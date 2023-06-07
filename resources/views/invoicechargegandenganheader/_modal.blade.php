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
                <label class="col-form-label">nobukti <span class="text-danger"></span> </label>
              </div>
              <div class="col-12 col-sm-9 col-md-4">
                <input type="text" readonly name="nobukti" class="form-control">
              </div>

              <div class="col-12 col-sm-3 col-md-2">
                <label class="col-form-label">tglbukti <span class="text-danger">*</span> </label>
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
                    <label>tglproses <span class="text-danger">*</span> </label>
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
                  <a id="btnReload" class="btn btn-secondary mr-2 mb-2">
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
  $(document).ready(function() {

    $('#crudForm').autocomplete({
      disabled: true
    });
    $(document).on('click', '.delete-row', function(event) {
      deleteRow($(this).parents('tr'))
    })


    $(document).on('click','#btnReload', function(event) {
      console.log('reloaad');
      let agen_id = $('#crudForm').find(`[name=agen_id]`).val()
      let tglproses = $('#crudForm').find(`[name=tglproses]`).val()
      if ((agen_id != '') && (tglproses != '' )) {
        console.log(agen_id,tglproses);
        getOrderanTrucking(agen_id,tglproses)
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
          if(id == 0){
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
            showDialog(error.statusText)
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
    
    $("#modalgrid").jqGrid({
      
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "local",
      colModel: [
        {
          label: 'ID',
          name: 'id',
          width: '50px',
          hidden: true
        },
        {
          label: 'Pilih',
          name: 'id',
          index: 'Pilih',
          formatter: (value) => {
              return `<input type="checkbox" class="checkBoxgrid" value="${value}" onchange="checkboxHandler(this)">`
          },
          editable: true,
          edittype: 'checkbox',
          search: false,
          width: 60,
          align: 'center',
          formatoptions: {
            disabled: false
          },
        },
          
        {
          label: 'NO. BUKTI',
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
      footerrow:true,
      userDataOnFooter: true,
      
      
      loadComplete: function(data) {
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
  function checkboxHandler(element) {
    let value = $(element).val();
    console.log(value);
        if (element.checked) {
          $(`#detail_row_${value}`).find(`[name="id_detail[]"]`).attr('disabled',false)
          $(`#detail_row_${value}`).find(`[name="jobtrucking_detail[]"]`).attr('disabled',false)
          $(`#detail_row_${value}`).find(`[name="tgltrip_detail[]"]`).attr('disabled',false)
          $(`#detail_row_${value}`).find(`[name="jumlahhari_detail[]"]`).attr('disabled',false)
          $(`#detail_row_${value}`).find(`[name="nominal_detail[]"]`).attr('disabled',false)
          $(`#detail_row_${value}`).find(`[name="nopolisi_detail[]"]`).attr('disabled',false)
          $(`#detail_row_${value}`).find(`[name="keterangan_detail[]"]`).attr('disabled',false)
        } else {
          $(`#detail_row_${value}`).find(`[name="id_detail[]"]`).attr('disabled',true)
          $(`#detail_row_${value}`).find(`[name="jobtrucking_detail[]"]`).attr('disabled',true)
          $(`#detail_row_${value}`).find(`[name="tgltrip_detail[]"]`).attr('disabled',true)
          $(`#detail_row_${value}`).find(`[name="jumlahhari_detail[]"]`).attr('disabled',true)
          $(`#detail_row_${value}`).find(`[name="nominal_detail[]"]`).attr('disabled',true)
          $(`#detail_row_${value}`).find(`[name="nopolisi_detail[]"]`).attr('disabled',true)
          $(`#detail_row_${value}`).find(`[name="keterangan_detail[]"]`).attr('disabled',true)
        }
  }
  function getOrderanTrucking(agen_id,tglproses){
    $('#detailList').html('')
    

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
      success: response => {
        console.log(response.data);
        let totalNominal = 0
        $.each(response.data, (index, detail) => {
          let id = detail.id
          let detailRow = $(`
          
          <div id="detail_row_${detail.id}">
          <input type="text" value="${detail.id}"  name="id_detail[]"  readonly disabled  >
          <input type="text" value="${detail.jobtrucking}"  name="jobtrucking_detail[]"  readonly disabled  >
          <input type="text" value="${detail.tgltrip}"  name="tgltrip_detail[]"  readonly disabled  >
          <input type="text" value="${detail.jumlahhari}"  name="jumlahhari_detail[]"  readonly disabled  >
          <input type="text" value="${detail.nominal_detail}"  name="nominal_detail[]"  readonly disabled  >
          <input type="text" value="${detail.nopolisi}"  name="nopolisi_detail[]"  readonly disabled  >
          <input type="text" value="${detail.keterangan}"  name="keterangan_detail[]"  readonly disabled  >
          </div>
          `)
          $('#detailList').append(detailRow)

        })
        // console.log(response.data);

        $('#modalgrid').setGridParam({
          datatype: "local",
          data:response.data
        }).trigger('reloadGrid')
      }
    })
  }

  function getInvoiceChargeGandenganHeader(id) {
    $('#detailList').html('')
    
    $.ajax({
      url: `${apiUrl}invoicechargegandenganheader/${id}/getinvoicegandengan`,
      method: 'GET',
      dataType: 'JSON',
      
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      success: response => {

        console.log(response.data);
        let totalNominal = 0
        
        $.each(response.data, (index, detail) => {
          
          let id = detail.id
          let detailRow = $(`
          <div id="detail_row_${detail.id}">
          <input type="text" value="${detail.id}"  name="id_detail[]"  readonly>
          <input type="text" value="${detail.jobtrucking}"  name="jobtrucking_detail[]"  readonly>
          <input type="text" value="${detail.tgltrip}"  name="tgltrip_detail[]"  readonly>
          <input type="text" value="${detail.jumlahhari}"  name="jumlahhari_detail[]"  readonly>
          <input type="text" value="${detail.nominal_detail}"  name="nominal_detail[]"  readonly>
          <input type="text" value="${detail.nopolisi}"  name="nopolisi_detail[]"  readonly>
          <input type="text" value="${detail.keterangan}"  name="keterangan_detail[]"  readonly>
          </div>
          `)

         
          $('#detailList').append(detailRow)
        })

        $('#modalgrid').setGridParam({
          datatype: "local",
          data:response.data
        }).trigger('reloadGrid')
        $('.checkBoxgrid').attr("checked",true);
      }
    })
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
            }else if (element.attr("name") == 'tglproses') {
              var result = value.split('-');
              element.val(result[2] + '-' + result[1] + '-' + result[0]);
            } else {
              element.val(value)
            }
          })

          getInvoiceChargeGandenganHeader(response.data.id)
          resolve()
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