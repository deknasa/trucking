<table id="pengeluaranStokLookup" class="lookup-grid" style="width: 100%;"></table>
{{-- <div id="pengeluaranStokLookupPager"></div> --}}

<script>
  $('#pengeluaranStokLookup').jqGrid({
      url: `{{ config('app.api_url') . 'pengeluaranstok' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      idPrefix: 'pengeluaranStokLookup',
      postData: {
        aktif: `{!! $Aktif ?? '' !!}`,        
        roleinput: `{!! $roleInput ?? '' !!}`,        
        isLookup: `{!! $isLookup ?? '' !!}`,
        // filters: `{!! $filters ?? '' !!}`
      },
      colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '70px',
            search: false,
          hidden: true
        },
        {
          label: 'Pengeluaran',
          name: 'kodepengeluaran',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left',
        },
        {
          label: 'KETERANGAN',
          name: 'keterangan',
          width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
          align: 'left'
        },
        {
          label: 'KODE PERKIRAAN',
          name: 'coa',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
          align: 'left'
        },
        {
          label: 'FORMAT BUKTI',
          name: 'format',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          formatter: (value, options, rowData) => {
            let statusFormat = JSON.parse(value)
            let Format = JSON.parse(value)

            // let formattedValue = $(`
            //     <div class="badge" style="background-color: ${statusFormat.WARNA}; color: #fff;">
            //       <span>${statusFormat.SINGKATAN}</span>
            //     </div>
            //   `)

            return Format.SINGKATAN
            // return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusFormat = JSON.parse(rowObject.format)

            return ` title="${statusFormat.MEMO}"`
          }
        },             
        {
          label: 'status format text',
          name: 'statusformattext',
          align: 'left',
          hidden: true
        },
        {
          label: 'status format id',
          name: 'statusformatid',
          align: 'left',
          hidden: true
        },        
        {
          label: 'STATUS HITUNG STOK',
          name: 'statushitungstok',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
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
          label: 'MODIFIED BY',
          name: 'modifiedby',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left'
        },
          {
            label: 'CREATED AT',
            name: 'created_at',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            align: 'right',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y H:i:s"
            }
          },
          {
            label: 'UPDATED AT',
            name: 'updated_at',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
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
      sortname: 'keterangan',
      sortorder: 'asc',
      toolbar: [true, "top"],
      page: 1,
      // pager: $('#pengeluaranStokLookupPager'),
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

          if (indexRow - 1 > $('#pengeluaranStokLookup').getGridParam().reccount) {
            indexRow = $('#pengeluaranStokLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#pengeluaranStokLookup [id="${$('#pengeluaranStokLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#pengeluaranStokLookup [id="${$('#pengeluaranStokLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#pengeluaranStokLookup').getDataIDs()[indexRow] == undefined) {
              $(`#pengeluaranStokLookup [id="` + $('#pengeluaranStokLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#pengeluaranStokLookup').setSelection($('#pengeluaranStokLookup').getDataIDs()[indexRow])
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

        clearGlobalSearch($('#pengeluaranStokLookup'))
      },
    })
    .customPager()
  loadGlobalSearch($('#pengeluaranStokLookup'))
  loadClearFilter($('#pengeluaranStokLookup'))
</script>
