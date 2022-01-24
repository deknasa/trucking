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
            <input type="hidden" name="kasgantung_nobukti" value="{{ $absensi['kasgantung_nobukti'] ?? $kasGantungNoBukti }}">

            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>NO BUKTI</label>
              </div>
              <div class="col-12 col-md-4">
                <input type="text" name="nobukti" class="form-control" value="{{ $absensi['nobukti'] ?? $noBukti }}" readonly>
              </div>
              <div class="col-12 col-md-2 col-form-label">
                <label>TANGGAL</label>
              </div>
              <div class="col-12 col-md-4">
                <input type="date" name="tgl" class="form-control" value="{{ $absensi['tgl'] ?? '' }}">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>KETERANGAN</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="keterangan" class="form-control" value="{{ $absensi['keterangan'] ?? '' }}">
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
                    <tbody id="table_body">
                      @foreach($combo['trado'] as $tradoIndex => $trado)
                      <tr>
                        <td>
                          <input type="hidden" name="trado_id[]" value="{{ $trado['id'] }}">
                          {{ $trado['keterangan'] }}
                        </td>
                        <td>
                          <select name="supir_id[]">
                            @foreach($combo['supir'] as $supirIndex => $supir)
                            <option value="{{ $supir['id'] }}" {{ $supir['id'] == @$absensi['absensi_supir_detail'][$tradoIndex]['supir']['id'] ? 'selected' : '' }}>{{ $supir['namasupir'] }}</option>
                            @endforeach
                          </select>
                        </td>
                        <td>
                          <input type="number" name="uangjalan[]" value="{{ $absensi['absensi_supir_detail'][$tradoIndex]['uangjalan'] ?? '' }}">
                        </td>
                        <td>
                          <select name="absen_id[]">
                            @foreach($combo['status'] as $status)
                            <option value="{{ $status['id'] }}" {{ $status['id'] == @$absensi['absensi_supir_detail'][$tradoIndex]['absen_trado']['id'] ? 'selected' : '' }}>{{ $status['kodeabsen'] }}</option>
                            @endforeach
                          </select>
                        </td>
                        <td>
                          <input type="text" name="jam[]" value="{{ $absensi['jam'] ?? '' }}">
                        </td>
                        <td>
                          <input type="text" name="keterangan_detail[]" value="{{ $absensi['absensi_supir_detail'][$tradoIndex]['trado']['keterangan'] ?? '' }}">
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
            <a href="{{ route('absensi.index') }}" class="btn btn-danger">
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
  let indexUrl = "{{ route('absensi.index') }}"
  let action = "{{ $action }}"
  let actionUrl = "{{ route('absensi.store') }}"
  let method = "POST"
  let csrfToken = "{{ csrf_token() }}"

  /* Set action url */
  <?php if ($action == 'edit') : ?>
    actionUrl = "{{ route('absensi.update', $absensi['id']) }}"
    method = "PATCH"
  <?php elseif ($action == 'delete') : ?>
    actionUrl = "{{ route('absensi.destroy', $absensi['id']) }}"
    method = "DELETE"
  <?php endif; ?>

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
          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()

          if (response.status) {
            alert(response.message)

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
          alert(`${error.statusText} | ${error.responseText}`)
        }
      }).always(() => {
        $(this).removeAttr('disabled')
      })
    })
  })
</script>
@endpush()