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
          <div class="modal-body">

            <input type="text" name="id" hidden readonly>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  tglbukti <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <div class="input-group">
                  <input type="text" name="tglbukti" class="form-control datepicker" readonly>
                </div>

              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  NO BUKTI <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="invoiceheader_id" readonly>
                <input type="text" name="nobukti" class="form-control" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  CUSTOMER <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="agen_id" class="form-control">
                <input type="text" name="agen" class="form-control" readonly>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  NOMINAL <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="nominal" class="form-control text-right" readonly>
              </div>
            </div>


            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  TGL BAYAR
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <div class="input-group">
                  <input type="text" name="tglbayar" class="form-control  datepicker">
                </div>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  BAYAR
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="bayar" class="form-control text-right">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  NK
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="potongan" class="form-control text-right">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  SISA <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="sisa" class="form-control text-right" readonly>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-start">
            <button id="btnSubmit" class="btn btn-primary">
              <i class="fa fa-save"></i>
              Save
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
  $(document).ready(function() {

    $(document).on('input', `#crudForm [name="bayar"]`, function(event) {
      let nominal = AutoNumeric.getNumber($(`#crudForm [name="nominal"]`)[0])
      let potongan = AutoNumeric.getNumber($(`#crudForm [name="potongan"]`)[0])
      let bayar = AutoNumeric.getNumber($(this)[0])
      sisa = nominal - (bayar + potongan)
      new AutoNumeric($(`#crudForm [name="sisa"]`)[0]).set(sisa)
    })
    $(document).on('input', `#crudForm [name="potongan"]`, function(event) {
      let nominal = AutoNumeric.getNumber($(`#crudForm [name="nominal"]`)[0])
      let bayar = AutoNumeric.getNumber($(`#crudForm [name="bayar"]`)[0])
      let potongan = AutoNumeric.getNumber($(this)[0])
      sisa = nominal - (bayar + potongan)
      new AutoNumeric($(`#crudForm [name="sisa"]`)[0]).set(sisa)
    })

    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let invoicelunaskepusatId = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()
      data.filter((row) => row.name === 'nominal')[0].value = AutoNumeric.getNumber($(`#crudForm [name="nominal"]`)[0])
      data.filter((row) => row.name === 'potongan')[0].value = AutoNumeric.getNumber($(`#crudForm [name="potongan"]`)[0])
      data.filter((row) => row.name === 'bayar')[0].value = AutoNumeric.getNumber($(`#crudForm [name="bayar"]`)[0])
      data.filter((row) => row.name === 'sisa')[0].value = AutoNumeric.getNumber($(`#crudForm [name="sisa"]`)[0])

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

      if (rowNum == 0) {
        data.push({
          name: 'limit',
          value: rowNum
        })
      } else {
        data.push({
          name: 'limit',
          value: limit
        })
      }

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}invoicelunaskepusat`

          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}invoicelunaskepusat/${invoicelunaskepusatId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}invoicelunaskepusat/${invoicelunaskepusatId}?indexRow=${indexRow}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}invoicelunaskepusat`
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
          indexRow = response.data.position;
          // id = response.data.position;
          $('#crudForm').trigger('reset')
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
            showDialog(error.responseJSON)
          }
        },
      }).always(() => {
        $('#processingLoader').addClass('d-none')
        $(this).removeAttr('disabled')
      })

    })
  })

  $('#crudModal').on('shown.bs.modal', () => {

    let form = $('#crudForm')

    setFormBindKeys(form)

    activeGrid = null
    initDatepicker()
    getMaxLength(form)
    // initSelect2()


  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    $('#crudModal').find('.modal-body').html(modalBody)
    initMonthpicker()
  })


  function createInvoicelunaskepusat(invoiceheader_id, nobukti) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'add')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Add Pelunasan Invoice Ke Pusat')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    // $('#crudForm').find('[name=tglbukti]').val($('#tglshow').val()).trigger('change');
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    Promise
      .all([
        // showDefault(form),
        showInvoicelunaskepusat(form, invoiceheader_id, nobukti)
      ])
      .then(() => {
        $('#crudModal').modal('show')
        form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
      })
      .catch((error) => {
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}mandor/field_length`,
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

  function editInvoicelunaskepusat(invoiceheader_id, nobukti) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Pelunasan Invoice Ke Pusat')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    Promise
      .all([
        showInvoicelunaskepusat(form, invoiceheader_id, nobukti)
      ])
      .then(() => {
        $('#crudModal').modal('show')
        form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
      })
      .catch((error) => {
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }

  function deleteInvoicelunaskepusat(invoiceheader_id, nobukti) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-trash"></i>
    Delete
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Pelunasan Invoice Ke Pusat')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    Promise
      .all([
        showInvoicelunaskepusat(form, invoiceheader_id, nobukti)
      ])
      .then(() => {
        $('#crudModal').modal('show')
      })
      .catch((error) => {
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })



  }


  function showInvoicelunaskepusat(form, invoiceheader_id, nobukti) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}invoicelunaskepusat/${invoiceheader_id}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          tanggal: $('#tglbukti').val(),
          nobukti: nobukti
        },
        success: response => {
          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)
            if (element.hasClass('datepicker')) {
              element.val(dateFormat(value))
            } else {
              element.val(value)
            }
          })
          let sisa = parseFloat(response.data.nominal) - (parseFloat(response.data.bayar) + parseFloat(response.data.potongan))

          initAutoNumeric(form.find(`[name="nominal"]`))
          initAutoNumeric(form.find(`[name="bayar"]`))
          initAutoNumeric(form.find(`[name="potongan"]`))
          new AutoNumeric($(`#crudForm [name="sisa"]`)[0]).set(sisa)
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

  function cekValidasi(invoiceheader_id, aksi, nobukti) {
    $.ajax({
      url: `${apiUrl}invoicelunaskepusat/${invoiceheader_id}/cekvalidasi`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        tanggal: $('#tglshow').val(),
        nobukti: nobukti
      },
      success: response => {
        if (response.errors) {
          showDialog(response.message)
        } else {
          if (aksi == 'edit') {
            editInvoicelunaskepusat(invoiceheader_id, nobukti)
          } else {
            deleteInvoicelunaskepusat(invoiceheader_id, nobukti)
          }
        }
      }
    })
  }

  function cekValidasiAdd(invoiceheader_id, nobukti) {
    $.ajax({
      url: `${apiUrl}invoicelunaskepusat/${invoiceheader_id}/cekvalidasiadd`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        periode: $('#periode').val(),
        nobukti: nobukti
      },
      success: response => {
        if (response.errors) {
          showDialog(response.message)
        } else {
          createInvoicelunaskepusat(invoiceheader_id, nobukti)
        }
      }
    })
  }

  // function showDefault(form) {
  //   return new Promise((resolve, reject) => {
  //     $.ajax({
  //       url: `${apiUrl}mandor/default`,
  //       method: 'GET',
  //       dataType: 'JSON',
  //       headers: {
  //         Authorization: `Bearer ${accessToken}`
  //       },
  //       success: response => {
  //         $.each(response.data, (index, value) => {
  //           let element = form.find(`[name="${index}"]`)
  //           // let element = form.find(`[name="statusaktif"]`)

  //           if (element.is('select')) {
  //             element.val(value).trigger('change')
  //           } else {
  //             element.val(value)
  //           }
  //         })
  //         resolve()
  //       },
  //       error: error => {
  //         reject(error)
  //       }
  //     })
  //   })
  // }
</script>
@endpush()