@extends('layouts.app-admin')

@section('content')
    <div class="container-fluid px-3">
        <h2 class="mb-4 text-uppercase fw-bold" style="color: #eb6566;">Listado de Citas</h2>

        @if(session('success'))
            <div class="alert alert-success rounded">{{ session('success') }}</div>
        @endif

        <div class="table-responsive">
            <table class="table table-bordered align-middle text-center shadow-sm rounded" style="background-color: #ffffff;">
                <thead class="text-uppercase" style="background-color:#f4a48f; color:#2e2e2e">
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
                            <td>{{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</td>
                            <td>{{ $appointment->time }}</td>
                            <td>{{ $appointment->veterinary->user->name ?? 'Desconocido' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center">No hay citas registradas.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
