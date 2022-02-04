<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>AdminLTE 3 | Dashboard</title>

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

  <!-- Custom styles -->
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>

<body class="sidebar-mini layout-fixed sidebar-closed sidebar-collapse">
  <div class="loader d-none" id="loader">
    <h1 id="txt1">Mohon Tunggu</h1>
  </div>

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

  <!-- Autonumeric -->
  <script src="{{ asset('libraries/autonumeric/4.5.4/autonumeric.js') }}"></script>
  
  <!-- Custom global script -->
  <script src="{{ asset('mains.js') }}"></script>

  <!-- Custom page script -->
  @stack('scripts')
</body>

</html>