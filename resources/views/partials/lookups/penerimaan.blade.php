<table id="penerimaanLookup" class="lookup-grid"></table>
<div id="penerimaanLookupPager"></div>

@push('scripts')
<script>
  $('#penerimaanLookup').jqGrid({
      url: `{{ config('app.api_url') . 'penerimaan' }}`,
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
            label: 'NO BUKTI',
            name: 'nobukti',
            align: 'left'
          },
          {
            label: 'TANGGAL BUKTI',
            name: 'tglbukti',
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'PELANGGAN ',
            name: 'pelanggan_id',
            align: 'left'
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
            align: 'left'
          },
          {
            label: 'BANK',
            name: 'bank_id',
            align: 'left'
          },
          // {
          //   label: 'DITERIMA DARI',
          //   name: 'diterimadari',
          //   align: 'left'
          // },
          {
            label: 'TGL LUNAS',
            name: 'tgllunas',
            align: 'left',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'CABANG',
            name: 'cabang_id',
            align: 'left'
          },
          {
            label: 'STATUS KAS',
            name: 'statuskas',
            align: 'left'
          },
          {
            label: 'NO RESI',
            name: 'noresi',
            align: 'left'
          },
          {
            label: 'STATUS APPROVAL',
            name: 'statusapproval',
            align: 'left'
          },
          // {
          //   label: 'USER APPROVAL',
          //   name: 'userapproval',
          //   align: 'left'
          // },
          // {
          //   label: 'TGL APPROVAL',
          //   name: 'tglapproval',
          //   align: 'left',
          //   formatter: "date",
          //   formatoptions: {
          //     srcformat: "ISO8601Long",
          //     newformat: "d-m-Y"
          //   }
          // },
         
          // {
          //   label: 'STATUS BERKAS',
          //   name: 'statusberkas',
          //   align: 'left'
          // },
          // {
          //   label: 'USER BERKAS',
          //   name: 'userberkas',
          //   align: 'left'
          // },
          // {
          //   label: 'TGL BERKAS',
          //   name: 'tglberkas',
          //   align: 'left',
          //   formatter: "date",
          //   formatoptions: {
          //     srcformat: "ISO8601Long",
          //     newformat: "d-m-Y"
          //   }
          // },
          {
            label: 'MODIFIEDBY',
            name: 'modifiedby',
            align: 'left'
          },
          {
            label: 'UPDATEDAT',
            name: 'updated_at',
            align: 'left',
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
      rowList: [10, 20, 50],
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      page: 1,
      toolbar: [true, "top"],
      pager: $('#penerimaanLookupPager'),
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

          if (indexRow - 1 > $('#penerimaanLookup').getGridParam().reccount) {
            indexRow = $('#penerimaanLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#penerimaanLookup [id="${$('#penerimaanLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#penerimaanLookup [id="${$('#penerimaanLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#penerimaanLookup').getDataIDs()[indexRow] == undefined) {
              $(`#penerimaanLookup [id="` + $('#penerimaanLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#penerimaanLookup').setSelection($('#penerimaanLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookup').prev().width())
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
        clearGlobalSearch($('#penerimaanLookup'))
      },
    })

  loadGlobalSearch($('#penerimaanLookup'))
  loadClearFilter($('#penerimaanLookup'))
</script>
