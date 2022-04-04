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
              <label for="staticEmail" class="col-sm-3 col-md-2 col-form-label">ID <span class="text-danger"></span></label>
              <div class="col-sm-9 col-md-10">
                <input type="text" name="id" class="form-control" value="{{ $menu['id'] ?? '' }}" readonly>
              </div>
            </div>

            <div class="form-group row">
              <label for="staticEmail" class="col-sm-3 col-md-2 col-form-label">Nama Menu <span class="text-danger">*</span></label>
              <div class="col-sm-9 col-md-10">
                <input type="text" name="menuname" class="form-control" id="menuname" placeholder="Nama Menu" value="{{ $menu['menuname'] ?? '' }}">
              </div>
            </div>

            <div class="form-group row">
              <label for="staticEmail" class="col-sm-3 col-md-2 col-form-label">Pengurutan<span class="text-danger">*</span></label>
              <div class="col-sm-9 col-md-10">
                <input type="text" name="menuseq" class="form-control numbernoseparate" id="menuseq" placeholder="Pengurutan" value="{{ $menu['menuseq'] ?? '' }}">
              </div>
            </div>

            @if($action == 'add')
            <div class="form-group row">
              <label for="staticEmail" class="col-sm-3 col-md-2 col-form-label">Menu Parent<span class="text-danger">*</span></label>
              <div class="col-sm-9 col-md-10">
                <select class="form-control select2bs4  <?= @$disable2 ?>" style="width: 100%;" name="menuparent" id="menuparent">
                  <?php foreach ($data['combo'] as $status) : ?>;
                  <option value="<?= $status['id'] ?>" <?= $status['id'] == @$menu['menuparent'] ? 'selected' : '' ?>><?= strtoupper($status['menuparent']) ?></option>
                <?php endforeach; ?>
                </select>
              </div>
            </div>
            @endif

            <div class="form-group row">
              <label for="staticEmail" class="col-sm-3 col-md-2 col-form-label">Icon <span class="text-danger">*</span></label>
              <div class="col-sm-9 col-md-10">
                <input type="text" name="menuicon" class="form-control" id="menuicon" placeholder="Icon" value="{{ $menu['menuicon'] ?? '' }}">
              </div>
            </div>

            @if($action == 'add')
            <div class="form-group row">
              <label for="staticEmail" class="col-sm-3 col-md-2 col-form-label">Link <span class="text-danger">*</span></label>
              <div class="col-sm-9 col-md-10">
                <input type="text" name="menuexe" class="form-control" id="menuexe" placeholder="Link" value="{{ $menu['menuexe'] ?? '' }}">
              </div>
            </div>
            @endif

            @if($action == 'add')
            <div class="form-group row">
              <label for="staticEmail" class="col-sm-3 col-md-2 col-form-label">Controller<span class="text-danger">*</span></label>
              <div class="col-sm-9 col-md-10">
                <select class="form-control select2bs4  <?= @$disable2 ?>" style="width: 100%;" name="controller" id="controller" <?= ($data['edit'] == '1') ? 'readonly' : '' ?>>
                  <?php foreach ($data['class'] as $class) : ?>;
                  <option value="<?= $class['class'] ?>" <?= $class['class'] == @$data['nama'] ? 'selected' : '' ?>><?= strtoupper($class['class']) ?></option>
                <?php endforeach; ?>
                </select>
              </div>
            </div>
            @endif

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
            <a href="{{ route('menu.index') }}" class="btn btn-danger">
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
  let indexUrl = "{{ route('menu.index') }}"
  let fieldLengthUrl = "{{ route('menu.field_length') }}"
  let action = "{{ $action }}"
  let actionUrl = "{{ config('app.api_url') . 'menu' }}"
  let method = "POST"
  let csrfToken = "{{ csrf_token() }}"

  /* Set action url */
  <?php if ($action !== 'add') : ?>
    actionUrl += `/{{ $menu['id'] }}`
  <?php endif; ?>

  <?php if ($action == 'edit') : ?>
    method = "PATCH"
  <?php elseif ($action == 'delete') : ?>
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
        },
      }).always(() => {
        $('#loader').addClass('d-none')
        $(this).removeAttr('disabled')
      })
    })

    /* Get field maxlength */
    $.ajax({
      url: `{{ config('app.api_url') . 'menu/field_length' }}`,
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
  })
</script>
@endpush()