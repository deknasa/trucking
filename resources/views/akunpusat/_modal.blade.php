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
                <input type="hidden" name="akuntansi_id">
                <input type="text" name="type" data-target-name="type" id="type" class="form-control lg-form type-lookup">
              </div>
            </div>
            <div class="row form-group">
              <label class="col-12 col-md-2 col-form-label">STATUS PARENT<span class="text-danger">*</span></label>
              <div class="col-12 col-md-10">
                <input type="hidden" name="statusparent">
                <input type="text" name="statusparentnama" data-target-name="statusparent" id="statusparentnama" class="form-control lg-form statusparent-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  kode perkiraan parent
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="parent">
                <input type="text" name="parentnama" data-target-name="parentnama" id="parentnama" class="form-control lg-form  parent-lookup">
              </div>
            </div>
            <div class="row form-group">
              <label class="col-12 col-md-2 col-form-label">STATUS NERACA<span class="text-danger">*</span></label>
              <div class="col-12 col-md-10">
                <input type="hidden" name="statusneraca">
                <input type="text" name="statusneracanama" data-target-name="statusneraca" id="statusneracanama" class="form-control lg-form statusneraca-lookup">
              </div>
            </div>
            <div class="row form-group">
              <label class="col-12 col-md-2 col-form-label">STATUS LABA RUGI<span class="text-danger">*</span></label>
              <div class="col-12 col-md-10">
                <input type="hidden" name="statuslabarugi">
                <input type="text" name="statuslabaruginama" data-target-name="statuslabarugi" id="statuslabaruginama" class="form-control lg-form statuslabarugi-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  kode perkiraan pusat <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="coamain">
                <input type="text" name="coamainket" data-target-name="coamainket" id="coamainket" class="form-control lg-form  coamain-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  STATUS AKTIF <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="statusaktif">
                <input type="text" name="statusaktifnama" data-target-name="statusaktif" id="statusaktifnama" class="form-control lg-form status-lookup">
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

  let dataMaxLength = []
  var data_id 
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
        name: 'accessTokenTnl',
        value: accessTokenTnl
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
          url = `${apiUrl}akunpusat`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}akunpusat/${akunPusatId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}akunpusat/${akunPusatId}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}akunpusat`
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
    let par = $(`#crudForm [name="statusparent"] option:selected`).text()
    console.log(par)
    if (par == 'PARENT') {
      setTimeout(() => {
        $('#crudForm [name=parentnama]').attr('readonly', true)
        $('#crudForm [name=parent]').val('')
        $('#crudForm [name=parentnama]').val('')
        $('#crudForm [name=parentnama]').parents('.input-group').find('.input-group-append').hide()
        $('#crudForm [name=parentnama]').parents('.input-group').find('.button-clear').hide()

      }, 500);
    } else if (par == 'BUKAN PARENT') {
      $('#crudForm [name=parentnama]').attr('readonly', false)
      $('#crudForm [name=parentnama]').parents('.input-group').find('.input-group-append').show()
      $('#crudForm [name=parentnama]').parents('.input-group').find('.button-clear').show()
    }
  });

  function activateParent(par) {
    if (par == 'BUKAN PARENT') {
      $('#crudForm [name=parentnama]').attr('readonly', false)
      $('#crudForm [name=parentnama]').parents('.input-group').find('.input-group-append').show()
      $('#crudForm [name=parentnama]').parents('.input-group').find('.button-clear').show()
    } else {
      setTimeout(() => {

        $('#crudForm [name=parentnama]').attr('readonly', true)
        $('#crudForm [name=parentnama]').parents('.input-group').find('.input-group-append').hide()
        $('#crudForm [name=parentnama]').parents('.input-group').find('.button-clear').hide()
      }, 500);
    }
  }

  $('#crudModal').on('shown.bs.modal', () => {
    let form = $('#crudForm')
    data_id = $('#crudForm').find('[name=id]').val();

    setFormBindKeys(form)

    activeGrid = null

    form.find('#btnSubmit').prop('disabled', false)
    if (form.data('action') == "view") {
      form.find('#btnSubmit').prop('disabled', true)
    }

    initSelect2(form.find('.select2bs4'), true)
    initLookup()
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    removeEditingBy(data_id)    

    $('#crudModal').find('.modal-body').html(modalBody)
  })

  function removeEditingBy(id) {
    $.ajax({
      url: `{{ config('app.api_url') }}bataledit`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        id: id,
        aksi: 'BATAL',
        table: 'akunpusat'

      },
      success: response => {
        $("#crudModal").modal("hide")
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
    })
  }

  function createAkunPusat() {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
    `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create Kode Perkiraan Cabang')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusParent(form),
        setStatusLabaRugiOptions(form),
        setStatusNeracaOptions(form),
        setStatusAktifOptions(form),
        getMaxLength(form)
      ])
      .then(() => {
        showDefault(form)
          .then(() => {
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
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
        url: `${apiUrl}akunpusat/default`,
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

            if (index == 'type') {
              element.data('current-value', value)
            }
            if (index == 'akuntansi') {
              element.data('current-value', value)
            }
            if (index == 'parentnama') {
              element.data('current-value', value)
            }
            if (index == 'statusparentnama') {
              activateParent(value);

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

  function editAkunPusat(akunPusatId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Kode Perkiraan Cabang')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusParent(form),
        setStatusLabaRugiOptions(form),
        setStatusNeracaOptions(form),
        setStatusAktifOptions(form),
        getMaxLength(form)

      ])
      .then(() => {
        showAkunPusat(form, akunPusatId)
          .then(() => {
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
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

  function deleteAkunPusat(akunPusatId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-trash"></i>
    Delete
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Kode Perkiraan Cabang')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusParent(form),
        setStatusLabaRugiOptions(form),
        setStatusNeracaOptions(form),
        setStatusAktifOptions(form),
        getMaxLength(form)

      ])
      .then(() => {
        showAkunPusat(form, akunPusatId)
          .then(() => {
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
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

  function viewAkunPusat(akunPusatId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'view')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.find('#btnSubmit').prop('disabled', true)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('View Kode Perkiraan Cabang')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusParent(form),
        setStatusLabaRugiOptions(form),
        setStatusNeracaOptions(form),
        setStatusAktifOptions(form),
        getMaxLength(form)

      ])
      .then(() => {
        showAkunPusat(form, akunPusatId)
          .then(akunPusatId => {
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
            form.find('[name=id]').prop('disabled', false)

          })
          .then(() => {
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
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
      return new Promise((resolve, reject) => {

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

          dataMaxLength = response.data
            form.attr('has-maxlength', true)
            resolve()
        },
        error: error => {
          showDialog(error.statusText)
          reject()
        }
      })
    })
    } else {
      return new Promise((resolve, reject) => {
        $.each(dataMaxLength, (index, value) => {
          if (value !== null && value !== 0 && value !== undefined) {
            form.find(`[name=${index}]`).attr('maxlength', value)

            if (value !== null && value !== 0 && value !== undefined) {
              form.find(`[name=coa]`).attr('maxlength', 15)
            }
          }
        })
        resolve()
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

  const setStatusParent = function(relatedForm) {
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

  function showAkunPusat(form, akunPusatId) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}akunpusat/${akunPusatId}`,
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
            if (index == 'parentnama') {
              element.data('current-value', value)
            }
            if (index == 'coamainket') {
              element.data('current-value', value)
            }
            if (index == 'statusparentnama') {
              activateParent(value);

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
      url: `{{ config('app.api_url') }}akunpusat/${Id}/cekValidasi`,
      method: 'GET',
      dataType: 'JSON',
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      data:{
        aksi: aksi,
      },
      success: response => {
        // var kondisi = response.kondisi
        // if (kondisi == true) {
        //   showDialog(response.message['keterangan'])
        // } else {
        //   if (aksi == 'edit') {
        //     editAkunPusat(Id)
        //   } else {
        //     deleteAkunPusat(Id)
        //   }
        // }
        var error = response.error
        if (error == true) {
          showDialog(response.message)
        } else {
          if (aksi=="edit") {
            editAkunPusat(Id)
          }else if (aksi=="delete"){
            deleteAkunPusat(Id)
          }
        }
      }
    })
  }

  function initLookup() {
    $('.type-lookup').lookupV3({
      title: 'Type Akuntansi Lookup',
      fileName: 'typeakuntansiV3',
      searching: ['kodetype','akuntansi'],
      labelColumn: false,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (type, element) => {
        $('#crudForm [name=type_id]').val(type.id)
        $('#crudForm [name=akuntansi_id]').val(type.akuntansi_id)
        element.val(type.kodetype)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=type_id]').val('')
        $('#crudForm [name=akuntansi_id]').val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.akuntansi-lookup').lookupV3({
      title: 'akuntansi Lookup',
      fileName: 'akuntansiV3',
      searching: ['kodeakuntansi','keterangan'],
      labelColumn: false,
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

    $('.parent-lookup').lookupV3({
      title: 'Akun Pusat Lookup',
      fileName: 'akunpusatV3',
      searching: ['coa','keterangancoa'],
      labelColumn: false,
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (akunpusat, element) => {
        $('#crudForm [name=parent]').val(akunpusat.coa)
        element.val(akunpusat.keterangancoa)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=parent]').val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.coamain-lookup').lookupV3({
      title: 'Main Akun Pusat Lookup',
      fileName: 'mainakunpusatV3',
      searching: ['coa','keterangancoa'],
      labelColumn: false,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (akunpusat, element) => {
        $('#crudForm [name=coamain]').val(akunpusat.coa)
        element.val(akunpusat.kodeket)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=coamain]').val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $(`.status-lookup`).lookupV3({
      title: 'Status Aktif Lookup',
      fileName: 'parameterV3',
      searching: ['text'],
      labelColumn: false,
      beforeProcess: function() {
        this.postData = {
          url: `${apiUrl}parameter/combo`,
          grp: 'STATUS AKTIF',
          subgrp: 'STATUS AKTIF',
          searching: 1,
          valueName: `statusaktif`,
          searchText: `status-lookup`,
          singleColumn: true,
          hideLabel: true,
          title: 'Status Aktif'
        };
      },
      onSelectRow: (status, element) => {
        let elId = element.data('targetName')
        $(`#crudForm [name=${elId}]`).first().val(status.id)
        element.val(status.text)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'));
      },
      onClear: (element) => {
        let elId = element.data('targetName')
        $(`#crudForm [name=${elId}]`).first().val('')
        element.val('')
        element.data('currentValue', element.val())
      },
    });
    $(`.statusparent-lookup`).lookupV3({
      title: 'status parent Lookup',
      fileName: 'parameterV3',
      searching: ['text'],
      labelColumn: false,
      beforeProcess: function() {
        this.postData = {
          url: `${apiUrl}parameter/combo`,
          grp: 'STATUS PARENT',
          // subgrp: 'STATUS PARENT',
        };
      },
      onSelectRow: (status, element) => {
        let elId = element.data('targetName')
        $(`#crudForm [name=${elId}]`).first().val(status.id)
        element.val(status.text)
        element.data('currentValue', element.val())
        activateParent(status.text)
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'));
      },
      onClear: (element) => {
        let elId = element.data('targetName')
        $(`#crudForm [name=${elId}]`).first().val('')
        element.val('')
        element.data('currentValue', element.val())
        activateParent('')
      },
    });
    $(`.statusneraca-lookup`).lookupV3({
      title: 'status neraca Lookup',
      fileName: 'parameterV3',
      searching: ['text'],
      labelColumn: false,
      beforeProcess: function() {
        this.postData = {
          url: `${apiUrl}parameter/combo`,
          grp: 'STATUS NERACA',
        };
      },
      onSelectRow: (status, element) => {
        let elId = element.data('targetName')
        $(`#crudForm [name=${elId}]`).first().val(status.id)
        element.val(status.text)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'));
      },
      onClear: (element) => {
        let elId = element.data('targetName')
        $(`#crudForm [name=${elId}]`).first().val('')
        element.val('')
        element.data('currentValue', element.val())
      },
    });
    $(`.statuslabarugi-lookup`).lookupV3({
      title: 'Status status labarugi Lookup',
      fileName: 'parameterV3',
      searching: ['text'],
      labelColumn: false,
      beforeProcess: function() {
        this.postData = {
          url: `${apiUrl}parameter/combo`,
          grp: 'STATUS LABA RUGI',
        };
      },
      onSelectRow: (status, element) => {
        let elId = element.data('targetName')
        $(`#crudForm [name=${elId}]`).first().val(status.id)
        element.val(status.text)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'));
      },
      onClear: (element) => {
        let elId = element.data('targetName')
        $(`#crudForm [name=${elId}]`).first().val('')
        element.val('')
        element.data('currentValue', element.val())
      },
    });
  }
</script>
@endpush()