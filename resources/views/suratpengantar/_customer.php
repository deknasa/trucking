@push('scripts')
<script>
    function loadRekapCustGrid(dari, sampai) {
        let sortnameRekapCust = 'agen'
        let sortorderRekapCust = 'asc'
        let totalRecordRekapCust
        let limitRekapCust
        let postDataRekapCust
        let triggerClickRekapCust
        let indexRowRekapCust
        let pageRekapCust = 0;
        $('#rekapCustGrid')
            .jqGrid({
                datatype: 'local',
                data: [],
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                idPrefix: 'rekapCustGrid',
                colModel: [{
                        label: 'agen',
                        name: 'agen',
                    },
                    {
                        label: 'JUMLAH',
                        name: 'jumlah',
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
                sortname: sortnameRekapCust,
                sortorder: sortorderRekapCust,
                page: pageRekapCust,
                viewrecords: true,
                postData: {
                    tgldari: dari,
                    tglsampai: sampai,
                },
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
                    sortnameRekapCust = $(this).jqGrid("getGridParam", "sortname")
                    sortorderRekapCust = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecordRekapCust = $(this).getGridParam("records")
                    limitRekapCust = $(this).jqGrid('getGridParam', 'postData').limit
                    postDataRekapCust = $(this).jqGrid('getGridParam', 'postData')
                    triggerClick = false

                    $('.clearsearchclass').click(function() {
                        clearColumnSearch($(this))
                    })

                    if (indexRowRekapCust > $(this).getDataIDs().length - 1) {
                        indexRowRekapCust = $(this).getDataIDs().length - 1;
                    }

                    setHighlight($(this))

                    if (data.attributes) {
                        $(this).jqGrid('footerData', 'set', {
                            nobukti: 'Total:',
                            nominal: data.attributes.totalNominal,
                            nominaltagih: data.attributes.totalNominalTagih,
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

                    clearGlobalSearch($('#rekapCustGrid'))
                },
            })

            .jqGrid("navGrid", pager, {
                search: false,
                refresh: false,
                add: false,
                edit: false,
                del: false,
            })

            .customPager()
        /* Append clear filter button */
        loadClearFilter($('#rekapCustGrid'))

        /* Append global search */
        loadGlobalSearch($('#rekapCustGrid'))
    }

    function loadRekapCustData(dari, sampai) {
        abortGridLastRequest($('#rekapCustGrid'))

        $('#rekapCustGrid').setGridParam({
            url: `${apiUrl}suratpengantar/rekapcustomer`,
            datatype: "json",
            postData: {
                tgldari: dari,
                tglsampai: sampai,
            },
            page: 1
        }).trigger('reloadGrid')
    }
</script>
@endpush