<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">

  </head>
    {{--
      COMENTARIOS
        @yield es un metodo de blade que crea una seccion, para introducir distintos tipos de informacion
        EN POCAS PALABRAS EN YIELD VA TODO LO QUE NO SE REPITE. LO DEMAS ES CODIGO QUE SE REPITE EN
        CADA HTML. POR EJEMPLO ENCABEZADO Y EL FOOTER, YA QUE ESTOS DOS VAN EN TODAS LAS PAGINAS.
    --}}
  <body>
    <div class="container">
      <a href="{{ route('venta') }}" class="btn btn-primary" role="button">Ventas</a>
      <a href="{{ route('producto') }}" class="btn btn-primary" role="button">Productos</a>
      <a href="{{ route('mozo') }}" class="btn btn-primary" role="button">Mozos</a>
      <a href="{{ route('reporte') }}" class="btn btn-primary" role="button">Reportes</a>
      <!-- boton desactivado <button type="button" class="btn btn-primary" disabled="disabled">Boton</button>-->
    </div>

    <div class="container">
      @yield('seccion')
    </div>

    <div>footer</div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
  </body>
</html>