@include('layouts._rangeheaderlookup')
<table id="orderanTruckingLookup" class="lookup-grid"></table>

@push('scripts')
<script>
  setRangeLookup()
  initDatepicker()
  $(document).on('click', '#btnReloadLookup', function(event) {
    loadDataHeaderLookup('orderantrucking/get', 'orderanTruckingLookup')
  })
  $('#orderanTruckingLookup').jqGrid({
      url: `{{ config('app.api_url') . 'orderantrucking/get' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      postData: {
        tgldari: $('#tgldariheaderlookup').val(),
        tglsampai: $('#tglsampaiheaderlookup').val(),
        jenisorder_id: `{!! $jenisorder_id ?? '' !!}`,
        agen_id: `{!! $agen_id ?? '' !!}`,
        container_id: `{!! $container_id ?? '' !!}`,
        trado_id: `{!! $trado_id ?? '' !!}`,
        tglbukti: `{!! $tglbukti ?? '' !!}`,
        from: `{!! $from ?? '' !!}`,
      },
      idPrefix: 'orderanTruckingLookup',
      colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '70px',
          search: false,
          hidden: true
        },
        {
          label: 'NO BUKTI',
          name: 'nobukti',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
        },
        {
          label: 'TGL BUKTI',
          name: 'tglbukti',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y"
          }
        },
        {
          label: 'CONTAINER',
          name: 'container_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
        },
        {
          label: 'containerid',
          name: 'containerid',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
          hidden: true,
          search: false
        },
        {
          label: 'CUSTOMER',
          name: 'agen_id',
          width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
        },
        {
          label: 'JENIS ORDER',
          name: 'jenisorder_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
        },
        {
          label: 'SHIPPER',
          name: 'pelanggan_id',
          width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
        },
        {
          label: 'TUJUAN',
          name: 'kotasampai_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
        },
        {
          label: 'no job EMKL (1)',
          name: 'nojobemkl',
          width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1
        },
        {
          label: 'no conT (1)',
          name: 'nocont',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
        },
        {
          label: 'no seaL (1)',
          name: 'noseal',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
        },
        {
          label: 'no job EMKL (2)',
          name: 'nojobemkl2',
          width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1
        },
        {
          label: 'no conT (2)',
          name: 'nocont2',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
        },
        {
          label: 'no seaL (2)',
          name: 'noseal2',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
        },
        {
          label: 'MODIFIED BY',
          name: 'modifiedby',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
        },
        {
          label: 'CREATED AT',
          name: 'created_at',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y H:i:s"
          }
        },
        {
          label: 'UPDATED AT',
          name: 'updated_at',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
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
      rownumbers: true,
      rownumWidth: 45,
      rowList: [10, 20, 50, 0],
      toolbar: [true, "top"],
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      page: 1,
      // pager: $('#orderanTruckingLookupPager'),
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

          if (indexRow - 1 > $('#orderanTruckingLookup').getGridParam().reccount) {
            indexRow = $('#orderanTruckingLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#orderanTruckingLookup [id="${$('#orderanTruckingLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#orderanTruckingLookup [id="${$('#orderanTruckingLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#orderanTruckingLookup').getDataIDs()[indexRow] == undefined) {
              $(`#orderanTruckingLookup [id="` + $('#orderanTruckingLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#orderanTruckingLookup').setSelection($('#orderanTruckingLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookuporderanTrucking').prev().width())
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

        clearGlobalSearch($('#orderanTruckingLookup'))
      },
    })
    .customPager()
  loadGlobalSearch($('#orderanTruckingLookup'))
  loadClearFilter($('#orderanTruckingLookup'))
</script>