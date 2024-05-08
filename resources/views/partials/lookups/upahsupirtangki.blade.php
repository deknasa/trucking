<table id="upahSupirTangkiLookup" class="lookup-grid"></table>
{{-- <div id="upahSupirTangkiLookupPager"></div> --}}

@push('scripts')
<script>
  $('#upahSupirTangkiLookup').jqGrid({
      url: `{{ config('app.api_url') . 'upahsupirtangki' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      postData: {
        aktif: `{!! $Aktif ?? '' !!}`,
        isParent: `{!! $isParent ?? '' !!}`,
      },
      idPrefix: 'upahSupirTangkiLookup',
      colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '50px',
          search: false,
          hidden: true
        },
        {
          label: 'DARI',
          name: 'kotadari_id',
          align: 'left'
        },
        {
          label: 'TUJUAN',
          name: 'kotasampai_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          align: 'left'
        },
        {
          label: 'PENYESUAIAN',
          name: 'penyesuaian',
          width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
          align: 'left'
        },
        {
          label: 'JARAK',
          name: 'jarak',
          align: 'right',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,

          // formatter: currencyFormat
        },
        {
          label: 'TGL MULAI BERLAKU',
          name: 'tglmulaiberlaku',
          formatter: "date",
          width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y"
          }
        },
        {
          label: 'MODIFIED BY',
          name: 'modifiedby',
          
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left'
        },
        {
          label: 'CREATED AT',
          name: 'created_at',
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
      height: 350,
      rowNum: 10,
      rownumbers: true,
      rownumWidth: 45,
      rowList: [10, 20, 50, 0],
      toolbar: [true, "top"],
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      page: 1,
      // pager: $('#upahSupirTangkiLookupPager'),
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

          if (indexRow - 1 > $('#upahSupirTangkiLookup').getGridParam().reccount) {
            indexRow = $('#upahSupirTangkiLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#upahSupirTangkiLookup [id="${$('#upahSupirTangkiLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#upahSupirTangkiLookup [id="${$('#upahSupirTangkiLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#upahSupirTangkiLookup').getDataIDs()[indexRow] == undefined) {
              $(`#upahSupirTangkiLookup [id="` + $('#upahSupirTangkiLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#upahSupirTangkiLookup').setSelection($('#upahSupirTangkiLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookuptarif').prev().width())
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
        $('#upahSupirTangkiLookup').setGridParam({
          postData: {
            proses: "page"
          }
        })
        clearGlobalSearch($('#upahSupirTangkiLookup'))
      },
    })
    .customPager()
  loadGlobalSearch($('#upahSupirTangkiLookup'))
  loadClearFilter($('#upahSupirTangkiLookup'))
</script>