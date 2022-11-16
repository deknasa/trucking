<div class="modal fade modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="crudForm" enctype="multipart/form-data">
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
                  <div class="input-group">
                    <input type="text" class="form-control datepicker" name="tgllahir">
                  </div>
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
                <label for="staticEmail" class="col-sm-4 col-form-label">SUPIR LAMA</label>
                <div class="col-sm-8">
                  <input type="hidden" name="supirold_id">
                  <input type="text" name="supir" class="form-control supir-lookup">
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Masuk <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <div class="input-group">
                    <input type="text" class="form-control datepicker" name="tglmasuk">
                  </div>
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Terbit SIM<span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <div class="input-group">
                    <input type="text" class="form-control datepicker" name="tglterbitsim">
                  </div>
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Exp SIM <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <div class="input-group">
                    <input type="text" class="form-control datepicker" name="tglexpsim">
                  </div>
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">No SIM <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" name="nosim" id="nosim" class="form-control numbernoseparate">
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
                  <input type="text" name="noktp" id="noktp" class="form-control numbernoseparate">
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">No KK <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" name="nokk" id="nokk" class="form-control numbernoseparate">
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
                <label for="staticEmail" class="col-sm-4 col-form-label">STATUS ZONA TERTENTU <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="statuszonatertentu" class="form-select select2bs4" style="width: 100%;" z-index='3'>
                    <option value="">-- PILIH STATUS ZONA TERTENTU --</option>
                  </select>
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">STATUS LUAR KOTA <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="statusluarkota" class="form-select select2bs4" style="width: 100%;" z-index='3'>
                    <option value="">-- PILIH STATUS LUAR KOTA --</option>
                  </select>
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <div class="col-12 col-sm-4 col-form-label">
                  <label>
                    ZONA <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-sm-8">
                  <input type="hidden" name="zona_id">
                  <input type="text" name="zona" class="form-control zona-lookup">
                </div>
              </div>


              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label ">Angsuran Pinjaman</label>
                <div class="col-sm-8">
                  <input type="text" name="angsuranpinjaman" class="form-control autonumeric">
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label ">Plafon Deposito</label>
                <div class="col-sm-8">
                  <input type="text" name="plafondeposito" class="form-control autonumeric">
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Berhenti Supir</label>
                <div class="col-sm-8">
                  <div class="input-group">
                    <input type="text" class="form-control datepicker" name="tglberhentisupir">
                  </div>
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Keterangan Resign</label>
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
                <div class="dropzone" id="dropzonesupir" data-field="supir">
                  <div class="fallback">
                    <input name="photosupir" type="file" multiple />
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
                <div class="dropzone" id="dropzone-ktp" data-field="ktp">
                  <div class="fallback">
                    <input name="ktp" type="file" multiple />
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
                <div class="dropzone" id="dropzone-sim" data-field="sim">
                  <div class="fallback">
                    <input name="sim" type="file" multiple />
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
                <div class="dropzone" id="dropzone-kk" data-field="kk">
                  <div class="fallback">
                    <input name="kk" type="file" multiple />
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
                <div class="dropzone" id="dropzone-skck" data-field="skck">
                  <div class="fallback">
                    <input name="skck" type="file" multiple />
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
                <div class="dropzone" id="dropzone-domisili" data-field="domisili">
                  <div class="fallback">
                    <input name="domisili" type="file" multiple />
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
  let modalBody = $('#crudModal').find('.modal-body').html()
  let myDropzone
  let dropzoneAttachment = {
    photosupir: [],
    photoktp: [],
    photosim: [],
    photokk: [],
    photoskck: [],
    photodomisili: [],
  }
  $(document).ready(function() {


    $("#noktp").inputmask("9999999999999999", {
      placeholder: "",
    });
    $("#nosim").inputmask("999999999999", {
      placeholder: "",
    });
    $("#nokk").inputmask("9999999999999999", {
      placeholder: "",
    });

    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      console.log(dropzoneAttachment)

      let method
      let url
      let form = $('#crudForm')
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      // let data = $('#crudForm').serializeArray()
      let formData = new FormData()


      formData.append('id', form.find(`[name="id"]`).val())
      formData.append('namasupir', form.find(`[name="namasupir"]`).val())
      formData.append('tgllahir', form.find(`[name="tgllahir"]`).val())
      formData.append('alamat', form.find(`[name="alamat"]`).val())
      formData.append('kota', form.find(`[name="kota"]`).val())
      formData.append('telp', form.find(`[name="telp"]`).val())
      formData.append('statusaktif', form.find(`[name="statusaktif"]`).val())
      formData.append('nominaldepositsa', AutoNumeric.getNumber($(`#crudForm [name="nominaldepositsa"]`)[0]))
      formData.append('depositke', AutoNumeric.getNumber($(`#crudForm [name="depositke"]`)[0]))
      formData.append('nominalpinjamansaldoawal', AutoNumeric.getNumber($(`#crudForm [name="nominalpinjamansaldoawal"]`)[0]))
      formData.append('supirold_id', form.find(`[name="supirold_id"]`).val())
      formData.append('tglmasuk', form.find(`[name="tglmasuk"]`).val())
      formData.append('tglterbitsim', form.find(`[name="tglterbitsim"]`).val())
      formData.append('tglexpsim', form.find(`[name="tglexpsim"]`).val())
      formData.append('nosim', form.find(`[name="nosim"]`).val())
      formData.append('keterangan', form.find(`[name="keterangan"]`).val())
      formData.append('noktp', form.find(`[name="noktp"]`).val())
      formData.append('nokk', form.find(`[name="nokk"]`).val())
      formData.append('statusadaupdategambar', form.find(`[name="statusadaupdategambar"]`).val())
      formData.append('statuszonatertentu', form.find(`[name="statuszonatertentu"]`).val())
      formData.append('statusluarkota', form.find(`[name="statusluarkota"]`).val())
      formData.append('zona_id', form.find(`[name="zona_id"]`).val())
      formData.append('angsuranpinjaman', AutoNumeric.getNumber($(`#crudForm [name="angsuranpinjaman"]`)[0]))
      formData.append('plafondeposito', AutoNumeric.getNumber($(`#crudForm [name="plafondeposito"]`)[0]))
      formData.append('tglberhentisupir', form.find(`[name="tglberhentisupir"]`).val())
      formData.append('keteranganresign', form.find(`[name="keteranganresign"]`).val())
      formData.append('statusblacklist', form.find(`[name="statusblacklist"]`).val())

      $.each(dropzoneAttachment.photosupir, function(row) {
        formData.append('photosupir[]', dropzoneAttachment.photosupir[row])
      })
      $.each(dropzoneAttachment.photoktp, function(row, val) {
        formData.append('ktp[]', dropzoneAttachment.photoktp[row])
      })
      $.each(dropzoneAttachment.photosim, function(row, val) {
        formData.append('sim[]', dropzoneAttachment.photosim[row])
      })
      $.each(dropzoneAttachment.photokk, function(row, val) {
        formData.append('kk[]', dropzoneAttachment.photokk[row])
      })
      $.each(dropzoneAttachment.photoskck, function(row, val) {
        formData.append('skck[]', dropzoneAttachment.photoskck[row])
      })
      $.each(dropzoneAttachment.photodomisili, function(row, val) {
        formData.append('domisili[]', dropzoneAttachment.photodomisili[row])
      })

      // $('#crudForm').find(`[name="angsuranpinjaman"]`).each((index, element) => {
      //   data.filter((row) => row.name === 'angsuranpinjaman')[index].value = AutoNumeric.getNumber($(`#crudForm [name="angsuranpinjaman"]`)[index])
      // })

      // $('#crudForm').find(`[name="plafondeposito"]`).each((index, element) => {
      //   data.filter((row) => row.name === 'plafondeposito')[index].value = AutoNumeric.getNumber($(`#crudForm [name="plafondeposito"]`)[index])
      // })

      // $('#crudForm').find(`[name="nominalpinjamansaldoawal"]`).each((index, element) => {
      //   data.filter((row) => row.name === 'nominalpinjamansaldoawal')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominalpinjamansaldoawal"]`)[index])
      // })

      // $('#crudForm').find(`[name="nominaldepositsa"]`).each((index, element) => {
      //   data.filter((row) => row.name === 'nominaldepositsa')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominaldepositsa"]`)[index])
      // })

      // $('#crudForm').find(`[name="depositke"]`).each((index, element) => {
      //   data.filter((row) => row.name === 'depositke')[index].value = AutoNumeric.getNumber($(`#crudForm [name="depositke"]`)[index])
      // })


      formData.append('sortIndex', $('#jqGrid').getGridParam().sortname)
      formData.append('sortOrder', $('#jqGrid').getGridParam().sortorder)
      formData.append('filters', $('#jqGrid').getGridParam('postData').filters)
      formData.append('indexRow', indexRow)
      formData.append('page', page)
      formData.append('limit', limit)

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}supir`
          break;
        case 'edit':
          method = 'POST'
          formData.append('_method', 'PUT')
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
        // dataType: 'JSON',
        // enctype: 'multipart/form-data',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: formData,
        processData: false,
        contentType: false,
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

  $('#crudModal').on('shown.bs.modal', () => {
    let form = $('#crudForm')

    setFormBindKeys(form)

    activeGrid = null
    getMaxLength(form)
    initLookup()
    initDatepicker()
    initSelect2()
    // initDropzone(form.data('action'))
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'

    $('#crudModal').find('.modal-body').html(modalBody)
  })

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
    setStatusBlackListOptions(form)
    initDropzone(form.data('action'))

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
        setStatusBlackListOptions(form)
      ])
      .then(() => {
        showSupir(form, id)
        initDropzone(form.data('action'), id)
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
        setStatusBlackListOptions(form)
      ])
      .then(() => {
        showSupir(form, id)
        initDropzone(form.data('action'), id)
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
          } else if (element.hasClass('datepicker')) {
            element.val(dateFormat(value))
          } else {
            element.val(value)
          }

        })

        // initAutoNumeric(form.find(`[name="nominal"]`))
        // initAutoNumeric(form.find(`[name="nominalton"]`))

        if (form.data('action') === 'delete') {
          form.find('[name]').addClass('disabled')
          initDisabled()
        }
      }
    })
  }

  function initLookup() {

    $('.zona-lookup').lookup({
      title: 'Zona Lookup',
      fileName: 'zona',
      onSelectRow: (zona, element) => {
        $('#crudForm [name=zona_id]').first().val(zona.id)
        element.val(zona.keterangan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      }
    })

    $('.supir-lookup').lookup({
      title: 'Supir Lookup',
      fileName: 'supir',
      onSelectRow: (supir, element) => {
        $('#crudForm [name=supir_id]').first().val(supir.id)
        element.val(supir.namasupir)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      }
    })
  }


  function initDropzone(action, id = null) {

    const dropzones = []


    $('.dropzone').each(function(i, el) {
      const name = 'g_' + $(el).data('field');

      myDropzone = new Dropzone(el, {
        url: window.location.pathname,
        autoProcessQueue: false,
        uploadMultiple: true,
        parallelUploads: 100,
        maxFiles: 15,
        paramName: name,
        addRemoveLinks: true,
        acceptedFiles: "image/*",
        init: function() {
          let wrapperThis = this;

          // if(action == 'add') {
            this.on('addedfile', function(imageFile) {
              console.log(imageFile)
              if (el.id == 'dropzonesupir') {
                dropzoneAttachment.photosupir.push(imageFile)
              }
              if (el.id == 'dropzone-ktp') {
                dropzoneAttachment.photoktp.push(imageFile)
              }
              if (el.id == 'dropzone-sim') {
                dropzoneAttachment.photosim.push(imageFile)
              }
              if (el.id == 'dropzone-kk') {
                dropzoneAttachment.photokk.push(imageFile)
              }
              if (el.id == 'dropzone-skck') {
                dropzoneAttachment.photoskck.push(imageFile)
              }
              if (el.id == 'dropzone-domisili') {
                dropzoneAttachment.photodomisili.push(imageFile)
              }

            })
          // }
            
          

          this.on('removedfile', function(file) {
            // let key = file.upload.uuid;
            console.log(file.name)
            // console.log(dropzoneAttachment.photosupir.hasOwnProperty())
            // if (dropzoneAttachment.photosupir.hasOwnProperty(key) || dropzoneAttachment.ktp.hasOwnProperty(key) || dropzoneAttachment.sim.hasOwnProperty(key) || dropzoneAttachment.kk.hasOwnProperty(key) || dropzoneAttachment.skck.hasOwnProperty(key) || dropzoneAttachment.domisili.hasOwnProperty(key)) {
            //   delete dropzoneAttachment.photosupir[key];
            //   delete dropzoneAttachment.ktp[key];
            //   delete dropzoneAttachment.sim[key];
            //   delete dropzoneAttachment.kk[key];
            //   delete dropzoneAttachment.skck[key];
            //   delete dropzoneAttachment.domisili[key];
            // }
          })
          console.log(action)

          if (action == 'edit' || action == 'delete') {
            if (el.id == 'dropzonesupir') {
              $.ajax({
                url: `${apiUrl}supir/getImage/${id}/photosupir`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                  Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                  $.each(response.file, function(index, value) {

                    // console.log(value);
                    let imageFile = new File([{
                      name: `${response.base}/supir/${value.name}`,
                      size: value.size,
                      status: 'added',
                      upload: {
                        uuid: (Math.random() + 1).toString(36).substring(7)
                      }
                    }], value.name, {type: value.type})

                    newAdd = false
                    console.log(imageFile)
                    wrapperThis.emit("addedfile", imageFile);
                    wrapperThis.emit("thumbnail", imageFile, `${response.base}/supir/${value.name}`);
                    // wrapperThis.emit("complete", imageFile);
                    
                    // wrapperThis.options.addedfile.call(wrapperThis, imageFile);
                    // wrapperThis.options.thumbnail.call(wrapperThis, imageFile,  `${response.base}/${value.file}`);
                    // dropzoneAttachment.photosupir.push({
                    //   imageFile
                    // })
                    wrapperThis.files.push(imageFile);
                  })
                }
              })
            }

            if (el.id == 'dropzone-ktp') {
              $.ajax({
                url: `${apiUrl}supir/getImage/${id}/photoktp`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                  Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                  $.each(response.file, function(index, value) {
                    let imageFile = new File([{
                      name: `${response.base}/ktp/${value.name}`,
                      size: 15245,
                      status: 'added',
                      upload: {
                        uuid: (Math.random() + 1).toString(36).substring(7)
                      }
                    }], value.name, {type: value.type})

                    wrapperThis.emit("addedfile", imageFile);
                    wrapperThis.emit("thumbnail", imageFile, `${response.base}/ktp/${value.name}`);
                    // wrapperThis.emit("complete", imageFile);
                    // dropzoneAttachment.photo.push({
                    //   imageFile
                    // })
                    wrapperThis.files.push(imageFile);
                  })
                }
              })
            }
            if (el.id == 'dropzone-sim') {
              $.ajax({
                url: `${apiUrl}supir/getImage/${id}/photosim`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                  Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                  $.each(response.file, function(index, value) {
                    let imageFile = new File([{
                      name: `${response.base}/sim/${value.name}`,
                      size: 15245,
                      status: 'added',
                      upload: {
                        uuid: (Math.random() + 1).toString(36).substring(7)
                      }
                    }], value.name, {type: value.type})

                    wrapperThis.emit("addedfile", imageFile);
                    wrapperThis.emit("thumbnail", imageFile, `${response.base}/sim/${value.name}`);
                    // wrapperThis.emit("complete", imageFile);
                    wrapperThis.files.push(imageFile);
                  })
                }
              })
            }
            if (el.id == 'dropzone-kk') {
              $.ajax({
                url: `${apiUrl}supir/getImage/${id}/photokk`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                  Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                  $.each(response.file, function(index, value) {
                    let imageFile = new File([{
                      name: `${response.base}/kk/${value.name}`,
                      size: 15245,
                      status: 'added',
                      upload: {
                        uuid: (Math.random() + 1).toString(36).substring(7)
                      }
                    }], value.name, {type: value.type})

                    wrapperThis.emit("addedfile", imageFile);
                    wrapperThis.emit("thumbnail", imageFile, `${response.base}/kk/${value.name}`);
                    // wrapperThis.emit("complete", imageFile);
                    wrapperThis.files.push(imageFile);
                  })
                }
              })
            }
            if (el.id == 'dropzone-skck') {
              $.ajax({
                url: `${apiUrl}supir/getImage/${id}/photoskck`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                  Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                  $.each(response.file, function(index, value) {
                    let imageFile = new File([{
                      name: `${response.base}/skck/${value.name}`,
                      size: 15245,
                      status: 'added',
                      upload: {
                        uuid: (Math.random() + 1).toString(36).substring(7)
                      }
                    }], value.name, {type: value.type})

                    wrapperThis.emit("addedfile", imageFile);
                    wrapperThis.emit("thumbnail", imageFile, `${response.base}/skck/${value.name}`);
                    // wrapperThis.emit("complete", imageFile);
                    wrapperThis.files.push(imageFile);
                  })
                }
              })
            }
            if (el.id == 'dropzone-domisili') {
              $.ajax({
                url: `${apiUrl}supir/getImage/${id}/photodomisili`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                  Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                  $.each(response.file, function(index, value) {
                    let imageFile = new File([{
                      name: `${response.base}/domisili/${value.name}`,
                      size: 15245,
                      status: 'added',
                      upload: {
                        uuid: (Math.random() + 1).toString(36).substring(7)
                      }
                    }], value.name, {type: value.type})

                    wrapperThis.emit("addedfile", imageFile);
                    wrapperThis.emit("thumbnail", imageFile, `${response.base}/domisili/${value.name}`);
                    // wrapperThis.emit("complete", imageFile);
                    wrapperThis.files.push(imageFile);
                  })
                }
              })
            }

          }
        }
      })
      dropzones.push(myDropzone)
    })


  }
</script>
@endpush()