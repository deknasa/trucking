<table id="zonaLookup" class="lookup-grid"></table>
<div id="zonaLookupPager"></div>

<script>
  $('#zonaLookup').jqGrid({
      url: `{{ config('app.api_url') . 'zona' }}`,
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
          label: 'ZONA',
          name: 'zona',
        },
        {
          label: 'KETERANGAN',
          name: 'keterangan',
        },
        {
          label: 'STATUS',
          name: 'statusaktif',
          //   stype: 'select',
          //   searchoptions: {
          //     value: `<?php
                          //             $i = 1;

                          //             foreach ($data['statusaktif'] as $status) :
                          //             echo "$status[param]:$status[parameter]";
                          //             if ($i !== count($data['statusaktif'])) {
                          //                 echo ";";
                          //             }
                          //             $i++;
                          //             endforeach

                          //             
                          ?>
          //         `,
          //   dataInit: function(element) {
          //     $(element).select2({
          //         width: 'resolve',
          //         theme: "bootstrap4"
          //     });
          //     }
          //   },
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
      toolbar: [true, "top"],
      rownumWidth: 45,
      rowList: [10, 20, 50],
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      page: 1,
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
        indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
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

          triggerClick = true

          if (indexRow - 1 > $('#zonaLookup').getGridParam().reccount) {
            indexRow = $('#zonaLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#zonaLookup [id="${$('#zonaLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#zonaLookup [id="${$('#zonaLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#zonaLookup').getDataIDs()[indexRow] == undefined) {
              $(`#zonaLookup [id="` + $('#zonaLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#zonaLookup').setSelection($('#zonaLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookupZona').prev().width())
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
          clearGlobalSearch($('#zonaLookup'))
      },
    })

    loadGlobalSearch($('#zonaLookup'))
    loadClearFilter($('#zonaLookup'))
</script>