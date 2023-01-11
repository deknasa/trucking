<!-- Grid -->
<div class="container-fluid my-4">
  <div class="row">
    <div class="col-12">
      <table id="detail"></table>
    </div>
  </div>
</div>

@push('scripts')
<script>
  function loadDetailGrid(id) {
    $("#detail").jqGrid({
        url: `${apiUrl}gajisupirdetail`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "local",
        colModel: [
          {
            label: 'NO TRIP',
            name: 'suratpengantar_nobukti',
          },
          {
            label: 'TANGGAL BON',
            name: 'tglsp',
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          
          {
            label: 'DARI',
            name: 'dari',
          },
          {
            label: 'TUJUAN',
            name: 'sampai',
          },
          {
            label: 'NO CONT',
            name: 'nocont',
          },
          {
            label: 'NO SP',
            name: 'nosp',
          },
          {
            label: 'GAJI SUPIR',
            name: 'gajisupir',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'GAJI KENEK',
            name: 'gajikenek',
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
          gajisupir_id: id
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

          let gajiSupir = $(this).jqGrid("getCol", "gajisupir")
          let totalGajiSupir = 0
          let gajiKenek= $(this).jqGrid("getCol", "gajikenek")
          let totalGajiKenek = 0

          if (gajiSupir.length > 0) {
            totalGajiSupir = gajiSupir.reduce((previousValue, currentValue) => previousValue + currencyUnformat(currentValue), 0)
          }
          if (gajiKenek.length > 0) {
            totalGajiKenek = gajiKenek.reduce((previousValue, currentValue) => previousValue + currencyUnformat(currentValue), 0)
          }

          $(this).jqGrid('footerData', 'set', {
            nobukti: 'Total:',
            gajisupir: totalGajiSupir,
            gajikenek: totalGajiKenek,
          }, true)
        }
      })

      .customPager()
  }

  function loadDetailData(id) {
    $('#detail').setGridParam({
      url: `${apiUrl}gajisupirdetail`,
      datatype: "json",
      postData: {
        gajisupir_id: id
      }
    }).trigger('reloadGrid')
  }
</script>
@endpush()