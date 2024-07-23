@extends('layouts.master')

@section('content')
<!-- Grid -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <table id="jqGrid"></table>
        </div>
    </div>
</div>

@include('trado._modal')
@include('trado._modalApprovalTanpa')
{{-- @include('trado._modalApprovalGambar')
@include('trado._modalApprovalKetrangan') --}}
@include('trado._modalHistoryTradoSupir')
@include('trado._modalHistoryTradoMandor')

@push('scripts')
<script>
    let indexUrl = "{{ route('trado.index') }}"
    let indexRow = 0;
    let page = 0;
    let pager = '#jqGridPager'
    let popup = "";
    let id = "";
    let triggerClick = true;
    let highlightSearch;
    let totalRecord
    let limit
    let postData
    let sortname = 'keterangan'
    let sortorder = 'asc'
    let autoNumericElements = []
    let rowNum = 10;
    let selectedRows = [];
    let selectedRowsTrado = [];

    function checkboxHandler(element) {
        let value = $(element).val();
        if (element.checked) {
            selectedRows.push($(element).val())
            selectedRowsTrado.push($(element).parents('tr').find(`td[aria-describedby="jqGrid_kodeTrado"]`).text())
            $(element).parents('tr').addClass('bg-light-blue')


        } else {
            $(element).parents('tr').removeClass('bg-light-blue')
            for (var i = 0; i < selectedRows.length; i++) {
                if (selectedRows[i] == value) {
                    selectedRows.splice(i, 1);
                    selectedRowsTrado.splice(i, 1);
                }
            }
        }

    }

    function clearSelectedRows() {
        selectedRows = []
        selectedRowsTrado = []
        $('#gs_check').prop('checked', false);
        $('#jqGrid').trigger('reloadGrid')
    }

    function selectAllRows() {
        $.ajax({
            url: `${apiUrl}trado`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: {
                limit: 0,
                filters: $('#jqGrid').jqGrid('getGridParam', 'postData').filters
            },
            success: (response) => {
                selectedRows = response.data.map((trado) => trado.id)
                $('#jqGrid').trigger('reloadGrid')
            }
        })
    }


    var statusAktif = new URLSearchParams(window.location.search).get('status');
    // let selectedRows = [];
    let filterDashboard = {}
    if (statusAktif != '') {
        filterDashboard.filters = JSON.stringify({
            "groupOp": "AND",
            "rules": [{
                "field": "statusaktif",
                "op": "cn",
                "data": statusAktif
            }]
        })
    }
    $(document).ready(function() {
        $("#jqGrid").jqGrid({
                url: `${apiUrl}trado`,
                mtype: "GET",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                datatype: "json",
                postData: filterDashboard,
                colModel: [{
                        label: '',
                        name: 'check',
                        width: 30,
                        align: 'center',
                        sortable: false,
                        clear: false,
                        stype: 'input',
                        searchable: false,
                        searchoptions: {
                            type: 'checkbox',
                            clearSearch: false,
                            dataInit: function(element) {
                                $(element).removeClass('form-control')
                                $(element).parent().addClass('text-center')

                                $(element).on('click', function() {

                                    $(element).attr('disabled', true)
                                    if ($(this).is(':checked')) {
                                        selectAllRows()
                                    } else {
                                        clearSelectedRows()
                                    }
                                })

                            }
                        },
                        formatter: (value, rowOptions, rowData) => {
                            return `<input type="checkbox" name="Id[]" value="${rowData.id}" onchange="checkboxHandler(this)">`
                        },
                    }, {
                        label: 'ID',
                        name: 'id',
                        width: '50px',
                        search: false,
                        hidden: true
                    },
                    {
                        label: 'KETERANGAN',
                        name: 'keterangan',
                        width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
                    },
                    {
                        label: 'NO POLISI',
                        name: 'kodetrado',
                        width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
                    },
                    {
                        label: 'MANDOR',
                        name: 'mandor_id',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                    },
                    {
                        label: 'TGL berlaku milik mandor',
                        name: 'tglberlakumilikmandor',
                        align: 'right',
                        formatter: "date",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'SUPIR',
                        name: 'supir_id',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                    },
                    {
                        label: 'TGL berlaku milik supir',
                        name: 'tglberlakumiliksupir',
                        align: 'right',
                        formatter: "date",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'STATUS AKTIF',
                        name: 'statusaktif',
                        stype: 'select',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                        searchoptions: {
                            value: `<?php
                                    $i = 1;
                                    foreach ($data['statusaktif'] as $status) :
                                        echo "$status[param]:$status[parameter]";
                                        if ($i !== count($data['statusaktif'])) {
                                            echo ';';
                                        }
                                        $i++;
                                    endforeach;
                                    ?>
              `,

                            dataInit: function(element) {
                                $(element).select2({
                                    width: 'resolve',
                                    theme: "bootstrap4"
                                });
                                var statusAktif = new URLSearchParams(window.location.search).get('status');
                                if (statusAktif != '') {
                                    // Set the selected value in the dropdown and trigger change event
                                    $(element).val(statusAktif).trigger('change');
                                }
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
                        label: 'TAHUN',
                        name: 'tahun',
                        align: 'right',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                    },
                    {
                        label: 'MEREK',
                        name: 'merek',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                    },
                    {
                        label: 'no rangka',
                        name: 'norangka',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
                    },
                    {
                        label: 'no mesin',
                        name: 'nomesin',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
                    },
                    {
                        label: 'NAMA PEMILIK',
                        name: 'nama',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                    },
                    {
                        label: 'NO. STNK',
                        name: 'nostnk',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                    },
                    {
                        label: 'ALAMAT STNK',
                        name: 'alamatstnk',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
                    },
                    {
                        label: 'JENIS PLAT',
                        name: 'statusjenisplat',
                        stype: 'select',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                        searchoptions: {
                            value: `<?php
                                    $i = 1;
                                    foreach ($data['statusjenisplat'] as $status) :
                                        echo "$status[param]:$status[parameter]";
                                        if ($i !== count($data['statusjenisplat'])) {
                                            echo ';';
                                        }
                                        $i++;
                                    endforeach;
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
                            let statusJenisPlat = JSON.parse(value)

                            let formattedValue = $(`
                                <div class="badge" style="background-color: ${statusJenisPlat.WARNA}; color: #fff;">
                                <span>${statusJenisPlat.SINGKATAN}</span>
                                </div>
                            `)

                            return formattedValue[0].outerHTML
                        },
                        cellattr: (rowId, value, rowObject) => {
                            let statusJenisPlat = JSON.parse(rowObject.statusjenisplat)

                            return ` title="${statusJenisPlat.MEMO}"`
                        }
                    },
                    {
                        label: 'TGL PAJAK STNK',
                        name: 'tglpajakstnk',
                        formatter: "date",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'TIPE',
                        name: 'tipe',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
                    },
                    {
                        label: 'JENIS',
                        name: 'jenis',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                    },
                    {
                        label: 'ISI SILINDER',
                        name: 'isisilinder',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                    },
                    {
                        label: 'WARNA',
                        name: 'warna',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                    },
                    {
                        label: 'BAHAN BAKAR',
                        name: 'jenisbahanbakar',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                    },
                    {
                        label: 'JLH SUMBU',
                        name: 'jumlahsumbu',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                    },
                    {
                        label: 'JLH BAN',
                        name: 'jumlahroda',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                    },
                    {
                        label: 'MODEL',
                        name: 'model',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                    },
                    {
                        label: 'BPKB',
                        name: 'nobpkb',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
                    },
                    {
                        label: 'JLH BAN SERAP',
                        name: 'jumlahbanserap',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                    },
                    {
                        label: 'PLUS BORONGAN',
                        name: 'nominalplusborongan',
                        align: 'right',
                        formatter: currencyFormat,
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                    },
                    // {
                    //   label: 'KM AWAL',
                    //   name: 'kmawal',
                    //   align: 'right',
                    //   formatter: 'currency',
                    //   formatoptions: {
                    //     decimalSeparator: '.',
                    //     thousandsSeparator: ','
                    //   }
                    // },
                    // {
                    //   label: 'KM GANTI OLI AKHIR',
                    //   name: 'kmakhirgantioli',
                    //   align: 'right',
                    //   formatter: 'currency',
                    //   formatoptions: {
                    //     decimalSeparator: '.',
                    //     thousandsSeparator: ','
                    //   }
                    // },
                    {
                        label: 'TGL ASURANSI MATI',
                        name: 'tglasuransimati',
                        formatter: "date",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'TGL STNK MATI',
                        name: 'tglstnkmati',
                        formatter: "date",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'TGL SPEKSI MATI',
                        name: 'tglspeksimati',
                        formatter: "date",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'MODIFIED BY',
                        name: 'modifiedby',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                    },
                    {
                        label: 'CREATED AT',
                        name: 'created_at',
                        align: 'right',
                        formatter: "date",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
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
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y H:i:s"
                        }
                    },
                    //             {
                    //                 label: 'TGL SERVICE OPNAME',
                    //                 name: 'tglserviceopname',
                    //                 width: 200,
                    //                 formatter: "date",
                    //                 width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                    //                 formatoptions: {
                    //                     srcformat: "ISO8601Long",
                    //                     newformat: "d-m-Y"
                    //                 }
                    //             },
                    //             {
                    //                 label: 'STATUS STANDARISASI',
                    //                 name: 'statusstandarisasi',
                    //                 width: 200,
                    //                 stype: 'select',
                    //                 width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                    //                 searchoptions: {
                    //                     value: `<?php
                                                    //                             $i = 1;
                                                    //                             foreach ($data['statusstandarisasi'] as $status) :
                                                    //                                 echo "$status[param]:$status[parameter]";
                                                    //                                 if ($i !== count($data['statusstandarisasi'])) {
                                                    //                                     echo ';';
                                                    //                                 }
                                                    //                                 $i++;
                                                    //                             endforeach;
                                                    //                             
                                                    ?>
                    // `,
                    //                     dataInit: function(element) {
                    //                         $(element).select2({
                    //                             width: 'resolve',
                    //                             theme: "bootstrap4"
                    //                         });
                    //                     }
                    //                 },
                    //                 formatter: (value, options, rowData) => {
                    //                     let statusStandarisasi = JSON.parse(value)

                    //                     let formattedValue = $(`
                    //         <div class="badge" style="background-color: ${statusStandarisasi.WARNA}; color: #fff;">
                    //           <span>${statusStandarisasi.SINGKATAN}</span>
                    //         </div>
                    //       `)

                    //                     return formattedValue[0].outerHTML
                    //                 },
                    //                 cellattr: (rowId, value, rowObject) => {
                    //                     let statusStandarisasi = JSON.parse(rowObject.statusstandarisasi)

                    //                     return ` title="${statusStandarisasi.MEMO}"`
                    //                 }
                    //             },
                    //             {
                    //                 label: 'KET. PROGRESS STANDARISASI',
                    //                 width: 230,
                    //                 name: 'keteranganprogressstandarisasi',
                    //             },

                    {
                        label: 'TGL GANTI AKI AKHIR',
                        name: 'tglgantiakiterakhir',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                        width: 200,
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    //                     {
                    //                         label: 'STATUS MUTASI',
                    //                         name: 'statusmutasi',
                    //                         stype: 'select',
                    //                         width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                    //                         searchoptions: {
                    //                             value: `<?php
                                                            //                                     $i = 1;
                                                            //                                     foreach ($data['statusmutasi'] as $status) :
                                                            //                                         echo "$status[param]:$status[parameter]";
                                                            //                                         if ($i !== count($data['statusmutasi'])) {
                                                            //                                             echo ';';
                                                            //                                         }
                                                            //                                         $i++;
                                                            //                                     endforeach;
                                                            //                                     
                                                            ?>
                    //         `,
                    //                             dataInit: function(element) {
                    //                                 $(element).select2({
                    //                                     width: 'resolve',
                    //                                     theme: "bootstrap4"
                    //                                 });
                    //                             }
                    //                         },
                    //                         formatter: (value, options, rowData) => {
                    //                             let statusMutasi = JSON.parse(value)

                    //                             let formattedValue = $(`
                    //                 <div class="badge" style="background-color: ${statusMutasi.WARNA}; color: #fff;">
                    //                   <span>${statusMutasi.SINGKATAN}</span>
                    //                 </div>
                    //               `)

                    //                             return formattedValue[0].outerHTML
                    //                         },
                    //                         cellattr: (rowId, value, rowObject) => {
                    //                             let statusMutasi = JSON.parse(rowObject.statusmutasi)

                    //                             return ` title="${statusMutasi.MEMO}"`
                    //                         }
                    //                     },
                    //                     {
                    //                         label: 'STATUS VALIDASI KEND',
                    //                         name: 'statusvalidasikendaraan',
                    //                         width: 200,
                    //                         stype: 'select',
                    //                         width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                    //                         searchoptions: {
                    //                             value: `<?php
                                                            //                                     $i = 1;
                                                            //                                     foreach ($data['statusvalidasikendaraan'] as $status) :
                                                            //                                         echo "$status[param]:$status[parameter]";
                                                            //                                         if ($i !== count($data['statusvalidasikendaraan'])) {
                                                            //                                             echo ';';
                                                            //                                         }
                                                            //                                         $i++;
                                                            //                                     endforeach;
                                                            //                                     
                                                            ?>
                    //   `,
                    //                             dataInit: function(element) {
                    //                                 $(element).select2({
                    //                                     width: 'resolve',
                    //                                     theme: "bootstrap4"
                    //                                 });
                    //                             }
                    //                         },
                    //                         formatter: (value, options, rowData) => {
                    //                             let statusValKendaraan = JSON.parse(value)

                    //                             let formattedValue = $(`
                    //                 <div class="badge" style="background-color: ${statusValKendaraan.WARNA}; color: #fff;">
                    //                   <span>${statusValKendaraan.SINGKATAN}</span>
                    //                 </div>
                    //               `)

                    //                             return formattedValue[0].outerHTML
                    //                         },
                    //                         cellattr: (rowId, value, rowObject) => {
                    //                             let statusValKendaraan = JSON.parse(rowObject.statusvalidasikendaraan)

                    //                             return ` title="${statusValKendaraan.MEMO}"`
                    //                         }
                    //                     },
                    //                     {
                    //                         label: 'STATUS MOBIL STORING',
                    //                         name: 'statusmobilstoring',
                    //                         width: 200,
                    //                         stype: 'select',
                    //                         width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                    //                         searchoptions: {
                    //                             value: `<?php
                                                            //                                     $i = 1;
                                                            //                                     foreach ($data['statusmobilstoring'] as $status) :
                                                            //                                         echo "$status[param]:$status[parameter]";
                                                            //                                         if ($i !== count($data['statusmobilstoring'])) {
                                                            //                                             echo ';';
                                                            //                                         }
                                                            //                                         $i++;
                                                            //                                     endforeach;
                                                            //                                     
                                                            ?>
                    //   `,
                    //                             dataInit: function(element) {
                    //                                 $(element).select2({
                    //                                     width: 'resolve',
                    //                                     theme: "bootstrap4"
                    //                                 });
                    //                             }
                    //                         },
                    //                         formatter: (value, options, rowData) => {
                    //                             let statusMobilStoring = JSON.parse(value)

                    //                             let formattedValue = $(`
                    //                 <div class="badge" style="background-color: ${statusMobilStoring.WARNA}; color: #fff;">
                    //                   <span>${statusMobilStoring.SINGKATAN}</span>
                    //                 </div>
                    //               `)

                    //                             return formattedValue[0].outerHTML
                    //                         },
                    //                         cellattr: (rowId, value, rowObject) => {
                    //                             let statusMobilStoring = JSON.parse(rowObject.statusmobilstoring)

                    //                             return ` title="${statusMobilStoring.MEMO}"`
                    //                         }
                    //                     },
                    // 
                    {
                        label: 'STATUS ABSENSI SUPIR',
                        name: 'statusabsensisupir',
                        width: 200,
                        stype: 'select',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        searchoptions: {
                            value: `<?php
                                    $i = 1;
                                    foreach ($data['statusabsensisupir'] as $status) :
                                        echo "$status[param]:$status[parameter]";
                                        if ($i !== count($data['statusabsensisupir'])) {
                                            echo ';';
                                        }
                                        $i++;
                                    endforeach;
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
                            let statusAbsensiSupir = JSON.parse(value)

                            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusAbsensiSupir.WARNA}; color: #fff;">
                  <span>${statusAbsensiSupir.SINGKATAN}</span>
                </div>
              `)

                            return formattedValue[0].outerHTML
                        },
                        cellattr: (rowId, value, rowObject) => {
                            let statusAbsensiSupir = JSON.parse(rowObject.statusabsensisupir)

                            return ` title="${statusAbsensiSupir.MEMO}"`
                        }
                    },
                    // 
                    //                     {
                    //                         label: 'STATUS BAN EDIT',
                    //                         name: 'statusappeditban',
                    //                         stype: 'select',
                    //                         width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                    //                         searchoptions: {
                    //                             value: `<?php
                                                            //                                     $i = 1;
                                                            //                                     foreach ($data['statusappeditban'] as $status) :
                                                            //                                         echo "$status[param]:$status[parameter]";
                                                            //                                         if ($i !== count($data['statusappeditban'])) {
                                                            //                                             echo ';';
                                                            //                                         }
                                                            //                                         $i++;
                                                            //                                     endforeach;
                                                            //                                     
                                                            ?>
                    //   `,
                    //                             dataInit: function(element) {
                    //                                 $(element).select2({
                    //                                     width: 'resolve',
                    //                                     theme: "bootstrap4"
                    //                                 });
                    //                             }
                    //                         },
                    //                         formatter: (value, options, rowData) => {
                    //                             let statusAppEditBan = JSON.parse(value)

                    //                             let formattedValue = $(`
                    //                 <div class="badge" style="background-color: ${statusAppEditBan.WARNA}; color: #fff;">
                    //                   <span>${statusAppEditBan.SINGKATAN}</span>
                    //                 </div>
                    //               `)

                    //                             return formattedValue[0].outerHTML
                    //                         },
                    //                         cellattr: (rowId, value, rowObject) => {
                    //                             let statusAppEditBan = JSON.parse(rowObject.statusappeditban)

                    //                             return ` title="${statusAppEditBan.MEMO}"`
                    //                         }
                    //                     },
                    //                     {
                    //                         label: 'STATUS LEWAT VALIDASI',
                    //                         name: 'statuslewatvalidasi',
                    //                         width: 200,
                    //                         stype: 'select',
                    //                         width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                    //                         searchoptions: {
                    //                             value: `<?php
                                                            //                                     $i = 1;
                                                            //                                     foreach ($data['statuslewatvalidasi'] as $status) :
                                                            //                                         echo "$status[param]:$status[parameter]";
                                                            //                                         if ($i !== count($data['statuslewatvalidasi'])) {
                                                            //                                             echo ';';
                                                            //                                         }
                                                            //                                         $i++;
                                                            //                                     endforeach;
                                                            //                                     
                                                            ?>
                    //   `,
                    //                             dataInit: function(element) {
                    //                                 $(element).select2({
                    //                                     width: 'resolve',
                    //                                     theme: "bootstrap4"
                    //                                 });
                    //                             }
                    //                         },
                    //                         formatter: (value, options, rowData) => {
                    //                             let statusLewatValidasi = JSON.parse(value)

                    //                             let formattedValue = $(`
                    //                 <div class="badge" style="background-color: ${statusLewatValidasi.WARNA}; color: #fff;">
                    //                   <span>${statusLewatValidasi.SINGKATAN}</span>
                    //                 </div>
                    //               `)

                    //                             return formattedValue[0].outerHTML
                    //                         },
                    //                         cellattr: (rowId, value, rowObject) => {
                    //                             let statusLewatValidasi = JSON.parse(rowObject.statuslewatvalidasi)

                    //                             return ` title="${statusLewatValidasi.MEMO}"`
                    //                         }
                    //                     },
                    {
                        label: 'STATUS APP HISTORY TRADO MILIK MANDOR',
                        name: 'statusapprovalhistorytradomilikmandor',
                        width: 200,
                        stype: 'select',
                        width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
                        searchoptions: {
                            value: `<?php
                                    $i = 1;
                                    foreach ($data['statusapprovalhistorytradomilikmandor'] as $status) :
                                        echo "$status[param]:$status[parameter]";
                                        if ($i !== count($data['statusapprovalhistorytradomilikmandor'])) {
                                            echo ';';
                                        }
                                        $i++;
                                    endforeach;
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
                            let statusApprovalHistoryTradoMilikMandor = JSON.parse(value)

                            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusApprovalHistoryTradoMilikMandor.WARNA}; color: #fff;">
                  <span>${statusApprovalHistoryTradoMilikMandor.SINGKATAN}</span>
                </div>
              `)

                            return formattedValue[0].outerHTML
                        },
                        cellattr: (rowId, value, rowObject) => {
                            let statusApprovalHistoryTradoMilikMandor = JSON.parse(rowObject.statusapprovalhistorytradomilikmandor)

                            return ` title="${statusApprovalHistoryTradoMilikMandor.MEMO}"`
                        }
                    },
                    {
                        label: 'USER APP HISTORY trado MILIK MANDOR',
                        name: 'userapprovalhistorytradomilikmandor',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                    },
                    {
                        label: 'TGL APP HISTORY trado MILIK MANDOR',
                        name: 'tglapprovalhistorytradomilikmandor',
                        align: 'right',
                        formatter: "date",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y H:i:s"
                        }
                    },
                    {
                        label: 'TGL UPDATE HISTORY trado MILIK MANDOR',
                        name: 'tglupdatehistorytradomilikmandor',
                        align: 'right',
                        formatter: "date",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y H:i:s"
                        }
                    },
                    {
                        label: 'STATUS APP HISTORY TRADO MILIK SUPIR',
                        name: 'statusapprovalhistorytradomiliksupir',
                        width: 200,
                        stype: 'select',
                        width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
                        searchoptions: {
                            value: `<?php
                                    $i = 1;
                                    foreach ($data['statusapprovalhistorytradomiliksupir'] as $status) :
                                        echo "$status[param]:$status[parameter]";
                                        if ($i !== count($data['statusapprovalhistorytradomiliksupir'])) {
                                            echo ';';
                                        }
                                        $i++;
                                    endforeach;
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
                            let statusApprovalHistoryTradoMilikSupir = JSON.parse(value)

                            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusApprovalHistoryTradoMilikSupir.WARNA}; color: #fff;">
                  <span>${statusApprovalHistoryTradoMilikSupir.SINGKATAN}</span>
                </div>
              `)

                            return formattedValue[0].outerHTML
                        },
                        cellattr: (rowId, value, rowObject) => {
                            let statusApprovalHistoryTradoMilikSupir = JSON.parse(rowObject.statusapprovalhistorytradomiliksupir)

                            return ` title="${statusApprovalHistoryTradoMilikSupir.MEMO}"`
                        }
                    },
                    {
                        label: 'USER APP HISTORY trado MILIK supir',
                        name: 'userapprovalhistorytradomiliksupir',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                    },
                    {
                        label: 'TGL APP HISTORY trado MILIK supir',
                        name: 'tglapprovalhistorytradomiliksupir',
                        align: 'right',
                        formatter: "date",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y H:i:s"
                        }
                    },
                    {
                        label: 'TGL UPDATE HISTORY trado MILIK supir',
                        name: 'tglupdatehistorytradomiliksupir',
                        align: 'right',
                        formatter: "date",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y H:i:s"
                        }
                    },
                    //                 
                    {
                        label: 'PHOTO STNK',
                        name: 'photostnk',
                        align: 'center',
                        search: false,
                        formatter: (value, row) => {
                            let images = []
                            if (value.length) {
                                let files = JSON.parse(value)

                                files.forEach(file => {
                                    if (file == '') {
                                        file = 'no-image'
                                    }
                                    let image = new Image()
                                    image.width = 25
                                    image.height = 25
                                    image.src =
                                        `${apiUrl}trado/image/stnk/${encodeURI(file)}/small/show`
                                    images.push(image.outerHTML)
                                });

                                return images.join(' ')
                            } else {
                                let image = new Image()
                                image.width = 25
                                image.height = 25
                                image.src = `${apiUrl}trado/image/stnk/no-image/small/show`
                                return image.outerHTML
                            }
                        }
                    },
                    {
                        label: 'PHOTO BPKB',
                        name: 'photobpkb',
                        align: 'center',
                        search: false,
                        formatter: (value, row) => {
                            let images = []

                            if (value) {
                                let files = JSON.parse(value)

                                files.forEach(file => {
                                    if (file == '') {
                                        file = 'no-image'
                                    }

                                    let image = new Image()
                                    image.width = 25
                                    image.height = 25
                                    image.src =
                                        `${apiUrl}trado/image/bpkb/${encodeURI(file)}/small/show`

                                    images.push(image.outerHTML)
                                });

                                return images.join(' ')
                            } else {
                                let image = new Image()
                                image.width = 25
                                image.height = 25
                                image.src = `${apiUrl}trado/image/bpkb/no-image/small/show`
                                return image.outerHTML
                            }
                        }
                    },
                    {
                        label: 'PHOTO TRADO',
                        name: 'phototrado',
                        align: 'center',
                        search: false,
                        formatter: (value, row) => {
                            let images = []

                            if (value) {
                                let files = JSON.parse(value)

                                files.forEach(file => {
                                    if (file == '') {
                                        file = 'no-image'
                                    }
                                    let image = new Image()
                                    image.width = 25
                                    image.height = 25
                                    image.src =
                                        `${apiUrl}trado/image/trado/${encodeURI(file)}/small/show`

                                    images.push(image.outerHTML)
                                });

                                return images.join(' ')
                            } else {
                                let image = new Image()
                                image.width = 25
                                image.height = 25
                                image.src = `${apiUrl}trado/image/trado/no-image/small/show`
                                return image.outerHTML
                            }
                        }
                    },
                ],
                autowidth: true,
                shrinkToFit: false,
                height: 350,
                rowNum: rowNum,
                rownumbers: true,
                rownumWidth: 45,
                rowList: [10, 20, 50, 0],
                toolbar: [true, "top"],
                sortable: true,
                sortname: sortname,
                sortorder: sortorder,
                page: page,
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
                loadBeforeSend: function(jqXHR) {
                    jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)

                    setGridLastRequest($(this), jqXHR)
                },
                onSelectRow: function(id) {
                    activeGrid = $(this)
                    indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
                    page = $(this).jqGrid('getGridParam', 'page')
                    let limit = $(this).jqGrid('getGridParam', 'postData').limit
                    if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))
                },
                loadComplete: function(data) {
                    changeJqGridRowListText()
                    $(document).unbind('keydown')
                    setCustomBindKeys($(this))
                    initResize($(this))
                    $.each(selectedRows, function(key, value) {

                        $('#jqGrid tbody tr').each(function(row, tr) {
                            if ($(this).find(`td input:checkbox`).val() == value) {
                                $(this).find(`td input:checkbox`).prop('checked', true)
                                $(this).addClass('bg-light-blue')
                            }
                        })

                    });

                    /* Set global variables */
                    sortname = $(this).jqGrid("getGridParam", "sortname")
                    sortorder = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecord = $(this).getGridParam("records")
                    limit = $(this).jqGrid('getGridParam', 'postData').limit
                    postData = $(this).jqGrid('getGridParam', 'postData')
                    triggerClick = true

                    $('.clearsearchclass').click(function() {
                        clearColumnSearch($(this))
                    })

                    if (indexRow > $(this).getDataIDs().length - 1) {
                        indexRow = $(this).getDataIDs().length - 1;
                    }

                    if (triggerClick) {
                        if (id != '') {
                            indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
                            $(`[id="${$('#jqGrid').getDataIDs()[indexRow]}"]`).click()
                            id = ''
                        } else if (indexRow != undefined) {
                            $(`[id="${$('#jqGrid').getDataIDs()[indexRow]}"]`).click()
                        }

                        if ($('#jqGrid').getDataIDs()[indexRow] == undefined) {
                            $(`[id="` + $('#jqGrid').getDataIDs()[0] + `"]`).click()
                        }

                        triggerClick = false
                    } else {
                        $('#jqGrid').setSelection($('#jqGrid').getDataIDs()[indexRow])
                    }

                    $('#left-nav').find('button').attr('disabled', false)
                    permission()
                    $('#gs_check').attr('disabled', false)
                    setHighlight($(this))
                },
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
                    $('#left-nav').find(`button:not(#add)`).attr('disabled', 'disabled')
                    clearGlobalSearch($('#jqGrid'))
                },
            })

            .customPager({
                buttons: [{
                        id: 'add',
                        innerHTML: '<i class="fa fa-plus"></i> ADD',
                        class: 'btn btn-primary btn-sm mr-1',
                        onClick: () => {
                            createTrado()
                        }
                    },
                    {
                        id: 'edit',
                        innerHTML: '<i class="fa fa-pen"></i> EDIT',
                        class: 'btn btn-success btn-sm mr-1',
                        onClick: () => {
                            selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                            if (selectedId == null || selectedId == '' || selectedId == undefined) {
                                showDialog('Harap pilih salah satu record')
                            } else {
                                cekValidasi(selectedId, 'EDIT')
                            }
                        }
                    },
                    {
                        id: 'delete',
                        innerHTML: '<i class="fa fa-trash"></i> DELETE',
                        class: 'btn btn-danger btn-sm mr-1',
                        onClick: () => {
                            selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                            if (selectedId == null || selectedId == '' || selectedId == undefined) {
                                showDialog('Harap pilih salah satu record')
                            } else {
                                cekValidasi(selectedId, 'DELETE')
                            }
                        }
                    },
                    {
                        id: 'view',
                        innerHTML: '<i class="fa fa-eye"></i> VIEW',
                        class: 'btn btn-orange btn-sm mr-1',
                        onClick: () => {
                            selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                            if (selectedId == null || selectedId == '' || selectedId == undefined) {
                                showDialog('Harap pilih salah satu record')
                            } else {
                                viewTrado(selectedId)
                            }
                        }
                    },
                    {
                        id: 'report',
                        innerHTML: '<i class="fa fa-print"></i> REPORT',
                        class: 'btn btn-info btn-sm mr-1',
                        onClick: () => {
                            $('#rangeModal').data('action', 'report')
                            $('#rangeModal').find('button:submit').html(`Report`)
                            $('#rangeModal').modal('show')
                        }
                    },
                    {
                        id: 'export',
                        innerHTML: '<i class="fa fa-file-export"></i> EXPORT',
                        class: 'btn btn-warning btn-sm mr-1',
                        onClick: () => {
                            $('#rangeModal').data('action', 'export')
                            $('#rangeModal').find('button:submit').html(`Export`)
                            $('#rangeModal').modal('show')
                        }
                    },
                ],
                modalBtnList: [{
                        id: 'approve',
                        title: 'Approve',
                        caption: 'Approve',
                        innerHTML: '<i class="fa fa-check"></i> APPROVAL/UN',
                        class: 'btn btn-purple btn-sm mr-1 ',
                        item: [{
                                id: 'approveun',
                                text: "APPROVAL/UN Reminder Oli Mesin",
                                color: "btn-success",
                                hidden: (!`{{ $myAuth->hasPermission('trado', 'approvalmesin') }}`),
                                onClick: () => {
                                    if (`{{ $myAuth->hasPermission('trado', 'approvalmesin') }}`) {

                                        approvalMesin()
                                    }
                                }
                            },
                            {
                                id: 'approvalaktif',
                                text: "APPROVAL AKTIF",
                                color: `<?php echo $data['listbtn']->btn->approvalaktif; ?>`,
                                hidden: (!`{{ $myAuth->hasPermission('trado', 'approvalaktif') }}`),
                                onClick: () => {
                                    if (`{{ $myAuth->hasPermission('trado', 'approvalaktif') }}`) {
                                        approvalAktif('trado')
                                    }
                                }
                            },
                            {
                                id: 'approvalnonaktif',
                                text: "Approval Non Aktif",
                                color: `<?php echo $data['listbtn']->btn->approvalnonaktif; ?>`,
                                hidden: (!`{{ $myAuth->hasPermission('trado', 'approvalnonaktif') }}`),
                                onClick: () => {
                                    if (`{{ $myAuth->hasPermission('trado', 'approvalnonaktif') }}`) {
                                        approvalNonAktif('trado')
                                    }
                                }
                            },
                            {
                                id: 'approvalPersneling',
                                text: "APPROVAL/UN Reminder Oli Persneling",
                                color: "btn-primary",
                                hidden: (!`{{ $myAuth->hasPermission('trado', 'approvalpersneling') }}`),
                                onClick: () => {
                                    if (`{{ $myAuth->hasPermission('trado', 'approvalpersneling') }}`) {
                                        approvalPersneling();
                                    }
                                    // selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                                }
                            },
                            {
                                id: 'approvalGardan',
                                text: "APPROVAL/UN Reminder Oli Gardan",
                                color: "btn-purple",
                                hidden: (!`{{ $myAuth->hasPermission('trado', 'approvalgardan') }}`),
                                onClick: () => {
                                    if (`{{ $myAuth->hasPermission('trado', 'approvalgardan') }}`) {
                                        approvalGardan();
                                    }
                                    // selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                                }
                            },
                            {
                                id: 'approvalSaringanHawa',
                                text: "APPROVAL/UN Reminder Oli Saringan Hawa",
                                color: "btn-orange",
                                hidden: (!`{{ $myAuth->hasPermission('trado', 'approvalsaringanhawa') }}`),
                                onClick: () => {
                                    if (`{{ $myAuth->hasPermission('trado', 'approvalsaringanhawa') }}`) {
                                        approvalSaringanHawa();
                                    }
                                    // selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                                }
                            },
                            {
                                id: 'StoreApprovalTradoTanpa',
                                text: "APPROVAL/UN Trado Tanpa Keterangan/Gambar",
                                color: "btn-warning",
                                hidden: (!`{{ $myAuth->hasPermission('trado', 'StoreApprovalTradoTanpa') }}`),
                                onClick: () => {
                                    var selectedOne = selectedOnlyOne();
                                    if (selectedOne[0]) {
                                        cekValidasiTanpa(selectedOne[1])
                                    } else {
                                        showDialog(selectedOne[1])
                                    }
                                }
                            },
                            {
                                id: 'approvalHistoryTradoMilikMandor',
                                text: "APPROVAL/UN History Trado Milik Mandor",
                                color: "btn-danger",
                                hidden: (!`{{ $myAuth->hasPermission('trado', 'approvalhistorytradomilikmandor') }}`),
                                onClick: () => {
                                    if (`{{ $myAuth->hasPermission('trado', 'approvalhistorytradomilikmandor') }}`) {
                                        approvalHistoryTradoMilikMandor();
                                    }
                                }
                            },
                            {
                                id: 'approvalHistoryTradoMilikSupir',
                                text: "APPROVAL/UN History Trado Milik Supir",
                                color: "btn-success",
                                hidden: (!`{{ $myAuth->hasPermission('trado', 'approvalhistorytradomiliksupir') }}`),
                                onClick: () => {
                                    if (`{{ $myAuth->hasPermission('trado', 'approvalhistorytradomiliksupir') }}`) {
                                        approvalHistoryTradoMilikSupir();
                                    }
                                }
                            },
                            // {
                            //     id: 'approvalTradoGambar',
                            //     text: "APPROVAL/UN Trado tanpa Gambar",
                            //     onClick: () => {
                            //         if (`{{ $myAuth->hasPermission('trado', 'approvaltradogambar') }}`) {
                            //             selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

                            //             if (selectedId == null || selectedId == '' || selectedId == undefined) {
                            //                 showDialog('Harap pilih salah satu record')
                            //             } else {
                            //                 approvalTradoGambar(selectedId);
                            //             }
                            //         }
                            //         // selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                            //     }
                            // },
                            // {
                            //     id: 'approvalTradoKeterangan',
                            //     text: "APPROVAL/UN Trado tanpa Keterangan",
                            //     onClick: () => {
                            //         if (`{{ $myAuth->hasPermission('trado', 'approvaltradoketerangan') }}`) {
                            //             selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

                            //             if (selectedId == null || selectedId == '' || selectedId == undefined) {
                            //                 showDialog('Harap pilih salah satu record')
                            //             } else {
                            //                 approvalTradoKeterangan(selectedId);
                            //             }
                            //         }
                            //         // selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                            //     }
                            // },
                        ],
                    },


                    {
                        id: 'lainnya',
                        title: 'Lainnya',
                        caption: 'Lainnya',
                        innerHTML: '<i class="fa fa-check"></i> LAINNYA',
                        class: 'btn btn-secondary btn-sm mr-1 ',
                        item: [{
                            id: 'historyMandor',
                            text: "History Trado Milik Mandor",
                            color: "btn-success",
                            hidden: (!`{{ $myAuth->hasPermission('trado', 'historyTradoMandor') }}`),
                            onClick: () => {
                                if (`{{ $myAuth->hasPermission('trado', 'historyTradoMandor') }}`) {
                                    var selectedOne = selectedOnlyOne();
                                    if (selectedOne[0]) {
                                        // editTradoMilikMandor(selectedOne[1])
                                        cekValidasihistory(selectedOne[1], 'historyMandor')
                                    } else {
                                        showDialog(selectedOne[1])
                                    }
                                }
                            }
                        }, {
                            id: 'historySupir',
                            text: "History Trado Milik Supir",
                            color: "btn-info",
                            hidden: (!`{{ $myAuth->hasPermission('trado', 'historyTradoSupir') }}`),
                            onClick: () => {
                                if (`{{ $myAuth->hasPermission('trado', 'historyTradoSupir') }}`) {
                                    var selectedOne = selectedOnlyOne();
                                    if (selectedOne[0]) {
                                        // editTradoMilikSupir(selectedOne[1])
                                        cekValidasihistory(selectedOne[1], 'historySupir')

                                    } else {
                                        showDialog(selectedOne[1])
                                    }
                                }
                            }
                        }, ],
                    }
                ]
            })

        /* Append clear filter button */
        loadClearFilter($('#jqGrid'))

        /* Append global search */
        loadGlobalSearch($('#jqGrid'))

        $('#add .ui-pg-div')
            .addClass(`btn-sm btn-primary`)
            .parent().addClass('px-1')

        $('#edit .ui-pg-div')
            .addClass('btn-sm btn-success')
            .parent().addClass('px-1')

        $('#delete .ui-pg-div')
            .addClass('btn-sm btn-danger')
            .parent().addClass('px-1')

        $('#report .ui-pg-div')
            .addClass('btn-sm btn-info')
            .parent().addClass('px-1')

        $('#export .ui-pg-div')
            .addClass('btn-sm btn-warning')
            .parent().addClass('px-1')

        function permission() {
            if (cabangTnl == 'YA') {
                $('#add').attr('disabled', 'disabled')
                $('#edit').attr('disabled', 'disabled')
                $('#delete').attr('disabled', 'disabled')
            } else {
                if (!`{{ $myAuth->hasPermission('trado', 'store') }}`) {
                    $('#add').attr('disabled', 'disabled')
                }

                // if (!`{{ $myAuth->hasPermission('trado', 'update') }}`) {
                //     $('#edit').attr('disabled', 'disabled')
                // }

                if ((!`{{ $myAuth->hasPermission('trado', 'update') }}`) && (!`{{ $myAuth->hasPermission('trado', 'updateuser') }}`)) {
                    $('#edit').attr('disabled', 'disabled')
                }

                if (!`{{ $myAuth->hasPermission('trado', 'destroy') }}`) {
                    $('#delete').attr('disabled', 'disabled')
                }
            }

            if (!`{{ $myAuth->hasPermission('trado', 'show') }}`) {
                $('#view').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('trado', 'export') }}`) {
                $('#export').attr('disabled', 'disabled')
            }
            if (!`{{ $myAuth->hasPermission('trado', 'report') }}`) {
                $('#report').attr('disabled', 'disabled')
            }
            let hakApporveCount = 0;
            hakApporveCount++
            if (!`{{ $myAuth->hasPermission('trado', 'approvalmesin') }}`) {
                hakApporveCount--
                $('#approveun').hide()
                // $('#approval-buka-cetak').attr('disabled', 'disabled')
            }
            hakApporveCount++
            if (!`{{ $myAuth->hasPermission('trado', 'approvalnonaktif') }}`) {
                hakApporveCount--
                $('#approvalnonaktif').hide()
                // $('#approval-buka-cetak').attr('disabled', 'disabled')
            }
            hakApporveCount++
            if (!`{{ $myAuth->hasPermission('trado', 'approvalaktif') }}`) {
                hakApporveCount--
                $('#approvalaktif').hide()
                // $('#approval-buka-cetak').attr('disabled', 'disabled')
            }
            hakApporveCount++
            if (!`{{ $myAuth->hasPermission('trado', 'approvalPersneling') }}`) {
                hakApporveCount--
                $('#approvalPersneling').hide()
                // $('#approval-buka-cetak').attr('disabled', 'disabled')
            }
            hakApporveCount++
            if (!`{{ $myAuth->hasPermission('trado', 'approvalGardan') }}`) {
                hakApporveCount--
                $('#approvalGardan').hide()
                // $('#approval-buka-cetak').attr('disabled', 'disabled')
            }
            hakApporveCount++
            if (!`{{ $myAuth->hasPermission('trado', 'approvalSaringanHawa') }}`) {
                hakApporveCount--
                $('#approvalSaringanHawa').hide()
                // $('#approval-buka-cetak').attr('disabled', 'disabled')
            }
            hakApporveCount++
            if (!`{{ $myAuth->hasPermission('trado', 'StoreApprovalTradoTanpa') }}`) {
                hakApporveCount--
                $('#StoreApprovalTradoTanpa').hide()
                // $('#approval-buka-cetak').attr('disabled', 'disabled')
            }
            hakApporveCount++
            if (!`{{ $myAuth->hasPermission('trado', 'approvalhistorytradomilikmandor') }}`) {
                hakApporveCount--
                $('#approvalHistoryTradoMilikMandor').hide()
                // $('#approval-buka-cetak').attr('disabled', 'disabled')
            }
            hakApporveCount++
            if (!`{{ $myAuth->hasPermission('trado', 'approvalhistorytradomiliksupir') }}`) {
                hakApporveCount--
                $('#approvalHistoryTradoMilikSupir').hide()
                // $('#approval-buka-cetak').attr('disabled', 'disabled')
            }




            if (hakApporveCount < 1) {
                $('#approve').hide()
                // $('#approve').attr('disabled', 'disabled')
            }

            let hakLainnyaCount = 0;
            hakLainnyaCount++
            if (!`{{ $myAuth->hasPermission('trado', 'historyTradoMandor') }}`) {
                hakLainnyaCount--
                $('#historyMandor').hide()
                // $('#approval-buka-cetak').attr('disabled', 'disabled')
            }
            hakLainnyaCount++
            if (!`{{ $myAuth->hasPermission('trado', 'historyTradoSupir') }}`) {
                hakLainnyaCount--
                $('#historySupir').hide()
                // $('#approval-buka-cetak').attr('disabled', 'disabled')
            }


            if (hakLainnyaCount < 1) {
                // $('#approve').hide()
                $('#lainnya').hide()
            }

        }

        $('#rangeModal').on('shown.bs.modal', function() {
            if (autoNumericElements.length > 0) {
                $.each(autoNumericElements, (index, autoNumericElement) => {
                    autoNumericElement.remove()
                })
            }

            $('#formRange [name]:not(:hidden)').first().focus()

            $('#formRange [name=sidx]').val($('#jqGrid').jqGrid('getGridParam').postData.sidx)
            $('#formRange [name=sord]').val($('#jqGrid').jqGrid('getGridParam').postData.sord)
            if (page == 0) {
                $('#formRange [name=dari]').val(page)
                $('#formRange [name=sampai]').val(totalRecord)
            } else {
                $('#formRange [name=dari]').val((indexRow + 1) + (limit * (page - 1)))
                $('#formRange [name=sampai]').val(totalRecord)
            }

            autoNumericElements = new AutoNumeric.multiple('#formRange .autonumeric-report', {
                digitGroupSeparator: ',',
                decimalCharacter: '.',
                decimalPlaces: 0,
                allowDecimalPadding: false,
                minimumValue: 1,
                maximumValue: totalRecord
            })
        })

        // MODAL HIDDEN, REMOVE KOTAK MERAH
        $('#rangeModal').on('hidden.bs.modal', function() {

            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
        })

        $('#formRange').submit(event => {
            event.preventDefault()

            let params
            let actionUrl = ``
            let submitButton = $(this).find('button:submit')
            submitButton.attr('disabled', 'disabled')
            $('#processingLoader').removeClass('d-none')

            /* Clear validation messages */
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()

            /* Set params value */
            for (var key in postData) {
                if (params != "") {
                    params += "&";
                }
                params += key + "=" + encodeURIComponent(postData[key]);
            }

            // window.open(`${actionUrl}?${$('#formRange').serialize()}&${params}`)

            let formRange = $('#formRange')
            let offset = parseInt(formRange.find('[name=dari]').val()) - 1
            let limit = parseInt(formRange.find('[name=sampai]').val().replace('.', '')) - offset
            params += `&offset=${offset}&limit=${limit}`

            getCekExport(params).then((response) => {
                    if ($('#rangeModal').data('action') == 'export') {
                        $.ajax({
                            url: `${apiUrl}trado/export?${params}`,
                            type: 'GET',
                            headers: {
                                Authorization: `Bearer ${accessToken}`
                            },
                            xhrFields: {
                                responseType: 'arraybuffer'
                            },
                            success: function(response, status, xhr) {
                                if (xhr.status === 200) {
                                    if (response !== undefined) {
                                        var blob = new Blob([response], {
                                            type: 'trado/vnd.ms-excel'
                                        });
                                        var link = document.createElement('a');
                                        link.href = window.URL.createObjectURL(blob);
                                        link.download = 'trado' + new Date().getTime() + '.xlsx';
                                        link.click();
                                    }
                                    $('#rangeModal').modal('hide')
                                }
                            },
                            error: function(xhr, status, error) {
                                $('#processingLoader').addClass('d-none')
                                submitButton.prop('disabled', false)
                            }
                        }).always(() => {
                            $('#processingLoader').addClass('d-none')
                            submitButton.prop('disabled', false)
                        })
                    } else if ($('#rangeModal').data('action') == 'report') {
                        window.open(`{{ route('trado.report') }}?${params}`)
                        submitButton.prop('disabled', false)
                        $('#processingLoader').addClass('d-none')
                        $('#rangeModal').modal('hide')
                    }
                })

                .catch((error) => {
                    if (error.status === 422) {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()
                        let status
                        if (error.responseJSON.hasOwnProperty('status') == false) {
                            status = false
                        } else {
                            status = true
                        }
                        statusText = error.statusText
                        errors = error.responseJSON.errors
                        $.each(errors, (index, error) => {
                            let indexes = index.split(".");
                            if (status === false) {
                                indexes[0] = 'sampai'
                            }
                            let element;
                            element = $('#rangeModal').find(`[name="${indexes[0]}"]`)[
                                0];
                            if ($(element).length > 0 && !$(element).is(":hidden")) {
                                $(element).addClass("is-invalid");
                                $(`
                                                <div class="invalid-feedback">
                                                ${error[0].toLowerCase()}
                                                </div>
                                        `).appendTo($(element).parent());
                            } else {
                                setTimeout(() => {
                                    return showDialog(error);
                                }, 100)
                            }
                        });
                        $(".is-invalid").first().focus();
                        $('#processingLoader').addClass('d-none')

                    } else {
                        showDialog(error.statusText)
                    }
                })

                .finally(() => {

                    $('.ui-button').click()

                    submitButton.removeAttr('disabled')
                })
        })

        function getCekExport(params) {

            params += `&cekExport=true`

            return new Promise((resolve, reject) => {
                $.ajax({
                    url: `${apiUrl}trado/export?${params}`,
                    dataType: "JSON",
                    headers: {
                        Authorization: `Bearer ${accessToken}`
                    },
                    success: (response) => {
                        resolve(response);
                    },
                    error: error => {
                        reject(error)

                    },
                });
            });
        }



        const setStatusApprovalOptions = function(relatedForm) {
            return new Promise((resolve, reject) => {
                relatedForm.find('[name=statusapproval]').empty()
                relatedForm.find('[name=statusapproval]').append(
                    new Option('-- PILIH STATUS APPROVAL --', '', false, true)
                ).trigger('change')

                $.ajax({
                    url: `${apiUrl}parameter/combo`,
                    method: 'GET',
                    dataType: 'JSON',
                    headers: {
                        Authorization: `Bearer ${accessToken}`
                    },
                    data: {
                        grp: 'STATUS APPROVAL',
                        subgrp: 'STATUS APPROVAL'
                    },
                    success: response => {
                        response.data.forEach(statusApproval => {
                            let option = new Option(statusApproval.text, statusApproval.id)

                            relatedForm.find('[name=statusapproval]').append(option).trigger('change')
                        });

                        resolve()
                    }
                })
            })
        }
    })
</script>
@endpush()
@endsection