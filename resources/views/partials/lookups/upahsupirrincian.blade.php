<table id="upahSupirRincianLookup" class="lookup-grid"></table>

@push('scripts')
<script>
  
  jenisKendaraan = (`{!! $statusjeniskendaraan ?? '' !!}`)
  urlUpahsupir = (jenisKendaraan == 'TANGKI') ? 'upahsupirtangki/get' : 'upahsupirrincian/get';
  $('#upahSupirRincianLookup').jqGrid({
      url: `{{ config('app.api_url') . '${urlUpahsupir}' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      postData: {
        aktif: `{!! $Aktif ?? '' !!}`,
        container_id: `{!! $container_Id ?? '' !!}`,
        statuscontainer_id: `{!! $statuscontainer_Id ?? '' !!}`,
        jenisorder_id: `{!! $jenisorder_Id ?? '' !!}`,
        statuskandang_id: `{!! $statuskandang_Id ?? '' !!}`,
        statusupahzona: `{!! $statusUpahZona ?? '' !!}`,
        tglbukti: `{!! $tglbukti ?? '' !!}`,
        longtrip: `{!! $longtrip ?? '' !!}`,
        dari_id: `{!! $dari_id ?? '' !!}`,
        sampai_id: `{!! $sampai_id ?? '' !!}`,
        statuspenyesuaian: `{!! $statuspenyesuaian ?? '' !!}`,
        statusperalihan: `{!! $statusperalihan ?? '' !!}`,
        statuslangsir: `{!! $statuslangsir ?? '' !!}`,
        nobukti_tripasal: `{!! $nobukti_tripasal ?? '' !!}`
      },
      idPrefix: 'upahSupirRincianLookup',
      colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '50px',
          search: false,
          hidden: true
        },
        {
          label: 'upah id',
          name: 'upah_id',
          search: false,
          hidden: true
        },
        {
          label: 'Kota dari Id',
          name: 'kotadari_id',
          search: false,
          hidden: true
        },
        {
          label: 'Kota Sampai Id',
          name: 'kotasampai_id',
          search: false,
          hidden: true
        },
        {
          label: 'Zona dari Id',
          name: 'zonadari_id',
          search: false,
          hidden: true
        },
        {
          label: 'Zona Sampai Id',
          name: 'zonasampai_id',
          search: false,
          hidden: true
        },
        {
          label: 'Tarif ID',
          name: 'tarif_id',
          search: false,
          hidden: true
        },
        {
          label: 'Tarif',
          name: 'tarif',
          align: 'left'
        },
        {
          label: 'DARI',
          name: 'kotadari',
          align: 'left'
        },
        {
          label: 'TUJUAN',
          name: 'kotasampai',
          align: 'left'
        },
        {
          label: 'PENYESUAIAN',
          name: 'penyesuaian',
          align: 'left'
        },
        {
          label: 'ZONA DARI',
          name: 'zonadari',
          align: 'left'
        },
        {
          label: 'ZONA SAMPAI',
          name: 'zonasampai',
          align: 'left'
        },
        {
          label: 'JARAK',
          name: 'jarak',
          align: 'right',
          formatter: currencyFormat
        },
        {
          label: 'Container',
          name: 'container',
          align: 'left'
        },
        {
          label: 'Status Container',
          name: 'statuscontainer',
          align: 'left'
        },
        {
          label: 'Omset',
          name: 'omset',
          align: 'right',
          formatter: currencyFormat,
        },
        {
          label: 'Nominal Supir',
          name: 'nominalsupir',
          align: 'right',
          formatter: currencyFormat,
        },
        {
          label: 'Nominal Kenek',
          name: 'nominalkenek',
          align: 'right',
          formatter: currencyFormat,
        },
        {
          label: 'Nominal Komisi',
          name: 'nominalkomisi',
          align: 'right',
          formatter: currencyFormat,
        },
        {
          label: 'STATUS AKTIF',
          name: 'statusaktif',
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
                    grp: 'STATUS AKTIF',
                    subgrp: 'STATUS AKTIF'
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
                      id: row.text,
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
            let statusAktif = JSON.parse(value)

            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusAktif.WARNA}; color: ${statusAktif.WARNATULISAN};">
                  <span>${statusAktif.SINGKATAN}</span>
                </div>
              `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusAktif = JSON.parse(rowObject.statusaktif)

            return ` title="${statusAktif.MEMO}"`
          }
        },
        {
          label: 'TGL MULAI BERLAKU',
          name: 'tglmulaiberlaku',
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y"
          }
        },
        {
          label: 'MODIFIED BY',
          name: 'modifiedby',
          align: 'left'
        },
        {
          label: 'CREATED AT',
          name: 'created_at',
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
          align: 'right',
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y H:i:s"
          }
        },
        {
          label: 'Kota Dari Sampai',
          name: 'kotadarisampai',
          align: 'left'
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
      //   pager: $('#upahSupirRincianLookupPager'),
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

        jenisKendaraan = (`{!! $statusjeniskendaraan ?? '' !!}`)
        if(jenisKendaraan == 'TANGKI'){
          $("#upahSupirRincianLookup").jqGrid("hideCol", 'zonadari');
          $("#upahSupirRincianLookup").jqGrid("hideCol", 'zonasampai');
          $("#upahSupirRincianLookup").jqGrid("hideCol", 'container');
          $("#upahSupirRincianLookup").jqGrid("hideCol", 'statuscontainer');
          $("#upahSupirRincianLookup").jqGrid("hideCol", 'nominalsupir');
          $("#upahSupirRincianLookup").jqGrid("hideCol", 'nominalkenek');
          $("#upahSupirRincianLookup").jqGrid("hideCol", 'nominalkomisi');
        }
        setGridLastRequest($(this), jqXHR)
      },
      loadComplete: function(data) {
        changeJqGridRowListText()
        if (detectDeviceType() == 'desktop') {
          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))

          if (indexRow - 1 > $('#upahSupirRincianLookup').getGridParam().reccount) {
            indexRow = $('#upahSupirRincianLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#upahSupirRincianLookup [id="${$('#upahSupirRincianLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#upahSupirRincianLookup [id="${$('#upahSupirRincianLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#upahSupirRincianLookup').getDataIDs()[indexRow] == undefined) {
              $(`#upahSupirRincianLookup [id="` + $('#upahSupirRincianLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#upahSupirRincianLookup').setSelection($('#upahSupirRincianLookup').getDataIDs()[indexRow])
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

        clearGlobalSearch($('#upahSupirRincianLookup'))
      },
    })
    .customPager()
  loadGlobalSearch($('#upahSupirRincianLookup'))
  loadClearFilter($('#upahSupirRincianLookup'))
</script>