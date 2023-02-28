<table id="historyGrid"></table>

<script>
  function loadGrid(id) {
    $('#historyGrid')
      .jqGrid({
        url: `${apiUrl}hutangdetail/history`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        colModel: [{
            label: 'NO BUKTI',
            name: 'hutang_nobukti',
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
          },
          {
            label: 'NO BUKTI PEMBAYARAN',
            name: 'nobukti_bayar',
          },
          {
            label: 'NOMINAL',
            name: 'nominal',
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
        rowList: [10, 20, 50, 0],
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
          changeJqGridRowListText()
          if (data.attributes) {
            $(this).jqGrid('footerData', 'set', {
                piutang_nobukti: 'Total:',
                nominal: data.attributes.totalNominal,
            }, true)
          }
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
      url: `${apiUrl}hutangdetail/history`,
      datatype: "json",
      postData: {
        hutang_id: id
      }
    }).trigger('reloadGrid')
  }
</script>