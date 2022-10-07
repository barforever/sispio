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
    {{--
      COMENTARIOS
        @yield es un metodo de blade que crea una seccion, para introducir distintos tipos de informacion
        EN POCAS PALABRAS EN YIELD VA TODO LO QUE NO SE REPITE. LO DEMAS ES CODIGO QUE SE REPITE EN
        CADA HTML. POR EJEMPLO ENCABEZADO Y EL FOOTER, YA QUE ESTOS DOS VAN EN TODAS LAS PAGINAS.
    --}}
  <body>
      <nav class="navbar navbar-expand-lg navbar-light fixed-top navbar-shrink pt-1" style="background-color:#f8c819">
        <div class="container">
          <a class="navbar-brand" href="#"> <h4> Sistema Pollito Pio </h4> </a>
          <button class="navbar-toggler navbar-toggler-right bg-danger text-white" type="button" data-toggle="collapse" data-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
            <!--<span class="navbar-toggler-icon"></span>-->
            Menu
            <i class="fas fa-bars fa-fw" style="color:white"></i></td>
          </button>
        
          <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
              <li class="nav-item m-1">
                <a class="btn btn-danger btn-lg" role="button" href="{{URL::action('PedidoController@index')}}">Pedidos</a>
              </li>
              <li class="nav-item m-1">
                  <a class="btn btn-danger btn-lg" role="button" href="{{URL::action('VentaController@index')}}">Ventas</a>
                </li>
                <li class="nav-item m-1">
                  <a class="btn btn-danger btn-lg" role="button" href="{{URL::action('IngresoController@index')}}">Compras</a>
              </li>
              <li class="nav-item m-1">
                  <a class="btn btn-danger btn-lg" role="button" href="{{URL::action('ReporteController@index')}}">Reportes</a>
              </li>
              <li class="nav-item dropdown m-1">
                <a class="btn btn-danger btn-lg dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Almacen
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="{{URL::action('CategoriaController@index')}}">Categoria</a>
                  <a class="dropdown-item" href="{{URL::action('InsumoController@index')}}">Insumo</a>
                  <a class="dropdown-item" href="{{URL::action('ProductoController@index')}}">Producto</a>
                  <a class="dropdown-item" href="{{URL::action('ProveedorController@index')}}">Proveedor</a>
              </li>
              <li class="nav-item dropdown m-1">
                <a class="btn btn-danger btn-lg dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  Configurar
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                  <a class="dropdown-item" href="{{URL::action('TurnoController@index')}}">Turno</a>
                  <a class="dropdown-item" href="{{URL::action('CargoController@index')}}">Cargo</a>
                  <a class="dropdown-item" href="{{URL::action('MesaController@index')}}">Mesa</a>
                  <a class="dropdown-item" href="{{URL::action('ColaboradorController@index')}}">Colaborador</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="#">Reporte Venta</a>
                </div>
              </li>
            </ul>
          </div>
        </div>
      </nav>
    <header>      
      
    </header>
      <div class="container">
        <div class="row" style="height:75px">
    
        </div>
      </div>

  
    <!-- <div class="row" style="height:10px">
    
    </div>-->

    <div class="container mb-5"  style="width:100%">
      @yield('contenido') <!--yield nos va crear un espacio donde ira nuestro contenido dinamico (que no repite)-->
    </div>

      <div class="container">  
        <div class="row" style="height:20px">
    
        </div>
      </div>

    <footer class="page-footer font-small fixed-bottom" style="background-color:#f8c819">
      <div class="row" style="height:5px">
    
      </div>
      <div class="footer-copyright text-center py-3"> <h6>© 2019 Copyright:
        <a href="https://www.facebook.com/Pollos-a-la-Brasa-El-Pollito-Pio-432373547199452/"> Pollos a la Brasa "El Pollito Pio"</a></h6>
      </div>
    </footer>

    <!-- Opcional: enlazando el JavaScript de Bootstrap -->
    <script src="{{asset('js/jquery-3.3.1.slim.min.js')}}"></script>
    <script src="{{asset('js/jQuery-2.1.4.min.js')}}"></script>
    @stack('scripts')
    
    <script src="{{asset('js/popper.min.js')}}"></script>

    <script src="{{asset('js/bootstrap.min.js')}}"></script>
    <script src="{{asset('js/bootstrap-select.min.js')}}"></script>

    <script src="{{asset('js/app.min.js')}}"></script>
  </body>

</html>

