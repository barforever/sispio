<!DOCTYPE html>
<html lang="es">
  <head>
    <!-- Etiquetas <meta> obligatorias para Bootstrap -->
    <meta charset="UTF-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Enlazando el CSS de Bootstrap -->
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="{{asset('css/bootstrap.min.css')}}" media="screen">
    <link rel="stylesheet" href="{{asset('css/bootstrap-select.min.css')}}" media="screen">
    <link rel="stylesheet" href="{{asset('css/style.css')}}" media="screen">
    <link rel="stylesheet" href="{{asset('css/all.css')}}" media="screen">
    <link rel="icon" type="image/ico" href="{{asset('imagenes/ico/pollitopio.ico')}}" />

    <title>El Pollito Pio</title>

    <style>
        act { color: #28A745; }
        dact { color: #DC3545; }
        nom { color: #007BFF; }
    </style>
  </head>
  <body>
    <header>      
      
    </header>
  
      @yield('reporte') <!--yield nos va crear un espacio donde ira nuestro contenido dinamico (que no repite)-->


  </body>

</html>

