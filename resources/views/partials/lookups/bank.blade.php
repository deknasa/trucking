<table id="bankLookup" class="lookup-grid"></table>
{{-- <div id="bankLookupPager"></div> --}}

@push('scripts')
<script>
  $('#bankLookup').jqGrid({
      url: `{{ config('app.api_url') . 'bank' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      postData: {
        filters: `{!! $filters ?? '' !!}`,
        aktif: `{!! $Aktif ?? '' !!}`,
        tipe: `{!! $tipe ?? '' !!}`,
        bankId: `{!! $bankId ?? '' !!}`,
        bankExclude: `{!! $bankExclude ?? '' !!}`,
        alatbayar: `{!! $alatbayar ?? '' !!}`,
      },
      colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '70px',
            search: false,
          hidden: true
        },
        {
          label: 'KODE BANK',
          name: 'kodebank',
          align: 'left',
        },
        {
          label: 'NAMA BANK',
          name: 'namabank',
          align: 'left'
        },
        {
          label: 'COA',
          name: 'coa',
          align: 'left'
        },
        {
          label: 'TIPE',
          name: 'tipe',
          align: 'left'
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
          label: 'FORMAT PENERIMAAN',
          name: 'formatpenerimaan',
          align: 'left',
          formatter: (value, options, rowData) => {
            let statusFormatPenerimaan = JSON.parse(value)

            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusFormatPenerimaan.WARNA}; color: #fff;">
                  <span>${statusFormatPenerimaan.SINGKATAN}</span>
                </div>
              `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusFormatPenerimaan = JSON.parse(rowObject.formatpenerimaan)

            return ` title="${statusFormatPenerimaan.MEMO}"`
          }
        },
        {
          label: 'FORMAT PENGELUARAN',
          name: 'formatpengeluaran',
          align: 'left',
          formatter: (value, options, rowData) => {
              let statusFormatPengeluaran = JSON.parse(value)

              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusFormatPengeluaran.WARNA}; color: #fff;">
                  <span>${statusFormatPengeluaran.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusFormatPengeluaran = JSON.parse(rowObject.formatpengeluaran)

              return ` title="${statusFormatPengeluaran.MEMO}"`
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
      // pager: $('#bankLookupPager'),
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

          if (indexRow - 1 > $('#bankLookup').getGridParam().reccount) {
            indexRow = $('#bankLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#bankLookup [id="${$('#bankLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#bankLookup [id="${$('#bankLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#bankLookup').getDataIDs()[indexRow] == undefined) {
              $(`#bankLookup [id="` + $('#bankLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#bankLookup').setSelection($('#bankLookup').getDataIDs()[indexRow])
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
        clearGlobalSearch($('#bankLookup'))
      },
    }).customPager()

  loadGlobalSearch($('#bankLookup'))
  loadClearFilter($('#bankLookup'))
</script>