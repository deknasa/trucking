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
                    CUSTOMER <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-12 col-md-4">
                  <input type="hidden" name="agen_id">
                  <input type="text" name="agen" class="form-control agen-lookup">
                </div>
                <div class="col-12 col-md-2 ">
                  <label class="col-form-label">
                    TGL JATUH TEMPO <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-12 col-md-4">
                  <div class="input-group">
                    <input type="text" name="tgljatuhtempo" class="form-control datepicker">
                  </div>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-12 col-md-2">
                  <label class="col-form-label">
                    STATUS pilihan invoice <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-12 col-md-4">
                  <select name="statuspilihaninvoice" class="form-select select2bs4" style="width: 100%;">
                    <option value="">-- PILIH STATUS pilihan invoice --</option>
                  </select>
                </div>

                <div class="col-12 col-md-2 jenisorder">
                  <label class="col-form-label">
                    Jenis Order <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-12 col-md-4 jenisorder">
                  <input type="hidden" name="jenisorder_id">
                  <input type="text" name="jenisorder" class="form-control jenisorder-lookup">
                </div>
              </div>

              <div class="row form-group noinvoicepajak">
                <div class="col-12 col-md-2  ">
                  <label class="col-form-label">
                    no invoice pajak
                  </label>
                </div>
                <div class="col-12 col-md-4">
                  <input type="text" name="noinvoicepajak" class="form-control">
                </div>

                <div class="col-12 col-md-2">
                  <label class="col-form-label">
                    STATUS JENIS KENDARAAN <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-12 col-md-4">
                  <select name="statusjeniskendaraan" class="form-control select2bs4" id="statusjeniskendaraan">
                    <option value="">-- PILIH STATUS JENIS KENDARAAN --</option>
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
        name: 'statuspilihaninvoice',
        value: form.find(`[name="statuspilihaninvoice"]`).val()
      })
      data.push({
        name: 'tgljatuhtempo',
        value: form.find(`[name="tgljatuhtempo"]`).val()
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
        name: 'agen',
        value: form.find(`[name="agen"]`).val()
      })
      data.push({
        name: 'agen_id',
        value: form.find(`[name="agen_id"]`).val()
      })
      data.push({
        name: 'noinvoicepajak',
        value: form.find(`[name="noinvoicepajak"]`).val()
      })
      data.push({
        name: 'statusjeniskendaraan',
        value: form.find(`[name="statusjeniskendaraan"]`).val()
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
      nominalextra = []
      nominalretribusi = []
      omset = []
      sp_id = []
      jobtrucking = []
      keteranganManual = []
      $.each(selectedRowsInvoice, function(index, value) {
        dataInvoice = $("#tableInvoice").jqGrid("getLocalRow", value);
        let selectedExtra = dataInvoice.nominalextra
        let selectedOmset = dataInvoice.omset
        let selectedRetribusi = (dataInvoice.nominalretribusi == undefined) ? 0 : dataInvoice.nominalretribusi;


        nominalextra.push((isNaN(selectedExtra)) ? parseFloat(selectedExtra.replaceAll(',', '')) : selectedExtra)
        nominalretribusi.push((isNaN(selectedRetribusi)) ? parseFloat(selectedRetribusi.replaceAll(',', '')) : selectedRetribusi)
        omset.push((isNaN(selectedOmset)) ? parseFloat(selectedOmset.replaceAll(',', '')) : selectedOmset)
        sp_id.push(dataInvoice.sp_id)
        jobtrucking.push(dataInvoice.jobtrucking)
        keteranganManual.push(dataInvoice.keterangan)
      });
      let requestData = {
        'nominalextra': nominalextra,
        'nominalretribusi': nominalretribusi,
        'omset': omset,
        'sp_id': sp_id,
        'jobtrucking': jobtrucking,
        'keterangan': keteranganManual
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
          url = `${apiUrl}invoiceheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}invoiceheader/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}invoiceheader/${Id}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}invoiceheader`
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
            let currTglbukti = $('#crudForm [name=tglbukti]').val();
            createInvoiceHeader(true)

            $('#crudForm').find('[name=tglbukti]').val(currTglbukti).trigger('change');
            $('#crudForm').find('input[type="text"]').data('current-value', '')
            $("#tableInvoice")[0].p.selectedRowIds = [];
            $('#tableInvoice').jqGrid("clearGridData");
            $("#tableInvoice")
              .jqGrid("setGridParam", {
                selectedRowIds: []
              })
              .trigger("reloadGrid");

            initAutoNumeric($('.footrow').find(`td[aria-describedby="tableInvoice_total"]`).text(0))
            initAutoNumeric($('.footrow').find(`td[aria-describedby="tableInvoice_omset"]`).text(0))
            initAutoNumeric($('.footrow').find(`td[aria-describedby="tableInvoice_nominalextra"]`).text(0))
            initAutoNumeric($('.footrow').find(`td[aria-describedby="tableInvoice_nominalretribusi"]`).text(0))


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


  $(document).on('change', `#crudForm [name="statusjeniskendaraan"]`, function(event) {

    let statusjeniskendaraan = $(`#crudForm [name="statusjeniskendaraan"] option:selected`).text()
    statusJenisKendaran = statusjeniskendaraan
    let jenisorder = $('#crudForm [name=jenisorder]')
    if (statusjeniskendaraan == 'TANGKI') {

      jenisorder.val('')
      jenisorder.data('currentValue', '')
      $('#crudForm [name=jenisorder_id]').val('')
      jenisorder.attr('readonly', true)
      jenisorder.parents('.input-group').find('.input-group-append').hide()
      jenisorder.parents('.input-group').find('.button-clear').hide()
    }
    if (statusjeniskendaraan == 'GANDENGAN') {

      jenisorder.attr('readonly', false)
      jenisorder.parents('.input-group').find('.input-group-append').show()
      jenisorder.parents('.input-group').find('.button-clear').show()
    }
  })

  function removeEditingBy(id) {

    let formData = new FormData();


    formData.append('id', id);
    formData.append('aksi', 'BATAL');
    formData.append('table', 'invoiceheader');

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

  function createInvoiceHeader(isSaveAdd = false) {
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
        setStatusPilihanInvoiceOptions(form),
        setStatusJenisKendaraanOptions(form),
        setTampilan(),
        setFormatTable()
      ])
      .then(() => {
        if (selectedRows.length > 0) {
          clearSelectedRows()
        }
        $('#crudModal').modal('show')
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        if (!isSaveAdd) {
          $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        }
        $('#crudForm').find('[name=tgljatuhtempo]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=tglterima]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
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
        setStatusPilihanInvoiceOptions(form),
        setStatusJenisKendaraanOptions(form),
        setTampilan(),
        setFormatTable()
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
            form.find(`[name="agen"]`).prop('readonly', true)
            form.find(`[name="agen"]`).parent('.input-group').find('.input-group-append').remove()
            form.find(`[name="agen"]`).parent('.input-group').find('.button-clear').remove()
            form.find(`[name="jenisorder"]`).prop('readonly', true)
            form.find(`[name="jenisorder"]`).parent('.input-group').find('.input-group-append').remove()
            form.find(`[name="jenisorder"]`).parent('.input-group').find('.button-clear').remove()
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
        setStatusPilihanInvoiceOptions(form),
        setStatusJenisKendaraanOptions(form),
        setTampilan(),
        setFormatTable()
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
        setStatusPilihanInvoiceOptions(form),
        setStatusJenisKendaraanOptions(form),
        setTampilan(),
        setFormatTable()
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
      url = `getSP`
    } else if ($('#crudForm').data('action') == 'edit') {
      invId = $(`#crudForm`).find(`[name="id"]`).val()
      url = `${invId}/getAllEdit`
    }

    $('#btnSubmit').prop('disabled', true)
    $('#btnSaveAdd').prop('disabled', true)
    if ($('#crudForm').find(`[name="agen_id"]`).val() != '') {
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

      });
    } else {
      showDialog('Harap memilih agen, jenis order, tgl dari serta tgl sampai')
    }
  })

  function clearSelectedRowsInvoice() {
    getSelectedRows = $("#tableInvoice").getGridParam("selectedRowIds");
    $("#tableInvoice")[0].p.selectedRowIds = [];
    $('#tableInvoice').trigger('reloadGrid');
    setTotalOmset()
    setTotalExtra()
    setTotalRetribusi()
    setTotalAll()
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

      setTotalOmset()
      setTotalExtra()
      setTotalRetribusi()
      setTotalAll()
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
            label: "sp_id",
            name: "sp_id",
            hidden: true,
            search: false,
          },
          {
            label: "JOB TRUCKING",
            name: "jobtrucking",
            sortable: true,
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: "TGL OTOBON",
            name: "tglsp",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_2,
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
            label: "no sp full",
            name: "nospfull",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            sortable: true,
          },
          {
            label: "no sp empty",
            name: "nospempty",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            sortable: true,
          },
          {
            label: "no sp full empty",
            name: "nospfullempty",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            sortable: true,
          },
          {
            label: "TUJUAN",
            name: "tarif_id",
            width: (detectDeviceType() == "desktop") ? md_dekstop_1 : sm_dekstop_1,
            sortable: true,
          },
          {
            label: "OMSET",
            name: "omset",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            sortable: true,
            align: "right",
            formatter: currencyFormat,
          },
          {
            label: "BIAYA TAMBAHAN",
            name: "nominalextra",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            sortable: true,
            align: "right",
            formatter: currencyFormat,
          },
          {
            label: "RETRIBUSI",
            name: "nominalretribusi",
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
                  localRow.nominalretribusi = event.target.value;
                  let retribusi = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])
                  let getOmset = $("#tableInvoice").jqGrid("getCell", rowObject.rowId, "omset")
                  let omset = (getOmset != '') ? parseFloat(getOmset.replaceAll(',', '')) : 0
                  let getExtra = $("#tableInvoice").jqGrid("getCell", rowObject.rowId, "nominalextra")
                  let extra = (getExtra != '') ? parseFloat(getExtra.replaceAll(',', '')) : 0

                  total = omset + extra + retribusi

                  console.log(total)
                  $("#tableInvoice").jqGrid(
                    "setCell",
                    rowObject.rowId,
                    "total",
                    total
                  );

                  // retribusiDetails = $(`#tableInvoice tr:not(#${rowObject.rowId})`).find(`td[aria-describedby="tableInvoice_nominalretribusi"]`)
                  // ttlRetribusi = 0
                  // $.each(retribusiDetails, (index, retribusiDetail) => {
                  //   ttlRetribusiDetail = parseFloat($(retribusiDetail).attr('title').replaceAll(',', ''))
                  //   ttlRetribusis = (isNaN(ttlRetribusiDetail)) ? 0 : ttlRetribusiDetail;
                  //   ttlRetribusi += ttlRetribusis
                  // });
                  // ttlRetribusi += retribusi
                  // initAutoNumeric($('.footrow').find(`td[aria-describedby="tableInvoice_nominalretribusi"]`).text(ttlRetribusi))

                  setTotalRetribusi()
                  setTotalAll()
                },
              }, ],
            },
            sortable: false,
            sorttype: "int",
          },
          {
            label: "TOTAL",
            name: "total",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            sortable: true,
            align: "right",
            formatter: currencyFormat,
          },
          {
            label: "BAGIAN",
            name: "jenisorder_idgrid",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            sortable: true,
          },
          {
            label: "CUSTOMER",
            name: "agen_idgrid",
            width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
            sortable: true,
          },
          {
            label: "LONG TRIP",
            name: "statuslongtrip",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            align: "center",
            sortable: false,
            search: false,
            formatter: 'checkbox',
            width: 100,
            editable: false,
            cb: {
              check: "TRUE", //check the checkbox when cell value is "YES".
              uncheck: "FALSE" //uncheck when "NO".
            },
          },
          {
            label: "PERALIHAN",
            name: "statusperalihan",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            align: "center",
            sortable: false,
            search: false,
            formatter: 'checkbox',
            width: 100,
            editable: false,
            cb: {
              check: "TRUE", //check the checkbox when cell value is "YES".
              uncheck: "FALSE" //uncheck when "NO".
            },
          },
          {
            label: "KET. BIAYA EXTRA",
            name: "keteranganbiaya",
            width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
            sortable: true,
          },
          {
            label: "KETERANGAN",
            name: "keterangan",
            width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
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
                  console.log(localRow)
                  localRow.keterangan = event.target.value;
                },
              }, ],
            },
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

          let getRetribusi = $("#tableInvoice").jqGrid("getCell", rowId, "nominalretribusi")
          let retribusi = (getRetribusi != '') ? parseFloat(getRetribusi.replaceAll(',', '')) : 0

          let getOmset = $("#tableInvoice").jqGrid("getCell", rowId, "omset")
          let omset = (getOmset != '') ? parseFloat(getOmset.replaceAll(',', '')) : 0

          let getExtra = $("#tableInvoice").jqGrid("getCell", rowId, "nominalextra")
          let extra = (getExtra != '') ? parseFloat(getExtra.replaceAll(',', '')) : 0

          total = omset + extra + retribusi
          console.log(retribusi)
          if (indexColumn == 13) {
            $("#tableInvoice").jqGrid(
              "setCell",
              rowId,
              "total",
              total
              // sisa - bayar - potongan
            );
          }
          setTotalAll()
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
                if (invoiceData.nominalretribusi > 0) {
                  initAutoNumeric($(this).find(`tr#${selectedRowId} td[aria-describedby="tableInvoice_nominalretribusi"]`))
                }
              });
          }, 100);

          $('#loaderGrid').addClass('d-none')
          setTotalOmset()
          setTotalExtra()
          setTotalAll()
          setTotalRetribusi()
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
          postData = $.parseJSON($('#tableInvoice').jqGrid('getGridParam', 'postData').filters)
          $.each(postData.rules, function(key, val) {
            if (val.field == 'omset') {
              return initAutoNumeric($('#gsh_tableInvoice_omset').find('#gs_omset'))
            }
          })
        },
      })
      .jqGrid("excelLikeGrid", {
        beforeDeleteCell: function(rowId, iRow, iCol, event) {
          let localRow = $("#tableInvoice").jqGrid("getLocalRow", rowId);

          $("#tableInvoice").jqGrid(
            "setCell",
            rowId,
            "sisa",
            parseInt(localRow.sisa) + parseInt(localRow.bayar)
          );

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
      $('#tableInvoice').jqGrid('saveCell', value, 21); //emptycell
      $('#tableInvoice').jqGrid('saveCell', value, 13); //nominal
    })

  });
  $(document).on('click', '#gbox_tableInvoice .ui-jqgrid-hbox .ui-jqgrid-htable thead .ui-search-toolbar th td a.clearsearchclass', function(event) {
    selectedRowsPengembalian = $("#tableInvoice").getGridParam("selectedRowIds");
    $.each(selectedRowsPengembalian, function(index, value) {
      $('#tableInvoice').jqGrid('saveCell', value, 21); //emptycell
      $('#tableInvoice').jqGrid('saveCell', value, 13); //nominal
    })
  })

  function getDataInvoice(url, id) {

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
      name: 'pilihanperiode',
      value: form.find(`[name="statuspilihaninvoice"]`).val()
    })
    data.push({
      name: 'statusjeniskendaraan',
      value: form.find(`[name="statusjeniskendaraan"]`).val()
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
        url: `${apiUrl}invoiceheader/${url}`,
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
        total = 0
        if ($('#crudForm').data('action') == 'edit') {
          total = parseFloat(originalGridData.omset) + parseFloat(originalGridData.nominalextra) + parseFloat(originalGridData.nominalretribusi)
        } else {
          total = parseFloat(originalGridData.omset) + parseFloat(originalGridData.nominalextra)
        }

        $("#tableInvoice").jqGrid(
          "setCell",
          rowId,
          "total",
          total
        );

        $("#tableInvoice").jqGrid("setCell", rowId, "nominalretribusi", 0);
        $(`#tableInvoice tr#${rowId}`).find(`td[aria-describedby="tableInvoice_nominalretribusi"]`).attr("value", 0)
      } else {
        selectedRowIds.push(rowId);
      }
    });

    $("#tableInvoice").jqGrid("setGridParam", {
      selectedRowIds: selectedRowIds,
    });

    setTotalOmset()
    setTotalExtra()
    setTotalRetribusi()
    setTotalAll()
    // initAutoNumeric($('.footrow').find(`td[aria-describedby="tableInvoice_potongan"]`).text(totalPotongan))
    // initAutoNumeric($('.footrow').find(`td[aria-describedby="tableInvoice_nominallebihbayar"]`).text(totalNominalLebih))

  }

  function setTotalOmset() {
    let omsetDetails = $(`#tableInvoice`).find(`td[aria-describedby="tableInvoice_omset"]`)
    let omset = 0
    let selectedRowsPinjaman = $("#tableInvoice").getGridParam("selectedRowIds");
    $.each(selectedRowsPinjaman, function(index, value) {
      dataPinjaman = $("#tableInvoice").jqGrid("getLocalRow", value);
      nominals = (dataPinjaman.omset == undefined || dataPinjaman.omset == '') ? 0 : dataPinjaman.omset;
      omsets = (isNaN(nominals)) ? parseFloat(nominals.replaceAll(',', '')) : parseFloat(nominals)
      omset = omset + omsets
    })
    // $.each(omsetDetails, (index, omsetDetail) => {
    //   omsetdetail = parseFloat($(omsetDetail).text().replaceAll(',', ''))
    //   omsets = (isNaN(omsetdetail)) ? 0 : omsetdetail;
    //   omset += omsets
    // });
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tableInvoice_omset"]`).text(omset))
  }

  function setTotalExtra() {
    let extraDetails = $(`#tableInvoice`).find(`td[aria-describedby="tableInvoice_nominalextra"]`)
    let extra = 0
    let selectedRowsPinjaman = $("#tableInvoice").getGridParam("selectedRowIds");
    $.each(selectedRowsPinjaman, function(index, value) {
      dataPinjaman = $("#tableInvoice").jqGrid("getLocalRow", value);
      lunas_extras = (dataPinjaman.nominalextra == undefined || dataPinjaman.nominalextra == '') ? 0 : dataPinjaman.nominalextra;
      extras = (isNaN(lunas_extras)) ? parseFloat(lunas_extras.replaceAll(',', '')) : parseFloat(lunas_extras)
      extra = extra + extras
    })
    // $.each(extraDetails, (index, extraDetail) => {
    //   extradetail = parseFloat($(extraDetail).text().replaceAll(',', ''))
    //   extras = (isNaN(extradetail)) ? 0 : extradetail;
    //   extra += extras
    // });
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tableInvoice_nominalextra"]`).text(extra))
  }

  function setTotalRetribusi() {
    let retribusiDetails = $(`#tableInvoice`).find(`td[aria-describedby="tableInvoice_nominalretribusi"]`)
    let retribusi = 0
    selectedRowsPinjaman = $("#tableInvoice").getGridParam("selectedRowIds");
    $.each(selectedRowsPinjaman, function(index, value) {
      dataPinjaman = $("#tableInvoice").jqGrid("getLocalRow", value);
      nominals = (dataPinjaman.nominalretribusi == undefined || dataPinjaman.nominalretribusi == '') ? 0 : dataPinjaman.nominalretribusi;
      retribusis = (isNaN(nominals)) ? parseFloat(nominals.replaceAll(',', '')) : parseFloat(nominals)
      retribusi = retribusi + retribusis
    })
    // $.each(retribusiDetails, (index, retribusiDetail) => {
    //   retribusidetail = parseFloat($(retribusiDetail).text().replaceAll(',', ''))
    //   retribusis = (isNaN(retribusidetail)) ? 0 : retribusidetail;
    //   retribusi += retribusis
    // });
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tableInvoice_nominalretribusi"]`).text(retribusi))
  }

  function setTotalAll() {
    let totalDetails = $(`#tableInvoice`).find(`td[aria-describedby="tableInvoice_total"]`)
    let total = 0

    let selectedRowsPinjaman = $("#tableInvoice").getGridParam("selectedRowIds");
    $.each(selectedRowsPinjaman, function(index, value) {
      dataPinjaman = $("#tableInvoice").jqGrid("getLocalRow", value);
      lunas_total = (dataPinjaman.total == undefined || dataPinjaman.total == '') ? 0 : dataPinjaman.total;
      totals = (isNaN(lunas_total)) ? parseFloat(lunas_total.replaceAll(',', '')) : parseFloat(lunas_total)
      total = total + totals
    })
    // $.each(totalDetails, (index, totalDetail) => {
    //   totaldetail = parseFloat($(totalDetail).text().replaceAll(',', ''))
    //   totals = (isNaN(totaldetail)) ? 0 : totaldetail;
    //   total += totals
    // });
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tableInvoice_total"]`).text(total))
  }

  function showInvoiceHeader(form, invId, aksi) {
    return new Promise((resolve, reject) => {


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
            // getEdit(invId, aksi)
            // $('#crudForm').find("[name=statuspilihaninvoice]").prop('disabled', true);
            $('#crudForm').find("[name=tgljatuhtempo]").prop('readonly', true);
            $('#crudForm').find("[name=tgljatuhtempo]").parent('.input-group').find('.input-group-append').children().prop('disabled', true);
          }
          // getEdit(invId, aksi)
          // $('#crudForm').find("[name=statuspilihaninvoice]").prop('disabled', true);
          // $('#crudForm').find("[name=statusjeniskendaraan]").prop('disabled', true);
          $('#crudForm').find("[name=tgljatuhtempo]").prop('readonly', true);
          $('#crudForm').find("[name=tgljatuhtempo]").parent('.input-group').find('.input-group-append').children().prop('disabled', true);
          // loadInvoiceGrid();

          getDataInvoice(`${invId}/getEdit`).then((response) => {
            console.log(response)
            let selectedIdInv = []
            let totalRetribusi = 0
            $.each(response.data, (index, value) => {
              if (value.idinvoice != null) {
                selectedIdInv.push(value.id)
                totalRetribusi += parseFloat(value.nominalretribusi)
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

            setTotalOmset()
            setTotalExtra()
            setTotalRetribusi()
            setTotalAll()
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
      url: `{{ config('app.api_url') }}invoiceheader/${Id}/cekvalidasi`,
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
            window.open(`{{ route('invoiceheader.report') }}?id=${Id}&printer=reportPrinterBesar`)
          } else if (Aksi == 'PRINTER KECIL') {
            window.open(`{{ route('invoiceheader.report') }}?id=${Id}&printer=reportPrinterKecil`)
          } else {
            cekValidasiAksi(Id, Aksi)
          }
        }
      }
    })
  }

  function cekValidasiAksi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}invoiceheader/${Id}/cekvalidasiAksi`,
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
      url: `${apiUrl}invoiceheader/approval`,
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

  const setStatusPilihanInvoiceOptions = function setStatusPilihanInvoiceOptions(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statuspilihaninvoice]').empty()
      relatedForm.find('[name=statuspilihaninvoice]').append(
        new Option('-- PILIH STATUS pilihan invoice --', '', false, true)
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
              "data": "STATUS PILIHAN INVOICE"
            }]
          })
        },
        success: response => {
          let selectedId
          response.data.forEach(statusKaryawan => {
            let option = new Option(statusKaryawan.text, statusKaryawan.id)
            // element.val(value).trigger('change')
            if (statusKaryawan.default != "") {
              selectedId = statusKaryawan.id
            }
            relatedForm.find('[name=statuspilihaninvoice]').append(option).trigger('change')
          });
          relatedForm.find('[name=statuspilihaninvoice]').val(selectedId).trigger('change')
          resolve()
        }
      })
    })
  }
  const setStatusJenisKendaraanOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusjeniskendaraan]').empty()
      relatedForm.find('[name=statusjeniskendaraan]').append(
        new Option('-- PILIH STATUS JENIS KENDARAAN --', '', false, true)
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
              "data": "STATUS JENIS KENDARAAN"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusJenisKendaraan => {
            let option = new Option(statusJenisKendaraan.text, statusJenisKendaraan.id)
            if (statusJenisKendaraan.default == "YA") {
              selectedId = statusJenisKendaraan.id
            }
            relatedForm.find('[name=statusjeniskendaraan]').append(option).trigger('change')
          });

          relatedForm.find('[name=statusjeniskendaraan]').val(selectedId).trigger('change')
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
    $('.agen-lookup').lookup({
      title: 'Customer Lookup',
      fileName: 'agen',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          Invoice: 'UTAMA',
        }
      },
      onSelectRow: (agen, element) => {
        $('#crudForm [name=agen_id]').first().val(agen.id)
        setTglJatuhTempo(agen.top);

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