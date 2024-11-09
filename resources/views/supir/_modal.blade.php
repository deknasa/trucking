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
                    <div id="pesan-enter-noktp">Setelah mengisi Noktp tekan <b>enter</b> </div>
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
                    <input type="text" name="telp" class="form-control numbernoseparate" maxlength="15">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">No SIM <span class="text-danger">*</span></label>
                  <div class="col-sm-10">
                    <input type="text" name="nosim" id="nosim" maxlength="16" class="form-control numbernoseparate">
                  </div>
                </div>

                <div class="row form-group statuspostingtnl">
                  <div class="col-12 col-md-2">
                    <label class="col-form-label">
                      STATUS POSTING TNL <span class="text-danger">*</span></label>
                  </div>
                  <div class="col-12 col-md-10">
                    <input type="hidden" name="statuspostingtnl">
                    <input type="text" name="statuspostingtnlnama" id="statuspostingtnlnama" class="form-control lg-form statuspostingtnl-lookup">
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
                    <input type="hidden" name="statusaktif">
                    <input type="text" name="statusaktifnama" id="statusaktifnama" class="form-control lg-form statusaktif-lookup">
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
                    <input type="text" name="pemutihansupir_nobukti" class="form-control" readonly>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Nominal Pinjaman</label>
                  <div class="col-sm-10">
                    <input type="text" name="nominalpinjamansaldoawal" class="form-control text-right" readonly>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-2 col-form-label">Milik Mandor</label>
                  <div class="col-sm-10">
                    <input type="hidden" name="mandor_id">
                    <input type="text" name="mandor" class="form-control" readonly>
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
                    <label class="col-form-label">Upload Foto SKCK </label>
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
                    <label class="col-form-label">Upload Foto Domisili</label>
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
                    <label class="col-form-label">Upload Foto Vaksin</label>
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
  Dropzone.autoDiscover = false

  let dropzones = []
  let hasFormBindKeys = false
  var data_id
  let modalBody = $('#crudModal').find('.modal-body').html()
  let linkPdf
  let noktp_readonly = '';
  let dataReadonly = '';
  $(document).ready(function() {

    linkPdf = document.createElement('a');
    $(document).on('dblclick', '[data-dz-thumbnail]', handleImageClick)

    $(document).on('dblclick', '.dropzonePdf .dz-preview', handlePDFClick)

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
      formData.append('accessTokenTnl', accessTokenTnl)
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
          irow = (response.data.position - 1) % limit
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


  $('#crudModal').on('shown.bs.modal', () => {
    data_id = $('#crudForm').find('[name=id]').val();

    //   let form = $('#crudForm')

    //   setFormBindKeys(form)

    //   activeGrid = null

    //   getMaxLength(form)
    // initLookup()
  })
  $('#crudModal').on('hidden.bs.modal', () => {
    $('#crudModal').find('.modal-body').html(modalBody)
    dataReadonly = '';
    noktp_readonly = '';
    activeGrid = '#jqGrid'
    removeEditingBy(data_id)
    $('#crudForm [name=nominalpinjamansaldoawal]').attr('value', '')
    dropzones.forEach(dropzone => {
      dropzone.removeAllFiles()
    })
  })

  function removeEditingBy(id) {
    if (id == "") {
      return ;
    }
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
        table: 'supir'

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
  $('#crudForm [name=noktp]').focus(function() {
    $(`#pesan-enter-noktp`).show();
  });

  $('#crudForm [name=noktp]').blur(function() {
    $(`#pesan-enter-noktp`).hide();
  });

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

            if (index == "namasupir") {
              element.prop("readonly", true)
            }
            if (index == "tglmasuk") {
              element.val(dateFormat(''))
            }
          })
          initDropzone('edit', response.data)
          initDropzonePdf('edit', response.data)
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
  $('#crudForm [name=noktp]').keydown(function(e) {
    if (e.keyCode == 9) {
      $(this).trigger("enterKey");
    }
  });


  function createSupir() {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')
    form.find('#btnSubmit').prop('disabled', false)

    form.find('[name]').removeAttr('disabled')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('add Supir')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        // setStatusAktifOptions(form),
        // setStatusPostingTnlOptions(form),
        setTampilan(form)
      ])
      .then(() => {
        showDefault(form)
          .then(() => {

            form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').show()
            let name = $('#crudForm').find(`[name=mandor]`).parents('.input-group').children()
            name.attr('disabled', false)
            name.find('.lookup-toggler').attr('disabled', false)
            $(`#crudForm [name=mandor]`).prop('readonly', false)

            let mandor = $('#crudForm').find(`[name=mandor]`).css({
              background: '#e9ecef'
            })
            $('#crudModal').modal('show')

            form.find(`[name="noktp"]`).attr('readonly', false)
            form.find(`[name="namasupir"]`).attr('readonly', false)
            form.find(`[name="tgllahir"]`).attr('readonly', false)
            form.find(`[name="alamat"]`).attr('readonly', false)
            form.find(`[name="kota"]`).attr('readonly', false)
            form.find(`[name="nokk"]`).attr('readonly', false)
            form.find(`[name="tglmasuk"]`).attr('readonly', false)
            form.find(`[name="statusaktif"]`).attr('readonly', false)
            form.find(`[name="keterangan"]`).attr('readonly', false)

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
    // initSelect2(form.find('.select2bs4'), true)
    form.find('[name]').removeAttr('disabled')
  }

  function editSupir(id) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')
    form.find('#btnSubmit').prop('disabled', false)

    form.find('[name]').removeAttr('disabled')
    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    $('#crudModalTitle').text('Edit Supir')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        // setStatusAktifOptions(form),
        // setStatusPostingTnlOptions(form),
        setTampilan(form)
      ])
      .then(() => {
        showSupir(form, id)
          .then(supir => {
            setFormBindKeys(form)
            initDropzone(form.data('action'), supir)
            initDropzonePdf(form.data('action'), supir)
            initLookup()
            initDatepicker()
            // initSelect2(form.find('.select2bs4'), true)
            form.find('[name]').removeAttr('disabled')
            form.find('[name=statuspostingtnl]').prop('disabled', true)
          })
          .then(() => {
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            $('#crudModal').modal('show')
            form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').show()
            let name = $('#crudForm').find(`[name=mandor]`).parents('.input-group').children()
            name.attr('disabled', true)
            name.find('.lookup-toggler').attr('disabled', true)
            $(`#crudForm [name=mandor]`).prop('readonly', true)
            let mandor = $('#crudForm').find(`[name=mandor]`).css({
              background: '#e9ecef'
            })
            if(dataReadonly != ''){
              $('#crudForm').find(`[name="tgllahir"].hasDatepicker`).parent('.input-group').find('.input-group-append').hide()
              $('#crudForm').find(`[name="tglmasuk"].hasDatepicker`).parent('.input-group').find('.input-group-append').hide()
            }
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
    form.find('#btnSubmit').prop('disabled', false)

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-trash"></i>
              Delete
    `)
    $('#crudModalTitle').text('Delete Supir')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        // setStatusAktifOptions(form),
        // setStatusPostingTnlOptions(form),
        setTampilan(form)
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
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            $('#crudModal').modal('show')
            form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').show()

            // $(`#crudForm [name=mandor]`).parents('.form-group').hide()
          })
          .catch((error) => {
            showDialog(error.statusText)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  function viewSupir(id) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'view')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.find('#btnSubmit').prop('disabled', true)


    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('View Supir')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        // setStatusAktifOptions(form),
        // setStatusPostingTnlOptions(form),
        setTampilan(form)
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
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            $('#crudModal').modal('show')
            form.find(`.hasDatepicker`).prop('readonly', true)
            form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').hide()
            let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
            name.attr('disabled', true)
            name.find('.lookup-toggler').attr('disabled', true)
            $(".dz-hidden-input").prop("disabled", true);
            // $(`#crudForm [name=mandor]`).parents('.form-group').hide()

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

            if (index == 'statusaktifnama') {
              element.data('current-value', value)
            }

            if (index == 'statuspostingtnlnama') {
              element.data('current-value', value)
            }
          })
          if (response.data.noktp_readonly != '') {
            noktp_readonly = response.data.noktp_readonly 
            dataReadonly = response.data
            form.find(`[name="noktp"]`).attr(response.data.noktp_readonly, true)
            form.find(`[name="namasupir"]`).attr(response.data.namasupir_readonly, true)
            form.find(`[name="tgllahir"]`).attr(response.data.tgllahir_readonly, true)
            form.find(`[name="alamat"]`).attr(response.data.alamat_readonly, true)
            form.find(`[name="kota"]`).attr(response.data.kota_readonly, true)
            form.find(`[name="nokk"]`).attr(response.data.nokk_readonly, true)
            form.find(`[name="tglmasuk"]`).attr(response.data.tglmasuk_readonly, true)
            form.find(`[name="statusaktif"]`).attr(response.data.statusaktif_readonly, true)
            form.find(`[name="keterangan"]`).attr(response.data.keterangan_readonly, true)

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

    $(`.statuspostingtnl-lookup`).lookupV3({
      title: 'Status Posting TNL Lookup',
      fileName: 'parameterV3',
      searching: ['text'],
      labelColumn: false,
      beforeProcess: function() {
        this.postData = {
          url: `${apiUrl}parameter/combo`,
          grp: 'STATUS POSTING TNL',
          subgrp: 'STATUS POSTING TNL',
        };
      },
      onSelectRow: (statuspostingtnl, element) => {
        $('#crudForm [name=statuspostingtnl]').first().val(statuspostingtnl.id)
        element.val(statuspostingtnl.text)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'));
      },
      onClear: (element) => {
        let status_id_input = element.parents('td').find(`[name="statuspostingtnl"]`).first();
        status_id_input.val('');
        element.val('');
        element.data('currentValue', element.val());
      },
    });

    $(`.statusaktif-lookup`).lookupV3({
      title: 'Status Aktif Lookup',
      fileName: 'parameterV3',
      searching: ['text'],
      labelColumn: false,
      beforeProcess: function() {
        this.postData = {
          url: `${apiUrl}parameter/combo`,
          grp: 'STATUS AKTIF',
          subgrp: 'STATUS AKTIF',
        };
      },
      onSelectRow: (statusaktif, element) => {
        $('#crudForm [name=statusaktif]').first().val(statusaktif.id)
        element.val(statusaktif.text)
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
  }

  function handlePDFClick(event) {
    // pdfName = $('.dropzonePdf .dz-preview').find('.dz-details .dz-filename').text()
    // window.open(`${apiUrl}supir/pdf/suratperjanjian/${pdfName}`);
    window.open($(linkPdf).attr('href'))
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
          minFilesize: 100, // Set the minimum file size in kilobytes
          paramName: $(element).data('field'),
          init: function() {
            dropzones.push(this)
            this.on("addedfile", function(file) {
              if (this.files.length > 5) {
                this.removeFile(file);
              }
              if ($(element).data('field') != 'photosupir') {

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
              } else {
                linkPdf.href = window.URL.createObjectURL(file);

                const currentDropzone = this;
                const reader = new FileReader();
                reader.onload = function(event) {
                  const arrayBuffer = event.target.result;
                  const uint8Array = new Uint8Array(arrayBuffer);

                  // Check for PDF magic numbers in the first few bytes (PDF files start with '%PDF')
                  const isPdf = uint8Array[0] === 0x25 && uint8Array[1] === 0x50 && uint8Array[2] === 0x44 && uint8Array[3] === 0x46;

                  console.log(isPdf)
                  if (!isPdf) {
                    // If the file is not a PDF, remove it from the dropzone
                    currentDropzone.removeFile(file);
                    showDialog('TYPE FILE BUKAN PDF')
                  }
                };

                reader.readAsArrayBuffer(file);
              }
              // $(file.previewElement).find('img').prop('src',appUrl+'/images/pdf_icon.png')
            });
          }
        })
      }
      element.dropzone.removeAllFiles()
      if (action == 'edit' || action == 'delete' || action == 'view') {
        assignAttachmentPdf(element.dropzone, data)
      }

    })
  }

  function assignAttachment(dropzone, data) {
    const paramName = dropzone.options.paramName
    const type = paramName.substring(5)
    let buttonRemoveDropzone = `<i class="fas fa-times-circle"></i>`
    if (data[paramName] == '') {
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
            minFilesize: 100, // Set the minimum file size in kilobytes
            paramName: $(element).data('field'),
            init: function() {
              dropzones.push(this)
              this.on("addedfile", function(file) {
                if (this.files.length > 5) {
                  this.removeFile(file);
                }
                if ($(element).data('field') != 'photosupir') {

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
    let buttonRemoveDropzone = `<i class="fas fa-times-circle"></i>`
    const paramName = dropzone.options.paramName
    const type = paramName.substring(3)
    if (data[paramName] == '') {

      $('.dropzonePdf').each((index, element) => {
        if (!element.dropzone) {
          let newDropzone = new Dropzone(element, {
            url: 'test',
            autoProcessQueue: false,
            addRemoveLinks: true,
            dictRemoveFile: buttonRemoveDropzone,
            acceptedFiles: 'application/pdf',
            paramName: $(element).data('field'),
            init: function() {
              dropzones.push(this)
              this.on("addedfile", function(file) {
                if (this.files.length > 1) {
                  this.removeFile(file);
                } else {
                  linkPdf.href = window.URL.createObjectURL(file);

                  const currentDropzone = this;
                  const reader = new FileReader();
                  reader.onload = function(event) {
                    const arrayBuffer = event.target.result;
                    const uint8Array = new Uint8Array(arrayBuffer);

                    // Check for PDF magic numbers in the first few bytes (PDF files start with '%PDF')
                    const isPdf = uint8Array[0] === 0x25 && uint8Array[1] === 0x50 && uint8Array[2] === 0x44 && uint8Array[3] === 0x46;

                    console.log(isPdf)
                    if (!isPdf) {
                      // If the file is not a PDF, remove it from the dropzone
                      currentDropzone.removeFile(file);
                      showDialog('TYPE FILE BUKAN PDF')
                    }
                  };

                  reader.readAsArrayBuffer(file);
                }
                // $(file.previewElement).find('img').prop('src',appUrl+'/images/pdf_icon.png')
              });
            }
          })
        }

        element.dropzone.removeAllFiles()
      })
    } else {

      let files = JSON.parse(data[paramName])
      console.log(files)
      files.forEach((file) => {
        if (file == '') {
          file = 'no file'
        }

        getImgURL(`${apiUrl}supir/pdf/${type}/${file}`, (fileBlob) => {

          if (file != 'no file') {
            let imageFile = new File([fileBlob], file, {
              type: 'application/pdf',
              lastModified: new Date().getTime()
            }, 'utf-8')

            if (fileBlob.type != 'application/json') {
              $(linkPdf).attr('href', `${apiUrl}supir/pdf/suratperjanjian/${file}`);
              dropzone.options.addedfile.call(dropzone, imageFile);
              // dropzone.options.thumbnail.call(dropzone, imageFile, `${apiUrl}supir/pdf/${type}/${file}`);
              dropzone.files.push(imageFile)
            }


          }
        })
      })
    }
  }


  // const setStatusPostingTnlOptions = function(relatedForm) {
  //   return new Promise((resolve, reject) => {
  //     relatedForm.find('[name=statuspostingtnl]').empty()
  //     relatedForm.find('[name=statuspostingtnl]').append(
  //       new Option('-- PILIH POSTING TNL --', '', false, true)
  //     ).trigger('change')

  //     $.ajax({
  //       url: `${apiUrl}parameter`,
  //       method: 'GET',
  //       dataType: 'JSON',
  //       headers: {
  //         Authorization: `Bearer ${accessToken}`
  //       },
  //       data: {
  //         filters: JSON.stringify({
  //           "groupOp": "AND",
  //           "rules": [{
  //             "field": "grp",
  //             "op": "cn",
  //             "data": "STATUS POSTING TNL"
  //           }]
  //         })
  //       },
  //       success: response => {
  //         response.data.forEach(statuspostingTnl => {
  //           let option = new Option(statuspostingTnl.text, statuspostingTnl.id)

  //           relatedForm.find('[name=statuspostingtnl]').append(option).trigger('change')
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

  const setTampilan = function(relatedForm) {
    return new Promise((resolve, reject) => {
      let data = [];
      data.push({
        name: 'grp',
        value: 'UBAH TAMPILAN'
      })
      data.push({
        name: 'text',
        value: 'SUPIR'
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
              field = field.toLowerCase();
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

  function cekValidasidelete(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}supir/${Id}/cekValidasi`,
      method: 'POST',
      dataType: 'JSON',
      data: {
        aksi: Aksi
      },
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      success: response => {
        var error = response.error
        if (error) {
          showDialog(response)
        } else {
          if (Aksi == 'EDIT') {
            editSupir(Id)
          }
          if (Aksi == 'DELETE') {
            deleteSupir(Id)
          }
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

  function approve() {
    event.preventDefault()

    let form = $('#crudForm')
    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')

    $.ajax({
      url: `${apiUrl}supir/approval`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        Id: selectedRows,
        nama: selectedRowsSupir
      },
      success: response => {
        $('#crudForm').trigger('reset')
        $('#crudModal').modal('hide')

        $('#jqGrid').jqGrid().trigger('reloadGrid');
        selectedRows = []
        selectedRowsSupir = []
        $('#gs_check').prop('checked', false)
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

  function approvenonaktif() {

    event.preventDefault()

    let form = $('#crudForm')
    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')

    $.ajax({
      url: `${apiUrl}supir/approvalnonaktif`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        Id: selectedRows,
        nama: selectedRowsSupir
      },
      success: response => {
        $('#crudForm').trigger('reset')
        $('#crudModal').modal('hide')

        $('#jqGrid').jqGrid().trigger('reloadGrid');
        selectedRows = []
        selectedRowsSupir = []
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

  function approveaktif() {

    event.preventDefault()

    let form = $('#crudForm')
    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')

    $.ajax({
      url: `${apiUrl}supir/approvalaktif`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        Id: selectedRows,
        nama: selectedRowsSupir
      },
      success: response => {
        $('#crudForm').trigger('reset')
        $('#crudModal').modal('hide')

        $('#jqGrid').jqGrid().trigger('reloadGrid');
        selectedRows = []
        selectedRowsSupir = []
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


  function approvalHistorySupirMilikMandor(id) {
    event.preventDefault()

    let form = $('#crudForm')
    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')

    $.ajax({
      url: `${apiUrl}supir/approvalhistorysupirmilikmandor`,
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

  function cekValidasihistory(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}supir/${Id}/cekvalidasihistory`,
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
            editSupirMilikMandor(Id)
          }
        }

      }
    })
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