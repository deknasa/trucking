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

            <div class="row form-group jurnalasal">
              <div class="col-12 col-sm-2 col-md-2">
                <label class="col-form-label">
                  NO JURNAL COPY <span class="text-danger"></span>
                </label>
              </div>
              <div class="col-12 col-sm-4 col-md-4">
                <input type="text" name="jurnalasal" class="form-control jurnal-lookup">
              </div>
            </div>

            <div class="table-container">
              <table class="table table-bordered table-bindkeys" id="detailList" style="width: 1150px;">
                <thead>
                  <tr>
                    <th width="1%">No</th>
                    <th width="1%" class="tbl_aksi">Aksi</th>
                    <th width="8%">NAMA PERKIRAAN (DEBET)</th>
                    <th width="8%">NAMA PERKIRAAN (KREDIT)</th>
                    <th width="5%">NOMINAL</th>
                    <th width="10%">KETERANGAN</th>
                  </tr>
                </thead>
                <tbody id="table_body" class="form-group">

                </tbody>
                <tfoot>
                  <tr>
                    <td></td>
                    <td class="tbl_aksi">
                      <button type="button" class="btn btn-primary btn-sm my-2" id="addRow">Tambah</button>
                    </td>
                    <td colspan="2">
                      <p class="text-right font-weight-bold">TOTAL :</p>
                    </td>
                    <td>
                      <p class="text-right font-weight-bold autonumeric" id="total"></p>
                    </td>
                    <td></td>
                  </tr>
                </tfoot>
              </table>
            </div>

          </div>
          <div class="modal-footer justify-content-start">
            <button id="btnSubmit" class="btn btn-primary">
              <i class="fa fa-save"></i>
              Save
            </button>
            <button id="btnSaveAdd" class="btn btn-success">
              <i class="fas fa-file-upload"></i>
              Save & Add
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
  let hasFormBindKeys = false
  let modalBody = $('#crudModal').find('.modal-body').html()
  let isEditTgl

  $(document).ready(function() {

    $("#crudForm [name]").attr("autocomplete", "off");

    $(document).on('click', "#addRow", function() {
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
      $.ajax({
        url: `${apiUrl}jurnalumumheader/addrow`,
        method: 'POST',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: data,
        success: response => {
          addRow()
          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()
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

    });

    $(document).on('click', '.delete-row', function(event) {
      deleteRow($(this).parents('tr'))
    })

    $(document).on('input', `#table_body [name="nominal_detail[]"]`, function(event) {
      setTotal()
    })

    $('#btnSubmit').click(function(event) {
      event.preventDefault()
      submit($(this).attr('id'))
    })
    $('#btnSaveAdd').click(function(event) {
      event.preventDefault()
      submit($(this).attr('id'))
    })


    function submit(button) {

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
        value: $('#jqGrid').jqGrid('getGridParam', 'postData').limit
      })
      data.push({
        name: 'button',
        value: button
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

          if (button == 'btnSubmit') {

            id = response.data.id
            console.log('id', id)
            $('#crudModal').modal('hide')
            $('#crudModal').find('#crudForm').trigger('reset')

            $('#rangeHeader').find('[name=tgldariheader]').val(dateFormat(response.data.tgldariheader)).trigger('change');
            $('#rangeHeader').find('[name=tglsampaiheader]').val(dateFormat(response.data.tglsampaiheader)).trigger('change');
            $('#jqGrid').jqGrid('setGridParam', {
              page: response.data.page,
              postData: {
                tgldari: dateFormat(response.data.tgldariheader),
                tglsampai: dateFormat(response.data.tglsampaiheader)
              }
            }).trigger('reloadGrid');

            if (id == 0) {
              $('#detail').jqGrid().trigger('reloadGrid')
            }
          } else {

            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
            showSuccessDialog(response.message, response.data.nobukti)
            createJurnalUmumHeader()
            $('#crudForm').find('input[type="text"]').data('current-value', '')
            $('#crudForm').find('[name=tglbukti]').val(dateFormat(response.data.tglbukti)).trigger('change');
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
            showDialog(error.responseJSON)
          }
        },
      }).always(() => {
        $('#processingLoader').addClass('d-none')
        $(this).removeAttr('disabled')
      })
    }
  })

  $('#crudModal').on('shown.bs.modal', () => {
    let form = $('#crudForm')

    setFormBindKeys(form)
    if (form.data('action') == 'add') {
      form.find('#btnSaveAdd').show()
    } else {
      form.find('#btnSaveAdd').hide()
    }

    activeGrid = null

    form.find('#btnSubmit').prop('disabled', false)
    if (form.data('action') == "view") {
      form.find('#btnSubmit').prop('disabled', true)
    }

    getMaxLength(form)
    initDatepicker()
    initLookup()
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    removeEditingBy($('#crudForm').find('[name=id]').val())
    $('#crudModal').find('.modal-body').html(modalBody)
    initDatepicker('datepickerIndex')
  })

  function removeEditingBy(id) {
    if (id == "") {
      return ;
    }
    let formData = new FormData();


    formData.append('id', id);
    formData.append('aksi', 'BATAL');
    formData.append('table', 'jurnalumumheader');

    fetch(`{{ config('app.api_url') }}removeedit`, {
        method: 'POST',
        headers: {
          'Authorization': `Bearer ${accessToken}`
        },
        body: formData,
        keepalive: true

      })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
        $("#crudModal").modal("hide");
      })
      .catch(error => {
        // Handle error
        if (error.status === 422) {
          $('.is-invalid').removeClass('is-invalid');
          $('.invalid-feedback').remove();
          setErrorMessages(form, error.responseJSON.errors);
        } else {
          showDialog(error.responseJSON);
        }
      })
  }

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
      Save
    `)
    form.data('action', 'add')

    $('#crudModalTitle').text('Add Jurnal Umum')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()


    $('#table_body').html('')
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    if (selectedRows.length > 0) {
      clearSelectedRows()
    }
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
      Save
    `)
    $('#crudModalTitle').text('Edit Jurnal Umum')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setTglBukti(form),
        showJurnalUmum(form, id)
      ])
      .then(() => {
        if (selectedRows.length > 0) {
          clearSelectedRows()
        }
        $('#crudModal').modal('show')
        if (isEditTgl == 'TIDAK') {
          form.find(`[name="tglbukti"]`).prop('readonly', true)
          form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
        }
      })
      .catch((error) => {
        showDialog(error.responseJSON)
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
      <i class="fa fa-trash"></i>
              Delete
    `)
    $('#crudModalTitle').text('Delete Jurnal Umum')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        showJurnalUmum(form, id)
      ])
      .then(() => {
        if (selectedRows.length > 0) {
          clearSelectedRows()
        }
        $('#crudModal').modal('show')
      })
      .catch((error) => {
        showDialog(error.responseJSON)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })

  }

  function viewJurnalUmumHeader(id) {

    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'view')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.find('#btnSubmit').prop('disabled', true)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('View Jurnal Umum')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        showJurnalUmum(form, id)
      ])
      .then(id => {
        setFormBindKeys(form)
        initSelect2(form.find('.select2bs4'), true)
        form.find('[name]').removeAttr('disabled')

        form.find('select').each((index, select) => {
          let element = $(select)

          if (element.data('select2')) {
            element.select2('destroy')
          }
        })

        form.find('[name]').attr('disabled', 'disabled').css({
          background: '#fff'
        })
        form.find('[name=id]').prop('disabled', false)
      })
      .then(() => {
        if (selectedRows.length > 0) {
          clearSelectedRows()
        }
        $('#crudModal').modal('show')
        form.find(`.hasDatepicker`).prop('readonly', true)
        form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').remove()

        let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
        let nameFind = $('#crudForm').find(`[name]`).parents('.input-group')
        name.attr('disabled', true)
        name.find('.lookup-toggler').remove()
        nameFind.find('button.button-clear').remove()
        $('#crudForm').find(`.tbl_aksi`).hide()
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
          showDialog(error.responseJSON)
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
      Save
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
      data: {
        aksi: Aksi
      },
      success: response => {
        var kodenobukti = response.kodenobukti
        if (kodenobukti == '1') {
          var kodestatus = response.kodestatus
          if (kodestatus == '1') {
            showDialog(response.message['keterangan'])
          } else {
            //function validasi aksi
            if (Aksi == 'PRINTER BESAR') {
              window.open(`{{ route('jurnalumumheader.report') }}?id=${Id}&printer=reportPrinterBesar`)
            } else if (Aksi == 'PRINTER KECIL') {
              window.open(`{{ route('jurnalumumheader.report') }}?id=${Id}&printer=reportPrinterKecil`)
            } else {
              cekValidasiAksi(Id, Aksi)
            }
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

      $.ajax({
        url: `${apiUrl}jurnalumumheader/${id}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          if (isCopy) {

            delete response.data['id'];
            delete response.data['nobukti'];
            delete response.data['tglbukti'];
            $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

          }
          $('.jurnalasal').hide()
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
              <td class="tbl_aksi">
                  <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
              </td>
              <td>
                <input type="hidden" name="coadebet_detail[]">
                <input type="text" name="ketcoadebet_detail[]" id="ketcoadebet_detail${index}" data-current-value="${detail.coadebet}" class="form-control coadebet-lookup">
              </td>
              <td>
                <input type="hidden" name="coakredit_detail[]">
                <input type="text" name="ketcoakredit_detail[]" id="ketcoakredit_detail${index}" data-current-value="${detail.coakredit}" class="form-control coakredit-lookup">
              </td>
              <td>
                <input type="text" name="nominal_detail[]"  style="text-align:right" class="form-control autonumeric nominal" > 
              </td>
              <td>
                <textarea class="form-control" name="keterangan_detail[]" rows="1" placeholder=""></textarea>
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

            $('.coadebet-lookup').last().lookupV3({
              title: 'Coa Debet Lookup',
              fileName: 'akunpusatV3',
              searching: ['coa','keterangancoa'],
              labelColumn: true,
              extendSize: md_extendSize_1,
              multiColumnSize:true,
              filterToolbar: true,
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

            $('.coakredit-lookup').last().lookupV3({
              title: 'Coa Kredit Lookup',
              fileName: 'akunpusatV3',
              searching: ['coa','keterangancoa'],
              labelColumn: true,
              extendSize: md_extendSize_1,
              multiColumnSize:true,
              filterToolbar: true,
              beforeProcess: function(test) {
                this.postData = {
                  levelCoa: '3',
                  Aktif: 'AKTIF',
                }
              },
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

  let lastRow = 0
  function addRow() {
    let detailRow = $(`
      <tr>
        <td></td>
        <td class="tbl_aksi">
            <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
        </td>
        <td>
          <input type="hidden" name="coadebet_detail[]">
          <input type="text" name="ketcoadebet_detail[]" id="ketcoadebet_detail${lastRow}" class="form-control coadebet-lookup">
        </td>
        <td>
          <input type="hidden" name="coakredit_detail[]">
          <input type="text" name="ketcoakredit_detail[]" id="ketcoakredit_detail${lastRow}" class="form-control coakredit-lookup">
        </td>
        <td>
          <input type="text" name="nominal_detail[]" class="form-control autonumeric nominal"> 
        </td>
        <td>
          <textarea class="form-control" name="keterangan_detail[]" rows="1" placeholder=""></textarea>
        </td>
      </tr>
    `)

    $('#detailList tbody').append(detailRow)

    // $('#lookup').hide()
    $('.coadebet-lookup').last().lookupV3({
      title: 'Coa Debet Lookup',
      fileName: 'akunpusatV3',
      searching: ['coa','keterangancoa'],
      labelColumn: true,
      extendSize: md_extendSize_1,
      multiColumnSize:true,
      filterToolbar: true,
      beforeProcess: function() {
        this.postData = {
          levelCoa: '3',
          Aktif: 'AKTIF',
          limits: 50,
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

    $('.coakredit-lookup').last().lookupV3({
      title: 'Coa Kredit Lookup',
      fileName: 'akunpusatV3',
      searching: ['coa','keterangancoa'],
      labelColumn: true,
      extendSize: md_extendSize_1,
      multiColumnSize:true,
      filterToolbar: true,
      beforeProcess: function(test) {
        this.postData = {
          levelCoa: '3',
          Aktif: 'AKTIF',
          limits: 50,
        }
      },
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
    lastRow++
  }

  function deleteRow(row) {
    let countRow = $('.delete-row').parents('tr').length
    row.remove()
    if (countRow <= 1) {
      addRow()
    }
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
          showDialog(error.responseJSON)
        }
      })
    }
  }

  function initLookup() {
    $('.jurnal-lookup').lookup({
      title: 'Jurnal Umum Lookup',
      fileName: 'jurnalumum',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (jurnalumum, element) => {
        element.val(jurnalumum.nobukti)
        element.data('currentValue', element.val())

        $('#table_body').html('')
        getJurnalUmum(jurnalumum.id)
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

  function getJurnalUmum(jurnalId) {
    $.ajax({
      url: `${apiUrl}jurnalumumdetail/getDetail`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        'Authorization': `Bearer ${accessToken}`
      },
      data: {
        jurnalumum_id: jurnalId
      },
      success: response => {
        $.each(response.data, (index, detail) => {
          let detailRow = $(`
              <tr>
              <td></td>
              <td class="tbl_aksi">
                  <button type="button" class="btn btn-danger btn-sm delete-row">Delete</button>
              </td>
              <td>
                <input type="hidden" name="coadebet_detail[]">
                <input type="text" name="ketcoadebet_detail[]" id="ketcoadebet_detail${index}"  data-current-value="${detail.coadebet}" class="form-control coadebet-lookup">
              </td>
              <td>
                <input type="hidden" name="coakredit_detail[]">
                <input type="text" name="ketcoakredit_detail[]" id="ketcoakredit_detail${index}"  data-current-value="${detail.coakredit}" class="form-control coakredit-lookup">
              </td><td>
                <input type="text" name="nominal_detail[]"  style="text-align:right" class="form-control autonumeric nominal" > 
              </td>
              <td>
                <textarea class="form-control" name="keterangan_detail[]" rows="1" placeholder=""></textarea>
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

          $('.coadebet-lookup').last().lookupV3({
            title: 'Coa Debet Lookup',
            fileName: 'akunpusatV3',
            searching: ['coa','keterangancoa'],
            labelColumn: true,
            extendSize: md_extendSize_1,
            multiColumnSize:true,
            filterToolbar: true,
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

          $('.coakredit-lookup').last().lookupV3({
            title: 'Coa Kredit Lookup',
            fileName: 'akunpusatV3',
            searching: ['coa','keterangancoa'],
            labelColumn: true,
            extendSize: md_extendSize_1,
            multiColumnSize:true,
            filterToolbar: true,
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
      },
      error: error => {
        showDialog(error.responseJSON)
      }
    })
  }

  const setTglBukti = function(form) {
    return new Promise((resolve, reject) => {
      let data = [];
      data.push({
        name: 'grp',
        value: 'EDIT TANGGAL BUKTI'
      })
      data.push({
        name: 'subgrp',
        value: 'JURNAL UMUM'
      })
      $.ajax({
        url: `${apiUrl}parameter/getparamfirst`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: data,
        success: response => {
          isEditTgl = $.trim(response.text);
          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }
</script>
@endpush()