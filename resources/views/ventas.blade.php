<?php
/*
    @extends es un metodo de blade, que trae las plantillas, en este caso la plantilla donde se encuentra
    el encabezado y el footer
    @section llama al nombre que le pusimos a @yield en nuestra plantilla  @endsection cierra la seccion
    */
?>
@extends('plantilla')

@section('seccion')
<h1>Ventas</h1>

@foreach($categorias as $item)
        <a href="{{ route('venta',$item)}}" class="btn btn-success btn-sm" role="button">{{ $item }}</a>
    @endforeach()

    @if(!empty($nomCat))

        @switch($nomCat)

            @case($nomCat=='Pollos')
                <h2 class="mt-5"> {{ $nomCat }}</h2> 
            @break

            @case($nomCat=='Carta')
                <h2 class="mt-5"> {{ $nomCat }}</h2> 
            @break

            @case($nomCat=='Bebidas')
                <h2 class="mt-5"> {{ $nomCat }}</h2> 
            @break

        @endswitch
        <p>{{ $nomCat }} existe</p>
    @endif

@endsection
