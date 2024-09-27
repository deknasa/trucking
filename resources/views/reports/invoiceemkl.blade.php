<?php require base_path('reports/stireport_config.inc'); ?>

<!DOCTYPE html>
<html>

<head>

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Report Invoice</title>
  <link rel="stylesheet" type="text/css" href="{{ asset($stireport_path . 'css/stimulsoft.viewer.office2013.whiteblue.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset($stireport_path . 'css/stimulsoft.designer.office2013.whiteblue.css') }}">
  <script type="text/javascript" src="{{ asset($stireport_path . 'scripts/stimulsoft.reports.js') }}"></script>
  <script type="text/javascript" src="{{ asset($stireport_path . 'scripts/stimulsoft.viewer.js') }}"></script>
  <script type="text/javascript" src="{{ asset($stireport_path . 'scripts/stimulsoft.designer.js') }}"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="{{ asset('libraries/tas-lib/js/terbilang.js?version='. config('app.version')) }}"></script>
  <script type="text/javascript">
    let invoiceheaders = <?= json_encode($invoices); ?>;

    function Start() {
      Stimulsoft.Base.StiLicense.loadFromFile("{{ asset($stireport_path . 'license.php') }}");
      var viewerOptions = new Stimulsoft.Viewer.StiViewerOptions()
      viewerOptions.toolbar.viewMode = Stimulsoft.Viewer.StiWebViewMode.Continuous;

      Stimulsoft.Report.Dictionary.StiFunctions.addFunction("MyCategory", "Terbilang", "Terbilang", "Terbilang", "", String, "Return Description", [Object], ["value"], ["Descriptions"], terbilang);
      viewerOptions.toolbar.viewMode = Stimulsoft.Viewer.StiWebViewMode.Continuous;

      var viewer = new Stimulsoft.Viewer.StiViewer(viewerOptions, "StiViewer", false)
      var report = new Stimulsoft.Report.StiReport()

      var statuscetak = invoiceheaders.statuscetak_id
      var sudahcetak = invoiceheaders['combo']['id']
      if (statuscetak == sudahcetak) {
        viewerOptions.toolbar.showPrintButton = false;
        viewerOptions.toolbar.showSaveButton = false;
        viewerOptions.toolbar.showOpenButton = false;
      }

      var options = new Stimulsoft.Designer.StiDesignerOptions()
      options.appearance.fullScreenMode = true

      var designer = new Stimulsoft.Designer.StiDesigner(options, "Designer", false)

      var dataSet = new Stimulsoft.System.Data.DataSet("Data")

      viewer.renderHtml('content')
      if (invoiceheaders.nobuktiinvoicereimbursement != '') {
        report.loadFile(`{{ asset('public/reports/ReportInvoiceReimbursement.mrt') }}`)
      } else {
        if (invoiceheaders.jenisorder == 'MUATAN') {
          report.loadFile(`{{ asset('public/reports/ReportInvoiceEmklMuatan.mrt') }}`)
        } else {
          if (invoiceheaders.statusinvoice == 'UTAMA') {
            report.loadFile(`{{ asset('public/reports/ReportInvoiceEmkl.mrt') }}`)

          } else {
            report.loadFile(`{{ asset('public/reports/ReportInvoiceEmklTambahan.mrt') }}`)

          }

        }
      }

      report.dictionary.dataSources.clear()

      dataSet.readJson({
        'invoices': <?= json_encode($invoices); ?>,
        'invoice_detail': <?= json_encode($invoice_detail); ?>
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

          var id = invoiceheaders.id
          window.opener.removeEditingBy(id);
        }
      });

      window.addEventListener('afterprint', (event) => {
        var id = invoiceheaders.id
        var apiUrl = `{{ config('app.api_url') }}`;
        $.ajax({
          url: `${apiUrl}invoiceemklheader/${id}/printreport`,
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
      var statuscetak = invoiceheaders.statuscetak_id
      var sudahcetak = invoiceheaders['combo']['id']
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