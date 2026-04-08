# Guía de Laboratorio 02: Módulo Categorías (CRUD Base)

## A. Objetivo de la Práctica
Comprender el paradigma MVC (Modelo-Vista-Controlador) construyendo un administrador funcional de Categorías para el inventario, incluyendo el esqueleto estructural y de diseño del sistema.

## B. Prerrequisitos
- Laboratorio 01 Finalizado (Autenticación operativa).
- Conceptos básicos de Rutas (`routes/web.php`).

## C. Desarrollo Paso a Paso

### 1. Generación del Archipiélago MVC
Ejecute el comando para crear mágicamente el Modelo, la Migración y el Controlador:
```bash
php artisan make:model Categoria -mc
```

### 2. Migración (Estructura de Base de Datos)
Abra la migración generada en `database/migrations/` y determine los campos:
```php
$table->id();
$table->string('nombre', 100);
$table->text('descripcion')->nullable();
$table->enum('estado', ['activo','inactivo'])->default('activo');
$table->timestamps();
```
Ejecute: `php artisan migrate`

### 3. Modificación del Modelo
En `app/Models/Categoria.php`, habilite la protección de asignación masiva:
```php
protected $fillable = ['nombre', 'descripcion', 'estado'];
```

### 4. Lógica del Controlador y Rutas
En `routes/web.php` proteja el servidor:
```php
Route::middleware('auth')->group(function () {
    Route::resource('categorias', CategoriaController::class);
});
```

En `CategoriaController.php`, programe al menos el método `index` para visualizar:
```php
public function index() {
    $categorias = Categoria::all();
    return view('categorias.index', compact('categorias'));
}
```

## D. Resultado Esperado
El estudiante será capaz de construir un panel de administración capaz de Crear, Leer, Actualizar y Eliminar (CRUD) categorías, visualizándolas en una tabla HTML utilizando clases de Bootstrap.
