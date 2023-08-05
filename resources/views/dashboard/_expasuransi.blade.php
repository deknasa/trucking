@push('scripts')
<script>
    function loadExpAsuransiGrid() {
        let sortnameExpAsuransi = 'supir'
        let sortorderExpAsuransi = 'asc'
        let totalRecordExpAsuransi
        let limitExpAsuransi
        let postDataExpAsuransi
        let triggerClickExpAsuransi
        let indexRowExpAsuransi
        let pageExpAsuransi = 0;
        $('#tableExpAsuransi')
            .jqGrid({
                datatype: 'local',
                data: [],
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                idPrefix: 'tableExpAsuransi',
                colModel: [{
                        label: 'SUPIR',
                        name: 'supir',
                    },
                    {
                        label: 'EXP ASURANSI',
                        name: 'expasuransi',
                        align: 'left',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                ],
                autowidth: true,
                shrinkToFit: false,
                height: 200,
                rowNum: 10,
                rownumbers: true,
                rownumWidth: 45,
                rowList: [10, 20, 50, 0],
                footerrow: true,
                userDataOnFooter: true,
                toolbar: [true, "top"],
                sortable: true,
                sortname: sortnameExpAsuransi,
                sortorder: sortorderExpAsuransi,
                page: pageExpAsuransi,
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
                    sortnameExpAsuransi = $(this).jqGrid("getGridParam", "sortname")
                    sortorderExpAsuransi = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecordExpAsuransi = $(this).getGridParam("records")
                    limitExpAsuransi = $(this).jqGrid('getGridParam', 'postData').limit
                    postDataExpAsuransi = $(this).jqGrid('getGridParam', 'postData')
                    triggerClick = false

                    $('.clearsearchclass').click(function() {
                        clearColumnSearch($(this))
                    })

                    if (indexRowExpAsuransi > $(this).getDataIDs().length - 1) {
                        indexRowExpAsuransi = $(this).getDataIDs().length - 1;
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

                    clearGlobalSearch($('#tableExpAsuransi'))
                },
            })

            .customPager()
        /* Append clear filter button */
        loadClearFilter($('#tableExpAsuransi'))

        /* Append global search */
        loadGlobalSearch($('#tableExpAsuransi'))
    }

</script>
@endpush