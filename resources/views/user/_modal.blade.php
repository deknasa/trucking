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
            {{-- <div class="row form-group" >
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
                  User <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="user" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  Nama User <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="name" class="form-control">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  Email <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="email" class="form-control">
              </div>
            </div>
            <!-- <div class="row form-group sometimes">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  Password <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <div class="input-group">
                  <input type="password" name="password" class="form-control password">
                  <div class="input-group-append">
                    <div class="input-group-text focusPass">
                      <span class="fas fa-eye toggle-password" toggle=".password"></span>
                    </div>
                  </div>
                </div>
              </div>
            </div> -->
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  Cabang <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="cabang_id">
                <input type="text" name="cabang" id="cabang" class="form-control cabang-lookup">
              </div>
            </div>
            {{-- <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  Status Karyawan <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <select name="karyawan_id" class="form-select select2bs4" style="width: 100%;">
                  <option value="">-- PILIH STATUS KARYAWAN --</option>
                </select>
              </div>
            </div> --}}
            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  Dashboard
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="dashboard" class="form-control">
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
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  Status Akses <span class="text-danger">*</span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="hidden" name="statusakses">
                <input type="text" name="statusaksesnama" id="statusaksesnama" class="form-control lg-form statusakses-lookup">
              </div>
            </div>

            <div class="row form-group rolediv">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">
                  Role <span class="text-danger"></span>
                </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <select name="role_ids[]" id="multiple" class="select2bs4 form-control" multiple="multiple"></select>
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
      let userId = form.find('[name=id]').val()
      let action = form.data('action')
      let data = []
      let dataAcos = {
        'aco_ids': selectedRows,
      };

      let jsonData = JSON.stringify(dataAcos);
      data.push({
        name: 'id',
        value: form.find('[name=id]').val()
      })
      data.push({
        name: 'user',
        value: form.find('[name=user]').val()
      })
      data.push({
        name: 'name',
        value: form.find('[name=name]').val()
      })
      data.push({
        name: 'email',
        value: form.find('[name=email]').val()
      })
      data.push({
        name: 'password',
        value: form.find('[name=password]').val()
      })
      data.push({
        name: 'cabang_id',
        value: form.find('[name=cabang_id]').val()
      })
      data.push({
        name: 'cabang',
        value: form.find('[name=cabang]').val()
      })
      data.push({
        name: 'dashboard',
        value: form.find('[name=dashboard]').val()
      })
      data.push({
        name: 'statusaktif',
        value: form.find('[name=statusaktif]').val()
      })
      data.push({
        name: 'statusakses',
        value: form.find('[name=statusakses]').val()
      })
      data.push({
        name: 'statusaktifnama',
        value: form.find('[name=statusaktifnama]').val()
      })
      data.push({
        name: 'statusaksesnama',
        value: form.find('[name=statusaksesnama]').val()
      })
      data.push({
        name: 'aco_ids',
        value: jsonData
      })
      let roleIds = form.find(`[name="role_ids[]"]`).val()
      $.each(roleIds, function(index, value) {

        data.push({
          name: 'role_ids[]',
          value: value
        })
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
          url = `${apiUrl}user`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}user/${userId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}user/${userId}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}user`
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

          $('#jqGrid').trigger('reloadGrid', {
            page: response.data.page
          })
          $('#userRoleGrid').trigger('reloadGrid', {
            postData: {
              proses: 'reload'
            }
          }).trigger('reloadGrid');
          $('#userAclGrid').trigger('reloadGrid', {
            postData: {
              proses: 'reload'
            }
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
    initSelect2(form.find('.select2bs4'), true)
    initDatepicker()
    initLookup()

    $('#multiple')
      .select2({
        theme: 'bootstrap4',
        width: '100%',
      })
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    selectedRows = []
    $('#crudModal').find('.modal-body').html(modalBody)
  })

  function createUser() {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')
    $('.rolediv').hide()
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Add User')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
    showDefault(form)
      .then(() => {
        $('#crudModal').modal('show')
      })
      .catch((error) => {
        showDialog(error.responseJSON)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }

  function editUser(userId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit User')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    loadAcoGrid(userId)
    Promise
      .all([
        setRoleOptions(form)
      ])
      .then(() => {
        showUser(form, userId)
          .then(() => {
            $('#acoGrid').jqGrid('setGridParam', {
              url: `${apiUrl}acos/getuseracl`,
              postData: {
                user_id: userId
              },
              datatype: "json"
            }).trigger('reloadGrid');
            $('#crudModal').modal('show')
          })
          .catch((error) => {
            showDialog(error.responseJSON)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  function deleteUser(userId) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-trash"></i>
    Delete
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete User')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    loadAcoGrid(userId)

    Promise
      .all([
        setRoleOptions(form)
      ])
      .then(() => {
        showUser(form, userId)
          .then(() => {
            $('#acoGrid').jqGrid('setGridParam', {
              url: `${apiUrl}acos/getuseracl`,
              postData: {
                user_id: userId
              },
              datatype: "json"
            }).trigger('reloadGrid');
            $('#crudModal').modal('show')
          })
          .catch((error) => {
            showDialog(error.responseJSON)
          })
          .finally(() => {
            $('.modal-loader').addClass('d-none')
          })
      })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}user/field_length`,
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

  const setCabangOptions = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=cabang_id]').empty()
      relatedForm.find('[name=cabang_id]').append(
        new Option('-- PILIH CABANG --', '', false, true)
      ).trigger('change')

      $.ajax({
        url: `${apiUrl}cabang`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          response.data.forEach(cabang => {
            let option = new Option(cabang.namacabang, cabang.id)

            relatedForm.find('[name=cabang_id]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  const setStatusKaryawanOptions = function setStatusKaryawanOptions(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=karyawan_id]').empty()
      relatedForm.find('[name=karyawan_id]').append(
        new Option('-- PILIH STATUS KARYAWAN --', '', false, true)
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
              "data": "STATUS KARYAWAN"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusKaryawan => {
            let option = new Option(statusKaryawan.text, statusKaryawan.id)

            relatedForm.find('[name=karyawan_id]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
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

  const setStatusAkses = function(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name=statusakses]').empty()
      relatedForm.find('[name=statusakses]').append(
        new Option('-- PILIH STATUS AKSES --', '', false, true)
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
              "data": "STATUS AKSES"
            }]
          })
        },
        success: response => {
          response.data.forEach(statusAkses => {
            let option = new Option(statusAkses.text, statusAkses.id)

            relatedForm.find('[name=statusakses]').append(option).trigger('change')
          });

          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }


  function showUser(form, userId) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}user/${userId}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {

          let roleIds = []

          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)

            if (element.is('select')) {
              element.val(value).trigger('change')
            } else {
              element.val(value)
            }

            if (index == 'cabang') {
              element.data('current-value', value)
            }
            if (index == 'statusaktifnama') {
              element.data('current-value', value)
            }
            if (index == 'statusaksesnama') {
              element.data('current-value', value)
            }
          })

          response.roles.forEach((role) => {
            roleIds.push(role.role_id)
          });

          form.find(`[name="role_ids[]"]`).val(roleIds).change()

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

  function setRoleOptions(relatedForm) {
    return new Promise((resolve, reject) => {
      relatedForm.find('[name="role_ids[]"]').empty()

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

            relatedForm.find(`[name="role_ids[]"]`).append(option).trigger('change')
          });

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
        url: `${apiUrl}user/default`,
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


  function clearSelectedRows() {
    selectedRows = []

    $('#acoGrid').trigger('reloadGrid')
  }

  function selectAllRows() {
    $.ajax({
      url: `${apiUrl}acos/getuseracl`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        limit: 0,
        user_id: $('#crudForm').find('[name=id]').val()
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

  function loadAcoGrid(userId) {
    $('#acoGrid')
      .jqGrid({
        styleUI: 'Bootstrap4',
        datatype: "local",
        // url: `${apiUrl}acos`,
        // postData: {
        //   role_id: userId
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
            label: 'CLASS',
            name: 'class',
            width: (detectDeviceType() == "desktop") ? lg_dekstop_3 : lg_mobile_3,
            align: 'left'
          },
          {
            label: 'METHOD',
            name: 'method',
            width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
            align: 'left'
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
            width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
            align: 'left'
          },
          {
            label: 'Nama',
            name: 'nama',
            width: (detectDeviceType() == "desktop") ? lg_dekstop_2 : lg_mobile_2,
          },
          {
            label: 'Status',
            name: 'status',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            stype: 'select',
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['combostatus'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['combostatus'])) {
                          echo ';';
                        }
                        $i++;
                      endforeach;

                      ?>
            `,
              dataInit: function(element) {
                $(element).select2({
                  width: 'resolve',
                  theme: "bootstrap4"
                });
              }
            },
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

  function initLookup() {

    $('.cabang-lookup').lookupV3({
      title: 'Cabang Lookup',
      fileName: 'cabangV3',
      searching: ['namacabang'],
      labelColumn: false,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF'
        }
      },
      onSelectRow: (cabang, element) => {
        $('#crudForm [name=cabang_id]').first().val(cabang.id)
        element.val(cabang.namacabang)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#crudForm [name=cabang_id]').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $(`.statusaktif-lookup`).lookupV3({
      title: 'Status Aktif Lookup',
      fileName: 'parameterV3',
      searching: ['text'],
      labelColumn: false,
      beforeProcess: function() {
        this.postData = {
          url: `${apiUrl}parameter/combo`,
          grp: 'STATUS AKTIF',
          subgrp: 'STATUS AKTIF'
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
        $('#crudForm [name=statusaktif]').first().val('')
        element.val('');
        element.data('currentValue', element.val());
      },
    });

    $(`.statusakses-lookup`).lookupV3({
      title: 'Status Akses Lookup',
      fileName: 'parameterV3',
      searching: ['text'],
      labelColumn: false,
      beforeProcess: function() {
        this.postData = {
          url: `${apiUrl}parameter/combo`,
          grp: 'STATUS AKSES',
          subgrp: 'STATUS AKSES'
        };
      },
      onSelectRow: (status, element) => {
        $('#crudForm [name=statusakses]').first().val(status.id)
        element.val(status.text)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'));
      },
      onClear: (element) => {
        $('#crudForm [name=statusakses]').first().val('')
        element.val('');
        element.data('currentValue', element.val());
      },
    });

  }
</script>
@endpush()