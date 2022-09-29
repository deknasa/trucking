<table id="akunPusatDetailLookup" style="width: 100%;"></table>
<div id="akunPusatDetailLookupPager"></div>

@push('scripts')
<script>
  let akunPusatDetailLookup = $('#akunPusatDetailLookup').jqGrid({
      url: `{{ config('app.api_url') . 'akunpusat' }}`,
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
          label: 'COA',
          name: 'coa',
          align: 'left',
        },
        {
          label: 'KETERANGAN COA',
          name: 'keterangancoa',
          align: 'left'
        },
        {
          label: 'TYPE',
          name: 'type',
          align: 'left'
        },
        {
          label: 'LEVEL',
          name: 'level',
          align: 'left'
        },
        {
            label: 'STATUS AKTIF',
            name: 'statusaktif',
            stype: 'select',
            align: 'left'
        },
        {
            label: 'PARENT',
            name: 'parent',
            align: 'left'
        },
        {
            label: 'STATUS COA',
            name: 'statuscoa',
            align: 'left'
        },
        {
            label: 'STATUS ACCOUNT PAYABLE',
            name: 'statusaccountpayable',
            align: 'left'
        },
        {
            label: 'STATUS NERACA',
            name: 'statusneraca',
            align: 'left'
        },
        {
            label: 'STATUS LABA RUGI',
            name: 'statuslabarugi',
            align: 'left'
        },
        {
            label: 'COAMAIN',
            name: 'coamain',
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
      pager: $('#akunPusatDetailLookupPager'),
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

          if (indexRow - 1 > $('#akunPusatDetailLookup').getGridParam().reccount) {
            indexRow = $('#akunPusatDetailLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#akunPusatDetailLookup [id="${$('#akunPusatDetailLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#akunPusatDetailLookup [id="${$('#akunPusatDetailLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#akunPusatDetailLookup').getDataIDs()[indexRow] == undefined) {
              $(`#akunPusatDetailLookup [id="` + $('#akunPusatDetailLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#akunPusatDetailLookup').setSelection($('#akunPusatDetailLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookupAkunPusatDetail').prev().width())
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