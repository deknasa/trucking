@extends('layouts.master')
@push('addtional-field')
<div class="form-group row">
  <label class="col-12 col-sm-2 col-form-label mt-2">pengeluaran stok</label>
  <div class="col-sm-4 mt-2">
    <select name="kodepengeluaranheader" id="kodepengeluaranheader" class="form-select select2" style="width: 100%;">
      <option value="">-- semua --</option>
      @foreach ($comboKodepengeluaran as $kodepengeluaran)
      {{-- @if ($kodepengeluaran['id'] === "1") selected @endif --}}
      <option @if ($kodepengeluaran['kodepengeluaran']=="SPK" ) selected @endif value="{{$kodepengeluaran['id']}}"> {{$kodepengeluaran['keterangan']}} </option>
      {{-- <option @if ($kodepengeluaran['statusdefault_text'] ==="YA") selected @endif value="{{$kodepengeluaran['id']}}"> {{$kodepengeluaran['namakodepengeluaran']}} </option> --}}
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
              <li><a href="#penerimaan-tab">penerimaan</a></li>
              <li><a href="#hutangbayar-tab">hutang bayar</a></li>
              <li><a href="#pengeluaran-tab">pengeluaran</a></li>
              <li><a href="#jurnal-tab">Jurnal</a></li>
            </ul>
            <div id="detail-tab">
              <table id="detail"></table>
            </div>

            <div id="penerimaan-tab">
              <table id="penerimaanGrid"></table>
            </div>
            <div id="hutangbayar-tab">
              <table id="hutangbayarGrid"></table>
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

@include('pengeluaranstokheader._modal')
<!-- Detail -->
@include('pengeluaranstokheader._detail')
@include('pengeluaranstokheader._pengeluaran')
@include('pengeluaranstokheader._hutangbayar')
@include('penerimaan._penerimaan')
@include('pengeluaranstokheader._jurnal')

