{!! Form::open(array('url'=>'ventas/pedido','method'=>'GET','autocomplete'=>'off', 'role'=>'search'))!!}

<div class="form-group">
    <div class="input-group">
        <input type="text" class="form-control" name="searchText" placeholder="Buscar Mesa" value="{{$searchText}}">
        <span class="input-group-btn">
            <button type="submit" class="btn btn-primary"><i class="fas fa-search fa-fw"></i> Buscar Mesa</button>
        </span>
    </div>
</div>

{{Form::close()}}