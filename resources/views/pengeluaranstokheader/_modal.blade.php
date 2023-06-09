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
                    <input type="text" name="pengeluaranstok" class="form-control pengeluaranstok-lookup">
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
                    <label class="col-form-label">SERVICE IN NO bukti </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <input type="text" name="servicein_nobukti" class="form-control servicein-lookup">
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
                    <label class="col-form-label">supplier </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <input type="text" name="supplier" class="form-control supplier-lookup">
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
                    <input type="text" name="kerusakan" class="form-control kerusakan-lookup">
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
                    <input type="text" name="supir" class="form-control supir-lookup">
                    <input type="text" id="supirId" name="supir_id" readonly hidden>
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
                    <input type="text" name="gudang" class="form-control gudang-lookup">
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
                    <input type="text" name="gandengan" class="form-control gandengan-lookup">
                    <input type="text" id="gandenganId" name="gandengan_id" readonly hidden>
                  </div>
                </div>
              </div>

              <div class="form-group col-md-6">
                <div class="row" >
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

            <div class="border p-3 potongkas" >
              <h6 id="titlePotongkas">Posting Penerimaan</h6>
              <div class="row">
                <div class="form-group col-md-6">
                  <div class="row">
                    <div class="col-12 col-sm-3 col-md-4">
                      <label class="col-form-label">bank </label>
                    </div>
                    <div class="col-12 col-sm-9 col-md-8">
                      <input type="text" name="bank" class="form-control bank-lookup">
                      <input type="text" id="bankId" name="bank_id" readonly hidden>
                    </div>
                  </div>
                </div>
                <div class="form-group col-md-6">
                  <div class="row">
                    <div class="col-12 col-sm-3 col-md-4">
                      <label class="col-form-label">TANGGAL POST  </label>
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
                      <label class="col-form-label">penerimaan no bukti  </label>
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
                  <div class="card" style="max-height:500px; overflow-y: scroll;">
                      <div class="card-body">
            <table class="table table-bordered table-bindkeys">
              <thead>
                <tr>
                  <th style="width : 5%">No</th>
                    <th style="width : 20%">stok</th>
                    <th class="data_tbl tbl_vulkanisirke" style="width : 20px">vulkanisir ke</th>
                    <th style="width : 20%">keterangan</th>
                    <th class="tbl_qty" style="width : 5%">qty</th>
                    <th class="data_tbl tbl_harga" style="width : 10%">harga</th>
                    <th class="data_tbl tbl_persentase" style="width : 5%">persentase discount</th>
                    <th class="data_tbl tbl_total" style="width : 10%">Total</th>
                    <th style="width : 5%">Aksi</th>
                </tr>
              </thead>
              <tbody id="table_body" class="form-group">
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="6" class="colspan"></td>

                  <td class="font-weight-bold  data_tbl tbl_total"> Total : </td>
                  <td id="sumary" class="text-right font-weight-bold data_tbl tbl_total"> </td>
                  <td>
                    <button type="button" class="btn btn-primary btn-sm my-2" id="addRow">Tambah</button>
                  </td>
                </tr>
              </tfoot>
            </table>
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
  let kodePengeluaranStok
  let modalBody = $('#crudModal').find('.modal-body').html()

  $(document).ready(function() {
    $(document).on('click', '#addRow', function(event) {
      addRow()
    });

    $(document).on('click', '.rmv', function(event) {
      deleteRow($(this).parents('tr'))
    })
    $(document).on('change', '#statuspotongretur', function(event) {
      // deleteRow($(this).parents('tr'))
      console.log($(this).val());
      if ($(this).val() == 219) {
        $('.potongkas').show()//potong kas
        $('#titlePotongkas').html('POSTING Penerimaan')
        $('[name=tglkasmasuk]').parents('.form-group').show()
        // $('[name=bank]').parents('.form-group').show()
        // $('[name=tglkasmasuk]').parents('.form-group').show()
      }else if($(this).val() == 220){
        $('.potongkas').show()//potong hutang
        $('#titlePotongkas').html('POSTING Pengeluaran')
        $('[name=tglkasmasuk]').parents('.form-group').hide()
        $('[name=penerimaan_nobukti]').parents('.form-group').hide()
      }else{
        $('.potongkas').hide()
      }
    })

    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let pengeluaranStokHeaderId = form.find('[name=id]').val()
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
      if (action == 'add') {
        data.push({
          name: 'pengeluaranheader_id',
          value: data.find(item => item.name === "pengeluaranstok_id").value
        })
        let pengeluaranheader_id = data.find(item => item.name === "pengeluaranstok_id").value
      }
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
          $('#crudModal').modal('hide')

          id = response.data.id
          $('#kodepengeluaranheader').val(response.data.pengeluaranstok_id).trigger('change')

          $('#jqGrid').jqGrid('setGridParam', {
            postData: {pengeluaranheader_id: response.data.pengeluaranstok_id},
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
            showDialog(error.statusText)
          }
        },
      }).always(() => {
        $('#processingLoader').addClass('d-none')
        $(this).removeAttr('disabled')
      })
    })
  })

  function setKodePengeluaran(kode) {
    kodePengeluaranStok = kode;
    setTampilanForm();
  }

  function setTampilanForm(){
    tampilanall()
    switch (kodePengeluaranStok) {
      case 'SPK':
        tampilanspk()
        break;
      case 'RTR':
        tampilanrbt()
        break;
      case 'KOR':
        tampilankor()
        break;
    
      default:
        tampilanall()
        break;
    }
  }

  // function cekKodePengeluaran(kode) {
  //   $.ajax({
  //     url: `${apiUrl}parameter`,
  //     method: 'GET',
  //     dataType: 'JSON',
  //     headers: {
  //       Authorization: `Bearer ${accessToken}`
  //     },
  //     data: {
  //       filters: JSON.stringify({
  //         "groupOp": "AND",
  //         "rules": [{
  //             "field": "grp",
  //             "op": "cn",
  //             "data": "PENGELUARAN STOK"
  //           },
  //           {
  //             "field": "id",
  //             "op": "cn",
  //             "data": kode
  //           }
  //         ]
  //       })
  //     },
  //     success: response => {
  //       if (kode) {
  //         if (response.data[0].subgrp == "SPK STOK BUKTI") {
  //           tampilanspk();
  //           enabledKorDisable()
  //           kodepengeluaranstok = "SPK";
  //         } else if(response.data[0].subgrp == "RETUR BELI BUKTI") {
  //           tampilanrbt();
  //           enabledKorDisable()
  //           kodepengeluaranstok = "RBT";
  //         } else if(response.data[0].subgrp == "KOREKSI STOK MINUS BUKTI") {
  //           tampilankor();
  //           kodepengeluaranstok = "KOR";
  //         }
  //       } else{
  //         console.log(kodepengeluaranstok);
  //         tampilanall();
  //       }
  //     }
  //   })
    
  // }

  function tampilanspk() {
    // $('[name=nobukti]').parents('.form-group').show()
    // $('[name=tglbukti]').parents('.form-group').show()
    // $('[name=pengeluaranstok]').parents('.form-group').show()
    // $('[name=kerusakan]').parents('.form-group').show()
    // $('[name=supir]').parents('.form-group').show()
    // $('[name=trado]').parents('.form-group').show()
    // $('[name=gandengan]').parents('.form-group').show()
    // $('[name=gudang]').parents('.form-group').show()
    
    
    $('[name=statuspotongretur]').parents('.form-group').hide()
    $('[name=penerimaanstok_nobukti]').parents('.form-group').hide()
    $('[name=pengeluaranstok_nobukti]').parents('.form-group').hide()
    $('[name=servicein_nobukti]').parents('.form-group').hide()
    $('[name=supplier]').parents('.form-group').hide()
    $('[name=gudang]').parents('.form-group').hide()
    $('.tbl_qty').show()
    $('.tbl_vulkanisirke').hide();
    $('.tbl_harga').hide();
    $('.tbl_persentase').hide();
    $('.tbl_total').hide();
    $('.colspan').attr('colspan', 4);
    $('.sumrow').hide();
  }

  // function tampilanSpkAddRow() {
  //   $('.tbl_qty').show()
  //   $('.tbl_vulkanisirke').hide();
  //   $('.tbl_harga').hide();
  //   $('.tbl_persentase').hide();
  //   $('.tbl_total').hide();
  //   $('.colspan').attr('colspan', 4);
  //   $('.sumrow').hide();
  // }

  function tampilanrbt() {
    // $('[name=nobukti]').parents('.form-group').show()
    // $('[name=tglbukti]').parents('.form-group').show()
    // $('[name=pengeluaranstok]').parents('.form-group').show()
    // $('[name=supplier]').parents('.form-group').show()
    // $('[name=penerimaanstok_nobukti]').parents('.form-group').show()
    // $('[name=trado]').parents('.form-group').show()
    // $('[name=gandengan]').parents('.form-group').show()
    // $('[name=gudang]').parents('.form-group').show()
    // $('[name=statuspotongretur]').parents('.form-group').show()
    
    $('[name=pengeluaranstok_nobukti]').parents('.form-group').hide()
    $('[name=servicein_nobukti]').parents('.form-group').hide()
    $('[name=kerusakan]').parents('.form-group').hide()
    $('[name=supir]').parents('.form-group').hide()
    $('[name=gandengan]').parents('.form-group').hide()
    $('[name=trado]').parents('.form-group').hide()
   $('.tbl_qty').show()
    $('.tbl_harga').show()
    $('.tbl_total').show()
    $('.tbl_vulkanisirke').hide();
    $('.tbl_persentase').hide();
    $('.colspan').attr('colspan', 4);
  }

  // function tampilanRbtAddRow() {
  //   $('.tbl_qty').show()
  //   $('.tbl_harga').show()
  //   $('.tbl_total').show()
  //   $('.tbl_vulkanisirke').hide();
  //   $('.tbl_persentase').hide();
  //   $('.colspan').attr('colspan', 4);
  // }

  function tampilankor() {
    // $('[name=nobukti]').parents('.form-group').show()
    // $('[name=tglbukti]').parents('.form-group').show()
    // $('[name=pengeluaranstok]').parents('.form-group').show()
    // $('[name=trado]').parents('.form-group').show()
    // $('[name=gandengan]').parents('.form-group').show()
    // $('[name=gudang]').parents('.form-group').show()
    $('[name=supplier]').parents('.form-group').hide()
    $('[name=servicein_nobukti]').parents('.form-group').hide()
    $('[name=penerimaanstok_nobukti]').parents('.form-group').hide()
    $('[name=pengeluaranstok_nobukti]').parents('.form-group').hide()
    $('[name=kerusakan]').parents('.form-group').hide()
    $('[name=supir]').parents('.form-group').hide()
    $('[name=statuspotongretur]').parents('.form-group').hide()
$('.tbl_qty').show()
    $('.tbl_vulkanisirke').hide();
    $('.tbl_harga').hide();
    $('.tbl_persentase').hide();
    $('.tbl_total').hide();
    $('.colspan').attr('colspan', 4);
    $('.sumrow').hide();
  }
  // function tampilanKorAddRow() {
  //   $('.tbl_qty').show()
  //   $('.tbl_vulkanisirke').hide();
  //   $('.tbl_harga').hide();
  //   $('.tbl_persentase').hide();
  //   $('.tbl_total').hide();
  //   $('.colspan').attr('colspan', 4);
  //   $('.sumrow').hide();
  // }
    
    
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
     
   tampilanAllRow();
    // $('.data_tbl').show();
  }
  function tampilanAllRow() {
    $('.tbl_vulkanisirke').show()
    $('.tbl_qty').show()
    $('.tbl_harga').show()
    $('.tbl_persentase').show()
    $('.tbl_total').show()
    $('.colspan').attr('colspan', 6);
  }

  $('#crudModal').on('shown.bs.modal', () => {
    let form = $('#crudForm')

    setFormBindKeys(form)

    activeGrid = null
    initDatepicker()
    
    initSelect2($('#statuspotongretur'),true)
    if( form.data('action') !== 'add'){
      let pengeluaranstok = $('#crudForm').find(`[name="pengeluaranstok"]`).parents('.input-group').children()
      pengeluaranstok.attr('disabled', true)
      pengeluaranstok.find('.lookup-toggler').attr('disabled', true)
      $('#pengeluaranstokId').attr('disabled', true);
      console.log(pengeluaranstok);
    }
    // getMaxLength(form)
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    $('#crudModal').find('.modal-body').html(modalBody)
  })

  function createPengeluaranstokHeader() {
    resetRow()
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    $('#crudModalTitle').text('Create Pengeluaran Stok')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusPotongReturOptions(form)
      ])
      .then(() => {
        $('#crudModal').modal('show')
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
      initLookup()
    addRow()
    sumary()
  }

  function editPengeluaranstokHeader(pengeluaranStokHeaderId) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Pengeluaran Stok')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusPotongReturOptions(form)
      ])
      .then(() => {
        showPengeluaranstokHeader(form, pengeluaranStokHeaderId)
          .then(() => {
            $('#crudModal').modal('show')
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
      initLookup()
  }

  function deletePengeluaranstokHeader(pengeluaranStokHeaderId) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Pengeluaran Stok')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusPotongReturOptions(form)
      ])
      .then(() => {
        showPengeluaranstokHeader(form, pengeluaranStokHeaderId)
          .then(() => {
            $('#crudModal').modal('show')
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
      initLookup()
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
        }
      })
    })
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
                    <input type="text"  name="detail_vulkanisirke[]" style="" class="form-control">                    
                  </td>  
                  <td>
                    <input type="text"  name="detail_keterangan[]" style="" class="form-control">                    
                  </td>
                  <td>
                    <input type="text"  name="detail_qty[]" id="detail_qty${index}" onkeyup="cal(${index})" style="text-align:right" class="form-control autonumeric number${index}">
                  </td>  
                  
                  <td class="data_tbl tbl_harga">
                    <input type="text"  name="detail_harga[]" id="detail_harga${index}" onkeyup="cal(${index})" style="text-align:right" class="form-control autonumeric number${index}">
                  </td>  
                  
                  <td class="data_tbl tbl_persentase">
                    <input type="text"  name="detail_persentasediscount[]" id="detail_persentasediscount${index}" onkeyup="cal(${index})" style="text-align:right" class="form-control autonumeric number${index}">
                  </td>  
                  <td class="data_tbl tbl_total">
                    <input type="text"  name="totalItem[]" readonly id="totalItem${index}" style="text-align:right" class="form-control totalItem autonumeric number${index}">                    
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
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

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


  function lookupSelected(el){
    if (kodePengeluaranStok =="KOR") {
      // console.log(kodepengeluaranstok);
      // console.log(el);
      switch (el) {
        case 'trado':
          $('#crudForm').find(`[name="gandengan"]`).parents('.input-group').children().attr('disabled',true)
          $('#crudForm').find(`[name="gandengan"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled',true)
          $('#gandenganId').attr('disabled',true);
          $('#crudForm').find(`[name="gudang"]`).parents('.input-group').children().attr('disabled',true)
          $('#crudForm').find(`[name="gudang"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled',true)
          $('#gudangId').attr('disabled',true);
          break;
        case 'gandengan':
          $('#crudForm').find(`[name="trado"]`).parents('.input-group').children().attr('disabled',true)
          $('#crudForm').find(`[name="trado"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled',true)
          $('#tradoId').attr('disabled',true);
          $('#crudForm').find(`[name="gudang"]`).parents('.input-group').children().attr('disabled',true)
          $('#crudForm').find(`[name="gudang"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled',true)
          $('#gudangId').attr('disabled',true);
          
          break;
          case 'gudang':
          $('#crudForm').find(`[name="trado"]`).parents('.input-group').children().attr('disabled',true)
          $('#crudForm').find(`[name="trado"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled',true)
          $('#tradoId').attr('disabled',true);
          $('#crudForm').find(`[name="gandengan"]`).parents('.input-group').children().attr('disabled',true)
          $('#crudForm').find(`[name="gandengan"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled',true)
          $('#gandenganId').attr('disabled',true);
          
          break;
        default:
          break;
        }
    }else if (kodePengeluaranStok =="SPK") {
      switch (el) {
      case 'trado':
          $('#crudForm').find(`[name="gandengan"]`).attr('disabled',true)
          $('#crudForm').find(`[name="gandengan"]`).parents('.input-group').children().attr('disabled',true)
          $('#crudForm').find(`[name="gandengan"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled',true)
          $('#gandenganId').attr('disabled',true);
          break;
        case 'gandengan':
          $('#crudForm').find(`[name="trado"]`).attr('disabled',true)
          $('#crudForm').find(`[name="trado"]`).parents('.input-group').children().attr('disabled',true)
          $('#crudForm').find(`[name="trado"]`).parents('.input-group').children().find('.lookup-toggler').attr('disabled',true)
          $('#tradoId').attr('disabled',true);
          default:
          break;
        }
    }
  }

  function enabledKorDisable(){
    $('#crudForm').find(`[name="gudang"]`).parents('.input-group').children().attr("disabled", false);
    $('#crudForm').find(`[name="gudang"]`).parents('.input-group').children().find(`.lookup-toggler`).attr("disabled", false);
    $('#gudangId').attr('disabled',false);
    $('#crudForm').find(`[name="trado"]`).parents('.input-group').children().attr("disabled", false);
    $('#crudForm').find(`[name="trado"]`).parents('.input-group').children().find(`.lookup-toggler`).attr("disabled", false);
    $('#tradoId').attr('disabled',false);
    $('#crudForm').find(`[name="gandengan"]`).parents('.input-group').children().attr("disabled", false);
    $('#crudForm').find(`[name="gandengan"]`).parents('.input-group').children().find(`.lookup-toggler`).attr("disabled", false);
    $('#gandenganId').attr('disabled',false);
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
        $('[name=supplier]').val(data.supplier).attr('readonly', true);
        $('[name=supplier]').data('currentValue', data.supplier)

        $('[name=supplier_id]').val(data.supplier_id)

        $('[name=gudang]').val(data.gudang).attr('readonly', true);
        $('[name=gudang]').data('currentValue', data.gudang)
        $('[name=gudang_id]').val(data.gudang_id)
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
          console.log(response);
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
                      <input type="text"  name="detail_vulkanisirke[]" style="" class="form-control">                    
                    </td>  
                    <td>
                      <input type="text"  name="detail_keterangan[]" style="" class="form-control">                    
                    </td>
                    <td>
                      <input type="text"  name="detail_qty[]" id="detail_qty${id}" onkeyup="cal(${id})" style="text-align:right" class="form-control autonumeric number${id}">                    
                    </td>  
                    
                    <td class="data_tbl tbl_harga">
                      <input type="text"  name="detail_harga[]" id="detail_harga${id}" onkeyup="cal(${id})" style="text-align:right" class="autonumeric number${id} form-control">                    
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
              // var levelcoa = $(`#levelcoa`).val();
                this.postData = {

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
            id++;
          })
          sumary()
          
          setKodePengeluaran(response.data.pengeluaranstok);
          enabledKorDisable()
          lookupSelected(persediaan)
          resolve()
        }
      })
    })
  }

  
  function getSpb(detail_id) {
    resetRow()
    $.ajax({
      url: `${apiUrl}penerimaanstokdetail?penerimaanstokheader_id=${detail_id}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        console.log(response);
        sum = 0;
        var statusformat;
        
        $.each(response.data, (id, detail) => {
          console.log(detail);
          let detailRow = $(`
            <tr class="trow">
                  <td>
                    <div class="baris">1</div>
                  </td>
                  
                  <td>
                    <input type="text"  name="detail_stok[]" id="detail_stok_${id}" class="form-control stok-lookup ">
                    <input type="text" id="detailstokId_${id}" readonly hidden class="detailstokId" name="detail_stok_id[]">
                  </td>
                   <td class="data_tbl tbl_vulkanisirke " style="display: none;">
                    <input type="text"  name="detail_vulkanisirke[]" style="" class="form-control">                    
                  </td>  
                  <td>
                    <input type="text"  name="detail_keterangan[]" style="" class="form-control">                    
                  </td>
                  <td>
                    <input type="text"  name="detail_qty[]" id="detail_qty${id}" onkeyup="cal(${id})" style="text-align:right" class="form-control autonumeric number${id}">                    
                  </td>  
                  
                  <td class="data_tbl tbl_harga">
                    <input type="text"  name="detail_harga[]" id="detail_harga${id}" onkeyup="cal(${id})" style="text-align:right" class="autonumeric number${id} form-control">                    
                  </td>  
                  
                  <td class="data_tbl tbl_persentase" style="display: none;">
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
        })
        sumary()
        
      }
    })
  }

  function cekValidasi(Id, Aksi) {
    $.ajax({
        url: `{{ config('app.api_url') }}pengeluaranstokheader/${Id}/cekvalidasi`,
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
                        editPengeluaranstokHeader(Id)
                    }
                    if (Aksi == 'DELETE') {
                        deletePengeluaranstokHeader(Id)
                    }
                }
            } else {
                showDialog(response.message['keterangan'])
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
      $('.pengeluaranstok-lookup').lookup({
        title: 'pengeluaran stok Lookup',
        fileName: 'pengeluaranstok',
        beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
        onSelectRow: (pengeluaranstok, element) => {
          // setKodePengeluaran(pengeluaranstok.statusformatid)
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
      $('.supir-lookup').lookup({
        title: 'supir Lookup',
        fileName: 'supir',
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
      
      $('.kerusakan-lookup').lookup({
        title: 'kerusakan Lookup',
        fileName: 'kerusakan',
        
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
      $('.supplier-lookup').lookup({
        title: 'supplier Lookup',
        fileName: 'supplier',
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

      $('.bank-lookup').lookup({
        title: 'bank Lookup',
        fileName: 'bank',
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
      
      $('.trado-lookup').lookup({
        title: 'Trado Lookup',
        fileName: 'trado',
        beforeProcess: function(test) {

          // var levelcoa = $(`#levelcoa`).val();
            this.postData = {
  
              Aktif: 'AKTIF',
            }
          },

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
          element.data('currentValue', element.val())
          enabledKorDisable()
        }
      })

      $('.gandengan-lookup').lookup({
        title: 'gandengan Lookup',
        fileName: 'gandengan',
        beforeProcess: function(test) {
          this.postData = {
            // var levelcoa = $(`#levelcoa`).val();
  
            Aktif: 'AKTIF',
          }
        },

        onSelectRow: (gandengan, element) => {
          element.val(gandengan.keterangan)
          $(`#${element[0]['name']}Id`).val(gandengan.id)
          element.data('currentValue', element.val())
          lookupSelected(`gandengan`);

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
          setSuplier(penerimaan.id);
          element.val(penerimaan.nobukti)
          element.data('currentValue', element.val())
          if (kodePengeluaranStok == "RTR") {
            getSpb(penerimaan.id)
          }
        },
        beforeProcess: function(test) {
          var supplierId= $(`#supplierId`).val();
          var pengeluaranstokId= $(`#pengeluaranstokId`).val();
          this.postData = {
            supplier_id:supplierId,
            pengeluaranstok_id:pengeluaranstokId
          }
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
      $('.servicein-lookup').lookup({
        title: 'service in Lookup',
        fileName: 'serviceinheader',
        onSelectRow: (gandengan, element) => {
          element.val(gandengan.nobukti)
          console.log(gandengan);
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

  }
</script>
@endpush()