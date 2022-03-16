<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

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

  <!-- Nestable2 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.css" />

  <!-- Custom styles -->
  <link rel="stylesheet" href="{{ asset('css/styles.css') }}">

  <link rel="stylesheet" href="{{ asset('plugins/dropzone/dropzone.css') }}">

</head>

<body class="sidebar-mini layout-fixed sidebar-collapse">
  <div class="loader d-none" id="loader">
    <h1 id="txt1">Mohon Tunggu</h1>
  </div>

  <div id="dialog-message" title="Pesan" class="text-center text-danger" style="display: none;">
    <span class="fa fa-exclamation-triangle" aria-hidden="true" style="font-size:25px;"></span>
    <p></p>
  </div>

  <div class="wrapper">
    @include('layouts._navbar')

    @include('layouts._sidebar')

    <div class="content-wrapper">
      <div class="content-header">
        <div class="container-fluid">
          <div class="row mb-2">
            <div class="col-sm-12">
              <ol class="breadcrumb">
                <li class="breadcrumb-item active">
                  {!! \App\Helpers\Menu::setBreadcrumb() !!}
                </li>
              </ol>
            </div>
          </div>
        </div>
      </div>
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

  <!-- Nestable2 -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.js"></script>
  
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