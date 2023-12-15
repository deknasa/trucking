<div class="modal modal-fullscreen" id="userRoleModal" tabindex="-1" aria-labelledby="userRoleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="userRoleForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="userRoleLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">

          </button>
        </div>
        <div class="modal-body">
          <div class="card">
            <div class="card-body">
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-2">
                  <label class="col-form-label">
                    User <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-10">
                  <input type="hidden" name="user_id">
                  <input type="text" name="user" class="form-control" disabled>
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-2">
                  <label class="col-form-label">
                    Role <span class="text-danger"></span>
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-10">
                  <select name="role_ids[]" id="multiple" class="select2bs4 form-control" multiple="multiple"></select>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="mr-auto">
            <button type="button" id="btnSubmitUserRole" class="btn btn-primary"> Save</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal"> <i class="fa fa-times"></i>Cancel</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
  hasFormBindKeys = false

  $(document).ready(function() {
    $(document).on('click', '#btnSubmitUserRole', function(event) {
      event.preventDefault()

      let userId = $('#userRoleForm').find(`[name=user_id]`).val()

      updateUserRole(userId)
    })
  })

  $(document).on('shown.bs.modal', '#userRoleModal', () => {
    let form = $('#userRoleForm')

    setFormBindKeys(form)

    activeGrid = null

    $('#multiple')
      .select2({
        theme: 'bootstrap4',
        width: '100%',
      })
  })

  $(document).on('hidden.bs.modal', '#userRoleModal', () => {
    activeGrid = '#jqGrid'
  })

  function updateUserRole(userId) {
    let form = $('#userRoleForm')

    $.ajax({
      url: `${apiUrl}user/${userId}/role`,
      method: 'POST',
      dataType: 'JSON',
      data: form.serializeArray(),
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        $('#userRoleForm').trigger('reset')
        $('#userRoleModal').modal('hide')

        $('#userRoleGrid').jqGrid('setGridParam').trigger('reloadGrid');
      },
      error: error => {
        if (error.status === 422) {
          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()

          setErrorMessages(form, error.responseJSON.errors);
        } else {
          showDialog(error.responseJSON)
        }
      }
    }).always(() => {
      $('#processingLoader').addClass('d-none')
      $(this).removeAttr('disabled')
    })
  }

  function editUserRole(userId) {
    let form = $('#userRoleForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmitUserRole').html(`
      <i class="fa fa-save"></i>
      Save
    `)

    form.find(`.sometimes`).hide()
    $('#userRoleModalTitle').text('Edit User Role')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setRoleOptions(form)
      ])
      .then(() => {
        showUserRoles(form, userId)
          .then(() => {
            $('#userRoleModal').modal('show')
          })
          .catch((error) => {
            showDialog(error.statusText)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  function showUserRoles(form, userId) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}user/${userId}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          let roleIds = []


          response.data.roles.forEach((role) => {
            roleIds.push(role.id)
          });

          form.find(`[name="role_ids[]"]`).val(roleIds).change()
          form.find(`[name="user_id"]`).val(response.data.id)
          form.find(`[name="user"]`).val(response.data.user)

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function setRoleOptions(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name="role_ids[]"]').empty()

      $.ajax({
        url: `${apiUrl}role`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          limit: 0,
        },
        success: response => {
          response.data.forEach(role => {
            let option = new Option(role.rolename, role.id)

            relatedForm.find(`[name="role_ids[]"]`).append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }
</script>
@endpush()