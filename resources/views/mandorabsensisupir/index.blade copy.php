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
@push('style')
<style>
  .ui-jqgrid .ui-jqgrid-btable tbody tr.jqgrow td {
    white-space: unset;
  }

  .ui-jqgrid .ui-jqgrid-btable tbody tr.jqgrow td .input-group {
    flex-wrap: nowrap;
  }
</style>
@endpush
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
      loadDataAbsensiMandor('mandorabsensisupir', {
        tglbukaabsensi: $('#tglbukaabsensi').val(),
        sortIndex: 'kodetrado'
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
        url: `${apiUrl}mandorabsensisupir`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        postData: {
          tglbukaabsensi: $('#tglbukaabsensi').val()
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
            // hidden: true
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
            label: 'absen_id',
            name: 'absen_id',
            width: '50px',
            search: false,
            hidden: true
          },
          {
            label: 'namasupir_old',
            name: 'namasupir_old',
            width: '50px',
            search: false,
            sortable: false,
            hidden: true,
            // formatter: (value, options, rowData) => {
            //   return rowData.namasupir
            // }
          },
          {
            label: 'supir_id_old',
            name: 'supir_id_old',
            width: '50px',
            search: false,
            sortable: false,
            hidden: true,
            // formatter: (value, options, rowData) => {
            //   return rowData.supir_id
            // }
          },
          // {
          //   label: 'sudah absen',
          //   name: 'sudah_absen',
          //   width: '50px',
          //   search: false,
          //   sortable:false,
          //   hidden: false,
          //   formatter: (value, options, rowData) => {
          //     if (!rowData.memo) {
          //       return ''
          //     }
          //     let statusAbsensi = JSON.parse(rowData.memo)
          //     let formattedValue = $(`
          //     <div class="badge" style="background-color: ${statusAbsensi.WARNA}; color: ${statusAbsensi.WARNATULISAN};">
          //       <span>${statusAbsensi.SINGKATAN}</span>
          //     </div>
          //     `)
          //     return formattedValue[0].outerHTML
          //   },
          //   cellattr: (rowId, value, rowData) => {
          //     if (!rowData.memo) {
          //       return ''
          //     }
          //     let statusAbsensi = JSON.parse(rowData.memo)
          //     return ` title="${statusAbsensi.MEMO}"`
          //   }
          // },
          {
            label: 'Trado',
            name: 'kodetrado',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          },
          {
            label: 'Supir',
            name: 'namasupir',
            editable: true,
            editoptions: {
              autocomplete: 'off',
              class: 'supirtrado-lookup',
              dataInit: function(element) {
                $('.supirtrado-lookup').last().lookup({
                  title: 'Supir Lookup',
                  fileName: 'supir',
                  beforeProcess: function(test) {
                    this.postData = {
                      Aktif: 'AKTIF',
                    }
                  },
                  onSelectRow: (supir, el) => {
                    el.val(supir.namasupir)
                    el.data('currentValue', supir.namasupir)
                    let rowId = $("#jqGrid").jqGrid('getGridParam', 'selrow');
                    $("#jqGrid").jqGrid('setCell', rowId, 'supir_id', supir.id);

                    $("#jqGrid").jqGrid('setCell', rowId, 'namasupir_old', supir.namasupir);
                    $("#jqGrid").jqGrid('setCell', rowId, 'supir_id_old', supir.id);
                    // $("#jqGrid").jqGrid('setCell', rowId, 'namasupir', supir.namasupir);
                  },
                  onCancel: (element) => {
                    element.val(element.data('currentValue'))
                  },
                  onClear: (element) => {
                    element.val('')
                    $("#jqGrid").jqGrid('setCell', rowId, 'namasupir_old', null);
                    $("#jqGrid").jqGrid('setCell', rowId, 'supir_id_old', null);
                  }
                })
              }
            },
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          },
          // {
          //   label: 'JAM',
          //   name: 'jam',
          //   editable: true,
          //   formatter: 'date',
          //   editoptions: {
          //     autocomplete: 'off',
          //     class:'inputmask-time',
          //     dataInit: function(element) {
          //       Inputmask("datetime", {
          //         inputFormat: "HH:MM",
          //         max: 24
          //       }).mask(".inputmask-time");

          //     }
          //   },
          //   // formatter: 'date',
          //   width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
          //   formatoptions: {
          //     srcformat: "H:i:s",
          //     newformat: "H:i",
          //     // userLocalTime : true
          //   },
          //   formatter: (value, options, rowData) => {
          //     if (!value) {
          //       return ''
          //     }
          //     // String waktu
          //     let waktuString = value;

          //     // Memisahkan string menjadi bagian-bagian
          //     let [jamStr, menitStr, detikStr] = waktuString.split(':');

          //     // Parsing nilai sebagai angka
          //     let jam = parseInt(jamStr, 10);
          //     let menit = parseInt(menitStr, 10);
          //     let detik = parseInt(detikStr, 10);
          //     if (jam === 0 && menit === 0 && detik === 0) {
          //       return ''
          //     } 
          //     return `${jamStr}:${menitStr}`
          //   }
          // },
          {
            label: 'status',
            name: 'absentrado',
            editable: true,
            editoptions: {
              autocomplete: 'off',
              class: 'statusabsentrado-lookup',
              dataInit: function(element) {
                let rowId = $("#jqGrid").jqGrid('getGridParam', 'selrow');
                let row_trado_id = $("#jqGrid").jqGrid('getCell', rowId, 'trado_id');
                let row_supir_id = $("#jqGrid").jqGrid('getCell', rowId, 'supir_id');
                let row_supirold_id = $("#jqGrid").jqGrid('getCell', rowId, 'supirold_id');
                $('.statusabsentrado-lookup').last().lookup({
                  title: 'Absen Trado Lookup',
                  fileName: 'absentrado',
                  beforeProcess: function(test) {
                    this.postData = {
                      Aktif: 'AKTIF',
                      trado_id : row_trado_id,
                      supir_id : row_supir_id,
                      supirold_id : row_supirold_id,
                      tglabsensi : $('#tglbukaabsensi').val(),
                      dari : 'mandorabsensisupir',
                    }
                  },
                  onSelectRow: (absentrado, el) => {
                    el.val(absentrado.keterangan)
                    el.data('currentValue', absentrado.keterangan)
                    let rowId = $("#jqGrid").jqGrid('getGridParam', 'selrow');
                    $("#jqGrid").jqGrid('setCell', rowId, 'absen_id', absentrado.id);

                  },
                  onCancel: (element) => {
                    element.val(element.data('currentValue'))
                  },
                  onClear: (element) => {
                    element.val('')

                    let rowId = $("#jqGrid").jqGrid('getGridParam', 'selrow');
                    // setSupirEnableIndex(false,rowId)
                    $("#jqGrid").jqGrid('setCell', rowId, 'absen_id', null);
                  }
                })
              }
            },
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          },
          {
            label: 'jlh trip',
            name: 'jlhtrip',
            editable: false,
            align: 'right',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2
          },
          {
            label: 'keterangan',
            name: 'keterangan',
            editable: true,
            editoptions: {
              autocomplete: 'off',
              dataEvents: [{
                type: "keyup",
              }]
            },
            width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1
          },
          {
            label: 'TGL BATAS',
            name: 'tglbatas',
            formatter: (value, options, rowData) => {
              let rowId = $("#jqGrid").jqGrid('getGridParam', 'selrow');
              let data = value
              if (!value) {
                data = $('#tglbukaabsensi').val() +' 11:59:00'
                $("#jqGrid").jqGrid('setCell', rowId, 'tglbatas', data);
              }
              return data;
            },
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            align: 'right',
            // formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'TGL BUKTI',
            name: 'tglbukti',
            formatter: (value, options, rowData) => {
              let rowId = $("#jqGrid").jqGrid('getGridParam', 'selrow');
              let data = value
              if (!value) {
                $("#jqGrid").jqGrid('setCell', rowId, 'tglbukti', $('#tglbukaabsensi').val());
                data = $('#tglbukaabsensi').val()
              }
              return data;
            },
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            align: 'right',
            // formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'action',
            name: 'action',
            formatter: (value, options, rowData) => {
              let trado_id = rowData.trado_id
              let supir_id = rowData.supir_id
              let id = rowData.id
              let formattedValue = $(`
            <button data-trado="${trado_id}" data-supir="${supir_id}" data-id="${id}" class="btn btn-danger btn-sm delete-row"><i class="fa fa-trash"></i> Delete</button>              
            `)
              return formattedValue[0].outerHTML
            }
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
        // afterEditCell: function(rowid, cellname, value, iRow, iCol) {
        //   var $grid = $("#jqGrid");
          
        //   $(this.rows[iRow].cells[iCol])
        //   .find("input,textarea,select,button,object,*[tabindex]")
        //   .filter(":input:visible:not(:disabled)")
        //   .first()
        //   .on("focusout", function (e) {
        //       var p = $grid.jqGrid('getGridParam');
      
        //       if ($(e.relatedTarget).closest('.input-group-append').length === 0) {
        //           $grid.jqGrid('saveCell', p.iRow, p.iCol);
        //           $("#jqGrid").jqGrid('setCell', rowid, cellname, value);
        //           pushToObject(rowid, cellname, value);
                  
        //           if (cellname === 'absentrado') {
        //             $("#jqGrid").jqGrid('setCell', rowid, 'absentrado', value);
        //             let absen_id = $("#jqGrid").jqGrid('getCell', rowid, 'absen_id')
        //             getabsentrado(absen_id).then((response) => {
        //                 setSupirEnableIndex(response, rowid)
        //               })
        //               .catch(() => {
        //                 setSupirEnableIndex(false, rowid)
        //               })
        //               .then(() => {
        //                 pushToObject(rowid, 'absentrado', value);
        //               })
        //           }
                  
        //       }
        //   });
        // },
        afterSaveCell: function(rowid, cellname, value, iRow, iCol) {
          if (cellname === 'namasupir') {
            $("#jqGrid").jqGrid('setCell', rowid, 'namasupir', value);
            pushToObject(rowid, 'namasupir', value);
          }
          if (cellname === 'absentrado') {
            $("#jqGrid").jqGrid('setCell', rowid, 'absentrado', value);
            let absen_id = $("#jqGrid").jqGrid('getCell', rowid, 'absen_id')
            getabsentrado(absen_id).then((response) => {
                setSupirEnableIndex(response, rowid)
              })
              .catch(() => {
                setSupirEnableIndex(false, rowid)
              })
              .then(() => {
                pushToObject(rowid, 'absentrado', value);
              })
          }
          // if (cellname === 'jam') {
          //   $("#jqGrid").jqGrid('setCell', rowid, 'jam', value);
          //   pushToObject(rowid,'jam', value);
          // }
          if (cellname === 'keterangan') {
            $("#jqGrid").jqGrid('setCell', rowid, 'keterangan', value);
            pushToObject(rowid, 'keterangan', value);
          }
          if (cellname === 'tglbukti') {
            $("#jqGrid").jqGrid('setCell', rowid, 'tglbukti', value);
            pushToObject(rowid, 'tglbukti', value);
          }
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
            }else{
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
      .excelLikeGrid()
      .customPager({
        buttons: [{
          id: 'absen',
          innerHTML: '<i class="fa fa-save"></i> Save',
          class: 'btn btn-primary btn-sm mr-1',
          onClick: () => {
            submitAll()
          }
        }, ]
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
        url: `${apiUrl}mandorabsensisupir`,
        method: 'GET',
        dataType: 'JSON',
        data: {
          limit: 0,
          sortIndex: 'trado_id',
          sortOrder: 'asc',
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

    function submitAll() {
      // $(this).attr('disabled', '')
      // $('#processingLoader').removeClass('d-none')
      $.ajax({
        url: `${apiUrl}mandorabsensisupir`,
        method: 'POST',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          data: JSON.stringify(dataAbsensi)
        },
        success: response => {
          $('#jqGrid').jqGrid().trigger('reloadGrid')
          dataAbsensi = {}
          isEditing()
        },
        error: error => {
          $(".ui-state-error").removeClass("ui-state-error");

          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()
          errors = error.responseJSON.errors
          $.each(errors, (index, error) => {
            selectedRows = $("#jqGrid").getGridParam("selectedRowIds");
            let indexes = index.split(".");
            let angka = indexes[0]
            row = parseInt(angka) - 1;
            let element;
            element = $(`#jqGrid tr#${parseInt(angka)}`).find(`td[aria-describedby="jqGrid_${indexes[1]}"]`)
            $(element).addClass("ui-state-error");
            $(element).attr("title", error[0].toLowerCase())
          });
        },
      }).always(() => {
        $('#processingLoader').addClass('d-none')
        $(this).removeAttr('disabled')
      })
    }

  })

  $(document).on('click', '.delete-row', function(event) {
    let tradoId = $(this).data('trado')
    let supirId = $(this).data('supir')
    let id = $(this).data('id')
    cekValidasi(tradoId, supirId, 'deleteFromAll', id)
  })

  function deleteFromAll(tradoId, supirId,rowId) {
    $.ajax({
      url: `${apiUrl}mandorabsensisupir/${tradoId}`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        tanggal: $('#tglshow').val(),
        supir_id: supirId
      },
      success: response => {

        // let waktuAwal = response.data.jam;
        // // Membuat objek Date dari waktu awal
        // let dateObj = new Date("2000-01-01 " + waktuAwal);
        // // Mendapatkan jam dan menit
        // let jam = dateObj.getHours();
        // let menit = dateObj.getMinutes();
        // // Menggabungkan jam dan menit dalam format "hh:mm"
        // let waktuAkhir = (jam < 10 ? "0" : "") + jam + ":" + (menit < 10 ? "0" : "") + menit;

        // response.data.jam = waktuAkhir

        let msg = `YAKIN HAPUS ABSENSI `
        let supirtrado = `${response.data.trado}`
        if (response.data.supir) {
          supirtrado += ` - ${response.data.supir}`
        }
        showConfirm(msg, supirtrado)
          .then(function() {
            $.ajax({
              url: `${apiUrl}mandorabsensisupir`,
              method: 'POST',
              dataType: 'JSON',
              data: {
                data: JSON.stringify(dataAbsensi),
                deleted_id: rowId
              },
              headers: {
                Authorization: `Bearer ${accessToken}`
              },
              success: response => {
                $('#jqGrid').jqGrid().trigger('reloadGrid')
                // deleteStatic(rowId,' ');
              },

              error: error => {
                if (error.status === 422) {
                  $('.is-invalid').removeClass('is-invalid')
                  $('.invalid-feedback').remove()

                  setErrorMessages($("#crudForm"), error.responseJSON.errors);
                } else {
                  showDialog(error.responseJSON)
                }
              },
            })

          })

      },
      error: error => {
        reject(error)
      }
    })
    isEditing()
  }

  function deleteStatic(id, message) {
    if (dataAbsensi.hasOwnProperty(String(id))) {
      const item = dataAbsensi[id];
      if (item.supirold_id) {
        nama_supir = item.namasupir_old
      } else {
        nama_supir = null;
      }
      $("#jqGrid").jqGrid('setCell', id, 'absen_id', null);
      $("#jqGrid").jqGrid('setCell', id, 'namasupir', nama_supir);
      $("#jqGrid").jqGrid('setCell', id, 'absentrado', null);
      $("#jqGrid").jqGrid('setCell', id, 'keterangan', null);
      // $('#jqGrid').jqGrid().trigger('reloadGrid')
      // console.log($("#jqGrid").jqGrid('getCell', id, 'supir_id'),'dfg',$("#jqGrid").jqGrid('getCell', id, 'namasupir'));
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

      // console.log(dataAbsensi[id]);
      // console.log(dataAbsensi);
    } else {
      showDialog(message)
    }
    isEditing()
  }

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