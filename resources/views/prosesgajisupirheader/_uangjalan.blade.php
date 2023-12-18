
@push('scripts')
<script>
  function loadPengembalianGrid(nobukti) {
    let sortnamePengembalian = 'nobukti'
    let sortorderPengembalian = 'asc'
    let totalRecordPengembalian
    let limitPengembalian
    let postDataPengembalian
    let triggerClickPengembalian
    let indexRowPengembalian
    let pagePengembalian = 0

    $("#pengembalianGrid")
      .jqGrid({
        datatype: 'local',
        data: [],
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        idPrefix: 'pengembalianGrid',
        colModel: [{
            label: 'NO BUKTI',
            name: 'nobukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },{
            label: 'TGL BUKTI',
            name: 'tglbukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'KODE PERKIRAAN',
            name: 'coa',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'NAMA PERKIRAAN',
            name: 'keterangancoa',
            width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
          },
          {
            label: 'DEBET',
            name: 'nominaldebet',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'KREDIT',
            name: 'nominalkredit',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
            width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
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
        sortname: sortnamePengembalian,
        sortorder: sortorderPengembalian,
        page: pagePengembalian,
        viewrecords: true,
        postData: {
          nobukti: nobukti,
          tab: 'Pengembalian'
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
          sortnamePengembalian = $(this).jqGrid("getGridParam", "sortname")
          sortorderPengembalian = $(this).jqGrid("getGridParam", "sortorder")
          totalRecordPengembalian = $(this).getGridParam("records")
          limitPengembalian = $(this).jqGrid('getGridParam', 'postData').limit
          postDataPengembalian = $(this).jqGrid('getGridParam', 'postData')
          triggerClick = false

          $('.clearsearchclass').click(function() {
            clearColumnSearch($(this))
          })

          if (indexRowPengembalian > $(this).getDataIDs().length - 1) {
            indexRowPengembalian = $(this).getDataIDs().length - 1;
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
          abortGridLastRequest($(this))
          $(this).setGridParam({
          postData: {
            nobukti: nobukti,
            tab: 'pengembalian'
          },})
          clearGlobalSearch($('#pengembalianGrid'))
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
    loadClearFilter($('#pengembalianGrid'))

    /* Append global search */
    loadGlobalSearch($('#pengembalianGrid'))
  }

  function loadPengembalianData(nobukti) {
    abortGridLastRequest($('#pengembalianGrid'))

    $('#pengembalianGrid').setGridParam({
      url: `${apiUrl}prosesgajisupirdetail/getjurnal`,
      datatype: "json",
      postData: {
        nobukti: nobukti,
        tab: 'pengembalian'
      },
      page: 1
    }).trigger('reloadGrid')
  }
</script>
@endpush