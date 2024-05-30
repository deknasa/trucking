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
</div>

<div class="container-fluid my-4">
  <div class="row">
    <div class="col-12">
      <table id="detailGrid"></table>
    </div>
  </div>
</div>


@include('biayatambahan._tambahan')

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
  let isKomisi;
  let isApprovalBiayaTambahan;
  let selectedRows = [];

  function checkboxHandler(element) {
    let value = $(element).val();
    var onSelectRowExisting = $("#jqGrid").jqGrid('getGridParam', 'onSelectRow');
    $("#jqGrid").jqGrid('setSelection', value, false);
    onSelectRowExisting(value)

    if (element.checked) {
      selectedRows.push($(element).val())
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
    }
  }

  function clearSelectedRows() {
    selectedRows = []
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
        biayatambahan: true,
        filters: $('#jqGrid').jqGrid('getGridParam', 'postData').filters
      },
      success: (response) => {
        selectedRows = response.data.map((suratpengantar) => suratpengantar.id)
        $('#jqGrid').trigger('reloadGrid')
      }
    })
  }

  setSpaceBarCheckedHandler()
  $(document).ready(function() {

    setRange(false, tgldariheader, tglsampaiheader)
    loadDetailGrid()
    initDatepicker('datepickerIndex')
    $(document).on('click', '#btnReload', function(event) {
      loadDataHeader('suratpengantar', {
        biayatambahan: true
      })
      selectedRows = []
      $('#gs_').prop('checked', false)
    })
    var grid = $("#jqGrid");
    grid.jqGrid({

        // $("#jqGrid").jqGrid({
        url: `${apiUrl}suratpengantar`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        postData: {
          tgldari: $('#tgldariheader').val(),
          tglsampai: $('#tglsampaiheader').val(),
          biayatambahan: true,
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
            label: 'STATUS APPROVAL',
            name: 'statusapproval',
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
              let statusApprovalBiayaTambahan = JSON.parse(value)
              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusApprovalBiayaTambahan.WARNA}; color: #fff;">
                  <span>${statusApprovalBiayaTambahan.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              if (!rowObject.statusapproval) {
                return ` title=""`
              }
              let statusApprovalBiayaTambahan = JSON.parse(rowObject.statusapproval)
              return ` title="${statusApprovalBiayaTambahan.MEMO}"`
            }
          },
          {
            label: 'NO TRIP',
            name: 'nobukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'KETERANGAN EXTRA',
            name: 'ketextra',
            width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
          },
          {
            label: 'BIAYA EXT. SUPIR',
            name: 'biayaextra',
            align: 'right',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            formatter: currencyFormat,
          },
          {
            label: 'KETERANGAN EXTRA TAGIH',
            name: 'ketextratagih',
            width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
          },
          {
            label: 'TAGIH KE EMKL',
            name: 'biayatagih',
            align: 'right',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            formatter: currencyFormat,
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
            label: 'LOKASI BONGKAR MUAT',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            name: 'tarif_id',

          },
          {
            label: 'GAJI SUPIR NO BUKTI',
            name: 'gajisupir_nobukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
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
            label: 'JOB TRUCKING',
            name: 'jobtrucking',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
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
        onSelectRow: onSelectRowFunction =function(id) {

        // onSelectRow: function(id) {
          activeGrid = grid
          indexRow = grid.jqGrid('getCell', id, 'rn') - 1
          page = grid.jqGrid('getGridParam', 'page')
          let limit = grid.jqGrid('getGridParam', 'postData').limit
          if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))

          loadDetailData(id)
          // loadRekapCustData($('#tgldariheader').val(), $('#tglsampaiheader').val())
        },
        loadComplete: function(data) {
          changeJqGridRowListText()
          if (data.data.length === 0) {
            $('#detailGrid').each((index, element) => {
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
          id: 'approveun',
          innerHTML: '<i class="fas fa-check"></i> APPROVAL/UN',
          class: 'btn btn-purple btn-sm mr-1',
          onClick: () => {

            approveBiayaTambahan()

          }
        }, ],


      })

    /* Append clear filter button */
    loadClearFilter($('#jqGrid'))

    /* Append global search */
    loadGlobalSearch($('#jqGrid'))


    function permission() {
      if (!`{{ $myAuth->hasPermission('suratpengantarbiayatambahan', 'approval') }}`) {
        $('#approveun').attr('disabled', 'disabled')
      }
    }
  })


  function approveBiayaTambahan() {
    event.preventDefault()
    $.ajax({
      url: `${apiUrl}suratpengantarbiayatambahan/approval`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        id: selectedRows
      },
      success: response => {
        $('#crudForm').trigger('reset')
        $('#crudModal').modal('hide')
        selectedRows = []
        $('#jqGrid').jqGrid().trigger('reloadGrid');
      },
      error: error => {
        if (error.status === 422) {
          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()

          setErrorMessages($('#crudForm'), error.responseJSON.errors);
        } else {
          showDialog(error.responseJSON)
        }
      },
    }).always(() => {
      $('#processingLoader').addClass('d-none')
      $(this).removeAttr('disabled')
    })
  }
</script>
@endpush()
@endsection