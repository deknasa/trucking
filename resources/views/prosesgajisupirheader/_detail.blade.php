<!-- Grid -->
<div class="container-fluid my-4">
  <div class="row">
    <div class="col-12">
      <table id="detail"></table>
    </div>
  </div>
</div>

@push('scripts')
<script>
  function loadDetailGrid(id) {
    $("#detail").jqGrid({
        url: `${apiUrl}prosesgajisupirdetail`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "local",
        colModel: [{
            label: 'NO RINCIAN',
            name: 'gajisupir_nobukti',
          },
          {
            label: 'NO BK',
            name: 'trado_id',
          },
          {
            label: 'SUPIR',
            name: 'supir_id',
          }, 
          {
            label: 'BORONGAN',
            name: 'total',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'U. JALAN',
            name: 'uangjalan',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'U. BBM',
            name: 'bbm',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'U. Makan',
            name: 'uangmakanharian',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'Pot. Pinjaman',
            name: 'potonganpinjaman',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'Pot. Pinjaman (semua)',
            name: 'potonganpinjamansemua',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'DEPOSITO',
            name: 'deposito',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'Komisi Supir',
            name: 'komisisupir',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'TOL',
            name: 'tolsupir',
            align: 'right',
            formatter: currencyFormat,
          },
        ],
        autowidth: true,
        shrinkToFit: false,
        height: 350,
        rowNum: 10,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [10, 20, 50, 0],
        footerrow: true,
        userDataOnFooter: true,
        toolbar: [true, "top"],
        sortable: true,
        sortname: sortname,
        sortorder: sortorder,
        page: page,
        viewrecords: true,
        postData: {
          prosesgajisupir_id: id
        },
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
        loadBeforeSend: (jqXHR) => {
          jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)
        },
        onSelectRow: function(id) {
          activeGrid = $(this)
        },
        loadComplete: function(data) {
          changeJqGridRowListText()
          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))

          /* Set global variables */
          sortname = $(this).jqGrid("getGridParam", "sortname")
          sortorder = $(this).jqGrid("getGridParam", "sortorder")
          totalRecord = $(this).getGridParam("records")
          limit = $(this).jqGrid('getGridParam', 'postData').limit
          postData = $(this).jqGrid('getGridParam', 'postData')
          triggerClick = true

          $('.clearsearchclass').click(function() {
            clearColumnSearch($(this))
          })

          if (indexRow > $(this).getDataIDs().length - 1) {
            indexRow = $(this).getDataIDs().length - 1;
          }

          $('#detail').setSelection($('#detail').getDataIDs()[0])

          setHighlight($(this))

          if (data.attributes) {
            $(this).jqGrid('footerData', 'set', {
              nobukti: 'Total:',
              total: data.attributes.totalNominal,
              uangjalan: data.attributes.totalUangJalan,
              bbm: data.attributes.totalBBM,
              uangmakanharian: data.attributes.totalUangMakan,
              potonganpinjaman: data.attributes.totalPinjaman,
              potonganpinjamansemua: data.attributes.totalPinjamanSemua,
              deposito: data.attributes.totalDeposito,
              komisisupir: data.attributes.totalKomisi,
              tolsupir: data.attributes.totalTol
            }, true)
          }
        }
      })
      .jqGrid("setLabel", "rn", "No.")
      .jqGrid('filterToolbar', {
        stringResult: true,
        searchOnEnter: false,
        defaultSearch: 'cn',
        groupOp: 'AND',
        disabledKeys: [17, 33, 34, 35, 36, 37, 38, 39, 40],
        beforeSearch: function() {
          clearGlobalSearch($('#detail'))
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

    /* Append clear filter button */
    loadClearFilter($('#detail'))

    /* Append global search */
    loadGlobalSearch($('#detail'))
  }

  function loadDetailData(id) {
    $('#detail').setGridParam({
      url: `${apiUrl}prosesgajisupirdetail`,
      datatype: "json",
      postData: {
        prosesgajisupir_id: id
      },
      page:1
    }).trigger('reloadGrid')
  }
</script>
@endpush()