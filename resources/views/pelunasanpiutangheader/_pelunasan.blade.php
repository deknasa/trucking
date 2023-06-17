
@push('scripts')
<script>
  function loadPelunasanGrid(nobukti) {
    let sortnamePelunasan = 'nobukti'
    let sortorderPelunasan = 'asc'
    let totalRecordPelunasan
    let limitPelunasan
    let postDataPelunasan
    let triggerClickPelunasan
    let indexRowPelunasan
    let pagePelunasan = 0

    $("#pelunasanGrid")
      .jqGrid({
        datatype: 'local',
        data: [],
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        idPrefix: 'pelunasanGrid',
        colModel: [{
            label: 'NO BUKTI',
            name: 'nobukti',
          },
          {
            label: 'NO BUKTI PIUTANG',
            name: 'piutang_nobukti',
          },
          {
            label: 'NO BUKTI INVOICE',
            name: 'invoice_nobukti',
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
          },
          {
            label: 'NOMINAL',
            name: 'nominal',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'KET. POTONGAN',
            name: 'keteranganpotongan',
          },
          {
            label: 'KODE PERKIRAAN POTONGAN',
            name: 'coapotongan',
            width: 220
          },
          {
            label: 'POTONGAN',
            name: 'potongan',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'NOMINAL LEBIH BAYAR',
            name: 'nominallebihbayar',
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
        sortname: sortnamePelunasan,
        sortorder: sortorderPelunasan,
        page: pagePelunasan,
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
          sortnamePelunasan = $(this).jqGrid("getGridParam", "sortname")
          sortorderPelunasan = $(this).jqGrid("getGridParam", "sortorder")
          totalRecordPelunasan = $(this).getGridParam("records")
          limitPelunasan = $(this).jqGrid('getGridParam', 'postData').limit
          postDataPelunasan = $(this).jqGrid('getGridParam', 'postData')
          triggerClick = false

          $('.clearsearchclass').click(function() {
            clearColumnSearch($(this))
          })

          if (indexRowPelunasan > $(this).getDataIDs().length - 1) {
            indexRowPelunasan = $(this).getDataIDs().length - 1;
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
          clearGlobalSearch($('#pelunasanGrid'))
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
    loadClearFilter($('#pelunasanGrid'))

    /* Append global search */
    loadGlobalSearch($('#pelunasanGrid'))
  }

  function loadDetailData(id, nobukti) {
    abortGridLastRequest($('#pelunasanGrid'))
    
    $('#pelunasanGrid').setGridParam({
      url: `${apiUrl}pelunasanpiutangdetail/getPelunasan`,
      datatype: "json",
      postData: {
        nobukti: nobukti
      },
      page: 1
    }).trigger('reloadGrid')
  }
</script>
@endpush