@extends('layouts.app-modern')@extends('layouts.app-modern')@extends('layouts.app-modern')@extends('layouts.app-modern')@extends('layouts.app-modern')@extends('layouts.app-modern')



@section('title', 'Le Tue Pizze')



@section('header')@section('title', 'Le Tue Pizze')

<div class="text-center py-4">

    <div class="mb-3">

        <div style="font-size: 3rem;">🍕</div>

    </div>@section('header')@section('title', 'Le Tue Pizze')

    <h1 class="display-6 fw-bold text-dark mb-2">Le Tue Pizze</h1>

    <p class="lead text-muted mb-4">Guarda tutte le pizze del tuo menu</p><div class="text-center py-4">

    

    {{-- Azione principale sempre visibile --}}    <div class="mb-3">

    <div class="d-flex justify-content-center gap-3 mb-3">

        <a class="btn btn-success btn-lg px-4 py-3 fw-bold"         <div style="font-size: 3rem;">🍕</div>

           href="{{ route('admin.pizzas.create') }}"

           data-bs-toggle="tooltip"     </div>@section('header')@section('title', 'Le Tue Pizze')

           title="Clicca qui per aggiungere una nuova pizza al menu">

            <i class="fas fa-plus me-2"></i>🍕 Aggiungi Nuova Pizza    <h1 class="display-6 fw-bold text-dark mb-2">Le Tue Pizze</h1>

        </a>

    </div>    <p class="lead text-muted mb-4">Guarda tutte le pizze del tuo menu</p><div class="text-center py-4">

    

    {{-- Contatore semplice --}}    

    <div class="badge bg-primary fs-6 px-3 py-2">

        <i class="fas fa-pizza-slice me-1"></i>    {{-- Azione principale sempre visibile --}}    <div class="mb-3">

        Hai {{ $pizzas->total() ?? 0 }} {{ $pizzas->total() == 1 ? 'pizza' : 'pizze' }} nel menu

    </div>    <div class="d-flex justify-content-center gap-3 mb-3">

</div>

@endsection        <a class="btn btn-success btn-lg px-4 py-3 fw-bold"         <div style="font-size: 3rem;">🍕</div>



