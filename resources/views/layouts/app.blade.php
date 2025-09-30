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
                    <div class="container py-3">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            @php($hideFab = request()->routeIs('dashboard') || request()->routeIs('login') || request()->routeIs('register') || request()->routeIs('password.*') || request()->routeIs('verification.*'))
            <main class="container my-4 {{ $hideFab ? '' : 'has-fab' }}">
                {{ $slot }}
                @unless ($hideFab)
                    <x-fab-nav />
                @endunless
            </main>
        </div>
    </body>
</html>
