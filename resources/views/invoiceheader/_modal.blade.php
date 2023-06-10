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

                <div class="col-12 col-md-2 text-right">
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
                    TGL TERIMA <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-12 col-md-4">
                  <div class="input-group">
                    <input type="text" name="tglterima" class="form-control datepicker">
                  </div>
                </div>
                <div class="col-12 col-md-2  text-right">
                  <label class="col-form-label">
                    Jenis Order <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-12 col-md-4">
                  <input type="hidden" name="jenisorder_id">
                  <input type="text" name="jenisorder" class="form-control jenisorder-lookup">
                </div>
              </div>

              <div class="row form-group">
                <div class="col-12 col-md-2">
                  <label class="col-form-label">
                    AGEN <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-12 col-md-4">
                  <input type="hidden" name="agen_id">
                  <input type="text" name="agen" class="form-control agen-lookup">
                </div>

                <div class="col-12 col-md-2  text-right">
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

              
              </div>

              <div class="row form-group mb-5">
                <div class="col-md-2">
                  <button class="btn btn-secondary" id="btnTampil"><i class="fas fa-sync"></i> RELOAD</button>
                </div>
              </div>

            </div>

            <table id="tableInvoice"></table>

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
        name: 'tglterima',
        value: form.find(`[name="tglterima"]`).val()
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
        value: selectedRowsInvoice
      })
      $.each(selectedRowsInvoice, function(index, value) {
        dataInvoice = $("#tableInvoice").jqGrid("getLocalRow", value);
        let selectedExtra = dataInvoice.nominalextra
        let selectedRetribusi = (dataInvoice.nominalretribusi == undefined) ? 0 : dataInvoice.nominalretribusi;
        console.log(selectedExtra)
        console.log(isNaN(selectedExtra))
        data.push({
          name: 'nominalextra[]',
          value: (isNaN(selectedExtra)) ? parseFloat(selectedExtra.replaceAll(',', '')) : selectedExtra
        })
        data.push({
          name: 'nominalretribusi[]',
          value: (isNaN(selectedRetribusi)) ? parseFloat(selectedRetribusi.replaceAll(',', '')) : selectedRetribusi
        })
        data.push({
          name: 'sp_id[]',
          value: dataInvoice.id
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
            if (error.responseJSON.errors) {
              showDialog(error.statusText, error.responseJSON.errors.join('<hr>'))
            } else if (error.responseJSON.message) {
              showDialog(error.statusText, error.responseJSON.message)
            } else {
              showDialog(error.statusText, error.statusText)
            }
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
    initLookup()
    initDatepicker()
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'

    $('#crudModal').find('.modal-body').html(modalBody)
  })

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
    loadInvoiceGrid();
  }

  function editInvoiceHeader(invId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
      Simpan
    `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Invoice')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    
    Promise
      .all([
        showInvoiceHeader(form, invId, 'edit')
      ])
      .then(() => {
        clearSelectedRows()
        $('#gs_').prop('checked', false)
        $('#crudModal').modal('show')
        form.find(`[name="tglbukti"]`).prop('readonly', true)
        form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
        form.find(`[name="agen"]`).prop('readonly', true)
        form.find(`[name="agen"]`).parent('.input-group').find('.input-group-append').remove()
        form.find(`[name="agen"]`).parent('.input-group').find('.button-clear').remove()
        form.find(`[name="jenisorder"]`).prop('readonly', true)
        form.find(`[name="jenisorder"]`).parent('.input-group').find('.input-group-append').remove()
        form.find(`[name="jenisorder"]`).parent('.input-group').find('.button-clear').remove()

      })
      .catch((error) => {
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }

  function deleteInvoiceHeader(invId) {
    let form = $('#crudForm') 

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Hapus
    `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Invoice')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    form.find('#btnTampil').prop('disabled', true)

    Promise
      .all([
        showInvoiceHeader(form, invId, 'edit')
      ])
      .then(() => {
        clearSelectedRows()
        $('#gs_').prop('checked', false)
        $('#crudModal').modal('show')
      })
      .catch((error) => {
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
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

    if ($('#crudForm').find(`[name="agen_id"]`).val() != '' && $('#crudForm').find(`[name="jenisorder_id"]`).val() != '') {

      getDataInvoice(url).then((response) => {
        setTimeout(() => {

          $("#tableInvoice")
            .jqGrid("setGridParam", {
              datatype: "local",
              data: response.data,
              originalData: response.data,
              rowNum: response.data.length,
              selectedRowIds: []
            })
            .trigger("reloadGrid");
        }, 100);

      });
    } else {
      showDialog('Harap memilih agen, jenis order, tgl dari serta tgl sampai')
    }
  })


  function loadInvoiceGrid() {
    $("#tableInvoice")
      .jqGrid({
        datatype: 'local',
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        colModel: [{
            label: "",
            name: "",
            width: 30,
            formatter: 'checkbox',
            search: false,
            editable: false,
            formatter: function(value, rowOptions, rowData) {
              let disabled = '';
              if ($('#crudForm').data('action') == 'delete') {
                disabled = 'disabled'
              }
              return `<input type="checkbox" value="${rowData.id}" ${disabled} onChange="checkboxHandlerInvoice(this, ${rowData.id})">`;
            },
          },
          {
            label: "id",
            name: "id",
            hidden: true,
            search: false,
          },
          {
            label: "JOB TRUCKING",
            name: "jobtrucking",
            sortable: true,
          },
          {
            label: "TGL OTOBON",
            name: "tglsp",
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
            sortable: true,
          },
          {
            label: "TARIF",
            name: "tarif_id",
            sortable: true,
          },
          {
            label: "OMSET",
            name: "omset",
            sortable: true,
            align: "right",
            formatter: currencyFormat,
          },
          {
            label: "BIAYA TAMBAHAN",
            name: "nominalextra",
            sortable: true,
            align: "right",
            formatter: currencyFormat,
          },
          {
            label: "RETRIBUSI",
            name: "nominalretribusi",
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

                  retribusiDetails = $(`#tableInvoice tr:not(#${rowObject.rowId})`).find(`td[aria-describedby="tableInvoice_nominalretribusi"]`)
                  ttlRetribusi = 0
                  $.each(retribusiDetails, (index, retribusiDetail) => {
                    ttlRetribusiDetail = parseFloat($(retribusiDetail).attr('title').replaceAll(',', ''))
                    ttlRetribusis = (isNaN(ttlRetribusiDetail)) ? 0 : ttlRetribusiDetail;
                    ttlRetribusi += ttlRetribusis
                  });
                  ttlRetribusi += retribusi
                  initAutoNumeric($('.footrow').find(`td[aria-describedby="tableInvoice_nominalretribusi"]`).text(ttlRetribusi))
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
            sortable: true,
            align: "right",
            formatter: currencyFormat,
          },
          {
            label: "BAGIAN",
            name: "jenisorder_id",
            sortable: true,
          },
          {
            label: "EMKL",
            name: "agen_id",
            sortable: true,
          },
          {
            label: "LONG TRIP",
            name: "statuslongtrip",
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
            label: "KETERANGAN",
            name: "keterangan",
            sortable: true,
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

          if (indexColumn == 9) {
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
                initAutoNumeric($(this).find(`td[aria-describedby="tableInvoice_nominalretribusi"]`))
              });
          }, 100);
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


    // initAutoNumeric($('.footrow').find(`td[aria-describedby="tableInvoice_potongan"]`).text(totalPotongan))
    // initAutoNumeric($('.footrow').find(`td[aria-describedby="tableInvoice_nominallebihbayar"]`).text(totalNominalLebih))

  }

  function setTotalOmset() {
    let omsetDetails = $(`#tableInvoice`).find(`td[aria-describedby="tableInvoice_omset"]`)
    let omset = 0
    $.each(omsetDetails, (index, omsetDetail) => {
      omsetdetail = parseFloat($(omsetDetail).text().replaceAll(',', ''))
      omsets = (isNaN(omsetdetail)) ? 0 : omsetdetail;
      omset += omsets
    });
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tableInvoice_omset"]`).text(omset))
  }

  function setTotalExtra() {
    let extraDetails = $(`#tableInvoice`).find(`td[aria-describedby="tableInvoice_nominalextra"]`)
    let extra = 0
    $.each(extraDetails, (index, extraDetail) => {
      extradetail = parseFloat($(extraDetail).text().replaceAll(',', ''))
      extras = (isNaN(extradetail)) ? 0 : extradetail;
      extra += extras
    });
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tableInvoice_nominalextra"]`).text(extra))
  }

  function setTotalRetribusi() {
    let retribusiDetails = $(`#tableInvoice`).find(`td[aria-describedby="tableInvoice_nominalretribusi"]`)
    let retribusi = 0
    $.each(retribusiDetails, (index, retribusiDetail) => {
      retribusidetail = parseFloat($(retribusiDetail).text().replaceAll(',', ''))
      retribusis = (isNaN(retribusidetail)) ? 0 : retribusidetail;
      retribusi += retribusis
    });
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tableInvoice_nominalretribusi"]`).text(retribusi))
  }

  function setTotalAll() {
    let totalDetails = $(`#tableInvoice`).find(`td[aria-describedby="tableInvoice_total"]`)
    let total = 0
    $.each(totalDetails, (index, totalDetail) => {
      totaldetail = parseFloat($(totalDetail).text().replaceAll(',', ''))
      totals = (isNaN(totaldetail)) ? 0 : totaldetail;
      total += totals
    });
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tableInvoice_total"]`).text(total))
  }

  function showInvoiceHeader(form, invId, aksi) {
    return new Promise((resolve, reject) => {

      form.find(`[name="tglbukti"]`).prop('readonly', true)
      form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()

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
          // getEdit(invId, aksi)

          loadInvoiceGrid();

          getDataInvoice(`${invId}/getEdit`).then((response) => {
            console.log(response)
            let selectedIdInv = []
            let totalRetribusi = 0
            $.each(response.data, (index, value) => {
              selectedIdInv.push(value.id)
              totalRetribusi += parseFloat(value.nominalretribusi)
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
            initAutoNumeric($('.footrow').find(`td[aria-describedby="tableInvoice_nominalretribusi"]`).text(totalRetribusi))

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
          showDialog(error.statusText)
        }
      },
    }).always(() => {
      $('#processingLoader').addClass('d-none')
      $(this).removeAttr('disabled')
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