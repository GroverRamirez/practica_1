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
        return view('listacategorias', compact('categorias')); // Envía $categorias a la vista
    }

    /**
     * create - Muestra el formulario para crear.
     * Ruta: GET /listacategorias/create
     */
    public function create()
    {
        return view('createcategorias');
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
        return view('editcategorias', compact('listacategoria')); // Pasa la categoría a editar
    }

    /**
     * update - Actualiza una categoría (procesa el PUT del formulario).
     * Ruta: PUT/PATCH /listacategorias/{id}
     */
    public function update(Request $request, Categoria $listacategoria)
    {
        $data = $request->all();
        $data['estado'] = $request->input('estado', 'activo');
        $listacategoria->update($data); // UPDATE en la BD
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
