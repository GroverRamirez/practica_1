# Guía de Laboratorio 05: Exportación de Reportes PDF (DomPDF)

## A. Objetivo de la Práctica
Proveer salidas tangibles al esfuerzo del software integrando una librería externa ("Package") para exportar vistas HTML puras hacia el estándar documental digital PDF, esencial para contabilidad y reportes de gerencia.

## B. Prerrequisitos
- Compresión del gestor de paquetes de PHP: `Composer`.
- Tener instalada y activada la extensión GD o zip en `php.ini` (Generalmente activo en servidores locales Laragon/Xampp).

## C. Desarrollo Paso a Paso

### 1. Engranar Librería BarvyD/DomPDF
Abra su terminal y descargue la librería oficial mediante Composer:
```bash
composer require barryvdh/laravel-dompdf
```

### 2. Preparar el Controlador
En `ProductoController.php`, añada la importación en su cabecera y elabore un motor de captura total `pdf`:
```php
use Barryvdh\DomPDF\Facade\Pdf; // Cabecera superior

public function pdf()
{
    // Extraer todo para el reporte contable global (Eager Loading necesario)
    $productos = Producto::with('categoria')->get();

    // Invocar una vista HTML pero procesarla estáticamente como papel A4
    $pdf = Pdf::loadView('productos.pdf', compact('productos'))
              ->setPaper('a4', 'landscape');
    
    // Descargar el archivo procesado hacia la PC del cliente
    return $pdf->download('Reporte_Global_Productos.pdf');
}
```

### 3. Enrutamiento del Reporte
Proteja esta ruta especial en `web.php`. Nómbrela claramente.
```php
Route::get('productos/exportar/pdf', [ProductoController::class, 'pdf'])->name('productos.pdf');
```

### 4. La Vista Exclusiva para la Impresora
Cree el archivo `resources/views/productos/pdf.blade.php`.
Esta vista **NO DEBE EXPORTAR** diseños complejos externos (ni Bootstraps enormes usando CDN's ni JavaScripts), pues DomPDF no lee componentes interactivos. Utilice estilos en línea o CSS básico:
```html
<style>
    table { width: 100%; border-collapse: collapse; }
    th, td { border: 1px solid #000; padding: 5px; }
    h1 { text-align: center; color: darkblue; }
</style>
<h1>Reporte General de Inventario</h1>
<!-- Continúe elaborando su foreach común de tabla HTML aquí... -->
```

## D. Resultado Esperado
Al pulsar el botón anclado hacia `route('productos.pdf')`, el sistema procesará la solicitud en backend por unos segundos y descargará estrictamente un archivo PDF con la insignia de la marca estipulada, ideal para enviar como adjunto por correo electrónico a la junta corporativa.
