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
  let indexUrl = "{{ route('trado.index') }}"
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
            width: '50px',
            hidden: true
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
          },
          {
            label: 'KODE TRADO',
            name: 'kodetrado',
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
            formatter: (value, options, rowData) => {
              let statusAktif = JSON.parse(value)

              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusAktif.WARNA}; color: #fff;">
                  <span>${statusAktif.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusAktif = JSON.parse(rowObject.statusaktif)

              return ` title="${statusAktif.MEMO}"`
            }
          },
          {
            label: 'KM AWAL',
            name: 'kmawal',
            align: 'right',
            formatter: 'currency',
            formatoptions: {
              decimalSeparator: '.',
              thousandsSeparator: ','
            }
          },
          {
            label: 'KM GANTI OLI AKHIR',
            name: 'kmakhirgantioli',
            align: 'right',
            formatter: 'currency',
            formatoptions: {
              decimalSeparator: '.',
              thousandsSeparator: ','
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
            label: 'NO. RANGKA',
            name: 'norangka',
          },
          {
            label: 'NO. MESIN',
            name: 'nomesin',
          },
          {
            label: 'NAMA',
            name: 'nama',
          },
          {
            label: 'NO. STNK',
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
            formatter: (value, options, rowData) => {
              let statusStandarisasi = JSON.parse(value)

              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusStandarisasi.WARNA}; color: #fff;">
                  <span>${statusStandarisasi.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusStandarisasi = JSON.parse(rowObject.statusstandarisasi)

              return ` title="${statusStandarisasi.MEMO}"`
            }
          },
          {
            label: 'KET. PROGRESS STANDARISASI',
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
            formatter: (value, options, rowData) => {
              let statusJenisPlat = JSON.parse(value)

              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusJenisPlat.WARNA}; color: #fff;">
                  <span>${statusJenisPlat.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusJenisPlat = JSON.parse(rowObject.statusjenisplat)

              return ` title="${statusJenisPlat.MEMO}"`
            }
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
            formatter: (value, options, rowData) => {
              let statusMutasi = JSON.parse(value)

              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusMutasi.WARNA}; color: #fff;">
                  <span>${statusMutasi.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusMutasi = JSON.parse(rowObject.statusmutasi)

              return ` title="${statusMutasi.MEMO}"`
            }
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
            formatter: (value, options, rowData) => {
              let statusValKendaraan = JSON.parse(value)

              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusValKendaraan.WARNA}; color: #fff;">
                  <span>${statusValKendaraan.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusValKendaraan = JSON.parse(rowObject.statusvalidasikendaraan)

              return ` title="${statusValKendaraan.MEMO}"`
            }
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
            formatter: (value, options, rowData) => {
              let statusMobilStoring = JSON.parse(value)

              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusMobilStoring.WARNA}; color: #fff;">
                  <span>${statusMobilStoring.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusMobilStoring = JSON.parse(rowObject.statusmobilstoring)

              return ` title="${statusMobilStoring.MEMO}"`
            }
          },
          {
            label: 'MANDOR',
            name: 'mandor_id',
          },
          {
            label: 'SUPIR',
            name: 'supir_id',
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
            formatter: (value, options, rowData) => {
              let statusAppEditBan = JSON.parse(value)

              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusAppEditBan.WARNA}; color: #fff;">
                  <span>${statusAppEditBan.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusAppEditBan = JSON.parse(rowObject.statusappeditban)

              return ` title="${statusAppEditBan.MEMO}"`
            }
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
            formatter: (value, options, rowData) => {
              let statusLewatValidasi = JSON.parse(value)

              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusLewatValidasi.WARNA}; color: #fff;">
                  <span>${statusLewatValidasi.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusLewatValidasi = JSON.parse(rowObject.statuslewatvalidasi)

              return ` title="${statusLewatValidasi.MEMO}"`
            }
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
        rowNum: rowNum,
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
              $(`[id="${$('#jqGrid').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`[id="${$('#jqGrid').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#jqGrid').getDataIDs()[indexRow] == undefined) {
              $(`[id="` + $('#jqGrid').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#jqGrid').setSelection($('#jqGrid').getDataIDs()[indexRow])
          }

          setHighlight($(this))
        },
      })

      .jqGrid("setLabel", "rn", "No.")
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
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Harap pilih salah satu record')
              } else {
                cekValidasidelete(selectedId)
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
        digitGroupSeparator: '.',
        decimalCharacter: ',',
        allowDecimalPadding: false,
        minimumValue: 1,
        maximumValue: totalRecord
      })
    })

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
</script>
@endpush()
@endsection