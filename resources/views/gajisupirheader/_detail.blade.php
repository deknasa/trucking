@push('scripts')
<script>
  function loadDetailGrid(id) {
    let sortnameDetail = 'suratpengantar_nobukti'
    let sortorderDetail = 'asc'
    let totalRecordDetail
    let limitDetail
    let postDataDetail
    let triggerClickDetail
    let indexRowDetail
    let pageDetail = 0;

    $("#detail").jqGrid({
        datatype: 'local',
        data: [],
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        idPrefix: 'detail',
        colModel: [
          
          {
            label: 'STS. APP. TRP',
            name: 'statusapprovaltrip',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            stype: 'select',
            hidden: (accessCabang == 'MEDAN') ? false : true,
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['comboapproval'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['comboapproval'])) {
                          echo ";";
                        }
                        $i++;
                      endforeach

                      ?>
            `,
              dataInit: function(element) {
                $(element).select2({
                  width: 'resolve',
                  theme: "bootstrap4"
                });
              }
            },
            formatter: (value, options, rowData) => {
              let statusApproval = JSON.parse(value)
              if (!statusApproval) {
                return ''
              }
              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusApproval.WARNA}; color: #fff;">
                  <span>${statusApproval.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusApproval = JSON.parse(rowObject.statusapprovaltrip)
              if (!statusApproval) {
                return ` title=""`
              }
              return ` title="${statusApproval.MEMO}"`
            }
          },
          {
            label: 'STS. APP. RTT',
            name: 'statusapprovalritasi',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            stype: 'select',
            hidden: (accessCabang == 'MEDAN') ? false : true,
            searchoptions: {
              value: `<?php
                      $i = 1;

                      foreach ($data['comboapproval'] as $status) :
                        echo "$status[param]:$status[parameter]";
                        if ($i !== count($data['comboapproval'])) {
                          echo ";";
                        }
                        $i++;
                      endforeach

                      ?>
            `,
              dataInit: function(element) {
                $(element).select2({
                  width: 'resolve',
                  theme: "bootstrap4"
                });
              }
            },
            formatter: (value, options, rowData) => {
              let statusApproval = JSON.parse(value)
              if (!statusApproval) {
                return ''
              }
              let formattedValue = $(`
                <div class="badge" style="background-color: ${statusApproval.WARNA}; color: #fff;">
                  <span>${statusApproval.SINGKATAN}</span>
                </div>
              `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusApproval = JSON.parse(rowObject.statusapprovalritasi)
              if (!statusApproval) {
                return ` title=""`
              }
              return ` title="${statusApproval.MEMO}"`
            }
          },{
            label: 'NO TRIP',
            name: 'suratpengantar_nobukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            formatter: (value, options, rowData) => {
              if ((value == null) || (value == '')) {
                return '';
              }
              let tgldari = rowData.tgldariheadersuratpengantar
              let tglsampai = rowData.tglsampaiheadersuratpengantar
              let url = "{{route('suratpengantar.index')}}"
              let formattedValue = $(`
              <a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}&nobukti=${value}" class="link-color" target="_blank">${value}</a>
             `)
             if (value =="Total:") {
              return value;
             }

              return formattedValue[0].outerHTML
            },
          },
          {
            label: 'TGL BON',
            name: 'tglsp',
            align: 'left',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            formatter: "date",
            formatoptions: {
              srcformat: "ISO8601Long",
              newformat: "d-m-Y"
            }
          },

          {
            label: 'NO POL',
            name: 'trado',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'DARI',
            name: 'dari',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'TUJUAN',
            name: 'sampai',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'NO CONT',
            name: 'nocont',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
          },
          {
            label: 'NO SP',
            name: 'nosp',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          },
          {
            label: 'U. MAKAN BERJENJANG',
            name: 'uangmakanberjenjang',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'GAJI SUPIR',
            name: 'gajisupir',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'GAJI KENEK',
            name: 'gajikenek',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'KOMISI SUPIR',
            name: 'komisisupir',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'right',
            formatter: currencyFormat,
          },
          {
            label: 'TOL SUPIR',
            name: 'tolsupir',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            formatter: currencyFormat,
            align: "right",
          },
          {
            label: 'NO BUKTI RITASI',
            name: 'ritasi_nobukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
            formatter: (value, options, rowData) => {
              if ((value == null) || (value == '')) {
                return '';
              }
              let tgldari = rowData.tgldariheaderritasi
              let tglsampai = rowData.tglsampaiheaderritasi
              let url = "{{route('ritasi.index')}}"
              let formattedValue = $(`<a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}&nobukti=${value}" class="link-color" target="_blank">${value}</a>`)
              return formattedValue[0].outerHTML
            },
          },
          {
            label: 'UPAH RITASI',
            name: 'upahritasi',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            formatter: currencyFormat,
            align: "right",
          },
          {
            label: 'STATUS RITASI',
            name: 'statusritasi',
            width: (detectDeviceType() == "desktop") ? md_dekstop_3 : md_mobile_3,
            align: 'left'
          },
          {
            label: 'BIAYA EXTRA (TRIP)',
            name: 'biayaextra',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            formatter: currencyFormat,
            align: "right",
          },
          {
            label: 'KET. BIAYA EXTRA (TRIP)',
            name: 'keteranganbiayatambahan',
            width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
            align: 'left',
            width: '300px'
          },
          {
            label: 'NO BUKTI B. EXT. SUPIR',
            name: 'biayaextrasupir_nobukti',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
            formatter: (value, options, rowData) => {
              if ((value == null) || (value == '')) {
                return '';
              }
              let tgldari = rowData.tgldariheaderbiayaextrasupir
              let tglsampai = rowData.tglsampaiheaderbiayaextrasupir
              let url = "{{route('biayaextrasupirheader.index')}}"
              let formattedValue = $(`<a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}&nobukti=${value}" class="link-color" target="_blank">${value}</a>`)
              return formattedValue[0].outerHTML
            },
          },
          {
            label: 'NOMINAL B. EXT SUPIR',
            name: 'biayaextrasupir_nominal',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            formatter: currencyFormat,
            align: "right",
          },
          {
            label: 'KET. B. EXT SUPIR',
            name: 'biayaextrasupir_keterangan',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
            align: 'left'
          },
          {
            label: 'TOTAL',
            name: 'total',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            formatter: currencyFormat,
            align: "right",
          },
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
        sortname: sortnameDetail,
        sortorder: sortorderDetail,
        page: pageDetail,
        viewrecords: true,
        postData: {
          gajisupir_id: id
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
        loadBeforeSend: function(jqXHR) {
          jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)

          setGridLastRequest($(this), jqXHR)
        },
        onSelectRow: function(id) {
          activeGrid = $(this)
        },
        loadComplete: function(data) {
          changeJqGridRowListText()

          $(document).unbind('keydown')
          setCustomBindKeys($(this))
          initResize($(this))

          /* Set global variables */
          sortnameDetail = $(this).jqGrid("getGridParam", "sortname")
          sortorderDetail = $(this).jqGrid("getGridParam", "sortorder")
          totalRecordDetail = $(this).getGridParam("records")
          limitDetail = $(this).jqGrid('getGridParam', 'postData').limit
          postDataDetail = $(this).jqGrid('getGridParam', 'postData')
          triggerClick = false

          $('.clearsearchclass').click(function() {
            clearColumnSearch($(this))
          })

          if (indexRowDetail > $(this).getDataIDs().length - 1) {
            indexRowDetail = $(this).getDataIDs().length - 1;
          }


          setHighlight($(this))

          if (data.attributes) {
            $(this).jqGrid('footerData', 'set', {
              suratpengantar_nobukti: 'Total:',
              gajisupir: data.attributes.totalGajiSupir,
              gajikenek: data.attributes.totalGajiKenek,
              komisisupir: data.attributes.totalKomisiSupir,
              upahritasi: data.attributes.totalUpahRitasi,
              tolsupir: data.attributes.totalTolSupir,
              biayaextra: data.attributes.totalBiayaExtra,
              uangmakanberjenjang: data.attributes.totalUangMakanBerjenjang,
              total: data.attributes.total,
              biayaextrasupir_nominal: data.attributes.totalBiayaExtraSupirNominal,
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
          abortGridLastRequest($(this))

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
    abortGridLastRequest($('#detail'))

    $('#detail').setGridParam({
      url: `${apiUrl}gajisupirdetail`,
      datatype: "json",
      postData: {
        gajisupir_id: id
      },
      page: 1
    }).trigger('reloadGrid')
  }
</script>
@endpush