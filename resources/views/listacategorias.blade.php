<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Categorías</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    {{-- VISTA listacategorias - Lista todas las categorías (index) --}}
    <div class="d-flex">
        {{-- Menú lateral --}}
        <div class="bg-primary text-white" style="width: 200px; min-height: 100vh; padding: 20px;">
            <h5 class="mb-4">CRUD Productos</h5>
            <ul class="list-unstyled">
                <li class="mb-2">
                    {{-- route() genera la URL desde el nombre. listacategorias.index = GET /listacategorias --}}
                    <a href="{{route('listacategorias.index')}}" class="text-white text-decoration-none {{request()->routeIs('listacategorias.*') ? 'fw-bold' : ''}}">
                        Categorías
                    </a>
                </li>
                <li class="mb-2">
                    <a href="" class="text-white text-decoration-none {{request()->routeIs('listaproductos.*') ? 'fw-bold' : ''}}">
                        Productos
                    </a>
                </li>
            </ul>
        </div>
        <div class="flex-grow-1 p-4">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Categorías</h2>
            {{-- Enlace al formulario de crear: GET /listacategorias/create --}}
            <a href="{{route('listacategorias.create')}}" class="btn btn-primary">Nueva Categoría</a>
        </div>

        {{-- Mensaje flash: se muestra tras redirect()->with('success', ...) --}}
        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                {{session('success')}}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card">
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @forelse: recorre $categorias; si está vacío, muestra @empty --}}
                        @forelse($categorias as $categoria)
                        <tr>
                            <td>{{$categoria->id}}</td>
                            <td>{{$categoria->nombre}}</td>
                            <td>{{$categoria->descripcion ?? '-'}}</td>
                            <td>
                                @php
                                    $esActivo = in_array($categoria->estado, ['activo', 1, '1']);
                                @endphp
                                <span class="badge {{ $esActivo ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $esActivo ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td>
                                {{-- route('listacategorias.edit', $categoria) → GET /listacategorias/{id}/edit --}}
                                <a href="{{route('listacategorias.edit', $categoria)}}" class="btn btn-sm btn-warning">Editar</a>
                                {{-- DELETE requiere @csrf y @method('DELETE') por seguridad --}}
                                <form action="{{route('listacategorias.destroy', $categoria)}}" method="POST" class="d-inline" onsubmit="return confirm('¿Eliminar?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">No hay categorías registradas</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
