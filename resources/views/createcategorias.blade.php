<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Categoría</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    {{-- VISTA createcategorias - Formulario para crear una nueva categoría --}}
    <div class="d-flex">
        <div class="bg-primary text-white" style="width: 200px; min-height: 100vh; padding: 20px;">
            <h5 class="mb-4">CRUD Productos</h5>
            <ul class="list-unstyled">
                <li class="mb-2">
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
        <h2 class="mb-3">Nueva Categoría</h2>
        <div class="card">
            <div class="card-body">
                {{-- action: POST /listacategorias - Envía los datos al método store() --}}
                <form action="{{route('listacategorias.store')}}" method="post">
                    @csrf {{-- Token CSRF: protege contra ataques de falsificación de peticiones --}}
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        {{-- old('nombre'): si hay error de validación, conserva lo que escribió el usuario --}}
                        <input type="text" class="form-control" name="nombre" id="nombre" value="{{old('nombre')}}" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" name="descripcion" id="descripcion" rows="3">{{old('descripcion')}}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        <select class="form-select" name="estado" id="estado" required>
                            <option value="activo" {{old('estado', 'activo') == 'activo' ? 'selected' : ''}}>Activo</option>
                            <option value="inactivo" {{old('estado') == 'inactivo' ? 'selected' : ''}}>Inactivo</option>
                        </select>
                    </div>
                    <div>
                        <a href="{{route('listacategorias.index')}}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
