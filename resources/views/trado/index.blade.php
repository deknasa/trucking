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
  let page = 1;
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

                      foreach ($data['statusaktif'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['statusaktif'])) {
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
            label: 'CREATEDAT',
            name: 'created_at',
            align: 'right',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y H:i:s"
            }
          },
          {
            label: 'UPDATEDAT',
            name: 'updated_at',
            align: 'right',
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
            stype: 'select',
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['statusstandarisasi'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['statusstandarisasi'])) {
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
            label: 'KET PROGRESS STANDARISASI',
            name: 'keteranganprogressstandarisasi',
          },
          {
            label: 'JENIS PLAT',
            name: 'statusjenisplat',
            stype: 'select',
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['statusjenisplat'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['statusjenisplat'])) {
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
            stype: 'select',
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['statusmutasi'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['statusmutasi'])) {
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
            label: 'STATUS VALIDASI KEND',
            name: 'statusvalidasikendaraan',
            stype: 'select',
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['statusvalidasikendaraan'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['statusvalidasikendaraan'])) {
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
            name: 'jumlahsumbu',
          },
          {
            label: 'JLH RODA',
            name: 'jumlahroda',
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
            stype: 'select',
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['statusmobilstoring'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['statusmobilstoring'])) {
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
            label: 'MANDOR',
            name: 'mandor_id',
          },
          {
            label: 'JLH BAN SERAP',
            name: 'jumlahbanserap',
          },
          {
            label: 'STATUS BAN EDIT',
            name: 'statusappeditban',
            stype: 'select',
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['statusappeditban'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['statusappeditban'])) {
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
            label: 'STATUS LEWAT VALIDASI',
            name: 'statuslewatvalidasi',
            stype: 'select',
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['statuslewatvalidasi'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['statuslewatvalidasi'])) {
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
            label: 'PHOTO STNK',
            name: 'photostnk',
            align: 'center',
            search: false,
            formatter: (value, row) => {
              let images = []

              if (value) {
                let files = JSON.parse(value)

                files.forEach(file => {
                  let image = new Image()
                  image.width = 25
                  image.height = 25
                  image.src = `${apiUrl}trado/image/stnk/${file}/small`

                  images.push(image.outerHTML)
                });

                return images.join(' ')
              }

              return 'NO PHOTOS'
            }
          },
          {
            label: 'PHOTO BPKB',
            name: 'photobpkb',
            align: 'center',
            search: false,
            formatter: (value, row) => {
              let images = []

              if (value) {
                let files = JSON.parse(value)

                files.forEach(file => {
                  let image = new Image()
                  image.width = 25
                  image.height = 25
                  image.src = `${apiUrl}trado/image/bpkb/${file}/small`

                  images.push(image.outerHTML)
                });

                return images.join(' ')
              }

              return 'NO PHOTOS'
            }
          },
          {
            label: 'PHOTO TRADO',
            name: 'phototrado',
            align: 'center',
            search: false,
            formatter: (value, row) => {
              let images = []

              if (value) {
                let files = JSON.parse(value)

                files.forEach(file => {
                  let image = new Image()
                  image.width = 25
                  image.height = 25
                  image.src = `${apiUrl}trado/image/trado/${file}/small`

                  images.push(image.outerHTML)
                });

                return images.join(' ')
              }

              return 'NO PHOTOS'
            }
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
        beforeSearch: function() {
          clearGlobalSearch($('#jqGrid'))
        }
      })

      .customPager({
        buttons: [{
            id: 'add',
            innerHTML: '<i class="fa fa-plus"></i> ADD',
            class: 'btn btn-primary btn-sm mr-1',
            onClick: function(event) {
              createTrado()
            }
          },
          {
            id: 'edit',
            innerHTML: '<i class="fa fa-pen"></i> EDIT',
            class: 'btn btn-success btn-sm mr-1',
            onClick: function(event) {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Please select a row')
              } else {
                editTrado(selectedId)
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
                showDialog('Please select a row')
              } else {
                deleteTrado(selectedId)
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

    if (!`{{ $myAuth->hasPermission('trado', 'store') }}`) {
      $('#add').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('trado', 'update') }}`) {
      $('#edit').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('trado', 'destroy') }}`) {
      $('#delete').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('trado', 'export') }}`) {
      $('#export').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('trado', 'report') }}`) {
      $('#report').attr('disabled', 'disabled')
    }
  })
</script>
@endpush()
@endsection