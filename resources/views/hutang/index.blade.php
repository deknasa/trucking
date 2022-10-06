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
@include('hutang._detail')

@include('hutang._modal')

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

    $('#lookup').hide()

    $('.akunpusat-lookup').lookup({
      title: 'Akun Pusat Lookup',
      fileName: 'akunpusat',
      onSelectRow: (akunpusat, element) => {
        // $('#crudForm [name=akunpusat]').first().val(akunpusat.id)
        element.val(akunpusat.coa)
      }
    })

    $('.pelanggan-lookup').lookup({
      title: 'pelanggan Lookup',
      fileName: 'pelanggan',
      onSelectRow: (pelanggan, element) => {
        $('#crudForm [name=pelanggan_id]').first().val(pelanggan.id)
        element.val(pelanggan.namapelanggan)

      }
    })

    
    $('.supplier-lookup').lookup({
      title: 'supplier Lookup',
      fileName: 'supplier',
      onSelectRow: (supplier, element) => {
        $('#crudForm [name=supplier_id]').first().val(supplier.id)
        element.val(supplier.namasupplier)

      }
    })
   
    $('#crudModal').on('shown.bs.modal', function() {
      activeGrid = '#jqGrid'
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
            name: 'akunpusat',
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
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Please select a row')
              } else {
                editHutangHeader(selectedId)
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
                showDialog('Please select a row')
              } else {
                deleteHutangHeader(selectedId)
              }
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
  const getServiceOutLookup = function(fileName) {
    return new Promise((resolve, reject) => {
      $.ajax({
        url: `${appUrl}/lookup/${fileName}`,
        method: 'GET',
        dataType: 'html',
        success: function(response) {
          resolve(response)
        }
      })
    })
  }

  $.fn.lookup = function(options = null) {
    this.each(function() {
      let element = $(this)

      element
        .wrap('<div class="input-group"></div>')
        .after(`
          <div class="input-group-append">
            <button class="btn btn-primary lookup-toggler" type="button">...</button>
          </div>
        `)

      element.siblings('.input-group-append').find('.lookup-toggler').click(function() {
        activateLookup(element)
      })
    })

    function activateLookup(element) {
      let lookupModal = $(`
        <div class="modal fade modal-fullscreen" id="lookupModal" tabindex="-1" aria-labelledby="lookupModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <form action="#" id="crudForm">
              <div class="modal-content">
                <div class="modal-header bg-primary">
                  <h5 class="modal-title" id="lookupModalLabel">${options.title}</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body">
                </div>
              </div>
            </form>
          </div>
        </div>
      `)

      $('body').append(lookupModal)

      lookupModal.modal('show')

      getServiceOutLookup(options.fileName)
        .then(response => {
          lookupModal.find('.modal-body').html(response)

          grid = lookupModal.find('.lookup-grid')

          if (detectDeviceType() == 'desktop') {
            grid.jqGrid('setGridParam', {
              ondblClickRow: function(id) {
                let rowData = $(this).getRowData(id)
                handleSelectedRow(id, lookupModal, element)
              }
            })
          } else if (detectDeviceType() == 'mobile') {
            grid.jqGrid('setGridParam', {
              onSelectRow: function(id) {
                handleSelectedRow(id, lookupModal, element)
              }
            })
          }
        })

      lookupModal.on('hidden.bs.modal', function() {
        lookupModal.remove()
      })
    }

    function handleSelectedRow(id, lookupModal, element) {
      if (id !== null) {
        lookupModal.modal('hide')

        options.onSelectRow(sanitize(grid.getRowData(id)), element)
      } else {
        alert('Please select a row')
      }

    }

    
    function sanitize(rowData) {
      Object.keys(rowData).forEach(key => {
        rowData[key] = rowData[key].replaceAll('<span class="highlight">', '').replaceAll('</span>', '')
      })

      return rowData
    }

    return this

  }
</script>
@endpush()
@endsection