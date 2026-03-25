# Guía Didáctica: Módulo II - Gestión de Productos en Laravel

## 1. Diagnóstico breve del proyecto

El proyecto `practica_1` está construido en Laravel y ya cuenta con una base funcional organizada bajo la estructura típica del framework:

- `app/` contiene los controladores y modelos.
- `routes/` define las rutas web del sistema.
- `database/migrations/` contiene la estructura de las tablas.
- `resources/views/` almacena las vistas Blade.
- `public/css/` contiene el estilo visual compartido del panel.

### Base actual del sistema

Después de revisar el proyecto, la base actual del sistema está formada por dos módulos principales activos:

1. `Categorías`
2. `Productos`

También existe un controlador y vistas de `calificaciones`, pero ese bloque no forma parte del sistema principal actual porque sus rutas están comentadas en `routes/web.php`.

### Estructura relevante del proyecto

#### Controladores

- `app/Http/Controllers/CategoriaController.php`
- `app/Http/Controllers/ProductoController.php`
- `app/Http/Controllers/CalificacionesController.php`

#### Modelos

- `app/Models/Categoria.php`
- `app/Models/Producto.php`

#### Migraciones

- `database/migrations/2026_03_10_141632_create_categorias_table.php`
- `database/migrations/2026_03_10_143525_create_productos_table.php`

#### Vistas Blade

- `resources/views/layouts/app.blade.php`
- `resources/views/categorias/index.blade.php`
- `resources/views/categorias/create.blade.php`
- `resources/views/categorias/edit.blade.php`
- `resources/views/productos/index.blade.php`
- `resources/views/productos/create.blade.php`
- `resources/views/productos/edit.blade.php`

#### Layout compartido

El sistema usa un layout común:

- `resources/views/layouts/app.blade.php`

Este layout define:

- la barra lateral del sistema,
- el encabezado del módulo,
- el área principal de contenido,
- los enlaces a categorías y productos,
- la carga del CSS compartido en `public/css/estilo.css`.

### Rutas activas del sistema

En `routes/web.php` se definen dos recursos principales:

```php
Route::resource('listacategorias', CategoriaController::class);
Route::resource('listaproductos', ProductoController::class);
```

Esto significa que Laravel genera automáticamente las rutas del CRUD para ambos módulos:

- `index`
- `create`
- `store`
- `show`
- `edit`
- `update`
- `destroy`

### Relación entre categorías y productos

Sí existe relación entre categorías y productos.

#### En el modelo `Producto`

```php
public function categoria()
{
    return $this->belongsTo(Categoria::class);
}
```

Esto indica que:

- cada producto pertenece a una categoría.

#### En el modelo `Categoria`

```php
public function producto()
{
    return $this->hasMany(Producto::class);
}
```

Esto indica que:

- una categoría puede tener muchos productos.

#### En la migración de productos

La tabla `productos` tiene una clave foránea:

```php
$table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
```

Esto confirma que:

- `productos.categoria_id` apunta a `categorias.id`,
- si se elimina una categoría, sus productos relacionados también se eliminan.

---

## 2. Identificación del Módulo II

El módulo que corresponde de forma más coherente al **Módulo II** es **Productos**.

### Justificación

Si el módulo de categorías fue trabajado primero como Módulo I, entonces productos es la continuación natural porque:

1. reutiliza el mismo flujo CRUD,
2. añade un nuevo nivel de dificultad,
3. introduce relaciones entre tablas,
4. obliga a trabajar con claves foráneas,
5. enseña cómo Laravel conecta módulos entre sí.

Pedagógicamente, este orden es correcto:

1. primero se enseña un CRUD simple: `categorías`,
2. luego se enseña un CRUD relacionado: `productos`.

El módulo `calificaciones` no resulta más coherente como Módulo II porque:

- no forma parte del panel activo,
- sus rutas están comentadas,
- no participa de la organización central del sistema actual.

Por tanto, para este proyecto:

- **Módulo I = Categorías**
- **Módulo II = Productos**

---

## 3. Revisión detallada del Módulo II: Productos

## A. Título de la práctica

**Desarrollo del Módulo II: Gestión de Productos con relación a Categorías en Laravel**

