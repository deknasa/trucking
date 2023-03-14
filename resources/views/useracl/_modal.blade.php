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
            <div class="row">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  USER <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <select name="user_id" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH USER --</option>
                </select>
              </div>
            </div>

            <hr>

            <table class="table table-borderd" id="accessList">
              <thead class="table-secondary">
                <tr>
                  <th>HAK</th>
                  <th>NAMA CONTROLLER</th>
                  <th>STATUS</th>
                </tr>
              </thead>
              <tbody>

              </tbody>
            </table>
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
  let statusAktif

  $(document).ready(function() {
    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let userId = form.find('[name=user_id]').val()
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

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}useracl`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}useracl/${userId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}useracl/${userId}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}useracl`
          break;
      }

      $(this).attr('disabled', '')
      $('#loader').removeClass('d-none')

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
            showDialog(error.statusText)
          }
        },
      }).always(() => {
        $('#loader').addClass('d-none')
        $(this).removeAttr('disabled')
      })
    })

    getStatusAktifOptions()
      .then(response => {
        statusAktif = response

      })

    $('#crudForm [name=user_id]').on('change', function(event) {
      let userId = $(this).val()

      if (userId !== '') {
        getAccessList(userId)
      }
    })
  })

  $('#crudModal').on('shown.bs.modal', () => {
    let form = $('#crudForm')

    setFormBindKeys(form)

    activeGrid = null

    getMaxLength(form)
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
  })

  function createUserAcl() {
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create User Acl')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    setUserOptions(form)
  }

  function editUserAcl(userId) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit User Acl')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setUserOptions(form)
      ])
      .then(() => {
        showUserAcl(form, userId)
      })
  }

  function deleteUserAcl(userId) {
    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete User Acl')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setUserOptions(form)
      ])
      .then(() => {
        showUserAcl(form, userId)
      })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}useracl/field_length`,
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

  const setUserOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=user_id]').empty()
      relatedForm.find('[name=user_id]').append(
        new Option('-- PILIH USER --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}user`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          limit: 0
        },
        success: response => {
          response.data.forEach(user => {
            let option = new Option(user.user, user.id)

            relatedForm.find('[name=user_id]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  function showUserAcl(form, userId) {
    $.ajax({
      url: `${apiUrl}useracl/${userId}`,
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
        })
      }
    })
  }

  const getStatusAktifOptions = function() {
    return new Promise((resolve, reject) => {
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
          resolve(response.data)
        }
      })
    })
  }

  function getAccessList(userId) {
    $('#accessList tbody').html('')
    
    $.ajax({
      url: `${apiUrl}useracl/detaillist`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        user_id: userId
      },
      success: response => {
        $('#accessList tbody').html(`
          ${
            response.data.map(accessList => {
              return `
                <tr>
                  <input type="hidden" name="aco_id[]" value="${accessList.aco_id}">
                  <input type="hidden" name="nama[]" value="${accessList.nama}">
                  <input type="hidden" name="class[]" value="${accessList.class}">
                
                  <td> ${accessList.nama} </td>
                  <td> ${accessList.class} </td>
                  <td>
                    <select name="status[]">
                    ${
                      statusAktif.map(row => {
                        return `
                            <option value="${row.id}" ${accessList.status == row.id ? 'selected' : ''}>${row.text}</option>
                        `
                      })
                    }
                    </select>
                  </td>
                </tr>
              `
            })
          }
        `)

        initSelect2($(`#crudForm select:not('.select2-hidden-accessible')`))
      }
    })
  }
</script>
@endpush()