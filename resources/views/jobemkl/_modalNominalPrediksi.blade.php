<div class="modal modal-fullscreen approval-modal" id="crudModalNominalPrediksi" tabindex="-1" aria-labelledby="crudModalNominalPrediksiLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="crudFormNominalPrediksi">
      <div class="modal-content">
        <div class="modal-header">
          <p class="modal-title" id="crudModalNominalPrediksiTitle"></p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          </button>
        </div>

        <form action="" method="post">
          <div class="modal-body">
            <input type="text" name="id" class="form-control" hidden readonly>

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
                  nominal <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <div class="input-group">
                  <input type="text" name="nominal" id="nominal" style="text-align:right" class="form-control ">
                </div>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  Keterangan Biaya <span class="text-danger"></span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <div class="input-group">
                  <input type="text" name="keteranganBiaya" id="keteranganBiaya" style="text-align:right" class="form-control  keteranganBiaya_modalinput">
                </div>
              </div>
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
  let modalBodyApprovalTanpa = $('#crudModalNominalPrediksi').find('.modal-body').html()
  let showGambar;
  let showKeterangan;
  let indexModalRow=0;
  
  $(document).ready(function() {
    $('#btnSubmitApprovalTanpa').click(function(event) {
      event.preventDefault()
      let method
      let url
      let form = $('#crudFormNominalPrediksi')
      let nominalId = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudFormNominalPrediksi').serializeArray()
      data.filter((row) => row.name === 'nominal')[0].value = AutoNumeric.getNumber($(`#crudFormNominalPrediksi [name="nominal"]`)[0])

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
          url = `${apiUrl}jobemkl/nominalprediksi`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}jobemkl/nominalprediksi/${nominalId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}jobemkl/nominalprediksi/${nominalId}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}jobemkl/nominalprediksi`
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
          $('#crudFormNominalPrediksi').trigger('reset')
          $('#crudModalNominalPrediksi').modal('hide')

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

  $('#crudModalNominalPrediksi').on('shown.bs.modal', () => {
    let form = $('#crudFormNominalPrediksi')

    setFormBindKeys(form)

    activeGrid = null
    // initDatepicker()
    // initSelect2(form.find('.select2bs4'), true)
  })

  $('#crudModalNominalPrediksi').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    $('#crudModalNominalPrediksi').find('.modal-body').html(modalBodyApprovalTanpa)
  })

  function jobEmklNominalPrediksi(id) {
    let form = $('#crudFormNominalPrediksi')
    $('.modal-loader').removeClass('d-none')

    form.trigger('reset')
    form.find('#btnSubmitApprovalTanpa').html(`<i class="fa fa-save"></i> Save`)

    form.find(`.sometimes`).show()
    $('#crudModalNominalPrediksiTitle').text('Job EMKL Nominal Prediksi ')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise.all([] )
    .then(() => {
      showJobEmklNominalPrediksi(form, id)
      .then((response) => {
        
        let approvalTanpa = response;
        $('#crudModalNominalPrediksi').modal('show')
        form.data('action', 'add')
      
        initAutoNumeric(form.find(`[name="nominal"]`))


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

  function showJobEmklNominalPrediksi(form, Id) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}jobemkl/${Id}`,
        method: 'GET',
        dataType: 'JSON',
        data: {
          jobemkl_id: Id
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
            if (index == 'nobukti') {
              element.prop('readonly', true)
            }
          
          })
          initLookupDetail();
          resolve(response.data)
        },
        error: error => {
          reject(error)
        }
      })
    })
  }
  function initLookupDetail() {
    $(`.keteranganBiaya_modalinput`).modalInput({
      title: 'Keterangan Biaya Job',
      fileName: 'jobbiaya_nominal',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (data, element) => {
        element.val(JSON.stringify(data));
        element.data('currentValue', JSON.stringify(data))
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
    


  function cekValidasiTanpa(Id) {
    $.ajax({
      url: `{{ config('app.api_url') }}jobemkl/${Id}/cekValidasi`,
      method: 'POST',
      dataType: 'JSON',
      data: {
        aksi: "ApprovalTanpa"
      },
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      success: response => {
        var error = response.error
        if (error) {
          showDialog('Gambar dan Keterangan Supir Telah terisi Semua')
        } else {
          showGambar = response.statusapproval.gambar
          showKeterangan = response.statusapproval.keterangan
          approvalSupirTanpa(Id)
        }

      }
    })
  }
</script>
@endpush()