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
            {{-- <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">ID</label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="id" class="form-control" readonly>
              </div>
            </div> --}}
            <input type="text" name="id" class="form-control" hidden>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  TUJUAN <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="tarif_id">
                <input type="text" name="tarif" class="form-control tarif-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  PENYESUAIAN<span class="text-danger"></span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="penyesuaian" class="form-control" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  CONTAINER <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="container_id">
                <input type="text" name="container" class="form-control container-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  TUJUAN CABANG BONGKAR <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="tujuanbongkar_id">
                <input type="text" name="tujuanbongkar" class="form-control tujuanbongkar-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  CABANG<span class="text-danger"></span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="cabang" class="form-control" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  STATUS CABANG<span class="text-danger"></span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="statuscabang" class="form-control" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  LOKASI DOORING <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="lokasidooring_id">
                <input type="text" name="lokasidooring" class="form-control lokasidooring-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  SHIPPER <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="shipper_id">
                <input type="text" name="shipper" class="form-control shipper-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  NOMINAL<span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="nominal" class="form-control text-right">
              </div>
            </div>


            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  STATUS AKTIF <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="statusaktif" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH STATUS AKTIF --</option>
                </select>
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
  let jenisorderId
  let containerId
  let cabang
  var statustas
  var kodecontainer
  var isAllowEdited;
  var data_id

    
  $(document).ready(function() {
    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let tarifHargaTertentuId = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()

      let dataMaxLength = []

      $('#crudForm').find(`[name="nominal"]`).each((index, element) => {
        data.filter((row) => row.name === 'nominal')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominal"]`)[index])
      })
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
      data.push({
        name: 'limit',
        value: limit
      })

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}tarifhargatertentu`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}tarifhargatertentu/${tarifHargaTertentuId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}tarifhargatertentu/${tarifHargaTertentuId}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}tarifhargatertentu`
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
          $('#crudForm').trigger('reset')
          $('#crudModal').modal('hide')

          id = response.data.id

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
    let form = $('#crudForm')

    setFormBindKeys(form)

    activeGrid = null

  
    form.find('#btnSubmit').prop('disabled', false)
    if (form.data('action') == "view") {
      form.find('#btnSubmit').prop('disabled', true)
    }
    data_id = $('#crudForm').find('[name=id]').val();

    
    initLookup()
    initSelect2(form.find('.select2bs4'), true)
    initDatepicker()
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    $('#crudModal').find('.modal-body').html(modalBody)
    removeEditingBy(data_id)
    initDatepicker('datepickerIndex')
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
        table: 'tarifhargatertentu'
        
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

  function createTarifHargaTertentu() {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create Tarif Harga Tertentu')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    initAutoNumeric(form.find(`[name="nominal"]`), {
      minimumValue: 0
    })
    Promise
      .all([
        setStatusAktifOptions(form),
        setStatusCabangOptions(form),
        getMaxLength(form)
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
  }

  function editTarifHargaTertentu(tarifHargaTertentuId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Tarif Harga Tertentu')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()


    Promise
      .all([
        setStatusAktifOptions(form),
        setStatusCabangOptions(form),
        getMaxLength(form)
      ])
      .then(() => {
        showTarifHargaTertentu(form, tarifHargaTertentuId)
          .then(() => {
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            $('#crudModal').modal('show')

            editValidasi(isAllowEdited);
          })
          .catch((error) => {
            showDialog(error.statusText)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  function deleteTarifHargaTertentu(tarifHargaTertentuId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-trash"></i>
    Delete
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Tarif Harga Tertentu')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    $('#crudForm [name=tglbukti]').attr('readonly', true)
    $('#crudForm [name=tglbukti]').siblings('.input-group-append').remove()

    Promise
      .all([
        setStatusAktifOptions(form),
        setStatusCabangOptions(form),
        getMaxLength(form)
      ])
      .then(() => {
        showTarifHargaTertentu(form, tarifHargaTertentuId)
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

  function viewTarifHargaTertentu(tarifHargaTertentuId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'view')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('View Tarif Harga Tertentu')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    $('#crudForm [name=tglbukti]').attr('readonly', true)
    $('#crudForm [name=tglbukti]').siblings('.input-group-append').remove()

    Promise
      .all([
        setStatusAktifOptions(form),
        setStatusCabangOptions(form),
        getMaxLength(form)
      ])
      .then(() => {
        showTarifHargaTertentu(form, tarifHargaTertentuId)
          .then(tarifHargaTertentuId => {
            // form.find('.aksi').hide()
            setFormBindKeys(form)
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
            $('#crudForm').find(`.ui-datepicker-trigger`).attr('disabled', true)

            let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
            name.attr('disabled', true)
            name.find('.lookup-toggler').attr('disabled', true)
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

  function approve() {
    event.preventDefault()

    let form = $('#crudForm')
    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')

    $.ajax({
      url: `${apiUrl}tarifhargatertentu/approval`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        tarifHargaTertentuId: selectedRows
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

  function approvalEditTarifHargaTertentu() {
    event.preventDefault()

    let form = $('#crudForm')
    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')

    $.ajax({
      url: `${apiUrl}tarifhargatertentu/approvaledit`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        tarifHargaTertentuId: selectedRows
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

  function editValidasi(edit) {
    let container = $('#crudForm').find(`[name="container"]`).parents('.input-group')
    let tarif = $('#crudForm').find(`[name="tarif"]`).parents('.input-group')

    if (!edit) {

      container.find('.button-clear').attr('disabled', true)
      container.find('input').attr('readonly', true)
      container.children().find('.lookup-toggler').attr('disabled', true)
      tarif.find('.button-clear').attr('disabled', true)
      tarif.find('input').attr('readonly', true)
      tarif.children().find('.lookup-toggler').attr('disabled', true)


    } else {
      console.log("true");
      container.find('.button-clear').attr('disabled', false)
      container.find('input').attr('readonly', false)
      container.children().find('.lookup-toggler').attr('disabled', false)
      tarif.find('.button-clear').attr('disabled', false)
      tarif.find('input').attr('readonly', false)
      tarif.children().find('.lookup-toggler').attr('disabled', false)

    }


  }


  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}tarifhargatertentu/field_length`,
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

  const setStatusCabangOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statuscabang]').empty()
      relatedForm.find('[name=statuscabang]').append(
        new Option('-- PILIH STATUS CABANG --', '', false, true)
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
              "data": "STATUS CABANG"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusCabang => {
            let option = new Option(statusCabang.text, statusCabang.id)

            relatedForm.find('[name=statuscabang]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function showTarifHargaTertentu(form, tarifHargaTertentuId) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}tarifhargatertentu/${tarifHargaTertentuId}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)
            containerId = response.data.container_id
            cabang = response.data.cabang

            if (element.is('select')) {
              element.val(value).trigger('change')
            } else {
              element.val(value)
            }


          })

          initAutoNumeric(form.find(`[name="nominal"]`), {
            minimumValue: 0
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

  function showDefault(form) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}tarifhargatertentu/default`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          containerId = 0
          jenisorderId = 0

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

  function setJobReadOnly() {

    let nojobemkl = $('#crudForm [name=nojobemkl]')
    let nojobemkl2 = $('#crudForm [name=nojobemkl2]')
    if (statustas == '0') {
      //bukan tas
      // console.log('bukan');
      nojobemkl.attr('readonly', true)
      nojobemkl.parents('.input-group').find('.input-group-append').hide()
      nojobemkl.parents('.input-group').find('.button-clear').hide()
      nojobemkl2.attr('readonly', true)
      nojobemkl2.parents('.input-group').find('.input-group-append').hide()
      nojobemkl2.parents('.input-group').find('.button-clear').hide()
      nojobemkl.val('')
      nojobemkl.val('')
    } else {
      //tas
      nojobemkl.attr('readonly', false)
      nojobemkl.parents('.input-group').find('.input-group-append').show()
      nojobemkl.parents('.input-group').find('.button-clear').show()
      nojobemkl2.attr('readonly', false)
      nojobemkl2.parents('.input-group').find('.input-group-append').show()
      nojobemkl2.parents('.input-group').find('.button-clear').show()
    }
  }

  function setContEnable() {
    let nojobemkl2 = $('#crudForm [name=nojobemkl2]')
    if (statustas == '0') {
      //bukan tas
      nojobemkl2.attr('readonly', true)
      nojobemkl2.parents('.input-group').find('.input-group-append').hide()
      nojobemkl2.parents('.input-group').find('.button-clear').hide()
      $('#crudForm [name=nocont]').attr('readonly', false)
      $('#crudForm [name=noseal]').attr('readonly', false)
      if (kodecontainer == '1') {
        $('#crudForm [name=nocont2]').attr('readonly', false)
        $('#crudForm [name=noseal2]').attr('readonly', false)
      }
    } else {
      nojobemkl2.attr('readonly', false)
      nojobemkl2.parents('.input-group').find('.input-group-append').show()
      nojobemkl2.parents('.input-group').find('.button-clear').show()
      $('#crudForm [name=nocont]').attr('readonly', true)
      $('#crudForm [name=noseal]').attr('readonly', true)
      $('#crudForm [name=nocont2]').attr('readonly', true)
      $('#crudForm [name=noseal2]').attr('readonly', true)
    }
  }


  function setCont2Enable() {
    let nojobemkl2 = $('#crudForm [name=nojobemkl2]')
    if (kodecontainer == '1') {
      //2x20
      if (statustas != '0') {
        nojobemkl2.attr('readonly', false)
        nojobemkl2.parents('.input-group').find('.input-group-append').show()
        nojobemkl2.parents('.input-group').find('.button-clear').show()

      } else {
        nojobemkl2.attr('readonly', true)
        nojobemkl2.parents('.input-group').find('.input-group-append').hide()
        nojobemkl2.parents('.input-group').find('.button-clear').hide()
      }
      $('#crudForm [name=nocont2]').attr('readonly', false)
      $('#crudForm [name=noseal2]').attr('readonly', false)
    } else {
      nojobemkl2.attr('readonly', true)
      nojobemkl2.parents('.input-group').find('.input-group-append').hide()
      nojobemkl2.parents('.input-group').find('.button-clear').hide()
      $('#crudForm [name=nocont2]').attr('readonly', true)
      $('#crudForm [name=noseal2]').attr('readonly', true)
    }
  }


  function getagentas(id) {
    $.ajax({
      url: `${apiUrl}tarifhargatertentu/${id}/getagentas`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        'Authorization': `Bearer ${accessToken}`
      },
      success: response => {

        statustas = response.data.statustas
        setJobReadOnly()
        setContEnable()
        // console.log(statustas)
      },
      error: error => {
        showDialog(error.statusText)
      }
    })
  }

  function getcont(id) {
    $.ajax({
      url: `${apiUrl}tarifhargatertentu/${id}/getcont`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        'Authorization': `Bearer ${accessToken}`
      },
      success: response => {

        kodecontainer = response.data.kodecontainer
        setCont2Enable()
      },
      error: error => {
        showDialog(error.statusText)
      }
    })
  }

  function initLookup() {

    $('.container-lookup').lookup({
      title: 'Container Lookup',
      fileName: 'container',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }

      },
      onSelectRow: (container, element) => {
        $('#crudForm [name=container_id]').first().val(container.id)
        element.val(container.keterangan)
        containerId = container.id
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=container_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    // tarif lookup
    $('.tarif-lookup').lookup({
      title: 'Tarif Lookup',
      fileName: 'tarif',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }

      },
      onSelectRow: (tarif, element) => {
        $('#crudForm [name=tarif_id]').first().val(tarif.id)
        element.val(tarif.keterangan)
        tarifId = tarif.id
        element.data('currentValue', element.val())
        $('#crudForm [name=tarif]').first().val(tarif.tujuan)
        $('#crudForm [name=penyesuaian]').first().val(tarif.penyesuaian)
      },

      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=tarif_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.tujuanbongkar-lookup').lookup({
      title: 'Tujuan Bongkar Lookup',
      fileName: 'tujuanbongkar',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (tujuanbongkar, element) => {
        $('#crudForm [name=tujuanbongkar_id]').first().val(tujuanbongkar.id)
        element.val(tujuanbongkar.tujuan)
        element.data('currentValue', element.val())
        cabang = tujuanbongkar.cabang
        $('#crudForm [name=tujuan]').first().val(tujuanbongkar.tujuan)
        $('#crudForm [name=cabang]').first().val(tujuanbongkar.cabang)
        $('#crudForm [name=statuscabang]').first().val(tujuanbongkar.statuscabang)


      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=tujuanbongkar_id]').first().val('')
        $('#crudForm [name=tujuan]').first().val('')
        $('#crudForm [name=cabang]').first().val('')
        $('#crudForm [name=statuscabang]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.shipper-lookup').lookup({
      title: 'Shipper Lookup',
      fileName: 'shipper',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (shipper, element) => {
        $('#crudForm [name=shipper_id]').first().val(shipper.id)
        element.val(shipper.shipper)
        element.data('currentValue', element.val())

        $('#crudForm [name=shipper]').first().val(shipper.shipper)
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.lokasidooring-lookup').lookup({
      title: 'Lokasi Dooring Lookup',
      fileName: 'lokasidooring',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          Cabang: cabang,
        }
      },
      onSelectRow: (lokasidooring, element) => {
        $('#crudForm [name=lokasidooring_id]').first().val(lokasidooring.id)
        element.val(lokasidooring.lokasidooring)
        element.data('currentValue', element.val())

        $('#crudForm [name=lokasidooring]').first().val(lokasidooring.lokasidooring)

      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        element.data('currentValue', element.val())
      }
    })



  }

  function cekValidasidelete(Id, Aksi, nobukti) {
    $.ajax({
      url: `{{ config('app.api_url') }}tarifhargatertentu/${Id}/cekValidasi`,
      method: 'POST',
      dataType: 'JSON',
      data: {
        aksi: Aksi,
        id: nobukti
      },
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      success: response => {
        var error = response.error
        isAllowEdited = response.edit;
        if (error == true) {
          showDialog(response.message)
        } else {
          if (Aksi == 'EDIT') {
            editTarifHargaTertentu(Id)
          } else if (Aksi == 'DELETE') {
            deleteTarifHargaTertentu(Id)
          }
        }

      }
    })
  }
</script>
@endpush()