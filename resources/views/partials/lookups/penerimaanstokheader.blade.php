@include('layouts._rangeheaderlookup')
<table id="penerimaanStokHeaderLookup" class="lookup-grid" style="width: 100%;"></table>
{{-- <div id="penerimaanStokHeaderLookupPager"></div> --}}

<script>
  // var sendedFilters = `{!! $filters ?? '' !!}`
  setRangeLookup()
  initDatepicker()
  $('#btnReloadLookup').click(function(event) {
    loadDataHeaderLookup('penerimaanstokheader', 'penerimaanStokHeaderLookup', {
      penerimaanstok_id: `{!! $penerimaanstok_id ?? '' !!}`,
      stok_id: `{!! $stok_id ?? '' !!}`,
      trado_id: `{!! $trado_id ?? '' !!}`,
      gandengan_id: `{!! $gandengan_id ?? '' !!}`,
      cabang: `{!! $cabang ?? '' !!}`,
      // filters: `{!! $filters ?? '' !!}`
      supplier_id: `{!! $supplier_id ?? '' !!}`,
      pengeluaranstok_id: `{!! $pengeluaranstok_id ?? '' !!}`,
      tgldari: $('#tgldariheaderlookup').val(),
      tglsampai: $('#tglsampaiheaderlookup').val(),
      from: `{!! $from ?? '' !!}`,
      pengeluarantrucking_id: `{!! $pengeluarantrucking_id ?? '' !!}`,
    }, `{!! $url ?? config('app.api_url')  !!}` + 'penerimaanstokheader')
  })

  $('#penerimaanStokHeaderLookup').jqGrid({
      url: `{!! $url ?? config('app.api_url')  !!}` + 'penerimaanstokheader',
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      postData: {
        penerimaanstok_id: `{!! $penerimaanstok_id ?? '' !!}`,
        stok_id: `{!! $stok_id ?? '' !!}`,
        trado_id: `{!! $trado_id ?? '' !!}`,
        gandengan_id: `{!! $gandengan_id ?? '' !!}`,
        cabang: `{!! $cabang ?? '' !!}`,
        // filters: `{!! $filters ?? '' !!}`
        supplier_id: `{!! $supplier_id ?? '' !!}`,
        pengeluaranstok_id: `{!! $pengeluaranstok_id ?? '' !!}`,
        tgldari: $('#tgldariheaderlookup').val(),
        tglsampai: $('#tglsampaiheaderlookup').val(),
        from: `{!! $from ?? '' !!}`,
        pengeluarantrucking_id: `{!! $pengeluarantrucking_id ?? '' !!}`,
      },
      idPrefix: 'penerimaanStokHeaderLookup',
      colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '50px',
          search: false,
          hidden: true
        },
        {
          label: 'NO BUKTI',
          name: 'nobukti',
          align: 'left'
        },
        {
          label: 'TGL BUKTI',
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
          label: 'Penerimaan no bukti',
          name: 'penerimaanstok_nobukti',
          align: 'left'
        },
        {
          label: 'Pengeluaran no bukti',
          name: 'pengeluaranstok_nobukti',
          align: 'left'
        },
        {
          label: 'Gudang',
          name: 'gudang',
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
          label: 'no bon',
          name: 'nobon',
          align: 'left'
        },
        {
          label: 'no bukti Hutang',
          name: 'hutang_nobukti',
          align: 'left'
        },
        {
          label: 'trado dari',
          name: 'tradodari',
          align: 'left'
        },
        {
          label: 'gandengan dari',
          name: 'gandengandari',
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
          label: 'KODE PERKIRAAN',
          name: 'coa',
          align: 'left'
        },
        {
          label: 'keterangan',
          name: 'keterangan',
          align: 'left'
        },

        {
          label: 'MODIFIED BY',
          name: 'modifiedby',
          align: 'left'
        },
        {
          label: 'CREATED AT',
          name: 'created_at',
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
          align: 'right',
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y H:i:s"
          }
        },
        {
          label: 'kelompok_id',
          name: 'kelompok_id',
          align: 'right',
          width: '50px',
          search: false,
          hidden: true
        },
        {
          label: 'stok_id',
          name: 'stok_id',
          align: 'right',
          width: '50px',
          search: false,
          hidden: true
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
      toolbar: [true, "top"],
      page: 1,
      // pager: $('#penerimaanStokHeaderLookupPager'),
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
        // cab = `{!! $cabang ?? '' !!}`;
        // if (cab == 'TNL') {
        //   jqXHR.setRequestHeader('Authorization', `Bearer ${accessTokenTnl}`)
        // } else {
          jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)
        // }
        setGridLastRequest($(this), jqXHR)
      },
      loadComplete: function(data) {
        changeJqGridRowListText()
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
    .jqGrid("navGrid", pager, {
      search: false,
      refresh: false,
      add: false,
      edit: false,
      del: false,
    })
    .customPager()
  loadGlobalSearch($('#penerimaanStokHeaderLookup'))
  // additionalRulesGlobalSearch(sendedFilters)

  loadClearFilter($('#penerimaanStokHeaderLookup'))
</script>