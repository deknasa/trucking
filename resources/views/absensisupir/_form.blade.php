<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card card-primary">
        <div class="card-header">Form {{ $title }}</div>
        <form action="" method="post">
          <div class="card-body">
            @csrf
            <input type="hidden" name="limit" value="{{ $_GET['limit'] ?? 10 }}">
            <input type="hidden" name="sortname" value="{{ $_GET['sortname'] ?? 'id' }}">
            <input type="hidden" name="sortorder" value="{{ $_GET['sortorder'] ?? 'asc' }}">
            <input type="hidden" name="kasgantung_nobukti" value="{{ $absensisupir['kasgantung_nobukti'] ?? $kasGantungNoBukti }}">

            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>NO BUKTI</label>
              </div>
              <div class="col-12 col-md-4">
                <input type="text" name="nobukti" class="form-control" value="{{ $absensisupir['nobukti'] ?? $noBukti }}" readonly>
              </div>
              <div class="col-12 col-md-2 col-form-label">
                <label>TANGGAL</label>
              </div>
              <div class="col-12 col-md-4">
                <input type="text" name="tgl" class="form-control datepicker" value="{{ $absensisupir['tgl'] ?? '' }}">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>KETERANGAN</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="keterangan" class="form-control" value="{{ $absensisupir['keterangan'] ?? '' }}">
              </div>
            </div>

            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Trado</th>
                        <th>Supir</th>
                        <th>Uang Jalan</th>
                        <th>Status</th>
                        <th>Jam</th>
                        <th>Keterangan</th>
                      </tr>
                    </thead>
                    <tbody id="table_body" class="form-group">
                      @foreach($combo['trado'] as $tradoIndex => $trado)
                      <tr>
                        <td>
                          <input type="hidden" name="trado_id[]" value="{{ $trado['id'] }}">
                          {{ $trado['keterangan'] }}
                        </td>
                        <td width="20%">
                          <select name="supir_id[]" class="form-control">
                            @foreach($combo['supir'] as $supirIndex => $supir)
                            <option value="{{ $supir['id'] }}" {{ $supir['id'] == @$absensisupir['absensi_supir_detail'][$tradoIndex]['supir']['id'] ? 'selected' : '' }}>{{ $supir['namasupir'] }}</option>
                            @endforeach
                          </select>
                        </td>
                        <td>
                          <input type="text" name="uangjalan[]" class="form-control autonumeric" value="{{ $absensisupir['absensi_supir_detail'][$tradoIndex]['uangjalan'] ?? '' }}">
                        </td>
                        <td width="20%">
                          <select name="absen_id[]" class="form-control">
                            @foreach($combo['status'] as $status)
                            <option value="{{ $status['id'] }}" {{ $status['id'] == @$absensisupir['absensi_supir_detail'][$tradoIndex]['absen_trado']['id'] ? 'selected' : '' }}>{{ $status['kodeabsen'] }}</option>
                            @endforeach
                          </select>
                        </td>
                        <td>
                          <input type="time" name="jam[]" class="form-control" value="{{ $absensisupir['jam'] ?? '' }}">
                        </td>
                        <td>
                          <input type="text" name="keterangan_detail[]" class="form-control" value="{{ $absensisupir['absensi_supir_detail'][$tradoIndex]['trado']['keterangan'] ?? '' }}">
                        </td>
                      </tr>
                      @endforeach
                    </tbody>
                  </table>
                </div>
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
            <a href="{{ route('absensisupir.index') }}" class="btn btn-danger">
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
  let indexUrl = "{{ route('absensisupir.index') }}"
  let action = "{{ $action }}"
  let actionUrl = "{{ route('absensisupir.store') }}"
  let method = "POST"
  let csrfToken = "{{ csrf_token() }}"

  /* Set action url */
  <?php if ($action == 'edit') : ?>
    actionUrl = "{{ route('absensisupir.update', $absensisupir['id']) }}"
    method = "PATCH"
  <?php elseif ($action == 'delete') : ?>
    actionUrl = "{{ route('absensisupir.destroy', $absensisupir['id']) }}"
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

      $.ajax({
        url: actionUrl,
        method: method,
        dataType: 'JSON',
        data: $('form').serializeArray(),
        success: response => {
          alert('success')
          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()

          if (response.status) {
            if (action != 'delete') {
              window.location.href = `${indexUrl}?page=${response.data.page ?? 1}&id=${response.data.id ?? 1}&sortname={{ $_GET['sortname'] ?? '' }}&sortorder={{ $_GET['sortorder'] }}&limit={{ $_GET['limit'] }}`
            } else {
              window.location.href = `${indexUrl}?page={{ $_GET['page'] ?? '' }}&sortname={{ $_GET['sortname'] ?? '' }}&sortorder={{ $_GET['sortorder'] }}&limit={{ $_GET['limit'] ?? ''}}&indexRow={{ $_GET['indexRow'] ?? '' }}`
            }
          }

          if (response.errors) {
            setErrorMessages(response.errors)
          }
        },
        error: error => {
          alert('error')
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            setErrorMessages(error.responseJSON.errors);
          } else {
            showDialog(error.statusText)
          }
        }
      }).always(() => {
        $(this).removeAttr('disabled')
      })
    })
  })
</script>
@endpush()