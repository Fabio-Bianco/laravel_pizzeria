<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <div class="min-vh-100 bg-light">
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white border-bottom">
                    <div class="container py-3 d-flex justify-content-between align-items-center">
                        <div>
                            {{ $header }}
                        </div>
                        @php($isDashboard = request()->routeIs('dashboard'))
                        @php($isLogin = request()->routeIs('login'))
                        @if (!$isDashboard && !$isLogin)
                            <button type="button" class="btn btn-outline-secondary" onclick="history.back()">Indietro</button>
                        @endif
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="container my-4">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
