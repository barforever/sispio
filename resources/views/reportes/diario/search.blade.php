{!! Form::open(array('url'=>'reportes/diario','method'=>'GET','autocomplete'=>'off', 'role'=>'search'))!!}

<div class="form-group">
    <div class="input-group">
        <input type="date" class="form-control" name="searchText" value="{{$searchText}}">
        <span class="input-group-btn">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search fa-fw"></i> Buscar Reporte</button>
        </span>
    </div>
</div>

{{Form::close()}}