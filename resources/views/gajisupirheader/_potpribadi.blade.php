<table id="potpribadiGrid"></table>

<script>
  function loadGrid(id,nobukti) {
    let sortnamePotPribadi = 'nobukti'
    let sortorderPotPribadi = 'asc'
    let totalRecordPotPribadi
    let limitPotPribadi
    let postDataPotPribadi
    let triggerClickPotPribadi
    let indexRowPotPribadi
    let pagePotPribadi = 0;

    $("#potpribadiGrid").jqGrid({
        url: `${apiUrl}gajisupirdetail/potpribadi`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        colModel: [{
            label: 'NO BUKTI',
            name: 'nobukti',
          },
          {
            label: 'SUPIR',
            name: 'supir_id',
          },
          {
            label: 'NO BUKTI PENGELUARAN TRUCKING',
            name: 'pengeluarantruckingheader_nobukti',
            width: 250
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
            width: 250
          },
          {
            label: 'NOMINAL',
            name: 'nominal',
            align: 'right',
            formatter: currencyFormat,
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
        sortname: sortnamePotPribadi,
        sortorder: sortorderPotPribadi,
        page: pagePotPribadi,
        viewrecords: true,
        postData: {
          nobukti: nobukti
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
          sortnamePotPribadi = $(this).jqGrid("getGridParam", "sortname")
          sortorderPotPribadi = $(this).jqGrid("getGridParam", "sortorder")
          totalRecordPotPribadi = $(this).getGridParam("records")
          limitPotPribadi = $(this).jqGrid('getGridParam', 'postData').limit
          postDataPotPribadi = $(this).jqGrid('getGridParam', 'postData')
          triggerClick = false

          $('.clearsearchclass').click(function() {
            clearColumnSearch($(this))
          })

          if (indexRowPotPribadi > $(this).getDataIDs().length - 1) {
            indexRowPotPribadi = $(this).getDataIDs().length - 1;
          }


          setHighlight($(this))

          if (data.attributes) {
            $(this).jqGrid('footerData', 'set', {
              nobukti: 'Total:',
              nominal: data.attributes.totalNominalPotPribadi,
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
            $(this).setGridParam({
                postData: {
                    nobukti: nobukti
                },
          })
          clearGlobalSearch($('#potpribadiGrid'))
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
    loadClearFilter($('#potpribadiGrid'))

    /* Append global search */
    loadGlobalSearch($('#potpribadiGrid'))
  }

  function loadPotPribadiData(id) {
    abortGridLastRequest($('#potpribadiGrid'))

    $('#potpribadiGrid').setGridParam({
      url: `${apiUrl}gajisupirdetail`,
      datatype: "json",
      postData: {
        nobukti: nobukti
      },
      page: 1
    }).trigger('reloadGrid')
  }
</script>