@section('content')           href="{{ route('admin.pizzas.create') }}"



    {{-- Messaggio di guida quando non ci sono pizze --}}           data-bs-toggle="tooltip"     </div>@section('header')@section('title', 'Le Tue Pizze')@section('title', 'Le Tue Pizze')

    @if($pizzas->count() == 0)

    <div class="row justify-content-center">           title="Clicca qui per aggiungere una nuova pizza al menu">

        <div class="col-lg-6">

            <div class="text-center py-5">            <i class="fas fa-plus me-2"></i>🍕 Aggiungi Nuova Pizza    <h1 class="display-6 fw-bold text-dark mb-2">Le Tue Pizze</h1>

                <div class="mb-4" style="font-size: 5rem; opacity: 0.5;">🍕</div>

                <h3 class="fw-bold text-dark mb-3">Non hai ancora nessuna pizza!</h3>        </a>

                <p class="text-muted mb-4">Inizia subito creando la tua prima pizza per il menu.</p>

                <a class="btn btn-success btn-lg px-4 py-3 fw-bold"     </div>    <p class="lead text-muted mb-4">Guarda tutte le pizze del tuo menu</p><div class="text-center py-4">

                   href="{{ route('admin.pizzas.create') }}">

                    <i class="fas fa-rocket me-2"></i>Crea la Prima Pizza    

                </a>

            </div>    {{-- Contatore semplice --}}    

        </div>

    </div>    <div class="badge bg-primary fs-6 px-3 py-2">

    @else

    {{-- Griglia semplificata delle pizze --}}        <i class="fas fa-pizza-slice me-1"></i>    {{-- Azione principale sempre visibile --}}    <div class="mb-3">

    <div class="row justify-content-center">

        <div class="col-12">        Hai {{ $pizzas->total() ?? 0 }} {{ $pizzas->total() == 1 ? 'pizza' : 'pizze' }} nel menu

            <div class="row g-4" aria-live="polite">

                @foreach($pizzas as $p)    </div>    <div class="d-flex justify-content-center gap-3 mb-3">

                    <div class="col-12 col-md-6 col-xl-4">

                        <div class="card h-100 border-0 shadow-sm hover-lift" </div>

                             style="transition: all 0.3s ease;">

                            @endsection        <a class="btn btn-success btn-lg px-4 py-3 fw-bold"         <div style="font-size: 3rem;">🍕</div>

                            {{-- Immagine pizza --}}

                            @if($p->image_path)

                                <div class="position-relative">

                                    <img src="{{ asset('storage/'.$p->image_path) }}" @section('content')           href="{{ route('admin.pizzas.create') }}"

                                         alt="Foto di {{ $p->name }}" 

                                         class="card-img-top" 

                                         style="height:220px;object-fit:cover;border-radius: 12px 12px 0 0;">

                                    @if($p->is_bianca)    {{-- Messaggio di guida quando non ci sono pizze --}}           data-bs-toggle="tooltip"     </div>@section('header')@section('header')

                                        <span class="position-absolute top-0 end-0 badge bg-white text-dark m-2">

                                            🧀 Bianca    @if($pizzas->count() == 0)

                                        </span>

                                    @endif    <div class="row justify-content-center">           title="Clicca qui per aggiungere una nuova pizza al menu">

                                    @if($p->is_vegan)

                                        <span class="position-absolute top-0 start-0 badge bg-success text-white m-2">        <div class="col-lg-6">

                                            🌱 Vegana

                                        </span>            <div class="text-center py-5">            <i class="fas fa-plus me-2"></i>🍕 Aggiungi Nuova Pizza    <h1 class="display-6 fw-bold text-dark mb-2">Le Tue Pizze</h1>

                                    @endif

                                </div>                <div class="mb-4" style="font-size: 5rem; opacity: 0.5;">🍕</div>

                            @else

                                <div class="card-img-top d-flex align-items-center justify-content-center bg-light"                 <h3 class="fw-bold text-dark mb-3">Non hai ancora nessuna pizza!</h3>        </a>

                                     style="height:220px;border-radius: 12px 12px 0 0;">

                                    <div class="text-center">                <p class="text-muted mb-4">Inizia subito creando la tua prima pizza per il menu.</p>

                                        <div style="font-size: 3rem; opacity: 0.5;">🍕</div>

                                        <small class="text-muted">Nessuna foto</small>                <a class="btn btn-success btn-lg px-4 py-3 fw-bold"     </div>    <p class="lead text-muted mb-4">Guarda tutte le pizze del tuo menu</p><div class="text-center py-4"><div class="text-center py-4">

                                    </div>

                                </div>                   href="{{ route('admin.pizzas.create') }}">

                            @endif

                    <i class="fas fa-rocket me-2"></i>Crea la Prima Pizza    

                            {{-- Contenuto carta --}}

                            <div class="card-body d-flex flex-column p-4">                </a>

                                <h4 class="card-title fw-bold text-dark mb-2">{{ $p->name }}</h4>

                                            </div>    {{-- Contatore semplice --}}    

                                {{-- Ingredienti principali --}}

                                @if($p->ingredients->isNotEmpty())        </div>

                                    <p class="card-text text-muted mb-3" style="line-height: 1.5;">

                                        🥬 {{ $p->ingredients->take(3)->pluck('name')->join(', ') }}    </div>    <div class="badge bg-primary fs-6 px-3 py-2">

                                        @if($p->ingredients->count() > 3)

                                            <span class="badge bg-light text-muted ms-1">+{{ $p->ingredients->count() - 3 }}</span>    @else

                                        @endif

                                    </p>    {{-- Griglia semplificata delle pizze --}}        <i class="fas fa-pizza-slice me-1"></i>    {{-- Azione principale sempre visibile --}}    <div class="mb-3">    <div class="mb-3">

                                @endif

                                    <div class="row justify-content-center">

                                {{-- Prezzo evidenziato --}}

                                <div class="d-flex justify-content-between align-items-center mb-3">        <div class="col-12">        Hai {{ $pizzas->total() ?? 0 }} {{ $pizzas->total() == 1 ? 'pizza' : 'pizze' }} nel menu

                                    <span class="h4 fw-bold text-success mb-0">€{{ number_format($p->price, 2) }}</span>

                                    @if($p->category)            <div class="row g-4" aria-live="polite">

                                        <span class="badge bg-light text-dark">{{ $p->category->name }}</span>

                                    @endif                @foreach($pizzas as $p)    </div>    <div class="d-flex justify-content-center gap-3 mb-3">

                                </div>

                    <div class="col-12 col-md-6 col-xl-4">

                                {{-- Bottoni azione semplificati --}}

                                <div class="d-grid gap-2">                        <div class="card h-100 border-0 shadow-sm hover-lift" </div>

                                    <div class="btn-group" role="group">

                                        <a class="btn btn-primary flex-fill"                              style="transition: all 0.3s ease;">

                                           href="{{ route('admin.pizzas.show', $p) }}"

                                           data-bs-toggle="tooltip"                             @endsection        <a class="btn btn-success btn-lg px-4 py-3 fw-bold"         <div style="font-size: 3rem;">🍕</div>        <div style="font-size: 3rem;">🍕</div>

                                           title="Guarda tutti i dettagli di {{ $p->name }}">

                                            <i class="fas fa-eye me-1"></i>Dettagli                            {{-- Immagine pizza --}}

                                        </a>

                                        <a class="btn btn-success flex-fill"                             @if($p->image_path)

                                           href="{{ route('admin.pizzas.edit', $p) }}"

                                           data-bs-toggle="tooltip"                                 <div class="position-relative">

                                           title="Modifica {{ $p->name }}">

                                            <i class="fas fa-edit me-1"></i>Modifica                                    <img src="{{ asset('storage/'.$p->image_path) }}" @section('content')           href="{{ route('admin.pizzas.create') }}"

                                        </a>

                                    </div>                                         alt="Foto di {{ $p->name }}" 

                                    

                                    {{-- Bottone elimina separato per sicurezza --}}                                         class="card-img-top" 

                                    <form method="POST" action="{{ route('admin.pizzas.destroy', $p) }}" 

                                          onsubmit="return confirm('⚠️ Sei sicuro di voler eliminare {{ $p->name }}?\n\nQuesta azione non si può annullare!')"                                         style="height:220px;object-fit:cover;border-radius: 12px 12px 0 0;">

                                          class="mb-0">

                                        @csrf                                    @if($p->is_bianca)    {{-- Messaggio di guida quando non ci sono pizze --}}           data-bs-toggle="tooltip"     </div>    </div>

                                        @method('DELETE')

                                        <button type="submit"                                         <span class="position-absolute top-0 end-0 badge bg-white text-dark m-2">

                                                class="btn btn-outline-danger btn-sm w-100"

                                                data-bs-toggle="tooltip"                                             🧀 Bianca    @if($pizzas->count() == 0)

                                                title="Elimina definitivamente {{ $p->name }}">

                                            <i class="fas fa-trash me-1"></i>🗑️ Elimina Pizza                                        </span>

                                        </button>

                                    </form>                                    @endif    <div class="row justify-content-center">           title="Clicca qui per aggiungere una nuova pizza al menu">

                                </div>

                            </div>                                    @if($p->is_vegan)

                        </div>

                    </div>                                        <span class="position-absolute top-0 start-0 badge bg-success text-white m-2">        <div class="col-lg-6">

                @endforeach

            </div>                                            🌱 Vegana

        </div>

    </div>                                        </span>            <div class="text-center py-5">            <i class="fas fa-plus me-2"></i>🍕 Aggiungi Nuova Pizza    <h1 class="display-6 fw-bold text-dark mb-2">Le Tue Pizze</h1>    <h1 class="display-6 fw-bold text-dark mb-2">Le Tue Pizze</h1>



    {{-- Paginazione semplificata --}}                                    @endif

    @if($pizzas->hasPages())

    <div class="row justify-content-center mt-5">                                </div>                <div class="mb-4" style="font-size: 5rem; opacity: 0.5;">🍕</div>

        <div class="col-auto">

            <div class="card border-0 shadow-sm">                            @else

                <div class="card-body text-center">

                    <h6 class="mb-3">📄 Altre pizze</h6>                                <div class="card-img-top d-flex align-items-center justify-content-center bg-light"                 <h3 class="fw-bold text-dark mb-3">Non hai ancora nessuna pizza!</h3>        </a>

                    {{ $pizzas->links() }}

                </div>                                     style="height:220px;border-radius: 12px 12px 0 0;">

            </div>

        </div>                                    <div class="text-center">                <p class="text-muted mb-4">Inizia subito creando la tua prima pizza per il menu.</p>

    </div>

    @endif                                        <div style="font-size: 3rem; opacity: 0.5;">🍕</div>

    @endif

                                        <small class="text-muted">Nessuna foto</small>                <a class="btn btn-success btn-lg px-4 py-3 fw-bold"     </div>    <p class="lead text-muted mb-4">Guarda tutte le pizze del tuo menu</p>    <p class="lead text-muted mb-4">Guarda tutte le pizze del tuo menu</p>

    {{-- Suggerimento finale --}}

    @if($pizzas->count() > 0)                                    </div>

    <div class="row justify-content-center mt-5">

        <div class="col-lg-8">                                </div>                   href="{{ route('admin.pizzas.create') }}">

            <div class="alert alert-info border-0 text-center py-4" 

                 style="background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);">                            @endif

                <div class="mb-2">💡</div>

                <h5 class="fw-bold mb-2">Suggerimento</h5>                    <i class="fas fa-rocket me-2"></i>Crea la Prima Pizza    

                <p class="mb-3">Hai già {{ $pizzas->total() }} {{ $pizzas->total() == 1 ? 'pizza' : 'pizze' }}! 

                   Che ne dici di aggiungere anche degli antipasti o dessert?</p>                            {{-- Contenuto carta --}}

                <div class="d-flex justify-content-center gap-2 flex-wrap">

                    <a href="{{ route('admin.appetizers.index') }}" class="btn btn-outline-primary btn-sm">                            <div class="card-body d-flex flex-column p-4">                </a>

                        🥗 Vai agli Antipasti

                    </a>                                <h4 class="card-title fw-bold text-dark mb-2">{{ $p->name }}</h4>

                    <a href="{{ route('admin.desserts.index') }}" class="btn btn-outline-primary btn-sm">

                        🍰 Vai ai Dessert                                            </div>    {{-- Contatore semplice --}}        

                    </a>

                </div>                                {{-- Ingredienti principali --}}

            </div>

        </div>                                @if($p->ingredients->isNotEmpty())        </div>

    </div>

    @endif                                    <p class="card-text text-muted mb-3" style="line-height: 1.5;">



