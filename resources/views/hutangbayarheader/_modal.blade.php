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
                  BANK <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-8 col-md-10">
                <input type="hidden" name="bank_id">
                <input type="text" name="bank" class="form-control bank-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  SUPPLIER <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-8 col-md-10">
                <input type="hidden" name="supplier_id">
                <input type="text" name="supplier" class="form-control supplier-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  COA <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-8 col-md-10">
                <input type="text" name="akunpusat" class="form-control akunPusat-lookup">
              </div>
            </div>

            <table class="table table-bordered table-bindkeys" id="detailList">
              <thead>
                <tr>
                  <th width="50">No</th>
                  <th>No Bukti Hutang</th>
                  <th>Nominal</th>
                  <th>Cicilan</th>
                  <th>Alat Bayar</th>
                  <th>Tgl Cair</th>
                  <th>Potongan</th>
                  <th>Keterangan</th>
                  <th>Aksi</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td></td>
                  <td>
                    <input type="text" name="hutang_nobukti[]" class="form-control hutangHeader-lookup">
                  </td>
                  <td>
                    <input type="text" name="nominal_detail[]" style="text-align:right" class="form-control text-right autonumeric nominal">
                  </td>
                  <td>
                    <input type="text" name="cicilan_detail[]" style="text-align:right" class="form-control text-right autonumeric">
                  </td>
                  <td>
                    <input type="hidden" name="alatbayar_id[]">
                    <input type="text" name="alatbayar[]" class="form-control alatBayar-lookup">
                  </td>
                  <td>
                    <input type="text" name="tglcair[]" class="form-control datepicker">
                  </td>
                  <td>
                    <input type="text" name="potongan_detail[]" style="text-align:right" class="form-control text-right autonumeric">
                  </td>
                  <td>
                    <input type="text" name="keterangan_detail[]" class="form-control">
                  </td>
                  <td>
                    <div class='btn btn-danger btn-sm rmv'>Hapus</div>
                  </td>
                </tr>

              </tbody>
              <tfoot>
              <tr>
                  <td colspan="7">
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

    $("#addRow").click(function() {
      addRow()
    });

    $(document).on('keyup', '.nominal', function(e) {
      calculateSum()
    })

    $(document).on('click', '.delete-row', function(event) {
      deleteRow($(this).parents('tr'))
      deleteSum()
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

      $('#crudForm').find(`[name="cicilan_detail[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'cicilan_detail[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="cicilan_detail[]"]`)[index])
      })

      $('#crudForm').find(`[name="potongan_detail[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'potongan_detail[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="potongan_detail[]"]`)[index])
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
          url = `${apiUrl}hutangbayarheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}hutangbayarheader/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}hutangbayarheader/${Id}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}hutangbayarheader`
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
          $('#crudModal').modal('hide')
          $('#crudModal').find('#crudForm').trigger('reset')

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

  function createHutangBayarHeader() {
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.data('action', 'add')
    $('#crudModalTitle').text('Add Hutang Bayar')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
  }

  function editHutangBayarHeader(id) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    $('#crudModalTitle').text('Edit Hutang Bayar')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    showHutangBayarHeader(form, id)
  }


  function deleteHutangBayarHeader(id) {
    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    $('#crudModalTitle').text('Delete Hutang Bayar')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    showHutangBayarHeader(form, id)
  }

  function showHutangBayarHeader(form, id) {
    $('#detailList tbody').html('')

    $.ajax({
      url: `${apiUrl}hutangbayarheader/${id}`,
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
        })

        $.each(response.detail, (index, detail) => {
          let detailRow = $(`
                <tr>
                  <td></td>
                  <td>
                    <input type="text" name="hutang_nobukti[]" class="form-control hutangHeader-lookup">
                  </td>
                  <td>
                    <input type="text" name="nominal_detail[]" style="text-align:right" class="form-control text-right autonumeric nominal">
                  </td>
                  <td>
                    <input type="text" name="cicilan_detail[]" style="text-align:right" class="form-control text-right autonumeric">
                  </td>
                  <td>
                    <input type="hidden" name="alatbayar_id[]">
                    <input type="text" name="alatbayar[]" class="form-control alatBayar-lookup">
                  </td>
                  <td>
                    <input type="text" name="tglcair[]" class="form-control datepicker">
                  </td>
                  <td>
                    <input type="text" name="potongan_detail[]" style="text-align:right" class="form-control text-right autonumeric">
                  </td>
                  <td>
                    <input type="text" name="keterangan_detail[]" class="form-control">
                  </td>
                  <td>
                        <div class='btn btn-danger btn-sm delete-row '>Hapus</div>
                      </td>
                </tr>`)

          detailRow.find(`[name="hutang_nobukti[]"]`).val(detail.hutang_nobukti)
          detailRow.find(`[name="nominal_detail[]"]`).val(detail.nominal)
          detailRow.find(`[name="cicilan_detail[]"]`).val(detail.cicilan)
          detailRow.find(`[name="alatbayar_id[]"]`).val(detail.alatbayar_id)
          detailRow.find(`[name="alatbayar[]"]`).val(detail.alatbayar)
          detailRow.find(`[name="tglcair[]"]`).val(dateFormat(detail.tglcair))
          detailRow.find(`[name="potongan_detail[]"]`).val(detail.potongan)
          detailRow.find(`[name="keterangan_detail[]"]`).val(detail.keterangan)

          initAutoNumeric(detailRow.find(`[name="nominal_detail[]"]`))
          initAutoNumeric(detailRow.find(`[name="cicilan_detail[]"]`))
          initAutoNumeric(detailRow.find(`[name="potongan_detail[]"]`))

          initDatepicker(detailRow.find('.datepicker'))

          $('#detailList tbody').append(detailRow)

          $('#lookup').hide()

          $('.hutangHeader-lookup').last().lookup({
            title: 'hutangheader Lookup',
            fileName: 'hutangheader',
            onSelectRow: (hutangheader, element) => {
              element.val(hutangheader.nobukti)
            }
          })

          $('.alatBayar-lookup').last().lookup({
            title: 'alatbayar Lookup',
            fileName: 'alatbayar',
            onSelectRow: (alatbayar, element) => {
              $('#crudForm [name=alatbayar]').first().val(alatbayar.namaalatbayar)
              element.val(alatbayar.id)
            }
          })

        })

        setRowNumbers()
      }
    })
  }

  function addRow() {
    let detailRow = $(`
    <tr>
                  <td></td>
                  <td>
                    <input type="text" name="hutang_nobukti[]" class="form-control hutangHeader-lookup">
                  </td>
                  <td>
                    <input type="text" name="nominal_detail[]" style="text-align:right" class="form-control text-right autonumeric nominal">
                  </td>
                  <td>
                    <input type="text" name="cicilan_detail[]" style="text-align:right" class="form-control text-right autonumeric">
                  </td>
                  <td>
                    <input type="hidden" name="alatbayar_id[]">
                    <input type="text" name="alatbayar[]" class="form-control alatBayar-lookup">
                  </td>
                  <td>
                    <input type="text" name="tglcair[]" class="form-control datepicker">
                  </td>
                  <td>
                    <input type="text" name="potongan_detail[]" style="text-align:right" class="form-control text-right autonumeric">
                  </td>
                  <td>
                    <input type="text" name="keterangan_detail[]" class="form-control">
                  </td>
                  <td>
            <div class='btn btn-danger btn-sm delete-row'>Hapus</div>
          </td>
                </tr>`)

    $('#detailList tbody').append(detailRow)
    initDatepicker(detailRow.find('.datepicker'))
    initAutoNumeric(detailRow.find('.autonumeric'))

    $('.hutangHeader-lookup').last().lookup({
      title: 'hutangheader Lookup',
      fileName: 'hutangheader',
      onSelectRow: (hutangheader, element) => {
        element.val(hutangheader.nobukti)
      }
    })

    $('.alatBayar-lookup').last().lookup({
      title: 'alatbayar Lookup',
      fileName: 'alatbayar',
      onSelectRow: (alatbayar, element) => {
        $('#crudForm [name=alatbayar]').first().val(alatbayar.namaalatbayar)
        element.val(alatbayar.id)
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

  function calculateSum() {
    var sum = 0;
    //iterate through each textboxes and add the values
    $(".nominal").each(function() {
      let number = this.value
      let hrg = parseFloat(number.replaceAll(',', ''));
      console.log(hrg)
      if (!isNaN(hrg) && hrg.length != 0) {
        sum += parseFloat(hrg);
      }
    });
    sum = new Intl.NumberFormat('en-US').format(sum);

    $("#total").html(`${sum}`);
    new AutoNumeric('#total', {
      decimalPlaces: '2'
    })
  }

  function deleteSum() {
    var sum = 0;
    //iterate through each textboxes and add the values
    $(".nominal").each(function() {
      let number = this.value
      let hrg = parseFloat(number.replaceAll(',', ''));
      if (!isNaN(hrg) && hrg.length != 0) {
        sum -= parseFloat(hrg);
      }
    });
    sum = new Intl.NumberFormat('en-US').format(sum);
    console.log(sum)

    $("#total").html(`${sum}`);
    new AutoNumeric('#total', {
      decimalPlaces: '2'
    })
  }
</script>
@endpush()