<table id="pelangganLookup" class="lookup-grid"></table>
<div id="pelangganLookupPager"></div>

@push('scripts')
<script>
   $('#pelangganLookup').jqGrid({
      url: `{{ config('app.api_url') . 'pelanggan' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '70px',
          hidden: true
        },
        {
          label: 'KODE PELANGGAN',
          name: 'kodepelanggan',
          align: 'left',
        },
        {
          label: 'NAMA PELANGGAN',
          name: 'namapelanggan',
          align: 'left'
        },
        {
          label: 'TELP',
          name: 'telp',
          align: 'left'
        },
        {
          label: 'ALAMAT',
          name: 'alamat',
          align: 'left'
        },
        {
          label: 'ALAMAT 2',
          name: 'alamat2',
          align: 'left'
        },
        {
          label: 'KOTA',
          name: 'kota',
          align: 'left'
        },
        {
          label: 'KODE POS',
          name: 'kodepos',
          align: 'left'
        },
        {
          label: 'KETERANGAN',
          name: 'keterangan',
          align: 'left'
        },
        
        {
          label: 'MODIFIEDBY',
          name: 'modifiedby',
          align: 'left'
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
      ],
      autowidth: true,
      responsive: true,
      shrinkToFit: false,
      height: 450,
      rowNum: 10,
      toolbar: [true, "top"],
      rownumbers: true,
      rownumWidth: 45,
      rowList: [10, 20, 50],
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      page: 1,
      pager: $('#pelangganLookupPager'),
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

          if (indexRow - 1 > $('#pelangganLookup').getGridParam().reccount) {
            indexRow = $('#pelangganLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#pelangganLookup [id="${$('#pelangganLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#pelangganLookup [id="${$('#pelangganLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#pelangganLookup').getDataIDs()[indexRow] == undefined) {
              $(`#pelangganLookup [id="` + $('#pelangganLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#pelangganLookup').setSelection($('#pelangganLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookupPelanggan').prev().width())
        setHighlight($(this))
      }
    })

    .jqGrid("setLabel", "rn", "No.")
    .jqGrid('filterToolbar', {
      stringResult: true,
      searchOnEnter: false,
      defaultSearch: 'cn',
      groupOp: 'AND',
      disabledKeys: [16, 17, 18, 33, 34, 35, 36, 37, 38, 39, 40],
      beforeSearch: function() {
        clearGlobalSearch($('#pelangganLookup'))
      },
    })
    loadGlobalSearch($('#pelangganLookup'))
    loadClearFilter($('#pelangganLookup'))
</script>
