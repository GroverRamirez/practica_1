# Guia Paso A Paso: Implementacion De Reporte PDF En El Modulo Productos Con DomPDF

## 1. Contexto del proyecto

El proyecto `practica_1` esta construido en Laravel 12 y actualmente tiene dos modulos principales activos:

1. `Categorias`
2. `Productos`

El reporte PDF se implementa sobre el modulo `Productos`, porque ese es el modulo que ya tiene:

- modelo,
- controlador,
- vistas Blade,
- rutas protegidas con autenticacion,
- relacion con categorias.

En esta guia se explica como agregar una salida en PDF usando `barryvdh/laravel-dompdf`, que es una integracion comun de `dompdf` para Laravel.

---

## 2. Objetivo general

Implementar un reporte PDF del listado de productos para que un usuario autenticado pueda generarlo desde la interfaz del modulo `Productos`.

---

## 3. Objetivos especificos

1. Instalar la libreria DomPDF en Laravel.
2. Crear una ruta exclusiva para el reporte PDF.
3. Agregar una accion en `ProductoController`.
4. Construir una vista Blade especializada para PDF.
5. Agregar un boton en la interfaz del modulo.
6. Verificar el funcionamiento con pruebas.

---

## 4. Requisitos previos

- PHP 8.2 o superior.
- Composer.
- Laravel 12 funcionando.
- Base de datos configurada.
- Migraciones ejecutadas.
- Modulo `Productos` ya operativo.
- Usuario autenticado para probar la generacion del PDF.

---

## 5. Archivos involucrados

### Dependencias

- `composer.json`
- `composer.lock`

### Rutas

- `routes/web.php`

### Controlador

- `app/Http/Controllers/ProductoController.php`

### Vistas

- `resources/views/productos/index.blade.php`
- `resources/views/productos/reporte-pdf.blade.php`

### Pruebas

- `tests/Feature/ProductoReportePdfTest.php`

---

## 6. Diagnostico inicial

Antes de implementar el PDF, el proyecto ya tenia:

- un CRUD de productos,
- una relacion `Producto -> Categoria`,
- autenticacion con Breeze,
- rutas privadas bajo `middleware('auth')`.

Pero todavia no tenia:

- ninguna libreria PDF instalada,
- una ruta para descargar o visualizar reportes,
- una vista preparada para salida PDF,
- pruebas del comportamiento del reporte.

Por eso la implementacion correcta debia tocar cuatro capas:

1. dependencia,
2. ruta,
3. controlador,
4. vista.

---

## 7. Paso 1 - Instalar DomPDF

En Laravel no conviene generar el PDF manualmente. La forma mas practica es usar una libreria ya integrada con Blade.

Se instalo el paquete:

```bash
composer require barryvdh/laravel-dompdf
```

### Que cambio produce este comando

1. Agrega el paquete a `composer.json`.
2. Actualiza `composer.lock`.
3. Descarga `dompdf` y sus dependencias.
4. Deja disponible el facade `Pdf`.

### Resultado esperado en `composer.json`

```json
"require": {
    "php": "^8.2",
    "barryvdh/laravel-dompdf": "^3.1",
    "laravel/framework": "^12.0",
    "laravel/tinker": "^2.10.1"
}
```

### Idea clave

DomPDF convierte una vista HTML Blade en un documento PDF. Eso permite reutilizar la logica visual del proyecto sin escribir bajo nivel de PDF.

---

## 8. Paso 2 - Crear la ruta del reporte

El reporte debe quedar protegido igual que el resto del panel administrativo. Por eso la ruta se agrego dentro del grupo con `middleware('auth')`.

Archivo:

- `routes/web.php`

### Codigo agregado

```php
Route::get('listaproductos/reporte/pdf', [ProductoController::class, 'reportePdf'])
    ->name('listaproductos.pdf');
```

### Ubicacion correcta dentro del archivo

Debe quedar antes de:

```php
Route::resource('listaproductos', ProductoController::class);
```

### Por que conviene ponerla antes del resource

