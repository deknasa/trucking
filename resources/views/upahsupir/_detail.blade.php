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
  let detailIndexUrl = "{{ route('upahsupirrincian.index') }}"

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
        url: `{{ config('app.api_url') . 'upahsupirrincian' }}`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "local",
        colModel: [
          {
            label: 'CONTAINER',
            name: 'container_id',
          },
          {
            label: 'STATUS CONTAINER',
            name: 'statuscontainer_id',
          },
          {
            label: 'NOMINAL SUPIR',
            name: 'nominalsupir',
            align: 'right',
            formatter: currencyFormat
          },
          {
            label: 'NOMINAL KENEK',
            name: 'nominalkenek',
            align: 'right',
            formatter: currencyFormat
          },
          {
            label: 'NOMINAL KOMISI',
            name: 'nominalkomisi',
            align: 'right',
            formatter: currencyFormat
          },
          {
            label: 'NOMINAL TOL',
            name: 'nominaltol',
            align: 'right',
            formatter: currencyFormat
          },
          {
            label: 'LITER',
            name: 'liter',
            align: 'right',
            formatter: currencyFormat
          }
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
        datatype: 'json',
        postData: {
          upahsupir_id: id
        }
      }).trigger('reloadGrid')
  }
</script>
@endpush()