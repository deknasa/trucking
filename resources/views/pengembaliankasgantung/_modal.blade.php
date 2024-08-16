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
            <div class="row">

              <div class="col-md-6 mb-3">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4">
                    <label class="col-form-label">
                      NO BUKTI
                    </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <input type="text" name="nobukti" class="form-control" readonly>
                  </div>
                </div>
              </div>

              <div class="col-md-6 mb-3">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4">
                    <label class="col-form-label">
                      TGL BUKTI <span class="text-danger">*</span>
                    </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <div class="input-group">
                      <input type="text" name="tglbukti" class="form-control datepicker">
                    </div>
                  </div>
                </div>
              </div>

              {{-- <div class="col-md-6 mb-3">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4">
                    <label class="col-form-label">COA KAS MASUK </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <input type="text" name="coa" class="form-control akunpusat-lookup">
                  </div>
                </div>
              </div> --}}
              <div class="col-md-6 mb-3">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4">
                    <label class="col-form-label">
                      DARI TANGGAL <span class="text-danger">*</span>
                    </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8 ">
                    <div class="input-group">
                      <input type="text" name="tgldari" class="form-control datepicker" id="tgldari">
                    </div>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4">
                    <label class="col-form-label">
                      SAMPAI TANGGAL <span class="text-danger">*</span>
                    </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8 ">
                    <div class="input-group">
                      <input type="text" name="tglsampai" class="form-control datepicker" id="tglsampai">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row mb-2 mt-1">
              <div class="col-12 col-md-12">
                <button id="btnTampil" type="button" class="btn btn-primary"><i class="fas fa-sync"></i>
                  RELOAD
                </button>
              </div>
            </div>
            <div class="border p-3">
              <h6>Posting Penerimaan</h6>

              <div class="row form-group">
                <div class="col-12 col-md-2">
                  <label class="col-form-label">
                    POSTING </label>
                </div>
                <div class="col-12 col-md-4">
                  <input type="text" name="bank" class="form-control bank-lookup">
                  <input type="hidden" id="bankId" name="bank_id">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-md-2">
                  <label class="col-form-label">
                    NO BUKTI KAS MASUK </label>
                </div>
                <div class="col-12 col-md-4">
                  <input type="text" name="penerimaan_nobukti" class="form-control" readonly>
                </div>
              </div>
            </div>

            <table id="tablePengembalian"></table>

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

    $(document).on('click', '#btnTampil', function(event) {
      event.preventDefault()
      selectedId = []
      rangeKasgantung()
    });

    $(document).on('click', "#addRow", function() {
      addRow()
    });

    $(document).on('click', '.delete-row', function(event) {
      deleteRow($(this).parents('tr'))
    })
    $(document).on('click', '.checkItem', function(event) {
      enabledRow($(this).data("id"))
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
        name: 'bank',
        value: form.find(`[name="bank"]`).val()
      })
      data.push({
        name: 'bank_id',
        value: form.find(`[name="bank_id"]`).val()
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
        name: 'penerimaan_nobukti',
        value: form.find(`[name="penerimaan_nobukti"]`).val()
      })

      let selectedRows = $("#tablePengembalian").getGridParam("selectedRowIds");
      data.push({
        name: 'jumlahdetail',
        value: selectedRows.length
      })
      $.each(selectedRows, function(index, value) {
        dataPengembalianKasGantung = $("#tablePengembalian").jqGrid("getLocalRow", value);
        let selectedNominal = (dataPengembalianKasGantung.nominal == undefined) ? 0 : dataPengembalianKasGantung.nominal;
        let selectedSisa = dataPengembalianKasGantung.sisa
        data.push({
          name: 'nominal[]',
          value: (isNaN(selectedNominal)) ? parseFloat(selectedNominal.replaceAll(',', '')) : selectedNominal
        })
        data.push({
          name: 'sisa[]',
          value: selectedSisa
        })
        data.push({
          name: 'keterangandetail[]',
          value: dataPengembalianKasGantung.keterangandetail
        })
        data.push({
          name: 'kasgantungdetail_id[]',
          value: dataPengembalianKasGantung.id
        })
        data.push({
          name: 'kasgantung_nobukti[]',
          value: dataPengembalianKasGantung.nobukti
        })
      });
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
          url = `${apiUrl}pengembaliankasgantungheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}pengembaliankasgantungheader/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}pengembaliankasgantungheader/${Id}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}pengembaliankasgantungheader`
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
            // showSuccessDialog(response.message, response.data.nobukti)
            $("#tablePengembalian")[0].p.selectedRowIds = [];
            $('#tablePengembalian').jqGrid("clearGridData");
            $("#tablePengembalian")
              .jqGrid("setGridParam", {
                selectedRowIds: []
              })
              .trigger("reloadGrid");

            createPengembalianKasGantung();
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
              row = parseInt(selectedRows[angka]) - 1;
              let element;

              if (indexes[0] == 'bank' || indexes[0] == 'tglbukti' || indexes[0] == 'tgldari' || indexes[0] == 'tglsampai' || indexes[0] == 'kasgantungdetail_id' || indexes[0] == 'id') {
                if (indexes.length > 1) {
                  element = form.find(`[name="${indexes[0]}[]"]`)[row];
                } else {
                  element = form.find(`[name="${indexes[0]}"]`)[0];
                }

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
              } else {
                console.log(selectedRows[angka])
                element = $(`#tablePengembalian tr#${parseInt(selectedRows[angka])}`).find(`td[aria-describedby="tablePengembalian_${indexes[0]}"]`)
                $(element).addClass("ui-state-error");
                $(element).attr("title", error[0].toLowerCase())
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
    activeGrid = null
    initLookup()
    form.find('#btnSubmit').prop('disabled', false)
    if (form.data('action') == "view") {
      form.find('#btnSubmit').prop('disabled', true)
    }

    if (form.data('action') == 'add') {
      form.find('#btnSaveAdd').show()
    } else {
      form.find('#btnSaveAdd').hide()
    }
    initDatepicker()
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    removeEditingBy($('#crudForm').find('[name=id]').val())
    $('#crudModal').find('.modal-body').html(modalBody)
    editedData = {}
    initDatepicker('datepickerIndex')
  })

  function removeEditingBy(id) {

    let formData = new FormData();


    formData.append('id', id);
    formData.append('aksi', 'BATAL');
    formData.append('table', 'pengembaliankasgantungheader');

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

  function rangeKasgantung() {

    var tgldari = $('#crudForm').find(`[name="tgldari"]`).val()
    var tglsampai = $('#crudForm').find(`[name="tglsampai"]`).val()

    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    $('#loaderGrid').removeClass('d-none')
    getDataPengembalian(tgldari, tglsampai)
      .then((response) => {

        $("#tablePengembalian")[0].p.selectedRowIds = [];
        selectedId = []
        totalBayar = 0
        $.each(response.data, (index, value) => {
          if (value.pengembaliankasgantungheader_id != null) {
            selectedId.push(value.id)
            totalBayar += parseFloat(value.nominal)
          }
        })
        $('#tablePengembalian').jqGrid("clearGridData");
        setTimeout(() => {

          $("#tablePengembalian")
            .jqGrid("setGridParam", {
              datatype: "local",
              data: response.data,
              originalData: response.data,
              selectedRowIds: selectedId
            })
            .trigger("reloadGrid");
        }, 100);
      })
      .catch((errors) => {
        $('#loaderGrid').addClass('d-none')
        if (error.status === 422) {
          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()
          setErrorMessages(form, error.responseJSON.errors);
        } else {
          showDialog(error.responseJSON)
        }
      })
  }



  function enabledRow(row) {
    let check = $(`#kasgantungdetail_${row}`)
    if (check.prop("checked") == true) {
      // console.log(row);
      $(`#coa_detail_${row}`).prop('disabled', false)
      $(`#nominal_detail_${row}`).prop('disabled', false)
      $(`#keterangan_detail_${row}`).prop('disabled', false)
    } else if (check.prop("checked") == false) {
      // console.log('disabale');
      $(`#coa_detail_${row}`).prop('disabled', true)
      $(`#nominal_detail_${row}`).prop('disabled', true)
      $(`#keterangan_detail_${row}`).prop('disabled', true)
    }

  }

  function setTotal() {
    let nominalDetails = $(`#table_body [name="nominal[]"]`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#total').set(total)
  }

  function createPengembalianKasGantung() {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)

    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Add Pengembalian Kas Gantung')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    Promise
      .all([
        showDefault(form)
      ])
      .then(() => {
        if (selectedRows.length > 0) {
          clearSelectedRows()
        }
        loadPengembalianGrid()
        $('#crudModal').modal('show')
        setRange(true)
      })
      .catch((error) => {
        showDialog(error.responseJSON)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }

  function editPengembalianKasGantung(userId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Pengembalian Kas Gantung')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setTglBukti(form),
        showpengembalianKasGantung(form, userId),
      ])
      .then(() => {
        if (selectedRows.length > 0) {
          clearSelectedRows()
        }
        $('#crudModal').modal('show')
        if (isEditTgl == 'TIDAK') {
          form.find(`[name="tglbukti"]`).not('#gs_tglbukti').prop('readonly', true)
          form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
        }
        form.find(`[name="bank"]`).prop('readonly', true)
        form.find(`[name="bank"]`).parent('.input-group').find('.button-clear').remove()
        form.find(`[name="bank"]`).parent('.input-group').find('.input-group-append').remove()
      })
      .catch((error) => {
        showDialog(error.responseJSON)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })

  }

  function deletePengembalianKasGantung(userId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-trash"></i>
    Delete
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Pengembalian Kas Gantung')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    form.find('#btnTampil').prop('disabled', true)

    Promise
      .all([
        showpengembalianKasGantung(form, userId)
      ])
      .then(() => {
        if (selectedRows.length > 0) {
          clearSelectedRows()
        }
        $('#crudModal').modal('show')
        form.find(`[name="tglbukti"]`).prop('readonly', true)
        form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
        form.find(`[name="tgldari"]`).prop('readonly', true)
        form.find(`[name="tgldari"]`).parent('.input-group').find('.input-group-append').remove()
        form.find(`[name="tglsampai"]`).prop('readonly', true)
        form.find(`[name="tglsampai"]`).parent('.input-group').find('.input-group-append').remove()
        form.find(`[name="bank"]`).prop('readonly', true)
        form.find(`[name="bank"]`).parent('.input-group').find('.button-clear').remove()
        form.find(`[name="bank"]`).parent('.input-group').find('.input-group-append').remove()
      })
      .catch((error) => {
        showDialog(error.responseJSON)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }

  function viewPengembalianKasGantung(userId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'view')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('View Pengembalian Kas Gantung')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    form.find('#btnTampil').prop('disabled', true)

    Promise
      .all([
        showpengembalianKasGantung(form, userId)
      ])
      .then(() => {
        if (selectedRows.length > 0) {
          clearSelectedRows()
        }
        $('#crudModal').modal('show')
        form.find(`[name="tglbukti"]`).prop('readonly', true)
        form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
        form.find(`[name="tgldari"]`).prop('readonly', true)
        form.find(`[name="tgldari"]`).parent('.input-group').find('.input-group-append').remove()
        form.find(`[name="tglsampai"]`).prop('readonly', true)
        form.find(`[name="tglsampai"]`).parent('.input-group').find('.input-group-append').remove()
      })
      .catch((error) => {
        showDialog(error.responseJSON)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }

  function clearSelectedRowsPengembalian() {
    getSelectedRows = $("#tablePengembalian").getGridParam("selectedRowIds");
    $("#tablePengembalian")[0].p.selectedRowIds = [];
    $.each(getSelectedRows, function(index, value) {
      let originalGridData = $("#tablePengembalian")
        .jqGrid("getGridParam", "originalData")
        .find((row) => row.id == value);

      if ($('#crudForm').data('action') == 'edit') {
        sisa = parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal)
      } else {
        sisa = parseFloat(originalGridData.sisa)
      }
      $("#tablePengembalian").jqGrid(
        "setCell",
        value,
        "sisa",
        sisa
      );
      $("#tablePengembalian").jqGrid("setCell", value, "nominal", 0);
      $(`#tablePengembalian tr#${value}`).find(`td[aria-describedby="tablePinjaman_nominal"]`).attr("value", 0)
      $("#tablePengembalian").jqGrid("setCell", value, "coadetail", null);
    })

    $('#tablePengembalian').trigger('reloadGrid');
    setTotalNominal()
    setTotalSisa()
  }

  function selectAllRowsPengembalian() {

    let originalData = $("#tablePengembalian").getGridParam("data");
    let getSelectedRows = originalData.map((data) => data.id);
    $("#tablePengembalian")[0].p.selectedRowIds = [];

    setTimeout(() => {
      $("#tablePengembalian")
        .jqGrid("setGridParam", {
          selectedRowIds: getSelectedRows
        })
        .trigger("reloadGrid");

      setTotalNominal()
      setTotalSisa()
    })
  }

  function loadPengembalianGrid() {
    let disabled = '';
    if ($('#crudForm').data('action') == 'delete') {
      disabled = 'disabled'
    }
    //console.log('test')
    $("#tablePengembalian")
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
                      selectAllRowsPengembalian()
                    } else {
                      clearSelectedRowsPengembalian()
                    }
                  })
                } else {
                  $(element).attr('disabled', true)
                }

              }
            },
            formatter: function(value, rowOptions, rowData) {
              let disabled = '';
              if (($('#crudForm').data('action') == 'delete') || ($('#crudForm').data('action') == 'view')) {
                disabled = 'disabled'
              }
              return `<input type="checkbox" class="checkbox-jqgrid" value="${rowData.id}" ${disabled} onChange="checkboxHandlerPengembalian(this, ${rowData.id})">`;
            },
          },
          {
            label: "id",
            name: "id",
            hidden: true,
            search: false,
          },
          {
            label: "NO BUKTI",
            name: "nobukti",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            sortable: true,
          },
          {
            label: "TGL BUKTI",
            name: "tglbukti",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: "SISA",
            name: "sisa",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            sortable: true,
            align: "right",
            formatter: currencyFormat,
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
                  let originalGridData = $("#tablePengembalian")
                    .jqGrid("getGridParam", "originalData")
                    .find((row) => row.id == rowObject.rowId);

                  let localRow = $("#tablePengembalian").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );
                  localRow.nominal = event.target.value;
                  let totalSisa = 0;
                  let nominal = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])
                  if ($('#crudForm').data('action') == 'edit') {
                    totalSisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal)) - nominal
                  } else {
                    totalSisa = originalGridData.sisa - nominal
                  }

                  $("#tablePengembalian").jqGrid(
                    "setCell",
                    rowObject.rowId,
                    "sisa",
                    totalSisa
                  );

                  if (totalSisa < 0) {
                    showDialog('sisa tidak boleh minus')
                    $("#tablePengembalian").jqGrid(
                      "setCell",
                      rowObject.rowId,
                      "nominal",
                      0
                    );
                    if (originalGridData.sisa == 0) {
                      $("#tablePengembalian").jqGrid("setCell", rowObject.rowId, "sisa", (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal)));
                    } else {
                      if ($('#crudForm').data('action') == 'edit') {
                        $("#tablePengembalian").jqGrid("setCell", rowObject.rowId, "sisa", (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal)));
                      } else {
                        $("#tablePengembalian").jqGrid("setCell", rowObject.rowId, "sisa", originalGridData.sisa);
                      }
                    }
                  }

                  setTotalNominal()
                  setTotalSisa()
                },
              }],
            },
            sortable: false,
            sorttype: "int",
          },
          {
            label: "KETERANGAN",
            name: "keterangandetail",
            width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
            sortable: false,
            editable: true,
            editoptions: {
              dataEvents: [{
                type: "keyup",
                fn: function(event, rowObject) {
                  let localRow = $("#tablePengembalian").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );
                  localRow.keterangandetail = event.target.value;
                }
              }]
            }
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
        editableColumns: ["nominal"],
        selectedRowIds: [],
        // onCellSelect: function(rowid, iCol, cellcontent, e) {
        //   console.log("Selected Cell - Row ID: " + rowid + ", Column Index: " + iCol);
        // },
        afterRestoreCell: function(rowId, value, indexRow, indexColumn) {
          let originalGridData = $("#tablePengembalian")
            .jqGrid("getGridParam", "originalData")
            .find((row) => row.id == rowId);

          let localRow = $("#tablePengembalian").jqGrid("getLocalRow", rowId);

          let getBayar = $("#tablePengembalian").jqGrid("getCell", rowId, "nominal")
          let nominal = (getBayar != '') ? parseFloat(getBayar.replaceAll(',', '')) : 0

          sisa = 0
          if ($('#crudForm').data('action') == 'edit') {
            sisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal)) - nominal
          } else {
            sisa = originalGridData.sisa - nominal
          }
          console.log(indexColumn)
          if (indexColumn == 6) {

            $("#tablePengembalian").jqGrid(
              "setCell",
              rowId,
              "sisa",
              sisa
            );
          }
          setTotalNominal()
          setTotalSisa()
        },
        isCellEditable: function(cellname, iRow, iCol) {
          let rowData = $(this).jqGrid("getRowData")[iRow - 1];

          return $(this)
            .find(`tr input[value=${rowData.id}]`)
            .is(":checked");
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
                initAutoNumeric($(this).find(`td[aria-describedby="tablePengembalian_nominal"]`))
              });
          }, 100);

          $('#loaderGrid').addClass('d-none')
          setTotalNominal()
          setTotalSisa()
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
      })
      .jqGrid("excelLikeGrid", {
        beforeDeleteCell: function(rowId, iRow, iCol, event) {
          let localRow = $("#tablePengembalian").jqGrid("getLocalRow", rowId);

          let originalGridData = $("#tablePengembalian")
            .jqGrid("getGridParam", "originalData")
            .find((row) => row.id == rowId);
          let totalSisa
          if ($('#crudForm').data('action') == 'edit') {
            totalSisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal))
          } else {
            totalSisa = parseFloat(originalGridData.sisa)
          }
          $("#tablePengembalian").jqGrid(
            "setCell",
            rowId,
            "sisa",
            totalSisa
          );

          return true;
        },
      });
    loadClearFilter($('#tablePengembalian'))
  }

  $(document).on('click', '#resetdatafilter_tablePengembalian', function(event) {
    selectedRowsPengembalian = $("#tablePengembalian").getGridParam("selectedRowIds");
    $.each(selectedRowsPengembalian, function(index, value) {
      $('#tablePengembalian').jqGrid('saveCell', value, 8); //emptycell
      $('#tablePengembalian').jqGrid('saveCell', value, 6); //nominal
      $('#tablePengembalian').jqGrid('saveCell', value, 7); //keterangan
    })

  });
  $(document).on('click', '#gbox_tablePengembalian .ui-jqgrid-hbox .ui-jqgrid-htable thead .ui-search-toolbar th td a.clearsearchclass', function(event) {
    selectedRowsPengembalian = $("#tablePengembalian").getGridParam("selectedRowIds");
    $.each(selectedRowsPengembalian, function(index, value) {
      $('#tablePengembalian').jqGrid('saveCell', value, 8); //emptycell
      $('#tablePengembalian').jqGrid('saveCell', value, 6); //nominal
      $('#tablePengembalian').jqGrid('saveCell', value, 7); //keterangan
    })
  })

  function setTotalNominal() {
    let nominalDetails = $(`#tablePengembalian`).find(`td[aria-describedby="tablePengembalian_nominal"]`)
    let nominal = 0
    selectedRowsPinjaman = $("#tablePengembalian").getGridParam("selectedRowIds");
    $.each(selectedRowsPinjaman, function(index, value) {
      dataPinjaman = $("#tablePengembalian").jqGrid("getLocalRow", value);
      nominals = (dataPinjaman.nominal == undefined || dataPinjaman.nominal == '') ? 0 : dataPinjaman.nominal;
      console.log('dataPinjaman ', dataPinjaman.nominal)
      getNominal = (isNaN(nominals)) ? parseFloat(nominals.replaceAll(',', '')) : parseFloat(nominals)
      nominal = nominal + getNominal
    })
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePengembalian_nominal"]`).text(nominal))
  }

  function setTotalSisa() {
    let sisaDetails = $(`#tablePengembalian`).find(`td[aria-describedby="tablePengembalian_sisa"]`)
    let sisa = 0
    let originalData = $("#tablePengembalian").getGridParam("data");
    $.each(originalData, function(index, value) {
      sisas = value.sisa;
      sisas = (isNaN(sisas)) ? parseFloat(sisas.replaceAll(',', '')) : parseFloat(sisas)
      sisa += sisas

    })
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePengembalian_sisa"]`).text(sisa))
  }

  function getDataPengembalian(dari, sampai, id) {
    aksi = $('#crudForm').data('action')

    data = {}
    urlPengembalian = ''
    if (aksi == 'edit') {
      id = $(`#crudForm`).find(`[name="id"]`).val()
      urlPengembalian = `${apiUrl}pengembaliankasgantungheader/${id}/edit/getpengembalian`
    } else if ((aksi == 'delete') || (aksi == 'view')) {
      urlPengembalian = `${apiUrl}pengembaliankasgantungheader/${id}/delete/getpengembalian`
      attribut = 'disabled'
      forCheckbox = 'disabled'
    } else if (aksi == 'add') {
      urlPengembalian = `${apiUrl}pengembaliankasgantungheader/getkasgantung`
    }


    data = {
      limit: 0,
      tgldari: dari,
      tglsampai: sampai,
      bank_id: $(`#crudForm`).find(`[name="bank_id"]`).val()
    }

    return new Promise((resolve, reject) => {
      $.ajax({
        url: urlPengembalian,
        dataType: "JSON",
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: data,
        success: (response) => {
          resolve(response);
        },
        error: error => {
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()


            errors = error.responseJSON.errors
            reject(errors)

          } else {
            showDialog(error.responseJSON)
          }
        },
        error: error => {
          reject(error)
        }
      });
    });
  }

  function checkboxHandlerPengembalian(element, rowId) {

    let isChecked = $(element).is(":checked");
    let editableColumns = $("#tablePengembalian").getGridParam("editableColumns");
    let selectedRowIds = $("#tablePengembalian").getGridParam("selectedRowIds");
    let originalGridData = $("#tablePengembalian")
      .jqGrid("getGridParam", "originalData")
      .find((row) => row.id == rowId);

    editableColumns.forEach((editableColumn) => {

      if (!isChecked) {
        for (var i = 0; i < selectedRowIds.length; i++) {
          if (selectedRowIds[i] == rowId) {
            selectedRowIds.splice(i, 1);
          }
        }
        if ($('#crudForm').data('action') == 'edit') {
          sisa = parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal)
        } else {
          sisa = parseFloat(originalGridData.sisa)
        }
        $("#tablePengembalian").jqGrid(
          "setCell",
          rowId,
          "sisa",
          sisa
        );
        $("#tablePengembalian").jqGrid("setCell", rowId, "nominal", 0);
        $(`#tablePengembalian tr#${rowId}`).find(`td[aria-describedby="tablePinjaman_nominal"]`).attr("value", 0)
        $("#tablePengembalian").jqGrid("setCell", rowId, "coadetail", null);
        setTotalNominal()
        setTotalSisa()
      } else {
        selectedRowIds.push(rowId);
        setTotalNominal()
        setTotalSisa()
      }
    });

    $("#tablePengembalian").jqGrid("setGridParam", {
      selectedRowIds: selectedRowIds,
    });

  }

  function showpengembalianKasGantung(form, userId) {
    return new Promise((resolve, reject) => {


      $.ajax({
        url: `${apiUrl}pengembaliankasgantungheader/${userId}`,
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
            // if (index == 'pelanggan') {
            //   element.data('current-value', value)
            // }
          })
          loadPengembalianGrid();

          getDataPengembalian($('#crudForm').find(`[name="tgldari"]`).val(), $('#crudForm').find(`[name="tglsampai"]`).val(), userId).then((response) => {

            let selectedId = []
            totalBayar = 0
            $.each(response.data, (index, value) => {
              if (value.pengembaliankasgantungheader_id != null) {
                selectedId.push(value.id)
                totalBayar += parseFloat(value.nominal)
              }
            })
            $('#tablePengembalian').jqGrid("clearGridData");
            setTimeout(() => {

              $("#tablePengembalian")
                .jqGrid("setGridParam", {
                  datatype: "local",
                  data: response.data,
                  originalData: response.data,
                  selectedRowIds: selectedId
                })
                .trigger("reloadGrid");
            }, 100);
            initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePengembalian_nominal"]`).text(totalBayar))
          });
          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function setRowNumbers() {
    let elements = $('#detailList tbody tr td:nth-child(1)')

    elements.each((index, element) => {
      $(element).text(index + 1)
    })
  }

  function getKasGantung(dari, sampai) {
    $('#detailList tbody').html('')

    $.ajax({
      url: `${apiUrl}pengembaliankasgantungheader/getkasgantung`,
      method: 'GET',
      dataType: 'JSON',
      data: {
        limit: 0,
        tgldari: dari,
        tglsampai: sampai
      },
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        let totalNominal = 0
        let row = 0
        $('#detailList tbody').html('')
        $.each(response.data, (index, detail) => {
          let id = detail.id
          row++
          let nominal = new Intl.NumberFormat('en-US').format(detail.nominal);
          totalNominal = parseFloat(totalNominal) + parseFloat(detail.nominal)
          let detailRow = $(`
          <tr>
            <td ><input name='kasgantungdetail_id[]' type="checkbox" class="checkItem" id="kasgantungdetail_${detail.detail_id}" data-id="${detail.detail_id}"  value="${detail.detail_id}"></td>
            <td>${row}</td>
            <td>${detail.nobukti}</td>
            <td>${detail.tglbukti}</td>
            <td>
              <input type="hidden" name="coadetail[]">
               <input type="text" name="ketcoadetail[]" disabled id="coa_detail_${detail.detail_id}"  class="form-control coa_detail_${detail.detail_id}">
              </td>
              <td class="text-right" >
                ${nominal}
                <input type="text" name="nominal[]" disabled id="nominal_detail_${detail.detail_id}" hidden class="form-control nominal_detail_${detail.detail_id}" value="${detail.nominal}">
              </td>
            <td><input type="text" name="keterangandetail[]" disabled id="keterangan_detail_${detail.detail_id}"  class="form-control keterangan_detail_${detail.detail_id}"></td>
          </tr>`)
          $('#detailList tbody').append(detailRow)
          $(`.coa_detail_${detail.detail_id}`).lookup({
            title: 'akun pusat Lookup',
            fileName: 'akunpusat',
            beforeProcess: function(test) {
              // var levelcoa = $(`#levelcoa`).val();
              this.postData = {
                levelCoa: '3',
                Aktif: 'AKTIF',
              }
            },
            onSelectRow: (akunpusat, element) => {
              element.parents('td').find(`[name="coadetail[]"]`).val(akunpusat.coa)
              element.val(akunpusat.keterangancoa)
              element.data('currentValue', element.val())
            },
            onCancel: (element) => {
              element.val(element.data('currentValue'))
            },
            onClear: (element) => {
              element.parents('td').find(`[name="coadetail[]"]`).val('')
              element.val('')
              element.data('currentValue', element.val())
            }
          })
        })
        totalNominal = new Intl.NumberFormat('en-US').format(totalNominal);
        $('#nominalPiutang').html(`${totalNominal}`)
      }
    })
  }

  function getPengembalian(userId) {
    $('#detailList tbody').html('')
    $.ajax({
      url: `${apiUrl}pengembaliankasgantungheader/getpengembalian/${userId}`,
      method: 'GET',
      dataType: 'JSON',
      data: {
        limit: 0,
      },
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        let totalNominal = 0
        let row = 0
        $('#detailList tbody').html('')
        $.each(response.data, (index, detail) => {
          let id = detail.id
          row++
          let nominal = new Intl.NumberFormat('en-US').format(detail.nominal);
          totalNominal = parseFloat(totalNominal) + parseFloat(detail.nominal)
          let detailRow = $(`
          <tr>
            <td ><input name='kasgantungdetail_id[]' type="checkbox" checked class="checkItem" id="kasgantungdetail_${detail.detail_id}" data-id="${detail.detail_id} "  value="${detail.detail_id}"></td>
            <td>${row}</td>
            <td>${detail.nobukti}</td>
            <td>${detail.tglbukti}</td>
            <td> <input type="text" name="coadetail[]" value="${detail.coadetail}" id="coa_detail_${detail.detail_id}" class="form-control coa-lookup coa_detail_${detail.detail_id}"></td>
            <td class="text-right" >
                ${nominal}
                <input type="text" name="nominal[]" disabled id="nominal_detail_${detail.detail_id}" hidden class="form-control nominal_detail_${detail.detail_id}" value="${detail.nominal}">
              </td>
            <td><input type="text" name="keterangandetail[]" value="${detail.keterangandetail}" id="keterangan_detail_${detail.detail_id}" class="form-control"></td>
          </tr>`)
          $('#detailList tbody').append(detailRow)
          $(`.coa_detail_${detail.detail_id}`).lookup({
            title: 'akun pusat Lookup',
            fileName: 'akunpusat',
            beforeProcess: function(test) {
              // var levelcoa = $(`#levelcoa`).val();
              this.postData = {
                levelCoa: '3',
                Aktif: 'AKTIF',
              }
            },
            onSelectRow: (akunpusat, element) => {
              element.val(akunpusat.coa)
              element.data('currentValue', element.val())
            },
            onCancel: (element) => {
              element.val(element.data('currentValue'))
            },
            onClear: (element) => {
              element.val('')
              element.data('currentValue', element.val())
            }
          })
        })
        totalNominal = new Intl.NumberFormat('en-US').format(totalNominal);
        $('#nominalPiutang').html(`${totalNominal}`)
      }
    })

  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}pengembaliankasgantungheader/field_length`,
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

  function cekValidasi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}pengembaliankasgantungheader/${Id}/cekvalidasi`,
      method: 'POST',
      dataType: 'JSON',
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      data: {
        aksi: Aksi
      },
      success: response => {
        // console.log(response)
        var error = response.error

        if (error) {
          showDialog(response)
        } else {
          if (Aksi == 'PRINTER BESAR') {
            window.open(`{{ route('pengembaliankasgantungheader.report') }}?id=${Id}&printer=reportPrinterBesar`)
          } else if (Aksi == 'PRINTER KECIL') {
            window.open(`{{ route('pengembaliankasgantungheader.report') }}?id=${Id}&printer=reportPrinterKecil`)
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
        //       window.open(`{{ route('pengembaliankasgantungheader.report') }}?id=${Id}&printer=reportPrinterBesar`)
        //     } else if (Aksi == 'PRINTER KECIL') {
        //       window.open(`{{ route('pengembaliankasgantungheader.report') }}?id=${Id}&printer=reportPrinterKecil`)
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
      url: `{{ config('app.api_url') }}pengembaliankasgantungheader/${Id}/cekValidasiAksi`,
      method: 'POST',
      dataType: 'JSON',
      data: {
        aksi: Aksi
      },
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      success: response => {
        var error = response.error
        if (error) {
          showDialog(response)
        } else {
          if (Aksi == 'EDIT') {
            editPengembalianKasGantung(Id)
          }
          if (Aksi == 'DELETE') {
            deletePengembalianKasGantung(Id)
          }
        }
        // var kondisi = response.kondisi
        // if (kondisi == true) {
        //   showDialog(response.message['keterangan'])
        // } else {
        //   if (Aksi == 'EDIT') {
        //     editPengembalianKasGantung(Id)
        //   }
        //   if (Aksi == 'DELETE') {
        //     deletePengembalianKasGantung(Id)
        //   }
        // }

      }
    })
  }

  function showDefault(form) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}pengembaliankasgantungheader/default`,
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

  function initLookup() {
    $('.akunpusat-lookup').lookup({
      title: 'akun pusat Lookup',
      fileName: 'akunpusat',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {
          levelCoa: '3',
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (akunpusat, element) => {
        element.val(akunpusat.coa)
        element.data('currentValue', element.val())
      },

      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        element.data('currentValue', element.val())
      },
      onClear: (element) => {
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.penerimaan-lookup').lookup({
      title: 'penerimaan Lookup',
      fileName: 'penerimaan',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (penerimaan, element) => {
        element.val(penerimaan.nobukti)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    // $('.pelanggan-lookup').lookup({
    //   title: 'pelanggan Lookup',
    //   fileName: 'pelanggan',
    //   beforeProcess: function(test) {
    //     // var levelcoa = $(`#levelcoa`).val();
    //     this.postData = {

    //       Aktif: 'AKTIF',
    //     }
    //   },
    //   onSelectRow: (pelanggan, element) => {
    //     element.val(pelanggan.namapelanggan)
    //     $(`#${element[0]['name']}Id`).val(pelanggan.id)
    //     element.data('currentValue', element.val())
    //   },
    //   onCancel: (element) => {
    //     element.val(element.data('currentValue'))
    //   },
    //   onClear: (element) => {
    //     element.val('')
    //     $(`#${element[0]['name']}Id`).val('')
    //     element.data('currentValue', element.val())
    //   }
    // })
    $('.bank-lookup').lookup({
      title: 'bank Lookup',
      fileName: 'bank',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
          tipe: 'KAS'
        }
      },
      onSelectRow: (bank, element) => {
        element.val(bank.namabank)
        $(`#${element[0]['name']}Id`).val(bank.id)
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
        value: 'PENGEMBALIAN KAS GANTUNG'
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