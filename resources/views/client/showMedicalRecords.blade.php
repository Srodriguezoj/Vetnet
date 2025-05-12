@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Historial clínico de {{ $pet->name }}</h1>

    @if ($pet->medicalRecords->isEmpty())
        <p>No hay historial clínico registrado para esta mascota.</p>
    @else
        <table class="table table-bordered">
            <thead class="thead-dark">
                <tr>
                    <th>Fecha</th>
                    <th>Diagnóstico</th>
                    <th>Veterinario/a</th>
                    <th>Cita</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($pet->medicalRecords as $record)
                    <tr>
                        <td>{{ $record->created_at->format('d/m/Y') }}</td>
                        <td>{{ $record->diagnosis }}</td>
                        <td>{{ $record->veterinary->user->name ?? 'N/D' }}</td>
                        <td>{{ $record->appointment->time ?? '' }}</td>
                        <td>
                            <a href="{{ route('medicalRecords.show', $record->id) }}" class="btn btn-primary btn-sm">Ver detalle</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <a href="{{ route('client.dashboard') }}" class="btn btn-secondary mt-4">Volver a tus mascotas</a>
</div>
@endsection