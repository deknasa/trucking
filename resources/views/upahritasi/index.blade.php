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

<!-- Detail -->
@include('upahritasi._detail')

@include('upahritasi._modal')

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
  let sortname = 'kotadari_id'
  let sortorder = 'asc'
  let autoNumericElements = []
  let rowNum = 10
  let hasDetail = false
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

  function clearSelectedRows() {
    selectedRows = []
    $('#gs_').prop('checked', false);
    $('#jqGrid').trigger('reloadGrid')
  }

  function selectAllRows() {
    $.ajax({
      url: `${apiUrl}upahritasi`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        limit: 0,
        filters: $('#jqGrid').jqGrid('getGridParam', 'postData').filters
      },
      success: (response) => {
        selectedRows = response.data.map((upahritasi) => upahritasi.id)
        $('#jqGrid').trigger('reloadGrid')
      }
    })
  }

  $(document).ready(function() {

    $("#jqGrid").jqGrid({
        url: `${apiUrl}upahritasi`,
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
            label: 'DARI',
            name: 'kotadari_id',
            width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
            align: 'left'
          },
          {
            label: 'TUJUAN',
            name: 'kotasampai_id',
            width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
            align: 'left'
          },
          {
            label: 'JARAK',
            name: 'jarak',
            align: 'right',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            // formatter: currencyFormat
          },
          {
            label: 'NOMINAL SUPIR',
            name: 'nominalsupir',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat
          },
          {
            label: 'STATUS AKTIF',
            name: 'statusaktif',
            stype: 'select',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['combo'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['combo'])) {
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
              let statusAktif = JSON.parse(value)

              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusAktif.WARNA}; color: ${statusAktif.WARNATULISAN};">
                  <span>${statusAktif.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusAktif = JSON.parse(rowObject.statusaktif)

              return ` title="${statusAktif.MEMO}"`
            }
          },
          // {
          //   label: 'TGL MULAI BERLAKU',
          //   name: 'tglmulaiberlaku',
          //   formatter: "date",
          //   width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          //   formatoptions: {
          //     srcformat: "ISO8601Long",
          //     newformat: "d-m-Y"
          //   }
          // },
          // {
          //   label: 'TGL AKHIR BERLAKU',
          //   name: 'tglakhirberlaku',
          //   formatter: "date",
          //   formatoptions: {
          //     srcformat: "ISO8601Long",
          //     newformat: "d-m-Y"
          //   }
          // },
          // {
          //   label: 'STATUS LUAR KOTA',
          //   name: 'statusluarkota',
          //   align: 'left',
          //   stype: 'select',
          //   searchoptions: {
          //     value: `<?php
                          //             $i = 1;

                          //             foreach ($data['comboluarkota'] as $status) :
                          //               echo "$status[param]:$status[parameter]";
                          //               if ($i !== count($data['comboluarkota'])) {
                          //                 echo ";";
                          //               }
                          //               $i++;
                          //             endforeach

                          //             
                          ?>
          //   `,
          //     dataInit: function(element) {
          //       $(element).select2({
          //         width: 'resolve',
          //         theme: "bootstrap4"
          //       });
          //     }
          //   },
          // },
          {
            label: 'MODIFIED BY',
            name: 'modifiedby',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            align: 'left'
          },
          {
            label: 'CREATED AT',
            name: 'created_at',
            align: 'right',
            formatter: "date",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y H:i:s"
            }
          },
          {
            label: 'UPDATED AT',
            name: 'updated_at',
            align: 'right',
            formatter: "date",
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
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
        ajaxRowOptions: {
          async: false,
        },
        onSelectRow: function(id) {
          activeGrid = $(this)

          indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
          page = $(this).jqGrid('getGridParam', 'page')
          let limit = $(this).jqGrid('getGridParam', 'postData').limit
          if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))

          if (!hasDetail) {
            loadDetailGrid(id)
            hasDetail = true
          }

          loadDetailData(id)
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
            onClick: () => {
              createUpahRitasi()
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
                cekValidasidelete(selectedId, 'EDIT')
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
                cekValidasidelete(selectedId, 'DELETE')
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
                viewUpahRitasi(selectedId)
              }
            }
          },
          {
            id: 'report',
            innerHTML: '<i class="fa fa-print"></i> REPORT',
            class: 'btn btn-info btn-sm mr-1',
            onClick: () => {
              $('#processingLoader').removeClass('d-none')
              $.ajax({
                url: `{{ route('upahritasi.report') }}`,
                method: 'GET',
                data: {
                  limit: 0,
                  filters: $('#jqGrid').jqGrid('getGridParam', 'postData').filters
                },
                success: function(response) {
                  $('#processingLoader').addClass('d-none')
                  // Handle the success response
                  var newWindow = window.open('', '_blank');
                  newWindow.document.open();
                  newWindow.document.write(response);
                  newWindow.document.close();
                },
                error: function(xhr, status, error) {
                 
                  $('#processingLoader').addClass('d-none')
                  showDialog('TIDAK ADA DATA')
                }
              });
            }
          },
          {
            id: 'export',
            title: 'Export',
            caption: 'Export',
            innerHTML: '<i class="fas fa-file-export"></i> EXPORT',
            class: 'btn btn-warning btn-sm mr-1',
            onClick: () => {
              // selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              // if (selectedId == null || selectedId == '' || selectedId == undefined) {
              //   showDialog('Harap pilih salah satu record')
              // } else {
              //   window.open(`{{ route('upahritasi.export') }}?id=${selectedId}`)
              // }
              $('#processingLoader').removeClass('d-none')
              $.ajax({
                url: `{{ route('upahritasi.export') }}`,
                type: 'GET',
                data: {
                  limit: 0,
                  filters: $('#jqGrid').jqGrid('getGridParam', 'postData').filters
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
                      link.download = `LAPORAN UPAH RITASI ${new Date().getTime()}.xlsx`;
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
          {
            id: 'import',
            innerHTML: '<i class="fas fa-file-upload"></i> UPDATE HARGA',
            class: 'btn btn-purple btn-sm mr-1',
            onClick: () => {
              // $('#importModal').data('action', 'import')
              $('#importModal').find('button:submit').html(`Update Harga`)
              $('#importModal').modal('show')
            }
          }
        ],
        modalBtnList: [{
          id: 'approve',
          title: 'Approve',
          caption: 'Approve',
          innerHTML: '<i class="fa fa-check"></i> APPROVAL/UN',
          class: 'btn btn-purple btn-sm mr-1 ',
          item: [{
              id: 'approvalaktif',
              text: "APPROVAL AKTIF",
              color: `<?php echo $data['listbtn']->btn->approvalaktif; ?>`,
              hidden: (!`{{ $myAuth->hasPermission('upahritasi', 'approvalaktif') }}`),
              onClick: () => {
                if (`{{ $myAuth->hasPermission('upahritasi', 'approvalaktif') }}`) {
                  approvalAktif('upahritasi')

                }
              }
            },
            {
              id: 'approvalnonaktif',
              text: "APPROVAL NON AKTIF",
              color: `<?php echo $data['listbtn']->btn->approvalnonaktif; ?>`,
              hidden: (!`{{ $myAuth->hasPermission('upahritasi', 'approvalnonaktif') }}`),
              onClick: () => {
                if (`{{ $myAuth->hasPermission('upahritasi', 'approvalnonaktif') }}`) {
                  approvalNonAktif('upahritasi')
                }
              }
            },

          ],
        }]
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

    function permission() {
      if (!`{{ $myAuth->hasPermission('upahritasi', 'store') }}`) {
        $('#add').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('upahritasi', 'update') }}`) {
        $('#edit').attr('disabled', 'disabled')
      }
      if (!`{{ $myAuth->hasPermission('upahritasi', 'show') }}`) {
        $('#view').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('upahritasi', 'destroy') }}`) {
        $('#delete').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('upahritasi', 'export') }}`) {
        $('#export').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('upahritasi', 'report') }}`) {
        $('#report').attr('disabled', 'disabled')
      }
      if (!`{{ $myAuth->hasPermission('upahritasi', 'updateharga') }}`) {
        $('#approvalEdit').attr('disabled', 'disabled')
      }

      let hakApporveCount = 0;

      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('upahritasi', 'approvalaktif') }}`) {
        hakApporveCount--
        $('#approvalaktif').hide()
      }
      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('upahritasi', 'approvalnonaktif') }}`) {
        hakApporveCount--
        $('#approvalnonaktif').hide()
      }
      if (hakApporveCount < 1) {
        $('#approve').hide()
      }
    }


    $('#rangeTglModal').on('shown.bs.modal', function() {


      initDatepicker()

      $('#formRangeTgl').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
      $('#formRangeTgl').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    })

    $('#formRangeTgl').submit(event => {
      event.preventDefault()

      getCekExport()
        .then((response) => {
          let actionUrl = `{{ route('upahritasi.export') }}`

          /* Clear validation messages */
          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()


          window.open(`${actionUrl}?${$('#formRangeTgl').serialize()}`)
        })
        .catch((error) => {
          setErrorMessages($('#formRangeTgl'), error.responseJSON.errors);
        })

    })

    function getCekExport() {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: `${apiUrl}upahritasi/export`,
          dataType: "JSON",
          headers: {
            Authorization: `Bearer ${accessToken}`
          },
          data: {
            dari: $('#formRangeTgl').find('[name=dari]').val(),
            sampai: $('#formRangeTgl').find('[name=sampai]').val()
          },
          success: (response) => {
            resolve(response);
          },
          error: error => {
            reject(error)

          },
        });
      });
    }
    $('#btnImport').click(function(event) {
      event.preventDefault()

      let url = `${apiUrl}upahritasi/import`
      let form_data = new FormData(document.getElementById('formImport'))
      let form = $('#formImport')

      $(this).attr('disabled', '')
      $('#processingLoader').removeClass('d-none')

      $.ajax({
        url: url,
        method: 'post',
        processData: false,
        contentType: false,
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: form_data,
        success: response => {
          var kondisi = response.kondisi
          console.log(kondisi)
          if (kondisi == false) {
            showDialog(response.keterangan);

            $('#formImport').trigger('reset')
            $('#importModal').modal('hide')
            $('#jqGrid').jqGrid().trigger('reloadGrid');

            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

          } else {

            showDialog(response.message['keterangan'])
          }
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
        console.log(response)
        showDialog(response.keterangan);
      })
    })
  })
</script>
@endpush()
@endsection