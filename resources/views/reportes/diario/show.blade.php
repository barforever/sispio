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
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <h4>DETALLE DE LA VENTA N° : <t> {{$venta->num_venta}} </t>  </h4>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    @if ($venta->estado =='0')
                        <td><h4 class="text-danger text-left">Venta Anulada</h4></td>
                    @else
                        <td><h4 class="text-success text-left">Venta Aceptada</h4></td>
                    @endif    
                </div>
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
                    <a href="javascript:history.back()"><button class="btn btn-success float-right">Atras</button></a>
                </div>
            </div>
        </div>
    </div>
    <!-- div detalles --> 
    <div class="row ml-1 mr-1 p-3 border">
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 text-primary">
            <h6>Fecha :</h6>
        </div>
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
            <h6>{{date("Y-m-d",strtotime($venta->fecha))}}</h6>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-primary">
            <h6>Total Venta :</h6>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <h6>S/. {{ number_format((float)$venta->monto_total, 2, '.', '') }}</h6>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 text-primary">
            <h6>Mozo :</h6>
        </div>
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
            <h6>{{$venta->mozo}}</h6>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-primary">
            <h6>Cant. Pollo :</h6>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <h6> @foreach ($pollo as $po) {{ number_format((float)$po->pollo, 3, '.', '') }} Pollos @endforeach</h6>
        </div>
        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12 text-primary">
            <h6>Mesa :</h6>
        </div>
        <div class="col-lg-11 col-md-11 col-sm-11 col-xs-12">
            <h6>{{$venta->mesa}}</h6>
        </div>
           
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-3">        
            <table class="table table-striped table-bordered table-condensed table-hover table-sm">
                <thead class="text-center text-white" style="background-color:#007BFF">
                    <th>Productos</th>
                    <th>Cantidad</th>
                    <th>Precio Venta</th>
                    <th>Sub Total</th>
                </thead>
                <tfoot class="table-secondary text-primary text-center">
                    <th></th>
                    <th></th>
                    <th></th>
                    <th><h5 id="total" class="text-right">Total: S/. {{ number_format((float)$venta->monto_total, 2, '.', '') }}</h5></th>
                </tfoot>
                <tbody>
                    @foreach ($detalles as $det)
                    <tr>
                        <td class="pl-3 pr-3">{{ $det->producto }}</td>
                        <td><p class="text-center">{{ $det->cantidad }}</p></td>
                        <td><p class="text-right">S/. {{ number_format((float)$det->precio_venta, 2, '.', '') }}</p></td>
                        <td><p class="text-right">S/. {{ number_format((float)$det->cantidad*$det->precio_venta, 2, '.', '') }}</p></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>            
        </div>
    </div>
    
@endsection