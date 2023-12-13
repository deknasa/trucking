<div class="modal modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="crudForm">
      <div class="modal-content">

        <form action="" method="post">
          <div class="modal-body">
            {{-- <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2" style="display:none">
                <label class="col-form-label">ID</label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="id" class="form-control" readonly>
              </div>
            </div> --}}
            <input type="text" name="id" class="form-control" hidden>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  Role Name
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="rolename" class="form-control">
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12">

                <table id="acoGrid"></table>

              </div>
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
  let selectedRows = [];
  let modalBody = $('#crudModal').find('.modal-body').html()
  $(document).ready(function() {
    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let roleId = form.find('[name=id]').val()
      let action = form.data('action')
      let data = [];
      let dataAcos = {
        'aco_ids': selectedRows,
      };

      let jsonData = JSON.stringify(dataAcos);


      data.push({
        name: 'id',
        value: form.find('[name=id]').val()
      })
      data.push({
        name: 'rolename',
        value: form.find('[name=rolename]').val()
      })
      data.push({
        name: 'aco_ids',
        value: jsonData
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

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}role`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}role/${roleId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}role/${roleId}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}role`
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

          selectedRows = []
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

    setFormBindKeys(form)

    activeGrid = null

    getMaxLength(form)
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    selectedRows = []
    $('#crudModal').find('.modal-body').html(modalBody)
  })

  function createRole() {
    let form = $('#crudForm')


    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.data('action', 'add')
    $('#crudModalTitle').text('Create Role')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
  }

  function editRole(roleId) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)

    $('#crudModalTitle').text('Edit Role')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    loadAcoGrid(roleId)
    Promise
      .all([
        showRole(form, roleId)
      ])
      .then(() => {
        $('#acoGrid').jqGrid('setGridParam', {
          url: `${apiUrl}acos`,
          postData: {
            role_id: roleId
          },
          datatype: "json"
        }).trigger('reloadGrid');
        $('#crudModal').modal('show')
      })
      .catch((error) => {
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }

  function deleteRole(roleId) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-trash"></i>
    Delete
  `)
    $('#crudModalTitle').text('Delete Role')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    loadAcoGrid(roleId)
    Promise
      .all([
        showRole(form, roleId)
      ])
      .then(() => {

        $('#acoGrid').jqGrid('setGridParam', {
          url: `${apiUrl}acos`,
          postData: {
            role_id: roleId
          },
          datatype: "json"
        }).trigger('reloadGrid');
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
      $.ajax({
        url: `${apiUrl}role/field_length`,
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

  function showRole(form, roleId) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}role/${roleId}`,
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
          $.each(response.detail, (index, detail) => {
            if (detail.status == 'AKTIF') {
              selectedRows.push(detail.id)
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

  function clearSelectedRows() {
    selectedRows = []

    $('#acoGrid').trigger('reloadGrid')
  }

  function selectAllRows() {
    $.ajax({
      url: `${apiUrl}acos`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        limit: 0,
        role_id: $('#crudForm').find('[name=id]').val()
      },
      success: (response) => {
        selectedRows = response.data.map((aco) => aco.id)

        $('#acoGrid').trigger('reloadGrid')
      }
    })
  }

  function checkboxHandler(element) {
    let value = $(element).val();

    if (element.checked) {
      selectedRows.push($(element).val())
      $(element).parents('tr').addClass('bg-light-blue')
    } else {
      $(element).parents('tr').removeClass('bg-light-blue')
      for (var i = 0; i < selectedRows.length; i++) {
        if (selectedRows[i] == value) {
          selectedRows.splice(i, 1);
        }
      }
    }
  }

  function loadAcoGrid(roleId) {
    $('#acoGrid')
      .jqGrid({
        styleUI: 'Bootstrap4',
        datatype: "local",
        // url: `${apiUrl}acos`,
        // postData: {
        //   role_id: roleId
        // },
        colModel: [{
            label: '',
            name: '',
            width: 30,
            align: 'center',
            sortable: false,
            clear: false,
            stype: 'input',
            searchable: false,
            searchoptions: {
              type: 'checkbox',
              clearSearch: false,
              dataInit: function(element) {
                $(element).removeClass('form-control')
                $(element).parent().addClass('text-center')
                $(element).on('click', function() {
                  $(element).attr('disabled', true)
                  if ($(this).is(':checked')) {
                    selectAllRows()
                  } else {
                    clearSelectedRows()
                  }
                })
              }
            },
            formatter: (value, rowOptions, rowData) => {
              return `<input type="checkbox" name="aco_ids[]" value="${rowData.id}" onchange="checkboxHandler(this)">`
            },
          },
          {
            label: 'Class',
            name: 'class',
            width: '500px',
          },
          {
            label: 'Method',
            name: 'method',
            width: '200px',
          },
          {
            label: 'Nama',
            name: 'nama',
            width: '400px',
          },
          {
            label: 'Status',
            name: 'status',
            width: '150px',
          },
        ],
        autowidth: true,
        shrinkToFit: false,
        height: 350,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [10, 20, 50, 0],
        rowNum: 10,
        page: 1,
        viewrecords: true,
        prmNames: {
          sort: 'sortIndex',
          order: 'sortOrder',
          rows: 'limit'
        },
        jsonReader: {
          root: 'data',
          total: 'attributes.totalPages',
          records: 'attributes.totalRows',
        },
        loadBeforeSend: function(jqXHR) {
          jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)

          setGridLastRequest($(this), jqXHR)
        },
        onSelectRow: function(id, status, event) {
          activeGrid = $(this)
          indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
          page = $(this).jqGrid('getGridParam', 'page')
          let rows = $(this).jqGrid('getGridParam', 'postData').limit
          if (indexRow >= rows) indexRow = (indexRow - rows * (page - 1))
        },
        ondblClickRow: function(id, status, event) {
          $(this).find(`tr#${id}`).find(`[name="aco_ids[]"]`).click()
        },
        loadComplete: function(data) {
          let grid = $(this)

          changeJqGridRowListText()

          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))

          $.each(selectedRows, function(key, value) {
            $(grid).find('tbody tr').each(function(row, tr) {
              if ($(this).find(`td input:checkbox`).val() == value) {
                $(this).addClass('bg-light-blue')
                $(this).find(`td input:checkbox`).prop('checked', true)
              }
            })
          });

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#acoGrid').jqGrid('getInd', id)) - 1
              $(`#acoGrid [id="${$('#acoGrid').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#acoGrid [id="${$('#acoGrid').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#acoGrid').getDataIDs()[indexRow] == undefined) {
              $(`#acoGrid [id="` + $('#acoGrid').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#acoGrid').setSelection($('#acoGrid').getDataIDs()[indexRow])
          }
          $('#gs_').attr('disabled', false)
          setHighlight($(this))
        }
      })
      .jqGrid('filterToolbar', {
        stringResult: true,
        searchOnEnter: false,
        defaultSearch: 'cn',
        groupOp: 'AND',
        disabledKeys: [17, 33, 34, 35, 36, 37, 38, 39, 40],
        beforeSearch: function() {
          abortGridLastRequest($(this))

          clearGlobalSearch($('#acoGrid'))
        },
      })
      .customPager()

    loadClearFilter($('#acoGrid'))
    loadGlobalSearch($('#acoGrid'))
  }
</script>
@endpush()