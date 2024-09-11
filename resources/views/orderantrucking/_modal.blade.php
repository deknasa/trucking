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
            <input type="text" name="jenisorderemkl" class="form-control" hidden>
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
                <input type="text" name="container" id="container" class="form-control container-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  CUSTOMER <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="agen_id">
                <input type="text" name="agen" id="agen" class="form-control agen-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  JENIS ORDER <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="jenisorder_id">
                <input type="text" name="jenisorder" id="jenisorder" class="form-control jenisorder-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  SHIPPER <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="pelanggan_id">
                <input type="text" id="pelanggan" name="pelanggan" class="form-control pelanggan-lookup">
              </div>
            </div>
            <div class="row form-group gandengan">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  NO GANDENGAN / CHASIS <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="gandengan_id">
                <input type="text" id="gandengan" name="gandengan" class="form-control gandengan-lookup">
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
                <input type="text" name="nojobemkl2" class="form-control orderanemkl2-lookup">
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
  let orderemklshipper
  var jenisKendaraanTangki;
  var isTangki = false;


  $(document).ready(function() {
    $("#crudForm [name]").attr("autocomplete", "off");
    var orederan_id;
    getStatusJenisKendaraan()
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

      data.push({
        name: 'tgldariheader',
        value: $('#tgldariheader').val()
      })
      data.push({
        name: 'tglsampaiheader',
        value: $('#tglsampaiheader').val()
      })
      data.push({
        name: 'aksi',
        value: action.toUpperCase()
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
    form.find('#btnSubmit').prop('disabled', false)
    if (form.data('action') == "view") {
      form.find('#btnSubmit').prop('disabled', true)
    }
    initLookup()
    initSelect2(form.find('.select2bs4'), true)
    initDatepicker()
    orederan_id = $('#crudForm').find('[name=id]').val();
    if (accessCabang != 'MEDAN') {
      $('.gandengan').hide()
    }
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    removeEditingBy(orederan_id)
    $('#crudModal').find('.modal-body').html(modalBody)
    initDatepicker('datepickerIndex')
  })

  function removeEditingBy(id) {
    let formData = new FormData();


    formData.append('id', id);
    formData.append('aksi', 'BATAL');
    formData.append('table', 'orderantrucking');

    fetch(`{{ config('app.api_url') }}removeedit`, {
        method: 'POST',
        headers: {
          'Authorization': `Bearer ${accessToken}`
        },
        body: formData,
        keepalive: true

      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
        $("#crudModal").modal("hide");
      })
      .catch(error => {
        // Handle error
        if (error.status === 422) {
          $('.is-invalid').removeClass('is-invalid');
          $('.invalid-feedback').remove();
          setErrorMessages(form, error.responseJSON.errors);
        } else {
          showDialog(error.responseJSON);
        }
      })
  }

  function createOrderanTrucking() {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('add Orderan Trucking')
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
    Save
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
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
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

  function deleteOrderanTrucking(orderanTruckingId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-trash"></i>
    Delete
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

  function viewOrderanTrucking(orderanTruckingId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'view')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('View Orderan Trucking')
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
          .then(orderanTruckingId => {
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

  function approvalEditOrderanTrucking() {
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


  function approvalTanpaJobEMKL() {
    event.preventDefault()

    let form = $('#crudForm')
    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')

    $.ajax({
      url: `${apiUrl}orderantrucking/approvaltanpajob`,
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

  function getStatusJenisKendaraan() {
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
            "data": "STATUS JENIS KENDARAAN"
          }, {
            "field": "text",
            "op": "cn",
            "data": "TANGKI"
          }]
        })
      },
      success: response => {
        jenisKendaraanTangki = response.data[0].id;
      }
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
            if (index == 'nojobemkl') {
              element.data('current-value', value)
            }
            if (index == 'nojobemkl2') {
              element.data('current-value', value)
            }
            if (index == 'gandengan') {
              element.data('current-value', value)
            }

            if (index == 'agen_id') {
              getagentas(form, value, response.data.statusapprovaltanpajob, response.data.tglbatastanpajoborderantrucking)
            }
          })
          if (jenisKendaraanTangki == response.data.statusjeniskendaraan) {
            isTangki = true
            let container = $('#crudForm').find(`[name="container"]`).parents('.form-group').hide()
            let jenisorder = $('#crudForm').find(`[name="jenisorder"]`).parents('.form-group').hide()
            let nojobemkl = $('#crudForm').find(`[name="nojobemkl"]`).parents('.form-group').hide()
            let nocont = $('#crudForm').find(`[name="nocont"]`).parents('.form-group').hide()
            let noseal = $('#crudForm').find(`[name="noseal"]`).parents('.form-group').hide()
            let nojobemkl2 = $('#crudForm').find(`[name="nojobemkl2"]`).parents('.form-group').hide()
            let nocont2 = $('#crudForm').find(`[name="nocont2"]`).parents('.form-group').hide()
            let noseal2 = $('#crudForm').find(`[name="noseal2"]`).parents('.form-group').hide()
          }

          orderemklshipper = response.orderemklshipper
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

  function setJobReadOnly(form) {
    let nojobemkl = form.find('[name=nojobemkl]')
    let nojobemkl2 = form.find('[name=nojobemkl2]')
    let container_id = form.find('[name=container_id]').val()
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
      nojobemkl2.val('')
    } else {
      //tas
      nojobemkl.attr('readonly', false)
      nojobemkl.parents('.input-group').find('.input-group-append').show()
      nojobemkl.parents('.input-group').find('.button-clear').show()

      if (container_id == 3) {
        nojobemkl2.attr('readonly', false)
        nojobemkl2.parents('.input-group').find('.input-group-append').show()
        nojobemkl2.parents('.input-group').find('.button-clear').show()
      }
    }
  }

  function setContEnable() {
    let container_id = $('#crudForm [name=container_id]').val()
    let nojobemkl2 = $('#crudForm [name=nojobemkl2]')
    if (container_id == 3) {
      nojobemkl2.attr('readonly', false)
      nojobemkl2.parents('.input-group').find('.input-group-append').show()
      nojobemkl2.parents('.input-group').find('.button-clear').show()
    } else {
      nojobemkl2.attr('readonly', true)
      nojobemkl2.parents('.input-group').find('.input-group-append').hide()
      nojobemkl2.parents('.input-group').find('.button-clear').hide()
    }
  }


  function setContApprovalTanpaJob(form, statusapproval, tglbatas) {
    var tglbatasDate = new Date(tglbatas);
    var currentDate = new Date();

    let container_id = form.find('[name=container_id]').val()
    if (statusapproval == 3 && currentDate < tglbatasDate) {
      form.find('[name=nocont]').attr('readonly', false)
      form.find('[name=noseal]').attr('readonly', false)
      if (container_id == 3) {
        form.find('[name=nocont2]').attr('readonly', false)
        form.find('[name=noseal2]').attr('readonly', false)
      }

    } else {
      let nojobemkl = form.find('[name=nojobemkl]')
      let nojobemkl2 = form.find('[name=nojobemkl2]')

      if (statustas == 1) {

        nojobemkl.attr('readonly', false)
        nojobemkl.parents('.input-group').find('.input-group-append').show()
        nojobemkl.parents('.input-group').find('.button-clear').show()
        form.find('[name=nocont]').attr('readonly', true)
        form.find('[name=noseal]').attr('readonly', true)
      } else {

        form.find('[name=nocont]').attr('readonly', false)
        form.find('[name=noseal]').attr('readonly', false)
      }
      if (container_id == 3) {
        if (statustas == 1) {
          nojobemkl2.attr('readonly', false)
          nojobemkl2.parents('.input-group').find('.input-group-append').show()
          nojobemkl2.parents('.input-group').find('.button-clear').show()
          form.find('[name=nocont2]').attr('readonly', true)
          form.find('[name=noseal2]').attr('readonly', true)
        } else {

          form.find('[name=nocont2]').attr('readonly', false)
          form.find('[name=noseal2]').attr('readonly', false)
        }
      } else {

        nojobemkl2.attr('readonly', true)
        nojobemkl2.parents('.input-group').find('.input-group-append').hide()
        nojobemkl2.parents('.input-group').find('.button-clear').hide()
      }
    }
  }


  function getagentas(form, id, statusapproval, tglbatas) {
    $.ajax({
      url: `${apiUrl}orderantrucking/${id}/getagentas`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        'Authorization': `Bearer ${accessToken}`
      },
      success: response => {
        statustas = response.data.statustas
        if (statusapproval == 3) {
          statustas = 0
        }
        setJobReadOnly(form)
        setContApprovalTanpaJob(form, statusapproval, tglbatas)
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
        // setCont2Enable()
      },
      error: error => {
        showDialog(error.statusText)
      }
    })
  }

  function initLookup() {

    $('.container-lookup').lookupV3({
      title: 'Container Lookup',
      fileName: 'containerV3',
      labelColumn: false,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }

      },
      onSelectRow: (container, element) => {
        $('#crudForm [name=container_id]').first().val(container.id)
        element.val(container.kodecontainer)
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
      title: 'orderan emkl Lookup',
      fileName: 'orderanemkl',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          jenisorder_Id: jenisorderId,
          container_Id: containerId,
          orderemklshipper: orderemklshipper
        }
      },
      onSelectRow: (orderanemkl, element) => {
        element.val(orderanemkl.nojob)
        element.data('currentValue', element.val())

        $('#crudForm [name=nocont]').first().val(orderanemkl.nocont)
        $('#crudForm [name=noseal]').first().val(orderanemkl.noseal)
        $('#crudForm [name=jenisorderemkl]').first().val(orderanemkl.jenisorderan)

      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        $('#crudForm [name=nocont]').val('')
        $('#crudForm [name=noseal]').val('')
        element.data('currentValue', element.val())
      }
    })

    $('.orderanemkl2-lookup').lookup({
      title: 'orderanemkl Lookup',
      fileName: 'orderanemkl',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          jenisorder_Id: jenisorderId,
          container_Id: containerId,
          orderemklshipper: orderemklshipper
        }
      },
      onSelectRow: (orderanemkl, element) => {
        element.val(orderanemkl.nojob)
        element.data('currentValue', element.val())

        $('#crudForm [name=nocont2]').first().val(orderanemkl.nocont)
        $('#crudForm [name=noseal2]').first().val(orderanemkl.noseal)
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.agen-lookup').lookupV3({
      title: 'Customer Lookup',
      fileName: 'agenV3',
      // searching: ['namaagen'],
      labelColumn: false,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          Invoice: 'UTAMA',
        }

      },
      onSelectRow: (agen, element) => {
        $('#crudForm [name=agen_id]').first().val(agen.id)
        element.val(agen.namaagen)
        element.data('currentValue', element.val())
        getagentas($('#crudForm'), agen.id)
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
    $('.jenisorder-lookup').lookupV3({
      title: 'Jenis Order Lookup',
      fileName: 'jenisorderV3',
      // searching: ['keterangan'],
      labelColumn: false,
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
    $('.pelanggan-lookup').lookupV3({
      title: 'Shipper Lookup',
      fileName: 'pelangganV3',
      searching: ['kodepelanggan'],
      labelColumn: false,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (pelanggan, element) => {
        $('#crudForm [name=pelanggan_id]').first().val(pelanggan.id)

        element.val(pelanggan.kodepelanggan)
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

    $('.gandengan-lookup').lookup({
      title: 'Gandengan Lookup',
      fileName: 'gandengan',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        var jeniskendaraan = '';
        if (isTangki) {
          jeniskendaraan = jenisKendaraanTangki
        }
        this.postData = {

          Aktif: 'AKTIF',
          statusjeniskendaraan: jeniskendaraan,
        }
      },
      onSelectRow: (gandengan, element) => {
        $('#crudForm [name=gandengan_id]').first().val(gandengan.id)
        if ($('#crudForm [name=gandenganasal_id]').val() == '') {
          gandenganId = gandengan.id
        }
        element.val(gandengan.keterangan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=gandengan_id]').first().val('')
        element.val('')
        if ($('#crudForm [name=gandenganasal_id]').val() == '') {
          gandenganId = 0
        }
        element.data('currentValue', element.val())
      }
    })
    // $('.pelanggan-lookup').lookupMaster({
    //   title: 'pelanggan Lookup',
    //   fileName: 'pelangganMaster',
    //   typeSearch: 'ALL',
    //   searching: 1,
    //   beforeProcess: function(test) {
    //     this.postData = {
    //       Aktif: 'AKTIF',
    //       searching: 1,
    //       valueName: 'pelanggan_id',
    //       searchText: 'pelanggan-lookup',
    //       title: 'pelanggan',
    //       typeSearch: 'ALL',
    //     }
    //   },
    //   onSelectRow: (pelanggan, element) => {
    //     $('#crudForm [name=pelanggan_id]').first().val(pelanggan.id)
    //     element.val(pelanggan.keterangan)
    //     element.data('currentValue', element.val())
    //   },
    //   onCancel: (element) => {
    //     element.val(element.data('currentValue'))
    //   },
    //   onClear: (element) => {
    //     $('#crudForm [name=pelanggan_id]').first().val('')
    //     element.val('')
    //     element.data('currentValue', element.val())
    //   }
    // })
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

  function cekValidasidelete(Id, Aksi, nobukti) {
    $.ajax({
      url: `{{ config('app.api_url') }}orderantrucking/${Id}/${Aksi}/cekValidasi`,
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
        // var kondisi = response.kondisi
        var error = response.error
        isAllowEdited = response.edit;
        // if (kondisi == true) {
        if (error) {
          // showDialog(response.message['keterangan'])
          showDialog(response)
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