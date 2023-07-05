<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | {{ config('app.name') }}</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('libraries/adminlte/plugins/fontawesome-free/css/all.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('libraries/adminlte/dist/css/adminlte-customized.min.css') }}">

    <!-- overlayScrollbars -->
    <link rel="stylesheet"
        href="{{ asset('libraries/adminlte/plugins/overlayScrollbars/css/OverlayScrollbars.min.css') }}">

    <!-- Daterange picker -->
    <link rel="stylesheet" href="{{ asset('libraries/adminlte/plugins/daterangepicker/daterangepicker.css') }}">

    <!-- JqGrid -->
    <link rel="stylesheet" href="{{ asset('libraries/jqgrid/570/css/ui.jqgrid-bootstrap4.css') }}" />

    <!-- Select2 -->
    <link rel="stylesheet" href="{{ asset('libraries/adminlte/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('libraries/adminlte/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">

    <!-- Jquery UI -->
    <link rel="stylesheet" href="{{ asset('libraries/jquery-ui/cupertino/jquery-ui.min.css') }}">

    <!-- Nestable2 -->
    <link rel="stylesheet" href="{{ asset('libraries/nestable2/1.6.0/css/jquery.nestable.min.css') }}" />

    <!-- Custom styles -->
    <link rel="stylesheet" href="{{ asset('libraries/tas-lib/css/styles.css?version=' . config('app.version')) }}">
    <link rel="stylesheet" href="{{ asset('libraries/tas-lib/css/pager.css?version=' . config('app.version')) }}">

    <link rel="stylesheet" href="{{ asset('libraries/adminlte/plugins/dropzone/dropzone.css') }}">
    <style>
        body {
            height: 100vh;
            display: flex;
            align-items: center;
            width: 100%;
        }
        label{
            color: black;
        }
    </style>
</head>

<body class="bg-primary">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6 offset-md-3 col-lg-4 offset-lg-4">
                <h5 class="text-center text-white card-label">
                    Silahkan masukkan password baru anda.
                </h5>

                <div class="card">
                    <div class="card-body">
                        <form id="reset-password-form" action="#" class="form-group">
                            @csrf
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="">Password Baru</label>
                                    <input type="password" name="password" class="form-control">
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="">Konfirmasi Password</label>
                                    <input type="password" name="password_confirmation" class="form-control">
                                </div>
                            </div>

                            <button class="btn btn-primary w-100 d-block">Ganti Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('libraries/adminlte/plugins/jquery/jquery.min.js') }}"></script>

    <!-- jQuery UI -->
    <script src="{{ asset('libraries/jquery-ui/1.13.1/jquery-ui.min.js') }}"></script>

    <script src="{{ asset('libraries/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script>
        let jwtToken = `{{ $token }}`

        $(document).ready(() => {
            $('#reset-password-form').submit(function(event) {
                event.preventDefault()

                let apiUrl = `{{ config('app.api_url') }}`
                let submitButton = $(this).find('button:submit').first()

                submitButton.attr('disabled', 'disabled')

                $.ajax({
                    url: `${apiUrl}reset-password/${jwtToken}`,
                    method: 'POST',
                    dataType: 'JSON',
                    data: $(this).serializeArray(),
                    beforeSend: () => {
                        submitButton.attr('disabled', 'disabled')
                    },
                    success: response => {
                        window.location = `{{ URL::route('reset-password.success') }}`
                    },
                    error: error => {
                        submitButton.removeAttr('disabled')

                        if (error.status === 422) {
                            $('.is-invalid').removeClass('is-invalid')
                            $('.invalid-feedback').remove()

                            setErrorMessages(error.responseJSON.errors)
                        } else {
                            showAlert('Ups...', 'Ada yang salah. Silahkan coba lagi nanti.',
                                'error')
                        }
                    }
                })
            })
        })

        function setErrorMessages(errors) {
            $(`[name=${Object.keys(errors)[0]}]`).focus();

            $.each(errors, (index, error) => {
                $(`[name=${index}]`).addClass("is-invalid").after(`
          <div class="invalid-feedback">
          ${error}
          </div>
          `);
            });
        }

        function setSuccessMessage(message) {
            $('.card-label').remove()

            $('.card-body').html(`
        <p>${message}</p>
      `)
        }

        function showAlert(title, text, icon) {
            Swal.fire({
                icon: icon,
                title: title,
                text: text,
            })
        }
    </script>
</body>

</html>
