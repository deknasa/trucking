@include('layouts._rangeheaderlookup')
<table id="hutangHeaderLookup" class="lookup-grid" style="width: 100%;"></table>


<script>
  setRangeLookup()
  initDatepicker()
  $(document).on('click', '#btnReloadLookup', function(event) {
    loadDataHeaderLookup('hutangheader', 'hutangHeaderLookup')
  })
  $('#hutangHeaderLookup').jqGrid({
      url: `{{ config('app.api_url') . 'hutangheader' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      postData: {
        tgldari: $('#tgldariheaderlookup').val(),
        tglsampai: $('#tglsampaiheaderlookup').val(),
      },
      idPrefix: 'hutangHeaderLookup',
      datatype: "json",
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
          label: 'KODE PERKIRAAN',
          name: 'coa',
          align: 'left'
        },
        {
          label: 'PELANGGAN',
          name: 'pelanggan_id',
          align: 'left'
        },
        {
          label: 'MODIFIED BY',
          name: 'modifiedby',
          align: 'left'
        },
          {
            label: 'CREATED AT',
            name: 'created_at',
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
      rowList: [10, 20, 50, 0],
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      toolbar: [true, "top"],
      page: 1,
      // pager: $('#hutangHeaderLookupPager'),
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

          if (indexRow - 1 > $('#hutangHeaderLookup').getGridParam().reccount) {
            indexRow = $('#hutangHeaderLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#hutangHeaderLookup [id="${$('#hutangHeaderLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#hutangHeaderLookup [id="${$('#hutangHeaderLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#hutangHeaderLookup').getDataIDs()[indexRow] == undefined) {
              $(`#hutangHeaderLookup [id="` + $('#hutangHeaderLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#hutangHeaderLookup').setSelection($('#hutangHeaderLookup').getDataIDs()[indexRow])
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

        clearGlobalSearch($('#hutangHeaderLookup'))
      },
    })
    .customPager()
  loadGlobalSearch($('#hutangHeaderLookup'))
  loadClearFilter($('#hutangHeaderLookup'))
</script>