Porque `Route::resource()` genera rutas dinamicas como:

```php
listaproductos/{listaproducto}
```

Si la ruta PDF se declarara despues, Laravel podria interpretar `reporte/pdf` como si fuera un parametro del recurso.

### Fragmento final recomendado

```php
Route::middleware('auth')->group(function () {
    Route::resource('listacategorias', CategoriaController::class);

    Route::get('listaproductos/reporte/pdf', [ProductoController::class, 'reportePdf'])
        ->name('listaproductos.pdf');

    Route::resource('listaproductos', ProductoController::class);
});
```

---

## 9. Paso 3 - Importar las clases necesarias en el controlador

Archivo:

- `app/Http/Controllers/ProductoController.php`

Se agregaron estos imports:

```php
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
```

### Para que sirve cada uno

- `Pdf`: genera el PDF a partir de una vista Blade.
- `Carbon`: permite mostrar la fecha y hora de generacion del reporte.

---

## 10. Paso 4 - Crear el metodo `reportePdf()` en `ProductoController`

El controlador es el lugar correcto para reunir datos, invocar la vista PDF y devolver la respuesta al navegador.

### Metodo implementado

```php
public function reportePdf()
{
    $productos = Producto::with('categoria')
        ->orderBy('nombre')
        ->get();

    $pdf = Pdf::loadView('productos.reporte-pdf', [
        'productos' => $productos,
        'fechaGeneracion' => Carbon::now(),
    ])->setPaper('a4', 'landscape');

    return $pdf->stream('reporte-productos.pdf');
}
```

### Explicacion paso a paso

1. `Producto::with('categoria')`
   Carga cada producto junto con su categoria para evitar consultas repetidas en la vista.

2. `orderBy('nombre')`
   Ordena el reporte alfabeticamente para que sea mas legible.

3. `Pdf::loadView(...)`
   Toma una vista Blade y la transforma en el contenido del PDF.

4. `'productos.reporte-pdf'`
   Es la vista creada especificamente para el reporte.

5. `'fechaGeneracion' => Carbon::now()`
   Envia la fecha actual a la vista para imprimirla en el encabezado.

6. `setPaper('a4', 'landscape')`
   Configura hoja A4 horizontal, util para tablas con varias columnas.

7. `stream('reporte-productos.pdf')`
   Abre el PDF en el navegador en vez de forzar descarga inmediata.

### Diferencia entre `stream()` y `download()`

- `stream()`: visualiza el PDF en el navegador.
- `download()`: descarga el archivo automaticamente.

Si luego se desea descarga directa, se puede cambiar por:

```php
return $pdf->download('reporte-productos.pdf');
```

---

## 11. Paso 5 - Crear la vista Blade para el PDF

Archivo nuevo:

- `resources/views/productos/reporte-pdf.blade.php`

Esta vista no debe depender del layout web normal. Un PDF necesita una estructura propia, con estilos internos simples y compatibles con DomPDF.

### Estructura minima recomendada

```blade
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Productos</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
        }
    </style>
</head>
<body>
    <h1>Reporte de Productos</h1>
</body>
</html>
```

### Por que usar estilos internos

DomPDF trabaja mejor con CSS directo dentro de la misma vista. No siempre interpreta igual los assets externos, frameworks grandes o estilos complejos del navegador.

### Estructura real utilizada en el proyecto

La vista implementada incluye:

- encabezado del reporte,
- fecha de generacion,
- resumen con total de productos,
- stock acumulado,
- valor total del inventario,
- tabla detallada por producto,
- subtotal por cada fila.

### Datos que recibe la vista

```php
[
    'productos' => $productos,
    'fechaGeneracion' => Carbon::now(),
]
```

### Campos mostrados en la tabla

- ID
- Nombre
- Descripcion
- Categoria
- Precio
- Stock
- Subtotal

### Logica importante usada en la vista

#### Conteo total de productos

```blade
{{ $productos->count() }}
```

#### Suma de stock

```blade
{{ $productos->sum('stock') }}
```

#### Valor total del inventario

