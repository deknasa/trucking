@push('scripts')
<script>
    function loadReminderSpkGrid() {
        let sortnameReminderSPK = 'nobukti'
        let sortorderReminderSPK = 'asc'
        let totalRecordReminderSPK
        let limitReminderSPK
        let postDataReminderSPK
        let triggerClickReminderSPK
        let indexRowReminderSPK
        let pageReminderSPK = 0;
        $('#tableReminderSPK')
            .jqGrid({
                datatype: 'local',
                data: [],
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                postData: {
                    tgldari: '05-08-2023',
                    tglsampai: '05-08-2023',
                    pengeluaranheader_id: 1,
                },
                colModel: [{
                        label: 'ID',
                        name: 'id',
                        align: 'right',
                        width: '50px',
                        search: false,
                        hidden: true
                    },
                    {
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
                sortname: sortnameReminderSPK,
                sortorder: sortorderReminderSPK,
                page: pageReminderSPK,
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
                    console.log('id', id)
                    loadReminderSPKDetailData(id)
                },
                loadComplete: function(data) {
                    changeJqGridRowListText()
                    $(document).unbind('keydown')
                    setCustomBindKeys($(this))
                    initResize($(this))

                    /* Set global variables */
                    sortnameReminderSPK = $(this).jqGrid("getGridParam", "sortname")
                    sortorderReminderSPK = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecordReminderSPK = $(this).getGridParam("records")
                    limitReminderSPK = $(this).jqGrid('getGridParam', 'postData').limit
                    postDataReminderSPK = $(this).jqGrid('getGridParam', 'postData')
                    triggerClick = false

                    $('.clearsearchclass').click(function() {
                        clearColumnSearch($(this))
                    })

                    if (indexRowReminderSPK > $(this).getDataIDs().length - 1) {
                        indexRowReminderSPK = $(this).getDataIDs().length - 1;
                    }
                    $('#tableReminderSPK').setSelection($('#tableReminderSPK').getDataIDs()[0])
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

                    clearGlobalSearch($('#tableReminderSPK'))
                },
            })

            .customPager()
        /* Append clear filter button */
        loadClearFilter($('#tableReminderSPK'))

        /* Append global search */
        loadGlobalSearch($('#tableReminderSPK'))
    }
</script>
@endpush