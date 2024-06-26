@extends('layouts.master')
@push('addtional-field')
<div class="form-group row">
  <label class="col-12 col-sm-2 col-form-label mt-2">kodepenerimaan <span class="text-danger">*</span></label>
  <div class="col-sm-4 mt-2">
    <select name="penerimaanheader_id" id="penerimaanheader_id" class="form-select select2" style="width: 100%;">
      <option value="">-- SEMUA --</option>
      @foreach ($comboKodepenerimaan as $kodepenerimaan)
      <option value="{{$kodepenerimaan['id']}}"> {{$kodepenerimaan['keterangan']}} </option>
      {{-- <option @if ($kodepenerimaan['statusdefault_text'] ==="YA") selected @endif value="{{$kodepenerimaan['id']}}"> {{$kodepenerimaan['namakodepenerimaan']}} </option> --}}
      {{-- @if ($kodepenerimaan['id'] == "1") selected @endif  --}}
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
              <li><a href="#penerimaan-tab">Penerimaan Kas/bank</a></li>
              <li><a href="#jurnal-tab">Jurnal</a></li>
            </ul>
            <div id="detail-tab">
              <table id="detail"></table>
            </div>
            <div id="penerimaan-tab">
              <table id="penerimaanGrid"></table>
            </div>
            <div id="jurnal-tab">
              <table id="jurnalGrid"></table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