@endsection                                        🥬 {{ $p->ingredients->take(3)->pluck('name')->join(', ') }}    </div>    <div class="badge bg-primary fs-6 px-3 py-2">

                                        @if($p->ingredients->count() > 3)

                                            <span class="badge bg-light text-muted ms-1">+{{ $p->ingredients->count() - 3 }}</span>    @else

                                        @endif

                                    </p>    {{-- Griglia semplificata delle pizze --}}        <i class="fas fa-pizza-slice me-1"></i>    {{-- Azione principale sempre visibile --}}    {{-- Azione principale sempre visibile --}}

                                @endif

                                    <div class="row justify-content-center">

                                {{-- Prezzo evidenziato --}}

                                <div class="d-flex justify-content-between align-items-center mb-3">        <div class="col-12">        Hai {{ $pizzas->total() ?? 0 }} {{ $pizzas->total() == 1 ? 'pizza' : 'pizze' }} nel menu

                                    <span class="h4 fw-bold text-success mb-0">€{{ number_format($p->price, 2) }}</span>

                                    @if($p->category)            <div class="row g-4" aria-live="polite">

                                        <span class="badge bg-light text-dark">{{ $p->category->name }}</span>

                                    @endif                @foreach($pizzas as $p)    </div>    <div class="d-flex justify-content-center gap-3 mb-3">    <div class="d-flex justify-content-center gap-3 mb-3">

                                </div>

                    <div class="col-12 col-md-6 col-xl-4">

                                {{-- Bottoni azione semplificati --}}

                                <div class="d-grid gap-2">                        <div class="card h-100 border-0 shadow-sm hover-lift" </div>

                                    <div class="btn-group" role="group">

                                        <a class="btn btn-primary flex-fill"                              style="transition: all 0.3s ease;">

                                           href="{{ route('admin.pizzas.show', $p) }}"

                                           data-bs-toggle="tooltip"                             @endsection        <a class="btn btn-success btn-lg px-4 py-3 fw-bold"         <a class="btn btn-success btn-lg px-4 py-3 fw-bold" 

                                           title="Guarda tutti i dettagli di {{ $p->name }}">

                                            <i class="fas fa-eye me-1"></i>Dettagli                            {{-- Immagine pizza --}}

                                        </a>

                                        <a class="btn btn-success flex-fill"                             @if($p->image_path)

                                           href="{{ route('admin.pizzas.edit', $p) }}"

                                           data-bs-toggle="tooltip"                                 <div class="position-relative">

                                           title="Modifica {{ $p->name }}">

                                            <i class="fas fa-edit me-1"></i>Modifica                                    <img src="{{ asset('storage/'.$p->image_path) }}" @section('content')           href="{{ route('admin.pizzas.create') }}"           href="{{ route('admin.pizzas.create') }}"

                                        </a>

                                    </div>                                         alt="Foto di {{ $p->name }}" 

                                    

                                    {{-- Bottone elimina separato per sicurezza --}}                                         class="card-img-top" 

                                    <form method="POST" action="{{ route('admin.pizzas.destroy', $p) }}" 

                                          onsubmit="return confirm('⚠️ Sei sicuro di voler eliminare {{ $p->name }}?\n\nQuesta azione non si può annullare!')"                                         style="height:220px;object-fit:cover;border-radius: 12px 12px 0 0;">

                                          class="mb-0">

                                        @csrf                                    @if($p->is_bianca)    {{-- Messaggio di guida quando non ci sono pizze --}}           data-bs-toggle="tooltip"            data-bs-toggle="tooltip" 

                                        @method('DELETE')

                                        <button type="submit"                                         <span class="position-absolute top-0 end-0 badge bg-white text-dark m-2">

                                                class="btn btn-outline-danger btn-sm w-100"

                                                data-bs-toggle="tooltip"                                             🧀 Bianca    @if($pizzas->count() == 0)

                                                title="Elimina definitivamente {{ $p->name }}">

                                            <i class="fas fa-trash me-1"></i>🗑️ Elimina Pizza                                        </span>

                                        </button>

                                    </form>                                    @endif    <div class="row justify-content-center">           title="Clicca qui per aggiungere una nuova pizza al menu">           title="Clicca qui per aggiungere una nuova pizza al menu">

                                </div>

                            </div>                                    @if($p->is_vegan)

                        </div>

                    </div>                                        <span class="position-absolute top-0 start-0 badge bg-success text-white m-2">        <div class="col-lg-6">

                @endforeach

            </div>                                            🌱 Vegana

        </div>

    </div>                                        </span>            <div class="text-center py-5">            <i class="fas fa-plus me-2"></i>🍕 Aggiungi Nuova Pizza            <i class="fas fa-plus me-2"></i>🍕 Aggiungi Nuova Pizza



    {{-- Paginazione semplificata --}}                                    @endif

    @if($pizzas->hasPages())

    <div class="row justify-content-center mt-5">                                </div>                <div class="mb-4" style="font-size: 5rem; opacity: 0.5;">🍕</div>

        <div class="col-auto">

            <div class="card border-0 shadow-sm">                            @else

                <div class="card-body text-center">

                    <h6 class="mb-3">📄 Altre pizze</h6>                                <div class="card-img-top d-flex align-items-center justify-content-center bg-light"                 <h3 class="fw-bold text-dark mb-3">Non hai ancora nessuna pizza!</h3>        </a>        </a>

                    {{ $pizzas->links() }}

                </div>                                     style="height:220px;border-radius: 12px 12px 0 0;">

            </div>

        </div>                                    <div class="text-center">                <p class="text-muted mb-4">Inizia subito creando la tua prima pizza per il menu.</p>

    </div>

    @endif                                        <div style="font-size: 3rem; opacity: 0.5;">🍕</div>

    @endif

                                        <small class="text-muted">Nessuna foto</small>                <a class="btn btn-success btn-lg px-4 py-3 fw-bold"     </div>    </div>

    {{-- Suggerimento finale --}}

    @if($pizzas->count() > 0)                                    </div>

    <div class="row justify-content-center mt-5">

        <div class="col-lg-8">                                </div>                   href="{{ route('admin.pizzas.create') }}">

            <div class="alert alert-info border-0 text-center py-4" 

                 style="background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);">                            @endif

                <div class="mb-2">💡</div>

                <h5 class="fw-bold mb-2">Suggerimento</h5>                    <i class="fas fa-rocket me-2"></i>Crea la Prima Pizza        

                <p class="mb-3">Hai già {{ $pizzas->total() }} {{ $pizzas->total() == 1 ? 'pizza' : 'pizze' }}! 

                   Che ne dici di aggiungere anche degli antipasti o dessert?</p>                            {{-- Contenuto carta --}}

                <div class="d-flex justify-content-center gap-2 flex-wrap">

                    <a href="{{ route('admin.appetizers.index') }}" class="btn btn-outline-primary btn-sm">                            <div class="card-body d-flex flex-column p-4">                </a>

                        🥗 Vai agli Antipasti

                    </a>                                <h4 class="card-title fw-bold text-dark mb-2">{{ $p->name }}</h4>

                    <a href="{{ route('admin.desserts.index') }}" class="btn btn-outline-primary btn-sm">

                        🍰 Vai ai Dessert                                            </div>    {{-- Contatore semplice --}}    {{-- Contatore semplice --}}

                    </a>

                </div>                                {{-- Ingredienti principali --}}

            </div>

        </div>                                @if($p->ingredients->isNotEmpty())        </div>

    </div>

    @endif                                    <p class="card-text text-muted mb-3" style="line-height: 1.5;">



