@extends('layouts.app')

@section('content')
    <h1>Bienvenida al panel de cliente</h1>

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
        <h3>Tus mascotas:</h3>
        <div class="row">
            @foreach ($pets as $pet)
                <div class="col-md-4">
                    <a href="{{ route('client.showPet', $pet->id) }}" class="text-decoration-none">
                        <div class="card mb-3">
                            <div class="card-body">
                                <h5 class="card-title">{{ $pet->name }}</h5>
                                <p class="card-text">Especie: {{ $pet->species }}</p>
                            </div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
        <a href="{{ route('pets.create') }}" class="btn btn-primary">Registrar nueva mascota</a>
    @endif
@endsection