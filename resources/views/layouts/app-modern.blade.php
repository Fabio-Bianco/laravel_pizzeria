<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', config('app.name', 'Laravel'))</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <!-- Mobile toggle button -->
        <button class="mobile-toggle" type="button" onclick="toggleSidebar()">
            <i class="fas fa-bars"></i>
        </button>

        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Main content -->
        <div class="main-content">
            <div class="content-wrapper">
                <!-- Page Header -->
                @hasSection('header')
                    <div class="page-header fade-in">
                        @yield('header')
                    </div>
                @elseif(isset($header))
                    <div class="page-header fade-in">
                        {{ $header }}
                    </div>
                @endif

                <!-- Flash Messages -->
                @include('partials.flash-modern')

                <!-- Page Content -->
                <main class="slide-up">
                    @if (isset($slot))
                        {{ $slot }}
                    @else
                        @yield('content')
                    @endif
                </main>
            </div>
        </div>
    </body>
</html>