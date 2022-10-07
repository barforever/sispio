@extends ('layouts.pdf')

@section('reporte')
    <h5>REPORTES DEL DIA : {{$fech}}</h5>

    <div style="height:5px">
        
    </div>
    <div class="text-center">
        <h6>VENTAS</h6>
    </div>
    <table class="table table-sm" style="font-size:10px">
        <thead class="text-left text-white bg-dark">
            <tr>
                <th>N</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Comanda</th>
                <th>Comprob.</th>
                <th>Mozo</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($ventas as $ven)
            <tr>
                <td class="text-left">{{ $n++ }}</td>
                <td class="text-left">{{ $ven->fecha }}</td>
                <td class="text-left">{{ $ven->nombre }}</td>
                <td class="text-center">{{ $ven->num_comanda }}</td>
                <td class="text-left">{{ $ven->tipo_comprobante.$ven->serie_comprobante.'-'.str_pad($ven->num_comprobante,5,"0",STR_PAD_LEFT) }}</td>
                <td class="text-left">{{ $ven->nickname }}</td>
                <td class="text-right">s/. {{ number_format((float)$ven->monto_total, 2, '.', '') }}</td>                     
            </tr>                    
        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th class="text-left"><h5><strong>Total</strong></h5></th>
                <th class="text-right"><h5><strong>s/. {{ number_format((float)$vtotal->monto_total, 2, '.', '') }}</strong></h5></th>
            </tr>
        </tfoot>
    </table>

    <div style="page-break-after:always;">
    
    </div>

    <div class="text-center">
        <h6>COMPRAS</h6>
    </div>
    <table class="table table-sm" style="font-size:10px">
        <thead class="text-left text-white bg-dark">
            <tr>
                <th>N</th>
                <th>Fecha</th>
                <th>Proveedor</th>
                <th>Documento</th>
                <th>Comprob.</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($compras as $compra)
            <tr>
                <td class="text-left">{{ $n2++ }}</td>
                <td class="text-left">{{ $compra->fecha }}</td>
                <td class="text-left">{{ $compra->nombre }}</td>
                <td class="text-left">{{ $compra->tipo_documento.'-'.$compra->num_documento }}</td>
                <td class="text-left">{{ $compra->tipo_comprobante.$compra->serie_comprobante.'-'.str_pad($compra->num_comprobante,5,"0",STR_PAD_LEFT) }}</td>
                <td class="text-right">s/. {{ number_format((float)$compra->monto_total, 2, '.', '') }}</td>                     
            </tr>                    
        @endforeach
        </tbody>
        <tfoot>
            <tr>
                <th></th>
                <th></th>
                <th></th>
                <th></th>
                <th class="text-left"><h5><strong>Total</strong></h5></th>
                <th class="text-right"><h5><strong>s/. {{ number_format((float)$ctotal->monto_total, 2, '.', '') }}</strong></h5></th>
            </tr>
        </tfoot>
    </table>

@endsection