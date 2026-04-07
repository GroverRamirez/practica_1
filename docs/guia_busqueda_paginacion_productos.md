# Guia Paso A Paso: Implementacion De Busqueda Y Paginacion En La Lista De Productos

## 1. Objetivo de la guia

Esta guia explica como implementar dos mejoras en el modulo `Productos` del proyecto `practica_1`:

1. paginacion del listado,
2. cuadro de busqueda sobre la lista de productos.

La implementacion se realiza sobre Laravel 12 usando el flujo normal del framework:

- ruta ya existente del `index`,
- controlador,
- vista Blade,
- estilos CSS,
- pruebas feature.

---

## 2. Resultado esperado

Al finalizar, la lista de productos debe permitir:

1. mostrar solo una cantidad fija de registros por pagina,
2. navegar entre paginas,
3. buscar por nombre del producto,
4. buscar por descripcion,
5. buscar por nombre de categoria,
6. conservar la busqueda al cambiar de pagina.

---

## 3. Archivos involucrados

### Controlador

- `app/Http/Controllers/ProductoController.php`

### Vista del listado

- `resources/views/productos/index.blade.php`

### Estilos

- `public/css/estilo.css`

### Configuracion de paginacion

- `app/Providers/AppServiceProvider.php`
- `resources/views/vendor/pagination/bootstrap-5.blade.php`

### Pruebas

- `tests/Feature/ProductoIndexPaginationTest.php`
- `tests/Feature/ProductoSearchTest.php`

---

## 4. Punto de partida

Antes de esta mejora, el modulo `Productos` cargaba todo el listado con:

```php
Producto::with('categoria')->get();
```

Eso genera dos problemas:

1. si existen muchos productos, la tabla crece demasiado,
2. el usuario no tiene una forma rapida de filtrar registros.

Por eso se incorporaron:

- `paginate()` para dividir resultados,
- `buscar` como parametro de consulta en la misma ruta `index`.

---

## 5. Paso 1 - Implementar la paginacion en el controlador

Archivo:

- `app/Http/Controllers/ProductoController.php`

### Metodo `index()` final

```php
public function index(Request $request)
{
    $busqueda = trim((string) $request->query('buscar', ''));

    $productos = Producto::with('categoria')
        ->when($busqueda !== '', function ($query) use ($busqueda) {
            $query->where(function ($subquery) use ($busqueda) {
                $subquery->where('nombre', 'like', "%{$busqueda}%")
                    ->orWhere('descripcion', 'like', "%{$busqueda}%")
                    ->orWhereHas('categoria', function ($categoriaQuery) use ($busqueda) {
                        $categoriaQuery->where('nombre', 'like', "%{$busqueda}%");
                    });
            });
        })
        ->orderBy('id')
        ->paginate(7)
        ->withQueryString();

    return view('productos.index', compact('productos', 'busqueda'));
}
```

### Que hace esta implementacion

1. lee el valor del parametro `buscar`,
2. aplica filtro solo si hay texto ingresado,
3. ordena los productos por `id`,
4. muestra `7` registros por pagina,
5. conserva la busqueda al moverse entre paginas con `withQueryString()`.

---

## 6. Paso 2 - Entender `paginate(7)`

La instruccion:

```php
->paginate(7)
```

significa que Laravel:

1. divide el resultado en paginas,
2. entrega solo `7` productos por solicitud,
3. calcula automaticamente total, pagina actual y ultima pagina,
4. permite usar `links()` en Blade para mostrar el paginador.

### Ejemplo

Si existen 10 productos:

- pagina 1 muestra productos 1 al 7,
- pagina 2 muestra productos 8 al 10.

---

## 7. Paso 3 - Implementar el cuadro de busqueda

La busqueda se resolvio en el mismo metodo `index()` mediante:

```php
$busqueda = trim((string) $request->query('buscar', ''));
```

Esto toma el valor enviado por URL, por ejemplo:

```text
/listaproductos?buscar=laptop
```

Luego, se filtran resultados con:

```php
->when($busqueda !== '', function ($query) use ($busqueda) {
    $query->where(function ($subquery) use ($busqueda) {
        $subquery->where('nombre', 'like', "%{$busqueda}%")
            ->orWhere('descripcion', 'like', "%{$busqueda}%")
            ->orWhereHas('categoria', function ($categoriaQuery) use ($busqueda) {
                $categoriaQuery->where('nombre', 'like', "%{$busqueda}%");
            });
    });
})
```