## B. Objetivo general

Desarrollar el módulo de productos del sistema usando Laravel, comprendiendo el flujo MVC completo, la validación de formularios, las relaciones entre modelos y la interacción entre rutas, controlador, modelo, migración y vistas.

## C. Objetivos específicos

- Identificar qué archivos participan en el módulo de productos.
- Comprender cómo se implementa el CRUD de productos.
- Relacionar productos con categorías mediante Eloquent.
- Entender el flujo MVC a partir del código real del proyecto.
- Analizar cómo Laravel resuelve rutas, formularios y consultas.
- Aplicar buenas prácticas básicas de validación y organización.

## D. Requisitos previos

Antes de desarrollar este módulo, el estudiante debe:

- haber revisado el módulo de categorías,
- entender qué es un CRUD,
- conocer la estructura básica de un proyecto Laravel,
- saber qué es una tabla, una clave primaria y una clave foránea,
- comprender formularios HTML básicos,
- tener Laravel y la base de datos funcionando correctamente.

## E. Archivos que intervienen

### 1. Rutas

- `routes/web.php`

### 2. Controlador principal del módulo

- `app/Http/Controllers/ProductoController.php`

### 3. Modelos relacionados

- `app/Models/Producto.php`
- `app/Models/Categoria.php`

### 4. Migración principal

- `database/migrations/2026_03_10_143525_create_productos_table.php`

### 5. Vistas del módulo

- `resources/views/productos/index.blade.php`
- `resources/views/productos/create.blade.php`
- `resources/views/productos/edit.blade.php`

### 6. Layout compartido

- `resources/views/layouts/app.blade.php`

## F. Explicación del funcionamiento del módulo

El módulo de productos permite:

- listar productos,
- registrar nuevos productos,
- editar productos existentes,
- eliminar productos,
- asociar cada producto a una categoría.

Este módulo depende del módulo de categorías porque un producto no se registra de manera aislada: necesita una categoría para poder guardarse correctamente.

### Flujo general del módulo

El flujo MVC del módulo funciona así:

1. El usuario entra a una URL del módulo, por ejemplo `/listaproductos`.
2. Laravel revisa `routes/web.php`.
3. La ruta envía la petición al método correspondiente de `ProductoController`.
4. El controlador interactúa con el modelo `Producto`.
5. Si el caso lo requiere, también consulta el modelo `Categoria`.
6. El controlador devuelve una vista Blade y le envía datos.
7. La vista muestra la información al usuario.
8. Si el usuario envía un formulario, el controlador valida y guarda en la base de datos.

### Cómo interactúan las capas MVC en este módulo

#### Rutas

Las rutas están definidas con:

```php
Route::resource('listaproductos', ProductoController::class);
```

Laravel genera automáticamente las rutas del CRUD.

#### Controlador

El controlador coordina toda la lógica del módulo:

- consulta productos,
- consulta categorías,
- valida datos,
- guarda productos,
- actualiza productos,
- elimina registros,
- devuelve vistas.

#### Modelo

El modelo `Producto` representa la tabla `productos` y define:

- los campos que se pueden guardar,
- la relación con `Categoria`.

#### Migración

La migración crea la tabla `productos` en la base de datos y establece la relación con `categorias`.

#### Vistas

Las vistas Blade presentan:

- el listado,
- el formulario de registro,
- el formulario de edición.

#### Layout

El layout compartido mantiene la estructura visual uniforme del sistema.

## G. Desarrollo paso a paso

### Paso 1. Revisar la ruta del módulo

En `routes/web.php` se encuentra:

```php
Route::resource('listaproductos', ProductoController::class);
```

Esta sola línea genera todas las rutas del CRUD.

Algunas de las más importantes son:

- `GET /listaproductos` para listar
- `GET /listaproductos/create` para mostrar formulario
- `POST /listaproductos` para guardar
- `GET /listaproductos/{listaproducto}/edit` para editar
- `PUT /listaproductos/{listaproducto}` para actualizar
- `DELETE /listaproductos/{listaproducto}` para eliminar

### Paso 2. Revisar la estructura de la tabla productos

