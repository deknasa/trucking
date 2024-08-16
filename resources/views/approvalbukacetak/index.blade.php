@extends('layouts.master')

@section('content')

<style>
    .ui-datepicker-calendar {
        display: none;
    }
</style>
<!-- Grid -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-easyui bordered mb-4">
                <div class="card-header">
                </div>
                <form id="crudForm">
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Periode<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="periode" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Transaksi<span class="text-danger">*</span></label>

                            <div class="col-12 col-sm-9 col-md-10">
                                <select name="table" id="table" class="form-select select2bs4" style="width: 100%;">

                                </select>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-sm-4 mt-2">
                                <a id="btnReload" class="btn btn-primary mr-2 ">
                                    <i class="fas fa-sync"></i>
                                    Reload
                                </a>
                                <!-- <button id="btnSubmit" class="btn btn-primary ">
                                    <i class="fa fa-save"></i>
                                    Proses
                                </button> -->
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <table id="jqGrid"></table>
        </div>
    </div>
</div>
<!-- Detail -->
{{-- @include('approvalbukacetak._detail') --}}

@push('scripts')
<script>
    let indexUrl = "{{ route('approvalbukacetak.index') }}"
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

        initSelect2($('#crudForm').find('[name=cetak]'), false)
        initSelect2($('#crudForm').find('[name=table]'), false)

        setStatusApprovalOptions($('#crudForm'))
        setStatusInvoiceOptions($('#crudForm'))
        $('#crudForm').find('[name=periode]').val($.datepicker.formatDate('mm-yy', new Date())).trigger('change');

        $('.datepicker').datepicker({
                changeMonth: true,
                changeYear: true,
                showButtonPanel: true,
                showOn: "button",
                dateFormat: 'mm-yy',
                onClose: function(dateText, inst) {
                    $(this).datepicker('setDate', new Date(inst.selectedYear, inst.selectedMonth, 1));
                }
            }).siblings(".ui-datepicker-trigger")
            .wrap(
                `
			<div class="input-group-append">
			</div>
		`
            )
            .addClass("btn btn-easyui text-easyui-dark").html(`
			<i class="fa fa-calendar-alt"></i>
		`);

        $('#cetak').on('select2:selected', function() {

        })

        loadGrid()


        $('#btnSubmit').click(function(event) {
            event.preventDefault()
            let method
            let url
            let form = $('#crudForm')
            let data = $('#crudForm').serializeArray()

            $(this).attr('disabled', '')
            $('#processingLoader').removeClass('d-none')

            $.ajax({
                url: `${apiUrl}approvalbukacetak`,
                method: 'POST',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    tableId: selectedRows,
                    periode: $('#crudForm').find('[name=periode]').val(),
                    table: $('#crudForm').find('[name=table]').val(),
                    info : info
                },
                success: response => {
                    $('.is-invalid').removeClass('is-invalid')
                    $('.invalid-feedback').remove()
                    $('#crudForm').trigger('reset')
                    $('#crudModal').modal('hide')


                    $('#jqGrid').jqGrid().trigger('reloadGrid');
                    let data = $('#jqGrid').jqGrid("getGridParam", "postData");

                    $('#crudForm').find('[name=periode]').val(data.periode)
                    $('#crudForm').find('[name=cetak]').val(data.cetak)
                    $('#crudForm').find('[name=table]').val(data.table)
                    selectedRows = []
                },
                error: error => {
                    if (error.status === 422) {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()

                        setErrorMessages(form, error.responseJSON.errors);
                    } else {
                        showDialog(error.statusText)
                    }
                },
            }).always(() => {
                $('#processingLoader').addClass('d-none')
                $(this).removeAttr('disabled')
            })

        })

    })

    $(document).on('click', '#btnReload', function(event) {
        getData()
            .then((response) => {
                $('#jqGrid').jqGrid('setGridParam', {
                    url: `{{ config('app.api_url') . 'approvalbukacetak' }}`,
                    datatype: "json",
                    postData: {
                        periode: $('#crudForm').find('[name=periode]').val(),
                        cetak: $('#crudForm').find('[name=cetak]').val(),
                        table: $('#crudForm').find('[name=table]').val(),
                    },
                }).trigger('reloadGrid');
            })
            .catch((errors) => {
                setErrorMessages($('#crudForm'), errors)
            })
    })

    function loadGrid() {
        $("#jqGrid").jqGrid({
                mtype: "GET",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                datatype: "local",
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

                                $(element).attr('disabled', true)
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
                            return `<input type="checkbox" name="tableId[]" value="${rowData.id}" onchange="checkboxHandler(this)">`
                        },
                    },
                    {
                        label: 'ID',
                        name: 'id',
                        align: 'right',
                        width: '50px',
                        hidden: true,
                        search: false
                    },
                    {
                        label: 'STATUS CETAK',
                        name: 'statuscetak',
                        align: 'left',

                        formatter: (value, options, rowData) => {
                            let statuscetak = JSON.parse(value)
                            if (!statuscetak) {
                                return ''
                            }
                            let formattedValue = $(`
                            <div class="badge" style="background-color: ${statuscetak.WARNA}; color: #fff;">
                              <span>${statuscetak.SINGKATAN}</span>
                            </div>
                          `)

                            return formattedValue[0].outerHTML
                        },
                        cellattr: (rowId, value, rowObject) => {
                            let statuscetak = JSON.parse(rowObject.statuscetak)
                            if (!statuscetak) {
                                return ` title=" "`
                            }
                            return ` title="${statuscetak.MEMO}"`
                        }
                    },
                    {
                        label: 'NO BUKTI',
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
                        label: 'KETERANGAN',
                        name: 'keterangan',
                        align: 'left'
                    },
                    {
                        label: 'USER CETAK',
                        name: 'userbukacetak',
                        align: 'left'
                    },
                    {
                        label: 'MODIFIED BY',
                        name: 'modifiedby',
                        align: 'left'
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

                    activeGrid = $(this)
                    indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
                    page = $(this).jqGrid('getGridParam', 'page')
                    let limit = $(this).jqGrid('getGridParam', 'postData').limit
                    if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))

                    // let jenisTable = $('#crudForm').find('[name=table]').val()
                    // if (!hasDetail) {
                    //     loadDetailGrid(id,jenisTable)
                    //     hasDetail = true
                    // }
                    // loadDetailData(id, jenisTable)

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
                    if (data.data != undefined) {
                        if (data.data.length != 0) {
                            $('#gs_').attr('disabled', false)
                        }
                    }
                    $('#left-nav').find('button').attr('disabled', false)
                    permission()
                    setHighlight($(this))
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
                    $('#left-nav').attr('disabled', 'disabled')
                    clearGlobalSearch($('#jqGrid'))
                },
            })

            .customPager({
                buttons: [{
                    id: 'btnSubmit',
                    innerHTML: '<i class="fas fa-check"></i> APPROVAL',
                    class: 'btn btn-purple btn-sm mr-1',
                }]
            })

        /* Append clear filter button */
        loadClearFilter($('#jqGrid'))

        /* Append global search */
        loadGlobalSearch($('#jqGrid'))

        function permission() {
            if (!`{{ $myAuth->hasPermission('approvalbukacetak', 'approvalbukacetak') }}`) {
                $('#btnSubmit').attr('disabled', 'disabled')
            }
        }
    }

    function getData() {
        return new Promise((resolve, reject) => {
            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
            $.ajax({
                url: `${apiUrl}approvalbukacetak`,
                dataType: "JSON",
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    periode: $('#crudForm').find('[name=periode]').val(),
                    cetak: $('#crudForm').find('[name=cetak]').val(),
                    table: $('#crudForm').find('[name=table]').val(),
                },
                success: (response) => {
                    console.log(response)
                    resolve(response);
                },
                error: error => {
                    if (error.status === 422) {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()
                        errors = error.responseJSON.errors
                        reject(errors)
                    } else {
                        showDialog(error.statusText)
                    }
                    reject(error)
                }
            })
        })
    }

    const setStatusApprovalOptions = function(relatedForm) {
        // return new Promise((resolve, reject) => {
        // relatedForm.find('[name=cetak]').empty()
        relatedForm.find('[name=cetak]').append(
            new Option('-- PILIH STATUS CETAK --', '', false, true)
        ).trigger('change')

        let data = [];
        data.push({
            name: 'grp',
            value: 'STATUSCETAK'
        })
        data.push({
            name: 'subgrp',
            value: 'STATUSCETAK'
        })
        $.ajax({
            url: `${apiUrl}parameter/combo`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: data,
            success: response => {

                response.data.forEach(statusApproval => {
                    let option = new Option(statusApproval.text, statusApproval.id)
                    relatedForm.find('[name=cetak]').append(option).trigger('change')
                });

                // relatedForm
                //     .find('[name=cetak]')
                //     .val($(`#crudForm [name=cetak] option:eq(1)`).val())
                //     .trigger('change')
                //     .trigger('select2:selected');

                // resolve()
            }
        })
        // })
    }
    const setStatusInvoiceOptions = function(relatedForm) {
        // return new Promise((resolve, reject) => {
        // relatedForm.find('[name=cetak]').empty()
        relatedForm.find('[name=table]').append(
            new Option('-- PILIH DATA TRANSAKSI --', '', false, true)
        ).trigger('change')

        let data = [];
        data.push({
            name: 'grp',
            value: 'CETAKULANG'
        })
        data.push({
            name: 'subgrp',
            value: 'CETAKULANG'
        })
        $.ajax({
            url: `${apiUrl}parameter/combo`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: data,
            success: response => {

                response.data.forEach(statusApproval => {
                    let memo = JSON.parse(statusApproval.memo)
                    let option = new Option(memo.MEMO, statusApproval.text)
                    relatedForm.find('[name=table]').append(option).trigger('change')
                });

                // relatedForm
                //     .find('[name=cetak]')
                //     .val($(`#crudForm [name=cetak] option:eq(1)`).val())
                //     .trigger('change')
                //     .trigger('select2:selected');

                // resolve()
            }
        })
        // })
    }

    function clearSelectedRows() {
        selectedRows = []

        $('#jqGrid').trigger('reloadGrid')
    }

    function selectAllRows() {
        getData()
            .then((response) => {
                selectedRows = response.data.map((rows) => rows.id)
                $('#jqGrid').trigger('reloadGrid')
            })
            .catch((errors) => {
                setErrorMessages($('#crudForm'), errors)
            })

    }
</script>
@endpush()
@endsection