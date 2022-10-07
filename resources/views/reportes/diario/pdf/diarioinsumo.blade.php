@extends ('layouts.pdf')

@section('reporte')
    <h5>REPORTES DEL DIA : {{$fech}}</h5>

    <div style="height:5px">
        
    </div>
    <div class="text-center">
        <h6>INSUMOS INGRESADOS :</h6>
    </div>
    <table class="table table-sm" style="font-size:10px">
        <thead class="text-left text-white bg-dark">
            <tr>
                <th>N</th>
                <th>Insumo</th>
                <th>Cant. Ant.</th>
                <th>Cant. Ing.</th>
                <th>Cant. Act.</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($insumos as $insumo)
            <tr>
                <td class="text-left">{{ $n3++ }}</td>
                <td class="text-left">{{ $insumo->nombre }}</td>
                <td class="text-right">{{ $insumo->anterior }}</td>
                <td class="text-right">{{ $insumo->ingreso }}</td>
                <td class="text-right">{{ $insumo->actual }}</td>                    
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
            </tr>
        </tfoot>
    </table>

    <div class="text-center">
        <h6>INSUMOS TOTALES</h6>
    </div>
    <table class="table table-sm" style="font-size:10px">
        <thead class="text-left text-white bg-dark">
            <tr>
                <th>N</th>
                <th>Insumo</th>
                <th>Cant. Ant.</th>
                <th>Cant. Ing.</th>
                <th>Cant. Act.</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($tinsumos as $insumo)
            <tr>
                <td class="text-left">{{ $n3++ }}</td>
                <td class="text-left">{{ $insumo->nombre }}</td>
                <td class="text-right">{{ $insumo->anterior }}</td>
                <td class="text-right">{{ $insumo->ingreso }}</td>
                <td class="text-right">{{ $insumo->actual }}</td>                    
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
            </tr>
        </tfoot>
    </table>

@endsection