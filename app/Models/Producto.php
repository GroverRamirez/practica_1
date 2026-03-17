<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    // Lista de columnas que se pueden asignar de forma masiva al crear o actualizar producto
    // Estos campos coinciden con la tabla productos y con lo que se envía desde los formularios.
    protected $fillable = ['nombre','descripcion','precio','stock','categoria_id'];
    //relacion de muschos a unio belongsTo cada producto pertenece a una sola categoria
    public function categoria()
    {
        // belongsTo() indica que cada producto está asociado a una sola categoría.
        // Gracias a esta relación se puede usar $producto->categoria para acceder al registro relacionado.
        return $this->belongsTo(Categoria::class);
    }

}