### Explicacion

- `where('nombre', 'like', ...)`
  busca coincidencias en el nombre del producto.

- `orWhere('descripcion', 'like', ...)`
  busca coincidencias en la descripcion.

- `orWhereHas('categoria', ...)`
  busca coincidencias en la categoria relacionada.

### Ventaja

El usuario no necesita tres filtros separados. Un solo cuadro permite buscar:

- productos,
- descripciones,
- categorias.

---

## 8. Paso 4 - Conservar la busqueda al paginar

Si solo se usa `paginate(7)`, al cambiar de pagina Laravel puede perder el parametro `buscar`.

Por eso se agrego:

```php
->withQueryString()
```

### Que logra esto

Si el usuario busca:

```text
/listaproductos?buscar=monitor
```

el enlace de la siguiente pagina mantiene:

```text
/listaproductos?buscar=monitor&page=2
```

Sin eso, la paginacion mostraria otra vez todo el listado completo.

---

## 9. Paso 5 - Crear el formulario de busqueda en Blade

Archivo:

- `resources/views/productos/index.blade.php`

### Formulario implementado

```blade
<form action="{{ route('listaproductos.index') }}" method="GET" class="product-search-form d-flex flex-wrap justify-content-center align-items-center gap-2 mt-3">
    <div class="input-group input-group-sm product-search-group">
        <span class="input-group-text bg-white border-end-0">
            <i class="bi bi-search"></i>
        </span>
        <input
            type="text"
            name="buscar"
            class="form-control border-start-0"
            placeholder="Buscar producto o categoria"
            value="{{ $busqueda }}"
        >
    </div>

    <button type="submit" class="btn btn-sm btn-primary-theme d-inline-flex align-items-center gap-1">
        <i class="bi bi-search"></i>
        <span>Buscar</span>
    </button>

    @if($busqueda !== '')
        <a href="{{ route('listaproductos.index') }}" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1">
            <i class="bi bi-x-circle"></i>
            <span>Limpiar</span>
        </a>
    @endif
</form>
```

### Por que se usa `GET`

Porque la busqueda:

- no modifica datos,
- debe reflejarse en la URL,
- debe poder compartirse o recargarse,
- es compatible con la paginacion.

---

## 10. Paso 6 - Mostrar informacion del filtro y de la pagina

En la parte superior del listado se dejaron indicadores como:

```blade
<span class="badge text-bg-light table-summary-pill">7 por pagina</span>
<span class="badge text-bg-light table-summary-pill">{{ $productos->count() }} visibles</span>
```

Y cuando existe filtro:

```blade
@if($busqueda !== '')
    <span class="badge text-bg-light table-summary-pill">Filtro: {{ $busqueda }}</span>
@endif
```

Esto ayuda al usuario a entender:

1. cuantos registros ve en la pagina actual,
2. cuantos registros se muestran por pagina,
3. si el listado esta filtrado.

---

## 11. Paso 7 - Mostrar el paginador en la vista

Al final de la tabla se usa:

```blade
{{ $productos->onEachSide(1)->links() }}
```

### Significado

- `links()` dibuja la navegacion del paginador,
- `onEachSide(1)` muestra una pagina vecina a cada lado.

### Bloque usado

```blade
@if($productos->hasPages())
    <div class="table-footer d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 px-4 py-3 border-top">
        <div class="table-summary-text mb-0">
            Pagina {{ $productos->currentPage() }} de {{ $productos->lastPage() }}
        </div>

        <div class="pagination-shell">
            {{ $productos->onEachSide(1)->links() }}
        </div>
    </div>
@endif
```

---

## 12. Paso 8 - Traducir el paginador al español

Laravel usa una vista Bootstrap para el paginador. Para traducir el texto:

```text
Showing 1 to 7 of 10 results
```

se creo una vista local en:

- `resources/views/vendor/pagination/bootstrap-5.blade.php`

### Resultado

Ahora se muestra:

```text
Mostrando 1 a 7 de 10 registros
```

Tambien se cambiaron:

