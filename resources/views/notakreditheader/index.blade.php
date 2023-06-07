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
  <div class="row mt-3">
    <div class="col-12">
      <div class="card card-primary card-outline card-outline-tabs">
        <div class="card-body border-bottom-0">
          <div id="tabs">
            <ul class="dejavu">
              <li><a href="#detail-tab">Details</a></li>
              <li><a href="#pelunasan-tab">Pelunasan piutang</a></li>
              <li><a href="#penerimaan-tab">Penerimaan Kas/bank</a></li>
              <li><a href="#jurnal-tab">Jurnal</a></li>
            </ul>
            <div id="detail-tab"></div>
            <div id="pelunasan-tab"></div>
            <div id="penerimaan-tab"></div>
            <div id="jurnal-tab"> </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@include('notakreditheader._modal')
<!-- Detail -->
@include('notakreditheader._detail')

@push('scripts')
<script>
  let indexUrl = "{{ route('notakreditheader.index') }}"
  let getUrl = "{{ route('notakreditheader.get') }}"
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
  let selectedRows = [];
  let currentTab = 'detail'

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

  $(document).ready(function() {
    $("#tabs").tabs()

    setRange()
    initDatepicker()
    $(document).on('click', '#btnReload', function(event) {
      loadDataHeader('notakreditheader')
      selectedRows = []
      $('#gs_').prop('checked', false)
    })


    $("#jqGrid").jqGrid({
        url: `{{ config('app.api_url') . 'notakreditheader' }}`,
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
                  if ($(this).is(':checked')) {
                    selectAllRows()
                  } else {
                    clearSelectedRows()
                  }
                })

              }
            },
            formatter: (value, rowOptions, rowData) => {
              return `<input type="checkbox" name="kreditId[]" value="${rowData.id}" onchange="checkboxHandler(this)">`
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
            label: 'status approval',
            name: 'statusapproval_memo',
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
                return ``
              }
              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusApproval.WARNA}; color: #fff;">
                  <span>${statusApproval.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusApproval = JSON.parse(rowObject.statusapproval_memo)
              if (!statusApproval) {
                return ` title=""`
              }
              return ` title="${statusApproval.MEMO}"`
            }
          },
          {
            label: 'STATUS CETAK',
            name: 'statuscetak_memo',
            align: 'left',
            stype: 'select',
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['combocetak'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['combocetak'])) {
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
              let statusCetak = JSON.parse(value)
              if (!statusCetak) {
                return ``
              }
              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusCetak.WARNA}; color: #fff;">
                  <span>${statusCetak.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusCetak = JSON.parse(rowObject.statuscetak_memo)
              if (!statusCetak) {
                return ` title=""`
              }
              return ` title="${statusCetak.MEMO}"`
            }
          },
          {
            label: 'NO. BUKTI',
            name: 'nobukti',
            align: 'left'
          },
          {
            label: 'TGL BUKTI',
            name: 'tglbukti',
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'tgl lunas',
            name: 'tgllunas',
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'NO BUKTI PELUNASAN PIUTANG',
            name: 'pelunasanpiutang_nobukti',
            align: 'left'
          },
          {
            label: 'user approval',
            name: 'userapproval',
            align: 'left'
          },
          {
            label: 'TGL APPROVAL',
            name: 'tglapproval',
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'user buka cetak',
            name: 'userbukacetak',
            align: 'left'
          },
          {
            label: 'TANGGAL buka cetak',
            name: 'tglbukacetak',
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'posting dari',
            name: 'postingdari',
            align: 'left'
          },
          {
            label: 'penerimaan_nobukti',
            name: 'penerimaan_nobukti',
            align: 'left',
            hidden: true,
            search: false
          },
          {
            label: 'modifiedby',
            name: 'modifiedby',
            align: 'left'
          },
          {
            label: 'CREATEDAT',
            name: 'created_at',
            align: 'right',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y H:i:s"
            }
          },
          {
            label: 'UPDATEDAT',
            name: 'updated_at',
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
          let nobukti_pelunasan = $('#jqGrid').jqGrid('getCell', id, 'pelunasanpiutang_nobukti')
          let nobukti_penerimaan = $('#jqGrid').jqGrid('getCell', id, 'penerimaan_nobukti')

          $(`#tabs #${currentTab}-tab`).html('').load(`${appUrl}/notakreditdetail/${currentTab}/grid`, function() {
            if (currentTab == 'detail' || currentTab == 'pelunasan') {
              loadGrid(id, nobukti_pelunasan)
            } else {
              loadGrid(id, nobukti_penerimaan)
            }
          })
          loadDetailData(id)
          activeGrid = $(this)
          indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
          page = $(this).jqGrid('getGridParam', 'page')
          let limit = $(this).jqGrid('getGridParam', 'postData').limit
          if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))
        },
        loadComplete: function(data) {
          changeJqGridRowListText()
          if (data.data.length == 0) {
            $('#detail').jqGrid('setGridParam', {
              postData: {
                notakredit_id: 0,
              },
            }).trigger('reloadGrid');
            $('#jurnalGrid').jqGrid('setGridParam', {
              postData: {
                nobukti: 0,
              },
            }).trigger('reloadGrid');
            $('#penerimaanGrid').jqGrid('setGridParam', {
              postData: {
                nobukti: 0,
              },
            }).trigger('reloadGrid');
            $('#pelunasanGrid').jqGrid('setGridParam', {
              postData: {
                nobukti: 0,
              },
            }).trigger('reloadGrid');
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
          
          clearGlobalSearch($('#jqGrid'))
        },
      })

      .customPager({
        buttons: [
          // {
          //   id: 'add',
          //   innerHTML: '<i class="fa fa-plus"></i> ADD',
          //   class: 'btn btn-primary btn-sm mr-1',
          //   onClick: function(event) {
          //     createNotaKredit()
          //   }
          // },
          // {
          //   id: 'edit',
          //   innerHTML: '<i class="fa fa-pen"></i> EDIT',
          //   class: 'btn btn-success btn-sm mr-1',
          //   onClick: function(event) {
          //     selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
          //     if (selectedId == null || selectedId == '' || selectedId == undefined) {
          //       showDialog('Please select a row')
          //     } else {
          //       cekValidasi(selectedId, 'EDIT')
          //     }
          //   }
          // },
          // {
          //   id: 'delete',
          //   innerHTML: '<i class="fa fa-trash"></i> DELETE',
          //   class: 'btn btn-danger btn-sm mr-1',
          //   onClick: () => {
          //     selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
          //     if (selectedId == null || selectedId == '' || selectedId == undefined) {
          //       showDialog('Please select a row')
          //     } else {
          //       cekValidasi(selectedId, 'DELETE')
          //     }
          //   }
          // },
          
          {
            id: 'report',
            innerHTML: '<i class="fa fa-print"></i> REPORT',
            class: 'btn btn-info btn-sm mr-1',
            onClick: () => {

              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Please select a row')
              } else {
                window.open(`{{ route('notakreditheader.report') }}?id=${selectedId}`)
              }
              clearSelectedRows()
              $('#gs_').prop('checked', false)
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
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Please select a row')
              } else {
                window.open(`{{ route('notakreditheader.report') }}?id=${selectedId}`)
              }
              clearSelectedRows()
              $('#gs_').prop('checked', false)
            }
          },
          {
            id: 'approveun',
            innerHTML: '<i class="fas fa-check""></i> UN/APPROVAL',
            class: 'btn btn-purple btn-sm mr-1',
            onClick: () => {

              approve()

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

    $('#approval .ui-pg-div')
      .addClass('btn btn-sm btn-warning')
      .parent().addClass('px-1')

    if (!`{{ $myAuth->hasPermission('notakreditheader', 'store') }}`) {
      $('#add').addClass('ui-disabled')
    }

    if (!`{{ $myAuth->hasPermission('notakreditheader', 'update') }}`) {
      $('#edit').addClass('ui-disabled')
    }

    if (!`{{ $myAuth->hasPermission('notakreditheader', 'destroy') }}`) {
      $('#delete').addClass('ui-disabled')
    }

    if (!`{{ $myAuth->hasPermission('notakreditheader', 'export') }}`) {
      $('#export').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('notakreditheader', 'report') }}`) {
      $('#report').attr('disabled', 'disabled')
    }
    if (!`{{ $myAuth->hasPermission('notakreditheader', 'approval') }}`) {
      $('#approveun').attr('disabled', 'disabled')
      $("#jqGrid").hideCol("");
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
        digitGroupSeparator: '.',
        decimalCharacter: ',',
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

      window.open(`${actionUrl}?${$('#formRange').serialize()}&${params}`)
    })

    function handleApproval(id) {
      $.ajax({
        url: `${apiUrl}notakreditheader/${id}/approval`,
        method: 'POST',
        dataType: 'JSON',
        beforeSend: request => {
          request.setRequestHeader('Authorization', `Bearer ${accessToken}`)
        },
        success: response => {
          $('#jqGrid').trigger('reloadGrid')
        }
      }).always(() => {
        $('#processingLoader').addClass('d-none')
      })
    }

    $("#tabs").on('click', 'li.ui-state-active', function() {
      let href = $(this).find('a').attr('href');
      currentTab = href.substring(1, href.length - 4);
      let notaId = $('#jqGrid').jqGrid('getGridParam', 'selrow')
      let nobukti_pelunasan = $('#jqGrid').jqGrid('getCell', notaId, 'pelunasanpiutang_nobukti')
      let nobukti_penerimaan = $('#jqGrid').jqGrid('getCell', notaId, 'penerimaan_nobukti')
      $(`#tabs #${currentTab}-tab`).html('').load(`${appUrl}/notakreditdetail/${currentTab}/grid`, function() {
        if (currentTab == 'detail' || currentTab == 'pelunasan') {
          loadGrid(notaId, nobukti_pelunasan)
        } else {
          loadGrid(notaId, nobukti_penerimaan)
        }
      })
    })
  })
  
  function clearSelectedRows() {
    selectedRows = []

    $('#jqGrid').trigger('reloadGrid')
  }

  function selectAllRows() {
    $.ajax({
      url: `${apiUrl}notakreditheader`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        limit: 0,
        tgldari: $('#tgldariheader').val(),
        tglsampai: $('#tglsampaiheader').val(),
      },
      success: (response) => {
        selectedRows = response.data.map((row) => row.id)
        $('#jqGrid').trigger('reloadGrid')
      }
    })
  }
</script>
@endpush()
@endsection