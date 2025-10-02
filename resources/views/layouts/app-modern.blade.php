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
        
        <!-- Custom CSS for modern admin -->
        <style>
            :root {
                --sidebar-width: 280px;
                --primary-color: #FF6B35;
                --primary-light: #FFE66D;
                --success-color: #10B981;
                --warning-color: #F59E0B;
                --danger-color: #EF4444;
                --gray-50: #F9FAFB;
                --gray-100: #F3F4F6;
                --gray-200: #E5E7EB;
                --gray-500: #6B7280;
                --gray-700: #374151;
                --gray-900: #111827;
            }

            body {
                background-color: var(--gray-50);
                font-family: 'Figtree', system-ui, sans-serif;
            }

            .main-content {
                margin-left: var(--sidebar-width);
                min-height: 100vh;
                transition: margin-left 0.3s ease;
            }

            .content-wrapper {
                padding: 2rem;
                max-width: 1400px;
                margin: 0 auto;
            }

            .page-header {
                background: white;
                border-radius: 1rem;
                padding: 1.5rem 2rem;
                margin-bottom: 2rem;
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
                border: 1px solid var(--gray-200);
            }

            .page-title {
                font-size: 1.875rem;
                font-weight: 700;
                color: var(--gray-900);
                margin: 0;
            }

            .page-subtitle {
                color: var(--gray-500);
                margin-top: 0.25rem;
            }

            .breadcrumb {
                background: none;
                padding: 0;
                margin: 0.5rem 0 0 0;
            }

            .breadcrumb-item + .breadcrumb-item::before {
                content: "›";
                color: var(--gray-500);
            }

            .card {
                border: 1px solid var(--gray-200);
                border-radius: 1rem;
                box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);
                transition: all 0.2s ease;
            }

            .card:hover {
                box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
                transform: translateY(-1px);
            }

            .btn {
                border-radius: 0.75rem;
                font-weight: 500;
                padding: 0.625rem 1.25rem;
                transition: all 0.2s ease;
            }

            .btn-primary {
                background: linear-gradient(135deg, var(--primary-color) 0%, #E55A2B 100%);
                border: none;
                color: white;
            }

            .btn-primary:hover {
                background: linear-gradient(135deg, #E55A2B 0%, #CC4125 100%);
                transform: translateY(-1px);
                box-shadow: 0 4px 8px rgba(255, 107, 53, 0.3);
            }

            .btn-success {
                background: linear-gradient(135deg, var(--success-color) 0%, #059669 100%);
                border: none;
            }

            .btn-outline-primary {
                border-color: var(--primary-color);
                color: var(--primary-color);
            }

            .btn-outline-primary:hover {
                background-color: var(--primary-color);
                border-color: var(--primary-color);
            }

            .alert {
                border-radius: 0.75rem;
                border: none;
                margin-bottom: 1.5rem;
            }

            .alert-success {
                background: linear-gradient(135deg, #D1FAE5 0%, #A7F3D0 100%);
                color: #047857;
            }

            .alert-danger {
                background: linear-gradient(135deg, #FEE2E2 0%, #FECACA 100%);
                color: #DC2626;
            }

            .form-control, .form-select {
                border-radius: 0.75rem;
                border: 1px solid var(--gray-200);
                padding: 0.75rem 1rem;
                transition: all 0.2s ease;
            }

            .form-control:focus, .form-select:focus {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 3px rgba(255, 107, 53, 0.1);
            }

            .form-label {
                font-weight: 600;
                color: var(--gray-700);
                margin-bottom: 0.5rem;
            }

            .mobile-toggle {
                display: none;
                position: fixed;
                top: 1rem;
                left: 1rem;
                z-index: 1001;
                background: white;
                border: 1px solid var(--gray-200);
                border-radius: 0.5rem;
                padding: 0.5rem;
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            }

            @media (max-width: 768px) {
                .main-content {
                    margin-left: 0;
                }

                .mobile-toggle {
                    display: block;
                }

                .content-wrapper {
                    padding: 1rem;
                    padding-top: 4rem;
                }
            }

            /* Animazioni moderne */
            .fade-in {
                animation: fadeIn 0.4s ease-out;
            }

            @keyframes fadeIn {
                from { opacity: 0; transform: translateY(10px); }
                to { opacity: 1; transform: translateY(0); }
            }

            .slide-up {
                animation: slideUp 0.3s ease-out;
            }

            @keyframes slideUp {
                from { transform: translateY(20px); opacity: 0; }
                to { transform: translateY(0); opacity: 1; }
            }

            /* Modern card effects */
            .hover-lift {
                transition: all 0.3s ease;
            }

            .hover-lift:hover {
                transform: translateY(-5px);
                box-shadow: 0 10px 25px rgba(0,0,0,0.15) !important;
            }

            .hover-primary:hover {
                color: var(--primary-color) !important;
            }

            /* Enhanced form styles */
            .form-control:focus {
                border-color: var(--primary-color);
                box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25);
            }

            .btn-primary {
                background-color: var(--primary-color);
                border-color: var(--primary-color);
                transition: all 0.3s ease;
            }

            .btn-primary:hover {
                background-color: #E55A2B;
                border-color: #E55A2B;
                transform: translateY(-1px);
                box-shadow: 0 4px 8px rgba(229, 90, 43, 0.3);
            }

            .btn-outline-primary:hover {
                background-color: var(--primary-color);
                border-color: var(--primary-color);
                transform: translateY(-1px);
            }

            /* Badge improvements */
            .badge {
                font-weight: 500;
            }

            /* Card improvements */
            .card {
                transition: all 0.3s ease;
            }

            /* Empty states */
            .empty-state {
                padding: 4rem 2rem;
                text-align: center;
            }

            /* Loading states */
            .loading-overlay {
                position: absolute;
                top: 0;
                left: 0;
                right: 0;
                bottom: 0;
                background: rgba(255, 255, 255, 0.9);
                display: flex;
                align-items: center;
                justify-content: center;
                z-index: 10;
            }

            .spinner {
                width: 2rem;
                height: 2rem;
                border: 0.2rem solid var(--gray-200);
                border-top: 0.2rem solid var(--primary-color);
                border-radius: 50%;
                animation: spin 1s linear infinite;
            }

            @keyframes spin {
                0% { transform: rotate(0deg); }
                100% { transform: rotate(360deg); }
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

        <!-- Scripts -->
        <script>
            function toggleSidebar() {
                document.querySelector('.sidebar-wrapper').classList.toggle('show');
            }

            // Auto-hide flash messages
            document.addEventListener('DOMContentLoaded', function() {
                const alerts = document.querySelectorAll('.alert[data-auto-dismiss]');
                alerts.forEach(alert => {
                    setTimeout(() => {
                        alert.style.transition = 'all 0.3s ease';
                        alert.style.opacity = '0';
                        alert.style.transform = 'translateY(-10px)';
                        setTimeout(() => alert.remove(), 300);
                    }, 5000);
                });
            });

            // Enhanced form validation feedback
            document.addEventListener('DOMContentLoaded', function() {
                const inputs = document.querySelectorAll('.form-control, .form-select');
                inputs.forEach(input => {
                    input.addEventListener('blur', function() {
                        if (this.hasAttribute('required') && !this.value.trim()) {
                            this.classList.add('is-invalid');
                        } else {
                            this.classList.remove('is-invalid');
                            this.classList.add('is-valid');
                        }
                    });

                    input.addEventListener('input', function() {
                        if (this.classList.contains('is-invalid') && this.value.trim()) {
                            this.classList.remove('is-invalid');
                            this.classList.add('is-valid');
                        }
                    });
                });
            });
        </script>
    </body>
</html>