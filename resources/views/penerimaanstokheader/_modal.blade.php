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
                    <input type="text" name="penerimaanstok" class="form-control penerimaanstok-lookup">
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
                    <input type="text" name="trado" class="form-control trado-lookup">
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
                    <input type="text" name="supplier" class="form-control supplier-lookup">
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
                    <input type="text" name="gudang" class="form-control gudang-lookup">
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
                    <input type="text" name="gandengan" class="form-control gandengan-lookup">
                    <input type="text" id="gandenganId" name="gandengan_id" hidden readonly>
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
                      <input type="text" name="gudangdari" class="form-control gudangdari-lookup">
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
                      <input type="text" name="gudangke" class="form-control gudangke-lookup">
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
                      <input type="text" name="tradodari" class="form-control tradodari-lookup">
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
                      <input type="text" name="tradoke" class="form-control tradoke-lookup">
                      <input type="text" id="tradokeId" name="tradoke_id" hidden readonly>
                    </div>
                  </div>
                </div>
              </div>
  
                <div class="form-group col-md-6">
                  <div class="row">
                    <div class="col-12 col-sm-3 col-md-4">
                      <label class="col-form-label">gandengan dari</label>
                    </div>
                    <div class="col-12 col-sm-9 col-md-8">
                      <input type="text" name="gandengandari" class="form-control gandengandari-lookup">
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
                      <input type="text" name="gandenganke" class="form-control gandenganke-lookup">
                      <input type="text" id="gandengankeId" name="gandenganke_id" hidden readonly>
                    </div>
                  </div>
                </div>
           


            </div>

            <div class="row form-group" style="display:none">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">keterangan </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="keterangan" class="form-control">
              </div>
            </div>


            <div class="table-scroll table-responsive">
              <table class="table table-bordered table-bindkeys" style="width: 100%; min-width: 500px;">
                <thead>
                  <tr>
                    <th style="width:10%; max-width: 25px;max-width: 15px">No</th>
                    <th style="width: 20%; min-width: 200px;">stok <span class="text-danger">*</span> </th>
                    <th class="data_tbl tbl_vulkanisirke" style="width: 10px">vulkanisir ke</th>
                    <th style="width: 20%; min-width: 200px;">keterangan <span class="text-danger">*</span> </th>
                    <th class="data_tbl tbl_qty" style="width:10%; min-width: 100px">qty <span class="text-danger">*</span></th>
                    <th class="data_tbl tbl_harga" style="width: 20%; min-width: 200px;">harga</th>
                    <th class="data_tbl tbl_penerimaanstok_nobukti"  style="width: 20%; min-width: 200px;">Penerimaan stok no bukti</th>
                    <th class="data_tbl tbl_persentase" style="width:10%; min-width: 100px">persentase discount</th>
                    <th class="data_tbl tbl_total"  style="width: 20%; min-width: 200px;">Total</th>
                    <th style="width:10%; max-width: 25px;max-width: 15px">Aksi</th>
                  </tr>
                </thead>
                <tbody id="table_body" class="form-group">

                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="6" class="colspan"></td>

                    <td class="font-weight-bold data_tbl sumrow"> Total : </td>
                    <td id="sumary" class="text-right font-weight-bold data_tbl sumrow"> </td>
                    <td>
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
  var KodePenerimaanId
  var listKodePenerimaan =[];
  $(document).ready(function() {
    addRow()
    $(document).on('click', '#addRow', function(event) {
      addRow()
    });

    $(document).on('click', '.rmv', function(event) {
      deleteRow($(this).parents('tr'))
    })

    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let penerimaanStokHeaderId = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()

      if (action !== 'delete') {
        $('#crudForm').find(`[name="detail_qty[]"]`).each((index, element) => {
          if (element.value !="" &&  AutoNumeric.getAutoNumericElement(element) !== null) {
            data.filter((row) => row.name === 'detail_qty[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="detail_qty[]"]`)[index])
          }else{
            data.filter((row) => row.name === 'detail_qty[]')[index].value = 0;
          }
        })
        $('#crudForm').find(`[name="detail_harga[]"]`).each((index, element) => {
          if (element.value !="" &&  AutoNumeric.getAutoNumericElement(element) !== null) {
            data.filter((row) => row.name === 'detail_harga[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="detail_harga[]"]`)[index])
          }else{
            data.filter((row) => row.name === 'detail_harga[]')[index].value = 0;
          }
        })
  
        $('#crudForm').find(`[name="detail_persentasediscount[]"]`).each((index, element) => {
          if (element.value !="" &&  AutoNumeric.getAutoNumericElement(element) !== null) {
            data.filter((row) => row.name === 'detail_persentasediscount[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="detail_persentasediscount[]"]`)[index])
          }else{
            data.filter((row) => row.name === 'detail_persentasediscount[]')[index].value = 0;
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
        name: 'penerimaanheader_id',
        value:  $('#penerimaanstokId').val()
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
          $('#crudModal').modal('hide')

          id = response.data.id
          $('#kodepenerimaanheader').val(response.data.penerimaanstok_id).trigger('change')

          $('#jqGrid').jqGrid('setGridParam', {
            postData: {penerimaanheader_id: response.data.penerimaanstok_id},
            page: response.data.page
          }).trigger('reloadGrid')

          if (response.data.grp == 'FORMAT') {
            updateFormat(response.data)
          }
        },
        error: error => {
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            setErrorMessages(form, error.responseJSON.errors);
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

  function setKodePenerimaan(kode) {
    KodePenerimaanId = kode;
    setTampilanForm();
  }

  function setTampilanForm() {
    tampilanall()
    switch (KodePenerimaanId) {
      case listKodePenerimaan[0] : // 'DOT':
        tampilandot()
        break;
      case listKodePenerimaan[1] : // 'PO':
        tampilanpo()
        break;
      case listKodePenerimaan[2] : // 'SPB':
        tampilanpbt()
        break;
      case listKodePenerimaan[4] : // 'PG':
        tampilanpgt()
        break;
      case listKodePenerimaan[3] : // 'KOR':
        tampilankst()
        break;
      case listKodePenerimaan[5] : // 'SPBS':
        tampilanpst()
        break;

      default:
        tampilanall()
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
    $('.tbl_vulkanisirke').hide();
    $('.tbl_persentase').hide();
    $('.tbl_total').hide();
    $('.tbl_harga').hide();
    $('.tbl_penerimaanstok_nobukti').hide();
    $('.colspan').attr('colspan', 4);
    $('.sumrow').hide();
    $('[name=gudang]').val('').attr('readonly', false);
    $('[name=gudang_id]').val('')
    // $('[name=supplier]').val('').attr('readonly', false);
    // $('[name=supplier]').data('currentValue', '')
    // $('[name=supplier_id]').val('')
    $('#addRow').show()
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
    $('.tbl_vulkanisirke').hide();
    $('.tbl_harga').hide();
    $('.tbl_persentase').hide();
    $('.tbl_total').hide();
    $('.tbl_penerimaanstok_nobukti').hide();

    $('.colspan').attr('colspan', 4);
    $('.sumrow').hide();
    $('[name=gudang]').val('').attr('readonly', false);
    $('[name=gudang_id]').val('')
    // $('[name=supplier]').val('').attr('readonly', false);
    // $('[name=supplier]').data('currentValue', '')
    // $('[name=supplier_id]').val('')
    $('#addRow').show()
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
    $('.tbl_vulkanisirke').hide();
    $('.colspan').attr('colspan', 5);
    $('.tbl_penerimaanstok_nobukti').hide();

    $('.sumrow').show();
    $.ajax({
      url: `${apiUrl}gudang/1`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        'Authorization': `Bearer ${accessToken}`
      },
      success: response => {
        var data = response.data;
        $('[name=gudang]').val(data.gudang).attr('readonly', true);
        $('[name=gudang_id]').val(data.id)
      },
      error: error => {
        showDialog(error.statusText)
      }
    })
    // $('#addRow').hide()
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

    $('[name=gudangdari]').parents('.form-group').show()
    $('[name=gudangke]').parents('.form-group').show()
    $('[name=tradodari]').parents('.form-group').show()
    $('[name=tradoke]').parents('.form-group').show()
    $('[name=gandengandari]').parents('.form-group').show()
    $('[name=gandenganke]').parents('.form-group').show()
    $('.tbl_penerimaanstok_nobukti').hide();

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
    // $('[name=gudang]').val('').attr('readonly', false);
    // $('[name=gudang_id]').val('')
    
    $('[name=gudangdari]').parents('.form-group').hide()
    $('[name=gudangke]').parents('.form-group').hide()
    $('[name=tradodari]').parents('.form-group').hide()
    $('[name=tradoke]').parents('.form-group').hide()
    $('[name=gandengandari]').parents('.form-group').hide()
    $('[name=gandenganke]').parents('.form-group').hide()
    $('.tbl_penerimaanstok_nobukti').hide();
    $('.tbl_qty').show()
    $('.tbl_vulkanisirke').hide();
    $('.tbl_harga').hide();
    $('.tbl_persentase').hide();
    $('.tbl_total').hide();
    $('.colspan').attr('colspan', 4);
    $('.sumrow').hide();
    
    $('#addRow').show()
  }

  function tampilanpst() {
    $('[name=gudang]').parents('.form-group').show()
    $('[name=trado]').parents('.form-group').hide()
    $('[name=gandengan]').parents('.form-group').hide()
    $('[name=penerimaanstok_nobukti]').parents('.form-group').hide()
    $('[name=pengeluaranstok_nobukti]').parents('.form-group').hide()
    $('[name=coa]').parents('.form-group').hide()
    $('[name=gudang]').parents('.form-group').hide()

    $('[name=gudangdari]').parents('.form-group').hide()
    $('[name=gudangke]').parents('.form-group').hide()
    $('[name=gandengan]').parents('.form-group').hide()
    $('[name=tradodari]').parents('.form-group').hide()
    $('[name=tradoke]').parents('.form-group').hide()
    $('[name=gandengandari]').parents('.form-group').hide()
    $('[name=gandenganke]').parents('.form-group').hide()

    $('.tbl_penerimaanstok_nobukti').show();
    $('.colspan').attr('colspan', 7);
    
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
    $('.colspan').attr('colspan', 6);
    // $('[name=nobon]').val('')
    // $('[name=supplier]').attr('readonly', false);
    // $('[name=supplier]').data('currentValue', '')
    // $('[name=supplier_id]').val('')
    $('#addRow').show()
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

  function setDetail(penerimaan_id) {
    $.ajax({
      url: `${apiUrl}penerimaanstokheader/${penerimaan_id}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        'Authorization': `Bearer ${accessToken}`
      },
      success: response => {
        resetRow()
        $.each(response.detail, (id, detail) => {
          let detailRow = $(`
            <tr class="trow">
                  <td>
                    <div class="baris">1</div>
                  </td>
                  
                  <td>
                    <input type="text"  name="detail_stok[]" id="detail_stok_${id}" class="form-control stok-lookup ">
                    <input type="text" id="detailstokId_${id}" readonly hidden class="detailstokId" name="detail_stok_id[]">
                  </td>
                  <td class="data_tbl tbl_vulkanisirke">
                    <input type="number"  name="detail_vulkanisirke[]" style="" class="form-control">                    
                  </td>  
                  <td>
                    <input type="text"  name="detail_keterangan[]" style="" class="form-control">                    
                  </td>
                  <td class="data_tbl tbl_qty">
                    <input type="text"  name="detail_qty[]" id="detail_qty${id}" onkeyup="cal(${id})" style="text-align:right" class="form-control autonumeric number${id}">                    
                  </td>  
                  
                  <td class="data_tbl tbl_harga">
                    <input type="text"  name="detail_harga[]" id="detail_harga${id}" onkeyup="cal(${id})" style="text-align:right" class="autonumeric number${id} form-control">                    
                  </td>  
                  
                  <td class="data_tbl tbl_penerimaanstok_nobukti">
                    <input type="text"  name="detail_penerimaanstoknobukti[]" id="detail_penerimaanstoknobukti_${id}" class="form-control ">
                    <input type="text" id="detailpenerimaanstoknobuktiId_${id}" readonly hidden class="detailpenerimaanstoknobuktiId" name="detail_penerimaanstoknobukti_id[]">
                  </td>  
                  
                  <td class="data_tbl tbl_persentase">
                    <input type="text"  name="detail_persentasediscount[]" id="detail_persentasediscount${id}" onkeyup="cal(${id})" style="text-align:right" class="autonumeric number${id} form-control">                    
                  </td>  
                  <td class="data_tbl tbl_total">
                    <input type="text"  name="totalItem[]" readonly id="totalItem${id}" style="text-align:right" class="form-control totalItem autonumeric number${id}">                    
                  </td>  
                  <td>
                    <div class='btn btn-danger btn-sm rmv'>Hapus</div>
                  </td>
              </tr>
          `)
          detailRow.find(`[name="detail_nobukti[]"]`).val(detail.nobukti)
          detailRow.find(`[name="detail_stok[]"]`).val(detail.stok)
          detailRow.find(`[name="detail_stok[]"]`).data('currentValue',detail.stok)
          detailRow.find(`[name="detail_stok_id[]"]`).val(detail.stok_id)
          detailRow.find(`[name="detail_qty[]"]`).val(detail.qty)
          detailRow.find(`[name="detail_harga[]"]`).val(detail.harga)
          detailRow.find(`[name="detail_persentasediscount[]"]`).val(detail.persentasediscount)
          detailRow.find(`[name="detail_vulkanisirke[]"]`).val(detail.vulkanisirke)
          detailRow.find(`[name="totalItem[]"]`).val(detail.total)
          detailRow.find(`[name="detail_keterangan[]"]`).val(detail.keterangan)
          $('table #table_body').append(detailRow)
          initAutoNumeric($(`.number${id}`))
          setRowNumbers()
          $(`#detail_stok_${id}`).lookup({
            title: 'stok Lookup',
            fileName: 'stok',
            beforeProcess: function(test) {
              var penerimaanstokId = $(`#penerimaanstokId`).val();
              var penerimaanstok_nobukti = $('#crudModal').find(`[name=penerimaanstok_nobukti]`).val();
              console.log(penerimaanstok_nobukti);
              this.postData = {
                penerimaanstok_id: penerimaanstokId,
                penerimaanstokheader_nobukti: penerimaanstok_nobukti,
                Aktif: 'AKTIF',
              }
            },
            onSelectRow: (stok, element) => {
              element.val(stok.namastok)
              parent = element.closest('td');
              parent.children('.detailstokId').val(stok.id)
              element.data('currentValue', element.val())
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
        if (KodePenerimaanId === listKodePenerimaan[2]) {
          $('#addRow').hide()
        }else{
          $('#addRow').show()
        }
      },
      error: error => {
        showDialog(error.statusText)
      }
    })
  }

  function lookupSelectedDari(el) {
    let trado = $('#crudForm').find(`[name="trado"]`).parents('.input-group').children()
    let tradodari = $('#crudForm').find(`[name="tradodari"]`).parents('.input-group').children()
    let gandengan = $('#crudForm').find(`[name="gandengan"]`).parents('.input-group').children()
    let gandengandari = $('#crudForm').find(`[name="gandengandari"]`).parents('.input-group').children()
    let gudang = $('#crudForm').find(`[name="gudang"]`).parents('.input-group').children()
    let gudangdari = $('#crudForm').find(`[name="gudangdari"]`).parents('.input-group').children()


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

  function enabledLookupSelectedDari() {

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



  $('#crudModal').on('shown.bs.modal', () => {
    let form = $('#crudForm')

    setFormBindKeys(form)
    
    activeGrid = null
    initDatepicker()
    initLookup()
    if( form.data('action') !== 'add'){
      let penerimaanstok = $('#crudForm').find(`[name="penerimaanstok"]`).parents('.input-group').children()
      penerimaanstok.attr('disabled', true)
      penerimaanstok.find('.lookup-toggler').attr('disabled', true)
      $('#penerimaanstokId').attr('readonly', true);
    }
      
      
    getMaxLength(form)
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    $('#crudModal').find('.modal-body').html(modalBody)
  })


  function createPenerimaanstokHeader() {
    resetRow()
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create Penerimaan Stok')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    tampilanall()
    addRow()
    sumary()
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    $('#crudForm').find('[name=tglbukti]').attr('readonly', 'readonly').css({
      background: '#fff'
    })
    let tglbukti = $('#crudForm').find(`[name="tglbukti"]`).parents('.input-group').children()
    tglbukti.find('button').attr('disabled', true)
    

  }

  function editPenerimaanstokHeader(penerimaanStokHeaderId) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Penerimaan Stok')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        showPenerimaanstokHeader(form, penerimaanStokHeaderId)
      ])
      .then(penerimaanStokHeaderId => {
            setFormBindKeys(form)
            initDatepicker()
            initSelect2(form.find('.select2bs4'), true)
            form.find('[name=tglbukti]').removeAttr('disabled')
    
            form.find('[name=tglbukti]').attr('readonly', 'readonly').css({
              background: '#fff'
            })

          })
      .then(() => {
        $('#crudModal').modal('show')
        $('#crudForm').find(`.ui-datepicker-trigger`).attr('disabled', true)
        if ( $('#crudForm').find("[name=gudang]")) {
            lookupSelected(`gudang`);
        }else if ( $('#crudForm').find("[name=gandengan]")) {
            lookupSelected('gandengan')
        }else if ( $('#crudForm').find("[name=trado]")) {
            lookupSelected('trado')
        }
        if ( $('#crudForm').find("[name=gudangke]")) {
            lookupSelectedKe(`gudangke`);
        }else if ( $('#crudForm').find("[name=gandenganke]")) {
          lookupSelectedKe('gandenganke')
        }else if ( $('#crudForm').find("[name=tradoke]")) {
          lookupSelectedKe('tradoke')
        }
        if ( $('#crudForm').find("[name=gudangdari]")) {
            lookupSelectedDari(`gudangdari`);
        }else if ( $('#crudForm').find("[name=gandengandari]")) {
          lookupSelectedDari('gandengandari')
        }else if ( $('#crudForm').find("[name=tradodari]")) {
          lookupSelectedDari('tradodari')
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
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Penerimaan Stok')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
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

          })
          .then(() => {
            $('#crudModal').modal('show')
            $('#crudForm').find(`.ui-datepicker-trigger`).attr('disabled', true)

            let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
            name.attr('disabled', true)
            name.find('.lookup-toggler').attr('disabled', true)

          })
      .catch((error) => {
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
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


  index = 0;

  function addRow() {
    let detailRow = $(`
    <tr class="trow">
                  <td>
                    <div class="baris">1</div>
                  </td>
                  
                  <td>
                    <input type="text"  name="detail_stok[]" id="" class="form-control detail_stok_${index}">
                    <input type="text" id="detailstokId_${index}" readonly hidden class="detailstokId" name="detail_stok_id[]">
                  </td>                 
                  <td class="data_tbl tbl_vulkanisirke">
                    <input type="number"  name="detail_vulkanisirke[]" style="" class="form-control" >                    
                  </td>  
                  <td>
                    <input type="text"  name="detail_keterangan[]" style="" class="form-control">                    
                  </td>
                  <td class="data_tbl tbl_qty">
                    <input type="text"  name="detail_qty[]" id="detail_qty${index}" onkeyup="cal(${index})" style="text-align:right" class="form-control autonumeric number${index}" >
                  </td>  
                  
                  <td class="data_tbl tbl_harga">
                    <input type="text"  name="detail_harga[]" id="detail_harga${index}" onkeyup="cal(${index})" style="text-align:right" class="form-control autonumeric number${index}" >
                  </td>  
                  
                  <td class="data_tbl tbl_penerimaanstok_nobukti">
                    <input type="text"  name="detail_penerimaanstoknobukti[]" id="detail_penerimaanstoknobukti_${index}" class="form-control ">
                    <input type="text" id="detailpenerimaanstoknobuktiId_${index}" readonly hidden class="detailpenerimaanstoknobuktiId" name="detail_penerimaanstoknobukti_id[]">
                  </td>  
                  
                  <td class="data_tbl tbl_persentase">
                    <input type="text"  name="detail_persentasediscount[]" id="detail_persentasediscount${index}" onkeyup="cal(${index})" style="text-align:right" class="form-control autonumeric number${index}" >
                  </td>  
                  <td class="data_tbl tbl_total">
                    <input type="text"  name="totalItem[]" readonly id="totalItem${index}" style="text-align:right" class="form-control totalItem autonumeric number${index}" >                    
                  </td>  
                  
                  <td>
                    <div class='btn btn-danger btn-sm rmv'>Hapus</div>
                  </td>
              </tr>
    `)

    $('table #table_body').append(detailRow)
    var row = index;
    $(`.detail_stok_${row}`).lookup({
      title: 'stok Lookup',
      fileName: 'stok',
      beforeProcess: function(test) {
        var penerimaanstokId = $(`#penerimaanstokId`).val();
        var penerimaanstok_nobukti = $('#crudModal').find(`[name=penerimaanstok_nobukti]`).val();
        this.postData = {
          penerimaanstok_id: penerimaanstokId,
          penerimaanstokheader_nobukti: penerimaanstok_nobukti,
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (stok, element) => {
        element.val(stok.namastok)
        parent = element.closest('td');
        parent.children('.detailstokId').val(stok.id)
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
    $(`#detail_penerimaanstoknobukti_${index}`).lookup({
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
      
    initAutoNumeric($(`.number${index}`))
    setTampilanForm()
    setRowNumbers()
    index++;
  }

  function deleteRow(row) {
    row.remove()
    sumary()
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

  function sumary() {
    let sumary = 0;
    $('.totalItem').each(function() {
      var totalItem = AutoNumeric.getNumber($(this)[0]);
      sumary += totalItem;
    })
    new AutoNumeric($('#sumary')[0]).set(sumary);
  }

  function cekValidasi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}penerimaanstokheader/${Id}/cekvalidasi`,
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
              editPenerimaanstokHeader(Id)
            }
            if (Aksi == 'DELETE') {
              deletePenerimaanstokHeader(Id)
            }
          }
        } else {
          showDialog(response.message['keterangan'])
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
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          // console.log(response.data);
          $.each(response.data, (index,data) => {
            // console.log();

            listKodePenerimaan[index] = data.kodepenerimaan;
          })

        }
      })
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

          $.each(response.detail, (id, detail) => {
            let detailRow = $(`
              <tr class="trow">
                    <td>
                      <div class="baris">1</div>
                    </td>
                    
                    <td>
                      <input type="text"  name="detail_stok[]" id="detail_stok_${id}" class="form-control stok-lookup ">
                      <input type="text" id="detailstokId_${id}" readonly hidden class="detailstokId" name="detail_stok_id[]">
                    </td>
                    <td class="data_tbl tbl_vulkanisirke">
                      <input type="number"  name="detail_vulkanisirke[]" style="" class="form-control">                    
                    </td>  
                    <td>
                      <input type="text"  name="detail_keterangan[]" style="" class="form-control">                    
                    </td>
                    <td class="data_tbl tbl_qty">
                      <input type="text"  name="detail_qty[]" id="detail_qty${id}" onkeyup="cal(${id})" style="text-align:right" class="form-control autonumeric number${id}">                    
                    </td>  
                    
                    <td class="data_tbl tbl_harga">
                      <input type="text"  name="detail_harga[]" id="detail_harga${id}" onkeyup="cal(${id})" style="text-align:right" class="autonumeric number${id} form-control">                    
                    </td>  
                    
                    <td class="data_tbl tbl_penerimaanstok_nobukti">
                      <input type="text"  name="detail_penerimaanstoknobukti[]" id="detail_penerimaanstoknobukti_${id}" class="form-control ">
                      <input type="text" id="detailpenerimaanstoknobuktiId_${id}" readonly hidden class="detailpenerimaanstoknobuktiId" name="detail_penerimaanstoknobukti_id[]">
                    </td>
                    
                    <td class="data_tbl tbl_persentase">
                      <input type="text"  name="detail_persentasediscount[]" id="detail_persentasediscount${id}" onkeyup="cal(${id})" style="text-align:right" class="autonumeric number${id} form-control">                    
                    </td>  
                    <td class="data_tbl tbl_total">
                      <input type="text"  name="totalItem[]" readonly id="totalItem${id}" style="text-align:right" class="form-control totalItem autonumeric number${id}">                    
                    </td>  
                    <td>
                      <div class='btn btn-danger btn-sm rmv'>Hapus</div>
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
            initAutoNumeric($(`.number${id}`))
            setRowNumbers()
            $(`#detail_stok_${id}`).lookup({
              title: 'stok Lookup',
              fileName: 'stok',
              beforeProcess: function(test) {
                var penerimaanstokId = $("#crudForm").find(`[name="penerimaanstok_id"]`).val();
                var penerimaanstok_nobukti = $('#crudModal').find(`[name=penerimaanstok_nobukti]`).val();
                console.log(penerimaanstok_nobukti);
                this.postData = {
                  penerimaanstok_id: penerimaanstokId,
                  penerimaanstokheader_nobukti: penerimaanstok_nobukti,
                  Aktif: 'AKTIF',
                }
              },
              onSelectRow: (stok, element) => {
                element.val(stok.namastok)
                parent = element.closest('td');
                parent.children('.detailstokId').val(stok.id)
                element.data('currentValue', element.val())
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
            id++;
          })
          sumary()
          setKodePenerimaan(response.data.penerimaanstok);
          
          if (KodePenerimaanId === listKodePenerimaan[2]) {
            $('#addRow').hide()
          }else{
            $('#addRow').hide()
          }
          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function initLookup(params) {
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

    $('.penerimaanstok-lookup').lookup({
      title: 'penerimaan stok Lookup',
      fileName: 'penerimaanstok',
      onSelectRow: (penerimaanstok, element) => {
        setKodePenerimaan(penerimaanstok.kodepenerimaan)
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

    $('.supplier-lookup').lookup({
      title: 'supplier Lookup',
      fileName: 'supplier',
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

    $('.trado-lookup').lookup({
      title: 'Trado Lookup',
      fileName: 'trado',
      onSelectRow: (trado, element) => {
        element.val(trado.keterangan)
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

    $('.gandengan-lookup').lookup({
      title: 'gandengan Lookup',
      fileName: 'gandengan',
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

    $('.gudang-lookup').lookup({
      title: 'Gudang Lookup',
      fileName: 'gudang',
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
        // console.log('asdasdsa');
        var penerimaanstokId = $(`#penerimaanstokId`).val();
        if (penerimaanstokId == (3||6)) {//spb beli /reuse
          setSuplier(penerimaan.id);
          $('[name=nobon]').val(penerimaan.nobon)
          setDetail(penerimaan.id);
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


    $('.tradoke-lookup').lookup({
      title: 'Trado Lookup',
      fileName: 'trado',
      onSelectRow: (trado, element) => {
        element.val(trado.keterangan)
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

    $('.gandenganke-lookup').lookup({
      title: 'gandengan Lookup',
      fileName: 'gandengan',
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

    $('.gudangke-lookup').lookup({
      title: 'Gudang Lookup',
      fileName: 'gudang',
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
    $('.tradodari-lookup').lookup({
      title: 'Trado Lookup',
      fileName: 'trado',
      onSelectRow: (trado, element) => {
        element.val(trado.keterangan)
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

    $('.gandengandari-lookup').lookup({
      title: 'gandengan Lookup',
      fileName: 'gandengan',
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

    $('.gudangdari-lookup').lookup({
      title: 'Gudang Lookup',
      fileName: 'gudang',
      beforeProcess: function(test) {
        var penerimaanstokId = $(`#penerimaanstokId`).val();
        this.postData = {
          penerimaanstok_id: penerimaanstokId,
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
        enabledLookupSelectedDari()
        element.val('')
        $(`#${element[0]['name']}Id`).val('')
        element.data('currentValue', element.val())
      }
    })
  }
</script>
@endpush()