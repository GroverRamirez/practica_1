# Guía de Laboratorio 03: Productos (Relaciones Foráneas)

## A. Objetivo de la Práctica
Elevar la complejidad lógica al integrar dos entidades independientes. Se creará el módulo de Productos, el cual estará estrictamente atado a la existencia de una Categoría Padre utilizando aspas foráneas ("Foreign Keys").

## B. Prerrequisitos
- Módulo de Categorías operando al 100%.

## C. Desarrollo Paso a Paso

### 1. Modelo y Migración Foránea
Ejecute `php artisan make:model Producto -mc`.
Dentro de la migración del Producto, añada el enlace foráneo:
```php
$table->id();
$table->string('nombre', 100);
$table->text('descripcion');
$table->decimal('precio');
$table->integer('stock');

// LLAVE FORÁNEA (Vital)
$table->foreignId('categoria_id')->constrained('categorias')->onDelete('restrict');
$table->timestamps();
```

### 2. Declarando la Familia (Eloquent Relationships)
Abra `app/Models/Producto.php` y enlázelo a Categoría:
```php
protected $fillable = ['nombre', 'descripcion', 'precio', 'stock', 'categoria_id'];

public function categoria() {
    return $this->belongsTo(Categoria::class);
}
```
Abra `app/Models/Categoria.php` y enlázelo hacia Productos (Uno a Muchos):
```php
public function productos() {
    return $this->hasMany(Producto::class);
}
```

### 3. Filtros Lógicos en Creación
Al momento de que el usuario envíe las variables a la vista para "Crear Producto", asegúrese de mostrar solo las categorías habilitadas y no las inútiles (`CategoriaController@create`):
```php
$categorias = Categoria::where('estado', 'activo')->get();
return view('productos.create', compact('categorias'));
```

## D. Resultado Esperado
Un formulario HTML que cuenta con un menú `<select>` alimentado directamente por la base de datos de categorías activas. Imposibilidad total de crear un producto si no existe una categoría válida asignada.
