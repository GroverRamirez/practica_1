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
    // $fillable define qué columnas pueden llenarse masivamente
    // al usar métodos como create() o update().
    // Esto ayuda a proteger el modelo frente a datos no deseados.
    protected $fillable = ['nombre', 'descripcion', 'estado'];

    /**
     * Relación: Una categoría tiene muchos productos.
     * hasMany = un registro (categoría) puede tener varios relacionados (productos).
     * Uso: $categoria->producto
     */
    public function productos()
    {
        // hasMany() indica una relación de uno a muchos:
        // una categoría puede tener varios productos asociados.
        //
        // Gracias a esta relación, Laravel permite acceder a los productos
        // relacionados desde una instancia de Categoria.
        return $this->hasMany(Producto::class); // Producto::class referencia al modelo Producto
    }
}
