<table id="tarifLookup" class="lookup-grid"></table>
<div id="tarifLookupPager"></div>

@push('scripts')
<script>
 $('#tarifLookup').jqGrid({
      url: `{{ config('app.api_url') . 'tarif' }}`,
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
          label: 'TUJUAN',
          name: 'tujuan',
        },
        {
          label: 'CONTAINER',
          name: 'container_id',
        },
        {
          label: 'NOMINAL',
          name: 'nominal',
          align: 'right',
          formatter: 'currency',
          formatoptions: {
              decimalSeparator: ',',
              thousandsSeparator: '.'
          }
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
          label: 'TUJUAN ASAL',
          name: 'tujuanasal',
        },
        {
          label: 'SISTEM TON',
          name: 'sistemton',
        },
        {
          label: 'KOTA',
          name: 'kota_id',
        },
        {
          label: 'ZONA',
          name: 'zona_id',
        },
        {
          label: 'NOMINAL TON',
          name: 'nominalton',
          align: 'right',
          formatter: 'currency',
          formatoptions: {
              decimalSeparator: ',',
              thousandsSeparator: '.'
          }
        },
        {
          label: 'TGL BERLAKU',
          name: 'tglberlaku',
          formatter: "date",
          formatoptions: { srcformat: "ISO8601Long", newformat: "d-m-Y" }
        },
        {
          label: 'STATUS PENYESUAIAN HARGA',
          name: 'statuspenyesuaianharga',
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
      pager: $('#tarifLookupPager'),
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

          if (indexRow - 1 > $('#tarifLookup').getGridParam().reccount) {
            indexRow = $('#tarifLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#tarifLookup [id="${$('#tarifLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#tarifLookup [id="${$('#tarifLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#tarifLookup').getDataIDs()[indexRow] == undefined) {
              $(`#tarifLookup [id="` + $('#tarifLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#tarifLookup').setSelection($('#tarifLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookuptarif').prev().width())
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
        clearGlobalSearch($('#tarifLookup'))
      },
    })

  loadGlobalSearch($('#tarifLookup'))
  loadClearFilter($('#tarifLookup'))
</script>
