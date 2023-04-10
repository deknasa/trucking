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
                            <div class="col-sm-4 mt-2">
                                <a id="btnReload" class="btn btn-secondary mr-2">
                                    <i class="fas fa-sync"></i>
                                    Reload
                                </a>
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
@include('pencairangiropengeluaran._detail')

@push('scripts')
<script>
    let indexUrl = "{{ route('pencairangiropengeluaranheader.index') }}"
    let getUrl = "{{ route('pencairangiropengeluaranheader.get') }}"
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
                `<div class="input-group-append"></div>`)
            .addClass("btn btn-primary").html(`
			    <i class="fa fa-calendar-alt"></i>
		    `);


        $(document).on('click', '#btnReload', function(event) {
            console.log(selectedRows)
            $('#jqGrid').jqGrid('setGridParam', {
                postData: {
                    periode: $('#crudForm').find('[name=periode]').val(),
                },
            }).trigger('reloadGrid');
        })

        function approve() {

            event.preventDefault()

            let method
            let url
            let form = $('#crudForm')
            let data = $('#crudForm').serializeArray()

            $.each(selectedRows, function(index, item) {
                data.push({
                    name: 'pengeluaranId[]',
                    value: item
                })
            });

            data.push({
                name: 'sortIndex',
                value: $('#jqGrid').getGridParam().sortname
            })
            data.push({
                name: 'sortOrder',
                value: $('#jqGrid').getGridParam().sortorder
            })
            data.push({
                name: 'filters',
                value: $('#jqGrid').getGridParam('postData').filters
            })
            data.push({
                name: 'indexRow',
                value: indexRow
            })
            data.push({
                name: 'page',
                value: page
            })
            data.push({
                name: 'limit',
                value: limit
            })


            $(this).attr('disabled', '')
            $('#loader').removeClass('d-none')

            $.ajax({
                url: `${apiUrl}pencairangiropengeluaranheader`,
                method: 'POST',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: data,
                success: response => {
                    $('#crudForm').trigger('reset')
                    $('#crudModal').modal('hide')

                    $('#jqGrid').jqGrid().trigger('reloadGrid');
                    let data = $('#jqGrid').jqGrid("getGridParam", "postData");
                    $('#crudForm').find('[name=periode]').val(data.periode)
                    selectedRows = []
                },
                error: error => {

                    if (error.status === 422) {
                        $('.is-invalid').removeClass('is-invalid')
                        $('.invalid-feedback').remove()
                        $('#crudForm').find('[name=periode]').val(data.periode)
                        setErrorMessages(form, error.responseJSON.errors);
                    } else {
                        showDialog(error.responseJSON.message)
                    }
                    $('#crudForm').find('[name=periode]').val($.datepicker.formatDate('mm-yy', new Date())).trigger('change');
                },
            }).always(() => {
                $('#loader').addClass('d-none')
                $(this).removeAttr('disabled')
            })

        }


        // $(document).on('click', '#jqGrid_nextPageButton', function(event) {
        //     $('#jqGrid tbody tr').each(function(row, tr) {
        //         if ($(this).find(`td input:checkbox`).is(':checked')) {
        //             selectedRows.push($(this).find(`td input:checkbox`).val())
        //         }
        //     })
        // })
        // $(document).on('click', '#jqGrid_previousPageButton', function(event) {
        //     $('#jqGrid tbody tr').each(function(row, tr) {
        //         if ($(this).find(`td input:checkbox`).is(':checked')) {
        //             selectedRows.push($(this).find(`td input:checkbox`).val())
        //         }
        //     })
        // })

        $("#jqGrid").jqGrid({
                url: `{{ config('app.api_url') . 'pencairangiropengeluaranheader' }}`,
                mtype: "GET",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                datatype: "json",
                colModel: [{
                        label: 'Pilih',
                        name: 'id',
                        index: 'Pilih',
                        formatter: (value) => {
                            return `<input type="checkbox" value="${value}" onchange="checkboxHandler(this)">`
                        },
                        editable: true,
                        edittype: 'checkbox',
                        search: false,
                        width: 60,
                        align: 'center',
                        formatoptions: {
                            disabled: false
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
                            if (value != null) {

                                let statusApproval = JSON.parse(value)

                                let formattedValue = $(`
                                    <div class="badge" style="background-color: ${statusApproval.WARNA}; color: #fff;">
                                    <span>${statusApproval.SINGKATAN}</span>
                                    </div>
                                `)

                                return formattedValue[0].outerHTML
                            } else {
                                let nullValue = $(`
                                    <div> </div>
                                `)

                                return nullValue[0].outerHTML
                            }
                        },
                        cellattr: (rowId, value, rowObject) => {
                            let statusApproval = JSON.parse(rowObject.statusapproval)
                            if (statusApproval != null) {
                                return ` title="${statusApproval.MEMO}"`
                            }
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
                        label: 'NO. BUKTI PENGELUARAN',
                        name: 'pengeluaran_nobukti',
                        align: 'left'
                    },
                    {
                        label: 'ALAT BAYAR',
                        name: 'alatbayar_id',
                        align: 'left'
                    },
                    {
                        label: 'BANK',
                        name: 'bank_id',
                        align: 'left'
                    },
                    {
                        label: 'DIBAYAR KE',
                        name: 'dibayarke',
                        align: 'left'
                    },
                    {
                        label: 'NOMINAL',
                        name: 'nominal',
                        align: 'right',
                        formatter: currencyFormat
                    },
                    {
                        label: 'MODIFIEDBY',
                        name: 'modifiedby',
                        align: 'left'
                    },
                    {
                        label: 'CREATEDAT',
                        name: 'created_at',
                        align: 'right',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y H:i:s"
                        }
                    },
                    {
                        label: 'UPDATEDAT',
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
                postData: {
                    periode: $('#crudForm').find('[name=periode]').val(),
                },
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
                loadBeforeSend: (jqXHR) => {
                    jqXHR.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`)
                },
                onSelectRow: function(id, status) {

                    activeGrid = $(this)
                    indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
                    page = $(this).jqGrid('getGridParam', 'page')
                    let limit = $(this).jqGrid('getGridParam', 'postData').limit
                    if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))

                    if (!hasDetail) {
                        loadDetailGrid(id)
                        hasDetail = true
                    }
                    loadDetailData(id)

                },
                loadComplete: function(data) {
                    changeJqGridRowListText()
                    $(document).unbind('keydown')
                    setCustomBindKeys($(this))
                    initResize($(this))

                    //CHECKED STAY STILL
                    $.each(selectedRows, function(key, value) {

                        $('#jqGrid tbody tr').each(function(row, tr) {
                            if ($(this).find(`td input:checkbox`).val() == value) {
                                $(this).find(`td input:checkbox`).prop('checked', true)
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
                    id: 'approveun',
                    innerHTML: '<i class="fa fa-plus"></i> ADD',
                    class: 'btn btn-primary btn-sm mr-1',
                    onClick: () => {

                        approve()

                    }
                }]
            })



        /* Append clear filter button */
        loadClearFilter($('#jqGrid'))

        /* Append global search */
        loadGlobalSearch($('#jqGrid'))
        if (!`{{ $myAuth->hasPermission('pencairangiropengeluaranheader', 'store') }}`) {
            $('#add').attr('disabled', 'disabled')
        }


    })
</script>
@endpush()
@endsection