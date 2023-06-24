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

            <input type="text" name="id" hidden readonly>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  tglbukti <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <div class="input-group">

                  <input type="text" name="tglbukti" class="form-control" readonly>
                </div>

              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  TRADO <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="trado_id" hidden readonly>
                <input type="text" name="trado" class="form-control" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  supir <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="supir_id">
                <input type="text" name="supir" class="form-control supir-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  Status
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="absen_id">
                <input type="text" name="absen" class="form-control absentrado-lookup">
              </div>
            </div>


            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  KETERANGAN
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="keterangan" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  Jam <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" class="form-control inputmask-time" name="jam">
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
  let hasFormBindKeys = false
  let modalBody = $('#crudModal').find('.modal-body').html()
  $(document).ready(function() {
    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let mandorId = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()

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
        case 'store':
          method = 'POST'
          url = `${apiUrl}mandorabsensisupir`

          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}mandorabsensisupir/${mandorId}/update`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}mandorabsensisupir/${mandorId}/delete`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}mandorabsensisupir`
          break;
      }

      $(this).attr('disabled', '')
      $('#processingLoader').removeClass('d-none')

      $.ajax({
        url: url,
        method: method,
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: data,
        success: response => {
          console.log(indexRow);
          $('#crudForm').trigger('reset')
          $('#crudModal').modal('hide')
          $.ajax({
            url: `${apiUrl}mandorabsensisupir`,
            method: 'GET',
            dataType: 'JSON',
            data: {
              limit: 0,
              sortIndex: 'trado_id',
              sortOrder: 'asc',
            },
            headers: {
              Authorization: `Bearer ${accessToken}`
            },
            success: response => {
              // indexRow =4
              $('#jqGrid').setGridParam({
                datatype: "local",
                data: response.data
              }).trigger('reloadGrid')
            }
          })
          // id = response.data.id

          // $('#jqGrid').jqGrid('setGridParam', {
          //   page: response.data.page
          // }).trigger('reloadGrid');

          // if (response.data.grp == 'FORMAT') {
          //   updateFormat(response.data)
          // }
        },
        error: error => {
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            let errorMessages = error.responseJSON.errors

            if (errorMessages['supir_id'] && errorMessages['supir_id'].length > 0) {
              form.find(`[name=supir]`).addClass("is-invalid")
              $(`
                <div class="invalid-feedback">
                ${errorMessages['supir_id'][0].toLowerCase()}
                </div>
              `).appendTo(form.find(`[name=supir]`).parent())
            }

            if (errorMessages['jam'] && errorMessages['jam'].length > 0) {
              form.find(`[name=jam]`).addClass("is-invalid")
              $(`
                <div class="invalid-feedback">
                ${errorMessages['jam'][0].toLowerCase()}
                </div>
              `).appendTo(form.find(`[name=jam]`).parent())
            }
          } else {
            if (error.responseJSON.errors) {
              showDialog(error.statusText, error.responseJSON.errors.join('<hr>'))
            } else if (error.responseJSON.message) {
              showDialog(error.statusText, error.responseJSON.message)
            } else {
              showDialog(error.statusText, error.statusText)
            }
          }
        },
      }).always(() => {
        $('#processingLoader').addClass('d-none')
        $(this).removeAttr('disabled')
      })

    })
  })

  $('#crudModal').on('shown.bs.modal', () => {

    let form = $('#crudForm')

    setFormBindKeys(form)

    activeGrid = null
    initDatepicker()
    getMaxLength(form)
    // initSelect2()
    initLookup()
    Inputmask("datetime", {
      inputFormat: "HH:MM",
      max: 24
    }).mask(".inputmask-time");
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    $('#crudModal').find('.modal-body').html(modalBody)
  })


  function createAbsensi(tradoId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'store')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Input Absen')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    Promise
      .all([
        showDefault(form),
        showAbsensi(form, tradoId)
      ])
      .then(() => {
        $('#crudModal').modal('show')
      })
      .catch((error) => {
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}mandor/field_length`,
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

  function editAbsensi(tradoId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Absen')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    Promise
      .all([
        showAbsensi(form, tradoId)
      ])
      .then(() => {
        $('#crudModal').modal('show')
      })
      .catch((error) => {
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }

  function deleteAbsensi(tradoId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Absen')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    Promise
      .all([
        showAbsensi(form, tradoId)
      ])
      .then(() => {
        $('#crudModal').modal('show')
      })
      .catch((error) => {
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })

  }


  function showAbsensi(form, tradoId) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}mandorabsensisupir/${tradoId}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)
            if (element.attr("name") == 'tglbukti') {
              if (value) {
                let result = value.split('-');

                element.val(result[2] + '-' + result[1] + '-' + result[0]);
              }
            } else {
              element.val(value)
            }
          })

          if (form.data('action') === 'delete') {
            form.find('[name]').addClass('disabled')
            initDisabled()
          }
          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function cekValidasi(tradoId, aksi) {
    $.ajax({
      url: `${apiUrl}mandorabsensisupir/${tradoId}/cekvalidasi`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        if (response.errors) {
          showDialog(response.message)
        } else {
          if (aksi == 'edit') {
            editAbsensi(tradoId)
          } else {
            deleteAbsensi(tradoId)
          }
        }
      }
    })
  }

  function cekValidasiAdd(tradoId) {
    $.ajax({
      url: `${apiUrl}mandorabsensisupir/${tradoId}/cekvalidasiadd`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        if (response.errors) {
          showDialog(response.message)
        } else {
          createAbsensi(tradoId)
        }
      }
    })
  }

  function showDefault(form) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}mandor/default`,
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
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function getabsentrado(id) {
    $.ajax({
      url: `${apiUrl}mandorabsensisupir/${id}/getabsentrado`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        'Authorization': `Bearer ${accessToken}`
      },
      success: response => {

        kodeabsen = response.data.kodeabsen
        setSupirEnable()
      },
      error: error => {
        showDialog(error.statusText)
      }
    })
  }

  
  function setSupirEnable() {
    let supir = $('#crudForm [name=supir]')
    if (kodeabsen == '1') {
      //2x20
      supir.attr('readonly', true)
      supir.parents('.input-group').find('.input-group-append').hide()
      supir.parents('.input-group').find('.button-clear').hide()


    } else {
      supir.attr('readonly', false)
        supir.parents('.input-group').find('.input-group-append').show()
        supir.parents('.input-group').find('.button-clear').show()

    }
  }





  function initLookup() {
    $('.supir-lookup').lookup({
      title: 'Supir Lookup',
      fileName: 'supir',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (supir, element) => {
        $(`#crudForm [name="supir_id"]`).first().val(supir.id)
        element.val(supir.namasupir)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        $(`#crudForm [name="supir_id"]`).first().val('')
        element.data('currentValue', element.val())
      }
    })


    $('.absentrado-lookup').lookup({
      title: 'Absen Trado Lookup',
      fileName: 'absentrado',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (absentrado, element) => {
        $(`#crudForm [name="absen_id"]`).first().val(absentrado.id)
        element.val(absentrado.keterangan)
        absentradoId = absentrado.id
        element.data('currentValue', element.val())
        getabsentrado(absentradoId)
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        $(`#crudForm [name="absen_id"]`).first().val('')
        element.data('currentValue', element.val())
        setSupirEnable()
      }
    })
  }
</script>
@endpush()