@extends('layouts.app-admin')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<div class="container">
    <h1 class="mb-4">Citas asignadas a {{ Auth::user()->name }}</h1>

    <div class="row">
        <!-- Columna de citas -->
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Citas pendientes</h5>

                    @if ($appointments->isEmpty())
                        <p>No tienes citas asignadas.</p>
                    @else
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Dueño</th>
                                    <th>Mascota</th>
                                    <th>Motivo</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($appointments as $appointment)
                                    <tr>
                                        <td>{{ \Carbon\Carbon::parse($appointment->date)->format('d/m/Y') }}</td>
                                        <td>{{ $appointment->time }}</td>
                                        <td>{{ $appointment->pet->owner->name ?? 'Sin dueño' }}</td>
                                        <td>{{ $appointment->pet->name ?? 'Sin nombre' }}</td>
                                        <td>{{ $appointment->title }}</td>
                                        <td>{{ $appointment->state }}</td>
                                        <!-- Mostrar el estado de la cita -->
                                        <td>
                                            @if ($appointment->state == 'Pendiente')
                                                <!-- Botón para aceptar la cita -->
                                                <form action="{{ route('appointments.updateState', ['appointment' => $appointment->id, 'state' => 'Confirmada']) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-success btn-sm">Aceptar</button>
                                                </form>

                                                <!-- Botón para cancelar la cita -->
                                                <form action="{{ route('appointments.updateState', ['appointment' => $appointment->id, 'state' => 'Cancelada']) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" class="btn btn-danger btn-sm">Cancelar</button>
                                                </form>

                                            @elseif ($appointment->state == 'Confirmada')
                                                <!-- Botón para crear historial médico -->
                                                <a href="{{ route('medical-records.create', ['appointment' => $appointment->id]) }}" class="btn btn-info btn-sm">Crear historial</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif

                </div>
            </div>
        </div>
    </div>
</div>
@endsection