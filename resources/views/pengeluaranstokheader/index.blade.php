@extends('layouts.master')
@push('addtional-field')
<div class="form-group row">
  <label class="col-12 col-sm-2 col-form-label mt-2">pengeluaran stok</label>
  <div class="col-sm-4 mt-2">
    <select name="kodepengeluaranheader" id="kodepengeluaranheader" class="form-select select2" style="width: 100%;">
      <option value="">-- semua --</option>
      @foreach ($comboKodepengeluaran as $kodepengeluaran)
      {{-- @if ($kodepengeluaran['id'] === "1") selected @endif --}}
        <option  value="{{$kodepengeluaran['id']}}"> {{$kodepengeluaran['keterangan']}} </option>
        {{-- <option @if ($kodepengeluaran['statusdefault_text'] ==="YA") selected @endif value="{{$kodepengeluaran['id']}}"> {{$kodepengeluaran['namakodepengeluaran']}} </option> --}}
      @endforeach
    </select>
  </div>
</div>
@endpush
@section('content')
<!-- Grid -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      @include('layouts._rangeheader')
      <table id="jqGrid"></table>
    </div>
  </div>
</div>

@include('pengeluaranstokheader._modal')
<!-- Detail -->
@include('pengeluaranstokheader._detail')

@push('scripts')
<script>
  let indexUrl = "{{ route('pengeluaranstokheader.index') }}"
  let getUrl = "{{ route('pengeluaranstokheader.get') }}"
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
    initSelect2($(`#kodepengeluaranheader`),false);

    $('#crudModal').on('hidden.bs.modal', function() {
       activeGrid = '#jqGrid'
     })
    setRange()
    initDatepicker()
    $(document).on('click','#btnReload', function(event) {
      loadDataHeader('pengeluaranstokheader',{pengeluaranheader_id:$('#kodepengeluaranheader').val()})
    })

    $("#jqGrid").jqGrid({
        url: `{{ config('app.api_url') . 'pengeluaranstokheader' }}`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        postData: {
          tgldari:$('#tgldariheader').val() ,
          tglsampai:$('#tglsampaiheader').val(),
          pengeluaranheader_id:$('#kodepengeluaranheader').val(),
        },
        datatype: "json",
        colModel: [
          {
            label: 'ID',
            name: 'id',
            align: 'right',
            width: '50px',
            search: false,
            hidden: true
          },
          {
            label: 'NO BUKTI',
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
            label: 'Gudang',
            name: 'gudang',
            align: 'left'
          },
          {
            label: 'Trado',
            name: 'trado',
            align: 'left'
          },
          {
            label: 'gandengan',
            name: 'gandengan',
            align: 'left'
          },
          {
            label: 'supplier',
            name: 'supplier',
            align: 'left'
          },
          {
            label: 'supir',
            name: 'supir',
            align: 'left'
          },
          {
            label: 'PENgeluaran Stok',
            name: 'pengeluaranstok',
            align: 'left'
          },
          
          {
            label: 'SERVICE IN NO BUKTI',
            width: 230,
            name: 'servicein_nobukti',
            align: 'left'
          },
         
          
          {
            label: 'PENERIMAAN STOK NO BUKTI',
            width: 230,
            name: 'penerimaanstok_nobukti',
            align: 'left'
          },
          {
            label: 'Pengeluaran no bukti',
            width: 230,
            name: 'pengeluaranstok_nobukti',
            align: 'left'
          },
          {
            label: 'Penerimaan no bukti',
            name: 'penerimaan_nobukti',
            width: 230,
            align: 'left'
          },
          {
            label: 'hutang bayar nobukti',
            width: 230,
            name: 'hutangbayar_nobukti',
            align: 'left'
          },
          {
            label: 'kerusakan',
            name: 'kerusakan',
            align: 'left'
          },
          {
            label: 'status potong retur',
            width: 230,
            name: 'statuspotongretur',
            align: 'left'
          },
          {
            label: 'bank',
            name: 'bank',
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

          loadDetailData(id)
          activeGrid = $(this)
          indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
          page = $(this).jqGrid('getGridParam', 'page')
          let limit = $(this).jqGrid('getGridParam', 'postData').limit
          if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))
        },
        loadComplete: function(data) {
          changeJqGridRowListText()

          if (data.data.length === 0) {
            abortGridLastRequest($('#detail'))
            clearGridData($('#detail'))
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
        buttons: [{
            id: 'add',
            innerHTML: '<i class="fa fa-plus"></i> ADD',
            class: 'btn btn-primary btn-sm mr-1',
            onClick: function(event) {
              createPengeluaranstokHeader()
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
                cekValidasi(selectedId, 'EDIT')
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
                cekValidasi(selectedId, 'DELETE')
              }
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
                window.open(`{{ route('pengeluaranstokheader.report') }}?id=${selectedId}`)
              }
            }
          },
          {
            id: 'export',
            title: 'Export',
            caption: 'Export',
            innerHTML: '<i class="fas fa-file-export"></i> EXPORT',
            class: 'btn btn-warning btn-sm mr-1',
            onClick: () => {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Please select a row')
              } else {
                window.open(`{{ route('pengeluaranstokheader.export') }}?id=${selectedId}`)
              }
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

    if (!`{{ $myAuth->hasPermission('pengeluaranstokheader', 'store') }}`) {
      $('#add').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('pengeluaranstokheader', 'update') }}`) {
      $('#edit').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('pengeluaranstokheader', 'destroy') }}`) {
      $('#delete').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('pengeluaranstokheader', 'export') }}`) {
      $('#export').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('pengeluaranstokheader', 'report') }}`) {
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
        xhr.open('GET', `{{ config('app.api_url') }}pengeluaranstokheader/export?${params}`, true)
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
              link.download = `laporanpengeluaranStok${(new Date).getTime()}.xlsx`
              link.click()

              submitButton.removeAttr('disabled')
            }
          }
        }

        xhr.send()
      } else if ($('#rangeModal').data('action') == 'report') {
        window.open(`{{ route('pengeluaranstokheader.report') }}?${params}`)

        submitButton.removeAttr('disabled')
      }
    })



  })
</script>
@endpush()
@endsection