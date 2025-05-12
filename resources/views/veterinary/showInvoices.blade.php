@extends('layouts.app-admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Listado de Facturas</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Veterinario</th>
                <th>Fecha</th>
                <th>Total (€)</th>
                <th>IVA (%)</th>
                <th>Total con IVA (€)</th>
                <th>Estado</th>
                <th>Cambiar estado</th>
            </tr>
        </thead>
        <tbody>
            @forelse($invoices as $invoice)
                <tr>
                    <td>{{ $invoice->id }}</td>
                    <td>{{ $invoice->client_name }}</td>
                    <td>{{ $invoice->veterinary ? $invoice->veterinary->user->name : 'Desconocido' }}</td>
                    <td>{{ $invoice->date }}</td>
                    <td>{{ number_format($invoice->total, 2) }}</td>
                    <td>{{ $invoice->tax_percentage }}</td>
                    <td>{{ number_format($invoice->total_with_tax, 2) }}</td>
                    <td>
                        @if($invoice->status == 'Pagada')
                            <span class="badge bg-success">{{ $invoice->status }}</span>
                        @elseif($invoice->status == 'Pendiente')
                            <span class="badge bg-warning text-dark">{{ $invoice->status }}</span>
                        @else
                            <span class="badge bg-danger">{{ $invoice->status }}</span>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('invoice.changeState', $invoice->id) }}" method="POST">
                            @csrf
                            @method('POST')
                            <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="Pendiente" {{ $invoice->status == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                <option value="Pagada" {{ $invoice->status == 'Pagada' ? 'selected' : '' }}>Pagada</option>
                                <option value="Anulada" {{ $invoice->status == 'Anulada' ? 'selected' : '' }}>Anulada</option>
                            </select>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">No hay facturas registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection