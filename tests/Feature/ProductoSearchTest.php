<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductoSearchTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_index_filters_by_search_term(): void
    {
        // Se autentica un usuario porque el módulo de productos está protegido por auth.
        $user = User::factory()->create();

        // Se crean dos categorías distintas para probar que el filtro también busca en la relación.
        $laptops = Categoria::create([
            'nombre' => 'Laptops',
            'descripcion' => 'Equipos portatiles',
            'estado' => 'activo',
        ]);

        $monitores = Categoria::create([
            'nombre' => 'Monitores',
            'descripcion' => 'Pantallas',
            'estado' => 'activo',
        ]);

        // El primer producto debe coincidir con la búsqueda por la categoría "Laptops".
        Producto::create([
            'nombre' => 'MacBook Air',
            'descripcion' => 'Portatil ligera para oficina',
            'precio' => 9500,
            'stock' => 5,
            'categoria_id' => $laptops->id,
        ]);

        // El segundo producto sirve para comprobar que el filtro excluye registros no relacionados.
        Producto::create([
            'nombre' => 'Samsung Odyssey',
            'descripcion' => 'Monitor curvo gamer',
            'precio' => 3200,
            'stock' => 7,
            'categoria_id' => $monitores->id,
        ]);

        // La búsqueda usa GET y viaja como ?buscar=... hacia el mismo index del listado.
        $response = $this
            ->actingAs($user)
            ->get(route('listaproductos.index', ['buscar' => 'Laptop']));

        $response->assertOk();
        $response->assertSee('MacBook Air');
        $response->assertDontSee('Samsung Odyssey');
        $response->assertSee('Filtro: Laptop');
    }
}
