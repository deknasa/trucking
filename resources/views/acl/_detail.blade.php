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
  function loadDetailGrid(roleId) {
    console.log(roleId)
    $("#detail").jqGrid({
        url: `${apiUrl}acl/detail/${roleId}`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        colModel: [{
            label: 'NAMA ROLE',
            name: 'rolename',
            align: 'left',
            hidden: true
          },
          {
            label: 'Hak',
            name: 'nama',
            align: 'left',
            width: '350px'
          },
          {
            label: 'Nama Controller',
            name: 'class',
            align: 'left',
            width: '350px'
          },
          {
            label: 'MODIFIEDBY',
            name: 'modifiedby',
            align: 'center'
          },
          {
            label: 'UPDATEDAT',
            name: 'updated_at',
            align: 'center'
          },
        ],
        autowidth: true,
        shrinkToFit: false,
        height: 350,
        rowNum: 10,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [10, 20, 50, 0],
        toolbar: [true, "top"],
        sortable: true,
        pager: pager,
        viewrecords: true,
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
        }
      })

      .customPager()
  }

  function loadDetailData(role_id) {
    $('#detail').setGridParam({
      url: `${apiUrl}acl/detail/${roleId}`,
      page:1
    }).trigger('reloadGrid')
  }
</script>
@endpush()