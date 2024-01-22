<table id="pengeluaranTruckingLookup" class="lookup-grid"></table>
{{-- <div id="pengeluaranTruckingLookupPager"></div> --}}

@push('scripts')
<script>
  $('#pengeluaranTruckingLookup').jqGrid({
      url: `{{ config('app.api_url') . 'pengeluarantrucking' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      idPrefix: 'pengeluaranTruckingLookup',
      postData: {
        aktif: `{!! $Aktif ?? '' !!}`,        
        roleinput: `{!! $roleInput ?? '' !!}`,        
        isLookup: `{!! $isLookup ?? '' !!}`,        
        // filters: `{!! $filters ?? '' !!}`
      },

      colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '70px',
            search: false,
          hidden: true
        },
        {
          label: 'PENGELUARAN',
          name: 'kodepengeluaran',
          align: 'left',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_1,
        },
        {
          label: 'KETERANGAN',
          name: 'keterangan',
          width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
          align: 'left'
        },
        // {
        //   label: 'KODE PERKIRAAN DEBET', 
    // width: 220,
        //   name: 'coadebet',
        //   hidden: true
        // },
        // {
        //   label: 'KODE PERKIRAAN kredit', 
        //  width: 220,
        //   name: 'coakredit',
        //   hidden: true
        // },
        // {
        //   label: 'KODE PERKIRAAN posting debet',
      //  width: 240,
        //   name: 'coapostingdebet',
        //   hidden: true
        // },
        // {
        //   label: 'KODE PERKIRAAN posting kredit', 

        //   name: 'coapostingkredit',
        //   hidden: true
        // },
        {
          label: 'KODE PERKIRAAN DEBET', 
          width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
          name: 'coadebet_keterangan',
        },
        {
          label: 'KODE PERKIRAAN kredit', 
          width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
          name: 'coakredit_keterangan',
        },
        {
          label: 'KODE PERKIRAAN posting debet',
          width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
          name: 'coapostingdebet_keterangan',
        },
        {
          label: 'KODE PERKIRAAN posting kredit', 
          width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
          name: 'coapostingkredit_keterangan',
        },
        {
          label: 'FORMAT BUKTI',
          name: 'format',
          width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
          formatter: (value, options, rowData) => {
            let statusFormat = JSON.parse(value)
            let Format = JSON.parse(value)

            // let formattedValue = $(`
            //     <div class="badge" style="background-color: ${statusFormat.WARNA}; color: #fff;">
            //       <span>${statusFormat.SINGKATAN}</span>
            //     </div>
            //   `)

            return Format.SINGKATAN
            // return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusFormat = JSON.parse(rowObject.format)

            return ` title="${statusFormat.MEMO}"`
          }
        },
        {
          label: 'MODIFIED BY',
          name: 'modifiedby',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
          align: 'left'
        },
        {
          label: 'CREATED AT',
          name: 'created_at',
          align: 'right',
          formatter: "date",
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y H:i:s"
          }
        },
        {
          label: 'UPDATED AT',
          name: 'updated_at',
          align: 'right',
          formatter: "date",
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
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
      rowNum: 20,
      rownumbers: true,
      rownumWidth: 45,
      rowList: [10, 20, 50, 0],
      toolbar: [true, "top"],
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      page: 1,
      // pager: $('#pengeluaranTruckingLookupPager'),
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

          if (indexRow - 1 > $('#pengeluaranTruckingLookup').getGridParam().reccount) {
            indexRow = $('#pengeluaranTruckingLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#pengeluaranTruckingLookup [id="${$('#pengeluaranTruckingLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#pengeluaranTruckingLookup [id="${$('#pengeluaranTruckingLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#pengeluaranTruckingLookup').getDataIDs()[indexRow] == undefined) {
              $(`#pengeluaranTruckingLookup [id="` + $('#pengeluaranTruckingLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#pengeluaranTruckingLookup').setSelection($('#pengeluaranTruckingLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookupPengeluaranTrucking').prev().width())
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

        clearGlobalSearch($('#pengeluaranTruckingLookup'))
      },
    })
    .customPager()
  loadGlobalSearch($('#pengeluaranTruckingLookup'))
  loadClearFilter($('#pengeluaranTruckingLookup'))
</script>