@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <!-- Columna izquierda: Imagen + nombre + microchip -->
        <div class="col-md-4">
            <div class="text-center">
                <h2 class="mb-3">{{ $medicalRecord->pet->name }}</h2>
                <p class="text-muted">Microchip: {{ $medicalRecord->pet->num_microchip }}</p>

                <!-- Imagen según especie -->
                @php
                    $species = strtolower($medicalRecord->pet->species);
                    $imagePath = match($species) {
                        'perro' => 'images/perro.jpg',
                        'gato' => 'images/gato.jpg',
                        default => 'images/huron.jpg',
                    };
                @endphp

                <img src="{{ asset($imagePath) }}" alt="Imagen de {{ $medicalRecord->pet->name }}" 
                     class="img-fluid rounded" style="max-width: 300px; border-radius: 8px;">
            </div>
        </div>

        <!-- Columna derecha: Detalles de la cita -->
        <div class="col-md-8 d-flex flex-column justify-content-between">
            <div class="card shadow-sm p-4 d-flex flex-column" style="min-height: 100%;">
                <!-- Fecha y hora -->
                <div class="mb-4 text-start">
                    <h4 class="text-primary">{{ $medicalRecord->created_at->format('d/m/Y') }} - {{ $medicalRecord->appointment->time ?? 'Hora no disponible' }}</h4>
                </div>

                <!-- Diagnóstico / título -->
                <div class="mb-3">
                    <h3 class="fw-bold">{{ $medicalRecord->diagnosis }}</h3>
                </div>

                <!-- Descripción -->
                <div class="mb-4">
                    <p>{{ $medicalRecord->description ?? $medicalRecord->diagnosis }}</p>
                </div>

                <!-- Botones -->
                <div class="mt-auto d-flex justify-content-between">
                    <a href="#" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#prescriptionModal">Ver prescripción </a>
                    <a href="#" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#invoiceModal">Ver factura</a>
                    <a href="{{ route('client.showMedicalRecords', $medicalRecord->pet->id) }}" class="btn btn-secondary">Volver al historial</a>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal de Prescripción -->
<div class="modal fade" id="prescriptionModal" tabindex="-1" aria-labelledby="prescriptionModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-centered">
    <div class="modal-content border-0 shadow">

      <!-- Encabezado del modal -->
      <div class="modal-header bg-primary text-white">
        <h5 class="modal-title" id="prescriptionModalLabel">
          <i class="bi bi-file-earmark-medical-fill me-2"></i>Prescripción médica
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
      </div>

      <!-- Cuerpo del modal -->
      <div class="modal-body">
        @if($medicalRecord->prescription)
          <div class="card border-primary">
            <div class="card-body">
              <h5 class="card-title">Medicamento: <span class="fw-normal">{{ $medicalRecord->prescription->medication }}</span></h5>
              <ul class="list-group list-group-flush mt-3">
                <li class="list-group-item"><strong>Dosificación:</strong> {{ $medicalRecord->prescription->dosage }}</li>
                <li class="list-group-item"><strong>Instrucciones:</strong> {{ $medicalRecord->prescription->instructions }}</li>
                <li class="list-group-item"><strong>Duración:</strong> {{ $medicalRecord->prescription->duration }}</li>
                <li class="list-group-item text-muted"><small>Creada el: {{ \Carbon\Carbon::parse($medicalRecord->prescription->created_at)->format('d/m/Y H:i') }}</small></li>
              </ul>
            </div>
          </div>
        @else
          <p class="text-muted text-center">No hay prescripciones adjuntas a este historial.</p>
        @endif
      </div>

      <!-- Pie del modal -->
      <div class="modal-footer justify-content-between">
        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>

        @if($medicalRecord->prescription)
          <a href="{{ route('prescription.download', $medicalRecord->prescription->id) }}" class="btn btn-primary">
            <i class="bi bi-download me-1"></i>Descargar prescripción
          </a>
        @endif
      </div>

    </div>
  </div>
</div>

<!-- Modal de Factura -->
<div class="modal fade" id="invoiceModal" tabindex="-1" aria-labelledby="invoiceModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow">

            <!-- Encabezado del modal -->
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title" id="invoiceModalLabel">
                    <i class="bi bi-file-earmark-earbuds me-2"></i>Factura
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>

            <!-- Cuerpo del modal -->
            <div class="modal-body">
                <h5>Factura #{{ $medicalRecord->invoice->id }}</h5>
                <p><strong>Cliente:</strong> {{ $medicalRecord->invoice->client->name }}</p>
                <p><strong>Total:</strong> {{ $medicalRecord->invoice->total }} €</p>
                <p><strong>Estado:</strong> {{ $medicalRecord->invoice->status }}</p>

                <h5 class="mt-4">Ítems de la factura:</h5>
                <table class="table table-bordered">
                    <thead>
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

            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cerrar</button>
                <a href="{{ route('invoice.download', $medicalRecord->invoice->id) }}" class="btn btn-primary">
                    <i class="bi bi-download me-1"></i> Descargar factura
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
