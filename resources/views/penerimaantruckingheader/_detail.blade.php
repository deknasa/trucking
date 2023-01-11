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
  let detailIndexUrl = "{{ route('penerimaantruckingdetail.index') }}"
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
        url: `{{ config('app.api_url') . 'penerimaantruckingdetail' }}`,
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
            label: 'SUPIR',
            name: 'supir_id',
          },
          {
            label: 'NO BUKTI PENGELUARAN TRUCKING',
            name: 'pengeluarantruckingheader_nobukti',
          },
          {
            label: 'NOMINAL',
            name: 'nominal',
            formatter: 'number', 
            formatoptions:{thousandsSeparator: ",", decimalPlaces: 0},
            align: "right",
          }
        ],
        autowidth: true,
        shrinkToFit: false,
        height: 350,
        rowNum: 10,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [10, 20, 50],
        toolbar: [true, "top"],
        sortable: true,
        // pager: pager,
        prmNames: {
          sort: 'sortIndex',
          order: 'sortOrder',
          rows: 'limit'
        },
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
      }).customPager()
  }

  function loadDetailData(id) {
    $('#detail').setGridParam({
      url: detailIndexUrl,
      datatype: "json",
      postData: {
        penerimaantruckingheader_id: id
      }
    }).trigger('reloadGrid')
  }
</script>
@endpush()