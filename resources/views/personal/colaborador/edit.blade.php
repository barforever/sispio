@extends ('layouts.admin') <!--traemos la plantilla-->

@section ('contenido') <!--abrimos la seccion donde estara nuestro contenido dinamico donde 'contenido' es el que definimos en la plantilla-->
    <div class="row ml-1 mr-1 p-2 border bg-light">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
            <h4>EDITAR COLABORADOR(A): <nom>{{ $colaborador->nickname }}</nom></h4>
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
    {!!Form::model($colaborador,['method'=>'PATCH','route'=>['colaborador.update',$colaborador->idcolaborador]])!!}
    {{Form::token()}}
    <div class="row ml-1 mr-1 p-2 border">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="nickname">NickName</label>
                <input type="text" name="nickname" required value="{{ $colaborador->nickname }}" class="form-control" placeholder="Nombre Abreviado...">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="nombres">Nombres</label>
                <input type="text" name="nombres" required value="{{ $colaborador->nombres }}" class="form-control" placeholder="Nombres...">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="apellidos">Apellidos</label>
                <input type="text" name="apellidos" required value="{{ $colaborador->apellidos }}" class="form-control" placeholder="Apellidos...">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="dni">DNI</label>
                <input type="text" name="dni" required value="{{ $colaborador->dni }}" class="form-control" placeholder="DNI...">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="direccion">Direccion</label>
                <input type="text" name="direccion" required value="{{ $colaborador->direccion }}" class="form-control" placeholder="Direccion...">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="telefono">Telefono</label>
                <input type="text" name="telefono" required value="{{ $colaborador->telefono }}" class="form-control" placeholder="Telefono...">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label>Cargo</label>
                <select name="idcargo" class="form-control">
                    @foreach ($cargos as $cargo)
                        @if ($cargo->idcargo==$colaborador->idcargo)
                            <option value="{{$cargo->idcargo}}" selected>{{$cargo->nombre}}</option>   
                        @else
                            <option value="{{$cargo->idcargo}}">{{$cargo->nombre}}</option>
                        @endif                        
                    @endforeach
                </select>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label>Turno</label>
                <select name="idturno" class="form-control">
                    @foreach ($turnos as $turno)
                        @if ($turno->idturno==$colaborador->idturno)
                            <option value="{{$turno->idturno}}" selected>{{ date('H:i A', strtotime($turno->hora_inicio)).'-'.date('H:i A', strtotime($turno->hora_salida)) }}</option>   
                        @else
                            <option value="{{$turno->idturno}}">{{ date('H:i A', strtotime($turno->hora_inicio)).'-'.date('H:i A', strtotime($turno->hora_salida)) }}</option>
                        @endif                         
                    @endforeach
                </select>
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