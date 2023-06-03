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
@include('upahsupir._detail')

@include('upahsupir._modal')

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
  let sortname = 'kotasampai_id'
  let sortorder = 'asc'
  let autoNumericElements = []
  let rowNum = 10
  let hasDetail = false

  $(document).ready(function() {
    $("#jqGrid").jqGrid({
        url: `${apiUrl}upahsupir`,
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
            label: 'PARENT',
            name: 'parent_id',
            align: 'left'
          },
          {
            label: 'DARI',
            name: 'kotadari_id',
            align: 'left'
          },
          {
            label: 'TUJUAN',
            name: 'kotasampai_id',
            align: 'left'
          },
          {
            label: 'JARAK',
            name: 'jarak',
            align: 'right',
          },
          {
            label: 'ZONA',
            name: 'zona_id',
            align: 'left'
          },
          {
            label: 'STATUS',
            name: 'statusaktif',
            stype: 'select',
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
                <div class="badge" style="background-color: ${statusAktif.WARNA}; color: #fff;">
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
            label: 'TGL MULAI BERLAKU',
            name: 'tglmulaiberlaku',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          
          {
            label: 'STATUS LUAR KOTA',
            name: 'statusluarkota',
            align: 'left',
            stype: 'select',
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['comboluarkota'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['comboluarkota'])) {
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
              let statusLuarKota = JSON.parse(value)

              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusLuarKota.WARNA}; color: #fff;">
                  <span>${statusLuarKota.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusLuarKota = JSON.parse(rowObject.statusluarkota)

              return ` title="${statusLuarKota.MEMO}"`
            }
          },
          {
            label: 'Keterangan',
            name: 'keterangan',
          },
          {
            label: 'MODIFIEDBY',
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
        buttons: [{
            id: 'add',
            innerHTML: '<i class="fa fa-plus"></i> ADD',
            class: 'btn btn-primary btn-sm mr-1',
            onClick: () => {
              createUpahSupir()
            }
          },
          {
            id: 'edit',
            innerHTML: '<i class="fa fa-pen"></i> EDIT',
            class: 'btn btn-success btn-sm mr-1',
            onClick: () => {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

              editUpahSupir(selectedId)
            }
          },
          {
            id: 'delete',
            innerHTML: '<i class="fa fa-trash"></i> DELETE',
            class: 'btn btn-danger btn-sm mr-1',
            onClick: () => {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

              deleteUpahSupir(selectedId)
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
              //   showDialog('Please select a row')
              // } else {
              //   window.open(`{{ route('upahsupir.export') }}?id=${selectedId}`)
              // }
              $('#rangeTglModal').find('button:submit').html(`Export`)
              $('#rangeTglModal').modal('show')
            }
          },  
          {
            id: 'report',
            innerHTML: '<i class="fa fa-print"></i> REPORT',
            class: 'btn btn-info btn-sm mr-1',
            onClick: () => {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Please select a row')
              } else {
                window.open(`{{ route('upahsupir.report') }}?id=${selectedId}`)
              }
            }
          },
          {
            id: 'import',
            innerHTML: '<i class="fas fa-file-upload"></i> UPDATE HARGA',
            class: 'btn btn-info btn-sm mr-1',
            onClick: () => {
              // $('#importModal').data('action', 'import')
              $('#importModal').find('button:submit').html(`Update Harga`)
              $('#importModal').modal('show')
            }
          },
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
      
    $('#importModal').on('shown.bs.modal', function() {
      $('#formImport [name]:not(:hidden)').first().focus()
    })

    $('#rangeTglModal').on('shown.bs.modal', function() {


    initDatepicker()

    $('#formRangeTgl').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
    $('#formRangeTgl').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    })

    $('#formRangeTgl').submit(event => {
    event.preventDefault()

    let actionUrl = `{{ route('upahsupir.export') }}`

    /* Clear validation messages */
    $('.is-invalid').removeClass('is-invalid')
    $('.invalid-feedback').remove()


    window.open(`${actionUrl}?${$('#formRangeTgl').serialize()}`)
})

    $('#btnImport').click(function(event) {
      event.preventDefault()

      let url = `${apiUrl}upahsupir/import`
      let form_data = new FormData(document.getElementById('formImport'))
      let form = $('#formImport')

      $(this).attr('disabled', '')
      $('#loader').removeClass('d-none')

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
          $('#formImport').trigger('reset')
          $('#importModal').modal('hide')
          $('#jqGrid').jqGrid().trigger('reloadGrid');

          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()
        },
        error: error => {
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            setErrorMessages(form, error.responseJSON.errors);
          } else {
            showDialog(error.statusText)
          }
        },
      }).always(() => {
        $('#loader').addClass('d-none')
        $(this).removeAttr('disabled')
      })
    })
    
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

    $('#formRange').submit(event => {
      event.preventDefault()

      let params
      let actionUrl = ``

      if ($('#rangeModal').data('action') == 'export') {
        actionUrl = `{{ route('upahsupir.export') }}`
      } else if ($('#rangeModal').data('action') == 'report') {
        actionUrl = `{{ route('upahsupir.report') }}`
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
  })
</script>
@endpush()
@endsection