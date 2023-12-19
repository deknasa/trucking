@extends('layouts.master')

@section('content')
<!-- Grid -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <table id="jqGrid"></table>
    </div>
  </div>
</div>


@include('pengajuantripinap._modal')

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
  let sortname = 'tglabsensi'
  let sortorder = 'asc'
  let autoNumericElements = []
  let rowNum = 10
  let tgldariheader
  let tglsampaiheader
  let approveRequest =null
  reloadGrid()
  $(document).ready(function() {

    $("#jqGrid").jqGrid({
        url: `${apiUrl}pengajuantripinap`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        colModel: [{
            label: 'ID',
            name: 'id',
            align: 'right',
            width: '50px',
            search: false,
            hidden: true
          },
          {
            label: 'STATUS APPROVAL',
            name: 'statusapproval',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
            stype: 'select',
            searchoptions: {
              dataInit: function(element) {
                $(element).select2({
                  width: 'resolve',
                  theme: "bootstrap4",
                  ajax: {
                    url: `${apiUrl}parameter/combo`,
                    dataType: 'JSON',
                    headers: {
                      Authorization: `Bearer ${accessToken}`
                    },
                    data: {
                      grp: 'STATUS APPROVAL',
                      subgrp: 'STATUS APPROVAL'
                    },
                    beforeSend: () => {
                      // clear options
                      $(element).data('select2').$results.children().filter((index, element) => {
                        // clear options except index 0, which
                        // is the "searching..." label
                        if (index > 0) {
                          element.remove()
                        }
                      })
                    },
                    processResults: (response) => {
                      let formattedResponse = response.data.map(row => ({
                        id: row.text,
                        text: row.text
                      }));

                      formattedResponse.unshift({
                        id: '',
                        text: 'ALL'
                      });

                      return {
                        results: formattedResponse
                      };
                    },
                  }
                });
              }
            },
            formatter: (value, options, rowData) => {
              let statusApproval = JSON.parse(value)
              if(!statusApproval){
                return ''
              }

              let formattedValue = $(`
                  <div class="badge" style="background-color: ${statusApproval.WARNA}; color: ${statusApproval.WARNATULISAN};">
                    <span>${statusApproval.SINGKATAN}</span>
                  </div>
                `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusApproval = JSON.parse(rowObject.statusapproval)
              if(!statusApproval){
                return ''
              }

              return ` title="${statusApproval.MEMO}"`
            }
          },
          {
            label: 'tgl Absensi',
            name: 'tglabsensi',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'trado',
            name: 'trado',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left'
          },
          {
            label: 'supir',
            name: 'supir',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            align: 'left'
          },
          {
            label: 'MODIFIED BY',
            name: 'modifiedby',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left'
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
          activeGrid = $(this)
          indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
          page = $(this).jqGrid('getGridParam', 'page')
          let limit = $(this).jqGrid('getGridParam', 'postData').limit
          if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))
          
         

        },
        loadComplete: function(data) {
          changeJqGridRowListText()

          if (data.data.length === 0) {

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
        
        extndBtn: [
        //  {
        //     id: 'report',
        //     title: 'Report',
        //     caption: 'Report',
        //     innerHTML: '<i class="fa fa-print"></i> REPORT',
        //     class: 'btn btn-info btn-sm mr-1 dropdown-toggle',
        //     dropmenuHTML: [{
        //         id: 'reportPrinterBesar',
        //         text: "Printer Lain(Faktur)",
        //         onClick: () => {
        //           selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
        //           if (selectedId == null || selectedId == '' || selectedId == undefined) {
        //             showDialog('Harap pilih salah satu record')
        //           } else {
        //             cekValidasi(selectedId, 'PRINTER BESAR')
        //           }
        //         }
        //       },
        //       {
        //         id: 'reportPrinterKecil',
        //         text: "Printer Epson Seri LX(Faktur)",
        //         onClick: () => {
        //           selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
        //           if (selectedId == null || selectedId == '' || selectedId == undefined) {
        //             showDialog('Harap pilih salah satu record')
        //           } else {
        //             cekValidasi(selectedId, 'PRINTER KECIL')
        //           }
        //         }
        //       },

        //     ],
        //   },
        //   {
        //     id: 'export',
        //     title: 'Export',
        //     caption: 'Export',
        //     innerHTML: '<i class="fas fa-file-export"></i> EXPORT',
        //     class: 'btn btn-warning btn-sm mr-1',
        //     onClick: () => {

        //       selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
        //       if (selectedId == null || selectedId == '' || selectedId == undefined) {
        //         showDialog('Harap pilih salah satu record')
        //       } else {
                // window.open(`{{ route('serviceinheader.export') }}?id=${selectedId}`)
        //       }
        //     }
        //   },
          {
            id: 'approve',
            title: 'Approve',
            caption: 'Approve',
            innerHTML: '<i class="fa fa-check"></i> UN/APPROVAL',
            class: 'btn btn-purple btn-sm mr-1',
            onClick: () => {
              if (`{{ $myAuth->hasPermission('pengajuantripinap', 'approval') }}`) {
                selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                console.log(selectedId);
                approve(selectedId)
              }
            }
          }
        ],
        buttons: [{
            id: 'add',
            innerHTML: '<i class="fa fa-plus"></i> ADD',
            class: 'btn btn-primary btn-sm mr-1',
            onClick: function(event) {
              createPengajuanTripInap()
            }
          },
          {
            id: 'edit',
            innerHTML: '<i class="fa fa-pen"></i> EDIT',
            class: 'btn btn-success btn-sm mr-1',
            onClick: function(event) {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Harap pilih salah satu record')
              } else {
                cekValidasi(selectedId, 'EDIT')
                
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
                cekValidasi(selectedId, 'DELETE')
                
              }
            }
          },
          {
            id: 'view',
            innerHTML: '<i class="fa fa-eye"></i> VIEW',
            class: 'btn btn-orange btn-sm mr-1',
            onClick: () => {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              viewPengajuanTripInap(selectedId)
            }
          },
        ]
      })

    /* Append clear filter button */
    loadClearFilter($('#jqGrid'))

    /* Append global search */
    loadGlobalSearch($('#jqGrid'))


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

      function permission() {
    if (!`{{ $myAuth->hasPermission('pengajuantripinap', 'store') }}`) {
      $('#add').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('pengajuantripinap', 'update') }}`) {
      $('#edit').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('pengajuantripinap', 'show') }}`) {
      $('#view').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('pengajuantripinap', 'destroy') }}`) {
      $('#delete').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('pengajuantripinap', 'export') }}`) {
      $('#export').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('pengajuantripinap', 'report') }}`) {
      $('#report').attr('disabled', 'disabled')
    }
    if (!`{{ $myAuth->hasPermission('pengajuantripinap', 'approval') }}`) {
      $('#approve').attr('disabled', 'disabled')
    }}

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

    $('#formRange').submit(function(event) {
      event.preventDefault()

      let params
      let submitButton = $(this).find('button:submit')

      submitButton.attr('disabled', 'disabled')

      /* Set params value */
      for (var key in postData) {
        if (params != "") {
          params += "&";
        }
        params += key + "=" + encodeURIComponent(postData[key]);
      }

      let formRange = $('#formRange')
      let offset = parseInt(formRange.find('[name=dari]').val()) - 1
      let limit = parseInt(formRange.find('[name=sampai]').val().replace('.', '')) - offset
      params += `&offset=${offset}&limit=${limit}`

      if ($('#rangeModal').data('action') == 'export') {
        let xhr = new XMLHttpRequest()
        xhr.open('GET', `{{ config('app.api_url') }}pengajuantripinap/export?${params}`, true)
        xhr.setRequestHeader("Authorization", `Bearer {{ session('access_token') }}`)
        xhr.responseType = 'arraybuffer'

        xhr.onload = function(e) {
          if (this.status === 200) {
            if (this.response !== undefined) {
              let blob = new Blob([this.response], {
                type: "application/vnd.ms-excel"
              })
              let link = document.createElement('a')

              link.href = window.URL.createObjectURL(blob)
              link.download = `laporanpengajuantripinap${(new Date).getTime()}.xlsx`
              link.click()

              submitButton.removeAttr('disabled')
            }
          }
        }

        xhr.send()
      } else if ($('#rangeModal').data('action') == 'report') {
        // window.open(`{{ route('serviceinheader.report') }}?${params}`)

        submitButton.removeAttr('disabled')
      }
    })


    function getStatusApproval() {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: `${apiUrl}parameter`,
          method: 'GET',
          dataType: 'JSON',
          headers: {
            Authorization: `Bearer ${accessToken}`
          },
          data: {
            limit: 0,
            filters: JSON.stringify({
              "groupOp": "AND",
              "rules": [{
                "field": "grp",
                "op": "cn",
                "data": "STATUS APPROVAL"
              }, {
                "field": "text",
                "op": "cn",
                "data": "APPROVAL"
              }]
            })
          },
          success: response => {
            statusApproval = response.data[0].id;
            resolve(statusApproval)
          },
          error:error=>{
            reject(error)
          }
        })
      })
    }

    function approve(id) {
      if (approveRequest) {
        approveRequest.abort();
      }
      approveRequest = $.ajax({
        url: `${apiUrl}pengajuantripinap/${id}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          getStatusApproval()
          .then(statusApproval=>{
            
            // console.log(statusApproval);
            let msg = `YAKIN Approve trip inap `
            if (response.data.statusapproval === statusApproval) {
              msg = `YAKIN UnApprove trip inap `
            }
            showConfirm(msg, response.data.nobukti, `pengajuantripinap/${response.data.id}/approval`)

          })
        },
      })
    }
  })
</script>
@endpush()
@endsection