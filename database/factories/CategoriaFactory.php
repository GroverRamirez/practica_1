<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Categoria>
 */
class CategoriaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Usa el motor Fake() para inventar datos realistas corporativos
            'nombre' => ucfirst(fake()->words(2, true)),
            'descripcion' => fake()->sentence(8),
            // Aseguramos que la mayoría salgan activos al azar, pero algunos inactivos
            'estado' => fake()->randomElement(['activo', 'activo', 'activo', 'inactivo']),
        ];
    }
}
