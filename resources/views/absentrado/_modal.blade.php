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
                <input type="text" name="id" class="form-control" value="{{ $absenTrado['id'] ?? '' }}" readonly>
          </div>
      </div> --}}
      <input type="text" name="id" class="form-control" hidden>
      <div class="row form-group">
        <div class="col-12 col-md-2">
          <label class="col-form-label">
            KODE ABSEN <span class="text-danger">*</span>
          </label>
        </div>
        <div class="col-12 col-md-10">
          <input type="text" name="kodeabsen" class="form-control" value="{{ $absenTrado['kodeabsen'] ?? '' }}">
        </div>
      </div>
      <div class="row form-group">
        <div class="col-12 col-md-2">
          <label class="col-form-label">
            KETERANGAN
          </label>
        </div>
        <div class="col-12 col-md-10">
          <input type="text" name="keterangan" class="form-control" value="{{ $absenTrado['keterangan'] ?? '' }}">
        </div>
      </div>
      <div class="row form-group">
        <div class="col-12 col-sm-3 col-md-2">
          <label class="col-form-label">
            STATUS AKTIF <span class="text-danger">*</span>
          </label>
        </div>
        <div class="col-12 col-sm-9 col-md-10">
          <input type="hidden" name="statusaktif">
          <input type="text" name="statusaktifnama" data-target-name="statusaktif" id="statusaktifnama" class="form-control lg-form status-lookup">
        </div>
      </div>

      <div class="row form-group">
        <div class="col-12 col-sm-3 col-md-2">
          <label class="col-form-label">
            MEMO
          </label>
        </div>
      </div>

      <div class="table-responsive">
        <table class="table table-bordered table-bindkeys" id="detailList" style="width: 100%;">
          <thead>
            <tr>
              <th width="2%" class="aksi">Aksi</th>
              <th width="46%">Judul</th>
              <th width="46%">Keterangan</th>
            </tr>
          </thead>
          <tbody id="table_body" class="form-group">

          </tbody>
          <tfoot>
            <tr>
              <td class="aksi">
                <div type="button" class="my-1" id="addRow"><span><i class="far fa-plus-square"></i></span></div>
              </td>
              <td colspan="2"></td>
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

  $(document).ready(function() {
    $(document).on('click', "#addRow", function() {
      event.preventDefault()
      let method = `POST`
      let url = `${apiUrl}absentrado/addrow`
      let form = $('#crudForm')
      let Id = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()
      var data_id

      $.ajax({
        url: url,
        method: method,
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

    $('#btnSubmit').click(function(event) {
      event.preventDefault()
      let cekHex
      $('#detailList tbody tr').each(function(row, tr) {
        let key = $(this).find(`[name="key[]"]`).val()
        let value = $(this).find(`[name="value[]"]`).val()
        if (key.toLowerCase() == 'warna') {
          if (value.length < 7) {
            cekHex = value.length;
          }
        }
      })

      if (cekHex < 7) {
        showDialog("value warna harus berjumlah 6 digit dan diawali dengan #")
      }
      let method
      let url
      let form = $('#crudForm')
      let absenTradoId = form.find('[name=id]').val()
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
          url = `${apiUrl}absentrado`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}absentrado/${absenTradoId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}absentrado/${absenTradoId}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}absentrado`
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
            //showDialog(error.responseJSON)
            if (error.responseJSON.errors) {
              showDialog(error.statusText, error.responseJSON.errors.join('<hr>'))
            } else if (error.responseJSON.message) {
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
    data_id = $('#crudForm').find('[name=id]').val();

    form.find('#btnSubmit').prop('disabled', false)
    if (form.data('action') == "view") {
      form.find('#btnSubmit').prop('disabled', true)
    }
    initLookup()
 
    initSelect2(form.find('.select2bs4'), true)
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
        table: 'absentrado'
        
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

  function createAbsenTrado() {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Add Absen Trado')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    $('#table_body').html('')
    addRow()

    Promise
      .all([
        showDefault(form),
        getMaxLength(form)
      ])
      .then(() => {
        $('#crudModal').modal('show')
      })
      .catch((error) => {
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }


  function cekValidasi(Id,Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}absentrado/${Id}/cekValidasi`,
      method: 'POST',
      dataType: 'JSON',
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      data: {
        aksi: Aksi,
      },
      success: response => {
        var kondisi = response.kondisi
        if (kondisi == true) {
          if (!response.editblok) {
            if (Aksi == 'EDIT') {
              editAbsenTrado(Id)
            } else {
              showDialog(response.message)
            }
          }else{
            showDialog(response.message)
          }
        } else {
          if (Aksi=="EDIT") {
            editAbsenTrado(Id)
          }else if (Aksi=="DELETE"){
            deleteAbsenTrado(Id)
          }
        }

      }
    })
  }


  function editAbsenTrado(absenTradoId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Absen Trado')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        showAbsenTrado(form, absenTradoId),
        getMaxLength(form)
      ])
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
  }

  function deleteAbsenTrado(absenTradoId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-trash"></i>
    Delete
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Absen Trado')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        showAbsenTrado(form, absenTradoId),
        getMaxLength(form)
      ])
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
  }

  function viewAbsenTrado(absenTradoId) {
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
    $('#crudModalTitle').text('View Absen Trado')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        showAbsenTrado(form, absenTradoId),
        getMaxLength(form)
      ])
      .then(absenTradoId => {
        form.find('.aksi').hide()
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
      })
      .catch((error) => {
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })


  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}absentrado/field_length`,
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

  const setStatusAktifOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusaktif]').empty()
      relatedForm.find('[name=statusaktif]').append(
        new Option('-- PILIH STATUS AKTIF --', '', false, true)
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
              "data": "STATUS AKTIF"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusAktif => {
            let option = new Option(statusAktif.text, statusAktif.id)

            relatedForm.find('[name=statusaktif]').append(option).trigger('change')
          });
          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function isJSON(something) {
    if (typeof something != 'string')
      something = JSON.stringify(something);

    try {
      JSON.parse(something);
      return true;
    } catch (e) {
      return false;
    }
  }

  function showAbsenTrado(form, absenTradoId) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}absentrado/${absenTradoId}`,
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
          })

          let memo = response.data.memo
          let isJson = isJSON(memo);

          console.log(isJSON(memo));

          if (isJson === false) {
            addRow();
          } else {

            let memoToArray = JSON.parse(memo)
            $.each(memoToArray, (index, detail) => {

              let detailRow = $(`
                <tr>
                  <td class="aksi">
                      <div type="button" class="delete-row"><span><i class="fas fa-trash-alt"></i></span></div>
                  </td>
                  <td>
                      <input type="text" name="key[]" class="form-control">
                  </td>
                  <td>
                    <div class="input-group" id="${index}">
                      <input type="text" name="value[]" class="form-control">
                    </div>
                  </td>
              </tr>`)
              let inputColor = $(`<div class="input-group-prepend" style="width:50px; background: #fff">
                        <span class="input-group-text form-control" id="basic-addon2" style="background: #fff">
                          <input type="color" name="color[]" style="border:none; background: #fff">
                        </span>
                      </div>`)

              detailRow.find(`[name="key[]"]`).val(index)
              detailRow.find(`[name="value[]"]`).val(detail)

              $('#detailList tbody').append(detailRow)
              if (index == 'WARNA') {
                // detailRow.find(`[name="value[]"]`).css({'color':`'${detail}'`});      
                // detailRow.find(`[name="value[]"]`).prop('disabled', true);      
                let test = $('#detailList tbody').find(`#${index}`).prepend(inputColor);
                detailRow.find(`[name="color[]"]`).val(detail)
                detailRow.find(`[name="key[]"]`).addClass('disabled')
                initDisabled()
              }

            })
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

  function showDefault(form) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}absentrado/default`,
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
            if (index == 'statusaktifnama') {
              element.data('current-value', value)
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

  function initLookup() {
    $(`.status-lookup`).lookupV3({
      title: 'Status Aktif Lookup',
      fileName: 'parameterV3',
      searching: ['text'],
      labelColumn: false,
      beforeProcess: function() {
        this.postData = {
          url: `${apiUrl}parameter/combo`,
          grp: 'STATUS AKTIF',
          subgrp: 'STATUS AKTIF',
        };
      },
      onSelectRow: (status, element) => {
        let elId = element.data('targetName')
        $(`#crudForm [name=${elId}]`).first().val(status.id)
        element.val(status.text)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'));
      },
      onClear: (element) => {
        let elId = element.data('targetName')
        $(`#crudForm [name=${elId}]`).first().val('')
        element.val('')
        element.data('currentValue', element.val())
      },
    });
  }

  function addRow() {
    let detailRow = (`
        <tr>
            <td class="aksi">
                <div type="button" class="delete-row"><span><i class="fas fa-trash-alt"></i></span></div>
            </td>
            <td>
                <input type="text" name="key[]" class="form-control">
            </td>

            <td>
                <input type="text" name="value[]" class="form-control">
            </td>

        </tr>`)

    $('#detailList tbody').append(detailRow)

    initDatepicker()

  }
  $(document).on('input', `#detailList tbody [name="color[]"]`, function() {
    let color = $(this).val()
    $(this).parents('.input-group').find(`[name="value[]"`).val(color)
    // $(this).parents('.input-group').find(`[name="value[]"`).css({'color':`'${color}'`});    
  })
  $(document).on('input', `#detailList tbody [name="key[]"]`, function(event) {
    let inputColor = $(`<div class="input-group-prepend" style="width:50px; background: #fff">
                      <span class="input-group-text form-control" id="basic-addon2" style="background: #fff">
                        <input type="color" name="color[]" style="border:none; background: #fff">
                      </span>
                    </div>`)

    if ($(this).val().toLowerCase() == 'warna') {
      $(this).parent().siblings().find(`[name="value[]"]`).wrap('<div class="input-group"></div>');
      $(this).parent().siblings().find(`.input-group`).prepend(inputColor);
    } else if ($(this).val().toLowerCase() == 'jurnal') {
      // $(this).parent().siblings().removeClass('input-group');
      $(this).parent().siblings().find(`[name="value[]"]`).addClass("coa-lookup")
      $('.coa-lookup').last().lookup({
        title: 'Jurnal Lookup',
        fileName: 'akunpusat',
        onSelectRow: (akunpusat, element) => {
          element.val(akunpusat.coa)
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
    } else {
      console.log($(this))

      $(this).parent().siblings().find('.input-group-append').remove()
      $(this).parent().siblings().find('.input-group .btn').remove()
      $(this).parent().siblings().find(`[name="value[]"]`).removeClass("coa-lookup")
      $(this).parent().siblings().find(`.input-group-prepend`).remove();
      $(this).parent().siblings().find('.input-group').children().unwrap();
    }
  })

  $(document).on('input', `#detailList tbody [name="value[]"]`, function(event) {
    let key = $(this).parents('td').siblings().find(`[name="key[]"]`).val();
    console.log(key);

    if (key.toLowerCase() == 'warna') {
      $(this).inputmask("#999999", {
        placeholder: "",
        definitions: {
          '#': {
            validator: "#"
          },
          9: {
            validator: "[0-9A-Fa-f]"
          },
        }
      });
      let color = $(this).val();
      $(this).parents('.input-group').find(`[name="color[]"`).val(color)
    }
  })

  function deleteRow(row) {
    let countRow = $('.delete-row').parents('tr').length
    row.remove()
    if (countRow <= 1) {
      addRow()
    }

  }
</script>
@endpush()