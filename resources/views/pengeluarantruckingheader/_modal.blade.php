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
                  KODE PENGELUARAN <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="pengeluarantrucking_id">
                <input type="text" name="pengeluarantrucking" class="form-control pengeluarantrucking-lookup">
              </div>
            </div>

            
            <div class="row form-group">
              <div class="col-12 col-sm-2 col-md-2">
                <label class="col-form-label">
                  TANGGAL dari <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-4 col-md-4">
                <div class="input-group">
                  <input type="text" name="tgldari" class="form-control datepicker">
                </div>
              </div>

              <div class="col-12 col-sm-2 col-md-2">
                <label class="col-form-label">
                  TANGGAL sampai <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-4 col-md-4">
                <div class="input-group">
                  <input type="text" name="tglsampai" class="form-control datepicker">
                </div>
              </div>
            </div>
            
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  supir <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" id="supirHaeaderId" name="supirheader_id">
                <input type="text" name="supir" class="form-control supirheader-lookup">
              </div>
            </div>


            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  NAMA PERKIRAAN <span class="text-danger">*</span>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="coa">
                <input type="text" name="keterangancoa" class="form-control akunpusat-lookup">
              </div>
            </div>

            <div class="border p-3">
              <h6>Posting Pengeluaran</h6>

              <div class="row form-group">
                <div class="col-12 col-md-2">
                  <label class="col-form-label">
                    POSTING <span class="text-danger">*</span></label>
                </div>
                <div class="col-12 col-md-4">
                  <input type="hidden" name="bank_id">
                  <input type="text" name="bank" class="form-control bank-lookup">
                </div>
              </div>
              <div class="row form-group">
                <div class="col-12 col-md-2">
                  <label class="col-form-label">
                    NO BUKTI KAS/BANK MASUK </label>
                </div>
                <div class="col-12 col-md-4">
                  <input type="text" name="pengeluaran_nobukti" id="pengeluaran_nobukti" class="form-control" readonly>
                </div>
              </div>
            </div>
            <div id="detail-bst-section">
              <table id="modalgrid"></table>
              <div id="modalgridPager"></div>
              <div id="detail-list-grid" style="display:none"></div>
            </div>
            <div id="detail-default-section" class="table-scroll table-responsive">
              <table class="table table-bordered table-bindkeys mt-3" id="detailList" style="width: 1000px;">
                <thead>
                  <tr>
                    <th width="1%" class="">No</th>
                    <th class="data_tbl tbl_checkbox" style="display:none" width="1%">Pilih</th>
                    <th width="20%" class="data_tbl tbl_supir_id">SUPIR</th>
                    <th class="data_tbl tbl_penerimaantruckingheader" width="20%">NO BUKTI PENERIMAAN TRUCKING</th>
                    <th width="14%" class="tbl_sisa">Sisa</th>
                    <th width="20%" class="tbl_nominal">Nominal</th>
                    <th class="data_tbl tbl_keterangan" width="25%">Keterangan</th>
                    <th width="1%" class="tbl_aksi">Aksi</th>
                  </tr>
                </thead>
                <tbody id="table_body" class="form-group">

                </tbody>
                <tfoot>
                   <tr>
                    <td colspan="3" class="colspan">
                      <p class="text-right font-weight-bold">TOTAL :</p>
                    </td>
                    <td id="sisaColFoot" style="display: none">
                      <p class="text-right font-weight-bold autonumeric" id="sisaFoot"></p>
                    </td>
                    <td>
                      <p class="text-right font-weight-bold autonumeric" id="total"></p>
                    </td>
                    <td class="colmn-offset"></td>
                    <td id="tbl_addRow">
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
  var KodePengeluaranId
  let selectedRows = [];
  $(document).ready(function() {

    $("#crudForm [name]").attr("autocomplete", "off");

    $(document).on('click', "#addRow", function() {
      addRow()
    });

    $(document).on('click', '.delete-row', function(event) {
      deleteRow($(this).parents('tr'))
    })

    $(document).on('input', `#table_body [name="nominal[]"]`, function(event) {
      setTotal()
    })

    function rangeInvoice() {
      var tgldari = $('#crudForm').find(`[name="tgldari"]`).val()
      var tglsampai = $('#crudForm').find(`[name="tglsampai"]`).val()
      // console.log(tgldari, tglsampai);
      if (tgldari !== "" && tglsampai !== "") {
        getInvoice(tgldari, tglsampai)
      }
    }
      
    $(document).on("change",`[name=tgldari], [name=tglsampai]`,function(event) {
        rangeInvoice();
      })

    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      let data
      if (KodePengeluaranId == "TDE") {
        data = []
  
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
          name: 'pengeluarantrucking_id', 
          value: form.find(`[name="pengeluarantrucking_id"]`).val()
        })
        data.push({
          name: 'pengeluarantrucking', 
          value: form.find(`[name="pengeluarantrucking"]`).val()
        })
        data.push({
          name: 'supirheader_id', 
          value: form.find(`[name="supirheader_id"]`).val()
        })
        data.push({
          name: 'supir', 
          value: form.find(`[name="supir"]`).val()
        })
        data.push({
          name: 'coa', 
          value: form.find(`[name="coa"]`).val()
        })
        data.push({
          name: 'keterangancoa', 
          value: form.find(`[name="keterangancoa"]`).val()
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
          name: 'pengeluaran_nobukti', 
          value: form.find(`[name="pengeluaran_nobukti"]`).val()
        })
        $('#table_body tr').each(function(row, tr) {
          
          if ($(this).find('[name="pinjPribadi[]"]').is(':checked')) {
            data.push({
              name: 'supir_id[]',
              value: form.find(`[name="supirheader_id"]`).val()
            })
            data.push({
              name: 'penerimaantruckingheader_nobukti[]',
              value: $(this).find(`[name="pinjPribadi_nobukti[]"]`).val()
            })
            data.push({
              name: 'keterangan[]',
              value: $(this).find(`[name="pinjPribadi_keterangan[]"]`).val()
            })
            data.push({
              name: 'nominal[]',
              value: AutoNumeric.getNumber($(`#crudForm [name="nominalDP[]"]`)[row])
            })
            
          }
          
        })
        
      }else{
        data = $('#crudForm').serializeArray()
       
          $('#crudForm').find(`[name="nominal[]"`).each((index, element) => {
            if (KodePengeluaranId != "BST") {
              data.filter((row) => row.name === 'nominal[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominal[]"]`)[index])
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
        name: 'pengeluaranheader_id',
        value: data.find(item => item.name === "pengeluarantrucking_id").value
      })


      let kodepengeluaranheader = data.find(item => item.name === "pengeluarantrucking_id").value;

      let tgldariheader = $('#tgldariheader').val();
      let tglsampaiheader = $('#tglsampaiheader').val()

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}pengeluarantruckingheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}pengeluarantruckingheader/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}pengeluarantruckingheader/${Id}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&pengeluaranheader_id=${kodepenerimaanheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}pengeluarantruckingheader`
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
          $('#crudModal').modal('hide')
          $('#crudModal').find('#crudForm').trigger('reset')
          
          $('#kodepengeluaranheader').val(response.data.pengeluarantrucking_id).trigger('change')

          $('#jqGrid').jqGrid('setGridParam', {
            postData: {pengeluaranheader_id: response.data.pengeluarantrucking_id},
            page: response.data.page
          }).trigger('reloadGrid');

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
            if (KodePengeluaranId =="TDE") {
              penerimaantruckingheaderid = []
              $('#table_body tr').each(function(row, tr) {
                if ($(this).find(`[name="penerimaantruckingheader_id[]"]`).is(':checked')) {
                  penerimaantruckingheaderid.push($(this).find(`[name="penerimaantruckingheader_id[]"]`).val())
                }
              })
              errors = error.responseJSON.errors
  
              $.each(errors, (index, error) => {
                let indexes = index.split(".");
                let angka = indexes[1]
                
                row = penerimaantruckingheaderid[angka] - 1;
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
            }else{
              setErrorMessages(form, error.responseJSON.errors);
            }
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

  function setKodePengeluaran(kode){
    KodePengeluaranId = kode;
    $('#detailList tbody').html('')
    $('#detail-list-grid').html('')
    setTampilanForm();
    addRow()
  }
  function setTampilanForm(){
    tampilanall()
    switch (KodePengeluaranId) {
      case 'PJT':
        tampilanPJT()
        break;
      case 'TDE':
        tampilanTDE()
        break;
      case 'BST':
        tampilanBST()
        break;
      case 'BSB':
        tampilanBSB()
        break;
      default:
        tampilanall()
        break;
    }
  }

  function tampilanPJT() {
    
    $('[name=keterangancoa]').parents('.form-group').hide()
    $('[name=supirheader_id]').parents('.form-group').hide()
    $('[name=tgldari]').parents('.form-group').hide()
    $('#detail-bst-section').hide()
    $('#detail-default-section').show()
    $('.tbl_checkbox').hide()
    $('.tbl_supir_id').show()
    $('.tbl_aksi').show()
    $('.colspan').attr('colspan', 3);
    $('#tbl_addRow').show()
    // $('.colmn-offset').hide()
  }
  function tampilanTDE() {
    $('[name=keterangancoa]').parents('.form-group').hide()
    $('.tbl_supir_id').hide()
    $('[name=supirheader_id]').parents('.form-group').show()
    $('[name=tgldari]').parents('.form-group').hide()
    $('#detail-bst-section').hide()
    $('#detail-default-section').show()
    $('.tbl_checkbox').show()
    $('.tbl_sisa').show()
  
    $('.colspan').attr('colspan', 3);
    $('#sisaColFoot').show()
    $('#sisaFoot').show()
    
    $('.tbl_aksi').hide()
    $('#tbl_addRow').hide()
    
  }

  function tampilanBST() {
    $('#detailList tbody').html('')
    $('[name=keterangancoa]').parents('.form-group').hide()
    $('[name=supirheader_id]').parents('.form-group').hide()
    $('[name=tgldari]').parents('.form-group').show()
    $('#detail-bst-section').show()
    $('#detail-default-section').hide()
    $('.tbl_checkbox').hide()
    $('.tbl_penerimaantruckingheader').hide()
    $('.tbl_supir_id').show()
    $('.tbl_aksi').show()
    $('.colspan').attr('colspan', 2);
    $('#tbl_addRow').show()
    // $('.colmn-offset').hide()
    loadModalGrid()
  }
  function tampilanBSB() {
    
    $('[name=keterangancoa]').parents('.form-group').hide()
    $('[name=supirheader_id]').parents('.form-group').hide()
    $('[name=tgldari]').parents('.form-group').hide()
    $('#detail-bst-section').hide()
    $('#detail-default-section').show()
    $('.tbl_checkbox').hide()
    $('.tbl_penerimaantruckingheader').hide()
    $('.tbl_supir_id').show()
    $('.tbl_aksi').show()
    $('.colspan').attr('colspan', 2);
    $('#tbl_addRow').show()
    // $('.colmn-offset').hide()
  }
  function tampilanall() {
    $('[name=keterangancoa]').parents('.form-group').show()
    $('.tbl_supir_id').show()
    $('.tbl_sisa').hide()
    $('.tbl_penerimaantruckingheader').show()
    $('[name=supirheader_id]').parents('.form-group').hide()
    $('[name=tgldari]').parents('.form-group').hide()
    $('#detail-bst-section').hide()
    $('#detail-default-section').show()
    $('.colspan').attr('colspan', 3);
    $('#sisaColFoot').hide()
    $('#sisaFoot').hide()
    $('.colmn-offset').show()
    
  }
    
  $(document).on('click', '.checkItem', function(event) {
    enabledRow($(this).data("id"))
  })
    
  function enabledRow(row) {
    let check = $(`#penerimaantruckingheader_id${row}`)
    if (check.prop("checked") == true) {
      $(`#nominal_${row}`).prop('disabled', false)
      $(`#penerimaantruckingheader_nobukti_detail${row}`).prop('disabled', false)
      $(`#keterangan_detail${row}`).prop('disabled', false)
    } else if (check.prop("checked") == false) {
      $(`#nominal_${row}`).prop('disabled', true)
      $(`#penerimaantruckingheader_nobukti_detail${row}`).prop('disabled', true)
      $(`#keterangan_detail${row}`).prop('disabled', true)
    }
    setTotal()

  }

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
    selectedRows = []

    $('#crudModal').find('.modal-body').html(modalBody)
  })

  function setTotal() {
    let nominalDetails = $(`#table_body [name="nominal[]"]:not([disabled])`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });
    new AutoNumeric('#total').set(total)
  }

  function createPengeluaranTruckingHeader() {
    let form = $('#crudForm')

    $('#crudModal').find('#crudForm').trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
    form.data('action', 'add')

    $('#crudModalTitle').text('Add Pengeluaran Trucking')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()


    $('#table_body').html('')
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    setDefaultBank()
    // setStatusPostingOptions(form)
    addRow()
    setTotal()
  }

  function editPengeluaranTruckingHeader(id) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
    $('#crudModalTitle').text('Edit Pengeluaran Truck')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    // Promise
    //   .all([
    //     setStatusPostingOptions(form)
    //   ])
    //   .then(() => {
    //     showPengeluaranTruckingHeader(form, id)
    //   })

    form.find(`[name="bank"]`).removeClass('bank-lookup')
    form.find(`[name="pengeluarantrucking"]`).removeClass('pengeluarantrucking-lookup')
    showPengeluaranTruckingHeader(form, id)

  }

  function deletePengeluaranTruckingHeader(id) {

    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Hapus
    `)
    $('#crudModalTitle').text('Delete Pengeluaran Truck')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    // Promise
    //   .all([
    //     setStatusPostingOptions(form)
    //   ])
    //   .then(() => {
    //     showPengeluaranTruckingHeader(form, id)
    //   })

    form.find(`[name="bank"]`).removeClass('bank-lookup')
    form.find(`[name="pengeluarantrucking"]`).removeClass('pengeluarantrucking-lookup')
    showPengeluaranTruckingHeader(form, id)

  }

  function cekValidasi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}pengeluarantruckingheader/${Id}/cekvalidasi`,
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
      url: `{{ config('app.api_url') }}pengeluarantruckingheader/${Id}/cekValidasiAksi`,
      method: 'POST',
      dataType: 'JSON',
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      success: response => {
        var kondisi = response.kondisi
        if (kondisi == true) {
          showDialog(response.message['keterangan'])
        } else {
          if (Aksi == 'EDIT') {
            editPengeluaranTruckingHeader(Id)
          }
          if (Aksi == 'DELETE') {
            deletePengeluaranTruckingHeader(Id)
          }
        }

      }
    })
  }
  function setDefaultBank(){
    $.ajax({
      url: `${apiUrl}bank`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        $.each(response.data, (index, bank) => {
          // console.log(index); 
          if (bank.id == 1) {
            $('#crudForm [name=bank_id]').first().val(bank.id)
            $('#crudForm [name=bank]').first().val(bank.namabank)
            $('#crudForm [name=bank]').first().data('currentValue', $('#crudForm [name=bank]').first().val())
          }
        })
      }
    })
  }

  function showPengeluaranTruckingHeader(form, id) {
    $('#detailList tbody').html('')

    $.ajax({
      url: `${apiUrl}pengeluarantruckingheader/${id}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        let tgl = response.data.tglbukti
        let kodepengeluaran = response.data.kodepengeluaran

        $.each(response.data, (index, value) => {
          let element = form.find(`[name="${index}"]`)
          if (element.is('select')) {
            element.val(value).trigger('change')
          } else if (element.hasClass('datepicker')) {
            element.val(dateFormat(value))
          } else {
            element.val(value)
          }

          if (index == 'periodedari') {
            form.find(`[name="tgldari"]`).val(dateFormat(value))
          }
          if (index == 'periodesampai') {
            form.find(`[name="tglsampai"]`).val(dateFormat(value))
          }

          if (index == 'pengeluarantrucking') {
            element.data('current-value', value).prop('readonly', true)
          }
          if (index == 'bank') {
            element.data('current-value', value).prop('readonly', true)
          }
          if (index == 'keterangancoa') {
            element.data('current-value', value)
          }
        })

        if (kodepengeluaran === "TDE") {
          getTarikDeposito(id)
        }else{
          $.each(response.detail, (index, detail) => {
            let detailRow = $(`
              <tr>
                  <td></td>
                  <td class="data_tbl tbl_supir">
                      <input type="hidden" name="supir_id[]">
                      <input type="text" name="supir[]" data-current-value="${detail.supir}" class="form-control supir-lookup">
                  </td>
                  <td class="data_tbl tbl_penerimaantruckingheader">
                      <input type="text" name="penerimaantruckingheader_nobukti[]" data-current-value="${detail.penerimaantruckingheader_nobukti}" class="form-control penerimaantruckingheader-lookup">
                  </td>
                  <td class="data_tbl tbl_nominal">
                      <input type="text" name="nominal[]" class="form-control autonumeric nominal"> 
                  </td>
                  <td class="data_tbl tbl_keterangan">
                      <input type="text" name="keterangan[]" class="form-control"> 
                  </td>
                  <td>
                      <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
                  </td>
              </tr>
            `)
  
            detailRow.find(`[name="supir_id[]"]`).val(detail.supir_id)
            detailRow.find(`[name="supir[]"]`).val(detail.supir)
            detailRow.find(`[name="keterangan[]"]`).val(detail.keterangan)
            detailRow.find(`[name="penerimaantruckingheader_nobukti[]"]`).val(detail.penerimaantruckingheader_nobukti)
            detailRow.find(`[name="nominal[]"]`).val(detail.nominal)
  
            initAutoNumeric(detailRow.find(`[name="nominal[]"]`))
            $('#detailList tbody').append(detailRow)
  
            setTotal();
  
            $('.supir-lookup').last().lookup({
              title: 'Supir Lookup',
              fileName: 'supir',
              beforeProcess: function(test) {
                // var levelcoa = $(`#levelcoa`).val();
                this.postData = {
                  Aktif: 'AKTIF',
                }
              },
              onSelectRow: (supir, element) => {
                element.parents('td').find(`[name="supir_id[]"]`).val(supir.id)
                element.val(supir.namasupir)
                element.data('currentValue', element.val())
              },
              onCancel: (element) => {
                element.val(element.data('currentValue'))
              },
              onClear: (element) => {
                element.parents('td').find(`[name="supir_id[]"]`).val('')
                element.val('')
                element.data('currentValue', element.val())
              }
            })
  
            $('.penerimaantruckingheader-lookup').last().lookup({
              title: 'Penerimaan Trucking Lookup',
              fileName: 'penerimaantruckingheader',
              beforeProcess: function(test) {
                // var levelcoa = $(`#levelcoa`).val();
                this.postData = {
  
                  Aktif: 'AKTIF',
                }
              },
              onSelectRow: (penerimaantruckingheader, element) => {
                element.val(penerimaantruckingheader.nobukti)
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

        }
        KodePengeluaranId = kodepengeluaran

        setTampilanForm()


        if(kodepengeluaran === "BST"){
          let detailRow =""
          $.each(response.detail, (index, detail) => {
            resetGrid()
            
            let id = detail.id_detail
            detailRow += `
            <div id="detail_row_${id}">
            <input type="text" value="${id}"  id="id_detail${id}" class="" name="id_detail[]"  readonly   >
            <input type="text" value="${detail.container_detail}"  id="container_detail${id}" class="" name="container_detail[]"  readonly   >
            <input type="text" value="${detail.noinvoice_detail}"  id="noinvoice_detail${id}" class="" name="noinvoice_detail[]"  readonly   >
            <input type="text" value="${detail.nominal_detail}"  id="nominal${id}" class="" name="nominal[]"  readonly   >
            <input type="text" value="${detail.nojobtrucking_detail}"  id="nojobtrucking_detail${id}" class="" name="nojobtrucking_detail[]"  readonly   >
            </div>
            `
            selectedRows.push(id);
          })
          $('#detail-list-grid').html(detailRow)
          $('#modalgrid').setGridParam({
            datatype: "local",
            data:response.detail
          }).trigger('reloadGrid')
          // // console.log('dsfgdfg');
          // $('#modalgrid').jqGrid('setGridParam',{
          //   data:response.detail
          // }).trigger('reloadGrid')
            
          $('.checkBoxgrid').prop('checked', true);
        }
        setRowNumbers()
        if (form.data('action') === 'delete') {
          form.find('[name]').addClass('disabled')
          initDisabled()
        }
      }
    })
  }
  function getDeposito(){
    let supir_id = $('#supirHaeaderId').val();
    KodePengeluaranId

    let data = {
      "supir":supir_id,
    }
    if ((KodePengeluaranId == "TDE") && (supir_id != "")) {
      $.ajax({
        url: `${apiUrl}pengeluarantruckingheader/getdeposito`,
        method: 'POST',
        dataType: 'JSON',
        data: data,
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $('#detailList tbody').html('')
          let totalSisa = 0
          $.each(response.data, (index, detail) => {
            let id = detail.id
            totalSisa = totalSisa + parseFloat(detail.sisa);
            let sisa = new Intl.NumberFormat('en-US').format(detail.sisa);
            let detailRow = $(`
                <tr >
                <td>
                  ${id}
                </td>
                <td>
                    <input name='pinjPribadi[]' type="checkbox" id="checkItem" value="${id}">
                    <input name='pinjPribadi_nobukti[]' type="hidden" value="${detail.nobukti}">
                </td>
                <td>${detail.nobukti}</td>
                <td>
                    <p class="text-right sisaDP autonumeric">${sisa}</p>
                    <input type="hidden" name="sisaDP[]" class="autonumeric" value="${sisa}">
                    <input type="hidden" name="sisaAwalDP[]" class="autonumeric" value="${sisa}">
                </td>
                <td id=${id}>
                    <input type="text" name="nominalDP[]" disabled class="form-control bayar text-right">
                </td>
                <td>
                    ${detail.keterangan}
                    <input name='pinjPribadi_keterangan[]' type="hidden" value="${detail.keterangan}">
                </td>
                </tr>
            `)

            initAutoNumeric(detailRow.find(`[name="sisaDP[]"]`))
            initAutoNumeric(detailRow.find(`[name="sisaAwalDP[]"]`))
            initAutoNumeric(detailRow.find(`.sisaDP`))

            $('#detailList tbody').append(detailRow)
            setTotalDP()
          })
          setTampilanForm()
          $(`#detailList tfoot`).show()

        }
      })
    }
  }

  function setTotalDP() {
    let nominalDetails = $(`#table_body [name="nominalDP[]"]:not([disabled])`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
        total += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#total').set(total)
    
  }
    
  $(document).on('click', `#detailList tbody [name="pinjPribadi[]"]`, function() {

    if ($(this).prop("checked") == true) {
      $(this).closest('tr').find(`td [name="nominalDP[]"]`).prop('disabled', false)
      let sisa = AutoNumeric.getNumber($(this).closest('tr').find(`td [name="sisaDP[]"]`)[0])
      initAutoNumeric($(this).closest('tr').find(`td [name="nominalDP[]"]`))

      // initAutoNumeric($(this).closest('tr').find(`td [name="nominalDP[]"]`).val(sisa))
      // let bayar = AutoNumeric.getNumber($(this).closest('tr').find(`td [name="nominalDP[]"]`)[0])
      // let totalSisa = sisa - bayar

      // $(this).closest("tr").find(".sisaDP").html(totalSisa)
      // $(this).closest("tr").find(`[name="sisaDP[]"]`).val(totalSisa)
      // initAutoNumeric($(this).closest("tr").find(".sisaDP"))
      setTotalDP()
      setSisaDP()
    } else {
      let id = $(this).val()
      $(this).closest('tr').find(`td [name="nominalDP[]"]`).remove();
      let newBayarElement = `<input type="text" name="nominalDP[]" class="form-control text-right" disabled>`
      $(this).closest('tr').find(`#${id}`).append(newBayarElement)
      
      let sisa = AutoNumeric.getNumber($(this).closest('tr').find(`td [name="sisaAwalDP[]"]`)[0])

      initAutoNumeric($(this).closest('tr').find(`td [name="sisaDP[]"]`).val(sisa))
      $(this).closest("tr").find(".sisaDP").html(sisa)
      initAutoNumeric($(this).closest("tr").find(".sisaDP"))

      setTotalDP()
      setSisaDP()
    }
  })
      
  $(document).on('input', `#table_body [name="nominalDP[]"]`, function(event) {
    setTotalDP()
    setSisaDetail(this)
  })

  function setSisaDetail(el){
    let sisa = AutoNumeric.getNumber($(el).closest("tr").find(`[name="sisaDP[]"]`)[0])
    let sisaAwal = AutoNumeric.getNumber($(el).closest("tr").find(`[name="sisaAwalDP[]"]`)[0])
    let bayar = $(el).val()
    bayar = parseFloat(bayar.replaceAll(',', ''));
    // console.log( sisaAwal , bayar );
    bayar = Number.isNaN(bayar) ? 0 : bayar
    totalSisa = sisaAwal - bayar
    $(el).closest("tr").find(".sisaDP").html(totalSisa)
    $(el).closest("tr").find(`[name="sisaDP[]"]`).val(totalSisa)
    initAutoNumeric($(el).closest("tr").find(".sisaDP"))
    let Sisa = $(`#table_body .sisaDP`)
    let total = 0
  
    $.each(Sisa, (index, SISA) => {
        total += AutoNumeric.getNumber(SISA)
    });
    new AutoNumeric('#sisaFoot').set(total)
  }

  function setSisaDP() {
    let nominalDetails = $(`.sisaDP`)
    let bayar = 0
    $.each(nominalDetails, (index, nominalDetail) => {
        bayar += AutoNumeric.getNumber(nominalDetail)
    });
  
    new AutoNumeric('#sisaFoot').set(bayar)
  }

  function getTarikDeposito(id){
    $.ajax({
      url: `${apiUrl}pengeluarantruckingheader/${id}/gettarikdeposito`,
      method: 'POST',
      dataType: 'JSON',
      // data: data,
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      
      success: response => {
        $('#detailList tbody').html('')
          let totalSisa = 0
          $.each(response.data, (index, detail) => {
            let check =""
            let disbaled ="disabled"
            // let awal = new Intl.NumberFormat('en-US').format(detail.sisa);
            if (detail.bayar !== null) {
              check = "checked"
              disbaled = ""
              detail.sisa = parseFloat(detail.sisa) + parseFloat(detail.bayar)
              // console.log(detail.sisa)
            }
            let id = detail.id
            totalSisa = totalSisa + parseFloat(detail.sisa);
            let sisa = new Intl.NumberFormat('en-US').format(detail.sisa);
            
            let detailRow = $(`
              <tr >
              <td>
                ${id}
              </td>
              <td>
                  <input name='pinjPribadi[]' type="checkbox" ${check} id="checkItem" value="${id}">
                  <input name='pinjPribadi_nobukti[]' type="hidden" value="${detail.nobukti}">
              </td>
              <td>${detail.nobukti}</td>
              <td>
                  <p class="text-right sisaDP autonumeric">${sisa}</p>
                  <input type="hidden" name="sisaDP[]" class="autonumeric" value="${sisa}">
                  <input type="hidden" name="sisaAwalDP[]" class="autonumeric" value="${sisa}">
              </td>
              <td id=${id}>
                  <input type="text" name="nominalDP[]" ${disbaled} value="${detail.bayar}" id="bayar_${id}" class="form-control bayar text-right">
              </td>
              <td>
                  ${detail.keterangan}
                  <input name='pinjPribadi_keterangan[]' type="hidden" value="${detail.keterangan}">
              </td>
              </tr>
          `)

            initAutoNumeric(detailRow.find(`[name="sisaDP[]"]`))
            initAutoNumeric(detailRow.find(`[name="sisaAwalDP[]"]`))
            initAutoNumeric(detailRow.find(`.sisaDP`))
            initAutoNumeric(detailRow.find(`#bayar_${id}`))
          setSisaDetail(detailRow.find(`[name="nominalDP[]"]`))
            $('#detailList tbody').append(detailRow)
            setTotalDP()
          setSisaDP()
          })
          setTampilanForm()
          $(`#detailList tfoot`).show()

        }

    })
      
  }

  function addRow() {
    let detailRow = $(`
      <tr>
        <td></td>
        <td class="data_tbl tbl_supir">
          <input type="hidden" name="supir_id[]">
          <input type="text" name="supir[]"  class="form-control supir-lookup">
        </td>
        <td class="data_tbl tbl_penerimaantruckingheader">
          <input type="text" name="penerimaantruckingheader_nobukti[]"  class="form-control penerimaantruckingheader-lookup">
        </td>
        <td class="data_tbl tbl_nominal">
          <input type="text" name="nominal[]" class="form-control autonumeric nominal"> 
        </td>
        <td class="data_tbl tbl_keterangan">
          <input type="text" name="keterangan[]" class="form-control"> 
        </td>
        <td>
            <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
        </td>
      </tr>
    `)

    $('#detailList tbody').append(detailRow)

    $('.supir-lookup').last().lookup({
      title: 'Supir Lookup',
      fileName: 'supir',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (supir, element) => {
        element.parents('td').find(`[name="supir_id[]"]`).val(supir.id)
        element.val(supir.namasupir)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {

        element.parents('td').find(`[name="supir_id[]"]`).val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.penerimaantruckingheader-lookup').last().lookup({
      title: 'Penerimaan Trucking Lookup',
      fileName: 'penerimaantruckingheader',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (penerimaantruckingheader, element) => {
        element.val(penerimaantruckingheader.nobukti)
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

    initAutoNumeric(detailRow.find('.autonumeric'))
    setTampilanForm()
    setRowNumbers()
  }

  function checkboxHandler(element) {
    let value = $(element).val();
    // console.log(value);
        if (element.checked) {
          selectedRows.push($(element).val());
          $(`#detail_row_${value}`).find(`[name="id_detail[]"]`).attr('disabled',false)
          $(`#detail_row_${value}`).find(`[name="container_detail[]"]`).attr('disabled',false)
          $(`#detail_row_${value}`).find(`[name="noinvoice_detail[]"]`).attr('disabled',false)
          $(`#detail_row_${value}`).find(`[name="nominal[]"]`).attr('disabled',false)
          $(`#detail_row_${value}`).find(`[name="nojobtrucking_detail[]"]`).attr('disabled',false)
        } else {
          for (var i = 0; i < selectedRows.length; i++) {
            if (selectedRows[i] == value) {
              selectedRows.splice(i, 1);
            }
          }
          $(`#detail_row_${value}`).find(`[name="id_detail[]"]`).attr('disabled',true)
          $(`#detail_row_${value}`).find(`[name="container_detail[]"]`).attr('disabled',true)
          $(`#detail_row_${value}`).find(`[name="noinvoice_detail[]"]`).attr('disabled',true)
          $(`#detail_row_${value}`).find(`[name="nominal[]"]`).attr('disabled',true)
          $(`#detail_row_${value}`).find(`[name="nojobtrucking_detail[]"]`).attr('disabled',true)
        }
  }

  function loadModalGrid() {
    $("#modalgrid").jqGrid({
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "local",
      colModel: [
        {
          editable: true,
          edittype: 'checkbox',
          search: false,
          width: 60,
          align: 'center',
          formatoptions: {
            disabled: false
          },
          label: 'Pilih',
          name: 'id_detail',
          index: 'Pilih',
          // key:true,
          formatter: (value) => {
              return `<input type="checkbox" class="checkBoxgrid"  id="${value}_checkBoxgrid" value="${value}" onchange="checkboxHandler(this)">`
          },
         
        },
        {
          label: 'no invoice',
          name: 'noinvoice_detail',
        },
        {
          label: 'no job',
          name: 'nojobtrucking_detail',
        },
        {
          label: 'container',
          name: 'container_detail',
        },
        {
          label: 'nominal',
          name: 'nominal_detail',
          align: 'right',
          formatter: currencyFormat,
        },
      ],
      autowidth: true,
      shrinkToFit: false,
      height: 350,
      rowNum: 10,
      rownumbers: true,
      rownumWidth: 45,
      rowList: [10, 20, 50, 0],
      toolbar: [true, "top"],
      sortable: true,
      viewrecords: true,
      footerrow:true,
      userDataOnFooter: true,
      loadComplete: function(data) {
        let grid = $(this)
        changeJqGridRowListText()
        initResize($(this))
        // console.log(data);
        $.each(selectedRows, function(key, value) {
          $(grid).find('tbody tr').each(function(row, tr) {
            if ($(this).find(`td input:checkbox`).val() == value) {
              // console.log(value);
              $(this).addClass('bg-light-blue')
              $(this).find(`td input:checkbox`).prop('checked', true)
            }
          })
        });
        
        $('.clearsearchclass').click(function() {
          clearColumnSearch($(this))
        })
  
        if (indexRow > $(this).getDataIDs().length - 1) {
          indexRow = $(this).getDataIDs().length - 1;
        }
  
        $('#modalgrid').setSelection($('#modalgrid').getDataIDs()[0])
  
        setHighlight($(this))
      },
      onSelectRow: function(id) {
        activeGrid = $(this)
        indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
        page = $(this).jqGrid('getGridParam', 'page')
        let limit = $(this).jqGrid('getGridParam', 'postData').limit
        if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))
        

},
    })
    .jqGrid('filterToolbar', {
      stringResult: true,
      searchOnEnter: false,
      defaultSearch: 'cn',
      groupOp: 'AND',
      disabledKeys: [17, 33, 34, 35, 36, 37, 38, 39, 40],
      beforeSearch: function() {
        clearGlobalSearch($('#modalgrid'))
      },
    })
    .customPager()
    /* Append clear filter button */
    loadClearFilter($('#modalgrid'))
    
    /* Append global search */
    loadGlobalSearch($('#modalgrid'))
  }

  function getInvoice(dari,sampai){
    $.ajax({
      url: `${apiUrl}pengeluarantruckingheader/getinvoice`,
      method: 'GET',
      dataType: 'JSON',
      data: {
        tgldari : dari,
        tglsampai : sampai,
        limit: 0
      },
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        resetGrid()
        let totalNominal = 0
        $.each(response.data, (index, detail) => {
          let id = detail.id
          let detailRow = $(`
          <div id="detail_row_${detail.id_detail}">
          <input type="text" value="${detail.id_detail}"  id="id_detail${detail.id_detail}" class="" name="id_detail[]"  readonly disabled  >
          <input type="text" value="${detail.container_detail}"  id="container_detail${detail.id_detail}" class="" name="container_detail[]"  readonly disabled  >
          <input type="text" value="${detail.noinvoice_detail}"  id="noinvoice_detail${detail.id_detail}" class="" name="noinvoice_detail[]"  readonly disabled  >
          <input type="text" value="${detail.nominal_detail}"  id="nominal${detail.id_detail}" class="" name="nominal[]"  readonly disabled  >
          <input type="text" value="${detail.nojobtrucking_detail}"  id="nojobtrucking_detail${detail.id_detail}" class="" name="nojobtrucking_detail[]"  readonly disabled  >
          </div>
          
          `)
          $('#detail-list-grid').append(detailRow)

        })

        $('#modalgrid').setGridParam({
          datatype: "local",
          data:response.data
        }).trigger('reloadGrid')
        // console.log(response.data);
      }
    })
    // console.log(dari, sampai);
  }
  function resetGrid() {
    $('#detail-list-grid').html('');
    $('#modalgrid').jqGrid('clearGridData')
  }
  function deleteRow(row) {
    row.remove()

    setRowNumbers()
    setTotal()
  }

  function setRowNumbers() {
    let elements = $('#detailList tbody tr td:nth-child(1)')

    elements.each((index, element) => {
      $(element).text(index + 1)
    })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}pengeluarantruckingheader/field_length`,
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

  function initLookup() {

    $('.pengeluarantrucking-lookup').lookup({
      title: 'Pengeluaran Trucking Lookup',
      fileName: 'pengeluarantrucking',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (pengeluarantrucking, element) => {
        setKodePengeluaran(pengeluarantrucking.kodepengeluaran)
        if (pengeluarantrucking.kodepengeluaran == "TDE") {
          deleteRow($('#table_body tr')[0]);
        }
        $('#crudForm [name=coa]').first().val(pengeluarantrucking.coapostingdebet)
        $('#crudForm [name=pengeluarantrucking_id]').first().val(pengeluarantrucking.id)
        element.val(pengeluarantrucking.keterangan)
        element.data('currentValue', element.val())
        getDeposito()
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        KodePengeluaranId=""
        $('#crudForm [name=pengeluarantrucking_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.bank-lookup').lookup({
      title: 'Bank Lookup',
      fileName: 'bank',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
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
    $('.supirheader-lookup').last().lookup({
      title: 'Supir Lookup',
      fileName: 'supir',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (supir, element) => {
        $(`#supirHaeaderId`).val(supir.id)
        element.val(supir.namasupir)
        element.data('currentValue', element.val())
        getDeposito()
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $(`#supirHaeaderId`).val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.pengeluaran-lookup').lookup({
      title: 'Pengeluaran Lookup',
      fileName: 'pengeluaranheader',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (pengeluaranheader, element) => {
        element.val(pengeluaranheader.nobukti)
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

    $('.akunpusat-lookup').lookup({
      title: 'Kode Perk. Lookup',
      fileName: 'akunpusat',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {
          levelCoa: '3',
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (akunpusat, element) => {
        $('#crudForm [name=coa]').first().val(akunpusat.coa)
        element.val(akunpusat.keterangancoa)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=coa]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
  }
</script>
@endpush()