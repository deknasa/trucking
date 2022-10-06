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
  let detailIndexUrl = "{{ route('hutangbayardetail.index') }}"
  /**
   * Custom Functions
   */
  var delay = (function() {
    var timer = 0;
    return function(callback, ms) {
      clearTimeout(timer);
      timer = setTimeout(callback, ms);
    };
  })()

  function loadDetailGrid() {
    let pager = '#detailPager'

    $("#detail").jqGrid({
        url: `{{ config('app.api_url') . 'hutangbayardetail' }}`,
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
            label: 'NOMINAL',
            name: 'nominal',
            formatter: 'number', 
            formatoptions:{thousandsSeparator: ",", decimalPlaces: 0},
            align: "right",
          },
          {
            label: 'NO BUKTI HUTANG',
            name: 'hutang_nobukti',
          },
          {
            label: 'CICILAN',
            name: 'cicilan',
          },
          {
            label: 'ALATBAYAR',
            name: 'alatbayar_id',
          },
          {
            label: 'TGL CAIR',
            name: 'tglcair',
          },
          {
            label: 'POTONGAN',
            name: 'potongan',
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
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
        pager: pager,
        viewrecords: true,
        loadComplete: function(data) {
        }
      })

      .jqGrid("navGrid", pager, {
        search: false,
        refresh: false,
        add: false,
        edit: false,
        del: false,
      })
  }

  function loadDetailData(id) {
    $('#detail').setGridParam({
      url: detailIndexUrl,
      datatype: "json",
      postData: {
        hutangbayar_id: id
      }
    }).trigger('reloadGrid')
  }
</script>
@endpush()