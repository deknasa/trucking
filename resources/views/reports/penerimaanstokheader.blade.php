<?php require base_path('reports/stireport_config.inc'); ?>

<!DOCTYPE html>
<html>

<head>

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Report Penerimaan Stok</title>
  <link rel="stylesheet" type="text/css" href="{{ asset($stireport_path . 'css/stimulsoft.viewer.office2013.whiteblue.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset($stireport_path . 'css/stimulsoft.designer.office2013.whiteblue.css') }}">
  <script type="text/javascript" src="{{ asset($stireport_path . 'scripts/stimulsoft.reports.js') }}"></script>
  <script type="text/javascript" src="{{ asset($stireport_path . 'scripts/stimulsoft.viewer.js') }}"></script>
   <!-- <script type="text/javascript" src="{{ asset($stireport_path . 'scripts/stimulsoft.designer.js') }}"></script> -->
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="{{ asset('libraries/tas-lib/js/terbilang.js?version='. config('app.version')) }}"></script>

  <script type="text/javascript">
    var penerimaanstokheaders = <?= json_encode($penerimaanstokheaders); ?>;
    var printer = <?= json_encode($printer); ?>;
    console.log(printer['tipe'])

    function Start() {
      Stimulsoft.Base.StiLicense.loadFromFile("{{ asset($stireport_path . 'license.php') }}");
      var viewerOptions = new Stimulsoft.Viewer.StiViewerOptions()
      viewerOptions.toolbar.viewMode = Stimulsoft.Viewer.StiWebViewMode.Continuous;


      Stimulsoft.Report.Dictionary.StiFunctions.addFunction("MyCategory", "Terbilang", "Terbilang", "Terbilang", "", String, "Return Description", [Object], ["value"], ["Descriptions"], terbilang);

      var viewer = new Stimulsoft.Viewer.StiViewer(viewerOptions, "StiViewer", false)
      var report = new Stimulsoft.Report.StiReport()

      var statuscetak = penerimaanstokheaders.statuscetak_id
      var sudahcetak = penerimaanstokheaders['combo']['id']
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
      if (printer['tipe'] == 'reportPrinterBesar') {
        switch (penerimaanstokheaders.statusformat) {
          case '132':
            //DOT
            report.loadFile(`{{ asset('public/reports/ReportpenerimaanStokPGDOBesar.mrt') }}`)
            break;
          case '133':
            //POT
            report.loadFile(`{{ asset('public/reports/ReportPenerimaanStokPOBesar.mrt') }}`) //now
            break;
          case '134':
            //SPB
            report.loadFile(`{{ asset('public/reports/ReportPenerimaanStokSPBBesar.mrt') }}`)
            break;
          case '136':
            //KOR
            report.loadFile(`{{ asset('public/reports/ReportPenerimaanStokKORBesar.mrt') }}`)
            break;
          case '137':
            //PG
            report.loadFile(`{{ asset('public/reports/ReportpenerimaanStokPGBesar.mrt') }}`)
            break;
          case '138':
            //SPBS
            report.loadFile(`{{ asset('public/reports/ReportPenerimaanStokSPBSBesar.mrt') }}`)
            break;
          case '352':
            //PST
            report.loadFile(`{{ asset('public/reports/ReportPenerimaanStokPSTBesar.mrt') }}`)
            break;
          case '361':
            //PST
            report.loadFile(`{{ asset('public/reports/ReportPenerimaanStokPSPKBesar.mrt') }}`)
            break;
          case '385':
            //KORV
            report.loadFile(`{{ asset('public/reports/ReportPenerimaanStokKORVBesar.mrt') }}`)
            break;
          case '394':
            //SPBP
            report.loadFile(`{{ asset('public/reports/ReportPenerimaanStokSPBPBesar.mrt') }}`)
            break;
          default:
            report.loadFile(`{{ asset('public/reports/ReportPenerimaanStokSPBBesar.mrt') }}`)
            break;
        }
      } else {
        switch (penerimaanstokheaders.statusformat) {
          case '132':
            //DOT
            report.loadFile(`{{ asset('public/reports/ReportpenerimaanStokPGDO.mrt') }}`)
            break;
          case '133':
            //POT
            report.loadFile(`{{ asset('public/reports/ReportPenerimaanStokPO.mrt') }}`) //now
            break;
          case '134':
            //SPB
            report.loadFile(`{{ asset('public/reports/ReportPenerimaanStokSPB.mrt') }}`)
            break;
          case '136':
            //KOR
            report.loadFile(`{{ asset('public/reports/ReportPenerimaanStokKOR.mrt') }}`)
            break;
          case '137':
            //PG
            report.loadFile(`{{ asset('public/reports/ReportpenerimaanStokPG.mrt') }}`)
            break;
          case '138':
            //SPBS
            report.loadFile(`{{ asset('public/reports/ReportPenerimaanStokSPBS.mrt') }}`)
            break;
          case '352':
            //PST
            report.loadFile(`{{ asset('public/reports/ReportPenerimaanStokPST.mrt') }}`)
            break;
          case '361':
            //PST
            report.loadFile(`{{ asset('public/reports/ReportPenerimaanStokPSPK.mrt') }}`)
            break;
          case '385':
            //KORV
            report.loadFile(`{{ asset('public/reports/ReportPenerimaanStokKORV.mrt') }}`)
            break;
          case '394':
            //SPBP
            report.loadFile(`{{ asset('public/reports/ReportPenerimaanStokSPBP.mrt') }}`)
            break;
          default:
            report.loadFile(`{{ asset('public/reports/ReportPenerimaanStokSPB.mrt') }}`)
            break;
        }
      }
      report.dictionary.dataSources.clear()

      dataSet.readJson({
        'penerimaanstokheader': penerimaanstokheaders
      })

      report.regData(dataSet.dataSetName, '', dataSet)
      report.dictionary.synchronize()

      viewer.report = report
      // designer.renderHtml("content")
      // designer.report = report

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

          var id = penerimaanstokheaders.id
          window.opener.removeEditingBy(id);
        }
      });


      window.addEventListener('afterprint', (event) => {
        var id = penerimaanstokheaders.id
        var apiUrl = `{{ config('app.api_url') }}`;

        $.ajax({
          url: `${apiUrl}penerimaanstokheader/${id}/printreport`,
          method: 'GET',
          dataType: 'JSON',
          headers: {
            Authorization: `Bearer {{ session('access_token') }}`
          },
          success: response => {
            // location.reload();
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
      var statuscetak = penerimaanstokheaders.statuscetak_id
      var sudahcetak = penerimaanstokheaders['combo']['id']
      if (statuscetak == sudahcetak) {
        $(document).on('keydown', function(e) {
          if ((e.ctrlKey || e.metaKey) && (e.key == "p" || e.charCode == 16 || e.charCode == 112 || e.keyCode == 80)) {
            alert("Document SUdah Pernah Dicetak ");
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