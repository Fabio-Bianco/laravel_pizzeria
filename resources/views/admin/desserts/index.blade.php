@extends('layouts.app-modern')@extends('layouts.app-modern')@extends('layouts.app-modern')



@section('title', 'I Tuoi Dessert')



@section('header')@section('title', 'I Tuoi Dessert')@section('title', 'Gestione Dessert')

<div class="text-center py-4">

    <div class="mb-3">

        <div style="font-size: 3rem;">🍰</div>

    </div>@section('header')@section('header')

    <h1 class="display-6 fw-bold text-dark mb-2">I Tuoi Dessert</h1>

    <p class="lead text-muted mb-4">Tutti i dolci e dessert del tuo menu</p><div class="text-center py-4"><div class="d-flex justify-content-between align-items-center">

    

    {{-- Azione principale sempre visibile --}}    <div class="mb-3">    <div>

    <div class="d-flex justify-content-center gap-3 mb-3">

        <a class="btn btn-success btn-lg px-4 py-3 fw-bold"         <div style="font-size: 3rem;">🍰</div>        <h1 class="page-title">

           href="{{ route('admin.desserts.create') }}"

           data-bs-toggle="tooltip"     </div>            <i class="fas fa-birthday-cake text-warning me-2"></i>

           title="Clicca qui per aggiungere un nuovo dessert al menu">

            <i class="fas fa-plus me-2"></i>🍰 Aggiungi Nuovo Dessert    <h1 class="display-6 fw-bold text-dark mb-2">I Tuoi Dessert</h1>            Gestione Dessert

        </a>

    </div>    <p class="lead text-muted mb-4">Tutti i dolci e dessert del tuo menu</p>        </h1>

    

    {{-- Contatore semplice --}}            <p class="page-subtitle">Organizza e modifica i tuoi dolci e dessert</p>

    <div class="badge bg-warning fs-6 px-3 py-2">

        <i class="fas fa-birthday-cake me-1"></i>    {{-- Azione principale sempre visibile --}}    </div>

        Hai {{ $desserts->total() ?? 0 }} {{ $desserts->total() == 1 ? 'dessert' : 'dessert' }} nel menu

    </div>    <div class="d-flex justify-content-center gap-3 mb-3">    <div class="d-flex gap-2">

</div>

@endsection        <a class="btn btn-success btn-lg px-4 py-3 fw-bold"         <span class="badge bg-light text-dark fs-6 px-3 py-2">



