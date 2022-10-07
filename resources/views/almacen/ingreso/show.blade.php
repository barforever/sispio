@extends ('layouts.admin') <!--traemos la plantilla-->

@section ('contenido')
    <div class="row ml-1 mr-1 p-2 border bg-light">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
            <h4>DETALLE DE INGRESO: </br><act>{{$ingreso->tipo_comprobante.$ingreso->serie_comprobante.'-'.str_pad($ingreso->num_comprobante,5,"0",STR_PAD_LEFT)}}</act></h4>
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
            <div class="row p-1 m-1 border align-items-center">
                <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
                    <div class="form-group">
                        <h5 class="text-left">POLLOS A LA BRASA</h5>
                        <h5 class="text-left">"El Pollito Pio"</h5>
                        <h6 class="text-left">Jr. San Cristobal 272 - Int. B - 2 Nivel</h6>
                        <h6 class="text-left">Yanacancha - Pasco - Pasco</h6>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 border">
                    <div class="form-group">                          
                        <h5 class="text-center">INGRESO</h5>
                        <h5 class="text-center">RUC: 20000000000</h5>
                        <h5 class="text-center">INGRESO N° {{str_pad($ingreso->idingreso,5,"0",STR_PAD_LEFT)}}</h5>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="row p-1 m-1 border">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="form-group row">
                        <label for="fecha" class="col-lg-2 col-md-2 col-sm-2 col-xs-12 col-form-label font-weight-bold">Fecha de Ingreso :</label>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                            <input type="text" readonly class="form-control-plaintext" id="fecha" value="{{ date('d-m-Y',strtotime($ingreso->fecha))}}">
                        </div>
                        <label for="fecha" class="col-lg-2 col-md-2 col-sm-2 col-xs-12 col-form-label font-weight-bold">Proveedor :</label>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                            <input type="text" readonly class="form-control-plaintext" id="fecha" value="{{ $ingreso->nombre }}">
                        </div>
                        <label for="fecha" class="col-lg-2 col-md-2 col-sm-2 col-xs-12 col-form-label font-weight-bold">{{ $ingreso->tipo_documento }} :</label>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                            <input type="text" readonly class="form-control-plaintext" id="fecha" value="{{ $ingreso->num_documento }}">
                        </div>
                        <label for="fecha" class="col-lg-2 col-md-2 col-sm-2 col-xs-12 col-form-label font-weight-bold">Comprobante :</label>
                        <div class="col-lg-9 col-md-9 col-sm-9 col-xs-12">
                            <input type="text" readonly class="form-control-plaintext" id="fecha" value="{{ $ingreso->tipo_comprobante.$ingreso->serie_comprobante.'-'.str_pad($ingreso->num_comprobante,5,"0",STR_PAD_LEFT) }}">
                        </div>
                    </div>                    
                </div>
            </div>                
        </div>

        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 mr-2">
                <div class="table-responsive-sm m-1">
                    <table class="table table-bordered table-condensed table-hover table-sm">
                        <thead class="text-center text-black thead-light">
                            <tr>    
                                <th>N</th>
                                <th>Insumo</th>
                                <th>Cant</th>
                                <th>U/M</th>
                                <th>P.Compra</th>
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
                                <th>Total</th>
                                <th class="text-right">S/.{{ number_format((float)$ingreso->monto_total , 2, '.', '') }}</th>
                            </tr>
                        </tfoot>
                        <tbody>
                        @foreach ($detalleingreso as $di)
                            <tr>
                                <td class="text-center">{{ $n++ }}</td>
                                <td class="text-left">{{ $di->nombre }}</td>
                                <td class="text-center">{{ $di->cantidad }}</td>                       
                                <td class="text-right">{{ $di->unidad_medida }}</td>                      
                                <td class="text-right">S/.{{ number_format((float)$di->precio_compra, 2, '.', '') }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>                
        </div>
    </div>

@endsection