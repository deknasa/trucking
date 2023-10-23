@extends('layouts.master')

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
          <div id="tabs-detail">
            <ul class="dejavu">
              <li><a href="#detail-tab">Details</a></li>
              <li><a href="#ebs-tab">Jurnal EBS</a></li>
              <li><a href="#pengeluaran-tab">Jurnal Kas/bank</a></li>
              <li><a href="#jurnalpotsemua-tab">Jurnal Pot. Semua</a></li>
              <li><a href="#jurnalpotpribadi-tab">Jurnal Pot. Pribadi</a></li>
              <li><a href="#jurnaldeposito-tab">Jurnal Deposito</a></li>
              <li><a href="#jurnalbbm-tab">Jurnal BBM</a></li>
              <li><a href="#pengembalian-tab">Jurnal Pengembalian Kas Gantung</a></li>
            </ul>
            <div id="detail-tab">
              <table id="detail"></table>
            </div>
            <div id="ebs-tab">
              <table id="jurnalGrid"></table>
            </div>
            <div id="pengeluaran-tab">
              <table id="pengeluaranGrid"></table>
            </div>
            <div id="jurnalpotsemua-tab">
              <table id="potsemuaGrid"></table>
            </div>
            <div id="jurnalpotpribadi-tab">
              <table id="potpribadiGrid"></table>
            </div>
            <div id="jurnaldeposito-tab">
              <table id="depositoGrid"></table>
            </div>
            <div id="jurnalbbm-tab">
              <table id="bbmGrid"></table>
            </div>
            <div id="pengembalian-tab">
              <table id="pengembalianGrid"></table>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@include('prosesgajisupirheader._modal')
