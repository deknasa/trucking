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
  let detailIndexUrl = "{{ route('acl.detail') }}"

  function loadDetailGrid() {
    let pager = '#detailPager'

    $("#detail").jqGrid({
        url: `{{ config('app.api_url') . 'useracl/detail' }}`,
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
        rowList: [10, 20, 50],
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
        loadBeforeSend: (jqXHR) => {
          jqXHR.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
        },
        loadComplete: function(data) {}
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
      url: `{{ config('app.api_url') . 'useracl/detail' }}?user_id=${id}`,
      postData: {
        id: id
      }
    }).trigger('reloadGrid')
  }
</script>
@endpush()