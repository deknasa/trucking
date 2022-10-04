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
                <label>nobukti</label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="nobukti" class="form-control">
              </div>
            </div>
            
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>tglbukti</label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="tglbukti" class="form-control formatdate">
              </div>
            </div>
            
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>penerimaanstok</label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="penerimaanstok" class="form-control">
              </div>
            </div>
            
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>penerimaanstok_nobukti</label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="penerimaanstok_nobukti" class="form-control">
              </div>
            </div>
            
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>pengeluaranstok_nobukti</label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="pengeluaranstok_nobukti" class="form-control">
              </div>
            </div>
            
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>gudangs</label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="gudangs" class="form-control">
              </div>
            </div>
            
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>trado</label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="trado" class="form-control">
              </div>
            </div>
            
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>supplier</label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="supplier" class="form-control">
              </div>
            </div>
            
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>nobon</label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="nobon" class="form-control">
              </div>
            </div>
            
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>hutang_nobukti</label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="hutang_nobukti" class="form-control">
              </div>
            </div>
            
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>gudangdari</label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="gudangdari" class="form-control">
              </div>
            </div>
            
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>gudangke</label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="gudangke" class="form-control">
              </div>
            </div>
            
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>coa</label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="coa" class="form-control">
              </div>
            </div>
            
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>keterangan</label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="keterangan" class="form-control">
              </div>
            </div>
            
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>modifiedby</label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="modifiedby" class="form-control">
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
      let penerimaanStokHeaderId = form.find('[name=id]').val()
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
          url = `${apiUrl}penerimaanstokheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}penerimaanstokheader/${penerimaanStokHeaderId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}penerimaanstokheader/${penerimaanStokHeaderId}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}penerimaanstokheader`
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

    // getMaxLength(form)
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
  })

  function createPenerimaanstokHeader() {
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create Penerimaan Trucking')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    setStatusAktifOptions(form)
  }

  function editPenerimaanstokHeader(penerimaanStokHeaderId) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Penerimaan Trucking')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusAktifOptions(form)
      ])
      .then(() => {
        showPenerimaanstokHeader(form, penerimaanStokHeaderId)
      })
  }

  function deletePenerimaanstokHeader(penerimaanStokHeaderId) {
    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Penerimaan Trucking')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusAktifOptions(form)
      ])
      .then(() => {
        showPenerimaanstokHeader(form, penerimaanStokHeaderId)
      })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}penerimaanstokheader/field_length`,
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
        }
      })
    })
  }

  function showPenerimaanstokHeader(form, penerimaanStokHeaderId) {
    $.ajax({
      url: `${apiUrl}penerimaanstokheader/${penerimaanStokHeaderId}`,
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