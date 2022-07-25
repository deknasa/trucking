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
              <div class="col-12 col-md-2 col-form-label">
                <label>ID</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="id" class="form-control" value="{{ $alatbayar['id'] ?? '' }}" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  KODE ALATBAYAR <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="kodealatbayar" class="form-control" value="{{ $alatbayar['kodealatbayar'] ?? '' }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  NAMA ALATBAYAR <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="namaalatbayar" class="form-control" value="{{ $alatbayar['namaalatbayar'] ?? '' }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  KETERANGAN <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="keterangan" class="form-control" value="{{ $alatbayar['keterangan'] ?? '' }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  STATUS LANGSUNG CAIR <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="statuslangsungcair" class="form-control select2bs4">
                        <option value="">PILIH STATUS</option>
                        <?php foreach ($combo['langsungcair'] as $key => $item) { 
                            $selected = @$alatbayar['statuslangsunggcair'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['text'] }}</option>
                        <?php } ?>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  STATUS DEFAULT <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="statusdefault" class="form-control select2bs4">
                        <option value="">PILIH STATUS</option>
                        <?php foreach ($combo['statusdefault'] as $key => $item) { 
                            $selected = @$alatbayar['statusdefault'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['text'] }}</option>
                        <?php } ?>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  BANK <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="bank_id" class="form-control select2bs4">
                        <option value="">PILIH BANK</option>
                        <?php foreach ($combo['bank'] as $key => $item) { 
                            $selected = @$alatbayar['bank_id'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['namabank'] }}</option>
                        <?php } ?>
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
            <a href="{{ route('alatbayar.index') }}" class="btn btn-danger">
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


  let indexUrl = "{{ route('alatbayar.index') }}"
  let action = "{{ $action }}"
  let actionUrl =  "{{ config('app.api_url') . 'alatbayar' }}" 
  let method = "POST"
  let csrfToken = "{{ csrf_token() }}"

  
  /* Set action url */

  <?php if ($action !== 'add') : ?>
    actionUrl += `/{{ $alatbayar['id'] }}`
    
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
            window.location.href = `${indexUrl}?page=${response.data.page ?? 1}&id=${response.data.id ?? 1}&sortname={{ $sortname }}&sortorder={{ $sortorder }}&limit={{ $limit }}`
          }

          if (response.errors) {
            setErrorMessages(response.errors)
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
        showDialog(error.statusText)
      }
    })
  })
</script>
@endpush()