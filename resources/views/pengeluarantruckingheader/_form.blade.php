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
            <input type="hidden" name="limit" value="{{ $_GET['limit'] ?? 10 }}">
            <input type="hidden" name="sortname" value="{{ $_GET['sidx'] ?? 'id' }}">
            <input type="hidden" name="sortorder" value="{{ $_GET['sord'] ?? 'asc' }}">
            <input type="hidden" name="indexRow" value="{{ $_GET['indexRow'] ?? 1 }}">
            <input type="hidden" name="page" value="{{ $_GET['page'] ?? 1 }}">

            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>NO BUKTI</label>
              </div>
              <div class="col-12 col-md-4">
                <input type="text" name="nobukti" class="form-control" value="{{ $pengeluarantruckingheader['nobukti'] ?? '-' }}" readonly>
              </div>
              <div class="col-12 col-md-2 col-form-label">
                <label>TANGGAL BUKTI</label>
              </div>
              <div class="col-12 col-md-4">
                @php
                if (isset($pengeluarantruckingheader['tglbukti'])) {
                $tglbukti = date('d-m-Y',strtotime($pengeluarantruckingheader['tglbukti']));
                } else {
                $tglbukti = date('d-m-Y');
                }
                @endphp
                <input type="text" name="tglbukti" class="form-control datepicker" value="{{ $tglbukti }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>KETERANGAN</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="keterangan" class="form-control" value="{{ $pengeluarantruckingheader['keterangan'] ?? '' }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>PENGELUARAN TRUCKING</label>
              </div>
              <div class="col-12 col-md-10">
                <select name="pengeluarantrucking_id" style="width:100%" class="form-control select2bs4">
                    <option value="" >PENGELUARAN TRUCKING</option>
                    <?php foreach ($combo['pengeluarantrucking'] as $key => $item) {
                        $selected = @$pengeluarantruckingheader['pengeluarantrucking_id'] == $item['id'] ? "selected" : ""
                    ?>
                        <option value="{{ $item['id'] }}" {{ $selected }}>{{ $item['formatbukti'] }}</option>
                    <?php } ?>
                </select>  
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>BANK</label>
              </div>
              <div class="col-12 col-md-10">
                <select name="bank_id" style="width:100%" class="form-control select2bs4">
                    <option value="" >BANK</option>
                    <?php foreach ($combo['bank'] as $key => $item) {
                        $selected = @$pengeluarantruckingheader['bank_id'] == $item['id'] ? "selected" : ""
                    ?>
                        <option value="{{ $item['id'] }}" {{ $selected }}>{{ $item['namabank'] }}</option>
                    <?php } ?>
                </select>  
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>COA</label>
              </div>
              <div class="col-12 col-md-10">
                <select name="coa" style="width:100%" class="form-control select2bs4">
                    <option value="" >COA</option>
                    <?php foreach ($combo['coa'] as $key => $item) {
                        $selected = @$pengeluarantruckingheader['coa'] == $item['coa'] ? "selected" : ""
                    ?>
                        <option value="{{ $item['coa'] }}" {{ $selected }}>{{ $item['coa'] }}</option>
                    <?php } ?>
                </select> 
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>NO BUKTI PENGELUARAN</label>
              </div>
              <div class="col-12 col-md-10">
                <select name="pengeluaran_nobukti" style="width:100%" class="form-control select2bs4">
                    <option value="" >NO BUKTI PENGELUARAN</option>
                    <?php foreach ($combo['pengeluaranheader'] as $key => $item) {
                        $selected = @$pengeluarantruckingheader['pengeluaran_nobukti'] == $item['nobukti'] ? "selected" : ""
                    ?>
                        <option value="{{ $item['nobukti'] }}" {{ $selected }}>{{ $item['nobukti'] }}</option>
                    <?php } ?>
                </select> 
              </div>
            </div>


            <div class="row">
              <div class="col-12">
                <div class="table-responsive">
                  <table class="table table-bordered table-bindkeys">
                    <thead>
                      <tr>
                        <th width="50">No</th>
                        <th>Supir</th>
                        <th>No Bukti Penerimaan Trucking</th>
                        <th>Nominal</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody id="table_body" class="form-group">
                      @if (isset($pengeluarantruckingheader['pengeluarantruckingdetail']))
                      @foreach($pengeluarantruckingheader['pengeluarantruckingdetail'] as $pengeluarantruckingIndex => $d)
                      <tr id="row">
                        <td>
                          <div class="baris">{{ $pengeluarantruckingIndex+1 }}</div>
                        </td>
                        <td>
                          <select name="supir_id[]" style="width:100%" class="form-control select2bs4">
                            <option value="" >SUPIR</option>
                            <?php foreach ($combo['supir'] as $key => $item) {
                              $selected = @$d['supir_id'] == $item['id'] ? "selected" : ""
                            ?>
                              <option value="{{ $item['id'] }}" {{ $selected }}>{{ $item['namasupir'] }}</option>
                            <?php } ?>
                          </select>
                        </td>
                        <td>
                          <select name="penerimaantruckingheader_nobukti[]" style="width:100%" class="form-control select2bs4">
                            <option value="" >NO BUKTI PENERIMAAN TRUCKING</option>
                            <?php foreach ($combo['penerimaantruckingheader'] as $key => $item) {
                              $selected = @$d['penerimaantruckingheader_nobukti'] == $item['nobukti'] ? "selected" : ""
                            ?>
                            <option value="{{ $item['nobukti'] }}" {{ $selected }}>{{ $item['nobukti'] }}</option>
                            <?php } ?>
                          </select>
                        </td>
                        <td>
                            <input type="text" name="nominal[]"  style="text-align:right" class="form-control text-right autonumeric" value="{{ number_format($d['nominal']??0,0,',' , ',') }}"> 
                        </td>
                        <td>
                          <div class='btn btn-danger btn-sm rmv'>Hapus</div>
                        </td>
                      </tr>
                      @endforeach
                      @else
                      <tr id="row">
                        <td>
                          <div class="baris">1</div>
                        </td>
                        <td>
                          <select name="supir_id[]" style="width:100%" class="form-control select2bs4">
                            <option value="">SUPIR</option>
                            <?php foreach ($combo['supir'] as $key => $item) { ?>
                              <option value="{{ $item['id'] }}">{{ $item['namasupir'] }}</option>
                            <?php } ?>
                          </select>   
                        </td>
                        <td>
                          <select name="penerimaantruckingheader_nobukti[]" style="width:100%" class="form-control select2bs4">
                            <option value="" >NO BUKTI PENERIMAAN TRUCKING</option>
                            <?php foreach ($combo['penerimaantruckingheader'] as $key => $item) { ?>
                              <option value="{{ $item['nobukti'] }}">{{ $item['nobukti'] }}</option>
                            <?php } ?>
                          </select>
                        </td>
                        <td>
                            <input type="text" name="nominal[]" style="text-align:right" class="form-control autonumeric">   
                        </td>
                        <td>
                          <div class='btn btn-danger btn-sm rmv'>Hapus</div>
                        </td>
                      </tr>
                      @endif
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="4"></td>
                        <td>
                          <button type="button" class="btn btn-primary btn-sm my-2" id="addrow">Tambah</button>
                        </td>
                      </tr>
                    </tfoot>
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
            <a href="{{ route('pengeluarantruckingheader.index') }}" class="btn btn-danger">
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
  @if(isset($pengeluarantruckingheader['pengeluarantruckingdetail']))
  baris = "{{count($pengeluarantruckingheader['pengeluarantruckingdetail'])}}";
  @endif;

  //ambil data untuk select option
  let comboSupir = `<?= json_encode($combo['supir']) ?>`;
  comboSupir = JSON.parse(comboSupir);
  let htmlComboSupir = '';
  $.each(comboSupir, function(index, value) {
    htmlComboSupir += `<option value='${value.id}'>${value.namasupir}</option>`;
  });
  
  //ambil data untuk select option
  let comboPenerimaan = `<?= json_encode($combo['penerimaantruckingheader']) ?>`;
  comboPenerimaan = JSON.parse(comboPenerimaan);
  let htmlComboPenerimaan = '';
  $.each(comboPenerimaan, function(index, value) {
    htmlComboPenerimaan += `<option value='${value.nobukti}'>${value.nobukti}</option>`;
  });

  let html = `<tr id="row">
        <td>
        <div class="baris">1</div>
      </td>
      <td>
        <select name="supir_id[]" style="width:100%" class="form-control select2bs4">
          <option value="">SUPIR</option>
          ${htmlComboSupir}
        </select>
      </td>
      <td>
        <select name="penerimaantruckingheader_nobukti[]" style="width:100%" class="form-control select2bs4">
          <option value="" >NO BUKTI PENERIMAAN TRUCKING</option>
          ${htmlComboPenerimaan}
        </select>
      </td>
      <td>
        <input type="text" name="nominal[]" style="text-align:right" class="form-control autonumeric">   
      </td>
      <td>
        <div class='btn btn-danger btn-sm rmv'>Hapus</div>
      </td>
    </tr>`;

    $("#addrow").click(function() {
    let rowCount = $('#row').length;
    if (rowCount > 0) {
      let clone = $('#row').clone();
      clone.find("span").remove();
      clone.find("select").select2({
        theme: 'bootstrap4'
      });
      clone.find("select").val('').change();
      clone.find('input').val('');

      baris = parseInt(baris) + 1;
      clone.find('.baris').text(baris);
      $('table #table_body').append(clone);

      $('#row').find('select').select2({
        theme: 'bootstrap4'
      });
    } else {
      baris = 1;
      $('#table_body').append(html);
    }

  });

  $('table').on('click', '.rmv', function() {
    $(this).closest('tr').remove();

    $('.baris').each(function(i, obj) {
      $(obj).text(i + 1);
    });
    baris = baris - 1;
  });

  let indexUrl = "{{ route('pengeluarantruckingheader.index') }}"
  let action = "{{ $action }}"
  let actionUrl = "{{ config('app.api_url') . 'pengeluarantruckingheader' }}"
  let method = "POST"
  let csrfToken = "{{ csrf_token() }}"
  let postingUrl = "{{ Config::get('app.api_url').'running_number' }}"

  /* Set action url */
 <?php if ($action !== 'add') : ?>
    actionUrl += `/{{ $pengeluarantruckingheader['id'] }}`
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
        data: $('form').serializeArray(),
        headers: {
          'Authorization': `Bearer {{ session('access_token') }}`
        },
        success: response => {
          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()

          if (response.status) {
            if (action != 'delete') {
              window.location.href = `${indexUrl}?page=${response.data.page ?? 1}&id=${response.data.id ?? 1}&sortname={{ $_GET['sortname'] ?? '' }}&sortorder={{ $_GET['sortorder'] }}&limit={{ $_GET['limit'] }}`
            } else {
              console.log('disini');
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