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
      <div id="jqGridPager" class="row bg-white">
        <div id="buttonContainer" class="col-12 col-md-7 text-center text-md-left">
          <button id="add" class="btn btn-primary btn-sm mb-1">
            <i class="fa fa-plus"></i> ADD
          </button>
          <button id="edit" class="btn btn-success btn-sm mb-1">
            <i class="fa fa-pen"></i> EDIT
          </button>
          <button id="delete" class="btn btn-danger btn-sm mb-1">
            <i class="fa fa-trash"></i> DELETE
          </button>
        </div>
        <div id="pagerHandler" class="col-12 col-md-4 d-flex justify-content-center align-items-center"></div>
        <div id="pagerInfo" class="col-12 col-md-1 d-flex justify-content-end align-items-center"></div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  $(document).ready(function() {
    let indexUrl = "{{ route('container.index') }}"
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
    let sortname = 'id'
    let sortorder = 'asc'
    let autoNumericElements = []
    let rowNum = 10

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

    <?php if (isset($_GET['limit'])) { ?>
      rowNum = "{{ $_GET['limit'] }}"
    <?php } ?>

    $("#jqGrid").jqGrid({
        url: `{{ config('app.api_url') . 'container' }}`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        colModel: [{
            label: 'ID',
            name: 'id',
            align: 'right',
            width: '70px'
          },
          {
            label: 'KODE CONTAINER',
            name: 'kodecontainer',
            align: 'left'
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
            align: 'left'
          },
          {
            label: 'Status',
            name: 'statusaktif',
            width: 100,
            stype: 'select',
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['combo'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['combo'])) {
                          echo ";";
                        }
                        $i++;
                      endforeach

                      ?>
            `,
              dataInit: function(element) {
                $(element).select2({
                  width: 'resolve',
                  theme: "bootstrap4"
                });
              }
            },
          },
          {
            label: 'MODIFIEDBY',
            name: 'modifiedby',
            align: 'left'
          },
          {
            label: 'UPDATEDAT',
            name: 'updated_at',
            formatter: "date",
            formatoptions: { srcformat: "ISO8601Long", newformat: "d-m-Y H:i:s" }
          }, {
            label: 'CREATEDAT',
            name: 'created_at',
            formatter: "date",
            formatoptions: { srcformat: "ISO8601Long", newformat: "d-m-Y H:i:s" }
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
        onSelectRow: function(id) {
          id = $(this).jqGrid('getCell', id, 'rn') - 1
          indexRow = id
          page = $(this).jqGrid('getGridParam', 'page')
          let limit = $(this).jqGrid('getGridParam', 'postData').limit
          if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))
        },
        ondblClickRow: function(rowid) {

        },
        loadComplete: function(data) {
          loadPagerHandler('#pagerHandler', $(this))
          loadPagerInfo('#pagerInfo', $(this))

          /* Set global variables */
          sortname = $(this).jqGrid("getGridParam", "sortname")
          sortorder = $(this).jqGrid("getGridParam", "sortorder")
          totalRecord = $(this).getGridParam("records")
          limit = $(this).jqGrid('getGridParam', 'postData').limit
          postData = $(this).jqGrid('getGridParam', 'postData')

          $('.clearsearchclass').click(function() {
            highlightSearch = ''
          })

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#jqGrid [id="${$('#jqGrid').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#jqGrid [id="${$('#jqGrid').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#jqGrid').getDataIDs()[indexRow] == undefined) {
              $(`#jqGrid [id="` + $('#jqGrid').getDataIDs()[0] + `"]`).click()
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

      // .navButtonAdd(pager, {
      //   caption: 'Add',
      //   title: 'Add',
      //   id: 'add',
      //   buttonicon: 'fas fa-plus',
      //   onClickButton: function() {
      //     let limit = $(this).jqGrid('getGridParam', 'postData').limit

      //     window.location.href = `{{ route('container.create') }}?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}`
      //   }
      // })

      // .navButtonAdd(pager, {
      //   caption: 'Edit',
      //   title: 'Edit',
      //   id: 'edit',
      //   buttonicon: 'fas fa-pen',
      //   onClickButton: function() {
      //     selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

      //     window.location.href = `${indexUrl}/${selectedId}/edit?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}`
      //   }
      // })

      // .navButtonAdd(pager, {
      //   caption: 'Delete',
      //   title: 'Delete',
      //   id: 'delete',
      //   buttonicon: 'fas fa-trash',
      //   onClickButton: function() {
      //     selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

      //     window.location.href = `${indexUrl}/${selectedId}/delete?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}&page=${page}&indexRow=${indexRow}`
      //   }
      // })

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


    $('#add .ui-pg-div')
      .addClass(`btn-sm btn-primary`)
      .parent().addClass('px-1')

    $('#edit .ui-pg-div')
      .addClass('btn-sm btn-success')
      .parent().addClass('px-1')

    $('#delete .ui-pg-div')
      .addClass('btn-sm btn-danger')
      .parent().addClass('px-1')


    if (!`{{ $myAuth->hasPermission('container', 'store') }}`) {
      $('#add').addClass('ui-disabled')
    }

    if (!`{{ $myAuth->hasPermission('container', 'update') }}`) {
      $('#edit').addClass('ui-disabled')
    }

    if (!`{{ $myAuth->hasPermission('container', 'destroy') }}`) {
      $('#delete').addClass('ui-disabled')
    }

    /* Handle button add on click */
    $('#add').click(function() {
      let limit = $('#jqGrid').jqGrid('getGridParam', 'postData').limit

      window.location.href = `{{ route('container.create') }}?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}`
    })

    /* Handle button edit on click */
    $('#edit').click(function() {
      selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

      if (selectedId == null || selectedId == '' || selectedId == undefined) {
        alert('please select a row')
      } else {
        window.location.href = `${indexUrl}/${selectedId}/edit?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}`
      }
    })

    /* Handle button delete on click */
    $('#delete').click(function() {
      selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

      window.location.href = `${indexUrl}/${selectedId}/delete?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}&page=${page}&indexRow=${indexRow}`
    })
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