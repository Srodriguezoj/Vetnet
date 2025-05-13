@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <h2>Contacto con el administrador</h2>
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form action="{{ route('client.contact.send') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="title" class="form-label">Asunto</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ old('title') }}" required>
            @error('title') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <div class="mb-3">
            <label for="subject" class="form-label">Mensaje</label>
            <textarea name="subject" id="subject" class="form-control" rows="5" required>{{ old('subject') }}</textarea>
            @error('subject') <div class="text-danger">{{ $message }}</div> @enderror
        </div>
        <button type="submit" class="btn btn-primary">Enviar</button>
    </form>
</div>
@endsection
