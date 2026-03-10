<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Categoría</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    {{-- VISTA editcategorias - Formulario para editar una categoría existente --}}
    {{-- Recibe la variable $listacategoria con los datos actuales --}}
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
                    <a href="{{route('listaproductos.index')}}" class="text-white text-decoration-none {{request()->routeIs('listaproductos.*') ? 'fw-bold' : ''}}">
                        Productos
                    </a>
                </li>
            </ul>
        </div>
        <div class="flex-grow-1 p-4">
        <h2 class="mb-3">Editar Categoría</h2>
        <div class="card">
            <div class="card-body">
                {{-- action: PUT /listacategorias/{id} - Envía los datos al método update() --}}
                <form action="{{route('listacategorias.update', $listacategoria->id)}}" method="post">
                    @csrf {{-- Token de seguridad obligatorio en formularios POST --}}
                    @method('PUT') {{-- Los navegadores solo envían GET/POST; @method simula PUT --}}
                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre</label>
                        {{-- old('nombre', $listacategoria->nombre): mantiene el valor tras errores de validación --}}
                        <input type="text" class="form-control" name="nombre" id="nombre" value="{{old('nombre', $listacategoria->nombre)}}" required>
                    </div>
                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción</label>
                        <textarea class="form-control" name="descripcion" id="descripcion" rows="3">{{old('descripcion', $listacategoria->descripcion)}}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="estado" class="form-label">Estado</label>
                        @php $estadoActual = old('estado', $listacategoria->estado ?? 'activo'); @endphp
                        <select class="form-select" name="estado" id="estado" required>
                            <option value="activo" {{in_array($estadoActual, ['activo', 1, '1']) ? 'selected' : ''}}>Activo</option>
                            <option value="inactivo" {{in_array($estadoActual, ['inactivo', 0, '0']) ? 'selected' : ''}}>Inactivo</option>
                        </select>
                    </div>
                    <div>
                        <a href="{{route('listacategorias.index')}}" class="btn btn-secondary">Cancelar</a>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
