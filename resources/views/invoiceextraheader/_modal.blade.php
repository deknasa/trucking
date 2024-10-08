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
            <div class="row form-group">
              <input type="hidden" name="id" hidden class="form-control" readonly>

              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">no bukti <span class="text-danger"></span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" readonly name="nobukti" class="form-control">
              </div>

              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">TGL BUKTI <span class="text-danger">*</span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <div class="input-group">
                  <input type="text" name="tglbukti" class="form-control datepicker">
                </div>
              </div>
            </div>


            <div class="row form-group">

              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">CUSTOMER <span class="text-danger">*</span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="agen" id="agen" class="form-control agen-lookup">
                <input type="text" id="agenId" name="agen_id" readonly hidden>
              </div>

            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  TGL JATUH TEMPO <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <div class="input-group">
                  <input type="text" name="tgljatuhtempo" class="form-control datepicker">
                </div>
              </div>
            </div>
            <input type="text" name="nominal" readonly hidden id="nominal">



            <div class="table-responsive table-scroll">
              <table class="table table-bordered table-bindkeys" style="width: 1000px;">
                <thead>
                  <tr>
                    <th width="2%" class="tbl_aksi">Aksi</th>
                    <th width="2%">No</th>
                    <th width="70%">keterangan</th>
                    <th width="26%">nominal</th>
                  </tr>
                </thead>
                <tbody id="table_body" class="form-group">
                </tbody>
                <tfoot>
                  <tr>
                    <td class="tbl_aksi">
                      <div type="button" class="my-1" id="addRow"><span><i class="far fa-plus-square"></i></span></div>
                    </td>
                    <td colspan=""></td>

                    <td class="font-weight-bold"> Total : </td>
                    <td id="sumary" class="text-right font-weight-bold"> </td>
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
  let rowIndex = 0;
  let isEditTgl

  $(document).ready(function() {

    $("#crudForm [name]").attr("autocomplete", "off");
    $(document).on('click', "#addRow", function() {

      event.preventDefault()

      let method = `POST`
      let url = `${apiUrl}invoiceextraheader/addrow`
      let form = $('#crudForm')
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()

      $('#crudForm').find(`[name="nominal_detail[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'nominal_detail[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominal_detail[]"]`)[index])
      })

      $('#crudForm').find(`[name="detail_persentasediscount[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'detail_persentasediscount[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="detail_persentasediscount[]"]`)[index])
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

    $(document).on('input', `#table_body [name="nominal_detail[]"]`, function(event) {
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
        name: 'button',
        value: button
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
        name: 'tgldariheader',
        value: $('#tgldariheader').val()
      })
      data.push({
        name: 'tglsampaiheader',
        value: $('#tglsampaiheader').val()
      })
      data.push({
        name: 'aksi',
        value: action.toUpperCase()
      })


      let tgldariheader = $('#tgldariheader').val();
      let tglsampaiheader = $('#tglsampaiheader').val()

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
          url = `${apiUrl}invoiceextraheader/${invoiceExtraHeader}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}invoiceextraheader`
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
          if (button == 'btnSubmit') {
            $('#crudForm').trigger('reset')
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
            if (id == 0) {
              $('#detail').jqGrid().trigger('reloadGrid')
            }

            if (response.data.grp == 'FORMAT') {
              updateFormat(response.data)
            }
          } else {

            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
            // showSuccessDialog(response.message, response.data.nobukti)
            createInvoiceExtraHeader()
            $('#crudForm').find('input[type="text"]').data('current-value', '')
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

    if (form.data('action') == 'add') {
      form.find('#btnSaveAdd').show()
    } else {
      form.find('#btnSaveAdd').hide()
    }
    activeGrid = null
    initLookup()
    initDatepicker()
    form.find('#btnSubmit').prop('disabled', false)
    if (form.data('action') == "view") {
      form.find('#btnSubmit').prop('disabled', true)
    }

    // getMaxLength(form)
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
    formData.append('table', 'invoiceextraheader');

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

  function cekValidasi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}invoiceextraheader/${Id}/cekvalidasi`,
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
            window.open(`{{ route('invoiceextraheader.report') }}?id=${Id}&printer=reportPrinterBesar`)
          } else if (Aksi == 'PRINTER KECIL') {
            window.open(`{{ route('invoiceextraheader.report') }}?id=${Id}&printer=reportPrinterKecil`)
          } else {
            cekValidasiAksi(Id, Aksi)
          }
        }
      }
    })
  }

  function cekValidasiAksi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}invoiceextraheader/${Id}/cekvalidasiAksi`,
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
            editInvoiceExtraHeader(Id)
          }
          if (Aksi == 'DELETE') {
            deleteInvoiceExtraHeader(Id)
          }
        }

      }
    })
  }


  function createInvoiceExtraHeader() {
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Add Invoice Extra')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    $('#table_body').html('')
    if (selectedRows.length > 0) {
      clearSelectedRows()
    }
    addRow()

    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    $('#crudForm').find('[name=tgljatuhtempo]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
  }

  function editInvoiceExtraHeader(invoiceExtraHeader) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Invoice Extra')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    Promise
      .all([
        setTglBukti(form),
        showInvoiceExtraHeader(form, invoiceExtraHeader)
      ])
      .then(() => {
        if (selectedRows.length > 0) {
          clearSelectedRows()
        }
        $('#crudModal').modal('show')
        if (isEditTgl == 'TIDAK') {
          form.find(`[name="tglbukti"]`).prop('readonly', true)
          form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
        }
      })
      .catch((error) => {
        showDialog(error.responseJSON)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })

  }

  function deleteInvoiceExtraHeader(invoiceExtraHeader) {
    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-trash"></i>
    Delete
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Invoice Extra')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        showInvoiceExtraHeader(form, invoiceExtraHeader)
      ])
      .then(() => {
        if (selectedRows.length > 0) {
          clearSelectedRows()
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

  function viewInvoiceExtraHeader(invoiceExtraHeader) {
    let form = $('#crudForm')

    form.data('action', 'view')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.find('#btnSubmit').prop('disabled', true)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('View Invoice Extra')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        showInvoiceExtraHeader(form, invoiceExtraHeader)
      ])
      .then(id => {
        setFormBindKeys(form)
        initSelect2(form.find('.select2bs4'), true)
        form.find('[name]').removeAttr('disabled')

        form.find('select').each((index, select) => {
          let element = $(select)

          if (element.data('select2')) {
            element.select2('destroy')
          }
        })

        form.find('[name]').attr('disabled', 'disabled').css({
          background: '#fff'
        })
        form.find('[name=id]').prop('disabled', false)
      })
      .then(() => {
        if (selectedRows.length > 0) {
          clearSelectedRows()
        }
        $('#crudModal').modal('show')
        form.find(`.hasDatepicker`).prop('readonly', true)
        form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').remove()

        let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
        let nameFind = $('#crudForm').find(`[name]`).parents('.input-group')
        name.attr('disabled', true)
        name.find('.lookup-toggler').remove()
        nameFind.find('button.button-clear').remove()
        $('#crudForm').find(`.tbl_aksi`).hide()

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
          showDialog(error.responseJSON)
        }
      })
    }
  }



  function addRow() {

    let detailRow = $(`
    <tr>            
                  <td class="tbl_aksi">
                    <div type="button" class="delete-row"><span><i class="fas fa-trash-alt"></i></span></div>
                  </td>
                  <td>
                    <div class="baris"></div>
                  </td> 
                  <td>
                    <textarea class="form-control" name="keterangan_detail[]" rows="1" placeholder=""></textarea>    
                  </td>                  
                  <td>
                    <input type="text"  name="nominal_detail[]" id="nominal_detail" text-align:right" class="form-control autonumeric nominal number${rowIndex}">
                  </td>      
              </tr>
    `)

    $('table #table_body').append(detailRow)
    initAutoNumeric(detailRow.find('.autonumeric'))
    setRowNumbers()
  }

  function deleteRow(row) {
    let countRow = $('.delete-row').parents('tr').length
    row.remove()
    if (countRow <= 1) {
      addRow()
    }
    setTotal()
    setRowNumbers()
  }

  function setRowNumbers() {
    let elements = $('table #table_body tr td:nth-child(2)')

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
    return new Promise((resolve, reject) => {
      $('#detailList tbody').html('')
      $.ajax({
        url: `${apiUrl}invoiceextraheader/${invoiceExtraHeader}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          sum = 0;
          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)
            if (element.hasClass('datepicker')) {
              element.val(dateFormat(value))
            } else {
              element.val(value)
            }
          })
          $.each(response.detail, (id, detail) => {
            let detailRow = $(`
              <tr>
                    <td class="tbl_aksi">
                     <div type="button" class="delete-row"><span><i class="fas fa-trash-alt"></i></span></div>
                    </td>
                    <td>
                      <div class="baris"></div>
                    </td>
                    
                    <td>
                      <textarea class="form-control" name="keterangan_detail[]" rows="1" placeholder=""></textarea>
                    </td>
                    <td>
                      <input type="text"  name="nominal_detail[]" id="nominal_detail${id}"  style="text-align:right" class="autonumeric nominal form-control">                    
                    </td>  
                </tr>
            `)
            detailRow.find(`[name="nominal_detail[]"]`).val(detail.nominal)
            detailRow.find(`[name="keterangan_detail[]"]`).val(detail.keterangan)
            $('table #table_body').append(detailRow)
            initAutoNumeric(detailRow.find('.autonumeric'))

            setRowNumbers()

            setTotal()
            id++;

            if (form.data('action') === 'delete') {
              form.find('[name]').addClass('disabled')
              initDisabled()
            }
            resolve()
          })
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
      url: `${apiUrl}invoiceextraheader/approval`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        extraId: selectedRows
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

  function setTglJatuhTempo(top = 0) {
    // Tanggal awal dalam format "YYYY-MM-DD"
    const tanggalAwal = new Date();

    // Menambahkan jumlah hari (34 hari)
    const jumlahHari = Math.floor(top);
    tanggalAwal.setDate(tanggalAwal.getDate() + jumlahHari);

    // Mendapatkan tanggal setelah ditambahkan 34 hari
    const tahun = tanggalAwal.getFullYear();
    const bulan = String(tanggalAwal.getMonth() + 1).padStart(2, "0"); // Ditambah 1 karena Januari dimulai dari 0
    const tanggal = String(tanggalAwal.getDate()).padStart(2, "0");

    $('#crudForm').find("[name=tgljatuhtempo]").val(tanggal + "-" + bulan + "-" + tahun);
    $('#crudForm').find("[name=tgljatuhtempo]").prop('readonly', true);
    $('#crudForm').find("[name=tgljatuhtempo]").parent('.input-group').find('.input-group-append').children().prop('disabled', true);
    // $('#crudForm').find("[name=tgljatuhtempo]").parent('.input-group').find('.input-group-append').remove()


  }

  function initLookup() {
    // 
    $('.agen-lookup').lookupV3({
      title: 'Customer Lookup',
      fileName: 'agenV3',
      // searching: ['namaagen'],
      labelColumn: false,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (agen, element) => {
        element.val(agen.namaagen)
        setTglJatuhTempo(agen.top);
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

  const setTglBukti = function(form) {
    return new Promise((resolve, reject) => {
      let data = [];
      data.push({
        name: 'grp',
        value: 'EDIT TANGGAL BUKTI'
      })
      data.push({
        name: 'subgrp',
        value: 'INVOICE EXTRA'
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