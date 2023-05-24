<div class="modal modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="crudForm" enctype="multipart/form-data">
      <div class="modal-content">
        <div class="modal-header">
          <p class="modal-title" id="crudModalTitle"></p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          </button>
        </div>
        <form action="" method="post">
          <div class="modal-body">

            <input type="hidden" name="id">
            <div class="row">
              <div class="form-group col-sm-6 row">
                <label class="col-sm-4 col-form-label">Keterangan</label>
                <div class="col-sm-8">
                  <input type="text" name="keterangan" class="form-control">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label class="col-sm-4 col-form-label">No Polisi <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" name="kodetrado" class="form-control">
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <label class="col-sm-4 col-form-label">STATUS AKTIF <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="statusaktif" class="form-control select2bs4">
                    <option value="">-- PILIH STATUS AKTIF --</option>
                  </select>
                </div>
              </div>
            </div>


            <div class="row">

              <div class="form-group col-sm-6 row">
                <label class="col-sm-4 col-form-label">Tahun <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input pattern="[0-9.]+" type="text" class="form-control numbernoseparate" name="tahun">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label class="col-sm-4 col-form-label">Merek <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="merek">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label class="col-sm-4 col-form-label">No Rangka <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="norangka">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label class="col-sm-4 col-form-label">No Mesin <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="nomesin">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label class="col-sm-4 col-form-label">Nama <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="nama">
                </div>
              </div>
              {{-- //NOTE - nominal borongan --}}
              <div class="form-group col-sm-6 row">
                <label class="col-sm-4 col-form-label">PLUS BORONGAN <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="nominalplusborongan">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label class="col-sm-4 col-form-label">No STNK <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="nostnk">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label class="col-sm-4 col-form-label">Alamat STNK <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="alamatstnk">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label class="col-sm-4 col-form-label">Jenis Plat <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="statusjenisplat" class="form-control select2bs4">
                    <option value="">-- PILIH JENIS PLAT --</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label class="col-sm-4 col-form-label">Tgl Pajak STNK <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <div class="input-group">
                    <input type="text" class="form-control datepicker" name="tglpajakstnk">
                  </div>
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label class="col-sm-4 col-form-label">Tipe <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="tipe">
                </div>
              </div>

            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label class="col-sm-4 col-form-label">Jenis <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="jenis">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label class="col-sm-4 col-form-label">Isi Silinder <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control numbernoseparate" name="isisilinder">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label class="col-sm-4 col-form-label">Warna <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="warna">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label class="col-sm-4 col-form-label">Bahan Bakar <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="jenisbahanbakar">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label class="col-sm-4 col-form-label">Jumlah Sumbu <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control numbernoseparate" name="jumlahsumbu">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label class="col-sm-4 col-form-label">Jumlah Roda <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control numbernoseparate" name="jumlahroda">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label class="col-sm-4 col-form-label">Model <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="model">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label class="col-sm-4 col-form-label">No BPKB <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="nobpkb">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label class="col-sm-4 col-form-label">Milik Mandor </label>
                <div class="col-sm-8">
                  <input type="hidden" name="mandor_id">
                  <input type="text" name="mandor" class="form-control mandor-lookup">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label class="col-sm-4 col-form-label">Jumlah Ban Serap <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control numbernoseparate" name="jumlahbanserap">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label class="col-sm-4 col-form-label">Milik Supir</label>
                <div class="col-sm-8">
                  <input type="hidden" name="supir_id">
                  <input type="text" name="supir" class="form-control supir-lookup">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label class="col-sm-4 col-form-label">STATUS GEROBAK <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="statusgerobak" class="form-control select2bs4">
                    <option value="">-- PILIH STATUS GEROBAK --</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row p-2">
              <div class="col">
                <div class="row mb-2">
                  <div class="col">
                    <label class="col-form-label">Upload Foto Trado</label>
                  </div>
                </div>
                <div class="dropzone" data-field="phototrado">
                  <div class="fallback">
                    <input name="phototrado" type="file" />
                  </div>
                </div>
              </div>

              <div class="col">
                <div class="row mb-2">
                  <div class="col">
                    <label class="col-form-label">Upload Foto BPKB</label>
                  </div>
                </div>
                <div class="dropzone" data-field="photobpkb">
                  <div class="fallback">
                    <input name="photobpkb" type="file" />
                  </div>
                </div>
              </div>

              <div class="col">
                <div class="row mb-2">
                  <div class="col">
                    <label class="col-form-label">Upload Foto STNK</label>
                  </div>
                </div>
                <div class="dropzone" data-field="photostnk">
                  <div class="fallback">
                    <input name="photostnk" type="file" />
                  </div>
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
        </form>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
  Dropzone.autoDiscover = false;

  let hasFormBindKeys = false
  let modalBody = $('#crudModal').find('.modal-body').html()
  let dropzones = []

  $(document).ready(function() {
    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let url
      let form = $('#crudForm')

      let formData = new FormData(form[0])
      let Id = form.find('[name=id]').val()

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
        url = `${apiUrl}trado`
      } else if (form.data('action') == 'edit') {
        url = `${apiUrl}trado/${Id}`
        formData.append('_method', 'PATCH')
      } else if (form.data('action') == 'delete') {
        url = `${apiUrl}trado/${Id}`
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
        },
      }).always(() => {
        $('#loader').addClass('d-none')
        $(this).removeAttr('disabled')
      })
    })
  })

  function cekValidasidelete(Id) {
    $.ajax({
      url: `{{ config('app.api_url') }}trado/${Id}/cekValidasi`,
      method: 'POST',
      dataType: 'JSON',
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      success: response => {
        var kondisi = response.kondisi
        if (kondisi == true) {
          showDialog(response.message['keterangan'])
        } else {
          deleteTrado(Id)
        }

      }
    })
  }


  function createTrado() {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.find('[name]').removeAttr('disabled')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create Trado')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusAktifOptions(form),
        setStatusJenisPlatOptions(form),
        setStatusGerobak(form)
      ])
      .then(() => {
        showDefault(form)
          .then(() => {
            $('#crudModal').modal('show')
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })

    setFormBindKeys(form)
    initDropzone(form.data('action'))
    initLookup()
    initDatepicker()
    initSelect2()
    form.find('[name]').removeAttr('disabled')
  }

  function editTrado(id) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.find('[name]').removeAttr('disabled')
    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    $('#crudModalTitle').text('Edit Trado')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()



    Promise
      .all([
        setStatusAktifOptions(form),
        setStatusJenisPlatOptions(form),
        setStatusGerobak(form)
      ])
      .then(() => {
        showTrado(form, id)
          .then(trado => {
            setFormBindKeys(form)
            initDropzone(form.data('action'), trado)
            initLookup()
            initDatepicker()
            initSelect2()
            form.find('[name]').removeAttr('disabled')
          })
          .then(() => {
            $('#crudModal').modal('show')
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })


  }

  function deleteTrado(id) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    $('#crudModalTitle').text('Delete Trado')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()



    Promise
      .all([
        setStatusAktifOptions(form),
        setStatusJenisPlatOptions(form),
        setStatusGerobak(form)

      ])
      .then(() => {
        showTrado(form, id)
          .then(trado => {
            setFormBindKeys(form)
            initDropzone(form.data('action'), trado)
            initLookup()
            initDatepicker()
            initSelect2()
            form.find('[name]').removeAttr('disabled')

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
          .then(() => {
            $('#crudModal').modal('show')
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }


  function showTrado(form, id) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}trado/${id}`,
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
            } else if (element.hasClass('autonumeric')) {
              let autoNumericInput = AutoNumeric.getAutoNumericElement(element[0])
              autoNumericInput.set(value)
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
    if (!$('.mandor-lookup').data('hasLookup')) {
      $('.mandor-lookup').lookup({
        title: 'Mandor Lookup',
        fileName: 'mandor',
        beforeProcess: function(test) {
          // var levelcoa = $(`#levelcoa`).val();
          this.postData = {

            Aktif: 'AKTIF',
          }
        },
        onSelectRow: (mandor, element) => {
          $('#crudForm [name=mandor_id]').first().val(mandor.id)
          element.val(mandor.namamandor)
          element.data('currentValue', element.val())
        },
        onCancel: (element) => {
          element.val(element.data('currentValue'))
        },
        onClear: (element) => {
          $('#crudForm [name=mandor_id]').first().val('')
          element.val('')
          element.data('currentValue', element.val())
        }
      })
    }
    if (!$('.supir-lookup').data('hasLookup')) {
      $('.supir-lookup').lookup({
        title: 'Supir Lookup',
        fileName: 'supir',
        beforeProcess: function(test) {
          // var levelcoa = $(`#levelcoa`).val();
          this.postData = {

            Aktif: 'AKTIF',
          }
        },
        onSelectRow: (supir, element) => {
          $('#crudForm [name=supir_id]').first().val(supir.id)
          element.val(supir.namasupir)
          element.data('currentValue', element.val())
        },
        onCancel: (element) => {
          element.val(element.data('currentValue'))
        },
        onClear: (element) => {
          $('#crudForm [name=supir_id]').first().val('')
          element.val('')
          element.data('currentValue', element.val())
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

    if (data[paramName] == '') {
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
      })
    } else {
      let files = JSON.parse(data[paramName])
      files.forEach((file) => {
        getImgURL(`${apiUrl}trado/image/${type}/${file}/ori/edit`, (fileBlob) => {
          let imageFile = new File([fileBlob], file, {
            type: 'image/jpeg',
            lastModified: new Date().getTime()
          }, 'utf-8')
          if (fileBlob.type != 'text/html') {
            dropzone.options.addedfile.call(dropzone, imageFile);
            dropzone.options.thumbnail.call(dropzone, imageFile, `${apiUrl}trado/image/${type}/${file}/ori/edit`);
            dropzone.files.push(imageFile)
          }
        })
      })

    }
  }


  const setStatusGerobak = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusgerobak]').empty()
      relatedForm.find('[name=statusgerobak]').append(
        new Option('-- PILIH STATUS GEROBAK --', '', false, true)
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
              "data": "STATUS GEROBAK"
            }]
          })
        },
        success: response => {
          response.data.forEach(jenisPlat => {
            let option = new Option(jenisPlat.text, jenisPlat.id)

            relatedForm.find('[name=statusgerobak]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  const setStatusJenisPlatOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusjenisplat]').empty()
      relatedForm.find('[name=statusjenisplat]').append(
        new Option('-- PILIH JENIS PLAT --', '', false, true)
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
              "data": "JENIS PLAT"
            }]
          })
        },
        success: response => {
          response.data.forEach(jenisPlat => {
            let option = new Option(jenisPlat.text, jenisPlat.id)

            relatedForm.find('[name=statusjenisplat]').append(option).trigger('change')
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

  function showDefault(form) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}trado/default`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $.each(response.data, (index, value) => {
            console.log(value)
            let element = form.find(`[name="${index}"]`)
            // let element = form.find(`[name="statusaktif"]`)

            if (element.is('select')) {
              element.val(value).trigger('change')
            } else {
              element.val(value)
            }
          })
          resolve()
        }
      })
    })
  }
</script>
@endpush()