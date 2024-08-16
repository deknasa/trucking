<div class="modal modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="crudForm">
      <div class="modal-content">

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
                  Jam
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
        name: 'info',
        value: info
      })
      data.push({
        name: 'indexRow',
        value: indexRow
      })
      data.push({
        name: 'page',
        value: page
      })

      if (rowNum == 0) {
        data.push({
          name: 'limit',
          value: rowNum
        })
      } else {
        data.push({
          name: 'limit',
          value: limit
        })
      }

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
          indexRow = response.data.position - 1;
          $('#crudForm').trigger('reset')
          $('#crudModal').modal('hide')

          $('#jqGrid').jqGrid('setGridParam', {
            page: response.data.page
          }).trigger('reloadGrid');

          if (response.data.grp == 'FORMAT') {
            updateFormat(response.data)
          }
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
            if (errorMessages['tglbukti'] && errorMessages['tglbukti'].length > 0) {
              form.find(`[name=tglbukti]`).addClass("is-invalid")
              $(`
                <div class="invalid-feedback">
                ${errorMessages['tglbukti'][0].toLowerCase()}
                </div>
              `).appendTo(form.find(`[name=tglbukti]`).parent())
            }

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
    initDatepicker('datepickerIndex')
  })


  function createAbsensi(tradoId,supirId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'store')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Input Absen')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    $('#crudForm').find('[name=tglbukti]').val($('#tglshow').val()).trigger('change');
    // $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    Promise
      .all([
        showDefault(form),
        showAbsensi(form, tradoId,supirId)
      ])
      .then(() => {
        $('#crudModal').modal('show')
        if (isTradoMilikSupir == 'YA') {
          
          form.find(`[name="supir"]`).prop('readonly', true)
          form.find(`[name="supir"]`).parent('.input-group').find('.button-clear').remove()
          form.find(`[name="supir"]`).parent('.input-group').find('.input-group-append').remove()
        }
      })
      .catch((error) => {
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
        let date = new Date();
        let time = date.toLocaleString("id", {
          timeStyle: "medium",
        });
        time = time.split('.')
        $('#crudForm').find('[name=jam]').val(time[0] + ":" + time[1]);
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

  function editAbsensi(tradoId,supirId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Absen')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    Promise
      .all([
        showAbsensi(form, tradoId,supirId)
      ])
      .then(() => {
        $('#crudModal').modal('show')
        if (isTradoMilikSupir == 'YA') {
          
          form.find(`[name="supir"]`).prop('readonly', true)
          form.find(`[name="supir"]`).parent('.input-group').find('.button-clear').remove()
          form.find(`[name="supir"]`).parent('.input-group').find('.input-group-append').remove()
        }
      })
      .catch((error) => {
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }

  function deleteAbsensi(tradoId,supirId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-trash"></i>
    Delete
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Absen')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    Promise
      .all([
        showAbsensi(form, tradoId,supirId)
      ])
      .then(() => {
        $('#crudModal').modal('show')
        if (isTradoMilikSupir == 'YA') {
          
          form.find(`[name="supir"]`).prop('readonly', true)
          form.find(`[name="supir"]`).parent('.input-group').find('.button-clear').remove()
          form.find(`[name="supir"]`).parent('.input-group').find('.input-group-append').remove()
        }
      })
      .catch((error) => {
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })

  }


  function showAbsensi(form, tradoId,supirId) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}mandorabsensisupir/${tradoId}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          tanggal: $('#tglshow').val(),
          supir_id: supirId
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
          let kodeabsen = form.find(`[name="absen_id"]`).val()
          if (kodeabsen !== "") {
            getabsentrado(kodeabsen)
          }
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

  function cekValidasi(tradoId,supirId, aksi,rowId = null) {
    $.ajax({
      url: `${apiUrl}mandorabsensisupir/${tradoId}/cekvalidasi`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        tanggal: $('#tglshow').val(),
        supir_id: supirId
      },
      success: response => {
        if (response.errors) {
          if (aksi =="deleteFromAll") {
            deleteStatic(rowId,response.message);
          }else{
            showDialog(response.message)
          }
          
        } else {
          if (aksi == 'edit') {
            editAbsensi(tradoId,supirId)
          } else if (aksi =="deleteFromAll") {
            deleteFromAll(tradoId,supirId,rowId)
          } else {
            deleteAbsensi(tradoId,supirId)
          }
        }
      }
    })
  }

  function cekValidasiAdd(tradoId, supirId) {
    $.ajax({
      url: `${apiUrl}mandorabsensisupir/${tradoId}/cekvalidasiadd`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        tanggal: $('#tglshow').val(),
        supir_id: supirId
      },
      success: response => {
        if (response.errors) {
          showDialog(response.message)
        } else {
          createAbsensi(tradoId,supirId)
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
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}mandorabsensisupir/${id}/getabsentrado`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          'Authorization': `Bearer ${accessToken}`
        },
        success: response => {
          resolve(response.data)
        },
        error: error => {
          reject(error)
        }
      })
    })
  }


  function setSupirEnable() {
    let supir = $('#crudForm [name=supir]')
    if (kodeabsen == '1') {
      //2x20
      supir.attr('readonly', true)
      supir.parents('.input-group').find('.input-group-append').hide()
      supir.parents('.input-group').find('.button-clear').hide()
      supir.val('');
      $('#crudForm [name=supir_id]').val('');

    } else {
      supir.attr('readonly', false)
      supir.parents('.input-group').find('.input-group-append').show()
      supir.parents('.input-group').find('.button-clear').show()

    }
  }




  function initLookup() {
    // $('.supir-lookup').lookup({
    //   title: 'Supir Lookup',
    //   fileName: 'supir',
    //   beforeProcess: function(test) {
    //     this.postData = {
    //       Aktif: 'AKTIF',
    //     }
    //   },
    //   onSelectRow: (supir, element) => {
    //     $(`#crudForm [name="supir_id"]`).first().val(supir.id)
    //     element.val(supir.namasupir)
    //     element.data('currentValue', element.val())
    //   },
    //   onCancel: (element) => {
    //     element.val(element.data('currentValue'))
    //   },
    //   onClear: (element) => {
    //     element.val('')
    //     $(`#crudForm [name="supir_id"]`).first().val('')
    //     element.data('currentValue', element.val())
    //   }
    // })


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
        $('#jqGrid').jqGrid('setCell', id_row, 'checked' ,element.val(absentrado.keterangan));
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        $(`#crudForm [name="absen_id"]`).first().val('')
        element.data('currentValue', element.val())
        kodeabsen = 0
        setSupirEnable()
      }
    })
  }
</script>
@endpush()