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
                <label>NO BUKTI</label>
              </div>
              <div class="col-12 col-md-4">
                <input type="text" name="nobukti" class="form-control" value="{{ $penerimaantrucking['nobukti'] ?? '-' }}" readonly>
              </div>
              <div class="col-12 col-md-2 col-form-label">
                <label>TANGGAL BUKTI</label>
              </div>
              <div class="col-12 col-md-4">
                @php
                if (isset($penerimaantrucking['tglbukti'])) {
                $tglbukti = date('d-m-Y',strtotime($penerimaantrucking['tglbukti']));
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
                <input type="text" name="keterangan" class="form-control" value="{{ $penerimaantrucking['keterangan'] ?? '' }}">
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
                    $selected = @$penerimaantrucking['bank_id'] == $item['id'] ? "selected" : ""
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
                <select name="coa" class="form-control select2bs4">
                  <option value="">PILIH COA</option>
                  <?php foreach ($combo['coa'] as $key => $item) {
                    $selected = @$penerimaantrucking['coa'] == $item['id'] ? "selected" : ""
                  ?>
                    <option value="{{ $item['id'] }}" {{ $selected }}>{{ $item['keterangancoa'] }}</option>
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
                        <th>Nominal</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody id="table_body" class="form-group">
                      @if (isset($penerimaantrucking['penerimaantruckingdetail']))
                      @foreach($penerimaantrucking['penerimaantruckingdetail'] as $penerimaantruckingIndex => $d)
                      <tr id="row">

                        <td>
                          <div class="baris">{{ $penerimaantruckingIndex+1 }}</div>
                        </td>

                        <td>
                          <select name="cao[]" class="form-control select2bs4">
                            <option value="">COA KREDIT</option>
                            <?php foreach ($combo['coa'] as $key => $item) {
                              $selected = @$d['coa'] == $item['coa'] ? "selected" : ""
                            ?>
                              <option value="{{ $item['id'] }}" {{ $selected }}>{{ $item['keterangancoa'] }}</option>
                            <?php } ?>
                          </select>
                        </td>

                        <td>
                          <input type="text" name="nominal[]" class="form-control text-right" value="{{ number_format($d['nominal'],0,'.','.') ?? '' }}" oninput="separatorNumber(this)">
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
                          <select name="supir[]" class="form-control select2bs4">
                            <option value="">PILIH SUPIR</option>
                            <?php foreach ($combo['supir'] as $key => $item) {
                            ?>
                              <option value="{{ $item['id'] }}">{{ $item['namasupir'] }}</option>
                            <?php } ?>
                          </select>
                        </td>

                        <td>
                          <input type="text" name="nominal[]" class="form-control text-right" oninput="separatorNumber(this)">
                        </td>

                        <td>
                          <div class='btn btn-danger btn-sm rmv'>Hapus</div>
                        </td>
                      </tr>
                      @endif
                      </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="3"></td>
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
        <a href="{{ route('penerimaantrucking.index') }}" class="btn btn-danger">
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
  var baris = 1;
  @if(isset($penerimaantrucking['penerimaantruckingdetail']))
  baris = "{{count($penerimaantrucking['penerimaantruckingdetail'])}}";
  @endif;

  //ambil data untuk select option

  let comboSupir = `<?= json_encode($combo['supir']) ?>`;
  comboSupir = JSON.parse(comboSupir);
  let htmlComboSupir = '';
  $.each(comboSupir, function(index, value) {
    htmlComboSupir += `<option value='${value.id}'>${value.keteranganSupir}</option>`;
  });

  let html = `<tr class="detailRow">
      <td>
        <div class="baris">1</div>
      </td>
      <td>
         <select name="supir[]" class="form-control select2bs4">
          <option value="">PILIH SUPIR</option>
          ${htmlComboSupir}
        </select>
       </td>
      <td>
        <input type="text" name="nominal[]" class="form-control text-right"  oninput="separatorNumber(this)">
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

  let indexUrl = "{{ route('penerimaantrucking.index') }}"
  let action = "{{ $action }}"
  let actionUrl = "{{ config('app.api_url') . 'penerimaantrucking' }}"
  let method = "POST"
  let csrfToken = "{{ csrf_token() }}"
  let postingUrl = "{{ Config::get('app.api_url').'running_number' }}"

  /* Set action url */
  <?php if ($action !== 'add') : ?>
    actionUrl += `/{{ $penerimaantrucking['id'] }}`
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
    // $('[name=statuskas]').change(function() {
    //   let value = $(this).val()
    //   let tipe = 'KAS'

      //lokal
      // if (value == 131) {
      //   tipe = 'KAS'
      // } else if (value == 134) {
      //   tipe = 'BANK'
      // }

      //web
      // if (value == 145) {
      //   tipe = 'KAS'
      // } else if (value == 146) {
      //   tipe = 'BANK'
      // }

    //   $.ajax({
    //     url: `${apiUrl}bank`,
    //     method: 'GET',
    //     async: false,
    //     data: {
    //       filters: JSON.stringify({
    //         "groupOp": "AND",
    //         "rules": [{
    //           "field": "tipe",
    //           "op": "cn",
    //           "data": tipe
    //         }]
    //       })
    //     },
    //     beforeSend: jqXHR => {
    //       jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)
    //     },
    //     success: response => {
    //       $('[name=bank_id]').html(`
    //         ${
    //           response.data.map((bank, index) => {
    //             return `
    //               <option value="${bank.id}">  ${bank.namabank} </option>
    //             `
    //           }).join(' ')
    //         }  
    //       `)
    //       //  console.log(response);
    //     }
    //   })
    // })

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