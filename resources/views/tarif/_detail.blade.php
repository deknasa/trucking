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
        url: `${apiUrl}tarifrincian`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "local",
        colModel: [
          {
            label: 'CONTAINER',
            name: 'container_id',
          },
          {
            label: 'NOMINAL',
            name: 'nominal',
            align: 'right',
            formatter: currencyFormat
          },
        ],
        autowidth: true,
        shrinkToFit: false,
        height: 250,
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
          tarif_id: id
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
          initResize($(this))
          
          
          
          
          let nominal = $(this).jqGrid("getCol", "nominal")
          let totalNominal = 0

          if (nominal.length > 0) {
            totalNominal = nominal.reduce((previousValue, currentValue) => previousValue + currencyUnformat(currentValue), 0)
          }
          $(this).jqGrid('footerData', 'set', {
            container_id: 'Total:',
            nominal: totalNominal,
          }, true)

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
    $('#detail').setGridParam({
      url: `${apiUrl}tarifrincian`,
      datatype: "json",
      postData: {
        tarif_id: id
      },
      page:1
    }).trigger('reloadGrid')
  }
</script>
@endpush()