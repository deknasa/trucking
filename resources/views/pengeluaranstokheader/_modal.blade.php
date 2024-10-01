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
              <div class="col-12 col-sm-9 col-md-4 mb-3">
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
                    <label class="col-form-label">pengeluaran stok <span class="text-danger">*</span> </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <input type="text" id="pengeluaranstok" name="pengeluaranstok" class="form-control pengeluaranstok-lookup">
                    <input type="text" id="pengeluaranstokId" name="pengeluaranstok_id" readonly hidden>
                  </div>
                </div>
              </div>



              {{-- <div class="form-group col-md-6" style="display: none">
                <div class="row" >
                  <div class="col-12 col-sm-3 col-md-4">
                    <label class="col-form-label">STATUS FORMAT <span class="text-danger">*</span> </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <select name="statusformat" disabled class="form-select select2bs4" style="width: 100%;">
                      <option value="">-- PILIH STATUS FORMAT --</option>
                    </select>
                    <input type="text" name="statusformat_id" readonly hidden class="form-control">
                  </div>
                </div>
              </div> --}}

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
                    <label class="col-form-label">supplier </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <input type="text" name="supplier" id="supplier" class="form-control supplier-lookup">
                    <input type="text" id="supplierId" name="supplier_id" readonly hidden>
                  </div>
                </div>
              </div>

              <div class="form-group col-md-6">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4">
                    <label class="col-form-label">kerusakan </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <input type="text" name="kerusakan" id="kerusakan" class="form-control kerusakan-lookup">
                    <input type="text" id="kerusakanId" name="kerusakan_id" readonly hidden>
                  </div>
                </div>
              </div>

              <div class="form-group col-md-6">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4">
                    <label class="col-form-label">supir </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <input type="text" name="supir" id="supir" class="form-control supir-lookup">
                    <input type="text" id="supirId" name="supir_id" readonly hidden>
                  </div>
                </div>
              </div>

              <div class="col-12">
                <div class="row">
                  <div class="form-group col-md-6">
                    <div class="row">
                      <div class="col-12 col-sm-3 col-md-4">
                        <label class="col-form-label">service in no bukti </label>
                      </div>
                      <div class="col-12 col-sm-9 col-md-8">
                        <input type="text" name="servicein_nobukti" class="form-control servicein-lookup">
                      </div>
                    </div>
                  </div>

                  {{-- <div class="form-group col-md-6">
                    <div class="row">
                      <div class="col-12 col-sm-3 col-md-4">
                        <label class="col-form-label">penerimaan stok nobukti </label>
                      </div>
                      <div class="col-12 col-sm-9 col-md-8">
                        <input type="text" name="penerimaanstok_nobukti" class="form-control penerimaanstokheader-lookup">
                      </div>
                    </div>
                  </div> --}}

                  <div class="form-group col-md-6">
                    <div class="row">
                      <div class="col-12 col-sm-3 col-md-4">
                        <label class="col-form-label">pengeluaran stok nobukti </label>
                      </div>
                      <div class="col-12 col-sm-9 col-md-8">
                        <input type="text" name="pengeluaranstok_nobukti" class="form-control pengeluaranstokheader-lookup">
                      </div>
                    </div>
                  </div>
                  {{-- </div>
              </div>

              <div class="col-12">
                <div class="row"> --}}
                  <div class="form-group col-md-6">
                    <div class="row">
                      <div class="col-12 col-sm-3 col-md-4">
                        <label class="col-form-label">trado </label>
                      </div>
                      <div class="col-12 col-sm-9 col-md-8">
                        <input type="text" name="trado" id="trado" class="form-control trado-lookup">
                        <input type="text" id="tradoId" name="trado_id" readonly hidden>
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
                        <input type="text" id="gudangId" name="gudang_id" readonly hidden>
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
                        <input type="text" id="gandenganId" name="gandengan_id" readonly hidden>
                      </div>
                    </div>
                  </div>

                </div>
              </div>

              <div class="form-group col-md-6">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4">
                    <label class="col-form-label">STATUS POTONG RETUR <span class="text-danger">*</span> </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <select name="statuspotongretur" id="statuspotongretur" class="form-select select2" style="width: 100%;">
                      <option value="">-- PILIH STATUS POTONG RETUR --</option>
                    </select>
                  </div>
                </div>
              </div>

            </div>

            <div class="border p-3 potongkas">
              <h6 id="titlePotongkas">Posting Penerimaan</h6>
              <div class="row">
                <div class="form-group col-md-6">
                  <div class="row">
                    <div class="col-12 col-sm-3 col-md-4">
                      <label class="col-form-label">KAS/bank </label>
                    </div>
                    <div class="col-12 col-sm-9 col-md-8">
                      <input type="text" name="bank" id="bank" class="form-control bank-lookup">
                      <input type="text" id="bankId" name="bank_id" readonly hidden>
                    </div>
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <div class="row">
                    <div class="col-12 col-sm-3 col-md-4">
                      <label class="col-form-label">TANGGAL POST </label>
                    </div>
                    <div class="col-12 col-sm-9 col-md-8">
                      <div class="input-group">
                        <input type="text" name="tglkasmasuk" class="form-control datepicker">
                      </div>
                    </div>
                  </div>
                </div>

                <div class="form-group col-md-6">
                  <div class="row">
                    <div class="col-12 col-sm-3 col-md-4">
                      <label class="col-form-label">penerimaan no bukti </label>
                    </div>
                    <div class="col-12 col-sm-9 col-md-8">
                      <div class="input-group">
                        <input type="text" name="penerimaan_nobukti" class="form-control" readonly>
                      </div>
                    </div>
                  </div>
                </div>

              </div>


            </div>
            <div class="row mt-5">
              <div class="col-md-12">
                <div id="detail-table" class="card" style="max-height:500px; min-height:200px overflow-y: scroll;">
                  <div class="card-body">
                    <table class="table table-bordered table-bindkeys" style="width: 100%; min-width: 500px;">
                      <thead>
                        <tr>
                          <th style="width:10%; max-width: 25px; max-width: 15px">No</th>
                          <th style="width: 20%; min-width: 200px;">stok</th>
                          <th style="width: 10%; min-width: 100px;">satuan</th>
                          <th class="data_tbl tbl_statusoli" style="width:10%; min-width: 100px">Status Oli</th>
                          <th style="width: 20%; min-width: 200px;">keterangan</th>
                          <th class="tbl_qty" style="width:10%; min-width: 100px">qty</th>
                          <th class="data_tbl tbl_statusban" style="width:10%; min-width: 100px">Status Ban</th>
                          <th class="data_tbl tbl_vulkanisirke" style="width:10%; min-width: 100px">vulkanisirke</th>
                          <th class="data_tbl tbl_vulkanisirtotal" style="width:10%; min-width: 100px">vulkanisir</th>
                          <th class="data_tbl tbl_harga" style="width: 20%; min-width: 200px;">harga</th>
                          <th class="data_tbl tbl_persentase" style="width:10%; min-width: 100px">persentase discount</th>
                          <th class="data_tbl tbl_total" style="width: 20%; min-width: 200px;">Total</th>
                          <th class="data_tbl tbl_aksi" style="width:10%; max-width: 25px;max-width: 15px">Aksi</th>
                        </tr>
                      </thead>
                      <tbody id="table_body" class="form-group">
                      </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="6" class="colspan"></td>

                          <td class="font-weight-bold  data_tbl tbl_total"> Total : </td>
                          <td id="sumary" class="text-right font-weight-bold data_tbl tbl_total"> </td>
                          <td class="data_tbl tbl_aksi">
                            <button type="button" class="btn btn-primary btn-sm my-2" id="addRow">Tambah</button>
                          </td>
                        </tr>
                      </tfoot>
                    </table>
                  </div>
                </div>
                <div id="detail-afkir" class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="row">
                        <div class="col-12 col-sm-3 col-md-4">
                          <label class="col-form-label">Stok <span class="text-danger">*</span> </label>
                        </div>
                        <div class="col-12 col-sm-9 col-md-8">
                          <input type="text" name="detail_stok[]" id="afkir_detail_stok_1" class="form-control detail_stok_1 stok-lookup-afkir">
                          <input type="text" class="detailstokId" id="detail_stok_id" name="detail_stok_id[]" readonly hidden>
                        </div>
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="row">
                        <div class="col-12 col-sm-3 col-md-4">
                          <label class="col-form-label">Satuan</label>
                        </div>
                        <div class="col-12 col-sm-9 col-md-8">
                          <input type="text" disabled="disabled" id="detail_satuan_id" name="detail_satuan[]" class="form-control detail_satuan_1 ">
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group col-md-6">
                    <div class="row">
                      <div class="col-12 col-sm-3 col-md-4">
                        <label class="col-form-label">status </label>
                      </div>
                      <div class="col-12 col-sm-9 col-md-8">
                        <input type="text" name="status[]" id="status_stok" class="form-control" readonly>

                      </div>
                    </div>
                  </div>

                  <div class="form-group col-md-6">
                    <div class="row">
                      <div class="col-12 col-sm-3 col-md-4">
                        <label class="col-form-label">Pengeluaran Trucking No bukti <span class="text-danger">*</span> </label>
                      </div>
                      <div class="col-12 col-sm-9 col-md-8">
                        <input type="text" name="pengeluarantrucking_nobukti" class="form-control detail_stok_1 pengeluarantrucking-lookup">
                      </div>
                    </div>
                  </div>

                  <div class="form-group col-md-6">
                    <div class="row">
                      <div class="col-12 col-sm-3 col-md-4">
                        <label class="col-form-label">STATUS BAN <span class="text-danger">*</span> </label>
                      </div>
                      <div class="col-12 col-sm-9 col-md-8">
                        <select name="statusban[]" id="statusban" class="form-select select2bs4" style="width: 100%;">
                          <option value="">-- PILIH STATUS BAN --</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="form-group col-md-6">
                    <div class="row">
                      <div class="col-12 col-sm-3 col-md-4">
                        <label class="col-form-label">vulkanisir Ke <span class="text-danger">*</span> </label>
                      </div>
                      <div class="col-12 col-sm-9 col-md-8">
                        <div class="input-group">
                          <input type="number" id="afkir_vulkanisirke" name="detail_vulkanisirke[]" style="" class="form-control" readonly>

                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group col-md-6">
                    <div class="row">
                      <div class="col-12 col-sm-3 col-md-4">
                        <label class="col-form-label">tgl klaim </label>
                      </div>
                      <div class="col-12 col-sm-9 col-md-8">
                        <div class="input-group">
                          <input type="text" name="tglklaim" class="form-control " readonly>
                        </div>
                      </div>
                    </div>
                  </div>

                  <div class="form-group col-md-6">
                    <div class="row">
                      <div class="col-12 col-sm-3 col-md-4">
                        <label class="col-form-label">no pinjaman </label>
                      </div>
                      <div class="col-12 col-sm-9 col-md-8">
                        <input type="text" name="nobukti_pjt" class="form-control" readonly>
                      </div>
                    </div>
                  </div>

                  <div class="form-group col-md-6">
                    <div class="row">
                      <div class="col-12 col-sm-3 col-md-4">
                        <label class="col-form-label">jlh Hari </label>
                      </div>
                      <div class="col-12 col-sm-9 col-md-8">
                        <input type="text" name="jlhhari" class="form-control" readonly>
                      </div>
                    </div>
                  </div>

                  <div class="form-group col-md-12">
                    <div class="row">
                      <div class="col-12 col-sm-3 col-md-2">
                        <label class="col-form-label">keterangan</label>
                      </div>
                      <div class="col-12 col-sm-9 col-md-10">
                        {{-- <input type="text" name="detail_keterangan[]" style="" class="form-control"> --}}
                        <textarea rows="1" placeholder="" name="detail_keterangan[]" class="form-control"></textarea>

                      </div>
                    </div>
                  </div>
                  <input type="text" name="qty_afkir[]" id="qty_afkir" hidden>



                </div>
              </div>
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
  let kodePengeluaranStok
  let modalBody = $('#crudModal').find('.modal-body').html()
  let pengeluaranheader_id
  var KelompokId = "";
  var StokId = "";
  var listKodePengeluaran = [];
  var listIdPengeluaran = [];
  var index = 0;

  $(document).ready(function() {
    $(document).on('click', '#addRow', function(event) {
      event.preventDefault()

      let method = `POST`
      let url = `${apiUrl}pengeluaranstokheader/addrow`
      let form = $('#crudForm')
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()

      $('#crudForm').find(`[name="detail_qty[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'detail_qty[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="detail_qty[]"]`)[index])
      })
      $('#crudForm').find(`[name="detail_harga[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'detail_harga[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="detail_harga[]"]`)[index])
      })

      $('#crudForm').find(`[name="detail_persentasediscount[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'detail_persentasediscount[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="detail_persentasediscount[]"]`)[index])
      })

      $.ajax({
        url: url,
        method: method,
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

            setErrorMessages(form, error.responseJSON.errors);
          } else {
            showDialog(error.responseJSON)
          }
        },
      }).always(() => {
        $('#processingLoader').addClass('d-none')
        $(this).removeAttr('disabled')
      })
    });

    $(document).on('click', '.rmv', function(event) {
      deleteRow($(this).parents('tr'))
    })
    $(document).on('change', '#statuspotongretur', function(event) {
      // deleteRow($(this).parents('tr'))
      if ($(this).val() == 219) {
        $('.potongkas').show() //potong kas
        $('#titlePotongkas').html('POSTING Penerimaan')
        $('[name=tglkasmasuk]').parents('.form-group').show()
        // $('[name=bank]').parents('.form-group').show()
        // $('[name=tglkasmasuk]').parents('.form-group').show()
      } else if ($(this).val() == 220) {
        $('.potongkas').hide() //potong hutang
        $('#titlePotongkas').html('POSTING Pengeluaran')
        $('[name=tglkasmasuk]').parents('.form-group').hide()
        $('[name=penerimaan_nobukti]').parents('.form-group').hide()
      } else {
        $('.potongkas').hide()
      }
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
      let pengeluaranStokHeaderId = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()



      if (action != 'delete') {
        $('#crudForm').find(`[name="detail_qty[]"]`).each((index, element) => {
          data.filter((row) => row.name === 'detail_qty[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="detail_qty[]"]`)[index])
        })
        $('#crudForm').find(`[name="detail_harga[]"]`).each((index, element) => {
          data.filter((row) => row.name === 'detail_harga[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="detail_harga[]"]`)[index])
        })

        $('#crudForm').find(`[name="detail_persentasediscount[]"]`).each((index, element) => {
          data.filter((row) => row.name === 'detail_persentasediscount[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="detail_persentasediscount[]"]`)[index])
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
        name: 'tgldariheader',
        value: $('#tgldariheader').val()
      })
      data.push({
        name: 'tglsampaiheader',
        value: $('#tglsampaiheader').val()
      })
      data.push({
        name: 'aksi',
        value: action.toUpperCase()
      })
      data.push({
        name: 'button',
        value: button
      })
      if (action != 'delete') {
        data.push({
          name: 'pengeluaranheader_id',
          value: data.find(item => item.name === "pengeluaranstok_id").value
        })
        // pengeluaranheader_id = data.find(item => item.name === "pengeluaranstok_id").value
      }
      // else {
      let pengeluaranheader_id = $('#kodepengeluaranheader').val();
      // }
      // console.log(action,$('#kodepengeluaranheader').val());
      let tgldariheader = $('#tgldariheader').val();
      let tglsampaiheader = $('#tglsampaiheader').val()

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}pengeluaranstokheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}pengeluaranstokheader/${pengeluaranStokHeaderId}`
          break;
        case 'delete':
          method = 'DELETE'
          // url = `${apiUrl}pengeluaranstokheader/${pengeluaranStokHeaderId}`
          url = `${apiUrl}pengeluaranstokheader/${pengeluaranStokHeaderId}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&pengeluaranheader_id=${pengeluaranheader_id}&indexRow=${indexRow}&limit=${limit}&page=${page}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}pengeluaranstokheader`
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
          $('#kodepengeluaranheader').val(response.data.pengeluaranstok_id).trigger('change')
          if (button == 'btnSubmit') {
            $('#crudModal').modal('hide')

            id = response.data.id

            $('#rangeHeader').find('[name=tgldariheader]').val(dateFormat(response.data.tgldariheader)).trigger('change');
            $('#rangeHeader').find('[name=tglsampaiheader]').val(dateFormat(response.data.tglsampaiheader)).trigger('change');
            $('#jqGrid').jqGrid('setGridParam', {
              postData: {
                proses: 'reload',
                pengeluaranheader_id: response.data.pengeluaranstok_id,
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
            if ($('#kodepengeluaranheader').val() != '') {
              createPengeluaranstokHeader()
              let IdPengeluaran = listIdPengeluaran.indexOf($('#kodepengeluaranheader').val());
              setKodePengeluaran(listKodePengeluaran[IdPengeluaran]);
              setIsDateAvailable($('#kodepengeluaranheader').val())

              $('#crudForm').find(`[name="pengeluaranstok"]`).val(listKodePengeluaran[IdPengeluaran])
              $('#crudForm').find(`[name="pengeluaranstok"]`).data('currentValue', listKodePengeluaran[IdPengeluaran])
              $('#crudForm').find(`[name="pengeluaranstok_id"]`).val($('#kodepengeluaranheader').val())
            } else {
              createPengeluaranstokHeader();
            }
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

  function setKodePengeluaran(kode) {
    kodePengeluaranStok = kode;
    setTampilanForm();

    if ($('#crudForm').data('action') == 'add') {
      if (kode != listKodePengeluaran[6]) {
        resetRow()
        initRowcreate()
      }
    }
  }

  function setTampilanForm() {
    tampilanall()
    switch (kodePengeluaranStok) {
      case listKodePengeluaran[0]: //'SPK':
        tampilanspk()
        break;
      case listKodePengeluaran[1]: //'RTR':
        tampilanrbt()
        break;
      case listKodePengeluaran[2]: //'KOR':
        tampilankor()
        break;
      case listKodePengeluaran[3]: //'PJA':
        tampilanPJA()
        break;
      case listKodePengeluaran[4]: //'GST':
        tampilanGST()
        break;
      case listKodePengeluaran[5]: //'KORV':
        tampilanKORV()
        break;
      case listKodePengeluaran[6]: //'AFKIR':
        tampilanAFKIR()
        break;
      default:
        tampilanInit()
        break;
    }
  }


  function tampilanspk() {
    $('[name=statuspotongretur]').parents('.form-group').hide()
    $('[name=penerimaanstok_nobukti]').parents('.form-group').show()
    $('[name=pengeluaranstok_nobukti]').parents('.form-group').hide()
    $('[name=servicein_nobukti]').parents('.form-group').show()
    $('[name=supplier]').parents('.form-group').hide()
    $('[name=gudang]').parents('.form-group').show()
    $('.tbl_qty').show()
    $('.tbl_statusoli').show();
    $('.tbl_statusban').hide();
    $('.tbl_vulkanisirke').hide();
    $('.tbl_vulkanisirtotal').hide();
    $('.tbl_harga').hide();
    $('.tbl_persentase').hide();
    $('.tbl_total').hide();
    $('.colspan').attr('colspan', 6);
    $('.sumrow').hide();
    $("#addRow").show();
    $("#detail-table").show();
    $("#detail-afkir").hide();
    $("#detail-afkir :input").attr("disabled", true);

  }


  function tampilanrbt() {

    $('[name=pengeluaranstok_nobukti]').parents('.form-group').hide()
    $('[name=servicein_nobukti]').parents('.form-group').hide()
    $('[name=kerusakan]').parents('.form-group').hide()
    $('[name=supir]').parents('.form-group').hide()
    $('[name=gandengan]').parents('.form-group').hide()
    $('[name=gudang]').parents('.form-group').hide()
    $('[name=trado]').parents('.form-group').hide()
    $('.tbl_qty').show()
    $('.tbl_harga').show()
    $('.tbl_total').show()
    $('.tbl_vulkanisirke').hide();
    $('.tbl_vulkanisirtotal').hide();
    $('.tbl_statusoli').hide();
    $('.tbl_statusban').hide();
    $('.tbl_persentase').hide();
    $('.colspan').attr('colspan', 5);
    $("#addRow").hide();
    $("#detail-table").show();
    $("#detail-afkir").hide();
    $("#detail-afkir :input").attr("disabled", true);
  }

  function tampilanPJA() {

    $('[name=penerimaanstok_nobukti]').parents('.form-group').hide()
    $('[name=statuspotongretur]').parents('.form-group').hide()

    $('[name=pengeluaranstok_nobukti]').parents('.form-group').hide()
    $('[name=servicein_nobukti]').parents('.form-group').hide()
    $('[name=kerusakan]').parents('.form-group').hide()
    $('[name=supir]').parents('.form-group').hide()
    $('[name=gandengan]').parents('.form-group').hide()
    $('[name=gudang]').parents('.form-group').hide()
    $('[name=trado]').parents('.form-group').hide()
    $('.tbl_qty').show()
    $('.tbl_harga').show()
    $('.tbl_total').show()
    $('.tbl_vulkanisirke').hide();
    $('.tbl_vulkanisirtotal').hide();
    $('.tbl_statusoli').hide();
    $('.tbl_statusban').hide();
    $('.tbl_persentase').hide();
    $('.colspan').attr('colspan', 5);
    $('.potongkas').show() //potong kas
    $("#addRow").show();
    $('#titlePotongkas').html('POSTING Penerimaan')
    $('[name=tglkasmasuk]').parents('.form-group').show()
    $("#detail-table").show();
    $("#detail-afkir").hide();
    $("#detail-afkir :input").attr("disabled", true);
  }

  function tampilanGST() {

    $('[name=kerusakan]').parents('.form-group').hide()
    $('[name=statuspotongretur]').parents('.form-group').hide()
    $('[name=penerimaanstok_nobukti]').parents('.form-group').hide()
    $('[name=pengeluaranstok_nobukti]').parents('.form-group').hide()
    $('[name=servicein_nobukti]').parents('.form-group').hide()
    $('[name=supplier]').parents('.form-group').hide()
    // $('[name=gudang]').parents('.form-group').hide()
    $('.tbl_qty').show()
    $('.tbl_vulkanisirke').hide();
    $('.tbl_vulkanisirtotal').hide();
    $('.tbl_harga').hide();
    $('.tbl_persentase').hide();
    $('.tbl_total').hide();
    $('.tbl_statusoli').hide();
    $('.tbl_statusban').hide();
    $('.colspan').attr('colspan', 5);
    $('.sumrow').hide();
    $("#detail-table").show();
    $("#detail-afkir").hide();
  }


  function tampilankor() {
    $('[name=supplier]').parents('.form-group').hide()
    $('[name=servicein_nobukti]').parents('.form-group').hide()
    $('[name=penerimaanstok_nobukti]').parents('.form-group').hide()
    $('[name=pengeluaranstok_nobukti]').parents('.form-group').hide()
    $('[name=kerusakan]').parents('.form-group').hide()
    $('[name=supir]').parents('.form-group').hide()
    $('[name=statuspotongretur]').parents('.form-group').hide()
    $('.tbl_qty').show()
    $('.tbl_vulkanisirke').hide();
    $('.tbl_vulkanisirtotal').hide();
    $('.tbl_harga').hide();
    $('.tbl_persentase').hide();
    $('.tbl_total').hide();
    $('.tbl_statusoli').hide();
    $('.tbl_statusban').hide();
    $('.colspan').attr('colspan', 5);
    $('.sumrow').hide();
    $("#detail-table").show();
    $("#addRow").show();
    $("#detail-afkir").hide();
    $("#detail-afkir :input").attr("disabled", true);
  }

  function tampilanKORV() {
    $('[name=trado]').parents('.form-group').hide()
    $('[name=gandengan]').parents('.form-group').hide()
    $('[name=gudang]').parents('.form-group').hide()
    $('[name=supplier]').parents('.form-group').hide()
    $('[name=servicein_nobukti]').parents('.form-group').hide()
    $('[name=penerimaanstok_nobukti]').parents('.form-group').hide()
    $('[name=pengeluaranstok_nobukti]').parents('.form-group').hide()
    $('[name=kerusakan]').parents('.form-group').hide()
    $('[name=supir]').parents('.form-group').hide()
    $('.potongkas').hide()
    $('[name=statuspotongretur]').parents('.form-group').hide()
    $('.tbl_qty').hide()
    $('.tbl_vulkanisirke').show();
    $('.tbl_vulkanisirtotal').show();
    $('.tbl_harga').hide();
    $('.tbl_persentase').hide();
    $('.tbl_statusoli').hide();
    $('.tbl_statusban').show();
    $('.tbl_total').hide();
    $('.colspan').attr('colspan', 7);
    $('.sumrow').hide();
    $("#detail-table").show();
    $("#detail-afkir").hide();
  }

  function tampilanAFKIR() {

    $('[name=nobukti]').parents('.form-group').show()
    $('[name=tglbukti]').parents('.form-group').show()
    $('[name=pengeluaranstok]').parents('.form-group').show()
    $('[name=supplier]').parents('.form-group').hide()
    $('[name=servicein_nobukti]').parents('.form-group').hide()
    $('[name=penerimaanstok_nobukti]').parents('.form-group').hide()
    $('[name=pengeluaranstok_nobukti]').parents('.form-group').hide()
    $('[name=kerusakan]').parents('.form-group').hide()
    $('[name=supir]').parents('.form-group').hide()
    $('[name=trado]').parents('.form-group').hide()
    $('[name=gandengan]').parents('.form-group').hide()
    $('[name=gudang]').parents('.form-group').hide()
    $('[name=statuspotongretur]').parents('.form-group').hide()
    $("#detail-table").hide();
    $('.rmv').parents('tr').remove();
    $("#detail-afkir").show();
    $("#detail-afkir :input").attr("disabled", false);
    $("#detail_satuan_id").attr("disabled", true);

  }

  function tampilanall() {
    $('[name=nobukti]').parents('.form-group').show()
    $('[name=tglbukti]').parents('.form-group').show()
    $('[name=pengeluaranstok]').parents('.form-group').show()
    $('[name=supplier]').parents('.form-group').show()
    $('[name=servicein_nobukti]').parents('.form-group').show()
    $('[name=penerimaanstok_nobukti]').parents('.form-group').show()
    $('[name=pengeluaranstok_nobukti]').parents('.form-group').show()
    $('[name=kerusakan]').parents('.form-group').show()
    $('[name=supir]').parents('.form-group').show()
    $('[name=trado]').parents('.form-group').show()
    $('[name=gandengan]').parents('.form-group').show()
    $('[name=gudang]').parents('.form-group').show()
    $('[name=statuspotongretur]').parents('.form-group').show()
    $("#detail-table").show();
    $("#detail-afkir").hide();
    $("#detail-afkir :input").attr("disabled", true);
    tampilanAllRow();
    // $('.data_tbl').show();
  }

  function tampilanInit() {
    $('[name=nobukti]').parents('.form-group').show()
    $('[name=tglbukti]').parents('.form-group').show()
    $('[name=pengeluaranstok]').parents('.form-group').show()
    $('[name=supplier]').parents('.form-group').hide()
    $('[name=servicein_nobukti]').parents('.form-group').hide()
    $('[name=penerimaanstok_nobukti]').parents('.form-group').hide()
    $('[name=pengeluaranstok_nobukti]').parents('.form-group').hide()
    $('[name=kerusakan]').parents('.form-group').hide()
    $('[name=supir]').parents('.form-group').hide()
    $('[name=trado]').parents('.form-group').hide()
    $('[name=gandengan]').parents('.form-group').hide()
    $('[name=gudang]').parents('.form-group').hide()
    $('[name=statuspotongretur]').parents('.form-group').hide()
    $("#detail-table").show();
    $("#detail-afkir").hide();
    $("#detail-afkir :input").attr("disabled", true);
    tampilanAllRow();
    // $('.data_tbl').show();
  }

  function tampilanAllRow() {
    $('.tbl_vulkanisirke').hide()
    $('.tbl_vulkanisirtotal').hide()
    $('.tbl_qty').show()
    $('.tbl_harga').show()
    $('.tbl_persentase').show()
    $('.tbl_total').show()
    $('.colspan').attr('colspan', 7);
  }

  $('#crudModal').on('shown.bs.modal', () => {
    let form = $('#crudForm')

    setFormBindKeys(form)

    activeGrid = null
    initDatepicker()
    initLookup()
    if (form.data('action') == 'add') {
      if ($('#kodepengeluaranheader').val() != '') {
        let IdPengeluaran = listIdPengeluaran.indexOf($('#kodepengeluaranheader').val());
        setKodePengeluaran(listKodePengeluaran[IdPengeluaran]);
        setIsDateAvailable($('#kodepengeluaranheader').val())

        $('#crudForm').find(`[name="pengeluaranstok"]`).val(listKodePengeluaran[IdPengeluaran])
        $('#crudForm').find(`[name="pengeluaranstok"]`).data('currentValue', listKodePengeluaran[IdPengeluaran])
        $('#crudForm').find(`[name="pengeluaranstok_id"]`).val($('#kodepengeluaranheader').val())
      }
    }
    initSelect2($('#statuspotongretur'), true)
    initSelect2($(`#statusban`), true)
    if (form.data('action') !== 'add') {
      $('#crudForm').find('[name=tglbukti]').attr('readonly', 'readonly').css({
        background: '#fff'
      })
      let tglbukti = $('#crudForm').find(`[name="tglbukti"]`).parents('.input-group').children()
      tglbukti.find('button').attr('disabled', true)
      let pengeluaranstok = $('#crudForm').find(`[name="pengeluaranstok"]`).parents('.input-group')
      pengeluaranstok.children().attr('readonly', true)
      pengeluaranstok.children().find('.lookup-toggler').attr('disabled', true)
      pengeluaranstok.find('button.button-clear').remove()

      let penerimaanstok_nobukti = $('#crudForm').find(`[name="penerimaanstok_nobukti"]`).parents('.input-group')
      penerimaanstok_nobukti.children().attr('readonly', true)
      penerimaanstok_nobukti.children().find('.lookup-toggler').attr('disabled', true)
      penerimaanstok_nobukti.find('button.button-clear').remove()
      $('#pengeluaranstokId').attr('readonly', true);

      let supplier = $('#crudForm').find(`[name="supplier"]`).parents('.input-group')
      supplier.children().attr('readonly', true)
      supplier.children().find('.lookup-toggler').attr('disabled', true)
      supplier.find('button.button-clear').remove()
      $('#supplierId').attr('readonly', true);
      $('#supplierId').attr('readonly', true);
      $('#statuspotongretur').attr('readonly', true);

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
    // getMaxLength(form)
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    removeEditingBy($('#crudForm').find('[name=id]').val())
    $('#crudModal').find('.modal-body').html(modalBody)
    initDatepicker('datepickerIndex')
    kodePengeluaranStok = ""
    KelompokId = ""
    StokId = ""
  })

  function removeEditingBy(id) {

    let formData = new FormData();


    formData.append('id', id);
    formData.append('aksi', 'BATAL');
    formData.append('table', 'pengeluaranstokheader');

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

  function createPengeluaranstokHeader() {
    resetRow()
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Add Pengeluaran Stok')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusPotongReturOptions(form),
        setStatusOliOptions(),
        setStatusBanDetailOptions(form),
        setStatusBanOptions(form)
      ])
      .then(() => {
        if (selectedRows.length > 0) {
          clearSelectedRows()
        }
        $('#crudModal').modal('show')
        // addRow()
        initRowcreate()
        // sumary()
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
    // initLookup()
    // addRow()
    // sumary()
  }

  function editPengeluaranstokHeader(pengeluaranStokHeaderId) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Pengeluaran Stok')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusPotongReturOptions(form),
        setStatusOliOptions(),
        setStatusBanDetailOptions(form),
        setStatusBanOptions(form)
      ])
      .then((showPengeluaranStok) => {
        showPengeluaranstokHeader(form, pengeluaranStokHeaderId)
          .then((showPengeluaranStok) => {

            let data = showPengeluaranStok;
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            $('#crudModal').modal('show')
            if ((data.statuseditketerangan_id == statusBisaEdit) && (data.statusedit_id != statusBisaEdit)) {
              form.find('[name]').attr('readonly', 'readonly')
              form.find('[name=id]').prop('disabled', false)
              form.find('[name="detail_keterangan[]"]').prop('readonly', false)

              let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
              name.attr('readonly', true)
              name.find('.lookup-toggler').attr('disabled', true)

              $('.tbl_aksi').hide()
            }

          })
      })
      .catch((error) => {
        console.log(error);
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
    // initLookup()
  }

  function deletePengeluaranstokHeader(pengeluaranStokHeaderId) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-trash"></i>
    Delete
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Pengeluaran Stok')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusPotongReturOptions(form),
        setStatusOliOptions(),
        setStatusBanDetailOptions(form),
        setStatusBanOptions(form)
      ])
      .then(() => {
        showPengeluaranstokHeader(form, pengeluaranStokHeaderId)
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
            form.find('[name=id]').prop('disabled', false);

          })
          .then(() => {
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            $('#crudModal').modal('show')
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
      })
    // initLookup()
  }

  function viewPengeluaranstokHeader(pengeluaranStokHeaderId) {
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
    $('#crudModalTitle').text('View Pengeluaran Stok')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusPotongReturOptions(form),
        setStatusOliOptions(),
        setStatusBanDetailOptions(form),
        setStatusBanOptions(form)
      ])
      .then(() => {
        showPengeluaranstokHeader(form, pengeluaranStokHeaderId)
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
            form.find('[name=id]').prop('disabled', false);

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
      })
    // initLookup()
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}pengeluaranstokheader/field_length`,
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
  const setStatusPotongReturOptions = function(relatedForm) {

    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statuspotongretur]').empty()
      relatedForm.find('[name=statuspotongretur]').append(
        new Option('-- PILIH STATUS POTONG RETUR --', '', false, true)
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
              "data": "STATUS POTONG RETUR"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusAktif => {
            let option = new Option(statusAktif.text, statusAktif.id)

            relatedForm.find('[name=statuspotongretur]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  let dataStatusOli
  const setStatusOliOptions = function() {
    return new Promise((resolve, reject) => {

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
              "data": "STATUS OLI"
            }]
          })
        },
        success: response => {
          dataStatusOli = response.data
          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }


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
            "groupOp": "ANDNOT",
            "rules": [{
                "field": "grp",
                "op": "cn",
                "data": "STATUS KONDISI BAN",
                "execpt_field": "text",
                "execpt_data": "MASAK",
              },
              {
                "field": "grp",
                "op": "cn",
                "data": "STATUS KONDISI BAN",
                "execpt_field": "text",
                "execpt_data": "MENTAH",
              },
            ]
          })
        },
        success: response => {
          response.data.forEach(statusReuse => {
            let option = new Option(statusReuse.text, statusReuse.id)

            relatedForm.find('#statusban').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }
  let dataStatusBan
  const setStatusBanDetailOptions = function(relatedForm) {
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
          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
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

  function getVulkanAfkir(stok_id) {
    $.ajax({
      url: `${apiUrl}stok/${stok_id}/getvulkan`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        $('#afkir_vulkanisirke').val(parseInt(response.data.totalvulkan))
      },
      error: error => {
        showDialog(error.responseJSON)
      }
    })
  }



  function addRow() {
    let detailRow = $(`
    <tr class="trow">
                  <td>
                    <div class="baris">1</div>
                  </td>
                  
                  <td>
                    <input name="id_detail[]" hidden value="${detail.id}">
                    <input type="text"  name="detail_stok[]" id="stokdetailaddrow${index}" class="form-control detail_stok_${index}">
                    <input type="text" id="detailstokId_${index}" readonly hidden class="detailstokId" name="detail_stok_id[]">
                    <input type="text" id="detailstokKelompok_${index}" readonly hidden class="detailstokKelompok" name="detail_stok_kelompok[]">

                  </td>                 
                  <td>
                    <input type="text" disabled name="detail_satuan[]" id="" class="form-control detail_satuan_${index}">
                  </td>       
                  <td class="data_tbl tbl_statusoli">
                    <select name="detail_statusoli[]" class="form-select select2bs4" id="statusoli${index}" style="width: 100%;">
                      <option value="">-- PILIH STATUS OLI --</option>
                    </select>
                  </td>
                  <td>
                    <textarea rows="1" placeholder="" name="detail_keterangan[]" id="detail_keterangan${index}" class="form-control"></textarea>
                  </td>
                  <td class="data_tbl tbl_qty">
                    <div id="qtytestlookup${index}" style="display:none;" >
                      <input type="text"  name="detail_qty_oli[]" id="detail_qty_oli${index}" class="form-control qtytambahgantioli-lookup${index}">
                    </div>

                    <input type="text"  name="detail_qty[]" id="detail_qty${index}" onkeyup="calculate(${index})" style="text-align:right" class="form-control autonumeric number${index}">
                  </td>  
                  <td class="data_tbl tbl_statusban">
                    <select name="detail_statusban[]" class="form-select select2bs4" id="statusban${index}" style="width: 100%;">
                      <option value="">-- PILIH STATUS BAN --</option>
                    </select>                 
                  </td> 
                  <td class="data_tbl tbl_vulkanisirke">
                      <input type="number"  name="detail_vulkanisirke[]" style="" class="form-control">                    
                    </td> 
                  <td class="data_tbl tbl_vulkanisirtotal">
                      <input type="number"  name="detail_vulkanisirtotal[]" readonly id="vulkanisirtotal${index}" style="" class="form-control">                    
                    </td> 
                  <td class="data_tbl tbl_harga">
                    <input type="text"  name="detail_harga[]" id="detail_harga${index}" readonly style="text-align:right" class="form-control autonumeric number${index}">
                  </td>  
                  
                  <td class="data_tbl tbl_persentase">
                    <input type="text"  name="detail_persentasediscount[]" id="detail_persentasediscount${index}" onkeyup="calculate(${index})" style="text-align:right" class="form-control autonumeric number${index}">
                  </td>  
                  <td class="data_tbl tbl_total">
                    <input type="text"  name="totalItem[]"  id="totalItem${index}" onkeyup="calculate(${index})" style="text-align:right" class="form-control totalItem autonumeric number${index}">                    
                  </td>  
                  
                  <td class="data_tbl tbl_aksi" >
                    <div class='btn btn-danger btn-sm rmv'>Delete</div>
                  </td>
              </tr>
    `)
    // // if (kodePengeluaranStok == 'SPK') {


    // // }
    $('table #table_body').append(detailRow)
    initSelect2($(`#statusoli${index}`), true)
    initSelect2($(`#statusban${index}`), true)
    dataStatusOli.forEach(statusOli => {
      let option = new Option(statusOli.text, statusOli.id)

      detailRow.find(`#statusoli${index}`).append(option).trigger('change')
    });
    dataStatusBan.forEach(statusBan => {
      option = new Option(statusBan.text, statusBan.id)
      detailRow.find(`#statusban${index}`).append(option).trigger('change')
    });
    var row = index;

    var nobuktipenerimaan = '';
    var idpengeluaranstok = '';
    var penerimaanstok_nobukti = $('#crudModal').find(`[name=penerimaanstok_nobukti]`).val();
    var pengeluaranstokId = $(`#pengeluaranstokId`).val();


    if (kodePengeluaranStok == listKodePengeluaran[1]) {
      idpengeluaranstok = pengeluaranstokId;
      nobuktipenerimaan = penerimaanstok_nobukti;
    }
    $(`.detail_stok_${row}`).lookupV3({
      title: 'stok Lookup',
      fileName: 'stokV3',
      searching: ['namstok'],
      extendSize: md_extendSize_1,
      multiColumnSize:true,
      labelColumn: false,
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        if (kodePengeluaranStok == listKodePengeluaran[0]) { //spk
          idpengeluaranstok = $(`#pengeluaranstokId`).val();
        }
        var nobukti = $('#crudModal').find(`[name=nobukti]`).val();
        cekKelompok(row);
        this.postData = {
          from: 'pengeluaranstok',
          Aktif: 'AKTIF',
          // if  (kodePengeluaranStok=listKodePengeluaran[1])  {
          pengeluaranstok_id: idpengeluaranstok,
          penerimaanstokheader_nobukti: nobuktipenerimaan,
          KelompokId: KelompokId,
          nobukti : nobukti,          
          StokId: StokId,
          isLookup: true
          // },


        }
      },
      onSelectRow: (stok, element) => {
        element.val(stok.namastok)
        parent = element.closest('td');
        parent.children('.detailstokId').val(stok.id)
        parent.children('.detailstokKelompok').val(stok.kelompok_id)
        element.data('currentValue', element.val())

        let satuanEl = element.parents('tr').find(`td [name="detail_satuan[]"]`);
        satuanEl.val(stok.satuan);
        let iddetailEl = element.parents('tr').find(`td [name="id_detail[]"]`);
        iddetailEl.val(stok.iddetail);


        setKorv(row, stok.id);
        let service = stok.servicerutin_text;

        let elStatusOli = element.parents('tr').find(`td [name="detail_statusoli[]"]`);
        elStatusOli.find(`option:contains('TAMBAH')`).remove()
        elStatusOli.find(`option:contains('GANTI')`).remove()
        // console.log(kodePengeluaranStok, listKodePengeluaran[1]);
        if (kodePengeluaranStok == listKodePengeluaran[1]) {
          if (nobuktipenerimaan != '') {
            $(`#detail_keterangan${row}`).val(stok.penerimaanstokdetail_keterangan);
            $(`#detail_qty${row}`).val(stok.penerimaanstokdetail_qty);
            $(`#detail_harga${row}`).val(stok.penerimaanstokdetail_harga);
            $(`#totalItem${row}`).val(stok.penerimaanstokdetail_total);
            $(`#totalItem${row}`).prop('readonly', true)
            $(`#statusoli${row}`).remove()
            $(`#statusban${row}`).remove()
            initAutoNumeric($(`.number${row}`))
            sumary()
          }
        }

        if (service == 'PERGANTIAN BATERE' || service == 'PERGANTIAN SARINGAN HAWA') {
          dataStatusOli.forEach(statusOli => {
            let option = new Option(statusOli.text, statusOli.id)

            elStatusOli.append(option).trigger('change')
          });

          elStatusOli.find(`option:contains('TAMBAH')`).remove()
          elStatusOli.trigger('change')
        } else if (service == '') {
          dataStatusOli.forEach(statusOli => {
            let option = new Option(statusOli.text, statusOli.id)

            elStatusOli.append(option).trigger('change')
          });

          elStatusOli.find(`option:contains('TAMBAH')`).remove()
          elStatusOli.find(`option:contains('GANTI')`).remove()
          elStatusOli.trigger('change')
          $(`#detail_qty_oli${row}`).hide()
          $(`#qtytestlookup${row}`).hide()
          $(`#detail_qty${row}`).show()
        } else {
          $(`#detail_qty_oli${row}`).show()
          $(`#qtytestlookup${row}`).show()
          $(`#detail_qty${row}`).hide()
          console.log(`#qtytestlookup${row}`, `detail_qty${row}`);
          dataStatusOli.forEach(statusOli => {
            let option = new Option(statusOli.text, statusOli.id)

            elStatusOli.append(option).trigger('change')
          });
        }
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        let satuanEl = element.parents('tr').find(`td [name="detail_satuan[]"]`);
        satuanEl.val('');
        element.val('')
        element.data('currentValue', element.val())
        dataStatusOli.forEach(statusOli => {
          let option = new Option(statusOli.text, statusOli.id)

          elStatusOli.append(option).trigger('change')
        });
      }
    })

    $(`.qtytambahgantioli-lookup${row}`).lookup({
      title: 'qtytambahgantioli Lookup',
      fileName: 'qtytambahgantioli',
      beforeProcess: function(test) {
        this.postData = {
          // var levelcoa = $(`#levelcoa`).val();
          Aktif: 'AKTIF',
          stok_id: $(`#detailstokId_${row}`).val(),
          statusoli: $(`#statusoli${row}`).val(),
          isLookup: true

        }
      },

      onSelectRow: (qtytambahgantioli, element) => {
        element.val(qtytambahgantioli.qty)
        elQty = AutoNumeric.getAutoNumericElement($(`#detail_qty${row}`)[0]);
        elQty.set(qtytambahgantioli.qty);
        // $(`#${element[0]['name']}Id`).val(qtytambahgantioli.id)
        element.data('currentValue', element.val())
        lookupSelected(`qtytambahgantioli`);

      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        element.data('currentValue', element.val())
        elQty = AutoNumeric.getAutoNumericElement($(`#detail_qty${row}`)[0]);
        elQty.set(0);
        enabledKorDisable()
      }
    })
    if (kodePengeluaranStok != listKodePengeluaran[1]) {
      if (nobuktipenerimaan == '') {
        initAutoNumeric($(`.number${row}`))
      }
    }
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

  function initRowcreate() {
    let countRow = $('.rmv').parents('tr').length
    // console.log(countRow);
    if (countRow <= 1) {
      addRow()
    }
    // sumary()
    setRowNumbers()
  }

  function resetRow() {
    $('.trow').remove()
  }

  function setRowNumbers() {
    let elements = $('table #table_body tr td:nth-child(1)')

    elements.each((index, element) => {
      $(element).text(index + 1)
    })
  }

  function calculate(id) {

    if (kodePengeluaranStok == listKodePengeluaran[1]) {
      if ($('#crudModal').find(`[name=penerimaanstok_nobukti]`).val() != '') {
        return cal(id)
      }
    }


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

  function penerimaanOrServicein(el, disabled = true) {
    if (disabled) {
      switch (el) {
        case 'penerimaan':
          $('#crudForm').find(`[name="servicein_nobukti"]`).parents('.input-group').children().attr('disabled', true)
          $('#crudForm').find(`[name="servicein_nobukti"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled', true)
          break;
        case 'servicein':
          $('#crudForm').find(`[name="penerimaanstok_nobukti"]`).parents('.input-group').children().attr('disabled', true)
          $('#crudForm').find(`[name="penerimaanstok_nobukti"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled', true)
        default:
          break;
      }
    } else {
      $('#crudForm').find(`[name="servicein_nobukti"]`).parents('.input-group').children().attr('disabled', false)
      $('#crudForm').find(`[name="servicein_nobukti"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled', false)
      $('#crudForm').find(`[name="penerimaanstok_nobukti"]`).parents('.input-group').children().attr('disabled', false)
      $('#crudForm').find(`[name="penerimaanstok_nobukti"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled', false)
    }
  }

  function lookupSelected(el) {
    if ((kodePengeluaranStok == listKodePengeluaran[0]) || (kodePengeluaranStok == listKodePengeluaran[1]) || (kodePengeluaranStok == listKodePengeluaran[2]) || (kodePengeluaranStok == listKodePengeluaran[4]) || (kodePengeluaranStok == listKodePengeluaran[5])) {
      // console.log(kodepengeluaranstok);
      // console.log(el);
      switch (el) {
        case 'trado':
          $('#crudForm').find(`[name="gandengan"]`).parents('.input-group').children().attr('disabled', true)
          $('#crudForm').find(`[name="gandengan"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled', true)
          $('#gandenganId').attr('disabled', true);
          $('#crudForm').find(`[name="gudang"]`).parents('.input-group').children().attr('disabled', true)
          $('#crudForm').find(`[name="gudang"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled', true)
          $('#gudangId').attr('disabled', true);
          break;
        case 'gandengan':
          $('#crudForm').find(`[name="trado"]`).parents('.input-group').children().attr('disabled', true)
          $('#crudForm').find(`[name="trado"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled', true)
          $('#tradoId').attr('disabled', true);
          $('#crudForm').find(`[name="gudang"]`).parents('.input-group').children().attr('disabled', true)
          $('#crudForm').find(`[name="gudang"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled', true)
          $('#gudangId').attr('disabled', true);

          break;
        case 'gudang':
          $('#crudForm').find(`[name="trado"]`).parents('.input-group').children().attr('disabled', true)
          $('#crudForm').find(`[name="trado"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled', true)
          $('#tradoId').attr('disabled', true);
          $('#crudForm').find(`[name="gandengan"]`).parents('.input-group').children().attr('disabled', true)
          $('#crudForm').find(`[name="gandengan"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled', true)
          $('#gandenganId').attr('disabled', true);

          break;
        default:
          break;
      }
      // } else if (kodePengeluaranStok == listKodePengeluaran[0]) {
      //   switch (el) {
      //     case 'trado':
      //       $('#crudForm').find(`[name="gandengan"]`).attr('disabled', true)
      //       $('#crudForm').find(`[name="gandengan"]`).parents('.input-group').children().attr('disabled', true)
      //       $('#crudForm').find(`[name="gandengan"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled', true)
      //       $('#gandenganId').attr('disabled', true);
      //       break;
      //     case 'gandengan':
      //       $('#crudForm').find(`[name="trado"]`).attr('disabled', true)
      //       $('#crudForm').find(`[name="trado"]`).parents('.input-group').children().attr('disabled', true)
      //       $('#crudForm').find(`[name="trado"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled', true)
      //       $('#tradoId').attr('disabled', true);
      //     default:
      //       break;
      //   }
    }
  }

  function enabledKorDisable() {
    $('#crudForm').find(`[name="gudang"]`).parents('.input-group').children().attr("disabled", false);
    $('#crudForm').find(`[name="gudang"]`).parents('.input-group').children().find(`.lookup-toggler`).attr("disabled", false);
    $('#gudangId').attr('disabled', false);
    $('#crudForm').find(`[name="trado"]`).parents('.input-group').children().attr("disabled", false);
    $('#crudForm').find(`[name="trado"]`).parents('.input-group').children().find(`.lookup-toggler`).attr("disabled", false);
    $('#tradoId').attr('disabled', false);
    $('#crudForm').find(`[name="gandengan"]`).parents('.input-group').children().attr("disabled", false);
    $('#crudForm').find(`[name="gandengan"]`).parents('.input-group').children().find(`.lookup-toggler`).attr("disabled", false);
    $('#gandenganId').attr('disabled', false);
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
        $('#crudForm').find('[name=supplier]').val(data.supplier).attr('readonly', true);
        $('#crudForm').find('[name=supplier]').data('currentValue', data.supplier)

        $('#crudForm').find('[name=supplier_id]').val(data.supplier_id)

        $('#crudForm').find('[name=gudang]').val(data.gudang).attr('readonly', true);
        $('#crudForm').find('[name=gudang]').data('currentValue', data.gudang)
        $('#crudForm').find('[name=gudang_id]').val(data.gudang_id)
      },
      error: error => {
        showDialog(error.statusText)
      }
    })
  }

  function sumary() {
    let sumary = 0;
    $('.totalItem').each(function() {
      var totalItem = AutoNumeric.getNumber($(this)[0]);
      sumary += totalItem;
    })
    new AutoNumeric($('#sumary')[0]).set(sumary);
  }

  function pengeluaranStok(form) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}pengeluaranstok`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $.each(response.data, (index, data) => {
            listIdPengeluaran[index] = data.id;
            listKodePengeluaran[index] = data.kodepengeluaran;
          })

        }
      })
    })
  }


  function setIsDateAvailable(pengeluaran_id) {
    $.ajax({
      url: `${apiUrl}bukapengeluaranstok/${pengeluaran_id}/cektanggal`,
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

  function showPengeluaranstokHeader(form, pengeluaranStokHeaderId) {
    return new Promise((resolve, reject) => {
      resetRow()
      $.ajax({
        url: `${apiUrl}pengeluaranstokheader/${pengeluaranStokHeaderId}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          sum = 0;
          var statusformat;
          var persediaan = ''
          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)
            if (element.attr("name") == 'tglbukti') {
              var result = value.split('-');
              element.val(result[2] + '-' + result[1] + '-' + result[0]);
            } else if (element.attr("name") == 'tglkasmasuk') {
              var result = value.split('-');
              element.val(result[2] + '-' + result[1] + '-' + result[0]);
            } else if (element.is('select')) {
              element.val(value).trigger('change')
            } else {
              element.val(value)
            }

          })
          if (form.find(`[name="trado_id"]`).val() > 0) {
            persediaan = 'trado'
            form.find(`[name="trado"]`).data('currentValue', form.find(`[name="trado"]`).val())
          }
          if (form.find(`[name="gandengan_id"]`).val() > 0) {
            persediaan = 'gandengan'
            form.find(`[name="gandengan"]`).data('currentValue', form.find(`[name="gandengan"]`).val())
          }
          $('#detailList tbody').html('')

          if (listKodePengeluaran[1] == response.data.pengeluaranstok) {//rtr
            $.each(response.detail, (id, detail) => {
              let detailRow = $(`
                <tr class="trow">
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
                        <input type="text" disabled name="detail_satuan[]" id="" value="${detail.satuan}" class="form-control detail_satuan_${index}">
                      </td>   
                      <td>
                        <textarea rows="1" placeholder="" name="detail_keterangan[]" class="form-control"></textarea>
                      </td>
                      <td class="data_tbl tbl_qty" >
                        <input type="text"  name="detail_qty[]" id="detail_qty${id}" onkeyup="cal(${id})" style="text-align:right" class="form-control autonumeric number${id}">                    
                      </td>
                      <td class="data_tbl tbl_vulkanisirke"  style="display: none;" >
                        <input type="text"  name="detail_vulkanisirke[]" style="" class="form-control">                    
                      </td> 
                      <td class="data_tbl tbl_vulkanisirtotal"  style="display: none;" >
                        <input type="text"  name="detail_vulkanisirtotal[]" readonly id="vulkanisirtotal${id}" style="" class="form-control">                    
                      </td> 
                      
                      <td class="data_tbl tbl_harga">
                        <input type="text"  name="detail_harga[]" id="detail_harga${id}" readonly style="text-align:right" class="autonumeric number${id} form-control">                    
                      </td>  
                      
                      <td class="data_tbl tbl_persentase" style="display: none;">
                        <input type="text"  name="detail_persentasediscount[]" id="detail_persentasediscount${id}" onkeyup="calculate(${id})" style="text-align:right" class="autonumeric number${id} form-control">                    
                      </td>  
                      <td class="data_tbl tbl_total">
                        <input type="text"  name="totalItem[]" id="totalItem${id}" readonly onkeyup="calculate(${id})" style="text-align:right" class="form-control totalItem autonumeric number${id}">                    
                      </td>  
                      <td>
                        <div class='btn btn-danger btn-sm rmv'>Delete</div>
                      </td>
                  </tr>
              `)

              detailRow.find(`[name="detail_nobukti[]"]`).val(detail.nobukti)
              detailRow.find(`[name="detail_stok[]"]`).val(detail.stok)
              detailRow.find(`[name="detail_stok_id[]"]`).val(detail.stok_id)
              detailRow.find(`[name="detail_qty[]"]`).val(detail.qty)
              detailRow.find(`[name="detail_harga[]"]`).val(detail.harga)
              detailRow.find(`[name="detail_persentasediscount[]"]`).val(detail.persentasediscount)
              // detailRow.find(`[name="totalItem[]"]`).val(detail.total)
              detailRow.find(`[name="detail_keterangan[]"]`).val(detail.keterangan)
              initSelect2($(`#statusban${id}`), true)
              initSelect2($(`#statusoli${id}`), true)
              $('table #table_body').append(detailRow)
              // initAutoNumeric($(`.number${id}`))
              // initAutoNumeric($(`#detail_qty${id}`), {
              //   'maximumValue': detail.qty
              // })
              initAutoNumeric($(`#detail_qty${id}`))
              initAutoNumeric($(`#detail_harga${id}`))
              initAutoNumeric($(`#detail_persentasediscount${id}`))
              initAutoNumeric($(`#totalItem${id}`))
              cal(id)
              setRowNumbers()
              // $(`#detail_stok_${id}`).lookup({
              //   title: 'stok Lookup',
              //   fileName: 'stok',
              //   onSelectRow: (stok, element) => {
              //     element.val(stok.namastok)
              //     parent = element.closest('td');
              //     parent.children('.detailstokId').val(stok.id)
              //     element.data('currentValue', element.val())
              //   },
              //   onCancel: (element) => {
              //     element.val(element.data('currentValue'))
              //   }
              // })
              id++;
              row = id;
              index = id;
            })

          } else if (listKodePengeluaran[6] == response.data.pengeluaranstok) {//afkir

            form.find(`[name="detail_stok[]"]`).val(response.detail[0].stok)
            form.find(`[name="detail_stok_id[]"]`).val(response.detail[0].stok_id)
            form.find(`[name="pengeluarantrucking_nobukti"]`).val(response.data.pengeluarantrucking_nobukti)
            form.find(`[name="statusban[]"]`).val(response.detail[0].statusban).trigger('change')
            form.find(`[name="detail_vulkanisirke[]"]`).val(response.detail[0].vulkanisirke)
            form.find(`[name="jlhhari"]`).val(response.detail[0].jlhhari)
            // form.find(`[name="tglklaim"]`).val()
            // form.find(`[name="nobukti_pjt"]`).val()
            // form.find(`[name="jlhhari"]`).val()
            form.find(`[name="detail_keterangan[]"]`).val(response.detail[0].keterangan)
            $(`#qty_afkir`).val(response.detail[0].qty)
            getVulkanAfkir(response.detail[0].stok_id)
          } else {
            $.each(response.detail, (id, detail) => {
              let idDetail = id
              let detailRow = $(`
                <tr class="trow">
                      <td>
                        <div class="baris">1</div>
                      </td>
                      
                      <td>
                        <input name="id_detail[]" hidden value="${detail.id}">
                        <input type="text"  name="detail_stok[]" id="detail_stok_${id}" class="form-control stok-lookup ">
                        <input type="text" id="detailstokId_${id}" data-current-value="${detail.stok}" readonly hidden class="detailstokId" name="detail_stok_id[]">
                        <input type="text" id="detailstokKelompok_${id}" value="${detail.kelompok_id}" readonly hidden class="detailstokKelompok" name="detail_stok_kelompok[]">
                      </td>
                      <td>
                        <input type="text" disabled name="detail_satuan[]" id="" value="${detail.satuan}" class="form-control detail_satuan_${index}">
                      </td>   
                      <td class="data_tbl tbl_statusoli">
                        <select name="detail_statusoli[]" class="form-select select2bs4" id="statusoli${id}" style="width: 100%;">
                          <option value="">-- PILIH STATUS OLI --</option>
                        </select>                 
                      </td>
                      <td>
                        <textarea rows="1" placeholder="" name="detail_keterangan[]" class="form-control"></textarea>
                      </td>
                      <td class="data_tbl tbl_qty">
                        <div id="qtytestlookup${id}" style="display:none;" >
                          <input type="text"  name="detail_qty_oli[]" id="detail_qty_oli${id}" data-ided="${id}" class="form-control qtytambahgantioli-lookup${id}">
                        </div>
                        
                        <input type="text"  name="detail_qty[]" id="detail_qty${id}" onkeyup="calculate(${id})" style="text-align:right" class="form-control autonumeric number${id}">                    
                      </td>  
                      <td class="data_tbl tbl_statusban">
                        <select name="detail_statusban[]" class="form-select select2bs4" id="statusban${id}" style="width: 100%;">
                          <option value="">-- PILIH STATUS BAN --</option>
                        </select>                 
                      </td> 
                      <td class="data_tbl tbl_vulkanisirke">
                        <input type="number"  name="detail_vulkanisirke[]" style="" class="form-control">                    
                      </td>  
                      <td class="data_tbl tbl_vulkanisirtotal">
                        <input type="number"  name="detail_vulkanisirtotal[]" readonly id="vulkanisirtotal${id}" style="" class="form-control">                    
                      </td>  
                      <td class="data_tbl tbl_harga">
                        <input type="text"  name="detail_harga[]" id="detail_harga${id}" readonly style="text-align:right" class="autonumeric number${id} form-control">                    
                      </td>  
                      
                      <td class="data_tbl tbl_persentase">
                        <input type="text"  name="detail_persentasediscount[]" id="detail_persentasediscount${id}" onkeyup="calculate(${id})" style="text-align:right" class="autonumeric number${id} form-control">                    
                      </td>  
                      <td class="data_tbl tbl_total">
                        <input type="text" readonly name="totalItem[]" id="totalItem${id}" onkeyup="calculate(${id})" style="text-align:right" class="form-control totalItem autonumeric number${id}">                    
                      </td>  
                      <td class="data_tbl tbl_aksi" >
                        <div class='btn btn-danger btn-sm rmv'>Delete</div>
                      </td>
                  </tr>
              `)


              dataStatusBan.forEach(statusBan => {
                option = new Option(statusBan.text, statusBan.id)
                detailRow.find(`#statusban${id}`).append(option).trigger('change')
              });

              detailRow.find(`[name="detail_nobukti[]"]`).val(detail.nobukti)
              detailRow.find(`[name="detail_stok[]"]`).val(detail.stok)
              detailRow.find(`[name="detail_stok_id[]"]`).val(detail.stok_id)
              detailRow.find(`[name="detail_qty[]"]`).val(detail.qty)
              detailRow.find(`[name="detail_qty_oli[]"]`).val(detail.qty)
              detailRow.find(`[name="detail_harga[]"]`).val(detail.harga)
              detailRow.find(`[name="detail_persentasediscount[]"]`).val(detail.persentasediscount)
              detailRow.find(`[name="detail_vulkanisirke[]"]`).val(detail.vulkanisirke)
              detailRow.find(`[name="totalItem[]"]`).val(detail.total)
              detailRow.find(`[name="detail_keterangan[]"]`).val(detail.keterangan)
              $('table #table_body').append(detailRow)

              initSelect2($(`#statusban${id}`), true)
              initSelect2($(`#statusoli${id}`), true)
              setKorv(id, detail.stok_id);


              if (response.data.pengeluaranstok == 'SPK') {
                service = detail.statusservicerutin;
                dataStatusOli.forEach(statusOli => {
                  let option = new Option(statusOli.text, statusOli.id)

                  detailRow.find(`#statusoli${id}`).append(option).trigger('change')
                });

                if (service == 'PERGANTIAN BATERE' || service == 'PERGANTIAN SARINGAN HAWA') {
                  detailRow.find(`#statusoli${id} option:contains('TAMBAH')`).remove()
                  detailRow.trigger('change')
                } else if (service == null) {

                  detailRow.find(`#statusoli${id} option:contains('TAMBAH')`).remove()
                  detailRow.find(`#statusoli${id} option:contains('GANTI')`).remove()
                  detailRow.find(`#statusoli${id}`).trigger('change')
                  $(`#detail_qty_oli${id}`).hide()
                  $(`#qtytestlookup${id}`).hide()
                  $(`#detail_qty${id}`).show()
                } else {
                  $(`#detail_qty_oli${id}`).show()
                  $(`#qtytestlookup${id}`).show()
                  $(`#detail_qty${id}`).hide()
                }

                detailRow.find(`[name="detail_statusoli[]"]`).val(detail.statusoli).trigger('change')

              }

              // initAutoNumeric($(`.number${id}`))
              // initAutoNumeric($(`#detail_qty${id}`), {
              //   'maximumValue': detail.qty
              // })
              initAutoNumeric($(`#detail_qty${id}`))
              initAutoNumeric($(`#detail_harga${id}`))
              initAutoNumeric($(`#detail_persentasediscount${id}`))
              initAutoNumeric($(`#totalItem${id}`))
              setRowNumbers()
              $(`#detail_stok_${id}`).lookupV3({
                title: 'stok Lookup',
                fileName: 'stokV3',
                searching: ['namstok'],
                extendSize: md_extendSize_1,
                multiColumnSize:true,
                labelColumn: false,
                beforeProcess: function(test) {
                  // var levelcoa = $(`#levelcoa`).val();
                  var nobukti = $('#crudModal').find(`[name=nobukti]`).val();                  
                  cekKelompok(id);
                  this.postData = {
                    from: 'pengeluaranstok',
                    pengeluaranstok_id: $(pengeluaranstokId).val(),
                    Aktif: 'AKTIF',
                    nobukti : nobukti,                    
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
                  let service = stok.servicerutin_text;

                  let elStatusOli = element.parents('tr').find(`td [name="detail_statusoli[]"]`);
                  elStatusOli.find(`option:contains('TAMBAH')`).remove()
                  elStatusOli.find(`option:contains('GANTI')`).remove()

                  if (service == 'PERGANTIAN BATERE' || service == 'PERGANTIAN SARINGAN HAWA') {
                    dataStatusOli.forEach(statusOli => {
                      let option = new Option(statusOli.text, statusOli.id)

                      elStatusOli.append(option).trigger('change')
                    });

                    elStatusOli.find(`option:contains('TAMBAH')`).remove()
                    elStatusOli.trigger('change')
                  } else if (service == '') {
                    dataStatusOli.forEach(statusOli => {
                      let option = new Option(statusOli.text, statusOli.id)

                      elStatusOli.append(option).trigger('change')
                    });

                    elStatusOli.find(`option:contains('TAMBAH')`).remove()
                    elStatusOli.find(`option:contains('GANTI')`).remove()
                    elStatusOli.trigger('change')
                    $(`#detail_qty_oli${idDetail}`).hide()
                    $(`#qtytestlookup${idDetail}`).hide()
                    $(`#detail_qty${idDetail}`).show()
                  } else {
                    $(`#detail_qty_oli${idDetail}`).show()
                    $(`#qtytestlookup${idDetail}`).show()
                    $(`#detail_qty${idDetail}`).hide()
                    dataStatusOli.forEach(statusOli => {
                      let option = new Option(statusOli.text, statusOli.id)

                      elStatusOli.append(option).trigger('change')
                    });
                  }
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
                  element.data('currentValue', element.val())
                  dataStatusOli.forEach(statusOli => {
                    let option = new Option(statusOli.text, statusOli.id)

                    elStatusOli.append(option).trigger('change')
                  });
                }
              })
              $(`.qtytambahgantioli-lookup${id}`).lookup({
                title: 'qtytambahgantioli Lookup',
                fileName: 'qtytambahgantioli',
                beforeProcess: function(test) {
                  this.postData = {
                    // var levelcoa = $(`#levelcoa`).val();
                    Aktif: 'AKTIF',
                    stok_id: $(`#detailstokId_${idDetail}`).val(),
                    statusoli: $(`#statusoli${idDetail}`).val(),
                    isLookup: true

                  }
                },

                onSelectRow: (qtytambahgantioli, element) => {
                  element.val(qtytambahgantioli.qty)
                  elQty = AutoNumeric.getAutoNumericElement($(`#detail_qty${idDetail}`)[0]);
                  elQty.set(qtytambahgantioli.qty);
                  // $(`#${element[0]['name']}Id`).val(qtytambahgantioli.id)
                  element.data('currentValue', element.val())
                  lookupSelected(`qtytambahgantioli`);

                },
                onCancel: (element) => {
                  element.val(element.data('currentValue'))
                },
                onClear: (element) => {
                  element.val('')
                  element.data('currentValue', element.val())
                  elQty = AutoNumeric.getAutoNumericElement($(`#detail_qty${idDetail}`)[0]);
                  elQty.set(0);
                  enabledKorDisable()
                }
              })

              $(`#statusoli${id}`).change(function(event) {
                $(`#detail_qty_oli${idDetail}`).val('');
                elQty = AutoNumeric.getAutoNumericElement($(`#detail_qty${idDetail}`)[0]);
                elQty.set(0);
              })

              id++;
              index++;
              row = id;
              index = id;

            })
          }
          sumary()

          setKodePengeluaran(response.data.pengeluaranstok);
          enabledKorDisable()
          lookupSelected(persediaan)
          resolve(response.data)
        },
        error: error => {
          reject(error)
        }
      })
    })
  }


  function getSpb(detail_id, nobukti) {
    resetRow()
    $.ajax({
      url: `${apiUrl}penerimaanstokdetail`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        penerimaanstokheader_id: detail_id,
        penerimaanstokheader_nobukti: nobukti,
        pengeluaranstok_id: $('#pengeluaranstokId').val(),
      },
      success: response => {
        sum = 0;
        var statusformat;

        $.each(response.data, (id, detail) => {
          let detailRow = $(`
            <tr class="trow">
                  <td>
                    <div class="baris">1</div>
                  </td>
                  
                  <td>
                    <input name="id_detail[]" hidden value="${detail.id}">
                    <input type="text"  name="detail_stok[]" id="detail_stok_${id}" readonly class="form-control stok-lookup ">
                    <input type="text" id="detailstokId_${id}" readonly hidden class="detailstokId" name="detail_stok_id[]">
                    <input type="text" id="detailstokKelompok_${id}" value="${detail.kelompok_id}" readonly hidden class="detailstokKelompok" name="detail_stok_kelompok[]">
                  </td>
                  <td>
                    <input type="text" disabled name="detail_satuan[]" id="" value="${detail.satuan}" class="form-control detail_satuan_${index}">
                  </td>   
                  <td>
                    <textarea rows="1" placeholder="" name="detail_keterangan[]" class="form-control"></textarea>
                  </td>
                  <td class="data_tbl tbl_qty" >
                    <input type="text"  name="detail_qty[]" id="detail_qty${id}" onkeyup="cal(${id})" style="text-align:right" class="form-control autonumeric number${id}">                    
                  </td>
                  <td class="data_tbl tbl_vulkanisirke"  style="display: none;" >
                    <input type="text"  name="detail_vulkanisirke[]" style="" class="form-control">                    
                  </td> 
                  <td class="data_tbl tbl_vulkanisirtotal"  style="display: none;" >
                    <input type="text"  name="detail_vulkanisirtotal[]" readonly id="vulkanisirtotal${id}" style="" class="form-control">                    
                  </td> 
                  
                  <td class="data_tbl tbl_harga">
                    <input type="text"  name="detail_harga[]" id="detail_harga${id}" readonly style="text-align:right" class="autonumeric number${id} form-control">                    
                  </td>  
                  
                  <td class="data_tbl tbl_persentase" style="display: none;">
                    <input type="text"  name="detail_persentasediscount[]" id="detail_persentasediscount${id}" onkeyup="calculate(${id})" style="text-align:right" class="autonumeric number${id} form-control">                    
                  </td>  
                  <td class="data_tbl tbl_total">
                    <input type="text"  name="totalItem[]" id="totalItem${id}" readonly onkeyup="calculate(${id})" style="text-align:right" class="form-control totalItem autonumeric number${id}">                    
                  </td>  
                  <td>
                    <div class='btn btn-danger btn-sm rmv'>Delete</div>
                  </td>
              </tr>
          `)
          detailRow.find(`[name="detail_nobukti[]"]`).val(detail.nobukti)
          detailRow.find(`[name="detail_stok[]"]`).val(detail.stok)
          detailRow.find(`[name="detail_stok_id[]"]`).val(detail.stok_id)
          detailRow.find(`[name="detail_qty[]"]`).val(detail.qty)
          detailRow.find(`[name="detail_harga[]"]`).val(detail.harga)
          detailRow.find(`[name="detail_persentasediscount[]"]`).val(detail.persentasediscount)
          // detailRow.find(`[name="totalItem[]"]`).val(detail.total)
          detailRow.find(`[name="detail_keterangan[]"]`).val(detail.keterangan)
          $('table #table_body').append(detailRow)
          // initAutoNumeric($(`.number${id}`))
          // initAutoNumeric($(`#detail_qty${id}`), {
          //   'maximumValue': detail.qty
          // })
          initAutoNumeric($(`#detail_qty${id}`))
          initAutoNumeric($(`#detail_harga${id}`))
          initAutoNumeric($(`#detail_persentasediscount${id}`))
          initAutoNumeric($(`#totalItem${id}`))
          cal(id)
          setRowNumbers()
          // $(`#detail_stok_${id}`).lookup({
          //   title: 'stok Lookup',
          //   fileName: 'stok',
          //   onSelectRow: (stok, element) => {
          //     element.val(stok.namastok)
          //     parent = element.closest('td');
          //     parent.children('.detailstokId').val(stok.id)
          //     element.data('currentValue', element.val())
          //   },
          //   onCancel: (element) => {
          //     element.val(element.data('currentValue'))
          //   }
          // })
          id++;
          index = id;
        })
        sumary()

      }
    })
  }

  function processJlhHari(pengeluarantrucking) {
    let form = $('#crudForm')
    // console.log(pengeluarantrucking);
    // console.log(pengeluarantrucking.pengeluarantrucking_nobukti);
    form.find('[name=tglklaim]').val(pengeluarantrucking.tglbukti)
    form.find('[name=nobukti_pjt]').val(pengeluarantrucking.pengeluarantrucking_nobukti)
    $('#qty_afkir').val(pengeluarantrucking.qty)

  }

  function getJlhHari(stok_id) {

    $.ajax({
      url: `${apiUrl}saldoumuraki/getUmurAki`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        stok_id: stok_id,
      },
      success: response => {
        $('[name=jlhhari]').val(response.data);
      },
      error: error => {
        showDialog(error.statusText)
      }
    });
  }

  function cekKelompok(row) {
    //check jika lookup baris pertama
    // console.log(listKodePengeluaran[0] == kodePengeluaranStok);
    if ($(`#detailstokKelompok_${row}`)[0] == $('.detailstokKelompok')[0]) {
      if ((listKodePengeluaran[0] != kodePengeluaranStok)) {
        KelompokId = "";
        StokId = "";
      }
    } else {
      let detailstokKelompok = $('.detailstokKelompok')[0]
      let detailstokId = $('.detailstokId')

      KelompokId = $(detailstokKelompok).val();
      StokId = $(detailstokId[0]).val();
    }
  }

  function cekValidasi(Id, Aksi, nobukti) {
    $.ajax({
      url: `{{ config('app.api_url') }}pengeluaranstokheader/${Id}/cekvalidasi`,
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
            // showDialog(response.message['keterangan'])
            showDialog(response)
          } else {
            if (Aksi == 'PRINTER BESAR') {
              window.open(`{{ route('pengeluaranstokheader.report') }}?id=${Id}&printer=reportPrinterBesar`)
            } else if (Aksi == 'PRINTER KECIL') {
              window.open(`{{ route('pengeluaranstokheader.report') }}?id=${Id}&printer=reportPrinterKecil`)
            }
            if (Aksi == 'EDIT') {
              editPengeluaranstokHeader(Id)
            }
            if (Aksi == 'DELETE') {
              deletePengeluaranstokHeader(Id)
            }
          }
        } else {
          showDialog(response)
          // showDialog(response.message['keterangan'])
        }
      }
    })
  }

  function initLookup() {
    $('.akunpusat-lookup').lookup({
      title: 'akun pusat Lookup',
      fileName: 'akunpusat',
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
    $('.pengeluaranstok-lookup').lookupV3({
      title: 'pengeluaran stok Lookup',
      fileName: 'pengeluaranstokV3',
      labelColumn: true,
      extendSize: md_extendSize_1,
      multiColumnSize:true,
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {
          roleInput: 'role',
          Aktif: 'AKTIF',
          isLookup: true

        }
      },
      onSelectRow: (pengeluaranstok, element) => {
        // setKodePengeluaran(pengeluaranstok.statusformatid)        
        setIsDateAvailable(pengeluaranstok.id)
        setKodePengeluaran(pengeluaranstok.kodepengeluaran)
        element.val(pengeluaranstok.kodepengeluaran)
        $(`#${element[0]['name']}Id`).val(pengeluaranstok.id)
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
    // $('.pengeluaranstok-lookup').lookupMaster({
    //   title: 'pengeluaran stok Lookup',
    //   fileName: 'pengeluaranstokMaster',
    //   typeSearch: 'ALL',
    //   searching: 1,
    //   beforeProcess: function(test) {
    //     this.postData = {
    //       Aktif: 'AKTIF',
    //       searching: 1,
    //       valueName: 'pengeluaranstok_id',
    //       searchText: 'pengeluaranstok-lookup',
    //       title: 'Pengeluaran Stok',
    //       typeSearch: 'ALL',
    //       roleInput: 'role',
    //       isLookup: true
    //     }
    //   },
    //   onSelectRow: (pengeluaranstok, element) => {
    //     $('#crudForm [name=pengeluaranstok_id]').first().val(pengeluaranstok.id)
    //     element.val(pengeluaranstok.keterangan)
    //     element.data('currentValue', element.val())
    //   },
    //   onCancel: (element) => {
    //     element.val(element.data('currentValue'))
    //   },
    //   onClear: (element) => {
    //     $('#crudForm [name=pengeluaranstok_id]').first().val('')
    //     element.val('')
    //     element.data('currentValue', element.val())
    //   }
    // })


    $('.supir-lookup').lookupV3({
      title: 'supir Lookup',
      fileName:"supirV3",
      labelColumn: false,
      searching: ['namasupir','namaalias'],
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (supir, element) => {
        element.val(supir.namasupir)
        $(`#${element[0]['name']}Id`).val(supir.id)
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

    $('.kerusakan-lookup').lookupV3({
      title: 'kerusakan Lookup',
      fileName: 'kerusakanV3',
      labelColumn: false,
      searching: ['keterangan'],
      onSelectRow: (kerusakan, element) => {
        element.val(kerusakan.keterangan)
        $(`#${element[0]['name']}Id`).val(kerusakan.id)
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
    $('.supplier-lookup').lookupV3({
      title: 'supplier Lookup',
      fileName: 'supplierV3',
      labelColumn: false,
      searching: ['namasupplier'],
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
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
        $(`#${element[0]['name']}Id`).val('')
        element.data('currentValue', element.val())
      }
    })

    $('.bank-lookup').lookupV3({
      title: 'bank Lookup',
      fileName: 'bankV3',
      searching: ['namabank'],
      labelColumn: false,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          withPusat: 0

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
        element.val('')
        $(`#${element[0]['name']}Id`).val('')
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
        $(`#${element[0]['name']}Id`).val('')
        element.data('currentValue', element.val())
        enabledKorDisable()
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
          // var levelcoa = $(`#levelcoa`).val();

          Aktif: 'AKTIF',
        }
      },

      onSelectRow: (gandengan, element) => {
        element.val(gandengan.kodegandengan)
        $(`#${element[0]['name']}Id`).val(gandengan.id)
        element.data('currentValue', element.val())
        lookupSelected(`gandengan`);

      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        $(`#${element[0]['name']}Id`).val('')
        element.data('currentValue', element.val())
        enabledKorDisable()
      }
    })

    $('.qtytambahgantioli-lookup').lookup({
      title: 'qtytambahgantioli Lookup',
      fileName: 'qtytambahgantioli',
      beforeProcess: function(test) {
        this.postData = {
          // var levelcoa = $(`#levelcoa`).val();
          Aktif: 'AKTIF',
          stok_id: $(`#detail_stok_id`).val(),
          isLookup: true

        }
      },

      onSelectRow: (qtytambahgantioli, element) => {
        element.val(qtytambahgantioli.kodeqtytambahgantioli)
        $(`#${element[0]['name']}Id`).val(qtytambahgantioli.id)
        element.data('currentValue', element.val())
        lookupSelected(`qtytambahgantioli`);

      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        element.data('currentValue', element.val())
        enabledKorDisable()
      }
    })

    $(`.stok-lookup-afkir`).lookupV3({
      title: 'stok Lookup',
      fileName: 'stokV3',
      searching: ['namstok'],
      extendSize: md_extendSize_1,
      multiColumnSize:true,
      labelColumn: false,
      beforeProcess: function(test) {
        this.postData = {
          from: 'pengeluaranstok',
          Aktif: 'AKTIF',
          statusreuse: 'REUSE',
          isLookup: true
        }
      },
      onSelectRow: (stok, element) => {
        element.val(stok.namastok)
        let satuanEl = $(`#detail_satuan_id`);
        satuanEl.val(stok.satuan);
        
        $(`#detail_stok_id`).val(stok.id)
        $(`#status_stok`).val(stok.statusban)
        getVulkanAfkir(stok.id)


        getJlhHari(stok.id)

        element.data('currentValue', element.val())

      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        let satuanEl = $(`#detail_satuan_id`);
        satuanEl.val('');
        let iddetailEl = element.parents('tr').find(`td [name="id_detail[]"]`);
        iddetailEl.val(0);        
        element.val('')
        element.data('currentValue', element.val())
        $(`#detail_stok_id`).val('')

      }
    })

    $(`.pengeluarantrucking-lookup`).lookup({
      title: 'pengeluaran trucking Lookup',
      fileName: 'pengeluarantruckingheader',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {
          pengeluarantruckingheader_id: 7, //klaim
          stok_id: $(`#detail_stok_id`).val(),
          pengeluaranstok_id: $(`#pengeluaranstokId`).val(),
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (pengeluarantrucking, element) => {
        element.val(pengeluarantrucking.nobukti)
        element.data('currentValue', element.val())

        processJlhHari(pengeluarantrucking)

      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
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
          pengeluaranstok_id: $(`#pengeluaranstokId`).val()
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
        element.data('currentValue', element.val())
        enabledKorDisable()
      }
    })
    $('.pengeluaranstokheader-lookup').lookup({
      title: 'pengeluaran stok header Lookup',
      fileName: 'pengeluaranstokheader',
      onSelectRow: (pengeluaran, element) => {
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
    $('.penerimaanstokheader-lookup').lookup({
      title: 'penerimaan stok header Lookup',
      fileName: 'penerimaanstokheader',
      onSelectRow: (penerimaan, element) => {
        console.log(penerimaan.stok_id);
        setSuplier(penerimaan.id);
        element.val(penerimaan.nobukti)
        KelompokId = penerimaan.kelompok_id
        StokId = penerimaan.stok_id
        element.data('currentValue', element.val())
        penerimaanOrServicein('penerimaan')
        if (kodePengeluaranStok == listKodePengeluaran[1]) {
          getSpb(penerimaan.id, penerimaan.nobukti)
        }
      },
      beforeProcess: function(test) {
        var supplierId = $(`#supplierId`).val();
        var pengeluaranstokId = $(`#pengeluaranstokId`).val();
        var tradoId = $(`#tradoId`).val()
        var gandenganId = $(`#gandenganId`).val()
        this.postData = {
          trado_id: tradoId,
          gandengan_id: gandenganId,
          supplier_id: supplierId,
          pengeluaranstok_id: pengeluaranstokId
        }
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        element.data('currentValue', element.val())
        penerimaanOrServicein('penerimaan', false)
      }
    })
    $('.hutang-lookup').lookup({
      title: 'hutang header Lookup',
      fileName: 'hutangheader',
      onSelectRow: (hutang, element) => {
        element.val(hutang.nobukti)
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
    $('.servicein-lookup').lookup({
      title: 'service in Lookup',
      fileName: 'serviceinheader',
      beforeProcess: function(test) {
        this.postData = {
          from: 'pengeluaranstok',
          nobukti: $('#crudForm').find(`[name="nobukti"] `).val()
        }
      },
      onSelectRow: (servicein, element) => {
        penerimaanOrServicein('servicein')
        element.val(servicein.nobukti)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        penerimaanOrServicein('servicein', false)
        element.data('currentValue', element.val())
      }
    })

  }
</script>
@endpush()