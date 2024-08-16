<div class="modal modal-fullscreen approval-modal" id="crudModalApprovalGambar" tabindex="-1" aria-labelledby="crudModalApprovalGambarLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="crudFormApprovalGambar">
      <div class="modal-content">
        <div class="modal-header">
          <p class="modal-title" id="crudModalApprovalGambarTitle"></p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          </button>
        </div>

        <form action="" method="post">
          <div class="modal-body">
            <input type="text" name="id" class="form-control" hidden readonly>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  nama supir <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <div class="input-group">
                  <input type="text" name="namasupir" class="form-control">
                </div>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  No KTP <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <div class="input-group">
                  <input type="text" name="noktp" id="noktp" maxlength="16" class="form-control numbernoseparate">
                </div>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  tgl batas <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <div class="input-group">
                  <input type="text" name="tglbatas" class="form-control datepicker">
                </div>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  STATUS APPROVAL <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <div class="input-group">
                  <select name="statusapproval" class="form-select select2bs4" style="width: 100%;">
                    <option value="">-- PILIH STATUS APPROVAL --</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="col-12 col-sm-9 col-md-10">

            </div>
          </div>
          <div class="modal-footer justify-content-start">
            <button id="btnSubmitApprovalGambar" class="btn btn-primary">
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
  let modalBodyApprovalGambar = $('#crudModalApprovalGambar').find('.modal-body').html()

  $(document).ready(function() {
    $('#btnSubmitApprovalGambar').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudFormApprovalGambar')
      let approvalSupirGambarId = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudFormApprovalGambar').serializeArray()

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
          url = `${apiUrl}approvalsupirgambar`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}approvalsupirgambar/${approvalSupirGambarId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}approvalsupirgambar/${approvalSupirGambarId}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}approvalsupirgambar`
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
          $('#crudFormApprovalGambar').trigger('reset')
          $('#crudModalApprovalGambar').modal('hide')

          $('#jqGrid').trigger('reloadGrid');
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
    })
  })

  $('#crudModalApprovalGambar').on('shown.bs.modal', () => {
    let form = $('#crudFormApprovalGambar')

    setFormBindKeys(form)

    activeGrid = null
    initDatepicker()
    initSelect2(form.find('.select2bs4'), true)

  })

  $('#crudModalApprovalGambar').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    $('#crudModalApprovalGambar').find('.modal-body').html(modalBodyApprovalGambar)
  })

  function createApprovalSupirGambar() {
    let form = $('#crudFormApprovalGambar')

    form.trigger('reset')
    form.find('#btnSubmitApprovalGambar').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.data('action', 'add')
    $('#crudModalApprovalGambarTitle').text('APPROVAL/UN Approval Supir Gambar')
    $('#crudModalApprovalGambar').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    // setStatusApprovalOptions(form)
    Promise
      .all([
        setStatusApprovalOptions(form)
      ])
      .then(() => {
        showDefault(form)
      })

  }

  function approvalSupirGambar(id) {
    let form = $('#crudFormApprovalGambar')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmitApprovalGambar').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    $('#crudModalApprovalGambarTitle').text('APPROVAL/UN Supir tanpa Gambar')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    Promise
      .all([
        setStatusApprovalOptions(form),
      ])
      .then(() => {
        showApprovalSupirGambar(form, id)
          .then((response) => {
            let approvalGambar = response;
            $('#crudModalApprovalGambar').modal('show')
            form.data('action', 'add')
            if (approvalGambar.id) {
              form.data('action', 'edit')
            }
            $('#crudModalApprovalGambar').modal('show')
          })
          .catch((error) => {
            showDialog(error.statusText)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })

      })



  }



  function showApprovalSupirGambar(form, Id) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}approvalsupirgambar`,
        method: 'GET',
        dataType: 'JSON',
        data: {
          supir_id: Id
        },
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)

            if (element.is('select')) {
              element.val(value).trigger('change')
            } else if (element.hasClass('datepicker')) {
              if (value) {
                element.val(dateFormat(value))
              }
            } else {
              element.val(value)
            }
            if (index == 'namasupir') {
              element.prop('readonly', true)
            }
            if (index == 'noktp') {
              element.prop('readonly', true)
            }
          })

          resolve(response.data)

        },
        error: error => {
          reject(error)
        }
      })
    })
  }
</script>
@endpush()