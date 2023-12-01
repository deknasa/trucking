@push('scripts')
<script>
    function loadDetailGrid(id) {
        let sortnameDetail = 'nobukti'
        let sortorderDetail = 'asc'
        let totalRecordDetail
        let limitDetail
        let postDataDetail
        let triggerClickDetail
        let indexRowDetail
        let pageDetail = 0

        $("#detailGrid")
            .jqGrid({
                datatype: 'local',
                data: [],
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                idPrefix: 'detailGrid',
                colModel: [{
                        label: 'NO BUKTI',
                        name: 'nobukti',
                    },
                    {
                        label: 'TANGGAL',
                        name: 'tglbukti',
                        align: 'left',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'GUDANG',
                        name: 'gudang',
                    },
                    {
                        label: 'NAMA BARANG',
                        name: 'namastok',
                    },
                    {
                        label: 'QTY',
                        name: 'qty',
                        align: 'right',
                        formatter: currencyFormat,
                    },
                    {
                        label: 'HARGA SATUAN',
                        name: 'hargasatuan',
                        align: 'right',
                        formatter: currencyFormat,
                    },   {
                        label: 'TOTAL',
                        name: 'total',
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
                sortname: sortnameDetail,
                sortorder: sortorderDetail,
                page: pageDetail,
                viewrecords: true,
                // postData: {
                //     stok_id: stok_Id,
                //     trado_id: trado_Id,
                //     gandengan_id: gandengan_Id,
                //     gudang: nama_gudang,
                //     stok: nama_stok
                // },
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
                    sortnameDetail = $(this).jqGrid("getGridParam", "sortname")
                    sortorderDetail = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecordDetail = $(this).getGridParam("records")
                    limitDetail = $(this).jqGrid('getGridParam', 'postData').limit
                    postDataDetail = $(this).jqGrid('getGridParam', 'postData')
                    triggerClick = false

                    $('.clearsearchclass').click(function() {
                        clearColumnSearch($(this))
                    })

                    if (indexRowDetail > $(this).getDataIDs().length - 1) {
                        indexRowDetail = $(this).getDataIDs().length - 1;
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

                    clearGlobalSearch($('#detailGrid'))
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
        loadClearFilter($('#detailGrid'))

        /* Append global search */
        loadGlobalSearch($('#detailGrid'))
    }

    function loadDetailData(stok_Id,trado_Id,gandengan_Id,nama_gudang,nama_stok) {
        abortGridLastRequest($('#detailGrid'))

        $('#detailGrid').setGridParam({
            url: `${apiUrl}reminderspkdetail`,
            datatype: "json",
            postData: {
                stok_id: stok_Id,
                trado_id: trado_Id,
                gandengan_id: gandengan_Id,
                gudang: nama_gudang,
                stok: nama_stok,
            },
            page: 1
        }).trigger('reloadGrid')
    }
</script>
@endpush