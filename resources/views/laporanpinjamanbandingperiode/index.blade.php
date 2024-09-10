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
                                    <input type="text" name="periode" class="form-control monthpicker">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="col-12 col-sm-2 col-form-label mt-2">Jenis Pinjaman<span class="text-danger">*</span></label>
                            <div class="col-sm-4 mt-2">
                                <input type="hidden" name="jenis">
                                <input type="text" name="jenisnama" data-target-name="jenis" id="jenisnama" class="form-control lg-form jenis-lookup">
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
<link rel="stylesheet" type="text/css" href="{{ asset('libraries/stimulsoft-report/2023.1.1/css/stimulsoft.viewer.office2013.whiteblue.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('libraries/stimulsoft-report/2023.1.1/css/stimulsoft.designer.office2013.whiteblue.css') }}">
<script type="text/javascript" src="{{ asset('libraries/stimulsoft-report/2023.1.1/scripts/stimulsoft.reports.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries/stimulsoft-report/2023.1.1/scripts/stimulsoft.viewer.js') }}"></script>
<script type="text/javascript" src="{{ asset('libraries/stimulsoft-report/2023.1.1/scripts/stimulsoft.designer.js') }}"></script>
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
        initMonthpicker()
        $('#crudForm').find('[name=periode]').val($.datepicker.formatDate('mm-yy', new Date())).trigger(
            'change');


        initLookup()
        if (!`{{ $myAuth->hasPermission('laporanpinjamanbandingperiode', 'report') }}`) {
            $('#btnPreview').attr('disabled', 'disabled')
        }
        if (!`{{ $myAuth->hasPermission('laporanpinjamanbandingperiode', 'export') }}`) {
            $('#btnExport').attr('disabled', 'disabled')
        }
    })

    $(document).on('click', `#btnPreview`, function(event) {
        let periode = $('#crudForm').find('[name=periode]').val()
        let jenis = $('#crudForm').find('[name=jenis]').val()

        if (jenis != '' && periode != '') {

            // window.open(`{{ route('laporanpinjamanbandingperiode.report') }}?periode=${periode}&jenis=${jenis}`)

            $.ajax({
                    url: `${apiUrl}laporanpinjamanbandingperiode/report`,
                    method: 'GET',
                    headers: {
                        Authorization: `Bearer ${accessToken}`
                    },
                    data: {
                        periode: periode,
                        jenis: jenis,
                    },
                    success: function(response) {
                        let data = response.data
                        let dataCabang = response.namacabang
                        let detailParams = {
                            periode: periode,
                            jenis: jenis,
                        };
                        let user = response.data[0].username;

                        // console.log(data, detailParams, dataCabang)

                        laporanpinjamanbandingperiode(data, detailParams, dataCabang, user);
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
        $('#processingLoader').removeClass('d-none')
        let periode = $('#crudForm').find('[name=periode]').val()
        let jenis = $('#crudForm').find('[name=jenis]').val()

        if (jenis != '' && periode != '') {
            $.ajax({

                // url: `{{ route('laporanpinjamanbandingperiode.export') }}?periode=${periode}&jenis=${jenis}`,
                url: `${apiUrl}laporanpinjamanbandingperiode/export`,
                type: 'GET',
                data: {
                    periode: periode,
                    jenis: jenis
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
                            link.download = 'LAP. KETERANGAN PINJAMAN' + new Date().getTime() + '.xlsx';
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

    function laporanpinjamanbandingperiode(data, detailParams, dataCabang, user) {
        Stimulsoft.Base.StiLicense.loadFromFile("{{ asset('libraries/stimulsoft-report/2023.1.1/license.php') }}");
        Stimulsoft.Base.StiFontCollection.addOpentypeFontFile("{{ asset('libraries/stimulsoft-report/2023.1.1/font/ComicSansMS3.ttf') }}", "Comic Sans MS3");

        var report = new Stimulsoft.Report.StiReport();
        var dataSet = new Stimulsoft.System.Data.DataSet("Data");

        report.loadFile(`{{ asset('public/reports/ReportLaporanPinjamanBandingPeriode.mrt') }}`);

        dataSet.readJson({
            'data': data,
            'dataCabang': dataCabang,
            'parameter': detailParams,
            'user': user
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
        $(`.jenis-lookup`).lookupMaster({
            title: 'Jenis Lookup',
            fileName: 'parameterMaster',
            typeSearch: 'ALL',
            searching: 1,
            beforeProcess: function() {
                this.postData = {
                    url: `${apiUrl}parameter/combo`,
                    grp: 'STATUS POSTING',
                    subgrp: 'STATUS POSTING',
                    searching: 1,
                    valueName: `jenis`,
                    searchText: `jenis-lookup`,
                    singleColumn: true,
                    hideLabel: true,
                    title: 'Jenis Lookup'
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