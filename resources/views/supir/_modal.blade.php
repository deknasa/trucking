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
                  <select name="statusaktif" class="form-control select2bs4" style="width: 100%;">
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
                  <select name="statusadaupdategambar" class="form-control select2bs4" style="width: 100%;">
                    <option value="">-- PILIH STATUS UPDATE GBR --</option>
                  </select>
                </div>
              </div>


              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">STATUS ZONA TERTENTU <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="statuszonatertentu" class="form-control select2bs4" style="width: 100%;" z-index='3'>
                    <option value="">-- PILIH STATUS ZONA TERTENTU --</option>
                  </select>
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">STATUS LUAR KOTA <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="statusluarkota" class="form-control select2bs4" style="width: 100%;" z-index='3'>
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
                  <select name="statusblacklist" class="form-control select2bs4" style="width: 100%;">
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
                </div>
                <div class="dropzone" data-field="photosupir">
                  <div class="fallback">
                    <input name="photosupir" type="file" />
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="row mb-2">
                  <div class="col">
                    <label class="col-form-label">Upload Foto KTP</label>
                  </div>
                </div>
                <div class="dropzone" data-field="photoktp">
                  <div class="fallback">
                    <input name="photoktp" type="file" />
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="row mb-2">
                  <div class="col">
                    <label class="col-form-label">Upload Foto SIM</label>
                  </div>
                </div>
                <div class="dropzone" data-field="photosim">
                  <div class="fallback">
                    <input name="photosim" type="file" />
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
                </div>
                <div class="dropzone" data-field="photokk">
                  <div class="fallback">
                    <input name="photokk" type="file" />
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="row mb-2">
                  <div class="col">
                    <label class="col-form-label">Upload Foto SKCK</label>
                  </div>
                </div>
                <div class="dropzone" data-field="photoskck">
                  <div class="fallback">
                    <input name="photoskck" type="file" />
                  </div>
                </div>
              </div>

              <div class="col-md-4">
                <div class="row mb-2">
                  <div class="col">
                    <label class="col-form-label">Upload Foto Domisili</label>
                  </div>
                </div>
                <div class="dropzone" data-field="photodomisili">
                  <div class="fallback">
                    <input name="photodomisili" type="file" />
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
  Dropzone.autoDiscover = false

  let dropzones = []
  let hasFormBindKeys = false
  let modalBody = $('#crudModal').find('.modal-body').html()

  $(document).ready(function() {
    $(document).on('click', '#btnSubmit', function(event) {
      event.preventDefault()
      // AutoNumeric.getNumber($(`#crudForm [name="nominaldepositsa"]`)[0])

      let form = $('#crudForm')

      let formData = new FormData(form[0])
      let id = form.find('[name=id]').val()
      let url

      dropzones.forEach(dropzone => {
        const {
          paramName
        } = dropzone.options

        dropzone.files.forEach((file, index) => {
          formData.append(`${paramName}[${index}]`, file)
        })
      })

      formData.append('sortIndex', $('#jqGrid').getGridParam().sortname)
      formData.append('sortOrder', $('#jqGrid').getGridParam().sortorder)
      formData.append('filters', $('#jqGrid').getGridParam('postData').filters)
      formData.append('indexRow', indexRow)
      formData.append('page', page)
      formData.append('limit', limit)

      if (form.data('action') == 'add') {
        url = `${apiUrl}supir`
      } else if (form.data('action') == 'edit') {
        url = `${apiUrl}supir/${id}`
        formData.append('_method', 'PATCH')
      } else if (form.data('action') == 'delete') {
        url = `${apiUrl}supir/${id}`
        formData.append('_method', 'DELETE')
      }

      $(this).attr('disabled', '')
      $('#loader').removeClass('d-none')

      $.ajax({
        url: url,
        method: 'POST',
        dataType: 'JSON',
        processData: false,
        contentType: false,
        data: formData,
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $('#crudForm').trigger('reset')
          $('#crudModal').modal('hide')

          id = response.data.id

          $('#jqGrid').jqGrid('setGridParam', {
            page: response.data.page
          }).trigger('reloadGrid');

          dropzones.forEach(dropzone => {
            dropzone.removeAllFiles()
          })
        },
        error: error => {
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            setErrorMessages(form, error.responseJSON.errors);
          }
        }
      }).always(() => {
        $('#loader').addClass('d-none')
        $(this).removeAttr('disabled')
      })
    })
  })

  function createSupir() {
    let form = $('#crudForm')

    form.find('[name]').removeAttr('disabled')
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

    setFormBindKeys(form)
    initDropzone(form.data('action'))
    initLookup()
    initDatepicker()
    initSelect2()
    form.find('[name]').removeAttr('disabled')
  }

  function editSupir(id) {
    let form = $('#crudForm')

    form.find('[name]').removeAttr('disabled')
    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
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
          .then(supir => {
            setFormBindKeys(form)
            initDropzone(form.data('action'), supir)
            initLookup()
            initDatepicker()
            initSelect2()
            form.find('[name]').removeAttr('disabled')
          })
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
          .then(supir => {
            setFormBindKeys(form)
            initDropzone(form.data('action'), supir)

            form.find('select').each((index, select) => {
              let element = $(select)

              if (element.data('select2')) {
                element.select2('destroy')
              }
            })

            form.find('[name]').attr('disabled', 'disabled').css({
              background: '#fff'
            })
          })
      })
  }

  const showSupir = function(form, id) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}supir/${id}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`).not(':file')

            if (element.is('select')) {
              element.val(value).trigger('change')
            } else if (element.hasClass('datepicker')) {
              element.val(dateFormat(value))
            } else {
              element.val(value)
            }
          })

          resolve(response.data)
        }
      })
    })
  }

  function initLookup() {
    if (!$('.zona-lookup').data('hasLookup')) {
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
    }

    if (!$('.supir-lookup').data('hasLookup')) {
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
  }

  function initDropzone(action, data = null) {
    $('.dropzone').each((index, element) => {
      if (!element.dropzone) {
        let newDropzone = new Dropzone(element, {
          url: 'test',
          autoProcessQueue: false,
          addRemoveLinks: true,
          acceptedFiles: 'image/*',
          paramName: $(element).data('field'),
          init: function() {
            dropzones.push(this)
          }
        })
      }

      element.dropzone.removeAllFiles()

      if (action == 'edit' || action == 'delete') {
        assignAttachment(element.dropzone, data)
      }
    })
  }

  function assignAttachment(dropzone, data) {
    const paramName = dropzone.options.paramName
    const type = paramName.substring(5)

    let files = JSON.parse(data[paramName])

    files.forEach((file) => {
      getImgURL(`${apiUrl}supir/image/${type}/${file}/ori`, (fileBlob) => {
        let imageFile = new File([fileBlob], file, {
          type: 'image/jpeg',
          lastModified: new Date().getTime()
        }, 'utf-8')

        dropzone.options.addedfile.call(dropzone, imageFile);
        dropzone.options.thumbnail.call(dropzone, imageFile, `${apiUrl}supir/image/${type}/${file}/ori`);
        dropzone.files.push(imageFile)
      })
    })
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

  function getImgURL(url, callback) {
    var xhr = new XMLHttpRequest();
    xhr.onload = function() {
      console.log(xhr.response);
      callback(xhr.response);
    };
    xhr.open('GET', url);
    xhr.responseType = 'blob';
    xhr.send();
  }
</script>
@endpush()