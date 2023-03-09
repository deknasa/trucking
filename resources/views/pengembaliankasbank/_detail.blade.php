<!-- Grid -->
<div class="container-fluid my-4">
  <div class="row">
    <div class="col-12">
      <table id="detail"></table>
      <div id="detailPager"></div>
    </div>
  </div>
</div>

@push('scripts')
<script>
  let sortnamedetail
  let sortorderdetail
  let indexRowdetail = 0;
  let totalRecorddetail
  let limitdetail
  let postDatadetail
  let triggerClickdetail
  let pageDetail = 0

  function loadDetailGrid(id) {

    $("#detail").jqGrid({
        url: `${apiUrl}pengembaliankasbankdetail`,
        mtype: "GET",
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        datatype: "local",
        colModel: [{
            label: 'NO BUKTI',
            name: 'nobukti',
          },
          {
            label: 'NO WARKAT',
            name: 'nowarkat',
          },
          {
            label: 'TGL JATUH TEMPO',
            name: 'tgljatuhtempo',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },
          {
            label: 'KETERANGAN',
            name: 'keterangan',
          },
          {
            label: 'NOMINAL',
            name: 'nominal',
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'COA DEBET',
            name: 'coadebet',
          },
          {
            label: 'COA KREDIT',
            name: 'coakredit',
          },
          {
            label: 'BULAN BEBAN',
            name: 'bulanbeban',
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          }
        ],
        autowidth: true,
        shrinkToFit: false,
        height: 350,
        rowNum: 10,
        rownumbers: true,
        rownumWidth: 45,
        rowList: [10, 20, 50, 0],
        footerrow: true,
        userDataOnFooter: true,
        toolbar: [true, "top"],
        sortable: true,
        sortname: sortname,
        sortorder: sortorder,
        page: pageDetail,
        viewrecords: true,
        postData: {
          pengembaliankasbank_id: id
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
        loadBeforeSend: (jqXHR) => {
          jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)
        },
        onSelectRow: function(id) {
          activeGrid = $(this)
        },
        loadComplete: function(data) {

          console.log(data.attributes)
          changeJqGridRowListText()
          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))

          if(data.attributes != undefined){
            
            pageDetail = data.attributes.totalPages
          }
          
          /* Set global variables */
          sortnamedetail = $(this).jqGrid("getGridParam", "sortname")
          sortorderdetail = $(this).jqGrid("getGridParam", "sortorder")
          totalRecorddetail = $(this).getGridParam("records")
          limitdetail = $(this).jqGrid('getGridParam', 'postData').limit
          postDatadetail = $(this).jqGrid('getGridParam', 'postData')
          triggerClickdetail = true

          $('.clearsearchclass').click(function() {
            clearColumnSearch($(this))
          })

          if (indexRowdetail > $(this).getDataIDs().length - 1) {
            indexRowdetail = $(this).getDataIDs().length - 1;
          }

          $('#detail').setSelection($('#detail').getDataIDs()[0])

          setHighlight($(this))
          if (data.attributes) {
            $(this).jqGrid('footerData', 'set', {
              nobukti: 'Total:',
              nominal: data.attributes.totalNominal,
            }, true)
          }
        }
      })

      .jqGrid("setLabel", "rn", "No.")
      .jqGrid('filterToolbar', {
        stringResult: true,
        searchOnEnter: false,
        defaultSearch: 'cn',
        groupOp: 'AND',
        disabledKeys: [17, 33, 34, 35, 36, 37, 38, 39, 40],
        beforeSearch: function() {
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

  function loadDetailData(id) {
    $('#detail').setGridParam({
      url: `${apiUrl}pengembaliankasbankdetail`,
      datatype: "json",
      postData: {
        pengembaliankasbank_id: id
      },
      page:1
    }).trigger('reloadGrid')
  }
</script>
@endpush()