@extends ('layouts.admin') <!--traemos la plantilla-->

@section ('contenido')
    <div class="row" style="height:50px">

    </div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <!-- div mozo-->
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="form-group">
                    <label for="mozo">Mozo</label>
                    <p>{{ $venta->mozo }}</p>                
                    </div>
                </div>
                <!-- div num_venta -->              
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="form-group">
                    <label for="num_venta">Numero de Venta</label>
                    <p>{{ $venta->num_venta }}</p>                
                    </div>
                </div>
                <!-- div mesa -->              
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
                    <div class="form-group">
                    <label for="mesa">Mesa</label>
                    <p>{{ $venta->mesa }}</p>                
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" style="height:10px">
        
    </div>

     <!-- div detalles --> 
    
        <div class="card.bg-light text-dark">
            <div class="body">
                <div class="row">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">        
                    <table id="detalles" class="table table-striped table-bordered table-condensed table-hover">
                        <thead style="background-color:#A9D0F5">
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Precio Venta</th>
                            <th>Sub Total</th>
                        </thead>
                        <tfoot>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th><h4 id="total" class="text-right">Total: S/. {{ $venta->monto_total }}</h4></th>
                        </tfoot>
                        <tbody>
                            @foreach ($detalles as $det)
                            <tr>
                                <td>{{ $det->producto }}</td>
                                <td><p class="text-center">{{ $det->cantidad }}</p></td>
                                <td><p class="text-right">S/. {{ $det->precio_venta }}</p></td>
                                <td><p class="text-right">S/. {{ $det->cantidad*$det->precio_venta }}</p></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>            
                </div>
                </div>
            </div>
        </div>
 
     <!--</div>-->
@endsection