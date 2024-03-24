@extends('layouts.master')

@section('content')
<!-- Grid -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <div class="card card-easyui bordered mb-4">
        <div class="card-header">
          <h5 class="card-title" id="crudModalTitle" style="color: #0e2d5f;font-weight: 700;"> {{$title}} </h5>

        </div>
        <form action="#" id="crudForm">
          <div class=" ">

            <form action="" method="post">
              <div class="card-body">

                <div class="form-group ">
                  <label class="col-sm-4 col-form-label">TGL TRIP <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <div class="input-group">
                      <input type="text" name="tglbukti" class="form-control datepicker">
                    </div>
                  </div>
                </div>
                <div class="form-group statusupahzona">
                  <label class="col-sm-12 col-form-label">UPAH ZONA <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <select name="statusupahzona" class="form-control select2bs4" id="statusupahzona">
                      <option value="">-- PILIH STATUS UPAH ZONA--</option>
                    </select>
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">JENIS SURAT PENGANTAR <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <select name="statuslongtrip" class="form-control select2bs4" id="statuslongtrip">
                      <option value="">-- PILIH STATUS LONGTRIP --</option>
                    </select>
                  </div>
                </div>
                <div class="form-group joblangsir">
                  <label class="col-sm-12 col-form-label">STATUS LANGSIR <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <select name="statuslangsir" class="form-control select2bs4" id="statuslangsir">
                      <option value="">-- PILIH STATUS LANGSIR --</option>
                    </select>
                  </div>
                </div>

                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">GUDANG SAMA <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <select name="statusgudangsama" class="form-control select2bs4" id="statusgudangsama">
                      <option value="">-- PILIH STATUS GUDANG SAMA --</option>
                    </select>
                  </div>
                </div>

                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">CUSTOMER <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="hidden" name="agen_id">
                    <input type="text" name="agen" class="form-control agen-lookup">
                  </div>
                </div>

                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">JENIS ORDERAN <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="hidden" name="jenisorder_id">
                    <input type="text" name="jenisorder" class="form-control jenisorder-lookup">
                  </div>
                </div>

                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">FULL / EMPTY <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="hidden" name="statuscontainer_id">
                    <input type="text" name="statuscontainer" class="form-control statuscontainer-lookup">
                  </div>
                </div>

                <div class="form-group ">
                  <label class="col-sm-4 col-form-label">CONTAINER <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="hidden" name="container_id">
                    <input type="text" name="container" class="form-control container-lookup">
                  </div>
                </div>

                <div class="form-group ">
                  <label class="col-sm-4 col-form-label">UPAH SUPIR <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="hidden" name="upah_id">
                    <input type="text" name="upah" class="form-control upahsupirrincian-lookup">
                  </div>
                </div>

                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">PENYESUAIAN</label>
                  <div class="col-sm-12">
                    <input type="text" name="penyesuaian" class="form-control" readonly>
                  </div>
                </div>

                <div class="form-group ">
                  <label class="col-sm-4 col-form-label">DARI <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="hidden" name="dari_id">
                    <input type="text" name="dari" class="form-control kotadari-lookup" readonly>
                  </div>
                </div>

                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">Sampai <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="hidden" name="sampai_id">
                    <input type="text" name="sampai" class="form-control kotasampai-lookup" readonly>
                  </div>
                </div>

                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">TUJUAN TARIF <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="hidden" name="tarifrincian_id">
                    <input type="text" name="tarifrincian" class="form-control" readonly>
                  </div>
                </div>

                <div class="form-group " style="display:none">
                  <label class="col-sm-12 col-form-label">Lokasi BONGKAR/MUAT <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="text" name="lokasibongkarmuat" class="form-control">
                  </div>
                </div>

                <div class="form-group ">
                  <label class="col-sm-4 col-form-label">NO POLISI <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="hidden" name="trado_id">
                    <input type="hidden" name="supir_id">
                    <input type="hidden" name="absensidetail_id">
                    <input type="text" name="trado" class="form-control absensisupirdetail-lookup">
                    <table class="table table-striped table-bordered table-responsive tableInfo" style="display:none">
                      <thead>
                        <tr>
                          <th>Keterangan</th>
                          <th>KM trado</th>
                          <th>KM total</th>
                        </tr>
                      </thead>
                      <tbody id="infoTrado">

                      </tbody>
                    </table>
                  </div>
                </div>

                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">SHIPPER <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="hidden" name="pelanggan_id">
                    <input type="text" name="pelanggan" class="form-control pelanggan-lookup">
                  </div>
                </div>

                <div class="form-group statusgandengan">
                  <label class="col-sm-12 col-form-label">STATUS GANDENGAN <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <select name="statusgandengan" class="form-control select2bs4" id="statusgandengan">
                      <option value="">-- PILIH STATUS GANDENGAN --</option>
                    </select>
                  </div>
                </div>

                <div class="form-group gandengan">
                  <label class="col-sm-12 col-form-label">NO GANDENGAN / CHASIS <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="hidden" name="gandengan_id">
                    <input type="text" name="gandengan" class="form-control gandengan-lookup">
                  </div>
                </div>

                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">NO GANDENGAN / CHASIS (ASAL)</label>
                  <div class="col-sm-12">
                    <input type="hidden" name="gandenganasal_id">
                    <input type="text" name="gandenganasal" class="form-control gandenganasal-lookup">
                  </div>
                </div>

                <div class="form-group nobukti_tripasal">
                  <label class="col-sm-12 col-form-label">TRIP ASAL</label>
                  <div class="col-sm-12">
                    <input type="text" name="nobukti_tripasal" class="form-control suratpengantar-lookup">
                  </div>
                </div>

                <div class="form-group ">
                  <label name="labeljobtrucking" class="col-sm-12 col-form-label">NO JOB TRUCKING
                    {{-- <span class="text-danger">*</span> --}}
                  </label>
                  <div class="col-sm-12">
                    <input type="text" name="jobtrucking" class="form-control jobtrucking-lookup">
                  </div>
                </div>

                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">GUDANG <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="text" name="gudang" class="form-control">
                  </div>
                </div>

                <div class="table-scroll table-responsive ritasi">
                  <table class="table table-bordered table-bindkeys" id="ritasiList" style="width: 1000px;">
                    <thead>
                      <tr>
                        <th width="2%">No</th>
                        <th width="25%">JENIS RITASI</th>
                        <th width="35%">RITASI DARI</th>
                        <th width="35%">RITASI KE</th>
                        <th width="2%">Aksi</th>
                      </tr>
                    </thead>
                    <tbody id="table_body" class="form-group">

                    </tbody>
                    <tfoot>
                      <tr>
                        <td colspan="4"></td>
                        <td>
                          <button type="button" class="btn btn-primary btn-sm my-2" id="addRow">TAMBAH</button>
                        </td>
                      </tr>
                    </tfoot>
                  </table>
                </div>

              </div>
              <div class="card-footer justify-content-start">
                <button id="btnSubmit" class="btn btn-primary">
                  <i class="fa fa-save"></i>
                  Save
                </button>

              </div>
            </form>
          </div>
        </form>

      </div>

    </div>
  </div>
