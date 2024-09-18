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

@include('customer._modal')

@push('scripts')
<script>
    let indexRow = 0;
    let page = 0;
    let popup = "";
    let id = "";
    let triggerClick = true;
    let highlightSearch;
    let totalRecord
    let limit
    let postData
    let sortname = 'kodeagen'
    let sortorder = 'asc'
    let autoNumericElements = []
    let rowNum = 10
    let selectedRows = [];
    let selectedRowsCustomer = [];


    function checkboxHandler(element) {
        let value = $(element).val();
        if (element.checked) {
            selectedRows.push($(element).val())
            selectedRowsCustomer.push($(element).parents('tr').find(`td[aria-describedby="jqGrid_kodeagen"]`).text())
            $(element).parents('tr').addClass('bg-light-blue')


        } else {
            $(element).parents('tr').removeClass('bg-light-blue')
            for (var i = 0; i < selectedRows.length; i++) {
                if (selectedRows[i] == value) {
                    selectedRows.splice(i, 1);
                    selectedRowsCustomer.splice(i, 1);
                }
            }
        }

    }

    $(document).ready(function() {
        $("#jqGrid").jqGrid({
                url: `${apiUrl}customer`,
                mtype: "GET",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                datatype: "json",
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
                        label: 'KODE CUSTOMER',
                        name: 'kodeagen',
                        width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
                    },
                    {
                        label: 'NAMA CUSTOMER',
                        name: 'namaagen',
                        width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
                    },
                    {
                        label: 'KETERANGAN',
                        name: 'keterangan',
                        width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
                    },
                    {
                        label: 'STATUS',
                        name: 'statusaktif',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        stype: 'select',
                        searchoptions: {
                            value: `:ALL;<?php
                                            $i = 1;

                                            foreach ($combo['statusaktif'] as $statusaktif) :
                                                echo "$statusaktif[text]:$statusaktif[text]";

                                                if ($i !== count($combo['statusaktif'])) {
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
                        label: 'NAMA PERUSAHAAN',
                        name: 'namaperusahaan',
                        width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
                    },
                    {
                        label: 'ALAMAT',
                        name: 'alamat',
                        width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
                    },
                    {
                        label: 'NO TELEPON / HANDPHONE',
                        name: 'notelp',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
                    },
                    {
                        label: 'NAMA KONTAK',
                        name: 'contactperson',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                    },
                    {
                        label: 'STATUS PEMBAYARAN (TOP)',
                        name: 'top',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
                        align: 'right',
                        formatter: currencyFormat
                    },
                    {
                        label: 'STATUS APPROVAL',
                        name: 'statusapproval',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        stype: 'select',
                        searchoptions: {
                            value: `:ALL;<?php
                                            $i = 1;

                                            foreach ($combo['statusapproval'] as $statusapproval) :
                                                echo "$statusapproval[text]:$statusapproval[text]";

                                                if ($i !== count($combo['statusapproval'])) {
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
                        label: 'USER APPROVAL',
                        name: 'userapproval',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
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
                        label: 'STATUS TAS',
                        name: 'statustas',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        stype: 'select',
                        searchoptions: {
                            value: `:ALL;<?php
                                            $i = 1;

                                            foreach ($combo['statustas'] as $statustas) :
                                                echo "$statustas[text]:$statustas[text]";

                                                if ($i !== count($combo['statustas'])) {
                                                    echo ';';
                                                }
                                                $i++;
                                            endforeach;

                                            ?>
                                 `,
                            dataInit: function(element) {
                                initSelect2($(element), false)
                                // $(element).select2({
                                //   width: 'resolve',
                                //   theme: "bootstrap4"
                                // },false);
                            }
                        },
                        formatter: (value, options, rowData) => {
                            let statusTas = JSON.parse(value)
                            if (!statusTas) {
                                return ''
                            }

                            let formattedValue = $(`
                                        <div class="badge" style="background-color: ${statusTas.WARNA}; color: #fff;">
                                        <span>${statusTas.SINGKATAN}</span>
                                        </div>
                                    `)

                            return formattedValue[0].outerHTML
                        },
                        cellattr: (rowId, value, rowObject) => {
                            let statusTas = JSON.parse(rowObject.statustas)
                            if (!statusTas) {
                                return ` title=""`
                            }

                            return ` title="${statusTas.MEMO}"`
                        }
                    },

                    {
                        label: 'STATUS INV. EXTRA',
                        name: 'statusinvoiceextra',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        stype: 'select',
                        searchoptions: {
                            value: `:ALL;<?php
                                            $i = 1;

                                            foreach ($combo['statusaktif'] as $statusaktif) :
                                                echo "$statusaktif[text]:$statusaktif[text]";

                                                if ($i !== count($combo['statusaktif'])) {
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
                            let statusAktif = JSON.parse(value)
                            if (!statusAktif) {
                                return ''
                            }

                            let formattedValue = $(`
                                            <div class="badge" style="background-color: ${statusAktif.WARNA}; color: ${statusAktif.WARNATULISAN};">
                                            <span>${statusAktif.SINGKATAN}</span>
                                            </div>
                                        `)

                            return formattedValue[0].outerHTML
                        },
                        cellattr: (rowId, value, rowObject) => {
                            let statusAktif = JSON.parse(rowObject.statusinvoiceextra)

                            if (!statusAktif) {
                                return ` title=""`
                            }
                            return ` title="${statusAktif.MEMO}"`
                        }
                    },
                    {
                        label: 'MODIFIED BY',
                        name: 'modifiedby',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                    },
                    {
                        label: 'CREATED AT',
                        name: 'created_at',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
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
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
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
                    let rows = $(this).jqGrid('getGridParam', 'postData').limit
                    if (indexRow >= rows) indexRow = (indexRow - rows * (page - 1))
                },
                loadComplete: function(data) {
                    changeJqGridRowListText()
                    if (data.data.length === 0) {
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
                            createAgen()
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
                                cekValidasidelete(selectedId, 'edit')
                                // editAgen(selectedId)
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
                                cekValidasidelete(selectedId, 'delete')
                            }
                        }
                    },
                    {
                        id: 'view',
                        innerHTML: '<i class="fa fa-eye"></i> VIEW',
                        class: 'btn btn-orange btn-sm mr-1',
                        onClick: () => {
                            selectedId = $("#jqGrid").jqGrid('getGridParam', 'selrow')

                            viewAgen(selectedId)
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
                            text: "APPROVAL/UN Data",
                            color: `<?php echo $combo['listbtn']->btn->approvaldata; ?>`,
                            hidden: (!`{{ $myAuth->hasPermission('customer', 'approval') }}`),
                            onClick: () => {
                                approve()
                            }
                        }, {
                            id: 'approvalaktif',
                            text: "APPROVAL AKTIF",
                            color: `<?php echo $combo['listbtn']->btn->approvalaktif; ?>`,
                            hidden: (!`{{ $myAuth->hasPermission('customer', 'approvalaktif') }}`),
                            onClick: () => {
                                if (`{{ $myAuth->hasPermission('customer', 'approvalaktif') }}`) {
                                    approvalAktif('customer')

                                }
                            }
                        },
                        {
                            id: 'approvalnonaktif',
                            text: "APPROVAL NON AKTIF",
                            color: `<?php echo $combo['listbtn']->btn->approvalnonaktif; ?>`,
                            hidden: (!`{{ $myAuth->hasPermission('customer', 'approvalnonaktif') }}`),
                            onClick: () => {
                                if (`{{ $myAuth->hasPermission('customer', 'approvalnonaktif') }}`) {
                                    approvalNonAktif('customer')
                                }
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

        $('#approval .ui-pg-div')
            .addClass('btn-sm')
            .css({
                'background': '#6619ff',
                'color': '#fff'
            })
            .parent().addClass('px-1')


        function permission() {
            if (cabangTnl == 'YA') {
                $('#add').attr('disabled', 'disabled')
                $('#edit').attr('disabled', 'disabled')
                $('#delete').attr('disabled', 'disabled')
            } else {
                if (!`{{ $myAuth->hasPermission('customer', 'store') }}`) {
                    $('#add').attr('disabled', 'disabled')
                }

                if (!`{{ $myAuth->hasPermission('customer', 'update') }}`) {
                    $('#edit').attr('disabled', 'disabled')
                }

                if (!`{{ $myAuth->hasPermission('customer', 'destroy') }}`) {
                    $('#delete').attr('disabled', 'disabled')
                }


            }

            if (!`{{ $myAuth->hasPermission('customer', 'show') }}`) {
                $('#view').attr('disabled', 'disabled')
            }


            if (!`{{ $myAuth->hasPermission('customer', 'export') }}`) {
                $('#export').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('customer', 'report') }}`) {
                $('#report').attr('disabled', 'disabled')
            }

            let hakApporveCount = 0;

            hakApporveCount++
            if (!`{{ $myAuth->hasPermission('upahsupir', 'approvalaktif') }}`) {
                hakApporveCount--
                $('#approvalaktif').hide()
            } 
            hakApporveCount++
            if (!`{{ $myAuth->hasPermission('customer', 'approval') }}`) {
                hakApporveCount--
                $('#approveun').hide()
                // $('#approval-buka-cetak').attr('disabled', 'disabled')
            }
            hakApporveCount++
            if (!`{{ $myAuth->hasPermission('upahsupir', 'approvalnonaktif') }}`) {
                hakApporveCount--
                $('#approvalnonaktif').hide()
            }
            if (hakApporveCount < 1) {
                $('#approve').hide()
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

        $('#rangeModal').on('hidden.bs.modal', function() {

            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
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
            $('#processingLoader').removeClass('d-none')


            getCekExport(params).then((response) => {
                    if ($('#rangeModal').data('action') == 'export') {
                        $.ajax({
                            url: `${apiUrl}customer/export?${params}`,
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
                                            type: 'customer/vnd.ms-excel'
                                        });
                                        var link = document.createElement('a');
                                        link.href = window.URL.createObjectURL(blob);
                                        link.download = 'LaporanCustomer' + new Date().getTime() + '.xlsx';
                                        link.click();
                                    }
                                    $('#rangeModal').modal('hide')
                                }
                            },
                            error: function(xhr, status, error) {
                                $('#processingLoader').addClass('d-none')
                                submitButton.removeAttr('disabled')
                            }
                        }).always(() => {
                            $('#processingLoader').addClass('d-none')
                            submitButton.removeAttr('disabled')
                        })
                    } else if ($('#rangeModal').data('action') == 'report') {
                        window.open(`{{ route('customer.report') }}?${params}`)
                        submitButton.removeAttr('disabled')
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
                        $('#processingLoader').addClass('d-none')
                    } else {
                        showDialog(error.statusText)
                    }
                })

                .finally(() => {

                    $('.ui-button').click()

                    submitButton.removeAttr('disabled')
                })

            function getCekExport(params) {

                params += `&cekExport=true`

                return new Promise((resolve, reject) => {
                    $.ajax({
                        url: `${apiUrl}customer/export?${params}`,
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

        function handleApproval(id) {
            $.ajax({
                url: `${apiUrl}customer/${id}/approval`,
                method: 'POST',
                dataType: 'JSON',
                beforeSend: request => {
                    request.setRequestHeader('Authorization', `Bearer ${accessToken}`)
                },
                success: response => {
                    $('#jqGrid').trigger('reloadGrid')
                }
            }).always(() => {
                $('#processingLoader').addClass('d-none')
            })
        }
    })
</script>
@endpush()
@endsection