@section('content')           href="{{ route('admin.desserts.create') }}"            <i class="fas fa-list me-1"></i>



    {{-- Messaggio di guida quando non ci sono dessert --}}           data-bs-toggle="tooltip"             {{ $desserts->total() ?? 0 }} dessert totali

    @if($desserts->count() == 0)

    <div class="row justify-content-center">           title="Clicca qui per aggiungere un nuovo dessert al menu">        </span>

        <div class="col-lg-6">

            <div class="text-center py-5">            <i class="fas fa-plus me-2"></i>🍰 Aggiungi Nuovo Dessert        <a class="btn btn-warning px-4 py-2" href="{{ route('admin.desserts.create') }}">

                <div class="mb-4" style="font-size: 5rem; opacity: 0.5;">🍰</div>

                <h3 class="fw-bold text-dark mb-3">Non hai ancora nessun dessert!</h3>        </a>            <i class="fas fa-plus me-2"></i>

                <p class="text-muted mb-4">Inizia subito aggiungendo i primi dolci per il menu.</p>

                <a class="btn btn-success btn-lg px-4 py-3 fw-bold"     </div>            Nuovo Dessert

                   href="{{ route('admin.desserts.create') }}">

                    <i class="fas fa-rocket me-2"></i>Crea il Primo Dessert            </a>

                </a>

            </div>    {{-- Contatore semplice --}}    </div>

        </div>

    </div>    <div class="badge bg-warning fs-6 px-3 py-2"></div>

    @else

    {{-- Griglia semplificata dei dessert --}}        <i class="fas fa-birthday-cake me-1"></i>@endsection

    <div class="row justify-content-center">

        <div class="col-12">        Hai {{ $desserts->total() ?? 0 }} {{ $desserts->total() == 1 ? 'dessert' : 'dessert' }} nel menu

            <div class="row g-4" aria-live="polite">

                @foreach($desserts as $d)    </div>@section('content')

                    <div class="col-12 col-md-6 col-xl-4">

                        <div class="card h-100 border-0 shadow-sm hover-lift" </div>    {{-- Barra filtri moderna --}}

                             style="transition: all 0.3s ease;">

                            @endsection    <div class="card border-0 shadow-sm mb-4">

                            {{-- Immagine dessert --}}

                            @if($d->image_path)        <div class="card-body">

                                <div class="position-relative">

                                    <img src="{{ asset('storage/'.$d->image_path) }}" @section('content')            <x-filter-toolbar

                                         alt="Foto di {{ $d->name }}" 

                                         class="card-img-top"                 search

                                         style="height:220px;object-fit:cover;border-radius: 12px 12px 0 0;">

                                    @if($d->is_vegan)    {{-- Messaggio di guida quando non ci sono dessert --}}                searchPlaceholder="Cerca dessert per nome o descrizione..."

                                        <span class="position-absolute top-0 start-0 badge bg-success text-white m-2">

                                            🌱 Vegano    @if($desserts->count() == 0)                :sort-options="['' => 'Più recenti', 'name_asc' => 'Nome A→Z', 'name_desc' => 'Nome Z→A', 'price_asc' => 'Prezzo ↑', 'price_desc' => 'Prezzo ↓']"

                                        </span>

                                    @endif    <div class="row justify-content-center">                :reset-url="route('admin.desserts.index')"

                                </div>

                            @else        <div class="col-lg-6">            />

                                <div class="card-img-top d-flex align-items-center justify-content-center bg-light" 

                                     style="height:220px;border-radius: 12px 12px 0 0;">            <div class="text-center py-5">        </div>

                                    <div class="text-center">

                                        <div style="font-size: 3rem; opacity: 0.5;">🍰</div>                <div class="mb-4" style="font-size: 5rem; opacity: 0.5;">🍰</div>    </div>

                                        <small class="text-muted">Nessuna foto</small>

                                    </div>                <h3 class="fw-bold text-dark mb-3">Non hai ancora nessun dessert!</h3>

                                </div>

                            @endif                <p class="text-muted mb-4">Inizia subito aggiungendo i primi dolci per il menu.</p>    {{-- Griglia dessert moderna --}}



                            {{-- Contenuto carta --}}                <a class="btn btn-success btn-lg px-4 py-3 fw-bold"     <div class="row g-4" aria-live="polite">

                            <div class="card-body d-flex flex-column p-4">

                                <h4 class="card-title fw-bold text-dark mb-2">{{ $d->name }}</h4>                   href="{{ route('admin.desserts.create') }}">        @forelse($desserts as $d)

                                

                                {{-- Descrizione breve --}}                    <i class="fas fa-rocket me-2"></i>Crea il Primo Dessert            <div class="col-12 col-lg-6 col-xl-4">

                                @if($d->description)

                                    <p class="card-text text-muted mb-3" style="line-height: 1.5;">                </a>                <div class="card h-100 border-0 shadow-sm hover-lift" role="article" aria-label="Scheda dessert {{ $d->name }}">

                                        {{ Str::limit($d->description, 100) }}

                                    </p>            </div>                    @if($d->image_path)

                                @endif

                                        </div>                        <div class="position-relative">

                                {{-- Prezzo evidenziato --}}

                                <div class="d-flex justify-content-between align-items-center mb-3">    </div>                            <img src="{{ asset('storage/'.$d->image_path) }}" 

                                    <span class="h4 fw-bold text-warning mb-0">€{{ number_format($d->price, 2) }}</span>

                                    @if($d->is_vegan)    @else                                 alt="Immagine dessert {{ $d->name }}" 

                                        <span class="badge bg-success text-white">🌱 Vegano</span>

                                    @endif    {{-- Griglia semplificata dei dessert --}}                                 class="card-img-top" 

                                </div>

    <div class="row justify-content-center">                                 style="height:200px;object-fit:cover;">

                                {{-- Bottoni azione semplificati --}}

                                <div class="d-grid gap-2">        <div class="col-12">                            @if($d->is_vegan)

                                    <div class="btn-group" role="group">

                                        <a class="btn btn-primary flex-fill"             <div class="row g-4" aria-live="polite">                                <span class="position-absolute top-0 start-0 badge bg-success text-white m-2">

                                           href="{{ route('admin.desserts.show', $d) }}"

                                           data-bs-toggle="tooltip"                 @foreach($desserts as $d)                                    <i class="fas fa-leaf me-1"></i>Vegano

                                           title="Guarda tutti i dettagli di {{ $d->name }}">

                                            <i class="fas fa-eye me-1"></i>Dettagli                    <div class="col-12 col-md-6 col-xl-4">                                </span>

                                        </a>

                                        <a class="btn btn-success flex-fill"                         <div class="card h-100 border-0 shadow-sm hover-lift"                             @endif

                                           href="{{ route('admin.desserts.edit', $d) }}"

                                           data-bs-toggle="tooltip"                              style="transition: all 0.3s ease;">                        </div>

                                           title="Modifica {{ $d->name }}">

                                            <i class="fas fa-edit me-1"></i>Modifica                                                @else

                                        </a>

                                    </div>                            {{-- Immagine dessert --}}                        <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height:200px;">

                                    

                                    {{-- Bottone elimina separato per sicurezza --}}                            @if($d->image_path)                            <div class="text-center text-muted">

                                    <form method="POST" action="{{ route('admin.desserts.destroy', $d) }}" 

                                          onsubmit="return confirm('⚠️ Sei sicuro di voler eliminare {{ $d->name }}?\n\nQuesta azione non si può annullare!')"                                <div class="position-relative">                                <i class="fas fa-birthday-cake fs-1 mb-2 text-warning"></i>

                                          class="mb-0">

                                        @csrf                                    <img src="{{ asset('storage/'.$d->image_path) }}"                                 <div class="small">Nessuna immagine</div>

                                        @method('DELETE')

                                        <button type="submit"                                          alt="Foto di {{ $d->name }}"                                 @if($d->is_vegan)

                                                class="btn btn-outline-danger btn-sm w-100"

                                                data-bs-toggle="tooltip"                                          class="card-img-top"                                     <span class="position-absolute top-0 start-0 badge bg-success text-white m-2">

                                                title="Elimina definitivamente {{ $d->name }}">

                                            <i class="fas fa-trash me-1"></i>🗑️ Elimina Dessert                                         style="height:220px;object-fit:cover;border-radius: 12px 12px 0 0;">                                        <i class="fas fa-leaf me-1"></i>Vegano

                                        </button>

                                    </form>                                    @if($d->is_vegan)                                    </span>

                                </div>

                            </div>                                        <span class="position-absolute top-0 start-0 badge bg-success text-white m-2">                                @endif

                        </div>

                    </div>                                            🌱 Vegano                            </div>

                @endforeach

            </div>                                        </span>                        </div>

        </div>

    </div>                                    @endif                    @endif



    {{-- Paginazione semplificata --}}                                </div>                    

    @if($desserts->hasPages())

    <div class="row justify-content-center mt-5">                            @else                    <div class="card-body d-flex flex-column">

        <div class="col-auto">

            <div class="card border-0 shadow-sm">                                <div class="card-img-top d-flex align-items-center justify-content-center bg-light"                         <div class="d-flex justify-content-between align-items-start mb-3">

                <div class="card-body text-center">

                    <h6 class="mb-3">📄 Altri dessert</h6>                                     style="height:220px;border-radius: 12px 12px 0 0;">                            <a href="{{ route('admin.desserts.show', $d) }}" 

                    {{ $desserts->links() }}

                </div>                                    <div class="text-center">                               class="h5 mb-0 text-decoration-none fw-bold text-dark hover-primary">

            </div>

        </div>                                        <div style="font-size: 3rem; opacity: 0.5;">🍰</div>                                {{ $d->name }}

    </div>

    @endif                                        <small class="text-muted">Nessuna foto</small>                            </a>

    @endif

                                    </div>                            <div class="text-end">

    {{-- Suggerimento finale --}}

    @if($desserts->count() > 0)                                </div>                                <div class="h5 mb-0 text-warning fw-bold">

    <div class="row justify-content-center mt-5">

        <div class="col-lg-8">                            @endif                                    €{{ number_format($d->price, 2, ',', '.') }}

            <div class="alert alert-info border-0 text-center py-4" 

                 style="background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);">                                </div>

                <div class="mb-2">💡</div>

                <h5 class="fw-bold mb-2">Suggerimento</h5>                            {{-- Contenuto carta --}}                            </div>

                <p class="mb-3">Hai già {{ $desserts->total() }} {{ $desserts->total() == 1 ? 'dessert' : 'dessert' }}! 

                   Che ne dici di aggiungere anche delle pizze o bevande?</p>                            <div class="card-body d-flex flex-column p-4">                        </div>

                <div class="d-flex justify-content-center gap-2 flex-wrap">

                    <a href="{{ route('admin.pizzas.index') }}" class="btn btn-outline-primary btn-sm">                                <h4 class="card-title fw-bold text-dark mb-2">{{ $d->name }}</h4>                        

                        🍕 Vai alle Pizze

                    </a>                                                        @if($d->description)

                    <a href="{{ route('admin.beverages.index') }}" class="btn btn-outline-primary btn-sm">

                        🥤 Vai alle Bevande                                {{-- Descrizione breve --}}                            <div class="mb-3">

                    </a>

                </div>                                @if($d->description)                                <div class="small text-muted mb-1">

            </div>

        </div>                                    <p class="card-text text-muted mb-3" style="line-height: 1.5;">                                    <i class="fas fa-align-left me-1"></i>

    </div>

    @endif                                        {{ Str::limit($d->description, 100) }}                                    Descrizione:



