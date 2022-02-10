<?php $id = 1; ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card card-primary">
        <div class="card-header">Form {{ $title }}</div>
        <form action="" method="post">
          <div class="card-body">
            <div style="margin-left:15px;margin-right:15px;">
              @csrf
              <input type="hidden" name="limit" value="{{ $_GET['limit'] ?? 10 }}">
              <input type="hidden" name="sortname" value="{{ $_GET['sortname'] ?? 'id' }}">
              <input type="hidden" name="sortorder" value="{{ $_GET['sortorder'] ?? 'asc' }}">
              <input type="hidden" name="indexRow" value="{{ $_GET['indexRow'] ?? 1 }}">
              <input type="hidden" name="page" value="{{ $_GET['page'] ?? 1 }}">


              <div class="row form-group py-0 my-0">
                <div class="col-12 col-md-1 col-form-label">
                  <label>ROLE</label>
                </div>
                <div class="col-12 col-md-5">
                  <div class="input-group mb-0 pb-0">

                    <input type="text" name="rolename" id="rolename" class="form-control" value="{{ $acl['rolename'] ?? '' }}" placeholder="Role Name">
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary" type="button" tabindex="-1" data-toggle="modal" data-target="#myModal" data-whatever="{{ $acl['rolename'] ?? 'tes' }}">...</button>
                      <!-- <button class="btn btn-outline-secondary" type="button" onclick="lookupRole('rolename')" tabindex="-1">...</button> -->

                    </div>

                  </div>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-12 col-md-1"></div>
                <div class="col-12 col-md-5">
                  <input type="hidden" value="{{ $acl['role_id'] ?? '' }}" name="role_id" id="role_id" />
                </div>
              </div>

              <div style="height: 300px; overflow-x: auto;">
                <table class="table table-sm table-bordered table-hover">
                  <thead class="thead-light">
                    <tr id="header_cart">
                      <th width="50%">Hak</th>
                      <th>Nama Controller</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody id="table_body" style="overflow-y: auto;">
                    @if ($list['detail'])
                    @foreach($list['detail'] as $detailIndex => $detail)
                    <tr id="<?= $detailIndex ?>">
                      <td>

                        <div class="input-group input-group mb-1">
                          <div class="input-group-prepend">

                            <!-- <span class="input-group-text" name="role_id[]" id="role_id<?= $detailIndex  ?>"> {{ $detail['role_id'] ?? ''}} </span> -->
                            <!-- <input type="hidden" value="" name="role_id[]"" id=" role_id<?= $detailIndex  ?>" /> -->
                            <input type="hidden" name="aco_id[]" id="aco_id<?= $detailIndex  ?>" readonly class="form-control aco_id" tabindex="-1" value="{{ $detail['aco_id'] ?? ''}}">

                          </div>

                          <input type="text" name="nama[]" id="nama<?= $detailIndex  ?>" readonly class="form-control nama" tabindex="-1" value="{{ $detail['nama'] ?? ''}}">
                        </div>
                      </td>
                      <td>

                        <input type="text" name="class[]" id="class<?= $detailIndex  ?>" readonly class="form-control class" tabindex="-1" value="{{ $detail['class'] ?? ''}}">
                      </td>


                      <td>
                        <div class="input-group input-group mb-1">
                          <select class="form-control select2" name="status[]" id="status">
                            <?php foreach ($data['combo'] as $key => $item) { ?>
                              <option value="<?= $item['id'] ?>" <?= $item['id'] == @$detail['status'] ? 'selected' : '' ?>><?= $item['keterangan'] ?></option>
                            <?php } ?>
                        </div>
                      </td>

                    </tr>
                    @endforeach
                    @endif
                  </tbody>

                </table>
              </div>
            </div>
          </div>

          <div class="card-footer">
            <button type="submit" id="btnSimpan" class="btn btn-primary">
              <i class="fa fa-save"></i>
              @if(isset($action) && $action == 'delete')
              Delete
              @else
              Simpan
              @endif
            </button>
            <a href="{{ route('acl.index') }}" class="btn btn-danger">
              <i class="fa fa-window-close"></i>
              BATAL
            </a>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<!-- The Modal -->
<div class="modal" id="myModal">
  <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
    <div class="modal-dialog modal-lg">

      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Role</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <div class="modal-body">
          <table class="table table-striped">

            <div class="container-fluid">
              <div class="row">
                <div class="col-10">
                  <table id="jqGrid"></table>
                  <div id="jqGridPager"></div>
                </div>

                <div class="row">
                  <!-- Modal footer -->
                  <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                  </div>
                </div>
              </div>
            </div>
          </table>
        </div>



      </div>
    </div>
  </div>
</div>
</div>