@endsection                                        🥬 {{ $p->ingredients->take(3)->pluck('name')->join(', ') }}    </div>    <div class="badge bg-primary fs-6 px-3 py-2">    <div class="badge bg-primary fs-6 px-3 py-2">

                                        @if($p->ingredients->count() > 3)

                                            <span class="badge bg-light text-muted ms-1">+{{ $p->ingredients->count() - 3 }}</span>    @else

                                        @endif

                                    </p>    {{-- Griglia semplificata delle pizze --}}        <i class="fas fa-pizza-slice me-1"></i>        <i class="fas fa-pizza-slice me-1"></i>

                                @endif

                                    <div class="row justify-content-center">

                                {{-- Prezzo evidenziato --}}

                                <div class="d-flex justify-content-between align-items-center mb-3">        <div class="col-12">        Hai {{ $pizzas->total() ?? 0 }} {{ $pizzas->total() == 1 ? 'pizza' : 'pizze' }} nel menu        Hai {{ $pizzas->total() ?? 0 }} {{ $pizzas->total() == 1 ? 'pizza' : 'pizze' }} nel menu

                                    <span class="h4 fw-bold text-success mb-0">€{{ number_format($p->price, 2) }}</span>

                                    @if($p->category)            <div class="row g-4" aria-live="polite">

                                        <span class="badge bg-light text-dark">{{ $p->category->name }}</span>

                                    @endif                @foreach($pizzas as $p)    </div>    </div>

                                </div>

                    <div class="col-12 col-md-6 col-xl-4">

                                {{-- Bottoni azione semplificati con coerenza cromatica --}}

                                <div class="d-grid gap-2">                        <div class="card h-100 border-0 shadow-sm hover-lift" </div></div>

                                    <div class="btn-group" role="group">

                                        <a class="btn btn-primary flex-fill"                              style="transition: all 0.3s ease;">

                                           href="{{ route('admin.pizzas.show', $p) }}"

                                           data-bs-toggle="tooltip"                             @endsection@endsection

                                           title="Guarda tutti i dettagli di {{ $p->name }}">

                                            <i class="fas fa-eye me-1"></i>Dettagli                            {{-- Immagine pizza --}}

                                        </a>

                                        <a class="btn btn-success flex-fill"                             @if($p->image_path)

                                           href="{{ route('admin.pizzas.edit', $p) }}"

                                           data-bs-toggle="tooltip"                                 <div class="position-relative">

                                           title="Modifica {{ $p->name }}">

                                            <i class="fas fa-edit me-1"></i>Modifica                                    <img src="{{ asset('storage/'.$p->image_path) }}" @section('content')@section('content')

                                        </a>

                                    </div>                                         alt="Foto di {{ $p->name }}" 

                                    

                                    {{-- Bottone elimina separato per sicurezza --}}                                         class="card-img-top" 

                                    <form method="POST" action="{{ route('admin.pizzas.destroy', $p) }}" 

                                          onsubmit="return confirm('⚠️ Sei sicuro di voler eliminare {{ $p->name }}?\n\nQuesta azione non si può annullare!')"                                         style="height:220px;object-fit:cover;border-radius: 12px 12px 0 0;">

                                          class="mb-0">

                                        @csrf                                    @if($p->is_bianca)    {{-- Filtri semplificati --}}    {{-- Filtri semplificati --}}

                                        @method('DELETE')

                                        <button type="submit"                                         <span class="position-absolute top-0 end-0 badge bg-white text-dark m-2">

                                                class="btn btn-outline-danger btn-sm w-100"

                                                data-bs-toggle="tooltip"                                             🧀 Bianca    @if($pizzas->total() > 3)    @if($pizzas->total() > 3)

                                                title="Elimina definitivamente {{ $p->name }}">

                                            <i class="fas fa-trash me-1"></i>🗑️ Elimina Pizza                                        </span>

                                        </button>

                                    </form>                                    @endif    <div class="row justify-content-center mb-4">    <div class="row justify-content-center mb-4">

                                </div>

                            </div>                                    @if($p->is_vegan)

                        </div>

                    </div>                                        <span class="position-absolute top-0 start-0 badge bg-success text-white m-2">        <div class="col-lg-8">        <div class="col-lg-8">

                @endforeach

            </div>                                            🌱 Vegana

        </div>

    </div>                                        </span>            <div class="card border-0 shadow-sm">            <div class="card border-0 shadow-sm">



    {{-- Paginazione semplificata --}}                                    @endif

    @if($pizzas->hasPages())

    <div class="row justify-content-center mt-5">                                </div>                <div class="card-header bg-light text-center">                <div class="card-header bg-light text-center">

        <div class="col-auto">

            <div class="card border-0 shadow-sm">                            @else

                <div class="card-body text-center">

                    <h6 class="mb-3">📄 Altre pizze</h6>                                <div class="card-img-top d-flex align-items-center justify-content-center bg-light"                     <h5 class="mb-0 fw-bold">🔍 Trova una pizza specifica</h5>                    <h5 class="mb-0 fw-bold">🔍 Trova una pizza specifica</h5>

                    {{ $pizzas->links() }}

                </div>                                     style="height:220px;border-radius: 12px 12px 0 0;">

            </div>

        </div>                                    <div class="text-center">                    <small class="text-muted">Usa questi filtri solo se hai molte pizze</small>                    <small class="text-muted">Usa questi filtri solo se hai molte pizze</small>

    </div>

    @endif                                        <div style="font-size: 3rem; opacity: 0.5;">🍕</div>

    @endif

                                        <small class="text-muted">Nessuna foto</small>                </div>                </div>

    {{-- Suggerimento finale --}}

    @if($pizzas->count() > 0)                                    </div>

    <div class="row justify-content-center mt-5">

        <div class="col-lg-8">                                </div>                <div class="card-body">                <div class="card-body">

            <div class="alert alert-info border-0 text-center py-4" 

                 style="background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);">                            @endif

                <div class="mb-2">💡</div>

                <h5 class="fw-bold mb-2">Suggerimento</h5>                    <x-filter-toolbar                    <x-filter-toolbar

                <p class="mb-3">Hai già {{ $pizzas->total() }} {{ $pizzas->total() == 1 ? 'pizza' : 'pizze' }}! 

                   Che ne dici di aggiungere anche degli antipasti o dessert?</p>                            {{-- Contenuto carta --}}

                <div class="d-flex justify-content-center gap-2 flex-wrap">

                    <a href="{{ route('admin.appetizers.index') }}" class="btn btn-outline-primary btn-sm">                            <div class="card-body d-flex flex-column p-4">                        search                        search

                        🥗 Vai agli Antipasti

                    </a>                                <h4 class="card-title fw-bold text-dark mb-2">{{ $p->name }}</h4>

                    <a href="{{ route('admin.desserts.index') }}" class="btn btn-outline-primary btn-sm">

                        🍰 Vai ai Dessert                                                        searchPlaceholder="Scrivi il nome della pizza che stai cercando..."                        searchPlaceholder="Scrivi il nome della pizza che stai cercando..."

                    </a>

                </div>                                {{-- Ingredienti principali --}}

            </div>

        </div>                                @if($p->ingredients->isNotEmpty())                        :selects="[                        :selects="[

    </div>

    @endif                                    <p class="card-text text-muted mb-3" style="line-height: 1.5;">



@endsection                                        🥬 {{ $p->ingredients->take(3)->pluck('name')->join(', ') }}                            ['name' => 'category', 'placeholder' => 'Tutte le categorie', 'options' => ($filters['categories'] ?? [])],                            ['name' => 'category', 'placeholder' => 'Tutte le categorie', 'options' => ($filters['categories'] ?? [])],

                                        @if($p->ingredients->count() > 3)

                                            <span class="badge bg-light text-muted ms-1">+{{ $p->ingredients->count() - 3 }}</span>                            ['name' => 'ingredient', 'placeholder' => 'Qualsiasi ingrediente', 'options' => ($filters['ingredients'] ?? [])],                            ['name' => 'ingredient', 'placeholder' => 'Qualsiasi ingrediente', 'options' => ($filters['ingredients'] ?? [])],

                                        @endif

                                    </p>                        ]"                        ]"

                                @endif

                                                        :sort-options="['' => 'Più recenti prima', 'name_asc' => 'Dalla A alla Z', 'name_desc' => 'Dalla Z alla A', 'price_asc' => 'Prezzo dal più basso', 'price_desc' => 'Prezzo dal più alto']"                        :sort-options="['' => 'Più recenti prima', 'name_asc' => 'Dalla A alla Z', 'name_desc' => 'Dalla Z alla A', 'price_asc' => 'Prezzo dal più basso', 'price_desc' => 'Prezzo dal più alto']"

                                {{-- Prezzo evidenziato --}}

                                <div class="d-flex justify-content-between align-items-center mb-3">                        :reset-url="route('admin.pizzas.index')"                        :reset-url="route('admin.pizzas.index')"

                                    <span class="h4 fw-bold text-success mb-0">€{{ number_format($p->price, 2) }}</span>

                                    @if($p->category)                    />                    />

                                        <span class="badge bg-light text-dark">{{ $p->category->name }}</span>

                                    @endif                </div>                </div>

                                </div>

            </div>            </div>

                                {{-- Bottoni azione semplificati --}}

                                <div class="d-grid gap-2">        </div>        </div>

                                    <div class="btn-group" role="group">

                                        <a class="btn btn-primary flex-fill"     </div>    </div>

                                           href="{{ route('admin.pizzas.show', $p) }}"

                                           data-bs-toggle="tooltip"     @endif    @endif

                                           title="Guarda tutti i dettagli di {{ $p->name }}">

                                            <i class="fas fa-eye me-1"></i>Dettagli

                                        </a>

                                        <a class="btn btn-success flex-fill"     {{-- Messaggio di guida quando non ci sono pizze --}}    {{-- Messaggio di guida quando non ci sono pizze --}}

                                           href="{{ route('admin.pizzas.edit', $p) }}"

                                           data-bs-toggle="tooltip"     @if($pizzas->count() == 0)    @if($pizzas->count() == 0)

                                           title="Modifica {{ $p->name }}">

                                            <i class="fas fa-edit me-1"></i>Modifica    <div class="row justify-content-center">    <div class="row justify-content-center">

                                        </a>

                                    </div>        <div class="col-lg-6">        <div class="col-lg-6">

                                    

                                    {{-- Bottone elimina separato per sicurezza --}}            <div class="text-center py-5">            <div class="text-center py-5">

                                    <form method="POST" action="{{ route('admin.pizzas.destroy', $p) }}" 

                                          onsubmit="return confirm('⚠️ Sei sicuro di voler eliminare {{ $p->name }}?\n\nQuesta azione non si può annullare!')"                <div class="mb-4" style="font-size: 5rem; opacity: 0.5;">🍕</div>                <div class="mb-4" style="font-size: 5rem; opacity: 0.5;">🍕</div>

                                          class="mb-0">

                                        @csrf                <h3 class="fw-bold text-dark mb-3">Non hai ancora nessuna pizza!</h3>                <h3 class="fw-bold text-dark mb-3">Non hai ancora nessuna pizza!</h3>

                                        @method('DELETE')

                                        <button type="submit"                 <p class="text-muted mb-4">Inizia subito creando la tua prima pizza per il menu.</p>                <p class="text-muted mb-4">Inizia subito creando la tua prima pizza per il menu.</p>

                                                class="btn btn-outline-danger btn-sm w-100"

                                                data-bs-toggle="tooltip"                 <a class="btn btn-success btn-lg px-4 py-3 fw-bold"                 <a class="btn btn-success btn-lg px-4 py-3 fw-bold" 

                                                title="Elimina definitivamente {{ $p->name }}">

                                            <i class="fas fa-trash me-1"></i>🗑️ Elimina Pizza                   href="{{ route('admin.pizzas.create') }}">                   href="{{ route('admin.pizzas.create') }}">

                                        </button>

                                    </form>                    <i class="fas fa-rocket me-2"></i>Crea la Prima Pizza                    <i class="fas fa-rocket me-2"></i>Crea la Prima Pizza

                                </div>

                            </div>                </a>                </a>

                        </div>

                    </div>            </div>            </div>

                @endforeach

            </div>        </div>        </div>

        </div>

    </div>    </div>    </div>



    {{-- Paginazione semplificata --}}    @else    @else

    @if($pizzas->hasPages())

    <div class="row justify-content-center mt-5">    {{-- Griglia semplificata delle pizze --}}    {{-- Griglia semplificata delle pizze --}}

        <div class="col-auto">

            <div class="card border-0 shadow-sm">    <div class="row justify-content-center">    <div class="row justify-content-center">

                <div class="card-body text-center">

                    <h6 class="mb-3">📄 Altre pizze</h6>        <div class="col-12">        <div class="col-12">

                    {{ $pizzas->links() }}

                </div>            <div class="row g-4" aria-live="polite">            <div class="row g-4" aria-live="polite">

            </div>

        </div>                @foreach($pizzas as $p)                @foreach($pizzas as $p)

    </div>

    @endif                    <div class="col-12 col-md-6 col-xl-4">                    <div class="col-12 col-md-6 col-xl-4">

    @endif

                        <div class="card h-100 border-0 shadow-sm hover-lift"                         <div class="card h-100 border-0 shadow-sm hover-lift" 

    {{-- Suggerimento finale --}}

    @if($pizzas->count() > 0)                             style="transition: all 0.3s ease;">                             style="transition: all 0.3s ease;">

    <div class="row justify-content-center mt-5">

        <div class="col-lg-8">                                                        

            <div class="alert alert-info border-0 text-center py-4" 

                 style="background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);">                            {{-- Immagine pizza --}}                            {{-- Immagine pizza --}}

                <div class="mb-2">💡</div>

                <h5 class="fw-bold mb-2">Suggerimento</h5>                            @if($p->image_path)                            @if($p->image_path)

                <p class="mb-3">Hai già {{ $pizzas->total() }} {{ $pizzas->total() == 1 ? 'pizza' : 'pizze' }}! 

                   Che ne dici di aggiungere anche degli antipasti o dessert?</p>                                <div class="position-relative">                                <div class="position-relative">

                <div class="d-flex justify-content-center gap-2 flex-wrap">

                    <a href="{{ route('admin.appetizers.index') }}" class="btn btn-outline-primary btn-sm">                                    <img src="{{ asset('storage/'.$p->image_path) }}"                                     <img src="{{ asset('storage/'.$p->image_path) }}" 

                        🥗 Vai agli Antipasti

                    </a>                                         alt="Foto di {{ $p->name }}"                                          alt="Foto di {{ $p->name }}" 

                    <a href="{{ route('admin.desserts.index') }}" class="btn btn-outline-primary btn-sm">

                        🍰 Vai ai Dessert                                         class="card-img-top"                                          class="card-img-top" 

                    </a>

                </div>                                         style="height:220px;object-fit:cover;border-radius: 12px 12px 0 0;">                                         style="height:220px;object-fit:cover;border-radius: 12px 12px 0 0;">

            </div>

        </div>                                    @if($p->is_bianca)                                </div>

    </div>

    @endif                                        <span class="position-absolute top-0 end-0 badge bg-white text-dark m-2">                            @else