En la migración `2026_03_10_143525_create_productos_table.php` se define:

```php
Schema::create('productos', function (Blueprint $table) {
    $table->id();
    $table->string('nombre', 100);
    $table->text('descripcion');
    $table->decimal('precio');
    $table->integer('stock');
    $table->foreignId('categoria_id')->constrained('categorias')->onDelete('cascade');
    $table->timestamps();
});
```

Esta migración enseña conceptos importantes:

- creación de tabla,
- tipos de columnas,
- clave primaria,
- clave foránea,
- relación con otra tabla,
- borrado en cascada.

### Paso 3. Revisar el modelo `Producto`

En `app/Models/Producto.php` se observa:

```php
protected $fillable = ['nombre','descripcion','precio','stock','categoria_id'];
```

Esto permite guardar esos campos con `create()` y `update()`.

También define la relación:

```php
public function categoria()
{
    return $this->belongsTo(Categoria::class);
}
```

Esto significa que un producto pertenece a una categoría.

### Paso 4. Revisar el método `index()`

En `ProductoController`:

```php
public function index()
{
    $productos = Producto::with('categoria')->get();
    return view('productos.index', compact('productos'));
}
```

Aquí ocurre lo siguiente:

1. se consultan todos los productos,
2. se carga también su categoría relacionada,
3. se envían a la vista `productos.index`.

La instrucción `with('categoria')` es importante porque evita hacer consultas repetidas al mostrar la categoría de cada producto en la tabla.

### Paso 5. Revisar el método `create()`

```php
public function create()
{
    $categorias = Categoria::all();
    return view('productos.create', compact('categorias'));
}
```

Aquí el controlador:

- consulta todas las categorías,
- las envía a la vista,
- prepara el formulario para que el usuario pueda elegir una categoría.

Sin este paso, el formulario no podría mostrar el `<select>` de categorías.

### Paso 6. Revisar el método `store()`

```php
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
```

Este método enseña varios conceptos importantes:

- recepción del formulario,
- validación,
- seguridad al guardar,
- inserción en base de datos,
- redirección con mensaje de sesión.

La validación de `categoria_id` garantiza que el producto quede asociado a una categoría real.

### Paso 7. Revisar la vista `create.blade.php`

La vista contiene el formulario de registro.

Elementos importantes:

- `@csrf` protege el formulario,
- el `action` apunta a `listaproductos.store`,
- existe un `<select>` para `categoria_id`,
- se usa `old()` para conservar datos si ocurre un error.

Fragmento clave:

```php
<select class="form-select" name="categoria_id" id="categoria_id" required>
    <option value="">Seleccione una categoría</option>
    @foreach($categorias as $categoria)
        <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
            {{ $categoria->nombre }}
        </option>
    @endforeach
</select>
```

Este bloque demuestra cómo una vista Blade puede mostrar datos provenientes de otro modelo.

### Paso 8. Revisar el método `edit()`

```php
public function edit(Producto $listaproducto)
{
    $categorias = Categoria::all();
    $producto = $listaproducto;
    return view('productos.edit', compact('producto', 'categorias'));
}
```

Laravel usa **Route Model Binding** para recibir automáticamente el producto desde la URL.

Además:

- vuelve a cargar categorías,
- envía el producto actual,
- prepara el formulario de edición.

### Paso 9. Revisar el método `update()`

```php
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
```

Este método repite el patrón del `store()`, pero ahora actualiza un registro existente.

### Paso 10. Revisar la vista `edit.blade.php`

La vista de edición:

- recibe el producto actual,
- muestra los datos en el formulario,
- conserva la categoría seleccionada,
- envía la petición como `PUT`.

Fragmento clave:

```php
@method('PUT')
```

Esto es necesario porque HTML solo envía `GET` y `POST`. Laravel simula el método `PUT` con esta directiva.

### Paso 11. Revisar el método `destroy()`

```php
public function destroy(Producto $listaproducto)
{
    $listaproducto->delete();

    return redirect()->route('listaproductos.index')
        ->with('success', 'Producto eliminado exitosamente');
}
```

Aquí el controlador:

- recibe el producto,
- lo elimina,
- redirige al listado.

