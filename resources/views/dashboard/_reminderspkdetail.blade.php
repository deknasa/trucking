@push('scripts')
<script>
    function loadReminderSpkDetailGrid() {
        let sortnameReminderSPKDetail = 'nobukti'
        let sortorderReminderSPKDetail = 'asc'
        let totalRecordReminderSPKDetail
        let limitReminderSPKDetail
        let postDataReminderSPKDetail
        let triggerClickReminderSPKDetail
        let indexRowReminderSPKDetail
        let pageReminderSPKDetail = 0;
        $('#tableReminderSPKDetail')
            .jqGrid({
                datatype: 'local',
                data: [],
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                idPrefix: 'tableReminderSPKDetail',
                colModel: [{
                        label: 'NO BUKTI',
                        name: 'nobukti',
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
                        label: 'TRADO',
                        name: 'trado',
                    },
                    {
                        label: 'NAMA BARANG',
                        name: 'namabarang',
                    },
                    {
                        label: 'SATUAN',
                        name: 'satuan',
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
                sortname: sortnameReminderSPKDetail,
                sortorder: sortorderReminderSPKDetail,
                page: pageReminderSPKDetail,
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
                    sortnameReminderSPKDetail = $(this).jqGrid("getGridParam", "sortname")
                    sortorderReminderSPKDetail = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecordReminderSPKDetail = $(this).getGridParam("records")
                    limitReminderSPKDetail = $(this).jqGrid('getGridParam', 'postData').limit
                    postDataReminderSPKDetail = $(this).jqGrid('getGridParam', 'postData')
                    triggerClick = false

                    $('.clearsearchclass').click(function() {
                        clearColumnSearch($(this))
                    })

                    if (indexRowReminderSPKDetail > $(this).getDataIDs().length - 1) {
                        indexRowReminderSPKDetail = $(this).getDataIDs().length - 1;
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

                    clearGlobalSearch($('#tableReminderSPKDetail'))
                },
            })

            .customPager()
        /* Append clear filter button */
        loadClearFilter($('#tableReminderSPKDetail'))

        /* Append global search */
        loadGlobalSearch($('#tableReminderSPKDetail'))
    }


    function loadReminderSPKDetailData(id) {
        abortGridLastRequest($('#tableReminderSPKDetail'))

        $('#tableReminderSPKDetail').setGridParam({
            url: `${apiUrl}pengeluaranstokdetail`,
            datatype: "json",
            postData: {
                pengeluaranstokheader_id: id
            },
            page: 1
        }).trigger('reloadGrid')
    }
</script>
@endpush