@extends ('layouts.admin') <!--traemos la plantilla-->

@section ('contenido') <!--abrimos la seccion donde estara nuestro contenido dinamico donde 'contenido' es el que definimos en la plantilla-->
    <div class="row ml-1 mr-1 p-2 border bg-light">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
            <h4>NUEVO PRODUCTO</h4>
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
    {!!Form::open(array('url'=>'almacen/producto','method'=>'POST','autocomplete'=>'off','files'=>'true'))!!}
    {{Form::token()}}
    <div class="row ml-1 mr-1 p-1 border">
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
            <div class="row p-1 border-right">
                <!-- div Nombre Producto-->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-primary">        
                    <div class="form-group">
                        <label for="nombre"><h6> Nombre Producto</h6></label>
                        <input type="text" name="nombre" required value="{{old('nombre')}}" class="form-control" placeholder="Nombre Producto...">
                    </div>
                </div>        
                <!-- div categoria -->              
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-primary">
                    <div class="form-group">
                        <label for="categoria"><h6> Categoria </h6></label>
                        <select name="idcategoria" class="form-control">
                            @foreach ($categorias as $categoria)
                            <option value="{{$categoria->idcategoria}}">{{$categoria->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- div mesa -->
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-primary">        
                    <div class="form-group">
                        <label for="precio"><h6> Precio </h6></label>
                        <input type="text" name="precio" required value="{{old('precio')}}" class="form-control" placeholder="Precio..">         
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-primary">
                    <div class="form-group">
                        <label for="imagen"><h6>Imagen</h6></label>
                        <input type="file" name="imagen" class="form-control">
                    </div>
                </div>             
            </div>
        </div>

        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
            <div class="row p-1">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <h5 class="text-center">INSUMOS USADOS EN PRODUCTO</h5>
                    </div>
                </div>       
                <!-- div producto --> 
                <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12 text-primary">        
                    <div class="form-group">
                        <label><h6>Insumo</h6></label>
                        <select name="pidinsumo" class="form-control selectpicker" id="pidinsumo" data-live-search="true">
                            @foreach ($insumos as $insumo)
                            <option value="{{$insumo->idinsumo}}_{{$insumo->cantidad}}_{{$insumo->unidad_medida}}">{{$insumo->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- div cantidad --> 
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 text-primary">        
                    <div class="form-group">
                        <label for="cantidad_utilizada"><h6>Cant Usada</h6></label>
                        <input type="number" step="any" name="pcantidad_utilizada" id="pcantidad_utilizada" class="form-control" placeholder="Cant Usada..">
                    </div>
                </div>
                <!-- div precio_venta --> 
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-primary">        
                    <div class="form-group">
                        <label for="unidad_medida"><h6>Und Med</h6></label>
                        <input type="text" disabled name="punidad_medida" id="punidad_medida" class="form-control" placeholder="">
                    </div>
                </div>
                <!-- div boton agregar --> 
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-right text-primary">        
                    <div class="form-group">
                        <label for="agregar"></label>
                        <button type="button" id="bt_add" class="btn btn-info btn-sm"><i class="far fa-plus-square fa-fw"></i> Agregar</button>
                    </div>
                </div>
                <!-- div detalles --> 
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-3">
                    <div class="table-responsive">            
                    <table id="detalles" class="table table-bordered table-condensed table-hover table-sm">
                        <thead class="text-center text-black" style="background-color: #f8c819">
                            <th>Quitar</th>
                            <th>Insumo</th>
                            <th>Cant Usada</th>
                            <th>Und Medida</th>
                        </thead>
                    </table>
                    </div>            
                </div>   
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" id="guardar">        
                    <div class="form-group">
                        <input name="_token" value="{{ csrf_token() }}" type="hidden">
                        <button class="btn btn-primary" type="submit"><i class="far fa-save fa-fw"></i> Guardar</button>
                        <button class="btn btn-danger" type="reset"><i class="far fa-window-close fa-fw"></i> Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {!!Form::close()!!}

@push ('scripts')
<script>
    $(document).ready(function(){
        $('#bt_add').click(function(){
            agregar();
        });
    });

    var cont=0;
    total=0;
    //$("#guardar").hide();
    $("#pidinsumo").change(mostrarValores);

    function mostrarValores()
    {
        datosInsumo=document.getElementById('pidinsumo').value.split('_');
        $("#punidad_medida").val(datosInsumo[2]);
    }

    function agregar() 
    {
        datosInsumo=document.getElementById('pidinsumo').value.split('_');

        idinsumo=datosInsumo[0];
        insumo=$("#pidinsumo option:selected").text();
        cantidad_utilizada=$("#pcantidad_utilizada").val();

        unidad_medida=$("#punidad_medida").val();

        if (idinsumo!="" && cantidad_utilizada!="" && cantidad_utilizada>0)
        {
            //total++

            var fila='<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-danger" onclick="eliminar('+cont+');">x</button></td><td><input type="hidden" name="idinsumo[]" value="'+idinsumo+'">'+insumo+'</td><td><input type="number" step="any" name="cantidad_utilizada[]" value="'+cantidad_utilizada+'"></td><td><input type="text" disabled name="unidad_medida[]" value="'+unidad_medida+'"></td></tr>';
        
            cont++;
            limpiar();
            //evaluar();
            $('#detalles').append(fila);   
        }
        else
        {
            alert("Error al ingresar el detalle de la venta, revise los datos del insumo");
        }
    }

    function limpiar() 
    {
        $("#pcantidad_utilizada").val("");      
        $("#punidad_medida").val("");
    }

    /*function evaluar() 
    {
        if (total>0) 
        {
            $("#guardar").show(); 
        }    
        else
        {
            $("#guardar").hide();
        }
    }*/

    function eliminar(index) {
        total=total-total
        $("#fila" + index).remove();
        //evaluar();
    }
</script>
@endpush
@endsection