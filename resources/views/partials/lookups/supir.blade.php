<table id="supirLookup" class="lookup-grid"></table>
<div id="supirLookupPager"></div>

@push('scripts')
<script>
  $('#supirLookup').jqGrid({
      url: `{{ config('app.api_url') . 'supir' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      postData: {
        aktif: `{!! $Aktif ?? '' !!}`,
      },
      colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '70px',
          hidden: true
        },
        {
          label: 'NAMA',
          name: 'namasupir',
          align: 'left',
        },
        {
          label: 'TGL LAHIR',
          name: 'tgllahir',
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y"
          }
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
          label: 'TELP',
          name: 'telp',
          align: 'left'
        },
        {
          label: 'STATUS AKTIF',
          name: 'statusaktif',
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
                <div class="badge" style="background-color: ${statusAktif.WARNA}; color: #fff;">
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
          label: 'NOMINAL DEPOSIT',
          name: 'nominaldepositsa',
        },
        {
          label: 'NOM PINJ SALDO AWAL',
          name: 'nominalpinjamansaldoawal',
        },
        {
          label: 'SUPIR LAMA',
          name: 'supirold_id',
        },
        {
          label: 'SIM',
          name: 'nosim',
        },
        {
          label: 'TGL EXP SIM',
          name: 'tglexpsim',
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y"
          }
        },
        {
          label: 'TGL TERBIT SIM',
          name: 'tglterbitsim',
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y"
          }
        },
        {
          label: 'KETERANGAN',
          name: 'keterangan',
        },
        {
          label: 'KTP',
          name: 'noktp',
        },
        {
          label: 'KK',
          name: 'nokk',
        },
        {
          label: 'STATUS ADA UPDATE GBR',
          name: 'statusadaupdategambar',
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
                    grp: 'STATUS ADA UPDATE GAMBAR',
                    subgrp: 'STATUS ADA UPDATE GAMBAR'
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
            let statusAdaUpdateGambar = JSON.parse(value)

            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusAdaUpdateGambar.WARNA}; color: #fff;">
                  <span>${statusAdaUpdateGambar.SINGKATAN}</span>
                </div>
              `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusAdaUpdateGambar = JSON.parse(rowObject.statusadaupdategambar)

            return ` title="${statusAdaUpdateGambar.MEMO}"`
          }
        },
        {
          label: 'STATUS LUAR KOTA',
          name: 'statusluarkota',
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
                    grp: 'STATUS LUAR KOTA',
                    subgrp: 'STATUS LUAR KOTA'
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
            let statusLuarKota = JSON.parse(value)

            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusLuarKota.WARNA}; color: #fff;">
                  <span>${statusLuarKota.SINGKATAN}</span>
                </div>
              `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusLuarKota = JSON.parse(rowObject.statusluarkota)

            return ` title="${statusLuarKota.MEMO}"`
          }
        },
        {
          label: 'ZONA TERTENTU',
          name: 'statuszonatertentu',
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
                    grp: 'ZONA TERTENTU',
                    subgrp: 'ZONA TERTENTU'
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
            let statusZonaTertentu = JSON.parse(value)

            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusZonaTertentu.WARNA}; color: #fff;">
                  <span>${statusZonaTertentu.SINGKATAN}</span>
                </div>
              `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusZonaTertentu = JSON.parse(rowObject.statuszonatertentu)

            return ` title="${statusZonaTertentu.MEMO}"`
          }
        },
        {
          label: 'ZONA',
          name: 'zona_id',
        },
        {
          label: 'angsuranpinjaman',
          name: 'angsuranpinjaman',
        },
        {
          label: 'plafondeposito',
          name: 'plafondeposito',
        },
        {
          label: 'PHOTO SUPIR',
          name: 'photosupir',
          search: false,
          align: 'center',
          formatter: (value, row) => {
            let images = []
            if (value) {
              let files = JSON.parse(value)

              files.forEach(file => {
                let image = new Image()
                image.width = 25
                image.height = 25
                image.src = `${apiUrl}supir/image/supir/${file}/small`

                images.push(image.outerHTML)
              });

              return images.join(' ')
            }
            return 'NO PHOTOS'
          }
        },
        {
          label: 'PHOTO KTP',
          name: 'photoktp',
          align: 'center',
          search: false,
          formatter: (value, row) => {
            let images = []
            if (value) {
              let files = JSON.parse(value)

              files.forEach(file => {
                let image = new Image()
                image.width = 25
                image.height = 25
                image.src = `${apiUrl}supir/image/ktp/${file}/small`

                images.push(image.outerHTML)
              });

              return images.join(' ')
            }
            return 'NO PHOTOS'
          }
        },
        {
          label: 'PHOTO SIM',
          name: 'photosim',
          align: 'center',
          search: false,
          formatter: (value, row) => {
            let images = []
            if (value) {
              let files = JSON.parse(value)

              files.forEach(file => {
                let image = new Image()
                image.width = 25
                image.height = 25
                image.src = `${apiUrl}supir/image/sim/${file}/small`

                images.push(image.outerHTML)
              });

              return images.join(' ')
            }
            return 'NO PHOTOS'
          }
        },
        {
          label: 'PHOTO KK',
          name: 'photokk',
          align: 'center',
          search: false,
          formatter: (value, row) => {
            let images = []
            if (value) {
              let files = JSON.parse(value)

              files.forEach(file => {
                let image = new Image()
                image.width = 25
                image.height = 25
                image.src = `${apiUrl}supir/image/kk/${file}/small`

                images.push(image.outerHTML)
              });

              return images.join(' ')
            }
            return 'NO PHOTOS'
          }
        },
        {
          label: 'PHOTO SKCK',
          name: 'photoskck',
          search: false,
          align: 'center',
          formatter: (value, row) => {
            let images = []
            if (value) {
              let files = JSON.parse(value)

              files.forEach(file => {
                let image = new Image()
                image.width = 25
                image.height = 25
                image.src = `${apiUrl}supir/image/skck/${file}/small`

                images.push(image.outerHTML)
              });

              return images.join(' ')
            }
            return 'NO PHOTOS'
          }
        },
        {
          label: 'PHOTO DOMISILI',
          name: 'photodomisili',
          search: false,
          align: 'center',
          formatter: (value, row) => {
            let images = []
            if (value) {
              let files = JSON.parse(value)

              files.forEach(file => {
                let image = new Image()
                image.width = 25
                image.height = 25
                image.src = `${apiUrl}supir/image/domisili/${file}/small`

                images.push(image.outerHTML)
              });

              return images.join(' ')
            }
            return 'NO PHOTOS'
          }
        },
        {
          label: 'TGL BERHENTI SUPIR',
          name: 'tglberhentisupir',
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y"
          }
        },
        {
          label: 'KET RESIGN',
          name: 'keteranganresign',
        },
        {
          label: 'STATUS BLACKLIST',
          name: 'statusblacklist',
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
                    grp: 'BLACKLIST SUPIR',
                    subgrp: 'BLACKLIST SUPIR'
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
            let statusBlacklist = JSON.parse(value)

            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusBlacklist.WARNA}; color: #fff;">
                  <span>${statusBlacklist.SINGKATAN}</span>
                </div>
              `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusBlacklist = JSON.parse(rowObject.statusblacklist)

            return ` title="${statusBlacklist.MEMO}"`
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
      rowList: [10, 20, 50],
      toolbar: [true, "top"],
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      page: 1,
      pager: $('#supirLookupPager'),
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
        jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)
      },
      loadComplete: function(data) {
        if (detectDeviceType() == 'desktop') {
          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))

          if (indexRow - 1 > $('#supirLookup').getGridParam().reccount) {
            indexRow = $('#supirLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#supirLookup [id="${$('#supirLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#supirLookup [id="${$('#supirLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#supirLookup').getDataIDs()[indexRow] == undefined) {
              $(`#supirLookup [id="` + $('#supirLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#supirLookup').setSelection($('#supirLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookupSupir').prev().width())
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
        clearGlobalSearch($('#supirLookup'))
      },
    })

  loadGlobalSearch($('#supirLookup'))
  loadClearFilter($('#supirLookup'))
</script>