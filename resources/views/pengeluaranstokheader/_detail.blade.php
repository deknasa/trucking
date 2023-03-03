<!-- Grid -->
<div class="container-fluid my-4">
  <div class="row">
    <div class="col-12">
      <table id="detail"></table>
      <div id="detailPager"></div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  /**
   * Custom Functions
   */
  var delay = (function() {
    var timer = 0;
    return function(callback, ms) {
      clearTimeout(timer);
      timer = setTimeout(callback, ms);
    };
  })()

  function loadDetailGrid() {
    let pager = '#detailPager'

    $("#detail").jqGrid({
        url: `${apiUrl}pengeluaranstokdetail`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "local",
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
            formatter: 'currency',
            formatoptions: {
              decimalSeparator: '.',
              thousandsSeparator: ',',
              decimalPlaces:0              
            }
          },
          {
            label: 'harga',
            name: 'harga',
            align: 'right',
            formatter: 'currency',
            formatoptions: {
              decimalSeparator: '.',
              thousandsSeparator: ',',
              decimalPlaces:0              
            }
          },
          
          {
            label: 'persentasediscount',
            name: 'persentasediscount',
            align: 'right',
            formatter: 'currency',
            formatoptions: {
              decimalSeparator: '.',
              thousandsSeparator: ',',
              decimalPlaces:0              
            }
          },
          {
            label: 'nominaldiscount',
            name: 'nominaldiscount',
            align: 'right',
            formatter: 'currency',
            formatoptions: {
              decimalSeparator: '.',
              thousandsSeparator: ',',
              decimalPlaces:0              
            }
          },
          {
            label: 'vulkanisirke',
            name: 'vulkanisirke',
          },
          {
            label: 'TOTAL',
            name: 'total',
            align: 'right',
            formatter: 'currency',
            formatoptions: {
              decimalSeparator: '.',
              thousandsSeparator: ',',
              decimalPlaces:0              
            }
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
          },
          {
            label: 'modifiedby',
            name: 'modifiedby',
          },
         
        
        ],
        autowidth: true,
        shrinkToFit: false,
        height: 350,
        rowNum: 0,
        rownumbers: true,
        footerrow: true,
		    userDataOnFooter: true,
        rownumWidth: 45,
        rowList: [10, 20, 50, 0],
        toolbar: [true, "top"],
        sortable: true,
        // pager: pager,
        viewrecords: true,
        postData: {
          pengeluaranstokheader_id: id
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
        loadBeforeSend: (jqXHR) => {
          jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)
        },
        loadComplete: function(data) {
          changeJqGridRowListText()

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

          $('#detail').setSelection($('#detail').getDataIDs()[0])

          setHighlight($(this))

          if (data.attributes) {
            $(this).jqGrid('footerData', 'set', {
              vulkanisirke: 'Total:',
              total: data.attributes.totalNominal,
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
    $('#detail').setGridParam({
      url: `${apiUrl}pengeluaranstokdetail`,
      datatype: "json",
      postData: {
        pengeluaranstokheader_id: id
      }
    }).trigger('reloadGrid')
  }
</script>
@endpush()