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
                  <label>USER</label>
                </div>
                <div class="col-12 col-md-5">
                  <div class="input-group mb-0 pb-0">

                    <input type="text" name="user" id="user" class="form-control" value="{{ $useracl['user'] ?? '' }}" placeholder="User">
                    <div class="input-group-append">
                      <!-- <button class="btn btn-outline-secondary" type="button" tabindex="-1" data-toggle="modal" data-target="#myModal" data-whatever="{{ $useracl['user'] ?? 'tes' }}">...</button> -->
                      <button class="btn btn-outline-secondary" type="button" onclick="lookupUser('user')" tabindex="-1">...</button>

                    </div>

                  </div>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-12 col-md-1"></div>
                <div class="col-12 col-md-5">
                  <input type="hidden" value="{{ $useracl['user_id'] ?? '' }}" name="user_id" id="user_id" />
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
                          <select class="form-control select2bs4" name="status[]" id="status">
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
            <a href="{{ route('useracl.index') }}" class="btn btn-danger">
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
    <div class=" modal-dialog modal-lg">

      <div class="modal-content">

        <!-- Modal Header -->
        <div class="modal-header">
          <h4 class="modal-title">Form User</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>

        <!-- Modal body -->
        <form id="pilih">

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
                      <button type="submit" class="btn btn-primary">Pilih</button>
                      <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                  </div>
                </div>
              </div>
            </table>
          </div>
        </form>



      </div>
    </div>
  </div>
</div>
</div>



@push('scripts')
<script>
  let indexUrl = "{{ route('useracl.index') }}"
  let action = "{{ $action }}"
  let actionUrl = "{{ config('app.api_url') . 'useracl' }}"
  let method = "POST"
  let csrfToken = "{{ csrf_token() }}"
  let fieldLengthUrl = "{{ route('useracl.field_length') }}"


  <?php

  use Illuminate\Support\Facades\URL;

  if ($action !== 'add') : ?>
    actionUrl += `/{{ $useracl['id'] }}`
  <?php endif; ?>

  <?php if ($action == 'edit') : ?>
    method = "PATCH"
  <?php elseif ($action == 'delete') : ?>
    method = "DELETE"
  <?php endif; ?>

  if (action == 'delete') {
    $('[name]').addClass('disabled')
  }

  /*Modal JQgrid action */
  let indexUrluser = "{{ route('user.index') }}"
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
    var user = $('#user').val();
    var modal = $(this);
    console.log(user);
    console.log($('#gs_user').val(user));
    if (typeof user === 'undefined') user = '';
    var grid = $("#jqGrid");
    var postdata = grid.jqGrid('getGridParam', 'postData');
    jQuery.extend(postdata, {
      _search: true,
      filters: JSON.stringify({
        "groupOp": "AND",
        "rules": [{
          "field": "user",
          "op": "cn",
          "data": user
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


  if (action == 'delete') {
    $('[name]').addClass('disabled')
  }

  function lookupUser(user) {

    var user = $('#user').val();
    console.log(user);
    if (typeof user === 'undefined') user = '';


    if (user) {
      var url = "<?= URL::to('/') ?>/user?popup=1&currentpage=" + currentpage + "&user=" + user;
    } else {
      var url = "<?= URL::to('/') ?>/user?popup=1&currentpage=" + currentpage;
    }

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
          var user = removeTags(getUser_id.user);
          $("#user").val(user);
          $('#user_id').val(kode);
          // setDetail(kode);
        }
      }
    }, 500);

  }

  $.ajax({
    url: `{{ config('app.api_url') . 'useracl/field_length' }}`,
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

  function getiduser(e) {
    var keyCode = e.keyCode || e.which;


    // var role_id = $('#'+user).val();

    if (user_id != '') {
      $('#user_id').val('');
      $.ajax({
        url: "<?= URL::to('/') . '/user/getuserid?user=' ?>" + $('#user').val(),
        method: 'GET',
        dataType: 'JSON',
        // async: false,
      }).done(function(data) {
        if (data != null) {
          $('#user_id').val(data.id);
        } else {
          $('#user_id').val('');
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

          if (response.status) {
            if (action != 'delete') {
              window.location.href = `${indexUrl}?page=${response.data.page ?? 1}&id=${response.data.id ?? 1}&sortname={{ $_GET['sortname'] ?? '' }}&sortorder={{ $_GET['sortorder'] }}&limit={{ $_GET['limit'] }}`
            } else {
              window.location.href = `${indexUrl}?page={{ $_GET['page'] ?? '' }}&sortname={{ $_GET['sortname'] ?? '' }}&sortorder={{ $_GET['sortorder'] }}&limit={{ $_GET['limit'] ?? ''}}&indexRow={{ $_GET['indexRow'] ?? '' }}`
            }
          }
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
      // $('#btnpilih').click(function() {
      //   $(this).attr('disabled', '')

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
    })



  })
</script>
@endpush()