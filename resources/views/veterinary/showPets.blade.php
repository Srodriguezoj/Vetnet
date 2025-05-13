@extends('layouts.app-admin')

@section('content')
    <div class="container">
        <h2 class="mb-4">Mascotas registradas</h2>

        <div class="row">
            @foreach ($pets as $pet)
                <div class="col-md-4">
                    <a href="{{ route('veterinary.showPet', $pet->id) }}" class="text-decoration-none">
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
    </div>
@endsection