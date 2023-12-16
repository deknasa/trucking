<table id="parameterLookup" class="lookup-grid" style="width: 100%;"></table>
{{-- <div id="parameterLookupPager"></div> --}}

<script>
$('#parameterLookup').jqGrid({
  url: `{{ config('app.api_url') . 'parameter' }}`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        idPrefix: 'parameterLookup',
        colModel: [{
            label: 'ID',
            name: 'id',
            width: '50px',
            search: false,
            hidden: true
          },
          {
            label: 'GROUP',
            name: 'grp',
            width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
          },
          {
            label: 'SUB GROUP',
            name: 'subgrp',
            width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
          },
          {
            label: 'KELOMPOK',
            name: 'kelompok',
            width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
          },
          {
            label: 'TEXT',
            name: 'text',
            width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
          },
          {
            label: 'MEMO',
            name: 'memo',
            width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
          },
          {
            label: 'MODIFIED BY',
            name: 'modifiedby',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,            
          },
          {
            label: 'CREATED AT',
            name: 'created_at',
            align: 'right',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,            
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
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,            
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
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      page: 1,
      toolbar: [true, "top"],
      // pager: $('#parameterLookupPager'),
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

          if (indexRow - 1 > $('#parameterLookup').getGridParam().reccount) {
            indexRow = $('#parameterLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#parameterLookup [id="${$('#parameterLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#parameterLookup [id="${$('#parameterLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#parameterLookup').getDataIDs()[indexRow] == undefined) {
              $(`#parameterLookup [id="` + $('#parameterLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#parameterLookup').setSelection($('#parameterLookup').getDataIDs()[indexRow])
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

        clearGlobalSearch($('#parameterLookup'))
      },
    })
    .customPager()
  loadGlobalSearch($('#parameterLookup'))
  loadClearFilter($('#parameterLookup'))
</script>
