@extends('layouts.app-admin')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="container">
    <div class="row mb-4">
        <div class="col-md-4 d-flex align-items-center">
            @php
                $speciesImages = [
                    'Perro' => 'perro.jpg',
                    'Gato' => 'gato.jpg',
                    'Huron' => 'huron.jpg'
                ];
                $imagePath = $speciesImages[$pet->species] ?? 'default.jpg';
            @endphp
            <div class="text-center">
                <img src="{{ asset('images/' . $imagePath) }}" class="card-img-top mb-3" style="height: 300px; object-fit: cover;">
                <h3>{{ $pet->name }}</h3>
            </div>
        </div>

        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">Información básica</h5>
                    <p><b>Nombre:</b> {{ $pet->name }}</p>
                    <p><b>Microchip:</b> {{ $pet->num_microchip }}</p>
                    <p><b>Especie:</b> {{ $pet->species }}</p>
                    <p><b>Raza:</b> {{ $pet->breed }}</p>
                    <p><b>Color:</b> {{ $pet->colour }}</p>
                    <p><b>Pelo:</b> {{ $pet->coat }}</p>
                    <p><b>Tamaño:</b> {{ $pet->size }}</p>
                    <p><b>Peso:</b> {{ number_format($pet->weight, 2) }} kg</p>
                    <p><b>Sexo:</b> {{ $pet->sex }}</p>
                    <p><b>Fecha de nacimiento:</b> {{ $pet->date_of_birth ? \Carbon\Carbon::parse($pet->date_of_birth)->format('d/m/Y') : 'No disponible' }}</p>
                    <p><b>Edad:</b> {{ $pet->date_of_birth ? \Carbon\Carbon::parse($pet->date_of_birth)->age . ' años' : 'No disponible' }}</p>
                    <div class="mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#vaccinesModal">Vacunas</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-4">
     @if ($pet->medicalRecords->isNotEmpty())
                @if ($pet->medicalRecords->isEmpty())
                    <p>No hay historial clínico registrado para esta mascota.</p>
                @else
                    <div class="row">
                        @foreach ($pet->medicalRecords as $record)
                            <div class="col-md-12 mb-3">
                                <div class="card shadow-sm">
                                    <div class="card-body d-flex justify-content-between">
                                        <div class="d-flex flex-column">
                                            <span class="font-weight-bold">{{ $record->created_at->format('d/m/Y') }}</span>
                                            <span class="mt-2">{{ $record->diagnosis }}</span>
                                        </div>
                                        <div class="d-flex flex-column align-items-end">
                                            <a href="{{ route('veterinary.medicalRecords.show', [$pet->id, $record->id]) }}" class="btn btn-primary btn-sm mt-2">Consultar historial</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    @endif
            </div>
        @else
        <p class="text-muted mt-2">No hay registros médicos para esta mascota.</p>
        @endif 
        </div>

        <!-- Info vacunas -->
        <div class="modal fade" id="vaccinesModal" tabindex="-1" aria-labelledby="vaccinesModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content shadow-sm rounded">
            <div class="modal-header" style="background-color:#eb6566; color: white;">
                <h5 class="text-uppercase" id="vaccinesModalLabel" style="color: #2e2e2e;">Vacunas de {{ $pet->name }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                @if ($pet->vaccinations && $pet->vaccinations->isNotEmpty())
                <div class="table-responsive">
                <table class="table table-bordered align-middle text-center shadow-sm rounded" style="background-color: #fdfafa;">
                    <thead style="background-color:#f4a48f; color:#2e2e2e" class="text-uppercase">
                        <tr>
                            <th>Tipo de vacuna</th>
                            <th>Etiqueta</th>
                            <th>Número de lote</th>
                            <th>Número de expedición</th>
                            <th>Fecha de administración</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pet->vaccinations as $vaccination)
                        <tr>
                            <td>{{ $vaccination->vaccine->vaccine_type }}</td>
                            <td>{{ $vaccination->vaccine->stamp }}</td>
                            <td>{{ $vaccination->vaccine->batch_num }}</td>
                            <td>{{ $vaccination->vaccine->expedition_number }}</td>
                            <td>{{ \Carbon\Carbon::parse($vaccination->date_administered)->format('d/m/Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                </div>
                @else
                <p class="text-muted">No se han administrado vacunas a esta mascota.</p>
                @endif
            </div>
            </div>
        </div>
    </div>
</div>
@endsection
