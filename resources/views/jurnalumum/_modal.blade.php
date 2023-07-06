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
                  NO BUKTI <span class="text-danger"></span>
                </label>
              </div>
              <div class="col-12 col-sm-4 col-md-4">
                <input type="text" name="nobukti" class="form-control" readonly>
              </div>

              <div class="col-12 col-sm-2 col-md-2">
                <label class="col-form-label">
                  TGL BUKTI <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-4 col-md-4">
                <div class="input-group">
                  <input type="text" name="tglbukti" class="form-control datepicker">
                </div>
              </div>
            </div>

            <div class="table-responsive table-scroll">
              <table class="table table-bordered table-bindkeys" id="detailList" style="width: 1500px;">
                <thead>
                  <tr>
                    <th width="1%">No</th>
                    <th width="5%">NAMA PERKIRAAN (DEBET)</th>
                    <th width="5%">NAMA PERKIRAAN (KREDIT)</th>
                    <th width="5%">KETERANGAN</th>
                    <th width="6%">NOMINAL</th>
                    <th width="2%">Aksi</th>
                  </tr>
                </thead>
                <tbody id="table_body" class="form-group">

                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="4">
                      <p class="text-right font-weight-bold">TOTAL :</p>
                    </td>
                    <td>
                      <p class="text-right font-weight-bold autonumeric" id="total"></p>
                    </td>
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

  $(document).ready(function() {

    $("#crudForm [name]").attr("autocomplete", "off");

    $(document).on('click', "#addRow", function() {
      addRow()
    });

    $(document).on('click', '.delete-row', function(event) {
      deleteRow($(this).parents('tr'))
    })

    $(document).on('input', `#table_body [name="nominal_detail[]"]`, function(event) {
      setTotal()
    })

    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()

      $('#crudForm').find(`[name="nominal_detail[]"`).each((index, element) => {
        data.filter((row) => row.name === 'nominal_detail[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominal_detail[]"]`)[index])
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

      let tgldariheader = $('#tgldariheader').val();
      let tglsampaiheader = $('#tglsampaiheader').val()

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}jurnalumumheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}jurnalumumheader/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}jurnalumumheader/${Id}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
          break;
        case 'copy':
          method = 'POST'
          url = `${apiUrl}jurnalumumheader/copy`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}jurnalumumheader`
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


          id = response.data.id
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
            //showDialog(error.responseJSON)
if(error.responseJSON.errors){
	showDialog(error.statusText, error.responseJSON.errors.join('<hr>'))
} else if(error.responseJSON.message) {
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

  $('#crudModal').on('shown.bs.modal', () => {
    let form = $('#crudForm')

    setFormBindKeys(form)

    activeGrid = null

    getMaxLength(form)
    initDatepicker()
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'

    $('#crudModal').find('.modal-body').html(modalBody)
  })

  function setTotal() {
    let nominalDetails = $(`#table_body [name="nominal_detail[]"]`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#total').set(total)
  }

  function createJurnalUmumHeader() {
    let form = $('#crudForm')

    $('#crudModal').find('#crudForm').trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
    form.data('action', 'add')

    $('#crudModalTitle').text('Add Jurnal Umum')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()


    $('#table_body').html('')
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    addRow()
    setTotal()
  }

  function editJurnalUmumHeader(id) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
    $('#crudModalTitle').text('Edit Jurnal Umum')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        showJurnalUmum(form, id)
      ])
      .then(() => {
        clearSelectedRows()
        $('#gs_').prop('checked', false)
        $('#crudModal').modal('show')
        form.find('[name=tglbukti]').attr('readonly', true)
        form.find('[name=tglbukti]').siblings('.input-group-append').remove()
      })
      .catch((error) => {
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })

  }

  function deleteJurnalUmumHeader(id) {

    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Hapus
    `)
    $('#crudModalTitle').text('Delete Jurnal Umum')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        showJurnalUmum(form, id)
      ])
      .then(() => {
        clearSelectedRows()
        $('#gs_').prop('checked', false)
        $('#crudModal').modal('show')
      })
      .catch((error) => {
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })

  }

  function approve() {

    event.preventDefault()

    let form = $('#crudForm')
    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')

    $.ajax({
      url: `${apiUrl}jurnalumumheader/approval`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        jurnalId: selectedRows
      },
      success: response => {
        $('#crudForm').trigger('reset')
        $('#crudModal').modal('hide')

        $('#jqGrid').jqGrid().trigger('reloadGrid');
        selectedRows = []
        $('#gs_').prop('checked', false)
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
  }

  function copyJurnal(id) {

    let form = $('#crudForm')

    form.data('action', 'copy')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
    $('#crudModalTitle').text('Copy Jurnal Umum')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    showJurnalUmum(form, id, true)

  }

  function cekApproval(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}jurnalumumheader/${Id}/cekapproval`,
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
            //function validasi aksi
            cekValidasiAksi(Id, Aksi)
            // if (Aksi == 'EDIT') {
            //   editJurnalUmumHeader(Id)
            // }
            // if (Aksi == 'DELETE') {
            //   deleteJurnalUmumHeader(Id)
            // }
            // if (Aksi == 'COPY') {
            //   copyJurnal(Id)
            // }
          }

        } else {
          showDialog(response.message['keterangan'])
        }
      }
    })
  }

  // validasiaksi
  function cekValidasiAksi(Id, Aksi) {
    console.log('cekaski')
    $.ajax({
      url: `{{ config('app.api_url') }}jurnalumumheader/${Id}/cekvalidasiaksi`,
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
            editJurnalUmumHeader(Id)
          }
          if (Aksi == 'DELETE') {
            deleteJurnalUmumHeader(Id)
          }
          if (Aksi == 'COPY') {
            copyJurnal(Id)
          }
        }
      }
    })
  }

  function showJurnalUmum(form, id, isCopy = false) {
    return new Promise((resolve, reject) => {
      $('#detailList tbody').html('')
      if (!isCopy) {
        form.find(`[name="tglbukti"]`).prop('readonly', true)
        form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
      }
      $.ajax({
        url: `${apiUrl}jurnalumumheader/${id}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          if(isCopy){

            delete response.data['id'];
            delete response.data['nobukti'];
            delete response.data['tglbukti'];
            $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

          }

          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)

            if (element.hasClass('datepicker')) {
              element.val(dateFormat(value))
            } else {
              element.val(value)
            }
          })
          $('#detailList tbody').html('')
          $.each(response.detail, (index, detail) => {
            let detailRow = $(`
              <tr>
              <td></td>
              <td>
                <input type="hidden" name="coadebet_detail[]">
                <input type="text" name="ketcoadebet_detail[]" data-current-value="${detail.coadebet}" class="form-control coadebet-lookup">
              </td>
              <td>
                <input type="hidden" name="coakredit_detail[]">
                <input type="text" name="ketcoakredit_detail[]" data-current-value="${detail.coakredit}" class="form-control coakredit-lookup">
              </td>
              <td>
                <input type="text" name="keterangan_detail[]" class="form-control">   
              </td><td>
                <input type="text" name="nominal_detail[]"  style="text-align:right" class="form-control autonumeric nominal" > 
              </td>
              <td>
                  <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
              </td>
              </tr>
            `)

            detailRow.find(`[name="coadebet_detail[]"]`).val(detail.coadebet)
            detailRow.find(`[name="coakredit_detail[]"]`).val(detail.coakredit)
            detailRow.find(`[name="ketcoadebet_detail[]"]`).val(detail.ketcoadebet)
            detailRow.find(`[name="ketcoakredit_detail[]"]`).val(detail.ketcoakredit)
            detailRow.find(`[name="keterangan_detail[]"]`).val(detail.keterangan)
            detailRow.find(`[name="nominal_detail[]"]`).val(detail.nominal)

            initAutoNumeric(detailRow.find(`[name="nominal_detail[]"]`))
            $('#detailList tbody').append(detailRow)
            setTotal();

            $('.coadebet-lookup').last().lookup({
              title: 'Coa Debet Lookup',
              fileName: 'akunpusat',
              beforeProcess: function(test) {
                this.postData = {
                  Aktif: 'AKTIF',
                  levelCoa: '3',
                }
              },
              onSelectRow: (akunpusat, element) => {
                element.parents('td').find(`[name="coadebet_detail[]"]`).val(akunpusat.coa)
                element.val(akunpusat.keterangancoa)
                element.data('currentValue', element.val())
              },
              onCancel: (element) => {
                element.val(element.data('currentValue'))
              },
              onClear: (element) => {
                element.parents('td').find(`[name="coadebet_detail[]"]`).val('')
                element.val('')
                element.data('currentValue', element.val())
              }
            })

            $('.coakredit-lookup').last().lookup({
              title: 'Coa Kredit Lookup',
              fileName: 'akunpusat',
              onSelectRow: (akunpusat, element) => {
                element.parents('td').find(`[name="coakredit_detail[]"]`).val(akunpusat.coa)
                element.val(akunpusat.keterangancoa)
                element.data('currentValue', element.val())
              },
              onCancel: (element) => {
                element.val(element.data('currentValue'))
              },
              onClear: (element) => {
                element.parents('td').find(`[name="coakredit_detail[]"]`).val('')
                element.val('')
                element.data('currentValue', element.val())
              }
            })
          })

          setRowNumbers()
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

  function addRow() {
    let detailRow = $(`
      <tr>
        <td></td>
        <td>
          <input type="hidden" name="coadebet_detail[]">
          <input type="text" name="ketcoadebet_detail[]"  class="form-control coadebet-lookup">
        </td>
        <td>
          <input type="hidden" name="coakredit_detail[]">
          <input type="text" name="ketcoakredit_detail[]"  class="form-control coakredit-lookup">
        </td>
        <td>
          <input type="text" name="keterangan_detail[]" class="form-control">   
        </td><td>
          <input type="text" name="nominal_detail[]" class="form-control autonumeric nominal"> 
        </td>
        <td>
            <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
        </td>
      </tr>
    `)

    $('#detailList tbody').append(detailRow)

    // $('#lookup').hide()
    $('.coadebet-lookup').last().lookup({
      title: 'Coa Debet Lookup',
      fileName: 'akunpusat',
      onSelectRow: (akunpusat, element) => {
        element.parents('td').find(`[name="coadebet_detail[]"]`).val(akunpusat.coa)
        element.val(akunpusat.keterangancoa)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.parents('td').find(`[name="coadebet_detail[]"]`).val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.coakredit-lookup').last().lookup({
      title: 'Coa Kredit Lookup',
      fileName: 'akunpusat',
      onSelectRow: (akunpusat, element) => {
        element.parents('td').find(`[name="coakredit_detail[]"]`).val(akunpusat.coa)
        element.val(akunpusat.keterangancoa)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.parents('td').find(`[name="coakredit_detail[]"]`).val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    initAutoNumeric(detailRow.find('.autonumeric'))

    initDatepicker()
    setRowNumbers()
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
        url: `${apiUrl}jurnalumumheader/field_length`,
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