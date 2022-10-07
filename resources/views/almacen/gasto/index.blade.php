@extends ('layouts.admin') <!--traemos la plantilla-->

@section ('contenido') <!--abrimos la seccion donde estara nuestro contenido dinamico donde 'contenido' es el que definimos en la plantilla-->
<style>
    t { color: #007BFF; }
</style>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                    <h4>LISTA DE GASTOS DE HOY :  <t> {{$hoy}} </t> </h4>
                </div>
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
                    @foreach ($costo as $c)
                        <h4 class="text-center">Total Gasto S/. {{ number_format((float)$c->costo, 2, '.', '') }}</h4>
                    @endforeach
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <a href="gasto/create"><button class="btn btn-success float-right">Ingresa Gasto</button></a>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="height:10px">
    
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover table-sm">
                    <thead class="text-center text-white" style="background-color:#007BFF">
                        <th>N</th>
                        <th>Nombre</th>
                        <th>Cantidad</th>
                        <th>Costo</th>
                        <th>Estado</th>
                        <th>Opciones</th>
                    </thead>
                    @foreach ($gastos as $g)
                    <tr>
                        <td><p class="text-center">{{ $n-- }}</p></td>
                        <td><p class="text-center">{{ $g->nombre }}</p></td>
                        <td><p class="text-center">{{ $g->cantidad }}</p></td>
                        <td><p class="text-right">S/. {{ number_format((float)$g->costo, 2, '.', '') }}</p></td>
                        @if ( $g->estado == '0' )
                            <td><p class="text-danger text-center"><strong>Anulado</strong></p></td>
                        @else
                            <td><p class="text-success text-center"><strong>Aceptado</strong></p></td>
                        @endif
                        <td class="text-center">
                        <a href="{{URL::action('GastoController@show',$g->idgasto)}}"><button class="btn btn-primary btn-sm">Detalles</button></a>
                            @if ($g->estado == '0')
                                <a href="" data-target="#modal-delete-{{$g->idgasto}}" data-toggle="modal"><button class="btn btn-danger btn-sm" disabled="disabled">Anular</button></a>
                            @else
                            <a href="" data-target="#modal-delete-{{$g->idgasto}}" data-toggle="modal"><button class="btn btn-danger btn-sm">Anular</button></a>
                            @endif
                        </td>                        
                    </tr>
                    @include('almacen.gasto.modal')
                    @endforeach
                </table>
            </div>
            {{$gastos->render()}}
        </div>
    </div>

@endsection