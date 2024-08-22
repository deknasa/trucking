<div class="modal modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="crudForm">
      <div class="modal-content">

        <div class="modal-header">
          <p class="modal-title" id="crudModalTitle"></p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          </button>
        </div>
        <form action="" method="post">
          <div class="modal-body">
            <div class="row form-group">
              <input type="hidden" name="id" hidden class="form-control" readonly>

              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">nama stok <span class="text-danger">*</span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="namastok" class="form-control">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">nama terpusat </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="namaterpusat" class="form-control">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  status aktif <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                {{-- <select name="statusaktif" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH STATUS AKTIF --</option>
                </select> --}}
                <input type="hidden" name="statusaktif">
                <input type="text" name="statusaktifnama" data-target-name="statusaktif" id="statusaktifnama" class="form-control lg-form statusaktif-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  status reuse <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="statusreuse">
                <input type="text" name="statusreusenama" data-target-name="statusreuse" id="statusreusenama" class="form-control lg-form statusreuse-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  status service rutin
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="statusservicerutin">
                <input type="text" name="statusservicerutinnama" data-target-name="statusservicerutin" id="statusservicerutinnama" class="form-control lg-form statusservicerutin-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">kelompok <span class="text-danger">*</span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="kelompok" id="kelompok" class="form-control kelompok-lookup">
                <input type="text" id="kelompokId" name="kelompok_id" readonly hidden>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">sub kelompok <span class="text-danger">*</span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="subkelompok" id="subkelompok" class="form-control subkelompok-lookup">
                <input type="text" id="subkelompokId" name="subkelompok_id" readonly hidden>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">kategori <span class="text-danger">*</span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="kategori" id="kategori" class="form-control kategori-lookup">
                <input type="text" id="kategoriId" name="kategori_id" readonly hidden>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">merk </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="merk" id="merk" class="form-control merk-lookup">
                <input type="text" id="merkId" name="merk_id" readonly hidden>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">jenis trado </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="jenistrado" id="jenistrado" class="form-control jenistrado-lookup">
                <input type="text" id="jenistradoId" name="jenistrado_id" readonly hidden>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">satuan </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="satuan" id="satuan" class="form-control satuan-lookup">
                <input type="text" id="satuanId" name="satuan_id" readonly hidden>
              </div>
            </div>

            <div class="row form-group">

              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">keterangan</label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="keterangan" class="form-control">
              </div>
            </div>

            <div id="kelompok-ban">
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-2">
                  <label class="col-form-label">
                    status ban <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-10">
                  <input type="hidden" name="statusban">
                  <input type="text" name="statusservicerutinnama" data-target-name="statusban" id="statusservicerutinnama" class="form-control lg-form statusban-lookup">
                </div>
              </div>

              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-2">
                  <label class="col-form-label">Total vulkanisir</label>
                </div>
                <div class="col-12 col-sm-9 col-md-10">
                  <input type="text" name="totalvulkanisir" style="text-align:right" disabled class="form-control">
                </div>
              </div>

              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-2">
                  <label class="col-form-label">vulkanisir awal</label>
                </div>
                <div class="col-12 col-sm-9 col-md-10">
                  <input type="text" name="vulkanisirawal" style="text-align:right" class="form-control">
                </div>
              </div>

            </div>

            <div class="row form-group">

              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">qty min </label>

              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" name="qtymin" style="text-align:right" class="form-control ">
              </div>

              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">qty max </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" name="qtymax" style="text-align:right" class="form-control ">
              </div>
            </div>
            <div class="row form-group">

              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">harga beli min </label>

              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" name="hargabelimin" style="text-align:right" class="form-control ">
              </div>

              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">harga beli max </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" name="hargabelimax" style="text-align:right" class="form-control ">
              </div>
            </div>

            <div class="row form-group">
              <div class="col">
                <div class="row mb-2">
                  <div class="col">
                    <label class="col-form-label">Upload Foto Stok</label>
                  </div>
                </div>
                <div class="dropzone" data-field="gambar" id="my-dropzone"></div>

                <div class="dz-preview dz-file-preview">
                  <div class="dz-details">
                    <img data-dz-thumbnail />
                  </div>
                </div>
                <!-- <div class="dropzone" data-field="gambar" style="padding: 0; min-width: 202px !important; min-height: 234px !important">
                  <div class="fallback">
                    <input name="gambar" type="file" />
                  </div>
                  <div class="dz-preview dz-file-preview">
                    <div class="dz-details" style="display: flex;">
                      <img data-dz-thumbnail width="100%" />
                    </div>
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

  let hasFormBindKeys = false
  let modalBody = $('#crudModal').find('.modal-body').html()
  let dropzones = []
  var dataReuse = []
  var data_id

  let dataMaxLength = []


  $(document).ready(function() {
    $(document).on('dblclick', '[data-dz-thumbnail]', handleImageClick)
    $(document).on('click', '.rmv', function(event) {
      deleteRow($(this).parents('tr'))
    })
    $(`#kelompok-ban`).hide();

    $(document).on('change', '#statusreuse', function(event) {
      let reuse = 0
      if (dataReuse.length) {
        $.each(dataReuse, (index, data) => {
          if (data.text == "REUSE") {
            reuse = data.id
          }
        })
      }
      if ($(this).val() == reuse) {
        $('#crudForm').find('[name=vulkanisirawal]').attr('readonly', false);
      } else {
        $('#crudForm').find('[name=vulkanisirawal]').attr('readonly', true);
        $('#crudForm').find('[name=vulkanisirawal]').val('');
      }
    })

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
      formData.delete(`qtymin`);
      $('#crudForm').find(`[name="qtymin"]`).each((index, element) => {
        formData.append(`qtymin`, AutoNumeric.getNumber($(`#crudForm [name="qtymin"]`)[index]))
      })
      formData.delete(`qtymax`);
      $('#crudForm').find(`[name="qtymax"]`).each((index, element) => {
        formData.append(`qtymax`, AutoNumeric.getNumber($(`#crudForm [name="qtymax"]`)[index]))
      })
      formData.delete(`hargabelimin`);
      $('#crudForm').find(`[name="hargabelimin"]`).each((index, element) => {
        formData.append(`hargabelimin`, AutoNumeric.getNumber($(`#crudForm [name="hargabelimin"]`)[index]))
      })
      formData.delete(`hargabelimax`);
      $('#crudForm').find(`[name="hargabelimax"]`).each((index, element) => {
        formData.append(`hargabelimax`, AutoNumeric.getNumber($(`#crudForm [name="hargabelimax"]`)[index]))
      })

      formData.delete(`vulkanisirawal`);
      $('#crudForm').find(`[name="vulkanisirawal"]`).each((index, element) => {
        formData.append(`vulkanisirawal`, AutoNumeric.getNumber($(`#crudForm [name="vulkanisirawal"]`)[index]))
      })



      formData.append('sortIndex', $('#jqGrid').getGridParam().sortname)
      formData.append('sortOrder', $('#jqGrid').getGridParam().sortorder)
      formData.append('filters', $('#jqGrid').getGridParam('postData').filters)
      formData.append('info', info)
      formData.append('indexRow', indexRow)
      formData.append('accessTokenTnl', accessTokenTnl)
      formData.append('page', page)
      formData.append('limit', limit)

      if (form.data('action') == 'add') {
        url = `${apiUrl}stok`
      } else if (form.data('action') == 'edit') {
        url = `${apiUrl}stok/${Id}`
        formData.append('_method', 'PATCH')
      } else if (form.data('action') == 'delete') {
        url = `${apiUrl}stok/${Id}`
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

          $('#jqGrid').trigger('reloadGrid', {
            page: response.data.page
          })

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

  function kodepengeluaran(kodepengeluaran) {
    $('#crudForm').find('[name=statusaktif]').val(kodepengeluaran).trigger('change');
    $('#crudForm').find('[name=statusaktif_id]').val(kodepengeluaran);
  }

  $('#crudModal').on('shown.bs.modal', () => {
    let form = $('#crudForm')

    setFormBindKeys(form)

    activeGrid = null
    data_id = $('#crudForm').find('[name=id]').val();
    form.find('#btnSubmit').prop('disabled', false)
    if (form.data('action') == "view") {
      form.find('#btnSubmit').prop('disabled', true)
    }

    initDatepicker()
    initLookup()
    // initSelect2(form.find(`[name="statusaktif"]`))
    // initSelect2(form.find(`[name="statusreuse"]`))
    // initSelect2(form.find(`[name="statusban"]`))
    // initSelect2(form.find(`[name="statusservicerutin"]`))
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    $('#crudModal').find('.modal-body').html(modalBody)
    removeEditingBy(data_id)

    activeGrid = '#jqGrid'
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
        table: 'stok'
        
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


  function createStok() {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    $('#crudModalTitle').text('add Stok')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    Promise
      .all([
        setStatusAktifOptions(form),
        setStatusReuseOptions(form),
        setStatusBanOptions(form),
        setStatusServiceRutinOptions(form),
        getMaxLength(form)

      ])
      .then(() => {
        showDefault(form)
          .then(() => {
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            $('#crudModal').modal('show')
            disabledHirarkiKelompok()
          })
          .catch((error) => {
            showDialog(error.statusText)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })

    initDropzone(form.data('action'))
    initAutoNumeric(form.find(`[name="qtymin"]`), {
      'maximumValue': 10000
    })
    initAutoNumeric(form.find(`[name="qtymax"]`), {
      'maximumValue': 10000
    })
    initAutoNumeric(form.find(`[name="hargabelimin"]`))
    initAutoNumeric(form.find(`[name="hargabelimax"]`))
    initAutoNumeric(form.find(`[name="vulkanisirawal"]`), {
      'maximumValue': 100
    })
  }

  function editStok(stokId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Pengeluaran Stok')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusAktifOptions(form),
        setStatusReuseOptions(form),
        setStatusBanOptions(form),
        setStatusServiceRutinOptions(form),
        getMaxLength(form)
      ])
      .then(() => {
        showStok(form, stokId)
          .then((stok) => {
            initDropzone(form.data('action'), stok)
          })
          .then(() => {
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
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

  function deleteStok(stokId) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-trash"></i>
    Delete
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Pengeluaran Stok')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusAktifOptions(form),
        setStatusReuseOptions(form),
        setStatusBanOptions(form),
        setStatusServiceRutinOptions(form),
        getMaxLength(form)
      ])
      .then(() => {
        showStok(form, stokId)
          .then((stok) => {
            initDropzone(form.data('action'), stok)
          })
          .then(() => {
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
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

  function viewStok(stokId) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'view')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('View Pengeluaran Stok')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusAktifOptions(form),
        setStatusReuseOptions(form),
        setStatusBanOptions(form),
        setStatusServiceRutinOptions(form),
        getMaxLength(form)
      ])
      .then(() => {
        showStok(form, stokId)
          .then((stok) => {
            initDropzone(form.data('action'), stok)
          })
          .then(stokId => {
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
            form.find('[name=id]').prop('disabled', false)
          })
          .then(() => {
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            $('#crudModal').modal('show')
            form.find(`.hasDatepicker`).prop('readonly', true)
            form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').remove()
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

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      return new Promise((resolve, reject) => {

        $.ajax({
          url: `${apiUrl}stok/field_length`,
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


          }
        })
        resolve()
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
  const setStatusReuseOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusreuse]').empty()
      relatedForm.find('[name=statusreuse]').append(
        new Option('-- PILIH STATUS REUSE --', '', false, true)
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
              "data": "STATUS REUSE"
            }]
          })
        },
        success: response => {
          response.data.forEach((statusReuse, index) => {
            dataReuse[index] = statusReuse
            // dataReuse[index]['text'] =  statusReuse.text

            let option = new Option(statusReuse.text, statusReuse.id)

            relatedForm.find('[name=statusreuse]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  const setStatusBanOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusban]').empty()
      relatedForm.find('[name=statusban]').append(
        new Option('-- PILIH STATUS BAN --', '', false, true)
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
              "data": "STATUS KONDISI BAN"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusReuse => {
            let option = new Option(statusReuse.text, statusReuse.id)

            relatedForm.find('[name=statusban]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }
  const setStatusServiceRutinOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusservicerutin]').empty()
      relatedForm.find('[name=statusservicerutin]').append(
        new Option('-- PILIH STATUS service rutin --', '', false, true)
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
              "data": "STATUS service rutin"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusReuse => {
            let option = new Option(statusReuse.text, statusReuse.id)

            relatedForm.find('[name=statusservicerutin]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function showDefault(form) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}stok/default`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $.each(response.data, (index, value) => {
            // console.log(value)
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

  function showStok(form, stokId) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}stok/${stokId}`,
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
              initAutoNumeric(element)
              element.val(value)
            } else {
              element.val(value)
            }
          })
          maxLengthForDropzone = 5 - response.count
          resolve(response.data)
          initAutoNumeric(form.find(`[name="qtymin"]`), {
            'maximumValue': 9999
          })
          initAutoNumeric(form.find(`[name="qtymax"]`), {
            'maximumValue': 10000
          })
          initAutoNumeric(form.find(`[name="hargabelimin"]`))
          initAutoNumeric(form.find(`[name="hargabelimax"]`))
          initAutoNumeric(form.find(`[name="vulkanisirawal"]`), {
            'maximumValue': 100
          })
          isKelompokBan(response.data.kelompok_id, response.data.kelompok)
          if (response.statuspakai) {
            $(`#statusreuse`).attr('disabled', true)
            form.find(`[name="vulkanisirawal"]`).attr('disabled', true)
          }

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })

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
            checkIsPhotExist(this.files, data)
            dropzones.push(this)
            this.on("addedfile", function(file) {
              if (this.files.length > 5) {
                this.removeFile(file);
              }
              checkIsPhotExist(this.files, data)
            });

          },
          removedfile: function(file) {

            file.previewElement.remove();
            checkIsPhotExist(this.files, data)

          }
        })
      }

      element.dropzone.removeAllFiles()

      if (action == 'edit' || action == 'delete' || action == 'view') {
        assignAttachment(element.dropzone, data)
      }
    })
  }

  function checkIsPhotExist(files, data) {

    if (files.length > 0) {
      $('#crudForm').find(`[name="namaterpusat"]`).prop('disabled', false)
    } else {
      $('#crudForm').find(`[name="namaterpusat"]`).prop('disabled', true)
    }
    $('#crudForm').find(`[name="namaterpusat"]`).prop('disabled', true)
  }

  function assignAttachment(dropzone, data) {
    let buttonRemoveDropzone = `<i class="fas fa-times-circle"></i>`
    const paramName = dropzone.options.paramName
    const type = paramName.substring(5)

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
              console.log(this.files.length);
              checkIsPhotExist(this, data)
              this.on("addedfile", function(file) {
                if (this.files.length > 5) {
                  this.removeFile(file);
                }
                checkIsPhotExist(this.files, data)
              });
            },
            removedfile: function(file) {

              file.previewElement.remove();
              checkIsPhotExist(this.files, data)

            }
          })
        }

        element.dropzone.removeAllFiles()
      })
    } else {

      let files = JSON.parse(data[paramName])
      checkIsPhotExist(files, data)
      files.forEach((file) => {
        getImgURL(`${apiUrl}stok/${file}/ori`, (fileBlob) => {
          let imageFile = new File([fileBlob], file, {
            type: 'image/jpeg',
            lastModified: new Date().getTime()
          }, 'utf-8')

          dropzone.options.addedfile.call(dropzone, imageFile);
          dropzone.options.thumbnail.call(dropzone, imageFile, `${apiUrl}stok/${file}/ori`);
          dropzone.files.push(imageFile)

        })
      })
    }
  }

  function disabledHirarkiKelompok(middle = false) {

    let kategori = $('#crudForm').find(`[name="kategori"]`).parents('.input-group').children()
    kategori.attr('disabled', true)
    kategori.val('')
    kategori.find('.lookup-toggler').attr('disabled', true)
    $('#kategoriId').attr('disabled', true);
    $('#subkelompokId').val('');

    if (middle) {
      return "oke";
    }

    let subkelompok = $('#crudForm').find(`[name="subkelompok"]`).parents('.input-group').children()
    subkelompok.attr('disabled', true)
    subkelompok.val('')
    subkelompok.find('.lookup-toggler').attr('disabled', true)
    $('#subkelompokId').attr('disabled', true);
    $('#subkelompokId').val('');


  }

  function enabledSubKelompok() {
    let subkelompok = $('#crudForm').find(`[name="subkelompok"]`).parents('.input-group').children()
    subkelompok.attr('disabled', false)
    subkelompok.val('')
    subkelompok.find('.lookup-toggler').attr('disabled', false)
    $('#subkelompokId').attr('disabled', false);
    $('#subkelompokId').val('');
  }

  function enabledKategori() {
    let kategori = $('#crudForm').find(`[name="kategori"]`).parents('.input-group').children()
    kategori.attr('disabled', false)
    kategori.val('')
    kategori.find('.lookup-toggler').attr('disabled', false)
    $('#kategoriId').attr('disabled', false);
    $('#kategoriId').val('');
  }

  function isKelompokBan(id = 0, Kelompok = "") {
    $(`#kelompok-ban`).hide();
    if ((id == 1) || (Kelompok == "BAN")) {
      $(`#kelompok-ban`).show();
    }
  }

  function initLookup() {

    $('.jenistrado-lookup').lookupV3({
      title: 'jenis trado Lookup',
      fileName: 'jenistradoV3',
      searching: ['kodemerk'],
      labelColumn: false,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (jenistrado, element) => {
        element.val(jenistrado.kodejenistrado)
        $(`#${element[0]['name']}Id`).val(jenistrado.id)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {

        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.merk-lookup').lookupV3({
      title: 'merk Lookup',
      fileName: 'merkV3',
      searching: ['kodemerk'],
      labelColumn: false,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (merk, element) => {
        element.val(merk.kodemerk)
        $(`#${element[0]['name']}Id`).val(merk.id)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {

        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.kelompok-lookup').lookupV3({
      /**
       title: 'Kelompok Lookup',
       fileName: 'kelompokMaster',
       typeSearch: 'ALL',
       searching: 1,
       beforeProcess: function(test) {
         this.postData = {
           Aktif: 'AKTIF',
           searching: 1,
           valueName: 'kelompok_id',
           searchText: 'kelompok-lookup',
           title: 'Kelompok',
           typeSearch: 'ALL',
         }
       },
       * 
      */
      title: 'Kelompok Lookup',
      fileName: 'kelompokV3',
      searching: ['kodekelompok'],
      labelColumn: false,
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (kelompok, element) => {
        element.val(kelompok.kodekelompok)
        $(`#${element[0]['name']}Id`).val(kelompok.id)
        element.data('currentValue', element.val())
        disabledHirarkiKelompok()
        enabledSubKelompok()
        isKelompokBan(kelompok.id, kelompok.kodekelompok)
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        disabledHirarkiKelompok()
        $(`#${element[0]['name']}Id`).val('')
        element.val('')
        element.data('currentValue', element.val())
        isKelompokBan(0, "")
      }
    })
    $('.subkelompok-lookup').lookupV3({
      title: 'subkelompok Lookup',
      fileName: 'subkelompokV3',
      searching: ['kodesubkelompok'],
      labelColumn: false,
      beforeProcess: function(test) {
        var kelompokId = $(`#kelompokId`).val();
        this.postData = {
          kelompok_id: kelompokId,
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (subkelompok, element) => {
        element.val(subkelompok.kodesubkelompok)
        $(`#${element[0]['name']}Id`).val(subkelompok.id)
        element.data('currentValue', element.val())
        enabledKategori()
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        disabledHirarkiKelompok(true)
        $(`#${element[0]['name']}Id`).val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.kategori-lookup').lookupV3({
      title: 'kategori Lookup',
      fileName: 'kategoriV3',
      searching: ['kodekategori'],
      labelColumn: false,
      beforeProcess: function(test) {
        var subkelompokId = $(`#subkelompokId`).val();
        this.postData = {
          subkelompok_id: subkelompokId,
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (kategori, element) => {
        element.val(kategori.kodekategori)
        $(`#${element[0]['name']}Id`).val(kategori.id)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $(`#${element[0]['name']}Id`).val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    // $('.satuan-lookup').lookupMaster({
    $('.satuan-lookup').lookupV3({
      title: 'satuan Lookup',
      fileName: 'satuanV3',
      searching: ['kodesatuan'],
      labelColumn: false,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (satuan, element) => {
        element.val(satuan.satuan)
        $(`#${element[0]['name']}Id`).val(satuan.id)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $(`#${element[0]['name']}Id`).val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $(`.statusaktif-lookup`).lookupV3({
      title: 'Status Aktif Lookup',
      fileName: 'parameterV3',
      searching: ['keterangan'],
      labelColumn: false,
      beforeProcess: function() {
        this.postData = {
          url: `${apiUrl}parameter/combo`,
          grp: 'STATUS AKTIF',
          subgrp: 'STATUS AKTIF',
        };
      },
      onSelectRow: (status, element) => {
        let elId = element.data('targetName')
        $(`#crudForm [name=${elId}]`).first().val(status.id)
        element.val(status.text)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'));
      },
      onClear: (element) => {
        let elId = element.data('targetName')
        $(`#crudForm [name=${elId}]`).first().val('')
        element.val('')
        element.data('currentValue', element.val())
      },
    });
    $(`.statusreuse-lookup`).lookupV3({
      title: 'Status REUSE Lookup',
      fileName: 'parameterV3',
      searching: ['keterangan'],
      labelColumn: false,
      beforeProcess: function() {
        this.postData = {
          url: `${apiUrl}parameter/combo`,
          grp: 'STATUS REUSE',
          subgrp: 'STATUS REUSE',
        };
      },
      onSelectRow: (status, element) => {
        let elId = element.data('targetName')
        $(`#crudForm [name=${elId}]`).first().val(status.id)
        element.val(status.text)
        element.data('currentValue', element.val())
        
        let reuse = 0
        
        if (dataReuse.length) {
          $.each(dataReuse, (index, data) => {
            if (data.text == "REUSE") {
              reuse = data.id
            }
          })
        }
        if (status.id == reuse) {
          $('#crudForm').find('[name=vulkanisirawal]').attr('readonly', false);
        } else {
          $('#crudForm').find('[name=vulkanisirawal]').attr('readonly', true);
          $('#crudForm').find('[name=vulkanisirawal]').val('');
        }

      },
      onCancel: (element) => {
        element.val(element.data('currentValue'));
      },
      onClear: (element) => {
        let elId = element.data('targetName')
        $(`#crudForm [name=${elId}]`).first().val('')
        element.val('')
        element.data('currentValue', element.val())
      },
    });
    $(`.statusservicerutin-lookup`).lookupV3({
      title: 'Status status service rutin Lookup',
      fileName: 'parameterV3',
      searching: ['keterangan'],
      labelColumn: false,
      beforeProcess: function() {
        this.postData = {
          url: `${apiUrl}parameter/combo`,
          grp: 'STATUS service rutin',
          subgrp: 'STATUS service rutin',
        };
      },
      onSelectRow: (status, element) => {
        let elId = element.data('targetName')
        $(`#crudForm [name=${elId}]`).first().val(status.id)
        element.val(status.text)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'));
      },
      onClear: (element) => {
        let elId = element.data('targetName')
        $(`#crudForm [name=${elId}]`).first().val('')
        element.val('')
        element.data('currentValue', element.val())
      },
    });
    $(`.statusban-lookup`).lookupV3({
      title: 'STATUS KONDISI BAN Lookup',
      fileName: 'parameterV3',
      searching: ['keterangan'],
      labelColumn: false,
      beforeProcess: function() {
        this.postData = {
          url: `${apiUrl}parameter/combo`,
          grp: 'STATUS KONDISI BAN',
          subgrp: 'STATUS KONDISI BAN',
        };
      },
      onSelectRow: (status, element) => {
        let elId = element.data('targetName')
        $(`#crudForm [name=${elId}]`).first().val(status.id)
        element.val(status.text)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'));
      },
      onClear: (element) => {
        let elId = element.data('targetName')
        $(`#crudForm [name=${elId}]`).first().val('')
        element.val('')
        element.data('currentValue', element.val())
      },
    });


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

  function cekValidasidelete(Id,Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}stok/${Id}/cekValidasi`,
      method: 'POST',
      dataType: 'JSON',
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      data: {
        aksi: Aksi
      },      
      success: response => {
        var kondisi = response.kondisi
        if (kondisi == true) {
          showDialog(response.message['keterangan'])
        } else {
          if(Aksi=='edit') {
            editStok(Id)
          } else {
            deleteStok(Id)
          }
          // deleteStok(Id)
        }

      }
    })
  }
</script>
@endpush()