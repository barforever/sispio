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
                    <h4>DETALLE DEL GASTO</h4>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    @if ($gasto->estado =='0')
                        <td><h4 class="text-danger text-left">Gasto Anulado</h4></td>
                    @else
                        <td><h4 class="text-success text-left">Gasto Aceptado</h4></td>
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
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-primary">
            <h5>Fecha :</h5>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <h5>{{date("Y-m-d",strtotime($gasto->fecha))}}</h5>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-primary">
            <h5>Total Gasto:</h5>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <h5>S/. {{ number_format((float)$gasto->costo, 2, '.', '') }}</h5>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-primary">
            <h5>Nombre :</h5>
        </div>
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
            <h5>{{$gasto->nombre}}</h5>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-primary">
            <h5>Cantidad :</h5>
        </div>
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
            <h5>{{$gasto->cantidad}}</h5>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-primary">
            <h5>Detalle :</h5>
        </div>
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
            <h5>{{$gasto->detalle}}</h5>
        </div>        
    </div>

@endsection