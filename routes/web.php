<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('/seleccionar', 'HomeController@indexUsers')->middleware('auth');

Route::post('/recaudar', 'RecaudaController@prepara');
Route::post('/validar/{id}/{p}', [
	'uses' => 'RecaudaController@guardar',
	'as' => 'guardar',
	'middleware' => ['auth']
	]);
// Route::post('/validartodo/{id}', [
// 	'uses' => 'RecaudaController@completarPlantilla',
// 	'as' => 'completarPlantilla',
// 	'middleware' => ['auth']
// 	]);

Route::get('/detalle/{id}',[
	'uses'=>'RecaudaController@detallePlantilla',
	'as' => 'detallePlantilla',
	'middleware' => ['auth']
	]);
Route::get('/control','RecaudaController@listadoplantillas')->middleware('auth');
Route::post('/modificarPlantilla/{id}/{a}', [
	'uses' => 'RecaudaController@modificarPlantilla',
	'as' => 'modificarPlantilla',
	'middleware' => ['auth']
	]);
// Route::post('/totalPlantilla/{id}/{t}', [
// 	'uses' => 'RecaudaController@guardarTotalPlantilla',
// 	'as' => 'totalPlantilla',
// 	'middleware' => ['auth']
// 	]);

//CRUD
Route::resource('maquinas', 'MaquinaController');

Route::get('/ventas','VentaController@index')->middleware('auth','admin');
Route::post('/ventas/crearInforme','VentaController@crearInforme')->middleware('auth','admin');;
Route::get('/descuadres','VentaController@mostrarDescuadres')->middleware('auth','admin');




