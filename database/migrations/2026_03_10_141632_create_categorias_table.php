<?php

/**
 * MIGRACIÓN - Categorías
 * Las migraciones definen la estructura de las tablas en la base de datos.
 * Se ejecutan con: php artisan migrate
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * up() - Se ejecuta al correr la migración.
     * Crea la tabla con su estructura.
     */
    public function up(): void
    {
        Schema::create('categorias', function (Blueprint $table) {
            $table->id();                                    // Columna 'id' autoincremental (clave primaria)
            $table->string('nombre', 100);                    // VARCHAR(100) - nombre de la categoría
            $table->text('descripcion');                      // TEXT - descripción (texto largo)
            $table->string('estado', 20)->default('activo');  // VARCHAR(20) - estado por defecto 'activo'
            $table->timestamps();                             // created_at y updated_at (fechas automáticas)
        });
    }

    /**
     * down() - Se ejecuta al hacer rollback.
     * Revierte los cambios (elimina la tabla).
     */
    public function down(): void
    {
        Schema::dropIfExists('categorias');
    }
};
