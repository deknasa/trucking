@extends('layouts.master')
@push('addtional-field')
<div class="form-group row">
  <label class="col-12 col-sm-2 col-form-label mt-2">pengeluaran trucking<span class="text-danger">*</span></label>
  <div class="col-sm-4 mt-2">
    <select name="pengeluaranheader_id" id="pengeluaranheader_id" class="form-select select2" style="width: 100%;">
      <option value="">-- SEMUA --</option>
      @foreach ($comboKodepengeluaran as $kodepengeluaran)
      <option value="{{$kodepengeluaran['id']}}"> {{$kodepengeluaran['keterangan']}} </option>
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
              <table id="detail"></table>
            </div>
            <div id="pengeluaran-tab">
              <table id="pengeluaranGrid"></table>
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
  let dataAcos = <?php echo json_encode($acosPengeluaran); ?>;
  let rowNum = 10
  let hasDetail = false
  let activeGrid
  let currentTab = 'detail'
  let tgldariheader
  let tglsampaiheader
  let selectedRowsIndex = [];
  let selectedbukti = [];

  reloadGrid()

  function checkboxHandlerIndex(element) {
    let value = $(element).val();

    var onSelectRowExisting = $("#jqGrid").jqGrid('getGridParam', 'onSelectRow');
    $("#jqGrid").jqGrid('setSelection', value, false);
    onSelectRowExisting(value)
    let valuebukti = $(`#jqGrid tr#${value}`).find(`td[aria-describedby="jqGrid_nobukti"]`).attr('title');

    if (element.checked) {
      selectedRowsIndex.push($(element).val())
      selectedbukti.push(valuebukti)
      $(element).parents('tr').addClass('bg-light-blue')
    } else {
      $(element).parents('tr').removeClass('bg-light-blue')
      for (var i = 0; i < selectedRowsIndex.length; i++) {
        if (selectedRowsIndex[i] == value) {
          selectedRowsIndex.splice(i, 1);
        }
      }

      if (selectedRowsIndex.length != $('#jqGrid').jqGrid('getGridParam').records) {
        $('#gs_').prop('checked', false)
      }
      for (var i = 0; i < selectedbukti.length; i++) {
        if (selectedbukti[i] == valuebukti) {
          selectedbukti.splice(i, 1);
        }
      }
    }

  }

  setSpaceBarCheckedHandler2()
  $(document).on('change', $('#crudForm').find('[name=pengeluaranheader_id]'), function(event) {
    setPermissionAcos()
  })

  function setPermissionAcos() {
    let selectedIdPengeluaran = $(`[name="pengeluaranheader_id"] option:selected`).val();
    if (selectedIdPengeluaran != '') {
      let isKodepengeluaranInData = dataAcos.some(item => parseInt(item.id) == selectedIdPengeluaran);
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
    // $("#pengeluaranheader_id").val($("#pengeluaranheader_id option:eq(1)").val()).trigger('change');
    $("#tabs").tabs()
    pengeluaranTrucking($('#crudForm'))
    let nobukti = $('#jqGrid').jqGrid('getCell', id, 'pengeluaran_nobukti')
    loadDetailGrid()
    loadPengeluaranGrid(nobukti)
    loadJurnalUmumGrid(nobukti)

    initSelect2($('#pengeluaranheader_id'), false)

    @isset($request['tgldari'])
    tgldariheader = `{{ $request['tgldari'] }}`;
    @endisset
    @isset($request['tglsampai'])
    tglsampaiheader = `{{ $request['tglsampai'] }}`;
    @endisset
    setRange(false, tgldariheader, tglsampaiheader)
    initDatepicker('datepickerIndex')
    $(document).on('click', '#btnReload', function(event) {
      console.log($('#pengeluaranheader_id').val());
      loadDataHeader('pengeluarantruckingheader', {
        pengeluaranheader_id: $('#pengeluaranheader_id').val()
      })
      selectedRowsIndex = []
      selectedbukti = []
      $('#gs_').prop('checked', false)
    })

    var grid = $("#jqGrid");
    grid.jqGrid({
        url: `{{ config('app.api_url') . 'pengeluarantruckingheader' }}`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        postData: {
          tgldari: $('#tgldariheader').val(),
          tglsampai: $('#tglsampaiheader').val(),
          pengeluaranheader_id: $('#pengeluaranheader_id').val(),

        },
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
                    clearSelectedRowsIndex()
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
            label: 'PENGELUARAN TRUCKING ',
            width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
            name: 'pengeluarantrucking_id',
            align: 'left'
          },
          {
            label: 'NO BUKTI PENERIMAAN TRUCKING',
            width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
            name: 'penerimaantrucking_nobukti',
            align: 'left',
            formatter: (value, options, rowData) => {
              if ((value == null) || (value == '')) {
                return '';
              }
              //   let tgldari = rowData.tgldariheaderpenerimaantrucking
              //   let tglsampai = rowData.tglsampaiheaderpenerimaantrucking
              //   let url = "{{route('penerimaantruckingheader.index')}}"
              //   let formattedValue = $(`
              //   <a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}" class="link-color" target="_blank">${value}</a>
              //  `)
              return value
            }
          },
          {
            label: 'BANK',
            name: 'bank_id',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left'
          },
          {
            label: 'STATUS POSTING',
            name: 'statusposting',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
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
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            align: 'left'
          },
          {
            label: 'trado',
            name: 'trado',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left'
          },
          {
            label: 'gandengan',
            name: 'gandengan',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left'
          },
          {
            label: 'karyawan',
            name: 'karyawan',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            align: 'left'
          },
          {
            label: 'NO BUKTI Pengeluaran Trucking',
            name: 'pengeluarantrucking_nobukti',
            width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
            align: 'left',
            formatter: (value, options, rowData) => {
              if ((value == null) || (value == '')) {
                return '';
              }
              let tgldari = rowData.tgldariheaderpengeluarantruckingheader
              let tglsampai = rowData.tglsampaiheaderpengeluarantruckingheader
              let url = "{{route('pengeluarantruckingheader.index')}}"
              let formattedValue = $(`
              <a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}&nobukti=${value}" class="link-color" target="_blank">${value}</a>
             `)
              return formattedValue[0].outerHTML
            }
          },
          {
            label: 'KODE PERKIRAAN',
            name: 'coa',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            align: 'left'
          },
          {
            label: 'NO BUKTI pengeluaran',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            name: 'pengeluaran_nobukti',
            align: 'left',
            formatter: (value, options, rowData) => {
              if ((value == null) || (value == '')) {
                return '';
              }
              let tgldari = rowData.tgldariheaderpengeluaranheader
              let tglsampai = rowData.tglsampaiheaderpengeluaranheader
              let bankpengeluaran = rowData.pengeluaranbank_id
              let url = "{{route('pengeluaranheader.index')}}"
              let formattedValue = $(`
              <a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}&nobukti=${value}&bank_id=${bankpengeluaran}" class="link-color" target="_blank">${value}</a>
             `)
              return formattedValue[0].outerHTML
            }
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
            label: 'STATUS KIRIM BERKAS',
            name: 'statuskirimberkas',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
            stype: 'select',
            searchoptions: {

              value: `<?php
                      $i = 1;

                      foreach ($data['combokirimberkas'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['combokirimberkas'])) {
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
              let statusKirimBerkas = JSON.parse(value)
              if (!statusKirimBerkas) {
                return ``
              }
              let formattedValue = $(`
                                <div class="badge" style="background-color: ${statusKirimBerkas.WARNA}; color: #fff;">
                                <span>${statusKirimBerkas.SINGKATAN}</span>
                                </div>
                            `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusKirimBerkas = JSON.parse(rowObject.statuskirimberkas)
              if (!statusKirimBerkas) {
                return ` title=""`
              }
              return ` title="${statusKirimBerkas.MEMO}"`
            }
          },
          {
            label: 'USER KIRIM BERKAS',
            name: 'userkirimberkas',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left'
          },
          {
            label: 'TGL KIRIM BERKAS',
            name: 'tglkirimberkas',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y H:i:s"
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
          let nobukti = $(`#jqGrid tr#${id}`).find(`td[aria-describedby="jqGrid_pengeluaran_nobukti"]`).attr('title') ?? '';
          //loadDetailData(id)
          activeGrid = grid
          indexRow = grid.jqGrid('getCell', id, 'rn') - 1
          page = grid.jqGrid('getGridParam', 'page')
          let limit = grid.jqGrid('getGridParam', 'postData').limit
          if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))

          loadDetailData(id)
          loadPengeluaranData(id, nobukti)
          loadJurnalUmumData(id, nobukti)
        },
        loadComplete: function(data) {
          changeJqGridRowListText()

          if (data.data.length === 0) {
            $('#detail, #jurnalGrid, #pengeluaranGrid').each((index, element) => {
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
          $.each(selectedRowsIndex, function(key, value) {

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
          getQueryParameter()
          setPermissionAcos()
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
                viewPengeluaranTruckingHeader(selectedId)
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
                // window.open(`{{ route('pengeluarantruckingheader.export') }}?id=${selectedId}`)
                $.ajax({
                  url: `${apiUrl}pengeluarantruckingheader/${selectedId}/export`,
                  type: 'GET',
                  data: {
                    forReport: true,
                    pengeluarantruckingheader_id: selectedId,
                    export : true
                  },
                  beforeSend: function(xhr) {
                    xhr.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`);
                  },
                  xhrFields: {
                    responseType: 'arraybuffer'
                  },
                  success: function(response, status, xhr) {
                    if (xhr.status === 200) {
                      var filename = xhr.getResponseHeader('Filename');
                      if (response !== undefined) {
                        var blob = new Blob([response], {
                          type: 'cabang/vnd.ms-excel'
                        });
                        var link = document.createElement('a');
                        link.href = window.URL.createObjectURL(blob);
                        link.download = filename + '.xlsx';
                        link.click();
                      }
                    }
                    $('#processingLoader').addClass('d-none')
                  },
                  error: function(xhr, status, error) {
                    $('#processingLoader').addClass('d-none')
                    showDialog('TIDAK ADA DATA')
                  }
                })
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
                text: "Approval Buka Cetak PENGELUARAN TRUCKING",
                color: `<?php echo $data['listbtn']->btn->approvalbukacetak; ?>`,
                hidden: (!`{{ $myAuth->hasPermission('pengeluarantruckingheader', 'approvalbukacetak') }}`),
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('pengeluarantruckingheader', 'approvalbukacetak') }}`) {
                    let tglbukacetak = $('#tgldariheader').val().split('-');
                    tglbukacetak = tglbukacetak[1] + '-' + tglbukacetak[2];

                    approvalBukaCetak(tglbukacetak, 'PENGELUARANTRUCKINGHEADER', selectedRowsIndex, selectedbukti);

                  }
                }
              },
              {
                id: 'approval-kirim-berkas',
                text: "APPROVAL/UN Kirim Berkas PENGELUARAN TRUCKING",
                color: `<?php echo $data['listbtn']->btn->approvalkirimberkas; ?>`,
                hidden: (!`{{ $myAuth->hasPermission('pengeluarantruckingheader', 'approvalkirimberkas') }}`),
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('pengeluarantruckingheader', 'approvalkirimberkas') }}`) {
                    let tglkirimberkas = $('#tgldariheader').val().split('-');
                    tglkirimberkas = tglkirimberkas[1] + '-' + tglkirimberkas[2];

                    approvalKirimBerkas(tglkirimberkas, 'PENGELUARANTRUCKINGHEADER', selectedRowsIndex, selectedbukti);

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




    // $("#tabs").on('click', 'li.ui-state-active', function() {
    //   let href = $(this).find('a').attr('href');
    //   currentTab = href.substring(1, href.length - 4);
    //   let hutangBayarId = $('#jqGrid').jqGrid('getGridParam', 'selrow')
    //   let nobukti = $('#jqGrid').jqGrid('getCell', hutangBayarId, 'pengeluaran_nobukti')
    //   $(`#tabs #${currentTab}-tab`).html('').load(`${appUrl}/pengeluarantruckingdetail/${currentTab}/grid`, function() {

    //     loadGrid(hutangBayarId, nobukti)
    //   })
    // })

  })

  function permission() {
    if (!`{{ $myAuth->hasPermission('pengeluarantruckingheader', 'store') }}`) {
      $('#add').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('pengeluaranstokheader', 'show') }}`) {
      $('#view').attr('disabled', 'disabled')
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

    let hakApporveCount = 0;
    hakApporveCount++
    if (!`{{ $myAuth->hasPermission('pengeluarantruckingheader', 'approvalbukacetak') }}`) {
      hakApporveCount--
      $('#approval-buka-cetak').hide()
      // $('#approval-buka-cetak').attr('disabled', 'disabled')
    }
    hakApporveCount++
    if (!`{{ $myAuth->hasPermission('pengeluarantruckingheader', 'approvalkirimberkas') }}`) {
      hakApporveCount--
      $('#approval-kirim-berkas').hide()
      // $('#approval-buka-cetak').attr('disabled', 'disabled')
    }
    if (hakApporveCount < 1) {
      $('#approve').hide()
      // $('#approve').attr('disabled', 'disabled')
    }
  }

  function clearSelectedRowsIndex() {
    selectedRowsIndex = []
    selectedbukti = []

    $('#gs_').prop('checked', false)
    $('#jqGrid').trigger('reloadGrid')
  }

  function selectAllRows() {
    $.ajax({
      url: `${apiUrl}pengeluarantruckingheader`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        limit: 0,
        tgldari: $('#tgldariheader').val(),
        tglsampai: $('#tglsampaiheader').val(),
        pengeluaranheader_id: $('#pengeluaranheader_id').val(),
        filters: $('#jqGrid').jqGrid('getGridParam', 'postData').filters
      },
      success: (response) => {
        selectedRowsIndex = response.data.map((row) => row.id)
        selectedbukti = response.data.map((datas) => datas.nobukti)
        $('#jqGrid').trigger('reloadGrid')
      }
    })
  }
</script>
@endpush()
@endsection