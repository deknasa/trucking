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
                  ALAT BAYAR <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">

                <input type="hidden" name="alatbayar_id" class="form-control">
                <input type="text" name="alatbayar" class="form-control alatbayar-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  TANGGAL CAIR <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">

                <div class="input-group">
                  <input type="text" name="tglcair" class="form-control datepicker">
                </div>
              </div>
            </div>

            <div class="row form-group">

              <div class="col-12 col-sm-2 col-md-2">
                <label class="col-form-label">
                  Supplier <span class="text-danger">*</span></label>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="supplier_id">
                <input type="text" name="supplier" class="form-control supplier-lookup">
              </div>

            </div>

            <div class="border p-3">
              <h6>Posting Pengeluaran</h6>

              <div class="row form-group">
                <div class="col-12 col-md-2">
                  <label class="col-form-label">
                    KAS / BANK <span class="text-danger">*</span></label>
                </div>
                <div class="col-12 col-md-4">
                  <input type="hidden" name="bank_id">
                  <input type="text" name="bank" class="form-control bank-lookup">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-md-2">
                  <label class="col-form-label">
                    NO BUKTI KAS / BANK KELUAR </label>
                </div>
                <div class="col-12 col-md-4">
                  <input type="text" name="pengeluaran_nobukti" id="pengeluaran_nobukti" class="form-control" readonly>
                </div>
              </div>
            </div>

            <table id="tableHutang"></table>
            <!-- <div class="table-responsive table-scroll mt-3">
              <table class="table table-bordered mt-3" id="detailList" style="width:2000px;">
                <thead class="table-secondary">
                  <tr>
                    <th width="1%"></th>
                    <th width="1%">NO</th>
                    <th width="5%">NO BUKTI</th>
                    <th width="3%">TGL BUKTI</th>
                    <th width="3%">NOMINAL HUTANG</th>
                    <th width="3%">SISA</th>
                    <th width="7%">KETERANGAN</th>
                    <th width="6%">BAYAR</th>
                    <th width="6%">POTONGAN</th>
                    <th width="7%">TOTAL</th>
                  </tr>
                </thead>
                <tbody id="table_body">

                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="4"></td>
                    <td>
                      <p id="nominalHutang" class="text-right font-weight-bold"></p>
                    </td>
                    <td>
                      <p id="sisaHutang" class="text-right font-weight-bold"></p>
                    </td>
                    <td></td>
                    <td>
                      <p id="bayarHutang" class="text-right font-weight-bold"></p>
                    </td>
                    <td>
                      <p id="potonganHutang" class="text-right font-weight-bold"></p>
                    </td>
                    <td>
                      <p id="totalHutang" class="text-right font-weight-bold"></p>
                    </td>
                  </tr>
                </tfoot>
              </table>
            </div> -->


          </div>
          <div class="modal-footer justify-content-start">
            <button id="btnSubmit" class="btn btn-primary">
              <i class="fa fa-save"></i>
              Simpan
            </button>
            <button id="btnBatal" class="btn btn-secondary" data-dismiss="modal">
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
  let bankId
  $(document).ready(function() {

    $("#crudForm [name]").attr("autocomplete", "off");

    $(document).on('input', `#table_body [name="bayar[]"]`, function(event) {
      setBayar()
      let element = $(this);
      setSisaHutang(element)
    })

    $(document).on('input', `#table_body [name="potongan[]"]`, function(event) {
      setPotongan()
      let action = $('#crudForm').data('action')
      let sisa = AutoNumeric.getNumber($(this).closest("tr").find(`[name="sisa[]"]`)[0])
      let bayar = AutoNumeric.getNumber($(this).closest("tr").find(`[name="bayar[]"]`)[0])
      let sisaAwal = AutoNumeric.getNumber($(this).closest("tr").find(`[name="sisaAwal[]"]`)[0])
      let potongan = $(this).val()
      potongan = parseFloat(potongan.replaceAll(',', ''));
      potongan = Number.isNaN(potongan) ? 0 : potongan
      let nominal = $(this).closest("tr").find(`[name="nominal[]"]`).val()
      nominal = parseFloat(nominal.replaceAll(',', ''));

      if (sisa == 0) {
        if (action == 'add') {
          totalSisa = sisaAwal - bayar - potongan
        } else {
          totalSisa = nominal - bayar - potongan
        }
      } else {
        if (action == 'add') {
          totalSisa = sisaAwal - bayar - potongan
        } else {
          totalSisa = nominal - bayar - potongan
        }
      }


      $(this).closest("tr").find(".sisa").html(totalSisa)
      initAutoNumeric($(this).closest("tr").find(".sisa"))

      let Sisa = $(`#table_body .sisa`)
      let ttlsisa = 0

      $.each(Sisa, (index, SISA) => {
        ttlsisa += AutoNumeric.getNumber(SISA)
      });

      new AutoNumeric('#sisaHutang').set(ttlsisa)

      let total = bayar - potongan
      $(this).closest("tr").find(`[name="total[]"]`).val(total)

      initAutoNumeric($(this).closest("tr").find(`[name="total[]"]`))

      let Total = $(`#table_body [name="total[]"]`)
      let gt = 0

      $.each(Total, (index, ttl) => {
        gt += AutoNumeric.getNumber(ttl)
      });

      new AutoNumeric('#totalHutang').set(gt)
      console.log(total)
    })

    $('#btnSubmit').click(function(event) {

      let method
      let url
      let form = $('#crudForm')


      event.preventDefault()

      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      // let tes = $('#crudForm').serializeArray()
      // unformatAutoNumeric(data)
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
        name: 'keterangan',
        value: form.find(`[name="keterangan"]`).val()
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
        name: 'supplier_id',
        value: form.find(`[name="supplier_id"]`).val()
      })
      data.push({
        name: 'supplier',
        value: form.find(`[name="supplier"]`).val()
      })
      data.push({
        name: 'alatbayar_id',
        value: form.find(`[name="alatbayar_id"]`).val()
      })
      data.push({
        name: 'alatbayar',
        value: form.find(`[name="alatbayar"]`).val()
      })
      data.push({
        name: 'tglcair',
        value: form.find(`[name="tglcair"]`).val()
      })

      let selectedRowsHutang = $("#tableHutang").getGridParam("selectedRowIds");
      console.log()
      data.push({
        name: 'jumlahdetail',
        value: selectedRowsHutang
      })
      $.each(selectedRowsHutang, function(index, value) {
        dataHutang = $("#tableHutang").jqGrid("getLocalRow", value);

        let selectedBayar = (dataHutang.bayar == undefined) ? 0 : dataHutang.bayar;
        let selectedPotongan = (dataHutang.potongan == undefined) ? 0 : dataHutang.potongan;
        let selectedSisa = dataHutang.sisa
        data.push({
          name: 'bayar[]',
          value: (isNaN(selectedBayar)) ? parseFloat(selectedBayar.replaceAll(',', '')) : selectedBayar
        })
        data.push({
          name: 'potongan[]',
          value: (isNaN(selectedPotongan)) ? parseFloat(selectedPotongan.replaceAll(',', '')) : selectedPotongan
        })
        data.push({
          name: 'sisa[]',
          value: selectedSisa
        })
        data.push({
          name: 'keterangan[]',
          value: dataHutang.keterangan
        })
        data.push({
          name: 'hutang_nobukti[]',
          value: dataHutang.nobukti
        })
        data.push({
          name: 'hutang_id[]',
          value: dataHutang.id
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
          url = `${apiUrl}hutangbayarheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}hutangbayarheader/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}hutangbayarheader/${Id}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}hutangbayarheader`
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

          $('#rangeHeader').find('[name=tgldariheader]').val(dateFormat(response.data.tgldariheader)).trigger('change');
          $('#rangeHeader').find('[name=tglsampaiheader]').val(dateFormat(response.data.tglsampaiheader)).trigger('change');
          $('#jqGrid').jqGrid('setGridParam', {
            page: response.data.page,
            postData: {
              tgldari: dateFormat(response.data.tgldariheader),
              tglsampai: dateFormat(response.data.tglsampaiheader)
            }
          }).trigger('reloadGrid');


          $('#detailList tbody').html('')
          $('#nominalHutang').html('')
          $('#sisaHutang').html('')
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
              row = parseInt(selectedRowsHutang[angka]) - 1;
              let element;

              if (indexes[0] == 'bank' || indexes[0] == 'alatbayar' || indexes[0] == 'tglcair' || indexes[0] == 'supplier' || indexes[0] == 'tglbukti' || indexes[0] == 'hutang_id') {
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
              } else if (indexes[0] == 'id') {
                return showDialog(error);
              } else {
                element = $(`#tableHutang tr#${parseInt(selectedRowsHutang[angka])}`).find(`td[aria-describedby="tableHutang_${indexes[0]}"]`)
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

  function setBayar() {
    let nominalDetails = $(`#table_body [name="bayar[]"]:not([disabled])`)
    let bayar = 0

    $.each(nominalDetails, (index, nominalDetail) => {
      bayar += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#bayarHutang').set(bayar)
  }

  function setSisa() {
    let nominalDetails = $(`.sisa`)
    let bayar = 0
    $.each(nominalDetails, (index, nominalDetail) => {
      bayar += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#sisaHutang').set(bayar)
  }


  function setPotongan() {
    let potongan = $(`#table_body [name="potongan[]"]:not([disabled])`)
    let totalPotongan = 0

    $.each(potongan, (index, potongan) => {
      totalPotongan += AutoNumeric.getNumber(potongan)
    });

    new AutoNumeric('#potonganHutang').set(totalPotongan)
  }

  function setTotal() {
    let total = $(`#table_body [name="total[]"]`)
    let totalHutang = 0

    $.each(total, (index, total) => {
      totalHutang += AutoNumeric.getNumber(total)
    });

    new AutoNumeric('#totalHutang').set(totalHutang)
  }



  function createHutangBayarHeader() {
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)

    form.data('action', 'add')
    $('#crudModalTitle').text('Add Pembayaran Hutang')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    $('#crudForm').find('[name=tglcair]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    initDatepicker()
    loadHutangGrid()
  }

  function editHutangBayarHeader(Id) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    $('#crudModalTitle').text('Edit Pembayaran Hutang')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        showHutangBayar(form, Id)
      ])
      .then(() => {
        clearSelectedRows()
        $('#gs_').prop('checked', false)
        $('#crudModal').modal('show')
        form.find(`[name="tglbukti"]`).prop('readonly', false)
        // form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
        form.find(`[name="alatbayar"]`).prop('readonly', true)
        form.find(`[name="alatbayar"]`).parent('.input-group').find('.input-group-append').remove()
        form.find(`[name="alatbayar"]`).parent('.input-group').find('.button-clear').remove()
        form.find(`[name="supplier"]`).prop('readonly', true)
        form.find(`[name="supplier"]`).parent('.input-group').find('.input-group-append').remove()
        form.find(`[name="supplier"]`).parent('.input-group').find('.button-clear').remove()
        form.find(`[name="bank"]`).prop('readonly', true)
        form.find(`[name="bank"]`).parent('.input-group').find('.input-group-append').remove()
        form.find(`[name="bank"]`).parent('.input-group').find('.button-clear').remove()

      })
      .catch((error) => {
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })

  }

  function deleteHutangBayarHeader(Id) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    $('#crudModalTitle').text('Delete Pembayaran Hutang')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        showHutangBayar(form, Id)
      ])
      .then(() => {
        clearSelectedRows()
        $('#gs_').prop('checked', false)
        $('#crudModal').modal('show')
        form.find(`[name="tglbukti"]`).prop('readonly', true)
        form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()

      })
      .catch((error) => {
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }

  function showHutangBayar(form, Id) {
    return new Promise((resolve, reject) => {

      $.ajax({
        url: `${apiUrl}hutangbayarheader/${Id}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {

          let tgl = response.data.tglbukti
          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)

            form.find(`[name="${index}"]`).val(value).attr('disabled', false)

            if (element.hasClass('datepicker')) {
              element.val(dateFormat(value))
            }

            if (index == 'bank') {
              element.data('current-value', value)
              element.parent('.input-group').find('.button-clear').remove()
              element.parent('.input-group').find('.input-group-append').remove()
            }
            if (index == 'supplier') {
              element.data('current-value', value)
              element.parent('.input-group').find('.button-clear').remove()
              element.parent('.input-group').find('.input-group-append').remove()
            }
            if (index == 'alatbayar') {
              element.data('current-value', value)
              element.parent('.input-group').find('.button-clear').remove()
              element.parent('.input-group').find('.input-group-append').remove()
            }

            if (index != 'tglcair') {
              element.prop("readonly", true)
            }
          })

          loadHutangGrid();
          getDataHutang(response.data.supplier_id, Id).then((response) => {

            let selectedId = []
            let totalBayar = 0
            let totalPotongan = 0

            $.each(response.data, (index, value) => {
              if (value.hutangbayar_id != null) {
                selectedId.push(value.id)
                totalBayar += parseFloat(value.bayar)
                totalPotongan += parseFloat(value.potongan)
              }
            })
            $('#tableHutang').jqGrid("clearGridData");
            setTimeout(() => {

              $("#tableHutang")
                .jqGrid("setGridParam", {
                  datatype: "local",
                  data: response.data,
                  originalData: response.data,
                  rowNum: response.data.length,
                  selectedRowIds: selectedId
                })
                .trigger("reloadGrid");
            }, 100);

            initAutoNumeric($('.footrow').find(`td[aria-describedby="tableHutang_bayar"]`).text(totalBayar))
            initAutoNumeric($('.footrow').find(`td[aria-describedby="tableHutang_potongan"]`).text(totalPotongan))

          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function loadHutangGrid() {
    $("#tableHutang")
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
              return `<input type="checkbox" value="${rowData.id}" ${disabled} onChange="checkboxHutangHandler(this, ${rowData.id})">`;
            },
          },
          {
            label: "id",
            name: "id",
            hidden: true,
            search: false,
          },
          {
            label: "Nobukti HUTANG",
            name: "nobukti",
            sortable: true,
          },
          {
            label: "TGL BUKTI",
            name: "tglbukti",
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: "NOMINAL HUTANG",
            name: "nominal",
            sortable: true,
            align: "right",
            formatter: currencyFormat,
          },
          {
            label: "SISA HUTANG",
            name: "sisa",
            sortable: true,
            align: "right",
            formatter: currencyFormat,
          },
          {
            label: "KETERANGAN",
            name: "keterangan",
            sortable: false,
            editable: true,
            editoptions: {
              dataEvents: [{
                type: "keyup",
                fn: function(event, rowObject) {

                  let localRow = $("#tableHutang").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );

                  localRow.keterangan = event.target.value;
                },
              }, ],
            },
          },
          {
            label: "BAYAR",
            name: "bayar",
            align: "right",
            editable: true,
            editoptions: {
              dataInit: function(element, id) {
                initAutoNumeric($('#crudForm').find(`[id="${id.id}"]`))
              },
              dataEvents: [{
                type: "keyup",
                fn: function(event, rowObject) {
                  let originalGridData = $("#tableHutang")
                    .jqGrid("getGridParam", "originalData")
                    .find((row) => row.id == rowObject.rowId);

                  let localRow = $("#tableHutang").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );
                  let totalSisa

                  localRow.bayar = event.target.value;
                  let bayar = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])

                  // ambil data potongan per row
                  dataHutang = $("#tableHutang").jqGrid("getLocalRow", rowObject.rowId);
                  getPotongan = (dataHutang.potongan == undefined) ? 0 : dataHutang.potongan;
                  potongan = (isNaN(getPotongan)) ? parseFloat(getPotongan.replaceAll(',', '')) : getPotongan

                  if ($('#crudForm').data('action') == 'edit') {
                    totalSisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.bayar)) - bayar - parseFloat(potongan)
                  } else {
                    totalSisa = originalGridData.sisa - bayar - parseFloat(potongan)
                  }
                  grandTotal = bayar + parseFloat(potongan);

                  $("#tableHutang").jqGrid(
                    "setCell",
                    rowObject.rowId,
                    "sisa",
                    totalSisa
                  );
                  $("#tableHutang").jqGrid(
                    "setCell",
                    rowObject.rowId,
                    "total",
                    grandTotal
                  );

                  if (totalSisa < 0) {
                    showDialog('sisa tidak boleh minus')
                    $("#tableHutang").jqGrid(
                      "setCell",
                      rowObject.rowId,
                      "bayar",
                      0
                    );
                    $("#tableHutang").jqGrid("setCell", rowObject.rowId, "total", 0 + potongan);
                    if (originalGridData.sisa == 0) {
                      $("#tableHutang").jqGrid("setCell", rowObject.rowId, "sisa", (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.bayar)));
                    } else {
                      $("#tableHutang").jqGrid("setCell", rowObject.rowId, "sisa", originalGridData.sisa - potongan);
                    }
                  }
                  setTotalBayar()
                  setAllTotal()
                  setTotalSisa()
                },
              }, ],
            },
            sortable: false,
            sorttype: "int",
          },
          {
            label: "Potongan",
            name: "potongan",
            align: "right",
            editable: true,
            editoptions: {
              dataInit: function(element, id) {
                initAutoNumeric($('#crudForm').find(`[id="${id.id}"]`))
              },
              dataEvents: [{
                type: "keyup",
                fn: function(event, rowObject) {
                  let originalGridData = $("#tableHutang")
                    .jqGrid("getGridParam", "originalData")
                    .find((row) => row.id == rowObject.rowId);

                  let localRow = $("#tableHutang").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );
                  let totalSisa
                  localRow.potongan = event.target.value;
                  let potongan = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])

                  // ambil data potongan per row
                  dataHutang = $("#tableHutang").jqGrid("getLocalRow", rowObject.rowId);
                  getBayar = (dataHutang.bayar == undefined) ? 0 : dataHutang.bayar;
                  bayar = (isNaN(getBayar)) ? parseFloat(getBayar.replaceAll(',', '')) : getBayar

                  if ($('#crudForm').data('action') == 'edit') {
                    totalSisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.bayar)) - parseFloat(bayar) - potongan
                  } else {
                    totalSisa = originalGridData.sisa - parseFloat(bayar) - potongan
                  }

                  grandTotal = parseFloat(bayar) + potongan;

                  $("#tableHutang").jqGrid(
                    "setCell",
                    rowObject.rowId,
                    "sisa",
                    totalSisa
                  );

                  $("#tableHutang").jqGrid(
                    "setCell",
                    rowObject.rowId,
                    "total",
                    grandTotal
                  );

                  if (totalSisa < 0) {
                    showDialog('sisa tidak boleh minus')
                    $("#tableHutang").jqGrid(
                      "setCell",
                      rowObject.rowId,
                      "potongan",
                      0
                    );
                    $("#tableHutang").jqGrid("setCell", rowObject.rowId, "total", 0 + bayar);
                    if (originalGridData.sisa == 0) {
                      $("#tableHutang").jqGrid("setCell", rowObject.rowId, "sisa", (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.bayar)));
                    } else {
                      $("#tableHutang").jqGrid("setCell", rowObject.rowId, "sisa", originalGridData.sisa - bayar);
                    }
                  }
                  setTotalPotongan()
                  setTotalSisa()
                  setAllTotal()
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
        editableColumns: ["bayar"],
        selectedRowIds: [],
        afterRestoreCell: function(rowId, value, indexRow, indexColumn) {
          let originalGridData = $("#tableHutang")
            .jqGrid("getGridParam", "originalData")
            .find((row) => row.id == rowId);

          let localRow = $("#tableHutang").jqGrid("getLocalRow", rowId);

          let getBayar = $("#tableHutang").jqGrid("getCell", rowId, "bayar")
          let bayar = (getBayar != '') ? parseFloat(getBayar.replaceAll(',', '')) : 0

          let getPotongan = $("#tableHutang").jqGrid("getCell", rowId, "potongan")
          let potongan = (getPotongan != '') ? parseFloat(getPotongan.replaceAll(',', '')) : 0

          sisa = 0
          if ($('#crudForm').data('action') == 'edit') {
            sisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.bayar)) - bayar - potongan
          } else {
            sisa = originalGridData.sisa - bayar - potongan
          }

          // console.log('sisa', originalGridData.sisa)
          // console.log('bayar', bayar)
          // console.log('potongan', potongan)
          // console.log(originalGridData.sisa - bayar - potongan)
          console.log('indexc', indexColumn)
          if (indexColumn == 8 || indexColumn == 9) {

            $("#tableHutang").jqGrid(
              "setCell",
              rowId,
              "sisa",
              sisa
              // sisa - bayar - potongan
            );
            $("#tableHutang").jqGrid(
              "setCell",
              rowId,
              "total",
              bayar + potongan
              // sisa - bayar - potongan
            );
          }
          setTotalSisa()
          setTotalBayar()
          setTotalPotongan()
          setAllTotal()
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
                initAutoNumeric($(this).find(`td[aria-describedby="tableHutang_bayar"]`))
                initAutoNumeric($(this).find(`td[aria-describedby="tableHutang_potongan"]`))
                initAutoNumeric($(this).find(`td[aria-describedby="tableHutang_nominallebihbayar"]`))
              });
          }, 100);
          setTotalNominal()
          setTotalSisa()
          setAllTotal()
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
          let localRow = $("#tableHutang").jqGrid("getLocalRow", rowId);

          $("#tableHutang").jqGrid(
            "setCell",
            rowId,
            "sisa",
            parseInt(localRow.sisa) + parseInt(localRow.bayar)
          );

          return true;
        },
      });
    /* Append clear filter button */
    loadClearFilter($('#tableHutang'))

    /* Append global search */
    // loadGlobalSearch($('#tableHutang'))
  }

  function getDataHutang(supplierId, id) {
    aksi = $('#crudForm').data('action')

    if (aksi == 'edit') {
      console.log(id)
      if (id != undefined) {
        url = `${apiUrl}hutangbayarheader/${id}/${supplierId}/getPembayaran`
      } else {
        url = `${apiUrl}hutangbayarheader/${supplierId}/getHutang`
      }
    } else if (aksi == 'delete') {
      url = `${apiUrl}hutangbayarheader/${id}/${supplierId}/getPembayaran`
      attribut = 'disabled'
      forCheckbox = 'disabled'
    } else if (aksi == 'add') {
      url = `${apiUrl}hutangbayarheader/${supplierId}/getHutang`
    }

    return new Promise((resolve, reject) => {
      $.ajax({
        url: url,
        dataType: "JSON",
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


  function checkboxHutangHandler(element, rowId) {

    let isChecked = $(element).is(":checked");
    let editableColumns = $("#tableHutang").getGridParam("editableColumns");
    let selectedRowIds = $("#tableHutang").getGridParam("selectedRowIds");
    let originalGridData = $("#tableHutang")
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
          sisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.bayar) + parseFloat(originalGridData.potongan))
        } else {
          sisa = originalGridData.sisa
        }

        $("#tableHutang").jqGrid(
          "setCell",
          rowId,
          "sisa",
          sisa
        );

        $("#tableHutang").jqGrid("setCell", rowId, "total", 0);
        $("#tableHutang").jqGrid("setCell", rowId, "bayar", 0);
        $(`#tableHutang tr#${rowId}`).find(`td[aria-describedby="tableHutang_bayar"]`).attr("value", 0)
        $("#tableHutang").jqGrid("setCell", rowId, "potongan", 0);
        $(`#tableHutang tr#${rowId}`).find(`td[aria-describedby="tableHutang_potongan"]`).attr("value", 0)
        $("#tableHutang").jqGrid("setCell", rowId, "keterangan", null);
        setTotalBayar()
        setTotalPotongan()

        setTotalSisa()
        setAllTotal()
      } else {
        selectedRowIds.push(rowId);

        let localRow = $("#tableHutang").jqGrid("getLocalRow", rowId);
        console.log(rowId)
        if ($('#crudForm').data('action') == 'edit') {
          // if (originalGridData.sisa == 0) {

          //   let getNominal = $("#tableHutang").jqGrid("getCell", rowId, "nominal")
          //   localRow.bayar = (getNominal != '') ? parseFloat(getNominal.replaceAll(',', '')) : 0
          // } else {
          //   localRow.bayar = originalGridData.sisa
          // }
          localRow.bayar = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.bayar) + parseFloat(originalGridData.potongan))
        } else {
          localRow.bayar = originalGridData.sisa
        }

        $("#tableHutang").jqGrid(
          "setCell",
          rowId,
          "sisa",
          0
        );
        $("#tableHutang").jqGrid(
          "setCell",
          rowId,
          "bayar",
          localRow.bayar
        );
        $("#tableHutang").jqGrid(
          "setCell",
          rowId,
          "total",
          localRow.bayar
        );

        initAutoNumeric($(`#tableHutang tr#${rowId}`).find(`td[aria-describedby="tableHutang_bayar"]`))
        initAutoNumeric($(`#tableHutang tr#${rowId}`).find(`td[aria-describedby="tableHutang_potongan"]`))
        setTotalBayar()
        setTotalPotongan()

        setTotalSisa()
        setAllTotal()
      }
    });

    $("#tableHutang").jqGrid("setGridParam", {
      selectedRowIds: selectedRowIds,
    });


    // initAutoNumeric($('.footrow').find(`td[aria-describedby="tableHutang_potongan"]`).text(totalPotongan))
    // initAutoNumeric($('.footrow').find(`td[aria-describedby="tableHutang_nominallebihbayar"]`).text(totalNominalLebih))

  }


  $(document).on('click', '#resetdatafilter_tableHutang', function(event) {
    selectedRowsPinjaman = $("#tableHutang").getGridParam("selectedRowIds");
    $.each(selectedRowsPinjaman, function(index, value) {
      $('#tableHutang').jqGrid('saveCell', value, 11); //emptycell
      $('#tableHutang').jqGrid('saveCell', value, 5); //nominal
      $('#tableHutang').jqGrid('saveCell', value, 6); //sisa
      $('#tableHutang').jqGrid('saveCell', value, 7); //keterangan
      $('#tableHutang').jqGrid('saveCell', value, 8); //bayar
      $('#tableHutang').jqGrid('saveCell', value, 9); //potongan
      $('#tableHutang').jqGrid('saveCell', value, 10); //total
    })
  })

  $(document).on('click', '#gbox_tableHutang .ui-jqgrid-hbox .ui-jqgrid-htable thead .ui-search-toolbar th td a.clearsearchclass', function(event) {
    selectedRowsPelunasan = $("#tableHutang").getGridParam("selectedRowIds");
    $.each(selectedRowsPelunasan, function(index, value) {
      $('#tableHutang').jqGrid('saveCell', value, 11); //emptycell
      $('#tableHutang').jqGrid('saveCell', value, 5); //nominal
      $('#tableHutang').jqGrid('saveCell', value, 6); //sisa
      $('#tableHutang').jqGrid('saveCell', value, 7); //keterangan
      $('#tableHutang').jqGrid('saveCell', value, 8); //bayar
      $('#tableHutang').jqGrid('saveCell', value, 9); //potongan
      $('#tableHutang').jqGrid('saveCell', value, 10); //total
    })
  })

  function setTotalNominal() {
    let nominalDetails = $(`#tableHutang`).find(`td[aria-describedby="tableHutang_nominal"]`)
    let nominal = 0
    let originalData = $("#tableHutang").getGridParam("data");
    $.each(originalData, function(index, value) {
      lunas_nominal = value.nominal;
      nominals = (isNaN(lunas_nominal)) ? parseFloat(lunas_nominal.replaceAll(',', '')) : parseFloat(lunas_nominal)
      nominal += nominals

    })
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tableHutang_nominal"]`).text(nominal))
  }

  function setTotalSisa() {
    let sisaDetails = $(`#tableHutang`).find(`td[aria-describedby="tableHutang_sisa"]`)
    let sisa = 0
    let originalData = $("#tableHutang").getGridParam("data");
    $.each(originalData, function(index, value) {
      lunas_sisa = value.sisa;
      sisas = (isNaN(lunas_sisa)) ? parseFloat(lunas_sisa.replaceAll(',', '')) : parseFloat(lunas_sisa)
      sisa += sisas

    })
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tableHutang_sisa"]`).text(sisa))
  }

  function setAllTotal() {
    let totalDetails = $(`#tableHutang`).find(`td[aria-describedby="tableHutang_total"]`)
    let total = 0
    let originalData = $("#tableHutang").getGridParam("data");
    $.each(originalData, function(index, value) {
      lunas_total = value.total;
      console.log(lunas_total)
      totals = (isNaN(lunas_total)) ? parseFloat(lunas_total.replaceAll(',', '')) : parseFloat(lunas_total)
      total += totals

    })

    initAutoNumeric($('.footrow').find(`td[aria-describedby="tableHutang_total"]`).text(total))
  }

  function setTotalBayar() {
    let bayarDetails = $(`#tableHutang`).find(`td[aria-describedby="tableHutang_bayar"]`)
    let bayar = 0
    selectedRows = $("#tableHutang").getGridParam("selectedRowIds");
    $.each(selectedRows, function(index, value) {
      dataHutang = $("#tableHutang").jqGrid("getLocalRow", value);
      lunas_nominal = (dataHutang.bayar == undefined || dataHutang.bayar == '') ? 0 : dataHutang.bayar;
      bayars = (isNaN(lunas_nominal)) ? parseFloat(lunas_nominal.replaceAll(',', '')) : parseFloat(lunas_nominal)
      bayar = bayar + bayars
    })
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tableHutang_bayar"]`).text(bayar))
  }

  function setTotalPotongan() {
    let potonganDetails = $(`#tableHutang`).find(`td[aria-describedby="tableHutang_potongan"]`)
    let potongan = 0
    selectedRows = $("#tableHutang").getGridParam("selectedRowIds");
    $.each(selectedRows, function(index, value) {
      dataHutang = $("#tableHutang").jqGrid("getLocalRow", value);
      lunas_potongan = (dataHutang.potongan == undefined || dataHutang.potongan == '') ? 0 : dataHutang.potongan;
      potongans = (isNaN(lunas_potongan)) ? parseFloat(lunas_potongan.replaceAll(',', '')) : parseFloat(lunas_potongan)
      potongan = potongan + potongans
    })
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tableHutang_potongan"]`).text(potongan))
  }

  function getHutang(id, field) {

    $('#detailList tbody').html('')
    $('#detailList tfoot #nominalHutang').html('')
    $('#detailList tfoot #sisaHutang').html('')

    $.ajax({
      url: `${apiUrl}hutangbayarheader/${id}/${field}/getHutang`,
      method: 'GET',
      dataType: 'JSON',
      data: {
        limit: 0
      },
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {

        let totalNominal = 0
        let totalSisa = 0
        $.each(response.data, (index, detail) => {

          let id = detail.id
          let nobukti = detail.nobukti
          totalNominal = parseFloat(totalNominal) + parseFloat(detail.total)
          totalSisa = totalSisa + parseFloat(detail.sisa);
          let nominal = new Intl.NumberFormat('en-US').format(detail.total);
          let sisa = new Intl.NumberFormat('en-US').format(detail.sisa);

          let detailRow = $(`
            <tr >
              <td>
                <input name='hutang_id[]' type="checkbox" id="checkItem" value="${id}">
                <input name='hutang_nobukti[]' type="hidden" value="${nobukti}">              
              </td>
              <td></td>
              <td>${detail.nobukti}</td>
              <td>${detail.tglbukti}</td>
              <td>
                <p class="text-right nominal">${nominal}</p>
                <input type="hidden" name="nominal[]" class="autonumeric" value="${nominal}">
              </td>
              <td>
                <p class="text-right sisa autonumeric">${sisa}</p>
                <input type="hidden" name="sisa[]" class="autonumeric" value="${sisa}">
                <input type="hidden" name="sisaAwal[]" class="autonumeric" value="${sisa}">
              </td>
              <td>
                <textarea name="keterangandetail[]" rows="1" disabled class="form-control"></textarea>
              </td>
              <td id='${id}'>
                <input type="text" name="bayar[]" disabled class="form-control bayar text-right">
              </td>
              <td>
                <input type="text" name="potongan[]" disabled class="form-control autonumeric">
              </td>
              <td>
                <input type="text" name="total[]" disabled class="form-control autonumeric">
              </td>
            </tr>
          `)


          detailRow.find(`[name="tglcair[]"]`).val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
          // detailRow.find(`[name="keterangan_detail[]"]`).val(detail.keterangan)
          // detailRow.find(`[name="nominal[]"]`).val(detail.nominal)

          // initAutoNumericNoMinus(detailRow.find(`[name="bayar[]"]`))
          initAutoNumericNoMinus(detailRow.find(`[name="potongan[]"]`))
          initAutoNumericNoMinus(detailRow.find(`[name="total[]"]`))
          initAutoNumeric(detailRow.find(`[name="nominal[]"]`))
          initAutoNumeric(detailRow.find(`[name="sisa[]"]`))
          initAutoNumeric(detailRow.find(`[name="sisaAwal[]"]`))
          initAutoNumeric(detailRow.find('.sisa'))
          initAutoNumeric(detailRow.find('.nominal'))

          $('#detailList tbody').append(detailRow)
          setTotal()
          initDatepicker()

        })
        totalNominal = new Intl.NumberFormat('en-US').format(totalNominal);
        totalSisa = new Intl.NumberFormat('en-US').format(totalSisa);
        $('#nominalHutang').append(`${totalNominal}`)
        $('#sisaHutang').append(`${totalSisa}`)

        initAutoNumeric($('#detailList tfoot').find('#nominalHutang'))
        initAutoNumeric($('#detailList tfoot').find('#sisaHutang'))
        setRowNumbers()

      }
    })


  }


  function cekValidasi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}hutangbayarheader/${Id}/cekvalidasi`,
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
      url: `{{ config('app.api_url') }}hutangbayarheader/${Id}/cekValidasiAksi`,
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
            editHutangBayarHeader(Id)
          }
          if (Aksi == 'DELETE') {
            deleteHutangBayarHeader(Id)
          }
        }

      }
    })
  }

  function getPembayaran(id, supplierId, aksi) {
    $('#detailList tbody').html('')
    let url
    let attribut
    let forCheckbox
    let forTotal = 'disabled'
    // if(aksi == 'edit'){
    url = `${apiUrl}hutangbayarheader/${id}/${supplierId}/getPembayaran`
    // }
    console.log(aksi)
    if (aksi == 'delete') {
      attribut = 'disabled'
      forCheckbox = 'disabled'
    }
    $.ajax({
      url: url,
      method: 'GET',
      dataType: 'JSON',
      data: {
        limit: 0
      },
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {

        let totalNominalHutang = 0
        let totalSisa = 0
        let totalNominal = 0
        let total = 0
        $.each(response.data, (index, detail) => {

          let id = detail.id
          let hutangbayarId = detail.hutangbayar_id
          let checked

          totalNominalHutang = parseFloat(totalNominalHutang) + parseFloat(detail.nominalhutang)
          totalSisa = totalSisa + parseFloat(detail.sisa);
          total = parseFloat(detail.bayar) + parseFloat(detail.potongan)
          let nominal = new Intl.NumberFormat('en-US').format(detail.nominalhutang);
          let sisaHidden = parseFloat(detail.sisa) + parseFloat(detail.bayar)
          let sisa = new Intl.NumberFormat('en-US').format(detail.sisa);

          if (hutangbayarId != null) {
            checked = 'checked'
            attribut = 'enable'
          } else {
            attribut = 'disabled'
          }

          let detailRow = $(`
            <tr>
              <td>
                <input name='hutang_id[]' type="checkbox" class="checkItem" value="${id}" ${checked} ${forCheckbox}>
                <input name='hutang_nobukti[]' type="hidden" value="${detail.hutang_nobukti}">
              
              </td>
              <td></td>
              <td>${detail.hutang_nobukti}</td>
              <td>${detail.tglbukti}</td>
              
              <td>
                <p class="text-right nominal">${nominal}</p>
                <input type="hidden" name="nominal[]" class="autonumeric" value="${nominal}">
              </td>
              <td>
                <p class="sisa text-right autonumeric">${sisa}</p>
                <input type="hidden" name="sisa[]" class="autonumeric" value="${sisa}">
                <input type="hidden" name="sisaAwal[]" class="autonumeric" value="${sisa}">
              </td>
              <td>
                <textarea name="keterangandetail[]" rows="1" class="form-control" ${attribut}>${detail.keterangan || ''}</textarea>
              </td>
              <td id='${detail.id}'>
                <input type="text" name="bayar[]" class="form-control autonumeric text-right" value="${detail.bayar || ''}" ${attribut}>
              </td>
              <td>
                <input type="text" name="potongan[]" class="form-control autonumeric" value="${detail.potongan || ''}" ${attribut}>
              </td>
              <td>
                <input type="text" name="total[]" class="form-control autonumeric" value="${total || ''}" disabled>
              </td>
            </tr>
          `)

          initAutoNumeric(detailRow.find(`[name="bayar[]"]`).not(':disabled'))
          initAutoNumericNoMinus(detailRow.find(`[name="potongan[]"]`))
          initAutoNumericNoMinus(detailRow.find(`[name="total[]"]`))
          initAutoNumeric(detailRow.find(`[name="nominal[]"]`))
          initAutoNumeric(detailRow.find(`[name="sisa[]"]`))
          initAutoNumeric(detailRow.find(`[name="sisaAwal[]"]`))
          initAutoNumeric(detailRow.find('.sisa'))
          initAutoNumeric(detailRow.find('.nominal'))

          $('#detailList tbody').append(detailRow)
          setPotongan()
          setTotal()
          initDatepicker()
          setBayar()
        })


        $('#nominalHutang').append(`${totalNominalHutang}`)
        $('#sisaHutang').append(`${totalSisa}`)
        initAutoNumeric($('#detailList tfoot').find('#nominalHutang'))
        initAutoNumeric($('#detailList tfoot').find('#sisaHutang'))
        setRowNumbers()


      }
    })

  }

  $(document).on('click', `#detailList tbody [name="hutang_id[]"]`, function() {

    if ($(this).prop("checked") == true) {
      $(this).closest('tr').find(`td [name="keterangandetail[]"]`).prop('disabled', false)
      $(this).closest('tr').find(`td [name="bayar[]"]`).prop('disabled', false)
      $(this).closest('tr').find(`td [name="potongan[]"]`).prop('disabled', false)

      let sisa = AutoNumeric.getNumber($(this).closest('tr').find(`td [name="sisa[]"]`)[0])

      initAutoNumeric($(this).closest('tr').find(`td [name="bayar[]"]`).val(sisa))
      initAutoNumeric($(this).closest('tr').find(`td [name="total[]"]`).val(sisa))

      let bayar = AutoNumeric.getNumber($(this).closest('tr').find(`td [name="bayar[]"]`)[0])
      let totalSisa = sisa - bayar

      $(this).closest("tr").find(".sisa").html(totalSisa)
      $(this).closest("tr").find(`[name="sisa[]"]`).val(totalSisa)
      initAutoNumeric($(this).closest("tr").find(".sisa"))

      setBayar()
      setPotongan()
      setTotal()
      setSisa()
    } else {

      let id = $(this).val()
      let action = $('#crudForm').data('action')
      $(this).closest('tr').find(`td [name="keterangandetail[]"]`).prop('disabled', true)
      $(this).closest('tr').find(`td [name="bayar[]"]`).val('').prop('disabled', true)
      $(this).closest('tr').find(`td [name="potongan[]"]`).val('').prop('disabled', true)
      $(this).closest('tr').find(`td [name="total[]"]`).val('').prop('disabled', true)

      if (action == 'add') {
        nominal = AutoNumeric.getNumber($(this).closest('tr').find(`td [name="sisaAwal[]"]`)[0])
      } else {

        nominal = AutoNumeric.getNumber($(this).closest('tr').find(`td [name="nominal[]"]`)[0])
      }
      console.log(nominal)
      initAutoNumeric($(this).closest('tr').find(`td [name="sisa[]"]`).val(nominal))
      $(this).closest("tr").find(".sisa").html(nominal)
      initAutoNumeric($(this).closest("tr").find(".sisa"))

      $(this).closest('tr').find(`td [name="bayar[]"]`).remove();
      let newBayarElement = `<input type="text" name="bayar[]" class="form-control text-right" disabled>`

      $(this).closest('tr').find(`#${id}`).append(newBayarElement)
      setBayar()
      setPotongan()
      setTotal()
      setSisa()
    }
  })



  function setRowNumbers() {
    let elements = $('#detailList tbody tr td:nth-child(2)')

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
      url: `${apiUrl}hutangbayarheader/approval`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        bayarId: selectedRows
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


  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}hutangbayarheader/field_length`,
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

  function setSisaHutang(element) {

    let action = $('#crudForm').data('action')
    let sisa = AutoNumeric.getNumber(element.closest("tr").find(`[name="sisa[]"]`)[0])
    let sisaAwal = AutoNumeric.getNumber(element.closest("tr").find(`[name="sisaAwal[]"]`)[0])
    let potongan = AutoNumeric.getNumber(element.closest("tr").find(`[name="potongan[]"]`)[0])

    let bayar = element.val()
    bayar = parseFloat(bayar.replaceAll(',', ''));
    bayar = Number.isNaN(bayar) ? 0 : bayar
    let nominal = element.closest("tr").find(`[name="nominal[]"]`).val()
    nominal = parseFloat(nominal.replaceAll(',', ''));

    if (sisa == 0) {
      if (action == 'add') {
        totalSisa = sisaAwal - bayar - potongan
      } else {
        totalSisa = nominal - bayar - potongan
      }
      element.closest("tr").find(".sisa").html(totalSisa)
    } else {
      if (action == 'add') {
        totalSisa = sisaAwal - bayar - potongan
      } else {
        totalSisa = nominal - bayar - potongan
      }
      element.closest("tr").find(".sisa").html(totalSisa)
    }


    initAutoNumeric(element.closest("tr").find(".sisa"))

    let Sisa = $(`#table_body .sisa`)
    let total = 0

    $.each(Sisa, (index, SISA) => {
      total += AutoNumeric.getNumber(SISA)
    });

    new AutoNumeric('#sisaHutang').set(total)

    // get potongan for total
    let totalHutang = bayar - potongan
    element.closest("tr").find(`[name="total[]"]`).val(totalHutang)

    initAutoNumeric(element.closest("tr").find(`[name="total[]"]`))

    let Total = $(`#table_body [name="total[]"]`)
    let gt = 0

    $.each(Total, (index, ttl) => {
      gt += AutoNumeric.getNumber(ttl)
    });

    new AutoNumeric('#totalHutang').set(gt)
  }

  function initAutoNumericNoMinus(elements = null) {
    let option = {
      digitGroupSeparator: formats.THOUSANDSEPARATOR,
      decimalCharacter: formats.DECIMALSEPARATOR,
      minimumValue: 0

    };

    if (elements == null) {
      new AutoNumeric.multiple(".autonumeric", option);
    } else {
      $.each(elements, (index, element) => {
        new AutoNumeric(element, option);
      });
    }
  }

  function initLookup() {
    $('.coa-lookup').lookup({
      title: 'COA Lookup',
      fileName: 'akunpusat',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          levelCoa: '3',
        }
      },
      onSelectRow: (coa, element) => {
        element.val(coa.coa)
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

    $('.bank-lookup').lookup({
      title: 'Bank Lookup',
      fileName: 'bank',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          // bankId: bankId
          alatbayar: bankId
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

    $('.supplier-lookup').lookup({
      title: 'Supplier Lookup',
      fileName: 'supplier',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (supplier, element) => {
        $('#crudForm [name=supplier_id]').first().val(supplier.id)
        element.val(supplier.namasupplier)
        element.data('currentValue', element.val())

        $('#tableHutang').jqGrid("clearGridData");
        $("#tableHutang")
          .jqGrid("setGridParam", {
            selectedRowIds: []
          })
          .trigger("reloadGrid");
        getDataHutang(supplier.id).then((response) => {

          console.log('before', $("#tableHutang").jqGrid('getGridParam', 'selectedRowIds'))
          setTimeout(() => {

            $("#tableHutang")
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
        $('#crudForm [name=supplier_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
        $('#detailList tbody').html('')
        $('#nominalHutang').html('')
        $('#sisaHutang').html('')
        $('#bayarHutang').html('')
        $('#potonganHutang').html('')
        $('#totalHutang').html('')
      }
    })

    $('.alatbayar-lookup').lookup({
      title: 'Alat Bayar Lookup',
      fileName: 'alatbayar',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (alatbayar, element) => {
        $('#crudForm [name=alatbayar_id]').first().val(alatbayar.id)
        element.val(alatbayar.namaalatbayar)
        bankId = alatbayar.bank_id
        element.data('currentValue', element.val())
        $('#crudForm [name=bank_id]').val('')
        $('#crudForm [name=bank]').val('')
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=alatbayar_id]').first().val('')
        $('#crudForm [name=bank_id]').first().val('')
        $('#crudForm [name=bank]').first().val('')
        $('#crudForm [name=bank]').first().data('currentValue', element.val())
        element.val('')
        element.data('currentValue', element.val())
      }
    })
  }
</script>
@endpush()