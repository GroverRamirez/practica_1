<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@isset($slot) {{ config('app.name', 'Laravel') }} @else @yield('title', 'CRUD Categorias') @endisset</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">
    <link href="{{ asset('css/estilo.css') }}" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
    <div class="d-flex min-vh-100">
        <aside class="sidebar-panel text-white d-flex flex-column p-4">
            <div class="mb-4 pb-3 border-bottom border-light border-opacity-10">
                <span class="badge text-bg-light text-primary fw-semibold mb-2">Bootstrap Panel</span>
                <h4 class="mb-1">Dashboard</h4>
                <p class="small text-white-50 mb-0">Gestion de categorias y productos</p>
            </div>

            @auth
                {{-- El sidebar confirma visualmente qué usuario sostiene la sesión actual. --}}
                <div class="mb-4 pb-3 border-bottom border-light border-opacity-10">
                    <div class="small text-white-50">Sesion iniciada</div>
                    <div class="fw-semibold">{{ auth()->user()->name }}</div>
                    <div class="small text-white-50">{{ auth()->user()->email }}</div>
                </div>

                <nav class="nav nav-pills flex-column gap-2">
                    <a href="{{ route('listacategorias.index') }}"
                       class="sidebar-link nav-link d-flex align-items-center gap-3 px-3 py-3 rounded-3 {{ request()->routeIs('listacategorias.*') ? 'active fw-semibold' : '' }}">
                        <i class="bi bi-tags-fill"></i>
                        <span>Categorias</span>
                    </a>

                    <a href="{{ route('listaproductos.index') }}"
                       class="sidebar-link nav-link d-flex align-items-center gap-3 px-3 py-3 rounded-3 {{ request()->routeIs('listaproductos.*') ? 'active fw-semibold' : '' }}">
                        <i class="bi bi-box-seam-fill"></i>
                        <span>Productos</span>
                    </a>

                    <a href="{{ route('profile.edit') }}"
                       class="sidebar-link nav-link d-flex align-items-center gap-3 px-3 py-3 rounded-3 {{ request()->routeIs('profile.*') ? 'active fw-semibold' : '' }}">
                        <i class="bi bi-person-circle"></i>
                        <span>Perfil</span>
                    </a>
                </nav>
            @endauth

            <div class="mt-auto pt-4">
                @auth
                    {{-- Logout usa POST porque cambia el estado de la sesión del usuario. --}}
                    <form method="POST" action="{{ route('logout') }}" class="mb-3">
                        @csrf
                        <button type="submit" class="btn btn-outline-light w-100 d-inline-flex align-items-center justify-content-center gap-2">
                            <i class="bi bi-box-arrow-right"></i>
                            <span>Cerrar sesion</span>
                        </button>
                    </form>
                @endauth

                <div class="small text-white-50">&copy; 2026 Sistemas Informaticos - CEFTE</div>
            </div>
        </aside>

        <main class="flex-grow-1 p-3 p-md-4 content-shell">
            <div class="panel-card bg-white mb-4 page-header-card">
                <div class="card-body page-header-body d-flex flex-column flex-md-row justify-content-between align-items-md-center gap-3">
                    @isset($slot)
                        {{-- Este layout soporta componentes Blade con slot y vistas clásicas con @extends. --}}
                        <div>
                            <div class="text-uppercase small fw-semibold section-label">Panel del modulo</div>
                            <div class="mb-1 section-title fw-bold fs-2">{{ strip_tags($header ?? 'Panel') }}</div>
                            <p class="text-secondary mb-0">Interfaz administrativa</p>
                        </div>
                    @else
                        <div>
                            <div class="text-uppercase small fw-semibold section-label">Panel del modulo</div>
                            <h2 class="mb-1 section-title">@yield('header')</h2>
                            <p class="text-secondary mb-0">Interfaz administrativa</p>
                        </div>
                        <div class="d-flex gap-2 flex-wrap">
                            @yield('header_actions')
                        </div>
                    @endisset
                </div>
            </div>

            @isset($slot)
                {{ $slot }}
            @else
                @yield('content')
            @endisset
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
