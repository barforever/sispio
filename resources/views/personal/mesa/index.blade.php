@extends ('layouts.admin') <!--traemos la plantilla-->

@section ('contenido') <!--abrimos la seccion donde estara nuestro contenido dinamico donde 'contenido' es el que definimos en la plantilla-->
    <div class="row row ml-1 mr-1 p-2 border bg-light">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
            <h4>MESAS</h4>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <a href="mesa/create"><button class="btn btn-success float-right"><i class="far fa-plus-square fa-fw"></i> Nuevo</button></a>
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
                        <th>Mesa</th>
                        <th>Per</th>
                        <th>Estado</th>
                        <th>Opciones</th>
                    </thead>
                    @foreach ($mesas as $mesa)
                    <tr>
                        <td class="text-center">{{ $mesa->idmesa }}</td>
                        <td class="text-center">{{ $mesa->num_mesa }}</td>
                        <td class="text-center">{{ $mesa->cant_per }}</td>
                        @if ($mesa->estado == '0')
                            <td class="text-center"><h6 class="text-danger">Inactivo</h6></td>                   
                        @elseif ($mesa->estado == '1')
                            <td class="text-center"><h6 class="text-success">Activo</h6></td>
                        @elseif($mesa->estado == '2')
                            <td class="text-center"><h6 class="text-success">Activo</h6></td>
                        @endif                       
                        <td class="text-center">
                            @if ($mesa->estado == '1')
                                <a href="{{URL::action('MesaController@edit',$mesa->idmesa)}}"><button class="btn btn-info btn-sm"><i class="fas fa-pencil-alt fa-fw"></i> Editar</button></a>
                            @else
                                <a href="{{URL::action('MesaController@edit',$mesa->idmesa)}}"><button class="btn btn-info btn-sm" disabled><i class="fas fa-pencil-alt fa-fw"></i> Editar</button></a>
                            @endif
                            @if ($mesa->estado == '1')
                                <a href="" data-target="#modal-delete-{{$mesa->idmesa}}" data-toggle="modal"><button class="btn btn-danger btn-sm"><i class="far fa-trash-alt fa-fw"></i> Desactivar</button></a>
                            @elseif ($mesa->estado == '2')
                                <a href="" data-target="#modal-delete-{{$mesa->idmesa}}" data-toggle="modal"><button class="btn btn-danger btn-sm" disabled><i class="far fa-trash-alt fa-fw"></i> Desactivar</button></a>
                            @else
                                <a href="" data-target="#modal-delete-{{$mesa->idmesa}}" data-toggle="modal"><button class="btn btn-success btn-sm"><i class="far fa-check-circle fa-fw"></i> Activar</button></a>
                            @endif                                                                           
                        </td>
                    </tr>
                    @include('personal.mesa.modal')
                    @endforeach
                </table>
            </div>
            {{$mesas->render()}}
        </div>
    </div>
@endsection