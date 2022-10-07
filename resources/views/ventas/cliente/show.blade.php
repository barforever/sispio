@extends ('layouts.admin') <!--traemos la plantilla-->

@section ('contenido')
<style>
    t { color: #007BFF; }
</style>
    <div class="row ml-1 mr-1 p-2 border bg-light">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h4><t>{{ $cliente->nombre }}</t></h4>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <h4>VISITAS: {{ $visitas->cant}}</h4>
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
                <label for="nombre" class="font-weight-bold text-primary">Nombre</label>
                <p name="nombre" class="form-control-static form-control-sm">{{ $cliente->nombre }}</p>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="tipo_documento" class="font-weight-bold text-primary">{{ $cliente->tipo_documento }}</label>
                <p name="tipo_documento" class="form-control-static form-control-sm">{{ $cliente->num_documento }}</p>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="direccion" class="font-weight-bold text-primary">Direccion</label>
                <p name="direccion" class="form-control-static form-control-sm">{{ $cliente->direccion }}</p>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="telefono" class="font-weight-bold text-primary">Telefono</label>
                <p name="telefono" class="form-control-static form-control-sm">{{ $cliente->telefono }}</p>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="f_nacimiento" class="font-weight-bold text-primary">Fecha de Nacimiento</label>
                <p name="f_nacimiento" class="form-control-static form-control-sm">{{ $cliente->f_nacimiento }}</p>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="email" class="font-weight-bold text-primary">Email</label>
                <p name="email" class="form-control-static form-control-sm">{{ $cliente->email }}</p>
            </div>
        </div>
    </div>
@endsection