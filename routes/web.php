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

Route::get('/',function (){
    return view('plantilla');
});
Route::get('lista_clientes','ClientesController@index');
Route::get('clientes','ClientesController@index');

Route::post('nuevo_cliente','ClientesController@create');
Route::post('agregar_cliente','ClientesController@store');
Route::post('buscar_cliente','ClientesController@show');


Route::get('lista_productos','ProductosController@index');
Route::get('productos','ProductosController@index');


Route::post('nuevo_producto','ProductosController@create');
Route::post('agregar_producto','ProductosController@store');



Route::get('lista_facturas','FacturasController@index');

Route::get('facturas','FacturasController@index');


Route::post('nueva_factura','FacturasController@create');
Route::post('agregar_factura','FacturasController@store');
Route::post('imprimir','FacturasController@show');
Route::get('eliminar_factura/{id}','FacturasController@destroy');

Route::get('agregar_producto_factura','Detalle_facturasController@create');
Route::post('agregar_detalle_factura','Detalle_facturasController@store');

Route::get('get_detalles_factura/{id}','Detalle_facturasController@index');
Route::post('ver_factura','Detalle_facturasController@show');

