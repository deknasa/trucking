<!-- Grid -->
<div class="container-fluid my-4"  style="display: none">
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
        url: `${apiUrl}upahritasirincian`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "local",
        colModel: [{
            label: 'CONTAINER',
            name: 'container_id',
          },
         
          {
            label: 'LITER',
            name: 'liter',
            align: 'right',
            formatter: currencyFormat
          }
        ],
        autowidth: true,
        shrinkToFit: false,
        height: 350,
        rowNum: 0,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [10, 20, 50, 0],
        footerrow: true,
        userDataOnFooter: true,
        toolbar: [true, "top"],
        sortable: true,
        viewrecords: true,
        postData: {
          upahritasi_id: id
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
        loadBeforeSend: function(jqXHR) {
          jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)

          setGridLastRequest($(this), jqXHR)
        },
        onSelectRow: function(id) {
          activeGrid = $(this)
        },
        loadComplete: function(data) {
          changeJqGridRowListText()
          initResize($(this))

        }
      })

      .jqGrid("navGrid", pager, {
        search: false,
        refresh: false,
        add: false,
        edit: false,
        del: false,
      })

      .customPager()
  }

  function loadDetailData(id) {
        abortGridLastRequest($('#detail'))

        $('#detail').setGridParam({
      url: `${apiUrl}upahritasirincian`,
      datatype: "json",
      postData: {
        upahritasi_id: id
      },
      page:1
    }).trigger('reloadGrid')
  }
</script>
@endpush()