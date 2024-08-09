<table id="tradoLookup" class="lookup-grid"></table>
{{-- <div id="tradoLookupPager"></div> --}}

@push('scripts')
<script>
  $('#tradoLookup').jqGrid({
      url: `{!! $url ?? config('app.api_url')  !!}` + 'trado',
      mtype: "GET",
      styleUI: 'Bootstrap4',
      iconSet: 'fontAwesome',
      datatype: "json",
      postData: {
        aktif: `{!! $Aktif ?? '' !!}`,
        trado_id: `{!! $trado_id ?? '' !!}`,
        cabang: `{!! $cabang ?? '' !!}`,
        penerimaanstok_id: `{!! $penerimaanstok_id ?? '' !!}`,
        supirserap: `{!! $supirserap ?? '' !!}`,
        tglabsensi: `{!! $tglabsensi ?? '' !!}`,
        tradodarike: `{!! $tradodarike ?? '' !!}`,
        tradodari_id: `{!! $tradodari_id ?? '' !!}`,
        tradoke_id: `{!! $tradoke_id ?? '' !!}`,
      },
      idPrefix: 'tradoLookup',
      colModel: [{
          label: 'ID',
          name: 'id',
          width: '50px',
          search: false,
          hidden: true
        },
        {
          label: 'KETERANGAN',
          name: 'keterangan',
        },
        {
          label: 'NO POLISI',
          name: 'kodetrado',
        },
        // {
        //   label: 'STATUS AKTIF',
        //   name: 'statusaktif',
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
        //             grp: 'STATUS AKTIF',
        //             subgrp: 'STATUS AKTIF'
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
        //     let statusAktif = JSON.parse(value)

        //     let formattedValue = $(`
        //         <div class="badge" style="background-color: ${statusAktif.WARNA}; color: ${statusAktif.WARNATULISAN};">
        //           <span>${statusAktif.SINGKATAN}</span>
        //         </div>
        //       `)

        //     return formattedValue[0].outerHTML
        //   },
        //   cellattr: (rowId, value, rowObject) => {
        //     let statusAktif = JSON.parse(rowObject.statusaktif)

        //     return ` title="${statusAktif.MEMO}"`
        //   }
        // },
        {
          label: 'KM AWAL',
          name: 'kmawal',
          align: 'right',
          formatter: currencyFormat,
        },
        {
          label: 'KM GANTI OLI AKHIR',
          name: 'kmakhirgantioli',
          align: 'right',
          formatter: currencyFormat,
        },
        // {
        //   label: 'TGL AKHIR GANTI OLI',
        //   name: 'tglakhirgantioli',
        //   align: 'left',
        //   formatter: "date",
        //   formatoptions: {
        //     srcformat: "ISO8601Long",
        //     newformat: "d-m-Y"
        //   }
        // },
        {
          label: 'MEREK',
          name: 'merek',
        },
        {
          label: 'NO RANGKA',
          name: 'norangka',
        },
        {
          label: 'NO MESIN',
          name: 'nomesin',
        },
        {
          label: 'NAMA',
          name: 'nama',
        },
        {
          label: 'NO STNK',
          name: 'nostnk',
        },
        {
          label: 'ALAMAT STNK',
          name: 'alamatstnk',
        },
        {
          label: 'MODIFIED BY',
          name: 'modifiedby',
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
          label: 'TGL SERVICE OPNAME',
          name: 'tglserviceopname',
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y"
          }
        },
        // {
        //   label: 'STATUS STANDARISASI',
        //   name: 'statusstandarisasi',
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
        //             grp: 'STATUS STANDARISASI',
        //             subgrp: 'STATUS STANDARISASI'
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
        //     let statusStandarisasi = JSON.parse(value)

        //     let formattedValue = $(`
        //         <div class="badge" style="background-color: ${statusStandarisasi.WARNA}; color: #fff;">
        //           <span>${statusStandarisasi.SINGKATAN}</span>
        //         </div>
        //       `)

        //     return formattedValue[0].outerHTML
        //   },
        //   cellattr: (rowId, value, rowObject) => {
        //     let statusStandarisasi = JSON.parse(rowObject.statusstandarisasi)

        //     return ` title="${statusStandarisasi.MEMO}"`
        //   }
        // },
        // {
        //   label: 'KET PROGRESS STANDARISASI',
        //   name: 'keteranganprogressstandarisasi',
        // },
        // {
        //   label: 'JENIS PLAT',
        //   name: 'statusjenisplat',
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
        //             grp: 'JENIS PLAT',
        //             subgrp: 'JENIS PLAT'
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
        //     let statusJenisPlat = JSON.parse(value)

        //     let formattedValue = $(`
        //         <div class="badge" style="background-color: ${statusJenisPlat.WARNA}; color: #fff;">
        //           <span>${statusJenisPlat.SINGKATAN}</span>
        //         </div>
        //       `)

        //     return formattedValue[0].outerHTML
        //   },
        //   cellattr: (rowId, value, rowObject) => {
        //     let statusJenisPlat = JSON.parse(rowObject.statusjenisplat)

        //     return ` title="${statusJenisPlat.MEMO}"`
        //   }
        // },
        {
          label: 'TGL PAJAK STNK',
          name: 'tglpajakstnk',
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y"
          }
        },
        {
          label: 'TGL GANTI AKI AKHIR',
          name: 'tglgantiakiterakhir',
          formatter: "date",
          formatoptions: {
            srcformat: "ISO8601Long",
            newformat: "d-m-Y"
          }
        },
        // {
        //   label: 'STATUS MUTASI',
        //   name: 'statusmutasi',
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
        //             grp: 'STATUS MUTASI',
        //             subgrp: 'STATUS MUTASI'
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
        //     let statusMutasi = JSON.parse(value)

        //     let formattedValue = $(`
        //         <div class="badge" style="background-color: ${statusMutasi.WARNA}; color: #fff;">
        //           <span>${statusMutasi.SINGKATAN}</span>
        //         </div>
        //       `)

        //     return formattedValue[0].outerHTML
        //   },
        //   cellattr: (rowId, value, rowObject) => {
        //     let statusMutasi = JSON.parse(rowObject.statusmutasi)

        //     return ` title="${statusMutasi.MEMO}"`
        //   }
        // },
        // {
        //   label: 'STATUS VALIDASI KEND',
        //   name: 'statusvalidasikendaraan',
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
        //             grp: 'STATUS VALIDASI KENDARAAN',
        //             subgrp: 'STATUS VALIDASI KENDARAAN'
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
        //     let statusValKendaraan = JSON.parse(value)

        //     let formattedValue = $(`
        //         <div class="badge" style="background-color: ${statusValKendaraan.WARNA}; color: #fff;">
        //           <span>${statusValKendaraan.SINGKATAN}</span>
        //         </div>
        //       `)

        //     return formattedValue[0].outerHTML
        //   },
        //   cellattr: (rowId, value, rowObject) => {
        //     let statusValKendaraan = JSON.parse(rowObject.statusvalidasikendaraan)

        //     return ` title="${statusValKendaraan.MEMO}"`
        //   }
        // },
        {
          label: 'TIPE',
          name: 'tipe',
        },
        {
          label: 'JENIS',
          name: 'jenis',
        },
        {
          label: 'ISI SILINDER',
          name: 'isisilinder',
        },
        {
          label: 'WARNA',
          name: 'warna',
        },
        {
          label: 'BAHAN BAKAR',
          name: 'jenisbahanbakar',
        },
        {
          label: 'JLH SUMBU',
          name: 'jumlahsumbu',
        },
        {
          label: 'JLH RODA',
          name: 'jumlahroda',
        },
        {
          label: 'MODEL',
          name: 'model',
        },
        {
          label: 'BPKB',
          name: 'nobpkb',
        },
        // {
        //   label: 'STATUS MOBIL STORING',
        //   name: 'statusmobilstoring',
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
        //             grp: 'STATUS MOBIL STORING',
        //             subgrp: 'STATUS MOBIL STORING'
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
        //     let statusMobilStoring = JSON.parse(value)

        //     let formattedValue = $(`
        //         <div class="badge" style="background-color: ${statusMobilStoring.WARNA}; color: #fff;">
        //           <span>${statusMobilStoring.SINGKATAN}</span>
        //         </div>
        //       `)

        //     return formattedValue[0].outerHTML
        //   },
        //   cellattr: (rowId, value, rowObject) => {
        //     let statusMobilStoring = JSON.parse(rowObject.statusmobilstoring)

        //     return ` title="${statusMobilStoring.MEMO}"`
        //   }
        // },
        {
          label: 'supir',
          name: 'supir_id',
        },
        {
          label: 'supirid',
          name: 'supirid',
          search: false,
          hidden: true
        },
        {
          label: 'MANDOR',
          name: 'mandor_id',
        },
        {
          label: 'JLH BAN SERAP',
          name: 'jumlahbanserap',
        },
        {
          label: 'PLUS BORONGAN',
          name: 'nominalplusborongan',
          align: 'right',
          formatter: currencyFormat,
        },
        // {
        //   label: 'STATUS BAN EDIT',
        //   name: 'statusappeditban',
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
        //             grp: 'STATUS APPROVAL EDIT BAN',
        //             subgrp: 'STATUS APPROVAL EDIT BAN'
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
        //     let statusAppEditBan = JSON.parse(value)

        //     let formattedValue = $(`
        //         <div class="badge" style="background-color: ${statusAppEditBan.WARNA}; color: #fff;">
        //           <span>${statusAppEditBan.SINGKATAN}</span>
        //         </div>
        //       `)

        //     return formattedValue[0].outerHTML
        //   },
        //   cellattr: (rowId, value, rowObject) => {
        //     let statusAppEditBan = JSON.parse(rowObject.statusappeditban)

        //     return ` title="${statusAppEditBan.MEMO}"`
        //   }
        // },
        // {
        //   label: 'STATUS LEWAT VALIDASI',
        //   name: 'statuslewatvalidasi',
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
        //             grp: 'STATUS LEWAT VALIDASI',
        //             subgrp: 'STATUS LEWAT VALIDASI'
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
        //     let statusLewatValidasi = JSON.parse(value)

        //     let formattedValue = $(`
        //         <div class="badge" style="background-color: ${statusLewatValidasi.WARNA}; color: #fff;">
        //           <span>${statusLewatValidasi.SINGKATAN}</span>
        //         </div>
        //       `)

        //     return formattedValue[0].outerHTML
        //   },
        //   cellattr: (rowId, value, rowObject) => {
        //     let statusLewatValidasi = JSON.parse(rowObject.statuslewatvalidasi)

        //     return ` title="${statusLewatValidasi.MEMO}"`
        //   }
        // },
        // {
        //   label: 'PHOTO STNK',
        //   name: 'photostnk',
        //   align: 'center',
        //   search: false,
        //   formatter: (value, row) => {
        //     let images = []
        //     if (value.length) {
        //       let files = JSON.parse(value)

        //       files.forEach(file => {
        //         if (file == '') {
        //           file = 'no-image'
        //         }
        //         let image = new Image()
        //         image.width = 25
        //         image.height = 25
        //         image.src = `${apiUrl}trado/image/stnk/${encodeURI(file)}/small/show`
        //         images.push(image.outerHTML)
        //       });

        //       return images.join(' ')
        //     } else {
        //       let image = new Image()
        //       image.width = 25
        //       image.height = 25
        //       image.src = `${apiUrl}trado/image/stnk/no-image/small/show`
        //       return image.outerHTML
        //     }
        //   }
        // },
        // {
        //   label: 'PHOTO BPKB',
        //   name: 'photobpkb',
        //   align: 'center',
        //   search: false,
        //   formatter: (value, row) => {
        //     let images = []

        //     if (value) {
        //       let files = JSON.parse(value)

        //       files.forEach(file => {
        //         if (file == '') {
        //           file = 'no-image'
        //         }

        //         let image = new Image()
        //         image.width = 25
        //         image.height = 25
        //         image.src = `${apiUrl}trado/image/bpkb/${encodeURI(file)}/small/show`

        //         images.push(image.outerHTML)
        //       });

        //       return images.join(' ')
        //     } else {
        //       let image = new Image()
        //       image.width = 25
        //       image.height = 25
        //       image.src = `${apiUrl}trado/image/bpkb/no-image/small/show`
        //       return image.outerHTML
        //     }
        //   }
        // },
        // {
        //   label: 'PHOTO TRADO',
        //   name: 'phototrado',
        //   align: 'center',
        //   search: false,
        //   formatter: (value, row) => {
        //     let images = []

        //     if (value) {
        //       let files = JSON.parse(value)

        //       files.forEach(file => {
        //         if (file == '') {
        //           file = 'no-image'
        //         }
        //         let image = new Image()
        //         image.width = 25
        //         image.height = 25
        //         image.src = `${apiUrl}trado/image/trado/${encodeURI(file)}/small/show`

        //         images.push(image.outerHTML)
        //       });

        //       return images.join(' ')
        //     } else {
        //       let image = new Image()
        //       image.width = 25
        //       image.height = 25
        //       image.src = `${apiUrl}trado/image/trado/no-image/small/show`
        //       return image.outerHTML
        //     }
        //   }
        // },
      ],
      autowidth: true,
      responsive: true,
      shrinkToFit: false,
      height: 450,
      rowNum: 10,
      rownumbers: true,
      toolbar: [true, "top"],
      rownumWidth: 45,
      rowList: [10, 20, 50, 0],
      sortable: true,
      sortname: 'id',
      sortorder: 'asc',
      toolbar: [true, "top"],
      page: 1,
      // pager: $('#tradoLookupPager'),
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
        cab = `{!! $cabang ?? '' !!}`;
        // if(cab == 'TNL'){
        //   jqXHR.setRequestHeader('Authorization', `Bearer ${accessTokenTnl}`)
        // }else{
        jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)
        // }
        setGridLastRequest($(this), jqXHR)
      },
      loadComplete: function(data) {
        changeJqGridRowListText()
        if (detectDeviceType() == 'desktop') {
          $(document).unbind('keydown')
          setCustomBindKeys($(this))

          if (indexRow - 1 > $('#tradoLookup').getGridParam().reccount) {
            indexRow = $('#tradoLookup').getGridParam().reccount - 1
          }

          if (triggerClick) {
            if (id != '') {
              indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
              $(`#tradoLookup [id="${$('#tradoLookup').getDataIDs()[indexRow]}"]`).click()
              id = ''
            } else if (indexRow != undefined) {
              $(`#tradoLookup [id="${$('#tradoLookup').getDataIDs()[indexRow]}"]`).click()
            }

            if ($('#tradoLookup').getDataIDs()[indexRow] == undefined) {
              $(`#tradoLookup [id="` + $('#tradoLookup').getDataIDs()[0] + `"]`).click()
            }

            triggerClick = false
          } else {
            $('#tradoLookup').setSelection($('#tradoLookup').getDataIDs()[indexRow])
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

        $(this).setGridWidth($('#lookupTrado').prev().width())
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

        clearGlobalSearch($('#tradoLookup'))
      },
    })
    .customPager()
  loadGlobalSearch($('#tradoLookup'))
  loadClearFilter($('#tradoLookup'))
</script>