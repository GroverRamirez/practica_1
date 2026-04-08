@props(['type' => 'stock', 'value' => '', 'color' => null])

@php
    $classes = '';
    $text = $value;

    if ($type === 'stock') {
        $classes = 'stock-badge px-3 py-1 shadow-sm';
    } elseif ($type === 'category') {
        $classes = 'category-badge';
    } elseif ($type === 'status') {
        $esActivo = in_array(strtolower($value), ['activo', '1', 1], true);
        $classes = 'badge rounded-pill ' . ($esActivo ? 'badge-soft-success' : 'badge-soft-danger');
        $text = $esActivo ? 'Activo' : 'Inactivo';
    } elseif ($color) {
        $classes = "badge rounded-pill badge-soft-{$color}";
    }
@endphp

<span class="{{ $classes }}">
    {{ $text }}
</span>
