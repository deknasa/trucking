@extends('layouts.master')
@push('addtional-field')
<div class="form-group row">
  <label class="col-12 col-sm-2 col-form-label mt-2">Supir</label>
  <div class="col-sm-4 mt-2">
    <input type="hidden" name="supirheader_id" id="supirheader_id">
    <input type="text" name="supirheader" id="supirheader" autocomplete="off" class="form-control supirheader-lookup">
  </div>
</div>
@endpush
@section('content')

<!-- Grid -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12">

      @include('layouts._rangeheader')
      <table id="jqGrid"></table>
    </div>
  </div>
</div>

@include('listtrip._modal')
@include('ritasi._modal')
@push('scripts')
<script>
  let indexRow = 0;
  let page = 0;
  let pager = '#jqGridPager'
  let popup = "";
  let id = "";
  let triggerClick = true;
  let highlightSearch;
  let totalRecord
  let limit
  let postData
  let sortname = 'nobukti'
  let sortorder = 'asc'
  let autoNumericElements = []
  let rowNum = 10
  let hasDetail = false
  let selectedRows = [];
  let selectedbukti = [];

  function checkboxHandler(element) {
    let value = $(element).val();
    let flag = $(`#jqGrid tr#${value}`).find(`td[aria-describedby="jqGrid_flag"]`).attr('title');
    let valuebukti = $(`#jqGrid tr#${value}`).find(`td[aria-describedby="jqGrid_nobukti"]`).attr('title');
    let valueritasi = $(`#jqGrid tr#${value}`).find(`td[aria-describedby="jqGrid_ritasi_nobukti"]`).attr('title');


    if (element.checked) {
      selectedRows.push($(element).val())
      if (flag != 1) {
        selectedbukti.push(valueritasi)
      } else {
        selectedbukti.push(valuebukti)
      }
    } else {
      for (var i = 0; i < selectedRows.length; i++) {
        if (selectedRows[i] == value) {
          selectedRows.splice(i, 1);
        }
        if (flag != 1) {
          if (selectedbukti[i] == valueritasi) {
            selectedbukti.splice(i, 1);
          }
        } else {
          if (selectedbukti[i] == valuebukti) {
            selectedbukti.splice(i, 1);
          }
        }
      }
    }
  }

  function clearSelectedRows() {
    selectedRows = []
    selectedbukti = []
    $('#gs_').prop('checked', false);
    $('#jqGrid').trigger('reloadGrid')
  }

  function selectAllRows() {

    $.ajax({
      url: `${apiUrl}listtrip`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        limit: 0,
        tgldari: $('#tgldariheader').val(),
        tglsampai: $('#tglsampaiheader').val(),
        supirheader: $('#supirheader_id').val(),
        proses: 'reload',
        filters: $('#jqGrid').jqGrid('getGridParam', 'postData').filters
      },
      success: (response) => {
        selectedRows = response.data.map((suratpengantar) => suratpengantar.id)
        console.log(response)
        $('#jqGrid').trigger('reloadGrid')
      }
    })
  }

  function initLookupHeader() {
    $('.supirheader-lookup').lookupV3({
      title: 'Supir Lookup',
      fileName: 'supirV3',
      searching: ['namasupir'],
      labelColumn: false,
      beforeProcess: function(test) {
        this.postData = {
          Aktif: 'AKTIF',
        }
      },
      onSelectRow: (supir, element) => {
        $('#supirheader_id').first().val(supir.id)
        element.val(supir.namaalias)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        $('#supirheader_id').first().val('')
        element.val('')
        element.data('currentValue', element.val())
      }
    })
  }

  $(document).ready(function() {
    let indexUrl = `${apiUrl}listtrip`

    initLookupHeader()
    setRange()
    initDatepicker('datepickerIndex')
    $(document).on('click', '#btnReload', function(event) {
      loadDataHeader('listtrip', {
        supirheader: $('#supirheader_id').val(),
        proses: 'reload'
      })
    })

    function createColModel() {
      return [
        {
          label: '',
          name: '',
          width: 40,
          align: 'center',
          sortable: false,
          clear: false,
          stype: 'input',
          searchable: false,
          hidden: (accessCabang == 'MEDAN') ? false : true,
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
            return `<input type="checkbox" name="listtripId[]" class="checkbox-jqgrid" value="${rowData.id}" onchange="checkboxHandler(this)">`
          },
        },
        {
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '50px',
          search: false,
          hidden: true
        }, 
        {
          label: 'ID ORI',
          name: 'idoriginal',
          search: false,
          hidden: true
        }, 
        {
          label: 'FLAG',
          name: 'flag',
          search: false,
          hidden: true
        },
        {
          label: 'STATUS APP.',
          name: 'statusapprovalmandor',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
          stype: 'select',
          hidden: (accessCabang == 'MEDAN') ? false : true,
          searchoptions: {
            value: `<?php
            $i = 1;
            
            foreach ($data['comboapproval'] as $status) :
            echo "$status[param]:$status[parameter]";
            if ($i !== count($data['comboapproval'])) {
              echo ";";
              }
              $i++;
              endforeach
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
            let statusApproval = JSON.parse(value)
            if (!statusApproval) {
              return ''
            }
            let formattedValue = $(`
            <div class="badge" style="background-color: ${statusApproval.WARNA}; color: #fff;">
              <span>${statusApproval.SINGKATAN}</span>
            </div>
            `)
            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusApproval = JSON.parse(rowObject.statusapprovalmandor)
            if (!statusApproval) {
              return ` title=""`
            }
            return ` title="${statusApproval.MEMO}"`
          }
        },
        {
          label: 'JOB TRUCKING',
          name: 'jobtrucking',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
        },
        {
          label: 'NO BUKTI',
          name: 'nobukti',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
        },
        {
          label: 'NO BUKTI RITASI',
          name: 'ritasi_nobukti',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          search: (accessCabang == 'MEDAN') ? true : false,
          hidden: (accessCabang == 'MEDAN') ? false : true
        },
        {
          label: 'SUPIR',
          name: 'supir_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4
        },
        {
          label: 'DARI',
          name: 'dari_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4
        },
        {
          label: 'SAMPAI',
          name: 'sampai_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4
        },
        {
          label: 'KET. RITASI',
          name: 'keteranganritasi',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          search: (accessCabang == 'MEDAN') ? true : false,
          hidden: (accessCabang == 'MEDAN') ? false : true
        },
        {
          label: 'GAJI SUPIR',
          name: 'gajisupir',
          align: 'right',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          formatter: currencyFormat,
          search: (accessCabang == 'MEDAN') ? true : false,
          hidden: (accessCabang == 'MEDAN') ? false : true

        },
        {
          label: 'CONTAINER',
          name: 'container_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3
        },
        {
          label: 'GAJI SUPIR NO BUKTI',
          name: 'gajisupir_nobukti',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          search: (accessCabang == 'MEDAN') ? true : false,
          hidden: (accessCabang == 'MEDAN') ? false : true,
          formatter: (value, options, rowData) => {
            if ((value == null) || (value == '')) {
              return '';
            }
            let tgldari = rowData.tgldarigajisupirheader
            let tglsampai = rowData.tglsampaigajisupirheader
            let url = "{{route('gajisupirheader.index')}}"
            let formattedValue = $(`
            <a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}&nobukti=${value}" class="link-color" target="_blank">${value}</a>
           `)
            return formattedValue[0].outerHTML
          }
        },
        {
          label: 'NO BUKTI EBS',
          name: 'prosesgajisupir_nobukti',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          search: (accessCabang == 'MEDAN') ? true : false,
          hidden: (accessCabang == 'MEDAN') ? false : true,
          formatter: (value, options, rowData) => {
            if ((value == null) || (value == '')) {
              return '';
            }
            let tgldari = rowData.tgldariebs
            let tglsampai = rowData.tglsampaiebs
            let url = "{{route('prosesgajisupirheader.index')}}"
            let formattedValue = $(`
            <a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}&nobukti=${value}" class="link-color" target="_blank">${value}</a>
           `)
            return formattedValue[0].outerHTML
          }
        },
        {
          label: 'TGL BUKTI',
          name: 'tglbukti',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y"
          }
        },
        
        {
          label: 'PENYESUAIAN',
          name: 'penyesuaian',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4
        },
        {
          label: 'NO CONT',
          name: 'nocont',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          search: (accessCabang == 'MEDAN') ? true : false,
          hidden: (accessCabang == 'MEDAN') ? false : true
        },
        {
          label: 'STATUS GAJI SUPIR',
          name: 'statusgajisupir',
          stype: 'select',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          hidden: (accessCabang == 'MEDAN') ? false : true,
          searchoptions: {
            value: `<?php
                    $i = 1;

                    foreach ($data['combogajisupir'] as $status) :
                      echo "$status[param]:$status[parameter]";
                      if ($i !== count($data['combogajisupir'])) {
                        echo ";";
                      }
                      $i++;
                    endforeach

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
            let statusGajisupir = JSON.parse(value)
            if (!statusGajisupir) {
              return ''
            }
            let formattedValue = $(`
              <div class="badge" style="background-color: ${statusGajisupir.WARNA}; color: #fff;">
                <span>${statusGajisupir.SINGKATAN}</span>
              </div>
            `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusGajisupir = JSON.parse(rowObject.statusgajisupir)
            if (!statusGajisupir) {
              return ` title=""`
            }
            return ` title="${statusGajisupir.MEMO}"`
          }
        },
        {
          label: 'CUSTOMER',
          name: 'agen_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4
        },
        {
          label: 'JENIS ORDER',
          name: 'jenisorder_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3
        },
        {
          label: 'SHIPPER',
          name: 'pelanggan_id',
          width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1
        },
        
        {
          label: 'STATUS CONTAINER',
          name: 'statuscontainer_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4
        },
        {
          label: 'TRADO',
          name: 'trado_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3
        },
        {
          label: 'GANDENGAN',
          name: 'gandengan_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4
        },
       
        {
          label: 'KETERANGAN',
          name: 'keterangan',
          width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1
        },
        {
          label: 'LONGTRIP',
          name: 'statuslongtrip',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          stype: 'select',
          searchoptions: {
            value: `<?php
                    $i = 1;

                    foreach ($data['combolongtrip'] as $status) :
                      echo "$status[param]:$status[parameter]";
                      if ($i !== count($data['combolongtrip'])) {
                        echo ";";
                      }
                      $i++;
                    endforeach

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
            let statusLongTrip = JSON.parse(value)
            if (!statusLongTrip) {
              return ''
            }
            let formattedValue = $(`
              <div class="badge" style="background-color: ${statusLongTrip.WARNA}; color: #fff;">
                <span>${statusLongTrip.SINGKATAN}</span>
              </div>
            `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusLongTrip = JSON.parse(rowObject.statuslongtrip)
            if (!statusLongTrip) {
              return ` title=""`
            }
            return ` title="${statusLongTrip.MEMO}"`
          }
        },
        {
          label: 'GUDANG SAMA',
          name: 'statusgudangsama',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          stype: 'select',
          searchoptions: {
            value: `<?php
              $i = 1;
              foreach ($data['combogudangsama'] as $status) :
                echo "$status[param]:$status[parameter]";
                if ($i !== count($data['combogudangsama'])) {
                  echo ";";
                }
                $i++;
              endforeach
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
            let statusGudangSama = JSON.parse(value)
            if (!statusGudangSama) {
              return ''
            }
            let formattedValue = $(`
              <div class="badge" style="background-color: ${statusGudangSama.WARNA}; color: #fff;">
                <span>${statusGudangSama.SINGKATAN}</span>
              </div>
            `)
              return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusGudangSama = JSON.parse(rowObject.statusgudangsama)
            if (!statusGudangSama) {
              return ` title=""`
            }
            return ` title="${statusGudangSama.MEMO}"`
          }
        },
        {
          label: 'LOKASI BONGKAR MUAT',
          name: 'tarif_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
        },
        {
          label: 'USER APPROVAL',
          name: 'userapprovalmandor',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          search: (accessCabang == 'MEDAN') ? true : false,
          hidden: (accessCabang == 'MEDAN') ? false : true
        },
        {
          label: 'TGL APPROVAL',
          name: 'tglapprovalmandor',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          search: (accessCabang == 'MEDAN') ? true : false,
          hidden: (accessCabang == 'MEDAN') ? false : true,
          align: 'left',
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y H:i:s"
          }
        },
        {
          label: 'MODIFIED BY',
          name: 'modifiedby',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
        },
        {
          label: 'CREATED AT',
          name: 'created_at',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          align: 'left',
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y H:i:s"
          }
        },
        {
          label: 'UPDATED AT',
          name: 'updated_at',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          align: 'left',
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y H:i:s"
          }
        },
      ];
    }

    function getSavedColumnOrder() {
      return JSON.parse(localStorage.getItem(`tas_${window.location.href}_${authUserId}`));
    }
    // Menyimpan urutan kolom ke local storage
    function saveColumnOrder() {
      var colOrder = $("#jqGrid").jqGrid("getGridParam", "colModel").map(function(col) {
        return col.name;
      });
      localStorage.setItem(`tas_${window.location.href}_${authUserId}`, JSON.stringify(colOrder));
    }
    // Mengatur ulang urutan colModel berdasarkan urutan yang disimpan
    function reorderColModel(colModel, colOrder) {
      if (!colOrder) return colModel;
      var orderedColModel = [];
      colOrder.forEach(function(colName) {
        var col = colModel.find(function(c) {
          return c.name === colName;
        });
        if (col) orderedColModel.push(col);
      });
      return orderedColModel;
    }
    var colModel = createColModel();
    var savedColOrder = getSavedColumnOrder();
    var orderedColModel = reorderColModel(colModel, savedColOrder);



    $("#jqGrid").jqGrid({
        url: `${apiUrl}listtrip`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        postData: {
          tgldari: $('#tgldariheader').val(),
          tglsampai: $('#tglsampaiheader').val(),
          supirheader: $('#supirheader_id').val(),
        },
        datatype: "json",
        colModel: orderedColModel,
        autowidth: true,
        shrinkToFit: false,
        height: 350,
        rowNum: rowNum,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [10, 20, 50, 0],
        toolbar: [true, "top"],
        sortable: true,
        sortname: sortname,
        sortorder: sortorder,
        page: page,
        pager: pager,
        viewrecords: true,
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
          $.each(selectedRows, function(key, value) {

            $('#jqGrid tbody tr').each(function(row, tr) {
              if ($(this).find(`td input:checkbox`).val() == value) {
                $(this).find(`td input:checkbox`).prop('checked', true)
                $(this).addClass('bg-light-blue')
              }
            })

          });

          /* Set global variables */
          sortname = $(this).jqGrid("getGridParam", "sortname")
          sortorder = $(this).jqGrid("getGridParam", "sortorder")
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
              $(`#jqGrid [id="${$('#jqGrid').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#jqGrid [id="${$('#jqGrid').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#jqGrid').getDataIDs()[indexRow] == undefined) {
              $(`#jqGrid [id="` + $('#jqGrid').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#jqGrid').setSelection($('#jqGrid').getDataIDs()[indexRow])
          }
          permission()
          setHighlight($(this))
        },
      })

      .jqGrid("setLabel", "rn", "No.")
      .jqGrid('filterToolbar', {
        stringResult: true,
        searchOnEnter: false,
        defaultSearch: 'cn',
        groupOp: 'AND',
        beforeSearch: function() {
          abortGridLastRequest($(this))

          clearGlobalSearch($('#jqGrid'))
        }
      })

      .customPager({

        buttons: [{
            id: 'add',
            innerHTML: '<i class="fa fa-plus"></i> ADD',
            class: 'btn btn-primary btn-sm mr-1',
            onClick: function(event) {
              createRitasi()
            }
          },
          {
            id: 'edit',
            innerHTML: '<i class="fa fa-pen"></i> EDIT',
            class: 'btn btn-success btn-sm mr-1',
            onClick: () => {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Harap pilih salah satu record')
              } else {
                let flag = $(`#jqGrid tr#${selectedId}`).find(`td[aria-describedby="jqGrid_flag"]`).attr('title');
                let idoriginal = $(`#jqGrid tr#${selectedId}`).find(`td[aria-describedby="jqGrid_idoriginal"]`).attr('title');
                if (flag != 1) {
                  cekValidasiRitasi(idoriginal, 'EDIT')
                } else {
                  cekValidasi(idoriginal, 'EDIT')
                }

              }
            }
          },
          {
            id: 'delete',
            innerHTML: '<i class="fa fa-trash"></i> DELETE',
            class: 'btn btn-danger btn-sm mr-1',
            onClick: () => {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Harap pilih salah satu record')
              } else {
                let flag = $(`#jqGrid tr#${selectedId}`).find(`td[aria-describedby="jqGrid_flag"]`).attr('title');
                let idoriginal = $(`#jqGrid tr#${selectedId}`).find(`td[aria-describedby="jqGrid_idoriginal"]`).attr('title');
                if (flag != 1) {
                  cekValidasiRitasi(idoriginal, 'DELETE')
                } else {
                  cekValidasi(idoriginal, 'DELETE')
                }
              }
            }
          },
          {
            id: 'view',
            innerHTML: '<i class="fa fa-eye"></i> VIEW',
            class: 'btn btn-orange btn-sm mr-1',
            onClick: () => {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Harap pilih salah satu record')
              } else {
                let flag = $(`#jqGrid tr#${selectedId}`).find(`td[aria-describedby="jqGrid_flag"]`).attr('title');
                let idoriginal = $(`#jqGrid tr#${selectedId}`).find(`td[aria-describedby="jqGrid_idoriginal"]`).attr('title');
                if (flag != 1) {
                  viewRitasi(idoriginal)
                } else {
                  viewTrip(idoriginal)
                }
              }
            }
          },
          {
            id: 'approve',
            innerHTML: '<i class="fa fa-check"></i> APPROVAL/UN',
            class: 'btn btn-purple btn-sm mr-1',
            onClick: function(event) {
              approvalMandor()
            }
          },
        ]
      })

      $("thead tr.ui-jqgrid-labels").sortable({
      stop: function(event, ui) {
        saveColumnOrder();
        console.log("Column order updated!");
      }
    });


    /* Append clear filter button */
    loadClearFilter($('#jqGrid'))

    /* Append global search */
    loadGlobalSearch($('#jqGrid'))

    function permission() {
      if (!`{{ $myAuth->hasPermission('ritasi', 'store') }}`) {
        $('#add').hide()
      }
      if (!`{{ $myAuth->hasPermission('listtrip', 'update') }}`) {
        $('#edit').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('listtrip', 'destroy') }}`) {
        $('#delete').attr('disabled', 'disabled')
      }
      if (!`{{ $myAuth->hasPermission('listtrip', 'approval') }}`) {
        $('#approve').hide()
      }
    }

  })

  function approvalMandor() {
    event.preventDefault()
    let requestDataTrip = {
      'nobukti': selectedbukti,
      'id': selectedRows,
    };
    $.ajax({
      url: `${apiUrl}listtrip/approval`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        detail: JSON.stringify(requestDataTrip)
      },
      success: response => {
        $('#jqGrid').jqGrid('setGridParam', {
          postData: {
            supirheader: $('#supirheader_id').val(),
            proses: 'reload'
          }
        }).trigger('reloadGrid');
        selectedRows = []
        selectedbukti = []
        $('#gs_').prop('checked', false)
      },
      error: error => {
        if (error.status === 422) {
          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()

          setErrorMessages($('#crudForm'), error.responseJSON.errors);
        } else {
          showDialog(error.responseJSON)
        }
      },
    }).always(() => {
      $('#processingLoader').addClass('d-none')
      $(this).removeAttr('disabled')
    })
  }
</script>
@endpush()
@endsection