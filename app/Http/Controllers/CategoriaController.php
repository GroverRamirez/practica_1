<?php

/**
 * CONTROLADOR - CategoriaController
 * Recibe las peticiones HTTP y decide qué hacer. Sigue el patrón REST con 7 métodos:
 * index, create, store, show, edit, update, destroy
 * Las rutas se definen en routes/web.php con Route::resource()
 */

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Http\Requests\StoreCategoriaRequest;
use App\Http\Requests\UpdateCategoriaRequest;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * index - Lista todas las categorías.
     * Ruta: GET /categorias
     */
    public function index()
    {
        $categorias = Categoria::paginate(10); // Consulta: SELECT * FROM categorias con paginación
        // Ahora la vista está en la carpeta 'categorias'; antes se llamaba 'categorias'.
        // Esta versión es mejor porque organiza el módulo por carpeta y facilita su mantenimiento.
        return view('categorias.index', compact('categorias')); // Envía $categorias a la vista
    }

    /**
     * create - Muestra el formulario para crear.
     * Ruta: GET /categorias/create
     */
    public function create()
    {
        // Ahora carga 'categorias.create'; antes apuntaba a 'createcategorias'.
        // Esta estructura es mejor porque hace consistente el nombre del módulo y de sus vistas.
        return view('categorias.create');
    }

    /**
     * store - Guarda una nueva categoría (procesa el POST del formulario).
     * Ruta: POST /categorias
     */
    public function store(StoreCategoriaRequest $request)
    {
        $data = $request->validated();
        $data['estado'] = $request->input('estado', 'activo'); // Estado por defecto
        Categoria::create($data); // INSERT en la BD (usa $fillable del modelo)
        return redirect()->route('categorias.index')
            ->with('success', 'Categoría creada exitosamente'); // Redirige y guarda mensaje en sesión
    }



    /**
     * edit - Muestra el formulario para editar.
     * Ruta: GET /categorias/{id}/edit
     * Route Model Binding: Laravel inyecta la Categoria por el ID de la URL
     */
    public function edit(Categoria $categoria)
    {
        // Ahora usa 'categorias.edit'; antes usaba 'editcategorias'.
        // Es mejor porque mantiene juntas las vistas del módulo y evita nombres dispersos.
        return view('categorias.edit', compact('categoria')); // Pasa la categoría a editar
    }

    /**
     * update - Actualiza una categoría (procesa el PUT del formulario).
     * Ruta: PUT/PATCH /categorias/{id}
     */
    public function update(UpdateCategoriaRequest $request, Categoria $categoria)
    {
        $categoria->update($request->validated());
        return redirect()->route('categorias.index')
            ->with('success', 'Categoría actualizada exitosamente');
    }

    /**
     * destroy - Elimina una categoría.
     * Ruta: DELETE /categorias/{id}
     */
    public function destroy(Categoria $categoria)
    {
        $categoria->delete(); // DELETE en la BD
        return redirect()->route('categorias.index')
            ->with('success', 'Categoría eliminada exitosamente');
    }
}
