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
            <input type="text" name="id" class="form-control" hidden readonly>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  tgl bukti <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <div class="input-group">
                  <input type="text" name="tglbukti" class="form-control datepicker">
                </div>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  pengeluaran stok <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <div class="input-group">
                  <input type="text" name="pengeluaranstok" class="form-control pengeluaranstok-lookup">
                  <input type="text" id="pengeluaranstokId" name="pengeluaranstok_id" hidden readonly>
                </div>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-start">
            <button id="btnSubmit" class="btn btn-primary">
              <i class="fa fa-save"></i>
              Save
            </button>
            <button id="btnSaveAdd" class="btn btn-success">
              <i class="fas fa-file-upload"></i>
              Save & Add
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
      submit($(this).attr('id'))
    })
    $('#btnSaveAdd').click(function(event) {
      event.preventDefault()
      submit($(this).attr('id'))
    })
    
    function submit(button) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let bukaPengeluaranStokId = form.find('[name=id]').val()
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
        name: 'button',
        value: button
      })

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}bukapengeluaranstok`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}bukapengeluaranstok/${bukaPengeluaranStokId}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}bukapengeluaranstok`
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

          if (button == 'btnSubmit') {  
            $('#crudModal').modal('hide')

            id = response.data.id

            $('#jqGrid').jqGrid('setGridParam', {
              page: response.data.page
            }).trigger('reloadGrid');

            if (response.data.grp == 'FORMAT') {
              updateFormat(response.data)
            }
          }else {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
            $('#crudForm').find('input[type="text"]').data('current-value', '')
            // showSuccessDialog(response.message, response.data.nobukti)
            createBukaPengeluaranStok();
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
    }
  })

  $('#crudModal').on('shown.bs.modal', () => {
    let form = $('#crudForm')

    setFormBindKeys(form)

    if (form.data('action') == 'add') {
      form.find('#btnSaveAdd').show()
    } else {
      form.find('#btnSaveAdd').hide()
    }
    activeGrid = null
    initDatepicker()
    initLookup()
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    $('#crudModal').find('.modal-body').html(modalBody)
  })

  function createBukaPengeluaranStok() {
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.data('action', 'add')
    $('#crudModalTitle').text('Add Buka Pengeluaran Stok')
     if (selectedRows.length > 0) {
              clearSelectedRows()
            }
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
  }

  function deleteBukaPengeluaranStok(bukaPengeluaranStokId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-trash"></i>
    Delete
  `)
    $('#crudModalTitle').text('Delete Buka Pengeluaran Stok')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        showBukaPengeluaranStok(form, bukaPengeluaranStokId)
      ])
      .then(() => {
         if (selectedRows.length > 0) {
              clearSelectedRows()
            }
        $('#crudModal').modal('show')
        form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
      })
      .catch((error) => {
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }

  function updatetanggalbatas(bukaPengeluaranStokId) {
    event.preventDefault()
    let form = $('#crudForm')
    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')
    $.ajax({
      url: `${apiUrl}bukapengeluaranstok/${bukaPengeluaranStokId}/updatetanggalbatas`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        $('#crudForm').trigger('reset')
        $('#crudModal').modal('hide')
        $('#jqGrid').jqGrid().trigger('reloadGrid');

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



  function showBukaPengeluaranStok(form, bukaPengeluaranStokId) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}bukapengeluaranstok/${bukaPengeluaranStokId}`,
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
            } else if (element.attr("name") == 'tglbukti') {
              var result = value.split('-');
              element.val(result[2] + '-' + result[1] + '-' + result[0]);
            } else {
              element.val(value)
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
    $('.pengeluaranstok-lookup').lookup({
      title: 'pengeluaran stok Lookup',
      fileName: 'pengeluaranstok',
      onSelectRow: (pengeluaranstok, element) => {
        element.val(pengeluaranstok.kodepengeluaran)
        $(`#${element[0]['name']}Id`).val(pengeluaranstok.id)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        $(`#${element[0]['name']}Id`).val('')
        element.data('currentValue', element.val())
      }
    })
  }
</script>
@endpush()