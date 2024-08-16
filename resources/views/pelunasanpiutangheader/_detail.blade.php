
@push('scripts')
<script>
  function loadDetailGrid() {
    let sortnameDetail = 'nobukti'
    let sortorderDetail = 'asc'
    let totalRecordDetail
    let limitDetail
    let postDataDetail
    let triggerClickDetail
    let indexRowDetail
    let pageDetail = 0;

    $("#detail").jqGrid({
        datatype: 'local',
        data: [],
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        idPrefix: 'detail',
        colModel: [{
            label: 'NO BUKTI',
            name: 'nobukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'NO BUKTI PIUTANG',
            name: 'piutang_nobukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            formatter: (value, options, rowData) => {
              if ((value == null) ||( value == '')) {
                return '';
              }
              let tgldari = rowData.tgldariheaderpiutangheader
              let tglsampai = rowData.tglsampaiheaderpiutangheader
              let url = "{{route('piutangheader.index')}}"
              let formattedValue = $(`
              <a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}" class="link-color" target="_blank">${value}</a>
             `)
             return formattedValue[0].outerHTML
           }
          },
          {
            label: 'NO BUKTI INVOICE',
            name: 'invoice_nobukti',
            align: 'left',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            formatter: (value, options, rowData) => {
              let tgldari
              let tglsampai
              let url
              if ((value == null) ||( value == '')) {
                return '';
              }
              if (rowData.tgldariheaderinvoiceheader) {
                tgldari = rowData.tgldariheaderinvoiceheader
                tglsampai = rowData.tglsampaiheaderinvoiceheader
                url = "{{route('invoiceheader.index')}}"
              }else if (rowData.tgldariheaderinvoiceextraheader) {
                tgldari = rowData.tgldariheaderinvoiceextraheader
                tglsampai = rowData.tglsampaiheaderinvoiceextraheader
                url = "{{route('invoiceextraheader.index')}}"
              }
              let formattedValue
              if (url) {
                formattedValue = $(`<a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}" class="link-color" target="_blank">${value}</a>`)
              }else{
                formattedValue = $(`<span>${value}</span>`)
              }
              return formattedValue[0].outerHTML
            },
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
            width: (detectDeviceType() == "desktop") ? lg_dekstop_2 : lg_mobile_2
          },
          {
            label: 'NOMINAL',
            name: 'nominal',
            align: 'right',
            formatter: currencyFormat,
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'KET. POTONGAN',
            name: 'keteranganpotongan',
            width: (detectDeviceType() == "desktop") ? lg_dekstop_2 : lg_mobile_2
          },
          {
            label: 'KODE PERKIRAAN POTONGAN',
            name: 'coapotongan',
            width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
            width: 220
          },
          {
            label: 'POTONGAN',
            name: 'potongan',
            align: 'right',
            formatter: currencyFormat,
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'KET. POTONGAN B. PPH',
            name: 'keteranganpotonganpph',
            width: (detectDeviceType() == "desktop") ? lg_dekstop_2 : lg_mobile_2
          },
          {
            label: 'KODE PERKIRAAN POTONGAN B. PPH',
            name: 'coapotonganpph',
            width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
            width: 220
          },
          {
            label: 'POTONGAN B. PPH',
            name: 'potonganpph',
            align: 'right',
            formatter: currencyFormat,
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'NOMINAL LEBIH BAYAR',
            name: 'nominallebihbayar',
            align: 'right',
            formatter: currencyFormat,
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
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
        sortname: sortnameDetail,
        sortorder: sortorderDetail,
        page: pageDetail,
        footerrow: true,
        userDataOnFooter: true,
        viewrecords: true,
        postData: {
          pelunasanpiutang_id: id
        },
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
          activeGrid = $(this)
        },
        loadComplete: function(data) {
          changeJqGridRowListText()

          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))

          /* Set global variables */
          sortnameDetail = $(this).jqGrid("getGridParam", "sortname")
          sortorderDetail = $(this).jqGrid("getGridParam", "sortorder")
          totalRecordDetail = $(this).getGridParam("records")
          limitDetail = $(this).jqGrid('getGridParam', 'postData').limit
          postDataDetail = $(this).jqGrid('getGridParam', 'postData')
          triggerClick = false

          $('.clearsearchclass').click(function() {
            clearColumnSearch($(this))
          })

          if (indexRowDetail > $(this).getDataIDs().length - 1) {
            indexRowDetail = $(this).getDataIDs().length - 1;
          }

          setHighlight($(this))

          if (data.attributes) {
            $(this).jqGrid('footerData', 'set', {
              nobukti: 'Total:',
              nominal: data.attributes.totalNominal,
              potongan: data.attributes.totalPotongan,
              potonganpph: data.attributes.totalPotonganPPH,
              nominallebihbayar: data.attributes.totalNominalLebih,
            }, true)
          }

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
          
          clearGlobalSearch($('#detail'))
        },
      })

      .jqGrid("navGrid", pager, {
        search: false,
        refresh: false,
        add: false,
        edit: false,
        del: false,
      })

      .customPager()
    /* Append clear filter button */
    loadClearFilter($('#detail'))

    /* Append global search */
    loadGlobalSearch($('#detail'))
  }

  function loadDetailData(id) {
        abortGridLastRequest($('#detail'))

        $('#detail').setGridParam({
      url: `${apiUrl}pelunasanpiutangdetail`,
      datatype: "json",
      postData: {
        pelunasanpiutang_id: id
      },
      page: 1
    }).trigger('reloadGrid')
  }
</script>
@endpush