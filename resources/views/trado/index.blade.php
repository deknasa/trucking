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
                    {
                        label: 'MANDOR',
                        name: 'mandor_id',
                    },
                    {
                        label: 'SUPIR',
                        name: 'supir_id',
                    },
                    {
                        label: 'STATUS AKTIF',
                        name: 'statusaktif',
                        stype: 'select',
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
                    },
                    {
                        label: 'MEREK',
                        name: 'merek',
                    },
                    {
                        label: 'no rangka',
                        name: 'norangka',
                    },
                    {
                        label: 'no mesin',
                        name: 'nomesin',
                    },
                    {
                        label: 'NAMA PEMILIK',
                        name: 'nama',
                    },
                    {
                        label: 'NO. STNK',
                        name: 'nostnk',
                    },
                    {
                        label: 'ALAMAT STNK',
                        name: 'alamatstnk',
                    },
                    {
                        label: 'JENIS PLAT',
                        name: 'statusjenisplat',
                        stype: 'select',
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
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
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
                        label: 'JLH BAN',
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
                    {
                        label: 'MILIK MANDOR',
                        name: 'mandor_id',
                    },
                    {
                        label: 'MILIK SUPIR',
                        name: 'supir_id',
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
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'TGL STNK MATI',
                        name: 'tglstnkmati',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'TGL SPEKSI MATI',
                        name: 'tglspeksimati',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
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
                    {
                        label: 'TGL SERVICE OPNAME',
                        name: 'tglserviceopname',
                        width: 200,
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'STATUS STANDARISASI',
                        name: 'statusstandarisasi',
                        width: 200,
                        stype: 'select',
                        searchoptions: {
                            value: `<?php
                                    $i = 1;

                                    foreach ($data['statusstandarisasi'] as $status) :
                                        echo "$status[param]:$status[parameter]";
                                        if ($i !== count($data['statusstandarisasi'])) {
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
                            let statusStandarisasi = JSON.parse(value)

                            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusStandarisasi.WARNA}; color: #fff;">
                  <span>${statusStandarisasi.SINGKATAN}</span>
                </div>
              `)

                            return formattedValue[0].outerHTML
                        },
                        cellattr: (rowId, value, rowObject) => {
                            let statusStandarisasi = JSON.parse(rowObject.statusstandarisasi)

                            return ` title="${statusStandarisasi.MEMO}"`
                        }
                    },
                    {
                        label: 'KET. PROGRESS STANDARISASI',
                        width: 230,
                        name: 'keteranganprogressstandarisasi',
                    },

                    {
                        label: 'TGL GANTI AKI AKHIR',
                        name: 'tglgantiakiterakhir',
                        width: 200,
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'STATUS MUTASI',
                        name: 'statusmutasi',
                        stype: 'select',
                        searchoptions: {
                            value: `<?php
                                    $i = 1;

                                    foreach ($data['statusmutasi'] as $status) :
                                        echo "$status[param]:$status[parameter]";
                                        if ($i !== count($data['statusmutasi'])) {
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
                            let statusMutasi = JSON.parse(value)

                            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusMutasi.WARNA}; color: #fff;">
                  <span>${statusMutasi.SINGKATAN}</span>
                </div>
              `)

                            return formattedValue[0].outerHTML
                        },
                        cellattr: (rowId, value, rowObject) => {
                            let statusMutasi = JSON.parse(rowObject.statusmutasi)

                            return ` title="${statusMutasi.MEMO}"`
                        }
                    },
                    {
                        label: 'STATUS VALIDASI KEND',
                        name: 'statusvalidasikendaraan',
                        width: 200,
                        stype: 'select',
                        searchoptions: {
                            value: `<?php
                                    $i = 1;

                                    foreach ($data['statusvalidasikendaraan'] as $status) :
                                        echo "$status[param]:$status[parameter]";
                                        if ($i !== count($data['statusvalidasikendaraan'])) {
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
                            let statusValKendaraan = JSON.parse(value)

                            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusValKendaraan.WARNA}; color: #fff;">
                  <span>${statusValKendaraan.SINGKATAN}</span>
                </div>
              `)

                            return formattedValue[0].outerHTML
                        },
                        cellattr: (rowId, value, rowObject) => {
                            let statusValKendaraan = JSON.parse(rowObject.statusvalidasikendaraan)

                            return ` title="${statusValKendaraan.MEMO}"`
                        }
                    },
                    {
                        label: 'STATUS MOBIL STORING',
                        name: 'statusmobilstoring',
                        width: 200,
                        stype: 'select',
                        searchoptions: {
                            value: `<?php
                                    $i = 1;

                                    foreach ($data['statusmobilstoring'] as $status) :
                                        echo "$status[param]:$status[parameter]";
                                        if ($i !== count($data['statusmobilstoring'])) {
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
                            let statusMobilStoring = JSON.parse(value)

                            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusMobilStoring.WARNA}; color: #fff;">
                  <span>${statusMobilStoring.SINGKATAN}</span>
                </div>
              `)

                            return formattedValue[0].outerHTML
                        },
                        cellattr: (rowId, value, rowObject) => {
                            let statusMobilStoring = JSON.parse(rowObject.statusmobilstoring)

                            return ` title="${statusMobilStoring.MEMO}"`
                        }
                    },
                    // 
                    {
                        label: 'STATUS ABSENSI SUPIR',
                        name: 'statusabsensisupir',
                        width: 200,
                        stype: 'select',
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
                    {
                        label: 'STATUS BAN EDIT',
                        name: 'statusappeditban',
                        stype: 'select',
                        searchoptions: {
                            value: `<?php
                                    $i = 1;

                                    foreach ($data['statusappeditban'] as $status) :
                                        echo "$status[param]:$status[parameter]";
                                        if ($i !== count($data['statusappeditban'])) {
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
                            let statusAppEditBan = JSON.parse(value)

                            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusAppEditBan.WARNA}; color: #fff;">
                  <span>${statusAppEditBan.SINGKATAN}</span>
                </div>
              `)

                            return formattedValue[0].outerHTML
                        },
                        cellattr: (rowId, value, rowObject) => {
                            let statusAppEditBan = JSON.parse(rowObject.statusappeditban)

                            return ` title="${statusAppEditBan.MEMO}"`
                        }
                    },
                    {
                        label: 'STATUS LEWAT VALIDASI',
                        name: 'statuslewatvalidasi',
                        width: 200,
                        stype: 'select',
                        searchoptions: {
                            value: `<?php
                                    $i = 1;

                                    foreach ($data['statuslewatvalidasi'] as $status) :
                                        echo "$status[param]:$status[parameter]";
                                        if ($i !== count($data['statuslewatvalidasi'])) {
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
                            let statusLewatValidasi = JSON.parse(value)

                            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusLewatValidasi.WARNA}; color: #fff;">
                  <span>${statusLewatValidasi.SINGKATAN}</span>
                </div>
              `)

                            return formattedValue[0].outerHTML
                        },
                        cellattr: (rowId, value, rowObject) => {
                            let statusLewatValidasi = JSON.parse(rowObject.statuslewatvalidasi)

                            return ` title="${statusLewatValidasi.MEMO}"`
                        }
                    },
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

                            editTrado(selectedId)
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
                                cekValidasidelete(selectedId)
                            }
                        }
                    },
                    {
                        id: 'view',
                        innerHTML: '<i class="fa fa-eye"></i> VIEW',
                        class: 'btn btn-orange btn-sm mr-1',
                        onClick: () => {
                            selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                            viewTrado(selectedId)
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
                extndBtn: [{
                    id: 'approve',
                    title: 'Approve',
                    caption: 'Approve',
                    innerHTML: '<i class="fa fa-check"></i> UN/APPROVAL',
                    class: 'btn btn-purple btn-sm mr-1 dropdown-toggle ',
                    dropmenuHTML: [{
                            id: 'approveun',
                            text: "UN/APPROVAL Reminder Oli Mesin",
                            onClick: () => {
                                if (`{{ $myAuth->hasPermission('trado', 'approvalmesin') }}`) {
                                    selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                                    approvalMesin(selectedId)
                                }
                            }
                        },
                        {
                            id: 'approvalPersneling',
                            text: "un/Approval Reminder Oli Persneling",
                            onClick: () => {
                                if (`{{ $myAuth->hasPermission('trado', 'approvalpersneling') }}`) {
                                    selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

                                    approvalPersneling(selectedId);
                                }
                                // selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                            }
                        },
                        {
                            id: 'approvalGardan',
                            text: "un/Approval Reminder Oli Gardan",
                            onClick: () => {
                                if (`{{ $myAuth->hasPermission('trado', 'approvalgardan') }}`) {
                                    selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                                    approvalGardan(selectedId);
                                }
                                // selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                            }
                        },
                        {
                            id: 'approvalSaringanHawa',
                            text: "un/Approval Reminder Oli Saringan Hawa",
                            onClick: () => {
                                if (`{{ $myAuth->hasPermission('trado', 'approvalsaringanhawa') }}`) {
                                    selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                                    approvalSaringanHawa(selectedId);
                                }
                                // selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                            }
                        },
                    ],
                }]
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
            if (!`{{ $myAuth->hasPermission('trado', 'store') }}`) {
                $('#add').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('trado', 'update') }}`) {
                $('#edit').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('trado', 'show') }}`) {
                $('#view').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('trado', 'destroy') }}`) {
                $('#delete').attr('disabled', 'disabled')
            }
            if (!`{{ $myAuth->hasPermission('trado', 'export') }}`) {
                $('#export').attr('disabled', 'disabled')
            }
            if (!`{{ $myAuth->hasPermission('trado', 'report') }}`) {
                $('#report').attr('disabled', 'disabled')
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
                            url: `{{ config('app.api_url ') }}trado/export?` + params,
                            type: 'GET',
                            beforeSend: function(xhr) {
                                xhr.setRequestHeader('Authorization', `Bearer {{ session('access_token ') }}`);
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
    })
</script>
@endpush()
@endsection