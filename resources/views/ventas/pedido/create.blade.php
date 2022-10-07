@extends ('layouts.admin') <!--traemos la plantilla-->

@section ('contenido') <!--abrimos la seccion donde estara nuestro contenido dinamico donde 'contenido' es el que definimos en la plantilla-->
    <div class="row ml-1 mr-1 p-2 border bg-light">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h4>REALIZAR PEDIDO: </h4>
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
            
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <a href="javascript:history.back()"><button class="btn btn-success float-right"><i class="far fa-arrow-alt-circle-left fa-fw"></i> Atras</button></a>
        </div>
    </div>
    <div class="row" style="height:10px">
        
    </div>
    {!!Form::open(array('url'=>'ventas/pedido','method'=>'POST','autocomplete'=>'off'))!!}
    {{Form::token()}}
    <div class="row ml-1 mr-1 pt-2 border align-items-center">
        <div class="col-lg-3 col-md-3 col-sm-4 col-xs-12">
            <div class="form-group row">
                <label for="idmozo" class="col-lg-4 col-md-4 col-sm-4 col-xs-12 col-form-label col-form-label-sm">Mozo(a): </label>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <select name="idmozo" class="form-control form-control-sm">
                        @foreach ($mozos as $mozo)
                            <option value="{{$mozo->idcolaborador}}">{{$mozo->nickname}}</option>
                        @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
            <div class="form-group row">
                <label for="idmesa" class="col-lg-5 col-md-5 col-sm-5 col-xs-12 col-form-label col-form-label-sm">Mesa: </label>
                <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
                    <input type="number" name="num_mesa" disabled value="{{$mesa->num_mesa}}" class="form-control form-control-sm text-center" placeholder="Mesa">
                    <input type="hidden" name="idmesa" value="{{$mesa->idmesa}}" class="form-control">
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-sm-5 col-xs-12">
            <div class="form-group row">
                <label for="num_comanda" class="col-lg-4 col-md-4 col-sm-4 col-xs-12 col-form-label col-form-label-sm">Comanda: </label>
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <input type="number" step="any" name="num_comanda" value="" class="form-control  form-control-sm text-center" placeholder="Num. Comanda">
                </div>
            </div>
        </div>
    </div>
    
    <div class="row ml-1 mr-1 p-1 border">
        <div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
            <div class="row border-right">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <h5 class="text-left">PEDIDO</h5>
                    </div>
                </div>
                <!-- div detalles --> 
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12"  style="height:300px; overflow-y : scroll">
                    <div class="table-responsive small" style="font-size:10px">            
                    <table id="detalles" class="table table-striped table-condensed table-hover table-sm">
                        <thead class="text-center text-black thead-light">
                            <th>Quitar</th>
                            <th class="col-lg-4 col-md-4 col-sm-4 col-xs-12">Producto</th>
                            <th>Cant</th>
                            <th>P.Unit</th>
                            <th>Import</th>
                        </thead>
                    </table>
                    </div>            
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 pt-4">
                    <div class="form-group row border text-right mr-2 ml-2 bg-light">
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12"></div>
                        <label for="num_comanda" class="col-lg-3 col-md-3 col-sm-3 col-xs-12 col-form-label col-form-label-sm"><h5>TOTAL: </h5></label>
                        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                            <h4 id="total">S/. 0.00</h4><input type="hidden" name="monto_total" id="monto_total">
                        </div>
                    </div>
                </div>
            </div>            
        </div>

        <div class="col-lg-8 col-md-8 col-sm-6 col-xs-12">
            <div class="row p-1">      
                <!-- div producto --> 
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-primary">        
                    <div class="form-group">
                        <label><h6>Producto</h6></label>
                        <select name="tidproducto" class="form-control selectpicker" id="tidproducto" data-live-search="true">
                            @foreach ($productos as $producto)
                            <option value="{{$producto->idproducto}}_{{$producto->precio}}">{{$producto->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- div cantidad --> 
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-primary">        
                    <div class="form-group">
                        <label for="cantidad"><h6>Cantidad</h6></label>
                        <button type="button" class="btn btn-primary btn-sm" id="aumentar"><i class="fa fa-plus fa-fw"></i></button>
                        <button type="button" class="btn btn-primary btn-sm" id="disminuir"><i class="fa fa-minus fa-fw"></i></button>
                        <input type="number" disabled name="tcantidad" id="tcantidad" class="form-control text-center" placeholder="Cantidad">
                    </div>
                </div>
                <!-- div precio_venta --> 
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 text-primary">        
                    <div class="form-group">
                        <label for="precio_venta"><h6>Precio S/.</h6></label>
                        <input type="number" step="any" disabled name="tprecio_venta" id="tprecio_venta" class="form-control text-right" placeholder="">
                    </div>
                </div>
                <!-- div boton agregar --> 
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12 text-primary">        
                    <div class="form-group">
                        <label for="agregar"></label></br>
                        <button type="button" id="bt_add" class="btn btn-info btn-sm"><i class="far fa-plus-square fa-fw"></i></br> Agregar</button>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12" style="height:20px">

                </div>                   
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center" id="guardar">
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
        $('#aumentar').click(function(){
            aumentar();
        });
        $('#disminuir').click(function(){
            disminuir();
        });
    });

    var cont=0;
    total=0;
    pre=0;
    subtotal=[];
    $("#guardar").hide();

    $("#tidproducto").change(mostrarDatos);

    function mostrarDatos()
    {
        datProducto=document.getElementById('tidproducto').value.split('_');
        $("#tprecio_venta").val(datProducto[1]);
        $("#tcantidad").val(1);
        inicio=inicio-inicio+1;
    }

    function agregar() 
    {
        datProducto=document.getElementById('tidproducto').value.split('_');

        idproducto=datProducto[0];
        producto=$("#tidproducto option:selected").text();
        cantidad=$("#tcantidad").val();

        precio_venta=$("#tprecio_venta").val();

        if (idproducto!="" && cantidad!="" && cantidad>0 && precio_venta!="") {
            
            subtotal[cont]=(cantidad*precio_venta);
            total=total+subtotal[cont];

            pre=number_format(precio_venta,2);
            st=number_format(subtotal[cont],2);

            var fila='<tr class="selected" id="fila'+cont+'"><td class="text-center"><button type="button" class="" style="height:23px" onclick="eliminar('+cont+');"><i class="far fa-trash-alt" aria-hidden="true"></i></button></td><td class="text-left col-lg-4 col-md-4 col-sm-4 col-xs-12"><input type="hidden" name="idproducto[]" value="'+idproducto+'">'+producto+'</td><td class="text-center"><input type="hidden" name="cantidad[]" value="'+cantidad+'">'+cantidad+'</td><td class="text-right"><input type="hidden" name="precio_venta[]" value="'+precio_venta+'">'+pre+'</td><td class="text-right">'+st+'</td></tr>';

            cont++;
            limpiar();
            $("#total").html("S/. " + number_format(total,2));
            $("#monto_total").val(total);
            evaluar();
            $('#detalles').append(fila); 

        }
        else
        {
            alert("Error al ingresar el detalle de la venta, revise los datos del producto");
        }
    }
    
    /*function agregar() 
    {
        datosProducto=document.getElementById('pidproducto').value.split('_');
        
        idproducto=datosProducto[0];
        producto=$("#pidproducto option:selected").text();
        cantidad=$("#pcantidad").val();
        
        precio_venta=$("#pprecio_venta").val();
        stock=$("#pstock").val();

        if (idproducto!="" && cantidad!="" && cantidad>0 && precio_venta!="")
        {
            subtotal[cont]=(cantidad*precio_venta);
            total=total+subtotal[cont];

            pre=number_format(precio_venta,2);
            st=number_format(subtotal[cont],2);

            var fila='<tr class="selected" id="fila'+cont+'"><td class="text-center"><button type="button" class="" style="height:23px" onclick="eliminar('+cont+');"><i class="far fa-trash-alt" aria-hidden="true"></i></button></td><td class="text-left col-lg-4 col-md-4 col-sm-4 col-xs-12"><input type="hidden" name="idproducto[]" value="'+idproducto+'">'+producto+'</td><td class="text-center"><input type="hidden" name="cantidad[]" value="'+cantidad+'">'+cantidad+'</td><td class="text-right"><input type="hidden" name="precio_venta[]" value="'+precio_venta+'">'+pre+'</td><td class="text-right">'+st+'</td></tr>';
            
            cont++;
            limpiar();
            $("#total").html("S/. " + number_format(total,2));
            $("#monto_total").val(total);
            evaluar();
            $('#detalles').append(fila);   
        }
        else
        {
            alert("Error al ingresar el detalle de la venta, revise los datos del producto");
        }
    }*/

    function limpiar() 
    {
        $("#tcantidad").val("");       
        $("#tprecio_venta").val("");
    }

    function evaluar() 
    {
        if (total>0) 
        {
            $("#guardar").show(); 
        }    
        else
        {
            $("#guardar").hide();
        }
    }

    function eliminar(index) {
        total=total-subtotal[index];
        $("#total").html("S/. " + number_format(total,2));
        $("#monto_total").val(total);
        $("#fila" + index).remove();
        evaluar();
    }

    function number_format(amount, decimals) {

        amount += ''; // por si pasan un numero en vez de un string
        amount = parseFloat(amount.replace(/[^0-9\.]/g, '')); // elimino cualquier cosa que no sea numero o punto

        decimals = decimals || 0; // por si la variable no fue fue pasada

        // si no es un numero o es igual a cero retorno el mismo cero
        if (isNaN(amount) || amount === 0) 
            return parseFloat(0).toFixed(decimals);

        // si es mayor o menor que cero retorno el valor formateado como numero
        amount = '' + amount.toFixed(decimals);

        var amount_parts = amount.split('.'),
        regexp = /(\d+)(\d{3})/;

        while (regexp.test(amount_parts[0]))
            amount_parts[0] = amount_parts[0].replace(regexp, '$1' + ',' + '$2');

        return amount_parts.join('.');
    }

    var inicio = 1; //se inicializa una variable en 0

    function aumentar(){ // se crean la funcion y se agrega al evento onclick en en la etiqueta button con id aumentar

        var cantidad = document.getElementById('tcantidad').value = ++inicio; //se obtiene el valor del input, y se incrementa en 1 el valor que tenga.
    }

    function disminuir(){ // se crean la funcion y se agrega al evento onclick en en la etiqueta button con id disminuir

        //var cantidad = document.getElementById('cantidad').value = --inicio; //se obtiene el valor del input, y se decrementa en 1 el valor que tenga.
        if (inicio > 1) {
            var cantidad = document.getElementById('tcantidad').value = --inicio;
        }
    }


</script>
@endpush

@endsection