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
                  kodepengeluaran <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="kodepengeluaran" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  keterangan <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="keterangan" class="form-control">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  COA <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-8 col-md-10">
                <div class="input-group">
                  <input type="text" name="coa" class="form-control akunpusat-lookup">
                </div>
              </div>
              {{-- <div class="col-8 col-md-10">
                <div class="input-group">
                  <input type="text" name="coa" class="form-control">
                  <div class="input-group-append">
                    <button id="lookupAkunPusatToggler" class="btn btn-secondary" type="button">...</button>
                  </div>
                </div>
                <div class="row position-absolute" id="lookupAkunPusat" style="z-index: 1;">
                  <div class="col-12">
                    <div id="lookupAkunPusat" class="shadow-lg">
                      @include('partials.lookups.akunpusat')
                    </div>
                  </div>
                </div>
              </div> --}}
            </div>


            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  status format <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <select name="statusformat" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH STATUS FORMAT --</option>
                </select>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  status hitung stok <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <select name="statushitungstok" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH STATUS FORMAT --</option>
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

    $('.numeric').inputmask('integer', {
			alias: 'numeric',
			groupSeparator: '',
			autoGroup: true,
			digitsOptional: false,
			allowMinus: false,
			placeholder: '',
		}).css('text-align', 'right');
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

  function createPengeluaranStok() {
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create Pengeluaran Stok')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    setStatusFormatListOptions(form)
    setStatusHitungListOptions(form)
  }

  function editPengeluaranStok(pengeluaranstokId) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Pengeluaran Stok')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusFormatListOptions(form),
        setStatusHitungListOptions(form)
      ])
      .then(() => {
        showPengeluaranStok(form, pengeluaranstokId)
      })
    
  }

  function deletePengeluaranStok(pengeluaranstokId) {
    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Pengeluaran Stok')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    Promise
      .all([
        setStatusFormatListOptions(form),
        setStatusHitungListOptions(form)
      ])
      .then(() => {
        showPengeluaranStok(form, pengeluaranstokId)
      })
  }

  const setStatusFormatListOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusformat]').empty()
      relatedForm.find('[name=statusformat]').append(
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
            console.log(statusFormatList);
            let option = new Option(statusFormatList.text, statusFormatList.id)

            relatedForm.find('[name=statusformat]').append(option).trigger('change')
          });

          resolve()
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
            console.log(statusHitungList);
            let option = new Option(statusHitungList.text, statusHitungList.id)

            relatedForm.find('[name=statushitungstok]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
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

          form.attr('has-maxlength', true)
        },
        error: error => {
          showDialog(error.statusText)
        }
      })
    }
  }

  function showPengeluaranStok(form, pengeluaranstokId) {
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
        })
      }
    })
  }
</script>
@endpush()