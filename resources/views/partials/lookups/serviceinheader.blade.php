@include('layouts._rangeheaderlookup')
<table id="serviceinLookup" class="lookup-grid"></table>
{{-- <div id="serviceinLookupPager"></div> --}}

@push('scripts')
<script>
  setRangeLookup()
  initDatepicker()
  $(document).on('click', '#btnReloadLookup', function(event) {
    loadDataHeaderLookup('serviceinheader', 'serviceinLookup')
  })
  $('#serviceinLookup').jqGrid({
      url: `{{ config('app.api_url') . 'serviceinheader' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      postData: {
        tgldari: $('#tgldariheaderlookup').val(),
        tglsampai: $('#tglsampaiheaderlookup').val(),
        serviceout:`{!! $serviceout ?? '' !!}`,
        nobukti:`{!! $nobukti ?? '' !!}`,
        from:`{!! $from ?? '' !!}`,
        trado_id:`{!! $trado_id ?? '' !!}`

      },
      idPrefix: 'serviceinLookup',
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
          align: 'left',
        },
        {
          label: 'TGL BUKTI',
          name: 'tglbukti',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
          align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
        },
        {
          label: 'TRADO',
          name: 'trado_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left',
        },
        {
          label: 'TGL MASUK',
          name: 'tglmasuk',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
          align: 'left',
            formatter: "date",
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
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          align: 'right',
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
          align: 'right',
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
      toolbar: [true, "top"],
      rowList: [10, 20, 50, 0],
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      page: 1,
      // pager: $('#serviceinLookupPager'),
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

          if (indexRow - 1 > $('#serviceinLookup').getGridParam().reccount) {
            indexRow = $('#serviceinLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#serviceinLookup [id="${$('#serviceinLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#serviceinLookup [id="${$('#serviceinLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#serviceinLookup').getDataIDs()[indexRow] == undefined) {
              $(`#serviceinLookup [id="` + $('#serviceinLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#serviceinLookup').setSelection($('#serviceinLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookupServicein').prev().width())
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

        clearGlobalSearch($('#serviceinLookup'))
      },
    })
    .customPager()
  loadGlobalSearch($('#serviceinLookup'))
  loadClearFilter($('#serviceinLookup'))
</script>