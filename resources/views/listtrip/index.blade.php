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

@include('listtrip._modal')
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
  let selectedRows = [];

  function checkboxHandler(element) {
    let value = $(element).val();
    if (element.checked) {
      selectedRows.push($(element).val())
    } else {
      for (var i = 0; i < selectedRows.length; i++) {
        if (selectedRows[i] == value) {
          selectedRows.splice(i, 1);
        }
      }
    }
  }

  $(document).ready(function() {
    let indexUrl = `${apiUrl}listtrip`

    setRange()
    initDatepicker('datepickerIndex')
    $(document).on('click', '#btnReload', function(event) {
      loadDataHeader('listtrip')
    })

    $("#jqGrid").jqGrid({
        url: `${apiUrl}listtrip`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        postData: {
          tgldari: $('#tgldariheader').val(),
          tglsampai: $('#tglsampaiheader').val()
        },
        datatype: "json",
        colModel: [{
            label: 'ID',
            name: 'id',
            align: 'right',
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
            label: 'NO BUKTI',
            name: 'nobukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'TGL BUKTI',
            name: 'tglbukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
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
            label: 'SHIPPER',
            name: 'pelanggan_id',
            width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1
          },
          {
            label: 'CONTAINER',
            name: 'container_id',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3
          },          
          {
            label: 'STATUS CONTAINER',
            name: 'statuscontainer_id',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4
          },
          {
            label: 'TRADO',
            name: 'trado_id',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3
          },
          {
            label: 'GANDENGAN',
            name: 'gandengan_id',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4
          },
          {
            label: 'SUPIR',
            name: 'supir_id',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
            width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1
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
            label: 'LOKASI BONGKAR MUAT',
            name: 'tarif_id',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          },
          {
            label: 'MODIFIED BY',
            name: 'modifiedby',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
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
        rowNum: rowNum,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [10, 20, 50, 0],
        toolbar: [true, "top"],
        sortable: true,
        sortname: sortname,
        sortorder: sortorder,
        page: page,
        pager: pager,
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
        },
        loadComplete: function(data) {
          changeJqGridRowListText()
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
          permission()
          setHighlight($(this))
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
              viewTrip(selectedId)
            }
          },
        ]
      })




    /* Append clear filter button */
    loadClearFilter($('#jqGrid'))

    /* Append global search */
    loadGlobalSearch($('#jqGrid'))

    function permission() {
      if (!`{{ $myAuth->hasPermission('listtrip', 'update') }}`) {
        $('#edit').attr('disabled', 'disabled')
      }
      
      if (!`{{ $myAuth->hasPermission('listtrip', 'destroy') }}`) {
        $('#delete').attr('disabled', 'disabled')
      }
    }

  })
</script>
@endpush()
@endsection