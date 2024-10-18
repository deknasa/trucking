<div class="modal modal-fullscreen" id="crudModal" tabindex="-1" aria-labelledby="crudModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <form action="#" id="crudForm">
      <div class="modal-content">

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

            <div class="row">

              <div class="form-group col-md-6">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4 col-form-label">
                    <label>CUSTOMER <span class="text-danger">*</span> </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <input type="text" name="agen" id="agen" class="form-control agen-lookup">
                    <input type="text" id="agenId" name="agen_id" readonly hidden>
                  </div>
                </div>
              </div>

              <div class="form-group col-md-6">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4 col-form-label">
                    <label>tgl proses <span class="text-danger">*</span> </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <div class="input-group">
                      <input type="text" name="tglproses" class="form-control datepicker">
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="form-group col-md-6">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4 col-form-label">
                    <label>tgl jatuh tempo <span class="text-danger">*</span> </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <div class="input-group">
                      <input type="text" name="tgljatuhtempo" class="form-control datepicker">
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="row mt-3">
              <div class="col-sm-4">
                <a id="btnTampil" class="btn btn-primary mr-2 mb-2">
                  <i class="fas fa-sync"></i>
                  Reload
                </a>
              </div>
            </div>


            <input type="text" name="nominal_header" readonly hidden id="nominal_header">

            <table id="modalgrid"></table>
            <div id="modalgridPager"></div>
            <div id="detailList" style="display:none"></div>
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
  let rowIndex = 0;
  let selectedRowsInvoice = []
  let selectedJobTrucking = [];
  let selectedNoPolisi = [];
  let selectedGandengan = [];
  let selectedTglTrip = [];
  let selectedTglAkhir = [];
  let selectedJumlahHari = [];
  let selectedNominal = [];
  let selectedJenisOrder = [];
  let selectedNamaGudang = [];
  let selectedKeterangan = [];

  let sortnameInvoice = 'jobtrucking';
  let sortorderInvoice = 'asc';
  let pageInvoice = 0;
  let totalRecordInvoice
  let limitInvoice
  let postDataInvoice
  let triggerClickInvoice
  let indexRowInvoice
  let isEditTgl

  $(document).ready(function() {

    $('#crudForm').autocomplete({
      disabled: true
    });
    $(document).on('click', '.delete-row', function(event) {
      deleteRow($(this).parents('tr'))
    })


    $(document).on('click', '#btnTampil', function(event) {
      console.log('reloaad');
      let agen_id = $('#crudForm').find(`[name=agen_id]`).val()
      let tglproses = $('#crudForm').find(`[name=tglproses]`).val()
      if ((agen_id != '') && (tglproses != '')) {
        getJobTrucking(agen_id, tglproses)
          .then((response) => {


            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            $('#modalgrid').jqGrid('setGridParam', {
              url: `${apiUrl}orderantrucking/getorderantrip`,
              postData: {
                tglbukti: tglproses,
                agen: agen_id,
                sortIndex: 'jobtrucking',
                aksi: $('#crudForm').data('action'),
                idInvoice: $('#crudForm').find(`[name=id]`).val()
              },
              datatype: "json"
            }).trigger('reloadGrid');
          }).catch((error) => {
            if (error.status === 422) {
              $('.is-invalid').removeClass('is-invalid')
              $('.invalid-feedback').remove()

              setErrorMessages(form, error.responseJSON.errors);
            } else {
              showDialog(error.responseJSON)
            }
          })
      }

    })


    $('#btnSubmit').click(function(event) {
      event.preventDefault()

      let method
      let url
      let form = $('#crudForm')
      let invoiceChargeGandenganHeader = form.find('[name=id]').val()
      let action = form.data('action')
      let data = []

      // $('#crudForm').find(`[name="nominal_detail[]"]`).each((index, element) => {
      //   data.filter((row) => row.name === 'nominal_detail[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominal_detail[]"]`)[index])
      // })

      // $('#crudForm').find(`[name="detail_persentasediscount[]"]`).each((index, element) => {
      //   data.filter((row) => row.name === 'detail_persentasediscount[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="detail_persentasediscount[]"]`)[index])
      // })
      data.push({
        name: 'id',
        value: form.find(`[name="id"]`).val()
      })
      data.push({
        name: 'nobukti',
        value: form.find(`[name="nobukti"]`).val()
      })
      data.push({
        name: 'tglbukti',
        value: form.find(`[name="tglbukti"]`).val()
      })
      data.push({
        name: 'tglproses',
        value: form.find(`[name="tglproses"]`).val()
      })
      data.push({
        name: 'tgljatuhtempo',
        value: form.find(`[name="tgljatuhtempo"]`).val()
      })
      data.push({
        name: 'agen',
        value: form.find(`[name="agen"]`).val()
      })
      data.push({
        name: 'agen_id',
        value: form.find(`[name="agen_id"]`).val()
      })

      data.push({
        name: 'jumlahdetail',
        value: selectedRowsInvoice.length
      })
      $.each(selectedRowsInvoice, function(index, item) {
        data.push({
          name: 'id_detail[]',
          value: item
        })
      });
      $.each(selectedJobTrucking, function(index, item) {
        data.push({
          name: 'jobtrucking_detail[]',
          value: item
        })
      });
      $.each(selectedNoPolisi, function(index, item) {
        data.push({
          name: 'nopolisi_detail[]',
          value: item
        })
      });
      $.each(selectedGandengan, function(index, item) {
        data.push({
          name: 'gandengan_detail[]',
          value: item
        })
      });
      $.each(selectedTglTrip, function(index, item) {
        data.push({
          name: 'tgltrip_detail[]',
          value: item
        })
      });
      $.each(selectedTglAkhir, function(index, item) {
        data.push({
          name: 'tglkembali_detail[]',
          value: item
        })
      });
      $.each(selectedJumlahHari, function(index, item) {
        data.push({
          name: 'jumlahhari_detail[]',
          value: item
        })
      });
      $.each(selectedNominal, function(index, item) {
        data.push({
          name: 'nominal_detail[]',
          value: parseFloat(item.replaceAll(',', ''))
        })
      });
      $.each(selectedJenisOrder, function(index, item) {
        data.push({
          name: 'jenisorder_detail[]',
          value: item
        })
      });
      $.each(selectedNamaGudang, function(index, item) {
        data.push({
          name: 'namagudang_detail[]',
          value: item
        })
      });
      $.each(selectedKeterangan, function(index, item) {
        data.push({
          name: 'keterangan_detail[]',
          value: item
        })
      });

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
      let tgldariheader = $('#tgldariheader').val();
      let tglsampaiheader = $('#tglsampaiheader').val()

      switch (action) {
        case 'add':
          method = 'POST'
          url = `${apiUrl}invoicechargegandenganheader`
          break;
        case 'edit':
          method = 'PATCH'
          url = `${apiUrl}invoicechargegandenganheader/${invoiceChargeGandenganHeader}`
          break;
        case 'delete':
          method = 'DELETE'
          url = `${apiUrl}invoicechargegandenganheader/${invoiceChargeGandenganHeader}?tgldariheader=${tgldariheader}&tglsampaiheader=${tglsampaiheader}&indexRow=${indexRow}&limit=${limit}&page=${page}`
          break;
        default:
          method = 'POST'
          url = `${apiUrl}invoicechargegandenganheader`
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

          $('#rangeHeader').find('[name=tgldariheader]').val(dateFormat(response.data.tgldariheader)).trigger('change');
          $('#rangeHeader').find('[name=tglsampaiheader]').val(dateFormat(response.data.tglsampaiheader)).trigger('change');
          $('#jqGrid').jqGrid('setGridParam', {
            page: response.data.page,
            postData: {
              tgldari: dateFormat(response.data.tgldariheader),
              tglsampai: dateFormat(response.data.tglsampaiheader)
            }
          }).trigger('reloadGrid');
          clearSelectedRowsInvoice()
          if (id == 0) {
            $('#detail').jqGrid().trigger('reloadGrid')
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
    })
  })

  $('#crudModal').on('shown.bs.modal', () => {
    let form = $('#crudForm')

    setFormBindKeys(form)

    activeGrid = null
    initLookup()
    initDatepicker()
    loadModalGrid()
    // getMaxLength(form)
  })

  $('#crudModal').on('hidden.bs.modal', () => {
    activeGrid = '#jqGrid'
    removeEditingBy($('#crudForm').find('[name=id]').val())
    $('#crudModal').find('.modal-body').html(modalBody)
    clearSelectedRowsInvoice()
    initDatepicker('datepickerIndex')
  })

  function removeEditingBy(id) {
    if (id == "") {
      return ;
    }
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
        table: 'invoicechargegandenganheader'

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

  function cekValidasi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}invoicechargegandenganheader/${Id}/cekvalidasi`,
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
          cekValidasiAksi(Id, Aksi)
        }

      }
    })
  }

  function cekValidasiAksi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}invoicechargegandenganheader/${Id}/cekvalidasiAksi`,
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
            editInvoiceChargeGandenganHeader(Id)
          }
          if (Aksi == 'DELETE') {
            deleteInvoiceChargeGandenganHeader(Id)
          }
        }

      }
    })
  }


  function createInvoiceChargeGandenganHeader() {
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Save
    `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create Invoice Charge Gandengan')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    $('#table_body').html('')

    if (selectedRows.length > 0) {
      clearSelectedRows()
    }
    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    $('#crudForm').find('[name=tglproses]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    $('#crudForm').find('[name=tgljatuhtempo]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
  }

  function editInvoiceChargeGandenganHeader(invoiceChargeGandenganHeader) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Save
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Invoice Charge Gandengan')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        setTglBukti(form),
        showInvoiceChargeGandenganHeader(form, invoiceChargeGandenganHeader)
      ])
      .then(() => {
        if (selectedRows.length > 0) {
          clearSelectedRows()
        }
        $('#crudModal').modal('show')
        if (isEditTgl == 'TIDAK') {
          form.find(`[name="tglbukti"]`).prop('readonly', true)
          form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()
        }
        form.find(`[name="agen"]`).parent('.input-group').find('.button-clear').remove()
        form.find(`[name="agen"]`).parent('.input-group').find('.input-group-append').remove()
      })
      .catch((error) => {
        showDialog(error.responseJSON)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })
  }

  function deleteInvoiceChargeGandenganHeader(invoiceChargeGandenganHeader) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'delete')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-trash"></i>
    Delete
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Invoice Charge Gandengan')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()
    $('#btnTampil').prop('disabled', true)
    Promise
      .all([
        showInvoiceChargeGandenganHeader(form, invoiceChargeGandenganHeader)
      ])
      .then(() => {
        if (selectedRows.length > 0) {
          clearSelectedRows()
        }
        $('#crudModal').modal('show')
      })
      .catch((error) => {
        showDialog(error.responseJSON)
      })
      .finally(() => {
        $('.modal-loader').addClass('d-none')
      })

  }

  function getMaxLength(form) {
    if (!form.attr('has-maxlength')) {
      $.ajax({
        url: `${apiUrl}invoicechargegandenganheader/field_length`,
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


  function loadModalGrid() {
    let disabled = '';
    if ($('#crudForm').data('action') == 'delete') {
      disabled = 'disabled'
    }

    $("#modalgrid").jqGrid({
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "local",
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
                // $(element).attr('id', 'gsRincian')
                let agen_id = $('#crudForm').find(`[name=agen_id]`).val()
                let tglproses = $('#crudForm').find(`[name=tglproses]`).val()

                $(element).removeClass('form-control')
                $(element).parent().addClass('text-center')
                if (disabled == '') {
                  $(element).on('click', function() {
                    $(element).attr('disabled', true)

                    if ($(this).is(':checked')) {
                      selectAllRowsInvoice()
                    } else {
                      clearSelectedRowsInvoice(element)
                    }
                  })
                } else {
                  $(element).attr('disabled', true)
                }
              }
            },
            formatter: (value, rowOptions, rowData) => {
              return `<input type="checkbox" name="idgrid[]" value="${rowData.id}" ${disabled} onchange="checkboxHandlerInvoice(this)">`
            },
          },
          {
            label: 'ID',
            name: 'id',
            width: '50px',
            hidden: true
          },
          {
            label: 'NO BUKTI',
            name: 'jobtrucking',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'TGL MASUK GUDANG',
            name: 'tgltrip',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'TGL KELUAR GUDANG',
            name: 'tglkembali',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'jlh Hari',
            name: 'jumlahhari',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
          },
          {
            label: 'NOMINAL',
            name: 'nominal_detail',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'Jenis Order',
            name: 'jenisorder',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'Nama Gudang',
            name: 'namagudang',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'No Polisi',
            name: 'nopolisi',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'Gandengan',
            name: 'gandengan',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'trado_id',
            name: 'trado_id',
            hidden: true,
            search: false
          },
          {
            label: 'gandengan_id',
            name: 'gandengan_id',
            hidden: true,
            search: false
          },
          {
            label: 'keterangan',
            name: 'keterangan',
            width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
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
        sortname: sortnameInvoice,
        sortorder: sortorderInvoice,
        page: pageInvoice,
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

          sortnameInvoice = $(this).jqGrid("getGridParam", "sortname")
          sortorderInvoice = $(this).jqGrid("getGridParam", "sortorder")
          totalRecordInvoice = $(this).getGridParam("records")
          limitInvoice = $(this).jqGrid('getGridParam', 'postData').limit
          postDataInvoice = $(this).jqGrid('getGridParam', 'postData')
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
              jobtrucking: 'Total:',
              nominal_detail: data.attributes.totalNominal,
            }, true)
          }

          $.each(selectedRowsInvoice, function(key, value) {
            $(grid).find('tbody tr').each(function(row, tr) {
              if ($(this).find(`td input:checkbox`).val() == value) {
                $(this).addClass('bg-light-blue')
                $(this).find(`td input:checkbox`).prop('checked', true)
              }
            })
          });
          if (disabled == '') {
            $('#gs_').attr('disabled', false)
          } else {
            $('#gs_').attr('disabled', true)
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

  function clearSelectedRowsInvoice(element = null) {
    selectedRowsInvoice = []
    selectedJobTrucking = [];
    selectedNoPolisi = [];
    selectedGandengan = [];
    selectedTglTrip = [];
    selectedTglAkhir = [];
    selectedJumlahHari = [];
    selectedNominal = [];
    selectedJenisOrder = [];
    selectedNamaGudang = [];
    selectedKeterangan = [];
    $('#modalgrid').trigger('reloadGrid')
  }

  function selectAllRowsInvoice() {
    agen_id = $('#crudForm').find(`[name=agen_id]`).val()
    tglproses = $('#crudForm').find(`[name=tglproses]`).val()

    $.ajax({
      url: `${apiUrl}orderantrucking/getorderantrip`,
      method: 'GET',
      dataType: 'JSON',
      data: {
        limit: 0,
        tglbukti: tglproses,
        agen: agen_id,
        sortIndex: 'jobtrucking',
        aksi: $('#crudForm').data('action'),
        idInvoice: $('#crudForm').find(`[name=id]`).val()
      },
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: (response) => {
        selectedRowsInvoice = []
        selectedJobTrucking = [];
        selectedNoPolisi = [];
        selectedGandengan = [];
        selectedTglTrip = [];
        selectedTglAkhir = [];
        selectedJumlahHari = [];
        selectedNominal = [];
        selectedJenisOrder = [];
        selectedNamaGudang = [];
        selectedKeterangan = [];

        selectedRowsInvoice = response.data.map((data) => data.id)
        selectedJobTrucking = response.data.map((data) => data.jobtrucking)
        selectedNoPolisi = response.data.map((data) => data.trado_id)
        selectedGandengan = response.data.map((data) => data.gandengan_id)
        selectedTglTrip = response.data.map((data) => data.tgltrip)
        selectedTglAkhir = response.data.map((data) => data.tglkembali)
        selectedJumlahHari = response.data.map((data) => data.jumlahhari)
        selectedNominal = response.data.map((data) => data.nominal_detail)
        selectedJenisOrder = response.data.map((data) => data.jenisorder)
        selectedNamaGudang = response.data.map((data) => data.namagudang)
        selectedKeterangan = response.data.map((data) => data.keterangan)

        $('#modalgrid').jqGrid('setGridParam', {
          url: `${apiUrl}orderantrucking/getorderantrip`,
          postData: {
            tglbukti: tglproses,
            agen: agen_id,
            sortIndex: 'jobtrucking',
            aksi: $('#crudForm').data('action'),
            idInvoice: $('#crudForm').find(`[name=id]`).val()
          },
          datatype: "json"
        }).trigger('reloadGrid');
      }
    })

  }

  function getJobTrucking(agen_id, tglproses) {
    // if (aksi == 'edit') {
    //   ricId = $(`#crudForm`).find(`[name="id"]`).val()
    //   url = `${ricId}/getEditTrip`
    // } else {
    //   url = 'getTrip'
    // }
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${apiUrl}orderantrucking/getorderantrip`,
        method: 'GET',
        dataType: 'JSON',
        data: {
          limit: 0,
          tglbukti: tglproses,
          agen: agen_id,
          sortIndex: 'jobtrucking',
          aksi: $('#crudForm').data('action'),
          idInvoice: $('#crudForm').find(`[name=id]`).val()
        },
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: (response) => {
          response.url = `${apiUrl}orderantrucking/getorderantrip`
          selectedRowsInvoice = []
          selectedJobTrucking = [];
          selectedNoPolisi = [];
          selectedGandengan = [];
          selectedTglTrip = [];
          selectedTglAkhir = [];
          selectedJumlahHari = [];
          selectedNominal = [];
          selectedJenisOrder = [];
          selectedNamaGudang = [];
          selectedKeterangan = [];

          $.each(response.data, (index, detail) => {
            if (detail.noinvoice != '') {

              selectedRowsInvoice.push(detail.id)
              selectedJobTrucking.push(detail.jobtrucking)
              selectedNoPolisi.push(detail.trado_id)
              selectedGandengan.push(detail.gandengan_id)
              selectedTglTrip.push(detail.tgltrip)
              selectedTglAkhir.push(detail.tglkembali)
              selectedJumlahHari.push(detail.jumlahhari)
              selectedNominal.push(detail.nominal_detail)
              selectedJenisOrder.push(detail.jenisorder)
              selectedNamaGudang.push(detail.namagudang)
              selectedKeterangan.push(detail.keterangan)
            }
          })
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

  function checkboxHandlerInvoice(element) {
    let value = $(element).val();
    if (element.checked) {
      selectedRowsInvoice.push($(element).val())
      selectedJobTrucking.push($(element).parents('tr').find(`td[aria-describedby="modalgrid_jobtrucking"]`).text())
      selectedNoPolisi.push($(element).parents('tr').find(`td[aria-describedby="modalgrid_trado_id"]`).text())
      selectedGandengan.push($(element).parents('tr').find(`td[aria-describedby="modalgrid_gandengan_id"]`).text())
      selectedTglTrip.push($(element).parents('tr').find(`td[aria-describedby="modalgrid_tgltrip"]`).text())
      selectedTglAkhir.push($(element).parents('tr').find(`td[aria-describedby="modalgrid_tglkembali"]`).text())
      selectedJumlahHari.push($(element).parents('tr').find(`td[aria-describedby="modalgrid_jumlahhari"]`).text())
      selectedNominal.push($(element).parents('tr').find(`td[aria-describedby="modalgrid_nominal_detail"]`).text())
      selectedJenisOrder.push($(element).parents('tr').find(`td[aria-describedby="modalgrid_jenisorder"]`).text())
      selectedNamaGudang.push($(element).parents('tr').find(`td[aria-describedby="modalgrid_namagudang"]`).text())
      selectedKeterangan.push($(element).parents('tr').find(`td[aria-describedby="modalgrid_keterangan"]`).text())
      $(element).parents('tr').addClass('bg-light-blue')
    } else {
      $(element).parents('tr').removeClass('bg-light-blue')
      for (var i = 0; i < selectedRowsInvoice.length; i++) {
        if (selectedRowsInvoice[i] == value) {
          selectedRowsInvoice.splice(i, 1);
          selectedJobTrucking.splice(i, 1);
          selectedNoPolisi.splice(i, 1);
          selectedGandengan.splice(i, 1);
          selectedTglTrip.splice(i, 1);
          selectedTglAkhir.splice(i, 1);
          selectedJumlahHari.splice(i, 1);
          selectedNominal.splice(i, 1);
          selectedJenisOrder.splice(i, 1);
          selectedNamaGudang.splice(i, 1);
          selectedKeterangan.splice(i, 1);
        }
      }
    }
  }


  function getInvoiceChargeGandenganHeader(id) {


    $('#modalgrid').jqGrid('setGridParam', {
      url: `${apiUrl}invoicechargegandenganheader/${id}/getinvoicegandengan`,
      postData: {
        tglbukti: $('#crudForm').find(`[name=tglproses]`).val(),
        agen: $('#crudForm').find(`[name=agen_id]`).val(),
        sortIndex: 'jobtrucking',
        aksi: 'show'
      },
      datatype: "json"
    }).trigger('reloadGrid');
    // $('#detailList').html('')

    // $.ajax({
    //   url: `${apiUrl}invoicechargegandenganheader/${id}/getinvoicegandengan`,
    //   method: 'GET',
    //   dataType: 'JSON',

    //   headers: {
    //     Authorization: `Bearer ${accessToken}`
    //   },
    //   success: response => {

    //     console.log(response.data);
    //     let totalNominal = 0

    //     $.each(response.data, (index, detail) => {

    //       let id = detail.id
    //       let detailRow = $(`
    //       <div id="detail_row_${detail.id}">
    //       <input type="text" value="${detail.id}"  name="id_detail[]"  readonly>
    //       <input type="text" value="${detail.jobtrucking}"  name="jobtrucking_detail[]"  readonly>
    //       <input type="text" value="${detail.tgltrip}"  name="tgltrip_detail[]"  readonly>
    //       <input type="text" value="${detail.jumlahhari}"  name="jumlahhari_detail[]"  readonly>
    //       <input type="text" value="${detail.nominal_detail}"  name="nominal_detail[]"  readonly>
    //       <input type="text" value="${detail.nopolisi}"  name="nopolisi_detail[]"  readonly>
    //       <input type="text" value="${detail.keterangan}"  name="keterangan_detail[]"  readonly>
    //       </div>
    //       `)


    //       $('#detailList').append(detailRow)
    //     })

    //     $('#modalgrid').setGridParam({
    //       datatype: "local",
    //       data: response.data
    //     }).trigger('reloadGrid')
    //     $('.checkBoxgrid').attr("checked", true);
    //   }
    // })
  }

  function setTotal() {
    let nominalDetails = $(`#table_body [name="nominal_detail[]"]`)
    let total = 0

    $.each(nominalDetails, (index, nominalDetail) => {
      total += AutoNumeric.getNumber(nominalDetail)
    });
    // $(`#nominal_header`).val(total);
  }

  function showInvoiceChargeGandenganHeader(form, invoiceChargeGandenganHeader) {
    return new Promise((resolve, reject) => {

      $.ajax({
        url: `${apiUrl}invoicechargegandenganheader/${invoiceChargeGandenganHeader}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          sum = 0;
          $.each(response.data, (index, value) => {
            let element = form.find(`[name="${index}"]`)
            if (element.hasClass('datepicker')) {
              element.val(dateFormat(value))
            } else {
              element.val(value)
            }

            if (index == 'agen') {
              element.data('current-value', value).prop('readonly', true)
            }
          })
          $('#detailList tbody').html('')
          $.each(response.detail, (index, detail) => {
            if (detail.nobukti_header != null) {

              selectedRowsInvoice.push(detail.id)
              selectedJobTrucking.push(detail.jobtrucking)
              selectedNoPolisi.push(detail.trado_id)
              selectedGandengan.push(detail.gandengan_id)
              selectedTglTrip.push(detail.tgltrip)
              selectedTglAkhir.push(detail.tglkembali)
              selectedJumlahHari.push(detail.jumlahhari)
              selectedNominal.push(detail.nominal_detail)
              selectedJenisOrder.push(detail.jenisorder)
              selectedNamaGudang.push(detail.namagudang)
              selectedKeterangan.push(detail.keterangan)
            }
          })
          setTimeout(() => {
            $('#modalgrid').jqGrid('setGridParam', {
              url: `${apiUrl}invoicechargegandenganheader/${invoiceChargeGandenganHeader}/getinvoicegandengan`,
              postData: {
                tglbukti: $('#crudForm').find(`[name=tglproses]`).val(),
                agen: $('#crudForm').find(`[name=agen_id]`).val(),
                sortIndex: 'jobtrucking',
              },
              datatype: "json"
            }).trigger('reloadGrid');
          }, 100);
          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }

  function setTglJatuhTempo(top = 0) {
    // Tanggal awal dalam format "YYYY-MM-DD"
    const tanggalAwal = new Date();

    // Menambahkan jumlah hari (34 hari)
    const jumlahHari = Math.floor(top);
    tanggalAwal.setDate(tanggalAwal.getDate() + jumlahHari);

    // Mendapatkan tanggal setelah ditambahkan 34 hari
    const tahun = tanggalAwal.getFullYear();
    const bulan = String(tanggalAwal.getMonth() + 1).padStart(2, "0"); // Ditambah 1 karena Januari dimulai dari 0
    const tanggal = String(tanggalAwal.getDate()).padStart(2, "0");

    $('#crudForm').find("[name=tgljatuhtempo]").val(tanggal + "-" + bulan + "-" + tahun);
    $('#crudForm').find("[name=tgljatuhtempo]").prop('readonly', true);
    $('#crudForm').find("[name=tgljatuhtempo]").parent('.input-group').find('.input-group-append').children().prop('disabled', true);
    // $('#crudForm').find("[name=tgljatuhtempo]").parent('.input-group').find('.input-group-append').remove()


  }

  function initLookup() {
    // 
    $('.agen-lookup').lookupV3({
      title: 'Customer Lookup',
      fileName: 'agenV3',
      // searching: ['namaagen'],
      labelColumn: false,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
          Invoice: 'UTAMA',
        }
      },
      onSelectRow: (agen, element) => {
        element.val(agen.namaagen)
        setTglJatuhTempo(agen.top);
        $(`#${element[0]['name']}Id`).val(agen.id)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $(`#${element[0]['name']}Id`).val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
  }

  const setTglBukti = function(form) {
    return new Promise((resolve, reject) => {
      let data = [];
      data.push({
        name: 'grp',
        value: 'EDIT TANGGAL BUKTI'
      })
      data.push({
        name: 'subgrp',
        value: 'INVOICE CHARGE'
      })
      $.ajax({
        url: `${apiUrl}parameter/getparamfirst`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: data,
        success: response => {
          isEditTgl = $.trim(response.text);
          resolve()
        },
        error: error => {
          reject(error)
        }
      })
    })
  }
</script>
@endpush()