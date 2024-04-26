@extends('layouts.master')

@section('content')
<!-- Grid -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            @include('layouts._rangeheader')

            <table id="jqGrid"></table>
        </div>
    </div>

    <div class="row mt-3">
        <div class="col-12">
            <div class="card card-primary card-outline card-outline-tabs">
                <div class="card-body border-bottom-0">
                    <div id="tabs">
                        <ul class="dejavu">
                            <li><a href="#detail-tab">Details</a></li>
                            <li><a href="#jurnal-tab">Jurnal</a></li>
                        </ul>
                        <div id="detail-tab">
                            <table id="detail"></table>
                        </div>
                        <div id="jurnal-tab">
                            <table id="jurnalGrid"></table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('penerimaangiroheader._modal')
<!-- Detail -->
@include('penerimaangiroheader._detail')
@include('jurnalumum._jurnal')

@push('scripts')
<script>
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
    let sortname = 'nobukti'
    let sortorder = 'asc'
    let autoNumericElements = []
    let rowNum = 10
    let hasDetail = false
    let currentTab = 'detail'
    let selectedRows = [];
    let tgldariheader
    let tglsampaiheader

    let selectedbukti = [];

    function checkboxHandler(element) {
        let value = $(element).val();
        let valuebukti = $(`#jqGrid tr#${value}`).find(`td[aria-describedby="jqGrid_nobukti"]`).attr('title');
        if (element.checked) {
            selectedRows.push($(element).val())
            selectedbukti.push(valuebukti)
            $(element).parents('tr').addClass('bg-light-blue')
        } else {
            $(element).parents('tr').removeClass('bg-light-blue')
            for (var i = 0; i < selectedRows.length; i++) {
                if (selectedRows[i] == value) {
                    selectedRows.splice(i, 1);
                }
            }
            if (selectedRows.length != $('#jqGrid').jqGrid('getGridParam').records) {
                $('#gs_').prop('checked', false)
            }

            for (var i = 0; i < selectedbukti.length; i++) {
                if (selectedbukti[i] == valuebukti) {
                    selectedbukti.splice(i, 1);
                }
            }

            if (selectedbukti.length != $('#jqGrid').jqGrid('getGridParam').records) {
                $('#gs_').prop('checked', false)
            }

        }

    }

    setSpaceBarCheckedHandler()
    reloadGrid()
    $(document).ready(function() {
        $("#tabs").tabs()

        let nobukti = $('#jqGrid').jqGrid('getCell', id, 'nobukti')
        loadDetailGrid()
        loadJurnalUmumGrid(nobukti)

        @isset($request['tgldari'])
        tgldariheader = `{{ $request['tgldari'] }}`;
        @endisset
        @isset($request['tglsampai'])
        tglsampaiheader = `{{ $request['tglsampai'] }}`;
        @endisset
        setRange(false, tgldariheader, tglsampaiheader)

        initDatepicker('datepickerIndex')
        $(document).on('click', '#btnReload', function(event) {
            loadDataHeader('penerimaangiroheader')
            selectedRows = []
            selectedbukti = []
            $('#gs_').prop('checked', false)
        })

        $("#jqGrid").jqGrid({
                url: `${apiUrl}penerimaangiroheader`,
                mtype: "GET",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                postData: {
                    tgldari: $('#tgldariheader').val(),
                    tglsampai: $('#tglsampaiheader').val()
                },
                datatype: "json",
                colModel: [{
                        label: '',
                        name: '',
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
                            return `<input type="checkbox" name="giroId[]" value="${rowData.id}" onchange="checkboxHandler(this)">`
                        },
                    }, {
                        label: 'ID',
                        name: 'id',
                        align: 'right',
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
                            let statusApproval = JSON.parse(rowObject.statusapproval)
                            if (!statusApproval) {
                                return ` title=" "`
                            }
                            return ` title="${statusApproval.MEMO}"`
                        }
                    },
                    {
                        label: 'STATUS CETAK',
                        name: 'statuscetak',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left',
                        stype: 'select',
                        searchoptions: {
                            value: `<?php
                                    $i = 1;

                                    foreach ($data['combocetak'] as $status) :
                                        echo "$status[param]:$status[parameter]";
                                        if ($i !== count($data['combocetak'])) {
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
                            let statusCetak = JSON.parse(value)
                            if (!statusCetak) {
                                return ''
                            }
                            let formattedValue = $(`
                                <div class="badge" style="background-color: ${statusCetak.WARNA}; color: #fff;">
                                <span>${statusCetak.SINGKATAN}</span>
                                </div>
                            `)

                            return formattedValue[0].outerHTML
                        },
                        cellattr: (rowId, value, rowObject) => {
                            let statusCetak = JSON.parse(rowObject.statuscetak)
                            if (!statusCetak) {
                                return ` title=" "`
                            }
                            return ` title="${statusCetak.MEMO}"`
                        }
                    },
                    {
                        label: 'STATUS KIRIM BERKAS',
                        name: 'statuskirimberkas',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left',
                        stype: 'select',
                        searchoptions: {

                            value: `<?php
                                    $i = 1;

                                    foreach ($data['combokirimberkas'] as $status) :
                                        echo "$status[param]:$status[parameter]";
                                        if ($i !== count($data['combokirimberkas'])) {
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
                            let statusKirimBerkas = JSON.parse(value)
                            if (!statusKirimBerkas) {
                                return ``
                            }
                            let formattedValue = $(`
                                <div class="badge" style="background-color: ${statusKirimBerkas.WARNA}; color: #fff;">
                                <span>${statusKirimBerkas.SINGKATAN}</span>
                                </div>
                            `)

                            return formattedValue[0].outerHTML
                        },
                        cellattr: (rowId, value, rowObject) => {
                            let statusKirimBerkas = JSON.parse(rowObject.statuskirimberkas)
                            if (!statusKirimBerkas) {
                                return ` title=""`
                            }
                            return ` title="${statusKirimBerkas.MEMO}"`
                        }
                    },
                    {
                        label: 'NO BUKTI',
                        name: 'nobukti',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
                        align: 'left'
                    },
                    {
                        label: 'TGL BUKTI',
                        name: 'tglbukti',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                        align: 'left',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'NOMINAL',
                        name: 'nominal',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'right',
                        formatter: currencyFormat,
                    },
                    {
                        label: 'CUSTOMER ',
                        name: 'agen_id',
                        width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
                        align: 'left'
                    },

                    {
                        label: 'POSTING DARI',
                        name: 'postingdari',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
                        align: 'left'
                    },
                    {
                        label: 'DITERIMA DARI',
                        name: 'diterimadari',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left'
                    },
                    {
                        label: 'TGL Lunas',
                        name: 'tgllunas',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                        align: 'left',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'USER APPROVAL',
                        name: 'userapproval',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left'
                    },
                    {
                        label: 'TGL APPROVAL',
                        name: 'tglapproval',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'USER BUKA CETAK',
                        name: 'userbukacetak',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left'
                    },
                    {
                        label: 'TGL BUKA CETAK',
                        name: 'tglbukacetak',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'USER KIRIM BERKAS',
                        name: 'userkirimberkas',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left'
                    },
                    {
                        label: 'TGL KIRIM BERKAS',
                        name: 'tglkirimberkas',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
                        align: 'left',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y H:i:s"
                        }
                    },
                    {
                        label: 'MODIFIED BY',
                        name: 'modifiedby',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left'
                    },
                    {
                        label: 'CREATED AT',
                        name: 'created_at',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
                        align: 'left',
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
                        align: 'left',
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
                    let nobukti = $(`#jqGrid tr#${id}`).find(`td[aria-describedby="jqGrid_nobukti"]`).attr('title') ?? '';
                    activeGrid = $(this)
                    indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
                    page = $(this).jqGrid('getGridParam', 'page')
                    let limit = $(this).jqGrid('getGridParam', 'postData').limit
                    if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))

                    loadDetailData(id)
                    loadJurnalUmumData(id, nobukti)
                },
                loadComplete: function(data) {
                    changeJqGridRowListText()

                    if (data.data.length === 0) {
                        $('#detail, #jurnalGrid').each((index, element) => {
                            abortGridLastRequest($(element))
                            clearGridData($(element))
                        })
                        $('#jqGrid').each((index, element) => {
                            abortGridLastRequest($(element))
                            clearGridHeader($(element))
                        })
                    }

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

                    setTimeout(function() {

                        if (triggerClick) {
                            if (id != '') {
                                indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
                                $(`#jqGrid [id="${$('#jqGrid').getDataIDs()[indexRow]}"]`).click()
                                id = ''
                            } else if (indexRow != undefined) {
                                $(`#jqGrid [id="${$('#jqGrid').getDataIDs()[indexRow]}"]`).click()
                            }

                            if ($('#jqGrid').getDataIDs()[indexRow] == undefined) {
                                $(`#jqGrid [id="` + $('#jqGrid').getDataIDs()[0] + `"]`).click()
                            }

                            triggerClick = false
                        } else {
                            $('#jqGrid').setSelection($('#jqGrid').getDataIDs()[indexRow])
                        }
                    }, 100)

                    $('#left-nav').find('button').attr('disabled', false)
                    permission()
                    $('#gs_').attr('disabled', false)
                    setHighlight($(this))
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
                    $('#left-nav').find(`button:not(#add)`).attr('disabled', 'disabled')
                    clearGlobalSearch($('#jqGrid'))
                },
            })

            .customPager({

                extndBtn: [{
                        id: 'report',
                        title: 'Report',
                        caption: 'Report',
                        innerHTML: '<i class="fa fa-print"></i> REPORT',
                        class: 'btn btn-info btn-sm mr-1 dropdown-toggle',
                        dropmenuHTML: [{
                                id: 'reportPrinterBesar',
                                text: "Printer Lain(Faktur)",
                                onClick: () => {
                                    selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                                    if (selectedId == null || selectedId == '' || selectedId == undefined) {
                                        showDialog('Harap pilih salah satu record')
                                    } else {
                                        nobukti = $(`#jqGrid tr#${selectedId}`).find(`td[aria-describedby="jqGrid_nobukti"]`).attr('title');

                                        cekValidasi(selectedId, 'PRINTER BESAR', nobukti)
                                    }
                                    clearSelectedRows()
                                    $('#gs_').prop('checked', false)
                                }
                            },
                            {
                                id: 'reportPrinterKecil',
                                text: "Printer Epson Seri LX(Faktur)",
                                onClick: () => {
                                    selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                                    if (selectedId == null || selectedId == '' || selectedId == undefined) {
                                        showDialog('Harap pilih salah satu record')
                                    } else {
                                        nobukti = $(`#jqGrid tr#${selectedId}`).find(`td[aria-describedby="jqGrid_nobukti"]`).attr('title');

                                        cekValidasi(selectedId, 'PRINTER KECIL', nobukti)
                                    }
                                    clearSelectedRows()
                                    $('#gs_').prop('checked', false)
                                }
                            },

                        ],
                    },
                    {
                        id: 'export',
                        title: 'Export',
                        caption: 'Export',
                        innerHTML: '<i class="fas fa-file-export"></i> EXPORT',
                        class: 'btn btn-warning btn-sm mr-1',
                        onClick: () => {

                            selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                            if (selectedId == null || selectedId == '' || selectedId == undefined) {
                                showDialog('Harap pilih salah satu record')
                            } else {
                                window.open(`{{ route('penerimaangiroheader.export') }}?id=${selectedId}`)
                            }
                            clearSelectedRows()
                            $('#gs_').prop('checked', false)
                        }
                    },
                    {
                        id: 'approve',
                        title: 'Approve',
                        caption: 'Approve',
                        innerHTML: '<i class="fa fa-check"></i> UN/APPROVAL',
                        class: 'btn btn-purple btn-sm mr-1 dropdown-toggle ',
                        dropmenuHTML: [{
                                id: 'approveun',
                                text: "UN/APPROVAL Status PENERIMAAN GIRO",
                                onClick: () => {

                                    if (`{{ $myAuth->hasPermission('penerimaangiroheader', 'approval') }}`) {
                                        approve()
                                    }
                                }
                            },
                            {
                                id: 'approval-buka-cetak',
                                text: "Approval Buka Cetak PENERIMAAN GIRO",
                                onClick: () => {
                                    if (`{{ $myAuth->hasPermission('penerimaangiroheader', 'approvalbukacetak') }}`) {
                                        let tglbukacetak = $('#tgldariheader').val().split('-');
                                        tglbukacetak = tglbukacetak[1] + '-' + tglbukacetak[2];
                                        approvalBukaCetak(tglbukacetak, 'PENERIMAANGIROHEADER', selectedRows, selectedbukti);
                                    }
                                }
                            },
                            {
                                id: 'approval-kirim-berkas',
                                text: "Un/Approval Kirim Berkas PENERIMAAN GIRO",
                                onClick: () => {
                                    if (`{{ $myAuth->hasPermission('penerimaangiroheader', 'approvalkirimberkas') }}`) {
                                        let tglkirimberkas = $('#tgldariheader').val().split('-');
                                        tglkirimberkas = tglkirimberkas[1] + '-' + tglkirimberkas[2];
                                        approvalKirimBerkas(tglkirimberkas, 'PENERIMAANGIROHEADER', selectedRows, selectedbukti);
                                    }
                                }
                            },
                        ],
                    }
                ],
                buttons: [{
                        id: 'add',
                        innerHTML: '<i class="fa fa-plus"></i> ADD',
                        class: 'btn btn-primary btn-sm mr-1',
                        onClick: function(event) {
                            clearSelectedRows()
                            $('#gs_').prop('checked', false)
                            createPenerimaanGiro()
                        }
                    },
                    {
                        id: 'edit',
                        innerHTML: '<i class="fa fa-pen"></i> EDIT',
                        class: 'btn btn-success btn-sm mr-1',
                        onClick: function(event) {

                            selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                            if (selectedId == null || selectedId == '' || selectedId == undefined) {
                                showDialog('Harap pilih salah satu record')
                            } else {
                                nobukti = $(`#jqGrid tr#${selectedId}`).find(`td[aria-describedby="jqGrid_nobukti"]`).attr('title');
                                cekValidasi(selectedId, 'EDIT', nobukti)
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
                                nobukti = $(`#jqGrid tr#${selectedId}`).find(`td[aria-describedby="jqGrid_nobukti"]`).attr('title');

                                cekValidasi(selectedId, 'DELETE', nobukti)
                            }
                        }
                    },
                    {
                        id: 'view',
                        innerHTML: '<i class="fa fa-eye"></i> VIEW',
                        class: 'btn btn-orange btn-sm mr-1',
                        onClick: () => {
                            selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

                            viewPenerimaanGiro(selectedId)

                            if (selectedId == null || selectedId == '' || selectedId == undefined) {
                                showDialog('Harap pilih salah satu record')
                            } else {
                                viewPenerimaanGiro(selectedId)
                            }
                        }
                    },
                ],
            })

        /* Append clear filter button */
        loadClearFilter($('#jqGrid'))

        /* Append global search */
        loadGlobalSearch($('#jqGrid'))

        $('#add .ui-pg-div')
            .addClass(`btn btn-sm btn-primary`)
            .parent().addClass('px-1')

        $('#edit .ui-pg-div')
            .addClass('btn btn-sm btn-success')
            .parent().addClass('px-1')

        $('#delete .ui-pg-div')
            .addClass('btn btn-sm btn-danger')
            .parent().addClass('px-1')

        $('#report .ui-pg-div')
            .addClass('btn btn-sm btn-info')
            .parent().addClass('px-1')

        $('#export .ui-pg-div')
            .addClass('btn btn-sm btn-warning')
            .parent().addClass('px-1')

        $('#approval .ui-pg-div')
            .addClass('btn btn-purple btn-sm')
            .css({
                'background': '#6619ff',
                'color': '#fff'
            })
            .parent().addClass('px-1')


        function permission() {
            if (!`{{ $myAuth->hasPermission('penerimaangiroheader', 'store') }}`) {
                $('#add').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('penerimaangiroheader', 'update') }}`) {
                $('#edit').attr('disabled', 'disabled')
            }
            if (!`{{ $myAuth->hasPermission('penerimaangiroheader', 'show') }}`) {
                $('#view').attr('disabled', 'disabled')
            }
            if (!`{{ $myAuth->hasPermission('penerimaangiroheader', 'destroy') }}`) {
                $('#delete').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('penerimaangiroheader', 'export') }}`) {
                $('#export').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('penerimaangiroheader', 'report') }}`) {
                $('#report').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('penerimaangiroheader', 'approval') }}`) {
                $('#approval').attr('disabled', 'disabled')
            }

            let hakApporveCount = 0;
            hakApporveCount++
            if (!`{{ $myAuth->hasPermission('penerimaangiroheader', 'approval') }}`) {
                hakApporveCount--
                $('#approveun').hide()
                // $('#approval-buka-cetak').attr('disabled', 'disabled')
            }
            hakApporveCount++
            if (!`{{ $myAuth->hasPermission('penerimaangiroheader', 'approvalbukacetak') }}`) {
                hakApporveCount--
                $('#approval-buka-cetak').hide()
                // $('#approval-buka-cetak').attr('disabled', 'disabled')
            }
            hakApporveCount++
            if (!`{{ $myAuth->hasPermission('penerimaangiroheader', 'approvalkirimberkas') }}`) {
                hakApporveCount--
                $('#approval-kirim-berkas').hide()
                // $('#approval-buka-cetak').attr('disabled', 'disabled')
            }
            if (hakApporveCount < 1) {
                $('#approve').hide()
                //   $('#approve').attr('disabled', 'disabled')
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
            $('#formRange [name=dari]').val((indexRow + 1) + (limit * (page - 1)))
            $('#formRange [name=sampai]').val(totalRecord)

            autoNumericElements = new AutoNumeric.multiple('#formRange .autonumeric-report', {
                digitGroupSeparator: '.',
                decimalCharacter: ',',
                allowDecimalPadding: false,
                minimumValue: 1,
                maximumValue: totalRecord
            })
        })

        $('#formRange').submit(function(event) {
            event.preventDefault()

            let params
            let submitButton = $(this).find('button:submit')

            submitButton.attr('disabled', 'disabled')

            /* Set params value */
            for (var key in postData) {
                if (params != "") {
                    params += "&";
                }
                params += key + "=" + encodeURIComponent(postData[key]);
            }

            let formRange = $('#formRange')
            let offset = parseInt(formRange.find('[name=dari]').val()) - 1
            let limit = parseInt(formRange.find('[name=sampai]').val().replace('.', '')) - offset
            params += `&offset=${offset}&limit=${limit}`

            if ($('#rangeModal').data('action') == 'export') {
                let xhr = new XMLHttpRequest()
                xhr.open('GET', `{{ config('app.api_url') }}piutangheader/export?${params}`, true)
                xhr.setRequestHeader("Authorization", `Bearer {{ session('access_token') }}`)
                xhr.responseType = 'arraybuffer'

                xhr.onload = function(e) {
                    if (this.status === 200) {
                        if (this.response !== undefined) {
                            let blob = new Blob([this.response], {
                                type: "application/vnd.ms-excel"
                            })
                            let link = document.createElement('a')

                            link.href = window.URL.createObjectURL(blob)
                            link.download = `laporanpengeluarantrucking${(new Date).getTime()}.xlsx`
                            link.click()

                            submitButton.removeAttr('disabled')
                        }
                    }
                }

                xhr.send()
            } else if ($('#rangeModal').data('action') == 'report') {
                window.open(`{{ route('piutangheader.report') }}?${params}`)

                submitButton.removeAttr('disabled')
            }
        })
    })

    function clearSelectedRows() {
        selectedRows = []
        selectedbukti = []

        $('#gs_').prop('checked', false);
        $('#jqGrid').trigger('reloadGrid')
    }

    function selectAllRows() {
        $.ajax({
            url: `${apiUrl}penerimaangiroheader`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: {
                limit: 0,
                tgldari: $('#tgldariheader').val(),
                tglsampai: $('#tglsampaiheader').val(),
                filters: $('#jqGrid').jqGrid('getGridParam', 'postData').filters
            },
            success: (response) => {
                selectedRows = response.data.map((datas) => datas.id)
                selectedbukti = response.data.map((datas) => datas.nobukti)
                $('#jqGrid').trigger('reloadGrid')
            }
        })
    }
</script>
@endpush()
@endsection