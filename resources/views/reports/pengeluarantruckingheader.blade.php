<?php require base_path('reports/stireport_config.inc'); ?>

<!DOCTYPE html>
<html>

<head>

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Report Pengeluaran Trucking</title>
  <link rel="stylesheet" type="text/css" href="{{ asset($stireport_path . 'css/stimulsoft.viewer.office2013.whiteblue.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset($stireport_path . 'css/stimulsoft.designer.office2013.whiteblue.css') }}">
  <script type="text/javascript" src="{{ asset($stireport_path . 'scripts/stimulsoft.reports.js') }}"></script>
  <script type="text/javascript" src="{{ asset($stireport_path . 'scripts/stimulsoft.viewer.js') }}"></script>
  <!--  <script type="text/javascript" src="{{ asset($stireport_path . 'scripts/stimulsoft.designer.js') }}"></script> -->
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="{{ asset('libraries/tas-lib/js/terbilang.js?version='. config('app.version')) }}"></script>
  <script type="text/javascript">
    let pengeluarantruckings = <?= json_encode($pengeluarantrucking); ?>;
    let printer = <?= json_encode($printer); ?>;

    function Start() {
      Stimulsoft.Base.StiLicense.loadFromFile("{{ asset($stireport_path . 'license.php') }}");
      var viewerOptions = new Stimulsoft.Viewer.StiViewerOptions()
      viewerOptions.toolbar.viewMode = Stimulsoft.Viewer.StiWebViewMode.Continuous;

      Stimulsoft.Report.Dictionary.StiFunctions.addFunction("MyCategory", "Terbilang", "Terbilang", "Terbilang", "", String, "Return Description", [Object], ["value"], ["Descriptions"], terbilang);
      viewerOptions.toolbar.viewMode = Stimulsoft.Viewer.StiWebViewMode.Continuous;

      var viewer = new Stimulsoft.Viewer.StiViewer(viewerOptions, "StiViewer", false)
      var report = new Stimulsoft.Report.StiReport()

      var statuscetak = pengeluarantruckings.statuscetak_id
      var sudahcetak = pengeluarantruckings['combo']['id']
      if (statuscetak == sudahcetak) {
        viewerOptions.toolbar.showPrintButton = false;
        viewerOptions.toolbar.showSaveButton = false;
        viewerOptions.toolbar.showOpenButton = false;
      }

     //  var options = new Stimulsoft.Designer.StiDesignerOptions()
     //  options.appearance.fullScreenMode = true

      // var designer = new Stimulsoft.Designer.StiDesigner(options, "Designer", false)

      var dataSet = new Stimulsoft.System.Data.DataSet("Data")

      viewer.renderHtml('content')
      switch (pengeluarantruckings.statusformat) {
        case '122':

          //pjt
          if (printer['tipe'] == 'reportPrinterBesar') {
            report.loadFile(`{{ asset('public/reports/ReportPengeluaranTruckingHeaderPJTBesar.mrt') }}`)
          } else {
            report.loadFile(`{{ asset('public/reports/ReportPengeluaranTruckingHeaderPJT.mrt') }}`)
          }
          break;
        case '251':
          //tde
          if (printer['tipe'] == 'reportPrinterBesar') {
            report.loadFile(`{{ asset('public/reports/ReportPengeluaranTruckingHeaderTDEBesar.mrt') }}`)
          } else {
            report.loadFile(`{{ asset('public/reports/ReportPengeluaranTruckingHeaderTDE.mrt') }}`)
          }
          break;
        case '289':
          //BST
          if (printer['tipe'] == 'reportPrinterBesar') {
            report.loadFile(`{{ asset('public/reports/ReportPengeluaranTruckingHeaderBSTBesar.mrt') }}`)
          } else {
            report.loadFile(`{{ asset('public/reports/ReportPengeluaranTruckingHeaderBST.mrt') }}`)
          }
          break;
        case '297':
          //BSB
          if (printer['tipe'] == 'reportPrinterBesar') {
            report.loadFile(`{{ asset('public/reports/ReportPengeluaranTruckingHeaderBSBBesar.mrt') }}`)
          } else {
            report.loadFile(`{{ asset('public/reports/ReportPengeluaranTruckingHeaderBSB.mrt') }}`)
          }
          break;
        case '298':
          //KBBM
          if (printer['tipe'] == 'reportPrinterBesar') {
            report.loadFile(`{{ asset('public/reports/ReportPengeluaranTruckingHeaderKBBMBesar.mrt') }}`)
          } else {
            report.loadFile(`{{ asset('public/reports/ReportPengeluaranTruckingHeaderKBBM.mrt') }}`)
          }
          break;
        case '279':
          //BLS
          if (printer['tipe'] == 'reportPrinterBesar') {
            report.loadFile(`{{ asset('public/reports/ReportPengeluaranTruckingHeaderBLSBesar.mrt') }}`)
          } else {
            report.loadFile(`{{ asset('public/reports/ReportPengeluaranTruckingHeaderBLS.mrt') }}`)
          }
          break;
        case '318':
          //KLAIM
          if (printer['tipe'] == 'reportPrinterBesar') {
            report.loadFile(`{{ asset('public/reports/ReportPengeluaranTruckingHeaderKLAIMBesar.mrt') }}`)
          } else {
            report.loadFile(`{{ asset('public/reports/ReportPengeluaranTruckingHeaderKLAIM.mrt') }}`)
          }
          break;
        case '369':
          //PJK
          if (printer['tipe'] == 'reportPrinterBesar') {
            report.loadFile(`{{ asset('public/reports/ReportPengeluaranTruckingHeaderPJKBesar.mrt') }}`)
          } else {
            report.loadFile(`{{ asset('public/reports/ReportPengeluaranTruckingHeaderPJK.mrt') }}`)
          }
          break;
        case '411':
          //BBT
          if (printer['tipe'] == 'reportPrinterBesar') {
            report.loadFile(`{{ asset('public/reports/ReportPengeluaranTruckingHeaderBBTBesar.mrt') }}`)
          } else {
            report.loadFile(`{{ asset('public/reports/ReportPengeluaranTruckingHeaderBBT.mrt') }}`)
          }
          break;
        case '545':
          //tde
          if (printer['tipe'] == 'reportPrinterBesar') {
            report.loadFile(`{{ asset('public/reports/ReportPengeluaranTruckingHeaderTDEKBesar.mrt') }}`)
          } else {
            report.loadFile(`{{ asset('public/reports/ReportPengeluaranTruckingHeaderTDEK.mrt') }}`)
          }
          break;          
        case '556':
        case '557':
          //OTOK&OTOL
          if (printer['tipe'] == 'reportPrinterBesar') {
            report.loadFile(`{{ asset('public/reports/ReportPengeluaranTruckingHeaderOTOBesar.mrt') }}`)
          } else {
            report.loadFile(`{{ asset('public/reports/ReportPengeluaranTruckingHeaderOTO.mrt') }}`)
          }
          break;
        default:
          if (printer['tipe'] == 'reportPrinterBesar') {
            report.loadFile(`{{ asset('public/reports/ReportPengeluaranTruckingHeaderBLLBesar.mrt') }}`)
          } else {
            report.loadFile(`{{ asset('public/reports/ReportPengeluaranTruckingHeaderBLL.mrt') }}`)
          }
          break;
      }

      report.dictionary.dataSources.clear()

      dataSet.readJson({
        'pengeluarantrucking_details': <?= json_encode($pengeluarantrucking_details); ?>,
        'pengeluarantrucking': <?= json_encode($pengeluarantrucking); ?>
      })

      report.regData(dataSet.dataSetName, '', dataSet)
      report.dictionary.synchronize()
      // designer.report = report;
      // designer.renderHtml('content');
      viewer.report = report
      viewer.onPrintReport = function(event) {
        triggerEvent(window, 'afterprint');
      }

      function triggerEvent(el, type) {
        // IE9+ and other modern browsers
        if ('createEvent' in document) {
          var e = document.createEvent('HTMLEvents');
          e.initEvent(type, false, true);
          el.dispatchEvent(e);
        } else {
          // IE8
          var e = document.createEventObject();
          e.eventType = type;
          el.fireEvent('on' + e.eventType, e);
        }
      }
      
      window.addEventListener('beforeunload', function() {
        if (window.opener && !window.opener.closed) {

          var id = pengeluarantruckings.id
          window.opener.removeEditingBy(id);
        }
      });

      window.addEventListener('afterprint', (event) => {
        var id = pengeluarantruckings.id
        var apiUrl = `{{ config('app.api_url') }}`;
        $.ajax({
          url: `${apiUrl}pengeluarantruckingheader/${id}/printreport`,
          method: 'GET',
          dataType: 'JSON',
          headers: {
            Authorization: `Bearer {{ session('access_token') }}`
          },
          success: response => {
            window.opener.reloadGrid();
            window.opener.removeEditingBy(id);
            window.close();
          }
        })
      });
    }
  </script>
  <script type="text/javascript">
    $(document).ready(function() {
      var statuscetak = pengeluarantruckings.statuscetak_id
      var sudahcetak = pengeluarantruckings['combo']['id']
      if (statuscetak == sudahcetak) {
        $(document).on('keydown', function(e) {
          if ((e.ctrlKey || e.metaKey) && (e.key == "p" || e.charCode == 16 || e.charCode == 112 || e.keyCode == 80)) {
            alert("Document Sudah Pernah Dicetak ");
            e.cancelBubble = true;
            e.preventDefault();
            e.stopImmediatePropagation();
          }
        });
      }
    });
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