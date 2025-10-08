{{-- QUESTO FILE VA ELIMINATO - USATO SOLO PER TEST --}}
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        
        <!-- Font Awesome -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

        <!-- Scripts - SOLO APP.CSS SENZA ACCESSIBILITY -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body>
        <!-- Skip navigation link per screen reader -->
        <a href="#main-content" class="skip-link">Salta alla navigazione principale</a>

        <!-- Mobile toggle button with proper ARIA -->
        <button 
            class="mobile-toggle" 
            type="button" 
            onclick="toggleSidebar()"
            aria-expanded="false"
            aria-controls="sidebar"
            aria-label="Apri/chiudi menu di navigazione"
        >
            <i class="fas fa-bars" aria-hidden="true"></i>
            <span class="sr-only">Menu</span>
        </button>

        <!-- Sidebar with proper navigation role -->
        <nav id="sidebar" role="navigation" aria-label="Menu principale">
            @include('layouts.sidebar')
        </nav>

        <!-- Main content with proper landmark -->
        <main class="main-content" id="main-content" role="main" aria-label="Contenuto principale">
            <div class="content-wrapper">
                <!-- Page Header with proper heading structure -->
                @hasSection('header')
                    <header class="page-header fade-in" role="banner">
                        @yield('header')
                    </header>
                @elseif(isset($header))
                    <header class="page-header fade-in" role="banner">
                        {{ $header }}
                    </header>
                @endif

                <!-- Flash Messages with proper ARIA live region -->
                <div aria-live="polite" aria-atomic="true">
                    @include('partials.flash-modern')
                </div>

                <!-- Page Content -->
                <section class="slide-up" aria-label="Contenuto della pagina">
                    @if (isset($slot))
                        {{ $slot }}
                    @else
                        @yield('content')
                    @endif
                </section>
            </div>
        </main>
    </body>
</html>