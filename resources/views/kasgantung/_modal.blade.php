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
          <input type="hidden" name="id">
          <div class="modal-body">
            <div class="row">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  NO BUKTI
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="nobukti" class="form-control" readonly>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  TANGGAL <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <div class="input-group">
                  <input type="text" name="tglbukti" class="form-control datepicker">
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  PENERIMA <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="penerima_id">
                <input type="text" name="penerima" class="form-control penerima-lookup">
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  KETERANGAN
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="keterangan" class="form-control">
              </div>
            </div>
            <div class="border p-3">
              <h6>Posting Pengeluaran</h6>

              <div class="row form-group">
                <div class="col-12 col-md-2 col-form-label">
                  <label>
                    POST <span class="text-danger">*</span></label>
                </div>
                <div class="col-12 col-md-4">
                  <input type="hidden" name="bank_id">
                  <input type="text" name="bank" class="form-control bank-lookup">
                </div>
                <div class="col-12 col-md-2 col-form-label">
                  <label>TANGGAL POST</label>
                </div>
                <div class="col-12 col-md-4">
                  <div class="input-group">
                    <input type="text" name="tglkaskeluar" class="form-control datepicker">
                  </div>
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-md-2 col-form-label">
                  <label>
                    NO BUKTI KAS KELUAR <span class="text-danger">*</span></label>
                </div>
                <div class="col-12 col-md-4">
                  <input type="text" name="pengeluaran_nobukti" id="pengeluaran_nobukti" class="form-control" readonly>
                </div>
              </div>
            </div>


            <div class="table-responsive">
              <table class="table table-bordered mt-3" id="detailList" style="width:1350px">
                <thead class="table-secondary">
                  <tr>
                    <th width="1%">NO</th>
                    <th width="5%">KETERANGAN</th>
                    <th width="5%">NOMINAL</th>
                    <th width="1%">AKSI</th>
                  </tr>
                </thead>
                <tbody id="table_body" class="form-group">
                  <tr>
                    <td>1</td>
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
                          <input type="text" name="nominal[]" class="form-control autonumeric nominal">
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
                      <button type="button" class="btn btn-primary btn-sm my-2" id="addRow">Tambah</button>
                    </td>
                  </tr>
                </tfoot>
              </table>
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

    $(document).on('click', "#addRow", function() {
      addRow()
    });

    $(document).on('click', '.delete-row', function(event) {
      deleteRow($(this).parents('tr'))
    })

    $(document).on('input', `#table_body [name="nominal[]"]`, function(event) {
      setTotal()
    })

    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let userId = form.find('[name=user_id]').val()
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()
      $('#crudForm').find(`[name="nominal[]"]`).each((index, element) => {
        console.log(element);
        data.filter((row) => row.name === 'nominal[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominal[]"]`)[index])
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
          url = `${apiUrl}kasgantungheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}kasgantungheader/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}kasgantungheader/${Id}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}kasgantungheader`
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

          $('#jqGrid').jqGrid('setGridParam', {
            page: response.data.page
          }).trigger('reloadGrid');

          if(id == 0){
            $('#detail').jqGrid().trigger('reloadGrid')
          }
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
    let nominalDetails = $(`#table_body [name="nominal[]"]`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#total').set(total)
  }

  function createKasGantung() {
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create Kas Gantung')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    $('#table_body').html('')
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    $('#crudForm').find('[name=tglkaskeluar]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    addRow()
    setTotal()
  }

  function editKasGantung(userId) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Kas Gantung')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    showKasGantung(form, userId)

  }

  function deleteKasGantung(userId) {
    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Kas Gantung')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()


    showKasGantung(form, userId)

  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}kasgantungheader/field_length`,
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


  function showKasGantung(form, userId) {
    $('#detailList tbody').html('')

    $.ajax({
      url: `${apiUrl}kasgantungheader/${userId}`,
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
          } else {
            element.val(value)
          }

          if (index == 'penerima') {
            element.data('current-value', value)
          }
          if (index == 'bank') {
            element.data('current-value', value)
          }
        })

        $.each(response.detail, (index, detail) => {
          let detailRow = $(`
            <tr>
              <td></td>
              <td>
                <input type="text" name="keterangan_detail[]" class="form-control">
              </td>
              <td>
                <input type="text" name="nominal[]" class="form-control autonumeric nominal">
              </td>
              <td>
                <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
              </td>
            </tr>
          `)

          detailRow.find(`[name="keterangan_detail[]"]`).val(detail.keterangan)
          detailRow.find(`[name="nominal[]"]`).val(detail.nominal)

          initAutoNumeric(detailRow.find(`[name="nominal[]"]`))
          $('#detailList tbody').append(detailRow)
          setTotal();
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
          <input type="text" name="nominal[]" class="form-control autonumeric nominal">
        </td>
        <td>
          <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
        </td>
      </tr>
    `)

    $('#detailList tbody').append(detailRow)

    initAutoNumeric(detailRow.find('.autonumeric'))
   
    setRowNumbers()
  }

  function deleteRow(row) {
    row.remove()

    setRowNumbers()
  }

  function setRowNumbers() {
    let elements = $('#detailList tbody tr td:nth-child(1)')

    elements.each((index, element) => {
      $(element).text(index + 1)
    })
  }



  function initLookup() {
    $('.penerima-lookup').lookup({
      title: 'Penerima Lookup',
      fileName: 'penerima',
      onSelectRow: (penerima, element) => {
        $('#crudForm [name=penerima_id]').first().val(penerima.id)
        element.val(penerima.namapenerima)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=penerima_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.bank-lookup').lookup({
      title: 'Bank Lookup',
      fileName: 'bank',
      onSelectRow: (bank, element) => {
        $('#crudForm [name=bank_id]').first().val(bank.id)
        element.val(bank.namabank)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=bank_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
  }
</script>
@endpush()