@include('penerimaantruckingheader._modal')
<!-- Detail -->
@include('penerimaantruckingheader._detail')
@include('penerimaan._penerimaan')
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
  let dataAcos = <?php echo json_encode($acosPenerimaan); ?>;
  let rowNum = 10
  let hasDetail = false
  let activeGrid
  let currentTab = 'detail'
  let tgldariheader
  let tglsampaiheader
  let selectedRows = [];
  let selectedbukti = [];

  reloadGrid()

  function checkboxHandlerIndex(element) {
    let value = $(element).val();

    var onSelectRowExisting = $("#jqGrid").jqGrid('getGridParam', 'onSelectRow');
    $("#jqGrid").jqGrid('setSelection', value, false);
    onSelectRowExisting(value)

    let valuebukti = $(`#jqGrid tr#${value}`).find(`td[aria-describedby="jqGrid_nobukti"]`).attr('title');

    if (element.checked) {
      selectedRows.push($(element).val())
      selectedbukti.push(valuebukti)
      $(element).parents('tr').addClass('bg-light-blue')
    } else {
      $(element).parents('tr').removeClass('bg-light-blue')
      for (var i = 0; i < selectedRows.length; i++) {
        if (selectedRows[i] == value) {
          selectedRows.splice(i, 1);
        }
      }

      if (selectedRows.length != $('#jqGrid').jqGrid('getGridParam').records) {
        $('#gs_').prop('checked', false)
      }
      for (var i = 0; i < selectedbukti.length; i++) {
        if (selectedbukti[i] == valuebukti) {
          selectedbukti.splice(i, 1);
        }
      }
    }

  }

  setSpaceBarCheckedHandler()
  $(document).on('change', $('#crudForm').find('[name=penerimaanheader_id]'), function(event) {
    setPermissionAcos()
  })

  function setPermissionAcos() {
    let selectedIdPenerimaan = $(`[name="penerimaanheader_id"] option:selected`).val();
    if (selectedIdPenerimaan != '') {
      let isKodepengeluaranInData = dataAcos.some(item => parseInt(item.id) == selectedIdPenerimaan);
      if (isKodepengeluaranInData) {
        $('#add').attr('disabled', false)
        $('#edit').attr('disabled', false)
        $('#delete').attr('disabled', false)
        permission()
      } else {
        $('#add').attr('disabled', true)
        $('#edit').attr('disabled', true)
        $('#delete').attr('disabled', true)
      }
    } else {
      $('#add').attr('disabled', false)
      $('#edit').attr('disabled', false)
      $('#delete').attr('disabled', false)
      permission()
    }
  }
  $(document).ready(function() {
    // $("#penerimaanheader_id").val($("#penerimaanheader_id option:eq(1)").val()).trigger('change');
    $("#tabs").tabs()
    penerimaanTrucking($('#crudForm'))

    let nobukti = $('#jqGrid').jqGrid('getCell', id, 'penerimaan_nobukti')
    loadDetailGrid()
    loadPenerimaanGrid(nobukti)
    loadJurnalUmumGrid(nobukti)

    $('.select2').select2({
      width: 'resolve',
      theme: "bootstrap4"
    });

    @isset($request['tgldari'])
    tgldariheader = `{{ $request['tgldari'] }}`;
    @endisset
    @isset($request['tglsampai'])
    tglsampaiheader = `{{ $request['tglsampai'] }}`;
    @endisset
    setRange(false, tgldariheader, tglsampaiheader)
    initDatepicker('datepickerIndex')
    $(document).on('click', '#btnReload', function(event) {
      loadDataHeader('penerimaantruckingheader', {
        penerimaanheader_id: $('#penerimaanheader_id').val()
      })

      selectedRows = []
      selectedbukti = []
      $('#gs_').prop('checked', false)
    })

    var grid = $("#jqGrid");
    grid.jqGrid({
        url: `{{ config('app.api_url') . 'penerimaantruckingheader' }}`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        postData: {
          tgldari: $('#tgldariheader').val(),
          tglsampai: $('#tglsampaiheader').val(),
          penerimaanheader_id: $('#penerimaanheader_id').val(),
        },
        datatype: "json",
        colModel: [{
            label: '',
            name: '',
            width: 40,
            align: 'center',
            sortable: false,
            clear: false,
            stype: 'input',
            searchable: false,
            searchoptions: {
              type: 'checkbox',
              clearSearch: false,
              dataInit: function(element) {
                $(element).removeClass('form-control')
                $(element).parent().addClass('text-center')
                $(element).addClass('checkbox-selectall')

                $(element).on('click', function() {
                  $(element).attr('disabled', true)
                  if ($(this).is(':checked')) {
                    selectAllRows()
                  } else {
                    clearSelectedRows()
                  }
                })

              }
            },
            formatter: (value, rowOptions, rowData) => {
              return `<input type="checkbox" name="Idindex[]" class="checkbox-jqgrid" value="${rowData.id}" onchange="checkboxHandlerIndex(this)">`
            },
          },
          {
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
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
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
            label: 'NO BUKTI',
            name: 'nobukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left'
          },
          {
            label: 'TGL BUKTI',
            name: 'tglbukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'PENERIMAAN TRUCKING ',
            width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
            name: 'penerimaantrucking_id',
            align: 'left'
          },
          {
            label: 'BANK',
            name: 'bank_id',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left'
          },
          {
            label: 'KODE PERKIRAAN',
            name: 'coa',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            align: 'left'
          },
          {
            label: 'NO BUKTI PENERIMAAN',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            name: 'penerimaan_nobukti',
            align: 'left',
            formatter: (value, options, rowData) => {
              if ((value == null) || (value == '')) {
                return '';
              }
              let tgldari = rowData.tgldariheaderpenerimaanheader
              let tglsampai = rowData.tglsampaiheaderpenerimaanheader
              let bankpenerimaan = rowData.penerimaanbank_id
              let url = "{{route('penerimaanheader.index')}}"
              let formattedValue = $(`
              <a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}&nobukti=${value}&bank_id=${bankpenerimaan}" class="link-color" target="_blank">${value}</a>
             `)
              return formattedValue[0].outerHTML
            }
          },
          {
            label: 'SUPIR',
            name: 'supir_id',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            align: 'left'
          },
          {
            label: 'KARYAWAN',
            name: 'karyawan_id',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            align: 'left'
          },
          {
            label: 'KETERANGAN',
            name: 'keteranganheader',
            width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
            align: 'left'
          },
          {
            label: 'USER BUKA CETAK',
            name: 'userbukacetak',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left'
          },
          {
            label: 'TGL BUKA CETAK',
            name: 'tglbukacetak',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'MODIFIED BY',
            name: 'modifiedby',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left'
          },
          {
            label: 'CREATED AT',
            name: 'created_at',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
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
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
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
        onSelectRow: onSelectRowFunction = function(id) {
          let nobukti = $(`#jqGrid tr#${id}`).find(`td[aria-describedby="jqGrid_penerimaan_nobukti"]`).attr('title') ?? '';
          activeGrid = grid
          indexRow = grid.jqGrid('getCell', id, 'rn') - 1
          page = grid.jqGrid('getGridParam', 'page')
          let limit = grid.jqGrid('getGridParam', 'postData').limit
          if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))

          loadDetailData(id)
          loadPenerimaanData(id, nobukti)
          loadJurnalUmumData(id, nobukti)
        },
        loadComplete: function(data) {
          changeJqGridRowListText()

          if (data.data.length === 0) {
            $('#detail, #jurnalGrid, #penerimaanGrid').each((index, element) => {
              abortGridLastRequest($(element))
              clearGridData($(element))
            })
            $('#jqGrid').each((index, element) => {
              abortGridLastRequest($(element))
              clearGridHeader($(element))
            })
          }

          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))
          $.each(selectedRows, function(key, value) {

            $('#jqGrid tbody tr').each(function(row, tr) {
              if ($(this).find(`td input:checkbox`).val() == value) {
                $(this).find(`td input:checkbox`).prop('checked', true)
                $(this).addClass('bg-light-blue')
              }
            })

          });

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

          $('#left-nav').find('button').attr('disabled', false)
          permission()
          $('#gs_').attr('disabled', false)
          setPermissionAcos()
          getQueryParameter()
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
          $('#left-nav').find(`button:not(#add)`).attr('disabled', 'disabled')
          clearGlobalSearch($('#jqGrid'))
        },
      })

      .customPager({


        buttons: [{
            id: 'add',
            innerHTML: '<i class="fa fa-plus"></i> ADD',
            class: 'btn btn-primary btn-sm mr-1',
            onClick: function(event) {
              createPenerimaanTruckingHeader()
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
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Harap pilih salah satu record')
              } else {
                viewPenerimaanTruckingHeader(selectedId)
              }
            }
          },
        ],
        modalBtnList: [{
            id: 'report',
            title: 'Report',
            caption: 'Report',
            innerHTML: '<i class="fa fa-print"></i> REPORT',
            class: 'btn btn-info btn-sm mr-1',
            item: [{
                id: 'reportPrinterBesar',
                text: "Printer Lain(Faktur)",
                color: `<?php echo $data['listbtn']->btn->reportPrinterBesar; ?>`,
                onClick: () => {
                  selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                  if (selectedId == null || selectedId == '' || selectedId == undefined) {
                    showDialog('Harap pilih salah satu record')
                  } else {
                    cekValidasi(selectedId, 'PRINTER BESAR')
                  }
                }
              },
              {
                id: 'reportPrinterKecil',
                text: "Printer Epson Seri LX(Faktur)",
                color: `<?php echo $data['listbtn']->btn->reportPrinterKecil; ?>`,
                onClick: () => {
                  selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                  if (selectedId == null || selectedId == '' || selectedId == undefined) {
                    showDialog('Harap pilih salah satu record')
                  } else {
                    cekValidasi(selectedId, 'PRINTER KECIL')
                  }
                }
              },

            ],
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
                window.open(`{{ route('penerimaantruckingheader.export') }}?id=${selectedId}`)
              }
            }
          }, {
            id: 'approve',
            title: 'Approve',
            caption: 'Approve',
            innerHTML: '<i class="fa fa-check"></i> APPROVAL/UN',
            class: 'btn btn-purple btn-sm mr-1',
            item: [
              // {
              //   id: 'approveun',
              //   text: "APPROVAL/UN Status penerimaan",
              //   onClick: () => {
              //     approve()
              //   }
              // },
              {
                id: 'approval-buka-cetak',
                text: "Approval Buka Cetak PENERIMAAN TRUCKING",
                color: `<?php echo $data['listbtn']->btn->approvalbukacetak; ?>`,
                hidden:(!`{{ $myAuth->hasPermission('penerimaantruckingheader', 'approvalbukacetak') }}`),
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('penerimaantruckingheader', 'approvalbukacetak') }}`) {
                    let tglbukacetak = $('#tgldariheader').val().split('-');
                    tglbukacetak = tglbukacetak[1] + '-' + tglbukacetak[2];

                    approvalBukaCetak(tglbukacetak, 'PENERIMAANTRUCKINGHEADER', selectedRows, selectedbukti);

                  }
                }
              },
              {
                id: 'approval-kirim-berkas',
                text: "APPROVAL/UN Kirim Berkas PENERIMAAN TRUCKING",
                color: `<?php echo $data['listbtn']->btn->approvalkirimberkas; ?>`,
                hidden:(!`{{ $myAuth->hasPermission('penerimaantruckingheader', 'approvalkirimberkas') }}`),
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('penerimaantruckingheader', 'approvalkirimberkas') }}`) {
                    let tglkirimberkas = $('#tgldariheader').val().split('-');
                    tglkirimberkas = tglkirimberkas[1] + '-' + tglkirimberkas[2];

                    approvalKirimBerkas(tglkirimberkas, 'PENERIMAANTRUCKINGHEADER', selectedRows, selectedbukti);

                  }
                }
              },
            ],
          }
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

  })


  function permission() {
    if (!`{{ $myAuth->hasPermission('penerimaantruckingheader', 'store') }}`) {
      $('#add').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('penerimaangiroheader', 'show') }}`) {
      $('#view').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('penerimaantruckingheader', 'update') }}`) {
      $('#edit').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('penerimaantruckingheader', 'destroy') }}`) {
      $('#delete').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('penerimaantruckingheader', 'export') }}`) {
      $('#export').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('penerimaantruckingheader', 'report') }}`) {
      $('#report').attr('disabled', 'disabled')
    }

    let hakApporveCount = 0;
    hakApporveCount++
    if (!`{{ $myAuth->hasPermission('penerimaantruckingheader', 'approvalbukacetak') }}`) {
      hakApporveCount--
      $('#approval-buka-cetak').hide()
      // $('#approval-buka-cetak').attr('disabled', 'disabled')
    }
    hakApporveCount++
    if (!`{{ $myAuth->hasPermission('penerimaantruckingheader', 'approvalkirimberkas') }}`) {
      hakApporveCount--
      $('#approval-kirim-berkas').hide()
      // $('#approval-buka-cetak').attr('disabled', 'disabled')
    }
    if (hakApporveCount < 1) {
      $('#approve').hide()
      // $('#approve').attr('disabled', 'disabled')
    }
  }

  function clearSelectedRows() {
    selectedRows = []
    selectedbukti = []

    $('#gs_').prop('checked', false)
    $('#jqGrid').trigger('reloadGrid')
  }

  function selectAllRows() {
    $.ajax({
      url: `${apiUrl}penerimaantruckingheader`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        limit: 0,
        tgldari: $('#tgldariheader').val(),
        tglsampai: $('#tglsampaiheader').val(),
        penerimaanheader_id: $('#penerimaanheader_id').val(),
        filters: $('#jqGrid').jqGrid('getGridParam', 'postData').filters
      },
      success: (response) => {
        selectedRows = response.data.map((datas) => datas.id)
        selectedbukti = response.data.map((datas) => datas.nobukti)
        $('#jqGrid').trigger('reloadGrid')
      }
    })
  }
</script>
@endpush()
@endsection