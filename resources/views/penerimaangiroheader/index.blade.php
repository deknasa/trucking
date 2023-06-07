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

                        </div>

                        <div id="jurnal-tab">

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

    $(document).ready(function() {
        $("#tabs").tabs()
        setRange()
        initDatepicker()
        $(document).on('click', '#btnReload', function(event) {
            loadDataHeader('penerimaangiroheader')
            selectedRows = []
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
                        label: 'NO. BUKTI',
                        name: 'nobukti',
                        align: 'left'
                    },
                    {
                        label: 'TGL BUKTI',
                        name: 'tglbukti',
                        align: 'left',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'PELANGGAN ',
                        name: 'pelanggan_id',
                        align: 'left'
                    },
                    
                    {
                        label: 'POSTING DARI',
                        name: 'postingdari',
                        align: 'left'
                    },
                    {
                        label: 'DITERIMA DARI',
                        name: 'diterimadari',
                        align: 'left'
                    },
                    {
                        label: 'TANGGAL LUNAS',
                        name: 'tgllunas',
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
                        align: 'left'
                    },
                    {
                        label: 'TGL APPROVAL',
                        name: 'tglapproval',
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
                        align: 'left'
                    },
                    {
                        label: 'TANGGAL BUKA CETAK',
                        name: 'tglbukacetak',
                        align: 'left',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'MODIFIEDBY',
                        name: 'modifiedby',
                        align: 'left'
                    },
                    {
                        label: 'CREATEDAT',
                        name: 'created_at',
                        align: 'left',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y H:i:s"
                        }
                    },
                    {
                        label: 'UPDATEDAT',
                        name: 'updated_at',
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
                    let nobukti = $('#jqGrid').jqGrid('getCell', id, 'nobukti')
                    $(`#tabs #${currentTab}-tab`).html('').load(`${appUrl}/penerimaangirodetail/${currentTab}/grid`, function() {
                        loadGrid(id, nobukti)
                    })
                    activeGrid = $(this)
                    indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
                    page = $(this).jqGrid('getGridParam', 'page')
                    let limit = $(this).jqGrid('getGridParam', 'postData').limit
                    if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))

                },
                loadComplete: function(data) {
                    changeJqGridRowListText()
                    if (data.data.length == 0) {
                        $('#detail').jqGrid('setGridParam', {
                            postData: {
                                penerimaangiro_id: 0,
                            },
                        }).trigger('reloadGrid');
                        $('#jurnalGrid').jqGrid('setGridParam', {
                            postData: {
                                nobukti: 0,
                            },
                        }).trigger('reloadGrid');
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
                    clearGlobalSearch($('#jqGrid'))
                },
            })

            .customPager({
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
                                showDialog('Please select a row')
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
                                showDialog('Please select a row')
                            } else {
                                cekValidasi(selectedId, 'DELETE')
                            }
                        }
                    },
                    {
                        id: 'report',
                        innerHTML: '<i class="fa fa-print"></i> REPORT',
                        class: 'btn btn-info btn-sm mr-1',
                        onClick: () => {

                            selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')
                            if (selectedId == null || selectedId == '' || selectedId == undefined) {
                                showDialog('Please select a row')
                            } else {
                                window.open(`{{ route('penerimaangiroheader.report') }}?id=${selectedId}`)
                            }
                            clearSelectedRows()
                            $('#gs_').prop('checked', false)
                        }
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
                                showDialog('Please select a row')
                            } else {
                                window.open(`{{ route('penerimaangiroheader.export') }}?id=${selectedId}`)
                            }
                            clearSelectedRows()
                            $('#gs_').prop('checked', false)
                        }
                    },
                    {
                        id: 'approveun',
                        innerHTML: '<i class="fas fa-check""></i> UN/APPROVAL',
                        class: 'btn btn-purple btn-sm mr-1',
                        onClick: () => {

                            approve()

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

        $('#approval .ui-pg-div')
            .addClass('btn btn-purple btn-sm')
            .css({
                'background': '#6619ff',
                'color': '#fff'
            })
            .parent().addClass('px-1')

        if (!`{{ $myAuth->hasPermission('penerimaangiroheader', 'store') }}`) {
            $('#add').attr('disabled', 'disabled')
        }

        if (!`{{ $myAuth->hasPermission('penerimaangiroheader', 'update') }}`) {
            $('#edit').attr('disabled', 'disabled')
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

        if (!`{{ $myAuth->hasPermission('penerimaangiroheader', 'approval') }}`) {
            $('#approveun').attr('disabled', 'disabled')
            $("#jqGrid").hideCol("");
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

        $("#tabs").on('click', 'li.ui-state-active', function() {
            let href = $(this).find('a').attr('href');
            currentTab = href.substring(1, href.length - 4);
            let giroId = $('#jqGrid').jqGrid('getGridParam', 'selrow')
            let nobukti = $('#jqGrid').jqGrid('getCell', giroId, 'nobukti')
            $(`#tabs #${currentTab}-tab`).html('').load(`${appUrl}/penerimaangirodetail/${currentTab}/grid`, function() {

                loadGrid(giroId, nobukti)
            })
        })
    })

    function clearSelectedRows() {
        selectedRows = []

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
                tglsampai: $('#tglsampaiheader').val()
            },
            success: (response) => {
                selectedRows = response.data.map((giro) => giro.id)
                $('#jqGrid').trigger('reloadGrid')
            }
        })
    }
</script>
@endpush()
@endsection