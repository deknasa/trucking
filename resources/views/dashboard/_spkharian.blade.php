@push('scripts')
<script>
    function loadSPKHarianGrid() {
        let sortnameSpkHarian = 'nobukti'
        let sortorderSpkHarian = 'asc'
        let totalRecordSpkHarian
        let limitSpkHarian
        let postDataSpkHarian
        let triggerClickSpkHarian
        let indexRowSpkHarian
        let pageSpkHarian = 0;
        $('#tableSPKHarian')
            .jqGrid({
                datatype: 'local',
                data: [],
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
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
                    },
                    {
                        label: 'JENIS BIAYA',
                        name: 'jenisbiaya',
                        align: 'right',
                        formatter: currencyFormat,
                    },
                    {
                        label: 'NOMINAL DISC',
                        name: 'nominaldisc',
                        align: 'right',
                        formatter: currencyFormat,
                    },
                    {
                        label: 'NOMINAL',
                        name: 'nominal',
                        align: 'right',
                        formatter: currencyFormat,
                    },
                    {
                        label: 'KETERANGAN',
                        name: 'keterangan',
                    },
                    {
                        label: 'KETERANGAN',
                        name: 'keterangan',
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
                sortname: sortnameSpkHarian,
                sortorder: sortorderSpkHarian,
                page: pageSpkHarian,
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
                    sortnameSpkHarian = $(this).jqGrid("getGridParam", "sortname")
                    sortorderSpkHarian = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecordSpkHarian = $(this).getGridParam("records")
                    limitSpkHarian = $(this).jqGrid('getGridParam', 'postData').limit
                    postDataSpkHarian = $(this).jqGrid('getGridParam', 'postData')
                    triggerClick = false

                    $('.clearsearchclass').click(function() {
                        clearColumnSearch($(this))
                    })

                    if (indexRowSpkHarian > $(this).getDataIDs().length - 1) {
                        indexRowSpkHarian = $(this).getDataIDs().length - 1;
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

                    clearGlobalSearch($('#tableSPKHarian'))
                },
            })

            .customPager()
        /* Append clear filter button */
        loadClearFilter($('#tableSPKHarian'))

        /* Append global search */
        loadGlobalSearch($('#tableSPKHarian'))
    }

</script>
@endpush