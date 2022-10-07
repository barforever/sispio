<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="es" xml:lang="es">

<body>
    <style type="text/css">
        .table  {border-collapse:collapse;border-spacing:0;}
        .table td{font-family:Arial, sans-serif;font-size:10px;padding:5px;border-bottom:solid;border-width:0.5px;overflow:hidden;word-break:normal;border-color:#525659;}
        .table th{font-family:Arial, sans-serif;font-size:10px;font-weight:normal;padding:5px;border-style:solid;border-width:1px;overflow:hidden;word-break:normal;border-color:black;}
        .table .pie{text-align:center;vertical-align:top;font-size:14px;font-weight:normal;border-width:0px}
        .table .right{text-align:right;vertical-align:top}
        .table .center{text-align:center;vertical-align:top}
        .table .cabecera{font-weight:bold;background-color:#000000;color:#ffffff;border-color:#ffffff;text-align:center;vertical-align:top}
        .table .left{text-align:left;vertical-align:top}
    </style>

    <h3 style="font-size:16px;font-family:Arial, sans-serif">REPORTES DEL DIA : {{$fech}}</h3>

    <div style="font-size:13px;font-family:Arial,sans-serif;text-align:center">
        <h4>VENTAS</h4>
    </div>
    <table class="table" style="font-size:10px;font-family:Arial, sans-serif; width: 100%">
            <tr>
                <th class="cabecera">N</th>
                <th class="cabecera">Fecha</th>
                <th class="cabecera">Cliente</th>
                <th class="cabecera">Comanda</th>
                <th class="cabecera">Comprob.</th>
                <th class="cabecera">Mozo</th>
                <th class="cabecera">Total</th>
            </tr>
        @foreach ($ventas as $ven)
            <tr>
                <td class="center">{{ $n++ }}</td>
                <td class="left">{{ $ven->fecha }}</td>
                <td class="left">{{ $ven->nombre }}</td>
                <td class="center">{{ $ven->num_comanda }}</td>
                <td class="left">{{ $ven->tipo_comprobante.$ven->serie_comprobante.'-'.str_pad($ven->num_comprobante,5,"0",STR_PAD_LEFT) }}</td>
                <td class="center">{{ $ven->nickname }}</td>
                <td class="right">s/. {{ number_format((float)$ven->monto_total, 2, '.', '') }}</td>                     
            </tr>                    
        @endforeach
            <tr>
                <th class="pie"></th>
                <th class="pie"></th>
                <th class="pie"></th>
                <th class="pie"></th>
                <th class="pie"></th>
                <th class="pie">Total</strong></th>
                <th class="pie" style="text-align:right;font-weight:bold">s/. {{ number_format((float)$vtotal->monto_total, 2, '.', '') }}</th>
            </tr>
    </table>

    <div style="page-break-after:always;">
    
    </div>

    <h3 style="font-size:16px;font-family:Arial, sans-serif">REPORTES DEL DIA : {{$fech}}</h3>

    <div style="font-size:13px;font-family:Arial,sans-serif;text-align:center">
        <h4>COMPRAS</h4>
    </div>
    <table class="table" style="font-size:10px;font-family:Arial, sans-serif; width: 100%">
            <tr>
                <th class="cabecera">N</th>
                <th class="cabecera">Fecha</th>
                <th class="cabecera">Proveedor</th>
                <th class="cabecera">Documento</th>
                <th class="cabecera">Comprob.</th>
                <th class="cabecera">Total</th>
            </tr>
        @foreach ($compras as $compra)
            <tr>
                <td class="center">{{ $n2++ }}</td>
                <td class="left">{{ $compra->fecha }}</td>
                <td class="left">{{ $compra->nombre }}</td>
                <td class="left">{{ $compra->tipo_documento.'-'.$compra->num_documento }}</td>
                <td class="left">{{ $compra->tipo_comprobante.$compra->serie_comprobante.'-'.str_pad($compra->num_comprobante,5,"0",STR_PAD_LEFT) }}</td>
                <td class="right">s/. {{ number_format((float)$compra->monto_total, 2, '.', '') }}</td>                     
            </tr>                    
        @endforeach
            <tr>
                <th class="pie"></th>
                <th class="pie"></th>
                <th class="pie"></th>
                <th class="pie"></th>
                <th class="pie">Total</strong></th>
                <th class="pie" style="text-align:right;font-weight:bold">s/. {{ number_format((float)$ctotal->monto_total, 2, '.', '') }}</th>
            </tr>
    </table>    

    <div style="page-break-after:always;">
    
    </div>

    <h3 style="font-size:16px;font-family:Arial, sans-serif">REPORTES DEL DIA : {{$fech}}</h3>

    <div style="font-size:13px;font-family:Arial,sans-serif;text-align:center">
        <h4>INSUMOS</h4>
    </div>
    <table class="table" style="font-size:10px;font-family:Arial, sans-serif; width: 100%">
            <tr>
                <th class="cabecera">N</th>
                <th class="cabecera">Fecha</th>
                <th class="cabecera">Proveedor</th>
                <th class="cabecera">Documento</th>
                <th class="cabecera">Comprob.</th>
                <th class="cabecera">Total</th>
            </tr>
        @foreach ($insumos as $insumo)
            <tr>
                <td class="center">{{ $n3++ }}</td>
                <td class="left">{{ $insumo->nombre }}</td>               
            </tr>                    
        @endforeach
            <tr>
                <th class="pie"></th>
                <th class="pie"></th>
                <th class="pie"></th>
                <th class="pie"></th>
                <th class="pie">Total</strong></th>
                <th class="pie" style="text-align:right;font-weight:bold">s/. </th>
            </tr>
    </table>    
</body>