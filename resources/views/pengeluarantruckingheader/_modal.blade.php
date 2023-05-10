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
                  NO BUKTI <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-4 col-md-4">
                <input type="text" name="nobukti" class="form-control" readonly>
              </div>

              <div class="col-12 col-sm-2 col-md-2">
                <label class="col-form-label">
                  TANGGAL BUKTI <span class="text-danger">*</span>
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
                  KODE PENGELUARAN <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="pengeluarantrucking_id">
                <input type="text" name="pengeluarantrucking" class="form-control pengeluarantrucking-lookup">
              </div>
            </div>


            <div class="row form-group">
              <div class="col-12 col-sm-2 col-md-2">
                <label class="col-form-label">
                  TANGGAL dari <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-4 col-md-4">
                <div class="input-group">
                  <input type="text" name="tgldari" class="form-control datepicker">
                </div>
              </div>

              <div class="col-12 col-sm-2 col-md-2">
                <label class="col-form-label">
                  TANGGAL sampai <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-4 col-md-4">
                <div class="input-group">
                  <input type="text" name="tglsampai" class="form-control datepicker">
                </div>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  supir <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" id="supirHaeaderId" name="supirheader_id">
                <input type="text" name="supir" class="form-control supirheader-lookup">
              </div>
            </div>


            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  NAMA PERKIRAAN <span class="text-danger">*</span>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="coa">
                <input type="text" name="keterangancoa" class="form-control akunpusat-lookup">
              </div>
            </div>

            <div class="border p-3 mb-3">
              <h6>Posting Pengeluaran</h6>

              <div class="row form-group">
                <div class="col-12 col-md-2">
                  <label class="col-form-label">
                    POSTING <span class="text-danger">*</span></label>
                </div>
                <div class="col-12 col-md-4">
                  <input type="hidden" name="bank_id">
                  <input type="text" name="bank" class="form-control bank-lookup">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-md-2">
                  <label class="col-form-label">
                    NO BUKTI KAS/BANK MASUK </label>
                </div>
                <div class="col-12 col-md-4">
                  <input type="text" name="pengeluaran_nobukti" id="pengeluaran_nobukti" class="form-control" readonly>
                </div>
              </div>
            </div>

            <div id="detail-tde-section">
              <table id="tableDeposito"></table>
            </div>

            <div id="detail-bst-section">
              <table id="modalgrid"></table>
              <div id="modalgridPager"></div>
              <div id="detail-list-grid" style="display:none"></div>
            </div>
            <div id="detail-default-section" class="table-scroll table-responsive">
              <table class="table table-bordered table-bindkeys mt-3" id="detailList" style="width: 1000px;">
                <thead>
                  <tr>
                    <th width="1%" class="">No</th>
                    <th class="data_tbl tbl_checkbox" style="display:none" width="1%">Pilih</th>
                    <th width="20%" class="data_tbl tbl_supir_id">SUPIR</th>
                    <th class="data_tbl tbl_penerimaantruckingheader" width="20%">NO BUKTI PENERIMAAN TRUCKING</th>
                    <th width="14%" class="tbl_sisa">Sisa</th>
                    <th width="20%" class="tbl_nominal">Nominal</th>
                    <th class="data_tbl tbl_keterangan" width="25%">Keterangan</th>
                    <th width="1%" class="tbl_aksi">Aksi</th>
                  </tr>
                </thead>
                <tbody id="table_body" class="form-group">

                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="3" class="colspan">
                      <p class="text-right font-weight-bold">TOTAL :</p>
                    </td>
                    <td id="sisaColFoot" style="display: none">
                      <p class="text-right font-weight-bold autonumeric" id="sisaFoot"></p>
                    </td>
                    <td>
                      <p class="text-right font-weight-bold autonumeric" id="total"></p>
                    </td>
                    <td class="colmn-offset"></td>
                    <td id="tbl_addRow">
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
  var KodePengeluaranId
  let selectedRows = [];
  $(document).ready(function() {

    $("#crudForm [name]").attr("autocomplete", "off");

    $(document).on('click', "#addRow", function() {
      addRow()
    });

    $(document).on('click', '.delete-row', function(event) {
      deleteRow($(this).parents('tr'))
    })

    $(document).on('input', `#table_body [name="nominal[]"]`, function(event) {
      setTotal()
    })

    function rangeInvoice() {
      var tgldari = $('#crudForm').find(`[name="tgldari"]`).val()
      var tglsampai = $('#crudForm').find(`[name="tglsampai"]`).val()
      // console.log(tgldari, tglsampai);
      if (tgldari !== "" && tglsampai !== "") {
        getInvoice(tgldari, tglsampai)
      }
    }

    $(document).on("change", `[name=tgldari], [name=tglsampai]`, function(event) {
      rangeInvoice();
    })

    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      let data
      if (KodePengeluaranId == "TDE") {
        data = []

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
          name: 'pengeluarantrucking_id',
          value: form.find(`[name="pengeluarantrucking_id"]`).val()
        })
        data.push({
          name: 'pengeluarantrucking',
          value: form.find(`[name="pengeluarantrucking"]`).val()
        })
        data.push({
          name: 'supirheader_id',
          value: form.find(`[name="supirheader_id"]`).val()
        })
        data.push({
          name: 'supir',
          value: form.find(`[name="supir"]`).val()
        })
        data.push({
          name: 'coa',
          value: form.find(`[name="coa"]`).val()
        })
        data.push({
          name: 'keterangancoa',
          value: form.find(`[name="keterangancoa"]`).val()
        })
        data.push({
          name: 'bank_id',
          value: form.find(`[name="bank_id"]`).val()
        })
        data.push({
          name: 'bank',
          value: form.find(`[name="bank"]`).val()
        })
        data.push({
          name: 'pengeluaran_nobukti',
          value: form.find(`[name="pengeluaran_nobukti"]`).val()
        })
        let selectedRowsDeposito = $("#tableDeposito").getGridParam("selectedRowIds");
        $.each(selectedRowsDeposito, function(index, value) {
          let selectedNominal = $("#tableDeposito").jqGrid("getCell", value, "nominal")
          let selectedSisa = $("#tableDeposito").jqGrid("getCell", value, "sisa")

          data.push({
            name: 'nominal[]',
            value: (selectedNominal != '') ? parseFloat(selectedNominal.replaceAll(',', '')) : 0
          })
          data.push({
            name: 'sisa[]',
            value: (selectedSisa != '') ? parseFloat(selectedSisa.replaceAll(',', '')) : 0
          })
          data.push({
            name: 'keterangan[]',
            value: $("#tableDeposito").jqGrid("getCell", value, "keterangan")
          })
          data.push({
            name: 'penerimaantruckingheader_nobukti[]',
            value: $("#tableDeposito").jqGrid("getCell", value, "nobukti")
          })
          data.push({
            name: 'supir_id[]',
            value: form.find(`[name="supirheader_id"]`).val()
          })
          data.push({
            name: 'tde_id[]',
            value: $("#tableDeposito").jqGrid("getCell", value, "id")
          })
        });

      } else {
        data = $('#crudForm').serializeArray()

        $('#crudForm').find(`[name="nominal[]"`).each((index, element) => {
          if (KodePengeluaranId != "BST") {
            data.filter((row) => row.name === 'nominal[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominal[]"]`)[index])
          }

        })
      }

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
      data.push({
        name: 'pengeluaranheader_id',
        value: data.find(item => item.name === "pengeluarantrucking_id").value
      })


      let kodepengeluaranheader = data.find(item => item.name === "pengeluarantrucking_id").value;

      let tgldariheader = $('#tgldariheader').val();
      let tglsampaiheader = $('#tglsampaiheader').val()

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}pengeluarantruckingheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}pengeluarantruckingheader/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}pengeluarantruckingheader/${Id}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&pengeluaranheader_id=${kodepengeluaranheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}pengeluarantruckingheader`
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
          $('#crudModal').modal('hide')
          $('#crudModal').find('#crudForm').trigger('reset')

          $('#kodepengeluaranheader').val(response.data.pengeluarantrucking_id).trigger('change')

          $('#jqGrid').jqGrid('setGridParam', {
            postData: {
              pengeluaranheader_id: response.data.pengeluarantrucking_id
            },
            page: response.data.page
          }).trigger('reloadGrid');

          selectedRows = []
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

            if (KodePengeluaranId == "TDE") {
              console.log(error)
              errors = error.responseJSON.errors
              $(".ui-state-error").removeClass("ui-state-error");
              $.each(errors, (index, error) => {
                let indexes = index.split(".");
                let angka = indexes[1]
                if (index == 'tde') {
                  return showDialog(error);
                } else {

                  selectedRowsDeposito = $("#tableDeposito").getGridParam("selectedRowIds");
                  row = parseInt(selectedRowsDeposito[angka]) - 1;
                  let element;
                  if (indexes[0] == 'bank' || indexes[0] == 'pengeluarantrucking') {
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

                    element = $(`#tableDeposito tr#${parseInt(selectedRowsDeposito[angka])}`).find(`td[aria-describedby="tableDeposito_${indexes[0]}"]`)
                    $(element).addClass("ui-state-error");
                    console.log(error)
                    $(element).attr("title", error[0].toLowerCase())
                  }
                }
              });
            } else {
              setErrorMessages(form, error.responseJSON.errors);
            }
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

  function setKodePengeluaran(kode) {
    KodePengeluaranId = kode;
    $('#detailList tbody').html('')
    $('#detail-list-grid').html('')
    setTampilanForm();
    addRow()
  }

  function setTampilanForm() {
    tampilanall()
    switch (KodePengeluaranId) {
      case 'PJT':
        tampilanPJT()
        break;
      case 'TDE':
        tampilanTDE()
        break;
      case 'BST':
        tampilanBST()
        break;
      case 'BSB':
        tampilanBSB()
        break;
      default:
        tampilanall()
        break;
    }
  }

  function tampilanPJT() {

    $('[name=keterangancoa]').parents('.form-group').hide()
    $('[name=supirheader_id]').parents('.form-group').hide()
    $('[name=tgldari]').parents('.form-group').hide()
    $('#detail-bst-section').hide()
    $('#detail-tde-section').hide()
    $('#detail-default-section').show()
    $('.tbl_checkbox').hide()
    $('.tbl_supir_id').show()
    $('.tbl_aksi').show()
    $('.colspan').attr('colspan', 3);
    $('#tbl_addRow').show()
    // $('.colmn-offset').hide()
  }

  function tampilanTDE() {
    $('[name=keterangancoa]').parents('.form-group').hide()
    $('.tbl_supir_id').hide()
    $('[name=supirheader_id]').parents('.form-group').show()
    $('[name=tgldari]').parents('.form-group').hide()

    $('#detail-tde-section').show()
    $('#detail-bst-section').hide()
    $('#detail-default-section').hide()
    loadDepositoGrid()
  }

  function tampilanBST() {
    $('#detailList tbody').html('')
    $('[name=keterangancoa]').parents('.form-group').hide()
    $('[name=supirheader_id]').parents('.form-group').hide()
    $('[name=tgldari]').parents('.form-group').show()
    $('#detail-bst-section').show()
    $('#detail-default-section').hide()
    $('#detail-tde-section').hide()
    $('.tbl_checkbox').hide()
    $('.tbl_penerimaantruckingheader').hide()
    $('.tbl_supir_id').show()
    $('.tbl_aksi').show()
    $('.colspan').attr('colspan', 2);
    $('#tbl_addRow').show()
    // $('.colmn-offset').hide()
    loadModalGrid()
  }

  function tampilanBSB() {

    $('[name=keterangancoa]').parents('.form-group').hide()
    $('[name=supirheader_id]').parents('.form-group').hide()
    $('[name=tgldari]').parents('.form-group').hide()
    $('#detail-bst-section').hide()
    $('#detail-tde-section').hide()
    $('#detail-default-section').show()
    $('.tbl_checkbox').hide()
    $('.tbl_penerimaantruckingheader').hide()
    $('.tbl_supir_id').show()
    $('.tbl_aksi').show()
    $('.colspan').attr('colspan', 2);
    $('#tbl_addRow').show()
    // $('.colmn-offset').hide()
  }

  function tampilanall() {
    $('[name=keterangancoa]').parents('.form-group').show()
    $('.tbl_supir_id').show()
    $('.tbl_sisa').hide()
    $('.tbl_penerimaantruckingheader').show()
    $('[name=supirheader_id]').parents('.form-group').hide()
    $('[name=tgldari]').parents('.form-group').hide()
    $('#detail-bst-section').hide()
    $('#detail-tde-section').hide()
    $('#detail-default-section').show()
    $('.colspan').attr('colspan', 3);
    $('#sisaColFoot').hide()
    $('#sisaFoot').hide()
    $('.colmn-offset').show()

  }

  $(document).on('click', '.checkItem', function(event) {
    enabledRow($(this).data("id"))
  })

  function enabledRow(row) {
    let check = $(`#penerimaantruckingheader_id${row}`)
    if (check.prop("checked") == true) {
      $(`#nominal_${row}`).prop('disabled', false)
      $(`#penerimaantruckingheader_nobukti_detail${row}`).prop('disabled', false)
      $(`#keterangan_detail${row}`).prop('disabled', false)
    } else if (check.prop("checked") == false) {
      $(`#nominal_${row}`).prop('disabled', true)
      $(`#penerimaantruckingheader_nobukti_detail${row}`).prop('disabled', true)
      $(`#keterangan_detail${row}`).prop('disabled', true)
    }
    setTotal()

  }

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
    selectedRows = []

    $('#crudModal').find('.modal-body').html(modalBody)
  })

  function setTotal() {
    let nominalDetails = $(`#table_body [name="nominal[]"]:not([disabled])`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });
    new AutoNumeric('#total').set(total)
  }

  function createPengeluaranTruckingHeader() {
    let form = $('#crudForm')

    $('#crudModal').find('#crudForm').trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
    form.data('action', 'add')

    $('#crudModalTitle').text('Add Pengeluaran Trucking')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()


    $('#table_body').html('')
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    setDefaultBank()
    // setStatusPostingOptions(form)
    addRow()
    setTotal()
  }

  function editPengeluaranTruckingHeader(id) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
    $('#crudModalTitle').text('Edit Pengeluaran Truck')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    // Promise
    //   .all([
    //     setStatusPostingOptions(form)
    //   ])
    //   .then(() => {
    //     showPengeluaranTruckingHeader(form, id)
    //   })

    form.find(`[name="bank"]`).removeClass('bank-lookup')
    form.find(`[name="pengeluarantrucking"]`).removeClass('pengeluarantrucking-lookup')
    showPengeluaranTruckingHeader(form, id)

  }

  function deletePengeluaranTruckingHeader(id) {

    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Hapus
    `)
    $('#crudModalTitle').text('Delete Pengeluaran Truck')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    // Promise
    //   .all([
    //     setStatusPostingOptions(form)
    //   ])
    //   .then(() => {
    //     showPengeluaranTruckingHeader(form, id)
    //   })

    form.find(`[name="bank"]`).removeClass('bank-lookup')
    form.find(`[name="pengeluarantrucking"]`).removeClass('pengeluarantrucking-lookup')
    showPengeluaranTruckingHeader(form, id)

  }

  function loadDepositoGrid() {
    $("#tableDeposito")
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
              return `<input type="checkbox" value="${rowData.id}" ${disabled} onChange="checkboxDepositoHandler(this, ${rowData.id})">`;
            },
          },
          {
            label: "id",
            name: "id",
            hidden: true,
            search: false,
          },
          {
            label: "Nobukti PENERIMAAN TRUCKING",
            name: "nobukti",
            sortable: true,
          },
          {
            label: "SISA",
            name: "sisa",
            sortable: true,
            align: "right",
            formatter: currencyFormat,
          },
          {
            label: "NOMINAL",
            name: "nominal",
            align: "right",
            editable: true,
            editoptions: {
              dataInit: function(element, id) {
                initAutoNumeric($('#crudForm').find(`[id="${id.id}"]`))
              },
              dataEvents: [{
                type: "keyup",
                fn: function(event, rowObject) {
                  let originalGridData = $("#tableDeposito")
                    .jqGrid("getGridParam", "originalData")
                    .find((row) => row.id == rowObject.rowId);

                  let localRow = $("#tableDeposito").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );
                  let totalSisa

                  let nominal = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])
                  if ($('#crudForm').data('action') == 'edit') {
                    totalSisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal)) - nominal
                  } else {
                    totalSisa = originalGridData.sisa - nominal
                  }

                  $("#tableDeposito").jqGrid(
                    "setCell",
                    rowObject.rowId,
                    "sisa",
                    totalSisa
                  );

                  nominalDetails = $(`#tableDeposito tr:not(#${rowObject.rowId})`).find(`td[aria-describedby="tableDeposito_nominal"]`)
                  ttlBayar = 0
                  $.each(nominalDetails, (index, nominalDetail) => {
                    ttlBayarDetail = parseFloat($(nominalDetail).attr('title').replaceAll(',', ''))
                    ttlBayars = (isNaN(ttlBayarDetail)) ? 0 : ttlBayarDetail;
                    ttlBayar += ttlBayars
                  });
                  ttlBayar += nominal
                  initAutoNumeric($('.footrow').find(`td[aria-describedby="tableDeposito_nominal"]`).text(ttlBayar))

                  // setAllTotal()
                  setTotalSisaDeposito()
                },
              }, ],
            },
            sortable: false,
            sorttype: "int",
          },
          {
            label: "KETERANGAN",
            name: "keterangan",
            sortable: false,
            editable: false,
            width: 500
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
        afterRestoreCell: function(rowId, value, indexRow, indexColumn) {
          let originalGridData = $("#tableDeposito")
            .jqGrid("getGridParam", "originalData")
            .find((row) => row.id == rowId);

          let localRow = $("#tableDeposito").jqGrid("getLocalRow", rowId);

          let getBayar = $("#tableDeposito").jqGrid("getCell", rowId, "nominal")
          let nominal = (getBayar != '') ? parseFloat(getBayar.replaceAll(',', '')) : 0

          sisa = 0
          if ($('#crudForm').data('action') == 'edit') {
            sisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal)) - nominal
          } else {
            sisa = originalGridData.sisa
          }
          if (indexColumn == 5) {

            $("#tableDeposito").jqGrid(
              "setCell",
              rowId,
              "sisa",
              sisa
              // sisa - nominal - potongan
            );
          }
          
          setTotalSisaDeposito()
          setTotalNominalDeposito()
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
                initAutoNumeric($(this).find(`td[aria-describedby="tableDeposito_nominal"]`))
              });
          }, 100);
          setTotalNominalDeposito()
          setTotalSisaDeposito()
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
          let localRow = $("#tableDeposito").jqGrid("getLocalRow", rowId);

          $("#tableDeposito").jqGrid(
            "setCell",
            rowId,
            "sisa",
            parseInt(localRow.sisa) + parseInt(localRow.nominal)
          );

          return true;
        },
      });
    /* Append clear filter button */
    loadClearFilter($('#tableDeposito'))

    /* Append global search */
    // loadGlobalSearch($('#tableDeposito'))
  }

  function getDataDeposito(supirId, id) {
    aksi = $('#crudForm').data('action')
    data = {}
    if (aksi == 'edit') {
      console.log(id)
      if (id != undefined) {
        url = `${apiUrl}pengeluarantruckingheader/${id}/edit/gettarikdeposito`
      } else {
        url = `${apiUrl}pengeluarantruckingheader/getdeposito`
      }
    } else if (aksi == 'delete') {
      url = `${apiUrl}pengeluarantruckingheader/${id}/delete/gettarikdeposito`
      attribut = 'disabled'
      forCheckbox = 'disabled'
    } else if (aksi == 'add') {
      url = `${apiUrl}pengeluarantruckingheader/getdeposito`
      data = {
        "supir": supirId,
      }
    }

    return new Promise((resolve, reject) => {
      $.ajax({
        url: url,
        dataType: "JSON",
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: data,
        success: (response) => {
          resolve(response);
        },
      });
    });
  }

  function checkboxDepositoHandler(element, rowId) {

    let isChecked = $(element).is(":checked");
    let editableColumns = $("#tableDeposito").getGridParam("editableColumns");
    let selectedRowIds = $("#tableDeposito").getGridParam("selectedRowIds");
    let originalGridData = $("#tableDeposito")
      .jqGrid("getGridParam", "originalData")
      .find((row) => row.id == rowId);

    editableColumns.forEach((editableColumn) => {

      if (!isChecked) {
        for (var i = 0; i < selectedRowIds.length; i++) {
          if (selectedRowIds[i] == rowId) {
            selectedRowIds.splice(i, 1);
          }
        }
        sisa = 0
        if ($('#crudForm').data('action') == 'edit') {
          sisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal))
        } else {
          sisa = originalGridData.sisa
        }

        $("#tableDeposito").jqGrid(
          "setCell",
          rowId,
          "sisa",
          sisa
        );

        $("#tableDeposito").jqGrid("setCell", rowId, "nominal", 0);
        setTotalNominalDeposito()
        setTotalSisaDeposito()
      } else {
        selectedRowIds.push(rowId);

        let localRow = $("#tableDeposito").jqGrid("getLocalRow", rowId);

        if ($('#crudForm').data('action') == 'edit') {
          // if (originalGridData.sisa == 0) {

          //   let getNominal = $("#tableDeposito").jqGrid("getCell", rowId, "nominal")
          //   localRow.nominal = (getNominal != '') ? parseFloat(getNominal.replaceAll(',', '')) : 0
          // } else {
          //   localRow.nominal = originalGridData.sisa
          // }
          localRow.nominal = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.nominal) + parseFloat(originalGridData.potongan))
        }

        initAutoNumeric($(`#tableDeposito tr#${rowId}`).find(`td[aria-describedby="tableDeposito_nominal"]`))
        setTotalNominalDeposito()
        setTotalSisaDeposito()
      }
    });

    $("#tableDeposito").jqGrid("setGridParam", {
      selectedRowIds: selectedRowIds,
    });

  }

  function setTotalNominalDeposito() {
    let nominalDetails = $(`#tableDeposito`).find(`td[aria-describedby="tableDeposito_nominal"]`)
    let nominal = 0
    $.each(nominalDetails, (index, nominalDetail) => {
      nominaldetail = parseFloat($(nominalDetail).text().replaceAll(',', ''))
      nominals = (isNaN(nominaldetail)) ? 0 : nominaldetail;
      nominal += nominals
    });
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tableDeposito_nominal"]`).text(nominal))
  }

  function setTotalSisaDeposito() {
    let sisaDetails = $(`#tableDeposito`).find(`td[aria-describedby="tableDeposito_sisa"]`)
    let sisa = 0
    $.each(sisaDetails, (index, sisaDetail) => {
      sisadetail = parseFloat($(sisaDetail).text().replaceAll(',', ''))
      sisas = (isNaN(sisadetail)) ? 0 : sisadetail;
      sisa += sisas
    });
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tableDeposito_sisa"]`).text(sisa))
  }

  function cekValidasi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}pengeluarantruckingheader/${Id}/cekvalidasi`,
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
            cekValidasiAksi(Id, Aksi)
          }

        } else {
          showDialog(response.message['keterangan'])
        }
      }
    })
  }

  function cekValidasiAksi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}pengeluarantruckingheader/${Id}/cekValidasiAksi`,
      method: 'POST',
      dataType: 'JSON',
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      success: response => {
        var kondisi = response.kondisi
        if (kondisi == true) {
          showDialog(response.message['keterangan'])
        } else {
          if (Aksi == 'EDIT') {
            editPengeluaranTruckingHeader(Id)
          }
          if (Aksi == 'DELETE') {
            deletePengeluaranTruckingHeader(Id)
          }
        }

      }
    })
  }

  function setDefaultBank() {
    $.ajax({
      url: `${apiUrl}bank`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        $.each(response.data, (index, bank) => {
          // console.log(index); 
          if (bank.id == 1) {
            $('#crudForm [name=bank_id]').first().val(bank.id)
            $('#crudForm [name=bank]').first().val(bank.namabank)
            $('#crudForm [name=bank]').first().data('currentValue', $('#crudForm [name=bank]').first().val())
          }
        })
      }
    })
  }

  function showPengeluaranTruckingHeader(form, id) {
    $('#detailList tbody').html('')

    form.find(`[name="tglbukti"]`).prop('readonly', true)
    form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()

    $.ajax({
      url: `${apiUrl}pengeluarantruckingheader/${id}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        let tgl = response.data.tglbukti
        let kodepengeluaran = response.data.kodepengeluaran

        KodePengeluaranId = kodepengeluaran

        $.each(response.data, (index, value) => {
          let element = form.find(`[name="${index}"]`)
          if (element.is('select')) {
            element.val(value).trigger('change')
          } else if (element.hasClass('datepicker')) {
            element.val(dateFormat(value))
          } else {
            element.val(value)
          }

          if (kodepengeluaran === "TDE") {
            if (index == 'supir') {
              element.data('current-value', value).prop('readonly', true)
              element.parent('.input-group').find('.button-clear').remove()
              element.parent('.input-group').find('.input-group-append').remove()
            }
          }

          if (index == 'periodedari') {
            form.find(`[name="tgldari"]`).val(dateFormat(value))
          }
          if (index == 'periodesampai') {
            form.find(`[name="tglsampai"]`).val(dateFormat(value))
          }

          if (index == 'pengeluarantrucking') {
            element.data('current-value', value).prop('readonly', true)
            element.parent('.input-group').find('.button-clear').remove()
            element.parent('.input-group').find('.input-group-append').remove()
          }
          if (index == 'bank') {
            element.data('current-value', value).prop('readonly', true)
            element.parent('.input-group').find('.button-clear').remove()
            element.parent('.input-group').find('.input-group-append').remove()
          }
          if (index == 'keterangancoa') {
            element.data('current-value', value)
          }
        })

        setTampilanForm()

        if (kodepengeluaran === "TDE") {
          getDataDeposito(response.data.supirheader_id, id).then((response) => {

            let selectedId = []
            let totalBayar = 0

            $.each(response.data, (index, value) => {
              if (value.pengeluarantruckingheader_id != null) {
                selectedId.push(value.id)
                totalBayar += parseFloat(value.nominal)
              }
            })
            $('#tableDeposito').jqGrid("clearGridData");
            setTimeout(() => {

              $("#tableDeposito")
                .jqGrid("setGridParam", {
                  datatype: "local",
                  data: response.data,
                  originalData: response.data,
                  selectedRowIds: selectedId
                })
                .trigger("reloadGrid");
            }, 100);
            console.log(response.data)
            initAutoNumeric($('.footrow').find(`td[aria-describedby="tableDeposito_nominal"]`).text(totalBayar))

          });
        } else if (kodepengeluaran === "BST") {
          let detailRow = ""

          resetGrid()
          $.each(response.detail, (index, detail) => {

            let id = detail.id_detail
            let detailRow = $(`
            <div id="detail_row_${id}">
            <input type="text" value="${id}"  id="id_detail${id}" class="" name="id_detail[]"  disabled   >
            <input type="text" value="${detail.container_detail}"  id="container_detail${id}" class="" name="container_detail[]"  disabled   >
            <input type="text" value="${detail.noinvoice_detail}"  id="noinvoice_detail${id}" class="" name="noinvoice_detail[]"  disabled   >
            <input type="text" value="${detail.nominal_detail}"  id="nominal${id}" class="" name="nominal[]"  disabled   >
            <input type="text" value="${detail.nojobtrucking_detail}"  id="nojobtrucking_detail${id}" class="" name="nojobtrucking_detail[]"  disabled   >
            <input type="text" value="SUMBANGAN SOSIAL"  id="keterangan${id}" class="" name="keterangan[]"  disabled   >
            </div>
            `)
            if (detail.pengeluarantrucking_id != null) {
              selectedRows.push(detail.id_detail)
              detailRow.find(`[name="id_detail[]"]`).attr('disabled', false)
              detailRow.find(`[name="container_detail[]"]`).attr('disabled', false)
              detailRow.find(`[name="noinvoice_detail[]"]`).attr('disabled', false)
              detailRow.find(`[name="nominal[]"]`).attr('disabled', false)
              detailRow.find(`[name="nojobtrucking_detail[]"]`).attr('disabled', false)
              detailRow.find(`[name="keterangan[]"]`).attr('disabled', false)
            }
          })
          $('#detail-list-grid').append(detailRow)
          $('#modalgrid').setGridParam({
            datatype: "local",
            data: response.detail
          }).trigger('reloadGrid')
          // // console.log('dsfgdfg');
          // $('#modalgrid').jqGrid('setGridParam',{
          //   data:response.detail
          // }).trigger('reloadGrid')

          // $('.checkBoxgrid').prop('checked', true);
        } else {
          $.each(response.detail, (index, detail) => {
            let detailRow = $(`
              <tr>
                  <td></td>
                  <td class="data_tbl tbl_supir">
                      <input type="hidden" name="supir_id[]">
                      <input type="text" name="supir[]" data-current-value="${detail.supir}" class="form-control supir-lookup">
                  </td>
                  <td class="data_tbl tbl_penerimaantruckingheader">
                      <input type="text" name="penerimaantruckingheader_nobukti[]" data-current-value="${detail.penerimaantruckingheader_nobukti}" class="form-control penerimaantruckingheader-lookup">
                  </td>
                  <td class="data_tbl tbl_nominal">
                      <input type="text" name="nominal[]" class="form-control autonumeric nominal"> 
                  </td>
                  <td class="data_tbl tbl_keterangan">
                      <input type="text" name="keterangan[]" class="form-control"> 
                  </td>
                  <td>
                      <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
                  </td>
              </tr>
            `)

            detailRow.find(`[name="supir_id[]"]`).val(detail.supir_id)
            detailRow.find(`[name="supir[]"]`).val(detail.supir)
            detailRow.find(`[name="keterangan[]"]`).val(detail.keterangan)
            detailRow.find(`[name="penerimaantruckingheader_nobukti[]"]`).val(detail.penerimaantruckingheader_nobukti)
            detailRow.find(`[name="nominal[]"]`).val(detail.nominal)

            initAutoNumeric(detailRow.find(`[name="nominal[]"]`))
            $('#detailList tbody').append(detailRow)

            setTotal();

            $('.supir-lookup').last().lookup({
              title: 'Supir Lookup',
              fileName: 'supir',
              beforeProcess: function(test) {
                // var levelcoa = $(`#levelcoa`).val();
                this.postData = {
                  Aktif: 'AKTIF',
                }
              },
              onSelectRow: (supir, element) => {
                element.parents('td').find(`[name="supir_id[]"]`).val(supir.id)
                element.val(supir.namasupir)
                element.data('currentValue', element.val())
              },
              onCancel: (element) => {
                element.val(element.data('currentValue'))
              },
              onClear: (element) => {
                element.parents('td').find(`[name="supir_id[]"]`).val('')
                element.val('')
                element.data('currentValue', element.val())
              }
            })

            $('.penerimaantruckingheader-lookup').last().lookup({
              title: 'Penerimaan Trucking Lookup',
              fileName: 'penerimaantruckingheader',
              beforeProcess: function(test) {
                // var levelcoa = $(`#levelcoa`).val();
                this.postData = {

                  Aktif: 'AKTIF',
                }
              },
              onSelectRow: (penerimaantruckingheader, element) => {
                element.val(penerimaantruckingheader.nobukti)
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

        }

        setRowNumbers()
        if (form.data('action') === 'delete') {
          form.find('[name]').addClass('disabled')
          initDisabled()
        }
      }
    })
  }

  function setTotalDP() {
    let nominalDetails = $(`#table_body [name="nominalDP[]"]:not([disabled])`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#total').set(total)

  }

  $(document).on('click', `#detailList tbody [name="pinjPribadi[]"]`, function() {

    if ($(this).prop("checked") == true) {
      $(this).closest('tr').find(`td [name="nominalDP[]"]`).prop('disabled', false)
      let sisa = AutoNumeric.getNumber($(this).closest('tr').find(`td [name="sisaDP[]"]`)[0])
      initAutoNumeric($(this).closest('tr').find(`td [name="nominalDP[]"]`))

      // initAutoNumeric($(this).closest('tr').find(`td [name="nominalDP[]"]`).val(sisa))
      // let bayar = AutoNumeric.getNumber($(this).closest('tr').find(`td [name="nominalDP[]"]`)[0])
      // let totalSisa = sisa - bayar

      // $(this).closest("tr").find(".sisaDP").html(totalSisa)
      // $(this).closest("tr").find(`[name="sisaDP[]"]`).val(totalSisa)
      // initAutoNumeric($(this).closest("tr").find(".sisaDP"))
      setTotalDP()
      setSisaDP()
    } else {
      let id = $(this).val()
      $(this).closest('tr').find(`td [name="nominalDP[]"]`).remove();
      let newBayarElement = `<input type="text" name="nominalDP[]" class="form-control text-right" disabled>`
      $(this).closest('tr').find(`#${id}`).append(newBayarElement)

      let sisa = AutoNumeric.getNumber($(this).closest('tr').find(`td [name="sisaAwalDP[]"]`)[0])

      initAutoNumeric($(this).closest('tr').find(`td [name="sisaDP[]"]`).val(sisa))
      $(this).closest("tr").find(".sisaDP").html(sisa)
      initAutoNumeric($(this).closest("tr").find(".sisaDP"))

      setTotalDP()
      setSisaDP()
    }
  })

  $(document).on('input', `#table_body [name="nominalDP[]"]`, function(event) {
    setTotalDP()
    setSisaDetail(this)
  })

  function setSisaDetail(el) {
    let sisa = AutoNumeric.getNumber($(el).closest("tr").find(`[name="sisaDP[]"]`)[0])
    let sisaAwal = AutoNumeric.getNumber($(el).closest("tr").find(`[name="sisaAwalDP[]"]`)[0])
    let bayar = $(el).val()
    bayar = parseFloat(bayar.replaceAll(',', ''));
    // console.log( sisaAwal , bayar );
    bayar = Number.isNaN(bayar) ? 0 : bayar
    totalSisa = sisaAwal - bayar
    $(el).closest("tr").find(".sisaDP").html(totalSisa)
    $(el).closest("tr").find(`[name="sisaDP[]"]`).val(totalSisa)
    initAutoNumeric($(el).closest("tr").find(".sisaDP"))
    let Sisa = $(`#table_body .sisaDP`)
    let total = 0

    $.each(Sisa, (index, SISA) => {
      total += AutoNumeric.getNumber(SISA)
    });
    new AutoNumeric('#sisaFoot').set(total)
  }

  function setSisaDP() {
    let nominalDetails = $(`.sisaDP`)
    let bayar = 0
    $.each(nominalDetails, (index, nominalDetail) => {
      bayar += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#sisaFoot').set(bayar)
  }


  function addRow() {
    let detailRow = $(`
      <tr>
        <td></td>
        <td class="data_tbl tbl_supir">
          <input type="hidden" name="supir_id[]">
          <input type="text" name="supir[]"  class="form-control supir-lookup">
        </td>
        <td class="data_tbl tbl_penerimaantruckingheader">
          <input type="text" name="penerimaantruckingheader_nobukti[]"  class="form-control penerimaantruckingheader-lookup">
        </td>
        <td class="data_tbl tbl_nominal">
          <input type="text" name="nominal[]" class="form-control autonumeric nominal"> 
        </td>
        <td class="data_tbl tbl_keterangan">
          <input type="text" name="keterangan[]" class="form-control"> 
        </td>
        <td>
            <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
        </td>
      </tr>
    `)

    $('#detailList tbody').append(detailRow)

    $('.supir-lookup').last().lookup({
      title: 'Supir Lookup',
      fileName: 'supir',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (supir, element) => {
        element.parents('td').find(`[name="supir_id[]"]`).val(supir.id)
        element.val(supir.namasupir)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {

        element.parents('td').find(`[name="supir_id[]"]`).val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.penerimaantruckingheader-lookup').last().lookup({
      title: 'Penerimaan Trucking Lookup',
      fileName: 'penerimaantruckingheader',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (penerimaantruckingheader, element) => {
        element.val(penerimaantruckingheader.nobukti)
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

    initAutoNumeric(detailRow.find('.autonumeric'))
    setTampilanForm()
    setRowNumbers()
  }

  function checkboxHandler(element) {
    let value = $(element).val();
    // console.log(value);
    if (element.checked) {
      selectedRows.push($(element).val());
      $(`#detail_row_${value}`).find(`[name="id_detail[]"]`).attr('disabled', false)
      $(`#detail_row_${value}`).find(`[name="container_detail[]"]`).attr('disabled', false)
      $(`#detail_row_${value}`).find(`[name="noinvoice_detail[]"]`).attr('disabled', false)
      $(`#detail_row_${value}`).find(`[name="nominal[]"]`).attr('disabled', false)
      $(`#detail_row_${value}`).find(`[name="nojobtrucking_detail[]"]`).attr('disabled', false)
      $(`#detail_row_${value}`).find(`[name="keterangan[]"]`).attr('disabled', false)
    } else {
      for (var i = 0; i < selectedRows.length; i++) {
        if (selectedRows[i] == value) {
          selectedRows.splice(i, 1);
        }
      }
      $(`#detail_row_${value}`).find(`[name="id_detail[]"]`).attr('disabled', true)
      $(`#detail_row_${value}`).find(`[name="container_detail[]"]`).attr('disabled', true)
      $(`#detail_row_${value}`).find(`[name="noinvoice_detail[]"]`).attr('disabled', true)
      $(`#detail_row_${value}`).find(`[name="nominal[]"]`).attr('disabled', true)
      $(`#detail_row_${value}`).find(`[name="nojobtrucking_detail[]"]`).attr('disabled', true)
      $(`#detail_row_${value}`).find(`[name="keterangan[]"]`).attr('disabled', true)
    }
  }

  function loadModalGrid() {
    $("#modalgrid").jqGrid({
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "local",
        colModel: [{
            editable: true,
            edittype: 'checkbox',
            search: false,
            width: 60,
            align: 'center',
            formatoptions: {
              disabled: false
            },
            label: 'Pilih',
            name: 'id_detail',
            index: 'Pilih',
            // key:true,
            formatter: (value) => {
              return `<input type="checkbox" class="checkBoxgrid"  id="${value}_checkBoxgrid" value="${value}" onchange="checkboxHandler(this)">`
            },

          },
          {
            label: 'no invoice',
            name: 'noinvoice_detail',
          },
          {
            label: 'no job',
            name: 'nojobtrucking_detail',
          },
          {
            label: 'container',
            name: 'container_detail',
          },
          {
            label: 'nominal',
            name: 'nominal_detail',
            align: 'right',
            formatter: currencyFormat,
          },
        ],
        autowidth: true,
        shrinkToFit: false,
        height: 350,
        rowNum: 10,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [10, 20, 50, 0],
        toolbar: [true, "top"],
        sortable: true,
        viewrecords: true,
        footerrow: true,
        userDataOnFooter: true,
        loadComplete: function(data) {
          let grid = $(this)
          changeJqGridRowListText()
          initResize($(this))
          // console.log(data);
          $.each(selectedRows, function(key, value) {
            $('#modalgrid tbody tr').each(function(row, tr) {
              if ($(this).find(`td input:checkbox`).val() == value) {
                console.log(value);
                $(this).addClass('bg-light-blue')
                console.log($(this).find(`td input:checkbox`).prop('checked', true))
                $(this).find(`td input:checkbox`).prop('checked', true)
              }
            })
          });

          $('.clearsearchclass').click(function() {
            clearColumnSearch($(this))
          })

          if (indexRow > $(this).getDataIDs().length - 1) {
            indexRow = $(this).getDataIDs().length - 1;
          }

          setHighlight($(this))
        },
        onSelectRow: function(id) {
          activeGrid = $(this)
          indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
          page = $(this).jqGrid('getGridParam', 'page')
          let limit = $(this).jqGrid('getGridParam', 'postData').limit
          if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))


        },
      })
      .jqGrid('filterToolbar', {
        stringResult: true,
        searchOnEnter: false,
        defaultSearch: 'cn',
        groupOp: 'AND',
        disabledKeys: [17, 33, 34, 35, 36, 37, 38, 39, 40],
        beforeSearch: function() {
          clearGlobalSearch($('#modalgrid'))
        },
      })
      .customPager()
    /* Append clear filter button */
    loadClearFilter($('#modalgrid'))

    /* Append global search */
    loadGlobalSearch($('#modalgrid'))
  }

  function getInvoice(dari, sampai) {
    if ($('#crudForm').data('action') == 'edit') {
      bstId = $(`#crudForm`).find(`[name="id"]`).val()
      url = `${bstId}/geteditinvoice`
    } else {
      url = 'getinvoice'
    }
    $.ajax({
      url: `${apiUrl}pengeluarantruckingheader/${url}`,
      method: 'GET',
      dataType: 'JSON',
      data: {
        tgldari: dari,
        tglsampai: sampai,
        limit: 0
      },
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        resetGrid()
        let totalNominal = 0
        selectedRows = []
        $.each(response.data, (index, detail) => {
          let id = detail.id
          let detailRow = $(`
          <div id="detail_row_${detail.id_detail}">
          <input type="text" value="${detail.id_detail}"  id="id_detail${detail.id_detail}" class="" name="id_detail[]"  disabled  >
          <input type="text" value="${detail.container_detail}"  id="container_detail${detail.id_detail}" class="" name="container_detail[]"  disabled  >
          <input type="text" value="${detail.noinvoice_detail}"  id="noinvoice_detail${detail.id_detail}" class="" name="noinvoice_detail[]"  disabled  >
          <input type="text" value="${detail.nominal_detail}"  id="nominal${detail.id_detail}" class="" name="nominal[]"  disabled  >
          <input type="text" value="${detail.nojobtrucking_detail}"  id="nojobtrucking_detail${detail.id_detail}" class="" name="nojobtrucking_detail[]"  disabled  >
          <input type="text" value="SUMBANGAN SOSIAL"  id="keterangan${id}" class="" name="keterangan[]"    >
          </div>
          
          `)
          $('#detail-list-grid').append(detailRow)
          if (detail.pengeluarantrucking_id != null) {
            selectedRows.push(detail.id_detail)
            detailRow.find(`[name="id_detail[]"]`).attr('disabled', false)
            detailRow.find(`[name="container_detail[]"]`).attr('disabled', false)
            detailRow.find(`[name="noinvoice_detail[]"]`).attr('disabled', false)
            detailRow.find(`[name="nominal[]"]`).attr('disabled', false)
            detailRow.find(`[name="nojobtrucking_detail[]"]`).attr('disabled', false)
            detailRow.find(`[name="keterangan[]"]`).attr('disabled', false)
          }
        })

        $('#modalgrid').setGridParam({
          datatype: "local",
          data: response.data
        }).trigger('reloadGrid')
        // console.log(response.data);
      }
    })
    // console.log(dari, sampai);
  }

  function resetGrid() {
    $('#detail-list-grid').html('');
    $('#modalgrid').jqGrid('clearGridData')
  }

  function deleteRow(row) {
    row.remove()

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
        url: `${apiUrl}pengeluarantruckingheader/field_length`,
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

    $('.pengeluarantrucking-lookup').lookup({
      title: 'Pengeluaran Trucking Lookup',
      fileName: 'pengeluarantrucking',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (pengeluarantrucking, element) => {
        setKodePengeluaran(pengeluarantrucking.kodepengeluaran)
        if (pengeluarantrucking.kodepengeluaran == "TDE") {
          deleteRow($('#table_body tr')[0]);
        }
        $('#crudForm [name=coa]').first().val(pengeluarantrucking.coapostingdebet)
        $('#crudForm [name=pengeluarantrucking_id]').first().val(pengeluarantrucking.id)
        element.val(pengeluarantrucking.keterangan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        KodePengeluaranId = ""
        $('#crudForm [name=pengeluarantrucking_id]').first().val('')
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
        }
      },
      onSelectRow: (bank, element) => {
        $('#crudForm [name=bank_id]').first().val(bank.id)
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
    $('.supirheader-lookup').last().lookup({
      title: 'Supir Lookup',
      fileName: 'supir',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (supir, element) => {
        $(`#supirHaeaderId`).val(supir.id)
        element.val(supir.namasupir)
        element.data('currentValue', element.val())

        $('#tableDeposito').jqGrid("clearGridData");
        $("#tableDeposito")
          .jqGrid("setGridParam", {
            selectedRowIds: []
          })
          .trigger("reloadGrid");

        getDataDeposito(supir.id).then((response) => {

          console.log('before', $("#tableDeposito").jqGrid('getGridParam', 'selectedRowIds'))
          setTimeout(() => {

            $("#tableDeposito")
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
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $(`#supirHaeaderId`).val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.pengeluaran-lookup').lookup({
      title: 'Pengeluaran Lookup',
      fileName: 'pengeluaranheader',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (pengeluaranheader, element) => {
        element.val(pengeluaranheader.nobukti)
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

    $('.akunpusat-lookup').lookup({
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
        $('#crudForm [name=coa]').first().val(akunpusat.coa)
        element.val(akunpusat.keterangancoa)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=coa]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
  }
</script>
@endpush()