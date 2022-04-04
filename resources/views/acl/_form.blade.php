<?php
$id = 1;
$limit = $_GET['limit'] ?? 10;
$sortname = $_GET['sortname'] ?? 'id';
$sortorder = $_GET['sortorder'] ?? 'asc';
$page = $_GET['page'] ?? '';
$indexRow = $_GET['indexRow'] ?? '';
?>

<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card card-primary">
        <div class="card-header">Form {{ $title }}</div>
        <form action="" method="post">
          <div class="card-body">
            <div>
              @csrf
              <input type="hidden" name="limit" value="{{ $limit }}">
              <input type="hidden" name="sortname" value="{{ $sortname }}">
              <input type="hidden" name="sortorder" value="{{ $sortorder }}">
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
                      <button class="btn btn-outline-secondary" type="button" onclick="lookupRole('rolename')" tabindex="-1">...</button>
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
                          <select class="form-control select2bs4 bg-parimary" name="status[]" id="status">
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

@push('scripts')
<script>
  let indexUrl = "{{ route('acl.index') }}"
  let action = "{{ $action }}"
  let actionUrl = "{{ config('app.api_url') . 'acl' }}"
  let method = "POST"
  let csrfToken = "{{ csrf_token() }}"
  let fieldLengthUrl = "{{ route('acl.field_length') }}"


  <?php

  use Illuminate\Support\Facades\URL;

  if ($action !== 'add') : ?>
    actionUrl += `/{{ $acl['id'] }}`
  <?php endif; ?>

  <?php if ($action == 'edit') : ?>
    method = "PATCH"
  <?php elseif ($action == 'delete') : ?>
    method = "DELETE"
  <?php endif; ?>

  /*Modal JQgrid action */
  let indexUrlrole = "{{ route('role.index') }}"
  let indexRow = 0;
  let page = 0;
  let pager = '#jqGridPager'
  let popup = "";
  let id = "";
  let rowid = "";
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
  $(document).on('shown.bs.modal', '#myModal', function() {
    var rolename = $('#rolename').val();
    var modal = $(this);
    $('#gs_rolename').val(rolename)
    if (typeof rolename === 'undefined') rolename = '';
    var grid = $("#jqGrid");
    var postdata = grid.jqGrid('getGridParam', 'postData');
    jQuery.extend(postdata, {
      _search: true,
      filters: JSON.stringify({
        "groupOp": "AND",
        "rules": [{
          "field": "rolename",
          "op": "cn",
          "data": rolename
        }]
      }),
      stringResult: true,
      searchOnEnter: false,
      defaultSearch: 'cn',
      groupOp: 'AND',
      beforeSearch: function() {
        clearGlobalSearch()
      }
    });
    grid.jqGrid('setGridParam', {
      postData: postdata
    });
    grid.trigger("reloadGrid");
  });

  /*batas*/


  if (action == 'delete') {
    $('[name]').addClass('disabled')
  }

  function lookupRole(rolename) {

    var rolename = $('#rolename').val();
    if (typeof rolename === 'undefined') rolename = '';


    if (rolename) {
      var url = "<?= URL::to('/') ?>/role?popup=1&currentpage=" + currentpage + "&rolename=" + rolename;
    } else {
      var url = "<?= URL::to('/') ?>/role?popup=1&currentpage=" + currentpage;
    }

    var winpeserta = window.open(
      url,
      "getRole_id");
    var timer = setInterval(function() {
      if (winpeserta.closed) {
        clearInterval(timer);
        var getRole_id = localStorage.getItem('getRole_id');
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

  $.ajax({
    url: `{{ config('app.api_url') . 'acl/field_length' }}`,
    method: 'GET',
    dataType: 'JSON',
    headers: {
      'Authorization': `Bearer {{ session('access_token') }}`
    },
    success: response => {
      $.each(response, (index, value) => {
        if (value !== null && value !== 0 && value !== undefined) {
          $(`[name=${index}]`).attr('maxlength', value)
        }
      })
    },
    error: error => {
      showDialog(error.statusText)
    }
  })

  $('#rolename').on('input', function(e) {
    getidrolename(e)
  })

  function getidrolename(e) {
    var keyCode = e.keyCode || e.which;


    if (role_id != '') {
      $('#role_id').val('');
      $.ajax({
        url: "<?= URL::to('/') . '/role/getroleid?rolename=' ?>" + $('#rolename').val(),
        method: 'GET',
        dataType: 'JSON',
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
      $('#loader').removeClass('d-none')

      $.ajax({
        url: actionUrl,
        method: method,
        dataType: 'JSON',
        headers: {
          'Authorization': `Bearer {{ session('access_token') }}`
        },
        data: $('form').serializeArray(),
        success: response => {
          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()

          window.location.href = `${indexUrl}`
        },
        error: error => {
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            setErrorMessages(error.responseJSON.errors);
          } else {
            showDialog(error.statusText)
          }
        },
      }).always(() => {
        $('#loader').addClass('d-none')
        $(this).removeAttr('disabled')
      })
    })

    $('#pilih').submit(event => {
      event.preventDefault()
      $('#myModal').modal('hide')

      var getRole_id = localStorage.getItem('getRole_id');
      if (getRole_id) {
        getRole_id = JSON.parse(getRole_id);
        localStorage.removeItem('getRole_id');
        var kode = removeTags(getRole_id.id);
        var rolename = removeTags(getRole_id.rolename);
        $("#rolename").val(rolename);
        $('#role_id').val(kode);
      }
    })
  })
</script>
@endpush()