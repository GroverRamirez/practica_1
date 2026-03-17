<?php

/**
 * RUTAS - web.php
 * Define las URLs y qué controlador/método las maneja.
 * Este archivo funciona como el punto de entrada del flujo web:
 * aquí se decide qué acción del sistema responderá a cada URL.
 */

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;

// Ruta principal: /
// Cuando el usuario entra a la raíz del proyecto, Laravel devuelve
// la vista de bienvenida del sistema.
Route::get('/', function () {
    return view('welcome');
});

Route::resource('listacategorias', CategoriaController::class);
// Este resource crea todas las rutas del CRUD de productos sin definirlas una por una.
// Laravel genera index, create, store, show, edit, update y destroy automáticamente.
Route::resource('listaproductos', ProductoController::class);
/**
 * Route::resource - Crea 7 rutas REST automáticamente para el recurso "categorias"
 * Método  | URI                        | Acción   | Nombre ruta
 * GET    | /listacategorias           | index    | listacategorias.index
 * GET    | /listacategorias/create    | create   | listacategorias.create
 * POST   | /listacategorias           | store    | listacategorias.store
 * GET    | /listacategorias/{id}      | show     | listacategorias.show
 * GET    | /listacategorias/{id}/edit | edit     | listacategorias.edit
 * PUT    | /listacategorias/{id}      | update   | listacategorias.update
 * DELETE | /listacategorias/{id}      | destroy  | listacategorias.destroy
 */
// Route::resource() genera automáticamente las rutas del CRUD
// siguiendo la convención REST de Laravel.
//
// 'listacategorias' define el segmento de URL del recurso.
// CategoriaController::class indica el controlador que atenderá
// las operaciones de listar, crear, guardar, editar, actualizar y eliminar.


/*
Route::get('/calificaciones',[CalificacionesController::class,'index'])
->name('calificaciones.index');

Route::get('/calificaciones/crear',[CalificacionesController::class,'create'])
->name('calificaciones.crear');

Route::get('/calificaciones/{id}/editar',[CalificacionesController::class,'edit'])
->whereNumber('id')->name('calificaciones.editar');

Route::get('/saludo',[CalificacionesController::class,'saludo']);
*/
/*
Route::get('/saludo', function () {
    return "Hola Mundo, soy Grover";
});

Route::get('/inicio',function(){
    return view('calificaciones.index');
});

Route::get('/crear', function(){
    return view('calificaciones.crear');
});

Route::get('/editar', function(){
    return view('calificaciones.editar');
});

*/
?>
