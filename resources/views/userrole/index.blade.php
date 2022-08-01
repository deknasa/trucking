@extends('layouts.master')

@section('content')
<!-- Grid -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <table id="jqGrid"></table>
      <div id="jqGridPager" class="row bg-white">
        <div id="buttonContainer" class="col-12 col-md-7 text-center text-md-left justify-content-center align-items-center">
          <button id="add" class="btn btn-primary btn-sm mb-1">
            <i class="fa fa-plus"></i> ADD
          </button>
          <button id="edit" class="btn btn-success btn-sm mb-1">
            <i class="fa fa-pen"></i> EDIT
          </button>
          <button id="delete" class="btn btn-danger btn-sm mb-1">
            <i class="fa fa-trash"></i> DELETE
          </button>
          <button id="export" class="btn btn-warning btn-sm mb-1">
            <i class="fa fa-file-export"></i> EXPORT
          </button>
          <button id="report" class="btn btn-info btn-sm mb-1">
            <i class="fa fa-print"></i> REPORT
          </button>
        </div>
        <div id="pagerHandler" class="col-12 col-md-4 d-flex justify-content-center align-items-center"></div>
        <div id="pagerInfo" class="col-12 col-md-1 d-flex justify-content-end align-items-center"></div>
      </div>
    </div>
  </div>
</div>

<div class="modal fade modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="crudForm">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title" id="crudModalLabel"></h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div class="card">
            <div class="card-body">
              <input type="hidden" name="user_id">

              <div class="row form-group">
                <div class="col-12 col-md-1">
                  <label>USER</label>
                </div>
                <div class="col-12 col-md-11">
                  <div class="input-group">
                    <input type="text" name="user" class="form-control">
                    <div class="input-group-append">
                      <button id="lookupToggler" class="btn btn-secondary" type="button">...</button>
                    </div>
                  </div>
                  <div class="row" id="lookup">
                    <div class="col-12" style="overflow-x: scroll;">
                      <div id="lookup">
                        @include('userrole._lookup')
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <table class="table table-borderd" id="roleList">
                <thead class="table-secondary">
                  <tr>
                    <th>Role</th>
                    <th>Status</th>
                  </tr>
                </thead>
                <tbody>
                  {{--
                  @foreach($combo['role'] as $role)
                  <tr>
                    <td><input type="hidden" name="role_id[]" value="{{ $role['role_id'] }}">{{ $role['rolename'] }}</td>
                  <td width="25%">
                    <select name="status[]" id="">
                      @foreach($combo['statusaktif'] as $statusaktif)
                      <option value="{{ $statusaktif['id'] }}">{{ $statusaktif['text'] }}</option>
                      @endforeach
                    </select>
                  </td>
                  </tr>
                  @endforeach
                  --}}
                </tbody>
              </table>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Simpan</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
      </div>
    </form>
  </div>
</div>

<!-- Detail -->
@include('userrole._detail')

