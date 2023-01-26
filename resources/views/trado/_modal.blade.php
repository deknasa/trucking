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
                <label for="staticEmail" class="col-sm-4 col-form-label">Keterangan <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" name="keterangan" class="form-control">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">STATUS AKTIF <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="statusaktif" class="form-control select2bs4">
                    <option value="">-- PILIH STATUS AKTIF --</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Kilometer Awal <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control autonumeric" name="kmawal">
                </div>
              </div>

              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Kilometer Akhir <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control autonumeric" name="kmakhirgantioli">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Akhir Ganti oli <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <div class="input-group">
                    <input type="text" class="form-control datepicker" name="tglakhirgantioli">
                  </div>
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl STNK Mati <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <div class="input-group">
                    <input type="text" class="form-control datepicker" name="tglstnkmati">
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Asuransi Mati <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <div class="input-group">
                    <input type="text" class="form-control datepicker" name="tglasuransimati">
                  </div>
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tahun <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input pattern="[0-9.]+" type="text" class="form-control numbernoseparate" name="tahun">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tahun Produksi Akhir <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control numbernoseparate" name="akhirproduksi">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Merek <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="merek">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">No Rangka <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="norangka">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">No Mesin <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="nomesin">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Nama <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="nama">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">No STNK <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="nostnk">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Alamat STNK <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="alamatstnk">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Standarisasi <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <div class="input-group">
                    <input type="text" class="form-control datepicker" name="tglstandarisasi">
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Service Opname <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <div class="input-group">
                    <input type="text" class="form-control datepicker" name="tglserviceopname">
                  </div>
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Status Standarisasi <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="statusstandarisasi" class="form-control select2bs4">
                    <option value="">-- PILIH STATUS STANDARISASI --</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Keterangan Progress Standarisasi <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="keteranganprogressstandarisasi">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Jenis Plat <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="statusjenisplat" class="form-control select2bs4">
                    <option value="">-- PILIH JENIS PLAT --</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Speksi Mati <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <div class="input-group">
                    <input type="text" class="form-control datepicker" name="tglspeksimati">
                  </div>
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Pajak STNK <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <div class="input-group">
                    <input type="text" class="form-control datepicker" name="tglpajakstnk">
                  </div>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tgl Ganti aki terakhir <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <div class="input-group">
                    <input type="text" class="form-control datepicker" name="tglgantiakiterakhir">
                  </div>
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Status Mutasi <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="statusmutasi" class="form-control select2bs4">
                    <option value="">-- PILIH STATUS MUTASI --</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Status Validasi Kendaraan <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="statusvalidasikendaraan" class="form-control select2bs4">
                    <option value="">-- PILIH STATUS VALIDASI KENDARAAN --</option>
                  </select>
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Tipe <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="tipe">
                </div>
              </div>

            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Jenis <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="jenis">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Isi Silinder <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control numbernoseparate" name="isisilinder">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Warna <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="warna">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Bahan Bakar <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="jenisbahanbakar">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Jumlah Sumbu <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control numbernoseparate" name="jumlahsumbu">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Jumlah Roda <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control numbernoseparate" name="jumlahroda">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Model <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="model">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">No BPKB <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control" name="nobpkb">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Status Mobil Storing <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="statusmobilstoring" class="form-control select2bs4">
                    <option value="">-- PILIH STATUS MOBIL STORING --</option>
                  </select>
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Milik Mandor <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="hidden" name="mandor_id">
                  <input type="text" name="mandor" class="form-control mandor-lookup">
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Jumlah Ban Serap <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="text" class="form-control numbernoseparate" name="jumlahbanserap">
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">STATUS APPEDIT BAN <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="statusappeditban" class="form-control select2bs4">
                    <option value="">-- PILIH STATUS APPEDIT BAN --</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="row">
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Lewat Validasi <span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <select name="statuslewatvalidasi" class="form-control select2bs4">
                    <option value="">-- PILIH LEWAT VALIDASI --</option>
                  </select>
                </div>
              </div>
              <div class="form-group col-sm-6 row">
                <label for="staticEmail" class="col-sm-4 col-form-label">Milik Supir<span class="text-danger">*</span></label>
                <div class="col-sm-8">
                  <input type="hidden" name="supir_id">
                  <input type="text" name="supir" class="form-control supir-lookup">
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

  function createTrado() {
    let form = $('#crudForm')

    form.find('[name]').removeAttr('disabled')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create Trado')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()


    Promise
      .all([
        setStatusAktifOptions(form),
        setStatusStandarisasiOptions(form),
        setStatusJenisPlatOptions(form),
        setStatusMutasiOptions(form),
        setStatusValidasiKendaraanOptions(form),
        setStatusMobilStoringOptions(form),
        setAppeditBanOptions(form),
        setStatusLewatValidasiOptions(form)
      ])
      .then(() => {
        showDefault(form)
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

    form.find('[name]').removeAttr('disabled')
    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    $('#crudModalTitle').text('Edit Trado')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusAktifOptions(form),
        setStatusStandarisasiOptions(form),
        setStatusJenisPlatOptions(form),
        setStatusMutasiOptions(form),
        setStatusValidasiKendaraanOptions(form),
        setStatusMobilStoringOptions(form),
        setAppeditBanOptions(form),
        setStatusLewatValidasiOptions(form)
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
      })
  }

  function deleteTrado(id) {
    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    $('#crudModalTitle').text('Delete Trado')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusAktifOptions(form),
        setStatusStandarisasiOptions(form),
        setStatusJenisPlatOptions(form),
        setStatusMutasiOptions(form),
        setStatusValidasiKendaraanOptions(form),
        setStatusMobilStoringOptions(form),
        setAppeditBanOptions(form),
        setStatusLewatValidasiOptions(form)
      ])
      .then(() => {
        showTrado(form, id)
          .then(trado => {
            setFormBindKeys(form)
            initDropzone(form.data('action'), trado)

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
        getImgURL(`${apiUrl}trado/image/${type}/${file}/ori`, (fileBlob) => {
          let imageFile = new File([fileBlob], file, {
            type: 'image/jpeg',
            lastModified: new Date().getTime()
          }, 'utf-8')

          dropzone.options.addedfile.call(dropzone, imageFile);
          dropzone.options.thumbnail.call(dropzone, imageFile, `${apiUrl}trado/image/${type}/${file}/ori`);
          dropzone.files.push(imageFile)
        })
      })

    }
  }

  const setStatusLewatValidasiOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statuslewatvalidasi]').empty()
      relatedForm.find('[name=statuslewatvalidasi]').append(
        new Option('-- PILIH STATUS LEWAT VALIDASI --', '', false, true)
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
              "data": "STATUS LEWAT VALIDASI"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusLewatValidasi => {
            let option = new Option(statusLewatValidasi.text, statusLewatValidasi.id)

            relatedForm.find('[name=statuslewatvalidasi]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }


  const setAppeditBanOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusappeditban]').empty()
      relatedForm.find('[name=statusappeditban]').append(
        new Option('-- PILIH STATUS APPEDIT BAN --', '', false, true)
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
              "data": "STATUS APPROVAL EDIT BAN"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusAppeditBan => {
            let option = new Option(statusAppeditBan.text, statusAppeditBan.id)

            relatedForm.find('[name=statusappeditban]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }
  //sini

  const setStatusMobilStoringOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusmobilstoring]').empty()
      relatedForm.find('[name=statusmobilstoring]').append(
        new Option('-- PILIH STATUS MOBIL STORING --', '', false, true)
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
              "data": "STATUS MOBIL STORING"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusMobilStoring => {
            let option = new Option(statusMobilStoring.text, statusMobilStoring.id)

            relatedForm.find('[name=statusmobilstoring]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  const setStatusValidasiKendaraanOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusvalidasikendaraan]').empty()
      relatedForm.find('[name=statusvalidasikendaraan]').append(
        new Option('-- PILIH STATUS VALIDASI KENDARAAN --', '', false, true)
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
              "data": "STATUS VALIDASI KENDARAAN"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusValidasiKendaraan => {
            let option = new Option(statusValidasiKendaraan.text, statusValidasiKendaraan.id)

            relatedForm.find('[name=statusvalidasikendaraan]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  const setStatusMutasiOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusmutasi]').empty()
      relatedForm.find('[name=statusmutasi]').append(
        new Option('-- PILIH STATUS MUTASI --', '', false, true)
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
              "data": "STATUS MUTASI"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusMutasi => {
            let option = new Option(statusMutasi.text, statusMutasi.id)

            relatedForm.find('[name=statusmutasi]').append(option).trigger('change')
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

  const setStatusStandarisasiOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusstandarisasi]').empty()
      relatedForm.find('[name=statusstandarisasi]').append(
        new Option('-- PILIH STATUS STANDARISASI --', '', false, true)
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
              "data": "STATUS STANDARISASI"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusStandarisasi => {
            let option = new Option(statusStandarisasi.text, statusStandarisasi.id)

            relatedForm.find('[name=statusstandarisasi]').append(option).trigger('change')
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


      }
    })
  }
</script>
@endpush()