<?php require base_path('reports/app_config.inc'); ?>

<!DOCTYPE html>
<html>

<head>

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Laporan Kartu Hutang Per Supplier</title>
    {{-- <link rel="stylesheet" type="text/css"
        href="{{ asset($stireport_path . 'css/stimulsoft.viewer.office2013.whiteblue.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset($stireport_path . 'css/stimulsoft.designer.office2013.whiteblue.css') }}"> --}}
    <script type="text/javascript" src="{{ asset($stireport_path . 'scripts/stimulsoft.reports.js') }}"></script>
    {{-- <script type="text/javascript" src="{{ asset($stireport_path . 'scripts/stimulsoft.viewer.js') }}"></script> --}}
    {{-- <script type="text/javascript" src="{{ asset($stireport_path . 'scripts/stimulsoft.designer.js') }}"></script> --}}
    <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk="
        crossorigin="anonymous"></script>
    <script type="text/javascript">
        let cabang = <?= json_encode($cabang) ?>;

        function Start() {
            Stimulsoft.Base.StiLicense.Key = "<?= $lisenceKeySti2024 ?>";

            var report = new Stimulsoft.Report.StiReport()

            // var options = new Stimulsoft.Designer.StiDesignerOptions()
            // options.appearance.fullScreenMode = true

            // var designer = new Stimulsoft.Designer.StiDesigner(options, "Designer", false)

            var dataSet = new Stimulsoft.System.Data.DataSet("Data")

            // report.loadFile(`{{ asset('public/reports/ReportLaporanLabaRugi.mrt') }}`)

            if (cabang['cabang'] == 'MEDAN') {
                report.loadFile(`{{ asset('public/reports/ReportLaporanKartuHutangPerSupplierA4.mrt') }}`)
            } else if (cabang['cabang'] == 'MAKASSAR') {
                report.loadFile(`{{ asset('public/reports/ReportLaporanKartuHutangPerSupplierLetter.mrt') }}`)
            } else {
                report.loadFile(`{{ asset('public/reports/ReportLaporanKartuHutangPerSupplier.mrt') }}`)
            }

            report.dictionary.dataSources.clear()

            dataSet.readJson({
                'data': <?= json_encode($data) ?>,
                'dataCabang': <?= json_encode($dataCabang) ?>,
                'user': <?= json_encode($user) ?>,
                'parameter': <?= json_encode($detailParams) ?>
            })

            report.regData(dataSet.dataSetName, '', dataSet)
            report.dictionary.synchronize()
            // designer.report = report;
            // designer.renderHtml('content');

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
