<table id="bankPelangganLookup" class="lookup-grid"></table>
<div id="bankPelangganLookupPager"></div>

@push('scripts')
<script>
  $('#bankPelangganLookup').jqGrid({
      url: `{{ config('app.api_url') . 'bankpelanggan' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '70px'
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
          label: 'KETERANGAN',
          name: 'keterangan',
          align: 'left'
        },
        {
          label: 'STATUS AKTIF',
          name: 'statusaktif',
          align: 'left',
          width: 100,
          stype: 'select',
          searchoptions: {
            dataInit: function(element) {
              $(element).select2({
                width: 'resolve',
                theme: "bootstrap4",
                ajax: {
                  url: `${apiUrl}bank/combo`,
                  method: "get",
                  dataType: 'JSON',
                  headers: {
                    Authorization: `Bearer ${accessToken}`
                  },
                  data: function () {
                    return{
                        search: 'status'
                    }
                  },
                  processResults: function (data) {
                    let datas = []
                    $.map(data, function (item) {
                      $.map(item, function (index,value) {
                            $.each(index, (row, detail) => {
                              datas.push({
                                    id: detail.text,
                                    text: detail.text
                                })
                            })
                              
                          })
                        })
                        console.log(datas)
                    return {
                        results: datas
                    };
                  }             
                }
              });
            }
          },
        },
        {
          label: 'MODIFIEDBY',
          name: 'modifiedby',
          align: 'left'
        },
        {
          label: 'UPDATEDAT',
          name: 'updated_at',
          align: 'right'
        }, {
          label: 'CREATEDAT',
          name: 'created_at',
          align: 'right'
        },
      ],
      autowidth: true,
      responsive: true,
      shrinkToFit: false,
      height: 450,
      rowNum: 10,
      rownumbers: true,
      rownumWidth: 45,
      rowList: [10, 20, 50],
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      page: 1,
      toolbar: [true, "top"],
      pager: $('#bankPelangganLookupPager'),
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
        if (detectDeviceType() == 'desktop') {
          $(document).unbind('keydown')
          setCustomBindKeys($(this))

          if (indexRow - 1 > $('#bankPelangganLookup').getGridParam().reccount) {
            indexRow = $('#bankPelangganLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#bankPelangganLookup [id="${$('#bankPelangganLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#bankPelangganLookup [id="${$('#bankPelangganLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#bankPelangganLookup').getDataIDs()[indexRow] == undefined) {
              $(`#bankPelangganLookup [id="` + $('#bankPelangganLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#bankPelangganLookup').setSelection($('#bankPelangganLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookupBankPelanggan').prev().width())
        setHighlight($(this))
      }
    })

    .jqGrid('filterToolbar', {
      stringResult: true,
      searchOnEnter: false,
      defaultSearch: 'cn',
      groupOp: 'AND',
      disabledKeys: [16, 17, 18, 33, 34, 35, 36, 37, 38, 39, 40],
      beforeSearch: function() {
        clearGlobalSearch($('#bankPelangganLookup'))
      },
    })

  loadGlobalSearch($('#bankPelangganLookup'))
  loadClearFilter($('#bankPelangganLookup'))
</script>
