@extends('layouts.app-admin')

@section('content')
    <h1>Registrar nuevo veterinario</h1>

    <form method="POST" action="{{ route('veterinary.store') }}">
        @csrf
        <div class="card p-4 shadow-sm">
            <div class="mb-3">
                <label class="form-label">Nombre</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Apellido</label>
                <input type="text" name="surname" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">DNI</label>
                <input type="text" name="dni" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Confirmar contraseña</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Número de colegiado</label>
                <input type="text" name="collegiate_num" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Especialidad</label>
                <select name="specialty" class="form-control" required>
                    <option value="Interna">Interna</option>
                    <option value="Cirugia">Cirugía</option>
                    <option value="Dermatologia">Dermatología</option>
                    <option value="Odontologia">Odontología</option>
                    <option value="Cardiologia">Cardiología</option>
                    <option value="Preventiva">Preventiva</option>
                    <option value="Etologia">Etología</option>
                </select>
            </div>

            <button type="submit" class="btn btn-success">Registrar</button>
        </div>
    </form>
@endsection