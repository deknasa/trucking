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
                <input type="text" name="nobukti" class="form-control" readonly>
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
                  STATUS RITASI <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="statusritasi" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH STATUS RITASI --</option>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  SURAT PENGANTAR <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="suratpengantar_nobukti" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH SURAT PENGANTAR --</option>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  DARI <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="dari_id" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH DARI --</option>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  SAMPAI <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="sampai_id" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH SAMPAI --</option>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  TRADO <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="trado_id" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH TRADO --</option>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>
                  SUPIR <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="supir_id" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH SUPIR --</option>
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
      let ritasiId = form.find('[name=id]').val()
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
          url = `${apiUrl}ritasi`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}ritasi/${ritasiId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}ritasi/${ritasiId}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}ritasi`
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

  function createRitasi() {
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create Ritasi')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    setStatusRitasiOptions(form)
    setSuratPengantarOptions(form)
    setKotaOptions(form)
    setTradoOptions(form)
    setSupirOptions(form)
  }

  function editRitasi(ritasiId) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Ritasi')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusRitasiOptions(form),
        setSuratPengantarOptions(form),
        setKotaOptions(form),
        setTradoOptions(form),
        setSupirOptions(form)
      ])
      .then(() => {
        showRitasi(form, ritasiId)
      })
  }

  function deleteRitasi(ritasiId) {
    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Ritasi')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusRitasiOptions(form),
        setSuratPengantarOptions(form),
        setKotaOptions(form),
        setTradoOptions(form),
        setSupirOptions(form)
      ])
      .then(() => {
        showRitasi(form, ritasiId)
      })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}ritasi/field_length`,
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

  const setStatusRitasiOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusritasi]').empty()
      relatedForm.find('[name=statusritasi]').append(
        new Option('-- PILIH STATUS RITASI --', '', false, true)
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
              "data": "STATUS RITASI"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusRitasi => {
            let option = new Option(statusRitasi.text, statusRitasi.id)

            relatedForm.find('[name=statusritasi]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  const setSuratPengantarOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=suratpengantar_nobukti]').empty()
      relatedForm.find('[name=suratpengantar_nobukti]').append(
        new Option('-- PILIH SURAT PENGANTAR --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}suratpengantar`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          limit: 0,
        },
        success: response => {
          response.data.forEach(suratPengantar => {
            let option = new Option(suratPengantar.nobukti, suratPengantar.nobukti)

            relatedForm.find('[name=suratpengantar_nobukti]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  const setKotaOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=dari_id], [name=sampai_id]').empty()
      relatedForm.find('[name=dari_id]').append(
        new Option('-- PILIH DARI --', '', false, true)
      ).trigger('change')
      relatedForm.find('[name=sampai_id]').append(
        new Option('-- PILIH SAMPAI --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}kota`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          limit: 0,
        },
        success: response => {
          response.data.forEach(kota => {
            let option = new Option(kota.keterangan, kota.id)

            relatedForm.find('[name=dari_id], [name=sampai_id]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  const setTradoOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=trado_id]').empty()
      relatedForm.find('[name=trado_id]').append(
        new Option('-- PILIH TRADO --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}trado`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          limit: 0,
        },
        success: response => {
          response.data.forEach(trado => {
            let option = new Option(trado.keterangan, trado.id)

            relatedForm.find('[name=trado_id]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  const setSupirOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=supir_id]').empty()
      relatedForm.find('[name=supir_id]').append(
        new Option('-- PILIH SUPIR --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}supir`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          limit: 0,
        },
        success: response => {
          response.data.forEach(supir => {
            let option = new Option(supir.namasupir, supir.id)

            relatedForm.find('[name=supir_id]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  function showRitasi(form, ritasiId) {
    $.ajax({
      url: `${apiUrl}ritasi/${ritasiId}`,
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