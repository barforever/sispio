{!! Form::open(array('url'=>'almacen/producto','method'=>'GET','autocomplete'=>'off', 'role'=>'search'))!!}

<div class="form-group">
    <div class="input-group">
        <input type="text" class="form-control" name="searchText" placeholder="Buscar..." value="{{$searchText}}">
        <span class="input-group-btn">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search fa-fw"></i> Buscar Producto</button>
        </span>
    </div>
</div>

{{Form::close()}}