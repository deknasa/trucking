<table id="tujuanbongkarLookup" class="lookup-grid"></table>

@push('scripts')
<script>
  $('#tujuanbongkarLookup').jqGrid({
      url: `${apiEmklUrl}tujuanbongkar`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",

      postData: {
        aktif: `{!! $Aktif ?? '' !!}`,
      },
      idPrefix: 'tujuanbongkarLookup',
      colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '50px',
          search: false,
          hidden: true
        },
        {
          label: 'TUJUAN KAPAL',
          name: 'tujuan',
          width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
          align: 'left'
        },
        {
          label: 'CABANG',
          name: 'cabang',
          width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
          align: "left",
        },
        {
          label: 'STATUS CABANG',
          name: 'statuscabang',
          width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
          align: "left",
        },
      ],
      autowidth: true,
      responsive: true,
      shrinkToFit: false,
      height: 450,
      rowNum: 10,
      rownumbers: true,
      rownumWidth: 45,
      rowList: [10, 20, 50, 0],
      sortable: true,
      toolbar: [true, "top"],
      sortname: 'id',
      sortorder: 'asc',
      page: 1,
      // pager: $('#tujuanbongkarLookupPager'),
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
      loadBeforeSend: function(jqXHR) {
        jqXHR.setRequestHeader('Authorization', `Bearer ${accessTokenEmkl}`)

        setGridLastRequest($(this), jqXHR)
      },
      loadComplete: function(data) {
        changeJqGridRowListText()
        if (detectDeviceType() == 'desktop') {
          $(document).unbind('keydown')
          setCustomBindKeys($(this))

          if (indexRow - 1 > $('#tujuanbongkarLookup').getGridParam().reccount) {
            indexRow = $('#tujuanbongkarLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#tujuanbongkarLookup [id="${$('#tujuanbongkarLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#tujuanbongkarLookup [id="${$('#tujuanbongkarLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#tujuanbongkarLookup').getDataIDs()[indexRow] == undefined) {
              $(`#tujuanbongkarLookup [id="` + $('#tujuanbongkarLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#tujuanbongkarLookup').setSelection($('#tujuanbongkarLookup').getDataIDs()[indexRow])
          }
        }

        /* Set global variables */
        sortname = $(this).jqGrid("getGridParam", "sortname")
        sortorder = $(this).jqGrid("getGridParam", "sortorder")
        totalRecord = $(this).getGridParam("records")
        limit = $(this).jqGrid('getGridParam', 'postData').limit
        postData = $(this).jqGrid('getGridParam', 'postData')

        $('.clearsearchclass').click(function() {
          clearColumnSearch($(this))
        })

        $(this).setGridWidth($('#lookuptujuanbongkar').prev().width())
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
        abortGridLastRequest($(this))

        clearGlobalSearch($('#tujuanbongkarLookup'))
      },
    })
    .customPager()
  loadGlobalSearch($('#tujuanbongkarLookup'))
  loadClearFilter($('#tujuanbongkarLookup'))
</script>