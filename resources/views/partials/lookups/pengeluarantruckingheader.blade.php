
@include('layouts._rangeheaderlookup')
<table id="pengeluaranTruckingHeaderLookup" class="lookup-grid" style="width: 100%;"></table>
{{-- <div id="pengeluaranTruckingHeaderLookupPager"></div> --}}

@push('scripts')
<script>
  
  setRangeLookup()
  initDatepicker()
  
  var urlLookopTas = `{{ config('app.api_url') . 'pengeluarantruckingheader' }}`
  var accessTokenLookup = accessToken
  var from_tnl = ''
  if (urlTas != '') {
    console.log(accessTokenUrlTas,urlTas);
    urlLookopTas = `${urlTas}pengeluarantruckingheader`
    accessTokenLookup = accessTokenUrlTas
    from_tnl = 'YA'
  }
  
  $(document).on('click', '#btnReloadLookup', function(event) {
    let url_tnl = null
    if (urlTas != '') {
      url_tnl = `${urlTas}pengeluarantruckingheader`
    }
    loadDataHeaderLookup('pengeluarantruckingheader', 'pengeluaranTruckingHeaderLookup',{
      pengeluaranheader_id : `{!! $pengeluarantruckingheader_id ?? '' !!}`,
      stok_id: `{!! $stok_id ?? '' !!}`,
      from_tnl: from_tnl,
      
    },url_tnl)
  })

  $('#pengeluaranTruckingHeaderLookup').jqGrid({
      url: urlLookopTas,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      postData: {
        pengeluaranheader_id: `{!! $pengeluarantruckingheader_id ?? '' !!}`,
        stok_id: `{!! $stok_id ?? '' !!}`,
        pengeluaranstok_id: `{!! $pengeluaranstok_id ?? '' !!}`,
        from_tnl: from_tnl,
        tgldari: $('#tgldariheaderlookup').val(),
        tglsampai: $('#tglsampaiheaderlookup').val(),
      },
      idPrefix: 'pengeluaranTruckingHeaderLookup',
      datatype: "json",
      colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '70px',
            search: false,
          hidden: true
        },
        {
          label: 'STATUS CETAK',
          name: 'statuscetak',
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
                    grp: 'STATUS CETAK',
                    subgrp: 'STATUS CETAK'
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
            let statusCetak = JSON.parse(value)

            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusCetak.WARNA}; color: #fff;">
                  <span>${statusCetak.SINGKATAN}</span>
                </div>
              `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusCetak = JSON.parse(rowObject.statuscetak)

            return ` title="${statusCetak.MEMO}"`
          }
        },
        {
          label: 'NO BUKTI',
          name: 'nobukti',
          align: 'left'
        },
        {
          label: 'TGL BUKTI',
          name: 'tglbukti',
          align: 'left',
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y"
          }
        },
        {
          label: 'PENGELUARAN TRUCKING ',
          name: 'pengeluarantrucking_id',
          align: 'left'
        },
        {
          label: 'BANK',
          name: 'bank_id',
          align: 'left'
        },
        {
          label: 'USER BUKA CETAK',
          name: 'userbukacetak',
          align: 'left'
        },
        {
          label: 'TGL CETAK',
          name: 'tglbukacetak',
          align: 'left',
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y"
          }
        },
        {
          label: 'STATUS POSTING',
          name: 'statusposting',
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
                    grp: 'STATUS POSTING',
                    subgrp: 'STATUS POSTING'
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
              return '';
            }
            let statusPosting = JSON.parse(value)

            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusPosting.WARNA}; color: #fff;">
                  <span>${statusPosting.SINGKATAN}</span>
                </div>
              `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            if (!rowObject.statusposting) {
              return '';
            }
            let statusPosting = JSON.parse(rowObject.statusposting)

            return ` title="${statusPosting.MEMO}"`
          }
        },
        {
          label: 'KODE PERKIRAAN',
          name: 'coa',
          align: 'left'
        },
        {
          label: 'NO BUKTI pengeluaran',
            width: 210,
          name: 'pengeluaran_nobukti',
          align: 'left'
        },
        {
          label: 'pengeluaran trucking Nobukti',
          width: 210,
          name: 'pengeluarantrucking_nobukti',
          align: 'left'
        },
        {
          label: 'qty',
          name: 'qty',
          align: 'left',
          search: false,
        },
        {
          label: 'MODIFIED BY',
          name: 'modifiedby',
          align: 'left'
        },
        {
          label: 'CREATED AT',
          name: 'created_at',
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
      height: 250,
      width: 500,
      rowNum: 10,
      rownumbers: true,
      rownumWidth: 45,
      rowList: [10, 20, 50, 0],
      toolbar: [true, "top"],
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      page: 1,
      // pager: $('#pengeluaranTruckingHeaderLookupPager'),
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
        jqXHR.setRequestHeader('Authorization', `Bearer ${accessTokenLookup}`)

        setGridLastRequest($(this), jqXHR)
      },
      loadComplete: function(data) {
          changeJqGridRowListText()
        if (detectDeviceType() == 'desktop') {
          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))

          if (indexRow - 1 > $('#pengeluaranTruckingHeaderLookup').getGridParam().reccount) {
            indexRow = $('#pengeluaranTruckingHeaderLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#pengeluaranTruckingHeaderLookup [id="${$('#pengeluaranTruckingHeaderLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#pengeluaranTruckingHeaderLookup [id="${$('#pengeluaranTruckingHeaderLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#pengeluaranTruckingHeaderLookup').getDataIDs()[indexRow] == undefined) {
              $(`#pengeluaranTruckingHeaderLookup [id="` + $('#pengeluaranTruckingHeaderLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#pengeluaranTruckingHeaderLookup').setSelection($('#pengeluaranTruckingHeaderLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookupPengeluaranTruckingHeader').prev().width())
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

        clearGlobalSearch($('#pengeluaranTruckingHeaderLookup'))
      },
    })
    .customPager()
  loadGlobalSearch($('#pengeluaranTruckingHeaderLookup'))
  loadClearFilter($('#pengeluaranTruckingHeaderLookup'))
</script>