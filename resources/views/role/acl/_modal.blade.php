<div class="modal modal-fullscreen" id="userAclModal" tabindex="-1" aria-labelledby="userAclModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="userAclForm">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="userAclLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            
          </button>
        </div>
        <div class="modal-body">
          <div class="card">
            <div class="card-body">
              <div class="row form-group">
                <div class="col-12 col-sm-3 col-md-2">
                  <label class="col-form-label">
                    Role <span class="text-danger">*</span>
                  </label>
                </div>
                <div class="col-12 col-sm-9 col-md-10">
                  <input type="hidden" name="role_id">
                  <input type="text" name="role" class="form-control" disabled>
                </div>
              </div>

              <div class="row form-group">
                <div class="col-12">

                  <table id="acoGrid"></table>

                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <div class="mr-auto">
            <button type="button" id="btnSubmitUserAcl" class="btn btn-primary">SIMPAN</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">BATAL</button>
          </div>
        </div>
      </div>
    </form>
  </div>
</div>

<script>
  hasFormBindKeys = false
  selectedRows = [];

  $(document).ready(function() {
    $('#btnSubmitUserAcl').click(function(event) {
      event.preventDefault()

      let roleId = $('#userAclForm').find(`[name=role_id]`).val()

      updateUserAcl(roleId)
    })
  })

  function updateUserAcl(roleId) {
    let form = $('#userAclForm')

    $.ajax({
      url: `${apiUrl}role/${roleId}/acl`,
      method: 'POST',
      dataType: 'JSON',
      data: {
        aco_ids: selectedRows
      },
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        $('#userAclForm').trigger('reset')
        $('#userAclModal').modal('hide')

        $('#roleAclGrid').jqGrid('setGridParam').trigger('reloadGrid');
      },
      error: error => {
        if (error.status === 422) {
          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()

          setErrorMessages(form, error.responseJSON.errors);
        }
      }
    }).always(() => {
      $('#loader').addClass('d-none')
      $(this).removeAttr('disabled')
    })
  }

  $('#userAclModal').on('shown.bs.modal', () => {
    let form = $('#userAclForm')

    setFormBindKeys(form)

    activeGrid = $('#acoGrid')
  })

  $('#userAclModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    $('#acoGrid').find('tr.bg-light-blue').removeClass('bg-light-blue')
  })

  async function editRoleAcl(roleId) {
    let form = $('#userAclForm')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmitUserAcl').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#userAclModalTitle').text('Edit User Role')
    $('#userAclModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()


    let userAcls = await getUserAcls(roleId)

    selectedRows = userAcls.data.map((acl) => {
      let element = $('#userAclForm').find(`[name="aco_ids[]"][value=${acl.id}]`)

      element.prop('checked', true)
      element.parents('tr').addClass('bg-light-blue')

      return acl.id
    })

    showRole(roleId)
    loadAcoGrid()
  }

  function showRole(roleId) {
    $.ajax({
      url: `${apiUrl}role/${roleId}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: (response) => {
        $('#userAclForm').find(`[name="role_id"]`).val(response.data.id)
        $('#userAclForm').find(`[name="role"]`).val(response.data.rolename)
      }
    })
  }
  function loadAcoGrid() {
    $('#acoGrid')
      .jqGrid({
        styleUI: 'Bootstrap4',
        datatype: 'json',
        url: `${apiUrl}acos`,
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
            name: 'class'
          },
          {
            label: 'Method',
            name: 'method'
          },
          {
            label: 'Nama',
            name: 'nama'
          },
        ],
        autowidth: true,
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
        loadBeforeSend: (jqXHR) => {
          jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)
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
          clearGlobalSearch($('#acoGrid'))
        },
      })
      .customPager()

    loadClearFilter($('#acoGrid'))
    loadGlobalSearch($('#acoGrid'))
  }

  
  async function getUserAcls(roleId) {
    return await $.ajax({
      url: `${apiUrl}role/${roleId}/acl`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        limit: 0
      },
      success: response => {
        return response
      },
      error: (error) => {
        showDialog(error.responseJSON.message)
      }
    })
  }


  function showUserAcls(form, roleId) {
    $.ajax({
      url: `${apiUrl}role/${roleId}/acl`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        console.log(response.role)
        $(`[name="role"]`).val(response.role)
        response.data.forEach(acl => {
          $(`[name="aco_ids[]"][value=${acl.id}]`).attr('checked', 'checked')
        });
      },
      error: (error) => {
        showDialog(error.responseJSON.message)
      }
    })
  }

  function setAclOptions(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name="aco_ids[]"]').empty()

      $.ajax({
        url: `${apiUrl}role`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          limit: 0,
        },
        success: response => {
          response.data.forEach(role => {
            let option = new Option(role.rolename, role.id)

            relatedForm.find(`[name="aco_ids[]"]`).append(option).trigger('change')
          });

          resolve()
        }
      })
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
        limit: 0
      },
      success: (response) => {
        selectedRows = response.data.map((aco) => aco.id)

        $('#acoGrid').trigger('reloadGrid')
      }
    })
  }
  function getUserAclOptions() {
    $('#acoList tbody').html('')

    $.ajax({
      url: `${apiUrl}acos`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: (response) => {
        response.data.forEach((aco, index) => {
          $('#acoList tbody').append(`
            <tr>
              <td>${index + 1}</td>
              <td class="text-center"><input class="form-check-input" type="checkbox" name="aco_ids[]" value="${aco.id}"></td>
              <td>${aco.class}</td>
              <td>${aco.method}</td>
            </tr>
          `)
        })
      },
      error: (error) => {
        console.log(error);
      }
    })
  }
</script>