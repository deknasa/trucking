<table id="alatBayarLookup" class="lookup-grid"></table>

@push('scripts')
<script>
  $('#alatBayarLookup').jqGrid({
      url: `{{ config('app.api_url') . 'alatbayar' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      postData: {
        statusdefault: `{!! $statusDefault?? '' !!}`,
        bank_id: `{!! $bank_Id ?? '' !!}`,
        aktif: `{!! $Aktif ?? '' !!}`,
        from: `{!! $from ?? '' !!}`,
      },
      idPrefix: 'alatBayarLookup',
      colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '70px',
          search: false,
          hidden: true
        },
        {
          label: 'ALAT BAYAR',
          name: 'kodealatbayar',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left',
        },
        {
          label: 'NAMA ALAT BAYAR',
          name: 'namaalatbayar',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left',
        },
        {
          label: 'BANK',
          name: 'bank',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left'
        },
        {
          label: 'bank_id',
          name: 'bank_id',
          hidden: true
        },
        {
          label: 'KETERANGAN',
          name: 'keterangan',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left'
        },
        {
          label: 'STATUS LANGSUNG CAIR',
          name: 'statuslangsungcair',
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
                    grp: 'STATUS LANGSUNG CAIR',
                    subgrp: 'STATUS LANGSUNG CAIR'
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
            let statusLgsgCair = JSON.parse(value)

            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusLgsgCair.WARNA}; color: #fff;">
                  <span>${statusLgsgCair.SINGKATAN}</span>
                </div>
              `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusLgsgCair = JSON.parse(rowObject.statuslangsungcair)

            return ` title="${statusLgsgCair.MEMO}"`
          }
        },
        {
          label: 'STATUS DEFAULT',
          name: 'statusdefault',
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
                    grp: 'STATUS DEFAULT',
                    subgrp: 'STATUS DEFAULT'
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
            let statusDefault = JSON.parse(value)

            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusDefault.WARNA}; color: #fff;">
                  <span>${statusDefault.SINGKATAN}</span>
                </div>
              `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusDefault = JSON.parse(rowObject.statusdefault)

            return ` title="${statusDefault.MEMO}"`
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
      // pager: $('#alatBayarLookupPager'),
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

          if (indexRow - 1 > $('#alatBayarLookup').getGridParam().reccount) {
            indexRow = $('#alatBayarLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#alatBayarLookup [id="${$('#alatBayarLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#alatBayarLookup [id="${$('#alatBayarLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#alatBayarLookup').getDataIDs()[indexRow] == undefined) {
              $(`#alatBayarLookup [id="` + $('#alatBayarLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#alatBayarLookup').setSelection($('#alatBayarLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookupBank').prev().width())
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

        clearGlobalSearch($('#alatBayarLookup'))
      },
    })
    .customPager()
  loadGlobalSearch($('#alatBayarLookup'))
  loadClearFilter($('#alatBayarLookup'))
</script>