<table id="tradoLookup" class="lookup-grid"></table>
<div id="tradoLookupPager"></div>

@push('scripts')
<script>
  $('#tradoLookup').jqGrid({
      url: `{{ config('app.api_url') . 'trado' }}`,
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
          name: 'statusjenisplat',
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
        },
        {
          label: 'STATUS LEWAT VALIDASI',
          name: 'statuslewatvalidasi',
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
      responsive: true,
      shrinkToFit: false,
      height: 450,
      rowNum: 10,
      rownumbers: true,
      toolbar: [true, "top"],
      rownumWidth: 45,
      rowList: [10, 20, 50],
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      toolbar: [true, "top"],
      page: 1,
      pager: $('#tradoLookupPager'),
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
      onSelectRow: function(id) {
        activeGrid = $(this)
        id = $(this).jqGrid('getCell', id, 'rn') - 1
        indexRow = id
        page = $(this).jqGrid('getGridParam', 'page')
        let rows = $(this).jqGrid('getGridParam', 'postData').limit
        if (indexRow >= rows) indexRow = (indexRow - rows * (page - 1))
      },
      loadBeforeSend: (jqXHR) => {
        jqXHR.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      loadComplete: function(data) {
        if (detectDeviceType() == 'desktop') {
          $(document).unbind('keydown')
          setCustomBindKeys($(this))

          if (indexRow - 1 > $('#tradoLookup').getGridParam().reccount) {
            indexRow = $('#tradoLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#tradoLookup [id="${$('#tradoLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#tradoLookup [id="${$('#tradoLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#tradoLookup').getDataIDs()[indexRow] == undefined) {
              $(`#tradoLookup [id="` + $('#tradoLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#tradoLookup').setSelection($('#tradoLookup').getDataIDs()[indexRow])
          }
        }

        /* Set global variables */
        sortname = $(this).jqGrid("getGridParam", "sortname")
        sortorder = $(this).jqGrid("getGridParam", "sortorder")
        totalRecord = $(this).getGridParam("records")
        limit = $(this).jqGrid('getGridParam', 'postData').limit
        postData = $(this).jqGrid('getGridParam', 'postData')

        $('.clearsearchclass').click(function() {
          clearColumnSearch()
        })

        $(this).setGridWidth($('#lookupTrado').prev().width())
        setHighlight($(this))
      }
    })

    .jqGrid('filterToolbar', {
      stringResult: true,
      searchOnEnter: false,
      defaultSearch: 'cn',
      groupOp: 'AND',
      disabledKeys: [16, 17, 18, 33, 34, 35, 36, 37, 38, 39, 40],
      beforeSearch: function() {
        clearGlobalSearch($('#tradoLookup'))
      },
    })

  loadGlobalSearch($('#tradoLookup'))
  loadClearFilter($('#tradoLookup'))
</script>