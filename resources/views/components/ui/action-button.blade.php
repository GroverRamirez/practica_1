@props(['action' => 'edit', 'url' => '#', 'confirm' => null])

@if ($action === 'edit')
    <a href="{{ $url }}" class="btn btn-sm btn-soft-secondary d-inline-flex align-items-center gap-1">
        <i class="bi bi-pencil-square"></i>
        <span>Editar</span>
    </a>
@elseif ($action === 'delete')
    <form action="{{ $url }}" method="POST" class="d-inline"
        @if($confirm) onsubmit="return confirm('{{ $confirm }}');" @endif>
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-sm btn-soft-danger d-inline-flex align-items-center gap-1">
            <i class="bi bi-trash3-fill"></i>
            <span>Eliminar</span>
        </button>
    </form>
@endif
