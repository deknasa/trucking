@push('scripts')
<script>
    function loadExpStnkGrid() {
        let sortnameExpStnk = 'supir'
        let sortorderExpStnk = 'asc'
        let totalRecordExpStnk
        let limitExpStnk
        let postDataExpStnk
        let triggerClickExpStnk
        let indexRowExpStnk
        let pageExpStnk = 0;
        $('#tableExpSTNK')
            .jqGrid({
                datatype: 'local',
                data: [],
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                idPrefix: 'tableExpSTNK',
                colModel: [{
                        label: 'SUPIR',
                        name: 'supir',
                    },
                    {
                        label: 'EXP STNK',
                        name: 'expstnk',
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
                sortname: sortnameExpStnk,
                sortorder: sortorderExpStnk,
                page: pageExpStnk,
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
                    sortnameExpStnk = $(this).jqGrid("getGridParam", "sortname")
                    sortorderExpStnk = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecordExpStnk = $(this).getGridParam("records")
                    limitExpStnk = $(this).jqGrid('getGridParam', 'postData').limit
                    postDataExpStnk = $(this).jqGrid('getGridParam', 'postData')
                    triggerClick = false

                    $('.clearsearchclass').click(function() {
                        clearColumnSearch($(this))
                    })

                    if (indexRowExpStnk > $(this).getDataIDs().length - 1) {
                        indexRowExpStnk = $(this).getDataIDs().length - 1;
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

                    clearGlobalSearch($('#tableExpSTNK'))
                },
            })

            .customPager()
        /* Append clear filter button */
        loadClearFilter($('#tableExpSTNK'))

        /* Append global search */
        loadGlobalSearch($('#tableExpSTNK'))
    }

</script>
@endpush