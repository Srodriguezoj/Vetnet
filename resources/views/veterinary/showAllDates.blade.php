@extends('layouts.app-admin')

@section('content')
<div class="container">
    <h2 class="mb-4">Listado de Citas</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Cliente</th>
                <th>Mascota</th>
                <th>Fecha</th>
                <th>Hora</th>
                <th>Veterinario</th>
            </tr>
        </thead>
        <tbody>
            @forelse($appointments as $appointment)
                <tr>
                    <td>{{ $appointment->id }}</td>
                    <td>{{ $appointment->pet->owner->name ?? 'Desconocido' }}</td> 
                    <td>{{ $appointment->pet->name ?? 'Desconocida' }}</td>
                    <td>{{ $appointment->date }}</td>
                    <td>{{ $appointment->time }}</td>
                    <td>{{ $appointment->veterinary->user->name ?? 'Desconocido' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">No hay citas registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection