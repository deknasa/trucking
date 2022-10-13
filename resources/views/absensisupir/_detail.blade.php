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
  let detailIndexUrl = "{{ config('app.api_url') . 'absensisupirheader' }}"

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
        url: `${detailIndexUrl}/1/detail`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        colModel: [{
            label: 'TRADO',
            name: 'trado.keterangan',
          },
          {
            label: 'SUPIR',
            name: 'supir.namasupir',
          },
          {
            label: 'STATUS',
            name: 'absen_trado.keterangan',
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
          },
          {
            label: 'JAM',
            name: 'jam',
          },
          {
            label: 'UANG JALAN',
            name: 'uangjalan',
            formatter: 'number', 
            formatoptions:{thousandsSeparator: ",", decimalPlaces: 0},
            align: "right",
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
        footerrow:true,
        userDataOnFooter: true,
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
          jqXHR.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
        },
        onSelectRow: function(id) {
          activeGrid = $(this)
        },
        loadComplete: function(data) {
          initResize($(this))
          var $grid = $("#detail");
          var colSum = $grid.jqGrid('getCol','uangjalan');
          // var colSum = $grid.jqGrid('getCol','nominal',false,'sum');
         function untuknominal(colSum) {
                  var nominalSum = 0;

                   for(i=0; i<colSum.length; i++){
                      var ambil = parseFloat(colSum[i])
                      nominalSum += ambil
                   }

                   return nominalSum.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                  // return nominalSum.toLocaleString('en-US', {maximumFractionDigits:2})
                  // return new Intl.NumberFormat('en-US').format(nominalSum);
              }

          $grid.jqGrid('footerData','set',{jam: "TOTAL:", uangjalan : untuknominal(colSum)}, false);
        
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
      url: `${detailIndexUrl}/${id}/detail`,
    }).trigger('reloadGrid')
  }
</script>
@endpush()