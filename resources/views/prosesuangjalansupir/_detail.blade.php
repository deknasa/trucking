<!-- Grid -->
<div class="container-fluid my-4">
  <div class="row">
    <div class="col-12">
      <table id="detail"></table>
      <div id="detailPager"></div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  function loadDetailGrid(id) {

    $("#detail").jqGrid({
        url: `${apiUrl}prosesuangjalansupirdetail`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "local",
        colModel: [
          // {
          //   label: 'PENERIMAAN',
          //   name: 'prosesuangjalansupir_id',
          // },
          {
            label: 'NO BUKTI',
            name: 'nobukti',
          },
          {
            label: 'NO. BUKTI PENERIMAAN',
            name: 'penerimaantrucking_nobukti',
          },
          {
            label: 'TGL PENERIMAAN',
            name: 'penerimaantrucking_tglbukti',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'BANK PENERIMAAN',
            name: 'penerimaantrucking_bank_id',
          },
          {
            label: 'NO. BUKTI PENGELUARAN',
            name: 'pengeluarantrucking_nobukti',
          },
          {
            label: 'TGL PENGELUARAN',
            name: 'pengeluarantrucking_tglbukti',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'BANK PENGELUARAN',
            name: 'pengeluarantrucking_bank_id',
          },
          {
            label: 'NO. BUKTI PENGEMBALIAN KAS GANTUNG',
            name: 'pengembaliankasgantung_nobukti',
          },
          {
            label: 'TGL PENGEMBALIAN KAS GANTUNG',
            name: 'pengembaliankasgantung_tglbukti',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'BANK PENGEMBALIAN KAS GANTUNG',
            name: 'pengembaliankasgantung_bank_id',
          },
          {
            label: 'PROSES UANG JALAN',
            name: 'statusprosesuangjalan',
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
          },
          {
            label: 'NOMINAL',
            name: 'nominal',
            align: 'right',
            formatter: currencyFormat
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
          prosesuangjalansupir_id: id
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
              nominal: data.attributes.totalNominal,
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
      url: `${apiUrl}prosesuangjalansupirdetail`,
      datatype: "json",
      postData: {
        prosesuangjalansupir_id: id
      }
    }).trigger('reloadGrid')
  }
</script>
@endpush()