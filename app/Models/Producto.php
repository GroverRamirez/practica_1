<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Producto extends Model
{
    // Lista de columnas que se pueden asignar de forma masiva al crear o actualizar producto
    protected $fillable = ['nombre','descripcion','precio','stock','categoria_id'];
    //relacion de muschos a unio belongsTo cada producto pertenece a una sola categoria
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

}
