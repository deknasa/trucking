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
</div>

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
    let sortname = 'id'
    let sortorder = 'asc'
    let autoNumericElements = []
    let indexRow = 0;

    $(document).ready(function() {
        setRange()
        initDatepicker('datepickerIndex')
        $(document).on('click', '#btnReload', function(event) {
            loadDataHeader('logabsensi')
        })
        $("#jqGrid").jqGrid({
                url: `${apiUrl}logabsensi`,
                mtype: "GET",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                datatype: "json",
                postData: {
                    tgldari: $('#tgldariheader').val(),
                    tglsampai: $('#tglsampaiheader').val(),
                },
                colModel: [{
                        label: 'ID',
                        name: 'id',
                        align: 'right',
                        width: '70px',
                        search: false,
                        hidden: true
                    },
                    {
                        label: 'KARYAWAN/SUPIR/KENEK',
                        name: 'karyawan',
                        align: 'left',
                        width: (detectDeviceType() == "desktop") ? md_dekstop_2 : md_mobile_2,
                    },
                    {
                        label: 'TANGGAL',
                        name: 'tanggal',
                        align: 'left',
                        formatter: "date",
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'JADWAL KERJA',
                        name: 'jadwalkerja',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left'
                    },
                    {
                        label: 'STATUS',
                        name: 'statusabsen',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'left'
                    },
                    {
                        label: 'LOG WAKTU',
                        name: 'logwaktu',
                        width: (detectDeviceType() == "desktop") ? md_dekstop_1 : md_mobile_1,
                        align: 'left'
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
                        id: 'report',
                        innerHTML: '<i class="fa fa-print"></i> REPORT',
                        class: 'btn btn-info btn-sm mr-1',
                        onClick: () => {
                            window.open(`{{ route('logabsensi.report') }}?tgldari=${$('#tgldariheader').val()}&tglsampai=${$('#tglsampaiheader').val()}&limit=0`)
                        }
                    },
                    {
                        id: 'export',
                        innerHTML: '<i class="fa fa-file-export"></i> EXPORT',
                        class: 'btn btn-warning btn-sm mr-1',
                        onClick: () => {
                            window.open(`{{ route('logabsensi.export') }}?tgldari=${$('#tgldariheader').val()}&tglsampai=${$('#tglsampaiheader').val()}&limit=0`)
                        }
                    },
                ]
            })

        /* Append clear filter button */
        loadClearFilter($('#jqGrid'))

        /* Append global search */
        loadGlobalSearch($('#jqGrid'))



        $('#report .ui-pg-div')
            .addClass('btn-sm btn-info')
            .parent().addClass('px-1')

        $('#export .ui-pg-div')
            .addClass('btn-sm btn-warning')
            .parent().addClass('px-1')

        function permission() {


            if (!`{{ $myAuth->hasPermission('logabsensi', 'export') }}`) {
                $('#export').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('logabsensi', 'report') }}`) {
                $('#report').attr('disabled', 'disabled')
            }
        }
    })
</script>
@endpush()
@endsection