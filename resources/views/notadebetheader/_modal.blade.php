<div class="modal modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="crudForm">
      <div class="modal-content">
        <div class="modal-header">
          <p class="modal-title" id="crudModalTitle"></p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          </button>
        </div>

        <form action="" method="post">
          <input type="hidden" name="id">
          <div class="modal-body">
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  NO BUKTI
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" name="nobukti" class="form-control" readonly>
              </div>
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  TGL BUKTI <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <div class="input-group">
                  <input type="text" name="tglbukti" class="form-control datepicker">
                </div>
              </div>
            </div>


            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  TGL LUNAS <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <div class="input-group">
                  <input type="text" name="tgllunas" class="form-control datepicker">
                </div>
              </div>
            </div>
            <div class="row form-group agen">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">CUSTOMER <span class="text-danger"></span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="agen_id">
                <input type="text" name="agen" class="form-control agen-lookup">
              </div>
            </div>
            <div class="row form-group pelanggan">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">SHIPPER <span class="text-danger"></span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="pelanggan_id">
                <input type="text" name="pelanggan" class="form-control pelanggan-lookup">
              </div>
            </div>


            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  BANK <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="bank_id">
                <input type="text" name="bank" class="form-control bank-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  ALAT BAYAR <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="alatbayar_id">
                <input type="text" name="alatbayar" class="form-control alatbayar-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  NO WARKAT </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="nowarkat" class="form-control">
              </div>
            </div>

            <div class="table-scroll table-responsive">
              <table class="table table-bordered table-bindkeys" id="detailList" style="width: 1000px;">
                <thead>
                  <tr>
                    <th width="2%" class="tbl_aksi">Aksi</th>
                    <th width="2%">No</th>
                    <th width="70%">Keterangan</th>
                    <th width="26%">Nominal</th>
                  </tr>
                </thead>
                <tbody id="table_body" class="form-group">

                </tbody>
                <tfoot>
                  <tr>
                    <td class="tbl_aksi">
                      <div type="button" class="my-1" id="addRow"><span><i class="far fa-plus-square"></i></span></div>
                    </td>
                    <td colspan="2">
                      <p class="text-right font-weight-bold">TOTAL :</p>
                    </td>
                    <td>
                      <p class="text-right font-weight-bold autonumeric" id="total"></p>
                    </td>
                  </tr>
                </tfoot>
              </table>
            </div>
          </div>
          <div class="modal-footer justify-content-start">
            <button id="btnSubmit" class="btn btn-primary">
              <i class="fa fa-save"></i>
              Save
            </button>
            <button id="btnSaveAdd" class="btn btn-success">
              <i class="fas fa-file-upload"></i>
              Save & Add
            </button>
            <button class="btn btn-secondary" data-dismiss="modal">
              <i class="fa fa-times"></i>
              Cancel
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
  let isEditTgl
  let bankId

  $(document).ready(function() {

    $(document).on('click', "#addRow", function() {
      event.preventDefault()
      let method = `POST`
      let url = `${apiUrl}notadebetheader/addrow`
      let form = $('#crudForm')
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()
      $('#crudForm').find(`[name="nominal_detail[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'nominal_detail[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominal_detail[]"]`)[index])
      })
      $.ajax({
        url: url,
        method: method,
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: data,
        success: response => {
          addRow()
          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()
        },
        error: error => {
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
            setErrorMessages(form, error.responseJSON.errors);
          } else {
            showDialog(error.responseJSON)
          }
        },
      }).always(() => {
        $('#processingLoader').addClass('d-none')
        $(this).removeAttr('disabled')
      })
    });

    $(document).on('click', '.delete-row', function(event) {
      deleteRow($(this).parents('tr'))
    })

    $(document).on('input', `#table_body [name="nominal[]"]`, function(event) {
      setTotal()
    })

    $('#btnSubmit').click(function(event) {
      event.preventDefault()
      submit($(this).attr('id'))
    })
    $('#btnSaveAdd').click(function(event) {
      event.preventDefault()
      submit($(this).attr('id'))
    })

    function submit(button) {
      event.preventDefault()
      let method
      let url
      let form = $('#crudForm')
      let userId = form.find('[name=user_id]').val()
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()

      $('#crudForm').find(`[name="nominal_detail[]"`).each((index, element) => {
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
        name: 'info',
        value: info
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
      data.push({
        name: 'aksi',
        value: action.toUpperCase()
      })


      data.push({
        name: 'tgldariheader',
        value: $('#tgldariheader').val()
      })
      data.push({
        name: 'tglsampaiheader',
        value: $('#tglsampaiheader').val()
      })
      data.push({
        name: 'button',
        value: button
      })
      let tgldariheader = $('#tgldariheader').val();
      let tglsampaiheader = $('#tglsampaiheader').val()

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}notadebetheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}notadebetheader/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}notadebetheader/${Id}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}notadebetheader`
          break;
      }

      $(this).attr('disabled', '')
      $('#processingLoader').removeClass('d-none')

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
          if (button == 'btnSubmit') {
            $('#crudModal').modal('hide')

            id = response.data.id
            $('#rangeHeader').find('[name=tgldariheader]').val(dateFormat(response.data.tgldariheader)).trigger('change');
            $('#rangeHeader').find('[name=tglsampaiheader]').val(dateFormat(response.data.tglsampaiheader)).trigger('change');

            $('#jqGrid').jqGrid('setGridParam', {
              page: response.data.page,
              postData: {
                tgldari: dateFormat(response.data.tgldariheader),
                tglsampai: dateFormat(response.data.tglsampaiheader)
              }
            }).trigger('reloadGrid');

            if (response.data.grp == 'FORMAT') {
              updateFormat(response.data)
            }
          } else {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
            $('#crudForm').find('input[type="text"]').data('current-value', '')
            $('#table_body').html('')
            showSuccessDialog(response.message, response.data.nobukti)
            createNotaDebet();
            $('#crudForm').find('[name=tglbukti]').val(dateFormat(response.data.tglbukti)).trigger('change');
          }
        },
        error: error => {
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            setErrorMessages(form, error.responseJSON.errors);
          } else {
            showDialog(error.responseJSON)
          }
        },
      }).always(() => {
        $('#processingLoader').addClass('d-none')
        $(this).removeAttr('disabled')
      })
    }
  })

  $('#crudModal').on('shown.bs.modal', () => {
    let form = $('#crudForm')

    setFormBindKeys(form)

    activeGrid = null

    getMaxLength(form)
    form.find('#btnSubmit').prop('disabled', false)
    if (form.data('action') == "view") {
      form.find('#btnSubmit').prop('disabled', true)
    }
    if (form.data('action') == 'add') {
      form.find('#btnSaveAdd').show()
    } else {
      form.find('#btnSaveAdd').hide()
    }
    initLookup()
    initSelect2(form.find('.select2bs4'), true)
    initDatepicker()
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    removeEditingBy($('#crudForm').find('[name=id]').val())
    $('#crudModal').find('.modal-body').html(modalBody)
    initDatepicker('datepickerIndex')
  })

  function removeEditingBy(id) {

    let formData = new FormData();


    formData.append('id', id);
    formData.append('aksi', 'BATAL');
    formData.append('table', 'notadebetheader');

    fetch(`{{ config('app.api_url') }}removeedit`, {
        method: 'POST',
        headers: {
          'Authorization': `Bearer ${accessToken}`
        },
        body: formData,
        keepalive: true

      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
        $("#crudModal").modal("hide");
      })
      .catch(error => {
        // Handle error
        if (error.status === 422) {
          $('.is-invalid').removeClass('is-invalid');
          $('.invalid-feedback').remove();
          setErrorMessages(form, error.responseJSON.errors);
        } else {
          showDialog(error.responseJSON);
        }
      })
  }

  function setTotal() {
    let nominalDetails = $(`#table_body [name="nominal_detail[]"]`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#total').set(total)
  }

  function createNotaDebet() {
    let form = $('#crudForm')
    // $('.modal-loader').removeClass('d-none')

    form.trigger('reset')
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    $('#crudForm').find('[name=tgllunas]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Add Nota Debet')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        showDefault(form)
      ])
      .then(() => {
        if (selectedRows.length > 0) {
          clearSelectedRows()
        }

        if (accessCabang == 'BITUNG-EMKL') {
          $('.agen').hide()
          $('.pelanggan').show()
        } else {
          $('.agen').show()
          $('.pelanggan').hide()
        }
        $('#crudModal').modal('show')
        addRow()
        setTotal()
      })
      .catch((error) => {
        showDialog(error.responseJSON)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }

  function editNotaDebet(userId) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Nota Debet')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setTglBukti(form)
      ])
      .then(() => {
        showNotaDebet(form, userId)
          .then(() => {
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            $('#crudModal').modal('show')
            if (isEditTgl == 'TIDAK') {
              form.find(`[name="tglbukti"]`).prop('readonly', true)
              form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
            }
            if (accessCabang == 'BITUNG-EMKL') {
              $('.agen').hide()
              $('.pelanggan').show()
            } else {
              $('.agen').show()
              $('.pelanggan').hide()
            }
            $('#crudForm').find(`[name="bank"]`).parents('.input-group').children().attr('disabled', true)
            $('#crudForm').find(`[name="bank"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled', true)
            $('#crudForm').find(`[name="bank"]`).attr('disabled', false).attr('readonly', true)
            $('[name="bank_id"]').attr('readonly', true);
            $('#crudForm').find(`[name="alatbayar"]`).parents('.input-group').children().attr('disabled', true)
            $('#crudForm').find(`[name="alatbayar"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled', true)
            $('#crudForm').find(`[name="alatbayar"]`).attr('disabled', false).attr('readonly', true)
            $('[name="alatbayar_id"]').attr('readonly', true);
          })
          .catch((error) => {
            showDialog(error.responseJSON)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })

  }

  function deleteNotaDebet(userId) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-trash"></i>
    Delete
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Nota Debet')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        showNotaDebet(form, userId)
      ])
      .then(() => {
        if (selectedRows.length > 0) {
          clearSelectedRows()
        }
        if (accessCabang == 'BITUNG-EMKL') {
          $('.agen').hide()
          $('.pelanggan').show()
        } else {
          $('.agen').show()
          $('.pelanggan').hide()
        }
        $('#crudModal').modal('show')
      })
      .catch((error) => {
        showDialog(error.responseJSON)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }

  function viewNotaDebetHeader(userId) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'view')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('View Nota Debet')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        showNotaDebet(form, userId)
      ])
      .then(() => {
        if (selectedRows.length > 0) {
          clearSelectedRows()
        }
        if (accessCabang == 'BITUNG-EMKL') {
          $('.agen').hide()
          $('.pelanggan').show()
        } else {
          $('.agen').show()
          $('.pelanggan').hide()
        }
        $('#crudModal').modal('show')
        form.find(`.hasDatepicker`).prop('readonly', true)
        form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').remove()
        form.find(`.tbl_aksi`).hide()

        form.find('[name]').attr('disabled', 'disabled').css({
          background: '#fff'
        })
        let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
        name.attr('disabled', true)
        name.find('.lookup-toggler').attr('disabled', true)
        name.find('.lookup-toggler').attr('disabled', true)

      })
      .catch((error) => {
        showDialog(error.responseJSON)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }

  function cekValidasi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}notadebetheader/${Id}/cekvalidasi`,
      method: 'POST',
      dataType: 'JSON',
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      data: {
        aksi: Aksi
      },
      success: response => {
        var error = response.error
        if (error) {
          showDialog(response)
        } else {
          if (Aksi == 'PRINTER BESAR') {
            window.open(`{{url('notadebetheader/report/${Id}?printer=reportPrinterBesar')}}`)
          } else if (Aksi == 'PRINTER KECIL') {
            window.open(`{{url('notadebetheader/report/${Id}?printer=reportPrinterKecil')}}`)
          } else {
            cekValidasiAksi(Id, Aksi)
          }
        }
      }
    })
  }

  function cekValidasiAksi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}notadebetheader/${Id}/cekValidasiAksi`,
      method: 'POST',
      dataType: 'JSON',
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      success: response => {
        var error = response.error
        if (error) {
          showDialog(response)
        } else {
          if (Aksi == 'EDIT') {
            editNotaDebet(Id)
          }
          if (Aksi == 'DELETE') {
            deleteNotaDebet(Id)
          }
        }

      }
    })
  }

  function showNotaDebet(form, userId) {
    return new Promise((resolve, reject) => {
      $('#detailList tbody').html('')

      $.ajax({
        url: `${apiUrl}notadebetheader/${userId}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          sum = 0;
          $.each(response.data, (index, value) => {
            bankId = response.data.bank_id
            let element = form.find(`[name="${index}"]`)
            if (element.is('select')) {
              element.val(value).trigger('change')
            } else if (element.hasClass('datepicker')) {
              element.val(dateFormat(value))
            } else {
              element.val(value)
            }

            if (index == 'alatbayar') {
              element.data('current-value', value)
            }
            if (index == 'bank') {
              element.data('current-value', value)
            }

          })

          $('#detailList tbody').html('')
          $.each(response.detail, (index, detail) => {
            let detailRow = $(`
              <tr>
              <td class="tbl_aksi">
                <div type="button" class="delete-row"><span><i class="fas fa-trash-alt"></i></span></div>
              </td>
              <td></td>
              <td>
                <textarea class="form-control" name="keterangan_detail[]" rows="1" placeholder=""></textarea>
              </td>
              <td>
                <input type="text" name="nominal_detail[]" class="form-control nominal autonumeric">
              </td>
            </tr>
            `)

            detailRow.find(`[name="keterangan_detail[]"]`).val(detail.keterangan)
            detailRow.find(`[name="nominal_detail[]"]`).val(detail.lebihbayar)

            initAutoNumeric(detailRow.find(`[name="nominal_detail[]"]`))

            $('#detailList tbody').append(detailRow)

            setTotal();
          })

          setRowNumbers()
          if (form.data('action') === 'delete') {
            form.find('[name]').addClass('disabled')
            initDisabled()
          }
          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }



  function getPelunasan(id) {

    $('#detailList tbody').html('')

    $.ajax({
      url: `${apiUrl}notadebetheader/${id}/getpelunasan`,
      method: 'GET',
      dataType: 'JSON',
      data: {
        limit: 0
      },
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        let totalNominal = 0
        let row = 0
        $.each(response.data, (index, detail) => {
          let id = detail.id
          row++
          let nominal = new Intl.NumberFormat('en-US').format(detail.nominal);
          let nominalbayar = new Intl.NumberFormat('en-US').format(detail.nominalbayar);
          let lebihbayar = new Intl.NumberFormat('en-US').format(detail.lebihbayar);
          totalNominal = parseFloat(totalNominal) + parseFloat(detail.nominal)
          let detailRow = $(`
          <tr>
            <td onclick="select(this)"><input name='pelunasanpiutangdetail_id[]' type="checkbox" id="checkItem" value="${detail.detail_id}"></td>
            <td>${row}</td>
            <td>
              ${detail.nobukti}
              <input type="hidden" value="${detail.nobukti}" disabled name="deatail_nobukti_pelunasan[]"  readonly>
            </td>
            <td>
              ${detail.tglcair}
              <input type="hidden" value="${detail.tglcair}" disabled name="deatail_tglcair_pelunasan[]"  readonly>
            </td>
            <td>
              ${detail.coalebihbayar}
              <input type="hidden" value="${detail.coalebihbayar}" disabled name="deatail_coalebihbayar_pelunasan[]"  readonly>
            </td>
            <td>
              ${nominal}
              <input type="hidden" value="${detail.nominal}" disabled name="deatail_nominal_pelunasan[]"  readonly>
            </td>
            <td>
              ${nominalbayar}
              <input type="hidden" value="${detail.nominalbayar}" disabled name="deatail_nominalbayar_pelunasan[]"  readonly>
            </td>
            <td>
              ${lebihbayar}
              <input type="hidden" value="${detail.lebihbayar}" disabled name="deatail_lebihbayar_pelunasan[]"  readonly>
            </td>
            <input type="hidden" value="${detail.invoice_nobukti}" disabled name="deatail_invoice_nobukti_pelunasan[]" readonly>
            
            <td>
              <textarea disabled name="keterangandetail[]" class="form-control" id=""  rows="1"></textarea>
            </td>
            
          </tr>`)
          $('#detailList tbody').append(detailRow)
        })
        totalNominal = new Intl.NumberFormat('en-US').format(totalNominal);
        $('#nominalPiutang').html(`${totalNominal}`)
      }
    })
  }

  function select(element) {
    var is_checked = $(element).find(`[name="pelunasanpiutangdetail_id[]"]`).is(":checked");
    console.log(is_checked);

    if (!is_checked) {
      $(element).siblings('td').find(`[name="deatail_nobukti_pelunasan[]"]`).prop('disabled', true)
      $(element).siblings('td').find(`[name="deatail_tglcair_pelunasan[]"]`).prop('disabled', true)
      $(element).siblings('td').find(`[name="deatail_coalebihbayar_pelunasan[]"]`).prop('disabled', true)
      $(element).siblings('td').find(`[name="deatail_nominal_pelunasan[]"]`).prop('disabled', true)
      $(element).siblings('td').find(`[name="deatail_nominalbayar_pelunasan[]"]`).prop('disabled', true)
      $(element).siblings('td').find(`[name="deatail_lebihbayar_pelunasan[]"]`).prop('disabled', true)
      $(element).siblings('td').find(`[name="deatail_invoice_nobukti_pelunasan[]"]`).prop('disabled', true)
      $(element).siblings('td').find(`[name="keterangandetail[]"]`).prop('disabled', true)
    } else {

      $(element).siblings('td').find(`[name="deatail_nobukti_pelunasan[]"]`).prop('disabled', false)
      $(element).siblings('td').find(`[name="deatail_tglcair_pelunasan[]"]`).prop('disabled', false)
      $(element).siblings('td').find(`[name="deatail_coalebihbayar_pelunasan[]"]`).prop('disabled', false)
      $(element).siblings('td').find(`[name="deatail_nominal_pelunasan[]"]`).prop('disabled', false)
      $(element).siblings('td').find(`[name="deatail_nominalbayar_pelunasan[]"]`).prop('disabled', false)
      $(element).siblings('td').find(`[name="deatail_lebihbayar_pelunasan[]"]`).prop('disabled', false)
      $(element).siblings('td').find(`[name="deatail_invoice_nobukti_pelunasan[]"]`).prop('disabled', false)
      $(element).siblings('td').find(`[name="keterangandetail[]"]`).prop('disabled', false)

    }
  }

  function getNotaDebet(id) {

    $('#detailList tbody').html('')

    $.ajax({
      url: `${apiUrl}notadebetheader/${id}/getnotadebet`,
      method: 'GET',
      dataType: 'JSON',
      data: {
        limit: 0
      },
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        let totalNominal = 0
        let row = 0
        $.each(response.data, (index, detail) => {
          let id = detail.id
          row++
          let nominal = new Intl.NumberFormat('en-US').format(detail.nominal);
          totalNominal = parseFloat(totalNominal) + parseFloat(detail.nominal)
          let detailRow = $(`
          <tr>
            <td onclick="select(this)"><input name='pelunasanpiutangdetail_id[]' checked type="checkbox" id="checkItem" value="${detail.detail_id}"></td>
            <td>${row}</td>
            <td>
              ${detail.nobukti}
              <input type="hidden" value="${detail.nobukti}" name="deatail_nobukti_pelunasan[]"  readonly>
            </td>
            <td>
              ${detail.tglcair}
              <input type="hidden" value="${detail.tglcair}" name="deatail_tglcair_pelunasan[]"  readonly>
            </td>
            <td>
              ${detail.coalebihbayar}
              <input type="hidden" value="${detail.coalebihbayar}" name="deatail_coalebihbayar_pelunasan[]"  readonly>
            </td>
            <td>
              ${detail.nominal}
              <input type="hidden" value="${detail.nominal}" name="deatail_nominal_pelunasan[]"  readonly>
            </td>
            <td>
              ${detail.nominalbayar}
              <input type="hidden" value="${detail.nominalbayar}" name="deatail_nominalbayar_pelunasan[]"  readonly>
            </td>
            <td>
              ${detail.lebihbayar}
              <input type="hidden" value="${detail.lebihbayar}" name="deatail_lebihbayar_pelunasan[]"  readonly>
            </td>
            
              <input type="hidden" value="${detail.invoice_nobukti}" name="deatail_invoice_nobukti_pelunasan[]" readonly>
            
            
            <td><textarea name="keterangandetail[]" class="form-control" id=""  rows="1">${detail.keterangan}</textarea></td>
          </tr>`)
          $('#detailList tbody').append(detailRow)
        })
        totalNominal = new Intl.NumberFormat('en-US').format(totalNominal);
        $('#nominalPiutang').html(`${totalNominal}`)
      }
    })
  }


  function showDefault(form) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}notadebetheader/default`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          bankId = response.data.bank_id

          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)

            if (element.is('select')) {
              element.val(value).trigger('change')
            } else {
              element.val(value)
            }
          })

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function approve() {

    event.preventDefault()

    let form = $('#crudForm')
    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')

    $.ajax({
      url: `${apiUrl}notadebetheader/approval`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        debetId: selectedRows
      },
      success: response => {
        $('#crudForm').trigger('reset')
        $('#crudModal').modal('hide')

        $('#jqGrid').jqGrid().trigger('reloadGrid');
        selectedRows = []
        $('#gs_').prop('checked', false)
      },
      error: error => {
        if (error.status === 422) {
          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()

          setErrorMessages(form, error.responseJSON.errors);
        } else {
          showDialog(error.responseJSON)
        }
      },
    }).always(() => {
      $('#processingLoader').addClass('d-none')
      $(this).removeAttr('disabled')
    })

  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}notadebetheader/field_length`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
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
          console.log(error);

          showDialog(error.responseJSON)
        }
      })
    }
  }

  function initLookup() {
    $('.agen-lookup').lookup({
      title: 'Customer Lookup',
      fileName: 'agen',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (agen, element) => {
        $('#crudForm').find('[name=agen_id]').val(agen.id)
        element.val(agen.namaagen)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm').find('[name=agen_id]').val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.pelanggan-lookup').lookup({
      title: 'Shipper Lookup',
      fileName: 'pelanggan',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (pelanggan, element) => {
        $('#crudForm').find('[name=pelanggan_id]').val(pelanggan.id)
        element.val(pelanggan.namapelanggan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm').find('[name=pelanggan_id]').val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.alatbayar-lookup').lookup({
      title: 'Alat Bayar Lookup',
      fileName: 'alatbayar',
      beforeProcess: function(test) {
        // const bank_ID=0        
        this.postData = {
          bank_Id: bankId,
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (alatbayar, element) => {
        $(`#crudForm [name="alatbayar_id"]`).first().val(alatbayar.id)
        element.val(alatbayar.namaalatbayar)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $(`#crudForm [name="alatbayar_id"]`).first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.bank-lookup').lookup({
      title: 'Bank Lookup',
      fileName: 'bank',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          withPusat: 0

        }
      },
      onSelectRow: (bank, element) => {
        $('#crudForm [name=bank_id]').first().val(bank.id)

        bankId = bank.id
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
  const setStatusApprovalListOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusapproval]').empty()
      relatedForm.find('[name=statusapproval]').append(
        new Option('-- PILIH STATUS Approval --', '', false, true)
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
              "data": "STATUS APPROVAL"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusApprovalList => {

            let option = new Option(statusApprovalList.text, statusApprovalList.id)

            relatedForm.find('[name=statusapproval]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function addRow() {
    let detailRow = $(`
      <tr>
        <td class="tbl_aksi">
          <div type="button" class="delete-row"><span><i class="fas fa-trash-alt"></i></span></div>
        </td>
        <td></td>
        <td>
          <textarea class="form-control" name="keterangan_detail[]" rows="1" placeholder=""></textarea>
        </td>
        <td>
          <input type="text" name="nominal_detail[]" class="form-control nominal autonumeric">
        </td>
        
      </tr>
    `)

    $('#detailList tbody').append(detailRow)

    initAutoNumeric(detailRow.find('.autonumeric'))

    setRowNumbers()
  }

  function deleteRow(row) {
    let countRow = $('.delete-row').parents('tr').length
    row.remove()
    if (countRow <= 1) {
      addRow()
    }

    setRowNumbers()
    setTotal()
  }

  function setRowNumbers() {
    let elements = $('#detailList tbody tr td:nth-child(2)')

    elements.each((index, element) => {
      $(element).text(index + 1)
    })
  }

  const setTglBukti = function(form) {
    return new Promise((resolve, reject) => {
      let data = [];
      data.push({
        name: 'grp',
        value: 'EDIT TANGGAL BUKTI'
      })
      data.push({
        name: 'subgrp',
        value: 'NOTA DEBET'
      })
      $.ajax({
        url: `${apiUrl}parameter/getparamfirst`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: data,
        success: response => {
          isEditTgl = $.trim(response.text);
          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }
</script>
@endpush()