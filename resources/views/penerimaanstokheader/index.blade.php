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

@include('penerimaanstokheader._modal')
<!-- Detail -->
@include('penerimaanstokheader._detail')

@push('scripts')
<script>
  let indexUrl = "{{ route('penerimaanstokheader.index') }}"
  let getUrl = "{{ route('penerimaanstokheader.get') }}"
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
  let parampostok


  $(document).ready(function() {





    $('#lookup').hide()

    $('.akunpusat-lookup').lookup({
      title: 'akun pusat Lookup',
      fileName: 'akunpusat',
      onSelectRow: (akunpusat, element) => {
        element.val(akunpusat.coa)
        $(`#${element[0]['name']}Id`).val(akunpusat.coa)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.penerimaanstok-lookup').lookup({
      title: 'penerimaan stok Lookup',
      fileName: 'penerimaanstok',
      onSelectRow: (penerimaanstok, element) => {
        $.ajax({
          url: `${apiUrl}parameter/combo`,
          method: 'GET',
          dataType: 'JSON',
          headers: {
            Authorization: `Bearer ${accessToken}`
          },
          data: {
            grp: 'po stok',
            subgrp: 'po stok'
          },
          success: response => {
            if (response.data[0].text==penerimaanstok.id) {
              tampilanpo();
            } else {
              tampilanall();
            }
          }
        })


        kodepenerimaan(penerimaanstok.statusformatid)
        element.val(penerimaanstok.kodepenerimaan)
        $(`#${element[0]['name']}Id`).val(penerimaanstok.id)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        element.data('currentValue', element.val())
      }

    })

    $('.supplier-lookup').lookup({
      title: 'supplier Lookup',
      fileName: 'supplier',
      onSelectRow: (supplier, element) => {
        element.val(supplier.namasupplier)
        $(`#${element[0]['name']}Id`).val(supplier.id)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.trado-lookup').lookup({
      title: 'Trado Lookup',
      fileName: 'trado',
      onSelectRow: (trado, element) => {
        element.val(trado.keterangan)
        $(`#${element[0]['name']}Id`).val(trado.id)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.gudang-lookup').lookup({
      title: 'Gudang Lookup',
      fileName: 'gudang',
      onSelectRow: (gudang, element) => {
        element.val(gudang.gudang)
        $(`#${element[0]['name']}Id`).val(gudang.id)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.penerimaanstokheader-lookup').lookup({
      title: 'penerimaan stok header Lookup',
      fileName: 'penerimaanstokheader',
      onSelectRow: (penerimaan, element) => {
        element.val(penerimaan.nobukti)
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.pengeluaranstokheader-lookup').lookup({
      title: 'pengeluaran stok header Lookup',
      fileName: 'pengeluaranstokheader',
      onSelectRow: (pengeluaran, element) => {
        element.val(pengeluaran.nobukti)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        element.data('currentValue', element.val())
      }
    })
    $('.hutang-lookup').lookup({
      title: 'hutang header Lookup',
      fileName: 'hutangheader',
      onSelectRow: (hutang, element) => {
        element.val(hutang.nobukti)
        element.data('currentValue', element.val())
      },
      onCancel: (element) => {
        element.val(element.data('currentValue'))
      },
      onClear: (element) => {
        element.val('')
        element.data('currentValue', element.val())
      }
    })

    $('#crudModal').on('hidden.bs.modal', function() {
      activeGrid = '#jqGrid'
    })

    $("#jqGrid").jqGrid({
        url: `{{ config('app.api_url') . 'penerimaanstokheader' }}`,
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
            label: 'PENERIMAAN Stok',
            name: 'penerimaanstok',
            align: 'left'
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
            align: 'left'
          },
          {
            label: 'Penerimaan nobukti',
            name: 'penerimaanstok_nobukti',
            align: 'left'
          },
          {
            label: 'Pengeluaran nobukti',
            name: 'pengeluaranstok_nobukti',
            align: 'left'
          },
          {
            label: 'Gudang',
            name: 'gudangs',
            align: 'left'
          },
          {
            label: 'Trado',
            name: 'trado',
            align: 'left'
          },
          {
            label: 'supplier',
            name: 'supplier',
            align: 'left'
          },
          {
            label: 'nobon',
            name: 'nobon',
            align: 'left'
          },
          {
            label: 'no bukti Hutang',
            name: 'hutang_nobukti',
            align: 'left'
          },
          {
            label: 'Status format',
            name: 'statusformat',
            align: 'left'
          },
          {
            label: 'gudang dari',
            name: 'gudangdari',
            align: 'left'
          },
          {
            label: 'gudang ke',
            name: 'gudangke',
            align: 'left'
          },
          {
            label: 'COA',
            name: 'coa',
            align: 'left'
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
          clearGlobalSearch($('#jqGrid'))
        },
      })

      .customPager({
        buttons: [{
            id: 'add',
            innerHTML: '<i class="fa fa-plus"></i> ADD',
            class: 'btn btn-primary btn-sm mr-1',
            onClick: function(event) {
              createPenerimaanstokHeader()
            }
          },
          {
            id: 'edit',
            innerHTML: '<i class="fa fa-pen"></i> EDIT',
            class: 'btn btn-success btn-sm mr-1',
            onClick: function(event) {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              editPenerimaanstokHeader(selectedId)
            }
          },
          {
            id: 'delete',
            innerHTML: '<i class="fa fa-trash"></i> DELETE',
            class: 'btn btn-danger btn-sm mr-1',
            onClick: () => {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              deletePenerimaanstokHeader(selectedId)
            }
          },
        ]

      })

    /* Append clear filter button */
    loadClearFilter($('#jqGrid'))

    /* Append global search */
    loadGlobalSearch($('#jqGrid'))

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

    if (!`{{ $myAuth->hasPermission('penerimaanstokheader', 'store') }}`) {
      $('#add').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('penerimaanstokheader', 'update') }}`) {
      $('#edit').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('penerimaanstokheader', 'destroy') }}`) {
      $('#delete').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('penerimaanstokheader', 'export') }}`) {
      $('#export').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('penerimaanstokheader', 'report') }}`) {
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
        xhr.open('GET', `{{ config('app.api_url') }}penerimaanstokheader/export?${params}`, true)
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
              link.download = `laporanpenerimaanStok${(new Date).getTime()}.xlsx`
              link.click()

              submitButton.removeAttr('disabled')
            }
          }
        }

        xhr.send()
      } else if ($('#rangeModal').data('action') == 'report') {
        window.open(`{{ route('penerimaanstokheader.report') }}?${params}`)

        submitButton.removeAttr('disabled')
      }
    })



  })
</script>
@endpush()
@endsection