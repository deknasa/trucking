
@push('scripts')
<script>
  function loadDataTidakLengkapGrid() {
    let sortnameDetail = 'trado'
    let sortorderDetail = 'asc'
    let totalRecordDetail
    let limitDetail
    let postDataDetail
    let triggerClickDetail
    let indexRowDetail
    let pageDetail = 0;

    $("#dataTidakLengkapGrid").jqGrid({
        datatype: 'local',
        data: [],
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        idPrefix: 'detailGrid',
        colModel: [{
            label: 'TRADO',
            name: 'trado',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'SUPIR',
            name: 'supir',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          },
          {
            label: 'STATUS',
            name: 'status',
            width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
          },
          {
            label: 'jenis kendaraan',
            name: 'statusjeniskendaraan',
            width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
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
            width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
          },
          {
            label: 'JAM',
            name: 'jam',
            formatter: 'date',
            hidden: true,
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            formatoptions: {
              srcformat: "H:i:s",
              newformat: "H:i",
              // userLocalTime : true
            }
          },
          {
            label: 'UANG JALAN',
            name: 'uangjalan',
            align: 'right',
            formatter: currencyFormat,
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'JLH TRIP',
            name: 'jumlahtrip',
            align: 'right',
            formatter: currencyFormat,
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
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
          absensi_id: id,
          from: "tidaklengkap"
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

          if (data.totalNominal) {
            $(this).jqGrid('footerData', 'set', {
              trado: 'Total:',
              uangjalan: data.totalNominal,
              jumlahtrip: data.jlhtrip,
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

          clearGlobalSearch($('#dataTidakLengkapGrid'))
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
    loadClearFilter($('#dataTidakLengkapGrid'))

    /* Append global search */
    loadGlobalSearch($('#dataTidakLengkapGrid'))
  }

  function loadDataTidakLengkap(id) {
    abortGridLastRequest($('#dataTidakLengkapGrid'))
    $('#dataTidakLengkapGrid').setGridParam({
      url: `${apiUrl}absensisupirdetail`,
      datatype: "json",
      postData: {
        absensi_id: id,
        from: "tidaklengkap"
      },
      page: 1
    }).trigger('reloadGrid')
  }
</script>
@endpush