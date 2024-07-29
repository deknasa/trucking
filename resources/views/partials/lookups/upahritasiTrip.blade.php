<table id="upahRitasiTripLookup" class="lookup-grid"></table>
{{-- <div id="upahRitasiTripLookupPager"></div> --}}

@push('scripts')
<script>
 $('#upahRitasiTripLookup').jqGrid({
      url: `{{ config('app.api_url') . 'upahritasi/triplookup' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      postData: {
        aktif: `{!! $Aktif ?? '' !!}`,
        isParent: `{!! $isParent ?? '' !!}`,
      },
      idPrefix: 'upahRitasiTripLookup',
      colModel: [
         {
            label: 'jenis ritasi',
            name: 'jenisritasi_id',
            align: 'left',
            width: '50px',
            search: false,
            hidden: true
          },
         {
            label: 'jenisritasi',
            name: 'jenisritasi',
            align: 'left',
            width:  (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
            search: true,
          },
         {
            label: 'ritasidari_id',
            name: 'ritasidari_id',
            align: 'left',
            search: false,
            hidden: true
          },
         {
            label: 'dari',
            name: 'ritasidari',
            align: 'left',
            width:  (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
            search: true,
          },
         {
            label: 'ritasike',
            name: 'ritasike_id',
            align: 'left',
            search: false,
            hidden: true
          },
         {
            label: 'ke',
            name: 'ritasike',
            align: 'left',
            width:  (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
            search: true,
          },

        ],
      autowidth: true,
      responsive: true,
      shrinkToFit: false,
      height: 350,
      rowNum: 10,
      rownumbers: true,
      rownumWidth: 45,
      rowList: [10, 20, 50, 0],
      toolbar: [true, "top"],
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      page: 1,
      // pager: $('#upahRitasiTripLookupPager'),
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

          if (indexRow - 1 > $('#upahRitasiTripLookup').getGridParam().reccount) {
            indexRow = $('#upahRitasiTripLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#upahRitasiTripLookup [id="${$('#upahRitasiTripLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#upahRitasiTripLookup [id="${$('#upahRitasiTripLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#upahRitasiTripLookup').getDataIDs()[indexRow] == undefined) {
              $(`#upahRitasiTripLookup [id="` + $('#upahRitasiTripLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#upahRitasiTripLookup').setSelection($('#upahRitasiTripLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookuptarif').prev().width())
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
          
          clearGlobalSearch($('#upahRitasiTripLookup'))
      },
    })
    .customPager()
    loadGlobalSearch($('#upahRitasiTripLookup'))
    loadClearFilter($('#upahRitasiTripLookup'))
</script>
