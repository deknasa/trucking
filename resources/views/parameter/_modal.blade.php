<div class="modal modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
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

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>ID</label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="id" class="form-control" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  GROUP <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="grp" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  SUBGROUP <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="subgrp" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  NAMA PARAMETER <span class="text-danger">*</span></label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="text" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  KELOMPOK
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="kelompok" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  TYPE
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="type">
                <input type="text" name="grup" class="form-control parameter-lookup">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  Default <span class="text-danger">*</span>
                </label>
              </div>

              
              <div class="col-12 col-sm-9 col-md-10">
                <select name="default" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH STATUS DEFAULT --</option>
                </select>
              </div>
            </div>


            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2 col-form-label">
                <label>
                  MEMO
                </label>
              </div>
            </div>

            <div class="table-responsive">
              <table class="table table-bordered table-bindkeys" id="detailList" style="width: 1300px;">
                <thead>
                  <tr>
                    <th width="3%">KEY</th>
                    <th width="8%">VALUE</th>
                    <th width="2%">Aksi</th>
                  </tr>
                </thead>
                <tbody id="table_body" class="form-group">

                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="2"></td>
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
    $(document).on('click', "#addRow", function() {
      addRow()
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
      } else {
        let method
        let url
        let form = $('#crudForm')
        let parameterId = form.find('[name=id]').val()
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
            url = `${apiUrl}parameter`
            break;
          case 'edit':
            method = 'PATCH'
            url = `${apiUrl}parameter/${parameterId}`
            break;
          case 'delete':
            method = 'DELETE'
            url = `${apiUrl}parameter/${parameterId}`
            break;
          default:
            method = 'POST'
            url = `${apiUrl}parameter`
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
      }

    })
  })

  $('#crudModal').on('shown.bs.modal', () => {
    let form = $('#crudForm')

    setFormBindKeys(form)

    activeGrid = null

    getMaxLength(form)
    initSelect2()
    initLookup()
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'

    $('#crudModal').find('.modal-body').html(modalBody)
  })

  function createParameter() {
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.data('action', 'add')
    $('#crudModalTitle').text('Create Parameter')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    $('#table_body').html('')
    addRow()

      setDefaultOptions(form)
  }

  const setDefaultOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=default]').empty()
      relatedForm.find('[name=default]').append(
        new Option('-- PILIH STATUS DEFAULT --', '', false, true)
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
              "data": "STATUS DEFAULT PARAMETER"
            }]
          })
        },
        success: response => {
          response.data.forEach(Default => {
            let option = new Option(Default.text, Default.text)

            relatedForm.find('[name=default]').append(option).trigger('change')
          });

          resolve()
        }
      })
    })
  }

  function editParameter(parameterId) {
    let form = $('#crudForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    $('#crudModalTitle').text('Edit Parameter')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()


    Promise
      .all([
        setDefaultOptions(form)
      ])
      .then(() => {
        showParameter(form, parameterId)
      })


  }

  function deleteParameter(parameterId) {
    let form = $('#crudForm')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find('[name]').addClass('disabled')
    $('#crudModalTitle').text('Delete Parameter')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setDefaultOptions(form)
      ])
      .then(() => {
        showParameter(form, parameterId)
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

  function showParameter(form, parameterId) {
    $.ajax({
      url: `${apiUrl}parameter/${parameterId}`,
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

        if (isJson === false) {
          addRow();
        } else {

          let memoToArray = JSON.parse(memo)
          $.each(memoToArray, (index, detail) => {

            let detailRow = $(`
              <tr>
                <td>
                    <input type="text" name="key[]" class="form-control">
                </td>
                <td>
                  <div class="input-group" id="${index}">
                    <input type="text" name="value[]" class="form-control">
                  </div>
                </td>
                <td>
                    <div class='btn btn-danger btn-sm delete-row'>Hapus</div>
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
            if(index == 'JURNAL'){
              detailRow.find(`[name="key[]"]`).addClass('disabled')
              initDisabled()
              detailRow.find(`[name="value[]"]`).addClass("coa-lookup")
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
            }
          })
        }


        if (form.data('action') === 'delete') {
          form.find('[name]').addClass('disabled')
          initDisabled()
        }
      }
    })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}parameter/field_length`,
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

  function updateFormat(parameter) {
    $.ajax({
      url: `${appUrl}/format`,
      method: 'PATCH',
      dataType: 'JSON',
      data: {
        key: parameter.subgrp,
        value: parameter.text
      },
      success: response => {
        // 
      },
      error: error => {
        showDialog(error.statusText)
      }
    })
  }

  function initLookup() {
    $('.parameter-lookup').lookup({
      title: 'Parameter Lookup',
      fileName: 'parameter',
      onSelectRow: (parameter, element) => {
        $(`#crudForm [name="type"]`).first().val(parameter.id)
        element.val(parameter.grp)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        $(`#crudForm [name="type"]`).first().val('')
        element.data('currentValue', element.val())
      }
    })
  }

  function addRow() {
    let detailRow = (`
        <tr>
            <td>
                <input type="text" name="key[]" class="form-control">
            </td>

            <td>
                <input type="text" name="value[]" class="form-control">
            </td>

            <td>
                <div class='btn btn-danger btn-sm delete-row'>Hapus</div>
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
    } else if($(this).val().toLowerCase() == 'jurnal') {
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
    }else {
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
    row.remove()

  }
</script>
@endpush()