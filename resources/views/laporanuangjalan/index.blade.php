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
                            <label class="col-12 col-sm-2 col-form-label mt-2">TGL RIC (DARI)<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="ricdari" class="form-control datepicker">
                                </div>
                            </div>
                            <h5 class="mt-3">s/d</h5>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="ricsampai" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">SUPIR (DARI)<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="supirdari_id">
                                <input type="text" name="supirdari" id="supirdari" class="form-control supirdari-lookup">
                            </div>
                            <h5 class="mt-3">s/d</h5>
                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="supirsampai_id">
                                <input type="text" name="supirsampai" id="supirsampai" class="form-control supirsampai-lookup">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">TGL AMBIL UANG JALAN (DARI)<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="ambildari" class="form-control datepicker">
                                </div>
                            </div>
                            <h5 class="mt-3">s/d</h5>
                            <div class="col-sm-4 mt-2">
                                <div class="input-group">
                                    <input type="text" name="ambilsampai" class="form-control datepicker">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">STATUS<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="status">
                                <input type="text" name="statusnama" data-target-name="jenis" id="statusnama" class="form-control lg-form status-lookup">
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
        // initSelect2($('#crudForm').find('[name=status]'), false)
        setStatusKembali($('#crudForm'))

        initDatepicker()
        $('#crudForm').find('[name=ricdari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=ricsampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=ambildari]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');
        $('#crudForm').find('[name=ambilsampai]').val($.datepicker.formatDate('dd-mm-yy', new Date())).trigger('change');

        initLookup()
        if (!`{{ $myAuth->hasPermission('laporanuangjalan', 'report') }}`) {
            $('#btnPreview').attr('disabled', 'disabled')
        }
        if (!`{{ $myAuth->hasPermission('laporanuangjalan', 'export') }}`) {
            $('#btnExport').attr('disabled', 'disabled')
        }
    })

    $(document).on('click', `#btnPreview`, function(event) {
        let ricdari = $('#crudForm').find('[name=ricdari]').val()
        let ricsampai = $('#crudForm').find('[name=ricsampai]').val()
        let ambildari = $('#crudForm').find('[name=ambildari]').val()
        let ambilsampai = $('#crudForm').find('[name=ambilsampai]').val()
        let supirdari = $('#crudForm').find('[name=supirdari_id]').val()
        let supirsampai = $('#crudForm').find('[name=supirsampai_id]').val()
        let status = $('#crudForm').find('[name=status]').val()
        if (ricdari != '' && ricsampai != '' && ambildari != '' && ambilsampai && supirdari != '' && supirsampai && status != '') {

            // window.open(`{{ route('laporanuangjalan.report') }}?ricdari=${ricdari}&ricsampai=${ricsampai}&ambildari=${ambildari}&ambilsampai=${ambilsampai}&supirdari=${supirdari}&supirsampai=${supirsampai}&status=${status}`)

            $.ajax({
                    url: `${apiUrl}laporanuangjalan/report`,
                    method: 'GET',
                    headers: {
                        Authorization: `Bearer ${accessToken}`
                    },
                    data: {
                        ricdari: ricdari,
                        ricsampai: ricsampai,
                        ambildari: ambildari,
                        ambilsampai: ambilsampai,
                        supirdari: supirdari,
                        supirsampai: supirsampai,
                        status: status
                    },
                    success: function(response) {
                        // console.log(response)
                        let data = response.data
                        let dataCabang = response.namacabang
                        let detailParams = {
                            ricdari: ricdari,
                            ricsampai: ricsampai,
                            ambildari: ambildari,
                            ambilsampai: ambilsampai,
                            supirdari: supirdari,
                            supirsampai: supirsampai,
                            status: status
                        };
                        laporanuangjalan(data, detailParams, dataCabang);
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
        } else {
            showDialog('ISI SELURUH KOLOM')
        }
    })

    $(document).on('click', `#btnExport`, function(event) {
        let ricdari = $('#crudForm').find('[name=ricdari]').val()
        let ricsampai = $('#crudForm').find('[name=ricsampai]').val()
        let ambildari = $('#crudForm').find('[name=ambildari]').val()
        let ambilsampai = $('#crudForm').find('[name=ambilsampai]').val()
        let supirdari = $('#crudForm').find('[name=supirdari_id]').val()
        let supirsampai = $('#crudForm').find('[name=supirsampai_id]').val()
        let status = $('#crudForm').find('[name=status]').val()
        if (ricdari != '' && ricsampai != '' && ambildari != '' && ambilsampai && supirdari != '' && supirsampai && status != '') {
            $('#processingLoader').removeClass('d-none')

            $.ajax({
                url: `${apiUrl}laporanuangjalan/export`,
                // url: `{{ route('laporanuangjalan.export') }}?ricdari=${ricdari}&ricsampai=${ricsampai}&ambildari=${ambildari}&ambilsampai=${ambilsampai}&supirdari=${supirdari}&supirsampai=${supirsampai}`,
                type: 'GET',
                data : {
                    ricdari : ricdari,
                    ricsampai : ricsampai,
                    ambildari : ambildari,
                    ambilsampai : ambilsampai,
                    supirdari : supirdari,
                    supirsampai : supirsampai,
                    status : status,
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
                            link.download = 'LAP. UANG JALAN ' + new Date().getTime() + '.xlsx';
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

    function laporanuangjalan(data, detailParams, dataCabang) {
        Stimulsoft.Base.StiLicense.loadFromFile("{{ asset('libraries/stimulsoft-report/2023.1.1/license.php') }}");
        Stimulsoft.Base.StiFontCollection.addOpentypeFontFile("{{ asset('libraries/stimulsoft-report/2023.1.1/font/ComicSansMS3.ttf') }}", "Comic Sans MS3");

        var report = new Stimulsoft.Report.StiReport();
        var dataSet = new Stimulsoft.System.Data.DataSet("Data");

        report.loadFile(`{{ asset('public/reports/ReportLaporanUangJalan.mrt') }}`);

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

    function initLookup() {
        $('.supirdari-lookup').lookupMaster({
            title: 'Supir Lookup',
            fileName: 'supirMaster',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'supirdari_id',
                    searchText: 'supirdari-lookup',
                    title: 'supir lookup',
                    typeSearch: 'ALL',
                }
            },
            onSelectRow: (supir, element) => {
                $('#crudForm [name=supirdari_id]').first().val(supir.id)
                element.val(supir.namasupir)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="supirdari_id"]`).first().val('')
                element.data('currentValue', element.val())
            }
        });

        $('.supirsampai-lookup').lookupMaster({
            title: 'Supir Lookup',
            fileName: 'supirMaster',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function(test) {
                this.postData = {
                    Aktif: 'AKTIF',
                    searching: 1,
                    valueName: 'supirsampai_id',
                    searchText: 'supirsampai-lookup',
                    title: 'supir lookup',
                    typeSearch: 'ALL',
                }
            },
            onSelectRow: (supir, element) => {
                $('#crudForm [name=supirsampai_id]').first().val(supir.id)
                element.val(supir.namasupir)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'))
            },
            onClear: (element) => {
                element.val('')
                $(`#crudForm [name="supirsampai_id"]`).first().val('')
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
                    grp: 'STATUS KEMBALI',
                    subgrp: 'STATUS KEMBALI',
                    searching: 1,
                    valueName: `jenis`,
                    searchText: `jenis-lookup`,
                    singleColumn: true,
                    hideLabel: true,
                    title: 'status Lookup'
                };
            },
            onSelectRow: (status, element) => {
                let elId = element.data('targetName')
                $(`#crudForm [name="status"]`).first().val(status.id)
                element.val(status.text)
                element.data('currentValue', element.val())
            },
            onCancel: (element) => {
                element.val(element.data('currentValue'));
            },
            onClear: (element) => {
                let elId = element.data('targetName')
                $(`#crudForm [name="status"]`).first().val('')
                element.val('')
                element.data('currentValue', element.val())
            },
        });
    }

    const setStatusKembali = function(relatedForm) {
        // return new Promise((resolve, reject) => {
        // relatedForm.find('[name=approve]').empty()
        relatedForm.find('[name=status]').append(
            new Option('-- PILIH STATUS KEMBALI --', '', false, true)
        ).trigger('change')

        let data = [];
        data.push({
            name: 'grp',
            value: 'STATUS KEMBALI'
        })
        data.push({
            name: 'subgrp',
            value: 'STATUS KEMBALI'
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

                response.data.forEach(statusKembali => {
                    let option = new Option(statusKembali.text, statusKembali.id)
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