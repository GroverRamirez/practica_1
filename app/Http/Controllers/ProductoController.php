<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateProductoRequest;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    public function index(Request $request)
    {
        // Se recoge el texto del cuadro de búsqueda desde la URL.
        // trim() evita que una cadena con solo espacios active filtros innecesarios.
        $busqueda = trim((string) $request->query('buscar', ''));

        // with('categoria') evita consultas repetidas en la vista al mostrar la categoría.
        // when(...) aplica el filtro solo si el usuario escribió algo en el buscador.
        $productos = Producto::with('categoria')
            ->when($busqueda !== '', function ($query) use ($busqueda) {
                // El filtro revisa nombre, descripción y también el nombre de la categoría relacionada.
                $query->where(function ($subquery) use ($busqueda) {
                    $subquery->where('nombre', 'like', "%{$busqueda}%")
                        ->orWhere('descripcion', 'like', "%{$busqueda}%")
                        ->orWhereHas('categoria', function ($categoriaQuery) use ($busqueda) {
                            $categoriaQuery->where('nombre', 'like', "%{$busqueda}%");
                        });
                });
            })
            // Se mantiene un orden estable para que la paginación no cambie entre recargas.
            ->orderBy('id')
            // paginate(7) divide el listado en bloques de 7 registros por página.
            ->paginate(7)
            // withQueryString() conserva ?buscar=... al pasar a la siguiente página.
            ->withQueryString();

        // La vista necesita tanto la colección paginada como el texto buscado para
        // volver a mostrarlo en el input y en el resumen del filtro.
        return view('productos.index', compact('productos', 'busqueda'));
    }

    public function reportePdf()
    {
        // El reporte PDF usa todos los productos, por eso aquí no se pagina.
        $productos = Producto::with('categoria')
            ->orderBy('nombre')
            ->get();

        // loadView() convierte una vista Blade en el contenido del PDF.
        // También se envía la fecha para imprimirla en el encabezado del reporte.
        $pdf = Pdf::loadView('productos.reporte-pdf', [
            'productos' => $productos,
            'fechaGeneracion' => Carbon::now(),
        ])->setPaper('a4', 'landscape');

        return $pdf->stream('reporte-productos.pdf');
    }

    public function create()
    {
        // Solo enviar categorías activas para nuevos productos.
        $categorias = Categoria::where('estado', 'activo')->get();

        return view('productos.create', compact('categorias'));
    }

    public function store(StoreProductoRequest $request)
    {
        $data = $request->validated();

        Producto::create($data);

        return redirect()->route('productos.index')
            ->with('success', 'Producto creado exitosamente');
    }



    public function edit(Producto $producto)
    {
        // Traemos las categorías activas, pero también incluimos la categoría actual del producto
        // en caso de que su categoría de origen haya sido marcada como inactiva después de crearse.
        $categorias = Categoria::where('estado', 'activo')
            ->orWhere('id', $producto->categoria_id)
            ->get();

        return view('productos.edit', compact('producto', 'categorias'));
    }

    public function update(UpdateProductoRequest $request, Producto $producto)
    {
        $data = $request->validated();

        $producto->update($data);

        return redirect()->route('productos.index')
            ->with('success', 'Producto actualizado exitosamente');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();

        return redirect()->route('productos.index')
            ->with('success', 'Producto eliminado exitosamente');
    }
}
