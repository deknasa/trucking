
@push('scripts')
<script>
  let nobuktiSearchPengeluaran = ''
  function loadPengeluaranGrid(nobukti) {
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
        datatype: 'local',
        data: [],
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        idPrefix: 'pengeluaranGrid',
        colModel: [{
            label: 'NO BUKTI',
            name: 'nobukti',
            width: (detectDeviceType() == "desktop") ?  sm_dekstop_4 : sm_mobile_3,
          },
          {
            label: 'KODE PERKIRAAN DEBET', 
            width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
            name: 'coadebet',
          },
          {
            label: 'KODE PERKIRAAN kredit', 
            width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
            name: 'coakredit',
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
            label: 'BULAN BEBAN',
            name: 'bulanbeban',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
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
        sortname: sortnamePengeluaran,
        sortorder: sortorderPengeluaran,
        page: pagePengeluaran,
        viewrecords: true,
        postData: {
          nobukti: nobuktiSearchPengeluaran
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
            nobukti: nobuktiSearchPengeluaran
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

  function loadPengeluaranData(id,nobukti,absensiTangki) {
    abortGridLastRequest($('#pengeluaranGrid'))
    nobuktiSearchPengeluaran = nobukti
    
    let url = `${apiUrl}pengeluarandetail/getPengeluaran`
    if (absensiTangki) {
      url = `${apiUrl}absensisupirapprovalproses/get`
    }
    $('#pengeluaranGrid').setGridParam({
      url: url,
      datatype: "json",
      postData: {
        nobukti: nobukti
      },
      page: 1
    }).trigger('reloadGrid')
  }
</script>
@endpush