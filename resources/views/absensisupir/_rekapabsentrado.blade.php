@push('scripts')
<script>
    function loadRekapAbsenTradoGrid() {
        let sortnameRekapCust = 'keterangan'
        let sortorderRekapCust = 'asc'
        let totalRecordRekapCust
        let limitRekapCust
        let postDataRekapCust
        let triggerClickRekapCust
        let indexRowRekapCust
        let pageRekapCust = 0;
        $('#rekapAbsenTradoGrid')
            .jqGrid({
                datatype: 'local',
                data: [],
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                idPrefix: 'rekapAbsenTradoGrid',
                colModel: [{
                        label: 'keterangan',
                        name: 'keterangan',
                        width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
                    },
                    {
                        label: 'JUMLAH',
                        name: 'jumlah',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
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
                    absensi_id: id
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

                    clearGlobalSearch($('#rekapAbsenTradoGrid'))
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
        loadClearFilter($('#rekapAbsenTradoGrid'))

        /* Append global search */
        loadGlobalSearch($('#rekapAbsenTradoGrid'))
    }

    function loadRekapAbsenTradoData(id) {
        abortGridLastRequest($('#rekapAbsenTradoGrid'))

        $('#rekapAbsenTradoGrid').setGridParam({
            url: `${apiUrl}absentrado/rekapabsentrado`,
            datatype: "json",
            postData: {
                absensi_id: id
            },
            page: 1
        }).trigger('reloadGrid')
    }
</script>
@endpush