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
                <input type="hidden" name="id" hidden class="form-control" readonly>

              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>nobukti <span class="text-danger">*</span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" readonly name="nobukti" class="form-control">
              </div>

              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>tglbukti <span class="text-danger">*</span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" name="tglbukti" class="form-control datepicker">
              </div>
            </div>

            
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>agen <span class="text-danger">*</span>  </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" name="agen" class="form-control agen-lookup">
                <input type="text" id="agenId" name="agen_id" readonly hidden >
              </div>
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>pelanggan  <span class="text-danger">*</span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" name="pelanggan" class="form-control pelanggan-lookup">
                <input type="text" id="pelangganId" name="pelanggan_id" readonly hidden >
              </div>
              
            </div>
            <input type="text" name="nominal" readonly hidden id="nominal" >

             
            
            
            <table class="table table-bordered table-bindkeys">
              <thead>
                <tr>
                  <th width="50">No</th>
                  <th>keterangan</th>
                  <th>harga</th>
                  <th width="50">Aksi</th>
                </tr>
              </thead>
              <tbody id="table_body" class="form-group">
              </tbody>
              <tfoot>
                <tr>
                  <td colspan=""></td>
                  
                  <td class="font-weight-bold"> Total : </td>
                  <td id="sumary" class="text-right font-weight-bold">  </td>
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
  let modalBody = $('#crudModal').find('.modal-body').html()
  let rowIndex = 0;
  $(document).ready(function() {
    
    $(document).on('click', "#addRow", function() {
      addRow()
    });

    $(document).on('click', '.rmv', function(event) {
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
      let invoiceExtraHeader = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()

      $('#crudForm').find(`[name="nominal_detail[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'nominal_detail[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominal_detail[]"]`)[index])
      })

      $('#crudForm').find(`[name="detail_persentasediscount[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'detail_persentasediscount[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="detail_persentasediscount[]"]`)[index])
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
          url = `${apiUrl}invoiceextraheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}invoiceextraheader/${invoiceExtraHeader}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}invoiceextraheader/${invoiceExtraHeader}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}invoiceextraheader`
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
    initLookup()
    initDatepicker()

    // getMaxLength(form)
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    $('#crudModal').find('.modal-body').html(modalBody)
    
  })


  function createInvoiceExtraHeader() {
    resetRow()
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create Invoice Extra')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    addRow()

    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date()) ).trigger('change');
  }

  function editInvoiceExtraHeader(invoiceExtraHeader) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Invoice Extra')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    showInvoiceExtraHeader(form, invoiceExtraHeader)
    
  }

  function deleteInvoiceExtraHeader(invoiceExtraHeader) {
    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Invoice Extra')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    showInvoiceExtraHeader(form, invoiceExtraHeader)

  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}invoiceextraheader/field_length`,
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

  
  
  function addRow() {

    let detailRow = $(`
    <tr class="trow">
                  <td>
                    <div class="baris">1</div>
                  </td> 
                  <td>
                    <input type="text"  name="keterangan_detail[]" style="" class="form-control">                    
                  </td>                  
                  <td>
                    <input type="text"  name="nominal_detail[]" id="nominal_detail" text-align:right" class="form-control autonumeric nominal number${rowIndex}">
                  </td>                  
                  <td>
                    <div class='btn btn-danger btn-sm rmv'>Hapus</div>
                  </td>
              </tr>
    `)
    
    $('table #table_body').append(detailRow)
    initAutoNumeric(detailRow.find('.autonumeric'))
    setRowNumbers()
  }
  
  function deleteRow(row) {
    row.remove()
    setTotal()
    setRowNumbers()
  }

  function resetRow() {
    $('.trow').remove()
  }

  function setRowNumbers() {
    let elements = $('#detailList tbody tr td:nth-child(1)')

    elements.each((index, element) => {
      $(element).text(index + 1)
    })
  }

  function cal(id) {
    harga = $(`#nominal_detail${id}`)[0];
    harga = AutoNumeric.getNumber(harga);
    

  }

  function setTotal() {
    let nominalDetails = $(`#table_body [name="nominal_detail[]"]`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });
    $(`#nominal`).val(total);
    new AutoNumeric('#sumary').set(total)
  }

  function showInvoiceExtraHeader(form, invoiceExtraHeader) {
    resetRow()
    $.ajax({
      url: `${apiUrl}invoiceextraheader/${invoiceExtraHeader}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        sum =0;
        $.each(response.data, (index, value) => {
          let element = form.find(`[name="${index}"]`)
          if(element.attr("name") == 'tglbukti'){
            var result = value.split('-');
            element.val(result[2]+'-'+result[1]+'-'+result[0]);
          }else{
            element.val(value)
          }
        })
        $.each(response.detail, (id, detail) => {
          let detailRow = $(`
            <tr class="trow">
                  <td>
                    <div class="baris">1</div>
                  </td>
                  
                  <td>
                    <input type="text"  name="keterangan_detail[]" style="" class="form-control">                    
                  </td>
                  <td>
                    <input type="text"  name="nominal_detail[]" id="nominal_detail${id}"  style="text-align:right" class="autonumeric nominal form-control">                    
                  </td>  
                  <td>
                    <div class='btn btn-danger btn-sm rmv'>Hapus</div>
                  </td>
              </tr>
          `)
          detailRow.find(`[name="nominal_detail[]"]`).val(detail.nominal)
          detailRow.find(`[name="keterangan_detail[]"]`).val(detail.keterangan)
          $('table #table_body').append(detailRow)
          initAutoNumeric(detailRow.find('.autonumeric'))

          setRowNumbers()
         
          id++;
        })
        

      }
    })
  }

  function initLookup() {
    $('.pelanggan-lookup').lookup({
        title: 'pelanggan Lookup',
        fileName: 'pelanggan',
        beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },        
        onSelectRow: (pelanggan, element) => {
          element.val(pelanggan.namapelanggan)
          $(`#${element[0]['name']}Id`).val(pelanggan.id)
          element.data('currentValue', element.val())
        },
        onCancel: (element) => {
          element.val(element.data('currentValue'))
        },
        onClear: (element) => {
          $(`#${element[0]['name']}Id`).val('')
        element.val('')
        element.data('currentValue', element.val())
      }
      })
      $('.agen-lookup').lookup({
        title: 'agen Lookup',
        fileName: 'agen',
        beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },        
        onSelectRow: (agen, element) => {
          element.val(agen.namaagen)
          $(`#${element[0]['name']}Id`).val(agen.id)
          element.data('currentValue', element.val())
        },
        onCancel: (element) => {
          element.val(element.data('currentValue'))
        },
        onClear: (element) => {
          $(`#${element[0]['name']}Id`).val('')
        element.val('')
        element.data('currentValue', element.val())
      }
      })
  }
</script>
@endpush()