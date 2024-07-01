<table id="supplierLookup" class="lookup-grid"></table>
{{-- <div id="supplierLookupPager"></div> --}}

<script>
  $('#supplierLookup').jqGrid({
      url: `{{ config('app.api_url') . 'supplier' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      postData: {
        aktif: `{!! $Aktif ?? '' !!}`,
        from: `{!! $from ?? '' !!}`,
      },
      idPrefix: 'supplierLookup',
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
          name: 'namasupplier',
          width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
          align: 'left',
        },
        {
          label: 'NAMA KONTAK',
          name: 'namakontak',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
          align: 'left',
        },
        {
          label: 'ALAMAT',
          name: 'alamat',
          width: (detectDeviceType() == "desktop") ? md_dekstop_3 : md_mobile_3,
          align: 'left'
        },
        {
          label: 'KOTA',
          name: 'kota',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left'
        },
        {
          label: 'KODE POS',
          name: 'kodepos',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
          align: 'left'
        },
        {
          label: 'NO TELEPON (1)',
          name: 'notelp1',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
          align: 'left'
        },
        {
          label: 'NO TELEPON (2)',
          name: 'notelp2',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
          align: 'left'
        },
        {
          label: 'EMAIL',
          name: 'email',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
          align: 'left',
        },
        {
          label: 'STATUS AKTIF',
          name: 'statusaktif',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left',
          stype: 'select',
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
                    grp: 'STATUS AKTIF',
                    subgrp: 'STATUS AKTIF'
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
                      id: row.text,
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
            let statusAktif = JSON.parse(value)

            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusAktif.WARNA}; color: ${statusAktif.WARNATULISAN};">
                  <span>${statusAktif.SINGKATAN}</span>
                </div>
              `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusAktif = JSON.parse(rowObject.statusaktif)

            return ` title="${statusAktif.MEMO}"`
          }
        },
        {
          label: 'WEB',
          name: 'web',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left',
        },
        {
          label: 'NAMA PEMILIK',
          name: 'namapemilik',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
          align: 'left',
        },
        {
          label: 'JENIS USAHA',
          name: 'jenisusaha',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
          align: 'left',
        },
        {
          label: 'TOP',
          name: 'top',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
          align: 'left',
        },
        {
          label: 'BANK',
          name: 'bank',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left',
        },
        {
          label: 'REKENING BANK',
          name: 'rekeningbank',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
          align: 'left',
        },
        {
          label: 'NAMA REKENING',
          name: 'namarekening',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left',
        },
        {
          label: 'JABATAN',
          name: 'jabatan',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left',
        },
        {
          label: 'STATUS DAFTAR HARGA',
          name: 'statusdaftarharga',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left',
          stype: 'select',
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
                    grp: 'STATUS DAFTAR HARGA',
                    subgrp: 'STATUS DAFTAR HARGA'
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
                      id: row.text,
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
            let statusDaftarHarga = JSON.parse(value)

            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusDaftarHarga.WARNA}; color: #fff;">
                  <span>${statusDaftarHarga.SINGKATAN}</span>
                </div>
              `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusDaftarHarga = JSON.parse(rowObject.statusdaftarharga)

            return ` title="${statusDaftarHarga.MEMO}"`
          }
        },
        {
          label: 'KATEGORI USAHA',
          name: 'kategoriusaha',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left',
        },
        {
          label: 'MODIFIED BY',
          name: 'modifiedby',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
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
      rowList: [10, 20, 50, 0],
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      page: 1,
      toolbar: [true, "top"],
      // pager: $('#supplierLookupPager'),
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
          clearColumnSearch($(this))
        })

        $(this).setGridWidth($('#lookupSupplier').prev().width())
        setHighlight($(this))
      }
    })

    .jqGrid("setLabel", "rn", "No.")
    .jqGrid('filterToolbar', {
      stringResult: true,
      searchOnEnter: false,
      defaultSearch: 'cn',
      groupOp: 'AND',
      disabledKeys: [17, 33, 34, 35, 36, 37, 38, 39, 40],
      beforeSearch: function() {
        abortGridLastRequest($(this))

        clearGlobalSearch($('#detail'))
      },
    })

    .jqGrid("navGrid", pager, {
      search: false,
      refresh: false,
      add: false,
      edit: false,
      del: false,
    })
    .customPager()

  loadGlobalSearch($('#supplierLookup'))
  loadClearFilter($('#supplierLookup'))
</script>