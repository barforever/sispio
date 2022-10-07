@extends ('layouts.admin') <!--traemos la plantilla-->

@section ('contenido') <!--abrimos la seccion donde estara nuestro contenido dinamico donde 'contenido' es el que definimos en la plantilla-->
    <div class="row ml-1 mr-1 p-2 border bg-light">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
            <h4>COBRAR MESA: <act>{{$pedido->num_mesa}}</act></h4>
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
    {!!Form::open(array('url'=>'ventas/venta','method'=>'POST','autocomplete'=>'off'))!!}
    {{Form::token()}}
    <div class="row ml-1 mr-1 p-1 border">
        <div class="col-lg-7 col-md-7 col-sm-7 col-xs-12">
            <div class="row p-1">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <label><h6>Cliente:</h6></label>
                        <select name="idcliente" class="form-control selectpicker" data-live-search="true">
                            @foreach ($clientes as $cliente)
                                <option value="{{$cliente->idpersona}}">{{$cliente->nombre}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label><h6>Tipo de Comprobante:</h6></label>
                        <select name="ptipo_comprobante" class="form-control" id="ptipo_comprobante">
                            <option value="" selected></option>
                            <option value="NV_01_{{str_pad($numnv->num_comprobante+1,6,"0",STR_PAD_LEFT)}}">NOTA DE VENTA</option>
                            <option value="B_02_{{str_pad($numb->num_comprobante+1,6,"0",STR_PAD_LEFT)}}">BOLETA</option>
                            <option value="F_03_{{str_pad($numf->num_comprobante+1,6,"0",STR_PAD_LEFT)}}">FACTURA</option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                        <label for="pserie_comprobante"><h6>Serie:</h6></label>
                        <input type="text" name="pserie_comprobante" disabled id="pserie_comprobante" class="form-control" placeholder="Serie">
                    </div>
                </div>
                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="form-group">
                        <label for="num_comprobante"><h6>Numero:</h6></label>
                        <input type="text" name="num_comprobante" id="num_comprobante" class="form-control" placeholder="Numero">
                        <input type="hidden" name="tipo_comprobante" id="tipo_comprobante">
                        <input type="hidden" name="serie_comprobante" id="serie_comprobante">
                        <input type="hidden" name="idpedido" value="{{ $pedido->idpedido }}">
                        <input type="hidden" name="monto_total" value="{{ $total->monto_total }}">                       
                    </div>
                </div>                
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 text-center">   
                    <div class="form-group">
                        <button class="btn btn-primary" type="submit"><i class="far fa-save fa-fw"></i> Guardar</button>
                        <button class="btn btn-danger" type="reset"><i class="far fa-window-close fa-fw"></i> Cancelar</button>
                    </div>
                    {!!Form::close()!!}
                </div>
            </div>
        </div>
        <div class="col-lg-5 col-md-5 col-sm-5 col-xs-12">
            <div class="row p-1 border-left">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group">
                        <h5 class="text-center">DETALLES DE LA VENTA</h5>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label for="fecha"><h6>Fecha:</h6></label>
                        <p name="fecha" class="form-control-static">{{ date('Y-m-d', strtotime($pedido->fecha)) }}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label for="num_mesa"><h6>Mesa:</h6></label>
                        <p name="num_mesa" class="form-control-static">{{ $pedido->num_mesa }}</p>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="form-group">
                        <label for="mozo"><h6>Mozo:</h6></label>
                        <p name="mozo" class="form-control-static">{{ $pedido->nickname }}</p>
                    </div>
                </div>            
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="table-responsive-sm" style="font-size:12px">
                        <table class="table table-condensed table-hover table-sm">
                            <thead class="text-center text-black thead-light">
                                <tr>    
                                    <th>N</th>
                                    <th>Producto</th>
                                    <th>Cant</th>
                                    <th>P.Unit</th>
                                    <th>P.Venta</th>
                                </tr>
                            </thead>
                            <tfoot class="text-center text-black">
                                <tr>    
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>S.Total</th>
                                    <th class="text-right">S/.{{ number_format((float)$st, 2, '.', '') }}</th>
                                </tr>
                                <tr>    
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>IGV</th>
                                    <th class="text-right">S/.{{ number_format((float)$igv2, 2, '.', '') }}</th>
                                </tr>
                                <tr>    
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th class="text-center text-danger" style="font-size:16px">Total</th>
                                    <th class="text-right text-danger"  style="font-size:16px">S/.{{ number_format((float)$total->monto_total , 2, '.', '') }}</th>
                                </tr>
                            </tfoot>
                            <tbody>
                            @foreach ($detallepedido as $dp)
                                <tr>
                                    <td class="text-center">{{ $n++ }}</td>
                                    <td class="text-left">{{ $dp->nombre }}</td>
                                    <td class="text-center">{{ $dp->cantidad }}</td>                       
                                    <td class="text-right">S/.{{ number_format((float)$dp->precio, 2, '.', '') }}</td>                      
                                    <td class="text-right">S/.{{ number_format((float)$dp->precio_venta*$dp->cantidad, 2, '.', '') }}</td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@push('scripts')
<script>
    $('#ptipo_comprobante').change(mostrarSerie);

    function mostrarSerie() 
    {
        datosComprobante=document.getElementById('ptipo_comprobante').value.split('_');
        $("#tipo_comprobante").val(datosComprobante[0]);
        $("#pserie_comprobante").val(datosComprobante[1]);
        $("#serie_comprobante").val(datosComprobante[1]);
        $("#num_comprobante").val(datosComprobante[2]);
    }
</script>
@endpush     
@endsection