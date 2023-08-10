<table id="penerimaanStokLookup" class="lookup-grid" style="width: 100%;"></table>
{{-- <div id="penerimaanStokLookupPager"></div> --}}

<script>
  $('#penerimaanStokLookup').jqGrid({
      url: `{{ config('app.api_url') . 'penerimaanstok' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      idPrefix: 'penerimaanStokLookup',
      colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '70px',
            search: false,
          hidden: true
        },
        {
          label: 'PENERIMAAN',
          name: 'kodepenerimaan',
          align: 'left',
        },
        {
          label: 'KETERANGAN',
          name: 'keterangan',
          align: 'left'
        },
        {
          label: 'KODE PERKIRAAN',
          name: 'coa',
          align: 'left'
        },
        {
          label: 'FORMAT BUKTI',
          name: 'format',
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
        // {
        //   label: 'status format text',
        //   name: 'statusformattext',
        //   align: 'left',
        //   hidden: true
        // },
        // {
        //   label: 'status format id',
        //   name: 'statusformatid',
        //   align: 'left',
        //   // hidden: true
        // },

        {
          label: 'STATUS HITUNG STOK',
          name: 'statushitungstok',
          formatter: (value, options, rowData) => {
            let statusHitungstok = JSON.parse(value)

            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusHitungstok.WARNA}; color: #fff;">
                  <span>${statusHitungstok.SINGKATAN}</span>
                </div>
              `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusHitungstok = JSON.parse(rowObject.statushitungstok)

            return ` title="${statusHitungstok.MEMO}"`
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
      rowNum: 20,
      rownumbers: true,
      rownumWidth: 45,
      rowList: [10, 20, 50, 0],
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      toolbar: [true, "top"],
      page: 1,
      // pager: $('#penerimaanStokLookupPager'),
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

          if (indexRow - 1 > $('#penerimaanStokLookup').getGridParam().reccount) {
            indexRow = $('#penerimaanStokLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#penerimaanStokLookup [id="${$('#penerimaanStokLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#penerimaanStokLookup [id="${$('#penerimaanStokLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#penerimaanStokLookup').getDataIDs()[indexRow] == undefined) {
              $(`#penerimaanStokLookup [id="` + $('#penerimaanStokLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#penerimaanStokLookup').setSelection($('#penerimaanStokLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookupPenerimaanStok').prev().width())
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

        clearGlobalSearch($('#penerimaanStokLookup'))
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
  loadGlobalSearch($('#penerimaanStokLookup'))
  loadClearFilter($('#penerimaanStokLookup'))
</script>