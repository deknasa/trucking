<table id="piutangGrid"></table>

<script>
  function loadGrid(invoiceId, nobukti) {
    let sortnamePiutang = 'nobukti'
    let sortorderPiutang = 'asc'
    let totalRecordPiutang
    let limitPiutang
    let postDataPiutang
    let triggerClickPiutang
    let indexRowPiutang
    let pagePiutang = 0

    $("#piutangGrid")
      .jqGrid({
        url: `${apiUrl}invoicedetail/piutang`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        colModel: [{
            label: 'NO BUKTI',
            name: 'nobukti',
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
          },
          {
            label: 'NO BUKTI INVOICE',
            name: 'invoice_nobukti',
          },
          {
            label: 'NOMINAL',
            name: 'nominal',
            align: 'right',
            formatter: currencyFormat,
          },
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
        sortname: sortnamePiutang,
        sortorder: sortorderPiutang,
        page: pagePiutang,
        viewrecords: true,
        postData: {
          nobukti_piutang: nobukti
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
          sortnamePiutang = $(this).jqGrid("getGridParam", "sortname")
          sortorderPiutang = $(this).jqGrid("getGridParam", "sortorder")
          totalRecordPiutang = $(this).getGridParam("records")
          limitPiutang = $(this).jqGrid('getGridParam', 'postData').limit
          postDataPiutang = $(this).jqGrid('getGridParam', 'postData')
          triggerClick = false

          $('.clearsearchclass').click(function() {
            clearColumnSearch($(this))
          })

          if (indexRowPiutang > $(this).getDataIDs().length - 1) {
            indexRowPiutang = $(this).getDataIDs().length - 1;
          }

          setHighlight($(this))

          if (data.attributes) {
            $(this).jqGrid('footerData', 'set', {
              nobukti: 'Total:',
              nominal: data.attributes.totalNominal,
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
          clearGlobalSearch($('#piutangGrid'))
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
    loadClearFilter($('#piutangGrid'))

    /* Append global search */
    loadGlobalSearch($('#piutangGrid'))
  }

  function loadDetailData(id, nobukti) {
    $('#piutangGrid').setGridParam({
      url: `${apiUrl}invoicedetail/piutang`,
      datatype: "json",
      postData: {
        nobukti_piutang: nobukti
      },
      page: 1
    }).trigger('reloadGrid')
  }
</script>