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
                            <label class="col-12 col-sm-2 col-form-label mt-2">Kategori</label>

                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="kelompok_id">
                                <input type="text" name="kelompok" class="form-control kelompok-lookup">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12 col-sm-2 col-form-label mt-2">
                                <label class="">STATUS TAMPIL<span class="text-danger">*</span></label>
                            </div>
                            <div class="col-sm-4 mt-2">
                                <select name="statustampil" id="statustampil" class="form-select select2bs4" style="width: 100%;">
                                </select>
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
                                    <input type="text" name="gandengan" id="gandengan" class="form-control gandengan-lookup">
                                </div>
                            </div>
                        </div>
                        <div class="row">

                            <div class="col-sm-6 mt-4">
                                <a id="btnPreview" class="btn btn-primary mr-2 ">
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
    let hasDetail = false

    $(document).ready(function() {

        initSelect2($('#crudForm').find('[name=filter]'), false)
        initSelect2($('#crudForm').find('[name=statustampil]'), false)
        initLookup()
        setFilterOptions($('#crudForm'))
        setStatusTampilOptions($('#crudForm'))
        initDatepicker()


        showDefault($('#crudForm'))
            .then(response => {
                // console.log(response);
                // $.each(response.data.stokdari, (index, value) => {
                //     let element = form.find(`[name="${index}"]`);
                //     element.val(value);
                // });
                // $.each(response.data.stoksampai, (index, value) => {
                //     let element = form.find(`[name="${index}"]`);
                //     element.val(value);
                // });
                // $.each(response.data.gudang, (index, value) => {
                //     let element = form.find(`[name="${index}"]`);
                //     element.val(value);
                // });
                // $.each(response.data.filter, (index, value) => {
                //     let element = form.find(`[name="${index}"]`);
                //     element.val(value).trigger('change');
                // });
                // $.each(response.data.trado, (index, value) => {
                //     let element = form.find(`[name="${index}"]`);
                //     element.val(value);
                // });
                // $.each(response.data.gandengan, (index, value) => {
                //     let element = form.find(`[name="${index}"]`);
                //     element.val(value);
                // });
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



                $('#jqGrid').jqGrid('setGridParam', {
                    url: `${apiUrl}kartustok`,
                    postData: {
                        dari: $('#crudForm').find('[name=dari]').val(),
                        sampai: $('#crudForm').find('[name=sampai]').val(),
                        stokdari_id: $('#crudForm').find('[name=stokdari_id]').val(),
                        stoksampai_id: $('#crudForm').find('[name=stoksampai_id]').val(),
                        filter: $('#crudForm').find('[name=filter]').val(),
                        stokdari: $('#crudForm').find('[name=stokdari]').val(),
                        stoksampai: $('#crudForm').find('[name=stoksampai]').val(),
                        gudang: $('#crudForm').find('[name=gudang]').val(),
                        gudang_id: $('#crudForm').find('[name=gudang_id]').val(),
                        gandengan: $('#crudForm').find('[name=gandengan]').val(),
                        gandengan_id: $('#crudForm').find('[name=gandengan_id]').val(),
                        trado: $('#crudForm').find('[name=trado]').val(),
                        trado_id: $('#crudForm').find('[name=trado_id]').val(),
                        proses: 'reload',
                        kelompok_id: $('#crudForm').find('[name=kelompok_id]').val(),
                        statustampil: $('#crudForm').find('[name=statustampil]').val(),
                        datafilter: dataFilter,

                    },
                    datatype: "json"
                }).trigger('reloadGrid');
            })
            .catch(error => {
                console.error(error);
            });

        // mendapatkan tanggal hari ini
        let today = new Date();

        let form = $('#crudForm');

        // mendapatkan tanggal pertama di bulan ini
        let firstDay = new Date(today.getFullYear(), today.getMonth(), 1);
        let formattedFirstDay = $.datepicker.formatDate('dd-mm-yy', firstDay);

        // mendapatkan tanggal terakhir di bulan ini
        let lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0);
        let formattedLastDay = $.datepicker.formatDate('dd-mm-yy', lastDay);

        $('#crudForm').find('[name=dari]').val(formattedFirstDay).trigger('change');
        $('#crudForm').find('[name=sampai]').val(formattedLastDay).trigger('change');

        $('#btnPreview').click(function(event) {

            let stokdari_id = $('#crudForm').find('[name=stokdari_id]').val()
            let stoksampai_id = $('#crudForm').find('[name=stoksampai_id]').val()
            let kelompok_id = $('#crudForm').find('[name=kelompok_id]').val()
            let dari = $('#crudForm').find('[name=dari]').val()
            let sampai = $('#crudForm').find('[name=sampai]').val()
            let statustampil = $('#crudForm').find('[name=statustampil]').val()
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

            if (dari != '' && sampai != '' && filter != '') {

                $('#jqGrid').jqGrid('setGridParam', {
                    postData: {
                        stokdari_id: stokdari_id,
                        stoksampai_id: stoksampai_id,
                        kelompok_id: kelompok_id,
                        statustampil: statustampil,
                        dari: dari,
                        sampai: sampai,
                        filter: filter,
                        datafilter: dataFilter,
                        proses: 'reload'
                    },
                }).trigger('reloadGrid');

            } else {
                showDialog('ISI SELURUH KOLOM')
            }

            // window.open(`{{ route('reportall.report') }}?tgl=${tanggal}&data=${data}`)
        })


        $("#jqGrid").jqGrid({

                mtype: "GET",
                styleUI: 'Bootstrap4',
                iconSet: 'fontAwesome',
                datatype: "local",
                colModel: [{
                        label: 'NO BUKTI',
                        name: 'nobukti',
                    },
                    {
                        label: 'TGL BUKTI',
                        name: 'tglbukti',
                        formatter: "date",
                        formatoptions: {
                            srcformat: "ISO8601Long",
                            newformat: "d-m-Y"
                        }
                    },
                    {
                        label: 'Lokasi',
                        name: 'lokasi',
                    },
                    {
                        label: 'KODE BARANG',
                        name: 'kodebarang',
                    },
                    {
                        label: 'NAMA BARANG',
                        name: 'namabarang',
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
                cmTemplate: {
                    sortable: true
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
                    setGridLastRequest($(this), jqXHR)
                },
                onSelectRow: function(id) {
                    activeGrid = $(this)
                    indexRow = $(this).jqGrid('getCell', id, 'rn') - 1
                    page = $(this).jqGrid('getGridParam', 'page')
                    let limit = $(this).jqGrid('getGridParam', 'postData').limit
                    if (indexRow >= limit) indexRow = (indexRow - limit * (page - 1))
                },
                // loadError: function(error) {
                //     if (error.status === 422) {
                //         $('.is-invalid').removeClass('is-invalid')
                //         $('.invalid-feedback').remove()

                //         setErrorMessages(form, error.responseJSON.errors);
                //     } else {
                //         showDialog(error.statusText)
                //     }
                // },
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
                    $('#jqGrid').setGridParam({
                        postData: {
                            proses: "page"
                        }
                    })
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
                        let stokdari_id = $('#crudForm').find('[name=stokdari_id]').val()
                        let stoksampai_id = $('#crudForm').find('[name=stoksampai_id]').val()
                        let kelompok_id = $('#crudForm').find('[name=kelompok_id]').val()
                        let dari = $('#crudForm').find('[name=dari]').val()
                        let sampai = $('#crudForm').find('[name=sampai]').val()
                        let statustampil = $('#crudForm').find('[name=statustampil]').val()
                        let filter = $('#crudForm').find('[name=filter]').val()
                        let dataFilter = ''
                        let proses = 'reload'
                        if (filter == '186') {
                            dataFilter = $('#crudForm').find('[name=gudang_id]').val()
                        }
                        if (filter == '187') {
                            dataFilter = $('#crudForm').find('[name=trado_id]').val()
                        }
                        if (filter == '188') {
                            dataFilter = $('#crudForm').find('[name=gandengan_id]').val()
                        }

                        if (dari != '' && sampai != '' && filter != '') {

                            window.open(
                                `{{ route('kartustok.report') }}?dari=${dari}&sampai=${sampai}&stokdari_id=${stokdari_id}&stoksampai_id=${stoksampai_id}&kelompok_id=${kelompok_id}&statustampil=${statustampil}&filter=${filter}&datafilter=${dataFilter}&proses=${proses}`
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
                        let stokdari_id = $('#crudForm').find('[name=stokdari_id]').val()
                        let stoksampai_id = $('#crudForm').find('[name=stoksampai_id]').val()
                        let kelompok_id = $('#crudForm').find('[name=kelompok_id]').val()
                        let dari = $('#crudForm').find('[name=dari]').val()
                        let sampai = $('#crudForm').find('[name=sampai]').val()
                        let statustampil = $('#crudForm').find('[name=statustampil]').val()
                        let filter = $('#crudForm').find('[name=filter]').val()
                        let proses = 'reload'
                        let dataFilter = ''
                        if (filter == '186') {
                            dataFilter = $('#crudForm').find('[name=gudang_id]').val()
                        } else if (filter == '187') {
                            dataFilter = $('#crudForm').find('[name=trado_id]').val()
                        } else if (filter == '188') {
                            dataFilter = $('#crudForm').find('[name=gandengan_id]').val()
                        } else {
                            let dataFilter = '1'
                        }

                        if (dari != '' && sampai != '' && filter != '') {

                            // window.open(
                            //     `{{ route('kartustok.export') }}?dari=${dari}&sampai=${sampai}&stokdari_id=${stokdari_id}&stoksampai_id=${stoksampai_id}&kelompok_id=${kelompok_id}&statustampil=${statustampil}&filter=${filter}&datafilter=${dataFilter}&proses=${proses}`
                            // )
                            $.ajax({
                                url: `${apiUrl}kartustok/export`,
                                type: 'GET',
                                data: {
                                    stokdari_id : stokdari_id,
                                    stoksampai_id : stoksampai_id,
                                    dari : dari,
                                    sampai : sampai,
                                    filter : filter,
                                    datafilter : dataFilter,
                                    statustampil : statustampil,
                                    kelompok_id : kelompok_id,
                                    limit : 0
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
                                            link.download = 'KARTU STOK' + new Date().getTime() + '.xlsx';
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
                }, ]
            })

        /* Append clear filter button */
        loadClearFilter($('#jqGrid'))

        /* Append global search */
        loadGlobalSearch($('#jqGrid'))

        function permission() {


            if (!`{{ $myAuth->hasPermission('kartustok', 'report') }}`) {
                $('#report').attr('disabled', 'disabled')
            }
            if (!`{{ $myAuth->hasPermission('kartustok', 'export') }}`) {
                $('#export').attr('disabled', 'disabled')
            }
        }

        // showDefault($('#crudForm'))
    })

    function showDefault(form) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}kartustok/default`,
                method: 'GET',
                dataType: 'JSON',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                success: response => {
                    $.each(response.data, (index, value) => {
                        let element = form.find(`[name="${index}"]`)
                        if (element.is('select')) {
                            element.val(value).trigger('change')
                        } else {
                            element.val(value)
                        }
                    })
                    resolve(response);
                },
                error: error => {
                    reject(error);
                }
            });
        });
    }

    $(document).on('change', `#crudForm [name="filter"]`, function(event) {

        let filter = $(this).val();
        // $('#crudForm').find('[name=trado_id]').val('')
        // $('#crudForm').find('[name=trado]').val('')
        // $('#crudForm').find('[name=gudang_id]').val('')
        // $('#crudForm').find('[name=gudang]').val('')
        // $('#crudForm').find('[name=gandengan_id]').val('')
        // $('#crudForm').find('[name=gandengan]').val('')

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
            $('#gandengan').hide()
            $('#gudang').hide()
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
                element.val(trado.kodetrado)
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

        // $('.gandengan-lookup').lookupMaster({
        //     title: 'Gandengan Lookup',
        //     fileName: 'gandenganMaster',
        //     typeSearch: 'ALL',
        //     searching: 1,
        //     beforeProcess: function(test) {
        //         this.postData = {
        //         searching: 1,
        //         valueName: 'kelompok_id',
        //         searchText: 'gandengan-lookup',
        //         title: 'gandengan',
        //         typeSearch: 'ALL',
        //         }
        //     },
        //     onSelectRow: (gandengan, element) => {
        //         $('#crudForm [name=gandengan_id]').first().val(gandengan.id)
        //         element.val(gandengan.keterangan)
        //         element.data('currentValue', element.val())
        //     },
        //     onCancel: (element) => {
        //         element.val(element.data('currentValue'))
        //     },
        //     onClear: (element) => {
        //         $('#crudForm [name=gandengan_id]').first().val('')
        //         element.val('')
        //         element.data('currentValue', element.val())
        //     }
        // })

        $('.kelompok-lookup').lookup({
            title: 'Kelompok Lookup',
            fileName: 'kelompok',
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                }
            },
            onSelectRow: (kelompok, element) => {
                $('#crudForm [name=kelompok_id]').first().val(kelompok.id)
                element.val(kelompok.kodekelompok)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=kelompok_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

    }

    const setFilterOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=filter]').empty()
            relatedForm.find('[name=filter]').append(
                new Option('-- SEMUA --', '0', false, true)
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
                        relatedForm.find('[name=filter]').append(option).trigger(
                            'change')
                    });

                }
            })
        })
    }
    const setStatusTampilOptions = function(relatedForm) {
        return new Promise((resolve, reject) => {
            relatedForm.find('[name=statustampil]').empty()
            relatedForm.find('[name=statustampil]').append(
                new Option('-- SEMUA --', '0', false, true)
            ).trigger('change')

            let data = [];
            data.push({
                name: 'grp',
                value: 'STATUS TAMPILAN KARTU STOK'
            })
            data.push({
                name: 'subgrp',
                value: 'STATUS TAMPILAN KARTU STOK'
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

                    response.data.forEach(statusTampil => {
                        let option = new Option(statusTampil.text, statusTampil.id)
                        relatedForm.find('[name=statustampil]').append(option).trigger(
                            'change')
                    });

                }
            })
        })
    }
</script>
@endpush()
@endsection