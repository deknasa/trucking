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
                <label class="col-form-label">nobukti <span class="text-danger"></span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" readonly name="nobukti" class="form-control">
              </div>

              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">tglbukti <span class="text-danger">*</span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">  
                <div class="input-group">
                  <input type="text" name="tglbukti" class="form-control datepicker">
                </div>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">absensisupir <span class="text-danger">*</span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="absensisupir_nobukti" class="form-control absensisupir-lookup">
                <input type="text" id="absensisupir_kasgantung" readonly hidden name="kasgantung_nobukti">
              </div>
            </div>
            
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">keterangan <span class="text-danger">*</span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="keterangan" class="form-control">
              </div>
            </div>
            
            <table class="table table-bordered table-bindkeys " id="detailList">
              <thead>
                <tr>
                  <th width="50">No</th>
                  <th width="">Supir</th>
                  <th width="">Trado</th>
                  <th width="">keterangan detail</th>
                  <th width="">uang jalan</th>
                </tr>
              </thead>
              <tbody id="table_body" class="form-group">
              </tbody>
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
  let modalBody = $('#crudModal').find('.modal-body').html()

  function initLookup() {
      $('.absensisupir-lookup').lookup({
        title: 'absensisupir Lookup',
        fileName: 'absensisupir',
        beforeProcess: function(test) {
              this.postData = {
                Aktif: 'AKTIF',
              }
            },        
        onSelectRow: (absensisupir, element) => {
          element.val(absensisupir.nobukti)
          $(`#absensisupir_kasgantung`).val(absensisupir.kasgantung_nobukti)
          getAbsensi(absensisupir.id)
          element.data('currentValue', element.val())
        },
        onCancel: (element) => {
          element.val(element.data('currentValue'))
        },
        onClear: (element) => {
          $(`#${element[0]['name']}Id`).val('')
        element.val('')
        element.data('currentValue', element.val())
        }
      })
    }
  $(document).ready(function() {

    
      
    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let absensiSupirApproval = form.find('[name=id]').val()
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
          url = `${apiUrl}absensisupirapprovalheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}absensisupirapprovalheader/${absensiSupirApproval}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}absensisupirapprovalheader/${absensiSupirApproval}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}absensisupirapprovalheader`
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
        $('#processingLoader').addClass('d-none')
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
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date()) ).trigger('change');
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    
    $('#crudModal').find('.modal-body').html(modalBody)
  })

  


  function createAbsensiSupirApprovalHeader() {
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create AbsensiSupirApproval')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
  }

  function editAbsensiSupirApprovalHeader(absensiSupirApproval) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit AbsensiSupirApproval')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    ShowAbsensiSupirApproval(form, absensiSupirApproval)
  }

  function deleteAbsensiSupirApprovalHeader(absensiSupirApproval) {
    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete AbsensiSupirApproval')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    
    ShowAbsensiSupirApproval(form, absensiSupirApproval)
  }
  
  function ShowAbsensiSupirApproval(form, userId) {
    $('#detailList tbody').html('')
    $.ajax({
      url: `${apiUrl}absensisupirapprovalheader/${userId}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        $.each(response.data, (index, value) => {
          let element = form.find(`[name="${index}"]`)
          element.val(value)
          if(element.attr("name") == 'tglbukti'){
            var result = value.split('-');
            element.val(result[2]+'-'+result[1]+'-'+result[0]);
          }
        })
        getApprovalAbsensi(userId)
      }
    })

  }

  function getAbsensi(id) {
    $('#detailList tbody').html('')

    $.ajax({
      url: `${apiUrl}absensisupirapprovalheader/${id}/getabsensi`,
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
          let detailRow = $(`
            <tr class="trow">
              <td>${row}</td>
              
              <td>
                ${detail.supir}
                <input type="text" value="${detail.supir_id}" id="supir_id" name="supir_id[]"  readonly hidden>

              </td>                 
              <td>
                ${detail.trado}
                <input type="text" value="${detail.trado_id}" id="trado_id" name="trado_id[]"  readonly hidden>

              </td>  
              <td>
                ${detail.keterangan_detail}
              </td>
             
              <td>
                <span class="autonumeric">
                  ${detail.uangjalan}
                </span>                
                <input type="text" value="${detail.uangjalan}" id="uangjalan" name="uangjalan[]"  readonly hidden>

              </td>
            </tr>`)
          $('#detailList tbody').append(detailRow)          
          initAutoNumeric(detailRow.find('.autonumeric'))
          })      
      }
    })
  }
  function getApprovalAbsensi(id) {
    $('#detailList tbody').html('')

    $.ajax({
      url: `${apiUrl}absensisupirapprovalheader/${id}/getapproval`,
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
          let detailRow = $(`
            <tr class="trow">
              <tr class="trow">
              <td>${row}</td>
              
              <td>
                ${detail.supir}
                <input type="text" value="${detail.supir_id}" id="supir_id" name="supir_id[]"  readonly hidden>

              </td>                 
              <td>
                ${detail.trado}
                <input type="text" value="${detail.trado_id}" id="trado_id" name="trado_id[]"  readonly hidden>
                
                </td>  
                <td>
                  ${detail.keterangan_detail}
                  </td>
                  
                <td>
                  <span class="autonumeric">
                    ${detail.uangjalan}
                  </span>
                  <input type="text" value="${detail.uangjalan}" id="uangjalan" name="uangjalan[]"  readonly hidden>
              </td>
            </tr>`)
          $('#detailList tbody').append(detailRow)
          initAutoNumeric(detailRow.find('.autonumeric'))
        })      
      }
    })
  }

  
  function cekValidasi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}absensisupirapprovalheader/${Id}/cekvalidasi`,
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
              editAbsensiSupirApprovalHeader(Id)
            }
            if (Aksi == 'DELETE') {
              deleteAbsensiSupirApprovalHeader(Id)
            }
          }

        } else {
          showDialog(response.message['keterangan'])
        }
      }
    })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}absensisupirapprovalheader/field_length`,
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
  
</script>
@endpush()