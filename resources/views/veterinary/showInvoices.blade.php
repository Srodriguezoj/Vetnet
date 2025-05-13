@extends('layouts.app-admin')

@section('content')
    <div class="container-fluid px-3">
        <h2 class="mb-4 text-uppercase fw-bold" style="color: #eb6566;">Listado de Facturas</h2>
        @if(session('success'))
            <div class="alert alert-success rounded">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center shadow-sm rounded w-100" style="background-color: #ffffff; min-width: 1200px;">
                <thead class="text-uppercase" style="background-color:#f4a48f; color:#2e2e2e">
                    <tr>
                        <th>#</th>
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
                            <td>{{ $invoice->veterinary ? $invoice->veterinary->user->name : 'Desconocido' }}</td>
                            <td>{{ \Carbon\Carbon::parse($invoice->date)->format('d/m/Y') }}</td>
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
                                    <select name="status" class="form-select form-select-sm rounded-pill" onchange="this.form.submit()">
                                        <option value="Pendiente" {{ $invoice->status == 'Pendiente' ? 'selected' : '' }}>Pendiente</option>
                                        <option value="Pagada" {{ $invoice->status == 'Pagada' ? 'selected' : '' }}>Pagada</option>
                                        <option value="Anulada" {{ $invoice->status == 'Anulada' ? 'selected' : '' }}>Anulada</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="9" class="text-center">No hay facturas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
