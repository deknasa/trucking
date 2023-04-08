<table id="potsemuaGrid"></table>

<script>
  function loadGrid(id, nobukti) {
    let sortnamePotSemua = 'nobukti'
    let sortorderPotSemua = 'asc'
    let totalRecordPotSemua
    let limitPotSemua
    let postDataPotSemua
    let triggerClickPotSemua
    let indexRowPotSemua
    let pagePotSemua = 0

    $("#potsemuaGrid")
      .jqGrid({
        url: `${apiUrl}gajisupirdetail/potsemua`,
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
            width: 200
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
        sortname: sortnamePotSemua,
        sortorder: sortorderPotSemua,
        page: pagePotSemua,
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
          sortnamePotSemua = $(this).jqGrid("getGridParam", "sortname")
          sortorderPotSemua = $(this).jqGrid("getGridParam", "sortorder")
          totalRecordPotSemua = $(this).getGridParam("records")
          limitPotSemua = $(this).jqGrid('getGridParam', 'postData').limit
          postDataPotSemua = $(this).jqGrid('getGridParam', 'postData')
          triggerClick = false

          $('.clearsearchclass').click(function() {
            clearColumnSearch($(this))
          })

          if (indexRowPotSemua > $(this).getDataIDs().length - 1) {
            indexRowPotSemua = $(this).getDataIDs().length - 1;
          }

          setHighlight($(this))

          if (data.attributes) {
            $(this).jqGrid('footerData', 'set', {
              nobukti: 'Total:',
              nominal: data.attributes.totalNominalPotSemua,
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
          },})
          clearGlobalSearch($('#potsemuaGrid'))
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
    loadClearFilter($('#potsemuaGrid'))

    /* Append global search */
    loadGlobalSearch($('#potsemuaGrid'))
  }

  function loadDetailData(id, nobukti) {
    $('#potsemuaGrid').setGridParam({
      url: `${apiUrl}gajisupirdetail/potsemua`,
      datatype: "json",
      postData: {
        nobukti: nobukti
      },
      page: 1
    }).trigger('reloadGrid')
  }
</script>