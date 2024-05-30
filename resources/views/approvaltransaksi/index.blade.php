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
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">Periode <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-sm-4">
                                <div class="input-group">
                                    <input type="text" name="periode" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    Proses data <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <select name="approve" id="approve" class="form-select select2bs4" style="width: 100%;">

                                </select>
                            </div>
                        </div>

                        <div class="row form-group">
                            <div class="col-12 col-sm-3 col-md-2">
                                <label class="col-form-label">
                                    Transaksi <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-12 col-sm-9 col-md-10">
                                <select name="transaksi" id="transaksi" class="form-select select2bs4" style="width: 100%;">

                                </select>
                            </div>
                        </div>

                        <div class="row mt-3">

                            <div class="col-sm-4">
                                <a id="btnReload" class="btn btn-primary mr-2">
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
@include('approvaltransaksi._detail')

@push('scripts')
<script>
    let indexUrl = "{{ route('approvaltransaksiheader.index') }}"
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

        initSelect2($('#crudForm').find('[name=approve]'), false)
        initSelect2($('#crudForm').find('[name=transaksi]'), false)

        setStatusApprovalOptions($('#crudForm'))
        setTransaksiOptions($('#crudForm'))
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
            .addClass("btn btn-primary").html(`
			<i class="fa fa-calendar-alt"></i>
		`);

        showDefault($('#crudForm'))

        $(document).on('click', '#btnReload', function(event) {


            $('#jqGrid').jqGrid('setGridParam', {
                postData: {
                    periode: $('#crudForm').find('[name=periode]').val(),
                    approve: $('#crudForm').find('[name=approve]').val(),
                    transaksi: $('#crudForm').find('[name=transaksi]').val(),
                    year: '',
                    month: ''
                },
            }).trigger('reloadGrid');

            $.jgrid.gridUnload("#detail")
            api = '';
            loadDetailGrid($('#crudForm').find('[name=transaksi]').val())
        })
       
    })

    function approve() {

        event.preventDefault()

        let method
        let url
        let form = $('#crudForm')
        let data = $('#crudForm').serializeArray()

        $.each(selectedRows, function(index, item) {
            data.push({
                name: 'transaksiId[]',
                value: item
            })
        });
        console.log(data);
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
        $('#processingLoader').removeClass('d-none')

        $.ajax({
            url: `${apiUrl}approvaltransaksiheader`,
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
                $('#crudForm').find('[name=approve]').val(data.approve)
                $('#crudForm').find('[name=transaksi]').val(data.transaksi)
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

    }

    function grid() {
        $("#jqGrid").jqGrid({
                url: `{{ config('app.api_url') . 'approvaltransaksiheader' }}`,
                mtype: "GET",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                postData: {
                    periode: $('#crudForm').find('[name=periode]').val(),
                    approve: $('#crudForm').find('[name=approve]').val(),
                    transaksi: $('#crudForm').find('[name=transaksi]').val(),
                    year: '',
                    month: ''
                },
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
                        width: 70,
                        align: 'center',
                        formatoptions: {
                            disabled: false
                        },
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

                            let formattedValue = $(`
                <div class="badge" style="background-color: ${statusApproval.WARNA}; color: #fff;">
                  <span>${statusApproval.SINGKATAN}</span>
                </div>
              `)

                            return formattedValue[0].outerHTML
                        },
                        cellattr: (rowId, value, rowObject) => {
                            let statusApproval = JSON.parse(rowObject.statusapproval)

                            return ` title="${statusApproval.MEMO}"`
                        }
                    },
                    {
                        label: 'ID',
                        name: 'id',
                        align: 'right',
                        width: '50px',
                        hidden: true
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
                        label: 'POSTING DARI',
                        name: 'postingdari',
                        align: 'left'
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
                            newformat: "d-m-Y H:i:s"
                        }
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

                    let jenisTransaksi = $('#crudForm').find('[name=transaksi]').val()
                    loadDetailData(id, jenisTransaksi)

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
                    innerHTML: '<i class="fas fa-check"></i> APPROVAL/UN',
                    class: 'btn btn-purple btn-sm mr-1',
                    onClick: () => {

                        approve()

                    }
                }]
            })


        /* Append clear filter button */
        loadClearFilter($('#jqGrid'))

        /* Append global search */
        loadGlobalSearch($('#jqGrid'))

        if (!`{{ $myAuth->hasPermission('approvaltransaksiheader', 'store') }}`) {
            $('#approveun').attr('disabled', 'disabled')
        }
    }

    function showDefault(form) {
        $.ajax({
            url: `${apiUrl}approvaltransaksiheader/default`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            success: response => {

                $.each(response.data, (index, value) => {
                    console.log(value)
                    let element = form.find(`[name="${index}"]`)

                    if (element.is('select')) {
                        element.val(value).trigger('change')
                    } else {
                        element.val(value)
                    }
                })

                grid()
                loadDetailGrid($('#crudForm').find('[name=transaksi]').val())
            }
        })
    }
    const setStatusApprovalOptions = function(relatedForm) {
        // return new Promise((resolve, reject) => {
        // relatedForm.find('[name=approve]').empty()
        relatedForm.find('[name=approve]').append(
            new Option('-- PILIH STATUS APPROVAL --', '', false, true)
        ).trigger('change')

        let data = [];
        data.push({
            name: 'grp',
            value: 'STATUS APPROVAL'
        })
        data.push({
            name: 'subgrp',
            value: 'STATUS APPROVAL'
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
                    relatedForm.find('[name=approve]').append(option).trigger('change')
                });

                // relatedForm
                //     .find('[name=approve]')
                //     .val($(`#crudForm [name=approve] option:eq(1)`).val())
                //     .trigger('change')
                //     .trigger('select2:selected');

                // resolve()
            }
        })
        // })
    }
    const setTransaksiOptions = function(relatedForm) {
        relatedForm.find('[name=transaksi]').append(
            new Option('-- PILIH TRANSAKSI --', '', false, true)
        ).trigger('change')

        let data = [];
        data.push({
            name: 'grp',
            value: 'PENERIMAAN KAS'
        })
        // data.push({
        //     name: 'subgrp',
        //     value: 'STATUS APPROVAL'
        // })
        $.ajax({
            url: `${apiUrl}approvaltransaksiheader/combo`,
            method: 'GET',
            dataType: 'JSON',
            headers: {
                Authorization: `Bearer ${accessToken}`
            },
            data: data,
            success: response => {

                response.data.forEach(statusApproval => {
                    let option = new Option(statusApproval.kelompok, statusApproval.kelompok)
                    relatedForm.find('[name=transaksi]').append(option).trigger('change')
                });

                // relatedForm
                //     .find('[name=transaksi]')
                //     .val($(`#crudForm [name=transaksi] option:eq(1)`).val())
                //     .trigger('change')
                //     .trigger('select2:selected');

                // resolve()
            }
        })
        // })
    }
</script>
@endpush()
@endsection