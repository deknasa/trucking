<table id="penerimaLookup" class="lookup-grid"></table>
{{-- <div id="penerimaLookupPager"></div> --}}

@push('scripts')
<script>
  $('#penerimaLookup').jqGrid({
      url: `{{ config('app.api_url') . 'penerima' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      idPrefix: 'penerimaLookup',
      colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '70px',
            search: false,
          hidden: true
        },
        {
          label: 'NAMA PENERIMA',
          name: 'namapenerima',
        },
        {
          label: 'NPWP',
          name: 'npwp',
        },
        {
          label: 'NO KTP',
          name: 'noktp',
        },
        {
          label: 'STATUS AKTIF',
          name: 'statusaktif',
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
          label: 'STATUS KARYAWAN',
          name: 'statuskaryawan',
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
                    grp: 'STATUS KARYAWAN',
                    subgrp: 'STATUS KARYAWAN'
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
            let statusKaryawan = JSON.parse(value)

            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusKaryawan.WARNA}; color: #fff;">
                  <span>${statusKaryawan.SINGKATAN}</span>
                </div>
              `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusKaryawan = JSON.parse(rowObject.statuskaryawan)

            return ` title="${statusKaryawan.MEMO}"`
          }
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
      height: 450,
      rowNum: 10,
      rownumbers: true,
      rownumWidth: 45,
      rowList: [10, 20, 50, 0],
      sortable: true,
      toolbar: [true, "top"],
      sortname: 'id',
      sortorder: 'asc',
      page: 1,
      // pager: $('#penerimaLookupPager'),
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

          if (indexRow - 1 > $('#penerimaLookup').getGridParam().reccount) {
            indexRow = $('#penerimaLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#penerimaLookup [id="${$('#penerimaLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#penerimaLookup [id="${$('#penerimaLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#penerimaLookup').getDataIDs()[indexRow] == undefined) {
              $(`#penerimaLookup [id="` + $('#penerimaLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#penerimaLookup').setSelection($('#penerimaLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookuppenerima').prev().width())
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

        clearGlobalSearch($('#penerimaLookup'))
      },
    })
    .customPager()
  loadGlobalSearch($('#penerimaLookup'))
  loadClearFilter($('#penerimaLookup'))
</script>