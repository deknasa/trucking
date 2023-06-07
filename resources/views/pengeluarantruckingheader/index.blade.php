@extends('layouts.master')
@push('addtional-field')
<div class="form-group row">
  <label class="col-12 col-sm-2 col-form-label mt-2">pengeluaran trucking<span class="text-danger">*</span></label>
  <div class="col-sm-4 mt-2">
    <select name="pengeluaranheader_id" id="pengeluaranheader_id" class="form-select select2" style="width: 100%;">
      <option value="">-- PILIH Pengeluaran trucking --</option>
      @foreach ($comboKodepengeluaran as $kodepengeluaran)
        <option @if ($kodepengeluaran['id'] == "1") selected @endif value="{{$kodepengeluaran['id']}}"> {{$kodepengeluaran['keterangan']}} </option>
        {{-- <option @if ($kodepengeluaran['statusdefault_text'] ==="YA") selected @endif value="{{$kodepengeluaran['id']}}"> {{$kodepengeluaran['namakodepengeluaran']}} </option> --}}
      @endforeach
    </select>
  </div>
</div>
@endpush
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
              <li><a href="#pengeluaran-tab">Pengeluaran Kas/bank</a></li>
              <li><a href="#jurnal-tab">Jurnal</a></li>
            </ul>
            <div id="detail-tab">

            </div>

            <div id="pengeluaran-tab">

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
@include('pengeluarantruckingheader._modal')
<!-- Detail -->
@include('pengeluarantruckingheader._detail')
@include('pengeluaran._pengeluaran')
@include('jurnalumum._jurnal')

@push('scripts')
<script>
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
  let activeGrid
  let currentTab = 'detail'

  $(document).ready(function() {
    $("#tabs").tabs()
    // $('.select2').select2({
    //   width: 'resolve',
    //   theme: "bootstrap4"
    // });
    initSelect2($('#pengeluaranheader_id'),false)
    
    setRange()
    initDatepicker()
    $(document).on('click','#btnReload', function(event) {
      console.log($('#pengeluaranheader_id').val());
      loadDataHeader('pengeluarantruckingheader',{pengeluaranheader_id:$('#pengeluaranheader_id').val()})
    })

    $("#jqGrid").jqGrid({
        url: `{{ config('app.api_url') . 'pengeluarantruckingheader' }}`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
         postData: {
          tgldari:$('#tgldariheader').val() ,
          tglsampai:$('#tglsampaiheader').val(),
          pengeluaranheader_id:$('#pengeluaranheader_id').val(),

        },
        colModel: [{
            label: 'ID',
            name: 'id',
            align: 'right',
            width: '50px',
            search: false,
            hidden: true
          },
          {
            label: 'STATUS CETAK',
            name: 'statuscetak',
            align: 'left',
            stype: 'select',
            searchoptions: {
              
              value: `<?php
                      $i = 1;

                      foreach ($data['combocetak'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['combocetak'])) {
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
            formatter: (value, options, rowData) => {
              let statusCetak = JSON.parse(value)
              if (!statusCetak) {
                return ''
              }
              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusCetak.WARNA}; color: #fff;">
                  <span>${statusCetak.SINGKATAN}</span>
                </div>
              `)
              
              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusCetak = JSON.parse(rowObject.statuscetak)
              if (!statusCetak) {
                return ` title=" "`
              }
              return ` title="${statusCetak.MEMO}"`
            }
          },
          {
            label: 'NO. BUKTI',
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
            label: 'PENGELUARAN TRUCKING ',
            name: 'pengeluarantrucking_id',
            align: 'left'
          },
          {
            label: 'BANK',
            name: 'bank_id',
            align: 'left'
          },
          {
            label: 'STATUS POSTING',
            name: 'statusposting',
            align: 'left',
            stype: 'select',
              searchoptions: {
                value: `<?php
                        $i = 1;

                        foreach ($data['combostatusposting'] as $status) :
                          echo "$status[param]:$status[parameter]";
                          if ($i !== count($data['combostatusposting'])) {
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
            formatter: (value, options, rowData) => {
              let statusPosting = JSON.parse(value)
              if (!statusPosting) {
                return ''
              }
              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusPosting.WARNA}; color: #fff;">
                  <span>${statusPosting.SINGKATAN}</span>
                </div>
              `)
              
              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusPosting = JSON.parse(rowObject.statusposting)
              if (!statusPosting) {
                return ` title=" "`
              }
              return ` title="${statusPosting.MEMO}"`
            }
          },
          {
            label: 'supir',
            name: 'supir',
            align: 'left'
          },
          {
            label: 'trado',
            name: 'trado',
            align: 'left'
          },
          {
            label: 'COA',
            name: 'coa',
            align: 'left'
          },
          {
            label: 'NO. BUKTI PENGELUARAN',
            name: 'pengeluaran_nobukti',
            align: 'left'
          },
          {
            label: 'USER BUKA CETAK',
            name: 'userbukacetak',
            align: 'left'
          },
          {
            label: 'TANGGAL CETAK',
            name: 'tglbukacetak',
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
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
          let nobukti = $('#jqGrid').jqGrid('getCell', id, 'pengeluaran_nobukti')
          $(`#tabs #${currentTab}-tab`).html('').load(`${appUrl}/pengeluarantruckingdetail/${currentTab}/grid`, function() {
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
                pengeluarantruckingheader_id: 0,
              },
            }).trigger('reloadGrid');
            $('#jurnalGrid').jqGrid('setGridParam', {
              postData: {
                nobukti: 0,
              },
            }).trigger('reloadGrid');
            $('#pengeluaranGrid').jqGrid('setGridParam', {
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
              createPengeluaranTruckingHeader()
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
                window.open(`{{ route('pengeluarantruckingheader.report') }}?id=${selectedId}`)
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
                window.open(`{{ route('pengeluarantruckingheader.export') }}?id=${selectedId}`)
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

    if (!`{{ $myAuth->hasPermission('pengeluarantruckingheader', 'store') }}`) {
      $('#add').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('pengeluarantruckingheader', 'update') }}`) {
      $('#edit').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('pengeluarantruckingheader', 'destroy') }}`) {
      $('#delete').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('pengeluarantruckingheader', 'export') }}`) {
      $('#export').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('pengeluarantruckingheader', 'report') }}`) {
      $('#report').attr('disabled', 'disabled')
    }


    $("#tabs").on('click', 'li.ui-state-active', function() {
      let href = $(this).find('a').attr('href');
      currentTab = href.substring(1, href.length - 4);
      let hutangBayarId = $('#jqGrid').jqGrid('getGridParam', 'selrow')
      let nobukti = $('#jqGrid').jqGrid('getCell', hutangBayarId, 'pengeluaran_nobukti')
      $(`#tabs #${currentTab}-tab`).html('').load(`${appUrl}/pengeluarantruckingdetail/${currentTab}/grid`, function() {

        loadGrid(hutangBayarId, nobukti)
      })
    })
    
  })

  
</script>
@endpush()
@endsection