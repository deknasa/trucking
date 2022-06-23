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
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>ID</label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="id" class="form-control" value="{{ $orderantrucking['id'] ?? '' }}" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  NO BUKTI <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="nobukti" class="form-control" value="{{ $orderantrucking['nobukti'] ?? '' }}" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  TGL BUKTI <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="tglbukti" class="form-control formatdate" value="{{ $orderantrucking['tglbukti'] ?? '' }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  CONTAINER <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="container_id" class="form-control select2bs4">
                        <option value="">PILIH CONTAINER</option>
                        <?php foreach ($combo['container'] as $key => $item) { 
                            $selected = @$orderantrucking['container_id'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['keterangan'] }}</option>
                        <?php } ?>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  AGEN <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="agen_id" class="form-control select2bs4">
                        <option value="">PILIH AGEN</option>
                        <?php foreach ($combo['agen'] as $key => $item) { 
                            $selected = @$orderantrucking['agen_id'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['namaagen'] }}</option>
                        <?php } ?>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  JENIS ORDER <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="jenisorder_id" class="form-control select2bs4">
                        <option value="">PILIH JENIS ORDER</option>
                        <?php foreach ($combo['jenisorder'] as $key => $item) { 
                            $selected = @$orderantrucking['jenisorder_id'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['keterangan'] }}</option>
                        <?php } ?>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  PELANGGAN <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="pelanggan_id" class="form-control select2bs4">
                        <option value="">PILIH PELANGGAN</option>
                        <?php foreach ($combo['pelanggan'] as $key => $item) { 
                            $selected = @$orderantrucking['pelanggan_id'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['namapelanggan'] }}</option>
                        <?php } ?>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  TARIF <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="tarif_id" class="form-control select2bs4">
                        <option value="">PILIH TARIF</option>
                        <?php foreach ($combo['tarif'] as $key => $item) { 
                            $selected = @$orderantrucking['tarif_id'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['tujuan'] }}</option>
                        <?php } ?>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  JOB EMKL <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="nojobemkl" class="form-control select2bs4">
                        <option value="">PILIH JOB EMKL</option>
                        <?php foreach ($combo['jobemkl'] as $key => $item) { 
                            $selected = @$orderantrucking['nojobemkl'] == $item['fntrans'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['fntrans'] }}" {{ $selected }} >{{ $item['fntrans'] }}</option>
                        <?php } ?>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  NO CONT <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="nocont" class="form-control" value="{{ $orderantrucking['nocont'] ?? '' }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  NO SEAL <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="noseal" class="form-control" value="{{ $orderantrucking['noseal'] ?? '' }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  JOB EMKL <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="nojobemkl2" class="form-control select2bs4">
                        <option value="">PILIH JOB EMKL</option>
                        <?php foreach ($combo['jobemkl'] as $key => $item) { 
                            $selected = @$orderantrucking['nojobemkl2'] == $item['fntrans'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['fntrans'] }}" {{ $selected }} >{{ $item['fntrans'] }}</option>
                        <?php } ?>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  NO CONT 2
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="nocont2" class="form-control" value="{{ $orderantrucking['nocont2'] ?? '' }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  NO SEAL 2
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="noseal2" class="form-control" value="{{ $orderantrucking['noseal2'] ?? '' }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  STATUS LANGSIR <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="statuslangsir" class="form-control select2bs4">
                        <option value="">PILIH STATUS</option>
                        <?php foreach ($combo['statuslangsir'] as $key => $item) { 
                            $selected = @$orderantrucking['statuslangsir'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['text'] }}</option>
                        <?php } ?>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  STATUS PERALIHAN <span class="text-danger">*</span></label>
              </div>
              
              <div class="col-12 col-md-10">
                <select name="statusperalihan" class="form-control select2bs4">
                        <option value="">PILIH STATUS</option>
                        <?php foreach ($combo['statusperalihan'] as $key => $item) { 
                            $selected = @$orderantrucking['statusperalihan'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['text'] }}</option>
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
            <a href="{{ route('orderantrucking.index') }}" class="btn btn-danger">
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
  


  let indexUrl = "{{ route('orderantrucking.index') }}"
  let action = "{{ $action }}"
  let actionUrl =  "{{ config('app.api_url') . 'orderantrucking' }}" 
  let method = "POST"
  let csrfToken = "{{ csrf_token() }}"

  /* Set action url */
  <?php if ($action !== 'add') : ?>
    actionUrl += `/{{ $orderantrucking['id'] }}`
    
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