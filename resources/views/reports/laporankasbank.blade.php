<?php require base_path('reports/app_config.inc'); ?>

<!DOCTYPE html>
<html>

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Laporan Kas/Bank</title>
    {{-- <link rel="stylesheet" type="text/css"
        href="{{ asset($stireport_path . 'css/stimulsoft.viewer.office2013.whiteblue.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset($stireport_path . 'css/stimulsoft.designer.office2013.whiteblue.css') }}"> --}}
    <script type="text/javascript" src="{{ asset($stireport_path . 'scripts/stimulsoft.reports.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset($stireport_path . 'scripts/stimulsoft.viewer.js') }}"></script>
    <script type="text/javascript" src="{{ asset($stireport_path . 'scripts/stimulsoft.designer.js') }}"></script>  --}}
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
    <script type="text/javascript">
        let printer = <?= json_encode($printer) ?>;
        let cabang = <?= json_encode($cabang) ?>;
        let jumlah = <?= json_encode($jumlah) ?>;


        function Start() {
            Stimulsoft.Base.StiLicense.Key = "<?= $lisenceKeySti2024 ?>";

            // Stimulsoft.Base.StiLicense.loadFromFile("{{ asset($stireport_path . 'license.php') }}");
            // var viewerOptions = new Stimulsoft.Viewer.StiViewerOptions()
            // viewerOptions.toolbar.viewMode = Stimulsoft.Viewer.StiWebViewMode.Continuous;

            // var viewer = new Stimulsoft.Viewer.StiViewer(viewerOptions, "StiViewer", false)
            var report = new Stimulsoft.Report.StiReport()

            // var options = new Stimulsoft.Designer.StiDesignerOptions()
            // options.appearance.fullScreenMode = true

            // var designer = new Stimulsoft.Designer.StiDesigner(options, "Designer", false)

            var dataSet = new Stimulsoft.System.Data.DataSet("Data")

            // viewer.renderHtml('content')
            if (cabang['cabang'] == 'PUSAT') {
                if (jumlah['jumlah'] == 2) {
                    report.loadFile(`{{ asset('public/reports/ReportLaporanKasBankBesarPusat.mrt') }}`)
                } else {
                    report.loadFile(`{{ asset('public/reports/ReportLaporanKasBankBesarPusatSaldo.mrt') }}`)
                }
            } else {
                if (printer['tipe'] == 'reportPrinterBesar') {

                    if (cabang['cabang'] == 'MEDAN') {
                        report.loadFile(`{{ asset('public/reports/ReportLaporanKasBankBesarA4.mrt') }}`)
                    } else if (cabang['cabang'] == 'MAKASSAR') {
                        report.loadFile(`{{ asset('public/reports/ReportLaporanKasBankBesarLetter.mrt') }}`)
                    } else {
                        report.loadFile(`{{ asset('public/reports/ReportLaporanKasBankBesar.mrt') }}`)
                    }
                } else {
                    report.loadFile(`{{ asset('public/reports/ReportLaporanKasBank.mrt') }}`)
                }
                // report.loadFile(`{{ asset('public/reports/ReportLaporanKasBankBesar.mrt') }}`)

            }


            report.dictionary.dataSources.clear()

            dataSet.readJson({
                'data': <?= json_encode($data) ?>,
                'datasaldo': <?= json_encode($datasaldo) ?>,
                'infopemeriksa': <?= json_encode($infopemeriksa) ?>,
                'dataCabang': <?= json_encode($dataCabang) ?>,
                'parameter': <?= json_encode($detailParams) ?>
            })


            report.regData(dataSet.dataSetName, '', dataSet)
            report.dictionary.synchronize()
            // designer.report = report;
            // designer.renderHtml('content');
            // viewer.report = report

            // Export report to PDF format and save to file
            report.renderAsync(function() {
                report.exportDocumentAsync(function(pdfData) {
                    let blob = new Blob([new Uint8Array(pdfData)], {
                        type: 'application/pdf'
                    });
                    let fileURL = URL.createObjectURL(blob);
                    // window.open(fileURL);
                    window.location.href = fileURL;
                    manipulatePdfWithJsPdf(pdfData);
                }, Stimulsoft.Report.StiExportFormat.Pdf);
            });
          }
    </script>
    <style>
        .stiJsViewerPage {
            word-break: break-all !important;
        }
    </style>
</head>

<body onLoad="Start()">

    <div id="content"></div>

</body>

</html>
