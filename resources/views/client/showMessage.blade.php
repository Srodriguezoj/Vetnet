@extends('layouts.app')

@section('content')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif
<div class="container">
    <div class="row">
        <div class="col-md-8">
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">Detalles del mensaje</h5>
                    <br/>
                    <p><b>Título:</b> {{ $message->title }}</p>
                    <p><b>Asunto:</b> {{ $message->subject }}</p>
                    <p><b>Cliente:</b> {{ $message->client->name ?? 'Desconocido' }}</p>
                    <p><b>Fecha:</b> {{ \Carbon\Carbon::parse($message->date)->format('d/m/Y') }}</p>
                    <p><b>Hora:</b> {{ $message->time }}</p>
                    <p><b>Estado:</b> {{ $message->status }}</p>
                    <p><b>Contenido:</b> {{ $message->content ?? 'No disponible' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
