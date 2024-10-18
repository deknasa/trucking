@extends('layouts.master')

@section('content')

<style>
  /* .ui-datepicker-calendar {
        display: none;
    } */
</style>
<div class="card card-easyui bordered mb-4">
  <div class="card-header"></div>
  <form id="indexForm">
    <div class="card-body">
      <div class="form-group row">
        <label class="col-12 col-sm-2 col-form-label mt-2">Periode<span class="text-danger">*</span></label>
        <div class="col-sm-4 mt-2">
          <div class="input-group">
            <input type="text" name="periode" id="periode" class="form-control monthpicker">
          </div>
        </div>

      </div>
      <div class="row">

        <div class="col-sm-6 mt-4">
          <a id="btnReload" class="btn btn-primary mr-2 ">
            <i class="fas fa-sync-alt"></i>
            Reload
          </a>
        </div>
      </div>

    </div>
  </form>
</div>
<!-- Grid -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <table id="jqGrid"></table>
    </div>
  </div>
</div>

@include('invoicelunaskepusat._modal')

@push('scripts')
<script>
  let indexRow = 0;
  let page = 1;
  let pager = '#jqGridPager'
  let popup = "";
  let id = "";
  let triggerClick = true;
  let highlightSearch;
  let totalRecord
  let limit
  let postData
  let sortname = 'invoiceheader_id'
  let sortorder = 'asc'
  let autoNumericElements = []
  let rowNum = 0
  let selectedRows = [];


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

  setSpaceBarCheckedHandler()

  $(document).ready(function() {

    // loadGrid()
    // initDatepicker()
    // mendapatkan tanggal hari ini
    // let today = new Date();
    // let tglBuka = new Date(today.getFullYear(), today.getMonth(), 1);
    // let formattedTglBuka = $.datepicker.formatDate('dd-mm-yy', today);
    // $('#tglBuka').find('[name=tglbukaabsensi]').val(formattedTglBuka).trigger('change');
    // $('#tglshow').val(formattedTglBuka);

    $('#indexForm').find('[name=periode]').val($.datepicker.formatDate('mm-yy', new Date())).trigger(
      'change');
    initMonthpicker()



    $(document).on('click', '#btnReload', function(event) {
      loadDataInvoiceLunasKePusat('invoicelunaskepusat', {
        periode: $('#periode').val()
      })
    })

    function loadDataInvoiceLunasKePusat(url, addtional = null) {
      data = {
        // ...data,
        ...addtional
      }
      getIndex(url, data).then((response) => {
        $('#periode').val($('#indexForm').find('[name=periode]').val());
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        clearGlobalSearch($('#jqGrid'))
        $('#jqGrid').setGridParam({
          url: `${apiUrl}${url}`,
          datatype: "json",
          postData: data,
          page: 1
        }).trigger('reloadGrid')
      }).catch((error) => {
        if (error.status === 422) {
          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()

          setErrorMessages($('#indexForm'), error.responseJSON.errors);
          $('#jqGrid').setGridParam({
            datatype: "local",
            data: [],
          }).trigger('reloadGrid')

        } else {
          showDialog(error.statusText)
        }
      })
    }



    $("#jqGrid").jqGrid({
        url: `${apiUrl}invoicelunaskepusat`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        postData: {
          periode: $('#periode').val()
        },
        // datatype: "local",
        data: {
          limit: 0,
          sortIndex: 'kodetrado',
          sortOrder: 'asc',
        },
        datatype: "json",
        colModel: [{
            label: '',
            name: '',
            width: 40,
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
                $(element).addClass('checkbox-selectall')

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
              return `<input type="checkbox" name="invId[]" class="checkbox-jqgrid" value="${rowData.invoiceheader_id}" onchange="checkboxHandler(this)">`
            },
          },
          {
            label: 'id',
            name: 'id',
            width: '50px',
            search: false,
            hidden: true
          },
          {
            label: 'invoiceheader_id',
            name: 'invoiceheader_id',
            width: '50px',
            search: false,
            hidden: true
          },
          {
            label: 'NO BUKTI',
            name: 'nobukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            // width: '50px',
            // search: false,
          },
          {
            label: 'TGL BUKTI',
            name: 'tglbukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'CUSTOMER',
            name: 'agen_id',
          },
          {
            label: 'NOMINAL',
            name: 'nominal',
            align: 'right',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            formatter: currencyFormat,
          },
          {
            label: 'TGL BAYAR',
            name: 'tglbayar',
            align: 'left',
            formatter: "date",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'BAYAR',
            name: 'bayar',
            align: 'right',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            formatter: currencyFormat,
          },
          {
            label: 'NK',
            name: 'potongan',
            align: 'right',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            formatter: currencyFormat,
          },
          {
            label: 'SISA',
            name: 'sisa',
            align: 'right',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            formatter: currencyFormat,
          },


        ],
        autowidth: true,
        shrinkToFit: false,
        height: 350,
        rowNum: rowNum,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [10, 20, 50, 0],
        toolbar: [true, "top"],
        sortable: false,
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
          total: 'attributes.total',
          records: 'attributes.records',
        },

        loadBeforeSend: function(jqXHR) {
          jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)

          setGridLastRequest($(this), jqXHR)
        },
        onSelectRow: function(id) {
          activeGrid = $(this)
          indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
          page = $(this).jqGrid('getGridParam', 'page')
          let limit = $(this).jqGrid('getGridParam', 'postData').limit
          if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))
        },
        loadComplete: function(data) {
          changeJqGridRowListText()
          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))

          /* Set global variables */
          // sortname = $(this).jqGrid("getGridParam", "sortname")
          // sortorder = $(this).jqGrid("getGridParam", "sortorder")
          totalRecord = $(this).getGridParam("records")
          limit = $(this).jqGrid('getGridParam', 'postData').limit
          postData = $(this).jqGrid('getGridParam', 'postData')
          triggerClick = true

          $('.clearsearchclass').click(function() {
            clearColumnSearch($(this))
          })

          if (indexRow > $(this).getDataIDs().length - 1) {
            indexRow = $(this).getDataIDs().length - 1;
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`[id="${$('#jqGrid').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`[id="${$('#jqGrid').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#jqGrid').getDataIDs()[indexRow] == undefined) {
              $(`[id="` + $('#jqGrid').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#jqGrid').setSelection($('#jqGrid').getDataIDs()[indexRow])
          }

          if (rowNum == 0) {
            $('#jqGrid_rowList option[value=0]').attr('selected', 'selected');
          }
          setHighlight($(this))
        },
        loadError: function(jqXHR, textStatus, errorThrown) {
          // alert('HTTP status code: ' + jqXHR.status + '\n' +
          // 'textStatus: ' + textStatus + '\n' +
          // 'errorThrown: ' + errorThrown);
          // alert('HTTP message body (jqXHR.responseText): ' + '\n' + jqXHR.responseText);
          if (jqXHR.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            setErrorMessages($('#indexForm'), jqXHR.responseJSON.errors);
            $('#jqGrid').setGridParam({
              datatype: "local",
              data: [],
            }).trigger('reloadGrid')

          } else {
            showDialog(error.statusText)
          }
        }
      })

      .jqGrid("setLabel", "rn", "No.")
      .jqGrid('filterToolbar', {
        stringResult: true,
        searchOnEnter: false,
        defaultSearch: 'cn',
        groupOp: 'AND',
        disabledKeys: [17, 33, 34, 35, 36, 37, 38, 39, 40],
        beforeSearch: function() {
          abortGridLastRequest($(this))

          clearGlobalSearch($('#jqGrid'))
        },
      })

      .customPager({
        buttons: [{
            id: 'add',
            innerHTML: '<i class="fa fa-plus"></i> ADD',
            class: 'btn btn-primary btn-sm mr-1',
            onClick: () => {

              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              let rowData = $("#jqGrid").jqGrid("getRowData", selectedId);
              let valuebukti = $(`#jqGrid tr#${selectedId}`).find(`td[aria-describedby="jqGrid_nobukti"]`).attr('title');
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Harap pilih salah satu record')
              } else {
                cekValidasiAdd(rowData.invoiceheader_id, valuebukti)
              }
            }
          },
          {
            id: 'edit',
            innerHTML: '<i class="fa fa-pen"></i> EDIT',
            class: 'btn btn-success btn-sm mr-1',
            onClick: () => {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              let rowData = $("#jqGrid").jqGrid("getRowData", selectedId);
              let valuebukti = $(`#jqGrid tr#${selectedId}`).find(`td[aria-describedby="jqGrid_nobukti"]`).attr('title');
              
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Harap pilih salah satu record')
              } else {
                cekValidasi(rowData.invoiceheader_id, 'edit', valuebukti)
              }
            }
          },
          {
            id: 'delete',
            innerHTML: '<i class="fa fa-trash"></i> DELETE',
            class: 'btn btn-danger btn-sm mr-1',
            onClick: () => {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              let rowData = $("#jqGrid").jqGrid("getRowData", selectedId); 
              let valuebukti = $(`#jqGrid tr#${selectedId}`).find(`td[aria-describedby="jqGrid_nobukti"]`).attr('title');
                            
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Harap pilih salah satu record')
              } else {
                cekValidasi(rowData.invoiceheader_id, 'delete', valuebukti)
              }
            }
          },
          {
            id: 'report',
            innerHTML: '<i class="fa fa-print"></i> REPORT',
            class: 'btn btn-info btn-sm mr-1',
            onClick: () => {
              window.open(`{{ route('invoicelunaskepusat.report') }}?periode=` + $('#periode').val() + `&invId=${selectedRows}`)
            }
          },
          {
            id: 'export',
            innerHTML: '<i class="fas fa-file-export"></i> EXPORT',
            class: 'btn btn-warning btn-sm mr-1',
            onClick: () => {
              // window.open(`{{ route('invoicelunaskepusat.export') }}?periode=` + $('#periode').val())
              $.ajax({
                url: `${apiUrl}invoicelunaskepusat/export`,
                type: 'GET',
                data: {
                  sortIndex: 'invoiceheader_id',
                  limit: 0,
                  periode : $('#periode').val(),
                },
                beforeSend: function(xhr) {
                  xhr.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`);
                },
                xhrFields: {
                  responseType: 'arraybuffer'
                },
                success: function(response, status, xhr) {
                  if (xhr.status === 200) {
                    if (response !== undefined) {
                      var blob = new Blob([response], {
                        type: 'cabang/vnd.ms-excel'
                      });
                      var link = document.createElement('a');
                      link.href = window.URL.createObjectURL(blob);
                      link.download = 'LAPORAN INVOICE LUNAS KE PUSAT' + new Date().getTime() + '.xlsx';
                      link.click();
                    }
                  }
                  $('#processingLoader').addClass('d-none')
                },
                error: function(xhr, status, error) {
                  $('#processingLoader').addClass('d-none')
                  showDialog('TIDAK ADA DATA')
                }
              })
            }
          },

        ]
      })

    /* Append clear filter button */
    loadClearFilter($('#jqGrid'))

    /* Append global search */
    loadGlobalSearch($('#jqGrid'))

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

    if (!`{{ $myAuth->hasPermission('invoicelunaskepusat', 'store') }}`) {
      $('#add').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('invoicelunaskepusat', 'update') }}`) {
      $('#edit').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('invoicelunaskepusat', 'destroy') }}`) {
      $('#delete').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('invoicelunaskepusat', 'export') }}`) {
      $('#export').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('invoicelunaskepusat', 'report') }}`) {
      $('#report').attr('disabled', 'disabled')
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
        digitGroupSeparator: ',',
        decimalCharacter: '.',
        decimalPlaces: 0,
        allowDecimalPadding: false,
        minimumValue: 1,
        maximumValue: totalRecord
      })
    })

    $('#formRange').submit(event => {
      event.preventDefault()

      let params
      let actionUrl = ``

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

  })

  function clearSelectedRows() {
    selectedRows = []

    $('#jqGrid').trigger('reloadGrid')
  }

  function selectAllRows() {
    $.ajax({
      url: `${apiUrl}invoicelunaskepusat`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        limit: 0,
        periode: $('#periode').val(),
        filters: $('#jqGrid').jqGrid('getGridParam', 'postData').filters
      },
      success: (response) => {
        selectedRows = response.data.map((invoice) => invoice.invoiceheader_id)
        $('#jqGrid').trigger('reloadGrid')
      }
    })
  }
</script>
@endpush()
@endsection