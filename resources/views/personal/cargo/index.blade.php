@extends ('layouts.admin') <!--traemos la plantilla-->

@section ('contenido') <!--abrimos la seccion donde estara nuestro contenido dinamico donde 'contenido' es el que definimos en la plantilla-->
    <div class="row row ml-1 mr-1 p-2 border bg-light">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
            <h4>CARGOS DE PERSONAL</h4>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <a href="cargo/create"><button class="btn btn-success float-right"><i class="far fa-plus-square fa-fw"></i> Nuevo</button></a>
        </div>
    </div>

    <div class="row" style="height:10px">
        
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover table-sm">
                    <thead class="text-center text-black" style="background-color:#f8c819">
                        <th>Id</th>
                        <th>Nombre</th>
                        <th>Sueldo</th>
                        <th>Opciones</th>
                    </thead>
                    @foreach ($cargos as $car)
                    <tr>
                        <td class="text-center">{{ $car->idcargo }}</td>
                        <td class="text-center">{{ $car->nombre }}</td>
                        <td class="text-center">S/. {{ $car->sueldo }}</td>                       
                        <td class="text-center">
                            <a href="{{URL::action('CargoController@edit',$car->idcargo)}}"><button class="btn btn-info btn-sm"><i class="fas fa-pencil-alt fa-fw"></i> Editar</button></a>
                            <a href="" data-target="#modal-delete-{{$car->idcargo}}" data-toggle="modal"><button class="btn btn-danger btn-sm"><i class="far fa-trash-alt fa-fw"></i> Eliminar</button></a>                                               
                        </td>
                    </tr>
                    @include('personal.cargo.modal')
                    @endforeach
                </table>
            </div>
            {{$cargos->render()}}
        </div>
    </div>
@endsection