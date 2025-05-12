<h1>Factura #{{ $invoice->id }}</h1>
<p><strong>Cliente:</strong> {{ $invoice->client->name }}</p>
<p><strong>Total:</strong> {{ $invoice->total }} €</p>
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