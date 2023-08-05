@push('scripts')
<script>
    function loadServiceGrid() {
        let sortnameService = 'nopol'
        let sortorderService = 'asc'
        let totalRecordService
        let limitService
        let postDataService
        let triggerClickService
        let indexRowService
        let pageService = 0;
        $('#tableService')
            .jqGrid({
                datatype: 'local',
                data: [],
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                idPrefix: 'tableService',
                colModel: [{
                        label: 'NO POL',
                        name: 'nopol',
                    },
                    {
                        label: 'TANGGAL',
                        name: 'tanggal',
                        align: 'left',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'STATUS',
                        name: 'status',
                    },
                    {
                        label: 'KM',
                        name: 'km',
                        align: 'right',
                        formatter: currencyFormat,
                    },
                    {
                        label: 'KM PERJALANAN',
                        name: 'kmperjalanan',
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
                footerrow: true,
                userDataOnFooter: true,
                toolbar: [true, "top"],
                sortable: true,
                sortname: sortnameService,
                sortorder: sortorderService,
                page: pageService,
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
                },
                loadComplete: function(data) {
                    changeJqGridRowListText()
                    $(document).unbind('keydown')
                    setCustomBindKeys($(this))
                    initResize($(this))

                    /* Set global variables */
                    sortnameService = $(this).jqGrid("getGridParam", "sortname")
                    sortorderService = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecordService = $(this).getGridParam("records")
                    limitService = $(this).jqGrid('getGridParam', 'postData').limit
                    postDataService = $(this).jqGrid('getGridParam', 'postData')
                    triggerClick = false

                    $('.clearsearchclass').click(function() {
                        clearColumnSearch($(this))
                    })

                    if (indexRowService > $(this).getDataIDs().length - 1) {
                        indexRowService = $(this).getDataIDs().length - 1;
                    }

                    setHighlight($(this))

                    if (data.attributes) {
                        $(this).jqGrid('footerData', 'set', {
                            nobukti: 'Total:',
                            nominal: data.attributes.totalNominal,
                        }, true)
                    }
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

                    clearGlobalSearch($('#tableService'))
                },
            })

            .customPager({
                buttons: [{
                    id: 'exportService',
                    innerHTML: '<i class="fas fa-file-export"></i> Export',
                    class: 'btn btn-warning btn-sm mr-1',
                    onClick: function(event) {
                        ExportService()
                    }
                }, ]
            })
        /* Append clear filter button */
        loadClearFilter($('#tableService'))

        /* Append global search */
        loadGlobalSearch($('#tableService'))
    }

</script>
@endpush