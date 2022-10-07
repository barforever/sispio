<?php
/*
    @extends es un metodo de blade, que trae las plantillas, en este caso la plantilla donde se encuentra
    el encabezado y el footer
    @section llama al nombre que le pusimos a @yield en nuestra plantilla  @endsection cierra la seccion
    */
?>
@extends('plantilla')

@section('seccion')
    <h1>Mozos</h1>

    @foreach($mozos as $item)
        <a href="{{ route('mozo',$item)}}" class="btn btn-success btn-sm" role="button">{{ $item }}</a>
    @endforeach()

    @if(!empty($nomMozo))

        @switch($nomMozo)

            @case($nomMozo=='Brayan')
                <h2 class="mt-5">El nombre del mozo es {{ $nomMozo }}</h2> 
            @break

            @case($nomMozo=='Raul')
                <h2 class="mt-5">El nombre del mozo es {{ $nomMozo }}</h2> 
            @break

            @case($nomMozo=='Lucho')
                <h2 class="mt-5">El nombre del mozo es {{ $nomMozo }}</h2> 
            @break

        @endswitch
        <p>{{ $nomMozo }} existe</p>
    @endif

@endsection
