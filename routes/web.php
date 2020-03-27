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

Route::get('/', function () {
    return view('auth/login');
});

Route::get('lista_facturas', 'FacturasController@index');
Route::get('nueva_factura', 'FacturasController@create');
Route::get('productos', 'ProductosController@index');
Route::get('nuevo_producto', 'ProductosController@create');
Route::get('nuevo_cliente', 'ClientesController@create');

Route::get('lista_clientes', 'ClientesController@index');
Route::get('clientes', 'ClientesController@index');
Route::get('editar_cliente/{id}', 'ClientesController@edit');
Route::post('actualizar_cliente/{id}', 'ClientesController@update');
Route::get('eliminar_cliente/{id}', 'ClientesController@destroy');

Route::post('agregar_cliente', 'ClientesController@store');
Route::get('buscar_cliente/{nombre}', 'ClientesController@show');


Route::get('lista_productos', 'ProductosController@index');


Route::post('agregar_producto', 'ProductosController@store');
Route::get('eliminar_producto/{id}', 'ProductosController@destroy');
Route::get('editar_producto/{id}', 'ProductosController@edit');
Route::post('actualizar_producto/{id}', 'ProductosController@update');

Route::get('facturas', 'FacturasController@index');
Route::post('agregar_factura', 'FacturasController@store');
Route::post('imprimir', 'FacturasController@show');
Route::get('eliminar_factura/{id}', 'FacturasController@destroy');

Route::get('agregar_producto_factura', 'Detalle_FacturasController@create');
Route::post('agregar_detalle_factura', 'Detalle_FacturasController@store');

Route::get('get_detalles_factura/{id}', 'Detalle_FacturasController@index');
Route::post('ver_factura', 'Detalle_FacturasController@show');
Route::get('editar_factura/{id}', 'Detalle_FacturasController@edit');
Route::post('actualizar_factura/{id}', 'Detalle_FacturasController@update');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
