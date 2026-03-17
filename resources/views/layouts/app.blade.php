<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CRUD Categorías')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/estilo.css') }}" rel="stylesheet"> {{-- Se enlaza el archivo CSS externo para separar la presentación del Blade y mantener el layout limpio. --}}
</head>
<body>
    <div class="d-flex min-vh-100">
        <aside class="sidebar-panel text-white d-flex flex-column p-4">
            <div class="mb-4 pb-3 border-bottom border-light border-opacity-10">
                <span class="badge text-bg-light text-primary fw-semibold mb-2">Bootstrap Panel</span>
                <h4 class="mb-1">Dashboard</h4>
                <p class="small text-white-50 mb-0">Gestión de categorías y productos</p>
            </div>

            <nav class="nav nav-pills flex-column gap-2">
                <a href="{{ route('listacategorias.index') }}"
                   class="sidebar-link nav-link d-flex align-items-center gap-3 px-3 py-3 rounded-3 {{ request()->routeIs('listacategorias.*') ? 'active fw-semibold' : '' }}">
                    <i class="bi bi-tags-fill"></i>
                    <span>Categorías</span>
                </a>

                <a href="{{ route('listaproductos.index') }}"
                   class="sidebar-link nav-link d-flex align-items-center gap-3 px-3 py-3 rounded-3 {{ request()->routeIs('listaproductos.*') ? 'active fw-semibold' : '' }}">
                    <i class="bi bi-box-seam-fill"></i>
                    <span>Productos</span>
                </a>
            </nav>

            <div class="mt-auto pt-4">
                <div class="small text-white-50">© 2026 Sistemas Informaticos - CEFTE</div>
            </div>
        </aside>

        <main class="flex-grow-1 p-4 p-md-5 content-shell">
            <div class="panel-card bg-white mb-4">
                <div class="card-body p-4 p-md-5 d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    <div>
                        <div class="text-uppercase small fw-semibold section-label">Panel del módulo</div> {{-- Se reemplaza el estilo inline por una clase reutilizable para mantener el Blade más limpio. --}}
                        <h2 class="mb-1 section-title">@yield('header')</h2> {{-- El color del título pasa a una clase CSS para separar estructura y presentación. --}}
                        <p class="text-secondary mb-0">Interfaz administrativa</p>
                    </div>
                    <div class="d-flex gap-2 flex-wrap">
                        @yield('header_actions')
                    </div>
                </div>
            </div>

            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
