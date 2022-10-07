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
                    <h4>CANTIDAD DE PRODUCTOS VENDIDOS EL :   <t> {{$fecha->fecha}} </t>  </h4>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <a href="javascript:history.back()"><button class="btn btn-success float-right">Atras</button></a>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-primary">
                    <h6>Fecha :</h6>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <h6>{{$fecha->fecha}}</h6>
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-primary">
                    <h6>Total Venta :</h6>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    @foreach ($suma as $s) <h6>S/. {{ number_format((float)$s->monto_total, 2, '.', '') }}</h6>@endforeach
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-primary">
                    <h6>Cant de Pollo :</h6>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    @foreach ($cantpollo as $cp) <h6>{{ number_format((float)$cp->pollo, 3, '.', '') }} pollos</h6>@endforeach
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-primary">
                    <h6>P. Vendidos :</h6>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    @foreach ($cantplatos as $pl) <h6>{{$pl->platos}} platos y bebidas vendidos</h6>@endforeach
                </div>                
            </div>
        </div>
    </div>

    <!-- div detalles --> 
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">        
            <table class="table table-striped table-bordered table-condensed table-hover table-sm">
                <thead class="text-center text-white" style="background-color:#007BFF">
                    <th>Productos</th>
                    <th>Cantidad</th>
                    <th>CantPollo</th>
                    <th>Precio Venta</th>
                    <th>Total</th>
                </thead>
                <tfoot class="table-secondary text-primary text-center">
                    <th><h6 class="text-center">Totales </h6></th>
                    @foreach ($cantplatos as $pl)
                    <th><h6 class="text-center">{{ $pl->platos }} </h6></th>
                    @endforeach
                    @foreach ($cantpollo as $cp)
                    <th><h6 class="text-right">{{ number_format((float)$cp->pollo, 3, '.', '') }} </h6></th>
                    @endforeach
                    <th></th>
                    @foreach ($suma as $total)
                    <th><h6 class="text-right">S/. {{ number_format((float)$total->monto_total, 2, '.', '') }} </h6></th>
                    @endforeach
                    </tfoot>
                <tbody>
                    @foreach ($ventas as $det)
                    <tr>
                        <td>{{ $det->nombre }}</td>
                        <td class="text-center">{{ $det->cant }}</td>                                
                        <td class="text-right">{{ number_format((float)$det->cpollo, 3, '.', '') }}</td>                               
                        <td class="text-right">s/. {{ number_format((float)$det->precio_venta, 2, '.', '') }}</td>                                
                        <td class="text-right">s/. {{ number_format((float)$det->total, 2, '.', '') }}</td>                                
                    </tr>
                    @endforeach
                </tbody>
            </table>           
        </div>
    </div>

@endsection