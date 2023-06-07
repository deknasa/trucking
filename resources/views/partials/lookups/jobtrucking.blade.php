<table id="jobTruckingLookup" class="lookup-grid"></table>
<div id="jobTruckingLookupPager"></div>

@push('scripts')
<script>
  // loadOrderanTrucking()
  $('#jobTruckingLookup').jqGrid({
      url: `{{ config('app.api_url') . 'jobtrucking' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      postData: {
        container_id: `{!! $container_id ?? '' !!}`,
        jenisorder_id: `{!! $jenisorder_id ?? '' !!}`,
        pelanggan_id: `{!! $pelanggan_id ?? '' !!}`,
        gandengan_id: `{!! $gandengan_id ?? '' !!}`,
        trado_id: `{!! $trado_id ?? '' !!}`,
        tarif_id: `{!! $tarif_id ?? '' !!}`,
        statuslongtrip: `{!! $statuslongtrip ?? '' !!}`,
        filters: `{!! $filters ?? '' !!}`
      },
      colModel: [{
          label: 'JOB TRUCKING',
          name: 'jobtrucking',
        },
        {
          label: 'TGL BUKTI',
          name: 'tglbukti',
          align: 'right',
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y"
          }
        },
        {
          label: 'SUPIR',
          name: 'supir',
        },
        {
          label: 'TRADO',
          name: 'trado',
        },
        {
          label: 'DARI',
          name: 'kotadari',
        },
        {
          label: 'SAMPAI',
          name: 'kotasampai',
        },
        {
          label: 'NOBUKTI',
          name: 'nobukti',
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
      sortname: 'jobtrucking',
      sortorder: 'asc',
      page: 1,
      pager: $('#jobTruckingLookupPager'),
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

          if (indexRow - 1 > $('#jobTruckingLookup').getGridParam().reccount) {
            indexRow = $('#jobTruckingLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#jobTruckingLookup [id="${$('#jobTruckingLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#jobTruckingLookup [id="${$('#jobTruckingLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#jobTruckingLookup').getDataIDs()[indexRow] == undefined) {
              $(`#jobTruckingLookup [id="` + $('#jobTruckingLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#jobTruckingLookup').setSelection($('#jobTruckingLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookupjobTrucking').prev().width())
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

        clearGlobalSearch($('#jobTruckingLookup'))
      },
    })

  loadGlobalSearch($('#jobTruckingLookup'))
  loadClearFilter($('#jobTruckingLookup'))

  function loadOrderanTrucking() {
    $('#jobTruckingLookup')
      .jqGrid('setGridParam', {
        url: `{{ config('app.api_url') . 'jobtrucking' }}`,
        mtype: "GET",
        datatype: "json",
        postData: {
          container_id: `{!! $container_id ?? '' !!}`,
          jenisorder_id: `{!! $jenisorder_id ?? '' !!}`,
          pelanggan_id: `{!! $pelanggan_id ?? '' !!}`,
          gandengan_id: `{!! $gandengan_id ?? '' !!}`,
          tarif_id: `{!! $tarifid ?? '' !!}`,
          statuslongtrip: `{!! $statuslongtrip ?? '' !!}`,
        },
      }).trigger('reloadGrid');
  }
</script>