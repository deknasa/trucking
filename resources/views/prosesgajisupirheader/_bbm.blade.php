<table id="bbmGrid"></table>

<script>
  function loadGrid(id, nobuktiPengeluaran, nobukti) {
    let sortnameBBM = 'nobukti'
    let sortorderBBM = 'asc'
    let totalRecordBBM
    let limitBBM
    let postDataBBM
    let triggerClickBBM
    let indexRowBBM
    let pageBBM = 0

    $("#bbmGrid")
      .jqGrid({
        url: `${apiUrl}prosesgajisupirdetail/getjurnal`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        colModel: [{
            label: 'NO BUKTI',
            name: 'nobukti',
          },{
            label: 'TGL BUKTI',
            name: 'tglbukti',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'KODE PERKIRAAN',
            name: 'coa',
          },
          {
            label: 'NAMA PERKIRAAN',
            name: 'keterangancoa',
          },
          {
            label: 'DEBET',
            name: 'nominaldebet',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'KREDIT',
            name: 'nominalkredit',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
            width: '500px'
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
        sortname: sortnameBBM,
        sortorder: sortorderBBM,
        page: pageBBM,
        viewrecords: true,
        postData: {
          nobukti: nobukti,
          tab: 'bbm'
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
          sortnameBBM = $(this).jqGrid("getGridParam", "sortname")
          sortorderBBM = $(this).jqGrid("getGridParam", "sortorder")
          totalRecordBBM = $(this).getGridParam("records")
          limitBBM = $(this).jqGrid('getGridParam', 'postData').limit
          postDataBBM = $(this).jqGrid('getGridParam', 'postData')
          triggerClick = false

          $('.clearsearchclass').click(function() {
            clearColumnSearch($(this))
          })

          if (indexRowBBM > $(this).getDataIDs().length - 1) {
            indexRowBBM = $(this).getDataIDs().length - 1;
          }

          setHighlight($(this))

          if (data.attributes) {
            $(this).jqGrid('footerData', 'set', {
              nobukti: 'Total:',
              nominaldebet: data.attributes.totalNominalDebet,
              nominalkredit: data.attributes.totalNominalKredit,
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
            nobukti: nobukti,
            tab: 'bbm'
          },})
          clearGlobalSearch($('#bbmGrid'))
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
    loadClearFilter($('#bbmGrid'))

    /* Append global search */
    loadGlobalSearch($('#bbmGrid'))
  }

  function loadDetailData(id, nobukti) {
    abortGridLastRequest($('#bbmGrid'))

    $('#bbmGrid').setGridParam({
      url: `${apiUrl}prosesgajisupirdetail/bbm`,
      datatype: "json",
      postData: {
        nobukti: nobukti
      },
      page: 1
    }).trigger('reloadGrid')
  }
</script>