<div class="modal modal-fullscreen" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="updateForm">
      <div class="modal-content">
        <div class="modal-header">
          <p class="modal-title" id="updateModalTitle"></p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          </button>
        </div>

        <form action="" method="post">
          <div class="modal-body">
            {{-- <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">ID</label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="id" class="form-control" readonly>
              </div>
            </div> --}}

            <input type="text" name="id" class="form-control" hidden>
            <input type="text" name="jenisorderemkl" class="form-control" hidden>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  NO BUKTI <span class="text-danger"></span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="nobukti" class="form-control" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  TGL BUKTI <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <div class="input-group">
                  <input type="text" name="tglbukti" class="form-control datepicker">
                </div>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  CONTAINER <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="container_id">
                <input type="text" name="container" class="form-control " readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  CUSTOMER <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="agen_id">
                <input type="text" name="agen" class="form-control " readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  JENIS ORDER <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="jenisorder_id">
                <input type="text" name="jenisorder" class="form-control " readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  SHIPPER <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="pelanggan_id">
                <input type="text" name="pelanggan" class="form-control " readonly>
              </div>
            </div>
            <div class="row form-group" style="display:none;">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  TUJUAN <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="tarifrincian_id">
                <input type="text" name="tarifrincian" class="form-control tarifrincian-lookup">
              </div>
            </div>
            
            <div class="row form-group">
              <div class="col-12 col-md-2">
                
              </div>
              <div class="col-12 col-md-10">
                <table class="table table-bordered " id="joblama" style="width:100%; display:none;">
                  <thead>
                      <th>#</th>
                      <th width="36%">No Job</th>
                      <th width="28%">No Cont</th>
                      <th width="36%">No Seal</th>
                  </thead>
                  <tbody>
                    <tr>
                      <th>1</th>
                      <td id="nojobemkl1"></td>
                      <td id="nocont1"></td>
                      <td id="noseal1"></td>
                    </tr>
                    <tr>
                      <th>2</th>
                      <td id="nojobemkl2"></td>
                      <td id="nocont2"></td>
                      <td id="noseal2"></td>
                    </tr>
                    <!-- Tambahkan baris lain sesuai kebutuhan -->
                  </tbody>
                </table>

              </div>
            </div>
           

            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  NO JOB EMKL (1)</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="nojobemkl" class="form-control new-orderanemkl-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  NO CONT (1)<span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="nocont" class="form-control" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  NO SEAL (1)<span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="noseal" class="form-control" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  NO JOB EMKL (2) </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="nojobemkl2" class="form-control new-orderanemkl2-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  NO CONT (2)
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="nocont2" class="form-control" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  NO SEAL (2)
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="noseal2" class="form-control" readonly>
              </div>
            </div>
            <div class="row form-group" style="display: none">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  STATUS LANGSIR <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="statuslangsir" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH STATUS LANGSIR --</option>
                </select>
              </div>
            </div>
            <div class="row form-group" style="display: none">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  STATUS PERALIHAN <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <select name="statusperalihan" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH STATUS PERALIHAN --</option>
                </select>
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-start">
            <button id="btnUpdateSubmit" class="btn btn-primary">
              <i class="fa fa-save"></i>
              Save
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
  hasFormBindKeys = false
  let modalBodyUpdate = $('#updateModal').find('.modal-body').html()

  var statustas
  var kodecontainer
  var isAllowEdited;

  $(document).ready(function() {
    $("#updateForm [name]").attr("autocomplete", "off");
    $('#btnUpdateSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#updateForm')
      let orderanTruckingId = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#updateForm').serializeArray()


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
        name: 'aksi',
        value: 'updatenocont'
      })

      data.push({
        name: 'tgldariheader',
        value: $('#tgldariheader').val()
      })
      data.push({
        name: 'tglsampaiheader',
        value: $('#tglsampaiheader').val()
      })

      let tgldariheader = $('#tgldariheader').val();
      let tglsampaiheader = $('#tglsampaiheader').val()
      
      method = 'PATCH'
      url = `${apiUrl}orderantrucking/${orderanTruckingId}/updatenocontainer`
       

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
          $('#updateForm').trigger('reset')
          $('#updateModal').modal('hide')

          id = response.data.id

          $('#jqGrid').jqGrid('setGridParam', {
            page: response.data.page
          }).trigger('reloadGrid');

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
            showDialog(error.responseJSON)
          }
        },
      }).always(() => {
        $('#processingLoader').addClass('d-none')
        $(this).removeAttr('disabled')
      })
    })


  })

  $('#updateModal').on('shown.bs.modal', () => {
    let form = $('#updateForm')

    setFormBindKeys(form)

    activeGrid = null

    getMaxLength(form)
    form.find('#btnUpdateSubmit').prop('disabled', false)
    if (form.data('action') == "view") {
      form.find('#btnUpdateSubmit').prop('disabled', true)
    }
    initLookups()
    initSelect2(form.find('.select2bs4'), true)
    initDatepicker()
  })

  $('#updateModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    $('#updateModal').find('.modal-body').html(modalBodyUpdate)
    initDatepicker('datepickerIndex')
  })


  function updateOrderanTrucking(orderanTruckingId) {
    let form = $('#updateForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnUpdateSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.find(`.sometimes`).hide()
    $('#updateModalTitle').text('update No container')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()


    Promise
      .all([
        setStatusLangsirOptions(form),
        setStatusPeralihanOptions(form)
      ])
      .then(() => {
        showOrderanTruckingUpdate(form, orderanTruckingId)
          .then(() => {
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            $('#updateModal').modal('show')
            $('#updateForm [name=tglbukti]').attr('readonly', true)
            $('#updateForm [name=tglbukti]').siblings('.input-group-append').remove()
            $('#joblama').show();

            editValidasi(isAllowEdited);
          })
          .catch((error) => {
            showDialog(error.statusText)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  function showOrderanTruckingUpdate(form, orderanTruckingId) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}orderantrucking/${orderanTruckingId}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)
            containerId = response.data.container_id
            jenisorderId = response.data.jenisorder_id

            if (element.is('select')) {
              element.val(value).trigger('change')
            } else if (element.hasClass('datepicker')) {
              element.val(dateFormat(value))
            } else if (
              index == "nojobemkl"||
              index == "nocont"||
              index == "noseal"||
              index == "nojobemkl2"||
              index == "nocont2"||
              index == "noseal2"
            ) {
              element.val('')
            } else {
              element.val(value)
            }

            if (index == 'container') {
              element.data('current-value', value)
            }
            if (index == 'agen') {
              element.data('current-value', value)
            }
            if (index == 'jenisorder') {
              element.data('current-value', value)
            }
            if (index == 'pelanggan') {
              element.data('current-value', value)
            }
            if (index == 'nojobemkl') {
              element.data('current-value', value)
              $(`#nojobemkl1`).html(value)
            }
            if (index == 'nojobemkl2') {
              element.data('current-value', value)
              $(`#nojobemkl2`).html(value)
            }
            if (index == 'nocont') {
              $(`#nocont1`).html(value)
            }
            if (index == 'nocont2') {
              $(`#nocont2`).html(value)
            }
            if (index == 'noseal') {
              $(`#noseal1`).html(value)
            }
            if (index == 'noseal2') {
              $(`#noseal2`).html(value)
            }

            if (index == 'agen_id') {
              getagentas(form,value, response.data.statusapprovaltanpajob, response.data.tglbatastanpajoborderantrucking)
            }
          })


          if (form.data('action') === 'delete') {
            form.find('[name]').addClass('disabled')
            initDisabled()
          }

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function initLookups() {
    
    $('.new-orderanemkl-lookup').lookup({
      title: 'orderanemkl Lookup',
      fileName: 'orderanemkl',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          jenisorder_Id: jenisorderId,
          container_Id: containerId,
        }
      },
      onSelectRow: (orderanemkl, element) => {
        element.val(orderanemkl.nojob)
        element.data('currentValue', element.val())
        
        $('#updateModal [name=nocont]').first().val(orderanemkl.nocont)
        $('#updateModal [name=noseal]').first().val(orderanemkl.noseal)
        $('#updateModal [name=jenisorderemkl]').first().val(orderanemkl.jenisorderan)
        
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        $('#updateModal [name=nocont]').val('')
        $('#updateModal [name=noseal]').val('')
        element.data('currentValue', element.val())
      }
    })
    
    $('.new-orderanemkl2-lookup').lookup({
      title: 'orderanemkl Lookup',
      fileName: 'orderanemkl',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          jenisorder_Id: jenisorderId,
          container_Id: containerId,
        }
      },
      onSelectRow: (orderanemkl, element) => {
        element.val(orderanemkl.nojob)
        element.data('currentValue', element.val())
        
        $('#updateModal [name=nocont2]').first().val(orderanemkl.nocont)
        $('#updateModal [name=noseal2]').first().val(orderanemkl.noseal)
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