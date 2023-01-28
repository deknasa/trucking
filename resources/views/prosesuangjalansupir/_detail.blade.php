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
        url: `${apiUrl}prosesuangjalansupirdetail`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "local",
        //datatype: "json",
        colModel: [
          // {
          //   label: 'PENERIMAAN',
          //   name: 'prosesuangjalansupir_id',
          // },
          {
            label: 'NO BUKTI',
            name: 'nobukti',
          }, 
          {
            label: 'NO. BUKTI PENERIMAAN',
            name: 'penerimaantrucking_nobukti',
          },
          {
            label: 'TGL PENERIMAAN',
            name: 'penerimaantrucking_tglbukti',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'BANK PENERIMAAN',
            name: 'penerimaantrucking_bank_id',
          },
          {
            label: 'NO. BUKTI PENGELUARAN',
            name: 'pengeluarantrucking_nobukti',
          },
          {
            label: 'TGL PENGELUARAN',
            name: 'pengeluarantrucking_tglbukti',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'BANK PENGELUARAN',
            name: 'pengeluarantrucking_bank_id',
          },
          {
            label: 'NO. BUKTI PENGEMBALIAN KAS GANTUNG',
            name: 'pengembaliankasgantung_nobukti',
          },
          {
            label: 'TGL PENGEMBALIAN KAS GANTUNG',
            name: 'pengembaliankasgantung_tglbukti',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'BANK PENGEMBALIAN KAS GANTUNG',
            name: 'pengembaliankasgantung_bank_id',
          },
          {
            label: 'PROSES UANG JALAN',
            name: 'statusprosesuangjalan',
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
          prosesuangjalansupir_id: id
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
      url: `${apiUrl}prosesuangjalansupirdetail`,
      datatype: "json",
      postData: {
        prosesuangjalansupir_id: id
      }
    }).trigger('reloadGrid')
  }
</script>
@endpush()