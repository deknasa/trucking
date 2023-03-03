<!-- Grid -->
<div class="container-fluid my-4">
  <div class="row">
    <div class="col-12 col-md-12">
      <table id="detail"></table>
      <div id="detailPager"></div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  function loadDetailGrid(id) {
    let pager = '#detailPager'

    $("#detail").jqGrid({
        url: `${apiUrl}pelunasanpiutangdetail`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "local",
        colModel: [{
            label: 'NO BUKTI',
            name: 'nobukti',
          },
          {
            label: 'NO BUKTI PIUTANG',
            name: 'piutang_nobukti',
          },
          {
            label: 'NO BUKTI INVOICE',
            name: 'invoice_nobukti',
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
          },
          {
            label: 'NOMINAL',
            name: 'nominal',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'KET. POTONGAN',
            name: 'keteranganpotongan',
          },
          {
            label: 'COA POTONGAN',
            name: 'coapotongan',
            width: 220
          },
          {
            label: 'POTONGAN',
            name: 'potongan',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'NOMINAL LEBIH BAYAR',
            name: 'nominallebihbayar',
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
        toolbar: [true, "top"],
        sortable: true,
        sortname: sortname,
        sortorder: sortorder,
        page: page,
        footerrow: true,
        userDataOnFooter: true,
        viewrecords: true,
        postData: {
          pelunasanpiutang_id: id
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
              potongan: data.attributes.totalPotongan,
              nominallebihbayar: data.attributes.totalNominalLebih,
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
      url: `${apiUrl}pelunasanpiutangdetail`,
      datatype: "json",
      postData: {
        pelunasanpiutang_id: id
      }
    }).trigger('reloadGrid')
  }

  // var $footRow = $("#detail").closest(".ui-jqgrid-bdiv")
  //   .next(".ui-jqgrid-sdiv")
  //   .find(".footrow");

  // $footRow.find('>td[aria-describedby="detail_nobukti"]')
  //   .css("border-right-color", "transparent");
</script>
@endpush()