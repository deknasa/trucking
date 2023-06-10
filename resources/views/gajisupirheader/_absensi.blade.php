<table id="absensiGrid"></table>

<script>
  function loadGrid(id, nobukti) {
    let sortnameAbsensi = 'nobukti'
    let sortorderAbsensi = 'asc'
    let totalRecordAbsensi
    let limitAbsensi
    let postDataAbsensi
    let triggerClickAbsensi
    let indexRowAbsensi
    let pageAbsensi = 0

    $("#absensiGrid")
      .jqGrid({
        url: `${apiUrl}gajisupirdetail/absensi`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        colModel: [{
            label: 'NO BUKTI',
            name: 'nobukti',
          },
          {
            label: 'TGL BUKTI',
            name: 'tglbukti',
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'UANG JALAN',
            name: 'uangjalan',
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
        sortname: sortnameAbsensi,
        sortorder: sortorderAbsensi,
        page: pageAbsensi,
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
          sortnameAbsensi = $(this).jqGrid("getGridParam", "sortname")
          sortorderAbsensi = $(this).jqGrid("getGridParam", "sortorder")
          totalRecordAbsensi = $(this).getGridParam("records")
          limitAbsensi = $(this).jqGrid('getGridParam', 'postData').limit
          postDataAbsensi = $(this).jqGrid('getGridParam', 'postData')
          triggerClick = false

          $('.clearsearchclass').click(function() {
            clearColumnSearch($(this))
          })

          if (indexRowAbsensi > $(this).getDataIDs().length - 1) {
            indexRowAbsensi = $(this).getDataIDs().length - 1;
          }

          setHighlight($(this))

          if (data.attributes) {
            $(this).jqGrid('footerData', 'set', {
              nobukti: 'Total:',
              uangjalan: data.attributes.totalUangJalan,
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
          clearGlobalSearch($('#absensiGrid'))
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
    loadClearFilter($('#absensiGrid'))

    /* Append global search */
    loadGlobalSearch($('#absensiGrid'))
  }

  function loadDetailData(id, nobukti) {
    abortGridLastRequest($('#absensiGrid'))
    
    $('#absensiGrid').setGridParam({
      url: `${apiUrl}gajisupirdetail/absensi`,
      datatype: "json",
      postData: {
        nobukti: nobukti
      },
      page: 1
    }).trigger('reloadGrid')
  }
</script>