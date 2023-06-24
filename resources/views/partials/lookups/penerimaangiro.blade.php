@include('layouts._rangeheaderlookup')
<table id="penerimaanGiroLookup" class="lookup-grid"></table>

@push('scripts')
<script>
  setRangeLookup()
  initDatepicker()
  $(document).on('click', '#btnReloadLookup', function(event) {
    loadDataHeaderLookup('penerimaangiroheader/get', 'penerimaanGiroLookup')
  })
 $('#penerimaanGiroLookup').jqGrid({
      url: `{{ config('app.api_url') . 'penerimaangiroheader/get' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json", 
      postData: {
        tgldari: $('#tgldariheaderlookup').val(),
        tglsampai: $('#tglsampaiheaderlookup').val(),
      }, 
      idPrefix: 'penerimaanGiroLookup',
      colModel: [
        {
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
            align: 'left'
        },
        {
            label: 'TGL BUKTI',
            name: 'tglbukti',
            align: 'left',
            formatter: "date",
            formatoptions: {
                srcformat: "ISO8601Long",
                newformat: "d-m-Y"
            }
        },
        {
            label: 'Pelanggan ',
            name: 'pelanggan_id',
            align: 'left'
        },
        {
            label: 'AGEN ',
            name: 'agen_id',
            align: 'left'
        },
          {
            label: 'Nominal',
            name: 'nominal',
            align: 'right',
            formatter: currencyFormat,
          },
        {
            label: 'POSTING DARI',
            name: 'postingdari',
            align: 'left'
        },
        {
            label: 'DITERIMA DARI',
            name: 'diterimadari',
            align: 'left'
        },
        {
            label: 'TGL Lunas',
            name: 'tgllunas',
            align: 'left',
            formatter: "date",
            formatoptions: {
                srcformat: "ISO8601Long",
                newformat: "d-m-Y"
            }
        },
       
          {
            label: 'MODIFIEDBY',
            name: 'modifiedby',
            align: 'left'
          },
          {
            label: 'CREATEDAT',
            name: 'created_at',
            align: 'right',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y H:i:s"
            }
          },
          {
            label: 'UPDATEDAT',
            name: 'updated_at',
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
    //   pager: $('#penerimaanGiroLookupPager'),
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

          if (indexRow - 1 > $('#penerimaanGiroLookup').getGridParam().reccount) {
            indexRow = $('#penerimaanGiroLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#penerimaanGiroLookup [id="${$('#penerimaanGiroLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#penerimaanGiroLookup [id="${$('#penerimaanGiroLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#penerimaanGiroLookup').getDataIDs()[indexRow] == undefined) {
              $(`#penerimaanGiroLookup [id="` + $('#penerimaanGiroLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#penerimaanGiroLookup').setSelection($('#penerimaanGiroLookup').getDataIDs()[indexRow])
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
          
          clearGlobalSearch($('#penerimaanGiroLookup'))
      },
    })
    .customPager()
    loadGlobalSearch($('#penerimaanGiroLookup'))
    loadClearFilter($('#penerimaanGiroLookup'))
</script>
