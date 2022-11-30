<div class="modal fade modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="crudForm">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title" id="crudModalTitle"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" method="post">

          <div class="modal-body">
            <input type="hidden" name="id">

            <div class="row form-group">
              <div class="col-12 col-sm-2 col-md-2 col-form-label">
                <label>
                  NO BUKTI <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-4 col-md-4">
                <input type="text" name="nobukti" class="form-control" readonly>
              </div>

              <div class="col-12 col-sm-2 col-md-2 col-form-label">
                <label>
                  TANGGAL BUKTI <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-4 col-md-4">
                <input type="text" name="tglbukti" class="form-control datepicker">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  KETERANGAN <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="keterangan" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  BANK <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-8 col-md-10">
                <input type="hidden" name="bank_id">
                <input type="text" name="bank" class="form-control bank-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  AGEN <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-8 col-md-10">
                <input type="hidden" name="agen_id">
                <input type="text" name="agen" class="form-control agen-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  CABANG <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-8 col-md-10">
                <input type="hidden" name="cabang_id">
                <input type="text" name="cabang" class="form-control cabang-lookup">
              </div>
            </div>

            <div class="row mt-5">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <div class="row form-group">
                      <div class="col-md-2">
                        <label>
                          PELANGGAN <span class="text-danger">*</span>
                        </label>
                      </div>
                      <div class="col-md-4">
                        <input type="hidden" name="pelanggan_id" class="form-control">
                        <input type="text" name="pelanggan" class="form-control pelanggan-lookup">
                      </div>

                      <div class="col-md-1 offset-md-1">
                        <label>
                          AGEN <span class="text-danger">*</span>
                        </label>
                      </div>
                      <div class="col-md-4">
                        <input type="hidden" name="agendetail_id" class="form-control">
                        <input type="text" name="agendetail" class="form-control agendetail-lookup">
                      </div>
                    </div>

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
                            <th width="5%">KETERANGAN</th>
                            <th width="6%">BAYAR</th>
                            <th width="5%">KETERANGAN PENYESUAIAN</th>
                            <th width="6%">PENYESUAIAN</th>
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
                            <td></td>
                            <td>
                              <p id="bayarPenyesuaian" class="text-right font-weight-bold"></p>
                            </td>
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

  $(document).ready(function() {

    $(document).on('input', `#table_body [name="bayarppd[]"]`, function(event) {
      setTotal()
      let sisa = AutoNumeric.getNumber($(this).closest("tr").find(`[name="sisa[]"]`)[0])

      let bayar = $(this).val()
      bayar = parseFloat(bayar.replaceAll(',', ''));
      bayar = Number.isNaN(bayar) ? 0 : bayar
      if (sisa == 0) {
        let nominal = $(this).closest("tr").find(`[name="nominal[]"]`).val()
        nominal = parseFloat(nominal.replaceAll(',', ''));
        let totalSisa = nominal - bayar
        console.log(totalSisa)
        $(this).closest("tr").find(".sisa").html(totalSisa)
      } else {
        let totalSisa = sisa - bayar
        $(this).closest("tr").find(".sisa").html(totalSisa)
      }


      initAutoNumeric($(this).closest("tr").find(".sisa"))

      let Sisa = $(`#table_body .sisa`)
      let total = 0

      $.each(Sisa, (index, SISA) => {
        total += AutoNumeric.getNumber(SISA)
      });

      new AutoNumeric('#sisaPiutang').set(total)
    })

    $(document).on('input', `#table_body [name="penyesuaianppd[]"]`, function(event) {
      setPenyesuaian()
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
        name: 'keterangan',
        value: form.find(`[name="keterangan"]`).val()
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
        name: 'agen',
        value: form.find(`[name="agen"]`).val()
      })
      data.push({
        name: 'agen_id',
        value: form.find(`[name="agen_id"]`).val()
      })
      data.push({
        name: 'cabang',
        value: form.find(`[name="cabang"]`).val()
      })
      data.push({
        name: 'cabang_id',
        value: form.find(`[name="cabang_id"]`).val()
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
        name: 'agendetail',
        value: form.find(`[name="agendetail"]`).val()
      })
      data.push({
        name: 'agendetail_id',
        value: form.find(`[name="agendetail_id"]`).val()
      })


      $('#table_body tr').each(function(row, tr) {
        // console.log(row);

        if ($(this).find(`[name="piutang_id[]"]`).is(':checked')) {

          data.push({
            name: 'keterangandetailppd[]',
            value: $(this).find(`[name="keterangandetailppd[]"]`).val()
          })
          data.push({
            name: 'bayarppd[]',
            value: AutoNumeric.getNumber($(`#crudForm [name="bayarppd[]"]`)[row])
          })
          data.push({
            name: 'keteranganpenyesuaianppd[]',
            value: $(this).find(`[name="keteranganpenyesuaianppd[]"]`).val()
          })
          data.push({
            name: 'penyesuaianppd[]',
            value: AutoNumeric.getNumber($(`#crudForm [name="penyesuaianppd[]"]`)[row])
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
      // console.log(typeof(data))

      // console.log(detailData);

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

      console.log(data);

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
            setErrorMessages(form, error.responseJSON.errors);
            showDialog(error.responseJSON.message)
          } else {
            showDialog(error.responseJSON.message)
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
    let penyesuaian = $(`#table_body [name="penyesuaianppd[]"]:not([disabled])`)
    let totalPenyesuaian = 0

    $.each(penyesuaian, (index, penyesuaian) => {
      totalPenyesuaian += AutoNumeric.getNumber(penyesuaian)
    });

    new AutoNumeric('#bayarPenyesuaian').set(totalPenyesuaian)
  }

  function setNominalLebih() {
    let nominalLebih = $(`#table_body [name="nominallebihbayarppd[]"]:not([disabled])`)
    let totalNominalLebih = 0

    $.each(nominalLebih, (index, nominalLebih) => {
      totalNominalLebih += AutoNumeric.getNumber(nominalLebih)
    });

    new AutoNumeric('#bayarNominalLebih').set(totalNominalLebih)
  }


  $(document).on('click', `#detailList tbody [name="piutang_id[]"]`, function() {

    if ($(this).prop("checked") == true) {

      id = $(this).val()
      $(this).closest('tr').find(`td [name="keterangandetailppd[]"]`).prop('disabled', false)
      $(this).closest('tr').find(`td [name="nominallebihbayarppd[]"]`).prop('disabled', false)
      $(this).closest('tr').find(`td [name="bayarppd[]"]`).prop('disabled', false)
      $(this).closest('tr').find(`td [name="keteranganpenyesuaianppd[]"]`).prop('disabled', false)
      $(this).closest('tr').find(`td [name="penyesuaianppd[]"]`).prop('disabled', false)
      $(this).closest('tr').find(`td [name="nominallebihbayarppd[]"]`).prop('disabled', false)

      setTotal()
      setPenyesuaian()
      setNominalLebih()
      
    } else {
      $(this).closest('tr').find(`td [name="keterangandetailppd[]"]`).prop('disabled', true)
      $(this).closest('tr').find(`td [name="nominallebihbayarppd[]"]`).prop('disabled', true)
      $(this).closest('tr').find(`td [name="bayarppd[]"]`).prop('disabled', true)
      $(this).closest('tr').find(`td [name="keteranganpenyesuaianppd[]"]`).prop('disabled', true)
      $(this).closest('tr').find(`td [name="penyesuaianppd[]"]`).prop('disabled', true)
      $(this).closest('tr').find(`td [name="nominallebihbayarppd[]"]`).prop('disabled', true)

      setTotal()
      setPenyesuaian()
      setNominalLebih()
    }
  })

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
          if (index == 'cabang') {
            element.data('current-value', value)
          }
        })


        $.each(response.detail, (index, value) => {
          form.find(`[name="${index}"]`).val(value).attr('disabled', false)

          if (index == 'pelanggan') {
            form.find(`[name="${index}"]`).data('current-value', value)
          }
          if (index == 'agendetail') {
            form.find(`[name="${index}"]`).data('current-value', value)
          }
        })

        let agenId = response.detail.agendetail_id
        $('#editpiutang').show()

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
        $.each(response.detail, (index, value) => {
          form.find(`[name="${index}"]`).val(value)
        })
        let agenId = response.detail.agendetail_id

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
          totalNominal = parseFloat(totalNominal) + parseFloat(detail.nominal)
          totalSisa = totalSisa + parseFloat(detail.sisa);
          let nominal = new Intl.NumberFormat('en-US').format(detail.nominal);
          let sisa = new Intl.NumberFormat('en-US').format(detail.sisa);

          let detailRow = $(`
            <tr >
              <td><input name='piutang_id[]' type="checkbox" id="checkItem" value="${id}"></td>
              <td></td>
              <td>${detail.nobukti}</td>
              <td>${detail.tglbukti}</td>
              <td>${detail.invoice_nobukti}</td>
              <td>
                <p class="text-right">${nominal}</p>
                <input type="hidden" name="nominal[]" class="autonumeric" value="${nominal}"></td>
              <td>
                <p class="text-right sisa autonumeric">${sisa}</p>
                <input type="hidden" name="sisa[]" class="autonumeric" value="${sisa}">
              </td>
              <td>
                <textarea name="keterangandetailppd[]" rows="1" disabled class="form-control"></textarea>
              </td>
              <td>
                <input type="text" name="bayarppd[]" disabled class="form-control bayar autonumeric">
              </td>
              <td>
                <textarea name="keteranganpenyesuaianppd[]" rows="1" disabled class="form-control"></textarea>
              </td>
              <td>
                <input type="text" name="penyesuaianppd[]" disabled class="form-control autonumeric">
              </td>
              <td>
                <input type="text" name="nominallebihbayarppd[]" disabled class="form-control autonumeric">
              </td>
            </tr>
          `)

          // detailRow.find(`[name="keterangan_detail[]"]`).val(detail.keterangan)
          // detailRow.find(`[name="nominal[]"]`).val(detail.nominal)

          initAutoNumericNoMinus(detailRow.find(`[name="bayarppd[]"]`))
          initAutoNumericNoMinus(detailRow.find(`[name="penyesuaianppd[]"]`))
          initAutoNumericNoMinus(detailRow.find(`[name="nominallebihbayarppd[]"]`))
          initAutoNumeric(detailRow.find(`[name="sisa[]"]`))
          initAutoNumeric(detailRow.find('.sisa'))
          initAutoNumeric(detailRow.find('.nominal'))

          $('#detailList tbody').append(detailRow)
          setTotal()
          setPenyesuaian()
          setNominalLebih()

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
          let pelunasanPiutangId = detail.pelunasanpiutang_id
          let checked

          totalNominalPiutang = parseFloat(totalNominalPiutang) + parseFloat(detail.nominalpiutang)
          totalSisa = totalSisa + parseFloat(detail.sisa);
          let nominal = new Intl.NumberFormat('en-US').format(detail.nominalpiutang);
          let sisaHidden = parseFloat(detail.sisa) + parseFloat(detail.nominal)
          let sisa = new Intl.NumberFormat('en-US').format(detail.sisa);

          if (pelunasanPiutangId != null) {
            checked = 'checked'
          } else {
            attribut = 'disabled'
          }

          let detailRow = $(`
            <tr>
              <td><input name='piutang_id[]' type="checkbox" class="checkItem" value="${id}" ${checked} ${forCheckbox}></td>
              <td></td>
              <td>${detail.piutang_nobukti}</td>
              <td>${detail.tglbukti}</td>
              <td>${detail.invoice_nobukti}</td>
              <td>
                <p class="text-right">${nominal}</p>
                <input type="hidden" name="nominal[]" class="autonumeric" value="${nominal}">
              </td>
              <td>
                <p class="sisa text-right">${sisa}</p>
                <input type="hidden" name="sisa[]" class="autonumeric" value="${sisaHidden}">
              </td>
              <td>
                <textarea name="keterangandetailppd[]" rows="1" class="form-control" ${attribut}>${detail.keterangan || ''}</textarea>
              </td>
              <td>
                <input type="text" name="bayarppd[]" class="form-control bayar autonumeric" value="${detail.nominal || ''}" ${attribut}>
              </td>
              <td>
                <textarea name="keteranganpenyesuaianppd[]" rows="1" class="form-control" ${attribut}>${detail.keteranganpenyesuaian || ''}</textarea>
              </td>
              <td>
                <input type="text" name="penyesuaianppd[]" class="form-control autonumeric" value="${detail.penyesuaian || ''}" ${attribut}>
              </td>
              <td>
                <input type="text" name="nominallebihbayarppd[]" class="form-control autonumeric" value="${detail.nominallebihbayar || ''}" ${attribut}>
              </td>
            </tr>
          `)

          initAutoNumericNoMinus(detailRow.find(`[name="bayarppd[]"]`))
          initAutoNumericNoMinus(detailRow.find(`[name="penyesuaianppd[]"]`))
          initAutoNumericNoMinus(detailRow.find(`[name="nominallebihbayarppd[]"]`))
          initAutoNumeric(detailRow.find(`[name="nominal[]"]`))
          initAutoNumeric(detailRow.find(`[name="sisa[]"]`))
          initAutoNumeric(detailRow.find('.sisa'))
          initAutoNumeric(detailRow.find('.nominal'))

          $('#detailList tbody').append(detailRow)
          setTotal()
          setPenyesuaian()
          setNominalLebih()
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
    $('.agen-lookup').lookup({
      title: 'Agen Lookup',
      fileName: 'agen',
      onSelectRow: (agen, element) => {
        $('#crudForm [name=agen_id]').first().val(agen.id)
        element.val(agen.namaagen)
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

    $('.bank-lookup').lookup({
      title: 'Bank Lookup',
      fileName: 'bank',
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

    $('.cabang-lookup').lookup({
      title: 'Cabang Lookup',
      fileName: 'cabang',
      onSelectRow: (cabang, element) => {
        $('#crudForm [name=cabang_id]').first().val(cabang.id)
        element.val(cabang.namacabang)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=cabang_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.pelanggan-lookup').lookup({
      title: 'Pelanggan Lookup',
      fileName: 'pelanggan',
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

    $('.agendetail-lookup').lookup({
      title: 'Agen Detail Lookup',
      fileName: 'agen',
      onSelectRow: (agen, element) => {
        $('#crudForm [name=agendetail_id]').first().val(agen.id)
        element.val(agen.namaagen)
        getPiutang(agen.id)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=agendetail_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
  }
</script>
@endpush()