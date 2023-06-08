@include('layouts._rangeheaderlookup')
<table id="pengeluaranHeaderLookup" class="lookup-grid" style="width: 100%;"></table>
<div id="pengeluaranHeaderLookupPager"></div>

@push('scripts')
<script>

  setRangeLookup()
  initDatepicker()
  $(document).on('click', '#btnReloadLookup', function(event) {
    loadDataHeaderLookup('pengeluaran', 'pengeluaranHeaderLookup')
  })
  $('#pengeluaranHeaderLookup').jqGrid({
      url: `{{ config('app.api_url') . 'pengeluaran' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      postData: {
        tgldari: $('#tgldariheaderlookup').val(),
        tglsampai: $('#tglsampaiheaderlookup').val(),
      },
      datatype: "json",
      colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '70px',
            search: false,
          hidden: true
        },
        // {
        //   label: 'STATUS APPROVAL',
        //   name: 'statusapproval',
        //   align: 'left',
        //   stype: 'select',
        //   searchoptions: {
        //     dataInit: function(element) {
        //       $(element).select2({
        //         width: 'resolve',
        //         theme: "bootstrap4",
        //         ajax: {
        //           url: `${apiUrl}parameter/combo`,
        //           dataType: 'JSON',
        //           headers: {
        //             Authorization: `Bearer ${accessToken}`
        //           },
        //           data: {
        //             grp: 'STATUS APPROVAL',
        //             subgrp: 'STATUS APPROVAL'
        //           },
        //           beforeSend: () => {
        //             // clear options
        //             $(element).data('select2').$results.children().filter((index, element) => {
        //               // clear options except index 0, which
        //               // is the "searching..." label
        //               if (index > 0) {
        //                 element.remove()
        //               }
        //             })
        //           },
        //           processResults: (response) => {
        //             let formattedResponse = response.data.map(row => ({
        //               id: row.text,
        //               text: row.text
        //             }));

        //             formattedResponse.unshift({
        //               id: '',
        //               text: 'ALL'
        //             });

        //             return {
        //               results: formattedResponse
        //             };
        //           },
        //         }
        //       });
        //     }
        //   },
        //   formatter: (value, options, rowData) => {
        //     let statusApproval = JSON.parse(value)
        //     let formattedValue = $(`
        //         <div class="badge" style="background-color: ${statusApproval.WARNA}; color: #fff;">
        //           <span>${statusApproval.SINGKATAN}</span>
        //         </div>
        //       `)

        //     return formattedValue[0].outerHTML
        //   },
        //   cellattr: (rowId, value, rowObject) => {
        //     let statusApproval = JSON.parse(rowObject.statusapproval)

        //     return ` title="${statusApproval.MEMO}"`
        //   }
        // },
        // {
        //   label: 'STATUS CETAK',
        //   name: 'statuscetak',
        //   align: 'left',
        //   stype: 'select',
        //   searchoptions: {
        //     dataInit: function(element) {
        //       $(element).select2({
        //         width: 'resolve',
        //         theme: "bootstrap4",
        //         ajax: {
        //           url: `${apiUrl}parameter/combo`,
        //           dataType: 'JSON',
        //           headers: {
        //             Authorization: `Bearer ${accessToken}`
        //           },
        //           data: {
        //             grp: 'STATUS CETAK',
        //             subgrp: 'STATUS CETAK'
        //           },
        //           beforeSend: () => {
        //             // clear options
        //             $(element).data('select2').$results.children().filter((index, element) => {
        //               // clear options except index 0, which
        //               // is the "searching..." label
        //               if (index > 0) {
        //                 element.remove()
        //               }
        //             })
        //           },
        //           processResults: (response) => {
        //             let formattedResponse = response.data.map(row => ({
        //               id: row.text,
        //               text: row.text
        //             }));

        //             formattedResponse.unshift({
        //               id: '',
        //               text: 'ALL'
        //             });

        //             return {
        //               results: formattedResponse
        //             };
        //           },
        //         }
        //       });
        //     }
        //   },
        //   formatter: (value, options, rowData) => {
        //     let statusCetak = JSON.parse(value)

        //     let formattedValue = $(`
        //         <div class="badge" style="background-color: ${statusCetak.WARNA}; color: #fff;">
        //           <span>${statusCetak.SINGKATAN}</span>
        //         </div>
        //       `)

        //     return formattedValue[0].outerHTML
        //   },
        //   cellattr: (rowId, value, rowObject) => {
        //     let statusCetak = JSON.parse(rowObject.statuscetak)

        //     return ` title="${statusCetak.MEMO}"`
        //   }
        // },
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
          label: 'PELANGGAN ',
          name: 'pelanggan_id',
          align: 'left'
        },
        // {
        //   label: 'STATUS JNS TRANSAKSI',
        //   name: 'statusjenistransaksi',
        //   align: 'left',
        //   stype: 'select',
        //   searchoptions: {
        //     dataInit: function(element) {
        //       $(element).select2({
        //         width: 'resolve',
        //         theme: "bootstrap4",
        //         ajax: {
        //           url: `${apiUrl}parameter/combo`,
        //           dataType: 'JSON',
        //           headers: {
        //             Authorization: `Bearer ${accessToken}`
        //           },
        //           data: {
        //             grp: 'JENIS TRANSAKSI',
        //             subgrp: 'JENIS TRANSAKSI'
        //           },
        //           beforeSend: () => {
        //             // clear options
        //             $(element).data('select2').$results.children().filter((index, element) => {
        //               // clear options except index 0, which
        //               // is the "searching..." label
        //               if (index > 0) {
        //                 element.remove()
        //               }
        //             })
        //           },
        //           processResults: (response) => {
        //             let formattedResponse = response.data.map(row => ({
        //               id: row.text,
        //               text: row.text
        //             }));

        //             formattedResponse.unshift({
        //               id: '',
        //               text: 'ALL'
        //             });

        //             return {
        //               results: formattedResponse
        //             };
        //           },
        //         }
        //       });
        //     }
        //   },
        //   formatter: (value, options, rowData) => {
        //     let statusJnsTrans = JSON.parse(value)

        //     let formattedValue = $(`
        //         <div class="badge" style="background-color: ${statusJnsTrans.WARNA}; color: #fff;">
        //           <span>${statusJnsTrans.SINGKATAN}</span>
        //         </div>
        //       `)

        //     return formattedValue[0].outerHTML
        //   },
        //   cellattr: (rowId, value, rowObject) => {
        //     let statusJnsTrans = JSON.parse(rowObject.statusjenistransaksi)

        //     return ` title="${statusJnsTrans.MEMO}"`
        //   }
        // },
        {
          label: 'POSTING DARI',
          name: 'postingdari',
          align: 'left'
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
          label: 'DIBAYARKAN KE',
          name: 'dibayarke',
          align: 'left'
        },
        {
          label: 'CABANG',
          name: 'cabang_id',
          align: 'left'
        },
        {
          label: 'BANK',
          name: 'bank_id',
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
      responsive: true,
      shrinkToFit: false,
      height: 450,
      rowNum: 10,
      rownumbers: true,
      rownumWidth: 45,
      rowList: [10, 20, 50, 0],
      toolbar: [true, "top"],
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      page: 1,
      pager: $('#pengeluaranHeaderLookupPager'),
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
      onSelectRow: function(id) {
        activeGrid = $(this)
        id = $(this).jqGrid('getCell', id, 'rn') - 1
        indexRow = id
        page = $(this).jqGrid('getGridParam', 'page')
        let rows = $(this).jqGrid('getGridParam', 'postData').limit
        if (indexRow >= rows) indexRow = (indexRow - rows * (page - 1))
      },
      loadBeforeSend: function(jqXHR) {
        jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)

        setGridLastRequest($(this), jqXHR)
      },
      loadComplete: function(data) {
          changeJqGridRowListText()
        if (detectDeviceType() == 'desktop') {
          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))

          if (indexRow - 1 > $('#pengeluaranHeaderLookup').getGridParam().reccount) {
            indexRow = $('#pengeluaranHeaderLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#pengeluaranHeaderLookup [id="${$('#pengeluaranHeaderLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#pengeluaranHeaderLookup [id="${$('#pengeluaranHeaderLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#pengeluaranHeaderLookup').getDataIDs()[indexRow] == undefined) {
              $(`#pengeluaranHeaderLookup [id="` + $('#pengeluaranHeaderLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#pengeluaranHeaderLookup').setSelection($('#pengeluaranHeaderLookup').getDataIDs()[indexRow])
          }
        }

        /* Set global variables */
        sortname = $(this).jqGrid("getGridParam", "sortname")
        sortorder = $(this).jqGrid("getGridParam", "sortorder")
        totalRecord = $(this).getGridParam("records")
        limit = $(this).jqGrid('getGridParam', 'postData').limit
        postData = $(this).jqGrid('getGridParam', 'postData')

        $('.clearsearchclass').click(function() {
          clearColumnSearch($(this))
        })

        $(this).setGridWidth($('#lookupPengeluaranHeader').prev().width())
        setHighlight($(this))
      }
    })

    .jqGrid("setLabel", "rn", "No.")
    .jqGrid('filterToolbar', {
      stringResult: true,
      searchOnEnter: false,
      defaultSearch: 'cn',
      groupOp: 'AND',
      disabledKeys: [16, 17, 18, 33, 34, 35, 36, 37, 38, 39, 40],
      beforeSearch: function() {
        abortGridLastRequest($(this))

        clearGlobalSearch($('#pengeluaranHeaderLookup'))
      },
    })

  loadGlobalSearch($('#pengeluaranHeaderLookup'))
  loadClearFilter($('#pengeluaranHeaderLookup'))
</script>