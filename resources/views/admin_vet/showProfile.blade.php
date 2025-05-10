@extends('layouts.app')

@section('content')
    <h1>Mi Perfil</h1>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
    <div class="card">
        <div class="card-body">
            <p><strong>Nombre:</strong> {{ $user->name }}</p>
            <p><strong>Apellidos:</strong> {{ $user->surname }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>DNI:</strong> {{ $user->dni }}</p>
            <p><strong>Rol:</strong> {{ $user->role }}</p>
            <p><strong>Teléfono:</strong> {{ $user->phone ?? 'No disponible' }}</p>
            <p><strong>Dirección:</strong> {{ $user->address ?? 'No disponible' }}</p>
            <p><strong>Ciudad:</strong> {{ $user->city ?? 'No disponible' }}</p>
            <p><strong>País:</strong> {{ $user->country ?? 'No disponible' }}</p>
            <p><strong>Código Postal:</strong> {{ $user->postcode ?? 'No disponible' }}</p>
        </div>
    </div>

    <a href="{{ route('admin-vet.dashboard') }}" class="btn btn-secondary mt-3">Volver al dashboard</a>
    <a href="{{ route('client.editClient') }}" class="btn btn-primary mt-3 ms-2">Editar perfil</a>
@endsection