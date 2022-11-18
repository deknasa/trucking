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
                <div class="input-group">
                  <input type="text" name="tglbukti" class="form-control datepicker">
                </div>
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
                  COA <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-8 col-md-10">
                <input type="text" name="coa" class="form-control coa-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  Supplier <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-8 col-md-10">
                <input type="hidden" name="supplier_id">
                <input type="text" name="supplier" class="form-control supplier-lookup">
              </div>
            </div>

            <div class="row mt-5">
              <div class="col-md-12">
                <div class="card">
                  <div class="card-body">
                    <div class="table-responsive">
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
                            <th width="4%">ALAT BAYAR</th>
                            <th width="4%">TGL CAIR</th>
                          </tr>
                        </thead>
                          <tbody id="table_body">

                          </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="4"></td>
                            <td><p id="nominalHutang" class="text-right font-weight-bold"></p></td>
                            <td><p id="sisaHutang" class="text-right font-weight-bold"></p></td>
                            <td></td>
                            <td><p id="bayarHutang" class="text-right font-weight-bold"></p></td>
                            <td><p id="potonganHutang" class="text-right font-weight-bold"></p></td>
                            <td><p id="totalHutang" class="text-right font-weight-bold"></p></td>
                            <td></td>
                            <td></td>
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

    $(document).on('input', `#table_body [name="bayar[]"]`, function(event) {
      setBayar()
      let sisa = AutoNumeric.getNumber($(this).closest("tr").find(`[name="sisa[]"]`)[0])

      let bayar = $(this).val()
      bayar = parseFloat(bayar.replaceAll(',',''));
      bayar =  Number.isNaN(bayar) ? 0 : bayar

      console.log(sisa)
      console.log(bayar)

      if(sisa == 0) {
        let nominal = $(this).closest("tr").find(`[name="nominal[]"]`).val()
        nominal = parseFloat(nominal.replaceAll(',',''));
        let totalSisa = nominal-bayar
        console.log(totalSisa)
        $(this).closest("tr").find(".sisa").html(totalSisa)
      } else {
        let totalSisa = sisa-bayar
        $(this).closest("tr").find(".sisa").html(totalSisa)
      }
      
      
      initAutoNumeric($(this).closest("tr").find(".sisa"))

      let Sisa = $(`#table_body .sisa`)
      let total = 0

      $.each(Sisa, (index, SISA) => {
        total += AutoNumeric.getNumber(SISA)
      });

      new AutoNumeric('#sisaHutang').set(total)

      // get potongan for total
      let potongan = AutoNumeric.getNumber($(this).closest("tr").find(`[name="potongan[]"]`)[0])
      let totalHutang = bayar-potongan
      $(this).closest("tr").find(`[name="total[]"]`).val(totalHutang)
      
      initAutoNumeric($(this).closest("tr").find(`[name="total[]"]`))

      let Total = $(`#table_body [name="total[]"]`)
      let gt = 0

      $.each(Total, (index, ttl) => {
        gt += AutoNumeric.getNumber(ttl)
      });
      
      new AutoNumeric('#totalHutang').set(gt)
    })

    $(document).on('input', `#table_body [name="potongan[]"]`, function(event) {
      setPotongan()
      let bayar = AutoNumeric.getNumber($(this).closest("tr").find(`[name="bayar[]"]`)[0])
      let potongan = $(this).val()
      potongan =  parseFloat(potongan.replaceAll(',',''));
      potongan =  Number.isNaN(potongan) ? 0 : potongan

      let total = bayar-potongan
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
        name: 'coa',
        value: form.find(`[name="coa"]`).val()
      })
      data.push({
        name: 'supplier_id',
        value: form.find(`[name="supplier_id"]`).val()
      })


      $('#table_body tr').each(function(row, tr){ 
        // console.log(row);
        
        if($(this).find(`[name="hutang_id[]"]`).is(':checked')) {

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
            name: 'alatbayar_id[]',
            value: $(this).find(`[name="alatbayar_id[]"]`).val()
          })
          data.push({
            name: 'tglcair[]',
            value: $(this).find(`[name="tglcair[]"]`).val()
          })
          data.push({
            name: 'hutang_id[]',
            value: $(this).find(`[name="hutang_id[]"]`).val()
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
          url = `${apiUrl}hutangbayarheader/${Id}`
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
          $('#jqGrid').jqGrid('setGridParam', { page: response.data.page}).trigger('reloadGrid');
         
          $('#detailList tbody').html('')
          $('#nominalHutang').html('')
          $('#sisaHutang').html('')

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

  function setPotongan() {
    let potongan = $(`#table_body [name="potongan[]"]:not([disabled])`)
    let totalPotongan = 0

    $.each(potongan, (index, potongan) => {
      totalPotongan += AutoNumeric.getNumber(potongan)
    });

    new AutoNumeric('#potonganHutang').set(totalPotongan)
  }

  function setTotal() {
    let total = $(`#table_body [name="total[]"]:not([disabled])`)
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

    // $('#gridEditPiutang').jqGrid('clearGridData')
    // $('#editpiutang').hide()

    form.data('action', 'add')
    $('#crudModalTitle').text('Add Pembayaran Hutang')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

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

           if(element.hasClass('datepicker')){
              element.val(dateFormat(value))
          }

          
          if(index == 'bank') {
            element.data('current-value', value)
          }
          if(index == 'supplier') {
            element.data('current-value', value)
          }
          if(index == 'coa') {
            element.data('current-value', value)
          }
        })
        

        let supplierId = response.data.supplier_id

        getPembayaran(Id, supplierId, 'edit')
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
          
           if(element.hasClass('datepicker')){
              element.val(dateFormat(value))
          }

        })
        let supplierId = response.data.supplier_id

        form.find('[name]').addClass('disabled')
        initDisabled()
        getPembayaran(Id, supplierId, 'delete')
        
      }
    })
  }

  // $(window).on("load", function() {
  //   var $grid = $("#gridPiutang"),
  //     newWidth = $grid.closest(".ui-jqgrid").parent().width();
  //   $grid.jqGrid("setGridWidth", newWidth, true);
  // });

  function getHutang(id) {
    
    $('#detailList tbody').html('')
    $('#detailList tfoot #nominalHutang').html('')
    $('#detailList tfoot #sisaHutang').html('')

    $.ajax({
      url: `${apiUrl}hutangbayarheader/${id}/getHutang`,
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
          totalNominal = parseFloat(totalNominal) + parseFloat(detail.total)
          totalSisa = totalSisa + parseFloat(detail.sisa);
          let nominal = new Intl.NumberFormat('en-US').format(detail.total);
          let sisa = new Intl.NumberFormat('en-US').format(detail.sisa);

          let detailRow = $(`
            <tr >
              <td><input name='hutang_id[]' type="checkbox" id="checkItem" value="${id}"></td>
              <td></td>
              <td>${detail.nobukti}</td>
              <td>${detail.tglbukti}</td>
              <td>
                <p class="text-right">${nominal}</p>
                <input type="hidden" name="nominal[]" class="autonumeric" value="${nominal}">
              </td>
              <td>
                <p class="text-right sisa autonumeric">${sisa}</p>
                <input type="hidden" name="sisa[]" class="autonumeric" value="${sisa}">
              </td>
              <td>
                <textarea name="keterangandetail[]" rows="1" disabled class="form-control"></textarea>
              </td>
              <td>
                <input type="text" name="bayar[]" disabled class="form-control bayar autonumeric">
              </td>
              <td>
                <input type="text" name="potongan[]" disabled class="form-control autonumeric">
              </td>
              <td>
                <input type="text" name="total[]" disabled class="form-control autonumeric">
              </td>
              <td>
                <input type="hidden" name="alatbayar_id[]" disabled class="form-control">
                <input type="text" name="alatbayar[]" disabled class="form-control alatbayar-lookup">
              </td>
              <td>
                <div class="input-group">
                  <input type="text" name="tglcair[]" disabled class="form-control datepicker">
                </div>
              </td>
            </tr>
          `)

          // detailRow.find(`[name="keterangan_detail[]"]`).val(detail.keterangan)
          // detailRow.find(`[name="nominal[]"]`).val(detail.nominal)

          initAutoNumericNoMinus(detailRow.find(`[name="bayar[]"]`))
          initAutoNumericNoMinus(detailRow.find(`[name="potongan[]"]`))
          initAutoNumericNoMinus(detailRow.find(`[name="total[]"]`))
          initAutoNumeric(detailRow.find(`[name="sisa[]"]`))
          initAutoNumeric(detailRow.find('.sisa'))
          initAutoNumeric(detailRow.find('.nominal'))

          $('#detailList tbody').append(detailRow)
          setTotal()
          initDatepicker()
          $('.alatbayar-lookup').last().lookup({
            title: 'Alat Bayar Lookup',
            fileName: 'alatbayar',
            onSelectRow: (alatbayar, element) => {
                element.parents('td').find(`[name="alatbayar_id[]"]`).val(alatbayar.id)
                element.val(alatbayar.namaalatbayar)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            }
          })
          
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


  function getPembayaran(id, supplierId, aksi) {
    $('#detailList tbody').html('')
    let url
    let attribut
    let forCheckbox
    let forTotal = 'disabled'
    // if(aksi == 'edit'){
      url = `${apiUrl}hutangbayarheader/${id}/${supplierId}/getPembayaran`
    // }
    if(aksi == 'delete'){ 
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

          if(hutangbayarId != null) {
            checked = 'checked'
          }else{
            attribut = 'disabled'
          }

          let detailRow = $(`
            <tr>
              <td><input name='hutang_id[]' type="checkbox" class="checkItem" value="${id}" ${checked} ${forCheckbox}></td>
              <td></td>
              <td>${detail.hutang_nobukti}</td>
              <td>${detail.tglbukti}</td>
              
              <td>
                <p class="text-right">${nominal}</p>
                <input type="hidden" name="nominal[]" class="autonumeric" value="${nominal}">
              </td>
              <td>
                <p class="sisa text-right autonumeric">${sisa}</p>
                <input type="hidden" name="sisa[]" class="autonumeric" value="${sisaHidden}">
              </td>
              <td>
                <textarea name="keterangandetail[]" rows="1" class="form-control" ${attribut}>${detail.keterangan || ''}</textarea>
              </td>
              <td>
                <input type="text" name="bayar[]" class="form-control bayar autonumeric" value="${detail.bayar || ''}" ${attribut}>
              </td>
              <td>
                <input type="text" name="potongan[]" class="form-control autonumeric" value="${detail.potongan || ''}" ${attribut}>
              </td>
              <td>
                <input type="text" name="total[]" class="form-control disabled autonumeric" value="${total || ''}" ${forTotal}>
              </td>
              <td>
                <input type="hidden" name="alatbayar_id[]" class="form-control" value="${detail.alatbayar_id || ''}" ${attribut}>
                <input type="text" name="alatbayar[]" class="form-control alatbayar-lookup" value="${detail.alatbayar || ''}" ${attribut}>
              </td>
              <td>
                <div class="input-group">
                  <input type="text" name="tglcair[]" class="form-control datepicker" value="${detail.tglcair || ''}" ${attribut}>
                </div>
              </td>
            </tr>
          `)

          initAutoNumericNoMinus(detailRow.find(`[name="bayar[]"]`))
          initAutoNumericNoMinus(detailRow.find(`[name="potongan[]"]`))
          initAutoNumericNoMinus(detailRow.find(`[name="total[]"]`))
          initAutoNumeric(detailRow.find(`[name="nominal[]"]`))
          initAutoNumeric(detailRow.find(`[name="sisa[]"]`))
          initAutoNumeric(detailRow.find('.sisa'))
          initAutoNumeric(detailRow.find('.nominal'))

          if (detailRow.find(`[name="tglcair[]"]`).val() != '') {
               detailRow.find(`[name="tglcair[]"]`).val(dateFormat(detail.tglcair))
          }
          $('#detailList tbody').append(detailRow)      
          setBayar()
          setPotongan()
          setTotal()
          initDatepicker()
          $('.alatbayar-lookup').last().lookup({
            title: 'Alat Bayar Lookup',
            fileName: 'alatbayar',
            onSelectRow: (alatbayar, element) => {
                element.parents('td').find(`[name="alatbayar_id[]"]`).val(alatbayar.id)
                element.val(alatbayar.namaalatbayar)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            }
          })
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
         $(this).closest('tr').find(`td [name="alatbayar[]"]`).prop('disabled', false)
         $(this).closest('tr').find(`td [name="tglcair[]"]`).prop('disabled', false)
        setBayar()
        setPotongan()
        setTotal()
      }else{

         $(this).closest('tr').find(`td [name="keterangandetail[]"]`).prop('disabled', true)
         $(this).closest('tr').find(`td [name="bayar[]"]`).prop('disabled', true)
         $(this).closest('tr').find(`td [name="potongan[]"]`).prop('disabled', true)
         $(this).closest('tr').find(`td [name="alatbayar[]"]`).prop('disabled', true)
         $(this).closest('tr').find(`td [name="tglcair[]"]`).prop('disabled', true)
        setBayar()
        setPotongan()
        setTotal()
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
    $('.coa-lookup').lookup({
      title: 'COA Lookup',
      fileName: 'akunpusat',
      onSelectRow: (coa, element) => {
        element.val(coa.coa)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
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
      }
    })
    $('.supplier-lookup').lookup({
      title: 'Supplier Lookup',
      fileName: 'supplier',
      onSelectRow: (supplier, element) => {
        $('#crudForm [name=supplier_id]').first().val(supplier.id)
        element.val(supplier.namasupplier) 
        getHutang(supplier.id)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      }
    })
  }
</script>
@endpush()