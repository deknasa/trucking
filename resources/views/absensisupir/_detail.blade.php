<table id="detail"></table>

<script>
  function loadGrid(id) {
    let sortnameDetail = 'nobukti'
    let sortorderDetail = 'asc'
    let totalRecordDetail
    let limitDetail
    let postDataDetail
    let triggerClickDetail
    let indexRowDetail
    let pageDetail = 0;

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
            formatter: 'date',
            formatoptions: {
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
        sortname: sortnameDetail,
        sortorder: sortorderDetail,
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
      },
      page: 1
    }).trigger('reloadGrid')
  }
</script>