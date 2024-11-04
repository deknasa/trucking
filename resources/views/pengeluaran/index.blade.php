@extends('layouts.master')
@push('addtional-field')
<div class="form-group row">
  <label class="col-12 col-sm-2 col-form-label mt-2">Bank<span class="text-danger">*</span></label>
  <div class="col-sm-4 mt-2">
    <select name="bankheader" id="bankheader" class="form-select select2" style="width: 100%;">
      <option value="">-- PILIH BANK --</option>
      @foreach ($data['combobank'] as $bank)
      <option @if ($bank['statusdefault_text']==="YA" ) selected @endif value="{{$bank['id']}}"> {{$bank['namabank']}} </option>
      @endforeach
    </select>
  </div>
</div>
@endpush
@section('content')
<!-- Grid Master-->
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
              <li><a href="#jurnal-tab">Jurnal</a></li>
            </ul>
            <div id="detail-tab">
              <table id="detail"></table>
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

<!-- Modal -->
@include('pengeluaran._modal')
<!-- Detail -->
@include('pengeluaran._detail')
@include('jurnalumum._jurnal')

@push('scripts')
<script>
  let indexUrl = "{{ route('pengeluaranheader.index') }}"
  let getUrl = "{{ route('pengeluaranheader.get') }}"
  let indexRow = 0;
  let page = 0;
  let pager = '#jqGridPager'
  let popup = "";
  let id = "";
  let triggerClick = true;
  let highlightSearch;
  let totalRecord
  let activeGrid
  let limit
  let postData
  let sortname = 'nobukti'
  let sortorder = 'asc'
  let autoNumericElements = []
  let rowNum = 10
  let hasDetail = false
  let currentTab = 'detail'
  let selectedRows = [];
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

    let nobukti = $('#jqGrid').jqGrid('getCell', id, 'nobukti')
    loadDetailGrid()
    loadJurnalUmumGrid(nobukti)

    $('#bankheader').select2({
      width: 'resolve',
      theme: "bootstrap4"
    });

    @isset($request['tgldari'])
    tgldariheader = `{{ $request['tgldari'] }}`;
    @endisset
    @isset($request['tglsampai'])
    tglsampaiheader = `{{ $request['tglsampai'] }}`;
    @endisset

    @isset($request['bank_id'])
    $('#bankheader').val(`{{ $request['bank_id'] }}`).trigger('change')
    @endisset

    setRange(false, tgldariheader, tglsampaiheader)
    initDatepicker('datepickerIndex')
    $(document).on('click', '#btnReload', function(event) {
      loadDataHeader('pengeluaranheader', {
        bank_id: $('#bankheader').val(),
        proses: 'reload'
      })
      selectedRows = []
      selectedbukti = []
      $('#gs_').prop('checked', false)
    })

    function createColModel() {
      return [{
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
          return `<input type="checkbox" name="pengeluaranId[]" class="checkbox-jqgrid" value="${rowData.id}" onchange="checkboxHandler(this)">`
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

          let formattedValue = $(`
            <div class="badge" style="background-color: ${statusApproval.WARNA}; color: #fff;">
              <span>${statusApproval.SINGKATAN}</span>
            </div>
          `)

          return formattedValue[0].outerHTML
        },
        cellattr: (rowId, value, rowObject) => {
          let statusApproval = JSON.parse(rowObject.statusapproval)

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
            return ``
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
            return ` title=""`
          }
          return ` title="${statusCetak.MEMO}"`
        }
      },
      {
        label: 'NO BUKTI',
        name: 'nobukti',
        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
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
        label: 'NOMINAL',
        name: 'nominal',
        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
        align: 'right',
        formatter: currencyFormat,
      },
      {
        label: 'ALAT BAYAR',
        name: 'alatbayar_id',
        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
        align: 'left'
      },
      {
        label: 'NO BUKTI ASAL',
        name: 'url_asal',
        width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
        align: 'left',
        formatter: (value, options, rowData) => {
          if ((value == null) || (value == '')) {
            return '';
          }
          return value
        }
      },
      {
        label: 'POSTING DARI',
        name: 'postingdari',
        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
        align: 'left'
      },
      {
        label: 'DIBAYARKAN KE',
        name: 'dibayarke',
        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
        align: 'left'
      },

      {
        label: 'BANK',
        name: 'bank',
        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
        align: 'left'
      },
      {
        label: 'TRANSFER KE NO REK',
        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
        name: 'transferkeac',
        align: 'left'
      },
      {
        label: 'TRANSFER NAMA REK',
        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
        name: 'transferkean',
        align: 'left'
      },
      {
        label: 'TRANSFER NAMA BANK',
        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
        name: 'transferkebank',
        align: 'left'
      },
      {
        label: 'PENERIMA',
        width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
        name: 'penerima',
        align: 'left'
      },
      {
        label: 'USER APPROVAL',
        name: 'userapproval',
        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
        align: 'left'
      },
      {
        label: 'TGL APPROVAL',
        name: 'tglapproval',
        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
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
        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
        align: 'left',
        formatter: "date",
        formatoptions: {
          srcformat: "ISO8601Long",
          newformat: "d-m-Y"
        }
      },
      {
        label: 'NO BUKTI PENERIMAAN',
        name: 'penerimaan_nobukti',
        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
        align: 'left'
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
    ]
    }

    function getSavedColumnOrder() {
      // return JSON.parse(localStorage.getItem(`tas_${window.location.href}_${authUserId}`));
      // console.log(authUserId);
      
      return colModelUser.pengeluaran;
    }
    // Menyimpan urutan kolom ke local storage
    function saveColumnOrder() {
      var colOrder = $("#jqGrid").jqGrid("getGridParam", "colModel").map(function(col) {
        return col.name;
      });
      // localStorage.setItem(`tas_${window.location.href}_${authUserId}`, JSON.stringify(colOrder));
    }
    // Mengatur ulang urutan colModel berdasarkan urutan yang disimpan
    function reorderColModel(colModel, colOrder) {
      if (!colOrder) return colModel;
      var orderedColModel = [];
      colOrder.forEach(function(colName) {
        var col = colModel.find(function(c) {
          return c.name === colName;
        });
        if (col) orderedColModel.push(col);
      });
      return orderedColModel;
    }
    var colModel = createColModel();
    var savedColOrder = getSavedColumnOrder();
    var orderedColModel = reorderColModel(colModel, savedColOrder);


    var grid = $("#jqGrid");
    grid.jqGrid({
        url: `{{ config('app.api_url') . 'pengeluaranheader' }}`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        postData: {
          tgldari: $('#tgldariheader').val(),
          tglsampai: $('#tglsampaiheader').val(),
          bank_id: $('#bankheader').val(),
        },
        datatype: "json",
        colModel: orderedColModel,
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
          if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))

          loadDetailData(id)
          loadJurnalUmumData(id, nobukti)
        },
        loadComplete: function(data) {
          changeJqGridRowListText()

          if (data.data.length === 0) {
            $('#detail, #jurnalGrid').each((index, element) => {
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
          setHighlight($(this))
          $('#gs_').attr('disabled', false)
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
          $('#left-nav').find(`button:not(#add)`).attr('disabled', 'disabled')
          $(this).setGridParam({
            postData: {
              tgldari: $('#tgldariheader').val(),
              tglsampai: $('#tglsampaiheader').val(),
              bank_id: $('#bankheader').val(),
            },
          })
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
                  rawCellValue = $("#jqGrid").jqGrid('getCell', selectedId, 'nobukti');
                  celValue = $("<div>").html(rawCellValue).text();
                  selectednobukti = celValue
                  if (selectedId == null || selectedId == '' || selectedId == undefined) {
                    showDialog('Harap pilih salah satu record')
                  } else {
                    cekValidasi(selectedId, 'PRINTER BESAR', selectednobukti)
                  }
                  clearSelectedRows()
                  $('#gs_').prop('checked', false)
                }
              },
              {
                id: 'reportPrinterKecil',
                text: "Printer Epson Seri LX(Faktur)",
                color: `<?php echo $data['listbtn']->btn->reportPrinterKecil; ?>`,
                onClick: () => {
                  selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                  rawCellValue = $("#jqGrid").jqGrid('getCell', selectedId, 'nobukti');
                  celValue = $("<div>").html(rawCellValue).text();
                  selectednobukti = celValue
                  if (selectedId == null || selectedId == '' || selectedId == undefined) {
                    showDialog('Harap pilih salah satu record')
                  } else {
                    cekValidasi(selectedId, 'PRINTER KECIL', selectednobukti)
                  }
                  clearSelectedRows()
                  $('#gs_').prop('checked', false)
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
                // window.open(`{{ route('pengeluaranheader.export') }}?id=${selectedId}`)
                $.ajax({
                  url: `${apiUrl}pengeluaranheader/${selectedId}/export`,
                  type: 'GET',
                  data: {
                    forReport : true,
                    pengeluaran_id: selectedId,
                    export: true
                  },
                  beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`);
                  },
                  xhrFields: {
                    responseType: 'arraybuffer'
                  },
                  success: function(response, status, xhr) {
                    if (xhr.status === 200) {
                      var filename = xhr.getResponseHeader('Filename');
                      if (response !== undefined) {
                        var blob = new Blob([response], {
                          type: 'cabang/vnd.ms-excel'
                        });
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = filename + '.xlsx';
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
              clearSelectedRows()
              $('#gs_').prop('checked', false)
            }
          },
          {
            id: 'approve',
            title: 'Approve',
            caption: 'Approve',
            innerHTML: '<i class="fa fa-check"></i> APPROVAL/UN',
            class: 'btn btn-purple btn-sm mr-1',
            item: [{
                id: 'approveun',
                text: "APPROVAL/UN Status PENGELUARAN",
                color: "btn-success",
                hidden: (!`{{ $myAuth->hasPermission('pengeluaranheader', 'approval') }}`),
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('pengeluaranheader', 'approval') }}`) {
                    approve()
                  }
                }
              },
              {
                id: 'approval-buka-cetak',
                text: "Approval Buka Cetak PENGELUARAN",
                color: "btn-info",
                hidden: (!`{{ $myAuth->hasPermission('pengeluaranheader', 'approvalbukacetak') }}`),
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('pengeluaranheader', 'approvalbukacetak') }}`) {
                    let tglbukacetak = $('#tgldariheader').val().split('-');
                    tglbukacetak = tglbukacetak[1] + '-' + tglbukacetak[2];


                    approvalBukaCetak(tglbukacetak, 'PENGELUARANHEADER', selectedRows, selectedbukti);
                  }
                }
              },
              {
                id: 'approval-kirim-berkas',
                text: "APPROVAL/UN Kirim Berkas PENGELUARAN",
                color: "btn-primary",
                hidden: (!`{{ $myAuth->hasPermission('pengeluaranheader', 'approvalkirimberkas') }}`),
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('pengeluaranheader', 'approvalkirimberkas') }}`) {
                    let tglkirimberkas = $('#tgldariheader').val().split('-');
                    tglkirimberkas = tglkirimberkas[1] + '-' + tglkirimberkas[2];


                    approvalKirimBerkas(tglkirimberkas, 'PENGELUARANHEADER', selectedRows, selectedbukti);
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
              createPengeluaran()
            }
          },
          {
            id: 'edit',
            innerHTML: '<i class="fa fa-pen"></i> EDIT',
            class: 'btn btn-success btn-sm mr-1',
            onClick: function(event) {

              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              rawCellValue = $("#jqGrid").jqGrid('getCell', selectedId, 'nobukti');
              celValue = $("<div>").html(rawCellValue).text();
              selectednobukti = celValue
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Harap pilih salah satu record')
              } else {
                cekValidasi(selectedId, 'EDIT', selectednobukti)
              }

            }
          },
          {
            id: 'delete',
            innerHTML: '<i class="fa fa-trash"></i> DELETE',
            class: 'btn btn-danger btn-sm mr-1',
            onClick: () => {

              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              rawCellValue = $("#jqGrid").jqGrid('getCell', selectedId, 'nobukti');
              celValue = $("<div>").html(rawCellValue).text();
              selectednobukti = celValue
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Harap pilih salah satu record')
              } else {
                cekValidasi(selectedId, 'DELETE', selectednobukti)
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
                viewPengeluaran(selectedId)
              }
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

    $('#approval .ui-pg-div')
      .addClass('btn btn-purple btn-sm')
      .css({
        'background': '#6619ff',
        'color': '#fff'
      })
      .parent().addClass('px-1')

    function permission() {
      if (!`{{ $myAuth->hasPermission('pengeluaranheader', 'store') }}`) {
        $('#add').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('pengeluaranheader', 'show') }}`) {
        $('#view').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('pengeluaranheader', 'update') }}`) {
        $('#edit').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('pengeluaranheader', 'destroy') }}`) {
        $('#delete').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('pengeluaranheader', 'export') }}`) {
        $('#export').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('pengeluaranheader', 'report') }}`) {
        $('#report').attr('disabled', 'disabled')
      }
      let hakApporveCount = 0;
      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('pengeluaranheader', 'approval') }}`) {
        hakApporveCount--
        $('#approveun').hide()
        // $('#approval-buka-cetak').attr('disabled', 'disabled')
      }
      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('pengeluaranheader', 'approvalbukacetak') }}`) {
        hakApporveCount--
        $('#approval-buka-cetak').hide()
        // $('#approval-buka-cetak').attr('disabled', 'disabled')
      }
      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('pengeluaranheader', 'approvalkirimberkas') }}`) {
        hakApporveCount--
        $('#approval-kirim-berkas').hide()
      }
      if (hakApporveCount < 1) {
        $('#approve').hide()
        // $('#approve').attr('disabled', 'disabled')
      }
    }
  })

  function clearSelectedRows() {
    selectedRows = []
    selectedbukti = []

    $('#gs_').prop('checked', false);
    $('#jqGrid').trigger('reloadGrid')
  }

  function selectAllRows() {
    $.ajax({
      url: `${apiUrl}pengeluaranheader`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        limit: 0,
        tgldari: $('#tgldariheader').val(),
        tglsampai: $('#tglsampaiheader').val(),
        bank_id: $('#bankheader').val(),
        filters: $('#jqGrid').jqGrid('getGridParam', 'postData').filters
      },
      success: (response) => {
        selectedRows = response.data.map((datas) => datas.id)
        selectedbukti = response.data.map((datas) => datas.nobukti)
        $('#jqGrid').trigger('reloadGrid')
      }
    })
  }
</script>
@endpush()
@endsection