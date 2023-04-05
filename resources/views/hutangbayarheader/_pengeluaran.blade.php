<table id="pengeluaranGrid"></table>

<script>
  function loadGrid(pelunasanId, nobukti) {
    let sortnamePengeluaran = 'nobukti'
    let sortorderPengeluaran = 'asc'
    let totalRecordPengeluaran
    let limitPengeluaran
    let postDataPengeluaran
    let triggerClickPengeluaran
    let indexRowPengeluaran
    let pagePengeluaran = 0

    $("#pengeluaranGrid")
      .jqGrid({
        url: `${apiUrl}pengeluarandetail/getPengeluaran`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        colModel: [{
            label: 'NO BUKTI',
            name: 'nobukti',
          },
          {
            label: 'NO WARKAT',
            name: 'nowarkat',
          },
          {
            label: 'TGL JATUH TEMPO',
            name: 'tgljatuhtempo',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
          },
          {
            label: 'NOMINAL',
            name: 'nominal',
            align: 'right',
            formatter: currencyFormat
          },
          {
            label: 'COA DEBET',
            name: 'coadebet',
          },
          {
            label: 'COA KREDIT',
            name: 'coakredit',
          },

          {
            label: 'BANK',
            name: 'bank_id',
          },
          {
            label: 'INVOICE NO BUKTI',
            name: 'invoice_nobukti',
          },
          {
            label: 'PELUNASAN PIUTANG NO BUKTI',
            name: 'pelunasanpiutang_nobukti',
          },
          {
            label: 'BANK PELANGGAN',
            name: 'bankpelanggan_id',
          },
          {
            label: 'BULAN BEBAN',
            name: 'bulanbeban',
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
        sortname: sortnamePengeluaran,
        sortorder: sortorderPengeluaran,
        page: pagePengeluaran,
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
          sortnamePengeluaran = $(this).jqGrid("getGridParam", "sortname")
          sortorderPengeluaran = $(this).jqGrid("getGridParam", "sortorder")
          totalRecordPengeluaran = $(this).getGridParam("records")
          limitPengeluaran = $(this).jqGrid('getGridParam', 'postData').limit
          postDataPengeluaran = $(this).jqGrid('getGridParam', 'postData')
          triggerClick = false

          $('.clearsearchclass').click(function() {
            clearColumnSearch($(this))
          })

          if (indexRowPengeluaran > $(this).getDataIDs().length - 1) {
            indexRowPengeluaran = $(this).getDataIDs().length - 1;
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
          clearGlobalSearch($('#pengeluaranGrid'))
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
    loadClearFilter($('#pengeluaranGrid'))

    /* Append global search */
    loadGlobalSearch($('#pengeluaranGrid'))
  }

  function loadDetailData(id, nobukti) {
    $('#pengeluaranGrid').setGridParam({
      url: `${apiUrl}pengeluarandetail/getPengeluaran`,
      datatype: "json",
      postData: {
        nobukti: nobukti
      },
      page: 1
    }).trigger('reloadGrid')
  }
</script>