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

            {{-- <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">ID</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="id" class="form-control" readonly>
              </div>
            </div> --}}
            <input type="text" name="id" class="form-control" hidden>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  NAMA MENU <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="menuname" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  PENGURUTAN
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="menuseq" class="form-control numbernoseparate">
              </div>
            </div>
            <div class="row form-group sometimes">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  MENU PARENT
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <select name="menuparent" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH MENU PARENT --</option>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  ICON
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="menuicon" class="form-control">
              </div>
            </div>
            <div class="row form-group sometimes_link">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  LINK
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="menuexe" class="form-control sometimes_link">
              </div>
            </div>
            <div class="row form-group sometimes">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  CONTROLLER <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <select name="controller" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH CONTROLLER --</option>
                </select>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-start">
            <button id="btnSubmit" class="btn btn-primary">
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
  let hasFormBindKeys = false
  let modalBody = $('#crudModal').find('.modal-body').html()
  $(document).ready(function() {
    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let menuId = form.find('[name=id]').val()
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
          url = `${apiUrl}menu`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}menu/${menuId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}menu/${menuId}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}menu`
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

          $('#jqGrid').jqGrid('setGridParam', {
            page: response.data.page
          }).trigger('reloadGrid');

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

    let selectElements = form.find('select')
    initSelect2(selectElements)
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    $('#crudModal').find('.modal-body').html(modalBody)
  })

  function createMenu() {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)

    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Add Menu')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setMenuParentOptions(form),
        setControllerOptions(form)
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

  function editMenu(menuId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)

    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Edit Menu')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setMenuParentOptions(form),
        // setControllerOptions(form)
      ])
      .then(() => {
        showMenu(form, menuId)
          .then(() => {
            form.find('select').prop('disabled', true);
            form.find('.select2-container').addClass('disabled');
            form.find('input[name="menuexe"]').prop('disabled', true);
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

  function deleteMenu(menuId) {
    let form = $('#crudForm');

    $('.modal-loader').removeClass('d-none');

    form.data('action', 'delete');
    form.trigger('reset');
    form.find('#btnSubmit').html(`
    <i class="fa fa-trash"></i>
    Delete
  `);
    form.find('.sometimes').show();
    $('#crudModalTitle').text('Delete Menu');
    $('.is-invalid').removeClass('is-invalid');
    $('.invalid-feedback').remove();

    Promise.all([
        setMenuParentOptions(form),
        // setControllerOptions(form)
      ])
      .then(() => {
        showMenu(form, menuId)
          .then(() => {
            form.find('select').prop('disabled', true);
            form.find('.select2-container').addClass('disabled');
            form.find('.form-control.sometimes_link').addClass('disabled');
            form.find('input[name="menuexe"]').prop('disabled', true);
            $('#crudModal').modal('show');
          })
          .catch((error) => {
            showDialog(error.statusText);
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none');
          });
      });
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}menu/field_length`,
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

  const setMenuParentOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=menuparent]').empty()
      relatedForm.find('[name=menuparent]').append(
        new Option('-- PILIH MENU PARENT --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}menu/combomenuparent`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          response.data.forEach(menuparent => {
            let option = new Option(menuparent.menuparent, menuparent.id)

            relatedForm.find('[name=menuparent]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  const setControllerOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=controller]').empty()
      relatedForm.find('[name=controller]').append(
        new Option('-- PILIH CONTROLLER --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}menu/controller`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          response.data.forEach(controller => {
            let option = new Option(controller.class, controller.class)

            relatedForm.find('[name=controller]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function showMenu(form, menuId) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}menu/${menuId}`,
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
</script>
@endpush()