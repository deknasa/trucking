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

            <div class="row">
              <div class="form-group col-md-4">
                <div class="col-12 col-md-2 col-form-label">
                  <label>ID</label>
                </div>
                <div>
                  <input type="text" name="id" class="form-control" value="{{ $suratpengantar['id'] ?? '' }}" readonly>
                </div>
              </div>
              <div class="form-group col-md-4">
                <div class="col-form-label">
                  <label>
                    NO BUKTI <span class="text-danger">*</span>
                  </label>
                </div>
                <div>
                  <input type="text" name="nobukti" class="form-control" value="{{ $suratpengantar['nobukti'] ?? '' }}" readonly>
                </div>
              </div>
              <div class="form-group col-md-4">
                <div class="col-form-label">
                  <label>
                    TGL BUKTI <span class="text-danger">*</span>
                  </label>
                </div>
                <div>
                  <input type="text" name="tglbukti" class="form-control formatdate" value="{{ $suratpengantar['tglbukti'] ?? '' }}">
                </div>
              </div>
              <div class="form-group col-md-4">
                <div class="col-12 col-md-2 col-form-label">
                  <label>
                    TGL SP <span class="text-danger">*</span>
                  </label>
                </div>
                <div>
                  <input type="text" name="tglsp" class="form-control formatdate" value="{{ $suratpengantar['tglsp'] ?? '' }}">
                </div>
              </div>
              <div class="form-group col-md-4">
                <div class="col-12 col-md-2 col-form-label">
                  <label>
                    NO SP <span class="text-danger">*</span>
                  </label>
                </div>
                <div>
                  <input type="text" name="nosp" class="form-control" value="{{ $suratpengantar['nosp'] ?? '' }}">
                </div>
              </div>
              <div class="form-group col-md-4">
                <div class="col-form-label">
                  <label>
                    STATUS LONGTRIP <span class="text-danger">*</span>
                  </label>
                </div>
                <div>
                  <select name="statuslongtrip" class="form-control select2bs4">
                          <option value="">PILIH STATUS LONGTRIP</option>
                          <?php foreach ($combo['statuslongtrip'] as $key => $item) { 
                              $selected = @$suratpengantar['statuslongtrip'] == $item['id'] ? "selected" : ""
                          ?>
                              <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['text'] }}</option>
                          <?php } ?>
                  </select>
                </div>
              </div>

            <div class="form-group col-md-6">
              <div class="col-form-label">
                <label>
                  DARI <span class="text-danger">*</span>
                </label>
              </div>
              <div>
                <select name="dari_id" id="dari_id" class="form-control select2bs4">
                        <option value="">PILIH DARI</option>
                        <?php foreach ($combo['kota'] as $key => $item) { 
                            $selected = @$suratpengantar['dari_id'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['keterangan'] }}</option>
                        <?php } ?>
                </select>
              </div>


                <div class="col-form-label">
                  <label>
                    SAMPAI <span class="text-danger">*</span>
                  </label>
                </div>
                <div>
                  <select name="sampai_id" id="sampai_id" class="form-control select2bs4">
                          <option value="">PILIH SAMPAI</option>
                          <?php foreach ($combo['kota'] as $key => $item) { 
                              $selected = @$suratpengantar['sampai_id'] == $item['id'] ? "selected" : ""
                          ?>
                              <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['keterangan'] }}</option>
                          <?php } ?>
                  </select>
                </div>
            </div>

            

            <div class="card col-md-6">
              <div class="card-header bg-info">
                Peralihan
              </div>
              <div class="card-body">
                  <div class="form-group">
                    <div class="col-form-label">
                      <label>
                        STATUS PERALIHAN <span class="text-danger">*</span>
                      </label>
                    </div>
                    <div>
                      <select name="statusperalihan" class="form-control select2bs4" id="statusperalihan">
                              <option value="">PILIH STATUS PERALIHAN</option>
                              <?php foreach ($combo['statusperalihan'] as $key => $item) { 
                                  $selected = @$suratpengantar['statusperalihan'] == $item['id'] ? "selected" : ""
                              ?>
                                  <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['text'] }}</option>
                              <?php } ?>
                      </select>
                    </div>
                  </div>

                  <div id="peralihan" hidden>
                    <div class="row">
                      <div class="col-md-3">
                        <div class="form-group">
                          <div class="col-form-label">
                            <label>
                              PERSENTASE <span class="text-danger">*</span>
                            </label>
                          </div>
                          <div class="input-group">
                            <input type="text" name="persentaseperalihan" class="form-control numbernoseparate" value="{{ @$suratpengantar['persentaseperalihan'] == '' ? '' : (int)$suratpengantar['persentaseperalihan'] }}" aria-label="Amount (to the nearest dollar)">
                            <div class="input-group-append">
                              <span class="input-group-text">%</span>
                            </div>
                          </div>
                        </div>
                      </div>
                      <!-- <div class="col-md-9">
                        <div class="form-group">
                          <div class="col-form-label">
                            <label>
                              NOMINAL <span class="text-danger">*</span>
                            </label>
                          </div>
                          <div class="input-group">
                            <input type="text" name="nominalperalihan" class="form-control" value="{{ @$suratpengantar['nominalperalihan'] == '' ? '' : (int)$suratpengantar['nominalperalihan'] }}" aria-label="Amount (to the nearest dollar)" readonly>
                            <div class="input-group-append">
                              <span class="input-group-text">%</span>
                            </div>
                          </div>
                        </div>
                      </div> -->
                    </div>
                  </div>

                  
              </div>
            </div>
            

            <div class="form-group col-md-6">
              <div class="col-form-label">
                <label>
                  PELANGGAN <span class="text-danger">*</span></label>
              </div>
              <div>
                <select name="pelanggan_id" class="form-control select2bs4">
                        <option value="">PILIH PELANGGAN</option>
                        <?php foreach ($combo['pelanggan'] as $key => $item) { 
                            $selected = @$suratpengantar['pelanggan_id'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['namapelanggan'] }}</option>
                        <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group col-md-6">
              <div class="col-form-label">
                <label>
                  KETERANGAN <span class="text-danger">*</span>
                </label>
              </div>
              <div>
                <input type="text" name="keterangan" class="form-control" value="{{ $suratpengantar['keterangan'] ?? '' }}">
              </div>
            </div>

            <div class="form-group col-md-6">
              <div class="col-form-label">
                <label>
                  CONTAINER <span class="text-danger">*</span>
                </label>
              </div>
              <div>
                <select name="container_id" id="container_id" class="form-control select2bs4">
                        <option value="">PILIH CONTAINER</option>
                        <?php foreach ($combo['container'] as $key => $item) { 
                            $selected = @$suratpengantar['container_id'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['keterangan'] }}</option>
                        <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group col-md-6">
              <div class="col-form-label">
                <label>
                  NO CONT <span class="text-danger">*</span>
                </label>
              </div>
              <div>
                <input type="text" name="nocont" class="form-control" value="{{ $suratpengantar['nocont'] ?? '' }}">
              </div>
            </div>
            <div class="form-group col-md-6">
              <div class="col-form-label">
                <label>
                  NO CONT 2 <span class="text-danger">*</span>
                </label>
              </div>
              <div>
                <input type="text" name="nocont2" class="form-control" value="{{ $suratpengantar['nocont2'] ?? '' }}">
              </div>
            </div>
            <div class="form-group col-md-6">
              <div class="col-form-label">
                <label>
                  STATUS CONTAINER <span class="text-danger">*</span>
                </label>
              </div>
              <div>
                <select name="statuscontainer_id" id="statuscontainer_id" class="form-control select2bs4">
                        <option value="">PILIH STATUS CONTAINER</option>
                        <?php foreach ($combo['statuscontainer'] as $key => $item) { 
                            $selected = @$suratpengantar['statuscontainer_id'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['keterangan'] }}</option>
                        <?php } ?>
                </select>
              </div>
            </div>

            <div class="form-group col-md-6">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  TRADO <span class="text-danger">*</span>
                </label>
              </div>
              <div>
                <select name="trado_id" class="form-control select2bs4">
                        <option value="">PILIH TRADO</option>
                        <?php foreach ($combo['trado'] as $key => $item) { 
                            $selected = @$suratpengantar['trado_id'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['keterangan'] }}</option>
                        <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group col-md-6">
              <div class="col-form-label">
                <label>
                  SUPIR <span class="text-danger">*</span>
                </label>
              </div>
              <div>
                <select name="supir_id" class="form-control select2bs4">
                        <option value="">PILIH SUPIR</option>
                        <?php foreach ($combo['supir'] as $key => $item) { 
                            $selected = @$suratpengantar['supir_id'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['namasupir'] }}</option>
                        <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group col-md-6">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  AGEN <span class="text-danger">*</span>
                </label>
              </div>
              <div>
                <select name="agen_id" class="form-control select2bs4">
                        <option value="">PILIH AGEN</option>
                        <?php foreach ($combo['agen'] as $key => $item) { 
                            $selected = @$suratpengantar['agen_id'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['namaagen'] }}</option>
                        <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group col-md-6">
              <div class="col-form-label">
                <label>
                  JENIS ORDER <span class="text-danger">*</span>
                </label>
              </div>
              <div>
                <select name="jenisorder_id" class="form-control select2bs4">
                        <option value="">PILIH JENIS ORDER</option>
                        <?php foreach ($combo['jenisorder'] as $key => $item) { 
                            $selected = @$suratpengantar['jenisorder_id'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['keterangan'] }}</option>
                        <?php } ?>
                </select>
              </div>
            </div>
            <div class="form-group col-md-6">
              <div class="col-form-label">
                <label>
                  NO JOB <span class="text-danger">*</span>
                </label>
              </div>
              <div>
                <input type="text" name="nojob" class="form-control" value="{{ $suratpengantar['nojob'] ?? '' }}">
              </div>
            </div>
            <div class="form-group col-md-6">
              <div class="col-form-label">
                <label>
                  NO JOB 2 <span class="text-danger">*</span>
                </label>
              </div>
              <div>
                <input type="text" name="nojob2" class="form-control" value="{{ $suratpengantar['nojob2'] ?? '' }}">
              </div>
            </div>

            <div class="form-group col-md-6">
              <div class="col-form-label">
                <label>
                  TARIF <span class="text-danger">*</span>
                </label>
              </div>
              <div>
                <select name="tarif_id" class="form-control select2bs4">
                        <option value="">PILIH TARIF</option>
                        <?php foreach ($combo['tarif'] as $key => $item) { 
                            $selected = @$suratpengantar['tarif_id'] == $item['id'] ? "selected" : ""
                        ?>
                            <option value="{{ $item['id'] }}" {{ $selected }} >{{ $item['tujuan'] }}</option>
                        <?php } ?>
                </select>
              </div>
            </div>

            </div>
            
            
            
            
            
            

            <div class="card">
              <div class="card-header bg-info">
                Biaya
              </div>
              <div class="card-body">

                <div class="row form-group">
                    <div class="col-12 col-md-2 col-form-label">
                      <label>
                        GAJI SUPIR <span class="text-danger">*</span>
                      </label>
                    </div>
                    <div class="col-12 col-md-10">
                      <input type="text" name="gajisupir" id="gajisupir" class="form-control" value="{{ number_format(@$suratpengantar['gajisupir'],0,'.','.') ?? '' }}" oninput="separatorNumber(this)" readonly>
                    </div>
                  </div>

                  <div class="row form-group">
                    <div class="col-12 col-md-2 col-form-label">
                      <label>
                        GAJI KENEK <span class="text-danger">*</span>
                      </label>
                    </div>
                    <div class="col-12 col-md-10">
                      <input type="text" name="gajikenek" id="gajikenek" class="form-control" value="{{ number_format(@$suratpengantar['gajikenek'],0,'.','.') ?? '' }}" oninput="separatorNumber(this)" readonly>
                    </div>
                  </div>

                  <div class="row form-group">
                    <div class="col-12 col-md-2 col-form-label">
                      <label>
                        KOMISI SUPIR <span class="text-danger">*</span>
                      </label>
                    </div>
                    <div class="col-12 col-md-10">
                      <input type="text" name="komisisupir" id="komisisupir" class="form-control" value="{{ number_format(@$suratpengantar['komisisupir'],0,'.','.') ?? '' }}" oninput="separatorNumber(this)" readonly>
                    </div>
                  </div>

              <h3 class="text-center">Biaya Tambahan</h3>
            <button type="button" class="btn btn-primary my-2" id="addrow">Tambah</button>

            <div class="row">
              <div class="col-12">
                <div class="table-responsive">
                  <table class="table table-bordered table-bindkeys">
                    <thead>
                      <tr>
                        <th width="50">No</th>
                        <th>Keterangan</th>
                        <th>Nominal</th>
                        <th>Aksi</th>
                      </tr>
                    </thead>
                    <tbody id="table_body" class="form-group">
                      @if (count(@$suratpengantar['suratpengantar_biaya'] ?? []) > 0)
                      @foreach($suratpengantar['suratpengantar_biaya'] as $suratpengantarIndex => $d)
                      <tr id="row">
                        <td>
                          <span class="baris">{{ $suratpengantarIndex+1 }}</span>
                        </td>
                        <td>
                          <input type="text" name="keteranganbiaya[]" class="form-control" value="{{ $d['keteranganbiaya'] ?? '' }}">
                        </td>
                        <td>
                          <input type="text" name="nominal[]" class="form-control text-right" value="{{ number_format($d['nominal'],0,'.','.') ?? '' }}" oninput="separatorNumber(this)">
                        </td>
                        <td>
                          @if($suratpengantarIndex > 0)
                          <div class='btn btn-danger btn-sm rmv'>Hapus</div>
                          @endif
                        </td>
                      </tr>
                      @endforeach
                      @else
                      <tr id="row">
                        <td>
                          <span class="baris">1</span>
                        </td>
                        <td>
                          <input type="text" name="keteranganbiaya[]" class="form-control">
                        </td>
                        <td>
                          <input type="text" name="nominal[]" class="form-control text-right" oninput="separatorNumber(this)">
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

                  <!-- <div class="row form-group">
                    <div class="col-12 col-md-2 col-form-label">
                      <label>
                        TOL SUPIR <span class="text-danger">*</span>
                      </label>
                    </div>
                    <div class="col-12 col-md-10">
                      <input type="text" name="tolsupir" class="form-control" value="{{ number_format(@$suratpengantar['tolsupir'],0,'.','.') ?? '' }}" oninput="separatorNumber(this)">
                    </div>
                  </div>

                  <div class="row form-group">
                    <div class="col-12 col-md-2 col-form-label">
                      <label>
                        NO SP TAGIH LAIN <span class="text-danger">*</span>
                      </label>
                    </div>
                    <div class="col-12 col-md-10">
                      <input type="text" name="nosptagihlain" class="form-control" value="{{ number_format(@$suratpengantar['nosptagihlain'],0,'.','.') ?? '' }}" oninput="separatorNumber(this)">
                    </div>
                  </div>

                  <div class="row form-group">
                    <div class="col-12 col-md-2 col-form-label">
                      <label>
                        NILAI TAGIH LAIN <span class="text-danger">*</span>
                      </label>
                    </div>
                    <div class="col-12 col-md-10">
                      <input type="text" name="nilaitagihlain" class="form-control" value="{{ number_format(@$suratpengantar['nilaitagihlain'],0,'.','.') ?? '' }}" oninput="separatorNumber(this)">
                    </div>
                  </div>

                  <div class="row form-group">
                    <div class="col-12 col-md-2 col-form-label">
                      <label>
                        TUJUAN TAGIH <span class="text-danger">*</span>
                      </label>
                    </div>
                    <div class="col-12 col-md-10">
                      <input type="text" name="tujuantagih" class="form-control" value="{{ $suratpengantar['tujuantagih'] ?? '' }}">
                    </div>
                  </div> -->
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
            <a href="{{ route('suratpengantar.index') }}" class="btn btn-danger">
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
<script type="text/javascript">

  $('#dari_id,#sampai_id,#container_id,#statuscontainer_id').change(function() {
    var dari = $('#dari_id').val();
    var sampai = $('#sampai_id').val();
    var container = $('#container_id').val();
    var statuscontainer = $('#statuscontainer_id').val();

    $.ajax({
      url: "{{ route('suratpengantar.get_gaji') }}",
      method: "GET",
      data: {
        dari : dari,
        sampai: sampai,
        container: container,
        statuscontainer: statuscontainer
      },
      headers: {
          'X-CSRF-TOKEN': csrfToken,
      },
      success: response => {
        if (response == '') {
          $('#gajisupir').val(0);
          $('#gajikenek').val(0);
          $('#komisisupir').val(0);
        } else {
          $('#gajisupir').val(response.nominalsupir)
          $('#gajikenek').val(response.nominalkenek)
          $('#komisisupir').val(response.nominalkomisi)
        }

        separatorNumber(document.getElementById('gajisupir'));
        separatorNumber(document.getElementById('gajikenek'));
        separatorNumber(document.getElementById('komisisupir'));
      },
      error: error => {
        showDialog(error.statusText)
      }
    });
  });

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
  @if(isset($suratpengantar['suratpengantar_biaya']))
  baris = "{{count($suratpengantar['suratpengantar_biaya'])}}";
  @endif

  $("#addrow").click(function() {
    let clone = $('#row').clone();
    clone.find(':last-child').append("<div class='btn btn-danger btn-sm rmv' >Hapus</div>")
    clone.find('input').val('');

    baris = parseInt(baris) + 1;
    clone.find('.baris').text(baris);
    $('table #table_body').append(clone);
  });

  $('table').on('click', '.rmv', function() {
    $(this).closest('tr').remove();

    $('.baris').each(function(i, obj) {
      $(obj).text(i + 1);
    });
    baris = baris - 1;
  });

  $(function() {
    $('#statusperalihan').change(function() {
      var val = $(this).val();

      if (val != '') {
        $('#peralihan').removeAttr('hidden');
      } else {
        $('#peralihan').attr('hidden','');
      }
    });

    $('#statusperalihan').trigger("change");
  });
</script>

<script>
 

  let indexUrl = "{{ route('suratpengantar.index') }}"
  let action = "{{ $action }}"
  let actionUrl =  "{{ config('app.api_url') . 'suratpengantar' }}" 
  let method = "POST"
  let csrfToken = "{{ csrf_token() }}"

  /* Set action url */
  <?php if ($action !== 'add') : ?>
    actionUrl += `/{{ $suratpengantar['id'] }}`
    
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

        // headers: {
        //     'X-CSRF-TOKEN': csrfToken,
        // },
        success: response => {
          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()

          if (response.status) {
            window.location.href = `${indexUrl}?page=${response.data.page ?? 1}&id=${response.data.id ?? 1}&sortname={{ $sortname }}&sortorder={{ $sortorder }}&limit={{ $limit }}`
          } else {
            showDialog(response.message)
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