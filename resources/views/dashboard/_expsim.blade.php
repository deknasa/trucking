@push('scripts')
<script>
    function loadExpSimGrid() {
        let sortnameExpSim = 'supir'
        let sortorderExpSim = 'asc'
        let totalRecordExpSim
        let limitExpSim
        let postDataExpSim
        let triggerClickExpSim
        let indexRowExpSim
        let pageExpSim = 0;
        $('#tableExpSIM')
            .jqGrid({
                datatype: 'local',
                data: [],
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                idPrefix: 'tableExpSIM',
                colModel: [{
                        label: 'SUPIR',
                        name: 'supir',
                    },
                    {
                        label: 'EXP SIM',
                        name: 'expsim',
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
                sortname: sortnameExpSim,
                sortorder: sortorderExpSim,
                page: pageExpSim,
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
                    sortnameExpSim = $(this).jqGrid("getGridParam", "sortname")
                    sortorderExpSim = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecordExpSim = $(this).getGridParam("records")
                    limitExpSim = $(this).jqGrid('getGridParam', 'postData').limit
                    postDataExpSim = $(this).jqGrid('getGridParam', 'postData')
                    triggerClick = false

                    $('.clearsearchclass').click(function() {
                        clearColumnSearch($(this))
                    })

                    if (indexRowExpSim > $(this).getDataIDs().length - 1) {
                        indexRowExpSim = $(this).getDataIDs().length - 1;
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

                    clearGlobalSearch($('#tableExpSIM'))
                },
            })

            .customPager()
        /* Append clear filter button */
        loadClearFilter($('#tableExpSIM'))

        /* Append global search */
        loadGlobalSearch($('#tableExpSIM'))
    }

</script>
@endpush