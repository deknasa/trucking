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
            <input type="hidden" name="kasgantung_nobukti" value="{{ $kasgantung['nobukti'] ?? $kasGantungNoBukti }}">

            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>NO BUKTI</label>
              </div>
              <div class="col-12 col-md-4">
                <input type="text" name="nobukti" class="form-control" value="{{ $kasgantung['nobukti'] ?? $noBukti }}" readonly>
              </div>
              <div class="col-12 col-md-2 col-form-label">
                <label>TANGGAL</label>
              </div>
              <div class="col-12 col-md-4">
                @php
                  if (isset($kasgantung['tgl'])) {
                    $tgl = date('d-m-Y',strtotime($kasgantung['tgl']));
                  } else {
                    $tgl = date('d-m-Y');
                  }
                @endphp
                <input type="text" name="tgl" class="form-control datepicker" value="{{ $tgl }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  PENERIMA <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="penerima_id" class="form-control select2bs4">
                        <option value="">PILIH PENERIMA</option>
                        <?php foreach ($combo['penerima'] as $key => $item) { 
                            $selected = @$kasgantung['penerima_id'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['namapenerima'] }}</option>
                        <?php } ?>
                </select>
              </div>
            </div>
            
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>KETERANGAN</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="keterangan" class="form-control" value="{{ $kasgantung['keterangan'] ?? '' }}">
              </div>
            </div>

            <div class="border p-3">
                <h6>Posting Pengeluaran</h6>

                <div class="row form-group">
                  <div class="col-12 col-md-2 col-form-label">
                    <label>
                      POST <span class="text-danger">*</span></label>
                  </div>
                  <div class="col-12 col-md-4">
                    <select name="bank_id" id="bank_id" class="form-control select2bs4" {{ @$kasgantung ? 'readonly' : '' }}>
                            <option value="">PILIH BANK</option>
                            <?php foreach ($combo['bank'] as $key => $item) { 
                                $selected = @$kasgantung['bank_id'] == $item['id'] ? "selected" : ""
                            ?>
                                <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['namabank'] }}</option>
                            <?php } ?>
                    </select>
                  </div>
                  <div class="col-12 col-md-2 col-form-label">
                    <label>TANGGAL POST</label>
                  </div>
                  <div class="col-12 col-md-4">
                    @php
                      if (isset($kasgantung['tglkaskeluar'])) {
                        $tglkaskeluar = date('d-m-Y',strtotime($kasgantung['tglkaskeluar']));
                      } else {
                        $tglkaskeluar = date('d-m-Y');
                      }
                    @endphp

                    <input type="text" name="tglkaskeluar" class="form-control datepicker" value="{{ $tglkaskeluar }}">
                  </div>
                </div>

                <div class="row form-group">
                  <div class="col-12 col-md-2 col-form-label">
                    <label>
                      NO BUKTI KAS KELUAR <span class="text-danger">*</span></label>
                  </div>
                  <div class="col-12 col-md-4">
                    <input type="text" name="nobuktikaskeluar" id="nobuktikaskeluar" class="form-control" value="{{ $kasgantung['nobuktikaskeluar'] ?? '' }}" readonly>
                  </div>
                </div>
            </div>

            <button type="button" class="btn btn-primary my-2" id="addrow">Tambah</button>

            <div class="row">
              <div class="col-md-12">
                <div class="table-responsive">
                  <table class="table table-bordered">
                    <thead>
                      <tr>
                        <th>Nominal</th>
                        <th>Keterangan</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody id="table_body" class="form-group">
                      @if (isset($kasgantung['kasgantung_detail']))
                      @foreach($kasgantung['kasgantung_detail'] as $kasgantungIndex => $d)
                      <tr id="row">
                        <td>
                          <input type="text" name="nominal[]" class="form-control text-right" value="{{ number_format($d['nominal'],0) ?? '' }}" oninput="separatorNumber(this)">
                        </td>
                        <td>
                          <input type="text" name="keterangan_detail[]" class="form-control" value="{{ $d['keterangan'] ?? '' }}">
                        </td>
                        <td>
                          @if($kasgantungIndex > 0)
                            <div class='btn btn-danger btn-sm rmv' >Hapus</div>
                          @endif
                        </td>
                      </tr>
                      @endforeach
                      @else
                      <tr id="row">
                        <td>
                          <input type="text" name="nominal[]" class="form-control text-right" oninput="separatorNumber(this)">
                        </td>
                        <td>
                          <input type="text" name="keterangan_detail[]" class="form-control">
                        </td>
                        <td>
                          
                        </td>
                      </tr>
                      @endif
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
            <a href="{{ route('kasgantung.index') }}" class="btn btn-danger">
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
    var value = parseInt(object.value.replaceAll('.','').replaceAll(',',''));

    if ($.isNumeric(value)) {
      object.value = value.toLocaleString();
    } else {
      object.value = '';
    }
    
    return true;
  }

  $("#addrow").click(function () {
    let clone = $('#row').clone();
    clone.find(':last-child').append("<div class='btn btn-danger btn-sm rmv' >Hapus</div>")
    clone.find('input').val('');

    $('table #table_body').append(clone);
  });

  $('table').on('click', '.rmv', function () {
    $(this).closest('tr').remove();
  });

  $('#bank_id').change(function() {
    let value = $(this).val();
    console.log(postingUrl);
    if (value!='') {
      $.get(postingUrl, { group: "NOBUKTI", subgroup: "KASKELUAR", table: "jurnalumumheader" }, function(res){ 
        $('#nobuktikaskeluar').val(res.data);
      })
      .fail(function() {

      })
    } else {
      $('#nobuktikaskeluar').val('');
    }
  });

  let indexUrl = "{{ route('kasgantung.index') }}"
  let action = "{{ $action }}"
  let actionUrl = "{{ route('kasgantung.store') }}"
  let method = "POST"
  let csrfToken = "{{ csrf_token() }}"
  let postingUrl = "{{ Config::get('app.api_url').'running_number' }}"

  /* Set action url */
  <?php if ($action == 'edit') : ?>
    actionUrl = "{{ route('kasgantung.update', $kasgantung['id']) }}"
    method = "PATCH"
  <?php elseif ($action == 'delete') : ?>
    actionUrl = "{{ route('kasgantung.destroy', $kasgantung['id']) }}"
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
  })
</script>
@endpush()