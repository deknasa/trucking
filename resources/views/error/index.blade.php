@extends('layouts.master')

@section('content')
<!-- Grid -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <table id="jqGrid"></table>
      <div id="jqGridPager"></div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  let indexUrl = "{{ route('error.index') }}"
  let getUrl = "{{ route('error.get') }}"
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
    /* Set page */
    <?php if (isset($_GET['page'])) { ?>
      page = "{{ $_GET['page'] }}"
    <?php } ?>

    /* Set id */
    <?php if (isset($_GET['id'])) { ?>
      id = "{{ $_GET['id'] }}"
    <?php } ?>

    /* Set indexRow */
    <?php if (isset($_GET['indexRow'])) { ?>
      indexRow = "{{ $_GET['indexRow'] }}"
    <?php } ?>

    /* Set sortname */
    <?php if (isset($_GET['sortname'])) { ?>
      sortname = "{{ $_GET['sortname'] }}"
    <?php } ?>

    /* Set sortorder */
    <?php if (isset($_GET['sortorder'])) { ?>
      sortorder = "{{ $_GET['sortorder'] }}"
    <?php } ?>

    $("#jqGrid").jqGrid({
        url: `{{ config('app.api_url') . 'error' }}`,
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
            label: 'KETERANGAN',
            name: 'keterangan',
            align: 'left'
          },
          {
            label: 'KODE ERROR',
            name: 'kodeerror',
            align: 'left'
          },
          {
            label: 'MODIFIEDBY',
            name: 'modifiedby',
            align: 'left'
          },
          {
            label: 'UPDATEDAT',
            name: 'updated_at',
            align: 'right'
          }, {
            label: 'CREATEDAT',
            name: 'created_at',
            align: 'right'
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
        pager: pager,
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
          id = $(this).jqGrid('getCell', id, 'rn') - 1
          indexRow = id
          page = $(this).jqGrid('getGridParam', 'page')
          let rows = $(this).jqGrid('getGridParam', 'postData').limit
          if (indexRow >= rows) indexRow = (indexRow - rows * (page - 1))
        },
        ondblClickRow: function(rowid) {

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

          $('.clearsearchclass').click(function() {
            clearColumnSearch()
          })

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
        }
      })

      .jqGrid("navGrid", pager, {
        search: false,
        refresh: false,
        add: false,
        edit: false,
        del: false,
      })

      .navButtonAdd(pager, {
        caption: 'Add',
        title: 'Add',
        id: 'add',
        buttonicon: 'fas fa-plus',
        onClickButton: function() {
          let limit = $(this).jqGrid('getGridParam', 'postData').limit

          window.location.href = `{{ route('error.create') }}?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}`
        }
      })

      .navButtonAdd(pager, {
        caption: 'Edit',
        title: 'Edit',
        id: 'edit',
        buttonicon: 'fas fa-pen',
        onClickButton: function() {
          selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

          window.location.href = `${indexUrl}/${selectedId}/edit?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}`
        }
      })

      .navButtonAdd(pager, {
        caption: 'Delete',
        title: 'Delete',
        id: 'delete',
        buttonicon: 'fas fa-trash',
        onClickButton: function() {
          selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

          window.location.href = `${indexUrl}/${selectedId}/delete?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}&page=${page}&indexRow=${indexRow}`
        }
      })

      .navButtonAdd(pager, {
        caption: 'Export',
        title: 'Export',
        id: 'export',
        buttonicon: 'fas fa-file-export',
        onClickButton: function() {
          $('#rangeModal').data('action', 'export')
          $('#rangeModal').find('button:submit').html(`Export`)
          $('#rangeModal').modal('show')
        }
      })

      .navButtonAdd(pager, {
        caption: 'Report',
        title: 'Report',
        id: 'report',
        buttonicon: 'fas fa-print',
        onClickButton: function() {
          $('#rangeModal').data('action', 'report')
          $('#rangeModal').find('button:submit').html(`Report`)
          $('#rangeModal').modal('show')
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
        }
      })

    /* Append clear filter button */
    loadClearFilter()

    /* Append global search */
    loadGlobalSearch()


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


    if (!`{{ $myAuth->hasPermission('error', 'store') }}`) {
      $('#add').addClass('ui-disabled')
    }

    if (!`{{ $myAuth->hasPermission('error', 'update') }}`) {
      $('#edit').addClass('ui-disabled')
    }

    if (!`{{ $myAuth->hasPermission('error', 'destroy') }}`) {
      $('#delete').addClass('ui-disabled')
    }

    if (!`{{ $myAuth->hasPermission('error', 'export') }}`) {
      $('#export').addClass('ui-disabled')
    }

    if (!`{{ $myAuth->hasPermission('error', 'report') }}`) {
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
    xhr.open('GET', `{{ config('app.api_url') }}error/export?${params}`, true)
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
          link.download = `laporanError${(new Date).getTime()}.xlsx`
          link.click()

          submitButton.removeAttr('disabled')
        }
      }
    }

    xhr.send()
  } else if ($('#rangeModal').data('action') == 'report') {
    window.open(`{{ route('error.report') }}?${params}`)

    submitButton.removeAttr('disabled')
  }
})
  })
</script>
@endpush()
@endsection