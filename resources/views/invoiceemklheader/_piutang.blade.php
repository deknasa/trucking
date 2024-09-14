@push('scripts')
<script>
  function loadPiutangGrid(nobukti) {
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
        datatype: 'local',
        data: [],
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        idPrefix: 'piutangGrid',
        colModel: [{
            label: 'NO BUKTI',
            name: 'nobukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
            width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
          },
          {
            label: 'NO BUKTI INVOICE',
            name: 'invoice_nobukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
          },
          {
            label: 'NOMINAL',
            name: 'nominal',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
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
          abortGridLastRequest($(this))
          
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

  function loadPiutangData(id, nobukti) {
    abortGridLastRequest($('#piutangGrid'))
    console.log('logpiutangdata')
    $('#piutangGrid').setGridParam({
      url: `${apiUrl}invoiceemkldetail/piutang`,
      datatype: "json",
      postData: {
        nobukti_piutang: nobukti
      },
      page: 1
    }).trigger('reloadGrid')
  }
</script>
@endpush