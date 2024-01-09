<table id="userLookup" class="lookup-grid"></table>
{{-- <div id="userLookupPager"></div> --}}

@push('scripts')
<script>
  $('#userLookup').jqGrid({
      url: `{{ config('app.api_url') . 'user' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      postData: {
        role: `{!! $role ?? '' !!}`,
      },
      idPrefix: 'userLookup',
      colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '70px',
            search: false,
          hidden: true
        },
        {
          label: 'USER',
          name: 'user',
          align: 'left',
          width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
        },
        {
          label: 'NAMA USER',
          name: 'name',
          width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
          align: 'left'
        },
        {
          label: 'DASHBOARD',
          name: 'dashboard',
          width: (detectDeviceType() == "desktop") ?sm_dekstop_2 : sm_mobile_2,
          align: 'left'
        },
        {
          label: 'ID KARYAWAN',
          name: 'karyawan_id',
          width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
          align: 'right'
        },
        {
          label: 'Cabang',
          name: 'cabang_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          width: 150,
        },
        {
          label: 'Status',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          name: 'statusaktif',
          width: 150,
        },
        {
          label: 'MODIFIED BY',
          name: 'modifiedby',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,            
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
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,            
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y H:i:s"
            }
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
      // pager: $('#userLookupPager'),
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
        indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
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

          if (indexRow - 1 > $('#userLookup').getGridParam().reccount) {
            indexRow = $('#userLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#userLookup [id="${$('#userLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#userLookup [id="${$('#userLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#userLookup').getDataIDs()[indexRow] == undefined) {
              $(`#userLookup [id="` + $('#userLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#userLookup').setSelection($('#userLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookupuser').prev().width())
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

        clearGlobalSearch($('#userLookup'))
      },
    })
    .customPager()
  loadGlobalSearch($('#userLookup'))
  loadClearFilter($('#userLookup'))
</script>