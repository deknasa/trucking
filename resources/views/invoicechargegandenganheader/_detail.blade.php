
@push('scripts')
<script>
  let sortnameDetail = 'jobtrucking'
  let sortorderDetail = 'asc'
  let totalRecordDetail
  let limitDetail
  let postDataDetail
  let triggerClickDetail
  let indexRowDetail
  let pageDetail = 0;

  function loadDetailGrid(id) {
    $("#detail").jqGrid({
        datatype: 'local',
        data: [],
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        idPrefix: 'detail',
        colModel: [{
            label: 'NO BUKTI',
            name: 'jobtrucking',
          },
          {
            label: 'TGL MASUK GUDANG',
            name: 'tgltrip',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'TGL KELUAR GUDANG',
            name: 'tglakhir',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'jumlah Hari',
            name: 'jumlahhari',
            align: 'right',
          },
          {
            label: 'NOMINAL',
            name: 'nominal',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'JENIS ORDER',
            name: 'jenisorder',
          },
          {
            label: 'NAMA GUDANG',
            name: 'namagudang',
          },
          {
            label: 'No Polisi',
            name: 'nopolisi',
          },
          {
            label: 'GANDENGAN',
            name: 'gandengan',
          },
          {
            label: 'keterangan',
            name: 'keterangan',
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
          invoicechargegandengan_id: id
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
      url: `${apiUrl}invoicechargegandengandetail`,
      datatype: "json",
      postData: {
        invoicechargegandengan_id: id
      },
      page: 1
    }).trigger('reloadGrid')
  }
</script>
@endpush()