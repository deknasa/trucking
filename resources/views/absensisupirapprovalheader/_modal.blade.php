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
            <div class="row form-group">
              <input type="hidden" name="id" hidden class="form-control" readonly>

              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">no bukti </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" readonly name="nobukti" class="form-control">
              </div>

              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">tgl bukti </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <div class="input-group">
                  <input type="text" name="tglbukti" class="form-control datepicker" readonly>
                </div>
              </div>
            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">absensi supir <span class="text-danger">*</span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="absensisupir_nobukti" class="form-control absensisupir-lookup">
                <input type="text" id="absensisupir_kasgantung" readonly hidden name="kasgantung_nobukti">
              </div>
            </div>

            {{-- <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">keterangan <span class="text-danger">*</span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="keterangan" class="form-control">
              </div>
            </div> --}}

            <table id="modalgrid"></table>
            <div id="modalgridPager"></div>
            <div id="detailList"></div>


          </div>
          <div class="modal-footer justify-content-start">
            <button id="btnSubmit" class="btn btn-primary">
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
  let hasFormBindKeys = false
  let modalBody = $('#crudModal').find('.modal-body').html()


  function initLookup() {
    $('.absensisupir-lookup').lookup({
      title: 'absensi supir Lookup',
      fileName: 'absensisupir',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          from: 'APPROVALSUPIR',
        }
      },
      onSelectRow: (absensisupir, element) => {
        element.val(absensisupir.nobukti)
        $(`#absensisupir_kasgantung`).val(absensisupir.kasgantung_nobukti)
        $(`#crudForm [name="tglbukti"]`).val(absensisupir.tglbukti)
        if (absensisupir.is_holiday_or_sunday == 1) {
          $('#crudForm').find('[name=tglbukti]').prop('readonly', false)
          $('#crudForm').find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').show()
        } else {
          $('#crudForm').find(`[name="tglbukti"]`).prop('readonly', true)
          $('#crudForm').find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').hide()
        }
        getAbsensi(absensisupir.id)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $(`#${element[0]['name']}Id`).val('')
        element.val('')
        $(`#crudForm [name="tglbukti"]`).val('')
        element.data('currentValue', element.val())
      }
    })
  }
  $(document).ready(function() {

    $('#btnSubmit').click(function(event) {
      event.preventDefault()
      submit($(this).attr('id'))
    })
    $('#btnSaveAdd').click(function(event) {
      event.preventDefault()
      submit($(this).attr('id'))
    })


    function submit(button) {

      let method
      let url
      let form = $('#crudForm')
      let absensiSupirApproval = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()
      let sortname = 'nobukti'
      let sortorder = 'asc'

      data.push({
        name: 'button',
        value: button
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
        name: 'tgldariheader',
        value: $('#tgldariheader').val()
      })
      data.push({
        name: 'tglsampaiheader',
        value: $('#tglsampaiheader').val()
      })
      data.push({
        name: 'aksi',
        value: action.toUpperCase()
      })
      data.push({
        name: 'button',
        value: 'btnSubmit'
      })

      let tgldariheader = $('#tgldariheader').val();
      let tglsampaiheader = $('#tglsampaiheader').val()

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}absensisupirapprovalheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}absensisupirapprovalheader/${absensiSupirApproval}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}absensisupirapprovalheader/${absensiSupirApproval}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}absensisupirapprovalheader`
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

          if (button == 'btnSubmit') {
            $('#crudForm').trigger('reset')
            $('#crudModal').modal('hide')

            id = response.data.id

            $('#rangeHeader').find('[name=tgldariheader]').val(dateFormat(response.data.tgldariheader)).trigger('change');
            $('#rangeHeader').find('[name=tglsampaiheader]').val(dateFormat(response.data.tglsampaiheader)).trigger('change');
            $('#jqGrid').jqGrid('setGridParam', {
              page: response.data.page,
              postData: {
                tgldari: dateFormat(response.data.tgldariheader),
                tglsampai: dateFormat(response.data.tglsampaiheader)
              }
            }).trigger('reloadGrid');
          } else {

            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
            // showSuccessDialog(response.message, response.data.nobukti)
            createAbsensiSupirApprovalHeader()
            $('#crudForm').find('input[type="text"]').data('current-value', '')

            $('#modalgrid').jqGrid("clearGridData");
            initAutoNumeric($('#gbox_modalgrid .footrow').find(`td[aria-describedby="modalgrid_uangjalan"]`).text(0))
          }
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
    }
  })


  $('#crudModal').on('shown.bs.modal', () => {
    let form = $('#crudForm')

    setFormBindKeys(form)

    activeGrid = null

    getMaxLength(form)
    if (form.data('action') == 'add') {
      form.find('#btnSaveAdd').show()
    } else {
      form.find('#btnSaveAdd').hide()
    }
    form.find('#btnSubmit').prop('disabled', false)
    if (form.data('action') == "view") {
      form.find('#btnSubmit').prop('disabled', true)
    }
    initLookup()
    initDatepicker()
    loadModalGrid()
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    removeEditingBy($('#crudForm').find('[name=id]').val())
    $('#crudModal').find('.modal-body').html(modalBody)
    initDatepicker('datepickerIndex')
  })

  function removeEditingBy(id) {
    let formData = new FormData();


    formData.append('id', id);
    formData.append('aksi', 'BATAL');
    formData.append('table', 'absensisupirapprovalheader');

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
        $("#crudModal").modal("hide");
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



  function createAbsensiSupirApprovalHeader() {
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.data('action', 'add')
    if (selectedRows.length > 0) {
      clearSelectedRows()
    }
    form.find(`[name="tglbukti"]`).prop('readonly', true)
    setTimeout(() => {
      form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').hide()

    }, 100);
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('ADD ABSENSI SUPIR POSTING (KEUANGAN)')

    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
  }

  function editAbsensiSupirApprovalHeader(absensiSupirApproval) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit ABSENSI SUPIR POSTING (KEUANGAN)')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        ShowAbsensiSupirApproval(form, absensiSupirApproval)
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

  function deleteAbsensiSupirApprovalHeader(absensiSupirApproval) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Delete
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete ABSENSI SUPIR POSTING (KEUANGAN)')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        ShowAbsensiSupirApproval(form, absensiSupirApproval)
      ])
      .then(() => {
        if (selectedRows.length > 0) {
          clearSelectedRows()
        }
        setTimeout(() => {
          form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').hide()
        }, 100);

        $('#crudModal').modal('show')
      })
      .catch((error) => {
        showDialog(error.responseJSON)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }

  function viewAbsensiSupirApprovalHeader(absensiSupirApproval) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'view')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('View ABSENSI SUPIR POSTING (KEUANGAN)')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        ShowAbsensiSupirApproval(form, absensiSupirApproval)
      ])
      .then(() => {
        if (selectedRows.length > 0) {
          clearSelectedRows()
        }
        $('#crudModal').modal('show')
        form.find(`.hasDatepicker`).prop('readonly', true)
        form.find(`.hasDatepicker`).parent('.input-group').find('.input-group-append').remove()
        form.find(`.tbl_aksi`).hide()
      })
      .catch((error) => {
        showDialog(error.responseJSON)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }

  function ShowAbsensiSupirApproval(form, userId) {
    return new Promise((resolve, reject) => {
      $('#detailList tbody').html('')
      $.ajax({
        url: `${apiUrl}absensisupirapprovalheader/${userId}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)
            element.val(value)
            if (element.attr("name") == 'tglbukti') {
              var result = value.split('-');
              element.val(result[2] + '-' + result[1] + '-' + result[0]);
            }
          })
          getApprovalAbsensi(userId)
          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function getAbsensi(id) {
    $('#detailList').html('')


    $.ajax({
      url: `${apiUrl}absensisupirapprovalheader/${id}/getabsensi`,
      method: 'GET',
      dataType: 'JSON',
      data: {
        limit: 0
      },
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        let totalNominal = 0
        $.each(response.data, (index, detail) => {
          let id = detail.id
          let detailRow = $(`
          <input type="text" value="${detail.supir_id}" id="supir_id" name="supir_id[]"  readonly  hidden >
          <input type="text" value="${detail.trado_id}" id="trado_id" name="trado_id[]"  readonly  hidden >
          <input type="text" value="${detail.uangjalan}" id="uangjalan" name="uangjalan[]"  readonly  hidden >
          <input type="text" value="${detail.statusjeniskendaraan}" id="statusjeniskendaraan" name="statusjeniskendaraan[]"  readonly  hidden >
          `)
          $('#detailList').append(detailRow)

        })
        $('#modalgrid').jqGrid("clearGridData");
        initAutoNumeric($('#gbox_modalgrid .footrow').find(`td[aria-describedby="modalgrid_uangjalan"]`).text(response.attributes.totalUangJalan))
        $('#modalgrid').setGridParam({
          datatype: "local",
          data: response.data
        }).trigger('reloadGrid')
      }
    })


  }

  function getApprovalAbsensi(id) {
    $('#detailList').html('')

    $.ajax({
      url: `${apiUrl}absensisupirapprovalheader/${id}/getapproval`,
      method: 'GET',
      dataType: 'JSON',
      data: {
        limit: 0
      },
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        let totalNominal = 0
        let row = 0
        $.each(response.data, (index, detail) => {
          let id = detail.id
          let detailRow = $(`
          <input type="text" value="${detail.supir_id}" id="supir_id" name="supir_id[]"  readonly  hidden >
          <input type="text" value="${detail.trado_id}" id="trado_id" name="trado_id[]"  readonly  hidden >
          <input type="text" value="${detail.uangjalan}" id="uangjalan" name="uangjalan[]"  readonly  hidden >
          <input type="text" value="${detail.statusjeniskendaraan}" id="statusjeniskendaraan" name="statusjeniskendaraan[]"  readonly  hidden >
          `)
          $('#detailList').append(detailRow)

        })
        initAutoNumeric($('#gbox_modalgrid .footrow').find(`td[aria-describedby="modalgrid_uangjalan"]`).text(response.attributes.totalUangJalan))
        $('#modalgrid').setGridParam({
          datatype: "local",
          data: response.data
        }).trigger('reloadGrid')
      }
    })
  }

  function loadModalGrid() {

    $("#modalgrid").jqGrid({

        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "local",
        colModel: [{
            label: 'supir',
            name: 'supir',
          },
          {
            label: 'Trado',
            name: 'trado',
          },
          {
            label: 'keterangan detail',
            name: 'keterangan_detail',
          },
          {
            label: 'uang jalan',
            name: 'uangjalan',
            align: 'right',
            formatter: currencyFormat,
          },
        ],
        autowidth: true,
        shrinkToFit: false,
        height: 350,
        rowNum: 10000,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [10, 20, 50],
        toolbar: [true, "top"],
        sortable: true,
        //  pager:"#modalgridPager",
        viewrecords: true,
        footerrow: true,
        userDataOnFooter: true,


        loadComplete: function(data) {
          changeJqGridRowListText()
          initResize($(this))
          console.log(data);
          let nominals = $(this).jqGrid("getCol", "uangjalan")
          let totalNominal = 0

          if (nominals.length > 0) {
            totalNominal = nominals.reduce((previousValue, currentValue) => previousValue + currencyUnformat(currentValue), 0)
          }

          $('.clearsearchclass').click(function() {
            clearColumnSearch($(this))
          })

          if (indexRow > $(this).getDataIDs().length - 1) {
            indexRow = $(this).getDataIDs().length - 1;
          }

          $('#modalgrid').setSelection($('#modalgrid').getDataIDs()[0])

          setHighlight($(this))
          $(this).jqGrid('footerData', 'set', {
            trado: 'Total:',
          }, true)
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

          clearGlobalSearch($('#modalgrid'))
        },
      })
      .customPager()
    /* Append clear filter button */
    loadClearFilter($('#modalgrid'))

    /* Append global search */
    loadGlobalSearch($('#modalgrid'))

  }

  function cekValidasi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}absensisupirapprovalheader/${Id}/cekvalidasi`,
      method: 'POST',
      dataType: 'JSON',
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      data: {
        aksi: Aksi
      },
      success: response => {
        var error = response.error
        if (error) {
          showDialog(response)
        } else {
          if (Aksi == 'PRINTER BESAR') {
            window.open(`{{ route('absensisupirapprovalheader.report') }}?id=${Id}&printer=reportPrinterBesar`)
          } else if (Aksi == 'PRINTER KECIL') {
            window.open(`{{ route('absensisupirapprovalheader.report') }}?id=${Id}&printer=reportPrinterKecil`)
          } else {
            cekValidasiAksi(Id, Aksi)
          }
        }
      }
    })
  }

  function cekValidasiAksi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}absensisupirapprovalheader/${Id}/cekvalidasiaksi`,
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
            editAbsensiSupirApprovalHeader(Id)
          }
          if (Aksi == 'DELETE') {
            deleteAbsensiSupirApprovalHeader(Id)
          }
        }

      }
    })
  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}absensisupirapprovalheader/field_length`,
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
</script>
@endpush()