```blade
{{ number_format($productos->sum(fn ($producto) => $producto->precio * $producto->stock), 2) }}
```

#### Subtotal por producto

```blade
{{ number_format((float) $producto->precio * $producto->stock, 2) }}
```

### Recomendaciones para vistas PDF

1. Usar tablas simples.
2. Evitar componentes Blade complejos.
3. Usar fuentes compatibles como `DejaVu Sans`.
4. No depender de Bootstrap ni de Vite.
5. Mantener el CSS lo mas directo posible.

---

## 12. Paso 6 - Agregar el boton en la interfaz del modulo productos

Archivo:

- `resources/views/productos/index.blade.php`

En la seccion `@section('header_actions')` se agrego un boton nuevo:

```blade
<a href="{{ route('listaproductos.pdf') }}" target="_blank" rel="noopener" class="btn btn-outline-danger d-inline-flex align-items-center gap-2 shadow-sm">
    <i class="bi bi-file-earmark-pdf-fill"></i>
    <span>Reporte PDF</span>
</a>
```

### Explicacion

- `route('listaproductos.pdf')`
  Construye la URL del reporte usando el nombre de ruta.

- `target="_blank"`
  Abre el PDF en una pestaña nueva.

- `rel="noopener"`
  Mejora seguridad al abrir nueva pestaña.

- `btn-outline-danger`
  Da una apariencia visual asociada a documentos PDF.

### Resultado para el usuario

Desde el listado de productos ahora se puede:

1. ver productos,
2. crear productos,
3. abrir el reporte PDF con un clic.

---

## 13. Paso 7 - Crear la prueba funcional

Archivo nuevo:

- `tests/Feature/ProductoReportePdfTest.php`

Las pruebas son importantes porque el PDF no debe quedar solo como funcionalidad visual; tambien debe verificarse su acceso y respuesta HTTP.

### Prueba principal

Se comprobo que un usuario autenticado:

1. pueda entrar a la ruta,
2. reciba respuesta `200`,
3. obtenga cabecera `application/pdf`,
4. reciba contenido PDF real.

### Ejemplo de prueba

```php
public function test_authenticated_user_can_generate_products_pdf_report(): void
{
    $user = User::factory()->create();
    $categoria = Categoria::create([
        'nombre' => 'Lacteos',
        'descripcion' => 'Productos refrigerados',
        'estado' => 'activo',
    ]);

    Producto::create([
        'nombre' => 'Yogurt',
        'descripcion' => 'Envase de 1 litro',
        'precio' => 12.50,
        'stock' => 8,
        'categoria_id' => $categoria->id,
    ]);

    $response = $this
        ->actingAs($user)
        ->get(route('listaproductos.pdf'));

    $response->assertOk();
    $response->assertHeader('content-type', 'application/pdf');
    $response->assertSee('%PDF', false);
}
```

### Prueba de seguridad

Tambien se agrego una prueba para confirmar que un invitado no puede acceder:

```php
public function test_guest_is_redirected_when_trying_to_access_products_pdf_report(): void
{
    $response = $this->get(route('listaproductos.pdf'));

    $response->assertRedirect(route('login'));
}
```

### Que valida esta segunda prueba

Confirma que la ruta del reporte sigue protegida por `auth`.

---

## 14. Paso 8 - Verificar que la ruta exista

Se puede comprobar con:

```bash
php artisan route:list --name=listaproductos.pdf
```

### Resultado esperado

Debe aparecer una fila parecida a esta:

```text
GET|HEAD   listaproductos/reporte/pdf   ...   listaproductos.pdf
```

Eso confirma que Laravel registro correctamente la ruta.

---

## 15. Paso 9 - Ejecutar la prueba del reporte

Comando usado:

```bash
php artisan test --filter=ProductoReportePdfTest
```

### Resultado esperado

```text
PASS  Tests\Feature\ProductoReportePdfTest
+ authenticated user can generate products pdf report
+ guest is redirected when trying to access products pdf report
```

Si estas pruebas pasan, la implementacion basica del reporte esta validada.

