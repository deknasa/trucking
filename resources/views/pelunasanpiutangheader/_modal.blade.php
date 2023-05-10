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
                  BANK/KAS <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-8 col-md-10">
                <input type="hidden" name="bank_id">
                <input type="text" name="bank" class="form-control bank-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  ALAT BAYAR <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-8 col-md-10">
                <input type="hidden" name="alatbayar_id">
                <input type="text" name="alatbayar" class="form-control alatbayar-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  NO BUKTI PENERIMAAN
                </label>
              </div>
              <div class="col-8 col-md-10">
                <input type="text" name="penerimaan_nobukti" class="form-control" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  NO BUKTI PENERIMAAN GIRO
                </label>
              </div>
              <div class="col-8 col-md-10">
                <input type="text" name="penerimaangiro_nobukti" class="form-control" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  NO BUKTI NOTA KREDIT
                </label>
              </div>
              <div class="col-8 col-md-10">
                <input type="text" name="notakredit_nobukti" class="form-control" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  NO BUKTI NOTA DEBET
                </label>
              </div>
              <div class="col-8 col-md-10">
                <input type="text" name="notadebet_nobukti" class="form-control" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  NO WARKAT
                </label>
              </div>
              <div class="col-8 col-md-10">
                <input type="text" name="nowarkat" class="form-control">
              </div>
            </div>
            <div class="row form-group mb-5">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  AGEN <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-8 col-md-10">
                <input type="hidden" name="agen_id" class="form-control">
                <input type="text" name="agen" class="form-control agen-lookup">
              </div>
            </div>

            <table id="tablePelunasan"></table>
            <!-- <div class="table-responsive table-scroll">
              <table class="table table-bordered mt-3" id="detailList" style="width:2000px;">
                <thead class="table-secondary">
                  <tr>
                    <th width="1%">pilih</th>
                    <th width="1%">NO</th>
                    <th width="5%">NO BUKTI</th>
                    <th width="4%">TGL BUKTI</th>
                    <th width="5%">NO BUKTI INVOICE</th>
                    <th width="5%">NOMINAL PIUTANG</th>
                    <th width="5%">SISA</th>
                    <th width="11%">KETERANGAN</th>
                    <th width="6%">BAYAR</th>
                    <th width="6%">POTONGAN</th>
                    <th width="6%">COA POTONGAN</th>
                    <th width="5%">KETERANGAN POTONGAN</th>
                    <th width="6%">NOMINAL LEBIH BAYAR</th>
                  </tr>
                </thead>
                <tbody id="table_body">

                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="5"></td>
                    <td>
                      <p id="nominalPiutang" class="text-right font-weight-bold"></p>
                    </td>
                    <td>
                      <p id="sisaPiutang" class="text-right font-weight-bold"></p>
                    </td>
                    <td></td>
                    <td>
                      <p id="bayarPiutang" class="text-right font-weight-bold"></p>
                    </td>
                    <td>
                      <p id="bayarPotongan" class="text-right font-weight-bold"></p>
                    </td>
                    <td colspan="2"></td>
                    <td>
                      <p id="bayarNominalLebih" class="text-right font-weight-bold"></p>
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
  let selectAll = false
  $(document).ready(function() {

    $("#crudForm [name]").attr("autocomplete", "off");

    $(document).on('input', `#table_body [name="bayarppd[]"]`, function(event) {
      let action = $('#crudForm').data('action')
      console.log(action)
      setTotal()
      let sisa = AutoNumeric.getNumber($(this).closest("tr").find(`[name="sisa[]"]`)[0])
      let sisaAwal = AutoNumeric.getNumber($(this).closest("tr").find(`[name="sisaAwal[]"]`)[0])
      let potonganppd = AutoNumeric.getNumber($(this).closest("tr").find(`[name="potonganppd[]"]`)[0])
      let bayar = $(this).val()
      bayar = parseFloat(bayar.replaceAll(',', ''));
      bayar = Number.isNaN(bayar) ? 0 : bayar
      let nominal = $(this).closest("tr").find(`[name="nominal[]"]`).val()
      if (sisa == 0) {
        nominal = parseFloat(nominal.replaceAll(',', ''));
        if (action == 'add') {
          totalSisa = sisaAwal - bayar - potonganppd
        } else {
          totalSisa = nominal - bayar - potonganppd
        }

        $(this).closest("tr").find(".sisa").html(totalSisa)
        $(this).closest("tr").find(`[name="sisa[]"]`).val(totalSisa)
      } else {

        nominal = parseFloat(nominal.replaceAll(',', ''));
        if (action == 'add') {
          totalSisa = sisaAwal - bayar - potonganppd
        } else {
          totalSisa = nominal - bayar - potonganppd
        }

        $(this).closest("tr").find(".sisa").html(totalSisa)
        $(this).closest("tr").find(`[name="sisa[]"]`).val(totalSisa)
      }


      initAutoNumeric($(this).closest("tr").find(".sisa"))

      let Sisa = $(`#table_body .sisa`)
      let total = 0

      $.each(Sisa, (index, SISA) => {
        total += AutoNumeric.getNumber(SISA)
      });

      new AutoNumeric('#sisaPiutang').set(total)
    })

    $(document).on('input', `#table_body [name="potonganppd[]"]`, function(event) {
      let action = $('#crudForm').data('action')
      setPenyesuaian()
      let sisa = AutoNumeric.getNumber($(this).closest("tr").find(`[name="sisa[]"]`)[0])
      let sisaAwal = AutoNumeric.getNumber($(this).closest("tr").find(`[name="sisaAwal[]"]`)[0])
      let bayar = AutoNumeric.getNumber($(this).closest("tr").find(`[name="bayarppd[]"]`)[0])
      let potonganppd = $(this).val()
      potonganppd = parseFloat(potonganppd.replaceAll(',', ''));
      potonganppd = Number.isNaN(potonganppd) ? 0 : potonganppd
      let nominal = $(this).closest("tr").find(`[name="nominal[]"]`).val()
      nominal = parseFloat(nominal.replaceAll(',', ''));
      if (sisa == 0) {
        if (action == 'add') {
          totalSisa = sisaAwal - bayar - potonganppd
        } else {
          totalSisa = nominal - bayar - potonganppd
        }

      } else {
        if (action == 'add') {
          totalSisa = sisaAwal - bayar - potonganppd
        } else {
          totalSisa = nominal - bayar - potonganppd
        }
      }
      $(this).closest("tr").find(".sisa").html(totalSisa)
      $(this).closest("tr").find(`[name="sisa[]"]`).val(totalSisa)

      initAutoNumeric($(this).closest("tr").find(".sisa"))

      let Sisa = $(`#table_body .sisa`)
      let total = 0

      $.each(Sisa, (index, SISA) => {
        total += AutoNumeric.getNumber(SISA)
      });

      new AutoNumeric('#sisaPiutang').set(total)
    })
    $(document).on('input', `#table_body [name="nominallebihbayarppd[]"]`, function(event) {
      setNominalLebih()
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
        name: 'bank',
        value: form.find(`[name="bank"]`).val()
      })
      data.push({
        name: 'bank_id',
        value: form.find(`[name="bank_id"]`).val()
      })
      data.push({
        name: 'alatbayar',
        value: form.find(`[name="alatbayar"]`).val()
      })
      data.push({
        name: 'alatbayar_id',
        value: form.find(`[name="alatbayar_id"]`).val()
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
        name: 'nowarkat',
        value: form.find(`[name="nowarkat"]`).val()
      })
      data.push({
        name: 'penerimaan_nobukti',
        value: form.find(`[name="penerimaan_nobukti"]`).val()
      })
      data.push({
        name: 'penerimaangiro_nobukti',
        value: form.find(`[name="penerimaangiro_nobukti"]`).val()
      })
      data.push({
        name: 'notakredit_nobukti',
        value: form.find(`[name="notakredit_nobukti"]`).val()
      })
      data.push({
        name: 'notadebet_nobukti',
        value: form.find(`[name="notadebet_nobukti"]`).val()
      })

      let selectedRows = $("#tablePelunasan").getGridParam("selectedRowIds");

      $.each(selectedRows, function(index, value) {
        let selectedBayar = $("#tablePelunasan").jqGrid("getCell", value, "bayar")
        let selectedPotongan = $("#tablePelunasan").jqGrid("getCell", value, "potongan")
        let selectedLebihBayar = $("#tablePelunasan").jqGrid("getCell", value, "nominallebihbayar")
        data.push({
          name: 'bayar[]',
          value: (selectedBayar != '') ? parseFloat(selectedBayar.replaceAll(',', '')) : 0
        })
        data.push({
          name: 'potongan[]',
          value: (selectedPotongan != '') ? parseFloat(selectedPotongan.replaceAll(',', '')) : 0
        })
        data.push({
          name: 'nominallebihbayar[]',
          value: (selectedLebihBayar != '') ? parseFloat(selectedLebihBayar.replaceAll(',', '')) : 0
        })
        data.push({
          name: 'keterangan[]',
          value: $("#tablePelunasan").jqGrid("getCell", value, "keterangan")
        })
        data.push({
          name: 'keteranganpotongan[]',
          value: $("#tablePelunasan").jqGrid("getCell", value, "keteranganpotongan")
        })
        data.push({
          name: 'coapotongan[]',
          value: $("#tablePelunasan").jqGrid("getCell", value, "coapotongan")
        })
        data.push({
          name: 'piutang_nobukti[]',
          value: $("#tablePelunasan").jqGrid("getCell", value, "nobukti")
        })
        data.push({
          name: 'piutang_id[]',
          value: $("#tablePelunasan").jqGrid("getCell", value, "id")
        })
      });
      // $('#table_body tr').each(function(row, tr) {


      //   if ($(this).find(`[name="piutang_id[]"]`).is(':checked')) {

      //     data.push({
      //       name: 'sisa[]',
      //       value: AutoNumeric.getNumber($(`#crudForm [name="sisa[]"]`)[row])
      //     })
      //     data.push({
      //       name: 'keterangandetailppd[]',
      //       value: $(this).find(`[name="keterangandetailppd[]"]`).val()
      //     })
      //     data.push({
      //       name: 'bayarppd[]',
      //       value: AutoNumeric.getNumber($(`#crudForm [name="bayarppd[]"]`)[row])
      //     })
      //     data.push({
      //       name: 'keteranganpotonganppd[]',
      //       value: $(this).find(`[name="keteranganpotonganppd[]"]`).val()
      //     })
      //     data.push({
      //       name: 'potonganppd[]',
      //       value: AutoNumeric.getNumber($(`#crudForm [name="potonganppd[]"]`)[row])
      //     })
      //     data.push({
      //       name: 'coapotonganppd[]',
      //       value: $(this).find(`[name="coapotonganppd[]"]`).val()
      //     })
      //     data.push({
      //       name: 'nominallebihbayarppd[]',
      //       value: AutoNumeric.getNumber($(`#crudForm [name="nominallebihbayarppd[]"]`)[row])
      //     })
      //     data.push({
      //       name: 'piutang_nobukti[]',
      //       value: $(this).find(`[name="piutang_nobukti[]"]`).val()
      //     })
      //     data.push({
      //       name: 'piutang_id[]',
      //       value: $(this).find(`[name="piutang_id[]"]`).val()
      //     })

      //   }
      // })

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
          url = `${apiUrl}pelunasanpiutangheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}pelunasanpiutangheader/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}pelunasanpiutangheader/${Id}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}pelunasanpiutangheader`
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
          $('#piutangrow').html('')
          $('#jqGrid').jqGrid('setGridParam', {
            page: response.data.page
          }).trigger('reloadGrid');

          if (id == 0) {
            $('#detail').jqGrid().trigger('reloadGrid')
          }

          $('#detailList tbody').html('')
          $('#nominalPiutang').html('')
          $('#sisaPiutang').html('')

          if (response.data.grp == 'FORMAT') {
            updateFormat(response.data)
          }
        },
        error: error => {
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
            // piutangid = []
            // $('#table_body tr').each(function(row, tr) {
            //   if ($(this).find(`[name="piutang_id[]"]`).is(':checked')) {
            //     piutangid.push($(this).find(`[name="piutang_id[]"]`).val())
            //   }
            // })
            errors = error.responseJSON.errors

            $(".ui-state-error").removeClass("ui-state-error");
            $.each(errors, (index, error) => {
              let indexes = index.split(".");
              let angka = indexes[1]
              row = parseInt(selectedRows[angka]) - 1;
              let element;

              if (indexes[0] == 'alatbayar' || indexes[0] == 'tglbukti' || indexes[0] == 'bank' || indexes[0] == 'nowarkat' || indexes[0] == 'agen') {
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
                element = $(`#tablePelunasan tr#${parseInt(selectedRows[angka])}`).find(`td[aria-describedby="tablePelunasan_${indexes[0]}"]`)
                $(element).addClass("ui-state-error");
                $(element).attr("title", error[0].toLowerCase())
              }
            });
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
    let nominalDetails = $(`#table_body [name="bayarppd[]"]:not([disabled])`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#bayarPiutang').set(total)
  }

  function setPenyesuaian() {
    let potongan = $(`#table_body [name="potonganppd[]"]:not([disabled])`)
    let totalPenyesuaian = 0

    $.each(potongan, (index, potongan) => {
      totalPenyesuaian += AutoNumeric.getNumber(potongan)
    });

    new AutoNumeric('#bayarPotongan').set(totalPenyesuaian)
  }

  function setNominalLebih() {
    let nominalLebih = $(`#table_body [name="nominallebihbayarppd[]"]:not([disabled])`)
    let totalNominalLebih = 0

    $.each(nominalLebih, (index, nominalLebih) => {
      totalNominalLebih += AutoNumeric.getNumber(nominalLebih)
    });

    new AutoNumeric('#bayarNominalLebih').set(totalNominalLebih)
  }

  function setSisa() {
    let nominalDetails = $(`.sisa`)
    let bayar = 0
    $.each(nominalDetails, (index, nominalDetail) => {
      bayar += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#sisaPiutang').set(bayar)
  }

  function createPelunasanPiutangHeader() {
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.data('action', 'add')
    $('#crudModalTitle').text('Add Pelunasan Piutang')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    showDefault(form)
    loadPelunasanGrid();


    // setTotal()
    // setPenyesuaian()
    // setNominalLebih()
  }

  function loadPelunasanGrid() {
    $("#tablePelunasan")
      .jqGrid({
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        colModel: [{
            label: "",
            name: "",
            width: 30,
            formatter: 'checkbox',
            search: false,
            editable: false,
            // align: 'center',
            // sortable: false,
            // clear: false,
            // stype: 'input',
            // searchable: false,
            // editable: false,
            // searchoptions: {
            //   type: 'checkbox',
            //   clearSearch: false,
            //   dataInit: function(element) {
            //     let disabled = '';
            //     if ($('#crudForm').data('action') == 'delete') {
            //       disabled = 'disabled'
            //     }

            //     $(element).removeClass('form-control')
            //     $(element).parent().addClass('text-center')
            //     if (disabled == '') {
            //       $(element).on('click', function() {
            //         if ($(this).is(':checked')) {
            //           selectAllRows()
            //         } else {
            //           clearSelectedRows()
            //         }
            //       })
            //     }
            //   }
            // },
            formatter: function(value, rowOptions, rowData) {
              let disabled = '';
              if ($('#crudForm').data('action') == 'delete') {
                disabled = 'disabled'
              }
              return `<input type="checkbox" value="${rowData.id}" ${disabled} onChange="checkboxHandler(this, ${rowData.id})">`;
            },
          },
          {
            label: "id",
            name: "id",
            hidden: true,
            search: false,
          },
          {
            label: "Nobukti Piutang",
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
            label: "Nobukti INVOICE",
            name: "invoice_nobukti",
            sortable: true,
          },
          {
            label: "NOMINAL PIUTANG",
            name: "nominal",
            sortable: true,
            align: "right",
            formatter: currencyFormat,
          },
          {
            label: "SISA PIUTANG",
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
                  let originalGridData = $("#tablePelunasan")
                    .jqGrid("getGridParam", "originalData")
                    .find((row) => row.id == rowObject.rowId);

                  let localRow = $("#tablePelunasan").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );
                  let totalSisa
                  localRow.bayar = event.target.value;
                  let bayar = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])
                  let getPotongan = $("#tablePelunasan").jqGrid(
                    "getCell",
                    rowObject.rowId,
                    "potongan")
                  let potongan = (getPotongan != '') ? parseFloat(getPotongan.replaceAll(',', '')) : 0
                  if ($('#crudForm').data('action') == 'edit') {
                    totalSisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.bayar)) - bayar - potongan
                  } else {
                    totalSisa = originalGridData.sisa - bayar - potongan
                  }

                  console.log(totalSisa)
                  $("#tablePelunasan").jqGrid(
                    "setCell",
                    rowObject.rowId,
                    "sisa",
                    totalSisa
                  );

                  bayarDetails = $(`#tablePelunasan tr:not(#${rowObject.rowId})`).find(`td[aria-describedby="tablePelunasan_bayar"]`)
                  ttlBayar = 0
                  $.each(bayarDetails, (index, bayarDetail) => {
                    ttlBayarDetail = parseFloat($(bayarDetail).attr('title').replaceAll(',', ''))
                    ttlBayars = (isNaN(ttlBayarDetail)) ? 0 : ttlBayarDetail;
                    ttlBayar += ttlBayars
                  });
                  ttlBayar += bayar
                  initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePelunasan_bayar"]`).text(ttlBayar))
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
                  let originalGridData = $("#tablePelunasan")
                    .jqGrid("getGridParam", "originalData")
                    .find((row) => row.id == rowObject.rowId);

                  let localRow = $("#tablePelunasan").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );
                  let totalSisa
                  localRow.potongan = event.target.value;
                  let potongan = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])
                  let getBayar = $("#tablePelunasan").jqGrid(
                    "getCell",
                    rowObject.rowId,
                    "bayar")
                  let bayar = (getBayar != '') ? parseFloat(getBayar.replaceAll(',', '')) : 0

                  if ($('#crudForm').data('action') == 'edit') {
                    totalSisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.bayar)) - bayar - potongan
                  } else {
                    totalSisa = originalGridData.sisa - bayar - potongan
                  }
                  $("#tablePelunasan").jqGrid(
                    "setCell",
                    rowObject.rowId,
                    "sisa",
                    totalSisa
                  );

                  let potonganDetails = $(`#tablePelunasan tr:not(#${rowObject.rowId})`).find(`td[aria-describedby="tablePelunasan_potongan"]`)
                  let ttlPotongan = 0
                  $.each(potonganDetails, (index, potonganDetail) => {
                    ttlPotDetail = parseFloat($(potonganDetail).attr('title').replaceAll(',', ''))
                    ttlPotongans = (isNaN(ttlPotDetail)) ? 0 : ttlPotDetail;
                    ttlPotongan += ttlPotongans
                  });
                  ttlPotongan += potongan
                  initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePelunasan_potongan"]`).text(ttlPotongan))
                  setTotalSisa()
                },
              }, ],
            },

            sortable: false,
            sorttype: "int",
          },

          {
            label: "COA POTONGAN",
            name: "coapotongan",
            width: 250,
            editable: true,
            editoptions: {
              class: 'coapotongan-lookup',
              dataInit: function(element) {
                console.log(element)
                $('.coapotongan-lookup').last().lookup({
                  title: 'Coa Potongan Lookup',
                  fileName: 'akunpusat',
                  beforeProcess: function(test) {
                    // var levelcoa = $(`#levelcoa`).val();
                    this.postData = {
                      potongan: '1',
                      levelCoa: '2',
                      Aktif: 'AKTIF',
                    }
                  },
                  onSelectRow: (akunpusat, el) => {
                    el.val(akunpusat.coa)
                    el.data('currentValue', el.val())
                    console.log()
                  },
                  onCancel: (el) => {
                    el.val(el.data('currentValue'))
                  },
                  onClear: (el) => {
                    el.val('')
                    el.data('currentValue', el.val())
                  }
                })
              }
            },
            sortable: false,
          },
          {
            label: "KETERANGAN POTONGAN",
            name: "keteranganpotongan",
            editable: true,
            sortable: false,
          },
          {
            label: "NOMINAL LEBIH BAYAR",
            name: "nominallebihbayar",
            align: "right",
            editable: true,
            editoptions: {
              dataInit: function(element, id) {
                initAutoNumeric($('#crudForm').find(`[id="${id.id}"]`))
              },
              dataEvents: [{
                type: "keyup",
                fn: function(event, rowObject) {
                  let originalGridData = $("#tablePelunasan")
                    .jqGrid("getGridParam", "originalData")
                    .find((row) => row.id == rowObject.rowId);

                  let lebihBayar = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])

                  let lebihBayarDetails = $(`#tablePelunasan tr:not(#${rowObject.rowId})`).find(`td[aria-describedby="tablePelunasan_nominallebihbayar"]`)
                  let ttlLebihBayar = 0
                  $.each(lebihBayarDetails, (index, lebihBayarDetail) => {
                    ttlLBayar = parseFloat($(lebihBayarDetail).attr('title').replaceAll(',', ''))
                    ttlLBayars = (isNaN(ttlLBayar)) ? 0 : ttlLBayar;
                    ttlLebihBayar += ttlLBayars
                  });
                  ttlLebihBayar += lebihBayar
                  initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePelunasan_nominallebihbayar"]`).text(ttlLebihBayar))

                },
              }, ],
            },

            sortable: false,
            sorttype: "int",
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
          let originalGridData = $("#tablePelunasan")
            .jqGrid("getGridParam", "originalData")
            .find((row) => row.id == rowId);

          let localRow = $("#tablePelunasan").jqGrid("getLocalRow", rowId);

          let getBayar = $("#tablePelunasan").jqGrid("getCell", rowId, "bayar")
          let bayar = (getBayar != '') ? parseFloat(getBayar.replaceAll(',', '')) : 0

          let getPotongan = $("#tablePelunasan").jqGrid("getCell", rowId, "potongan")
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
          if (indexColumn == 9 || indexColumn == 10) {
            console.log('here')
            $("#tablePelunasan").jqGrid(
              "setCell",
              rowId,
              "sisa",
              sisa
              // sisa - bayar - potongan
            );
          }
          setTotalSisa()
          setTotalBayar()
          setTotalPotongan()
          setTotalLebihBayar()
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
                initAutoNumeric($(this).find(`td[aria-describedby="tablePelunasan_bayar"]`))
                initAutoNumeric($(this).find(`td[aria-describedby="tablePelunasan_potongan"]`))
                initAutoNumeric($(this).find(`td[aria-describedby="tablePelunasan_nominallebihbayar"]`))
              });
          }, 100);

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
          let localRow = $("#tablePelunasan").jqGrid("getLocalRow", rowId);

          $("#tablePelunasan").jqGrid(
            "setCell",
            rowId,
            "sisa",
            parseInt(localRow.sisa) + parseInt(localRow.bayar)
          );

          return true;
        },
      });
    /* Append clear filter button */
    loadClearFilter($('#tablePelunasan'))

    /* Append global search */
    // loadGlobalSearch($('#tablePelunasan'))
  }

  function getDataPelunasan(agenId, id) {
    aksi = $('#crudForm').data('action')
    if (aksi == 'edit') {
      console.log(id)
      if (id != undefined) {
        url = `${apiUrl}pelunasanpiutangheader/${id}/${agenId}/getPelunasanPiutang`
      } else {
        url = `${apiUrl}pelunasanpiutangheader/${agenId}/getpiutang`
      }
    } else if (aksi == 'delete') {
      url = `${apiUrl}pelunasanpiutangheader/${id}/${agenId}/getDeletePelunasanPiutang`
      attribut = 'disabled'
      forCheckbox = 'disabled'
    } else if (aksi == 'add') {
      url = `${apiUrl}pelunasanpiutangheader/${agenId}/getpiutang`
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
      });
    });
  }

  function checkboxHandler(element, rowId) {

    let isChecked = $(element).is(":checked");
    let editableColumns = $("#tablePelunasan").getGridParam("editableColumns");
    let selectedRowIds = $("#tablePelunasan").getGridParam("selectedRowIds");
    let originalGridData = $("#tablePelunasan")
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
          sisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.bayar))
        } else {
          sisa = originalGridData.sisa
        }

        $("#tablePelunasan").jqGrid(
          "setCell",
          rowId,
          "sisa",
          sisa
        );

        $("#tablePelunasan").jqGrid("setCell", rowId, "bayar", 0);
        $(`#tablePelunasan tr#${rowId}`).find(`td[aria-describedby="tablePelunasan_bayar"]`).attr("value", 0)
        $("#tablePelunasan").jqGrid("setCell", rowId, "potongan", 0);
        $(`#tablePelunasan tr#${rowId}`).find(`td[aria-describedby="tablePelunasan_potongan"]`).attr("value", 0)
        $("#tablePelunasan").jqGrid("setCell", rowId, "nominallebihbayar", 0);
        $(`#tablePelunasan tr#${rowId}`).find(`td[aria-describedby="tablePelunasan_nominallebihbayar"]`).attr("value", 0)
        $("#tablePelunasan").jqGrid("setCell", rowId, "keterangan", null);
        $("#tablePelunasan").jqGrid("setCell", rowId, "keteranganpotongan", null);
        $("#tablePelunasan").jqGrid("setCell", rowId, "coapotongan", null);
        setTotalBayar()
        setTotalPotongan()
        setTotalLebihBayar()
        setTotalNominal()
        setTotalSisa()
      } else {
        if (!selectAll) {
          selectedRowIds.push(rowId);
        }
        let localRow = $("#tablePelunasan").jqGrid("getLocalRow", rowId);
        console.log(rowId)
        if ($('#crudForm').data('action') == 'edit') {
          // if (originalGridData.sisa == 0) {

          //   let getNominal = $("#tablePelunasan").jqGrid("getCell", rowId, "nominal")
          //   localRow.bayar = (getNominal != '') ? parseFloat(getNominal.replaceAll(',', '')) : 0
          // } else {
          //   localRow.bayar = originalGridData.sisa
          // }
          localRow.bayar = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.bayar) + parseFloat(originalGridData.potongan))
        } else {
          localRow.bayar = originalGridData.sisa
        }

        $("#tablePelunasan").jqGrid(
          "setCell",
          rowId,
          "sisa",
          0
        );
        $("#tablePelunasan").jqGrid(
          "setCell",
          rowId,
          "bayar",
          localRow.bayar
        );

        initAutoNumeric($(`#tablePelunasan tr#${rowId}`).find(`td[aria-describedby="tablePelunasan_bayar"]`))
        initAutoNumeric($(`#tablePelunasan tr#${rowId}`).find(`td[aria-describedby="tablePelunasan_potongan"]`))
        initAutoNumeric($(`#tablePelunasan tr#${rowId}`).find(`td[aria-describedby="tablePelunasan_nominallebihbayar"]`))
        setTotalBayar()
        setTotalPotongan()
        setTotalLebihBayar()
        setTotalNominal()
        setTotalSisa()
      }
    });

    $("#tablePelunasan").jqGrid("setGridParam", {
      selectedRowIds: selectedRowIds,
    });


    // initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePelunasan_potongan"]`).text(totalPotongan))
    // initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePelunasan_nominallebihbayar"]`).text(totalNominalLebih))

  }

  function setTotalBayar() {
    let bayarDetails = $(`#tablePelunasan`).find(`td[aria-describedby="tablePelunasan_bayar"]`)
    let bayar = 0
    $.each(bayarDetails, (index, bayarDetail) => {
      bayardetail = parseFloat($(bayarDetail).text().replaceAll(',', ''))
      bayars = (isNaN(bayardetail)) ? 0 : bayardetail;
      bayar += bayars
    });
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePelunasan_bayar"]`).text(bayar))
  }

  function setTotalPotongan() {
    let potonganDetails = $(`#tablePelunasan`).find(`td[aria-describedby="tablePelunasan_potongan"]`)
    let potongan = 0
    $.each(potonganDetails, (index, potonganDetail) => {
      potongandetail = parseFloat($(potonganDetail).text().replaceAll(',', ''))
      potongans = (isNaN(potongandetail)) ? 0 : potongandetail;
      potongan += potongans
    });
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePelunasan_potongan"]`).text(potongan))
  }

  function setTotalLebihBayar() {
    let lebihBayarDetails = $(`#tablePelunasan`).find(`td[aria-describedby="tablePelunasan_nominallebihbayar"]`)
    let lebihBayar = 0
    $.each(lebihBayarDetails, (index, lebihBayarDetail) => {
      lebihbayardetail = parseFloat($(lebihBayarDetail).text().replaceAll(',', ''))
      lebihBayars = (isNaN(lebihbayardetail)) ? 0 : lebihbayardetail;
      lebihBayar += lebihBayars
    });
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePelunasan_nominallebihbayar"]`).text(lebihBayar))
  }


  function setTotalNominal() {
    let nominalDetails = $(`#tablePelunasan`).find(`td[aria-describedby="tablePelunasan_nominal"]`)
    let nominal = 0
    $.each(nominalDetails, (index, nominalDetail) => {
      nominaldetail = parseFloat($(nominalDetail).text().replaceAll(',', ''))
      nominals = (isNaN(nominaldetail)) ? 0 : nominaldetail;
      nominal += nominals
    });
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePelunasan_nominal"]`).text(nominal))
  }

  function setTotalSisa() {
    let sisaDetails = $(`#tablePelunasan`).find(`td[aria-describedby="tablePelunasan_sisa"]`)
    let sisa = 0
    $.each(sisaDetails, (index, sisaDetail) => {
      sisadetail = parseFloat($(sisaDetail).text().replaceAll(',', ''))
      sisas = (isNaN(sisadetail)) ? 0 : sisadetail;
      sisa += sisas
    });
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePelunasan_sisa"]`).text(sisa))
  }

  function editPelunasanPiutangHeader(Id) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    $('#crudModalTitle').text('Edit Pelunasan Piutang')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    showPelunasanPiutang(form, Id)

  }

  function showPelunasanPiutang(form, Id) {

    form.find(`[name="tglbukti"]`).prop('readonly', true)
    form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
    $.ajax({
      url: `${apiUrl}pelunasanpiutangheader/${Id}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {

        let tgl = response.data.tglbukti
        $.each(response.data, (index, value) => {
          bankId = response.data.bank_id
          let element = form.find(`[name="${index}"]`)

          form.find(`[name="${index}"]`).val(value).attr('readonly', true)

          if (element.hasClass('datepicker')) {
            element.val(dateFormat(value))
          }


          if (index == 'bank') {
            element.data('current-value', value).prop('readonly', true)
            element.parent('.input-group').find('.button-clear').remove()
            element.parent('.input-group').find('.input-group-append').remove()
          }
          if (index == 'alatbayar') {
            element.data('current-value', value).prop('readonly', true)
            element.parent('.input-group').find('.button-clear').remove()
            element.parent('.input-group').find('.input-group-append').remove()
          }
          if (index == 'agen') {
            element.data('current-value', value).prop('readonly', true)
            element.parent('.input-group').find('.button-clear').remove()
            element.parent('.input-group').find('.input-group-append').remove()
          }
          if (index != 'agen' && index != 'agen_id') {

            form.find(`[name="${index}"]`).addClass('disabled')
            initDisabled()
          }

        })
        let agenId = response.data.agen_id

        loadPelunasanGrid();

        getDataPelunasan(agenId, Id).then((response) => {

          let selectedId = []
          let totalBayar = 0
          let totalPotongan = 0
          let totalNominalLebih = 0

          $.each(response.data, (index, value) => {
            if (value.pelunasanpiutang_id != null) {
              selectedId.push(value.id)
              totalBayar += parseFloat(value.bayar)
              totalPotongan += parseFloat(value.potongan)
              totalNominalLebih += parseFloat(value.nominallebihbayar)
            }
          })
          $('#tablePelunasan').jqGrid("clearGridData");
          setTimeout(() => {

            $("#tablePelunasan")
              .jqGrid("setGridParam", {
                datatype: "local",
                data: response.data,
                originalData: response.data,
                selectedRowIds: selectedId
              })
              .trigger("reloadGrid");
          }, 100);

          initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePelunasan_bayar"]`).text(totalBayar))
          initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePelunasan_potongan"]`).text(totalPotongan))
          initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePelunasan_nominallebihbayar"]`).text(totalNominalLebih))
        });
      }
    })
  }
  // function clearSelectedRows() {
  //   $("#tablePelunasan")
  //     .jqGrid("setGridParam", {
  //       selectedRowIds: selectedId
  //     })
  //     .trigger("reloadGrid");
  // }

  // function selectAllRows() {
  //   aksi = $('#crudForm').data('action')
  //   id = $('#crudForm').find(`[name="id"]`).val()
  //   agenId = $('#crudForm').find(`[name="agen_id"]`).val()
  //   if (aksi == 'edit') {
  //     url = `${apiUrl}pelunasanpiutangheader/${id}/${agenId}/getPelunasanPiutang`
  //   } else if (aksi == 'delete') {
  //     url = `${apiUrl}pelunasanpiutangheader/${id}/${agenId}/getDeletePelunasanPiutang`
  //     attribut = 'disabled'
  //     forCheckbox = 'disabled'
  //   } else if (aksi == 'add') {
  //     url = `${apiUrl}pelunasanpiutangheader/${agenId}/getpiutang`
  //   }
  //   $.ajax({
  //     url: url,
  //     method: 'GET',
  //     dataType: 'JSON',
  //     headers: {
  //       Authorization: `Bearer ${accessToken}`
  //     },
  //     success: (response) => {
  //       let selectedId = []
  //       $.each(response.data, (index, value) => {
  //         selectedId.push(value.id)
  //       })
  //       setTimeout(() => {
  //         $("#tablePelunasan")
  //           .jqGrid("setGridParam", {
  //             datatype: "local",
  //             data: response.data,
  //             originalData: response.data,
  //             selectedRowIds: selectedId
  //           })
  //           .trigger("reloadGrid");
  //       }, 100);

  //       selectAll = true
  //       $.each(response.data, (index, value) => {
  //         el = '<input type="checkbox" value="' + value.id + '" checked>';
  //         checkboxHandler(el, value.id)
  //       })
  //     }
  //   })

  // }

  function deletePelunasanPiutangHeader(Id) {
    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    $('#crudModalTitle').text('Delete Pelunasan Piutang')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    showPelunasanPiutang(form, Id)
  }

  // $(window).on("load", function() {
  //   var $grid = $("#gridPiutang"),
  //     newWidth = $grid.closest(".ui-jqgrid").parent().width();
  //   $grid.jqGrid("setGridWidth", newWidth, true);
  // });

  function getPiutang(id) {
    $('#detailList tbody').html('')
    $('#detailList tfoot #nominalPiutang').html('')
    $('#detailList tfoot #sisaPiutang').html('')

    $.ajax({
      url: `${apiUrl}pelunasanpiutangheader/${id}/getpiutang`,
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
          totalNominal = parseFloat(totalNominal) + parseFloat(detail.nominal)
          totalSisa = totalSisa + parseFloat(detail.sisa);
          let nominal = new Intl.NumberFormat('en-US').format(detail.nominal);
          let sisa = new Intl.NumberFormat('en-US').format(detail.sisa);

          let detailRow = $(`
            <tr >
              <td>
                <input name='piutang_id[]' type="checkbox" id="checkItem" value="${id}">
                <input name='piutang_nobukti[]' type="hidden" value="${nobukti}">
              
              </td>
              <td></td>
              <td>${detail.nobukti}</td>
              <td>${dateFormat(detail.tglbukti)}</td>
              <td>${detail.invoice_nobukti}</td>
              <td>
                <p class="text-right nominal">${nominal}</p>
                <input type="hidden" name="nominal[]" class="autonumeric" value="${nominal}"></td>
              <td>
                <p class="text-right sisa autonumeric">${sisa}</p>
                <input type="hidden" name="sisa[]" class="autonumeric" value="${sisa}">
                <input type="hidden" name="sisaAwal[]" class="autonumeric" value="${sisa}">
              </td>
              <td>
                <textarea name="keterangandetailppd[]" rows="1" disabled class="form-control"></textarea>
              </td>
              <td id=${id}>
                <input type="text" name="bayarppd[]" disabled class="form-control bayar text-right">
              </td>
              <td id="potongan${id}">
                <input type="text" name="potonganppd[]" disabled class="form-control text-right">
              </td>
              <td>
                  <input type="text" name="coapotonganppd[]" disabled class="form-control coapotongan-lookup">
              </td>
              <td>
                <textarea name="keteranganpotonganppd[]" rows="1" disabled class="form-control"></textarea>
              </td>
              <td id="lebih${id}">
                <input type="text" name="nominallebihbayarppd[]" disabled class="form-control text-right">
              </td>
            </tr>
          `)

          initAutoNumeric(detailRow.find(`[name="nominal[]"]`))
          initAutoNumeric(detailRow.find(`[name="sisa[]"]`))
          initAutoNumeric(detailRow.find(`[name="sisaAwal[]"]`))
          initAutoNumeric(detailRow.find('.sisa'))
          initAutoNumeric(detailRow.find('.nominal'))

          $('#detailList tbody').append(detailRow)
          setTotal()
          setPenyesuaian()
          setNominalLebih()

          // initSelect2()
          // setCoaPotonganOptions(detailRow)

          $('.coapotongan-lookup').last().lookup({
            title: 'Coa Potongan Lookup',
            fileName: 'akunpusat',
            beforeProcess: function(test) {
              // var levelcoa = $(`#levelcoa`).val();
              this.postData = {
                potongan: '1',
                levelCoa: '2',
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
        // totalNominal = new Intl.NumberFormat('en-US').format(totalNominal);
        // totalSisa = new Intl.NumberFormat('en-US').format(totalSisa);
        $('#nominalPiutang').append(`${totalNominal}`)
        $('#sisaPiutang').append(`${totalSisa}`)

        initAutoNumeric($('#detailList tfoot').find('#nominalPiutang'))
        initAutoNumeric($('#detailList tfoot').find('#sisaPiutang'))
        setRowNumbers()

      }
    })


  }

  function getPelunasan(id, agenId, aksi) {

    $('#detailList tbody').html('')
    let url
    let attribut
    let forCheckbox
    if (aksi == 'edit') {
      url = `${apiUrl}pelunasanpiutangheader/${id}/${agenId}/getPelunasanPiutang`
    }
    if (aksi == 'delete') {
      url = `${apiUrl}pelunasanpiutangheader/${id}/${agenId}/getDeletePelunasanPiutang`
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

        let totalNominalPiutang = 0
        let totalSisa = 0
        let totalNominal = 0
        $.each(response.data, (index, detail) => {

          let id = detail.id
          let nobukti = detail.piutang_nobukti;
          let pelunasanPiutangId = detail.pelunasanpiutang_id
          let checked

          totalNominalPiutang = parseFloat(totalNominalPiutang) + parseFloat(detail.nominalpiutang)
          totalSisa = totalSisa + parseFloat(detail.sisa);
          let nominal = new Intl.NumberFormat('en-US').format(detail.nominalpiutang);
          // let sisaHidden = parseFloat(detail.sisa) + parseFloat(detail.nominal)
          let sisa = new Intl.NumberFormat('en-US').format(detail.sisa);
          if (pelunasanPiutangId != null) {
            checked = 'checked'
            attribut = 'enable'
          } else {
            attribut = 'disabled'
          }

          let detailRow = $(`
            <tr>
              <td>
                <input name='piutang_id[]' type="checkbox" class="checkItem" value="${id}" ${checked} ${forCheckbox}>
                <input name='piutang_nobukti[]' type="hidden" value="${nobukti}">
              </td>
              <td></td>
              <td>${detail.piutang_nobukti}</td>
              <td>${dateFormat(detail.tglbukti)}</td>
              <td>${detail.invoice_nobukti}</td>
              <td>
                <p class="text-right nominal">${nominal}</p>
                <input type="hidden" name="nominal[]" class="autonumeric" value="${nominal}">
              </td>
              <td>
                <p class="sisa text-right">${sisa}</p>
                <input type="hidden" name="sisa[]" class="autonumeric" value="${sisa}">
                <input type="hidden" name="sisaAwal[]" class="autonumeric" value="${sisa}">
              </td>
              <td>
                <textarea name="keterangandetailppd[]" rows="1" class="form-control" ${attribut}>${detail.keterangan || ''}</textarea>
              </td>
              <td id=${id}>
                <input type="text" name="bayarppd[]" class="form-control bayar text-right" value="${detail.nominal || ''}" ${attribut}>
              </td>
              <td id="potongan${id}">
                <input type="text" name="potonganppd[]" class="form-control text-right" value="${detail.potongan || ''}" ${attribut}>
              </td>
              <td>
                <input type="text" name="coapotonganppd[]" class="form-control coapotongan-lookup" data-current-value="${detail.coapotongan}" ${attribut}>
              </td>
              <td>
                <textarea name="keteranganpotonganppd[]" rows="1" class="form-control" ${attribut}>${detail.keteranganpotongan || ''}</textarea>
              </td>
              <td id="lebih${id}">
                <input type="text" name="nominallebihbayarppd[]" class="form-control autonumeric" value="${detail.nominallebihbayar || ''}" ${attribut}>
              </td>
            </tr>
          `)

          detailRow.find(`[name="coapotonganppd[]"]`).val(detail.coapotongan)
          if (aksi == 'edit') {

            initAutoNumericNoMinus(detailRow.find(`[name="bayarppd[]"]`).not(':disabled'))
            initAutoNumericNoMinus(detailRow.find(`[name="potonganppd[]"]`).not(':disabled'))
            initAutoNumericNoMinus(detailRow.find(`[name="nominallebihbayarppd[]"]`).not(':disabled'))
          }
          if (aksi == 'delete') {

            initAutoNumericNoMinus(detailRow.find(`[name="bayarppd[]"]`))
            initAutoNumericNoMinus(detailRow.find(`[name="potonganppd[]"]`))
            initAutoNumericNoMinus(detailRow.find(`[name="nominallebihbayarppd[]"]`))

          }
          initAutoNumeric(detailRow.find(`[name="nominal[]"]`))
          initAutoNumeric(detailRow.find(`[name="sisa[]"]`))
          initAutoNumeric(detailRow.find(`[name="sisaAwal[]"]`))
          initAutoNumeric(detailRow.find('.sisa'))
          initAutoNumeric(detailRow.find('.nominal'))

          $('#detailList tbody').append(detailRow)


          $('.coapotongan-lookup').last().lookup({
            title: 'Coa Potongan Lookup',
            fileName: 'akunpusat',
            beforeProcess: function(test) {
              // var levelcoa = $(`#levelcoa`).val();
              this.postData = {
                potongan: '1',
                Aktif: 'AKTIF',
                levelCoa: '2',
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
          if (aksi == 'delete') {
            let nominalDetails = $(`#table_body [name="bayarppd[]"]`)
            let total = 0

            $.each(nominalDetails, (index, nominalDetail) => {
              total += AutoNumeric.getNumber(nominalDetail)
            });

            new AutoNumeric('#bayarPiutang').set(total)

            let potongan = $(`#table_body [name="potonganppd[]"]`)
            let totalPenyesuaian = 0

            $.each(potongan, (index, potongan) => {
              totalPenyesuaian += AutoNumeric.getNumber(potongan)
            });

            new AutoNumeric('#bayarPotongan').set(totalPenyesuaian)


            let nominalLebih = $(`#table_body [name="nominallebihbayarppd[]"]`)
            let totalNominalLebih = 0

            $.each(nominalLebih, (index, nominalLebih) => {
              totalNominalLebih += AutoNumeric.getNumber(nominalLebih)
            });

            new AutoNumeric('#bayarNominalLebih').set(totalNominalLebih)
          } else {
            setTotal()
            setPenyesuaian()
            setNominalLebih()
          }

        })
        $('#nominalPiutang').append(`${totalNominalPiutang}`)
        $('#sisaPiutang').append(`${totalSisa}`)
        initAutoNumeric($('#detailList tfoot').find('#nominalPiutang'))
        initAutoNumeric($('#detailList tfoot').find('#sisaPiutang'))
        setRowNumbers()


      }
    })

  }

  $("#checkAll").click(function() {
    $('input:checkbox').not(this).prop('checked', this.checked);
  });


  $(document).on('click', `#detailList tbody [name="piutang_id[]"]`, function() {

    if ($(this).prop("checked") == true) {

      nobukti = $(this).val()
      $(this).closest('tr').find(`td [name="keterangandetailppd[]"]`).prop('disabled', false)
      $(this).closest('tr').find(`td [name="nominallebihbayarppd[]"]`).prop('disabled', false)
      $(this).closest('tr').find(`td [name="bayarppd[]"]`).prop('disabled', false)
      $(this).closest('tr').find(`td [name="keteranganpotonganppd[]"]`).prop('disabled', false)
      $(this).closest('tr').find(`td [name="potonganppd[]"]`).prop('disabled', false)
      $(this).closest('tr').find(`td [name="coapotonganppd[]"]`).prop('disabled', false)
      $(this).closest('tr').find(`td [name="nominallebihbayarppd[]"]`).prop('disabled', false)

      let sisa = AutoNumeric.getNumber($(this).closest('tr').find(`td [name="sisa[]"]`)[0])
      initAutoNumeric($(this).closest('tr').find(`td [name="bayarppd[]"]`).val(sisa))
      initAutoNumeric($(this).closest('tr').find(`td [name="potonganppd[]"]`))
      initAutoNumeric($(this).closest('tr').find(`td [name="nominallebihbayarppd[]"]`))
      let bayar = AutoNumeric.getNumber($(this).closest('tr').find(`td [name="bayarppd[]"]`)[0])
      let totalSisa = sisa - bayar

      $(this).closest("tr").find(".sisa").html(totalSisa)
      $(this).closest("tr").find(`[name="sisa[]"]`).val(totalSisa)
      initAutoNumeric($(this).closest("tr").find(".sisa"))

      setTotal()
      setPenyesuaian()
      setNominalLebih()
      setSisa()

    } else {
      let id = $(this).val()
      let action = $('#crudForm').data('action')
      $(this).closest('tr').find(`td [name="keterangandetailppd[]"]`).prop('disabled', true)
      $(this).closest('tr').find(`td [name="nominallebihbayarppd[]"]`).prop('disabled', true)
      $(this).closest('tr').find(`td [name="bayarppd[]"]`).prop('disabled', true)
      $(this).closest('tr').find(`td [name="keteranganpotonganppd[]"]`).prop('disabled', true)
      $(this).closest('tr').find(`td [name="potonganppd[]"]`).val('').prop('disabled', true)
      $(this).closest('tr').find(`td [name="coapotonganppd[]"]`).prop('disabled', true)
      $(this).closest('tr').find(`td [name="nominallebihbayarppd[]"]`).prop('disabled', true)
      $(this).closest('tr').find(`td [name="bayarppd[]"]`).val('')
      if (action == 'add') {
        nominal = AutoNumeric.getNumber($(this).closest('tr').find(`td [name="sisaAwal[]"]`)[0])
      } else {
        nominal = AutoNumeric.getNumber($(this).closest('tr').find(`td [name="nominal[]"]`)[0])
      }
      initAutoNumeric($(this).closest('tr').find(`td [name="sisa[]"]`).val(nominal))
      $(this).closest("tr").find(".sisa").html(nominal)
      initAutoNumeric($(this).closest("tr").find(".sisa"))

      $(this).closest('tr').find(`td [name="bayarppd[]"]`).remove();
      $(this).closest('tr').find(`td [name="potonganppd[]"]`).remove();
      $(this).closest('tr').find(`td [name="nominallebihbayarppd[]"]`).remove();
      let newBayarElement = `<input type="text" name="bayarppd[]" class="form-control bayar text-right" disabled>`
      let newPotonganElement = `<input type="text" name="potonganppd[]" class="form-control text-right" disabled>`
      let newLebihElement = `<input type="text" name="nominallebihbayarppd[]" class="form-control text-right" disabled>`

      $(this).closest('tr').find(`#${id}`).append(newBayarElement)
      $(this).closest('tr').find(`#potongan${id}`).append(newPotonganElement)
      $(this).closest('tr').find(`#lebih${id}`).append(newLebihElement)

      setTotal()
      setPenyesuaian()
      setNominalLebih()
      setSisa()
    }
  })


  function setRowNumbers() {
    let elements = $('#detailList tbody tr td:nth-child(2)')

    elements.each((index, element) => {
      $(element).text(index + 1)
    })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}pelunasanpiutangheader/field_length`,
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


  function showDefault(form) {
    $.ajax({
      url: `${apiUrl}pelunasanpiutangheader/default`,
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

          if (element.is('select')) {
            element.val(value).trigger('change')
          } else {
            element.val(value)
          }
        })
      }
    })
  }

  function initLookup() {

    $('.bank-lookup').lookup({
      title: 'Bank Lookup',
      fileName: 'bank',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (bank, element) => {

        bankId = bank.id
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

    $('.agen-lookup').lookup({
      title: 'Agen Detail Lookup',
      fileName: 'agen',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',

        }
      },
      onSelectRow: (agen, element) => {
        $('#crudForm [name=agen_id]').first().val(agen.id)
        element.val(agen.namaagen)
        // getPiutang(agen.id)
        $('#tablePelunasan').jqGrid("clearGridData");
        $("#tablePelunasan")
          .jqGrid("setGridParam", {
            selectedRowIds: []
          })
          .trigger("reloadGrid");
        getDataPelunasan(agen.id).then((response) => {

          console.log('before', $("#tablePelunasan").jqGrid('getGridParam', 'selectedRowIds'))
          setTimeout(() => {

            $("#tablePelunasan")
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
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=agen_id]').first().val('')
        // $("#tablePelunasan")
        //   .jqGrid("setGridParam", {
        //     selectedRowIds: []
        //   })
        //   .trigger("reloadGrid");

        console.log('onclear', $("#tablePelunasan").jqGrid('getGridParam', 'selectedRowIds'))
        // setTimeout(() => {
        $('#tablePelunasan').jqGrid("clearGridData");
        // }, 100);
        $('.footrow').find(`td[aria-describedby="tablePelunasan_bayar"]`).text('')
        $('.footrow').find(`td[aria-describedby="tablePelunasan_potongan"]`).text('')
        $('.footrow').find(`td[aria-describedby="tablePelunasan_nominallebihbayar"]`).text('')

        element.val('')
        element.data('currentValue', element.val())
      }
    })
  }
</script>
@endpush()