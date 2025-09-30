<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Accedi • Pizzeria</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        <style>
            body { background: #f8fafc; }
            .login-card { max-width: 420px; margin: 5rem auto; }
            .logo svg { width: 56px; height: 56px; }
        </style>
    </head>
    <body>
        @include('layouts.navigation')
        <div class="card login-card shadow-sm">
            <div class="card-body">
            <div class="logo d-flex align-items-center justify-content-center mb-3" aria-label="Logo pizza">
                <!-- Logo pizza semplice -->
                <svg viewBox="0 0 64 64" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true">
                    <circle cx="32" cy="32" r="30" fill="#fcd34d" stroke="#b45309" stroke-width="2"/>
                    <path d="M32 2 A30 30 0 0 1 62 32 L32 32 Z" fill="#ef4444"/>
                    <circle cx="24" cy="24" r="3" fill="#991b1b"/>
                    <circle cx="40" cy="22" r="3" fill="#991b1b"/>
                    <circle cx="36" cy="36" r="3" fill="#991b1b"/>
                </svg>
            </div>
            <h1 class="h5 text-center mb-3">Accedi</h1>

            @if (session('status'))
                <div class="alert alert-success" role="status">{{ session('status') }}</div>
            @endif

            <form method="POST" action="{{ route('login') }}" novalidate>
                @csrf
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" class="form-control" />
                    @error('email')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" type="password" name="password" required autocomplete="current-password" class="form-control" />
                    @error('password')
                        <div class="text-danger small mt-1">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3 form-check">
                    <input class="form-check-input" id="remember" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }} />
                    <label class="form-check-label" for="remember">Ricordami</label>
                </div>

                <button type="submit" class="btn btn-danger w-100">Entra</button>
            </form>
            </div>
        </div>
    </body>
</html>
