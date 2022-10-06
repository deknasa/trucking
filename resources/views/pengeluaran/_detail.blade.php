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
  let detailIndexUrl = "{{ route('pengeluarandetail.index') }}"
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
        url: `{{ config('app.api_url') . 'pengeluarandetail' }}`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "local",
        //datatype: "json",
        colModel: [
          // {
          //   label: 'PENGELUARAN',
          //   name: 'pengeluaran_id',
          // },
          {
            label: 'NO BUKTI',
            name: 'nobukti',
          }, 
          {
            label: 'ALAT BAYAR',
            name: 'alatbayar_id',
          }, 
          {
            label: 'NO WARKAT',
            name: 'nowarkat',
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
            label: 'NOMINAL',
            name: 'nominal',
            align: 'right',
            formatter: 'currency',
            formatoptions: {
              decimalSeparator: ',',
                thousandsSeparator: '.'
            }
          },
          {
            label: 'COA DEBET',
            name: 'coadebet',
          },
          {
            label: 'COA KREDIT',
            name: 'coakredit',
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
          }, 
          {
            label: 'BULAN BEBAN',
            name: 'bulanbeban',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
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
      datatype: "json",
      postData: {
        pengeluaran_id: id
      }
    }).trigger('reloadGrid')
  }
</script>
@endpush()