<div class="modal modal-fullscreen" id="userAclModal" tabindex="-1" aria-labelledby="userAclModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="userAclForm">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title" id="userAclLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card">
            <div class="card-body">
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-2 col-form-label">
                  <label>
                    User <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-10">
                  <input type="hidden" name="user_id">
                  <input type="text" name="user" class="form-control" disabled>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-12">
                  <table class="table table-condensed" id="acoList">
                    <thead>
                      <tr>
                        <th width="10px">#</th>
                        <th width="10px">CHECK</th>
                        <th>CLASS</th>
                        <th>METHOD</th>
                      </tr>
                    </thead>
                    <tbody>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="mr-auto">
            <button type="button" id="btnSubmitUserAcl" class="btn btn-primary">SIMPAN</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">BATAL</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  hasFormBindKeys = false

  $(document).ready(function() {
    $('#btnSubmitUserAcl').click(function(event) {
      event.preventDefault()

      let userId = $('#userAclForm').find(`[name=user_id]`).val()

      updateUserAcl(userId)
    })
  })

  function updateUserAcl(userId) {
    let form = $('#userAclForm')

    $.ajax({
      url: `${apiUrl}user/${userId}/acl`,
      method: 'POST',
      dataType: 'JSON',
      data: form.serializeArray(),
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        $('#userAclForm').trigger('reset')
        $('#userAclModal').modal('hide')

        $('#userAclGrid').jqGrid('setGridParam').trigger('reloadGrid');
      },
      error: error => {
        if (error.status === 422) {
          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()

          setErrorMessages(form, error.responseJSON.errors);
        }
      }
    }).always(() => {
      $('#loader').addClass('d-none')
      $(this).removeAttr('disabled')
    })
  }

  $('#userAclModal').on('shown.bs.modal', () => {
    let form = $('#userAclForm')

    setFormBindKeys(form)

    activeGrid = null
  })

  $('#userAclModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
  })

  function editUserAcl(userId) {
    let form = $('#userAclForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmitUserAcl').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#userAclModalTitle').text('Edit User Role')
    $('#userAclModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    getUserAclOptions()

    $('#userAclForm').find(`[name=user_id]`).val(userId)

    setTimeout(() => {
      showUserAcls(form, userId)
    }, 1000);
  }

  function showUserAcls(form, userId) {
    $.ajax({
      url: `${apiUrl}user/${userId}/acl`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        response.data.forEach(acl => {
          $(`[name="aco_ids[]"][value=${acl.id}]`).attr('checked', 'checked')
        });
      },
      error: (error) => {
        showDialog(error.responseJSON.message)
      }
    })
  }

  function setAclOptions(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name="aco_ids[]"]').empty()

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

            relatedForm.find(`[name="aco_ids[]"]`).append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  function getUserAclOptions() {
    $('#acoList tbody').html('')

    $.ajax({
      url: `${apiUrl}acos`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: (response) => {
        response.data.forEach((aco, index) => {
          $('#acoList tbody').append(`
            <tr>
              <td>${index + 1}</td>
              <td class="text-center"><input class="form-check-input" type="checkbox" name="aco_ids[]" value="${aco.id}"></td>
              <td>${aco.class}</td>
              <td>${aco.method}</td>
            </tr>
          `)
        })
      },
      error: (error) => {
        console.log(error);
      }
    })
  }
</script>