- `Previous` por `Anterior`,
- `Next` por `Siguiente`.

---

## 13. Paso 9 - Ajustar estilos del buscador

Archivo:

- `public/css/estilo.css`

### Reglas usadas

```css
.product-search-group {
    min-width: 280px;
    width: min(100%, 420px);
}

.product-search-form {
    width: 100%;
}

.product-search-group .input-group-text,
.product-search-group .form-control {
    border-color: var(--mist-200);
}

.product-search-group .form-control:focus {
    border-color: #9fb5d1;
    box-shadow: 0 0 0 0.15rem rgba(37, 99, 235, 0.08);
}
```

### Objetivo visual

1. que el buscador no sea demasiado angosto,
2. que quede centrado,
3. que mantenga la estetica del panel,
4. que se vea bien en desktop y mobile.

---

## 14. Paso 10 - Mejorar el mensaje cuando no hay resultados

Cuando no hay registros y existe una busqueda activa, el mensaje ya no debe ser el mismo que en un listado vacio normal.

### Logica usada

```blade
@if($busqueda !== '')
    No se encontraron productos para "{{ $busqueda }}"
@else
    No hay productos registrados
@endif
```

### Ventaja

El usuario entiende si:

- realmente no existen productos,
- o simplemente su filtro no encontro coincidencias.

---

## 15. Paso 11 - Verificar con pruebas

### Paginacion

Archivo:

- `tests/Feature/ProductoIndexPaginationTest.php`

Esta prueba verifica que:

1. la primera pagina muestre productos del 1 al 7,
2. la segunda pagina muestre desde el 8 en adelante,
3. los productos no aparezcan en la pagina equivocada.

### Busqueda

Archivo:

- `tests/Feature/ProductoSearchTest.php`

Esta prueba verifica que:

1. un termino de busqueda filtre resultados,
2. se muestren coincidencias correctas,
3. no aparezcan productos ajenos al filtro,
4. se vea el indicador `Filtro: ...`.

### Comandos usados

```bash
php artisan test --filter ProductoIndexPaginationTest
php artisan test --filter ProductoSearchTest
```

---

## 16. Flujo completo del usuario

Con la implementacion final, el flujo es este:

1. el usuario entra a `listaproductos`,
2. Laravel carga 7 productos por pagina,
3. el usuario escribe un texto en el cuadro de busqueda,
4. el formulario envia `buscar` por `GET`,
5. el controlador filtra productos y categorias,
6. la vista muestra solo coincidencias,
7. el paginador conserva la busqueda entre paginas.

---

## 17. Problemas comunes

### Problema 1: La busqueda desaparece al cambiar de pagina

#### Causa

Falta `withQueryString()`.

#### Solucion

Agregar:

```php
->paginate(7)
->withQueryString();
```

---

### Problema 2: El formulario no filtra nada

#### Causa

El input no usa el nombre correcto o el controlador no lee `buscar`.

#### Solucion

Revisar:

```blade
name="buscar"
```

y en el controlador:

```php
$busqueda = trim((string) $request->query('buscar', ''));
```

---

### Problema 3: La paginacion funciona, pero el texto sigue en ingles

#### Causa

Laravel esta usando la vista default del framework.

#### Solucion

Crear:

- `resources/views/vendor/pagination/bootstrap-5.blade.php`

con el texto traducido al español.

---

## 18. Resumen tecnico

La implementacion completa de busqueda y paginacion en `Productos` se resolvio asi:

1. modificar `ProductoController@index` para aceptar `Request`,
2. leer el parametro `buscar`,
3. aplicar filtro por nombre, descripcion y categoria,
4. usar `paginate(7)`,
5. agregar `withQueryString()`,
6. crear el formulario de busqueda en `index.blade.php`,
7. mostrar resumen de filtro y paginas,
8. traducir el paginador al español,
9. validar con pruebas.

---

## 19. Conclusion

La lista de productos ya no es un listado plano. Ahora es una interfaz administrativa mas util porque:

- divide los resultados en paginas,
- reduce carga visual,
- permite encontrar registros rapido,
- mantiene el filtro entre paginas,
- muestra mensajes mas claros al usuario.

Con esto, el modulo `Productos` queda mas cercano a un panel administrativo real y escalable.
