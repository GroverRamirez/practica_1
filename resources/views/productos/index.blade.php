@extends('layouts.app') {{-- Hereda la plantilla base del proyecto para reutilizar la estructura general sin repetir HTML en cada vista. --}}

@section('title', 'Lista de Productos') {{-- Define el contenido que el layout insertará en @yield('title'). --}}
@section('header', 'Productos') {{-- Define el título visible que el layout mostrará en @yield('header'). --}}

@section('header_actions') {{-- Esta sección llena el espacio de acciones del encabezado definido en el layout. --}}
    <a href="{{ route('listaproductos.create') }}" class="btn btn-primary-theme d-inline-flex align-items-center gap-2 shadow-sm"> {{-- El botón principal se adapta al azul marino profesional para mantener coherencia con todo el panel. --}}
        <i class="bi bi-plus-circle-fill"></i> {{-- El icono refuerza visualmente la acción principal del módulo. --}}
        <span>Nuevo Producto</span>
    </a>
@endsection

@section('content') {{-- Todo este bloque se inserta en el @yield('content') del layout. --}}
    {{-- El mensaje flash se muestra después de crear, actualizar o eliminar un producto. --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 panel-card"> {{-- El mensaje se presenta como una alerta más limpia y alineada con el estilo general del sistema. --}}
            <i class="bi bi-check-circle-fill me-2"></i> {{-- El icono de confirmación se conserva para dar contexto rápido al mensaje. --}}
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="panel-card bg-white"> {{-- La tabla se encierra en una card sobria para mejorar orden y lectura visual. --}}
        <div class="card-body p-0">
            <div class="table-responsive"> {{-- La tabla se mantiene adaptable para conservar usabilidad en distintas pantallas. --}}
                <table class="table table-theme table-hover align-middle mb-0"> {{-- Se refuerza la apariencia de tabla administrativa con una clase temática común. --}}
                    <thead>
                        <tr>
                            <th class="px-4 py-3">ID</th>
                            <th class="py-3">Nombre</th>
                            <th class="py-3">Descripción</th>
                            <th class="py-3">Precio</th>
                            <th class="py-3">Stock</th>
                            <th class="py-3">Categoría</th>
                            <th class="py-3 text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        {{-- @forelse recorre los productos y, si no hay registros, ejecuta el bloque @empty. --}}
                        @forelse($productos as $producto) {{-- $productos llega desde el controlador y aquí se recorre producto por producto para construir la tabla. --}}
                            <tr>
                                <td class="px-4 fw-semibold text-secondary">{{ $producto->id }}</td> {{-- El ID usa un tono menos dominante para priorizar la lectura del contenido principal. --}}
                                <td class="fw-semibold">{{ $producto->nombre }}</td> {{-- El nombre del producto gana peso visual para una lectura más rápida del listado. --}}
                                <td>{{ $producto->descripcion ?? '-' }}</td>
                                <td><span class="price-text">{{ $producto->precio }} Bs.</span></td> {{-- El precio se formatea como dato importante usando el color principal del tema. --}}
                                <td><span class="badge rounded-pill stock-pill px-3 py-2">{{ $producto->stock }}</span></td> {{-- El stock se encapsula en un badge suave para mejorar legibilidad y orden. --}}
                                <td>{{ $producto->categoria->nombre ?? 'Sin categoría' }}</td> {{-- Antes podía fallar si la relación no cargaba; ahora muestra un texto seguro. --}}
                                <td class="text-center">
                                    <div class="d-inline-flex gap-2"> {{-- Las acciones se agrupan para que la fila se vea más limpia y equilibrada. --}}
                                        <a href="{{ route('listaproductos.edit', ['listaproducto' => $producto->id]) }}" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1"> {{-- Editar pasa a un estilo más sobrio que armoniza mejor con el panel. --}}
                                            <i class="bi bi-pencil-square"></i> {{-- El icono permite reconocer de inmediato la acción de edición. --}}
                                            <span>Editar</span>
                                        </a>

                                        {{-- Este formulario usa DELETE para eliminar el producto actual desde la fila de la tabla. --}}
                                        <form action="{{ route('listaproductos.destroy', ['listaproducto' => $producto->id]) }}" {{-- También se usa el ID en eliminación para evitar ambigüedad al construir la URL del recurso. --}}
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('¿Eliminar?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center gap-1"> {{-- El botón eliminar mantiene su intención, pero con una presencia visual más controlada. --}}
                                                <i class="bi bi-trash3-fill"></i> {{-- El icono de papelera mantiene la acción claramente identificable. --}}
                                                <span>Eliminar</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-secondary"> {{-- El estado vacío se adapta a la estética limpia del nuevo tema. --}}
                                    <i class="bi bi-box2-heart-fill fs-4 d-block mb-2" style="color: var(--steel-500);"></i> {{-- El icono usa un acento azul suave para mantener coherencia cromática. --}}
                                    No hay productos registrados
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
