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

@include('tradotambahanabsensi._modal')

@push('scripts')
<script>
    let page = 0;
    let pager = '#jqGridPager'
    let popup = "";
    let id = "";
    let triggerClick = true;
    let highlightSearch;
    let totalRecord
    let limit
    let postData
    let sortname = 'tglabsensi'
    let sortorder = 'asc'
    let autoNumericElements = []
    let indexRow = 0;
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
            if (selectedRows.length != $('#jqGrid').jqGrid('getGridParam').records) {
                $('#gs_').prop('checked', false)
            }
        }

    }

    setSpaceBarCheckedHandler()

    $(document).ready(function() {
        $("#jqGrid").jqGrid({
                url: `${apiUrl}tradotambahanabsensi`,
                mtype: "GET",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
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
                            return `<input type="checkbox" name="tradoTambahanId[]" class="checkbox-jqgrid" value="${rowData.id}" onchange="checkboxHandler(this)">`
                        },
                    },
                    {
                        label: 'ID',
                        name: 'id',
                        align: 'right',
                        width: '70px',
                        search: false,
                        hidden: true
                    },
                    {
                        label: 'TGL ABSENSI',
                        name: 'tglabsensi',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'TRADO',
                        name: 'trado_id',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                    },
                    {
                        label: 'SUPIR',
                        name: 'supir_id',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
                    },
                    {
                        label: 'Jenis Kendaraan',
                        name: 'statusjeniskendaraan',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
                    },
                    {
                        label: 'keterangan',
                        name: 'keterangan',
                        width: (detectDeviceType() == "desktop") ? md_dekstop_4 : md_mobile_3,
                    },
                    {
                        label: 'Status Approval',
                        name: 'statusapproval',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        stype: 'select',
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
                            if (!value) {
                                return ''
                            }
                            let statusApproval = JSON.parse(value)

                            let formattedValue = $(`
                                <div class="badge" style="background-color: ${statusApproval.WARNA}; color: ${statusApproval.WARNATULISAN};">
                                <span>${statusApproval.SINGKATAN}</span>
                                </div>
                            `)

                            return formattedValue[0].outerHTML
                        },
                        cellattr: (rowId, value, rowObject) => {
                            if (!rowObject.statusapproval) {
                                return ''
                            }
                            let statusApproval = JSON.parse(rowObject.statusapproval)

                            return ` title="${statusApproval.MEMO}"`
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
                        label: 'MODIFIED BY',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        name: 'modifiedby',
                        align: 'left'
                    }, {
                        label: 'CREATED AT',
                        name: 'created_at',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_4,
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
                    id = $(this).jqGrid('getCell', id, 'rn') - 1
                    indexRow = id
                    page = $(this).jqGrid('getGridParam', 'page')
                    let limit = $(this).jqGrid('getGridParam', 'postData').limit
                    if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))
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
                buttons: [{
                        id: 'add',
                        innerHTML: '<i class="fa fa-plus"></i> ADD',
                        class: 'btn btn-primary btn-sm mr-1',
                        onClick: () => {
                            createTradoTambahanAbsensi()
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
                                viewTradoTambahanAbsensi(selectedId)
                            }
                        }
                    },
                    {
                        id: 'report',
                        innerHTML: '<i class="fa fa-print"></i> REPORT',
                        class: 'btn btn-info btn-sm mr-1',
                        onClick: () => {
                            $('#rangeTglModal').data('action', 'report')
                            $('#rangeTglModal').find('button:submit').html(`Report`)
                            $('#rangeTglModal').modal('show')
                        }
                    },
                    {
                        id: 'export',
                        innerHTML: '<i class="fa fa-file-export"></i> EXPORT',
                        class: 'btn btn-warning btn-sm mr-1',
                        onClick: () => {
                            $('#rangeTglModal').data('action', 'export')
                            $('#rangeTglModal').find('button:submit').html(`Export`)
                            $('#rangeTglModal').modal('show')
                        }
                    },
                ],
                extndBtn: [{
                    id: 'approve',
                    innerHTML: '<i class="fa fa-check"></i> APPROVAL/UN',
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
            if (!`{{ $myAuth->hasPermission('tradotambahanabsensi', 'store') }}`) {
                $('#add').attr('disabled', 'disabled')
            }
            if (!`{{ $myAuth->hasPermission('tradotambahanabsensi', 'show') }}`) {
                $('#view').attr('disabled', 'disabled')
            }
            if (!`{{ $myAuth->hasPermission('tradotambahanabsensi', 'update') }}`) {
                $('#edit').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('tradotambahanabsensi', 'destroy') }}`) {
                $('#delete').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('tradotambahanabsensi', 'export') }}`) {
                $('#export').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('tradotambahanabsensi', 'report') }}`) {
                $('#report').attr('disabled', 'disabled')
            }
            if (!`{{ $myAuth->hasPermission('tradotambahanabsensi', 'approval') }}`) {
                $('#approve').attr('disabled', 'disabled')
            }
        }

        $('#rangeTglModal').on('shown.bs.modal', function() {
            initDatepicker()
            today = new Date();
            firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
            $('#formRangeTgl').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', firstDay)).trigger('change');
            $('#formRangeTgl').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

        })

        // MODAL HIDDEN, REMOVE KOTAK MERAH
        $('#rangeTglModal').on('hidden.bs.modal', function() {

            $('.is-invalid').removeClass('is-invalid')
            $('.invalid-feedback').remove()
        })

        $('#formRangeTgl').submit(function(event) {
            event.preventDefault()
            let params
            let submitButton = $(this).find('button:submit')
            let dari = $('#formRangeTgl').find('[name=dari]').val()
            let sampai = $('#formRangeTgl').find('[name=sampai]').val()
            if ($('#rangeTglModal').data('action') == 'report') {
                window.open(`{{ route('tradotambahanabsensi.report') }}?dari=${dari}&sampai=${sampai}`)
            } else {

                $('#processingLoader').removeClass('d-none')
                $.ajax({
                    url: `{{ route('tradotambahanabsensi.export') }}?${$('#formRangeTgl').serialize()}`,
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
                                    type: 'cabang/vnd.ms-excel'
                                });
                                var link = document.createElement('a');
                                link.href = window.URL.createObjectURL(blob);
                                link.download = 'LAPORAN SUPIR SERAP ' + new Date().getTime() + '.xlsx';
                                link.click();
                            }
                        }

                        $('#processingLoader').addClass('d-none')
                    },
                    error: function(xhr, status, error) {
                        $('#processingLoader').addClass('d-none')
                        showDialog('TIDAK ADA DATA')
                    }
                })
            }
        })

    })

    function clearSelectedRows() {
        selectedRows = []
        $('#gs_').prop('checked', false)
        $('#jqGrid').trigger('reloadGrid')
    }

    function selectAllRows() {
        $.ajax({
            url: `${apiUrl}tradotambahanabsensi`,
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
                selectedRows = response.data.map((serap) => serap.id)
                $('#jqGrid').trigger('reloadGrid')
            }
        })
    }
</script>
@endpush()
@endsection