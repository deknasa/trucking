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
                    <div id="tabs" class="open-sans">
                        <ul>
                            <li><a href="#detail-tab">Details</a></li>
                            <li><a href="#hutang-tab">Hutang</a></li>
                            <li><a href="#jurnal-tab">Jurnal</a></li>
                        </ul>
                        <div id="detail-tab">
                            <table id="detailGrid"></table>
                        </div>
                        <div id="hutang-tab">
                            <table id="hutangGrid"></table>
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

<!-- Detail -->

@include('hutangextraheader._detail')
@include('hutangextraheader._hutang')
@include('jurnalumum._jurnal')

@include('hutangextraheader._modal')
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
    let currentTab = 'detail'
    let selectedRows = [];

    function checkboxHandler(element) {
        let value = $(element).val();
        if (element.checked) {
            selectedRows.push($(element).val())
            $(element).parents('tr').addClass('bg-light-blue')
        } else {
            $(element).parents('tr').removeClass('bg-light-blue')
            for (var i = 0; i < selectedRows.length; i++) {
                if (selectedRows[i] == value) {
                    selectedRows.splice(i, 1);
                }
            }
        }

    }

    setSpaceBarCheckedHandler()
    reloadGrid()

    $(document).ready(function() {
        $("#tabs").tabs()

        let nobukti = $('#jqGrid').jqGrid('getCell', id, 'hutang_nobukti')
        loadDetailGrid()
        loadHutangGrid()
        loadJurnalUmumGrid(nobukti)

        setRange()
        initDatepicker('datepickerIndex')
        $(document).on('click', '#btnReload', function(event) {
            loadDataHeader('hutangextraheader')
        })

        $("#jqGrid").jqGrid({
                url: `${apiUrl}hutangextraheader`,
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
                        width: 40,
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
                                $(element).addClass('checkbox-selectall')

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
                            return `<input type="checkbox" name="hutangId[]" class="checkbox-jqgrid" value="${rowData.id}" onchange="checkboxHandler(this)">`
                        },
                    },
                    {

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
                        align: 'left',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
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
                                return ` title=""`
                            }
                            return ` title="${statusApproval.MEMO}"`
                        }
                    },
                    {
                        label: 'STATUS CETAK',
                        name: 'statuscetak',
                        align: 'left',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
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

                            let formattedValue = $(`
                            <div class="badge" style="background-color: ${statusCetak.WARNA}; color: #fff;">
                            <span>${statusCetak.SINGKATAN}</span>
                            </div>
                        `)

                            return formattedValue[0].outerHTML
                        },
                        cellattr: (rowId, value, rowObject) => {
                            let statusCetak = JSON.parse(rowObject.statuscetak)

                            return ` title="${statusCetak.MEMO}"`
                        }
                    },
                    {
                        label: 'NO BUKTI',
                        name: 'nobukti',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left'
                    },
                    {
                        label: 'TGL BUKTI',
                        name: 'tglbukti',
                        align: 'left',
                        formatter: "date",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'POSTING DARI',
                        name: 'postingdari',
                        width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
                        align: 'left'
                    },
                    {
                        label: 'NO BUKTI HUTANG',
                        name: 'hutang_nobukti',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left',
                        formatter: (value, options, rowData) => {
                            if ((value == null) || (value == '')) {
                                return '';
                            }
                            let tgldari = rowData.tgldariheaderhutangheader
                            let tglsampai = rowData.tglsampaiheaderhutangheader
                            let url = "{{route('hutangheader.index')}}"
                            let formattedValue = $(`
                            <a href="${url}?tgldari=${tgldari}&tglsampai=${tglsampai}" class="link-color" target="_blank">${value}</a>
                           `)
                            return formattedValue[0].outerHTML
                        }
                    },
                    {
                        label: 'NAMA PERKIRAAN',
                        name: 'coa',
                        width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
                        align: 'left'
                    },
                    {
                        label: 'SUPPLIER',
                        name: 'supplier_id',
                        align: 'left'
                    },
                    {
                        label: 'TOTAL',
                        name: 'total',
                        align: 'right',
                        formatter: currencyFormat,
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
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
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
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
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                        align: 'left',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
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
                    let nobukti = $(`#jqGrid tr#${id}`).find(`td[aria-describedby="jqGrid_hutang_nobukti"]`).attr('title') ?? '';

                    activeGrid = $(this)
                    indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
                    page = $(this).jqGrid('getGridParam', 'page')
                    let limit = $(this).jqGrid('getGridParam', 'postData').limit
                    if (indexRow >= limit) {
                        indexRow = (indexRow - limit * (page - 1))
                    }
                    loadDetailData(id)
                    loadHutangData(nobukti)
                    loadJurnalUmumData(id, nobukti)
                },
                loadComplete: function(data) {
                    changeJqGridRowListText()

                    if (data.data.length === 0) {
                        $('#detailGrid, #hutangGrid, #jurnalGrid').each((index, element) => {
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
                                        cekValidasi(selectedId, 'PRINTER BESAR')
                                    }
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
                                        cekValidasi(selectedId, 'PRINTER KECIL')
                                    }
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
                                window.open(`{{ route('hutangextraheader.export') }}?id=${selectedId}`)
                            }
                        }
                    },
                    {
                        id: 'approveun',
                        innerHTML: '<i class="fas fa-check"></i> APPROVAL/UN',
                        class: 'btn btn-purple btn-sm mr-1',
                        onClick: () => {

                            approve()

                        }
                    },
                ],
                buttons: [{
                        id: 'add',
                        innerHTML: '<i class="fa fa-plus"></i> ADD',
                        class: 'btn btn-primary btn-sm mr-1',
                        onClick: function(event) {
                            createHutangExtraHeader()
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

                            viewHutangExtraHeader(selectedId)
                        }
                    },
                ]

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

        function permission() {
            if (!`{{ $myAuth->hasPermission('hutangextraheader', 'store') }}`) {
                $('#add').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('hutangextraheader', 'show') }}`) {
                $('#view').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('hutangextraheader', 'update') }}`) {
                $('#edit').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('hutangextraheader', 'destroy') }}`) {
                $('#delete').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('hutangextraheader', 'export') }}`) {
                $('#export').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('hutangextraheader', 'report') }}`) {
                $('#report').attr('disabled', 'disabled')
            }
            if (!`{{ $myAuth->hasPermission('hutangextraheader', 'approval') }}`) {
                $('#approval').addClass('ui-disabled')
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
                digitGroupSeparator: ',',
                decimalCharacter: '.',
                decimalPlaces: 0,
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
                xhr.open('GET', `{{ config('app.api_url') }}hutangextraheader/export?${params}`, true)
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
                            link.download = `laporanhutangextra${(new Date).getTime()}.xlsx`
                            link.click()

                            submitButton.removeAttr('disabled')
                        }
                    }
                }

                xhr.send()
            } else if ($('#rangeModal').data('action') == 'report') {
                window.open(`{{ route('hutangextraheader.report') }}?${params}`)

                submitButton.removeAttr('disabled')
            }
        })
    })


    function clearSelectedRows() {
        selectedRows = []

        $('#jqGrid').trigger('reloadGrid')
    }

    function selectAllRows() {
        $.ajax({
            url: `${apiUrl}hutangextraheader`,
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
                selectedRows = response.data.map((hutang) => hutang.id)
                $('#jqGrid').trigger('reloadGrid')
            }
        })
    }
</script>
@endpush()
@endsection