@push('scripts')
<script>
  function loadDetailGrid() {
    let sortnameDetail = 'gajisupir_nobukti'
    let sortorderDetail = 'asc'
    let totalRecordDetail
    let limitDetail
    let postDataDetail
    let triggerClickDetail
    let indexRowDetail
    let pageDetail = 0;

    $("#detail").jqGrid({
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: 'local',
        data: [],
        idPrefix: 'detail',
        colModel: [{
            label: 'NO RINCIAN',
            name: 'gajisupir_nobukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            formatter: (value, options, rowData) => {
              if ((value == null) || (value == '')) {
                return '';
              }
              let tgldari = rowData.tgldariheadergajisupirheaderheader
              let tglsampai = rowData.tglsampaiheadergajisupirheaderheader
              let url = "{{route('gajisupirheader.index')}}"
              let formattedValue = $(`<a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}&nobukti=${value}" class="link-color" target="_blank">${value}</a>`)
              return formattedValue[0].outerHTML
            },

          },
          {
            label: 'NO BK',
            name: 'trado_id',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'SUPIR',
            name: 'supir_id',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          },
          {
            label: 'Gaji Supir',
            name: 'gajisupir',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'Biaya Extra (Trip)',
            name: 'biayaextra',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'Komisi Supir',
            name: 'komisisupir',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'Komisi Kenek',
            name: 'gajikenek',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },

          {
            label: 'TOTAL',
            name: 'total',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'U. JALAN',
            name: 'uangjalan',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'U. BBM',
            name: 'bbm',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'U. Makan',
            name: 'uangmakanharian',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'U. Makan Berjenjang',
            name: 'uangmakanberjenjang',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'B. Extra',
            name: 'biayaextraheader',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'Pot. Pinjaman',
            name: 'potonganpinjaman',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'POT. PINJAMAN (SEMUA)',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            name: 'potonganpinjamansemua',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'DEPOSITO',
            name: 'deposito',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },


          {
            label: 'TOL',
            name: 'tolsupir',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
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
          prosesgajisupir_id: id
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
              total: data.attributes.totalNominal,
              uangjalan: data.attributes.totalUangJalan,
              bbm: data.attributes.totalBBM,
              uangmakanharian: data.attributes.totalUangMakan,
              uangmakanberjenjang: data.attributes.totalUangMakanBerjenjang,
              biayaextraheader: data.attributes.totalBiayaExtraHeader,
              potonganpinjaman: data.attributes.totalPinjaman,
              potonganpinjamansemua: data.attributes.totalPinjamanSemua,
              deposito: data.attributes.totalDeposito,
              komisisupir: data.attributes.totalKomisi,
              gajisupir: data.attributes.totalGajiSupir,
              gajikenek: data.attributes.totalGajiKenek,
              biayaextra: data.attributes.totalBiayaExtra,
              tolsupir: data.attributes.totalTol
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
      .customPager()

    /* Append clear filter button */
    loadClearFilter($('#detail'))

    /* Append global search */
    loadGlobalSearch($('#detail'))
  }

  function loadDetailData(id) {
    abortGridLastRequest($('#detail'))

    $('#detail').setGridParam({
      url: `${apiUrl}prosesgajisupirdetail`,
      datatype: "json",
      postData: {
        prosesgajisupir_id: id,
        proses: 'reload'
      },
      page: 1
    }).trigger('reloadGrid')
  }
</script>
@endpush