# Guia de Laboratorio: Modulo de Categorias en Laravel

## 1. Datos de la practica

- Proyecto: `practica_1`
- Modulo: `Categorias`
- Framework: Laravel
- Tema principal: CRUD con rutas resource, controlador, modelo, migracion y vistas Blade

## 2. Proposito de la guia

Esta guia tiene como objetivo ayudar al estudiante a comprender como funciona un modulo CRUD real en Laravel usando el ejemplo de categorias. Al finalizar la practica, el estudiante deberia ser capaz de:

- Identificar los archivos que forman un modulo CRUD.
- Explicar la responsabilidad de cada archivo.
- Seguir el flujo completo de crear, listar, editar y eliminar registros.
- Detectar errores comunes de implementacion.
- Proponer mejoras tecnicas y de organizacion.

## 3. Requisitos previos

Antes de iniciar, el estudiante debe conocer:

- Conceptos basicos de PHP.
- Estructura general de un proyecto Laravel.
- Uso basico de rutas, controladores y vistas.
- Concepto de base de datos relacional.
- Comandos basicos como `php artisan migrate` y `php artisan route:list`.

## 4. Archivos del modulo

### Archivos principales

1. [routes/web.php](C:/laragon/www/practica_1/routes/web.php)
2. [app/Http/Controllers/CategoriaController.php](C:/laragon/www/practica_1/app/Http/Controllers/CategoriaController.php)
3. [app/Models/Categoria.php](C:/laragon/www/practica_1/app/Models/Categoria.php)
4. [database/migrations/2026_03_10_141632_create_categorias_table.php](C:/laragon/www/practica_1/database/migrations/2026_03_10_141632_create_categorias_table.php)
5. [resources/views/listacategorias.blade.php](C:/laragon/www/practica_1/resources/views/listacategorias.blade.php)
6. [resources/views/createcategorias.blade.php](C:/laragon/www/practica_1/resources/views/createcategorias.blade.php)
7. [resources/views/editcategorias.blade.php](C:/laragon/www/practica_1/resources/views/editcategorias.blade.php)

### Archivos relacionados indirectamente

1. [database/migrations/2026_03_10_143525_create_productos_table.php](C:/laragon/www/practica_1/database/migrations/2026_03_10_143525_create_productos_table.php)
2. [app/Models/Producto.php](C:/laragon/www/practica_1/app/Models/Producto.php)
3. [app/Http/Controllers/ProductoController.php](C:/laragon/www/practica_1/app/Http/Controllers/ProductoController.php)
4. [storage/logs/laravel.log](C:/laragon/www/practica_1/storage/logs/laravel.log)

## 5. Funcion de cada archivo

### 5.1 Rutas

Archivo: [routes/web.php](C:/laragon/www/practica_1/routes/web.php)

Este archivo define las URL del sistema. En este modulo se usa:

```php
Route::resource('listacategorias', CategoriaController::class);
```

Esta sola linea genera automaticamente las rutas del CRUD:

- `GET /listacategorias`
- `GET /listacategorias/create`
- `POST /listacategorias`
- `GET /listacategorias/{listacategoria}`
- `GET /listacategorias/{listacategoria}/edit`
- `PUT/PATCH /listacategorias/{listacategoria}`
- `DELETE /listacategorias/{listacategoria}`

### 5.2 Controlador

Archivo: [app/Http/Controllers/CategoriaController.php](C:/laragon/www/practica_1/app/Http/Controllers/CategoriaController.php)

El controlador recibe la peticion del usuario y decide que hacer. Sus metodos principales son:

- `index()`: obtiene todas las categorias y las envia a la vista de listado.
- `create()`: muestra el formulario para registrar una categoria.
- `store()`: guarda una categoria nueva en la base de datos.
- `edit()`: carga una categoria existente para modificarla.
- `update()`: actualiza los datos de una categoria.
- `destroy()`: elimina una categoria.
- `show()`: existe, pero no esta implementado.

### 5.3 Modelo

Archivo: [app/Models/Categoria.php](C:/laragon/www/practica_1/app/Models/Categoria.php)

El modelo representa la tabla `categorias` de la base de datos. Tambien define:

- Los campos que se pueden asignar de forma masiva con `$fillable`.
- La relacion entre categorias y productos.

En este caso, una categoria puede tener muchos productos.

### 5.4 Migracion

Archivo: [database/migrations/2026_03_10_141632_create_categorias_table.php](C:/laragon/www/practica_1/database/migrations/2026_03_10_141632_create_categorias_table.php)