### Paso 12. Revisar la vista `index.blade.php`

El listado muestra:

- id,
- nombre,
- descripción,
- precio,
- stock,
- categoría,
- acciones.

Fragmento clave:

```php
{{ $producto->categoria->nombre ?? 'Sin categoría' }}
```

Esto permite mostrar el nombre de la categoría relacionada directamente desde el producto.

## H. Código clave explicado

### 1. Ruta resource

```php
Route::resource('listaproductos', ProductoController::class);
```

Genera automáticamente el CRUD del módulo.

### 2. Carga de relación

```php
$productos = Producto::with('categoria')->get();
```

Permite listar productos mostrando su categoría sin hacer consultas innecesarias desde la vista.

### 3. Relación `belongsTo`

```php
return $this->belongsTo(Categoria::class);
```

Hace posible acceder a la categoría de un producto.

### 4. Validación del formulario

```php
'categoria_id' => 'required|exists:categorias,id',
```

Garantiza que la categoría seleccionada exista.

### 5. Creación del producto

```php
Producto::create($data);
```

Inserta el producto en la base de datos usando datos validados.

### 6. Actualización del producto

```php
$listaproducto->update($data);
```

Modifica los datos del producto seleccionado.

### 7. Eliminación

```php
$listaproducto->delete();
```

Elimina el producto correspondiente.

## I. Actividades prácticas para el estudiante

1. Identificar en `routes/web.php` todas las rutas que Laravel genera para productos.
2. Explicar con sus palabras qué hace `with('categoria')`.
3. Crear una categoría y luego registrar un producto asociado a ella.
4. Editar un producto y cambiar su categoría.
5. Eliminar un producto desde la tabla del listado.
6. Dibujar el flujo MVC del módulo productos.
7. Comparar el módulo categorías con el módulo productos e indicar qué dificultad adicional introduce productos.

## J. Preguntas de reflexión o evaluación

1. ¿Por qué el módulo productos depende del módulo categorías?
2. ¿Qué función cumple `categoria_id` en la tabla productos?
3. ¿Qué ventaja tiene `Route::resource()`?
4. ¿Qué sucede si se intenta guardar un producto con una categoría inexistente?
5. ¿Qué diferencia existe entre `belongsTo` y `hasMany`?
6. ¿Por qué el controlador envía categorías a las vistas `create` y `edit`?
7. ¿Qué papel cumple `@csrf` en los formularios?
8. ¿Por qué se usa `@method('PUT')` en edición?

## K. Errores comunes y cómo corregirlos

### Error 1. No cargar categorías en el formulario

**Problema:** el formulario de productos no muestra opciones en el select.  
**Causa:** no se envió `$categorias` desde el controlador.  
**Corrección:** usar:

```php
$categorias = Categoria::all();
return view('productos.create', compact('categorias'));
```

### Error 2. Usar nombres incorrectos de rutas

**Problema:** la redirección falla o el enlace no funciona.  
**Causa:** se usa un nombre de ruta que no corresponde al `resource`.  
**Corrección:** usar nombres como:

- `listaproductos.index`
- `listaproductos.create`
- `listaproductos.store`

### Error 3. No validar `categoria_id`

**Problema:** se intenta guardar un producto con una categoría inválida.  
**Corrección:** incluir:

```php
'categoria_id' => 'required|exists:categorias,id',
```

### Error 4. No definir `$fillable`

**Problema:** `create()` o `update()` no guardan correctamente.  
**Corrección:** revisar:

```php
protected $fillable = ['nombre','descripcion','precio','stock','categoria_id'];
```

### Error 5. No entender la relación entre módulos

**Problema:** se ve productos como un CRUD aislado.  
**Corrección:** recordar que productos es un módulo relacional y depende de categorías.

### Error 6. Confundir el parámetro del route model binding

**Problema:** el método del controlador no recibe correctamente el producto.  
**Corrección:** respetar el nombre usado por la ruta resource:

```php
public function edit(Producto $listaproducto)
```

## L. Resultado esperado

Al finalizar la práctica, el estudiante deberá ser capaz de:

