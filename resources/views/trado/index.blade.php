@extends('layouts.master')

@section('content')
<!-- Grid -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <table id="jqGrid"></table>
    </div>
  </div>
</div>

@include('trado._modal')

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
  let sortname = 'keterangan'
  let sortorder = 'asc'
  let autoNumericElements = []
  let rowNum = 10

  $(document).ready(function() {
    $("#jqGrid").jqGrid({
        url: `${apiUrl}trado`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        colModel: [{
            label: 'ID',
            name: 'id',
            width: '50px'
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
          },
          {
            label: 'STATUS AKTIF',
            name: 'statusaktif',
            stype: 'select',
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['combo'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['combo'])) {
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
          },
          {
            label: 'KM AWAL',
            name: 'kmawal',
            align: 'right',
            formatter: 'currency',
            formatoptions: {
              decimalSeparator: ',',
              thousandsSeparator: '.'
            }
          },
          {
            label: 'KM GANTI OLI AKHIR',
            name: 'kmakhirgantioli',
            align: 'right',
            formatter: 'currency',
            formatoptions: {
              decimalSeparator: ',',
              thousandsSeparator: '.'
            }
          },
          {
            label: 'TGL ASURANSI MATI',
            name: 'tglasuransimati',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'MEREK',
            name: 'merek',
          },
          {
            label: 'NO RANGKA',
            name: 'norangka',
          },
          {
            label: 'NO MESIN',
            name: 'nomesin',
          },
          {
            label: 'NAMA',
            name: 'nama',
          },
          {
            label: 'NO STNK',
            name: 'nostnk',
          },
          {
            label: 'ALAMAT STNK',
            name: 'alamatstnk',
          },
          {
            label: 'MODIFIEDBY',
            name: 'modifiedby',
          },
          {
            label: 'UPDATEDAT',
            name: 'updated_at',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y H:i:s"
            }
          },
          {
            label: 'TGL SERVICE OPNAME',
            name: 'tglserviceopname',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'STATUS STANDARISASI',
            name: 'statusstandarisasi',
          },
          {
            label: 'KET PROGRESS STANDARISASI',
            name: 'keteranganprogressstandarisasi',
          },
          {
            label: 'JENIS PLAT',
            name: 'jenisplat',
          },
          {
            label: 'TGL PAJAK STNK',
            name: 'tglpajakstnk',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'TGL GANTI AKI AKHIR',
            name: 'tglgantiakiterakhir',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'STATUS MUTASI',
            name: 'statusmutasi',
          },
          {
            label: 'STATUS VALIDASI KEND',
            name: 'statusvalidasikendaraan',
          },
          {
            label: 'TIPE',
            name: 'tipe',
          },
          {
            label: 'JENIS',
            name: 'jenis',
          },
          {
            label: 'ISI SILINDER',
            name: 'isisilinder',
          },
          {
            label: 'WARNA',
            name: 'warna',
          },
          {
            label: 'BAHAN BAKAR',
            name: 'jenisbahanbakar',
          },
          {
            label: 'JLH SUMBU',
            name: 'jlhsumbu',
          },
          {
            label: 'JLH RODA',
            name: 'jlhroda',
          },
          {
            label: 'MODEL',
            name: 'model',
          },
          {
            label: 'BPKB',
            name: 'nobpkb',
          },
          {
            label: 'STATUS MOBIL STORING',
            name: 'statusmobilstoring',
          },
          {
            label: 'MANDOR',
            name: 'mandor_id',
          },
          {
            label: 'JLH BAN SERAP',
            name: 'jlhbanserap',
          },
          {
            label: 'STATUS BAN EDIT',
            name: 'statusappeditban',
          },
          {
            label: 'STATUS LEWAT VALIDASI',
            name: 'statuslewatvalidasi',
          },
          {
            label: 'PHOTO STNK',
            name: 'photostnk',
            align: 'center',
            search: false
          },
          {
            label: 'PHOTO BPKB',
            name: 'photobpkb',
            align: 'center',
            search: false
          },
          {
            label: 'PHOTO TRADO',
            name: 'phototrado',
            align: 'center',
            search: false
          },
        ],
        autowidth: true,
        shrinkToFit: false,
        height: 350,
        rowNum: 10,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [10, 20, 50],
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
        loadBeforeSend: (jqXHR) => {
          jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)
        },
        onSelectRow: function(id) {
          activeGrid = $(this)
          indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
          page = $(this).jqGrid('getGridParam', 'page')
          let limit = $(this).jqGrid('getGridParam', 'postData').limit
          if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))
        },
        loadComplete: function(data) {
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
            clearColumnSearch()
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

          setHighlight($(this))
        }
      })

      .jqGrid('filterToolbar', {
        stringResult: true,
        searchOnEnter: false,
        defaultSearch: 'cn',
        groupOp: 'AND',
        disabledKeys: [17, 33, 34, 35, 36, 37, 38, 39, 40],
        beforeSearch: function() {
          clearGlobalSearch($('#jqGrid'))
        },
      })

      .customPager({
        buttons: [{
            id: 'add',
            innerHTML: '<i class="fa fa-plus"></i> ADD',
            class: 'btn btn-primary btn-sm mr-1',
            onClick: () => {
              createTrado()
            }
          },
          {
            id: 'edit',
            innerHTML: '<i class="fa fa-pen"></i> EDIT',
            class: 'btn btn-success btn-sm mr-1',
            onClick: () => {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

              editTrado(selectedId)
            }
          },
          {
            id: 'delete',
            innerHTML: '<i class="fa fa-trash"></i> DELETE',
            class: 'btn btn-danger btn-sm mr-1',
            onClick: () => {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

              deleteTrado(selectedId)
            }
          },
        ]
      })

    /* Append clear filter button */
    loadClearFilter($('#jqGrid'))

    /* Append global search */
    loadGlobalSearch($('#jqGrid'))
  })
</script>
@endpush()
@endsection