La migracion crea la tabla `categorias` con estos campos:

- `id`
- `nombre`
- `descripcion`
- `estado`
- `created_at`
- `updated_at`

### 5.5 Vistas Blade

Archivo: [resources/views/listacategorias.blade.php](C:/laragon/www/practica_1/resources/views/listacategorias.blade.php)

Muestra la tabla con todas las categorias y las acciones de editar y eliminar.

Archivo: [resources/views/createcategorias.blade.php](C:/laragon/www/practica_1/resources/views/createcategorias.blade.php)

Muestra el formulario para registrar una nueva categoria.

Archivo: [resources/views/editcategorias.blade.php](C:/laragon/www/practica_1/resources/views/editcategorias.blade.php)

Muestra el formulario para modificar una categoria existente.

## 6. Flujo CRUD completo

## 6.1 Read: listar categorias

Paso 1. El usuario entra a la URL:

```text
/listacategorias
```

Paso 2. Laravel busca la ruta en `web.php`.

Paso 3. La ruta ejecuta el metodo `index()` del controlador.

Paso 4. El controlador hace la consulta:

```php
$categorias = Categoria::all();
```

Paso 5. Los datos se envian a la vista:

```php
return view('listacategorias', compact('categorias'));
```

Paso 6. La vista recorre la coleccion y genera la tabla HTML.

## 6.2 Create: crear una categoria

Paso 1. El usuario hace clic en el boton "Nueva Categoria".

Paso 2. Se abre la ruta:

```text
/listacategorias/create
```

Paso 3. El metodo `create()` retorna la vista del formulario.

Paso 4. El estudiante llena los campos:

- nombre
- descripcion
- estado

Paso 5. El formulario envia un `POST` a:

```text
/listacategorias
```

Paso 6. El metodo `store()` recibe la informacion y ejecuta:

```php
Categoria::create($data);
```

Paso 7. Laravel guarda el registro en la tabla `categorias`.

Paso 8. El sistema redirige al listado y muestra un mensaje de exito.

## 6.3 Update: editar una categoria

Paso 1. En el listado, el usuario pulsa el boton "Editar".

Paso 2. Se accede a:

```text
/listacategorias/{id}/edit
```

Paso 3. Laravel usa route model binding y busca automaticamente la categoria.

Paso 4. El metodo `edit()` envia esa categoria a la vista de edicion.

Paso 5. El formulario carga los datos actuales.

Paso 6. El usuario modifica los valores y envia el formulario.

Paso 7. El formulario usa `@method('PUT')` para simular una peticion `PUT`.

Paso 8. El metodo `update()` valida y actualiza la categoria.

Paso 9. El sistema redirige al listado con mensaje de confirmacion.

## 6.4 Delete: eliminar una categoria

Paso 1. En el listado, el usuario pulsa "Eliminar".

Paso 2. Se envia un formulario `POST` con:

```php
@method('DELETE')
```

Paso 3. Laravel interpreta la peticion como `DELETE`.

Paso 4. El metodo `destroy()` recibe la categoria y ejecuta:

```php
$listacategoria->delete();
```

Paso 5. El registro se elimina de la base de datos.

Paso 6. El usuario vuelve al listado con un mensaje de exito.

## 7. Explicacion didactica del modulo

### 7.1 Como se conectan las piezas

En Laravel, un modulo CRUD normalmente trabaja asi:

1. La ruta recibe la URL.
2. La ruta llama a un metodo del controlador.
3. El controlador se comunica con el modelo.
4. El modelo trabaja sobre la tabla de la base de datos.
5. El controlador devuelve una vista.
6. La vista muestra la informacion al usuario.

### 7.2 Papel de cada capa

- Ruta: dice que URL existe y quien la atiende.
- Controlador: contiene la logica del proceso.
- Modelo: representa los datos y las relaciones.
- Vista: construye la interfaz visible.
- Migracion: define la estructura de la tabla.

### 7.3 Que debe observar el estudiante

Mientras revisa este modulo, el estudiante debe fijarse en:

- Como `Route::resource()` evita escribir todas las rutas manualmente.
- Como `compact('categorias')` envia datos a la vista.
- Como `@csrf` protege los formularios.
- Como `@method('PUT')` y `@method('DELETE')` simulan metodos HTTP que HTML no envia por defecto.
- Como `$fillable` protege contra asignacion masiva.
- Como Laravel inyecta automaticamente una categoria usando route model binding.

