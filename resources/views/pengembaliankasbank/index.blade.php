@extends('layouts.master')
@push('addtional-field')
<div class="form-group row">
  <label class="col-12 col-sm-2 col-form-label mt-2">Bank<span class="text-danger">*</span></label>
  <div class="col-sm-4 mt-2">
    <select name="bankheader" id="bankheader" class="form-select select2" style="width: 100%;">
      <option value="">-- PILIH BANK --</option>
      @foreach ($data['combobank'] as $bank)
      <option @if ($bank['namabank']==="BANK TRUCKING" ) selected @endif value="{{$bank['id']}}"> {{$bank['namabank']}} </option>
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
@include('pengembaliankasbank._modal')
<!-- Detail -->
@include('pengembaliankasbank._detail')
@include('pengeluaran._pengeluaran')
@include('jurnalumum._jurnal')

@push('scripts')
<script>
  let indexUrl = "{{ route('pengembaliankasbankheader.index') }}"
  let getUrl = "{{ route('pengembaliankasbankheader.get') }}"
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
    
    $('.select2').select2({
      width: 'resolve',
      theme: "bootstrap4"
    });

    setRange()
    initDatepicker()
    $(document).on('click','#btnReload', function(event) {
      loadDataHeader('pengembaliankasbankheader', {
        bank_id: $('#bankheader').val()
      })
    })
    $("#jqGrid").jqGrid({
        url: `{{ config('app.api_url') . 'pengembaliankasbankheader' }}`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        postData: {
          tgldari:$('#tgldariheader').val() ,
          tglsampai:$('#tglsampaiheader').val(),
          bank_id: $('#bankheader').val(),          
        },
        colModel: [{
            label: 'ID',
            name: 'id',
            align: 'right',
            width: '50px',
            search: false,
            hidden:true
          },
          {
            label: 'STATUS APPROVAL',
            name: 'statusapproval',
            align: 'left',
            stype: 'select',
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['comboapproval'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['comboapproval'])) {
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
              let statusApproval = JSON.parse(value)

              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusApproval.WARNA}; color: #fff;">
                  <span>${statusApproval.SINGKATAN}</span>
                </div>
              `)
              
              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusApproval = JSON.parse(rowObject.statusapproval)
              
              return ` title="${statusApproval.MEMO}"`
            }
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

              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusCetak.WARNA}; color: #fff;">
                  <span>${statusCetak.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusCetak = JSON.parse(rowObject.statuscetak)

              return ` title="${statusCetak.MEMO}"`
            }
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
            label: 'pengeluaran nobukti ',
            name: 'pengeluaran_nobukti',
            align: 'left',
            formatter: (value, options, rowData) => {
              if ((value == null) ||( value == '')) {
                return '';
              }
              let tgldari = rowData.tgldariheaderpengeluaranheader
              let tglsampai = rowData.tglsampaiheaderpengeluaranheader
              let url = "{{route('pengeluaranheader.index')}}"
              let formattedValue = $(`
              <a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}" class="link-color" target="_blank">${value}</a>
             `)
             return formattedValue[0].outerHTML
           }
          },
          {
            label: 'BANK',
            name: 'bank_id',
            align: 'left'
          },
          {
            label: 'STATUS JNS TRANSAKSI',
            name: 'statusjenistransaksi',
            align: 'left',
            stype: 'select',
              searchoptions: {
                value: `<?php
                        $i = 1;

                        foreach ($data['combojenistransaksi'] as $status) :
                          echo "$status[param]:$status[parameter]";
                          if ($i !== count($data['combojenistransaksi'])) {
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
            label: 'POSTING DARI',
            name: 'postingdari',
            align: 'left'
          },
          {
            label: 'DIBAYARKAN KE',
            name: 'dibayarke',
            align: 'left'
          },
          {
            label: 'TRANSFER KE NO REK',
            name: 'transferkeac',
            align: 'left'
          }, 
          {
            label: 'TRANSFER NAMA REK',
            name: 'transferkean',
            align: 'left'
          },
          {
            label: 'TRANSFER NAMA BANK',
            name: 'transferkebank',
            align: 'left'
          },
          {
            label: 'TGL APPROVAL',
            name: 'tglapproval',
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'USER APPROVAL',
            name: 'userapproval',
            align: 'left'
          },
          {
            label: 'TGL CETAK',
            name: 'tglbukacetak',
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'USER CETAK',
            name: 'userbukacetak',
            align: 'left'
          },
          {
            label: 'MODIFIED BY',
            name: 'modifiedby',
            align: 'left'
          },
          {
            label: 'CREATED AT',
            name: 'created_at',
            align: 'right',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y H:i:s"
            }
          },
          {
            label: 'UPDATED AT',
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
          let nobukti = $(`#jqGrid tr#${id}`).find(`td[aria-describedby="jqGrid_pengeluaran_nobukti"]`).attr('title') ?? '';
          $(`#tabs #${currentTab}-tab`).html('').load(`${appUrl}/pengembaliankasbankdetail/${currentTab}/grid`, function() {
            loadGrid(id,nobukti)
          })
          loadDetailData(id)
          activeGrid = $(this)
          indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
          page = $(this).jqGrid('getGridParam', 'page')
          limit = $(this).jqGrid('getGridParam', 'postData').limit
          if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))
          
        },
        loadComplete: function(data) {
          changeJqGridRowListText()
          if (data.data.length == 0) {
            $('#detail').jqGrid('setGridParam', {
              postData: {
                pengembaliankasbank_id: 0,
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
          console.log('complete', limit)
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
              createPengembalianKasBank()
            }
          },
          {
            id: 'edit',
            innerHTML: '<i class="fa fa-pen"></i> EDIT',
            class: 'btn btn-success btn-sm mr-1',
            onClick: function(event) {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Harap pilih salah satu record')
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
                showDialog('Harap pilih salah satu record')
              } else {
                cekValidasi(selectedId, 'DELETE')
              }
            }
          },
          {
            id: 'view',
            innerHTML: '<i class="fa fa-eye"></i> VIEW',
            class: 'btn btn-orange btn-sm mr-1',
            onClick: () => {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              viewPengembalianKasBank(selectedId)
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
                showDialog('Harap pilih salah satu record')
              } else {
                window.open(`{{ route('pengembaliankasbankheader.export') }}?id=${selectedId}`)
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
                showDialog('Harap pilih salah satu record')
              } else {
                window.open(`{{ route('pengembaliankasbankheader.report') }}?id=${selectedId}`)
              }
            }
          },
          {
            id: 'approval',
            innerHTML: '<i class="fa fa-check"></i> APPROVAL/UN',
            class: 'btn btn-purple btn-sm mr-1',
            onClick: () => {
              var selectedOne = selectedOnlyOne();
              if (selectedOne[0]) {
                handleApproval(selectedOne[1])
              } else {
                showDialog(selectedOne[1])
              }
            }
          },
        ]

      })

      function handleApproval(id) {
        $.ajax({
          url: `${apiUrl}pengembaliankasbankheader/${id}/approval`,
          method: 'POST',
          dataType: 'JSON',
          beforeSend: request => {
            request.setRequestHeader('Authorization', `Bearer ${accessToken}`)
          },
          success: response => {
            $('#jqGrid').trigger('reloadGrid')
          }
        }).always(() => {
          $('#processingLoader').addClass('d-none')
        })
      }
      
        

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

    $('#approval .ui-pg-div')
    .addClass('btn btn-purple btn-sm')
    .css({
    'background': '#6619ff',
    'color': '#fff'
    })
    .parent().addClass('px-1')

    if (!`{{ $myAuth->hasPermission('pengembaliankasbankheader', 'store') }}`) {
      $('#add').attr('disabled', 'disabled')
    }
    if (!`{{ $myAuth->hasPermission('pengembaliankasbankheader', 'show') }}`) {
      $('#view').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('pengembaliankasbankheader', 'update') }}`) {
      $('#edit').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('pengembaliankasbankheader', 'destroy') }}`) {
      $('#delete').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('pengembaliankasbankheader', 'export') }}`) {
      $('#export').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('pengembaliankasbankheader', 'report') }}`) {
      $('#report').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('pengembaliankasbankheader', 'approval') }}`) {
      $('#approval').attr('disabled', 'disabled')
    }


    
    $("#tabs").on('click', 'li.ui-state-active', function() {
      let href = $(this).find('a').attr('href');
      currentTab = href.substring(1, href.length - 4);
      let hutangBayarId = $('#jqGrid').jqGrid('getGridParam', 'selrow')
      let nobukti = $('#jqGrid').jqGrid('getCell', hutangBayarId, 'pengeluaran_nobukti')
      $(`#tabs #${currentTab}-tab`).html('').load(`${appUrl}/pengembaliankasbankdetail/${currentTab}/grid`, function() {

        loadGrid(hutangBayarId, nobukti)
      })
    })
    
  })

  
</script>
@endpush()
@endsection