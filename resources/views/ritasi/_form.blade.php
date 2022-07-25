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
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>ID</label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="id" class="form-control" value="{{ $ritasi['id'] ?? '' }}" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  NO BUKTI <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="nobukti" class="form-control" value="{{ $ritasi['nobukti'] ?? '' }}" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  TLG BUKTI <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="tglbukti" class="form-control formatdate" value="{{ $ritasi['tglbukti'] ?? '' }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  STATUS RITASI <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="statusritasi" class="form-control select2bs4">
                        <option value="">PILIH RITASI</option>
                        <?php foreach ($combo['statusritasi'] as $key => $item) { 
                            $selected = @$ritasi['statusritasi'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['text'] }}</option>
                        <?php } ?>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  SURAT PENGANTAR <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="suratpengantar_nobukti" class="form-control select2bs4">
                        <option value="">PILIH SURAT PENGANTAR</option>
                        <?php foreach ($combo['suratpengantar'] as $key => $item) { 
                            $selected = @$ritasi['suratpengantar_nobukti'] == $item['nobukti'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['nobukti'] }}" {{ $selected }} >{{ $item['nobukti'] }}</option>
                        <?php } ?>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  DARI <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="dari_id" class="form-control select2bs4">
                        <option value="">PILIH DARI</option>
                        <?php foreach ($combo['kota'] as $key => $item) { 
                            $selected = @$ritasi['dari_id'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['keterangan'] }}</option>
                        <?php } ?>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  SAMPAI <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="sampai_id" class="form-control select2bs4">
                        <option value="">PILIH SAMPAI</option>
                        <?php foreach ($combo['kota'] as $key => $item) { 
                            $selected = @$ritasi['sampai_id'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['keterangan'] }}</option>
                        <?php } ?>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  TRADO <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="trado_id" class="form-control select2bs4">
                        <option value="">PILIH TRADO</option>
                        <?php foreach ($combo['trado'] as $key => $item) { 
                            $selected = @$ritasi['trado_id'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['keterangan'] }}</option>
                        <?php } ?>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  SUPIR <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="supir_id" class="form-control select2bs4">
                        <option value="">PILIH SUPIR</option>
                        <?php foreach ($combo['supir'] as $key => $item) { 
                            $selected = @$ritasi['supir_id'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['namasupir'] }}</option>
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
            <a href="{{ route('ritasi.index') }}" class="btn btn-danger">
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


  let indexUrl = "{{ route('ritasi.index') }}"
  let action = "{{ $action }}"
  let actionUrl =  "{{ config('app.api_url') . 'ritasi' }}" 
  let method = "POST"
  let csrfToken = "{{ csrf_token() }}"

  /* Set action url */
  <?php if ($action !== 'add') : ?>
    actionUrl += `/{{ $ritasi['id'] }}`
    
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
            window.location.href = `${indexUrl}?page=${response.data.page ?? 1}&id=${response.data.id ?? 1}&sortname={{ $sortname ?? '' }}&sortorder={{ $sortorder }}&limit={{ $limit }}`
          } else {
            showDialog(response.message)
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