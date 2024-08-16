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


@include('tariftangki._modal')

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
  let sortname = 'tujuan'
  let sortorder = 'asc'
  let autoNumericElements = []
  let rowNum = 10
  let hasDetail = false
  let selectedRows = [];
  let selectedRowsTarif = [];


  function checkboxHandler(element) {
    let value = $(element).val();
    if (element.checked) {
      selectedRows.push($(element).val())
      selectedRowsTarif.push($(element).parents('tr').find(`td[aria-describedby="jqGrid_tujuan"]`).text())
      $(element).parents('tr').addClass('bg-light-blue')


    } else {
      $(element).parents('tr').removeClass('bg-light-blue')
      for (var i = 0; i < selectedRows.length; i++) {
        if (selectedRows[i] == value) {
          selectedRows.splice(i, 1);
          selectedRowsTarif.splice(i, 1);
        }
      }
    }

  }


  function clearSelectedRows() {
    selectedRows = []
    selectedRowsTarif = []
    $('#gs_check').prop('checked', false);
    $('#jqGrid').trigger('reloadGrid')
  }

  function selectAllRows() {
    $.ajax({
      url: `${apiUrl}tariftangki`,
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
        selectedRows = response.data.map((tarif) => tarif.id)
        $('#jqGrid').trigger('reloadGrid')
      }
    })
  }

  $(document).ready(function() {

    // setTampilanIndex()
    $("#jqGrid").jqGrid({
        url: `${apiUrl}tariftangki`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        colModel: [{
            label: '',
            name: 'check',
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
            width: '50px',
            search: false,
            hidden: true
          },
          {
            label: 'PARENT',
            name: 'parent_id',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'UPAH SUPIR',
            name: 'upahsupirtangki',
            width: (detectDeviceType() == "desktop") ? md_dekstop_3 : md_mobile_3,
          },
          {
            label: 'TUJUAN',
            name: 'tujuan',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          },
          {
            label: 'PENYESUAIAN',
            name: 'penyesuaian',
            width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
          },
          {
            label: 'NOMINAL',
            name: 'nominal',
            align: 'right',
            formatter: currencyFormat
          },

          {
            label: 'STATUS',
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
          {
            label: 'KOTA',
            name: 'kota_id',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          },

          {
            label: 'TGL MULAI BERLAKU',
            name: 'tglmulaiberlaku',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'Keterangan',
            name: 'keterangan',
            width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
          },
          {
            label: 'MODIFIED BY',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            name: 'modifiedby',
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
            highlightSearch = ''
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

          $('#left-nav').find('button').attr('disabled', false)
          permission()
          $('#gs_check').attr('disabled', false)
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
          $('#left-nav').find(`button:not(#add)`).attr('disabled', 'disabled')
          clearGlobalSearch($('#jqGrid'))
        }
      })

      .customPager({
        buttons: [{
            id: 'add',
            innerHTML: '<i class="fa fa-plus"></i> ADD',
            class: 'btn add btn-primary btn-sm mr-1',
            onClick: () => {
              createTarifTangki()
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
            class: 'btn delete btn-danger btn-sm mr-1',
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
                viewTarifTangki(selectedId)
              }
            }
          },
          {
            id: 'report',
            innerHTML: '<i class="fa fa-print"></i> REPORT',
            class: 'btn btn-info btn-sm mr-1',
            onClick: () => {
              // $('#rangeModal').data('action', 'report')
              // $('#rangeModal').find('button:submit').html(`Report`)
              // $('#rangeModal').modal('show')

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
              // $('#rangeModal').data('action', 'export')
              // $('#rangeModal').find('button:submit').html(`Export`)
              // $('#rangeModal').modal('show')
              $('#formRangeTgl').data('action', 'export')
              $('#rangeTglModal').find('button:submit').html(`Export`)
              $('#rangeTglModal').modal('show')
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
              hidden: (!`{{ $myAuth->hasPermission('tariftangki', 'approvalaktif') }}`),
              onClick: () => {
                if (`{{ $myAuth->hasPermission('tariftangki', 'approvalaktif') }}`) {
                  approvalAktif('tariftangki')

                }
              }
            },
            {
              id: 'approvalnonaktif',
              text: "APPROVAL NON AKTIF",
              color: `<?php echo $data['listbtn']->btn->approvalnonaktif; ?>`,
              hidden: (!`{{ $myAuth->hasPermission('tariftangki', 'approvalnonaktif') }}`),
              onClick: () => {
                if (`{{ $myAuth->hasPermission('tariftangki', 'approvalnonaktif') }}`) {
                  approvalNonAktif('tariftangki')
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

    $('#rangeTglModal').on('shown.bs.modal', function() {


      initDatepicker()

      $('#formRangeTgl').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
      $('#formRangeTgl').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    })

    $('#formRangeTgl').submit(event => {
      event.preventDefault()

      let submitButton = $(this).find('button:submit')

      submitButton.attr('disabled', 'disabled')
      $('#processingLoader').removeClass('d-none')

      let dari = $('#formRangeTgl').find('[name=dari]').val()
      let sampai = $('#formRangeTgl').find('[name=sampai]').val()
      if ($('#formRangeTgl').data('action') == 'export') {
        $.ajax({
          url: `{{ route('tariftangki.export') }}?dari=${dari}&sampai=${sampai}`,
          type: 'GET',
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
                link.download = `LAPORAN TARIF TANGKI ${new Date().getTime()}.xlsx`;
                link.click();
              }
            }

            $('#processingLoader').addClass('d-none')

            submitButton.removeAttr('disabled')
          },
          error: function(xhr, status, error) {
            $('#processingLoader').addClass('d-none')

            submitButton.removeAttr('disabled')
            showDialog('TIDAK ADA DATA')
          }
        })
      } else {
        actionUrl = `{{ route('tariftangki.report') }}?dari=${dari}&sampai=${sampai}`
        window.open(actionUrl)
        submitButton.removeAttr('disabled')
        $('#processingLoader').addClass('d-none')
        $('#rangeTglModal').modal('hide')
      }
      /* Clear validation messages */
      $('.is-invalid').removeClass('is-invalid')
      $('.invalid-feedback').remove()

    })

    function getCekExport() {
      return new Promise((resolve, reject) => {
        $.ajax({
          url: `${apiUrl}tariftangki/getExport`,
          dataType: "JSON",
          headers: {
            Authorization: `Bearer ${accessToken}`
          },
          data: {
            dari: $('#formRangeTgl').find('[name=dari]').val(),
            sampai: $('#formRangeTgl').find('[name=sampai]').val(),
            cekExport: true
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

    function permission() {
      if (!`{{ $myAuth->hasPermission('tariftangki', 'store') }}`) {
        $('#add').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('tariftangki', 'update') }}`) {
        $('#edit').attr('disabled', 'disabled')
      }
      if (!`{{ $myAuth->hasPermission('tariftangki', 'destroy') }}`) {
        $('#delete').attr('disabled', 'disabled')
      }
      if (!`{{ $myAuth->hasPermission('tariftangki', 'export') }}`) {
        $('#export').attr('disabled', 'disabled')
      }
      if (!`{{ $myAuth->hasPermission('tariftangki', 'report') }}`) {
        $('#report').attr('disabled', 'disabled')
      }
      if (!`{{ $myAuth->hasPermission('tariftangki', 'import') }}`) {
        $('#import').attr('disabled', 'disabled')
      }

      let hakApporveCount = 0;

      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('tariftangki', 'approvalaktif') }}`) {
        hakApporveCount--
        $('#approvalaktif').hide()
      }
      hakApporveCount++
      if (!`{{ $myAuth->hasPermission('tariftangki', 'approvalnonaktif') }}`) {
        hakApporveCount--
        $('#approvalnonaktif').hide()
      }
      if (hakApporveCount < 1) {
        $('#approve').hide()
      }
    }

    $('#importModal').on('shown.bs.modal', function() {


      $('#formImport [name]:not(:hidden)').first().focus()

    })

  })

  const setTampilanIndex = function() {
    return new Promise((resolve, reject) => {
      let data = [];
      data.push({
        name: 'grp',
        value: 'UBAH TAMPILAN'
      })
      data.push({
        name: 'text',
        value: 'TARIF'
      })
      $.ajax({
        url: `${apiUrl}parameter/getparambytext`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: data,
        success: response => {
          memo = JSON.parse(response.memo)
          memo = memo.INPUT
          if (memo != '') {
            input = memo.split(',');
            input.forEach(field => {
              field = $.trim(field.toLowerCase());
              $(`.${field}`).hide()
              $("#jqGrid").jqGrid("hideCol", field);
            });
          }

        }
      })
    })
  }
</script>
@endpush()
@endsection