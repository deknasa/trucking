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
            <input type="hidden" name="id">

            <div class="row form-group">
              <div class="col-12 col-sm-2 col-md-2 col-form-label">
                <label>
                  NO BUKTI <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-4 col-md-4">
                <input type="text" name="nobukti" class="form-control" readonly>
              </div>

              <div class="col-12 col-sm-2 col-md-2 col-form-label">
                <label>
                  TANGGAL BUKTI <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-4 col-md-4">
                <div class="input-group">
                  <input type="text" name="tglbukti" class="form-control datepicker">
                </div>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  KETERANGAN <span class="text-danger">*</span></label>
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
                <input type="text" name="akunpusat" class="form-control akunpusat-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  PELANGGAN <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-8 col-md-10">
                <input type="hidden" name="pelanggan_id">
                <input type="text" name="pelanggan" class="form-control pelanggan-lookup">
              </div>
            </div>

            <div class="table-responsive">
              <table class="table table-bordered table-bindkeys" id="detailList" style="width: 1500px;">
                <thead>
                  <tr>
                    <th width="1%">No</th>
                    <th width="5%">Supplier</th>
                    <th width="3%">Tgl Jatuh Tempo</th>
                    <th width="5%">Keterangan</th>
                    <th width="6%">Total</th>
                    <th width="1%">Aksi</th>
                  </tr>
                </thead>
                <tbody id="table_body">
                  
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="4">
                      <h5 class="text-right font-weight-bold">TOTAL:</h5>
                    </td>
                    <td>
                      <h5 id="total" class="text-right font-weight-bold"></h5>
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

    $(document).on('input', `#table_body [name="total_detail[]"]`, function(event) {
      setTotal()
    })

    $(document).on('click', '.delete-row', function(event) {
      deleteRow($(this).parents('tr'))
    })
    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()


      $('#crudForm').find(`[name="total_detail[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'total_detail[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="total_detail[]"]`)[index])
      })

      $('#crudForm').find(`[name="cicilan_detail[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'cicilan_detail[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="cicilan_detail[]"]`)[index])
      })

      $('#crudForm').find(`[name="totalbayar_detail[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'totalbayar_detail[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="totalbayar_detail[]"]`)[index])
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
          url = `${apiUrl}hutangheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}hutangheader/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}hutangheader/${Id}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}hutangheader`
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

    initLookup()
    getMaxLength(form)
    initDatepicker()
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'

    $('#crudModal').find('.modal-body').html(modalBody)
  })

  function setTotal() {
    let nominalDetails = $(`#detailList [name="total_detail[]"]`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#total').set(total)
  }

  function createHutangHeader() {
    let form = $('#crudForm')

    $('#crudModal').find('#crudForm').trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
    form.data('action', 'add')
    // form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create Hutang')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    $('#table_body').html('')
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    addRow()
    setTotal()
  }

  function editHutangHeader(id) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
                <i class="fa fa-save"></i>
                Simpan
              `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Hutang')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    showHutangHeader(form, id)

  }

  function deleteHutangHeader(id) {
    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
                <i class="fa fa-save"></i>
                Hapus
              `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Hutang')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    showHutangHeader(form, id)
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}hutangheader/field_length`,
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

  function showHutangHeader(form, userId) {
    $('#detailList tbody').html('')

    $.ajax({
      url: `${apiUrl}hutangheader/${userId}`,
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

          if (index == 'akunpusat') {
            element.data('current-value', value)
          }
          if (index == 'pelanggan') {
            element.data('current-value', value)
          }
        })

        $.each(response.detail, (index, detail) => {
          let detailRow = $(`
            <tr>
              <td> </td>
              <td>
                <input type="hidden" name="supplier_id[]" class="form-control">
                <input type="text" name="supplier[]" data-current-value="${detail.supplier}" class="form-control supplier-lookup">
              </td>
              <td>
                <div class="input-group">
                  <input type="text" name="tgljatuhtempo[]" class="form-control datepicker">
                </div>
              </td>
              <td>
                <input type="text" name="keterangan_detail[]"  class="form-control">
              </td>
              <td>
                  <input type="text" name="total_detail[]" style="text-align:right" class="form-control text-right autonumeric" > 
              </td>
              <td>
                <div class='btn btn-danger btn-sm delete-row '>Hapus</div>
              </td>
            </tr>
          `)

          detailRow.find(`[name="supplier[]"]`).val(detail.supplier)
          detailRow.find(`[name="supplier_id[]"]`).val(detail.supplier_id)
          detailRow.find(`[name="tgljatuhtempo[]"]`).val(dateFormat(detail.tgljatuhtempo))
          detailRow.find(`[name="total_detail[]"]`).val(detail.total)
          detailRow.find(`[name="keterangan_detail[]"]`).val(detail.keterangan)

          initAutoNumeric(detailRow.find(`[name="total_detail[]"]`))


          $('#detailList tbody').append(detailRow)
          initDatepicker(detailRow.find('.datepicker'))
          setTotal()

          $('.supplier-lookup').last().lookup({
            title: 'supplier Lookup',
            fileName: 'supplier',
            onSelectRow: (supplier, element) => {
              element.parents('td').find(`[name="supplier_id[]"]`).val(supplier.id)
              element.val(supplier.namasupplier)
              element.data('currentValue', element.val())
            },
            onCancel: (element) => {
              element.val(element.data('currentValue'))
            },
            onClear: (element) => {
              element.parents('td').find(`[name="supplier_id[]"]`).val('')
              element.val('')
              element.data('currentValue', element.val())
            }
          })

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
          <td> </td>
          <td>
            <input type="hidden" name="supplier_id[]" class="form-control">
            <input type="text" name="supplier[]" class="form-control supplier-lookup">
          </td>
          <td>
            <div class="input-group">
              <input type="text" name="tgljatuhtempo[]" class="form-control datepicker">
            </div>
          </td>
          <td>
            <input type="text" name="keterangan_detail[]"  class="form-control">
          </td>
          <td>
              <input type="text" name="total_detail[]" style="text-align:right" class="form-control text-right autonumeric" > 
          </td>
          <td>
            <div class='btn btn-danger btn-sm delete-row'>Hapus</div>
          </td>
      </tr>`)
      
      detailRow.find(`[name="tgljatuhtempo[]"]`).val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');


    $('#detailList tbody').append(detailRow)
    initDatepicker(detailRow.find('.datepicker'))

    $('.supplier-lookup').last().lookup({
      title: 'supplier Lookup',
      fileName: 'supplier',
      onSelectRow: (supplier, element) => {
        $(`#crudForm [name="supplier_id[]"]`).last().val(supplier.id)
        element.val(supplier.namasupplier)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $(`#crudForm [name="supplier_id[]"]`).last().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    initAutoNumeric(detailRow.find('.autonumeric'))
    
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

  function initLookup() {
    $('.akunpusat-lookup').lookup({
      title: 'Akun Pusat Lookup',
      fileName: 'akunpusat',
      onSelectRow: (akunpusat, element) => {
        element.val(akunpusat.coa)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.pelanggan-lookup').lookup({
      title: 'pelanggan Lookup',
      fileName: 'pelanggan',
      onSelectRow: (pelanggan, element) => {
        $('#crudForm [name=pelanggan_id]').first().val(pelanggan.id)
        element.val(pelanggan.namapelanggan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=pelanggan_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

  }
</script>
@endpush()