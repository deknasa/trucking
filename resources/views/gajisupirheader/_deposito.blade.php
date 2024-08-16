@push('scripts')
<script>
  function loadDepositoGrid(nobukti) {
    let sortnameDeposito = 'nobukti'
    let sortorderDeposito = 'asc'
    let totalRecordDeposito
    let limitDeposito
    let postDataDeposito
    let triggerClickDeposito
    let indexRowDeposito
    let pageDeposito = 0;

    $("#depositoGrid").jqGrid({
        datatype: 'local',
        data: [],
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        idPrefix: 'depositoGrid',
        colModel: [{
            label: 'NO BUKTI',
            name: 'nobukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'SUPIR',
            name: 'supir_id',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
            width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1
          },
          {
            label: 'NOMINAL',
            name: 'nominal',
            align: 'right',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
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
        sortname: sortnameDeposito,
        sortorder: sortorderDeposito,
        page: pageDeposito,
        viewrecords: true,
        postData: {
          nobukti: nobuktiRicForSearching
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
          sortnameDeposito = $(this).jqGrid("getGridParam", "sortname")
          sortorderDeposito = $(this).jqGrid("getGridParam", "sortorder")
          totalRecordDeposito = $(this).getGridParam("records")
          limitDeposito = $(this).jqGrid('getGridParam', 'postData').limit
          postDataDeposito = $(this).jqGrid('getGridParam', 'postData')
          triggerClick = false

          $('.clearsearchclass').click(function() {
            clearColumnSearch($(this))
          })

          if (indexRowDeposito > $(this).getDataIDs().length - 1) {
            indexRowDeposito = $(this).getDataIDs().length - 1;
          }


          setHighlight($(this))

          if (data.attributes) {
            $(this).jqGrid('footerData', 'set', {
              nobukti: 'Total:',
              nominal: data.attributes.totalNominalDeposito,
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
                nobukti: nobuktiRicForSearching
            },
          })
          clearGlobalSearch($('#depositoGrid'))
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
    loadClearFilter($('#depositoGrid'))

    /* Append global search */
    loadGlobalSearch($('#depositoGrid'))
  }

  function loadDepositoData(nobukti) {
    abortGridLastRequest($('#depositoGrid'))
    
    $('#depositoGrid').setGridParam({
      url: `${apiUrl}gajisupirdetail/deposito`,
      datatype: "json",
      postData: {
        nobukti: nobukti
      },
      page: 1
    }).trigger('reloadGrid')
  }
</script>
@endpush