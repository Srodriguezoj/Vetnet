<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            font-size: 16px;
            color: #2e2e2e;
            line-height: 1.6;
            margin: 0;
            padding: 0;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            color: #eb6566;
            margin-top: 0;
        }
        p {
            margin-bottom: 1em;
            font-weight: 400;
        }
        .section { margin-bottom: 12px; }
        .label { font-weight: bold; }
        h1 {
            font-size: 24px;
            color: #eb6566;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            padding: 8px 12px;
            text-align: center;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f4a48f;
            color: #2e2e2e;
            text-transform: uppercase;
        }
        tr:nth-child(even) {
            background-color: #f7f7f7;
        }
        tr:hover {
            background-color: #f2f2f2;
        }
        .total-row {
            font-weight: bold;
            text-align: right;
            margin-top: 20px;
        }
        .total-row p {
            font-size: 1.1em;
        }
        .badge {
            padding: 5px 10px;
            border-radius: 12px;
            font-size: 0.9em;
        }
        .badge-success { background-color: #28a745; color: white; }
        .badge-warning { background-color: #ffc107; color: #212529; }
        .badge-danger { background-color: #dc3545; color: white; }
    </style>
</head>
<body>
    <div style="max-width: 800px; margin: 0 auto; background-color: white; padding: 30px; border-radius: 8px; box-shadow: 0px 4px 10px rgba(0,0,0,0.1);">
        <h1 style="text-aling:center;">Factura #{{ $invoice->id }}</h1>
        <p><strong>Cliente:</strong> {{ $invoice->client->name ?? 'Desconocido' }}</p>
        <p><strong>Estado:</strong>
            @if($invoice->status == 'Pagada')
                <span class="badge badge-success">{{ $invoice->status }}</span>
            @elseif($invoice->status == 'Pendiente')
                <span class="badge badge-warning">{{ $invoice->status }}</span>
            @else
                <span class="badge badge-danger">{{ $invoice->status }}</span>
            @endif
        </p>
        <h3>Conceptos:</h3>
        <table>
            <thead>
                <tr>
                    <th>Producto/Servicio</th>
                    <th>Cantidad</th>
                    <th>Precio Unitario</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->items as $item)
                    <tr>
                        <td>{{ $item->title }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ number_format($item->unit_price, 2) }} €</td>
                        <td>{{ number_format($item->subtotal, 2) }} €</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="total-row">
            <p>Total sin IVA: {{ number_format($invoice->total, 2) }} €</p>
            <p>IVA ({{ $invoice->tax_percentage }}%): {{ number_format($invoice->total * $invoice->tax_percentage / 100, 2) }} €</p>
            <p>Total con IVA: {{ number_format($invoice->total_with_tax, 2) }} €</p>
        </div>
    </div>
</body>
</html>
