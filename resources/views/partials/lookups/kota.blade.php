<table id="kotaLookup" class="lookup-grid"></table>
<div id="kotaLookupPager"></div>

@push('scripts')
<script>
 $('#kotaLookup').jqGrid({
      url: `{{ config('app.api_url') . 'kota' }}`,
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
          label: 'KODE KOTA',
          name: 'kode kota',
          align: 'left',
        },
        {
          label: 'KETERANGAN',
          name: 'keterangan',
          align: 'left'
        },
        {
            label: 'STATUS AKTIF',
            name: 'statusaktif',
            // stype: 'select',
            // searchoptions: {
            //   value: `<?php
            //           $i = 1;

            //           foreach ($data['combo'] as $status) :
            //             echo "$status[param]:$status[parameter]";
            //             if ($i !== count($data['combo'])) {
            //               echo ";";
            //             }
            //             $i++;
            //           endforeach

            //           ?>
            // `,
            //   dataInit: function(element) {
            //     $(element).select2({
            //       width: 'resolve',
            //       theme: "bootstrap4"
            //     });
            //   }
            // },
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
      height: 350,
      rowNum: 10,
      rownumbers: true,
      rownumWidth: 45,
      rowList: [10, 20, 50],
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      page: 1,
      pager: $('#kotaLookupPager'),
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

          if (indexRow - 1 > $('#kotaLookup').getGridParam().reccount) {
            indexRow = $('#kotaLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#kotaLookup [id="${$('#kotaLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#kotaLookup [id="${$('#kotaLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#kotaLookup').getDataIDs()[indexRow] == undefined) {
              $(`#kotaLookup [id="` + $('#kotaLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#kotaLookup').setSelection($('#kotaLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookupkota').prev().width())
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

      },
    })
</script>
