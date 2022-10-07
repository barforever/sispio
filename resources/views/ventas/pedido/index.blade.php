@extends ('layouts.admin') <!--traemos la plantilla-->

@section ('contenido') <!--abrimos la seccion donde estara nuestro contenido dinamico donde 'contenido' es el que definimos en la plantilla-->
    <div class="row ml-1 mr-1 p-2 border bg-light">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
            <h4>REALIZA PEDIDO</h4>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <!--<a href="#"><button class="btn btn-success float-right"><i class="far fa-plus-square fa-fw"></i> Imprimir</button></a>-->
        </div>
    </div>
    <div class="row" style="height:10px">
        
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h6><i class="fa fa-dumpster fa-fw" style="color:black"></i> : Mesa Libre - <i class="fa fa-dumpster fa-fw" style="color:orange"></i> : Mesa en Atencion</h6>
        </div>
    </div>

    <div class="row ml-1 mr-1 p-1 border">
        @foreach ($mesas as $mesa) 
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">             
            <div class="row align-items-center">
                <div class="row m-3 border">                                     
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group text-center">
                            </br>
                            <span class="fa-stack fa-lg">
                                @if ($mesa->estado == '2')
                                <i class="fa fa-dumpster fa-5x fa-stack-2x text-warning pull-right"></i>
                                <i class="fa fa-stack-1x fa-inverse">{{$mesa->num_mesa}}</i>
                                @else
                                <a href="{{URL::action('PedidoController@create',$mesa->idmesa)}}"><i class="fa fa-dumpster fa-5x fa-stack-2x text-dark pull-right"></i>
                                <i class="fa fa-stack-1x fa-inverse">{{$mesa->num_mesa}}</i></a>    
                                @endif
                            </span>                   
                        </div>
                    </div>
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">                    
                        <div class="form-group text-center">
                            @if ($mesa->estado == '2')
                            <a href="{{URL::action('PedidoController@show',$mesa->idmesa)}}"><button class="btn btn-info btn-sm"><i class="far fa-file-alt fa-fw"></i></button></a>
                            <a href=""><button class="btn btn-primary btn-sm" disabled><i class="fa fa-pencil-alt fa-fw"></i></button></a>
                            <a href="" data-target="#modal-delete-{{$mesa->idmesa}}" data-toggle="modal"><button class="btn btn-danger btn-sm"><i class="far fa-window-close fa-fw"></i></button></a>
                            @else
                            <a href=""><button class="btn btn-info btn-sm" disabled><i class="far fa-file-alt fa-fw"></i></button></a>
                            <a href=""><button class="btn btn-primary btn-sm" disabled><i class="fa fa-pencil-alt fa-fw"></i></button></a>
                            <a href=""><button class="btn btn-danger btn-sm" disabled><i class="far fa-window-close fa-fw"></i></button></a>
                            @endif
                        </div>
                    </div>
                </div>    
            </div>
        </div>
        @include('ventas.pedido.modal')
        @endforeach 
    </div>

    <div class="row" style="height:30px">
        
    </div>
    <div class="row ml-1 mr-1 p-2 border bg-light">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
            <h4>LISTA DE PEDIDOS DEL DIA</h4>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <!--<a href="#"><button class="btn btn-success float-right"><i class="far fa-plus-square fa-fw"></i> Imprimir</button></a>-->
        </div>
    </div>
    <div class="row" style="height:10px">
        
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">            
            @include('ventas.pedido.search')
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <h6><i class="far fa-check-circle fa-fw" style="color:green"></i> : Cobrado - <i class="far fa-times-circle fa-fw" style="color:red"></i> : Anulado</h6>
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover table-sm">
                    <thead class="text-center text-black" style="background-color:#f8c819">
                        <th>N</th>
                        <th>Mesa</th>
                        <th>Fecha</th>
                        <th>Comd</th>
                        <th>Mozo</th>
                        <th>Total</th>
                        <th>Est</th>
                        <th>Opciones</th>
                    </thead>
                    @foreach ($pedidos as $pedido)
                    <tr>
                        <td class="text-center">{{ $n-- }}</td>
                        <td class="text-center"><i class="fas fa-dumpster fa-fw"></i> {{ $pedido->num_mesa }}</a></td>
                        <td class="text-center">{{ $pedido->fecha}}</td>                       
                        <td class="text-right">{{ $pedido->num_comanda}}</td>                       
                        <td class="text-center">{{ $pedido->nickname}}</td>                       
                        <td class="text-right">S/.{{ number_format((float)$pedido->monto, 2, '.', '') }}</td>                       
                        @if ($pedido->estado == '2')
                            <td class="text-center"><i class="fas fa-utensils fa-fw" style="color:orange"></i></td>
                        @elseif ($pedido->estado == '1')
                            <td class="text-center"><i class="far fa-check-circle fa-fw" style="color:green"></i></td>
                        @else
                            <td class="text-center"><i class="far fa-times-circle fa-fw" style="color:red"></i></td>
                        @endif                                      
                        <td class="text-center">
                            <a href="{{URL::action('PedidoController@show2',$pedido->idpedido)}}"><button class="btn btn-info btn-sm"><i class="far fa-file-alt fa-fw"></i> Detalle</button></a>                                                                        
                        </td>
                    </tr>
                    
                    @endforeach
                </table>
            </div>
            {{$pedidos->render()}}
        </div>
    </div>
@push('scripts')
<script>
    //Cuando la página esté cargada completamente
    $(document).ready(function(){
        //Cada 10 segundos se ejecutará la función refrescar
        setTimeout(refrescar, 15000);
    });
    function refrescar(){
        //Actualiza la el div con los datos de imagenes.php
        location.reload();
    }
</script>
@endpush
@endsection