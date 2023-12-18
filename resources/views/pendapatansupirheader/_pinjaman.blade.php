
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

    $("#jurnalpinjamanGrid")
      .jqGrid({
        datatype: 'local',
        data: [],
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        idPrefix: 'jurnalpinjamanGrid',
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
          clearGlobalSearch($('#jurnalpinjamanGrid'))
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
    loadClearFilter($('#jurnalpinjamanGrid'))

    /* Append global search */
    loadGlobalSearch($('#jurnalpinjamanGrid'))
  }

  function loadPinjamanData(id, nobukti) {
    abortGridLastRequest($('#jurnalpinjamanGrid'))
    $('#jurnalpinjamanGrid').setGridParam({
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