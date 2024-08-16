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
              <li><a href="#rekap-tab">Rekap Absen Trado</a></li>
              <li class="kasgantung_nobukti"><a href="#kasgantung-tab">KAS GANTUNG</a></li>
              <li><a href="#tidaklengkap-tab">Data tidak lengkap</a></li>
            </ul>
            <div id="detail-tab">
              <table id="detail"></table>
            </div>
            <div id="rekap-tab">
              <table id="rekapAbsenTradoGrid"></table>
            </div>
            <div class="kasgantung_nobukti" id="kasgantung-tab">
              <table id="kasgantungGrid"></table>
            </div>
            <div id="tidaklengkap-tab">
              <table id="dataTidakLengkapGrid"></table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@include('absensisupir._modal')
@include('absensisupir._modalabsesntrado')
<!-- Detail -->
@include('absensisupir._detail')
@include('absensisupir._rekapabsentrado')
@include('absensisupir._kasgantung')
@include('absensisupir._tidaklengkap')

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
  var statusTidakBisaEdit;
  let approveEditRequest = null;
  let showKasgantung = true;
  let absensiTangki;
  let tgldariheader
  let tglsampaiheader
  let activeKolomJenisKendaraan
  let isTradoMilikSupir = ''
  let selectedRows = [];
  let selectedbukti = [];

  function checkboxHandler(element) {
    let value = $(element).val();
    // perubahan
    var onSelectRowExisting = $("#jqGrid").jqGrid('getGridParam', 'onSelectRow'); 
    $("#jqGrid").jqGrid('setSelection', value,false);
    onSelectRowExisting(value)
    // 

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
      url: `${apiUrl}absensisupirheader`,
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
        selectedbukti =response.data.map((datas) => datas.nobukti)
        $('#jqGrid').trigger('reloadGrid')
      }
    })
  }

  reloadGrid()
  setSpaceBarCheckedHandler()
  $(document).ready(function() {

    $("#tabs").tabs()
    setTampilanIndex()
    isAbsensiTangki()
    loadDetailGrid()
    loadDataTidakLengkapGrid()
    loadRekapAbsenTradoGrid()
    loadKasGantungGrid()
    setTradoMilikSupir()
    GetActiveKolomJenisKendaraan()
    @isset($request['tgldari'])
    tgldariheader = `{{ $request['tgldari'] }}`;
    @endisset
    @isset($request['tglsampai'])
    tglsampaiheader = `{{ $request['tglsampai'] }}`;
    @endisset
    setRange(false, tgldariheader, tglsampaiheader)
    initDatepicker('datepickerIndex')
    $(document).on('click', '#btnReload', function(event) {
      loadDataHeader('absensisupirheader')
      selectedRows = []
      selectedbukti = []
      $('#gs_').prop('checked', false)
    })
    // perubahan
    var grid= $("#jqGrid");  
    grid.jqGrid({
      // 
        url: `${apiUrl}absensisupirheader`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        postData: {
          tgldari: $('#tgldariheader').val(),
          tglsampai: $('#tglsampaiheader').val()
        },
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
          }, {
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
            align: 'left',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'TGL BUKTI',
            name: 'tglbukti',
            align: 'left',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            formatter: 'date',
            formatoptions: {
              newformat: 'd-m-Y'
            }
          },
          {
            label: 'NO BUKTI KGT',
            name: 'kasgantung',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
            formatter: (value, options, rowData) => {
              if ((value == null) || (value == '')) {
                return '';
              }
              return rowData.kasgantung_url
            }
          },
          {
            label: 'NO BUKTI KGT',
            name: 'kasgantung_nobukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
            formatter: (value, options, rowData) => {
              if ((value == null) || (value == '')) {
                return '';
              }
              let tgldari = rowData.tgldariheaderkasgantungheader
              let tglsampai = rowData.tglsampaiheaderkasgantungheader
              let url = "{{route('kasgantungheader.index')}}"
              let formattedValue = $(`<a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}" class="link-color" target="_blank">${value}</a>`)
              return formattedValue[0].outerHTML
            },
          },
          {
            label: 'NOMINAL',
            name: 'nominal',
            align: 'right',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            formatter: currencyFormat
          },
          {
            label: 'STATUS FINAL ABSENSI',
            name: 'statusapprovalfinalabsensi',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
            stype: 'select',
            searchoptions: {

              value: `<?php
                      $i = 1;

                      foreach ($data['combofinalabsensi'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['combofinalabsensi'])) {
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
              let statusFinalAbsensi = JSON.parse(value)
              if (!statusFinalAbsensi) {
                return ''
              }
              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusFinalAbsensi.WARNA}; color: #fff;">
                  <span>${statusFinalAbsensi.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusFinalAbsensi = JSON.parse(rowObject.statusapprovalfinalabsensi)
              if (!statusFinalAbsensi) {
                return ` title=" "`
              }
              return ` title="${statusFinalAbsensi.MEMO}"`
            }
          },
          {
            label: 'USER FINAL ABSENSI',
            name: 'userapprovalfinalabsensi',
            align: 'left',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'TGL FINAL ABSENSI',
            name: 'tglapprovalfinalabsensi',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y H:i:s"
            }
          },          
          {
            label: 'USER BUKA CETAK',
            name: 'userbukacetak',
            align: 'left',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
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
            label: 'STATUS APP EDIT',
            name: 'statusapprovaleditabsensi',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
            stype: 'select',
            searchoptions: {

              value: `<?php
                      $i = 1;

                      foreach ($data['comboedit'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['comboedit'])) {
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
              let statusAppEdit = JSON.parse(value)
              if (!statusAppEdit) {
                return ''
              }
              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusAppEdit.WARNA}; color: #fff;">
                  <span>${statusAppEdit.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusAppEdit = JSON.parse(rowObject.statusapprovaleditabsensi)
              if (!statusAppEdit) {
                return ` title=" "`
              }
              return ` title="${statusAppEdit.MEMO}"`
            }
          },
          {
            label: 'USER APP EDIT',
            name: 'userapprovaleditabsensi',
            align: 'left',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'TGL APP EDIT',
            name: 'tglapprovaleditabsensi',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_2,
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'STATUS APP pengajuan trip inap',
            name: 'statusapprovalpengajuantripinap',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
            stype: 'select',
            searchoptions: {

              value: `<?php
                      $i = 1;

                      foreach ($data['comboedit'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['comboedit'])) {
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
              let statusAppEdit = JSON.parse(value)
              if (!statusAppEdit) {
                return ''
              }
              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusAppEdit.WARNA}; color: #fff;">
                  <span>${statusAppEdit.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusAppEdit = JSON.parse(rowObject.statusapprovalpengajuantripinap)
              if (!statusAppEdit) {
                return ` title=" "`
              }
              return ` title="${statusAppEdit.MEMO}"`
            }
          },
          {
            label: 'USER APP pengajuan trip inap',
            name: 'userapprovalpengajuantripinap',
            align: 'left',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
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
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y H:i:s"
            }
          },
          {
            label: 'UPDATED AT',
            name: 'updated_at',
            align: 'right',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
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
        // perubahan
        onSelectRow: onSelectRowFunction =function(id) {
          let nobukti = $(`#jqGrid tr#${id}`).find(`td[aria-describedby="jqGrid_kasgantung_nobukti"]`).attr('title') ?? '';

          activeGrid = grid
          indexRow = grid.jqGrid('getCell', id, 'rn') - 1
          page = grid.jqGrid('getGridParam', 'page')
          let limit = grid.jqGrid('getGridParam', 'postData').limit
          // 
          if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))

          loadDetailData(id)
          loadDataTidakLengkap(id)
          loadRekapAbsenTradoData(id)
          if (showKasgantung) {
            let referen = nobukti
            if (absensiTangki) {
              referen = $(`#jqGrid tr#${id}`).find(`td[aria-describedby="jqGrid_nobukti"]`).attr('title') ?? '';
            }
            loadKasGantungData(referen,absensiTangki)
          }
        },
        loadComplete: function(data) {
          changeJqGridRowListText()

          if (data.data.length === 0) {
            $('#detail, #kasGantungGrid').each((index, element) => {
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
          getQueryParameter()
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
                window.open(`{{ route('absensisupirheader.export') }}?id=${selectedId}`)
              }
            }
          },
          {
            id: 'approve',
            title: 'Approve',
            caption: 'Approve',
            innerHTML: '<i class="fa fa-check"></i> APPROVAL/UN',
            class: 'btn btn-purple btn-sm mr-1',
            item: [{
                id: 'approvalEdit',
                text: "APPROVAL/UN Absensi Edit",
                color: `<?php echo $data['listbtn']->btn->approvaledit; ?>`,
                hidden :(!`{{ $myAuth->hasPermission('absensisupirheader', 'approvalEditAbsensi') }}`),
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('absensisupirheader', 'approvalEditAbsensi') }}`) {
                    // var selectedOne = selectedOnlyOne();
                    // if (selectedOne[0]) {
                    //   approveEdit(selectedOne[1])
                    // } else {
                    //   showDialog(selectedOne[1])
                    // }
                    selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                    if (selectedRows.length < 1) {
                      showDialog('Harap pilih salah satu record')
                    } else {
                      approveEdit()
                    }
                  }
                }
              },
              {
                id: 'approvalTripInap',
                text: "APPROVAL/UN Pengajuan Trip Inap",
                color: `<?php echo $data['listbtn']->btn->approvalpengajuantripinap; ?>`,
                hidden :(!`{{ $myAuth->hasPermission('absensisupirheader', 'approvalTripInap') }}`),
                onClick: () => {
                  // if (`{{ $myAuth->hasPermission('absensisupirheader', 'approvalTripInap') }}`) {
                  // var selectedOne = selectedOnlyOne();                            
                  // if (selectedOne[0]) {
                  approveTripInap(selectedRows)
                  // } else {
                  //     showDialog(selectedOne[1])
                  // }
                  // }
                }
              },
              {
                id: 'approval-buka-cetak',
                text: "Approval Buka Cetak Absensi",
                color: `<?php echo $data['listbtn']->btn->approvalbukacetak; ?>`,
                hidden :(!`{{ $myAuth->hasPermission('absensisupirheader', 'approvalbukacetak') }}`),
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('absensisupirheader', 'approvalbukacetak') }}`) {
                    let tglbukacetak = $('#tgldariheader').val().split('-');
                    tglbukacetak = tglbukacetak[1] + '-' + tglbukacetak[2];
                    selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                    if (selectedId == null || selectedId == '' || selectedId == undefined) {
                      showDialog('Harap pilih salah satu record')
                    } else {
                      approvalBukaCetak(tglbukacetak, 'ABSENSISUPIRHEADER', selectedRows, selectedbukti);
                    }
                  }
                }
              },
              {
                id: 'approval-kirim-berkas',
                text: "APPROVAL/UN Kirim Berkas Absensi",
                color: `<?php echo $data['listbtn']->btn->approvalkirimberkas; ?>`,
                hidden :(!`{{ $myAuth->hasPermission('absensisupirheader', 'approvalkirimberkas') }}`),
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('absensisupirheader', 'approvalkirimberkas') }}`) {
                    let tglkirimberkas = $('#tgldariheader').val().split('-');
                    tglkirimberkas = tglkirimberkas[1] + '-' + tglkirimberkas[2];
                    selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                    if (selectedId == null || selectedId == '' || selectedId == undefined) {
                      showDialog('Harap pilih salah satu record')
                    } else {
                      approvalKirimBerkas(tglkirimberkas, 'ABSENSISUPIRHEADER', selectedRows, selectedbukti);
                    }
                  }
                }
              },

              {
                  id: 'approvalabsensifinal',
                  text: "APPROVAL/UN Absensi Final",
                  color: `<?php echo $data['listbtn']->btn->approvaldata; ?>`,
                  hidden :(!`{{ $myAuth->hasPermission('absensisupirheader', 'approvalfinalabsensi') }}`),
                  onClick: () => {
                      if (`{{ $myAuth->hasPermission('absensisupirheader', 'approvalfinalabsensi') }}`) {
                        approvalFinalAbsensi();
                      }
                  }
              },
             

            ],
          },
          {
            id: 'lainnya',
            title: 'Lainnya',
            caption: 'Lainnya',
            innerHTML: '<i class="fa fa-check"></i> LAINNYA',
            class: 'btn btn-secondary btn-sm mr-1',
            item: [{
                id: 'cekAbsenTrado',
                text: "Cek Absen Trado",
                color: `<?php echo $data['listbtn']->btn->cekabsentrado; ?>`,
                hidden :(!`{{ $myAuth->hasPermission('absensisupirheader', 'cekabsensi') }}`),
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('absensisupirheader', 'cekabsensi') }}`) {
                    selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                    cekAbsenTrado(selectedId)
                  }
                }
              },


            ],
          }
        ],
        buttons: [{
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

              viewAbsensiSupir(selectedId)
            }
          },
        ]

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
      if (!`{{ $myAuth->hasPermission('absensisupirheader', 'store') }}`) {
        $('#add').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('absensisupirheader', 'update') }}`) {
        $('#edit').attr('disabled', 'disabled')
      }
      if (!`{{ $myAuth->hasPermission('absensisupirheader', 'show') }}`) {
        $('#view').attr('disabled', 'disabled')
      }
      if (!`{{ $myAuth->hasPermission('absensisupirheader', 'destroy') }}`) {
        $('#delete').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('absensisupirheader', 'export') }}`) {
        $('#export').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('absensisupirheader', 'report') }}`) {
        $('#report').attr('disabled', 'disabled')
      }
      if (!`{{ $myAuth->hasPermission('absensisupirheader', 'cekabsensi') }}`) {
        $('#cekAbsenTrado').attr('disabled', 'disabled')
      }
      let hakApporveCount = 0;
      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('absensisupirheader', 'approvalbukacetak') }}`) {
        hakApporveCount--
        $('#approval-buka-cetak').hide()
        // $('#approval-buka-cetak').attr('disabled', 'disabled')
      }

      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('absensisupirheader', 'approvalkirimberkas') }}`) {
        hakApporveCount--
        $('#approval-kirim-berkas').hide()
      }
      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('absensisupirheader', 'approvalEditAbsensi') }}`) {
        hakApporveCount--
        $('#approvalEdit').hide()
      }
      if (hakApporveCount < 1) {
        $('#approve').hide()
        // $('#approve').attr('disabled', 'disabled')
      }
      // console.log(hakApporveCount);
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

    function approve(id) {
      $.ajax({
        url: `${apiUrl}absensisupirheader/${id}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          showConfirm("Approve", response.data.nobukti, `absensisupirheader/${response.data.id}/approval`)
        },
      })
    }
    getStatusEdit()

    function approveEdit() {
      event.preventDefault()

      let form = $('#crudForm')
      $(this).attr('disabled', '')
      $('#processingLoader').removeClass('d-none')
      if (approveEditRequest) {
        approveEditRequest.abort();
      }
      approveEditRequest = $.ajax({
        url: `${apiUrl}absensisupirheader/approvalEditAbsensi`,
        method: 'POST',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          Id: selectedRows,
        },
        success: response => {
          $('#crudForm').trigger('reset')
          $('#crudModal').modal('hide')

          $('#jqGrid').jqGrid('setGridParam', {
            postData: {
              proses: 'reload'
            }
          }).trigger('reloadGrid');
          selectedRows = []
          $('#gs_').prop('checked', false)
        },
        error: error => {
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            setErrorMessages(form, error.responseJSON.errors);
          } else {
            showDialog(error.responseJSON)
          }
        },
      }).always(() => {
        $('#processingLoader').addClass('d-none')
        $(this).removeAttr('disabled')
      })
    }

    function approveEditOld(id) {
      if (approveEditRequest) {
        approveEditRequest.abort();
      }
      approveEditRequest = $.ajax({
        url: `${apiUrl}absensisupirheader/${id}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
   
        success: response => {
          if (response.data.statusapprovalfinalabsensi === "TIDAK"){
            let msg = `YAKIN UnApprove Status Edit `
              console.log(statusTidakBisaEdit);
              if (response.data.statusapprovaleditabsensi === statusTidakBisaEdit) {
                msg = `YAKIN Approve Status Edit `
              }
              showConfirm(msg, response.data.nobukti, `absensisupirheader/${response.data.id}/approvalEditAbsensi?absenId=${selectedRows}`)
                .then(() => {
                  selectedRows = []
                  $('#gs_').prop('checked', false)
                })

          } else {
            showDialog("TIDAK BISA APPROVAL KARENA SUDAH APPROVAL FINAL")
          }


        },
      })
    }

    function approveTripInap(id) {
      if (approveEditRequest) {
        approveEditRequest.abort();
      }
      approveEditRequest = $.ajax({
        url: `${apiUrl}absensisupirheader/approvaltripinap`,
        method: 'POST',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          id: selectedRows
        },
        success: response => {
          $('#jqGrid').jqGrid().trigger('reloadGrid');
          selectedRows = []
          $('#gs_').prop('checked', false)

        },
        error: error => {
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            setErrorMessages( $('#crudForm'), error.responseJSON.errors);
          } else {
            showDialog(error.responseJSON)
          }
        },
      })
    }

  })

  const setTampilanIndex = function() {
    return new Promise((resolve, reject) => {
      let data = [];
      data.push({
        name: 'grp',
        value: 'UBAH TAMPILAN'
      })
      data.push({
        name: 'text',
        value: 'ABSENSISUPIR'
      })
      $.ajax({
        url: `${apiUrl}parameter/getparambytext`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: data,
        success: response => {
          memo = JSON.parse(response.memo)
          memo = memo.INPUT
          if (memo != '') {
            input = memo.split(',');
            input.forEach(field => {
              field = $.trim(field.toLowerCase());
              $(`.${field}`).hide()
              if (field == 'uangjalan') {
                $("#detail").jqGrid("hideCol", field);
              } else {
                $("#jqGrid").jqGrid("hideCol", field);
              }
            });
            showKasgantung = false;
          }

        }
      })
    })
  }

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
            $("#jqGrid").jqGrid('showCol', 'kasgantung');
            $("#jqGrid").jqGrid('hideCol', 'kasgantung_nobukti')
            absensiTangki = true;
          }else{
            $("#jqGrid").jqGrid('showCol', 'kasgantung_nobukti');
            $("#jqGrid").jqGrid('hideCol', 'kasgantung')
            absensiTangki = false;
          }
            

        }
      })
    })
  }

  function setTradoMilikSupir() {
    $.ajax({
      url: `${apiUrl}parameter/getparamfirst`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        grp: 'ABSENSI SUPIR',
        subgrp: 'TRADO MILIK SUPIR'
      },
      success: response => {
        isTradoMilikSupir = $.trim(response.text)
      }
    })
  }
  function GetActiveKolomJenisKendaraan() {
    $.ajax({
      url: `${apiUrl}absensisupirheader/getStatusJeniskendaraan`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
     
      success: response => {
        activeKolomJenisKendaraan = response.activeKolomJenisKendaraan
        if (!activeKolomJenisKendaraan) {
          $("#detail").jqGrid("hideCol", `statusjeniskendaraan`);
          $("#dataTidakLengkapGrid").jqGrid("hideCol", `statusjeniskendaraan`);
        }
      }
    })
  }

  function getStatusEdit() {

    $.ajax({
      url: `${apiUrl}parameter`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        limit: 0,
        filters: JSON.stringify({
          "groupOp": "AND",
          "rules": [{
            "field": "grp",
            "op": "cn",
            "data": "STATUS EDIT ABSENSI"
          }, {
            "field": "text",
            "op": "cn",
            "data": "TIDAK BOLEH EDIT ABSENSI"
          }]
        })
      },
      success: response => {
        statusTidakBisaEdit = response.data[0].id;
      }
    })
  }
</script>
@endpush()
@endsection