@endsection                                            🧀 Bianca                                <div class="card-img-top d-flex align-items-center justify-content-center bg-light" 

                                        </span>                                     style="height:220px;border-radius: 12px 12px 0 0;">

                                    @endif                                    <div class="text-center">

                                    @if($p->is_vegan)                                        <div style="font-size: 3rem; opacity: 0.5;">🍕</div>

                                        <span class="position-absolute top-0 start-0 badge bg-success text-white m-2">                                        <small class="text-muted">Nessuna foto</small>

                                            🌱 Vegana                                    </div>

                                        </span>                                </div>

                                    @endif                            @endif

                                </div>

                            @else                            {{-- Contenuto carta --}}

                                <div class="card-img-top d-flex align-items-center justify-content-center bg-light"                             <div class="card-body d-flex flex-column p-4">

                                     style="height:220px;border-radius: 12px 12px 0 0;">                                <h4 class="card-title fw-bold text-dark mb-2">{{ $p->name }}</h4>

                                    <div class="text-center">                                

                                        <div style="font-size: 3rem; opacity: 0.5;">🍕</div>                                @if($p->description)

                                        <small class="text-muted">Nessuna foto</small>                                    <p class="card-text text-muted flex-grow-1 mb-3" style="line-height: 1.5;">

                                    </div>                                        {{ Str::limit($p->description, 100) }}

                                </div>                                    </p>

                            @endif                                @endif

                                

                            {{-- Contenuto carta --}}                                {{-- Prezzo evidenziato --}}

                            <div class="card-body d-flex flex-column p-4">                                <div class="d-flex justify-content-between align-items-center mb-3">

                                <h4 class="card-title fw-bold text-dark mb-2">{{ $p->name }}</h4>                                    <span class="h4 fw-bold text-success mb-0">€{{ number_format($p->price, 2) }}</span>

                                                                    @if($p->category)

                                {{-- Ingredienti principali --}}                                        <span class="badge bg-light text-dark">{{ $p->category->name }}</span>

                                @if($p->ingredients->isNotEmpty())                                    @endif

                                    <p class="card-text text-muted mb-3" style="line-height: 1.5;">                                </div>

                                        🥬 {{ $p->ingredients->take(3)->pluck('name')->join(', ') }}

                                        @if($p->ingredients->count() > 3)                                {{-- Bottoni azione semplificati --}}

                                            <span class="badge bg-light text-muted ms-1">+{{ $p->ingredients->count() - 3 }}</span>                                <div class="d-grid gap-2">

                                        @endif                                    <div class="btn-group" role="group">

                                    </p>                                        <a class="btn btn-primary flex-fill" 

                                @endif                                           href="{{ route('admin.pizzas.show', $p) }}"

                                                                           data-bs-toggle="tooltip" 

                                {{-- Prezzo evidenziato --}}                                           title="Guarda tutti i dettagli di {{ $p->name }}">

                                <div class="d-flex justify-content-between align-items-center mb-3">                                            <i class="fas fa-eye me-1"></i>Dettagli

                                    <span class="h4 fw-bold text-success mb-0">€{{ number_format($p->price, 2) }}</span>                                        </a>

                                    @if($p->category)                                        <a class="btn btn-success flex-fill" 

                                        <span class="badge bg-light text-dark">{{ $p->category->name }}</span>                                           href="{{ route('admin.pizzas.edit', $p) }}"

                                    @endif                                           data-bs-toggle="tooltip" 

                                </div>                                           title="Modifica {{ $p->name }}">

                                            <i class="fas fa-edit me-1"></i>Modifica

                                {{-- Bottoni azione semplificati --}}                                        </a>

                                <div class="d-grid gap-2">                                    </div>

                                    <div class="btn-group" role="group">                                    

                                        <a class="btn btn-primary flex-fill"                                     {{-- Bottone elimina separato per sicurezza --}}

                                           href="{{ route('admin.pizzas.show', $p) }}"                                    <form method="POST" action="{{ route('admin.pizzas.destroy', $p) }}" 

                                           data-bs-toggle="tooltip"                                           onsubmit="return confirm('⚠️ Sei sicuro di voler eliminare {{ $p->name }}?\n\nQuesta azione non si può annullare!')"

                                           title="Guarda tutti i dettagli di {{ $p->name }}">                                          class="mb-0">

                                            <i class="fas fa-eye me-1"></i>Dettagli                                        @csrf

                                        </a>                                        @method('DELETE')

                                        <a class="btn btn-success flex-fill"                                         <button type="submit" 

                                           href="{{ route('admin.pizzas.edit', $p) }}"                                                class="btn btn-outline-danger btn-sm w-100"

                                           data-bs-toggle="tooltip"                                                 data-bs-toggle="tooltip" 

                                           title="Modifica {{ $p->name }}">                                                title="Elimina definitivamente {{ $p->name }}">

                                            <i class="fas fa-edit me-1"></i>Modifica                                            <i class="fas fa-trash me-1"></i>🗑️ Elimina Pizza

                                        </a>                                        </button>

                                    </div>                                    </form>

                                                                    </div>

                                    {{-- Bottone elimina separato per sicurezza --}}                            </div>

                                    <form method="POST" action="{{ route('admin.pizzas.destroy', $p) }}"                         </div>

                                          onsubmit="return confirm('⚠️ Sei sicuro di voler eliminare {{ $p->name }}?\n\nQuesta azione non si può annullare!')"                    </div>

                                          class="mb-0">                @endforeach

                                        @csrf            </div>

                                        @method('DELETE')        </div>

                                        <button type="submit"     </div>

                                                class="btn btn-outline-danger btn-sm w-100"

                                                data-bs-toggle="tooltip"     {{-- Paginazione semplificata --}}

                                                title="Elimina definitivamente {{ $p->name }}">    @if($pizzas->hasPages())

                                            <i class="fas fa-trash me-1"></i>🗑️ Elimina Pizza    <div class="row justify-content-center mt-5">

                                        </button>        <div class="col-auto">

                                    </form>            <div class="card border-0 shadow-sm">

                                </div>                <div class="card-body text-center">

                            </div>                    <h6 class="mb-3">📄 Altre pizze</h6>

                        </div>                    {{ $pizzas->links() }}

                    </div>                </div>

                @endforeach            </div>

            </div>        </div>

        </div>    </div>

    </div>    @endif

    @endif

    {{-- Paginazione semplificata --}}

    @if($pizzas->hasPages())    {{-- Suggerimento finale --}}

    <div class="row justify-content-center mt-5">    @if($pizzas->count() > 0)

        <div class="col-auto">    <div class="row justify-content-center mt-5">

            <div class="card border-0 shadow-sm">        <div class="col-lg-8">

                <div class="card-body text-center">            <div class="alert alert-info border-0 text-center py-4" 

                    <h6 class="mb-3">📄 Altre pizze</h6>                 style="background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);">

                    {{ $pizzas->links() }}                <div class="mb-2">💡</div>

                </div>                <h5 class="fw-bold mb-2">Suggerimento</h5>

            </div>                <p class="mb-3">Hai già {{ $pizzas->total() }} {{ $pizzas->total() == 1 ? 'pizza' : 'pizze' }}! 

        </div>                   Che ne dici di aggiungere anche degli antipasti o dessert?</p>

    </div>                <div class="d-flex justify-content-center gap-2 flex-wrap">

    @endif                    <a href="{{ route('admin.appetizers.index') }}" class="btn btn-outline-primary btn-sm">

    @endif                        🥗 Vai agli Antipasti

                    </a>

    {{-- Suggerimento finale --}}                    <a href="{{ route('admin.desserts.index') }}" class="btn btn-outline-primary btn-sm">

    @if($pizzas->count() > 0)                        🍰 Vai ai Dessert

    <div class="row justify-content-center mt-5">                    </a>

        <div class="col-lg-8">                </div>

            <div class="alert alert-info border-0 text-center py-4"             </div>

                 style="background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);">        </div>

                <div class="mb-2">💡</div>    </div>

                <h5 class="fw-bold mb-2">Suggerimento</h5>    @endif

                <p class="mb-3">Hai già {{ $pizzas->total() }} {{ $pizzas->total() == 1 ? 'pizza' : 'pizze' }}! 

                   Che ne dici di aggiungere anche degli antipasti o dessert?</p>@endsection

                <div class="d-flex justify-content-center gap-2 flex-wrap">                    @if($p->image_path)

                    <a href="{{ route('admin.appetizers.index') }}" class="btn btn-outline-primary btn-sm">                        <div class="position-relative">

                        🥗 Vai agli Antipasti                            {{-- 🚀 LAZY LOADING OTTIMIZZATO --}}

                    </a>                            <img 

                    <a href="{{ route('admin.desserts.index') }}" class="btn btn-outline-primary btn-sm">                                data-src="{{ Storage::url($p->image_path) }}" 

                        🍰 Vai ai Dessert                                alt="Immagine di {{ $p->name }}" 

                    </a>                                class="card-img-top object-fit-cover"

                </div>                                style="height: 200px; opacity: 0; transition: opacity 0.3s ease;"

            </div>                                loading="lazy"

        </div>                                data-critical="{{ $loop->index < 3 ? 'true' : 'false' }}"

    </div>                            />

    @endif                            @if($p->is_bianca)

                                <span class="position-absolute top-0 end-0 badge bg-white text-dark m-2">

