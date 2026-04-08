# Guía de Laboratorio 04: Búsquda Avanzada y Paginación

## A. Objetivo de la Práctica
Mejorar la interfaz y experiencia del usuario (UI/UX) al manejar volúmenes masivos de datos. Evitar el colapso del sistema reemplazando consultas `all()` por fraccionamientos paginados e incorporando un motor de búsqueda por texto.

## B. Prerrequisitos
- Productos existentes en Base de datos (Idealmente más de 15).

## C. Desarrollo Paso a Paso

### 1. Acelerar Consultas (Eager Loading) y Búsqueda
En `app/Http/Controllers/ProductoController.php`, modifique el método `index` para capturar cualquier parámetro "?buscar=" incrustado en la URL y utilice `with()` para arrastrar la relación y aligerar la memoria:

```php
public function index(Request $request) {
    // 1. Atrapar la palabra
    $busqueda = $request->input('buscar');
    
    // 2. Ejecutar lógica ("Eager Loading" con `with`)
    $query = Producto::with('categoria')->orderBy('id', 'desc');

    if ($busqueda) {
        $query->where('nombre', 'LIKE', '%' . $busqueda . '%');
    }

    // 3. Paginación y Resistencia (Query String vital para no perder la búsqueda)
    $productos = $query->paginate(10)->withQueryString();

    return view('productos.index', compact('productos', 'busqueda'));
}
```

### 2. Formulario de Búsqueda HTML
En su vista de lista (`index.blade.php`), incorpore encima de la tabla un motor clásico "GET":
```html
<form action="{{ route('productos.index') }}" method="GET">
    <input type="text" name="buscar" value="{{ $busqueda ?? '' }}" placeholder="Buscar por producto..." required>
    <button type="submit">Buscar</button>
</form>
```

### 3. Componente Paginador Bootstrap
Indíquele al núcleo visual de Laravel que las flechas paginadoras deben ser compatibles con Bootstrap 5 en `app/Providers/AppServiceProvider.php` (Método `boot`):
```php
use Illuminate\Pagination\Paginator;

public function boot() {
    Paginator::useBootstrapFive();
}
```
Y en la vista, invoque la paginación dinámica debajo de su `</table>`:
```php
{{ $productos->links() }}
```

## D. Resultado Esperado
Un sistema que extrae de 10 en 10, optimizando el rendimiento dramáticamente. Un input en la cabecera permite escribir una palabra y filtrar instantáneamente, preservando la página actual en la URL.
