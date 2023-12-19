
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
        datatype: "json",
        colModel: [
          // {
          //   label: 'PENERIMAAN',
          //   name: 'penerimaan_id',
          // },
          {
            label: 'NO BUKTI',
            name: 'nobukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'NO WARKAT',
            name: 'nowarkat',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'TGL JATUH TEMPO',
            name: 'tgljatuhtempo',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
            width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
          },
          {
            label: 'NOMINAL',
            name: 'nominal',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat
          },
          {
            label: 'KODE PERKIRAAN DEBET', 
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            name: 'coadebet',
          },
          {
            label: 'KODE PERKIRAAN kredit', 
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            name: 'coakredit',
          },

          {
            label: 'BANK',
            name: 'bank_id',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'INVOICE NO BUKTI',
            name: 'invoice_nobukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            align: 'left',
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
            label: 'PELUNASAN PIUTANG NO BUKTI', 
            width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
            name: 'pelunasanpiutang_nobukti',
            formatter: (value, options, rowData) => {
              if ((value == null) ||( value == '')) {
                return '';
              }
              let tgldari = rowData.tgldariheaderpelunasanpiutangheader
              let tglsampai = rowData.tglsampaiheaderpelunasanpiutangheader
              let url = "{{route('pelunasanpiutangheader.index')}}"
              let formattedValue = $(`
              <a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}" class="link-color" target="_blank">${value}</a>
             `)
             return formattedValue[0].outerHTML
           }
          },
          {
            label: 'PENERIMAAN GIRO NO BUKTI',
            name: 'penerimaangiro_nobukti',
            width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
            formatter: (value, options, rowData) => {
              if ((value == null) ||( value == '')) {
                return '';
              }
              let tgldari = rowData.tgldariheaderpenerimaangiroheader
              let tglsampai = rowData.tglsampaiheaderpenerimaangiroheader
              let url = "{{route('penerimaangiroheader.index')}}"
              let formattedValue = $(`
              <a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}" class="link-color" target="_blank">${value}</a>
             `)
             return formattedValue[0].outerHTML
           }
          },
          {
            label: 'BANK PELANGGAN',
            name: 'bankpelanggan_id',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },


          {
            label: 'BULAN BEBAN',
            name: 'bulanbeban',
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
        footerrow: true,
        userDataOnFooter: true,
        toolbar: [true, "top"],
        sortable: true,
        sortname: sortnameDetail,
        sortorder: sortorderDetail,
        page: pageDetail,
        viewrecords: true,
        postData: {
          penerimaan_id: id
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
            }, true)
          }

        }
      })

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
      url: `${apiUrl}penerimaandetail`,
      datatype: "json",
      postData: {
        penerimaan_id: id
      },
      page: 1
    }).trigger('reloadGrid')
  }
</script>
@endpush