@extends('layouts.app')

@section('title', 'Lista de Categorías')
@section('header', 'Categorías')

@section('header_actions')
    <a href="{{ route('listacategorias.create') }}" class="btn btn-primary-theme d-inline-flex align-items-center gap-2 shadow-sm"> {{-- El botón principal adopta el azul marino del tema para verse más sobrio y profesional. --}}
        <i class="bi bi-plus-circle-fill"></i> {{-- El icono refuerza la acción de crear sin sobrecargar visualmente el botón. --}}
        <span>Nueva Categoría</span>
    </a>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 panel-card"> {{-- El mensaje de éxito se integra con el nuevo estilo de cards suaves del sistema. --}}
            <i class="bi bi-check-circle-fill me-2"></i> {{-- Se mantiene el icono para dar lectura rápida al tipo de mensaje. --}}
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="panel-card bg-white"> {{-- La card principal usa el estilo del nuevo tema para verse más limpia y consistente. --}}
        <div class="card-body p-0">
            <div class="table-responsive"> {{-- La tabla sigue siendo adaptable para tamaños de pantalla menores. --}}
                <table class="table table-theme table-hover align-middle mb-0"> {{-- Se aplica una clase visual temática para mejorar la tabla sin cambiar su funcionalidad. --}}
                    <thead>
                        <tr>
                            <th class="px-4 py-3">ID</th>
                            <th class="py-3">Nombre</th>
                            <th class="py-3">Descripción</th>
                            <th class="py-3">Estado</th>
                            <th class="py-3 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($categorias as $categoria)
                            <tr>
                                <td class="px-4 fw-semibold text-secondary">{{ $categoria->id }}</td> {{-- El ID reduce protagonismo visual usando un tono secundario más elegante. --}}
                                <td class="fw-semibold">{{ $categoria->nombre }}</td> {{-- El nombre se destaca un poco más para facilitar el escaneo de la tabla. --}}
                                <td>{{ $categoria->descripcion ?? '-' }}</td>
                                <td>
                                    @php
                                        // Se convierte el valor guardado en una etiqueta visual fácil de interpretar.
                                        $esActivo = in_array($categoria->estado, ['activo', 1, '1']);
                                    @endphp
                                    <span class="badge rounded-pill {{ $esActivo ? 'badge-soft-success' : 'badge-soft-danger' }}"> {{-- Los estados pasan a usar badges suaves para verse más modernos y menos agresivos. --}}
                                        {{ $esActivo ? 'Activo' : 'Inactivo' }}
                                    </span>
                                </td>
                                <td class="text-center">
                                    <div class="d-inline-flex gap-2"> {{-- Las acciones se agrupan con mejor separación para una lectura más ordenada. --}}
                                        <a href="{{ route('listacategorias.edit', $categoria) }}" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1"> {{-- Editar adopta un estilo más neutro y profesional dentro del nuevo tema. --}}
                                            <i class="bi bi-pencil-square"></i> {{-- El icono mantiene reconocimiento rápido de la acción de edición. --}}
                                            <span>Editar</span>
                                        </a>

                                        <form action="{{ route('listacategorias.destroy', $categoria) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('¿Eliminar?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center gap-1"> {{-- El botón eliminar conserva prioridad visual, pero con un acabado más limpio. --}}
                                                <i class="bi bi-trash3-fill"></i> {{-- El icono de papelera facilita la identificación inmediata de la acción. --}}
                                                <span>Eliminar</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5 text-secondary"> {{-- El estado vacío se vuelve más aireado y consistente con el tono sobrio del sistema. --}}
                                    <i class="bi bi-inboxes-fill fs-4 d-block mb-2" style="color: var(--steel-500);"></i> {{-- El icono usa azul acero para integrarse con la paleta elegida. --}}
                                    No hay categorías registradas
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
