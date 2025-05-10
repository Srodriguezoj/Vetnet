@extends('layouts.app-admin')

@section('content')
    <h1>Editar Perfil</h1>

    <form action="{{ route('veterinary.updateProfile') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="surname" class="form-label">Apellidos</label>
            <input type="text" name="surname" class="form-control" value="{{ old('surname', $user->surname) }}" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">Correo Electrónico</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
        </div>

        <div class="mb-3">
            <label for="phone" class="form-label">Teléfono</label>
            <input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}">
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Dirección</label>
            <input type="text" name="address" class="form-control" value="{{ old('address', $user->address) }}">
        </div>

        <div class="mb-3">
            <label for="city" class="form-label">Ciudad</label>
            <input type="text" name="city" class="form-control" value="{{ old('city', $user->city) }}">
        </div>

        <div class="mb-3">
            <label for="country" class="form-label">País</label>
            <input type="text" name="country" class="form-control" value="{{ old('country', $user->country) }}">
        </div>

        <div class="mb-3">
            <label for="postcode" class="form-label">Código Postal</label>
            <input type="text" name="postcode" class="form-control" value="{{ old('postcode', $user->postcode) }}">
        </div>

        <button type="submit" class="btn btn-success">Guardar cambios</button>
        <a href="{{ route('veterinary.showProfile') }}" class="btn btn-secondary">Cancelar</a>
    </form>
@endsection