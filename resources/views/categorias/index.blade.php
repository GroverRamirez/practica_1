@extends('layouts.app')

@section('title', 'Lista de Categorías')
@section('header', 'Categorías')

@section('header_actions')
    <a href="{{ route('listacategorias.create') }}" class="btn btn-primary">Nueva Categoría</a>
@endsection

@section('content')
    {{-- Mensaje temporal enviado desde el controlador después de crear, editar o eliminar --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show">
            {{ session('success') }}
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
                    @forelse($categorias as $categoria)
                        <tr>
                            <td>{{ $categoria->id }}</td>
                            <td>{{ $categoria->nombre }}</td>
                            <td>{{ $categoria->descripcion ?? '-' }}</td>
                            <td>
                                @php
                                    // Se convierte el valor guardado en una etiqueta visual fácil de interpretar.
                                    $esActivo = in_array($categoria->estado, ['activo', 1, '1']);
                                @endphp
                                <span class="badge {{ $esActivo ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $esActivo ? 'Activo' : 'Inactivo' }}
                                </span>
                            </td>
                            <td>
                                <a href="{{ route('listacategorias.edit', $categoria) }}" class="btn btn-sm btn-warning">Editar</a>

                                <form action="{{ route('listacategorias.destroy', $categoria) }}"
                                      method="POST"
                                      class="d-inline"
                                      onsubmit="return confirm('¿Eliminar?');">
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
@endsection
