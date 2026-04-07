<?php

namespace Tests\Feature;

use App\Models\Categoria;
use App\Models\Producto;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ProductoIndexPaginationTest extends TestCase
{
    use RefreshDatabase;

    public function test_products_index_is_paginated(): void
    {
        $user = User::factory()->create();
        $categoria = Categoria::create([
            'nombre' => 'Monitores',
            'descripcion' => 'Pantallas y accesorios',
            'estado' => 'activo',
        ]);

        foreach (range(1, 10) as $numero) {
            $etiqueta = str_pad((string) $numero, 2, '0', STR_PAD_LEFT);

            Producto::create([
                'nombre' => "Producto {$etiqueta}",
                'descripcion' => "Descripcion extensa del producto {$etiqueta}",
                'precio' => 100 + $numero,
                'stock' => $numero,
                'categoria_id' => $categoria->id,
            ]);
        }

        $primeraPagina = $this
            ->actingAs($user)
            ->get(route('listaproductos.index'));

        $primeraPagina->assertOk();
        $primeraPagina->assertSee('Producto 01');
        $primeraPagina->assertSee('Producto 07');
        $primeraPagina->assertDontSee('Producto 08');

        $segundaPagina = $this
            ->actingAs($user)
            ->get(route('listaproductos.index', ['page' => 2]));

        $segundaPagina->assertOk();
        $segundaPagina->assertSee('Producto 08');
        $segundaPagina->assertSee('Producto 09');
        $segundaPagina->assertSee('Producto 10');
        $segundaPagina->assertDontSee('Producto 01');
    }
}
