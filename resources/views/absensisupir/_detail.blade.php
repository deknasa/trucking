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
  function loadDetailGrid(id) {
    let pager = '#detailPager'

    $("#detail").jqGrid({
        url: `${apiUrl}absensisupirdetail`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        colModel: [{
            label: 'TRADO',
            name: 'trado'
          },
          {
            label: 'SUPIR',
            name: 'supir',
          },
          {
            label: 'STATUS',
            name: 'status',
          },
  
          // {
          //   label: 'STATUS TRIP',
          //   name: 'statustrip',
          //   align: 'left',

          //   formatter: (value, options, rowData) => {
          //     if (value!='') {
          //       let statusTrip = JSON.parse(value)
          //       if (!statusTrip) {
          //         return ''
          //       }
          //       let formattedValue = $(`
          //       <div class="badge" style="background-color: ${statusTrip.WARNA}; color: #fff;">
          //         <span>${statusTrip.SINGKATAN}</span>
          //       </div>
          //     `)

          //       return formattedValue[0].outerHTML
          //     } 

          //     return ''
          //   },
          //   cellattr: (rowId, value, rowObject) => {
          //     try {
          //       let statusTrip = JSON.parse(rowObject.statustrip)

          //       if (!statusTrip) {
          //         return ` title=" "`
          //       }
                
          //       return ` title="${statusTrip.MEMO}"`
          //     } catch (error) {
          //       return ``
          //     }
          //   }
          // },
          {
            label: 'KETERANGAN',
            name: 'keterangan_detail',
          },
          {
            label: 'JAM',
            name: 'jam',
            formatter:'date',
            formatoptions:{
              srcformat: "H:i:s",
              newformat: "H:i",
              // userLocalTime : true
          }
          },
          {
            label: 'UANG JALAN',
            name: 'uangjalan',
            formatter: 'number',
            formatoptions: {
              thousandsSeparator: ",",
              decimalPlaces: 0
            },
            align: "right",
          },
          {
            label: 'JUMLAH TRIP',
            name: 'jumlahtrip',
            formatter: 'number',
            formatoptions: {
              thousandsSeparator: ",",
              decimalPlaces: 0
            },
            align: "right",
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
        // pager: pager,
        viewrecords: true,
        footerrow: true,
        userDataOnFooter: true,
        postData: {
          absensi_id: id
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
          jqXHR.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
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

          if (data.totalNominal) {
            $(this).jqGrid('footerData', 'set', {
              trado: 'Total:',
              uangjalan: data.totalNominal,
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
      url: `${apiUrl}absensisupirdetail`,
      datatype: "json",
      postData: {
        absensi_id: id
      }
    }).trigger('reloadGrid')
  }
</script>
@endpush()