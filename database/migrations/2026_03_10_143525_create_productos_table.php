<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Esta migración crea la tabla productos y define su estructura en la base de datos.
        Schema::create('productos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->text('descripcion');
            // precio almacena el valor económico del producto.
            $table->decimal('precio');
            // stock guarda cuántas unidades disponibles existen del producto.
            $table->integer('stock');
            // categoria_id crea la relación con la tabla categorias.
            // onDelete('cascade') indica que si se elimina una categoría, sus productos relacionados también se eliminan.
            $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
