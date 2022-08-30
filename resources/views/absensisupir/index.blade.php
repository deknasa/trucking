@extends('layouts.master')

@section('content')
<!-- Modal for report -->
<div class="modal fade" id="rangeModal" tabindex="-1" aria-labelledby="rangeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rangeModalLabel">Pilih baris</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formRange" target="_blank">
        @csrf
        <div class="modal-body">
          <input type="hidden" name="sidx">
          <input type="hidden" name="sord">

          <div class="form-group row">
            <div class="col-sm-2 col-form-label">
              <label for="">Dari</label>
            </div>
            <div class="col-sm-10">
              <input type="text" name="dari" class="form-control autonumeric-report" autofocus>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-sm-2 col-form-label">
              <label for="">Sampai</label>
            </div>
            <div class="col-sm-10">
              <input type="text" name="sampai" class="form-control autonumeric-report">
            </div>
          </div>
        </div>
        <div class="modal-footer justify-content-start">
          <button type="submit" class="btn btn-primary">Report</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<div class="modal fade modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="crudForm">
      <div class="modal-content">
        <div class="modal-header bg-primary">
          <h5 class="modal-title" id="crudModalTitle">Create Absensi Supir</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form action="" method="post">
          <div class="modal-body">
            <input type="hidden" name="id">

            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>NO BUKTI</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="nobukti" class="form-control" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>NO BUKTI KGT</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="kasgantung_nobukti" class="form-control" readonly>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>TANGGAL</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="tglbukti" class="form-control datepicker">
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-2 col-form-label">
                <label>KETERANGAN</label>
              </div>
              <div class="col-12 col-md-10">
                <input type="text" name="keterangan" class="form-control">
              </div>
            </div>

            <hr>

            <table class="table table-bordered">
              <thead>
                <tr>
                  <th>Trado</th>
                  <th>Supir</th>
                  <th>Uang Jalan</th>
                  <th>Status</th>
                  <th>Jam</th>
                  <th>Keterangan</th>
                </tr>
              </thead>
              <tbody id="table_body" class="form-group">
              </tbody>
            </table>
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

<!-- Grid -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <table id="jqGrid"></table>
      <div id="jqGridPager"></div>
    </div>
  </div>
</div>

<!-- Detail -->
@include('absensisupir._detail')

