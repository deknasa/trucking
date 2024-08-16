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

@include('kerusakan._modal')

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
    let sortname = 'keterangan'
    let sortorder = 'asc'
    let autoNumericElements = []
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

    function clearSelectedRows() {
        selectedRows = []
        $('#gs_').prop('checked', false);
        $('#jqGrid').trigger('reloadGrid')
    }

    function selectAllRows() {
        $.ajax({
            url: `${apiUrl}kerusakan`,
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
                selectedRows = response.data.map((kerusakan) => kerusakan.id)
                $('#jqGrid').trigger('reloadGrid')
            }
        })
    }

    $(document).ready(function() {
        $("#jqGrid").jqGrid({
                url: `${apiUrl}kerusakan`,
                mtype: "GET",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
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
                        label: 'KETERANGAN',
                        name: 'keterangan',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
                    },
                    {
                        label: 'STATUS',
                        name: 'statusaktif',
                        stype: 'select',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                        searchoptions: {
                            value: `<?php
                                    $i = 1;

                                    foreach ($data['combo'] as $status) :
                                        echo "$status[param]:$status[parameter]";
                                        if ($i !== count($data['combo'])) {
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
                        label: 'MODIFIED BY',
                        name: 'modifiedby',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
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
                    $('#gs_').attr('disabled', false)
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
                            createKerusakan()
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
                            if (selectedId == null || selectedId == '' || selectedId == undefined) {
                                showDialog('Harap pilih salah satu record')
                            } else {
                                viewKerusakan(selectedId)
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
                    }
                ],
                modalBtnList: [{
                    id: 'approve',
                    title: 'Approve',
                    caption: 'Approve',
                    innerHTML: '<i class="fa fa-check"></i> APPROVAL/UN',
                    class: 'btn btn-purple btn-sm mr-1 ',
                    item: [{
                            id: 'approvalaktif',
                            text: "APPROVAL AKTIF",
                            color: `<?php echo $data['listbtn']->btn->approvalaktif; ?>`,
                            hidden: (!`{{ $myAuth->hasPermission('kerusakan', 'approvalaktif') }}`),
                            onClick: () => {
                                if (`{{ $myAuth->hasPermission('kerusakan', 'approvalaktif') }}`) {
                                    approvalAktif('kerusakan')

                                }
                            }
                        },
                        {
                            id: 'approvalnonaktif',
                            text: "APPROVAL NON AKTIF",
                            color: `<?php echo $data['listbtn']->btn->approvalnonaktif; ?>`,
                            hidden: (!`{{ $myAuth->hasPermission('kerusakan', 'approvalnonaktif') }}`),
                            onClick: () => {
                                if (`{{ $myAuth->hasPermission('kerusakan', 'approvalnonaktif') }}`) {
                                    approvalNonAktif('kerusakan')
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

        function permission() {
            if (cabangTnl == 'YA') {
                $('#add').attr('disabled', 'disabled')
                $('#edit').attr('disabled', 'disabled')
                $('#delete').attr('disabled', 'disabled')
            } else {
                if (!`{{ $myAuth->hasPermission('kerusakan', 'store') }}`) {
                    $('#add').attr('disabled', 'disabled')
                }

                if (!`{{ $myAuth->hasPermission('kerusakan', 'update') }}`) {
                    $('#edit').attr('disabled', 'disabled')
                }

                if (!`{{ $myAuth->hasPermission('kerusakan', 'destroy') }}`) {
                    $('#delete').attr('disabled', 'disabled')
                }
            }

            if (!`{{ $myAuth->hasPermission('kerusakan', 'show') }}`) {
                $('#view').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('kerusakan', 'export') }}`) {
                $('#export').attr('disabled', 'disabled')
            }
            if (!`{{ $myAuth->hasPermission('kerusakan', 'report') }}`) {
                $('#report').attr('disabled', 'disabled')
            }

            let hakApporveCount = 0;

            hakApporveCount++
            if (!`{{ $myAuth->hasPermission('kerusakan', 'approvalaktif') }}`) {
                hakApporveCount--
                $('#approvalaktif').hide()
            }
            hakApporveCount++
            if (!`{{ $myAuth->hasPermission('kerusakan', 'approvalnonaktif') }}`) {
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

            // window.open(`${actionUrl}?${$('#formRange').serialize()}&${params}`)
            let formRange = $('#formRange')
            let offset = parseInt(formRange.find('[name=dari]').val()) - 1
            let limit = parseInt(formRange.find('[name=sampai]').val().replace('.', '')) - offset
            params += `&offset=${offset}&limit=${limit}`

            getCekExport(params).then((response) => {
                    if ($('#rangeModal').data('action') == 'export') {
                        $.ajax({
                            url: `${apiUrl}kerusakan/export?${params}`,
                            type: 'GET',
                            beforeSend: function(xhr) {
                                xhr.setRequestHeader('Authorization', `Bearer ${accessToken}`);
                            },
                            xhrFields: {
                                responseType: 'arraybuffer'
                            },
                            success: function(response, status, xhr) {
                                if (xhr.status === 200) {
                                    if (response !== undefined) {
                                        var blob = new Blob([response], {
                                            type: 'kerusakan/vnd.ms-excel'
                                        });
                                        var link = document.createElement('a');
                                        link.href = window.URL.createObjectURL(blob);
                                        link.download = 'kerusakan' + new Date().getTime() + '.xlsx';
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
                        window.open(`{{ route('kerusakan.report') }}?${params}`)
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
                    url: `${apiUrl}kerusakan/export?${params}`,
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