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

            {{-- <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">ID</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="id" class="form-control" readonly>
              </div>
            </div> --}}
            <input type="text" name="id" class="form-control" hidden>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  KODE ALATBAYAR <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="kodealatbayar" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  NAMA ALATBAYAR <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="namaalatbayar" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  KETERANGAN
                </label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="keterangan" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  STATUS LANGSUNG CAIR <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="statuslangsungcair">
                <input type="text" name="statuslangsungcairnama" id="statuslangsungcairnama" class="form-control lg-form statuslangsungcair-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  STATUS DEFAULT <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="statusdefault">
                <input type="text" name="statusdefaultnama" id="statusdefaultnama" class="form-control lg-form statusdefault-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  Status Aktif <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="statusaktif">
                <input type="text" name="statusaktifnama" id="statusaktifnama" class="form-control lg-form statusaktif-lookup">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  BANK <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="bank_id">
                <input type="text" id="bank" name="bank" class="form-control bank-lookup">
              </div>
            </div>
            {{-- <div class="row form-group">
              <div class="col-12 col-md-2">
                <label class="col-form-label">
                  KODE PERKIRAAN <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-md-10">
                <input type="hidden" name="coa">
                <input type="text" name="keterangancoa" class="form-control coa-lookup">
              </div>
            </div>
            --}}
          </div>
          <div class="modal-footer justify-content-start">
            <button id="btnSubmit" class="btn btn-primary">
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
  let hasFormBindKeys = false
  let modalBody = $('#crudModal').find('.modal-body').html()
  let dataMaxLength = []
  var data_id

  $(document).ready(function() {
    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let alatBayarId = form.find('[name=id]').val()
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
        name: 'info',
        value: info
      })
      data.push({
        name: 'accessTokenTnl',
        value: accessTokenTnl
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
          url = `${apiUrl}alatbayar`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}alatbayar/${alatBayarId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}alatbayar/${alatBayarId}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}alatbayar`
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

  $('#crudModal').on('shown.bs.modal', () => {
    let form = $('#crudForm')
    data_id = $('#crudForm').find('[name=id]').val();
    setFormBindKeys(form)

    activeGrid = null

    form.find('#btnSubmit').prop('disabled', false)
    if (form.data('action') == "view") {
      form.find('#btnSubmit').prop('disabled', true)
    }

    initLookup()
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    removeEditingBy(data_id)
    $('#crudModal').find('.modal-body').html(modalBody)
  })

  function removeEditingBy(id) {
    $.ajax({
      url: `{{ config('app.api_url') }}bataledit`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        id: id,
        aksi: 'BATAL',
        table: 'alatbayar'

      },
      success: response => {
        $("#crudModal").modal("hide")
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
    })
  }

  function createAlatBayar() {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Add Alat Bayar')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        // setLangsungCairOptions(form),
        // setDefaultOptions(form),
        // setStatusAktifOptions(form),
        getMaxLength(form)
      ])
      .then(() => {
        showDefault(form)
          .then(() => {
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            $('#crudModal').modal('show')
          })
          .catch((error) => {
            showDialog(error.statusText)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })

  }

  function editAlatBayar(alatBayarId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Alat Bayar')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        // setLangsungCairOptions(form),
        // setDefaultOptions(form),
        // setStatusAktifOptions(form),
        getMaxLength(form)
      ])
      .then(() => {
        showAlatBayar(form, alatBayarId)
          .then(() => {
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            $('#crudModal').modal('show')
          })
          .catch((error) => {
            showDialog(error.statusText)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  function deleteAlatBayar(alatBayarId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-trash"></i>
              Delete
    `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Alat Bayar')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        // setLangsungCairOptions(form),
        // setDefaultOptions(form),
        // setStatusAktifOptions(form),
        getMaxLength(form)
      ])
      .then(() => {
        showAlatBayar(form, alatBayarId)
          .then(() => {
            if (selectedRows.length > 0) {
              clearSelectedRows()
            }
            $('#crudModal').modal('show')
          })
          .catch((error) => {
            showDialog(error.statusText)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  function viewAlatBayar(alatBayarId) {
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
    $('#crudModalTitle').text('Delete Alat Bayar')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        // setLangsungCairOptions(form),
        // setDefaultOptions(form),
        // setStatusAktifOptions(form),
        getMaxLength(form)
      ])
      .then(() => {
        showAlatBayar(form, alatBayarId)
          .then(alatBayarId => {
            // form.find('.aksi').hide()
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
            let name = $('#crudForm').find(`[name]`).parents('.input-group').children()
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

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      return new Promise((resolve, reject) => {

        $.ajax({
          url: `${apiUrl}alatbayar/field_length`,
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

            dataMaxLength = response.data
            form.attr('has-maxlength', true)
            resolve()
          },
          error: error => {
            showDialog(error.statusText)
            reject()
          }
        })
      })
    } else {
      return new Promise((resolve, reject) => {
        $.each(dataMaxLength, (index, value) => {
          if (value !== null && value !== 0 && value !== undefined) {
            form.find(`[name=${index}]`).attr('maxlength', value)

          }
        })
        resolve()
      })
    }
  }



  // const setStatusAktifOptions = function(relatedForm) {
  //   return new Promise((resolve, reject) => {
  //     relatedForm.find('[name=statusaktif]').empty()
  //     relatedForm.find('[name=statusaktif]').append(
  //       new Option('-- PILIH STATUS AKTIF --', '', false, true)
  //     ).trigger('change')

  //     $.ajax({
  //       url: `${apiUrl}parameter`,
  //       method: 'GET',
  //       dataType: 'JSON',
  //       headers: {
  //         Authorization: `Bearer ${accessToken}`
  //       },
  //       data: {
  //         filters: JSON.stringify({
  //           "groupOp": "AND",
  //           "rules": [{
  //             "field": "grp",
  //             "op": "cn",
  //             "data": "STATUS AKTIF"
  //           }]
  //         })
  //       },
  //       success: response => {
  //         response.data.forEach(statusAktif => {
  //           let option = new Option(statusAktif.text, statusAktif.id)

  //           relatedForm.find('[name=statusaktif]').append(option).trigger('change')
  //         });

  //         resolve()
  //       },
  //       error: error => {
  //         reject(error)
  //       }
  //     })
  //   })
  // }

  // const setDefaultOptions = function(relatedForm) {
  //   return new Promise((resolve, reject) => {
  //     relatedForm.find('[name=statusdefault]').empty()
  //     relatedForm.find('[name=statusdefault]').append(
  //       new Option('-- PILIH STATUS DEFAULT --', '', false, true)
  //     ).trigger('change')

  //     $.ajax({
  //       url: `${apiUrl}parameter`,
  //       method: 'GET',
  //       dataType: 'JSON',
  //       headers: {
  //         Authorization: `Bearer ${accessToken}`
  //       },
  //       data: {
  //         filters: JSON.stringify({
  //           "groupOp": "AND",
  //           "rules": [{
  //             "field": "grp",
  //             "op": "cn",
  //             "data": "STATUS DEFAULT"
  //           }]
  //         })
  //       },
  //       success: response => {
  //         response.data.forEach(statusDefault => {
  //           if (statusDefault.grp == 'STATUS DEFAULT') {

  //             let option = new Option(statusDefault.text, statusDefault.id)

  //             relatedForm.find('[name=statusdefault]').append(option).trigger('change')
  //           }
  //         });

  //         resolve()
  //       },
  //       error: error => {
  //         reject(error)
  //       }
  //     })
  //   })
  // }

  // const setLangsungCairOptions = function(relatedForm) {
  //   return new Promise((resolve, reject) => {
  //     relatedForm.find('[name=statuslangsungcair]').empty()
  //     relatedForm.find('[name=statuslangsungcair]').append(
  //       new Option('-- PILIH STATUS LANGSUNG CAIR --', '', false, true)
  //     ).trigger('change')

  //     $.ajax({
  //       url: `${apiUrl}parameter`,
  //       method: 'GET',
  //       dataType: 'JSON',
  //       headers: {
  //         Authorization: `Bearer ${accessToken}`
  //       },
  //       data: {
  //         filters: JSON.stringify({
  //           "groupOp": "AND",
  //           "rules": [{
  //             "field": "grp",
  //             "op": "cn",
  //             "data": "STATUS LANGSUNG CAIR"
  //           }]
  //         })
  //       },
  //       success: response => {
  //         response.data.forEach(statusLangsunggCair => {
  //           let option = new Option(statusLangsunggCair.text, statusLangsunggCair.id)

  //           relatedForm.find('[name=statuslangsungcair]').append(option).trigger('change')
  //         });
  //         resolve()
  //       },
  //       error: error => {
  //         reject(error)
  //       }
  //     })
  //   })
  // }

  function showDefault(form) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}alatbayar/default`,
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

  function showAlatBayar(form, alatBayarId) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}alatbayar/${alatBayarId}`,
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
            } else {
              element.val(value)
            }
            if (index == 'bank') {
              element.data('current-value', value)
            }
            if (index == 'keterangancoa') {
              element.data('current-value', value)
            }
            if (index == 'statuslansungcairnama') {
              element.data('current-value', value)
            }
            if (index == 'statusdefaultnama') {
              element.data('current-value', value)
            }
            if (index == 'statusaktifnama') {
              element.data('current-value', value)
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

  function initLookup() {
    // $('.bank-lookup').lookup({
    //   title: 'Bank Lookup',
    //   fileName: 'bank',
    //   onSelectRow: (bank, element) => {
    //     $('#crudForm [name=bank_id]').first().val(bank.id)
    //     element.val(bank.namabank)
    //     element.data('currentValue', element.val())
    //   },
    //   onCancel: (element) => {
    //     element.val(element.data('currentValue'))
    //   },
    //   onClear: (element) => {
    //     $('#crudForm [name=bank_id]').first().val('')
    //     element.val('')
    //     element.data('currentValue', element.val())
    //   }
    // })

    $('.bank-lookup').lookupMaster({
      title: 'Bank Lookup',
      fileName: 'bankMaster',
      typeSearch: 'ALL',
      searching: 1,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          searching: 1,
          valueName: 'bank_id',
          searchText: 'bank-lookup',
          title: 'Bank Lookup',
          typeSearch: 'ALL',
        }
      },
      onSelectRow: (bank, element) => {
        $('#crudForm [name=bank_id]').first().val(bank.id)
        element.val(bank.namabank)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=bank_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    
    $('.coa-lookup').lookup({
      title: 'COA Lookup',
      fileName: 'akunpusat',
      onSelectRow: (coa, element) => {
        $('#crudForm [name=coa]').first().val(coa.coa)
        element.val(coa.keterangancoa)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=coa]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $(`.statuslangsungcair-lookup`).lookupMaster({
      title: 'Status Lansung Cair Lookup',
      fileName: 'parameterMaster',
      typeSearch: 'ALL',
      searching: 1,
      beforeProcess: function() {
        this.postData = {
          url: `${apiUrl}parameter/combo`,
          grp: 'STATUS LANGSUNG CAIR',
          subgrp: 'STATUS LANGSUNG CAIR',
          searching: 1,
          valueName: `statuslansungcair`,
          searchText: `statuslansungcair-lookup`,
          singleColumn: true,
          hideLabel: true,
          title: 'Status Lansung Cair',
        };
      },
      onSelectRow: (statuslansungcair, element) => {
        $('#crudForm [name=statuslansungcair]').first().val(statuslansungcair.id)
        element.val(statuslansungcair.text)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'));
      },
      onClear: (element) => {
        let status_id_input = element.parents('td').find(`[name="statuslansungcair"]`).first();
        status_id_input.val('');
        element.val('');
        element.data('currentValue', element.val());
      },
    });

    $(`.statusdefault-lookup`).lookupMaster({
      title: 'Status Default Lookup',
      fileName: 'parameterMaster',
      typeSearch: 'ALL',
      searching: 1,
      beforeProcess: function() {
        this.postData = {
          url: `${apiUrl}parameter/combo`,
          grp: 'STATUS DEFAULT',
          subgrp: 'STATUS DEFAULT',
          searching: 1,
          valueName: `statusdefault`,
          searchText: `statusdefault-lookup`,
          singleColumn: true,
          hideLabel: true,
          title: 'Status Default'
        };
      },
      onSelectRow: (statusdefault, element) => {
        $('#crudForm [name=statusdefault]').first().val(statusdefault.id)
        element.val(statusdefault.text)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'));
      },
      onClear: (element) => {
        let status_id_input = element.parents('td').find(`[name="statusdefault"]`).first();
        status_id_input.val('');
        element.val('');
        element.data('currentValue', element.val());
      },
    });

    $(`.statusaktif-lookup`).lookupMaster({
      title: 'Status Aktif Lookup',
      fileName: 'parameterMaster',
      typeSearch: 'ALL',
      searching: 1,
      beforeProcess: function() {
        this.postData = {
          url: `${apiUrl}parameter/combo`,
          grp: 'STATUS AKTIF',
          subgrp: 'STATUS AKTIF',
          searching: 1,
          valueName: `statusaktif`,
          searchText: `statusaktif-lookup`,
          singleColumn: true,
          hideLabel: true,
          title: 'Status Aktif'
        };
      },
      onSelectRow: (status, element) => {
        $('#crudForm [name=statusaktif]').first().val(status.id)
        element.val(status.text)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'));
      },
      onClear: (element) => {
        let status_id_input = element.parents('td').find(`[name="statusaktif"]`).first();
        status_id_input.val('');
        element.val('');
        element.data('currentValue', element.val());
      },
    });
  }

  function cekValidasidelete(Id, aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}alatbayar/${Id}/cekValidasi`,
      method: 'POST',
      dataType: 'JSON',
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      data: {
        aksi: aksi,
      },
      success: response => {
        // var kondisi = response.kondisi
        // if (kondisi == true) {
        //   showDialog(response.message['keterangan'])
        // } else {
        //   deleteAlatBayar(Id)
        // }

        var error = response.error
        if (error == true) {
          showDialog(response.message)
        } else {
          if (aksi == "edit") {
            editAlatBayar(Id)
          } else if (aksi == "delete") {
            deleteAlatBayar(Id)
          }
        }



      }
    })
  }
</script>
@endpush()