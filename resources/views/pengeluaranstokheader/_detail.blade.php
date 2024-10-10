<!-- Grid -->
<div class="container-fluid my-4">
  <div class="row">
    <div class="col-12">
      <table id="detail"></table>
    </div>
  </div>
</div>

@push('scripts')
<script>
  let sortnameDetail = 'nobukti'
  let sortorderDetail = 'asc'
  let totalRecordDetail
  let limitDetail
  let postDataDetail
  let triggerClickDetail
  let indexRowDetail
  let pageDetail = 0;

  function loadDetailGrid() {
    let pager = '#detailPager'

    $("#detail").jqGrid({
        url: `${apiUrl}pengeluaranstokdetail`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "local",
        colModel: [{
            label: 'NO BUKTI',
            name: 'nobukti',
          },
          {
            label: 'stok',
            name: 'stok',
          },
          {
            label: 'STATUS reuse',
            name: 'statusreuse',
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
                    grp: 'STATUS reuse',
                    subgrp: 'STATUS reuse'
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
                      id: row.id,
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
              if(!value){
                return ''
              }
            let statusreuse = JSON.parse(value)
            let formattedValue = $(`
            <div class="badge" style="background-color: ${statusreuse.WARNA}; color: ${statusreuse.WARNATULISAN};">
              <span>${statusreuse.SINGKATAN}</span>
              </div>
              `)
              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              if(!value){
                return ''
              }
              let statusreuse = JSON.parse(rowObject.statusreuse)
              return ` title="${statusreuse.MEMO}"`
            }
          },
          {
            label: 'qty',
            name: 'qty',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'harga',
            name: 'harga',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'selisih harga fifo',
            name: 'selisihhargafifo',
            align: 'right',
            formatter: currencyFormat,
          },

          {
            label: 'persentase discount',
            width: 200,
            name: 'persentasediscount',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'nominal discount',
            name: 'nominaldiscount',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'vulkanisir ke',
            name: 'vulkanisirke',
          },
          {
            label: 'Status Oli',
            name: 'statusoli',
          },
          {
            label: 'TOTAL',
            name: 'total',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
          },
          {
            label: 'MODIFIED BY',
            name: 'modifiedby',
          },


        ],
        autowidth: true,
        shrinkToFit: false,
        height: 350,
        rowNum: 0,
        rownumbers: true,
        footerrow: true,
        userDataOnFooter: true,
        rownumWidth: 45,
        rowList: [10, 20, 50, 0],
        toolbar: [true, "top"],
        sortable: true,
        sortname: sortnameDetail,
        sortorder: sortorderDetail,
        page: pageDetail,
        // pager: pager,
        viewrecords: true,
        postData: {
          pengeluaranstokheader_id: id
        },
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
        loadBeforeSend: function(jqXHR) {
          jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)

          setGridLastRequest($(this), jqXHR)
        },
        loadComplete: function(data) {
          changeJqGridRowListText()

          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))

          /* Set global variables */
          sortnameDetail = $(this).jqGrid("getGridParam", "sortname")
          sortorderDetail = $(this).jqGrid("getGridParam", "sortorder")
          totalRecordDetail = $(this).getGridParam("records")
          limitDetail = $(this).jqGrid('getGridParam', 'postData').limit
          postDataDetail = $(this).jqGrid('getGridParam', 'postData')
          triggerClick = false

          $('.clearsearchclass').click(function() {
            clearColumnSearch($(this))
          })

          if (indexRowDetail > $(this).getDataIDs().length - 1) {
            indexRowDetail = $(this).getDataIDs().length - 1;
          }

          setHighlight($(this))

          if (data.attributes) {
            $(this).jqGrid('footerData', 'set', {
              statusoli: 'Total:',
              total: data.attributes.totalNominal,
            }, true)
          }
        }
      })
      .jqGrid('filterToolbar', {
        stringResult: true,
        searchOnEnter: false,
        defaultSearch: 'cn',
        groupOp: 'AND',
        disabledKeys: [17, 33, 34, 35, 36, 37, 38, 39, 40],
        beforeSearch: function() {
          abortGridLastRequest($(this))
          
          clearGlobalSearch($('#detail'))
        },
      })

      .jqGrid("navGrid", pager, {
        search: false,
        refresh: false,
        add: false,
        edit: false,
        del: false,
      })
      .customPager()

    /* Append clear filter button */
    loadClearFilter($('#detail'))

    /* Append global search */
    loadGlobalSearch($('#detail'))
  }

  function loadDetailData(id,nobukti) {
        abortGridLastRequest($('#detail'))

        $('#detail').setGridParam({
      url: `${apiUrl}pengeluaranstokdetail`,
      datatype: "json",
      postData: {
        nobukti: nobukti,
        pengeluaranstokheader_id: id
      },
      page: 1
    }).trigger('reloadGrid')
  }
</script>
@endpush()