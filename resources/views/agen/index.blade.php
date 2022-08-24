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
      <div id="jqGridPager" class="row bg-white">
        <div id="buttonContainer" class="col-12 col-md-7 text-center text-md-left">
          <button id="add" class="btn btn-primary btn-sm mb-1">
            <i class="fa fa-plus"></i> ADD
          </button>
          <button id="edit" class="btn btn-success btn-sm mb-1">
            <i class="fa fa-pen"></i> EDIT
          </button>
          <button id="delete" class="btn btn-danger btn-sm mb-1">
            <i class="fa fa-trash"></i> DELETE
          </button>
          <button id="export" class="btn btn-warning btn-sm mb-1">
            <i class="fa fa-file-export"></i> EXPORT
          </button>
          <button id="report" class="btn btn-info btn-sm mb-1">
            <i class="fa fa-print"></i> REPORT
          </button>
          <button id="approval" class="btn btn-purple btn-sm mb-1">
            <i class="fa fa-check"></i> UN/APPROVAL
          </button>
        </div>
        <div id="pagerHandler" class="col-12 col-md-4 d-flex justify-content-center align-items-center"></div>
        <div id="pagerInfo" class="col-12 col-md-1 d-flex justify-content-end align-items-center"></div>
      </div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  let indexUrl = "{{ route('agen.index') }}"
  let getUrl = "{{ route('agen.get') }}"
  let indexRow = 0;
  let page = 0;
  let popup = "";
  let id = "";
  let triggerClick = true;
  let highlightSearch;
  let totalRecord
  let limit
  let postData
  let sortname = 'kodeagen'
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
        url: `{{ config('app.api_url') . 'agen' }}`,
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
            label: 'KODE AGEN',
            name: 'kodeagen',
          },
          {
            label: 'NAMA AGEN',
            name: 'namaagen',
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
          },
          {
            label: 'STATUS AKTIF',
            name: 'statusaktif',
            stype: 'select',
            searchoptions: {
              value: `:ALL;<?php
                            $i = 1;

                            foreach ($combo['statusaktif'] as $statusaktif) :
                              echo "$statusaktif[text]:$statusaktif[text]";

                              if ($i !== count($combo['statusaktif'])) {
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
            label: 'NAMA PERUSAHAAN',
            name: 'namaperusahaan',
          },
          {
            label: 'ALAMAT',
            name: 'alamat',
          },
          {
            label: 'NO TELP',
            name: 'notelp',
          },
          {
            label: 'NO HP',
            name: 'nohp',
          },
          {
            label: 'CONTACT PERSON',
            name: 'contactperson',
          },
          {
            label: 'TOP',
            name: 'top',
            align: 'right',
            formatter: currencyFormat
          },
          {
            label: 'STATUS APPROVAL',
            name: 'statusapproval',
            stype: 'select',
            searchoptions: {
              value: `:ALL;<?php
                            $i = 1;

                            foreach ($combo['statusapproval'] as $statusapproval) :
                              echo "$statusapproval[text]:$statusapproval[text]";

                              if ($i !== count($combo['statusapproval'])) {
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
            label: 'USER APPROVAL',
            name: 'userapproval',
          },
          {
            label: 'TGL APPROVAL',
            name: 'tglapproval',
            formatter: dateFormat
          },
          {
            label: 'STATUS TAS',
            name: 'statustas',
            stype: 'select',
            searchoptions: {
              value: `:ALL;<?php
                            $i = 1;

                            foreach ($combo['statustas'] as $statustas) :
                              echo "$statustas[text]:$statustas[text]";

                              if ($i !== count($combo['statustas'])) {
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
            label: 'JENIS EMKL',
            name: 'jenisemkl',
          },
          {
            label: 'MODIFIEDBY',
            name: 'modifiedby',
          },
          {
            label: 'CREATEDAT',
            name: 'created_at',
          },
          {
            label: 'UPDATEDAT',
            name: 'updated_at'
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
        loadComplete: function(data) {
          loadPagerHandler('#pagerHandler', $(this))
          loadPagerInfo('#pagerInfo', $(this))

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
        },
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

    $('#approval .ui-pg-div')
      .addClass('btn-sm')
      .css({
        'background': '#6619ff',
        'color': '#fff'
      })
      .parent().addClass('px-1')

    if (!`{{ $myAuth->hasPermission('agen', 'store') }}`) {
      $('#add').addClass('ui-disabled')
    }

    if (!`{{ $myAuth->hasPermission('agen', 'update') }}`) {
      $('#edit').addClass('ui-disabled')
    }

    if (!`{{ $myAuth->hasPermission('agen', 'destroy') }}`) {
      $('#delete').addClass('ui-disabled')
    }

    if (!`{{ $myAuth->hasPermission('agen', 'export') }}`) {
      $('#export').addClass('ui-disabled')
    }

    if (!`{{ $myAuth->hasPermission('agen', 'report') }}`) {
      $('#report').addClass('ui-disabled')
    }

    if (!`{{ $myAuth->hasPermission('agen', 'approval') }}`) {
      $('#approval').addClass('ui-disabled')
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
        xhr.open('GET', `{{ config('app.api_url') }}agen/export?${params}`, true)
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
              link.download = `laporanAgen${(new Date).getTime()}.xlsx`
              link.click()

              submitButton.removeAttr('disabled')
            }
          }
        }

        xhr.send()
      } else if ($('#rangeModal').data('action') == 'report') {
        window.open(`{{ route('agen.report') }}?${params}`)

        submitButton.removeAttr('disabled')
      }
    })

    /* Handle button add on click */
    $('#add').click(function() {
      let limit = $('#jqGrid').jqGrid('getGridParam', 'postData').limit

      window.location.href = `{{ route('agen.create') }}?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}`
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

    /* Handle button approval on click */
    $('#approval').click(function() {
      let id = $('#jqGrid').jqGrid('getGridParam', 'selrow')

      $('#loader').removeClass('d-none')

      $.ajax({
        url: `{{ config('app.api_url') }}agen/${id}/approval`,
        method: 'POST',
        dataType: 'JSON',
        beforeSend: request => {
          request.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
        },
        success: response => {
          $('#jqGrid').trigger('reloadGrid')
        }
      }).always(() => {
        $('#loader').addClass('d-none')
      })
    })

    /* Handle button export on click */
    $('#export').click(function() {
      $('#rangeModal').data('action', 'export')
      $('#rangeModal').find('button:submit').html(`Export`)
      $('#rangeModal').modal('show')
    })

    /* Handle button report on click */
    $('#report').click(function() {
      $('#rangeModal').data('action', 'report')
      $('#rangeModal').find('button:submit').html(`Report`)
      $('#rangeModal').modal('show')
    })

  })
</script>
@endpush()
@endsection