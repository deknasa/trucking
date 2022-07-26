@extends('layouts.master')

@section('content')


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

<!-- Detail -->
@include('servicein._detail')

@push('scripts')
<script>
  let indexUrl = "{{ route('servicein.index') }}"
  let getUrl = "{{ route('servicein.get') }}"
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
  // console.log(getUrl);
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
          url: `{{ config('app.api_url') . 'servicein' }}`,
          // url: getUrl,
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
            formatoptions: { srcformat: "ISO8601Long", newformat: "d-m-Y" }
          },
          {
            label: 'TRADO ID',
            name: 'trado_id',
            align: 'left'
          },
          {
            label: 'TGL MASUK',
            name: 'tglmasuk',
            align: 'left',
            formatter: "date",
            formatoptions: { srcformat: "ISO8601Long", newformat: "d-m-Y" }
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
            align: 'left'
          },
          {
            label: 'MODIFIEDBY',
            name: 'modifiedby',
            align: 'left'
          },
          // {
            //   label: 'CREATEDAT',
            //   name: 'created_at',
            //   align: 'left'
            // },
            {
              label: 'UPDATEDAT',
              name: 'updated_at',
              align: 'left',
              formatter: "date",
            formatoptions: { srcformat: "ISO8601Long", newformat: "d-m-Y H:i:s" }
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
          ajaxRowOptions: {
              async: false,
            },
            onSelectRow: function(id) {
              loadDetailData(id)
              
              id = $(this).jqGrid('getCell', id, 'rn') - 1
              indexRow = id
              page = $(this).jqGrid('getGridParam', 'page')
              let rows = $(this).jqGrid('getGridParam', 'postData').limit
              if (indexRow >= rows) indexRow = (indexRow - rows * (page - 1))
            },
            loadComplete: function(data) {
              $("input").attr("autocomplete", "off");
              $(document).unbind('keydown')
              setCustomBindKeys($(this))
              initResize($(this))
              
              if (data.message !== "" && data.message !== undefined && data.message !== null) {
                alert(data.message)
          }

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
          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`[id="${$('#jqGrid').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`[id="${$('#jqGrid').getDataIDs()[indexRow]}"]`).click()
            }
            
            if ($('#jqGrid').getDataIDs()[indexRow] == undefined) {
              $(`[id="` + $('#jqGrid').getDataIDs()[0] + `"]`).click()
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
      
      // .navButtonAdd(pager, {
      //   caption: 'Add',
      //   title: 'Add',
      //   id: 'add',
      //   buttonicon: 'fas fa-plus',
      //   onClickButton: function() {
      //     let limit = $('#jqGrid').jqGrid('getGridParam', 'postData').limit
          
      //     window.location.href = `{{ route('servicein.create') }}?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}`
      //   }
      // })
      
      // .navButtonAdd(pager, {
      //   caption: 'Edit',
      //   title: 'Edit',
      //   id: 'edit',
      //   buttonicon: 'fas fa-pen',
      //   onClickButton: function() {
      //     selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
          
      //     window.location.href = `${indexUrl}/${selectedId}/edit?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}`
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
      
      // .navButtonAdd(pager, {
        //   caption: 'Export',
        //   title: 'Export',
        //   id: 'export',
        //   buttonicon: 'fas fa-file-export',
        //   onClickButton: function() {
          //     $('#rangeModal').data('action', 'export')
          //     $('#rangeModal').find('button:submit').html(`Export`)
          //     $('#rangeModal').modal('show')
          //   }
          // })
          
          // .navButtonAdd(pager, {
            //   caption: 'Report',
            //   title: 'Report',
            //   id: 'report',
            //   buttonicon: 'fas fa-print',
            //   onClickButton: function() {
              //     $('#rangeModal').data('action', 'report')
              //     $('#rangeModal').find('button:submit').html(`Report`)
              //     $('#rangeModal').modal('show')
              //   }
              // })
              
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
              
              /* Load detial grid */
              loadDetailGrid()
              
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

              $('#add').click(function() {
      let limit = $('#jqGrid').jqGrid('getGridParam', 'postData').limit

      window.location.href = `{{ route('servicein.create') }}?sortname=${sortname}&sortorder=${sortorder}&limit=${limit}`
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
                
                if ($('#rangeModal').data('action') == 'export') {
                  actionUrl = `{{ route('servicein.export') }}`
                } else if ($('#rangeModal').data('action') == 'report') {
                  actionUrl = `{{ route('servicein.report') }}`
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