- comprender el módulo de productos dentro del proyecto real,
- explicar el flujo MVC usando el código del sistema,
- desarrollar y mantener un CRUD con relación a otra tabla,
- crear formularios con datos relacionados,
- validar correctamente la entrada del usuario,
- diferenciar entre lógica de rutas, controlador, modelo y vistas.

---

## 4. Flujo completo del CRUD de productos

### Caso 1. Listar productos

1. El usuario entra a `/listaproductos`.
2. Laravel ejecuta `index()`.
3. El controlador consulta `Producto::with('categoria')->get()`.
4. Envía `$productos` a `productos.index`.
5. La vista muestra la tabla.

### Caso 2. Crear producto

1. El usuario entra a `/listaproductos/create`.
2. Laravel ejecuta `create()`.
3. El controlador consulta categorías.
4. La vista muestra el formulario.
5. El usuario completa datos y envía el formulario.
6. Laravel ejecuta `store()`.
7. Se validan los datos.
8. Se crea el producto.
9. Se redirige al listado.

### Caso 3. Editar producto

1. El usuario entra a `/listaproductos/{id}/edit`.
2. Laravel ejecuta `edit()`.
3. Resuelve el producto por Route Model Binding.
4. Carga categorías.
5. Muestra el formulario con datos actuales.
6. El usuario envía cambios.
7. Laravel ejecuta `update()`.
8. Se validan datos.
9. Se actualiza el producto.
10. Se redirige al listado.

### Caso 4. Eliminar producto

1. El usuario pulsa el botón eliminar.
2. El formulario envía `DELETE`.
3. Laravel ejecuta `destroy()`.
4. El producto se elimina.
5. Se redirige al listado.

---

## 5. Conceptos de Laravel que aprende el estudiante en este módulo

Este módulo permite enseñar, en contexto real, los siguientes conceptos:

- `Route::resource`
- patrón MVC
- controladores REST
- modelos Eloquent
- relaciones `belongsTo` y `hasMany`
- migraciones
- claves foráneas
- validación con `$request->validate()`
- asignación masiva con `$fillable`
- vistas Blade
- `@extends`, `@section`, `@csrf`, `@method`
- mensajes flash con `with('success', ...)`
- redirecciones con `redirect()->route(...)`
- route model binding

---

## 6. Sugerencia de secuencia de trabajo para los estudiantes

Para evitar que el estudiante se pierda durante la construcción del módulo, se recomienda seguir este orden:

### Primero

Revisar el módulo de categorías y comprobar que ya se entiende el CRUD básico.

### Segundo

Analizar la migración de productos para entender qué campos existen y cómo se relacionan con categorías.

### Tercero

Revisar el modelo `Producto` y su relación con `Categoria`.

### Cuarto

Estudiar las rutas resource de productos para reconocer todas las acciones del CRUD.

### Quinto

Leer `ProductoController` método por método:

- `index()`
- `create()`
- `store()`
- `edit()`
- `update()`
- `destroy()`

### Sexto

Observar cómo las vistas `create` y `edit` usan las categorías dentro del `<select>`.

### Séptimo

Revisar la vista `index` para comprender cómo se muestra la relación:

```php
$producto->categoria->nombre
```

### Octavo

Probar el CRUD completo desde el navegador:

- listar,
- crear,
- editar,
- eliminar.

### Noveno

Explicar el flujo completo de una petición usando un ejemplo concreto:

- URL,
- ruta,
- controlador,
- modelo,
- base de datos,
- vista.

### Décimo

Comparar el módulo de categorías con el de productos para identificar qué nuevos conceptos introduce el Módulo II.

---

## 7. Conclusión docente

El proyecto `practica_1` ya contiene la base necesaria para enseñar el desarrollo modular en Laravel. La secuencia pedagógica más sólida consiste en trabajar primero el CRUD de categorías y luego el CRUD de productos.

El módulo de productos es ideal como **Módulo II** porque no solo repite la mecánica del CRUD, sino que introduce un elemento clave en el aprendizaje de Laravel: la relación entre modelos y tablas.

Por eso, este módulo permite que el estudiante avance desde un CRUD básico hacia un CRUD relacional, comprendiendo de manera concreta cómo Laravel implementa el patrón MVC en un sistema real.
