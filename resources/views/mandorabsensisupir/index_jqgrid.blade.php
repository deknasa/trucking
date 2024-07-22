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
  let activeGrid
  let indexRow = 0;
  let page = 1;
  let pager = '#jqGridPager'
  let popup = "";
  let id = "";
  let triggerClick = true;
  let highlightSearch;
  let totalRecord
  let tradoMilikSupir
  let limit
  let postData
  let sortname = 'kodetrado'
  let sortorder = 'asc'
  let autoNumericElements = []
  let dataAbsensi = {}
  let rowNum = 0
  let firstTime = true
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
    isEditing()


    $(document).on('click', '#btnReload', function(event) {
      dataAbsensi = {}
      loadDataAbsensiMandor('mandorabsensisupirhistory', {
        tglbukaabsensi: $('#tglbukaabsensi').val(),
        sortIndex: 'kodetrado',
        view: true,
      })
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
            data: [],
          }).trigger('reloadGrid')

        } else {
          showDialog(error.statusText)
        }
      })
    }



    $("#jqGrid").jqGrid({
        url: `${apiUrl}mandorabsensisupirhistory`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        postData: {
          tglbukaabsensi: $('#tglbukaabsensi').val(),
          view: true,
          from: 'viewHistory',
        },
        // datatype: "local",
        data: {
          limit: 0,
          sortIndex: 'kodetrado',
          sortOrder: 'asc',
        },
        datatype: "json",
        colModel: [{
            label: 'STATUS TRIP',
            name: 'statustrip',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            stype: 'select',
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['combo'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['combo'])) {
                          echo ';';
                        }
                        $i++;
                      endforeach;

                      ?>
            `,
              dataInit: function(element) {
                $(element).select2({
                  width: 'resolve',
                  theme: "bootstrap4"
                });
              }
            },
            formatter: (value, options, rowData) => {
              let statusTrip = JSON.parse(value)

              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusTrip.WARNA}; color: ${statusTrip.WARNATULISAN};">
                  <span>${statusTrip.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusTrip = JSON.parse(rowObject.statustrip)

              return ` title="${statusTrip.MEMO}"`
            }
          },
          {
            label: 'status tambahan trado',
            name: 'statustambahantrado',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'status supir serap',
            name: 'statussupirserap',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'TRADO',
            name: 'trado',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'SUPIR',
            name: 'supir',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          },
          {
            label: 'STATUS',
            name: 'status',
            width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
          },
          {
            label: 'jenis kendaraan',
            name: 'statusjeniskendaraan',
            width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan_detail',
            width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
          },
          {
            label: 'JAM',
            name: 'jam',
            formatter: 'date',
            hidden: true,
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            formatoptions: {
              srcformat: "H:i:s",
              newformat: "H:i",
              // userLocalTime : true
            }
          },
          {
            label: 'UANG JALAN',
            name: 'uangjalan',
            align: 'right',
            formatter: currencyFormat,
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'JLH TRIP',
            name: 'jumlahtrip',
            align: 'right',
            formatter: currencyFormat,
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
          },
        ],

        autowidth: true,
        shrinkToFit: false,
        height: 350,
        cellEdit: true,
        rowNum: rowNum,
        cellsubmit: "clientArray",
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
          if (data.attributes !== undefined) {
            tradoMilikSupir = data.attributes.tradosupir;
            if (data.attributes.tradosupir === true) {
              $("#jqGrid").jqGrid('setColProp', 'namasupir', {
                editable: false
              });
            } else {
              $("#jqGrid").jqGrid('setColProp', 'namasupir', {
                editable: true
              });
            }
            if (firstTime) {
              $.each(data.data, (index, absensi) => {
                pushToObject(absensi.id, null, null)
              })
              firstTime = false
            } else {
              $.each(data.data, (index, absensi) => {
                if (!absensi.memo) {
                  // console.log(dataAbsensi.hasOwnProperty(String(absensi.id)),absensi.id);
                  // dataAbsensi.hasOwnProperty(String(id))
                  pushToObject(absensi.id, null, null)
                }
              })
            }
          }
          loadStaticData();
        },
        loadError: function(jqXHR, textStatus, errorThrown) {
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
              data: [],
            }).trigger('reloadGrid')

          } else {
            // showDialog( jqXHR.textStatus)
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
      .excelLikeGrid()
      .customPager()

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
    isEditing()

    function pushToObject(id, cell, value) {
      if (dataAbsensi.hasOwnProperty(String(id))) {
        delete dataAbsensi[String(id)];
      }
      dataAbsensi[id] = {
        id: $("#jqGrid").jqGrid('getCell', id, 'id'),
        trado_id: $("#jqGrid").jqGrid('getCell', id, 'trado_id'),
        supir_id: $("#jqGrid").jqGrid('getCell', id, 'supir_id'),
        supirold_id: $("#jqGrid").jqGrid('getCell', id, 'supir_id_old'),
        absen_id: $("#jqGrid").jqGrid('getCell', id, 'absen_id'),
        kodetrado: $("#jqGrid").jqGrid('getCell', id, 'kodetrado'),
        namasupir: $("#jqGrid").jqGrid('getCell', id, 'namasupir'),
        namasupir_old: $("#jqGrid").jqGrid('getCell', id, 'namasupir_old'),
        // jam : $("#jqGrid").jqGrid('getCell', id, 'jam'),
        absentrado: $("#jqGrid").jqGrid('getCell', id, 'absentrado'),
        keterangan: $("#jqGrid").jqGrid('getCell', id, 'keterangan'),
        tglbukti: $("#jqGrid").jqGrid('getCell', id, 'tglbukti'),
      }
      isEditing()
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

    function loadGrid() {
      $.ajax({
        url: `${apiUrl}mandorabsensisupirhistory`,
        method: 'GET',
        dataType: 'JSON',
        data: {
          limit: 0,
          sortIndex: 'trado_id',
          sortOrder: 'asc',
          view: true,
        },
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          $('#jqGrid').setGridParam({
            datatype: "local",
            data: response.data,
            rowNum: response.data.length
          }).trigger('reloadGrid')
        }
      })
    }



  })

  $(document).on('click', '.delete-row', function(event) {
    let tradoId = $(this).data('trado')
    let supirId = $(this).data('supir')
    let id = $(this).data('id')
    cekValidasi(tradoId, supirId, 'deleteFromAll', id)
  })





  function isEditing() {
    // if (jQuery.isEmptyObject(dataAbsensi)) {
    //   $('#absen').prop('disabled', true)
    // } else {
    //   $('#absen').prop('disabled', false)
    // }
  }

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

  function loadStaticData() {
    // $("#tablePelunasan").jqGrid("setCell", rowId, "bayar", 0);
    // $("#jqGrid").jqGrid('setCell', rowid, 'namasupir', value);
    for (const key in dataAbsensi) {
      if (dataAbsensi.hasOwnProperty(key)) {
        const item = dataAbsensi[key];
        let nama_supir
        if (item.supir_id) {
          nama_supir = item.namasupir
        } else {
          nama_supir = null;
        }
        $("#jqGrid").jqGrid('setCell', key, 'trado_id', item.trado_id);
        $("#jqGrid").jqGrid('setCell', key, 'supir_id', item.supir_id);
        $("#jqGrid").jqGrid('setCell', key, 'absen_id', item.absen_id);
        $("#jqGrid").jqGrid('setCell', key, 'kodetrado', item.kodetrado);
        $("#jqGrid").jqGrid('setCell', key, 'namasupir', nama_supir);
        // $("#jqGrid").jqGrid('setCell', key, 'jam', item.jam);
        $("#jqGrid").jqGrid('setCell', key, 'absentrado', item.absentrado);
        $("#jqGrid").jqGrid('setCell', key, 'keterangan', item.keterangan);
        $("#jqGrid").jqGrid('setCell', key, 'tglbukti', item.tglbukti);
        $("#jqGrid").jqGrid('setCell', key, 'action', item.action);
      }
    }
  }

  function setSupirEnableIndex(kodeabsensitrado, rowId) {

    if (kodeabsensitrado.supir) {
      $("#jqGrid").jqGrid('setCell', rowId, 'namasupir', null, 'not-editable-cell');
      $("#jqGrid").jqGrid('setCell', rowId, 'supir_id', null);
      // $("#jqGrid").jqGrid('setCell', rowId, 'jam', null);
    } else {
      let namasupir_old = $("#jqGrid").jqGrid('getCell', rowId, 'namasupir_old')
      let supir_id_old = $("#jqGrid").jqGrid('getCell', rowId, 'supir_id_old')
      $("#jqGrid").jqGrid('setCell', rowId, 'namasupir', namasupir_old);
      $("#jqGrid").jqGrid('setCell', rowId, 'supir_id', supir_id_old);

      let rowElement = $("#jqGrid").jqGrid("getInd", rowId, true);
      // Find the <td> element with aria-describedby="jqGrid_namasupir"
      let tdWithAria = $(rowElement).find('td[aria-describedby="jqGrid_namasupir"]');
      tdWithAria.removeClass('not-editable-cell');
    }
  }
</script>
@endpush()
@endsection