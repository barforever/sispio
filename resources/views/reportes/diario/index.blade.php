@extends ('layouts.admin') <!--traemos la plantilla-->

@section ('contenido') <!--abrimos la seccion donde estara nuestro contenido dinamico donde 'contenido' es el que definimos en la plantilla-->
    <div class="row" style="height:20px">
        
    </div>
    <div class="row">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">            
            
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">            
            @include('reportes.diario.search')
        </div>
    </div>
    <div class="row" style="height:">
        
    </div>
    <div class="row ml-1 mr-1 p-2 border bg-light">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <h4>REPORTES DEL DIA : <nom>{{$searchText}}</nom></h4>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
            @if ($searchText)
            <a href="{{URL::action('ReporteController@reporte',$searchText)}}" target="_blank"><button class="btn btn-info">CIERRE TOTAL</button></a>
            @else
            <a href="diario/wow/{{$searchText}}"><button class="btn btn-info" disabled="disabled">CIERRE TOTAL</button></a>
            @endif
        </div>
    </div>
    <div class="row" style="height:10px">
        
    </div>
    <div class="row mr-1 ml-1 p-3 border">
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
            <div class="row m-3 border align-items-center bg-success">                                 
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-2">
                    <h5 class="text-center text-white">VENTAS</h5>
                    <h5 class="text-center text-white">S/. {{number_format((float)$vtotal->monto_total, 2, '.', '')}}</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">                                  
            <div class="row m-3 border align-items-center bg-danger">                                 
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-2">
                    <h5 class="text-center text-white">COMPRAS</h5>
                    <h5 class="text-center text-white">S/. {{number_format((float)$ctotal->monto_total, 2, '.', '')}}</h5>
                </div>
            </div>
        </div>
        <div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">                                  
            <div class="row m-3 border align-items-center bg-primary">                                 
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12 p-2">
                    <h5 class="text-center text-white">ENTREGAR</h5>
                    <h5 class="text-center text-white">S/. {{number_format((float)$vtotal->monto_total-$ctotal->monto_total, 2, '.', '')}}</h5>
                </div>
            </div>
        </div>
    </div>
    <div class="row" style="height:10px">
        
    </div>
    <div class="row mr-1 ml-1 pt-3 border">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="row m-1">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-left">
                    <div class="form-group text-left">
                        <h5>VENTAS</h5>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                    <div class="form-group text-right">
                        <h5>TOTAL: S/. {{number_format((float)$vtotal->monto_total, 2, '.', '')}}</h5>
                    </div>
                </div>
                <div class="table-responsive small">
                    <table class="table table-striped table-bordered table-condensed table-hover table-sm">
                        <thead class="text-center text-dark bg-light">
                            <th>N</th>
                            <th>FECHA</th>
                            <th>COMANDA</th>
                            <th>COMPROB</th>
                            <th>TOTAL</th>
                            <th>OPC.</th>
                        </thead>
                        @foreach ($ventas as $ven)
                        <tr>
                            <td class="text-center">{{ $n++ }}</td>
                            <td class="text-center">{{ date('d-m-Y',strtotime($ven->fecha)) }}</td>
                            <td class="text-center">{{ $ven->num_comanda }}</td>
                            <td class="text-center">{{ $ven->tipo_comprobante.$ven->serie_comprobante.'-'.str_pad($ven->num_comprobante,5,"0",STR_PAD_LEFT) }}</td>
                            <td class="text-center">S/. {{ number_format((float)$ven->monto_total, 2, '.', '') }}</td>
                            <td class="text-center">
                                <a href="{{URL::action('ReporteController@show',$ven->idventa)}}"><button class="btn btn-primary btn-sm">Detalles</button></a>
                            </td>                        
                        </tr>                            
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="row m-1">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-left">
                    <div class="form-group text-left">
                        <h5>COMPRAS</h5>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                    <div class="form-group text-right">
                        <h5>TOTAL: S/. {{number_format((float)$ctotal->monto_total, 2, '.', '')}}</h5>
                    </div>
                </div>
                <div class="table-responsive small">
                    <table class="table table-striped table-bordered table-condensed table-hover table-sm">
                        <thead class="text-center text-dark bg-light">
                            <th>N</th>
                            <th>FECHA</th>
                            <th>PROVEEDOR</th>
                            <th>TOTAL</th>
                            <th>OPC.</th>
                        </thead>
                        @foreach ($compras as $com)
                        <tr>
                            <td class="text-center">{{ $n++ }}</td>
                            <td class="text-center">{{ date('d-m-Y',strtotime($com->fecha)) }}</td>
                            <td class="text-left">{{ $com->nombre }}</td>
                            <td class="text-right">S/. {{ number_format((float)$com->monto_total, 2, '.', '') }}</td>
                            <td class="text-center">
                                <a href="{{URL::action('ReporteController@show',$com->idingreso)}}"><button class="btn btn-primary btn-sm">Detalles</button></a>
                            </td>                        
                        </tr>                                
                        @endforeach
                    </table>
                </div>
            </div>
        </div>
    </div>


    <div class="row" style="height:10px">
        
    </div>
    <div class="row mr-1 ml-1 pt-3 border">
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="row m-1">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-left">
                    <div class="form-group text-left">
                        <h5>INSUMOS TOTALES</h5>
                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                    <div class="form-group text-right">
                        
                    </div>
                </div>
                <div class="table-responsive small">
                    <table class="table table-striped table-bordered table-condensed table-hover table-sm">
                        <thead class="text-center text-dark bg-light">
                            <th>N</th>
                            <th>Insumo</th>
                            <th>Cant. Ant.</th>
                            <th>Cant. Ing.</th>
                            <th>Cant. Act.</th>
                    </thead>
                    @foreach ($tinsumos as $insumo)
                        <tr>
                            <td class="text-left">{{ $n++ }}</td>
                            <td class="text-left">{{ $insumo->nombre }}</td>
                            <td class="text-left">{{ $insumo->anterior }}</td>
                            <td class="text-left">{{ $insumo->ingreso }}</td>
                            <td class="text-left">{{ $insumo->actual }}</td>                    
                        </tr>                    
                    @endforeach
                </table>
                </div>
            </div>
        </div>
        <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
            <div class="row m-1">
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-left">
                    <div class="form-group text-left">

                    </div>
                </div>
                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12 text-right">
                    <div class="form-group text-right">
                        
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection