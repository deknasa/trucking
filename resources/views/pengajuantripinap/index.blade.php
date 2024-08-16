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
  let approveRequest = null
  let selectedRows = [];
  reloadGrid()

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

      if (selectedRows.length != $('#jqGrid').jqGrid('getGridParam').records) {
        $('#gs_').prop('checked', false)
      }
    }

  }

  function clearSelectedRows() {
    selectedRows = []
    $('#gs_').prop('checked', false)

    $('#jqGrid').trigger('reloadGrid')
  }

  function selectAllRows() {
    $.ajax({
      url: `${apiUrl}pengajuantripinap`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        limit: 0,
        sortIndex: $('#jqGrid').jqGrid("getGridParam", "postData").sortIndex,
        sortOrder: $('#jqGrid').jqGrid("getGridParam", "postData").sortOrder,
        filters: $('#jqGrid').jqGrid("getGridParam", "postData").filters
      },
      success: (response) => {
        selectedRows = response.data.map((supplier) => supplier.id)
        $('#jqGrid').trigger('reloadGrid')
      }
    })
  }
  setSpaceBarCheckedHandler()

  $(document).ready(function() {

    $("#jqGrid").jqGrid({
        url: `${apiUrl}pengajuantripinap`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
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
                $(element).removeClass('form-control')
                $(element).parent().addClass('text-center')

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
              return `<input type="checkbox" name="Id[]" value="${rowData.id}" onchange="checkboxHandler(this)">`
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
            label: 'STATUS APPROVAL',
            name: 'statusapproval',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
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
                  <div class="badge" style="background-color: ${statusApproval.WARNA}; color: ${statusApproval.WARNATULISAN};">
                    <span>${statusApproval.SINGKATAN}</span>
                  </div>
                `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusApproval = JSON.parse(rowObject.statusapproval)
              if (!statusApproval) {
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
            label: 'STATUS APP. LEWAT BATAS',
            name: 'statusapprovallewatbataspengajuan',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
            stype: 'select',
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['combobatas'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['combobatas'])) {
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
                  <div class="badge" style="background-color: ${statusApproval.WARNA}; color: ${statusApproval.WARNATULISAN};">
                    <span>${statusApproval.SINGKATAN}</span>
                  </div>
                `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusApproval = JSON.parse(rowObject.statusapprovallewatbataspengajuan)
              if (!statusApproval) {
                return ''
              }

              return ` title="${statusApproval.MEMO}"`
            }
          },
          {
            label: 'USER APP LEWAT BATAS',
            name: 'userapprovallewatbataspengajuan',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'TGL BATAS PENGAJUAN',
            name: 'tglbataslewatbataspengajuan',
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
          $('#gs_').attr('disabled', false)
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
            innerHTML: '<i class="fa fa-check"></i> APPROVAL/UN',
            class: 'btn btn-purple btn-sm mr-1 dropdown-toggle ',
            dropmenuHTML: [{
                id: 'approveun',
                text: "APPROVAL/UN Pengajuan Trip Inap",
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('pengajuantripinap', 'approval') }}`) {
                    approve()
                  }
                }
              },
              {
                id: 'approval-batas-pengajuan',
                text: "APPROVAL/UN Lewat Batas Pengajuan",
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('pengajuantripinap', 'approvalbataspengajuan') }}`) {
                    approveBatasPengajuan()
                  }
                }
              },
            ],
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
          {
            id: 'report',
            innerHTML: '<i class="fa fa-print"></i> REPORT',
            class: 'btn btn-info btn-sm mr-1',
            onClick: () => {

              $('#formRangeTgl').data('action', 'report')
              $('#rangeTglModal').find('button:submit').html(`Report`)
              $('#rangeTglModal').modal('show')
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

      let hakApporveCount = 0;
      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('pengajuantripinap', 'approval') }}`) {
        hakApporveCount--
        $('#approveun').hide()
        // $('#approval-buka-cetak').attr('disabled', 'disabled')
      }
      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('pengajuantripinap', 'approvalbataspengajuan') }}`) {
        hakApporveCount--
        $('#approval-batas-pengajuan').hide()
        // $('#approval-buka-cetak').attr('disabled', 'disabled')
      }
      if (hakApporveCount < 1) {
        $('#approve').hide()
        // $('#approve').attr('disabled', 'disabled')
      }
    }


    $('#rangeTglModal').on('shown.bs.modal', function() {


      initDatepicker()

      $('#formRangeTgl').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
      $('#formRangeTgl').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    })

    $('#formRangeTgl').submit(event => {
      event.preventDefault()

      let params

      let submitButton = $(this).find('button:submit')
      $('#processingLoader').removeClass('d-none')


      /* Set params value */
      for (var key in postData) {
        if (params != "") {
          params += "&";
        }
        params += key + "=" + encodeURIComponent(postData[key]);
      }

      let formRangeTgl = $('#formRangeTgl')
      let dari = formRangeTgl.find('[name=dari]').val()
      let sampai = formRangeTgl.find('[name=sampai]').val()
      params += `&dari=${dari}&sampai=${sampai}`

      console.log('here')
      if ($('#formRangeTgl').data('action') == 'export') {
        let xhr = new XMLHttpRequest()
        xhr.open('GET', `${apiUrl}pengajuantripinap/export?${params}`, true)
        xhr.setRequestHeader("Authorization", `Bearer ${accessToken}`)
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
              $('#processingLoader').addClass('d-none')
            }
          } else {
            showDialog('TIDAK ADA DATA')
            $('#processingLoader').addClass('d-none')
          }
        }

        xhr.send()
      } else if ($('#formRangeTgl').data('action') == 'report') {
        window.open(`{{ route('pengajuantripinap.report') }}?${params}`)

        $('#processingLoader').addClass('d-none')
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
          error: error => {
            reject(error)
          }
        })
      })
    }

    function approve() {
      event.preventDefault()

      let form = $('#crudForm')
      $(this).attr('disabled', '')
      $('#processingLoader').removeClass('d-none')
      let dataabsensi = [];
      let datatrado = [];
      let datasupir = [];
      $.each(selectedRows, function(index, row) {
        dataabsensi.push($(`#jqGrid tr#${row}`).find(`td[aria-describedby="jqGrid_tglabsensi"]`).attr('title'))
        datasupir.push($(`#jqGrid tr#${row}`).find(`td[aria-describedby="jqGrid_supir"]`).attr('title'))
        datatrado.push($(`#jqGrid tr#${row}`).find(`td[aria-describedby="jqGrid_trado"]`).attr('title'))
      })

      $.ajax({
        url: `${apiUrl}pengajuantripinap/approval`,
        method: 'POST',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          Id: selectedRows,
          supir: datasupir,
          absen: dataabsensi,
          trado: datatrado,
        },
        success: response => {
          $('#jqGrid').jqGrid().trigger('reloadGrid');
          selectedRows = []
          $('#gs_').prop('checked', false)
        },
        error: error => {
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            setErrorMessages(form, error.responseJSON.errors);
          } else {
            showDialog(error.responseJSON)
          }
        },
      }).always(() => {
        $('#processingLoader').addClass('d-none')
        $(this).removeAttr('disabled')
      })
    }
  })

  function approveBatasPengajuan() {
    event.preventDefault()

    let form = $('#crudForm')
    $(this).attr('disabled', '')
    $('#processingLoader').removeClass('d-none')
    let dataabsensi = [];
    let datatrado = [];
    let datasupir = [];
    $.each(selectedRows, function(index, row) {
      dataabsensi.push($(`#jqGrid tr#${row}`).find(`td[aria-describedby="jqGrid_tglabsensi"]`).attr('title'))
      datasupir.push($(`#jqGrid tr#${row}`).find(`td[aria-describedby="jqGrid_supir"]`).attr('title'))
      datatrado.push($(`#jqGrid tr#${row}`).find(`td[aria-describedby="jqGrid_trado"]`).attr('title'))
    })
    $.ajax({
      url: `${apiUrl}pengajuantripinap/approvalbataspengajuan`,
      method: 'POST',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        Id: selectedRows,
        supir: datasupir,
        absen: dataabsensi,
        trado: datatrado,
      },
      success: response => {
        $('#jqGrid').jqGrid().trigger('reloadGrid');
        selectedRows = []
        $('#gs_').prop('checked', false)
      },
      error: error => {
        if (error.status === 422) {
          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()

          setErrorMessages(form, error.responseJSON.errors);
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