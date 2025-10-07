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
        
        <!-- Custom Button Colors -->
        <style>
        /* SISTEMA COLORI SEMANTICO PER ANALFABETI DIGITALI */
        
        /* Verde = Azioni POSITIVE (crea, salva, conferma) */
        .btn-create, .btn.btn-create, .btn-success {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
            color: white !important;
            font-weight: 600 !important;
        }
        .btn-create:hover, .btn-success:hover {
            background-color: #218838 !important;
            border-color: #1e7e34 !important;
            transform: scale(1.02);
        }
        
        /* Blu = Azioni INFORMATIVE (visualizza, dettagli) */
        .btn-view, .btn.btn-view, .btn-primary, .btn-info {
            background-color: #007bff !important;
            border-color: #007bff !important;
            color: white !important;
            font-weight: 600 !important;
        }
        .btn-view:hover, .btn-primary:hover, .btn-info:hover {
            background-color: #0056b3 !important;
            border-color: #004085 !important;
            transform: scale(1.02);
        }
        
        /* Rosso = Azioni PERICOLOSE (elimina) */
        .btn-delete, .btn.btn-delete, .btn-danger {
            background-color: #dc3545 !important;
            border-color: #dc3545 !important;
            color: white !important;
            font-weight: 600 !important;
        }
        .btn-delete:hover, .btn-danger:hover {
            background-color: #c82333 !important;
            border-color: #bd2130 !important;
            transform: scale(1.02);
        }
        
        /* Giallo = Azioni di ATTENZIONE (modifica, warning) */
        .btn-edit, .btn.btn-edit, .btn-warning {
            background-color: #ffc107 !important;
            border-color: #ffc107 !important;
            color: #212529 !important;
            font-weight: 600 !important;
        }
        .btn-edit:hover, .btn-warning:hover {
            background-color: #e0a800 !important;
            border-color: #d39e00 !important;
            transform: scale(1.02);
        }
        
        /* Grigio = Azioni NEUTRALI (annulla, reset) */
        .btn-cancel, .btn.btn-cancel, .btn-secondary {
            background-color: #6c757d !important;
            border-color: #6c757d !important;
            color: white !important;
            font-weight: 600 !important;
        }
        .btn-cancel:hover, .btn-secondary:hover {
            background-color: #545b62 !important;
            border-color: #4e555b !important;
            transform: scale(1.02);
        }
        
        /* Miglioramenti per accessibilità */
        .btn {
            transition: all 0.2s ease !important;
            min-height: 44px !important; /* Minimum touch target */
            font-size: 1rem !important;
            border-radius: 8px !important;
        }
        
        .btn-lg {
            min-height: 56px !important;
            font-size: 1.1rem !important;
            padding: 12px 24px !important;
        }
        
        /* Focus migliorato per keyboard navigation */
        .btn:focus, .card:focus {
            outline: 3px solid #007bff !important;
            outline-offset: 2px !important;
            box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25) !important;
        }
        
        /* Cards più accessibili */
        .card {
            border-radius: 12px !important;
            transition: all 0.3s ease !important;
        }
        
        .card:hover {
            box-shadow: 0 8px 25px rgba(0,0,0,0.15) !important;
        }
        
        /* Testi più leggibili */
        .card-title {
            font-size: 1.2rem !important;
            font-weight: 700 !important;
            line-height: 1.3 !important;
        }
        
        .card-text, .text-muted {
            font-size: 1rem !important;
            line-height: 1.5 !important;
        }
        
        /* Badge più visibili */
        .badge {
            font-size: 0.9rem !important;
            padding: 6px 12px !important;
            font-weight: 600 !important;
        }
        
        /* Spaziatura migliorata */
        .container-fluid {
            padding: 20px !important;
        }
        
        @media (max-width: 768px) {
            .btn {
                font-size: 1.1rem !important;
                padding: 12px 16px !important;
            }
        }
        
        /* Bottoni specifici per azioni */
        .btn-filter, .btn.btn-filter {
            background-color: #ffc107 !important; /* Giallo warning */
            border-color: #ffc107 !important;
            color: #212529 !important;
        }
        .btn-filter:hover {
            background-color: #e0a800 !important;
            border-color: #d39e00 !important;
        }
        
        .btn-reset, .btn.btn-reset {
            background-color: #6c757d !important; /* Grigio */
            border-color: #6c757d !important;
            color: white !important;
        }
        .btn-reset:hover {
            background-color: #5a6268 !important;
            border-color: #545b62 !important;
        }
        
        /* Ottimizzazione leggibilità card */
        .card {
            border-radius: 0.75rem !important;
            box-shadow: 0 0.125rem 0.5rem rgba(0, 0, 0, 0.08) !important;
        }
        .card-header {
            padding: 1rem 1.25rem !important;
            font-size: 1.1rem !important;
            font-weight: 600 !important;
        }
        .card-body {
            padding: 1.25rem !important;
            line-height: 1.6 !important;
        }
        .form-label {
            font-weight: 600 !important;
            margin-bottom: 0.75rem !important;
            color: #495057 !important;
        }
        .form-control, .form-select {
            padding: 0.75rem 1rem !important;
            font-size: 0.95rem !important;
            border-radius: 0.5rem !important;
            border: 1px solid #ced4da !important;
        }
        .form-control:focus, .form-select:focus {
            border-color: #28a745 !important;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25) !important;
        }
        .form-text {
            font-size: 0.85rem !important;
            color: #6c757d !important;
            margin-top: 0.5rem !important;
        }
        .badge {
            font-size: 0.8rem !important;
            padding: 0.5rem 0.75rem !important;
            border-radius: 0.5rem !important;
        }
        
        /* Spaziatura ottimale per i gap */
        .g-3 > * {
            margin-bottom: 1rem !important;
        }
        .g-4 > * {
            margin-bottom: 1.5rem !important;
        }
        
        /* Hover effect migliorato */
        .hover-lift:hover {
            transform: translateY(-2px) !important;
            box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15) !important;
            transition: all 0.2s ease-in-out !important;
        }
        </style>
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