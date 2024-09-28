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
                        {{-- <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Periode<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="sampai" class="form-control datepicker">
                                </div>
                            </div>
                            <label class="col-12 col-sm-2 col-form-label mt-2">Minggu ke<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="minggu" class="form-control datepicker">
                                </div>
                            </div>
                            
                        </div> --}}

                        <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Periode<span class="text-danger">*</span></label>
                            <div class="col-sm-10 mt-2">
                                <div class="input-group">
                                    <input type="text" name="dari" class="form-control datepicker">
                                </div>
                            </div>
                        </div>

                        <div class="form-group row agen">
                            <label class="col-12 col-sm-2 col-form-label mt-2">CUSTOMER (DARI)</label>
                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="agendari_id">
                                <input type="text" id="agendari" name="agendari" class="form-control agendari-lookup">
                            </div>
                            <h5 class="col-sm-1 mt-3 text-center">s/d</h5>
                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="agensampai_id">
                                <input type="text" id="agensampai" name="agensampai" class="form-control agensampai-lookup">
                            </div>
                        </div>

                        <div class="form-group row shipper">
                            <label class="col-12 col-sm-2 col-form-label mt-2">SHIPPER (DARI)</label>
                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="pelanggandari_id">
                                <input type="text" id="pelanggandari" name="pelanggandari" class="form-control pelanggandari-lookup">
                            </div>
                            <h5 class="col-sm-1 mt-3 text-center">s/d</h5>
                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="pelanggansampai_id">
                                <input type="text" id="pelanggansampai" name="pelanggansampai" class="form-control pelanggansampai-lookup">
                            </div>
                        </div>


                        <div class="row">

                            <div class="col-sm-6 mt-4">
                                <button type="button" id="btnPreview" class="btn btn-info mr-1 ">
                                    <i class="fas fa-print"></i>
                                    Report
                                </button>
                                <button type="button" id="btnExport" class="btn btn-warning mr-1 ">
                                    <i class="fas fa-file-export"></i>
                                    Export
                                </button>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
            <table id="jqGrid"></table>
        </div>
    </div>
