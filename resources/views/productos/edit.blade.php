@extends('layouts.app') {{-- Reutiliza el layout base y evita duplicar la estructura general de la página. --}}

@section('title', 'Editar Producto') {{-- Define el texto que el layout mostrará dentro del <title> del documento. --}}
@section('header', 'Editar Producto') {{-- Define el encabezado de la página que el layout insertará con @yield('header'). --}}

@section('content') {{-- Este bloque contiene el formulario de edición que el layout mostrará como contenido principal. --}}
    <div class="card">
        <div class="card-body">
            {{-- Este formulario envía los cambios al método update() usando PUT, que es el verbo HTTP habitual para actualizar. --}}
            <form action="{{ route('listaproductos.update', ['listaproducto' => $producto->id]) }}" method="post"> {{-- Ahora se usa el ID del producto para que la ruta update reciba el parámetro exacto que Laravel exige. --}}
                @csrf {{-- Agrega el token CSRF para proteger el formulario contra envíos no válidos. --}}
                @method('PUT') {{-- HTML solo envía GET y POST; esta directiva le dice a Laravel que trate la petición como PUT. --}}

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text"
                           class="form-control"
                           name="nombre"
                           id="nombre"
                           value="{{ old('nombre', $producto->nombre) }}"
                           required>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control"
                              name="descripcion"
                              id="descripcion"
                              rows="3">{{ old('descripcion', $producto->descripcion) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="precio" class="form-label">Precio</label>
                    <input type="number"
                           step="0.01"
                           class="form-control"
                           name="precio"
                           id="precio"
                           value="{{ old('precio', $producto->precio) }}"
                           required> {{-- Se agrega el campo precio en edición porque el controlador ahora valida y actualiza este valor real del producto. --}}
                </div>

                <div class="mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number"
                           class="form-control"
                           name="stock"
                           id="stock"
                           value="{{ old('stock', $producto->stock) }}"
                           required> {{-- Se agrega stock para que la edición sea completa y consistente con la tabla productos. --}}
                </div>

                <div class="mb-3">
                    <label for="categoria_id" class="form-label">Categoría</label>
                    {{-- Se vuelve a mostrar la lista de categorías para permitir cambiar la categoría asociada al producto. --}}
                    <select class="form-select" name="categoria_id" id="categoria_id" required>
                        <option value="">Seleccione una categoría</option>
                        @foreach($categorias as $categoria) {{-- Se recorren las categorías disponibles para permitir elegir cuál se relaciona con el producto. --}}
                            <option value="{{ $categoria->id }}" {{ old('categoria_id', $producto->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <a href="{{ route('listaproductos.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
