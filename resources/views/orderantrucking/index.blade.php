@extends('layouts.master')

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

@include('orderantrucking._modal')
@include('orderantrucking._modalUpdate')

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
  let activeGrid
  let rowNum = 10
  let selectedRows = [];
  let tgldariheader
  let tglsampaiheader

  let selectedbukti = [];

  function checkboxHandler(element) {
    let value = $(element).val();
    let valuebukti = $(`#jqGrid tr#${value}`).find(`td[aria-describedby="jqGrid_nobukti"]`).attr('title');
    if (element.checked) {
      selectedRows.push($(element).val())
      selectedbukti.push(valuebukti)
      $(element).parents('tr').addClass('bg-light-blue')
    } else {
      $(element).parents('tr').removeClass('bg-light-blue')
      for (var i = 0; i < selectedRows.length; i++) {
        if (selectedRows[i] == value) {
          selectedRows.splice(i, 1);
        }
      }
      if (selectedRows.length != $('#jqGrid').jqGrid('getGridParam').records) {
        $('#gs_').prop('checked', false)
      }

      for (var i = 0; i < selectedbukti.length; i++) {
        if (selectedbukti[i] == valuebukti) {
          selectedbukti.splice(i, 1);
        }
      }

      if (selectedbukti.length != $('#jqGrid').jqGrid('getGridParam').records) {
        $('#gs_').prop('checked', false)
      }

    }

  }


  setSpaceBarCheckedHandler()

  $(document).ready(function() {

    @isset($request['tgldari'])
    tgldariheader = `{{ $request['tgldari'] }}`;
    @endisset
    @isset($request['tglsampai'])
    tglsampaiheader = `{{ $request['tglsampai'] }}`;
    @endisset
    setRange(false, tgldariheader, tglsampaiheader)
    initDatepicker('datepickerIndex')
    $(document).on('click', '#btnReload', function(event) {
      loadDataHeader('orderantrucking')
      selectedRows = []
      $('#gs_').prop('checked', false)

    })

    $("#jqGrid").jqGrid({
        url: `${apiUrl}orderantrucking`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        postData: {
          tgldari: $('#tgldariheader').val(),
          tglsampai: $('#tglsampaiheader').val()
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
              return `<input type="checkbox" name="orderanTruckingId[]" class="checkbox-jqgrid" value="${rowData.id}" onchange="checkboxHandler(this)">`
            },
          },
          {
            label: 'STATUS APPROVAL',
            name: 'statusapprovalbukatrip',
            align: 'left',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            stype: 'select',
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
              let statusApproval = JSON.parse(rowObject.statusapprovalbukatrip)
              if (!statusApproval) {
                return ` title=" "`
              }
              return ` title="${statusApproval.MEMO}"`
            }
          },
          {
            label: 'ID',
            name: 'id',
            width: '50px',
            search: false,
            hidden: true
          },
          {
            label: 'NO BUKTI',
            name: 'nobukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'TGL BUKTI',
            name: 'tglbukti',
            formatter: "date",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'SUPIR',
            name: 'supir',
            width: (detectDeviceType() == "desktop") ? md_dekstop_3 : md_mobile_3,
          },
          {
            label: 'TRADO',
            name: 'trado',
            width: (detectDeviceType() == "desktop") ? md_dekstop_3 : md_mobile_3,
          },
          {
            label: 'MANDOR',
            name: 'mandor',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'CONTAINER',
            name: 'container_id',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
          },
          {
            label: 'CUSTOMER',
            name: 'agen_id',
            width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2
          },
          {
            label: 'JENIS ORDER',
            name: 'jenisorder_id',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'SHIPPER',
            name: 'pelanggan_id',
            width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
          },
          {
            label: 'no job EMKL (1)',
            name: 'nojobemkl',
            width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1
          },
          {
            label: 'no conT (1)',
            name: 'nocont',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          },
          {
            label: 'no seaL (1)',
            name: 'noseal',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'no job EMKL (2)',
            name: 'nojobemkl2',
            width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1
          },
          {
            label: 'no conT (2)',
            name: 'nocont2',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          },
          {
            label: 'no seaL (2)',
            name: 'noseal2',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'EDIT ORDERAN TRUCKING',
            name: 'statusapprovaledit',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
            stype: 'select',
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['comboapprovaledit'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['comboapprovaledit'])) {
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
              let statusApprovalEdit = JSON.parse(value)
              if (!statusApprovalEdit) {
                return ''
              }
              let formattedValue = $(`
                    <div class="badge" style="background-color: ${statusApprovalEdit.WARNA}; color: #fff;">
                    <span>${statusApprovalEdit.SINGKATAN}</span>
                    </div>
                `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusApprovalEdit = JSON.parse(rowObject.statusapprovaledit)
              if (!statusApprovalEdit) {
                return ` title=" "`
              }
              return ` title="${statusApprovalEdit.MEMO}"`
            }
          },
          {
            label: 'TGL APP EDIT',
            name: 'tglapprovaledit',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'USER APP EDIT',
            name: 'userapprovaledit',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'TGL BATAS EDIT',
            name: 'tglbataseditorderantrucking',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            align: 'right',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y H:i:s"
            }
          },
          {
            label: 'APP TANPA JOB',
            name: 'statusapprovaltanpajob',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
            stype: 'select',
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['comboapprovaltanpajob'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['comboapprovaltanpajob'])) {
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
              let statusApprovalTanpaJob = JSON.parse(value)
              if (!statusApprovalTanpaJob) {
                return ''
              }
              let formattedValue = $(`
                    <div class="badge" style="background-color: ${statusApprovalTanpaJob.WARNA}; color: #fff;">
                    <span>${statusApprovalTanpaJob.SINGKATAN}</span>
                    </div>
                `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusApprovalTanpaJob = JSON.parse(rowObject.statusapprovaltanpajob)
              if (!statusApprovalTanpaJob) {
                return ` title=" "`
              }
              return ` title="${statusApprovalTanpaJob.MEMO}"`
            }
          },
          {
            label: 'TGL APP TANPA JOB',
            name: 'tglapprovaltanpajob',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'USER APP TANPA JOB',
            name: 'userapprovaltanpajob',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'TGL BATAS TANPA JOB',
            name: 'tglbatastanpajoborderantrucking',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            align: 'right',
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
            align: 'right',
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
            align: 'right',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y H:i:s"
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
        sortable: true,
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
          $('#left-nav').find('button').attr('disabled', false)
          permission()
          $('#gs_').attr('disabled', false)
          getQueryParameter()
          setHighlight($(this))
        },
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
          $('#left-nav').find(`button:not(#add)`).attr('disabled', 'disabled')
          clearGlobalSearch($('#jqGrid'))
        },
      })

      .customPager({
        buttons: [{
            id: 'edit',
            innerHTML: '<i class="fa fa-pen"></i> EDIT',
            class: 'btn btn-success btn-sm mr-1',
            onClick: () => {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              rawCellValue = $("#jqGrid").jqGrid('getCell', selectedId, 'nobukti');
              celValue = $("<div>").html(rawCellValue).text();
              selectednobukti = celValue

              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Harap pilih salah satu record')
              } else {
                cekValidasidelete(selectedId, 'edit', selectednobukti)
              }
            }
          },
          {
            id: 'delete',
            innerHTML: '<i class="fa fa-trash"></i> DELETE',
            class: 'btn btn-danger btn-sm mr-1',
            onClick: () => {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              rawCellValue = $("#jqGrid").jqGrid('getCell', selectedId, 'nobukti');
              celValue = $("<div>").html(rawCellValue).text();
              selectednobukti = celValue
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Harap pilih salah satu record')
              } else {
                cekValidasidelete(selectedId, 'delete', selectednobukti)
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
                viewOrderanTrucking(selectedId)
              }
            }
          },
          {
            id: 'report',
            innerHTML: '<i class="fa fa-print"></i> REPORT',
            class: 'btn btn-info btn-sm mr-1',
            onClick: () => {
              $('#formRangeTgl').data('action', 'report')
              $('#rangeTglModal').find('button:submit').html(`Report`)
              $('#rangeTglModal').modal('show')
              clearSelectedRows()
              $('#gs_').prop('checked', false)
            }
          },
          {
            id: 'export',
            innerHTML: '<i class="fa fa-file-export"></i> EXPORT',
            class: 'btn btn-warning btn-sm mr-1',
            onClick: () => {
              $('#formRangeTgl').data('action', 'export')
              $('#rangeTglModal').find('button:submit').html(`Export`)
              $('#rangeTglModal').modal('show')
              clearSelectedRows()
              $('#gs_').prop('checked', false)
            }
          },

        ],
        modalBtnList: [{
            id: 'approve',
            title: 'Approve',
            caption: 'Approve',
            innerHTML: '<i class="fa fa-check"></i> APPROVAL/UN',
            class: 'btn btn-purple btn-sm mr-1  ',
            item: [{
                id: 'approveun',
                text: "APPROVAL/UN status orderan trucking",
                color: `<?php echo $data['listbtn']->btn->approvaldata; ?>`,
                hidden: (!`{{ $myAuth->hasPermission('orderantrucking', 'approval') }}`),
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('orderantrucking', 'approval') }}`) {
                    approve()
                  }
                }
              },
              {
                id: 'approvalEditOrderanTrucking',
                text: "APPROVAL/UN Edit orderan trucking",
                color: `<?php echo $data['listbtn']->btn->approvaledit; ?>`,
                hidden: (!`{{ $myAuth->hasPermission('orderantrucking', 'approvaledit') }}`),
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('orderantrucking', 'approvaledit') }}`) {
                    approvalEditOrderanTrucking();
                  }
                  // selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                }
              },
              {
                id: 'approvalTanpaJob',
                text: "APPROVAL/UN Tanpa Job EMKL",
                color: `<?php echo $data['listbtn']->btn->approvaltanpajob; ?>`,
                hidden: (!`{{ $myAuth->hasPermission('orderantrucking', 'approvaltanpajobemkl') }}`),
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('orderantrucking', 'approvaltanpajobemkl') }}`) {
                    approvalTanpaJobEMKL();
                  }
                  // selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                }
              },
            ],
          },
          {
            id: 'lainnya',
            title: 'Lainnya',
            caption: 'Lainnya',
            innerHTML: '<i class="fa fa-check"></i> LAINNYA',
            class: 'btn btn-secondary btn-sm mr-1  ',
            item: [{
              id: 'updateNoContainer',
              text: "Update No Container",
              color: `<?php echo $data['listbtn']->btn->updatenocontainer; ?>`,
              onClick: () => {
                var selectedOne = selectedOnlyOne();
                if (selectedOne[0]) {
                  updateOrderanTrucking(selectedOne[1])
                } else {
                  showDialog(selectedOne[1])
                }
              }
            }]
          }
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

    $('#rangeTglModal').on('shown.bs.modal', function() {
      initDatepicker()

      $('#formRangeTgl').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
      $('#formRangeTgl').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    })

    $('#formRangeTgl').submit(event => {
      event.preventDefault()
      let params
      let actionUrl = ``
      let submitButton = $(this).find('button:submit')

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

      let formRange = $('#formRangeTgl')
      let dari = formRange.find('[name=dari]').val()
      let sampai = formRange.find('[name=sampai]').val()
      params += `&dari=${dari}&sampai=${sampai}`

      if ($('#formRangeTgl').data('action') == 'export') {
        let actionUrl = `{{ route('orderantrucking.export') }}`
        /* Clear validation messages */
        $('.is-invalid').removeClass('is-invalid')
        $('.invalid-feedback').remove()
        // window.open(`${actionUrl}?${$('#formRangeTgl').serialize()}`)
        $.ajax({
          url: `${apiUrl}orderantrucking/export`,
          type: 'GET',
          data: {
            dari: dari,
            sampai: sampai,
            export: true
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
                link.download = 'LAPORAN ORDERAN TRUCKING' + new Date().getTime() + '.xlsx';
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
      } else if ($('#formRangeTgl').data('action') == 'report') {
        window.open(`{{ route('orderantrucking.report') }}?${params}`)
      }
    })

    // function getCekExport() {
    //   return new Promise((resolve, reject) => {
    //     $.ajax({
    //       url: `${apiUrl}orderantrucking/export`,
    //       dataType: "JSON",
    //       headers: {
    //         Authorization: `Bearer ${accessToken}`
    //       },
    //       data: {
    //         dari: $('#formRangeTgl').find('[name=dari]').val(),
    //         sampai: $('#formRangeTgl').find('[name=sampai]').val()
    //       },
    //       success: (response) => {
    //         resolve(response);
    //       },
    //       error: error => {
    //         reject(error)

    //       },
    //     });
    //   });
    // }

    function permission() {
      if (!`{{ $myAuth->hasPermission('orderantrucking', 'store') }}`) {
        $('#add').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('orderantrucking', 'show') }}`) {
        $('#view').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('orderantrucking', 'update') }}`) {
        $('#edit').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('orderantrucking', 'destroy') }}`) {
        $('#delete').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('orderantrucking', 'report') }}`) {
        $('#report').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('orderantrucking', 'export') }}`) {
        $('#export').attr('disabled', 'disabled')
      }
      let hakApporveCount = 0;
      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('orderantrucking', 'approval') }}`) {
        hakApporveCount--
        $('#approveun').hide()
        // $('#approval-buka-cetak').attr('disabled', 'disabled')
      }
      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('orderantrucking', 'approvaledit') }}`) {
        hakApporveCount--
        $('#approvalEditOrderanTrucking').hide()
        // $('#approval-buka-cetak').attr('disabled', 'disabled')
      }

      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('orderantrucking', 'approvaltanpajobemkl') }}`) {
        hakApporveCount--
        $('#approvalTanpaJob').hide()
        // $('#approval-buka-cetak').attr('disabled', 'disabled')
      }
      if (hakApporveCount < 1) {
        $('#approve').hide()
        // $('#approve').attr('disabled', 'disabled')
      }

      let hakLainnyaCount = 0;
      hakLainnyaCount++
      if (!`{{ $myAuth->hasPermission('orderantrucking', 'updateNoContainer') }}`) {
        hakLainnyaCount--
        $('#updateNoContainer').hide()
        // $('#approval-buka-cetak').attr('disabled', 'disabled')
      }
      if (hakLainnyaCount < 1) {
        // $('#approve').hide()
        $('#lainnya').hide()
      }
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
    selectedbukti = []

    $('#gs_').prop('checked', false)
    $('#jqGrid').trigger('reloadGrid')
  }

  function selectAllRows() {
    $.ajax({
      url: `${apiUrl}orderantrucking`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        limit: 0,
        tgldari: $('#tgldariheader').val(),
        tglsampai: $('#tglsampaiheader').val(),
        filters: $('#jqGrid').jqGrid('getGridParam', 'postData').filters
      },
      success: (response) => {
        selectedRows = response.data.map((datas) => datas.id)
        selectedbukti = response.data.map((datas) => datas.nobukti)
        $('#jqGrid').trigger('reloadGrid')
      }
    })
  }
</script>
@endpush()
@endsection