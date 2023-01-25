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
            <div class="row form-group">
                <input type="hidden" name="id" hidden class="form-control" readonly>

              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>nobukti <span class="text-danger">*</span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" readonly name="nobukti" class="form-control">
              </div>

              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>tgl bukti <span class="text-danger">*</span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" name="tglbukti" class="form-control datepicker">
              </div>
            </div>
            <div class="row form-group">

              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>tgl transaksi <span class="text-danger">*</span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="tgltransaksi" onchange="setPengeluaranTgl();" class="form-control datepicker">
              </div>

            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>bank  <span class="text-danger">*</span>  </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="bank" class="form-control bank-lookup">
                <input type="text" id="bankId" name="bank_id" readonly hidden >
              </div>  
            </div>

            <table class="table table-bordered table-bindkeys " id="detailList">
              <thead>
                <tr>                  
                  <th width="50">No</th>
                  <th>nobukti</th>
                  <th>tgltransaksi</th>
                  <th>keterangan</th>
                  <th>nominal</th>
                </tr>
              </thead>
              <tbody id="table_body" class="form-group">
              </tbody>
              <tfoot>
                <tr>
                  <td colspan="3"></td>
                  
                  <td class="font-weight-bold"> Total : </td>
                  <td id="sumary" class="text-right font-weight-bold">  </td>
                  
                </tr>
              </tfoot>
            </table>

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
  let parameterPengeluaran = {};
  let modalBody = $('#crudModal').find('.modal-body').html()

  $(document).ready(function() {
    

    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let rekapPengeluaranId = form.find('[name=id]').val()
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

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}rekappengeluaranheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}rekappengeluaranheader/${rekapPengeluaranId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}rekappengeluaranheader/${rekapPengeluaranId}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}rekappengeluaranheader`
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

          $('#jqGrid').trigger('reloadGrid', {
            page: response.data.page
          })

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
  function kodepengeluaran(kodepengeluaran){
    $('#crudForm').find('[name=statusformat]').val(kodepengeluaran).trigger('change');
  }
    
    $('#crudModal').on('shown.bs.modal', () => {
      let form = $('#crudForm')
      
      setFormBindKeys(form)
      
      activeGrid = null
      initDatepicker()
      initLookup()

      $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date()) ).trigger('change');
    // getMaxLength(form)
  })

  $('#crudForm').find('[name=statusformat]').change()
  
  function setPengeluaranTgl() {
    parameterPengeluaran.tglbukti = $('#crudForm').find('[name=tgltransaksi]').val();
    getPengeluaran();
  }


  function initLookup() {
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
        element.val(bank.kodebank)
        parameterPengeluaran.bank = bank.id;
        getPengeluaran();
        element.data('currentValue', element.val())
        $(`#${element[0]['name']}Id`).val(bank.id)

      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      }
    })
  }

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    $('#crudModal').find('.modal-body').html(modalBody)
    parameterPengeluaran = {};

  })


  function createRekapPengeluaranHeader() {
    resetRow()
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create Pengeluaran Stok')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
  }

  function editRekapPengeluaranHeader(rekapPengeluaranId) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Pengeluaran Stok')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    
    showRekapPengeluaran(form, rekapPengeluaranId)
  }

  function deleteRekapPengeluaranHeader(rekapPengeluaranId) {
    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Pengeluaran Stok')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    showRekapPengeluaran(form, rekapPengeluaranId)

  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}rekappengeluaranheader/field_length`,
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

  function resetRow() {
    $('.trow').remove()
  }

  function setRowNumbers() {
    let elements = $('table #table_body tr td:nth-child(1)')

    elements.each((index, element) => {
      $(element).text(index + 1)
    })
  }

  function sumary(){
		let sumary =0;
		$('.totalItem').each(function(){
			var totalItem = AutoNumeric.getNumber($(this)[0]);
			sumary +=totalItem;
		})
    new AutoNumeric($('#sumary')[0]).set(sumary);
	}

  function showRekapPengeluaran(form, rekapPengeluaranId) {
    resetRow()
    $.ajax({
      url: `${apiUrl}rekappengeluaranheader/${rekapPengeluaranId}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        sum =0;
        $.each(response.data, (index, value) => {
          let element = form.find(`[name="${index}"]`)
          if (element.is('select')) {
            element.val(value).trigger('change')
          }else if(element.attr("name") == 'tglbukti'){
            var result = value.split('-');
            element.val(result[2]+'-'+result[1]+'-'+result[0]);
          }else if(element.attr("name") == 'tgltransaksi'){
            var result = value.split('-');
            element.val(result[2]+'-'+result[1]+'-'+result[0]);
          } else {
            element.val(value)
          }
        })
        getRekapPengeluaran(rekapPengeluaranId)

      }
    })
  }

  function getPengeluaran() {
    $('#detailList tbody').html('')
    $.ajax({
      url: `${apiUrl}rekappengeluaranheader/getpengeluaran`,
      method: 'GET',
      dataType: 'JSON',
      data: {
        limit: 0,
        bank : parameterPengeluaran.bank,
        tglbukti : parameterPengeluaran.tglbukti,
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
          let detailRow = $(`
            <tr class="trow">
              <td>${row}</td>
              
              <td>
                ${detail.nobukti}
                <input type="text" value="${detail.nobukti}" id="pengeluaran_nobukti" readonly hidden name="pengeluaran_nobukti[]"  >
              </td>                 
              <td>
                ${detail.tglbukti}
                <input type="text" value="${detail.tglbukti}" id="tgltransaksi" readonly hidden name="tgltransaksi_detail[]"  >
              </td>                 
              <td>
                ${detail.keterangan_detail}
                <input type="text" value=" ${detail.keterangan_detail}" id="keterangan_detail" readonly hidden name="keterangan_detail[]"  >
              </td>
              <td>
                ${detail.nominal}
                <input type="text" value="${detail.nominal}" id="nominal" readonly hidden name="nominal[]"  >
              </td>  
            </tr>`)
          $('#detailList tbody').append(detailRow)
          totalNominal +=parseInt(detail.nominal)
          })      
          new AutoNumeric($('#sumary')[0]).set(totalNominal);
      }
    })
  }

  function getRekapPengeluaran(rekapPengeluaranId) {
    $('#detailList tbody').html('')
    $.ajax({
      url: `${apiUrl}rekappengeluaranheader/${rekapPengeluaranId}/getrekappengeluaran`,
      method: 'GET',
      dataType: 'JSON',
      data: {
        limit: 0,
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
          let detailRow = $(`
            <tr class="trow">
              <td>${row}</td>
              
              <td>
                ${detail.nobukti}
                <input type="text" value="${detail.nobukti}" id="pengeluaran_nobukti" readonly hidden name="pengeluaran_nobukti[]"  >
              </td>                 
              <td>
                ${detail.tglbukti}
                <input type="text" value="${detail.tglbukti}" id="tgltransaksi" readonly hidden name="tgltransaksi_detail[]"  >
              </td>                 
              <td>
                ${detail.keterangan_detail}
                <input type="text" value=" ${detail.keterangan_detail}" id="keterangan_detail" readonly hidden name="keterangan_detail[]"  >
              </td>
              <td>
                ${detail.nominal}
                <input type="text" value="${detail.nominal}" id="nominal" readonly hidden name="nominal[]"  >
              </td>  
            </tr>`)
          $('#detailList tbody').append(detailRow)
          // totalNominal +=parseInt(detail.nominal)
          })      
          // new AutoNumeric($('#sumary')[0]).set(totalNominal);
      }
    })
  }
</script>
@endpush()