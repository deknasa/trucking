<table id="tradoLookup"  class="lookup-grid"></table>
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
          align: 'right',
          width: '70px'
        },
        {
          label: 'KETERANGAN',
          name: 'keterangan',
          align: 'left',
        },
        {
            label: 'STATUS AKTIF',
            name: 'statusaktif',
            align: 'left',
            width: 100,
            stype: 'select',
        },
        {
          label: 'KM AWAL',
          name: 'kmawal',
          align: 'left'
        },
        {
          label: 'KM AKHIR GANTI OLI',
          name: 'kmakhirgantioli',
          align: 'left'
        },
        {
          label: 'TGL AKHIR GANTI OLI',
          name: 'tglakhirgantioli',
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
          initResize($(this))

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

</script>
