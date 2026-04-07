<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use App\Models\Producto;
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
        $categorias = Categoria::all();

        return view('productos.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        Producto::create($data);

        return redirect()->route('listaproductos.index')
            ->with('success', 'Producto creado exitosamente');
    }

    public function show(Producto $listaproducto)
    {
        //
    }

    public function edit(Producto $listaproducto)
    {
        $categorias = Categoria::all();
        $producto = $listaproducto;

        return view('productos.edit', compact('producto', 'categorias'));
    }

    public function update(Request $request, Producto $listaproducto)
    {
        $data = $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'categoria_id' => 'required|exists:categorias,id',
        ]);

        $listaproducto->update($data);

        return redirect()->route('listaproductos.index')
            ->with('success', 'Producto actualizado exitosamente');
    }

    public function destroy(Producto $listaproducto)
    {
        $listaproducto->delete();

        return redirect()->route('listaproductos.index')
            ->with('success', 'Producto eliminado exitosamente');
    }
}