---

## 16. Flujo completo de funcionamiento

El flujo final queda asi:

1. El usuario inicia sesion.
2. Entra al modulo `Productos`.
3. Hace clic en `Reporte PDF`.
4. Laravel llama a la ruta `listaproductos.pdf`.
5. La ruta ejecuta `ProductoController@reportePdf`.
6. El controlador consulta productos y categorias.
7. Los datos se envian a `productos.reporte-pdf`.
8. DomPDF renderiza la vista como PDF.
9. El navegador muestra el archivo `reporte-productos.pdf`.

---

## 17. Ventajas de esta implementacion

1. Reutiliza Blade, que ya forma parte del proyecto.
2. Mantiene el reporte dentro del mismo modulo de productos.
3. Conserva la seguridad mediante `auth`.
4. Permite evolucionar despues a filtros, descargas o reportes por categoria.
5. Tiene prueba automatizada para evitar regresiones.

---

## 18. Problemas comunes y soluciones

### Problema 1: La ruta PDF devuelve 404

#### Posibles causas

- La ruta no fue agregada.
- Se puso despues del `Route::resource`.
- El archivo no fue guardado.

#### Solucion

Verificar `routes/web.php` y ejecutar:

```bash
php artisan route:list --name=listaproductos.pdf
```

---

### Problema 2: Error de clase `Pdf` no encontrada

#### Posibles causas

- El paquete no se instalo.
- Composer no actualizo autoload.
- Falta el import del facade.

#### Solucion

1. Revisar `composer.json`.
2. Confirmar:

```php
use Barryvdh\DomPDF\Facade\Pdf;
```

3. Si hace falta:

```bash
composer dump-autoload
```

---

### Problema 3: El PDF sale vacio

#### Posibles causas

- La vista Blade esta mal nombrada.
- No se enviaron datos a la vista.
- Hay error en HTML o CSS del reporte.

#### Solucion

Revisar:

- nombre de vista `productos.reporte-pdf`,
- variables enviadas desde el controlador,
- estructura minima del HTML.

---

### Problema 4: El PDF no muestra bien los estilos

#### Causa frecuente

DomPDF no interpreta igual de bien todos los estilos modernos del navegador.

#### Solucion

- usar CSS simple,
- usar tablas directas,
- evitar layouts complejos,
- usar fuentes compatibles.

---

## 19. Posibles mejoras futuras

Una vez funcionando el reporte base, se puede extender con:

1. filtro por categoria,
2. filtro por rango de fechas,
3. descarga automatica en vez de vista previa,
4. encabezado con logo institucional,
5. pie de pagina con numeracion,
6. reportes separados por categoria,
7. exportacion adicional a Excel.

---

## 20. Resumen tecnico final

La implementacion del reporte PDF en `practica_1` se resolvio con esta secuencia:

1. instalar `barryvdh/laravel-dompdf`,
2. crear la ruta `listaproductos/reporte/pdf`,
3. agregar `reportePdf()` en `ProductoController`,
4. crear `resources/views/productos/reporte-pdf.blade.php`,
5. agregar boton en `resources/views/productos/index.blade.php`,
6. validar con `ProductoReportePdfTest`.

Con esto, el modulo `Productos` ya tiene una salida PDF funcional, protegida y verificable.

---

## 21. Archivos finales de referencia

- `composer.json`
- `routes/web.php`
- `app/Http/Controllers/ProductoController.php`
- `resources/views/productos/index.blade.php`
- `resources/views/productos/reporte-pdf.blade.php`
- `tests/Feature/ProductoReportePdfTest.php`

---

## 22. Conclusion

El reporte PDF no se agrega solo como una vista nueva. En Laravel forma parte de un flujo completo:

- dependencia instalada,
- ruta dedicada,
- controlador con consulta de datos,
- vista especializada para PDF,
- acceso desde interfaz,
- prueba automatizada.

Ese enfoque deja una implementacion ordenada, mantenible y coherente con la arquitectura del proyecto `practica_1`.
