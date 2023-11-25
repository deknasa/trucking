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
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  kode penerimaan <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="kodepenerimaan" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  keterangan
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="keterangan" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  KODE PERKIRAAN debet <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="coadebet">
                <input type="text" name="coadebetKeterangan" class="form-control coadebet-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  KODE PERKIRAAN kredit<span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="coakredit">
                <input type="text" name="coakreditKeterangan" class="form-control coakredit-lookup">
              </div>
            </div>

            
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  KODE PERKIRAAN posting debet <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="coapostingdebet">
                <input type="text" name="coapostingdebetKeterangan" class="form-control coapostingdebet-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  KODE PERKIRAAN posting kredit<span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="coapostingkredit">
                <input type="text" name="coapostingkreditKeterangan" class="form-control coapostingkredit-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  FORMAT<span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <select name="format" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH FORMAT --</option>
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

  $(document).ready(function() {
    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let penerimaanTruckingId = form.find('[name=id]').val()
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

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}penerimaantrucking`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}penerimaantrucking/${penerimaanTruckingId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}penerimaantrucking/${penerimaanTruckingId}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}penerimaantrucking`
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

          $('#jqGrid').trigger('reloadGrid', {
            page: response.data.page
          })

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
    form.find('#btnSubmit').prop('disabled',false)
    if (form.data('action') == "view") {
      form.find('#btnSubmit').prop('disabled',true)
    }
    initLookup()
    initSelect2(form.find('.select2bs4'), true)
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    $('#crudModal').find('.modal-body').html(modalBody)
  })

  function createPenerimaanTrucking() {
    let form = $('#crudForm')

    
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create Penerimaan Trucking')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusFormatOptions(form),
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

  function editPenerimaanTrucking(penerimaanTruckingId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Penerimaan Trucking')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusFormatOptions(form),
      ])
      .then(() => {
        showPenerimaanTrucking(form, penerimaanTruckingId)
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

  function deletePenerimaanTrucking(penerimaanTruckingId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')


    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Penerimaan Trucking')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusFormatOptions(form),
      ])
      .then(() => {
        showPenerimaanTrucking(form, penerimaanTruckingId)
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
  function viewPenerimaanTrucking(penerimaanTruckingId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')
    form.data('action', 'view')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('View Penerimaan Trucking')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
    .all([
      setStatusFormatOptions(form),
    ])
    .then(() => {
      showPenerimaanTrucking(form, penerimaanTruckingId)
      .then(penerimaanTruckingId => {
        // form.find('.aksi').hide()
        setFormBindKeys(form)
        initSelect2(form.find('.select2bs4'), true)
        form.find('[name]').removeAttr('disabled')
    
        form.find('select').each((index, select) => {
          let element = $(select)
          if (element.data('select2')) {
              element.select2('destroy')
          }
        })
        form.find('[name]').attr('disabled', 'disabled').css({
          background: '#fff'
        })
        form.find('[name=id]').prop('disabled',false)
      })
      .then(() => {
        $('#crudModal').modal('show')
        form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').remove()
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
      
          

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}penerimaantrucking/field_length`,
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

  const setStatusFormatOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=format]').empty()
      relatedForm.find('[name=format]').append(
        new Option('-- PILIH FORMAT --', '', false, true)
      ).trigger('change')

      $.ajax({
        limit:0,
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
              "data": "PENERIMAAN TRUCKING"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusFormat => {
            let option = new Option(statusFormat.text, statusFormat.id)

            relatedForm.find('[name=format]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function showPenerimaanTrucking(form, penerimaanTruckingId) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}penerimaantrucking/${penerimaanTruckingId}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)

            if (element.is('select')) {
              element.val(value).trigger('change')
            } else {
              element.val(value)
            }
            if (index == 'kodepenerimaan') {
              element.attr('readonly', true)
            }
            if (index == 'coadebetKeterangan') {
              element.data('current-value', value)
            }
            if (index == 'coakreditKeterangan') {
              element.data('current-value', value)
            }
            if (index == 'coapostingdebetKeterangan') {
              element.data('current-value', value)
            }
            if (index == 'coapostingkreditKeterangan') {
              element.data('current-value', value)
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

  function initLookup() {
    $('.coadebet-lookup').lookup({
      title: 'Nama Perkiraan (Debet) Lookup',
      fileName: 'akunpusat',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {
          levelCoa: '3',
          Aktif: 'AKTIF',          
        }
      },      
      onSelectRow: (akunpusat, element) => {
        $('#crudForm [name=coadebet]').first().val(akunpusat.coa)
        element.val(akunpusat.keterangancoa)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=coadebet]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.coakredit-lookup').lookup({
      title: 'Nama Perkiraan (Kredit) Lookup',
      fileName: 'akunpusat',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {
          levelCoa: '3',
          Aktif: 'AKTIF',          
        }
      },      
      onSelectRow: (akunpusat, element) => {
        $('#crudForm [name=coakredit]').first().val(akunpusat.coa)
        element.val(akunpusat.keterangancoa)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=coakredit]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    
    $('.coapostingdebet-lookup').lookup({
      title: 'Nama Perkiraan (Posting Debet) Lookup',
      fileName: 'akunpusat',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {
          levelCoa: '3',
          Aktif: 'AKTIF',          
        }
      },      
      onSelectRow: (akunpusat, element) => {
        $('#crudForm [name=coapostingdebet]').first().val(akunpusat.coa)
        element.val(akunpusat.keterangancoa)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=coapostingdebet]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.coapostingkredit-lookup').lookup({
      title: 'Nama Perkiraan (Posting Kredit) Lookup',
      fileName: 'akunpusat',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {
          levelCoa: '3',
          Aktif: 'AKTIF',          
        }
      },      
      onSelectRow: (akunpusat, element) => {
        $('#crudForm [name=coapostingkredit]').first().val(akunpusat.coa)
        element.val(akunpusat.keterangancoa)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=coapostingkredit]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

  }
  
  function cekValidasidelete(Id) {
    $.ajax({
      url: `{{ config('app.api_url') }}penerimaantrucking/${Id}/cekValidasi`,
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
              deletePenerimaanTrucking(Id)
          }

      }
    })
  }

</script>
@endpush()