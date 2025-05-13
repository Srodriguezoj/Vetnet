@extends('layouts.app-admin')

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

<a href="{{ route('veterinary.showDates') }}" class="btn btn-primary  mt-3">Volver al dashboard</a>
<a href="{{ route('veterinary.editProfile') }}" class="btn btn-secondary mt-3 ms-2">Editar perfil</a>
<a href="#" class="btn btn-tertiary mt-3 ms-2" data-bs-toggle="modal" data-bs-target="#changePasswordModal">Cambiar Contraseña</a>

<!-- Modal contraseña -->
<div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="changePasswordModalLabel">Cambiar Contraseña</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('veterinary.updatePassword') }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-3">
                        <label for="current_password" class="form-label">Contraseña Actual</label>
                        <input type="password" name="current_password" id="current_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password" class="form-label">Nueva Contraseña</label>
                        <input type="password" name="new_password" id="new_password" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="new_password_confirmation" class="form-label">Confirmar Nueva Contraseña</label>
                        <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-tertiary">Cambiar Contraseña</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection