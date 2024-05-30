<div class="modal modal-fullscreen approval-modal" id="crudModalApprovalTanpa" tabindex="-1" aria-labelledby="crudModalApprovalTanpaLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="crudFormApprovalTanpa">
      <div class="modal-content">
        <div class="modal-header">
          <p class="modal-title" id="crudModalApprovalTanpaTitle"></p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          </button>
        </div>

        <form action="" method="post">
          <div class="modal-body">
            <input type="text" name="id" class="form-control" hidden readonly>

            <div class="row form-group">
              <div class="col-12 col-md-2">
                  <label class="col-form-label">
                      KODE TRADO <span class="text-danger">*</span>
                  </label>
              </div>
              <div class="col-12 col-md-10">
                  <input type="text" name="kodetrado" class="form-control">
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
                  APPROVAL TANPA KETERANGAN <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="keterangan_id" class="form-control" readonly hidden>
                
                <div class="input-group">
                  <select name="keterangan_statusapproval" class="form-select select2bs4" style="width: 100%;">
                    <option value="">-- PILIH STATUS APPROVAL --</option>
                  </select>
                </div>
              </div>
            </div>
            
            
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  APPROVAL TANPA GAMBAR <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="gambar_id" class="form-control" readonly hidden>
                
                <div class="input-group">
                  <select name="gambar_statusapproval" class="form-select select2bs4" style="width: 100%;">
                    <option value="">-- PILIH STATUS APPROVAL --</option>
                  </select>
                </div>
              </div>
            </div>

            <div class="col-12 col-sm-9 col-md-10">

            </div>
          </div>
          <div class="modal-footer justify-content-start">
            <button id="btnSubmitApprovalTanpa" class="btn btn-primary">
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
  let modalBodyApprovalTanpa = $('#crudModalApprovalTanpa').find('.modal-body').html()
  let showGambar;
  let showKeterangan;
  
  $(document).ready(function() {
    $('#btnSubmitApprovalTanpa').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudFormApprovalTanpa')
      let approvalTradoTanpaId = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudFormApprovalTanpa').serializeArray()
      

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
          url = `${apiUrl}trado/approvaltradotanpa`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}trado/approvaltradotanpa/${approvalTradoTanpaId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}trado/approvaltradotanpa/${approvalTradoTanpaId}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}trado/approvaltradotanpa`
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
          $('#crudFormApprovalTanpa').trigger('reset')
          $('#crudModalApprovalTanpa').modal('hide')

          $('#jqGrid').trigger('reloadGrid');
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
    })
  })

  $('#crudModalApprovalTanpa').on('shown.bs.modal', () => {
    let form = $('#crudFormApprovalTanpa')

    setFormBindKeys(form)

    activeGrid = null
    initDatepicker()
    initSelect2(form.find('.select2bs4'), true)
  })

  $('#crudModalApprovalTanpa').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    $('#crudModalApprovalTanpa').find('.modal-body').html(modalBodyApprovalTanpa)
  })

  function approvalTradoTanpa(id) {
    let form = $('#crudFormApprovalTanpa')
    $('.modal-loader').removeClass('d-none')

    form.trigger('reset')
    form.find('#btnSubmitApprovalTanpa').html(`<i class="fa fa-save"></i> Save`)

    form.find(`.sometimes`).show()
    $('#crudModalApprovalTanpaTitle').text('APPROVAL/UN Trado tanpaKeterangan')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise.all([
      setStatusApprovalOptions(form),
    ])
    .then(() => {
      showApprovalTradoTanpa(form, id)
      .then((response) => {
        let approvalTanpa = response;
        $('#crudModalApprovalTanpa').modal('show')
        form.data('action', 'add')
        if (approvalTanpa.id) {
          form.data('action', 'edit')
        }
        if (!showKeterangan) {
          $('[name=keterangan_statusapproval]').parents('.form-group').hide()
        }
        if (!showGambar) {
          $('[name=gambar_statusapproval]').parents('.form-group').hide()
        }    
      })
      .catch((error) => {
        console.log(error);
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
    })
  }

  function showApprovalTradoTanpa(form, Id) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}trado/approvaltradotanpa`,
        method: 'GET',
        dataType: 'JSON',
        data: {
          trado_id: Id
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
            if(index == 'kodetrado'){
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
      relatedForm.find('[name=keterangan_statusapproval]').empty()
      relatedForm.find('[name=keterangan_statusapproval]').append(
        new Option('-- PILIH STATUS APPROVAL --', '', false, true)
      ).trigger('change')
      relatedForm.find('[name=gambar_statusapproval]').empty()
      relatedForm.find('[name=gambar_statusapproval]').append(
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
            relatedForm.find('[name=keterangan_statusapproval]').append(option).trigger('change')
          });
          response.data.forEach(statusApproval => {
            let option = new Option(statusApproval.text, statusApproval.id)
            relatedForm.find('[name=gambar_statusapproval]').append(option).trigger('change')
          });
          resolve()


        }
      })
    })
  }
  
  function cekValidasiTanpa(Id) {
    $.ajax({
      url: `{{ config('app.api_url') }}trado/${Id}/cekValidasi`,
      method: 'POST',
      dataType: 'JSON',
      data: {
        aksi: "ApprovalTanpa"
      },
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      success: response => {
        console.log(response);
        var error = response.error
        if (error) {
          showDialog('Gambar dan Keterangan Trado Telah terisi Semua')
        } else {
          showGambar = response.statusapproval.gambar
          showKeterangan = response.statusapproval.keterangan
          approvalTradoTanpa(Id)
        }

      }
    })
  }
</script>
@endpush()