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
  function loadDetailGrid(id) {
    let pager = '#detailPager'

    $("#detail").jqGrid({
        url: `${apiUrl}absensisupirdetail`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        colModel: [{
            label: 'TRADO',
            name: 'trado'
          },
          {
            label: 'SUPIR',
            name: 'supir',
          },
          {
            label: 'STATUS',
            name: 'status',
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan_detail',
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
        rowNum: 10,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [10, 20, 50],
        toolbar: [true, "top"],
        sortable: true,
        // pager: pager,
        viewrecords: true,
        footerrow:true,
        userDataOnFooter: true,
        postData: {
          absensi_id: id
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
          jqXHR.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
        },
        onSelectRow: function(id) {
          activeGrid = $(this)
        },
        loadComplete: function(data) {
          initResize($(this))
          
          let nominals = $(this).jqGrid("getCol", "uangjalan")
          let totalNominal = 0

          if (nominals.length > 0) {
            totalNominal = nominals.reduce((previousValue, currentValue) => previousValue + currencyUnformat(currentValue), 0)
          }

          $(this).jqGrid('footerData', 'set', {
            trado: 'Total:',
            uangjalan: totalNominal,
          }, true)
        }
      })

      .customPager()
  }

  function loadDetailData(id) {
    $('#detail').setGridParam({
      url: `${apiUrl}absensisupirdetail`,
      datatype: "json",
      postData: {
        absensi_id: id
      }
    }).trigger('reloadGrid')
  }
</script>
@endpush()