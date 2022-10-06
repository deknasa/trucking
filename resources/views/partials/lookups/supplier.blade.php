<table id="supplierLookup" class="lookup-grid"></table>
<div id="supplierLookupPager"></div>

<script>
   $('#supplierLookup').jqGrid({
      url: `{{ config('app.api_url') . 'supplier' }}`,
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
          label: 'NAMA',
          name: 'namasupplier',
          align: 'left',
        },
        {
          label: 'NAMA KONTAK',
          name: 'namakontak',
          align: 'left',
        },
        {
          label: 'ALAMAT',
          name: 'alamat',
          align: 'left'
        },
        {
          label: 'KOTA',
          name: 'kota',
          align: 'left'
        },
        {
          label: 'KODE POS',
          name: 'kodepos',
          align: 'left'
        },
        {
          label: 'NO TELP 1',
          name: 'notelp1',
          align: 'left'
        },
        {
          label: 'NO TELP 2',
          name: 'notelp2',
          align: 'left'
        },
        {
            label: 'EMAIL',
            name: 'email',
            align: 'left',
        },
        {
            label: 'STATUS AKTIF',
            name: 'statusaktif',
            align: 'left',
        },
        {
            label: 'WEB',
            name: 'web',
            align: 'left',
        },
        {
            label: 'NAMA PEMILIK',
            name: 'namapemilik',
            align: 'left',
        },
        {
            label: 'JENIS USAHA',
            name: 'jenisusaha',
            align: 'left',
        },
        {
            label: 'TOP',
            name: 'top',
            align: 'left',
        },
        {
            label: 'BANK',
            name: 'bank',
            align: 'left',
        },
        {
            label: 'REKENING BANK',
            name: 'rekeningbank',
            align: 'left',
        },
        {
            label: 'NAMA REKENING',
            name: 'namarekening',
            align: 'left',
        },
        {
            label: 'JABATAN',
            name: 'jabatan',
            align: 'left',
        },
        {
            label: 'STATUS DAFTAR HARGA',
            name: 'statusdaftarharga',
            align: 'left',
        },
        {
            label: 'KATEGORI USAHA',
            name: 'kategoriusaha',
            align: 'left',
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
      pager: $('#supplierLookupPager'),
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

          if (indexRow - 1 > $('#supplierLookup').getGridParam().reccount) {
            indexRow = $('#supplierLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#supplierLookup [id="${$('#supplierLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#supplierLookup [id="${$('#supplierLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#supplierLookup').getDataIDs()[indexRow] == undefined) {
              $(`#supplierLookup [id="` + $('#supplierLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#supplierLookup').setSelection($('#supplierLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookupSupplier').prev().width())
        setHighlight($(this))
      }
    })

</script>

