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
                            <label class="col-12 col-sm-2 col-form-label mt-2">Posisi Akhir Ban Trado</label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="hidden" name="posisiakhirtrado_id" id="tradoId">
                                    <input type="text" id="posisiakhirtrado" name="posisiakhirtrado" class="form-control posisiakhirtrado-lookup">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Posisi Akhir Ban Gandengan</label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="hidden" name="posisiakhirgandengan_id" id="gandenganId">
                                    <input type="text" id="gandenganId" name="posisiakhirgandengan" class="form-control posisiakhirgandengan-lookup">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Parameter</label>
                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="text" id="text">
                                <input type="text" id="text" name="textnama" class="form-control text-lookup">
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

        initDatepicker()
        $('#crudForm').find('[name=dari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=sampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        initLookup()

        if (!`{{ $myAuth->hasPermission('laporanpemakaianban', 'report') }}`) {
            $('#btnPreview').attr('disabled', 'disabled')
        }
        if (!`{{ $myAuth->hasPermission('laporanpemakaianban', 'export') }}`) {
            $('#btnExport').attr('disabled', 'disabled')
        }

    })

    $(document).on('click', `#btnPreview`, function(event) {
        let sampai = $('#crudForm').find('[name=sampai]').val()
        let dari = $('#crudForm').find('[name=dari]').val()
        let posisiakhirtrado = $('#crudForm').find('[name=posisiakhirtrado]').val()
        let posisiakhirtradoId = $('#crudForm').find('[name=posisiakhirtrado_id]').val()
        let posisiakhirgandengan = $('#crudForm').find('[name=posisiakhirgandengan]').val()
        let posisiakhirgandenganId = $('#crudForm').find('[name=posisiakhirgandengan_id]').val()
        let posisiakhirgandengantext = $('#crudForm').find('[name=posisiakhirgandengan]').val()
        let jenislaporan_id = $('#crudForm').find('[name=text]').val()
        let jenislaporan = $('#text').find('option:selected').text();

        let parameter

        if (posisiakhirtrado != null && posisiakhirtrado !== '') {
            parameter = posisiakhirtrado;
        } else {
            parameter = posisiakhirgandengan;
        }

        // console.log(parameter)

        $.ajax({
                url: `${apiUrl}laporanpemakaianban/report`,
                method: 'GET',
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    dari: dari,
                    sampai: sampai,
                    posisiakhir: parameter,
                    jenislaporan: jenislaporan,
                },
                success: function(response) {
                    // console.log(response)
                    let data = response.data
                    let dataCabang = response.namacabang
                    let detailParams = {
                        dari: dari,
                        sampai: sampai,
                        posisiakhir: parameter,
                        jenislaporan: jenislaporan,
                    };

                    let cabang = accessCabang

                    laporanpemakaianban(data, detailParams, dataCabang,cabang);
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

        let sampai = $('#crudForm').find('[name=sampai]').val()
        let dari = $('#crudForm').find('[name=dari]').val()
        let posisiakhirtrado = $('#crudForm').find('[name=posisiakhirtrado]').val()
        let posisiakhirtradoId = $('#crudForm').find('[name=posisiakhirtrado_id]').val()
        let posisiakhirgandengan = $('#crudForm').find('[name=posisiakhirgandengan]').val()
        let posisiakhirgandenganId = $('#crudForm').find('[name=posisiakhirgandengan_id]').val()
        let posisiakhirgandengantext = $('#crudForm').find('[name=posisiakhirgandengan]').val()
        let jenislaporan_id = $('#crudForm').find('[name=text]').val()
        let jenislaporan = $('#text').find('option:selected').text();

        if (sampai != '' && dari != '') {

            $.ajax({
                url: `${apiUrl}laporanpemakaianban/export`,
                type: 'GET',
                data: {
                    dari: dari,
                    sampai: sampai,
                    posisiakhirtrado: posisiakhirtrado,
                    posisiakhirtradoId: posisiakhirtradoId,
                    posisiakhirgandengan: posisiakhirgandengan,
                    posisiakhirgandenganId: posisiakhirgandenganId,
                    posisiakhirgandengantext: posisiakhirgandengantext,
                    jenislaporan_id: jenislaporan_id,
                    jenislaporan: jenislaporan,
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
                            link.download = 'LAP. PEMAKAIAN BAN ' + new Date().getTime() + '.xlsx';
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
    })

    function laporanpemakaianban(data, detailParams, dataCabang,cabang) {
        Stimulsoft.Base.StiLicense.loadFromFile("{{ asset('libraries/stimulsoft-report/2023.1.1/license.php') }}");
        Stimulsoft.Base.StiFontCollection.addOpentypeFontFile("{{ asset('libraries/stimulsoft-report/2023.1.1/font/SourceSansPro.ttf') }}", "SourceSansPro");

        var report = new Stimulsoft.Report.StiReport();
        var dataSet = new Stimulsoft.System.Data.DataSet("Data");

        if (cabang == 'MEDAN') {
            report.loadFile(`{{ asset('public/reports/ReportLaporanPemakaianBanA4.mrt') }}`);
        }else if(cabang == 'MAKASSAR'){
            report.loadFile(`{{ asset('public/reports/ReportLaporanPemakaianBanLetter.mrt') }}`);
        }else{
            report.loadFile(`{{ asset('public/reports/ReportLaporanPemakaianBan.mrt') }}`);
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

    function getCekReport() {

        return new Promise((resolve, reject) => {
            $.ajax({
                url: `${apiUrl}laporanpemakaianban/report`,
                dataType: "JSON",
                headers: {
                    Authorization: `Bearer ${accessToken}`
                },
                data: {
                    dari: $('#crudForm').find('[name=dari]').val(),
                    sampai: $('#crudForm').find('[name=sampai]').val(),
                    posisiakhirtrado: $('#crudForm').find('[name=posisiakhirtrado]').val(),
                    posisiakhirtradoId: $('#crudForm').find('[name=posisiakhirtrado_id]').val(),
                    posisiakhirgandengan: $('#crudForm').find('[name=posisiakhirgandengan]').val(),
                    posisiakhirgandenganId: $('#crudForm').find('[name=posisiakhirgandengan_id]').val(),
                    posisiakhirgandengantext: $('#crudForm').find('[name=posisiakhirgandengan]').val(),
                    jenislaporan_id: $('#crudForm').find('[name=text]').val(),
                    jenislaporan: $('#text').find('option:selected').text(),
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




    function lookupSelected(el) {

        let trado = $('#crudForm').find(`[name="posisiakhirtrado"]`).parents('.input-group').children()

        let gandengan = $('#crudForm').find(`[name="posisiakhirgandengan"]`).parents('.input-group').children()


        switch (el) {
            case 'trado':
                gandengan.attr('disabled', true)
                gandengan.find('.lookup-toggler').attr('disabled', true)
                $('#gandenganId').attr('disabled', true);

                break;
            case 'gandengan':
                trado.attr('disabled', true)
                trado.find('.lookup-toggler').attr('disabled', true)
                $('#tradoId').attr('disabled', true);

                break;
            default:
                break;
        }

    }

    function enabledLookupSelected() {
        let trado = $('#crudForm').find(`[name="posisiakhirtrado"]`).parents('.input-group').children()
        let gandengan = $('#crudForm').find(`[name="posisiakhirgandengan"]`).parents('.input-group').children()
        trado.find(`.lookup-toggler`).attr("disabled", false);
        trado.attr('disabled', false);
        gandengan.find(`.lookup-toggler`).attr("disabled", false);
        gandengan.attr('disabled', false);


        $('#tradoId').attr('disabled', false);
        $('#tradoId').val('');

        $('#gudangId').attr('disabled', false);
        $('#gudangId').val('');
    }

    function initLookup() {

        $('.posisiakhirtrado-lookup').lookupMaster({
            title: 'Posisi Akhir Ban Trado Lookup',
            fileName: 'tradoMaster',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'posisiakhirtrado_id',
                    searchText: 'posisiakhirtrado-lookup',
                    title: 'Posisi Akhir Ban Trado Lookup',
                    typeSearch: 'ALL',
                }
            },
            onSelectRow: (trado, element) => {
                $('#crudForm [name=posisiakhirtrado_id]').first().val(trado.id)
                element.val(trado.kodetrado)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=posisiakhirtrado_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        $('.posisiakhirgandengan-lookup').lookupMaster({
            title: 'Posisi Akhir Ban Gandengan Lookup',
            fileName: 'gandenganMaster',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'posisiakhirgandengan_id',
                    searchText: 'posisiakhirgandengan-lookup',
                    title: 'Posisi Akhir Ban Gandengan Lookup',
                    typeSearch: 'ALL',
                }
            },
            onSelectRow: (gandengan, element) => {
                $('#crudForm [name=posisiakhirgandengan_id]').first().val(gandengan.id)
                element.val(gandengan.keterangan)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=posisiakhirgandengan_id]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })

        $('.text-lookup').lookupMaster({
            title: 'Parameter Lookup',
            fileName: 'parameterMaster',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    url: `${apiUrl}parameter/combo`,
                    grp: 'LAPORAN PEMAKAIAN BAN',
                    subgrp: 'LAPORAN PEMAKAIAN BAN',
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'text_id',
                    searchText: 'text-lookup',
                    title: 'Parameter Lookup',
                    typeSearch: 'ALL',
                    singleColumn: true,
                    hideLabel: true,
                }
            },
            onSelectRow: (text, element) => {
                $('#crudForm [name=text]').first().val(text.id)
                element.val(text.text)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                $('#crudForm [name=text]').first().val('')
                element.val('')
                element.data('currentValue', element.val())
            }
        })
    }
</script>
@endpush()
@endsection