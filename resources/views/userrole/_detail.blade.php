<!-- Grid -->
<div class="container-fluid py-4">
  <div class="row">
    <div class="col-12">
      <table id="detail"></table>
    </div>
  </div>
</div>

@push('scripts')
<script>
  let detailIndexUrl = "{{ route('userrole.detail') }}"

  /**
   * Custom Functions
   */
  var delay = (function() {
    var timer = 0;
    return function(callback, ms) {
      clearTimeout(timer);
      timer = setTimeout(callback, ms);
    };
  })()

  function loadDetailGrid() {
    $("#detail").jqGrid({
        url: `{{ config('app.api_url') . 'userrole/detail' }}`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        colModel: [{
            label: 'USER',
            name: 'user',
            align: 'left',
            hidden: true
          },
          {
            label: 'ROLE',
            name: 'rolename',
            align: 'left'
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
        onSelectRow: function(id) {
          activeGrid = $(this)
        },
        loadBeforeSend: (jqXHR) => {
          jqXHR.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
        },
        loadComplete: function(data) {
          initResize($(this))
        }
      })

      .customPager()
  }

  function loadDetailData(id) {
    $('#detail').setGridParam({
      url: `{{ config('app.api_url') . 'userrole/detail' }}?user_id=${id}`,
      postData: {
        id: id
      }
    }).trigger('reloadGrid')
  }
</script>
@endpush()