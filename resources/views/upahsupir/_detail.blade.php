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
        url: `${apiUrl}upahsupirrincian`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "local",
        colModel: [
          {
            label: 'CONTAINER',
            name: 'container_id',
          },
          {
            label: 'STATUS CONTAINER',
            name: 'statuscontainer_id',
          },
          {
            label: 'NOMINAL SUPIR',
            name: 'nominalsupir',
            align: 'right',
            formatter: currencyFormat
          },
          {
            label: 'NOMINAL KENEK',
            name: 'nominalkenek',
            align: 'right',
            formatter: currencyFormat
          },
          {
            label: 'NOMINAL KOMISI',
            name: 'nominalkomisi',
            align: 'right',
            formatter: currencyFormat
          },
          {
            label: 'NOMINAL TOL',
            name: 'nominaltol',
            align: 'right',
            formatter: currencyFormat
          },
          {
            label: 'LITER',
            name: 'liter',
            align: 'right',
            formatter: currencyFormat
          }
        ],
        autowidth: true,
        shrinkToFit: false,
        height: 250,
        rowNum: 0,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [10, 20, 50, 0],
        footerrow: true,
        userDataOnFooter: true,
        toolbar: [true, "top"],
        sortable: true,
        viewrecords: true,
        postData: {
          upahsupir_id: id
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
        loadBeforeSend: function(jqXHR) {
          jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)

          setGridLastRequest($(this), jqXHR)
        },
        onSelectRow: function(id) {
          activeGrid = $(this)
        },
        loadComplete: function(data) {
          changeJqGridRowListText()
          initResize($(this))
          
          
          
          
          let nominalsupirs = $(this).jqGrid("getCol", "nominalsupir")
          let nominalkeneks = $(this).jqGrid("getCol", "nominalkenek")
          let nominalkomisis = $(this).jqGrid("getCol", "nominalkomisi")
          let nominaltols = $(this).jqGrid("getCol", "nominaltol")
          let totalNominalsupir = 0
          let totalNominalkenek = 0
          let totalNominalkomisi = 0
          let totalNominaltol = 0

          if (nominalsupirs.length > 0) {
            totalNominalsupir = nominalsupirs.reduce((previousValue, currentValue) => previousValue + currencyUnformat(currentValue), 0)
          }
          if (nominalkeneks.length > 0) {
            totalNominalkenek = nominalkeneks.reduce((previousValue, currentValue) => previousValue + currencyUnformat(currentValue), 0)
          }
          if (nominalkomisis.length > 0) {
            totalNominalkomisi = nominalkomisis.reduce((previousValue, currentValue) => previousValue + currencyUnformat(currentValue), 0)
          }
          if (nominaltols.length > 0) {
            totalNominaltol = nominaltols.reduce((previousValue, currentValue) => previousValue + currencyUnformat(currentValue), 0)
          }

          $(this).jqGrid('footerData', 'set', {
            container_id: 'Total:',
            nominalsupir: totalNominalsupir,
            nominalkenek: totalNominalkenek,
            nominalkomisi: totalNominalkomisi,
            nominaltol: totalNominaltol,
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
        abortGridLastRequest($('#detail'))

        $('#detail').setGridParam({
      url: `${apiUrl}upahsupirrincian`,
      datatype: "json",
      postData: {
        upahsupir_id: id
      }
    }).trigger('reloadGrid')
  }
</script>
@endpush()