<!DOCTYPE html>
<html lang="en">
<head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <link rel= "shortcut icon" type= "/img/x-icon"href="/img/icono.ico">
     <title>Reporte de Usuarios</title>
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    
     <link rel="stylesheet" href="css/tablasReportePDF.css">
     <link rel="stylesheet" type="text/css" href="css/index.css">
     <style>
      .code{
           height:80px !important;
      }
th,h5,p{
  font-family: "Times New Roman", Times, serif;
}
      td{
        font-size:70%;
        font-family: "Times New Roman", Times, serif;
      }
    </style>

</head>
<body>  

<header>
<div class="row">
  <div class="col  border-success"><img src="img/logo.png" class="rounded-circle" width="130" height="100"></div>
  <div class="col border-success"><p style="text-align:right"><strong>Fecha: <?php echo date('Y-n-j');?> 
    <br> Hora del sistema: 
  <?php
  $now = new \DateTime();
  echo $now->format('H:i:s');
?></strong></p></div>
</div>

</header>

  <h1 class="text-center">Reporte de Usuarios</h1>
  <div>
     <table class="table my-3">
  <thead class="thead-dark">
    <tr>
        <th scope="col">Cedula</th>
        <th scope="col">Nombre</th>
        <th scope="col">Email</th>
        <th scope="col">Rol</th>
    </tr>
  </thead>
  <!-- $Usuarios Proviene de PDFController en el metodo PDFUsuarios -->
  <tbody>
  @foreach($users as $user)
    <tr>
        <td>{{$user->id}}</td>
        <td>{{$user->nombre}}</td>
        <td>{{$user->email}}</td>
        <td>{{$user->name_screen}}</td>
    </tr>
    @endforeach
  </tbody>
</table>
     </div> 
     <br>
     <div class="footer footer-sm-md-lg-xl">
    <p class="text-white"> 
        <strong class="text-white ">© Copyright <?php echo date("Y");?> Sistema de informacion para gestion de colaboradores </strong>
    </p>
</div>
</body>
</html>