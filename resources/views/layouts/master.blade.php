<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title ?? 'No title' }} | Dashboard</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/fontawesome-free/css/all.min.css') }}">

  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">

  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">
  
  <!-- Daterange picker -->
  <link rel="stylesheet" href="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.css') }}">

  <!-- JqGrid -->
  <link rel="stylesheet" href="{{ asset('libraries/jqgrid/570/css/ui.jqgrid-bootstrap4.css') }}" />

  <!-- Select2 -->
  <link rel="stylesheet" href="{{ asset('plugins/select2/4.0.13/css/select2.min.css') }}">
  <link rel="stylesheet" href="{{ asset('plugins/select2/themes/select2-bootstrap4.min.css') }}">

  <!-- Jquery UI -->
  <link rel="stylesheet" href="{{ asset('libraries/jquery-ui/1.13.1/jquery-ui.min.css') }}">

  <!-- Nestable2 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.css" />

  <!-- Custom styles -->
  <link rel="stylesheet" href="{{ asset('css/styles.css?version='. config('app.version')) }}">
  <link rel="stylesheet" href="{{ asset('css/pager.css?version='. config('app.version')) }}">

  <link rel="stylesheet" href="{{ asset('plugins/dropzone/dropzone.css') }}">
</head>

<body class="hold-transition sidebar-collapse layout-fixed">
  <div class="loader" id="loader">
    <img src="{{ asset('images/hour-glass.gif') }}" rel="preload">
    <span>Loading</span>
  </div>

  <div id="dialog-message" title="Pesan" class="text-center text-danger" style="display: none;">
    <span class="fa fa-exclamation-triangle" aria-hidden="true" style="font-size:25px;"></span>
    <p></p>
  </div>
  
  <!-- Modal for report and export -->
  <div class="modal fade" id="rangeModal" tabindex="-1" aria-labelledby="rangeModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="rangeModalLabel">Pilih baris</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <form id="formRange" target="_blank">
          @csrf
          <div class="modal-body">
            <input type="hidden" name="sidx">
            <input type="hidden" name="sord">

            <div class="form-group row">
              <div class="col-sm-2 col-form-label">
                <label for="">Dari</label>
              </div>
              <div class="col-sm-10">
                <input type="text" name="dari" class="form-control autonumeric-report" autofocus>
              </div>
            </div>

            <div class="form-group row">
              <div class="col-sm-2 col-form-label">
                <label for="">Sampai</label>
              </div>
              <div class="col-sm-10">
                <input type="text" name="sampai" class="form-control autonumeric-report">
              </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Report</button>
            <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
          </div>
        </form>
      </div>
    </div>
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
                <li class="breadcrumb-item active" style="text-transform: uppercase;">
                  {!! \App\Helpers\Menu::setBreadcrumb() !!}
                </li>
              </ol>
            </div>
          </div>
        </div>
      </div>

      <section class="content">
        @yield('content')
      </section>
    </div>

    <footer class="main-footer">
      <strong>Design &copy; by <a href="#">IT PUSAT</a>.</strong>
    </footer>
  </div>

  <!-- jQuery -->
  <script src="{{ asset('adminlte/plugins/jquery/jquery.min.js') }}"></script>

  <!-- jQuery UI -->
  <script src="{{ asset('libraries/jquery-ui/1.13.1/jquery-ui.min.js') }}"></script>

  <!-- Highlight -->
  <script src="{{ asset('js/highlight.js') }}"></script>

  <!-- Bootstrap 4 -->
  <script src="{{ asset('adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

  <!-- ChartJS -->
  <script src="{{ asset('adminlte/plugins/chart.js/Chart.min.js') }}"></script>

  <!-- daterangepicker -->
  <script src="{{ asset('adminlte/plugins/moment/moment.min.js') }}"></script>
  <script src="{{ asset('adminlte/plugins/daterangepicker/daterangepicker.js') }}"></script>

  <!-- overlayScrollbars -->
  <script src="{{ asset('adminlte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js') }}"></script>

  <!-- AdminLTE App -->
  <script src="{{ asset('adminlte/dist/js/adminlte.js') }}"></script>

  <!-- JqGrid -->
  <script src="{{ asset('libraries/jqgrid/570/js/jquery.jqGrid.js') }}"></script>
  <script src="{{ asset('libraries/jqgrid/570/js/i18n/grid.locale-en.js') }}"></script>

  <!-- Autonumeric -->
  <script src="{{ asset('libraries/autonumeric/4.5.4/autonumeric.min.js') }}"></script>

  <!-- Select2 -->
  <script src="{{ asset('adminlte/plugins/select2/js/select2.full.min.js') }}"></script>

  <!-- Inputmask -->
  <script src="{{ asset('libraries/inputmask/5.0.6/jquery.inputmask.min.js') }}"></script>

  <!-- dropzone -->
  <script src="{{ asset('plugins/dropzone/dropzone.js') }}"></script>

  <!-- Nestable2 -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/nestable2/1.6.0/jquery.nestable.min.js"></script>

  <!-- Custom global script -->
  <script src="{{ asset('js/pager.js?version='. config('app.version')) }}"></script>
  <script src="{{ asset('js/lookup.js?version='. config('app.version')) }}"></script>
  <script src="{{ asset('mains.js?version='. config('app.version')) }}"></script>
  <script src="{{ asset('js/app.js?version='. config('app.version')) }}"></script>

  <!-- Custom page script -->
  @stack('scripts')

  <script type="text/javascript">
    let accessToken = `{{ session('access_token') }}`
    let appUrl = `{{ url()->to('/') }}`
    let apiUrl = `{{ config('app.api_url') }}`

    function separatorNumber(object) {
      var value = parseInt(object.value.replaceAll('.', '').replaceAll(',', ''));

      if ($.isNumeric(value)) {
        object.value = value.toLocaleString();
      } else {
        object.value = '';
      }

      return true;
    }

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

    $(document).ready(function() {
      Echo.channel('export')
        .listen('UpdateExportProgress', event => {
          $('.modal-body').append(`<div id="progressbar"></div>`)

          $(document).find('#progressbar').progressbar({
            value: event.progress
          })

          $('.ui-progressbar-value').addClass('text-center').text(`${parseInt(event.progress)}%`)

          if (event.progress >= 100) {
            $(document).find('#progressbar').remove()
          }
        })
    })

    $(document).on('collapsed.lte.pushmenu', () => {
      $('body').removeClass('sidebar-open')
    })

    $(document).on('shown.lte.pushmenu', () => {
      $('body').addClass('sidebar-open')
    })
  </script>
</body>

</html>