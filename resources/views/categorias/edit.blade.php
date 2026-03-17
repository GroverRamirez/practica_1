@extends('layouts.app')

@section('title', 'Editar Categoría')
@section('header', 'Editar Categoría')

@section('content')
    <div class="card">
        <div class="card-body">
            <form action="{{ route('listacategorias.update', $listacategoria) }}" method="post">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text"
                           class="form-control"
                           name="nombre"
                           id="nombre"
                           value="{{ old('nombre', $listacategoria->nombre) }}"
                           required>
                </div>

                <div class="mb-3">
                    <label for="descripcion" class="form-label">Descripción</label>
                    <textarea class="form-control"
                              name="descripcion"
                              id="descripcion"
                              rows="3">{{ old('descripcion', $listacategoria->descripcion) }}</textarea>
                </div>

                <div class="mb-3">
                    <label for="estado" class="form-label">Estado</label>
                    @php
                        // Se conserva el estado enviado por el usuario o, si no existe, el del registro actual.
                        $estadoActual = old('estado', $listacategoria->estado);

                        if (in_array($estadoActual, [1, '1', true])) $estadoActual = 'activo';
                        if (in_array($estadoActual, [0, '0', false])) $estadoActual = 'inactivo';
                        if (!in_array($estadoActual, ['activo', 'inactivo'])) $estadoActual = 'activo';
                    @endphp
                    <select class="form-select" name="estado" id="estado" required>
                        <option value="activo" {{ $estadoActual === 'activo' ? 'selected' : '' }}>Activo</option>
                        <option value="inactivo" {{ $estadoActual === 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                    </select>
                </div>

                <div>
                    <a href="{{ route('listacategorias.index') }}" class="btn btn-secondary">Cancelar</a>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
@endsection
