@extends ('layouts.admin') <!--traemos la plantilla-->

@section ('contenido') <!--abrimos la seccion donde estara nuestro contenido dinamico donde 'contenido' es el que definimos en la plantilla-->
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h3>Listado de ventas <a href="venta/create"><button class="btn btn-success">Nuevo</button></a></h3>
            @include('ventas.venta.search')
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <th>Fecha</th>
                        <th>Mozo</th>
                        <th>NumVenta</th>
                        <th>Mesa</th>
                        <th>Total</th>
                        <th>Estado</th>
                        <th>Opciones</th>
                    </thead>
                    @foreach ($ventas as $ven)
                    <tr>
                        <td>{{ $ven->fecha }}</td>
                        <td><p class="text-center">{{ $ven->mozo }}</p></td>
                        <td><p class="text-center">{{ $ven->num_venta }}</p></td>
                        <td><p class="text-center">{{ $ven->mesa }}</p></td>
                        <td><p class="text-right">s/. {{ $ven->monto_total }}</p></td>
                        @if ($ven->estado =='0')
                            <td><p class="text-danger text-center"><strong>Anulado</strong></p></td>
                        @else
                            <td><p class="text-success text-center"><strong>Aceptado</strong></p></td>
                        @endif
                        <td>
                            <a href="{{URL::action('VentaController@show',$ven->idventa)}}"><button class="btn btn-primary">Detalles</button></a>
                            @if ($ven->estado == '0')
                                <a href="" data-target="#modal-delete-{{$ven->idventa}}" data-toggle="modal"><button class="btn btn-danger" disabled="disabled">Anular</button></a>
                            @else
                            <a href="" data-target="#modal-delete-{{$ven->idventa}}" data-toggle="modal"><button class="btn btn-danger">Anular</button></a>
                            @endif
                        </td>                        
                    </tr>
                    @include('ventas.venta.modal')
                    @endforeach
                </table>
            </div>
            {{$ventas->render()}}
        </div>
    </div>

@endsection