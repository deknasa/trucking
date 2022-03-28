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
    </div>
  </div>
</div>

<!-- Detail -->
@include('logtrail._detail')

@push('scripts')
<script>
  let indexUrl = "{{ route('logtrail.index') }}"
  let getUrl = "{{ route('logtrail.get') }}"
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
  let sortname = 'namatabel'
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
        url: getUrl,
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
            label: 'NAMA TABEL',
            name: 'namatabel',
          },
          {
            label: 'POSTING DARI',
            name: 'postingdari',
          },
          {
            label: 'ID TRANS',
            name: 'idtrans',
          },
          {
            label: 'NO BUKTI TRANS',
            name: 'nobuktitrans',
          },
          {
            label: 'AKSI',
            name: 'aksi',
          },
          {
            label: 'MODIFIEDBY',
            name: 'modifiedby',
          },
          {
            label: 'UPDATEDAT',
            name: 'updated_at',
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
        ajaxRowOptions: {
          async: false,
        },
        onSelectRow: function(id) {
          $.jgrid.gridUnload("#logtrailHeader")
          $.jgrid.gridUnload("#logtrailDetail")

          loadLogtrailHeaderData(id)
          loadLogtrailDetailData(id)

          id = $(this).jqGrid('getCell', id, 'rn') - 1
          indexRow = id
          page = $(this).jqGrid('getGridParam', 'page')
          let rows = $(this).jqGrid('getGridParam', 'postData').rows
          if (indexRow >= rows) indexRow = (indexRow - rows * (page - 1))
        },
        loadComplete: function(data) {
          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))

          /* Set global variables */
          sortname = $(this).jqGrid("getGridParam", "sortname")
          sortorder = $(this).jqGrid("getGridParam", "sortorder")
          totalRecord = $(this).getGridParam("records")
          limit = $(this).jqGrid('getGridParam', 'postData').rows
          postData = $(this).jqGrid('getGridParam', 'postData')
          triggerClick = true

          $('.clearsearchclass').click(function() {
            highlightSearch = ''
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

      if ($('#rangeModal').data('action') == 'export') {
        actionUrl = `{{ route('logtrail.export') }}`
      } else if ($('#rangeModal').data('action') == 'report') {
        actionUrl = `{{ route('logtrail.report') }}`
      }

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