<table id="penerimaanStokHeaderLookup" class="lookup-grid" style="width: 100%;"></table>
<div id="penerimaanStokHeaderLookupPager"></div>

<script>
  // var sendedFilters = `{!! $filters ?? '' !!}`

  $('#penerimaanStokHeaderLookup').jqGrid({
      url: `{{ config('app.api_url') . 'penerimaanstokheader' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      postData: {
        penerimaanstok_id: `{!! $penerimaanstok_id ?? '' !!}`,
        // filters: `{!! $filters ?? '' !!}`
        supplier_id: `{!! $supplier_id ?? '' !!}`,
        pengeluaranstok_id: `{!! $pengeluaranstok_id ?? '' !!}`,
      },
      colModel: [{
            label: 'ID',
            name: 'id',
            align: 'right',
            width: '50px',
            hidden: true
          },
          {
            label: 'NO. BUKTI',
            name: 'nobukti',
            align: 'left'
          },
          {
            label: 'TANGGAL BUKTI',
            name: 'tglbukti',
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'PENERIMAAN Stok',
            name: 'penerimaanstok',
            align: 'left'
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
            align: 'left'
          },
          {
            label: 'Penerimaan nobukti',
            name: 'penerimaanstok_nobukti',
            align: 'left'
          },
          {
            label: 'Pengeluaran nobukti',
            name: 'pengeluaranstok_nobukti',
            align: 'left'
          },
          {
            label: 'Gudang',
            name: 'gudangs',
            align: 'left'
          },
          {
            label: 'Trado',
            name: 'trado',
            align: 'left'
          },
          {
            label: 'supplier',
            name: 'supplier',
            align: 'left'
          },
          {
            label: 'nobon',
            name: 'nobon',
            align: 'left'
          },
          {
            label: 'no bukti Hutang',
            name: 'hutang_nobukti',
            align: 'left'
          },
          {
            label: 'Status format',
            name: 'statusformat',
            align: 'left'
          },
          {
            label: 'gudang dari',
            name: 'gudangdari',
            align: 'left'
          },
          {
            label: 'gudang ke',
            name: 'gudangke',
            align: 'left'
          },
          {
            label: 'COA',
            name: 'coa',
            align: 'left'
          },
          {
            label: 'keterangan',
            name: 'keterangan',
            align: 'left'
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
      rowList: [10, 20, 50],
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      toolbar: [true, "top"],
      page: 1,
      pager: $('#penerimaanStokHeaderLookupPager'),
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
        if (detectDeviceType() == 'desktop') {
          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))

          if (indexRow - 1 > $('#penerimaanStokHeaderLookup').getGridParam().reccount) {
            indexRow = $('#penerimaanStokHeaderLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#penerimaanStokHeaderLookup [id="${$('#penerimaanStokHeaderLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#penerimaanStokHeaderLookup [id="${$('#penerimaanStokHeaderLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#penerimaanStokHeaderLookup').getDataIDs()[indexRow] == undefined) {
              $(`#penerimaanStokHeaderLookup [id="` + $('#penerimaanStokHeaderLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#penerimaanStokHeaderLookup').setSelection($('#penerimaanStokHeaderLookup').getDataIDs()[indexRow])
          }
        }

        /* Set global variables */
        sortname = $(this).jqGrid("getGridParam", "sortname")
        sortorder = $(this).jqGrid("getGridParam", "sortorder")
        totalRecord = $(this).getGridParam("records")
        limit = $(this).jqGrid('getGridParam', 'postData').limit
        postData = $(this).jqGrid('getGridParam', 'postData')

        $('.clearsearchclass').click(function() {
          clearColumnSearch()
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
        clearGlobalSearch($('#penerimaanStokHeaderLookup'))
        // let currentFilters = JSON.parse($(this).jqGrid('getGridParam').postData.filters)
        // if (JSON.parse(sendedFilters).rules[0]) {
        //   currentFilters.rules.push(JSON.parse(sendedFilters).rules[0])
        //   console.log(currentFilters);
        // }else{
        //   console.log('das');
        // }

        // $(this).jqGrid('setGridParam', {
        //   postData: {
        //     filters: JSON.stringify(currentFilters),
        //   }
        // })
      },
    })
  loadGlobalSearch($('#penerimaanStokHeaderLookup'))
  // additionalRulesGlobalSearch(sendedFilters)

  loadClearFilter($('#penerimaanStokHeaderLookup'))
</script>

