@push('scripts')
<script>
  function loadBBMGrid(nobukti) {
    let sortnameJurnal = 'nobukti'
    let sortorderJurnal = 'asc'
    let totalRecordJurnal
    let limitJurnal
    let postDataJurnal
    let triggerClickJurnal
    let indexRowJurnal
    let pageJurnal = 0;

    $("#bbmGrid").jqGrid({
        datatype: 'local',
        data: [],
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        idPrefix: 'bbmGrid',
        colModel: [{
            label: 'NO BUKTI',
            name: 'nobukti',
          },
          {
            label: 'SUPIR',
            name: 'supir_id',
          },
          {
            label: 'NO BUKTI PENGELUARAN TRUCKING',
            name: 'pengeluarantruckingheader_nobukti',
            width: 250
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
            width: 250
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
        sortname: sortnameJurnal,
        sortorder: sortorderJurnal,
        page: pageJurnal,
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
          sortnameJurnal = $(this).jqGrid("getGridParam", "sortname")
          sortorderJurnal = $(this).jqGrid("getGridParam", "sortorder")
          totalRecordJurnal = $(this).getGridParam("records")
          limitJurnal = $(this).jqGrid('getGridParam', 'postData').limit
          postDataJurnal = $(this).jqGrid('getGridParam', 'postData')
          triggerClick = false

          $('.clearsearchclass').click(function() {
            clearColumnSearch($(this))
          })

          if (indexRowJurnal > $(this).getDataIDs().length - 1) {
            indexRowJurnal = $(this).getDataIDs().length - 1;
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
                nobukti: nobukti
            },
          })
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

  function loadBBMData(nobukti) {
    abortGridLastRequest($('#bbmGrid'))

    $('#bbmGrid').setGridParam({
      url: `${apiUrl}gajisupirdetail/bbm`,
      datatype: "json",
      postData: {
        nobukti: nobukti
      },
      page: 1
    }).trigger('reloadGrid')
  }
</script>
@endpush