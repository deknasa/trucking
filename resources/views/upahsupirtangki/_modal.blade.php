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
            <input type="hidden" name="id">

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  Parent
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="parent_id">
                <input type="text" id="parent" name="parent" class="form-control upahsupirtangki-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  Tarif <span class="text-danger"></span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="tariftangki_id">
                <input type="text" id="tariftangki" name="tariftangki" class="form-control tariftangki-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  DARI <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="kotadari_id">
                <input type="text" id="kotadari" name="kotadari" class="form-control kotadari-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  TUJUAN <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="kotasampai_id">
                <input type="text" id="kotaupahsupir" name="kotasampai" class="form-control kotasampai-lookup">
                <!-- <input type="hidden" id="kotatarif" name="kotasampai" disabled class="form-control"> -->
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  PENYESUAIAN
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="penyesuaian" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  JARAK <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <div class="input-group">
                  <input type="text" name="jarak" class="form-control" style="text-align: right">
                  <div class="input-group-append">
                    <span class="input-group-text" style="font-weight: bold;">KM</span>
                  </div>
                </div>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  STATUS AKTIF <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="statusaktif">
                <input type="text" name="statusaktifnama" id="statusaktifnama" class="form-control lg-form status-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  TGL MULAI BERLAKU <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <div class="input-group">
                  <input type="text" name="tglmulaiberlaku" class="form-control datepicker">
                </div>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  KETERANGAN
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="keterangan_id">
                <input type="text" name="keterangan" class="form-control keterangan">
              </div>
            </div>


            <div class="row form-group">
              <div class="col">
                <div class="row mb-2">
                  <div class="col">
                    <label class="col-form-label">Upload Foto Peta</label>
                  </div>
                </div>
                <div class="dropzone" data-field="gambar" id="my-dropzone"></div>

                <div class="dz-preview dz-file-preview">
                  <div class="dz-details">
                    <img data-dz-thumbnail style="width:100%" />
                  </div>
                </div>
                <!-- <div class="dropzone" data-field="gambar" style="padding: 0; min-width: 202px !important; min-height: 234px !important; display:flex;">
                  <div class="fallback">
                    <input name="gambar" type="file" />
                  </div>
                </div> -->
              </div>
            </div>

            <div class="table-responsive table-scroll ">
              <table class="table table-bordered mt-3 table-bindkeys" id="detailList" style="width:800px">
                <thead class="table-secondary">
                  <tr>
                    <th width="1%">NO</th>
                    <th width="10%">TRIP</th>
                    <th width="12%">NOMINAL SUPIR</th>
                    {{-- <th width="1%">AKSI</th> --}}
                  </tr>
                </thead>
                <tbody id="table_body" class="form-group">
                  <tr>
                    <td>1</td>
                    <td>
                      <input type="hidden" name="triptangki_id[]">
                      <input type="text" name="triptangki[]" class="form-control triptangki-lookup">
                    </td>
                    <td>
                      <input type="text" name="nominalsupir[]" class="form-control autonumeric">
                    </td>
                    {{-- <td>
                      <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
                    </td> --}}
                  </tr>
                </tbody>
                <tfoot>
                  <tr style="display: none;">
                    <td>
                      <p class="text-right font-weight-bold">TOTAL :</p>
                    </td>
                    <td>
                      <p class="text-right font-weight-bold autonumeric" id="nominalSupir"></p>
                    </td>
                    <td>
                      {{-- <button type="button" class="btn btn-primary btn-sm my-2" id="addRow">TAMBAH</button> --}}
                    </td>
                  </tr>
                </tfoot>
              </table>
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
  let hasFormBindKeys = false
  let modalBody = $('#crudModal').find('.modal-body').html()
  Dropzone.autoDiscover = false;
  let dropzones = []
  let aksiEdit = true;
  var data_id

  let dataMaxLength = []

  let statusAktif
  let statusUpahZona
  $(document).ready(function() {
    $(document).on('dblclick', '[data-dz-thumbnail]', handleImageClick)
    $('#kotatarif').hide()
    $("#crudForm [name]").attr("autocomplete", "off");

    $(document).on('click', '#addRow', function(event) {
      addRow()
    });

    $(document).on('input', `#table_body [name="nominalsupir[]"]`, function(event) {
      setNominalSupir()
    })



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
      let formData = new FormData()

      dropzones.forEach(dropzone => {
        const {
          paramName
        } = dropzone.options

        dropzone.files.forEach((file, index) => {
          formData.append(`${paramName}[${index}]`, file)
        })
      })

      // formData.delete(`nominalsupir[]`);
      $('#crudForm').find(`[name="nominalsupir[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'nominalsupir[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominalsupir[]"]`)[index])
        // formData.append(`nominalsupir[]`, AutoNumeric.getNumber($(`#crudForm [name="nominalsupir[]"]`)[index]))
      })

      data.filter((row) => row.name === 'jarak')[0].value = AutoNumeric.getNumber($(`#crudForm [name="jarak"]`)[0])

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

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}upahsupirtangki`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}upahsupirtangki/${Id}`
          formData.append('_method', 'PATCH')
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}upahsupirtangki/${Id}`
          formData.append('_method', 'DELETE')
          break;
        default:
          method = 'POST'
          url = `${apiUrl}upahsupirtangki`
          break;
      }

      $(this).attr('disabled', '')
      $('#processingLoader').removeClass('d-none')
      $.ajax({
        url: url,
        method: 'POST',
        dataType: 'JSON',
        processData: false,
        contentType: false,
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: formData,
        success: response => {
          $('#crudForm').trigger('reset')
          $('#crudModal').modal('hide')
          id = response.data.id

          $('#jqGrid').jqGrid('setGridParam', {
            page: response.data.page,
            postData: {
              proses: 'reload'
            }
          }).trigger('reloadGrid');

          if (id == 0) {
            $('#detail').jqGrid().trigger('reloadGrid')
          }

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
            showDialog(error.responseJSON)
          }
        },
      }).always(() => {
        $('#processingLoader').addClass('d-none')
        $(this).removeAttr('disabled')
      })
    })
  })




  //update sore
  $('#crudModal').on('shown.bs.modal', () => {
    let form = $('#crudForm')

    setFormBindKeys(form)

    activeGrid = null
    data_id = $('#crudForm').find('[name=id]').val();

    form.find('#btnSubmit').prop('disabled', false)
    if (form.data('action') == "view") {
      form.find('#btnSubmit').prop('disabled', true)
    }


    // initSelect2(form.find('.select2bs4'), true)
    initDatepicker()
    initLookup()
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    removeEditingBy(data_id)
    $('#crudModal').find('.modal-body').html(modalBody)
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
        table: 'upahsupirtangki'

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

  function setNominalSupir() {
    let nominalDetails = $(`#table_body [name="nominalsupir[]"]`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#nominalSupir').set(total)
  }


  function createUpahSupir() {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    $('#crudModal').find('#crudForm').trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.data('action', 'add')

    $('#crudModalTitle').text('Add Upah Supir Tangki')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()


    $('#table_body').html('')
    setUpRow()

    $('#crudForm').find('[name=tglmulaiberlaku]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    Promise
      .all([
        // setStatusAktifOptions(form),
        getMaxLength(form)
      ])
      .then(() => {
        showDefault(form)
          .then(() => {

            $('#crudModal').modal('show')
          })
          .catch((error) => {
            showDialog(error.responseJSON)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
    initDropzone(form.data('action'))

    initAutoNumeric(form.find(`[name="jarak"]`), {
      minimumValue: 0
    })

  }

  function editUpahSupir(id) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Upah Supir')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        // setStatusAktifOptions(form),
        getMaxLength(form)
      ])
      .then(() => {
        showUpahSupir(form, id)
          .then((upahsupir) => {
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            initDropzone(form.data('action'), upahsupir);
            if (aksiEdit == false) {

              statusAktif = form.find(`[name="statusaktif"]`).val()
              // form.find('select').each((index, select) => {
              //   let element = $(select)

              //   if (element.data('select2')) {
              //     element.select2('destroy')
              //   }
              // })

              form.find(`[name="jarak"]`).prop('readonly', true)
              form.find(`[name="tujuan"]`).prop('readonly', true)
              form.find(`[name="penyesuaian"]`).prop('readonly', true)
              form.find(`[name="kotadari"]`).prop('readonly', true)
              form.find(`[name="kotasampai"]`).prop('readonly', true)
              form.find(`[name="parent"]`).prop('readonly', true)
              form.find(`[name="tariftangki"]`).prop('readonly', true)
            }
          })
          .then(() => {
            $('#crudModal').modal('show')
            if (aksiEdit == false) {
              $('#crudForm').find(`.ui-datepicker-trigger`).attr('disabled', false)
              let name = $('#crudForm').find(`[name]`).parents('.input-group')
              name.find('.button-clear').attr('disabled', true)
              name.children().find('.lookup-toggler').attr('disabled', true)

            } else {
              $('#crudForm').find(`.ui-datepicker-trigger`).attr('disabled', false)

              let name = $('#crudForm').find(`[name]`).parents('.input-group')
              name.find('.button-clear').attr('disabled', false)
              name.children().find('.lookup-toggler').attr('disabled', false)

            }
            $('#simpanKandang').hide()
          })
          .catch((error) => {
            showDialog(error.responseJSON)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  function deleteUpahSupir(id) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-trash"></i>
    Delete
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Upah Supir')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        // setStatusAktifOptions(form),
        getMaxLength(form)
      ])
      .then(() => {
        showUpahSupir(form, id)
          .then((upahsupir) => {
            initDropzone(form.data('action'), upahsupir)
          })
          .then(() => {
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            $('#crudModal').modal('show')
            $('#crudForm').find(`.btn.btn-easyui.lookup-toggler`).attr('disabled', true)
            $('#crudForm').find(`.ui-datepicker-trigger.btn.btn-easyui.text-easyui-dark`).attr('disabled', true)


            $('#simpanKandang').hide()
          })
          .catch((error) => {
            showDialog(error.responseJSON)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })

      })
  }

  function viewUpahSupir(id) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'view')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('View Upah Supir')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        // setStatusAktifOptions(form),
        getMaxLength(form)
      ])
      .then(() => {
        showUpahSupir(form, id)
          .then((upahsupir) => {
            initDropzone(form.data('action'), upahsupir)
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
            $('#crudForm').find(`.btn.btn-easyui.lookup-toggler`).attr('disabled', true)
            $('#crudForm').find(`.ui-datepicker-trigger.btn.btn-easyui.text-easyui-dark`).attr('disabled', true)
            form.find(`.hasDatepicker`).prop('readonly', true)
            form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').remove()
            let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
            name.attr('disabled', true)
            name.find('.lookup-toggler').attr('disabled', true)
            $(".dz-hidden-input").prop("disabled", true);

            $('#simpanKandang').hide()
          })
          .catch((error) => {
            showDialog(error.responseJSON)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })

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
        value: 'UPAHSUPIR'
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


  function cekValidasidelete(Id, aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}upahsupirtangki/${Id}/cekValidasi`,
      method: 'POST',
      dataType: 'JSON',
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      data: {
        aksi: aksi
      },
      success: response => {
        var kondisi = response.kondisi
        if (kondisi == true) {
          if (!response.editblok) {
            if (aksi == 'EDIT') {
              aksiEdit = false
              editUpahSupir(selectedId)
            } else {
              showDialog(response.message['keterangan'])
            }
          } else {
            showDialog(response.message['keterangan'])
          }
        } else {
          if (aksi == 'EDIT') {
            aksiEdit = true
            editUpahSupir(selectedId)
          } else {
            deleteUpahSupir(selectedId)
          }
        }

        // 
      }
    })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: `${apiUrl}upahsupirtangki/field_length`,
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
              if (file.size < (this.options.minFilesize * 1024)) {
                showDialog('ukuran file minimal 100 kb')
                this.removeFile(file);
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
              this.on("addedfile", function(file) {
                if (this.files.length > 5) {
                  this.removeFile(file);
                }
                if (file.size < (this.options.minFilesize * 1024)) {
                  showDialog('ukuran file minimal 100 kb')
                  this.removeFile(file);
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
        getImgURL(`${apiUrl}upahsupirtangki/${file}/ori`, (fileBlob) => {
          let imageFile = new File([fileBlob], file, {
            type: 'image/jpeg',
            lastModified: new Date().getTime()
          }, 'utf-8')

          if (fileBlob.type != 'text/html') {
            dropzone.options.addedfile.call(dropzone, imageFile);
            dropzone.options.thumbnail.call(dropzone, imageFile, `${apiUrl}upahsupirtangki/${file}/ori`);
            dropzone.files.push(imageFile)
          }
        })
      })
    }
  }

  function showUpahSupir(form, userId, parent = null) {
    return new Promise((resolve, reject) => {
      $('#detailList tbody').html('')
      $.ajax({
        url: `${apiUrl}upahsupirtangki/${userId}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          if (parent) {
            delete response.data['id'];
            delete response.data['parent_id'];
            delete response.data['parent'];
            delete response.data['penyesuaian'];
            delete response.data['statuspostingtnl'];
            delete response.data['tglmulaiberlaku'];
            delete response.data['tariftangki'];
            delete response.data['tariftangki_id'];
          }
          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`).not(':file')
            if (element.is('select')) {
              element.val(value).trigger('change')
            } else if ((index == 'parent_id') && parent || (index == 'id') && parent) {
              console.log('parent');
            } else if (element.hasClass('datepicker')) {
              element.val(dateFormat(value))
            } else {
              element.val(value)
            }

            if (index == 'statuspostingtnl') {
              if (!parent) {
                element.prop('disabled', true)
              }
            }
            if (index == 'tariftangki') {
              element.data('currentValue', value)
            }

            if (index == 'parent') {
              element.data('current-value', value)
            }

            if (index == 'kotaupahsupir') {
              element.data('current-value', value)
            }

            if (index == 'kotadari') {
              element.data('current-value', value)
            }

            if (index == 'statusaktifnama') {
              element.data('current-value', value)
            }

            // if(!parent && aksiEdit == true){
            //   console.log('tru kaaa')
            //   if (index == 'tujuan' || index == 'penyesuaian' || index == 'kotadari' || index == 'kotasampai' || index == 'zona' || index == 'parent' || index == 'tarif') {
            //     element.prop('readonly', true)
            //   }
            // }
          })
          if (parent) {
            $('#crudForm').find('[name=tglmulaiberlaku]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change')
          }
          initAutoNumeric(form.find(`[name="jarak"]`), {
            minimumValue: 0
          })
          // initAutoNumeric(form.find('.autonumeric'), {
          //   minimumValue: 0
          // })
          $('#detailList tbody').html('')
          $.each(response.detail, (index, detail) => {
            // $.each(response.data.upahsupir_rincian, (index, detail) => {
            let detailRow = $(`
              <tr>
                <td></td>
                <td>
                  <input type="hidden" name="triptangki_id[]">
                  <input type="text" name="triptangki[]" data-current-value="${detail.triptangki}" class="form-control " readonly>
                </td>
                <td>
                  <input type="text" name="nominalsupir[]" class="form-control autonumeric">
                </td>
                
              </tr>
            `)

            detailRow.find(`[name="triptangki_id[]"]`).val(detail.triptangki_id)
            detailRow.find(`[name="triptangki[]"]`).val(detail.triptangki)
            detailRow.find(`[name="nominalsupir[]"]`).val(detail.nominalsupir)

            $('#detailList tbody').append(detailRow)

            initAutoNumeric(detailRow.find('.autonumeric'), {
              minimumValue: 0
            })

            setNominalSupir()
          })
          // setuprowshow(userId);

          setRowNumbers()

          if (form.data('action') === 'delete') {
            form.find('[name]').addClass('disabled')
            initDisabled()
          }
          resolve(response.data)
        },
        error: error => {
          reject(error)
        }
      })
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
        url: `${apiUrl}upahsupirtangki/default`,
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

  function addRow() {
    let detailRow = $(`
      <tr>
        <td></td>
        <td>
          <input type="hidden" name="triptangki_id[]">
          <input type="text" name="triptangki[]" class="form-control triptangki-lookup">
        </td>
        <td>
          <input type="text" name="nominalsupir[]" class="form-control autonumeric">
        </td>
        <td>
          <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
        </td>
      </tr>
    `)
    $('#detailList tbody').append(detailRow)

    $('.triptangki-lookup').last().lookup({
      title: 'Trip Tangki Lookup',
      fileName: 'triptangki',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (triptangki, element) => {
        $(`#crudForm [name="triptangki_id[]"]`).last().val(triptangki.id)
        element.val(triptangki.keterangan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $(`#crudForm [name="triptangki_id[]"]`).last().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    initAutoNumeric(detailRow.find('.autonumeric'), {
      minimumValue: 0
    })

    setRowNumbers()
  }


  function setUpRow() {
    $.ajax({
      url: `${apiUrl}upahsupirtangkirincian/setuprow`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        $('#detailList tbody').html('')
        $.each(response.detail, (index, detail) => {
          let detailRow = $(`
          <tr>
            <td></td>
            <td>
              <input type="hidden" name="triptangki_id[]">
              <input type="text" name="triptangki[]" data-current-value="${detail.triptangki}" class="form-control" readonly>
            </td>
            <td>
              <input type="text" name="nominalsupir[]" data-current-value="${detail.nominalsupir}" class="form-control autonumeric">
            </td>
          </tr>
        `);

          detailRow.find(`[name="triptangki_id[]"]`).val(detail.triptangki_id);
          detailRow.find(`[name="triptangki[]"]`).val(detail.triptangki);
          // let nominalSupirInput = detailRow.find(`[name="nominalsupir[]"]`);
          // let nominalKenekInput = detailRow.find(`[name="nominalkenek[]"]`);

          // nominalSupirInput.val(detail.nominalsupir);
          // nominalKenekInput.val(detail.nominalkenek);


          // nominalSupirInput.on('input', function() {
          //   let cleanedInput = nominalSupirInput.val().replace(/\D/g, '');
          //   nominalSupirInput.val(cleanedInput);

          // });

          // nominalKenekInput.on('input', function() {
          //   let cleanedInput = nominalKenekInput.val().replace(/\D/g, '');
          //   nominalKenekInput.val(cleanedInput);
          // });


          initAutoNumeric(detailRow.find('.autonumeric'), {
            minimumValue: 0
          })

          setNominalSupir();

          $('#detailList tbody').append(detailRow);
        });

        setRowNumbers();
      }
    });
  }


  function setuprowshow(id) {
    $.ajax({
      url: `${apiUrl}upahsupirrincian/setuprowshow/${id}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        $('#detailList tbody').html('')
        $.each(response.detail, (index, detail) => {

          let detailRow = $(`
            <tr>
              <td></td>
              <td>
                <input type="hidden" name="container_id[]">
                <input type="text" name="container[]" data-current-value="${detail.container}" class="form-control" readonly>
              </td>
              <td>
                <input type="hidden" name="statuscontainer_id[]" class="form-control">
                <input type="text" name="statuscontainer[]" data-current-value="${detail.statuscontainer}" class="form-control" readonly>
              </td>
              <td>
                <input type="text" name="nominalsupir[]" class="form-control autonumeric">
              </td>
              <td>
                <input type="text" name="nominalkenek[]" class="form-control autonumeric" data-negative="false">
              </td>
              <td>
                <input type="text" name="nominalkomisi[]" class="form-control autonumeric">
              </td>
              <td>
                <input type="text" name="nominaltol[]" class="form-control autonumeric">
              </td>
              <td>
                <input type="text" name="liter[]" class="form-control autonumeric">
              </td>
              
            </tr>
            `)
          detailRow.find(`[name="container_id[]"]`).val(detail.container_id)
          detailRow.find(`[name="container[]"]`).val(detail.container)
          detailRow.find(`[name="statuscontainer_id[]"]`).val(detail.statuscontainer_id)
          detailRow.find(`[name="statuscontainer[]"]`).val(detail.statuscontainer)
          initAutoNumeric(detailRow.find('.autonumeric'), {
            minimumValue: 0
          })

          setNominalSupir()
          setNominalKenek()
          setNominalKomisi()
          setNominalTol()
          $('#detailList tbody').append(detailRow)

        })
        setRowNumbers()
      }
    })

  }

  function deleteRow(row) {
    let countRow = $('.delete-row').parents('tr').length
    row.remove()
    if (countRow <= 1) {
      addRow()
    }

    setRowNumbers()
    setNominalSupir()

  }

  function setRowNumbers() {
    let elements = $('#detailList tbody tr td:nth-child(1)')

    elements.each((index, element) => {
      $(element).text(index + 1)
    })
  }




  function approvenonaktif() {

    event.preventDefault()

    let form = $('#crudForm')
    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')

    $.ajax({
      url: `${apiUrl}upahsupirtangki/approvalnonaktif`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        Id: selectedRows,
        nama: selectedRowsUpahSupir
      },
      success: response => {
        $('#crudForm').trigger('reset')
        $('#crudModal').modal('hide')

        $('#jqGrid').jqGrid().trigger('reloadGrid');
        selectedRows = []
        selectedRowsUpahSupir = []
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




  function initLookup() {
    // $('.upahsupirtangki-lookup').lookup({
    //   title: 'upah supir tangki Lookup',
    //   fileName: 'upahsupirtangki',
    //   beforeProcess: function(test) {
    //     // var levelcoa = $(`#levelcoa`).val();
    //     this.postData = {

    //       Aktif: 'AKTIF',
    //       isParent: true
    //     }
    //   },
    //   onSelectRow: (upahsupir, element) => {
    //     // console.log(element);

    //     $('#crudForm [name=parent_id]').first().val(upahsupir.id)
    //     $('#crudForm [name=parent]').first().val(upahsupir.kotasampai_id)

    //     $('#crudForm').find(`[name=penyesuaian]`).val('').prop('readonly', false)
    //     $('#crudForm [name=kotasampai_id]').val('')
    //     $('#crudForm').find(`[name=kotasampai]`).val('').prop('readonly', false)
    //     // $('#kotaupahsupir').prop('disabled', false)
    //     // $('#kotaupahsupir').parent('.input-group').show()
    //     $('#kotatarif').prop('type', 'hidden')
    //     $('#kotatarif').prop('disabled', true).hide()

    //     element.data('currentValue', element.val())
    //     upahSupirKota = upahsupir.kotasampai_id;
    //     // Menghapus nilai autonumeric pada input jarak
    //     // $('#crudForm [name=jarak]').autoNumeric('remove')
    //     let jarakInput = $('#crudForm [name=jarak]').get(0); // Dapatkan elemen input jarak
    //     let autoNumericInstance = AutoNumeric.getAutoNumericElement(jarakInput); // Dapatkan instance AutoNumeric dari elemen tersebut

    //     if (autoNumericInstance) {
    //       autoNumericInstance.remove(); // Hapus efek AutoNumeric
    //     }


    //     let form = $('#crudForm')
    //     showUpahSupir(form, upahsupir.id, true).then((upahsupir) => {
    //       initDropzone('edit', upahsupir)
    //       element.val(upahSupirKota)
    //       element.data('currentValue', element.val())
    //     })

    //   },
    //   onCancel: (element) => {
    //     element.val(element.data('currentValue'))
    //   },
    //   onClear: (element) => {
    //     $('#crudForm [name=parent_id]').first().val('')
    //     element.val('')
    //     element.data('currentValue', element.val())

    //   }
    // })

    $('.upahsupirtangki-lookup').lookupMaster({
      title: 'Upah Supir Tangki Lookup',
      fileName: 'upahsupirtangkiMaster',
      typeSearch: 'ALL',
      searching: 1,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          searching: 1,
          valueName: 'upahsupirtangki_id',
          searchText: 'upahsupirtangki-lookup',
          title: 'Upah Supir Tangki Lookup',
          typeSearch: 'ALL',
          isParent: true
        }
      },
      onSelectRow: (upahsupir, element) => {
        $('#crudForm [name=parent_id]').first().val(upahsupir.id)
        $('#crudForm [name=parent]').first().val(upahsupir.kotasampai_id)

        $('#crudForm').find(`[name=penyesuaian]`).val('').prop('readonly', false)
        $('#crudForm [name=kotasampai_id]').val('')
        $('#crudForm').find(`[name=kotasampai]`).val('').prop('readonly', false)
        // $('#kotaupahsupir').prop('disabled', false)
        // $('#kotaupahsupir').parent('.input-group').show()
        $('#kotatarif').prop('type', 'hidden')
        $('#kotatarif').prop('disabled', true).hide()


        // element.val(upahsupir.keterangan)
        element.data('currentValue', element.val())

        upahSupirKota = upahsupir.kotasampai_id;
        // Menghapus nilai autonumeric pada input jarak
        // $('#crudForm [name=jarak]').autoNumeric('remove')
        let jarakInput = $('#crudForm [name=jarak]').get(0); // Dapatkan elemen input jarak
        let autoNumericInstance = AutoNumeric.getAutoNumericElement(jarakInput); // Dapatkan instance AutoNumeric dari elemen tersebut

        if (autoNumericInstance) {
          autoNumericInstance.remove(); // Hapus efek AutoNumeric
        }

        let form = $('#crudForm')
        showUpahSupir(form, upahsupir.id, true).then((upahsupir) => {
          initDropzone('edit', upahsupir)
          element.val(upahSupirKota)
          element.data('currentValue', element.val())
        })
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=parent_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.kotadari-lookup').lookupMaster({
      title: 'kota Dari Lookup',
      fileName: 'kotaMaster',
      typeSearch: 'ALL',
      searching: 1,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          searching: 1,
          valueName: 'kotadari_id',
          searchText: 'kotadari-lookup',
          title: 'Kota Dari Lookup',
          typeSearch: 'ALL',
        }
      },
      onSelectRow: (kotadari, element) => {
        $('#crudForm [name=kotadari_id]').first().val(kotadari.id)
        element.val(kotadari.kodekota)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=kotadari_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.kotasampai-lookup').lookupMaster({
      title: 'Kota Tujuan Lookup',
      fileName: 'kotaMaster',
      typeSearch: 'ALL',
      searching: 1,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          searching: 1,
          valueName: 'kotasampai_id',
          searchText: 'kotasampai-lookup',
          title: 'Kota Tujuan Lookup',
          typeSearch: 'ALL',
        }
      },
      onSelectRow: (kotasampai, element) => {
        $('#crudForm [name=kotasampai_id]').first().val(kotasampai.id)
        element.val(kotasampai.keterangan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=kotasampai_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    // $('.tariftangki-lookup').lookup({
    //   title: 'Tarif Tangki Lookup',
    //   fileName: 'tariftangki',
    //   beforeProcess: function(test) {
    //     // var levelcoa = $(`#levelcoa`).val();
    //     this.postData = {

    //       Aktif: 'AKTIF',
    //     }
    //   },
    //   onSelectRow: (tarif, element) => {
    //     $('#crudForm').find(`[name=penyesuaian]`).val(tarif.penyesuaian)
    //     $('#crudForm [name=kotasampai_id]').first().val(tarif.kotaId)
    //     $('#crudForm [name=kotasampai]').val(tarif.tujuan)
    //     $('#crudForm [name=kotasampai]').data('currentValue', tarif.tujuan)
    //     $('#crudForm [name=tariftangki_id]').first().val(tarif.id)
    //     // $('#crudForm').find(`[name=kotasampai]`).prop('readonly', true)
    //     // $('#kotaupahsupir').prop('readonly', true)
    //     // $('#kotaupahsupir').parent('.input-group').hide()
    //     $('#kotatarif').prop('type', 'text')
    //     $('#kotatarif').show()
    //     // $('#kotatarif').prop('readonly', true).show()

    //     $('#crudForm').find(`[name=kotasampai]`).parents('.input-group').find('.input-group-append').show()
    //     $('#crudForm').find(`[name=kotasampai]`).parents('.input-group').find('.button-clear').show()
    //     // element.val(tarif.tujuan + ' - ' + tarif.penyesuaian)
    //     element.val(tarif.tujuanpenyesuaian)
    //     element.data('currentValue', element.val())
    //   },
    //   onCancel: (element) => {
    //     element.val(element.data('currentValue'))
    //   },
    //   onClear: (element) => {
    //     $('#crudForm').find(`[name=penyesuaian]`).val('').prop('readonly', false)
    //     $('#crudForm [name=kotasampai_id]').val('')
    //     $('#crudForm').find(`[name=kotasampai]`).val('').prop('readonly', false)
    //     $('#crudForm').find(`[name=kotasampai]`).parents('.input-group').find('.input-group-append').show()
    //     $('#crudForm').find(`[name=kotasampai]`).parents('.input-group').find('.button-clear').show()
    //     // $('#kotaupahsupir').prop('disabled', false)
    //     // $('#kotaupahsupir').parent('.input-group').show()
    //     $('#kotatarif').prop('type', 'hidden')
    //     $('#kotatarif').prop('disabled', true).hide()
    //     element.val('')
    //     element.data('currentValue', element.val())
    //     $('#crudForm [name=tariftangki_id]').val('')
    //   }
    // })

    $('.tariftangki-lookup').lookupMaster({
      title: 'Tarif Tangki Lookup',
      fileName: 'tariftangkiMaster',
      typeSearch: 'ALL',
      searching: 1,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          searching: 1,
          valueName: 'tariftangki_id',
          searchText: 'tariftangki-lookup',
          title: 'Tarif Tangki Lookup',
          typeSearch: 'ALL',
        }
      },
      onSelectRow: (tarif, element) => {
        $('#crudForm [name=penyesuaian]').first().val(tarif.penyesuaian)
        $('#crudForm [name=kotasampai_id]').first().val(tarif.kotaId)
        $('#crudForm [name=kotasampai]').first().val(tarif.tujuan)
        $('#crudForm [name=tariftangki_id]').first().val(tarif.id)
        $('#kotatarif').prop('type', 'text')
        $('#kotatarif').show()

        $('#crudForm').find(`[name=kotasampai]`).parents('.input-group').find('.input-group-append').show()
        $('#crudForm').find(`[name=kotasampai]`).parents('.input-group').find('.button-clear').show()
        element.val(tarif.tujuanpenyesuaian)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm').find(`[name=penyesuaian]`).val('').prop('readonly', false)
        $('#crudForm [name=kotasampai_id]').val('')
        $('#crudForm').find(`[name=kotasampai]`).val('').prop('readonly', false)
        $('#crudForm').find(`[name=kotasampai]`).parents('.input-group').find('.input-group-append').show()
        $('#crudForm').find(`[name=kotasampai]`).parents('.input-group').find('.button-clear').show()
        $('#kotatarif').prop('type', 'hidden')
        $('#kotatarif').prop('disabled', true).hide()
        element.val('')
        element.data('currentValue', element.val())
        $('#crudForm [name=tariftangki_id]').val('')
      }
    })

    $(`.status-lookup`).lookupMaster({
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
          searchText: `status-lookup`,
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
  }
</script>
@endpush()