## 8. Posibles errores encontrados y mejoras propuestas

## 8.1 Errores o debilidades observadas

### 1. Falta validacion en `store()`

En `store()` se usa:

```php
$data = $request->all();
```

Esto no es lo ideal para un modulo formativo, porque el estudiante deberia ver validacion explicita antes de guardar.

### 2. El metodo `show()` no esta implementado

La ruta existe, pero el metodo no hace nada. Eso puede confundir a los estudiantes porque parece parte del CRUD completo, pero no se usa.

### 3. La relacion del modelo `Categoria` podria llamarse mejor

Actualmente el metodo se llama:

```php
public function producto()
```

Como una categoria tiene muchos productos, seria mas claro usar:

```php
public function productos()
```

### 4. La relacion en `Producto.php` esta mal escrita

Actualmente aparece:

```php
return $this->belongsTo('Categoria::class');
```

La forma correcta es:

```php
return $this->belongsTo(Categoria::class);
```

### 5. El modulo de productos no esta implementado

En las vistas aparece un enlace a productos, pero en las rutas activas no existe un modulo funcional de productos. Eso puede generar confusion o enlaces vacios.

### 6. No se muestran errores de validacion en pantalla

Los formularios usan `old()`, lo cual esta bien, pero no imprimen mensajes de error para orientar al usuario.

### 7. Codigo repetido en las vistas

Las tres vistas de categorias repiten gran parte del HTML del menu y la estructura general. Seria mejor usar una plantilla comun con `@extends` y `@section`.

## 8.2 Mejoras recomendadas

- Agregar validacion tambien en `store()`.
- Implementar o eliminar `show()`.
- Renombrar la relacion `producto()` a `productos()`.
- Corregir la relacion en el modelo `Producto`.
- Crear un layout comun para las vistas.
- Mostrar mensajes de error de validacion en cada formulario.
- Agregar paginacion en lugar de `Categoria::all()` cuando haya muchos datos.
- Agregar pruebas automatizadas del CRUD.

## 9. Actividades sugeridas para el laboratorio

### Actividad 1. Identificacion de archivos

Instruccion:

Ubica los archivos del modulo de categorias y explica con tus palabras que responsabilidad cumple cada uno.

Producto esperado:

Un cuadro o lista con archivo y funcion.

### Actividad 2. Seguimiento del flujo

Instruccion:

Sigue el recorrido que hace Laravel cuando el usuario presiona "Nueva Categoria" y luego "Guardar".

Producto esperado:

Un diagrama simple o una secuencia escrita paso a paso.

### Actividad 3. Deteccion de errores

Instruccion:

Revisa el controlador y detecta al menos tres puntos que pueden mejorarse.

Producto esperado:

Una lista de errores o mejoras justificadas.

### Actividad 4. Mejora guiada

Instruccion:

Modifica el metodo `store()` para que valide los datos antes de guardar.

Sugerencia:

```php
$data = $request->validate([
    'nombre' => 'required|string|max:100',
    'descripcion' => 'nullable|string',
    'estado' => 'required|in:activo,inactivo',
]);
```

### Actividad 5. Reflexion final

Pregunta:

Por que es importante separar rutas, controladores, modelos y vistas en una aplicacion MVC?

## 10. Preguntas para evaluar al estudiante

1. Que ventaja ofrece `Route::resource()`?
2. Para que sirve `$fillable` en un modelo?
3. Que funcion cumple `@csrf` en un formulario?
4. Cual es la diferencia entre `create()` y `store()`?
5. Que hace el metodo `edit()`?
6. Por que en HTML se usa `@method('PUT')` o `@method('DELETE')`?
7. Que riesgo existe si se usa `$request->all()` sin validacion?
8. Que significa que una categoria tenga muchos productos?

## 11. Conclusion

El modulo de categorias es un buen ejemplo para explicar el patron MVC en Laravel, porque muestra claramente como se relacionan las rutas, el controlador, el modelo, la migracion y las vistas. Tambien es util pedagogicamente porque no es perfecto: contiene decisiones correctas y varios puntos mejorables. Eso lo convierte en un excelente material para que los estudiantes no solo copien codigo, sino que aprendan a analizarlo, cuestionarlo y mejorarlo.

## 12. Tarea opcional

Como trabajo complementario, el estudiante puede:

- Implementar el metodo `show()`.
- Corregir la relacion con productos.
- Crear el modulo de productos.
- Reutilizar un layout comun para evitar duplicacion.
- Agregar mensajes de error visibles en los formularios.
