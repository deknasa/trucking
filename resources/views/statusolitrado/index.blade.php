@extends('layouts.master')

@section('content')
<!-- Grid -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-easyui bordered mb-4">
                <div class="card-header">
                </div>
                <form id="crudForm">
                    <div class="card-body">
                        <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Periode<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="dari" class="form-control datepicker">
                                </div>
                            </div>
                            <h5 class="mt-3">s/d</h5>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="sampai" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">NO POL</label>
                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="trado_id">
                                <input type="text" name="trado" id="trado" class="form-control trado-lookup">
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-12 col-sm-2 col-md-2">
                                <label class="col-form-label">Status <span class="text-danger">*</span></label>
                            </div>
                            <div class="col-sm-4">
                                <input type="hidden" name="status">
                                <input type="text" name="statusnama" id="statusnama" class="form-control lg-form status-lookup">
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-sm-6 mt-4">
                                <button type="button" id="btnTampil" class="btn btn-primary mr-1 ">
                                    <i class="fas fa-sync"></i>
                                    Reload
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">

            <table id="jqGrid"></table>
        </div>
    </div>
</div>

@push('scripts')
<script>
    let indexRow = 0;
    let page = 0;
    let pager = '#jqGridPager'
    let popup = "";
    let id = "";
    let triggerClick = true;
    let highlightSearch;
    let totalRecord
    let limit
    let postData
    let sortname = 'nopol'
    let sortorder = 'asc'
    let autoNumericElements = []
    let rowNum = 10
    let hasDetail = false

    $(document).ready(function() {
        initDatepicker()
        let today = new Date();
        // mendapatkan tanggal pertama di bulan ini
        let firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        let formattedFirstDay = $.datepicker.formatDate('dd-mm-yy', firstDay);

        // mendapatkan tanggal terakhir di bulan ini
        let lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
        let formattedLastDay = $.datepicker.formatDate('dd-mm-yy', lastDay);

        $('#crudForm').find('[name=dari]').val(formattedFirstDay).trigger('change');
        $('#crudForm').find('[name=sampai]').val(formattedLastDay).trigger('change');

        initLookup()
        // initSelect2($('#crudForm').find('[name=status]'), false)
        // setStatusOptions($('#crudForm'))

        $(document).on('click', "#btnTampil", function() {
            $('#jqGrid').jqGrid('setGridParam', {
                postData: {
                    status: $('#crudForm').find('[name=status]').val(),
                    dari: $('#crudForm').find('[name=dari]').val(),
                    sampai: $('#crudForm').find('[name=sampai]').val(),
                    trado_id: $('#crudForm').find('[name=trado_id]').val(),
                },
            }).trigger('reloadGrid');
        })

        $("#jqGrid").jqGrid({
                url: `${apiUrl}statusolitrado`,
                mtype: "GET",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                datatype: "json",
                isLoading: true,
                colModel: [{
                        label: 'ID',
                        name: 'id',
                        align: 'right',
                        width: '50px',
                        search: false,
                        hidden: true
                    },
                    {
                        label: 'NO POL',
                        name: 'nopol',
                        align: 'left'
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
                        label: 'STATUS',
                        name: 'status',
                        align: 'left'
                    },
                    {
                        label: 'KODE STOK',
                        name: 'kodestok',
                        align: 'left'
                    },
                    {
                        label: 'QTY',
                        name: 'qty',
                        align: 'right',
                        formatter: currencyFormat,
                    },
                    {
                        label: 'SATUAN',
                        name: 'satuan',
                        align: 'left'
                    },
                ],
                autowidth: true,
                shrinkToFit: false,
                height: 350,
                rowNum: 10,
                rownumbers: true,
                rownumWidth: 45,
                rowList: [10, 20, 50, 0],
                toolbar: [true, "top"],
                sortable: true,
                sortname: sortname,
                sortorder: sortorder,
                page: page,
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
                    indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
                    page = $(this).jqGrid('getGridParam', 'page')
                    let limit = $(this).jqGrid('getGridParam', 'postData').limit
                    if (indexRow >= limit) {
                        indexRow = (indexRow - limit * (page - 1))
                    }
                },
                loadComplete: function(data) {

                    changeJqGridRowListText()
                    if (data.data.length === 0) {
                        $('#jqGrid').each((index, element) => {
                            abortGridLastRequest($(element))
                            clearGridHeader($(element))
                        })
                    }

                    $(document).unbind('keydown')
                    setCustomBindKeys($(this))
                    initResize($(this))

                    /* Set global variables */
                    sortname = $(this).jqGrid("getGridParam", "sortname")
                    sortorder = $(this).jqGrid("getGridParam", "sortorder")
                    totalRecord = $(this).getGridParam("records")
                    limit = $(this).jqGrid('getGridParam', 'postData').limit
                    postData = $(this).jqGrid('getGridParam', 'postData')
                    triggerClick = true

                    $('.clearsearchclass').click(function() {
                        clearColumnSearch($(this))
                    })

                    if (indexRow > $(this).getDataIDs().length - 1) {
                        indexRow = $(this).getDataIDs().length - 1;
                    }
                    setTimeout(function() {

                        if (triggerClick) {
                            if (id != '') {
                                indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
                                $(`#jqGrid [id="${$('#jqGrid').getDataIDs()[indexRow]}"]`).click()
                                id = ''
                            } else if (indexRow != undefined) {
                                $(`#jqGrid [id="${$('#jqGrid').getDataIDs()[indexRow]}"]`).click()
                            }

                            if ($('#jqGrid').getDataIDs()[indexRow] == undefined) {
                                $(`#jqGrid [id="` + $('#jqGrid').getDataIDs()[0] + `"]`).click()
                            }
                            triggerClick = false
                        } else {
                            $('#jqGrid').setSelection($('#jqGrid').getDataIDs()[indexRow])
                        }
                    }, 100)

                    $('#left-nav').find('button').attr('disabled', false)
                    permission()
                    setHighlight($(this))
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
                    $('#left-nav').find(`button:not(#add)`).attr('disabled', 'disabled')
                    clearGlobalSearch($('#jqGrid'))
                }
            })

            .customPager({
                buttons: [{
                    id: 'export',
                    title: 'Export',
                    caption: 'Export',
                    innerHTML: '<i class="fas fa-file-export"></i> EXPORT',
                    class: 'btn btn-warning btn-sm mr-1',
                    onClick: () => {
                        let status = $('#crudForm').find('[name=status]').val();
                        let statustext = $('#crudForm').find('[name=status] option:selected').text();
                        let dari = $('#crudForm').find('[name=dari]').val();
                        let sampai = $('#crudForm').find('[name=sampai]').val();
                        let trado_id = $('#crudForm').find('[name=trado_id]').val();
                        let trado = $('#crudForm').find('[name=trado]').val();
                        $('#processingLoader').removeClass('d-none')

                        $.ajax({
                            url: `{{ route('statusolitrado.export') }}?status=${status}&dari=${dari}&sampai=${sampai}&trado_id=${trado_id}&trado=${trado}&statustext=${statustext}`,
                            type: 'GET',
                            beforeSend: function(xhr) {
                                xhr.setRequestHeader('Authorization', `Bearer {{ session('access_token') }}`);
                            },
                            xhrFields: {
                                responseType: 'arraybuffer'
                            },
                            success: function(response, status, xhr) {
                                if (xhr.status === 200) {
                                    if (response !== undefined) {
                                        var blob = new Blob([response], {
                                            type: 'cabang/vnd.ms-excel'
                                        });
                                        var link = document.createElement('a');
                                        link.href = window.URL.createObjectURL(blob);
                                        link.download = 'REMINDER STATUS OLI TRADO ' + new Date().getTime() + '.xlsx';
                                        link.click();
                                    }
                                }
                                
                                $('#processingLoader').addClass('d-none')
                            },
                            error: function(xhr, status, error) {
                                $('#processingLoader').addClass('d-none')
                                showDialog('TIDAK ADA DATA')
                            }
                        })    
                    }
                }, ]

            })

        /* Append clear filter button */
        loadClearFilter($('#jqGrid'))

        /* Append global search */
        loadGlobalSearch($('#jqGrid'))

        $('#export .ui-pg-div')
            .addClass('btn btn-sm btn-warning')
            .parent().addClass('px-1')

        function permission() {
            if (!`{{ $myAuth->hasPermission('statusolitrado', 'export') }}`) {
                $('#export').attr('disabled', 'disabled')
            }

        }
    })

    const setStatusOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=status]').empty()
            relatedForm.find('[name=status]').append(
                new Option('{SEMUA}', 'all', false, true)
            ).trigger('change')

            let data = [];
            data.push({
                name: 'grp',
                value: 'STATUS OLI'
            })
            data.push({
                name: 'subgrp',
                value: 'STATUS OLI'
            })
            $.ajax({
                url: `${apiUrl}parameter/combo`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: data,
                success: response => {

                    response.data.forEach(stokPersediaan => {
                        let option = new Option(stokPersediaan.text, stokPersediaan.id)
                        relatedForm.find('[name=status]').append(option).trigger(
                            'change')
                    });

                }
            })
        })
    }

    function initLookup() {
        $('.trado-lookup').lookupMaster({
            title: 'Trado Lookup',
            fileName: 'tradoMaster',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'trado_id',
                    searchText: 'trado-lookup',
                    title: 'trado lookup',
                    typeSearch: 'ALL',
                }
            },
            onSelectRow: (trado, element) => {
                $('#crudForm [name=trado_id]').first().val(trado.id)
                element.val(trado.kodetrado)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="trado_id"]`).first().val('')
                element.data('currentValue', element.val())
            }
        })

        $(`.status-lookup`).lookupMaster({
            title: 'status Lookup',
            fileName: 'parameterMaster',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function() {
                this.postData = {
                url: `${apiUrl}parameter/combo`,
                grp: 'STATUS OLI',
                subgrp: 'STATUS OLI',
                searching: 1,
                valueName: `status`,
                searchText: `status-lookup`,
                singleColumn: true,
                hideLabel: true,
                title: 'status Lookup'
                };
            },
            onSelectRow: (status, element) => {
                let elId = element.data('targetName')
                $(`#crudForm [name=${elId}]`).first().val(status.id)
                element.val(status.text)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'));
            },
            onClear: (element) => {
                let elId = element.data('targetName')
                $(`#crudForm [name=${elId}]`).first().val('')
                element.val('')
                element.data('currentValue', element.val())
            },
        });
    }
</script>
@endpush()
@endsection