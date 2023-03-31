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
                  KODE PENERIMAAN <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="penerimaantrucking_id">
                <input type="text" name="penerimaantrucking" class="form-control penerimaantrucking-lookup">
              </div>
            </div>

            <div class="row form-group" style="display:none;">
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
                  NAMA PERKIRAAN <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="coa">
                <input type="text" name="keterangancoa" class="form-control akunpusat-lookup">
              </div>
            </div>

            <div class="border p-3">
              <h6>Posting Penerimaan</h6>

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
                  <input type="text" name="penerimaan_nobukti" id="penerimaan_nobukti" class="form-control" readonly>
                </div>
              </div>
            </div>
            
            <div class="table-scroll table-responsive">
              <table class="table table-bordered table-bindkeys mt-3" id="detailList" style="width: 1000px;">
                <thead>
                  <tr>
                    <th width="1%" class="">No</th>
                    <th class="data_tbl tbl_checkbox" style="display:none" width="1%">Pilih</th>
                    <th width="20%" class="tbl_supir_id">SUPIR</th>
                    <th width="15%" class="tbl_pengeluarantruckingheader_nobukti">NO BUKTI PENGELUARAN TRUCKING</th>
                    <th width="14%" class="tbl_sisa">Sisa</th>
                    <th width="25%" class="tbl_keterangan">Keterangan</th>
                    <th width="20%" class="tbl_nominal">Nominal</th>
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
  var KodePenerimaanId

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
      // let sisa = AutoNumeric.getNumber($(this).closest("tr").find(`[name="sisaPP[]"]`)[0])
      // let sisaAwal = AutoNumeric.getNumber($(this).closest("tr").find(`[name="sisaAwalPP[]"]`)[0])
      // let bayar = $(this).val()
      // bayar = parseFloat(bayar.replaceAll(',', ''));
      // bayar = Number.isNaN(bayar) ? 0 : bayar
      // totalSisa = sisaAwal - bayar
      // $(this).closest("tr").find(".sisaPP").html(totalSisa)
      // $(this).closest("tr").find(`[name="sisaPP[]"]`).val(totalSisa)
     
      // initAutoNumeric($(this).closest("tr").find(".sisaPP"))
      // let Sisa = $(`#table_body .sisaPP`)
      // let total = 0
      // $.each(Sisa, (index, SISA) => {
      //     total += AutoNumeric.getNumber(SISA)
      // });
      // new AutoNumeric('#sisaFoot').set(total)


    })
      

    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      let data
      if (KodePenerimaanId === "PJP") {
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
          name: 'penerimaantrucking_id', 
          value: form.find(`[name="penerimaantrucking_id"]`).val()
        })
        data.push({
          name: 'penerimaantrucking', 
          value: form.find(`[name="penerimaantrucking"]`).val()
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
          name: 'penerimaan_nobukti', 
          value: form.find(`[name="pengeluaran_nobukti"]`).val()
        })
        $('#table_body tr').each(function(row, tr) {
          
          if ($(this).find('[name="pinjPribadi[]"]').is(':checked')) {
            data.push({
              name: 'supir_id[]',
              value: form.find(`[name="supirheader_id"]`).val()
            })
            data.push({
              name: 'pengeluarantruckingheader_nobukti[]',
              value: $(this).find(`[name="pinjPribadi_nobukti[]"]`).val()
            })
            data.push({
              name: 'keterangan[]',
              value: $(this).find(`[name="pinjPribadi_keterangan[]"]`).val()
            })
            data.push({
              name: 'nominal[]',
              value: AutoNumeric.getNumber($(`#crudForm [name="nominalPP[]"]`)[row])
            })
            
          }
          
        })
        
      }else{
        data = $('#crudForm').serializeArray()

        $('#crudForm').find(`[name="nominal[]"`).each((index, element) => {
          data.filter((row) => row.name === 'nominal[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominal[]"]`)[index])
        })
          
        // data.push({
        //   name: 'nominal[]',
        //   value: AutoNumeric.getNumber($(`#crudForm [name="nominal[]"]`)[row])
        // })
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
      console.log(data)
      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}penerimaantruckingheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}penerimaantruckingheader/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}penerimaantruckingheader/${Id}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}penerimaantruckingheader`
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
          console.log(id)
          $('#crudModal').modal('hide')
          $('#crudModal').find('#crudForm').trigger('reset')

          $('#jqGrid').jqGrid('setGridParam', {
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
  function setKodePenerimaan(kode) {
    KodePenerimaanId = kode;
    console.log(KodePenerimaanId);
    setTampilanForm();
  }

  function setTampilanForm(){
    tampilanall()
    switch (KodePenerimaanId) {
      case 'BBM':
        tampilanBBM()
        break;
      case 'PJP':
        tampilanPJP()
        break;
      default:
        tampilanall()
        break;
    }
  }
function tampilanBBM() {
  $('[name=keterangancoa]').parents('.form-group').hide()
  $('.tbl_supir_id').hide()
  $('.tbl_sisa').hide()
  $('.colmn-offset').hide()
  $('.tbl_pengeluarantruckingheader_nobukti').hide()
  $('[name=supirheader_id]').parents('.form-group').hide()
  $('.colspan').attr('colspan', 2);
  $('#sisaColFoot').hide()
  $('#sisaFoot').hide()

}
function tampilanPJP() {
  $('[name=keterangancoa]').parents('.form-group').hide()
  $('.tbl_supir_id').hide()
  $('[name=supirheader_id]').parents('.form-group').show()
  $('.tbl_checkbox').show()
  $('.tbl_sisa').show()

  $('.colspan').attr('colspan', 3);
  $('#sisaColFoot').show()
  $('#sisaFoot').show()
  
  $('.tbl_aksi').hide()
  $('#tbl_addRow').hide()
}
function tampilanall() {
  $('[name=keterangancoa]').parents('.form-group').show()
  $('.tbl_supir_id').show()
  $('.tbl_sisa').hide()
  $('.tbl_pengeluarantruckingheader_nobukti').show()
  $('[name=supirheader_id]').parents('.form-group').hide()
  $('.colspan').attr('colspan', 3);
  $('#sisaColFoot').hide()
  $('#sisaFoot').hide()
  $('.colmn-offset').show()

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

    $('#crudModal').find('.modal-body').html(modalBody)
  })

  function setTotal() {
    let nominalDetails = $(`#table_body [name="nominal[]"]`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#total').set(total)
  }

  function createPenerimaanTruckingHeader() {
    let form = $('#crudForm')

    $('#crudModal').find('#crudForm').trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
    form.data('action', 'add')

    $('#crudModalTitle').text('Add Penerimaan Trucking')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()


    $('#table_body').html('')
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    addRow()
    setTotal()
  }

  function editPenerimaanTruckingHeader(id) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
    $('#crudModalTitle').text('Edit Penerimaan Truck')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    form.find(`[name="bank"]`).removeClass('bank-lookup')
    form.find(`[name="penerimaantrucking"]`).removeClass('penerimaantrucking-lookup')
    showPenerimaanTruckingHeader(form, id)

  }

  function deletePenerimaanTruckingHeader(id) {

    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Hapus
    `)
    $('#crudModalTitle').text('Delete Penerimaan Truck')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    form.find(`[name="bank"]`).removeClass('bank-lookup')
    form.find(`[name="penerimaantrucking"]`).removeClass('penerimaantrucking-lookup')
    showPenerimaanTruckingHeader(form, id)

  }

  function cekValidasi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}penerimaantruckingheader/${Id}/cekvalidasi`,
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
            cekValidasiAksi(Id,Aksi)
          }

        } else {
          showDialog(response.message['keterangan'])
        }
      }
    })
  }
  
  function cekValidasiAksi(Id,Aksi){
    $.ajax({
      url: `{{ config('app.api_url') }}penerimaantruckingheader/${Id}/cekValidasiAksi`,
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
              editPenerimaanTruckingHeader(Id)
            }
            if (Aksi == 'DELETE') {
              deletePenerimaanTruckingHeader(Id)
            }
          }

      }
    })
  }

  function showPenerimaanTruckingHeader(form, id) {
    $('#detailList tbody').html('')

    $.ajax({
      url: `${apiUrl}penerimaantruckingheader/${id}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        let tgl = response.data.tglbukti
        let kodepenerimaan = response.data.kodepenerimaan

        $.each(response.data, (index, value) => {
          let element = form.find(`[name="${index}"]`)
          if (element.hasClass('datepicker')) {
            element.val(dateFormat(value))
          } else {
            element.val(value)
          }

          if (index == 'penerimaantrucking') {
            element.data('current-value', value).prop('readonly', true)
          }
          if (index == 'bank') {
            element.data('current-value', value).prop('readonly', true)
          }
          if (index == 'keterangancoa') {
            element.data('current-value', value)
          }
        })
        
        if (kodepenerimaan === "PJP") {
          getPengembalianPinjaman(id)
        }else{
          $.each(response.detail, (index, detail) => {
            let detailRow = $(`
              <tr>
                  <td></td>
                  <td class="tbl_supir_id">
                      <input type="hidden" name="supir_id[]">
                      <input type="text" name="supir[]" data-current-value="${detail.supir}" class="form-control supir-lookup">
                  </td>
                  <td class="tbl_pengeluarantruckingheader_nobukti">
                      <input type="text" name="pengeluarantruckingheader_nobukti[]" data-current-value="${detail.pengeluarantruckingheader_nobukti}" class="form-control pengeluarantruckingheader-lookup">
                  </td>
                  <td class="tbl_keterangan">
                      <input type="text" name="keterangan[]" class="form-control"> 
                  </td>
                  <td class="tbl_nominal">
                      <input type="text" name="nominal[]" class="form-control autonumeric nominal"> 
                  </td>
                  <td>
                      <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
                  </td>
              </tr>
            `)

            detailRow.find(`[name="supir_id[]"]`).val(detail.supir_id)
            detailRow.find(`[name="supir[]"]`).val(detail.supir)
            detailRow.find(`[name="pengeluarantruckingheader_nobukti[]"]`).val(detail.pengeluarantruckingheader_nobukti)
            detailRow.find(`[name="keterangan[]"]`).val(detail.keterangan)
            detailRow.find(`[name="nominal[]"]`).val(detail.nominal)

            initAutoNumeric(detailRow.find(`[name="nominal[]"]`))
            $('#detailList tbody').append(detailRow)

            setTotal();

            $('.supir-lookup').last().lookup({
              title: 'Supir Lookup',
              fileName: 'supir',
              beforeProcess: function(test) {
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
                element.val('')
                element.parents('td').find(`[name="supir_id[]"]`).val('')
                element.data('currentValue', element.val())
              }
            })

            $('.pengeluarantruckingheader-lookup').last().lookup({
              title: 'Pengeluaran Trucking Lookup',
              fileName: 'pengeluarantruckingheader',
              beforeProcess: function(test) {
                this.postData = {
                  Aktif: 'AKTIF',

                }
              },
              onSelectRow: (pengeluarantruckingheader, element) => {
                element.val(pengeluarantruckingheader.nobukti)
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
        KodePenerimaanId = kodepenerimaan
        setRowNumbers()
        if (form.data('action') === 'delete') {
          form.find('[name]').addClass('disabled')
          initDisabled()
        }
        setKodePenerimaan(response.data.penerimaantrucking);

      }
    })
  }

  function getPinjaman() {
    let supirId = $('#supirHaeaderId').val();
    KodePenerimaanId

    let data = {
      "supir":supirId,
    }
    console.log((supirId != ""));
    if ((KodePenerimaanId === "PJP") && (supirId != "")) {
      $.ajax({
        url: `${apiUrl}gajisupirheader/${supirId}/getpinjpribadi`,
        method: 'GET',
        dataType: 'JSON',
        data: {
            limit: 0
        },
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
                    <p class="text-right sisaPP autonumeric">${sisa}</p>
                    <input type="hidden" name="sisaPP[]" class="autonumeric" value="${sisa}">
                    <input type="hidden" name="sisaAwalPP[]" class="autonumeric" value="${sisa}">
                </td>
                <td id=${id}>
                    <input type="text" name="nominalPP[]" disabled class="form-control bayar text-right">
                </td>
                <td>
                    ${detail.keterangan}
                    <input name='pinjPribadi_keterangan[]' type="hidden" value="${detail.keterangan}">
                </td>
                </tr>
            `)

            initAutoNumeric(detailRow.find(`[name="sisaPP[]"]`))
            initAutoNumeric(detailRow.find(`[name="sisaAwalPP[]"]`))
            initAutoNumeric(detailRow.find(`.sisaPP`))

            $('#detailList tbody').append(detailRow)
            setTotalPP()
          })
          setTampilanForm()
          $(`#detailList tfoot`).show()

        }
      })
    }
  }

  function setTotalPP() {
    let nominalDetails = $(`#table_body [name="nominalPP[]"]:not([disabled])`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
        total += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#total').set(total)
    
  }
    
  $(document).on('click', `#detailList tbody [name="pinjPribadi[]"]`, function() {

    if ($(this).prop("checked") == true) {
      $(this).closest('tr').find(`td [name="nominalPP[]"]`).prop('disabled', false)
      let sisa = AutoNumeric.getNumber($(this).closest('tr').find(`td [name="sisaPP[]"]`)[0])
      initAutoNumeric($(this).closest('tr').find(`td [name="nominalPP[]"]`))

      // initAutoNumeric($(this).closest('tr').find(`td [name="nominalPP[]"]`).val(sisa))
      // let bayar = AutoNumeric.getNumber($(this).closest('tr').find(`td [name="nominalPP[]"]`)[0])
      // let totalSisa = sisa - bayar

      // $(this).closest("tr").find(".sisaPP").html(totalSisa)
      // $(this).closest("tr").find(`[name="sisaPP[]"]`).val(totalSisa)
      // initAutoNumeric($(this).closest("tr").find(".sisaPP"))
      setTotalPP()
      setSisaPP()
    } else {
      let id = $(this).val()
      $(this).closest('tr').find(`td [name="nominalPP[]"]`).remove();
      let newBayarElement = `<input type="text" name="nominalPP[]" class="form-control text-right" disabled>`
      $(this).closest('tr').find(`#${id}`).append(newBayarElement)
      
      let sisa = AutoNumeric.getNumber($(this).closest('tr').find(`td [name="sisaAwalPP[]"]`)[0])

      initAutoNumeric($(this).closest('tr').find(`td [name="sisaPP[]"]`).val(sisa))
      $(this).closest("tr").find(".sisaPP").html(sisa)
      initAutoNumeric($(this).closest("tr").find(".sisaPP"))

      setTotalPP()
      setSisaPP()
    }
  })
      
  $(document).on('input', `#table_body [name="nominalPP[]"]`, function(event) {
    setTotalPP()
    setSisaDetail(this)
  })

  function setSisaDetail(el){
    let sisa = AutoNumeric.getNumber($(el).closest("tr").find(`[name="sisaPP[]"]`)[0])
    let sisaAwal = AutoNumeric.getNumber($(el).closest("tr").find(`[name="sisaAwalPP[]"]`)[0])
    let bayar = $(el).val()
    bayar = parseFloat(bayar.replaceAll(',', ''));
    console.log( sisaAwal , bayar );
    bayar = Number.isNaN(bayar) ? 0 : bayar
    totalSisa = sisaAwal - bayar
    $(el).closest("tr").find(".sisaPP").html(totalSisa)
    $(el).closest("tr").find(`[name="sisaPP[]"]`).val(totalSisa)
    initAutoNumeric($(el).closest("tr").find(".sisaPP"))
    let Sisa = $(`#table_body .sisaPP`)
    let total = 0
  
    $.each(Sisa, (index, SISA) => {
        total += AutoNumeric.getNumber(SISA)
    });
    new AutoNumeric('#sisaFoot').set(total)
  }

  function setSisaPP() {
    let nominalDetails = $(`.sisaPP`)
    let bayar = 0
    $.each(nominalDetails, (index, nominalDetail) => {
        bayar += AutoNumeric.getNumber(nominalDetail)
    });
  
    new AutoNumeric('#sisaFoot').set(bayar)
  }

  function addRow() {
    let detailRow = $(`
      <tr>
        <td></td>
        <td class="tbl_supir_id">
          <input type="hidden" name="supir_id[]">
          <input type="text" name="supir[]"  class="form-control supir-lookup">
        </td>
        <td class="tbl_pengeluarantruckingheader_nobukti">
          <input type="text" name="pengeluarantruckingheader_nobukti[]"  class="form-control pengeluarantruckingheader-lookup">
        </td>
        <td class="tbl_keterangan">
          <input type="text" name="keterangan[]" class="form-control"> 
        </td>
        <td class="tbl_nominal">
          <input type="text" name="nominal[]" class="form-control autonumeric nominal"> 
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
        this.postData = {
          Aktif: 'AKTIF',

        }
      },
      onSelectRow: (supir, element) => {
        $(`#crudForm [name="supir_id[]"]`).last().val(supir.id)
        element.val(supir.namasupir)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        $(`#crudForm [name="supir_id[]"]`).last().val('')
        element.data('currentValue', element.val())
      }
    })
    $('.pengeluarantruckingheader-lookup').last().lookup({
      title: 'Pengeluaran Trucking Lookup',
      fileName: 'pengeluarantruckingheader',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',

        }
      },
      onSelectRow: (pengeluarantruckingheader, element) => {
        element.val(pengeluarantruckingheader.nobukti)
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

  function getPengembalianPinjaman(id) {
    $.ajax({
      url: `${apiUrl}penerimaantruckingheader/${id}/getpengembalianpinjaman`,
      method: 'GET',
      dataType: 'JSON',
      data: {
          limit: 0
      },
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
            console.log(detail.sisa)
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
                  <p class="text-right sisaPP autonumeric">${sisa}</p>
                  <input type="hidden" name="sisaPP[]" class="autonumeric" value="${sisa}">
                  <input type="hidden" name="sisaAwalPP[]" class="autonumeric" value="${sisa}">
              </td>
              <td id=${id}>
                  <input type="text" name="nominalPP[]" ${disbaled} value="${detail.bayar}" class="form-control bayar text-right">
              </td>
              <td>
                  ${detail.keterangan}
                  <input name='pinjPribadi_keterangan[]' type="hidden" value="${detail.keterangan}">
              </td>
              </tr>
          `)

          initAutoNumeric(detailRow.find(`[name="sisaPP[]"]`))
          initAutoNumeric(detailRow.find(`[name="sisaAwalPP[]"]`))
          initAutoNumeric(detailRow.find(`.sisaPP`))
          initAutoNumeric(detailRow.find(`.bayar`))
          setSisaDetail(detailRow.find(`[name="nominalPP[]"]`))
          $('#detailList tbody').append(detailRow)
          setTotalPP()
          setSisaPP()
        })
        setTampilanForm()
        $(`#detailList tfoot`).show()
      
      }

    })
      
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
        url: `${apiUrl}penerimaantruckingheader/field_length`,
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
    $('.supirheader-lookup').last().lookup({
      title: 'Supir Lookup',
      fileName: 'supir',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',

        }
      },
      onSelectRow: (supir, element) => {
        $(`#crudForm [name="supirheader_id"]`).last().val(supir.id)
        element.val(supir.namasupir)
        element.data('currentValue', element.val())
        getPinjaman()
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        $(`#crudForm [name="supir_id[]"]`).last().val('')
        element.data('currentValue', element.val())
      }
    })
    $('.penerimaantrucking-lookup').lookup({
      title: 'Penerimaan Trucking Lookup',
      fileName: 'penerimaantrucking',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',

        }
      },
      onSelectRow: (penerimaantrucking, element) => {
        setKodePenerimaan(penerimaantrucking.kodepenerimaan)
        $('#crudForm [name=penerimaantrucking_id]').first().val(penerimaantrucking.id)
        element.val(penerimaantrucking.keterangan)
        element.data('currentValue', element.val())
        getPinjaman()
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        $(`#crudForm [name="penerimaantrucking_id"]`).first().val('')
        element.data('currentValue', element.val())
      }
    })

    $('.bank-lookup').lookup({
      title: 'Bank Lookup',
      fileName: 'bank',
      beforeProcess: function(test) {
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
        element.val('')
        $(`#crudForm [name="bank_id"]`).first().val('')
        element.data('currentValue', element.val())
      }
    })

    $('.akunpusat-lookup').lookup({
      title: 'Kode Perk. Lookup',
      fileName: 'akunpusat',
      beforeProcess: function(test) {
                            this.postData = {
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