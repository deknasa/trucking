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

                    <table class="table table-responsive table-borderd mt-3" id="detailList">
                      <thead class="table-secondary">
                        <tr>
                          <th><input type="checkbox" id="checkAll"> </th>
                          <th>NO</th>
                          <th>NO BUKTI</th>
                          <th>TGL BUKTI</th>
                          <th>NO BUKTI INVOICE</th>
                          <th>NOMINAL PIUTANG</th>
                          <th>SISA</th>
                          <th>KETERANGAN</th>
                          <th>BAYAR</th>
                          <th>KETERANGAN PENYESUAIAN</th>
                          <th>PENYESUAIAN</th>
                          <th>NOMINAL LEBIH BAYAR</th>
                        </tr>
                      </thead>
                        <tbody id="bodyList">

                        </tbody>
                      <tfoot>
                        <tr>
                          <td colspan="3"></td>
                          <td>
                            <!-- <button type="button" class="btn btn-primary btn-sm my-2" id="addRow">Tambah</button> -->
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

  $(document).ready(function() {

    $('#btnBatal').click(function(event) {
      $('#detailList tbody').html('')


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


      $('#bodyList tr').each(function(row, tr){ 
        // console.log(row);
        
        if($(this).find(`[name="piutang_id[]"]`).is(':checked')) {

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
          $('#crudModal').modal('hide')
          $('#crudModal').find('#crudForm').trigger('reset')
          $('#piutangrow').html('')
          $('#jqGrid').jqGrid('setGridParam', { page: response.data.page}).trigger('reloadGrid');
         
          $('#detailList tbody').html('')


          if (response.data.grp == 'FORMAT') {
            updateFormat(response.data)
          }
        },
        error: error => {
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()


            // setErrorMessages(form, error.responseJSON.errors);
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

  function createPelunasanPiutangHeader() {
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)

    // $('#gridEditPiutang').jqGrid('clearGridData')
    // $('#editpiutang').hide()

    form.data('action', 'add')
    $('#crudModalTitle').text('Add Pelunasan Piutang')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
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
          form.find(`[name="${index}"]`).val(value).attr('disabled', false)
        })
        
        let ft = dateFormat(tgl)
        form.find(`[name="tglbukti"]`).val(ft)

        $.each(response.detail, (index, value) => {
          form.find(`[name="${index}"]`).val(value).attr('disabled', false)
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
          form.find(`[name="${index}"]`).val(value).attr('disabled', true)
        })
        $.each(response.detail, (index, value) => {
          form.find(`[name="${index}"]`).val(value).attr('disabled', true)
        })
        let agenId = response.detail.agendetail_id

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
       

        $.each(response.data, (index, detail) => {
          let no = 1;
          let id = detail.id
          let nominal = new Intl.NumberFormat('en-US').format(detail.nominal);
          let sisa = new Intl.NumberFormat('en-US').format(detail.sisa);

         
          let detailRow = $(`
            <tr onclick="select(this)">
              <td><input name='piutang_id[]' type="checkbox" id="checkItem" value="${id}"></td>
              <td></td>
              <td width="10%">${detail.nobukti}</td>
              <td width="10%">${detail.tglbukti}</td>
              <td width="10%">${detail.invoice_nobukti}</td>
              <td width="10%">${nominal}</p></td>
              <td width="10%">${sisa}</td>
              <td width="10%">
                <input type="text" name="keterangandetailppd[]" class="form-control">
              </td>
              <td width="10%">
                <input type="text" name="bayarppd[]" class="form-control autonumeric">
              </td>
              <td width="10%">
                <input type="text" name="keteranganpenyesuaianppd[]" class="form-control">
              </td>
              <td width="10%">
                <input type="text" name="penyesuaianppd[]" class="form-control autonumeric">
              </td>
              <td width="10%">
                <input type="text" name="nominallebihbayarppd[]" class="form-control autonumeric">
              </td>
            </tr>
          `)

          // detailRow.find(`[name="keterangan_detail[]"]`).val(detail.keterangan)
          // detailRow.find(`[name="nominal[]"]`).val(detail.nominal)

          initAutoNumericNoMinus(detailRow.find(`[name="bayarppd[]"]`))
          initAutoNumericNoMinus(detailRow.find(`[name="penyesuaianppd[]"]`))
          initAutoNumericNoMinus(detailRow.find(`[name="nominallebihbayarppd[]"]`))
          //untuk unformat
          // input.value = AutoNumeric.getNumber(autoNumericElement);
          $('#detailList tbody').append(detailRow)
          no++
        })

        setRowNumbers()
      }
    }) 

   
  }


  function getPelunasan(id, agenId, aksi) {
    $('#detailList tbody').html('')
    let url
    let attribut
    if(aksi == 'edit'){
      
      url = `${apiUrl}pelunasanpiutangheader/${id}/${agenId}/getPelunasanPiutang`
    }
    if(aksi == 'delete'){ 
      
      url = `${apiUrl}pelunasanpiutangheader/${id}/${agenId}/getDeletePelunasanPiutang`
      attribut = 'disabled'
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
       

        $.each(response.data, (index, detail) => {
          
          let id = detail.id
          let pelunasanPiutangId = detail.pelunasanpiutang_id
          let checked
          
          let nominal = new Intl.NumberFormat('en-US').format(detail.nominalpiutang);
          let sisa = new Intl.NumberFormat('en-US').format(detail.sisa);
         
          if(pelunasanPiutangId != null) {
            checked = 'checked'
          }

          let detailRow = $(`
            <tr onclick="select(this)">
              <td><input name='piutang_id[]' type="checkbox" class="checkItem" value="${id}" ${checked} ${attribut}></td>
              <td></td>
              <td width="10%">${detail.piutang_nobukti}</td>
              <td width="10%">${detail.tglbukti}</td>
              <td width="10%">${detail.invoice_nobukti}</td>
              <td width="10%">${nominal}</p></td>
              <td width="10%">${sisa}</td>
              <td>
                <input type="text" name="keterangandetailppd[]" class="form-control" value="${detail.keterangan || ''}" ${attribut}>
              </td>
              <td>
                <input type="text" name="bayarppd[]" class="form-control autonumeric" value="${detail.nominal || ''}" ${attribut}>
              </td>
              <td>
                <input type="text" name="keteranganpenyesuaianppd[]" class="form-control" value="${detail.keteranganpenyesuaian || ''}" ${attribut}>
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
          $('#detailList tbody').append(detailRow)          
        })

        setRowNumbers()
        
      }
    }) 
    
  }

  function select(element) {
      $(element).find(`[name="piutang_id[]"]`).attr('checked', true)
      // $(element).style.backgroundColor = "green"
  }
  
  function setRowNumbers() {
    let elements = $('#detailList tbody tr td:nth-child(2)')

    elements.each((index, element) => {
      $(element).text(index + 1)
    })
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
</script>
@endpush()