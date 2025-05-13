@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-4">
            <div class="text-center">
                <h3 class="mb-4">Historial clínico de {{ $pet->name }}</h3>
                @if($pet->species == 'Perro')
                    <img src="{{ asset('images/perro.jpg') }}" alt="Imagen de {{ $pet->name }}" class="img-fluid rounded" style="max-width: 300px;border-radius: 8px;">
                @elseif($pet->species == 'Gato')
                    <img src="{{ asset('images/gato.jpg') }}" alt="Imagen de {{ $pet->name }}" class="img-fluid rounded" style="max-width: 300px;border-radius: 8px;">
                @else
                    <img src="{{ asset('images/huron.jpg') }}" alt="Imagen de {{ $pet->name }}" class="img-fluid rounded" style="max-width: 300px;border-radius: 8px;">
                @endif    
                <br/><br/>
                <h4><small class="subtitleText">{{ $pet->num_microchip }}</small></h4>        
            </div>
        </div>
        <div class="col-md-8">
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
                                        <a href="{{ route('medicalRecords.show', $record->id) }}" class="btn btn-primary btn-sm mt-2">Consultar cita</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
                @endif
            <a href="{{ route('client.dashboard') }}" class="btn btn-secondary mt-4">Volver a tus mascotas</a>
        </div>
    </div>
</div>
@endsection
