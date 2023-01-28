<table id="orderanemklLookup" class="lookup-grid"></table>
<div id="orderanemklLookupPager"></div>

@push('scripts')
<script>
  $('#orderanemklLookup').jqGrid({
      url: `{{ config('app.emkl_api_url') . 'orderanemkl' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      postData: {
        container_id: `{!! $Container_id ?? '' !!}`,
      },          
      colModel: [
        {
          label: 'NO JOB',
          name: 'nojob',
          align: 'left',
        },
        {
          label: 'NO CONTAINER',
          name: 'nocont',
          align: 'left'
        },        {
          label: 'NO SEAL',
          name: 'noseal',
          align: 'left'
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
      toolbar: [true, "top"],
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      page: 1,
      pager: $('#orderanemklLookupPager'),
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

          if (indexRow - 1 > $('#orderanemklLookup').getGridParam().reccount) {
            indexRow = $('#orderanemklLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#orderanemklLookup [id="${$('#orderanemklLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#orderanemklLookup [id="${$('#orderanemklLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#orderanemklLookup').getDataIDs()[indexRow] == undefined) {
              $(`#orderanemklLookup [id="` + $('#orderanemklLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#orderanemklLookup').setSelection($('#orderanemklLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookuporderanemkl').prev().width())
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
        clearGlobalSearch($('#orderanemklLookup'))
      },
    })

  loadGlobalSearch($('#orderanemklLookup'))
  loadClearFilter($('#orderanemklLookup'))
</script>