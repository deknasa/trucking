@extends('layouts.master')

@section('content')
<!-- Grid -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <table id="jqGrid"></table>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-12">

            <table id="detailGrid"></table>
        </div>
    </div>
</div>

<!-- Detail -->
@include('reminderspk._detail')

@push('scripts')
<script>
    let indexRow = 0;
    let page = 0;
    let pager = '#jqGridPager'
    let popup = "";
    let id = "";
    let stok_id = "";
    let gandengan_id = "";
    let trado_id = "";
    let gudang = "";
    let stok = "";
    let triggerClick = true;
    let highlightSearch;
    let totalRecord
    let limit
    let postData
    let sortname = 'id'
    let sortorder = 'asc'
    let autoNumericElements = []
    let rowNum = 10
    let hasDetail = false
    let currentTab = 'detail'

    $(document).ready(function() {
        loadDetailGrid()

        $("#jqGrid").jqGrid({
                url: `${apiUrl}reminderspk`,
                mtype: "GET",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                datatype: "json",
                isLoading: true,
                colModel: [{
                        label: 'ID',
                        name: 'id',
                        align: 'right',
                        width: '50px',
                        search: false,
                        hidden: true
                    },
                    {
                        label: 'GUDANG',
                        name: 'gudang',
                        align: 'left'
                    },
                    {
                        label: 'GANDENGAN ID',
                        name: 'gandengan_id',
                        align: 'left',
                        hidden: true
                    },
                    {
                        label: 'TRADO ID',
                        name: 'trado_id',
                        align: 'left',
                        hidden: true
                    },
                    {
                        label: 'STOK ID',
                        name: 'stok_id',
                        align: 'left',
                        hidden: true
                    },
                    {
                        label: 'GANDENGAN_ID',
                        name: 'gandengan_id',
                        align: 'left',
                        hidden: true
                    },
                    {
                        label: 'NAMA BARANG',
                        name: 'stok',
                        align: 'left'
                    },
                    {
                        label: 'QTY',
                        name: 'qty',
                        align: 'right',
                        formatter: currencyFormat,
                    },
                    {
                        label: 'TOTAL',
                        name: 'total',
                        align: 'right',
                        formatter: currencyFormat,
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
                    if (indexRow >= limit) {
                        indexRow = (indexRow - limit * (page - 1))
                    }
                    stok_id = $('#jqGrid').jqGrid('getCell', id, 'stok_id');
                    trado_id = $('#jqGrid').jqGrid('getCell', id, 'trado_id');
                    gandengan_id = $('#jqGrid').jqGrid('getCell', id, 'gandengan_id');
                    gudang = $('<div/>').html($('#jqGrid').jqGrid('getCell', id, 'gudang')).text();
                    stok = $('<div/>').html($('#jqGrid').jqGrid('getCell', id, 'stok')).text();

                    loadDetailData(stok_id, trado_id, gandengan_id, gudang, stok)
                },
                loadComplete: function(data) {

                    changeJqGridRowListText()
                    if (data.data.length === 0) {
                        $('#detailGrid').each((index, element) => {
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
                    clearGlobalSearch($('#jqGrid'))
                }
            })

            .customPager({
                buttons: [{
                    id: 'export',
                    title: 'Export',
                    caption: 'Export',
                    innerHTML: '<i class="fas fa-file-export"></i> EXPORT',
                    class: 'btn btn-warning btn-sm mr-1',
                    onClick: function(event) {
                        $.ajax({
                            url: `${apiUrl}reminderspkdetail/export`,
                            // url: `{{ route('reminderspkdetail.export') }}`,
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
                                        link.download = 'REMINDER SPK ' + new Date().getTime() + '.xlsx';
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
                }, ]
            })

        /* Append clear filter button */
        loadClearFilter($('#jqGrid'))

        /* Append global search */
        loadGlobalSearch($('#jqGrid'))


    })
</script>
@endpush()
@endsection