<table id="suratpengantarLookup" class="lookup-grid"></table>
<div id="suratpengantarLookupPager"></div>

@push('scripts')
<script>
  $('#suratpengantarLookup').jqGrid({
      url: `{{ config('app.api_url') . 'suratpengantar' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '50px'
        },

        {
          label: 'NOBUKTI',
          name: 'nobukti',
        },
        {
          label: 'TGLBUKTI',
          name: 'tglbukti',
        },
        {
          label: 'PELANGGAN',
          name: 'pelanggan_id',
        },
        {
          label: 'KETERANGAN',
          name: 'keterangan',
        },
        {
          label: 'DARI',
          name: 'dari_id',
        },
        {
          label: 'SAMPAI',
          name: 'sampai_id',
        },
        {
          label: 'CONTAINER',
          name: 'container_id'
        },
        {
          label: 'NO CONT',
          name: 'nocont'
        },
        {
          label: 'NO CONT2',
          name: 'nocont2'
        },
        {
          label: 'STATUS CONTAINER',
          name: 'statuscontainer_id',
        },
        {
          label: 'TRADO',
          name: 'trado_id',
        },
        {
          label: 'SUPIR',
          name: 'supir_id',
        },
        {
          label: 'NOJOB',
          name: 'nojob',
        },
        {
          label: 'NOJOB2',
          name: 'nojob2',
        },
        {
          label: 'STATUSLONGTRIP',
          name: 'statuslongtrip',
        },
        {
          label: 'GAJI SUPIR',
          name: 'gajisupir',
          formatter: 'currency',
          formatoptions: {
            decimalSeparator: ',',
            thousandsSeparator: '.'
          }
        },
        {
          label: 'GAJI KENEK',
          name: 'gajikenek',
          formatter: 'currency',
          formatoptions: {
            decimalSeparator: ',',
            thousandsSeparator: '.'
          }
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
          label: 'STATUS PERALIHAN',
          name: 'statusperalihan',
        },
        {
          label: 'TARIF',
          name: 'tarif_id',
        },
        {
          label: 'NOMINAL PERALIHAN',
          name: 'nominalperalihan',
          formatter: 'currency',
          formatoptions: {
            decimalSeparator: ',',
            thousandsSeparator: '.'
          }
        },
        {
          label: 'NO SP',
          name: 'nosp',
        },
        {
          label: 'TGLSP',
          name: 'tglsp',
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
      height: 350,
      rowNum: 10,
      rownumbers: true,
      rownumWidth: 45,
      rowList: [10, 20, 50],
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      page: 1,
      pager: $('#suratpengantarLookupPager'),
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

          if (indexRow - 1 > $('#suratpengantarLookup').getGridParam().reccount) {
            indexRow = $('#suratpengantarLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#suratpengantarLookup [id="${$('#suratpengantarLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#suratpengantarLookup [id="${$('#suratpengantarLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#suratpengantarLookup').getDataIDs()[indexRow] == undefined) {
              $(`#suratpengantarLookup [id="` + $('#suratpengantarLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#suratpengantarLookup').setSelection($('#suratpengantarLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookupsuratpengantar').prev().width())
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
        clearGlobalSearch($('#suratpengantarLookup'))
      },
    })

  loadGlobalSearch($('#suratpengantarLookup'))
  loadClearFilter($('#suratpengantarLookup'))
</script>