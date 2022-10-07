@extends ('layouts.admin') <!--traemos la plantilla-->

@section ('contenido') <!--abrimos la seccion donde estara nuestro contenido dinamico donde 'contenido' es el que definimos en la plantilla-->
    <div class="row ml-1 mr-1 p-2 border bg-light">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
            <h4>EDITAR CARGO: <nom>{{ $cargo->nombre }}</nom></h4>
            @if (count($errors)>0)
            <div class="alert alert-danger">
                <ul class="fa-ul">
                @foreach ($errors->all() as $error)
                    <li><i class="fa-li fa fa-exclamation-circle"></i> {{$error}}</li>
                @endforeach
                <ul>
            </div>
            @endif
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <a href="javascript:history.back()"><button class="btn btn-success float-right"><i class="far fa-arrow-alt-circle-left fa-fw"></i> Atras</button></a>
        </div>
    </div>
    <div class="row" style="height:10px">
        
    </div>
    {!!Form::model($cargo,['method'=>'PATCH','route'=>['cargo.update',$cargo->idcargo]])!!}
    {{Form::token()}}
    <div class="row ml-1 mr-1 p-2 border">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" class="form-control" value="{{ $cargo->nombre}}">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
            <div class="form-group">
                <label for="sueldo">Sueldo</label>
                <input type="text" name="sueldo" class="form-control" value="{{ $cargo->sueldo}}" placeholder="000.00">
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">  
            <div class="form-group">
                <button class="btn btn-primary" type="submit"><i class="far fa-save fa-fw"></i> Guardar</button>
                <button class="btn btn-danger" type="reset"><i class="far fa-window-close fa-fw"></i> Cancelar</button>
            </div>
            {!!Form::close()!!}
        </div>
    </div>
@endsection