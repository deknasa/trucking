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
                <input type="text" name="id" class="form-control" value="{{ $tarif['id'] ?? '' }}" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  TUJUAN <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="tujuan" class="form-control" value="{{ $tarif['tujuan'] ?? '' }}">
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
                            $selected = @$tarif['container_id'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['keterangan'] }}</option>
                        <?php } ?>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  NOMINAL <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="nominal" class="form-control text-right" value="{{ number_format($tarif['nominal']??0,0,'.','.') }}" oninput="separatorNumber(this)">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  STATUS AKTIF <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="statusaktif" class="form-control select2bs4">
                        <option value="">PILIH STATUS</option>
                        <?php foreach ($combo['statusaktif'] as $key => $item) { 
                            $selected = @$tarif['statusaktif'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['text'] }}</option>
                        <?php } ?>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  TUJUAN ASAL <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="tujuanasal" class="form-control" value="{{ $tarif['tujuanasal'] ?? '' }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  SISTEM TON <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="sistemton" class="form-control" value="{{ $tarif['sistemton'] ?? '' }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  KOTA <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="kota_id" class="form-control select2bs4">
                        <option value="">PILIH KOTA</option>
                        <?php foreach ($combo['kota'] as $key => $item) { 
                            $selected = @$tarif['kota_id'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['kodekota'] }}</option>
                        <?php } ?>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  ZONA <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="zona_id" class="form-control select2bs4">
                        <option value="">PILIH ZONA</option>
                        <?php foreach ($combo['zona'] as $key => $item) { 
                            $selected = @$tarif['zona_id'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['zona'] }}</option>
                        <?php } ?>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  NOMINAL TON
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="nominalton" class="form-control text-right" value="{{ number_format($tarif['nominalton']??0,0,'.','.') }}" oninput="separatorNumber(this)">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  TGL BERLAKU<span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                @php
                if (isset($tarif['tglberlaku'])) {
                $tgl = date('d-m-Y',strtotime($tarif['tglberlaku']));
                } else {
                $tgl = date('d-m-Y');
                }
                @endphp
                <input type="text" name="tglberlaku" class="form-control datepicker" value="{{ $tgl }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  STATUS PENYESUAIAN HARGA <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="statuspenyesuaianharga" class="form-control select2bs4">
                        <option value="">PILIH STATUS</option>
                        <?php foreach ($combo['statuspenyesuaianharga'] as $key => $item) { 
                            $selected = @$tarif['statuspenyesuaianharga'] == $item['id'] ? "selected" : ""
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
            <a href="{{ route('tarif.index') }}" class="btn btn-danger">
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
  function separatorNumber(object) {
    var value = parseInt(object.value.replaceAll('.', '').replaceAll(',', ''));

    if ($.isNumeric(value)) {
      object.value = value.toLocaleString();
    } else {
      object.value = '';
    }

    return true;
  }
  
 

  let indexUrl = "{{ route('tarif.index') }}"
  let action = "{{ $action }}"
  let actionUrl =  "{{ config('app.api_url') . 'tarif' }}" 
  let method = "POST"
  let csrfToken = "{{ csrf_token() }}"

  /* Set action url */
  <?php if ($action !== 'add') : ?>
    actionUrl += `/{{ $tarif['id'] }}`
    
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