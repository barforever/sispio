<?php
/*
    @extends es un metodo de blade, que trae las plantillas, en este caso la plantilla donde se encuentra
    el encabezado y el footer
    @section llama al nombre que le pusimos a @yield en nuestra plantilla  @endsection cierra la seccion
    */
?>
@extends('plantilla')

@section('seccion')
<h1>Reportes</h1>
@endsection
