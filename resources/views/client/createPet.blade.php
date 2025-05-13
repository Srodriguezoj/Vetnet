@extends('layouts.app')

@section('content')
    <h1 class="mb-4">Registrar nueva mascota</h1>
    <form method="POST" action="{{ route('pets.store') }}">
        @csrf
        <div class="card p-4 shadow-sm">
            <div class="mb-3">
                <label for="name" class="form-label">Nombre</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Ingrese el nombre de la mascota" required>
            </div>
            <div class="mb-3">
                <label for="num_microchip" class="form-label">Número de Microchip</label>
                <input type="text" class="form-control" id="num_microchip" name="num_microchip" maxlength="15" placeholder="Ingrese el número de microchip" required>
            </div>
            <div class="mb-3">
                <label for="date_of_birth" class="form-label">Fecha de Nacimiento</label>
                <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" required>
            </div>
            <div class="mb-3">
                <label for="sex" class="form-label">Sexo</label>
                <select class="form-select" id="sex" name="sex" required>
                    <option value="Macho">Macho</option>
                    <option value="Hembra">Hembra</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="species" class="form-label">Especie</label>
                <select class="form-select" id="species" name="species" required>
                    <option value="Perro">Perro</option>
                    <option value="Gato">Gato</option>
                    <option value="Huron">Huron</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="breed" class="form-label">Raza</label>
                <input type="text" class="form-control" id="breed" name="breed" placeholder="Ingrese la raza" required>
            </div>
            <div class="mb-3">
                <label for="colour" class="form-label">Color</label>
                <input type="text" class="form-control" id="colour" name="colour" placeholder="Ingrese el color" required>
            </div>
            <div class="mb-3">
                <label for="coat" class="form-label">Pelaje</label>
                <input type="text" class="form-control" id="coat" name="coat" placeholder="Ingrese el tipo de pelaje" required>
            </div>
            <div class="mb-3">
                <label for="size" class="form-label">Tamaño</label>
                <select class="form-select" id="size" name="size" required>
                    <option value="Grande">Grande</option>
                    <option value="Mediano">Mediano</option>
                    <option value="Pequeño">Pequeño</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="weight" class="form-label">Peso (kg)</label>
                <input type="number" class="form-control" id="weight" name="weight" placeholder="Ingrese el peso en kg" step="0.1" required>
            </div>
            <button type="submit" class="btn btn-secondary">Registrar</button>
            </div>
    </form>
@endsection