@extends('layouts.master')

@section('content')
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      

      <table id="jqGrid"></table>
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-12">
      <table id="detailGrid"></table>
    </div>
  </div>
</div>
@include('reminderservice._modal')
<!-- Detail -->
@include('reminderservice._detail')

@push('scripts')
<script>
  let indexUrl = "{{ route('reminderservice.index') }}"
  let getUrl = "{{ route('reminderservice.get') }}"
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

  $(document).ready(function() {

    $('#lookup').hide()

    $("#jqGrid").jqGrid({
        url: `{{ config('app.api_url') . 'reminderservice' }}`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        postData: {
          tgldari: $('#tgldariheader').val(),
          tglsampai: $('#tglsampaiheader').val(),

        },
        datatype: "json",
        colModel: [{
            label: 'ID',
            name: 'id',
            align: 'right',
            width: '50px',
            search: false,
            hidden: true
          },
          // {
          //   label: 'STATUS APPROVAL',
          //   name: 'statusapproval',
          //   align: 'left',
          //   stype: 'select',
          //   searchoptions: {
          //     value: `<?php
          //             $i = 1;

          //             foreach ($data['comboapproval'] as $status) :
          //               echo "$status[param]:$status[parameter]";
          //               if ($i !== count($data['comboapproval'])) {
          //                 echo ";";
          //               }
          //               $i++;
          //             endforeach

          //             ?>
          //     `,
          //     dataInit: function(element) {
          //       $(element).select2({
          //         width: 'resolve',
          //         theme: "bootstrap4"
          //       });
          //     }
          //   },
          //   formatter: (value, options, rowData) => {
          //     let statusApproval = JSON.parse(value)

          //     let formattedValue = $(`
          //       <div class="badge" style="background-color: ${statusApproval.WARNA}; color: #fff;">
          //         <span>${statusApproval.SINGKATAN}</span>
          //       </div>
          //     `)

          //     return formattedValue[0].outerHTML
          //   },
          //   cellattr: (rowId, value, rowObject) => {
          //     let statusApproval = JSON.parse(rowObject.statusapproval)

          //     return ` title="${statusApproval.MEMO}"`
          //   }
          // },
          // {
          //   label: 'STATUS CETAK',
          //   name: 'statuscetak',
          //   align: 'left',
          //   stype: 'select',
          //   searchoptions: {

          //     value: `<?php
          //             $i = 1;

          //             foreach ($data['combocetak'] as $status) :
          //               echo "$status[param]:$status[parameter]";
          //               if ($i !== count($data['combocetak'])) {
          //                 echo ";";
          //               }
          //               $i++;
          //             endforeach

          //             ?>
          //     `,
          //     dataInit: function(element) {
          //       $(element).select2({
          //         width: 'resolve',
          //         theme: "bootstrap4"
          //       });
          //     }
          //   },
          //   formatter: (value, options, rowData) => {
          //     let statusCetak = JSON.parse(value)

          //     let formattedValue = $(`
          //       <div class="badge" style="background-color: ${statusCetak.WARNA}; color: #fff;">
          //         <span>${statusCetak.SINGKATAN}</span>
          //       </div>
          //     `)

          //     return formattedValue[0].outerHTML
          //   },
          //   cellattr: (rowId, value, rowObject) => {
          //     let statusCetak = JSON.parse(rowObject.statuscetak)

          //     return ` title="${statusCetak.MEMO}"`
          //   }
          // },
          {
            label: 'NO Pol',
            name: 'nopol',
            align: 'left'
          },
          {
            label: 'tanggal',
            name: 'tanggal',
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'status',
            name: 'status',
            align: 'left'
          },
          {
            label: 'limit',
            name: 'limit',
            align: 'right',
            formatter: currencyFormat,
          },  
          {
            label: 'perjalanan',
            name: 'perjalanan',
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

          loadDetailData(id)
          activeGrid = $(this)
          indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
          page = $(this).jqGrid('getGridParam', 'page')
          let limit = $(this).jqGrid('getGridParam', 'postData').limit
          if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))
        },
        loadComplete: function(data) {
          changeJqGridRowListText()

          if (data.data.length === 0) {
            abortGridLastRequest($('#detail'))
            clearGridData($('#detail'))
            $('#jqGrid').each((index, element) => {
              abortGridLastRequest($(element))
              clearGridHeader($(element))
            })
          }

          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))

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

          setTimeout(function() {

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
          }, 100)

          $('#left-nav').find('button').attr('disabled', false)
          permission()
          setHighlight($(this))
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
          $('#left-nav').find(`button:not(#add)`).attr('disabled', 'disabled')
          clearGlobalSearch($('#jqGrid'))
        },
      })
      .customPager({
        buttons: [{
            id: 'add',
            innerHTML: '<i class="fa fa-plus"></i> ADD',
            class: 'btn btn-primary btn-sm mr-1',
            onClick: function(event) {
              createreminderservice()
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
                cekValidasi(selectedId, 'DELETE')
              }
            }
          },
          {
            id: 'report',
            innerHTML: '<i class="fa fa-print"></i> REPORT',
            class: 'btn btn-info btn-sm mr-1',
            onClick: () => {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              window.open(`{{url('reminderservice/report/${selectedId}')}}`)
            }
          },
          {
            id: 'export',
            title: 'Export',
            caption: 'Export',
            innerHTML: '<i class="fas fa-file-export"></i> EXPORT',
            class: 'btn btn-warning btn-sm mr-1',
            onClick: () => {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Harap pilih salah satu record')
              } else {
                window.open(`{{url('reminderservice/export/${selectedId}')}}`)

              }
            }
          },
          {
            id: 'approval',
            innerHTML: '<i class="fa fa-check"></i> APPROVAL/UN',
            class: 'btn btn-purple btn-sm mr-1',
            onClick: () => {
              let selectedId = $('#jqGrid').jqGrid('getGridParam', 'selrow')
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Harap pilih salah satu record')
              } else {
                handleApproval(selectedId)
              }
            }
          },
        ]

      })

    /* Append clear filter button */
    loadClearFilter($('#jqGrid'))

    /* Append global search */
    loadGlobalSearch($('#jqGrid'))

    /* Load detail grid */
    loadDetailGrid()

    $('#add .ui-pg-div')
      .addClass(`btn btn-sm btn-primary`)
      .parent().addClass('px-1')

    $('#edit .ui-pg-div')
      .addClass('btn btn-sm btn-success')
      .parent().addClass('px-1')

    $('#delete .ui-pg-div')
      .addClass('btn btn-sm btn-danger')
      .parent().addClass('px-1')

    $('#report .ui-pg-div')
      .addClass('btn btn-sm btn-info')
      .parent().addClass('px-1')

    $('#export .ui-pg-div')
      .addClass('btn btn-sm btn-warning')
      .parent().addClass('px-1')

    $('#approval .ui-pg-div')
      .addClass('btn btn-sm btn-warning')
      .parent().addClass('px-1')

    function permission() {
      if (!`{{ $myAuth->hasPermission('reminderservice', 'store') }}`) {
        $('#add').addClass('ui-disabled')
      }

      if (!`{{ $myAuth->hasPermission('reminderservice', 'update') }}`) {
        $('#edit').addClass('ui-disabled')
      }

      if (!`{{ $myAuth->hasPermission('reminderservice', 'destroy') }}`) {
        $('#delete').addClass('ui-disabled')
      }

      if (!`{{ $myAuth->hasPermission('reminderservice', 'export') }}`) {
        $('#export').addClass('ui-disabled')
      }

      if (!`{{ $myAuth->hasPermission('reminderservice', 'report') }}`) {
        $('#report').addClass('ui-disabled')
      }
      if (!`{{ $myAuth->hasPermission('reminderservice', 'approval') }}`) {
        $('#approval').addClass('ui-disabled')
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
      if ($('#rangeModal').data('action') == 'export') {
        window.open(`{{url('reminderservice/export/${selectedId}')}}`)

        // } else if ($('#rangeModal').data('action') == 'report') {
      }

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

    function handleApproval(id) {
      $.ajax({
        url: `${apiUrl}reminderservice/${id}/approval`,
        method: 'POST',
        dataType: 'JSON',
        beforeSend: request => {
          request.setRequestHeader('Authorization', `Bearer ${accessToken}`)
        },
        success: response => {
          $('#loader').addClass('d-none')
          $('#jqGrid').trigger('reloadGrid')
        }
      }).always(() => {
        $('#processingLoader').addClass('d-none')
      })
    }

  })
</script>
@endpush()
@endsection