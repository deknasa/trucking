<table id="mainAkunPusatLookup" class="lookup-grid" style="width: 100%;"></table>

<script>
  $('#mainAkunPusatLookup').jqGrid({
      url: `{{ config('app.api_url') . 'mainakunpusat' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      postData: {
        level: `{!! $levelCoa ?? '' !!}`,
        potongan: `{!! $potongan ?? '' !!}`,
        aktif: `{!! $Aktif ?? '' !!}`,
        // filters: `{!! $filters ?? '' !!}`
      },
      idPrefix: 'mainAkunPusatLookup',
      colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '70px',
          search: false,
          hidden: true
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
          label: 'KODE PERKIRAAN',
          name: 'coa',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left',
        },
        {
          label: 'keterangan kode perkiraan',
            width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
          name: 'keterangancoa',
          align: 'left'
        },
        {
          label: 'TYPE',
          name: 'type',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left'
        },
        {
          label: 'AKUNTANSI',
          name: 'akuntansi',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
        },
        {
          label: 'LEVEL',
          name: 'level',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
          align: 'left'
        },
        {
          label: 'PARENT',
          name: 'parent',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left'
        },
        {
          label: 'STATUS PARENT',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          name: 'statusparent',
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
                    grp: 'STATUS PARENT',
                    subgrp: 'STATUS PARENT'
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
            if (!value) {
              return ''
            }
            let statusParent = JSON.parse(value)

            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusParent.WARNA}; color: #fff;">
                  <span>${statusParent.SINGKATAN}</span>
                </div>
              `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            if (!rowObject.statusparent) {
              return ` title=""`
            }
            let statusParent = JSON.parse(rowObject.statusparent)

            return ` title="${statusParent.MEMO}"`
          }
        },
        {
          label: 'STATUS NERACA',
          name: 'statusneraca',
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
                    grp: 'STATUS NERACA',
                    subgrp: 'STATUS NERACA'
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
            let statusNeraca = JSON.parse(value)

            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusNeraca.WARNA}; color: #fff;">
                  <span>${statusNeraca.SINGKATAN}</span>
                </div>
              `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusNeraca = JSON.parse(rowObject.statusneraca)

            return ` title="${statusNeraca.MEMO}"`
          }
        },
        {
          label: 'STATUS LABA RUGI',
          name: 'statuslabarugi',
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
                    grp: 'STATUS LABA RUGI',
                    subgrp: 'STATUS LABA RUGI'
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
            let statusLabaRugi = JSON.parse(value)

            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusLabaRugi.WARNA}; color: #fff;">
                  <span>${statusLabaRugi.SINGKATAN}</span>
                </div>
              `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusLabaRugi = JSON.parse(rowObject.statuslabarugi)

            return ` title="${statusLabaRugi.MEMO}"`
          }
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
        {
          label: 'kode-keterangan',
          name: 'kodeket',
            width: (detectDeviceType() == "desktop") ? md_dekstop_3 : md_mobile_3,
          align: 'left'
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
      // pager: $('#mainAkunPusatLookupPager'),
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

          if (indexRow - 1 > $('#mainAkunPusatLookup').getGridParam().reccount) {
            indexRow = $('#mainAkunPusatLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#mainAkunPusatLookup [id="${$('#mainAkunPusatLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#mainAkunPusatLookup [id="${$('#mainAkunPusatLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#mainAkunPusatLookup').getDataIDs()[indexRow] == undefined) {
              $(`#mainAkunPusatLookup [id="` + $('#mainAkunPusatLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#mainAkunPusatLookup').setSelection($('#mainAkunPusatLookup').getDataIDs()[indexRow])
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

        clearGlobalSearch($('#mainAkunPusatLookup'))
      },
    })
    .customPager()
  loadGlobalSearch($('#mainAkunPusatLookup'))
  loadClearFilter($('#mainAkunPusatLookup'))
</script>