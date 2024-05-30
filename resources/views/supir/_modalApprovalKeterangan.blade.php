<div class="modal modal-fullscreen approval-modal" id="crudModalApprovalKeterangan" tabindex="-1" aria-labelledby="crudModalApprovalKeteranganLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="crudFormApprovalKeterangan">
      <div class="modal-content">
        <div class="modal-header">
          <p class="modal-title" id="crudModalApprovalKeteranganTitle"></p>
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
            <button id="btnSubmitApprovalKeterangan" class="btn btn-primary">
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
  let modalBodyApprovalKeterangan = $('#crudModalApprovalKeterangan').find('.modal-body').html()

  $(document).ready(function() {
    $('#btnSubmitApprovalKeterangan').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudFormApprovalKeterangan')
      let approvalSupirKeteranganId = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudFormApprovalKeterangan').serializeArray()

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
          url = `${apiUrl}approvalsupirketerangan`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}approvalsupirketerangan/${approvalSupirKeteranganId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}approvalsupirketerangan/${approvalSupirKeteranganId}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}approvalsupirketerangan`
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
          $('#crudFormApprovalKeterangan').trigger('reset')
          $('#crudModalApprovalKeterangan').modal('hide')

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

  $('#crudModalApprovalKeterangan').on('shown.bs.modal', () => {
    let form = $('#crudFormApprovalKeterangan')

    setFormBindKeys(form)

    activeGrid = null
    initDatepicker()
    initSelect2(form.find('.select2bs4'), true)
  })

  $('#crudModalApprovalKeterangan').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    $('#crudModalApprovalKeterangan').find('.modal-body').html(modalBodyApprovalKeterangan)
  })

  function approvalSupirKeterangan(id) {
    let form = $('#crudFormApprovalKeterangan')
    $('.modal-loader').removeClass('d-none')

    form.trigger('reset')
    form.find('#btnSubmitApprovalKeterangan').html(`<i class="fa fa-save"></i> Save`)

    form.find(`.sometimes`).show()
    $('#crudModalApprovalKeteranganTitle').text('APPROVAL/UN Supir tanpa Keterangan')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise.all([
        setStatusApprovalOptions(form),
        showApprovalSupirKeterangan(form, id)
      ])
      .then((response) => {
        let approvalKeterangan = response[1];
        $('#crudModalApprovalKeterangan').modal('show')
        form.data('action', 'add')
        if (approvalKeterangan.id) {
          form.data('action', 'edit')
        }
      })
      .catch((error) => {
        console.log(error);
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }



  function showApprovalSupirKeterangan(form, Id) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}approvalsupirketerangan`,
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


  const setStatusApprovalOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusapproval]').empty()
      relatedForm.find('[name=statusapproval]').append(
        new Option('-- PILIH STATUS APPROVAL --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}parameter/combo`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          grp: 'STATUS APPROVAL',
          subgrp: 'STATUS APPROVAL'
        },
        success: response => {
          response.data.forEach(statusApproval => {
            let option = new Option(statusApproval.text, statusApproval.id)
            relatedForm.find('[name=statusapproval]').append(option).trigger('change')
          });
          resolve()


        }
      })
    })
  }
</script>
@endpush()