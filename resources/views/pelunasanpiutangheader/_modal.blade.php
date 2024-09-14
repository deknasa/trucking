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

            <div class="row form-group agen">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  CUSTOMER <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-8 col-md-10">
                <input type="hidden" name="agen_id" class="form-control">
                <input type="text" name="agen" class="form-control agen-lookup">
              </div>
            </div>
            <div class="row form-group pelanggan">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  PELANGGAN <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-8 col-md-10">
                <input type="hidden" name="pelanggan_id" class="form-control">
                <input type="text" name="pelanggan" class="form-control pelanggan-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  PELUNASAN <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-8 col-md-10">
                <select name="statuspelunasan" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH STATUS PELUNASAN --</option>
                </select>
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
                  NO BUKTI PENGELUARAN
                </label>
              </div>
              <div class="col-8 col-md-10">
                <input type="text" name="pengeluaran_nobukti" class="form-control" readonly>
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
                  NO BUKTI NOTA KREDIT B. PPH
                </label>
              </div>
              <div class="col-8 col-md-10">
                <input type="text" name="notakreditpph_nobukti" class="form-control" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  NO BUKTI NOTA DEBET
                </label>
              </div>
              <div class="col-8 col-md-10">
                <input type="text" name="notadebet_nobukti" class="form-control notadebet-lookup" readonly>
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
                  TGL JATUH TEMPO
                </label>
              </div>
              <div class="col-8 col-md-10">
                <div class="input-group">
                  <input type="text" name="tgljatuhtempo" class="form-control datepicker">
                </div>
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
              Save
            </button>
            <button id="btnSaveAdd" class="btn btn-success">
              <i class="fas fa-file-upload"></i>
              Save & Add
            </button>
            <button id="btnBatal" class="btn btn-secondary" data-dismiss="modal">
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
  let agenId
  let pelangganId
  let selectAll = false
  let isEditTgl
  let statusDebet = {}
  let statusKredit = {}
  let topAgen = 0
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
        name: 'statuspelunasan',
        value: form.find(`[name="statuspelunasan"]`).val()
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
        name: 'pelanggan',
        value: form.find(`[name="pelanggan"]`).val()
      })
      data.push({
        name: 'pelanggan_id',
        value: form.find(`[name="pelanggan_id"]`).val()
      })
      data.push({
        name: 'nowarkat',
        value: form.find(`[name="nowarkat"]`).val()
      })
      data.push({
        name: 'tgljatuhtempo',
        value: form.find(`[name="tgljatuhtempo"]`).val()
      })
      data.push({
        name: 'penerimaan_nobukti',
        value: form.find(`[name="penerimaan_nobukti"]`).val()
      })
      data.push({
        name: 'pengeluaran_nobukti',
        value: form.find(`[name="pengeluaran_nobukti"]`).val()
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

      data.push({
        name: 'aksi',
        value: action.toUpperCase()
      })
      let selectedRows = $("#tablePelunasan").getGridParam("selectedRowIds");
      data.push({
        name: 'jumlahdetail',
        value: selectedRows
      })
      $.each(selectedRows, function(index, value) {
        $('#tablePelunasan').jqGrid('saveCell', value, 5); //nominal
        $('#tablePelunasan').jqGrid('saveCell', value, 6); //sisa
        $('#tablePelunasan').jqGrid('saveCell', value, 7); //keterangan
        $('#tablePelunasan').jqGrid('saveCell', value, 8); //bayar
        $('#tablePelunasan').jqGrid('saveCell', value, 9); //potongan
        $('#tablePelunasan').jqGrid('saveCell', value, 10); //coapotongan
        $('#tablePelunasan').jqGrid('saveCell', value, 11); //keteranganpotongan
        $('#tablePelunasan').jqGrid('saveCell', value, 12); //nominallebihbayar
      })
      $.each(selectedRows, function(index, value) {
        dataPelunasan = $("#tablePelunasan").jqGrid("getLocalRow", value);
        let selectedBayar = (dataPelunasan.bayar == undefined || dataPelunasan.bayar == '') ? 0 : dataPelunasan.bayar;
        let selectedPotongan = (dataPelunasan.potongan == undefined || dataPelunasan.potongan == '') ? 0 : dataPelunasan.potongan;
        let selectedPotonganPPH = (dataPelunasan.potonganpph == undefined || dataPelunasan.potonganpph == '') ? 0 : dataPelunasan.potonganpph;
        let selectedLebihBayar = (dataPelunasan.nominallebihbayar == undefined || dataPelunasan.nominallebihbayar == '') ? 0 : dataPelunasan.nominallebihbayar;
        let selectedSisa = dataPelunasan.sisa
        data.push({
          name: 'bayar[]',
          value: (isNaN(selectedBayar)) ? parseFloat(selectedBayar.replaceAll(',', '')) : selectedBayar
        })
        data.push({
          name: 'potongan[]',
          value: (isNaN(selectedPotongan)) ? parseFloat(selectedPotongan.replaceAll(',', '')) : selectedPotongan
        })
        data.push({
          name: 'potonganpph[]',
          value: (isNaN(selectedPotonganPPH)) ? parseFloat(selectedPotonganPPH.replaceAll(',', '')) : selectedPotonganPPH
        })
        data.push({
          name: 'nominallebihbayar[]',
          value: (isNaN(selectedLebihBayar)) ? parseFloat(selectedLebihBayar.replaceAll(',', '')) : selectedLebihBayar
        })
        data.push({
          name: 'sisa[]',
          value: selectedSisa
        })
        data.push({
          name: 'keterangan[]',
          value: dataPelunasan.keterangan
        })
        data.push({
          name: 'statusnotadebet[]',
          value: dataPelunasan.statusnotadebet
        })
        data.push({
          name: 'keteranganpotongan[]',
          value: dataPelunasan.keteranganpotongan
        })
        data.push({
          name: 'keteranganpotonganpph[]',
          value: dataPelunasan.keteranganpotonganpph
        })
        data.push({
          name: 'piutang_nobukti[]',
          value: dataPelunasan.nobukti
        })
        data.push({
          name: 'piutang_id[]',
          value: dataPelunasan.id
        })
      });
      data.push({
        name: 'info',
        value: info
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
          if (button == 'btnSubmit') {
            $('#crudModal').modal('hide')
            $('#piutangrow').html('')
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

            $('#detailList tbody').html('')
            $('#nominalPiutang').html('')
            $('#sisaPiutang').html('')

            if (response.data.grp == 'FORMAT') {
              updateFormat(response.data)
            }
          } else {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
            $('#crudForm').find('input[type="text"]').data('current-value', '')
            // showSuccessDialog(response.message, response.data.nobukti)

            $("#tablePelunasan")[0].p.selectedRowIds = [];
            $('#tablePelunasan').jqGrid("clearGridData");
            $("#tablePelunasan")
              .jqGrid("setGridParam", {
                selectedRowIds: []
              })
            createPelunasanPiutangHeader();
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

              if (indexes[0] == 'alatbayar' || indexes[0] == 'statuspelunasan' || indexes[0] == 'id' || indexes[0] == 'tglbukti' || indexes[0] == 'bank' || indexes[0] == 'nowarkat' || indexes[0] == 'agen' || indexes[0] == 'pelanggan' || indexes[0] == 'tgljatuhtempo' || indexes[0] == 'piutang_id' || indexes[0] == 'notadebet_nobukti') {
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

    getMaxLength(form)
    form.find('#btnSubmit').prop('disabled', false)
    if (form.data('action') == "view") {
      form.find('#btnSubmit').prop('disabled', true)
    }
    if (form.data('action') == 'add') {
      form.find('#btnSaveAdd').show()
    } else {
      form.find('#btnSaveAdd').hide()
    }
    initLookup()
    initDatepicker()
    initSelect2($(`.select2bs4`), true)
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
    formData.append('table', 'pelunasanpiutangheader');

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

  $(document).on('change', `#crudForm [name="statuspelunasan"]`, function() {
    pelunasanText = $("[name=statuspelunasan] option:selected").text()
    if ($.trim(pelunasanText) == 'NOTA DEBET') {
      $('#tablePelunasan').jqGrid('setColProp', 'nominallebihbayar', {
        editable: false
      });
      $('#tablePelunasan').jqGrid('setColProp', 'statusnotadebet', {
        editable: false
      });
      notaDebetSelected(true)
    } else {
      $('#tablePelunasan').jqGrid('setColProp', 'nominallebihbayar', {
        editable: true
      });
      $('#tablePelunasan').jqGrid('setColProp', 'statusnotadebet', {
        editable: true
      });
      notaDebetSelected(false)
    }
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

  function enableTglJatuhTempo(el) {
    if ($(`#crudForm [name="alatbayar"]`).val() == 'GIRO') {
      el.find(`[name="tgljatuhtempo"]`).addClass('datepicker')
      el.find(`[name="tgljatuhtempo"]`).attr('readonly', false)
      initDatepicker()
      el.find(`[name="tgljatuhtempo"]`).parent('.input-group').find('.input-group-append').show()
    } else {
      el.find(`[name="tgljatuhtempo"]`).removeClass('datepicker')
      el.find(`[name="tgljatuhtempo"]`).parent('.input-group').find('.input-group-append').hide()
      el.find(`[name="tgljatuhtempo"]`).val($('#crudForm').find(`[name="tglbukti"]`).val()).trigger('change');
      el.find(`[name="tgljatuhtempo"]`).attr('readonly', true)
    }
  }

  function enableNoWarkat(el) {
    if ($(`#crudForm [name="alatbayar"]`).val() != 'TUNAI') {
      el.find(`[name="nowarkat"]`).attr('readonly', false)
    } else {
      el.find(`[name="nowarkat"]`).attr('readonly', true)
      el.find(`[name="nowarkat"]`).val('')
    }
  }


  function notaDebetSelected(status) {
    if (status) {
      $('[name=bank]').parents('.form-group').hide()
      $('[name=alatbayar]').parents('.form-group').hide()
      $("#tablePelunasan").jqGrid('setColProp', 'nominallebihbayar', {
        editable: false
      });
      $("#tablePelunasan").jqGrid('setColProp', 'statusnotadebet', {
        editable: false
      });

      selectedRows = $("#tablePelunasan").getGridParam("selectedRowIds");
      $.each(selectedRows, function(index, value) {
        $("#tablePelunasan").jqGrid("setCell", value, "nominallebihbayar", 0);
        $(`#tablePelunasan tr#${value}`).find(`td[aria-describedby="tablePelunasan_nominallebihbayar"]`).attr("value", "")
        $("#tablePelunasan").jqGrid("setCell", value, "statusnotadebet", 0);
        $(`#tablePelunasan tr#${value}`).find(`td[aria-describedby="tablePelunasan_statusnotadebet"]`).attr("value", 0).trigger('change')
      })

      let notadebet_nobukti = $('#crudForm').find(`[name="notadebet_nobukti"]`).parents('.input-group').children()
      notadebet_nobukti.attr('readonly', false)
      notadebet_nobukti.parents('.input-group').find('.button-clear').attr('disabled', false)
      notadebet_nobukti.find('.lookup-toggler').attr('disabled', false)

    } else {
      $('[name=bank]').parents('.form-group').show()
      $('[name=alatbayar]').parents('.form-group').show()
      $('[name=notadebet_nobukti]').val('')
      let notadebet_nobukti = $('#crudForm').find(`[name="notadebet_nobukti"]`).parents('.input-group').children()
      notadebet_nobukti.attr('readonly', true)
      notadebet_nobukti.parents('.input-group').find('.button-clear').attr('disabled', true)
      notadebet_nobukti.find('.lookup-toggler').attr('disabled', true)
    }

  }

  $(document).on('change', `#crudForm [name="tglbukti"]`, function() {
    if ($(`#crudForm [name="alatbayar"]`).val() != 'GIRO') {
      $('#crudForm').find(`[name="tgljatuhtempo"]`).val($(this).val()).trigger('change');
    }
  });

  function createPelunasanPiutangHeader() {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.data('action', 'add')
    $('#crudModalTitle').text('Add Pelunasan Piutang')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    setStatusNotaDebetOptions()
    setStatusNotaKreditOptions()
    Promise
      .all([
        setStatusPelunasanOptions(form),
        showDefault(form)
      ])
      .then(() => {
        if (selectedRows.length > 0) {
          clearSelectedRows()
        }

        if (accessCabang == 'BTG-EMKL') {
          $('.agen').hide()
          $('.pelanggan').show()
        } else {
          $('.agen').show()
          $('.pelanggan').hide()
        }
        loadPelunasanGrid()
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


  }

  function clearSelectedRowsPelunasan() {
    getSelectedRows = $("#tablePelunasan").getGridParam("selectedRowIds");
    $("#tablePelunasan")[0].p.selectedRowIds = [];
    $.each(getSelectedRows, function(index, value) {
      let originalGridData = $("#tablePelunasan")
        .jqGrid("getGridParam", "originalData")
        .find((row) => row.id == value);

      sisa = 0
      if ($('#crudForm').data('action') == 'edit') {
        sisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.bayar) + parseFloat(originalGridData.potongan))
      } else {
        sisa = originalGridData.sisa
      }

      $("#tablePelunasan").jqGrid(
        "setCell",
        value,
        "sisa",
        sisa
      );

      $("#tablePelunasan").jqGrid("setCell", value, "bayar", 0);
      $(`#tablePelunasan tr#${value}`).find(`td[aria-describedby="tablePelunasan_bayar"]`).attr("value", 0)
      $("#tablePelunasan").jqGrid("setCell", value, "potongan", 0);
      $(`#tablePelunasan tr#${value}`).find(`td[aria-describedby="tablePelunasan_potongan"]`).attr("value", 0)
      $("#tablePelunasan").jqGrid("setCell", value, "nominallebihbayar", 0);
      $(`#tablePelunasan tr#${value}`).find(`td[aria-describedby="tablePelunasan_nominallebihbayar"]`).attr("value", 0)
      $("#tablePelunasan").jqGrid("setCell", value, "keterangan", null);
      $("#tablePelunasan").jqGrid("setCell", value, "keteranganpotongan", null);
      $("#tablePelunasan").jqGrid("setCell", value, "coapotongan", null);
    })
    $('#tablePelunasan').trigger('reloadGrid');
    setTotalBayar()
    setTotalPotongan()
    setTotalLebihBayar()
    setTotalNominal()
    setTotalSisa()
  }

  function selectAllRowsPelunasan() {
    let getSelectedRows = [];
    let originalData = $("#tablePelunasan").getGridParam("data");
    $.each(originalData, function(index, value) {
      getSelectedRows.push(value.id);
      rowId = value.id
      let localRow = $("#tablePelunasan").jqGrid("getLocalRow", rowId);

      let originalGridData = $("#tablePelunasan")
        .jqGrid("getGridParam", "originalData")
        .find((row) => row.id == rowId);
      if ($('#crudForm').data('action') == 'edit') {
        if (parseFloat(localRow.bayar) != 0) {
          localRow.bayar = parseFloat(originalGridData.bayar)
          $("#tablePelunasan").jqGrid("setCell", rowId, "sisa", originalGridData.sisa);
        } else if (parseFloat(localRow.potongan) != 0) {
          localRow.bayar = 0
          $("#tablePelunasan").jqGrid("setCell", rowId, "sisa", originalGridData.sisa);
        } else {
          localRow.bayar = parseFloat(localRow.sisa)
          $("#tablePelunasan").jqGrid("setCell", rowId, "sisa", 0);
        }

        $("#tablePelunasan").jqGrid("setCell", rowId, "potongan", localRow.potongan);
        $("#tablePelunasan").jqGrid("setCell", rowId, "nominallebihbayar", localRow.nominallebihbayar);
      } else {
        localRow.bayar = originalGridData.sisa

        $("#tablePelunasan").jqGrid("setCell", rowId, "sisa", 0);
        $("#tablePelunasan").jqGrid("setCell", rowId, "potongan", 0);
        $("#tablePelunasan").jqGrid("setCell", rowId, "nominallebihbayar", 0);
      }

      $("#tablePelunasan").jqGrid("setCell", rowId, "bayar", localRow.bayar);

      initAutoNumeric($(`#tablePelunasan tr#${rowId}`).find(`td[aria-describedby="tablePelunasan_bayar"]`))
      initAutoNumeric($(`#tablePelunasan tr#${rowId}`).find(`td[aria-describedby="tablePelunasan_potongan"]`))
      initAutoNumeric($(`#tablePelunasan tr#${rowId}`).find(`td[aria-describedby="tablePelunasan_nominallebihbayar"]`))

    })

    console.log(getSelectedRows)
    $("#tablePelunasan")[0].p.selectedRowIds = [];
    $("#tablePelunasan")
      .jqGrid("setGridParam", {
        selectedRowIds: getSelectedRows
      })
      .trigger("reloadGrid");
    setTotalBayar()
    setTotalPotongan()
    setTotalLebihBayar()
    setTotalNominal()
    setTotalSisa()
  }

  function loadPelunasanGrid() {
    let disabled = '';
    if ($('#crudForm').data('action') == 'delete') {
      disabled = 'disabled'
    }

    $("#tablePelunasan")
      .jqGrid({
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "local",
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
                      selectAllRowsPelunasan()
                    } else {
                      clearSelectedRowsPelunasan()
                    }
                  })
                } else {
                  $(element).attr('disabled', true)
                }

              }
            },
            formatter: function(value, rowOptions, rowData) {
              let disabled = '';
              if ($('#crudForm').data('action') == 'delete' || $('#crudForm').data('action') == 'view') {
                disabled = 'disabled'
              }
              return `<input type="checkbox" class="checkbox-jqgrid" value="${rowData.id}" ${disabled} onChange="checkboxHandlerPelunasan(this, ${rowData.id})">`;
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
            name: "tglbukti_piutang",
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
            editoptions: {
              dataEvents: [{
                type: "keyup",
                fn: function(event, rowObject) {

                  let localRow = $("#tablePelunasan").jqGrid(
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

                  // ambil data potongan per row
                  dataPelunasan = $("#tablePelunasan").jqGrid("getLocalRow", rowObject.rowId);
                  getPotongan = (dataPelunasan.potongan == undefined || dataPelunasan.potongan == '') ? 0 : dataPelunasan.potongan;
                  potongan = (isNaN(getPotongan)) ? parseFloat(getPotongan.replaceAll(',', '')) : getPotongan

                  getPotonganPPH = (dataPelunasan.potonganpph == undefined || dataPelunasan.potonganpph == '') ? 0 : dataPelunasan.potonganpph;
                  potonganPPH = (isNaN(getPotonganPPH)) ? parseFloat(getPotonganPPH.replaceAll(',', '')) : getPotonganPPH

                  if ($('#crudForm').data('action') == 'edit') {
                    totalSisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.bayar) + parseFloat(originalGridData.potongan) + parseFloat(originalGridData.potonganpph)) - bayar - potongan - potonganPPH
                  } else {
                    totalSisa = originalGridData.sisa - bayar - potongan - potonganPPH
                  }

                  $("#tablePelunasan").jqGrid(
                    "setCell",
                    rowObject.rowId,
                    "sisa",
                    totalSisa
                  );

                  if (totalSisa < 0) {
                    showDialog('sisa tidak boleh minus')
                    $("#tablePelunasan").jqGrid(
                      "setCell",
                      rowObject.rowId,
                      "bayar",
                      0
                    );
                    // if (originalGridData.sisa == 0) {
                    //   $("#tablePelunasan").jqGrid("setCell", rowObject.rowId, "sisa", (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.bayar)));
                    // } else {
                    totalSisaKosong = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.bayar) + parseFloat(originalGridData.potongan) + parseFloat(originalGridData.potonganpph)) - potongan - potonganPPH
                    $("#tablePelunasan").jqGrid("setCell", rowObject.rowId, "sisa", totalSisaKosong);
                    // }
                  }

                  setTotalBayar()
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
                  localRow.potongan = event.target.value;

                  let totalSisa
                  let potongan = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])
                  // ambil data potongan per row
                  dataPelunasan = $("#tablePelunasan").jqGrid("getLocalRow", rowObject.rowId);
                  getBayar = (dataPelunasan.bayar == undefined || dataPelunasan.bayar == '') ? 0 : dataPelunasan.bayar;
                  bayar = (isNaN(getBayar)) ? parseFloat(getBayar.replaceAll(',', '')) : getBayar

                  getPotonganPPH = (dataPelunasan.potonganpph == undefined || dataPelunasan.potonganpph == '') ? 0 : dataPelunasan.potonganpph;
                  potonganPPH = (isNaN(getPotonganPPH)) ? parseFloat(getPotonganPPH.replaceAll(',', '')) : getPotonganPPH

                  if ($('#crudForm').data('action') == 'edit') {
                    totalSisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.bayar) + parseFloat(originalGridData.potongan) + parseFloat(originalGridData.potonganpph)) - bayar - potongan - potonganPPH
                  } else {
                    totalSisa = originalGridData.sisa - bayar - potongan - potonganPPH
                  }
                  $("#tablePelunasan").jqGrid(
                    "setCell",
                    rowObject.rowId,
                    "sisa",
                    totalSisa
                  );

                  if (totalSisa < 0) {
                    showDialog('sisa tidak boleh minus')
                    $("#tablePelunasan").jqGrid(
                      "setCell",
                      rowObject.rowId,
                      "potongan",
                      0
                    );
                    // if (originalGridData.sisa == 0) {

                    //   totalSisaKosong = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.bayar) + parseFloat(originalGridData.potongan) + parseFloat(originalGridData.potonganpph)) - bayar - potonganPPH
                    //   $("#tablePelunasan").jqGrid("setCell", rowObject.rowId, "sisa", totalSisaKosong);
                    // } else {
                    totalSisaKosong = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.bayar) + parseFloat(originalGridData.potongan) + parseFloat(originalGridData.potonganpph)) - bayar - potonganPPH
                    $("#tablePelunasan").jqGrid("setCell", rowObject.rowId, "sisa", totalSisaKosong);
                    // }
                  }

                  setTotalPotongan()
                  setTotalSisa()
                },
              }, ],
            },

            sortable: false,
            sorttype: "int",
          },
          {
            label: "KETERANGAN POTONGAN",
            name: "keteranganpotongan",
            editable: true,
            sortable: false,
            editoptions: {
              dataEvents: [{
                type: "keyup",
                fn: function(event, rowObject) {

                  let localRow = $("#tablePelunasan").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );
                  localRow.keteranganpotongan = event.target.value;
                },
              }, ],
            },
          },
          {
            label: "Potongan PPH",
            name: "potonganpph",
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
                  localRow.potonganpph = event.target.value;

                  let totalSisa
                  let potonganpph = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])
                  // ambil data potongan per row
                  dataPelunasan = $("#tablePelunasan").jqGrid("getLocalRow", rowObject.rowId);
                  getBayar = (dataPelunasan.bayar == undefined || dataPelunasan.bayar == '') ? 0 : dataPelunasan.bayar;
                  bayar = (isNaN(getBayar)) ? parseFloat(getBayar.replaceAll(',', '')) : getBayar
                  getPotongan = (dataPelunasan.potongan == undefined || dataPelunasan.potongan == '') ? 0 : dataPelunasan.potongan;
                  potongan = (isNaN(getPotongan)) ? parseFloat(getPotongan.replaceAll(',', '')) : getPotongan

                  if ($('#crudForm').data('action') == 'edit') {
                    totalSisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.bayar) + parseFloat(originalGridData.potongan) + parseFloat(originalGridData.potonganpph)) - bayar - potongan - potonganpph
                  } else {
                    totalSisa = originalGridData.sisa - bayar - potongan - potonganpph
                  }
                  $("#tablePelunasan").jqGrid(
                    "setCell",
                    rowObject.rowId,
                    "sisa",
                    totalSisa
                  );

                  if (totalSisa < 0) {
                    showDialog('sisa tidak boleh minus')
                    $("#tablePelunasan").jqGrid(
                      "setCell",
                      rowObject.rowId,
                      "potonganpph",
                      0
                    );
                    // if (originalGridData.sisa == 0) {
                    //   $("#tablePelunasan").jqGrid("setCell", rowObject.rowId, "sisa", (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.bayar) + parseFloat(originalGridData.potongan)) - bayar - potongan);
                    // } else {
                    totalSisaKosong = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.bayar) + parseFloat(originalGridData.potongan) + parseFloat(originalGridData.potonganpph)) - bayar - potongan
                    $("#tablePelunasan").jqGrid("setCell", rowObject.rowId, "sisa", totalSisaKosong);
                    // }
                  }

                  setTotalPotonganPph()
                  setTotalSisa()
                },
              }, ],
            },

            sortable: false,
            sorttype: "int",
          },
          {
            label: "KET. POTONGAN PPH",
            name: "keteranganpotonganpph",
            editable: true,
            sortable: false,
            editoptions: {
              dataEvents: [{
                type: "keyup",
                fn: function(event, rowObject) {

                  let localRow = $("#tablePelunasan").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );
                  localRow.keteranganpotonganpph = event.target.value;
                },
              }, ],
            },
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
                  let localRow = $("#tablePelunasan").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );
                  localRow.nominallebihbayar = event.target.value;
                  let lebihBayar = AutoNumeric.getNumber($('#crudForm').find(`[id="${rowObject.id}"]`)[0])

                  setTotalLebihBayar()
                },
              }, ],
            },

            sortable: false,
            sorttype: "int",
          },
          {
            label: "TIPE NOTA DEBET",
            name: "statusnotadebet",
            width: 250,
            editable: true,
            edittype: "select",
            formatoptions: {
              disabled: false
            },
            editoptions: {
              class: 'statusdebet',
              value: statusDebet,
              dataInit: function(element) {
                initSelect2($(`.statusdebet`), true);
              },

              dataEvents: [{
                type: "change",
                fn: function(event, rowObject) {
                  let originalGridData = $("#tablePelunasan")
                    .jqGrid("getGridParam", "originalData")
                    .find((row) => row.id == rowObject.rowId);
                  let localRow = $("#tablePelunasan").jqGrid(
                    "getLocalRow",
                    rowObject.rowId
                  );
                  localRow.statusnotadebet = event.target.value;
                },
              }, ],
            },
            formatter: function(cellValue, options, rowData) {
              if (typeof cellValue === 'undefined' || cellValue === '' || cellValue == 0) {
                return '';
              }
              return statusDebet[cellValue];
            },
            unformat: function(cellValue, options, cell) {
              if (typeof cellValue === 'undefined' || cellValue === '' || cellValue == 0) {
                return '';
              }
              return cellValue;
            },
            sortable: false,
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
        // onCellSelect: function(rowid, iCol, cellcontent, e) {
        //   console.log("Selected Cell - Row ID: " + rowid + ", Column Index: " + iCol);
        // },
        afterRestoreCell: function(rowId, value, indexRow, indexColumn) {
          let originalGridData = $("#tablePelunasan")
            .jqGrid("getGridParam", "originalData")
            .find((row) => row.id == rowId);

          let localRow = $("#tablePelunasan").jqGrid("getLocalRow", rowId);

          let getBayar = $("#tablePelunasan").jqGrid("getCell", rowId, "bayar")
          let bayar = (getBayar != '') ? parseFloat(getBayar.replaceAll(',', '')) : 0

          let getPotongan = $("#tablePelunasan").jqGrid("getCell", rowId, "potongan")
          let potongan = (getPotongan != '') ? parseFloat(getPotongan.replaceAll(',', '')) : 0

          let getPotonganPPH = $("#tablePelunasan").jqGrid("getCell", rowId, "potonganpph")
          let potonganPPH = (getPotonganPPH != '') ? parseFloat(getPotonganPPH.replaceAll(',', '')) : 0

          sisa = 0
          if ($('#crudForm').data('action') == 'edit') {

            sisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.bayar) + parseFloat(originalGridData.potongan) + parseFloat(originalGridData.potonganpph)) - bayar - potonganPPH - potongan
            // sisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.bayar)) - bayar - potongan - potonganPPH
          } else {
            sisa = originalGridData.sisa - bayar - potongan - potonganPPH
          }

          // console.log('sisa', originalGridData.sisa)
          // console.log('bayar', bayar)
          // console.log('potongan', potongan)
          // console.log(originalGridData.sisa - bayar - potongan)
          console.log('indexc', indexColumn)
          if (indexColumn == 9 || indexColumn == 10 || indexColumn == 12) {
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
          setTotalPotonganPph()
          setTotalLebihBayar()
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
                initAutoNumeric($(this).find(`td[aria-describedby="tablePelunasan_bayar"]`))
                initAutoNumeric($(this).find(`td[aria-describedby="tablePelunasan_potongan"]`))
                initAutoNumeric($(this).find(`td[aria-describedby="tablePelunasan_potonganpph"]`))
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
          console.log(iCol)
          let originalGridData = $("#tablePelunasan")
            .jqGrid("getGridParam", "originalData")
            .find((row) => row.id == rowId);

          getBayar = (localRow.bayar == undefined || localRow.bayar == '') ? 0 : localRow.bayar;
          bayar = (isNaN(getBayar)) ? parseFloat(getBayar.replaceAll(',', '')) : getBayar
          getPotongan = (localRow.potongan == undefined || localRow.potongan == '') ? 0 : localRow.potongan;
          potongan = (isNaN(getPotongan)) ? parseFloat(getPotongan.replaceAll(',', '')) : getPotongan
          getPotonganPPH = (localRow.potonganpph == undefined || localRow.potonganpph == '') ? 0 : localRow.potonganpph;
          potonganPPH = (isNaN(getPotonganPPH)) ? parseFloat(getPotonganPPH.replaceAll(',', '')) : getPotonganPPH
          let totalSisa
          if (iCol == 10 || iCol == 9 || iCol == 12) {

            if ($('#crudForm').data('action') == 'edit') {
              if (iCol == 10) {
                totalSisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.bayar) + parseFloat(originalGridData.potongan) + parseFloat(originalGridData.potonganpph)) - bayar - potonganPPH
                localRow.potongan = 0
              }
              if (iCol == 9) {
                totalSisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.bayar) + parseFloat(originalGridData.potongan) + parseFloat(originalGridData.potonganpph)) - potongan - potonganPPH
                localRow.bayar = 0
              }
              if (iCol == 12) {
                totalSisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.bayar) + parseFloat(originalGridData.potongan) + parseFloat(originalGridData.potonganpph)) - bayar - potongan
                localRow.potonganpph = 0
              }

            } else {
              if (iCol == 10) {
                totalSisa = parseFloat(originalGridData.sisa) - bayar - potonganPPH
                localRow.potongan = 0
              }

              if (iCol == 9) {
                totalSisa = parseFloat(originalGridData.sisa) - potongan - potonganPPH
                localRow.bayar = 0
              }
              if (iCol == 12) {
                totalSisa = parseFloat(originalGridData.sisa) - bayar - potongan
                localRow.potonganpph = 0
              }
            }
            console.log(totalSisa)
            $("#tablePelunasan").jqGrid(
              "setCell",
              rowId,
              "sisa",
              totalSisa
            );

            setTotalSisa()
            setTotalBayar()
            setTotalPotongan()
            setTotalPotonganPph()
          }
          if (iCol == 13) {
            localRow.nominallebihbayar = 0
            setTotalLebihBayar()
          }
          return true;
        },
      });

    loadClearFilter($('#tablePelunasan'))

  }

  $(document).on('click', '#resetdatafilter_tablePelunasan', function(event) {
    selectedRowsPinjaman = $("#tablePelunasan").getGridParam("selectedRowIds");
    $.each(selectedRowsPinjaman, function(index, value) {
      $('#tablePelunasan').jqGrid('saveCell', value, 16); //emptycell
      $('#tablePelunasan').jqGrid('saveCell', value, 6); //nominal
      $('#tablePelunasan').jqGrid('saveCell', value, 7); //sisa
      $('#tablePelunasan').jqGrid('saveCell', value, 8); //keterangan
      $('#tablePelunasan').jqGrid('saveCell', value, 9); //bayar
      $('#tablePelunasan').jqGrid('saveCell', value, 10); //potongan
      $('#tablePelunasan').jqGrid('saveCell', value, 11); //keteranganpotongan
      $('#tablePelunasan').jqGrid('saveCell', value, 12); //potonganpph
      $('#tablePelunasan').jqGrid('saveCell', value, 13); //keteranganpotonganpph
      $('#tablePelunasan').jqGrid('saveCell', value, 14); //nominallebihbayar
      $('#tablePelunasan').jqGrid('saveCell', value, 15); //statusnotadebet
    })
  })

  $(document).on('click', '#gbox_tablePelunasan .ui-jqgrid-hbox .ui-jqgrid-htable thead .ui-search-toolbar th td a.clearsearchclass', function(event) {
    selectedRowsPelunasan = $("#tablePelunasan").getGridParam("selectedRowIds");
    $.each(selectedRowsPelunasan, function(index, value) {
      $('#tablePelunasan').jqGrid('saveCell', value, 16); //emptycell
      $('#tablePelunasan').jqGrid('saveCell', value, 6); //nominal
      $('#tablePelunasan').jqGrid('saveCell', value, 7); //sisa
      $('#tablePelunasan').jqGrid('saveCell', value, 8); //keterangan
      $('#tablePelunasan').jqGrid('saveCell', value, 9); //bayar
      $('#tablePelunasan').jqGrid('saveCell', value, 10); //potongan
      $('#tablePelunasan').jqGrid('saveCell', value, 11); //keteranganpotongan
      $('#tablePelunasan').jqGrid('saveCell', value, 12); //potonganpph
      $('#tablePelunasan').jqGrid('saveCell', value, 13); //keteranganpotonganpph
      $('#tablePelunasan').jqGrid('saveCell', value, 14); //nominallebihbayar
      $('#tablePelunasan').jqGrid('saveCell', value, 15); //statusnotadebet

    })
  })

  function getDataPelunasan(agenId, id, pilihan) {
    aksi = $('#crudForm').data('action')
    if (aksi == 'edit') {
      console.log(id)
      if (id != undefined) {
        url = `${apiUrl}pelunasanpiutangheader/${id}/${agenId}/${pilihan}/getPelunasanPiutang`
      } else {
        url = `${apiUrl}pelunasanpiutangheader/${agenId}/${pilihan}/getpiutang`
      }
    } else if (aksi == 'delete' || aksi == 'view') {
      url = `${apiUrl}pelunasanpiutangheader/${id}/${agenId}/${pilihan}/getDeletePelunasanPiutang`
      attribut = 'disabled'
      forCheckbox = 'disabled'
    } else if (aksi == 'add') {
      url = `${apiUrl}pelunasanpiutangheader/${agenId}/${pilihan}/getpiutang`
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

  function checkboxHandlerPelunasan(element, rowId) {

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
          sisa = (parseFloat(originalGridData.sisa) + parseFloat(originalGridData.bayar) + parseFloat(originalGridData.potongan))
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
        $("#tablePelunasan").jqGrid("setCell", rowId, "bayar", localRow.bayar);
        $("#tablePelunasan").jqGrid("setCell", rowId, "potongan", 0);
        $("#tablePelunasan").jqGrid("setCell", rowId, "nominallebihbayar", 0);

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
    selectedRows = $("#tablePelunasan").getGridParam("selectedRowIds");
    $.each(selectedRows, function(index, value) {
      dataPelunasan = $("#tablePelunasan").jqGrid("getLocalRow", value);
      lunas_nominal = (dataPelunasan.bayar == undefined || dataPelunasan.bayar == '') ? 0 : dataPelunasan.bayar;
      bayars = (isNaN(lunas_nominal)) ? parseFloat(lunas_nominal.replaceAll(',', '')) : parseFloat(lunas_nominal)
      bayar = bayar + bayars
    })
    // $.each(bayarDetails, (index, bayarDetail) => {
    //   bayardetail = parseFloat($(bayarDetail).text().replaceAll(',', ''))
    //   bayars = (isNaN(bayardetail)) ? 0 : bayardetail;
    //   bayar += bayars
    // });
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePelunasan_bayar"]`).text(bayar))
  }

  function setTotalPotongan() {
    let potonganDetails = $(`#tablePelunasan`).find(`td[aria-describedby="tablePelunasan_potongan"]`)
    let potongan = 0
    selectedRows = $("#tablePelunasan").getGridParam("selectedRowIds");
    $.each(selectedRows, function(index, value) {
      dataPelunasan = $("#tablePelunasan").jqGrid("getLocalRow", value);
      lunas_potongan = (dataPelunasan.potongan == undefined || dataPelunasan.potongan == '') ? 0 : dataPelunasan.potongan;
      potongans = (isNaN(lunas_potongan)) ? parseFloat(lunas_potongan.replaceAll(',', '')) : parseFloat(lunas_potongan)
      potongan = potongan + potongans
    })
    // $.each(potonganDetails, (index, potonganDetail) => {
    //   potongandetail = parseFloat($(potonganDetail).text().replaceAll(',', ''))
    //   potongans = (isNaN(potongandetail)) ? 0 : potongandetail;
    //   potongan += potongans
    // });
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePelunasan_potongan"]`).text(potongan))
  }

  function setTotalPotonganPph() {
    let potonganDetails = $(`#tablePelunasan`).find(`td[aria-describedby="tablePelunasan_potonganpph"]`)
    let potonganpph = 0
    selectedRows = $("#tablePelunasan").getGridParam("selectedRowIds");
    $.each(selectedRows, function(index, value) {
      dataPelunasan = $("#tablePelunasan").jqGrid("getLocalRow", value);
      lunas_potonganpph = (dataPelunasan.potonganpph == undefined || dataPelunasan.potonganpph == '') ? 0 : dataPelunasan.potonganpph;
      potonganpphs = (isNaN(lunas_potonganpph)) ? parseFloat(lunas_potonganpph.replaceAll(',', '')) : parseFloat(lunas_potonganpph)
      potonganpph = potonganpph + potonganpphs
    })
    // $.each(potonganDetails, (index, potonganDetail) => {
    //   potongandetail = parseFloat($(potonganDetail).text().replaceAll(',', ''))
    //   potongans = (isNaN(potongandetail)) ? 0 : potongandetail;
    //   potongan += potongans
    // });
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePelunasan_potonganpph"]`).text(potonganpph))
  }

  function setTotalLebihBayar() {
    let lebihBayarDetails = $(`#tablePelunasan`).find(`td[aria-describedby="tablePelunasan_nominallebihbayar"]`)
    let lebihBayar = 0
    selectedRows = $("#tablePelunasan").getGridParam("selectedRowIds");
    $.each(selectedRows, function(index, value) {
      dataPelunasan = $("#tablePelunasan").jqGrid("getLocalRow", value);
      lunas_lebih = (dataPelunasan.nominallebihbayar == undefined || dataPelunasan.nominallebihbayar == '') ? 0 : dataPelunasan.nominallebihbayar;
      lebihBayars = (isNaN(lunas_lebih)) ? parseFloat(lunas_lebih.replaceAll(',', '')) : parseFloat(lunas_lebih)
      lebihBayar = lebihBayar + lebihBayars
    })
    // $.each(lebihBayarDetails, (index, lebihBayarDetail) => {
    //   lebihbayardetail = parseFloat($(lebihBayarDetail).text().replaceAll(',', ''))
    //   lebihBayars = (isNaN(lebihbayardetail)) ? 0 : lebihbayardetail;
    //   lebihBayar += lebihBayars
    // });
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePelunasan_nominallebihbayar"]`).text(lebihBayar))
  }

  function setTotalNominal() {
    let nominalDetails = $(`#tablePelunasan`).find(`td[aria-describedby="tablePelunasan_nominal"]`)
    let nominal = 0
    let originalData = $("#tablePelunasan").getGridParam("data");
    $.each(originalData, function(index, value) {
      lunas_nominal = value.nominal;
      nominals = (isNaN(lunas_nominal)) ? parseFloat(lunas_nominal.replaceAll(',', '')) : parseFloat(lunas_nominal)
      nominal += nominals

    })
    // $.each(nominalDetails, (index, nominalDetail) => {
    //   nominaldetail = parseFloat($(nominalDetail).text().replaceAll(',', ''))
    //   nominals = (isNaN(nominaldetail)) ? 0 : nominaldetail;
    //   nominal += nominals
    // });
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePelunasan_nominal"]`).text(nominal))
  }

  function setTotalSisa() {
    let sisaDetails = $(`#tablePelunasan`).find(`td[aria-describedby="tablePelunasan_sisa"]`)
    let sisa = 0
    let originalData = $("#tablePelunasan").getGridParam("data");
    $.each(originalData, function(index, value) {
      lunas_sisa = value.sisa;
      sisas = (isNaN(lunas_sisa)) ? parseFloat(lunas_sisa.replaceAll(',', '')) : parseFloat(lunas_sisa)
      sisa += sisas

    })
    // $.each(sisaDetails, (index, sisaDetail) => {
    //   sisadetail = parseFloat($(sisaDetail).text().replaceAll(',', ''))
    //   sisas = (isNaN(sisadetail)) ? 0 : sisadetail;
    //   sisa += sisas
    // });
    initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePelunasan_sisa"]`).text(sisa))
  }

  function editPelunasanPiutangHeader(Id) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    $('#crudModalTitle').text('Edit Pelunasan Piutang')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    setStatusNotaDebetOptions()
    setStatusNotaKreditOptions()
    Promise
      .all([
        setTglBukti(form),
        setStatusPelunasanOptions(form),
      ]).then(() => {

        showPelunasanPiutang(form, Id).then(() => {

            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            if (accessCabang == 'BTG-EMKL') {
              $('.agen').hide()
              $('.pelanggan').show()
            } else {
              $('.agen').show()
              $('.pelanggan').hide()
            }
            enableTglJatuhTempo(form)
            enableNoWarkat(form)
            $('#crudModal').modal('show')
            if (isEditTgl == 'TIDAK') {
              form.find(`[name="tglbukti"]`).prop('readonly', true)
              form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
            }
            form.find(`[name="agen"]`).parent('.input-group').find('.button-clear').remove()
            form.find(`[name="agen"]`).parent('.input-group').find('.input-group-append').remove()
            form.find(`[name="pelanggan"]`).parent('.input-group').find('.button-clear').remove()
            form.find(`[name="pelanggan"]`).parent('.input-group').find('.input-group-append').remove()
            form.find(`[name="bank"]`).parent('.input-group').find('.button-clear').remove()
            form.find(`[name="bank"]`).parent('.input-group').find('.input-group-append').remove()
            form.find(`[name="alatbayar"]`).parent('.input-group').find('.button-clear').remove()
            form.find(`[name="alatbayar"]`).parent('.input-group').find('.input-group-append').remove()
          })
          .catch((error) => {
            showDialog(error.responseJSON)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })

  }

  function deletePelunasanPiutangHeader(Id) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')
    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-trash"></i>
    Delete
  `)
    $('#crudModalTitle').text('Delete Pelunasan Piutang')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    setStatusNotaDebetOptions()
    setStatusNotaKreditOptions()
    Promise
      .all([
        setStatusPelunasanOptions(form),
      ])
      .then(() => {

        showPelunasanPiutang(form, Id).then(() => {
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }

            if (accessCabang == 'BTG-EMKL') {
              $('.agen').hide()
              $('.pelanggan').show()
            } else {
              $('.agen').show()
              $('.pelanggan').hide()
            }
            enableTglJatuhTempo(form)
            enableNoWarkat(form)
            $('#crudModal').modal('show')
            form.find(`[name="agen"]`).parent('.input-group').find('.button-clear').remove()
            form.find(`[name="agen"]`).parent('.input-group').find('.input-group-append').remove()
            form.find(`[name="pelanggan"]`).parent('.input-group').find('.button-clear').remove()
            form.find(`[name="pelanggan"]`).parent('.input-group').find('.input-group-append').remove()
            form.find(`[name="bank"]`).parent('.input-group').find('.button-clear').remove()
            form.find(`[name="bank"]`).parent('.input-group').find('.input-group-append').remove()
            form.find(`[name="alatbayar"]`).parent('.input-group').find('.button-clear').remove()
            form.find(`[name="alatbayar"]`).parent('.input-group').find('.input-group-append').remove()
          })
          .catch((error) => {
            showDialog(error.responseJSON)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  function viewPelunasanPiutang(Id) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'view')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.find('#btnSubmit').prop('disabled', true)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('View Pelunasan Piutang')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    setStatusNotaDebetOptions()
    setStatusNotaKreditOptions()

    Promise
      .all([
        setStatusPelunasanOptions(form),
      ])
      .then(() => {

        showPelunasanPiutang(form, Id)
          .then(id => {
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
            if (accessCabang == 'BTG-EMKL') {
              $('.agen').hide()
              $('.pelanggan').show()
            } else {
              $('.agen').show()
              $('.pelanggan').hide()
            }
            enableTglJatuhTempo(form)
            enableNoWarkat(form)
            $('#crudModal').modal('show')
            form.find('[name=tglbukti]').attr('readonly', true)
            form.find('[name=tglbukti]').siblings('.input-group-append').remove()

            let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
            let nameFind = $('#crudForm').find(`[name]`).parents('.input-group')
            name.attr('disabled', true)
            name.find('.lookup-toggler').remove()
            nameFind.find('button.button-clear').remove()
          })
          .catch((error) => {
            showDialog(error.responseJSON)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  function showPelunasanPiutang(form, Id) {
    return new Promise((resolve, reject) => {
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
            // console.log(response.data.bank_id)
            // console.log(response.data.agen_id)

            agenId = response.data.agen_id
            let element = form.find(`[name="${index}"]`)

            form.find(`[name="${index}"]:not([name="tglbukti"])`).val(value).attr('readonly', true)

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
            }
            if (index == 'pelanggan') {
              element.data('current-value', value).prop('readonly', true)
            }
            // form.find(`[name="${index}"]:not([name="tglbukti"])`).addClass('disabled')
            if (form.data('action') === 'delete') {
              form.find('[name]').addClass('disabled')
              initDisabled()
            }

          })
          let agenId_ = '';
          let pilihan = '';
          if (response.data.agen_id != 0) {
            agenId_ = response.data.agen_id
            pilihan = 'agen'
          } else {
            agenId_ = response.data.pelanggan_id
            pilihan = 'pelanggan'
          }
          loadPelunasanGrid();

          getDataPelunasan(agenId_, Id, pilihan).then((response) => {

            let selectedId = []
            let totalBayar = 0
            let totalPotongan = 0
            let totalPotonganPph = 0
            let totalNominalLebih = 0
            console.log(response.data)
            $.each(response.data, (index, value) => {
              if (value.pelunasanpiutang_id != null) {
                selectedId.push(value.id)
                totalBayar += parseFloat(value.bayar)
                totalPotongan += parseFloat(value.potongan)
                totalPotonganPph += parseFloat(value.potonganpph)
                totalNominalLebih += parseFloat(value.nominallebihbayar)
              }
            })

            setTimeout(() => {

              $("#tablePelunasan")
                .jqGrid("setGridParam", {
                  datatype: "local",
                  data: response.data,
                  originalData: response.data,
                  rowNum: response.data.length,
                  selectedRowIds: selectedId
                })
                .trigger("reloadGrid");
            }, 100);

            initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePelunasan_bayar"]`).text(totalBayar))
            initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePelunasan_potongan"]`).text(totalPotongan))
            initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePelunasan_potonganpph"]`).text(totalPotonganPph))
            initAutoNumeric($('.footrow').find(`td[aria-describedby="tablePelunasan_nominallebihbayar"]`).text(totalNominalLebih))
          });
          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

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

          $('.coapotongan-lookup').last().lookup({
            title: 'Coa Potongan Lookup',
            fileName: 'akunpusat',
            beforeProcess: function(test) {
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

            initAutoNumeric(detailRow.find(`[name="bayarppd[]"]`).not(':disabled'))
            initAutoNumeric(detailRow.find(`[name="potonganppd[]"]`).not(':disabled'))
            initAutoNumeric(detailRow.find(`[name="nominallebihbayarppd[]"]`).not(':disabled'))
          }
          if (aksi == 'delete') {

            initAutoNumeric(detailRow.find(`[name="bayarppd[]"]`))
            initAutoNumeric(detailRow.find(`[name="potonganppd[]"]`))
            initAutoNumeric(detailRow.find(`[name="nominallebihbayarppd[]"]`))

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
          showDialog(error.responseJSON)
        }
      })
    }
  }



  function showDefault(form) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}pelunasanpiutangheader/default`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          bankId = response.data.bank_id
          agenId = response.data.agen_id

          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)
            // let element = form.find(`[name="statusaktif"]`)

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

    $('.bank-lookup').lookup({
      title: 'Bank Lookup',
      fileName: 'bank',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          withPusat: 0
        }
      },
      onSelectRow: (bank, element) => {

        bankId = bank.id
        $('#crudForm [name=bank_id]').first().val(bank.id)
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
        enableTglJatuhTempo($(`#crudForm`))
        enableNoWarkat($(`#crudForm`))

        setTOP()
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

    $('.notadebet-lookup').lookup({
      title: 'nota debet Lookup',
      fileName: 'notadebetheader',
      beforeProcess: function(test) {
        // const bank_ID=0        
        this.postData = {
          bank_Id: bankId,
          Aktif: 'AKTIF',
          Panjar: 'PANJAR',
          agen_Id: agenId,

        }
      },
      onSelectRow: (alatbayar, element) => {
        element.val(alatbayar.nobukti)
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

    $('.agen-lookup').lookup({
      title: 'Customer Lookup',
      fileName: 'agen',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',

        }
      },
      onSelectRow: (agen, element) => {
        $('#crudForm [name=agen_id]').first().val(agen.id)
        agenId = agen.id
        element.val(agen.namaagen)
        topAgen = agen.top
        setTOP()
        // getPiutang(agen.id)
        $('#btnSubmit').prop('disabled', true)
        $('#btnSaveAdd').prop('disabled', true)
        $('#tablePelunasan').jqGrid("clearGridData");
        $("#tablePelunasan")
          .jqGrid("setGridParam", {
            selectedRowIds: []
          })
          .trigger("reloadGrid");

        setTotalBayar()
        setTotalPotongan()
        setTotalLebihBayar()
        setTotalNominal()
        setTotalSisa()

        getDataPelunasan(agen.id, '', 'agen').then((response) => {

          $("#tablePelunasan")[0].p.selectedRowIds = [];
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
            $('#btnSubmit').prop('disabled', false)
            $('#btnSaveAdd').prop('disabled', false)
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

        topAgen = 0
        console.log('onclear', $("#tablePelunasan").jqGrid('getGridParam', 'selectedRowIds'))
        // setTimeout(() => {
        $("#tablePelunasan")[0].p.selectedRowIds = [];
        $('#tablePelunasan').jqGrid("clearGridData");
        // }, 100);
        $('.footrow').find(`td[aria-describedby="tablePelunasan_sisa"]`).text('')
        $('.footrow').find(`td[aria-describedby="tablePelunasan_nominal"]`).text('')
        $('.footrow').find(`td[aria-describedby="tablePelunasan_bayar"]`).text('')
        $('.footrow').find(`td[aria-describedby="tablePelunasan_potongan"]`).text('')
        $('.footrow').find(`td[aria-describedby="tablePelunasan_nominallebihbayar"]`).text('')

        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.pelanggan-lookup').lookup({
      title: 'Pelanggan Lookup',
      fileName: 'pelanggan',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',

        }
      },
      onSelectRow: (pelanggan, element) => {
        $('#crudForm [name=pelanggan_id]').first().val(pelanggan.id)
        pelangganId = pelanggan.id
        element.val(pelanggan.namapelanggan)
        // getPiutang(pelanggan.id)
        $('#btnSubmit').prop('disabled', true)
        $('#btnSaveAdd').prop('disabled', true)
        $('#tablePelunasan').jqGrid("clearGridData");
        $("#tablePelunasan")
          .jqGrid("setGridParam", {
            selectedRowIds: []
          })
          .trigger("reloadGrid");

        setTotalBayar()
        setTotalPotongan()
        setTotalLebihBayar()
        setTotalNominal()
        setTotalSisa()

        getDataPelunasan(pelanggan.id, '', 'pelanggan').then((response) => {

          $("#tablePelunasan")[0].p.selectedRowIds = [];
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
            $('#btnSubmit').prop('disabled', false)
            $('#btnSaveAdd').prop('disabled', false)
          }, 100);

        });
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=pelanggan_id]').first().val('')
        // $("#tablePelunasan")
        //   .jqGrid("setGridParam", {
        //     selectedRowIds: []
        //   })
        //   .trigger("reloadGrid");

        console.log('onclear', $("#tablePelunasan").jqGrid('getGridParam', 'selectedRowIds'))
        // setTimeout(() => {
        $("#tablePelunasan")[0].p.selectedRowIds = [];
        $('#tablePelunasan').jqGrid("clearGridData");
        // }, 100);
        $('.footrow').find(`td[aria-describedby="tablePelunasan_sisa"]`).text('')
        $('.footrow').find(`td[aria-describedby="tablePelunasan_nominal"]`).text('')
        $('.footrow').find(`td[aria-describedby="tablePelunasan_bayar"]`).text('')
        $('.footrow').find(`td[aria-describedby="tablePelunasan_potongan"]`).text('')
        $('.footrow').find(`td[aria-describedby="tablePelunasan_nominallebihbayar"]`).text('')

        element.val('')
        element.data('currentValue', element.val())
      }
    })
  }

  function cekValidasi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}pelunasanpiutangheader/${Id}/cekvalidasi`,
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
            window.open(`{{ route('pelunasanpiutangheader.report') }}?id=${Id}&printer=reportPrinterBesar`)
          } else if (Aksi == 'PRINTER KECIL') {
            window.open(`{{ route('pelunasanpiutangheader.report') }}?id=${Id}&printer=reportPrinterKecil`)
          } else {
            cekValidasiAksi(Id, Aksi)
          }
        }
      }
    })
  }

  function cekValidasiAksi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}pelunasanpiutangheader/${Id}/cekValidasiAksi`,
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
            editPelunasanPiutangHeader(Id)
          }
          if (Aksi == 'DELETE') {
            deletePelunasanPiutangHeader(Id)
          }
        }

      }
    })
  }

  function setTOP() {
    if ($('#crudForm').find(`[name="alatbayar"]`).val() == 'GIRO') {

      let dateNow = new Date();
      dateNow.setDate(dateNow.getDate() + parseInt(topAgen));
      let end_date = new Date(dateNow.getFullYear(), dateNow.getMonth(), dateNow.getDate());
      formattedDate = end_date.getDate().toString().padStart(2, '0') + '-' + (end_date.getMonth() + 1).toString().padStart(2, '0') + '-' + end_date.getFullYear();

      $('#crudForm').find(`[name="tgljatuhtempo"]`).val(formattedDate).trigger('change');

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
        value: 'PELUNASAN PIUTANG'
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

  const setStatusPelunasanOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statuspelunasan]').empty()
      relatedForm.find('[name=statuspelunasan]').append(
        new Option('-- PILIH STATUS PELUNASAN --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}parameter/combo`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          grp: 'PELUNASAN',
          subgrp: 'PELUNASAN'
        },
        success: response => {
          response.data.forEach(statusPelunasan => {
            let option = new Option(statusPelunasan.text, statusPelunasan.id)

            relatedForm.find('[name=statuspelunasan]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function setStatusNotaDebetOptions() {
    $.ajax({
      url: `${apiUrl}parameter/combo`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        grp: 'TIPENOTADEBET',
        subgrp: 'TIPENOTADEBET'
      },
      success: response => {
        statusDebet[0] = "--PILIH STATUS NOTA DEBET--"
        $.each(response.data, function(index, item) {
          statusDebet[item.id] = item.text;
        });
      },
    })
  }

  function setStatusNotaKreditOptions() {
    $.ajax({
      url: `${apiUrl}parameter/combo`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        grp: 'TIPENOTAKREDIT',
        subgrp: 'TIPENOTAKREDIT',
        sortIndex: 'text',
        sortOrder: 'asc',
      },
      success: response => {
        statusKredit[0] = "--PILIH STATUS NOTA KREDIT--"
        $.each(response.data, function(index, item) {
          statusKredit[item.id] = item.text;
        });
      },
    })
  }

  function getStatusKredit(rowid) {
    let localRow = $("#tablePelunasan").jqGrid("getLocalRow", rowid);
    let jenisinvoice = localRow.jenisinvoice
    let tidakTampil
    let data = statusKredit
    // Melakukan filter berdasarkan nilai (value)
    if (jenisinvoice == "TAMBAHAN") {
      tidakTampil = "POTONGAN PENDAPATAN"
    } else {
      tidakTampil = "POTONGAN PENDAPATAN LAIN"
    }
    var filteredValues = Object.entries(data).filter(function(entry) {

      return entry[1] !== tidakTampil; // Filter semua nilai yang bukan "UANG DIBAYAR DIMUKA"
    });

    // Mengonversi hasil filter kembali ke dalam objek
    var filteredObject = Object.fromEntries(filteredValues);


    return filteredObject;


  }
</script>
@endpush()