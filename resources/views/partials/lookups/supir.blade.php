<table id="supirLookup" class="lookup-grid"></table>
{{-- <div id="supirLookupPager"></div> --}}

@push('scripts')
<script>
  $('#supirLookup').jqGrid({
      url: `{{ config('app.api_url') . 'supir' }}`,
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      postData: {
        aktif: `{!! $Aktif ?? '' !!}`,
        absen: `{!! $AbsensiId ?? '' !!}`,
        supir_id: `{!! $supir_id ?? '' !!}`,
        tgltrip: `{!! $tgltrip ?? '' !!}`,
        fromSupirSerap: `{!! $fromSupirSerap ?? '' !!}`,
        trado_id: `{!! $trado_id ?? '' !!}`,
        from: `{!! $from ?? '' !!}`,
      },
      idPrefix: 'supirLookup',
      colModel: [{
          label: 'ID',
          name: 'id',
          align: 'right',
          width: '70px',
          search: false,
          hidden: true
        },
        {
          label: 'STATUS APPROVAL',
          name: 'statusapproval',
          width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
          align: 'left',
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
                    grp: 'STATUS Approval',
                    subgrp: 'STATUS Approval'
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
                      id: 'ALL',
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
            if (!value) {
              return ''
            }
            let statusApproval = JSON.parse(value)
            
            if (statusApproval == null) {
              return '';
            }
            
            let formattedValue = $(`
            <div class="badge" style="background-color: ${statusApproval.WARNA}; color: #fff;">
              <span>${statusApproval.SINGKATAN}</span>
              </div>
              `)
              
              return formattedValue[0].outerHTML
          },
          cellattr: (rowId, value, rowObject) => {
            if (!rowObject.statusapproval) {
              return ''
            }
            let statusApproval = JSON.parse(rowObject.statusapproval)
            if (statusApproval == null) {
              return '';
            }
            return ` title="${statusApproval.MEMO}"`
          }
        },
        {
          label: 'NAMA',
          name: 'namasupir',
          align: 'left',
        },
        {
          label: 'NAMA ALIAS',
          name: 'namaalias',
          align: 'left',
        },
        {
          label: 'TGL LAHIR',
          name: 'tgllahir',
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y"
          },
          hidden: true,
          search: false
        },
        {
          label: 'ALAMAT',
          name: 'alamat',
          align: 'left',
          hidden: true,
          search: false
        },
        {
          label: 'KOTA',
          name: 'kota',
          align: 'left',
          hidden: true,
          search: false
        },
        {
          label: 'NO TELEPON',
          name: 'telp',
          align: 'left',
          hidden: true,
          search: false
        },
        {
          label: 'NOMINAL DEPOSIT',
          name: 'nominaldepositsa',
          hidden: true,
          search: false
        },
        {
          label: 'NOM PINJ SALDO AWAL',
          name: 'nominalpinjamansaldoawal',
          hidden: true,
          search: false
        },
        {
          label: 'SUPIR LAMA',
          name: 'supirold_id',
          hidden: true,
          search: false
        },
        {
          label: 'SIM',
          name: 'nosim',
          hidden: true,
          search: false
        },
        {
          label: 'TGL EXP SIM',
          name: 'tglexpsim',
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y"
          },
          hidden: true,
          search: false
        },
        {
          label: 'TGL TERBIT SIM',
          name: 'tglterbitsim',
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y"
          },
          hidden: true,
          search: false
        },
        {
          label: 'KETERANGAN',
          name: 'keterangan',
          hidden: true,
          search: false
        },
        {
          label: 'KTP',
          name: 'noktp',
          hidden: true,
          search: false
        },
        {
          label: 'KK',
          name: 'nokk',
          hidden: true,
          search: false
        },
        // {
        //   label: 'STATUS ADA UPDATE GBR',
        //   name: 'statusadaupdategambar',
        //   stype: 'select',
        //   searchoptions: {
        //     dataInit: function(element) {
        //       $(element).select2({
        //         width: 'resolve',
        //         theme: "bootstrap4",
        //         ajax: {
        //           url: `${apiUrl}parameter/combo`,
        //           dataType: 'JSON',
        //           headers: {
        //             Authorization: `Bearer ${accessToken}`
        //           },
        //           data: {
        //             grp: 'STATUS ADA UPDATE GAMBAR',
        //             subgrp: 'STATUS ADA UPDATE GAMBAR'
        //           },
        //           beforeSend: () => {
        //             // clear options
        //             $(element).data('select2').$results.children().filter((index, element) => {
        //               // clear options except index 0, which
        //               // is the "searching..." label
        //               if (index > 0) {
        //                 element.remove()
        //               }
        //             })
        //           },
        //           processResults: (response) => {
        //             let formattedResponse = response.data.map(row => ({
        //               id: row.text,
        //               text: row.text
        //             }));

        //             formattedResponse.unshift({
        //               id: '',
        //               text: 'ALL'
        //             });

        //             return {
        //               results: formattedResponse
        //             };
        //           },
        //         }
        //       });
        //     }
        //   },
        //   formatter: (value, options, rowData) => {
        //     let statusAdaUpdateGambar = JSON.parse(value)

        //     let formattedValue = $(`
        //         <div class="badge" style="background-color: ${statusAdaUpdateGambar.WARNA}; color: #fff;">
        //           <span>${statusAdaUpdateGambar.SINGKATAN}</span>
        //         </div>
        //       `)

        //     return formattedValue[0].outerHTML
        //   },
        //   cellattr: (rowId, value, rowObject) => {
        //     let statusAdaUpdateGambar = JSON.parse(rowObject.statusadaupdategambar)

        //     return ` title="${statusAdaUpdateGambar.MEMO}"`
        //   }
        // },
        // {
        //   label: 'STATUS LUAR KOTA',
        //   name: 'statusluarkota',
        //   stype: 'select',
        //   searchoptions: {
        //     dataInit: function(element) {
        //       $(element).select2({
        //         width: 'resolve',
        //         theme: "bootstrap4",
        //         ajax: {
        //           url: `${apiUrl}parameter/combo`,
        //           dataType: 'JSON',
        //           headers: {
        //             Authorization: `Bearer ${accessToken}`
        //           },
        //           data: {
        //             grp: 'STATUS LUAR KOTA',
        //             subgrp: 'STATUS LUAR KOTA'
        //           },
        //           beforeSend: () => {
        //             // clear options
        //             $(element).data('select2').$results.children().filter((index, element) => {
        //               // clear options except index 0, which
        //               // is the "searching..." label
        //               if (index > 0) {
        //                 element.remove()
        //               }
        //             })
        //           },
        //           processResults: (response) => {
        //             let formattedResponse = response.data.map(row => ({
        //               id: row.text,
        //               text: row.text
        //             }));

        //             formattedResponse.unshift({
        //               id: '',
        //               text: 'ALL'
        //             });

        //             return {
        //               results: formattedResponse
        //             };
        //           },
        //         }
        //       });
        //     }
        //   },
        //   formatter: (value, options, rowData) => {
        //     let statusLuarKota = JSON.parse(value)

        //     let formattedValue = $(`
        //         <div class="badge" style="background-color: ${statusLuarKota.WARNA}; color: #fff;">
        //           <span>${statusLuarKota.SINGKATAN}</span>
        //         </div>
        //       `)

        //     return formattedValue[0].outerHTML
        //   },
        //   cellattr: (rowId, value, rowObject) => {
        //     let statusLuarKota = JSON.parse(rowObject.statusluarkota)

        //     return ` title="${statusLuarKota.MEMO}"`
        //   }
        // },
        // {
        //   label: 'ZONA TERTENTU',
        //   name: 'statuszonatertentu',
        //   stype: 'select',
        //   searchoptions: {
        //     dataInit: function(element) {
        //       $(element).select2({
        //         width: 'resolve',
        //         theme: "bootstrap4",
        //         ajax: {
        //           url: `${apiUrl}parameter/combo`,
        //           dataType: 'JSON',
        //           headers: {
        //             Authorization: `Bearer ${accessToken}`
        //           },
        //           data: {
        //             grp: 'ZONA TERTENTU',
        //             subgrp: 'ZONA TERTENTU'
        //           },
        //           beforeSend: () => {
        //             // clear options
        //             $(element).data('select2').$results.children().filter((index, element) => {
        //               // clear options except index 0, which
        //               // is the "searching..." label
        //               if (index > 0) {
        //                 element.remove()
        //               }
        //             })
        //           },
        //           processResults: (response) => {
        //             let formattedResponse = response.data.map(row => ({
        //               id: row.text,
        //               text: row.text
        //             }));

        //             formattedResponse.unshift({
        //               id: '',
        //               text: 'ALL'
        //             });

        //             return {
        //               results: formattedResponse
        //             };
        //           },
        //         }
        //       });
        //     }
        //   },
        //   formatter: (value, options, rowData) => {
        //     let statusZonaTertentu = JSON.parse(value)

        //     let formattedValue = $(`
        //         <div class="badge" style="background-color: ${statusZonaTertentu.WARNA}; color: #fff;">
        //           <span>${statusZonaTertentu.SINGKATAN}</span>
        //         </div>
        //       `)

        //     return formattedValue[0].outerHTML
        //   },
        //   cellattr: (rowId, value, rowObject) => {
        //     let statusZonaTertentu = JSON.parse(rowObject.statuszonatertentu)

        //     return ` title="${statusZonaTertentu.MEMO}"`
        //   }
        // },
        {
          label: 'ZONA',
          name: 'zona_id',
          hidden: true,
          search: false
        },
        {
          label: 'TGL BERHENTI SUPIR',
          name: 'tglberhentisupir',
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y"
          },
          hidden: true,
          search: false
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
      // pager: $('#supirLookupPager'),
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

          if (indexRow - 1 > $('#supirLookup').getGridParam().reccount) {
            indexRow = $('#supirLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#supirLookup [id="${$('#supirLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#supirLookup [id="${$('#supirLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#supirLookup').getDataIDs()[indexRow] == undefined) {
              $(`#supirLookup [id="` + $('#supirLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#supirLookup').setSelection($('#supirLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookupSupir').prev().width())
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

        clearGlobalSearch($('#supirLookup'))
      },
    }).customPager()

  loadGlobalSearch($('#supirLookup'))
  loadClearFilter($('#supirLookup'))
</script>