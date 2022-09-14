<table id="bankLookup" style="width: 100%;"></table>
<div id="bankLookupPager"></div>

@push('scripts')
<script>
  let bankLookup = $('#bankLookup').jqGrid({
      url: `{{ config('app.api_url') . 'bank' }}`,
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
            align: 'left',
            width: 100,
            stype: 'select',
            // searchoptions: {
            //     value: `<?php
            //             $i = 1;

            //             foreach ($data['combo'] as $status) :
            //             echo "$status[param]:$status[parameter]";
            //             if ($i !== count($data['combo'])) {
            //                 echo ";";
            //             }
            //             $i++;
            //             endforeach

            //             ?>
            // `,
            //     dataInit: function(element) {
            //     $(element).select2({
            //         width: 'resolve',
            //         theme: "bootstrap4"
            //     });
            //     }
            // },
        },
        {
            label: 'KODE PENERIMAAN',
            name: 'kodepenerimaan',
            align: 'left'
        },
        {
            label: 'KODE PENGELUARAN',
            name: 'kodepengeluaran',
            align: 'left'
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
      pager: $('#bankLookupPager'),
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
          initResize($(this))

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
          clearColumnSearch()
        })

        $(this).setGridWidth($('#lookupBank').prev().width())
        setHighlight($(this))
      }
    })

    // .jqGrid('filterToolbar', {
    //   stringResult: true,
    //   searchOnEnter: false,
    //   defaultSearch: 'cn',
    //   groupOp: 'AND',
    //   disabledKeys: [16, 17, 18, 33, 34, 35, 36, 37, 38, 39, 40],
    //   beforeSearch: function() {

    //   },
    // })
</script>
@endpush