<!-- Detail -->
@include('prosesgajisupirheader._detail')
@include('pengeluaran._pengeluaran')
@include('prosesgajisupirheader._potsemua')
@include('jurnalumum._jurnal')
@include('prosesgajisupirheader._potpribadi')
@include('prosesgajisupirheader._deposito')
@include('prosesgajisupirheader._bbm')
@include('prosesgajisupirheader._uangjalan')

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
  let currentTab = 'detail'
  let hasDetail = false

  $(document).ready(function() {
    $("#tabs-detail").tabs()

    let pengeluaran_nobukti = $('#jqGrid').jqGrid('getCell', id, 'pengeluaran_nobukti')
    let nobukti = $('#jqGrid').jqGrid('getCell', id, 'nobukti')
    loadDetailGrid()
    loadPengeluaranGrid(pengeluaran_nobukti)
    loadPotSemuaGrid(nobukti)
    loadPotPribadiGrid(nobukti)
    loadDepositoGrid(nobukti)
    loadBBMGrid(nobukti)
    loadJurnalUmumGrid(nobukti)
    loadPengembalianGrid(nobukti)

    setRange()
    initDatepicker()
    $(document).on('click', '#btnReload', function(event) {
      loadDataHeader('prosesgajisupirheader')
    })
    $("#jqGrid").jqGrid({
        url: `${apiUrl}prosesgajisupirheader`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        postData: {
          tgldari: $('#tgldariheader').val(),
          tglsampai: $('#tglsampaiheader').val()
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
              if (!statusApproval) {
                return ''
              }
              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusApproval.WARNA}; color: #fff;">
                  <span>${statusApproval.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusApproval = JSON.parse(rowObject.statusapproval)
              if (!statusApproval) {
                return ` title=" "`
              }
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
            label: 'U. borongan',
            name: 'total',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'U. borongan (post kas keluar)',
            width: 280,
            name: 'totalposting',
            align: 'right',
            formatter: currencyFormat,
          },
          // {
          //   label: 'GAJI SUPIR',
          //   name: 'gajisupir',
          //   align: 'right',
          //   formatter: currencyFormat,
          // },
          {
            label: 'KOMISI SUPIR',
            name: 'komisisupir',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'KOMISI KENEK',
            name: 'gajikenek',
            align: 'right',
            formatter: currencyFormat,
          },
          // {
          //   label: 'BIAYA EXTRA',
          //   name: 'biayaextra',
          //   align: 'right',
          //   formatter: currencyFormat,
          // },
          {
            label: 'U. JALAN',
            name: 'uangjalan',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'U. BBM',
            name: 'bbm',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'U. MAKAN',
            name: 'uangmakanharian',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'U. MAKAN BERJENJANG',
            name: 'uangmakanberjenjang',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'POT. PINJAMAN',
            name: 'potonganpinjaman',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'POT. PINJAMAN (SEMUA)',
            width: 210,
            name: 'potonganpinjamansemua',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'DEPOSITO',
            name: 'deposito',
            align: 'right',
            formatter: currencyFormat,
          },

          {
            label: 'PERIODE',
            name: 'periode',
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'TGL DARI',
            name: 'tgldari',
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'TGL SAMPAI',
            name: 'tglsampai',
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
            label: 'USER BUKA CETAK',
            name: 'userbukacetak',
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
            label: 'KETERANGAN',
            width: 210,
            name: 'keterangan',
            align: 'left'
          },
          {
            label: 'NO BUKTI pengeluaran',
            width: 210,
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
            },
          },
          {
            label: 'MODIFIED BY',
            name: 'modifiedby',
            align: 'left'
          },
          {
            label: 'CREATED AT',
            name: 'created_at',
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y H:i:s"
            }
          },
          {
            label: 'UPDATED AT',
            name: 'updated_at',
            align: 'left',
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
        footerrow: true,
        userDataOnFooter: true,
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
          let nobukti = $(`#jqGrid tr#${id}`).find(`td[aria-describedby="jqGrid_nobukti"]`).attr('title') ?? '';
          let pengeluaran_nobukti = $(`#jqGrid tr#${id}`).find(`td[aria-describedby="jqGrid_pengeluaran_nobukti"]`).attr('title') ?? '';
          activeGrid = $(this)
          indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
          page = $(this).jqGrid('getGridParam', 'page')
          let limit = $(this).jqGrid('getGridParam', 'postData').limit
          if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))

          loadDetailData(id)
          loadPengeluaranData(id,pengeluaran_nobukti)
          loadPotSemuaData(nobukti)
          loadPotPribadiData(nobukti)
          loadDepositoData(nobukti)
          loadBBMData(nobukti)
          loadJurnalUmumData(id, nobukti)
          loadPengembalianData(nobukti)
        },
        loadComplete: function(data) {
          changeJqGridRowListText()
          console.log(data.data)
          if (data.data.length === 0) {
            console.log('0 data')
            $('#detail, #potsemuaGrid, #potpribadiGrid, #depositoGrid, #bbmGrid, #pengeluaranGrid, #jurnalGrid, #pengembalianGrid').each((index, element) => {
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

          if (data.attributes) {
            $(this).jqGrid('footerData', 'set', {
              nobukti: 'Total:',
              total: data.attributes.totalAll,
              totalposting: data.attributes.totalPosting,
              uangjalan: data.attributes.totalJalan,
              bbm: data.attributes.totalBbm,
              potonganpinjaman: data.attributes.totalPotPinj,
              potonganpinjamansemua: data.attributes.totalPotSemua,
              deposito: data.attributes.totalDeposito,
              uangmakanberjenjang: data.attributes.totalMakanBerjenjang,
              uangmakanharian: data.attributes.totalMakan,
              komisisupir: data.attributes.totalKomisiSupir,
              gajikenek: data.attributes.totalGajiKenek,
              gajisupir: data.attributes.totalGajiSupir,
              biayaextra: data.attributes.totalBiayaExtra,
            }, true)
          }
          $('#left-nav').find('button').attr('disabled', false)
          permission()
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
          $('#left-nav').find(`button:not(#add)`).attr('disabled', 'disabled')
          $(this).setGridParam({
            postData: {
              tgldari: $('#tgldariheader').val(),
              tglsampai: $('#tglsampaiheader').val()
            },
          })
          clearGlobalSearch($('#jqGrid'))
        },
      })

      .customPager({
        buttons: [{
            id: 'add',
            innerHTML: '<i class="fa fa-plus"></i> ADD',
            class: 'btn btn-primary btn-sm mr-1',
            onClick: function(event) {
              createProsesGajiSupirHeader()
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
              viewProsesGajiSupirHeader(selectedId)
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
                window.open(`{{ route('prosesgajisupirheader.report') }}?id=${selectedId}`)
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
                showDialog('Harap pilih salah satu record')
              } else {
                window.open(`{{ route('prosesgajisupirheader.export') }}?id=${selectedId}`)
              }
            }
          },
        ],
        extndBtn: [{
          id: 'approve',
          title: 'Approve',
          caption: 'Approve',
          innerHTML: '<i class="fa fa-check"></i> UN/APPROVAL',
          class: 'btn btn-purple btn-sm mr-1 dropdown-toggle ',
          dropmenuHTML: [
            {
              id: 'approval-buka-cetak',
              text: "un/Approval Buka Cetak PROSES  GAJI SUPIR",
              onClick: () => {
                if (`{{ $myAuth->hasPermission('approvalbukacetak', 'store') }}`) {
                  let tglbukacetak = $('#tgldariheader').val().split('-');
                  tglbukacetak =tglbukacetak[1] + '-' + tglbukacetak[2];
                  selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                  if (selectedId == null || selectedId == '' || selectedId == undefined) {
                    showDialog('Harap pilih salah satu record')
                  }else{
                    approvalBukaCetak(tglbukacetak,'PROSESGAJISUPIRHEADER',[selectedId]);
                  }
                }
              }
            },
          ],
        }]

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

    function permission() {
      if (!`{{ $myAuth->hasPermission('prosesgajisupirheader', 'store') }}`) {
        $('#add').attr('disabled', 'disabled')
      }
      if (!`{{ $myAuth->hasPermission('prosesgajisupirheader', 'show') }}`) {
        $('#view').attr('disabled', 'disabled')
      }
      if (!`{{ $myAuth->hasPermission('prosesgajisupirheader', 'update') }}`) {
        $('#edit').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('prosesgajisupirheader', 'destroy') }}`) {
        $('#delete').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('prosesgajisupirheader', 'export') }}`) {
        $('#export').attr('disabled', 'disabled')
      }

      if (!`{{ $myAuth->hasPermission('prosesgajisupirheader', 'report') }}`) {
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
        xhr.open('GET', `{{ config('app.api_url') }}prosesgajisupirheader/export?${params}`, true)
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
              link.download = `laporanpengeluarantrucking${(new Date).getTime()}.xlsx`
              link.click()

              submitButton.removeAttr('disabled')
            }
          }
        }

        xhr.send()
      } else if ($('#rangeModal').data('action') == 'report') {
        window.open(`{{ route('prosesgajisupirheader.report') }}?${params}`)

        submitButton.removeAttr('disabled')
      }
    })

  })
</script>
@endpush()
@endsection