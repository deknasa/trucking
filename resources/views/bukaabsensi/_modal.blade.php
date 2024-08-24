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
                  tgl absensi <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <div class="input-group">
                  <input type="text" name="tglabsensi" class="form-control datepicker">
                </div>
              </div>
            </div>


            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  user
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="user_id">
                <input type="text" id="user" name="user" class="form-control user-lookup">
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

      let method
      let url
      let form = $('#crudForm')
      let bukaAbsensiId = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()

      data.push({
        name: 'button',
        value: button
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
          url = `${apiUrl}bukaabsensi`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}bukaabsensi/${bukaAbsensiId}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}bukaabsensi`
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

          if (button == 'btnSubmit') {
            $('#crudForm').trigger('reset')
            $('#crudModal').modal('hide')

            id = response.data.id

            $('#jqGrid').jqGrid('setGridParam', {
              page: response.data.page
            }).trigger('reloadGrid');

            if (response.data.grp == 'FORMAT') {
              updateFormat(response.data)
            }
          } else {

            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
            // showSuccessDialog(response.message)
            createBukaAbsensi()
            $('#crudForm').find('[name=tglabsensi]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

            $('#crudForm').find('input[type="text"]').data('current-value', '')
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
    initLookup();
    if (form.data('action') == 'add') {
      form.find('#btnSaveAdd').show()
    } else {
      form.find('#btnSaveAdd').hide()
    }
    activeGrid = null
    initDatepicker()
    $('#crudForm').find('[name=tglabsensi]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    $('#crudModal').find('.modal-body').html(modalBody)
  })

  function createBukaAbsensi() {
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.data('action', 'add')
    if (selectedRows.length > 0) {
      clearSelectedRows()
    }
    $('#crudModalTitle').text('Add Buka tanggal Absensi')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
  }

  function deleteBukaAbsensi(bukaAbsensiId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-trash"></i>
    Delete
  `)
    $('#crudModalTitle').text('Delete Buka tanggal Absensi')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        showBukaAbsensi(form, bukaAbsensiId)
      ])
      .then(() => {
        if (selectedRows.length > 0) {
          clearSelectedRows()
        }
        $('#crudModal').modal('show')
        form.find(`[name="tglabsensi"]`).parent('.input-group').find('.input-group-append').remove()
      })
      .catch((error) => {
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }

  function updatetanggalbatas() {
    event.preventDefault()
    let form = $('#crudForm')
    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')
    $.ajax({
      url: `${apiUrl}bukaabsensi/updatetanggalbatas`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        Id: selectedRows,
        table: 'tanggal absensi'
      },
      success: response => {
        clearSelectedRows()
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



  function showBukaAbsensi(form, bukaAbsensiId) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}bukaabsensi/${bukaAbsensiId}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)
            console.log(value)
            if (element.is('select')) {
              element.val(value).trigger('change')
            } else if (element.attr("name") == 'tglabsensi') {
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
    $('.user-lookup').lookupV3({
      title: 'Supir Lookup',
      fileName: 'userV3',
      searching: ['user'],
      labelColumn: false,
     
      beforeProcess: function(test) {
        this.postData = {
          role: 'MANDOR',
        }
      },
      onSelectRow: (supir, element) => {
        $('#crudForm [name=user_id]').first().val(user.id) 
        element.val(supir.user)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=user_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    // $('.user-lookup').lookupMaster({
    //   title: 'user Lookup',
    //   fileName: 'userMaster',
    //   typeSearch: 'ALL',
    //   searching: 1,
    //   beforeProcess: function(test) {
    //     this.postData = {
    //       searching: 1,
    //       valueName: 'user_id',
    //       searchText: 'user-lookup',
    //       title: 'User',
    //       typeSearch: 'ALL',
    //       role: 'MANDOR',
    //     }
    //   },
    //   onSelectRow: (user, element) => {
    //     $('#crudForm [name=user_id]').first().val(user.id)
    //     element.val(user.name)
    //     element.data('currentValue', element.val())
    //   },
    //   onCancel: (element) => {
    //     element.val(element.data('currentValue'))
    //   },
    //   onClear: (element) => {
    //     $('#crudForm [name=user_id]').first().val('')
    //     element.val('')
    //     element.data('currentValue', element.val())
    //   }
    // })
  }
</script>
@endpush()