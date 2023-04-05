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
                    POST <span class="text-danger">*</span></label>
                </div>
                <div class="col-12 col-md-4">
                  <input type="hidden" name="bank_id">
                  <input type="text" name="bank" class="form-control bank-lookup">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-md-2">
                  <label class="col-form-label">
                    NO BUKTI KAS KELUAR </label>
                </div>
                <div class="col-12 col-md-4">
                  <input type="text" name="pengeluaran_nobukti" id="pengeluaran_nobukti" class="form-control" readonly>
                </div>
              </div>
            </div>

            <div class="table-responsive table-scroll mt-3">
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

      if (action != 'delete') {

        $('#table_body tr').each(function(row, tr) {
          // console.log(row);

          if ($(this).find(`[name="hutang_id[]"]`).is(':checked')) {

            data.push({
              name: 'keterangandetail[]',
              value: $(this).find(`[name="keterangandetail[]"]`).val()
            })
            data.push({
              name: 'bayar[]',
              value: AutoNumeric.getNumber($(`#crudForm [name="bayar[]"]`)[row])
            })
            data.push({
              name: 'potongan[]',
              value: AutoNumeric.getNumber($(`#crudForm [name="potongan[]"]`)[row])
            })
            data.push({
              name: 'total[]',
              value: AutoNumeric.getNumber($(`#crudForm [name="total[]"]`)[row])
            })

            data.push({
              name: 'hutang_nobukti[]',
              value: $(this).find(`[name="hutang_nobukti[]"]`).val()
            })

            data.push({
              name: 'hutang_id[]',
              value: $(this).find(`[name="hutang_id[]"]`).val()
            })

          }
        })
      }
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
          $('#jqGrid').jqGrid('setGridParam', {
            page: response.data.page
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
            hutangid = []
            $('#table_body tr').each(function(row, tr) {
              if ($(this).find(`[name="hutang_id[]"]`).is(':checked')) {
                hutangid.push($(this).find(`[name="hutang_id[]"]`).val())
              }
            })
            errors = error.responseJSON.errors

            $.each(errors, (index, error) => {
              let indexes = index.split(".");
              let angka = indexes[1]

              row = hutangid[angka] - 1;
              let element;

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
    setBayar()
    setPotongan()
    setTotal()
  }

  function editHutangBayarHeader(Id) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    $('#crudModalTitle').text('Edit Pembayaran Hutang')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()


    form.find(`[name="tglbukti"]`).prop('readonly', true)
    form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()

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
          }
          if (index == 'supplier') {
            element.data('current-value', value)
          }
          if (index == 'alatbayar') {
            element.data('current-value', value)
          }

          if (index == 'tglbukti' || index == 'supplier_id' || index == 'supplier' || index == 'tglcair') {
            element.prop('disabled', false)
          } else {
            element.prop("disabled", true)
          }
        })


        getPembayaran(Id, response.data.supplier_id, 'edit')
      }
    })
  }

  function deleteHutangBayarHeader(Id) {
    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    $('#crudModalTitle').text('Delete Pembayaran Hutang')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    form.find(`[name="tglbukti"]`).prop('readonly', true)
    form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
    $.ajax({
      url: `${apiUrl}hutangbayarheader/${Id}`,
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

        getPembayaran(Id, response.data.supplier_id, 'delete')

      }
    })
  }

  // $(window).on("load", function() {
  //   var $grid = $("#gridPiutang"),
  //     newWidth = $grid.closest(".ui-jqgrid").parent().width();
  //   $grid.jqGrid("setGridWidth", newWidth, true);
  // });

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
            if (Aksi == 'EDIT') {
              editHutangBayarHeader(Id)
            }
            if (Aksi == 'DELETE') {
              deleteHutangBayarHeader(Id)
            }
          }

        } else {
          showDialog(response.message['keterangan'])
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
    $('#loader').removeClass('d-none')

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
      $('#loader').addClass('d-none')
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
          bankId: bankId
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
        getHutang(supplier.id, 'supplier_id')
        element.data('currentValue', element.val())
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
        console.log(alatbayar)
        bankId = alatbayar.bank_id
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
  }
</script>
@endpush()