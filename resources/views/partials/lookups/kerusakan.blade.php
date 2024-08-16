<table id="kerusakanLookup" class="lookup-grid" style="width: 100%;"></table>
<script>
$('#kerusakanLookup').jqGrid({
        url: `{{ config('app.api_url') . 'kerusakan' }}`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "json",
        postData: {
        aktif: `{!! $Aktif ?? '' !!}`,
        },   
        idPrefix: 'kerusakanLookup',        
        colModel: [{
            label: 'ID',
            name: 'id',
            width: '50px',
            search: false,
            hidden: true
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
          },

          {
            label: 'STATUS',
            name: 'statusaktif',
            align: 'left',
              
              formatter: (value, options, rowData) => {
              let statusAktif = JSON.parse(value)
              if (!statusAktif) {
                return ''
              }
              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusAktif.WARNA}; color: ${statusAktif.WARNATULISAN};">
                  <span>${statusAktif.SINGKATAN}</span>
                </div>
              `)
              
              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusAktif = JSON.parse(rowObject.statusaktif)
              if (!statusAktif) {
                return ` title=" "`
              }
              return ` title="${statusAktif.MEMO}"`
            }
          },
            
          {
            label: 'MODIFIED BY',
            name: 'modifiedby',
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
      page: 1,
      toolbar: [true, "top"],
      // pager: $('#kerusakanLookupPager'),
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

          if (indexRow - 1 > $('#kerusakanLookup').getGridParam().reccount) {
            indexRow = $('#kerusakanLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#kerusakanLookup [id="${$('#kerusakanLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#kerusakanLookup [id="${$('#kerusakanLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#kerusakanLookup').getDataIDs()[indexRow] == undefined) {
              $(`#kerusakanLookup [id="` + $('#kerusakanLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#kerusakanLookup').setSelection($('#kerusakanLookup').getDataIDs()[indexRow])
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

        clearGlobalSearch($('#kerusakanLookup'))
      },
    })
    .customPager()
  loadGlobalSearch($('#kerusakanLookup'))
  loadClearFilter($('#kerusakanLookup'))
</script>
