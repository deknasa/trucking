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
  let detailIndexUrl = "{{ route('pelunasanpiutangdetail.index') }}"
  // /**
  //  * Custom Functions
  //  */
  // var delay = (function() {
  //   var timer = 0;
  //   return function(callback, ms) {
  //     clearTimeout(timer);
  //     timer = setTimeout(callback, ms);
  //   };
  // })()

  function loadDetailGrid(id) {
    let pager = '#detailPager'

    $("#detail").jqGrid({
        url: `{{ config('app.api_url') . 'pelunasanpiutangdetail' }}`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "local",
        colModel: [
          {
            label: 'NO BUKTI',
            name: 'nobukti',
          },
          {
            label: 'PELANGGAN',
            name: 'pelanggan_id',
          },
          {
            label: 'AGEN',
            name: 'agen_id',
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
            formatoptions:{thousandsSeparator: ",", decimalPlaces: 0},
            align: "right",
            summaryType:'sum'
          },
          {
            label: 'KET. PENYESUAIAN',
            name: 'keteranganpenyesuaian',
          },
          {
            label: 'PENYESUAIAN',
            name: 'penyesuaian',
            formatter: 'number', 
            formatoptions:{thousandsSeparator: ",", decimalPlaces: 0},
            align: "right",
            summaryType:'sum'
          },
          {
            label: 'NOMINAL LEBIH BAYAR',
            name: 'nominallebihbayar',
            formatter: 'number', 
            formatoptions:{thousandsSeparator: ",", decimalPlaces: 0},
            align: "right",
            summaryType:'sum'
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
        viewrecords: true,
        
        footerrow:true,
         userDataOnFooter: true,
        loadComplete: function() {
          initResize($(this))

          let nominals = $(this).jqGrid("getCol", "nominal")
          let totalNominal = 0
          let penyesuaians = $(this).jqGrid("getCol", "penyesuaian")
          let totalPenyesuaian = 0
          let lebihbayars = $(this).jqGrid("getCol", "lebihbayar")
          let totalLebihBayar = 0

          if (nominals.length > 0) {
            totalNominal = nominals.reduce((previousValue, currentValue) => previousValue + currencyUnformat(currentValue), 0)
          }
          if (penyesuaians.length > 0) {
            totalPenyesuaian = penyesuaians.reduce((previousValue, currentValue) => previousValue + currencyUnformat(currentValue), 0)
          }
          if (lebihbayars.length > 0) {
            totalLebihBayar = lebihbayars.reduce((previousValue, currentValue) => previousValue + currencyUnformat(currentValue), 0)
          }

          $(this).jqGrid('footerData', 'set', {
            nobukti: 'Total:',
            nominal: totalNominal,
            penyesuaian: totalPenyesuaian,
            nominallebihbayar: totalLebihBayar,
          }, true)
        }
      })

      .customPager()
  }

  function loadDetailData(id) {
    $('#detail').setGridParam({
      url: detailIndexUrl,
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