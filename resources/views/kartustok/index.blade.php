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
                                <label class="col-12 col-sm-2 col-form-label mt-2">Periode<span
                                        class="text-danger">*</span></label>
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
                                <label class="col-12 col-sm-2 col-form-label mt-2">STOK<span
                                        class="text-danger">*</span></label>

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
                                <label class="col-12 col-sm-2 col-form-label mt-2">FILTER<span
                                        class="text-danger">*</span></label>

                                <div class="col-sm-4 col-md-4 mt-2">
                                    <select name="filter" id="filter" class="form-select select2bs4"
                                        style="width: 100%;">

                                    </select>
                                </div>
                            </div>
                            <div class="row" id="gudang">
                                <label class="col-12 col-sm-2 col-form-label mt-2">GUDANG<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-4 mt-2">
                                    <div class="input-group">
                                        <input type="hidden" name="gudang_id">
                                        <input type="text" name="gudang" class="form-control gudang-lookup">
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="trado">
                                <label class="col-12 col-sm-2 col-form-label mt-2">TRADO<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-4 mt-2">
                                    <div class="input-group">
                                        <input type="hidden" name="trado_id">
                                        <input type="text" name="trado" class="form-control trado-lookup">
                                    </div>
                                </div>
                            </div>
                            <div class="row" id="gandengan">
                                <label class="col-12 col-sm-2 col-form-label mt-2">GANDENGAN<span
                                        class="text-danger">*</span></label>
                                <div class="col-sm-4 mt-2">
                                    <div class="input-group">
                                        <input type="hidden" name="gandengan_id">
                                        <input type="text" name="gandengan" class="form-control gandengan-lookup">
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
            let activeGrid;
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
            let ajaxdefault = null

            $(document).ready(function() {

                initSelect2($('#crudForm').find('[name=filter]'), false)
                initLookup()
                setFilterOptions($('#crudForm'))
                initDatepicker()

                showDefault($('#crudForm'))
                .then(response => {
                    
                    $.each(response.data.stokdari, (index, value) => {
                        let element = form.find(`[name="${index}"]`);
                        element.val(value);
                    });
                    $.each(response.data.stoksampai, (index, value) => {
                        let element = form.find(`[name="${index}"]`);
                        element.val(value);
                    });
                    $.each(response.data.gudang, (index, value) => {
                        let element = form.find(`[name="${index}"]`);
                        element.val(value);
                    });
                    // $.each(response.data.filter, (index, value) => {
                    //     let element = form.find(`[name="${index}"]`);
                    //     element.val(value).trigger('change');
                    // });
                    $.each(response.data.trado, (index, value) => {
                        let element = form.find(`[name="${index}"]`);
                        element.val(value);
                    });
                    $.each(response.data.gandengan, (index, value) => {
                        let element = form.find(`[name="${index}"]`);
                        element.val(value);
                    });
                    
                    getKartuStok()
                    // var data = [
                    //     {
                    //         "lokasi": "GUDANG KANTOR",
                    //         "kodebarang": "1",
                    //         "namabarang": "0007255076",
                    //         "tglbukti": "2023-07-01 00:00:00.000",
                    //         "nobukti": "Saldo Awal",
                    //         "kategori_id": "BATERAI NAGOYA N-120",
                    //         "qtymasuk": "0.0",
                    //         "nilaimasuk": "0.0",
                    //         "qtykeluar": "0.0",
                    //         "nilaikeluar": "0.0",
                    //         "qtysaldo": "0.0",
                    //         "nilaisaldo": "0.0",
                    //         "modifiedby": ""
                    //     },
                    //     {
                    //         "lokasi": "GUDANG KANTOR",
                    //         "kodebarang": "1",
                    //         "namabarang": "0007255076",
                    //         "tglbukti": "2023-07-03 00:00:00.000",
                    //         "nobukti": "SPB 0001\/VII\/2023",
                    //         "kategori_id": "BATERAI NAGOYA N-120",
                    //         "qtymasuk": "50.0",
                    //         "nilaimasuk": "12000000.0",
                    //         "qtykeluar": "0.0",
                    //         "nilaikeluar": "0.0",
                    //         "qtysaldo": "50.0",
                    //         "nilaisaldo": "12000000.0",
                    //         "modifiedby": "ADMIN"
                    //     },
                    //     {
                    //         "lokasi": "GUDANG KANTOR",
                    //         "kodebarang": "1",
                    //         "namabarang": "0007255076",
                    //         "tglbukti": "2023-07-03 00:00:00.000",
                    //         "nobukti": "PSPK 0001\/VII\/2023",
                    //         "kategori_id": "BATERAI NAGOYA N-120",
                    //         "qtymasuk": "1.0",
                    //         "nilaimasuk": "240000.0",
                    //         "qtykeluar": "0.0",
                    //         "nilaikeluar": "0.0",
                    //         "qtysaldo": "51.0",
                    //         "nilaisaldo": "12240000.0",
                    //         "modifiedby": "ADMIN"
                    //     },
                    //     {
                    //         "lokasi": "GUDANG KANTOR",
                    //         "kodebarang": "1",
                    //         "namabarang": "0007255076",
                    //         "tglbukti": "2023-07-03 00:00:00.000",
                    //         "nobukti": "SPK 0001\/VII\/2023",
                    //         "kategori_id": "BATERAI NAGOYA N-120",
                    //         "qtymasuk": "0.0",
                    //         "nilaimasuk": "0.0",
                    //         "qtykeluar": "2.0",
                    //         "nilaikeluar": "480000.0",
                    //         "qtysaldo": "49.0",
                    //         "nilaisaldo": "11760000.0",
                    //         "modifiedby": "ADMIN"
                    //     },
                    //     {
                    //         "lokasi": "GUDANG PIHAK III",
                    //         "kodebarang": "1",
                    //         "namabarang": "0007255076",
                    //         "tglbukti": "2023-07-01 00:00:00.000",
                    //         "nobukti": "Saldo Awal",
                    //         "kategori_id": "BATERAI NAGOYA N-120",
                    //         "qtymasuk": "0.0",
                    //         "nilaimasuk": "0.0",
                    //         "qtykeluar": "0.0",
                    //         "nilaikeluar": "0.0",
                    //         "qtysaldo": "0.0",
                    //         "nilaisaldo": "0.0",
                    //         "modifiedby": ""
                    //     },
                    // ];
                    // console.log(data);
                    // $('#jqGrid').jqGrid('setGridParam', {
                    //     datatype: "local",
                    //     data:data,
                    //     rowNum: data.length
                    // }).trigger('reloadGrid');     
                        
                    // $('#jqGrid').jqGrid('setGridParam', {
                    //     url: `${apiUrl}kartustok`,
                    //     postData: {
                            

                    //     },
                    //     datatype: "json"
                    // }).trigger('reloadGrid');
                })
                // .catch(error => {
                //     console.error(error);
                // });


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
                    let dari = $('#crudForm').find('[name=dari]').val()
                    let sampai = $('#crudForm').find('[name=sampai]').val()
                    let filter = $('#crudForm').find('[name=filter]').val()
                    let stokdari =  $('#crudForm').find('[name=stokdari]').val()
                    let stoksampai =  $('#crudForm').find('[name=stoksampai]').val()
                    let gudang =  $('#crudForm').find('[name=gudang]').val()
                    let gudang_id =  $('#crudForm').find('[name=gudang_id]').val()
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

                    if (stokdari_id != '' && stoksampai_id != '' && dari != '' && sampai != '' && filter != '') {
                        $('#jqGrid').jqGrid('setGridParam', { data:[] })
                        $('#jqGrid').trigger('reloadGrid');
                        getKartuStok()
                       

                    } else {
                        showDialog('ISI SELURUH KOLOM')
                    }

                    // window.open(`{{ route('reportall.report') }}?tgl=${tanggal}&data=${data}`)
                })
                    
                
                $("#jqGrid").jqGrid({
                    
                    // mtype: "GET",
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
                            label: 'MODIFIEDBY',
                            name: 'modifiedby',
                        }
                    ],
                    autowidth: true,
                    shrinkToFit: false,
                    height: 350,
                    rowNum: 10,
                    rownumbers: true,
                    rownumWidth: 45,
                    rowList: [10, 20, 50],
                    toolbar: [true, "top"],
                    sortable: true,
                    // pager:"#gridStatusAbsenPager",
                    viewrecords: true,
                    emptyrecords: "No records to display",


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
                    loadError: function(error) {
                        if (error.status === 422) {
                            $('.is-invalid').removeClass('is-invalid')
                            $('.invalid-feedback').remove()

                            setErrorMessages(form, error.responseJSON.errors);
                        } else {
                            showDialog(error.statusText)
                        }
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
                        clearGlobalSearch($('#jqGrid'))
                    },
                })
                .customPager({
                    
                    buttons: [{
                        id: 'export',
                        innerHTML: '<i class="fas fa-file-export"></i> EXPORT',
                        class: 'btn btn-warning btn-sm mr-1',
                        onClick: function(event) {
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
    
                            if (stokdari_id != '' && stoksampai_id != '' && dari != '' && sampai !=
                                '' && filter != '' ) {
    
                                window.open(
                                    `{{ route('kartustok.export') }}?dari=${dari}&sampai=${sampai}&stokdari_id=${stokdari_id}&stoksampai_id=${stoksampai_id}&filter=${filter}&datafilter=${dataFilter}`
                                )
                            } else {
                                showDialog('ISI SELURUH KOLOM')
                            }
                        }
                        
                        
                        
                    }, {
                        id: 'report',
                        innerHTML: '<i class="fa fa-print"></i> REPORT',
                        class: 'btn btn-info btn-sm mr-1',
                        onClick: function(event) {
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
    
                            if (stokdari_id != '' && stoksampai_id != '' && dari != '' && sampai !=
                                '' && filter != '') {
    
                                window.open(
                                    `{{ route('kartustok.report') }}?dari=${dari}&sampai=${sampai}&stokdari_id=${stokdari_id}&stoksampai_id=${stoksampai_id}&filter=${filter}&datafilter=${dataFilter}`
                                )
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


                if (!`{{ $myAuth->hasPermission('kartustok', 'export') }}`) {
                    $('#export').attr('disabled', 'disabled')
                }

                if (!`{{ $myAuth->hasPermission('kartustok', 'report') }}`) {
                    $('#report').attr('disabled', 'disabled')
                }

                showDefault($('#crudForm'))
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
                
            function getKartuStok() {
                
                if (ajaxdefault) {
                    ajaxdefault.abort();
                }
                $("#jqGrid")[0].grid.beginReq();
                // $('#loader').removeClass('d-none')

                
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
                let gridArrayData;
                ajaxdefault = $.ajax({
                    url: `${apiUrl}kartustok`,
                    method: 'GET',
                    dataType: 'JSON',
                    data: {
                        limit: 0,
                        sortIndex:sortname,
                        sortOrder:sortorder,
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
                        datafilter:dataFilter,
                    },
                    headers: {
                        Authorization: `Bearer ${accessToken}`
                    },
                    success: response => {
                        $('#jqGrid').jqGrid('setGridParam', { 
                            data:[],
                        }).trigger('reloadGrid');
                        $("#jqGrid")[0].grid.endReq();
                        gridArrayData = response.data
                    },
                }).always(() => {
                    $('#jqGrid').jqGrid('setGridParam', { 
                        data:gridArrayData,
                        datatype: "local" 
                    }).trigger('reloadGrid');
                    // $('#loader').addClass('d-none')
                })
                    
                // console.log(gridArrayData);
                    
                    
            }

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
                                relatedForm.find('[name=filter]').append(option).trigger('change')
                            });
                        }
                    })
                })
            }
        </script>
    @endpush()
@endsection
