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

    $("#detail").jqGrid({
        url: `${apiUrl}penerimaangirodetail`,
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
            label: 'KETERANGAN',
            name: 'keterangan',
          },
          {
            label: 'NOMINAL',
            name: 'nominal',
            align: 'right',
            formatter: currencyFormat
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
            label: 'BANK',
            name: 'bank_id',
          },
          {
            label: 'PELANGGAN',
            name: 'pelanggan_id',
          },
          {
            label: 'INVOICE NO BUKTI',
            name: 'invoice_nobukti',
          },
          {
            label: 'BANK PELANGGAN',
            name: 'bankpelanggan_id',
          },
          {
            label: 'JENIS BIAYA',
            name: 'jenisbiaya',
          },
          {
            label: 'PELUNASAN PIUTANG NO BUKTI',
            name: 'pelunasanpiutang_nobukti',
          },
          {
            label: 'BULAN BEBAN',
            name: 'bulanbeban',
          }
        ],
        autowidth: true,
        shrinkToFit: false,
        height: 350,
        rowNum: 0,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [10, 20, 50],
        footerrow: true,
        userDataOnFooter: true,
        toolbar: [true, "top"],
        sortable: true,
        viewrecords: true,
        postData: {
          penerimaangiro_id: id
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

          let nominals = $(this).jqGrid("getCol", "nominal")
          let totalNominal = 0

          if (nominals.length > 0) {
            totalNominal = nominals.reduce((previousValue, currentValue) => previousValue + currencyUnformat(currentValue), 0)
          }

          $(this).jqGrid('footerData', 'set', {
            nobukti: 'Total:',
            nominal: totalNominal,
          }, true)
        }
      })

      .jqGrid("navGrid", pager, {
        search: false,
        refresh: false,
        add: false,
        edit: false,
        del: false,
      })

      .customPager()
  }

  function loadDetailData(id) {
    $('#detail').setGridParam({
      url: `${apiUrl}penerimaangirodetail`,
      datatype: "json",
      postData: {
        penerimaangiro_id: id
      }
    }).trigger('reloadGrid')
  }
</script>
@endpush()