@extends('layouts.app')

@section('content')
   
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($pets->isEmpty())
        <div class="alert alert-info">
            Aún no tienes mascotas registradas.
        </div>
        <a href="{{ route('pets.create') }}" class="btn btn-primary">Registrar nueva mascota</a>

    @else
        <h2>Tus mascotas:</h2>
        <div class="row">
            @foreach ($pets as $pet)
                <div class="col-md-4">
                    <a href="{{ route('client.showPet', $pet->id) }}" class="text-decoration-none">
                        <div class="card mb-3">
                            @php
                                $speciesImages = [
                                    'Perro' => 'perro.jpg',
                                    'Gato' => 'gato.jpg',
                                    'Huron' => 'huron.jpg'
                                ];
                                $imagePath = $speciesImages[$pet->species] ?? 'default.jpg';
                            @endphp
                            <img src="{{ asset('images/' . $imagePath) }}" class="card-img-top" alt="Foto de {{ $pet->species }}" style="height: 300px; object-fit: cover;">

                            <div class="card-body text-center">
                                <h5 class="card-title">{{ $pet->name }}</h5>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <a href="{{ route('pets.create') }}" class="btn btn-primary">Registrar nueva mascota</a>
    @endif
@endsection