</div>

@push('scripts')

<script>
  let indexRow = 0;
  let triggerClick = true;
  let id = "";
  let jenisorderId
  let statuscontainerId
  let kotadariId
  let kotasampaiId
  let pilihKotaDariId = 0;
  let pilihKotaSampaiId = 0;
  let containerId
  let tradoId
  let pelangganId
  let gandenganId
  let tarifrincianId
  let statusLongtrip
  var statuspelabuhan
  let dataRitasiId = []
  let statusUpahZona
  let selectedUpahZona
  let zonadariId
  let zonasampaiId
  let upahZona
  let tinggalGandengan
  let longTripId
  let kodeStatusContainer
  let isTripAsal = true;
  let isPulangLongtrip;
  let isGudangSama = true;

  $(document).ready(function() {
    $('.nobukti_tripasal').hide()
    $(document).on('click', "#addRow", function() {
      addRow()
    });

    $(document).on('click', '.delete-row', function(event) {
      deleteRow($(this).parents('tr'))
    })

    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()

      method = 'POST'
      url = `${apiUrl}inputtrip`

      data.push({
        name: 'info',
        value: info
      })
      data.push({
        name: 'indexRow',
        value: indexRow
      })
      data.push({
        name: 'upahritasi',
        value: ''
      })

      $(this).attr('disabled', '')
      $('#processingLoader').removeClass('d-none')

      $.ajax({
        url: url,
        method: method,
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: data,
        success: response => {

          $('.tableInfo').hide()
          showSuccessDialog(response.message, response.data.nobukti)
          enabledUpahSupir()
          $('#crudForm [name=nobukti_tripasal]').data('currentValue', '')
          $('#crudForm [name=agen]').data('currentValue', '')
          $('#crudForm [name=jenisorder]').data('currentValue', '')
          $('#crudForm [name=statuscontainer]').data('currentValue', '')
          $('#crudForm [name=container]').data('currentValue', '')
          $('#crudForm [name=upah]').data('currentValue', '')
          $('#crudForm [name=pelanggan]').data('currentValue', '')
          $('#crudForm [name=gandengan]').data('currentValue', '')
          $('#crudForm [name=gandenganasal]').data('currentValue', '')
          $('#crudForm [name=trado]').data('currentValue', '')
          $('#crudForm [name=jobtrucking]').data('currentValue', '')
          $('#crudForm [name=jobtrucking]').attr('readonly', false)
          $('#crudForm [name=dari]').data('currentValue', '')
          $('#crudForm [name=sampai]').data('currentValue', '')
          $('#crudForm [name=tarifrincian]').data('currentValue', '')
          createSuratPengantar()

        },
        error: error => {
          console.log('postdata ', error)
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
            setErrorMessages(form, error.responseJSON.errors);
          } else {
            showDialog(error.responseJSON)
          }
        },
      }).always(() => {
        $('#processingLoader').addClass('d-none')
        $(this).removeAttr('disabled')
      })

      // $.ajax({
      //   url: url,
      //   method: method,
      //   dataType: 'JSON',
      //   headers: {
      //     Authorization: `Bearer ${accessToken}`
      //   },
      //   data: data,
      //   success: response => {

      //     id = response.data.id
      //     $('#crudModal').modal('hide')
      //     $('#crudModal').find('#crudForm').trigger('reset')

      //     $('#jqGrid').jqGrid('setGridParam', {
      //       page: response.data.page
      //     }).trigger('reloadGrid');

      //     if (response.data.grp == 'FORMAT') {
      //       updateFormat(response.data)
      //     }
      //   },
      //   error: error => {
      //     if (error.status === 422) {
      //       $('.is-invalid').removeClass('is-invalid')
      //       $('.invalid-feedback').remove()

      //       setErrorMessages(form, error.responseJSON.errors);
      //     } else {
      //       showDialog(error.statusText)
      //     }
      //   },
      // }).always(() => {
      //   $('#processingLoader').addClass('d-none')
      //   $(this).removeAttr('disabled')
      // })


    })

    let form = $('#crudForm')
    setFormBindKeys(form)

    activeGrid = null
    createSuratPengantar()
    getMaxLength(form)
    initLookup()
    initDatepicker()
    initSelect2(null, false)
    // enabledTarif()
    enabledUpahSupir()
    // enabledKota()
  })

  // function enabledTarif() {

  //   let container_id = $('#crudForm [name=container_id]')
  //   let tarifrincian = $('#crudForm [name=tarifrincian]')
  //   // tarifrincian
  //   if (container_id.val() == '') {
  //     tarifrincian.attr('readonly', true)
  //     tarifrincian.parents('.input-group').find('.input-group-append').hide()
  //     tarifrincian.parents('.input-group').find('.button-clear').hide()
  //   } else {
  //     tarifrincian.attr('readonly', false)
  //     tarifrincian.parents('.input-group').find('.input-group-append').show()
  //     tarifrincian.parents('.input-group').find('.button-clear').show()
  //   }
  // }
  $(`#crudForm [name="statusupahzona"]`).on('change', function(event) {
    selectedUpahZona = $(`#crudForm [name="statusupahzona"] option:selected`).text()
    enabledLogTrip($(this).val())
    if (selectedUpahZona == 'NON UPAH ZONA' || selectedUpahZona == 'UPAH ZONA') {
      statusUpahZona = $(`#crudForm [name="statusupahzona"]`).val()

      $('#crudForm [name=upah_id]').val('')
      $('#crudForm [name=upah]').val('').data('currentValue', '')
      enabledUpahSupir()
      clearUpahSupir()
      if (selectedUpahZona == 'UPAH ZONA') {
        let jobtrucking = $('#crudForm [name=jobtrucking]')
        let labeljobtrucking = $('#crudForm [name=labeljobtrucking]')

        jobtrucking.attr('hidden', true)
        labeljobtrucking.attr('hidden', true)
        jobtrucking.parents('.input-group').find('.input-group-append').hide()
        jobtrucking.parents('.input-group').find('.button-clear').hide()
      }
    }
  })
  $(`#crudForm [name="statusgandengan"]`).on('change', function(event) {
    if ($(this).val() == tinggalGandengan) {
      $(`#crudForm [name="gandenganasal"]`).parents('.form-group').hide()
    } else {
      $(`#crudForm [name="gandenganasal"]`).parents('.form-group').show()
    }
  })


  $(`#crudForm [name="statusgudangsama"]`).on('change', function(event) {
    enableTripAsal()
    setJobReadOnly()
  })

  $(`#crudForm [name="statuslongtrip"]`).on('change', function(event) {
    let statuslongtrip = $(`#crudForm [name="statuslongtrip"]`).val()

    if (statuslongtrip == 65) {
      $('.nobukti_tripasal').hide()
      clearTripAsal()
      isPulangLongtrip = false;
    }
    clearUpahSupir()
    setJobReadOnly()
  })

  $(document).on("change", `[name=tglbukti]`, function(event) {
    $(`#crudForm [name="trado_id"]`).val('')
    $(`#crudForm [name="supir_id"]`).val('')
    $(`#crudForm [name="absensidetail_id"]`).val('')
    $(`#crudForm [name="trado"]`).val('')
    $('#crudForm [name=trado]').data('currentValue', '')
  })

  function enabledLogTrip(selected) {
    if (selected == upahZona) {

      $(`#crudForm [name="statuslongtrip"]`).val(longTripId).trigger('change');
      $(`#crudForm [name="statuslongtrip"]`).attr('readonly', true);
    } else {
      $(`#crudForm [name="statuslongtrip"]`).attr('readonly', false);
    }
  }

  function enabledUpahSupir() {

    let statuscontainer_id = $('#crudForm [name=statuscontainer_id]')
    let container_id = $('#crudForm [name=container_id]')
    let jenisorder_id = $('#crudForm [name=jenisorder_id]')
    let upahsupir = $('#crudForm [name=upah]')

    if (container_id.val() == '' && statuscontainer_id.val() == '' && jenisorder_id.val() == '') {
      upahSupirReadOnly()
      kotaUpahZona()
    } else {
      if (container_id.val() == '') {
        upahSupirReadOnly()
      } else if (statuscontainer_id.val() == '') {
        upahSupirReadOnly()
      } else if (jenisorder_id.val() == '') {
        upahSupirReadOnly()
      } else {
        if (upahsupir.val() != '') {
          upahsupir.val('')
          $('#crudForm [name=upah]').val('')
          clearUpahSupir()
        } else {
          upahsupir.attr('readonly', false)
          upahsupir.parents('.input-group').find('.input-group-append').show()
          upahsupir.parents('.input-group').find('.button-clear').show()
        }
      }
    }
  }

  function upahSupirReadOnly() {
    let upahsupir = $('#crudForm [name=upah]')
    upahsupir.attr('readonly', true)
    upahsupir.parents('.input-group').find('.input-group-append').hide()
    upahsupir.parents('.input-group').find('.button-clear').hide()
  }

  function kotaUpahZona() {
    let kotadari_id = $('#crudForm [name=dari]')
    let kotasampai_id = $('#crudForm [name=sampai]')
    let upahsupir = $('#crudForm [name=upah]')
    if (upahsupir.val() != '') {
      if (selectedUpahZona == 'UPAH ZONA') {
        kotadari_id.attr('readonly', false)
        kotasampai_id.attr('readonly', false)
        kotadari_id.parents('.input-group').find('.input-group-append').show()
        kotadari_id.parents('.input-group').find('.button-clear').show()
        kotasampai_id.parents('.input-group').find('.input-group-append').show()
        kotasampai_id.parents('.input-group').find('.button-clear').show()
      } else {
        kotadari_id.attr('readonly', true)
        kotasampai_id.attr('readonly', true)
        kotadari_id.parents('.input-group').find('.input-group-append').hide()
        kotadari_id.parents('.input-group').find('.button-clear').hide()
        kotasampai_id.parents('.input-group').find('.input-group-append').hide()
        kotasampai_id.parents('.input-group').find('.button-clear').hide()
      }
    } else {

      kotadari_id.parents('.input-group').find('.input-group-append').hide()
      kotadari_id.parents('.input-group').find('.button-clear').hide()
      kotasampai_id.parents('.input-group').find('.input-group-append').hide()
      kotasampai_id.parents('.input-group').find('.button-clear').hide()
    }
  }
  // function enabledKota() {

  //   let kotadari_id = $('#crudForm [name=dari]')
  //   let kotasampai_id = $('#crudForm [name=sampai]')
  //   let upahsupir = $('#crudForm [name=upah_id]')
  //   // tarifrincian
  //   if (upahsupir.val() == '') {
  //     kotadari_id.attr('readonly', true)
  //     kotadari_id.parents('.input-group').find('.input-group-append').hide()
  //     kotadari_id.parents('.input-group').find('.button-clear').hide()
  //     kotasampai_id.attr('readonly', true)
  //     kotasampai_id.parents('.input-group').find('.input-group-append').hide()
  //     kotasampai_id.parents('.input-group').find('.button-clear').hide()
  //   } else {
  //     kotadari_id.attr('readonly', false)
  //     kotadari_id.parents('.input-group').find('.input-group-append').show()
  //     kotadari_id.parents('.input-group').find('.button-clear').show()
  //     kotasampai_id.attr('readonly', false)
  //     kotasampai_id.parents('.input-group').find('.input-group-append').show()
  //     kotasampai_id.parents('.input-group').find('.button-clear').show()
  //   }
  // }

  function createSuratPengantar() {
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`  <i class="fa fa-save"></i> Save `)
    form.data('action', 'add')
    // form.find(`.sometimes`).show()
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    // $('#crudForm').find('[name=tglsp]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    $('#table_body').html('')
    addRow()
    Promise
      .all([
        setStatusLongTripOptions(form),
        setStatusGudangSamaOptions(form),
        setStatusUpahZonaOptions(form),
        setStatusLangsirOptions(form),
        setStatusGandenganOptions(form),
        setTampilan(form)
      ])
      .then(() => {

        setIsDateAvailable(form),
          showDefault(form)
      })
      .catch((error) => {
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }

  const setTampilan = function(relatedForm) {
    return new Promise((resolve, reject) => {
      let data = [];
      data.push({
        name: 'grp',
        value: 'UBAH TAMPILAN'
      })
      data.push({
        name: 'text',
        value: 'INPUTTRIP'
      })
      $.ajax({
        url: `${apiUrl}parameter/getparambytext`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: data,
        success: response => {
          memo = JSON.parse(response.memo)
          memo = memo.INPUT
          if (memo != '') {
            input = memo.split(',');
            input.forEach(field => {
              field = $.trim(field.toLowerCase());
              if (field == 'nobukti_tripasal') {
                isTripAsal = false
              }
              $(`.${field}`).hide()
            });
          }
          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }
  const setStatusGandenganOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusgandengan]').empty()
      relatedForm.find('[name=statusgandengan]').append(
        new Option('-- PILIH STATUS GANDENGAN --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}parameter`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          filters: JSON.stringify({
            "groupOp": "AND",
            "rules": [{
              "field": "grp",
              "op": "cn",
              "data": "STATUS GANDENGAN"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusGandengan => {
            let option = new Option(statusGandengan.text, statusGandengan.id)
            statusLongtrip = statusGandengan.id
            if (statusGandengan.text == "TINGGAL GANDENGAN") {
              tinggalGandengan = statusGandengan.id
            }
            relatedForm.find('[name=statusgandengan]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  const setStatusUpahZonaOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusupahzona]').empty()
      relatedForm.find('[name=statusupahzona]').append(
        new Option('-- PILIH STATUS UPAH ZONA --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}parameter`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          filters: JSON.stringify({
            "groupOp": "AND",
            "rules": [{
              "field": "grp",
              "op": "cn",
              "data": "STATUS UPAH ZONA"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusUpahZona => {
            let option = new Option(statusUpahZona.text, statusUpahZona.id)
            if (statusUpahZona.text == "UPAH ZONA") {
              upahZona = statusUpahZona.id
            }
            relatedForm.find('[name=statusupahzona]').append(option).trigger('change')
          });
          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  const setStatusLongTripOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statuslongtrip]').empty()
      relatedForm.find('[name=statuslongtrip]').append(
        new Option('-- PILIH STATUS LONG TRIPS --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}parameter`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          filters: JSON.stringify({
            "groupOp": "AND",
            "rules": [{
              "field": "grp",
              "op": "cn",
              "data": "STATUS LONGTRIP"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusLongTrip => {
            let option = new Option(statusLongTrip.text, statusLongTrip.id)
            statusLongtrip = statusLongTrip.id
            if (statusLongTrip.text == 'LONGTRIP') {
              longTripId = statusLongTrip.id;
            }
            relatedForm.find('[name=statuslongtrip]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  const setStatusGudangSamaOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusgudangsama]').empty()
      relatedForm.find('[name=statusgudangsama]').append(
        new Option('-- PILIH STATUS GUDANG SAMA --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}parameter`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          filters: JSON.stringify({
            "groupOp": "AND",
            "rules": [{
              "field": "grp",
              "op": "cn",
              "data": "STATUS GUDANG SAMA"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusGudangSama => {
            let option = new Option(statusGudangSama.text, statusGudangSama.id)

            relatedForm.find('[name=statusgudangsama]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  const setStatusRitasi = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find(`[name="jenisritasi[]"]`).empty()
      relatedForm.find(`[name="jenisritasi[]"]`).append(
        new Option('-- PILIH JENIS RITASI --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}parameter/combo`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          grp: 'STATUS RITASI',
          subgrp: 'STATUS RITASI'
        },
        success: response => {
          response.data.forEach(jenisRitasi => {
            let option = new Option(jenisRitasi.text, jenisRitasi.id)

            relatedForm.find(`[name="jenisritasi[]"]`).append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  const setStatusLangsirOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statuslangsir]').empty()
      relatedForm.find('[name=statuslangsir]').append(
        new Option('-- PILIH STATUS LANGSIR --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}parameter`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          filters: JSON.stringify({
            "groupOp": "AND",
            "rules": [{
              "field": "grp",
              "op": "cn",
              "data": "STATUS LANGSIR"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusLangsir => {
            let option = new Option(statusLangsir.text, statusLangsir.id)

            relatedForm.find('[name=statuslangsir]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }


  function setIsDateAvailable(form) {
    $.ajax({
      url: `${apiUrl}suratpengantarapprovalinputtrip/cektanggal`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        let tglbukti = $('#crudForm').find(`[name="tglbukti"]`).parents('.input-group').children()
        if (response.data.length) {
          // $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
          tglbukti.attr('readonly', false);
          tglbukti.find('.ui-datepicker-trigger').attr('disabled', false)
        } else {
          tglbukti.attr('readonly', true);
          tglbukti.find('.ui-datepicker-trigger').attr('disabled', true)
        }

      }
    })
  }

  function clearTrado() {
    $('#crudForm [name=trado_id]').val('')
    $('#crudForm [name=supir_id]').val('')
    $('#crudForm [name=absensidetail_id]').val('')
    $('#crudForm [name=trado]').val('')
    $('#crudForm [name=trado]').data('currentValue', '')
    $('#infoTrado').html('')
    $('.tableInfo').hide()
  }

  function showDefault(form) {
    $.ajax({
      url: `${apiUrl}suratpengantar/default`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        containerId = 0
        jenisorderId = 0
        tradoId = 0
        gandenganId = 0
        pelangganId = 0
        taridrincianId = 0
        statusLongtrip = 0
        statuspelabuhan = '1'
        statusUpahZona = response.data.statusupahzona
        setJobReadOnly()



        $.each(response.data, (index, value) => {
          let element = form.find(`[name="${index}"]`)
          // let element = form.find(`[name="statusaktif"]`)

          if (element.is('select')) {
            element.val(value).trigger('change')
          } else if (element.hasClass('datepicker')) {
            element.val(dateFormat(value))
          } else {
            element.val(value)
          }
        })


      }
    })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}suratpengantar/field_length`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          'Authorization': `Bearer ${accessToken}`
        },
        success: response => {
          $.each(response.data, (index, value) => {
            if (value !== null && value !== 0 && value !== undefined) {
              form.find(`[name=${index}]`).attr('maxlength', value)
            }
          })

          form.attr('has-maxlength', true)
        },
        error: error => {
          showDialog(error.statusText)
        }
      })
    }
  }

  function getTarifOmset(id) {
    $.ajax({
      url: `${apiUrl}suratpengantar/${id}/getTarifOmset`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        'Authorization': `Bearer ${accessToken}`
      },
      success: response => {
        $('#crudForm [name=lokasibongkarmuat]').first().val(response.dataTarif.tujuan)
        $('#crudForm [name=hargaperton]').first().val(response.dataTarif.nominalton)
        // initAutoNumeric($('#crudForm ').find(`[name="omset"]`))
      },
      error: error => {
        showDialog(error.statusText)
      }
    })
  }

  function getInfoTrado(trado) {
    $.ajax({
      url: `${apiUrl}inputtrip/getinfo`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        'Authorization': `Bearer ${accessToken}`
      },
      data: {
        trado_id: $('#crudForm').find(`[name="trado_id"]`).val(),
        upah_id: $('#crudForm').find(`[name="upah_id"]`).val(),
        statuscontainer_id: $('#crudForm').find(`[name="statuscontainer_id"]`).val()
      },
      success: response => {
        if (response.data.length > 0) {

          $('.tableInfo').show()
          $('#infoTrado').html('')
          $.each(response.data, (index, detail) => {
            let detailRow = $(`
              <tr>
                <td> ${detail.status} </td>
                <td align="right"> ${numberWithCommas(detail.kmperjalanan)} </td>
                <td align="right"> ${numberWithCommas(detail.kmtotal)} </td>
                <input type="hidden" name="namastatus[]" value="${detail.status}">
                <input type="hidden" name="statusbatas[]" value="${detail.statusbatas}">
                <input type="hidden" name="jarak[]" value="${detail.jarak}">
              </tr>
            `)

            $('#infoTrado').append(detailRow)
          })
        }
      },
      error: error => {
        showDialog(error.statusText)
      }
    })
  }

  function getpelabuhan(id) {
    $.ajax({
      url: `${apiUrl}suratpengantar/${id}/getpelabuhan`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        'Authorization': `Bearer ${accessToken}`
      },
      success: response => {
        // console.log('test')
        // console.log(response.data.status)
        statuspelabuhan = response.data.status
        setJobReadOnly()

        // console.log(statustas)
      },
      error: error => {
        showDialog(error.statusText)
      }
    })
  }

  function setJobTruckingFromTripAsal() {

    let jobtrucking = $('#crudForm [name=jobtrucking]')
    jobtrucking.attr('readonly', true)
    jobtrucking.parents('.input-group').find('.input-group-append').hide()
    jobtrucking.parents('.input-group').find('.button-clear').hide()
  }

  function setJobReadOnly() {

    let jobtrucking = $('#crudForm [name=jobtrucking]')
    let labeljobtrucking = $('#crudForm [name=labeljobtrucking]')
    let longtrip = $('#crudForm [name=statuslongtrip]').val()
    let gudangsama = $('#crudForm [name=statusgudangsama]').val()
    if (longtrip != 66) {
      jobtrucking.attr('hidden', true)
      labeljobtrucking.attr('hidden', true)
      jobtrucking.parents('.input-group').find('.input-group-append').hide()
      jobtrucking.parents('.input-group').find('.button-clear').hide()
    } else if (gudangsama == 204) {

      jobtrucking.attr('hidden', true)
      labeljobtrucking.attr('hidden', true)
      jobtrucking.parents('.input-group').find('.input-group-append').hide()
      jobtrucking.parents('.input-group').find('.button-clear').hide()
    } else {
      if (statuspelabuhan == '0') {
        //bukan tas
        // console.log('bukan');
        jobtrucking.attr('hidden', true)
        labeljobtrucking.attr('hidden', true)
        jobtrucking.parents('.input-group').find('.input-group-append').hide()
        jobtrucking.parents('.input-group').find('.button-clear').hide()
      } else {
        //tas
        labeljobtrucking.attr('hidden', false)
        jobtrucking.attr('hidden', false)
        jobtrucking.parents('.input-group').find('.input-group-append').show()
        jobtrucking.parents('.input-group').find('.button-clear').show()
      }
    }
  }


  function clearTripAsal() {
    $('#crudForm [name=nobukti_tripasal]').val('')
    $('#crudForm [name=nobukti_tripasal]').data('currentValue', '')
    let statuslongtrip = $(`#crudForm [name="statuslongtrip"]`).val()
    let jenisorder_id = $('#crudForm [name=jenisorder_id]').val()
    let statuscontainer_id = $('#crudForm [name=statuscontainer_id]').val()
    if (statuslongtrip == 66) {
      if ((jenisorder_id == 2 && statuscontainer_id == 2) || (jenisorder_id == 3 && statuscontainer_id == 2) || (jenisorder_id == 1 && statuscontainer_id == 1) || (jenisorder_id == 4 && statuscontainer_id == 1)) {
        clearJobTrucking()
      }
    }
  }

  function clearJobTrucking() {
    $('#crudForm [name=jobtrucking]').val('')
    $('#crudForm [name=jobtrucking]').data('currentValue', '')
  }


  function initLookup() {
    $('.suratpengantar-lookup').lookup({
      title: 'Surat Pengantar Lookup',
      fileName: 'suratpengantar',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {
          Aktif: 'AKTIF',
          container_id: $('#crudForm [name=container_id]').val(),
          agen_id: $('#crudForm [name=agen_id]').val(),
          upah_id: $('#crudForm [name=upah_id]').val(),
          pelanggan_id: $('#crudForm [name=pelanggan_id]').val(),
          jenisorder_id: $('#crudForm [name=jenisorder_id]').val(),
          trado_id: $('#crudForm [name=trado_id]').val(),
          gudangsama: $('#crudForm [name=statusgudangsama]').val(),
          longtrip: $('#crudForm [name=statuslongtrip]').val(),
          isGudangSama: isGudangSama
        }
      },
      onSelectRow: (suratpengantar, element) => {
        element.val(suratpengantar.nobukti)
        element.data('currentValue', element.val())
        if ($('#crudForm [name=statusgudangsama]').val() == 205) {

          $('#crudForm [name=jobtrucking]').val(suratpengantar.jobtrucking)
          $('#crudForm [name=jobtrucking]').data('currentValue', suratpengantar.jobtrucking)
          setJobTruckingFromTripAsal()
        }
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.kotadari-lookup').lookup({
      title: 'Kota Dari Lookup',
      fileName: 'kotazona',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {
          Aktif: 'AKTIF',
          kotaZona: zonadariId
        }
      },
      onSelectRow: (kota, element) => {
        $('#crudForm [name=dari_id]').first().val(kota.id)
        pilihKotaDariId = kota.id
        getpelabuhan(kota.id)
        element.val(kota.keterangan)
        element.data('currentValue', element.val())
        // getGaji()
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=dari_id]').first().val('')
        pilihKotaDariId = 0
        element.val('')
        element.data('currentValue', element.val())
        // getGaji()
      }
    })

    $('.jobtrucking-lookup').lookup({
      title: 'Job Trucking Lookup',
      fileName: 'jobtrucking',
      beforeProcess: function(test) {

        this.postData = {
          jenisorder_id: jenisorderId,
          container_id: containerId,
          pelanggan_id: pelangganId,
          gandengan_id: gandenganId,
          trado_id: tradoId,
          statuslongtrip: statusLongtrip,
          tarif_id: tarifrincianId,
          tripasal: $('#crudForm [name=nobukti_tripasal]').val(),
          isPulangLongtrip: isPulangLongtrip
        }
      },
      onSelectRow: (jobtrucking, element) => {
        $('#crudForm [name=jobtrucking]').first().val(jobtrucking.jobtrucking)
        element.val(jobtrucking.jobtrucking)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=jobtrucking]').first().val('')
        element.val('')
        element.data('currentValue', element.val())

      }
    })

    $('.kotasampai-lookup').lookup({
      title: 'Kota Tujuan Lookup',
      fileName: 'kotazona',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
          kotaZona: zonasampaiId
        }
      },
      onSelectRow: (kota, element) => {
        $('#crudForm [name=sampai_id]').first().val(kota.id)
        pilihKotaSampaiId = kota.id
        element.val(kota.keterangan)
        element.data('currentValue', element.val())
        // getGaji()
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=sampai_id]').first().val('')

        pilihKotaSampaiId = 0
        element.val('')
        element.data('currentValue', element.val())
        // getGaji()
      }
    })

    $('.pelanggan-lookup').lookup({
      title: 'Shipper Lookup',
      fileName: 'pelanggan',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (pelanggan, element) => {
        $('#crudForm [name=pelanggan_id]').first().val(pelanggan.id)
        pelangganId = pelanggan.id

        element.val(pelanggan.namapelanggan)
        element.data('currentValue', element.val())
        clearTripAsal()
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        pelangganId = 0
        $('#crudForm [name=pelanggan_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
        clearTripAsal()
      }
    })

    $('.container-lookup').lookup({
      title: 'Container Lookup',
      fileName: 'container',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (container, element) => {
        $('#crudForm [name=container_id]').first().val(container.id)
        containerId = container.id
        element.val(container.keterangan)
        element.data('currentValue', element.val())
        enabledUpahSupir()
        clearTripAsal()
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
        enabledUpahSupir()
      },
      onClear: (element) => {
        containerId = 0
        $('#crudForm [name=container_id]').first().val('')
        $('#crudForm [name=upah_id]').val('')
        $('#crudForm [name=upah]').val('').data('currentValue', '')
        enabledUpahSupir()
        clearUpahSupir()
        clearTripAsal()
        element.val('')
        element.data('currentValue', element.val())
      }
    })


    $('.statuscontainer-lookup').lookup({
      title: 'Status Container Lookup',
      fileName: 'statuscontainer',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (statuscontainer, element) => {
        $('#crudForm [name=statuscontainer_id]').first().val(statuscontainer.id)
        statuscontainerId = statuscontainer.id
        kodeStatusContainer = statuscontainer.kodestatuscontainer
        element.val(statuscontainer.keterangan)
        element.data('currentValue', element.val())
        enabledUpahSupir()
        if (statuscontainer.kodestatuscontainer == 'FULL EMPTY') {
          let jobtrucking = $('#crudForm [name=jobtrucking]')
          let labeljobtrucking = $('#crudForm [name=labeljobtrucking]')
          jobtrucking.attr('hidden', true)
          labeljobtrucking.attr('hidden', true)
          jobtrucking.parents('.input-group').find('.input-group-append').hide()
          jobtrucking.parents('.input-group').find('.button-clear').hide()
          enableTripAsalLongTrip()
        } else {
          enableTripAsalLongTrip()
        }
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
        enabledUpahSupir()
      },
      onClear: (element) => {
        statuscontainerId = 0
        $('#crudForm [name=statuscontainer_id]').first().val('')
        $('#crudForm [name=upah_id]').val('')
        $('#crudForm [name=upah]').val('').data('currentValue', '')
        enabledUpahSupir()
        clearUpahSupir()
        element.val('')
        element.data('currentValue', element.val())
        isPulangLongtrip = false;
        clearTripAsal()
      }
    })

    $('.trado-lookup').lookup({
      title: 'Trado Lookup',
      fileName: 'trado',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (trado, element) => {
        $('#crudForm [name=trado_id]').first().val(trado.id)
        tradoId = trado.id

        element.val(trado.kodetrado)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        tradoId = 0
        $('#crudForm [name=trado_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.absensisupirdetail-lookup').lookup({
      title: 'Trado Lookup',
      fileName: 'absensisupirdetail',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {
          tgltrip: $('#crudForm [name=tglbukti]').val(),
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (absensi, element) => {
        $('#crudForm [name=trado_id]').first().val(absensi.trado_id)
        $('#crudForm [name=supir_id]').first().val(absensi.supir_id)
        $('#crudForm [name=absensidetail_id]').first().val(absensi.id)
        tradoId = absensi.trado_id
        element.val(absensi.tradosupir)
        element.data('currentValue', element.val())
        getInfoTrado(tradoId)
        clearTripAsal()
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        tradoId = 0
        $('#crudForm [name=trado_id]').first().val('')
        $('#crudForm [name=supir_id]').first().val('')
        $('#crudForm [name=absensidetail_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
        clearTripAsal()
        $('.tableInfo').hide()
      }
    })

    $('.gandengan-lookup').lookup({
      title: 'Gandengan Lookup',
      fileName: 'gandengan',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (gandengan, element) => {
        $('#crudForm [name=gandengan_id]').first().val(gandengan.id)
        if ($('#crudForm [name=gandenganasal_id]').val() == '') {
          gandenganId = gandengan.id
        }
        element.val(gandengan.keterangan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=gandengan_id]').first().val('')
        element.val('')
        if ($('#crudForm [name=gandenganasal_id]').val() == '') {
          gandenganId = 0
        }
        element.data('currentValue', element.val())
      }
    })
    $('.agen-lookup').lookup({
      title: 'Customer Lookup',
      fileName: 'agen',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
          Invoice: 'UTAMA',
        }
      },
      onSelectRow: (agen, element) => {
        $('#crudForm [name=agen_id]').first().val(agen.id)
        element.val(agen.namaagen)
        element.data('currentValue', element.val())
        clearTripAsal()
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=agen_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
        clearTripAsal()
      }
    })

    $('.jenisorder-lookup').lookup({
      title: 'Jenis Order Lookup',
      fileName: 'jenisorder',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (jenisorder, element) => {
        $('#crudForm [name=jenisorder_id]').first().val(jenisorder.id)
        jenisorderId = jenisorder.id
        element.val(jenisorder.keterangan)
        element.data('currentValue', element.val())
        enabledUpahSupir()
        if ($('#crudForm [name=statuscontainer_id]') != 3) {
          enableTripAsal()
          enableTripAsalLongTrip()
        }
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
        enabledUpahSupir()
      },
      onClear: (element) => {
        jenisorderId = 0
        $('#crudForm [name=jenisorder_id]').first().val('')
        $('#crudForm [name=upah_id]').val('')
        $('#crudForm [name=upah]').val('').data('currentValue', '')
        enabledUpahSupir()
        clearUpahSupir()
        element.val('')
        element.data('currentValue', element.val())
        isPulangLongtrip = false;
        clearTripAsal()
      }
    })

    $('.tarifrincian-lookup').lookup({
      title: 'Tarif Rincian Lookup',
      fileName: 'tarifrincian',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {
          Aktif: 'AKTIF',
          container_Id: containerId,
        }
      },
      onSelectRow: (tarifrincian, element) => {
        $('#crudForm [name=tarifrincian_id]').first().val(tarifrincian.id)
        $('#crudForm [name=penyesuaian]').val(tarifrincian.penyesuaian)
        tarifrincianId = tarifrincian.id
        element.val(tarifrincian.tujuan)
        element.data('currentValue', element.val())
        getTarifOmset(tarifrincian.id)
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        tarifrincianId = 0
        $('#crudForm [name=tarifrincian_id]').val('')
        $('#crudForm [name=omset]').first().val('')
        $('#crudForm [name=penyesuaian]').val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.upahsupirrincian-lookup').lookup({
      title: 'Upah Supir Lookup',
      fileName: 'upahsupirrincian',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {
          Aktif: 'AKTIF',
          container_Id: containerId,
          statuscontainer_Id: statuscontainerId,
          jenisorder_Id: jenisorderId,
          statusUpahZona: statusUpahZona,
          tglbukti: $('#crudForm [name=tglbukti]').val(),
          longtrip: $('#crudForm [name=statuslongtrip]').val()
        }
      },
      onSelectRow: (upahsupir, element) => {
        $('#crudForm [name=upah_id]').val(upahsupir.id)
        if (selectedUpahZona == 'NON UPAH ZONA') {

          $('#crudForm [name=tarifrincian_id]').val(upahsupir.tarif_id)
          $('#crudForm [name=tarifrincian]').val(upahsupir.tarif)
          $('#crudForm [name=penyesuaian]').val(upahsupir.penyesuaian)
          $('#crudForm [name=dari_id]').val(upahsupir.kotadari_id)
          $('#crudForm [name=dari]').val(upahsupir.kotadari)
          $('#crudForm [name=sampai_id]').val(upahsupir.kotasampai_id)
          $('#crudForm [name=sampai]').val(upahsupir.kotasampai)
          element.val(`${upahsupir.kotadari} - ${upahsupir.kotasampai}`)

          tarifrincianId = upahsupir.tarif_id
          if (kodeStatusContainer != 'FULL EMPTY') {
            getpelabuhan(upahsupir.kotadari_id)
          }
        } else {
          zonadariId = upahsupir.zonadari_id
          zonasampaiId = upahsupir.zonasampai_id

          element.val(`${upahsupir.zonadari} - ${upahsupir.zonasampai}`)
        }
        kotaUpahZona()

        element.data('currentValue', element.val())
        // clearTrado()
        getInfoTrado()
        clearTripAsal()
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
        // enabledKota()
      },
      onClear: (element) => {
        tarifrincianId = 0
        $('#crudForm [name=upah_id]').val('')
        clearUpahSupir()
        element.val('')
        element.data('currentValue', element.val())
        // clearTrado()
        clearTripAsal()
      }
    })

    $('.gandenganasal-lookup').lookup({
      title: 'Gandengan Asal Lookup',
      fileName: 'gandengan',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
          Asal: 'YA'
        }
      },
      onSelectRow: (gandengan, element) => {
        $('#crudForm [name=gandenganasal_id]').first().val(gandengan.id)
        gandenganId = gandengan.id

        element.val(gandengan.keterangan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=gandenganasal_id]').first().val('')
        if ($('#crudForm [name=gandengan_id]') != '') {
          gandenganId = $('#crudForm [name=gandengan_id]').val()
        } else {
          gandenganId = 0
        }
        element.val('')
        element.data('currentValue', element.val())
      }
    })

  }

  function clearUpahSupir() {

    $('#crudForm [name=upah_id]').val('')
    $('#crudForm [name=upah]').val('')
    $('#crudForm [name=upah]').data('currentValue', '')
    $('#crudForm [name=dari_id]').val('')
    $('#crudForm [name=sampai_id]').val('')
    $('#crudForm [name=dari]').val('')
    $('#crudForm [name=sampai]').val('')
    $('#crudForm [name=tarifrincian_id]').val('')
    $('#crudForm [name=tarifrincian]').val('')
    $('#crudForm [name=penyesuaian]').val('')
  }

  function getKotaRitasi(ritasiId, element, jenisritasi_id) {
    $.ajax({
      url: `${apiUrl}inputtrip/getKotaRitasi`,
      method: 'GET',
      dataType: 'JSON',
      data: {
        dataritasi_id: ritasiId
      },
      headers: {
        'Authorization': `Bearer ${accessToken}`
      },
      success: response => {
        if (response.data.length != 0) {
          element.parents('tr').find(`td [name="ritasidari_id[]"]`).val(response.data.dari_id)
          element.parents('tr').find(`td [name="ritasidari[]"]`).val(response.data.dari).data('currentValue', response.data.dari)
          element.parents('tr').find(`td [name="ritasike_id[]"]`).val(response.data.sampai_id)
          element.parents('tr').find(`td [name="ritasike[]"]`).val(response.data.sampai).data('currentValue', response.data.sampai)
        } else {


          let ritDari = element.parents('tr').find(`td [name="ritasidari[]"]`).parents('.input-group')
          ritDari.find('.button-clear').attr('disabled', false)
          ritDari.attr('readonly', false)
          ritDari.find('input').attr('readonly', false)
          ritDari.children().find('.lookup-toggler').attr('disabled', false)

          let ritKe = element.parents('tr').find(`td [name="ritasike[]"]`).parents('.input-group')
          ritKe.find('.button-clear').attr('disabled', false)
          ritKe.find('input').attr('readonly', false)
          ritKe.children().find('.lookup-toggler').attr('disabled', false)
        }
        dataRitasiId[jenisritasi_id] = ritasiId
        console.log(dataRitasiId)
      },
      error: error => {
        showDialog(error.statusText)
      }
    })

  }

  let index = 0;

  function addRow() {
    let detailRow = $(`
      <tr>
        <td></td>
        <td>
          <input type="hidden" name="jenisritasi_id[]" id="jenisritasi_id_${index}">
          <input type="text" name="jenisritasi[]" class="form-control dataritasi-lookup" id="jenisritasi_${index}">
        </td>
        <td>
          <input type="hidden" name="ritasidari_id[]">
          <input type="text" name="ritasidari[]" class="form-control ritasidari-lookup" readonly>
        </td>
        <td>
          <input type="hidden" name="ritasike_id[]">
          <input type="text" name="ritasike[]" class="form-control ritasike-lookup" readonly>
        </td>
        <td>
          <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
        </td>
      </tr>
    `)

    $('#ritasiList tbody').append(detailRow)
    // setStatusRitasi(detailRow)
    // initSelect2(detailRow.find(`[name="jenisritasi[]"]`), false)


    $(`.ritasidari-lookup`).last().lookup({
      title: 'RITASI DARI Lookup',
      fileName: 'kota',
      beforeProcess: function() {
        console.log(this)
        this.postData = {
          Aktif: 'AKTIF',
          DataRitasi: dataRitasiId[`jenisritasi_${index}`],
          RitasiDariKe: 'dari',
          pilihkota_id: pilihKotaSampaiId
        }
      },
      onSelectRow: (kota, element) => {
        element.parents('td').find(`[name="ritasidari_id[]"]`).val(kota.id)
        pilihKotaDariId = kota.id
        element.val(kota.kodekota)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.parents('td').find(`[name="ritasidari_id[]"]`).val('')
        pilihKotaDariId = 0
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $(`.ritasike-lookup`).last().lookup({
      title: 'RITASI KE Lookup',
      fileName: 'kota',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          DataRitasi: dataRitasiId[`jenisritasi_${index}`],
          RitasiDariKe: 'ke',
          pilihkota_id: pilihKotaDariId
        }
      },
      onSelectRow: (kota, element) => {
        element.parents('td').find(`[name="ritasike_id[]"]`).val(kota.id)
        pilihKotaSampaiId = kota.id
        element.val(kota.kodekota)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.parents('td').find(`[name="ritasike_id[]"]`).val('')
        pilihKotaSampaiId = 0
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.dataritasi-lookup').last().lookup({
      title: 'Data Ritasi Lookup',
      fileName: 'dataritasi',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (dataRitasi, element) => {
        element.parents('td').find(`[name="jenisritasi_id[]"]`).val(dataRitasi.id)
        element.val(dataRitasi.statusritasi)
        element.data('currentValue', element.val())
        getKotaRitasi(dataRitasi.statusritasi_id, element, element.attr("id"))
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.parents('td').find(`[name="jenisritasi_id[]"]`).val('')
        element.parents('tr').find(`td [name="ritasidari_id[]"]`).val('')
        element.parents('tr').find(`td [name="ritasidari[]"]`).val('').data('currentValue', '').attr("readonly", true)
        element.parents('tr').find(`td [name="ritasike_id[]"]`).val('')
        element.parents('tr').find(`td [name="ritasike[]"]`).val('').data('currentValue', '').attr("readonly", true)

        element.val('')
        element.data('currentValue', element.val())
        let ritDari = element.parents('tr').find(`td [name="ritasidari[]"]`).parents('.input-group')
        ritDari.find('.button-clear').attr('disabled', true)
        ritDari.children().find('.lookup-toggler').attr('disabled', true)

        let ritKe = element.parents('tr').find(`td [name="ritasike[]"]`).parents('.input-group')
        ritKe.find('.button-clear').attr('disabled', true)
        ritKe.children().find('.lookup-toggler').attr('disabled', true)

      }
    })

    let ritDari = detailRow.find(`[name="ritasidari[]"]`).parents('.input-group')
    ritDari.find('.button-clear').attr('disabled', true)
    ritDari.children().find('.lookup-toggler').attr('disabled', true)

    let ritKe = detailRow.find(`[name="ritasike[]"]`).parents('.input-group')
    ritKe.find('.button-clear').attr('disabled', true)
    ritKe.children().find('.lookup-toggler').attr('disabled', true)
    index++
    setRowNumbers()
  }

  function deleteRow(row) {
    let countRow = $('.delete-row').parents('tr').length
    row.remove()
    if (countRow <= 1) {
      addRow()
    }

    setRowNumbers()
    setTotal()
  }

  function setRowNumbers() {
    let elements = $('#ritasiList tbody tr td:nth-child(1)')

    elements.each((index, element) => {
      $(element).text(index + 1)
    })
  }

  function numberWithCommas(x) {
    return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
  }

  function enableTripAsal() {
    let statusgudangsama = $(`#crudForm [name="statusgudangsama"]`).val()
    let jenisorder_id = $('#crudForm [name=jenisorder_id]').val()
    if (statusgudangsama == 204) {
      if (isTripAsal) {
        if (jenisorder_id == 1 || jenisorder_id == 4) {
          $('.nobukti_tripasal').show()
          isGudangSama = true
        } else {
          $('.nobukti_tripasal').hide()
          clearTripAsal()
          isGudangSama = false
        }
      }
    } else {
      $('.nobukti_tripasal').hide()
      clearTripAsal()
      isGudangSama = false
    }
  }

  function enableTripAsalLongTrip() {
    let statuslongtrip = $(`#crudForm [name="statuslongtrip"]`).val()
    let jenisorder_id = $('#crudForm [name=jenisorder_id]').val()
    let statuscontainer_id = $('#crudForm [name=statuscontainer_id]').val()
    if (statuslongtrip == 66) {
      if ((jenisorder_id == 2 && statuscontainer_id == 2) || (jenisorder_id == 3 && statuscontainer_id == 2) || (jenisorder_id == 1 && statuscontainer_id == 1) || (jenisorder_id == 4 && statuscontainer_id == 1)) {
        $('.nobukti_tripasal').show()
        isPulangLongtrip = true;
      } else {
        $('.nobukti_tripasal').hide()
        clearTripAsal()
        isPulangLongtrip = false;
      }
    } else {
      $('.nobukti_tripasal').hide()
      clearTripAsal()
      isPulangLongtrip = false;
    }
  }
</script>
@endpush

@endsection