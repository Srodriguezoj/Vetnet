@extends('layouts.app-admin')

@section('content')
<div class="container">
    <div class="row d-flex align-items-stretch">
        
        <div class="col text-center">
            <h3>Historial clínico de {{ $medicalRecord->pet->name }}</h3>
            @if($medicalRecord->pet->species == 'Perro')
            <img src="{{ asset('images/perro.jpg') }}" class="img-fluid rounded" style="max-width: 250px;">
            @elseif($medicalRecord->pet->species == 'Gato')
            <img src="{{ asset('images/gato.jpg') }}" class="img-fluid rounded" style="max-width: 250px;">
            @else
            <img src="{{ asset('images/huron.jpg') }}" class="img-fluid rounded" style="max-width: 250px;">
            @endif
            <h4 style="text-aling:center"><small class="text-muted">{{ $medicalRecord->pet->num_microchip }}</small></h4>
        </div>
        
        <div class="col-md-8 d-flex">
            <div class="card shadow-sm p-4 w-100">
                <h5>{{ $medicalRecord->created_at->format('d/m/Y') }}-{{ $medicalRecord->appointment->time ?? 'Hora no disponible' }}</h5><br/>
                <h4 class="fw-bold" style="color:#7a7a7a">{{ $medicalRecord->diagnosis }}</h4><br/>
                <p>{{ $medicalRecord->description ?? $medicalRecord->diagnosis }}</p>
                <div class="d-flex justify-content-between" style="margin-top:auto;">
                    <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#prescriptionModal">Ver prescripción</a>
                    <a href="{{ route('veterinary.showPet', $medicalRecord->pet->id) }}" class="btn btn-tertiary">Volver al historial</a>
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
                    <p class="text-muted text-center">No hay prescripciones adjuntas a este historial.</p>
                @endif
            </div>
        </div>
    </div>
</div>


@endsection
