<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Categoria;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Producto>
 */
class ProductoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Engendra nombres de productos de 3 a 4 letras
            'nombre' => ucfirst(fake()->words(3, true)),
            'descripcion' => fake()->paragraph(2),
            // Crea un precio hiper-realista entre 10 Bs. y 8000 Bs. con 2 decimales
            'precio' => fake()->randomFloat(2, 10, 8000), 
            // Crea un inventario aleatorio entre 0 y 50
            'stock' => fake()->numberBetween(0, 50),
            // Si el factory se llama solo, invocará y creará una Categoría nueva.
            'categoria_id' => Categoria::factory(),
        ];
    }
}
