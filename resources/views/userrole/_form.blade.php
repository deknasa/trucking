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
                  <label>USER</label>
                </div>
                <div class="col-12 col-md-5">
                  <div class="input-group mb-0 pb-0">

                    <input type="text" name="user" id="user" class="form-control" value="{{ $userrole['user'] ?? '' }}" placeholder="User">
                    <div class="input-group-append">
                      <button class="btn btn-outline-secondary" type="button" onclick="lookupUser('user')" tabindex="-1">...</button>
                    </div>

                  </div>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-12 col-md-1"></div>
                <div class="col-12 col-md-5">
                  <input type="hidden" value="{{ $userrole['user_id'] ?? '' }}" name="user_id" id="user_id" />
                </div>
              </div>

              <div style="height: 300px; overflow-x: auto;">
                <table class="table table-sm table-bordered table-hover">
                  <thead class="thead-light">
                    <tr id="header_cart">
                      <th width="75%">Role</th>
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
                            <input type="hidden" name="role_id[]" id="role_id<?= $detailIndex  ?>" readonly class="form-control role_id" tabindex="-1" value="{{ $detail['role_id'] ?? ''}}">
                          </div>

                          <input type="text" name="rolename[]" id="rolename<?= $detailIndex  ?>" readonly class="form-control rolename" tabindex="-1" value="{{ $detail['rolename'] ?? ''}}">
                        </div>
                      </td>

                      <td>
                        <div class="input-group input-group mb-1">
                          <select class="form-control select2" name="status[]">
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
            <a href="{{ route('userrole.index') }}" class="btn btn-danger">
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
  let indexUrl = "{{ route('userrole.index') }}"
  let action = "{{ $action }}"
  let actionUrl = "{{ route('userrole.store') }}"
  let method = "POST"
  let csrfToken = "{{ csrf_token() }}"
  let fieldLengthUrl = "{{ route('userrole.field_length') }}"

  var currentpage = 0;
  var id;

  /* Set action url */
  <?php

  use Illuminate\Support\Facades\URL;

  if ($action !== 'add') : ?>
    actionUrl += `/{{ $userrole['id'] }}`
  <?php endif; ?>

  <?php if ($action == 'edit') : ?>
    method = "PATCH"
  <?php elseif ($action == 'delete') : ?>
    method = "DELETE"
  <?php endif; ?>

  if (action == 'delete') {
    $('[name]').addClass('disabled')
  }

  function lookupUser(user) {
    var user = $('#user').val();

    if (typeof user === 'undefined') user = '';

    if (user) {
      var url = "<?= URL::to('/') ?>/user?popup=1&currentpage=" + currentpage + "&user=" + user;
    } else {
      var url = "<?= URL::to('/') ?>/user?popup=1&currentpage=" + currentpage;
    }

    var winpeserta = window.open(url, "getUser_id");

    var timer = setInterval(function() {
      if (winpeserta.closed) {
        clearInterval(timer);
        var getUser_id = localStorage.getItem('getUser_id');
        console.log(getUser_id);
        if (getUser_id) {
          getUser_id = JSON.parse(getUser_id);
          localStorage.removeItem('getUser_id');
          var kode = removeTags(getUser_id.id);
          var user = removeTags(getUser_id.user);
          $("#user").val(user);
          $('#user_id').val(kode);
        }
      }
    }, 500);
  }

  $.ajax({
    url: `{{ config('app.api_url') . 'userrole/field_length' }}`,
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

  $('#user').on('input', function(e) {
    getiduser(e)
  })

  function getiduser(e) {
    var keyCode = e.keyCode || e.which;

    if (user_id != '') {
      $('#user_id').val('');
      $.ajax({
        url: "<?= URL::to('/') . '/user/getuserid?user=' ?>" + $('#user').val(),
        method: 'GET',
        dataType: 'JSON',
      }).done(function(data) {
        if (data != null) {
          $('#user_id').val(data.id);
        } else {
          $('#user_id').val('');
        }

      });
    }

  }

  function add_row(id) {
    var baris = parseInt($('#baris').text()) + 1;
    $('#baris').text(baris);

    id += 1;
    $('#plus').attr('onclick', 'add_row(' + id + ')');

    $('#table_body').append(`
    		<tr id=` + id + `>
        <td>
          <div>
            <div class="input-group">
              <input type="text" name="role_id[]" id="role_id` + id + `"  readonly class="form-control flevel" tabindex="-1">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button" id="btnBuka` + id + `"  onclick="lookupRole('role_id',` + id + `)" tabindex="-1">...</button>
              </span>
            </div>
          </div>
        </td>     
        <td>
          <div>
            <div class="input-group">
              <input type="text" name="rolename[]"  id="rolename` + id + `" readonly class="form-control rolename" tabindex="-1" autocomplete="off">
            </div>
          </div>
        </td> 
        <td class="action" style="width:80px;">
        <span class="delete_btn">
        <a href="javascript:;" onclick="del_row(` + id + `)" class="tblItem_del"><span class="fas fa-trash"></span></a>
        </span>

        </tr>
    `);

    field_data();
  }

  function del_row(id) {
    $('#' + id).remove();
    var baris = parseInt($('#baris').text()) - 1;
    $('#baris').text(baris);
  }

  function lookupRole(role_id, id) {
    var role = $('#role_id').val();

    if (id == 'default') {
      id = '';
    }

    if (typeof role === 'undefined') role = '';

    var url = "<?= URL::to('/') ?>/role?popup=1&currentpage=" + currentpage + "&id=" + role;

    var winpeserta = window.open(
      url,
      "getRole_id");

    var timer = setInterval(function() {
      if (winpeserta.closed) {
        clearInterval(timer);
        var getRole_id = localStorage.getItem('getRole_id');
        // console.log(getRole_id);
        if (getRole_id) {
          getRole_id = JSON.parse(getRole_id);
          localStorage.removeItem('getRole_id');
          var kode = removeTags(getRole_id.id);
          var role = removeTags(getRole_id.rolename);
          // console.log($('#role_id'id));

          $('#' + role_id + id).val(kode);
          $('#rolename' + id).val(role);
        }
      }
    }, 500);
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

          window.location.href = `${indexUrl}?page=${response.data.page ?? 1}&id=${response.data.id ?? 1}&sortname={{ $sortname ?? '' }}&sortorder={{ $sortorder }}&limit={{ $limit }}`
        },
        error: error => {
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            setErrorMessages(error.responseJSON.errors);
          } else {
            showDialog(error.statusText)
          }
        }
      }).always(() => {
        $('#loader').addClass('d-none')
        $(this).removeAttr('disabled')
      })
    })
  })
</script>
@endpush()