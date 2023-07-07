<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Trucking | Log in</title>

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <style>
      body {
        height: 100vh;
        display: flex;
        align-items: center;
        width: 100%;
      }
    </style>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-6 offset-md-3 col-lg-4 offset-lg-4">
                <div class="alert alert-success" role="alert">
                    <h4 class="alert-heading">Berhasil!</h4>
                    <hr>
                    <p>Password anda berhasil diubah. Silahkan login dengan password baru.</p>
                    <a href="{{ config('app.url') }}/login" class="btn btn-primary">Login</a>
                </div>
            </div>
        </div>
    </div>


</body>

</html>
