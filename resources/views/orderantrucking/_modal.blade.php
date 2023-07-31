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
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  NO BUKTI <span class="text-danger"></span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="nobukti" class="form-control" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  TGL BUKTI <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <div class="input-group">
                  <input type="text" name="tglbukti" class="form-control datepicker">
                </div>
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
                  AGEN <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="agen_id">
                <input type="text" name="agen" class="form-control agen-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  JENIS ORDER <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="jenisorder_id">
                <input type="text" name="jenisorder" class="form-control jenisorder-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  PELANGGAN <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="pelanggan_id">
                <input type="text" name="pelanggan" class="form-control pelanggan-lookup">
              </div>
            </div>
            <div class="row form-group" style="display:none;">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  TUJUAN <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="tarifrincian_id">
                <input type="text" name="tarifrincian" class="form-control tarifrincian-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  NO JOB EMKL (1)</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="nojobemkl" class="form-control orderanemkl-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  NO CONT (1)<span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="nocont" class="form-control" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  NO SEAL (1)<span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="noseal" class="form-control" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  NO JOB EMKL (2) </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="nojobemkl2" class="form-control orderanemkl-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  NO CONT (2)
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="nocont2" class="form-control" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  NO SEAL (2)
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="noseal2" class="form-control" readonly>
              </div>
            </div>
            <div class="row form-group" style="display: none">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  STATUS LANGSIR <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="statuslangsir" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH STATUS LANGSIR --</option>
                </select>
              </div>
            </div>
            <div class="row form-group" style="display: none">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  STATUS PERALIHAN <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="statusperalihan" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH STATUS PERALIHAN --</option>
                </select>
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
  let jenisorderId
  let containerId
  var statustas
  var kodecontainer

  $(document).ready(function() {
    $("#crudForm [name]").attr("autocomplete", "off");
    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let orderanTruckingId = form.find('[name=id]').val()
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

      data.push({
        name: 'tgldariheader',
        value: $('#tgldariheader').val()
      })
      data.push({
        name: 'tglsampaiheader',
        value: $('#tglsampaiheader').val()
      })

      let tgldariheader = $('#tgldariheader').val();
      let tglsampaiheader = $('#tglsampaiheader').val()

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}orderantrucking`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}orderantrucking/${orderanTruckingId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}orderantrucking/${orderanTruckingId}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}orderantrucking`
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
    initLookup()
    initSelect2(form.find('.select2bs4'), true)
    initDatepicker()
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    $('#crudModal').find('.modal-body').html(modalBody)
  })

  function createOrderanTrucking() {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create Orderan Trucking')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    $('#crudForm [name=nojobemkl]').attr('readonly', true)
    $('#crudForm [name=nojobemkl2]').attr('readonly', true)

    Promise
      .all([
        setStatusLangsirOptions(form),
        setStatusPeralihanOptions(form)
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

  function editOrderanTrucking(orderanTruckingId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Orderan Trucking')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()


    Promise
      .all([
        setStatusLangsirOptions(form),
        setStatusPeralihanOptions(form)
      ])
      .then(() => {
        showOrderanTrucking(form, orderanTruckingId)
          .then(() => {
            $('#crudModal').modal('show')
            $('#crudForm [name=tglbukti]').attr('readonly', true)
            $('#crudForm [name=tglbukti]').siblings('.input-group-append').remove()

          })
          .catch((error) => {
            showDialog(error.statusText)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  function deleteOrderanTrucking(orderanTruckingId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Orderan Trucking')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    $('#crudForm [name=tglbukti]').attr('readonly', true)
    $('#crudForm [name=tglbukti]').siblings('.input-group-append').remove()

    Promise
      .all([
        setStatusLangsirOptions(form),
        setStatusPeralihanOptions(form)
      ])
      .then(() => {
        showOrderanTrucking(form, orderanTruckingId)
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

  function approve() {
    event.preventDefault()
    
    let form = $('#crudForm')
    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')
    
    $.ajax({
        url: `${apiUrl}orderantrucking/approval`,
        method: 'POST',
        dataType: 'JSON',
        headers: {
            Authorization: `Bearer ${accessToken}`
        },
        data: {
          orderanTruckingId: selectedRows
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

  function approvalEditOrderanTrucking(){
    event.preventDefault()
    
    let form = $('#crudForm')
    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')
    
    $.ajax({
        url: `${apiUrl}orderantrucking/approvaledit`,
        method: 'POST',
        dataType: 'JSON',
        headers: {
            Authorization: `Bearer ${accessToken}`
        },
        data: {
          orderanTruckingId: selectedRows
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
    

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}orderantrucking/field_length`,
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

  const setStatusLangsirOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statuslangsir]').empty()
      relatedForm.find('[name=statuslangsir]').append(
        new Option('-- PILIH STATUS LANGSIR --', '', false, true)
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
              "data": "STATUS LANGSIR"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusLangsir => {
            let option = new Option(statusLangsir.text, statusLangsir.id)

            relatedForm.find('[name=statuslangsir]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  const setStatusPeralihanOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusperalihan]').empty()
      relatedForm.find('[name=statusperalihan]').append(
        new Option('-- PILIH STATUS PERALIHAN --', '', false, true)
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
              "data": "STATUS PERALIHAN"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusPeralihan => {
            let option = new Option(statusPeralihan.text, statusPeralihan.id)

            relatedForm.find('[name=statusperalihan]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function showOrderanTrucking(form, orderanTruckingId) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}orderantrucking/${orderanTruckingId}`,
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
        url: `${apiUrl}orderantrucking/default`,
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
      url: `${apiUrl}orderantrucking/${id}/getagentas`,
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
      url: `${apiUrl}orderantrucking/${id}/getcont`,
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

    $('.orderanemkl-lookup').lookup({
      title: 'orderanemkl Lookup',
      fileName: 'orderanemkl',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          jenisorder_Id: jenisorderId,
          container_Id: containerId,
        }
      },
      onSelectRow: (orderanemkl, element) => {
        element.val(orderanemkl.nojob)
        element.data('currentValue', element.val())

        $('#crudForm [name=nocont]').first().val(orderanemkl.nocont)
        $('#crudForm [name=noseal]').first().val(orderanemkl.noseal)
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.agen-lookup').lookup({
      title: 'Agen Lookup',
      fileName: 'agen',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }

      },
      onSelectRow: (agen, element) => {
        $('#crudForm [name=agen_id]').first().val(agen.id)
        element.val(agen.namaagen)
        element.data('currentValue', element.val())
        getagentas(agen.id)
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=agen_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.jenisorder-lookup').lookup({
      title: 'Jenis Order Lookup',
      fileName: 'jenisorder',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (jenisorder, element) => {
        $('#crudForm [name=jenisorder_id]').first().val(jenisorder.id)
        jenisorderId = jenisorder.id
        element.val(jenisorder.keterangan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=jenisorder_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.pelanggan-lookup').lookup({
      title: 'Pelanggan Lookup',
      fileName: 'pelanggan',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (pelanggan, element) => {
        $('#crudForm [name=pelanggan_id]').first().val(pelanggan.id)

        element.val(pelanggan.namapelanggan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=pelanggan_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.tarifrincian-lookup').lookup({
      title: 'Tarif Rincian Lookup',
      fileName: 'tarifrincian',
      beforeProcess: function(test) {
        this.postData = {
          container_Id: containerId,
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (tarifrincian, element) => {
        $('#crudForm [name=tarifrincian_id]').first().val(tarifrincian.id)
        element.val(tarifrincian.tujuan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=tarifrincian_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
  }

  function cekValidasidelete(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}orderantrucking/${Id}/${Aksi}/cekValidasi`,
      method: 'POST',
      dataType: 'JSON',
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      success: response => {
        var kondisi = response.kondisi
        if (kondisi == true) {
          showDialog(response.message['keterangan'])
        } else {
          if (Aksi == 'edit') {
            editOrderanTrucking(selectedId)
          } else if (Aksi == 'delete') {
            deleteOrderanTrucking(Id)
          }
        }

      }
    })
  }
</script>
@endpush()