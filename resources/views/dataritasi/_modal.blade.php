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

            <div class="row form-group">
              <div class="col-12 col-md-2" style="display:none">
                <label class="col-form-label">ID</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="id" class="form-control" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  STATUS RITASI <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="statusritasi" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH STATUS RITASI --</option>
                </select>
              </div>
            </div>
            {{-- <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  Keterangan
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="keterangan" class="form-control">
              </div>
            </div> --}}
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  NOMINAL <span class="text-danger"></span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="nominal" class="form-control text-right">
              </div>
            </div>
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
      let dataRitasiId = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()
      $('#crudForm').find(`[name="nominal"]`).each((index, element) => {
        data.filter((row) => row.name === 'nominal')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominal"]`)[index])
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
          url = `${apiUrl}dataritasi`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}dataritasi/${dataRitasiId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}dataritasi/${dataRitasiId}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}dataritasi`
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


  function createDataRitasi() {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
    `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create Data Ritasi')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    initAutoNumeric(form.find(`[name="nominal"]`), {
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
  }

  function editDataRitasi(id) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Data Ritasi')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    // initAutoNumeric(form.find(`[name="nominal"]`), {
    //   minimumValue:0
    // })

    Promise
      .all([
        setStatusAktifOptions(form),
        setStatusRitasiOptions(form)
      ])
      .then(() => {
        showDataRitasi(form, id)
        .then(() => {
            $('#crudModal').modal('show')
            form.find(`[name="nominal"]`).parent('.input-group').find('.button-clear').remove()
            form.find(`[name="nominal"]`).parent('.input-group').find('.input-group-append').remove()

          })
          .catch((error) => {
            showDialog(error.statusText)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  function deleteDataRitasi(id) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Data Ritasi')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusAktifOptions(form),
        setStatusRitasiOptions(form)
      ])
      .then(() => {
        showDataRitasi(form, id)
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

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}dataritasi/field_length`,
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


  function showDataRitasi(form, id) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}dataritasi/${id}`,
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

          initAutoNumeric(form.find(`[name="nominal"]`),{
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
        url: `${apiUrl}container/default`,
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
</script>
@endpush()