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


              <div class="row form-group">
                <div class="col-12 col-md-2 col-form-label">
                  <label>
                    DARI <span class="text-danger">*</span></label>
                </div>
                <div class="col-12 col-md-10">
                  <select name="kotadari_id" class="form-control select2bs4">
                    <option value="">PILIH DARI</option>
                    <?php foreach ($combo['kota'] as $key => $item) {
                      $selected = @$upahritasi['kotadari_id'] == $item['id'] ? "selected" : ""
                    ?>
                      <option value="{{ $item['id'] }}" {{ $selected }}>{{ $item['keterangan'] }}</option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-12 col-md-2 col-form-label">
                  <label>
                    TUJUAN <span class="text-danger">*</span></label>
                </div>
                <div class="col-12 col-md-10">
                  <select name="kotasampai_id" class="form-control select2bs4">
                    <option value="">PILIH TUJUAN</option>
                    <?php foreach ($combo['kota'] as $key => $item) {
                      $selected = @$upahritasi['kotasampai_id'] == $item['id'] ? "selected" : ""
                    ?>
                      <option value="{{ $item['id'] }}" {{ $selected }}>{{ $item['keterangan'] }}</option>
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
                      $selected = @$upahritasi['zona_id'] == $item['id'] ? "selected" : ""
                    ?>
                      <option value="{{ $item['id'] }}" {{ $selected }}>{{ $item['keterangan'] }}</option>
                    <?php } ?>
                  </select>
                </div>
              </div>

            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>JARAK</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="jarak" class="form-control numbernoseparate" value="{{ $upahritasi['jarak'] ?? '' }}">
              </div>
            </div>

            <div class="row form-group">
                <div class="col-12 col-md-2 col-form-label">
                  <label>
                    STATUS AKTIF <span class="text-danger">*</span></label>
                </div>
                <div class="col-12 col-md-10">
                  <select name="statusaktif" class="form-control select2bs4">
                    <option value="">PILIH STATUS AKTIF</option>
                    <?php foreach ($combo['statusaktif'] as $key => $item) {
                      $selected = @$upahritasi['statusaktif'] == $item['id'] ? "selected" : ""
                    ?>
                      <option value="{{ $item['id'] }}" {{ $selected }}>{{ $item['text'] }}</option>
                    <?php } ?>
                  </select>
                </div>
              </div>

              <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>TGL MULAI BERLAKU</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="tglmulaiberlaku" class="form-control formatdate" value="{{ $upahritasi['tglmulaiberlaku'] ?? '' }}">
              </div>
            </div>

            <div class="row form-group">
                <div class="col-12 col-md-2 col-form-label">
                  <label>
                    STATUS LUAR KOTA <span class="text-danger">*</span></label>
                </div>
                <div class="col-12 col-md-10">
                  <select name="statusluarkota" class="form-control select2bs4">
                    <option value="">PILIH STATUS LUAR KOTA</option>
                    <?php foreach ($combo['statusluarkota'] as $key => $item) {
                      $selected = @$upahritasi['statusluarkota'] == $item['id'] ? "selected" : ""
                    ?>
                      <option value="{{ $item['id'] }}" {{ $selected }}>{{ $item['text'] }}</option>
                    <?php } ?>
                  </select>
                </div>
              </div>


            <button type="button" class="btn btn-primary my-2" id="addrow">Tambah</button>

            <div class="row">
              <div class="col-12">
                <div class="table-responsive">
                  <table class="table table-bordered table-bindkeys">
                    <thead>
                      <tr>
                        <th width="50">No</th>
                        <th>Container</th>
                        <th>Status Container</th>
                        <th>Nominal Supir</th>
                        <th>Nominal Kenek</th>
                        <th>Nominal Komisi</th>
                        <th>Nominal Tol</th>
                        <th>Liter</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody id="table_body" class="form-group">
                      @if (isset($upahritasi['upahritasi_rincian']))
                      @foreach($upahritasi['upahritasi_rincian'] as $upahritasiIndex => $d)
                      <tr id="row">
                        <td>
                          <div class="baris">{{ $upahritasiIndex+1 }}</div>
                        </td>
                        <td>
                          <select name="container_id[]" class="form-control select2bs4">
                            <option value="">PILIH CONTAINER</option>
                            <?php foreach ($combo['container'] as $key => $item) {
                              $selected = @$d['container_id'] == $item['id'] ? "selected" : ""
                            ?>
                              <option value="{{ $item['id'] }}" {{ $selected }}>{{ $item['keterangan'] }}</option>
                            <?php } ?>
                          </select>
                        </td>
                        <td>
                          <select name="statuscontainer_id[]" class="form-control select2bs4">
                            <option value="">PILIH STATUS CONTAINER</option>
                            <?php foreach ($combo['statuscontainer'] as $key => $item) {
                              $selected = @$d['statuscontainer_id'] == $item['id'] ? "selected" : ""
                            ?>
                              <option value="{{ $item['id'] }}" {{ $selected }}>{{ $item['keterangan'] }}</option>
                            <?php } ?>
                          </select>
                        </td>
                        <td>
                          <input type="text" name="nominalsupir[]" class="form-control text-right" value="{{ number_format($d['nominalsupir'],0,'.','.') ?? '' }}" oninput="separatorNumber(this)">
                        </td>
                        <td>
                          <input type="text" name="nominalkenek[]" class="form-control text-right" value="{{ number_format($d['nominalkenek'],0,'.','.') ?? '' }}" oninput="separatorNumber(this)">
                        </td>
                        <td>
                          <input type="text" name="nominalkomisi[]" class="form-control text-right" value="{{ number_format($d['nominalkomisi'],0,'.','.') ?? '' }}" oninput="separatorNumber(this)">
                        </td>
                        <td>
                          <input type="text" name="nominaltol[]" class="form-control text-right" value="{{ number_format($d['nominaltol'],0,'.','.') ?? '' }}" oninput="separatorNumber(this)">
                        </td>
                        <td>
                          <input type="text" name="liter[]" class="form-control text-right" value="{{ number_format($d['liter'],0,'.','.') ?? '' }}" oninput="separatorNumber(this)">
                        </td>
                        <td>
                          @if($upahritasiIndex > 0)
                          <div class='btn btn-danger btn-sm rmv'>Hapus</div>
                          @endif
                        </td>
                      </tr>
                      @endforeach
                      @else
                      <tr id="row">
                        <td>
                          <div class="baris">1</div>
                        </td>
                        <td>
                          <select name="container_id[]" class="form-control select2bs4">
                            <option value="">PILIH CONTAINER</option>
                            <?php foreach ($combo['container'] as $key => $item) {?>
                              <option value="{{ $item['id'] }}">{{ $item['keterangan'] }}</option>
                            <?php } ?>
                          </select>
                        </td>
                        <td>
                          <select name="statuscontainer_id[]" class="form-control select2bs4">
                            <option value="">PILIH STATUS CONTAINER</option>
                            <?php foreach ($combo['statuscontainer'] as $key => $item) { ?>
                              <option value="{{ $item['id'] }}">{{ $item['keterangan'] }}</option>
                            <?php } ?>
                          </select>
                        </td>
                        <td>
                          <input type="text" name="nominalsupir[]" class="form-control text-right" oninput="separatorNumber(this)">
                        </td>
                        <td>
                          <input type="text" name="nominalkenek[]" class="form-control text-right" oninput="separatorNumber(this)">
                        </td>
                        <td>
                          <input type="text" name="nominalkomisi[]" class="form-control text-right" oninput="separatorNumber(this)">
                        </td>
                        <td>
                          <input type="text" name="nominaltol[]" class="form-control text-right" oninput="separatorNumber(this)">
                        </td>
                        <td>
                          <input type="text" name="liter[]" class="form-control text-right" oninput="separatorNumber(this)">
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
    <a href="{{ route('upahritasi.index') }}" class="btn btn-danger">
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

  var baris = 1;
  @if(isset($upahritasi['upahritasiRincian']))
  baris = "{{count($upahritasi['upahritasiRincian'])}}";
  @endif

  $("#addrow").click(function() {
    let clone = $('#row').clone();
    // console.log(clone.find(':last-child'));
    clone.find("span").remove();
    clone.find("select").select2({theme : 'bootstrap4'});
    clone.find("select").val('').change();
    clone.find('td').last().append("<div class='btn btn-danger btn-sm rmv' >Hapus</div>")
    clone.find('input').val('');

    baris = parseInt(baris) + 1;
    clone.find('.baris').text(baris);
    $('table #table_body').append(clone);

    $('#row').find('select').select2({theme : 'bootstrap4'});
  });

  $('table').on('click', '.rmv', function() {
    $(this).closest('tr').remove();

    $('.baris').each(function(i, obj) {
      $(obj).text(i + 1);
    });
    baris = baris - 1;
  });

  // $('#bank_id').change(function() {
  //   let value = $(this).val();
  //   console.log(postingUrl);
  //   if (value!='') {
  //     $.get(postingUrl, { group: "NOBUKTI", subgroup: "KASKELUAR", table: "jurnalumumheader" }, function(res){ 
  //       $('#nobuktikaskeluar').val(res.data);
  //     })
  //     .fail(function() {

  //     })
  //   } else {
  //     $('#nobuktikaskeluar').val('');
  //   }
  // });

  let indexUrl = "{{ route('upahritasi.index') }}"
  let action = "{{ $action }}"
  let actionUrl = "{{ route('upahritasi.store') }}"
  let method = "POST"
  let csrfToken = "{{ csrf_token() }}"
  let postingUrl = "{{ Config::get('app.api_url').'running_number' }}"

  /* Set action url */
  <?php if ($action == 'edit') : ?>
    actionUrl = "{{ route('upahritasi.update', $upahritasi['id']) }}"
    method = "PATCH"
  <?php elseif ($action == 'delete') : ?>
    actionUrl = "{{ route('upahritasi.destroy', $upahritasi['id']) }}"
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