<table id="akunPusatLookup" class="lookup-grid" style="width: 100%;"></table>

<script>
  $('#akunPusatLookup').jqGrid({
      url: `{{ config('app.api_url') . 'akunpusat' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      postData: {
        levelCoa: `{!! $levelCoa ?? '' !!}`,
        potongan: `{!! $potongan ?? '' !!}`,
        aktif: `{!! $Aktif ?? '' !!}`,
        keterangancoa: `{!! $KeteranganCoa ?? '' !!}`,
        supplier: `{!! $Supplier ?? '' !!}`,
        isParent: `{!! $isParent ?? '' !!}`,
        limit: `{!! $limits ?? '10' !!}`,
        // filters: `{!! $filters ?? '' !!}`
      },
      idPrefix: 'akunPusatLookup',
      colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '70px',
          search: false,
          hidden: true
        },
        {
          label: 'KODE PERKIRAAN',
          name: 'coa',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left',
        },
        {
          label: 'NAMA',
          name: 'keterangancoa',
          align: 'left',
          width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
        },
        {
          label: 'TYPE',
          name: 'type',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left',
          search: false,
          hidden: true
        },
        {
          label: 'LEVEL',
          name: 'level',
          align: 'left',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
          search: false,
          hidden: true
        },
        {
          label: 'PARENT',
          name: 'parent',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left',
          search: false,
          hidden: true
        },
        {
          label: 'kode perkiraan main',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
          name: 'coamain',
          align: 'left',
          search: false,
          hidden: true
        },
        {
          label: 'kode-keterangan',
          name: 'kodeket',
          width: (detectDeviceType() == "desktop") ? md_dekstop_3 : md_mobile_3,
          align: 'left',
          search: false,
          hidden: true
        },
      ],
      autowidth: true,
      responsive: true,
      shrinkToFit: false,
      height: 450,
      rowNum: `{!! $limits ?? '10' !!}`,
      rownumbers: true,
      rownumWidth: 45,
      rowList: [10, 20, 50, 0],
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      toolbar: [true, "top"],
      page: 1,
      // pager: $('#akunPusatLookupPager'),
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

          if (indexRow - 1 > $('#akunPusatLookup').getGridParam().reccount) {
            indexRow = $('#akunPusatLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#akunPusatLookup [id="${$('#akunPusatLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#akunPusatLookup [id="${$('#akunPusatLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#akunPusatLookup').getDataIDs()[indexRow] == undefined) {
              $(`#akunPusatLookup [id="` + $('#akunPusatLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#akunPusatLookup').setSelection($('#akunPusatLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookupCabang').prev().width())
        setHighlight($(this))
        // var limits = `{!! $limits ?? '10' !!}`
        // if(limits == 50){
        // $('#akunPusatLookup_rowList').val(limit).trigger('change')
        // }

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

        clearGlobalSearch($('#akunPusatLookup'))
      },
    })
    .customPager()
  loadGlobalSearch($('#akunPusatLookup'))
  loadClearFilter($('#akunPusatLookup'))
</script>