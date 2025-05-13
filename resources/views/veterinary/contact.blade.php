@extends('layouts.app-admin')

@section('content')
<div class="container mt-4">
    <h2>Mensajes de clientes</h2>
    @if($messages->isEmpty())
        <p class="subtitleText">No hay mensajes por el momento.</p>
    @else
        <table class="table table-bordered table-striped mt-3">
            <thead>
                <tr>
                    <th>Cliente</th>
                    <th>Asunto</th>
                    <th>Fecha</th>
                    <th>Hora</th>
                    <th>Estado</th>
                    <th>Acción</th>
                </tr>
            </thead>
            <tbody>
                @foreach($messages as $msg)
                    <tr>
                        <td>{{ $msg->client->name }}</td>
                        <td>{{ $msg->title }}</td>
                        <td>{{ $msg->date }}</td>
                        <td>{{ $msg->time }}</td>
                        <td>
                            @if($msg->status === 'No leido')
                                <span class="badge bg-warning text-dark">No leído</span>
                            @else
                                <span class="badge bg-success">Leído</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('veterinary.showMessage', $msg->id) }}" class="btn btn-sm btn-primary">Ver mensaje</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
