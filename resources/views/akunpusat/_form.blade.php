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
              <div class="col-12 col-md-2 col-form-label">
                <label>ID</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="id" class="form-control" value="{{ $akunPusat['id'] ?? '' }}" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  coa <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="coa" class="form-control" value="{{ $akunPusat['coa'] ?? '' }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  keterangan coa <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="keterangancoa" class="form-control" value="{{ $akunPusat['keterangancoa'] ?? '' }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  type <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="type" class="form-control" value="{{ $akunPusat['type'] ?? '' }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  level <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="level" class="form-control" value="{{ $akunPusat['level'] ?? '' }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  aktif <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="aktif" class="form-control" value="{{ $akunPusat['aktif'] ?? '' }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  parent <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="parent" class="form-control" value="{{ $akunPusat['parent'] ?? '' }}">
              </div>
            </div>
            <div class="row form-group">
              <label for="staticEmail" class="col-12 col-md-2 col-form-label">STATUS COA<span class="text-danger">*</span></label>
              <div class="col-12 col-md-10">
                <select name="statuscoa" class="w-100">
                  <optgroup label="">
                    <option selected hidden disabled></option>
                    @foreach($combo['statuscoa'] as $statuscoa)
                    <option value="{{ $statuscoa['id'] }}" {{ $statuscoa['id'] == @$akunPusat['statuscoa'] ? 'selected' : '' }}>{{ $statuscoa['text'] }}</option>
                    @endforeach
                  </optgroup>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <label for="staticEmail" class="col-12 col-md-2 col-form-label">STATUS ACCOUNT PAYABLE<span class="text-danger">*</span></label>
              <div class="col-12 col-md-10">
                <select name="statusaccountpayable" class="w-100">
                  <optgroup label="">
                    <option selected hidden disabled></option>
                    @foreach($combo['statusaccountpayable'] as $statusaccountpayable)
                    <option value="{{ $statusaccountpayable['id'] }}" {{ $statusaccountpayable['id'] == @$akunPusat['statusaccountpayable'] ? 'selected' : '' }}>{{ $statusaccountpayable['text'] }}</option>
                    @endforeach
                  </optgroup>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <label for="staticEmail" class="col-12 col-md-2 col-form-label">STATUS NERACA<span class="text-danger">*</span></label>
              <div class="col-12 col-md-10">
                <select name="statusneraca" class="w-100">
                  <optgroup label="">
                    <option selected hidden disabled></option>
                    @foreach($combo['statusneraca'] as $statusneraca)
                    <option value="{{ $statusneraca['id'] }}" {{ $statusneraca['id'] == @$akunPusat['statusneraca'] ? 'selected' : '' }}>{{ $statusneraca['text'] }}</option>
                    @endforeach
                  </optgroup>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <label for="staticEmail" class="col-12 col-md-2 col-form-label">STATUS LABA RUGI<span class="text-danger">*</span></label>
              <div class="col-12 col-md-10">
                <select name="statuslabarugi" class="w-100">
                  <optgroup label="">
                    <option selected hidden disabled></option>
                    @foreach($combo['statuslabarugi'] as $statuslabarugi)
                    <option value="{{ $statuslabarugi['id'] }}" {{ $statuslabarugi['id'] == @$akunPusat['statuslabarugi'] ? 'selected' : '' }}>{{ $statuslabarugi['text'] }}</option>
                    @endforeach
                  </optgroup>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  coamain <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="coamain" class="form-control" value="{{ $akunPusat['coamain'] ?? '' }}">
              </div>
            </div>
            <div class="row form-group">
              <label for="staticEmail" class="col-12 col-md-2 col-form-label">STATUS AKTIF<span class="text-danger">*</span></label>
              <div class="col-12 col-md-10">
                <select name="statusaktif" class="w-100">
                  <optgroup label="">
                    <option selected hidden disabled></option>
                    @foreach($combo['statusaktif'] as $statusaktif)
                    <option value="{{ $statusaktif['id'] }}" {{ $statusaktif['id'] == @$akunPusat['statusaktif'] ? 'selected' : '' }}>{{ $statusaktif['text'] }}</option>
                    @endforeach
                  </optgroup>
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
            <a href="{{ route('akunpusat.index') }}" class="btn btn-danger">
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
  let indexUrl = "{{ route('akunpusat.index') }}"
  let action = "{{ $action }}"
  let actionUrl = "{{ config('app.api_url') . 'akunpusat' }}"
  let method = "POST"
  let csrfToken = "{{ csrf_token() }}"

  /* Set action url */
  <?php if ($action !== 'add') : ?>
    actionUrl += `/{{ $akunPusat['id'] }}`

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