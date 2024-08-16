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
            <!--{{-- <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">ID</label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="id" class="form-control" readonly>
              </div>
            </div> --}}
            <input type="text" name="id" class="form-control" hidden> -->
            <input type="text" name="id" class="form-control" hidden>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  sub kelompok <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="kodesubkelompok" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  Keterangan
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="keterangan" class="form-control">
              </div>
            </div>
            <div class="form-group row">
              <label class="col-sm-3 col-md-2 col-form-label">KELOMPOK<span class="text-danger">*</span></label>
              <div class="col-sm-9 col-md-10">
                <input type="hidden" name="kelompok_id">
                <input type="text" name="kelompok" id="kelompok" class="form-control kelompok-lookup">
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
      let subKelompokId = form.find('[name=id]').val()
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
          url = `${apiUrl}subkelompok`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}subkelompok/${subKelompokId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}subkelompok/${subKelompokId}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}subkelompok`
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

          // $('#jqGrid').trigger('reloadGrid', {
          //   page: response.data.page
          // })

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
    data_id = $('#crudForm').find('[name=id]').val();
    form.find('#btnSubmit').prop('disabled', false)
    if (form.data('action') == "view") {
      form.find('#btnSubmit').prop('disabled', true)
    }

    initLookup()
    initSelect2(form.find('.select2bs4'), true)
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
        table: 'subkelompok'
        
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

  function createSubKelompok() {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Add Sub Kelompok')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
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

  function editSubKelompok(subKelompokId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Sub Kelompok')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([

        setStatusAktifOptions(form),
        getMaxLength(form)

      ])
      .then(() => {
        showSubKelompok(form, subKelompokId)
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

  function deleteSubKelompok(subKelompokId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-trash"></i>
    Delete
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Sub Kelompok')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([

        setStatusAktifOptions(form),
        getMaxLength(form)

      ])
      .then(() => {
        showSubKelompok(form, subKelompokId)
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

  function viewSubKelompok(subKelompokId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'view')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('View Sub Kelompok')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([

        setStatusAktifOptions(form),
        getMaxLength(form)

      ])
      .then(() => {
        showSubKelompok(form, subKelompokId)
          .then(subKelompokId => {
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
        url: `${apiUrl}subkelompok/field_length`,
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

            
          }
        })
        resolve()
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

  function showDefault(form) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}subkelompok/default`,
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

  function showSubKelompok(form, subKelompokId) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}subkelompok/${subKelompokId}`,
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


            if (index == 'kelompok') {
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

  function initLookup() {
    $(`.status-lookup`).lookupMaster({
      title: 'Status Aktif Lookup',
      fileName: 'parameterMaster',
      typeSearch: 'ALL',
      searching: 1,
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
    $('.kelompok-lookup').lookupMaster({
      title: 'Kelompok Lookup',
      fileName: 'kelompokMaster',
      typeSearch: 'ALL',
      searching: 1,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          searching: 1,
          valueName: 'kelompok_id',
          searchText: 'kelompok-lookup',
          title: 'Kelompok',
          typeSearch: 'ALL',
        }
      },
      onSelectRow: (kelompok, element) => {
        $('#crudForm [name=kelompok_id]').first().val(kelompok.id)
        element.val(kelompok.keterangan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=kelompok_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
  }

  function cekValidasidelete(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}subkelompok/${Id}/cekValidasi`,
      method: 'POST',
      dataType: 'JSON',
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      data: {
        aksi: Aksi
      },
      success: response => {
        var kondisi = response.kondisi
        if (kondisi == true) {
          showDialog(response.message['keterangan'])
        } else {
          if (Aksi == 'EDIT') {
            editSubKelompok(Id)
          }
          if (Aksi == 'DELETE') {
            deleteSubKelompok(Id)
          }
        }

      }
    })
  }
</script>
@endpush()