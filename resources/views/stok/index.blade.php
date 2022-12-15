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

@include('stok._modal')

@push('scripts')
<script>
  let indexUrl = "{{ route('stok.index') }}"
  let getUrl = "{{ route('stok.get') }}"
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
  let sortname = 'id'
  let sortorder = 'asc'
  let autoNumericElements = []

  $(document).ready(function() {

    $('#lookup').hide()
    
   
    

    $('#crudModal').on('hidden.bs.modal', function() {
       activeGrid = '#jqGrid'
     })

    $("#jqGrid").jqGrid({
      url: `{{ config('app.api_url') . 'stok' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      colModel: [{
        label: 'ID',
        name: 'id',
        align: 'right',
        width: '70px'
        
      },
      {
        label: 'NAMA',
        name: 'namastok',
        align: 'left',
      },
      {
          label: 'STATUS AKTIF',
          name: 'statusaktif',
          align: 'left',
      },
      {
          label: 'keterangan',
          name: 'keterangan',
          align: 'left',
      },
      {
          label: 'namaterpusat',
          name: 'namaterpusat',
          align: 'left',
      },
      {
        label: 'kelompok',
        name: 'kelompok',
        align: 'left'
      },
      {
        label: 'jenistrado',
        name: 'jenistrado',
        align: 'left'
      },
      {
        label: 'subkelompok',
        name: 'subkelompok',
        align: 'left'
      },
      {
        label: 'kategori',
        name: 'kategori',
        align: 'left'
      },
      {
        label: 'merk',
        name: 'merk',
        align: 'left'
      },
      
      {
          label: 'qty min',
          name: 'qtymin',
          align: 'left',
      },
      {
          label: 'qty max',
          name: 'qtymax',
          align: 'left',
      },
      
      {
          label: 'modifiedby',
          name: 'modifiedby',
          align: 'left',
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
          clearGlobalSearch($('#jqGrid'))
        },
      })

      .customPager({
        buttons: [{
            id: 'add',
            innerHTML: '<i class="fa fa-plus"></i> ADD',
            class: 'btn btn-primary btn-sm mr-1',
            onClick: function(event) {
              createStok()
            }
          },
          {
            id: 'edit',
            innerHTML: '<i class="fa fa-pen"></i> EDIT',
            class: 'btn btn-success btn-sm mr-1',
            onClick: function(event) {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              editStok(selectedId)
            }
          },
          {
            id: 'delete',
            innerHTML: '<i class="fa fa-trash"></i> DELETE',
            class: 'btn btn-danger btn-sm mr-1',
            onClick: () => {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              deleteStok(selectedId)
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

    if (!`{{ $myAuth->hasPermission('stok', 'store') }}`) {
      $('#add').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('stok', 'update') }}`) {
      $('#edit').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('stok', 'destroy') }}`) {
      $('#delete').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('stok', 'export') }}`) {
      $('#export').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('stok', 'report') }}`) {
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

    // $('#formRange').submit(function(event) {
    //   event.preventDefault()

    //   let params
    //   let submitButton = $(this).find('button:submit')

    //   submitButton.attr('disabled', 'disabled')

    //   /* Set params value */
    //   for (var key in postData) {
    //     if (params != "") {
    //       params += "&";
    //     }
    //     params += key + "=" + encodeURIComponent(postData[key]);
    //   }

    //   let formRange = $('#formRange')
    //   let offset = parseInt(formRange.find('[name=dari]').val()) - 1
    //   let limit = parseInt(formRange.find('[name=sampai]').val().replace('.', '')) - offset
    //   params += `&offset=${offset}&limit=${limit}`

    //   if ($('#rangeModal').data('action') == 'export') {
    //     let xhr = new XMLHttpRequest()
    //     xhr.open('GET', `{{ config('app.api_url') }}stok/export?${params}`, true)
    //     xhr.setRequestHeader("Authorization", `Bearer {{ session('access_token') }}`)
    //     xhr.responseType = 'arraybuffer'

    //     xhr.onload = function(e) {
    //       if (this.status === 200) {
    //         if (this.response !== undefined) {
    //           let blob = new Blob([this.response], {
    //             type: "application/vnd.ms-excel"
    //           })
    //           let link = document.createElement('a')

    //           link.href = window.URL.createObjectURL(blob)
    //           link.download = `laporanpengeluaranStok${(new Date).getTime()}.xlsx`
    //           link.click()

    //           submitButton.removeAttr('disabled')
    //         }
    //       }
    //     }

    //     xhr.send()
    //   } else if ($('#rangeModal').data('action') == 'report') {

    //     submitButton.removeAttr('disabled')
    //   }
    // })



  })
</script>
@endpush()
@endsection