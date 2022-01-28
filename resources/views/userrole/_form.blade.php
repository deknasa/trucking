<?php $role_id = 1; ?>

<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card card-primary">
        <div class="card-header">Form {{ $title }}</div>
        <form action="" method="post">
          <div class="card-body">
            @csrf
            <input type="hidden" name="limit" value="{{ $_GET['limit'] ?? 10 }}">
            <input type="hidden" name="sortname" value="{{ $_GET['sortname'] ?? 'id' }}">
            <input type="hidden" name="sortorder" value="{{ $_GET['sortorder'] ?? 'asc' }}">

            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>USER ID</label>
              </div>
              <div class="col-12 col-md-2">
                <div class="input-group">
                  <input type="text" name="user_id" id="user_id" class="form-control" value="{{ $userrole['user_id'] ?? '' }}" readonly>
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="button" onclick="lookupUser('user_id')" tabindex="-1">...</button>
                  </span>
                </div>
              </div>
            </div>


            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>NAMA USER</label>
              </div>
              <div class="col-12 col-md-5">
                <input type="text" name="name" id="name" class="form-control" value="{{ $userrole['name'] ?? '' }}" readonly>
              </div>
            </div>

            <div style="height: 300px; overflow-x: auto;">
              <table class="table table-bordered">
                <thead class="thead-light">
                  <tr id="header_cart">
                    <th width="25%">ID</th>
                    <th>Role</th>
                  </tr>
                </thead>
                <tbody id="table_body" style="overflow-y: auto;">
                  @if ($list['detail'])
                  @foreach($list['detail'] as $detailIndex => $detail)
                  <tr id="<?= $idx ?>">
                    <td>
                      <input type="hidden" name="role_id[]" id="role_id<?= $idx ?>"  readonly id="role_id" class="form-control flevel" tabindex="-1" value="{{ $detail['role_id'] ?? ''}}">
                      {{ $detail['role_id'] }}
                    </td>
                    <td>
                      <input type="hidden" name="rolename[]"  id="role_name<?= $idx ?>"  value="{{ $detail['rolename'] }} " name="rolename[]" readonly id="rolename" class="form-control rolename">
                      {{ $detail['rolename'] }}
                    </td>

                  </tr>
                  @endforeach
                  @else
                  <td>
                    <div>
                      <div class=" input-group">
                        <input type="text" name="role_id[]" readonly id="role_id" class="form-control flevel" tabindex="-1">
                        <span class="input-group-btn">
                          <button class="btn btn-default" type="button" onclick="lookupRole('role_id',0)" tabindex="-1">...</button>
                        </span>
                      </div>
                    </div>
                  </td>
                  <td>
                    <div>
                      <div class="input-group">
                        <input type="text" name="rolename[]" readonly id="rolename" class="form-control rolename">
                      </div>
                    </div>
                  </td>

                  @endif
                </tbody>
                <tfoot>
                  <tr>
                    <td>Jumlah Baris : <span id="baris"><?= $list['detail'] ? count($list['detail']) : 1 ?></span></td>
                    <td colspan="1"></td>
                    <td>
                      <a id="plus" href="javascript:;" onclick="add_row(<?= $role_id ?>)"><span class="fas fa-plus"></span></a>
                    </td>

                  </tr>
                </tfoot>
              </table>
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

  var currentpage = 0;
  var id;


  /* Set action url */
  <?php

  use Illuminate\Support\Facades\URL;

  if ($action == 'edit') : ?>
    actionUrl = "{{ route('userrole.update', $userrole['id']) }}"
    method = "PATCH"
  <?php elseif ($action == 'delete') : ?>
    actionUrl = "{{ route('userrole.destroy', $userrole['id']) }}"
    method = "DELETE"
  <?php endif; ?>

  function lookupUser(user_id) {

    var user = $('#user_id').val();
    console.log(user);
    if (typeof user === 'undefined') user = '';



    var url = "<?= URL::to('/') ?>/user?popup=1&currentpage=" + currentpage + "&id=" + user;
    // console.log(url);
    var winpeserta = window.open(
      url,
      "getUser_id");
    var timer = setInterval(function() {
      if (winpeserta.closed) {
        clearInterval(timer);
        var getUser_id = localStorage.getItem('getUser_id');
        console.log(getUser_id);
        if (getUser_id) {
          getUser_id = JSON.parse(getUser_id);
          localStorage.removeItem('getUser_id');
          var kode = removeTags(getUser_id.id);
          var user = removeTags(getUser_id.name);
          $("#user_id").val(kode);
          $('#name').val(user);
        }
      }
    }, 500);
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
              <input type="text" name="role_id[]" id="role_id`+id+`" readonly class="form-control flevel" tabindex="-1">
              <span class="input-group-btn">
                <button class="btn btn-default" type="button" onclick="lookupRole('role_id',id)" tabindex="-1">...</button>
              </span>
            </div>
          </div>
        </td>     
        <td>
          <div>
            <div class="input-group">
              <input type="text" name="rolename[]" id="role_name`+id+`" readonly class="form-control rolename">
            </div>
          </div>

        </td> 

              

        <td class="action" style="width:80px;">
        <span class="delete_btn">
        <a href="javascript:;" onclick="del_row(` + id + `)" class="tblItem_del"><span class="ui-icon ui-icon-trash"></span></a>
        </span>
        </td>

        </tr>
    `);


    // $('#select' + id).select2();
    $('.select2bs4').select2({
      theme: 'bootstrap4',
    })

    field_data();
  }

  function del_row(id) {
    $('#' + id).remove();
    var baris = parseInt($('#baris').text()) - 1;
    $('#baris').text(baris);
  }

  function lookupRole(role_id,id) {

    var role = $('#role_id').val();
    // console.log(role);
    if (typeof role === 'undefined') role = '';



    var url = "<?= URL::to('/') ?>/role?popup=1&currentpage=" + currentpage + "&id=" + role;
    // console.log(url);
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
          // console.log($('#role_id'+id));
          console.log(id);
          $('#role_id'+id).val(kode);
          $('#rolename'+id).val(role);
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

      $.ajax({
        url: actionUrl,
        method: method,
        dataType: 'JSON',
        data: $('form').serializeArray(),
        success: response => {
          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()

          if (response.status) {
            alert(response.message)

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