@extends('layouts.master')

@section('content')
<!-- Grid -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      @include('layouts._rangeheadertrip')

      <table id="jqGrid"></table>
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-12">
      <div class="card card-primary card-outline card-outline-tabs">
        <div class="card-body border-bottom-0">
          <div id="tabs">
            <ul class="dejavu">
              <li><a href="#detail-tab">Biaya Tambahan</a></li>
              <li><a href="#rekap-tab">Rekap Customer</a></li>
            </ul>
            <div id="detail-tab">
              <table id="detailGrid"></table>
            </div>
            <div id="rekap-tab">
              <table id="rekapCustGrid"></table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@include('suratpengantar._tambahan')
@include('suratpengantar._customer')
@include('suratpengantar._editsp')

@include('suratpengantar._modal')

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
  var statusBukanBatalMuat;
  var activeGrid;
  var statusEditTujuan;
  let tgldariheader
  let tglsampaiheader
  let nobukti
  let isKomisi;
  let isApprovalBiayaTambahan;
  let selectedRows = [];
  let selectedbukti = [];
  let selectednobuktiheader;

  function checkboxHandler(element) {
    let value = $(element).val();
    // let valueid= $(element).parents('tr').find(`td[aria-describedby="jqGrid_id"]`).text();
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
      url: `${apiUrl}suratpengantar`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        limit: 0,
        tgldari: $('#tgldariheader').val(),
        tglsampai: $('#tglsampaiheader').val(),
        nobukti: $('#nobukti').val(),
        filters: $('#jqGrid').jqGrid('getGridParam', 'postData').filters
      },
      success: (response) => {
        selectedRows = response.data.map((suratpengantar) => suratpengantar.nobukti)
        $('#jqGrid').trigger('reloadGrid')
      }
    })
  }

  setSpaceBarCheckedHandler('suratpengantar')
  $(document).ready(function() {
    if (accessCabang != 'MEDAN') {
      $('#btnReloadTrip').hide()
    }
    $("#tabs").tabs()
    setIsKomisi()
    loadDetailGrid()
    loadRekapCustGrid($('#tgldariheader').val(), $('#tglsampaiheader').val())
    syncHeaderScroll('detailGrid');
    syncHeaderScroll('rekapCustGrid');

    @isset($request['tgldari'])
    tgldariheader = `{{ $request['tgldari'] }}`;
    @endisset
    @isset($request['tglsampai'])
    tglsampaiheader = `{{ $request['tglsampai'] }}`;
    @endisset


    setRange(false, tgldariheader, tglsampaiheader)
    initDatepicker('datepickerIndex')
    $(document).on('click', '#btnReload', function(event) {
      selectedbukti = []

      $('#jqGrid').jqGrid('setGridParam', {
        page: 1,
        postData: {

          limit: 0,
          page: 1,
          tgldari: $('#tgldariheader').val(),
          tglsampai: $('#tglsampaiheader').val(),
          nobukti: selectednobuktiheader,
          proses: 'reload',
          reload: true,
          clearfilter: true,
          nobukti: '',
          filters: $('#jqGrid').jqGrid('getGridParam', 'postData').filters
        }

      }).trigger('reloadGrid')

      selectedRows = []
      $('#gs_').prop('checked', false)
    })
    $(document).on('click', '#btnReloadTrip', function(event) {
      selectedbukti = []
      selectedIdheader = $("#jqGrid").jqGrid('getGridParam', 'selrow')
      rawCellValueheader = $("#jqGrid").jqGrid('getCell', selectedIdheader, 'nobukti');
      celValueheader = $("<div>").html(rawCellValueheader).text();
      selectednobuktiheader = celValueheader

      $('#jqGrid').jqGrid('setGridParam', {
        page: 1,
        postData: {

          limit: 0,
          page: 1,
          tgldari: $('#tgldariheader').val(),
          tglsampai: $('#tglsampaiheader').val(),
          nobukti: selectednobuktiheader,
          proses: 'page',
          reload: true,
          // clearfilter:true,
          filters: ''
        }

      }).trigger('reloadGrid')

      // loadDataHeaderTrip('suratpengantar')
      selectedRows = []
      $('#gs_').prop('checked', false)
    })
    var grid = $("#jqGrid");
    grid.jqGrid({
        url: `${apiUrl}suratpengantar`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        postData: {
          tgldari: $('#tgldariheader').val(),
          tglsampai: $('#tglsampaiheader').val(),
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
          }, {
            label: 'ID',
            name: 'id',
            width: '50px',
            search: false,
            hidden: true
          },
          {
            label: 'JOB TRUCKING',
            name: 'jobtrucking',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
            formatter: (value, options, rowData) => {
              if ((value == null) || (value == '')) {
                return '';
              }
              let tgldari = rowData.tgldariorderantrucking
              let tglsampai = rowData.tglsampaiorderantrucking
              let url = "{{route('orderantrucking.index')}}"
              let formattedValue = $(`
              <a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}&nobukti=${value}" class="link-color" target="_blank">${value}</a>
             `)
              return formattedValue[0].outerHTML
            }
          },
          {
            label: 'NO TRIP',
            name: 'nobukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'TGL TRIP',
            name: 'tglbukti',
            align: 'left',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'no sp',
            name: 'nosp',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'TGL SP',
            name: 'tglsp',
            align: 'left',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'no job',
            name: 'nojob',
            width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1
          },

          {
            label: 'SHIPPER',
            name: 'pelanggan_id',
            width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
            width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1
          },
          {
            label: 'DARI',
            name: 'dari_id',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4
          },
          {
            label: 'SAMPAI',
            name: 'sampai_id',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4
          },
          {
            label: 'PENYESUAIAN',
            name: 'penyesuaian',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4
          },
          {
            label: 'GAJI SUPIR',
            name: 'gajisupir',
            align: 'right',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            formatter: currencyFormat,

          },
          {
            label: 'JARAK',
            name: 'jarak',
            align: 'right',
            formatter: currencyFormat,
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
          },
          {
            label: 'OMSET',
            name: 'omset',
            align: 'right',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            formatter: currencyFormat,
          },
          {
            label: 'NOMINAL PERALIHAN',
            name: 'nominalperalihan',
            align: 'right',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            formatter: currencyFormat,
          },
          {
            label: 'TOTAL OMSET',
            name: 'totalomset',
            align: 'right',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            formatter: currencyFormat,
          },
          {
            label: 'CUSTOMER',
            name: 'agen_id',
            width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2
          },
          {
            label: 'JENIS ORDER',
            name: 'jenisorder_id',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3
          },
          {
            label: 'CONTAINER',
            name: 'container_id',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3
          },
          {
            label: 'no conT',
            name: 'nocont',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4
          },
          {
            label: 'no seaL',
            name: 'noseal',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3
          },
          {
            label: 'no conT 2',
            name: 'nocont2',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4
          },
          {
            label: 'no seaL 2',
            name: 'noseal2',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3
          },
          {
            label: 'FULL/EMPTY',
            name: 'statuscontainer_id',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4
          },
          {
            label: 'GUDANG',
            name: 'gudang',
            width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2
          },
          {
            label: 'no polisi',
            name: 'trado_id',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3
          },
          {
            label: 'SUPIR',
            name: 'supir_id',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4
          },
          {
            label: 'CHASIS',
            name: 'gandengan_id',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3
          },
          {
            label: 'LONGTRIP',
            name: 'statuslongtrip',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            stype: 'select',
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['combolongtrip'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['combolongtrip'])) {
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
              let statusLongTrip = JSON.parse(value)
              if (!statusLongTrip) {
                return ''
              }
              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusLongTrip.WARNA}; color: #fff;">
                  <span>${statusLongTrip.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusLongTrip = JSON.parse(rowObject.statuslongtrip)
              if (!statusLongTrip) {
                return ` title=""`
              }
              return ` title="${statusLongTrip.MEMO}"`
            }
          },
          {
            label: 'PERALIHAN',
            name: 'statusperalihan',
            stype: 'select',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['comboperalihan'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['comboperalihan'])) {
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
              let statusPeralihan = JSON.parse(value)
              if (!statusPeralihan) {
                return ''
              }
              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusPeralihan.WARNA}; color: #fff;">
                  <span>${statusPeralihan.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusPeralihan = JSON.parse(rowObject.statusperalihan)
              if (!statusPeralihan) {
                return ` title=""`
              }
              return ` title="${statusPeralihan.MEMO}"`
            }
          },
          {
            label: 'LANGSIR',
            name: 'statuslangsir',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            stype: 'select',
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['combolangsir'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['combolangsir'])) {
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
              if (!value) {
                return ''
              }
              let statusLangsir = JSON.parse(value)
              if (!statusLangsir) {
                return ''
              }
              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusLangsir.WARNA}; color: #fff;">
                  <span>${statusLangsir.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {

              if (!rowObject.statuslangsir) {
                return ` title=""`
              }
              let statusLangsir = JSON.parse(rowObject.statuslangsir)
              if (!statusLangsir) {
                return ` title=""`
              }
              return ` title="${statusLangsir.MEMO}"`
            }
          },

          {
            label: 'LOKASI BONGKAR MUAT',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            name: 'tarif_id',

          },
          {
            label: 'GAJI SUPIR NO BUKTI',
            name: 'gajisupir_nobukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            formatter: (value, options, rowData) => {
              if ((value == null) || (value == '')) {
                return '';
              }
              let tgldari = rowData.tgldarigajisupirheader
              let tglsampai = rowData.tglsampaigajisupirheader
              let url = "{{route('gajisupirheader.index')}}"
              let formattedValue = $(`
              <a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}&nobukti=${value}" class="link-color" target="_blank">${value}</a>
             `)
              return formattedValue[0].outerHTML
            }
          },
          {
            label: 'NO BUKTI EBS',
            name: 'prosesgajisupir_nobukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            formatter: (value, options, rowData) => {
              if ((value == null) || (value == '')) {
                return '';
              }
              let tgldari = rowData.tgldarigajisupirheader
              let tglsampai = rowData.tglsampaigajisupirheader
              let url = "{{route('prosesgajisupirheader.index')}}"
              let formattedValue = $(`
              <a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}&nobukti=${value}" class="link-color" target="_blank">${value}</a>
             `)
              return formattedValue[0].outerHTML
            }
          },

          {
            label: 'STATUS GAJI SUPIR',
            name: 'statusgajisupir',
            stype: 'select',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['combogajisupir'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['combogajisupir'])) {
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
              let statusGajisupir = JSON.parse(value)
              if (!statusGajisupir) {
                return ''
              }
              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusGajisupir.WARNA}; color: #fff;">
                  <span>${statusGajisupir.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusGajisupir = JSON.parse(rowObject.statusgajisupir)
              if (!statusGajisupir) {
                return ` title=""`
              }
              return ` title="${statusGajisupir.MEMO}"`
            }
          },
          {
            label: 'INVOICE NO BUKTI',
            name: 'invoice_nobukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            formatter: (value, options, rowData) => {
              if ((value == null) || (value == '')) {
                return '';
              }
              let tgldari = rowData.tgldariinvoiceheader
              let tglsampai = rowData.tglsampaiinvoiceheader
              let url = "{{route('invoiceheader.index')}}"
              let formattedValue = $(`
              <a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}&nobukti=${value}" class="link-color" target="_blank">${value}</a>
             `)
              return formattedValue[0].outerHTML
            }

          },
          {
            label: 'STATUS INVOICE',
            name: 'statusinvoice',
            stype: 'select',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['comboinvoice'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['comboinvoice'])) {
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
              let statusInvoice = JSON.parse(value)
              if (!statusInvoice) {
                return ''
              }
              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusInvoice.WARNA}; color: #fff;">
                  <span>${statusInvoice.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusInvoice = JSON.parse(rowObject.statusinvoice)
              if (!statusInvoice) {
                return ` title=""`
              }
              return ` title="${statusInvoice.MEMO}"`
            }
          },
          {
            label: 'MANDOR TRADO',
            name: 'mandortrado_id',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4
          },
          {
            label: 'MANDOR SUPIR',
            name: 'mandorsupir_id',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4
          },
          {
            label: 'STATUS TOLAKAN',
            name: 'statustolakan',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            stype: 'select',
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['combotolakan'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['combotolakan'])) {
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
              if (!value) {
                return ''
              }
              let statusTolakan = JSON.parse(value)
              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusTolakan.WARNA}; color: #fff;">
                  <span>${statusTolakan.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              if (!rowObject.statustolakan) {
                return ` title=""`
              }
              let statusTolakan = JSON.parse(rowObject.statustolakan)
              return ` title="${statusTolakan.MEMO}"`
            }
          },
          {
            label: 'GUDANG SAMA',
            name: 'statusgudangsama',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            stype: 'select',
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['combogudangsama'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['combogudangsama'])) {
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
              let statusGudangSama = JSON.parse(value)
              if (!statusGudangSama) {
                return ''
              }
              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusGudangSama.WARNA}; color: #fff;">
                  <span>${statusGudangSama.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusGudangSama = JSON.parse(rowObject.statusgudangsama)
              if (!statusGudangSama) {
                return ` title=""`
              }
              return ` title="${statusGudangSama.MEMO}"`
            }
          },
          {
            label: 'BATAL MUAT',
            name: 'statusbatalmuat',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            stype: 'select',
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['combobatalmuat'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['combobatalmuat'])) {
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
              let statusBatalMuat = JSON.parse(value)
              if (!statusBatalMuat) {
                return ''
              }
              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusBatalMuat.WARNA}; color: #fff;">
                  <span>${statusBatalMuat.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusBatalMuat = JSON.parse(rowObject.statusbatalmuat)
              if (!statusBatalMuat) {
                return ` title=""`
              }
              return ` title="${statusBatalMuat.MEMO}"`
            }
          },
          {
            label: 'EDIT SURAT PENGANTAR',
            name: 'statusapprovaleditsuratpengantar',
            stype: 'select',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['comboeditsp'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['comboeditsp'])) {
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
              if (!value) {
                return ''
              }
              let statusEditSP = JSON.parse(value)
              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusEditSP.WARNA}; color: #fff;">
                  <span>${statusEditSP.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              if (!rowObject.statusapprovaleditsuratpengantar) {
                return ` title=""`
              }
              let statusEditSP = JSON.parse(rowObject.statusapprovaleditsuratpengantar)
              return ` title="${statusEditSP.MEMO}"`
            }
          },
          {
            label: 'TGL APP EDIT',
            name: 'tglapprovaleditsuratpengantar',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'USER APP EDIT',
            name: 'userapprovaleditsuratpengantar',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'TGL BATAS EDIT',
            name: 'tglbataseditsuratpengantar',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            align: 'right',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y H:i:s"
            }
          },
          {
            label: 'APPROVAL TITIPAN EMKL',
            name: 'statusapprovalbiayatitipanemkl',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            stype: 'select',
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['combotitipan'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['combotitipan'])) {
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
              if (!value) {
                return ''
              }
              let statusTitipan = JSON.parse(value)
              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusTitipan.WARNA}; color: #fff;">
                  <span>${statusTitipan.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              if (!rowObject.statusapprovalbiayatitipanemkl) {
                return ` title=""`
              }
              let statusTitipan = JSON.parse(rowObject.statusapprovalbiayatitipanemkl)
              return ` title="${statusTitipan.MEMO}"`
            }
          },
          {
            label: 'TGL APP TITIPAN EMKL',
            name: 'tglapprovalbiayatitipanemkl',
            align: 'left',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'USER APP TITIPAN EMKL',
            name: 'userapprovalbiayatitipanemkl',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'APP. BIAYA EXTRA',
            name: 'statusapprovalbiayaextra',
            stype: 'select',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['comboeditsp'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['comboeditsp'])) {
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
              if (!value) {
                return ''
              }
              let statusbiayaextra = JSON.parse(value)
              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusbiayaextra.WARNA}; color: #fff;">
                  <span>${statusbiayaextra.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              if (!rowObject.statusapprovalbiayaextra) {
                return ` title=""`
              }
              let statusbiayaextra = JSON.parse(rowObject.statusapprovalbiayaextra)
              return ` title="${statusbiayaextra.MEMO}"`
            }
          },
          {
            label: 'TGL APP B. EXTRA',
            name: 'tglapprovalbiayaextra',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'USER APP B. EXTRA',
            name: 'userapprovalbiayaextra',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'TGL BATAS B. EXTRA',
            name: 'tglbatasapprovalbiayaextra',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            align: 'right',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y H:i:s"
            }
          },
          {
            label: 'MODIFIED BY',
            name: 'modifiedby',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
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
        rowNum: rowNum,
        rownumbers: true,
        footerrow: true,
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
          activeGrid = grid
          indexRow = grid.jqGrid('getCell', id, 'rn') - 1
          page = grid.jqGrid('getGridParam', 'page')
          let limit = grid.jqGrid('getGridParam', 'postData').limit
          if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))

          loadDetailData(id)
          loadRekapCustData($('#tgldariheader').val(), $('#tglsampaiheader').val())
        },
        loadComplete: function(data) {
          changeJqGridRowListText()
          if (data.data.length === 0) {
            $('#detailGrid, #rekapCustGrid').each((index, element) => {
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
          $('#left-nav').find('button').attr('disabled', false)
          permission()
          $('#gs_').attr('disabled', false)
          getQueryParameter()
          setHighlight($(this))

          if (data.attributes) {
            $(this).jqGrid('footerData', 'set', {
              nobukti: 'Total:',
              jarak: data.attributes.totalJarak,
            }, true)
          }
        },
      })

      .jqGrid("setLabel", "rn", "No.")
      .jqGrid('filterToolbar', {
        stringResult: true,
        searchOnEnter: false,
        defaultSearch: 'cn',
        groupOp: 'AND',
        beforeSearch: function() {
          abortGridLastRequest($(this))
          $('#left-nav').find(`button:not(#add)`).attr('disabled', 'disabled')
          clearGlobalSearch($('#jqGrid'))
        }
      })

      .customPager({
        buttons: [{
            id: 'edit',
            innerHTML: '<i class="fa fa-pen"></i> EDIT',
            class: 'btn btn-success btn-sm mr-1',
            onClick: () => {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              rawCellValue = $("#jqGrid").jqGrid('getCell', selectedId, 'nobukti');
              celValue = $("<div>").html(rawCellValue).text();
              selectednobukti = celValue
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Harap pilih salah satu record')
              } else {
                cekValidasidelete(selectedId, 'EDIT', selectednobukti)
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
                cekValidasidelete(selectedId, 'DELETE', selectednobukti)
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
                viewSuratPengantar(selectedId)
              }
            }
          },
          {
            id: 'report',
            innerHTML: '<i class="fa fa-print"></i> REPORT',
            class: 'btn btn-info btn-sm mr-1',
            onClick: () => {
              $('#processingLoader').removeClass('d-none')
              $.ajax({
                url: `{{ route('suratpengantar.report') }}`,
                method: 'GET',
                data: {
                  limit: 0,
                  tgldari: $('#tgldariheader').val(),
                  tglsampai: $('#tglsampaiheader').val(),
                  filters: $('#jqGrid').jqGrid('getGridParam', 'postData').filters
                },
                success: function(response) {
                  $('#processingLoader').addClass('d-none')
                  // Handle the success response
                  var newWindow = window.open('', '_blank');
                  newWindow.document.open();
                  newWindow.document.write(response);
                  newWindow.document.close();
                },
                error: function(xhr, status, error) {

                  $('#processingLoader').addClass('d-none')
                  showDialog('TIDAK ADA DATA')
                }
              });
            }
          },
          {
            id: 'export',
            innerHTML: '<i class="fa fa-file-export"></i> EXPORT',
            class: 'btn btn-warning btn-sm mr-1',
            onClick: () => {
              $('#processingLoader').removeClass('d-none')
              $.ajax({
                // url: `{{ route('suratpengantar.export') }}`,
                url: `${apiUrl}suratpengantar/export`,
                type: 'GET',
                data: {
                  limit: 0,
                  tgldari: $('#tgldariheader').val(),
                  tglsampai: $('#tglsampaiheader').val(),
                  filters: $('#jqGrid').jqGrid('getGridParam', 'postData').filters,
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
                      link.download = `LAPORAN SURAT PENGANTAR ${new Date().getTime()}.xlsx`;
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
          },
        ],
        modalBtnList: [{
            id: 'approve',
            title: 'Approve',
            caption: 'Approve',
            innerHTML: '<i class="fa fa-check"></i> APPROVAL/UN',
            class: 'btn btn-purple btn-sm mr-1 ',
            item: [{
                id: 'approvalBatalMuat',
                text: "APPROVAL/UN Batal Muat",
                color: `<?php echo $data['listbtn']->btn->approvalbatalmuat; ?>`,
                hidden: (!`{{ $myAuth->hasPermission('suratpengantar', 'approvalBatalMuat') }}`),
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('suratpengantar', 'approvalBatalMuat') }}`) {
                    selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                    approvalBatalMuat(selectedId);
                  }
                }
              },
              {
                id: 'approvalEditTujuan',
                text: "APPROVAL/UN Edit Surat Pengantar",
                color: `<?php echo $data['listbtn']->btn->approvaledit; ?>`,
                hidden: (!`{{ $myAuth->hasPermission('suratpengantar', 'approvalEditTujuan') }}`),
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('suratpengantar', 'approvalEditTujuan') }}`) {
                    selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                    approvalEditTujuan(selectedId);
                  }
                }
              },
              {
                id: 'approvalTitipanEmkl',
                text: "APPROVAL/UN Titipan EMKL",
                color: `<?php echo $data['listbtn']->btn->approvaltitipanemkl; ?>`,
                hidden: (!`{{ $myAuth->hasPermission('suratpengantar', 'approvalTitipanEmkl') }}`),
                onClick: () => {
                  selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                  rawCellValue = $("#jqGrid").jqGrid('getCell', selectedId, 'nobukti');
                  celValue = $("<div>").html(rawCellValue).text();
                  selectednobukti = celValue
                  if (`{{ $myAuth->hasPermission('suratpengantar', 'approvalTitipanEmkl') }}`) {
                    approvalTitipanEmkl(selectedId, selectednobukti);
                  }
                }
              },
              {
                id: 'approvalTolakan',
                text: "APPROVAL/UN Tolakan",
                color: `<?php echo $data['listbtn']->btn->approvaltolakan; ?>`,
                hidden: (!`{{ $myAuth->hasPermission('suratpengantar', 'approvalTolakan') }}`),
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('suratpengantar', 'approvalTolakan') }}`) {
                    var selectedOne = selectedOnlyOne();
                    if (selectedOne[0]) {
                      approvalTolakan(selectedOne[1]);
                    } else {
                      showDialog(selectedOne[1])
                    }
                  }
                }
              },
              {
                id: 'approvalBiayaExtra',
                text: "APPROVAL/UN Biaya Extra",
                color: `<?php echo $data['listbtn']->btn->approvalbiayaextra; ?>`,
                hidden: (!`{{ $myAuth->hasPermission('suratpengantar', 'approvalBiayaExtra') }}`),
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('suratpengantar', 'approvalBiayaExtra') }}`) {
                    var selectedOne = selectedOnlyOne();
                    if (selectedOne[0]) {
                      approvalBiayaExtra(selectedOne[1]);
                    } else {
                      showDialog(selectedOne[1])
                    }
                  }
                }
              },
              {
                id: 'approvalGabungJobTrucking',
                text: "APPROVAL/UN Gabung Job Trucking",
                color: `<?php echo $data['listbtn']->btn->approvaledit; ?>`,
                hidden: (!`{{ $myAuth->hasPermission('suratpengantar', 'approvalGabungJobTrucking') }}`),
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('suratpengantar', 'approvalGabungJobTrucking') }}`) {
                    selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                    approvalGabungJobTrucking(selectedId);
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
            class: 'btn btn-secondary btn-sm mr-1  ',
            item: [{
              id: 'editSP',
              text: "Edit SP",
              hidden: (!`{{ $myAuth->hasPermission('suratpengantar', 'editSP') }}`),
              color: `<?php echo $data['listbtn']->btn->updatenocontainer; ?>`,
              onClick: () => {
                if (`{{ $myAuth->hasPermission('suratpengantar', 'editSP') }}`) {
                  createEditSp()
                }
              }
            }, {
              id: 'edit-trip-asal',
              text: "Edit Trip Asal",
              hidden: (!`{{ $myAuth->hasPermission('suratpengantar', 'editTripAsal') }}`),
              color: `<?php echo $data['listbtn']->btn->approvalbiayaextra; ?>`,
              onClick: () => {
                if (`{{ $myAuth->hasPermission('suratpengantar', 'editTripAsal') }}`) {
                  selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                  editTripAsal(selectedId);
                }
              }
            }]
          }
        ]


      })

    /* Append clear filter button */
    loadClearFilter($('#jqGrid'))

    /* Append global search */
    loadGlobalSearch($('#jqGrid'))

    $('#add .ui-pg-div')
      .addClass(`btn-sm btn-primary`)
      .parent().addClass('px-1')

    $('#edit .ui-pg-div')
      .addClass('btn-sm btn-success')
      .parent().addClass('px-1')

    $('#delete .ui-pg-div')
      .addClass('btn-sm btn-danger')
      .parent().addClass('px-1')

    $('#report .ui-pg-div')
      .addClass('btn-sm btn-info')
      .parent().addClass('px-1')

    $('#export .ui-pg-div')
      .addClass('btn-sm btn-warning')
      .parent().addClass('px-1')

    $('#rangeTglModal').on('shown.bs.modal', function() {
      initDatepicker()
      $('#formRangeTgl').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
      $('#formRangeTgl').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    })
    $('#formRangeTgl').submit(event => {
      event.preventDefault()

      let params
      let actionUrl = ``
      let submitButton = $(this).find('button:submit')

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

      let formRange = $('#formRangeTgl')
      let dari = formRange.find('[name=dari]').val()
      let sampai = formRange.find('[name=sampai]').val()
      params += `&dari=${dari}&sampai=${sampai}`

      getCekExport()
        .then((response) => {
          if ($('#formRangeTgl').data('action') == 'export') {
            let actionUrl = `{{ route('suratpengantar.export') }}`

            /* Clear validation messages */
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
            window.open(`${actionUrl}?${$('#formRangeTgl').serialize()}`)
          } else if ($('#formRangeTgl').data('action') == 'report') {
            window.open(`{{ route('suratpengantar.report') }}?${params}`)
          }
        })
    })

    function getCekExport() {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: `${apiUrl}suratpengantar/export`,
          dataType: "JSON",
          headers: {
            Authorization: `Bearer ${accessToken}`
          },
          data: {
            dari: $('#formRangeTgl').find('[name=dari]').val(),
            sampai: $('#formRangeTgl').find('[name=sampai]').val()
          },
          success: (response) => {
            resolve(response);
          },
          error: error => {
            reject(error)
          },
        });
      });
    }

    function permission() {
      if (!`{{ $myAuth->hasPermission('suratpengantar', 'store') }}`) {
        $('#add').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('suratpengantar', 'show') }}`) {
        $('#view').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('suratpengantar', 'update') }}`) {
        $('#edit').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('suratpengantar', 'destroy') }}`) {
        $('#delete').attr('disabled', 'disabled')
      }
      // if (!`{{ $myAuth->hasPermission('suratpengantar', 'approvalBatalMuat') }}`) {
      //   $('#approvalBatalMuat').attr('disabled', 'disabled')
      // }
      // if (!`{{ $myAuth->hasPermission('suratpengantar', 'approvalEditTujuan') }}`) {
      //   $('#approvalEditTujuan').attr('disabled', 'disabled')
      // }
      if (!`{{ $myAuth->hasPermission('suratpengantar', 'report') }}`) {
        $('#report').attr('disabled', 'disabled')
      }
      if (!`{{ $myAuth->hasPermission('suratpengantar', 'export') }}`) {
        $('#export').attr('disabled', 'disabled')
      }

      let hakApporveCount = 0;
      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('suratpengantar', 'approvalBatalMuat') }}`) {
        hakApporveCount--
        $('#approvalBatalMuat').hide()
        // $('#approval-buka-cetak').attr('disabled', 'disabled')
      }
      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('suratpengantar', 'approvalEditTujuan') }}`) {
        hakApporveCount--
        $('#approvalEditTujuan').hide()
        // $('#approval-buka-cetak').attr('disabled', 'disabled')
      }
      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('suratpengantar', 'approvalTitipanEmkl') }}`) {
        hakApporveCount--
        $('#approvalTitipanEmkl').hide()
        // $('#approval-buka-cetak').attr('disabled', 'disabled')
      }
      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('suratpengantar', 'approvalTolakan') }}`) {
        hakApporveCount--
        $('#approvalTolakan').hide()
        // $('#approval-buka-cetak').attr('disabled', 'disabled')
      }
      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('suratpengantar', 'approvalBiayaExtra') }}`) {
        hakApporveCount--
        $('#approvalBiayaExtra').hide()
        // $('#approval-buka-cetak').attr('disabled', 'disabled')
      }
      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('suratpengantar', 'approvalGabungJobTrucking') }}`) {
        hakApporveCount--
        $('#approvalGabungJobTrucking').hide()
        // $('#approval-buka-cetak').attr('disabled', 'disabled')
      }
      if (hakApporveCount < 1) {
        $('#approve').hide()
        // $('#approve').attr('disabled', 'disabled')
      }
      if (!`{{ $myAuth->hasPermission('suratpengantar', 'approvalBiayaTambahan') }}`) {
        $('#approvalbiayatambahan').attr('disabled', 'disabled')
      }
      let hakLainnyaCount = 0;
      hakLainnyaCount++
      if (!`{{ $myAuth->hasPermission('suratpengantar', 'editSP') }}`) {
        hakLainnyaCount--
        $('#editSP').hide()
      }
      hakLainnyaCount++
      if (!`{{ $myAuth->hasPermission('suratpengantar', 'editTripAsal') }}`) {
        hakLainnyaCount--
        $('#edit-trip-asal').hide()
      }
      if (hakLainnyaCount < 1) {
        // $('#approve').hide()
        $('#lainnya').hide()
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

    function approvalBatalMuat(id) {
      // getBatalMuat()
      // $.ajax({
      //   url: `${apiUrl}suratpengantar/${id}`,
      //   method: 'GET',
      //   dataType: 'JSON',
      //   headers: {
      //     Authorization: `Bearer ${accessToken}`
      //   },
      //   success: response => {
      //     let msg = `YAKIN Unapproval Batal Muat`
      //     console.log(statusBukanBatalMuat);
      //     if (response.data.statusbatalmuat === statusBukanBatalMuat) {
      //       msg = `YAKIN approval Batal Muat`
      //     }
      //     showConfirm(msg, response.data.nobukti, `suratpengantar/${response.data.id}/batalmuat`)
      //   },
      // })
      event.preventDefault()

      let form = $('#crudForm')
      $(this).attr('disabled', '')
      $('#processingLoader').removeClass('d-none')

      $.ajax({
        url: `${apiUrl}suratpengantar/batalmuat`,
        method: 'POST',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          Id: selectedbukti,
          table: 'surat pengantar'
        },
        success: response => {
          clearSelectedRows()
          $('#jqGrid').jqGrid().trigger('reloadGrid');
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

    function approvalEditTujuan(id) {
      event.preventDefault()

      let form = $('#crudForm')
      $(this).attr('disabled', '')
      $('#processingLoader').removeClass('d-none')

      $.ajax({
        url: `${apiUrl}suratpengantar/edittujuan`,
        method: 'POST',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          Id: selectedbukti,
          table: 'surat pengantar'
        },
        success: response => {
          clearSelectedRows()
          $('#jqGrid').jqGrid().trigger('reloadGrid');
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

    function approvalGabungJobTrucking(id) {
      event.preventDefault()

      let form = $('#crudForm')
      $(this).attr('disabled', '')
      $('#processingLoader').removeClass('d-none')

      $.ajax({
        url: `${apiUrl}suratpengantar/approvalgabungjobtrucking`,
        method: 'POST',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          Id: selectedbukti,
          table: 'surat pengantar'
        },
        success: response => {
          var error = response.error
          if (error) {
            showDialog(response)
            // showDialog(response.message['keterangan'])
          } else {
            selectedRows = []
            selectedbukti = []
            $('#gs_').prop('checked', false);
            console.log(response.nobukti)
            loadDataHeader('suratpengantar', {
              nobukti: response.nobukti,
              proses: 'reload',
              reload: true,
            })
          }

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


    function approvalTitipanEmkl(id, noBukti) {

      event.preventDefault()

      let form = $('#crudForm')
      $(this).attr('disabled', '')
      $('#processingLoader').removeClass('d-none')

      $.ajax({
        url: `${apiUrl}suratpengantar/titipanemkl`,
        method: 'POST',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          Id: selectedbukti,
          table: 'surat pengantar'
        },
        success: response => {
          clearSelectedRows()
          $('#jqGrid').jqGrid().trigger('reloadGrid');
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

    function approvalBiayaExtra(id) {
      event.preventDefault()

      let form = $('#crudForm')
      $(this).attr('disabled', '')
      $('#processingLoader').removeClass('d-none')

      $.ajax({
        url: `${apiUrl}suratpengantar/biayaextra`,
        method: 'POST',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          Id: selectedbukti,
          table: 'suratpengantar'
        },
        success: response => {
          clearSelectedRows()
          $('#jqGrid').jqGrid().trigger('reloadGrid');
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

    function getBatalMuat() {
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
              "data": "STATUS BATAL MUAT"
            }, {
              "field": "text",
              "op": "cn",
              "data": "BUKAN BATAL MUAT"
            }]
          })
        },
        success: response => {
          statusBukanBatalMuat = response.data[0].id;
        }
      })
    }

    function getEditTujuan() {
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
              "data": "STATUS APPROVAL"
            }, {
              "field": "text",
              "op": "cn",
              "data": "NON APPROVAL"
            }]
          })
        },
        success: response => {
          statusEditTujuan = response.data[0].id;
        }
      })
    }



    $('#formRange').submit(event => {
      event.preventDefault()

      let params
      let actionUrl = ``

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
  })

  function setIsKomisi() {
    $.ajax({
      url: `${apiUrl}parameter/getparamfirst`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        grp: 'SURAT PENGANTAR',
        subgrp: 'KOMISI'
      },
      success: response => {
        isKomisi = $.trim(response.text)
      }
    })
  }


  function setApprovalBiayaTambahan() {
    $.ajax({
      url: `${apiUrl}parameter/getparamfirst`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        grp: 'SURAT PENGANTAR BIAYA TAMBAHAN',
        subgrp: 'APPROVAL'
      },
      success: response => {
        isApprovalBiayaTambahan = $.trim(response.text)
        if (isApprovalBiayaTambahan == 'TIDAK') {

          $("#detailGrid").jqGrid("hideCol", '');
          $("#detailGrid").jqGrid("hideCol", 'statusapproval');
          $("#detailGrid").jqGrid("hideCol", 'userapproval');
          $("#detailGrid").jqGrid("hideCol", 'tglapproval');
          $("#approvalbiayatambahan").hide()
        }
      }
    })
  }
</script>
@endpush()
@endsection