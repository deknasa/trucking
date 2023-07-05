<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trucking | Log in</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('libraries/adminlte/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('libraries/adminlte/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('libraries/adminlte/dist/css/adminlte.min.css') }}">
    <!-- Jquery UI -->
    <link rel="stylesheet" href="{{ asset('libraries/jquery-ui/cupertino/jquery-ui.min.css') }}">
    <!-- Custom Style -->
    <link rel="stylesheet" href="{{ asset('libraries/tas-lib/css/styles.css?version=' . config('app.version')) }}">
</head>

<body class="hold-transition login-page">
    <div id="dialog-success-message" title="Pesan" class="text-center text-success" style="display: none;">
        <span class="fa fa-check" aria-hidden="true" style="font-size:25px;"></span>
        <p></p>
    </div>


    <div id="dialog-message" title="Error" class="text-center text-danger" style="display: none;">
        <span class="fa fa-exclamation-triangle" aria-hidden="true" style="font-size:25px;"></span>
        <p></p>
    </div>

    <div class="processing-loader d-none" id="processingLoader">
        <img src="{{ asset('libraries/tas-lib/img/loading-color.gif') }}" rel="preload">
        <span>Processing</span>
    </div>


    <div class="login-box">
        <div class="login-logo">
            <img class="mx-auto d-block" src="{{ asset('libraries/tas-lib/img/logo-min.png') }}" width="150"
                height="150">
            <h5 style="font-family: 'Open Sans Condensed';">PT. TRANSPORINDO AGUNG SEJAHTERA</h5>
            <p style="font-family: 'Open Sans Condensed'; font-size:1rem" class="text-success">TRUCKING DEV</p>
        </div>
        <div class="card">
            <div class="card-body login-card-body">
                <p class="login-box-msg">Login</p>
                @error('user_not_found')
                    <div class="alert alert-danger">
                        {{ $message }}
                    </div>
                @enderror
                <form action="{{ route('login.process') }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="text" name="user" value="{{ env('LOGIN_USER', 'admin') }}" id="user"
                            class="form-control @error('user') is-invalid @enderror" placeholder="User ID" autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                        @error('user')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" value="{{ env('LOGIN_PASSWORD', '123456') }}"
                            id="password" class="form-control @error('password') is-invalid @enderror"
                            placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                        @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <div id="error">
                    </div>
                    {{-- <a href="{{ config('app.api_url') }}">reset password</a> --}}
                    <a href="javascript: void(0)" id="resetPassword">reset password</a>
                    <div class="row">
                        <div class="col-md-4 offset-md-8">
                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <p>Copyright &copy; <?= Date('Y') ?></p>
    <p>Halaman ini dimuat selama <strong>{{ number_format(microtime(true) - LARAVEL_START, 2) }}</strong> detik</p>

    <!-- jQuery -->
    <script src="{{ asset('libraries/adminlte/plugins/jquery/jquery.min.js') }}"></script>
    <!-- jQuery UI -->
    <script src="{{ asset('libraries/jquery-ui/1.13.1/jquery-ui.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('libraries/adminlte/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('libraries/adminlte/dist/js/adminlte.min.js') }}"></script>

    <script>
        $(document).ready(function() {


            $(document).on('click', '#resetPassword', function() {
                let form = $('#user')
                let user = $('#user').val();


               
                checkValidation(user)
                    .then((response) => {
                        $('#processingLoader').removeClass('d-none')
                        $.ajax({
                            url: `{{ config('app.api_url') }}forgot-password`,
                            method: 'POST',
                            dataType: "JSON",
                            data: {
                                user: user
                            },
                            success: (response) => {
                                $('#processingLoader').addClass('d-none')

                                $("#dialog-success-message").find("p").remove();
                                $("#dialog-success-message").append(
                                    `<p> ${response.message} </p>`
                                );
                                $("#dialog-success-message").dialog({
                                    modal: true,
                                    buttons: [{
                                        text: "Ok",
                                        click: function() {
                                            $(this).dialog("close");
                                        },
                                    }, ]
                                });
                                showSuccessDialog(response.message)
                            },
                            // error: error => {

                            // },
                        }).always(() => {
                            $('#processingLoader').addClass('d-none')

                        });
                    })
                    .catch((error) => {
                        $("#dialog-message").html(`
                            <span class="fa fa-exclamation-triangle" aria-hidden="true" style="font-size:25px;"></span>
                          `)
                        $("#dialog-message").append(
                            `<p class="text-dark"> MESSAGE </p> ${error.responseJSON.errors.user}`
                        );
                        $("#dialog-message").dialog({
                            modal: true,
                            buttons: [{
                                text: "Ok",
                                click: function() {
                                    $(this).dialog("close");
                                },
                            }, ]
                        });

                        $(".ui-dialog-titlebar-close").find("p").remove();
                    })

            });

            function checkValidation(user) {
                return new Promise((resolve, reject) => {
                    $('#processingLoader').removeClass('d-none')
                    $.ajax({
                            url: `{{ config('app.api_url') }}forgot-password`,
                            method: 'POST',
                            dataType: "JSON",
                            data: {
                                user: user
                            },
                            success: (response) => {
                                resolve(response);
                            },
                            error: error => {
                                console.log(error)
                                reject(error)

                            }
                        })
                        .always(() => {
                            $('#processingLoader').addClass('d-none')

                        });
                });
            }

        })
    </script>
</body>

</html>
