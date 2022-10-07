@extends ('layouts.admin') <!--traemos la plantilla-->

@section ('contenido')
<style>
    t { color: #007BFF; }
</style>

    <div class="row" style="height:20px">
    
    </div>

    <div class="card">
        <div class="card-header">
            <div class="row">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <h4>DETALLE DE GASTOS DEL DIA :   <t> {{$fecha->fecha}} </t>  </h4>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <a href="javascript:history.back()"><button class="btn btn-success float-right">Atras</button></a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-primary">
                    <h5>Fecha :</h5>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <h5>{{$fecha->fecha}}</h5>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-primary">
                    <h5>Total Venta :</h5>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    @foreach ($costo as $c) <h5>S/. {{ number_format((float)$c->costo, 2, '.', '') }}</h5>@endforeach
                </div>                
            </div>
        </div>
    </div>

    <!-- div detalles --> 
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">        
            <table class="table table-striped table-bordered table-condensed table-hover table-sm">
                <thead class="text-center text-white" style="background-color:#007BFF">
                    <th>Nombre</th>
                    <th>Cantidad</th>
                    <th>Costo</th>
                    <th>Detalle</th>
                    <th>Estado</th>
                </thead>
                <tbody>
                    @foreach ($gastos as $g)
                    <tr>
                        <td class="pl-3 pr-3">{{ $g->nombre }}</td>
                        <td class="text-center">{{ $g->cantidad }}</td>                                
                        <td class="text-right">s/. {{ number_format((float)$g->costo, 2, '.', '') }}</td>                               
                        <td class="text-left pl-3 pr-3">{{ $g->detalle }}</td> 
                        @if ($g->estado =='0')
                            <td class="text-center text-danger"><strong>Anulado</strong></p></td>
                        @else
                            <td class="text-center text-success"><strong>Aceptado</strong></p></td>
                        @endif                                
                    </tr>
                    @endforeach
                </tbody>
            </table>           
        </div>
    </div>

@endsection