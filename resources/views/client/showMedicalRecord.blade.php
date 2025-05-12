@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Detalle del historial clínico</h1>
    <h3>Diagnóstico: {{ $medicalRecord->diagnosis }}</h3>
    <p>Fecha: {{ $medicalRecord->created_at->format('d/m/Y') }}</p>
    <p>Veterinario/a: {{ $medicalRecord->veterinary->user->name ?? 'N/D' }}</p>
    <p>Cita: {{ $medicalRecord->appointment->time ?? 'N/D' }}</p>
    <p>Descripción: {{ $medicalRecord->diagnosis }}</p>
    
    <a href="{{ route('client.showMedicalRecords', $medicalRecord->pet->id) }}" class="btn btn-secondary mt-4">Volver al historial clínico</a>
</div>
@endsection