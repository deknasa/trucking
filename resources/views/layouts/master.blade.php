<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Dashboard</title>

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


  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="{{ asset('plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css') }}">

  <!-- iCheck -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">

  <!-- JQVMap -->
  <link rel="stylesheet" href="{{ asset('plugins/jqvmap/jqvmap.min.css') }}">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">

  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('plugins/daterangepicker/daterangepicker.css') }}">

  <!-- summernote -->
  <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.min.css') }}">

  <!-- JqGrid -->
  <link rel="stylesheet" href="{{ asset('libraries/jqgrid/560/css/trirand/ui.jqgrid-bootstrap4.css') }}" />

  <style>
    * {
      font-size: 14px;
      text-transform: uppercase;
    }
  </style>
</head>

<body class="sidebar-mini layout-fixed sidebar-closed sidebar-collapse">
  <div class="wrapper">

    @include('layouts._navbar')

    @include('layouts._sidebar')

    <!-- <div class="content-wrapper"> -->
    @yield('content')
    <!-- </div> -->

    @include('layouts._footer')

    <aside class="control-sidebar control-sidebar-dark"></aside>
  </div>

  <!-- jQuery -->
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>

  <!-- jQuery UI 1.11.4 -->
  <script src="{{ asset('plugins/jquery-ui/jquery-ui.min.js') }}"></script>

  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    $.widget.bridge('uibutton', $.ui.button)
  </script>

  <!-- Bootstrap 4 -->
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- ChartJS -->
  <script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>

  <!-- Sparkline -->
  <script src="{{ asset('plugins/sparklines/sparkline.js') }}"></script>

  <!-- JQVMap -->
  <script src="{{ asset('plugins/jqvmap/jquery.vmap.min.js') }}"></script>
  <script src="{{ asset('plugins/jqvmap/maps/jquery.vmap.usa.js') }}"></script>

  <!-- jQuery Knob Chart -->
  <script src="{{ asset('plugins/jquery-knob/jquery.knob.min.js') }}"></script>

  <!-- daterangepicker -->
  <script src="{{ asset('plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('plugins/daterangepicker/daterangepicker.js') }}"></script>

  <!-- Tempusdominus Bootstrap 4 -->
  <script src="{{ asset('plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js') }}"></script>

  <!-- Summernote -->
  <script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>

  <!-- overlayScrollbars -->
  <script src="{{ asset('plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

  <!-- AdminLTE App -->
  <script src="{{ asset('dist/js/adminlte.js') }}"></script>

  <!-- JqGrid -->
  <script src="{{ asset('libraries/jqgrid/560/js/trirand/src/jquery.jqGrid.js') }}"></script>
  <script src="{{ asset('libraries/jqgrid/560/js/trirand/i18n/grid.locale-en.js') }}"></script>

  <!-- Custom global script -->

  <script src="{{ asset('mains.js') }}"></script>

  <!-- Custom page script -->
  @stack('scripts')
</body>

</html>