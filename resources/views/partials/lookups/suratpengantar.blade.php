<table id="suratpengantarLookup" class="lookup-grid"></table>
<div id="suratpengantarLookupPager"></div>

@push('scripts')
<script>
  $('#suratpengantarLookup').jqGrid({
      url: `{{ config('app.api_url') . 'suratpengantar' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '50px',
            search: false,
          hidden: true
        },

        {
          label: 'NO. BUKTI',
          name: 'nobukti',
        },
        {
          label: 'TANGGAL BUKTI',
          name: 'tglbukti',
        },
        {
          label: 'PELANGGAN',
          name: 'pelanggan_id',
        },
        {
          label: 'KETERANGAN',
          name: 'keterangan',
        },
        {
          label: 'DARI',
          name: 'dari_id',
        },
        {
          label: 'SAMPAI',
          name: 'sampai_id',
        },
        {
          label: 'CONTAINER',
          name: 'container_id'
        },
        {
          label: 'NO CONT',
          name: 'nocont'
        },
        {
          label: 'NO CONT2',
          name: 'nocont2'
        },
        {
          label: 'STATUS CONTAINER',
          name: 'statuscontainer_id',
        },
        {
          label: 'TRADO',
          name: 'trado_id',
        },
        {
          label: 'SUPIR',
          name: 'supir_id',
        },
        {
          label: 'NOJOB',
          name: 'nojob',
        },
        {
          label: 'NOJOB2',
          name: 'nojob2',
        },
        {
          label: 'STATUSLONGTRIP',
          name: 'statuslongtrip',
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
                    grp: 'STATUS LONGTRIP',
                    subgrp: 'STATUS LONGTRIP'
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
            let statusLongTrip = JSON.parse(value)

            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusLongTrip.WARNA}; color: #fff;">
                  <span>${statusLongTrip.SINGKATAN}</span>
                </div>
              `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusLongTrip = JSON.parse(rowObject.statuslongtrip)

            return ` title="${statusLongTrip.MEMO}"`
          }
        },
        {
          label: 'GAJI SUPIR',
          name: 'gajisupir',
          formatter: 'currency',
          formatoptions: {
            decimalSeparator: ',',
            thousandsSeparator: '.'
          }
        },
        {
          label: 'GAJI KENEK',
          name: 'gajikenek',
          formatter: 'currency',
          formatoptions: {
            decimalSeparator: ',',
            thousandsSeparator: '.'
          }
        },
        {
          label: 'AGEN',
          name: 'agen_id',
        },
        {
          label: 'JENIS ORDER',
          name: 'jenisorder_id',
        },
        {
          label: 'STATUS PERALIHAN',
          name: 'statusperalihan',
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
                    grp: 'STATUS PERALIHAN',
                    subgrp: 'STATUS PERALIHAN'
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
            let statusPeralihan = JSON.parse(value)

            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusPeralihan.WARNA}; color: #fff;">
                  <span>${statusPeralihan.SINGKATAN}</span>
                </div>
              `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusPeralihan = JSON.parse(rowObject.statusperalihan)

            return ` title="${statusPeralihan.MEMO}"`
          }
        },
        {
          label: 'TARIF',
          name: 'tarif_id',
        },
        {
          label: 'NOMINAL PERALIHAN',
          name: 'nominalperalihan',
          formatter: 'currency',
          formatoptions: {
            decimalSeparator: ',',
            thousandsSeparator: '.'
          }
        },
        {
          label: 'NO SP',
          name: 'nosp',
        },
        {
          label: 'TANGGAL SP',
          name: 'tglsp',
        },
        {
          label: 'MODIFIEDBY',
          name: 'modifiedby',
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
      toolbar: [true, "top"],
      rownumWidth: 45,
      rowList: [10, 20, 50, 0],
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      page: 1,
      pager: $('#suratpengantarLookupPager'),
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
          changeJqGridRowListText()
        if (detectDeviceType() == 'desktop') {
          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))

          if (indexRow - 1 > $('#suratpengantarLookup').getGridParam().reccount) {
            indexRow = $('#suratpengantarLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#suratpengantarLookup [id="${$('#suratpengantarLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#suratpengantarLookup [id="${$('#suratpengantarLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#suratpengantarLookup').getDataIDs()[indexRow] == undefined) {
              $(`#suratpengantarLookup [id="` + $('#suratpengantarLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#suratpengantarLookup').setSelection($('#suratpengantarLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookupsuratpengantar').prev().width())
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
        clearGlobalSearch($('#suratpengantarLookup'))
      },
    })

  loadGlobalSearch($('#suratpengantarLookup'))
  loadClearFilter($('#suratpengantarLookup'))
</script>