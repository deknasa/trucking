<table id="orderanTruckingLookup" class="lookup-grid"></table>
<div id="orderanTruckingLookupPager"></div>

@push('scripts')
<script>
   $('#orderanTruckingLookup').jqGrid({
      url: `{{ config('app.api_url') . 'orderantrucking' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '70px'
        },
        {
            label: 'NO BUKTI',
            name: 'nobukti',
          },
          {
            label: 'TGL BUKTI',
            name: 'tglbukti',
          },
          {
            label: 'CONTAINER',
            name: 'container_id',
          },
          {
            label: 'AGEN',
            name: 'agen_id',
          },
          {
            label: 'JENIS ORDER',
            name: 'jenisorder_id',
          },
          {
            label: 'PELANGGAN',
            name: 'pelanggan_id',
          },
          {
            label: 'TUJUAN',
            name: 'tarif_id',
          },
          {
            label: 'NOMINAL',
            name: 'nominal',
            align: 'right',
            formatter: 'currency',
            formatoptions: {
              decimalSeparator: ',',
              thousandsSeparator: '.'
            }
          },
          {
            label: 'NO JOBEMKL',
            name: 'nojobemkl',
          },
          {
            label: 'NO CONT',
            name: 'nocont',
          },
          {
            label: 'NO SEAL',
            name: 'noseal',
          },
          {
            label: 'NO JOBEMKL',
            name: 'nojobemkl2',
          },
          {
            label: 'NO CONT',
            name: 'nocont2',
          },
          {
            label: 'NO SEAL',
            name: 'noseal2',
          },
          {
            label: 'STATUS LANGSIR',
            name: 'statuslangsir',
          },
          {
            label: 'STATUS PERALIHAN',
            name: 'statusperalihan',
          },
          {
            label: 'MODIFIEDBY',
            name: 'modifiedby',
          },
          {
            label: 'UPDATEDAT',
            name: 'updated_at',
          },
      ],
      autowidth: true,
      responsive: true,
      shrinkToFit: false,
      height: 450,
      rowNum: 10,
      rownumbers: true,
      rownumWidth: 45,
      rowList: [10, 20, 50],
      toolbar: [true, "top"],
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      page: 1,
      pager: $('#orderanTruckingLookupPager'),
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
      loadBeforeSend: (jqXHR) => {
        jqXHR.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
      },
      loadComplete: function(data) {
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
          clearColumnSearch()
        })

        $(this).setGridWidth($('#lookuporderanTrucking').prev().width())
        setHighlight($(this))
      }
    })

    .jqGrid('filterToolbar', {
      stringResult: true,
      searchOnEnter: false,
      defaultSearch: 'cn',
      groupOp: 'AND',
      disabledKeys: [16, 17, 18, 33, 34, 35, 36, 37, 38, 39, 40],
      beforeSearch: function() {
        clearGlobalSearch($('#orderanTruckingLookup'))
      },
    })

  loadGlobalSearch($('#orderanTruckingLookup'))
  loadClearFilter($('#orderanTruckingLookup'))
</script>