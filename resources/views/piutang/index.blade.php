@extends('layouts.master')

@section('content')
<!-- Grid -->
<div class="container-fluid">
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
              <li><a href="#history-tab">History pelunasan</a></li>
              <li><a href="#jurnal-tab">Jurnal</a></li>
            </ul>
            <div id="detail-tab">
              <table id="detailGrid"></table>
            </div>
            <div id="history-tab">
              <table id="historyGrid"></table>
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

<!-- Detail -->
@include('piutang._modal')
@include('piutang._details')
@include('piutang._history')
@include('jurnalumum._jurnal')

@push('scripts')
<script>
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
  let rowNum = 10
  let hasDetail = false
  let currentTab = 'detail'
  let tgldariheader
  let tglsampaiheader

  let selectedRows = [];
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

  function clearSelectedRows() {
    selectedRows = []
    selectedbukti = []
    $('#gs_').prop('checked', false);
    $('#jqGrid').trigger('reloadGrid')
  }

  function selectAllRows() {
    $.ajax({
      url: `${apiUrl}piutangheader`,
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
        selectedRows = response.data.map((supir) => supir.id)
        selectedbukti = response.data.map((supir) => supir.nobukti)
        $('#jqGrid').trigger('reloadGrid')
      }
    })
  }

  reloadGrid()
  setSpaceBarCheckedHandler()

  $(document).ready(function() {
    $("#tabs").tabs()

    let nobukti = $('#jqGrid').jqGrid('getCell', id, 'nobukti')
    loadDetailGrid()
    loadHistoryGrid(nobukti)
    loadJurnalUmumGrid(nobukti)
    syncHeaderScroll('historyGrid');

    @isset($request['tgldari'])
    tgldariheader = `{{ $request['tgldari'] }}`;
    @endisset
    @isset($request['tglsampai'])
    tglsampaiheader = `{{ $request['tglsampai'] }}`;
    @endisset
    setRange(false, tgldariheader, tglsampaiheader)
    initDatepicker('datepickerIndex')
    $(document).on('click', '#btnReload', function(event) {
      loadDataHeader('piutangheader')
      selectedRows = []
      selectedbukti = []
      $('#gs_').prop('checked', false)
    })

    var grid = $("#jqGrid");
    grid.jqGrid({
        url: `${apiUrl}piutangheader`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        postData: {
          tgldari: $('#tgldariheader').val(),
          tglsampai: $('#tglsampaiheader').val()
        },
        datatype: "json",
        isLoading: true,
        colModel: [{
            label: '',
            name: '',
            width: 30,
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
              return `<input type="checkbox" name="Id[]" value="${rowData.id}" onchange="checkboxHandler(this)">`
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
            label: 'STATUS CETAK',
            name: 'statuscetak',
            align: 'left',
            stype: 'select',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['statuscetak'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['statuscetak'])) {
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
              let statusCetak = JSON.parse(rowObject.statuscetak)
              if (!statusCetak) {
                return ''
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
            label: 'CUSTOMER',
            name: 'agen_id',
            align: 'left',
            search: (accessCabang != 'BITUNG-EMKL') ? true : false,
            hidden: (accessCabang != 'BITUNG-EMKL') ? false : true
          },
          {
            label: 'SHIPPER',
            name: 'pelanggan_id',
            align: 'left',
            width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
            search: (accessCabang == 'BITUNG-EMKL') ? true : false,
            hidden: (accessCabang == 'BITUNG-EMKL') ? false : true
          },
          {
            label: 'POSTING DARI',
            name: 'postingdari',
            width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
            align: 'left'
          },
          {
            label: 'NOMINAL',
            name: 'nominal',
            align: 'right',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            formatter: currencyFormat,
          },
          {
            label: 'NOMINAL PELUNASAN',
            name: 'nominalpelunasan',
            align: 'right',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            formatter: currencyFormat,
          },
          {
            label: 'SISA PIUTANG',
            name: 'sisapiutang',
            align: 'right',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            formatter: currencyFormat,
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
            width: (detectDeviceType() == "desktop") ? lg_dekstop_2 : lg_mobile_2,
            align: 'left'
          },
          {
            label: 'NO BUKTI INVOICE',
            name: 'invoice_nobukti',
            align: 'left',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            formatter: (value, options, rowData) => {

              let tgldari
              let tglsampai
              let url
              if ((value == null) || (value == '')) {
                return '';
              }
              if (rowData.tgldariheaderinvoiceheader) {
                tgldari = rowData.tgldariheaderinvoiceheader
                tglsampai = rowData.tglsampaiheaderinvoiceheader
                url = "{{route('invoiceheader.index')}}"
              } else if (rowData.tgldariheaderinvoiceextraheader) {
                tgldari = rowData.tgldariheaderinvoiceextraheader
                tglsampai = rowData.tglsampaiheaderinvoiceextraheader
                url = "{{route('invoiceextraheader.index')}}"
              }
              let formattedValue
              if (url) {
                formattedValue = $(`<a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}" class="link-color" target="_blank">${value}</a>`)
              } else {
                formattedValue = $(`<span>${value}</span>`)
              }

              if (!`{{ $myAuth->hasPermission('invoiceheader', 'index') }}`) {
                formattedValue.prop('href', '#')
                formattedValue.prop('target', '')
              }
              return formattedValue[0].outerHTML
            },
          },
          {
            label: 'TGL JATUH TEMPO',
            name: 'tgljatuhtempo',
            align: 'left',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'NAMA PERKIRAAN (DEBET)',
            name: 'coadebet',
            align: 'left',
            width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
            width: 200
          },
          {
            label: 'NAMA PERKIRAAN (KREDIT)',
            name: 'coakredit',
            align: 'left',
            width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
            width: 200
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

          let nobukti = $(`#jqGrid tr#${id}`).find(`td[aria-describedby="jqGrid_nobukti"]`).attr('title') ?? '';
          activeGrid = grid
          indexRow = grid.jqGrid('getCell', id, 'rn') - 1
          page = grid.jqGrid('getGridParam', 'page')
          let limit = grid.jqGrid('getGridParam', 'postData').limit
          if (indexRow >= limit) {
            indexRow = (indexRow - limit * (page - 1))
          }
          loadDetailData(id)
          loadHistoryData(id)
          loadJurnalUmumData(id, nobukti)
        },
        loadComplete: function(data) {

          changeJqGridRowListText()
          if (data.data.length === 0) {
            $('#detailGrid, #historyGrid, #jurnalGrid').each((index, element) => {
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
          getQueryParameter()
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
        }
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
                // window.open(`{{ route('piutangheader.export') }}?id=${selectedId}`)
                $.ajax({
                  url: `${apiUrl}piutangheader/${selectedId}/export`,
                  type: 'GET',
                  data: {
                    piutang_id: selectedId,
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
                        link.download = 'LAPORAN PIUTANG' + new Date().getTime() + '.xlsx';
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
            class: 'btn btn-purple btn-sm mr-1',
            item: [
              // {
              //   id: 'approveun',
              //   text: "APPROVAL/UN Status penerimaan",
              //   onClick: () => {
              //     approve()
              //   }
              // },
              {
                id: 'approval-buka-cetak',
                text: "Approval Buka Cetak PIUTANGHEADER",
                color: 'btn-success',
                hidden: (!`{{ $myAuth->hasPermission('piutangheader', 'approvalbukacetak') }}`),
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('piutangheader', 'approvalbukacetak') }}`) {
                    let tglbukacetak = $('#tgldariheader').val().split('-');
                    tglbukacetak = tglbukacetak[1] + '-' + tglbukacetak[2];

                    approvalBukaCetak(tglbukacetak, 'PIUTANGHEADER', selectedRows, selectedbukti);

                  }
                }
              },
              {
                id: 'approval-kirim-berkas',
                text: "APPROVAL/UN Kirim Berkas PIUTANGHEADER",
                color: 'btn-info',
                hidden: (!`{{ $myAuth->hasPermission('piutangheader', 'approvalkirimberkas') }}`),
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('piutangheader', 'approvalkirimberkas') }}`) {
                    let tglkirimberkas = $('#tgldariheader').val().split('-');
                    tglkirimberkas = tglkirimberkas[1] + '-' + tglkirimberkas[2];

                    approvalKirimBerkas(tglkirimberkas, 'PIUTANGHEADER', selectedRows, selectedbukti);

                  }
                }
              },
            ],
          }
          // {
          //   id: 'approve',
          //   title: 'Approve',
          //   caption: 'Approve',
          //   innerHTML: '<i class="fa fa-check"></i> APPROVAL/UN',
          //   class: 'btn btn-purple btn-sm mr-1 dropdown-toggle ',
          //   dropmenuHTML: [{
          //     id: 'approval-buka-cetak',
          //     text: "APPROVAL/UN Buka Cetak Piutang",
          //     onClick: () => {
          //       if (`{{ $myAuth->hasPermission('piutangheader', 'approvalbukacetak') }}`) {
          //         let tglbukacetak = $('#tgldariheader').val().split('-');
          //         tglbukacetak = tglbukacetak[1] + '-' + tglbukacetak[2];
          //         selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
          //         if (selectedId == null || selectedId == '' || selectedId == undefined) {
          //           showDialog('Harap pilih salah satu record')
          //         } else {
          //           approvalBukaCetak(tglbukacetak, 'PIUTANGHEADER', selectedRows, selectedbukti);
          //         }
          //       }
          //     }
          //   }, ],
          // }
        ],
        buttons: [{
          id: 'view',
          innerHTML: '<i class="fa fa-eye"></i> VIEW',
          class: 'btn btn-orange btn-sm mr-1',
          onClick: () => {
            selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
            if (selectedId == null || selectedId == '' || selectedId == undefined) {
              showDialog('Harap pilih salah satu record')
            } else {
              viewPiutangHeader(selectedId)
            }
          }
        }, ],

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
      if (!`{{ $myAuth->hasPermission('piutangheader', 'store') }}`) {
        $('#add').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('piutangheader', 'show') }}`) {
        $('#view').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('piutangheader', 'update') }}`) {
        $('#edit').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('piutangheader', 'destroy') }}`) {
        $('#delete').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('piutangheader', 'export') }}`) {
        $('#export').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('piutangheader', 'report') }}`) {
        $('#report').attr('disabled', 'disabled')
      }
      let hakApporveCount = 0;
      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('piutangheader', 'approvalbukacetak') }}`) {
        hakApporveCount--
        $('#approval-buka-cetak').hide()
        // $('#approval-buka-cetak').attr('disabled', 'disabled')
      }
      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('piutangheader', 'approvalkirimberkas') }}`) {
        hakApporveCount--
        $('#approval-kirim-berkas').hide()
      }
      if (hakApporveCount < 1) {
        $('#approve').hide()
        // $('#approve').attr('disabled', 'disabled')
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

    $('#formRange').submit(function(event) {
      event.preventDefault()

      let params
      let submitButton = $(this).find('button:submit')

      submitButton.attr('disabled', 'disabled')

      /* Set params value */
      for (var key in postData) {
        if (params != "") {
          params += "&";
        }
        params += key + "=" + encodeURIComponent(postData[key]);
      }

      let formRange = $('#formRange')
      let offset = parseInt(formRange.find('[name=dari]').val()) - 1
      let limit = parseInt(formRange.find('[name=sampai]').val().replace('.', '')) - offset
      params += `&offset=${offset}&limit=${limit}`

      if ($('#rangeModal').data('action') == 'export') {
        let xhr = new XMLHttpRequest()
        xhr.open('GET', `{{ config('app.api_url') }}piutangheader/export?${params}`, true)
        xhr.setRequestHeader("Authorization", `Bearer {{ session('access_token') }}`)
        xhr.responseType = 'arraybuffer'

        xhr.onload = function(e) {
          if (this.status === 200) {
            if (this.response !== undefined) {
              let blob = new Blob([this.response], {
                type: "application/vnd.ms-excel"
              })
              let link = document.createElement('a')

              link.href = window.URL.createObjectURL(blob)
              link.download = `laporanpengeluarantrucking${(new Date).getTime()}.xlsx`
              link.click()

              submitButton.removeAttr('disabled')
            }
          }
        }

        xhr.send()
      } else if ($('#rangeModal').data('action') == 'report') {
        window.open(`{{ route('piutangheader.report') }}?${params}`)

        submitButton.removeAttr('disabled')
      }
    })
  })
  $(document).on('click', '.link-color', function() {
    if (!`{{ $myAuth->hasPermission('invoiceheader', 'index') }}`) {
      preventNewTab('invoice');
    }
  });
</script>
@endpush()
@endsection