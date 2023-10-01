@include('layouts._rangeheaderlookup')
<table id="jurnalUmumLookup" class="lookup-grid"></table>

@push('scripts')
<script>
    setRangeLookup()
    initDatepicker()
    $(document).on('click', '#btnReloadLookup', function(event) {
        loadDataHeaderLookup('jurnalumumheader', 'jurnalUmumLookup')
    })
    $('#jurnalUmumLookup').jqGrid({
            url: `{{ config('app.api_url') . 'jurnalumumheader' }}`,
            mtype: "GET",
            styleUI: 'Bootstrap4',
            iconSet: 'fontAwesome',
            datatype: "json",
            postData: {
                jurnal: 1,
                tgldari: $('#tgldariheaderlookup').val(),
                tglsampai: $('#tglsampaiheaderlookup').val(),
            },
            idPrefix: 'jurnalUmumLookup',
            colModel: [{
                    label: 'ID',
                    name: 'id',
                    align: 'right',
                    width: '70px',
                    search: false,
                    hidden: true
                },
                {
                    label: 'NO BUKTI',
                    name: 'nobukti',
                    align: 'left'
                },
                {
                    label: 'TGL BUKTI',
                    name: 'tglbukti',
                    align: 'left',
                    formatter: "date",
                    formatoptions: {
                        srcformat: "ISO8601Long",
                        newformat: "d-m-Y"
                    }
                },
                {
                    label: 'DEBET',
                    name: 'nominaldebet',
                    align: 'right',
                    formatter: currencyFormat,
                },
                {
                    label: 'KREDIT',
                    name: 'nominalkredit',
                    align: 'right',
                    formatter: currencyFormat,
                },
                {
                    label: 'MODIFIED BY',
                    name: 'modifiedby',
                    align: 'left'
                },
                {
                    label: 'CREATED AT',
                    name: 'created_at',
                    align: 'right',
                    formatter: "date",
                    formatoptions: {
                        srcformat: "ISO8601Long",
                        newformat: "d-m-Y H:i:s"
                    }
                },
                {
                    label: 'UPDATED AT',
                    name: 'updated_at',
                    align: 'right',
                    formatter: "date",
                    formatoptions: {
                        srcformat: "ISO8601Long",
                        newformat: "d-m-Y H:i:s"
                    }
                },
            ],
            autowidth: true,
            responsive: true,
            shrinkToFit: false,
            height: 350,
            rowNum: 10,
            rownumbers: true,
            toolbar: [true, "top"],
            rownumWidth: 45,
            rowList: [10, 20, 50, 0],
            sortable: true,
            sortname: 'id',
            sortorder: 'asc',
            page: 1,
            // pager: $('#jurnalUmumLookupPager'),
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
            onSelectRow: function(id) {
                activeGrid = $(this)
                id = $(this).jqGrid('getCell', id, 'rn') - 1
                indexRow = id
                page = $(this).jqGrid('getGridParam', 'page')
                let rows = $(this).jqGrid('getGridParam', 'postData').limit
                if (indexRow >= rows) indexRow = (indexRow - rows * (page - 1))
            },
            loadBeforeSend: function(jqXHR) {
                jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)

                setGridLastRequest($(this), jqXHR)
            },
            loadComplete: function(data) {
                changeJqGridRowListText()
                if (detectDeviceType() == 'desktop') {
                    $(document).unbind('keydown')
                    setCustomBindKeys($(this))
                    initResize($(this))

                    if (indexRow - 1 > $('#jurnalUmumLookup').getGridParam().reccount) {
                        indexRow = $('#jurnalUmumLookup').getGridParam().reccount - 1
                    }

                    if (triggerClick) {
                        if (id != '') {
                            indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
                            $(`#jurnalUmumLookup [id="${$('#jurnalUmumLookup').getDataIDs()[indexRow]}"]`).click()
                            id = ''
                        } else if (indexRow != undefined) {
                            $(`#jurnalUmumLookup [id="${$('#jurnalUmumLookup').getDataIDs()[indexRow]}"]`).click()
                        }

                        if ($('#jurnalUmumLookup').getDataIDs()[indexRow] == undefined) {
                            $(`#jurnalUmumLookup [id="` + $('#jurnalUmumLookup').getDataIDs()[0] + `"]`).click()
                        }

                        triggerClick = false
                    } else {
                        $('#jurnalUmumLookup').setSelection($('#jurnalUmumLookup').getDataIDs()[indexRow])
                    }
                }

                /* Set global variables */
                sortname = $(this).jqGrid("getGridParam", "sortname")
                sortorder = $(this).jqGrid("getGridParam", "sortorder")
                totalRecord = $(this).getGridParam("records")
                limit = $(this).jqGrid('getGridParam', 'postData').limit
                postData = $(this).jqGrid('getGridParam', 'postData')

                $('.clearsearchclass').click(function() {
                    clearColumnSearch($(this))
                })

                $(this).setGridWidth($('#lookupjenistrado').prev().width())
                setHighlight($(this))
            }
        })

        .jqGrid("setLabel", "rn", "No.")
        .jqGrid('filterToolbar', {
            stringResult: true,
            searchOnEnter: false,
            defaultSearch: 'cn',
            groupOp: 'AND',
            disabledKeys: [16, 17, 18, 33, 34, 35, 36, 37, 38, 39, 40],
            beforeSearch: function() {
                abortGridLastRequest($(this))

                clearGlobalSearch($('#jurnalUmumLookup'))
            },
        })
        .customPager()
    loadGlobalSearch($('#jurnalUmumLookup'))
    loadClearFilter($('#jurnalUmumLookup'))
</script>