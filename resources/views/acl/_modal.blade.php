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
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  ROLE <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="role_id">
                <input type="text" name="rolename" class="form-control role-lookup">
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

    
    $(`#crudForm [name="role_id"]`).on('change', function(event) {
      let roleId = $(this).val()
      if (roleId !== '') {
        getAccessList(roleId)
      }
    })

    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let roleId = form.find('[name=role_id]').val()
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
          url = `${apiUrl}acl`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}acl/${roleId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}acl/${roleId}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}acl`
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

          id = response.data.position

          $('#jqGrid').jqGrid('setGridParam', { page: response.data.page}).trigger('reloadGrid');

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

  function createAcl() {
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create Acl')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    // setRoleOptions(form)
  }

  function editAcl(roleId) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Acl')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    // Promise
    //   .all([
    //     setRoleOptions(form)
    //   ])
    //   .then(() => {
        showAcl(form, roleId)
      // })
  }

  function deleteAcl(roleId) {
    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Acl')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    // Promise
    //   .all([
    //     setRoleOptions(form)
    //   ])
      // .then(() => {
        showAcl(form, roleId)
      // })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}acl/field_length`,
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

  // const setRoleOptions = function(relatedForm) {
  //   return new Promise((resolve, reject) => {
  //     relatedForm.find('[name=role_id]').empty()
  //     relatedForm.find('[name=role_id]').append(
  //       new Option('-- PILIH ROLE --', '', false, true)
  //     ).trigger('change')

  //     $.ajax({
  //       url: `${apiUrl}role`,
  //       method: 'GET',
  //       dataType: 'JSON',
  //       headers: {
  //         Authorization: `Bearer ${accessToken}`
  //       },
  //       data: {
  //         limit: 0
  //       },
  //       success: response => {
  //         response.data.forEach(role => {
  //           let option = new Option(role.rolename, role.id)

  //           relatedForm.find('[name=role_id]').append(option).trigger('change')
  //         });

  //         resolve()
  //       }
  //     })
  //   })
  // }

  function showAcl(form, roleId) {
    $.ajax({
      url: `${apiUrl}acl/${roleId}`,
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
        $(`#crudForm [name="role_id"]`).first().trigger('change')

        
        if (form.data('action') === 'delete') {
          form.find('[name]').addClass('disabled')
          initDisabled()
        }
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

  function getAccessList(roleId) {
    $('#accessList tbody').html('')

    $.ajax({
      url: `${apiUrl}acl/detaillist`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        role_id: roleId
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
        let form = $('#crudForm')
        if (form.data('action') === 'delete') {
          form.find('[name]').addClass('disabled')
          initDisabled()
        }
      }
    })
  }
</script>
@endpush()