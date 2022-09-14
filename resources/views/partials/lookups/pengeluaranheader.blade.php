<table id="pengeluaranHeaderLookup" style="width: 100%;"></table>
<div id="pengeluaranHeaderLookupPager"></div>

@push('scripts')
<script>
  let pengeluaranHeaderLookup = $('#pengeluaranHeaderLookup').jqGrid({
      url: `{{ config('app.api_url') . 'pengeluaran' }}`,
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
          label: 'TGL BUKTI',
          name: 'tglbukti',
          align: 'left',
          formatter: "date",
          formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
          }
        },
        {
          label: 'PELANGGAN',
          name: 'pelanggan_id',
          align: 'left'
        },
        {
          label: 'KETERANGAN',
          name: 'keterangan',
          align: 'left'
        },
        
        {
          label: 'STATUS JNS TRANSAKSI',
          name: 'statusjenistransaksi',
          align: 'left'
        },
        {
          label: 'POSTING DARI',
          name: 'postingdari',
          align: 'left'
        },
        {
          label: 'STATUS APPROVAL',
          name: 'statusapproval',
          align: 'left'
        },
        {
          label: 'DIBAYARKAN KE',
          name: 'dibayarke',
          align: 'left'
        },
        {
          label: 'CABANG',
          name: 'cabang_id',
          align: 'left'
        },
        {
          label: 'BANK',
          name: 'bank_id',
          align: 'left'
        },
        {
          label: 'TRANSFER KE NO REK',
          name: 'transferkeac',
          align: 'left'
        }, 
        {
          label: 'TRANSFER NAMA REK',
          name: 'transferkean',
          align: 'left'
        },
        {
          label: 'TRANSFER NAMA BANK',
          name: 'transferkebank',
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
        }, {
          label: 'CREATEDAT',
          name: 'created_at',
          align: 'right'
        },
      ],
      autowidth: true,
      responsive: true,
      shrinkToFit: false,
      height: 450,
      rowNum: 10,
      rownumbers: true,
      rownumWidth: 45,
      rowList: [10, 20, 50],
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      page: 1,
      pager: $('#pengeluaranHeaderLookupPager'),
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

          if (indexRow - 1 > $('#pengeluaranHeaderLookup').getGridParam().reccount) {
            indexRow = $('#pengeluaranHeaderLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#pengeluaranHeaderLookup [id="${$('#pengeluaranHeaderLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#pengeluaranHeaderLookup [id="${$('#pengeluaranHeaderLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#pengeluaranHeaderLookup').getDataIDs()[indexRow] == undefined) {
              $(`#pengeluaranHeaderLookup [id="` + $('#pengeluaranHeaderLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#pengeluaranHeaderLookup').setSelection($('#pengeluaranHeaderLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookupPengeluaranHeader').prev().width())
        setHighlight($(this))
      }
    })

    // .jqGrid('filterToolbar', {
    //   stringResult: true,
    //   searchOnEnter: false,
    //   defaultSearch: 'cn',
    //   groupOp: 'AND',
    //   disabledKeys: [16, 17, 18, 33, 34, 35, 36, 37, 38, 39, 40],
    //   beforeSearch: function() {

    //   },
    // })
</script>
@endpush