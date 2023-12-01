<div class="modal modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="crudForm">
      <div class="modal-content">
        
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

                  <input type="text" name="tglbukti"  class="form-control  datepicker" readonly>
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
                <input type="text" name="nobukti" class="form-control"  readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  CUSTOMER <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="agen_id" class="form-control" readonly>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  NOMINAL <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="nominal" class="form-control autonumeric" readonly>
              </div>
            </div>
            

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  TGL BAYAR
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="tglbayar" class="form-control  datepicker" >
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  BAYAR
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="bayar" class="form-control autonumeric">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  SISA <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="sisa" class="form-control autonumeric" readonly>
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
  let modalBody = $('#crudModal').find('.modal-body').html()
  $(document).ready(function() {
    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let invoicelunaskepusatId = form.find('[name=id]').val()
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
        case 'store':
          method = 'POST'
          url = `${apiUrl}invoicelunaskepusat`

          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}invoicelunaskepusat/${invoicelunaskepusatId}/update`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}invoicelunaskepusat/${invoicelunaskepusatId}/delete`
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
          indexRow = response.data.position - 1;
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

            let errorMessages = error.responseJSON.errors

            
            if (errorMessages['tglbukti'] && errorMessages['tglbukti'].length > 0) {
              form.find(`[name=tglbukti]`).addClass("is-invalid")
              $(`
                <div class="invalid-feedback">
                ${errorMessages['tglbukti'][0].toLowerCase()}
                </div>
              `).appendTo(form.find(`[name=tglbukti]`).parent())
            }
            
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
    initDatepicker('datepickerIndex')
  })


  function createInvoicelunaskepusat(invoiceheader_id) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'store')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Input Pelunasan Invoice Ke Pusat')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    // $('#crudForm').find('[name=tglbukti]').val($('#tglshow').val()).trigger('change');
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    Promise
      .all([
        // showDefault(form),
        showInvoicelunaskepusat(form, invoiceheader_id)
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

  function editInvoicelunaskepusat(invoiceheader_id) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Absen')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    Promise
      .all([
        showInvoicelunaskepusat(form, invoiceheader_id)
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

  function deleteInvoicelunaskepusat(invoiceheader_id) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Absen')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    Promise
      .all([
        showInvoicelunaskepusat(form, invoiceheader_id)
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


  function showInvoicelunaskepusat(form, invoiceheader_id) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}invoicelunaskepusat/${invoiceheader_id}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data :{
          tanggal : $('#tglbukti').val()
        },
        success: response => {
          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)
            if (element.attr("name") == 'tglbukti') {
              if (value) {
                let result = value.split('-');

                element.val(result[2] + '-' + result[1] + '-' + result[0]);
              }
            } else {
              element.val(value)
            }
          })
 
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

  function cekValidasi(invoiceheader_id, aksi) {
    $.ajax({
      url: `${apiUrl}invoicelunaskepusat/${invoiceheader_id}/cekvalidasi`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data :{
          tanggal : $('#tglshow').val()
        },
      success: response => {
        if (response.errors) {
          showDialog(response.message)
        } else {
          if (aksi == 'edit') {
            editAbsensi(invoiceheader_id)
          } else {
            deleteAbsensi(invoiceheader_id)
          }
        }
      }
    })
  }

  function cekValidasiAdd(invoiceheader_id) {
    $.ajax({
      url: `${apiUrl}invoicelunaskepusat/${invoiceheader_id}/cekvalidasiadd`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data :{
          periode : $('#periode').val()
      },
      success: response => {
        if (response.errors) {
          showDialog(response.message)
        } else {
          createInvoicelunaskepusat(invoiceheader_id)
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