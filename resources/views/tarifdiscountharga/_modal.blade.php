<div class="modal modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="crudForm">
      <div class="modal-content">
        
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
                  TARIF <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="tarif_id">
                <input type="text" name="tarif" class="form-control tarif-lookup">
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
                  TUJUAN BONGKAR <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="tujuanbongkar_id">
                <input type="text" name="tujuanbongkar" class="form-control tujuanbongkar-lookup">
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
           
            <div class="row form-group" >
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  STATUS CABANG <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="statuscabang" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH STATUS CABANG --</option>
                </select>
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
  var statustas
  var kodecontainer
  var isAllowEdited;

  $(document).ready(function() {
    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let tarifDiscounthargaId = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()
      $('#crudForm').find(`[name="nominalsumbangan"]`).each((index, element) => {
        data.filter((row) => row.name === 'nominalsumbangan')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominalsumbangan"]`)[index])
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
          url = `${apiUrl}tarifdicountharga`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}tarifdicountharga/${tarifDiscountharga}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}tarifdicountharga/${tarifDiscountharga}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}tarifdicountharga`
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

    getMaxLength(form)
    form.find('#btnSubmit').prop('disabled', false)
    if (form.data('action') == "view") {
      form.find('#btnSubmit').prop('disabled', true)
    }
    initLookup()
    initSelect2(form.find('.select2bs4'), true)
    initDatepicker()
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    $('#crudModal').find('.modal-body').html(modalBody)
    initDatepicker('datepickerIndex')
  })

  function createTarifDiscountHarga() {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create Tarif Discount Harga')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    $('#crudForm [name=nojobemkl]').attr('readonly', true)
    $('#crudForm [name=nojobemkl2]').attr('readonly', true)

    Promise
      .all([
        setStatusAktifOptions(form),
        setStatusCabangOptions(form)
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

  function editTarifDiscountHarga(tarifDiscounthargaId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Tarif Discount Harga')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()


    Promise
      .all([
        setStatusAktifOptions(form),
        setStatusCabangOptions(form)
      ])
      .then(() => {
        showTarifDiscountHarga(form, tarifDiscounthargaId)
          .then(() => {
            $('#crudModal').modal('show')
            $('#crudForm [name=tglbukti]').attr('readonly', true)
            $('#crudForm [name=tglbukti]').siblings('.input-group-append').remove()

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

  function deleteTarifDiscountHarga(tarifDiscounthargaId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-trash"></i>
    Delete
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Tarif Discount Harga')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    $('#crudForm [name=tglbukti]').attr('readonly', true)
    $('#crudForm [name=tglbukti]').siblings('.input-group-append').remove()

    Promise
      .all([
        setStatusAktifOptions(form),
        setStatusCabangOptions(form)
      ])
      .then(() => {
        showTarifDiscountHarga(form, tarifDiscounthargaId)
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

  function viewTarifDiscountHarga(tarifDiscounthargaId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'view')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('View Tarif Discount Harga')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    $('#crudForm [name=tglbukti]').attr('readonly', true)
    $('#crudForm [name=tglbukti]').siblings('.input-group-append').remove()

    Promise
      .all([
        setStatusAktifOptions(form),
        setStatusCabangOptions(form)
      ])
      .then(() => {
        showTarifDiscountHarga(form, tarifDiscounthargaId)
          .then(tarifDiscounthargaId => {
            // form.find('.aksi').hide()
            setFormBindKeys(form)
            form.find('[name]').attr('disabled', 'disabled').css({
              background: '#fff'
            })
            form.find('[name=id]').prop('disabled', false)

          })
          .then(() => {
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
      url: `${apiUrl}tarifdiscountharga/approval`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        tarifDiscounthargaId: selectedRows
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

  function approvalEditTarifDiscountHarga() {
    event.preventDefault()

    let form = $('#crudForm')
    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')

    $.ajax({
      url: `${apiUrl}tarifdiscountharga/approvaledit`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        tarifDiscounthargaId: selectedRows
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
    let agen = $('#crudForm').find(`[name="agen"]`).parents('.input-group')
    let jenisorder = $('#crudForm').find(`[name="jenisorder"]`).parents('.input-group')
    let pelanggan = $('#crudForm').find(`[name="pelanggan"]`).parents('.input-group')

    if (!edit) {

      container.find('.button-clear').attr('disabled', true)
      container.find('input').attr('readonly', true)
      container.children().find('.lookup-toggler').attr('disabled', true)
      agen.find('.button-clear').attr('disabled', true)
      agen.find('input').attr('readonly', true)
      agen.children().find('.lookup-toggler').attr('disabled', true)
      jenisorder.find('.button-clear').attr('disabled', true)
      jenisorder.find('input').attr('readonly', true)
      jenisorder.children().find('.lookup-toggler').attr('disabled', true)

      pelanggan.find('.button-clear').attr('disabled', true)
      pelanggan.find('input').attr('readonly', true)
      pelanggan.children().find('.lookup-toggler').attr('disabled', true)


    } else {
      console.log("true");
      container.find('.button-clear').attr('disabled', false)
      container.find('input').attr('readonly', false)
      container.children().find('.lookup-toggler').attr('disabled', false)
      agen.find('.button-clear').attr('disabled', false)
      agen.find('input').attr('readonly', false)
      agen.children().find('.lookup-toggler').attr('disabled', false)
      jenisorder.find('.button-clear').attr('disabled', false)
      jenisorder.find('input').attr('readonly', false)
      jenisorder.children().find('.lookup-toggler').attr('disabled', false)

      pelanggan.find('.button-clear').attr('disabled', false)
      pelanggan.find('input').attr('readonly', false)
      pelanggan.children().find('.lookup-toggler').attr('disabled', false)

    }


  }


  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}tarifdiscountharga/field_length`,
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

  function showTarifDiscountHarga(form, tarifDiscounthargaId) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}tarifdiscountharga/${tarifDiscounthargaId}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)
            containerId = response.data.container_id
            jenisorderId = response.data.jenisorder_id

            // if (index == 'tglbukti') {
            //   element.val(dateFormat(value))
            // }

            if (element.is('select')) {
              element.val(value).trigger('change')
            } else if (element.hasClass('datepicker')) {
              element.val(dateFormat(value))
            } else {
              element.val(value)
            }

            if (index == 'container') {
              element.data('current-value', value)
              console.log(containerId)
              getcont(containerId)
            }
            if (index == 'agen') {
              element.data('current-value', value)
            }
            if (index == 'jenisorder') {
              element.data('current-value', value)
            }
            if (index == 'pelanggan') {
              element.data('current-value', value)
            }
            if (index == 'tarifrincian') {
              element.data('current-value', value)
            }

            if (index == 'agen_id') {
              getagentas(value)
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

  function showDefault(form) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}tarifdiscountharga/default`,
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
      url: `${apiUrl}tarifdiscountharga/${id}/getagentas`,
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
      url: `${apiUrl}tarifdiscountharga/${id}/getcont`,
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
        getcont(containerId)
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
        getcont(tarifId)
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
          jenisorder_Id: jenisorderId,
          container_Id: containerId,
        }
      },
      onSelectRow: (tujuanbongkar, element) => {
        element.val(tujuanbongkar.tujuan)
        element.data('currentValue', element.val())

        $('#crudForm [name=tujuan]').first().val(tujuanbongkar.tujuan)

      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
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
          jenisorder_Id: jenisorderId,
          container_Id: containerId,
        }
      },
      onSelectRow: (shipper, element) => {
        element.val(shipper.namashipper)
        element.data('currentValue', element.val())

        $('#crudForm [name=namashipper]').first().val(shipper.namashipper)
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
          jenisorder_Id: jenisorderId,
          container_Id: containerId,
        }
      },
      onSelectRow: (lokasidooring, element) => {
        element.val(lokasidooring.lokasidooring)
        element.data('currentValue', element.val())

        $('#crudForm [name=namalokasidooring]').first().val(lokasidooring.lokasidooring)
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
      url: `{{ config('app.api_url') }}tarifdiscountharga/${Id}/${Aksi}/cekValidasi`,
      method: 'POST',
      dataType: 'JSON',
      data: {
        aksi: Aksi,
        nobukti: nobukti
      },
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      success: response => {
        var kondisi = response.kondisi
        isAllowEdited = response.edit;
        if (kondisi == true) {
          showDialog(response.message['keterangan'])
        } else {
          if (Aksi == 'edit') {
            editTarifDiscountHarga(selectedId)
          } else if (Aksi == 'delete') {
            deleteTarifDiscountHarga(Id)
          }
        }

      }
    })
  }
</script>
@endpush()