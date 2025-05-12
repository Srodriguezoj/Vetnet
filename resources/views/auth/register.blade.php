<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>VetNet - Registro</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="{{ asset('css/login.css') }}">
        <style>
            body {
                font-family: 'Montserrat', sans-serif;
                font-size: 16px;
                color: #2e2e2e; 
                line-height: 1.6;
                margin: 0;
                padding: 0;
                background-color: #fdfafa; 
                min-height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;  
            }


            .register-container {
                max-width: 1000px;
                width: 100%;
            }

            .register-card {
                display: flex;
                border-radius: 12px;
                overflow: hidden;
                box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
                background-color: white;
                height: auto;
            }

            .register-form {
                padding: 2rem;
                flex: 1;
                max-width: 600px;
            }

            .form-label {
                font-weight: 500;
            }

            .register-image {
                flex: 1;
                display: flex;
                align-items: center;
                justify-content: center;
                background-color: #ffffff;
            }

            .register-image img {
                max-width: 450px;
                height: auto;
            }

            @media (max-width: 768px) {
                .register-image {
                    display: none;
                }
            }
        </style>
    </head>
    <body>
        <div class="register-container">
            <div class="register-card">

                <!-- Formulario de registro -->
                <div class="register-form">
                    <h3 class="text-center mb-4">Regístrate</h3>
                    <form method="POST" action="{{ route('register.post') }}">
                        @csrf
                        <div class="row mb-3">
                            <div class="col">
                                <label for="name" class="form-label">{{ __('Nombre') }}</label>
                                <input type="text" id="name" name="name" class="form-control @error('name') is-invalid @enderror" value="{{ old('name') }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="surname" class="form-label">{{ __('Apellidos') }}</label>
                                <input type="text" id="surname" name="surname" class="form-control @error('surname') is-invalid @enderror" value="{{ old('surname') }}" required>
                                @error('surname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="email" class="form-label">{{ __('Email') }}</label>
                                <input type="email" id="email" name="email" class="form-control @error('email') is-invalid @enderror" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="dni" class="form-label">{{ __('DNI') }}</label>
                                <input type="text" id="dni" name="dni" class="form-control @error('dni') is-invalid @enderror" value="{{ old('dni') }}" required>
                                @error('dni')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="phone" class="form-label">{{ __('Teléfono') }}</label>
                            <input type="text" id="phone" name="phone" class="form-control @error('phone') is-invalid @enderror" value="{{ old('phone') }}">
                            @error('phone')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="address" class="form-label">{{ __('Dirección') }}</label>
                                <input type="text" id="address" name="address" class="form-control @error('address') is-invalid @enderror" value="{{ old('address') }}">
                                @error('address')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="city" class="form-label">{{ __('Ciudad') }}</label>
                                <input type="text" id="city" name="city" class="form-control @error('city') is-invalid @enderror" value="{{ old('city') }}">
                                @error('city')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col">
                                <label for="country" class="form-label">{{ __('País') }}</label>
                                <input type="text" id="country" name="country" class="form-control @error('country') is-invalid @enderror" value="{{ old('country') }}">
                                @error('country')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="col">
                                <label for="postcode" class="form-label">{{ __('Código Postal') }}</label>
                                <input type="text" id="postcode" name="postcode" class="form-control @error('postcode') is-invalid @enderror" value="{{ old('postcode') }}">
                                @error('postcode')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="password" class="form-label">{{ __('Contraseña') }}</label>
                            <input type="password" id="password" name="password" class="form-control @error('password') is-invalid @enderror" required>
                            @error('password')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">{{ __('Confirmar Contraseña') }}</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Regístrate</button>
                        <a href="{{ route('login') }}" class="btn btn-link mt-2 d-block text-center text-link">{{ __('¿Ya tienes cuenta? Inicia sesión') }}</a>
                    </form>
                </div>

                <!-- Imagen -->
                <div class="register-image d-none d-md-flex">
                    <img src="{{ asset('images/logoText.png') }}" alt="VetNet Logo">
                </div>
            </div>
        </div>
    </body>
</html>
