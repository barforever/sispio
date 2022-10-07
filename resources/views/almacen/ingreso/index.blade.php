@extends ('layouts.admin') <!--traemos la plantilla-->

@section ('contenido') <!--abrimos la seccion donde estara nuestro contenido dinamico donde 'contenido' es el que definimos en la plantilla-->
    <div class="row ml-1 mr-1 p-2 border bg-light">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
            <h4>COMPRAS HOY : <nom>{{$hoy}}</nom></h4>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <a href="ingreso/create"><button class="btn btn-success float-right"><i class="far fa-plus-square fa-fw"></i> Nuevo</button></a>
        </div>
    </div>
    <div class="row" style="height:10px">
        
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">            
            @include('almacen.ingreso.search')
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h6><i class="far fa-check-circle fa-fw" style="color:green"></i> : Pagado - <i class="far fa-times-circle fa-fw" style="color:red"></i> : Anulado</h6>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover table-sm">
                    <thead class="text-center text-black" style="background-color:#f8c819">
                        <th>N</th>
                        <th>Proveedor</th>
                        <th>Comprobante</th>
                        <th>Monto</th>
                        <th>Est</th>
                        <th>Opciones</th>
                    </thead>
                    @foreach ($compras as $compra)
                    <tr>
                        <td class="text-center">{{$n--}}</td>
                        <td class="text-center">{{$compra->nombre}}</td>
                        <td class="text-left">{{ $compra->tipo_comprobante.$compra->serie_comprobante.'-'.str_pad($compra->num_comprobante,5,"0",STR_PAD_LEFT) }}</td>                       
                        <td class="text-center">S/.{{ number_format((float)$compra->monto_total , 2, '.', '') }}</td>
                        @if ($compra->estado == '1')
                            <td class="text-center"><i class="far fa-check-circle fa-fw" style="color:green"></i></td>
                        @else
                            <td class="text-center"><i class="far fa-times-circle fa-fw" style="color:red"></i></td>
                        @endif 
                        <td class="text-center">
                                <a href="{{URL::action('IngresoController@show',$compra->idingreso)}}"><button class="btn btn-info btn-sm"><i class="far fa-file-alt fa-fw"></i>Detalles</button></a>                                                                        
                        </td>
                    </tr>
                    
                    @endforeach
                </table>
            </div>
            {{$compras->render()}}
        </div>
    </div>

@endsection