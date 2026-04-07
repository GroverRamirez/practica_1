@extends('layouts.app')

@section('title', 'Lista de Productos')
@section('header', 'Productos')

@section('header_actions')
    <a href="{{ route('listaproductos.pdf') }}" target="_blank" rel="noopener" class="btn btn-outline-danger d-inline-flex align-items-center gap-2 shadow-sm">
        <i class="bi bi-file-earmark-pdf-fill"></i>
        <span>Reporte PDF</span>
    </a>

    <a href="{{ route('listaproductos.create') }}" class="btn btn-primary-theme d-inline-flex align-items-center gap-2 shadow-sm">
        <i class="bi bi-plus-circle-fill"></i>
        <span>Nuevo Producto</span>
    </a>
@endsection

@section('content')
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm border-0 panel-card">
            <i class="bi bi-check-circle-fill me-2"></i>
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="panel-card bg-white overflow-hidden">
        <div class="card-body p-0">
            {{-- Esta cabecera agrupa el título del listado, el cuadro de búsqueda y las etiquetas resumen. --}}
            <div class="table-toolbar px-4 py-3 border-bottom">
                <div class="table-toolbar-content mx-auto text-center">
                    <div class="table-summary-title">Catalogo de productos</div>

                    {{-- El formulario usa GET para que la búsqueda viaje en la URL y funcione junto con la paginación. --}}
                    <form action="{{ route('listaproductos.index') }}" method="GET" class="product-search-form d-flex flex-wrap justify-content-center align-items-center gap-2 mt-3">
                        <div class="input-group input-group-sm product-search-group">
                            <span class="input-group-text bg-white border-end-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input
                                type="text"
                                name="buscar"
                                class="form-control border-start-0"
                                placeholder="Buscar producto o categoria"
                                value="{{ $busqueda }}"
                            >
                        </div>

                        <button type="submit" class="btn btn-sm btn-primary-theme d-inline-flex align-items-center gap-1">
                            <i class="bi bi-search"></i>
                            <span>Buscar</span>
                        </button>

                        @if($busqueda !== '')
                            <a href="{{ route('listaproductos.index') }}" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1">
                                <i class="bi bi-x-circle"></i>
                                <span>Limpiar</span>
                            </a>
                        @endif
                    </form>

                    {{-- Estas etiquetas muestran contexto rápido: filtro activo y cantidad visible en pantalla. --}}
                    <div class="d-flex flex-wrap justify-content-center gap-2 mt-2">
                        @if($busqueda !== '')
                            <span class="badge text-bg-light table-summary-pill">Filtro: {{ $busqueda }}</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-theme table-hover align-middle mb-0 productos-table">
                    <thead>
                        <tr>
                            <th class="px-4 py-3 product-id-col">#</th>
                            <th class="py-3 product-name-col">Producto</th>
                            <th class="py-3 product-description-col">Descripcion</th>
                            <th class="py-3 product-price-col">Precio</th>
                            <th class="py-3 product-stock-col text-center">Stock</th>
                            <th class="py-3 product-category-col">Categoria</th>
                            <th class="py-3 product-actions-col text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($productos as $producto)
                            <tr>
                                <td class="px-4 fw-semibold text-secondary">
                                    {{-- firstItem() + $loop->index mantiene numeración continua entre páginas. --}}
                                    {{ $productos->firstItem() + $loop->index }}
                                </td>
                                <td>
                                    <div class="fw-semibold product-name">{{ $producto->nombre }}</div>
                                </td>
                                <td>
                                    {{-- Se recorta la descripción para que la tabla no crezca demasiado en alto. --}}
                                    <div class="product-description">
                                        {{ \Illuminate\Support\Str::limit($producto->descripcion ?: 'Sin descripcion registrada', 85) }}
                                    </div>
                                </td>
                                <td>
                                    <span class="price-text d-block">{{ number_format((float) $producto->precio, 2) }} Bs.</span>
                                </td>
                                <td class="text-center">
                                    <span class="badge rounded-pill stock-pill px-2 py-1">{{ $producto->stock }}</span>
                                </td>
                                <td class="category-cell">
                                    {{-- La categoría llega precargada desde with('categoria') en el controlador. --}}
                                    {{ $producto->categoria->nombre ?? 'Sin categoria' }}
                                </td>
                                <td class="text-center">
                                    <div class="d-inline-flex flex-wrap justify-content-center gap-2">
                                        <a href="{{ route('listaproductos.edit', ['listaproducto' => $producto->id]) }}" class="btn btn-sm btn-outline-secondary d-inline-flex align-items-center gap-1">
                                            <i class="bi bi-pencil-square"></i>
                                            <span>Editar</span>
                                        </a>

                                        <form action="{{ route('listaproductos.destroy', ['listaproducto' => $producto->id]) }}"
                                              method="POST"
                                              class="d-inline"
                                              onsubmit="return confirm('Eliminar este producto?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-outline-danger d-inline-flex align-items-center gap-1">
                                                <i class="bi bi-trash3-fill"></i>
                                                <span>Eliminar</span>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5 text-secondary">
                                    <i class="bi bi-box2-heart-fill fs-4 d-block mb-2" style="color: var(--steel-500);"></i>
                                    {{-- El mensaje cambia si no hay coincidencias para una búsqueda concreta. --}}
                                    @if($busqueda !== '')
                                        No se encontraron productos para "{{ $busqueda }}"
                                    @else
                                        No hay productos registrados
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($productos->hasPages())
                {{-- El pie muestra la página actual y delega la navegación a la vista personalizada de Bootstrap 5. --}}
                <div class="table-footer d-flex flex-column flex-lg-row justify-content-between align-items-lg-center gap-3 px-4 py-3 border-top">
                    <div class="table-summary-text mb-0">
                        Pagina {{ $productos->currentPage() }} de {{ $productos->lastPage() }}
                    </div>

                    <div class="pagination-shell">
                        {{ $productos->onEachSide(1)->links() }}
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