@push('scripts')
<script>
  let indexUrl = "{{ route('acl.index') }}"
  let action = "{{ $action }}"
  let actionUrl = "{{ route('acl.store') }}"
  let method = "POST"
  let csrfToken = "{{ csrf_token() }}"
  let fieldLengthUrl = "{{ route('acl.field_length') }}"


  <?php

  use Illuminate\Support\Facades\URL;

  if ($action == 'edit') : ?>
    actionUrl = "{{ route('acl.update', $acl['id']) }}"
    method = "PATCH"
  <?php elseif ($action == 'delete') : ?>
    actionUrl = "{{ route('acl.destroy', $acl['id']) }}"
    method = "DELETE"
  <?php endif; ?>

  /*Modal JQgrid action */
  let indexUrlrole = "{{ route('role.index') }}"
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
  popup = "<?= @$_GET['popup'] ?>" == "" ? "" : "ada";
  id = "<?= @$_GET['name'] ?>" == "" ? "undefined" : "<?= @$_GET['name'] ?>";
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

  var currentpage = 0;

  /* Set action url */


  $('#myModal').on('show.bs.modal', function(event) {
    var button = $(event.relatedTarget)
    var rolename = $('#rolename').val();
    var modal = $(this)
    // modal.find('.modal-body input').val(rolename)

     
    console.log(rolename);


  })

  $("#jqGrid").jqGrid({
      url: indexUrlrole,
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
          label: 'ROLE',
          name: 'rolename',
          align: 'left',
          searchoptions: {
            sopt: ['cn'],
            defaultValue: $("#rolename").val()
          }
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
        }, {
          label: 'CREATEDAT',
          name: 'created_at',
          align: 'right'
        },
      ],
      // autowidth: true,
      shrinkToFit: true,
      width: '100%',
      modal: true,
      height: '75%',
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
        id = $(this).jqGrid('getCell', id, 'rn') - 1
        indexRow = id
        page = $(this).jqGrid('getGridParam', 'page')
        let rows = $(this).jqGrid('getGridParam', 'postData').rows
        if (indexRow >= rows) indexRow = (indexRow - rows * (page - 1))
      },
      ondblClickRow: function(rowid) {
        if (popup == "ada") {
          var rowData = jQuery(this).getRowData(rowid);
          localStorage.setItem('getRole_id', JSON.stringify(rowData));
          window.close();
        }
      },

      beforeRequest: function() {
        var $requestGrid = $(this);
        if ($requestGrid.data('areFiltersDefaulted') !== true) {
          $requestGrid.data('areFiltersDefaulted', true);
          setTimeout(function() {
            $requestGrid[0].triggerToolbar();
          }, 50);
          return false;
        }
        // Subsequent runs are always allowed
        return true;
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

        window.location.href = `{{ route('role.create') }}?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}`
      }
    })

    .navButtonAdd(pager, {
      caption: 'Edit',
      title: 'Edit',
      id: 'edit',
      buttonicon: 'fas fa-pen',
      onClickButton: function() {
        selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

        window.location.href = `${indexUrl}/${selectedId}/edit?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}`
      }
    })

    .navButtonAdd(pager, {
      caption: 'Delete',
      title: 'Delete',
      id: 'delete',
      buttonicon: 'fas fa-trash',
      onClickButton: function() {
        selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

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

  /*batas*/


  if (action == 'delete') {
    $('[name]').addClass('disabled')
  }



  function lookupRole(rolename) {

    var rolename = $('#rolename').val();
    console.log(rolename);
    if (typeof rolename === 'undefined') rolename = '';


    if (rolename) {
      var url = "<?= URL::to('/') ?>/role?popup=1&currentpage=" + currentpage + "&rolename=" + rolename;
    } else {
      var url = "<?= URL::to('/') ?>/role?popup=1&currentpage=" + currentpage;
    }

    // console.log(url);
    var winpeserta = window.open(
      url,
      "getRole_id");
    var timer = setInterval(function() {
      if (winpeserta.closed) {
        clearInterval(timer);
        var getRole_id = localStorage.getItem('getRole_id');
        console.log(getRole_id);
        if (getRole_id) {
          getRole_id = JSON.parse(getRole_id);
          localStorage.removeItem('getRole_id');
          var kode = removeTags(getRole_id.id);
          var rolename = removeTags(getRole_id.rolename);
          $("#rolename").val(rolename);
          $('#role_id').val(kode);
          // setDetail(kode);
        }
      }
    }, 500);

  }

  function field_data() {
    $.ajax({
      url: fieldLengthUrl,
      method: 'GET',
      dataType: 'JSON',
      success: response => {
        $.each(response, (index, value) => {
          if (value !== null && value !== 0 && value !== undefined) {
            $(`[name=${index}]`).attr('maxlength', value)
          }
        })
      },
      error: error => {
        alert(error)
      }
    });
  }

  $('#rolename').on('input', function(e) {
    getidrolename(e)
  })

  function getidrolename(e) {
    var keyCode = e.keyCode || e.which;


    // var role_id = $('#'+user).val();

    if (role_id != '') {
      $('#role_id').val('');
      $.ajax({
        url: "<?= URL::to('/') . '/role/getroleid?rolename=' ?>" + $('#rolename').val(),
        method: 'GET',
        dataType: 'JSON',
        // async: false,
      }).done(function(data) {
        if (data != null) {
          $('#role_id').val(data.id);
        } else {
          $('#role_id').val('');
        }

      });
    }

  }







  $(document).ready(function() {
    $('form').submit(function(e) {
      e.preventDefault()
    })

    /* Handle on click btnSimpan */
    $('#btnSimpan').click(function() {
      $(this).attr('disabled', '')

      $.ajax({
        url: actionUrl,
        method: method,
        dataType: 'JSON',
        data: $('form').serializeArray(),
        success: response => {
          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()

          if (response.status) {
            // alert(response.message)

            if (action != 'delete') {
              window.location.href = `${indexUrl}?page=${response.data.page ?? 1}&id=${response.data.id ?? 1}&sortname={{ $_GET['sortname'] ?? '' }}&sortorder={{ $_GET['sortorder'] }}&limit={{ $_GET['limit'] }}`
            } else {
              window.location.href = `${indexUrl}?page={{ $_GET['page'] ?? '' }}&sortname={{ $_GET['sortname'] ?? '' }}&sortorder={{ $_GET['sortorder'] }}&limit={{ $_GET['limit'] ?? ''}}&indexRow={{ $_GET['indexRow'] ?? '' }}`
            }
          }

          if (response.errors) {
            setErrorMessages(response.errors)
          }
        },
        error: error => {
          alert(`${error.statusText} | ${error.responseText}`)
        }
      }).always(() => {
        $(this).removeAttr('disabled')
      })
    })




  })
</script>
@endpush()