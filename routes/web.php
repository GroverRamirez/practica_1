<?php

use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

// La portada pública permite entrar al sistema o ir al panel si el usuario ya se autenticó.
Route::view('/', 'welcome')->name('welcome');

// auth protege todo el panel administrativo y evita que invitados entren al CRUD.
Route::middleware('auth')->group(function () {
    // Breeze redirige aquí después de login o registro; desde este punto el proyecto
    // envía al módulo de productos como puerta de entrada del sistema.
    Route::get('/dashboard', function () {
        return redirect()->route('listaproductos.index');
    })->name('dashboard');

    // El perfil también pertenece al área privada porque depende del usuario autenticado.
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Los módulos académicos quedan restringidos hasta que Laravel valide la sesión.
    Route::resource('listacategorias', CategoriaController::class);
    Route::resource('listaproductos', ProductoController::class);
});

// Se separan las rutas de autenticación para mantener ordenado el módulo.
require __DIR__.'/auth.php';
