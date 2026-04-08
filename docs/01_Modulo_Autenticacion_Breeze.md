# Guía de Laboratorio 01: Instalación y Autenticación (Breeze)

## A. Objetivo de la Práctica
Configurar la base del proyecto Laravel, enlazarlo con la base de datos MySQL e implementar el sistema de autenticación preconstruido para asegurar el acceso a la plataforma corporativa.

## B. Prerrequisitos
- Servidor local activo (Laragon/XAMPP).
- Base de datos relacional creada (ej. `practica_1`).
- Proyecto base de Laravel instanciado vía Composer.

## C. Desarrollo Paso a Paso

### 1. Configuración de Base de Datos
Edite el archivo oculto `.env` en la raíz de su proyecto y especifique credenciales:
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=practica_1
DB_USERNAME=root
DB_PASSWORD=
```

### 2. Instalación de Motor Starter (Laravel Breeze)
Ejecute en la terminal los tres comandos vitales para inyectar el sistema (use Blade puro):
```bash
composer require laravel/breeze --dev
php artisan breeze:install
php artisan migrate
```

### 3. Compilación de Assets
Breeze requiere construir el diseño visual:
```bash
npm install
npm run dev
```

## D. Resultado Esperado
Al visitar `http://localhost/practica_1/public/` o `http://127.0.0.1:8000/`, el estudiante deberá visualizar la ventana de "Welcome" con los enlaces `Log in` y `Register` operativos en la esquina superior derecha, logrando autenticarse y acceder al `Dashboard`.
