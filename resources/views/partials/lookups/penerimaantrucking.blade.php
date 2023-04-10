<table id="penerimaanTruckingLookup" class="lookup-grid"></table>
<div id="penerimaanTruckingLookupPager"></div>

@push('scripts')
<script>
  $('#penerimaanTruckingLookup').jqGrid({
      url: `{{ config('app.api_url') . 'penerimaantrucking' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '70px',
            search: false,
          hidden: true
        },
        {
          label: 'KODE PENERIMAAN',
          name: 'kodepenerimaan',
          align: 'left',
        },
        {
          label: 'KETERANGAN',
          name: 'keterangan',
          align: 'left'
        },
        {
          label: 'COA',
          name: 'coa',
          align: 'left'
        },
        {
          label: 'FORMAT BUKTI',
          name: 'format',
          align: 'left',
          formatter: (value, options, rowData) => {
            let statusFormat = JSON.parse(value)

            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusFormat.WARNA}; color: #fff;">
                  <span>${statusFormat.SINGKATAN}</span>
                </div>
              `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusFormat = JSON.parse(rowObject.format)

            return ` title="${statusFormat.MEMO}"`
          }
        },
        {
          label: 'MODIFIEDBY',
          name: 'modifiedby',
          align: 'left'
        },
        {
          label: 'CREATEDAT',
          name: 'created_at',
          align: 'right',
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y H:i:s"
          }
        },
        {
          label: 'UPDATEDAT',
          name: 'updated_at',
          align: 'right',
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
      sortable: true,
      toolbar: [true, "top"],
      sortname: 'id',
      sortorder: 'asc',
      page: 1,
      pager: $('#penerimaanTruckingLookupPager'),
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
      loadBeforeSend: (jqXHR) => {
        jqXHR.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      loadComplete: function(data) {
          changeJqGridRowListText()
        if (detectDeviceType() == 'desktop') {
          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))

          if (indexRow - 1 > $('#penerimaanTruckingLookup').getGridParam().reccount) {
            indexRow = $('#penerimaanTruckingLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#penerimaanTruckingLookup [id="${$('#penerimaanTruckingLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#penerimaanTruckingLookup [id="${$('#penerimaanTruckingLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#penerimaanTruckingLookup').getDataIDs()[indexRow] == undefined) {
              $(`#penerimaanTruckingLookup [id="` + $('#penerimaanTruckingLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#penerimaanTruckingLookup').setSelection($('#penerimaanTruckingLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookupPenerimaanTrucking').prev().width())
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
        clearGlobalSearch($('#penerimaanTruckingLookup'))
      },
    })

  loadGlobalSearch($('#penerimaanTruckingLookup'))
  loadClearFilter($('#penerimaanTruckingLookup'))
</script>