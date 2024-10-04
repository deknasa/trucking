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

            <div class="row form-group">
              <input type="hidden" name="id" hidden class="form-control" readonly>

              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">no bukti <span class="text-danger"></span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" readonly name="nobukti" class="form-control">
              </div>

              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">TGL BUKTI <span class="text-danger">*</span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <div class="input-group">
                  <input type="text" name="tglbukti" class="form-control datepicker">
                </div>
              </div>
            </div>
            <div class="row">

              <div class="form-group col-md-6">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4">
                    <label class="col-form-label">penerimaan stok <span class="text-danger">*</span> </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <input type="text" name="penerimaanstok" id="penerimaanstok" class="form-control penerimaanstok-lookup">
                    <input type="text" id="penerimaanstokId" name="penerimaanstok_id" hidden readonly>
                  </div>
                </div>
              </div>


              <div class="form-group col-md-6">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4">
                    <label class="col-form-label">PENERIMAAN STOK NO BUKTI </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <input type="text" name="penerimaanstok_nobukti" class="form-control penerimaanstokheader-lookup">
                  </div>
                </div>
              </div>

              <div class="form-group col-md-6">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4">
                    <label class="col-form-label">pengeluaran stok no bukti </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <input type="text" name="pengeluaranstok_nobukti" class="form-control pengeluaranstokheader-lookup">
                  </div>
                </div>
              </div>

              <div class="form-group col-md-6">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4">
                    <label class="col-form-label">pengeluaran stok no bukti proses</label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <input type="text" name="pengeluaranstok_nobukti_proses" class="form-control" readonly>
                  </div>
                </div>
              </div>

              <div class="form-group col-md-6">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4">
                    <label class="col-form-label">no bon </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <input type="text" name="nobon" class="form-control">
                  </div>
                </div>
              </div>

              <div class="form-group col-md-6">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4">
                    <label class="col-form-label">hutang no bukti </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <input type="text" name="hutang_nobukti" class="form-control" readonly>
                  </div>
                </div>
              </div>

              <div class="form-group col-md-6">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4">
                    <label class="col-form-label">kode perkiraan</label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <input type="text" name="coa" class="form-control akunpusat-lookup">
                  </div>
                </div>
              </div>

              <div class="form-group col-md-6">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4">
                    <label class="col-form-label">trado </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <input type="text" name="trado" id="trado" class="form-control trado-lookup">
                    <input type="text" id="tradoId" name="trado_id" hidden readonly>
                  </div>
                </div>
              </div>

              <div class="form-group col-md-6">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4">
                    <label class="col-form-label">supplier </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <input type="text" name="supplier" id="supplier" class="form-control supplier-lookup">
                    <input type="text" id="supplierId" name="supplier_id" hidden readonly>
                  </div>
                </div>
              </div>

              <div class="form-group col-md-6">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4">
                    <label class="col-form-label">gudang </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <input type="text" name="gudang" id="gudang" class="form-control gudang-lookup">
                    <input type="text" id="gudangId" name="gudang_id" hidden readonly>
                  </div>
                </div>
              </div>

              <div class="form-group col-md-6">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4">
                    <label class="col-form-label">gandengan </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <input type="text" name="gandengan" id="gandengan" class="form-control gandengan-lookup">
                    <input type="text" id="gandenganId" name="gandengan_id" hidden readonly>
                  </div>
                </div>
              </div>

            </div>

            <div class="row">

              <div class="form-group col-md-6">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4">
                    <label class="col-form-label"> gudang dari </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <input type="text" name="gudangdari" id="gudangdari" class="form-control gudangdari-lookup">
                    <input type="text" id="gudangdariId" name="gudangdari_id" hidden readonly>
                  </div>
                </div>
              </div>
              <div class="form-group col-md-6">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4">
                    <label class="col-form-label">gudang ke </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <input type="text" name="gudangke" id="gudangke" class="form-control gudangke-lookup">
                    <input type="text" id="gudangkeId" name="gudangke_id" hidden readonly>
                  </div>
                </div>
              </div>

              <div class="form-group col-md-6">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4">
                    <label class="col-form-label">trado dari</label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <input type="text" name="tradodari" id="tradodari" class="form-control tradodari-lookup">
                    <input type="text" id="tradodariId" name="tradodari_id" hidden readonly>
                  </div>
                </div>
              </div>

              <div class="form-group col-md-6">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4">
                    <label class="col-form-label">trado ke </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <input type="text" name="tradoke" id="tradoke" class="form-control tradoke-lookup">
                    <input type="text" id="tradokeId" name="tradoke_id" hidden readonly>
                  </div>
                </div>
              </div>


              <div class="form-group col-md-6">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4">
                    <label class="col-form-label">gandengan dari</label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <input type="text" name="gandengandari" id="gandengandari" class="form-control gandengandari-lookup">
                    <input type="text" id="gandengandariId" name="gandengandari_id" hidden readonly>
                  </div>
                </div>
              </div>

              <div class="form-group col-md-6">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4">
                    <label class="col-form-label">gandengan ke </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <input type="text" name="gandenganke" id="gandenganke" class="form-control gandenganke-lookup">
                    <input type="text" id="gandengankeId" name="gandenganke_id" hidden readonly>
                  </div>
                </div>
              </div>
            </div>




            {{-- <div class="row form-group" style="display:none">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">keterangan </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="keterangan" class="form-control">
              </div>
            </div> --}}


            <div class="table-scroll table-responsive" style="min-height: 500px;">
              <table class="table table-bordered table-bindkeys" id="detailList" style="width: 100%; min-width: 500px;">
                <thead>
                  <tr>
                    <th style="width:10%; max-width: 25px;max-width: 15px">No</th>
                    <th style="width: 20%; min-width: 200px;">stok </th>
                    <th style="width: 10%; min-width: 100px;">Satuan </th>
                    <th style="width: 20%; min-width: 200px;">keterangan </th>
                    <th class="data_tbl tbl_penerimaanstok_nobukti" style="width: 20%; min-width: 200px;">Penerimaan stok no bukti</th>
                    <th class="data_tbl tbl_harga" style="width: 20%; min-width: 200px;">harga</th>
                    <th class="data_tbl tbl_qty" style="width:10%; min-width: 100px">qty </th>
                    <th class="data_tbl tbl_qtyterpakai" style="width:10%; min-width: 100px">qty terpakai</th>
                    <th class="data_tbl tbl_vulkanisirke" style="width:10%; min-width: 100px">vulkanisir ke</th>
                    <th class="data_tbl tbl_vulkanisirtotal" style="width:10%; min-width: 100px">vulkanisir</th>
                    <th class="data_tbl tbl_total_sebelum" style="width: 20%; min-width: 200px;">Total Sebelum disc</th>
                    <th class="data_tbl tbl_statusban" style="width:10%; min-width: 100px">Status Ban</th>
                    <th class="data_tbl tbl_persentase" style="width:10%; min-width: 100px">persentase discount</th>
                    <th class="data_tbl tbl_nominaldiscount" style="width:20%; min-width: 200px">nominal discount</th>
                    <th class="data_tbl tbl_total" style="width: 20%; min-width: 200px;">Total</th>
                    <th class="data_tbl tbl_aksi" style="width:10%; max-width: 25px;max-width: 15px">Aksi</th>
                  </tr>
                </thead>
                <tbody id="table_body" class="form-group">

                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="6" class="colspan"></td>

                    <td class="font-weight-bold data_tbl sumrow"> Total : </td>
                    <td id="sumary" class="text-right font-weight-bold data_tbl sumrow"> </td>
                    <td class="data_tbl tbl_aksi">
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
  var KodePenerimaanId
  var KelompokId = "";
  var StokId = "";
  var listKodePenerimaan = [];
  var listIdPenerimaan = [];
  $(document).ready(function() {
    $(document).on('click', '#addRow', function(event) {
      event.preventDefault()
      let form = $('#crudForm')
      let penerimaanStokHeaderId = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()
      data = numericInput(data);


      $.ajax({
        url: `${apiUrl}penerimaanstokheader/addrow`,
        method: 'POST',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: data,
        success: response => {
          addRow()
          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()

        },
        error: error => {
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            // Membuang elemen dengan kunci yang mengandung "detail_stok_id"
            const filteredErrors = Object.keys(error.responseJSON.errors).reduce((result, key) => {
              if (!key.includes("penerimaanstok_id")) {
                if (!key.includes("detail_stok_id")) {
                  result[key] = error.responseJSON.errors[key];
                }
              }
              return result;
            }, {});

            console.log(filteredErrors);
            setErrorMessages(form, filteredErrors);

          } else {
            showDialog(error.responseJSON)
          }
        },
      }).always(() => {
        $('#processingLoader').addClass('d-none')
        $(this).removeAttr('disabled')
      })
    });

    function validasiSpbMinus(detail_id, row) {
      let form = $('#crudForm');
      $.ajax({
        url: `${apiUrl}penerimaanstokheader/deleterow`,
        method: 'POST',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          detail: detail_id
        },
        success: response => {
          console.log(response);
          deleteRow(row)
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

    $(document).on('click', '.rmv', function(event) {
      // console.log($(.rmv).parents('tr'));
      if ($(this).attr('data-id')) {
        validasiSpbMinus($(this).attr('data-id'), $(this).parents('tr'))
      } else {
        deleteRow($(this).parents('tr'))
      }
    })

    function numericInput(data) {
      $('#crudForm').find(`[name="detail_qty[]"]`).each((index, element) => {
        if (element.value != "" && AutoNumeric.getAutoNumericElement(element) !== null) {
          data.filter((row) => row.name === 'detail_qty[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="detail_qty[]"]`)[index])
        } else {
          data.filter((row) => row.name === 'detail_qty[]')[index].value = 0;
        }
      })
      $('#crudForm').find(`[name="detail_qtyterpakai[]"]`).each((index, element) => {
        if (element.value != "" && AutoNumeric.getAutoNumericElement(element) !== null) {
          data.filter((row) => row.name === 'detail_qtyterpakai[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="detail_qtyterpakai[]"]`)[index])
        } else {
          data.filter((row) => row.name === 'detail_qtyterpakai[]')[index].value = 0;
        }
      })
      $('#crudForm').find(`[name="detail_harga[]"]`).each((index, element) => {
        if (element.value != "" && AutoNumeric.getAutoNumericElement(element) !== null) {
          data.filter((row) => row.name === 'detail_harga[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="detail_harga[]"]`)[index])
        } else {
          data.filter((row) => row.name === 'detail_harga[]')[index].value = 0;
        }
      })

      $('#crudForm').find(`[name="detail_persentasediscount[]"]`).each((index, element) => {
        if (element.value != "" && AutoNumeric.getAutoNumericElement(element) !== null) {
          data.filter((row) => row.name === 'detail_persentasediscount[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="detail_persentasediscount[]"]`)[index])
        } else {
          data.filter((row) => row.name === 'detail_persentasediscount[]')[index].value = 0;
        }
      })

      $('#crudForm').find(`[name="detail_nominaldiscount[]"]`).each((index, element) => {
        if (element.value != "" && AutoNumeric.getAutoNumericElement(element) !== null) {
          data.filter((row) => row.name === 'detail_nominaldiscount[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="detail_nominaldiscount[]"]`)[index])
        } else {
          data.filter((row) => row.name === 'detail_nominaldiscount[]')[index].value = 0;
        }
      })

      $('#crudForm').find(`[name="total_sebelum[]"]`).each((index, element) => {
        if (element.value != "" && AutoNumeric.getAutoNumericElement(element) !== null) {
          data.filter((row) => row.name === 'total_sebelum[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="total_sebelum[]"]`)[index])
        } else {
          data.filter((row) => row.name === 'total_sebelum[]')[index].value = 0;
        }
      })
      $('#crudForm').find(`[name="totalItem[]"]`).each((index, element) => {
        if (element.value != "" && AutoNumeric.getAutoNumericElement(element) !== null) {
          data.filter((row) => row.name === 'totalItem[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="totalItem[]"]`)[index])
        } else {
          data.filter((row) => row.name === 'totalItem[]')[index].value = 0;
        }
      })
      return data;
    }

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
      let penerimaanStokHeaderId = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()

      if (action !== 'delete') {
        data = numericInput(data);
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
        name: 'keterangan',
        value: ''
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
        name: 'penerimaanheader_id',
        value: $('#penerimaanstokId').val()
      })
      data.push({
        name: 'button',
        value: button
      })
      data.push({
        name: 'aksi',
        value: action.toUpperCase()
      })
      let penerimaanheader_id = $('#penerimaanstokId').val()
      let tgldariheader = $('#tgldariheader').val();
      let tglsampaiheader = $('#tglsampaiheader').val()
      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}penerimaanstokheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}penerimaanstokheader/${penerimaanStokHeaderId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}penerimaanstokheader/${penerimaanStokHeaderId}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&penerimaanheader_id=${penerimaanheader_id}&indexRow=${indexRow}&limit=${limit}&page=${page}`
          // url = `${apiUrl}penerimaanstokheader/${penerimaanStokHeaderId}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}penerimaanstokheader`
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
          $('#kodepenerimaanheader').val(response.data.penerimaanstok_id).trigger('change')
          if (button == 'btnSubmit') {
            $('#crudModal').modal('hide')

            id = response.data.id

            $('#rangeHeader').find('[name=tgldariheader]').val(dateFormat(response.data.tgldariheader)).trigger('change');
            $('#rangeHeader').find('[name=tglsampaiheader]').val(dateFormat(response.data.tglsampaiheader)).trigger('change');
            $('#jqGrid').jqGrid('setGridParam', {
              postData: {
                proses: 'reload',
                penerimaanheader_id: response.data.penerimaanstok_id,
                tgldari: dateFormat(response.data.tgldariheader),
                tglsampai: dateFormat(response.data.tglsampaiheader)
              },
              page: response.data.page
            }).trigger('reloadGrid')

            if (response.data.grp == 'FORMAT') {
              updateFormat(response.data)
            }
          } else {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
            $('#crudForm').find('input[type="text"]').data('current-value', '')
            if ($('#kodepenerimaanheader').val() != '') {
              createPenerimaanstokHeader();
              let index = listIdPenerimaan.indexOf($('#kodepenerimaanheader').val());
              setKodePenerimaan(listKodePenerimaan[index]);
              setIsDateAvailable($('#kodepenerimaanheader').val())

              $('#crudForm').find(`[name="penerimaanstok"]`).val(listKodePenerimaan[index])
              $('#crudForm').find(`[name="penerimaanstok"]`).data('currentValue', listKodePenerimaan[index])
              $('#crudForm').find(`[name="penerimaanstok_id"]`).val($('#kodepenerimaanheader').val())
            } else {
              createPenerimaanstokHeader();
            }
            showSuccessDialog(response.message, response.data.nobukti)
            $('#crudForm').find('[name=tglbukti]').val(dateFormat(response.data.tglbukti)).trigger('change');

          }
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
  })

  function setKodePenerimaan(kode) {
    KodePenerimaanId = kode;
    // resetLookup()
    setTampilanForm();
  }

  function setTampilanForm() {
    tampilanall()
    switch (KodePenerimaanId) {
      case listKodePenerimaan[0]: // 'DOT':
        tampilandot()
        break;
      case listKodePenerimaan[1]: // 'PO':
        tampilanpo()
        break;
      case listKodePenerimaan[2]: // 'SPB':
        tampilanpbt()
        break;
      case listKodePenerimaan[4]: // 'PG':
        tampilanpgt()
        break;
      case listKodePenerimaan[3]: // 'KOR':
        tampilankst()
        break;
      case listKodePenerimaan[5]: // 'SPBS':
        tampilanSPBS()
        break;
      case listKodePenerimaan[7]: // 'PST':
        tampilanPST()
        break;
      case listKodePenerimaan[8]: // 'PSPK':
        tampilanPSPK()
        break;
      case listKodePenerimaan[9]: // 'KORV':
        tampilanKORV()
        break;
      case listKodePenerimaan[10]: // 'SPBP':
        tampilanSPBP()
        break;

      default:
        tampilanInit()
        break;
    }
  }


  function tampilandot() {
    $('[name=penerimaanstok_nobukti]').parents('.form-group').hide()
    $('[name=pengeluaranstok_nobukti]').parents('.form-group').hide()
    $('[name=hutang_nobukti]').parents('.form-group').hide()
    $('[name=trado]').parents('.form-group').hide()
    $('[name=gudang]').parents('.form-group').hide()
    $('[name=gudangdari]').parents('.form-group').hide()
    $('[name=gudangke]').parents('.form-group').hide()
    $('[name=gandengan]').parents('.form-group').hide()
    $('[name=tradodari]').parents('.form-group').hide()
    $('[name=tradoke]').parents('.form-group').hide()
    $('[name=gandengandari]').parents('.form-group').hide()
    $('[name=gandenganke]').parents('.form-group').hide()
    $('[name=coa]').parents('.form-group').hide()
    $('[name=pengeluaranstok_nobukti_proses]').parents('.form-group').hide()
    $('.tbl_vulkanisirke').hide();
    $('.tbl_vulkanisirtotal').hide();
    $('.tbl_statusban').hide();
    $('.tbl_qtyterpakai').hide();
    $('.tbl_persentase').hide();
    $('.tbl_nominaldiscount').hide();
    $('.tbl_total').hide();
    $('.tbl_harga').hide();
    $('.tbl_penerimaanstok_nobukti').hide();
    $('.colspan').attr('colspan', 5);
    $('.sumrow').hide();

    // $('[name=supplier]').val('').attr('readonly', false);
    // $('[name=supplier]').data('currentValue', '')
    // $('[name=supplier_id]').val('')
    $('#addRow').show()
    $('.tbl_aksi').show()

  }

  function tampilanpo() {
    $('[name=penerimaanstok_nobukti]').parents('.form-group').hide()
    $('[name=pengeluaranstok_nobukti]').parents('.form-group').hide()
    $('[name=hutang_nobukti]').parents('.form-group').hide()
    $('[name=trado]').parents('.form-group').hide()
    $('[name=gudang]').parents('.form-group').hide()
    $('[name=gudangdari]').parents('.form-group').hide()
    $('[name=gudangke]').parents('.form-group').hide()
    $('[name=gandengan]').parents('.form-group').hide()
    $('[name=tradodari]').parents('.form-group').hide()
    $('[name=tradoke]').parents('.form-group').hide()
    $('[name=gandengandari]').parents('.form-group').hide()
    $('[name=gandenganke]').parents('.form-group').hide()
    $('[name=coa]').parents('.form-group').hide()
    $('[name=pengeluaranstok_nobukti_proses]').parents('.form-group').hide()
    $('.tbl_vulkanisirke').hide();
    $('.tbl_vulkanisirtotal').hide();
    $('.tbl_statusban').hide();
    $('.tbl_qtyterpakai').hide();
    $('.tbl_harga').hide();
    $('.tbl_persentase').hide();
    $('.tbl_nominaldiscount').hide();
    $('.tbl_total').hide();
    $('.tbl_penerimaanstok_nobukti').hide();

    $('.colspan').attr('colspan', 5);
    $('.sumrow').hide();

    // $('[name=supplier]').val('').attr('readonly', false);
    // $('[name=supplier]').data('currentValue', '')
    // $('[name=supplier_id]').val('')
    $('#addRow').show()
    $('.tbl_aksi').show()

  }

  function tampilanpbt() {
    $('[name=pengeluaranstok_nobukti]').parents('.form-group').hide()
    $('[name=trado]').parents('.form-group').hide()
    $('[name=gudang]').parents('.form-group').hide()
    $('[name=gudangdari]').parents('.form-group').hide()
    $('[name=gudangke]').parents('.form-group').hide()
    $('[name=gandengan]').parents('.form-group').hide()
    $('[name=tradodari]').parents('.form-group').hide()
    $('[name=tradoke]').parents('.form-group').hide()
    $('[name=gandengandari]').parents('.form-group').hide()
    $('[name=gandenganke]').parents('.form-group').hide()
    $('[name=coa]').parents('.form-group').hide()
    $('[name=pengeluaranstok_nobukti_proses]').parents('.form-group').hide()
    $('.tbl_qtyterpakai').hide();
    $('.tbl_vulkanisirke').hide();
    $('.tbl_vulkanisirtotal').hide();
    $('.tbl_statusban').hide();
    $('.colspan').attr('colspan', 8);
    $('.tbl_total_sebelum').show();
    $('.tbl_penerimaanstok_nobukti').hide();

    $('.sumrow').show();

    $('.tbl_aksi').show()
  }

  function tampilanpgt() {
    $('[name=gudang]').parents('.form-group').hide()
    $('[name=trado]').parents('.form-group').hide()
    $('[name=gandengan]').parents('.form-group').hide()
    $('[name=penerimaanstok_nobukti]').parents('.form-group').hide()
    $('[name=pengeluaranstok_nobukti]').parents('.form-group').hide()
    $('[name=hutang_nobukti]').parents('.form-group').hide()
    $('[name=coa]').parents('.form-group').hide()
    $('[name=supplier_id]').parents('.form-group').hide()
    $('[name=nobon]').parents('.form-group').hide()
    $('.tbl_vulkanisirke').hide();
    $('.tbl_vulkanisirtotal').hide();
    $('[name=pengeluaranstok_nobukti_proses]').parents('.form-group').hide()
    $('[name=gudangdari]').parents('.form-group').show()
    $('[name=gudangke]').parents('.form-group').show()
    $('[name=tradodari]').parents('.form-group').show()
    $('[name=tradoke]').parents('.form-group').show()
    $('[name=gandengandari]').parents('.form-group').show()
    $('[name=gandenganke]').parents('.form-group').show()
    $('.tbl_penerimaanstok_nobukti').hide();
    $('.tbl_persentase').hide();
    $('.tbl_qtyterpakai').hide();

    $('.tbl_nominaldiscount').hide();
    $('.tbl_statusban').hide();
    $('.tbl_total').hide();
    $('.tbl_harga').hide();
    $('.tbl_total_sebelum').hide();
    $('.colspan').attr('colspan', 3);

    $('.tbl_aksi').show()
    $('#addRow').show()

  }

  function tampilankst() {
    $('[name=supplier]').parents('.form-group').hide()
    $('[name=servicein_nobukti]').parents('.form-group').hide()
    $('[name=penerimaanstok_nobukti]').parents('.form-group').hide()
    $('[name=pengeluaranstok_nobukti]').parents('.form-group').hide()
    $('[name=keterangan]').parents('.form-group').hide()
    $('[name=nobon]').parents('.form-group').hide()
    $('[name=hutang_nobukti]').parents('.form-group').hide()
    $('[name=coa]').parents('.form-group').hide()

    $('[name=gudang]').parents('.form-group').show()
    $('[name=trado]').parents('.form-group').show()
    $('[name=gandengan]').parents('.form-group').show()
    $('[name=pengeluaranstok_nobukti_proses]').parents('.form-group').hide()

    $('[name=gudangdari]').parents('.form-group').hide()
    $('[name=gudangke]').parents('.form-group').hide()
    $('[name=tradodari]').parents('.form-group').hide()
    $('[name=tradoke]').parents('.form-group').hide()
    $('[name=gandengandari]').parents('.form-group').hide()
    $('[name=gandenganke]').parents('.form-group').hide()
    $('.tbl_penerimaanstok_nobukti').hide();
    $('.tbl_qtyterpakai').hide();
    $('.tbl_qty').show()
    $('.tbl_statusban').hide();
    $('.tbl_vulkanisirke').hide();
    $('.tbl_vulkanisirtotal').hide();
    $('.tbl_harga').hide();
    $('.tbl_persentase').hide();
    $('.tbl_nominaldiscount').hide();
    $('.tbl_total').hide();
    $('.tbl_total_sebelum').hide();
    $('.colspan').attr('colspan', 5);
    $('.sumrow').hide();

    $('#addRow').show()
  }

  function tampilanSPBS() {
    $('[name=gudang]').parents('.form-group').show()
    $('[name=trado]').parents('.form-group').hide()
    $('[name=gandengan]').parents('.form-group').hide()
    $('[name=penerimaanstok_nobukti]').parents('.form-group').hide()
    $('[name=pengeluaranstok_nobukti]').parents('.form-group').hide()
    $('[name=coa]').parents('.form-group').hide()
    $('[name=gudang]').parents('.form-group').hide()

    $('[name=pengeluaranstok_nobukti_proses]').parents('.form-group').hide()
    $('[name=gudangdari]').parents('.form-group').hide()
    $('[name=gudangke]').parents('.form-group').hide()
    $('[name=gandengan]').parents('.form-group').hide()
    $('[name=tradodari]').parents('.form-group').hide()
    $('[name=tradoke]').parents('.form-group').hide()
    $('[name=gandengandari]').parents('.form-group').hide()
    $('[name=gandenganke]').parents('.form-group').hide()
    $('.tbl_qtyterpakai').hide();
    $('.tbl_vulkanisirke').hide();
    $('.tbl_vulkanisirtotal').hide();
    $('.tbl_statusban').hide();
    $('.tbl_total_sebelum').show();
    $('.tbl_penerimaanstok_nobukti').show();
    $('.colspan').attr('colspan', 9);

    $('#addRow').show()
  }

  function tampilanall() {
    $('[name=penerimaanstok_nobukti]').parents('.form-group').show()
    $('[name=pengeluaranstok_nobukti]').parents('.form-group').show()
    $('[name=nobon]').parents('.form-group').show()
    $('[name=hutang_nobukti]').parents('.form-group').show()
    $('[name=trado]').parents('.form-group').show()
    $('[name=supplier]').parents('.form-group').show()
    $('[name=gudang]').parents('.form-group').show()
    $('[name=gudangdari]').parents('.form-group').show()
    $('[name=gudangke]').parents('.form-group').show()
    $('[name=coa]').parents('.form-group').show()
    // $('[name=gudang]').val('').attr('readonly', false);
    // $('[name=gudang_id]').val('')
    $('.tbl_penerimaanstok_nobukti').hide();
    $('.sumrow').show();
    $('.data_tbl').show();
    $('.tbl_total_sebelum').hide();
    $('.colspan').attr('colspan', 7);
    $('.tbl_vulkanisirke').hide();
    $('.tbl_vulkanisirtotal').hide();
    $('.tbl_statusban').hide();
    // $('[name=nobon]').val('')
    // $('[name=supplier]').attr('readonly', false);
    // $('[name=supplier]').data('currentValue', '')
    // $('[name=supplier_id]').val('')
    $('#addRow').show()

  }

  function tampilanInit() {
    $('[name=gudang]').val('').attr('readonly', false);
    $('[name=gudang_id]').val('')
    $('[name=penerimaanstok_nobukti]').parents('.form-group').hide()
    $('[name=pengeluaranstok_nobukti]').parents('.form-group').hide()
    $('[name=nobon]').parents('.form-group').hide()
    $('[name=hutang_nobukti]').parents('.form-group').hide()
    $('[name=trado]').parents('.form-group').hide()
    $('[name=tradodari]').parents('.form-group').hide()
    $('[name=tradoke]').parents('.form-group').hide()
    $('[name=gandengan]').parents('.form-group').hide()
    $('[name=gandengandari]').parents('.form-group').hide()
    $('[name=gandenganke]').parents('.form-group').hide()
    $('[name=pengeluaranstok_nobukti_proses]').parents('.form-group').hide()

    $('[name=supplier]').parents('.form-group').hide()
    $('[name=gudang]').parents('.form-group').hide()
    $('[name=gudangdari]').parents('.form-group').hide()
    $('[name=gudangke]').parents('.form-group').hide()
    $('[name=coa]').parents('.form-group').hide()
    // $('[name=gudang]').val('').attr('readonly', false);
    // $('[name=gudang_id]').val('')
    $('.tbl_penerimaanstok_nobukti').hide();
    $('.sumrow').hide();
    $('.data_tbl').hide();
    $('.tbl_total_sebelum').hide();
    $('.tbl_statusban').hide();
    $('.colspan').attr('colspan', 4);
    // $('[name=nobon]').val('')
    // $('[name=supplier]').attr('readonly', false);
    // $('[name=supplier]').data('currentValue', '')
    // $('[name=supplier_id]').val('')
    $('#addRow').show()
    $('.tbl_aksi').show()
  }

  function tampilanPST() {
    $('[name=pengeluaranstok_nobukti]').parents('.form-group').show()
    $('[name=penerimaanstok_nobukti]').parents('.form-group').hide()
    $('[name=nobon]').parents('.form-group').hide()
    $('[name=hutang_nobukti]').parents('.form-group').hide()
    $('[name=supplier]').parents('.form-group').hide()
    $('[name=trado]').parents('.form-group').hide()
    $('[name=gudang]').parents('.form-group').hide()
    $('[name=gudangdari]').parents('.form-group').hide()
    $('[name=gudangke]').parents('.form-group').hide()
    $('[name=gandengan]').parents('.form-group').hide()
    $('[name=tradodari]').parents('.form-group').hide()
    $('[name=tradoke]').parents('.form-group').hide()
    $('[name=gandengandari]').parents('.form-group').hide()
    $('[name=pengeluaranstok_nobukti_proses]').parents('.form-group').show()
    $('[name=gandenganke]').parents('.form-group').hide()
    $('[name=coa]').parents('.form-group').hide()
    $('.tbl_vulkanisirke').hide();
    $('.tbl_vulkanisirtotal').hide();
    $('.tbl_statusban').hide();
    $('.tbl_total_sebelum').hide();
    $('.tbl_persentase').hide();
    $('.tbl_nominaldiscount').hide();
    $('.colspan').attr('colspan', 6);

    $('.tbl_penerimaanstok_nobukti').hide();
    $('.tbl_qtyterpakai').show();

    $('.sumrow').show();

    $('.tbl_aksi').hide()
  }

  function tampilanPSPK() {
    $('[name=pengeluaranstok_nobukti]').parents('.form-group').show()
    $('[name=penerimaanstok_nobukti]').parents('.form-group').hide()
    $('[name=nobon]').parents('.form-group').hide()
    $('[name=hutang_nobukti]').parents('.form-group').hide()
    $('[name=supplier]').parents('.form-group').hide()
    $('[name=trado]').parents('.form-group').hide()
    $('[name=gudang]').parents('.form-group').hide()
    $('[name=gudangdari]').parents('.form-group').hide()
    $('[name=gudangke]').parents('.form-group').hide()
    $('[name=gandengan]').parents('.form-group').hide()
    $('[name=tradodari]').parents('.form-group').hide()
    $('[name=tradoke]').parents('.form-group').hide()
    $('[name=gandengandari]').parents('.form-group').hide()
    $('[name=gandenganke]').parents('.form-group').hide()
    $('[name=coa]').parents('.form-group').hide()
    $('[name=pengeluaranstok_nobukti_proses]').parents('.form-group').hide()
    $('.tbl_vulkanisirke').hide();
    $('.tbl_qtyterpakai').hide();
    $('.tbl_vulkanisirtotal').hide();
    $('.tbl_statusban').hide();
    $('.tbl_total_sebelum').hide();
    $('.colspan').attr('colspan', 7);
    $('.tbl_penerimaanstok_nobukti').hide();

    $('.sumrow').show();

    $('.tbl_aksi').show()
  }

  function tampilanKORV() {
    $('[name=supplier]').parents('.form-group').hide()
    $('[name=servicein_nobukti]').parents('.form-group').hide()
    $('[name=penerimaanstok_nobukti]').parents('.form-group').hide()
    $('[name=pengeluaranstok_nobukti]').parents('.form-group').hide()
    $('[name=keterangan]').parents('.form-group').hide()
    $('[name=nobon]').parents('.form-group').hide()
    $('[name=hutang_nobukti]').parents('.form-group').hide()
    $('[name=coa]').parents('.form-group').hide()
    $('[name=pengeluaranstok_nobukti_proses]').parents('.form-group').hide()
    $('[name=gudang]').parents('.form-group').hide()
    $('[name=trado]').parents('.form-group').hide()
    $('[name=gandengan]').parents('.form-group').hide()
    $('.tbl_qtyterpakai').hide();
    $('.tbl_total_sebelum').hide();
    $('[name=gudangdari]').parents('.form-group').hide()
    $('[name=gudangke]').parents('.form-group').hide()
    $('[name=tradodari]').parents('.form-group').hide()
    $('[name=tradoke]').parents('.form-group').hide()
    $('[name=gandengandari]').parents('.form-group').hide()
    $('[name=gandenganke]').parents('.form-group').hide()
    $('.tbl_penerimaanstok_nobukti').hide();
    $('.tbl_qty').hide()
    $('.tbl_vulkanisirke').show();
    $('.tbl_vulkanisirtotal').show();
    $('.tbl_statusban').show();
    $('.tbl_harga').hide();
    $('.tbl_persentase').hide();
    $('.tbl_nominaldiscount').hide();
    $('.tbl_total').hide();
    $('.colspan').attr('colspan', 7);
    $('.sumrow').hide();

    $('#addRow').show()
  }


  function tampilanSPBP() {
    $('[name=pengeluaranstok_nobukti]').parents('.form-group').hide()
    $('[name=hutang_nobukti]').parents('.form-group').hide()
    $('[name=supplier]').parents('.form-group').show()

    $('[name=trado]').parents('.form-group').hide()
    $('[name=gudang]').parents('.form-group').hide()
    $('[name=gudangdari]').parents('.form-group').hide()
    $('[name=gudangke]').parents('.form-group').hide()
    $('[name=gandengan]').parents('.form-group').hide()
    $('[name=tradodari]').parents('.form-group').hide()
    $('[name=tradoke]').parents('.form-group').hide()
    $('[name=gandengandari]').parents('.form-group').hide()
    $('[name=gandenganke]').parents('.form-group').hide()
    $('[name=coa]').parents('.form-group').hide()
    $('[name=pengeluaranstok_nobukti_proses]').parents('.form-group').hide()
    $('.tbl_qtyterpakai').hide();
    $('.tbl_vulkanisirke').hide();
    $('.tbl_vulkanisirtotal').hide();
    $('.tbl_statusban').hide();
    $('.tbl_total_sebelum').hide();
    $('.tbl_penerimaanstok_nobukti').show();
    $('.colspan').attr('colspan', 8);

    $('.tbl_aksi').show()
  }

  function setSuplier(penerimaan_id) {
    $.ajax({
      url: `${apiUrl}penerimaanstokheader/${penerimaan_id}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        'Authorization': `Bearer ${accessToken}`
      },
      success: response => {
        var data = response.data;
        // kategori.attr('disabled', true)
        $('#crudForm').find(`[name="supplier"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled', true)
        $('#crudForm').find(`[name="supplier"]`).parents('.input-group').find('.button-clear').attr('disabled', true)
        // attr('disabled', true)
        $('[name=supplier]').val(data.supplier).attr('readonly', true);
        $('[name=supplier]').data('currentValue', data.supplier)

        $('[name=supplier_id]').val(data.supplier_id)
      },
      error: error => {
        showDialog(error.statusText)
      }
    })
  }

  function setDetailPenerimaan(penerimaan_id) {
    $.ajax({
      url: `${apiUrl}penerimaanstokheader/${penerimaan_id}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        'Authorization': `Bearer ${accessToken}`
      },
      success: response => {
        $('#detailList tbody').html('')
        resetRow()
        $.each(response.detail, (id, detail) => {
          let detailRow = $(`
            <tr class="trow" data-id="${detail.id}">
                  <td>
                    <div class="baris">1</div>
                  </td>
                  
                  <td>
                    <input type="text"  name="detail_stok[]" id="detail_stok_${detail.id}" class="form-control stok-lookup ">
                    <input type="text" id="detailstokId_${detail.id}" readonly hidden class="detailstokId" name="detail_stok_id[]">
                    <input type="text" id="detailstokKelompok_${detail.id}" value="${detail.kelompok_id}" readonly hidden class="detailstokKelompok" name="detail_stok_kelompok[]">
                  </td>
                  <td>
                    <input type="text" disabled name="detail_satuan[]" id="" value="${detail.satuan}" class="form-control detail_satuan_${detail.id}">
                  </td> 
                  <td>
                    <textarea class="form-control" name="detail_keterangan[]" rows="1" placeholder=""></textarea>
                  </td>
                  
                  <td class="data_tbl tbl_penerimaanstok_nobukti">
                    <input type="text"  name="detail_penerimaanstoknobukti[]" id="detail_penerimaanstoknobukti_${detail.id}" class="form-control ">
                    <input type="text" id="detailpenerimaanstoknobuktiId_${detail.id}" readonly hidden class="detailpenerimaanstoknobuktiId" name="detail_penerimaanstoknobukti_id[]">
                  </td>  

                  <td class="data_tbl tbl_harga">
                    <input type="text"  name="detail_harga[]" readonly id="detail_harga${detail.id}" style="text-align:right" class="autonumeric number${detail.id} form-control">                    
                  </td>

                  <td class="data_tbl tbl_qty">
                    <input type="text"  name="detail_qty[]" id="detail_qty${detail.id}" onkeyup="calculate(${detail.id})" style="text-align:right" class="form-control autonumeric number${detail.id}">                    
                  </td>

                  <td class="data_tbl tbl_qtyterpakai">
                    <input type="text"  name="detail_qtyterpakai[]" id="detail_qtyterpakai${detail.id}" onkeyup="calculate(${detail.id})" style="text-align:right" class="form-control autonumeric number${detail.id}">
                  </td>

                  <td class="data_tbl tbl_vulkanisirke">
                    <input type="number"  name="detail_vulkanisirke[]" style="" class="form-control">                    
                  </td>
                  
                  <td class="data_tbl tbl_vulkanisirtotal">
                    <input type="number"  name="detail_vulkanisirtotal[]" readonly style="" class="form-control">                    
                  </td>


                  <td class="data_tbl tbl_total_sebelum">
                      <input type="text"  name="total_sebelum[]" id="total_sebelum${detail.id}" style="text-align:right"  onkeyup="calculate(${detail.id})" class="form-control total_sebelum autonumeric number${detail.id}" >
                    </td>


                  <td class="data_tbl tbl_persentase">
                    <input type="text"  name="detail_persentasediscount[]" id="detail_persentasediscount${detail.id}" onkeyup="calculate(${detail.id})" style="text-align:right" class="autonumeric number${detail.id} form-control">                    
                  </td>  

                  <td class="data_tbl tbl_nominaldiscount">
                    <input type="text"  name="detail_nominaldiscount[]" id="detail_nominaldiscount${detail.id}" onkeyup="calculate_nominal(${detail.id})" style="text-align:right" class="autonumeric number${detail.id} form-control">                    
                  </td>  

                  <td class="data_tbl tbl_total">
                    <input type="text"  name="totalItem[]" id="totalItem${detail.id}" style="text-align:right" onkeyup="calculate(${detail.id})" class="form-control totalItem autonumeric number${detail.id}">                    
                  </td>

                  <td class="tbl_aksi">
                    <div class='btn btn-danger btn-sm rmv'>Delete</div>
                  </td>
              </tr>
          `)
          detailRow.find(`[name="detail_nobukti[]"]`).val(detail.nobukti)
          detailRow.find(`[name="detail_stok[]"]`).val(detail.stok)
          detailRow.find(`[name="detail_stok[]"]`).data('currentValue', detail.stok)
          detailRow.find(`[name="detail_stok_id[]"]`).val(detail.stok_id)
          detailRow.find(`[name="detail_qty[]"]`).val(detail.qty)
          detailRow.find(`[name="detail_harga[]"]`).val(detail.harga)
          detailRow.find(`[name="detail_persentasediscount[]"]`).val(detail.persentasediscount)
          detailRow.find(`[name="detail_vulkanisirke[]"]`).val(detail.vulkanisirke)
          detailRow.find(`[name="totalItem[]"]`).val(detail.total)
          detailRow.find(`[name="detail_keterangan[]"]`).val(detail.keterangan)
          $('table #table_body').append(detailRow)
          initAutoNumeric($(`.number${detail.id}`))
          setRowNumbers()
          $(`#detail_stok_${detail.id}`).lookupV3({
            title: 'stok Lookup',
            fileName: 'stokV3',
            searching: ['namastok'],
            extendSize: md_extendSize_1,
            multiColumnSize:true,
            labelColumn: false,
            beforeProcess: function(test) {
              var penerimaanstokId = $(`#penerimaanstokId`).val();
              var penerimaanstok_nobukti = $('#crudModal').find(`[name=penerimaanstok_nobukti]`).val();
              var nobukti = $('#crudModal').find(`[name=nobukti]`).val();
              cekKelompok(id);
              this.postData = {
                from: 'penerimaanstok',
                penerimaanstok_id: penerimaanstokId,
                penerimaanstokheader_nobukti: penerimaanstok_nobukti,
                nobukti : nobukti,
                Aktif: 'AKTIF',
                KelompokId: KelompokId,
                StokId: StokId,
                isLookup: true
              }
            },
            onSelectRow: (stok, element) => {
              element.val(stok.namastok)

              let satuanEl = element.parents('tr').find(`td [name="detail_satuan[]"]`);
              satuanEl.val(stok.satuan);

              parent = element.closest('td');
              parent.children('.detailstokId').val(stok.id)
              parent.children('.detailstokKelompok').val(stok.kelompok_id)
              element.data('currentValue', element.val())
            },
            onCancel: (element) => {
              element.val(element.data('currentValue'))
            },
            onClear: (element) => {
              let satuanEl = element.parents('tr').find(`td [name="detail_satuan[]"]`);
              satuanEl.val('');
              let iddetailEl = element.parents('tr').find(`td [name="id_detail[]"]`);
              iddetailEl.val(0);


              element.val('')
              parent = element.closest('td');
              parent.children('.detailpenerimaanstoknobuktiId').val('')
              element.data('currentValue', element.val())
            }
          })
          $(`#detail_penerimaanstoknobukti_${detail.id}`).lookup({
            title: 'penerimaan stok header Lookup',
            fileName: 'penerimaanstokheader',
            beforeProcess: function(test) {
              var penerimaanstokId = $(`#penerimaanstokId`).val();
              this.postData = {
                penerimaanstok_id: penerimaanstokId,
              }
            },
            onSelectRow: (penerimaan, element) => {
              parent = element.closest('td');
              parent.children('.detailpenerimaanstoknobuktiId').val(penerimaan.id)
              element.val(penerimaan.nobukti)
            },
            onCancel: (element) => {
              element.val(element.data('currentValue'))
            },
            onClear: (element) => {
              element.val('')
              parent = element.closest('td');
              parent.children('.detailstokId').val('')
              element.data('currentValue', element.val())
            }
          })
          id++;
        })
        sumary()
        setTampilanForm()
        // if (KodePenerimaanId === listKodePenerimaan[2]) {
        //   $('#addRow').hide()
        // } else {
        $('#addRow').show()
        // }
      },
      error: error => {
        showDialog(error.statusText)
      }
    })
  }

  function setDetailSPBP(penerimaan_id) {
    $.ajax({
      url: `${apiUrl}penerimaanstokheader/${penerimaan_id}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        'Authorization': `Bearer ${accessToken}`
      },
      success: response => {
        $('#detailList tbody').html('')
        resetRow()

        $.each(response.detail, (id, detail) => {

          let detailRow = $(`
            <tr class="trow" data-id="${id}">
                  <td>
                    <div class="baris">1</div>
                  </td>
                  
                  <td>
                    <input type="text"  name="detail_stok[]" id="detail_stok_${id}" class="form-control stok-lookup ">
                    <input type="text" id="detailstokId_${id}" readonly hidden class="detailstokId" name="detail_stok_id[]">
                    <input type="text" id="detailstokKelompok_${id}" value="${detail.kelompok_id}" readonly hidden class="detailstokKelompok" name="detail_stok_kelompok[]">
                  </td>
                  <td>
                    <input type="text" disabled name="detail_satuan[]" id="" value="${detail.satuan}" class="form-control detail_satuan_${id}">
                  </td> 
                  <td>
                    <textarea class="form-control" name="detail_keterangan[]" rows="1" placeholder=""></textarea>    
                  </td>
                  
                  <td class="data_tbl tbl_penerimaanstok_nobukti">
                    <input type="text"  name="detail_penerimaanstoknobukti[]" id="detail_penerimaanstoknobukti_${id}" class="form-control ">
                    <input type="text" id="detailpenerimaanstoknobuktiId_${id}" readonly hidden class="detailpenerimaanstoknobuktiId" name="detail_penerimaanstoknobukti_id[]">
                  </td>  

                  <td class="data_tbl tbl_harga">
                    <input type="text"  name="detail_harga[]" readonly id="detail_harga${id}" style="text-align:right" class="autonumeric number${id} form-control">                    
                  </td>

                  <td class="data_tbl tbl_qty">
                    <input type="text"  name="detail_qty[]" id="detail_qty${id}" onkeyup="calculate(${id})" style="text-align:right" class="form-control autonumeric number${id}">                    
                  </td>

                  <td class="data_tbl tbl_qtyterpakai">
                    <input type="text"  name="detail_qtyterpakai[]" id="detail_qtyterpakai${id}" onkeyup="calculate(${id})" style="text-align:right" class="form-control autonumeric number${id}">
                  </td>

                  <td class="data_tbl tbl_vulkanisirke">
                    <input type="number"  name="detail_vulkanisirke[]" style="" class="form-control">                    
                  </td>

                  <td class="data_tbl tbl_vulkanisirtotal">
                    <input type="number"  name="detail_vulkanisirtotal[]" readonly style="" class="form-control">                    
                  </td>

                  <td class="data_tbl tbl_persentase">
                    <input type="text"  name="detail_persentasediscount[]" id="detail_persentasediscount${id}" onkeyup="calculate(${id})" style="text-align:right" class="autonumeric number${id} form-control">                    
                  </td>  

                  <td class="data_tbl tbl_nominaldiscount">
                    <input type="text"  name="detail_nominaldiscount[]" id="detail_nominaldiscount${id}" onkeyup="calculate_nominal(${id})" style="text-align:right" class="autonumeric number${id} form-control">                    
                  </td>  

                  <td class="data_tbl tbl_total">
                    <input type="text"  name="totalItem[]" id="totalItem${id}" style="text-align:right" onkeyup="calculate(${id})" class="form-control totalItem autonumeric number${id}">                    
                  </td>

                  <td class="tbl_aksi">
                    <div class='btn btn-danger btn-sm rmv'>Delete</div>
                  </td>
              </tr>
          `)
          // detailRow.find(`[name="detail_nobukti[]"]`).val(detail.nobukti)
          detailRow.find(`[name="detail_stok[]"]`).val(detail.stok)
          detailRow.find(`[name="detail_stok[]"]`).data('currentValue', detail.stok)
          detailRow.find(`[name="detail_stok_id[]"]`).val(detail.stok_id)

          detailRow.find(`[name="detail_qty[]"]`).val(0)
          detailRow.find(`[name="detail_harga[]"]`).val(0)
          detailRow.find(`[name="detail_persentasediscount[]"]`).val(0)
          detailRow.find(`[name="detail_vulkanisirke[]"]`).val(0)
          detailRow.find(`[name="totalItem[]"]`).val(0)

          detailRow.find(`[name="detail_qty[]"]`).prop('readonly', true)
          detailRow.find(`[name="detail_harga[]"]`).prop('readonly', true)
          detailRow.find(`[name="detail_persentasediscount[]"]`).prop('readonly', true)
          detailRow.find(`[name="detail_vulkanisirke[]"]`).prop('readonly', true)
          detailRow.find(`[name="totalItem[]"]`).prop('readonly', true)


          detailRow.find(`[name="detail_keterangan[]"]`).val(detail.keterangan)
          $('table #table_body').append(detailRow)
          initAutoNumeric($(`.number${id}`))
          setRowNumbers()
          $(`#detail_stok_${id}`).lookupV3({
            title: 'stok Lookup',
            fileName: 'stokV3',
            searching: ['namastok'],
            extendSize: md_extendSize_1,
            multiColumnSize:true,
            labelColumn: false,
            beforeProcess: function(test) {
              var penerimaanstokId = $(`#penerimaanstokId`).val();
              var penerimaanstok_nobukti = $('#crudModal').find(`[name=penerimaanstok_nobukti]`).val();
              var nobukti = $('#crudModal').find(`[name=nobukti]`).val();
              cekKelompok(row);
              this.postData = {
                from: 'penerimaanstok',
                penerimaanstok_id: penerimaanstokId,
                penerimaanstokheader_nobukti: penerimaanstok_nobukti,
                nobukti : nobukti,
                Aktif: 'AKTIF',
                KelompokId: KelompokId,
                StokId: StokId,
                isLookup: true
              }
            },
            onSelectRow: (stok, element) => {
              element.val(stok.namastok)

              let satuanEl = element.parents('tr').find(`td [name="detail_satuan[]"]`);
              satuanEl.val(stok.satuan);
              let iddetailEl = element.parents('tr').find(`td [name="id_detail[]"]`);
              iddetailEl.val(stok.iddetail);


              parent = element.closest('td');
              parent.children('.detailstokId').val(stok.id)
              parent.children('.detailstokKelompok').val(stok.kelompok_id)
              element.data('currentValue', element.val())
            },
            onCancel: (element) => {
              element.val(element.data('currentValue'))
            },
            onClear: (element) => {
              let satuanEl = element.parents('tr').find(`td [name="detail_satuan[]"]`);
              satuanEl.val('');
              let iddetailEl = element.parents('tr').find(`td [name="id_detail[]"]`);
              iddetailEl.val(0);


              element.val('')
              parent = element.closest('td');
              parent.children('.detailpenerimaanstoknobuktiId').val('')
              element.data('currentValue', element.val())
            }
          })
          $(`#detail_penerimaanstoknobukti_${id}`).lookup({
            title: 'penerimaan stok header Lookup',
            fileName: 'penerimaanstokdetail',
            beforeProcess: function(test) {
              var penerimaanstokId = $(`#penerimaanstokId`).val();
              var detailstok = $(`#detailstokId_${id}`).val()
              this.postData = {
                penerimaanstok_id: penerimaanstokId,
                // penerimaanstokheader_id: null,
                stok_id: detailstok,
              }
            },
            onSelectRow: (penerimaan, element) => {
              parent = element.closest('td');
              parent.children('.detailpenerimaanstoknobuktiId').val(penerimaan.id)
              element.val(penerimaan.nobukti)

              detailRow.find(`[name="detail_qty[]"]`).val(penerimaan.qty)
              detailRow.find(`[name="detail_harga[]"]`).val(penerimaan.harga)
              detailRow.find(`[name="detail_persentasediscount[]"]`).val(penerimaan.persentasediscount)
              detailRow.find(`[name="detail_vulkanisirke[]"]`).val(penerimaan.vulkanisirke)
              detailRow.find(`[name="totalItem[]"]`).val(penerimaan.total)

              initAutoNumeric(detailRow.find(`[name="detail_qty[]"]`))
              initAutoNumeric(detailRow.find(`[name="detail_harga[]"]`))
              initAutoNumeric(detailRow.find(`[name="detail_persentasediscount[]"]`))
              initAutoNumeric(detailRow.find(`[name="totalItem[]"]`))
              sumary()
            },
            onCancel: (element) => {
              element.val(element.data('currentValue'))
            },
            onClear: (element) => {
              element.val('')
              parent = element.closest('td');
              parent.children('.detailstokId').val('')
              element.data('currentValue', element.val())
            }
          })
        })
        sumary()
        setTampilanForm()
        $('#addRow').hide()

      },
      error: error => {
        showDialog(error.statusText)
      }
    })
  }

  function setShowDetailSPBP(data) {
    resetRow()
    $.each(data, (id, detail) => {

      let detailRow = $(`
        <tr class="trow" data-id="${id}">
              <td>
                <div class="baris">1</div>
              </td>
              
              <td>
                <input name="id_detail[]" hidden value="${detail.id}">
                <input type="text"  name="detail_stok[]" id="detail_stok_${id}" class="form-control stok-lookup ">
                <input type="text" id="detailstokId_${id}" readonly hidden class="detailstokId" name="detail_stok_id[]">
                <input type="text" id="detailstokKelompok_${id}" value="${detail.kelompok_id}"  readonly hidden class="detailstokKelompok" name="detail_stok_kelompok[]">
              </td>
              <td>
                <input type="text" disabled name="detail_satuan[]" id="" value="${detail.satuan}"  class="form-control detail_satuan_${id}">
              </td> 
              <td>
                <textarea class="form-control" name="detail_keterangan[]" rows="1" placeholder=""></textarea>
              </td>
              
              <td class="data_tbl tbl_penerimaanstok_nobukti">
                <input type="text"  name="detail_penerimaanstoknobukti[]" id="detail_penerimaanstoknobukti_${id}" class="form-control ">
                <input type="text" id="detailpenerimaanstoknobuktiId_${id}" readonly hidden class="detailpenerimaanstoknobuktiId" name="detail_penerimaanstoknobukti_id[]">
              </td>  

              <td class="data_tbl tbl_harga">
                <input type="text"  name="detail_harga[]" readonly id="detail_harga${id}" style="text-align:right" class="autonumeric number${id} form-control">                    
              </td>

              <td class="data_tbl tbl_qty">
                <input type="text"  name="detail_qty[]" id="detail_qty${id}" onkeyup="calculate(${id})" style="text-align:right" class="form-control autonumeric number${id}">                    
              </td>

              <td class="data_tbl tbl_qtyterpakai">
                <input type="text"  name="detail_qtyterpakai[]" id="detail_qtyterpakai${id}" onkeyup="calculate(${id})" style="text-align:right" class="form-control autonumeric number${id}">
              </td>

              <td class="data_tbl tbl_vulkanisirke">
                <input type="number"  name="detail_vulkanisirke[]" style="" class="form-control">                    
              </td>

              <td class="data_tbl tbl_vulkanisirtotal">
                    <input type="number"  name="detail_vulkanisirtotal[]" readonly style="" class="form-control">                    
                  </td>

              <td class="data_tbl tbl_persentase">
                <input type="text"  name="detail_persentasediscount[]" id="detail_persentasediscount${id}" onkeyup="calculate(${id})" style="text-align:right" class="autonumeric number${id} form-control">                    
              </td>  

              <td class="data_tbl tbl_nominaldiscount">
                <input type="text"  name="detail_nominaldiscount[]" id="detail_nominaldiscount${id}" onkeyup="calculate_nominal(${id})" style="text-align:right" class="autonumeric number${id} form-control">                    
              </td>  

              <td class="data_tbl tbl_total">
                <input type="text"  name="totalItem[]" id="totalItem${id}" style="text-align:right" onkeyup="calculate(${id})" class="form-control totalItem autonumeric number${id}">                    
              </td>

              <td class="tbl_aksi">
                <div class='btn btn-danger btn-sm rmv'>Delete</div>
              </td>
          </tr>
      `)
      // detailRow.find(`[name="detail_nobukti[]"]`).val(detail.nobukti)
      detailRow.find(`[name="detail_stok[]"]`).val(detail.stok)
      detailRow.find(`[name="detail_stok[]"]`).data('currentValue', detail.stok)
      detailRow.find(`[name="detail_stok_id[]"]`).val(detail.stok_id)

      detailRow.find(`[name="detail_penerimaanstoknobukti[]"]`).val(detail.penerimaanstok_nobukti)
      detailRow.find(`[name="detail_penerimaanstoknobukti[]"]`).data('currentValue', detail.penerimaanstok_nobukti)
      // element.data('currentValue', value)
      detailRow.find(`[name="detail_qty[]"]`).val(detail.qty)
      detailRow.find(`[name="detail_harga[]"]`).val(detail.harga)
      detailRow.find(`[name="detail_persentasediscount[]"]`).val(detail.persentasediscount)
      detailRow.find(`[name="detail_vulkanisirke[]"]`).val(detail.vulkanisirke)
      detailRow.find(`[name="totalItem[]"]`).val(detail.total)

      detailRow.find(`[name="detail_qty[]"]`).prop('readonly', true)
      detailRow.find(`[name="detail_harga[]"]`).prop('readonly', true)
      detailRow.find(`[name="detail_persentasediscount[]"]`).prop('readonly', true)
      detailRow.find(`[name="detail_vulkanisirke[]"]`).prop('readonly', true)
      detailRow.find(`[name="totalItem[]"]`).prop('readonly', true)


      detailRow.find(`[name="detail_keterangan[]"]`).val(detail.keterangan)
      $('table #table_body').append(detailRow)
      initAutoNumeric($(`.number${id}`))
      setRowNumbers()
      $(`#detail_stok_${id}`).lookupV3({
        title: 'stok Lookup',
        fileName: 'stokV3',
        searching: ['namastok'],
        extendSize: md_extendSize_1,
        multiColumnSize:true,
        labelColumn: false,
        beforeProcess: function(test) {
          var penerimaanstokId = $(`#penerimaanstokId`).val();
          var penerimaanstok_nobukti = $('#crudModal').find(`[name=penerimaanstok_nobukti]`).val();
          var nobukti = $('#crudModal').find(`[name=nobukti]`).val();
          cekKelompok(row);
          this.postData = {
            from: 'penerimaanstok',
            penerimaanstok_id: penerimaanstokId,
            penerimaanstokheader_nobukti: penerimaanstok_nobukti,
            nobukti : nobukti,
            Aktif: 'AKTIF',
            KelompokId: KelompokId,
            StokId: StokId,
            isLookup: true
          }
        },
        onSelectRow: (stok, element) => {
          element.val(stok.namastok)

          let satuanEl = element.parents('tr').find(`td [name="detail_satuan[]"]`);
          satuanEl.val(stok.satuan);
          let iddetailEl = element.parents('tr').find(`td [name="id_detail[]"]`);
          iddetailEl.val(stok.iddetail);


          parent = element.closest('td');
          parent.children('.detailstokId').val(stok.id)
          parent.children('.detailstokKelompok').val(stok.kelompok_id)
          element.data('currentValue', element.val())
        },
        onCancel: (element) => {
          element.val(element.data('currentValue'))
        },
        onClear: (element) => {
          let satuanEl = element.parents('tr').find(`td [name="detail_satuan[]"]`);
          satuanEl.val('');
          let iddetailEl = element.parents('tr').find(`td [name="id_detail[]"]`);
        iddetailEl.val(0);


          element.val('')
          parent = element.closest('td');
          parent.children('.detailpenerimaanstoknobuktiId').val('')
          element.data('currentValue', element.val())
        }
      })
      $(`#detail_penerimaanstoknobukti_${id}`).lookup({
        title: 'penerimaan stok header Lookup',
        fileName: 'penerimaanstokdetail',
        beforeProcess: function(test) {
          console.log($(`#detail_penerimaanstoknobukti_${id}`).val());
          var penerimaanstoknobukti = $(`#detail_penerimaanstoknobukti_${id}`).val();
          var penerimaanstokId = $(`#penerimaanstokId`).val();
          var detailstok = $(`#detailstokId_${id}`).val()
          this.postData = {
            penerimaanstok_id: penerimaanstokId,
            nobukti: penerimaanstoknobukti,
            stok_id: detailstok,
          }
        },
        onSelectRow: (penerimaan, element) => {
          parent = element.closest('td');
          parent.children('.detailpenerimaanstoknobuktiId').val(penerimaan.id)
          element.val(penerimaan.nobukti)

          detailRow.find(`[name="detail_qty[]"]`).val(penerimaan.qty)
          detailRow.find(`[name="detail_harga[]"]`).val(penerimaan.harga)
          detailRow.find(`[name="detail_persentasediscount[]"]`).val(penerimaan.persentasediscount)
          detailRow.find(`[name="detail_vulkanisirke[]"]`).val(penerimaan.vulkanisirke)
          detailRow.find(`[name="totalItem[]"]`).val(penerimaan.total)

          initAutoNumeric(detailRow.find(`[name="detail_qty[]"]`))
          initAutoNumeric(detailRow.find(`[name="detail_harga[]"]`))
          initAutoNumeric(detailRow.find(`[name="detail_persentasediscount[]"]`))
          initAutoNumeric(detailRow.find(`[name="totalItem[]"]`))
          sumary()
        },
        onCancel: (element) => {
          element.val(element.data('currentValue'))
        },
        onClear: (element) => {
          element.val('')
          parent = element.closest('td');
          parent.children('.detailstokId').val('')
          element.data('currentValue', element.val())
        }
      })
    })
    setTampilanForm()
    $('#addRow').hide()

  }

  function setDetailPengeluaran(pengeluaran_id) {
    $.ajax({
      url: `${apiUrl}pengeluaranstokheader/${pengeluaran_id}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        'Authorization': `Bearer ${accessToken}`
      },
      success: response => {
        $('#detailList tbody').html('')
        resetRow()
        $.each(response.detail, (id, detail) => {
          let detailRow = $(`
            <tr class="trow" data-id="${index}">
                  <td>
                    <div class="baris">1</div>
                  </td>
                  
                  <td>
                    <input type="text"  name="detail_stok[]" id="detail_stok_${id}" class="form-control stok-lookup ">
                    <input type="text" id="detailstokId_${id}" readonly hidden class="detailstokId" name="detail_stok_id[]">
                    <input type="text" id="detailstokKelompok_${id}" value="${detail.kelompok_id}" readonly hidden class="detailstokKelompok" name="detail_stok_kelompok[]">
                  </td>
                  <td>
                    <input type="text" disabled name="detail_satuan[]" id="" value="${detail.satuan}"  class="form-control detail_satuan_${id}">
                  </td> 
                  <td>
                    <textarea class="form-control" name="detail_keterangan[]" rows="1" placeholder=""></textarea>
                  </td>
                  
                  <td class="data_tbl tbl_penerimaanstok_nobukti">
                    <input type="text"  name="detail_penerimaanstoknobukti[]" id="detail_penerimaanstoknobukti_${id}" class="form-control ">
                    <input type="text" id="detailpenerimaanstoknobuktiId_${id}" readonly hidden class="detailpenerimaanstoknobuktiId" name="detail_penerimaanstoknobukti_id[]">
                  </td>  

                  <td class="data_tbl tbl_harga">
                    <input type="text"  name="detail_harga[]" readonly id="detail_harga${id}" onkeyup="cal(${id})"  style="text-align:right" class="autonumeric number${id} form-control">                    
                  </td>

                  <td class="data_tbl tbl_qty">
                    <input type="text"  name="detail_qty[]" id="detail_qty${id}" onkeyup="cal(${id})" style="text-align:right" class="form-control autonumeric number${id}">                    
                  </td>
                  
                  <td class="data_tbl tbl_qtyterpakai">
                    <input type="text"  name="detail_qtyterpakai[]" id="detail_qtyterpakai${id}" onkeyup="cal(${id})" style="text-align:right" class="form-control autonumeric number${id}">
                  </td>
                  
                  <td class="data_tbl tbl_vulkanisirke">
                    <input type="number"  name="detail_vulkanisirke[]" style="" max="100" class="form-control">                    
                  </td> 
                  
                  <td class="data_tbl tbl_vulkanisirtotal">
                    <input type="number"  name="detail_vulkanisirtotal[]" readonly style="" max="100" class="form-control">                    
                  </td>
                  
                  <td class="data_tbl tbl_persentase">
                    <input type="text"  name="detail_persentasediscount[]" id="detail_persentasediscount${id}" onkeyup="calculate(${id})" style="text-align:right" class="autonumeric number${id} form-control">                    
                  </td>  

                  <td class="data_tbl tbl_nominaldiscount">
                    <input type="text"  name="detail_nominaldiscount[]" id="detail_nominaldiscount${id}" onkeyup="calculate_nominal(${id})" style="text-align:right" class="autonumeric number${id} form-control">                    
                  </td>  

                  <td class="data_tbl tbl_total">
                    <input type="text"  name="totalItem[]" id="totalItem${id}" style="text-align:right" class="form-control totalItem autonumeric number${id}">                    
                  </td>

                  <td class="tbl_aksi">
                    <div class='btn btn-danger btn-sm rmv'>Delete</div>
                  </td>
              </tr>
          `)
          if (KodePenerimaanId === listKodePenerimaan[7]) {
            detailRow.find(`[name="detail_harga[]"]`).prop('readonly', true);
            detailRow.find(`[name="detail_persentasediscount[]"]`).prop('readonly', true);
            detailRow.find(`[name="totalItem[]"]`).prop('readonly', true);
            detailRow.find(`[name="detail_qty[]"]`).prop('readonly', true);
            detailRow.find(`[name="detail_qty[]"]`).val(detail.qty)
            detailRow.find(`[name="detail_qtyterpakai[]"]`).val(detail.qty)
          } else {
            detailRow.find(`[name="detail_harga[]"]`).prop('readonly', true);
            detailRow.find(`[name="detail_persentasediscount[]"]`).prop('readonly', true);
            detailRow.find(`[name="totalItem[]"]`).prop('readonly', true);
            detailRow.find(`[name="detail_qty[]"]`).prop('readonly', false);
            detailRow.find(`[name="detail_qty[]"]`).val(0)
            detailRow.find(`[name="totalItem[]"]`).val(0)
          }
          detailRow.find(`[name="detail_nobukti[]"]`).val(detail.nobukti)
          detailRow.find(`[name="detail_stok[]"]`).val(detail.stok)
          detailRow.find(`[name="detail_stok[]"]`).data('currentValue', detail.stok)
          detailRow.find(`[name="detail_stok_id[]"]`).val(detail.stok_id)

          detailRow.find(`[name="detail_harga[]"]`).val(detail.harga)
          detailRow.find(`[name="detail_persentasediscount[]"]`).val(detail.persentasediscount)
          detailRow.find(`[name="detail_vulkanisirke[]"]`).val(detail.vulkanisirke)
          // detailRow.find(`[name="totalItem[]"]`).val(detail.total)
          detailRow.find(`[name="detail_keterangan[]"]`).val(detail.keterangan)
          $('table #table_body').append(detailRow)
          initAutoNumeric($(`#detail_harga${id}`))
          initAutoNumeric($(`#detail_persentasediscount${id}`))
          initAutoNumeric($(`#totalItem${id}`))
          initAutoNumeric($(`#detail_qty${id}`), {
            'maximumValue': detail.qty
          })
          initAutoNumeric($(`#detail_qtyterpakai${id}`), {
            'maximumValue': detail.qty
          })
          cal(id)
          setRowNumbers()
          $(`#detail_penerimaanstoknobukti_${id}`).lookup({
            title: 'penerimaan stok header Lookup',
            fileName: 'penerimaanstokheader',
            beforeProcess: function(test) {
              var penerimaanstokId = $(`#penerimaanstokId`).val();
              this.postData = {
                penerimaanstok_id: penerimaanstokId,
              }
            },
            onSelectRow: (penerimaan, element) => {
              parent = element.closest('td');
              parent.children('.detailpenerimaanstoknobuktiId').val(penerimaan.id)
              element.val(penerimaan.nobukti)
            },
            onCancel: (element) => {
              element.val(element.data('currentValue'))
            },
            onClear: (element) => {
              element.val('')
              parent = element.closest('td');
              parent.children('.detailstokId').val('')
              element.data('currentValue', element.val())
            }
          })
          id++;
        })
        sumary()
        setTampilanForm()
        if ((KodePenerimaanId === listKodePenerimaan[7]) || (KodePenerimaanId === listKodePenerimaan[8])) {
          $('#addRow').hide()
          $('.tbl_aksi').hide()
          if (KodePenerimaanId === listKodePenerimaan[8]) {
            $('.tbl_persentase').hide()
            $('.tbl_nominaldiscount').hide()
            $('.colspan').attr('colspan', 5);
          }
        } else {
          $('#addRow').show()
        }
      },
      error: error => {
        showDialog(error.statusText)
      }
    })
  }

  function setShowDetailPengeluaran(idpenerimaan, kodepenerimaan) {
    resetRow()
    $.ajax({
      url: `${apiUrl}penerimaanstokheader/${idpenerimaan}/pengeluaranstoknobukti`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        'Authorization': `Bearer ${accessToken}`
      },
      success: response => {
        $('#detailList tbody').html('')

        $.each(response.detail, (id, detail) => {
          console.log(detail.maximum);
          let detailRow = $(`
            <tr class="trow" data-id="${id}">
                  <td>
                    <div class="baris">1</div>
                  </td>
                  
                  <td>
                    <input name="id_detail[]" hidden value="${detail.id}">
                    <input type="text"  name="detail_stok[]" id="detail_stok_${id}" class="form-control stok-lookup ">
                    <input type="text" id="detailstokId_${id}" readonly hidden class="detailstokId" name="detail_stok_id[]">
                    <input type="text" id="detailstokKelompok_${id}" value="${detail.kelompok_id}" readonly hidden class="detailstokKelompok" name="detail_stok_kelompok[]">
                  </td>
                  <td>
                    <input type="text" disabled name="detail_satuan[]" id="" value="${detail.satuan}" class="form-control detail_satuan_${id}">
                  </td> 
                  <td>
                    <textarea class="form-control" name="detail_keterangan[]" rows="1" placeholder=""></textarea>
                  </td>
                  
                  <td class="data_tbl tbl_penerimaanstok_nobukti">
                    <input type="text"  name="detail_penerimaanstoknobukti[]" id="detail_penerimaanstoknobukti_${id}" class="form-control ">
                    <input type="text" id="detailpenerimaanstoknobuktiId_${id}" readonly hidden class="detailpenerimaanstoknobuktiId" name="detail_penerimaanstoknobukti_id[]">
                  </td>  
    
                  <td class="data_tbl tbl_harga">
                    <input type="text"  name="detail_harga[]" readonly id="detail_harga${id}" onkeyup="calculate(${id})"  style="text-align:right" class="autonumeric number${id} form-control">                    
                  </td>
    
                  <td class="data_tbl tbl_qty">
                    <input type="text"  name="detail_qty[]" id="detail_qty${id}" onkeyup="calculate(${id})" style="text-align:right" class="form-control autonumeric number${id}">                    
                  </td>  

                  <td class="data_tbl tbl_qtyterpakai">
                    <input type="text"  name="detail_qtyterpakai[]" id="detail_qtyterpakai${id}" onkeyup="calculate(${id})" style="text-align:right" class="form-control autonumeric number${id}">
                  </td>

                  <td class="data_tbl tbl_vulkanisirke">
                    <input type="number"  name="detail_vulkanisirke[]" style="" max="100" class="form-control">                    
                  </td>
                  
                  <td class="data_tbl tbl_vulkanisirtotal">
                    <input type="number"  name="detail_vulkanisirtotal[]" readonly style="" max="100" class="form-control">                    
                  </td>
                  
                  <td class="data_tbl tbl_persentase">
                    <input type="text"  name="detail_persentasediscount[]" id="detail_persentasediscount${id}" onkeyup="calculate(${id})" style="text-align:right" class="autonumeric number${id} form-control">                    
                  </td>  

                  <td class="data_tbl tbl_nominaldiscount">
                    <input type="text"  name="detail_nominaldiscount[]" id="detail_nominaldiscount${id}" onkeyup="calculate_nominal(${id})" style="text-align:right" class="autonumeric number${id} form-control">
                  </td>
    
                  <td class="data_tbl tbl_total">
                    <input type="text"  name="totalItem[]" id="totalItem${id}" style="text-align:right" class="form-control totalItem autonumeric number${id}">                    
                  </td>
    
                  <td class="tbl_aksi">
                    <div class='btn btn-danger btn-sm rmv'>Delete</div>
                  </td>
              </tr>
          `)
          if (KodePenerimaanId === listKodePenerimaan[7]) {
            detailRow.find(`[name="detail_harga[]"]`).prop('readonly', true);
            detailRow.find(`[name="detail_persentasediscount[]"]`).prop('readonly', true);
            detailRow.find(`[name="totalItem[]"]`).prop('readonly', true);
            detailRow.find(`[name="detail_qty[]"]`).prop('readonly', true);
            detailRow.find(`[name="detail_qty[]"]`).val(detail.qty)
          } else {
            detailRow.find(`[name="detail_harga[]"]`).prop('readonly', true);
            detailRow.find(`[name="detail_persentasediscount[]"]`).prop('readonly', true);
            detailRow.find(`[name="totalItem[]"]`).prop('readonly', true);
            detailRow.find(`[name="detail_qty[]"]`).prop('readonly', false);
            detailRow.find(`[name="detail_qty[]"]`).val(0)
            detailRow.find(`[name="totalItem[]"]`).val(0)
          }
          detailRow.find(`[name="detail_nobukti[]"]`).val(detail.nobukti)
          detailRow.find(`[name="detail_stok[]"]`).val(detail.stok)
          detailRow.find(`[name="detail_stok[]"]`).data('currentValue', detail.stok)
          detailRow.find(`[name="detail_stok_id[]"]`).val(detail.stok_id)
          detailRow.find(`[name="detail_qty[]"]`).val(detail.qty)

          detailRow.find(`[name="detail_harga[]"]`).val(detail.harga)
          detailRow.find(`[name="detail_persentasediscount[]"]`).val(detail.persentasediscount)
          detailRow.find(`[name="detail_vulkanisirke[]"]`).val(detail.vulkanisirke)
          // detailRow.find(`[name="totalItem[]"]`).val(detail.total)
          detailRow.find(`[name="detail_keterangan[]"]`).val(detail.keterangan)
          $('table #table_body').append(detailRow)
          initAutoNumeric($(`#detail_harga${id}`))
          initAutoNumeric($(`#detail_persentasediscount${id}`))
          initAutoNumeric($(`#totalItem${id}`))
          initAutoNumeric($(`#detail_qty${id}`), {
            'maximumValue': detail.maximum
          })


          setRowNumbers()
          id++;
        })
        setTampilanForm()
      },
    })
  }

  function lookupSelectedDari(el) {
    let trado = $('#crudForm').find(`[name="trado"]`).parents('.input-group').children()
    let tradodari = $('#crudForm').find(`[name="tradodari"]`).parents('.input-group').children()
    let gandengan = $('#crudForm').find(`[name="gandengan"]`).parents('.input-group').children()
    let gandengandari = $('#crudForm').find(`[name="gandengandari"]`).parents('.input-group').children()
    let gudang = $('#crudForm').find(`[name="gudang"]`).parents('.input-group').children()
    let gudangdari = $('#crudForm').find(`[name="gudangdari"]`).parents('.input-group').children()
    let tradoke = $('#crudForm').find(`[name="tradoke"]`).parents('.input-group').children()
    let gandenganke = $('#crudForm').find(`[name="gandenganke"]`).parents('.input-group').children()
    let gudangke = $('#crudForm').find(`[name="gudangke"]`).parents('.input-group').children()



    switch (el) {
      case 'tradodari':
        gandengan.attr('disabled', true)
        gandengan.find('.lookup-toggler').attr('disabled', true)
        $('#gandenganId').attr('disabled', true);
        gandengandari.attr('disabled', true)
        gandengandari.find('.lookup-toggler').attr('disabled', true)
        $('#gandengandariId').attr('disabled', true);

        gudang.attr('disabled', true)
        gudang.find('.lookup-toggler').attr('disabled', true)
        $('#gudangId').attr('disabled', true);
        gudangdari.attr('disabled', true)
        gudangdari.find('.lookup-toggler').attr('disabled', true)
        $('#gudangdariId').attr('disabled', true);
        $('#tradodariId').attr('disabled', false);

        break;
      case 'gandengandari':
        trado.attr('disabled', true)
        trado.find('.lookup-toggler').attr('disabled', true)
        $('#tradoId').attr('disabled', true);
        tradodari.attr('disabled', true)
        tradodari.find('.lookup-toggler').attr('disabled', true)
        $('#tradodariId').attr('disabled', true);

        gudang.attr('disabled', true)
        gudang.find('.lookup-toggler').attr('disabled', true)
        $('#gudangId').attr('disabled', true);
        gudangdari.attr('disabled', true)
        gudangdari.find('.lookup-toggler').attr('disabled', true)
        $('#gudangdariId').attr('disabled', true);
        $('#gandengandariId').attr('disabled', false);

        break;
      case 'gudangdari':
        trado.attr('disabled', true)
        trado.find('.lookup-toggler').attr('disabled', true)
        $('#tradoId').attr('disabled', true);
        tradodari.attr('disabled', true)
        tradodari.find('.lookup-toggler').attr('disabled', true)
        $('#tradodariId').attr('disabled', true);

        gandengan.attr('disabled', true)
        gandengan.find('.lookup-toggler').attr('disabled', true)
        $('#gandenganId').attr('disabled', true);
        gandengandari.attr('disabled', true)
        gandengandari.find('.lookup-toggler').attr('disabled', true)
        $('#gandengandariId').attr('disabled', true);
        $('#gudangdariId').attr('disabled', false);

        // if (KodePenerimaanId == listKodePenerimaan[4]) {
        //   // GUDANG KANTOR
        //   if ($('#gudangdariId').val() == 1) {
        //     gudangke.attr('disabled', false)
        //     gudangke.find('.lookup-toggler').attr('disabled', false)
        //     $('#gudangkeId').attr('disabled', false);
        //     $('#gudangkeId').val('');
        //     $('#crudForm').find(`[name="gudangke"]`).val('');

        //     tradoke.attr('disabled', true)
        //     tradoke.find('.lookup-toggler').attr('disabled', true)
        //     $('#tradokeId').attr('disabled', true);

        //     gandenganke.attr('disabled', true)
        //     gandenganke.find('.lookup-toggler').attr('disabled', true)
        //     $('#gandengankeId').attr('disabled', true);
        //   }else{
        //     tradoke.attr('disabled', false)
        //     tradoke.find('.lookup-toggler').attr('disabled', false)
        //     $('#tradokeId').attr('disabled', false);

        //     gandenganke.attr('disabled', false)
        //     gandenganke.find('.lookup-toggler').attr('disabled', false)
        //     $('#gandengankeId').attr('disabled', false);
        //   }

        // }

        break;
      default:
        break;
    }
  }

  function lookupSelectedKe(el) {

    let tradoke = $('#crudForm').find(`[name="tradoke"]`).parents('.input-group').children()

    let gandenganke = $('#crudForm').find(`[name="gandenganke"]`).parents('.input-group').children()

    let gudangke = $('#crudForm').find(`[name="gudangke"]`).parents('.input-group').children()

    switch (el) {
      case 'tradoke':
        gandenganke.attr('disabled', true)
        gandenganke.find('.lookup-toggler').attr('disabled', true)
        $('#gandengankeId').attr('disabled', true);
        gudangke.attr('disabled', true)
        gudangke.find('.lookup-toggler').attr('disabled', true)
        $('#gudangkeId').attr('disabled', true);
        $('#tradokeId').attr('disabled', false);

        break;
      case 'gandenganke':
        tradoke.attr('disabled', true)
        tradoke.find('.lookup-toggler').attr('disabled', true)
        $('#tradokeId').attr('disabled', true);

        gudangke.attr('disabled', true)
        gudangke.find('.lookup-toggler').attr('disabled', true)
        $('#gudangkeId').attr('disabled', true);
        $('#gandengankeId').attr('disabled', false);

        break;
      case 'gudangke':
        tradoke.attr('disabled', true)
        tradoke.find('.lookup-toggler').attr('disabled', true)
        $('#tradokeId').attr('disabled', true);

        gandenganke.attr('disabled', true)
        gandenganke.find('.lookup-toggler').attr('disabled', true)
        $('#gandengankeId').attr('disabled', true);
        $('#gudangkeId').attr('disabled', false);

        break;
      default:
        break;
    }
  }

  function enabledLookupSelectedDari(lokasi = null, nilai = null) {

    let tradodari = $('#crudForm').find(`[name="tradodari"]`).parents('.input-group').children()
    let gandengandari = $('#crudForm').find(`[name="gandengandari"]`).parents('.input-group').children()
    let gudangdari = $('#crudForm').find(`[name="gudangdari"]`).parents('.input-group').children()

    tradodari.attr('disabled', false)
    tradodari.find('.lookup-toggler').attr('disabled', false)
    $('#tradodariId').attr('disabled', false);
    $('#tradodariId').val('');
    gudangdari.attr('disabled', false)
    gudangdari.find('.lookup-toggler').attr('disabled', false)
    $('#gudangdariId').attr('disabled', false);
    $('#gudangdariId').val('');
    gandengandari.attr('disabled', false)
    gandengandari.find('.lookup-toggler').attr('disabled', false)
    $('#gandengandariId').attr('disabled', false);
    $('#gandengandariId').val('');

    if (KodePenerimaanId == listKodePenerimaan[4]) {
      if (lokasi == 'gudang' && nilai == 1) {
        enabledLookupSelectedKe()
        $('#crudForm').find(`[name="gudangke"]`).val('');
      }
      // let tradoke = $('#crudForm').find(`[name="tradoke"]`).parents('.input-group').children()
      // let gandenganke = $('#crudForm').find(`[name="gandenganke"]`).parents('.input-group').children()
      // let gudangke = $('#crudForm').find(`[name="gudangke"]`).parents('.input-group').children()
    }

  }

  function enabledLookupSelectedKe() {

    let tradoke = $('#crudForm').find(`[name="tradoke"]`).parents('.input-group').children()
    let gandenganke = $('#crudForm').find(`[name="gandenganke"]`).parents('.input-group').children()
    let gudangke = $('#crudForm').find(`[name="gudangke"]`).parents('.input-group').children()

    tradoke.attr('disabled', false)
    tradoke.find('.lookup-toggler').attr('disabled', false)
    $('#tradokeId').attr('disabled', false);
    $('#tradokeId').val('');
    gudangke.attr('disabled', false)
    gudangke.find('.lookup-toggler').attr('disabled', false)
    $('#gudangkeId').attr('disabled', false);
    $('#gudangkeId').val('');
    gandenganke.attr('disabled', false)
    gandenganke.find('.lookup-toggler').attr('disabled', false)
    $('#gandengankeId').attr('disabled', false);
    $('#gandengankeId').val('');

  }

  function lookupSelected(el) {

    let trado = $('#crudForm').find(`[name="trado"]`).parents('.input-group').children()

    let gandengan = $('#crudForm').find(`[name="gandengan"]`).parents('.input-group').children()

    let gudang = $('#crudForm').find(`[name="gudang"]`).parents('.input-group').children()

    switch (el) {
      case 'trado':
        gandengan.attr('disabled', true)
        gandengan.find('.lookup-toggler').attr('disabled', true)
        $('#gandenganId').attr('disabled', true);
        gudang.attr('disabled', true)
        gudang.find('.lookup-toggler').attr('disabled', true)
        $('#gudangId').attr('disabled', true);
        $('#tradoId').attr('disabled', false);

        break;
      case 'gandengan':
        trado.attr('disabled', true)
        trado.find('.lookup-toggler').attr('disabled', true)
        $('#tradoId').attr('disabled', true);

        gudang.attr('disabled', true)
        gudang.find('.lookup-toggler').attr('disabled', true)
        $('#gudangId').attr('disabled', true);
        $('#gandenganId').attr('disabled', false);

        break;
      case 'gudang':
        trado.attr('disabled', true)
        trado.find('.lookup-toggler').attr('disabled', true)
        $('#tradoId').attr('disabled', true);

        gandengan.attr('disabled', true)
        gandengan.find('.lookup-toggler').attr('disabled', true)
        $('#gandenganId').attr('disabled', true);
        $('#gudangId').attr('disabled', false);

        break;
      default:
        break;
    }
  }

  function enabledLookupSelected() {
    let trado = $('#crudForm').find(`[name="trado"]`).parents('.input-group').children()
    let gandengan = $('#crudForm').find(`[name="gandengan"]`).parents('.input-group').children()
    let gudang = $('#crudForm').find(`[name="gudang"]`).parents('.input-group').children()
    trado.find(`.lookup-toggler`).attr("disabled", false);
    trado.attr('disabled', false);
    gandengan.find(`.lookup-toggler`).attr("disabled", false);
    gandengan.attr('disabled', false);
    gudang.find(`.lookup-toggler`).attr("disabled", false);
    gudang.attr('disabled', false);


    $('#tradoId').attr('disabled', false);
    $('#tradoId').val('');
    $('#gandenganId').attr('disabled', false);
    $('#gandenganId').val('');
    $('#gudangId').attr('disabled', false);
    $('#gudangId').val('');
  }

  $(window).on('popstate', function() {
    $('#crudModal').modal('hide')
  });

  $('#crudModal').on('shown.bs.modal', () => {
    var urlReplace = "#" + $(this).attr('id'); // make the hash the id of the modal shown
    history.pushState(null, null, urlReplace); // push state that hash into the url
    let form = $('#crudForm')
    setFormBindKeys(form)

    activeGrid = null
    initDatepicker()
    initLookup()
    if (form.data('action') == 'add') {
      if ($('#kodepenerimaanheader').val() != '') {
        let index = listIdPenerimaan.indexOf($('#kodepenerimaanheader').val());
        setKodePenerimaan(listKodePenerimaan[index]);
        setIsDateAvailable($('#kodepenerimaanheader').val())

        $('#crudForm').find(`[name="penerimaanstok"]`).val(listKodePenerimaan[index])
        $('#crudForm').find(`[name="penerimaanstok"]`).data('currentValue', listKodePenerimaan[index])
        $('#crudForm').find(`[name="penerimaanstok_id"]`).val($('#kodepenerimaanheader').val())
      }
    }
    if (form.data('action') !== 'add') {

      $('#crudForm').find('[name=tglbukti]').attr('readonly', 'readonly').css({
        background: '#fff'
      })
      let tglbukti = $('#crudForm').find(`[name="tglbukti"]`).parents('.input-group').children()
      tglbukti.find('button').attr('disabled', true)
      let penerimaanstok = $('#crudForm').find(`[name="penerimaanstok"]`).parents('.input-group').children()
      let penerimaanstok_nobukti = $('#crudForm').find(`[name="penerimaanstok_nobukti"]`).parents('.input-group').children()
      let pengeluaranstok_nobukti = $('#crudForm').find(`[name="pengeluaranstok_nobukti"]`).parents('.input-group').children()
      penerimaanstok.attr('disabled', true)
      penerimaanstok.find('.lookup-toggler').attr('disabled', true)
      $('#penerimaanstokId').attr('readonly', true);

      penerimaanstok_nobukti.attr('readonly', true)
      penerimaanstok_nobukti.parents('.input-group').find('.button-clear').attr('disabled', true)
      penerimaanstok_nobukti.find('.lookup-toggler').attr('disabled', true)
      pengeluaranstok_nobukti.attr('readonly', true)
      pengeluaranstok_nobukti.parents('.input-group').find('.button-clear').attr('disabled', true)
      pengeluaranstok_nobukti.find('.lookup-toggler').attr('disabled', true)
    }


    form.find('#btnSubmit').prop('disabled', false)
    if (form.data('action') == "view") {
      form.find('#btnSubmit').prop('disabled', true)
    }

    if (form.data('action') == 'add') {
      form.find('#btnSaveAdd').show()
    } else {
      form.find('#btnSaveAdd').hide()
    }
    getMaxLength(form)
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    removeEditingBy($('#crudForm').find('[name=id]').val())
    $('#crudModal').find('.modal-body').html(modalBody)
    initDatepicker('datepickerIndex')
    KodePenerimaanId = "";

  })

  function removeEditingBy(id) {


    let formData = new FormData();


    formData.append('id', id);
    formData.append('aksi', 'BATAL');
    formData.append('table', 'penerimaanstokheader');

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


  function createPenerimaanstokHeader() {
    resetRow()
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Add Penerimaan Stok')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusBanOptions(form)
      ])
      .then(() => {
        if (selectedRows.length > 0) {
          clearSelectedRows()
        }
        $('#crudModal').modal('show')
        // tampilanall()
        tampilanInit()
        // addRow()
        initRow()
        sumary()
        $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

        $('#crudForm').find('[name=tglbukti]').attr('readonly', 'readonly').css({
          background: '#fff'
        })
        let tglbukti = $('#crudForm').find(`[name="tglbukti"]`).parents('.input-group').children()
        tglbukti.find('button').attr('disabled', true)
      })
      .catch((error) => {
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })

  }

  function editPenerimaanstokHeader(penerimaanStokHeaderId) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Penerimaan Stok')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusBanOptions(form),
        showPenerimaanstokHeader(form, penerimaanStokHeaderId)
      ])
      .then((showPenerimaanstok) => {
        let data = showPenerimaanstok[1];
        // console.log(data.statuseditketerangan_id == statusBisaEdit);
        // console.log(data.statuseditketerangan_id == statusBisaEdit);

        initDatepicker()
        initSelect2(form.find('.select2bs4'), true)
        form.find('[name=tglbukti]').removeAttr('disabled')

        form.find('[name=tglbukti]').attr('readonly', 'readonly').css({
          background: '#fff'
        })

        if (selectedRows.length > 0) {
          clearSelectedRows()
        }
        $('#crudModal').modal('show')
        $('#crudForm').find(`.ui-datepicker-trigger`).attr('disabled', true)
        if ($('#crudForm').find("[name=gudang]").val()) {
          lookupSelected(`gudang`);
        } else if ($('#crudForm').find("[name=gandengan]").val()) {
          lookupSelected('gandengan')
        } else if ($('#crudForm').find("[name=trado]").val()) {
          lookupSelected('trado')
        }

        if ($('#crudForm').find("[name=gudangke]").val()) {
          lookupSelectedKe(`gudangke`);
        } else if ($('#crudForm').find("[name=gandenganke]").val()) {
          lookupSelectedKe('gandenganke')
        } else if ($('#crudForm').find("[name=tradoke]").val()) {
          lookupSelectedKe('tradoke')
        }

        if ($('#crudForm').find("[name=gudangdari]").val()) {
          lookupSelectedDari(`gudangdari`);
        } else if ($('#crudForm').find("[name=gandengandari]").val()) {
          lookupSelectedDari('gandengandari')
        } else if ($('#crudForm').find("[name=tradodari]").val()) {
          lookupSelectedDari('tradodari')
        }

        if ((data.statuseditketerangan_id == statusBisaEdit) && (data.statusedit_id != statusBisaEdit)) {
          form.find('[name]').attr('readonly', 'readonly')
          form.find('[name=id]').prop('disabled', false)
          form.find('[name="detail_keterangan[]"]').prop('readonly', false)
          // console.log();

          let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
          name.attr('readonly', true)
          name.find('.lookup-toggler').attr('disabled', true)

          $('.tbl_aksi').hide()

        }

        // let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
        // name.attr('disabled', true)
        // name.find('.lookup-toggler').attr('disabled', true)
      })
      .catch((error) => {
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }

  function deletePenerimaanstokHeader(penerimaanStokHeaderId) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-trash"></i>
    Delete
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Penerimaan Stok')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusBanOptions(form),
        showPenerimaanstokHeader(form, penerimaanStokHeaderId)
      ])
      .then(penerimaanStokHeaderId => {
        setFormBindKeys(form)
        initDatepicker()
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
        $('#crudModal').modal('show')
        $('#crudForm').find(`.ui-datepicker-trigger`).attr('disabled', true)

        let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
        name.attr('disabled', true)
        name.find('.lookup-toggler').attr('disabled', true)

        $('.tbl_aksi').hide()
      })
      .catch((error) => {
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }

  function viewPenerimaanstokHeader(penerimaanStokHeaderId) {
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
    $('#crudModalTitle').text('View Penerimaan Stok')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusBanOptions(form),
        showPenerimaanstokHeader(form, penerimaanStokHeaderId)
      ])
      .then(penerimaanStokHeaderId => {
        setFormBindKeys(form)
        initDatepicker()
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
        $('#crudModal').modal('show')
        $('#crudForm').find(`.ui-datepicker-trigger`).attr('disabled', true)

        form.find(`.hasDatepicker`).prop('readonly', true)
        form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').remove()
        let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
        let nameFind = $('#crudForm').find(`[name]`).parents('.input-group')
        name.attr('disabled', true)
        name.find('.lookup-toggler').remove()
        nameFind.find('button.button-clear').remove()

        $('.tbl_aksi').hide()
      })
      .catch((error) => {
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }

  let dataStatusBan
  const setStatusBanOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusban]').empty()
      relatedForm.find('[name=statusban]').append(
        new Option('-- PILIH STATUS BAN --', '', false, true)
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
                "data": "STATUS KONDISI BAN",

              },

            ]
          })
        },

        success: response => {
          dataStatusBan = response.data
          resolve(dataStatusBan)
        },
        error: error => {
          reject(error)
        }
      })
    })
  }


  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}penerimaanstokheader/field_length`,
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

  function setKorv(row, stok_id) {

    $.ajax({
      url: `${apiUrl}stok/${stok_id}/getvulkan`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        $(`#vulkanisirtotal${row}`).val(response.data.totalvulkan)
        $(`#statusban${row}`).val(response.data.statusban).trigger('change')

      },
      error: error => {
        showDialog(error.responseJSON)
      }
    })


  }

  index = 0;

  function addRow() {
    let detailRow = $(`
    <tr class="trow" data-id="${index}">
                  <td>
                    <div class="baris">1</div>
                  </td>
                  
                  <td>
                    <input name="id_detail[]" hidden value="0">
                    <input type="text"  name="detail_stok[]" id="detailstokaddrow${index}" class="form-control detail_stok_${index}">
                    <input type="text" id="detailstokId_${index}" readonly hidden class="detailstokId" name="detail_stok_id[]">
                    <input type="text" id="detailstokKelompok_${index}" readonly hidden class="detailstokKelompok" name="detail_stok_kelompok[]">
                  </td>                 
                  <td>
                    <input type="text" disabled name="detail_satuan[]" id="" class="form-control detail_satuan_${index}">
                  </td> 
                  <td>
                    <textarea class="form-control" name="detail_keterangan[]" rows="1" placeholder=""></textarea>
                  </td>
                  
                  <td class="data_tbl tbl_penerimaanstok_nobukti">
                    <input type="text"  name="detail_penerimaanstoknobukti[]" id="detail_penerimaanstoknobukti_${index}" class="form-control ">
                    <input type="text" id="detailpenerimaanstoknobuktiId_${index}" readonly hidden class="detailpenerimaanstoknobuktiId" name="detail_penerimaanstoknobukti_id[]">
                  </td>

                  <td class="data_tbl tbl_harga">
                    <input type="text"  name="detail_harga[]" readonly id="detail_harga${index}" style="text-align:right" class="form-control autonumeric number${index}" >
                  </td>

                  <td class="data_tbl tbl_qty">
                    <input type="text"  name="detail_qty[]" id="detail_qty${index}" onkeyup="calculate(${index})" style="text-align:right" class="form-control autonumeric number${index}" >
                  </td>

                  <td class="data_tbl tbl_qtyterpakai">
                    <input type="text"  name="detail_qtyterpakai[]" id="detail_qtyterpakai${index}" onkeyup="calculate(${index})" style="text-align:right" class="form-control autonumeric number${index}">
                  </td>

                  <td class="data_tbl tbl_vulkanisirke">
                    <input type="number"  name="detail_vulkanisirke[]" id="vulkanisirke${index}" style="" max="100" class="form-control" >                    
                  </td> 

                  <td class="data_tbl tbl_vulkanisirtotal">
                    <input type="number"  name="detail_vulkanisirtotal[]" readonly id="vulkanisirtotal${index}" style="" max="100" class="form-control">                    
                  </td>

                  <td class="data_tbl tbl_total_sebelum">
                    <input type="text"  name="total_sebelum[]" id="total_sebelum${index}" style="text-align:right"  onkeyup="calculate(${index})" class="form-control total_sebelum autonumeric number${index}" >
                  </td>

                  <td class="data_tbl tbl_statusban">
                    <select name="detail_statusban[]" class="form-select select2bs4" id="statusban${index}" style="width: 100%;">
                      <option value="">-- PILIH STATUS BAN --</option>
                    </select>                 
                  </td> 

                  <td class="data_tbl tbl_persentase">
                    <input type="text"  name="detail_persentasediscount[]" id="detail_persentasediscount${index}" onkeyup="calculate(${index})" style="text-align:right" class="form-control autonumeric number${index}" >
                  </td>  

                  <td class="data_tbl tbl_nominaldiscount">
                    <input type="text"  name="detail_nominaldiscount[]" id="detail_nominaldiscount${index}"  onkeyup="calculate_nominal(${index})"  style="text-align:right" class="form-control autonumeric number${index}" >
                  </td>  

                  <td class="data_tbl tbl_total">
                    <input type="text"  name="totalItem[]" readonly id="totalItem${index}" style="text-align:right"  onkeyup="calculate(${index})" class="form-control totalItem autonumeric number${index}" >                    
                  </td>

                  <td class="tbl_aksi">
                    <div class='btn btn-danger btn-sm rmv'>Delete</div>
                  </td>
              </tr>
    `)

    $('table #table_body').append(detailRow)
    initSelect2($(`#statusban${index}`), true)
    dataStatusBan.forEach(statusBan => {
      let option = new Option(statusBan.text, statusBan.id)

      detailRow.find(`#statusban${index}`).append(option).trigger('change')
    });
    var row = index;
    $(`.detail_stok_${row}`).lookupV3({
      title: 'stok Lookup',
      fileName: 'stokV3',
      searching: ['namastok'],
      extendSize: md_extendSize_1,
      multiColumnSize:true,
      labelColumn: false,

      beforeProcess: function(test) {
        var penerimaanstokId = $(`#penerimaanstokId`).val();
        var penerimaanstok_nobukti = $('#crudModal').find(`[name=penerimaanstok_nobukti]`).val();
        var nobukti = $('#crudModal').find(`[name=nobukti]`).val();
        cekKelompok(row);
        this.postData = {
          from: 'penerimaanstok',
          penerimaanstok_id: penerimaanstokId,
          penerimaanstokheader_nobukti: penerimaanstok_nobukti,
          nobukti : nobukti,
          Aktif: 'AKTIF',
          KelompokId: KelompokId,
          StokId: StokId,
          isLookup: true
        }
      },
      onSelectRow: (stok, element) => {
        element.val(stok.namastok)

        let satuanEl = element.parents('tr').find(`td [name="detail_satuan[]"]`);
        satuanEl.val(stok.satuan);
        let iddetailEl = element.parents('tr').find(`td [name="id_detail[]"]`);
        iddetailEl.val(stok.iddetail);

        parent = element.closest('td');
        parent.children('.detailstokId').val(stok.id)
        parent.children('.detailstokKelompok').val(stok.kelompok_id)
        element.data('currentValue', element.val())
        setKorv(row, stok.id);
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        let satuanEl = element.parents('tr').find(`td [name="detail_satuan[]"]`);
        let iddetailEl = element.parents('tr').find(`td [name="id_detail[]"]`);
        satuanEl.val('');
        iddetailEl.val(0);

        element.val('')
        element.data('currentValue', element.val())
      }

    })
    $(`#detail_penerimaanstoknobukti_${index}`).lookup({
      title: 'penerimaan stok header Lookup',
      fileName: 'penerimaanstokheader',
      beforeProcess: function(test) {
        var penerimaanstokId = $(`#penerimaanstokId`).val();
        var detailstok = $(`#detailstokId_${row}`).val()
        // console.log(row);
        // console.log($(`#detailstokId_${row}`).val(),$(`#detailstokId_${row}`));
        this.postData = {
          penerimaanstok_id: penerimaanstokId,
          stok_id: detailstok
        }
      },
      onSelectRow: (penerimaan, element) => {
        parent = element.closest('td');
        parent.children('.detailpenerimaanstoknobuktiId').val(penerimaan.id)
        element.val(penerimaan.nobukti)
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        parent = element.closest('td');
        parent.children('.detailpenerimaanstoknobuktiId').val('')
        element.data('currentValue', element.val())
      }
    })

    initAutoNumeric($(`.number${index}`))
    setTampilanForm()
    setRowNumbers()
    index++;
  }

  function deleteRow(row) {
    let countRow = $('.rmv').parents('tr').length
    row.remove()
    if (countRow <= 1) {
      addRow()
    }
    sumary()
    setRowNumbers()
  }

  function initRow() {
    let countRow = $('.rmv').parents('tr').length
    if (countRow <= 1) {
      addRow()
    }
    sumary()
    setRowNumbers()
  }

  function resetRow() {
    $('.trow').remove()
  }

  function cekKelompok(row) {
    //check jika lookup baris pertama
    if ($(`#detailstokKelompok_${row}`)[0] == $('.detailstokKelompok')[0]) {
      KelompokId = "";
      StokId = "";
    } else {
      let detailstokKelompok = $('.detailstokKelompok')
      let detailstokId = $('.detailstokId')
      KelompokId = $(detailstokKelompok[0]).val();
      StokId = $(detailstokId[0]).val();
    }
  }

  function setRowNumbers() {
    let elements = $('table #table_body tr td:nth-child(1)')

    elements.each((index, element) => {
      $(element).text(index + 1)
    })
  }

  function cal(id) {
    qty = $(`#detail_qty${id}`)[0];
    harga = $(`#detail_harga${id}`)[0];
    discount = $(`#detail_persentasediscount${id}`)[0];

    qty = AutoNumeric.getNumber(qty);
    harga = AutoNumeric.getNumber(harga);
    discount = AutoNumeric.getNumber(discount);

    total = qty * harga;
    nominaldiscount = total * (discount / 100);
    total -= nominaldiscount;
    new AutoNumeric($(`#totalItem${id}`)[0]).set(total)
    sumary();
  }

  function calculate(id) {
    qty = $(`#detail_qty${id}`)[0];
    discount = $(`#detail_persentasediscount${id}`)[0];
    totalItem = $(`#totalItem${id}`)[0];
    total_sebelum = $(`#total_sebelum${id}`)[0];

    qty = AutoNumeric.getNumber(qty);
    discount = AutoNumeric.getNumber(discount);
    totalItem = AutoNumeric.getNumber(totalItem);
    total_sebelum = AutoNumeric.getNumber(total_sebelum);

    nominaldiscount = total_sebelum * (discount / 100);
    totalItem = total_sebelum - nominaldiscount;
    discSatuan = nominaldiscount / qty;
    satuanSetelahDiscount = (total_sebelum / qty) - discSatuan;
    harga = satuanSetelahDiscount;

    elNominalDiscount = AutoNumeric.getAutoNumericElement($(`#detail_nominaldiscount${id}`)[0]);
    elNominalDiscount.set(nominaldiscount);

    new AutoNumeric($(`#totalItem${id}`)[0]).set(totalItem)
    new AutoNumeric($(`#detail_harga${id}`)[0]).set(harga)
    sumary();
  }

  function calculate_nominal(id) {
    qty = $(`#detail_qty${id}`)[0];
    nominaldiscount = $(`#detail_nominaldiscount${id}`)[0];
    totalItem = $(`#totalItem${id}`)[0];
    total_sebelum = $(`#total_sebelum${id}`)[0];

    qty = AutoNumeric.getNumber(qty);
    nominaldiscount = AutoNumeric.getNumber(nominaldiscount);
    totalItem = AutoNumeric.getNumber(totalItem);
    total_sebelum = AutoNumeric.getNumber(total_sebelum);

    totalItem = total_sebelum - nominaldiscount;
    discSatuan = nominaldiscount / qty;
    satuanSetelahDiscount = (total_sebelum / qty) - discSatuan;
    harga = satuanSetelahDiscount;
    discount = (nominaldiscount / total_sebelum) * 100;

    elPersentaseDiscount = AutoNumeric.getAutoNumericElement($(`#detail_persentasediscount${id}`)[0]);
    elPersentaseDiscount.set(discount);

    new AutoNumeric($(`#totalItem${id}`)[0]).set(totalItem)
    new AutoNumeric($(`#detail_harga${id}`)[0]).set(harga)
    sumary();
  }

  function calculate2(id) {
    qty = $(`#detail_qty${id}`)[0];
    discount = $(`#detail_persentasediscount${id}`)[0];
    totalItem = $(`#totalItem${id}`)[0];

    qty = AutoNumeric.getNumber(qty);
    discount = AutoNumeric.getNumber(discount);
    totalItem = AutoNumeric.getNumber(totalItem);

    satuanSebelumDiscount = totalItem / qty
    discount = 1 - (discount / 100)

    satuanSetelahDiscount = satuanSebelumDiscount / discount;

    harga = satuanSetelahDiscount;
    new AutoNumeric($(`#detail_harga${id}`)[0]).set(harga)
    sumary();
  }

  function sumary() {
    let sumary = 0;
    $('.totalItem').each(function() {
      var totalItem = AutoNumeric.getNumber($(this)[0]);
      sumary += totalItem;
    })
    new AutoNumeric($('#sumary')[0]).set(sumary);
  }

  function cekValidasi(Id, Aksi, nobukti) {
    $.ajax({
      url: `{{ config('app.api_url') }}penerimaanstokheader/${Id}/cekvalidasi`,
      method: 'POST',
      dataType: 'JSON',
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      data: {
        aksi: Aksi,
        nobukti: nobukti
      },
      success: response => {
        var kodenobukti = response.kodenobukti
        if (kodenobukti == '1') {
          var kodestatus = response.kodestatus
          if (kodestatus == '1') {
            showDialog(response)
            // showDialog(response.message['keterangan'])
          } else {
            if (Aksi == 'PRINTER BESAR') {
              window.open(`{{ route('penerimaanstokheader.report') }}?id=${Id}&nobukti=${nobukti}&printer=reportPrinterBesar`)
            } else if (Aksi == 'PRINTER KECIL') {
              window.open(`{{ route('penerimaanstokheader.report') }}?id=${Id}&nobukti=${nobukti}&printer=reportPrinterKecil`)
            }
            if (Aksi == 'EDIT') {
              editPenerimaanstokHeader(Id)
            }
            if (Aksi == 'DELETE') {
              deletePenerimaanstokHeader(Id)
            }
            if (Aksi == 'VIEW') {
              viewPenerimaanstokHeader(Id)
            }
          }
        } else {
          showDialog(response)
          // showDialog(response.message['keterangan'])
        }
      }
    })
  }

  function disabledkodepenerimaanedit() {

  }

  function penerimaanStok(form) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}penerimaanstok`,
        method: 'GET',
        dataType: 'JSON',
        data: {
          "limit": 20
        },
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $.each(response.data, (index, data) => {
            listIdPenerimaan[index] = data.id
            listKodePenerimaan[index] = data.kodepenerimaan;
          })

        }
      })
    })
  }

  function setIsDateAvailable(penerimaan_id) {
    $.ajax({
      url: `${apiUrl}bukapenerimaanstok/${penerimaan_id}/cektanggal`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {

        if (response.data.length) {
          $('#crudForm').find('[name=tglbukti]').attr('readonly', false)
          let tglbukti = $('#crudForm').find(`[name="tglbukti"]`).parents('.input-group').children()
          tglbukti.find('button').attr('disabled', false)
        } else {
          $('#crudForm').find('[name=tglbukti]').attr('readonly', 'readonly').css({
            background: '#fff'
          })
          let tglbukti = $('#crudForm').find(`[name="tglbukti"]`).parents('.input-group').children()
          tglbukti.find('button').attr('disabled', true)
        }

      }
    })
  }

  function showPenerimaanstokHeader(form, penerimaanStokHeaderId) {
    return new Promise((resolve, reject) => {
      resetRow()
      $.ajax({
        url: `${apiUrl}penerimaanstokheader/${penerimaanStokHeaderId}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          sum = 0;
          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)
            if (element.attr("name") == 'tglbukti') {
              var result = value.split('-');
              element.val(result[2] + '-' + result[1] + '-' + result[0]);
            } else {
              element.val(value)
              element.data('currentValue', value)
            }


          })

          // console.log('gudang_id '+ response.data.tradodari_id);
          // console.log('gandengan_id '+ response.data.gandengan_id);

          $('#gudangId').val(response.data.gudang_id)
          $('#gandenganId').val(response.data.gandengan_id)
          $('#tradoId').val(response.data.trado_id)
          $('#gudangkeId').val(response.data.gudangke_id)
          $('#gandengankeId').val(response.data.gandenganke_id)
          $('#tradokeId').val(response.data.tradoke_id)
          $('#gudangdariId').val(response.data.gudangdari_id)
          $('#gandengandariId').val(response.data.gandengandari_id)
          $('#tradodariId').val(response.data.tradodari_id)

          $('#detailList tbody').html('')
          setKodePenerimaan(response.data.penerimaanstok);

          $.each(response.detail, (id, detail) => {

            let detailRow = $(`
              <tr class="trow" data-id="${id}">
                    <td>
                      <div class="baris">1</div>
                    </td>
                    
                    <td>
                      <input name="id_detail[]" hidden value="${detail.id}">
                      <input type="text"  name="detail_stok[]" id="detail_stok_${id}" class="form-control stok-lookup ">
                      <input type="text" id="detailstokId_${id}" readonly hidden class="detailstokId" name="detail_stok_id[]">
                      <input type="text" id="detailstokId_${id}_old" value="${detail.stok_id}" readonly hidden name="detail_stok_id_old[]">
                      <input type="text" id="detailstokKelompok_${id}" value="${detail.kelompok_id}" readonly hidden class="detailstokKelompok" name="detail_stok_kelompok[]">
                    </td>
                    <td>
                      <input type="text" disabled name="detail_satuan[]" id=""   class="form-control detail_satuan_${id}">
                    </td> 
                    <td>
                      <textarea class="form-control" name="detail_keterangan[]" rows="1" placeholder=""></textarea>
                    </td>
                    
                    <td class="data_tbl tbl_penerimaanstok_nobukti">
                      <input type="text"  name="detail_penerimaanstoknobukti[]" id="detail_penerimaanstoknobukti_${id}" class="form-control ">
                      <input type="text" id="detailpenerimaanstoknobuktiId_${id}" readonly hidden class="detailpenerimaanstoknobuktiId" name="detail_penerimaanstoknobukti_id[]">
                    </td>

                    <td class="data_tbl tbl_harga">
                      <input type="text"  name="detail_harga[]" readonly id="detail_harga${id}" style="text-align:right" class="autonumeric number${id} form-control">                    
                    </td>

                    <td class="data_tbl tbl_qty">
                      <input type="text"  name="detail_qty[]" id="detail_qty${id}" onkeyup="calculate(${id})" style="text-align:right" class="form-control autonumeric number${id}">
                    </td>

                    <td class="data_tbl tbl_qtyterpakai">
                      <input type="text"  name="detail_qtyterpakai[]" id="detail_qtyterpakai${id}" onkeyup="calculate(${id})" style="text-align:right" class="form-control autonumeric number${id}">
                    </td>  

                    <td class="data_tbl tbl_vulkanisirke">
                      <input type="number"  name="detail_vulkanisirke[]" style="" max="100" class="form-control">                    
                    </td>  

                    <td class="data_tbl tbl_vulkanisirtotal">
                      <input type="number"  name="detail_vulkanisirtotal[]" readonly id="vulkanisirtotal${id}" style="" max="100" class="form-control">                    
                    </td>

                    <td class="data_tbl tbl_total_sebelum">
                      <input type="text"  name="total_sebelum[]" id="total_sebelum${id}" style="text-align:right"  onkeyup="calculate(${id})" class="form-control total_sebelum autonumeric number${id}" >
                    </td>

                    <td class="data_tbl tbl_statusban">
                        <select name="detail_statusban[]" class="form-select select2bs4" id="statusban${id}" style="width: 100%;">
                          <option value="">-- PILIH STATUS BAN --</option>
                        </select>                 
                      </td> 

                    <td class="data_tbl tbl_persentase">
                      <input type="text"  name="detail_persentasediscount[]" id="detail_persentasediscount${id}" onkeyup="calculate(${id})" style="text-align:right" class="autonumeric number${id} form-control">
                    </td>

                    <td class="data_tbl tbl_nominaldiscount">
                      <input type="text"  name="detail_nominaldiscount[]" id="detail_nominaldiscount${id}" onkeyup="calculate_nominal(${id})" style="text-align:right" class="autonumeric number${id} form-control">
                    </td>

                    <td class="data_tbl tbl_total">
                      <input type="text"  name="totalItem[]" readonly id="totalItem${id}" style="text-align:right" onkeyup="calculate(${id})" class="form-control totalItem autonumeric number${id}">
                    </td>

                    <td class="data_tbl tbl_aksi">
                      <div data-id="${detail.id}" class='btn btn-danger btn-sm rmv'>Delete</div>
                    </td>
                </tr>
            `)
            // console.log(KodePenerimaanId , listKodePenerimaan[7]);

            dataStatusBan.forEach(statusBan => {
              option = new Option(statusBan.text, statusBan.id)
              detailRow.find(`#statusban${index}`).append(option).trigger('change')
            });
            if (KodePenerimaanId === listKodePenerimaan[7]) {
              detailRow.find(`[name="detail_harga[]"]`).prop('readonly', true);
              detailRow.find(`[name="detail_persentasediscount[]"]`).prop('readonly', true);
              detailRow.find(`[name="totalItem[]"]`).prop('readonly', true);
              detailRow.find(`[name="detail_qty[]"]`).prop('readonly', true);
            }
            if (detail.satuan) {
              detailRow.find(`[name="detail_satuan[]"]`).val(detail.satuan)
            }
            detailRow.find(`[name="detail_nobukti[]"]`).val(detail.nobukti)
            detailRow.find(`[name="detail_stok[]"]`).val(detail.stok)
            detailRow.find(`[name="detail_stok[]"]`).data('currentValue', detail.stok)
            detailRow.find(`[name="detail_stok_id[]"]`).val(detail.stok_id)
            detailRow.find(`[name="detail_qty[]"]`).val(detail.qty)
            detailRow.find(`[name="detail_qtyterpakai[]"]`).val(detail.qtyterpakai)
            detailRow.find(`[name="detail_penerimaanstoknobukti[]"]`).val(detail.penerimaanstok_nobukti)
            detailRow.find(`[name="detail_harga[]"]`).val(detail.harga)
            detailRow.find(`[name="detail_persentasediscount[]"]`).val(detail.persentasediscount)
            detailRow.find(`[name="detail_nominaldiscount[]"]`).val(detail.nominaldiscount)
            detailRow.find(`[name="detail_vulkanisirke[]"]`).val(detail.vulkanisirke)
            detailRow.find(`[name="totalItem[]"]`).val(detail.total)
            totalSSebelumDiscount = detail.total / (1 - (detail.persentasediscount / 100))
            detailRow.find(`[name="total_sebelum[]"]`).val(totalSSebelumDiscount)
            detailRow.find(`[name="detail_keterangan[]"]`).val(detail.keterangan)
            $('table #table_body').append(detailRow)
            initSelect2($(`#statusban${id}`), true)
            setKorv(id, detail.stok_id);
            initAutoNumeric($(`#detail_qtyterpakai${id}`), {
              'maximumValue': detail.qty
            })
            initAutoNumeric($(`#detail_harga${id}`))
            initAutoNumeric($(`#detail_qty${id}`))
            initAutoNumeric($(`#total_sebelum${id}`))
            initAutoNumeric($(`#detail_persentasediscount${id}`))
            initAutoNumeric($(`#detail_nominaldiscount${id}`))
            initAutoNumeric($(`#totalItem${id}`))


            setRowNumbers()
            let row = id;
            $(`#detail_stok_${id}`).lookupV3({
              title: 'stok Lookup',
              fileName: 'stokV3',
              searching: ['namastok'],
              extendSize: md_extendSize_1,
              multiColumnSize:true,
              labelColumn: false,
              beforeProcess: function(test) {
                var penerimaanstokId = $("#crudForm").find(`[name="penerimaanstok_id"]`).val();
                var penerimaanstok_nobukti = $('#crudModal').find(`[name=penerimaanstok_nobukti]`).val();
                var nobukti = $('#crudModal').find(`[name=nobukti]`).val();
                cekKelompok(row);
                this.postData = {
                  from: 'penerimaanstok',
                  penerimaanstok_id: penerimaanstokId,
                  penerimaanstokheader_nobukti: penerimaanstok_nobukti,
                  nobukti : nobukti,
                  Aktif: 'AKTIF',
                  isLookup: true
                }
              },
              onSelectRow: (stok, element) => {
                element.val(stok.namastok)

                let satuanEl = element.parents('tr').find(`td [name="detail_satuan[]"]`);
                satuanEl.val(stok.satuan);
                let iddetailEl = element.parents('tr').find(`td [name="id_detail[]"]`);
                iddetailEl.val(stok.iddetail);


                parent = element.closest('td');
                parent.children('.detailstokId').val(stok.id)
                parent.children('.detailstokKelompok').val(stok.kelompok_id)
                element.data('currentValue', element.val())
                setKorv(id, stok.id);

              },
              onCancel: (element) => {
                element.val(element.data('currentValue'))
              }
            })
            $(`#detail_penerimaanstoknobukti_${id}`).lookup({
              title: 'penerimaan stok header Lookup',
              fileName: 'penerimaanstokheader',
              beforeProcess: function(test) {
                var penerimaanstokId = $(`#penerimaanstokId`).val();
                this.postData = {
                  penerimaanstok_id: penerimaanstokId,
                }
              },
              onSelectRow: (penerimaan, element) => {
                parent = element.closest('td');
                parent.children('.detailpenerimaanstoknobuktiId').val(penerimaan.id)
                element.val(penerimaan.nobukti)
              },
              onCancel: (element) => {
                element.val(element.data('currentValue'))
              },
              onClear: (element) => {
                element.val('')
                parent = element.closest('td');
                parent.children('.detailpenerimaanstoknobuktiId').val('')
                element.data('currentValue', element.val())
              }
            })

            // dataStatusBan.forEach(statusBan => {
            //   option = new Option(statusBan.text, statusBan.id)

            //   detailRow.find(`#statusban${id}`).append(option).trigger('change')
            // });

            id++;
          })
          sumary()
          setKodePenerimaan(response.data.penerimaanstok);

          if (KodePenerimaanId === listKodePenerimaan[2]) {
            if (response.data.penerimaanstok_nobukti) {
              $('#addRow').hide()
            } else {
              $('#addRow').show()
            }
          } else if (KodePenerimaanId === listKodePenerimaan[10]) {
            setShowDetailSPBP(response.detail)
          } else if (KodePenerimaanId === listKodePenerimaan[8]) {
            setShowDetailPengeluaran(penerimaanStokHeaderId, KodePenerimaanId)
          } else if (KodePenerimaanId === listKodePenerimaan[7]) {
            $('#addRow').hide()
          } else {
            $('#addRow').show()
          }
          resolve(response.data)
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function resetLookup() {

    array = [
      'supplier',
      'trado',
      'gandengan',
      'gudangdari',
      'gudang',
      'penerimaanstokheader_nobukti',
      'pengeluaranstokheader_nobukti',
      'tradoke',
      'gandenganke',
      'gudangke',
      'tradodari',
      'gandengandari',
    ];
    array.forEach(index => {
      $('#crudForm').find(`[name="${index}"]`).parents('.input-group').children().attr('disabled', false)
      $('#crudForm').find(`[name="${index}"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled', false)
      $(`#${index}Id`).val('')
      $('#crudForm').find(`[name="${index}"]`).data('currentValue', '')
    });
    enabledLookupSelected()
    enabledLookupSelectedDari()
    enabledLookupSelectedKe()
  }

  function initLookup(params) {
    $('.akunpusat-lookup').lookupV3({
      title: 'akun pusat Lookup',
      fileName: 'akunpusatV3',
      searching: ['coa','keterangancoa'],
      labelColumn: false,
      onSelectRow: (akunpusat, element) => {
        element.val(akunpusat.coa)
        $(`#${element[0]['name']}Id`).val(akunpusat.coa)
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

    $('.penerimaanstok-lookup').lookupV3({
      title: 'penerimaan stok Lookup',
      fileName: 'penerimaanstokV3',
      labelColumn: true,
      extendSize: md_extendSize_1,
      multiColumnSize:true,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          roleInput: 'role',
          isLookup: true
        }
      },
      onSelectRow: (penerimaanstok, element) => {
        setKodePenerimaan(penerimaanstok.kodepenerimaan)
        setIsDateAvailable(penerimaanstok.id)

        element.val(penerimaanstok.kodepenerimaan)
        $(`#${element[0]['name']}Id`).val(penerimaanstok.id)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        $(`#${element[0]['name']}Id`).val('')
        element.data('currentValue', element.val())
      }

    })

    // $('.penerimaanstok-lookup').lookupMaster({
    //   title: 'penerimaan stok Lookup',
    //   fileName: 'penerimaanstokMaster',
    //   beforeProcess: function(test) {
    //     this.postData = {
    //       Aktif: 'AKTIF',
    //       roleInput: 'role',
    //       isLookup: true,
    //       searching: 1,
    //       valueName: 'penerimaanstok_id',
    //       searchText: 'penerimaanstok-lookup',
    //       title: 'penerimaan stok',
    //       typeSearch: 'ALL',
    //     }
    //   },
    //   onSelectRow: (penerimaanstok, element) => {
    //     setKodePenerimaan(penerimaanstok.kodepenerimaan)
    //     setIsDateAvailable(penerimaanstok.id)

    //     element.val(penerimaanstok.kodepenerimaan)
    //     $(`#${element[0]['name']}Id`).val(penerimaanstok.id)
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

    $('.supplier-lookup').lookupV3({
      title: 'supplier Lookup',
      fileName: 'supplierV3',
      labelColumn: false,
      searching: ['namasupplier'],

      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (supplier, element) => {
        element.val(supplier.namasupplier)
        $(`#${element[0]['name']}Id`).val(supplier.id)
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

    $('.trado-lookup').lookupV3({
      title: 'Trado Lookup',
      fileName: 'tradoV3',
      labelColumn: false,
      searching: ['kodetrado'],
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (trado, element) => {
        element.val(trado.kodetrado)
        $(`#${element[0]['name']}Id`).val(trado.id)
        element.data('currentValue', element.val())
        lookupSelected(`trado`);
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        enabledLookupSelected()
        element.data('currentValue', element.val())
      }
    })

    $('.gandengan-lookup').lookupV3({
      title: 'gandengan Lookup',
      fileName: 'gandenganV3',
      searching: ['name','keterangan'],
      labelColumn: true,
      extendSize: md_extendSize_1,
      multiColumnSize:true,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (trado, element) => {
        element.val(trado.keterangan)
        $(`#${element[0]['name']}Id`).val(trado.id)
        element.data('currentValue', element.val())
        lookupSelected(`gandengan`);
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        enabledLookupSelected()
        element.data('currentValue', element.val())
      }
    })

    $('.gudang-lookup').lookupV3({
      title: 'Gudang Lookup',
      fileName: 'gudangV3',
      labelColumn: false,
      searching: ['gudang'],
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (gudang, element) => {
        element.val(gudang.gudang)
        $(`#${element[0]['name']}Id`).val(gudang.id)
        element.data('currentValue', element.val())
        lookupSelected(`gudang`);
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        enabledLookupSelected()
        element.data('currentValue', element.val())
      }
    })
    $('.penerimaanstokheader-lookup').lookup({
      title: 'penerimaan stok header Lookup',
      fileName: 'penerimaanstokheader',
      beforeProcess: function(test) {
        var penerimaanstokId = $(`#penerimaanstokId`).val();
        this.postData = {
          penerimaanstok_id: penerimaanstokId,
        }
      },
      onSelectRow: (penerimaan, element) => {
        var penerimaanstokId = $(`#penerimaanstokId`).val();
        if ((penerimaanstokId == listIdPenerimaan[2] || penerimaanstokId == listIdPenerimaan[10])) { //spb beli /reuse /spbp
          setSuplier(penerimaan.id);
          $('[name=nobon]').val(penerimaan.nobon)
          if (penerimaanstokId == listIdPenerimaan[2]) { //spb
            setDetailPenerimaan(penerimaan.id);
          }
          if (penerimaanstokId == listIdPenerimaan[10]) { //spbp
            setDetailSPBP(penerimaan.id);
          }
          // console.log(penerimaan.supplier,
          // penerimaan.nobon);
        }

        element.val(penerimaan.nobukti)
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        element.data('currentValue', element.val())
        $('#crudForm').find(`[name="supplier"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled', false)
        $('#crudForm').find(`[name="supplier"]`).parents('.input-group').find('.button-clear').attr('disabled', false)
        $('[name=supplier]').attr('readonly', false);
      }
    })


    $('.pengeluaranstokheader-lookup').lookup({
      title: 'pengeluaran stok header Lookup',
      fileName: 'pengeluaranstokheader',
      beforeProcess: function(test) {
        var penerimaanstokId = $(`#penerimaanstokId`).val();
        this.postData = {
          penerimaanstok_id: penerimaanstokId,
        }
      },
      onSelectRow: (pengeluaran, element) => {
        var penerimaanstokId = $(`#penerimaanstokId`).val();
        if ((penerimaanstokId == 8) || (penerimaanstokId == 9)) { //pst pengembalian stok dan pspk
          console.log(penerimaanstokId);
          setDetailPengeluaran(pengeluaran.id);
        }
        element.val(pengeluaran.nobukti)
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


    $('.tradoke-lookup').lookupV3({
      title: 'Trado Lookup',
       fileName: 'tradoV3',
      labelColumn: false,
      searching: ['kodetrado'],
      beforeProcess: function(test) {
        var penerimaanstokId = $(`#penerimaanstokId`).val();
        this.postData = {
          Aktif: 'AKTIF',
          penerimaanstok_id: penerimaanstokId,
          tradodari_id: $('#crudForm').find(`[id="tradodariId"] `).val(),
          tradodarike: 'ke',
        }
      },
      onSelectRow: (trado, element) => {
        element.val(trado.kodetrado)
        $(`#${element[0]['name']}Id`).val(trado.id)
        element.data('currentValue', element.val())
        lookupSelectedKe(`tradoke`);
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        enabledLookupSelectedKe()
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.gandenganke-lookup').lookupV3({
      title: 'gandengan Lookup',
      fileName: 'gandenganV3',
      searching: ['name','keterangan'],
      labelColumn: true,
      extendSize: md_extendSize_1,
      multiColumnSize:true,      
      beforeProcess: function(test) {
        var penerimaanstokId = $(`#penerimaanstokId`).val();
        this.postData = {
          Aktif: 'AKTIF',
          penerimaanstok_id: penerimaanstokId,
          gandengandari_id: $('#crudForm').find(`[id="gandengandariId"] `).val(),
          gandengandarike: 'ke',
        }
      },
      onSelectRow: (trado, element) => {
        element.val(trado.keterangan)
        $(`#${element[0]['name']}Id`).val(trado.id)
        element.data('currentValue', element.val())
        lookupSelectedKe(`gandenganke`);
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        enabledLookupSelectedKe()
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.gudangke-lookup').lookupV3({
      title: 'Gudang Lookup',
      fileName: 'gudangV3',
      labelColumn: false,
      searching: ['gudang'],
      beforeProcess: function(test) {
        var penerimaanstokId = $(`#penerimaanstokId`).val();
        this.postData = {
          penerimaanstok_id: penerimaanstokId,
          gudangdari_id: $('#crudForm').find(`[id="gudangdariId"] `).val(),
          gudangdarike: 'ke',
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (gudang, element) => {
        element.val(gudang.gudang)
        $(`#${element[0]['name']}Id`).val(gudang.id)
        element.data('currentValue', element.val())
        lookupSelectedKe(`gudangke`);
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        enabledLookupSelectedKe()
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.tradodari-lookup').lookupV3({
      title: 'Trado Lookup',
       fileName: 'tradoV3',
      labelColumn: false,
      searching: ['kodetrado'],
      beforeProcess: function(test) {
        var penerimaanstokId = $(`#penerimaanstokId`).val();
        this.postData = {
          penerimaanstok_id: penerimaanstokId,
          tradoke_id: $('#crudForm').find(`[id="tradokeId"] `).val(),
          Aktif: 'AKTIF',
          tradodarike: 'dari',
        }
      },
      onSelectRow: (trado, element) => {
        element.val(trado.kodetrado)
        $(`#${element[0]['name']}Id`).val(trado.id)
        element.data('currentValue', element.val())
        lookupSelectedDari(`tradodari`);
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        enabledLookupSelectedDari()
        element.val('')
        $(`#${element[0]['name']}Id`).val('')
        element.data('currentValue', element.val())
      }
    })

    $('.gandengandari-lookup').lookupV3({
      title: 'gandengan Lookup',
      fileName: 'gandenganV3',
      searching: ['name','keterangan'],
      labelColumn: true,
      extendSize: md_extendSize_1,
      multiColumnSize:true,
      beforeProcess: function(test) {
        var penerimaanstokId = $(`#penerimaanstokId`).val();
        this.postData = {
          penerimaanstok_id: penerimaanstokId,
          gandenganke_id: $('#crudForm').find(`[id="gandengankeId"] `).val(),
          Aktif: 'AKTIF',
          gandengandarike: 'dari',
        }
      },
      onSelectRow: (trado, element) => {
        element.val(trado.keterangan)
        $(`#${element[0]['name']}Id`).val(trado.id)
        element.data('currentValue', element.val())
        lookupSelectedDari(`gandengandari`);
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        enabledLookupSelectedDari()
        element.val('')
        $(`#${element[0]['name']}Id`).val('')
        element.data('currentValue', element.val())
      }
    })

    $('.gudangdari-lookup').lookupV3({
      title: 'Gudang Lookup',
      fileName: 'gudangV3',
      labelColumn: false,
      searching: ['gudang'],
      beforeProcess: function(test) {
        var penerimaanstokId = $(`#penerimaanstokId`).val();
        this.postData = {
          penerimaanstok_id: penerimaanstokId,
          gudangke_id: $('#crudForm').find(`[id="gudangkeId"] `).val(),
          gudangdarike: 'dari',
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (gudang, element) => {
        element.val(gudang.gudang)
        $(`#${element[0]['name']}Id`).val(gudang.id)
        element.data('currentValue', element.val())
        lookupSelectedDari(`gudangdari`);
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        enabledLookupSelectedDari('gudang', $(`#${element[0]['name']}Id`).val())
        element.val('')
        $(`#${element[0]['name']}Id`).val('')
        element.data('currentValue', element.val())
      }
    })
  }
</script>
@endpush()