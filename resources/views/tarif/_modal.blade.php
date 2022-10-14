<div class="modal fade modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="crudForm">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title" id="crudModalTitle"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" method="post">
          <div class="modal-body">
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>ID</label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="id" class="form-control" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  TUJUAN <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="tujuan" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  CONTAINER <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="container_id" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH CONTAINER --</option>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  NOMINAL <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="nominal" class="form-control text-right autonumeric">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  STATUS AKTIF <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <select name="statusaktif" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH STATUS AKTIF --</option>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  TUJUAN ASAL <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="tujuanasal" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  SISTEM TON <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <select name="statussistemton" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH SISTEM TON --</option>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  KOTA <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="kota_id" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH KOTA --</option>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  ZONA <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="zona_id" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH ZONA --</option>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  NOMINAL TON
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="nominalton" class="form-control text-right autonumeric">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  TGL MULAI BERLAKU <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="tglmulaiberlaku" class="form-control datepicker">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  TGL AKHIR BERLAKU <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="tglakhirberlaku" class="form-control datepicker">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  STATUS PENYESUAIAN HARGA <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="statuspenyesuaianharga" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH STATUS PENYESUAIAN HARGA --</option>
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

  $(document).ready(function() {
    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let tarifId = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()

      unformatAutoNumeric(data)
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
          url = `${apiUrl}tarif`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}tarif/${tarifId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}tarif/${tarifId}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}tarif`
          break;
      }

      $(this).attr('disabled', '')
      $('#loader').removeClass('d-none')

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
            showDialog(error.statusText)
          }
        },
      }).always(() => {
        $('#loader').addClass('d-none')
        $(this).removeAttr('disabled')
      })
    })
  })

  $('#crudModal').on('shown.bs.modal', () => {
    let form = $('#crudForm')

    setFormBindKeys(form)

    activeGrid = null

    getMaxLength(form)
    initDatepicker()

  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
  })

  function createTarif() {
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create Tarif')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    setStatusPenyesuaianHargaOptions(form)
    setZonaOptions(form)
    setKotaOptions(form)
    setStatusSistemTonOptions(form)
    setContainerOptions(form)
    setStatusAktifOptions(form)
  }

  function editTarif(tarifId) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Tarif')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusPenyesuaianHargaOptions(form),
        setZonaOptions(form),
        setKotaOptions(form),
        setStatusSistemTonOptions(form),
        setContainerOptions(form),
        setStatusAktifOptions(form)
      ])
      .then(() => {
        showTarif(form, tarifId)
      })
  }

  function deleteTarif(tarifId) {
    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Tarif')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusPenyesuaianHargaOptions(form),
        setZonaOptions(form),
        setKotaOptions(form),
        setStatusSistemTonOptions(form),
        setContainerOptions(form),
        setStatusAktifOptions(form)
      ])
      .then(() => {
        showTarif(form, tarifId)
      })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}tarif/field_length`,
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

  const setStatusPenyesuaianHargaOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statuspenyesuaianharga]').empty()
      relatedForm.find('[name=statuspenyesuaianharga]').append(
        new Option('-- PILIH STATUS PENYESUAIAN HARGA --', '', false, true)
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
              "data": "STATUS PENYESUAIAN HARGA"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusPenyesuaianHarga => {
            let option = new Option(statusPenyesuaianHarga.text, statusPenyesuaianHarga.id)

            relatedForm.find('[name=statuspenyesuaianharga]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  const setZonaOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=zona_id]').empty()
      relatedForm.find('[name=zona_id]').append(
        new Option('-- PILIH KOTA --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}zona`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          response.data.forEach(zona => {
            let option = new Option(zona.keterangan, zona.id)

            relatedForm.find('[name=zona_id]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  const setKotaOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=kota_id]').empty()
      relatedForm.find('[name=kota_id]').append(
        new Option('-- PILIH KOTA --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}kota`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          response.data.forEach(kota => {
            let option = new Option(kota.keterangan, kota.id)

            relatedForm.find('[name=kota_id]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  const setStatusSistemTonOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statussistemton]').empty()
      relatedForm.find('[name=statussistemton]').append(
        new Option('-- PILIH SISTEM TON --', '', false, true)
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
              "data": "SISTEM TON"
            }]
          })
        },
        success: response => {
          response.data.forEach(statussistemTon => {
            let option = new Option(statussistemTon.text, statussistemTon.id)

            relatedForm.find('[name=statussistemton]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  const setContainerOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=container_id]').empty()
      relatedForm.find('[name=container_id]').append(
        new Option('-- PILIH CONTAINER --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}container`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          response.data.forEach(container => {
            let option = new Option(container.keterangan, container.id)

            relatedForm.find('[name=container_id]').append(option).trigger('change')
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

  function showTarif(form, tarifId) {
    $.ajax({
      url: `${apiUrl}tarif/${tarifId}`,
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
          } else if (element.hasClass('datepicker')) {
            element.val(dateFormat(value))
          } else if (element.hasClass('autonumeric')) {
            let autoNumericInput = AutoNumeric.getAutoNumericElement(element[0])

            autoNumericInput.set(value);
          } else {
            element.val(value)
          }
        })
      }
    })
  }
</script>
@endpush()