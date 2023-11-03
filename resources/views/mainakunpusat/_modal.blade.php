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
                  KODE PERKIRAAN <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="coa" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  NAMA PERKIRAAN <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="keterangancoa" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  type <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="type_id">
                <input type="text" name="type" class="form-control type-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  akuntansi <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="akuntansi_id">
                <input type="text" name="akuntansi" class="form-control akuntansi-lookup">
              </div>
            </div>
            <div class="row form-group">
              <label class="col-12 col-md-2 col-form-label">STATUS PARENT<span class="text-danger">*</span></label>
              <div class="col-12 col-md-10">
                <select name="statusparent" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH STATUS PARENT --</option>
                </select>
              </div>
            </div>
            <div class="row form-group parent">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  kode perkiraan parent
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="parent" class="form-control parent-lookup">
              </div>
            </div>
            <div class="row form-group">
              <label class="col-12 col-md-2 col-form-label">status kode perkiraan<span class="text-danger">*</span></label>
              <div class="col-12 col-md-10">
                <select name="statuscoa" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH status kode perkiraan --</option>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <label class="col-12 col-md-2 col-form-label">STATUS NERACA<span class="text-danger">*</span></label>
              <div class="col-12 col-md-10">
                <select name="statusneraca" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH STATUS NERACA --</option>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <label class="col-12 col-md-2 col-form-label">STATUS LABA RUGI<span class="text-danger">*</span></label>
              <div class="col-12 col-md-10">
                <select name="statuslabarugi" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH STATUS LABA RUGI --</option>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  STATUS AKTIF <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <select name="statusaktif" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH STATUS AKTIF --</option>
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
      let akunPusatId = form.find('[name=id]').val()
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
          url = `${apiUrl}mainakunpusat`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}mainakunpusat/${akunPusatId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}mainakunpusat/${akunPusatId}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}mainakunpusat`
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


  $(document).on('change', $('#crudForm').find('[name=statusparent]'), function(event) {
    let par =  $(`#crudForm [name="statusparent"] option:selected`).text()
    console.log(par)
    if (par == 'PARENT') {
      setTimeout(() => {
        $('#crudForm [name=parent]').attr('readonly', true)
        $('#crudForm [name=parent]').parents('.input-group').find('.input-group-append').hide()
        $('#crudForm [name=parent]').parents('.input-group').find('.button-clear').hide()

      }, 500);
    } else if (par == 'BUKAN PARENT') {
      $('#crudForm [name=parent]').attr('readonly', false)
      $('#crudForm [name=parent]').parents('.input-group').find('.input-group-append').show()
      $('#crudForm [name=parent]').parents('.input-group').find('.button-clear').show()
    }
  });
  $('#crudModal').on('shown.bs.modal', () => {
    let form = $('#crudForm')

    setFormBindKeys(form)

    activeGrid = null

    form.find('#btnSubmit').prop('disabled', false)
    if (form.data('action') == "view") {
      form.find('#btnSubmit').prop('disabled', true)
    }

    getMaxLength(form)
    initSelect2(form.find('.select2bs4'), true)
    initLookup()
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    $('#crudModal').find('.modal-body').html(modalBody)
  })

  function createMainAkunPusat() {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create Main Akun Pusat')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusCoaOptions(form),
        setStatusParentOptions(form),
        setStatusLabaRugiOptions(form),
        setStatusNeracaOptions(form),
        setStatusAktifOptions(form),
      ])
      .then(() => {
        showDefault(form)
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

  function showDefault(form) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}mainakunpusat/default`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $.each(response.data, (index, value) => {
            console.log(value)
            let element = form.find(`[name="${index}"]`)
            // let element = form.find(`[name="statusaktif"]`)

            if (element.is('select')) {
              element.val(value).trigger('change')
            } else {
              element.val(value)
            }
          })
          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function editMainAkunPusat(akunPusatId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Akun Pusat')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    Promise
      .all([
        setStatusCoaOptions(form),
        setStatusParentOptions(form),
        setStatusLabaRugiOptions(form),
        setStatusNeracaOptions(form),
        setStatusAktifOptions(form),
      ])
      .then(() => {
        showMainAkunPusat(form, akunPusatId)
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

  function deleteMainAkunPusat(akunPusatId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Akun Pusat')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusCoaOptions(form),
        setStatusParentOptions(form),
        setStatusLabaRugiOptions(form),
        setStatusNeracaOptions(form),
        setStatusAktifOptions(form),
      ])
      .then(() => {
        showMainAkunPusat(form, akunPusatId)
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

  function viewMainAkunPusat(akunPusatId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'view')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('View Akun Pusat')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusCoaOptions(form),
        setStatusParentOptions(form),
        setStatusLabaRugiOptions(form),
        setStatusNeracaOptions(form),
        setStatusAktifOptions(form),
      ])
      .then(() => {
        showMainAkunPusat(form, akunPusatId)
          .then(akunPusatId => {
            // form.find('.aksi').hide()
            setFormBindKeys(form)
            form.find('[name]').attr('disabled', 'disabled').css({
              background: '#fff'
            })
            form.find('[name=id]').prop('disabled', false)

          })
          .then(() => {
            $('#crudModal').modal('show')
            let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
            name.attr('disabled', true)
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
        url: `${apiUrl}akunpusat/field_length`,
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
            if (value !== null && value !== 0 && value !== undefined) {
              form.find(`[name=coa]`).attr('maxlength', 15)
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

  const setStatusCoaOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statuscoa]').empty()
      relatedForm.find('[name=statuscoa]').append(
        new Option('-- PILIH status kode perkiraan --', '', false, true)
      ).trigger('change')

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
              "data": "STATUS COA"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusCoa => {
            let option = new Option(statusCoa.text, statusCoa.id)

            relatedForm.find('[name=statuscoa]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  const setStatusParentOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusparent]').empty()
      relatedForm.find('[name=statusparent]').append(
        new Option('-- PILIH STATUS PARENT --', '', false, true)
      ).trigger('change')

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
              "data": "STATUS PARENT"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusParent => {
            let option = new Option(statusParent.text, statusParent.id)

            relatedForm.find('[name=statusparent]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  const setStatusNeracaOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusneraca]').empty()
      relatedForm.find('[name=statusneraca]').append(
        new Option('-- PILIH STATUS NERACA --', '', false, true)
      ).trigger('change')

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
              "data": "STATUS NERACA"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusNeraca => {
            let option = new Option(statusNeraca.text, statusNeraca.id)

            relatedForm.find('[name=statusneraca]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  const setStatusLabaRugiOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statuslabarugi]').empty()
      relatedForm.find('[name=statuslabarugi]').append(
        new Option('-- PILIH STATUS LABA RUGI --', '', false, true)
      ).trigger('change')

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
              "data": "STATUS LABA RUGI"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusLabaRugi => {
            let option = new Option(statusLabaRugi.text, statusLabaRugi.id)

            relatedForm.find('[name=statuslabarugi]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  const setStatusAktifOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusaktif]').empty()
      relatedForm.find('[name=statusaktif]').append(
        new Option('-- PILIH STATUS AKTIF --', '', false, true)
      ).trigger('change')

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
          response.data.forEach(statusAktif => {
            let option = new Option(statusAktif.text, statusAktif.id)

            relatedForm.find('[name=statusaktif]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function showMainAkunPusat(form, akunPusatId) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}mainakunpusat/${akunPusatId}`,
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

            if (index == 'type') {
              element.data('current-value', value)
            }
            if (index == 'akuntansi') {
              element.data('current-value', value)
            }
            if (index == 'parent') {
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

  function cekValidasi(Id, aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}mainakunpusat/${Id}/cekValidasi`,
      method: 'GET',
      dataType: 'JSON',
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      success: response => {
        var kondisi = response.kondisi
        if (kondisi == true) {
          showDialog(response.message['keterangan'])
        } else {
          if (aksi == 'edit') {
            editMainAkunPusat(Id)
          } else {
            deleteMainAkunPusat(Id)
          }
        }

      }
    })
  }

  function initLookup() {
    $('.type-lookup').lookup({
      title: 'Type Akuntansi Lookup',
      fileName: 'typeakuntansi',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (type, element) => {
        $('#crudForm [name=type_id]').val(type.id)
        element.val(type.kodetype)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=type_id]').val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.akuntansi-lookup').lookup({
      title: 'Akuntansi Lookup',
      fileName: 'akuntansi',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (akuntansi, element) => {
        $('#crudForm [name=akuntansi_id]').val(akuntansi.id)
        element.val(akuntansi.kodeakuntansi)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=akuntansi_id]').val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.parent-lookup').lookup({
      title: 'Main Akun Pusat Lookup',
      fileName: 'mainakunpusat',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (akunpusat, element) => {
        element.val(akunpusat.coa)
        element.data('currentValue', element.val())
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
</script>
@endpush()