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

@include('dataritasi._modal')

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
  let sortname = 'statusritasi'
  let sortorder = 'asc'
  let autoNumericElements = []
  let rowNum = 10

  $(document).ready(function() {
    $("#jqGrid").jqGrid({
        url: `${apiUrl}dataritasi`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        colModel: [{
            label: 'ID',
            name: 'id',
            align: 'right',
            width: '70px',
            search: false,
            hidden: true
          },
          {
            label: 'STATUS RITASI',
            name: 'statusritasi',
          },
          {
            label: 'NOMINAL',
            name: 'nominal',
            align: "right",
            formatter: currencyFormat,
          },
          // {
          //   label: 'KETERANGAN',
          //   name: 'keterangan',
          //   align: 'left'
          // },
          {
            label: 'Status',
            name: 'statusaktif',
            width: 100,
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
            label: 'MODIFIEDBY',
            name: 'modifiedby',
            align: 'left'
          },
          {
            label: 'UPDATEDAT',
            name: 'updated_at',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y H:i:s"
            }
          }, {
            label: 'CREATEDAT',
            name: 'created_at',
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

          setHighlight($(this))
        }
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
            onClick: () => {
              createDataRitasi()
            }
          },
          {
            id: 'edit',
            innerHTML: '<i class="fa fa-pen"></i> EDIT',
            class: 'btn btn-success btn-sm mr-1',
            onClick: () => {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              console.log(selectedId)
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Harap pilih salah satu record')
              } else {
                editDataRitasi(selectedId)
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
                deleteDataRitasi(selectedId)
              }
            }
          },
          {
            id: 'report',
            innerHTML: '<i class="fa fa-print"></i> REPORT',
            class: 'btn btn-info btn-sm mr-1',
            onClick: () => {
              $('#rangeModal').data('action', 'report')
              $('#rangeModal').find('button:submit').html(`Report`)
              $('#rangeModal').modal('show')
            }
          },
          {
            id: 'export',
            innerHTML: '<i class="fa fa-file-export"></i> EXPORT',
            class: 'btn btn-warning btn-sm mr-1',
            onClick: () => {
              $('#rangeModal').data('action', 'export')
              $('#rangeModal').find('button:submit').html(`Export`)
              $('#rangeModal').modal('show')
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


    if (!`{{ $myAuth->hasPermission('container', 'store') }}`) {
      $('#add').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('container', 'update') }}`) {
      $('#edit').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('container', 'destroy') }}`) {
      $('#delete').attr('disabled', 'disabled')
    }
    if (!`{{ $myAuth->hasPermission('container', 'export') }}`) {
      $('#export').attr('disabled', 'disabled')
    }
    if (!`{{ $myAuth->hasPermission('container', 'report') }}`) {
      $('#report').attr('disabled', 'disabled')
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
      if (page == 0) {
        $('#formRange [name=dari]').val(page)
        $('#formRange [name=sampai]').val(totalRecord)
      }else{
        $('#formRange [name=dari]').val((indexRow + 1) + (limit * (page - 1)))
        $('#formRange [name=sampai]').val(totalRecord)
      }

      autoNumericElements = new AutoNumeric.multiple('#formRange .autonumeric-report', {
        digitGroupSeparator: '.',
        decimalCharacter: ',',
        allowDecimalPadding: false,
        minimumValue: 0,
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

      // window.open(`${actionUrl}?${$('#formRange').serialize()}&${params}`)
      let formRange = $('#formRange')
      let offset = parseInt(formRange.find('[name=dari]').val()) - 1
      let limit = parseInt(formRange.find('[name=sampai]').val().replace('.', '')) - offset
      params += `&offset=${offset}&limit=${limit}`

      getCekExport(params).then((response) => {
        if ($('#rangeModal').data('action') == 'export') {
          let xhr = new XMLHttpRequest()
          xhr.open('GET', `{{ config('app.api_url') }}dataritasi/export?${params}`, true)
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
                link.download = `laporanDataRitasi${(new Date).getTime()}.xlsx`
                link.click()

                submitButton.removeAttr('disabled')
              }
            }
          }

          xhr.onerror = () => {
            submitButton.removeAttr('disabled')
          }

          xhr.send()
        } else if ($('#rangeModal').data('action') == 'report') {
        
          window.open(`{{ route('dataritasi.report') }}?${params}`)

          submitButton.removeAttr('disabled')
        }
      }).catch((error) => {
        if (error.status === 422) {
          $('.is-invalid').removeClass('is-invalid')
          $('.invalid-feedback').remove()
          errors = error.responseJSON.errors

          $.each(errors, (index, error) => {
            let indexes = index.split(".");
            indexes[0] = 'sampai'
            let element;
            element = $('#rangeModal').find(`[name="${indexes[0]}"]`)[0];

            $(element).addClass("is-invalid");
            $(`
              <div class="invalid-feedback">
              ${error[0].toLowerCase()}
              </div>
			    `).appendTo($(element).parent());

          });

          $(".is-invalid").first().focus();
        } else {
          showDialog(error.statusText)
        }
      })
      
      .finally(() => {
        $('.ui-button').click()
        
        submitButton.removeAttr('disabled')
      })
    })
    function getCekExport(params) {
      
      params += `&cekExport=true`

      return new Promise((resolve, reject) => {
        $.ajax({
          url: `${apiUrl}dataritasi/export?${params}`,
          dataType: "JSON",
          headers: {
            Authorization: `Bearer ${accessToken}`
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

    })
    
</script>
@endpush()
@endsection