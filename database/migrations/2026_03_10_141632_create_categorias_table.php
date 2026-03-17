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
        // Aquí se define la estructura de la tabla 'categorias'.
        // La migración permite crear la tabla de forma controlada y repetible.
        Schema::create('categorias', function (Blueprint $table) {
            // id() crea la clave primaria autoincremental.
            $table->id();                                    // Columna 'id' autoincremental (clave primaria)

            // string() crea una columna de texto corto con un límite de 100 caracteres.
            $table->string('nombre', 100);                    // VARCHAR(100) - nombre de la categoría

            // text() se utiliza para descripciones u otros textos largos.
            $table->text('descripcion');                      // TEXT - descripción (texto largo)

            // default('activo') hace que el estado inicial de la categoría
            // sea 'activo' si no se especifica otro valor al guardar.
            $table->string('estado', 20)->default('activo');  // VARCHAR(20) - estado por defecto 'activo'

            // timestamps() agrega created_at y updated_at automáticamente.
            $table->timestamps();                             // created_at y updated_at (fechas automáticas)
        });
    }

    /**
     * down() - Se ejecuta al hacer rollback.
     * Revierte los cambios (elimina la tabla).
     */
    public function down(): void
    {
        // Este método revierte la migración eliminando la tabla.
        // Se usa cuando se ejecuta un rollback.
        Schema::dropIfExists('categorias');
    }
};
