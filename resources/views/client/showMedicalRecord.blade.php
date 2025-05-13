@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row d-flex align-items-stretch">
        <div class="col-md-4 text-center d-flex flex-column justify-content-start">
            <h3 class="mb-4">Historial clínico de {{ $medicalRecord->pet->name }}</h3>
            @if($medicalRecord->pet->species == 'Perro')
            <img src="{{ asset('images/perro.jpg') }}" class="img-fluid rounded" style="max-width: 250px;">
            @elseif($medicalRecord->pet->species == 'Gato')
            <img src="{{ asset('images/gato.jpg') }}" class="img-fluid rounded" style="max-width: 250px;">
            @else
            <img src="{{ asset('images/huron.jpg') }}" class="img-fluid rounded" style="max-width: 250px;">
            @endif
            <h4><small class="subtitleText">{{ $medicalRecord->pet->num_microchip }}</small></h4>
        </div>
        <div class="col-md-8 d-flex">
            <div class="card shadow-sm p-4 w-100">
                <h5>{{ $medicalRecord->created_at->format('d/m/Y') }}-{{ $medicalRecord->appointment->time ?? 'Hora no disponible' }}</h5><br/>
                <h4 class="fw-bold" style="color:#7a7a7a">{{ $medicalRecord->diagnosis }}</h4><br/>
                <p>{{ $medicalRecord->description ?? $medicalRecord->diagnosis }}</p>
                <div class="d-flex justify-content-between" style="margin-top:auto;">
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#prescriptionModal">Ver prescripción</a>
                    <a href="#" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#invoiceModal">Ver factura</a>
                    <a href="{{ route('client.showMedicalRecords', $medicalRecord->pet->id) }}" class="btn btn-tertiary">Volver al historial</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Prescripción -->
<div class="modal fade" id="prescriptionModal" tabindex="-1" aria-labelledby="prescriptionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" style="max-width:700px;">
        <div class="modal-content shadow-sm rounded" style="margin-top:5% !important">
            <div class="modal-header" style="background-color:#eb6566; color: white;">
                <h5 class="text-uppercase" id="prescriptionModalLabel" style="color: #2e2e2e;">Prescripción médica</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                @if($medicalRecord->prescription)
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Medicamento: <span class="fw-normal"> {{ $medicalRecord->prescription->medication }}</span></h5>
                            <ul class="list-group list-group-flush mt-3">
                                <li class="list-group-item"><strong>Dosis:</strong> {{ $medicalRecord->prescription->dosage }}</li>
                                <li class="list-group-item"><strong>Instrucciones:</strong> {{ $medicalRecord->prescription->instructions }}</li>
                                <li class="list-group-item"><strong>Duración:</strong> {{ $medicalRecord->prescription->duration }}</li>
                            </ul>
                        </div>
                    </div>
                @else
                    <p class="subtitleText text-center">No hay prescripciones adjuntas a este historial.</p>
                @endif
            </div>
            <div class="modal-footer justify-content-between">
                @if($medicalRecord->prescription)
                    <a href="{{ route('prescription.download', $medicalRecord->prescription->id) }}" class="btn btn-primary">Descargar prescripción</a>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Factura -->
<div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" style="max-width:800px;">
        <div class="modal-content shadow-sm rounded" style="margin-top:5% !important">
            <div class="modal-header" style="background-color:#eb6566; color: white;">
                @if($medicalRecord->invoice)
                    <h5 class="text-uppercase" id="invoiceModalLabel" style="color: #2e2e2e;">Factura #{{ $medicalRecord->invoice->id }}</h5>
                @else
                    <h5 class="text-uppercase" id="invoiceModalLabel" style="color: #2e2e2e;">Factura no disponible</h5>
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                @if($medicalRecord->invoice)
                    <p><strong>Cliente:</strong> {{ $medicalRecord->invoice->client->name }}</p>
                    <p><strong>Estado:</strong>
                        @if($medicalRecord->invoice->status == 'Pagada')
                            <span class="badge bg-success">{{ $medicalRecord->invoice->status }}</span>
                        @elseif($medicalRecord->invoice->status == 'Pendiente')
                            <span class="badge bg-warning text-dark">{{ $medicalRecord->invoice->status }}</span>
                        @else
                            <span class="badge bg-danger">{{ $medicalRecord->invoice->status }}</span>
                        @endif
                    </p>
                    <h5 class="mt-4">Conceptos:</h5>
                    @if($medicalRecord->invoice->items->isNotEmpty())
                        <div class="table-responsive">
                            <table class="table table-bordered align-middle text-center shadow-sm rounded" style="background-color: #fdfafa;">
                                <thead style="background-color:#f4a48f; color:#2e2e2e" class="text-uppercase">
                                    <tr>
                                        <th>Producto/Servicio</th>
                                        <th>Cantidad</th>
                                        <th>Precio Unitario</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($medicalRecord->invoice->items as $item)
                                        <tr>
                                            <td>{{ $item->title }}</td>
                                            <td>{{ $item->quantity }}</td>
                                            <td>{{ number_format($item->unit_price, 2) }} €</td>
                                            <td>{{ number_format($item->subtotal, 2) }} €</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <p class="text-end fw-bold">Total sin IVA: {{ number_format($medicalRecord->invoice->total, 2) }} €</p>
                        <p class="text-end fw-bold">IVA ({{ $medicalRecord->invoice->tax_percentage }}%): {{ number_format($medicalRecord->invoice->total * $medicalRecord->invoice->tax_percentage / 100, 2) }} €</p>
                        <p class="text-end fw-bold fs-5">Total con IVA: {{ number_format($medicalRecord->invoice->total_with_tax, 2) }} €</p>
                    @else
                        <p class="subtitleText">No existe factura.</p>
                    @endif
                @else
                    <p class="subtitleText">No existe factura.</p>
                @endif
            </div>
           <div class="modal-footer justify-content-between">
                @if($medicalRecord->invoice)
                    <a href="{{ route('invoice.download', $medicalRecord->invoice->id) }}" class="btn btn-primary">Descargar factura</a>
                @endif
            </div>
        </div>
    </div>
</div>


@endsection
