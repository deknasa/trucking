<table id="tarifLookup" class="lookup-grid"></table>
{{-- <div id="tarifLookupPager"></div> --}}

@push('scripts')
<script>
  $('#tarifLookup').jqGrid({
      url: `{{ config('app.api_url') . 'tarif' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      postData: {
        aktif: `{!! $Aktif ?? '' !!}`,
        jenisOrder: `{!! $jenisOrder ?? '' !!}`,
        isParent: `{!! $isParent ?? '' !!}`,
      },
      idPrefix: 'tarifLookup',
      colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '50px',
          search: false,
          hidden: true
        },

        {
          label: 'TUJUAN',
          name: 'tujuan',
          width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
        },
        {
          label: 'PENYESUAIAN',
          name: 'penyesuaian',
          width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
        },
        // {
        //   label: 'CONTAINER',
        //   name: 'container_id',
        // },

        {
          label: 'STATUS AKTIF',
          name: 'statusaktif',
          stype: 'select',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
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
        // {
        //   label: 'TUJUAN ASAL',
        //   name: 'tujuanasal',
        // },
        {
          label: 'SISTEM TON',
          name: 'statussistemton',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
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
                    grp: 'SISTEM TON',
                    subgrp: 'SISTEM TON'
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
            let statusSistemTon = JSON.parse(value)
            if (!statusSistemTon) {
              return ''
            }
            console.log(statusSistemTon)
            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusSistemTon.WARNA}; color: ${statusSistemTon.WARNATULISAN};">
                  <span>${statusSistemTon.SINGKATAN}</span>
                </div>
              `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusSistemTon = JSON.parse(rowObject.statussistemton)
            if (!statusSistemTon) {
              return ` title=""`
            }
            return ` title="${statusSistemTon.MEMO}"`
          }
        },
        {
          label: 'KOTA',
          name: 'kota_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
        },
        {
          label: 'KOTAID',
          name: 'kotaId',
          hidden: true,
          search: false,
        },
        {
          label: 'ZONA',
          name: 'zona_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
        },
        {
          label: 'PELABUHAN',
          name: 'pelabuhan_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
        },
        {
          label: 'jenis order',
          name: 'jenisorder',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
        },
        // {
        //   label: 'NOMINAL TON',
        //   name: 'nominalton',
        //   align: 'right',
        //   formatter: 'currency',
        //   formatoptions: {
        //       decimalSeparator: ',',
        //       thousandsSeparator: '.'
        //   }
        // },
        // {
        //   label: 'TGL BERLAKU',
        //   name: 'tglberlaku',
        //   formatter: "date",
        //   formatoptions: { srcformat: "ISO8601Long", newformat: "d-m-Y" }
        // },
      
        {
          label: 'MODIFIED BY',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          name: 'modifiedby',
          align: 'left'
        },
        {
          label: 'CREATED AT',
          name: 'created_at',
          align: 'right',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
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
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y H:i:s"
          }
        },
        {
          label: 'Tujuan-Penyesuaian',
          name: 'tujuanpenyesuaian',
          width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
          align: 'left'
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
      sortname: 'tujuan',
      sortorder: 'asc',
      page: 1,
      // pager: $('#tarifLookupPager'),
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

          if (indexRow - 1 > $('#tarifLookup').getGridParam().reccount) {
            indexRow = $('#tarifLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#tarifLookup [id="${$('#tarifLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#tarifLookup [id="${$('#tarifLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#tarifLookup').getDataIDs()[indexRow] == undefined) {
              $(`#tarifLookup [id="` + $('#tarifLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#tarifLookup').setSelection($('#tarifLookup').getDataIDs()[indexRow])
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

        clearGlobalSearch($('#tarifLookup'))
      },
    })
    .customPager()
  loadGlobalSearch($('#tarifLookup'))
  loadClearFilter($('#tarifLookup'))
</script>