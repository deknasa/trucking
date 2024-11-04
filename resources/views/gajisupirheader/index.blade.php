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
          <div id="tabs-detail">
            <ul class="dejavu">
              <li><a href="#detail-tab">Details</a></li>
              <li><a href="#potsemua-tab">Pot. Semua</a></li>
              <li><a href="#potpribadi-tab">Pot. Pribadi</a></li>
              <li><a href="#deposito-tab">Deposito</a></li>
              <li><a href="#bbm-tab">BBM</a></li>
              <li><a href="#absensi-tab">Absensi</a></li>
            </ul>
            <div id="detail-tab">
              <table id="detail"></table>
            </div>
            <div id="potsemua-tab">
              <table id="potsemuaGrid"></table>
            </div>
            <div id="potpribadi-tab">
              <table id="potpribadiGrid"></table>
            </div>
            <div id="deposito-tab">
              <table id="depositoGrid"></table>
            </div>
            <div id="bbm-tab">
              <table id="bbmGrid"></table>
            </div>
            <div id="absensi-tab">
              <table id="absensiGrid"></table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@include('gajisupirheader._modal')
<!-- Detail -->
@include('gajisupirheader._detail')
@include('gajisupirheader._potsemua')
@include('gajisupirheader._potpribadi')
@include('gajisupirheader._deposito')
@include('gajisupirheader._bbm')
@include('gajisupirheader._absensi')

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
  let activeGrid
  let postData
  let sortname = 'nobukti'
  let sortorder = 'asc'
  let autoNumericElements = []
  let rowNum = 10
  let hasDetail = false
  let currentTab = 'detail'
  let tgldariheader
  let tglsampaiheader
  let selectedRowsIndex = [];
  let nobuktiRicForSearching = '';
  let jenisTambahan = '';
  let selectedbukti = [];

  function checkboxHandlerIndex(element) {
    let value = $(element).val();

    var onSelectRowExisting = $("#jqGrid").jqGrid('getGridParam', 'onSelectRow');
    $("#jqGrid").jqGrid('setSelection', value, false);
    onSelectRowExisting(value)


    let valuebukti = $(`#jqGrid tr#${value}`).find(`td[aria-describedby="jqGrid_nobukti"]`).attr('title');
    if (element.checked) {
      selectedRowsIndex.push($(element).val())
      selectedbukti.push(valuebukti)
      $(element).parents('tr').addClass('bg-light-blue')
    } else {
      $(element).parents('tr').removeClass('bg-light-blue')
      for (var i = 0; i < selectedRowsIndex.length; i++) {
        if (selectedRowsIndex[i] == value) {
          selectedRowsIndex.splice(i, 1);
        }
      }
      if (selectedRowsIndex.length != $('#jqGrid').jqGrid('getGridParam').records) {
        $('#gs_check').prop('checked', false)
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


  function clearSelectedRowsIndex() {
    selectedRowsIndex = []
    selectedbukti = []
    $('#gs_check').prop('checked', false);
    $('#jqGrid').trigger('reloadGrid')
  }

  function selectAllRowsIndex() {
    $.ajax({
      url: `${apiUrl}gajisupirheader`,
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
        selectedRowsIndex = response.data.map((datas) => datas.id)
        selectedbukti = response.data.map((datas) => datas.nobukti)
        $('#jqGrid').trigger('reloadGrid')
      }
    })
  }

  reloadGrid()
  setSpaceBarCheckedHandler2()
  $(document).ready(function() {
    $("#tabs-detail").tabs()

    let nobukti = $('#jqGrid').jqGrid('getCell', id, 'nobukti')
    console.log('nobukti', nobukti)
    loadDetailGrid()
    loadPotSemuaIndexGrid()
    loadPotPribadiIndexGrid()
    loadDepositoGrid()
    loadBBMGrid()
    getJenisTambahan()
    loadAbsensiGrid()
    syncHeaderScroll('potsemuaGrid');
    syncHeaderScroll('potpribadiGrid');
    syncHeaderScroll('depositoGrid');
    syncHeaderScroll('bbmGrid');
    syncHeaderScroll('absensiGrid');

    @isset($request['tgldari'])
    tgldariheader = `{{ $request['tgldari'] }}`;
    @endisset
    @isset($request['tglsampai'])
    tglsampaiheader = `{{ $request['tglsampai'] }}`;
    @endisset
    setRange(false, tgldariheader, tglsampaiheader)
    initDatepicker('datepickerIndex')
    $(document).on('click', '#btnReload', function(event) {
      loadDataHeader('gajisupirheader')
      selectedRowsIndex = []
      selectedbukti = []
      $('#gs_check').prop('checked', false);
    })


    var grid = $("#jqGrid");
    grid.jqGrid({
        url: `{{ config('app.api_url') . 'gajisupirheader' }}`,
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
            name: 'check',
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
                    selectAllRowsIndex()
                  } else {
                    clearSelectedRowsIndex()
                  }
                })

              }
            },
            formatter: (value, rowOptions, rowData) => {
              return `<input type="checkbox" name="Idindex[]" value="${rowData.id}" onchange="checkboxHandlerIndex(this)">`
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
            label: 'SUPIR',
            name: 'supir_id',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            align: 'left',
          },
          {
            label: 'U. Borongan (Supir)',
            name: 'gajisupir',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'U. Borongan (Ritasi Supir)',
            name: 'ritasisupir',
            width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
            align: 'right',
            formatter: currencyFormat,
          },

          {
            label: 'Biaya Extra (Trip)',
            name: 'biayaextra',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'Total',
            name: 'total',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'U. Jalan',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            name: 'uangjalan',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'U. BBM',
            name: 'bbm',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'Pot. pinjaman',
            name: 'potonganpinjaman',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'POT. PINJAMAN (SEMUA)',
            name: 'potonganpinjamansemua',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'DEPOSITO',
            name: 'deposito',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'U. MAKAN HARIAN',
            name: 'uangmakanharian',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'U. MAKAN BERJENJANG',
            name: 'uangmakanberjenjang',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'B. EXTRA',
            name: 'biayaextraheader',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'KET. BIAYA EXTRA',
            name: 'keteranganextra',
            width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
            align: 'left'
          },
          {
            label: 'Nominal',
            name: 'nominal',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'Komisi Kenek',
            name: 'gajikenek',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'Komisi Supir',
            name: 'komisisupir',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'NO BUKTI EBS',
            width: 220,
            name: 'nobukti_ebs',
            formatter: (value, options, rowData) => {
              if ((value == null) || (value == '')) {
                return '';
              }
              let tgldari = rowData.tgldariheaderebs
              let tglsampai = rowData.tglsampaiheaderebs
              let url = "{{route('prosesgajisupirheader.index')}}"
              let formattedValue = $(`<a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}&nobukti=${value}" class="link-color" target="_blank">${value}</a>`)

              return formattedValue[0].outerHTML
            },
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
            label: 'TGL DARI',
            name: 'tgldari',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'TGL SAMPAI',
            name: 'tglsampai',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
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
            align: 'left',
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
            align: 'left',
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
        footerrow: true,
        userDataOnFooter: true,
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
          loadDetailData(id)
          loadPotSemuaIndexData(nobukti)
          loadPotPribadiIndexData(nobukti)
          loadDepositoData(nobukti)
          loadBBMData(nobukti)
          loadAbsensiData(nobukti)
          nobuktiRicForSearching = nobukti
          activeGrid = grid
          indexRow = grid.jqGrid('getCell', id, 'rn') - 1
          page = grid.jqGrid('getGridParam', 'page')
          let limit = grid.jqGrid('getGridParam', 'postData').limit
          if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))

        },
        loadComplete: function(data) {
          changeJqGridRowListText()

          if (data.data.length === 0) {
            $('#detail, #potsemuaGrid, #potpribadiGrid, #depositoGrid,#bbmGrid, #absensiGrid').each((index, element) => {
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

          $.each(selectedRowsIndex, function(key, value) {

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

          if (data.attributes) {
            $(this).jqGrid('footerData', 'set', {
              nobukti: 'Total:',
              total: data.attributes.totalAll,
              komisisupir: data.attributes.totalKomisiSupir,
              gajikenek: data.attributes.totalGajiKenek,
              biayaextra: data.attributes.totalBiayaExtra,
              biayaextraheader: data.attributes.totalBiayaExtraHeader,
              uangjalan: data.attributes.totalUangJalan,
              bbm: data.attributes.totalBbm,
              potonganpinjaman: data.attributes.totalPotPinj,
              potonganpinjamansemua: data.attributes.totalPotSemua,
              deposito: data.attributes.totalDeposito,
              uangmakanberjenjang: data.attributes.totalJenjang,
              uangmakanharian: data.attributes.totalMakan,
              nominal: data.attributes.totalNominal,
              gajisupir: data.attributes.totalGajiSupir,
              ritasisupir: data.attributes.totalRitasiSupir,
            }, true)
          }
          $('#left-nav').find('button').attr('disabled', false)
          permission()
          $('#gs_check').attr('disabled', false)
          getQueryParameter()
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
          $('#left-nav').find(`button:not(#add)`).attr('disabled', 'disabled')
          $(this).setGridParam({
            postData: {
              tgldari: $('#tgldariheader').val(),
              tglsampai: $('#tglsampaiheader').val()
            },
          })
          clearGlobalSearch($('#jqGrid'))
        },
      })

      .customPager({
        buttons: [{
            id: 'add',
            innerHTML: '<i class="fa fa-plus"></i> ADD',
            class: 'btn btn-primary btn-sm mr-1',
            onClick: function(event) {
              createGajiSupirHeader()
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

                viewGajiSupirHeader(selectedId)
              }
            }
          },
          {
            id: 'report',
            innerHTML: '<i class="fa fa-print"></i> REPORT',
            class: 'btn btn-info btn-sm mr-1',
            onClick: () => {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Harap pilih salah satu record')
              } else {
                cekValidasi(selectedId, 'PRINTER')
              }
            }
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
                // window.open(`{{ route('gajisupirheader.export') }}?id=${selectedId}`)
                $.ajax({
                  url: `${apiUrl}gajisupirheader/${selectedId}/export`,
                  type: 'GET',
                  data: {
                    forReport: true,
                    sortIndex: 'suratpengantar_nobukti',
                    gajisupir_id: selectedId,
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
                      if (response !== undefined) {
                        var blob = new Blob([response], {
                          type: 'cabang/vnd.ms-excel'
                        });
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = 'LAPORAN RINCIAN GAJI SUPIR' + new Date().getTime() + '.xlsx';
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
        ],
        modalBtnList: [{
          id: 'approve',
          title: 'Approve',
          caption: 'Approve',
          innerHTML: '<i class="fa fa-check"></i> APPROVAL/UN',
          class: 'btn btn-purple btn-sm mr-1 ',
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
              text: "Approval Buka Cetak GAJI SUPIR",
              hidden: (!`{{ $myAuth->hasPermission('gajisupirheader', 'approvalbukacetak') }}`),
              color: `<?php echo $data['listbtn']->btn->approvalbukacetak; ?>`,
              onClick: () => {
                if (`{{ $myAuth->hasPermission('gajisupirheader', 'approvalbukacetak') }}`) {
                  let tglbukacetak = $('#tgldariheader').val().split('-');
                  tglbukacetak = tglbukacetak[1] + '-' + tglbukacetak[2];

                  approvalBukaCetak(tglbukacetak, 'GAJISUPIRHEADER', selectedRowsIndex, selectedbukti);

                }
              }
            },
            {
              id: 'approval-kirim-berkas',
              text: "APPROVAL/UN Kirim Berkas GAJI SUPIR",
              color: `<?php echo $data['listbtn']->btn->approvalkirimberkas; ?>`,
              hidden: (!`{{ $myAuth->hasPermission('gajisupirheader', 'approvalkirimberkas') }}`),
              onClick: () => {
                if (`{{ $myAuth->hasPermission('gajisupirheader', 'approvalkirimberkas') }}`) {
                  let tglkirimberkas = $('#tgldariheader').val().split('-');
                  tglkirimberkas = tglkirimberkas[1] + '-' + tglkirimberkas[2];

                  approvalKirimBerkas(tglkirimberkas, 'GAJISUPIRHEADER', selectedRowsIndex, selectedbukti);

                }
              }
            },
            {
              id: 'approval-mandor',
              text: "Approval Mandor",
              hidden: (!`{{ $myAuth->hasPermission('listtrip', 'approval') }}`),
              color: `<?php echo $data['listbtn']->btn->approvalaktif; ?>`,
              onClick: () => {
                if (`{{ $myAuth->hasPermission('listtrip', 'approval') }}`) {

                  selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                  if (selectedId == null || selectedId == '' || selectedId == undefined) {
                    showDialog('Harap pilih salah satu record')
                  } else {
                    cekValidasi(selectedId, 'APPROVAL MANDOR')
                  }

                }
              }
            },
          ],
        }]
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
      if (!`{{ $myAuth->hasPermission('gajisupirheader', 'store') }}`) {
        $('#add').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('gajisupirheader', 'show') }}`) {
        $('#view').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('gajisupirheader', 'update') }}`) {
        $('#edit').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('gajisupirheader', 'destroy') }}`) {
        $('#delete').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('gajisupirheader', 'export') }}`) {
        $('#export').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('gajisupirheader', 'report') }}`) {
        $('#report').attr('disabled', 'disabled')
      }
      let hakApporveCount = 0;
      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('gajisupirheader', 'approvalbukacetak') }}`) {
        hakApporveCount--
        $('#approval-buka-cetak').hide()
        // $('#approval-buka-cetak').attr('disabled', 'disabled')
      }
      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('gajisupirheader', 'approvalkirimberkas') }}`) {
        hakApporveCount--
        $('#approval-kirim-berkas').hide()
      }
      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('listtrip', 'approval') }}`) {
        hakApporveCount--
        $('#approval-mandor').hide()
      }
      if (hakApporveCount < 1) {
        $('#approve').hide()
        // $('#approve').attr('disabled', 'disabled')
      }
    }
  })

  function getJenisTambahan() {
    $.ajax({
      url: `${apiUrl}parameter/getparamfirst`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        grp: 'GAJI SUPIR',
        subgrp: 'JENIS TAMBAHAN'
      },
      success: response => {
        jenisTambahan = response.text

        if (jenisTambahan == 'RITASI') {
          $("#detail").jqGrid("hideCol", `biayaextrasupir_nobukti`);
          $("#detail").jqGrid("hideCol", `biayaextrasupir_nominal`);
          $("#detail").jqGrid("hideCol", `biayaextrasupir_keterangan`);
        } else {
          $("#detail").jqGrid("hideCol", `ritasi_nobukti`);
          $("#detail").jqGrid("hideCol", `upahritasi`);
          $("#detail").jqGrid("hideCol", `statusritasi`);
        }
      }
    })
  }
</script>
@endpush()
@endsection