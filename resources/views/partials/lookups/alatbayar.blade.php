<table id="alatBayarLookup" style="width: 100%;"></table>
<div id="alatBayarLookupPager"></div>

@push('scripts')
<script>
  let alatBayarLookup = $('#alatBayarLookup').jqGrid({
      url: `{{ config('app.api_url') . 'alatbayar' }}`,
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
          label: 'KODE ALAT BAYAR',
          name: 'kodealatbayar',
          align: 'left',
        },
        {
          label: 'NAMA ALAT BAYAR',
          name: 'namaalatbayar',
          align: 'left',
        },
        {
          label: 'BANK',
          name: 'bank_id',
          align: 'left'
        },
        {
          label: 'KETERANGAN',
          name: 'keterangan',
          align: 'left'
        },
        {
          label: 'STATUS LANGSUNG CAIR',
          name: 'statuslangsungcair',
          align: 'left'
        },
        {
          label: 'STATUS DEFAULT',
          name: 'statusdefault',
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
      pager: $('#alatbayarLookupPager'),
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

          if (indexRow - 1 > $('#alatbayarLookup').getGridParam().reccount) {
            indexRow = $('#alatbayarLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#alatbayarLookup [id="${$('#alatbayarLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#alatbayarLookup [id="${$('#alatbayarLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#alatbayarLookup').getDataIDs()[indexRow] == undefined) {
              $(`#alatbayarLookup [id="` + $('#alatbayarLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#alatbayarLookup').setSelection($('#alatbayarLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookupAlatBayar').prev().width())
        setHighlight($(this))
      }
    })

</script>
@endpush