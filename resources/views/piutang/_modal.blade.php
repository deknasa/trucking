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
            <div class="master">
              <input type="hidden" name="id">

              <div class="row form-group">
                <div class="col-12 col-md-2 col-form-label">
                  <label>
                    NO BUKTI <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-12 col-md-4">
                  <input type="text" name="nobukti" class="form-control" readonly>
                </div>

                <div class="col-12 col-md-2 col-form-label">
                  <label>
                    TANGGAL BUKTI <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-12 col-md-4">
                  <input type="text" name="tglbukti" class="form-control datepicker">
                </div>
              </div>

              <div class="row form-group">
                <div class="col-12 col-md-2 col-form-label">
                  <label>
                    KETERANGAN <span class="text-danger">*</span></label>
                </div>
                <div class="col-12 col-md-10">
                  <input type="text" name="keterangan" class="form-control">
                </div>
              </div>

              <div class="row form-group">
                <div class="col-12 col-md-2 col-form-label">
                  <label>
                    AGEN <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-12 col-md-10">
                  <input type="hidden" name="agen_id">
                  <input type="text" name="agen" class="form-control agen-lookup">
                </div>
              </div>
            </div>

            <table class="table table-bordered table-bindkeys" id="detailList">
              <thead>
                <tr>
                  <th width="5%">No</th>
                  <th width="40%">Keterangan</th>
                  <th width="40%">Nominal</th>
                  <th width="15%">Aksi</th>
                </tr>
              </thead>
              <tbody id="table_body" class="form-group">
                <tr>
                  <td> 1</td>
                  <td>
                    <div class="row form-group">
                      <div class="col-12 col-md-12">
                        <input type="text" name="keterangan_detail[]" class="form-control">
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="row form-group">
                      <div class="col-12 col-md-12">
                        <input type="text" name="nominal_detail[]" class="form-control nominal autonumeric">
                      </div>
                    </div>
                  </td>
                  <td>
                    <div class="btn btn-danger btn-sm delete-row">HAPUS</div>
                  </td>
                </tr>
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="2">
                    <p class="text-right font-weight-bold">TOTAL :</p>
                  </td>
                  <td>
                    <p class="text-right font-weight-bold autonumeric" id="total"></p>
                  </td>
                  <td>
                    <button type="button" class="btn btn-primary btn-sm my-2" id="addRow">TAMBAH</button>
                  </td>
                </tr>
              </tfoot>
            </table>
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
    $(document).on('click', "#addRow", function() {
      addRow()
    });
    
    $(document).on('click', '.delete-row', function(event) {
      deleteRow($(this).parents('tr'))
    })

    $(document).on('input', `#table_body [name="nominal_detail[]"]`, function(event) {
      setTotal()
    })

    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()

      $('#crudForm').find(`[name="nominal_detail[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'nominal_detail[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominal_detail[]"]`)[index])
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
          url = `${apiUrl}piutangheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}piutangheader/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}piutangheader/${Id}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}piutangheader`
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
          id = response.data.id

          $('#crudModal').find('#crudForm').trigger('reset')
          $('#crudModal').modal('hide')

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
    initLookup()
    initDatepicker()
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    
    $('#crudModal').find('.modal-body').html(modalBody)
  })

  function setTotal() {
    let nominalDetails = $(`#table_body [name="nominal_detail[]"]`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#total').set(total)
  }

  function createPiutangHeader() {
    let form = $('#crudForm')

    $('#crudModal').find('#crudForm').trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
    form.data('action', 'add')
    // form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create Piutang Header')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    $('#table_body').html('')
    addRow()
    setTotal()
  }

  function editPiutangHeader(userId) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Piutang Header')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()


    showPiutangHeader(form, userId)

  }

  function deletePiutangHeader(userId) {
    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Piutang Header')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    showPiutangHeader(form, userId)
  }

  function showPiutangHeader(form, userId) {
    $('#detailList tbody').html('')

    $.ajax({
      url: `${apiUrl}piutangheader/${userId}`,
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

        form.find(`[name="tglbukti"]`).val(dateFormat(response.data.tglbukti))
        form.find(`[name="agen"]`).val(response.data.agen.namaagen)
        form.find(`[name="agen"]`).data('currentValue', response.data.agen.namaagen)

        $.each(response.data.piutang_details, (index, detail) => {
          let detailRow = $(`
            <tr>
              <td></td>
              <td>
                <input type="text" name="keterangan_detail[]" class="form-control">
              </td>
              <td>
                <input type="text" name="nominal_detail[]" class="form-control nominal autonumeric">
              </td>
              <td>
                <button type="button" class="btn btn-danger btn-sm delete-row">HAPUS</button>
              </td>
            </tr>
          `)

          detailRow.find(`[name="keterangan_detail[]"]`).val(detail.keterangan)
          detailRow.find(`[name="nominal_detail[]"]`).val(detail.nominal)

          initAutoNumeric(detailRow.find(`[name="nominal_detail[]"]`))
          $('#detailList tbody').append(detailRow)
          setTotal()
        })

        setRowNumbers()

        if (form.data('action') === 'delete') {
          form.find('[name]').addClass('disabled')
          initDisabled()
        }
      }
    })
  }

  function addRow() {
    let detailRow = $(`
      <tr>
        <td></td>
        <td>
          <input type="text" name="keterangan_detail[]" class="form-control">
        </td>
        <td>
          <input type="text" name="nominal_detail[]" class="form-control nominal autonumeric">
        </td>
        <td>
          <button type="button" class="btn btn-danger btn-sm delete-row">HAPUS</button>
        </td>
      </tr>
    `)

    $('#detailList tbody').append(detailRow)

    initAutoNumeric(detailRow.find('.autonumeric'))
    initDatepicker()

    setRowNumbers()
  }

  function deleteRow(row) {
    row.remove()

    setRowNumbers()
    setTotal()
  }

  function setRowNumbers() {
    let elements = $('#detailList tbody tr td:nth-child(1)')

    elements.each((index, element) => {
      $(element).text(index + 1)
    })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}piutangheader/field_length`,
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

  function initLookup() {
    $('.agen-lookup').lookup({
      title: 'Agen Lookup',
      fileName: 'agen',
      onSelectRow: (agen, element) => {
        $('#crudForm [name=agen_id]').first().val(agen.id)
        element.val(agen.namaagen)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      }
    })
  }
</script>
@endpush()