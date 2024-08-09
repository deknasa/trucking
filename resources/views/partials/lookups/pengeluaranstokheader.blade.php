@include('layouts._rangeheaderlookup')
<table id="pengeluaranStokHeaderLookup" class="lookup-grid" style="width: 100%;"></table>
{{-- <div id="pengeluaranStokHeaderLookupPager"></div> --}}


<script>
  setRangeLookup()
  initDatepicker()
  $('#btnReloadLookup').click(function(event) {
    event.preventDefault()
    console.log('tekan')
    loadDataHeaderLookup('pengeluaranstokheader', 'pengeluaranStokHeaderLookup', {
      penerimaanstok_id: `{!! $penerimaanstok_id ?? '' !!}`,
      cabang: `{!! $cabang ?? '' !!}`,
      from: `{!! $from ?? '' !!}`,
      aksi: `{!! $aksi ?? '' !!}`,
      pengeluarantrucking_id: `{!! $pengeluarantrucking_id ?? '' !!}`,

      tgldari: $('#tgldariheaderlookup').val(),
      tglsampai: $('#tglsampaiheaderlookup').val(),
    }, `{!! $url ?? config('app.api_url')  !!}` + 'pengeluaranstokheader')
  })

  $('#pengeluaranStokHeaderLookup').jqGrid({
      url: `{!! $url ?? config('app.api_url')  !!}` + 'pengeluaranstokheader',
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      postData: {
        penerimaanstok_id: `{!! $penerimaanstok_id ?? '' !!}`,
        cabang: `{!! $cabang ?? '' !!}`,
        from: `{!! $from ?? '' !!}`,
        aksi: `{!! $aksi ?? '' !!}`,
        pengeluarantrucking_id: `{!! $pengeluarantrucking_id ?? '' !!}`,

        tgldari: $('#tgldariheaderlookup').val(),
        tglsampai: $('#tglsampaiheaderlookup').val(),
      },
      idPrefix: 'pengeluaranStokHeaderLookup',
      datatype: "json",
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
          label: 'gandengan',
          name: 'gandengan',
          align: 'left'
        },
        {
          label: 'supplier',
          name: 'supplier',
          align: 'left'
        },
        {
          label: 'supir',
          name: 'supir',
          align: 'left'
        },
        {
          label: 'PENgeluaran Stok',
          name: 'pengeluaranstok',
          align: 'left'
        },
        {
          label: 'Pengeluaran trucking no BUKTI',
          name: 'pengeluarantrucking_nobukti',
          align: 'left'
        },

        {
          label: 'SERVICE IN NO BUKTI',
          name: 'servicein_nobukti',
          align: 'left'
        },


        {
          label: 'Penerimaan stok no bukti',
          name: 'penerimaanstok_nobukti',
          align: 'left'
        },
        {
          label: 'Pengeluaran no bukti',
          name: 'pengeluaranstok_nobukti',
          align: 'left'
        },
        {
          label: 'Penerimaan no bukti',
          name: 'penerimaan_nobukti',
          align: 'left'
        },
        {
          label: 'kerusakan',
          name: 'kerusakan',
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
      // pager: $('#pengeluaranStokHeaderLookupPager'),
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

        clearGlobalSearch($('#pengeluaranStokHeaderLookup'))
      },
    })
    .customPager()
  loadGlobalSearch($('#pengeluaranStokHeaderLookup'))
  loadClearFilter($('#pengeluaranStokHeaderLookup'))
</script>