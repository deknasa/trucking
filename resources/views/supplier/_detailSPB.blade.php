
@push('scripts')
<script>
  function loadSPBGrid() {
    let sortnameDetail = 'nobukti'
    let sortorderDetail = 'asc'
    let totalRecordDetail
    let limitDetail
    let postDataDetail
    let triggerClickDetail
    let indexRowDetail
    let pageDetail = 0;
    var stokIdSpb;

    $("#detailSPB").jqGrid({
        datatype: 'local',
        data: [],
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        idPrefix: 'detailSPB',
        colModel: [
          {
            label: 'NO BUKTI',
            name: 'nobukti',
          }, 
          {
            label: 'stok',
            name: 'stok',
          },         
          
          {
            label: 'qty',
            name: 'qty',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'harga',
            name: 'harga',
            align: 'right',
            formatter: currencyFormat,
          },
          
          {
            label: 'persentase discount',
            name: 'persentasediscount',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'nominal discount',
            name: 'nominaldiscount',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'vulkanisir ke',
            name: 'vulkanisirke',
          },
          {
            label: 'status ban',
            name: 'statusban',
          },
          {
            label: 'TOTAL',
            name: 'total',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
          },
          {
            label: 'MODIFIED BY',
            name: 'modifiedby',
          },
         
        
        ],
        autowidth: true,
        shrinkToFit: false,
        height: 350,
        rowNum: 10,
        rownumbers: true,
        footerrow: true,
        userDataOnFooter: true,
        rownumWidth: 45,
        rowList: [10, 20, 50, 0],
        toolbar: [true, "top"],
        sortable: true,
        sortname: sortnameDetail,
        sortorder: sortorderDetail,
        page: pageDetail,
        prmNames: {
          sort: 'sortIndex',
          order: 'sortOrder',
          rows: 'limit'
        },
        viewrecords: true,
        postData: {
          stok_id: stokIdSpb
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

          // if (data.attributes) {
          //   $(this).jqGrid('footerData', 'set', {
          //     nobukti: 'Total:',
          //     total: data.attributes.totalNominal,
          //   }, true)
          // }
          
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
          
          clearGlobalSearch($('#detailSPB'))
        },
      })

      .jqGrid("navGrid", pager, {
        search: false,
        refresh: false,
        add: false,
        edit: false,
        del: false,
      })
     
    /* Append clear filter button */
    loadClearFilter($('#detailSPB'))
    
    /* Append global search */
    loadGlobalSearch($('#detailSPB'))
  }

  function loadSPBData(stok_id) {
    // console.log(masterSupplierId);
    abortGridLastRequest($('#detailSPB'))
    stokIdSpb = stok_id
    $('#detailSPB').setGridParam({
      url: `${apiUrl}penerimaanstokdetail/supplier/${masterSupplierId}`,
      datatype: "json",
      page:1,
      postData: {
        stok_id: stok_id
      },
    }).trigger('reloadGrid')
  }
  
</script>
@endpush