@endsection                                    </p>                                </div>

                                @endif                                <div class="small text-dark">

                                                                    {{ \Illuminate\Support\Str::limit($d->description, 120) }}

                                {{-- Prezzo evidenziato --}}                                </div>

                                <div class="d-flex justify-content-between align-items-center mb-3">                            </div>

                                    <span class="h4 fw-bold text-warning mb-0">€{{ number_format($d->price, 2) }}</span>                        @endif

                                    @if($d->is_vegan)                        

                                        <span class="badge bg-success text-white">🌱 Vegano</span>                        @if($d->ingredients && $d->ingredients->isNotEmpty())

                                    @endif                            <div class="mb-3">

                                </div>                                <div class="small text-muted mb-1">

                                    <i class="fas fa-seedling me-1"></i>

                                {{-- Bottoni azione semplificati --}}                                    Ingredienti:

                                <div class="d-grid gap-2">                                </div>

                                    <div class="btn-group" role="group">                                <div class="d-flex flex-wrap gap-1">

                                        <a class="btn btn-primary flex-fill"                                     @foreach($d->ingredients->take(3) as $ingredient)

                                           href="{{ route('admin.desserts.show', $d) }}"                                        <span class="badge bg-light text-dark">{{ $ingredient->name }}</span>

                                           data-bs-toggle="tooltip"                                     @endforeach

                                           title="Guarda tutti i dettagli di {{ $d->name }}">                                    @if($d->ingredients->count() > 3)

                                            <i class="fas fa-eye me-1"></i>Dettagli                                        <span class="badge bg-secondary">+{{ $d->ingredients->count() - 3 }}</span>

                                        </a>                                    @endif

                                        <a class="btn btn-success flex-fill"                                 </div>

                                           href="{{ route('admin.desserts.edit', $d) }}"                            </div>

                                           data-bs-toggle="tooltip"                         @endif

                                           title="Modifica {{ $d->name }}">                        

                                            <i class="fas fa-edit me-1"></i>Modifica                        @if(!empty($d->notes))

                                        </a>                            <div class="alert alert-info py-2 px-3 mb-3 small border-0" role="note">

                                    </div>                                <i class="fas fa-info-circle me-1"></i>

                                                                    <strong>Nota:</strong> {{ \Illuminate\Support\Str::limit($d->notes, 80) }}

                                    {{-- Bottone elimina separato per sicurezza --}}                            </div>

                                    <form method="POST" action="{{ route('admin.desserts.destroy', $d) }}"                         @endif

                                          onsubmit="return confirm('⚠️ Sei sicuro di voler eliminare {{ $d->name }}?\n\nQuesta azione non si può annullare!')"                        

                                          class="mb-0">                        <div class="d-flex gap-2 mt-auto">

                                        @csrf                            <a class="btn btn-success btn-sm flex-fill" 

                                        @method('DELETE')                               href="{{ route('admin.desserts.edit', $d) }}" 

                                        <button type="submit"                                aria-label="Modifica dessert {{ $d->name }}">

                                                class="btn btn-outline-danger btn-sm w-100"                                <i class="fas fa-edit me-1"></i>

                                                data-bs-toggle="tooltip"                                 Modifica

                                                title="Elimina definitivamente {{ $d->name }}">                            </a>

                                            <i class="fas fa-trash me-1"></i>🗑️ Elimina Dessert                            <form class="flex-fill" method="POST" action="{{ route('admin.desserts.destroy', $d) }}" 

                                        </button>                                  data-confirm="Sicuro di voler eliminare il dessert '{{ $d->name }}'?">

                                    </form>                                @csrf @method('DELETE')

                                </div>                                <button class="btn btn-outline-danger btn-sm w-100" 

                            </div>                                        type="submit" 

                        </div>                                        aria-label="Elimina dessert {{ $d->name }}">

                    </div>                                    <i class="fas fa-trash me-1"></i>

                @endforeach                                    Elimina

            </div>                                </button>

        </div>                            </form>

    </div>                        </div>

                    </div>

    {{-- Paginazione semplificata --}}                </div>

    @if($desserts->hasPages())            </div>

    <div class="row justify-content-center mt-5">        @empty

        <div class="col-auto">            <div class="col-12">

            <div class="card border-0 shadow-sm">                <div class="card border-0 bg-light">

                <div class="card-body text-center">                    <div class="card-body text-center py-5">

                    <h6 class="mb-3">📄 Altri dessert</h6>                        <div class="display-1 text-muted mb-3">🍰</div>

                    {{ $desserts->links() }}                        <h4 class="text-muted mb-3">Nessun dessert trovato</h4>

                </div>                        <p class="text-muted mb-4">Inizia ad aggiungere dessert per arricchire il tuo menu</p>

            </div>                        <a href="{{ route('admin.desserts.create') }}" class="btn btn-warning">

        </div>                            <i class="fas fa-plus me-2"></i>

    </div>                            Crea il primo dessert

    @endif                        </a>

    @endif                    </div>

                </div>

    {{-- Suggerimento finale --}}            </div>

    @if($desserts->count() > 0)        @endforelse

    <div class="row justify-content-center mt-5">    </div>

        <div class="col-lg-8">

            <div class="alert alert-info border-0 text-center py-4"     {{-- Paginazione moderna --}}

                 style="background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);">    @if($desserts->hasPages())

                <div class="mb-2">💡</div>        <div class="d-flex justify-content-center mt-5">

                <h5 class="fw-bold mb-2">Suggerimento</h5>            <nav aria-label="Navigazione dessert">

                <p class="mb-3">Hai già {{ $desserts->total() }} {{ $desserts->total() == 1 ? 'dessert' : 'dessert' }}!                 {{ $desserts->links('pagination.custom') }}

                   Che ne dici di aggiungere anche delle pizze o bevande?</p>            </nav>

                <div class="d-flex justify-content-center gap-2 flex-wrap">        </div>

                    <a href="{{ route('admin.pizzas.index') }}" class="btn btn-outline-primary btn-sm">    @endif

                        🍕 Vai alle Pizze@endsection
                    </a>
                    <a href="{{ route('admin.beverages.index') }}" class="btn btn-outline-primary btn-sm">
                        🥤 Vai alle Bevande
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

@endsection