</div>
@push('report-scripts')
{{-- <link rel="stylesheet" type="text/css" href="{{ asset('libraries/stimulsoft-report/2023.1.1/css/stimulsoft.viewer.office2013.whiteblue.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('libraries/stimulsoft-report/2023.1.1/css/stimulsoft.designer.office2013.whiteblue.css') }}"> --}}
<script type="text/javascript" src="{{ asset('libraries/stimulsoft-report/2023.1.1/scripts/stimulsoft.reports.js') }}"></script>
{{-- <script type="text/javascript" src="{{ asset('libraries/stimulsoft-report/2023.1.1/scripts/stimulsoft.viewer.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries/stimulsoft-report/2023.1.1/scripts/stimulsoft.designer.js') }}"></script> --}}
@endpush()
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
        initSelect2($('#crudForm').find('[name=status]'), false)
        setLaporanPiutangPerAgen($('#crudForm'))
        if (accessCabang == 'BITUNG-EMKL') {
            $('.agen').hide()
            $('.pelanggan').show()
        } else {
            $('.agen').show()
            $('.pelanggan').hide()
        }
        initDatepicker()
        $('#crudForm').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=ambildari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=ambilsampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');


        if (!`{{ $myAuth->hasPermission('laporankartupiutangperagen', 'report') }}`) {
            $('#btnPreview').attr('disabled', 'disabled')
        }
        if (!`{{ $myAuth->hasPermission('laporankartupiutangperagen', 'export') }}`) {
            $('#btnExport').attr('disabled', 'disabled')
        }
        initLookup()
    })

    $(document).on('click', `#btnPreview`, function(event) {
        let dari = $('#crudForm').find('[name=dari]').val()
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let agendari_id = $('#crudForm').find('[name=agendari_id]').val()
        let agensampai_id = $('#crudForm').find('[name=agensampai_id]').val()
        let agendari = $('#crudForm').find('[name=agendari]').val()
        let agensampai = $('#crudForm').find('[name=agensampai]').val()

        $.ajax({
                url: `${apiUrl}laporankartupiutangperagen/report`,
                method: 'GET',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    dari: dari,
                    sampai: sampai,
                    agendari_id: agendari_id,
                    agensampai_id: agensampai_id,
                    agendari: agendari,
                    agensampai: agensampai,
                    pelanggandari_id: $('#crudForm').find('[name=pelanggandari_id]').val(),
                    pelanggansampai_id: $('#crudForm').find('[name=pelanggansampai_id]').val(),
                    pelanggandari: $('#crudForm').find('[name=pelanggandari]').val(),
                    pelanggansampai: $('#crudForm').find('[name=pelanggansampai]').val(),
                },
                success: function(response) {
                    // console.log(response)
                    let data = response.data
                    let dataCabang = response.namacabang
                    let detailParams = {
                        dari: dari,
                        sampai: sampai,
                        agendari_id: agendari_id,
                        agensampai_id: agensampai_id,
                        agendari: agendari,
                        agensampai: agensampai,
                        pelanggandari_id: $('#crudForm').find('[name=pelanggandari_id]').val(),
                        pelanggansampai_id: $('#crudForm').find('[name=pelanggansampai_id]').val(),
                        pelanggandari: $('#crudForm').find('[name=pelanggandari]').val(),
                        pelanggansampai: $('#crudForm').find('[name=pelanggansampai]').val(),
                    };
                    let cabang = accessCabang

                    laporankartupiutangperagen(data, detailParams, dataCabang, cabang);
                },
                error: function(error) {
                    if (error.status === 422) {
                        $('.is-invalid').removeClass('is-invalid');
                        $('.invalid-feedback').remove();
                        $('#rangeTglModal').modal('hide')
                        setErrorMessages($('#crudForm'), error.responseJSON.errors);
                    } else {
                        showDialog(error.responseJSON.message);
                    }
                }
            })
            .always(() => {
                $('#processingLoader').addClass('d-none')
            });

    })

    $(document).on('click', `#btnExport`, function(event) {
        $('#processingLoader').removeClass('d-none')

        let dari = $('#crudForm').find('[name=dari]').val()
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let agendari_id = $('#crudForm').find('[name=agendari_id]').val()
        let agensampai_id = $('#crudForm').find('[name=agensampai_id]').val()
        let agendari = $('#crudForm').find('[name=agendari]').val()
        let agensampai = $('#crudForm').find('[name=agensampai]').val()

        $.ajax({
            url: `${apiUrl}laporankartupiutangperagen/export`,
            // url: `{{ route('laporankartupiutangperagen.export') }}?dari=${dari}&sampai=${sampai}&agendari_id=${agendari_id}&agensampai_id=${agensampai_id}&agendari=${agendari}&agensampai=${agensampai}`,
            type: 'GET',
            data: {
                dari: dari,
                sampai: sampai,
                agendari_id: agendari_id,
                agensampai_id: agensampai_id,
                agendari: agendari,
                agensampai: agensampai,
                pelanggandari_id: $('#crudForm').find('[name=pelanggandari_id]').val(),
                pelanggansampai_id: $('#crudForm').find('[name=pelanggansampai_id]').val(),
                pelanggandari: $('#crudForm').find('[name=pelanggandari]').val(),
                pelanggansampai: $('#crudForm').find('[name=pelanggansampai]').val(),
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
                        link.download = 'LAPORAN KARTU PIUTANG PER CUSTOMER ' + new Date().getTime() + '.xlsx';
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
    })

    function laporankartupiutangperagen(data, detailParams, dataCabang, cabang) {
        Stimulsoft.Base.StiLicense.loadFromFile("{{ asset('libraries/stimulsoft-report/2023.1.1/license.php') }}");
        Stimulsoft.Base.StiFontCollection.addOpentypeFontFile("{{ asset('libraries/stimulsoft-report/2023.1.1/font/SourceSansPro.ttf') }}", "SourceSansPro");

        var report = new Stimulsoft.Report.StiReport();
        var dataSet = new Stimulsoft.System.Data.DataSet("Data");

        if (cabang == 'MEDAN') {
            report.loadFile(`{{ asset('public/reports/ReportLaporanKartuPiutangPerAgenA4.mrt') }}`);
        } else if (cabang == 'MAKASSAR') {
            report.loadFile(`{{ asset('public/reports/ReportLaporanKartuPiutangPerAgenLetter.mrt') }}`);
        } else {
            report.loadFile(`{{ asset('public/reports/ReportLaporanKartuPiutangPerAgen.mrt') }}`);
        }

        dataSet.readJson({
            'data': data,
            'dataCabang': dataCabang,
            'parameter': detailParams
        });

        report.regData(dataSet.dataSetName, '', dataSet);
        report.dictionary.synchronize();

        // var options = new Stimulsoft.Designer.StiDesignerOptions()
        // options.appearance.fullScreenMode = true
        // var designer = new Stimulsoft.Designer.StiDesigner(options, "Designer", false)
        // designer.report = report;
        // designer.renderHtml('content');

        report.renderAsync(function() {
            report.exportDocumentAsync(function(pdfData) {
                let blob = new Blob([new Uint8Array(pdfData)], {
                    type: 'application/pdf'
                });
                let fileURL = URL.createObjectURL(blob);
                window.open(fileURL, '_blank');
                manipulatePdfWithJsPdf(pdfData);
            }, Stimulsoft.Report.StiExportFormat.Pdf);
        });
    }

    function getCekExport() {

        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}laporankartupiutangperagen/export`,
                dataType: "JSON",
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    dari: $('#crudForm').find('[name=dari]').val(),
                    sampai: $('#crudForm').find('[name=sampai]').val(),
                    agendari_id: $('#crudForm').find('[name=agendari_id]').val(),
                    agensampai_id: $('#crudForm').find('[name=agensampai_id]').val(),
                    agendari: $('#crudForm').find('[name=agendari]').val(),
                    agensampai: $('#crudForm').find('[name=agensampai]').val(),
                    pelanggandari_id: $('#crudForm').find('[name=pelanggandari_id]').val(),
                    pelanggansampai_id: $('#crudForm').find('[name=pelanggansampai_id]').val(),
                    pelanggandari: $('#crudForm').find('[name=pelanggandari]').val(),
                    pelanggansampai: $('#crudForm').find('[name=pelanggansampai]').val(),
                    isCheck: true,
                },
                success: (response) => {
                    resolve(response);
                },
                error: error => {
                    reject(error)

                },
            });
        });
    }

    function initLookup() {

        $('.agendari-lookup').lookupMaster({
            title: 'Customer Lookup',
            fileName: 'agenMaster',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'agendari_id',
                    searchText: 'agendari-lookup',
                    title: 'Customer Lookup',
                    typeSearch: 'ALL',
                }
            },
            onSelectRow: (agen, element) => {
                $('#crudForm [name=agendari_id]').first().val(agen.id)
                element.val(agen.namaagen)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=agendari_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        $('.agensampai-lookup').lookupMaster({
            title: 'Customer Lookup',
            fileName: 'agenMaster',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'agensampai_id',
                    searchText: 'agensampai-lookup',
                    title: 'Customer Lookup',
                    typeSearch: 'ALL',
                }
            },
            onSelectRow: (agen, element) => {
                $('#crudForm [name=agensampai_id]').first().val(agen.id)
                element.val(agen.namaagen)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=agensampai_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        $('.pelanggandari-lookup').lookupMaster({
            title: 'Shipper Lookup',
            fileName: 'pelangganMaster',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'pelanggandari_id',
                    searchText: 'pelanggandari-lookup',
                    title: 'Shipper Lookup',
                    typeSearch: 'ALL',
                }
            },
            onSelectRow: (pelanggan, element) => {
                $('#crudForm [name=pelanggandari_id]').first().val(pelanggan.id)
                element.val(pelanggan.namapelanggan)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=pelanggandari_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        $('.pelanggansampai-lookup').lookupMaster({
            title: 'Shipper Lookup',
            fileName: 'pelangganMaster',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'pelanggansampai_id',
                    searchText: 'pelanggansampai-lookup',
                    title: 'Shipper Lookup',
                    typeSearch: 'ALL',
                }
            },
            onSelectRow: (pelanggan, element) => {
                $('#crudForm [name=pelanggansampai_id]').first().val(pelanggan.id)
                element.val(pelanggan.namapelanggan)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=pelanggansampai_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
    }

    const setLaporanPiutangPerAgen = function(relatedForm) {
        // return new Promise((resolve, reject) => {
        // relatedForm.find('[name=approve]').empty()
        relatedForm.find('[name=status]').append(
            new Option('-- PILIH STATUS KEMBALI --', '', false, true)
        ).trigger('change')

        let data = [];
        data.push({
            name: 'grp',
            value: 'LAPORAN PEMBELIAN'
        })
        data.push({
            name: 'subgrp',
            value: 'LAPORAN PEMBELIAN'
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

                response.data.forEach(laporanPembelian => {
                    let option = new Option(laporanPembelian.text, laporanPembelian.text)
                    relatedForm.find('[name=status]').append(option).trigger('change')
                });

                // relatedForm
                //     .find('[name=approve]')
                //     .val($(`#crudForm [name=approve] option:eq(1)`).val())
                //     .trigger('change')
                //     .trigger('select2:selected');

                // resolve()
            }
        })
        // })
    }
</script>
@endpush()
@endsection