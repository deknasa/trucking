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

@include('otobon._modal')

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
    let sortname = 'agen'
    let sortorder = 'asc'
    let autoNumericElements = []
    let rowNum = 10

    $(document).ready(function() {



        $("#jqGrid").jqGrid({
                url: `${apiUrl}otobon`,
                mtype: "GET",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                datatype: "json",
                colModel: [{
                        label: 'ID',
                        name: 'id',
                        width: '50px',
                        search: false,
                        hidden: true
                    },
                    {
                        label: 'CUSTOMER',
                        name: 'agen',
                        width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
                    },
                    {
                        label: 'CONTAINER',
                        name: 'container',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                    },
                    {
                        label: 'NOMINAL',
                        name: 'nominal',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: "right",
                        formatter: currencyFormat,
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
                        highlightSearch = ''
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
                beforeSearch: function() {
                    abortGridLastRequest($(this))
                    $('#left-nav').find(`button:not(#add)`).attr('disabled', 'disabled')
                    clearGlobalSearch($('#jqGrid'))
                }
            })

            .customPager({
                buttons: [{
                        id: 'add',
                        innerHTML: '<i class="fa fa-plus"></i> ADD',
                        class: 'btn btn-primary btn-sm mr-1',
                        onClick: () => {
                            createOtobon()
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
                                editOtobon(selectedId)
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
                                deleteOtobon(selectedId)
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
                                viewOtobon(selectedId)
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
            if (!`{{ $myAuth->hasPermission('otobon', 'store') }}`) {
                $('#add').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('otobon', 'update') }}`) {
                $('#edit').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('otobon', 'destroy') }}`) {
                $('#delete').attr('disabled', 'disabled')
            }
            if (!`{{ $myAuth->hasPermission('otobon', 'export') }}`) {
                $('#export').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('otobon', 'report') }}`) {
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
                            url: `{{ config('app.api_url') }}otobon/export?` + params,
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
                                            type: 'bank/vnd.ms-excel'
                                        });
                                        var link = document.createElement('a');
                                        link.href = window.URL.createObjectURL(blob);
                                        link.download = 'laporanotobon' + new Date().getTime() + '.xlsx';
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
                        window.open(`{{ route('otobon.report') }}?${params}`)
                        submitButton.removeAttr('disabled')
                        $('#processingLoader').addClass('d-none')
                        $('#rangeModal').modal('hide')
                    }
                }).catch((error) => {
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
                    url: `${apiUrl}otobon/export?${params}`,
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