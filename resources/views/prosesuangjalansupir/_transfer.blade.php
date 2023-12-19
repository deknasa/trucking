<table id="transferGrid"></table>

<script>
    function loadGrid(id, nobukti) {
        let sortnameJurnal = 'nobukti'
        let sortorderJurnal = 'asc'
        let totalRecordJurnal
        let limitJurnal
        let postDataJurnal
        let triggerClickJurnal
        let indexRowJurnal
        let pageJurnal = 0

        $("#transferGrid")
            .jqGrid({
                url: `${apiUrl}prosesuangjalansupirdetail/transfer`,
                mtype: "GET",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                datatype: "json",
                colModel: [{
                        label: 'NO BUKTI',
                        name: 'nobukti',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                    }, {
                        label: 'TGL BUKTI',
                        name: 'tglbukti',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_2 : sm_mobile_2,
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'KODE PERKIRAAN',
                        name: 'coa',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                    },
                    {
                        label: 'NAMA PERKIRAAN',
                        name: 'keterangancoa',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_4 : sm_mobile_3,
                    },
                    {
                        label: 'DEBET',
                        name: 'nominaldebet',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'right',
                        formatter: currencyFormat,
                    },
                    {
                        label: 'KREDIT',
                        name: 'nominalkredit',
                        width: (detectDeviceType() == "desktop") ? sm_dekstop_3 : sm_mobile_3,
                        align: 'right',
                        formatter: currencyFormat,
                    },
                    {
                        label: 'KETERANGAN',
                        name: 'keterangan',
                        width: (detectDeviceType() == "desktop") ? lg_dekstop_1 : lg_mobile_1,
                    }
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
                sortname: sortnameJurnal,
                sortorder: sortorderJurnal,
                page: pageJurnal,
                viewrecords: true,
                postData: {
                    prosesuangjalan_id: id,
                    nobukti: nobukti
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
                    sortnameJurnal = $(this).jqGrid("getGridParam", "sortname")
                    sortorderJurnal = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecordJurnal = $(this).getGridParam("records")
                    limitJurnal = $(this).jqGrid('getGridParam', 'postData').limit
                    postDataJurnal = $(this).jqGrid('getGridParam', 'postData')
                    triggerClick = false

                    $('.clearsearchclass').click(function() {
                        clearColumnSearch($(this))
                    })

                    if (indexRowJurnal > $(this).getDataIDs().length - 1) {
                        indexRowJurnal = $(this).getDataIDs().length - 1;
                    }

                    setHighlight($(this))

                    if (data.attributes) {
                        $(this).jqGrid('footerData', 'set', {
                            nobukti: 'Total:',
                            nominaldebet: data.attributes.totalNominalDebet,
                            nominalkredit: data.attributes.totalNominalKredit,
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
                    $(this).setGridParam({
                        postData: {
                            nobukti: nobukti
                        },
                    })
                    clearGlobalSearch($('#transferGrid'))
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
        loadClearFilter($('#transferGrid'))

        /* Append global search */
        loadGlobalSearch($('#transferGrid'))
    }

    function loadDetailData(id, nobukti) {
        $('#transferGrid').setGridParam({
            url: `${apiUrl}jurnalumumdetail/jurnal`,
            datatype: "json",
            postData: {
                nobukti: nobukti
            },
            page: 1
        }).trigger('reloadGrid')
    }
</script>