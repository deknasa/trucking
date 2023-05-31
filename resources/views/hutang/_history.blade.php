<table id="historyGrid"></table>

<script>
  function loadGrid(id) {
    let sortnameHistory = 'hutang_nobukti'
    let sortorderHistory = 'asc'
    let totalRecordHistory
    let limitHistory
    let postDataHistory
    let triggerClickHistory
    let indexRowHistory
    let pageHistory = 0;
    $('#historyGrid')
      .jqGrid({
        url: `${apiUrl}hutangdetail/history`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        colModel: [{
            label: 'NO BUKTI',
            name: 'hutang_nobukti',
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan_bayar',
          },
          {
            label: 'NO BUKTI PEMBAYARAN',
            name: 'nobukti_bayar',
          },
          {
            label: 'NOMINAL',
            name: 'nominal_bayar',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'POTONGAN',
            name: 'potongan',
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
        sortname: sortnameHistory,
        sortorder: sortorderHistory,
        page: pageHistory,
        viewrecords: true,
        postData: {
          hutang_id: id
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
          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))

          /* Set global variables */
          sortnameHistory = $(this).jqGrid("getGridParam", "sortname")
          sortorderHistory = $(this).jqGrid("getGridParam", "sortorder")
          totalRecordHistory = $(this).getGridParam("records")
          limitHistory = $(this).jqGrid('getGridParam', 'postData').limit
          postDataHistory = $(this).jqGrid('getGridParam', 'postData')
          triggerClick = false

          $('.clearsearchclass').click(function() {
            clearColumnSearch($(this))
          })

          if (indexRowHistory > $(this).getDataIDs().length - 1) {
            indexRowHistory = $(this).getDataIDs().length - 1;
          }

          setHighlight($(this))

          if (data.attributes) {
            $(this).jqGrid('footerData', 'set', {
              piutang_nobukti: 'Total:',
              nominal: data.attributes.totalNominal,
              potongan: data.attributes.totalPotongan,
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
          
          clearGlobalSearch($('#historyGrid'))
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
    loadClearFilter($('#historyGrid'))

    /* Append global search */
    loadGlobalSearch($('#historyGrid'))
  }

  function loadDetailData(id) {
        abortGridLastRequest($('#detail'))

        $('#historyGrid').setGridParam({
      url: `${apiUrl}hutangdetail/history`,
      datatype: "json",
      postData: {
        hutang_id: id
      },
      page:1
    }).trigger('reloadGrid')
  }
</script>