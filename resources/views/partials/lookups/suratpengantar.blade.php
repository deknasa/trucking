@include('layouts._rangeheaderlookup')
<table id="suratpengantarLookup" class="lookup-grid"></table>
{{-- <div id="suratpengantarLookupPager"></div> --}}

@push('scripts')
<script>
  setRangeLookup()
  tglheader = `{!! $tglbukti ?? '' !!}`;
  if (tglheader != '') {
    $('#rangeHeaderLookup').find('[name=tgldariheaderlookup]').val(tglheader).trigger('change');
    $('#rangeHeaderLookup').find('[name=tglsampaiheaderlookup]').val(tglheader).trigger('change');
  }
  from = `{!! $from ?? '' !!}`;
  if (from == 'ritasi') {
    $('#rangeHeaderLookup').parents('.card').hide()
  }else{
    $('#rangeHeaderLookup').parents('.card').show()
  }
  initDatepicker()
  $(document).on('click', '#btnReloadLookup', function(event) {
    loadDataHeaderLookup('suratpengantar', 'suratpengantarLookup')
  })
  $('#suratpengantarLookup').jqGrid({
      url: `{{ config('app.api_url') . 'suratpengantar' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      postData: {
        tgldari: $('#tgldariheaderlookup').val(),
        tglsampai: $('#tglsampaiheaderlookup').val(),
        pengeluarantruckingheader: `{!! $pengeluarantruckingheader ?? '' !!}`,
        jenisorder_id: `{!! $jenisorder_id ?? '' !!}`,
        tglabsensi: `{!! $tglabsensi ?? '' !!}`,
        trado_id: `{!! $trado_id ?? '' !!}`,
        supir_id: `{!! $supir_id ?? '' !!}`,
        container_id: `{!! $container_id ?? '' !!}`,
        agen_id: `{!! $agen_id ?? '' !!}`,
        upah_id: `{!! $upah_id ?? '' !!}`,
        pelanggan_id: `{!! $pelanggan_id ?? '' !!}`,
        gandengan_id: `{!! $gandengan_id ?? '' !!}`,
        dari_id: `{!! $dari_id ?? '' !!}`,
        sampai_id: `{!! $sampai_id ?? '' !!}`,
        gudangsama: `{!! $gudangsama ?? '' !!}`,
        longtrip: `{!! $longtrip ?? '' !!}`,
        isGudangSama: `{!! $isGudangSama ?? '' !!}`,
        idTrip: `{!! $idTrip ?? '' !!}`,
        from: `{!! $from ?? '' !!}`,
      },
      idPrefix: 'suratpengantarLookup',
      colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '50px',
          search: false,
          hidden: true
        },

        {
          label: 'NO BUKTI',
          name: 'nobukti',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
        },
        {
          label: 'JOB TRUCKING',
          name: 'jobtrucking',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
        },
        {
          label: 'TGL BUKTI',
          name: 'tglbukti',
          formatter: "date",
          width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y"
          }
        },
        {
          label: 'SHIPPER',
          name: 'pelanggan_id',
          width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1
        },
        {
          label: 'PELANGGANID',
          name: 'pelangganid',
          hidden: true,
          search: false
        },
        {
          label: 'JENIS ORDER',
          name: 'jenisorder_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3
        },
        {
          label: 'FULL/EMPTY',
          name: 'statuscontainer_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4
        },
        {
          label: 'DARI',
          name: 'dari_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4
        },
        {
          label: 'SAMPAI',
          name: 'sampai_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4
        },
        {
          label: 'SAMPAIID',
          name: 'sampaiid',
          hidden: true,
          search: false
        },
        {
          label: 'CUSTOMER',
          name: 'agen_id',
          width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2
        },
        {
          label: 'CONTAINER',
          name: 'container_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3
        },
        {
          label: 'NO CONT',
          name: 'nocont',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4
        },
        {
          label: 'NO CONT2',
          name: 'nocont2',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4
        },
        {
          label: 'NO POLISI',
          name: 'trado_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3
        },
        {
          label: 'SUPIR',
          name: 'supir_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4
        },
        {
          label: 'GANDENGAN',
          name: 'gandengan_id',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3
        },
        {
          label: 'TRADO ID',
          name: 'tradolookup',
          hidden: true,
          search: false
        },
        {
          label: 'SUPIR ID',
          name: 'supirlookup',
          hidden: true,
          search: false
        },
        {
          label: 'GANDENGAN ID',
          name: 'gandenganid',
          hidden: true,
          search: false
        },
        {
          label: 'KETERANGAN',
          name: 'keterangan',
          width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1
        },
        {
          label: 'NOJOB',
          name: 'nojob',
          width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1
        },
        {
          label: 'NOJOB2',
          name: 'nojob2',
          width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1
        },
        {
          label: 'STATUSLONGTRIP',
          name: 'statuslongtrip',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
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
                    grp: 'STATUS LONGTRIP',
                    subgrp: 'STATUS LONGTRIP'
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
            let statusLongTrip = JSON.parse(value)
            if (!statusLongTrip) {
              return ''
            }
            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusLongTrip.WARNA}; color: #fff;">
                  <span>${statusLongTrip.SINGKATAN}</span>
                </div>
              `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusLongTrip = JSON.parse(rowObject.statuslongtrip)
            if (!statusLongTrip) {
              return ` title=""`
            }
            return ` title="${statusLongTrip.MEMO}"`
          }
        },
        {
          label: 'GAJI SUPIR',
          name: 'gajisupir',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          formatter: 'currency',
          formatoptions: {
            decimalSeparator: ',',
            thousandsSeparator: '.'
          }
        },
        // {
        //   label: 'GAJI KENEK',
        //   name: 'gajikenek',
        //   width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
        //   formatter: 'currency',
        //   formatoptions: {
        //     decimalSeparator: ',',
        //     thousandsSeparator: '.'
        //   }
        // },
        {
          label: 'STATUS PERALIHAN',
          name: 'statusperalihan',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,

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
                    grp: 'STATUS PERALIHAN',
                    subgrp: 'STATUS PERALIHAN'
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
            let statusPeralihan = JSON.parse(value)
            if (!statusPeralihan) {
              return ''
            }
            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusPeralihan.WARNA}; color: #fff;">
                  <span>${statusPeralihan.SINGKATAN}</span>
                </div>
              `)

            return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            let statusPeralihan = JSON.parse(rowObject.statusperalihan)
            if (!statusPeralihan) {
              return ` title=""`
            }
            return ` title="${statusPeralihan.MEMO}"`
          }
        },
        {
          label: 'LOKASI BONGKAR MUAT',
          name: 'tarif_id',
          width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,

        },
        {
          label: 'NOMINAL PERALIHAN',
          name: 'nominalperalihan',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          formatter: 'currency',
          formatoptions: {
            decimalSeparator: ',',
            thousandsSeparator: '.'
          }
        },
        {
          label: 'NO SP',
          name: 'nosp',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
        },
        {
          label: 'TGL SP',
          name: 'tglsp',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
        },
        {
          label: 'MODIFIED BY',
          name: 'modifiedby',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
        },
        {
          label: 'CREATED AT',
          name: 'created_at',
          align: 'right',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
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
          width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,

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
      toolbar: [true, "top"],
      rownumWidth: 45,
      rowList: [10, 20, 50, 0],
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      page: 1,
      // pager: $('#suratpengantarLookupPager'),
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

          if (indexRow - 1 > $('#suratpengantarLookup').getGridParam().reccount) {
            indexRow = $('#suratpengantarLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#suratpengantarLookup [id="${$('#suratpengantarLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#suratpengantarLookup [id="${$('#suratpengantarLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#suratpengantarLookup').getDataIDs()[indexRow] == undefined) {
              $(`#suratpengantarLookup [id="` + $('#suratpengantarLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#suratpengantarLookup').setSelection($('#suratpengantarLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookupsuratpengantar').prev().width())
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

        clearGlobalSearch($('#suratpengantarLookup'))
      },
    })
    .customPager()
  loadGlobalSearch($('#suratpengantarLookup'))
  loadClearFilter($('#suratpengantarLookup'))
</script>