<table id="pengeluaranStokDetailLookup" class="lookup-grid" style="width: 100%;"></table>
{{-- <div id="pengeluaranStokDetailLookupPager"></div> --}}

<script>
  $('#pengeluaranStokDetailLookup').jqGrid({
      url: `{!! $url ?? config('app.api_url')  !!}` + 'pengeluaranstokdetail',
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      postData: {
        penerimaanstokheader_id: `{!! $penerimaanstokheader_id ?? '' !!}`, //dari klaim
        pengeluaranstokheader_id: `{!! $pengeluaranstokheader_id ?? '' !!}`,
        penerimaanstokheader_nobukti: `{!! $penerimaanstokheader_nobukti ?? '' !!}`,
        cabang: `{!! $cabang ?? '' !!}`,
        from: `{!! $from ?? '' !!}`,
        stok_id: `{!! $stok_id ?? '' !!}`,
      },
      idPrefix: 'pengeluaranStokDetailLookup',
      colModel: [{
          label: 'NO BUKTI',
          name: 'nobukti',
        },
        {
          label: 'stok',
          name: 'stok',
        },

        {
          label: 'qty',
          name: 'qty',
          align: 'right',
          formatter: currencyFormat,
        },
        {
          label: 'harga',
          name: 'harga',
          align: 'right',
          formatter: currencyFormat,
        },

        {
          label: 'persentase discount',
          name: 'persentasediscount',
          align: 'right',
          formatter: currencyFormat,
        },
        {
          label: 'nominaldiscount',
          name: 'nominaldiscount',
          align: 'right',
          formatter: currencyFormat,
        },
        {
          label: 'vulkanisirke',
          name: 'vulkanisirke',
        },
        {
          label: 'TOTAL',
          name: 'total',
          align: 'right',
          formatter: currencyFormat,
        },
        {
          label: 'KETERANGAN',
          name: 'keterangan',
          width: (detectDeviceType() == "desktop") ? md_dekstop_4 : md_mobile_4,
        },
        {
          label: 'MODIFIED BY',
          name: 'modifiedby',
        },
        {
          label: 'stok_id',
          name: 'stok_id',
          align: 'right',
          width: '70px',
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
      sortname: 'nobukti',
      sortorder: 'asc',
      toolbar: [true, "top"],
      page: 1,
      // pager: $('#pengeluaranStokDetailLookupPager'),
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
        cab = `{!! $cabang ?? '' !!}`;
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

          if (indexRow - 1 > $('#pengeluaranStokDetailLookup').getGridParam().reccount) {
            indexRow = $('#pengeluaranStokDetailLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#pengeluaranStokDetailLookup [id="${$('#pengeluaranStokDetailLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#pengeluaranStokDetailLookup [id="${$('#pengeluaranStokDetailLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#pengeluaranStokDetailLookup').getDataIDs()[indexRow] == undefined) {
              $(`#pengeluaranStokDetailLookup [id="` + $('#pengeluaranStokDetailLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#pengeluaranStokDetailLookup').setSelection($('#pengeluaranStokDetailLookup').getDataIDs()[indexRow])
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

        clearGlobalSearch($('#pengeluaranStokDetailLookup'))
      },
    })
    .customPager()
  loadGlobalSearch($('#pengeluaranStokDetailLookup'))
  loadClearFilter($('#pengeluaranStokDetailLookup'))
</script>