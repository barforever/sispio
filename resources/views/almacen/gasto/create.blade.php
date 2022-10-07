@extends ('layouts.admin') <!--traemos la plantilla-->

@section ('contenido') <!--abrimos la seccion donde estara nuestro contenido dinamico donde 'contenido' es el que definimos en la plantilla-->
    <div class="row ml-1 mr-1 p-2 border bg-light">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h4>INGRESA NUEVO GASTO </h4>
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
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">            
        
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <a href="javascript:history.back()"><button class="btn btn-success float-right">Atras</button></a>
        </div>
    </div>
            {!!Form::open(array('url'=>'almacen/gasto','method'=>'POST','autocomplete'=>'off','files'=>'true'))!!}
            {{Form::token()}}
    <div class="row ml-1 mr-1 p-2 border">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" required value="{{old('nombre')}}" class="form-control" placeholder="Nombre...">
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
                <label for="cantidad">Cantidad</label>
                <input type="text" name="cantidad" required value="{{old('cantidad')}}" class="form-control" placeholder="Cantidad...">
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group">
                <label for="costo">Costo</label>
                <input type="text" name="costo" required value="{{old('costo')}}" class="form-control" placeholder="Costo...">
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="form-group">
                <label for="detalle">Detalle de Gasto</label>
                <textarea name="detalle"  rows="3" value="{{old('detalle')}}" class="form-control" placeholder="Detalle el motivo del gasto (boleta, factura, etc)..."></textarea>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-center">
            <div class="form-group">
                <label for="">.</label></br></br>
                <button class="btn btn-primary" type="submit">Guardar</button>
                <button class="btn btn-danger" type="reset">Cancelar</button>
            </div>
        </div>
    </div> 
            {!!Form::close()!!}
     
@endsection