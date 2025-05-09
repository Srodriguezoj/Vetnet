@extends('layouts.app')

@section('content')
    <h1>Detalles de la mascota: {{ $pet->name }}</h1>

    <div class="card mb-3">
        <div class="card-body">
            <h5 class="card-title">Información básica</h5>

            <p class="card-text"><strong>Nombre:</strong> {{ $pet->name }}</p>
            <p class="card-text"><strong>Microchip:</strong> {{ $pet->num_microchip }}</p>
            <p class="card-text"><strong>Especie:</strong> {{ $pet->species }}</p>
            <p class="card-text"><strong>Raza:</strong> {{ $pet->breed }}</p>
            <p class="card-text"><strong>Color:</strong> {{ $pet->colour }}</p>
            <p class="card-text"><strong>Pelo:</strong> {{ $pet->coat }}</p>
            <p class="card-text"><strong>Tamaño:</strong> {{ $pet->size }}</p>
            <p class="card-text"><strong>Peso:</strong> {{ number_format($pet->weight, 2) }} kg</p>
            <p class="card-text"><strong>Sexo:</strong> {{ $pet->sex }}</p>
            
            <p class="card-text"><strong>Fecha de nacimiento:</strong> 
                @if ($pet->date_of_birth)
                    {{ \Carbon\Carbon::parse($pet->date_of_birth)->format('d/m/Y') }}
                @else
                    <span>No disponible</span>
                @endif
            </p>

            <p class="card-text"><strong>Edad:</strong> 
                @if ($pet->date_of_birth)
                    {{ \Carbon\Carbon::parse($pet->date_of_birth)->age }} años
                @else
                    <span>No disponible</span>
                @endif
            </p>
        </div>
    </div>

    <h3>Historial médico</h3>
    @if ($pet->medicalRecords->isEmpty())
        <p>No se ha registrado historial médico para esta mascota.</p>
    @else
        <ul>
            @foreach ($pet->medicalRecords as $record)
                <li>
                    <strong>{{ \Carbon\Carbon::parse($record->date)->format('d/m/Y') }}:</strong> {{ $record->description }}
                </li>
            @endforeach
        </ul>
    @endif

    <a href="{{ route('client.dashboard') }}" class="btn btn-secondary">Volver a tus mascotas</a>
    <a href="{{ route('pets.editPet', ['pet' => $pet->id]) }}" class="btn btn-primary">Editar mascota</a>
@endsection