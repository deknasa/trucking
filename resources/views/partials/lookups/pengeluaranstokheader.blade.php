<table id="pengeluaranStokHeaderLookup" class="lookup-grid" style="width: 100%;"></table>
<div id="pengeluaranStokHeaderLookupPager"></div>



<script>
  $('#pengeluaranStokHeaderLookup').jqGrid({
      url: `{{ config('app.api_url') . 'pengeluaranstokheader' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      colModel: [{
            label: 'ID',
            name: 'id',
            align: 'right',
            width: '50px'
          },
          {
            label: 'NO BUKTI',
            name: 'nobukti',
            align: 'left'
          },
          {
            label: 'servicein nobukti',
            name: 'servicein_nobukti',
            align: 'left'
          },
          {
            label: 'kerusakan',
            name: 'kerusakan',
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
            label: 'Pengeluaran Stok',
            name: 'pengeluaranstok',
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
<<<<<<< Updated upstream
            name: 'gudang',
=======
            name: 'gudangs',
>>>>>>> Stashed changes
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
<<<<<<< Updated upstream
=======
            label: 'no bukti Hutang',
            name: 'hutang_nobukti',
            align: 'left'
          },
          {
>>>>>>> Stashed changes
            label: 'Status format',
            name: 'statusformat',
            align: 'left'
          },
          {
            label: 'MODIFIEDBY',
            name: 'modifiedby',
            align: 'left'
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
<<<<<<< Updated upstream
      toolbar: [true, "top"],
=======
>>>>>>> Stashed changes
      page: 1,
      pager: $('#pengeluaranStokHeaderLookupPager'),
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

          if (indexRow - 1 > $('#pengeluaranStokHeaderLookup').getGridParam().reccount) {
            indexRow = $('#pengeluaranStokHeaderLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#pengeluaranStokHeaderLookup [id="${$('#pengeluaranStokHeaderLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#pengeluaranStokHeaderLookup [id="${$('#pengeluaranStokHeaderLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#pengeluaranStokHeaderLookup').getDataIDs()[indexRow] == undefined) {
              $(`#pengeluaranStokHeaderLookup [id="` + $('#pengeluaranStokHeaderLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#pengeluaranStokHeaderLookup').setSelection($('#pengeluaranStokHeaderLookup').getDataIDs()[indexRow])
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

<<<<<<< Updated upstream
    .jqGrid('filterToolbar', {
      stringResult: true,
      searchOnEnter: false,
      defaultSearch: 'cn',
      groupOp: 'AND',
      disabledKeys: [16, 17, 18, 33, 34, 35, 36, 37, 38, 39, 40],
      beforeSearch: function() {
        clearGlobalSearch($('#pengeluaranStokHeaderLookup'))
      },
    })

  loadGlobalSearch($('#pengeluaranStokHeaderLookup'))
  loadClearFilter($('#pengeluaranStokHeaderLookup'))
=======
    // .jqGrid('filterToolbar', {
    //   stringResult: true,
    //   searchOnEnter: false,
    //   defaultSearch: 'cn',
    //   groupOp: 'AND',
    //   disabledKeys: [16, 17, 18, 33, 34, 35, 36, 37, 38, 39, 40],
    //   beforeSearch: function() {

    //   },
    // })
>>>>>>> Stashed changes
</script>
