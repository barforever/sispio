<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
// el metodo Route::get nos permite crear una sola ruta para una accion en este caso para mostrar el inicio.
Route::get('/','VentaController@index');

// le metodo Route::resource nos permite crear un grupo de rutas de recursos con las peticiones
// index, create, show, edit, store, update y delete para cada modelo (la cual esta asociada a una tabla)
Route::resource('almacen/categoria','CategoriaController');
Route::resource('almacen/insumo','InsumoController');
Route::resource('almacen/proveedor','ProveedorController');
Route::resource('almacen/producto','ProductoController');
Route::resource('almacen/ingreso','IngresoController');
Route::resource('ventas/cliente','ClienteController');
Route::resource('ventas/venta','VentaController');
Route::get('ventas/venta/{id}/create','VentaController@create');
Route::resource('ventas/pedido','PedidoController');
Route::get('ventas/pedido/{id}/create','PedidoController@create');
Route::get('ventas/pedido/show2/{id}','PedidoController@show2');
Route::resource('personal/cargo','CargoController');
Route::resource('personal/turno','TurnoController');
Route::resource('personal/mesa','MesaController');
Route::resource('personal/colaborador','ColaboradorController');

Route::resource('reportes/diario','ReporteController');
Route::get('reportes/diario/pdf/ventas/{fecha}','ReporteController@ventas');
Route::get('reportes/diario/pdf/reporte/{fecha}','ReporteController@reporte');
Route::get('reportes/diario/pdf/diario/{fecha}','ReporteController@diario');
Route::get('reportes/diario/pdf/diarioinsumo/{fecha}','ReporteController@diarioinsumo');


Route::resource('usuarios/rol','RolController');
Route::resource('ventas/mozo','MozoController');
Route::resource('reportes/diario','ReporteController');
Route::resource('almacen/gasto','GastoController');

Route::get('reportes/diario/wow/{id}','ControladorPaginas@ventaproductos');
Route::get('reportes/diario/gasto/{id}','ControladorPaginas@detallegastos');




Route::get('ventas/{nomCat?}','ControladorPaginas@ventas')->name('venta');

Route::get('productos','ControladorPaginas@productos')->name('producto');
/*
Route::get('mozos/{nombre?}', function ($nombre = null){

    $mozos = ['Brayan','Raul','Lucho'];

    //return view('mozos',['mozo'=>$mozos,'nombre'=>$nombre]);
    return view('mozos',compact('mozos', 'nombre'));
})->name('mozo');
*/
Route::get('mozos/{nomMozo?}','ControladorPaginas@mozos')->name('mozo');

Route::get('reportes','ControladorPaginas@reportes')->name('reporte');
