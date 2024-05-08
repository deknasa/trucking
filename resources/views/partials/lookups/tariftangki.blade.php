<table id="tarifTangkiLookup" class="lookup-grid"></table>
{{-- <div id="tarifTangkiLookupPager"></div> --}}

@push('scripts')
<script>
  $('#tarifTangkiLookup').jqGrid({
      url: `{{ config('app.api_url') . 'tariftangki' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      postData: {
        aktif: `{!! $Aktif ?? '' !!}`,
        isParent: `{!! $isParent ?? '' !!}`,
      },
      idPrefix: 'tarifTangkiLookup',
      colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '50px',
          search: false,
          hidden: true
        },
        {
          label: 'TUJUAN',
          name: 'tujuan',
          width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
        },
        {
          label: 'PENYESUAIAN',
          name: 'penyesuaian',
          width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
        },
        {
          label: 'KOTA',
          name: 'kota_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
        },
        {
          label: 'KOTAID',
          name: 'kotaId',
          hidden: true,
          search: false,
        },
        {
          label: 'MODIFIED BY',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          name: 'modifiedby',
          align: 'left'
        },
        {
          label: 'CREATED AT',
          name: 'created_at',
          align: 'right',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y H:i:s"
          }
        },
        {
          label: 'UPDATED AT',
          name: 'updated_at',
          align: 'right',
          formatter: "date",
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y H:i:s"
          }
        },
        {
          label: 'Tujuan-Penyesuaian',
          name: 'tujuanpenyesuaian',
          width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
          align: 'left'
        },
      ],
      autowidth: true,
      responsive: true,
      shrinkToFit: false,
      height: 350,
      rowNum: 10,
      rownumbers: true,
      rownumWidth: 45,
      rowList: [10, 20, 50, 0],
      toolbar: [true, "top"],
      sortable: true,
      sortname: 'tujuan',
      sortorder: 'asc',
      page: 1,
      // pager: $('#tarifTangkiLookupPager'),
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

          if (indexRow - 1 > $('#tarifTangkiLookup').getGridParam().reccount) {
            indexRow = $('#tarifTangkiLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#tarifTangkiLookup [id="${$('#tarifTangkiLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#tarifTangkiLookup [id="${$('#tarifTangkiLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#tarifTangkiLookup').getDataIDs()[indexRow] == undefined) {
              $(`#tarifTangkiLookup [id="` + $('#tarifTangkiLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#tarifTangkiLookup').setSelection($('#tarifTangkiLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookuptarif').prev().width())
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

        clearGlobalSearch($('#tarifTangkiLookup'))
      },
    })
    .customPager()
  loadGlobalSearch($('#tarifTangkiLookup'))
  loadClearFilter($('#tarifTangkiLookup'))
</script>