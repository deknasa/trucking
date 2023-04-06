<table id="kasgantungGrid"></table>

<script>
  function loadGrid(id, nobukti) {
    let sortnameKasgantung = 'nobukti'
    let sortorderKasgantung = 'asc'
    let totalRecordKasgantung
    let limitKasgantung
    let postDataKasgantung
    let triggerClickKasgantung
    let indexRowKasgantung
    let pageKasgantung = 0

    $("#kasgantungGrid")
      .jqGrid({
        url: `${apiUrl}kasgantungdetail/getKasgantung`,
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
            label: 'COA',
            name: 'coa',
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
        sortname: sortnameKasgantung,
        sortorder: sortorderKasgantung,
        page: pageKasgantung,
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
          sortnameKasgantung = $(this).jqGrid("getGridParam", "sortname")
          sortorderKasgantung = $(this).jqGrid("getGridParam", "sortorder")
          totalRecordKasgantung = $(this).getGridParam("records")
          limitKasgantung = $(this).jqGrid('getGridParam', 'postData').limit
          postDataKasgantung = $(this).jqGrid('getGridParam', 'postData')
          triggerClick = false

          $('.clearsearchclass').click(function() {
            clearColumnSearch($(this))
          })

          if (indexRowKasgantung > $(this).getDataIDs().length - 1) {
            indexRowKasgantung = $(this).getDataIDs().length - 1;
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
          $(this).setGridParam({
          postData: {
            nobukti: nobukti
          },})
          clearGlobalSearch($('#kasgantungGrid'))
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
    loadClearFilter($('#kasgantungGrid'))

    /* Append global search */
    loadGlobalSearch($('#kasgantungGrid'))
  }

  function loadDetailData(id, nobukti) {
    $('#kasgantungGrid').setGridParam({
      url: `${apiUrl}jurnalumumdetail/jurnal`,
      datatype: "json",
      postData: {
        nobukti: nobukti
      },
      page: 1
    }).trigger('reloadGrid')
  }
</script>