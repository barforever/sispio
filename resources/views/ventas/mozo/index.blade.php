@extends ('layouts.admin') <!--traemos la plantilla-->

@section ('contenido') <!--abrimos la seccion donde estara nuestro contenido dinamico donde 'contenido' es el que definimos en la plantilla-->
    <div class="row">
        <div class="col-lg-8 col-md-8 col-sm-8 col-xs-12">
            <h3>Listado Mozos <a href="mozo/create"><button class="btn btn-success">Nuevo</button></a></h3>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover">
                    <thead>
                        <th>Id</th>
                        <th>Nick</th>
                        <th>Nombres</th>
                        <th>Apellidos</th>
                        <th>Telefono</th>
                        <th>Opciones</th>
                    </thead>
                    @foreach ($mozos as $mo)
                    <tr>
                        <td>{{ $mo->idmozo }}</td>
                        <td>{{ $mo->mozo }}</td>
                        <td>{{ $mo->nombres }}</td>
                        <td>{{ $mo->apellidos }}</td>
                        <td>{{ $mo->telefono }}</td>
                        <td>
                            <a href="{{URL::action('MozoController@edit',$mo->idmozo)}}"><button class="btn btn-info">Editar</button></a>
                            <a href="" data-target="#modal-delete-{{$mo->idmozo}}" data-toggle="modal"><button class="btn btn-danger">Eliminar</button></a>
                        </td>
                    </tr>
                    @include('ventas.mozo.modal')
                    @endforeach
                </table>
            </div>
            {{$mozos->render()}}
        </div>
    </div>

@endsection