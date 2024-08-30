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
                  <input type="text" name="tgltransaksi" onchange="setPengeluaranTgl();" class="form-control datepicker">
                </div>
              </div>

            </div>

            <div class="row form-group">
              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">KAS/bank <span class="text-danger">*</span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-10">
                <input type="text" id="bankId" name="bank_id" readonly hidden>
                <input type="text" name="bank" id="bank" class="form-control bank-lookup">
              
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
                    <td id="sumary" class="text-right font-weight-bold"> </td>

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
  let parameterPengeluaran = {};
  let modalBody = $('#crudModal').find('.modal-body').html()
  let selectedRowsId = []
  let selectedNobukti = [];
  let selectedTglBukti = [];
  let selectedKeterangan = [];
  let selectedNominal = [];
  let sortnamePengeluaran = 'nobukti_pengeluaran';
  let sortorderPengeluaran = 'asc';
  let pagePengeluaran = 0;
  let totalRecordPengeluaran
  let limitPengeluaran
  let postDataPengeluaran
  let triggerClickPengeluaran
  let indexRowPengeluaran

  $(document).ready(function() {

    $(document).on('click', '#btnTampil', function(event) {

      getPengeluaran().then((response) => {

        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        selectedRowsId = response.data.map((data) => data.id)
        selectedNobukti = response.data.map((data) => data.nobukti_pengeluaran);
        selectedTglBukti = response.data.map((data) => data.tglbukti_pengeluaran);
        selectedKeterangan = response.data.map((data) => data.keterangan_detail);
        selectedNominal = response.data.map((data) => data.nominal_detail);

        $('#modalgrid').jqGrid('setGridParam', {
          url: `${apiUrl}rekappengeluaranheader/getpengeluaran`,
          postData: {
            bank: parameterPengeluaran.bank,
            tglbukti: parameterPengeluaran.tglbukti,
            sortIndex: 'nobukti_pengeluaran',
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

      let method
      let url
      let form = $('#crudForm')
      let rekapPengeluaranId = form.find('[name=id]').val()
      let action = form.data('action')
      let data = $('#crudForm').serializeArray()

      $.each(selectedNobukti, function(index, item) {
        data.push({
          name: 'pengeluaran_nobukti[]',
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
      let tgldariheader = $('#tgldariheader').val();
      let tglsampaiheader = $('#tglsampaiheader').val()

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}rekappengeluaranheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}rekappengeluaranheader/${rekapPengeluaranId}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}rekappengeluaranheader/${rekapPengeluaranId}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}rekappengeluaranheader`
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

            if (id == 0) {
              $('#detail').jqGrid().trigger('reloadGrid')
            }
          } else {

            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
            // showSuccessDialog(response.message, response.data.nobukti)
            createRekapPengeluaranHeader()
            $('#crudForm').find('input[type="text"]').data('current-value', '')

            selectedRowsId = []
            selectedNobukti = []
            selectedTglBukti = []
            selectedKeterangan = []
            selectedNominal = []
            $('#modalgrid').jqGrid("clearGridData");
            initAutoNumeric($('#gbox_modalgrid .footrow').find(`td[aria-describedby="modalgrid_nominal_detail"]`).text(0))
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

  function kodepengeluaran(kodepengeluaran) {
    $('#crudForm').find('[name=statusformat]').val(kodepengeluaran).trigger('change');
  }

  $('#crudModal').on('shown.bs.modal', () => {
    let form = $('#crudForm')

    setFormBindKeys(form)

    if (form.data('action') == 'add') {
      form.find('#btnSaveAdd').show()
    } else {
      form.find('#btnSaveAdd').hide()
    }
    activeGrid = null
    initDatepicker()
    initLookup()
    loadModalGrid()
    // $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date()) ).trigger('change');
    // getMaxLength(form)
  })

  $('#crudForm').find('[name=statusformat]').change()

  function setPengeluaranTgl() {
    parameterPengeluaran.tglbukti = $('#crudForm').find('[name=tgltransaksi]').val();
  }


  function initLookup() {
    // $('.bank-lookup').lookup({
    //   title: 'Bank Lookup',
    //   fileName: 'bank',
    //   beforeProcess: function(test) {
    //     // var levelcoa = $(`#levelcoa`).val();
    //     this.postData = {

    //       Aktif: 'AKTIF',
    //       from: 'pengeluaran'
    //     }
    //   },
    //   onSelectRow: (bank, element) => {
    //     element.val(bank.kodebank)
    //     parameterPengeluaran.bank = bank.id;
    //     getPengeluaran();
    //     element.data('currentValue', element.val())
    //     $(`#${element[0]['name']}Id`).val(bank.id)

    //   },
    //   onCancel: (element) => {
    //     element.val(element.data('currentValue'))
    //   }
    // })

    $('.bank-lookup').lookupV3({
        title: 'Bank Lookup',
        fileName: 'bankV3',
        searching: ['namabank'],
        labelColumn: false,
        // filterToolbar:true,
        beforeProcess: function(test) {
            this.postData = {
              Aktif: 'AKTIF',
              from: 'pengeluaran'
            }
        },
        onSelectRow: (bank, element) => {
          element.val(bank.namabank)
          parameterPengeluaran.bank = bank.id;
          getPengeluaran();
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
    parameterPengeluaran = {};
    initDatepicker('datepickerIndex')

  })

  function removeEditingBy(id) {
    let formData = new FormData();


    formData.append('id', id);
    formData.append('aksi', 'BATAL');
    formData.append('table', 'rekappengeluaranheader');

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


  function createRekapPengeluaranHeader() {
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
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Add Rekap Pengeluaran')
    form.find('#btnTampil').prop('disabled', false)

    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
  }

  function editRekapPengeluaranHeader(rekapPengeluaranId) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Rekap Pengeluaran')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        showRekapPengeluaran(form, rekapPengeluaranId)
      ])
      .then(() => {
        if (selectedRows.length > 0) {
          clearSelectedRows()
        }
        $('#crudModal').modal('show')
        form.find(`[name="tglbukti"]`).prop('readonly', true)
        form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
        form.find(`[name="tgltransaksi"]`).prop('readonly', true)
        form.find(`[name="tgltransaksi"]`).parent('.input-group').find('.input-group-append').remove()
        form.find(`[name="bank"]`).prop('readonly', true)
        form.find(`[name="bank"]`).parent('.input-group').find('.input-group-append').remove()
        form.find(`[name="bank"]`).parent('.input-group').find('.button-clear').remove()
      })
      .catch((error) => {
        showDialog(error.statusText)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }

  function deleteRekapPengeluaranHeader(rekapPengeluaranId) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-trash"></i>
    Delete
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Rekap Pengeluaran')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    form.find('#btnTampil').prop('disabled', true)

    Promise
      .all([
        showRekapPengeluaran(form, rekapPengeluaranId)
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
        url: `${apiUrl}rekappengeluaranheader/field_length`,
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

  function showRekapPengeluaran(form, rekapPengeluaranId) {
    return new Promise((resolve, reject) => {
      resetRow()
      $.ajax({
        url: `${apiUrl}rekappengeluaranheader/${rekapPengeluaranId}`,
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
            selectedRowsId.push(detail.id)
            selectedNobukti.push(detail.nobukti_pengeluaran)
            selectedTglBukti.push(detail.tglbukti_pengeluaran)
            selectedKeterangan.push(detail.keterangan_detail)
            selectedNominal.push(detail.nominal_detail)
          })
          setTimeout(() => {
            $('#modalgrid').jqGrid('setGridParam', {
              url: `${apiUrl}rekappengeluaranheader/${rekapPengeluaranId}/getrekappengeluaran`,
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

  function cekValidasi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}rekappengeluaranheader/${Id}/cekvalidasi`,
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
            window.open(`{{url('rekappengeluaranheader/report/${Id}?printer=reportPrinterBesar')}}`)
          } else if (Aksi == 'PRINTER KECIL') {
            window.open(`{{url('rekappengeluaranheader/report/${Id}?printer=reportPrinterKecil')}}`)
          } else if (Aksi == 'EDIT') {
            showDialog('REKAP PENGELUARAN TIDAK BISA DIEDIT')
          } else if (Aksi == 'DELETE') {
            deleteRekapPengeluaranHeader(Id)
          }
        }

        // var kodenobukti = response.kodenobukti
        // if (kodenobukti == '1') {
        //   var kodestatus = response.kodestatus
        //   if (kodestatus == '1') {
        //     showDialog(response.message['keterangan'])
        //   } else {
        //     if (Aksi == 'PRINTER BESAR') {
        //       window.open(`{{url('rekappengeluaranheader/report/${Id}?printer=reportPrinterBesar')}}`)
        //     } else if (Aksi == 'PRINTER KECIL') {
        //       window.open(`{{url('rekappengeluaranheader/report/${Id}?printer=reportPrinterKecil')}}`)
        //     } else if (Aksi == 'EDIT') {
        //       showDialog('REKAP PENGELUARAN TIDAK BISA DIEDIT')
        //     } else if (Aksi == 'DELETE') {
        //       deleteRekapPengeluaranHeader(Id)
        //     }
        //   }
        // } else {
        //   showDialog(response.message['keterangan'])
        // }
      }
    })
  }

  function loadModalGrid() {
    $("#modalgrid").jqGrid({
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "local",
        colModel: [{
            label: 'NO BUKTI',
            name: 'nobukti_pengeluaran',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'TGL BUKTI',
            name: 'tglbukti_pengeluaran',
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
        sortname: sortnamePengeluaran,
        sortorder: sortorderPengeluaran,
        page: pagePengeluaran,
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
          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))

          /* Set global variables */
          sortnamePengeluaran = $(this).jqGrid("getGridParam", "sortname")
          sortorderPengeluaran = $(this).jqGrid("getGridParam", "sortorder")
          totalRecordPengeluaran = $(this).getGridParam("records")
          limitPengeluaran = $(this).jqGrid('getGridParam', 'postData').limit
          postDataPengeluaran = $(this).jqGrid('getGridParam', 'postData')
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
              nobukti_pengeluaran: 'Total:',
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

  function getPengeluaran() {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}rekappengeluaranheader/getpengeluaran`,
        method: 'GET',
        dataType: 'JSON',
        data: {
          limit: 0,
          bank: parameterPengeluaran.bank,
          tglbukti: parameterPengeluaran.tglbukti,
          sortIndex: 'nobukti_pengeluaran',
        },
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: (response) => {
          response.url = `${apiUrl}rekappengeluaranheader/getpengeluaran`
          resolve(response)
        },
        error: error => {
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
            errors = error.responseJSON.errors
            reject(errors)

          } else {
            showDialog(error.statusText)
          }
        },
        error: error => {
          reject(error)
        }
      })
    });

  }

  // function getPengeluaran() {
  //   $('#detailList tbody').html('')
  //   $.ajax({
  //     url: `${apiUrl}rekappengeluaranheader/getpengeluaran`,
  //     method: 'GET',
  //     dataType: 'JSON',
  //     data: {
  //       limit: 0,
  //       bank: parameterPengeluaran.bank,
  //       tglbukti: parameterPengeluaran.tglbukti,
  //     },
  //     headers: {
  //       Authorization: `Bearer ${accessToken}`
  //     },
  //     success: response => {
  //       let totalNominal = 0
  //       let row = 0
  //       $.each(response.data, (index, detail) => {
  //         let id = detail.id
  //         row++
  //         let detailRow = $(`
  //           <tr class="trow">
  //             <td>${row}</td>

  //             <td>
  //               ${detail.nobukti}
  //               <input type="text" value="${detail.nobukti}" id="pengeluaran_nobukti" readonly hidden name="pengeluaran_nobukti[]"  >
  //             </td>                 
  //             <td>
  //               ${detail.tglbukti}
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

  function getRekapPengeluaran(rekapPengeluaranId) {
    $('#detailList tbody').html('')
    $.ajax({
      url: `${apiUrl}rekappengeluaranheader/${rekapPengeluaranId}/getrekappengeluaran`,
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
          let detailRow = $(`
            <tr class="trow">
              <td>${row}</td>
              
              <td>
                ${detail.pengeluaran_nobukti}
                <input type="text" value="${detail.pengeluaran_nobukti}" id="pengeluaran_nobukti" readonly hidden name="pengeluaran_nobukti[]"  >
              </td>                 
              <td>
                ${detail.tglbukti}
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