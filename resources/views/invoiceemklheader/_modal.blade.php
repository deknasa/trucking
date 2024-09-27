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
            <div class="master">
              <input type="hidden" name="id">

              <div class="row form-group">
                <div class="col-12 col-md-2">
                  <label class="col-form-label">
                    NO BUKTI <span class="text-danger"></span>
                  </label>
                </div>
                <div class="col-12 col-md-4">
                  <input type="text" name="nobukti" class="form-control" readonly>
                </div>

                <div class="col-12 col-md-2 ">
                  <label class="col-form-label">
                    TGL BUKTI <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-12 col-md-4">
                  <div class="input-group">
                    <input type="text" name="tglbukti" class="form-control datepicker">
                  </div>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-12 col-md-2">
                  <label class="col-form-label">
                    STATUS INVOICE <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-12 col-md-4">
                  <select name="statusinvoice" class="form-control select2bs4" id="statusinvoice">
                    <option value="">-- PILIH STATUS INVOICE --</option>
                  </select>
                </div>

                <div class="col-12 col-md-2 jenisorder">
                  <label class="col-form-label">
                    JENIS ORDER <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-12 col-md-4 jenisorder">
                  <input type="hidden" name="jenisorder_id">
                  <input type="text" name="jenisorder" class="form-control jenisorder-lookup">
                </div>

              </div>

              <div class="row form-group">

                <div class="col-12 col-md-2">
                  <label class="col-form-label">
                    KAPAL <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-12 col-md-4">
                  <input type="text" name="kapal" class="form-control">
                </div>

                <div class="col-12 col-md-2">
                  <label class="col-form-label">
                    DESTINATION <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-12 col-md-4">
                  <input type="text" name="destination" class="form-control">
                </div>
              </div>

              <div class="row form-group">

                <div class="col-12 col-md-2">
                  <label class="col-form-label">
                    NO INVOICE PAJAK
                  </label>
                </div>
                <div class="col-12 col-md-4">
                  <input type="text" name="nobuktiinvoicepajak" class="form-control" readonly>
                </div>

                <div class="col-12 col-md-2">
                  <label class="col-form-label">
                    KETERANGAN
                  </label>
                </div>
                <div class="col-12 col-md-4">
                  <input type="text" name="keterangan" class="form-control">
                </div>
              </div>

              <div class="row form-group">

              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  ASAL MUAT
                </label>
              </div>
              <div class="col-12 col-md-4">
                  <input type="hidden" name="tujuan_id">
                  <input type="text" name="tujuan" class="form-control tujuan-lookup">
                </div>

              </div>


              <div class="row form-group">
                <div class="col-12 col-md-2">
                  <label class="col-form-label">
                    SHIPPER <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-12 col-md-4">
                  <input type="hidden" name="pelanggan_id">
                  <input type="text" name="pelanggan" class="form-control pelanggan-lookup">
                </div>


                <div class="col-12 col-md-2">
                  <label class="col-form-label">
                    STATUS PAJAK <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-12 col-md-4">
                  <select name="statuspajak" class="form-control select2bs4" id="statuspajak">
                    <option value="">-- PILIH STATUS PAJAK --</option>
                  </select>
                </div>                
              </div>

              <div class="row form-group">
                <div class="col-12 col-md-2">
                  <label class="col-form-label">
                    TGL DARI <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-12 col-md-4">
                  <div class="input-group">
                    <input type="text" name="tgldari" class="form-control datepicker">
                  </div>
                </div>

                <div class="col-12 col-md-2  ">
                  <label class="col-form-label">
                    TGL SAMPAI <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-12 col-md-4">
                  <div class="input-group">
                    <input type="text" name="tglsampai" class="form-control datepicker">
                  </div>
                </div>

              </div>

              <div class="row form-group mb-5">
                <div class="col-md-2">
                  <button class="btn btn-primary" id="btnTampil"><i class="fas fa-sync"></i> RELOAD</button>
                </div>
              </div>

            </div>

            <table id="tableInvoice"></table>

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
  let indexModalRow =0

  $(document).ready(function() {

    $("#crudForm [name]").attr("autocomplete", "off");

    $(document).on('input', `#spList tbody [name="nominalretribusi[]"]`, function(event) {
      setNominalRetribusi()

      let Omset = AutoNumeric.getNumber($(this).closest("tr").find(`td.omset`)[0])
      let Tambahan = AutoNumeric.getNumber($(this).closest("tr").find(`td.tambahan`)[0])
      let Retribusi = $(this).val()
      Retribusi = parseFloat(Retribusi.replaceAll(',', ''));
      Retribusi = Number.isNaN(Retribusi) ? 0 : Retribusi

      let Total = Omset + Tambahan + Retribusi

      $(this).closest("tr").find("td.total").html(Total)

      initAutoNumeric($(this).closest("tr").find("td.total"))

      let getOmset = $('#omset').text()
      getOmset = parseFloat(getOmset.replaceAll(',', ''));

      let getTambahan = $('#tambahan').text()
      getTambahan = parseFloat(getTambahan.replaceAll(',', ''));
      let getRetribusi = $('#retribusi').text()
      getRetribusi = parseFloat(getRetribusi.replaceAll(',', ''));

      let setTotal = getOmset + getTambahan + getRetribusi
      $('#total').html('')
      $('#total').append(`${setTotal}`)
      initAutoNumeric($('#spList tfoot').find('#total'))
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
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      let data = []

      data.push({
        name: 'id',
        value: form.find(`[name="id"]`).val()
      })
      data.push({
        name: 'nobukti',
        value: form.find(`[name="nobukti"]`).val()
      })
      data.push({
        name: 'tglbukti',
        value: form.find(`[name="tglbukti"]`).val()
      })
      data.push({
        name: 'statusinvoice',
        value: form.find(`[name="statusinvoice"]`).val()
      })
      data.push({
        name: 'statuspajak',
        value: form.find(`[name="statuspajak"]`).val()
      })
      data.push({
        name: 'kapal',
        value: form.find(`[name="kapal"]`).val()
      })
      data.push({
        name: 'destination',
        value: form.find(`[name="destination"]`).val()
      })
      data.push({
        name: 'nobuktiinvoicepajak',
        value: form.find(`[name="nobuktiinvoicepajak"]`).val()
      })
      data.push({
        name: 'keterangan',
        value: form.find(`[name="keterangan"]`).val()
      })
      data.push({
        name: 'jenisorder',
        value: form.find(`[name="jenisorder"]`).val()
      })
      data.push({
        name: 'jenisorder_id',
        value: form.find(`[name="jenisorder_id"]`).val()
      })
      data.push({
        name: 'pelanggan',
        value: form.find(`[name="pelanggan"]`).val()
      })
      data.push({
        name: 'pelanggan_id',
        value: form.find(`[name="pelanggan_id"]`).val()
      })
      data.push({
        name: 'tujuan',
        value: form.find(`[name="tujuan"]`).val()
      })
      data.push({
        name: 'tujuan_id',
        value: form.find(`[name="tujuan_id"]`).val()
      })

      data.push({
        name: 'tgldari',
        value: form.find(`[name="tgldari"]`).val()
      })
      data.push({
        name: 'tglsampai',
        value: form.find(`[name="tglsampai"]`).val()
      })
      let selectedRowsInvoice = $("#tableInvoice").getGridParam("selectedRowIds");
      data.push({
        name: 'jumlahdetail',
        value: selectedRowsInvoice.length
      })
      nominal = []
      job_id = []
      nojobemkl = []
      keterangan_detail = []
      keterangan_biaya = []
      $.each(selectedRowsInvoice, function(index, value) {
        dataInvoice = $("#tableInvoice").jqGrid("getLocalRow", value);
        let selectedNominal = (dataInvoice.nominal == undefined) ? 0 : dataInvoice.nominal;


        nominal.push((isNaN(selectedNominal)) ? parseFloat(selectedNominal.replaceAll(',', '')) : selectedNominal)
        job_id.push(dataInvoice.id)
        nojobemkl.push(dataInvoice.nojobemkl)
        keterangan_detail.push(dataInvoice.keterangan_detail)
        keterangan_biaya.push((dataInvoice.keteranganInput)?dataInvoice.keteranganInput:dataInvoice.keterangan_biaya)
      });
      let requestData = {
        'nominal': nominal,
        'job_id': job_id,
        'nojobemkl': nojobemkl,
        'keterangan_detail': keterangan_detail,
        'keterangan_biaya': keterangan_biaya
      };
      data.push({
        name: 'detail',
        value: JSON.stringify(requestData)
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
          url = `${apiUrl}invoiceemklheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}invoiceemklheader/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}invoiceemklheader/${Id}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}invoiceemklheader`
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
            id = response.data.id

            $('#crudModal').find('#crudForm').trigger('reset')
            $('#crudModal').modal('hide')

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
            createInvoiceHeader()
            $('#crudForm').find('input[type="text"]').data('current-value', '')
            $("#tableInvoice")[0].p.selectedRowIds = [];
            $('#tableInvoice').jqGrid("clearGridData");
            $("#tableInvoice")
              .jqGrid("setGridParam", {
                selectedRowIds: []
              })
              .trigger("reloadGrid");
            initAutoNumeric($('.footrow').find(`td[aria-describedby="tableInvoice_nominal"]`).text(0))


          }
        },
        error: error => {
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            errors = error.responseJSON.errors
            $(".ui-state-error").removeClass("ui-state-error");
            $.each(errors, (index, error) => {
              let indexes = index.split(".");
              let angka = indexes[1]

              let element;
              if (indexes[0] == 'sp') {
                return showDialog(error);
              } else if (indexes[0] == 'nominalretribusi') {
                selectedRowsInvoice = $("#tableInvoice").getGridParam("selectedRowIds");
                row = parseInt(selectedRowsInvoice[angka]) - 1;

                element = $(`#tableInvoice tr#${parseInt(selectedRowsInvoice[angka])}`).find(`td[aria-describedby="tableInvoice_${indexes[0]}"]`)
                $(element).addClass("ui-state-error");
                $(element).attr("title", error[0].toLowerCase())

              } else {

                element = form.find(`[name="${indexes[0]}"]`)[0];

                if ($(element).length > 0 && !$(element).is(":hidden")) {
                  $(element).addClass("is-invalid");
                  $(`
                      <div class="invalid-feedback">
                      ${error[0].toLowerCase()}
                      </div>
                      `).appendTo($(element).parent());
                } else {
                  return showDialog(error);
                }
              }
            });
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
    form.find('#btnSubmit').prop('disabled', false)
    if (form.data('action') == "view") {
      form.find('#btnSubmit').prop('disabled', true)
    }

    getMaxLength(form)
    initLookup()
    initDatepicker()
    initSelect2(form.find('.select2bs4'), true)

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
    formData.append('table', 'invoiceemklheader');

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

  function createInvoiceHeader() {
    let form = $('#crudForm')

    $('#crudModal').find('#crudForm').trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.data('action', 'add')
    $('#crudModalTitle').text('Add Invoice')

    initDatepicker()
    loadInvoiceGrid();
    Promise
      .all([
        setStatusInvoice(form),
        setStatusPajak(form)
      ])
      .then(() => {
        if (selectedRows.length > 0) {
          clearSelectedRows()
        }
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tgldari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tglsampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

      })
      .catch((error) => {
        showDialog(error.responseJSON)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })

  }

  function editInvoiceHeader(invId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
      Save
    `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Invoice')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    loadInvoiceGrid();

    Promise
      .all([
        setTglBukti(form),
        setStatusInvoice(form),
        setStatusPajak(form)
      ])
      .then(() => {

        showInvoiceHeader(form, invId, 'edit')
          .then(() => {

            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            $('#crudModal').modal('show')
            if (isEditTgl == 'TIDAK') {
              form.find(`[name="tglbukti"]`).prop('readonly', true)
              form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
            }

            $('#crudForm').find("[name=tgldari]").prop('readonly', true);
            $('#crudForm').find("[name=tgldari]").parent('.input-group').find('.input-group-append').children().prop('disabled', true);
            $('#crudForm').find("[name=tglsampai]").prop('readonly', true);
            $('#crudForm').find("[name=tglsampai]").parent('.input-group').find('.input-group-append').children().prop('disabled', true);
            form.find(`[name="pelanggan"]`).prop('readonly', true)
            form.find(`[name="pelanggan"]`).parent('.input-group').find('.input-group-append').remove()
            form.find(`[name="pelanggan"]`).parent('.input-group').find('.button-clear').remove()
            form.find(`[name="jenisorder"]`).prop('readonly', true)
            form.find(`[name="jenisorder"]`).parent('.input-group').find('.input-group-append').remove()
            form.find(`[name="jenisorder"]`).parent('.input-group').find('.button-clear').remove()

            tampilanMuatanBongkaran()
          }).catch((error) => {
            showDialog(error.responseJSON)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })

      })

  }

  function deleteInvoiceHeader(invId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-trash"></i>
              Delete
    `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Invoice')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    form.find('#btnTampil').prop('disabled', true)

    loadInvoiceGrid();
    Promise
      .all([
        setStatusInvoice(form),
        setStatusPajak(form)
      ])
      .then(() => {

        showInvoiceHeader(form, invId, 'delete')
          .then(() => {
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            form.find(`[name="tglbukti"]`).prop('readonly', true)
            form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
            $('#crudModal').modal('show')
            tampilanMuatanBongkaran()
          })
          .catch((error) => {
            showDialog(error.responseJSON)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  function viewInvoiceHeader(invId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'view')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('View Invoice')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    form.find('#btnTampil').prop('disabled', true)

    loadInvoiceGrid();
    Promise
      .all([
        setStatusInvoice(form),
        setStatusPajak(form)
      ])
      .then(() => {

        showInvoiceHeader(form, invId, 'delete')
          .then(() => {
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            form.find(`[name="tglbukti"]`).prop('readonly', true)
            form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
            $('#crudModal').modal('show')
            tampilanMuatanBongkaran()
          })
          .catch((error) => {
            showDialog(error.responseJSON)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  $(document).on('click', '#btnTampil', function(event) {
    event.preventDefault()

    if ($('#crudForm').data('action') == 'add') {
      url = `getjob`
    } else if ($('#crudForm').data('action') == 'edit') {
      invId = $(`#crudForm`).find(`[name="id"]`).val()
      url = `${invId}/getAllEdit`
    }

    $('#btnSubmit').prop('disabled', true)
    $('#btnSaveAdd').prop('disabled', true)
    let jenisorder = $('#crudForm [name=jenisorder]').val()
    if (jenisorder == 'MUATAN' ) {
      if ($('#crudForm').find(`[name="pelanggan_id"]`).val() != '') {
      $('#loaderGrid').removeClass('d-none')
      getDataInvoice(url).then((response) => {
          $("#tableInvoice")[0].p.selectedRowIds = [];
          $('#tableInvoice').jqGrid("clearGridData");
          if ($('#crudForm').data('action') == 'add') {
            selectedRowId = [];
          } else {
            selectedRowId = response.selectedId;
          }
          setTimeout(() => {

            $("#tableInvoice")
              .jqGrid("setGridParam", {
                datatype: "local",
                data: response.data,
                originalData: response.data,
                rowNum: response.data.length,
                selectedRowIds: selectedRowId
              })
              .trigger("reloadGrid");
            $('#btnSubmit').prop('disabled', false)
            $('#btnSaveAdd').prop('disabled', false)
          }, 100);

        })
        .catch((error) => {
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            setErrorMessages($('#crudForm'), error.responseJSON.errors);
          } else {
            showDialog(error.responseJSON)
          }
        })
        .finally(() => {
          $('.loaderGrid').addClass('d-none')
        });
    } else {
      showDialog('Harap memilih shipper, jenis order, tgl dari serta tgl sampai')
    }

    } else {
      if ($('#crudForm').find(`[name="tujuan_id"]`).val() != '') {

      $('#loaderGrid').removeClass('d-none')
      getDataInvoice(url).then((response) => {
          $("#tableInvoice")[0].p.selectedRowIds = [];
          $('#tableInvoice').jqGrid("clearGridData");
          if ($('#crudForm').data('action') == 'add') {
            selectedRowId = [];
          } else {
            selectedRowId = response.selectedId;
          }
          setTimeout(() => {

            $("#tableInvoice")
              .jqGrid("setGridParam", {
                datatype: "local",
                data: response.data,
                originalData: response.data,
                rowNum: response.data.length,
                selectedRowIds: selectedRowId
              })
              .trigger("reloadGrid");
            $('#btnSubmit').prop('disabled', false)
            $('#btnSaveAdd').prop('disabled', false)
          }, 100);

        })
        .catch((error) => {
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            setErrorMessages($('#crudForm'), error.responseJSON.errors);
          } else {
            showDialog(error.responseJSON)
          }
        })
        .finally(() => {
          $('.loaderGrid').addClass('d-none')
        });
    
      } else {
      showDialog('Harap memilih asal muat, jenis order, tgl dari serta tgl sampai')
    }

    }
  })

  function clearSelectedRowsInvoice() {
    getSelectedRows = $("#tableInvoice").getGridParam("selectedRowIds");
    $("#tableInvoice")[0].p.selectedRowIds = [];
    $('#tableInvoice').trigger('reloadGrid');
    setTotalNominal()
  }

  function selectAllRowsInvoice() {

    let originalData = $("#tableInvoice").getGridParam("data");
    let getSelectedRows = originalData.map((data) => data.id);
    $("#tableInvoice")[0].p.selectedRowIds = [];

    setTimeout(() => {
      $("#tableInvoice")
        .jqGrid("setGridParam", {
          selectedRowIds: getSelectedRows
        })
        .trigger("reloadGrid");

      setTotalNominal()
    })
  }

  function loadInvoiceGrid() {

    let disabled = '';
    if ($('#crudForm').data('action') == 'delete') {
      disabled = 'disabled'
    }
    $("#tableInvoice")
      .jqGrid({
        datatype: 'local',
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        colModel: [{
            label: "",
            name: "",
            width: 40,
            align: 'center',
            sortable: false,
            clear: false,
            stype: 'input',
            searchable: false,
            searchoptions: {
              type: 'checkbox',
              clearSearch: false,
              dataInit: function(element) {

                $(element).removeClass('form-control')
                $(element).parent().addClass('text-center')
                $(element).addClass('checkbox-selectall')
                if (disabled == '') {
                  $(element).on('click', function() {
                    if ($(this).is(':checked')) {
                      selectAllRowsInvoice()
                    } else {
                      clearSelectedRowsInvoice()
                    }
                  })
                } else {
                  $(element).attr('disabled', true)
                }

              }
            },
            formatter: function(value, rowOptions, rowData) {
              let disabled = '';
              if ($('#crudForm').data('action') == 'delete') {
                disabled = 'disabled'
              }
              return `<input type="checkbox" class="checkbox-jqgrid" value="${rowData.id}" ${disabled} onChange="checkboxHandlerInvoice(this, ${rowData.id})">`;
            },
          },
          {
            label: "id",
            name: "id",
            hidden: true,
            search: false,
          },
          {
            label: "JOB",
            name: "nojobemkl",
            sortable: true,
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: "TGL JOB",
            name: "tgljobemkl",
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: "NO CONT",
            name: "nocont",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            sortable: true,
          },
          {
            label: "NO SEAL",
            name: "noseal",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            sortable: true,
          },
          {
            label: "NOMINAL",
            name: "nominal",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: "right",
            editable: true,
            editoptions: {
              dataInit: function(element, id) {
                initAutoNumeric($('#crudForm').find(`[id="${id.id}"]`))
              },
              dataEvents: [{
                type: "keyup",
                fn: function(event, rowObject) {
                  let originalGridData = $("#tableInvoice")
                    .jqGrid("getGridParam", "originalData")
                    .find((row) => row.id == rowObject.rowId);

                  let localRow = $("#tableInvoice").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );
                  let total
                  localRow.nominal = event.target.value;
                  setTotalNominal()
                },
              }, ],
            },
            sortable: false,
            sorttype: "int",
          },
          {
            label: "KETERANGAN",
            name: "keterangan_detail",
            sortable: false,
            editable: true,
            editoptions: {
              dataEvents: [{
                type: "keyup",
                fn: function(event, rowObject) {

                  let localRow = $("#tableInvoice").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );
                  localRow.keterangan_detail = event.target.value;
                },
              }, ],
            },
          },
          {
            label: "keterangan Biaya",
            name: "keterangan_biaya",
            sortable: false,
            editable: true,
            editoptions: {
              autocomplete: 'off',
              class: 'keteranganBiaya_modalinput',
              dataInit: function(element) {
                let rowId = $("#tableInvoice").jqGrid('getGridParam', 'selrow');
                let localRow = $("#tableInvoice").jqGrid("getLocalRow",rowId);
                let dddd = localRow.keteranganInput
                $('.keteranganBiaya_modalinput').last().data('currentValue', dddd)
                $('.keteranganBiaya_modalinput').last().linkInput({
                  title: 'Keterangan Biaya Job',
                  fileName: 'jobbiaya_nominal',
                 
                  onSelectRow: (data, element) => {
                    element.val(JSON.stringify(data))
                    element.data('currentValue', element.val())
                    $("#tableInvoice").jqGrid('setCell', rowId, 'keteranganInput', JSON.stringify(data));
                    const totalNominal = data.reduce((accumulator, item) => {
                      return accumulator + item.nominal_biaya;
                    }, 0);
                    $("#tableInvoice").jqGrid('setCell', rowId, 'nominal', totalNominal);
                    $("#tableInvoice").jqGrid('setCell', rowId, 'keterangan_biaya', '');

                  },
                  onCancel: (element) => {
                    element.val(element.data('currentValue'))
                  },
                  onClear: (element) => {
                    element.val('')
                    element.data('currentValue', element.val())
                  }
                })
              }, 
            },
            // formatter: function(value, rowOptions, rowData) {
            //   let disabled = '';
            //   if ($('#crudForm').data('action') == 'delete') {
            //     disabled = 'disabled'
            //   }
            //   return `<input type="checkbox" class="checkbox-jqgrid" value="${rowData.id}" ${disabled} onChange="checkboxHandlerInvoice(this, ${rowData.id})">`;
            // },
          },
          {
            label: "keteranganInput",
            name: "keteranganInput",
            width: (detectDeviceType() == "desktop") ? md_dekstop_3 : md_mobile_3,
            sortable: false,
            hidden:true,
            formatter: function(cellValue, options, rowObject) {
              return rowObject.keterangan_biaya;
            }
          },
          {
            label: "SHIPPER",
            name: "namapelanggan",
            width: (detectDeviceType() == "desktop") ? md_dekstop_3 : md_mobile_3,
            sortable: true,
          },
          {
            label: "empty",
            name: "empty",
            hidden: true,
            search: false,
          },
        ],
        autowidth: true,
        shrinkToFit: false,
        height: 400,
        rownumbers: true,
        rownumWidth: 45,
        footerrow: true,
        userDataOnFooter: true,
        toolbar: [true, "top"],
        pgbuttons: false,
        pginput: false,
        cellEdit: true,
        cellsubmit: "clientArray",
        editableColumns: ["retribusi"],
        selectedRowIds: [],
        // onCellSelect: function(rowid, iCol, cellcontent, e) {
        //   console.log("Selected Cell - Row ID: " + rowid + ", Column Index: " + iCol);
        // },
        afterRestoreCell: function(rowId, value, indexRow, indexColumn) {
          let originalGridData = $("#tableInvoice")
            .jqGrid("getGridParam", "originalData")
            .find((row) => row.id == rowId);

          let localRow = $("#tableInvoice").jqGrid("getLocalRow", rowId);

          let getNominal = $("#tableInvoice").jqGrid("getCell", rowId, "nominal")
          let retribusi = (getNominal != '') ? parseFloat(getNominal.replaceAll(',', '')) : 0
          setTotalNominal()
        },
        isCellEditable: function(cellname, iRow, iCol) {
          let rowData = $(this).jqGrid("getRowData")[iRow - 1];
          if ($('#crudForm').data('action') != 'delete') {
            return $(this)
              .find(`tr input[value=${rowData.id}]`)
              .is(":checked");
          }
        },
        validationCell: function(cellobject, errormsg, iRow, iCol) {
          console.log(cellobject);
          console.log(errormsg);
          console.log(iRow);
          console.log(iCol);
        },
        loadComplete: function() {
          setTimeout(() => {
            $(this)
              .getGridParam("selectedRowIds")
              .forEach((selectedRowId) => {
                $(this)
                  .find(`tr input[value=${selectedRowId}]`)
                  .prop("checked", true);
                invoiceData = $("#tableInvoice").jqGrid("getLocalRow", selectedRowId)
                if (invoiceData.nominal > 0) {
                  initAutoNumeric($(this).find(`tr#${selectedRowId} td[aria-describedby="tableInvoice_nominal"]`))
                }
              });
            initAutoNumeric($(this).find(`td[aria-describedby="tableInvoice_nominal"]`))
          }, 100);

          $('#loaderGrid').addClass('d-none')
          setTotalNominal()
          setHighlight($(this))
        },
      })
      .jqGrid("setLabel", "rn", "No.")
      .jqGrid("navGrid", "#tablePager", {
        add: false,
        edit: false,
        del: false,
        refresh: false,
        search: false,
      })
      .jqGrid("filterToolbar", {
        searchOnEnter: false,
        beforeSearch: function() {
          // postData = $.parseJSON($('#tableInvoice').jqGrid('getGridParam', 'postData').filters)
          // $.each(postData.rules, function(key, val) {
          //   if (val.field == 'omset') {
          //     return initAutoNumeric($('#gsh_tableInvoice_omset').find('#gs_omset'))
          //   }
          // })
        },
      })
      .jqGrid("excelLikeGrid", {
        beforeDeleteCell: function(rowId, iRow, iCol, event) {
          let localRow = $("#tableInvoice").jqGrid("getLocalRow", rowId);
          return true;
        },
      });
    /* Append clear filter button */
    loadClearFilter($('#tableInvoice'))

    /* Append global search */
    // loadGlobalSearch($('#tableInvoice'))
  }

  $(document).on('click', '#resetdatafilter_tableInvoice', function(event) {
    selectedRowsPengembalian = $("#tableInvoice").getGridParam("selectedRowIds");
    $.each(selectedRowsPengembalian, function(index, value) {
      $('#tableInvoice').jqGrid('saveCell', value, 9); //emptycell
      $('#tableInvoice').jqGrid('saveCell', value, 7); //nominal
    })

  });
  $(document).on('click', '#gbox_tableInvoice .ui-jqgrid-hbox .ui-jqgrid-htable thead .ui-search-toolbar th td a.clearsearchclass', function(event) {
    selectedRowsPengembalian = $("#tableInvoice").getGridParam("selectedRowIds");
    $.each(selectedRowsPengembalian, function(index, value) {
      $('#tableInvoice').jqGrid('saveCell', value, 9); //emptycell
      $('#tableInvoice').jqGrid('saveCell', value, 7); //nominal
    })
  })

  function getDataInvoice(url, id) {

    let form = $('#crudForm')
    let data = []

    data.push({
      name: 'pelanggan_id',
      value: form.find(`[name="pelanggan_id"]`).val()
    })
    data.push({
      name: 'tujuan_id',
      value: form.find(`[name="tujuan_id"]`).val()
    })
    data.push({
      name: 'nobukti',
      value: form.find(`[name="nobukti"]`).val()
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
      name: 'statusinvoice',
      value: form.find(`[name="statusinvoice"]`).val()
    })
    data.push({
      name: 'limit',
      value: 0
    })
    data.push({
      name: 'aksi',
      value: form.data('action')
    })

    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}invoiceemklheader/${url}`,
        dataType: "JSON",
        data: data,
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: (response) => {
          if (form.data('action') != 'add') {
            let selectedIdPinj = []

            $.each(response.data, (index, value) => {
              if (value.idinvoice != null) {
                selectedIdPinj.push(parseInt(value.id))
              }
            })
            response.selectedId = selectedIdPinj;
          }
          resolve(response);
        },
        error: error => {
          reject(error)
        }
      });
    });
  }


  function checkboxHandlerInvoice(element, rowId) {

    let isChecked = $(element).is(":checked");
    let editableColumns = $("#tableInvoice").getGridParam("editableColumns");
    let selectedRowIds = $("#tableInvoice").getGridParam("selectedRowIds");
    let originalGridData = $("#tableInvoice")
      .jqGrid("getGridParam", "originalData")
      .find((row) => row.id == rowId);

    editableColumns.forEach((editableColumn) => {

      if (!isChecked) {
        for (var i = 0; i < selectedRowIds.length; i++) {
          if (selectedRowIds[i] == rowId) {
            selectedRowIds.splice(i, 1);
          }
        }
        $("#tableInvoice").jqGrid("setCell", rowId, "nominal", originalGridData.nominal);
        $(`#tableInvoice tr#${rowId}`).find(`td[aria-describedby="tableInvoice_nominal"]`).attr("value", originalGridData.nominal)
        initAutoNumeric( $(`#tableInvoice tr#${rowId}`).find(`td[aria-describedby="tableInvoice_nominal"]`))
      } else {
        selectedRowIds.push(rowId);
      }
    });

    $("#tableInvoice").jqGrid("setGridParam", {
      selectedRowIds: selectedRowIds,
    });

    setTotalNominal()

  }

  function setTotalNominal() {
    let retribusi = 0
    selectedRowsPinjaman = $("#tableInvoice").getGridParam("selectedRowIds");
    $.each(selectedRowsPinjaman, function(index, value) {
      dataPinjaman = $("#tableInvoice").jqGrid("getLocalRow", value);
      nominals = (dataPinjaman.nominal == undefined || dataPinjaman.nominal == '') ? 0 : dataPinjaman.nominal;
      retribusis = (isNaN(nominals)) ? parseFloat(nominals.replaceAll(',', '')) : parseFloat(nominals)
      retribusi = retribusi + retribusis
    })
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tableInvoice_nominal"]`).text(retribusi))
  }

  function showInvoiceHeader(form, invId, aksi) {
    return new Promise((resolve, reject) => {


      $.ajax({
        url: `${apiUrl}invoiceemklheader/${invId}`,
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
            // getEdit(invId, aksi)
            // $('#crudForm').find("[name=statuspilihaninvoice]").prop('disabled', true);
          }
          // getEdit(invId, aksi)
          $('#crudForm').find("[name=statuspajak]").prop('disabled', true);
          $('#crudForm').find("[name=statusinvoice]").prop('disabled', true);
          // loadInvoiceGrid();

          getDataInvoice(`${invId}/getEdit`).then((response) => {
            console.log(response)
            let selectedIdInv = []
            let totalRetribusi = 0
            $.each(response.data, (index, value) => {
              if (value.idinvoice != null) {
                selectedIdInv.push(value.id)
                totalRetribusi += parseFloat(value.nominal)
              }
            })
            $("#tableInvoice")
              .jqGrid("setGridParam", {
                datatype: "local",
                data: response.data,
                originalData: response.data,
                rowNum: response.data.length,
                selectedRowIds: selectedIdInv
              })
              .trigger("reloadGrid");
            // initAutoNumeric($('.footrow').find(`td[aria-describedby="tableInvoice_nominalretribusi"]`).text(totalRetribusi))

            setTotalNominal()
            resolve()
          });
        },
        error: error => {
          reject(error)
        }
      })
    })
  }


  $(document).on('click', `#spList tbody [name="sp_id[]"]`, function() {
    let tdOmset = $(this).closest('tr').find('td.omset').text()
    tdOmset = parseFloat(tdOmset.replaceAll(',', ''));
    let tdTambahan = $(this).closest('tr').find('td.tambahan').text()
    tdTambahan = parseFloat(tdTambahan.replaceAll(',', ''));
    let tdTotal = $(this).closest('tr').find('td.total').text()
    tdTotal = parseFloat(tdTotal.replaceAll(',', ''));

    let allOmset = $('#omset').text()
    allOmset = parseFloat(allOmset.replaceAll(',', ''));

    let allTambahan = $('#tambahan').text()
    allTambahan = parseFloat(allTambahan.replaceAll(',', ''));
    let allTotal = $('#total').text()
    allTotal = parseFloat(allTotal.replaceAll(',', ''));
    let nominal = 0

    if ($(this).prop("checked") == true) {
      allOmset = allOmset + tdOmset
      allTambahan = allTambahan + tdTambahan
      allTotal = allTotal + tdTotal

      $(this).closest('tr').find(`td [name="nominalretribusi[]"]`).prop('disabled', false)
      setNominalRetribusi()

    } else {
      allOmset = allOmset - tdOmset
      allTambahan = allTambahan - tdTambahan
      allTotal = allTotal - tdTotal
      let updTotal = tdOmset + tdTambahan
      // $(this).closest('tr').find(`td [name="nominalretribusi[]"]`).prop('disabled', true)
      $(this).closest('tr').find(`td [name="nominalretribusi[]"]`).remove();
      let newRetElement = `<input type="text" name="nominalretribusi[]" class="form-control text-right" disabled>`
      let id = $(this).val()
      $(this).closest('tr').find(`#ret${id}`).append(newRetElement)
      initAutoNumeric($(this).closest("tr").find(`td [name="nominalretribusi[]"]`))
      setNominalRetribusi()

      $(this).closest("tr").find("td.total").html(updTotal)
      initAutoNumeric($(this).closest("tr").find("td.total"))

    }

    $('#omset').html('')
    $('#omset').append(`${allOmset}`)
    initAutoNumeric($('#spList tfoot').find('#omset'))
    $('#tambahan').html('')
    $('#tambahan').append(`${allTambahan}`)
    initAutoNumeric($('#spList tfoot').find('#tambahan'))
    $('#total').html('')
    $('#total').append(`${allTotal}`)
    initAutoNumeric($('#spList tfoot').find('#total'))

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
          showDialog(error.responseJSON)
        }
      })
    }
  }

  function cekValidasi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}invoiceemklheader/${Id}/cekvalidasi`,
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
          if (Aksi == 'PRINTER') {
            window.open(`{{ route('invoiceemklheader.report') }}?id=${Id}`)
          } else {
            cekValidasiAksi(Id, Aksi)
          }
        }
      }
    })
  }

  function cekValidasiAksi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}invoiceemklheader/${Id}/cekvalidasiAksi`,
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
            editInvoiceHeader(Id)
          }
          if (Aksi == 'DELETE') {
            deleteInvoiceHeader(Id)
          }
        }

      }
    })
  }


  function approve() {

    event.preventDefault()

    let form = $('#crudForm')
    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')

    $.ajax({
      url: `${apiUrl}invoiceemklheader/approval`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        invoiceId: selectedRows
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

  const setStatusInvoice = function setStatusInvoice(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusinvoice]').empty()
      relatedForm.find('[name=statusinvoice]').append(
        new Option('-- PILIH STATUS invoice --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}parameter`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          filters: JSON.stringify({
            "groupOp": "AND",
            "rules": [{
              "field": "grp",
              "op": "cn",
              "data": "STATUS INVOICE EMKL"
            }]
          })
        },
        success: response => {
          let selectedId
          response.data.forEach(statusInvoice => {
            let option = new Option(statusInvoice.text, statusInvoice.id)
            // element.val(value).trigger('change')
            if (statusInvoice.default != "") {
              selectedId = statusInvoice.id
            }
            relatedForm.find('[name=statusinvoice]').append(option).trigger('change')
          });
          relatedForm.find('[name=statusinvoice]').val(selectedId).trigger('change')
          resolve()
        }
      })
    })
  }
  const setStatusPajak = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statuspajak]').empty()
      relatedForm.find('[name=statuspajak]').append(
        new Option('-- PILIH STATUS PAJAK --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}parameter`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          filters: JSON.stringify({
            "groupOp": "AND",
            "rules": [{
              "field": "grp",
              "op": "cn",
              "data": "STATUS PAJAK"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusPajak => {
            let option = new Option(statusPajak.text, statusPajak.id)
            if (statusPajak.default == "YA") {
              selectedId = statusPajak.id
            }
            relatedForm.find('[name=statuspajak]').append(option).trigger('change')
          });

          relatedForm.find('[name=statuspajak]').val(selectedId).trigger('change')
          resolve()
        },
        error: error => {
          reject(error)
        }
      })
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
        console.log(element.val())
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=pelanggan_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.tujuan-lookup').lookup({
      title: 'Asal Muat Lookup',
      fileName: 'tujuan',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          emkl: 'emkl',
        }
      },
      onSelectRow: (tujuan, element) => {
        $('#crudForm [name=tujuan_id]').first().val(tujuan.id)

        element.val(tujuan.keterangan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        console.log(element.val())
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=tujuan_id]').first().val('')
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
        tampilanMuatanBongkaran();
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

  function tampilanMuatanBongkaran() {
    let jenisorder = $('#crudForm [name=jenisorder]').val()
    if (jenisorder == 'MUATAN' ) {
      $('[name=statuspajak]').parents('.form-group').show();
      $('[name=kapal]').parents('.form-group').show();
      $('[name=destination]').parents('.form-group').show();
      $('[name=nobuktiinvoicepajak]').parents('.form-group').show();
      $('[name=tujuan]').parents('.form-group').hide();

      $("#tableInvoice").jqGrid("hideCol", `keterangan_biaya`);
      $("#tableInvoice").jqGrid('setColProp', 'nominal', {
        editable: true
      });
    }else if (jenisorder == 'BONGKARAN') {
      $('[name=statuspajak]').parents('.form-group').hide();
      $('[name=kapal]').parents('.form-group').hide();
      $('[name=destination]').parents('.form-group').hide();
      $('[name=tujuan]').parents('.form-group').show();

      $('[name=nobuktiinvoicepajak]').parents('.form-group').hide();
      $("#tableInvoice").jqGrid("showCol", `keterangan_biaya`);
      $("#tableInvoice").jqGrid('setColProp', 'nominal', {
        editable: false
      });
    }
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
        value: 'INVOICE'
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
  const setFormatTable = function() {
    return new Promise((resolve, reject) => {
      let data = [];
      data.push({
        name: 'grp',
        value: 'STATUS CETAKAN'
      })
      data.push({
        name: 'subgrp',
        value: 'INVOICE'
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
          if (response.text == 'FORMAT 1') {
            $("#tableInvoice").jqGrid("hideCol", `keteranganbiaya`);
          }
          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  const setTampilan = function(relatedForm) {
    return new Promise((resolve, reject) => {
      let data = [];
      data.push({
        name: 'grp',
        value: 'UBAH TAMPILAN'
      })
      data.push({
        name: 'text',
        value: 'INVOICEHEADER'
      })
      $.ajax({
        url: `${apiUrl}parameter/getparambytext`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: data,
        success: response => {
          memo = JSON.parse(response.memo)
          memo = memo.INPUT
          if (memo != '') {

            input = memo.split(',');
            input.forEach(field => {
              field = $.trim(field.toLowerCase());
              $(`.${field}`).hide()
              $("#tableInvoice").jqGrid("hideCol", `${field}`);
            });
          }
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