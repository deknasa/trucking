<div class="modal modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
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
                  <div class="input-group">
                    <input type="text" name="tglbukti" class="form-control datepicker">
                  </div>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-12 col-md-2 col-form-label">
                  <label>
                    TGL TERIMA <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-12 col-md-4">
                  <div class="input-group">
                    <input type="text" name="tglterima" class="form-control datepicker">
                  </div>
                </div>

              </div>

              <div class="row form-group">
                <div class="col-12 col-md-2 col-form-label">
                  <label>
                    AGEN <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-12 col-md-4">
                  <input type="hidden" name="agen_id">
                  <input type="text" name="agen" class="form-control agen-lookup">
                </div>

                <div class="col-12 col-md-2 col-form-label text-right">
                  <label>
                    Jenis Order <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-12 col-md-4">
                  <input type="hidden" name="jenisorder_id">
                  <input type="text" name="jenisorder" class="form-control jenisorder-lookup">
                </div>
              </div>

              <div class="row form-group">
                <div class="col-12 col-md-2 col-form-label">
                  <label>
                    TGL DARI <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-12 col-md-4">
                  <div class="input-group">
                    <input type="text" name="tgldari" class="form-control datepicker">
                  </div>
                </div>

                <div class="col-12 col-md-2 col-form-label text-right">
                  <label>
                    TGL SAMPAI <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-12 col-md-4">
                  <div class="input-group">
                    <input type="text" name="tglsampai" class="form-control datepicker">
                  </div>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-md-2">
                  <button class="btn btn-secondary" id="btnTampil">TAMPIL</button>
                </div>
              </div>

            </div>

            <div class="table-responsive">
              <table class="table table-bordered table-bindkeys" id="spList" style="width:1800px">
                <thead class="table-secondary">
                  <tr>
                    <th width="2%"></th>
                    <th width="5%">JOB TRUCKING</th>
                    <th width="5%">TGL OTOBON</th>
                    <th width="5%">NO CONT</th>
                    <th width="8%">TARIF</th>
                    <th width="8%">OMSET</th>
                    <th width="10%">RETRIBUSI</th>
                    <th width="8%">BAGIAN</th>
                    <th width="15%">EMKL</th>
                    <th width="5%">LONG TRIP</th>
                    <th width="5%">PERALIHAN</th>
                    <th width="15%">KETERANGAN</th>
                  </tr>
                </thead>
                <tbody>

                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="5">
                      <p class="font-weight-bold">TOTAL:</p>
                    </td>
                    <td>
                      <p id="omset" class="text-right font-weight-bold"></p>
                    </td>
                    <td>
                      <p id="retribusi" class="text-right font-weight-bold"></p>
                    </td>

                    <td colspan="5"></td>
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

    $('#crudForm').autocomplete({
      disabled: true
    });
    $(document).on('input', `#table_body [name="nominal_detail[]"]`, function(event) {
      setTotal()
    })
    $(document).on('input', `#spList tbody [name="nominalretribusi[]"]`, function(event) {
      setNominalRetribusi()
    })

    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()

       $('#crudForm').find(`[name="nominalretribusi[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'nominalretribusi[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominalretribusi[]"]`)[index])
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
          url = `${apiUrl}invoiceheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}invoiceheader/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}invoiceheader/${Id}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}invoiceheader`
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

          if (id == 0) {
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
    let nominalDetails = $(`#table_body [name="omset[]"]`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#total').set(total)
  }

  function setNominalRetribusi() {
    let nominalDetails = $(`#spList tbody [name="nominalretribusi[]"]:not([disabled])`)
    let total = 0

    console.log(nominalDetails)
    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#retribusi').set(total)
  }

  function createInvoiceHeader() {
    let form = $('#crudForm')

    $('#crudModal').find('#crudForm').trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
    form.data('action', 'add')
    $('#crudModalTitle').text('Create Invoice')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    $('#crudForm').find('[name=tglterima]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    $('#crudForm').find('[name=tgldari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    $('#crudForm').find('[name=tglsampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    initDatepicker()
  }

  function editInvoiceHeader(invId) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
      Simpan
    `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Invoice')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()


    showInvoiceHeader(form, invId, 'edit')

  }

  function deleteInvoiceHeader(invId) {
    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Hapus
    `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Invoice')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    showInvoiceHeader(form, invId, 'delete')
  }

  $(document).on('click', '#btnTampil', function(event) {
    event.preventDefault()
    let form = $('#crudForm')
    let data = []

    data.push({
      name: 'agen_id',
      value: form.find(`[name="agen_id"]`).val()
    })
    data.push({
      name: 'jenisorder_id',
      value: form.find(`[name="jenisorder_id"]`).val()
    })
    data.push({
      name: 'tgldari',
      value: form.find(`[name="tgldari"]`).val()
    })
    data.push({
      name: 'tglsampai',
      value: form.find(`[name="tglsampai"]`).val()
    })
    data.push({
      name: 'limit',
      value: 0
    })

    let tgldari = form.find(`[name="tgldari"]`).val()
    let tglsampai = form.find(`[name="tglsampai"]`).val()
    console.log()
    if (data[0].value != '' && data[1].value != '' && data[2].value != '' && data[3].value != '') {

      if (tgldari > tglsampai) {
        showDialog('Tanggal dari tidak boleh melebihi tanggal sampai')
      }
      $('#spList tbody').html('')
      $('#omset').html('')
      $.ajax({
        url: `${apiUrl}invoiceheader/getSP`,
        method: 'GET',
        dataType: 'JSON',
        data: data,
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {

          if (response.errors == true) {
            showDialog(response.message)
          } else {
            let omset = 0
            $.each(response.data, (index, detail) => {

              omset = parseFloat(omset) + parseFloat(detail.omset)
              let cekLongtrip = detail.statuslongtrip == 65 ? "checked" : "";
              let cekPeralihan = detail.statusperalihan == 67 ? "checked" : "";
              let detailRow = $(`
                              <tr >
                                  <td><input name='sp_id[]' type="checkbox" class="checkItem" value="${detail.id}" checked></td>
                                  <td>${detail.jobtrucking}</td>
                                  <td>${detail.tglsp}</td>
                                  <td>${detail.nocont}</td>
                                  <td>${detail.tarif_id}</td>
                                  <td class="omset text-right">${detail.omset}</td>
                                  <td id="ret${detail.id}"><input type="text" name="nominalretribusi[]" class="form-control text-right"></td>
                                  <td>${detail.jenisorder_id}</td>
                                  <td>${detail.agen_id}</td>
                                  <td><input name='statuslongtrip[]' type="checkbox" value="${detail.statuslongtrip}" ${cekLongtrip} disabled></td>
                                  <td><input name='statusperalihan[]' type="checkbox" value="${detail.statusperalihan}" ${cekPeralihan} disabled></td>
                                  <td>${detail.keterangan}</td>
                              </tr>
                          `)

              $('#spList tbody').append(detailRow)
              initAutoNumeric(detailRow.find('.omset'))
              initAutoNumeric(detailRow.find(`[name="nominalretribusi[]"]`))
              setNominalRetribusi()
            })

            $('#omset').append(`${omset}`)

            initAutoNumeric($('#spList tfoot').find('#omset'))

          }
        },
        error: error => {
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
            setErrorMessages(form, error.responseJSON.errors);
            showDialog(error.responseJSON.message)
          } else {
            showDialog(error.statusText)
          }
        }
      })
    } else {
      showDialog('Harap memilih agen, jenis order, tgl dari serta tgl sampai')
    }
  })


  function showInvoiceHeader(form, invId, aksi) {
    $('#spList tbody').html('')

    $.ajax({
      url: `${apiUrl}invoiceheader/${invId}`,
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

        if (aksi == 'delete') {
          form.find('[name]').addClass('disabled')
          initDisabled()
        }
        getEdit(invId, aksi)
      }
    })
  }

  function getEdit(invId, aksi) {
    let form = $('#crudForm')
    let data = []

    data.push({
      name: 'agen_id',
      value: form.find(`[name="agen_id"]`).val()
    })
    data.push({
      name: 'jenisorder_id',
      value: form.find(`[name="jenisorder_id"]`).val()
    })
    data.push({
      name: 'tgldari',
      value: form.find(`[name="tgldari"]`).val()
    })
    data.push({
      name: 'tglsampai',
      value: form.find(`[name="tglsampai"]`).val()
    })
    data.push({
      name: 'limit',
      value: 0
    })

    $.ajax({
      url: `${apiUrl}invoiceheader/${invId}/getEdit`,
      method: 'GET',
      dataType: 'JSON',
      data: data,
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {

        let omset = 0
        let disabled = aksi == 'delete' ? "disabled" : "";
        $.each(response.data, (index, detail) => {
          omset = parseFloat(omset) + parseFloat(detail.omset)

          let cekLongtrip = detail.statuslongtrip == 65 ? "checked" : "";
          let cekPeralihan = detail.statusperalihan == 67 ? "checked" : "";
          let detailRow = $(`
                  <tr >
                      <td><input name='sp_id[]' type="checkbox" class="checkItem" value="${detail.id}" checked></td>
                      <td>${detail.jobtrucking}</td>
                      <td>${detail.tglsp}</td>
                      <td>${detail.nocont}</td>
                      <td>${detail.tarif_id}</td>
                      <td class="omset text-right">${detail.omset}</td>
                      <td id="ret${detail.id}"><input type="text" name="nominalretribusi[]" class="form-control text-right" value="${detail.nominalretribusi}"></td>
                      <td>${detail.jenisorder_id}</td>
                      <td>${detail.agen_id}</td>
                      <td><input name='statuslongtrip[]' type="checkbox" value="${detail.statuslongtrip}" ${cekLongtrip} disabled></td>
                      <td><input name='statusperalihan[]' type="checkbox" value="${detail.statusperalihan}" ${cekPeralihan} disabled></td>
                      <td>${detail.keterangan}</td>
                  </tr>
              `)

          $('#spList tbody').append(detailRow)
          initAutoNumeric(detailRow.find('.omset'))
          initAutoNumeric(detailRow.find(`[name="nominalretribusi[]"]`))
          setNominalRetribusi()
        })

        $('#omset').append(`${omset}`)

        initAutoNumeric($('#spList tfoot').find('#omset'))


      }
    })
  }


  $(document).on('click', `#spList tbody [name="sp_id[]"]`, function() {
    let tdOmset = $(this).closest('tr').find('td.omset').text()
    tdOmset = parseFloat(tdOmset.replaceAll(',', ''));

    let allOmset = $('#omset').text()
    allOmset = parseFloat(allOmset.replaceAll(',', ''));
    let nominal = 0

    if ($(this).prop("checked") == true) {
      allOmset = allOmset + tdOmset
      $(this).closest('tr').find(`td [name="nominalretribusi[]"]`).prop('disabled', false)
      setNominalRetribusi()
    } else {
      allOmset = allOmset - tdOmset
      // $(this).closest('tr').find(`td [name="nominalretribusi[]"]`).prop('disabled', true)
      $(this).closest('tr').find(`td [name="nominalretribusi[]"]`).remove();
      let newRetElement = `<input type="text" name="nominalretribusi[]" class="form-control text-right" disabled>`
      let id = $(this).val()
      $(this).closest('tr').find(`#ret${id}`).append(newRetElement)
      initAutoNumeric($(this).closest("tr").find(`td [name="nominalretribusi[]"]`))
      setNominalRetribusi()
    }

    $('#omset').html('')
    $('#omset').append(`${allOmset}`)
    initAutoNumeric($('#spList tfoot').find('#omset'))
  })


  function setRowNumbers() {
    let elements = $('#spList tbody tr td:nth-child(1)')

    elements.each((index, element) => {
      $(element).text(index + 1)
    })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}invoiceheader/field_length`,
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

  function cekValidasi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}invoiceheader/${Id}/cekvalidasi`,
      method: 'POST',
      dataType: 'JSON',
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      success: response => {
        var kodenobukti = response.kodenobukti
        if (kodenobukti == '1') {
          var kodestatus = response.kodestatus
          if (kodestatus == '1') {
            showDialog(response.message['keterangan'])
          } else {
            if (Aksi == 'EDIT') {
              editInvoiceHeader(Id)
            }
            if (Aksi == 'DELETE') {
              deleteInvoiceHeader(Id)
            }
          }

        } else {
          showDialog(response.message['keterangan'])
        }
      }
    })
  }


  function initLookup() {
    $('.agen-lookup').lookup({
      title: 'Agen Lookup',
      fileName: 'agen',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (agen, element) => {
        $('#crudForm [name=agen_id]').first().val(agen.id)
        element.val(agen.namaagen)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        console.log(element.val())
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=agen_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.jenisorder-lookup').lookup({
      title: 'Jenis Order Lookup',
      fileName: 'jenisorder',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (jenisorder, element) => {
        $('#crudForm [name=jenisorder_id]').first().val(jenisorder.id)
        element.val(jenisorder.keterangan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=jenisorder_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

  }
</script>
@endpush()