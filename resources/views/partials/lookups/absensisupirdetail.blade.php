<table id="absensiSupirLookup" class="lookup-grid"></table>
{{-- <div id="absensiSupirLookupPager"></div> --}}

<script>
  $('#absensiSupirLookup').jqGrid({
      url: `{{ config('app.api_url') . 'absensisupirdetail/get' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      idPrefix: 'absensiSupirLookup',
      postData: {
        aktif: `{!! $Aktif ?? '' !!}`,
        trado_id: `{!! $trado_id ?? '' !!}`,
        cabang: `{!! $cabang ?? '' !!}`,
        absensiId: `{!! $absensiId ?? '' !!}`,
        tgltrip: `{!! $tgltrip ?? '' !!}`,
        absensi_id: `{!! $absensi_id ?? '' !!}`,
        from: `{!! $from ?? '' !!}`,
        aksi: `{!! $aksi ?? '' !!}`,
        tripinap_id: `{!! $tripinap_id ?? '' !!}`,
        pengajuantrip_id: `{!! $pengajuantrip_id ?? '' !!}`,
        isProsesUangjalan: `{!! $isProsesUangjalan ?? '' !!}`,
        uangJalanId: `{!! $uangJalanId ?? '' !!}`,
        statusjeniskendaraan: `{!! $statusjeniskendaraan ?? '' !!}`,
        trip_id: `{!! $trip_id ?? '' !!}`,
      },
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
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
        },
        {
          label: 'KETERANGAN',
          name: 'keterangan_detail',
          width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
        },
        // {
        //   label: 'JAM',
        //   name: 'jam',
        //   formatter: 'date',
        //   width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
        //   formatoptions: {
        //     srcformat: "H:i:s",
        //     newformat: "H:i",
        //     // userLocalTime : true
        //   }
        // },



        {
          label: 'id',
          name: 'id',
          hidden: true
        },
        {
          label: 'trado_id',
          name: 'trado_id',
          hidden: true
        },
        {
          label: 'supir_id',
          name: 'supir_id',
          hidden: true
        },
        {
          label: 'statusgerobak',
          name: 'statusgerobak',
          hidden: true,
          search: false
        },
        {
          label: 'nominalplusborongan',
          name: 'nominalplusborongan',
          hidden: true,
          search: false
        },
        {
          label: 'UANG JALAN',
          name: 'uangjalan',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          formatter: currencyFormat,
          align: "right",
          hidden: true,
          search: false
        },
        {
          label: 'TRADO - SUPIR',
          name: 'tradosupir',
          width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
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
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      page: 1,
      toolbar: [true, "top"],
      // pager: $('#absensiSupirLookupPager'),
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

          if (indexRow - 1 > $('#absensiSupirLookup').getGridParam().reccount) {
            indexRow = $('#absensiSupirLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#absensiSupirLookup [id="${$('#absensiSupirLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#absensiSupirLookup [id="${$('#absensiSupirLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#absensiSupirLookup').getDataIDs()[indexRow] == undefined) {
              $(`#absensiSupirLookup [id="` + $('#absensiSupirLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#absensiSupirLookup').setSelection($('#absensiSupirLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookupBank').prev().width())
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

        clearGlobalSearch($('#absensiSupirLookup'))
      },
    })
    .customPager()

  loadGlobalSearch($('#absensiSupirLookup'))
  loadClearFilter($('#absensiSupirLookup'))
</script>