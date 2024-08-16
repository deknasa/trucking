<table id="mingguanLookup" class="lookup-grid"></table>
<!-- <div id="mingguanLookupPager"></div> -->

@push('scripts')
<script>
  $('#mingguanLookup').jqGrid({
      url: `{{ config('app.api_url') . 'laporanarusdanapusat/mingguan' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      postData: {
        aktif: `{!! $Aktif ?? '' !!}`,
      },          
      idPrefix: 'mingguanLookup',
      colModel: [
        {
          label: 'Minggu',
          name: 'fKode',
          align: 'left',
          width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,

        },
        {
          label: 'Tahun',
          name: 'fTahun',
          align: 'left',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
        },
        {
          label: 'Minggu Ke',
          name: 'fMingguKe',
          align: 'left',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
        },
        {
          label: 'Bulan Ke',
          name: 'fBulanKe',
          align: 'left',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
        },
        {
          label: 'Tgl Dari',
          name: 'fTglDr',
          align: 'left',
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y"
          },
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,

        },
        {
          label: 'Tgl Sampai',
          name: 'fTglSd',
          align: 'left',
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y"
          },
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,

        },
      ],
      autowidth: true,
      responsive: true,
      shrinkToFit: false,
      height: 450,
      rowNum: 10,
      rownumbers: true,
      rownumWidth: 45,
      rowList: [10, 20, 50, 0],
      toolbar: [true, "top"],
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      page: 1,
      // pager: $('#mingguanLookupPager'),
      viewrecords: true,
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
      onSelectRow: function(id) {
        activeGrid = $(this)
        id = $(this).jqGrid('getCell', id, 'rn') - 1
        indexRow = id
        page = $(this).jqGrid('getGridParam', 'page')
        let rows = $(this).jqGrid('getGridParam', 'postData').limit
        if (indexRow >= rows) indexRow = (indexRow - rows * (page - 1))
      },
      loadBeforeSend: function(jqXHR) {
        jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)

        setGridLastRequest($(this), jqXHR)
      },
      loadComplete: function(data) {
          changeJqGridRowListText()
        if (detectDeviceType() == 'desktop') {
          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))

          if (indexRow - 1 > $('#mingguanLookup').getGridParam().reccount) {
            indexRow = $('#mingguanLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#mingguanLookup [id="${$('#mingguanLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#mingguanLookup [id="${$('#mingguanLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#mingguanLookup').getDataIDs()[indexRow] == undefined) {
              $(`#mingguanLookup [id="` + $('#mingguanLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#mingguanLookup').setSelection($('#mingguanLookup').getDataIDs()[indexRow])
          }
        }

        /* Set global variables */
        sortname = $(this).jqGrid("getGridParam", "sortname")
        sortorder = $(this).jqGrid("getGridParam", "sortorder")
        totalRecord = $(this).getGridParam("records")
        limit = $(this).jqGrid('getGridParam', 'postData').limit
        postData = $(this).jqGrid('getGridParam', 'postData')

        $('.clearsearchclass').click(function() {
          clearColumnSearch($(this))
        })

        $(this).setGridWidth($('#lookupCabang').prev().width())
        setHighlight($(this))
      }
    })

    .jqGrid("setLabel", "rn", "No.")
    .jqGrid('filterToolbar', {
      stringResult: true,
      searchOnEnter: false,
      defaultSearch: 'cn',
      groupOp: 'AND',
      disabledKeys: [16, 17, 18, 33, 34, 35, 36, 37, 38, 39, 40],
      beforeSearch: function() {
        abortGridLastRequest($(this))

        clearGlobalSearch($('#mingguanLookup'))
      },
    })
    .customPager()
  loadGlobalSearch($('#mingguanLookup'))
  loadClearFilter($('#mingguanLookup'))
</script>