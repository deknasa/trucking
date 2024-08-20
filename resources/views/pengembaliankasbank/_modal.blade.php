<div class="modal modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="crudForm">
      <div class="modal-content">
        
        <form action="" method="post">

          <div class="modal-body">
            <input type="hidden" name="id">

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  NO BUKTI <span class="text-danger"></span>
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
                  DIBAYAR KE <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="dibayarke" class="form-control">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  TRANSFER KE ACC
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="transferkeac" class="form-control">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  TRANSFER KE AN
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="transferkean" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  TRANSFER KE BANK
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="transferkebank" class="form-control">
              </div>
            </div>

            <div class="table-scroll table-responsive">
              <table class="table table-bordered table-bindkeys table-fixed" id="detailList" style="width: 1500px ;">
                <thead>
                  <tr>

                    <th width="1%">No</th>
                    <th width="15%">Nama Perkiraan</th>
                    <th width="25%">Keterangan</th>
                    <th width="10%">Nominal</th>
                    <th width="10%">No warkat</th>
                    <th width="10%">Tgl jatuh tempo</th>
                    <th width="10%">Bulan beban</th>
                    <th width="1%" class="tbl_aksi">Aksi</th>

                  </tr>
                </thead>
                <tbody id="table_body" class="form-group">


                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="3">
                      <p class="text-right font-weight-bold">TOTAL :</p>
                    </td>
                    <td>
                      <p class="text-right font-weight-bold autonumeric" id="total"></p>
                    </td>
                    <td colspan="3"></td>
                    <td class="tbl_aksi">
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
  let bankId

  $(document).ready(function() {

    $("#crudForm [name]").attr("autocomplete", "off");

    $(document).on('click', "#addRow", function() {
      event.preventDefault()
      let method = `POST`
      let url = `${apiUrl}pengembaliankasbankheader/addrow`
      let form = $('#crudForm')
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()
      $('#crudForm').find(`[name="nominal_detail[]"`).each((index, element) => {
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

    $(document).on('change', `#crudForm [name="tglbukti"]`, function() {
      $('#crudForm').find(`[name="tgljatuhtempo[]"]`).val($(this).val()).trigger('change');
    });

    $(document).on('click', '.delete-row', function(event) {
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
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()

      $('#crudForm').find(`[name="nominal_detail[]"`).each((index, element) => {
        data.filter((row) => row.name === 'nominal_detail[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominal_detail[]"]`)[index])
      })

      console.log(limit)
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
        name: 'bankheader',
        value: $('#bankheader').val()
      })

      let tgldariheader = $('#tgldariheader').val();
      let tglsampaiheader = $('#tglsampaiheader').val()
      let bankheader = $('#bankheader').val()

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}pengembaliankasbankheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}pengembaliankasbankheader/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}pengembaliankasbankheader/${Id}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&bankheader=${bankheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}pengembaliankasbankheader`
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


          id = response.data.id
          console.log(id)
          $('#crudModal').modal('hide')
          $('#crudModal').find('#crudForm').trigger('reset')

          $('.select2').select2({
            width: 'resolve',
            theme: "bootstrap4"
          });
          $('#jqGrid').jqGrid('setGridParam', {
            page: response.data.page
          }).trigger('reloadGrid');

          if (id == 0) {
            $('#detailGrid').jqGrid().trigger('reloadGrid')
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
        $('#processingLoader').addClass('d-none')
        $(this).removeAttr('disabled')
      })
    })
  })

  $('#crudModal').on('shown.bs.modal', () => {
    let form = $('#crudForm')

    setFormBindKeys(form)

    activeGrid = null

    form.find('#btnSubmit').prop('disabled',false)
    if (form.data('action') == "view") {
      form.find('#btnSubmit').prop('disabled',true)
    }

    getMaxLength(form)
    initLookup()
    initSelect2(form.find('.select2bs4'), true)
    initDatepicker()
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'

    $('#crudModal').find('.modal-body').html(modalBody)
  })

  function setTotal() {
    let nominalDetails = $(`#table_body [name="nominal_detail[]"]`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#total').set(total)
  }

  function createPengembalianKasBank() {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    $('#crudModal').find('#crudForm').trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.data('action', 'add')
    $('#crudModalTitle').text('Add Pengembalian Kas Bank')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    $('#table_body').html('')
    $('#crudForm').find(`[name="tglbukti"]`).val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    Promise
      .all([
        showDefault(form),
        addRow(),
        setTotal()
      ])
      .then(() => {
        $('#crudModal').modal('show')
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }

  function showDefault(form) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}pengembaliankasbankheader/default`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          bankId = response.data.bank_id

          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)
            // let element = form.find(`[name="statusaktif"]`)

            if (index == 'alatbayar') {
              element.data('current-value', value)
            }
            if (index == 'bank') {
              element.data('current-value', value)
            }
            if (element.is('select')) {
              element.val(value).trigger('change')
            } else {
              element.val(value)
            }
          })
          resolve()
        }
      })
    })
  }

  function editPengembalianKasBank(id) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    $('#crudModalTitle').text('Edit Pengembalian Kas Bank')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        showPengembalianKasBank(form, id)
      ])
      .then(() => {
        $('#crudModal').modal('show')
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }

  function deletePengembalianKasBank(id) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-trash"></i>
              Delete
    `)
    $('#crudModalTitle').text('Delete Pengembalian Kas Bank')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        showPengembalianKasBank(form, id)
      ])
      .then(() => {
        $('#crudModal').modal('show')
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }
  function viewPengembalianKasBank(id) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'view')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.find('#btnSubmit').prop('disabled',true)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('View Pengembalian Kas Bank')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        showPengembalianKasBank(form, id)
      ])
      .then(id => {
            setFormBindKeys(form)
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
            form.find('[name=id]').prop('disabled', false);

          })
      .then(() => {
        $('#crudModal').modal('show')
            $('#crudForm').find(`.ui-datepicker-trigger`).attr('disabled', true)
            
            form.find(`.hasDatepicker`).prop('readonly', true)
            form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').remove()
            let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
            let nameFind = $('#crudForm').find(`[name]`).parents('.input-group')
            name.attr('disabled', true)
            name.find('.lookup-toggler').remove()
            nameFind.find('button.button-clear').remove()
            $('.tbl_aksi').hide()
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }

  function approval(Id) {
    $('#processingLoader').removeClass('d-none')

    $.ajax({
      url: `{{ config('app.api_url') }}pengembaliankasbankheader/${Id}/approval`,
      method: 'POST',
      dataType: 'JSON',
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      success: response => {
        $('#jqGrid').trigger('reloadGrid')
      }
    }).always(() => {
      $('#processingLoader').addClass('d-none')
    })
  }

  function cekValidasi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}pengembaliankasbankheader/${Id}/cekvalidasi`,
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

              editPengembalianKasBank(Id)
            }
            if (Aksi == 'DELETE') {
              deletePengembalianKasBank(Id)
            }
          }

        } else {
          showDialog(response.message['keterangan'])
        }
      }
    })
  }


  function showPengembalianKasBank(form, id) {
    return new Promise((resolve, reject) => {
      $('#detailList tbody').html('')

      $('#crudForm [name=tglbukti]').attr('readonly', true)
      $('#crudForm [name=tglbukti]').siblings('.input-group-append').remove()

      $.ajax({
        url: `${apiUrl}pengembaliankasbankheader/${id}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          let tgl = response.data.tglbukti
          let alatbayar = $('#crudForm [name=alatbayar]')
          let bank = $('#crudForm [name=bank]')

          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)
            if (element.is('select')) {
              element.val(value).trigger('change')
              console.log(value);
              // detailRow.find('[name=statusjenistransaksi]').val(detail.statusjenistransaksi).trigger('change');

            } else if (element.hasClass('datepicker')) {
              element.val(dateFormat(value))
            } else {
              element.val(value)
            }


            if (index == 'alatbayar') {
              element.data('current-value', value).prop('readonly', true)
              alatbayar.parents('.input-group').find('.input-group-append').hide()
              alatbayar.parents('.input-group').find('.button-clear').hide()
            }
            if (index == 'bank') {
              element.data('current-value', value).prop('readonly', true)
              bank.parents('.input-group').find('.input-group-append').hide()
              bank.parents('.input-group').find('.button-clear').hide()
            }
          })
          $('#detailList tbody').html('')
          $.each(response.detail, (index, detail) => {
            let detailRow = $(`
              <tr>
                  <td></td>
                  <td>
                    <input type="hidden" name="coadebet[]">
                    <input type="text" name="ketcoadebet[]" data-current-value="${detail.ketcoadebet}" class="form-control akunpusat-lookup">
                  </td>                
                  <td>
                      <textarea class="form-control" name="keterangan_detail[]" rows="1" placeholder=""></textarea>
                  </td>
                  <td>
                      <input type="text" name="nominal_detail[]" class="form-control autonumeric nominal"> 
                  </td>

                  <td>
                      <input type="text" name="nowarkat[]"  class="form-control">
                  </td>
                  <td>
                      <div class="input-group">
                          <input type="text" name="tgljatuhtempo[]" class="form-control datepicker">   
                      </div>
                  </td>
                  <td>
                      <div class="input-group">
                          <input type="text" name="bulanbeban[]" class="form-control datepicker">   
                      </div>
                  </td>
                  <td class="tbl_aksi">
                      <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
                  </td>
              </tr>
            `)

            detailRow.find(`[name="nowarkat[]"]`).val(detail.nowarkat)
            detailRow.find(`[name="tgljatuhtempo[]"]`).val(detail.tgljatuhtempo)
            detailRow.find(`[name="keterangan_detail[]"]`).val(detail.keterangan)
            detailRow.find(`[name="nominal_detail[]"]`).val(detail.nominal)
            detailRow.find(`[name="coadebet[]"]`).val(detail.coadebet)
            detailRow.find(`[name="ketcoadebet[]"]`).val(detail.ketcoadebet)

            detailRow.find(`[name="bulanbeban[]"]`).val(dateFormat(detail.bulanbeban))
            initAutoNumeric(detailRow.find(`[name="nominal_detail[]"]`))

            detailRow.find(`[name="tgljatuhtempo[]"]`).val(dateFormat(detail.tgljatuhtempo))
            $('#detailList tbody').append(detailRow)


            setTotal();

            $('.akunpusat-lookup').last().lookup({
              title: 'Nama Perkiraan (Debet) Lookup',
              fileName: 'akunpusat',
              beforeProcess: function(test) {
                // var levelcoa = $(`#levelcoa`).val();
                this.postData = {
                  Aktif: 'AKTIF',
                  levelCoa: '3',

                }
              },
              onSelectRow: (akunpusat, element) => {
                element.parents('td').find(`[name="coadebet[]"]`).val(akunpusat.coa)
                element.val(akunpusat.keterangancoa)
                element.data('currentValue', element.val())
              },
              onCancel: (element) => {
                element.val(element.data('currentValue'))
              },
              onClear: (element) => {
                element.parents('td').find(`[name="coadebet[]"]`).val('')
                element.val('')
                element.data('currentValue', element.val())
              }
            })

          })

          setRowNumbers()
          initDatepicker()
          if (form.data('action') === 'delete') {
            form.find('[name]').addClass('disabled')
            initDisabled()
          }
          resolve()
        }
      })
    })
  }

  function addRow() {
    let detailRow = $(`
      <tr>
        <td></td>
        <td>
            <input type="hidden" name="coadebet[]">
            <input type="text" name="ketcoadebet[]"  class="form-control akunpusat-lookup">
        </td>
       
        <td>
          <textarea class="form-control" name="keterangan_detail[]" rows="1" placeholder=""></textarea>
        </td>
        <td>
          <input type="text" name="nominal_detail[]" class="form-control autonumeric nominal"> 
        </td>
        <td>
          <input type="text" name="nowarkat[]"  class="form-control">
        </td>
        <td>
          <div class="input-group">
            <input type="text" name="tgljatuhtempo[]" class="form-control datepicker">   
          </div>
        </td>
        <td>
          <div class="input-group">
            <input type="text" name="bulanbeban[]" class="form-control datepicker">   
          </div>
        </td>
        <td class="tbl_aksi">
            <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
        </td>
      </tr>
    `)


    $('#detailList tbody').append(detailRow)

    $('.akunpusat-lookup').last().lookup({
      title: 'Nama Perkiraan (Debet) Lookup',
      fileName: 'akunpusat',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {
          Aktif: 'AKTIF',
          levelCoa: '3',

        }
      },
      onSelectRow: (akunpusat, element) => {
        element.parents('td').find(`[name="coadebet[]"]`).val(akunpusat.coa)
        element.val(akunpusat.keterangancoa)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.parents('td').find(`[name="coadebet[]"]`).val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    initAutoNumeric(detailRow.find('.autonumeric'))
    tglbukti = $('#crudForm').find(`[name="tglbukti"]`).val()
    detailRow.find(`[name="tgljatuhtempo[]"]`).val(tglbukti).trigger('change');
    initDatepicker()
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
    let elements = $('#detailList tbody tr td:nth-child(1)')

    elements.each((index, element) => {
      $(element).text(index + 1)
    })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}pengembaliankasbankheader/field_length`,
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

  function initLookup() {

    $('.alatbayar-lookup').last().lookup({
      title: 'Alat Bayar Lookup',
      fileName: 'alatbayar',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {
          bank_Id: bankId,
          Aktif: 'AKTIF',

        }
      },
      onSelectRow: (alatbayar, element) => {
        $('#crudForm [name=alatbayar_id]').first().val(alatbayar.id)
        element.val(alatbayar.namaalatbayar)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=alatbayar_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.bank-lookup').lookup({
      title: 'Bank Lookup',
      fileName: 'bank',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {
          Aktif: 'AKTIF',
          tipe: 'BANK'

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
</script>
@endpush()