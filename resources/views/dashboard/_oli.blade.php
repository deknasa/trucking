@push('scripts')
<script>
    function loadOliGrid() {
        let sortnameOli = 'nopol'
        let sortorderOli = 'asc'
        let totalRecordOli
        let limitOli
        let postDataOli
        let triggerClickOli
        let indexRowOli
        let pageOli = 0;
        $('#tableStatusOli')
            .jqGrid({
                datatype: 'local',
                data: [],
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                idPrefix: 'tableStatusOli',
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
                        label: 'KODE STOK',
                        name: 'kodestok',
                    },
                    {
                        label: 'QTY',
                        name: 'qty',
                        align: 'right',
                        formatter: currencyFormat,
                    },
                    {
                        label: 'SATUAN',
                        name: 'satuan',
                    },
                    {
                        label: 'KM',
                        name: 'km',
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
                sortname: sortnameOli,
                sortorder: sortorderOli,
                page: pageOli,
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
                    sortnameOli = $(this).jqGrid("getGridParam", "sortname")
                    sortorderOli = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecordOli = $(this).getGridParam("records")
                    limitOli = $(this).jqGrid('getGridParam', 'postData').limit
                    postDataOli = $(this).jqGrid('getGridParam', 'postData')
                    triggerClick = false

                    $('.clearsearchclass').click(function() {
                        clearColumnSearch($(this))
                    })

                    if (indexRowOli > $(this).getDataIDs().length - 1) {
                        indexRowOli = $(this).getDataIDs().length - 1;
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

                    clearGlobalSearch($('#tableStatusOli'))
                },
            })

            .customPager({
                buttons: [{
                    id: 'exportOli',
                    innerHTML: '<i class="fas fa-file-export"></i> Export',
                    class: 'btn btn-warning btn-sm mr-1',
                    onClick: function(event) {
                        ExportOli()
                    }
                }, ]
            })
        /* Append clear filter button */
        loadClearFilter($('#tableStatusOli'))

        /* Append global search */
        loadGlobalSearch($('#tableStatusOli'))
    }

</script>
@endpush