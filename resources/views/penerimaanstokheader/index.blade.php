@extends('layouts.master')
@push('addtional-field')
<div class="form-group row">
  <label class="col-12 col-sm-2 col-form-label mt-2">penerimaan stok </label>
  <div class="col-sm-4 mt-2">
    <select name="kodepenerimaanheader" id="kodepenerimaanheader" class="form-select select2" style="width: 100%;">
      <option value="">-- semua --</option>
      @foreach ($comboKodepenerimaan as $kodepenerimaan)
      {{-- @if ($kodepenerimaan['id'] === "1") selected @endif --}}
      <option value="{{$kodepenerimaan['id']}}"> {{$kodepenerimaan['keterangan']}} ({{$kodepenerimaan['kodepenerimaan']}}) </option>
      {{-- <option @if ($kodepenerimaan['statusdefault_text'] ==="YA") selected @endif value="{{$kodepenerimaan['id']}}"> {{$kodepenerimaan['namakodepenerimaan']}} </option> --}}
      @endforeach

    </select>
  </div>
</div>
@endpush


@section('content')
<!-- Grid -->
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
              <li><a href="#hutang-tab">Hutang</a></li>
              <li><a href="#jurnal-tab">Jurnal</a></li>
            </ul>
            <div id="detail-tab">
              <table id="detail"></table>
            </div>

            <div id="hutang-tab">
              <table id="hutangGrid"></table>
            </div>
            <div id="jurnal-tab">
              <table id="jurnalGrid"></table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  {{-- @isset($request['tgldari']) ? $request['tgldari'] : 'null' }} --}}


</div>
@include('penerimaanstokheader._modal')
<!-- Detail -->
@include('penerimaanstokheader._detail')
@include('penerimaanstokheader._hutang')
@include('jurnalumum._jurnal')

