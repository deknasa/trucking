<div class="modal modal-fullscreen" id="crudModalRitasi" tabindex="-1" aria-labelledby="crudModalRitasiLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="crudFormRitasi">
      <div class="modal-content">
        <div class="modal-header">
          <p class="modal-title" id="crudModalRitasiTitle"></p>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          </button>
        </div>

        <form action="" method="post">
          <div class="modal-body">
            <input type="hidden" name="id" class="form-control" readonly>
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
                  TGL TRIP <span class="text-danger">*</span>
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
                  STATUS RITASI <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="statusritasi_id">
                <input type="text" name="statusritasi" id="dataritasi" class="form-control dataritasi-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  SURAT PENGANTAR</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="suratpengantar_nobukti" class="form-control suratpengantar-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  DARI <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="dari_id">
                <input type="text" name="dari" id="dari" class="form-control dari-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  SAMPAI <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="sampai_id">
                <input type="text" name="sampai" id="sampai" class="form-control sampai-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  TRADO <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="trado_id">
                <input type="text" name="trado" id="trado" class="form-control trado-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  SUPIR <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="supir_id">
                <input type="text" name="supir" id="supir" class="form-control supir-lookup">
              </div>
            </div>
          </div>
          <div class="modal-footer justify-content-start">
            <button id="btnSubmitRitasi" class="btn btn-primary">
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
  let hasFormBindKeysRitasi = false
  let modalBodyRitasi = $('#crudModalRitasi').find('.modal-body').html()
  let tradoLookup = ''
  let supirLookup = ''
  $(document).ready(function() {
    $('#btnSubmitRitasi').click(function(event) {
      event.preventDefault()
      submitRitasi($(this).attr('id'))
    })
    $('#btnSaveAdd').click(function(event) {
      event.preventDefault()
      submitRitasi($(this).attr('id'))
    })

    function submitRitasi(button) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudFormRitasi')
      let ritasiId = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudFormRitasi').serializeArray()

      data.push({
        name: 'supirheader',
        value: $('#supirheader_id').val()
      })
      data.push({
        name: 'tgldariheader',
        value: $('#tgldariheader').val()
      })
      data.push({
        name: 'tglsampaiheader',
        value: $('#tglsampaiheader').val()
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
        value: limit
      })
      data.push({
        name: 'button',
        value: button
      })

      let tgldariheader = $('#tgldariheader').val();
      let tglsampaiheader = $('#tglsampaiheader').val()

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}ritasi`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}ritasi/${ritasiId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}ritasi/${ritasiId}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}ritasi`
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
          $('#crudFormRitasi').trigger('reset')
          if (button == 'btnSubmitRitasi') {
            $('#crudModalRitasi').modal('hide')
            id = response.data.position
            // $('#rangeHeader').find('[name=tgldariheader]').val(dateFormat(response.data.tgldariheader)).trigger('change');
            // $('#rangeHeader').find('[name=tglsampaiheader]').val(dateFormat(response.data.tglsampaiheader)).trigger('change');
            $('#jqGrid').jqGrid('setGridParam', {
              page: response.data.page,
              postData: {
                tgldari: $('#tgldariheader').val(),
                tglsampai: $('#tglsampaiheader').val(),
                supirheader: $('#supirheader_id').val(),
                proses: 'reload'
              }
            }).trigger('reloadGrid');
            if (response.data.grp == 'FORMAT') {
              updateFormat(response.data)
            }
          } else {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
            $('#crudFormRitasi').find('input[type="text"]').data('current-value', '')
            // showSuccessDialog(response.message, response.data.nobukti)
            createRitasi()
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

  $('#crudModalRitasi').on('shown.bs.modal', () => {
    let form = $('#crudFormRitasi')

    setFormBindKeys(form)

    activeGrid = null

    getMaxLengthRitasi(form)
    initLookupRitasi()
    form.find('#btnSubmitRitasi').prop('disabled', false)
    if (form.data('action') == "view") {
      form.find('#btnSubmitRitasi').prop('disabled', true)
    }

    if (form.data('action') == 'add') {
      form.find('#btnSaveAdd').show()
    } else {
      form.find('#btnSaveAdd').hide()
    }
    initDatepicker()
    initSelect2(form.find('.select2bs4'), true)
  })

  $('#crudModalRitasi').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    removeEditingByRitasi($('#crudFormRitasi').find('[name=id]').val())
    $('#crudModalRitasi').find('.modal-body').html(modalBodyRitasi)
    $('#crudModal').find('.modal-body').html(modalBody)
    tradoLookup = ''
    supirLookup = ''
    initDatepicker('datepickerIndex')
  })

  function removeEditingByRitasi(id) {
    let formData = new FormData();


    formData.append('id', id);
    formData.append('aksi', 'BATAL');
    formData.append('table', 'ritasi');

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
        $("#crudModalRitasi").modal("hide");
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

  function createRitasi() {
    let form = $('#crudFormRitasi')

    $('.modal-loader').removeClass('d-none')

    form.trigger('reset')
    form.find('#btnSubmitRitasi').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.data('action', 'add')
    $('#crudModalRitasi').modal('show')
    form.find(`.sometimes`).show()
    $('#crudModalRitasiTitle').text('Add Ritasi')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    $('#crudFormRitasi').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    $('.modal-loader').addClass('d-none')

  }

  function editRitasi(ritasiId) {
    let form = $('#crudFormRitasi')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmitRitasi').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalRitasiTitle').text('Edit Ritasi')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusRitasiOptions(form)
      ])
      .then(() => {
        showRitasi(form, ritasiId)
          .then(() => {
            $('#crudModalRitasi').modal('show')
            $('#crudFormRitasi [name=tglbukti]').attr('readonly', true)
            $('#crudFormRitasi [name=tglbukti]').siblings('.input-group-append').remove()
          })
          .catch((error) => {
            showDialog(error.statusText)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  function deleteRitasi(ritasiId) {
    let form = $('#crudFormRitasi')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmitRitasi').html(`
    <i class="fa fa-trash"></i>
    Delete
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalRitasiTitle').text('Delete Ritasi')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusRitasiOptions(form)
      ])
      .then(() => {
        showRitasi(form, ritasiId)
          .then(() => {
            $('#crudModalRitasi').modal('show')
          })
          .catch((error) => {
            showDialog(error.statusText)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  function viewRitasi(ritasiId) {
    let form = $('#crudFormRitasi')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'view')
    form.trigger('reset')
    form.find('#btnSubmitRitasi').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.find(`.sometimes`).hide()
    $('#crudModalRitasiTitle').text('View Ritasi')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setStatusRitasiOptions(form)
      ])
      .then(() => {
        showRitasi(form, ritasiId)
          .then(() => {
            $('#crudModalRitasi').modal('show')
            form.find(`.hasDatepicker`).prop('readonly', true)
            form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').remove()
            let name = $('#crudFormRitasi').find(`[name]`).parents('.input-group').children()
            name.attr('disabled', true)
            name.find('.lookup-toggler').attr('disabled', true)
          })
          .catch((error) => {
            showDialog(error.statusText)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  function showDefaultRitasi(form) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}ritasi/default`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $.each(response.data, (index, value) => {
            console.log(value)
            let element = form.find(`[name="${index}"]`)
            // let element = form.find(`[name="statusaktif"]`)

            if (element.is('select')) {
              element.val(value).trigger('change')
            } else {
              element.val(value)
            }
          })
          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function getMaxLengthRitasi(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}ritasi/field_length`,
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

  const setStatusRitasiOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusritasi]').empty()
      relatedForm.find('[name=statusritasi]').append(
        new Option('-- PILIH STATUS RITASI --', '', false, true)
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
              "data": "STATUS RITASI"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusRitasi => {
            let option = new Option(statusRitasi.text, statusRitasi.id)

            relatedForm.find('[name=statusritasi]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function showRitasi(form, ritasiId) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}ritasi/${ritasiId}`,
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
            } else {
              element.val(value)
            }

            if (index == 'suratpengantar_nobukti') {
              element.data('current-value', value)
            }
            if (index == 'dari') {
              element.data('current-value', value)
            }
            if (index == 'sampai') {
              element.data('current-value', value)
            }
            if (index == 'trado') {
              element.data('current-value', value)
            }
            if (index == 'supir') {
              element.data('current-value', value)
            }
            if (index == 'statusritasi') {
              element.data('current-value', value)
            }
          })
          if (response.data.suratpengantar_nobukti != null) {
            tradoLookup = response.data.trado_id
            supirLookup = response.data.supir_id
          }

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

  function initLookupRitasi() {
    $('.suratpengantar-lookup').lookup({
      title: 'Surat Pengantar Lookup',
      fileName: 'suratpengantar',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
          from: 'ritasi',
          tglbukti: $('#crudFormRitasi [name=tglbukti]').val()
        }
      },
      onSelectRow: (suratpengantar, element) => {
        element.val(suratpengantar.nobukti)
        $('#crudFormRitasi [name=trado_id]').val('')
        $('#crudFormRitasi [name=trado]').val('').data('currentValue', '')
        $('#crudFormRitasi [name=supir_id]').val('')
        $('#crudFormRitasi [name=supir]').val('').data('currentValue', '')
        tradoLookup = suratpengantar.tradolookup
        supirLookup = suratpengantar.supirlookup
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        element.data('currentValue', element.val())
        $('#crudFormRitasi [name=trado_id]').val('')
        $('#crudFormRitasi [name=trado]').val('').data('currentValue', '')
        $('#crudFormRitasi [name=supir_id]').val('')
        $('#crudFormRitasi [name=supir]').val('').data('currentValue', '')
        tradoLookup = ''
        supirLookup = ''
      }
    })
    $('.dari-lookup').lookupV3({
      title: 'Dari Lookup',
      fileName: 'kotaV3',
      labelColumn: false,
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (kota, element) => {
        $('#crudFormRitasi [name=dari_id]').first().val(kota.id)
        element.val(kota.kodekota)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudFormRitasi [name=dari_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.sampai-lookup').lookupV3({
      title: 'Sampai Lookup',
      fileName: 'kotaV3',
      labelColumn: false,
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (kota, element) => {
        $('#crudFormRitasi [name=sampai_id]').first().val(kota.id)
        element.val(kota.kodekota)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudFormRitasi [name=sampai_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.trado-lookup').lookupV3({
      title: 'Trado Lookup',
      fileName: 'tradoV3',
      labelColumn: false,
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
          trado_id: tradoLookup
        }
      },
      onSelectRow: (trado, element) => {
        $('#crudFormRitasi [name=trado_id]').first().val(trado.id)
        element.val(trado.kodetrado)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudFormRitasi [name=trado_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.supir-lookup').lookupV3({
      title: 'Supir Lookup',
      fileName: 'supirV3',
      labelColumn: false,
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
          supir_id: supirLookup
        }
      },
      onSelectRow: (supir, element) => {
        $('#crudFormRitasi [name=supir_id]').first().val(supir.id)
        element.val(supir.namasupir)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudFormRitasi [name=supir_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('.dataritasi-lookup').lookupV3({
      title: 'Data Ritasi Lookup',
      fileName: 'dataritasiv3',
      labelColumn: false,
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (dataRitasi, element) => {
        $('#crudFormRitasi [name=statusritasi_id]').first().val(dataRitasi.id)
        element.val(dataRitasi.statusritasi)
        element.data('currentValue', element.val())
        getKota(dataRitasi.statusritasi_id)
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudFormRitasi [name=statusritasi_id]').first().val('')
        $('#crudFormRitasi [name=dari_id]').first().val('')
        $('#crudFormRitasi [name=dari]').first().val('').data('currentValue', '').attr("readonly", true)
        $('#crudFormRitasi [name=sampai_id]').first().val('')
        $('#crudFormRitasi [name=sampai]').first().val('').data('currentValue', '').attr("readonly", true)
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    // $('.dataritasi-lookup').lookupMaster({
    //   title: 'Data Ritasi Lookup',
    //   fileName: 'dataritasiMaster',
    //   typeSearch: 'ALL',
    //   searching: 1,
    //   beforeProcess: function(test) {
    //     // var levelcoa = $(`#levelcoa`).val();
    //     this.postData = {
    //       title: 'data ritasi',
    //       Aktif: 'AKTIF',
    //       searching: 1,
    //       valueName: 'dataritasi_id',
    //       searchText: 'dataritasi-lookup',
    //       typeSearch: 'ALL',
    //     }
    //   },
    //   onSelectRow: (dataRitasi, element) => {
    //     $('#crudFormRitasi [name=statusritasi_id]').first().val(dataRitasi.id)
    //     element.val(dataRitasi.statusritasi)
    //     element.data('currentValue', element.val())
    //   },
    //   onCancel: (element) => {
    //     element.val(element.data('currentValue'))
    //   },
    //   onClear: (element) => {
    //     $('#crudFormRitasi [name=statusritasi_id]').first().val('')
    //     element.val('')
    //     element.data('currentValue', element.val())
    //   }
    // })

  }

  function cekValidasiRitasi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}ritasi/${Id}/cekvalidasi`,
      method: 'POST',
      dataType: 'JSON',
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      success: response => {
        var error = response.error
        if (error) {
          showDialog(response)
        } else {
          if (Aksi == 'EDIT') {
            editRitasi(Id)
          }
          if (Aksi == 'DELETE') {
            deleteRitasi(Id)
          }
        }

      }
    })
  }

  function getKota(ritasiId) {
    $.ajax({
      url: `${apiUrl}inputtrip/getKotaRitasi`,
      method: 'GET',
      dataType: 'JSON',
      data: {
        dataritasi_id: ritasiId
      },
      headers: {
        'Authorization': `Bearer ${accessToken}`
      },
      success: response => {

        if (response.data.length != 0) {
          $('#crudFormRitasi').find(`[name="dari_id"]`).val(response.data.dari_id)
          $('#crudFormRitasi').find(`[name="dari"]`).val(response.data.dari).data('currentValue', response.data.dari)
          $('#crudFormRitasi').find(`[name="sampai_id"]`).val(response.data.sampai_id)
          $('#crudFormRitasi').find(`[name="sampai"]`).val(response.data.sampai).data('currentValue', response.data.sampai)
          $('#crudFormRitasi').find(`[name="dari"]`).prop('readonly', true)
          $('#crudFormRitasi').find(`[name="sampai"]`).prop('readonly', true)

          let ritDari =   $('#crudFormRitasi').find(`[name="dari"]`).parents('.input-group')
          ritDari.find('.button-clear').attr('disabled', true)
          ritDari.children().find('.lookup-toggler').attr('disabled', true)

          let ritKe =   $('#crudFormRitasi').find(`[name="sampai"]`).parents('.input-group')
          ritKe.find('.button-clear').attr('disabled', true)
          ritKe.children().find('.lookup-toggler').attr('disabled', true)
        } else {


          let ritDari = $('#crudFormRitasi').find(`[name="dari"]`).parents('.input-group')
          ritDari.find('.button-clear').attr('disabled', false)
          ritDari.find('input').attr('readonly', false)
          ritDari.children().find('.lookup-toggler').attr('disabled', false)

          let ritKe = $('#crudFormRitasi').find(`[name="sampai"]`).parents('.input-group')
          ritKe.find('.button-clear').attr('disabled', false)
          ritKe.find('input').attr('readonly', false)
          ritKe.children().find('.lookup-toggler').attr('disabled', false)
        }
      },
      error: error => {
        showDialog(error.statusText)
      }
    })

  }
</script>
@endpush()