@extends('layouts.app-admin')

@section('content')
    <h1 class="mb-4">Veterinarios</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if ($veterinaries->isEmpty())
        <div class="alert alert-info">
            Aún no hay veterinarios registrados.
        </div>
        <a href="{{ route('veterinary.create') }}" class="btn btn-primary">Registrar nuevo veterinario</a>
    @else
        <a href="{{ route('veterinary.create') }}" class="btn btn-primary mb-3">Registrar nuevo veterinario</a>

        <div class="table-responsive">
            <table class="table table-bordered table-striped">
                <thead class="table-dark">
                    <tr>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Nº Colegiado</th>
                        <th>Especialidad</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($veterinaries as $veterinary)
                        <tr>
                            <td>{{ $veterinary->user->name }}</td>
                            <td>{{ $veterinary->user->email }}</td>
                            <td>{{ $veterinary->collegiate_num }}</td>
                            <td>{{ $veterinary->specialty }}</td>
                            <td class="text-center">
                                <form action="{{ route('veterinary.delete', $veterinary->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de que quieres eliminar este veterinario?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="bi bi-trash"></i> Eliminar
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
@endsection