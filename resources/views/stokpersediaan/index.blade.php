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
                        <div class="row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">FILTER<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <select name="keterangan" id="keterangan" class="form-select select2bs4" style="width: 100%;">

                                </select>
                            </div>

                        </div>
                        <div class="row" id="gudang">
                            <label class="col-12 col-sm-2 col-form-label mt-2">GUDANG<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="hidden" name="gudang_id">
                                    <input type="text" name="gudang" class="form-control gudang-lookup">
                                </div>
                            </div>
                        </div>
                        <div class="row" id="trado">
                            <label class="col-12 col-sm-2 col-form-label mt-2">TRADO<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="hidden" name="trado_id">
                                    <input type="text" name="trado" class="form-control trado-lookup">
                                </div>
                            </div>
                        </div>
                        <div class="row" id="gandengan">
                            <label class="col-12 col-sm-2 col-form-label mt-2">GANDENGAN<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="hidden" name="gandengan_id">
                                    <input type="text" name="gandengan" class="form-control gandengan-lookup">
                                </div>
                            </div>
                        </div>

                        <div class="row">

                            <div class="col-sm-4 mt-2">
                                <a id="btnReload" class="btn btn-primary mr-2">
                                    <i class="fas fa-sync"></i>
                                    Reload
                                </a>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <table id="jqGrid"></table>
        </div>
    </div>
</div>

