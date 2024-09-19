@extends('layouts.master')

@section('content')
<!-- Grid -->
<div class="container-fluid">
  {{-- {{ route('notadebetheader.report', ['id' => '1']) }} --}}
  <div class="row">
    <div class="col-12">
      @include('layouts._rangeheader')
      <table id="jqGrid"></table>
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-12">
      <div class="card card-primary card-outline card-outline-tabs">
        <div class="card-body border-bottom-0">
          <div id="tabs">
            <ul class="dejavu">
              <li><a href="#detail-tab">Details</a></li>
              <li><a href="#pelunasan-tab">Pelunasan piutang</a></li>
              <li><a href="#jurnal-tab">Jurnal</a></li>
            </ul>
            <div id="detail-tab">
              <table id="detail"></table>
            </div>
            <div id="pelunasan-tab">
              <table id="pelunasanGrid"></table>
            </div>
            <div id="jurnal-tab">
              <table id="jurnalGrid"></table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@include('notadebetheader._modal')
<!-- Detail -->
@include('notadebetheader._detail')
@include('pelunasanpiutangheader._pelunasan')
@include('jurnalumum._jurnal')


@push('scripts')
<script>
  let indexUrl = "{{ route('notadebetheader.index') }}"
  let getUrl = "{{ route('notadebetheader.get') }}"
  let indexRow = 0;
  let page = 0;
  let pager = '#jqGridPager'
  let popup = "";
  let id = "";
  let triggerClick = true;
  let highlightSearch;
  let totalRecord
  let limit
  let postData
  let sortname = 'nobukti'
  let sortorder = 'asc'
  let autoNumericElements = []
  let selectedRows = [];
  let currentTab = 'detail'
  let tgldariheader
  let tglsampaiheader

  let selectedbukti = [];

  function checkboxHandler(element) {
    let value = $(element).val();
    var onSelectRowExisting = $("#jqGrid").jqGrid('getGridParam', 'onSelectRow');
    $("#jqGrid").jqGrid('setSelection', value, false);
    onSelectRowExisting(value)

    let valuebukti = $(`#jqGrid tr#${value}`).find(`td[aria-describedby="jqGrid_nobukti"]`).attr('title');

    if (element.checked) {
      selectedRows.push($(element).val())
      selectedbukti.push(valuebukti)
      $(element).parents('tr').addClass('bg-light-blue')
    } else {
      $(element).parents('tr').removeClass('bg-light-blue')
      for (var i = 0; i < selectedRows.length; i++) {
        if (selectedRows[i] == value) {
          selectedRows.splice(i, 1);
        }
      }

      if (selectedRows.length != $('#jqGrid').jqGrid('getGridParam').records) {
        $('#gs_').prop('checked', false)
      }

      for (var i = 0; i < selectedbukti.length; i++) {
        if (selectedbukti[i] == valuebukti) {
          selectedbukti.splice(i, 1);
        }
      }
      if (selectedbukti.length != $('#jqGrid').jqGrid('getGridParam').records) {
        $('#gs_').prop('checked', false)
      }

    }

  }

  setSpaceBarCheckedHandler()
  reloadGrid()

  $(document).ready(function() {
    $("#tabs").tabs()

    let nobukti_pelunasan = $('#jqGrid').jqGrid('getCell', id, 'pelunasanpiutang_nobukti')
    let nobukti_jurnal = $('#jqGrid').jqGrid('getCell', id, 'nobukti')
    loadDetailGrid()
    loadPelunasanGrid(nobukti_pelunasan)
    loadJurnalUmumGrid(nobukti_jurnal)

    @isset($request['tgldari'])
    tgldariheader = `{{ $request['tgldari'] }}`;
    @endisset
    @isset($request['tglsampai'])
    tglsampaiheader = `{{ $request['tglsampai'] }}`;
    @endisset
    setRange(false, tgldariheader, tglsampaiheader)
    initDatepicker('datepickerIndex')
    $(document).on('click', '#btnReload', function(event) {
      loadDataHeader('notadebetheader')
      selectedRows = []
      selectedbukti = []
      $('#gs_').prop('checked', false)
    })


    var grid = $("#jqGrid");
    grid.jqGrid({
        url: `{{ config('app.api_url') . 'notadebetheader' }}`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        postData: {
          tgldari: $('#tgldariheader').val(),
          tglsampai: $('#tglsampaiheader').val()
        },
        datatype: "json",
        colModel: [{
            label: '',
            name: '',
            width: 40,
            align: 'center',
            sortable: false,
            clear: false,
            stype: 'input',
            searchable: false,
            searchoptions: {
              type: 'checkbox',
              clearSearch: false,
              dataInit: function(element) {
                $(element).removeClass('form-control')
                $(element).parent().addClass('text-center')
                $(element).addClass('checkbox-selectall')

                $(element).on('click', function() {
                  $(element).attr('disabled', true)
                  if ($(this).is(':checked')) {
                    selectAllRows()
                  } else {
                    clearSelectedRows()
                  }
                })

              }
            },
            formatter: (value, rowOptions, rowData) => {
              return `<input type="checkbox" name="hutangbayarId[]" class="checkbox-jqgrid" value="${rowData.id}" onchange="checkboxHandler(this)">`
            },
          },
          {
            label: 'ID',
            name: 'id',
            align: 'right',
            width: '50px',
            search: false,
            hidden: true
          },
          {
            label: 'status approval',
            name: 'statusapproval_memo',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
            stype: 'select',
            searchoptions: {

              value: `<?php
                      $i = 1;

                      foreach ($data['comboapproval'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['comboapproval'])) {
                          echo ";";
                        }
                        $i++;
                      endforeach

                      ?>
              `,
              dataInit: function(element) {
                $(element).select2({
                  width: 'resolve',
                  theme: "bootstrap4"
                });
              }
            },
            formatter: (value, options, rowData) => {
              let statusApproval = JSON.parse(value)
              if (!statusApproval) {
                return ''
              }
              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusApproval.WARNA}; color: #fff;">
                  <span>${statusApproval.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusApproval = JSON.parse(rowObject.statusapproval_memo)
              if (!statusApproval) {
                return ` title=""`
              }
              return ` title="${statusApproval.MEMO}"`
            }
          },
          {
            label: 'STATUS CETAK',
            name: 'statuscetak_memo',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
            stype: 'select',
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['combocetak'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['combocetak'])) {
                          echo ";";
                        }
                        $i++;
                      endforeach

                      ?>
              `,
              dataInit: function(element) {
                $(element).select2({
                  width: 'resolve',
                  theme: "bootstrap4"
                });
              }
            },
            formatter: (value, options, rowData) => {
              let statusCetak = JSON.parse(value)
              if (!statusCetak) {
                return ''
              }
              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusCetak.WARNA}; color: #fff;">
                  <span>${statusCetak.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusCetak = JSON.parse(rowObject.statuscetak_memo)
              if (!statusCetak) {
                return ` title=""`
              }
              return ` title="${statusCetak.MEMO}"`
            }
          },
          {
            label: 'NO BUKTI',
            name: 'nobukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left'
          },
          {
            label: 'TGL BUKTI',
            name: 'tglbukti',
            align: 'left',
            formatter: "date",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'tgl lunas',
            name: 'tgllunas',
            align: 'left',
            formatter: "date",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'CUSTOMER',
            name: 'agen',
            align: 'left',
          },
          {
            label: 'NO BUKTI PELUNASAN PIUTANG',
            width: 250,
            name: 'pelunasanpiutang_nobukti',
            align: 'left',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            formatter: (value, options, rowData) => {
              if ((value == null) || (value == '')) {
                return '';
              }
              let tgldari = rowData.tgldariheaderpelunasanpiutangheader
              let tglsampai = rowData.tglsampaiheaderpelunasanpiutangheader
              let url = "{{route('pelunasanpiutangheader.index')}}"
              let formattedValue = $(`
              <a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}" class="link-color" target="_blank">${value}</a>
             `)
              return formattedValue[0].outerHTML
            }
          },
          {
            label: 'BANK',
            name: 'bank',
            align: 'left',
          },
          {
            label: 'ALAT BAYAR',
            name: 'alatbayar',
            align: 'left',
          },
          {
            label: 'NO BUKTI PENERIMAAN',
            name: 'penerimaan_nobukti',
            align: 'left',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            formatter: (value, options, rowData) => {
              if ((value == null) || (value == '')) {
                return '';
              }
              let tgldari = rowData.tgldariheaderpenerimaanheader
              let tglsampai = rowData.tglsampaiheaderpenerimaanheader
              let url = "{{route('penerimaanheader.index')}}"
              let formattedValue = $(`
              <a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}" class="link-color" target="_blank">${value}</a>
             `)
              return formattedValue[0].outerHTML
            }
          },
          {
            label: 'user approval',
            name: 'userapproval',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left'
          },
          {
            label: 'TGL APPROVAL',
            name: 'tglapproval',
            align: 'left',
            formatter: "date",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'user buka cetak',
            name: 'userbukacetak',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left'
          },
          {
            label: 'TGL BUKA CETAK',
            name: 'tglbukacetak',
            align: 'left',
            formatter: "date",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'STATUS KIRIM BERKAS',
            name: 'statuskirimberkas',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
            stype: 'select',
            searchoptions: {

              value: `<?php
                      $i = 1;

                      foreach ($data['combokirimberkas'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['combokirimberkas'])) {
                          echo ";";
                        }
                        $i++;
                      endforeach

                      ?>
                                `,
              dataInit: function(element) {
                $(element).select2({
                  width: 'resolve',
                  theme: "bootstrap4"
                });
              }
            },
            formatter: (value, options, rowData) => {
              let statusKirimBerkas = JSON.parse(value)
              if (!statusKirimBerkas) {
                return ``
              }
              let formattedValue = $(`
                                <div class="badge" style="background-color: ${statusKirimBerkas.WARNA}; color: #fff;">
                                <span>${statusKirimBerkas.SINGKATAN}</span>
                                </div>
                            `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusKirimBerkas = JSON.parse(rowObject.statuskirimberkas)
              if (!statusKirimBerkas) {
                return ` title=""`
              }
              return ` title="${statusKirimBerkas.MEMO}"`
            }
          },
          {
            label: 'USER KIRIM BERKAS',
            name: 'userkirimberkas',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left'
          },
          {
            label: 'TGL KIRIM BERKAS',
            name: 'tglkirimberkas',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y H:i:s"
            }
          },
          {
            label: 'posting dari',
            name: 'postingdari',
            width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
            align: 'left'
          },
          {
            label: 'MODIFIED BY',
            name: 'modifiedby',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left'
          },
          {
            label: 'CREATED AT',
            name: 'created_at',
            align: 'right',
            formatter: "date",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y H:i:s"
            }
          },
          {
            label: 'UPDATED AT',
            name: 'updated_at',
            align: 'right',
            formatter: "date",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y H:i:s"
            }
          },
        ],

        autowidth: true,
        shrinkToFit: false,
        height: 350,
        rowNum: 10,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [10, 20, 50, 0],
        toolbar: [true, "top"],
        sortable: true,
        sortname: sortname,
        sortorder: sortorder,
        page: page,
        viewrecords: true,
        prmNames: {
          sort: 'sortIndex',
          order: 'sortOrder',
          rows: 'limit'
        },
        jsonReader: {
          root: 'data',
          total: 'attributes.totalPages',
          records: 'attributes.totalRows',
        },
        loadBeforeSend: function(jqXHR) {
          jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)

          setGridLastRequest($(this), jqXHR)
        },
        onSelectRow: onSelectRowFunction = function(id) {
          // let nobukti_pelunasan = $('#jqGrid').jqGrid('getCell', id, 'pelunasanpiutang_nobukti')
          // let nobukti_jurnal = $('#jqGrid').jqGrid('getCell', id, 'nobukti')
          // let nobukti_penerimaan = $('#jqGrid').jqGrid('getCell', id, 'penerimaan_nobukti')

          let nobukti_pelunasan = $(`#jqGrid tr#${id}`).find(`td[aria-describedby="jqGrid_pelunasanpiutang_nobukti"]`).attr('title') ?? '';
          let nobukti_jurnal = $(`#jqGrid tr#${id}`).find(`td[aria-describedby="jqGrid_nobukti"]`).attr('title')
          let nobukti_penerimaan = $(`#jqGrid tr#${id}`).find(`td[aria-describedby="jqGrid_penerimaan_nobukti"]`).attr('title') ?? '';

          activeGrid = grid
          indexRow = grid.jqGrid('getCell', id, 'rn') - 1
          page = grid.jqGrid('getGridParam', 'page')
          let limit = grid.jqGrid('getGridParam', 'postData').limit
          if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))
          console.log(nobukti_pelunasan)
          console.log(nobukti_penerimaan)
          loadDetailData(id)
          loadPelunasanData(id, nobukti_pelunasan)
          if (nobukti_penerimaan == '') {
            loadJurnalUmumData(id, nobukti_jurnal)
          } else {
            loadJurnalUmumData(id, nobukti_penerimaan)
          }
        },
        loadComplete: function(data) {
          changeJqGridRowListText()

          if (data.data.length === 0) {
            $('#detail, #jurnalGrid, #pelunasanGrid').each((index, element) => {
              abortGridLastRequest($(element))
              clearGridData($(element))
            })
            $('#jqGrid').each((index, element) => {
              abortGridLastRequest($(element))
              clearGridHeader($(element))
            })
          }

          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))

          $.each(selectedRows, function(key, value) {

            $('#jqGrid tbody tr').each(function(row, tr) {
              if ($(this).find(`td input:checkbox`).val() == value) {
                $(this).find(`td input:checkbox`).prop('checked', true)
                $(this).addClass('bg-light-blue')
              }
            })

          });

          /* Set global variables */
          sortname = $(this).jqGrid("getGridParam", "sortname")
          sortorder = $(this).jqGrid("getGridParam", "sortorder")
          totalRecord = $(this).getGridParam("records")
          limit = $(this).jqGrid('getGridParam', 'postData').limit
          postData = $(this).jqGrid('getGridParam', 'postData')
          triggerClick = true

          $('.clearsearchclass').click(function() {
            clearColumnSearch($(this))
          })

          if (indexRow > $(this).getDataIDs().length - 1) {
            indexRow = $(this).getDataIDs().length - 1;
          }

          setTimeout(function() {

            if (triggerClick) {
              if (id != '') {
                indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
                $(`#jqGrid [id="${$('#jqGrid').getDataIDs()[indexRow]}"]`).click()
                id = ''
              } else if (indexRow != undefined) {
                $(`#jqGrid [id="${$('#jqGrid').getDataIDs()[indexRow]}"]`).click()
              }

              if ($('#jqGrid').getDataIDs()[indexRow] == undefined) {
                $(`#jqGrid [id="` + $('#jqGrid').getDataIDs()[0] + `"]`).click()
              }

              triggerClick = false
            } else {
              $('#jqGrid').setSelection($('#jqGrid').getDataIDs()[indexRow])
            }
          }, 100)

          $('#left-nav').find('button').attr('disabled', false)
          permission()
          $('#gs_').attr('disabled', false)
          setHighlight($(this))
          getQueryParameter()
        }
      })

      .jqGrid("setLabel", "rn", "No.")
      .jqGrid('filterToolbar', {
        stringResult: true,
        searchOnEnter: false,
        defaultSearch: 'cn',
        groupOp: 'AND',
        disabledKeys: [17, 33, 34, 35, 36, 37, 38, 39, 40],
        beforeSearch: function() {
          abortGridLastRequest($(this))
          $('#left-nav').find(`button:not(#add)`).attr('disabled', 'disabled')
          clearGlobalSearch($('#jqGrid'))
        },
      })

      .customPager({

        modalBtnList: [{
            id: 'report',
            title: 'Report',
            caption: 'Report',
            innerHTML: '<i class="fa fa-print"></i> REPORT',
            class: 'btn btn-info btn-sm mr-1',
            item: [{
                id: 'reportPrinterBesar',
                text: "Printer Lain(Faktur)",
                color: `<?php echo $data['listbtn']->btn->reportPrinterBesar; ?>`,
                onClick: () => {
                  selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                  if (selectedId == null || selectedId == '' || selectedId == undefined) {
                    showDialog('Harap pilih salah satu record')
                  } else {

                    cekValidasi(selectedId, 'PRINTER BESAR')
                  }
                }
              },
              {
                id: 'reportPrinterKecil',
                text: "Printer Epson Seri LX(Faktur)",
                color: `<?php echo $data['listbtn']->btn->reportPrinterKecil; ?>`,
                onClick: () => {
                  selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                  if (selectedId == null || selectedId == '' || selectedId == undefined) {
                    showDialog('Harap pilih salah satu record')
                  } else {
                    cekValidasi(selectedId, 'PRINTER KECIL')
                  }
                }
              },

            ],
          },
          {
            id: 'export',
            title: 'Export',
            caption: 'Export',
            innerHTML: '<i class="fas fa-file-export"></i> EXPORT',
            class: 'btn btn-warning btn-sm mr-1',
            onClick: () => {

              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Harap pilih salah satu record')
              } else {
                // window.open(`{{ route('notadebetheader.export') }}?id=${selectedId}`)
                $.ajax({
                  url: `${apiUrl}notadebetheader/${selectedId}/export`,
                  type: 'GET',
                  data: {
                    notadebet_id: selectedId,
                    export : true
                  },
                  beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`);
                  },
                  xhrFields: {
                    responseType: 'arraybuffer'
                  },
                  success: function(response, status, xhr) {
                    if (xhr.status === 200) {
                      if (response !== undefined) {
                        var blob = new Blob([response], {
                          type: 'cabang/vnd.ms-excel'
                        });
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = 'LAPORAN NOTA DEBET' + new Date().getTime() + '.xlsx';
                        link.click();
                      }
                    }
                    $('#processingLoader').addClass('d-none')
                  },
                  error: function(xhr, status, error) {
                    $('#processingLoader').addClass('d-none')
                    showDialog('TIDAK ADA DATA')
                  }
                })
              }
            }
          },
          {
            id: 'approve',
            title: 'Approve',
            caption: 'Approve',
            innerHTML: '<i class="fa fa-check"></i> APPROVAL/UN',
            class: 'btn btn-purple btn-sm mr-1 ',
            item: [{
                id: 'approveun',
                text: "APPROVAL/UN Status NOTA DEBET",
                color: 'btn-success',
                hidden: (!`{{ $myAuth->hasPermission('notadebetheader', 'approval') }}`),
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('notadebetheader', 'approval') }}`) {
                    approve()
                  }
                }
              },
              {
                id: 'approval-buka-cetak',
                text: "Approval Buka Cetak NOTA DEBET",
                color: 'btn-info',
                hidden: (!`{{ $myAuth->hasPermission('notadebetheader', 'approvalbukacetak') }}`),
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('notadebetheader', 'approvalbukacetak') }}`) {
                    let tglbukacetak = $('#tgldariheader').val().split('-');
                    tglbukacetak = tglbukacetak[1] + '-' + tglbukacetak[2];

                    approvalBukaCetak(tglbukacetak, 'NOTADEBETHEADER', selectedRows, selectedbukti);

                  }
                }
              },
              {
                id: 'approval-kirim-berkas',
                text: "APPROVAL/UN Kirim Berkas NOTA DEBET",
                color: 'btn-primary',
                hidden: (!`{{ $myAuth->hasPermission('notadebetheader', 'approvalkirimberkas') }}`),
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('notadebetheader', 'approvalkirimberkas') }}`) {
                    let tglkirimberkas = $('#tgldariheader').val().split('-');
                    tglkirimberkas = tglkirimberkas[1] + '-' + tglkirimberkas[2];

                    approvalKirimBerkas(tglkirimberkas, 'NOTADEBETHEADER', selectedRows, selectedbukti);

                  }
                }
              },
            ],
          }
        ],
        buttons: [{
            id: 'add',
            innerHTML: '<i class="fa fa-plus"></i> ADD',
            class: 'btn btn-primary btn-sm mr-1',
            onClick: function(event) {
              createNotaDebet()
            }
          },
          {
            id: 'edit',
            innerHTML: '<i class="fa fa-pen"></i> EDIT',
            class: 'btn btn-success btn-sm mr-1',
            onClick: function(event) {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Harap pilih salah satu record')
              } else {
                cekValidasi(selectedId, 'EDIT')
              }
            }
          },
          {
            id: 'delete',
            innerHTML: '<i class="fa fa-trash"></i> DELETE',
            class: 'btn btn-danger btn-sm mr-1',
            onClick: () => {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Harap pilih salah satu record')
              } else {

                cekValidasi(selectedId, 'DELETE')
              }
            }
          },
          {
            id: 'view',
            innerHTML: '<i class="fa fa-eye"></i> VIEW',
            class: 'btn btn-orange btn-sm mr-1',
            onClick: () => {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Harap pilih salah satu record')
              } else {
                viewNotaDebetHeader(selectedId)
              }
            }
          },
        ],
      })

    /* Append clear filter button */
    loadClearFilter($('#jqGrid'))

    /* Append global search */
    loadGlobalSearch($('#jqGrid'))


    $('#add .ui-pg-div')
      .addClass(`btn btn-sm btn-primary`)
      .parent().addClass('px-1')

    $('#edit .ui-pg-div')
      .addClass('btn btn-sm btn-success')
      .parent().addClass('px-1')

    $('#delete .ui-pg-div')
      .addClass('btn btn-sm btn-danger')
      .parent().addClass('px-1')

    $('#report .ui-pg-div')
      .addClass('btn btn-sm btn-info')
      .parent().addClass('px-1')

    $('#export .ui-pg-div')
      .addClass('btn btn-sm btn-warning')
      .parent().addClass('px-1')

    function permission() {
      if (!`{{ $myAuth->hasPermission('notadebetheader', 'store') }}`) {
        $('#add').addClass('ui-disabled')
      }

      if (!`{{ $myAuth->hasPermission('notadebetheader', 'update') }}`) {
        $('#edit').addClass('ui-disabled')
      }

      if (!`{{ $myAuth->hasPermission('notadebetheader', 'destroy') }}`) {
        $('#delete').addClass('ui-disabled')
      }

      if (!`{{ $myAuth->hasPermission('notadebetheader', 'export') }}`) {
        $('#export').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('notadebetheader', 'report') }}`) {
        $('#report').attr('disabled', 'disabled')
      }
      let hakApporveCount = 0;
      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('notadebetheader', 'approval') }}`) {
        hakApporveCount--
        $('#approveun').hide()
        // $('#approval-buka-cetak').attr('disabled', 'disabled')
      }
      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('notadebetheader', 'approvalbukacetak') }}`) {
        hakApporveCount--
        $('#approval-buka-cetak').hide()
        // $('#approval-buka-cetak').attr('disabled', 'disabled')
      }
      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('notadebetheader', 'approvalkirimberkas') }}`) {
        hakApporveCount--
        $('#approval-kirim-berkas').hide()
        // $('#approval-buka-cetak').attr('disabled', 'disabled')
      }
      if (hakApporveCount < 1) {
        // $('#approve').hide()
        $('#approve').attr('disabled', 'disabled')
      }
    }

    $('#rangeModal').on('shown.bs.modal', function() {
      if (autoNumericElements.length > 0) {
        $.each(autoNumericElements, (index, autoNumericElement) => {
          autoNumericElement.remove()
        })
      }

      $('#formRange [name]:not(:hidden)').first().focus()

      $('#formRange [name=sidx]').val($('#jqGrid').jqGrid('getGridParam').postData.sidx)
      $('#formRange [name=sord]').val($('#jqGrid').jqGrid('getGridParam').postData.sord)
      $('#formRange [name=dari]').val((indexRow + 1) + (limit * (page - 1)))
      $('#formRange [name=sampai]').val(totalRecord)

      autoNumericElements = new AutoNumeric.multiple('#formRange .autonumeric-report', {
        digitGroupSeparator: ',',
        decimalCharacter: '.',
        decimalPlaces: 0,
        allowDecimalPadding: false,
        minimumValue: 1,
        maximumValue: totalRecord
      })
    })

    $('#formRange').submit(event => {
      event.preventDefault()

      let params
      let actionUrl = ``
      if ($('#rangeModal').data('action') == 'export') {
        actionUrl = `{{ route('notadebetheader.export') }}`
      }

      /* Clear validation messages */
      $('.is-invalid').removeClass('is-invalid')
      $('.invalid-feedback').remove()

      /* Set params value */
      for (var key in postData) {
        if (params != "") {
          params += "&";
        }
        params += key + "=" + encodeURIComponent(postData[key]);
      }

      window.open(`${actionUrl}?${$('#formRange').serialize()}&${params}`)
    })

    function handleApproval(id) {
      $.ajax({
        url: `${apiUrl}notadebetheader/${id}/approval`,
        method: 'POST',
        dataType: 'JSON',
        beforeSend: request => {
          request.setRequestHeader('Authorization', `Bearer ${accessToken}`)
        },
        success: response => {
          $('#jqGrid').trigger('reloadGrid')
        }
      }).always(() => {
        $('#processingLoader').addClass('d-none')
      })
    }

    function reportNotaDebet(id) {
      $.ajax({
        url: `{{url('notadebetheader/report/${id}')}}`,
        method: 'get',
        dataType: 'JSON',
        beforeSend: request => {
          request.setRequestHeader('Authorization', `Bearer ${accessToken}`)
        },
        success: response => {
          $('#jqGrid').trigger('reloadGrid')
        }
      }).always(() => {
        $('#processingLoader').addClass('d-none')
      })
    }

    // $("#tabs").on('click', 'li.ui-state-active', function() {
    //   let href = $(this).find('a').attr('href');
    //   currentTab = href.substring(1, href.length - 4);
    //   let notaId = $('#jqGrid').jqGrid('getGridParam', 'selrow')
    //   let nobukti_pelunasan = $('#jqGrid').jqGrid('getCell', notaId, 'pelunasanpiutang_nobukti')
    //   let nobukti_penerimaan = $('#jqGrid').jqGrid('getCell', notaId, 'penerimaan_nobukti')
    //   $(`#tabs #${currentTab}-tab`).html('').load(`${appUrl}/notadebetdetail/${currentTab}/grid`, function() {
    //     if (currentTab == 'detail' || currentTab == 'pelunasan') {
    //       loadGrid(notaId, nobukti_pelunasan)
    //     } else {
    //       loadGrid(notaId, nobukti_penerimaan)
    //     }
    //   })
    // })

  })


  function clearSelectedRows() {
    selectedRows = []
    selectedbukti = []
    $('#gs_').prop('checked', false);
    $('#jqGrid').trigger('reloadGrid')
  }

  function selectAllRows() {
    $.ajax({
      url: `${apiUrl}notadebetheader`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        limit: 0,
        tgldari: $('#tgldariheader').val(),
        tglsampai: $('#tglsampaiheader').val(),
        filters: $('#jqGrid').jqGrid('getGridParam', 'postData').filters
      },
      success: (response) => {
        selectedRows = response.data.map((row) => row.id)
        selectedbukti = response.data.map((hutang) => hutang.nobukti)
        $('#jqGrid').trigger('reloadGrid')
      }
    })
  }
</script>
@endpush()
@endsection