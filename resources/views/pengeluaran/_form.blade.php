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
                <input type="text" name="nobukti" class="form-control" value="{{ $pengeluaran['nobukti'] ?? '-' }}" readonly>
              </div>
              <div class="col-12 col-md-2 col-form-label">
                <label>TANGGAL BUKTI</label>
              </div>
              <div class="col-12 col-md-4">
                @php
                if (isset($pengeluaran['tglbukti'])) {
                $tglbukti = date('d-m-Y',strtotime($pengeluaran['tglbukti']));
                } else {
                $tglbukti = date('d-m-Y');
                }
                @endphp
                <input type="text" name="tglbukti" class="form-control datepicker" value="{{ $tglbukti }}">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>Pelanggan</label>
              </div>
              <div class="col-12 col-md-10">
                <select name="pelanggan_id" class="form-control select2bs4">
                  <option value="">PILIH PELANGGAN</option>
                  <?php foreach ($combo['pelanggan'] as $key => $item) {
                    $selected = @$pengeluaran['pelanggan_id'] == $item['id'] ? "selected" : ""
                  ?>
                    <option value="{{ $item['id'] }}" {{ $selected }}>{{ $item['namapelanggan'] }}</option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>KETERANGAN</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="keterangan" class="form-control" value="{{ $pengeluaran['keterangan'] ?? '' }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>STATUS JENIS TRANSAKSI</label>
              </div>
              <div class="col-12 col-md-10">
                <select name="statusjenistransaksi" class="form-control select2bs4">
                  <option value="">STATUS JENIS TRANSAKSI</option>
                  <?php foreach ($combo['statusjenistransaksi'] as $key => $item) {
                    $selected = @$pengeluaran['id'] == $item['id'] ? "selected" : ""
                  ?>
                    <option value="{{ $item['id'] }}" {{ $selected }}>{{ $item['grp'] }}</option>
                  <?php } ?>
                </select>
              </div>
            </div>
            <!-- <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>STATUS JENIS TRANSAKSI</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="number" name="statusjenistransaksi" class="form-control" value="{{ $pengeluaran['statusjenistransaksi'] ?? '' }}">
              </div>
            </div> -->

            <!-- <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>POSTING DARI</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="postingdari" class="form-control" value="{{ $pengeluaran['postingdari'] ?? '' }}">
              </div>
            </div> -->

            <!-- <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>STATUS APPROVAL</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="statusapproval" class="form-control" value="{{ $pengeluaran['statusapproval'] ?? 0 }}">
              </div>
            </div> -->

            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>DIBAYAR KE</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="dibayarke" class="form-control" value="{{ $pengeluaran['dibayarke'] ?? '' }}">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>CABANG</label>
              </div>
              <div class="col-12 col-md-10">
                <select name="cabang_id" class="form-control select2bs4">
                  <option value="">CABANG</option>
                  <?php foreach ($combo['cabang'] as $key => $item) {
                    $selected = @$pengeluaran['cabang_id'] == $item['id'] ? "selected" : ""
                  ?>
                    <option value="{{ $item['id'] }}" {{ $selected }}>{{ $item['namacabang'] }}</option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>BANK</label>
              </div>
              <div class="col-12 col-md-10">
                <select name="bank_id" class="form-control select2bs4">
                  <option value="">BANK</option>
                  <?php foreach ($combo['bank'] as $key => $item) {
                    $selected = @$pengeluaran['bank_id'] == $item['id'] ? "selected" : ""
                  ?>
                    <option value="{{ $item['id'] }}" {{ $selected }}>{{ $item['namabank'] }}</option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>TRANSFER KE ACC</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="transferkeac" class="form-control" value="{{ $pengeluaran['transferkeac'] ?? '' }}">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>TRANSFER KE AN</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="transferkean" class="form-control" value="{{ $pengeluaran['transferkean'] ?? '' }}">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>TRANSFER KE BANK</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="transferkebank" class="form-control" value="{{ $pengeluaran['transferkebank'] ?? '' }}">
              </div>
            </div>

            <div class="row">
              <div class="col-13">
                <div class="table-responsive">
                  <table class="table table-bordered table-bindkeys">
                    <thead>
                      <tr>
                        <th width="50">No</th>
                        <th>Alat Bayar</th>
                        <th>No warkat</th>
                        <th>Tgl jatuh tempo</th>
                        <th>Nominal</th>
                        <!-- <th>Coa Debet</th>
                        <th>Coa Kredit</th>  -->
                        <th>Keterangan</th>
                        <th>Bulan beban</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody id="table_body" class="form-group">
                      @if (isset($pengeluaran['pengeluarandetail']))
                      @foreach($pengeluaran['pengeluarandetail'] as $pengeluaranIndex => $d)
                      <tr id="row">
                        <td>
                          <div class="baris">{{ $pengeluaranIndex+1 }}</div>
                        </td>

                        <td>
                          <select name="alatbayar_id[]" class="form-control select2bs4">
                            <option value="">ALAT BAYAR</option>
                            <?php foreach ($combo['alatbayar'] as $key => $item) {
                              $selected = @$d['alatbayar_id'] == $item['id'] ? "selected" : ""
                            ?>
                              <option value="{{ $item['id'] }}" {{ $selected }}>{{ $item['namaalatbayar'] }}</option>
                            <?php } ?>
                          </select>
                        </td>

                        <td>
                          <input type="text" name="nowarkat[]" class="form-control" value="{{ $d['nowarkat'] ?? '' }}">
                        </td>

                        <td>
                          @php
                          if (isset($d['tgljatuhtempo'])) {
                          $tgljatuhtempo = date('d-m-Y',strtotime($d['tgljatuhtempo']));
                          } else {
                          $tgljatuhtempo = date('d-m-Y');
                          }
                          @endphp
                          <input type="date" name="tgljatuhtempo[]" class="form-control" value="{{ $d['tgljatuhtempo'] }}">
                        </td>

                        <td>
                          <input type="text" name="nominal[]" class="form-control text-right" value="{{ number_format($d['nominal'],0,'.','.') ?? '' }}" oninput="separatorNumber(this)">
                        </td>
<!-- 
                        <td>
                          <select name="coa_id[]" class="form-control select2bs4">
                            <option value="">COA DEBET</option>
                            <?php foreach ($combo['akunpusat'] as $key => $item) {
                              $selected = @$d['coa_id'] == $item['id'] ? "selected" : ""
                            ?>
                              <option value="{{ $item['id'] }}" {{ $selected }}>{{ $item['keterangancoa'] }}</option>
                            <?php } ?>
                          </select>
                        </td>

                        <td>
                          <select name="coa_id[]" class="form-control select2bs4">
                            <option value="">COA KREDIT</option>
                            <?php foreach ($combo['akunpusat'] as $key => $item) {
                              $selected = @$d['coa_id'] == $item['id'] ? "selected" : ""
                            ?>
                              <option value="{{ $item['id'] }}" {{ $selected }}>{{ $item['keterangancoa'] }}</option>
                            <?php } ?>
                          </select>
                        </td> -->

                        <td>
                          <input type="text" name="keterangan_detail[]" class="form-control" value="{{ $d['keterangan'] ?? '' }}">
                        </td>

                        <td>
                          @php
                          if (isset($d['bulanbeban'])) {
                          $bulanbeban = date('d-m-Y',strtotime($d['bulanbeban']));
                          } else {
                          $bulanbeban = date('d-m-Y');
                          }
                          @endphp
                          <input type="date" name="bulanbeban[]" class="form-control" value="{{ $d['bulanbeban'] }}">
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
                          <select name="alatbayar_id[]" class="form-control select2bs4">
                            <option value="">ALAT BAYAR</option>
                            <?php foreach ($combo['alatbayar'] as $key => $item) {
                            ?>
                              <option value="{{ $item['id'] }}">{{ $item['namaalatbayar'] }}</option>
                            <?php } ?>
                          </select>
                        </td>

                        <td>
                          <input type="text" name="nowarkat[]" class="form-control">
                        </td>
                        <td>
                          <input type="date" name="tgljatuhtempo[]" class="form-control">
                        </td>
                        <td>
                          <input type="text" name="nominal[]" class="form-control text-right" oninput="separatorNumber(this)">
                        </td>
                        <!-- <td>
                          <select name="coa_id[]" class="form-control select2bs4">
                            <option value="">COA DEBET</option>
                            <?php foreach ($combo['akunpusat'] as $key => $item) {
                            ?>
                              <option value="{{ $item['id'] }}">{{ $item['keterangancoa'] }}</option>
                            <?php } ?>
                          </select>
                        </td>

                        <td>
                          <select name="coa_id[]" class="form-control select2bs4">
                            <option value="">COA KREDIT</option>
                            <?php foreach ($combo['akunpusat'] as $key => $item) {
                            ?>
                              <option value="{{ $item['id'] }}">{{ $item['keterangancoa'] }}</option>
                            <?php } ?>
                          </select>
                        </td> -->
                        <td>
                          <input type="text" name="keterangan_detail[]" class="form-control">
                        </td>

                        <td>
                          <input type="date" name="bulanbeban[]" class="form-control">
                        </td>
                        <td>
                          <div class='btn btn-danger btn-sm rmv'>Hapus</div>
                        </td>
                      </tr>
                      @endif
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="7"></td>
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
            <a href="{{ route('pengeluaran.index') }}" class="btn btn-danger">
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
  // function separatorNumber(object) {
  //   var value = parseInt(object.value.replaceAll('.', '').replaceAll(',', ''));

  //   if ($.isNumeric(value)) {
  //     object.value = value.toLocaleString();
  //   } else {
  //     object.value = '';
  //   }

  //   return true;
  // }

  var baris = 1;
  @if(isset($pengeluaran['pengeluarandetail']))
  baris = "{{count($pengeluaran['pengeluarandetail'])}}";
  @endif;

  //ambil data untuk select option


  let comboAlatBayar = `<?= json_encode($combo['alatbayar']) ?>`;
  comboAlatBayar = JSON.parse(comboAlatBayar);
  let htmlComboAlatBayar = '';
  $.each(comboAlatBayar, function(index, value) {
    htmlComboAlatBayar += `<option value='${value.id}'>${value.namaalatbayar}</option>`;
  });

  let comboCoaDebet = `<?= json_encode($combo['akunpusat']) ?>`;
  comboCoaDebet = JSON.parse(comboCoaDebet);
  let htmlComboCoaDebet = '';
  $.each(comboCoaDebet, function(index, value) {
    htmlComboCoaDebet += `<option value='${value.id}'>${value.keterangancoa}</option>`;
  });

  let comboCoaKredit = `<?= json_encode($combo['akunpusat']) ?>`;
  comboCoaKredit = JSON.parse(comboCoaKredit);
  let htmlComboCoaKredit = '';
  $.each(comboCoaKredit, function(index, value) {
    htmlComboCoaKredit += `<option value='${value.id}'>${value.keterangancoa}</option>`;
  });

  let html = `<tr id="row">
      <td>
        <div class="baris">1</div>
      </td>

      <td>
        <select name="alatbayar_id[]" class="form-control select2bs4">
          <option value="">ALAT BAYAR</option>
          ${htmlComboAlatBayar}
        </select>
      </td>

      <td>
        <input type="text" name="nowarkat[]" class="form-control">
      </td>

      <td>
        <input type="date" name="tgljatuhtempo[]" class="form-control">
      </td>

      <td>
        <input type="text" name="nominal[]" class="form-control text-right"  oninput="separatorNumber(this)">
      </td>

   

      <td>
        <input type="text" name="keterangan_detail[]" class="form-control">
      </td>

      <td>
        <input type="date" name="bulanbeban[]" class="form-control">
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

    // resetFormatDate();
  });

  $('table').on('click', '.rmv', function() {
    $(this).closest('tr').remove();

    $('.baris').each(function(i, obj) {
      $(obj).text(i + 1);
    });
    baris = baris - 1;
  });

  let indexUrl = "{{ route('pengeluaran.index') }}"
  let action = "{{ $action }}"
  let actionUrl = "{{ config('app.api_url') . 'pengeluaran' }}"
  let method = "POST"
  let csrfToken = "{{ csrf_token() }}"
  let postingUrl = "{{ Config::get('app.api_url').'running_number' }}"

  /* Set action url */
  <?php if ($action !== 'add') : ?>
    actionUrl += `/{{ $pengeluaran['id'] }}`
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