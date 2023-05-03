<?php require base_path('reports/stireport_config.inc'); ?>

<!DOCTYPE html>
<html>

<head>

  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
  <title>Report Penerimaan Kas/Bank</title>
  <link rel="stylesheet" type="text/css" href="{{ asset($stireport_path . 'css/stimulsoft.viewer.office2013.whiteblue.css') }}">
  <link rel="stylesheet" type="text/css" href="{{ asset($stireport_path . 'css/stimulsoft.designer.office2013.whiteblue.css') }}">
  <script type="text/javascript" src="{{ asset($stireport_path . 'scripts/stimulsoft.reports.js') }}"></script>
  <script type="text/javascript" src="{{ asset($stireport_path . 'scripts/stimulsoft.viewer.js') }}"></script>
  <script type="text/javascript" src="{{ asset($stireport_path . 'scripts/stimulsoft.designer.js') }}"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.js" integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
  <script src="{{ asset('libraries/js/terbilang.js?version='. config('app.version')) }}"></script>
  <script type="text/javascript">
    
    let penerimaanheaders = <?= json_encode($data); ?>

    $( document ).ready(function() {
      var statuscetak = penerimaanheaders.statuscetak
      if (statuscetak == 174) {
        $(document).on('keydown', function(e) { 
          if((e.ctrlKey || e.metaKey) && (e.key == "p" || e.charCode == 16 || e.charCode == 112 || e.keyCode == 80) ){
            alert("Document Sudah Pernah Dicetak ");
            e.cancelBubble = true;
            e.preventDefault();
            e.stopImmediatePropagation();
          }  
        });  
      }


    });

    function Start() {
      Stimulsoft.Base.StiLicense.loadFromFile("{{ asset($stireport_path . 'license.php') }}");
      var myFunc = function (value) {
        if (!Stimulsoft.Data.Extensions.ListExt.isList(value))
        return Stimulsoft.Base.Helpers.StiValueHelper.tryToNumber(value);
        return Stimulsoft.Data.Functions.Funcs.skipNulls(Stimulsoft.Data.Extensions.ListExt.toList(value)).tryCastToNumber().sum();
      };
      var terbilang = function (number) {

        // Array kosong untuk menampung kata terbilang
        
        let words = [];
        
        // Array untuk menampung angka terbilang
        const units = [
        "", "satu", "dua", "tiga", "empat", "lima", "enam", "tujuh", "delapan", "sembilan", "sepuluh", "sebelas"
        ];
        
        // Konversi angka menjadi terbilang
        if (number < 12) {
        words.push(units[number]);
        } else if (number < 20) {
        words.push(terbilang(number - 10) + " belas");
        } else if (number < 100) {
        words.push(terbilang(Math.floor(number / 10)) + " puluh");
        if (number % 10 !== 0) {
          words.push(terbilang(number % 10));
        }
        } else if (number < 200) {
        words.push("seratus", terbilang(number - 100));
        } else if (number < 1000) {
        words.push(terbilang(Math.floor(number / 100)) + " ratus");
        if (number % 100 !== 0) {
          words.push(terbilang(number % 100));
        }
        } else if (number < 2000) {
        words.push("seribu", terbilang(number - 1000));
        } else if (number < 1000000) {
        words.push(terbilang(Math.floor(number / 1000)) + " ribu");
        if (number % 1000 !== 0) {
          words.push(terbilang(number % 1000));
        }
        } else if (number < 1000000000) {
        words.push(terbilang(Math.floor(number / 1000000)) + " juta");
        if (number % 1000000 !== 0) {
          words.push(terbilang(number % 1000000));
        }
        } else {
        words.push("Angka terlalu besar");
        }
        
        // Menggabungkan semua kata terbilang menjadi satu string
        return words.join(" ");

      };
        
      Stimulsoft.Report.Dictionary.StiFunctions.addFunction("MyCategory", "MySum", "MySum", "MySum", "", Number, "Return Description", [Object], ["value"], ["Descriptions"], myFunc);
      Stimulsoft.Report.Dictionary.StiFunctions.addFunction("MyCategory", "Terbilang", "Terbilang", "Terbilang", "", String, "Return Description", [Object], ["value"], ["Descriptions"], terbilang);

      var viewerOptions = new Stimulsoft.Viewer.StiViewerOptions()

      var viewer = new Stimulsoft.Viewer.StiViewer(viewerOptions, "StiViewer", false)
      var report = new Stimulsoft.Report.StiReport()

      var statuscetak = penerimaanheaders.statuscetak
      if (statuscetak == 174) {
        viewerOptions.toolbar.showPrintButton = false;
        viewerOptions.toolbar.showSaveButton = false;
        viewerOptions.toolbar.showOpenButton = false;
      }
      var options = new Stimulsoft.Designer.StiDesignerOptions()
      options.appearance.fullScreenMode = true

      var designer = new Stimulsoft.Designer.StiDesigner(options, "Designer", false)

      var dataSet = new Stimulsoft.System.Data.DataSet("Data")

      viewer.renderHtml('content')
      report.loadFile(`{{ asset('public/reports/ReportPenerimaan.mrt') }}`)

      report.dictionary.dataSources.clear()

      dataSet.readJson({
        'penerimaan': <?= json_encode($penerimaan_details); ?>,
        'user': <?= json_encode($user); ?>
      })

      report.regData(dataSet.dataSetName, '', dataSet)
      report.dictionary.synchronize()
      designer.report = report;
      designer.renderHtml('content');
      viewer.report = report
      
      viewer.onPrintReport = function (event) {
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

      window.addEventListener('afterprint', (event) => {
        
        var id = penerimaanheaders.id
        var apiUrl = `{{ config('app.api_url') }}`;
        
        $.ajax({
          url: `${apiUrl}penerimaanheader/${id}/printreport`,
          method: 'GET',
          dataType: 'JSON',
          headers: {
            Authorization: `Bearer {{ session('access_token') }}`
          },
          success: response => {
            console.log(response);
            location.reload()
          }
    
        })
          
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