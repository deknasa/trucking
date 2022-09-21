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
                  NO BUKTI <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="nobukti" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  TGL BUKTI <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="tglbukti" class="form-control formatdate">
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
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  AGEN <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="agen_id" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH AGEN --</option>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  JENIS ORDER <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="jenisorder_id" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH JENIS ORDER --</option>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  PELANGGAN <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="pelanggan_id" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH PELANGGAN --</option>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  TARIF <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="tarif_id" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH TARIF --</option>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  JOB EMKL <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="nojobemkl" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  NO CONT <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="nocont" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  NO SEAL <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="noseal" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  JOB EMKL 2 <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="nojobemkl2" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  NO CONT 2
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="nocont2" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  NO SEAL 2
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="noseal2" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  STATUS LANGSIR <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="statuslangsir" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH STATUS LANGSIR --</option>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  STATUS PERALIHAN <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="statusperalihan" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH STATUS PERALIHAN --</option>
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
      let orderanTruckingId = form.find('[name=id]').val()
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
          url = `${apiUrl}orderantrucking`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}orderantrucking/${orderanTruckingId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}orderantrucking/${orderanTruckingId}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}orderantrucking`
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
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
  })

  function createOrderanTrucking() {
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create Orderan Trucking')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    setContainerOptions(form)
    setAgenOptions(form)
    setJenisOrderOptions(form)
    setPelangganOptions(form)
    setTarifOptions(form)
    setStatusLangsirOptions(form)
    setStatusPeralihanOptions(form)
  }

  function editOrderanTrucking(orderanTruckingId) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Orderan Trucking')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setContainerOptions(form),
        setAgenOptions(form),
        setJenisOrderOptions(form),
        setPelangganOptions(form),
        setTarifOptions(form),
        setStatusLangsirOptions(form),
        setStatusPeralihanOptions(form)
      ])
      .then(() => {
        showOrderanTrucking(form, orderanTruckingId)
      })
  }

  function deleteOrderanTrucking(orderanTruckingId) {
    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Orderan Trucking')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setContainerOptions(form),
        setAgenOptions(form),
        setJenisOrderOptions(form),
        setPelangganOptions(form),
        setTarifOptions(form),
        setStatusLangsirOptions(form),
        setStatusPeralihanOptions(form)
      ])
      .then(() => {
        showOrderanTrucking(form, orderanTruckingId)
      })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}orderantrucking/field_length`,
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
        data: {
          limit: 0,
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

  const setAgenOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=agen_id]').empty()
      relatedForm.find('[name=agen_id]').append(
        new Option('-- PILIH AGEN --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}agen`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          limit: 0,
        },
        success: response => {
          response.data.forEach(agen => {
            let option = new Option(agen.namaagen, agen.id)

            relatedForm.find('[name=agen_id]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  const setJenisOrderOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=jenisorder_id]').empty()
      relatedForm.find('[name=jenisorder_id]').append(
        new Option('-- PILIH JENIS ORDER --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}jenisorder`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          limit: 0,
        },
        success: response => {
          response.data.forEach(jenisOrder => {
            let option = new Option(jenisOrder.keterangan, jenisOrder.id)

            relatedForm.find('[name=jenisorder_id]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  const setPelangganOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=pelanggan_id]').empty()
      relatedForm.find('[name=pelanggan_id]').append(
        new Option('-- PILIH PELANGGAN --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}pelanggan`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          limit: 0,
        },
        success: response => {
          response.data.forEach(pelanggan => {
            let option = new Option(pelanggan.namapelanggan, pelanggan.id)

            relatedForm.find('[name=pelanggan_id]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  const setTarifOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=tarif_id]').empty()
      relatedForm.find('[name=tarif_id]').append(
        new Option('-- PILIH TARIF --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}tarif`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          limit: 0,
        },
        success: response => {
          response.data.forEach(tarif => {
            let option = new Option(tarif.tujuan, tarif.id)

            relatedForm.find('[name=tarif_id]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  const setStatusLangsirOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statuslangsir]').empty()
      relatedForm.find('[name=statuslangsir]').append(
        new Option('-- PILIH STATUS LANGSIR --', '', false, true)
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
              "data": "STATUS LANGSIR"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusLangsir => {
            let option = new Option(statusLangsir.text, statusLangsir.id)

            relatedForm.find('[name=statuslangsir]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  const setStatusPeralihanOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusperalihan]').empty()
      relatedForm.find('[name=statusperalihan]').append(
        new Option('-- PILIH STATUS PERALIHAN --', '', false, true)
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
              "data": "STATUS PERALIHAN"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusPeralihan => {
            let option = new Option(statusPeralihan.text, statusPeralihan.id)

            relatedForm.find('[name=statusperalihan]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  function showOrderanTrucking(form, orderanTruckingId) {
    $.ajax({
      url: `${apiUrl}orderantrucking/${orderanTruckingId}`,
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
      }
    })
  }
</script>
@endpush()