@push('scripts')
<script>
  let indexUrl = "{{ route('userrole.index') }}"
  let getUrl = "{{ route('userrole.get') }}"
  let indexRow = 0;
  let page = 0;
  let pager = '#jqGridPager'
  let popup = "";
  let id = "";
  let triggerClick = true;
  let highlightSearch;
  let totalRecord
  let limit
  let postData
  let sortname = 'user'
  let sortorder = 'asc'
  let autoNumericElements = []

  $(document).ready(function() {
    $('#lookup').hide()

    $('#crudForm').submit(function(event) {
      event.preventDefault()

      let action = $(this).data('action')
      let userId = $(this).find('[name=user_id]').val()
      let url = `{{ config('app.api_url') . 'userrole' }}`
      let method = 'POST'

      if (action != 'add') {
        url += `/${userRoleId}`
      }

      if (action === 'edit') {
        method = 'PATCH'
      } else if (action === 'delete') {
        method = 'DELETE'
      }

      $.ajax({
        url: url,
        method: method,
        dataType: 'JSON',
        headers: {
          'Authorization': `Bearer {{ session('access_token') }}`
        },
        data: $(this).serializeArray(),
        success: response => {
          $('#jqGrid').trigger('reloadGrid', {
            page: response.page
          })

          $('#crudModal').modal('hide')
          $('#crudModal').find('#crudForm').trigger('reset')
          $('#crudModal').find('#crudForm select').val(1).trigger("change.select2")
        },
        error: error => {
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            setErrorMessages(error.responseJSON.errors);
          } else {
            showDialog(error.statusText)
          }
        }
      })
    })

    $('#lookupToggler').click(function(event) {
      $('#lookup').toggle()
    })

    $('[name=user]').on('input', function(event) {
      $('#lookup').show()

      delay(() => {
        let postData = userRoleLookup.getGridParam('postData')
        let colModels = userRoleLookup.getGridParam('colModel')
        let rules = []

        colModels = colModels.filter((colModel) => {
          return colModel.name !== 'rn'
        })

        colModels.forEach(colModel => {
          rules.push({
            field: colModel.name,
            op: 'cn',
            data: $(this).val()
          })
        });

        postData.filters = JSON.stringify({
          groupOp: 'OR',
          rules: rules
        })

        userRoleLookup.trigger('reloadGrid', {
          page: 1
        })
      }, 500)
    })

    $("#jqGrid").jqGrid({
        url: `{{ config('app.api_url') . 'userrole' }}`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        colModel: [{
            label: 'USER ID',
            name: 'user_id',
            align: 'left',
            hidden: true
          },
          {
            label: 'ID',
            name: 'id',
            align: 'left',
            hidden: true
          },
          {
            label: 'USER',
            name: 'user',
            align: 'left'
          }, {
            label: 'NAMA USER',
            name: 'name',
            align: 'left'
          },
          {
            label: 'MODIFIEDBY',
            name: 'modifiedby',
            align: 'left'
          },
          {
            label: 'UPDATEDAT',
            name: 'updated_at',
            align: 'right'
          },
        ],
        autowidth: true,
        shrinkToFit: false,
        height: 350,
        rowNum: 10,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [10, 20, 50],
        toolbar: [true, "top"],
        sortable: true,
        sortname: sortname,
        sortorder: sortorder,
        page: page,
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
          jqXHR.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
        },
        onSelectRow: function(id) {
          row_id = $(this).jqGrid('getGridParam', 'selrow')
          selectedId = $(this).jqGrid('getCell', row_id, 'user_id');

          loadDetailData(selectedId)

          id = $(this).jqGrid('getCell', id, 'rn') - 1
          indexRow = id
          page = $(this).jqGrid('getGridParam', 'page')
          let rows = $(this).jqGrid('getGridParam', 'postData').limit
          if (indexRow >= rows) indexRow = (indexRow - rows * (page - 1))
        },
        loadComplete: function(data) {
          loadPagerHandler('#pagerHandler', $(this))
          loadPagerInfo('#pagerInfo', $(this))

          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))

          /* Set global variables */
          sortname = $(this).jqGrid("getGridParam", "sortname")
          sortorder = $(this).jqGrid("getGridParam", "sortorder")
          totalRecord = $(this).getGridParam("records")
          limit = $(this).jqGrid('getGridParam', 'postData').limit
          postData = $(this).jqGrid('getGridParam', 'postData')

          $('.clearsearchclass').click(function() {
            clearColumnSearch()
          })

          if (indexRow > $(this).getDataIDs().length - 1) {
            indexRow = $(this).getDataIDs().length - 1;
          }

          setTimeout(function() {
            if (triggerClick) {

              if (id != '') {
                indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
                $(`#jqGrid [id="${$('#jqGrid').getDataIDs()[indexRow]}"]`).click()
                id = ''
              } else if (indexRow != undefined) {
                $(`#jqGrid [id="${$('#jqGrid').getDataIDs()[indexRow]}"]`).click()
              }

              if ($('#jqGrid').getDataIDs()[indexRow] == undefined) {
                $(`#jqGrid [id="` + $('#jqGrid').getDataIDs()[0] + `"]`).click()
              }

              triggerClick = false
            } else {
              $('#jqGrid').setSelection($('#jqGrid').getDataIDs()[indexRow])
            }

          }, 100)
        }
      })

      .jqGrid('filterToolbar', {
        stringResult: true,
        searchOnEnter: false,
        defaultSearch: 'cn',
        groupOp: 'AND',
        disabledKeys: [17, 33, 34, 35, 36, 37, 38, 39, 40],
        beforeSearch: function() {
          clearGlobalSearch()
        },
      })


    /* Append clear filter button */
    loadClearFilter()

    /* Append global search */
    loadGlobalSearch()

    /* Load detial grid */
    loadDetailGrid()

    $('#add .ui-pg-div')
      .addClass(`btn btn-sm btn-primary`)
      .parent().addClass('px-1')

    $('#edit .ui-pg-div')
      .addClass('btn btn-sm btn-success')
      .parent().addClass('px-1')

    $('#delete .ui-pg-div')
      .addClass('btn btn-sm btn-danger')
      .parent().addClass('px-1')

    $('#report .ui-pg-div')
      .addClass('btn btn-sm btn-info')
      .parent().addClass('px-1')

    $('#export .ui-pg-div')
      .addClass('btn btn-sm btn-warning')
      .parent().addClass('px-1')

    if (!`{{ $myAuth->hasPermission('userrole', 'store') }}`) {
      $('#add').addClass('ui-disabled')
    }

    if (!`{{ $myAuth->hasPermission('userrole', 'update') }}`) {
      $('#edit').addClass('ui-disabled')
    }

    if (!`{{ $myAuth->hasPermission('userrole', 'destroy') }}`) {
      $('#delete').addClass('ui-disabled')
    }

    if (!`{{ $myAuth->hasPermission('userrole', 'export') }}`) {
      $('#export').addClass('ui-disabled')
    }

    if (!`{{ $myAuth->hasPermission('userrole', 'report') }}`) {
      $('#report').addClass('ui-disabled')
    }

    $('#rangeModal').on('shown.bs.modal', function() {
      if (autoNumericElements.length > 0) {
        $.each(autoNumericElements, (index, autoNumericElement) => {
          autoNumericElement.remove()
        })
      }

      $('#formRange [name]:not(:hidden)').first().focus()

      $('#formRange [name=sidx]').val($('#jqGrid').jqGrid('getGridParam').postData.sidx)
      $('#formRange [name=sord]').val($('#jqGrid').jqGrid('getGridParam').postData.sord)
      $('#formRange [name=dari]').val((indexRow + 1) + (limit * (page - 1)))
      $('#formRange [name=sampai]').val(totalRecord)

      autoNumericElements = new AutoNumeric.multiple('#formRange .autonumeric-report', {
        digitGroupSeparator: '.',
        decimalCharacter: ',',
        allowDecimalPadding: false,
        minimumValue: 1,
        maximumValue: totalRecord
      })
    })

    $('#formRange').submit(function(event) {
      event.preventDefault()

      let params
      let submitButton = $(this).find('button:submit')

      submitButton.attr('disabled', 'disabled')

      /* Set params value */
      for (var key in postData) {
        if (params != "") {
          params += "&";
        }
        params += key + "=" + encodeURIComponent(postData[key]);
      }

      let formRange = $('#formRange')
      let offset = parseInt(formRange.find('[name=dari]').val()) - 1
      let limit = parseInt(formRange.find('[name=sampai]').val().replace('.', '')) - offset
      params += `&offset=${offset}&limit=${limit}`

      if ($('#rangeModal').data('action') == 'export') {
        let xhr = new XMLHttpRequest()
        xhr.open('GET', `{{ config('app.api_url') }}userrole/export?${params}`, true)
        xhr.setRequestHeader("Authorization", `Bearer {{ session('access_token') }}`)
        xhr.responseType = 'arraybuffer'

        xhr.onload = function(e) {
          if (this.status === 200) {
            if (this.response !== undefined) {
              let blob = new Blob([this.response], {
                type: "application/vnd.ms-excel"
              })
              let link = document.createElement('a')

              link.href = window.URL.createObjectURL(blob)
              link.download = `laporanUserRole${(new Date).getTime()}.xlsx`
              link.click()

              submitButton.removeAttr('disabled')
            }
          }
        }

        xhr.send()
      } else if ($('#rangeModal').data('action') == 'report') {
        window.open(`{{ route('userrole.report') }}?${params}`)

        submitButton.removeAttr('disabled')
      }
    })

    /* Handle button add on click */
    $('#add').click(function() {
      $('.is-invalid').removeClass('is-invalid')
      $('.invalid-feedback').remove()

      $('#crudForm').data('action', 'add')
      $('#crudForm [name=user]').val('')
      $('#crudForm [name=user_id]').val('')
      $('#crudModal').find('button:submit').text('SIMPAN')
      $('#crudModal').find('.modal-title').text('Add User Role')
      $('#crudModal').modal('show')

      let roles
      let statuses

      $.ajax({
        url: `{{ config('app.api_url') . 'role' }}`,
        method: 'GET',
        dataType: 'JSON',
        async: false,
        headers: {
          'Authorization': `Bearer {{ session('access_token') }}`
        },
        success: response => {
          roles = response.data
        }
      })

      $.ajax({
        url: `{{ config('app.api_url') . 'parameter/combo' }}`,
        method: 'GET',
        dataType: 'JSON',
        async: false,
        headers: {
          'Authorization': `Bearer {{ session('access_token') }}`
        },
        data: {
          grp: 'STATUS AKTIF',
          subgrp: 'STATUS AKTIF'
        },
        success: response => {
          statuses = response.data
        }
      })

      $('table#roleList tbody').html(`
        ${roles.map((role) => {
          return `
          <tr>
            <td><input type="hidden" name="role_id[]" value="${role.id}">${role.rolename}</td>
            <td width="25%">
              <select name="status[]">
                ${
                  statuses.map((status) => {
                    return `<option value="${status.id}">${status.text}</option>`
                  })
                }
              </select>
            </td>
          </tr>`
        })}
      `)

      $(document)
        .find("#crudModal select")
        .select2({
          theme: "bootstrap4",
          dropdownParent: $('#crudModal')
        })
        .on("select2:open", function(e) {
          document.querySelector(".select2-search__field").focus();
        });
    })

    /* Handle button edit on click */
    $('#edit').click(function() {
      $('.is-invalid').removeClass('is-invalid')
      $('.invalid-feedback').remove()

      $('#crudForm').data('action', 'edit')
      $('#crudModal').find('button:submit').text('SIMPAN')
      $('#crudModal').find('.modal-title').text('Edit User Role')
      $('#crudModal').modal('show')

      row_id = $("#jqGrid").jqGrid('getGridParam', 'selrow')
      selectedId = $("#jqGrid").jqGrid('getCell', row_id, 'id');

      let userRole
      let roles
      let statuses
      let user

      $.ajax({
        url: `{{ config('app.api_url') . 'parameter/combo' }}`,
        method: 'GET',
        dataType: 'JSON',
        async: false,
        headers: {
          'Authorization': `Bearer {{ session('access_token') }}`
        },
        data: {
          grp: 'STATUS AKTIF',
          subgrp: 'STATUS AKTIF'
        },
        success: response => {
          statuses = response.data
        }
      })

      $.ajax({
        url: `{{ config('app.api_url') . 'user' }}`,
        method: 'GET',
        dataType: 'JSON',
        async: false,
        headers: {
          'Authorization': `Bearer {{ session('access_token') }}`
        },
        data: {
          grp: 'STATUS AKTIF',
          subgrp: 'STATUS AKTIF'
        },
        success: response => {
          user = response.data
        }
      })

      $.ajax({
        url: `{{ config('app.api_url') . 'userrole' }}/${selectedId}`,
        method: 'GET',
        dataType: 'JSON',
        async: false,
        headers: {
          'Authorization': `Bearer {{ session('access_token') }}`
        },
        success: response => {
          userRole = response.data
        }
      })

      $.ajax({
        url: `{{ config('app.api_url') . 'userrole/detaillist' }}`,
        method: 'GET',
        dataType: 'JSON',
        async: false,
        headers: {
          'Authorization': `Bearer {{ session('access_token') }}`
        },
        data: {
          user_id: userRole.user_id
        },
        success: response => {
          roles = response.data
        }
      })

      userRoleId = userRole.id

      $('#crudForm [name=user_id]').val(userRole.user_id)
      $('#crudForm [name=user]').val(userRole.user)

      $('table#roleList tbody').html(`
        ${roles.map((role) => {
          return `
            <tr>
            <td><input type="hidden" name="role_id[]" value="${role.role_id}">${role.rolename}</td>
            <td width="25%">
              <select name="status[]">
                ${
                  statuses.map((status) => {
                    return `<option value="${status.id}" ${status.id == role.status ? 'selected' : ''}>${status.text}</option>`
                  })
                }
              </select>
            </td>
          </tr>`
        })}
      `)

      $(document)
        .find("#crudModal select")
        .select2({
          theme: "bootstrap4",
          dropdownParent: $('#crudModal')
        })
        .on("select2:open", function(e) {
          document.querySelector(".select2-search__field").focus();
        });
    })

    /* Handle button delete on click */
    $('#delete').click(function() {
      $('.is-invalid').removeClass('is-invalid')
      $('.invalid-feedback').remove()

      $('#crudModal').find('.modal-title').text('Delete User Role')
      $('#crudModal').modal('show')
      $('#crudModal').find('button:submit').text('DELETE')
      $('#crudForm [name]').addClass('disabled')
      $('#crudForm').data('action', 'delete')

      row_id = $("#jqGrid").jqGrid('getGridParam', 'selrow')
      selectedId = $("#jqGrid").jqGrid('getCell', row_id, 'id');

      let userRole
      let roles
      let statuses

      $.ajax({
        url: `{{ config('app.api_url') . 'parameter/combo' }}`,
        method: 'GET',
        dataType: 'JSON',
        async: false,
        headers: {
          'Authorization': `Bearer {{ session('access_token') }}`
        },
        data: {
          grp: 'STATUS AKTIF',
          subgrp: 'STATUS AKTIF'
        },
        success: response => {
          statuses = response.data
        }
      })

      $.ajax({
        url: `{{ config('app.api_url') . 'userrole' }}/${selectedId}`,
        method: 'GET',
        dataType: 'JSON',
        async: false,
        headers: {
          'Authorization': `Bearer {{ session('access_token') }}`
        },
        success: response => {
          userRole = response.data
        }
      })

      $.ajax({
        url: `{{ config('app.api_url') . 'userrole/detaillist' }}`,
        method: 'GET',
        dataType: 'JSON',
        async: false,
        headers: {
          'Authorization': `Bearer {{ session('access_token') }}`
        },
        data: {
          user_id: userRole.user_id
        },
        success: response => {
          roles = response.data
        }
      })

      userRoleId = userRole.id

      $('#crudForm [name=user_id]').val(userRole.id)
      $('#crudForm [name=user]').val(userRole.user)

      $('table#roleList tbody').html(`
        ${roles.map((role) => {
          return `
            <tr>
            <td><input type="hidden" name="role_id[]" value="${role.role_id}">${role.rolename}</td>
            <td width="25%">
              <select name="status[]">
                ${
                  statuses.map((status) => {
                    return `<option value="${status.id}" ${status.id == role.status ? 'selected' : ''}>${status.text}</option>`
                  })
                }
              </select>
            </td>
          </tr>`
        })}
      `)

      $(document)
        .find("#crudModal select")
        .select2({
          theme: "bootstrap4",
          dropdownParent: $('#crudModal')
        })
        .on("select2:open", function(e) {
          document.querySelector(".select2-search__field").focus();
        });

      // row_id = $("#jqGrid").jqGrid('getGridParam', 'selrow')
      // selectedId = $("#jqGrid").jqGrid('getCell', row_id, 'id');

      // window.location.href = `${indexUrl}/${selectedId}/delete?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}&page=${page}&indexRow=${indexRow}`
    })

    /* Handle button export on click */
    $('#export').click(function() {
      $('#rangeModal').data('action', 'export')
      $('#rangeModal').find('button:submit').html(`Export`)
      $('#rangeModal').modal('show')
    })

    /* Handle button report on click */
    $('#report').click(function() {
      $('#rangeModal').data('action', 'report')
      $('#rangeModal').find('button:submit').html(`Report`)
      $('#rangeModal').modal('show')
    })
  })
</script>
@endpush()
@endsection