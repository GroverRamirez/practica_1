@props(['route', 'value' => '', 'placeholder' => 'Buscar'])

<form action="{{ $route }}" method="GET" class="product-search-form d-flex flex-wrap justify-content-center align-items-center gap-2 mt-3 mx-auto" style="max-width: 550px;">
    <div class="input-group input-group-sm product-search-group shadow-sm w-100">
        <span class="input-group-text bg-white border-end-0 text-muted">
            <i class="bi bi-search"></i>
        </span>
        <input
            type="text"
            name="buscar"
            class="form-control border-start-0"
            placeholder="{{ $placeholder }}"
            value="{{ $value }}"
            style="border-right-color: transparent;"
        >
        <button type="submit" class="btn btn-primary-theme d-inline-flex align-items-center gap-1 px-3">
            <span>Buscar</span>
        </button>
    </div>

    @if($value !== '')
        <a href="{{ $route }}" class="btn btn-sm btn-soft-secondary d-inline-flex align-items-center gap-1 shadow-sm">
            <i class="bi bi-x-circle"></i>
            <span>Limpiar</span>
        </a>
    @endif
</form>
