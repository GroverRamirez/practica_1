@extends('layouts.app')

@section('title', 'Nueva Categoría')
@section('header', 'Agregar una Nueva Categoría')

@section('content')
    <div class="panel-card bg-white mt-2 mb-4 mx-auto" style="max-width: 700px;">
        <div class="card-body p-4 p-lg-5">
            <h5 class="table-summary-title mb-4 border-bottom pb-3">Información de la Categoría</h5>

            <form action="{{ route('categorias.store') }}" method="post">
                @csrf

                <div class="row g-4">
                    <div class="col-md-12">
                        <label for="nombre" class="form-label fw-semibold text-secondary">Nombre de la categoría <span class="text-danger">*</span></label>
                        <input type="text" class="form-control @error('nombre') is-invalid @enderror" name="nombre" id="nombre" value="{{ old('nombre') }}" placeholder="Ej. Laptops" required>
                        @error('nombre')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-12">
                        <label for="descripcion" class="form-label fw-semibold text-secondary">Descripción</label>
                        <textarea class="form-control @error('descripcion') is-invalid @enderror" name="descripcion" id="descripcion" rows="4" placeholder="Breve descripción interna...">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mt-5 d-flex justify-content-end gap-2 pt-3 border-top">
                    <a href="{{ route('categorias.index') }}" class="btn btn-soft-secondary px-4">Cancelar</a>
                    <button type="submit" class="btn btn-primary-theme px-4 d-inline-flex align-items-center gap-2">
                        <i class="bi bi-save2"></i>
                        Confirmar Registro
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
