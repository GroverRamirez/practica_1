# Guiá de Laboratorio 06: Refactorización Premium y Motores de Patrones

## A. Objetivo General
Transformar una aplicación base con diseño nativo (Breeze/Bootstrap plano) en una arquitectura de aspecto "SaaS Corporativo" y dotarla de capacidad para generar datos de prueba masivos e independientes.

## B. Prerrequisitos
- Haber completado satisfactoriamente los laboratorios 01 al 05.
- Comprender la sintaxis de "Hojas de Estilos en Cascada" (CSS) y clases estructurales.

---

## C. Fase 1: Arquitectura de Pruebas (Factories & Seeders)

En la vida corporativa real, no llenarás tablas "a mano" 500 veces para probar la paginación. Aprenderás a usar Fábricas Eloquent.

### 1. Las Fábricas (`database/factories`)
Ejecuta `php artisan make:factory CategoriaFactory` y `php artisan make:factory ProductoFactory`.

Dentro de la Fábrica de Categorías, puedes usar la herramienta nativa `$this->faker` para instanciar nombres ficticios:
```php
public function definition()
{
    return [
        'nombre' => fake()->word(),
        'descripcion' => fake()->sentence(),
        'estado' => fake()->randomElement(['activo', 'inactivo']),
    ];
}
```

### 2. El Inyector Maestro (`DatabaseSeeder.php`)
Dirígete a `database/seeders/DatabaseSeeder.php` e instruye al sistema para que invoque y conecte ambas fábricas:
```php
// Crea 10 categorías Padre, y adentro de cada una inyecta 5 productos.
Categoria::factory()
    ->count(10)
    ->has(Producto::factory()->count(5), 'productos')
    ->create();
```
**Ejecución:** En Terminal corre `php artisan migrate:fresh --seed` para reiniciar completamente la DB y cargar tus falsos datos.

---

## D. Fase 2: Front-End UI Premium (Tailwind & Bootstrap Slate)

El objetivo es separar el diseño básico por uno "Glassmorphism" (Cristalino y de sombras profundas):

1. **Tipografía Base:** Ve a `resources/views/layouts/app.blade.php` o a tu CSS e importa Google Fonts `Inter`.
2. **Fondos Pizarra (Slate 100):** Elimina o modifica los temidos colores Blancos puros (`#ffffff`) en los fondos absolutos (`body`). Intercámbialo por un sutil Slate `#f1f5f9` para que las tablas o formularios blancos que van por encima cobren jerarquía visual con la sombra base (`box-shadow: 0 10px 40px rgba(0,0,0,0.05);`).
3. **Botones Inteligentes:** Usa Componentes en Blade o crea un CSS general como `.btn-primary-theme` con esquinas redondeadas y relleno de contraste para alejarse de los azules predeterminados de Bootstrap.

## E. Resultado Final Esperado
Al completar esta guía el alumno poseerá un Panel de Control unificado con `Blade`, capaz de rearmarse completamente a nivel DB con un solo comando de consola, emulando la calidad técnica que se requiere en "Deep Tech" o el sector financiero real de la Ingeniería de Software.
