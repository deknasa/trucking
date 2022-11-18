<table id="agenLookup" class="lookup-grid"></table>
<div id="agenLookupPager"></div>

@push('scripts')
<script>
  $('#agenLookup').jqGrid({
      url: `{{ config('app.api_url') . 'agen' }}`,
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
          label: 'KODE AGEN',
          name: 'kodeagen',
          align: 'left',
        },
        {
          label: 'NAMA AGEN',
          name: 'namaagen',
          align: 'left'
        },
        {
          label: 'KETERANGAN',
          name: 'keterangan',
          align: 'left'
        },
        {
          label: 'Status',
          name: 'statusaktif',
          align: 'left'
        },

        {
          label: 'NAMA PERUSAHAAN',
          name: 'namaperusahaan',
          align: 'left'
        },
        {
          label: 'ALAMAT',
          name: 'alamat',
          align: 'left'
        },
        {
          label: 'NO TELP',
          name: 'notelp',
          align: 'left'
        },
        {
          label: 'NO HP',
          name: 'nohp',
          align: 'left'
        },
        {
          label: 'CONTACT PERSON',
          name: 'contactperson',
          align: 'left'
        },
        {
          label: 'TOP',
          name: 'top',
          align: 'right',
          formatter: currencyFormat
        },
        {
          label: 'STATUS APPROVAL',
          name: 'statusapproval',
          align: 'left'
        },
        {
          label: 'USER APPROVAL',
          name: 'userapproval',
          align: 'left'
        },
        {
          label: 'TGL APPROVAL',
          name: 'tglapproval',
          align: 'left'
        },
        {
          label: 'STATUS TAS',
          name: 'statustas',
          align: 'left'
        },

        {
          label: 'JENIS EMKL',
          name: 'jenisemkl',
          align: 'left'
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
      pager: $('#agenLookupPager'),
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

          if (indexRow - 1 > $('#agenLookup').getGridParam().reccount) {
            indexRow = $('#agenLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#agenLookup [id="${$('#agenLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#agenLookup [id="${$('#agenLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#agenLookup').getDataIDs()[indexRow] == undefined) {
              $(`#agenLookup [id="` + $('#agenLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#agenLookup').setSelection($('#agenLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookupAgen').prev().width())
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
        clearGlobalSearch($('#agenLookup'))
      },
    })

  loadGlobalSearch($('#agenLookup'))
  loadClearFilter($('#agenLookup'))
</script>