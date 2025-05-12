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
                display: flex;
                flex-direction: column;
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
            h1{font-size:20px !important;}
        </style>
    </head>
    <body>
        <h1>Factura #{{ $invoice->id }}</h1>
        <p><strong>Cliente:</strong> {{ $invoice->client->name }}</p>
        <p><strong>Total:</strong> {{ $invoice->total }} €</p>
        <p><strong>IVA:</strong> {{ $invoice->tax_percentage }} €</p>
        <p><strong>Total con IVA:</strong> {{ $invoice->total_with_tax }} €</p>
        <p><strong>Estado:</strong> {{ $invoice->status }}</p>

        <h3>Ítems de la factura:</h3>
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
            
    </body>
</html>