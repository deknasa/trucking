
@push('scripts')
<script>
  function loadPinjamanJurnalGrid(nobukti) {
    let sortnamePinjaman = 'nobukti'
    let sortorderPinjaman = 'asc'
    let totalRecordPinjaman
    let limitPinjaman
    let postDataPinjaman
    let triggerClickPinjaman
    let indexRowPinjaman
    let pagePinjaman = 0

    $("#pinjamanGrid")
      .jqGrid({
        datatype: 'local',
        data: [],
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        idPrefix: 'pinjamanGrid',
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
        sortname: sortnamePinjaman,
        sortorder: sortorderPinjaman,
        page: pagePinjaman,
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
          sortnamePinjaman = $(this).jqGrid("getGridParam", "sortname")
          sortorderPinjaman = $(this).jqGrid("getGridParam", "sortorder")
          totalRecordPinjaman = $(this).getGridParam("records")
          limitPinjaman = $(this).jqGrid('getGridParam', 'postData').limit
          postDataPinjaman = $(this).jqGrid('getGridParam', 'postData')
          triggerClick = false

          $('.clearsearchclass').click(function() {
            clearColumnSearch($(this))
          })

          if (indexRowPinjaman > $(this).getDataIDs().length - 1) {
            indexRowPinjaman = $(this).getDataIDs().length - 1;
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
          },})
          clearGlobalSearch($('#pinjamanGrid'))
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
    loadClearFilter($('#pinjamanGrid'))

    /* Append global search */
    loadGlobalSearch($('#pinjamanGrid'))
  }

  function loadPinjamanData(id, nobukti) {
    abortGridLastRequest($('#pinjamanGrid'))
    $('#pinjamanGrid').setGridParam({
      url: `${apiUrl}pendapatansupirdetail/jurnal`,
      datatype: "json",
      postData: {
        nobukti: nobukti,
        penerimaan: 'PJP'
      },
      page: 1
    }).trigger('reloadGrid')
  }
</script>
@endpush