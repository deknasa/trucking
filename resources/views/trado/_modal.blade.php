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
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">No Polisi <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="text" name="kodetrado" class="form-control">
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">Merek <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="text" name="merek" class="form-control">
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">Tipe <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="text" name="tipe" class="form-control">
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">Jenis <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="text" name="jenis" class="form-control">
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">Model <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="text" name="model" class="form-control">
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">Tahun <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="text" name="tahun" class="form-control numbernoseparate" maxlength="4">
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">Isi Silinder <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <div class="input-group">
                      <input type="text" name="isisilinder" class="form-control numbernoseparate">
                      <div class="input-group-append">
                        <span class="input-group-text" style="font-weight: bold;">CC</span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">Warna <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="text" name="warna" class="form-control">
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">Tgl asuransi Mati <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <div class="input-group">
                      <input type="text" name="tglasuransimati" class="form-control datepicker">
                    </div>
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">No Rangka <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="text" name="norangka" class="form-control">
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">No Mesin <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="text" name="nomesin" class="form-control">
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">PLUS BORONGAN</label>
                  <div class="col-sm-12">
                    <input type="text" class="form-control autonumeric text-right" name="nominalplusborongan">
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">Bahan Bakar <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="text" name="jenisbahanbakar" class="form-control">
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">Jumlah Sumbu <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="text" name="jumlahsumbu" class="form-control numbernoseparate">
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">STATUS ABSENSI SUPIR <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="hidden" name="statusabsensisupir">
                    <input type="text" name="statusabsensisupirnama" id="statusabsensisupirnama" class="form-control lg-form statusabsensisupir-lookup">
                  </div>
                </div>
              </div>
              <div class="col-md-6">

                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">Jumlah BAN <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="text" name="jumlahroda" class="form-control numbernoseparate">
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">Jumlah Ban Serap <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="text" name="jumlahbanserap" class="form-control numbernoseparate">
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">Nama Pemilik<span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="text" name="nama" class="form-control">
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">No BPKB <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="text" name="nobpkb" class="form-control">
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">Alamat STNK <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="text" name="alamatstnk" class="form-control">
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">No STNK <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="text" name="nostnk" class="form-control">
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">Tgl Pajak STNK <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <div class="input-group">
                      <input type="text" name="tglpajakstnk" class="form-control datepicker">
                    </div>
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">Tgl STNK Mati <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <div class="input-group">
                      <input type="text" name="tglstnkmati" class="form-control datepicker">
                    </div>
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">Tgl Speksi Mati <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <div class="input-group">
                      <input type="text" name="tglspeksimati" class="form-control datepicker">
                    </div>
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">Jenis Plat <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="hidden" name="statusjenisplat">
                    <input type="text" name="statusjenisplatnama" id="statusjenisplatnama" class="form-control lg-form statusjenisplat-lookup">
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">STATUS AKTIF <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="hidden" name="statusaktif">
                    <input type="text" name="statusaktifnama" id="statusaktifnama" class="form-control lg-form statusaktif-lookup">
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">STATUS GEROBAK <span class="text-danger">*</span></label>
                  <div class="col-sm-12">
                    <input type="hidden" name="statusgerobak">
                    <input type="text" name="statusgerobaknama" id="statusgerobaknama" class="form-control lg-form statusgerobak-lookup">
                  </div>
                </div>

                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">Keterangan</label>
                  <div class="col-sm-12">
                    <input type="text" name="keterangan" class="form-control">
                  </div>
                </div>
                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">Milik Mandor</label>
                  <div class="col-sm-12">
                    <input type="hidden" name="mandor_id">
                    <input type="text" name="mandor" class="form-control" readonly>
                  </div>
                </div>

                <div class="form-group ">
                  <label class="col-sm-12 col-form-label">Milik Supir</label>
                  <div class="col-sm-12">
                    <input type="hidden" name="supir_id">
                    <input type="text" name="supir" class="form-control" readonly>
                  </div>
                </div>

              </div>
            </div>

            <div class="row p-2">
              <div class="col">
                <div class="row mb-2">
                  <div class="col">
                    <label class="col-form-label">Upload Foto Trado <span class="text-danger">*</span></label>
                  </div>
                </div>
                <div class="dropzone" data-field="phototrado" id="my-dropzone"></div>

                <div class="dz-preview dz-file-preview">
                  <div class="dz-details">
                    <img data-dz-thumbnail />
                  </div>
                </div>
                <!-- <div class="dropzone" data-field="phototrado">
                  <div class="fallback">
                    <input name="phototrado" type="file" />
                  </div>
                </div> -->
              </div>

              <div class="col">
                <div class="row mb-2">
                  <div class="col">
                    <label class="col-form-label">Upload Foto BPKB <span class="text-danger">*</span></label>
                  </div>
                </div>
                <div class="dropzone" data-field="photobpkb" id="my-dropzone"></div>

                <div class="dz-preview dz-file-preview">
                  <div class="dz-details">
                    <img data-dz-thumbnail />
                  </div>
                </div>
                <!-- <div class="dropzone" data-field="photobpkb">
                  <div class="fallback">
                    <input name="photobpkb" type="file" />
                  </div>
                </div> -->
              </div>

              <div class="col">
                <div class="row mb-2">
                  <div class="col">
                    <label class="col-form-label">Upload Foto STNK <span class="text-danger">*</span></label>
                  </div>
                </div>
                <div class="dropzone" data-field="photostnk" id="my-dropzone"></div>

                <div class="dz-preview dz-file-preview">
                  <div class="dz-details">
                    <img data-dz-thumbnail />
                  </div>
                </div>
                <!-- <div class="dropzone" data-field="photostnk">
                  <div class="fallback">
                    <input name="photostnk" type="file" />
                  </div>
                </div> -->
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-start">
            <button id="btnSubmit" class="btn btn-primary">
              <i class="fa fa-save"></i>
              Save
            </button>
            <button class="btn btn-secondary" data-dismiss="modal">
              <i class="fa fa-times"></i>
              Cancel
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
  var data_id

  let hasFormBindKeys = false
  let modalBody = $('#crudModal').find('.modal-body').html()
  let dropzones = []
  let dataMaxLength = []

  $(document).ready(function() {
    $(document).on('dblclick', '[data-dz-thumbnail]', handleImageClick)
    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let url
      let form = $('#crudForm')
      let data = $('#crudForm').serializeArray()
      let formData = new FormData()
      let Id = form.find('[name=id]').val()

      dropzones.forEach(dropzone => {
        const {
          paramName
        } = dropzone.options

        dropzone.files.forEach((file, index) => {
          formData.append(`${paramName}[${index}]`, file)
        })
      })
      if (form.data('action') != 'delete') {
        data.filter((row) => row.name === 'nominalplusborongan')[0].value = AutoNumeric.getNumber($(`#crudForm [name="nominalplusborongan"]`)[0])
      }
      $.each(data, function(key, input) {
        formData.append(input.name, input.value);
      });

      formData.append('sortIndex', $('#jqGrid').getGridParam().sortname)
      formData.append('sortOrder', $('#jqGrid').getGridParam().sortorder)
      formData.append('filters', $('#jqGrid').getGridParam('postData').filters)
      formData.append('info', info)
      formData.append('indexRow', indexRow)
      formData.append('accessTokenTnl', accessTokenTnl)
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
          } else {
            showDialog(error.responseJSON)
          }
        },
      }).always(() => {
        $('#processingLoader').addClass('d-none')
        $(this).removeAttr('disabled')
      })
    })
  })
  $('#crudModal').on('shown.bs.modal', () => {
    data_id = $('#crudForm').find('[name=id]').val();

  })
  $('#crudModal').on('hidden.bs.modal', () => {
    // $('#crudModal').find('.modal-body').html(modalBody)
    removeEditingBy(data_id)
    dropzones.forEach(dropzone => {
      dropzone.removeAllFiles()
    })
  })

  function removeEditingBy(id) {
    $.ajax({
      url: `{{ config('app.api_url') }}bataledit`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        id: id,
        aksi: 'BATAL',
        table: 'trado'

      },
      success: response => {
        $("#crudModal").modal("hide")
      },
      error: error => {
        if (error.status === 422) {
          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()

          setErrorMessages(form, error.responseJSON.errors);
        } else {
          showDialog(error.responseJSON)
        }
      },
    })
  }


  function cekValidasihistory(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}trado/${Id}/cekvalidasihistory`,
      method: 'POST',
      dataType: 'JSON',
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      data: {
        aksi: Aksi
      },
      success: response => {
        var error = response.error
        if (error) {
          showDialog(response)
        } else {
          if (Aksi == 'historyMandor') {
            editTradoMilikMandor(Id)
          }
          if (Aksi == 'historySupir') {
            editTradoMilikSupir(Id)
          }
        }

      }
    })
  }

  function cekValidasi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}trado/${Id}/cekValidasi`,
      method: 'POST',
      dataType: 'JSON',
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      data: {
        aksi: Aksi,
      },
      success: response => {
        var kondisi = response.kondisi
        if (kondisi == true) {
          showDialog(response.message['keterangan'])
        } else {
          // deleteKaryawan(Id)
          if (Aksi == "EDIT") {
            editTrado(Id)
          } else if (Aksi == "DELETE") {
            deleteTrado(Id)
          }

        }
        // var kondisi = response.kondisi
        // if (kondisi == true) {
        //   showDialog(response.message['keterangan'])
        // } else {
        //   deleteTrado(Id)
        // }

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
    Save
  `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Add Trado')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    Promise
      .all([
        // setStatusAktifOptions(form),
        // setStatusJenisPlatOptions(form),
        // setStatusGerobak(form),
        // setStatusAbsensiSupir(form),
        getMaxLength(form)
      ])
      .then(() => {
        showDefault(form)
          .then(() => {
            $('#crudModal').modal('show')

            $('#crudForm').find(`.ui-datepicker-trigger`).attr('disabled', false)
            form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').show()

            let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
            name.attr('disabled', false)
            name.find('.lookup-toggler').attr('disabled', false)

            let mandor = $('#crudForm').find(`[name=mandor]`).css({
              background: '#e9ecef'
            })
            let supir = $('#crudForm').find(`[name=supir]`).css({
              background: '#e9ecef'

            })
            form.find(`[name="kodetrado"]`).attr('readonly', false)
            form.find(`[name="keterangan"]`).attr('readonly', false)
            form.find(`[name="merek"]`).attr('readonly', false)
            form.find(`[name="tipe"]`).attr('readonly', false)
            form.find(`[name="jenis"]`).attr('readonly', false)
            form.find(`[name="model"]`).attr('readonly', false)
            form.find(`[name="tahun"]`).attr('readonly', false)
            form.find(`[name="isisilinder"]`).attr('readonly', false)
            form.find(`[name="warna"]`).attr('readonly', false)
            form.find(`[name="norangka"]`).attr('readonly', false)
            form.find(`[name="nomesin"]`).attr('readonly', false)
            form.find(`[name="jenisbahanbakar"]`).attr('readonly', false)
            form.find(`[name="jumlahsumbu"]`).attr('readonly', false)
            form.find(`[name="statusabsensisupir"]`).attr('readonly', false)
            form.find(`[name="jumlahroda"]`).attr('readonly', false)
            form.find(`[name="jumlahbanserap"]`).attr('readonly', false)
            form.find(`[name="nostnk"]`).attr('readonly', false)
            form.find(`[name="statusjenisplat"]`).attr('readonly', false)
            form.find(`[name="statusaktif"]`).attr('readonly', false)
            form.find(`[name="statusgerobak"]`).attr('readonly', false)


          })

          .catch((error) => {
            showDialog(error.statusText)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })

    setFormBindKeys(form)
    initDropzone(form.data('action'))
    initLookup()
    initDatepicker()
    // initSelect2(form.find(`
    //   [name="statusaktif"],
    //   [name="statusjenisplat"],
    //   [name="statusgerobak"],
    //   [name="statusabsensisupir"]
    // `), true)

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
    Save
  `)
    $('#crudModalTitle').text('Edit Trado')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()



    Promise
      .all([
        // setStatusAktifOptions(form),
        // setStatusJenisPlatOptions(form),
        // setStatusGerobak(form),
        // setStatusAbsensiSupir(form),
        getMaxLength(form)
      ])
      .then(() => {
        showTrado(form, id)
          .then(trado => {
            setFormBindKeys(form)
            initDropzone(form.data('action'), trado)
            initLookup()
            initDatepicker()
            initSelect2(form.find('.select2bs4'), true)
            form.find('[name]').removeAttr('disabled')
          })
          .then(() => {
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            $('#crudModal').modal('show')

            form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').show()

            $('#crudForm').find(`.ui-datepicker-trigger`).attr('disabled', false)

            let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
            name.attr('disabled', false)
            name.find('.lookup-toggler').attr('disabled', false)

            let mandor = $('#crudForm').find(`[name=mandor]`).css({
              background: '#e9ecef'
            })
            let supir = $('#crudForm').find(`[name=supir]`).css({
              background: '#e9ecef'
            })
          })
          .catch((error) => {
            showDialog(error.statusText)
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
    <i class="fa fa-trash"></i>
    Delete
  `)
    $('#crudModalTitle').text('Delete Trado')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()



    Promise
      .all([
        // setStatusAktifOptions(form),
        // setStatusJenisPlatOptions(form),
        // setStatusGerobak(form),
        // setStatusAbsensiSupir(form),
        getMaxLength(form)

      ])
      .then(() => {
        showTrado(form, id)
          .then(trado => {
            setFormBindKeys(form)
            initDropzone(form.data('action'), trado)
            initLookup()
            initDatepicker()
            initSelect2(form.find('.select2bs4'), true)
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
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            $('#crudModal').modal('show')
            $('#crudForm').find(`.ui-datepicker-trigger`).attr('disabled', true)
            form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').show()

            let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
            name.attr('disabled', true)
            name.find('.lookup-toggler').attr('disabled', true)

          })
          .catch((error) => {
            showDialog(error.statusText)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  function viewTrado(id) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'view')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('View Trado')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()



    Promise
      .all([
        // setStatusAktifOptions(form),
        // setStatusJenisPlatOptions(form),
        // setStatusGerobak(form),
        // setStatusAbsensiSupir(form),
        getMaxLength(form)

      ])
      .then(() => {
        showTrado(form, id)
          .then(trado => {
            setFormBindKeys(form)
            initDropzone(form.data('action'), trado)
            initLookup()
            initDatepicker()
            initSelect2(form.find('.select2bs4'), true)
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
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            $('#crudModal').modal('show')
            $('#crudForm').find(`.ui-datepicker-trigger`).attr('disabled', true)

            form.find(`.hasDatepicker`).prop('readonly', true)
            form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').hide()

            let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
            name.attr('disabled', true)
            name.find('.lookup-toggler').attr('disabled', true)
            $(".dz-hidden-input").prop("disabled", true);

          })
          .catch((error) => {
            showDialog(error.statusText)
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
            if (index == "isisilinder") {
              if (value == 0) {
                value = ""
              }
            }
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

            if (index == 'statusabsensisupir') {
              element.data('current-value', value)
            }

            if (index == 'statusjenisplat') {
              element.data('current-value', value)
            }

            if (index == 'statusaktifnama') {
              element.data('current-value', value)
            }

            if (index == 'statusgerobak') {
              element.data('current-value', value)
            }
          })
          if (response.data.kodetrado_readonly != '') {
            form.find(`[name="kodetrado"]`).attr(response.data.kodetrado_readonly, true)
            form.find(`[name="keterangan"]`).attr(response.data.keterangan_readonly, true)
            form.find(`[name="merek"]`).attr(response.data.merk_readonly, true)
            form.find(`[name="tipe"]`).attr(response.data.tipe_readonly, true)
            form.find(`[name="jenis"]`).attr(response.data.jenis_readonly, true)
            form.find(`[name="model"]`).attr(response.data.model_readonly, true)
            form.find(`[name="tahun"]`).attr(response.data.tahun_readonly, true)
            form.find(`[name="isisilinder"]`).attr(response.data.isisilinder_readonly, true)
            form.find(`[name="warna"]`).attr(response.data.warna_readonly, true)
            form.find(`[name="norangka"]`).attr(response.data.norangka_readonly, true)
            form.find(`[name="nomesin"]`).attr(response.data.nomesin_readonly, true)
            form.find(`[name="jenisbahanbakar"]`).attr(response.data.jenisbahanbakar_readonly, true)
            form.find(`[name="jumlahsumbu"]`).attr(response.data.jumlahsumbu_readonly, true)
            form.find(`[name="statusabsensisupir"]`).attr(response.data.statusabsensisupir_readonly, true)
            form.find(`[name="jumlahroda"]`).attr(response.data.jumlahroda_readonly, true)
            form.find(`[name="jumlahbanserap"]`).attr(response.data.jumlahbanserap_readonly, true)
            form.find(`[name="nostnk"]`).attr(response.data.nostnk_readonly, true)
            form.find(`[name="statusjenisplat"]`).attr(response.data.statusjenisplat_readonly, true)
            form.find(`[name="statusaktif"]`).attr(response.data.statusaktif_readonly, true)
            form.find(`[name="statusgerobak"]`).attr(response.data.statusgerobak_readonly, true)

          }
          resolve(response.data)

        },
        error: error => {
          reject(error)
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

    $(`.statusabsensisupir-lookup`).lookupMaster({
      title: 'Status Absensi Supir Lookup',
      fileName: 'parameterMaster',
      typeSearch: 'ALL',
      searching: 1,
      beforeProcess: function() {
        this.postData = {
          url: `${apiUrl}parameter/combo`,
          grp: 'STATUS ABSENSI SUPIR',
          subgrp: 'STATUS ABSENSI SUPIR',
          searching: 1,
          valueName: `statusabsensisupir`,
          searchText: `statusabsensisupir-lookup`,
          singleColumn: true,
          hideLabel: true,
          title: 'Status Absensi Supir'
        };
      },
      onSelectRow: (statusabsensisupir, element) => {
        $('#crudForm [name=statusabsensisupir]').first().val(statusabsensisupir.id)
        element.val(statusabsensisupir.text)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'));
      },
      onClear: (element) => {
        let status_id_input = element.parents('td').find(`[name="statusabsensisupir"]`).first();
        status_id_input.val('');
        element.val('');
        element.data('currentValue', element.val());
      },
    });

    $(`.statusjenisplat-lookup`).lookupMaster({
      title: 'Status Jenis Plat Lookup',
      fileName: 'parameterMaster',
      typeSearch: 'ALL',
      searching: 1,
      beforeProcess: function() {
        this.postData = {
          url: `${apiUrl}parameter/combo`,
          grp: 'JENIS PLAT',
          subgrp: 'JENIS PLAT',
          searching: 1,
          valueName: `statusjenisplat`,
          searchText: `statusjenisplat-lookup`,
          singleColumn: true,
          hideLabel: true,
          title: 'Status Jenis Plat'
        };
      },
      onSelectRow: (statusjenisplat, element) => {
        $('#crudForm [name=statusjenisplat]').first().val(statusjenisplat.id)
        element.val(statusjenisplat.text)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'));
      },
      onClear: (element) => {
        let status_id_input = element.parents('td').find(`[name="statusjenisplat"]`).first();
        status_id_input.val('');
        element.val('');
        element.data('currentValue', element.val());
      },
    });

    $(`.statusaktif-lookup`).lookupMaster({
      title: 'Status Aktif Lookup',
      fileName: 'parameterMaster',
      typeSearch: 'ALL',
      searching: 1,
      beforeProcess: function() {
        this.postData = {
          url: `${apiUrl}parameter/combo`,
          grp: 'STATUS AKTIF',
          subgrp: 'STATUS AKTIF',
          searching: 1,
          valueName: `statusaktif`,
          searchText: `statusaktif-lookup`,
          singleColumn: true,
          hideLabel: true,
          title: 'Status Aktif'
        };
      },
      onSelectRow: (status, element) => {
        $('#crudForm [name=statusaktif]').first().val(status.id)
        element.val(status.text)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'));
      },
      onClear: (element) => {
        let status_id_input = element.parents('td').find(`[name="statusaktif"]`).first();
        status_id_input.val('');
        element.val('');
        element.data('currentValue', element.val());
      },
    });

    $(`.statusgerobak-lookup`).lookupMaster({
      title: 'Status Aktif Lookup',
      fileName: 'parameterMaster',
      typeSearch: 'ALL',
      searching: 1,
      beforeProcess: function() {
        this.postData = {
          url: `${apiUrl}parameter/combo`,
          grp: 'STATUS GEROBAK',
          subgrp: 'STATUS GEROBAK',
          searching: 1,
          valueName: `statusgerobak`,
          searchText: `statusgerobak-lookup`,
          singleColumn: true,
          hideLabel: true,
          title: 'Status Gerobak'
        };
      },
      onSelectRow: (status, element) => {
        $('#crudForm [name=statusgerobak]').first().val(status.id)
        element.val(statusgerobak.text)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'));
      },
      onClear: (element) => {
        let status_id_input = element.parents('td').find(`[name="statusgerobak"]`).first();
        status_id_input.val('');
        element.val('');
        element.data('currentValue', element.val());
      },
    });
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
    $('.dropzone').each((index, element) => {
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
          minFilesize: 100, // Set the minimum file size in kilobytes
          paramName: $(element).data('field'),
          init: function() {
            dropzones.push(this)
            this.on("addedfile", function(file) {
              if (this.files.length > 5) {
                this.removeFile(file);
              }

              if ($(element).data('field') == 'photobpkb' || $(element).data('field') == 'photostnk') {

                if (file.size < (this.options.minFilesize * 1024)) {
                  showDialog('ukuran file minimal 100 kb')
                  this.removeFile(file);

                }
              }
            });
          }
        })
      }

      element.dropzone.removeAllFiles()

      if (action == 'edit' || action == 'delete' || action == 'view') {
        assignAttachment(element.dropzone, data)
      }
    })
  }


  function assignAttachment(dropzone, data) {
    const paramName = dropzone.options.paramName
    const type = paramName.substring(5)
    let buttonRemoveDropzone = `<i class="fas fa-times-circle"></i>`
    if (data[paramName] == '') {
      $('.dropzone').each((index, element) => {
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
            minFilesize: 100, // Set the minimum file size in kilobytes
            paramName: $(element).data('field'),
            init: function() {
              dropzones.push(this)
              this.on("addedfile", function(file) {
                if (this.files.length > 5) {
                  this.removeFile(file);
                }

                if ($(element).data('field') == 'photobpkb' || $(element).data('field') == 'photostnk') {

                  if (file.size < (this.options.minFilesize * 1024)) {
                    showDialog('ukuran file minimal 100 kb')
                    this.removeFile(file);

                  }
                }
              });
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


  // const setStatusGerobak = function(relatedForm) {
  //   return new Promise((resolve, reject) => {
  //     relatedForm.find('[name=statusgerobak]').empty()
  //     relatedForm.find('[name=statusgerobak]').append(
  //       new Option('-- PILIH STATUS GEROBAK --', '', false, true)
  //     ).trigger('change')

  //     $.ajax({
  //       url: `${apiUrl}parameter`,
  //       method: 'GET',
  //       dataType: 'JSON',
  //       headers: {
  //         Authorization: `Bearer ${accessToken}`
  //       },
  //       data: {
  //         limit: 0,
  //         filters: JSON.stringify({
  //           "groupOp": "AND",
  //           "rules": [{
  //             "field": "grp",
  //             "op": "cn",
  //             "data": "STATUS GEROBAK"
  //           }]
  //         })
  //       },
  //       success: response => {
  //         response.data.forEach(jenisPlat => {
  //           let option = new Option(jenisPlat.text, jenisPlat.id)

  //           relatedForm.find('[name=statusgerobak]').append(option).trigger('change')
  //         });

  //         resolve()
  //       },
  //       error: error => {
  //         reject(error)
  //       }
  //     })
  //   })
  // }

  // const setStatusAbsensiSupir = function(relatedForm) {
  //   return new Promise((resolve, reject) => {
  //     relatedForm.find('[name=statusabsensisupir]').empty()
  //     relatedForm.find('[name=statusabsensisupir]').append(
  //       new Option('-- PILIH STATUS ABSENSI SUPIR --', '', false, true)
  //     ).trigger('change')

  //     $.ajax({
  //       url: `${apiUrl}parameter`,
  //       method: 'GET',
  //       dataType: 'JSON',
  //       headers: {
  //         Authorization: `Bearer ${accessToken}`
  //       },
  //       data: {
  //         limit: 0,
  //         filters: JSON.stringify({
  //           "groupOp": "AND",
  //           "rules": [{
  //             "field": "grp",
  //             "op": "cn",
  //             "data": "STATUS ABSENSI SUPIR"
  //           }]
  //         })
  //       },
  //       success: response => {
  //         response.data.forEach(jenisPlat => {
  //           let option = new Option(jenisPlat.text, jenisPlat.id)

  //           relatedForm.find('[name=statusabsensisupir]').append(option).trigger('change')
  //         });

  //         resolve()
  //       },
  //       error: error => {
  //         reject(error)
  //       }
  //     })
  //   })
  // }

  // const setStatusJenisPlatOptions = function(relatedForm) {
  //   return new Promise((resolve, reject) => {
  //     relatedForm.find('[name=statusjenisplat]').empty()
  //     relatedForm.find('[name=statusjenisplat]').append(
  //       new Option('-- PILIH JENIS PLAT --', '', false, true)
  //     ).trigger('change')

  //     $.ajax({
  //       url: `${apiUrl}parameter`,
  //       method: 'GET',
  //       dataType: 'JSON',
  //       headers: {
  //         Authorization: `Bearer ${accessToken}`
  //       },
  //       data: {
  //         limit: 0,
  //         filters: JSON.stringify({
  //           "groupOp": "AND",
  //           "rules": [{
  //             "field": "grp",
  //             "op": "cn",
  //             "data": "JENIS PLAT"
  //           }]
  //         })
  //       },
  //       success: response => {
  //         response.data.forEach(jenisPlat => {
  //           let option = new Option(jenisPlat.text, jenisPlat.id)

  //           relatedForm.find('[name=statusjenisplat]').append(option).trigger('change')
  //         });

  //         resolve()
  //       },
  //       error: error => {
  //         reject(error)
  //       }
  //     })
  //   })
  // }

  // const setStatusAktifOptions = function(relatedForm) {
  //   return new Promise((resolve, reject) => {
  //     relatedForm.find('[name=statusaktif]').empty()
  //     relatedForm.find('[name=statusaktif]').append(
  //       new Option('-- PILIH STATUS AKTIF --', '', false, true)
  //     ).trigger('change')

  //     $.ajax({
  //       url: `${apiUrl}parameter`,
  //       method: 'GET',
  //       dataType: 'JSON',
  //       headers: {
  //         Authorization: `Bearer ${accessToken}`
  //       },
  //       data: {
  //         limit: 0,
  //         filters: JSON.stringify({
  //           "groupOp": "AND",
  //           "rules": [{
  //             "field": "grp",
  //             "op": "cn",
  //             "data": "STATUS AKTIF"
  //           }]
  //         })
  //       },
  //       success: response => {
  //         response.data.forEach(statusAktif => {
  //           let option = new Option(statusAktif.text, statusAktif.id)

  //           relatedForm.find('[name=statusaktif]').append(option).trigger('change')
  //         });

  //         resolve()
  //       },
  //       error: error => {
  //         reject(error)
  //       }
  //     })
  //   })
  // }

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


  function approvalMesin(id) {
    event.preventDefault()

    let form = $('#crudForm')
    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')

    $.ajax({
      url: `${apiUrl}trado/approvalmesin`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        Id: selectedRows,
        table: 'trado'
      },
      success: response => {
        $('#crudForm').trigger('reset')
        $('#crudModal').modal('hide')

        $('#jqGrid').jqGrid().trigger('reloadGrid');
        selectedRows = []
        $('#gs_').prop('checked', false)
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
      $('#processingLoader').addClass('d-none')
      $(this).removeAttr('disabled')
    })
  }

  function approvalPersneling(id) {
    event.preventDefault()

    let form = $('#crudForm')
    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')

    $.ajax({
      url: `${apiUrl}trado/approvalpersneling`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        Id: selectedRows,
        table: 'trado'
      },
      success: response => {
        $('#crudForm').trigger('reset')
        $('#crudModal').modal('hide')

        $('#jqGrid').jqGrid().trigger('reloadGrid');
        selectedRows = []
        $('#gs_').prop('checked', false)
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
      $('#processingLoader').addClass('d-none')
      $(this).removeAttr('disabled')
    })
  }


  function approvalGardan(id) {
    event.preventDefault()

    let form = $('#crudForm')
    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')

    $.ajax({
      url: `${apiUrl}trado/approvalgardan`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        Id: selectedRows,
        table: 'trado'
      },
      success: response => {
        $('#crudForm').trigger('reset')
        $('#crudModal').modal('hide')

        $('#jqGrid').jqGrid().trigger('reloadGrid');
        selectedRows = []
        $('#gs_').prop('checked', false)
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
      $('#processingLoader').addClass('d-none')
      $(this).removeAttr('disabled')
    })
  }

  function approvalSaringanHawa(id) {
    event.preventDefault()

    let form = $('#crudForm')
    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')

    $.ajax({
      url: `${apiUrl}trado/approvalsaringanhawa`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        Id: selectedRows,
        table: 'trado'
      },
      success: response => {
        $('#crudForm').trigger('reset')
        $('#crudModal').modal('hide')

        $('#jqGrid').jqGrid().trigger('reloadGrid');
        selectedRows = []
        $('#gs_').prop('checked', false)
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
      $('#processingLoader').addClass('d-none')
      $(this).removeAttr('disabled')
    })
  }

  function approvalHistoryTradoMilikMandor(id) {
    event.preventDefault()

    let form = $('#crudForm')
    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')

    $.ajax({
      url: `${apiUrl}trado/approvalhistorytradomilikmandor`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        Id: selectedRows,
        table: 'trado'
      },
      success: response => {
        $('#crudForm').trigger('reset')
        $('#crudModal').modal('hide')

        $('#jqGrid').jqGrid().trigger('reloadGrid');
        selectedRows = []
        $('#gs_').prop('checked', false)
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
      $('#processingLoader').addClass('d-none')
      $(this).removeAttr('disabled')
    })
  }

  function approvalHistoryTradoMilikSupir(id) {
    event.preventDefault()

    let form = $('#crudForm')
    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')

    $.ajax({
      url: `${apiUrl}trado/approvalhistorytradomiliksupir`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        Id: selectedRows,
        table: 'trado'
      },
      success: response => {
        $('#crudForm').trigger('reset')
        $('#crudModal').modal('hide')

        $('#jqGrid').jqGrid().trigger('reloadGrid');
        selectedRows = []
        $('#gs_').prop('checked', false)
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
      $('#processingLoader').addClass('d-none')
      $(this).removeAttr('disabled')
    })
  }


  function approvenonaktif() {

    event.preventDefault()

    let form = $('#crudForm')
    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')

    $.ajax({
      url: `${apiUrl}trado/approvalnonaktif`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        Id: selectedRows,
        nama: selectedRowsTrado
      },
      success: response => {
        $('#crudForm').trigger('reset')
        $('#crudModal').modal('hide')

        $('#jqGrid').jqGrid().trigger('reloadGrid');
        selectedRows = []
        selectedRowsTrado = []
        $('#gs_').prop('checked', false)
      },
      error: error => {
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

  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: `${apiUrl}trado/field_length`,
          method: 'GET',
          dataType: 'JSON',
          headers: {
            'Authorization': `Bearer ${accessToken}`
          },
          success: response => {
            $.each(response.data, (index, value) => {

              if (value !== null && value !== 0 && value !== undefined) {
                form.find(`[name=${index}]`).attr('maxlength', value)
                if (index == 'tahun') {
                  form.find(`[name=tahun]`).attr('maxlength', 4)
                }
                if (index == 'norangka') {
                  form.find(`[name=norangka]`).attr('maxlength', 20)
                }
                if (index == 'nostnk') {
                  form.find(`[name=nostnk]`).attr('maxlength', 50)
                }
                if (index == 'kodetrado') {
                  form.find(`[name=kodetrado]`).attr('maxlength', 12)
                }
                if (index == 'nomesin') {
                  form.find(`[name=nomesin]`).attr('maxlength', 20)
                }
                if (index == 'nobpkb') {
                  form.find(`[name=nobpkb]`).attr('maxlength', 15)
                }

              }

              if (index == 'jumlahsumbu') {
                form.find(`[name=jumlahsumbu]`).attr('maxlength', 2)
              }
              if (index == 'isisilinder') {
                form.find(`[name=isisilinder]`).attr('maxlength', 5)
              }
              if (index == 'jumlahroda') {
                form.find(`[name=jumlahroda]`).attr('maxlength', 2)
              }
              if (index == 'jumlahbanserap') {
                form.find(`[name=jumlahbanserap]`).attr('maxlength', 2)
              }
            })
            dataMaxLength = response.data
            form.attr('has-maxlength', true)
            resolve()
          },
          error: error => {
            showDialog(error.statusText)
            reject()
          }
        })
      })
    } else {
      return new Promise((resolve, reject) => {
        $.each(dataMaxLength, (index, value) => {
          if (value !== null && value !== 0 && value !== undefined) {
            form.find(`[name=${index}]`).attr('maxlength', value)
            if (index == 'tahun') {
              form.find(`[name=tahun]`).attr('maxlength', 4)
            }
            if (index == 'norangka') {
              form.find(`[name=norangka]`).attr('maxlength', 20)
            }
            if (index == 'nostnk') {
              form.find(`[name=nostnk]`).attr('maxlength', 50)
            }
            if (index == 'kodetrado') {
              form.find(`[name=kodetrado]`).attr('maxlength', 12)
            }
            if (index == 'nomesin') {
              form.find(`[name=nomesin]`).attr('maxlength', 20)
            }
            if (index == 'nobpkb') {
              form.find(`[name=nobpkb]`).attr('maxlength', 15)
            }

          }

          if (index == 'jumlahsumbu') {
            form.find(`[name=jumlahsumbu]`).attr('maxlength', 2)
          }
          if (index == 'isisilinder') {
            form.find(`[name=isisilinder]`).attr('maxlength', 5)
          }
          if (index == 'jumlahroda') {
            form.find(`[name=jumlahroda]`).attr('maxlength', 2)
          }
          if (index == 'jumlahbanserap') {
            form.find(`[name=jumlahbanserap]`).attr('maxlength', 2)
          }
        })
        resolve()
      })
    }
  }
</script>
@endpush()