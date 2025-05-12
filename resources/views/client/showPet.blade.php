@extends('layouts.app')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<div class="container">
    <h1 class="mb-4">Detalles de la mascota: {{ $pet->name }}</h1>

    <div class="row">
        <!-- Columna izquierda: Información de la mascota -->
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Información básica</h5>

                    <p><strong>Nombre:</strong> {{ $pet->name }}</p>
                    <p><strong>Microchip:</strong> {{ $pet->num_microchip }}</p>
                    <p><strong>Especie:</strong> {{ $pet->species }}</p>
                    <p><strong>Raza:</strong> {{ $pet->breed }}</p>
                    <p><strong>Color:</strong> {{ $pet->colour }}</p>
                    <p><strong>Pelo:</strong> {{ $pet->coat }}</p>
                    <p><strong>Tamaño:</strong> {{ $pet->size }}</p>
                    <p><strong>Peso:</strong> {{ number_format($pet->weight, 2) }} kg</p>
                    <p><strong>Sexo:</strong> {{ $pet->sex }}</p>
                    <p><strong>Fecha de nacimiento:</strong> 
                        {{ $pet->date_of_birth ? \Carbon\Carbon::parse($pet->date_of_birth)->format('d/m/Y') : 'No disponible' }}
                    </p>
                    <p><strong>Edad:</strong> 
                        {{ $pet->date_of_birth ? \Carbon\Carbon::parse($pet->date_of_birth)->age . ' años' : 'No disponible' }}
                    </p>
                </div>
            </div>

            <a href="{{ route('client.dashboard') }}" class="btn btn-secondary mt-3 me-2">Volver a tus mascotas</a>
            <a href="{{ route('pets.editPet', ['pet' => $pet->id]) }}" class="btn btn-primary mt-3">Editar mascota</a>

            <div class="mt-3">
               <a href="{{ route('medicalRecords.show', $record->id) }}" class="btn btn-primary btn-sm">Consultar historia</a>
            </div>
        </div>

        <!-- Columna derecha: Citas -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Citas reservadas</h5>

                    @if ($pet->appointments->isEmpty())
                        <p>No hay citas registradas para esta mascota.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Motivo</th>
                                    <th>Estado</th>  <!-- Columna de estado -->
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($pet->appointments as $appointment)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</td>
                                        <td>{{ $appointment->time }}</td>
                                        <td>{{ $appointment->title }}</td>
                                        <td>{{ $appointment->state }}</td>

                                        <!-- Mostrar el estado de la cita -->
                                        <td>
                                            <!-- No mostrar el botón de eliminar si la cita está cancelada -->
                                            @if ($appointment->state == 'Pendiente' || $appointment->state == 'Confirmada')
                                                <form action="{{ route('appointments.destroy', $appointment->id) }}" method="POST" onsubmit="return confirm('¿Estás segura de cancelar esta cita?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">Cancelar</button>
                                                </form>

                                            @elseif ($appointment->state == 'Completada')
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                    <a href="{{ route('appointments.create') }}" class="btn btn-success mt-3">Reservar nueva cita</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection