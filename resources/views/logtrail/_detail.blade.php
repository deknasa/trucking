<!-- Grid -->
<div class="container-fluid my-4">
  <div class="row">
    <div class="col-12">
      <table id="logtrailHeader"></table>
      <div id="logtrailHeaderPager"></div>

      <table id="logtrailDetail"></table>
      <div id="logtrailDetailPager"></div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  let logtrailHeaderData
  let logtrailHeaderUrl = `{{ route('logtrail.header') }}`
  let logtrailGeaderColModel = []

  let logtrailDetailData
  let logtrailDetailUrl = `{{ route('logtrail.detail') }}`
  let detailColModel = []

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

  function loadLogtrailHeaderGrid(id) {
    let pager = '#logtrailHeaderPager'

    $("#logtrailHeader").jqGrid({
        url: `{{ config('app.api_url') . 'logtrail/header' }}?id=${id}`,
        colModel: logtrailGeaderColModel,
        caption: "Header Grid",
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        autowidth: true,
        shrinkToFit: false,
        title: 'Header Grid',
        height: 350,
        rowNum: 10,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [10, 20, 50, 0],
        sortable: true,
        // pager: pager,
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
        loadComplete: function(data) {
          changeJqGridRowListText()

        }
      })

      .customPager()
  }

  function loadLogtrailDetailGrid(id) {
    let pager = '#logtrailDetailPager'

    $("#logtrailDetail").jqGrid({
        url: `{{ config('app.api_url') . 'logtrail/detail' }}?id=${id}`,
        colModel: logtrailGeaderColModel,
        caption: "Detail Grid",
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        autowidth: true,
        shrinkToFit: false,
        height: 350,
        rowNum: 10,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [10, 20, 50, 0],
        sortable: true,
        // pager: pager,
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
        loadComplete: function(data) {
          changeJqGridRowListText()

        }
      })

      .customPager()
  }

  function loadLogtrailHeaderData(id) {
    $.ajax({
      url: logtrailHeaderUrl,
      method: 'GET',
      dataType: 'JSON',
      data: {
        id: id,
      },
      success: response => {
        logtrailGeaderColModel = []

        Object.keys(response.rows[0]).map((value, index) => {
          logtrailGeaderColModel.push({
            label: value,
            name: value,
          })
        })

        loadLogtrailHeaderGrid(id)

      },
      error: error => {

      }
    })
  }

  function loadLogtrailDetailData(id) {
    $.ajax({
      url: logtrailDetailUrl,
      method: 'GET',
      dataType: 'JSON',
      data: {
        id: id,
      },
      success: response => {
        logtrailGeaderColModel = []

        if (response.rows[0] !== undefined) {
          Object.keys(response.rows[0]).map((value, index) => {
            logtrailGeaderColModel.push({
              label: value,
              name: value,
            })
          })

          loadLogtrailDetailGrid(id)
        }

      },
      error: error => {

      }
    })
  }
</script>
@endpush()