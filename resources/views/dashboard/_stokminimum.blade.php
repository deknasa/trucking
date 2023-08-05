@push('scripts')
<script>
    function loadStokMinimumGrid() {
        let sortnameStokMinimum = 'kode'
        let sortorderStokMinimum = 'asc'
        let totalRecordStokMinimum
        let limitStokMinimum
        let postDataStokMinimum
        let triggerClickStokMinimum
        let indexRowStokMinimum
        let pageStokMinimum = 0;
        $('#tableStokMinimum')
            .jqGrid({
                datatype: 'local',
                data: [],
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                idPrefix: 'tableStokMinimum',
                colModel: [{
                        label: 'KODE',
                        name: 'kode',
                    },
                    {
                        label: 'NAMA',
                        name: 'nama',
                        width: '200px'
                    },
                    {
                        label: 'Qty Min',
                        name: 'qtymin',
                        align: 'right',
                        formatter: currencyFormat,
                    },
                    {
                        label: 'SALDO STOK',
                        name: 'saldostok',
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
                sortname: sortnameStokMinimum,
                sortorder: sortorderStokMinimum,
                page: pageStokMinimum,
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
                    sortnameStokMinimum = $(this).jqGrid("getGridParam", "sortname")
                    sortorderStokMinimum = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecordStokMinimum = $(this).getGridParam("records")
                    limitStokMinimum = $(this).jqGrid('getGridParam', 'postData').limit
                    postDataStokMinimum = $(this).jqGrid('getGridParam', 'postData')
                    triggerClick = false

                    $('.clearsearchclass').click(function() {
                        clearColumnSearch($(this))
                    })

                    if (indexRowStokMinimum > $(this).getDataIDs().length - 1) {
                        indexRowStokMinimum = $(this).getDataIDs().length - 1;
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

                    clearGlobalSearch($('#tableStokMinimum'))
                },
            })

            .customPager({
                buttons: [{
                    id: 'exportStokMinimum',
                    innerHTML: '<i class="fas fa-file-export"></i> Export',
                    class: 'btn btn-warning btn-sm mr-1',
                    onClick: function(event) {
                        ExportStokMinimum()
                    }
                }, ]
            })
        /* Append clear filter button */
        loadClearFilter($('#tableStokMinimum'))

        /* Append global search */
        loadGlobalSearch($('#tableStokMinimum'))
    }

</script>
@endpush