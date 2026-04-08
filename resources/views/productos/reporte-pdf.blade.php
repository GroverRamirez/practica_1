<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte de Productos</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            color: #1f2937;
            font-size: 12px;
        }

        .header {
            border-bottom: 2px solid #1d4ed8;
            margin-bottom: 20px;
            padding-bottom: 12px;
        }

        .title {
            font-size: 22px;
            font-weight: 700;
            margin: 0 0 6px;
        }

        .subtitle {
            margin: 0;
            color: #4b5563;
        }

        .summary {
            width: 100%;
            margin: 18px 0;
            border-collapse: separate;
            border-spacing: 12px 0;
        }

        .summary td {
            background: #eff6ff;
            border: 1px solid #bfdbfe;
            border-radius: 8px;
            padding: 10px 12px;
            width: 33.33%;
        }

        .summary-label {
            display: block;
            font-size: 10px;
            text-transform: uppercase;
            color: #1d4ed8;
            margin-bottom: 4px;
        }

        .summary-value {
            font-size: 18px;
            font-weight: 700;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            background: #1e3a8a;
            color: #ffffff;
            font-size: 11px;
            text-align: left;
            padding: 10px 8px;
        }

        tbody td {
            border-bottom: 1px solid #dbe3f0;
            padding: 9px 8px;
            vertical-align: top;
        }

        tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .text-right {
            text-align: right;
        }

        .empty {
            text-align: center;
            padding: 20px;
            color: #6b7280;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">Reporte de Productos</h1>
        <p class="subtitle">Fecha de generacion: {{ $fechaGeneracion->format('d/m/Y H:i') }}</p>
    </div>

    <table class="summary">
        <tr>
            <td>
                <span class="summary-label">Total productos</span>
                <span class="summary-value">{{ $productos->count() }}</span>
            </td>
            <td>
                <span class="summary-label">Stock acumulado</span>
                <span class="summary-value">{{ $productos->sum('stock') }}</span>
            </td>
            <td>
                <span class="summary-label">Valor inventario</span>
                <span class="summary-value">{{ number_format($productos->sum(fn ($producto) => $producto->precio * $producto->stock), 2) }} Bs.</span>
            </td>
        </tr>
    </table>

    <table>
        <thead>
            <tr>
                <th style="width: 6%;">Nro</th>
                <th style="width: 18%;">Nombre</th>
                <th style="width: 28%;">Descripcion</th>
                <th style="width: 16%;">Categoria</th>
                <th style="width: 10%;" class="text-right">Precio</th>
                <th style="width: 8%;" class="text-right">Stock</th>
                <th style="width: 14%;" class="text-right">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($productos as $producto)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $producto->nombre }}</td>
                    <td>{{ $producto->descripcion ?: '-' }}</td>
                    <td>{{ $producto->categoria->nombre ?? 'Sin categoria' }}</td>
                    <td class="text-right">{{ number_format((float) $producto->precio, 2) }} Bs.</td>
                    <td class="text-right">{{ $producto->stock }}</td>
                    <td class="text-right">{{ number_format((float) $producto->precio * $producto->stock, 2) }} Bs.</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="empty">No hay productos registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
