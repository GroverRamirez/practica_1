<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'CRUD Categorías')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="d-flex">
        <aside class="bg-primary text-white" style="width: 200px; min-height: 100vh; padding: 20px;">
            <h5 class="mb-4">CRUD Productos</h5>
            <ul class="list-unstyled">
                <li class="mb-2">
                    {{-- Se resalta el módulo de categorías cuando la ruta actual pertenece a ese recurso --}}
                    <a href="{{ route('listacategorias.index') }}"
                       class="text-white text-decoration-none {{ request()->routeIs('listacategorias.*') ? 'fw-bold' : '' }}">
                        Categorías
                    </a>
                </li>
                <li class="mb-2">
                    {{-- Este enlace queda visible como referencia del otro módulo, aunque aún no esté implementado --}}
                    <a href=""
                       class="text-white text-decoration-none {{ request()->routeIs('listaproductos.*') ? 'fw-bold' : '' }}">
                        Productos
                    </a>
                </li>
            </ul>
        </aside>

        <main class="flex-grow-1 p-4">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h2 class="mb-0">@yield('header')</h2>
                @yield('header_actions')
            </div>

            {{-- El contenido específico de cada pantalla del CRUD se inserta aquí --}}
            @yield('content')
        </main>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
