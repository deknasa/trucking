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


                if (!`{{ $myAuth->hasPermission('laporanbangudangsementara', 'report') }}`) {
                    $('#btnPreview').attr('disabled', 'disabled')
                }
                if (!`{{ $myAuth->hasPermission('laporanbangudangsementara', 'export') }}`) {
                    $('#btnExport').attr('disabled', 'disabled')
                }

            })

            $(document).on('click', `#btnPreview`, function(event) {

                window.open(`{{ route('laporanbangudangsementara.report') }}`)

            })

            $(document).on('click', `#btnExport`, function(event) {
                $('#processingLoader').removeClass('d-none')
                $.ajax({
                    url: `{{ route('laporanbangudangsementara.export') }}`,
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
                                link.download = ' LAP. BAN DI GDG SEMENTARA/PHK KE 3' + new Date()
                                .getTime() + '.xlsx';
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

            function laporanbangudangsementara(data, dataCabang) {
                Stimulsoft.Base.StiLicense.loadFromFile("{{ asset('libraries/stimulsoft-report/2023.1.1/license.php') }}");
                Stimulsoft.Base.StiFontCollection.addOpentypeFontFile(
                    "{{ asset('libraries/stimulsoft-report/2023.1.1/font/SourceSansPro.ttf') }}", "SourceSansPro");

                var report = new Stimulsoft.Report.StiReport();
                var dataSet = new Stimulsoft.System.Data.DataSet("Data");

                if (accessCabang == 'MEDAN') {
                    report.loadFile(`{{ asset('public/reports/ReportLaporanBanGudangSementaraA4.mrt') }}`)
                } else if (accessCabang == 'MAKASSAR') {
                    report.loadFile(`{{ asset('public/reports/ReportLaporanBanGudangSementaraLetter.mrt') }}`)
                } else {
                    report.loadFile(`{{ asset('public/reports/ReportLaporanBanGudangSementara.mrt') }}`);
                }

                // report.loadFile(`{{ asset('public/reports/ReportLaporanBanGudangSementara.mrt') }}`);

                dataSet.readJson({
                    'data': data,
                    'dataCabang': dataCabang
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
        </script>
    @endpush()
@endsection
