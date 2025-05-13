@extends('layouts.app-admin')

@section('content')
    <div class="container-fluid px-3">
        <h1 class="mb-4 text-uppercase fw-bold" style="color: #eb6566;"> itas asignadas a {{ Auth::user()->name }} </h1>

        @if (session('success'))
            <div class="alert alert-success rounded">
                {{ session('success') }}
            </div>
        @endif

        @if ($appointments->isEmpty())
            <div class="alert alert-info">No tienes citas asignadas.</div>
        @else
            <div class="table-responsive">
                <table class="table table-bordered align-middle text-center shadow-sm rounded" style="background-color: #ffffff;">
                    <thead class="text-uppercase" style="background-color:#f4a48f; color:#2e2e2e">
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
                                <td>
                                    @if ($appointment->state == 'Pendiente')
                                        <form action="{{ route('appointments.updateState', ['appointment' => $appointment->id, 'state' => 'Confirmada']) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-success btn-sm">Aceptar</button>
                                        </form>
                                        <form action="{{ route('appointments.updateState', ['appointment' => $appointment->id, 'state' => 'Cancelada']) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-danger btn-sm">Cancelar</button>
                                        </form>
                                    @elseif ($appointment->state == 'Confirmada')
                                        <a href="{{ route('medical-records.create', ['appointment' => $appointment->id]) }}" class="btn btn-info btn-sm">Crear historial</a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
