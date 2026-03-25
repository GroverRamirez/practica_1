# Guía Paso a Paso: Habilitar Login y Registro con Laravel Breeze

## Objetivo

Implementar autenticación en el proyecto `practica_1` para que:

- exista login y registro de usuarios,
- las rutas de categorías y productos queden protegidas,
- la ruta `/` redirija al panel o al formulario de acceso,
- solo usuarios autenticados puedan ver el sistema.

---

## 1. Verificar el estado actual del proyecto

Antes de empezar, confirmar que el proyecto Laravel funciona y que la base de datos está configurada en el archivo `.env`.

Revisar especialmente:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=productos
DB_USERNAME=root
DB_PASSWORD=
```

Tambien verificar que existe la migración de usuarios:

- `database/migrations/0001_01_01_000000_create_users_table.php`

Esa migración ya viene por defecto en Laravel y será usada para login y registro.

---

## 2. Instalar Laravel Breeze

Laravel Breeze agrega autenticación básica lista para usar:

- login,
- registro,
- cierre de sesión,
- recuperación básica de estructura de usuarios.

Ejecutar:

```bash
composer require laravel/breeze --dev
php artisan breeze:install
npm install
npm run dev
```

Si el proyecto usa Blade, la instalación por defecto es suficiente.

Si el sistema pide confirmación durante la instalación, elegir la opción más simple basada en Blade.

---

## 3. Ejecutar migraciones de usuarios

Luego de instalar Breeze, ejecutar las migraciones:

```bash
php artisan migrate
```

Esto crea o actualiza las tablas necesarias para autenticación, especialmente:

- `users`
- tablas de soporte que Laravel necesite

Si ya existen migraciones previas de categorías y productos, también quedarán registradas en la misma base de datos.

---

## 4. Verificar rutas de autenticación

Después de instalar Breeze, Laravel agrega rutas como:

- `/login`
- `/register`
- `/dashboard` o la ruta definida por Breeze

Puedes revisarlas con:

```bash
php artisan route:list
```

Debes confirmar que aparecen rutas relacionadas con autenticación, por ejemplo:

- `login`
- `register`
- `logout`

---

## 5. Habilitar login y registro en la interfaz

Breeze genera automáticamente las vistas de autenticación.

Normalmente se crean archivos como:

- `resources/views/auth/login.blade.php`
- `resources/views/auth/register.blade.php`

En este punto ya deberías poder abrir en el navegador:

```text
http://127.0.0.1:8000/login
http://127.0.0.1:8000/register
```

### Prueba recomendada

1. Abrir `/register`
2. Crear un usuario nuevo
3. Iniciar sesión con ese usuario
4. Confirmar que Laravel redirige al área autenticada

---

## 6. Proteger rutas con `middleware('auth')`

Una vez que login y registro estén activos, proteger las rutas del sistema.

Editar `routes/web.php`.

### Antes

```php
Route::resource('listacategorias', CategoriaController::class);
Route::resource('listaproductos', ProductoController::class);
```

### Después

```php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ProductoController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::resource('listacategorias', CategoriaController::class);
    Route::resource('listaproductos', ProductoController::class);
});
```

Con esto, Laravel exigirá iniciar sesión antes de entrar a:

- categorías,
- productos,
- crear,
- editar,
- eliminar,
- listados.

---

## 7. Redirigir `/` al login o al panel

Aquí hay dos opciones correctas.

## Opción A: redirigir al login

Si el usuario entra al sistema sin autenticarse, se lo envía a `/login`.

```php
Route::get('/', function () {
    return redirect()->route('login');
});
```

Esta opción es útil cuando el proyecto será exclusivamente administrativo.

## Opción B: redirigir al panel si ya inició sesión

Si el usuario ya está autenticado, se envía al panel. Si no, va al login.

```php
Route::get('/', function () {
    return auth()->check()
        ? redirect()->route('listaproductos.index')
        : redirect()->route('login');
});
```

Esta es la opción más recomendable para `practica_1`, porque el sistema ya tiene panel de productos y categorías.

---

## 8. Verificar que categorías y productos solo se vean autenticado

Después de aplicar el middleware, hacer estas pruebas:

### Prueba 1: usuario no autenticado

1. Cerrar sesión
2. Intentar entrar manualmente a:

```text
/listacategorias
/listaproductos
```

Resultado esperado:

- Laravel debe redirigir automáticamente a `/login`

### Prueba 2: usuario autenticado

1. Iniciar sesión
2. Entrar a:

```text
/listacategorias
/listaproductos
```

Resultado esperado:

- el usuario puede ver los módulos sin bloqueo

### Prueba 3: crear y editar autenticado

Comprobar que también funcionan:

- `/listacategorias/create`
- `/listaproductos/create`
- edición y eliminación

Resultado esperado:

- todo funciona normalmente solo después de autenticarse

---

## 9. Ajuste recomendado del menú o layout

Una vez instalado Breeze, conviene adaptar el layout principal para mostrar opciones según sesión:

- si el usuario inició sesión: mostrar nombre y botón `Cerrar sesión`
- si no inició sesión: mostrar enlace a `Login`

Ejemplo básico dentro de Blade:

```blade
@auth
    <span>{{ auth()->user()->name }}</span>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Cerrar sesión</button>
    </form>
@endauth

@guest
    <a href="{{ route('login') }}">Login</a>
    <a href="{{ route('register') }}">Registro</a>
@endguest
```

Esto mejora la experiencia del usuario y confirma visualmente el estado de autenticación.

---

## 10. Estructura esperada al finalizar

Al terminar esta práctica, el proyecto debe tener:

- autenticación instalada con Breeze,
- tabla `users` migrada,
- formulario de login,
- formulario de registro,
- rutas protegidas con `auth`,
- redirección desde `/`,
- acceso restringido a categorías y productos.

---

## 11. Comandos resumidos

```bash
composer require laravel/breeze --dev
php artisan breeze:install
npm install
npm run dev
php artisan migrate
php artisan route:list
php artisan serve
```

---

## 12. Resultado esperado

El usuario deberá:

1. registrarse en el sistema,
2. iniciar sesión,
3. acceder al panel,
4. trabajar con categorías y productos solo si está autenticado.

De esta forma, el proyecto `practica_1` quedará alineado con el tema:

- sistema de autenticación,
- manejo de sesión,
- protección de rutas,
- control de acceso en Laravel.

---

## 13. Siguiente mejora recomendada

Después de completar esta guía, lo siguiente más conveniente es:

1. personalizar el diseño del login y registro con Bootstrap,
2. mostrar el usuario autenticado en el sidebar,
3. ocultar el panel cuando no exista sesión,
4. continuar con exportación de PDF y Excel.
