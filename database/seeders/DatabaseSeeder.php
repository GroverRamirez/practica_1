<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Categoria;
use App\Models\Producto;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        // ===== PATRÓN DE FACTORÍAS PARA PRUEBAS Y DUMMY DATA =====
        // Instruimos a Laravel: "Fabrica 8 categorías Padre. Adentro de CADA UNA de esas 8 categorías,
        // incrusta 12 productos falsos que hereden esa id."
        Categoria::factory()
            ->count(8)
            ->has(Producto::factory()->count(12), 'productos')
            ->create();
    }
}
