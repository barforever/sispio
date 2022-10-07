@extends ('layouts.admin') <!--traemos la plantilla-->

@section ('contenido')
    <div class="row ml-1 mr-1 p-2 border bg-light">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
            <h5>DETALLE DEL PRODUCTO: </br><nom>{{$producto->nombre}}</nom></h5>
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
    <!-- div detalles --> 
    <div class="row ml-1 mr-1 p-2 border">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <h5>@if ($producto->estado=='1') <act>Producto Activado</act>@else <dact>Producto Desactivado</dact> @endif</h5>
                    <div class="form-group row">
                        <label for="fecha" class="col-lg-2 col-md-2 col-sm-2 col-xs-12 col-form-label font-weight-bold">Nombre :</label>
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                            <input type="text" readonly class="form-control-plaintext" id="fecha" value="{{ $producto->nombre }}">
                        </div>
                        <label for="fecha" class="col-lg-2 col-md-2 col-sm-2 col-xs-12 col-form-label font-weight-bold">Categoria :</label>
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                            <input type="text" readonly class="form-control-plaintext" id="fecha" value="{{ $producto->categoria }}">
                        </div>
                        <label for="fecha" class="col-lg-2 col-md-2 col-sm-2 col-xs-12 col-form-label font-weight-bold">Precio :</label>
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                            <input type="text" readonly class="form-control-plaintext" id="fecha" value="S/. {{ number_format((float)$producto->precio, 2, '.', '') }}">
                        </div>
                        <label for="fecha" class="col-lg-2 col-md-2 col-sm-2 col-xs-12 col-form-label font-weight-bold">Imagen :</label>
                        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
                            <img src="{{asset('imagenes/productos/'.$producto->imagen)}}" height="150px" width="150px" class="img-thumbnail">
                        </div>
                    </div>                    
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive-sm">
                        <table class="table table-bordered table-condensed table-hover table-sm">
                            <thead class="text-center text-black thead-light">
                                <tr>    
                                    <th>N</th>
                                    <th>Insumo</th>
                                    <th>Cant Usada</th>
                                    <th>Und Med</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach ($insumosproducto as $ip)
                                <tr>
                                    <td class="text-center">{{ $n++ }}</td>
                                    <td class="text-left">{{ $ip->nombre }}</td>
                                    <td class="text-center">{{ $ip->cantidad_utilizada }}</td>                       
                                    <td class="text-center">{{ $ip->unidad_medida }}</td> 
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>                
                </div>
            </div>                
        </div>
    </div>

@endsection