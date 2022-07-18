@extends('layouts.master')

@section('content')
<!-- Modal for report -->
<div class="modal fade" id="rangeModal" tabindex="-1" aria-labelledby="rangeModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="rangeModalLabel">Pilih baris</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form id="formRange" target="_blank">
        @csrf
        <div class="modal-body">
          <input type="hidden" name="sidx">
          <input type="hidden" name="sord">

          <div class="form-group row">
            <div class="col-sm-2 col-form-label">
              <label for="">Dari</label>
            </div>
            <div class="col-sm-10">
              <input type="text" name="dari" class="form-control autonumeric-report" autofocus>
            </div>
          </div>

          <div class="form-group row">
            <div class="col-sm-2 col-form-label">
              <label for="">Sampai</label>
            </div>
            <div class="col-sm-10">
              <input type="text" name="sampai" class="form-control autonumeric-report">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Report</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
        </div>
      </form>
    </div>
  </div>
</div>

<!-- Grid -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <table id="jqGrid"></table>
      <div id="jqGridPager"></div>

      <div id="customPager" class="row bg-white">
        <div id="buttonContainer" class="col-12 col-md-5 text-center text-md-left">
          <button id="add" class="btn btn-primary btn-sm mb-1">
            <i class="fa fa-plus"></i> ADD
          </button>
          <button id="edit" class="btn btn-success btn-sm mb-1">
            <i class="fa fa-pen"></i> EDIT
          </button>
          <button id="delete" class="btn btn-danger btn-sm mb-1">
            <i class="fa fa-trash"></i> DELETE
          </button>
        </div>
        <div id="pagerButtonContainer" class="col-12 col-md-3 d-flex justify-content-center"></div>
        <div id="pagerInfo" class="col-12 col-md-4"></div>
      </div>

    </div>
  </div>
</div>

@push('scripts')
<script>
  let indexUrl = "{{ route('bankpelanggan.index') }}"
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
  let sortname = 'kodebank'
  let sortorder = 'asc'
  let autoNumericElements = []
  let rowNum = 10

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
    
    /* Set rowNum */
    <?php if (isset($_GET['limit'])) { ?>
      rowNum = "{{ $_GET['limit'] }}"
    <?php } ?>

    $("#jqGrid").jqGrid({
        url: `{{ config('app.api_url') . 'bankpelanggan' }}`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        colModel: [{
            label: 'ID',
            name: 'id',
            width: '50px'
          },
          {
            label: 'KODE BANK',
            name: 'kodebank',
          },
          {
            label: 'NAMA BANK',
            name: 'namabank',
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
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
          },
          {
            label: 'MODIFIEDBY',
            name: 'modifiedby',
          },
          {
            label: 'CREATEDAT',
            name: 'created_at',
            formatter: "date",
            formatoptions: { srcformat: "ISO8601Long", newformat: "d-m-Y H:i:s" }
          },
          {
            label: 'UPDATEDAT',
            name: 'updated_at',
            formatter: "date",
            formatoptions: { srcformat: "ISO8601Long", newformat: "d-m-Y H:i:s" }
          },
        ],
        autowidth: true,
        shrinkToFit: false,
        height: 350,
        rowNum: rowNum,
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
        },
      })

      .jqGrid("navGrid", pager, {
        search: false,
        refresh: false,
        add: false,
        edit: false,
        del: false,
      })

      // .navButtonAdd(pager, {
      //   caption: 'Add',
      //   title: 'Add',
      //   id: 'add',
      //   buttonicon: 'fas fa-plus',
      //   class: 'btn btn-primary',
      //   onClickButton: function() {
      //     let limit = $(this).jqGrid('getGridParam', 'postData').limit

      //     window.location.href = `{{ route('bankpelanggan.create') }}?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}`
      //   }
      // })

      // .navButtonAdd(pager, {
      //   caption: 'Edit',
      //   title: 'Edit',
      //   id: 'edit',
      //   buttonicon: 'fas fa-pen',
      //   onClickButton: function() {
      //     selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

      //     if (selectedId == null || selectedId == '' || selectedId == undefined) {
      //       alert('please select a row')
      //     } else {
      //       window.location.href = `${indexUrl}/${selectedId}/edit?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}`
      //     }
      //   }
      // })

      // .navButtonAdd(pager, {
      //   caption: 'Delete',
      //   title: 'Delete',
      //   id: 'delete',
      //   buttonicon: 'fas fa-trash',
      //   onClickButton: function() {
      //     selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

      //     window.location.href = `${indexUrl}/${selectedId}/delete?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}&page=${page}&indexRow=${indexRow}`
      //   }
      // })

      

      .jqGrid('filterToolbar', {
        stringResult: true,
        searchOnEnter: false,
        defaultSearch: 'cn',
        groupOp: 'AND',
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

    if (!`{{ $myAuth->hasPermission('bankpelanggan', 'store') }}`) {
      $('#add').addClass('ui-disabled')
    }

    if (!`{{ $myAuth->hasPermission('bankpelanggan', 'update') }}`) {
      $('#edit').addClass('ui-disabled')
    }

    if (!`{{ $myAuth->hasPermission('bankpelanggan', 'destroy') }}`) {
      $('#delete').addClass('ui-disabled')
    }

    /* Handle button add on click */
    $('#add').click(function() {
      let limit = $('#jqGrid').jqGrid('getGridParam', 'postData').limit

      window.location.href = `{{ route('bankpelanggan.create') }}?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}`
    })

    /* Handle button edit on click */
    $('#edit').click(function() {
      selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

      if (selectedId == null || selectedId == '' || selectedId == undefined) {
        alert('please select a row')
      } else {
        window.location.href = `${indexUrl}/${selectedId}/edit?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}`
      }
    })

    /* Handle button delete on click */
    $('#delete').click(function() {
      selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

      window.location.href = `${indexUrl}/${selectedId}/delete?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}&page=${page}&indexRow=${indexRow}`
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