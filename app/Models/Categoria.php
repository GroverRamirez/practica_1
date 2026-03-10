<?php

/**
 * MODELO - Categoria
 * Los modelos representan las tablas de la BD. Laravel asume que la tabla se llama 'categorias'
 * (plural del nombre de la clase en minúsculas).
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categoria extends Model
{
    /**
     * $fillable - Asignación masiva permitida.
     * Solo estos campos pueden usarse con create() o update(['campo' => valor]).
     * Protege contra ataques de asignación masiva.
     * Nota: Si usas 'estado' en store/update, agrégalo aquí: ['nombre','descripcion','estado']
     */
    protected $fillable = ['nombre', 'descripcion', 'estado'];

    /**
     * Relación: Una categoría tiene muchos productos.
     * hasMany = un registro (categoría) puede tener varios relacionados (productos).
     * Uso: $categoria->producto
     */
    public function producto()
    {
        return $this->hasMany(Producto::class); // Producto::class referencia al modelo Producto
    }
}
