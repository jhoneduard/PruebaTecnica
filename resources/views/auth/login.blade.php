<!DOCTYPE html>
<html lang="es">
<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Sistema Ventas Laravel Vue Js- IncanatoIT">
  <meta name="author" content="Incanatoit.com">
  <meta name="keyword" content="Sistema ventas Laravel Vue Js, Sistema compras Laravel Vue Js">

  <title>Sistema Ventas - IncanatoIT</title>

  <link href="css/plantilla.css" rel="stylesheet">
  <script src="js/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="css/sweetalert2.min.css">

</head>

<body class="app flex-row align-items-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card-group mb-0">
          <div class="card p-4">
            <div class="card-body">
              <h1 class="text-muted text-center">Login</h1>

                <form method="POST" action="{{ route('login') }}">
                    @csrf

              <div class="input-group mb-3">
                <span class="input-group-addon"><i class="icon-user"></i></span>
                <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                @error('email')
                <script>
                  Swal.fire({
                  icon: 'error',
                  text: 'No existe un usuario con esas credenciales'
                  });
                  </script>
            @enderror
            
            </div>
              <div class="input-group mb-4">
                <span class="input-group-addon"><i class="icon-lock"></i></span>
                <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">

                @error('password')
                <script>
                  Swal.fire({
                  icon: 'error',
                  text: 'No existe un usuario con esas credenciales'
                  });
                  </script>
            @enderror

             </div>

             <div class="row">
                <div class="col-6">
                    <button type="submit" class="btn btn-primary">
                        {{ __('Login') }}
                    </button>

                </div>
              </div>

            </form>
            </div>
          </div>
          <div class="card text-white bg-primary py-5 d-md-down-none" style="width:44%">
            <div class="card-body text-center">
              <div>
                <h2>Sistema de informacion para la gestion de colaboradores</h2>

              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="js/plantilla.js"></script>

</body>
</html>