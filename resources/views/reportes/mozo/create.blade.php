@extends ('layouts.admin') <!--traemos la plantilla-->

@section ('contenido') <!--abrimos la seccion donde estara nuestro contenido dinamico donde 'contenido' es el que definimos en la plantilla-->
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h3>Nueva Venta</h3>
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
            {!!Form::open(array('url'=>'ventas/venta','method'=>'POST','autocomplete'=>'off'))!!}
            {{Form::token()}}
    
    <div class="row" style="width:100%">
        <!-- div idmozo -->              
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="form-group">
                <label for="mozo">Mozo</label>
                <select name="idmozo" id="idmozo" class="form-control selectpicker" data-live-search="true">
                    @foreach ($mozos as $mozo)
                    <option value="{{$mozo->idmozo}}">{{$mozo->mozo}}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <!-- div num_venta -->
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">        
            <div class="form-group">
                <label for="num_venta">Numero de Venta</label>
                <input type="text" name="num_venta" required value="{{old('num_venta')}}" class="form-control" placeholder="Numero de venta">
            </div>
        </div>
        <!-- div mesa -->
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">        
            <div class="form-group">
                <label>Mesa</label>
                <select name="mesa" class="form-control">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5">5</option>
                    <option value="6">6</option>
                    <option value="7">7</option>
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option value="12">12</option>
                    <option value="13">13</option>
                    <option value="14">14</option>
                    <option value="15">15</option>
                    <option value="16">16</option>
                    <option value="17">17</option>
                    <option value="18">18</option>
                    <option value="19">19</option>
                    <option value="20">20</option>
                    <option value="21">21</option>
                    <option value="22">22</option>
                    <option value="23">23</option>
                    <option value="24">24</option>
                </select>  
            </div>
        </div>              
    </div>
    
    <div class="row">
        
                <!-- div producto --> 
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">        
                    <div class="form-group">
                        <label>Producto</label>
                        <select name="pidproducto" class="form-control selectpicker" id="pidproducto" data-live-search="true">
                            @foreach ($productos as $producto)
                            <option value="{{$producto->idproducto}}_{{$producto->stock}}_{{$producto->precio}}">{{$producto->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <!-- div cantidad --> 
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">        
                    <div class="form-group">
                        <label for="cantidad">Cantidad</label>
                        <input type="number" name="pcantidad" id="pcantidad" class="form-control" placeholder="Cantidad">
                    </div>
                </div>
                <!-- div stock --> 
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">        
                    <div class="form-group">
                        <label for="stock">Stock</label>
                        <input type="number" disabled name="pstock" id="pstock" class="form-control" placeholder="Stock">
                    </div>
                </div>
                <!-- div precio_venta --> 
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">        
                    <div class="form-group">
                        <label for="precio_venta">Precio Venta</label>
                        <input type="number" disabled name="pprecio_venta" id="pprecio_venta" class="form-control" placeholder="P.venta">
                    </div>
                </div>
                <!-- div boton agregar --> 
                <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">        
                    <div class="form-group">
                        <button type="button" id="bt_add" class="btn btn-primary">Agregar</button>
                    </div>
                </div>
                <!-- div detalles --> 
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">        
                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                        <thead style="background-color:#A9D0F5">
                            <th>Opciones</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Venta</th>
                            <th>Sub Total</th>
                        </thead>
                        <tfoot>
                            <th>TOTAL</th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th><h4 id="total">S/. 0.00</h4><input type="hidden" name="monto_total" id="monto_total"></th>
                        </tfoot>
                    </table>            
                </div>           
         

        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="guardar">        
            <div class="form-group">
                <input name="_token" value="{{ csrf_token() }}" type="hidden">
                <button class="btn btn-primary" type="submit">Guardar</button>
                <button class="btn btn-danger" type="reset">Cancelar</button>
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
    subtotal=[];
    $("#guardar").hide();
    $("#pidproducto").change(mostrarValores);

    function mostrarValores()
    {
        datosProducto=document.getElementById('pidproducto').value.split('_');
        $("#pstock").val(datosProducto[1]);
        $("#pprecio_venta").val(datosProducto[2]);
    }

    function agregar() 
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

            var fila='<tr class="selected" id="fila'+cont+'"><td><button type="button" class="btn btn-warning" onclick="eliminar('+cont+');">x</button></td><td><input type="hidden" name="idproducto[]" value="'+idproducto+'">'+producto+'</td><td><input type="number" name="cantidad[]" value="'+cantidad+'"></td><td><input type="number" name="precio_venta[]" value="'+precio_venta+'"></td><td>'+subtotal[cont]+'</td></tr>';
            
            cont++;
            limpiar();
            $("#total").html("S/. " + total);
            $("#monto_total").val(total);
            evaluar();
            $('#detalles').append(fila);   
        }
        else
        {
            alert("Error al ingresar el detalle de la venta, revise los datos del producto");
        }
    }

    function limpiar() 
    {
        $("#pcantidad").val("");
        $("#pstock").val("");       
        $("#pprecio_venta").val("");
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
        $("#total").html("S/. " + total);
        $("#monto_total").val(total);
        $("#fila" + index).remove();
        evaluar();
    }
    
 
</script>
@endpush

@endsection