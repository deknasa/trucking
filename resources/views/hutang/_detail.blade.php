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
 
  function loadDetailGrid() {
    let pager = '#detailPager'

    $("#detail").jqGrid({
        url: `${apiUrl}hutangdetail`,
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
            label: 'KETERANGAN',
            name: 'keterangan',
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
            formatter: currencyFormat,
          },
        ],
        autowidth: true,
        shrinkToFit: false,
        height: 350,
        rowNum: 10,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [10, 20, 50],
        footerrow: true,
        userDataOnFooter: true,
        toolbar: [true, "top"],
        sortable: true,
        viewrecords: true,
        postData: {
          hutang_id: id
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
        loadComplete: function(data) {
          initResize($(this))

          let nominals = $(this).jqGrid("getCol", "total")
          let totalNominal = 0

          if (nominals.length > 0) {
            totalNominal = nominals.reduce((previousValue, currentValue) => previousValue + currencyUnformat(currentValue), 0)
          }

          $(this).jqGrid('footerData', 'set', {
            nobukti: 'Total:',
            total: totalNominal,
          }, true)
        }
      })

      .customPager()
  }

  function loadDetailData(id) {
    $('#detail').setGridParam({
      url: `${apiUrl}hutangdetail`,
      datatype: "json",
      postData: {
        hutang_id: id
      }
    }).trigger('reloadGrid')
  }
</script>
@endpush()