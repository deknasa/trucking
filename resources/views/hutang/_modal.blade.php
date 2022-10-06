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
                <input type="text" name="tglbukti" class="form-control datepicker">
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

            <table class="table table-bordered table-bindkeys" id="detailList">
              <thead>
                <tr>
                  <th width="50">No</th>
                  <th>Supplier</th>
                  <th>Tgl Jatuh Tempo</th>
                  <th>Total</th>
                  <th>Cicilan</th>
                  <th>Total Bayar</th>
                  <th>Keterangan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody id="table_body" class="form-group">
                <tr id="row">
                  <td>
                    <div class="baris">1</div>
                  </td>
                  <td>
                    <div class="row form-group">
                      <div class="col-12 col-md-12" id="supplier">
                        <div class="col-8 col-md-10">
                          <input type="hidden" name="supplier_id">
                          <input type="text" name="supplier" class="form-control supplier-lookup">
                        </div>
                      </div>
                    </div>
                  </td>

                  <td>
                    <input type="text" name="tgljatuhtempo" class="form-control datepicker">
                  </td>

                  <td>
                    <input type="text" name="total_detail[]" style="text-align:right" class="form-control text-right autonumeric">
                  </td>

                  <td>
                    <input type="text" name="cicilan_detail[]" style="text-align:right" class="form-control text-right autonumeric">
                  </td>

                  <td>
                    <input type="text" name="totalbayar_detail[]" style="text-align:right" class="form-control text-right autonumeric">
                  </td>


                  <td>
                    <input type="text" name="keterangan_detail[]" class="form-control ">
                  </td>

                  <td>
                    <div class='btn btn-danger btn-sm rmv'>Hapus</div>
                  </td>
                </tr>

              </tbody>
              <tfoot>
                <tr>
                  <td colspan="7"></td>
                  <td>
                    <button type="button" class="btn btn-primary btn-sm my-2" id="addRow">Tambah</button>
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
  $(document).ready(function() {
    // addRow()

    $("#addRow").click(function() {
      addRow()
    });

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
    })
  })

  $('#crudModal').on('shown.bs.modal', () => {
    let form = $('#crudForm')
    setFormBindKeys(form)
    activeGrid = null
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
  })

  function createHutangHeader() {
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
                  <i class="fa fa-save"></i>
                  Simpan
                `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create Hutang Header')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
  }

  function editHutangHeader(userId) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
                <i class="fa fa-save"></i>
                Simpan
              `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Hutang Header')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    showHutangHeader(form, userId)

  }

  function deleteHutangHeader(userId) {
    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
                <i class="fa fa-save"></i>
                Hapus
              `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Hutang Header')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    showHutangHeader(form, userId)
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
          } else {
            element.val(value)
          }
        })

        $.each(response.detail, (index, detail) => {
          let detailRow = $(`
                      <tr>
                      <td> </td>
                      <td>
                          <input type="hidden" name="supplier_id[]">
                          <input type="text" name="supplier" class="form-control supplier-lookup">
                      </td>
                      <td>
                      <input type="text" name="tgljatuhtempo[]" class="form-control datepicker">
                      </td>
                      <td>
                          <input type="text" name="total_detail[]" style="text-align:right" class="form-control text-right autonumeric" > 
                      </td>
                      <td>
                          <input type="text" name="cicilan_detail[]"  style="text-align:right" class="form-control text-right autonumeric" > 
                      </td>
                      <td>
                          <input type="text" name="totalbayar_detail[]"  style="text-align:right" class="form-control text-right autonumeric" > 
                      </td>
                      <td>
                        <input type="text" name="keterangan_detail[]"  class="form-control">
                      </td>
                      <td>
                        <div class='btn btn-danger btn-sm rmv'>Hapus</div>
                      </td>
                      </tr>`)

          detailRow.find(`[name="supplier_id[]"]`).val(detail.supplier_id)
          detailRow.find(`[name="tgljatuhtempo[]"]`).val(detail.tgljatuhtempo)
          detailRow.find(`[name="total_detail[]"]`).val(detail.total)
          detailRow.find(`[name="cicilan_detail[]"]`).val(detail.cicilan)
          detailRow.find(`[name="totalbayar_detail[]"]`).val(detail.totalbayar)
          detailRow.find(`[name="keterangan_detail[]"]`).val(detail.keterangan)

          initAutoNumeric(detailRow.find(`[name="total_detail[]"]`))
          initAutoNumeric(detailRow.find(`[name="cicilan_detail[]"]`))
          initAutoNumeric(detailRow.find(`[name="totalbayar_detail[]"]`))

          $('#detailList tbody').append(detailRow)

          $('#lookup').hide()

          // $('.supplier-lookup').lookup({
          //   title: 'supplier Lookup',
          //   fileName: 'supplier',
          //   onSelectRow: (supplier, element) => {
          //     $('#crudForm [name=supplier_id]').first().val(supplier.id)
          //     element.val(supplier.namasupplier)
          //   }
          // })
        })

        setRowNumbers()
      }
    })
  }

  function addRow() {
    let detailRow = $(`
                      <tr>
                      <td> </td>
                      <td>
                          <input type="hidden" name="supplier_id[]">
                          <input type="text" name="supplier" class="form-control supplier-lookup">
                      </td>
                      <td>
                      <input type="text" name="tgljatuhtempo[]" class="form-control datepicker">
                      </td>
                      <td>
                          <input type="text" name="total_detail[]" style="text-align:right" class="form-control text-right autonumeric" > 
                      </td>
                      <td>
                          <input type="text" name="cicilan_detail[]"  style="text-align:right" class="form-control text-right autonumeric" > 
                      </td>
                      <td>
                          <input type="text" name="totalbayar_detail[]"  style="text-align:right" class="form-control text-right autonumeric" > 
                      </td>
                      <td>
                        <input type="text" name="keterangan_detail[]"  class="form-control">
                      </td>
                      <td>
                        <div class='btn btn-danger btn-sm rmv'>Hapus</div>
                      </td>
              </tr>`)

    $('#detailList tbody').append(detailRow)

    initAutoNumeric(detailRow.find('.autonumeric'))

    $('.supplier-lookup').last().lookup({
      title: 'supplier Lookup',
      fileName: 'supplier',
      onSelectRow: (supplier, element) => {
        element.val(supplier.namasupplier)
      }
    })
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
</script>
@endpush()