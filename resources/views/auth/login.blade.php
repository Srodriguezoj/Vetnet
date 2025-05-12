<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Vetnet</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/login.css') }}">
    </head>
    <body>
        <div class="login-container">
            <div class="login-card">

                <!-- Iniciar sesión -->
                <div class="login-form d-flex align-items-center">
                    <div class="w-100">
                        <h3 class="text-center mb-4">Iniciar sesión</h3>
                        <form method="POST" action="{{ route('login.post') }}">
                            @csrf

                            <div class="mb-3">
                                <label for="email" class="form-label">{{ __('Email') }}</label>
                                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label for="password" class="form-label">{{ __('Contraseña') }}</label>
                                <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <button type="submit" class="btn btn-primary w-100">Iniciar sesión</button>
                            <a href="{{ route('register') }}" class="btn btn-link mt-2 d-block text-center text-link">{{ __('¿No tienes cuenta? Regístrate') }}</a>
                        </form>
                    </div>
                </div>

                <!-- Imagen -->
                <div class="login-image d-none d-md-flex">
                    <img src="{{ asset('images/logoText.png') }}" alt="VetNet Logo">
                </div>
                
            </div>
        </div>
    </body>
</html>
