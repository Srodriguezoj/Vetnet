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
                        <th>Ver factura</th>
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
                            <td>
                                <button class="btn btn-primary btn-sm text-white" data-bs-toggle="modal" data-bs-target="#invoiceModal{{ $invoice->id }}">Ver factura</button>
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
        @foreach ($invoices as $invoice)
        <!-- Info Factura -->
        <div class="modal fade" id="invoiceModal{{ $invoice->id }}" tabindex="-1" aria-labelledby="invoiceModalLabel{{ $invoice->id }}" aria-hidden="true">
            <div class="modal-dialog modal-xl" style="max-width:800px;">
                <div class="modal-content shadow-sm rounded" style="margin-top:5% !important;">
                    <div class="modal-header" style="background-color:#eb6566; color: white;">
                        <h5 class="text-uppercase" id="invoiceModalLabel{{ $invoice->id }}" style="color: #2e2e2e;">Factura #{{ $invoice->id }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <p><strong>Veterinario:</strong> {{ $invoice->veterinary->user->name ?? 'Desconocido' }}</p>
                        <p><strong>Cliente:</strong> {{ $invoice->client->name ?? 'Desconocido' }}</p>
                        <p><strong>Fecha:</strong> {{ \Carbon\Carbon::parse($invoice->date)->format('d/m/Y') }}</p>
                        <p><strong>Estado:</strong>
                            @if($invoice->status == 'Pagada')
                                <span class="badge bg-success">{{ $invoice->status }}</span>
                            @elseif($invoice->status == 'Pendiente')
                                <span class="badge bg-warning text-dark">{{ $invoice->status }}</span>
                            @else
                                <span class="badge bg-danger">{{ $invoice->status }}</span>
                            @endif
                        </p>
                        <hr>
                        @if ($invoice->items->isNotEmpty())
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle text-center shadow-sm rounded" style="background-color: #fdfafa;">
                                    <thead style="background-color:#f4a48f; color:#2e2e2e" class="text-uppercase">
                                        <tr>
                                            <th>Concepto</th>
                                            <th>Cantidad</th>
                                            <th>Precio unitario (€)</th>
                                            <th>Subtotal (€)</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($invoice->items as $item)
                                            <tr>
                                                <td>{{ $item->title }}</td>
                                                <td>{{ $item->quantity }}</td>
                                                <td>{{ number_format($item->unit_price, 2) }}</td>
                                                <td>{{ number_format($item->subtotal, 2) }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            <p class="text-end fw-bold">Total sin IVA: {{ number_format($invoice->total, 2) }} €</p>
                            <p class="text-end fw-bold">IVA ({{ $invoice->tax_percentage }}%): {{ number_format($invoice->total * $invoice->tax_percentage / 100, 2) }} €</p>
                            <p class="text-end fw-bold fs-5">Total con IVA: {{ number_format($invoice->total_with_tax, 2) }} €</p>
                        @else
                            <p class="text-muted">No hay conceptos registrados en esta factura.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endsection
