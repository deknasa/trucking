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

@include('tarif._detail')

@include('tarif._modal')

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

  $(document).ready(function() {

    setTampilanIndex()
    $("#jqGrid").jqGrid({
        url: `${apiUrl}tarif`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        colModel: [{
            label: 'ID',
            name: 'id',
            width: '50px',
            search: false,
            hidden: true
          },
          {
            label: 'PARENT',
            name: 'parent_id',
          },
          {
            label: 'TUJUAN',
            name: 'tujuan',
          },
          {
            label: 'PENYESUAIAN',
            name: 'penyesuaian',
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
            label: 'SISTEM TON',
            name: 'statussistemton',
            stype: 'select',
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['comboton'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['comboton'])) {
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
              let statusSistemton = JSON.parse(value)

              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusSistemton.WARNA}; color: ${statusSistemton.WARNATULISAN};">
                  <span>${statusSistemton.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusSistemton = JSON.parse(rowObject.statussistemton)

              return ` title="${statusSistemton.MEMO}"`
            }
          },
          {
            label: 'KOTA',
            name: 'kota_id',
          },
          {
            label: 'ZONA',
            name: 'zona_id',
          },
          {
            label: 'JENIS ORDER',
            name: 'jenisorder',
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
            label: 'STATUS PENYESUAIAN HARGA',
            name: 'statuspenyesuaianharga',
            width: 230,
            stype: 'select',
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['combopenyesuaianharga'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['combopenyesuaianharga'])) {
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
              let statusPenyesuaianharga = JSON.parse(value)

              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusPenyesuaianharga.WARNA}; color: ${statusPenyesuaianharga.WARNATULISAN};">
                  <span>${statusPenyesuaianharga.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusPenyesuaianharga = JSON.parse(rowObject.statuspenyesuaianharga)

              return ` title="${statusPenyesuaianharga.MEMO}"`
            }
          },
          {
            label: 'STATUS POSTING TNL',
            name: 'statuspostingtnl',
            width: 230,
            stype: 'select',
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['combopostingtnl'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['combopostingtnl'])) {
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
              let statusPostingTnl = JSON.parse(value)
              if (!statusPostingTnl) {
                return ''
              }

              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusPostingTnl.WARNA}; color: #fff;">
                  <span>${statusPostingTnl.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusPostingTnl = JSON.parse(rowObject.statuspostingtnl)
              if (!statusPostingTnl) {
                return ` title=""`
              }
              return ` title="${statusPostingTnl.MEMO}"`
            }
          },
          {
            label: 'Keterangan',
            name: 'keterangan',
          },
          {
            label: 'MODIFIED BY',
            name: 'modifiedby',
          },
          {
            label: 'CREATED AT',
            name: 'created_at',
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
            class: 'btn btn-primary btn-sm mr-1',
            onClick: () => {
              createTarif()
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
              viewTarif(selectedId)
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
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Harap pilih salah satu record')
              } else {
                window.open(`{{ route('tarif.report') }}?id=${selectedId}`)
              }
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
              $('#rangeTglModal').find('button:submit').html(`Export`)
              $('#rangeTglModal').modal('show')
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

    $('#rangeTglModal').on('shown.bs.modal', function() {


      initDatepicker()

      $('#formRangeTgl').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
      $('#formRangeTgl').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

    })

    $('#formRangeTgl').submit(event => {
      event.preventDefault()

      getCekExport()
        .then((response) => {
          let actionUrl = `{{ route('tarif.export') }}`

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
          url: `${apiUrl}tarif/listpivot`,
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

    function permission() {
      if (!`{{ $myAuth->hasPermission('tarif', 'store') }}`) {
        $('#add').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('tarif', 'update') }}`) {
        $('#edit').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('tarif', 'show') }}`) {
        $('#view').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('tarif', 'destroy') }}`) {
        $('#delete').attr('disabled', 'disabled')
      }
      if (!`{{ $myAuth->hasPermission('tarif', 'export') }}`) {
        $('#export').attr('disabled', 'disabled')
      }
      if (!`{{ $myAuth->hasPermission('tarif', 'report') }}`) {
        $('#report').attr('disabled', 'disabled')
      }
    }

    $('#importModal').on('shown.bs.modal', function() {


      $('#formImport [name]:not(:hidden)').first().focus()

    })

    $('#btnImport').click(function(event) {
      event.preventDefault()

      let url = `${apiUrl}tarif/import`
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
            showDialog(error.statusText)
          }
        },
      }).always(() => {
        $('#processingLoader').addClass('d-none')
        $(this).removeAttr('disabled')
      })
    })
    // $('#rangeModal').on('shown.bs.modal', function() {
    //   if (autoNumericElements.length > 0) {
    //     $.each(autoNumericElements, (index, autoNumericElement) => {
    //       autoNumericElement.remove()
    //     })
    //   }

    //   $('#formRange [name]:not(:hidden)').first().focus()

    //   $('#formRange [name=sidx]').val($('#jqGrid').jqGrid('getGridParam').postData.sidx)
    //   $('#formRange [name=sord]').val($('#jqGrid').jqGrid('getGridParam').postData.sord)
    //   if (page == 0) {
    //     $('#formRange [name=dari]').val(page)
    //     $('#formRange [name=sampai]').val(totalRecord)
    //   }else{
    //     $('#formRange [name=dari]').val((indexRow + 1) + (limit * (page - 1)))
    //     $('#formRange [name=sampai]').val(totalRecord)
    //   }

    //   autoNumericElements = new AutoNumeric.multiple('#formRange .autonumeric-report', {
    //     digitGroupSeparator: '.',
    //     decimalCharacter: ',',
    //     allowDecimalPadding: false,
    //     minimumValue: 0,
    //     maximumValue: totalRecord
    //   })
    // })

    // $('#formRange').submit(event => {
    //   event.preventDefault()

    //   let params
    //   let actionUrl = ``

    //   /* Clear validation messages */
    //   $('.is-invalid').removeClass('is-invalid')
    //   $('.invalid-feedback').remove()

    //   /* Set params value */
    //   for (var key in postData) {
    //     if (params != "") {
    //       params += "&";
    //     }
    //     params += key + "=" + encodeURIComponent(postData[key]);
    //   }

    //   // window.open(`${actionUrl}?${$('#formRange').serialize()}&${params}`)
    //   let formRange = $('#formRange')
    //   let offset = parseInt(formRange.find('[name=dari]').val()) - 1
    //   let limit = parseInt(formRange.find('[name=sampai]').val().replace('.', '')) - offset
    //   params += `&offset=${offset}&limit=${limit}`

    //   if ($('#rangeModal').data('action') == 'export') {
    //     let xhr = new XMLHttpRequest()
    //     xhr.open('GET', `{{ config('app.api_url') }}tarif/export?${params}`, true)
    //     xhr.setRequestHeader("Authorization", `Bearer ${accessToken}`)
    //     xhr.responseType = 'arraybuffer'


    //     xhr.onload = function(e) {
    //       if (this.status === 200) {
    //         if (this.response !== undefined) {
    //           let blob = new Blob([this.response], {
    //             type: "application/vnd.ms-excel"
    //           })
    //           let link = document.createElement('a')

    //           link.href = window.URL.createObjectURL(blob)
    //           link.download = `laporanTarif${(new Date).getTime()}.xlsx`
    //           link.click()

    //           submitButton.removeAttr('disabled')
    //         }
    //       }
    //     }

    //     xhr.onerror = () => {
    //       submitButton.removeAttr('disabled')
    //     }

    //     xhr.send()
    //   } else if ($('#rangeModal').data('action') == 'report') {

    //     window.open(`{{ route('tarif.report') }}?${params}`)

    //     submitButton.removeAttr('disabled')
    //   }
    // })
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