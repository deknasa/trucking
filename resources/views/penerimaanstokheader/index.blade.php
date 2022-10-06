@extends('layouts.master')

@section('content')
<!-- Grid -->
<div class="container-fluid">
  <div class="row">
    <div class="col-12">
      <table id="jqGrid"></table>
    </div>
  </div>
</div>

@include('penerimaanstokheader._modal')
<!-- Detail -->
@include('penerimaanstokheader._detail')

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

  $(document).ready(function() {

    // $('#lookupPenerimaanStok').hide()
    // $('#lookupBank').hide()
    // $('#lookupAkunPusat').hide()
    // $('#lookupPenerimaanHeader').hide()
    // $('#lookupSupir').hide()
    // $('#lookupPengeluaranStokHeader').hide()



    // $('#crudModal').on('shown.bs.modal', function() {
    //   penerimaanStokLookup.setGridWidth($('#lookupPenerimaanStok').prev().width())
    //   bankLookup.setGridWidth($('#lookupBank').prev().width())
    //   akunPusatLookup.setGridWidth($('#lookupAkunPusat').prev().width())
    //   penerimaanHeaderLookup.setGridWidth($('#lookupPenerimaanHeader').prev().width())
    //   supirLookup.setGridWidth($('#lookupSupir').prev().width())
    //   pengeluaranStokHeaderLookup.setGridWidth($('#lookupPengeluaranStokHeader').prev().width())


    //   if (detectDeviceType() == 'desktop') {
    //     penerimaanStokLookup.setGridParam({
    //       ondblClickRow: function(id) {
    //         let rowData = $(this).getRowData(id)
    //         console.log(rowData)

    //         $('#crudForm [name=penerimaanStok_id]').first().val(rowData.id)
    //         $('#crudForm [name=penerimaanStok]').first().val(rowData.kodepenerimaan)
    //         // $('#crudForm [name=user_id]').first().val(id)
    //         $('#lookupPenerimaanStok').hide()

    //         $('#lookupBankToggler').show()
    //         $('#lookupAkunPusatToggler').show()
    //         $('#lookupPenerimaanHeaderToggler').show()
    //         $('#lookupSupirToggler').show()
    //         $('#lookupPengeluaranStokHeaderToggler').show()
    //       }
    //     })

    //     bankLookup.setGridParam({
    //       ondblClickRow: function(id) {
    //         let rowData = $(this).getRowData(id)
    //         console.log(rowData)

    //         $('#crudForm [name=bank_id]').first().val(rowData.id)
    //         $('#crudForm [name=bank]').first().val(rowData.namabank)
    //         // $('#crudForm [name=user_id]').first().val(id)
    //         $('#lookupBank').hide()

    //         $('#lookupAkunPusatToggler').show()
    //         $('#lookupPenerimaanHeaderToggler').show()
    //         $('#lookupSupirToggler').show()
    //         $('#lookupPengeluaranStokHeaderToggler').show()
    //       }
    //     })
    //     akunPusatLookup.setGridParam({
    //       ondblClickRow: function(id) {
    //         let rowData = $(this).getRowData(id)
    //         console.log(rowData.coa)

    //         $('#crudForm [name=akunpusat]').first().val(rowData.coa)
    //         // $('#crudForm [name=user_id]').first().val(id)
    //         $('#lookupAkunPusat').hide()

    //         $('#lookupPenerimaanHeaderToggler').show()
    //         $('#lookupPengeluaranStokHeaderToggler').show()
    //         $('#lookupSupirToggler').show()

    //       }
    //     })

    //     penerimaanHeaderLookup.setGridParam({
    //       ondblClickRow: function(id) {
    //         let rowData = $(this).getRowData(id)
    //         console.log(rowData)

    //         $('#crudForm [name=penerimaan_nobukti]').first().val(rowData.nobukti)
    //         // $('#crudForm [name=user_id]').first().val(id)
    //         $('#lookupPenerimaanHeader').hide()

    //         $('#lookupSupirToggler').show()
    //         $('#lookupPengeluaranStokHeaderToggler').show()
    //       }
    //     })

    //     supirLookup.setGridParam({
    //       ondblClickRow: function(id) {
    //         let rowData = $(this).getRowData(id)
    //         console.log(rowData)

    //         $('#crudForm [name=supir_id]').first().val(rowData.id)
    //         $('#crudForm [name=supir]').first().val(rowData.namasupir)
    //         // $('#crudForm [name=user_id]').first().val(id)
    //         $('#lookupSupir').hide()
    //         $('#lookupPengeluaranStokHeaderToggler').show()

    //       }
    //     })
    //     pengeluaranStokHeaderLookup.setGridParam({
    //       ondblClickRow: function(id) {
    //         let rowData = $(this).getRowData(id)
    //         console.log(rowData)

    //         $('#crudForm [name=pengeluaranStokheader_nobukti]').first().val(rowData.nobukti)
    //         // $('#crudForm [name=user_id]').first().val(id)
    //         $('#lookupPengeluaranStokHeader').hide()
    //       }
    //     })


    //   } else if (detectDeviceType() == 'mobile') {
    //     penerimaanStokLookup.setGridParam({
    //       onSelectRow: function(id) {
    //         let rowData = $(this).getRowData(id)

    //         $('#crudForm [name=penerimaanStok_id]').first().val(rowData.kodepenerimaan)
    //         // $('#crudForm [name=user_id]').first().val(id)
    //         $('#lookupPenerimaanStok').hide()
    //       }
    //     })
    //     bankLookup.setGridParam({
    //       onSelectRow: function(id) {
    //         let rowData = $(this).getRowData(id)

    //         $('#crudForm [name=bank_id]').first().val(rowData.namabank)
    //         // $('#crudForm [name=user_id]').first().val(id)
    //         $('#lookupBank').hide()
    //       }
    //     })
    //     akunPusatLookup.setGridParam({
    //       onSelectRow: function(id) {
    //         let rowData = $(this).getRowData(id)

    //         $('#crudForm [name=coa]').first().val(rowData.coa)
    //         // $('#crudForm [name=user_id]').first().val(id)
    //         $('#lookupAkunPusat').hide()
    //       }
    //     })
    //     penerimaanHeaderLookup.setGridParam({
    //       onSelectRow: function(id) {
    //         let rowData = $(this).getRowData(id)

    //         $('#crudForm [name=penerimaan_nobukti]').first().val(rowData.nobukti)
    //         // $('#crudForm [name=user_id]').first().val(id)
    //         $('#lookupPenerimaanHeader').hide()
    //       }
    //     })
    //     supirLookup.setGridParam({
    //       onSelectRow: function(id) {
    //         let rowData = $(this).getRowData(id)

    //         $('#crudForm [name=supir_id]').first().val(rowData.namasupir)
    //         // $('#crudForm [name=user_id]').first().val(id)
    //         $('#lookupSupir').hide()
    //       }
    //     })
    //     pengeluaranStokHeaderLookup.setGridParam({
    //       onSelectRow: function(id) {
    //         let rowData = $(this).getRowData(id)

    //         $('#crudForm [name=pengeluaranStokheader_nobukti]').first().val(rowData.nobukti)
    //         // $('#crudForm [name=user_id]').first().val(id)
    //         $('#lookupPengeluaranStokHeader').hide()
    //       }
    //     })

    //   }

    //   $('#crudModal').find("[name]:not(:hidden, [readonly], [disabled], .disabled), button:submit").first().focus()
    // })

    // $('#crudModal').on('hidden.bs.modal', function() {
    //   activeGrid = '#jqGrid'
    // })


    // //tampil lookup ketika klik toggler
    // $('#lookupPenerimaanStokToggler').click(function(event) {
    //   penerimaanStokLookup.setGridWidth($('#lookupPenerimaanStok').prev().width())
    //   $('#lookupPenerimaanStok').toggle()

    //   $('#lookupBank').hide()
    //   $('#lookupAkunPusat').hide()
    //   $('#lookupPenerimaanHeader').hide()
    //   $('#lookupPengeluaranStokHeader').hide()
    //   $('#lookupSupir').hide()

    //   $('#lookupBankToggler').hide()
    //   $('#lookupAkunPusatToggler').hide()
    //   $('#lookupPenerimaanHeaderToggler').hide()
    //   $('#lookupPengeluaranStokHeaderToggler').hide()
    //   $('#lookupSupirToggler').hide()


    //   if (detectDeviceType() != 'desktop') {
    //     penerimaanStokLookup.setGridHeight(window.innerHeight / 1.5)
    //   }

    //   if (detectDeviceType() == 'desktop') {
    //     activeGrid = penerimaanStokLookup
    //   }

    // })

    // $('#lookupBankToggler').click(function(event) {
    //   bankLookup.setGridWidth($('#lookupBank').prev().width())
    //   $('#lookupBank').toggle()

    //   $('#lookupPenerimaanStok').hide()
    //   $('#lookupAkunPusat').hide()
    //   $('#lookupPenerimaanHeader').hide()
    //   $('#lookupPengeluaranStokHeader').hide()
    //   $('#lookupSupir').hide()

    //   $('#lookupAkunPusatToggler').hide()
    //   $('#lookupPenerimaanHeaderToggler').hide()
    //   $('#lookupPengeluaranStokHeaderToggler').hide()
    //   $('#lookupSupirToggler').hide()

    //   if (detectDeviceType() != 'desktop') {
    //     bankLookup.setGridHeight(window.innerHeight / 1.5)
    //   }

    //   if (detectDeviceType() == 'desktop') {
    //     activeGrid = bankLookup
    //   }
    // })

    // $('#lookupAkunPusatToggler').click(function(event) {
    //   akunPusatLookup.setGridWidth($('#lookupAkunPusat').prev().width())
    //   $('#lookupAkunPusat').toggle()

    //   $('#lookupPenerimaanStok').hide()
    //   $('#lookupBank').hide()
    //   $('#lookupPenerimaanHeader').hide()
    //   $('#lookupPengeluaranStokHeader').hide()
    //   $('#lookupSupir').hide()

    //   $('#lookupPenerimaanHeaderToggler').hide()
    //   $('#lookupSupirToggler').hide()
    //   $('#lookupPengeluaranStokHeaderToggler').hide()

    //   if (detectDeviceType() != 'desktop') {
    //     akunPusatLookup.setGridHeight(window.innerHeight / 1.5)
    //   }

    //   if (detectDeviceType() == 'desktop') {
    //     activeGrid = akunPusatLookup
    //   }
    // })

    // $('#lookupPenerimaanHeaderToggler').click(function(event) {
    //   penerimaanHeaderLookup.setGridWidth($('#lookupPenerimaanHeader').prev().width())
    //   $('#lookupPenerimaanHeader').toggle()

    //   $('#lookupPenerimaanStok').hide()
    //   $('#lookupAkunPusat').hide()
    //   $('#lookupBank').hide()
    //   $('#lookupPengeluaranStokHeader').hide()
    //   $('#lookupSupir').hide()


    //   $('#lookupSupirToggler').hide()
    //   $('#lookupPengeluaranStokHeaderToggler').hide()
    //   if (detectDeviceType() != 'dekstop') {
    //     penerimaanHeaderLookup.setGridHeight(window.innerHeight / 1.5)
    //   }

    //   if (detectDeviceType() == 'dekstop') {
    //     activeGrid = penerimaanHeaderLookup
    //   }
    // })

    // $('#lookupSupirToggler').click(function(event) {
    //   supirLookup.setGridWidth($('#lookupSupir').prev().width())
    //   $('#lookupSupir').toggle()

    //   $('#lookupPenerimaanStok').hide()
    //   $('#lookupAkunPusat').hide()
    //   $('#lookupBank').hide()
    //   $('#lookupPenerimaanHeader').hide()
    //   $('#lookupPengeluaranStokHeader').hide()


    //   if (detectDeviceType() != 'dekstop') {
    //     supirLookup.setGridHeight(window.innerHeight / 1.5)
    //   }

    //   if (detectDeviceType() == 'dekstop') {
    //     activeGrid = supirLookup
    //   }
    // })

    // $('#lookupPengeluaranStokHeaderToggler').click(function(event) {
    //   pengeluaranStokHeaderLookup.setGridWidth($('#lookupPengeluaranStokHeader').prev().width())
    //   $('#lookupPengeluaranStokHeader').toggle()

    //   $('#lookupPenerimaanStok').hide()
    //   $('#lookupAkunPusat').hide()
    //   $('#lookupBank').hide()
    //   $('#lookupPenerimaanHeader').hide()
    //   $('#lookupSupir').hide()

    //   if (detectDeviceType() != 'dekstop') {
    //     pengeluaranStokHeaderLookup.setGridHeight(window.innerHeight / 1.5)
    //   }

    //   if (detectDeviceType() == 'dekstop') {
    //     activeGrid = pengeluaranStokHeaderLookup
    //   }
    // })



    // //untuk auto search dari kolom input
    // $('[name=penerimaanStok]').on('input', function(event) {
    //   $('#lookuppenerimaanStok').show()

    //   if (detectDeviceType() != 'desktop') {
    //     penerimaanStokLookup.setGridHeight(window.innerHeight / 1.5)
    //   }

    //   delay(() => {
    //     let postData = penerimaanStokLookup.getGridParam('postData')
    //     let colModels = penerimaanStokLookup.getGridParam('colModel')
    //     let rules = []

    //     colModels = colModels.filter((colModel) => {
    //       return colModel.name !== 'rn'
    //     })

    //     colModels.forEach(colModel => {
    //       rules.push({
    //         field: colModel.name,
    //         op: 'cn',
    //         data: $(this).val()
    //       })
    //     });

    //     postData.filters = JSON.stringify({
    //       groupOp: 'OR',
    //       rules: rules
    //     })

    //     penerimaanStokLookup.trigger('reloadGrid', {
    //       page: 1
    //     })
    //   }, 500)
    // })

    // $('[name=bank]').on('input', function(event) {
    //   $('#lookupBank').show()

    //   if (detectDeviceType() != 'desktop') {
    //     bankLookup.setGridHeight(window.innerHeight / 1.5)
    //   }

    //   delay(() => {
    //     let postData = bankLookup.getGridParam('postData')
    //     let colModels = bankLookup.getGridParam('colModel')
    //     let rules = []

    //     colModels = colModels.filter((colModel) => {
    //       return colModel.name !== 'rn'
    //     })

    //     colModels.forEach(colModel => {
    //       rules.push({
    //         field: colModel.name,
    //         op: 'cn',
    //         data: $(this).val()
    //       })
    //     });

    //     postData.filters = JSON.stringify({
    //       groupOp: 'OR',
    //       rules: rules
    //     })

    //     bankLookup.trigger('reloadGrid', {
    //       page: 1
    //     })
    //   }, 500)
    // })

    // $('[name=coa]').on('input', function(event) {
    //   $('#lookupAkunPusat').show()

    //   if (detectDeviceType() != 'desktop') {
    //     akunPusatLookup.setGridHeight(window.innerHeight / 1.5)
    //   }

    //   delay(() => {
    //     let postData = akunPusatLookup.getGridParam('postData')
    //     let colModels = akunPusatLookup.getGridParam('colModel')
    //     let rules = []

    //     colModels = colModels.filter((colModel) => {
    //       return colModel.name !== 'rn'
    //     })

    //     colModels.forEach(colModel => {
    //       rules.push({
    //         field: colModel.name,
    //         op: 'cn',
    //         data: $(this).val()
    //       })
    //     });

    //     postData.filters = JSON.stringify({
    //       groupOp: 'OR',
    //       rules: rules
    //     })

    //     akunPusatLookup.trigger('reloadGrid', {
    //       page: 1
    //     })
    //   }, 500)
    // })

    // $('[name=penerimaan_nobukti]').on('input', function(event) {
    //   $('#lookupPenerimaanHeader').show()

    //   if (detectDeviceType() != 'desktop') {
    //     penerimaanHeaderLookup.setGridHeight(window.innerHeight / 1.5)
    //   }

    //   delay(() => {
    //     let postData = penerimaanHeaderLookup.getGridParam('postData')
    //     let colModels = penerimaanHeaderLookup.getGridParam('colModel')
    //     let rules = []

    //     colModels = colModels.filter((colModel) => {
    //       return colModel.name !== 'rn'
    //     })

    //     colModels.forEach(colModel => {
    //       rules.push({
    //         field: colModel.name,
    //         op: 'cn',
    //         data: $(this).val()
    //       })
    //     });

    //     postData.filters = JSON.stringify({
    //       groupOp: 'OR',
    //       rules: rules
    //     })

    //     penerimaanHeaderLookup.trigger('reloadGrid', {
    //       page: 1
    //     })
    //   }, 500)
    // })

    // $('[name=supir_id]').on('input', function(event) {
    //   $('#lookupSupir').show()

    //   if (detectDeviceType() != 'desktop') {
    //     supirLookup.setGridHeight(window.innerHeight / 1.5)
    //   }

    //   delay(() => {
    //     let postData = supirLookup.getGridParam('postData')
    //     let colModels = supirLookup.getGridParam('colModel')
    //     let rules = []

    //     colModels = colModels.filter((colModel) => {
    //       return colModel.name !== 'rn'
    //     })

    //     colModels.forEach(colModel => {
    //       rules.push({
    //         field: colModel.name,
    //         op: 'cn',
    //         data: $(this).val()
    //       })
    //     });

    //     postData.filters = JSON.stringify({
    //       groupOp: 'OR',
    //       rules: rules
    //     })

    //     supirLookup.trigger('reloadGrid', {
    //       page: 1
    //     })
    //   }, 500)
    // })

    // $('[name=pengeluaranStokheader_nobukti]').on('input', function(event) {
    //   $('#lookupPengeluaranStokHeader').show()

    //   if (detectDeviceType() != 'desktop') {
    //     pengeluaranStokHeaderLookup.setGridHeight(window.innerHeight / 1.5)
    //   }

    //   delay(() => {
    //     let postData = pengeluaranStokHeaderLookup.getGridParam('postData')
    //     let colModels = pengeluaranStokHeaderLookup.getGridParam('colModel')
    //     let rules = []

    //     colModels = colModels.filter((colModel) => {
    //       return colModel.name !== 'rn'
    //     })

    //     colModels.forEach(colModel => {
    //       rules.push({
    //         field: colModel.name,
    //         op: 'cn',
    //         data: $(this).val()
    //       })
    //     });

    //     postData.filters = JSON.stringify({
    //       groupOp: 'OR',
    //       rules: rules
    //     })

    //     pengeluaranStokHeaderLookup.trigger('reloadGrid', {
    //       page: 1
    //     })
    //   }, 500)
    // })
    

    $("#jqGrid").jqGrid({
        url: `{{ config('app.api_url') . 'penerimaanstokheader' }}`,
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
            label: 'Penerimaan nobukti',
            name: 'penerimaanstok_nobukti',
            align: 'left'
          },
          {
            label: 'Pengeluaran nobukti',
            name: 'pengeluaranstok_nobukti',
            align: 'left'
          },
          {
            label: 'Gudang',
            name: 'gudangs',
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
            label: 'nobon',
            name: 'nobon',
            align: 'left'
          },
          {
            label: 'hutang_nobukti',
            name: 'hutang_nobukti',
            align: 'left'
          },
          {
            label: 'gudang dari',
            name: 'gudangdari',
            align: 'left'
          },
          {
            label: 'gudang ke',
            name: 'gudangke',
            align: 'left'
          },
          {
            label: 'COA',
            name: 'coa',
            align: 'left'
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

          loadDetailData(id)
          activeGrid = $(this)
          indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
          page = $(this).jqGrid('getGridParam', 'page')
          let limit = $(this).jqGrid('getGridParam', 'postData').limit
          if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))
        },
        loadComplete: function(data) {

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

      .jqGrid('filterToolbar', {
        stringResult: true,
        searchOnEnter: false,
        defaultSearch: 'cn',
        groupOp: 'AND',
        disabledKeys: [17, 33, 34, 35, 36, 37, 38, 39, 40],
        beforeSearch: function() {
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
              editPenerimaanstokHeader(selectedId)
            }
          },
          {
            id: 'delete',
            innerHTML: '<i class="fa fa-trash"></i> DELETE',
            class: 'btn btn-danger btn-sm mr-1',
            onClick: () => {
              selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
              deletePenerimaanstokHeader(selectedId)
            }
          },
        ]

      })

    /* Append clear filter button */
    loadClearFilter($('#jqGrid'))

    /* Append global search */
    loadGlobalSearch($('#jqGrid'))

    /* Load detail grid */
    loadDetailGrid()

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

    if (!`{{ $myAuth->hasPermission('penerimaanstokheader', 'store') }}`) {
      $('#add').addClass('ui-disabled')
    }

    if (!`{{ $myAuth->hasPermission('penerimaanstokheader', 'update') }}`) {
      $('#edit').addClass('ui-disabled')
    }

    if (!`{{ $myAuth->hasPermission('penerimaanstokheader', 'destroy') }}`) {
      $('#delete').addClass('ui-disabled')
    }

    if (!`{{ $myAuth->hasPermission('penerimaanstokheader', 'export') }}`) {
      $('#export').addClass('ui-disabled')
    }

    if (!`{{ $myAuth->hasPermission('penerimaanstokheader', 'report') }}`) {
      $('#report').addClass('ui-disabled')
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
  })
</script>
@endpush()
@endsection