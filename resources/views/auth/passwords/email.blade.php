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

  <!-- Icons -->
  <link href="../assests/css/font-awesome.min.css" rel="stylesheet">
  <link href="../assests/css/simple-line-icons.min.css" rel="stylesheet">

  <!-- Main styles for this application -->
  <link href="../assests/css/style.css" rel="stylesheet">
  <script src="../js/sweetalert2.min.js"></script>
  <link rel="stylesheet" href="../css/sweetalert2.min.css">
  <script src="https://kit.fontawesome.com/c3a6c2f3b7.js" crossorigin="anonymous"></script>

</head>

<body class="app flex-row align-items-center">
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card-group mb-0">
          <div class="card p-4">
            <div class="card-body">
              <h3 class="text-muted text-center">Reestablecimiento de contraseña</h3>

              @if (session('status'))
              <div class="alert alert-success" role="alert">
                  {{ session('status') }}
              </div>
          @endif


              <form method="POST" action="{{ route('password.email') }}">
                @csrf
                <div class="row mb-3">
                    <label for="email" class="col-md-3 col-form-label text-md-end">Email</label>

                    <div class="col-md-9">
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                </div>

                <div class="text-center">
                        <button type="submit" class="btn btn-primary">
                            <i class="fa-solid fa-key"></i>    Reestablecer contraseña
                        </button>
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

  <!-- Bootstrap and necessary plugins -->
  <script src="../assests/js/jquery.min.js"></script>
  <script src="../assests/js/popper.min.js"></script>
  <script src="../assests/js/bootstrap.min.js"></script>

</body>
</html>