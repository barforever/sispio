@extends ('layouts.admin') <!--traemos la plantilla-->

@section ('contenido')
<style>
    t { color: #007BFF; }
</style>
    <div class="row ml-1 mr-1 p-2 border bg-light">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h4><t>{{ $colaborador->nickname }}</t></h4>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            @if ($colaborador->estado == '1')
                <h4 class="text-success">CONTRATADO(A)</h4>
            @else
                <h4 class="text-danger">RETIRADO(A)</h4>
            @endif
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <a href="javascript:history.back()"><button class="btn btn-success float-right"><i class="far fa-arrow-alt-circle-left fa-fw"></i> Atras</button></a>
        </div>
    </div>
    <div class="row" style="height:10px">
        
    </div>
    
    <!-- div detalles --> 
    <div class="row ml-1 mr-1 p-2 border">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="nombres" class="font-weight-bold text-primary">NOMBRES Y APELLIDOS</label>
                <p name="nombres" class="form-control-static form-control-sm">{{ $colaborador->nombres.' '.$colaborador->apellidos }}</p>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="dni" class="font-weight-bold text-primary">DNI</label>
                <p name="dni" class="form-control-static form-control-sm">{{ $colaborador->dni }}</p>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="direccion" class="font-weight-bold text-primary">DIRECCION</label>
                <p name="direccion" class="form-control-static form-control-sm">{{ $colaborador->direccion }}</p>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="telefono" class="font-weight-bold text-primary">TELEFONO</label>
                <p name="telefono" class="form-control-static form-control-sm">{{ $colaborador->telefono }}</p>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="hora_inicio" class="font-weight-bold text-primary">HORA INGRESO</label>
                <p name="hora_inicio" class="form-control-static form-control-sm">{{ date('H:i A', strtotime($colaborador->hora_inicio)) }}</p>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="hora_salida" class="font-weight-bold text-primary">HORA SALIDA</label>
                <p name="hora_salida" class="form-control-static form-control-sm">{{ date('H:i A', strtotime($colaborador->hora_salida)) }}</p>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="sueldo" class="font-weight-bold text-primary">SUELDO</label>
                <p name="sueldo" class="form-control-static form-control-sm">S/. {{ $colaborador->sueldo }}</p>
            </div>
        </div>        
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="cargo" class="font-weight-bold text-primary">CARGO</label>
                <p name="cargo" class="form-control-static form-control-sm">{{ $colaborador->nombre }}</p>
            </div>
        </div>
    </div>
@endsection