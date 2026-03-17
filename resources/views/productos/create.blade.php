@extends('layouts.app') {{-- Usa el layout compartido para que esta vista solo se concentre en el formulario del módulo productos. --}}

@section('title', 'Nuevo Producto') {{-- Envía el título de la pestaña al layout mediante @yield('title'). --}}
@section('header', 'Nuevo Producto') {{-- Envía el encabezado principal que el layout mostrará arriba del contenido. --}}

@section('content') {{-- Este bloque representa el contenido principal de la pantalla de creación. --}}
    <div class="card">
        <div class="card-body">
            {{-- Este formulario envía los datos al método store() del controlador para registrar un nuevo producto. --}}
            <form action="{{ route('listaproductos.store') }}" method="post">
                @csrf {{-- Inserta un token de seguridad que Laravel exige para aceptar formularios POST. --}}

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre" id="nombre" value="{{ old('nombre') }}" required>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control" name="descripcion" id="descripcion" rows="3">{{ old('descripcion') }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="precio" class="form-label">Precio</label>
                    <input type="number" step="0.01" class="form-control" name="precio" id="precio" value="{{ old('precio') }}" required> {{-- Antes no tenía tipo numérico; ahora ayuda a capturar correctamente un precio decimal. --}}
                </div>

                <div class="mb-3">
                    <label for="stock" class="form-label">Stock</label>
                    <input type="number" class="form-control" name="stock" id="stock" value="{{ old('stock') }}" required> {{-- Antes tenía atributos mal armados; ahora queda como un input numérico válido. --}}
                </div>

                <div class="mb-3">
                    <label for="categoria_id" class="form-label">Categoría</label>
                    {{-- El select permite asociar el producto con una categoría existente. --}}
                    <select class="form-select" name="categoria_id" id="categoria_id" required>
                        <option value="">Seleccione una categoría</option>
                        @foreach($categorias as $categoria) {{-- $categorias llega desde el controlador y se recorre para llenar las opciones del select. --}}
                            <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>
                                {{ $categoria->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <a href="{{ route('listaproductos.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
