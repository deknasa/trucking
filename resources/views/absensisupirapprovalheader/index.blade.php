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
              <li><a href="#pengeluaran-tab">Pengeluaran Kas/bank</a></li>
              <li><a href="#jurnal-tab">Jurnal</a></li>
            </ul>
            <div id="detail-tab">
              <table id="detail"></table>
            </div>
            <div id="pengeluaran-tab">
              <table id="pengeluaranGrid"></table>
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

@include('absensisupirapprovalheader._modal')
<!-- Detail -->
@include('absensisupirapprovalheader._detail')
@include('absensisupirapprovalheader._pengeluaran')
@include('absensisupirapprovalheader._jurnal')

@push('scripts')
<script>
  let indexUrl = "{{ route('absensisupirapprovalheader.index') }}"
  let getUrl = "{{ route('absensisupirapprovalheader.get') }}"
  let indexRow = 0;
  let page = 0;
  let pager = '#jqGridPager'
  let popup = "";
  let id = "";
  let triggerClick = true;
  let highlightSearch;
  let totalRecord
  let absensiTangki;
  let limit
  let postData
  let sortname = 'nobukti'
  let sortorder = 'asc'
  let autoNumericElements = []
  let currentTab = 'detail'
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
      url: `${apiUrl}absensisupirapprovalheader`,
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
        selectedRows = response.data.map((datas) => datas.id)
        selectedbukti = response.data.map((datas) => datas.nobukti)
        $('#jqGrid').trigger('reloadGrid')
      }
    })
  }

  reloadGrid()
  setSpaceBarCheckedHandler()
  $(document).ready(function() {
    $("#tabs").tabs()

    isAbsensiTangki()
    let nobukti = $('#jqGrid').jqGrid('getCell', id, 'pengeluaran_nobukti')
    loadDetailGrid()
    loadPengeluaranGrid(nobukti)
    loadJurnalUmumGrid(nobukti)

    $('#lookup').hide()
    setRange()
    initDatepicker('datepickerIndex')
    $(document).on('click', '#btnReload', function(event) {
      loadDataHeader('absensisupirapprovalheader')
      selectedRows = []
      selectedbukti = []
      $('#gs_').prop('checked', false)
    })
    $('.supir-lookup').lookup({
      title: 'supir Lookup',
      fileName: 'supir',
      onSelectRow: (supir, element) => {
        element.val(supir.namasupir)
        $(`#${element[0]['name']}Id`).val(supir.id)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      }
    })


    $('#crudModal').on('hidden.bs.modal', function() {
      activeGrid = '#jqGrid'
    })

    var grid = $("#jqGrid");
    grid.jqGrid({
        url: `${apiUrl}absensisupirapprovalheader`,
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
            hidden: true
          },
          {
            label: 'STATUS APPROVAL',
            name: 'statusapproval',
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
              let statusApproval = JSON.parse(rowObject.statusapproval)
              if (!statusApproval) {
                return ` title=""`
              }
              return ` title="${statusApproval.MEMO}"`
            }
          },
          {
            label: 'STATUS CETAK',
            name: 'statuscetak',
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
              let statusCetak = JSON.parse(rowObject.statuscetak)
              if (!statusCetak) {
                return ` title=" "`
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
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
            width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
            align: 'left'
          },

          {
            label: 'NO BUKTI Absensi Supir',
            name: 'absensisupir_nobukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
            formatter: (value, options, rowData) => {
              if ((value == null) || (value == '')) {
                return '';
              }
              let tgldari = rowData.tgldariheaderabsensisupirheader
              let tglsampai = rowData.tglsampaiheaderabsensisupirheader
              let url = "{{route('absensisupirheader.index')}}"
              let formattedValue = $(`<a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}&nobukti=${value}" class="link-color" target="_blank">${value}</a>`)
              return formattedValue[0].outerHTML
            },
          },
          {
            label: 'user approval',
            name: 'userapproval',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left'
          },
          {
            label: 'TGL approval',
            name: 'tglapproval',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_2,
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'NO BUKTI pengeluaran',
            width: 210,
            name: 'pengeluaran',
            width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
            align: 'left',
            formatter: (value, options, rowData) => {
              if ((value == null) || (value == '')) {
                return '';
              }
              return rowData.pengeluaran_url
            }
          },
          {
            label: 'NO BUKTI pengeluaran',
            width: 210,
            name: 'pengeluaran_nobukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
            formatter: (value, options, rowData) => {
              if ((value == null) || (value == '')) {
                return '';
              }
              let tgldari = rowData.tgldariheaderpengeluaranheader
              let tglsampai = rowData.tglsampaiheaderpengeluaranheader
              let url = "{{route('pengeluaranheader.index')}}"
              let formattedValue = $(`
              <a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}" class="link-color" target="_blank">${value}</a>
             `)
              return formattedValue[0].outerHTML
            },
          },
          {
            label: 'KODE PERKIRAAN KAS KELUAR',
            width: 230,
            name: 'coakaskeluar',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left'
          },
          {
            label: 'TGL kas keluar',
            name: 'tglkaskeluar',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_2,
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'USER BUKA CETAK',
            name: 'userbukacetak',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left'
          },
          {
            label: 'TGL BUKA CETAK',
            name: 'tglbukacetak',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_2,
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
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
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            align: 'right',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y H:i:s"
            }
          },
          {
            label: 'UPDATED AT',
            name: 'updated_at',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            align: 'right',
            formatter: "date",
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
        onSelectRow: onSelectRowFunction =function(id) {
          let nobukti = $(`#jqGrid tr#${id}`).find(`td[aria-describedby="jqGrid_pengeluaran_nobukti"]`).attr('title') ?? '';

          activeGrid = grid
          indexRow = grid.jqGrid('getCell', id, 'rn') - 1
          page = grid.jqGrid('getGridParam', 'page')
          let limit = grid.jqGrid('getGridParam', 'postData').limit
          if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))

          loadDetailData(id)
          let referen = nobukti
          if (absensiTangki) {
            referen = $(`#jqGrid tr#${id}`).find(`td[aria-describedby="jqGrid_nobukti"]`).attr('title') ?? '';
          }
          loadPengeluaranData(id,referen,absensiTangki)
          loadJurnalUmumData(id, referen,absensiTangki)
        },
        loadComplete: function(data) {
          changeJqGridRowListText()

          if (data.data.length === 0) {
            $('#detail, #pengeluaranGrid, #jurnalGrid').each((index, element) => {
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
            class: 'btn btn-info btn-sm mr-1 ',
            item: [{
                id: 'reportPrinterBesar',
                text: "Printer Lain(Faktur)",
                color: `<?php echo $data['listbtn']->btn->reportPrinterBesar; ?>`,
                // hidden :(!`{{ $myAuth->hasPermission('supir', 'approvalBlackListSupir') }}`),
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
                window.open(`{{ route('absensisupirapprovalheader.export') }}?id=${selectedId}`)
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
                text: "Approval Buka Cetak Absensi SUpir Approval",
                color: `<?php echo $data['listbtn']->btn->approvalbukacetak; ?>`,
                hidden :(!`{{ $myAuth->hasPermission('absensisupirapprovalheader', 'approvalbukacetak') }}`),
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('absensisupirapprovalheader', 'approvalbukacetak') }}`) {
                    let tglbukacetak = $('#tgldariheader').val().split('-');
                    tglbukacetak = tglbukacetak[1] + '-' + tglbukacetak[2];

                    approvalBukaCetak(tglbukacetak, 'ABSENSISUPIRAPPROVALHEADER', selectedRows, selectedbukti);

                  }
                }
              },
              {
                id: 'approval-kirim-berkas',
                text: "APPROVAL/UN Kirim Berkas Absensi Supir Approval",
                color: `<?php echo $data['listbtn']->btn->approvalkirimberkas; ?>`,
                hidden :(!`{{ $myAuth->hasPermission('absensisupirapprovalheader', 'approvalkirimberkas') }}`),
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('absensisupirapprovalheader', 'approvalkirimberkas') }}`) {
                    let tglkirimberkas = $('#tgldariheader').val().split('-');
                    tglkirimberkas = tglkirimberkas[1] + '-' + tglkirimberkas[2];

                    approvalKirimBerkas(tglkirimberkas, 'ABSENSISUPIRAPPROVALHEADER', selectedRows, selectedbukti);

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
          //       id: 'approval-buka-cetak',
          //       text: "Approval Buka Cetak Absensi",
          //       onClick: () => {
          //         if (`{{ $myAuth->hasPermission('absensisupirapprovalheader', 'approvalbukacetak') }}`) {
          //           let tglbukacetak = $('#tgldariheader').val().split('-');
          //           tglbukacetak = tglbukacetak[1] + '-' + tglbukacetak[2];
          //           selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
          //           if (selectedId == null || selectedId == '' || selectedId == undefined) {
          //             showDialog('Harap pilih salah satu record')
          //           } else {
          //             approvalBukaCetak(tglbukacetak, 'ABSENSISUPIRAPPROVALHEADER', selectedRows, selectedbukti);
          //           }
          //         }
          //       }
          //     },


          //   ],
          // },
        ],
        buttons: [{
            id: 'add',
            innerHTML: '<i class="fa fa-plus"></i> ADD',
            class: 'btn btn-primary btn-sm mr-1',
            onClick: function(event) {
              createAbsensiSupirApprovalHeader()
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
                viewAbsensiSupirApprovalHeader(selectedId)
              }
            }
          },
        ],
        // modalBtnList: []

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
      if (!`{{ $myAuth->hasPermission('absensisupirapprovalheader', 'store') }}`) {
        $('#add').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('absensisupirapprovalheader', 'update') }}`) {
        $('#edit').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('absensisupirapprovalheader', 'destroy') }}`) {
        $('#delete').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('absensisupirapprovalheader', 'export') }}`) {
        $('#export').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('absensisupirapprovalheader', 'report') }}`) {
        $('#report').attr('disabled', 'disabled')
      }
      let hakApporveCount = 0;
      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('absensisupirapprovalheader', 'approvalbukacetak') }}`) {
        hakApporveCount--
        $('#approval-buka-cetak').hide()
        // $('#approval-buka-cetak').attr('disabled', 'disabled')
      }
      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('absensisupirapprovalheader', 'approvalkirimberkas') }}`) {
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

      if ($('#rangeModal').data('action') == 'export') {
        actionUrl = `{{ route('absensisupirapprovalheader.export') }}`
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
        url: `${apiUrl}absensisupirapprovalheader/${id}/approval`,
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

    // $("#tabs").on('click', 'li.ui-state-active', function() {
    //   let href = $(this).find('a').attr('href');
    //   currentTab = href.substring(1, href.length - 4);
    //   let approvalId = $('#jqGrid').jqGrid('getGridParam', 'selrow')
    //   let nobukti = $('#jqGrid').jqGrid('getCell', approvalId, 'pengeluaran_nobukti')
    //   $(`#tabs #${currentTab}-tab`).html('').load(`${appUrl}/absensisupirapprovaldetail/${currentTab}/grid`, function() {

    //     loadGrid(approvalId, nobukti)
    //   })
    // })
  })
  const isAbsensiTangki = function() {
    return new Promise((resolve, reject) => {
      let data = [];
      data.push({
        name: 'grp',
        value: 'ABSENSI TANGKI'
      })
      data.push({
        name: 'subgrp',
        value: 'ABSENSI TANGKI'
      })
      $.ajax({
        url: `${apiUrl}parameter/getparamfirst`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: data,
        success: response => {
          if (response.text == "YA") {
            $("#jqGrid").jqGrid('showCol', 'pengeluaran');
            $("#jqGrid").jqGrid('hideCol', 'pengeluaran_nobukti')
            absensiTangki = true;
          }else{
            $("#jqGrid").jqGrid('showCol', 'pengeluaran_nobukti');
            $("#jqGrid").jqGrid('hideCol', 'pengeluaran')
            absensiTangki = false;
          }
        }
      })
    })
  }
  
</script>
@endpush()
@endsection