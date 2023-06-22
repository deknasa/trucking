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

            <div class="row">

              <div class="form-group col-md-6">
                <div class="row">
                  <div class="col-12 col-sm-3 col-md-4 col-form-label">
                    <label>agen <span class="text-danger">*</span> </label>
                  </div>
                  <div class="col-12 col-sm-9 col-md-8">
                    <input type="text" name="agen" class="form-control agen-lookup">
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

            <div class="row mt-3">
              <div class="col-sm-4">
                <a id="btnTampil" class="btn btn-secondary mr-2 mb-2">
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
  let rowIndex = 0;
  let selectedRows = []
  let selectedJobTrucking = [];
  let selectedTglTrip = [];
  let selectedJumlahHari = [];
  let selectedNominal = [];
  let selectedNoPolisi = [];
  let selectedKeterangan = [];

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
              },
              datatype: "json"
            }).trigger('reloadGrid');
          }).catch((errors) => {
            setErrorMessages($('#crudForm'), errors)
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
      let data = $('#crudForm').serializeArray()

      // $('#crudForm').find(`[name="nominal_detail[]"]`).each((index, element) => {
      //   data.filter((row) => row.name === 'nominal_detail[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="nominal_detail[]"]`)[index])
      // })

      // $('#crudForm').find(`[name="detail_persentasediscount[]"]`).each((index, element) => {
      //   data.filter((row) => row.name === 'detail_persentasediscount[]')[index].value = AutoNumeric.getNumber($(`#crudForm [name="detail_persentasediscount[]"]`)[index])
      // })

      $.each(selectedRows, function(index, item) {
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
      $.each(selectedTglTrip, function(index, item) {
        data.push({
          name: 'tgltrip_detail[]',
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
      $.each(selectedNoPolisi, function(index, item) {
        data.push({
          name: 'nopolisi_detail[]',
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

          $('#jqGrid').trigger('reloadGrid', {
            page: response.data.page
          })
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
            if (error.responseJSON.errors) {
              showDialog(error.statusText, error.responseJSON.errors.join('<hr>'))
            } else if (error.responseJSON.message) {
              showDialog(error.statusText, error.responseJSON.message)
            } else {
              showDialog(error.statusText, error.statusText)
            }
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
    $('#crudModal').find('.modal-body').html(modalBody)
    clearSelectedRows()
  })

  function cekValidasi(Id, Aksi) {
    $.ajax({
      url: `{{ config('app.api_url') }}invoicechargegandenganheader/${Id}/cekvalidasi`,
      method: 'POST',
      dataType: 'JSON',
      beforeSend: request => {
        request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      success: response => {
        var kodenobukti = response.kodenobukti
        if (kodenobukti == '1') {
          var kodestatus = response.kodestatus
          if (kodestatus == '1') {
            showDialog(response.message['keterangan'])
          } else {
            if (Aksi == 'EDIT') {
              editInvoiceChargeGandenganHeader(Id)
            }
            if (Aksi == 'DELETE') {
              deleteInvoiceChargeGandenganHeader(Id)
            }
          }

        } else {
          showDialog(response.message['keterangan'])
        }
      }
    })
  }



  function createInvoiceChargeGandenganHeader() {
    let form = $('#crudForm')

    form.trigger('reset')
    form.find('#btnSubmit').html(`
      <i class="fa fa-save"></i>
      Simpan
    `)
    form.data('action', 'add')
    form.find(`.sometimes`).show()
    $('#crudModalTitle').text('Create Invoice Charge Gandengan')
    $('#crudModal').modal('show')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    $('#table_body').html('')

    $('#crudForm').find('[name=tglbukti]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
  }

  function editInvoiceChargeGandenganHeader(invoiceChargeGandenganHeader) {
    let form = $('#crudForm')
    $('.modal-loader').removeClass('d-none')

    form.data('action', 'edit')
    form.trigger('reset')
    form.find('#btnSubmit').html(`
    <i class="fa fa-save"></i>
    Simpan
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Edit Invoice Charge Gandengan')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        showInvoiceChargeGandenganHeader(form, invoiceChargeGandenganHeader)
      ])
      .then(() => {
        $('#crudModal').modal('show')
        $('#crudForm [name=tglbukti]').attr('readonly', true)
        $('#crudForm [name=tglbukti]').siblings('.input-group-append').remove()
      })
      .catch((error) => {
        showDialog(error.statusText)
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
    <i class="fa fa-save"></i>
    Hapus
  `)
    form.find(`.sometimes`).hide()
    $('#crudModalTitle').text('Delete Invoice Charge Gandengan')
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()

    Promise
      .all([
        showInvoiceChargeGandenganHeader(form, invoiceChargeGandenganHeader)
      ])
      .then(() => {
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
                      selectAllRows()
                    } else {
                      clearSelectedRows(element)
                    }
                  })
                } else {
                  $(element).attr('disabled', true)
                }
              }
            },
            formatter: (value, rowOptions, rowData) => {
              return `<input type="checkbox" name="id_detail[]" value="${rowData.id}" ${disabled} onchange="checkboxHandler(this)">`
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
          },
          {
            label: 'TGL BUKTI',
            name: 'tgltrip',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'jumlah Hari',
            name: 'jumlahhari',
            align: 'right',
          },
          {
            label: 'NOMINAL',
            name: 'nominal_detail',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'No Polisi',
            name: 'nopolisi',
          },
          {
            label: 'keterangan',
            name: 'keterangan',
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
        viewrecords: true,
        footerrow: true,
        userDataOnFooter: true,
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
          console.log(data);
          let nominals = $(this).jqGrid("getCol", "nominal")
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
            nobukti: 'Total:',
            nominal: totalNominal,
          }, true)

          $.each(selectedRows, function(key, value) {
            $(grid).find('tbody tr').each(function(row, tr) {
              if ($(this).find(`td input:checkbox`).val() == value) {
                $(this).addClass('bg-light-blue')
                $(this).find(`td input:checkbox`).prop('checked', true)
              }
            })
          });
          if (disabled == '') {
            $('#gs_').attr('disabled', false)
          }else{
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

  function clearSelectedRows(element = null) {
    selectedRows = []
    selectedJobTrucking = [];
    selectedTglTrip = [];
    selectedJumlahHari = [];
    selectedNominal = [];
    selectedNoPolisi = [];
    selectedKeterangan = [];
    $('#modalgrid').trigger('reloadGrid')
  }

  function selectAllRows() {
    if (aksi == 'edit') {
      Id = $(`#crudForm`).find(`[name="id"]`).val()
      url = `${apiUrl}invoicechargegandenganheader/${Id}/getinvoicegandengan`
    } else {
      url = `${apiUrl}orderantrucking/getorderantrip`
    }
    agen_id = $('#crudForm').find(`[name=agen_id]`).val()
    tglproses = $('#crudForm').find(`[name=tglproses]`).val()
    $.ajax({
      url: url,
      method: 'GET',
      dataType: 'JSON',
      data: {
        limit: 0,
        tglbukti: tglproses,
        agen: agen_id,
      },
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: (response) => {
        selectedRows = response.data.map((data) => data.id)
        selectedJobTrucking = response.data.map((data) => data.jobtrucking)
        selectedTglTrip = response.data.map((data) => data.tgltrip)
        selectedJumlahHari = response.data.map((data) => data.jumlahhari)
        selectedNominal = response.data.map((data) => data.nominal_detail)
        selectedNoPolisi = response.data.map((data) => data.nopolisi)
        selectedKeterangan = response.data.map((data) => data.keterangan)

        $('#modalgrid').jqGrid('setGridParam', {
          url: url,
          postData: {
            tglbukti: tglproses,
            agen: agen_id,
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
        },
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: (response) => {
          response.url = `${apiUrl}orderantrucking/getorderantrip`
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

  function checkboxHandler(element) {
    let value = $(element).val();
    if (element.checked) {
      selectedRows.push($(element).val())
      selectedJobTrucking.push($(element).parents('tr').find(`td[aria-describedby="modalgrid_jobtrucking"]`).text())
      selectedTglTrip.push($(element).parents('tr').find(`td[aria-describedby="modalgrid_tgltrip"]`).text())
      selectedJumlahHari.push($(element).parents('tr').find(`td[aria-describedby="modalgrid_jumlahhari"]`).text())
      selectedNominal.push($(element).parents('tr').find(`td[aria-describedby="modalgrid_nominal_detail"]`).text())
      selectedNoPolisi.push($(element).parents('tr').find(`td[aria-describedby="modalgrid_nopolisi"]`).text())
      selectedKeterangan.push($(element).parents('tr').find(`td[aria-describedby="modalgrid_keterangan"]`).text())
      $(element).parents('tr').addClass('bg-light-blue')
    } else {
      $(element).parents('tr').removeClass('bg-light-blue')
      for (var i = 0; i < selectedRows.length; i++) {
        if (selectedRows[i] == value) {
          selectedRows.splice(i, 1);
          selectedJobTrucking.splice(i, 1);
          selectedTglTrip.splice(i, 1);
          selectedJumlahHari.splice(i, 1);
          selectedNominal.splice(i, 1);
          selectedNoPolisi.splice(i, 1);
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
      form.find(`[name="tglbukti"]`).prop('readonly', true)
      form.find(`[name="tglbukti"]`).parent('.input-group').find('.input-group-append').remove()

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
            if (element.attr("name") == 'tglbukti') {
              var result = value.split('-');
              element.val(result[2] + '-' + result[1] + '-' + result[0]);
            } else if (element.attr("name") == 'tglproses') {
              var result = value.split('-');
              element.val(result[2] + '-' + result[1] + '-' + result[0]);
            } else {
              element.val(value)
            }
          })

          $.each(response.detail, (index, detail) => {
            if (detail.nobukti_header != null) {

              selectedRows.push(detail.id)
              selectedJobTrucking.push(detail.jobtrucking)
              selectedTglTrip.push(detail.tgltrip)
              selectedJumlahHari.push(detail.jumlahhari)
              selectedNominal.push(detail.nominal_detail)
              selectedNoPolisi.push(detail.nopolisi)
              selectedKeterangan.push(detail.keterangan)
            }
          })
          setTimeout(() => {
            $('#modalgrid').jqGrid('setGridParam', {
              url: `${apiUrl}invoicechargegandenganheader/${invoiceChargeGandenganHeader}/getinvoicegandengan`,
              postData: {
                tglbukti: $('#crudForm').find(`[name=tglproses]`).val(),
                agen: $('#crudForm').find(`[name=agen_id]`).val(),
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

  function initLookup() {
    // 
    $('.agen-lookup').lookup({
      title: 'agen Lookup',
      fileName: 'agen',
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (agen, element) => {
        element.val(agen.namaagen)
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
</script>
@endpush()