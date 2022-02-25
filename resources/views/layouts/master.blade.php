<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <style>
    /* .sidebar-mini.sidebar-collapse .main-sidebar, .sidebar-mini.sidebar-collapse .main-sidebar::selebefore{
            margin-left:unset !important;
        } */

    /* .sidebar-open #sidebar-overlay {
      display: block;
    } */

    .ui-jqgrid-bdiv td {
      padding: 6px;
    }

    .ui-jqgrid {
      /* margin-left: -7px !important; */
      width: 100%;
      background-color: white;
      top: -10px;
      margin-top: 10px;
    }

    .tambah {
      padding-right: 8px;
    }

    .edit {
      padding-right: 8px;
    }

    #resetdatafilter {
      /* margin-right:100px; */
      text-align: center;
      background-color: #d6d4d4;
      border: none;
    }

    #resetfilter:hover {
      background-color: #9e9e9e;
    }

    .ui-jqgrid .ui-jqgrid-bdiv {
      position: relative;
      margin: 0;
      padding: 0;
      overflow: auto;
      z-index: 101;
      /* width: 2455px !important; */
    }

    .hidden {
      display: none;
    }

    .loader {
      position: fixed;
      left: 0px;
      top: 0px;
      width: 100%;
      height: 100%;
      opacity: 0.8;
      z-index: 9999;
      background: url('{{ asset("dist/img/loading-red.gif") }}') 50% 50% no-repeat rgb(249, 249, 249);
      background-size: 50px;
    }

    #txt1 {
      position: fixed;
      top: 56%;
      left: 50%;
      text-align: center;
      transform: translate(-50%, -50%);
      color: black;
    }

    .dropzone {
      background: white;
      border-radius: 5px;
      border: 2px dashed rgb(0, 135, 247);
      border-image: none;
      /*max-width: 500px;*/
      margin-left: auto;
      margin-right: auto;
    }

    .dz-image img {
      width: 100% !important;
      height: 100% !important;
    }

    /* #split-bar {
      height: 100%;
      float: right;
      opacity: 0;
      width: 4px;
      cursor: col-resize;
    } */

    /* Make jqgrid pager responsive */
    @media only screen and (max-width: 1000px) {
      .ui-pager-control {
        display: block;
        height: auto;
      }

      .ui-pager-control table {
        display: flex;
        justify-content: center;
      }

      #jqGridPager_left,
      #jqGridPager_center {
        display: table-row;
        display: flex;
        justify-content: center;
        padding: 0 5px;
      }

      #jqGridPager_right {
        display: none;
      }

      /* Dynamic way to make responsive pager, but doesnt work on some andorid browsers */
      /*.ui-pager-control table tr td:not(.ui-pager-control table tr td *) {
        display: table-row;
        display: flex;
        justify-content: center;
        padding: 0 5px;
      }
      .ui-pager-control table tr td:not(.ui-pager-control table tr td *):last-child {
        display: none;
      }*/
    }

    /* Make jqgrid pager sticky to bottom */
    .ui-jqgrid-pager.ui-jqgrid-pager {
      background: #fff;
      position: sticky;
      bottom: 0;
      overflow-x: scroll;
    }

    [id^=gview_] {
      z-index: 0;
    }

    /* Override default left pager width(10px) */
    .ui-pg-table td {
      width: auto !important;
    }
  </style>

  <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

  <title>{{ $title ?? 'No title' }} | Trucking</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

  <!-- Daterangepicker -->
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">

  <!-- JqGrid -->
  <link rel="stylesheet" href="{{ asset('libraries/jqgrid/560/css/trirand/ui.jqgrid-bootstrap4.css') }}" />

  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/4.0.13/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2/themes/select2-bootstrap4.min.css') }}">

  <!-- Jquery UI -->
  <link rel="stylesheet" href="{{ asset('libraries/jquery-ui/1.13.1/jquery-ui.min.css') }}">

  <!-- Custom styles -->
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

  <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/dropzone/dropzone.css') }}">

  <style>
    * {
      font-size: 14px;
      text-transform: uppercase;
    }
  </style>

</head>

<body class="sidebar-mini layout-fixed sidebar-collapse">
  <div class="loader d-none" id="loader">
    <h1 id="txt1">Mohon Tunggu</h1>
  </div>

  <div id="dialog-message" title="Pesan" class="text-center text-danger" style="display: none;">
    <span class="fa fa-exclamation-triangle" aria-hidden="true" style="font-size:25px;"></span>
    <p></p>
  </div>

  @dd((new \App\Http\Controllers\Controller)->class);

  <div class="wrapper">
    @include('layouts._navbar')

    @include('layouts._sidebar')

    <div class="content-wrapper">
      @yield('content')
    </div>

    @include('layouts._footer')
  </div>

  <!-- jQuery -->
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <script src="{{ asset('js/jquery.min.js') }}"></script>

  <!-- Bootstrap 4 -->
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- jQuery UI -->
  <script src="{{ asset('libraries/jquery-ui/1.13.1/jquery-ui.min.js') }}"></script>

  <!-- ChartJS -->
  <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>

  <!-- Daterangepicker -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/5.0.6/jquery.inputmask.min.js"></script>
  <script src="{{ asset('plugins/dropzone/dropzone.js') }}"></script>

  <!-- daterangepicker -->
  <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>

  <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>

  <!-- AdminLTE App -->
  <script src="{{ asset('dist/js/adminlte.js') }}"></script>

  <!-- JqGrid -->
  <script src="{{ asset('libraries/jqgrid/560/js/trirand/src/jquery.jqGrid.js') }}"></script>
  <script src="{{ asset('libraries/jqgrid/560/js/trirand/i18n/grid.locale-en.js') }}"></script>

  <!-- Autonumeric -->
  <script src="{{ asset('libraries/autonumeric/4.5.4/autonumeric.min.js') }}"></script>

  <!-- Select2 -->
  <script src="{{ asset('plugins/select2/4.0.13/js/select2-customized.js') }}"></script>

  <script src="{{ asset('plugins/select2/js/select2-customized.js') }}"></script>

  <!-- Custom global script -->
  <!-- Inputmask -->
  <script src="{{ asset('libraries/inputmask/5.0.6/jquery.inputmask.min.js') }}"></script>

  <!-- Custom global script -->
  <script src="{{ asset('mains.js') }}"></script>

  <!-- Custom page script -->
  @stack('scripts')

  <script type="text/javascript">
    $(".formatdate").datepicker({
        dateFormat: 'dd-mm-yy',
        assumeNearbyYear: true
      })
      .inputmask({
        inputFormat: "dd-mm-yyyy",
        alias: "datetime",
      })
      .focusout(function(e) {
        let val = $(this).val()
        if (val.match('[a-zA-Z]') == null) {
          if (val.length == 8) {
            $(this).inputmask({
              inputFormat: "dd-mm-yyyy",
            }).val([val.slice(0, 6), '20', val.slice(6)].join(''))
          }
        } else {
          $(this).focus()
        }
      })
      .focus(function() {})
  </script>
</body>

</html>