@push('scripts')
<script>
  let indexUrl = "{{ route('absensisupirheader.index') }}"
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
  let sortname = 'nobukti'
  let sortorder = 'asc'
  let autoNumericElements = []

  $(document).ready(function() {
    $("#jqGrid").jqGrid({
        url: `{{ config('app.api_url') . 'absensisupirheader' }}`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        colModel: [{
            label: 'ID',
            name: 'id',
            align: 'right',
            width: '50px'
          },
          {
            label: 'NO BUKTI',
            name: 'nobukti',
            align: 'left'
          },
          {
            label: 'TANGGAL',
            name: 'tglbukti',
            align: 'left',
            formatter: 'date',
            formatoptions: {
              newformat: 'd-m-Y'
            }
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
            align: 'left'
          },
          {
            label: 'NO BUKTI KGT',
            name: 'kasgantung_nobukti',
            align: 'left'
          },
          {
            label: 'NOMINAL',
            name: 'nominal',
            align: 'right',
            formatter: 'currency',
            formatoptions: {
              decimalSeparator: ',',
              thousandsSeparator: '.'
            }
          },
          {
            label: 'MODIFIEDBY',
            name: 'modifiedby',
            align: 'left'
          },
          {
            label: 'UPDATEDAT',
            name: 'updated_at',
            align: 'left'
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
        pager: pager,
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
          delay(() => {
            loadDetailData(id)
          }, 500);

          activeGrid = $(this)
          indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
          page = $(this).jqGrid('getGridParam', 'page')
          let rows = $(this).jqGrid('getGridParam', 'postData').rows
          if (indexRow >= rows) indexRow = (indexRow - rows * (page - 1))
        },
        loadComplete: function(data) {
          $("input").attr("autocomplete", "off");
          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))

          if (data.message !== "" && data.message !== undefined && data.message !== null) {
            alert(data.message)
          }

          /* Set global variables */
          sortname = $(this).jqGrid("getGridParam", "sortname")
          sortorder = $(this).jqGrid("getGridParam", "sortorder")
          totalRecord = $(this).getGridParam("records")
          limit = $(this).jqGrid('getGridParam', 'postData').rows
          postData = $(this).jqGrid('getGridParam', 'postData')
          triggerClick = true

          $('.clearsearchclass').click(function() {
            clearColumnSearch()
          })

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

          setHighlight($(this))
        }
      })

      .jqGrid("navGrid", pager, {
        search: false,
        refresh: false,
        add: false,
        edit: false,
        del: false,
      })

      .navButtonAdd(pager, {
        caption: 'Add',
        title: 'Add',
        id: 'add',
        buttonicon: 'fas fa-plus',
        onClickButton: function() {
          createAbsensiSupir()
        }
      })

      .navButtonAdd(pager, {
        caption: 'Edit',
        title: 'Edit',
        id: 'edit',
        buttonicon: 'fas fa-pen',
        onClickButton: function() {
          selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

          editAbsensiSupir(selectedId)
        }
      })

      .navButtonAdd(pager, {
        caption: 'Delete',
        title: 'Delete',
        id: 'delete',
        buttonicon: 'fas fa-trash',
        onClickButton: function() {
          selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

          deleteAbsensiSupir(selectedId)
        }
      })

      .navButtonAdd(pager, {
        caption: 'Export',
        title: 'Export',
        id: 'export',
        buttonicon: 'fas fa-file-export',
        onClickButton: function() {
          $('#rangeModal').data('action', 'export')
          $('#rangeModal').find('button:submit').html(`Export`)
          $('#rangeModal').modal('show')
        }
      })

      .navButtonAdd(pager, {
        caption: 'Report',
        title: 'Report',
        id: 'report',
        buttonicon: 'fas fa-print',
        onClickButton: function() {
          $('#rangeModal').data('action', 'report')
          $('#rangeModal').find('button:submit').html(`Report`)
          $('#rangeModal').modal('show')
        }
      })

      .jqGrid('filterToolbar', {
        stringResult: true,
        searchOnEnter: false,
        defaultSearch: 'cn',
        groupOp: 'AND',
        disabledKeys: [16, 17, 18, 33, 34, 35, 36, 37, 38, 39, 40],
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
      .addClass(`btn-sm btn-primary`)
      .parent().addClass('px-1')

    $('#edit .ui-pg-div')
      .addClass('btn-sm btn-success')
      .parent().addClass('px-1')

    $('#delete .ui-pg-div')
      .addClass('btn-sm btn-danger')
      .parent().addClass('px-1')

    $('#report .ui-pg-div')
      .addClass('btn-sm btn-info')
      .parent().addClass('px-1')

    $('#export .ui-pg-div')
      .addClass('btn-sm btn-warning')
      .parent().addClass('px-1')

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

    $('#formRange').submit(event => {
      event.preventDefault()

      let params
      let actionUrl = ``

      if ($('#rangeModal').data('action') == 'export') {
        actionUrl = `{{ route('absensisupirheader.export') }}`
      } else if ($('#rangeModal').data('action') == 'report') {
        actionUrl = `{{ route('absensisupirheader.report') }}`
      }

      /* Clear validation messages */
      $('.is-invalid').removeClass('is-invalid')
      $('.invalid-feedback').remove()

      /* Set params value */
      for (var key in postData) {
        if (params != "") {
          params += "&";
        }
        params += key + "=" + encodeURIComponent(postData[key]);
      }

      window.open(`${actionUrl}?${$('#formRange').serialize()}&${params}`)
    })

    $(document).on('click', '#btnSubmit', function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let id = form.find('[name=id]').val()
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

      let inputs = data.filter((row) => row.name === 'uangjalan[]')

      inputs.forEach((input, index) => {
        if (input.value !== '') {
          input.value = AutoNumeric.getNumber($('#crudForm').find('[name="uangjalan[]"]')[index])
        }
      });

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}absensisupirheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}absensisupirheader/${id}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}absensisupirheader/${id}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}absensisupirheader`
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

          indexRow = response.data.position - 1

          $('#jqGrid').trigger('reloadGrid', {
            page: response.data.page
          })
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
    setFormBindKeys($('#crudForm'))
    activeGrid = null
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
  })

  function createAbsensiSupir() {
    $('#crudForm').trigger('reset')
    $('#crudForm').find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
    $('#crudModalTitle').text('Create Absensi Supir')
    $('#crudModal').modal('show')
    $('#crudForm').data('action', 'add')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    let supirs
    let statuses

    $.ajax({
      url: `{{ config('app.api_url') . 'trado' }}`,
      method: 'GET',
      dataType: 'JSON',
      async: false,
      headers: {
        Authorization: `Bearer {{ session('access_token') }}`
      },
      success: response => {
        $(document).find('#crudForm #table_body').html('')

        $.each(response.data, (index, trado) => {
          $(document).find('#crudForm #table_body').append(`
            <tr>
              <input type="hidden" name="trado_id[]" value="${trado.id}">
              <td>${trado.keterangan}</td>
              <td>
                <select class="form-control" name="supir_id[]">
                  <option hidden selected value="">-- PILIH SUPIR --</option>
                </select>
              </td>
              <td>
                  <input type="text" class="form-control autonumeric" name="uangjalan[]"></input>
              </td>
              <td>
                <select class="form-control" name="absen_id[]">
                  <option hidden selected value="">-- PILIH STATUS --</option>
                </select>
              </td>
              <td>
                  <input type="time" class="form-control" name="jam[]"></input>
              </td>
              <td>
                  <input type="text" class="form-control" name="keterangan_detail[]"></input>
              </td>
            <tr>
          `)
        })

        initSelect2($('#crudForm').find('select'))
        initAutoNumeric($('#crudForm').find('.autonumeric'))
      },
      error: error => {
        showDialog(error.statusText)
      }
    })

    $.ajax({
      url: `{{ config('app.api_url') . 'supir' }}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer {{ session('access_token') }}`
      },
      success: response => {
        let supirElements = $(`#crudForm [name="supir_id[]"]`)

        supirElements.map((index, supirElement) => {
          response.data.map((supir, index) => {
            supirElement.append(
              new Option(supir.namasupir, supir.id)
            )
          }).join('')
        })
      },
      error: error => {
        showDialog(error.statusText)
      }
    })

    $.ajax({
      url: `{{ config('app.api_url') . 'absentrado' }}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer {{ session('access_token') }}`
      },
      success: response => {
        let statusElements = $(`#crudForm [name="absen_id[]"]`)

        statusElements.map((index, statusElement) => {
          response.data.map((status, index) => {
            statusElement.append(
              new Option(status.keterangan, status.id)
            )
          }).join('')
        })
      },
      error: error => {
        showDialog(error.statusText)
      }
    })
  }

  function editAbsensiSupir(id) {
    $('#crudForm').data('action', 'edit')
    $('#crudForm').trigger('reset')
    $('#crudForm').find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
    $('#crudModalTitle').text('Edit Absensi Supir')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    let supirs
    let statuses
    let absensiSupir

    $.ajax({
      url: `{{ config('app.api_url') . 'trado' }}`,
      method: 'GET',
      dataType: 'JSON',
      async: false,
      headers: {
        Authorization: `Bearer {{ session('access_token') }}`
      },
      success: response => {
        $(document).find('#crudForm #table_body').html('')

        $.each(response.data, (index, trado) => {
          $(document).find('#crudForm #table_body').append(`
            <tr>
              <input type="hidden" name="trado_id[]" value="${trado.id}">
              <td>${trado.keterangan}</td>
              <td>
                <select class="form-control" name="supir_id[]"></select>
              </td>
              <td>
                  <input type="text" class="form-control autonumeric" name="uangjalan[]"></input>
              </td>
              <td>
                <select class="form-control" name="absen_id[]"></select>
              </td>
              <td>
                  <input type="time" class="form-control" name="jam[]"></input>
              </td>
              <td>
                  <input type="text" class="form-control" name="keterangan_detail[]"></input>
              </td>
            <tr>
          `)
        })

        initSelect2($('#crudForm').find('select'))
      },
      error: error => {
        showDialog(error.statusText)
      }
    })

    $.ajax({
      url: `{{ config('app.api_url') . 'supir' }}`,
      method: 'GET',
      dataType: 'JSON',
      async: false,
      headers: {
        Authorization: `Bearer {{ session('access_token') }}`
      },
      success: response => {
        let supirElements = $(`#crudForm [name="supir_id[]"]`)

        supirElements.map((index, supirElement) => {
          response.data.map((supir, index) => {
            supirElement.append(
              new Option(supir.namasupir, supir.id)
            )
          }).join('')
        })
      },
      error: error => {
        showDialog(error.statusText)
      }
    })

    $.ajax({
      url: `{{ config('app.api_url') . 'absentrado' }}`,
      method: 'GET',
      dataType: 'JSON',
      async: false,
      headers: {
        Authorization: `Bearer {{ session('access_token') }}`
      },
      success: response => {
        let statusElements = $(`#crudForm [name="absen_id[]"]`)

        statusElements.map((index, statusElement) => {
          response.data.map((status, index) => {
            statusElement.append(
              new Option(status.keterangan, status.id)
            )
          }).join('')
        })
      },
      error: error => {
        showDialog(error.statusText)
      }
    })

    $.ajax({
      url: `${apiUrl}absensisupirheader/${id}`,
      method: 'GET',
      dataType: 'JSON',
      async: false,
      headers: {
        Authorization: `Bearer {{ session('access_token') }}`
      },
      success: response => {
        $('#crudForm').find(`[name="id"]`).val(response.data.id)
        $('#crudForm').find(`[name="nobukti"]`).val(response.data.nobukti)
        $('#crudForm').find(`[name="kasgantung_nobukti"]`).val(response.data.kasgantung_nobukti)
        $('#crudForm').find(`[name="tglbukti"]`).val(dateFormat(response.data.tglbukti))
        $('#crudForm').find(`[name="keterangan"]`).val(response.data.keterangan)

        $.each(response.data.absensi_supir_detail, (index, detail) => {
          $($('#crudForm').find(`[name="supir_id[]"]`)[index]).val(detail.supir_id)
          $($('#crudForm').find(`[name="absen_id[]"]`)[index]).val(detail.absen_id)
          $($('#crudForm').find(`[name="jam[]"]`)[index]).val(detail.jam)
          $($('#crudForm').find(`[name="keterangan_detail[]"]`)[index]).val(detail.keterangan)

          new AutoNumeric($('#crudForm').find(`[name="uangjalan[]"]`)[index]).set(detail.uangjalan)
        })

      },
      error: error => {
        showDialog(error.statusText)
      }
    })
  }

  function deleteAbsensiSupir(id) {
    $('#crudForm').data('action', 'delete')
    $('#crudForm').trigger('reset')
    $('#crudForm').find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Hapus
    `)
    $('#crudModalTitle').text('Delete Absensi Supir')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    let supirs
    let statuses
    let absensiSupir

    $.ajax({
      url: `{{ config('app.api_url') . 'trado' }}`,
      method: 'GET',
      dataType: 'JSON',
      async: false,
      headers: {
        Authorization: `Bearer {{ session('access_token') }}`
      },
      success: response => {
        $(document).find('#crudForm #table_body').html('')

        $.each(response.data, (index, trado) => {
          $(document).find('#crudForm #table_body').append(`
            <tr>
              <input type="hidden" name="trado_id[]" value="${trado.id}">
              <td>${trado.keterangan}</td>
              <td>
                <select class="form-control" name="supir_id[]"></select>
              </td>
              <td>
                  <input type="text" class="form-control autonumeric" name="uangjalan[]"></input>
              </td>
              <td>
                <select class="form-control" name="absen_id[]"></select>
              </td>
              <td>
                  <input type="time" class="form-control" name="jam[]"></input>
              </td>
              <td>
                  <input type="text" class="form-control" name="keterangan_detail[]"></input>
              </td>
            <tr>
          `)
        })

        initSelect2($('#crudForm').find('select'))
      },
      error: error => {
        showDialog(error.statusText)
      }
    })

    $.ajax({
      url: `{{ config('app.api_url') . 'supir' }}`,
      method: 'GET',
      dataType: 'JSON',
      async: false,
      headers: {
        Authorization: `Bearer {{ session('access_token') }}`
      },
      success: response => {
        let supirElements = $(`#crudForm [name="supir_id[]"]`)

        supirElements.map((index, supirElement) => {
          response.data.map((supir, index) => {
            supirElement.append(
              new Option(supir.namasupir, supir.id)
            )
          }).join('')
        })
      },
      error: error => {
        showDialog(error.statusText)
      }
    })

    $.ajax({
      url: `{{ config('app.api_url') . 'absentrado' }}`,
      method: 'GET',
      dataType: 'JSON',
      async: false,
      headers: {
        Authorization: `Bearer {{ session('access_token') }}`
      },
      success: response => {
        let statusElements = $(`#crudForm [name="absen_id[]"]`)

        statusElements.map((index, statusElement) => {
          response.data.map((status, index) => {
            statusElement.append(
              new Option(status.keterangan, status.id)
            )
          }).join('')
        })
      },
      error: error => {
        showDialog(error.statusText)
      }
    })

    $.ajax({
      url: `${apiUrl}absensisupirheader/${id}`,
      method: 'GET',
      dataType: 'JSON',
      async: false,
      headers: {
        Authorization: `Bearer {{ session('access_token') }}`
      },
      success: response => {
        $('#crudForm').find(`[name="id"]`).val(response.data.id)
        $('#crudForm').find(`[name="nobukti"]`).val(response.data.nobukti)
        $('#crudForm').find(`[name="kasgantung_nobukti"]`).val(response.data.kasgantung_nobukti)
        $('#crudForm').find(`[name="tglbukti"]`).val(dateFormat(response.data.tglbukti))
        $('#crudForm').find(`[name="keterangan"]`).val(response.data.keterangan)

        $.each(response.data.absensi_supir_detail, (index, detail) => {
          $($('#crudForm').find(`[name="supir_id[]"]`)[index]).val(detail.supir_id)
          $($('#crudForm').find(`[name="absen_id[]"]`)[index]).val(detail.absen_id)
          $($('#crudForm').find(`[name="jam[]"]`)[index]).val(detail.jam)
          $($('#crudForm').find(`[name="keterangan_detail[]"]`)[index]).val(detail.keterangan)

          new AutoNumeric($('#crudForm').find(`[name="uangjalan[]"]`)[index]).set(detail.uangjalan)
        })

      },
      error: error => {
        showDialog(error.statusText)
      }
    })
  }
</script>
@endpush()
@endsection