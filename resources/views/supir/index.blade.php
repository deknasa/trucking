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

@include('supir._modal')
@include('supir._modalApprovalTanpa')
{{-- @include('supir._modalApprovalKeterangan')
@include('supir._modalApprovalGambar') --}}
@include('supir._modalSupirResign')
@include('supir._modalHistoryMandor')
@include('supir._modalApprovalSupirLuarKota')

@push('scripts')
<script>
    let indexUrl = "{{ route('supir.index') }}"
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
    let sortname = 'namasupir'
    let sortorder = 'asc'
    let autoNumericElements = []
    let rowNum = 10
    let selectedRows = [];
    let selectedRowsSupir = [];


    function checkboxHandler(element) {
        let value = $(element).val();
        if (element.checked) {
            selectedRows.push($(element).val())
            selectedRowsSupir.push($(element).parents('tr').find(`td[aria-describedby="jqGrid_namasupir"]`).text())
            $(element).parents('tr').addClass('bg-light-blue')


        } else {
            $(element).parents('tr').removeClass('bg-light-blue')
            for (var i = 0; i < selectedRows.length; i++) {
                if (selectedRows[i] == value) {
                    selectedRows.splice(i, 1);
                    selectedRowsSupir.splice(i, 1);
                }
            }
        }

    }

    function clearSelectedRows() {
        selectedRows = []
        selectedRowsSupir = []
        $('#gs_check').prop('checked', false);
        $('#jqGrid').trigger('reloadGrid')
    }

    function selectAllRows() {
        $.ajax({
            url: `${apiUrl}supir`,
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
                selectedRows = response.data.map((supir) => supir.id)
                $('#jqGrid').trigger('reloadGrid')
            }
        })
    }
    var statusTidakBolehLuarkota;
    var statusBukanBlackList;
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

    permission()
    $(document).ready(function() {

        setTampilanIndex()
        $("#jqGrid").jqGrid({
                url: `${apiUrl}supir`,
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
                    },
                    {
                        label: 'ID',
                        name: 'id',
                        width: '50px',
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
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
                    },
                    {
                        label: 'ALIAS',
                        name: 'namaalias',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
                    },
                    {
                        label: 'MANDOR',
                        name: 'mandor_id',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
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
                        label: 'TGL LAHIR',
                        name: 'tgllahir',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                        align: 'right',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'ALAMAT',
                        name: 'alamat',
                        width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
                    },
                    {
                        label: 'KOTA',
                        name: 'kota',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                    },
                    {
                        label: 'NO TELEPON',
                        name: 'telp',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                    },
                    {
                        label: 'STATUS',
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
                        label: 'NOM. DEPOSIT SALDO AWAL',
                        name: 'nominaldepositsa',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'right',
                        formatter: currencyFormat,
                    },
                    {
                        label: 'DEPOSIT KE',
                        name: 'depositke',
                        align: 'right',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                        formatter: currencyFormat,
                    },
                    {
                        label: 'NOM. PINJ SALDO AWAL',
                        name: 'nominalpinjamansaldoawal',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'right',
                        formatter: currencyFormat,
                    },
                    {
                        label: 'SUPIR LAMA',
                        name: 'supirold_id',
                    },
                    {
                        label: 'SIM',
                        name: 'nosim',
                    },
                    {
                        label: 'TGL EXP SIM',
                        name: 'tglexpsim',
                        formatter: "date",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                        align: 'right',
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'TGL MASUK',
                        name: 'tglmasuk',
                        formatter: "date",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                        align: 'right',
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'TGL TERBIT SIM',
                        name: 'tglterbitsim',
                        formatter: "date",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                        align: 'right',
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'KETERANGAN',
                        name: 'keterangan',
                    },
                    {
                        label: 'KTP',
                        name: 'noktp',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                    },
                    {
                        label: 'KK',
                        name: 'nokk',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                    },
                    // {
                    //   label: 'UPDATE GBR',
                    //   name: 'statusadaupdategambar',
                    //   stype: 'select',
                    //   searchoptions: {
                    //     value: `<?php
                                    //             $i = 1;

                                    //             foreach ($data['statusadaupdategambar'] as $status) :
                                    //               echo "$status[param]:$status[parameter]";
                                    //               if ($i !== count($data['statusadaupdategambar'])) {
                                    //                 echo ";";
                                    //               }
                                    //               $i++;
                                    //             endforeach

                                    //
                                    ?>
                    // `,
                    //     dataInit: function(element) {
                    //       $(element).select2({
                    //         width: 'resolve',
                    //         theme: "bootstrap4"
                    //       });
                    //     }
                    //   },
                    //   formatter: (value, options, rowData) => {
                    //     let statusAdaupdategambar = JSON.parse(value)

                    //     let formattedValue = $(`
                    //       <div class="badge" style="background-color: ${statusAdaupdategambar.WARNA}; color: #fff;">
                    //         <span>${statusAdaupdategambar.SINGKATAN}</span>
                    //       </div>
                    //     `)

                    //     return formattedValue[0].outerHTML
                    //   },
                    //   cellattr: (rowId, value, rowObject) => {
                    //     let statusAdaupdategambar = JSON.parse(rowObject.statusadaupdategambar)

                    //     return ` title="${statusAdaupdategambar.MEMO}"`
                    //   }
                    // },
                    {
                        label: 'LUAR KOTA',
                        name: 'statusluarkota',
                        stype: 'select',
                        searchoptions: {
                            value: `<?php
                                    $i = 1;

                                    foreach ($data['statusluarkota'] as $status) :
                                        echo "$status[param]:$status[parameter]";
                                        if ($i !== count($data['statusluarkota'])) {
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
                            if (value != null) {

                                let statusLuarkota = JSON.parse(value)

                                let formattedValue = $(`
                  <div class="badge" style="background-color: ${statusLuarkota.WARNA}; color: #fff;">
                    <span>${statusLuarkota.SINGKATAN}</span>
                  </div>
                `)

                                return formattedValue[0].outerHTML
                            } else {
                                return `&nbsp;`;
                            }
                        },
                        cellattr: (rowId, value, rowObject) => {
                            if (rowObject.statusluarkota != null) {

                                let statusLuarkota = JSON.parse(rowObject.statusluarkota)

                                return ` title="${statusLuarkota.MEMO}"`
                            } else {
                                return ` title="${rowObject.statusluarkota}"`
                            }
                        }
                    },
                    // {
                    //   label: 'ZONA TERTENTU',
                    //   name: 'statuszonatertentu',
                    //   stype: 'select',
                    //   searchoptions: {
                    //     value: `<?php
                                    //             $i = 1;

                                    //             foreach ($data['statuszonatertentu'] as $status) :
                                    //               echo "$status[param]:$status[parameter]";
                                    //               if ($i !== count($data['statuszonatertentu'])) {
                                    //                 echo ";";
                                    //               }
                                    //               $i++;
                                    //             endforeach

                                    //
                                    ?>
                    // `,
                    //     dataInit: function(element) {
                    //       $(element).select2({
                    //         width: 'resolve',
                    //         theme: "bootstrap4"
                    //       });
                    //     }
                    //   },
                    //   formatter: (value, options, rowData) => {
                    //     let statusZonatertentu = JSON.parse(value)

                    //     let formattedValue = $(`
                    //       <div class="badge" style="background-color: ${statusZonatertentu.WARNA}; color: #fff;">
                    //         <span>${statusZonatertentu.SINGKATAN}</span>
                    //       </div>
                    //     `)

                    //     return formattedValue[0].outerHTML
                    //   },
                    //   cellattr: (rowId, value, rowObject) => {
                    //     let statusZonatertentu = JSON.parse(rowObject.statuszonatertentu)

                    //     return ` title="${statusZonatertentu.MEMO}"`
                    //   }
                    // },
                    // {
                    //   label: 'ZONA',
                    //   name: 'zona_id',
                    // },                    
                    {
                        label: 'TGL BATAS TDK BOLEH LUAR KOTA',
                        name: 'tglbatastidakbolehluarkota',
                        formatter: "date",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                        align: 'left',
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'Ket. TDK BOLEH LUAR KOTA',
                        name: 'keterangantidakbolehluarkota',
                        width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
                    },
                    // {
                    //     label: 'angsuran pinjaman',
                    //     name: 'angsuranpinjaman',
                    // },
                    // {
                    //     label: 'plafon deposito',
                    //     name: 'plafondeposito',
                    // },
                    {
                        label: 'STATUS APP HISTORY SUPIR MILIK MANDOR',
                        name: 'statusapprovalhistorysupirmilikmandor',
                        width: 200,
                        stype: 'select',
                        width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
                        searchoptions: {
                            value: `<?php
                                    $i = 1;
                                    foreach ($data['statusapprovalhistorysupirmilikmandor'] as $status) :
                                        echo "$status[param]:$status[parameter]";
                                        if ($i !== count($data['statusapprovalhistorysupirmilikmandor'])) {
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
                            let statusApprovalHistorySupirMilikMandor = JSON.parse(value)

                            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusApprovalHistorySupirMilikMandor.WARNA}; color: #fff;">
                  <span>${statusApprovalHistorySupirMilikMandor.SINGKATAN}</span>
                </div>
              `)

                            return formattedValue[0].outerHTML
                        },
                        cellattr: (rowId, value, rowObject) => {
                            let statusApprovalHistorySupirMilikMandor = JSON.parse(rowObject.statusapprovalhistorysupirmilikmandor)

                            return ` title="${statusApprovalHistorySupirMilikMandor.MEMO}"`
                        }
                    },
                    {
                        label: 'USER APP HISTORY SUPIR MILIK MANDOR',
                        name: 'userapprovalhistorysupirmilikmandor',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                    },
                    {
                        label: 'TGL APP HISTORY SUPIR MILIK MANDOR',
                        name: 'tglapprovalhistorysupirmilikmandor',
                        align: 'right',
                        formatter: "date",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y H:i:s"
                        }
                    },
                    {
                        label: 'TGL UPDATE HISTORY SUPIR MILIK MANDOR',
                        name: 'tglupdatehistorysupirmilikmandor',
                        align: 'right',
                        formatter: "date",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y H:i:s"
                        }
                    },
                    {
                        label: 'STATUS POSTING TNL',
                        name: 'statuspostingtnl',
                        width: 230,
                        stype: 'select',
                        searchoptions: {
                            value: `<?php
                                    $i = 1;

                                    foreach ($data['combopostingtnl'] as $status) :
                                        echo "$status[param]:$status[parameter]";
                                        if ($i !== count($data['combopostingtnl'])) {
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
                            let statusPostingTnl = JSON.parse(value)
                            if (!statusPostingTnl) {
                                return ''
                            }

                            let formattedValue = $(`
                                    <div class="badge" style="background-color: ${statusPostingTnl.WARNA}; color: #fff;">
                                    <span>${statusPostingTnl.SINGKATAN}</span>
                                    </div>
                                `)

                            return formattedValue[0].outerHTML
                        },
                        cellattr: (rowId, value, rowObject) => {
                            let statusPostingTnl = JSON.parse(rowObject.statuspostingtnl)
                            if (!statusPostingTnl) {
                                return ` title=""`
                            }
                            return ` title="${statusPostingTnl.MEMO}"`
                        }
                    },
                    {
                        label: 'PHOTO SUPIR',
                        name: 'photosupir',
                        search: false,
                        align: 'center',
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
                                        `${apiUrl}supir/image/supir/${encodeURI(file)}/small/show`

                                    images.push(image.outerHTML)
                                });

                                return images.join(' ')
                            } else {
                                let image = new Image()
                                image.width = 25
                                image.height = 25
                                image.src = `${apiUrl}supir/image/supir/no-image/small/show`
                                return image.outerHTML
                            }
                        }
                    },
                    {
                        label: 'PHOTO KTP',
                        name: 'photoktp',
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
                                        `${apiUrl}supir/image/ktp/${file}/small/show`

                                    images.push(image.outerHTML)
                                });

                                return images.join(' ')
                            } else {
                                let image = new Image()
                                image.width = 25
                                image.height = 25
                                image.src = `${apiUrl}supir/image/ktp/no-image/small/show`
                                return image.outerHTML
                            }
                        }
                    },
                    {
                        label: 'PHOTO SIM',
                        name: 'photosim',
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
                                        `${apiUrl}supir/image/sim/${file}/small/show`

                                    images.push(image.outerHTML)
                                });

                                return images.join(' ')
                            } else {
                                let image = new Image()
                                image.width = 25
                                image.height = 25
                                image.src = `${apiUrl}supir/image/sim/no-image/small/show`
                                return image.outerHTML
                            }
                        }
                    },
                    {
                        label: 'PHOTO KK',
                        name: 'photokk',
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
                                    image.src = `${apiUrl}supir/image/kk/${file}/small/show`

                                    images.push(image.outerHTML)
                                });

                                return images.join(' ')
                            } else {
                                let image = new Image()
                                image.width = 25
                                image.height = 25
                                image.src = `${apiUrl}supir/image/kk/no-image/small/show`
                                return image.outerHTML
                            }
                        }
                    },
                    {
                        label: 'PHOTO SKCK',
                        name: 'photoskck',
                        search: false,
                        align: 'center',
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
                                        `${apiUrl}supir/image/skck/${file}/small/show`

                                    images.push(image.outerHTML)
                                });

                                return images.join(' ')
                            } else {
                                let image = new Image()
                                image.width = 25
                                image.height = 25
                                image.src = `${apiUrl}supir/image/skck/no-image/small/show`
                                return image.outerHTML
                            }
                        }
                    },
                    {
                        label: 'PHOTO DOMISILI',
                        name: 'photodomisili',
                        search: false,
                        align: 'center',
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
                                        `${apiUrl}supir/image/domisili/${file}/small/show`

                                    images.push(image.outerHTML)
                                });
                                return images.join(' ')
                            } else {
                                let image = new Image()
                                image.width = 25
                                image.height = 25
                                image.src = `${apiUrl}supir/image/domisili/no-image/small/show`
                                return image.outerHTML
                            }
                        }
                    },


                    {
                        label: 'TGL BERHENTI SUPIR',
                        name: 'tglberhentisupir',
                        width: 200,
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'keterangan BERHENTI SUPIR',
                        name: 'keteranganberhentisupir',
                        width: 250,

                    },
                    // {
                    //   label: 'KET RESIGN',
                    //   name: 'keteranganresign',
                    // },
                    {
                        label: 'STATUS BLACKLIST',
                        name: 'statusblacklist',
                        stype: 'select',
                        searchoptions: {
                            value: `<?php
                                    $i = 1;

                                    foreach ($data['statusblacklist'] as $status) :
                                        echo "$status[param]:$status[parameter]";
                                        if ($i !== count($data['statusblacklist'])) {
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
                            if (value != null) {

                                let statusBlacklist = JSON.parse(value)
                                let formattedValue = $(`
                <div class="badge" style="background-color: ${statusBlacklist.WARNA}; color: #fff;">
                  <span>${statusBlacklist.SINGKATAN}</span>
                </div>
              `)

                                return formattedValue[0].outerHTML
                            }
                        },
                        cellattr: (rowId, value, rowObject) => {
                            if (rowObject.statusblacklist != null) {
                                let statusBlacklist = JSON.parse(rowObject.statusblacklist)
                                return ` title="${statusBlacklist.MEMO}"`
                            }

                        }
                    },
                    {
                        label: 'NO BUKTI PEMUTIHAN SUPIR',
                        name: 'pemutihansupir_nobukti',
                        width: 230,
                        formatter: (value, options, rowData) => {
                            if ((value == null) || (value == '')) {
                                return '';
                            }
                            let tgldari = rowData.tgldariheaderpemutihansupir
                            let tglsampai = rowData.tglsampaiheaderpemutihansupir
                            let url = "{{route('pemutihansupir.index')}}"
                            let formattedValue = $(`<a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}" class="link-color" target="_blank">${value}</a>`)
                            return formattedValue[0].outerHTML
                        },
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
                        label: 'UPDATED AT',
                        name: 'updated_at',
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
                        class: 'btn add btn-primary btn-sm mr-1',
                        onClick: () => {
                            createSupir()
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
                                cekValidasidelete(selectedId, 'EDIT')
                            }

                        }
                    },
                    {
                        id: 'delete',
                        innerHTML: '<i class="fa fa-trash"></i> DELETE',
                        class: 'btn delete btn-danger btn-sm mr-1',
                        onClick: () => {
                            selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                            if (selectedId == null || selectedId == '' || selectedId == undefined) {
                                showDialog('Harap pilih salah satu record')
                            } else {
                                cekValidasidelete(selectedId, 'DELETE')
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
                                viewSupir(selectedId)
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
                        innerHTML: '<i class="fa fa-check"></i> APPROVAL/UN ',
                        class: 'btn btn-purple btn-sm mr-1',
                        // targetModal:'#listMenuModal',
                        item: [{
                                id: 'approvalBlackListSupir',
                                text: "APPROVAL/UN Black List Supir",
                                color: `<?php echo $data['listbtn']->btn->approvalblacklist; ?>`,
                                hidden: (!`{{ $myAuth->hasPermission('supir', 'approvalBlackListSupir') }}`),
                                onClick: () => {
                                    if (`{{ $myAuth->hasPermission('supir', 'approvalBlackListSupir') }}`) {
                                        selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                                        if (selectedId == null || selectedId == '' || selectedId == undefined) {
                                            showDialog('Harap pilih salah satu record')
                                        } else {
                                            approvalBlackListSupir(selectedId)
                                        }
                                    }
                                }
                            },
                            {
                                id: 'approveun',
                                text: "APPROVAL/UN Kacab",
                                color: `<?php echo $data['listbtn']->btn->approvaldata; ?>`,
                                hidden: (!`{{ $myAuth->hasPermission('supir', 'approval') }}`),
                                onClick: () => {
                                    approve()
                                }
                            },
                            {
                                id: 'approvalaktif',
                                text: "Approval Aktif",
                                color: `<?php echo $data['listbtn']->btn->approvalaktif; ?>`,
                                hidden: (!`{{ $myAuth->hasPermission('supir', 'approvalaktif') }}`),
                                onClick: () => {
                                    if (`{{ $myAuth->hasPermission('supir', 'approvalaktif') }}`) {
                                        approvalAktif('supir')

                                    }
                                }
                            },
                            {
                                id: 'approvalnonaktif',
                                text: "Approval Non Aktif",
                                color: `<?php echo $data['listbtn']->btn->approvalnonaktif; ?>`,
                                hidden: (!`{{ $myAuth->hasPermission('supir', 'approvalnonaktif') }}`),
                                onClick: () => {
                                    if (`{{ $myAuth->hasPermission('supir', 'approvalnonaktif') }}`) {
                                        approvalNonAktif('supir')
                                    }
                                }
                            },
                            {
                                id: 'approvalSupirLuarKota',
                                text: "APPROVAL/UN Supir Luar Kota",
                                color: `<?php echo $data['listbtn']->btn->approvalsupirluarkota; ?>`,
                                hidden: (!`{{ $myAuth->hasPermission('supir', 'approvalSupirLuarKota') }}`),
                                onClick: () => {
                                    if (`{{ $myAuth->hasPermission('supir', 'approvalSupirLuarKota') }}`) {
                                        // selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                                        // if (selectedId == null || selectedId == '' || selectedId == undefined) {
                                        //     showDialog('Harap pilih salah satu record')
                                        // } else {
                                        //     approvalSupirLuarKota(selectedId)
                                        // }
                                        var selectedOne = selectedOnlyOne();
                                        if (selectedOne[0]) {
                                            approvalLuarKota(selectedOne[1])
                                        } else {
                                            showDialog(selectedOne[1])
                                        }
                                    }
                                }
                            },
                            {
                                id: 'approvalSupirResign',
                                text: "APPROVAL/UN Supir Resign",
                                color: `<?php echo $data['listbtn']->btn->approvalresign; ?>`,
                                hidden: (!`{{ $myAuth->hasPermission('supir', 'approvalSupirResign') }}`),
                                onClick: () => {
                                    if (`{{ $myAuth->hasPermission('supir', 'approvalSupirResign') }}`) {
                                        var selectedOne = selectedOnlyOne();
                                        if (selectedOne[0]) {
                                            supirResign(selectedOne[1])
                                        } else {
                                            showDialog(selectedOne[1])
                                        }
                                    }
                                }
                            },
                            {
                                id: 'approvalHistorySupirMilikMandor',
                                text: "APPROVAL/UN History Supir Milik Mandor",
                                color: `<?php echo $data['listbtn']->btn->approvalhistorysupirmilikmandor; ?>`,
                                hidden: (!`{{ $myAuth->hasPermission('supir', 'approvalhistorysupirmilikmandor') }}`),
                                onClick: () => {
                                    if (`{{ $myAuth->hasPermission('supir', 'approvalhistorysupirmilikmandor') }}`) {
                                        approvalHistorySupirMilikMandor();
                                    }
                                }
                            },

                            {
                                id: 'StoreApprovalTradoTanpa',
                                text: "APPROVAL/UN Supir Tanpa Keterangan/Gambar",
                                color: `<?php echo $data['listbtn']->btn->approvaltanpaketerangan; ?>`,
                                hidden: (!`{{ $myAuth->hasPermission('supir', 'StoreApprovalSupirTanpa') }}`),
                                onClick: () => {
                                    var selectedOne = selectedOnlyOne();
                                    if (selectedOne[0]) {
                                        cekValidasiTanpa(selectedOne[1])
                                    } else {
                                        showDialog(selectedOne[1])
                                    }
                                }
                            },
                        ]
                    },
                    {
                        id: 'lainnya',
                        title: 'Lainnya',
                        caption: 'Lainnya',
                        innerHTML: '<i class="fa fa-check"></i> LAINNYA',
                        class: 'btn btn-secondary btn-sm mr-1',
                        // targetModal:'#listMenuModal',
                        item: [{
                            id: 'historyMandor',
                            text: "History Supir Milik Mandor",
                            hidden: (!`{{ $myAuth->hasPermission('supir', 'historySupirMandor') }}`),
                            color: `<?php echo $data['listbtn']->btn->historysupirmandor; ?>`,
                            onClick: () => {
                                if (`{{ $myAuth->hasPermission('supir', 'historySupirMandor') }}`) {
                                    var selectedOne = selectedOnlyOne();
                                    if (selectedOne[0]) {
                                        // editSupirMilikMandor(selectedOne[1])
                                        cekValidasihistory(selectedOne[1], 'historyMandor')

                                    } else {
                                        showDialog(selectedOne[1])
                                    }
                                }
                            },
                        }, ]

                    }
                ],
                // extndBtn: [{
                //         id: 'approve',
                //         title: 'Approve',
                //         caption: 'Approve',
                //         innerHTML: '<i class="fa fa-check"></i> APPROVAL/UN',
                //         class: 'btn btn-purple btn-sm mr-1 dropdown-toggle ',
                //         dropmenuHTML: [{
                //                 id: 'approvalBlackListSupir',
                //                 text: "APPROVAL/UN Black List Supir",
                //                 onClick: () => {
                //                     if (`{{ $myAuth->hasPermission('supir', 'approvalBlackListSupir') }}`) {
                //                         selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                //                         if (selectedId == null || selectedId == '' || selectedId == undefined) {
                //                             showDialog('Harap pilih salah satu record')
                //                         } else {
                //                             approvalBlackListSupir(selectedId)
                //                         }
                //                     }
                //                 }
                //             },
                //             {
                //                 id: 'approveun',
                //                 text: "APPROVAL/UN Kacab",
                //                 onClick: () => {
                //                     approve()
                //                 }
                //             },
                //             {
                //                 id: 'approvalnonaktif',
                //                 text: "Approval Non Aktif",
                //                 onClick: () => {
                //                     approvalNonAktif('supir')
                //                 }
                //             },
                //             {
                //                 id: 'approvalaktif',
                //                 text: "Approval Aktif",
                //                 onClick: () => {
                //                     approvalAktif('supir')
                //                 }
                //             },
                //             {
                //                 id: 'approvalSupirLuarKota',
                //                 text: "APPROVAL/UN Supir Luar Kota",
                //                 onClick: () => {
                //                     if (`{{ $myAuth->hasPermission('supir', 'approvalSupirLuarKota') }}`) {
                //                         // selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                //                         // if (selectedId == null || selectedId == '' || selectedId == undefined) {
                //                         //     showDialog('Harap pilih salah satu record')
                //                         // } else {
                //                         //     approvalSupirLuarKota(selectedId)
                //                         // }
                //                         var selectedOne = selectedOnlyOne();
                //                         if (selectedOne[0]) {
                //                             approvalLuarKota(selectedOne[1])
                //                         } else {
                //                             showDialog(selectedOne[1])
                //                         }
                //                     }
                //                 }
                //             },
                //             {
                //                 id: 'approvalSupirResign',
                //                 text: "APPROVAL/UN Supir Resign",
                //                 onClick: () => {
                //                     if (`{{ $myAuth->hasPermission('supir', 'approvalSupirResign') }}`) {
                //                         var selectedOne = selectedOnlyOne();
                //                         if (selectedOne[0]) {
                //                             supirResign(selectedOne[1])
                //                         } else {
                //                             showDialog(selectedOne[1])
                //                         }
                //                     }
                //                 }
                //             },
                //             {
                //                 id: 'approvalHistorySupirMilikMandor',
                //                 text: "APPROVAL/UN History Supir Milik Mandor",
                //                 onClick: () => {
                //                     if (`{{ $myAuth->hasPermission('supir', 'approvalhistorysupirmilikmandor') }}`) {
                //                         approvalHistorySupirMilikMandor();
                //                     }
                //                 }
                //             },

                //             {
                //                 id: 'StoreApprovalTradoTanpa',
                //                 text: "APPROVAL/UN Supir Tanpa Keterangan/Gambar",
                //                 onClick: () => {
                //                     var selectedOne = selectedOnlyOne();
                //                     if (selectedOne[0]) {
                //                         cekValidasiTanpa(selectedOne[1])
                //                     } else {
                //                         showDialog(selectedOne[1])
                //                     }
                //                 }
                //             },
                //             // {
                //             //     id: 'approvalSupirKeterangan',
                //             //     text: "APPROVAL/UN Supir tanpa Keterangan",
                //             //     onClick: () => {
                //             //         // if (`{{ $myAuth->hasPermission('approvalsupirketerangan', 'update') }}`) {
                //             //         selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                //             //         if (selectedId == null || selectedId == '' || selectedId == undefined) {
                //             //             showDialog('Harap pilih salah satu record')
                //             //         } else {
                //             //             approvalSupirKeterangan(selectedId);
                //             //         }
                //             //         // }
                //             //         // selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                //             //     }
                //             // },
                //             // {
                //             //     id: 'approvalSupirGambar',
                //             //     text: "APPROVAL/UN Supir tanpa Gambar",
                //             //     onClick: () => {
                //             //         // if (`{{ $myAuth->hasPermission('approvalsupirgambar', 'update') }}`) {
                //             //         selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                //             //         if (selectedId == null || selectedId == '' || selectedId == undefined) {
                //             //             showDialog('Harap pilih salah satu record')
                //             //         } else {
                //             //             approvalSupirGambar(selectedId);
                //             //         }
                //             //         // }
                //             //         // selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                //             //     }
                //             // },

                //         ]
                //     },

                //     {
                //         id: 'lainnya',
                //         title: 'Lainnya',
                //         caption: 'Lainnya',
                //         innerHTML: '<i class="fa fa-check"></i> LAINNYA',
                //         class: 'btn btn-secondary btn-sm mr-1 dropdown-toggle ',
                //         dropmenuHTML: [{
                //             id: 'historyMandor',
                //             text: "History Supir Milik Mandor",
                //             onClick: () => {
                //                 if (`{{ $myAuth->hasPermission('supir', 'historySupirMandor') }}`) {
                //                     var selectedOne = selectedOnlyOne();
                //                     if (selectedOne[0]) {
                //                         // editSupirMilikMandor(selectedOne[1])
                //                         cekValidasihistory(selectedOne[1], 'historyMandor')

                //                     } else {
                //                         showDialog(selectedOne[1])
                //                     }
                //                 }
                //             }
                //         }, ],
                //     }
                // ]
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


        getTidakBolehLuarkota()
        getBukanBlackList()
        $('#tglModal').on('shown.bs.modal', function(id) {
            $('#tglModal [name]:not(:hidden)').first().focus()
            initDatepicker()
            $('#tglModal').find('[name=tgl]').val($.datepicker.formatDate('dd-mm-yy', new Date()))
                .trigger('change');
        })

        $('#tglModal').submit(event => {
            event.preventDefault()
            let form = $('#formTgl')
            let id = form.find('[name=id]').val()
            let url = `${apiUrl}supir/${id}/approvalresign`

            $.ajax({
                url: url,
                method: 'POST',
                dataType: 'JSON',
                data: {
                    tanggalberhenti: form.find('[name=tgl]').val()
                },
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    $('#tglModal').trigger('reset')
                    $('#tglModal').modal('hide')
                    id = response.data.id
                },
                error: error => {
                    console.error(error);
                    if (error.status === 422) {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()
                        setErrorMessages(form, error.responseJSON.errors);
                    }
                }
            })
        })


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
                            url: `{{ config('app.api_url') }}supir/export?` + params,
                            type: 'GET',
                            beforeSend: function(xhr) {
                                xhr.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`);
                            },
                            xhrFields: {
                                responseType: 'arraybuffer'
                            },
                            success: function(response, status, xhr) {
                                if (xhr.status === 200) {
                                    if (response !== undefined) {
                                        var blob = new Blob([response], {
                                            type: 'supir/vnd.ms-excel'
                                        });
                                        var link = document.createElement('a');
                                        link.href = window.URL.createObjectURL(blob);
                                        link.download = 'supir' + new Date().getTime() + '.xlsx';
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
                        window.open(`{{ route('supir.report') }}?${params}`)
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
                    url: `${apiUrl}supir/export?${params}`,
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


        function approvalBlackListSupir(supirId) {
            console.log('cvbn');
            event.preventDefault()

            let form = $('#crudForm')
            $(this).attr('disabled', '')
            $('#processingLoader').removeClass('d-none')

            $.ajax({
                url: `${apiUrl}supir/approvalblacklist`,
                method: 'POST',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    Id: selectedRows,
                    nama: selectedRowsSupir
                },
                success: response => {
                    $('#crudForm').trigger('reset')
                    $('#crudModal').modal('hide')

                    $('#jqGrid').jqGrid().trigger('reloadGrid');
                    selectedRows = []
                    selectedRowsSupir = []
                    $('#gs_check').prop('checked', false)
                },
                error: error => {
                    if (error.status === 422) {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()

                        setErrorMessages(form, error.responseJSON.errors);
                    } else {
                        showDialog(error.responseJSON)
                    }
                },
            }).always(() => {
                $('#processingLoader').addClass('d-none')
                $(this).removeAttr('disabled')
            })

            // $.ajax({
            //     url: `${apiUrl}supir/${supirId}`,
            //     method: 'GET',
            //     dataType: 'JSON',
            //     headers: {
            //         Authorization: `Bearer ${accessToken}`
            //     },
            //     success: response => {
            //         let msg = `YAKIN approval BlackList Supir ${response.data.namasupir}`
            //         if (response.data.statusblacklist != statusBukanBlackList) {
            //             msg = `YAKIN Unapproval BlackList Supir ${response.data.namasupir}`
            //         }
            //         showConfirm(msg, "", `supir/${response.data.id}/approvalblacklist`)
            //     },
            // })


        }

        function approvalSupirLuarKota(supirId) {
            event.preventDefault()

            let form = $('#crudForm')
            $(this).attr('disabled', '')
            $('#processingLoader').removeClass('d-none')

            $.ajax({
                url: `${apiUrl}supir/approvalluarkota`,
                method: 'POST',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    Id: selectedRows,
                    nama: selectedRowsSupir
                },
                success: response => {
                    $('#crudForm').trigger('reset')
                    $('#crudModal').modal('hide')

                    $('#jqGrid').jqGrid().trigger('reloadGrid');
                    selectedRows = []
                    selectedRowsSupir = []
                    $('#gs_check').prop('checked', false)
                },
                error: error => {
                    if (error.status === 422) {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()

                        setErrorMessages(form, error.responseJSON.errors);
                    } else {
                        showDialog(error.responseJSON)
                    }
                },
            }).always(() => {
                $('#processingLoader').addClass('d-none')
                $(this).removeAttr('disabled')
            })
        }

        function approvalSupirResign(supirId) {
            $.ajax({
                url: `${apiUrl}supir/${supirId}`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    console.log('approvalsupirresign');
                    if (response.data.tglberhentisupir == "1900-01-01") {
                        $('#tglModal').find('button:submit').html(`Approve Resign`)
                        $('#tglModal').find('label').html(`Tgl Supir Resign`)
                        $('#tglModalLabel').html(`PILIH TANGGAL Supir Resign`)
                        $('#tglModal').find('[name=id]').val(`${selectedId}`)
                        $('#tglModal').modal('show')
                    } else {
                        showConfirm("unapproval Supir Resign", response.data.namasupir,
                            `supir/${response.data.id}/approvalresign`)
                    }
                },
            })
        }

    })


    function permission() {



        if (!`{{ $myAuth->hasPermission('supir', 'store') }}`) {
            $('#add').attr('disabled', 'disabled')
        }

        if ((!`{{ $myAuth->hasPermission('supir', 'update') }}`) && (!`{{ $myAuth->hasPermission('supir', 'updateuser') }}`)) {
            $('#edit').attr('disabled', 'disabled')
        }

        if (!`{{ $myAuth->hasPermission('supir', 'destroy') }}`) {
            $('#delete').attr('disabled', 'disabled')
        }




        if (!`{{ $myAuth->hasPermission('supir', 'show') }}`) {
            $('#view').attr('disabled', 'disabled')
        }

        // if (!`{{ $myAuth->hasPermission('supir', 'update') }}`) {
        //     $('#edit').attr('disabled', 'disabled')
        // }


        if (!`{{ $myAuth->hasPermission('supir', 'export') }}`) {
            $('#export').attr('disabled', 'disabled')
        }
        if (!`{{ $myAuth->hasPermission('supir', 'report') }}`) {
            $('#report').attr('disabled', 'disabled')
        }

        let hakApporveCount = 0;

        hakApporveCount++
        if (!`{{ $myAuth->hasPermission('supir', 'approvalBlackListSupir') }}`) {
            hakApporveCount--
            $('#approvalBlackListSupir').hide()
            // $('#approval-buka-cetak').attr('disabled', 'disabled')
        }

        hakApporveCount++
        if (!`{{ $myAuth->hasPermission('supir', 'approvalaktif') }}`) {
            hakApporveCount--
            $('#approvalaktif').hide()
        }

        hakApporveCount++
        if (!`{{ $myAuth->hasPermission('supir', 'approvalnonaktif') }}`) {
            hakApporveCount--
            $('#approvalnonaktif').hide()
            // $('#approval-buka-cetak').attr('disabled', 'disabled')
        }

        hakApporveCount++
        if (!`{{ $myAuth->hasPermission('supir', 'approvalSupirLuarKota') }}`) {
            hakApporveCount--
            $('#approvalSupirLuarKota').hide()
            // $('#approval-buka-cetak').attr('disabled', 'disabled')
        }
        hakApporveCount++
        if (!`{{ $myAuth->hasPermission('supir', 'approval') }}`) {
            hakApporveCount--
            $('#approveun').hide()
            // $('#approval-buka-cetak').attr('disabled', 'disabled')
        }

        hakApporveCount++
        if (!`{{ $myAuth->hasPermission('supir', 'approvalSupirResign') }}`) {
            hakApporveCount--
            $('#approvalSupirResign').hide()
            // $('#approval-buka-cetak').attr('disabled', 'disabled')
        }

        hakApporveCount++
        if (!`{{ $myAuth->hasPermission('supir', 'StoreApprovalSupirTanpa') }}`) {
            hakApporveCount--
            $('#StoreApprovalTradoTanpa').hide()
        }

        hakApporveCount++
        if (!`{{ $myAuth->hasPermission('supir', 'approvalhistorysupirmilikmandor') }}`) {
            hakApporveCount--
            $('#approvalHistorySupirMilikMandor').hide()
        }



        if (hakApporveCount < 1) {
            $('#approve').hide()
            // $('#approve').attr('disabled', 'disabled')
        }

        if (!`{{ $myAuth->hasPermission('supir', 'historySupirMandor') }}`) {
            $('#lainnya').hide()
        }
    }

    function getTidakBolehLuarkota() {

        $.ajax({
            url: `${apiUrl}parameter`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: {
                limit: 0,
                filters: JSON.stringify({
                    "groupOp": "AND",
                    "rules": [{
                        "field": "grp",
                        "op": "cn",
                        "data": "STATUS LUAR KOTA"
                    }, {
                        "field": "text",
                        "op": "cn",
                        "data": "TIDAK BOLEH LUAR KOTA"
                    }]
                })
            },
            success: response => {
                statusTidakBolehLuarkota = response.data[0].id;
            }
        })
    }

    function getBukanBlackList() {

        $.ajax({
            url: `${apiUrl}parameter`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: {
                limit: 0,
                filters: JSON.stringify({
                    "groupOp": "AND",
                    "rules": [{
                        "field": "grp",
                        "op": "cn",
                        "data": "BLACKLIST SUPIR"
                    }, {
                        "field": "text",
                        "op": "cn",
                        "data": "BUKAN SUPIR BLACKLIST"
                    }]
                })
            },
            success: response => {
                statusBukanBlackList = response.data[0].id;
            }
        })
    }
    const setTampilanIndex = function() {
        return new Promise((resolve, reject) => {
            let data = [];
            data.push({
                name: 'grp',
                value: 'UBAH TAMPILAN'
            })
            data.push({
                name: 'text',
                value: 'SUPIR'
            })
            $.ajax({
                url: `${apiUrl}parameter/getparambytext`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: data,
                success: response => {
                    memo = JSON.parse(response.memo)
                    memo = memo.INPUT
                    if (memo != '') {
                        input = memo.split(',');
                        input.forEach(field => {
                            field = field.toLowerCase();
                            $(`.${field}`).hide()
                            $("#jqGrid").jqGrid("hideCol", field);
                        });
                    }

                }
            })
        })
    }
</script>
@endpush()
@endsection