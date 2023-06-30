@include('layouts._rangeheaderlookup')
<table id="penerimaanTruckingHeaderLookup" class="lookup-grid" style="width: 100%;"></table>
{{-- <div id="penerimaanTruckingHeaderLookupPager"></div> --}}

@push('scripts')
<script>
  
  setRangeLookup()
  initDatepicker()
  $(document).on('click', '#btnReloadLookup', function(event) {
    loadDataHeaderLookup('penerimaantruckingheader', 'penerimaanTruckingHeaderLookup')
  })

  $('#penerimaanTruckingHeaderLookup').jqGrid({
      url: `{{ config('app.api_url') . 'penerimaantruckingheader' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      postData: {
        tgldari: $('#tgldariheaderlookup').val(),
        tglsampai: $('#tglsampaiheaderlookup').val(),
        
        // penerimaanheader_id:  `{!! $penerimaanheader_id ?? '' !!}`,
      
      },
      idPrefix: 'penerimaanTruckingHeaderLookup',
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
          label: 'PENERIMAAN TRUCKING ',
          name: 'penerimaantrucking_id',
          align: 'left'
        },
        {
          label: 'BANK',
          name: 'bank_id',
          align: 'left'
        },
        {
          label: 'KODE PERKIRAAN',
          name: 'coa',
          align: 'left'
        },
        {
          label: 'NO BUKTI PENERIMAAN',
          width: 230,
          name: 'penerimaan_nobukti',
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
      // pager: $('#penerimaanTruckingHeaderLookupPager'),
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

          if (indexRow - 1 > $('#penerimaanTruckingHeaderLookup').getGridParam().reccount) {
            indexRow = $('#penerimaanTruckingHeaderLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#penerimaanTruckingHeaderLookup [id="${$('#penerimaanTruckingHeaderLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#penerimaanTruckingHeaderLookup [id="${$('#penerimaanTruckingHeaderLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#penerimaanTruckingHeaderLookup').getDataIDs()[indexRow] == undefined) {
              $(`#penerimaanTruckingHeaderLookup [id="` + $('#penerimaanTruckingHeaderLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#penerimaanTruckingHeaderLookup').setSelection($('#penerimaanTruckingHeaderLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookupPenerimaanTruckingHeader').prev().width())
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

        clearGlobalSearch($('#penerimaanTruckingHeaderLookup'))
      },
    })
    .customPager()
  loadGlobalSearch($('#penerimaanTruckingHeaderLookup'))
  loadClearFilter($('#penerimaanTruckingHeaderLookup'))
</script>