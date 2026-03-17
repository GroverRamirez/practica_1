<?php

/**
 * CONTROLADOR - CategoriaController
 * Recibe las peticiones HTTP y decide qué hacer. Sigue el patrón REST con 7 métodos:
 * index, create, store, show, edit, update, destroy
 * Las rutas se definen en routes/web.php con Route::resource()
 */

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    /**
     * index - Lista todas las categorías.
     * Ruta: GET /listacategorias
     */
    public function index()
    {
        $categorias = Categoria::all(); // Consulta: SELECT * FROM categorias
        // Ahora la vista está en la carpeta 'categorias'; antes se llamaba 'listacategorias'.
        // Esta versión es mejor porque organiza el módulo por carpeta y facilita su mantenimiento.
        return view('categorias.index', compact('categorias')); // Envía $categorias a la vista
    }

    /**
     * create - Muestra el formulario para crear.
     * Ruta: GET /listacategorias/create
     */
    public function create()
    {
        // Ahora carga 'categorias.create'; antes apuntaba a 'createcategorias'.
        // Esta estructura es mejor porque hace consistente el nombre del módulo y de sus vistas.
        return view('categorias.create');
    }

    /**
     * store - Guarda una nueva categoría (procesa el POST del formulario).
     * Ruta: POST /listacategorias
     */
    public function store(Request $request)
    {
        $data = $request->all(); // Obtiene todos los datos del formulario
        $data['estado'] = $request->input('estado', 'activo'); // Estado por defecto
        Categoria::create($data); // INSERT en la BD (usa $fillable del modelo)
        return redirect()->route('listacategorias.index')
            ->with('success', 'Categoría creada exitosamente'); // Redirige y guarda mensaje en sesión
    }

    /**
     * show - Muestra una categoría específica (no implementado).
     * Ruta: GET /listacategorias/{id}
     */
    public function show(Categoria $categoria)
    {
        //
    }

    /**
     * edit - Muestra el formulario para editar.
     * Ruta: GET /listacategorias/{id}/edit
     * Route Model Binding: Laravel inyecta la Categoria por el ID de la URL
     */
    public function edit(Categoria $listacategoria)
    {
        // Ahora usa 'categorias.edit'; antes usaba 'editcategorias'.
        // Es mejor porque mantiene juntas las vistas del módulo y evita nombres dispersos.
        return view('categorias.edit', compact('listacategoria')); // Pasa la categoría a editar
    }

    /**
     * update - Actualiza una categoría (procesa el PUT del formulario).
     * Ruta: PUT/PATCH /listacategorias/{id}
     */
    public function update(Request $request, Categoria $listacategoria)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'estado' => 'required|in:activo,inactivo',
        ]);
        $listacategoria->update([
            'nombre' => $request->input('nombre'),
            'descripcion' => $request->input('descripcion'),
            'estado' => $request->input('estado'),
        ]);
        return redirect()->route('listacategorias.index')
            ->with('success', 'Categoría actualizada exitosamente');
    }

    /**
     * destroy - Elimina una categoría.
     * Ruta: DELETE /listacategorias/{id}
     */
    public function destroy(Categoria $listacategoria)
    {
        $listacategoria->delete(); // DELETE en la BD
        return redirect()->route('listacategorias.index')
            ->with('success', 'Categoría eliminada exitosamente');
    }
}
