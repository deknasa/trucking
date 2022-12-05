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
    let api
    let column = []
    let post = {}

    function loadDetailGrid(tabel) {
        if (tabel == 'notakreditheader') {
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
                label: 'TANGGAL TERIMA',
                name: 'tglterima',
                align: 'left',
                formatter: "date",
                formatoptions: {
                    srcformat: "ISO8601Long",
                    newformat: "d-m-Y"
                }
            }, {
                label: 'coa adjust',
                name: 'coaadjust',
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
                label: 'penyesuaian',
                name: 'penyesuaian',
                align: 'right',
                formatter: currencyFormat,
            }, {
                label: 'modifiedby',
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
                label: 'TANGGAL TERIMA',
                name: 'tglterima',
                align: 'left',
                formatter: "date",
                formatoptions: {
                    srcformat: "ISO8601Long",
                    newformat: "d-m-Y"
                }
            }, {
                label: 'coa lebihbayar',
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
                label: 'modifiedby',
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
                rowNum: 0,
                rownumbers: true,
                rownumWidth: 45,
                rowList: [10, 20, 50],
                footerrow: true,
                userDataOnFooter: true,
                toolbar: [true, "top"],
                sortable: true,
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
                loadBeforeSend: (jqXHR) => {
                    jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)
                },
                onSelectRow: function(id) {
                    activeGrid = $(this)
                },
                loadComplete: function(data) {
                    initResize($(this))

                    let nominals = $(this).jqGrid("getCol", "nominal")
                    let totalNominal = 0

                    if (nominals.length > 0) {
                        totalNominal = nominals.reduce((previousValue, currentValue) => previousValue + currencyUnformat(currentValue), 0)
                    }

                    $(this).jqGrid('footerData', 'set', {
                        nobukti: 'Total:',
                        nominal: totalNominal,
                    }, true)
                }
            })

            .jqGrid("navGrid", pager, {
                search: false,
                refresh: false,
                add: false,
                edit: false,
                del: false,
            })
            .customPager()

    }

    function loadDetailData(id, tabel) {

        if (tabel == 'notakreditheader') {
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
                label: 'TANGGAL TERIMA',
                name: 'tglterima',
                align: 'left',
                formatter: "date",
                formatoptions: {
                    srcformat: "ISO8601Long",
                    newformat: "d-m-Y"
                }
            }, {
                label: 'coa adjust',
                name: 'coaadjust',
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
                label: 'penyesuaian',
                name: 'penyesuaian',
                align: 'right',
                formatter: currencyFormat,
            }, {
                label: 'modifiedby',
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
        } else {
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
                label: 'TANGGAL TERIMA',
                name: 'tglterima',
                align: 'left',
                formatter: "date",
                formatoptions: {
                    srcformat: "ISO8601Long",
                    newformat: "d-m-Y"
                }
            }, {
                label: 'coa lebihbayar',
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
                label: 'modifiedby',
                name: 'modifiedby',
                align: 'left'
            })

            post = {
                notadebet_id: id
            }
            $('#detail').setGridParam({
                url: `${apiUrl}notadebet_detail`,
                datatype: "json",
                postData: post
            }).trigger('reloadGrid')
        }
        
        $('#gbox_detail').siblings('.grid-pager').not(':first').remove()

    }
</script>
@endpush()