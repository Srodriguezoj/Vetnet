@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Editar Información de la Mascota</h2>

    <form action="{{ route('pets.updatePet', $pet->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nombre</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $pet->name) }}" required maxlength="100">
        </div>

        <div class="form-group">
            <label for="num_microchip">Número de Microchip</label>
            <input type="text" class="form-control" id="num_microchip" name="num_microchip" value="{{ old('num_microchip', $pet->num_microchip) }}" maxlength="50">
        </div>

        <div class="form-group">
            <label for="date_of_birth">Fecha de Nacimiento</label>
            <input type="date" class="form-control" id="date_of_birth" name="date_of_birth" value="{{ old('date_of_birth', $pet->date_of_birth) }}">
        </div>

        <div class="form-group">
            <label for="sex">Sexo</label>
            <select class="form-control" id="sex" name="sex">
                <option value="Macho" {{ old('sex', $pet->sex) == 'Macho' ? 'selected' : '' }}>Macho</option>
                <option value="Hembra" {{ old('sex', $pet->sex) == 'Hembra' ? 'selected' : '' }}>Hembra</option>
            </select>
        </div>

        <div class="form-group">
            <label for="species">Especie</label>
            <select class="form-control" id="species" name="species">
                <option value="Perro" {{ old('species', $pet->species) == 'Perro' ? 'selected' : '' }}>Perro</option>
                <option value="Gato" {{ old('species', $pet->species) == 'Gato' ? 'selected' : '' }}>Gato</option>
                <option value="Huron" {{ old('species', $pet->species) == 'Huron' ? 'selected' : '' }}>Huron</option>
            </select>
        </div>

        <div class="form-group">
            <label for="breed">Raza</label>
            <input type="text" class="form-control" id="breed" name="breed" value="{{ old('breed', $pet->breed) }}" maxlength="100">
        </div>

        <div class="form-group">
            <label for="colour">Color</label>
            <input type="text" class="form-control" id="colour" name="colour" value="{{ old('colour', $pet->colour) }}" maxlength="50">
        </div>

        <div class="form-group">
            <label for="coat">Pelaje</label>
            <input type="text" class="form-control" id="coat" name="coat" value="{{ old('coat', $pet->coat) }}" maxlength="50">
        </div>

        <div class="form-group">
            <label for="size">Tamaño</label>
            <select class="form-control" id="size" name="size">
                <option value="Grande" {{ old('size', $pet->size) == 'Grande' ? 'selected' : '' }}>Grande</option>
                <option value="Mediano" {{ old('size', $pet->size) == 'Mediano' ? 'selected' : '' }}>Mediano</option>
                <option value="Pequeño" {{ old('size', $pet->size) == 'Pequeño' ? 'selected' : '' }}>Pequeño</option>
            </select>
        </div>

        <div class="form-group">
            <label for="weight">Peso</label>
            <input type="number" class="form-control" id="weight" name="weight" value="{{ old('weight', $pet->weight) }}" step="0.1">
        </div>
        <br/>
        <button type="submit" class="btn btn-primary">Actualizar</button>
    </form>
</div>
@endsection