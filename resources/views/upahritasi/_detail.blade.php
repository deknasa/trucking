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
  let detailIndexUrl = "{{ route('upahritasirincian.index') }}"

  function loadDetailGrid() {
    $("#detail").jqGrid({
        url: `{{ config('app.api_url') . 'upahritasirincian' }}`,
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
        height: 350,
        rowNum: 0,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [10, 20, 50],
        toolbar: [true, "top"],
        sortable: true,
        viewrecords: true,
        onSelectRow: function() {
          activeGrid = $(this)
        },
        loadComplete: function(data) {
          initResize($(this))
        }
      })
  }

  function loadDetailData(id) {
    $('#detail').setGridParam({
      url: detailIndexUrl,
      datatype: 'json',
      postData: {
        upahritasi_id: id
      }
    }).trigger('reloadGrid')
  }

  function clearColumnSearch() {
    $('input[id*="gs_"]').val("");
    $("#resetFilterOptions span#resetFilterOptions").removeClass('aktif');
    $('select[id*="gs_"]').val("");
    $("#resetdatafilter").removeClass("active");
  }

  function clearGlobalSearch() {
    $("#searchText").val("")
  }

  function loadClearFilter() {
    /* Append Button */
    $('#gsh_' + $.jgrid.jqID($('#jqGrid')[0].id) + '_rn').html(
      $("<div id='resetfilter' class='reset'><span id='resetdatafilter' class='btn btn-default'> X </span></div>")
    )

    /* Handle button on click */
    $("#resetdatafilter").click(function() {
      highlightSearch = '';

      clearGlobalSearch()
      clearColumnSearch()

      $("#jqGrid").jqGrid('setGridParam', {
        search: false,
        postData: {
          "filters": ""
        }
      }).trigger("reloadGrid");
    })
  }

  function loadGlobalSearch() {
    /* Append global search textfield */
    $('#t_' + $.jgrid.jqID($('#jqGrid')[0].id)).html($('<form class="form-inline"><div class="form-group" id="titlesearch"><label for="searchText" style="font-weight: normal !important;">Search : </label><input type="text" class="form-control" id="searchText" placeholder="Search" autocomplete="off"></div></form>'));

    /* Handle textfield on input */
    $(document).on("input", "#searchText", function() {
      delay(function() {
        clearColumnSearch()

        var postData = $('#jqGrid').jqGrid("getGridParam", "postData"),
          colModel = $('#jqGrid').jqGrid("getGridParam", "colModel"),
          rules = [],
          searchText = $("#searchText").val(),
          l = colModel.length,
          i,
          cm;
        for (i = 0; i < l; i++) {
          cm = colModel[i];
          if (cm.search !== false && (cm.stype === undefined || cm.stype === "text" || cm.stype === "select")) {
            rules.push({
              field: cm.name,
              op: "cn",
              data: searchText.toUpperCase()
            });
          }
        }
        postData.filters = JSON.stringify({
          groupOp: "OR",
          rules: rules
        });

        $('#jqGrid').jqGrid("setGridParam", {
          search: true
        });
        $('#jqGrid').trigger("reloadGrid", [{
          page: 1,
          current: true
        }]);
        return false;
      }, 500);
    });
  }
</script>
@endpush()