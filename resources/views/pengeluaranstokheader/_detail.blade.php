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
  let detailIndexUrl = "{{ route('pengeluaranstokdetail.index') }}"
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
        url: `{{ config('app.api_url') . 'pengeluaranstokdetail' }}`,
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
            label: 'stok',
            name: 'stok',
          },         
          
          {
            label: 'qty',
            name: 'qty',
            align: 'right',
            formatter: 'currency',
            formatoptions: {
              decimalSeparator: '.',
              thousandsSeparator: ',',
              decimalPlaces:0              
            }
          },
          {
            label: 'harga',
            name: 'harga',
            align: 'right',
            formatter: 'currency',
            formatoptions: {
              decimalSeparator: '.',
              thousandsSeparator: ',',
              decimalPlaces:0              
            }
          },
          
          {
            label: 'persentasediscount',
            name: 'persentasediscount',
            align: 'right',
            formatter: 'currency',
            formatoptions: {
              decimalSeparator: '.',
              thousandsSeparator: ',',
              decimalPlaces:0              
            }
          },
          {
            label: 'nominaldiscount',
            name: 'nominaldiscount',
            align: 'right',
            formatter: 'currency',
            formatoptions: {
              decimalSeparator: '.',
              thousandsSeparator: ',',
              decimalPlaces:0              
            }
          },
          {
            label: 'vulkanisirke',
            name: 'vulkanisirke',
          },
          {
            label: 'TOTAL',
            name: 'total',
            align: 'right',
            formatter: 'currency',
            formatoptions: {
              decimalSeparator: '.',
              thousandsSeparator: ',',
              decimalPlaces:0              
            }
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
          },
          {
            label: 'modifiedby',
            name: 'modifiedby',
          },
         
        
        ],
        autowidth: true,
        shrinkToFit: false,
        height: 350,
        rowNum: 0,
        rownumbers: true,
        footerrow: true,
		    userDataOnFooter: true,
        rownumWidth: 45,
        rowList: [10, 20, 50],
        toolbar: [true, "top"],
        sortable: true,
        pager: pager,
        viewrecords: true,
        loadComplete: function(data) {
          detailsPostData = $(this).jqGrid('getGridParam', 'postData')
          
          sum = $('#detail').jqGrid("getCol", "total", false, "sum")
    
          $(this).jqGrid('footerData', 'set', {
            vulkanisirke:"Total",
            total: sum,
          }, true)
          
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
        pengeluaranstokheader_id: id
      }
    }).trigger('reloadGrid')
  }
</script>
@endpush()