@endsection                                    <i class="fas fa-cheese me-1"></i>Bianca
                                </span>
                            @endif
                            @if($p->is_vegan)
                                <span class="position-absolute top-0 start-0 badge bg-success text-white m-2">
                                    <i class="fas fa-leaf me-1"></i>Vegano
                                </span>
                            @endif
                        </div>
                    @else
                        <div class="d-flex align-items-center justify-content-center bg-light" style="height: 200px;">
                            <div class="text-center text-muted">
                                <i class="fas fa-image fa-3x mb-2 opacity-50"></i>
                                <br><small>Nessuna immagine</small>
                            </div>
                        </div>
                    @endif                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <a href="{{ route('admin.pizzas.show', $p) }}" 
                               class="h5 mb-0 text-decoration-none fw-bold text-dark hover-primary">
                                {{ $p->name }}
                            </a>
                            <div class="text-end">
                                <div class="h5 mb-0 text-primary fw-bold">
                                    €{{ number_format($p->price, 2, ',', '.') }}
                                </div>
                                @if($p->category)
                                    <span class="badge bg-light text-muted small">{{ $p->category->name }}</span>
                                @endif
                            </div>
                        </div>
                        
                        @php($ingredientNames = $p->ingredients->pluck('name'))
                        @if($ingredientNames->isNotEmpty())
                            <div class="mb-3">
                                <div class="small text-muted mb-1">
                                    <i class="fas fa-seedling me-1"></i>
                                    Ingredienti:
                                </div>
                                <div class="small text-dark" title="{{ $ingredientNames->join(', ') }}">
                                    {{ \Illuminate\Support\Str::limit($ingredientNames->join(', '), 100) }}
                                </div>
                            </div>
                        @endif
                        
                        @php(
                            $allergenNames = collect($p->ingredients)
                                ->flatMap(fn($ing) => $ing->allergens->pluck('name'))
                                ->unique()
                                ->values()
                        )
                        @if($allergenNames->isNotEmpty())
                            <div class="mb-3">
                                <div class="small text-warning mb-1">
                                    <i class="fas fa-exclamation-triangle me-1"></i>
                                    Allergeni:
                                </div>
                                <div class="d-flex flex-wrap gap-1">
                                    @foreach($allergenNames->take(3) as $allergen)
                                        <span class="badge bg-warning bg-opacity-10 text-warning">{{ $allergen }}</span>
                                    @endforeach
                                    @if($allergenNames->count() > 3)
                                        <span class="badge bg-light text-muted">+{{ $allergenNames->count() - 3 }}</span>
                                    @endif
                                </div>
                            </div>
                        @endif
                        
                        @if(!empty($p->notes))
                            <div class="alert alert-warning py-2 px-3 mb-3 small border-0" role="note">
                                <i class="fas fa-info-circle me-1"></i>
                                <strong>Nota:</strong> {{ \Illuminate\Support\Str::limit($p->notes, 80) }}
                            </div>
                        @endif
                        
                        <div class="d-flex gap-2 mt-auto">
                            <a class="btn btn-success btn-sm flex-fill" 
                               href="{{ route('admin.pizzas.edit', $p) }}" 
                               aria-label="Modifica pizza {{ $p->name }}">
                                <i class="fas fa-edit me-1"></i>
                                Modifica
                            </a>
                            <form class="flex-fill" method="POST" action="{{ route('admin.pizzas.destroy', $p) }}" 
                                  data-confirm="Sicuro di voler eliminare la pizza '{{ $p->name }}'?">
                                @csrf @method('DELETE')
                                <button class="btn btn-outline-danger btn-sm w-100" 
                                        type="submit" 
                                        aria-label="Elimina pizza {{ $p->name }}">
                                    <i class="fas fa-trash me-1"></i>
                                    Elimina
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card border-0 bg-light">
                    <div class="card-body text-center py-5">
                        <div class="display-1 text-muted mb-3">🍕</div>
                        <h4 class="text-muted mb-3">Nessuna pizza trovata</h4>
                        <p class="text-muted mb-4">Inizia ad aggiungere le tue pizze per costruire il menu perfetto</p>
                        <a href="{{ route('admin.pizzas.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>
                            Crea la prima pizza
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    {{-- Paginazione moderna --}}
    @if($pizzas->hasPages())
        <div class="d-flex justify-content-center mt-5">
            <nav aria-label="Navigazione pizze">
                {{ $pizzas->links('pagination.custom') }}
            </nav>
        </div>
    @endif
@endsection
