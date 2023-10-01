<!-- Grid -->
<div class="container-fluid my-4">
    <div class="row">
        <div class="col-12">
            <table id="detail"></table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let sortnameDetail = 'nobukti'
    let sortorderDetail = 'asc'
    let totalRecordDetail
    let limitDetail
    let postDataDetail
    let triggerClickDetail
    let indexRowDetail
    let pageDetail = 0;

    let column = []
    let post = {}

    function loadDetailGrid(tabel) {
        if (tabel == 'NOTA KREDIT') {
            api = `${apiUrl}notakredit_detail`
            column = []
            post = {}
            column.push({
                label: 'id',
                name: 'id',
                align: 'right',
                width: '50px'
            }, {
                label: 'NO BUKTI',
                name: 'nobukti',
            }, {
                label: 'KETERANGAN',
                name: 'keterangan',
            }, {
                label: 'TGL TERIMA',
                name: 'tglterima',
                align: 'left',
                formatter: "date",
                formatoptions: {
                    srcformat: "ISO8601Long",
                    newformat: "d-m-Y"
                }
            }, {
                label: 'KODE PERKIRAAN adjust',
                name: 'coaadjust',
            }, {
                label: 'INVOICE NO BUKTI',
                name: 'invoice_nobukti',
            }, {
                label: 'NOMINAL',
                name: 'nominal',
                align: 'right',
                formatter: currencyFormat,
            }, {
                label: 'nominal bayar',
                name: 'nominalbayar',
                align: 'right',
                formatter: currencyFormat,
            }, {
                label: 'penyesuaian',
                name: 'penyesuaian',
                align: 'right',
                formatter: currencyFormat,
            }, {
                label: 'MODIFIED BY',
                name: 'modifiedby',
                align: 'left'
            }, )

        } else {
            api = `${apiUrl}notadebet_detail`
            column = []
            post = {}
            column.push({
                label: 'id',
                name: 'id',
                align: 'right',
                width: '50px'
            }, {
                label: 'NO BUKTI',
                name: 'nobukti',
            }, {
                label: 'KETERANGAN',
                name: 'keterangan',
            }, {
                label: 'TGL TERIMA',
                name: 'tglterima',
                align: 'left',
                formatter: "date",
                formatoptions: {
                    srcformat: "ISO8601Long",
                    newformat: "d-m-Y"
                }
            }, {
                label: 'KODE PERKIRAAN LEBIH BAYAR',
                name: 'coalebihbayar',
            }, {
                label: 'INVOICE NO BUKTI',
                name: 'invoice_nobukti',
            }, {
                label: 'NOMINAL',
                name: 'nominal',
                align: 'right',
                formatter: currencyFormat,
            }, {
                label: 'nominal bayar',
                name: 'nominalbayar',
                align: 'right',
                formatter: currencyFormat,
            }, {
                label: 'lebih bayar',
                name: 'lebihbayar',
                align: 'right',
                formatter: currencyFormat,
            }, {
                label: 'MODIFIED BY',
                name: 'modifiedby',
                align: 'left'
            }, )
        }

        $("#detail").jqGrid({
                url: api,
                mtype: "GET",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                datatype: "local",
                colModel: column,
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
                // postData: post,
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
                        if (tabel == 'NOTA KREDIT') {
                            $(this).jqGrid('footerData', 'set', {
                                nobukti: 'Total:',
                                nominal: data.attributes.totalNominal,
                                nominalbayar: data.attributes.totalNominalBayar,
                                penyesuaian: data.attributes.totalPenyesuaian,
                            }, true)
                        } else {
                            $(this).jqGrid('footerData', 'set', {
                                nobukti: 'Total:',
                                nominal: data.attributes.totalNominal,
                                nominalbayar: data.attributes.totalNominalBayar,
                                lebihbayar: data.attributes.totalLebihBayar,
                            }, true)
                        }

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
                    clearGlobalSearch($('#detail'))
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
        loadClearFilter($('#detail'))

        /* Append global search */
        loadGlobalSearch($('#detail'))
        $('#gbox_detail').siblings('.grid-pager').not(':first').remove()
    }

    function loadDetailData(id, tabel) {

        if (tabel == 'NOTA KREDIT') {
            column = []
            post = {}
            column.push({
                label: 'id',
                name: 'id',
                align: 'right',
                width: '50px'
            }, {
                label: 'NO BUKTI',
                name: 'nobukti',
            }, {
                label: 'KETERANGAN',
                name: 'keterangan',
            }, {
                label: 'TGL TERIMA',
                name: 'tglterima',
                align: 'left',
                formatter: "date",
                formatoptions: {
                    srcformat: "ISO8601Long",
                    newformat: "d-m-Y"
                }
            }, {
                label: 'KODE PERKIRAAN adjust',
                name: 'coaadjust',
            }, {
                label: 'INVOICE NO BUKTI',
                name: 'invoice_nobukti',
            }, {
                label: 'NOMINAL',
                name: 'nominal',
                align: 'right',
                formatter: currencyFormat,
            }, {
                label: 'nominal bayar',
                name: 'nominalbayar',
                align: 'right',
                formatter: currencyFormat,
            }, {
                label: 'penyesuaian',
                name: 'penyesuaian',
                align: 'right',
                formatter: currencyFormat,
            }, {
                label: 'MODIFIED BY',
                name: 'modifiedby',
                align: 'left'
            })

            post = {
                notakredit_id: id
            }
            $('#detail').setGridParam({
                url: `${apiUrl}notakredit_detail`,
                datatype: "json",
                postData: post
            }).trigger('reloadGrid')
        }
        if (tabel == 'NOTA DEBET') {
            column = []
            post = {}
            column.push({
                label: 'id',
                name: 'id',
                align: 'right',
                width: '50px'
            }, {
                label: 'NO BUKTI',
                name: 'nobukti',
            }, {
                label: 'KETERANGAN',
                name: 'keterangan',
            }, {
                label: 'TGL TERIMA',
                name: 'tglterima',
                align: 'left',
                formatter: "date",
                formatoptions: {
                    srcformat: "ISO8601Long",
                    newformat: "d-m-Y"
                }
            }, {
                label: 'KODE PERKIRAAN LEBIH BAYAR',
                name: 'coalebihbayar',
            }, {
                label: 'invoice nobukti',
                name: 'invoice_nobukti',
            }, {
                label: 'NOMINAL',
                name: 'nominal',
                align: 'right',
                formatter: currencyFormat,
            }, {
                label: 'nominal bayar',
                name: 'nominalbayar',
                align: 'right',
                formatter: currencyFormat,
            }, {
                label: 'lebih bayar',
                name: 'lebihbayar',
                align: 'right',
                formatter: currencyFormat,
            }, {
                label: 'MODIFIED BY',
                name: 'modifiedby',
                align: 'left'
            })

            post = {
                notadebet_id: id
            }
            $('#detail').setGridParam({
                url: `${apiUrl}notadebet_detail`,
                datatype: "json",
                postData: post,
                page: 1
            }).trigger('reloadGrid')
        }

        $('#gbox_detail').siblings('.grid-pager').not(':first').remove()

    }
</script>
@endpush()