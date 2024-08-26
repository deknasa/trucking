<table id="kotaLookup" class="lookup-grid"></table>

@push('scripts')
<script>
  $('#kotaLookup').jqGrid({
      url: `{{ config('app.api_url') . 'kota' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      postData: {
        aktif: `{!! $Aktif ?? '' !!}`,
        statuspelabuhan: `{!! $StatusPelabuhan ?? '' !!}`,
        kotadari_id: `{!! $kotadari_id ?? '' !!}`,
        kotasampai_id: `{!! $kotasampai_id ?? '' !!}`,
        pilihkota_id: `{!! $pilihkota_id ?? '' !!}`,
        dataritasi_id: `{!! $DataRitasi ?? '' !!}`,
        ritasidarike: `{!! $RitasiDariKe ?? '' !!}`,
        zonadari_id: `{!! $zonadari_id ?? '' !!}`,
        zonasampai_id: `{!! $zonasampai_id ?? '' !!}`,
        upahSupirDariKe: `{!! $upahSupirDariKe ?? '' !!}`,
        upahSupirKotaDari: `{!! $upahSupirKotaDari ?? '' !!}`,
      },         
      idPrefix: 'kotaLookup',
      colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '70px',
            search: false,
          hidden: true
        },
        {
          label: 'KOTA',
          name: 'kodekota',
          align: 'left',
          width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
        },
        {
          label: 'KETERANGAN',
          name: 'keterangan',
          align: 'left',
          width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
        },
        {
          label: 'ZONA',
          name: 'zona_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left'
        },
        {
          label: 'STATUS AKTIF',
          name: 'statusaktif',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
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
          label: 'MODIFIED BY',
          name: 'modifiedby',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
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
      ],
      autowidth: true,
      responsive: true,
      shrinkToFit: false,
      height: 350,
      rowNum: 10,
      rownumbers: true,
      toolbar: [true, "top"],
      rownumWidth: 45,
      rowList: [10, 20, 50, 0],
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      page: 1,
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

          if (indexRow - 1 > $('#kotaLookup').getGridParam().reccount) {
            indexRow = $('#kotaLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#kotaLookup [id="${$('#kotaLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#kotaLookup [id="${$('#kotaLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#kotaLookup').getDataIDs()[indexRow] == undefined) {
              $(`#kotaLookup [id="` + $('#kotaLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#kotaLookup').setSelection($('#kotaLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookupkota').prev().width())
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

        clearGlobalSearch($('#kotaLookup'))
      },
    })

    .customPager()
  loadGlobalSearch($('#kotaLookup'))
  loadClearFilter($('#kotaLookup'))
</script>