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
  let isKomisi;
  let isApprovalBiayaTambahan;

  $(document).ready(function() {
    $("#tabs").tabs()
    setIsKomisi()
    setApprovalBiayaTambahan()
    loadDetailGrid()
    loadRekapCustGrid($('#tgldariheader').val(), $('#tglsampaiheader').val())
    @isset($request['tgldari'])
    tgldariheader = `{{ $request['tgldari'] }}`;
    @endisset
    @isset($request['tglsampai'])
    tglsampaiheader = `{{ $request['tglsampai'] }}`;
    @endisset
    setRange(false, tgldariheader, tglsampaiheader)
    initDatepicker('datepickerIndex')
    $(document).on('click', '#btnReload', function(event) {
      loadDataHeader('suratpengantar')
    })

    $("#jqGrid").jqGrid({
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
            label: 'INVOICE NO BUKTI',
            name: 'invoice_nobukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
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
        onSelectRow: function(id) {
          activeGrid = $(this)
          indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
          page = $(this).jqGrid('getGridParam', 'page')
          let limit = $(this).jqGrid('getGridParam', 'postData').limit
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
              $('#formRangeTgl').data('action', 'report')
              $('#rangeTglModal').find('button:submit').html(`Report`)
              $('#rangeTglModal').modal('show')
            }
          },
          {
            id: 'export',
            innerHTML: '<i class="fa fa-file-export"></i> EXPORT',
            class: 'btn btn-warning btn-sm mr-1',
            onClick: () => {
              $('#formRangeTgl').data('action', 'export')
              $('#rangeTglModal').find('button:submit').html(`Export`)
              $('#rangeTglModal').modal('show')
            }
          },
        ],
        extndBtn: [{
          id: 'approve',
          title: 'Approve',
          caption: 'Approve',
          innerHTML: '<i class="fa fa-check"></i> UN/APPROVAL',
          class: 'btn btn-purple btn-sm mr-1 dropdown-toggle ',
          dropmenuHTML: [{
              id: 'approvalBatalMuat',
              text: "un/Approval Batal Muat",
              onClick: () => {
                if (`{{ $myAuth->hasPermission('suratpengantar', 'approvalBatalMuat') }}`) {
                  selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                  approvalBatalMuat(selectedId);
                }
              }
            },
            {
              id: 'approvalEditTujuan',
              text: "un/Approval Edit Surat Pengantar",
              onClick: () => {
                if (`{{ $myAuth->hasPermission('suratpengantar', 'approvalEditTujuan') }}`) {
                  selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                  approvalEditTujuan(selectedId);
                }
              }
            },
            {
              id: 'approvalTitipanEmkl',
              text: "un/Approval Titipan EMKL",
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
          ],
        }]


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

    function approvalBatalMuat(id) {
      getBatalMuat()
      $.ajax({
        url: `${apiUrl}suratpengantar/${id}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          let msg = `YAKIN Unapproval Batal Muat`
          console.log(statusBukanBatalMuat);
          if (response.data.statusbatalmuat === statusBukanBatalMuat) {
            msg = `YAKIN approval Batal Muat`
          }
          showConfirm(msg, response.data.nobukti, `suratpengantar/${response.data.id}/batalmuat`)
        },
      })
    }

    function approvalEditTujuan(id) {
      getEditTujuan()
      $.ajax({
        url: `${apiUrl}suratpengantar/${id}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          let msg = `YAKIN Unapproval Edit Surat Pengantar`
          console.log(statusEditTujuan, response.data.statusapprovaleditsuratpengantar);
          if (response.data.statusapprovaleditsuratpengantar === statusEditTujuan) {
            msg = `YAKIN approval Edit Surat Pengantar`
          }
          showConfirm(msg, response.data.nobukti, `suratpengantar/${response.data.id}/edittujuan`)
        },
      })
    }

    function approvalTitipanEmkl(id, noBukti) {
      getEditTujuan()
      $.ajax({
        url: `${apiUrl}suratpengantar/${id}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          let msg = `YAKIN Unapproval Titipan EMKL`
          console.log(statusEditTujuan, response.data.statusapprovalbiayatitipanemkl);
          if (response.data.statusapprovalbiayatitipanemkl === statusEditTujuan) {
            msg = `YAKIN approval Titipan EMKL`
          }
          showConfirm(msg, noBukti, `suratpengantar/titipanemkl?nobukti=${noBukti}`)
        },
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