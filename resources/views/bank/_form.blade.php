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
                <input type="text" name="id" class="form-control" value="{{ $bank['id'] ?? '' }}" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  KODE BANK <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="kodebank" class="form-control" value="{{ $bank['kodebank'] ?? '' }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  NAMA BANK <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="namabank" class="form-control" value="{{ $bank['namabank'] ?? '' }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  COA <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="coa" class="form-control select2bs4">
                        <option value="">PILIH COA</option>
                        <?php foreach ($combo['akunpusat'] as $key => $item) { 
                            $selected = @$bank['coa'] == $item['coa'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['coa'] }}" {{ $selected }} >{{ $item['coa'] }}</option>
                        <?php } ?>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  TIPE <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="tipe" class="form-control" value="{{ $bank['tipe'] ?? '' }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  STATUS AKTIF <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <select name="statusaktif" class="form-control select2bs4">
                        <option value="">PILIH STATUS</option>
                        <?php foreach ($combo['status'] as $key => $item) { 
                            $selected = @$bank['statusaktif'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['text'] }}</option>
                        <?php } ?>
                </select>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  KODE PENERIMAAN <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <select name="kodepenerimaan" class="form-control select2bs4">
                        <option value="">PILIH PENERIMAAN</option>
                        <?php foreach ($combo['kodepenerimaan'] as $key => $item) { 
                            $selected = @$bank['kodepenerimaan'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['text'] }}</option>
                        <?php } ?>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  KODE PENGELUARAN <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <select name="kodepengeluaran" class="form-control select2bs4">
                        <option value="">PILIH PENGELUARAN</option>
                        <?php foreach ($combo['kodepengeluaran'] as $key => $item) { 
                            $selected = @$bank['kodepengeluaran'] == $item['id'] ? "selected" : ""
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
            <a href="{{ route('bank.index') }}" class="btn btn-danger">
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

  let indexUrl = "{{ route('bank.index') }}"
  let action = "{{ $action }}"
  let actionUrl =  "{{ config('app.api_url') . 'bank' }}" 
  let method = "POST"
  let csrfToken = "{{ csrf_token() }}"


  
<?php if ($action !== 'add') : ?>
    actionUrl += `/{{ $bank['id'] }}`
  <?php endif; ?>

  /* Set action url */
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
        data: $('form').serializeArray(),
        headers: {
          'Authorization': `Bearer {{ session('access_token') }}`
        },
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
      url: `{{ config('app.api_url') . 'bank/field_length' }}`,
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