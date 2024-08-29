@include('layouts._rangeheaderlookup')
<table id="absensiSupirLookup" class="lookup-grid"></table>

@push('scripts')
<script>
  setRangeLookup()
  initDatepicker()
  $(document).on('click', '#btnReloadLookup', function(event) {
    loadDataHeaderLookup('absensisupirheader', 'absensiSupirLookup')
  })
  $('#absensiSupirLookup').jqGrid({
      url: `{{ config('app.api_url') . 'absensisupirheader' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      postData: {
        proses: `{!! $Proses ?? '' !!}`,        
        from: `{!! $from ?? '' !!}`,        
        tgldari: $('#tgldariheaderlookup').val(),
        tglsampai: $('#tglsampaiheaderlookup').val(),

      },
      idPrefix: 'absensiSupirLookup',
      colModel: [{
            label: 'ID',
            name: 'id',
            align: 'right',
            width: '50px',
            search: false,
            hidden: true
          },
          {
            label: 'NO BUKTI',
            name: 'nobukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left'
          },
          {
            label: 'TANGGAL',
            name: 'tglbukti',
            align: 'left',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            formatter: 'date',
            formatoptions: {
              newformat: 'd-m-Y'
            }
          },
          {
            label: 'NO BUKTI KGT',
            name: 'kasgantung_nobukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left'
          },
          {
            label: 'is_holiday_or_sunday',
            name: 'is_holiday_or_sunday',
            hidden: true,
            search: false
          },
          {
            label: 'NOMINAL',
            name: 'nominal',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat
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
