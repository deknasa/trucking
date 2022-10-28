<div class="modal fade modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="crudForm">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title" id="crudModalTitle"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" method="post">
          <div class="modal-body">
            <input type="hidden" name="id">

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Nama Supir <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" name="namasupir" class="form-control">
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Lahir <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control datepicker" name="tgllahir">
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Alamat <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" name="alamat" class="form-control">
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Kota <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" name="kota" class="form-control">
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Telp <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" name="telp" class="form-control numbernoseparate">
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">STATUS AKTIF <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="statusaktif" class="form-select select2bs4" style="width: 100%;">
                    <option value="">-- PILIH STATUS AKTIF --</option>
                  </select>
                </div>
              </div>


              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Nominal Deposit SA</label>
                <div class="col-sm-8">
                  <input type="text" name="nominaldepositsa" class="form-control autonumeric">
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Deposit Ke</label>
                <div class="col-sm-8">
                  <input type="text" name="depositke" class="form-control autonumeric">
                </div>
              </div>



              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Nominal Pinjaman</label>
                <div class="col-sm-8">
                  <input type="text" name="nominalpinjamansaldoawal" class="form-control autonumeric">
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">SUPIR LAMA <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="supirold_id" class="form-select select2bs4" style="width: 100%;">
                    <option value="">-- PILIH SUPIR LAMA --</option>
                  </select>
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Terbit SIM<span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control datepicker" name="tglterbitsim">
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Exp SIM <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control datepicker" name="tglexpsim">
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">No SIM <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" name="nosim" class="form-control numbernoseparate">
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Keterangan <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" name="keterangan" class="form-control">
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">No KTP <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" name="noktp" class="form-control numbernoseparate">
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">No KK <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" name="nokk" class="form-control numbernoseparate">
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">STATUS UPDATE GBR <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="statusadaupdategambar" class="form-select select2bs4" style="width: 100%;">
                    <option value="">-- PILIH STATUS UPDATE GBR --</option>
                  </select>
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">STATUS LUAR KOTA <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="statusluarkota" class="form-select select2bs4" style="width: 100%;">
                    <option value="">-- PILIH STATUS LUAR KOTA --</option>
                  </select>
                </div>
              </div>

              <!-- <div class="form-group col-sm-6 row">
                <div class="col-12 col-sm-3 col-md-2 col-form-label">
                  <label>
                    ZONA <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-8 col-md-10">
                  <input type="hidden" name="zona_id">
                  <input type="text" name="zona" class="form-control zona-lookup">
                </div>
            </div> -->

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">ZONA <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="zona_id" class="form-select select2bs4" style="width: 100%;">
                    <option value="">-- PILIH ZONA --</option>
                  </select>
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label ">Angsuran Pinjaman <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" name="angsuranpinjaman" class="form-control autonumeric">
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label ">Plafon Deposito <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" name="plafondeposito" class="form-control autonumeric">
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Berhenti Supir <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control datepicker" name="tglberhentisupir">
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Keterangan Resign <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" name="keteranganresign" class="form-control">
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">STATUS BLACKLIST <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="statusblacklist" class="form-select select2bs4" style="width: 100%;">
                    <option value="">-- PILIH STATUS BLACKLIST --</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row p-2">
              <div class="col-md-4">
                <div class="row mb-2">
                  <div class="col">
                    <label class="col-form-label">Upload Foto Supir</label>
                  </div>
                  <div class="col text-right">
                    <button class="btn btn-info btn-sm" id="photosupir" type="button">Upload Supir</button>
                  </div>
                </div>
                <div class="dropzone" id="my-dropzone" data-field="supir">
                  <div class="fallback">
                    <!-- <input name="file" type="file" /> -->
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="row mb-2">
                  <div class="col">
                    <label class="col-form-label">Upload Foto KTP</label>
                  </div>
                  <div class="col text-right">
                    <button class="btn btn-info btn-sm" type="button" id="uploadBpkb">Upload KTP</button>
                  </div>
                </div>
                <div class="dropzone" id="my-dropzoness" data-field="ktp">
                  <div class="fallback">
                    <input name="file" type="file" />
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="row mb-2">
                  <div class="col">
                    <label class="col-form-label">Upload Foto SIM</label>
                  </div>
                  <div class="col text-right">
                    <button class="btn btn-info btn-sm" type="button">Upload SIM</button>
                  </div>
                </div>
                <div class="dropzone" id="dropzonestnk" data-field="sim">
                  <div class="fallback">
                    <input name="file" type="file" />
                  </div>
                </div>
              </div>
            </div>

            <div class="row p-2">
              <div class="col-md-4">
                <div class="row mb-2">
                  <div class="col">
                    <label class="col-form-label">Upload Foto KK</label>
                  </div>
                  <div class="col text-right">
                    <button class="btn btn-info btn-sm" id="uploadsupir" type="button">Upload KK</button>
                  </div>
                </div>
                <div class="dropzone" id="my-dropzone" data-field="kk">
                  <div class="fallback">
                    <input name="file" type="file" />
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="row mb-2">
                  <div class="col">
                    <label class="col-form-label">Upload Foto SKCK</label>
                  </div>
                  <div class="col text-right">
                    <button class="btn btn-info btn-sm" type="button" id="uploadBpkb">Upload SKCK</button>
                  </div>
                </div>
                <div class="dropzone" id="my-dropzoness" data-field="skck">
                  <div class="fallback">
                    <input name="file" type="file" />
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="row mb-2">
                  <div class="col">
                    <label class="col-form-label">Upload Foto Domisili</label>
                  </div>
                  <div class="col text-right">
                    <button class="btn btn-info btn-sm" type="button">Upload Domisili</button>
                  </div>
                </div>
                <div class="dropzone" id="dropzonestnk" data-field="domisili">
                  <div class="fallback">
                    <input name="file" type="file" />
                  </div>
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-start">
              <button id="btnSubmit" class="btn btn-primary">
                <i class="fa fa-save"></i>
                Simpan
              </button>
              <button class="btn btn-secondary" data-dismiss="modal">
                <i class="fa fa-times"></i>
                Batal
              </button>
            </div>
          </div>
        </form>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
  let hasFormBindKeys = false
  Dropzone.autoDiscover = false;

  $(document).ready(function() {
    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()


      $('#crudForm').find(`[name="angsuranpinjaman"]`).each((index, element) => {
        data.filter((row) => row.name === 'angsuranpinjaman')[index].value = AutoNumeric.getNumber($(`#crudForm [name="angsuranpinjaman"]`)[index])
      })

      $('#crudForm').find(`[name="plafondeposito"]`).each((index, element) => {
        data.filter((row) => row.name === 'plafondeposito')[index].value = AutoNumeric.getNumber($(`#crudForm [name="plafondeposito"]`)[index])
      })

      $('#crudForm').find(`[name="nominalpinjamansaldoawal"]`).each((index, element) => {
        data.filter((row) => row.name === 'nominalpinjamansaldoawal')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominalpinjamansaldoawal"]`)[index])
      })

      $('#crudForm').find(`[name="nominaldepositsa"]`).each((index, element) => {
        data.filter((row) => row.name === 'nominaldepositsa')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominaldepositsa"]`)[index])
      })

      $('#crudForm').find(`[name="depositke"]`).each((index, element) => {
        data.filter((row) => row.name === 'depositke')[index].value = AutoNumeric.getNumber($(`#crudForm [name="depositke"]`)[index])
      })


      data.push({
        name: 'sortIndex',
        value: $('#jqGrid').getGridParam().sortname
      })
      data.push({
        name: 'sortOrder',
        value: $('#jqGrid').getGridParam().sortorder
      })
      data.push({
        name: 'filters',
        value: $('#jqGrid').getGridParam('postData').filters
      })
      data.push({
        name: 'indexRow',
        value: indexRow
      })
      data.push({
        name: 'page',
        value: page
      })
      data.push({
        name: 'limit',
        value: limit
      })

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}supir`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}supir/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}supir/${Id}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}supir`
          break;
      }

      $(this).attr('disabled', '')
      $('#loader').removeClass('d-none')

      $.ajax({
        url: url,
        method: method,
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: data,
        success: response => {
          $('#crudForm').trigger('reset')
          $('#crudModal').modal('hide')

          id = response.data.id

          $('#jqGrid').trigger('reloadGrid', {
            page: response.data.page
          })

          if (response.data.grp == 'FORMAT') {
            updateFormat(response.data)
          }
        },
        error: error => {
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            setErrorMessages(form, error.responseJSON.errors);
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

  $('#crudModal').on('shown.bs.modal', function() {
    let form = $(this).find('#crudForm')

    initDropzone(form.data('action'))
  })

  // $('#crudModal').on('shown.bs.modal', () => {
  //   let form = $('#crudForm')

  //   setFormBindKeys(form)

  //   activeGrid = null

  //   getMaxLength(form)
  //   // initLookup()
  // })

  // $('#crudModal').on('hidden.bs.modal', () => {
  //   activeGrid = '#jqGrid'
  // })

  function createSupir() {
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create Supir')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    setStatusAktifOptions(form)
    setSupirLamaOptions(form)
    setStatusAdaUpdateGambarOptions(form)
    setStatusLuarKotaOptions(form)
    setStatusZonaTertentuOptions(form)
    setZonaOptions(form)
    setStatusBlackListOptions(form)
  }

  function editSupir(id) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    // form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Supir')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusAktifOptions(form),
        setSupirLamaOptions(form),
        setStatusAdaUpdateGambarOptions(form),
        setStatusLuarKotaOptions(form),
        setStatusZonaTertentuOptions(form),
        setZonaOptions(form),
        setStatusBlackListOptions(form)
      ])
      .then(() => {
        showSupir(form, id)
      })
  }

  function deleteSupir(id) {
    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Supir')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusAktifOptions(form),
        setSupirLamaOptions(form),
        setStatusAdaUpdateGambarOptions(form),
        setStatusLuarKotaOptions(form),
        setStatusZonaTertentuOptions(form),
        setZonaOptions(form),
        setStatusBlackListOptions(form)
      ])
      .then(() => {
        showSupir(form, id)
      })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}supir/field_length`,
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

  const setSupirLamaOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=supirold_id]').empty()
      relatedForm.find('[name=supirold_id]').append(
        new Option('-- PILIH SUPIR LAMA --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}supir`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          limit: 0,
        },
        success: response => {
          response.data.forEach(supir => {
            let option = new Option(supir.namasupir, supir.id)

            relatedForm.find('[name=supirold_id]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  const setZonaOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=zona_id]').empty()
      relatedForm.find('[name=zona_id]').append(
        new Option('-- PILIH ZONA --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}zona`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          limit: 0,
        },
        success: response => {
          response.data.forEach(zona => {
            let option = new Option(zona.keterangan, zona.id)

            relatedForm.find('[name=zona_id]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  const setStatusBlackListOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusblacklist]').empty()
      relatedForm.find('[name=statusblacklist]').append(
        new Option('-- PILIH STATUS BLACKLIST --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}parameter`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          limit: 0,
          filters: JSON.stringify({
            "groupOp": "AND",
            "rules": [{
              "field": "grp",
              "op": "cn",
              "data": "BLACKLIST SUPIR"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusBlackList => {
            let option = new Option(statusBlackList.text, statusBlackList.id)

            relatedForm.find('[name=statusblacklist]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  const setStatusZonaTertentuOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statuszonatertentu]').empty()
      relatedForm.find('[name=statuszonatertentu]').append(
        new Option('-- PILIH STATUS ZONA TERTENTU --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}parameter`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          limit: 0,
          filters: JSON.stringify({
            "groupOp": "AND",
            "rules": [{
              "field": "grp",
              "op": "cn",
              "data": "ZONA TERTENTU"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusZonaTertentu => {
            let option = new Option(statusZonaTertentu.text, statusZonaTertentu.id)

            relatedForm.find('[name=statuszonatertentu]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  const setStatusLuarKotaOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusluarkota]').empty()
      relatedForm.find('[name=statusluarkota]').append(
        new Option('-- PILIH STATUS LUAR KOTA --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}parameter`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          limit: 0,
          filters: JSON.stringify({
            "groupOp": "AND",
            "rules": [{
              "field": "grp",
              "op": "cn",
              "data": "STATUS LUAR KOTA"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusLuarKota => {
            let option = new Option(statusLuarKota.text, statusLuarKota.id)

            relatedForm.find('[name=statusluarkota]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  const setStatusAdaUpdateGambarOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusadaupdategambar]').empty()
      relatedForm.find('[name=statusadaupdategambar]').append(
        new Option('-- PILIH STATUS ADA UPDATE GAMBAR --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}parameter`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          limit: 0,
          filters: JSON.stringify({
            "groupOp": "AND",
            "rules": [{
              "field": "grp",
              "op": "cn",
              "data": "STATUS ADA UPDATE GAMBAR"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusAdaUpdateGambar => {
            let option = new Option(statusAdaUpdateGambar.text, statusAdaUpdateGambar.id)

            relatedForm.find('[name=statusadaupdategambar]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  const setStatusAktifOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusaktif]').empty()
      relatedForm.find('[name=statusaktif]').append(
        new Option('-- PILIH STATUS AKTIF --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}parameter`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          limit: 0,
          filters: JSON.stringify({
            "groupOp": "AND",
            "rules": [{
              "field": "grp",
              "op": "cn",
              "data": "STATUS AKTIF"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusAktif => {
            let option = new Option(statusAktif.text, statusAktif.id)

            relatedForm.find('[name=statusaktif]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  function showSupir(form, id) {
    $.ajax({
      url: `${apiUrl}supir/${id}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        $.each(response.data, (index, value) => {
          let element = form.find(`[name="${index}"]`)

          if (element.is('select')) {
            element.val(value).trigger('change')
          } else if (element.hasClass('autonumeric')) {
            let autoNumericInput = AutoNumeric.getAutoNumericElement(element[0])
            
            autoNumericInput.set(value);
          } else {
            element.val(value)
          }
        })
      }
    })
  }

  function initDropzone(action) {
    let attachArray = {
      'supir': {},
      'ktp': {},
      'sim': {},
      'kk': {},
      'skck': {},
      'domisili': {}
    };

    const dropzones = []

    $('.dropzone').each(function(i, el) {
      const name = 'g_' + $(el).data('field');
      let myDropzone = new Dropzone(el, {
        url: window.location.pathname,
        autoProcessQueue: false,
        uploadMultiple: true,
        parallelUploads: 100,
        maxFiles: 100,
        paramName: name,
        addRemoveLinks: true,
        acceptedFiles: "image/*",
        init: function() {
          let wrapperThis = this;

          this.on('removedfile', function(file) {
            let key = file.upload.uuid;
            if (attachArray.supir.hasOwnProperty(key) || attachArray.ktp.hasOwnProperty(key) || attachArray.sim.hasOwnProperty(key) || attachArray.kk.hasOwnProperty(key) || attachArray.skck.hasOwnProperty(key) || attachArray.domisili.hasOwnProperty(key)) {
              delete attachArray.supir[key];
              delete attachArray.ktp[key];
              delete attachArray.sim[key];
              delete attachArray.kk[key];
              delete attachArray.skck[key];
              delete attachArray.domisili[key];
            }
          })

          if (action == 'edit' || action == 'delete') {
            let imgsupir = {}
            let imgktp = {}
            let imgsim = {}
            let imgkk = {}
            let imgskck = {}
            let imgdomisili = {}

            if (Object.keys(imgsupir).length > 0) {
              let total = Object.keys(imgsupir).length / 3;
              let idx = 0;
              for (let i = 1; i <= total; i++) {
                if (i > 1) {
                  idx += 3;
                }

                let obj = {
                  name: imgsupir[idx],
                  size: 12345,
                  upload: {
                    uuid: (Math.random() + 1).toString(36).substring(7)
                  }
                };

                if (name == 'g_supir') {
                  wrapperThis.emit("addedfile", obj);
                  wrapperThis.emit("thumbnail", obj, `${api}/uploads/supir/${imgsupir[idx]}`);

                  wrapperThis.emit("complete", obj);
                  wrapperThis.files.push(obj);
                  attachArray.supir[obj.upload.uuid] = imgsupir[idx];
                }
              }
            }

            if (Object.keys(imgktp).length > 0) {
              let total = Object.keys(imgktp).length / 3;
              let idx = 0;
              for (let i = 1; i <= total; i++) {
                if (i > 1) {
                  idx += 3;
                }

                let obj = {
                  name: imgktp[idx],
                  size: 12345,
                  upload: {
                    uuid: (Math.random() + 1).toString(36).substring(7)
                  }
                };

                if (name == 'g_ktp') {
                  wrapperThis.emit("addedfile", obj);
                  wrapperThis.emit("thumbnail", obj, `${api}/uploads/ktp/${imgktp[idx]}`);
                  wrapperThis.emit("complete", obj);
                  wrapperThis.files.push(obj);
                  attachArray.ktp[obj.upload.uuid] = imgktp[idx];
                }
              }
            }

            if (Object.keys(imgsim).length > 0) {
              let total = Object.keys(imgsim).length / 3;
              let idx = 0;
              for (let i = 1; i <= total; i++) {
                if (i > 1) {
                  idx += 3;
                }

                let obj = {
                  name: imgsim[idx],
                  size: 12345,
                  upload: {
                    uuid: (Math.random() + 1).toString(36).substring(7)
                  }
                };

                if (name == 'g_sim') {
                  wrapperThis.emit("addedfile", obj);
                  wrapperThis.emit("thumbnail", obj, `${api}/uploads/sim/${imgsim[idx]}`);
                  wrapperThis.emit("complete", obj);
                  wrapperThis.files.push(obj);
                  attachArray.sim[obj.upload.uuid] = imgsim[idx];
                }
              }
            }

            if (Object.keys(imgkk).length > 0) {
              let total = Object.keys(imgkk).length / 3;
              let idx = 0;
              for (let i = 1; i <= total; i++) {
                if (i > 1) {
                  idx += 3;
                }

                let obj = {
                  name: imgkk[idx],
                  size: 12345,
                  upload: {
                    uuid: (Math.random() + 1).toString(36).substring(7)
                  }
                };

                if (name == 'g_kk') {
                  wrapperThis.emit("addedfile", obj);
                  wrapperThis.emit("thumbnail", obj, `${api}/uploads/kk/${imgkk[idx]}`);
                  wrapperThis.emit("complete", obj);
                  wrapperThis.files.push(obj);
                  attachArray.kk[obj.upload.uuid] = imgkk[idx];
                }
              }
            }

            if (Object.keys(imgskck).length > 0) {
              let total = Object.keys(imgskck).length / 3;
              let idx = 0;
              for (let i = 1; i <= total; i++) {
                if (i > 1) {
                  idx += 3;
                }

                let obj = {
                  name: imgskck[idx],
                  size: 12345,
                  upload: {
                    uuid: (Math.random() + 1).toString(36).substring(7)
                  }
                };

                if (name == 'g_skck') {
                  wrapperThis.emit("addedfile", obj);
                  wrapperThis.emit("thumbnail", obj, `${api}/uploads/skck/${imgskck[idx]}`);
                  wrapperThis.emit("complete", obj);
                  wrapperThis.files.push(obj);
                  attachArray.skck[obj.upload.uuid] = imgskck[idx];
                }
              }
            }

            if (Object.keys(imgdomisili).length > 0) {
              let total = Object.keys(imgdomisili).length / 3;
              let idx = 0;
              for (let i = 1; i <= total; i++) {
                if (i > 1) {
                  idx += 3;
                }

                let obj = {
                  name: imgdomisili[idx],
                  size: 12345,
                  upload: {
                    uuid: (Math.random() + 1).toString(36).substring(7)
                  }
                };

                if (name == 'g_domisili') {
                  wrapperThis.emit("addedfile", obj);
                  wrapperThis.emit("thumbnail", obj, `${api}/uploads/domisili/${imgdomisili[idx]}`);
                  wrapperThis.emit("complete", obj);
                  wrapperThis.files.push(obj);
                  attachArray.domisili[obj.upload.uuid] = imgdomisili[idx];
                }
              }
            }
          }
        }
      })
      dropzones.push(myDropzone)
    })

    // ctionction initLookup() {
    //   $('.zona-lookup').lookup({
    //     title: 'zona Lookup',
    //     fileName: 'zona',
    //     onSelectRow: (zona, element) => {
    //       $('#crudForm [name=zona_id]').first().val(zona.id)
    //       element.val(zona.zona)
    //       element.data('currentValue', element.val())
    //     },
    //     onCancel: (element) => {
    //       element.val(element.data('currentValue'))
    //     }
    //   })
    // }
  }
</script>
@endpush()