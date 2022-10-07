@extends ('layouts.admin') <!--traemos la plantilla-->

@section ('contenido') <!--abrimos la seccion donde estara nuestro contenido dinamico donde 'contenido' es el que definimos en la plantilla-->
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h3>Editar Mozo {{$mozo->mozo}}</h3>
            @if (count($errors)>0)
            <div class="alert alert-danger">
                <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
                </ul>
            </div>
            @endif
        </div>
    </div>
            {!!Form::model($mozo,['method'=>'PATCH','route'=>['mozo.update',$mozo->idmozo]])!!}
            {{Form::token()}}
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="mozo">Nick</label>
                <input type="text" name="mozo" required value="{{$mozo->mozo}}" class="form-control" placeholder="Nick...">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="nombres">Nombres</label>
                <input type="text" name="nombres" required value="{{$mozo->nombres}}" class="form-control" placeholder="Nombres...">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="apellidos">Apellidos</label>
                <input type="text" name="apellidos" required value="{{$mozo->apellidos}}" class="form-control" placeholder="Apellidos...">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="telefono">Telefono</label>
                <input type="text" name="telefono" required value="{{$mozo->telefono}}" class="form-control" placeholder="Telefono...">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <button class="btn btn-primary" type="submit">Guardar</button>
                <button class="btn btn-danger" type="reset">Cancelar</button>
            </div>
        </div>
    </div>
            {!!Form::close()!!}

@endsection