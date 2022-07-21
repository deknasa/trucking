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
            <input type="hidden" name="sortIndex" value="{{ $sortname }}">
            <input type="hidden" name="sortOrder" value="{{ $sortorder }}">
            <input type="hidden" name="indexRow" value="{{ $_GET['indexRow'] ?? 1 }}">
            <input type="hidden" name="page" value="{{ $_GET['page'] ?? 1 }}">

            <div class="row form-group">
              <label for="staticEmail" class="col-sm-3 col-md-2 col-form-label">ID <span class="text-danger"></span></label>
              <div class="col-sm-9 col-md-10">
                <input type="text" name="id" class="form-control" value="{{ $cabang['id'] ?? '' }}" readonly>
              </div>
            </div>

            <div class="row form-group">
              <label for="staticEmail" class="col-sm-3 col-md-2 col-form-label">Kode Cabang<span class="text-danger">*</span></label>
              <div class="col-sm-9 col-md-10">
                <input type="text" name="kodecabang" class="form-control" value="{{ $cabang['kodecabang'] ?? '' }}">
              </div>
            </div>

            <div class="row form-group">
              <label for="staticEmail" class="col-sm-3 col-md-2 col-form-label">Nama Cabang<span class="text-danger">*</span></label>
              <div class="col-sm-9 col-md-10">
                <input type="text" name="namacabang" class="form-control" value="{{ $cabang['namacabang'] ?? '' }}">
              </div>
            </div>

            <div class="form-group row">
              <label for="staticEmail" class="col-sm-3 col-md-2 col-form-label">Status Aktif<span class="text-danger">*</span></label>
              <div class="col-sm-9 col-md-10">
                <select class="form-control select2bs4  <?= @$disable2 ?>" style="width: 100%;" name="statusaktif" id="statusaktif">
                  <?php foreach ($data['combo'] as $status) : ?>;
                  <option value="<?= $status['id'] ?>" <?= $status['id'] == @$cabang['statusaktif'] ? 'selected' : '' ?>><?= $status['keterangan'] ?></option>
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
            <a href="{{ route('cabang.index') }}" class="btn btn-danger">
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


  let indexUrl = "{{ route('cabang.index') }}"
  let action = "{{ $action }}"
  let actionUrl =  "{{ config('app.api_url') . 'cabang' }}" 
  let method = "POST"
  let csrfToken = "{{ csrf_token() }}"


  /* Set action url */

  <?php if ($action !== 'add') : ?>
    actionUrl += `/{{ $cabang['id'] }}`
    
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
            window.location.href = `${indexUrl}?page=${response.data.page ?? 1}&id=${response.data.id ?? 1}&sortname={{ $_GET['sortname'] ?? '' }}&sortorder={{ $_GET['sortorder'] }}&limit={{ $_GET['limit'] }}`
          }

          if (response.errors) {
            setErrorMessages(response.errors)
          }
        },
        error: error => {
          alert(`${error.statusText} | ${error.responseText}`)
        },
      }).always(() => {
        $(this).removeAttr('disabled')
      })
    })

    /* Get field maxlength */
    $.ajax({
      url: fieldLengthUrl,
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
        alert(error)
      }
    })
  })
</script>
@endpush()