@push('scripts')
<script>
  let indexUrl = "{{ route('pengeluaranstokheader.index') }}"
  let getUrl = "{{ route('pengeluaranstokheader.get') }}"
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
  let approveEditRequest = null;
  let dataAcos = <?php echo json_encode($acosPengeluaran); ?>;
  let activeGrid;
  let tgldariheader
  let tglsampaiheader
  reloadGrid()

  $(document).on('change', $('#crudForm').find('[name=kodepengeluaranheader]'), function(event) {
    setPermissionAcos()
  })

  function setPermissionAcos() {
    let selectedIdPengeluaran = $(`[name="kodepengeluaranheader"] option:selected`).val();
    if (selectedIdPengeluaran != '') {
      let isKodepengeluaranInData = dataAcos.some(item => parseInt(item.id) == selectedIdPengeluaran);
      if (isKodepengeluaranInData) {
        $('#add').attr('disabled', false)
        $('#edit').attr('disabled', false)
        $('#delete').attr('disabled', false)
      } else {
        $('#add').attr('disabled', true)
        $('#edit').attr('disabled', true)
        $('#delete').attr('disabled', true)
      }
    } else {
      $('#add').attr('disabled', false)
      $('#edit').attr('disabled', false)
      $('#delete').attr('disabled', false)
    }
  }
  $(document).ready(function() {
    $("#tabs").tabs()

    initSelect2($(`#kodepengeluaranheader`), false);
    pengeluaranStok($('#crudForm'));
    $('#crudModal').on('hidden.bs.modal', function() {
      activeGrid = '#jqGrid'
    })
    @isset($request['tgldari'])
    tgldariheader = `{{ $request['tgldari'] }}`;
    @endisset
    @isset($request['tglsampai'])
    tglsampaiheader = `{{ $request['tglsampai'] }}`;
    @endisset
    setRange(false, tgldariheader, tglsampaiheader)
    initDatepicker('datepickerIndex')
    $(document).on('click', '#btnReload', function(event) {
      loadDataHeader('pengeluaranstokheader', {
        pengeluaranheader_id: $('#kodepengeluaranheader').val(),
        proses: 'reload'
      })
    })
    // console.log(,);



    $("#jqGrid").jqGrid({
        url: `{{ config('app.api_url') . 'pengeluaranstokheader' }}`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        postData: {
          tgldari: $('#tgldariheader').val(),
          tglsampai: $('#tglsampaiheader').val(),
          pengeluaranheader_id: $('#kodepengeluaranheader').val(),
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
            label: 'gandengan',
            name: 'gandengan',
            align: 'left'
          },
          {
            label: 'supplier',
            name: 'supplier',
            align: 'left'
          },
          {
            label: 'supir',
            name: 'supir',
            align: 'left'
          },
          {
            label: 'PENgeluaran Stok',
            name: 'pengeluaranstok',
            align: 'left'
          },
          {
            label: 'Pengeluaran trucking no BUKTI',
            width: 230,
            name: 'pengeluarantrucking_nobukti',
            align: 'left',
            formatter: (value, options, rowData) => {
              if ((value == null) || (value == '')) {
                return '';
              }
              let tgldari = rowData.tgldariheaderpengeluarantruckingheader
              let tglsampai = rowData.tglsampaiheaderpengeluarantruckingheader
              let url = "{{route('pengeluarantruckingheader.index')}}"
              let formattedValue = $(`
              <a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}" class="link-color" target="_blank">${value}</a>
             `)
              return formattedValue[0].outerHTML
            },
          },
          {
            label: 'SERVICE IN NO BUKTI',
            width: 230,
            name: 'servicein_nobukti',
            align: 'left',
            formatter: (value, options, rowData) => {
              if ((value == null) || (value == '')) {
                return '';
              }
              let tgldari = rowData.tgldariheaderserviceinheader
              let tglsampai = rowData.tglsampaiheaderserviceinheader
              let url = "{{route('serviceinheader.index')}}"
              let formattedValue = $(`
              <a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}" class="link-color" target="_blank">${value}</a>
             `)
              return formattedValue[0].outerHTML
            },
          },


          {
            label: 'PENERIMAAN STOK NO BUKTI',
            width: 230,
            name: 'penerimaanstok_nobukti',
            align: 'left',
            formatter: (value, options, rowData) => {
              if ((value == null) || (value == '')) {
                return '';
              }
              let tgldari = rowData.tgldariheaderpenerimaanstok
              let tglsampai = rowData.tglsampaiheaderpenerimaanstok
              let url = "{{route('penerimaanstokheader.index')}}"
              let formattedValue = $(`
              <a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}" class="link-color" target="_blank">${value}</a>
             `)
              return formattedValue[0].outerHTML
            },
          },
          {
            label: 'Pengeluaran stok no bukti',
            width: 230,
            name: 'pengeluaranstok_nobukti',
            align: 'left',
            formatter: (value, options, rowData) => {
              if ((value == null) || (value == '')) {
                return '';
              }
              let tgldari = rowData.tgldariheaderpenerimaanheader
              let tglsampai = rowData.tglsampaiheaderpenerimaanheader
              let url = "{{route('pengeluaranstokheader.index')}}"
              let formattedValue = $(`
             <a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}" class="link-color" target="_blank">${value}</a>
             `)
              return formattedValue[0].outerHTML
            },
          },
          {
            label: 'Penerimaan no bukti',
            name: 'penerimaan_nobukti',
            width: 230,
            align: 'left',
            formatter: (value, options, rowData) => {
              if ((value == null) || (value == '')) {
                return '';
              }
              let tgldari = rowData.tgldariheaderpenerimaanheader
              let tglsampai = rowData.tglsampaiheaderpenerimaanheader
              let url = "{{route('penerimaanheader.index')}}"
              let formattedValue = $(`
             <a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}" class="link-color" target="_blank">${value}</a>
             `)
              return formattedValue[0].outerHTML
            },
          },
          {
            label: 'hutang bayar nobukti',
            width: 230,
            name: 'hutangbayar_nobukti',
            align: 'left',
            formatter: (value, options, rowData) => {
              if ((value == null) || (value == '')) {
                return '';
              }
              let tgldari = rowData.tgldariheaderhutangbayarheader
              let tglsampai = rowData.tglsampaiheaderhutangbayarheader
              let url = "{{route('pelunasanhutangheader.index')}}"
              let formattedValue = $(`
             <a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}" class="link-color" target="_blank">${value}</a>
             `)
              return formattedValue[0].outerHTML
            },
          },
          {
            label: 'kerusakan',
            name: 'kerusakan',
            align: 'left'
          },
          {
            label: 'status potong retur',
            width: 230,
            name: 'statuspotongretur',
            align: 'left'
          },
          {
            label: 'bank',
            name: 'bank',
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

          loadDetailData(id)
          activeGrid = $(this)
          indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
          page = $(this).jqGrid('getGridParam', 'page')
          let limit = $(this).jqGrid('getGridParam', 'postData').limit
          if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))

          let pengeluaranstok = $(`#jqGrid tr#${id}`).find(`td[aria-describedby="jqGrid_pengeluaranstok"]`).attr('title') ?? '';
          let nobukti = $(`#jqGrid tr#${id}`).find(`td[aria-describedby="jqGrid_nobukti"]`).attr('title') ?? '';
          let statuspotong = $(`#jqGrid tr#${id}`).find(`td[aria-describedby="jqGrid_statuspotongretur"]`).attr('title') ?? '';
          let penerimaan = $(`#jqGrid tr#${id}`).find(`td[aria-describedby="jqGrid_penerimaan_nobukti"]`).attr('title') ?? '';
          let hutangbayar = $(`#jqGrid tr#${id}`).find(`td[aria-describedby="jqGrid_hutangbayar_nobukti"]`).attr('title') ?? '';
          let pengeluaran = false;
          if (pengeluaranstok == "PJA") {
            nobukti = $('#jqGrid').jqGrid('getCell', id, 'jqGrid_hutangbayar_nobukti')
            hutangbayar = false;
          } else if (pengeluaranstok == "RTR") {

            if (statuspotong == 219) { //penerimaan
              nobukti = penerimaan;
              hutangbayar = false;
            } else if (statuspotong == 220) { //hutangbayar_nobukti
              nobukti = hutangbayar;
              pengeluaran = hutangbayar;
            }
            loadJurnalUmumData(id, nobukti, "pengeluaranstokdetail", statuspotong)
          } else {
            loadJurnalUmumData(id, nobukti)
          }
          // loadPenerimaanData(id, nobukti)

          loadHutangBayarData(id, hutangbayar)
          loadPengeluaranData(id, pengeluaran)
          loadPenerimaanData(id, penerimaan)
        },
        loadComplete: function(data) {
          changeJqGridRowListText()

          if (data.data.length === 0) {
            $('#detail,#penerimaanGrid,#hutangbayarGrid, #pengeluaranGrid, #jurnalGrid').each((index, element) => {
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
              createPengeluaranstokHeader()
            }
          },
          {
            id: 'edit',
            innerHTML: '<i class="fa fa-pen"></i> EDIT',
            class: 'btn btn-success btn-sm mr-1',
            onClick: function(event) {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              if (selectedId == null || selectedId == '' || selectedId == undefined) {
                showDialog(pleaseSelectARow)
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
                showDialog(pleaseSelectARow)
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
              viewPengeluaranstokHeader(selectedId)
            }
          },
        ],
        extndBtn: [{
            id: 'report',
            title: 'report',
            caption: 'report',
            innerHTML: '<i class="fa fa-print"></i> REPORT',
            class: 'btn btn-info btn-sm mr-1 dropdown-toggle ',
            dropmenuHTML: [{
                id: 'reportPrinterBesar',
                text: 'Printer Lain(Faktur)',
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
                onClick: () => {
                  selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                  if (selectedId == null || selectedId == '' || selectedId == undefined) {
                    showDialog('Harap pilih salah satu record')
                  } else {
                    cekValidasi(selectedId, 'PRINTER KECIL')
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
                showDialog(pleaseSelectARow)
              } else {
                window.open(`{{ route('pengeluaranstokheader.export') }}?id=${selectedId}`)
              }
            }
          },
          {
            id: 'approve',
            title: 'Approve',
            caption: 'Approve',
            innerHTML: '<i class="fa fa-check"></i> UN/APPROVAL',
            class: 'btn btn-purple btn-sm mr-1 dropdown-toggle ',
            dropmenuHTML: [{
                id: 'approvalEdit',
                text: 'approval Edit',
                onClick: () => {

                  if (`{{ $myAuth->hasPermission('pengeluaranstokheader', 'approvalEdit') }}`) {
                    selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                    approveEdit(selectedId)
                  }
                }
              },
              {
                id: 'approvalEditKeterangan',
                text: ' UN/APPROVAL status Edit Keterangan',
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('pengeluaranstokheader', 'approvalEditKeterangan') }}`) {
                    selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                    approveEditKeterangan(selectedId)
                  }
                }
              },
              {
                id: 'approval-buka-cetak',
                text: "un/Approval Buka Cetak PENGELUARAN STOK",
                onClick: () => {
                  if (`{{ $myAuth->hasPermission('pengeluaranstokheader', 'approvalbukacetak') }}`) {
                    let tglbukacetak = $('#tgldariheader').val().split('-');
                    tglbukacetak = tglbukacetak[1] + '-' + tglbukacetak[2];
                    selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                    if (selectedId == null || selectedId == '' || selectedId == undefined) {
                      showDialog('Harap pilih salah satu record')
                    } else {
                      approvalBukaCetak(tglbukacetak, 'PENGELUARANSTOKHEADER', [selectedId]);
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

    /* Load detail grid */
    loadDetailGrid()
    loadJurnalUmumGrid("")
    loadHutangBayarGrid("")
    loadPengeluaranGrid("")
    loadPenerimaanGrid("")



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

    function permission() {
      if (!`{{ $myAuth->hasPermission('pengeluaranstokheader', 'store') }}`) {
        $('#add').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('pengeluaranstokheader', 'show') }}`) {
        $('#view').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('pengeluaranstokheader', 'update') }}`) {
        $('#edit').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('pengeluaranstokheader', 'destroy') }}`) {
        $('#delete').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('pengeluaranstokheader', 'export') }}`) {
        $('#export').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('pengeluaranstokheader', 'report') }}`) {
        $('#report').attr('disabled', 'disabled')
      }
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
        xhr.open('GET', `{{ config('app.api_url') }}pengeluaranstokheader/export?${params}`, true)
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
              link.download = `laporanpengeluaranStok${(new Date).getTime()}.xlsx`
              link.click()

              submitButton.removeAttr('disabled')
            }
          }
        }

        xhr.send()
      } else if ($('#rangeModal').data('action') == 'report') {
        window.open(`{{ route('pengeluaranstokheader.report') }}?${params}`)

        submitButton.removeAttr('disabled')
      }
    })
    getStatusEdit()

    function approveEdit(id) {
      if (approveEditRequest) {
        approveEditRequest.abort();
      }
      approveEditRequest = $.ajax({
        url: `${apiUrl}pengeluaranstokheader/${id}`,
        method: 'GET',
        dataType: 'JSON',
        headers: {
          Authorization: `Bearer ${accessToken}`
        },
        success: response => {
          let msg = `YAKIN Approve Status Edit `

          console.log(response.data);
          if (response.data.statusedit_id === statusBisaEdit) {
            msg = `YAKIN UnApprove Status Edit `
          }
          showConfirm(msg, response.data.nobukti, `pengeluaranstokheader/${response.data.id}/approvaledit`)
        },
      })
    }


    function approveEditKeterangan(id) {
      if (approveEditRequest) {
        approveEditRequest.abort();
      }
      approveEditRequest = $.ajax({
        url: `${apiUrl}pengeluaranstokheader/${id}`,
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
          showConfirm(msg, response.data.nobukti, `pengeluaranstokheader/${response.data.id}/approvaleditketerangan`)
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
</script>
@endpush()
@endsection