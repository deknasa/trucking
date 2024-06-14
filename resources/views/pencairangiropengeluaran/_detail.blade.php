@push('scripts')
<script>
    let nobuktiSearchDetail = ''
  function loadDetailGrid(nobukti) {
    let sortnameDetail = 'id'
    let sortorderDetail = 'asc'
    let totalRecordDetail
    let limitDetail
    let postDataDetail
    let triggerClickDetail
    let indexRowDetail
    let pageDetail = 0;
    $("#detail").jqGrid({
        datatype: 'local',
        data: [],
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        idPrefix: 'detail',
        colModel: [{
            label: 'NO BUKTI GIRO',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            name: 'nobukti',
          },
          {
            label: 'NO WARKAT',
            name: 'nowarkat',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'TGL JATUH TEMPO',
            name: 'tgljatuhtempo',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },

          {
            label: 'KETERANGAN',
            name: 'keterangan',
            width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
          },
          {
            label: 'NOMINAL',
            name: 'nominal',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'KODE PERKIRAAN DEBET',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            name: 'coadebet',
          },
          {
            label: 'KODE PERKIRAAN kredit',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            name: 'coakredit',
          },
          {
            label: 'BULAN BEBAN',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
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
        sortname: sortnameDetail,
        sortorder: sortorderDetail,
        page: pageDetail,
        viewrecords: true,
        postData: {
          pengeluaran_id: id,
          nobukti: nobuktiSearchDetail
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
          $(this).setGridParam({
          postData: {
            nobukti: nobuktiSearchDetail
          },})
          clearGlobalSearch($('#detail'))
        },
      })
      .customPager()
    /* Append clear filter button */
    loadClearFilter($('#detail'))

    /* Append global search */
    loadGlobalSearch($('#detail'))
  }

  function loadDetailData(id, nobukti, status) {
    nobuktiSearchDetail = nobukti
    abortGridLastRequest($('#detail'))

    $('#detail').setGridParam({
      url: `${apiUrl}pencairangiropengeluarandetail`,
      datatype: "json",
      postData: {
        pengeluaran_id: id,
        nobukti: nobukti,
        status: status
      },
      page: 1
    }).trigger('reloadGrid')
  }
</script>
@endpush