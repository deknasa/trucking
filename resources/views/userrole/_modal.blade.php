<div class="modal modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="crudForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="crudModalLabel"></h5>
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
                <div class="col-8 col-md-10">
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
                <div class="col-12 col-md-10">
                  <select name="role_ids[]" id="multiple" class="select2bs4 form-control" multiple="multiple"></select>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="mr-auto">
            <button type="button" id="btnSubmit" class="btn btn-primary">SIMPAN</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">BATAL</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

@push('scripts')
<script>
  let hasFormBindKeys = false
  let modalBody = $('#crudModal').find('.modal-body').html()

  $('#crudModal').on('shown.bs.modal', function() {
    $('#multiple')
      .select2({
        theme: 'bootstrap4'
      })
  })

  $(document).ready(function() {
    $(document).on('click', '#btnSubmit', function(event) {
      event.preventDefault()

      updateUserRole()
    })
  })

  function editUserRole(user) {
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.data('action', 'edit')
    $('#crudModalTitle').text('Edit User Role')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    $('#table_body').html('')

    form.find('[name=user_id]').val(user.id)
    form.find('[name=user]').val(user.user)

    setRoleOptions(form)

    $.ajax({
      url: `${apiUrl}user/${user.id}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: (response) => {
        let roleIds = []

        response.data.roles.forEach((role) => {
          roleIds.push(role.id)
        });

        form.find(`[name="role_ids[]"]`).val(roleIds).change()
      },
      error: (error) => {
        showDialog(error.responseJSON.message)
      }
    })
  }

  function updateUserRole() {
    let form = $('#crudForm')

    $.ajax({
      url: `${apiUrl}userrole`,
      method: 'POST',
      dataType: 'JSON',
      data: form.serializeArray(),
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        $('#crudForm').trigger('reset')
        $('#crudModal').modal('hide')

        id = response.data.id

        $('#jqGrid').jqGrid('setGridParam', {
          page: response.data.page
        }).trigger('reloadGrid');
      },
      error: error => {
        if (error.status === 422) {
          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()

          setErrorMessages(form, error.responseJSON.errors);
        }
      }
    }).always(() => {
      $('#processingLoader').addClass('d-none')
      $(this).removeAttr('disabled')
    })
  }


  const setRoleOptions = function(relatedForm) {
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