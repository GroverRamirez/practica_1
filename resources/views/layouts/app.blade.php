<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') - Mi Aplicación</title>

    <!-- Usando Bootstrap CDN y Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    
    <!-- Fuente Inter (Google Fonts) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- CSS del Tema Premium -->
    <link rel="stylesheet" href="{{ asset('css/estilo.css') }}">

    <!-- Vite Assets (Tailwind para módulos Breeze nativos) -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="d-flex" style="background-color: #f1f5f9;">

    {{-- BARRA LATERAL (SIDEBAR) --}}
    <nav class="sidebar-panel text-white sidebar-nav shrink-0 d-flex flex-column vh-100" style="width: 280px; position: fixed; top: 0; left: 0; z-index: 1000;">
        {{-- LOGO Y TITULO (Top) --}}
        <div class="px-4 py-4 border-bottom border-light border-opacity-10 position-relative">
            <h4 class="mb-0 fw-bold d-flex align-items-center gap-2 text-white shadow-sm" style="letter-spacing: -0.01em;">
                <i class="bi bi-grid-fill" style="color: #60a5fa;"></i>
                <span>Dashboard</span>
            </h4>
            <small class="text-white-50 mt-1 d-block" style="font-size: 0.8rem; line-height: 1.2;">Gestión de categorías y productos</small>
        </div>

        {{-- NAVEGACIÓN PRINCIPAL (Centro) --}}
        <div class="flex-grow-1 py-4 sidebar-scrollbox overflow-auto">
            <div class="px-4 mb-3">
                <span class="text-uppercase text-white-50 fw-bold" style="font-size: 0.70rem; letter-spacing: 0.05em;">Menú Principal</span>
            </div>
            
            <a href="{{ route('categorias.index') }}" class="sidebar-link d-flex align-items-center text-decoration-none {{ request()->routeIs('categorias.*') ? 'active' : '' }}">
                <i class="bi bi-tags-fill me-3 fs-5 opacity-75"></i>
                Categorías
            </a>
            <a href="{{ route('productos.index') }}" class="sidebar-link d-flex align-items-center text-decoration-none {{ request()->routeIs('productos.*') ? 'active' : '' }}">
                <i class="bi bi-box-seam-fill me-3 fs-5 opacity-75"></i>
                Productos
            </a>
            <a href="{{ route('profile.edit') }}" class="sidebar-link d-flex align-items-center text-decoration-none {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                <i class="bi bi-person-circle me-3 fs-5 opacity-75"></i>
                Perfil
            </a>
        </div>

        {{-- PERFIL Y SESIÓN (Fondo) --}}
        <div class="mt-auto p-3 border-top border-light border-opacity-10" style="background: rgba(0,0,0,0.2);">
            {{-- Info de Usuario usando Avatar Circular --}}
            <div class="d-flex align-items-center px-1 py-2 mb-3">
                <div class="rounded-circle d-flex justify-content-center align-items-center shadow-sm" style="width: 44px; height: 44px; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; border: 2px solid rgba(255,255,255,0.1);">
                    <span class="fw-bold" style="font-size: 1rem;">GR</span>
                </div>
                <div class="ms-3 overflow-hidden">
                    <div class="fw-bold text-white text-truncate" style="font-size: 0.95rem;">Grover Ramirez</div>
                    <small class="text-white-50 text-truncate d-block" style="font-size: 0.75rem;">grover.ramirez.z@gmail.com</small>
                </div>
            </div>

            {{-- Botón Suave para Cerrar Sesión (Glassmorphism Red) --}}
            <form action="{{ route('logout') ?? '#' }}" method="POST" class="w-100">
                @csrf
                <button type="submit" class="btn w-100 d-flex justify-content-center align-items-center gap-2 border-0 rounded-3 text-white fw-medium py-2" style="background-color: rgba(220, 38, 38, 0.2); transition: all 0.2s ease;">
                    <i class="bi bi-box-arrow-left"></i>
                    Cerrar sesión
                </button>
            </form>
        </div>
    </nav>

    {{-- CONTENIDO PRINCIPAL (Desplazamiento para el sidebar fixed) --}}
    <main class="content-shell flex-grow-1 min-vh-100 d-flex flex-column" style="margin-left: 280px; background-color: #f1f5f9 !important;">
        
        {{-- HEADER SUPERIOR BLANCO --}}
        <header class="bg-white border-bottom shadow-sm px-4 px-md-5 py-3 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3" style="position: sticky; top: 0; z-index: 900;">
            <div class="d-flex align-items-center gap-3">
                {{-- Icono representativo dinámico para el encabezado --}}
                <div class="d-flex justify-content-center align-items-center rounded-3 shadow-sm bg-primary-theme" style="width: 48px; height: 48px; background: #eff6ff; color: #3b82f6;">
                    @if(request()->routeIs('productos.*'))
                        <i class="bi bi-box-seam fs-3"></i>
                    @elseif(request()->routeIs('categorias.*'))
                        <i class="bi bi-tags fs-3"></i>
                    @else
                        <i class="bi bi-grid fs-3"></i>
                    @endif
                </div>
                
                <div class="header-titles">
                    <h4 class="mb-0 fw-bold text-dark text-capitalize" style="letter-spacing: -0.01em;">
                        Módulo @yield('header', 'Panel de Control')
                    </h4>
                    <small class="text-secondary fw-semibold d-block mt-1" style="font-size: 0.85rem;">Interfaz Administrativa y Operativa</small>
                </div>
            </div>
            
            <div class="d-flex align-items-center flex-wrap gap-2">
                @yield('header_actions')
            </div>
        </header>

        {{-- CONTENEDOR INYECTABLE DE LAS VISTAS --}}
        <div class="p-4 p-md-5 container-fluid flex-grow-1 d-flex flex-column" style="max-width: 1400px; margin: 0 auto; width: 100%;">
            @isset($slot)
                {{ $slot }}
            @endisset
            @yield('content')
        </div>
        
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
