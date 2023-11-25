<div class="modal modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="crudForm">
      <div class="modal-content">
        
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
            <input type="hidden" name="id" class="form-control">

            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  KODE CUSTOMER <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="kodeagen" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  NAMA CUSTOMER <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="namaagen" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  KETERANGAN
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="keterangan" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  Status Aktif <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <select name="statusaktif" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH STATUS AKTIF --</option>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  NAMA PERUSAHAAN <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="namaperusahaan" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  ALAMAT <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="alamat" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  NO TELEPON / HANDPHONE <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="notelp" class="form-control numbernoseparate">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  NAMA KONTAK <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="contactperson" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  STATUS PEMBAYARAN (TOP) <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="top" class="form-control text-right numbernoseparate">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  STATUS TAS <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <select name="statustas" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH STATUS TAS --</option>
                </select>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  NAMA PERKIRAAN <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="coa">
                <input type="text" name="keterangancoa" class="form-control coa-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  NAMA PERKIRAAN (PENDAPATAN) <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="coapendapatan">
                <input type="text" name="keterangancoapendapatan" class="form-control coapendapatan-lookup">
              </div>
            </div>
            {{-- <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  JENIS EMKL <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="jenisemkl">
                <input type="text" name="keteranganjenisemkl" class="form-control jenisemkl-lookup">
              </div>
            </div> --}}
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
      let agenId = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()

      $('#crudForm').find(`[name="top`).each((index, element) => {
        data.filter((row) => row.name === 'top')[index].value = AutoNumeric.getNumber($(`#crudForm [name="top`)[index])
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
          url = `${apiUrl}agen`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}agen/${agenId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}agen/${agenId}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}agen`
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

    form.find('#btnSubmit').prop('disabled', false)
    if (form.data('action') == "view") {
      form.find('#btnSubmit').prop('disabled', true)
    }

    getMaxLength(form)
    initSelect2(form.find(`[name="statustas"]`), true)
    initSelect2(form.find(`[name="statusaktif"]`), true)


    initLookup()
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    $('#crudModal').find('.modal-body').html(modalBody)
  })

  function createAgen() {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create Customer')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    initAutoNumeric(form.find(`[name="top"]`))
    Promise
      .all([
        setStatusAktifOptions(form),
        setStatusTasOptions(form),
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

  function editAgen(agenId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Customer')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusAktifOptions(form),
        setStatusTasOptions(form),
      ])
      .then(() => {
        showAgen(form, agenId)
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

  function deleteAgen(agenId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Customer')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusAktifOptions(form),
        setStatusTasOptions(form),
      ])
      .then(() => {
        showAgen(form, agenId)
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

  function viewAgen(agenId) {
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
    $('#crudModalTitle').text('View Customer')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusAktifOptions(form),
        setStatusTasOptions(form),
      ])
      .then(() => {
        showAgen(form, agenId)
          .then(agenId => {
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
        url: `${apiUrl}agen/field_length`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          'Authorization': `Bearer ${accessToken}`
        },
        success: response => {
          $.each(response.data, (index, value) => {
            if (value !== null && value !== 0 && value !== undefined) {
              form.find(`[name=${index}]`).attr('maxlength', value)

              if (index == 'nohp') {
                form.find(`[name=nohp]`).attr('maxlength', 13)
              }
              if (index == 'notelp') {
                form.find(`[name=notelp]`).attr('maxlength', 13)
              }
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

  const setCabangOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=cabang_id]').empty()
      relatedForm.find('[name=cabang_id]').append(
        new Option('-- PILIH CABANG --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}cabang`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          response.data.forEach(cabang => {
            let option = new Option(cabang.namacabang, cabang.id)

            relatedForm.find('[name=cabang_id]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  const setStatusTasOptions = function setStatusTasOptions(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statustas]').empty()
      relatedForm.find('[name=statustas]').append(
        new Option('-- PILIH STATUS TAS --', '', false, true)
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
              "data": "STATUS TAS"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusKaryawan => {
            let option = new Option(statusKaryawan.text, statusKaryawan.id)

            relatedForm.find('[name=statustas]').append(option).trigger('change')
          });

          resolve()
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
        }
      })
    })
  }

  function showAgen(form, agenId) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}agen/${agenId}`,
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
            if (index == 'keteranganjenisemkl') {
              element.data('current-value', value)
            }
          })
          initAutoNumeric($('#crudForm').find(`[name="top"]`))

          if (form.data('action') === 'delete') {
            form.find('[name]').addClass('disabled')
            initDisabled()
          }
          resolve()
        }
      })
    })
  }

  function initLookup() {
    $('.jenisemkl-lookup').lookup({
      title: 'Jenis EMKL Lookup',
      fileName: 'jenisemkl',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (jenisemkl, element) => {
        $('#crudForm [name=jenisemkl]').first().val(jenisemkl.id)
        element.val(jenisemkl.keterangan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {

        $('#crudForm [name=jenisemkl]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.coa-lookup').last().lookup({
      title: 'Coa Lookup',
      fileName: 'akunpusat',
      beforeProcess: function(test) {
        this.postData = {
          levelCoa: '3',
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (akunpusat, element) => {
        $('#crudForm [name=coa]').first().val(akunpusat.coa)
        element.val(akunpusat.kodeket)
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
    $('.coapendapatan-lookup').last().lookup({
      title: 'Coa Pendapatan Lookup',
      fileName: 'akunpusat',
      beforeProcess: function(test) {
        this.postData = {
          levelCoa: '3',
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (akunpusat, element) => {
        $('#crudForm [name=coapendapatan]').first().val(akunpusat.coa)
        element.val(akunpusat.kodeket)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=coapendapatan]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
  }

  function showDefault(form) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}agen/default`,
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
        }
      })
    })
  }

  function cekValidasidelete(Id) {
    $.ajax({
      url: `{{ config('app.api_url') }}agen/${Id}/cekValidasi`,
      method: 'POST',
      dataType: 'JSON',
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      success: response => {
        var kondisi = response.kondisi
        if (kondisi == true) {
          showDialog(response.message['keterangan'])
        } else {
          deleteAgen(Id)
        }

      }
    })
  }
</script>
@endpush()