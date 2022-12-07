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
        <input type="hidden" name="id">
          <div class="modal-body">
            <div class="row">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  NO BUKTI
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" name="nobukti" class="form-control" readonly>
              </div>
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  TANGGAL BUKTI <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <div class="input-group">
                <input type="text" name="tglbukti" class="form-control datepicker">
              </div>
              </div>
            </div>

            <div class="row">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                 TANGGAL approval <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <div class="input-group">
                  <input type="text" name="tglapproval" class="form-control datepicker">

                </div>
              </div>

              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  status approval <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <select name="statusapproval" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH STATUS approval --</option>
                </select>
              </div>
            </div>

            <div class="row">

              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  TANGGAL LUNAS <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <div class="input-group">
                <input type="text" name="tgllunas" class="form-control datepicker">
              </div>
              </div>
              
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>pelunasan piutang <span class="text-danger">*</span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" name="pelunasanpiutang_nobukti" class="form-control pelunasanpiutang-lookup">
              </div>
            </div>

            <div class="row">
              
              {{-- <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>STATUS FORMAT <span class="text-danger">*</span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <select name="statusformat" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH STATUS FORMAT --</option>
                </select>
              </div> --}}

            <div class="col-12 col-sm-3 col-md-2 col-form-label">
              <label>keterangan <span class="text-danger">*</span> </label>
            </div>
            <div class="col-12 col-sm-9 col-md-4">
              <input type="text" name="keterangan" class="form-control">
            </div>
          </div>
            <div class="col-md-12" style="overflow-x:scroll">
              <table class="table table-borderd mt-3" id="detailList" style="table-layout:auto">
                <thead id="table_body" class="table-secondary">
                  <tr>
                    <th><input type="checkbox" id="checkAll"> </th>
                    <th>no</th>
                    <th>nobukti</th>
                    <th>tglcair</th>
                    <th>coapenyesuaian</th>
                    <th>nominal</th>
                    <th>nominalbayar</th>
                    <th>penyesuaian</th>
                    <th>keterangan</th>
                  </tr>
                </thead>
                  <tbody id="table_body">

                  </tbody>
                <tfoot>
                  <tr>
                    <td colspan="6"></td>
                    <td><p id="nominalPiutang" class="text-right font-weight-bold"></p></td>
                    <th></th>
                  
                   
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

  $(document).ready(function() {

    $(document).on('click', "#addRow", function() {
      addRow()
    });
    
    $(document).on('click', '.delete-row', function(event) {
      deleteRow($(this).parents('tr'))
    })

    $(document).on('input', `#table_body [name="nominal[]"]`, function(event) {
      setTotal()
    })

    $('#btnSubmit').click(function(event) {
      event.preventDefault()
      let method
      let url
      let form = $('#crudForm')
      let userId = form.find('[name=user_id]').val()
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()
      
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
      $('#table_body tr').each(function(row, tr){ 

        if($(this).find(`[name="pelunasanpiutangdetail_id[]"]`).is(':checked')) {
          data.push({
            name: 'pelunasanpiutangdetail_id[]',
            value: $(this).find(`[name="pelunasanpiutangdetail_id[]"]`).val()
          })
          data.push({
            name: 'deatail_nobukti_pelunasan[]',
            value: $(this).find(`[name="deatail_nobukti_pelunasan[]"]`).val()
          })
          
          data.push({
            name: 'deatail_tglcair_pelunasan[]',
            value: $(this).find(`[name="deatail_tglcair_pelunasan[]"]`).val()
          })
          
          data.push({
            name: 'deatail_coapenyesuaian_pelunasan[]',
            value: $(this).find(`[name="deatail_coapenyesuaian_pelunasan[]"]`).val()
          })
          
          data.push({
            name: 'deatail_nominal_pelunasan[]',
            value: $(this).find(`[name="deatail_nominal_pelunasan[]"]`).val()
          })
          
          data.push({
            name: 'deatail_nominalbayar_pelunasan[]',
            value: $(this).find(`[name="deatail_nominalbayar_pelunasan[]"]`).val()
          })
          
          data.push({
            name: 'deatail_penyesuaian_pelunasan[]',
            value: $(this).find(`[name="deatail_penyesuaian_pelunasan[]"]`).val()
          })
          
          data.push({
            name: 'deatail_invoice_nobukti_pelunasan[]',
            value: $(this).find(`[name="deatail_invoice_nobukti_pelunasan[]"]`).val()
          })
          
          data.push({
            name: 'keterangandetail[]',
            value: $(this).find(`[name="keterangandetail[]"]`).val()
          })
          
          
          
        }
      })

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}notakreditheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}notakreditheader/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}notakreditheader/${Id}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}notakreditheader`
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
          $('#crudForm').trigger('reset')
          $('#crudModal').modal('hide')

          id = response.data.id

          $('#jqGrid').jqGrid('setGridParam', { page: response.data.page}).trigger('reloadGrid');

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
    initSelect2()
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

  function createNotaKredit() {
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create Nota Kredit')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    // getKasGantung()
    // setStatusFormatListOptions(form)
    setStatusApprovalListOptions(form)

  }

  function editNotaKredit(userId) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Nota Kredit')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    
    Promise
      .all([
        // setStatusFormatListOptions(form),
        setStatusApprovalListOptions(form)
      ])
      .then(() => {
        showNotaKredit(form, userId)
      })
    
  }

  function deleteNotaKredit(userId) {
    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Nota Kredit')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    
    Promise
      .all([
        // setStatusFormatListOptions(form),
        setStatusApprovalListOptions(form)
      ])
      .then(() => {
        showNotaKredit(form, userId)
      })
  }

  function showNotaKredit(form, userId) {
    $('#detailList tbody').html('')

    $.ajax({
      url: `${apiUrl}notakreditheader/${userId}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        sum =0;
        $.each(response.data, (index, value) => {
          let element = form.find(`[name="${index}"]`)
          if(element.attr("name") == 'tglbukti'){
            var result = value.split('-');
            element.val(result[2]+'-'+result[1]+'-'+result[0]);
          } else if(element.attr("name") == 'tglapproval'){
            var result = value.split('-');
            element.val(result[2]+'-'+result[1]+'-'+result[0]);
          } else if(element.attr("name") == 'tgllunas'){
            var result = value.split('-');
            element.val(result[2]+'-'+result[1]+'-'+result[0]);
          }else if (element.is('select')) {
            element.val(value).trigger('change')
          }else  {
            element.val(value)
          }
        })
        getNotaKredit(userId)
      }
    })
  }

  function setRowNumbers() {
    let elements = $('#detailList tbody tr td:nth-child(1)')

    elements.each((index, element) => {
      $(element).text(index + 1)
    })
  }

  function getPelunasan(id) {
    
    $('#detailList tbody').html('')

    $.ajax({
      url: `${apiUrl}notakreditheader/${id}/getpelunasan`,
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
        let row = 0
        $.each(response.data, (index, detail) => {
          let id = detail.id
          row++
          let nominal = new Intl.NumberFormat('en-US').format(detail.nominal);
          totalNominal = parseFloat(totalNominal) + parseFloat(detail.nominal)
          let detailRow = $(`
          <tr>
            <td onclick="select(this)"><input name='pelunasanpiutangdetail_id[]' type="checkbox" id="checkItem" value="${detail.detail_id}"></td>
            <td>${row}</td>
            <td>
              ${detail.nobukti}
              <input type="hidden" value="${detail.nobukti}" disabled name="deatail_nobukti_pelunasan[]"  readonly>
            </td>
            <td>
              ${detail.tglcair}
              <input type="hidden" value="${detail.tglcair}" disabled name="deatail_tglcair_pelunasan[]"  readonly>
            </td>
            <td>
              ${detail.coapenyesuaian}
              <input type="hidden" value="${detail.coapenyesuaian}" disabled name="deatail_coapenyesuaian_pelunasan[]"  readonly>
            </td>
            <td>
              ${detail.nominal}
              <input type="hidden" value="${detail.nominal}" disabled name="deatail_nominal_pelunasan[]"  readonly>
            </td>
            <td>
              ${detail.nominalbayar}
              <input type="hidden" value="${detail.nominalbayar}" disabled name="deatail_nominalbayar_pelunasan[]"  readonly>
            </td>
            <td>
              ${detail.penyesuaian}
              <input type="hidden" value="${detail.penyesuaian}" disabled name="deatail_penyesuaian_pelunasan[]"  readonly>
            </td>
            
              <input type="hidden" value="${detail.invoice_nobukti}" disabled name="deatail_invoice_nobukti_pelunasan[]" readonly>
            
            <td>
              <td><textarea disabled name="keterangandetail[]" class="form-control" id=""  rows="1"></textarea></td>
            </td>
          </tr>`)
          $('#detailList tbody').append(detailRow)
          })
           totalNominal = new Intl.NumberFormat('en-US').format(totalNominal);
           $('#nominalPiutang').html(`${totalNominal}`)           
      }
    })
  }
  
  function select(element) {
    var is_checked = $(element).find(`[name="pelunasanpiutangdetail_id[]"]`).is(":checked");
    console.log(is_checked);
    
    if(!is_checked) {      
      $(element).siblings('td').find(`[name="deatail_nobukti_pelunasan[]"]`).prop('disabled', true)
      $(element).siblings('td').find(`[name="deatail_tglcair_pelunasan[]"]`).prop('disabled', true)
      $(element).siblings('td').find(`[name="deatail_coapenyesuaian_pelunasan[]"]`).prop('disabled', true)
      $(element).siblings('td').find(`[name="deatail_nominal_pelunasan[]"]`).prop('disabled', true)
      $(element).siblings('td').find(`[name="deatail_nominalbayar_pelunasan[]"]`).prop('disabled', true)
      $(element).siblings('td').find(`[name="deatail_penyesuaian_pelunasan[]"]`).prop('disabled', true)
      $(element).siblings('td').find(`[name="deatail_invoice_nobukti_pelunasan[]"]`).prop('disabled', true)
      $(element).siblings('td').find(`[name="keterangandetail[]"]`).prop('disabled', true)
    }else{
      
      $(element).siblings('td').find(`[name="deatail_nobukti_pelunasan[]"]`).prop('disabled', false)
      $(element).siblings('td').find(`[name="deatail_tglcair_pelunasan[]"]`).prop('disabled', false)
      $(element).siblings('td').find(`[name="deatail_coapenyesuaian_pelunasan[]"]`).prop('disabled', false)
      $(element).siblings('td').find(`[name="deatail_nominal_pelunasan[]"]`).prop('disabled', false)
      $(element).siblings('td').find(`[name="deatail_nominalbayar_pelunasan[]"]`).prop('disabled', false)
      $(element).siblings('td').find(`[name="deatail_penyesuaian_pelunasan[]"]`).prop('disabled', false)
      $(element).siblings('td').find(`[name="deatail_invoice_nobukti_pelunasan[]"]`).prop('disabled', false)
      $(element).siblings('td').find(`[name="keterangandetail[]"]`).prop('disabled', false)

    }
  }
    
  function getNotaKredit(id) {
    
    $('#detailList tbody').html('')

    $.ajax({
      url: `${apiUrl}notakreditheader/${id}/getnotakredit`,
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
        let row = 0
        $.each(response.data, (index, detail) => {
          let id = detail.id
          row++
          let nominal = new Intl.NumberFormat('en-US').format(detail.nominal);
          totalNominal = parseFloat(totalNominal) + parseFloat(detail.nominal)
          let detailRow = $(`
          <tr>
            <td ><input name='pelunasanpiutangdetail_id[]' checked type="checkbox" id="checkItem" value="${detail.detail_id}"></td>
            <td>${row}</td>
            <td>
              ${detail.nobukti}
              <input type="hidden" value="${detail.nobukti}" name="deatail_nobukti_pelunasan[]"  readonly>
            </td>
            <td>
              ${detail.tglcair}
              <input type="hidden" value="${detail.tglcair}" name="deatail_tglcair_pelunasan[]"  readonly>
            </td>
            <td>
              ${detail.coapenyesuaian}
              <input type="hidden" value="${detail.coapenyesuaian}" name="deatail_coapenyesuaian_pelunasan[]"  readonly>
            </td>
            <td>
              ${detail.nominal}
              <input type="hidden" value="${detail.nominal}" name="deatail_nominal_pelunasan[]"  readonly>
            </td>
            <td>
              ${detail.nominalbayar}
              <input type="hidden" value="${detail.nominalbayar}" name="deatail_nominalbayar_pelunasan[]"  readonly>
            </td>
            <td>
              ${detail.penyesuaian}
              <input type="hidden" value="${detail.penyesuaian}" name="deatail_penyesuaian_pelunasan[]"  readonly>
            </td>
            
              <input type="hidden" value="${detail.invoice_nobukti}" name="deatail_invoice_nobukti_pelunasan[]" readonly>
            
            
            <td><textarea name="keterangandetail[]" class="form-control" id=""  rows="1">${detail.keterangan}</textarea></td>
          </tr>`)
          $('#detailList tbody').append(detailRow)
          })
           totalNominal = new Intl.NumberFormat('en-US').format(totalNominal);
           $('#nominalPiutang').html(`${totalNominal}`)           
      }
    })
  }
  
  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}notakreditheader/field_length`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
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
          console.log(error);

          showDialog(error.statusText)
        }
      })
    }
  }
 
  function initLookup() {
    $('.pelunasanpiutang-lookup').lookup({
      title: 'pelunasan piutang Lookup',
      fileName: 'pelunasanpiutangheader',
      onSelectRow: (pelunasanpiutang, element) => {
        element.val(pelunasanpiutang.nobukti)
        getPelunasan(pelunasanpiutang.id)
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
  const setStatusApprovalListOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusapproval]').empty()
      relatedForm.find('[name=statusapproval]').append(
        new Option('-- PILIH STATUS Approval --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}parameter`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          limit: 0,
          filters: JSON.stringify({
            "groupOp": "AND",
            "rules": [{
              "field": "grp",
              "op": "cn",
              "data": "STATUS APPROVAL"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusApprovalList => {
            
            let option = new Option(statusApprovalList.text, statusApprovalList.id)

            relatedForm.find('[name=statusapproval]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  // const setStatusFormatListOptions = function(relatedForm) {
  //   return new Promise((resolve, reject) => {
  //     relatedForm.find('[name=statusformat]').empty()
  //     relatedForm.find('[name=statusformat]').append(
  //       new Option('-- PILIH STATUS FORMAT --', '', false, true)
  //     ).trigger('change')

  //     $.ajax({
  //       url: `${apiUrl}parameter`,
  //       method: 'GET',
  //       dataType: 'JSON',
  //       headers: {
  //         Authorization: `Bearer ${accessToken}`
  //       },
  //       data: {
  //         limit: 0,
  //         filters: JSON.stringify({
  //           "groupOp": "AND",
  //           "rules": [{
  //             "field": "grp",
  //             "op": "cn",
  //             "data": "NOTA KREDIT"
  //           }]
  //         })
  //       },
  //       success: response => {
  //         response.data.forEach(statusFormatList => {
            
  //           let option = new Option(statusFormatList.text, statusFormatList.id)

  //           relatedForm.find('[name=statusformat]').append(option).trigger('change')
  //         });

  //         resolve()
  //       }
  //     })
  //   })
  // }
    
    
    

  
</script>
@endpush()