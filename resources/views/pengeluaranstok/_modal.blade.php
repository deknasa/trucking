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
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">ID</label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="id" class="form-control" readonly>
              </div>
            </div> --}}
            <input type="text" name="id" class="form-control" readonly hidden>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  kodepengeluaran <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="kodepengeluaran" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  keterangan
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="keterangan" class="form-control">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  KODE PERKIRAAN <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="coa">
                <input type="text" name="keterangancoa" id="keterangancoa" class="form-control akunpusat-lookup">
              </div>
            </div>


            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  status format <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="format">
                <input type="text" name="formatnama" data-target-name="format" id="formatnama" class="form-control lg-form format-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  status hitung stok <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="statushitungstok">
                <input type="text" name="statushitungstoknama" data-target-name="statushitungstok" id="statushitungstoknama" class="form-control lg-form statushitungstok-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  status Aktif <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="statusaktif">
                <input type="text" name="statusaktifnama" data-target-name="statusaktif" id="statusaktifnama" class="form-control lg-form statusaktif-lookup">
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
      let pengeluaranstokId = form.find('[name=id]').val()
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
          url = `${apiUrl}pengeluaranstok`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}pengeluaranstok/${pengeluaranstokId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}pengeluaranstok/${pengeluaranstokId}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}pengeluaranstok`
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

          $('#jqGrid').trigger('reloadGrid', {
            page: response.data.page
          })

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

    form.find('#btnSubmit').prop('disabled', false)
    if (form.data('action') == "view") {
      form.find('#btnSubmit').prop('disabled', true)
    }

    activeGrid = null
    data_id = $('#crudForm').find('[name=id]').val();
    initLookup()
    initSelect2(form.find('.select2bs4'), true);
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
        table: 'pengeluaranstok'
        
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

  function createPengeluaranStok() {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Add Pengeluaran Stok')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    Promise
      .all([
        showDefault(form),
        getMaxLength(form)
      ])
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
  }

  function editPengeluaranStok(pengeluaranstokId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Pengeluaran Stok')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        showPengeluaranStok(form, pengeluaranstokId),
        getMaxLength(form)
      ])
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
  }

  function deletePengeluaranStok(pengeluaranstokId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-trash"></i>
    Delete
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Pengeluaran Stok')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    Promise
      .all([
        showPengeluaranStok(form, pengeluaranstokId),
        getMaxLength(form)
      ])
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
  }

  function viewPengeluaranStok(pengeluaranstokId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'view')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('View Pengeluaran Stok')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    Promise
      .all([
        showPengeluaranStok(form, pengeluaranstokId),
        getMaxLength(form)
      ])
      .then(pengeluaranstokId => {
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
        form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').remove()
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

  }

  const setStatusFormatListOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=format]').empty()
      relatedForm.find('[name=format]').append(
        new Option('-- PILIH STATUS FORMAT --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}parameter`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          limit: 0,
          filters: JSON.stringify({
            "groupOp": "AND",
            "rules": [{
              "field": "grp",
              "op": "cn",
              "data": "PENGELUARAN STOK"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusFormatList => {
            let option = new Option(statusFormatList.text, statusFormatList.id)

            relatedForm.find('[name=format]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  const setStatusHitungListOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statushitungstok]').empty()
      relatedForm.find('[name=statushitungstok]').append(
        new Option('-- PILIH STATUS HITUNG --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}parameter`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          limit: 0,
          filters: JSON.stringify({
            "groupOp": "AND",
            "rules": [{
              "field": "grp",
              "op": "cn",
              "data": "STATUS HITUNG STOK"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusHitungList => {
            let option = new Option(statusHitungList.text, statusHitungList.id)

            relatedForm.find('[name=statushitungstok]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}pengeluaranstok/field_length`,
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

  function showPengeluaranStok(form, pengeluaranstokId) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}pengeluaranstok/${pengeluaranstokId}`,
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
            if (index == 'kodepengeluaran') {
              element.attr('readonly', true)
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
    $('.akunpusat-lookup').lookupMaster({
      title: 'akun pusat Lookup',
      fileName: 'akunpusatMaster',
      typeSearch: 'ALL',
      searching: 1,
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {
          levelCoa: '3',
          Aktif: 'AKTIF',
          searching: 1,
          typeSearch: 'ALL',
          valueName: `keterangancoa`,
          searchText: `akunpusat-lookup`,
          title: 'COA'
        }
      },
      onSelectRow: (akunpusat, element) => {
        $('#crudForm [name=coa]').first().val(akunpusat.coa)
        element.val(akunpusat.keterangancoa)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=coa]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $(`.format-lookup`).lookupMaster({
      title: 'Status Format',
      fileName: 'parameterMaster',
      typeSearch: 'ALL',
      searching: 1,
      beforeProcess: function() {
        this.postData = {
          url: `${apiUrl}parameter/combo`,
          grp: 'PENGELUARAN STOK',
          searching: 1,
          valueName: `format`,
          searchText: `format-lookup`,
          singleColumn: true,
          hideLabel: true,
          title: 'Status Format'
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
    $(`.statushitungstok-lookup`).lookupMaster({
      title: 'status hitung stok',
      fileName: 'parameterMaster',
      typeSearch: 'ALL',
      searching: 1,
      beforeProcess: function() {
        this.postData = {
          url: `${apiUrl}parameter/combo`,
          grp: 'STATUS HITUNG STOK',
          searching: 1,
          valueName: `statushitungstok`,
          searchText: `statushitungstok-lookup`,
          singleColumn: true,
          hideLabel: true,
          title: 'status hitung stok'
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
    $(`.statusaktif-lookup`).lookupMaster({
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
          searchText: `statusaktif-lookup`,
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
  }

  function showDefault(form) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}pengeluaranstok/default`,
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

  function cekValidasidelete(Id,Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}pengeluaranstok/${Id}/cekValidasi`,
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
            editPengeluaranStok(Id)
          }
          if (Aksi == 'DELETE') {
            deletePengeluaranStok(Id)
          }
        }

      }
    })
  }
</script>
@endpush()