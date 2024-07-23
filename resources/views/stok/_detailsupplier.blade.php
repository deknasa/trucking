
@push('scripts')
<script>
  function loadSupplierGrid() {
    let sortnameDetail = 'namasupplier'
    let sortorderDetail = 'asc'
    let totalRecordDetail
    let limitDetail
    let postDataDetail
    let triggerClickDetail
    let indexRowDetail
    let pageDetail = 0;

    $("#detailsupplier").jqGrid({
        datatype: 'local',
        data: [],
        styleUI: 'Bootstrap4',
        iconSet: 'fontAwesome',
        idPrefix: 'detail',
        colModel: [
          {
            label: 'ID',
            name: 'id',
            align: 'right',
            width: '70px',
            search: false,
            hidden: true
          },
          {
            label: 'NAMA',
            name: 'namasupplier',
            width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
            align: 'left',
          },
          {
            label: 'NAMA KONTAK',
            name: 'namakontak',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            align: 'left',
          },
          {
            label: 'ALAMAT',
            name: 'alamat',
            width: (detectDeviceType() == "desktop") ? md_dekstop_3 : md_mobile_3,
            align: 'left'
          },
          {
            label: 'KOTA',
            name: 'kota',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left'
          },
          {
            label: 'KODE POS',
            name: 'kodepos',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            align: 'left'
          },
          {
            label: 'NO TELEPON (1)',
            name: 'notelp1',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            align: 'left'
          },
          {
            label: 'NO TELEPON (2)',
            name: 'notelp2',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            align: 'left'
          },
          {
            label: 'EMAIL',
            name: 'email',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            align: 'left',
          },
          {
            label: 'STATUS AKTIF',
            name: 'statusaktif',
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
            label: 'WEB',
            name: 'web',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
          },
          {
            label: 'NAMA PEMILIK',
            name: 'namapemilik',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            align: 'left',
          },
          {
            label: 'JENIS USAHA',
            name: 'jenisusaha',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            align: 'left',
          },
          {
            label: 'TOP',
            name: 'top',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
            align: 'left',
          },
          {
            label: 'BANK',
            name: 'bank',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
          },
          {
            label: 'REKENING BANK',
            name: 'rekeningbank',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
            align: 'left',
          },
          {
            label: 'NAMA REKENING',
            name: 'namarekening',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
          },
          {
            label: 'JABATAN',
            name: 'jabatan',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
          },
          {
            label: 'STATUS DAFTAR HARGA',
            name: 'statusdaftarharga',
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
                      grp: 'STATUS DAFTAR HARGA',
                      subgrp: 'STATUS DAFTAR HARGA'
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
              let statusDaftarHarga = JSON.parse(value)

              let formattedValue = $(`
                  <div class="badge" style="background-color: ${statusDaftarHarga.WARNA}; color: #fff;">
                    <span>${statusDaftarHarga.SINGKATAN}</span>
                  </div>
                `)

              return formattedValue[0].outerHTML
            },
            cellattr: (rowId, value, rowObject) => {
              let statusDaftarHarga = JSON.parse(rowObject.statusdaftarharga)

              return ` title="${statusDaftarHarga.MEMO}"`
            }
          },
          {
            label: 'KATEGORI USAHA',
            name: 'kategoriusaha',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
            align: 'left',
          },
          {
            label: 'MODIFIED BY',
            name: 'modifiedby',
            width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
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
        shrinkToFit: false,
        height: 350,
        rowNum: 10,
        rownumbers: true,
        footerrow: true,
        userDataOnFooter: true,
        rownumWidth: 45,
        rowList: [10, 20, 50, 0],
        toolbar: [true, "top"],
        sortable: true,
        sortname: sortnameDetail,
        sortorder: sortorderDetail,
        page: pageDetail,
        prmNames: {
          sort: 'sortIndex',
          order: 'sortOrder',
          rows: 'limit'
        },
        viewrecords: true,
        // postData: {
        //   penerimaanstokheader_id: id
        // },
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
          // console.log(id);
          let detail_id = $(`#detailsupplier tr#${id}`).find(`td[aria-describedby="detailsupplier_id"]`).attr('title') ?? '';
          // console.log(nobukti);

          loadSPBData(detail_id)
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

          // if (data.attributes) {
          //   $(this).jqGrid('footerData', 'set', {
          //     nobukti: 'Total:',
          //     total: data.attributes.totalNominal,
          //   }, true)
          // }
          
        }
      })
      .jqGrid('filterToolbar', {
        stringResult: true,
        searchOnEnter: false,
        defaultSearch: 'cn',
        groupOp: 'AND',
        disabledKeys: [17, 33, 34, 35, 36, 37, 38, 39, 40],
        beforeSearch: function() {
          abortGridLastRequest($(this))
          
          clearGlobalSearch($('#detailsupplier'))
        },
      })

      .jqGrid("navGrid", pager, {
        search: false,
        refresh: false,
        add: false,
        edit: false,
        del: false,
      })
      // .customPager({
      //   buttons: [
      //     {
      //       id: 'export_Detail',
      //       title: 'Export Detail',
      //       caption: 'Export',
      //       innerHTML: '<i class="fas fa-file-export"></i> EXPORT Detail',
      //       class: 'btn btn-warning btn-sm mr-1',
      //       onClick: () => {
      //         if (tradoHeader) {
      //           let status = $('#crudForm').find('[name=status]').val();
      //           let statustext = $('#crudForm').find('[name=status] option:selected').text();
      //           let dari = $('#crudForm').find('[name=dari]').val();
      //           let sampai = $('#crudForm').find('[name=sampai]').val();
      //           let trado = tradoHeaderKode
      //           $.ajax({
      //             url: `{{ route('statusolitrado.exportdetail') }}?trado_id=${tradoHeader}&status=${status}&dari=${dari}&sampai=${sampai}&trado=${trado}&statustext=${statustext}`,
      //             type: 'GET',
      //             beforeSend: function(xhr) {
      //               xhr.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`);
      //             },
      //             xhrFields: {
      //               responseType: 'arraybuffer'
      //             },
      //             success: function(response, status, xhr) {
      //               if (xhr.status === 200) {
      //                 if (response !== undefined) {
      //                   var blob = new Blob([response], {
      //                     type: 'cabang/vnd.ms-excel'
      //                   });
      //                   var link = document.createElement('a');
      //                   link.href = window.URL.createObjectURL(blob);
      //                   link.download = 'REMINDER STATUS OLI TRADO DETAIL' + new Date().getTime() + '.xlsx';
      //                   link.click();
      //                 }
      //               }
                    
      //               $('#processingLoader').addClass('d-none')
      //             },
      //             error: function(xhr, status, error) {
      //               $('#processingLoader').addClass('d-none')
      //               showDialog('TIDAK ADA DATA')
      //             }
      //           })    
      //         }

            
      //       }
      //     }, 
      //   ]
        
      // })      
            
    /* Append clear filter button */
    loadClearFilter($('#detailsupplier'))
    
    /* Append global search */
    loadGlobalSearch($('#detailsupplier'))
  }

  function loadSuplierData(stok_id) {
    abortGridLastRequest($('#detailsupplier'))
    // console.log(tradoHeader);
    $('#detailsupplier').setGridParam({
      url: `${apiUrl}supplier/stok/${stok_id}`,
      datatype: "json",
      page:1
    }).trigger('reloadGrid')
  }
  
</script>
@endpush