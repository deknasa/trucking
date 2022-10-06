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
  let detailIndexUrl = "{{ route('penerimaanstokdetail.index') }}"
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
        url: `{{ config('app.api_url') . 'penerimaanstokdetail' }}`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "local",
        colModel: [
          // {
          //   label: 'HUTANG',
          //   name: 'hutang_id',
          // },
          {
            label: 'NO BUKTI',
            name: 'nobukti',
          }, 
          {
            label: 'SUPPLIER',
            name: 'supplier_id',
          },
        
          {
            label: 'TGL JATUH TEMPO',
            name: 'tgljatuhtempo',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          }, 
          {
            label: 'TOTAL',
            name: 'total',
            align: 'right',
            formatter: 'currency',
            formatoptions: {
              decimalSeparator: ',',
              thousandsSeparator: '.'
            }
          },
          {
            label: 'CICILAN',
            name: 'cicilan',
            align: 'right',
            formatter: 'currency',
            formatoptions: {
              decimalSeparator: ',',
              thousandsSeparator: '.'
            }
          },
          {
            label: 'TOTAL BAYAR',
            name: 'totalbayar',
            align: 'right',
            formatter: 'currency',
            formatoptions: {
              decimalSeparator: ',',
              thousandsSeparator: '.'
            }
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
        hutang_id: id
      }
    }).trigger('reloadGrid')
  }
</script>
@endpush()