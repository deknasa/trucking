@extends('layouts.master')

@section('content')
<div class="content-header">
  <div class="container-fluid">
    <div class="row mb-2">
      <div class="col-sm-6">
        <h1 class="m-0">{{ $title }}</h1>
      </div>
      <div class="col-sm-6">
        <ol class="breadcrumb float-sm-right">
          <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
          <li class="breadcrumb-item active">{{ $title }}</li>
        </ol>
      </div>
    </div>
  </div>
</div>

<!-- Grid -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <table id="jqGrid"></table>
      <div id="jqGridPager"></div>
    </div>
  </div>
</div>

<!-- Detail -->
<!-- @include('userrole._detail') -->


@push('scripts')
<script>
  $(document).ready(function() {
    let indexUrl = "{{ route('userrole.index') }}"
    let indexRow = 0;
    let page = 0;
    let pager = '#jqGridPager'
    let popup = "";
    let id = "";
    let triggerClick = true;
    let highlightSearch;
    let totalRecord
    let limit
    let postData
    let sortname = 'user_id'
    let sortorder = 'asc'

    /* Set page */
    <?php if (isset($_GET['page'])) { ?>
      page = "{{ $_GET['page'] }}"
    <?php } ?>

    /* Set id */
    <?php if (isset($_GET['id'])) { ?>
      id = "{{ $_GET['id'] }}"
    <?php } ?>

    /* Set indexRow */
    <?php if (isset($_GET['indexRow'])) { ?>
      indexRow = "{{ $_GET['indexRow'] }}"
    <?php } ?>

    /* Set sortname */
    <?php if (isset($_GET['sortname'])) { ?>
      sortname = "{{ $_GET['sortname'] }}"
    <?php } ?>

    /* Set sortorder */
    <?php if (isset($_GET['sortorder'])) { ?>
      sortorder = "{{ $_GET['sortorder'] }}"
    <?php } ?>



    $("#jqGrid").jqGrid({
        url: indexUrl,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        colModel: [{
            label: 'USER ID',
            name: 'user_id',
            align: 'left',
            hidden: true
          },
          {
            label: 'USER',
            name: 'user',
            align: 'left'
          }, {
            label: 'NAMA USER',
            name: 'name',
            align: 'left'
          },
          {
            label: 'MODIFIEDBY',
            name: 'modifiedby',
            align: 'left'
          },
          {
            label: 'UPDATEDAT',
            name: 'updated_at',
            align: 'right'
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
        sortname: sortname,
        sortorder: sortorder,
        page: page,
        pager: pager,
        viewrecords: true,
        onSelectRow: function(id) {
          console.log(id)
          loadDetailData(id)

          id = $(this).jqGrid('getCell', id, 'rn') - 1
          indexRow = id
          page = $(this).jqGrid('getGridParam', 'page')
          let rows = $(this).jqGrid('getGridParam', 'postData').rows
          if (indexRow >= rows) indexRow = (indexRow - rows * (page - 1))
        },
        gridComplete: function() {
          id = $(this).jqGrid('getCell', id, 'rn')
          console.log(id)
          loadDetailData(id)

        },
        loadComplete: function(data) {

          /* Set global variables */
          sortname = $(this).jqGrid("getGridParam", "sortname")
          sortorder = $(this).jqGrid("getGridParam", "sortorder")
          totalRecord = $(this).getGridParam("records")
          limit = $(this).jqGrid('getGridParam', 'postData').rows
          postData = $(this).jqGrid('getGridParam', 'postData')


          $('.clearsearchclass').click(function() {
            highlightSearch = ''
          })

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`[id="${$('#jqGrid').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`[id="${$('#jqGrid').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#jqGrid').getDataIDs()[indexRow] == undefined) {
              $(`[id="` + $('#jqGrid').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#jqGrid').setSelection($('#jqGrid').getDataIDs()[indexRow])
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

      .navButtonAdd(pager, {
        caption: 'Add',
        title: 'Add',
        id: 'add',
        buttonicon: 'fas fa-plus',
        onClickButton: function() {
          let limit = $(this).jqGrid('getGridParam', 'postData').rows

          window.location.href = `{{ route('userrole.create') }}?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}`
        }
      })

      .navButtonAdd(pager, {
        caption: 'Edit',
        title: 'Edit',
        id: 'edit',
        buttonicon: 'fas fa-pen',
        onClickButton: function() {
          row_id = $("#jqGrid").jqGrid('getGridParam', 'selrow')
          selectedId = $(this).jqGrid('getCell', row_id, 'user_id');
          // alert(selectid);

          window.location.href = `${indexUrl}/${selectedId}/edit?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}`
        }
      })

      .navButtonAdd(pager, {
        caption: 'Delete',
        title: 'Delete',
        id: 'delete',
        buttonicon: 'fas fa-trash',
        onClickButton: function() {
          // selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
          row_id = $("#jqGrid").jqGrid('getGridParam', 'selrow')
          selectedId = $(this).jqGrid('getCell', row_id, 'user_id');

          window.location.href = `${indexUrl}/${selectedId}/delete?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}&page=${page}&indexRow=${indexRow}`
        }
      })

      .jqGrid('filterToolbar', {
        stringResult: true,
        searchOnEnter: false,
        defaultSearch: 'cn',
        groupOp: 'AND',
        beforeSearch: function() {
          clearGlobalSearch()
        }
      })

      .bindKeys() /

      /* Append clear filter button */
      loadClearFilter()

    /* Append global search */
    loadGlobalSearch()

    /* Load detial grid */
    loadDetailGrid()
  })

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
@endsection