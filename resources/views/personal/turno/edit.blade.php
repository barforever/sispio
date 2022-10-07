@extends ('layouts.admin') <!--traemos la plantilla-->

@section ('contenido') <!--abrimos la seccion donde estara nuestro contenido dinamico donde 'contenido' es el que definimos en la plantilla-->
    <div class="row ml-1 mr-1 p-2 border bg-light">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
            <h4>EDITAR TURNO: <nom>{{ date('H:i A', strtotime($turno->hora_inicio)) }}</nom></h4>
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
    {!!Form::model($turno,['method'=>'PATCH','route'=>['turno.update',$turno->idturno]])!!}
    {{Form::token()}}
    <div class="row ml-1 mr-1 p-2 border">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="hora_inicio">Hora de Ingreso</label>
                <input type="time" name="hora_inicio" required value="{{ date('H:i', strtotime($turno->hora_inicio)) }}" class="form-control" placeholder="00:00">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="hora_salida">Hora de Salida</label>
                <input type="time" name="hora_salida" required value="{{ date('H:i', strtotime($turno->hora_salida)) }}" class="form-control" placeholder="00:00">
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