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
  let sortnameDetail = 'nobukti'
  let sortorderDetail = 'asc'
  let totalRecordDetail
  let limitDetail
  let postDataDetail
  let triggerClickDetail
  let indexRowDetail
  let pageDetail = 0;

  let column = []
  let post = {}

  function loadDetailGrid(jenisInvoice) {
    if (jenisInvoice === '85') {
      var invoice = 'invoicedetail';
      column = []
      post = {}
      column.push({
        label: 'NO BUKTI',
        name: 'nobukti',
      }, {
        label: 'KETERANGAN',
        name: 'keterangan',
      }, {
        label: 'NOMINAL',
        name: 'nominal',
        align: 'right',
        formatter: currencyFormat,
      }, {
        label: 'NO BUKTI ORDERAN',
        name: 'orderantrucking_nobukti',
      }, {
        label: 'NO BUKTI SP',
        name: 'suratpengantar_nobukti',
      })

    } else if (jenisInvoice === '86') {
      var invoice = 'invoiceextradetail';
      column = []
      post = {}
      column.push({
        label: 'NO BUKTI',
        name: 'nobukti',
      }, {
        label: 'KETERANGAN',
        name: 'keterangan',
      }, {
        label: 'NOMINAL',
        name: 'nominal',
        align: 'right',
        formatter: currencyFormat,
      })
    }

    $("#detail").jqGrid({
        url: `${apiUrl}${invoice}`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "local",
        colModel: column,
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
        sortname: sortnameDetail,
        sortorder: sortorderDetail,
        page: pageDetail,
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
        loadBeforeSend: function(jqXHR) {
          jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)

          setGridLastRequest($(this), jqXHR)
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
          sortnameDetail = $(this).jqGrid("getGridParam", "sortname")
          sortorderDetail = $(this).jqGrid("getGridParam", "sortorder")
          totalRecordDetail = $(this).getGridParam("records")
          limitDetail = $(this).jqGrid('getGridParam', 'postData').limit
          postDataDetail = $(this).jqGrid('getGridParam', 'postData')
          triggerClick = false

          $('.clearsearchclass').click(function() {
            clearColumnSearch($(this))
          })

          if (indexRowDetail > $(this).getDataIDs().length - 1) {
            indexRowDetail = $(this).getDataIDs().length - 1;
          }


          setHighlight($(this))

          if (data.attributes) {

            $(this).jqGrid('footerData', 'set', {
              nobukti: 'Total:',
              nominal: data.attributes.totalNominal
            }, true)

          }
        }
      })
      .jqGrid("setLabel", "rn", "No.")
      .jqGrid('filterToolbar', {
        stringResult: true,
        searchOnEnter: false,
        defaultSearch: 'cn',
        groupOp: 'AND',
        disabledKeys: [17, 33, 34, 35, 36, 37, 38, 39, 40],
        beforeSearch: function() {
          abortGridLastRequest($(this))
          
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

    $('#gbox_detail').siblings('.grid-pager').not(':first').remove()
  }

  function loadDetailData(id, jenisInvoice) {

    if (jenisInvoice === '85') {
      var invoice = 'invoicedetail';
      column = []
      post = {}
      column.push({
        label: 'NO BUKTI',
        name: 'nobukti',
      }, {
        label: 'KETERANGAN',
        name: 'keterangan',
      }, {
        label: 'NOMINAL',
        name: 'nominal',
        align: 'right',
        formatter: currencyFormat,
      }, {
        label: 'NO BUKTI ORDERAN',
        name: 'orderantrucking_nobukti',
      }, {
        label: 'NO BUKTI SP',
        name: 'suratpengantar_nobukti',
      })

      post = {
        invoice_id: id
      }
    } else if (jenisInvoice === '86') {
      var invoice = 'invoiceextradetail';
      column = []
      post = {}
      column.push({
        label: 'NO BUKTI',
        name: 'nobukti',
      }, {
        label: 'KETERANGAN',
        name: 'keterangan',
      }, {
        label: 'NOMINAL',
        name: 'nominal',
        align: 'right',
        formatter: currencyFormat,
      })
      post = {
        invoiceextra_id: id
      }
    }

    $('#detail').setGridParam({
      url: `${apiUrl}${invoice}`,
      datatype: "json",
      postData: post,
      page: 1
    }).trigger('reloadGrid')

    $('#gbox_detail').siblings('.grid-pager').not(':first').remove()
  }
</script>
@endpush()