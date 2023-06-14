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
              <div class="col-12 col-md-2" style="display:none">
                <label class="col-form-label">ID</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="id" class="form-control" readonly>
              </div>
            </div> --}}
            <input type="hidden" name="id" class="form-control" hidden>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  kode tipe <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="kodetype" class="form-control">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  ORDER <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="order" class="form-control text-right">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  Akuntansi <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                  <input type="hidden" name="akuntansi_id">
                  <input type="text" name="akuntansi" class="form-control akuntansi-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  Keterangan
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="keterangantype" class="form-control">
              </div>
            </div>
            {{-- <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  order <span class="text-danger"></span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="order" class="form-control text-right">
              </div>
            </div> --}}
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  Status Aktif <span class="text-danger">*</span>
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
      let MainTypeAkuntansi = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()
      $('#crudForm').find(`[name="order"]`).each((index, element) => {
        data.filter((row) => row.name === 'order')[index].value = AutoNumeric.getNumber($(`#crudForm [name="order"]`)[index])
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
          url = `${apiUrl}maintypeakuntansi`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}maintypeakuntansi/${MainTypeAkuntansi}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}maintypeakuntansi/${MainTypeAkuntansi}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}maintypeakuntansi`
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
            if (error.responseJSON.errors) {
              showDialog(error.statusText, error.responseJSON.errors.join('<hr>'))
            } else if (error.responseJSON.message) {
              showDialog(error.statusText, error.responseJSON.message)
            } else {
              showDialog(error.statusText, error.statusText)
            }
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
    initSelect2(form.find('.select2bs4'), true)
    initLookup()
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    $('#crudModal').find('.modal-body').html(modalBody)
  })

  // function cekValidasidelete(Id) {
  //   $.ajax({
  //     url: `{{ config('app.api_url') }}dataritasi/${Id}/cekValidasi`,
  //     method: 'POST',
  //     dataType: 'JSON',
  //     beforeSend: request => {
  //       request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
  //     },
  //     success: response => {
  //       var kondisi = response.kondisi
  //       console.log(kondisi)
  //       if (kondisi == true) {
  //         showDialog(response.message['keterangan'])
  //       } else {
  //         deleteContainer(Id)
  //       }

  //     }
  //   })
  // }


  function createMainTypeAkuntansi() {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
    `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create Main Tipe Akuntansi')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    initAutoNumeric(form.find(`[name="order"]`), {
      minimumValue:0
    })
    
    Promise
      .all([
        setStatusAktifOptions(form),
        setStatusRitasiOptions(form)
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
      setFormBindKeys(form)
  }

  function editMainTypeAkuntansi(id) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Main Tipe Akuntansi')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    // initAutoNumeric(form.find(`[name="order"]`), {
    //   minimumValue:0
    // })

    Promise
      .all([
        setStatusAktifOptions(form),
        setStatusRitasiOptions(form)
      ])
      .then(() => {
        showMainTypeAkuntansi(form, id)
        .then(() => {
            $('#crudModal').modal('show')
            form.find(`[name="order"]`).parent('.input-group').find('.button-clear').remove()
            form.find(`[name="order"]`).parent('.input-group').find('.input-group-append').remove()

          })
          .catch((error) => {
            showDialog(error.statusText)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  function deleteMainTypeAkuntansi(id) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Main Tipe Akuntansi')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusAktifOptions(form),
        setStatusRitasiOptions(form)
      ])
      .then(() => {
        showMainTypeAkuntansi(form, id)
          .then(() => {
            $('#crudModal').modal('show')
            $('#crudForm').find(`.btn.btn-easyui.lookup-toggler`).attr('disabled', true)
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
        url: `${apiUrl}maintypeakuntansi/field_length`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          'Authorization': `Bearer ${accessToken}`
        },
        success: response => {
          $.each(response.data, (index, value) => {
            if (value !== null && value !== 0 && value !== undefined) {
              form.find(`[name=${index}]`).attr('maxlength', value)
            }if(index == 'order'){
                form.find(`[name=order]`).attr('maxlength', 50)
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

  const setStatusRitasiOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusritasi]').empty()
      relatedForm.find('[name=statusritasi]').append(
        new Option('-- PILIH STATUS RITASI --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}parameter/combo`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          limit: 0,
          grp: 'STATUS RITASI',
          subgrp: 'STATUS RITASI',
        },
        success: response => {
          response.data.forEach(statusRitasi => {
            let option = new Option(statusRitasi.text, statusRitasi.id)

            relatedForm.find('[name=statusritasi]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }


  function showMainTypeAkuntansi(form, id) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}maintypeakuntansi/${id}`,
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

          initAutoNumeric(form.find(`[name="order"]`),{
            minimumValue:0
          })

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function showDefault(form) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}maintypeakuntansi/default`,
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

  function initLookup() {
    $('.akuntansi-lookup').lookup({
      title: 'akuntansi Lookup',
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
  }
</script>
@endpush()