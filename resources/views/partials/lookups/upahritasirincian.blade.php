<table id="upahRitasiRincianLookup" class="lookup-grid"></table>
{{-- <div id="upahRitasiRincianLookupPager"></div> --}}

@push('scripts')
<script>
  $('#upahRitasiRincianLookup').jqGrid({
      url: `{{ config('app.api_url') . 'upahritasirincian/get' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      idPrefix: 'upahRitasiRincianLookup',  
      postData: {
        aktif: `{!! $Aktif ?? '' !!}`,
        kotadari_id: `{!! $kotadari_id ?? '' !!}`,
        kotasampai_id: `{!! $kotasampai_id ?? '' !!}`,
        pilihkota_id: `{!! $pilihkota_id ?? '' !!}`,
        DataRitasi: `{!! $DataRitasi ?? '' !!}`,
        ritasidarike: `{!! $RitasiDariKe ?? '' !!}`,
        upahSupirDariKe: `{!! $upahSupirDariKe ?? '' !!}`,
        upahSupirKotaDari: `{!! $upahSupirKotaDari ?? '' !!}`,
      }, 
      colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '50px',
          search: false,
          hidden: true
        },
        {
          label: 'KOTA',
          name: 'kodekota',
          align: 'left',
          width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
        },
        {
          label: 'KETERANGAN',
          name: 'keterangan',
          align: 'left',
          width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
        },
        {
          label: 'MODIFIED BY',
          name: 'modifiedby',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
          align: 'left'
        },
        {
          label: 'CREATED AT',
          name: 'created_at',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          align: 'right',
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y H:i:s"
          }
        },
        {
          label: 'UPDATED AT',
          name: 'updated_at',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
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
      // pager: $('#upahRitasiRincianLookupPager'),
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

          if (indexRow - 1 > $('#upahRitasiRincianLookup').getGridParam().reccount) {
            indexRow = $('#upahRitasiRincianLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#upahRitasiRincianLookup [id="${$('#upahRitasiRincianLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#upahRitasiRincianLookup [id="${$('#upahRitasiRincianLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#upahRitasiRincianLookup').getDataIDs()[indexRow] == undefined) {
              $(`#upahRitasiRincianLookup [id="` + $('#upahRitasiRincianLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#upahRitasiRincianLookup').setSelection($('#upahRitasiRincianLookup').getDataIDs()[indexRow])
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

        clearGlobalSearch($('#upahRitasiRincianLookup'))
      },
    })
    .customPager()
  loadGlobalSearch($('#upahRitasiRincianLookup'))
  loadClearFilter($('#upahRitasiRincianLookup'))
</script>