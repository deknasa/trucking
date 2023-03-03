<!-- Grid -->
<div class="container-fluid my-4">
  <div class="row">
    <div class="col-12">
      <table id="detail"></table>
    </div>
  </div>
</div>

@push('scripts')
<script>
  function loadDetailGrid(id) {
    $("#detail").jqGrid({
        url: `${apiUrl}serviceindetail`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "local",
        colModel: [
            {
              label: 'MEKANIK',
              name: 'mekanik_id',
            },
            {
              label: 'KETERANGAN',
              name: 'keterangan',
            }
          ],
        autowidth: true,
        shrinkToFit: false,
        height: 350,
        rowNum: 10,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [10, 20, 50, 0],
        footerrow: true,
        userDataOnFooter: true,
        toolbar: [true, "top"],
        sortable: true,
        viewrecords: true,
        postData: {
          servicein_id: id
        },
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
        loadBeforeSend: (jqXHR) => {
          jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)
        },
        onSelectRow: function(id) {
          activeGrid = $(this)
        },
        loadComplete: function(data) {
          changeJqGridRowListText()
          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))
          
          /* Set global variables */
          sortname = $(this).jqGrid("getGridParam", "sortname")
          sortorder = $(this).jqGrid("getGridParam", "sortorder")
          totalRecord = $(this).getGridParam("records")
          limit = $(this).jqGrid('getGridParam', 'postData').limit
          postData = $(this).jqGrid('getGridParam', 'postData')
          triggerClick = true

          $('.clearsearchclass').click(function() {
            clearColumnSearch($(this))
          })

          if (indexRow > $(this).getDataIDs().length - 1) {
            indexRow = $(this).getDataIDs().length - 1;
          }

          $('#detail').setSelection($('#detail').getDataIDs()[0])

          setHighlight($(this))

        }
      })
      .jqGrid('filterToolbar', {
        stringResult: true,
        searchOnEnter: false,
        defaultSearch: 'cn',
        groupOp: 'AND',
        disabledKeys: [17, 33, 34, 35, 36, 37, 38, 39, 40],
        beforeSearch: function() {
          clearGlobalSearch($('#detail'))
        },
      })

      .jqGrid("navGrid", pager, {
        search: false,
        refresh: false,
        add: false,
        edit: false,
        del: false,
      })
      .customPager()
      
    /* Append clear filter button */
    loadClearFilter($('#detail'))
    
    /* Append global search */
    loadGlobalSearch($('#detail'))
  }

  function loadDetailData(id) {
    $('#detail').setGridParam({
      url: `${apiUrl}serviceindetail`,
      datatype: "json",
      postData: {
        servicein_id: id
      }
    }).trigger('reloadGrid')
  }
</script>
@endpush()