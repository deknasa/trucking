@extends('layouts.master')

@section('content')
<!-- Grid -->
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card card-primary">
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
                            <div class="col-sm-1 mt-2">
                                <h5 class="text-center mt-2">s/d</h5>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="sampai" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">STOK<span class="text-danger">*</span></label>

                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="stokdari_id">
                                <input type="text" name="stokdari" class="form-control stokdari-lookup">
                            </div>
                            <div class="col-sm-1 mt-2">
                                <h5 class="text-center mt-2">s/d</h5>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="stoksampai_id">
                                <input type="text" name="stoksampai" class="form-control stoksampai-lookup">
                            </div>
                        </div>

                        <div class="row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">FILTER<span class="text-danger">*</span></label>

                            <div class="col-sm-4 col-md-4 mt-2">
                                <select name="filter" id="filter" class="form-select select2bs4" style="width: 100%;">

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

                            <div class="col-sm-6 mt-4">
                                <a id="btnPreview" class="btn btn-secondary mr-2 ">
                                    <i class="fas fa-sync"></i>
                                    Preview
                                </a>
                                <a id="btnReport" class="btn btn-info mr-2" style="visibility: hidden;">
                                    <i class="fas fa-print"></i>
                                    Report
                                </a>
                                <a id="btnExport" class="btn btn-warning mr-2" style="visibility: hidden;">
                                    <i class="fas fa-file-export"></i>
                                    Export
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
    let sortname = 'nobukti'
    let sortorder = 'asc'
    let autoNumericElements = []
    let rowNum = 10
    let hasDetail = false

    $(document).ready(function() {

        initSelect2($('#crudForm').find('[name=filter]'), false)
        initLookup()
        setFilterOptions($('#crudForm'))
        initDatepicker()

        $('#crudForm').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

        $('#btnPreview').click(function(event) {

            let stokdari_id = $('#crudForm').find('[name=stokdari_id]').val()
            let stoksampai_id = $('#crudForm').find('[name=stoksampai_id]').val()
            let dari = $('#crudForm').find('[name=dari]').val()
            let sampai = $('#crudForm').find('[name=sampai]').val()
            let filter = $('#crudForm').find('[name=filter]').val()
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

            if (stokdari_id != '' && stoksampai_id != '' && dari != '' && sampai != '' && filter != '' && dataFilter != '') {

                $('#jqGrid').jqGrid('setGridParam', {
                    postData: {
                        stokdari_id: stokdari_id,
                        stoksampai_id: stoksampai_id,
                        dari: dari,
                        sampai: sampai,
                        filter: filter,
                        datafilter: dataFilter
                    },
                }).trigger('reloadGrid');

                $('#btnReport').css('visibility', 'visible')
                $('#btnExport').css('visibility', 'visible')
            } else {
                showDialog('ISI SELURUH KOLOM')
            }

            // window.open(`{{ route('reportall.report') }}?tgl=${tanggal}&data=${data}`)
        })

        $("#jqGrid").jqGrid({
                url: `${apiUrl}kartustok`,
                mtype: "GET",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                datatype: "json",
                colModel: [{
                        label: 'ID',
                        name: 'id',
                        width: '50px'
                    },
                    {
                        label: 'KODE BARANG',
                        name: 'kodebarang',
                        width: '250px'
                    },
                    {
                        label: 'NAMA BARANG',
                        name: 'namabarang',
                        width: '250px'
                    },
                    {
                        label: 'KATEGORI',
                        name: 'kategori_id',
                    },
                    {
                        label: 'QTY MASUK',
                        name: 'qtymasuk',
                        align: 'right',
                        formatter: 'number',
                        formatoptions: {
                            decimalSeparator: '.',
                            thousandsSeparator: ','
                        }
                    },
                    
                    {
                        label: 'NILAI MASUK',
                        name: 'nilaimasuk',
                        align: 'right',
                        formatter: 'number',
                        formatoptions: {
                            decimalSeparator: '.',
                            thousandsSeparator: ','
                        }
                    },
                    {
                        label: 'QTY KELUAR',
                        name: 'qtykeluar',
                        align: 'right',
                        formatter: 'number',
                        formatoptions: {
                            decimalSeparator: '.',
                            thousandsSeparator: ','
                        }
                    },
                    {
                        label: 'NILAI KELUAR',
                        name: 'nilaikeluar',
                        align: 'right',
                        formatter: 'number',
                        formatoptions: {
                            decimalSeparator: '.',
                            thousandsSeparator: ','
                        }
                    },
                    {
                        label: 'QTY SALDO',
                        name: 'qtysaldo',
                        align: 'right',
                        formatter: 'number',
                        formatoptions: {
                            decimalSeparator: '.',
                            thousandsSeparator: ','
                        }
                    },

                    {
                        label: 'NILAI SALDO',
                        name: 'nilaisaldo',
                        align: 'right',
                        formatter: 'number',
                        formatoptions: {
                            decimalSeparator: '.',
                            thousandsSeparator: ','
                        }
                    },


                    {
                        label: 'MODIFIEDBY',
                        name: 'modifiedby',
                    }
                ],
                autowidth: true,
                shrinkToFit: false,
                height: 350,
                rowNum: rowNum,
                rownumbers: true,
                rownumWidth: 45,
                rowList: [10, 20, 50],
                toolbar: [true, "top"],
                cmTemplate: {
                    sortable: false
                },
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

                loadBeforeSend: (jqXHR) => {
                    jqXHR.setRequestHeader('Authorization', `Bearer ${accessToken}`)
                },
                onSelectRow: function(id) {
                    activeGrid = $(this)
                    indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
                    page = $(this).jqGrid('getGridParam', 'page')
                    let limit = $(this).jqGrid('getGridParam', 'postData').limit
                    if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))
                },
                loadComplete: function(data) {
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
                        clearColumnSearch()
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

                    setHighlight($(this))
                },
            })

            .jqGrid('filterToolbar', {
                stringResult: true,
                searchOnEnter: false,
                defaultSearch: 'cn',
                groupOp: 'AND',
                disabledKeys: [17, 33, 34, 35, 36, 37, 38, 39, 40],
                beforeSearch: function() {
                    clearGlobalSearch($('#jqGrid'))
                },
            })

            .customPager({})

        /* Append clear filter button */
        loadClearFilter($('#jqGrid'))

        /* Append global search */
        loadGlobalSearch($('#jqGrid'))


    })

    $(document).on('click', `#btnReport`, function(event) {
        let stokdari_id = $('#crudForm').find('[name=stokdari_id]').val()
        let stoksampai_id = $('#crudForm').find('[name=stoksampai_id]').val()
        let dari = $('#crudForm').find('[name=dari]').val()
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let filter = $('#crudForm').find('[name=filter]').val()
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

        if (stokdari_id != '' && stoksampai_id != '' && dari != '' && sampai != '' && filter != '' && dataFilter != '') {

            window.open(`{{ route('kartustok.report') }}?dari=${dari}&sampai=${sampai}&stokdari_id=${stokdari_id}&stoksampai_id=${stoksampai_id}&filter=${filter}&datafilter=${dataFilter}`)
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })
    
    $(document).on('click', `#btnExport`, function(event) {
        let stokdari_id = $('#crudForm').find('[name=stokdari_id]').val()
        let stoksampai_id = $('#crudForm').find('[name=stoksampai_id]').val()
        let dari = $('#crudForm').find('[name=dari]').val()
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let filter = $('#crudForm').find('[name=filter]').val()
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

        if (stokdari_id != '' && stoksampai_id != '' && dari != '' && sampai != '' && filter != '' && dataFilter != '') {

            window.open(`{{ route('kartustok.export') }}?dari=${dari}&sampai=${sampai}&stokdari_id=${stokdari_id}&stoksampai_id=${stoksampai_id}&filter=${filter}&datafilter=${dataFilter}`)
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })


    $(document).on('change', `#crudForm [name="filter"]`, function(event) {
        let filter = $(this).val();
        $('#crudForm').find('[name=trado_id]').val('')
        $('#crudForm').find('[name=trado]').val('')
        $('#crudForm').find('[name=gudang_id]').val('')
        $('#crudForm').find('[name=gudang]').val('')
        $('#crudForm').find('[name=gandengan_id]').val('')
        $('#crudForm').find('[name=gandengan]').val('')

        if (filter == '186') {
            $('#gudang').show()
            $('#trado').hide()
            $('#gandengan').hide()
        } else if (filter == '187') {
            $('#trado').show()
            $('#gudang').hide()
            $('#gandengan').hide()
        } else if (filter == '188') {
            $('#gandengan').show()
            $('#gudang').hide()
            $('#trado').hide()
        } else {
            $('#trado').hide()
            $('#gudang').hide()
            $('#gandengan').hide()
        }
    })

    function initLookup() {

        $('.stokdari-lookup').lookup({
            title: 'Stok Lookup',
            fileName: 'stok',
            onSelectRow: (stok, element) => {
                $('#crudForm [name=stokdari_id]').first().val(stok.id)
                element.val(stok.namastok)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=stokdari_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
        $('.stoksampai-lookup').lookup({
            title: 'Stok Lookup',
            fileName: 'stok',
            onSelectRow: (stok, element) => {
                $('#crudForm [name=stoksampai_id]').first().val(stok.id)
                element.val(stok.namastok)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=stoksampai_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
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

    const setFilterOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=filter]').empty()
            relatedForm.find('[name=filter]').append(
                new Option('-- PILIH FILTER --', '', false, true)
            ).trigger('change')

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
                        relatedForm.find('[name=filter]').append(option).trigger('change')
                    });

                }
            })
        })
    }
</script>
@endpush()
@endsection