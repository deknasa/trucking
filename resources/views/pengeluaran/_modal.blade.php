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
            <input type="hidden" name="id">

            <div class="row form-group">
              <div class="col-12 col-sm-2 col-md-2">
                <label class="col-form-label">
                  NO BUKTI <span class="text-danger"></span>
                </label>
              </div>
              <div class="col-12 col-sm-4 col-md-4">
                <input type="text" name="nobukti" class="form-control" readonly>
              </div>

              <div class="col-12 col-sm-2 col-md-2">
                <label class="col-form-label">
                  TGL BUKTI <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-4 col-md-4">
                <div class="input-group">
                  <input type="text" name="tglbukti" class="form-control datepicker">
                </div>
              </div>
            </div>



            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  DIBAYAR KE
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="dibayarke" class="form-control">
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


            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  PENERIMA
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <select name="penerima_id[]" id="multiple" class="select2bs4 form-control" multiple="multiple"></select>
              </div>
            </div>


            <div class="row form-group bmt" style="display: none;">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  NO BUKTI PENERIMAAN
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="nobukti_penerimaan" class="form-control bmt-lookup">
              </div>
            </div>

            <div class="overflow scroll-container mb-2">
              <div class="table-container">
                <table class="table table-bordered table-bindkeys" id="detailList" style="width: 1500px;">
                  <thead>
                    <tr>
                      <th style="width: 10px; min-width: 10px;">No</th>
                      <th style="width: 180px; min-width: 180px;">Nama Perkiraan</th>
                      <th style="width: 350px; min-width: 350px;">Keterangan</th>
                      <th style="width: 180px; min-width: 180px;">Nominal</th>
                      <th style="width: 180px; min-width: 180px;">No warkat</th>
                      <th style="width: 150px; min-width: 150px;">Tgl jatuh tempo</th>
                      <th style="width: 210px; min-width: 210px;">No Invoice</th>
                      <th style="width: 210px; min-width: 210px;">Bank</th>
                      <th style="width: 10px; min-width: 10px;" class="aksiBmt tbl_aksi">Aksi</th>
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
                      <td colspan="4"></td>
                      <td class="aksiBmt tbl_aksi">
                        <button type="button" class="btn btn-primary btn-sm my-2" id="addRow">Tambah</button>
                      </td>
                    </tr>
                  </tfoot>
                </table>
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
  let bankId
  let isEditTgl

  $(document).ready(function() {

    $("#crudForm [name]").attr("autocomplete", "off");

    $(document).on('click', "#addRow", function() {
      event.preventDefault()
      let method = `POST`
      let url = `${apiUrl}pengeluaranheader/addrow`
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
      if ($(`#crudForm [name="alatbayar"]`).val() != 'GIRO') {
        $('#crudForm').find(`[name="tgljatuhtempo[]"]`).val($(this).val()).trigger('change');
      }
    });


    $(document).on('change', `#table_body [name="tgljatuhtempo[]"]`, function() {
      if ($(`#crudForm [name="alatbayar"]`).val() == 'GIRO') {
        $('#crudForm').find(`[name="tgljatuhtempo[]"]`).val($(this).val());
      }
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
        value: data.find(item => item.name === "bank_id").value
      })
      let tgldariheader = $('#tgldariheader').val();
      let tglsampaiheader = $('#tglsampaiheader').val()
      let bankheader = data.find(item => item.name === "bank_id").value

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}pengeluaranheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}pengeluaranheader/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}pengeluaranheader/${Id}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&bankheader=${bankheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
          break;
        case 'editcoa':
          method = 'POST'
          url = `${apiUrl}pengeluaranheader/${Id}/editcoa`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}pengeluaranheader`
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
          $('#bankheader').val(response.data.bank_id).trigger('change')

          // $('.select2').select2({
          //   width: 'resolve',
          //   theme: "bootstrap4"
          // });
          $('#rangeHeader').find('[name=tgldariheader]').val(dateFormat(response.data.tgldariheader)).trigger('change');
          $('#rangeHeader').find('[name=tglsampaiheader]').val(dateFormat(response.data.tglsampaiheader)).trigger('change');
          $('#jqGrid').jqGrid('setGridParam', {
            page: response.data.page,
            postData: {
              bank_id: response.data.bank_id,
              tgldari: dateFormat(response.data.tgldariheader),
              tglsampai: dateFormat(response.data.tglsampaiheader),
              proses: 'reload'
            }
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

    getMaxLength(form)
    form.find('#btnSubmit').prop('disabled', false)
    if (form.data('action') == "view") {
      form.find('#btnSubmit').prop('disabled', true)
    }
    initLookup()
    initSelect2(form.find('.select2bs4'), true)
    $('#multiple')
      .select2({
        theme: 'bootstrap4',
        width: '100%',
      })
    initDatepicker()
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    removeEditingBy($('#crudForm').find('[name=id]').val())
    $('#crudModal').find('.modal-body').html(modalBody)
    initDatepicker('datepickerIndex')
  })

  function removeEditingBy(id) {
    $.ajax({
      url: `{{ config('app.api_url') }}bataledit`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        id: id,
        aksi: 'BATAL',
        table: 'pengeluaranheader'

      },
      success: response => {
        $("#crudModal").modal("hide")
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

  function createPengeluaran() {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.data('action', 'add')

    $('#crudModalTitle').text('Add Pengeluaran Kas/bank')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()


    $('#table_body').html('')
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');


    Promise
      .all([
        setStatusJenisTransaksiOptions(form),
        setPenerimaOptions(form),
      ])
      .then(() => {
        showDefault(form)
          .then(() => {
            if (bankId == 3) {
              $('.bmt').show()
            } else {
              $('.bmt').hide()
            }
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            $('#crudModal').modal('show')
            addRow()
            enableTglJatuhTempo(form)
          })
          .catch((error) => {
            showDialog(error.responseJSON)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })

    setTotal()
  }


  function showDefault(form) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}pengeluaranheader/default`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          bank_id: $('#bankheader').val(),
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


  function editPengeluaran(id) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')
    form.data('action', 'edit')
    // form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    $('#crudModalTitle').text('Edit Pengeluaran Kas/bank')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setTglBukti(form),
        setStatusJenisTransaksiOptions(form),
        setPenerimaOptions(form),

        // $('#detailList tbody').remove()
      ])
      .then(() => {
        showPengeluaran(form, id)
          .then(() => {
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }

            enableTglJatuhTempo(form)
            enableNoWarkat(form)
            $('#crudModal').modal('show')
            if (isEditTgl == 'TIDAK') {
              form.find(`[name="tglbukti"]`).prop('readonly', true)
              form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
            }
            $('#crudForm').find(`[name="bank"]`).parents('.input-group').children().attr('disabled', true)
            $('#crudForm').find(`[name="bank"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled', true)
            $('#crudForm').find(`[name="bank"]`).attr('disabled', false).attr('readonly', true)
            $('#crudForm').find('[name="bank_id"]').attr('readonly', true);
            $('#crudForm').find(`[name="alatbayar"]`).parents('.input-group').children().attr('disabled', true)
            $('#crudForm').find(`[name="alatbayar"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled', true)
            $('#crudForm').find(`[name="alatbayar"]`).attr('disabled', false).attr('readonly', true)
            $('#crudForm').find('[name="alatbayar_id"]').attr('readonly', true);
          })
          .catch((error) => {
            showDialog(error.responseJSON)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })



  }

  function editCoa(id) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')
    form.data('action', 'editcoa')
    penerimaanGiro = ''
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    $('#crudModalTitle').text('Edit Kode Perkiraan')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    Promise
      .all([
        setTglBukti(form),
        setStatusJenisTransaksiOptions(form),
        setPenerimaOptions(form),
      ])
      .then(() => {
        showPengeluaran(form, id)
          .then(() => {
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').remove()
            // let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
            // name.attr('readonly', true)
            // name.find('.lookup-toggler').attr('disabled', true)
            // name.find('.lookup-toggler').attr('disabled', true)
            $('#crudForm').find(`.tbl_aksi`).hide()
            // // form.find('.aksi').hide()
            // setFormBindKeys(form)
            // initSelect2(form.find('.select2bs4'), true)

            form.find('[name]').attr('readonly', 'readonly').css({
              background: '#fff'
            })

            form.find(`[name="ketcoadebet[]"]`).prop('readonly', false)
            form.find(`[name="coadebet[]"]`).prop('readonly', false)
          })
          .then(() => {
            clearSelectedRows()
            $('#gs_').prop('checked', false)

            enableTglJatuhTempo(form)
            enableNoWarkat(form)
            $('#crudModal').modal('show')
            $('#crudForm [name=tglbukti]').attr('readonly', true)
            $('#crudForm [name=tglbukti]').siblings('.input-group-append').remove()
            $('#crudForm [name=bank]').parent('.input-group').find('.button-clear').remove()
            $('#crudForm [name=bank]').parent('.input-group').find('.input-group-append').remove()
            $('#crudForm [name=alatbayar]').parent('.input-group').find('.button-clear').remove()
            $('#crudForm [name=alatbayar]').parent('.input-group').find('.input-group-append').remove()
            $('#crudForm [name=pelanggan]').parent('.input-group').find('.button-clear').remove()
            $('#crudForm [name=pelanggan]').parent('.input-group').find('.input-group-append').remove()
          })
          .catch((error) => {
            showDialog(error.responseJSON)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  function deletePengeluaran(id) {

    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')
    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-trash"></i>
              Delete
    `)
    $('#crudModalTitle').text('Delete Pengeluaran Kas/bank')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()


    Promise
      .all([
        setStatusJenisTransaksiOptions(form),
        setPenerimaOptions(form),
      ])
      .then(() => {
        showPengeluaran(form, id)
          .then(() => {
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            enableTglJatuhTempo(form)
            enableNoWarkat(form)
            $('#crudModal').modal('show')
          })
          .catch((error) => {
            showDialog(error.responseJSON)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })

  }

  function viewPengeluaran(id) {

    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')
    form.data('action', 'view')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('View Pengeluaran Kas/bank')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()


    Promise
      .all([
        setStatusJenisTransaksiOptions(form),
        setPenerimaOptions(form),
      ])
      .then(() => {
        showPengeluaran(form, id)
          .then(id => {
            // form.find('.aksi').hide()
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
            enableTglJatuhTempo(form)
            enableNoWarkat(form)
            $('#crudModal').modal('show')
            form.find(`.hasDatepicker`).prop('readonly', true)
            form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').remove()
            let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
            let nameFind = $('#crudForm').find(`[name]`).parents('.input-group')
            name.attr('disabled', true)
            name.find('.lookup-toggler').remove()
            nameFind.find('button.button-clear').remove()

            $('.tbl_aksi').hide()
          })
          .catch((error) => {
            showDialog(error.responseJSON)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })

  }

  function cekValidasi(Id, Aksi, nobukti) {
    $.ajax({
      url: `{{ config('app.api_url') }}pengeluaranheader/${Id}/cekvalidasi`,
      method: 'POST',
      dataType: 'JSON',
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      data: {
        aksi: Aksi,
        nobukti: nobukti
      },
      success: response => {
        var error = response.error
        if (error) {
          // if (response.force) {
          //   showConfirmForce(response.message, Id)
          // } else {
            showDialog(response)
          // }
        } else {
          if (Aksi == 'PRINTER BESAR') {
            window.open(`{{ route('pengeluaranheader.report') }}?id=${Id}&printer=reportPrinterBesar`)
          } else if (Aksi == 'PRINTER KECIL') {
            window.open(`{{ route('pengeluaranheader.report') }}?id=${Id}&printer=reportPrinterKecil`)
          } else {
            cekValidasiAksi(Id, Aksi)
          }
        }
        // var kodenobukti = response.kodenobukti
        // if (kodenobukti == '1') {
        //   var kodestatus = response.kodestatus
        //   if (kodestatus == '1') {
        //     showDialog(response.message['keterangan'])
        //   } else {
        //     if (Aksi == 'PRINTER BESAR') {
        //       window.open(`{{ route('pengeluaranheader.report') }}?id=${Id}&printer=reportPrinterBesar`)
        //     } else if (Aksi == 'PRINTER KECIL') {
        //       window.open(`{{ route('pengeluaranheader.report') }}?id=${Id}&printer=reportPrinterKecil`)
        //     } else {
        //       cekValidasiAksi(Id, Aksi)
        //     }
        //   }

        // } else {
        //   showDialog(response.message['keterangan'])
        // }
      }
    })
  }


  function cekValidasiAksi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}pengeluaranheader/${Id}/cekValidasiAksi`,
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
            editPengeluaran(Id)
          }
          if (Aksi == 'DELETE') {
            deletePengeluaran(Id)
          }
        }
        // var kondisi = response.kondisi
        // if (kondisi == true) {
        //   if (response.editcoa) {
        //     if (Aksi == 'EDIT') {
        //       editCoa(Id)
        //     } else {
        //       showDialog(response.message['keterangan'])
        //     }
        //   } else {
        //     showDialog(response.message['keterangan'])
        //   }
        // } else {
        //   if (Aksi == 'EDIT') {
        //     editPengeluaran(Id)
        //   }
        //   if (Aksi == 'DELETE') {
        //     deletePengeluaran(Id)
        //   }
        // }
      }
    })
  }

  const setStatusJenisTransaksiOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusjenistransaksi]').empty()
      relatedForm.find('[name=statusjenistransaksi]').append(
        new Option('-- PILIH STATUS JENIS TRANSAKSI --', '', false, true)
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
              "data": "JENIS TRANSAKSI"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusJenisTransaksi => {
            let option = new Option(statusJenisTransaksi.text, statusJenisTransaksi.id)

            relatedForm.find('[name=statusjenistransaksi]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function showPengeluaran(form, id) {
    console.log(id);
    return new Promise((resolve, reject) => {
      $('#detailList tbody').html('')

      $.ajax({
        url: `${apiUrl}pengeluaranheader/${id}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          let tgl = response.data.tglbukti

          let penerimaIds = []
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

            if (index == 'pelanggan') {
              element.data('current-value', value)
            }
            if (index == 'alatbayar') {
              element.data('current-value', value)
            }
            if (index == 'bank') {
              element.data('current-value', value)
            }
            if (index == 'nobukti_penerimaan') {
              element.data('current-value', value)
            }
          })

          if (bankId == 3) {
            $('.bmt').show()
          } else {
            $('.bmt').hide()
          }
          response.detailpenerima.forEach((penerima) => {
            penerimaIds.push(penerima.penerima_id)
          })

          form.find(`[name="penerima_id[]"]`).val(penerimaIds).change()

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
                      <input type="text" name="keterangan_detail[]"  class="form-control">
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
                      <input type="text" name="noinvoice[]" class="form-control">
                  </td>
                  <td>
                      <input type="text" name="bank_detail[]" class="form-control">
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
            detailRow.find(`[name="noinvoice[]"]`).val(detail.noinvoice)
            detailRow.find(`[name="bank_detail[]"]`).val(detail.bank)

            initAutoNumericMinus(detailRow.find(`[name="nominal_detail[]"]`))

            detailRow.find(`[name="tgljatuhtempo[]"]`).val(dateFormat(detail.tgljatuhtempo))
            $('#detailList>#table_body').append(detailRow)

            setTotal();

            $('.akunpusat-lookup').last().lookup({
              title: 'Kode Perk. Lookup',
              fileName: 'akunpusat',
              beforeProcess: function(test) {
                // var levelcoa = $(`#levelcoa`).val();
                this.postData = {
                  levelCoa: '3',
                  Aktif: 'AKTIF',
                }
              },
              onSelectRow: (akunpusat, element) => {
                $(`#crudForm [name="coadebet[]"]`).last().val(akunpusat.coa)
                element.val(akunpusat.keterangancoa)
                element.data('currentValue', element.val())
              },
              onCancel: (element) => {
                element.val(element.data('currentValue'))
              },
              onClear: (element) => {
                $(`#crudForm [name="coadebet[]"]`).last().val('')
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
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function addRow() {

    let isTheFirstRow = $('#table_body tr').length;
    let detailRow = $(`
      <tr>
        <td></td>
        <td>
            <input type="hidden" name="coadebet[]">
            <input type="text" name="ketcoadebet[]"  class="form-control akunpusat-lookup">
        </td>
       
        <td>
          <input type="text" name="keterangan_detail[]"  class="form-control">
        </td>
        <td>
          <input type="text" name="nominal_detail[]" class="form-control autonumeric nominal"> 
        </td>
        <td>
          <input type="text" name="nowarkat[]"  class="form-control">
        </td>
        <td>
          <div class="input-group">
            <input type="text" name="tgljatuhtempo[]" class="form-control">   
          </div>
        </td>
        <td>
          <div class="input-group">
            <input type="text" name="noinvoice[]" class="form-control">   
          </div>
        </td>
        <td>
          <div class="input-group">
            <input type="text" name="bank_detail[]" class="form-control">   
          </div>
        </td>
        <td>
            <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
        </td>
      </tr>
    `)

    $('#detailList>#table_body').append(detailRow)


    $('.akunpusat-lookup').last().lookup({
      title: 'Kode Perkiraan Lookup',
      fileName: 'akunpusat',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {
          levelCoa: '3',
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (akunpusat, element) => {
        $(`#crudForm [name="coadebet[]"]`).last().val(akunpusat.coa)
        element.val(akunpusat.keterangancoa)
        element.data('currentValue', element.val())

        enableTglJatuhTempo($(`#crudForm`))
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))

        enableTglJatuhTempo($(`#crudForm`))
      },
      onClear: (element) => {
        $(`#crudForm [name="coadebet[]"]`).last().val('')
        element.val('')
        element.data('currentValue', element.val())

        enableTglJatuhTempo($(`#crudForm`))
      }
    })
    initAutoNumericMinus(detailRow.find(`[name="nominal_detail[]"]`))
    tglbukti = $('#crudForm').find(`[name="tglbukti"]`).val()
    if (isTheFirstRow == 0) {
      detailRow.find(`[name="tgljatuhtempo[]"]`).addClass('first-input');
      detailRow.find(`[name="tgljatuhtempo[]"]`).val(tglbukti).trigger('change');
    } else {
      let firstDateVal = $('#table_body tr:first').find(`[name="tgljatuhtempo[]"]`).val();
      detailRow.find(`[name="tgljatuhtempo[]"]`).val(firstDateVal).trigger('change');
    }
    enableTglJatuhTempo(detailRow)
    enableNoWarkat(detailRow)
    setRowNumbers()
  }

  function enableTglJatuhTempo(el) {
    if ($(`#crudForm [name="alatbayar"]`).val() == 'GIRO') {
      el.find(`[name="tgljatuhtempo[]"]`).addClass('datepicker')
      el.find(`[name="tgljatuhtempo[]"]`).attr('readonly', false)
      initDatepicker()
      el.find(`[name="tgljatuhtempo[]"]`).parent('.input-group').find('.input-group-append').show()
    } else {
      el.find(`[name="tgljatuhtempo[]"]`).removeClass('datepicker')
      el.find(`[name="tgljatuhtempo[]"]`).parent('.input-group').find('.input-group-append').hide()
      el.find(`[name="tgljatuhtempo[]"]`).val($('#crudForm').find(`[name="tglbukti"]`).val()).trigger('change');
      el.find(`[name="tgljatuhtempo[]"]`).attr('readonly', true)
    }
  }

  function enableNoWarkat(el) {
    if ($(`#crudForm [name="alatbayar"]`).val() != 'TUNAI') {
      el.find(`[name="nowarkat[]"]`).attr('readonly', false)
    } else {
      el.find(`[name="nowarkat[]"]`).attr('readonly', true)
      el.find(`[name="nowarkat[]"]`).val('')
    }
  }

  function deleteRow(row) {
    let countRow = $('.delete-row').parents('tr').length
    row.remove()
    if (countRow <= 1) {
      addRow()
    }
    setRowNumbers()
    setTotal()
    initDatepicker()
  }

  function setRowNumbers() {
    let elements = $('#detailList>#table_body>tr>td:nth-child(1)')

    elements.each((index, element) => {
      $(element).text(index + 1)
    })
  }

  function approve() {

    event.preventDefault()

    let form = $('#crudForm')
    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')

    $.ajax({
      url: `${apiUrl}pengeluaranheader/approval`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        pengeluaranId: selectedRows,
        bukti: selectedbukti,
        table: 'pengeluaranheader',
        statusapproval: 'statusapproval',
      },
      success: response => {
        $('#crudForm').trigger('reset')
        $('#crudModal').modal('hide')

        $('#jqGrid').jqGrid().trigger('reloadGrid');
        selectedRows = []
        selectedbukti = []
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
        url: `${apiUrl}pengeluaranheader/field_length`,
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

  function initLookup() {

    $('.pelanggan-lookup').lookup({
      title: 'Shipper Lookup',
      fileName: 'pelanggan',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',

        }
      },
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
        enableTglJatuhTempo($(`#crudForm`))
        enableNoWarkat($(`#crudForm`))
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
          from: 'pengeluaran'
        }
      },
      onSelectRow: (bank, element) => {
        $('#crudForm [name=bank_id]').first().val(bank.id)

        bankId = bank.id

        if (bankId == 3) {
          $('.bmt').show()
        } else {
          $('.bmt').hide()
        }
        element.val(bank.namabank)
        element.data('currentValue', element.val())
        $('#crudForm [name=alatbayar_id]').first().val('')
        $('#crudForm [name=alatbayar]').first().val('')
        $('#crudForm [name=alatbayar]').data('currentValue', '')
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=bank_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
        $('#crudForm [name=alatbayar_id]').first().val('')
        $('#crudForm [name=alatbayar]').first().val('')
        $('#crudForm [name=alatbayar]').data('currentValue', '')
      }
    })

    $('.bmt-lookup').lookup({
      title: 'Penerimaan Kas/Bank Lookup',
      fileName: 'penerimaan',
      beforeProcess: function(test) {
        this.postData = {
          bankId: bankId,
          isBmt: true,
          nobuktiBmt: $('#crudForm [name=nobukti_penerimaan]').val()
        }
      },
      onSelectRow: (penerimaan, element) => {
        $('#table_body').html('')
        $('.aksiBmt').hide()
        element.val(penerimaan.nobukti)
        getBMT(penerimaan.id)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('.aksiBmt').show()
        $('#table_body').html('')
        addRow();
        element.val('')
        element.data('currentValue', element.val())
      }
    })
  }

  function getBMT(bmtId) {
    $.ajax({
      url: `${apiUrl}penerimaandetail/getDetail`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        'Authorization': `Bearer ${accessToken}`
      },
      data: {
        penerimaan_id: bmtId
      },
      success: response => {
        $.each(response.data, (index, detail) => {
          let detailRow = $(`
              <tr>
                  <td></td>
                  <td>
                    <input type="hidden" name="coadebet[]">
                    <input type="text" name="ketcoadebet[]" data-current-value="${detail.ketcoakredit}" class="form-control akunpusat-lookup">
                  </td>                
                  <td>
                      <input type="text" name="keterangan_detail[]"  class="form-control">
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
                      <input type="text" name="noinvoice[]" class="form-control">
                  </td>
                  <td>
                      <input type="text" name="bank_detail[]" class="form-control">
                  </td>
              </tr>
            `)

          detailRow.find(`[name="nowarkat[]"]`).val(detail.nowarkat)
          detailRow.find(`[name="tgljatuhtempo[]"]`).val(detail.tgljatuhtempo)
          detailRow.find(`[name="keterangan_detail[]"]`).val(detail.keterangan)
          detailRow.find(`[name="nominal_detail[]"]`).val(detail.nominal)
          detailRow.find(`[name="coadebet[]"]`).val(detail.coakredit)
          detailRow.find(`[name="ketcoadebet[]"]`).val(detail.ketcoakredit)
          detailRow.find(`[name="noinvoice[]"]`).val(detail.invoice_nobukti)

          initAutoNumericMinus(detailRow.find(`[name="nominal_detail[]"]`))

          detailRow.find(`[name="tgljatuhtempo[]"]`).val(dateFormat(detail.tgljatuhtempo))
          $('#detailList>#table_body').append(detailRow)

          setTotal();

          $('.akunpusat-lookup').last().lookup({
            title: 'Kode Perk. Lookup',
            fileName: 'akunpusat',
            beforeProcess: function(test) {
              // var levelcoa = $(`#levelcoa`).val();
              this.postData = {
                levelCoa: '3',
                Aktif: 'AKTIF',
              }
            },
            onSelectRow: (akunpusat, element) => {
              $(`#crudForm [name="coadebet[]"]`).last().val(akunpusat.coa)
              element.val(akunpusat.keterangancoa)
              element.data('currentValue', element.val())
            },
            onCancel: (element) => {
              element.val(element.data('currentValue'))
            },
            onClear: (element) => {
              $(`#crudForm [name="coadebet[]"]`).last().val('')
              element.val('')
              element.data('currentValue', element.val())
            }
          })


        })
        setRowNumbers()
      },
      error: error => {
        showDialog(error.responseJSON)
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
        value: 'PENGELUARAN KAS/BANK'
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

  function setPenerimaOptions(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name="penerima_id[]"]').empty()

      $.ajax({
        url: `${apiUrl}penerima`,
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
              "field": "statusaktif",
              "op": "eq",
              "data": "AKTIF"
            }, {
              "field": "statuskaryawan",
              "op": "eq",
              "data": "KARYAWAN"
            }]
          }),
        },
        success: response => {
          response.data.forEach(penerima => {
            let option = new Option(penerima.namapenerima, penerima.id)

            relatedForm.find(`[name="penerima_id[]"]`).append(option).trigger('change')
          });

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