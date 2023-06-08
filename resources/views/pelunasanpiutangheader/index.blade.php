@extends('layouts.master')

@section('content')
<!-- Grid Master-->
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      @include('layouts._rangeheader')
      <table id="jqGrid"></table>
    </div>
  </div>
  <div class="row mt-3">
    <div class="col-12">
      <div class="card card-primary card-outline card-outline-tabs">
        <div class="card-body border-bottom-0">
          <div id="tabs">
            <ul class="dejavu">
              <li><a href="#detail-tab">Details</a></li>
              <li><a href="#penerimaan-tab">Penerimaan Kas/bank</a></li>
              <li><a href="#jurnal-tab">Jurnal</a></li>
            </ul>
            <div id="detail-tab">

            </div>

            <div id="penerimaan-tab">

            </div>
            <div id="jurnal-tab">

            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
@include('pelunasanpiutangheader._modal')
<!-- Detail -->
@include('pelunasanpiutangheader._detail')
@include('penerimaan._penerimaan')
@include('jurnalumum._jurnal')

@push('scripts')
<script>
  let indexUrl = "{{ route('pelunasanpiutangheader.index') }}"
  let getUrl = "{{ route('pelunasanpiutangheader.get') }}"
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
  let rowNum = 10
  let hasDetail = false
  let currentTab = 'detail'

  $(document).ready(function() {
    $("#tabs").tabs()

    setRange()
    initDatepicker()
    $(document).on('click','#btnReload', function(event) {
      loadDataHeader('pelunasanpiutangheader')
    })

    $("#jqGrid").jqGrid({
        url: `{{ config('app.api_url') . 'pelunasanpiutangheader' }}`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        postData: {
          tgldari:$('#tgldariheader').val() ,
          tglsampai:$('#tglsampaiheader').val() 
        },
        datatype: "json",
        colModel: [{
            label: 'ID',
            name: 'id',
            align: 'right',
            width: '50px',
            search: false,
            hidden: true
          },
          {
            label: 'NO. BUKTI',
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
            label: 'BANK',
            name: 'bank_id',
            align: 'left'
          },
          {
            label: 'ALAT BAYAR',
            name: 'alatbayar_id',
            align: 'left'
          },
          {
            label: 'AGEN',
            name: 'agen_id',
            align: 'left'
          },
          {
            label: 'NO. BUKTI PENERIMAAN',
            name: 'penerimaan_nobukti',
            align: 'left'
          },
          {
            label: 'NO. BUKTI GIRO',
            name: 'penerimaangiro_nobukti',
            align: 'left'
          },
          {
            label: 'NOTA DEBET',
            name: 'notadebet_nobukti',
            align: 'left'
          },
          {
            label: 'NOTA KREDIT',
            name: 'notakredit_nobukti',
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
          let nobukti = $('#jqGrid').jqGrid('getCell', id, 'penerimaan_nobukti')
          $(`#tabs #${currentTab}-tab`).html('').load(`${appUrl}/pelunasanpiutangdetail/${currentTab}/grid`, function() {
            loadGrid(id,nobukti)
          })
          loadDetailData(id)
          activeGrid = $(this)
          indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
          page = $(this).jqGrid('getGridParam', 'page')
          let limit = $(this).jqGrid('getGridParam', 'postData').limit
          if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))
          
        },
        loadComplete: function(data) {
          changeJqGridRowListText()
          if (data.data.length == 0) {
            $('#detail').jqGrid('setGridParam', {
              postData: {
                pelunasanpiutang_id: 0,
              },
            }).trigger('reloadGrid');
            $('#jurnalGrid').jqGrid('setGridParam', {
              postData: {
                nobukti: 0,
              },
            }).trigger('reloadGrid');
            $('#penerimaanGrid').jqGrid('setGridParam', {
              postData: {
                nobukti: 0,
              },
            }).trigger('reloadGrid');
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
              createPelunasanPiutangHeader()
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
              }else {
                editPelunasanPiutangHeader(selectedId)
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
                deletePelunasanPiutangHeader(selectedId)
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
                window.open(`{{ route('pelunasanpiutangheader.report') }}?id=${selectedId}`)
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
                window.open(`{{ route('pelunasanpiutangheader.export') }}?id=${selectedId}`)
              }
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

    if (!`{{ $myAuth->hasPermission('pelunasanpiutangheader', 'store') }}`) {
      $('#add').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('pelunasanpiutangheader', 'update') }}`) {
      $('#edit').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('pelunasanpiutangheader', 'destroy') }}`) {
      $('#delete').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('pelunasanpiutangheader', 'export') }}`) {
      $('#export').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('pelunasanpiutangheader', 'report') }}`) {
      $('#report').attr('disabled', 'disabled')
    }


    $("#tabs").on('click', 'li.ui-state-active', function() {
      let href = $(this).find('a').attr('href');
      currentTab = href.substring(1, href.length - 4);
      let pelunasanId = $('#jqGrid').jqGrid('getGridParam', 'selrow')
      let nobukti = $('#jqGrid').jqGrid('getCell', pelunasanId, 'penerimaan_nobukti')
      $(`#tabs #${currentTab}-tab`).html('').load(`${appUrl}/pelunasanpiutangdetail/${currentTab}/grid`, function() {

        loadGrid(pelunasanId, nobukti)
      })
    })
    
  })

  
</script>
@endpush()
@endsection