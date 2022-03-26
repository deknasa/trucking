<?php

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
            @csrf
            <input type="hidden" name="limit" value="{{ $limit }}">
            <input type="hidden" name="sortname" value="{{ $sortname }}">
            <input type="hidden" name="sortorder" value="{{ $sortorder }}">
            <input type="hidden" name="indexRow" value="{{ $_GET['indexRow'] ?? 1 }}">
            <input type="hidden" name="page" value="{{ $_GET['page'] ?? 1 }}">

            <div class="row form-group">
              <label for="staticEmail" class="col-12 col-sm-3 col-md-2 col-form-label">ID <span class="text-danger"></span></label>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="id" class="form-control" value="{{ $user['id'] ?? '' }}" readonly>
              </div>
            </div>
            <div class="row form-group">
              <label for="staticEmail" class="col-12 col-sm-3 col-md-2 col-form-label">User<span class="text-danger">*</span></label>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="user" class="form-control" value="{{ $user['user'] ?? '' }}">
              </div>
            </div>
            <div class="row form-group">
              <label for="staticEmail" class="col-12 col-sm-3 col-md-2 col-form-label">Nama User<span class="text-danger">*</span></label>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="name" class="form-control" value="{{ $user['name'] ?? '' }}">
              </div>
            </div>
            @if($action == 'add')
            <div class="row form-group">
              <label for="staticEmail" class="col-12 col-sm-3 col-md-2 col-form-label">Password<span class="text-danger">*</span></label>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="password" name="password" class="form-control" value="{{ $user['password'] ?? '' }}">
              </div>
            </div>
            @endif

            <div class="form-group row">
              <label for="staticEmail" class="col-12 col-sm-3 col-md-2 col-form-label">Cabang<span class="text-danger">*</span></label>
              <div class="col-12 col-sm-9 col-md-10">
                <select id="selectcabang_id" name="cabang_id" class="form-select select2bs4" style="width: 100%;">
                  @foreach($data['combocabang'] as $cabang)
                  <option value="{{ $cabang['id'] }}">{{ $cabang['namacabang'] }}</option>
                  @endforeach
                </select>
              </div>
            </div>

            <div class="row form-group">
              <label for="staticEmail" class="col-12 col-sm-3 col-md-2 col-form-label">Karyawan ID<span class="text-danger">*</span></label>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="number" name="karyawan_id" class="form-control" value="{{ $user['karyawan_id'] ?? 0 }}">
              </div>
            </div>

            <div class="row form-group">
              <label for="staticEmail" class="col-12 col-sm-3 col-md-2 col-form-label">Dashboard</label>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="dashboard" class="form-control" value="{{ $user['dashboard'] ?? '' }}">
              </div>
            </div>

            <div class="form-group row">
              <label for="staticEmail" class="col-12 col-sm-3 col-md-2 col-form-label">Status Aktif<span class="text-danger">*</span></label>
              <div class="col-12 col-sm-9 col-md-10">
                <select class="form-control select2bs4 <?= @$disable2 ?>" style="width: 100%;" name="statusaktif" id="statusaktif">
                  <?php foreach ($data['combo'] as $status) : ?>;
                  <option value="<?= $status['id'] ?>" <?= $status['id'] == @$user['statusaktif'] ? 'selected' : '' ?>><?= $status['keterangan'] ?></option>
                <?php endforeach; ?>
                </select>
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
            <a href="{{ route('user.index') }}" class="btn btn-danger">
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
  let indexUrl = "{{ route('user.index') }}"
  let fieldLengthUrl = "{{ route('user.field_length') }}"
  let action = "{{ $action }}"
  let actionUrl = "{{ route('user.store') }}"
  let method = "POST"
  let csrfToken = "{{ csrf_token() }}"

  /* Set action url */
  <?php if ($action == 'edit') : ?>
    actionUrl = "{{ route('user.update', $user['id']) }}"
    method = "PATCH"
  <?php elseif ($action == 'delete') : ?>
    actionUrl = "{{ route('user.destroy', $user['id']) }}"
    method = "DELETE"
  <?php endif; ?>

  if (action == 'delete') {
    $('[name]').addClass('disabled')
  }

  $(document).ready(function() {
    $('form').submit(function(e) {
      e.preventDefault()
    })

    $('#btnSimpan').click(function() {
      $(this).attr('disabled', '')
      $('#loader').removeClass('d-none')

      $.ajax({
        url: actionUrl,
        method: method,
        dataType: 'JSON',
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
        },
      }).always(() => {
        $('#loader').addClass('d-none')
        $(this).removeAttr('disabled')
      })
    })

    // $('#selectcabang_id').select2({
    //   data: JSON.parse(`<?php echo json_encode($data['combocabang']); ?>`),
    //   theme: 'bootstrap4',
    //   width: '100%',
    //   templateResult: formatResult,
    //   templateSelection: formatSelection,
    //   matcher: matcher,
    //   escapeMarkup: function(m) {
    //     return m;
    //   },
    // })

    var firstEmptySelect = false;

    function formatSelection(selection) {
      return '<div class="row">' +
        '<div class="col-12">' + selection.namacabang + '</div>' +
        '</div>';
    }

    function formatResult(result) {
      if (!result.id) {
        if (firstEmptySelect) {
          firstEmptySelect = false;

          return '<div class="row">' +
            '<div class="col-sm-3"><b>ID</b></div>' +
            '<div class="col-sm-9"><b>Nama Cabang</b></div>' +
            '</div>';
        } else {
          return false;
        }
      }
      return '<div class="row">' +
        '<div class="col-sm-3">' + result.id + '</div>' +
        '<div class="col-sm-9">' + result.namacabang + '</div>' +
        '</div>';
    }

    function matcher(query, option) {
      firstEmptySelect = true;

      if (!query.term) {
        return option;
      }

      var has = true;
      var words = query.term.toUpperCase().split(" ");

      for (var i = 0; i < words.length; i++) {
        var word = words[i];
        if (option.namacabang !== undefined) {
          has = has && (option.namacabang.toUpperCase().indexOf(word) >= 0);
        }
      }

      if (has) {
        return option
      }

      return null;
    }

    /* Get field maxlength */
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
    })
  })
</script>
@endpush()