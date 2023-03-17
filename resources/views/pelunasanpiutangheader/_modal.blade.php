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
            <div class="row form-group">
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
            <div class="row mt-5">
              <div class="col-md-12">
                <div class="card card-scroll">
                  <div class="card-body">


                    <div class="table-responsive">
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
                    </div>

                  </div>
                </div>
              </div>
            </div>

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


      $('#table_body tr').each(function(row, tr) {


        if ($(this).find(`[name="piutang_id[]"]`).is(':checked')) {

          data.push({
            name: 'sisa[]',
            value: AutoNumeric.getNumber($(`#crudForm [name="sisa[]"]`)[row])
          })
          data.push({
            name: 'keterangandetailppd[]',
            value: $(this).find(`[name="keterangandetailppd[]"]`).val()
          })
          data.push({
            name: 'bayarppd[]',
            value: AutoNumeric.getNumber($(`#crudForm [name="bayarppd[]"]`)[row])
          })
          data.push({
            name: 'keteranganpotonganppd[]',
            value: $(this).find(`[name="keteranganpotonganppd[]"]`).val()
          })
          data.push({
            name: 'potonganppd[]',
            value: AutoNumeric.getNumber($(`#crudForm [name="potonganppd[]"]`)[row])
          })
          data.push({
            name: 'coapotonganppd[]',
            value: $(this).find(`[name="coapotonganppd[]"]`).val()
          })
          data.push({
            name: 'nominallebihbayarppd[]',
            value: AutoNumeric.getNumber($(`#crudForm [name="nominallebihbayarppd[]"]`)[row])
          })
          data.push({
            name: 'piutang_id[]',
            value: $(this).find(`[name="piutang_id[]"]`).val()
          })

        }
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
          url = `${apiUrl}pelunasanpiutangheader/${Id}`
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
          console.log(error)
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            setErrorMessages(form, error.responseJSON.errors);
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

    setTotal()
    setPenyesuaian()
    setNominalLebih()
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
          let element = form.find(`[name="${index}"]`)

          form.find(`[name="${index}"]`).val(value).attr('disabled', false)

          if (element.hasClass('datepicker')) {
            element.val(dateFormat(value))
          }


          if (index == 'bank') {
            element.data('current-value', value)
          }
          if (index == 'agen') {
            element.data('current-value', value)
          }
          if (index != 'agen' && index != 'agen_id') {

            form.find(`[name="${index}"]`).addClass('disabled')
            initDisabled()
          }

        })


        form.find(`[name="agen"]`).prop('disabled', false)
        form.find(`[name="agen_id"]`).prop('disabled', false)
        let agenId = response.data.agen_id
        $('#editpiutang').show()
        // Promise
        // .all([
        //   setCoaPotonganOptions($('#detailList tbody'))
        // ])
        // .then(() => {
        //   getPelunasan(Id, agenId, 'edit')
        // })
        getPelunasan(Id, agenId, 'edit')
      }
    })
  }

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

    $.ajax({
      url: `${apiUrl}pelunasanpiutangheader/${Id}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        $.each(response.data, (index, value) => {
          let element = form.find(`[name="${index}"]`)

          form.find(`[name="${index}"]`).val(value)

          if (element.hasClass('datepicker')) {
            element.val(dateFormat(value))
          }

        })
        let agenId = response.data.agen_id

        form.find('[name]').addClass('disabled')
        initDisabled()
        // $('#gridEditPiutang').trigger('reloadGrid')
        getPelunasan(Id, agenId, 'delete')

      }
    })
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
              <td><input name='piutang_id[]' type="checkbox" id="checkItem" value="${nobukti}"></td>
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
              <td id=${nobukti}>
                <input type="text" name="bayarppd[]" disabled class="form-control bayar text-right">
              </td>
              <td id="potongan${nobukti}">
                <input type="text" name="potonganppd[]" disabled class="form-control text-right">
              </td>
              <td>
                  <input type="text" name="coapotonganppd[]" disabled class="form-control coapotongan-lookup">
              </td>
              <td>
                <textarea name="keteranganpotonganppd[]" rows="1" disabled class="form-control"></textarea>
              </td>
              <td id="lebih${nobukti}">
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
          } else {
            attribut = 'disabled'
          }

          let detailRow = $(`
            <tr>
              <td><input name='piutang_id[]' type="checkbox" class="checkItem" value="${nobukti}" ${checked} ${forCheckbox}></td>
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
              <td id=${nobukti}>
                <input type="text" name="bayarppd[]" class="form-control bayar text-right" value="${detail.nominal || ''}" ${attribut}>
              </td>
              <td id="potongan${nobukti}">
                <input type="text" name="potonganppd[]" class="form-control text-right" value="${detail.potongan || ''}" ${attribut}>
              </td>
              <td>
                <input type="text" name="coapotonganppd[]" class="form-control coapotongan-lookup" data-current-value="${detail.coapotongan}" ${attribut}>
              </td>
              <td>
                <textarea name="keteranganpotonganppd[]" rows="1" class="form-control" ${attribut}>${detail.keteranganpotongan || ''}</textarea>
              </td>
              <td id="lebih${nobukti}">
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
      let nobukti = $(this).val()
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

      $(this).closest('tr').find(`#${nobukti}`).append(newBayarElement)
      $(this).closest('tr').find(`#potongan${nobukti}`).append(newPotonganElement)
      $(this).closest('tr').find(`#lebih${nobukti}`).append(newLebihElement)

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
        getPiutang(agen.id)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=agen_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
  }
</script>
@endpush()