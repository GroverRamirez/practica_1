<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index()
    {
        // with('categoria') carga también la categoría de cada producto en una sola consulta lógica.
        // Esto permite mostrar el nombre de la categoría en la tabla sin hacer consultas repetidas en la vista.
        $productos = Producto::with('categoria')->get(); // Se mantiene la carga de la categoría relacionada para mostrarla en el listado.
        return view('productos.index', compact('productos')); // La vista ya estaba en productos.index y se conserva porque coincide con la nueva estructura pedida.
    }

    public function create()
    {
        // Se consultan las categorías porque el formulario de productos necesita un select para elegir la categoría relacionada.
        $categorias = Categoria::all(); // Antes se cargaban productos y no se enviaban categorías correctamente; ahora se manda la colección necesaria para el select.
        return view('productos.create', compact('categorias')); // Antes la vista recibía una variable incorrecta; ahora recibe lo que realmente usa el formulario.
    }

    public function store(Request $request)
    {
        // validate() revisa que los datos del formulario cumplan reglas antes de guardar en la base de datos.
        $data = $request->validate([ // Antes se usaba all() sin control; ahora se validan solo los campos reales de la tabla productos.
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        // create() inserta un nuevo producto usando los campos permitidos en $fillable del modelo.
        Producto::create($data); // Se mantiene create(), pero ahora con datos validados para que coincidan con el modelo y la migración.

        return redirect()->route('listaproductos.index') // Antes redirigía a productos.index, ruta que no existe; ahora usa el nombre real generado por Route::resource().
            ->with('success', 'Producto creado exitosamente');
    }

    public function show(Producto $listaproducto) // Antes el nombre no coincidía con `{listaproducto}`; ahora Laravel enlaza correctamente el modelo definido por la ruta resource.
    {
        //
    }

    public function edit(Producto $listaproducto) // Se corrige el nombre del parámetro para que coincida con `listaproductos/{listaproducto}/edit` y llegue el producto real.
    {
        // También se cargan categorías en edición para permitir cambiar la relación del producto.
        $categorias = Categoria::all(); // Antes no se enviaban categorías a edición; ahora se mandan para poder cambiar la categoría del producto.
        // Se mantiene la variable $producto porque la vista ya está construida usando ese nombre.
        $producto = $listaproducto; // Se conserva el nombre `$producto` para la vista y así no se rompe la lógica actual del formulario.
        return view('productos.edit', compact('producto', 'categorias')); // La vista sigue recibiendo las mismas variables, pero ahora con el producto enlazado correctamente.
    }

    public function update(Request $request, Producto $listaproducto) // Se alinea el parámetro con el nombre de la ruta resource para que update reciba el registro correcto.
    {
        // En actualización se validan los mismos campos que en creación para mantener consistencia en el CRUD.
        $data = $request->validate([ // Antes validaba estado, campo inexistente en productos; ahora valida precio, stock y categoria_id.
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        // update() modifica el registro existente con los datos validados del formulario.
        $listaproducto->update($data); // Ahora se actualiza el producto enlazado por `{listaproducto}`, evitando trabajar con una instancia incorrecta.

        return redirect()->route('listaproductos.index') // Se corrige el nombre de la ruta para volver correctamente al listado de productos.
            ->with('success', 'Producto actualizado exitosamente');
    }

    public function destroy(Producto $listaproducto) // Se corrige el nombre para que la eliminación use el mismo binding correcto del recurso.
    {
        // delete() elimina el producto seleccionado desde la base de datos.
        $listaproducto->delete(); // Ahora se elimina el producto resuelto desde la ruta resource y no una variable con nombre inconsistente.

        return redirect()->route('listaproductos.index') // Antes apuntaba a una ruta con nombre incorrecto; ahora coincide con el resource de productos.
            ->with('success', 'Producto eliminado exitosamente');
    }
}
