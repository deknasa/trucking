<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Trucking | Log in</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="{{ asset('plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
  <!-- Custom Style -->
  <link rel="stylesheet" href="{{ asset('css/styles.css?version=' . config('app.version')) }}">
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <img class="mx-auto d-block" src="{{ asset('images/logo-min.png') }}" width="150" height="150">
      <h5 style="font-family: 'Open Sans Condensed';"><b>PT. TRANSPORINDO AGUNG SEJAHTERA</b></h5>
      <p style="font-family: 'Open Sans Condensed'; font-size:1rem" class="text-success"><b>TRUCKING DEV</b></p>
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
            <input type="text" name="user" value="{{ env('LOGIN_USER', 'admin') }}" id="user" class="form-control @error('user') is-invalid @enderror" placeholder="User ID" autofocus>
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
            <input type="password" name="password" value="{{ env('LOGIN_PASSWORD', '123456') }}" id="password" class="form-control @error('password') is-invalid @enderror" placeholder="Password">
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
          <div class="row">
            <div class="col-md-4 offset-md-8">
              <button type="submit" class="btn btn-primary btn-block">Sign In</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
  <p>Copyright &copy; <?= Date("Y") ?></p>
  <p>Halaman ini dimuat selama <strong>{{ number_format(microtime(true) - LARAVEL_START, 2) }}</strong> detik</p>

  <!-- jQuery -->
  <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
  <!-- Bootstrap 4 -->
  <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
  <!-- AdminLTE App -->
  <script src="{{ asset('js/adminlte.min.js') }}"></script>
</body>

</html>