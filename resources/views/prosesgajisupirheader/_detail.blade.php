@push('scripts')
<script>
  function loadDetailGrid() {
    let sortnameDetail = 'nobukti'
    let sortorderDetail = 'asc'
    let totalRecordDetail
    let limitDetail
    let postDataDetail
    let triggerClickDetail
    let indexRowDetail
    let pageDetail = 0;

    $("#detail").jqGrid({
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: 'local',
        data: [],
        idPrefix: 'detail',
        colModel: [{
            label: 'NO RINCIAN',
            name: 'gajisupir_nobukti',
          },
          {
            label: 'NO BK',
            name: 'trado_id',
          },
          {
            label: 'SUPIR',
            name: 'supir_id',
          },
          {
            label: 'BORONGAN',
            name: 'total',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'U. JALAN',
            name: 'uangjalan',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'U. BBM',
            name: 'bbm',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'U. Makan',
            name: 'uangmakanharian',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'Pot. Pinjaman',
            name: 'potonganpinjaman',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'POT. PINJAMAN (SEMUA)',
            width: 210,
            name: 'potonganpinjamansemua',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'DEPOSITO',
            name: 'deposito',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'Komisi Supir',
            name: 'komisisupir',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'TOL',
            name: 'tolsupir',
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
        sortname: sortnameDetail,
        sortorder: sortorderDetail,
        page: pageDetail,
        viewrecords: true,
        postData: {
          prosesgajisupir_id: id
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
              total: data.attributes.totalNominal,
              uangjalan: data.attributes.totalUangJalan,
              bbm: data.attributes.totalBBM,
              uangmakanharian: data.attributes.totalUangMakan,
              potonganpinjaman: data.attributes.totalPinjaman,
              potonganpinjamansemua: data.attributes.totalPinjamanSemua,
              deposito: data.attributes.totalDeposito,
              komisisupir: data.attributes.totalKomisi,
              tolsupir: data.attributes.totalTol
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
  }

  function loadDetailData(id) {
    abortGridLastRequest($('#detail'))

    $('#detail').setGridParam({
      url: `${apiUrl}prosesgajisupirdetail`,
      datatype: "json",
      postData: {
        prosesgajisupir_id: id
      },
      page: 1
    }).trigger('reloadGrid')
  }
</script>
@endpush