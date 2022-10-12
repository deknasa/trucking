<table id="containerLookup" class="lookup-grid"></table>
<div id="containerLookupPager"></div>

@push('scripts')
<script>
  $('#containerLookup').jqGrid({
      url: `{{ config('app.api_url') . 'container' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '50px'
        },
        {
          label: 'KODE CONTAINER',
          name: 'kodecontainer',
          align: 'left'
        },
        {
          label: 'KETERANGAN',
          name: 'keterangan',
          align: 'left'
        },
        {
          label: 'Status',
          name: 'statusaktif',
          width: 100,
        //   stype: 'select',
        //   searchoptions: {
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
        //  },
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
      toolbar: [true, "top"],
      sortname: 'id',
      sortorder: 'asc',
      page: 1,
      pager: $('#containerLookupPager'),
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

          if (indexRow - 1 > $('#containerLookup').getGridParam().reccount) {
            indexRow = $('#containerLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#containerLookup [id="${$('#containerLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#containerLookup [id="${$('#containerLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#containerLookup').getDataIDs()[indexRow] == undefined) {
              $(`#containerLookup [id="` + $('#containerLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#containerLookup').setSelection($('#containerLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookupcontainer').prev().width())
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
        clearGlobalSearch($('#containerLookup'))
      },
    })

    loadGlobalSearch($('#containerLookup'))
    loadClearFilter($('#containerLookup'))
</script>