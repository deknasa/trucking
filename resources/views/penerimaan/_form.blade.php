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
                <input type="text" name="nobukti" class="form-control" value="{{ $penerimaan['nobukti'] ?? '-' }}" readonly>
              </div>
              <div class="col-12 col-md-2 col-form-label">
                <label>TANGGAL BUKTI</label>
              </div>
              <div class="col-12 col-md-4">
                @php
                if (isset($penerimaan['tglbukti'])) {
                $tglbukti = date('d-m-Y',strtotime($penerimaan['tglbukti']));
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
                    $selected = @$penerimaan['pelanggan_id'] == $item['id'] ? "selected" : ""
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
                <input type="text" name="keterangan" class="form-control" value="{{ $penerimaan['keterangan'] ?? '' }}">
              </div>
            </div>

            <!-- <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>POSTING DARI</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="keterangan" class="form-control" value="{{ $penerimaan['postingdari'] ?? '' }}">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>DITERIMA DARI</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="keterangan" class="form-control" value="{{ $penerimaan['diterimadari'] ?? '' }}">
              </div>
            </div> -->
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>TANGGAL LUNAS</label>
              </div>
              <div class="col-12 col-md-4">
                @php
                if (isset($penerimaan['tgllunas'])) {
                $tgllunas = date('d-m-Y',strtotime($penerimaan['tgllunas']));
                } else {
                $tgllunas = date('d-m-Y');
                }
                @endphp
                <input type="text" name="tgllunas" class="form-control datepicker" value="{{ $tgllunas }}">
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
                    $selected = @$penerimaan['cabang_id'] == $item['id'] ? "selected" : ""
                  ?>
                    <option value="{{ $item['id'] }}" {{ $selected }}>{{ $item['namacabang'] }}</option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <script>
              // $('#statuskas').change(function() {
              //     console.log('here');
              //     //console.log($("#statuskas option:selected").val());
              //     var value = $(this).val();
              //     if (value == 'BUKAN KAS') {
              //       $('#bank').hide()
              //     } else {
              //       $('#bank').show()
              //     }
              //   })
  
            
            </script>

            <div id="statuskas" class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>STATUS KAS</label>
              </div>
              <div class="col-12 col-md-10">
                <select name="statuskas" class="form-control select2bs4">
                  <option id="statuskas" value="">STATUS KAS</option>
                  <?php foreach ($combo['statuskas'] as $key => $item) {
                    $selected = @$penerimaan['statuskas'] == $item['id'] ? "selected" : ""
                  ?>
                    <option value="{{ $item['id'] }}" {{ $selected }}>{{ $item['text'] }}</option>
                  <?php } ?>
                </select>
              </div>
            </div>

            <div class="row form-group" id="bank">
              <div class="col-12 col-md-2 col-form-label">
                <label id="bank">BANK</label>
              </div>
              <div class="col-12 col-md-10">
                <select name="bank_id" class="form-control select2bs4">
                  <option value="">PILIH BANK</option>
                  <?php foreach ($combo['bank'] as $key => $item) {
                    $selected = @$penerimaan['bank_id'] == $item['id'] ? "selected" : ""
                  ?>
                    <option value="{{ $item['id'] }}" {{ $selected }}>{{ $item['namabank'] }}</option>
                  <?php } ?>
                </select>
              </div>
            </div>


            <!-- <script>
              function tampil_bank(param) {
                if (param == 1)
                  document.getElementById("showbank").style.visibility = 'visible';
                else
                  document.getElementById("showbank").style.visibility = 'hidden';

              }
            </script> -->


            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>NO RESI</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="noresi" class="form-control" value="{{ $penerimaan['noresi'] ?? '' }}">
              </div>
            </div>
            <!-- 
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>STATUS BERKAS</label>
              </div>
              <div class="col-12 col-md-10">
                <select name="statusberkas" class="form-control select2bs4">
                  <option value="">STATUS BERKAS</option>
               
                  <?php foreach ($combo['statusberkas'] as $key => $item) {
                    $selected = @$penerimaan['statusberkas'] == $item['id'] ? "selected" : ""
                  ?>
                    <option value="{{ $item['id'] }}" {{ $selected }}>{{ $item['text'] }}</option>
                  <?php } ?>
                </select>
              </div>
            </div> -->

            <div class="row">
              <div class="col-12">
                <div class="table-responsive">
                  <table class="table table-bordered table-bindkeys">
                    <thead>
                      <tr>
                        <th width="50">No</th>
                        <th>No warkat</th>
                        <th>Tgl jatuh tempo</th>
                        <th>Nominal</th>
                        <th>Keterangan</th>
                        <th width="200">Coa Kredit</th>
                        <!-- <th>Coa Debet</th> -->
                        <!-- <th>Pelanggan</th> -->
                        <th width="200">Bank Pelanggan</th>
                        <th>Jenis Biaya</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody id="table_body" class="form-group">
                      @if (isset($penerimaan['penerimaandetail']))
                      @foreach($penerimaan['penerimaandetail'] as $penerimaanIndex => $d)
                      <tr id="row">
                        <td>
                          <div class="baris">{{ $penerimaanIndex+1 }}</div>
                        </td>
                        <td>
                          <input type="text" name="nowarkat[]" clas s="form-control" value="{{ $d['nowarkat'] ?? '' }}">
                        </td>
                        <td>
                          @php
                          if (isset($d['tgljatuhtempo'])) {
                          $tgljatuhtempo = date('d-m-Y',strtotime($d['tgljatuhtempo']));
                          } else {
                          $tgljatuhtempo = date('d-m-Y');
                          }
                          @endphp
                          <input type="date" name="tgljatuhtemp
                          o[]" class="form-control" value="{{ $d['tgljatuhtempo'] }}">
                        </td>
                        <td>
                          <input type="text" name="nominal[]" class="form-control text-right" value="{{ number_format($d['nominal'],0,'.','.') ?? '' }}" oninput="separatorNumber(this)">
                        </td>
                        <td>
                          <input type="text" name="keterangan_detail[]" class="form-control" value="{{ $d['keterangan'] ?? '' }}">
                        </td>


                        <td>
                          <select name="coakredit[]" class="form-control select2bs4">
                            <option value="">COA KREDIT</option>
                            <?php foreach ($combo['coa'] as $key => $item) {
                              $selected = @$d['coakredit'] == $item['id'] ? "selected" : ""
                            ?>
                              <option value="{{ $item['id'] }}" {{ $selected }}>{{ $item['keterangancoa'] }}</option>
                            <?php } ?>
                          </select>
                        </td>
                        <td>
                          <select name="bankpelanggan_id[]" class="form-control select2bs4">
                            <option value="">PELANGGAN</option>
                            <?php foreach ($combo['bankpelanggan'] as $key => $item) {
                              $selected = @$d['bankpelanggan_id'] == $item['id'] ? "selected" : ""
                            ?>
                              <option value="{{ $item['id'] }}" {{ $selected }}>{{ $item['namabank'] }}</option>
                            <?php } ?>
                          </select>
                        </td>

                        <td>
                          <input type="text" name="jenisbiaya[]" class="form-control" value="{{ $d['jenisbiaya'] ?? '' }}">
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
                          <input type="text" name="nowarkat[]" class="form-control">
                        </td>
                        <td>
                          <input type="text" name="tgljatuhtempo[]" class="form-control datepicker">
                        </td>
                        <td>
                          <input type="text" name="nominal[]" class="form-control text-right" oninput="separatorNumber(this)">
                        </td>
                        <td>
                          <input type="text" name="keterangan_detail[]" class="form-control">
                        </td>

                        <td>
                          <select name="coakredit[]" class="form-control select2bs4">
                            <option value="">COA KREDIT</option>
                            <?php foreach ($combo['coa'] as $key => $item) {

                            ?>
                              <option value="{{ $item['id'] }}">{{ $item['keterangancoa'] }}</option>
                            <?php } ?>
                          </select>
                        </td>
                        <td>
                          <select name="bankpelanggan_id[]" class="form-control select2bs4">
                            <option value="">PELANGGAN</option>
                            <?php foreach ($combo['bankpelanggan'] as $key => $item) {
                            ?>
                              <option value="{{ $item['id'] }}">{{ $item['namabank'] }}</option>
                            <?php } ?>
                          </select>
                        </td>

                        <td>
                          <input type="text" name="jenisbiaya[]" class="form-control">
                        </td>
                        <td>
                          <div class='btn btn-danger btn-sm rmv'>Hapus</div>
                        </td>
                      </tr>
                      @endif
                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="8"></td>
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
            <a href="{{ route('penerimaan.index') }}" class="btn btn-danger">
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

function myFunction() {
  var x = document.getElementById("bank");
  if ($("#statuskas option:selected").val() == 'STATUS BUKAN KAS') {
  				$('#bank').prop('hidden', 'true');
  			} else {
  				$('#bank').prop('hidden', false);
  			}

  // if (x.style.display === "none") {
  //   x.style.display = "block";
  // } else {
  //   x.style.display = "none";
  // }
}

// console.log("here");
//     $("#statuskas").load(function(){
//                 $('#statuskas').change(function() {
//                   var value = $(this).val();
//                   if (value == 'Bank') {
//                     $('#bank').hide()
//                   } else {
//                     $('#bank').show()
//                   }
//                 })
//               });

  //   $("#statuskas").load(function(){
  // $("#statuskas").change(function() {
  // 			console.log($("#statuskas option:selected").val());
  // 			if ($("#statuskas option:selected").val() == 'STATUS BUKAN KAS') {
  // 				$('#bank_id').prop('hidden', 'true');
  // 			} else {
  // 				$('#bank_id').prop('hidden', false);
  // 			}
  // 		});
  // });
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
  @if(isset($penerimaan['penerimaandetail']))
  baris = "{{count($penerimaan['penerimaandetail'])}}";
  @endif;

  //ambil data untuk select option
  let comboBankPelanggan = `<?= json_encode($combo['bankpelanggan']) ?>`;
  comboBankPelanggan = JSON.parse(comboBankPelanggan);
  let htmlComboBankPelanggan = '';
  $.each(comboBankPelanggan, function(index, value) {
    htmlComboBankPelanggan += `<option value='${value.id}'>${value.namabank}</option>`;
  });

  let comboCoa = `<?= json_encode($combo['coa']) ?>`;
  comboCoa = JSON.parse(comboCoa);
  let htmlComboCoa = '';
  $.each(comboCoa, function(index, value) {
    htmlComboCoa += `<option value='${value.id}'>${value.keterangancoa}</option>`;
  });

  let html = `<tr class="detailRow">
      <td>
        <div class="baris">1</div>
      </td>
      <td>
        <input type="text" name="nowarkat[]" class="form-control">
      </td>
      <td>
        <input type="text" name="tgljatuhtempo[]" class="form-control datepicker">
      </td>
      <td>
        <input type="text" name="nominal[]" class="form-control text-right"  oninput="separatorNumber(this)">
      </td>
      <td>
        <input type="text" name="keterangan_detail[]" class="form-control">
      </td>

       <td>
         <select name="coakredit[]" class="form-control select2bs4">
          <option value="">COA KREDIT</option>
          ${htmlComboCoa}
        </select>
       </td>
     
      <td>
        <select name="bankpelanggan_id[]" class="form-control select2bs4">
          <option value="">PELANGGAN</option>
          ${htmlComboBankPelanggan}
        </select>
      </td>
      <td>
        <input type="text" name="jenisbiaya[]" class="form-control">
       </td>
      <td>
        <div class='btn btn-danger btn-sm rmv'>Hapus</div>
      </td>                       
    </tr>`;

  $("#addrow").click(function() {
    destroyDatepicker()
    destroySelect2()
    let rowCount = $('#detailRow').length;
    if (rowCount > 0) {
      let clone = $('#detailRow').clone();
      clone.find("span").remove();
      clone.find("select").select2({
        theme: 'bootstrap4'
      });
      clone.find("select").val('').change();
      clone.find('input').val('');

      baris = parseInt(baris) + 1;
      clone.find('.baris').text(baris);
      $('table #table_body').append(clone);

      $('#detailRow').find('select').select2({
        theme: 'bootstrap4'
      });
    } else {
      baris = 1;
      $('#table_body').append(html);
    }

    initDatepicker()
    initSelect2()

    // resetFormatDate();
  });

  $('table').on('click', '.rmv', function() {
    $(this).closest('tr').remove();

    $('.baris').each(function(i, obj) {
      $(obj).text(i + 1);
    });
    baris = baris - 1;
  });

  let indexUrl = "{{ route('penerimaan.index') }}"
  let action = "{{ $action }}"
  let actionUrl = "{{ config('app.api_url') . 'penerimaan' }}"
  let method = "POST"
  let csrfToken = "{{ csrf_token() }}"
  let postingUrl = "{{ Config::get('app.api_url').'running_number' }}"

  /* Set action url */
  <?php if ($action !== 'add') : ?>
    actionUrl += `/{{ $penerimaan['id'] }}`
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