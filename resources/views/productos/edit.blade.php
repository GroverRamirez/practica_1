@extends('layouts.app') 

@section('title', 'Editar Producto') 
@section('header', 'Modificando Producto') 

@section('content') 
    <div class="panel-card bg-white mt-2 mb-4 mx-auto" style="max-width: 800px;">
        <div class="card-body p-4 p-lg-5">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                <h5 class="table-summary-title mb-0">Detalles Exactos del Producto</h5>
                <span class="badge badge-soft-success">ID: {{ $producto->id }}</span>
            </div>
            
            <form action="{{ route('productos.update', $producto->id) }}" method="post">
                @csrf 
                @method('PUT')

                <div class="row g-4">
                    <div class="col-md-12">
                        <label for="nombre" class="form-label fw-semibold text-secondary">Nombre del producto <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" id="nombre" value="{{ old('nombre', $producto->nombre) }}" required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="descripcion" class="form-label fw-semibold text-secondary">Descripción</label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" id="descripcion" rows="4">{{ old('descripcion', $producto->descripcion) }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="precio" class="form-label fw-semibold text-secondary">Precio (Bs.) <span class="text-danger">*</span></label>
                        <div class="input-group">
                            <span class="input-group-text">Bs.</span>
                            <input type="number" step="0.01" class="form-control @error('precio') is-invalid @enderror" name="precio" id="precio" value="{{ old('precio', $producto->precio) }}" required>
                            @error('precio')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="col-md-6">
                        <label for="stock" class="form-label fw-semibold text-secondary">Stock Actual <span class="text-danger">*</span></label>
                        <input type="number" class="form-control @error('stock') is-invalid @enderror" name="stock" id="stock" value="{{ old('stock', $producto->stock) }}" required>
                        @error('stock')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="categoria_id" class="form-label fw-semibold text-secondary">Categoría Asociada <span class="text-danger">*</span></label>
                        <select class="form-select form-control @error('categoria_id') is-invalid @enderror" name="categoria_id" id="categoria_id" required>
                            <option value="">Seleccione una categoría</option>
                            @foreach($categorias as $categoria)
                                <option value="{{ $categoria->id }}" {{ old('categoria_id', $producto->categoria_id) == $categoria->id ? 'selected' : '' }}>
                                    {{ $categoria->nombre }} ({{ $categoria->estado }})
                                </option>
                            @endforeach
                        </select>
                        @error('categoria_id')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-5 d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('productos.index') }}" class="btn btn-soft-secondary px-4">Cancelar Edición</a>
                    <button type="submit" class="btn btn-primary-theme px-4 d-inline-flex align-items-center gap-2">
                        <i class="bi bi-cloud-upload-fill"></i>
                        Actualizar Producto
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