@push('scripts')
<script>
  let indexUrl = "{{ route('penerimaanstokheader.index') }}"
  let getUrl = "{{ route('penerimaanstokheader.get') }}"
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
  let currentTab = 'detail'
  let parampostok
  let activeGrid
  let dataAcos = <?php echo json_encode($acosPenerimaan); ?>;
  let approveEditRequest = null;
  let tgldariheader
  let tglsampaiheader

  let selectedRows = [];

  let selectedbukti = [];

  function checkboxHandler(element) {
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

      if (selectedbukti.length != $('#jqGrid').jqGrid('getGridParam').records) {
        $('#gs_').prop('checked', false)
      }

    }

  }


  function clearSelectedRows() {
    selectedRows = []
    selectedbukti = []
    $('#gs_').prop('checked', false);
    $('#jqGrid').trigger('reloadGrid')
  }

  function selectAllRows() {
    $.ajax({
      url: `${apiUrl}penerimaanstokheader`,
      method: 'GET',
      dataType: 'JSON',
      headers: {
        Authorization: `Bearer ${accessToken}`
      },
      data: {
        limit: 0,
        tgldari: $('#tgldariheader').val(),
        tglsampai: $('#tglsampaiheader').val(),
        filters: $('#jqGrid').jqGrid('getGridParam', 'postData').filters
      },
      success: (response) => {
        selectedRows = response.data.map((penerimaanstokheader) => penerimaanstokheader.id)
        selectedbukti = response.data.map((penerimaanstokheader) => penerimaanstokheader.nobukti)
        $('#jqGrid').trigger('reloadGrid')
      }
    })
  }
  reloadGrid()
  setSpaceBarCheckedHandler()

  $(document).on('change', $('#crudForm').find('[name=kodepenerimaanheader]'), function(event) {
    setPermissionAcos()
  })

  function setPermissionAcos() {
    let selectedIdPenerimaan = $(`[name="kodepenerimaanheader"] option:selected`).val();
    if (selectedIdPenerimaan != '') {
      let isKodepenerimaanInData = dataAcos.some(item => parseInt(item.id) == selectedIdPenerimaan);
      if (isKodepenerimaanInData) {
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
    // $("#kodepenerimaanheader").val($("#kodepenerimaanheader option:eq(1)").val()).trigger('change');
    penerimaanStok($('#crudForm'))
    $("#tabs").tabs()

    let nobukti = $('#jqGrid').jqGrid('getCell', id, 'hutang_nobukti')
    loadDetailGrid()
    loadHutangGrid(nobukti)
    loadJurnalUmumGrid(nobukti)

    initSelect2($(`#kodepenerimaanheader`), false)

    @isset($request['tgldari'])
    tgldariheader = `{{ $request['tgldari'] }}`;
    @endisset
    @isset($request['tglsampai'])
    tglsampaiheader = `{{ $request['tglsampai'] }}`;
    @endisset
    setRange(false, tgldariheader, tglsampaiheader)
    initDatepicker('datepickerIndex')
    $(document).on('click', '#btnReload', function(event) {
      loadDataHeader('penerimaanstokheader', {
        penerimaanheader_id: $('#kodepenerimaanheader').val(),
        proses: 'reload'
      })
      selectedRows = []
      selectedbukti = []
      $('#gs_').prop('checked', false)
    })

    $('#crudModal').on('hidden.bs.modal', function() {
      activeGrid = '#jqGrid'
    })

    var grid = $("#jqGrid");
    grid.jqGrid({
        url: `{{ config('app.api_url') . 'penerimaanstokheader' }}`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        postData: {
          tgldari: $('#tgldariheader').val(),
          tglsampai: $('#tglsampaiheader').val(),
          penerimaanheader_id: $('#kodepenerimaanheader').val(),
        },
        datatype: "json",
        colModel: [{
            label: '',
            name: '',
            width: 30,
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
              return `<input type="checkbox" name="Id[]" value="${rowData.id}" onchange="checkboxHandler(this)">`
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
            align: 'left',
            stype: 'select',
            searchoptions: {

              value: `<?php
                      $i = 1;

                      foreach ($data['combocetak'] as $status) :
                        echo "$status[id]:$status[parameter]";
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
            label: 'PENERIMAAN Stok',
            name: 'penerimaanstok',
            align: 'left'
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
            hidden: true,
            align: 'left'
          },
          {
            label: 'Penerimaan no bukti',
            width: 200,
            name: 'penerimaanstok_nobukti',
            align: 'left',
            formatter: (value, options, rowData) => {
              if ((value == null) || (value == '')) {
                return '';
              }
              let tgldari = rowData.tgldariheadernobuktipenerimaanstok
              let tglsampai = rowData.tglsampaiheadernobuktipenerimaanstok
              let url = "{{route('penerimaanstokheader.index')}}"
              let formattedValue = $(`
              <a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}&nobukti=${value}" class="link-color" target="_blank">${value}</a>
             `)
              return formattedValue[0].outerHTML
            }
          },
          {
            label: 'Pengeluaran no bukti',
            width: 200,
            name: 'pengeluaranstok_nobukti',
            align: 'left',
            formatter: (value, options, rowData) => {
              if ((value == null) || (value == '')) {
                return '';
              }
              let tgldari = rowData.tgldariheaderpengeluaranstok
              let tglsampai = rowData.tglsampaiheaderpengeluaranstok
              let url = "{{route('pengeluaranstokheader.index')}}"
              let formattedValue = $(`
              <a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}&nobukti=${value}" class="link-color" target="_blank">${value}</a>
             `)
              return formattedValue[0].outerHTML
            }
          },
          {
            label: 'nominal',
            name: 'nominal',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'Gudang',
            name: 'gudang',
            align: 'left'
          },
          {
            label: 'Trado',
            name: 'trado',
            align: 'left'
          },
          {
            label: 'supplier',
            name: 'supplier',
            align: 'left'
          },
          {
            label: 'no bon',
            name: 'nobon',
            align: 'left'
          },
          {
            label: 'NO BUKTI Hutang',
            name: 'hutang_nobukti',
            align: 'left',
            formatter: (value, options, rowData) => {
              if ((value == null) || (value == '')) {
                return '';
              }
              let tgldari = rowData.tgldariheaderhutangheader
              let tglsampai = rowData.tglsampaiheaderhutangheader
              let url = "{{route('hutangheader.index')}}"
              let formattedValue = $(`
              <a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}&nobukti=${value}" class="link-color" target="_blank">${value}</a>
             `)
              return formattedValue[0].outerHTML
            }
          },
          {
            label: 'approval PG spk',
            name: 'statusapprovalpindahgudangspk',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
            stype: 'select',
            searchoptions: {
            dataInit: function(element) {
              $(element).select2({
                width: 'resolve',
                theme: "bootstrap4",
                ajax: {
                  url: `${apiUrl}parameter/combo`,
                  dataType: 'JSON',
                  headers: {
                    Authorization: `Bearer ${accessToken}`
                  },
                  data: {
                    grp: 'STATUS APPROVAL',
                    subgrp: 'STATUS APPROVAL'
                  },
                  beforeSend: () => {
                    // clear options
                    $(element).data('select2').$results.children().filter((index, element) => {
                      // clear options except index 0, which
                      // is the "searching..." label
                      if (index > 0) {
                        element.remove()
                      }
                    })
                  },
                  processResults: (response) => {
                    let formattedResponse = response.data.map(row => ({
                      id: row.id,
                      text: row.text
                    }));

                    formattedResponse.unshift({
                      id: '',
                      text: 'ALL'
                    });

                    return {
                      results: formattedResponse
                    };
                  },
                }
              });
            }
          },
            formatter: (value, options, rowData) => {
              if (!value) {
                return ``
              }
              let apppgspk = JSON.parse(value)
              if (!apppgspk) {
                return ``
              }
              let formattedValue = $(`
                <div class="badge" style="background-color: ${apppgspk.WARNA}; color: #fff;">
                  <span>${apppgspk.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              if (!rowObject) {
                return ` title=""`
              }
              let apppgspk = JSON.parse(rowObject.statusapprovalpindahgudangspk)
              if (!apppgspk) {
                return ` title=""`
              }
              return ` title="${apppgspk.MEMO}"`
            }
          },
          {
            label: 'gudang dari',
            name: 'gudangdari',
            align: 'left'
          },
          {
            label: 'trado dari',
            name: 'tradodari',
            align: 'left'
          },
          {
            label: 'gandengan dari',
            name: 'gandengandari',
            align: 'left'
          },
          {
            label: 'gudang ke',
            name: 'gudangke',
            align: 'left'
          },
          {
            label: 'trado ke',
            name: 'tradoke',
            align: 'left'
          },
          {
            label: 'gandengan ke',
            name: 'gandenganke',
            align: 'left'
          },
          {
            label: 'KODE PERKIRAAN',
            name: 'coa',
            align: 'left'
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
                        echo "$status[id]:$status[parameter]";
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
        onSelectRow: onSelectRowFunction =function(id) {
          let penerimaanstok = $(`#jqGrid tr#${id}`).find(`td[aria-describedby="jqGrid_penerimaanstok"]`).attr('title') ?? '';
          let nobukti = $(`#jqGrid tr#${id}`).find(`td[aria-describedby="jqGrid_nobukti"]`).attr('title') ?? '';
          loadDetailData(id,nobukti)
          if (penerimaanstok == "SPB" || penerimaanstok == "SPBS") {
            nobukti = $(`#jqGrid tr#${id}`).find(`td[aria-describedby="jqGrid_hutang_nobukti"]`).attr('title') ?? '';
          }

          activeGrid = grid
          indexRow = grid.jqGrid('getCell', id, 'rn') - 1
          page = grid.jqGrid('getGridParam', 'page')
          let limit = grid.jqGrid('getGridParam', 'postData').limit
          if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))

          
          loadHutangData(id, nobukti)
          loadJurnalUmumData(id, nobukti)
        },
        loadComplete: function(data) {
          changeJqGridRowListText()

          if (data.data.length === 0) {
            $('#detail, #hutangGrid, #jurnalGrid').each((index, element) => {
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
          setPermissionAcos()
          $('#gs_').attr('disabled', false)
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
              createPenerimaanstokHeader()
            }
          },
          {
            id: 'edit',
            innerHTML: '<i class="fa fa-pen"></i> EDIT',
            class: 'btn btn-success btn-sm mr-1',
            onClick: function(event) {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              rawCellValue = $("#jqGrid").jqGrid('getCell', selectedId, 'nobukti');
              celValue = $("<div>").html(rawCellValue).text();
              selectednobukti = celValue
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Harap pilih salah satu record')
              } else {
                cekValidasi(selectedId, 'EDIT', selectednobukti)
              }
            }
          },
          {
            id: 'delete',
            innerHTML: '<i class="fa fa-trash"></i> DELETE',
            class: 'btn btn-danger btn-sm mr-1',
            onClick: () => {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              rawCellValue = $("#jqGrid").jqGrid('getCell', selectedId, 'nobukti');
              celValue = $("<div>").html(rawCellValue).text();
              selectednobukti = celValue
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Harap pilih salah satu record')
              } else {
                cekValidasi(selectedId, 'DELETE', selectednobukti)
              }
            }
          },
          {
            id: 'view',
            innerHTML: '<i class="fa fa-eye"></i> VIEW',
            class: 'btn btn-orange btn-sm mr-1',
            onClick: () => {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              rawCellValue = $("#jqGrid").jqGrid('getCell', selectedId, 'nobukti');
              celValue = $("<div>").html(rawCellValue).text();
              selectednobukti = celValue
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog('Harap pilih salah satu record')
              } else {
                // viewPenerimaanstokHeader(selectedId)
                cekValidasi(selectedId, 'VIEW', selectednobukti)
              }
            }
          },


        ],
        modalBtnList: [{
            id: 'report',
            title: 'report',
            caption: 'report',
            innerHTML: '<i class="fa fa-print"></i> REPORT',
            class: 'btn btn-info btn-sm mr-1 ',
            item: [{
                id: 'reportPrinterBesar',
                text: 'Printer Lain(Faktur)',
                color: `<?php echo $data['listbtn']->btn->reportPrinterBesar; ?>`,
                onClick: () => {
                  selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                  rawCellValue = $("#jqGrid").jqGrid('getCell', selectedId, 'nobukti');
                  celValue = $("<div>").html(rawCellValue).text();
                  selectednobukti = celValue
                  if (selectedId == null || selectedId == '' || selectedId == undefined) {
                    showDialog('Harap pilih salah satu record')
                  } else {
                    cekValidasi(selectedId, 'PRINTER BESAR', selectednobukti)
                  }
                }
              },
              {
                id: 'reportPrinterKecil',
                text: "Printer Epson Seri LX(Faktur)",
                color: `<?php echo $data['listbtn']->btn->reportPrinterKecil; ?>`,
                onClick: () => {
                  selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                  rawCellValue = $("#jqGrid").jqGrid('getCell', selectedId, 'nobukti');
                  celValue = $("<div>").html(rawCellValue).text();
                  selectednobukti = celValue
                  if (selectedId == null || selectedId == '' || selectedId == undefined) {
                    showDialog('Harap pilih salah satu record')
                  } else {
                    cekValidasi(selectedId, 'PRINTER KECIL', selectednobukti)
                  }
                }
              },
            ]
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
                window.open(`{{ route('penerimaanstokheader.export') }}?id=${selectedId}`)
              }
            }
          },
          {
            id: 'approve',
            title: 'Approve',
            caption: 'Approve',
            innerHTML: '<i class="fa fa-check"></i> APPROVAL/UN',
            class: 'btn btn-purple btn-sm mr-1 ',
            item: [{
                id: 'approvalEdit',
                text: ' APPROVAL/UN status Edit',
                color:'btn-success',
                hidden:(!`{{ $myAuth->hasPermission('penerimaanstokheader', 'approvalEdit') }}`),
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('penerimaanstokheader', 'approvalEdit') }}`) {
                    var selectedOne = selectedOnlyOne();
                    if (selectedOne[0]) {
                      approveEdit(selectedOne[1])
                    } else {
                      showDialog(selectedOne[1])
                    }
                  }
                }
              },
              {
                id: 'approvalEditKeterangan',
                text: ' APPROVAL/UN status Edit Keterangan',
                color:'btn-info',
                hidden:(!`{{ $myAuth->hasPermission('penerimaanstokheader', 'approvalEditKeterangan') }}`),
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('penerimaanstokheader', 'approvalEditKeterangan') }}`) {
                    var selectedOne = selectedOnlyOne();
                    if (selectedOne[0]) {
                      approveEditKeterangan(selectedOne[1])
                    } else {
                      showDialog(selectedOne[1])
                    }
                  }
                }
              },
              {
                id: 'approvalBukaTglBatasPG',
                text: ' approval/un Buka Tgl Batas PG',
                color:'btn-primary',
                hidden:(!`{{ $myAuth->hasPermission('penerimaanstokheader', 'approvalBukaTglBatasPG') }}`),
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('penerimaanstokheader', 'approvalBukaTglBatasPG') }}`) {
                    var selectedOne = selectedOnlyOne();
                    if (selectedRows.length > 0) {
                      approvalBukaTglBatasPG()
                    } else {
                      showDialog('Harap pilih salah satu record')
                    }
                  }
                }
              },
              {
                id: 'approval-buka-cetak',
                text: "Approval Buka Cetak PENERIMAAN STOK",
                color:'btn-orange',
                hidden:(!`{{ $myAuth->hasPermission('penerimaanstokheader', 'approvalbukacetak') }}`),
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('penerimaanstokheader', 'approvalbukacetak') }}`) {
                    let tglbukacetak = $('#tgldariheader').val().split('-');
                    tglbukacetak = tglbukacetak[1] + '-' + tglbukacetak[2];
                    selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                    if (selectedId == null || selectedId == '' || selectedId == undefined) {
                      showDialog('Harap pilih salah satu record')
                    } else {
                      approvalBukaCetak(tglbukacetak, 'PENERIMAANSTOKHEADER', selectedRows, selectedbukti);
                    }
                  }
                }
              },
              {
                id: 'approval-kirim-berkas',
                text: "APPROVAL/UN Kirim Berkas PENERIMAAN STOK",
                color:'btn-dark-blue',
                hidden:(!`{{ $myAuth->hasPermission('penerimaanstokheader', 'approvalkirimberkas') }}`),
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('penerimaanstokheader', 'approvalkirimberkas') }}`) {
                    let tglkirimberkas = $('#tgldariheader').val().split('-');
                    tglkirimberkas = tglkirimberkas[1] + '-' + tglkirimberkas[2];
                    selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                    if (selectedId == null || selectedId == '' || selectedId == undefined) {
                      showDialog('Harap pilih salah satu record')
                    } else {
                      approvalKirimBerkas(tglkirimberkas, 'PENERIMAANSTOKHEADER', selectedRows, selectedbukti);
                    }
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
        digitGroupSeparator: ',',
        decimalCharacter: '.',
        decimalPlaces: 0,
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
        xhr.open('GET', `{{ config('app.api_url') }}penerimaanstokheader/export?${params}`, true)
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
              link.download = `laporanpenerimaanStok${(new Date).getTime()}.xlsx`
              link.click()

              submitButton.removeAttr('disabled')
            }
          }
        }

        xhr.send()
      } else if ($('#rangeModal').data('action') == 'report') {
        window.open(`{{ route('penerimaanstokheader.report') }}?${params}`)

        submitButton.removeAttr('disabled')
      }
    })

    getStatusEdit()

    function approveEdit(id) {
      if (approveEditRequest) {
        approveEditRequest.abort();
      }
      approveEditRequest = $.ajax({
        url: `${apiUrl}penerimaanstokheader/${id}/approvaledit?to=show`,
        method: 'POST',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          let msg = `YAKIN Approve Status Edit `

          if (response.data.statusedit_id === statusBisaEdit) {
            msg = `YAKIN UnApprove Status Edit `
          }

          if (response.is_before_opname) {
            showConfirm('Yakin ingin mengedit data ?', 'stok Sudah Melewati Batas Stok Opname')
              .done(function() {
                showConfirm(msg, response.data.nobukti, `penerimaanstokheader/${response.data.id}/approvaledit?to=confirm`)
              })
              .then(() => {
                selectedRows = []
                $('#gs_').prop('checked', false)
              })
          } else {
            showConfirm(msg, response.data.nobukti, `penerimaanstokheader/${response.data.id}/approvaledit?to=confirm`)
              .then(() => {
                selectedRows = []
                $('#gs_').prop('checked', false)
              })
          }

        },
      })
    }
    function approvalBukaTglBatasPG() {
      event.preventDefault()
      
      let form = $('#crudForm')
      $(this).attr('disabled', '')
      $('#processingLoader').removeClass('d-none')
      
      $.ajax({
        url: `${apiUrl}penerimaanstokheader/approvalbukatglbataspg`,
        method: 'POST',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          Id: selectedRows,
          nobukti:selectedbukti,
        },
        success: response => {
          $('#crudForm').trigger('reset')
          $('#crudModal').modal('hide')
      
          $('#jqGrid').jqGrid('setGridParam', {
            postData: {
              proses: 'reload'
            }
          }).trigger('reloadGrid');
          selectedRows = []
          $('#gs_').prop('checked', false)
        },
        error: error => {
          if (error.status === 422) {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
      
            setErrorMessages(form, error.responseJSON.errors);
          } else {
            showDialog(error.responseJSON)
          }
        },
      }).always(() => {
        $('#processingLoader').addClass('d-none')
        $(this).removeAttr('disabled')
      })
    }



    function approveEditKeterangan(id) {
      if (approveEditRequest) {
        approveEditRequest.abort();
      }
      approveEditRequest = $.ajax({
        url: `${apiUrl}penerimaanstokheader/${id}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          let msg = `YAKIN Approve Status Edit Keterangan`

          console.log(response.data);
          if (response.data.statuseditketerangan_id === statusBisaEdit) {
            msg = `YAKIN UnApprove Status Edit Keterangan`
          }
          showConfirm(msg, response.data.nobukti, `penerimaanstokheader/${response.data.id}/approvaleditketerangan`)
            .then(() => {
              selectedRows = []
              $('#gs_').prop('checked', false)
            })

        },
      })
    }

    function getStatusEdit() {
      $.ajax({
        url: `${apiUrl}parameter`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        data: {
          limit: 0,
          filters: JSON.stringify({
            "groupOp": "AND",
            "rules": [{
              "field": "grp",
              "op": "cn",
              "data": "STATUS APPROVAL"
            }, {
              "field": "text",
              "op": "cn",
              "data": "APPROVAL"
            }]
          })
        },
        success: response => {
          statusBisaEdit = response.data[0].id;
        }
      })
    }

  })


  function permission() {
    if (!`{{ $myAuth->hasPermission('penerimaanstokheader', 'store') }}`) {
      $('#add').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('penerimaanstokheader', 'update') }}`) {
      $('#edit').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('penerimaanstokheader', 'show') }}`) {
      $('#view').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('penerimaanstokheader', 'destroy') }}`) {
      $('#delete').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('penerimaanstokheader', 'export') }}`) {
      $('#export').attr('disabled', 'disabled')
    }

    if (!`{{ $myAuth->hasPermission('penerimaanstokheader', 'report') }}`) {
      $('#report').attr('disabled', 'disabled')
    }
    let hakApporveCount = 0;
    hakApporveCount++
    if (!`{{ $myAuth->hasPermission('penerimaanstokheader', 'approvalEdit') }}`) {
      $('#approvalEdit').hide()
      hakApporveCount--
      // $('#approvalEdit').attr('disabled', 'disabled')
    }
    hakApporveCount++
    if (!`{{ $myAuth->hasPermission('penerimaanstokheader', 'approvalEditKeterangan') }}`) {
      $('#approvalEditKeterangan').hide()
      hakApporveCount--
      // $('#approvalEditKeterangan').attr('disabled', 'disabled')
    }
    hakApporveCount++
    if (!`{{ $myAuth->hasPermission('penerimaanstokheader', 'approvalbukacetak') }}`) {
      hakApporveCount--
      $('#approval-buka-cetak').hide()
      // $('#approval-buka-cetak').attr('disabled', 'disabled')
    }
    hakApporveCount++
    if (!`{{ $myAuth->hasPermission('penerimaanstokheader', 'approvalkirimberkas') }}`) {
      hakApporveCount--
      $('#approval-kirim-berkas').hide()
    }
    hakApporveCount++
    if (!`{{ $myAuth->hasPermission('penerimaanstokheader', 'approvalBukaTglBatasPG') }}`) {
      hakApporveCount--
      $('#approvalBukaTglBatasPG').hide()
    }
    if (hakApporveCount < 1) {
      $('#approve').hide()
      // $('#approve').attr('disabled', 'disabled')
    }

  }
</script>
@endpush()
@endsection