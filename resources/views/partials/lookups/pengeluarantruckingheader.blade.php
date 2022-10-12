<table id="pengeluaranTruckingHeaderLookup" style="width: 100%;"></table>
<div id="pengeluaranTruckingHeaderLookupPager"></div>

@push('scripts')
<script>
  let pengeluaranTruckingHeaderLookup = $('#pengeluaranTruckingHeaderLookup').jqGrid({
    url: `{{ config('app.api_url') . 'pengeluarantruckingheader' }}`,
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
        label: 'NO BUKTI',
        name: 'nobukti',
        align: 'left',
      },
      {
        label: 'TANGGAL BUKTI',
        name: 'tglbukti',
        align: 'left',
        formatter: "date",
        formatoptions: {
          srcformat: "ISO8601Long",
          newformat: "d-m-Y"
        }
      },
      {
        label: 'BANK',
        name: 'bank_id',
        align: 'left'
      },
      {
        label: 'COA',
        name: 'coa',
        align: 'left'
      },
      {
        label: 'NO BUKTI PENGELUARAN',
        name: 'pengeluaran_nobukti',
        align: 'left'
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
      },
      {
        label: 'CREATEDAT',
        name: 'created_at',
        align: 'right'
      },
    ],
    autowidth: true,
    responsive: true,
    shrinkToFit: false,
    height: 250,
    width: 500,
    rowNum: 10,
    rownumbers: true,
    rownumWidth: 45,
    rowList: [10, 20, 50],
    sortable: true,
    sortname: 'id',
    sortorder: 'asc',
    page: 1,
    pager: $('#pengeluaranTruckingHeaderLookupPager'),
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

        if (indexRow - 1 > $('#pengeluaranTruckingHeaderLookup').getGridParam().reccount) {
          indexRow = $('#pengeluaranTruckingHeaderLookup').getGridParam().reccount - 1
        }

        if (triggerClick) {
          if (id != '') {
            indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
            $(`#pengeluaranTruckingHeaderLookup [id="${$('#pengeluaranTruckingHeaderLookup').getDataIDs()[indexRow]}"]`).click()
            id = ''
          } else if (indexRow != undefined) {
            $(`#pengeluaranTruckingHeaderLookup [id="${$('#pengeluaranTruckingHeaderLookup').getDataIDs()[indexRow]}"]`).click()
          }

          if ($('#pengeluaranTruckingHeaderLookup').getDataIDs()[indexRow] == undefined) {
            $(`#pengeluaranTruckingHeaderLookup [id="` + $('#pengeluaranTruckingHeaderLookup').getDataIDs()[0] + `"]`).click()
          }

          triggerClick = false
        } else {
          $('#pengeluaranTruckingHeaderLookup').setSelection($('#pengeluaranTruckingHeaderLookup').getDataIDs()[indexRow])
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

      $(this).setGridWidth($('#lookupPengeluaranTruckingHeader').prev().width())
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
        clearGlobalSearch($('#pengeluaranTruckingHeaderLookup'))
      },
    })

  loadGlobalSearch($('#pengeluaranTruckingHeaderLookup'))
  loadClearFilter($('#pengeluaranTruckingHeaderLookup'))
</script>
@endpush