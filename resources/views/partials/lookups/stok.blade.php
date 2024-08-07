<table id="stokLookup" class="lookup-grid" style="width: 100%;"></table>
{{-- <div id="stokLookupPager"></div> --}}

<script>
  $('#stokLookup').jqGrid({
      url: `{{ config('app.api_url') . 'stok' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      postData: {
        aktif: `{!! $Aktif ?? '' !!}`,
        isLookup: true,
        statusreuse: `{!! $statusreuse ?? '' !!}`,
        approveReuse: `{!! $approveReuse ?? '' !!}`,
        penerimaanstok_id: `{!! $penerimaanstok_id ?? '' !!}`,
        pengeluaranstok_id: `{!! $pengeluaranstok_id ?? '' !!}`,
        penerimaanstokheader_nobukti: `{!! $penerimaanstokheader_nobukti ?? '' !!}`,
        nobukti: `{!! $nobukti ?? '' !!}`,
        KelompokId: `{!! $KelompokId ?? '' !!}`,
        StokId: `{!! $StokId ?? '' !!}`,
        isLookup: `{!! $isLookup ?? '' !!}`,
      },
      idPrefix: 'stokLookup',
      colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '70px',
          search: false,
          hidden: true

        },
        {
          label: 'NAMA',
          name: 'namastok',
          align: 'left',
          width: (detectDeviceType() == "desktop") ? lg_dekstop_2 : lg_mobile_2
        },
        {
          label: 'Keterangan',
          name: 'keterangan',
          align: 'left',
          width: (detectDeviceType() == "desktop") ? lg_dekstop_2 : lg_mobile_2
        },
        {
          label: 'nama terpusat',
          name: 'namaterpusat',
          width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
          align: 'left',
          search: false,
          hidden: true
        },
        {
          label: 'kelompok',
          name: 'kelompok',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left',
          search: false,
          hidden: true
        },
        {
          label: 'satuan',
          name: 'satuan',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left',
          search: false,
          hidden: true
        },
        {
          label: 'statusban',
          name: 'statusban',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left',
          search: false,
          hidden: true
        },
        {
          label: 'jenistrado',
          name: 'jenistrado',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left',
          search: false,
          hidden: true
        },
        {
          label: 'subkelompok',
          name: 'subkelompok',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left',
          search: false,
          hidden: true
        },
        {
          label: 'kategori',
          name: 'kategori',
          width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
          align: 'left',
          search: false,
          hidden: true
        },
        {
          label: 'merk',
          name: 'merk',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left',
          search: false,
          hidden: true
        },

        {
          label: 'qty min',
          name: 'qtymin',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
          align: 'left',
          search: false,
          hidden: true
        },
        {
          label: 'qty max',
          name: 'qtymax',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
          align: 'left',
          search: false,
          hidden: true
        },
        {
          label: 'total vulkanisir',
          name: 'vulkan',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left',
          search: false,
          hidden: true
        },
        {
          label: 'kelompok_id',
          name: 'kelompok_id',
          align: 'left',
          search: false,
          hidden: true
        },
        {
          label: 'statusban_id',
          name: 'statusban_id',
          align: 'left',
          search: false,
          hidden: true
        },
        {
          label: 'vulkanplus',
          name: 'vulkanplus',
          align: 'left',
          search: false,
          hidden: true
        },
        {
          label: 'vulkanminus',
          name: 'vulkanminus',
          align: 'left',
          search: false,
          hidden: true
        },
        {
          label: 'penerimaanstokdetail_keterangan',
          name: 'penerimaanstokdetail_keterangan',
          align: 'left',
          search: false,
          hidden: true
        },
        {
          label: 'penerimaanstokdetail_qty',
          name: 'penerimaanstokdetail_qty',
          align: 'left',
          search: false,
          hidden: true
        },
        {
          label: 'penerimaanstokdetail_harga',
          name: 'penerimaanstokdetail_harga',
          align: 'left',
          search: false,
          hidden: true
        },
        {
          label: 'penerimaanstokdetail_total',
          name: 'penerimaanstokdetail_total',
          align: 'left',
          search: false,
          hidden: true
        },
        {
          label: 'Status Service Rutin',
          name: 'statusservicerutin',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          stype: 'select',
          hidden: true,
          search: false,
          searchoptions: {
            dataInit: function(element) {
              $(element).select2({
                width: 'resolve',
                theme: "bootstrap4",
                ajax: {
                  url: `${apiUrl}parameter/combo`,
                  dataType: 'JSON',
                  headers: {
                    Authorization: `Bearer ${accessToken}`
                  },
                  data: {
                    grp: 'STATUS SERVICE RUTIN',
                    subgrp: 'STATUS SERVICE RUTIN'
                  },
                  beforeSend: () => {
                    // clear options
                    $(element).data('select2').$results.children().filter((index, element) => {
                      // clear options except index 0, which
                      // is the "searching..." label
                      if (index > 0) {
                        element.remove()
                      }
                    })
                  },
                  processResults: (response) => {
                    let formattedResponse = response.data.map(row => ({
                      id: row.id,
                      text: row.text
                    }));

                    formattedResponse.unshift({
                      id: '',
                      text: 'ALL'
                    });

                    return {
                      results: formattedResponse
                    };
                  },
                }
              });
            }
          },
          formatter: (value, options, rowData) => {
            let statusService = JSON.parse(value)
            if (!statusService) {
              return ''
            }
            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusService.WARNA}; color: #fff;">
                  <span>${statusService.SINGKATAN}</span>
                </div>
              `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusService = JSON.parse(rowObject.statusservicerutin)
            if (!statusService) {
              return ` title=" "`
            }
            return ` title="${statusService.MEMO}"`
          }
        },
        {
          label: 'service',
          name: 'servicerutin_text',
          align: 'left',
          hidden: true,
          search: false
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
      // pager: $('#stokLookupPager'),
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

          if (indexRow - 1 > $('#stokLookup').getGridParam().reccount) {
            indexRow = $('#stokLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#stokLookup [id="${$('#stokLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#stokLookup [id="${$('#stokLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#stokLookup').getDataIDs()[indexRow] == undefined) {
              $(`#stokLookup [id="` + $('#stokLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#stokLookup').setSelection($('#stokLookup').getDataIDs()[indexRow])
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

        clearGlobalSearch($('#stokLookup'))
      },
    })
    .customPager()

  loadGlobalSearch($('#stokLookup'))
  loadClearFilter($('#stokLookup'))
</script>