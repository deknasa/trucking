@extends('layouts.master')

@section('content')
<div class="card card-easyui bordered mb-4">
  <div class="card-header"></div>
  <form id="tglBuka">
      <div class="card-body">
          <div class="form-group row">
              <label class="col-12 col-sm-2 col-form-label mt-2">Tgl absensi<span class="text-danger">*</span></label>
              <div class="col-sm-4 mt-2">
                  <div class="input-group">
                      <input type="text" name="tglbukaabsensi" id="tglbukaabsensi" class="form-control datepickerIndex">
                      <input type="text" name="tglshow" id="tglshow" class="form-control " style="display:none">
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

@include('mandorabsensisupir._modal')

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
  let sortname = 'kodetrado'
  let sortorder = 'asc'
  let autoNumericElements = []
  let rowNum = 0
  let isTradoMilikSupir = ''
  $(document).ready(function() {
    setTradoMilikSupir()
    // loadGrid()
    initDatepicker('datepickerIndex')
    // mendapatkan tanggal hari ini
    let today = new Date();
    // let tglBuka = new Date(today.getFullYear(), today.getMonth(), 1);
    let formattedTglBuka = $.datepicker.formatDate('dd-mm-yy', today);
    $('#tglBuka').find('[name=tglbukaabsensi]').val(formattedTglBuka).trigger('change');
    $('#tglshow').val(formattedTglBuka);

    

    $(document).on('click','#btnReload', function(event) {
      loadDataAbsensiMandor('mandorabsensisupir',{tglbukaabsensi:$('#tglbukaabsensi').val(),sortIndex:'kodetrado'})
    })
    
    function loadDataAbsensiMandor(url, addtional = null) {
      data = {
        // ...data,
        ...addtional
      }
      getIndex(url, data).then((response) => {
        $('#tglshow').val($('#tglBuka').find('[name=tglbukaabsensi]').val());
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

            setErrorMessages($('#tglBuka'), error.responseJSON.errors);
            $('#jqGrid').setGridParam({
              datatype: "local",
              data:[],
            }).trigger('reloadGrid')
            
          } else {
            showDialog(error.statusText)
          }
      })
    }
              
      

    $("#jqGrid").jqGrid({
        url: `${apiUrl}mandorabsensisupir`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        postData: {
          tglbukaabsensi:$('#tglbukaabsensi').val()
        },
        // datatype: "local",
        data: {
          limit: 0,
          sortIndex: 'kodetrado',
          sortOrder: 'asc',
        },
        datatype: "json",
        colModel: [{
            label: 'id',
            name: 'id',
            width: '50px',
            search: false,
            hidden: true
          },
          {
            label: 'trado_id',
            name: 'trado_id',
            width: '50px',
            search: false,
            hidden: true
          },
          {
            label: 'supir_id',
            name: 'supir_id',
            width: '50px',
            search: false,
            hidden: true
          },
          {
            label: 'Trado',
            name: 'kodetrado',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'Supir',
            name: 'namasupir',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          },
          {
            label: 'JAM',
            name: 'jam',
            formatter: 'date',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            formatoptions: {
              srcformat: "H:i:s",
              newformat: "H:i",
              // userLocalTime : true
            }
          },
          {
            label: 'status',
            name: 'absentrado',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          },
          {
            label: 'keterangan',
            name: 'keterangan',
            width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1
          },
          {
            label: 'TGL BUKTI',
            name: 'tglbukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            align: 'right',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
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
            $('#jqGrid_rowList option[value=0]').attr('selected','selected');
          }
          setHighlight($(this))
        },
        loadError: function (jqXHR, textStatus, errorThrown) {
          // alert('HTTP status code: ' + jqXHR.status + '\n' +
          // 'textStatus: ' + textStatus + '\n' +
          // 'errorThrown: ' + errorThrown);
          // alert('HTTP message body (jqXHR.responseText): ' + '\n' + jqXHR.responseText);
          if (jqXHR.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            setErrorMessages($('#tglBuka'), jqXHR.responseJSON.errors);
            $('#jqGrid').setGridParam({
              datatype: "local",
              data:[],
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
            id: 'absen',
            innerHTML: '<i class="fa fa-plus"></i> ADD',
            class: 'btn btn-primary btn-sm mr-1',
            onClick: () => {

              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              let rowData = $("#jqGrid").jqGrid("getRowData", selectedId);
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Harap pilih salah satu record')
              } else {
                cekValidasiAdd(rowData.trado_id,rowData.supir_id)
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

              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Harap pilih salah satu record')
              } else {
                cekValidasi(rowData.trado_id,rowData.supir_id, 'edit')
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
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Harap pilih salah satu record')
              } else {
                cekValidasi(rowData.trado_id,rowData.supir_id, 'delete')
              }
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

    if (!`{{ $myAuth->hasPermission('mandorabsensisupir', 'store') }}`) {
      $('#absen').attr('disabled', 'disabled')
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
    // function loadGrid() {
    //   $.ajax({
    //       url: `${apiUrl}mandorabsensisupir`,
    //       method: 'GET',
    //     dataType: 'JSON',
    //     data: {
    //       limit: 0,
    //       sortIndex:'trado_id',
    //       sortOrder:'asc',
    //     },
    //     headers: {
    //       Authorization: `Bearer ${accessToken}`
    //     },
    //     success: response => {
    //       $('#jqGrid').setGridParam({
    //         datatype: "local",
    //         data:response.data,
    //         rowNum: response.data.length
    //       }).trigger('reloadGrid')
    //     }
    //   })
    // }
  })

  function setTradoMilikSupir() {
    $.ajax({
      url: `${apiUrl}parameter/getparamfirst`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        grp: 'ABSENSI SUPIR',
        subgrp: 'TRADO MILIK SUPIR'
      },
      success: response => {
        isTradoMilikSupir = $.trim(response.text)
      }
    })
  }
</script>
@endpush()
@endsection