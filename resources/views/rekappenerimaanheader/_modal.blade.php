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
                <label class="col-form-label">no bukti <span class="text-danger"></span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" readonly name="nobukti" class="form-control">
              </div>

              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">TGL BUKTI <span class="text-danger">*</span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <div class="input-group">
                  <input type="text" name="tglbukti" class="form-control datepicker">
                </div>

              </div>
            </div>
            <div class="row form-group">

              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">tgl transaksi <span class="text-danger">*</span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <div class="input-group">
                  <input type="text" name="tgltransaksi" onchange="setPenerimaanTgl();" class="form-control datepicker">
                </div>
              </div>

            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">KAS/bank <span class="text-danger">*</span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" name="bank" class="form-control bank-lookup">
                <input type="text" id="bankId" name="bank_id" readonly hidden>
              </div>
            </div>
            <div class="row form-group">
              <div class="col-12 col-md-12">
                <button class="btn btn-primary" type="button" id="btnTampil"><i class="fas fa-sync"></i>
                  RELOAD</button>
              </div>
            </div>

            <table id="modalgrid"></table>

            <!-- <div class="table-scroll table-responsive">
              <table class="table table-bordered table-bindkeys " id="detailList">
                <thead>
                  <tr>                  
                    <th width="50">No</th>
                    <th>no bukti</th>
                    <th>TGL TRANSAKSI</th>
                    <th>keterangan</th>
                    <th>nominal</th>
                  </tr>
                </thead>
                <tbody id="table_body" class="form-group">
                </tbody>
                <tfoot>
                  <tr>
                    <td colspan="3"></td>
                    
                    <td class="font-weight-bold"> Total : </td>
                    <td id="sumary" class="text-right font-weight-bold">  </td>
                    
                  </tr>
                </tfoot>
              </table>
            </div> -->

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
  let parameterPenerimaan = {};
  let modalBody = $('#crudModal').find('.modal-body').html()
  let selectedNobukti = [];
  let selectedTglBukti = [];
  let selectedKeterangan = [];
  let selectedNominal = [];

  let sortnamePenerimaan = 'nobukti_penerimaan';
  let sortorderPenerimaan = 'asc';
  let pagePenerimaan = 0;
  let totalRecordPenerimaan
  let limitPenerimaan
  let postDataPenerimaan
  let triggerClickPenerimaan
  let indexRowPenerimaan

  $(document).ready(function() {

    $(document).on('click', '#btnTampil', function(event) {

      getPenerimaan().then((response) => {

        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        selectedNobukti = response.data.map((data) => data.nobukti_penerimaan);
        selectedTglBukti = response.data.map((data) => data.tglbukti_penerimaan);
        selectedKeterangan = response.data.map((data) => data.keterangan_detail);
        selectedNominal = response.data.map((data) => data.nominal_detail);

        $('#modalgrid').jqGrid('setGridParam', {
          url: `${apiUrl}rekappenerimaanheader/getpenerimaan`,
          postData: {
            bank: parameterPenerimaan.bank,
            tglbukti: parameterPenerimaan.tglbukti,
            sortIndex: 'nobukti_penerimaan',
          },
          datatype: "json"
        }).trigger('reloadGrid');
      }).catch((error) => {
        if (error.status === 422) {
          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()

          setErrorMessages($('#crudForm'), error.responseJSON.errors);
        } else {
          showDialog(error.responseJSON)
        }
      })
    })

    $('#btnSubmit').click(function(event) {
      event.preventDefault()
      submit($(this).attr('id'))
    })
    $('#btnSaveAdd').click(function(event) {
      event.preventDefault()
      submit($(this).attr('id'))
    })

    function submit(button) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let rekapPenerimaanId = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()

      $.each(selectedNobukti, function(index, item) {
        data.push({
          name: 'penerimaan_nobukti[]',
          value: item
        })
      });
      $.each(selectedTglBukti, function(index, item) {
        data.push({
          name: 'tgltransaksi_detail[]',
          value: item
        })
      });
      $.each(selectedKeterangan, function(index, item) {
        data.push({
          name: 'keterangan_detail[]',
          value: item
        })
      });
      $.each(selectedNominal, function(index, item) {
        data.push({
          name: 'nominal[]',
          value: parseFloat(item.replaceAll(',', ''))
        })
      });
      data.push({
        name: 'aksi',
        value: action.toUpperCase()
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
        name: 'button',
        value: button
      })

      let tgldariheader = $('#tgldariheader').val();
      let tglsampaiheader = $('#tglsampaiheader').val()

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}rekappenerimaanheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}rekappenerimaanheader/${rekapPenerimaanId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}rekappenerimaanheader/${rekapPenerimaanId}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}rekappenerimaanheader`
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
          if (button == 'btnSubmit') {
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


            if (response.data.grp == 'FORMAT') {
              updateFormat(response.data)
            }
          } else {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
            $('#crudForm').find('input[type="text"]').data('current-value', '')
            // showSuccessDialog(response.message, response.data.nobukti)
            $("#modalgrid")[0].p.selectedRowIds = [];
            $('#modalgrid').jqGrid("clearGridData");
            $("#modalgrid")
              .jqGrid("setGridParam", {
                selectedRowIds: []
              })
              .trigger("reloadGrid");
            createRekapPenerimaanHeader();
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

  function kodepenerimaan(kodepenerimaan) {
    $('#crudForm').find('[name=statusformat]').val(kodepenerimaan).trigger('change');
  }

  $('#crudModal').on('shown.bs.modal', () => {
    let form = $('#crudForm')

    setFormBindKeys(form)

    activeGrid = null
    initDatepicker()
    initLookup()

    if (form.data('action') == 'add') {
      form.find('#btnSaveAdd').show()
    } else {
      form.find('#btnSaveAdd').hide()
    }
    loadModalGrid()
    // $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    // getMaxLength(form)
  })

  $('#crudForm').find('[name=statusformat]').change()

  function setPenerimaanTgl() {
    parameterPenerimaan.tglbukti = $('#crudForm').find('[name=tgltransaksi]').val();
  }

  function initLookup() {
    $('.bank-lookup').lookup({
      title: 'bank Lookup',
      fileName: 'bank',
      beforeProcess: function(test) {
        // var levelcoa = $(`#levelcoa`).val();
        this.postData = {

          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (bank, element) => {
        element.val(bank.kodebank)
        parameterPenerimaan.bank = bank.id;
        element.data('currentValue', element.val())
        $(`#${element[0]['name']}Id`).val(bank.id)

      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        element.data('currentValue', element.val())
        $(`#${element[0]['name']}Id`).val('')
      }
    })
  }

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    removeEditingBy($('#crudForm').find('[name=id]').val())
    $('#crudModal').find('.modal-body').html(modalBody)
    initDatepicker('datepickerIndex')
    parameterPenerimaan = {};
  })

  function removeEditingBy(id) {
    let formData = new FormData();


    formData.append('id', id);
    formData.append('aksi', 'BATAL');
    formData.append('table', 'rekappenerimaanheader');

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


  function createRekapPenerimaanHeader() {
    resetRow()
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

    form.find('#btnTampil').prop('disabled', false)
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Add Rekap Penerimaan')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    $('.invalid-feedback').remove()
  }

  function editRekapPenerimaanHeader(rekapPenerimaanId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Rekap penerimaan')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        showRekapPenerimaan(form, rekapPenerimaanId)
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

  function deleteRekapPenerimaanHeader(rekapPenerimaanId) {
    let form = $('#crudForm')

    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-trash"></i>
    Delete
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Rekap Penerimaan')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    form.find('#btnTampil').prop('disabled', true)

    Promise
      .all([
        showRekapPenerimaan(form, rekapPenerimaanId)
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

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}rekappenerimaanheader/field_length`,
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

  function resetRow() {
    $('.trow').remove()
  }

  function setRowNumbers() {
    let elements = $('table #table_body tr td:nth-child(1)')

    elements.each((index, element) => {
      $(element).text(index + 1)
    })
  }

  function sumary() {
    let sumary = 0;
    $('.totalItem').each(function() {
      var totalItem = AutoNumeric.getNumber($(this)[0]);
      sumary += totalItem;
    })
    new AutoNumeric($('#sumary')[0]).set(sumary);
  }

  function cekValidasi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}rekappenerimaanheader/${Id}/cekvalidasi`,
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
            window.open(`{{ route('rekappenerimaanheader.report') }}?id=${Id}&printer=reportPrinterBesar`)
          } else if (Aksi == 'PRINTER KECIL') {
            window.open(`{{ route('rekappenerimaanheader.report') }}?id=${Id}&printer=reportPrinterKecil`)
          } else if (Aksi == 'EDIT') {
            showDialog('REKAP PENERIMAAN TIDAK BISA DIEDIT')
          } else if (Aksi == 'DELETE') {
            deleteRekapPenerimaanHeader(Id)
          }
        }
        // var kodenobukti = response.kodenobukti
        // if (kodenobukti == '1') {
        //   var kodestatus = response.kodestatus
        //   if (kodestatus == '1') {
        //     showDialog(response.message['keterangan'])
        //   } else {
        //     if (Aksi == 'PRINTER BESAR') {
        //       window.open(`{{ route('rekappenerimaanheader.report') }}?id=${Id}&printer=reportPrinterBesar`)
        //     } else if (Aksi == 'PRINTER KECIL') {
        //       window.open(`{{ route('rekappenerimaanheader.report') }}?id=${Id}&printer=reportPrinterKecil`)
        //     } else if (Aksi == 'EDIT') {
        //       showDialog('REKAP PENERIMAAN TIDAK BISA DIEDIT')
        //     } else if (Aksi == 'DELETE') {
        //       deleteRekapPenerimaanHeader(Id)
        //     }
        //   }
        // } else {
        //   showDialog(response.message['keterangan'])
        // }
      }
    })
  }

  function showRekapPenerimaan(form, rekapPenerimaanId) {
    return new Promise((resolve, reject) => {
      resetRow()
      $.ajax({
        url: `${apiUrl}rekappenerimaanheader/${rekapPenerimaanId}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          sum = 0;
          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)
            if (element.is('select')) {
              element.val(value).trigger('change')
            } else if (element.attr("name") == 'tglbukti') {
              var result = value.split('-');
              element.val(result[2] + '-' + result[1] + '-' + result[0]);
            } else if (element.attr("name") == 'tgltransaksi') {
              var result = value.split('-');
              element.val(result[2] + '-' + result[1] + '-' + result[0]);
            } else {
              element.val(value)
            }
          })
          $('#detailList tbody').html('')
          $.each(response.detail, (index, detail) => {
            selectedNobukti.push(detail.nobukti_penerimaan)
            selectedTglBukti.push(detail.tglbukti_penerimaan)
            selectedKeterangan.push(detail.keterangan_detail)
            selectedNominal.push(detail.nominal_detail)
          })
          setTimeout(() => {
            $('#modalgrid').jqGrid('setGridParam', {
              url: `${apiUrl}rekappenerimaanheader/${rekapPenerimaanId}/getrekappenerimaan`,
              datatype: "json"
            }).trigger('reloadGrid');
          })
          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function loadModalGrid() {
    $("#modalgrid").jqGrid({
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "local",
        colModel: [{
            label: 'NO BUKTI',
            name: 'nobukti_penerimaan',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'TGL BUKTI',
            name: 'tglbukti_penerimaan',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'NOMINAL',
            name: 'nominal_detail',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },
        ],
        autowidth: true,
        shrinkToFit: false,
        height: 350,
        rowNum: 10,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [10, 20, 50, 0],
        toolbar: [true, "top"],
        sortable: true,
        sortname: sortnamePenerimaan,
        sortorder: sortorderPenerimaan,
        page: pagePenerimaan,
        viewrecords: true,
        footerrow: true,
        userDataOnFooter: true,
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

        loadComplete: function(data) {
          let grid = $(this)
          changeJqGridRowListText()
          initResize($(this))
          $(document).unbind('keydown')
          setCustomBindKeys($(this))

          /* Set global variables */
          sortnamePenerimaan = $(this).jqGrid("getGridParam", "sortname")
          sortorderPenerimaan = $(this).jqGrid("getGridParam", "sortorder")
          totalRecordPenerimaan = $(this).getGridParam("records")
          limitPenerimaan = $(this).jqGrid('getGridParam', 'postData').limit
          postDataPenerimaan = $(this).jqGrid('getGridParam', 'postData')
          triggerClick = false

          $('.clearsearchclass').click(function() {
            clearColumnSearch($(this))
          })
          if (indexRow > $(this).getDataIDs().length - 1) {
            indexRow = $(this).getDataIDs().length - 1;
          }
          $('#modalgrid').setSelection($('#modalgrid').getDataIDs()[0])
          setHighlight($(this))
          if (data.attributes) {

            $(this).jqGrid('footerData', 'set', {
              nobukti_penerimaan: 'Total:',
              nominal_detail: data.attributes.totalNominal,
            }, true)
          }
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

  function getPenerimaan() {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}rekappenerimaanheader/getpenerimaan`,
        method: 'GET',
        dataType: 'JSON',
        data: {
          limit: 0,
          bank: parameterPenerimaan.bank,
          tglbukti: parameterPenerimaan.tglbukti,
          sortIndex: 'nobukti_penerimaan',
        },
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: (response) => {
          response.url = `${apiUrl}rekappenerimaanheader/getpenerimaan`
          resolve(response)
        },
        error: error => {
          reject(error)
        }
      })
    });

  }

  // function getPenerimaan() {
  //   $('#detailList tbody').html('')
  //   $.ajax({
  //     url: `${apiUrl}rekappenerimaanheader/getpenerimaan`,
  //     method: 'GET',
  //     dataType: 'JSON',
  //     data: {
  //       limit: 0,
  //       bank: parameterPenerimaan.bank,
  //       tglbukti: parameterPenerimaan.tglbukti,
  //     },
  //     headers: {
  //       Authorization: `Bearer ${accessToken}`
  //     },
  //     success: response => {
  //       console.log(response.attributes.totalRows);
  //       let totalNominal = 0
  //       let row = 0
  //       // showDialog('REKAP PENERIMAAN TIDAK BISA DIEDIT')

  //       $.each(response.data, (index, detail) => {
  //         let id = detail.id
  //         row++
  //         tglbukti = detail.tglbukti.split("-")

  //         let detailRow = $(`
  //           <tr class="trow">
  //             <td>${row}</td>

  //             <td>
  //               ${detail.nobukti}
  //               <input type="text" value="${detail.nobukti}" id="penerimaan_nobukti" readonly hidden name="penerimaan_nobukti[]"  >
  //             </td>                 
  //             <td>
  //               ${tglbukti[2]+'-'+tglbukti[1]+'-'+tglbukti[0]}
  //               <input type="text" value="${detail.tglbukti}" id="tgltransaksi" readonly hidden name="tgltransaksi_detail[]"  >
  //             </td>                 
  //             <td>
  //               ${detail.keterangan_detail}
  //               <input type="text" value=" ${detail.keterangan_detail}" id="keterangan_detail" readonly hidden name="keterangan_detail[]"  >
  //             </td>
  //             <td>
  //               <p class="text-right nominal">${detail.nominal}</p>
  //               <input type="text" value="${detail.nominal}" id="nominal" readonly hidden name="nominal[]"  >
  //             </td>  
  //           </tr>`)
  //         $('#detailList tbody').append(detailRow)
  //         totalNominal += parseInt(detail.nominal)
  //         initAutoNumeric(detailRow.find('.nominal'))
  //       })
  //       new AutoNumeric($('#sumary')[0]).set(totalNominal);

  //     }
  //   })
  // }

  function getRekapPenerimaan(rekapPenerimaanId) {
    $('#detailList tbody').html('')
    $.ajax({
      url: `${apiUrl}rekappenerimaanheader/${rekapPenerimaanId}/getrekappenerimaan`,
      method: 'GET',
      dataType: 'JSON',
      data: {
        limit: 0,
      },
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {
        let totalNominal = 0
        let row = 0
        $.each(response.data, (index, detail) => {
          let id = detail.id
          row++

          tglbukti = detail.tglbukti.split("-")

          let detailRow = $(`
            <tr class="trow">
              <td>${row}</td>
              
              <td>
                ${detail.penerimaan_nobukti}
                <input type="text" value="${detail.penerimaan_nobukti}" id="penerimaan_nobukti" readonly hidden name="penerimaan_nobukti[]"  >
              </td>                 
              <td>
                ${tglbukti[2]+'-'+tglbukti[1]+'-'+tglbukti[0]}
                <input type="text" value="${detail.tglbukti}" id="tgltransaksi" readonly hidden name="tgltransaksi_detail[]"  >
              </td>                 
              <td>
                ${detail.keterangan_detail}
                <input type="text" value=" ${detail.keterangan_detail}" id="keterangan_detail" readonly hidden name="keterangan_detail[]"  >
              </td>
              <td>
              <p class="text-right nominal">${detail.nominal}</p>
                <input type="text" value="${detail.nominal}" id="nominal" readonly hidden name="nominal[]"  >
              </td>  
            </tr>`)


          $('#detailList tbody').append(detailRow)
          totalNominal += parseInt(detail.nominal)
          initAutoNumeric(detailRow.find('.nominal'))
        })
        new AutoNumeric($('#sumary')[0]).set(totalNominal);
      }
    })
  }
</script>
@endpush()