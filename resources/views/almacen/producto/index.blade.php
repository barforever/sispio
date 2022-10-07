@extends ('layouts.admin') <!--traemos la plantilla-->

@section ('contenido') <!--abrimos la seccion donde estara nuestro contenido dinamico donde 'contenido' es el que definimos en la plantilla-->
<div class="row ml-1 mr-1 p-2 border bg-light">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
            <h4>PRODUCTOS</h4>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <a href="producto/create"><button class="btn btn-success float-right"><i class="far fa-plus-square fa-fw"></i> Nuevo</button></a>
        </div>
    </div>
    <div class="row" style="height:10px">
        
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">            
            @include('almacen.producto.search')
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover table-sm">
                    <thead class="text-center text-black" style="background-color:#f8c819">
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>P.Venta</th>
                        <th>categoria</th>
                        <th>Est</th>
                        <th>Opciones</th>
                    </thead>
                    @foreach ($productos as $producto)
                    <tr>
                        <td class="text-center">{{ $producto->idproducto }}</td>
                        <td class="text-left">
                            <a href="{{URL::action('ProductoController@show',$producto->idproducto)}}"><img src="{{asset('imagenes/productos/'.$producto->imagen)}}" alt="{{$producto->nombre}}" height="55px" width="80px" class="img-thumbnail"></a>
                        </td>
                        <td class="text-right">S/.{{ number_format((float)$producto->precio, 2, '.', '') }}</td>     
                        <td class="text-center">{{ $producto->categoria }}</td>         
                        @if ($producto->estado == '1')
                            <td class="text-center"><i class="far fa-check-circle fa-fw" style="color:green"></i></td>
                        @else
                            <td class="text-center"><i class="far fa-times-circle fa-fw" style="color:red"></i></td>
                        @endif                                      
                        <td class="text-center">
                        @if ($producto->estado=='1')
                            <a href="{{URL::action('ProductoController@edit',$producto->idproducto)}}"><button class="btn btn-info btn-sm"><i class="fas fa-pencil-alt fa-fw"></i> Editar</button></a>
                        @else
                            <a href="{{URL::action('ProductoController@edit',$producto->idproducto)}}"><button class="btn btn-info btn-sm" disabled><i class="fas fa-pencil-alt fa-fw"></i> Editar</button></a>
                        @endif    
                        @if ($producto->estado=='1')
                            <a href="" data-target="#modal-delete-{{$producto->idproducto}}" data-toggle="modal"><button class="btn btn-danger btn-sm"><i class="far fa-trash-alt fa-fw"></i> Desact</button></a>
                        @else
                            <a href="" data-target="#modal-delete-{{$producto->idproducto}}" data-toggle="modal"><button class="btn btn-success btn-sm"><i class="far fa-check-circle fa-fw"></i> Activar</button></a>
                        @endif                                                                         
                        </td>
                    </tr>
                    @include('almacen.producto.modal')
                    @endforeach
                </table>
            </div>
            {{$productos->render()}}
        </div>
    </div>
@endsection