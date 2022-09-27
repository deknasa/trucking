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

@include('hutang._modal')
<!-- Detail -->
@include('hutang._detail')

@push('scripts')
<script>
  let indexUrl = "{{ route('hutangheader.index') }}"
  let getUrl = "{{ route('hutangheader.get') }}"
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
    $('#lookupAkunPusat').hide()
    $('#lookupSupplier').hide()
    $('#lookupPelanggan').hide()


    $('#crudModal').on('shown.bs.modal', function() {
      akunPusatLookup.setGridWidth($('#lookupAkunPusat').prev().width())
      supplierLookup.setGridWidth($('#lookupSupplier').prev().width())
      pelangganLookup.setGridWidth($('#lookupPelanggan').prev().width())


      if (detectDeviceType() == 'desktop') {

        akunPusatLookup.setGridParam({
          ondblClickRow: function(id) {
            let rowData = $(this).getRowData(id)
            console.log(rowData.coa)

            $('#crudForm [name=akunpusat]').first().val(rowData.coa)
            $('#lookupAkunPusat').hide()

            $('#lookupSupplierToggler').show()
            $('#lookupPelangganToggler').show()

          }
        })

        pelangganLookup.setGridParam({
          ondblClickRow: function(id) {
            let rowData = $(this).getRowData(id)
            console.log(rowData)

            $('#crudForm [name=pelanggan_id]').first().val(rowData.id)
            $('#crudForm [name=pelanggan]').first().val(rowData.kodepelanggan)
            $('#lookupPelanggan').hide()

            //$('#lookupAkunPusatToggler').show()
            $('#lookupSupplierToggler').show()
          }
        })

        supplierLookup.setGridParam({
          ondblClickRow: function(id) {
            let rowData = $(this).getRowData(id)
            console.log(rowData)

            $('#crudForm [name=supplier_id]').first().val(rowData.id)
            $('#crudForm [name=supplier]').first().val(rowData.namasupplier)
            $('#lookupSupplier').hide()
            console.log( $('#crudForm [name=supplier_id]').first().val())
          }
        })

      } else if (detectDeviceType() == 'mobile') {

        akunPusatLookup.setGridParam({
          onSelectRow: function(id) {
            let rowData = $(this).getRowData(id)

            $('#crudForm [name=akunpusat]').first().val(rowData.coa)
            $('#lookupAkunPusat').hide()
          }
        })

        pelangganLookup.setGridParam({
          onSelectRow: function(id) {
            let rowData = $(this).getRowData(id)

            $('#crudForm [name=pelanggan]').first().val(rowData.namapelanggan)
            // $('#crudForm [name=user_id]').first().val(id)
            $('#lookupPelanggan').hide()
          }
        })

        supplierLookup.setGridParam({
          onSelectRow: function(id) {
            let rowData = $(this).getRowData(id)

            $('#crudForm [name=supplier_id]').first().val(rowData.namasupplier)
            // $('#crudForm [name=user_id]').first().val(id)
            $('#lookupSupplier').hide()
          }
        })
      }

      $('#crudModal').find("[name]:not(:hidden, [readonly], [disabled], .disabled), button:submit").first().focus()

    })

    $('#crudModal').on('hidden.bs.modal', function() {
      activeGrid = '#jqGrid'
    })

    //tampil lookup ketika klik toggler
    $('#lookupAkunPusatToggler').click(function(event) {
      akunPusatLookup.setGridWidth($('#lookupAkunPusat').prev().width())
      $('#lookupAkunPusat').toggle()
      $('#lookupSupplier').hide()
      $('#lookupSupplierToggler').hide()

      if (detectDeviceType() != 'desktop') {
        akunPusatLookup.setGridHeight(window.innerHeight / 1.5)
      }

      if (detectDeviceType() == 'desktop') {
        activeGrid = akunPusatLookup
      }
    })

    $('#lookupPelangganToggler').click(function(event) {
      pelangganLookup.setGridWidth($('#lookupPelanggan').prev().width())
      $('#lookupPelanggan').toggle()

      $('#lookupAkunPusat').hide()
      $('#lookupSupplier').hide()

      $('#lookupAkunPusatToggler').hide()
      $('#lookupSupplierToggler').hide()

      if (detectDeviceType() != 'desktop') {
        pelangganLookup.setGridHeight(window.innerHeight / 1.5)
      }

      if (detectDeviceType() == 'desktop') {
        activeGrid = pelangganLookup
      }
    })

    $('#lookupSupplierToggler').click(function(event) {
      supplierLookup.setGridWidth($('#lookupSupplier').prev().width())
      $('#lookupSupplier').toggle()
      $('#lookupAkunPusat').hide()

      if (detectDeviceType() != 'desktop') {
        supplierLookup.setGridHeight(window.innerHeight / 1.5)
      }

      if (detectDeviceType() == 'desktop') {
        activeGrid = supplierLookup
      }
    })

   

    //untuk auto search dari kolom input
    $('[name=coa]').on('input', function(event) {
      $('#lookupAkunPusat').show()

      if (detectDeviceType() != 'desktop') {
        akunPusatLookup.setGridHeight(window.innerHeight / 1.5)
      }

      delay(() => {
        let postData = akunPusatLookup.getGridParam('postData')
        let colModels = akunPusatLookup.getGridParam('colModel')
        let rules = []

        colModels = colModels.filter((colModel) => {
          return colModel.name !== 'rn'
        })

        colModels.forEach(colModel => {
          rules.push({
            field: colModel.name,
            op: 'cn',
            data: $(this).val()
          })
        });

        postData.filters = JSON.stringify({
          groupOp: 'OR',
          rules: rules
        })

        akunPusatLookup.trigger('reloadGrid', {
          page: 1
        })
      }, 500)
    })

    $('[name=pelanggan]').on('input', function(event) {
      $('#lookupPelanggan').show()

      if (detectDeviceType() != 'desktop') {
        pelangganLookup.setGridHeight(window.innerHeight / 1.5)
      }

      delay(() => {
        let postData = pelangganLookup.getGridParam('postData')
        let colModels = pelangganLookup.getGridParam('colModel')
        let rules = []

        colModels = colModels.filter((colModel) => {
          return colModel.name !== 'rn'
        })

        colModels.forEach(colModel => {
          rules.push({
            field: colModel.name,
            op: 'cn',
            data: $(this).val()
          })
        });

        postData.filters = JSON.stringify({
          groupOp: 'OR',
          rules: rules
        })

        pelangganLookup.trigger('reloadGrid', {
          page: 1
        })
      }, 500)
    })


    $('[name=supplier_id]').on('input', function(event) {
      $('#lookupSupplier').show()

      if (detectDeviceType() != 'desktop') {
        supplierLookup.setGridHeight(window.innerHeight / 1.5)
      }

      delay(() => {
        let postData = supplierLookup.getGridParam('postData')
        let colModels = supplierLookup.getGridParam('colModel')
        let rules = []

        colModels = colModels.filter((colModel) => {
          return colModel.name !== 'rn'
        })

        colModels.forEach(colModel => {
          rules.push({
            field: colModel.name,
            op: 'cn',
            data: $(this).val()
          })
        });

        postData.filters = JSON.stringify({
          groupOp: 'OR',
          rules: rules
        })

        supplierLookup.trigger('reloadGrid', {
          page: 1
        })
      }, 500)
    })

    $("#jqGrid").jqGrid({
        url: `{{ config('app.api_url') . 'hutangheader' }}`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        colModel: [{
            label: 'ID',
            name: 'id',
            align: 'right',
            width: '50px'
          },
          {
            label: 'NO BUKTI',
            name: 'nobukti',
            align: 'left'
          },
          {
            label: 'TANGGAL BUKTI',
            name: 'tglbukti',
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
            align: 'left'
          },
          {
            label: 'COA',
            name: 'coa',
            align: 'left'
          },
          {
            label: 'PELANGGAN',
            name: 'pelanggan_id',
            align: 'left'
          },
          // {
          //   label: 'TOTAL',
          //   name: 'total',
          //   align: 'left'
          // },
          {
            label: 'MODIFIEDBY',
            name: 'modifiedby',
            align: 'left'
          },
          {
            label: 'UPDATEDAT',
            name: 'updated_at',
            align: 'left',
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
        rowList: [10, 20, 50],
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
        loadBeforeSend: (jqXHR) => {
          jqXHR.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
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
            clearColumnSearch()
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

      .jqGrid('filterToolbar', {
        stringResult: true,
        searchOnEnter: false,
        defaultSearch: 'cn',
        groupOp: 'AND',
        disabledKeys: [17, 33, 34, 35, 36, 37, 38, 39, 40],
        beforeSearch: function() {
          clearGlobalSearch()
        },
      })
      .customPager({
        buttons: [{
            id: 'add',
            innerHTML: '<i class="fa fa-plus"></i> ADD',
            class: 'btn btn-primary btn-sm mr-1',
            onClick: function(event) {
              createHutangHeader()
            }
          },
          {
            id: 'edit',
            innerHTML: '<i class="fa fa-pen"></i> EDIT',
            class: 'btn btn-success btn-sm mr-1',
            onClick: function(event) {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              editHutangHeader(selectedId)
            }
          },
          {
            id: 'delete',
            innerHTML: '<i class="fa fa-trash"></i> DELETE',
            class: 'btn btn-danger btn-sm mr-1',
            onClick: () => {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              deleteHutangHeader(selectedId)
            }
          },
        ]

      })
    /* Append clear filter button */
    loadClearFilter()

    /* Append global search */
    loadGlobalSearch()

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

    if (!`{{ $myAuth->hasPermission('hutangheader', 'store') }}`) {
      $('#add').addClass('ui-disabled')
    }

    if (!`{{ $myAuth->hasPermission('hutangheader', 'update') }}`) {
      $('#edit').addClass('ui-disabled')
    }

    if (!`{{ $myAuth->hasPermission('hutangheader', 'destroy') }}`) {
      $('#delete').addClass('ui-disabled')
    }

    if (!`{{ $myAuth->hasPermission('hutangheader', 'export') }}`) {
      $('#export').addClass('ui-disabled')
    }

    if (!`{{ $myAuth->hasPermission('hutangheader', 'report') }}`) {
      $('#report').addClass('ui-disabled')
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

      let formRange = $('#formRange')
      let offset = parseInt(formRange.find('[name=dari]').val()) - 1
      let limit = parseInt(formRange.find('[name=sampai]').val().replace('.', '')) - offset
      params += `&offset=${offset}&limit=${limit}`

      if ($('#rangeModal').data('action') == 'export') {
        let xhr = new XMLHttpRequest()
        xhr.open('GET', `{{ config('app.api_url') }}hutangheader/export?${params}`, true)
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
              link.download = `laporanhutang${(new Date).getTime()}.xlsx`
              link.click()

              submitButton.removeAttr('disabled')
            }
          }
        }

        xhr.send()
      } else if ($('#rangeModal').data('action') == 'report') {
        window.open(`{{ route('hutangheader.report') }}?${params}`)

        submitButton.removeAttr('disabled')
      }
    })
  })
</script>
@endpush()
@endsection