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

            <div class="row">
              <!-- <div class="form-group col-md-4">
                <div class="col-12 col-md-2 col-form-label">
                  <label>ID</label>
                </div>
                <div>
                  <input type="text" name="id" class="form-control" readonly>
                </div>
              </div> -->

              <div class="form-group col-md-4">
                <div class="col-form-label">
                  <label>
                    NO BUKTI <span class="text-danger">*</span>
                  </label>
                </div>
                <div>
                  <input type="text" name="nobukti" class="form-control" readonly>
                </div>
              </div>

              <div class="form-group col-md-4">
                <div class="col-form-label col-form-label">
                  <label>
                    TGL BUKTI <span class="text-danger">*</span>
                  </label>
                </div>
                <div>
                  <div class="input-group">
                    <input type="text" name="tglbukti" class="form-control datepicker">
                  </div>
                </div>
              </div>

              <div class="form-group col-md-4">
                <div class="col-12 col-md-2 col-form-label">
                  <label>
                    TGL SP <span class="text-danger">*</span>
                  </label>
                </div>
                <div>
                  <div class="input-group">
                    <input type="text" name="tglsp" class="form-control datepicker">
                  </div>
                </div>
              </div>

              <div class="form-group col-md-4">
                <div class="col-12 col-md-2 col-form-label">
                  <label>
                    NO SP <span class="text-danger">*</span>
                  </label>
                </div>
                <div>
                  <input type="text" name="nosp" class="form-control">
                </div>
              </div>
              <div class="form-group col-md-4">
                <div class="col-form-label">
                  <label>
                    STATUS LONGTRIP <span class="text-danger">*</span>
                  </label>
                </div>
                <div>
                  <select name="statuslongtrip" class="form-control select2bs4" id="statuslongtrip">
                    <option value="">-- PILIH STATUS LONGTRIP --</option>
                  </select>
                </div>
              </div>
              <!-- <div class="form-group col-md-4">
                <div class="col-form-label">
                  <label>
                    STATUS LONGTRIP <span class="text-danger">*</span>
                  </label>
                </div>
                <div>
                  <select name="statuslongtrip" class="form-control select2bs4" style="width: 100%;">
                    <option value="">-- PILIH STATUS LONGTRIP --</option>
                  </select>
                </div>
              </div> -->

              <!-- <div class="row form-group col-md-4">
                <div class="col-12 col-sm-3 col-md-2 col-form-label">
                  <label>
                    DARI <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-8 col-md-10">
                  <input type="hidden" name="dari_id">
                  <input type="text" name="dari" class="form-control kotadari-lookup">
                </div>
              </div>

              <div class="row form-group col-md-4">
                <div class="col-12 col-sm-3 col-md-2 col-form-label">
                  <label>
                    TUJUAN <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-8 col-md-10">
                  <input type="hidden" name="sampai_id">
                  <input type="text" name="sampai" class="form-control kotasampai-lookup">
                </div>
              </div> -->

              <div class="form-group col-md-6">
                <div class="col-form-label">
                  <label>
                    DARI <span class="text-danger">*</span>
                  </label>
                </div>
                <div>
                  <input type="hidden" name="dari_id">
                  <input type="text" name="dari" class="form-control kotadari-lookup">
                </div>

                <div class="col-form-label">
                  <label>
                    TUJUAN <span class="text-danger">*</span>
                  </label>
                </div>
                <div>
                  <input type="hidden" name="sampai_id">
                  <input type="text" name="sampai" class="form-control kotasampai-lookup">
                </div>

                <!-- <div class="col-form-label">
                  <label>
                    SAMPAI <span class="text-danger">*</span>
                  </label>
                </div>
                <div>
                  <select name="sampai_id" id="sampai_id" class="form-control select2bs4" style="width: 100%;">
                    <option value="">-- PILIH SAMPAI --</option>
                  </select>
                </div> -->
              </div>

              <div class="col-md-6">
                <div class="card">
                  <div class="card-header bg-info">
                    Peralihan
                  </div>
                  <div class="card-body">
                    <div class="form-group">
                      <div class="col-form-label">
                        <label>
                          STATUS PERALIHAN <span class="text-danger">*</span>
                        </label>
                      </div>
                      <div>
                        <select name="statusperalihan" class="form-control select2bs4" id="statusperalihan">
                          <option value="">-- PILIH STATUS PERALIHAN --</option>
                        </select>
                      </div>
                    </div>
                    <div id="peralihan" hidden>
                      <div class="row">
                        <div class="col-md-3">
                          <div class="form-group">
                            <div class="col-form-label">
                              <label>
                                PERSENTASE <span class="text-danger">*</span>
                              </label>
                            </div>
                            <div class="input-group">
                              <input type="text" name="persentaseperalihan" class="form-control numbernoseparate">
                              <div class="input-group-append">
                                <span class="input-group-text">%</span>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="form-group col-md-6">
                <div class="col-form-label">
                  <label>
                    PELANGGAN <span class="text-danger">*</span></label>
                </div>
                <div>
                  <input type="hidden" name="pelanggan_id">
                  <input type="text" name="pelanggan" class="form-control pelanggan-lookup">
                </div>
              </div>

              <div class="form-group col-md-6">
                <div class="col-form-label">
                  <label>
                    KETERANGAN <span class="text-danger">*</span>
                  </label>
                </div>
                <div>
                  <input type="text" name="keterangan" class="form-control">
                </div>
              </div>
              <div class="form-group col-md-6">
                <div class="col-form-label">
                  <label>
                    CONTAINER <span class="text-danger">*</span>
                  </label>
                </div>
                <div>
                  <input type="hidden" name="container_id">
                  <input type="text" name="container" class="form-control container-lookup">
                </div>
              </div>
              <div class="form-group col-md-6">
                <div class="col-form-label">
                  <label>
                    NO CONT <span class="text-danger">*</span>
                  </label>
                </div>
                <div>
                  <input type="text" name="nocont" class="form-control">
                </div>
              </div>
              <div class="form-group col-md-6">
                <div class="col-form-label">
                  <label>
                    NO CONT 2 <span class="text-danger">*</span>
                  </label>
                </div>
                <div>
                  <input type="text" name="nocont2" class="form-control">
                </div>
              </div>
              <div class="form-group col-md-6">
                <div class="col-form-label">
                  <label>
                    STATUS CONTAINER <span class="text-danger">*</span>
                  </label>
                </div>
                <div>
                  <input type="hidden" name="statuscontainer_id">
                  <input type="text" name="statuscontainer" class="form-control statuscontainer-lookup">
                </div>
              </div>

              <div class="form-group col-md-6">
                <div class="col-12 col-md-2 col-form-label">
                  <label>
                    TRADO <span class="text-danger">*</span>
                  </label>
                </div>
                <div>
                  <input type="hidden" name="trado_id">
                  <input type="text" name="trado" class="form-control trado-lookup">
                </div>
              </div>
              <div class="form-group col-md-6">
                <div class="col-form-label">
                  <label>
                    SUPIR <span class="text-danger">*</span>
                  </label>
                </div>
                <div>
                  <input type="hidden" name="supir_id">
                  <input type="text" name="supir" class="form-control supir-lookup">
                </div>
              </div>
              <div class="form-group col-md-6">
                <div class="col-12 col-md-2 col-form-label">
                  <label>
                    AGEN <span class="text-danger">*</span>
                  </label>
                </div>
                <div>
                  <input type="hidden" name="agen_id">
                  <input type="text" name="agen" class="form-control agen-lookup">
                </div>
              </div>
              <div class="form-group col-md-6">
                <div class="col-form-label">
                  <label>
                    JENIS ORDER <span class="text-danger">*</span>
                  </label>
                </div>
                <div>
                  <input type="hidden" name="jenisorder_id">
                  <input type="text" name="jenisorder" class="form-control jenisorder-lookup">
                </div>
              </div>
              <div class="form-group col-md-6">
                <div class="col-form-label">
                  <label>
                    NO JOB <span class="text-danger">*</span>
                  </label>
                </div>
                <div>
                  <input type="text" name="nojob" class="form-control">
                </div>
              </div>
              <div class="form-group col-md-6">
                <div class="col-form-label">
                  <label>
                    NO JOB 2 <span class="text-danger">*</span>
                  </label>
                </div>
                <div>
                  <input type="text" name="nojob2" class="form-control">
                </div>
              </div>

              <div class="form-group col-md-6">
                <div class="col-form-label">
                  <label>
                    TARIF <span class="text-danger">*</span>
                  </label>
                </div>
                <div>
                  <input type="hidden" name="tarif_id">
                  <input type="text" name="tarif" class="form-control tarif-lookup">
                </div>
              </div>
            </div>

            <div class="card">
              <div class="card-header bg-info">
                Biaya
              </div>
              <div class="card-body">
                <div class="row form-group">
                  <div class="col-12 col-md-2 col-form-label">
                    <label>
                      GAJI SUPIR <span class="text-danger">*</span>
                    </label>
                  </div>
                  <div class="col-12 col-md-10">
                    <input type="text" name="gajisupir" id="gajisupir" class="form-control" readonly>
                  </div>
                </div>
                <div class="row form-group">
                  <div class="col-12 col-md-2 col-form-label">
                    <label>
                      GAJI KENEK <span class="text-danger">*</span>
                    </label>
                  </div>
                  <div class="col-12 col-md-10">
                    <input type="text" name="gajikenek" id="gajikenek" class="form-control" readonly>
                  </div>
                </div>
                <div class="row form-group">
                  <div class="col-12 col-md-2 col-form-label">
                    <label>
                      KOMISI SUPIR <span class="text-danger">*</span>
                    </label>
                  </div>
                  <div class="col-12 col-md-10">
                    <input type="text" name="komisisupir" id="komisisupir" class="form-control" readonly>
                  </div>
                </div>
                <!-- <div class="row form-group">
                <div class="col-12 col-md-2 col-form-label">
                    <label>
                      KOMISI SUPIR <span class="text-danger">*</span>
                    </label>
                  </div>
                  <div class="col-12 col-md-10">
                    <input type="text" name="komisisupir" id="komisisupir" class="form-control" readonly>
                  </div>
                </div> -->

                <h3 class="text-center">Biaya Tambahan</h3>

                <div class="row">
                  <div class="col-12">
                    <div class="table-responsive">
                      <table id="detailList" class="table table-bordered table-bindkeys">
                        <thead>
                          <tr>
                            <th width="50">No</th>
                            <th>Keterangan</th>
                            <th>Nominal</th>
                            <th>Aksi</th>
                          </tr>
                        </thead>
                        <tbody class="form-group">
                        </tbody>
                        <tfoot>
                          <tr>
                            <td colspan="2">
                              <p class="text-right font-weight-bold">TOTAL :</p>
                            </td>
                            <td>
                              <p class="text-right font-weight-bold autonumeric" id="total"></p>
                            </td>
                            <td>
                              <button type="button" class="btn btn-primary btn-sm my-2" id="addRow">TAMBAH</button>
                            </td>
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
  $(document).ready(function() {

    $("#addRow").click(function() {
      addRow()
    });

    $(document).on('click', '.delete-row', function(event) {
      deleteRow($(this).parents('tr'))
    })

    $(document).on('input', `#detailList [name="nominal[]"]`, function(event) {
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

      $('#crudForm').find(`[name="nominal[]"]`).each((index, element) => {
        data.filter((row) => row.name === 'nominal[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominal[]"]`)[index])
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

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}suratpengantar`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}suratpengantar/${Id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}suratpengantar/${Id}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}suratpengantar`
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

  function setTotal() {
    let nominalDetails = $(`#detailList [name="nominal[]"]`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });

    new AutoNumeric('#total').set(total)
  }

  function createSuratPengantar() {
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.data('action', 'add')
    // form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create Surat Pengantar')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    setStatusLongTripOptions(form)
    setStatusPeralihanOptions(form)

    addRow()
    setTotal()
  }

  function editSuratPengantar(id) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Surat Pengantar')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusLongTripOptions(form),
        setStatusPeralihanOptions(form),
      ])
      .then(() => {
        showSuratPengantar(form, id)
      })
  }

  function deleteSuratPengantar(id) {
    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Surat Pengantar')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusLongTripOptions(form),
        setStatusPeralihanOptions(form),
      ])
      .then(() => {
        showSuratPengantar(form, id)
      })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}suratpengantar/field_length`,
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

  const setStatusPeralihanOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusperalihan]').empty()
      relatedForm.find('[name=statusperalihan]').append(
        new Option('-- PILIH STATUS PERALIHAN --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}parameter`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          filters: JSON.stringify({
            "groupOp": "AND",
            "rules": [{
              "field": "grp",
              "op": "cn",
              "data": "STATUS PERALIHAN"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusPeralihan => {
            let option = new Option(statusPeralihan.text, statusPeralihan.id)

            relatedForm.find('[name=statusperalihan]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  const setStatusLongTripOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statuslongtrip]').empty()
      relatedForm.find('[name=statuslongtrip]').append(
        new Option('-- PILIH STATUS LONG TRIPS --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}parameter`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          filters: JSON.stringify({
            "groupOp": "AND",
            "rules": [{
              "field": "grp",
              "op": "cn",
              "data": "STATUS LONGTRIP"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusLongTrip => {
            let option = new Option(statusLongTrip.text, statusLongTrip.id)

            relatedForm.find('[name=statuslongtrip]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  function getGaji() {
    let form = $('#crudForm')
    let data = []
    data.push({
      name: 'dari',
      value: form.find(`[name="dari_id"]`).val()
    })
    data.push({
      name: 'sampai',
      value: form.find(`[name="sampai_id"]`).val()
    })
    data.push({
      name: 'container',
      value: form.find(`[name="container_id"]`).val()
    })
    data.push({
      name: 'statuscontainer',
      value: form.find(`[name="statuscontainer_id"]`).val()
    })

    $.ajax({
      url: `${apiUrl}suratpengantar/getGaji`,
      method: 'GET',
      dataType: 'JSON',
      data: data,
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        
      }
    })
  }

  function showSuratPengantar(form, userId) {
    $('#detailList tbody').html('')

    $.ajax({
      url: `${apiUrl}suratpengantar/${userId}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        $.each(response.data, (index, value) => {
          let element = form.find(`[name="${index}"]`)

          if (element.is('select')) {
            element.val(value).trigger('change')
          } else if (element.hasClass('datepicker')) {
            element.val(dateFormat(value))
          } else if (element.hasClass('autonumeric')) {
            let autoNumericInput = AutoNumeric.getAutoNumericElement(element[0])

            autoNumericInput.set(value);
          } else {
            element.val(value)
          }
        })
        $.each(response.detail, (index, detail) => {
          let detailRow = $(`
                    <tr>
                      <td></td>
                      <td>
                        <input type="text" name="keterangan_detail[]" class="form-control">
                      </td>
                      <td>
                        <input type="text" name="nominal[]" class="form-control autonumeric">
                      </td>
                      <td>
                        <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
                      </td>
                    </tr>
                  `)

          detailRow.find(`[name="keterangan_detail[]"]`).val(detail.keterangan)

          detailRow.find(`[name="nominal[]"]`).val(detail.nominal)
          $('#detailList tbody').append(detailRow)

          initAutoNumeric(detailRow.find('.autonumeric'))

          $('#detailList tbody').append(detailRow)

          $('#lookup').hide()

          setTotal()

        })
        setRowNumbers()

        if (form.data('action') === 'delete') {
          form.find('[name]').addClass('disabled')
          initDisabled()
        }
      }
    })
  }

  function addRow() {
    let detailRow = $(`
      <tr>
        <td></td>
        <td>
          <input type="text" name="keterangan_detail[]" class="form-control">
        </td>
        <td>
          <input type="text" name="nominal[]" class="form-control autonumeric">
        </td>
        <td>
          <button type="button" class="btn btn-danger btn-sm delete-row">Hapus</button>
        </td>
      </tr>
    `)

    $('#detailList tbody').append(detailRow)

    initAutoNumeric(detailRow.find('.autonumeric'))
    setRowNumbers()
  }

  function deleteRow(row) {
    row.remove()

    setRowNumbers()
  }

  function setRowNumbers() {
    let elements = $('#detailList tbody tr td:nth-child(1)')

    elements.each((index, element) => {
      $(element).text(index + 1)
    })
  }

  function initLookup() {
    $('.kotadari-lookup').lookup({
      title: 'Kota Dari Lookup',
      fileName: 'kota',
      onSelectRow: (kota, element) => {
        $('#crudForm [name=dari_id]').first().val(kota.id)
        element.val(kota.keterangan)
        element.data('currentValue', element.val())
        getGaji()
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      }
    })

    $('.kotasampai-lookup').lookup({
      title: 'Kota Tujuan Lookup',
      fileName: 'kota',
      onSelectRow: (kota, element) => {
        $('#crudForm [name=sampai_id]').first().val(kota.id)
        element.val(kota.keterangan)
        element.data('currentValue', element.val())
        getGaji()
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      }
    })

    $('.pelanggan-lookup').lookup({
      title: 'Pelanggan Lookup',
      fileName: 'pelanggan',
      onSelectRow: (pelanggan, element) => {
        $('#crudForm [name=pelanggan_id]').first().val(pelanggan.id)
        element.val(pelanggan.namapelanggan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      }
    })
    
    $('.container-lookup').lookup({
      title: 'Container Lookup',
      fileName: 'container',
      onSelectRow: (container, element) => {
        $('#crudForm [name=container_id]').first().val(container.id)
        element.val(container.keterangan)
        element.data('currentValue', element.val())
        getGaji()
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      }
    })


    $('.statuscontainer-lookup').lookup({
      title: 'Status Container Lookup',
      fileName: 'statuscontainer',
      onSelectRow: (statuscontainer, element) => {
        $('#crudForm [name=statuscontainer_id]').first().val(statuscontainer.id)
        element.val(statuscontainer.keterangan)
        element.data('currentValue', element.val())
        getGaji()
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      }
    })

    $('.trado-lookup').lookup({
      title: 'Trado Lookup',
      fileName: 'trado',
      onSelectRow: (trado, element) => {
        $('#crudForm [name=trado_id]').first().val(trado.id)
        element.val(trado.keterangan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      }
    })
    $('.supir-lookup').lookup({
      title: 'Supir Lookup',
      fileName: 'supir',
      onSelectRow: (supir, element) => {
        $('#crudForm [name=supir_id]').first().val(supir.id)
        element.val(supir.namasupir)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      }
    })
    $('.agen-lookup').lookup({
      title: 'Agen Lookup',
      fileName: 'agen',
      onSelectRow: (agen, element) => {
        $('#crudForm [name=agen_id]').first().val(agen.id)
        element.val(agen.namaagen)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      }
    })

    $('.jenisorder-lookup').lookup({
      title: 'Jenis Order Lookup',
      fileName: 'jenisorder',
      onSelectRow: (jenisorder, element) => {
        $('#crudForm [name=jenisorder_id]').first().val(jenisorder.id)
        element.val(jenisorder.keterangan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      }
    })

    $('.tarif-lookup').lookup({
      title: 'Tarif Lookup',
      fileName: 'tarif',
      onSelectRow: (tarif, element) => {
        $('#crudForm [name=tarif_id]').first().val(tarif.id)
        element.val(tarif.tujuan)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      }
    })
  }

  // function setDummyOption() {
  //   fetch(`http://dummy.test/server/`)
  //     .then(response => {
  //       console.log(response);
  //     })

  // $.ajax({
  //   url: `http://dummy.test/server/`,
  //   method: 'GET',
  //   dataType: 'JSON',
  //   headers: {
  //     Authorization: `Bearer ${accessToken}`
  //   },
  //   success: response => {
  //     console.log(response);
  //   }
  // })
  // }
</script>
@endpush()