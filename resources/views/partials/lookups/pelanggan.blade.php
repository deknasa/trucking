<table id="pelangganLookup" class="lookup-grid"></table>
{{-- <div id="pelangganLookupPager"></div> --}}

@push('scripts')
<script>
   $('#pelangganLookup').jqGrid({
      url: `{{ config('app.api_url') . 'shipper' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      postData: {
        aktif: `{!! $Aktif ?? '' !!}`,
      },   
      idPrefix: 'pelangganLookup',
      colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '70px',
            search: false,
          hidden: true
        },
        {
          label: 'kode shipper',
          name: 'kodepelanggan',
          align: 'left',
          width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1
        },
        {
          label: 'NAMA SHIPPER',
          name: 'namapelanggan',
          align: 'left',
          width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2
        },
        {
          label: 'NO TELEPON',
          name: 'telp',
          align: 'left',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4
        },
        {
          label: 'ALAMAT',
          name: 'alamat',
          align: 'left',
          width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1

        },
        {
          label: 'ALAMAT 2',
          name: 'alamat2',
          align: 'left',
          width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2

        },
        {
          label: 'KOTA',
          name: 'kota',
          align: 'left',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4

        },
        {
          label: 'KODE POS',
          name: 'kodepos',
          align: 'left',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4
        },
        {
          label: 'KETERANGAN',
          name: 'keterangan',
          align: 'left',
          width: (detectDeviceType() == "desktop") ? lg_dekstop_3 : lg_mobile_3

        },
        
        {
          label: 'MODIFIED BY',
          name: 'modifiedby',
          align: 'left',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : md_mobile_3
        },
          {
            label: 'CREATED AT',
            name: 'created_at',
            align: 'right',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : md_mobile_4,
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y H:i:s"
            }
          },
          {
            label: 'UPDATED AT',
            name: 'updated_at',
            align: 'right',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : md_mobile_4,
            formatter: "date",
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
      rowNum: 10,
      toolbar: [true, "top"],
      rownumbers: true,
      rownumWidth: 45,
      rowList: [10, 20, 50, 0],
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      page: 1,
      // pager: $('#pelangganLookupPager'),
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

          if (indexRow - 1 > $('#pelangganLookup').getGridParam().reccount) {
            indexRow = $('#pelangganLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#pelangganLookup [id="${$('#pelangganLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#pelangganLookup [id="${$('#pelangganLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#pelangganLookup').getDataIDs()[indexRow] == undefined) {
              $(`#pelangganLookup [id="` + $('#pelangganLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#pelangganLookup').setSelection($('#pelangganLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookupPelanggan').prev().width())
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

        clearGlobalSearch($('#pelangganLookup'))
      },
    })
    .customPager()
    loadGlobalSearch($('#pelangganLookup'))
    loadClearFilter($('#pelangganLookup'))
</script>
