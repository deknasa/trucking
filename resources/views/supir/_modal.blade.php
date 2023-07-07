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
              <div class="col-md-6">

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">No KTP<span class="text-danger">*</span></label>
                  <div class="col-sm-10">
                    <input type="text" name="noktp" id="noktp" maxlength="16" class="form-control numbernoseparate">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Nama Supir<span class="text-danger">*</span></label>
                  <div class="col-sm-10">
                    <input type="text" name="namasupir" class="form-control">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">nama alias<span class="text-danger">*</span></label>
                  <div class="col-sm-10">
                    <input type="text" name="namaalias" class="form-control">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Tgl Lahir <span class="text-danger">*</span></label>
                  <div class="col-sm-10">
                    <div class="input-group">
                      <input type="text" class="form-control datepicker" name="tgllahir">
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Alamat <span class="text-danger">*</span></label>
                  <div class="col-sm-10">
                    <input type="text" name="alamat" class="form-control">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Kota <span class="text-danger">*</span></label>
                  <div class="col-sm-10">
                    <input type="text" name="kota" class="form-control">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">NO Telepon / Handphone <span class="text-danger">*</span></label>
                  <div class="col-sm-10">
                    <input type="text" name="telp" class="form-control numbernoseparate" maxlength="50">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">No SIM <span class="text-danger">*</span></label>
                  <div class="col-sm-10">
                    <input type="text" name="nosim" id="nosim" maxlength="12" class="form-control numbernoseparate">
                  </div>
                </div>
              </div>
              <div class="col-md-6">

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Tgl Terbit SIM<span class="text-danger">*</span></label>
                  <div class="col-sm-10">
                    <div class="input-group">
                      <input type="text" class="form-control datepicker" name="tglterbitsim">
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Tgl Exp SIM <span class="text-danger">*</span></label>
                  <div class="col-sm-10">
                    <div class="input-group">
                      <input type="text" class="form-control datepicker" name="tglexpsim">
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">No KK <span class="text-danger">*</span></label>
                  <div class="col-sm-10">
                    <input type="text" name="nokk" id="nokk" maxlength="16" class="form-control numbernoseparate">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Tgl Masuk <span class="text-danger">*</span></label>
                  <div class="col-sm-10">
                    <div class="input-group">
                      <input type="text" class="form-control datepicker" name="tglmasuk">
                    </div>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">STATUS AKTIF <span class="text-danger">*</span></label>
                  <div class="col-sm-10">
                    <select name="statusaktif" class="form-control select2bs4" style="width: 100%;">
                      <option value="">-- PILIH STATUS AKTIF --</option>
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Keterangan</label>
                  <div class="col-sm-10">
                    <input type="text" name="keterangan" class="form-control">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">No Bukti Pemutihan</label>
                  <div class="col-sm-10">
                    <input type="text" name="pemutihansupir_nobukti" class="form-control pemutihan-lookup">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Nominal Pinjaman</label>
                  <div class="col-sm-10">
                    <input type="text" name="nominalpinjamansaldoawal" class="form-control text-right" readonly>
                  </div>
                </div>

                <div class="form-group row" style="display:none;">
                  <label for="staticEmail" class="col-sm-2 col-form-label ">Angsuran Pinjaman</label>
                  <div class="col-sm-10">
                    <input type="text" name="angsuranpinjaman" class="form-control autonumeric">
                  </div>
                </div>

                <div class="form-group row" style="display:none;">
                  <label for="staticEmail" class="col-sm-2 col-form-label ">Plafon Deposito</label>
                  <div class="col-sm-10">
                    <input type="text" name="plafondeposito" class="form-control autonumeric">
                  </div>
                </div>

              </div>
            </div>

            <div class="row p-2">
              <div class="col-md-4">
                <div class="row mb-2">
                  <div class="col">
                    <label class="col-form-label">Upload Foto Supir <span class="text-danger">*</span></label>
                  </div>
                </div>
                <div class="dropzone dropzoneImg" data-field="photosupir" id="my-dropzone"></div>

                <div class="dz-preview dz-file-preview">
                  <div class="dz-details">
                    <img data-dz-thumbnail />
                  </div>
                </div>
                <!-- <div class="dropzone dropzoneImg" data-field="photosupir">
                  <div class="fallback">
                    <input name="photosupir" type="file" />
                  </div>
                </div> -->
              </div>

              <div class="col-md-4">
                <div class="row mb-2">
                  <div class="col">
                    <label class="col-form-label">Upload Foto KTP <span class="text-danger">*</span></label>
                  </div>
                </div>
                <div class="dropzone dropzoneImg" data-field="photoktp" id="my-dropzone"></div>

                <div class="dz-preview dz-file-preview">
                  <div class="dz-details">
                    <img data-dz-thumbnail />
                  </div>
                </div>
                <!-- <div class="dropzone dropzoneImg" data-field="photoktp">
                  <div class="fallback">
                    <input name="photoktp" type="file" />
                  </div>
                </div> -->
              </div>

              <div class="col-md-4">
                <div class="row mb-2">
                  <div class="col">
                    <label class="col-form-label">Upload Foto SIM <span class="text-danger">*</span></label>
                  </div>
                </div>
                <div class="dropzone dropzoneImg" data-field="photosim" id="my-dropzone"></div>

                <div class="dz-preview dz-file-preview">
                  <div class="dz-details">
                    <img data-dz-thumbnail />
                  </div>
                </div>
                <!-- <div class="dropzone dropzoneImg" data-field="photosim">
                  <div class="fallback">
                    <input name="photosim" type="file" />
                  </div>
                </div> -->
              </div>
            </div>

            <div class="row p-2">
              <div class="col-md-4">
                <div class="row mb-2">
                  <div class="col">
                    <label class="col-form-label">Upload Foto KK <span class="text-danger">*</span></label>
                  </div>
                </div>
                <div class="dropzone dropzoneImg" data-field="photokk" id="my-dropzone"></div>

                <div class="dz-preview dz-file-preview">
                  <div class="dz-details">
                    <img data-dz-thumbnail />
                  </div>
                </div>
                <!-- <div class="dropzone dropzoneImg" data-field="photokk">
                  <div class="fallback">
                    <input name="photokk" type="file" />
                  </div>
                </div> -->
              </div>

              <div class="col-md-4">
                <div class="row mb-2">
                  <div class="col">
                    <label class="col-form-label">Upload Foto SKCK <span class="text-danger">*</span></label>
                  </div>
                </div>
                <div class="dropzone dropzoneImg" data-field="photoskck" id="my-dropzone"></div>

                <div class="dz-preview dz-file-preview">
                  <div class="dz-details">
                    <img data-dz-thumbnail />
                  </div>
                </div>
                <!-- <div class="dropzone dropzoneImg" data-field="photoskck">
                  <div class="fallback">
                    <input name="photoskck" type="file" />
                  </div>
                </div> -->
              </div>

              <div class="col-md-4">
                <div class="row mb-2">
                  <div class="col">
                    <label class="col-form-label">Upload Foto Domisili <span class="text-danger">*</span></label>
                  </div>
                </div>
                <div class="dropzone dropzoneImg" data-field="photodomisili" id="my-dropzone"></div>

                <div class="dz-preview dz-file-preview">
                  <div class="dz-details">
                    <img data-dz-thumbnail />
                  </div>
                </div>
                <!-- <div class="dropzone dropzoneImg" data-field="photodomisili">
                  <div class="fallback">
                    <input name="photodomisili" type="file" />
                  </div>
                </div> -->
              </div>

              <div class="col-md-4">
                <div class="row mb-2">
                  <div class="col">
                    <label class="col-form-label">Upload Foto Vaksin <span class="text-danger">*</span></label>
                  </div>
                </div>
                <div class="dropzone dropzoneImg" data-field="photovaksin" id="my-dropzone"></div>

                <div class="dz-preview dz-file-preview">
                  <div class="dz-details">
                    <img data-dz-thumbnail />
                  </div>
                </div>
                <!-- <div class="dropzone dropzoneImg" data-field="photovaksin">
                  <div class="fallback">
                    <input name="photovaksin" type="file" />
                  </div>
                </div> -->
              </div>

              <div class="col-md-4">
                <div class="row mb-2">
                  <div class="col">
                    <label class="col-form-label">Upload surat perjanjian <span class="text-danger">*</span></label>
                  </div>
                </div>
                <div class="dropzone dropzonePdf" data-field="pdfsuratperjanjian">
                  <div class="fallback">
                    <input name="pdfsuratperjanjian" type="file" />
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
    $(document).on('dblclick', '[data-dz-thumbnail]', handleImageClick)
    $(document).on('click', '#btnSubmit', function(event) {
      event.preventDefault()

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
      $('#processingLoader').removeClass('d-none')

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
          irow = (response.data.position -1 ) % limit
          // console.log(irow);
          indexRow = Math.ceil(irow)
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
            console.error(error.responseJSON)
            // console.log(error.responseJSON);
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            setErrorMessages(form, error.responseJSON.errors);
          } else {
            showDialog(error.responseJSON)
          }
        }
      }).always(() => {
        $('#processingLoader').addClass('d-none')
        $(this).removeAttr('disabled')
      })
    })
  })


  // $('#crudModal').on('shown.bs.modal', () => {
  //   let form = $('#crudForm')

  //   setFormBindKeys(form)

  //   activeGrid = null

  //   getMaxLength(form)
  //   initLookup()
  // })
  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'

    $('#crudForm [name=nominalpinjamansaldoawal]').attr('value', '')
    dropzones.forEach(dropzone => {
      dropzone.removeAllFiles()
    })
  })

  $('#crudForm [name=noktp]').bind("enterKey", function(e) {
    let form = $('#crudForm');
    $.ajax({
      url: `${apiUrl}supir/getsupirresign`,
      method: 'GET',
      dataType: 'JSON',
      data: {
        noktp: $('#crudForm [name=noktp]').val()
      },
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        console.log(response.data)
        if (response.data != null) {
          console.log(response.data)
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
        }
      },
      error: error => {

      }
    })
  });

  $('#crudForm [name=noktp]').keyup(function(e) {
    if (e.keyCode == 13) {
      $(this).trigger("enterKey");
    }
  });


  function createSupir() {
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
    $('#crudModalTitle').text('Create Supir')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusAktifOptions(form),
      ])
      .then(() => {
        showDefault(form)
          .then(() => {
            $('#crudModal').modal('show')
          })
          .catch((error) => {
            showDialog(error.statusText)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
    // $('#crudForm').find('[name=tgllahir]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    $('#crudForm').find('[name=tglmasuk]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    $('#crudForm').find('[name=tglterbitsim]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    $('#crudForm').find('[name=tglexpsim]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');


    initDropzone(form.data('action'))
    initDropzonePdf(form.data('action'))
    initLookup()
    initDatepicker()
    initSelect2(form.find('.select2bs4'), true)
    form.find('[name]').removeAttr('disabled')
  }

  function editSupir(id) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.find('[name]').removeAttr('disabled')
    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    $('#crudModalTitle').text('Edit Supir')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusAktifOptions(form),
      ])
      .then(() => {
        showSupir(form, id)
          .then(supir => {
            setFormBindKeys(form)
            initDropzone(form.data('action'), supir)
            initDropzonePdf(form.data('action'), supir)
            initLookup()
            initDatepicker()
            initSelect2(form.find('.select2bs4'), true)
            form.find('[name]').removeAttr('disabled')
          })
          .then(() => {
            $('#crudModal').modal('show')
          })
          .catch((error) => {
            showDialog(error.statusText)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  function deleteSupir(id) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Hapus
    `)
    $('#crudModalTitle').text('Delete Supir')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusAktifOptions(form),
      ])
      .then(() => {
        showSupir(form, id)
          .then(supir => {
            setFormBindKeys(form)
            initDropzone(form.data('action'), supir)
            initDropzonePdf(form.data('action'), supir)
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
          .catch((error) => {
            showDialog(error.statusText)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
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
        },
        error: error => {
          reject(error)
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
        },
        onClear: (element) => {
          $('#crudForm [name=zona_id]').first().val('')
          element.val('')
          element.data('currentValue', element.val())
        }
      })
    }

    if (!$('.supir-lookup').data('hasLookup')) {
      $('.supir-lookup').lookup({
        title: 'Supir Lookup',
        fileName: 'supir',
        onSelectRow: (supir, element) => {
          $('#crudForm [name=supirold_id]').first().val(supir.id)
          element.val(supir.namasupir)
          element.data('currentValue', element.val())
        },
        onCancel: (element) => {
          element.val(element.data('currentValue'))
        },
        onClear: (element) => {
          $('#crudForm [name=supirold_id]').first().val('')
          element.val('')
          element.data('currentValue', element.val())
        }
      })
    }

    if (!$('.pemutihan-lookup').data('hasLookup')) {
      $('.pemutihan-lookup').lookup({
        title: 'Pemutihan Supir Lookup',
        fileName: 'pemutihansupir',
        onSelectRow: (pemutihansupir, element) => {

          newPengeluaran = pemutihansupir.pengeluaransupir.replace(',', '');
          newPenerimaan = pemutihansupir.penerimaansupir.replace(',', '');
          pinjaman = parseFloat(newPengeluaran) - parseFloat(newPenerimaan);
          initAutoNumeric($('#crudForm [name=nominalpinjamansaldoawal]').val(pinjaman))
          element.val(pemutihansupir.nobukti)
          element.data('currentValue', element.val())
        },
        onCancel: (element) => {
          element.val(element.data('currentValue'))
        },
        onClear: (element) => {
          element.val('')
          $('#crudForm [name=nominalpinjamansaldoawal]').val('')
          element.data('currentValue', element.val())
        }
      })
    }
  }


  function handleImageClick(event) {
    event.preventDefault();
    let imageUrl = event.target.src;
    if (imageUrl.substr(0, 4) == 'data') {
      var image = new Image();
      image.src = imageUrl;
      var w = window.open("");
      w.document.write(image.outerHTML);
    } else {
      window.open(imageUrl);
    }

  }

  function initDropzone(action, data = null) {
    let buttonRemoveDropzone = `<i class="fas fa-times-circle"></i>`
    $('.dropzoneImg').each((index, element) => {
      if (!element.dropzone) {
        let newDropzone = new Dropzone(element, {
          url: 'test',
          previewTemplate: document.querySelector('.dz-preview').innerHTML,
          thumbnailWidth: null,
          thumbnailHeight: null,
          autoProcessQueue: false,
          addRemoveLinks: true,
          dictRemoveFile: buttonRemoveDropzone,
          acceptedFiles: 'image/*',
          paramName: $(element).data('field'),
          init: function() {
            dropzones.push(this)
            this.on("addedfile", function(file) {
              if (this.files.length > 5) {
                this.removeFile(file);
              }
            });
          }
        })
      }

      element.dropzone.removeAllFiles()

      if (action == 'edit' || action == 'delete') {
        assignAttachment(element.dropzone, data)
      }
    })
  }

  function initDropzonePdf(action, data = null) {
    let buttonRemoveDropzone = `<i class="fas fa-times-circle"></i>`
    $('.dropzonePdf').each((index, element) => {
      if (!element.dropzone) {
        let newDropzone = new Dropzone(element, {
          url: 'test',
          autoProcessQueue: false,
          addRemoveLinks: true,
          dictRemoveFile: buttonRemoveDropzone,
          acceptedFiles: 'application/pdf',
          uploadprogress: false,
          paramName: $(element).data('field'),
          init: function() {
            dropzones.push(this)
            this.on("addedfile", function(file) {
              if (this.files.length > 1) {
                this.removeFile(file);
              }

              // $(file.previewElement).find('img').prop('src',appUrl+'/images/pdf_icon.png')
            });
          }
        })
      }
      element.dropzone.removeAllFiles()
      if (action == 'edit' || action == 'delete') {
        assignAttachmentPdf(element.dropzone, data)
      }

    })
  }

  function assignAttachment(dropzone, data) {
    const paramName = dropzone.options.paramName
    const type = paramName.substring(5)
    if (data[paramName] == '') {
      $('.dropzoneImg').each((index, element) => {
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
        if (file == '') {
          file = 'no-image'
        }
        getImgURL(`${apiUrl}supir/image/${type}/${file}/ori/edit`, (fileBlob) => {
          let imageFile = new File([fileBlob], file, {
            type: 'image/jpeg',
            lastModified: new Date().getTime()
          }, 'utf-8')

          if (fileBlob.type != 'text/html') {
            dropzone.options.addedfile.call(dropzone, imageFile);
            dropzone.options.thumbnail.call(dropzone, imageFile, `${apiUrl}supir/image/${type}/${file}/ori/edit`);
            dropzone.files.push(imageFile)
          }
        })
      })
    }
  }

  function assignAttachmentPdf(dropzone, data) {
    const paramName = dropzone.options.paramName
    const type = paramName.substring(3)
    if (data[paramName] == '') {

      $('.dropzonePdf').each((index, element) => {
        if (!element.dropzone) {
          let newDropzone = new Dropzone(element, {
            url: 'test',
            autoProcessQueue: false,
            addRemoveLinks: true,
            acceptedFiles: 'application/pdf',
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
        if (file == '') {
          file = 'no file'
        }
        getImgURL(`${apiUrl}supir/pdf/${type}/${file}`, (fileBlob) => {
          // console.log('file', file)
          if (file != 'no file') {
            let imageFile = new File([fileBlob], file, {
              type: 'application/pdf',
              lastModified: new Date().getTime()
            }, 'utf-8')

            dropzone.options.addedfile.call(dropzone, imageFile);
            // dropzone.options.thumbnail.call(dropzone, imageFile, `${apiUrl}supir/pdf/${type}/${file}`);
            dropzone.files.push(imageFile)
          }
        })
      })
    }
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
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function cekValidasidelete(Id) {
    $.ajax({
      url: `{{ config('app.api_url') }}supir/${Id}/cekValidasi`,
      method: 'POST',
      dataType: 'JSON',
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      success: response => {
        var kondisi = response.kondisi
        console.log(kondisi)
        if (kondisi == true) {
          showDialog(response.message['keterangan'])
        } else {
          deleteSupir(Id)
        }

      }
    })
  }

  function getImgURL(url, callback) {
    var xhr = new XMLHttpRequest();
    xhr.onload = function() {
      // console.log(xhr.response);
      callback(xhr.response);
    };
    xhr.open('GET', url);
    xhr.responseType = 'blob';
    xhr.send();
  }

  function showDefault(form) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}supir/default`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)
            // let element = form.find(`[name="statusaktif"]`)

            if (element.is('select')) {
              element.val(value).trigger('change')
            } else {
              element.val(value)
            }
          })
          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }
</script>
@endpush()