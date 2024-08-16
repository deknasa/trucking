
@push('scripts')
<script>
  let nobuktiSearch = ''
  function loadJurnalUmumGrid(nobukti) {
    let sortnameJurnal = 'nobukti'
    let sortorderJurnal = 'asc'
    let totalRecordJurnal
    let limitJurnal
    let postDataJurnal
    let triggerClickJurnal
    let indexRowJurnal
    let pageJurnal = 0

    $("#jurnalGrid")
      .jqGrid({
        datatype: 'local',
        data: [],
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        idPrefix: 'jurnalGrid',
        colModel: [{
            label: 'NO BUKTI',
            name: 'nobukti',
            width: (detectDeviceType() == "desktop") ?  sm_dekstop_4 : sm_mobile_3,
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
            align: 'right',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            formatter: currencyFormat,
          },
          {
            label: 'KREDIT',
            name: 'nominalkredit',
            align: 'right',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
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
        sortname: sortnameJurnal,
        sortorder: sortorderJurnal,
        page: pageJurnal,
        viewrecords: true,
        postData: {
          nobukti: nobuktiSearch
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
            nobukti: nobuktiSearch
          },})
          clearGlobalSearch($('#jurnalGrid'))
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
    loadClearFilter($('#jurnalGrid'))

    /* Append global search */
    loadGlobalSearch($('#jurnalGrid'))
  }

  function loadJurnalUmumData(id, nobukti,absensiTangki) {
    nobuktiSearch = nobukti
    abortGridLastRequest($('#jurnalGrid'))

    let url = `${apiUrl}jurnalumumdetail/jurnal`
    if (absensiTangki) {
      url = `${apiUrl}absensisupirapprovalproses/getjurnal`
    }
    $('#jurnalGrid').setGridParam({
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