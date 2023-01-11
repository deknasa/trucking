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
        url: `${apiUrl}absensisupirapprovaldetail`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        colModel: [
          {
            label: 'NO BUKTI',
            name: 'nobukti',
            align: 'left'
          },
          {
            label: 'TRADO',
            name: 'trado'
          },
          {
            label: 'SUPIR',
            name: 'supir',
          },
          {
            label: 'SUPIR SERAP',
            name: 'supirserap',
          },
          {
            label: 'MODIFIEDBY',
            name: 'modifiedby',
            align: 'left'
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
        pager: pager,
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
      url: `${apiUrl}absensisupirapprovaldetail`,
      datatype: "json",
      postData: {
        absensisupirapproval_id: id
      }
    }).trigger('reloadGrid')
  }
</script>
@endpush()