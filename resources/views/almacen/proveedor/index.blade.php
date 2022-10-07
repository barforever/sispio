@extends ('layouts.admin') <!--traemos la plantilla-->

@section ('contenido') <!--abrimos la seccion donde estara nuestro contenido dinamico donde 'contenido' es el que definimos en la plantilla-->
    <div class="row ml-1 mr-1 p-2 border bg-light">
        <div class="col-lg-10 col-md-10 col-sm-10 col-xs-12">
            <h4>PROVEEDORES</h4>
        </div>
        <div class="col-lg-2 col-md-2 col-sm-2 col-xs-12">
            <a href="proveedor/create"><button class="btn btn-success float-right"><i class="far fa-plus-square fa-fw"></i> Nuevo</button></a>
        </div>
    </div>
    <div class="row" style="height:10px">
        
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">            
            @include('almacen.proveedor.search')
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-condensed table-hover table-sm">
                    <thead class="text-center text-black" style="background-color:#f8c819">
                        <th>N</th>
                        <th>Nombre</th>
                        <th>Documento</th>
                        <th>Est</th>
                        <th>Opciones</th>
                    </thead>
                    @foreach ($proveedores as $proveedor)
                    <tr>
                        <td class="text-center">{{ $n++ }}</td>
                        <td class="text-left"><a href="{{URL::action('ProveedorController@show',$proveedor->idpersona)}}">{{ $proveedor->nombre }}</a></td>
                        <td class="text-left">{{ $proveedor->tipo_documento.'-'.$proveedor->num_documento }}</td>                       
                        @if ($proveedor->estado == '1')
                            <td class="text-center"><i class="far fa-check-circle fa-fw" style="color:green"></i></td>
                        @else
                            <td class="text-center"><i class="far fa-times-circle fa-fw" style="color:red"></i></td>
                        @endif                                      
                        <td class="text-center">
                        @if ($proveedor->estado=='1')
                            <a href="{{URL::action('ProveedorController@edit',$proveedor->idpersona)}}"><button class="btn btn-info btn-sm"><i class="fas fa-pencil-alt fa-fw"></i> Editar</button></a>
                        @else
                            <a href="{{URL::action('ProveedorController@edit',$proveedor->idpersona)}}"><button class="btn btn-info btn-sm" disabled><i class="fas fa-pencil-alt fa-fw"></i> Editar</button></a>
                        @endif    
                        @if ($proveedor->estado=='1')
                            <a href="" data-target="#modal-delete-{{$proveedor->idpersona}}" data-toggle="modal"><button class="btn btn-danger btn-sm"><i class="far fa-trash-alt fa-fw"></i> Desact</button></a>
                        @else
                            <a href="" data-target="#modal-delete-{{$proveedor->idpersona}}" data-toggle="modal"><button class="btn btn-success btn-sm"><i class="far fa-check-circle fa-fw"></i> Activar</button></a>
                        @endif                                                                         
                        </td>
                    </tr>
                    @include('almacen.proveedor.modal')
                    @endforeach
                </table>
            </div>
            {{$proveedores->render()}}
        </div>
    </div>
@endsection