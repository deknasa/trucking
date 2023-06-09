<table id="detail"></table>

<script>
  function loadGrid(id) {
    let sortnameDetail = 'suratpengantar_nobukti'
    let sortorderDetail = 'asc'
    let totalRecordDetail
    let limitDetail
    let postDataDetail
    let triggerClickDetail
    let indexRowDetail
    let pageDetail = 0;

    $("#detail").jqGrid({
        url: `${apiUrl}gajisupirdetail`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        colModel: [{
            label: 'NO TRIP',
            name: 'suratpengantar_nobukti',
          },
          {
            label: 'TANGGAL BON',
            name: 'tglsp',
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },

          {
            label: 'DARI',
            name: 'dari',
          },
          {
            label: 'TUJUAN',
            name: 'sampai',
          },
          {
            label: 'NO CONT',
            name: 'nocont',
          },
          {
            label: 'NO SP',
            name: 'nosp',
          },
          {
            label: 'GAJI SUPIR',
            name: 'gajisupir',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'GAJI KENEK',
            name: 'gajikenek',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'KOMISI SUPIR',
            name: 'komisisupir',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'TOL SUPIR',
            name: 'tolsupir',
            formatter: currencyFormat,
            align: "right",
          },
          {
            label: 'NO BUKTI RITASI',
            name: 'ritasi_nobukti',
            align: 'left'
          },
          {
            label: 'UPAH RITASI',
            name: 'upahritasi',
            formatter: currencyFormat,
            align: "right",
          },
          {
            label: 'STATUS RITASI',
            name: 'statusritasi',
            align: 'left'
          },
          {
            label: 'BIAYA EXTRA',
            name: 'biayaextra',
            formatter: currencyFormat,
            align: "right",
          },
          {
            label: 'KET. BIAYA EXTRA',
            name: 'keteranganbiayatambahan',
            align: 'left'
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
          gajisupir_id: id
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
              suratpengantar_nobukti: 'Total:',
              gajisupir: data.attributes.totalGajiSupir,
              gajikenek: data.attributes.totalGajiKenek,
              komisisupir: data.attributes.totalKomisiSupir,
              upahritasi: data.attributes.totalUpahRitasi,
              tolsupir: data.attributes.totalTolSupir,
              biayaextra: data.attributes.totalBiayaExtra,
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
      url: `${apiUrl}gajisupirdetail`,
      datatype: "json",
      postData: {
        gajisupir_id: id
      },
      page: 1
    }).trigger('reloadGrid')
  }
</script>