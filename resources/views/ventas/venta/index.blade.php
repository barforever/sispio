@extends ('layouts.admin') <!--traemos la plantilla-->

@section ('contenido') <!--abrimos la seccion donde estara nuestro contenido dinamico donde 'contenido' es el que definimos en la plantilla-->
    <div class="row ml-1 mr-1 p-2 border bg-light">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
            <h4>PEDIDOS <act>EN ATENCIÓN</act></h4>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <a href="{{URL::action('ClienteController@index')}}"><button class="btn btn-danger float-right"><i class="far fa-plus-square fa-fw"></i> Clientes</button></a>
        </div>
    </div>
    <div class="row" style="height:10px">
        
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover table-sm">
                    <thead class="text-center text-black" style="background-color:#f8c819">
                        <th>N</th>
                        <th>Mesa</th>
                        <th>Fecha</th>
                        <th>Comd</th>
                        <th>Mozo</th>
                        <th>Total</th>
                        <th>Opciones</th>
                    </thead>
                    @foreach ($pedidos as $pedido)
                    <tr>
                        <td class="text-center">{{ $n2-- }}</td>                                            
                        <td class="text-center"><h5><i class="fas fa-dumpster fa-fw"></i> {{ $pedido->num_mesa }}<h5></td>
                        <td class="text-left">{{ $pedido->fecha }}</td>
                        <td class="text-center">{{ $pedido->num_comanda }}</td>                                     
                        <td class="text-center">{{ $pedido->nickname }}</td>
                        <td class="text-center">S/.{{ number_format((float)$pedido->monto_total , 2, '.', '') }}</td>
                        <td class="text-center">
                            <a href="{{URL::action('VentaController@create',$pedido->idpedido)}}"><button class="btn btn-success btn-sm"><i class="fas fa-cash-register fa-fw"></i> Cobrar</button></a>                                                                         
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
            {{$pedidos->render()}}
        </div>
    </div>

    <div class="row" style="height:40px">
        
    </div>
    <div class="row ml-1 mr-1 p-2 border bg-light">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h4>VENTAS <act>REALIZADAS</act></h4>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-success text-right">
            <a href="#"><button class="btn btn-success" ><h6>VENTAS</br>S/. {{ number_format((float)$sumav->monto_total , 2, '.', '') }}</h6></button></a>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-danger text-right">
            <a href="#"><button class="btn btn-danger" ><h6>COMPRAS</br>S/. {{ number_format((float)$sumac->monto_total , 2, '.', '') }}</h6></button></a>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-primary text-right">
            <a href="#"><button class="btn btn-primary" ><h6>ENTREGAR</br>S/. {{ number_format((float)$sumav->monto_total , 2, '.', '') }}</h6></button></a>
        </div>
    </div>
    <div class="row" style="height:10px">
        
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover table-sm">
                    <thead class="text-center text-black" style="background-color:#f8c819">
                        <th>N</th>
                        <th>Cliente</th>
                        <th>Comprobante</th>
                        <th>Monto</th>
                        <th>Opciones</th>
                    </thead>
                    @foreach ($ventas as $venta)
                    <tr>    
                        <td class="text-center">{{ $n-- }}</td>
                        <td class="text-left">{{ $venta->nombre }}</td>
                        <td class="text-left">{{ $venta->tipo_comprobante.$venta->serie_comprobante.'-'.str_pad($venta->num_comprobante,5,"0",STR_PAD_LEFT) }}</td>                                     
                        <td class="text-right">S/. {{ number_format((float)$venta->monto_total , 2, '.', '') }}</td>
                        <td class="text-center">
                            <a href="{{URL::action('VentaController@show',$venta->idpedido)}}"><button class="btn btn-info btn-sm"><i class="far fa-file-alt fa-fw"></i>Detalles</button></a>                                                                         
                        </td>
                    </tr>
                    @endforeach
                </table>
            </div>
            {{$ventas->render()}}
        </div>
    </div>
@push('scripts')
<script>
    //Cuando la página esté cargada completamente
    $(document).ready(function(){
        //Cada 10 segundos se ejecutará la función refrescar
        setTimeout(refrescar, 30000);
    });
    function refrescar(){
        //Actualiza la el div con los datos de imagenes.php
        location.reload();
    }
</script>
@endpush
@endsection