@include('gudang._modal')

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
    let sortname = 'id'
    let sortorder = 'asc'
    let autoNumericElements = []
    let rowNum = 10

    $(document).ready(function() {

        initSelect2($('#crudForm').find('[name=keterangan]'), false)
        initLookup()
        setKeteranganOptions($('#crudForm'))



        showDefault($('#crudForm'))
            .then(response => {

                $.each(response.data, (index, value) => {
                    let element = $('#crudForm').find(`[name="${index}"]`);

                    if (element.is('select')) {
                        element.val(value).trigger('change');
                    } else {
                        element.val(value);
                    }
                });
                grid()

            })
            .catch(error => {
                // Penanganan kesalahan
            });


    });

    function showDefault(form) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}stokpersediaan/default`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    resolve(response);
                },
                error: error => {
                    reject(error);
                }
            });
        });
    }


    function grid() {
        $("#jqGrid").jqGrid({
                url: `${apiUrl}stokpersediaan`,
                mtype: "GET",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                datatype: "json",
                colModel: [{
                        label: 'ID',
                        name: 'id',
                        width: '50px',
                        search: false,
                        hidden: true
                    },
                    {
                        label: 'Lokasi',
                        name: 'lokasi'
                    },
                    {
                        label: 'STOK',
                        name: 'stok_id',
                        width: '500px'
                    },
                    {
                        label: 'QTY',
                        name: 'qty',
                        align: 'right',
                        formatter: 'currency',
                        formatoptions: {
                            decimalSeparator: '.',
                            thousandsSeparator: ','
                        }
                    },

                    {
                        label: 'MODIFIED BY',
                        name: 'modifiedby',
                    }
                ],
                autowidth: true,
                shrinkToFit: false,
                height: 350,
                rowNum: rowNum,
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
                postData: {
                    filter: $('#crudForm').find('[name=keterangan]').val(),
                    gudang: $('#crudForm').find('[name=gudang]').val(),
                    gudang_id: $('#crudForm').find('[name=gudang_id]').val(),

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
                    if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))
                },
                loadComplete: function(data) {
                    changeJqGridRowListText()
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

                    if (triggerClick) {
                        if (id != '') {
                            indexRow = parseInt($('#jqGrid').jqGrid('getInd', id)) - 1
                            $(`[id="${$('#jqGrid').getDataIDs()[indexRow]}"]`).click()
                            id = ''
                        } else if (indexRow != undefined) {
                            $(`[id="${$('#jqGrid').getDataIDs()[indexRow]}"]`).click()
                        }

                        if ($('#jqGrid').getDataIDs()[indexRow] == undefined) {
                            $(`[id="` + $('#jqGrid').getDataIDs()[0] + `"]`).click()
                        }

                        triggerClick = false
                    } else {
                        $('#jqGrid').setSelection($('#jqGrid').getDataIDs()[indexRow])
                    }
                    $('#left-nav').find('button').attr('disabled', false)
                    permission()
                    setHighlight($(this))
                },
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
                    $('#left-nav').attr('disabled', 'disabled')
                    clearGlobalSearch($('#jqGrid'))
                },
            })

            .customPager({
                buttons: [{
                    id: 'report',
                    innerHTML: '<i class="fa fa-print"></i> REPORT',
                    class: 'btn btn-info btn-sm mr-1',
                    onClick: function(event) {
                        let filter = $('#crudForm').find('[name=keterangan]').val()
                        let dataFilter = ''
                        if (filter == '186') {
                            dataFilter = $('#crudForm').find('[name=gudang_id]').val()
                        }
                        if (filter == '187') {
                            dataFilter = $('#crudForm').find('[name=trado_id]').val()
                        }
                        if (filter == '188') {
                            dataFilter = $('#crudForm').find('[name=gandengan_id]').val()
                        }

                        if (filter != '' && dataFilter != '') {

                            window.open(
                                `{{ route('stokpersediaan.report') }}?filter=${filter}&datafilter=${dataFilter}`
                            )
                        } else {
                            showDialog('ISI SELURUH KOLOM')
                        }
                    }
                }, {
                    id: 'export',
                    innerHTML: '<i class="fas fa-file-export"></i> EXPORT',
                    class: 'btn btn-warning btn-sm mr-1',
                    onClick: function(event) {
                        let filter = $('#crudForm').find('[name=keterangan]').val()
                        let dataFilter = ''
                        if (filter == '186') {
                            dataFilter = $('#crudForm').find('[name=gudang_id]').val()
                        }
                        if (filter == '187') {
                            dataFilter = $('#crudForm').find('[name=trado_id]').val()
                        }
                        if (filter == '188') {
                            dataFilter = $('#crudForm').find('[name=gandengan_id]').val()
                        }

                        if (filter != '' && dataFilter != '') {

                            // window.open(
                            //     `{{ route('stokpersediaan.export') }}?filter=${filter}&datafilter=${dataFilter}`
                            // )
                            $.ajax({
                                url: `${apiUrl}stokpersediaan/export`, 
                                type: 'GET',
                                data: {
                                    forReport : true,
                                    filter : filter,
                                    datafilter: dataFilter,
                                },
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
                                            link.download = 'LAPORAN STOK PERSEDIAAN' + new Date().getTime() + '.xlsx';
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
                        } else {
                            showDialog('ISI SELURUH KOLOM')
                        }
                    }
                }]
            })

        /* Append clear filter button */
        loadClearFilter($('#jqGrid'))

        /* Append global search */
        loadGlobalSearch($('#jqGrid'))

        function permission() {
            if (!`{{ $myAuth->hasPermission('stokpersediaan', 'export') }}`) {
                $('#export').attr('disabled', 'disabled')
            }

            if (!`{{ $myAuth->hasPermission('stokpersediaan', 'report') }}`) {
                $('#report').attr('disabled', 'disabled')
            }
        }
    }

    $(document).on('click', '#btnReload', function(event) {

        let keterangan = $('#crudForm').find('[name=keterangan]').val()
        if (keterangan == '') {
            showDialog('pilih proses data')
        } else {
            let dataFilter = ''
            if (keterangan == '186') {
                dataFilter = $('#crudForm').find('[name=gudang_id]').val()
            }
            if (keterangan == '187') {
                dataFilter = $('#crudForm').find('[name=trado_id]').val()
            }
            if (keterangan == '188') {
                dataFilter = $('#crudForm').find('[name=gandengan_id]').val()
            }
            if (keterangan == '0') {
                dataFilter = ""
            }
            $('#jqGrid').jqGrid('setGridParam', {
                postData: {
                    keterangan: $('#crudForm').find('[name=keterangan]').val(),
                    data: dataFilter,
                },
            }).trigger('reloadGrid');

        }

    })

    $(document).on('change', `#crudForm [name="keterangan"]`, function(event) {
        let keterangan = $(this).val();

        if (keterangan == '186') {
            $('#gudang').show()
            $('#trado').hide()
            $('#gandengan').hide()
        } else if (keterangan == '187') {
            $('#trado').show()
            $('#gudang').hide()
            $('#gandengan').hide()
        } else if (keterangan == '188') {
            $('#gandengan').show()
            $('#gudang').hide()
            $('#trado').hide()
        } else if (keterangan == '0') {
            $('#gandengan').hide()
            $('#gudang').hide()
            $('#trado').hide()
        } else {
            $('#trado').hide()
            $('#gandengan').hide()
        }
    })

    function initLookup() {

        $('.gudang-lookup').lookup({
            title: 'Gudang Lookup',
            fileName: 'gudang',
            onSelectRow: (gudang, element) => {
                $('#crudForm [name=gudang_id]').first().val(gudang.id)
                element.val(gudang.gudang)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=gudang_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
        $('.trado-lookup').lookup({
            title: 'Trado Lookup',
            fileName: 'trado',
            onSelectRow: (trado, element) => {
                $('#crudForm [name=trado_id]').first().val(trado.id)
                element.val(trado.keterangan)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=trado_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
        $('.gandengan-lookup').lookup({
            title: 'Gandengan Lookup',
            fileName: 'gandengan',
            onSelectRow: (gandengan, element) => {
                $('#crudForm [name=gandengan_id]').first().val(gandengan.id)
                element.val(gandengan.keterangan)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=gandengan_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
    }


    const setKeteranganOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=keterangan]').empty()
            relatedForm.find('[name=keterangan]').append(
                new Option('-- PILIH FILTER --', '', false, true)
            ).trigger('change')
            relatedForm.find('[name=keterangan]').append(
                new Option('Semua', 0, false, true)
            )
            let data = [];
            data.push({
                name: 'grp',
                value: 'STOK PERSEDIAAN'
            })
            data.push({
                name: 'subgrp',
                value: 'STOK PERSEDIAAN'
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
                        relatedForm.find('[name=keterangan]').append(option).trigger('change')
                    });

                    relatedForm
                        .find('[name=keterangan]')
                        .val($(`#crudForm [name=keterangan] option:eq(1)`).val())
                        .trigger('change')
                        .trigger('select2:selected');
                    // resolve()
                }
            })
        })
    }
</script>
@endpush()
@endsection