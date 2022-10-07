<table id="supirLookup" class="lookup-grid"></table>
<div id="supirLookupPager"></div>

@push('scripts')
<script>
 $('#supirLookup').jqGrid({
      url: `{{ config('app.api_url') . 'supir' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '70px'
        },
        {
          label: 'NAMA',
          name: 'namasupir',
          align: 'left',
        },
        {
          label: 'TGL LAHIR',
          name: 'tgllahir',
          formatter: "date",
          formatoptions: { srcformat: "ISO8601Long", newformat: "d-m-Y" }
        },
        {
          label: 'ALAMAT',
          name: 'alamat',
          align: 'left'
        },
        {
          label: 'KOTA',
          name: 'kota',
          align: 'left'
        },
        {
          label: 'TELP',
          name: 'telp',
          align: 'left'
        },
        {
            label: 'STATUS AKTIF',
            name: 'statusaktif',
            align: 'left',
        },
        {
            label: 'NOMINAL DEPOSIT',
            name: 'nominaldepositsa',
          },
          {
            label: 'NOM PINJ SALDO AWAL',
            name: 'nominalpinjamansaldoawal',
          },
          {
            label: 'SUPIR LAMA',
            name: 'supirold_id',
          },
          {
            label: 'SIM',
            name: 'nosim',
          },
          {
            label: 'TGL EXP SIM',
            name: 'tglexpsim',
            formatter: "date",
            formatoptions: { srcformat: "ISO8601Long", newformat: "d-m-Y" }
          },
          {
            label: 'TGL TERBIT SIM',
            name: 'tglterbitsim',
            formatter: "date",
            formatoptions: { srcformat: "ISO8601Long", newformat: "d-m-Y" }
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
          },
          {
            label: 'KTP',
            name: 'noktp',
          },
          {
            label: 'KK',
            name: 'nokk',
          },
          {
            label: 'STATUS ADA UPDATE GBR',
            name: 'statusadaupdategambar',
          },
          {
            label: 'STATUS LUAR KOTA',
            name: 'statusluarkota',
          },
          {
            label: 'ZONA TERTENTU',
            name: 'statuszonatertentu',
          },
          {
            label: 'ZONA',
            name: 'zona_id',
          },
          {
            label: 'angsuranpinjaman',
            name: 'angsuranpinjaman',
          },
          {
            label: 'plafondeposito',
            name: 'plafondeposito',
          },
          {
            label: 'PHOTO SUPIR',
            name: 'photosupir',
            align: 'center'
          },
          {
            label: 'PHOTO KTP',
            name: 'photoktp',
            align: 'center'
          },
          {
            label: 'PHOTO SIM',
            name: 'photosim',
            align: 'center'
          },
          {
            label: 'PHOTO KK',
            name: 'photokk',
            align: 'center'
          },
          {
            label: 'PHOTO SKCK',
            name: 'photoskck',
          },
          {
            label: 'PHOTO DOMISILI',
            name: 'photodomisili',
          },
          {
            label: 'TGL BERHENTI SUPIR',
            name: 'tglberhentisupir',
            formatter: "date",
            formatoptions: { srcformat: "ISO8601Long", newformat: "d-m-Y" }
          },
          {
            label: 'KET RESIGN',
            name: 'keteranganresign',
          },
          {
            label: 'STATUS BLACKLIST',
            name: 'statusblacklist',
          },
        {
          label: 'MODIFIEDBY',
          name: 'modifiedby',
          align: 'left'
        },
        {
          label: 'UPDATEDAT',
          name: 'updated_at',
          align: 'right'
        }, {
          label: 'CREATEDAT',
          name: 'created_at',
          align: 'right'
        },
      ],
      autowidth: true,
      responsive: true,
      shrinkToFit: false,
      height: 350,
      rowNum: 10,
      rownumbers: true,
      rownumWidth: 45,
      rowList: [10, 20, 50],
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      page: 1,
      pager: $('#supirLookupPager'),
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
          initResize($(this))

          if (indexRow - 1 > $('#supirLookup').getGridParam().reccount) {
            indexRow = $('#supirLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#supirLookup [id="${$('#supirLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#supirLookup [id="${$('#supirLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#supirLookup').getDataIDs()[indexRow] == undefined) {
              $(`#supirLookup [id="` + $('#supirLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#supirLookup').setSelection($('#supirLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookupSupir').prev().width())
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
        clearGlobalSearch($('#supirLookup'))
      },
    })

  loadGlobalSearch($('#supirLookup'))
  loadClearFilter($('#supirLookup'))
</script>
