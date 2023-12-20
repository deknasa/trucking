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

@include('stokpusat._modal')
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
    let sortname = 'namaterpusat'
    let sortorder = 'asc'
    let autoNumericElements = []
    let rowNum = 10

    $(document).ready(function() {
        $("#jqGrid").jqGrid({
                url: `${apiUrl}stokpusat`,
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
                        label: 'NAMA TERPUSAT',
                        name: 'namaterpusat',
                        width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
                    },
                    {
                        label: 'ID MEDAN',
                        name: 'idmedan',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                    },
                    {
                        label: 'NAMA MEDAN',
                        name: 'namamedan',
                        width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
                    },
                    {
                        label: 'ID SURABAYA',
                        name: 'idsurabaya',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                    },
                    {
                        label: 'NAMA SURABAYA',
                        name: 'namasurabaya',
                        width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
                    },
                    {
                        label: 'ID JAKARTA',
                        name: 'idjakarta',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                    },
                    {
                        label: 'NAMA JAKARTA',
                        name: 'namajakarta',
                        width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
                    },
                    {
                        label: 'ID JKT TNL',
                        name: 'idjakartatnl',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                    },
                    {
                        label: 'NAMA JKT TNL',
                        name: 'namajakartatnl',
                        width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
                    },
                    {
                        label: 'ID MAKASSAR',
                        name: 'idmakassar',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                    },
                    {
                        label: 'NAMA MAKASSAR',
                        name: 'namamakassar',
                        width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
                    },
                    {
                        label: 'ID BITUNG',
                        name: 'idmanado',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                    },
                    {
                        label: 'NAMA BITUNG',
                        name: 'namamanado',
                        width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
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
                            createStokPusat()
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
                                editStokPusat(selectedId)
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
                                deleteStokPusat(selectedId)
                            }
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
            if (!`{{ $myAuth->hasPermission('akunpusat', 'store') }}`) {
                $('#add').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('akunpusat', 'update') }}`) {
                $('#edit').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('akunpusat', 'destroy') }}`) {
                $('#delete').attr('disabled', 'disabled')
            }


        }

    })
</script>
@endpush()
@endsection