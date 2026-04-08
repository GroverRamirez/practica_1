@extends('layouts.app')

@section('title', 'Editar Categoría')
@section('header', 'Modificando Categoría')

@section('content')
    <div class="panel-card bg-white mt-2 mb-4 mx-auto" style="max-width: 700px;">
        <div class="card-body p-4 p-lg-5">
            <div class="d-flex justify-content-between align-items-center border-bottom pb-3 mb-4">
                <h5 class="table-summary-title mb-0">Detalles Exactos de la Categoría</h5>
                <span class="badge badge-soft-success">ID: {{ $categoria->id }}</span>
            </div>

            <form action="{{ route('categorias.update', $categoria->id) }}" method="post">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <div class="col-md-12">
                        <label for="nombre" class="form-label fw-semibold text-secondary">Nombre de la categoría <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" id="nombre" value="{{ old('nombre', $categoria->nombre) }}" required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="descripcion" class="form-label fw-semibold text-secondary">Descripción</label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" id="descripcion" rows="4">{{ old('descripcion', $categoria->descripcion) }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="estado" class="form-label fw-semibold text-secondary">Estado Operativo <span class="text-danger">*</span></label>
                        <select class="form-select form-control @error('estado') is-invalid @enderror" name="estado" id="estado" required>
                            <option value="activo" {{ old('estado', $categoria->estado) == 'activo' ? 'selected' : '' }}>Activo</option>
                            <option value="inactivo" {{ old('estado', $categoria->estado) == 'inactivo' ? 'selected' : '' }}>Inactivo</option>
                        </select>
                        @error('estado')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-5 d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('categorias.index') }}" class="btn btn-soft-secondary px-4">Cancelar Edición</a>
                    <button type="submit" class="btn btn-primary-theme px-4 d-inline-flex align-items-center gap-2">
                        <i class="bi bi-cloud-upload-fill"></i>
                        Actualizar Categoría
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
