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
            formatter: 'number',
            formatoptions: {
              thousandsSeparator: ",",
              decimalPlaces: 0
            },
            align: "right",
            summaryType: 'sum'
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
            formatter: 'number',
            formatoptions: {
              thousandsSeparator: ",",
              decimalPlaces: 0
            },
            align: "right",
            summaryType: 'sum'
          },
          {
            label: 'NOMINAL LEBIH BAYAR',
            name: 'nominallebihbayar',
            formatter: 'number',
            formatoptions: {
              thousandsSeparator: ",",
              decimalPlaces: 0
            },
            align: "right",
            summaryType: 'sum'
          },
        ],
        autowidth: true,
        shrinkToFit: false,
        height: 350,
        rowNum: 0,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [10, 20, 50],
        toolbar: [true, "top"],
        sortable: true,
        // pager: pager,
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
        loadComplete: function() {
          initResize($(this))

          let nominals = $(this).jqGrid("getCol", "nominal")
          let totalNominal = 0
          let potongans = $(this).jqGrid("getCol", "potongan")
          let totalPenyesuaian = 0
          let lebihbayars = $(this).jqGrid("getCol", "lebihbayar")
          let totalLebihBayar = 0

          if (nominals.length > 0) {
            totalNominal = nominals.reduce((previousValue, currentValue) => previousValue + currencyUnformat(currentValue), 0)
          }
          if (potongans.length > 0) {
            totalPenyesuaian = potongans.reduce((previousValue, currentValue) => previousValue + currencyUnformat(currentValue), 0)
          }
          if (lebihbayars.length > 0) {
            totalLebihBayar = lebihbayars.reduce((previousValue, currentValue) => previousValue + currencyUnformat(currentValue), 0)
          }

          $(this).jqGrid('footerData', 'set', {
            nobukti: 'Total:',
            nominal: totalNominal,
            potongan: totalPenyesuaian,
            nominallebihbayar: totalLebihBayar,
          }, true)
        }
      })

      .customPager()
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

  var $footRow = $("#detail").closest(".ui-jqgrid-bdiv")
    .next(".ui-jqgrid-sdiv")
    .find(".footrow");

  $footRow.find('>td[aria-describedby="detail_nobukti"]')
    .css("border-right-color", "transparent");
</script>
@endpush()