{!! Form::open(array('url'=>'almacen/ingreso','method'=>'GET','autocomplete'=>'off', 'role'=>'search'))!!}

<div class="form-group">
    <div class="input-group">
        <input type="text" class="form-control" name="searchText" placeholder="Buscar Numero Comprobante" value="{{$searchText}}">
        <span class="input-group-btn">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search fa-fw"></i> Buscar Compra</button>
        </span>
    </div>
</div>

{{Form::close()}}