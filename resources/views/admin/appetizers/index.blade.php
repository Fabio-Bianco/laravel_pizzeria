@extends('layouts.app-modern')@extends('layouts.app-modern')@extends('layouts.app-modern')



@section('title', 'I Tuoi Antipasti')



@section('header')@section('title', 'I Tuoi Antipasti')@section('title', 'I Tuoi Antipasti')

<div class="text-center py-4">

    <div class="mb-3">

        <div style="font-size: 3rem;">🥗</div>

    </div>@section('header')@section('header')

    <h1 class="display-6 fw-bold text-dark mb-2">I Tuoi Antipasti</h1>

    <p class="lead text-muted mb-4">Tutti gli antipasti e stuzzichini del tuo menu</p><div class="text-center py-4"><div class="text-center py-4">

    

    {{-- Azione principale sempre visibile --}}    <div class="mb-3">    <div class="mb-3">

    <div class="d-flex justify-content-center gap-3 mb-3">

        <a class="btn btn-success btn-lg px-4 py-3 fw-bold"         <div style="font-size: 3rem;">🥗</div>        <div style="font-size: 3rem;">🥗</div>

           href="{{ route('admin.appetizers.create') }}"

           data-bs-toggle="tooltip"     </div>    </div>

           title="Clicca qui per aggiungere un nuovo antipasto al menu">

            <i class="fas fa-plus me-2"></i>🥗 Aggiungi Nuovo Antipasto    <h1 class="display-6 fw-bold text-dark mb-2">I Tuoi Antipasti</h1>    <h1 class="display-6 fw-bold text-dark mb-2">I Tuoi Antipasti</h1>

        </a>

    </div>    <p class="lead text-muted mb-4">Tutti gli antipasti e stuzzichini del tuo menu</p>    <p class="lead text-muted mb-4">Tutti gli antipasti e stuzzichini del tuo menu</p>

    

    {{-- Contatore semplice --}}        

    <div class="badge bg-success fs-6 px-3 py-2">

        <i class="fas fa-salad me-1"></i>    {{-- Azione principale sempre visibile --}}    {{-- Azione principale sempre visibile --}}

        Hai {{ $appetizers->total() ?? 0 }} {{ $appetizers->total() == 1 ? 'antipasto' : 'antipasti' }} nel menu

    </div>    <div class="d-flex justify-content-center gap-3 mb-3">    <div class="d-flex justify-content-center gap-3 mb-3">

</div>

@endsection        <a class="btn btn-success btn-lg px-4 py-3 fw-bold"         <a class="btn btn-success btn-lg px-4 py-3 fw-bold" 



@section('content')           href="{{ route('admin.appetizers.create') }}"           href="{{ route('admin.appetizers.create') }}"



    {{-- Messaggio di guida quando non ci sono antipasti --}}           data-bs-toggle="tooltip"            data-bs-toggle="tooltip" 

    @if($appetizers->count() == 0)

    <div class="row justify-content-center">           title="Clicca qui per aggiungere un nuovo antipasto al menu">           title="Clicca qui per aggiungere un nuovo antipasto al menu">

        <div class="col-lg-6">

            <div class="text-center py-5">            <i class="fas fa-plus me-2"></i>🥗 Aggiungi Nuovo Antipasto            <i class="fas fa-plus me-2"></i>🥗 Aggiungi Nuovo Antipasto

                <div class="mb-4" style="font-size: 5rem; opacity: 0.5;">🥗</div>

                <h3 class="fw-bold text-dark mb-3">Non hai ancora nessun antipasto!</h3>        </a>        </a>

                <p class="text-muted mb-4">Inizia subito creando il tuo primo antipasto per il menu.</p>

                <a class="btn btn-success btn-lg px-4 py-3 fw-bold"     </div>    </div>

                   href="{{ route('admin.appetizers.create') }}">

                    <i class="fas fa-rocket me-2"></i>Crea il Primo Antipasto        

                </a>

            </div>    {{-- Contatore semplice --}}    {{-- Contatore semplice --}}

        </div>

    </div>    <div class="badge bg-success fs-6 px-3 py-2">    <div class="badge bg-success fs-6 px-3 py-2">

    @else

    {{-- Griglia semplificata degli antipasti --}}        <i class="fas fa-salad me-1"></i>        <i class="fas fa-salad me-1"></i>

    <div class="row justify-content-center">

        <div class="col-12">        Hai {{ $appetizers->total() ?? 0 }} {{ $appetizers->total() == 1 ? 'antipasto' : 'antipasti' }} nel menu        Hai {{ $appetizers->total() ?? 0 }} {{ $appetizers->total() == 1 ? 'antipasto' : 'antipasti' }} nel menu

            <div class="row g-4" aria-live="polite">

                @foreach($appetizers as $a)    </div>

                    <div class="col-12 col-md-6 col-xl-4">

                        <div class="card h-100 border-0 shadow-sm hover-lift" </div>    </div>    </div>

                             style="transition: all 0.3s ease;">

                            @endsection

                            {{-- Immagine antipasto --}}

                            @if($a->image_path)</div></div>

                                <div class="position-relative">

                                    <img src="{{ asset('storage/'.$a->image_path) }}" @section('content')

                                         alt="Foto di {{ $a->name }}" 

                                         class="card-img-top" @endsection@endsection

                                         style="height:220px;object-fit:cover;border-radius: 12px 12px 0 0;">

                                    @if($a->is_vegan)    {{-- Messaggio di guida quando non ci sono antipasti --}}

                                        <span class="position-absolute top-0 start-0 badge bg-success text-white m-2">

                                            🌱 Vegano    @if($appetizers->count() == 0)

                                        </span>

                                    @endif    <div class="row justify-content-center">

                                </div>

                            @else        <div class="col-lg-6">@section('content')@section('content')

                                <div class="card-img-top d-flex align-items-center justify-content-center bg-light" 

                                     style="height:220px;border-radius: 12px 12px 0 0;">            <div class="text-center py-5">

                                    <div class="text-center">

                                        <div style="font-size: 3rem; opacity: 0.5;">🥗</div>                <div class="mb-4" style="font-size: 5rem; opacity: 0.5;">🥗</div>    {{-- Messaggio di guida quando non ci sono antipasti --}}

                                        <small class="text-muted">Nessuna foto</small>

                                    </div>                <h3 class="fw-bold text-dark mb-3">Non hai ancora nessun antipasto!</h3>

                                </div>

                            @endif                <p class="text-muted mb-4">Inizia subito creando il tuo primo antipasto per il menu.</p>    {{-- Messaggio di guida quando non ci sono antipasti --}}    @if($appetizers->count() == 0)



                            {{-- Contenuto carta --}}                <a class="btn btn-success btn-lg px-4 py-3 fw-bold" 

                            <div class="card-body d-flex flex-column p-4">

                                <h4 class="card-title fw-bold text-dark mb-2">{{ $a->name }}</h4>                   href="{{ route('admin.appetizers.create') }}">    @if($appetizers->count() == 0)    <div class="row justify-content-center">

                                

                                {{-- Descrizione breve --}}                    <i class="fas fa-rocket me-2"></i>Crea il Primo Antipasto

                                @if($a->description)

                                    <p class="card-text text-muted mb-3" style="line-height: 1.5;">                </a>    <div class="row justify-content-center">        <div class="col-lg-6">

                                        {{ Str::limit($a->description, 100) }}

                                    </p>            </div>

                                @endif

                                        </div>        <div class="col-lg-6">            <div class="text-center py-5">

                                {{-- Prezzo evidenziato --}}

                                <div class="d-flex justify-content-between align-items-center mb-3">    </div>

                                    <span class="h4 fw-bold text-success mb-0">€{{ number_format($a->price, 2) }}</span>

                                    @if($a->is_vegan)    @else            <div class="text-center py-5">                <div class="mb-4" style="font-size: 5rem; opacity: 0.5;">🥗</div>

                                        <span class="badge bg-success text-white">🌱 Vegano</span>

                                    @endif    {{-- Griglia semplificata degli antipasti --}}

                                </div>

    <div class="row justify-content-center">                <div class="mb-4" style="font-size: 5rem; opacity: 0.5;">🥗</div>                <h3 class="fw-bold text-dark mb-3">Non hai ancora nessun antipasto!</h3>

                                {{-- Bottoni azione semplificati --}}

                                <div class="d-grid gap-2">        <div class="col-12">

                                    <div class="btn-group" role="group">

                                        <a class="btn btn-primary flex-fill"             <div class="row g-4" aria-live="polite">                <h3 class="fw-bold text-dark mb-3">Non hai ancora nessun antipasto!</h3>                <p class="text-muted mb-4">Inizia subito creando il tuo primo antipasto per il menu.</p>

                                           href="{{ route('admin.appetizers.show', $a) }}"

                                           data-bs-toggle="tooltip"                 @foreach($appetizers as $a)

                                           title="Guarda tutti i dettagli di {{ $a->name }}">

                                            <i class="fas fa-eye me-1"></i>Dettagli                    <div class="col-12 col-md-6 col-xl-4">                <p class="text-muted mb-4">Inizia subito creando il tuo primo antipasto per il menu.</p>                <a class="btn btn-success btn-lg px-4 py-3 fw-bold" 

                                        </a>

                                        <a class="btn btn-success flex-fill"                         <div class="card h-100 border-0 shadow-sm hover-lift" 

                                           href="{{ route('admin.appetizers.edit', $a) }}"

                                           data-bs-toggle="tooltip"                              style="transition: all 0.3s ease;">                <a class="btn btn-success btn-lg px-4 py-3 fw-bold"                    href="{{ route('admin.appetizers.create') }}">

                                           title="Modifica {{ $a->name }}">

                                            <i class="fas fa-edit me-1"></i>Modifica                            

                                        </a>

                                    </div>                            {{-- Immagine antipasto --}}                   href="{{ route('admin.appetizers.create') }}">                    <i class="fas fa-rocket me-2"></i>Crea il Primo Antipasto

                                    

                                    {{-- Bottone elimina separato per sicurezza --}}                            @if($a->image_path)

                                    <form method="POST" action="{{ route('admin.appetizers.destroy', $a) }}" 

                                          onsubmit="return confirm('⚠️ Sei sicuro di voler eliminare {{ $a->name }}?\n\nQuesta azione non si può annullare!')"                                <div class="position-relative">                    <i class="fas fa-rocket me-2"></i>Crea il Primo Antipasto                </a>

                                          class="mb-0">

                                        @csrf                                    <img src="{{ asset('storage/'.$a->image_path) }}" 

                                        @method('DELETE')

                                        <button type="submit"                                          alt="Foto di {{ $a->name }}"                 </a>            </div>

                                                class="btn btn-outline-danger btn-sm w-100"

                                                data-bs-toggle="tooltip"                                          class="card-img-top" 

                                                title="Elimina definitivamente {{ $a->name }}">

                                            <i class="fas fa-trash me-1"></i>🗑️ Elimina Antipasto                                         style="height:220px;object-fit:cover;border-radius: 12px 12px 0 0;">            </div>        </div>

                                        </button>

                                    </form>                                    @if($a->is_vegan)

                                </div>

                            </div>                                        <span class="position-absolute top-0 start-0 badge bg-success text-white m-2">        </div>    </div>

                        </div>

                    </div>                                            🌱 Vegano

                @endforeach

            </div>                                        </span>    </div>    @else

        </div>

    </div>                                    @endif



    {{-- Paginazione semplificata --}}                                </div>    @else    {{-- Griglia semplificata degli antipasti --}}

    @if($appetizers->hasPages())

    <div class="row justify-content-center mt-5">                            @else

        <div class="col-auto">

            <div class="card border-0 shadow-sm">                                <div class="card-img-top d-flex align-items-center justify-content-center bg-light"     {{-- Griglia semplificata degli antipasti --}}    <div class="row justify-content-center">

                <div class="card-body text-center">

                    <h6 class="mb-3">📄 Altri antipasti</h6>                                     style="height:220px;border-radius: 12px 12px 0 0;">

                    {{ $appetizers->links() }}

                </div>                                    <div class="text-center">    <div class="row justify-content-center">        <div class="col-12">

            </div>

        </div>                                        <div style="font-size: 3rem; opacity: 0.5;">🥗</div>

    </div>

    @endif                                        <small class="text-muted">Nessuna foto</small>        <div class="col-12">            <div class="row g-4" aria-live="polite">

    @endif

                                    </div>

    {{-- Suggerimento finale --}}

    @if($appetizers->count() > 0)                                </div>            <div class="row g-4" aria-live="polite">                @foreach($appetizers as $a)

    <div class="row justify-content-center mt-5">

        <div class="col-lg-8">                            @endif

            <div class="alert alert-info border-0 text-center py-4" 

                 style="background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);">                @foreach($appetizers as $a)            <div class="col-12 col-lg-6 col-xl-4">

                <div class="mb-2">💡</div>

                <h5 class="fw-bold mb-2">Suggerimento</h5>                            {{-- Contenuto carta --}}

                <p class="mb-3">Hai già {{ $appetizers->total() }} {{ $appetizers->total() == 1 ? 'antipasto' : 'antipasti' }}! 

                   Che ne dici di aggiungere anche delle pizze o bevande?</p>                            <div class="card-body d-flex flex-column p-4">                    <div class="col-12 col-md-6 col-xl-4">                <div class="card h-100 border-0 shadow-sm hover-lift" role="article" aria-label="Scheda antipasto {{ $a->name }}">

                <div class="d-flex justify-content-center gap-2 flex-wrap">

                    <a href="{{ route('admin.pizzas.index') }}" class="btn btn-outline-primary btn-sm">                                <h4 class="card-title fw-bold text-dark mb-2">{{ $a->name }}</h4>

                        🍕 Vai alle Pizze

                    </a>                                                        <div class="card h-100 border-0 shadow-sm hover-lift"                     @if($a->image_path)

                    <a href="{{ route('admin.beverages.index') }}" class="btn btn-outline-primary btn-sm">

                        🥤 Vai alle Bevande                                {{-- Descrizione breve --}}

                    </a>

                </div>                                @if($a->description)                             style="transition: all 0.3s ease;">                        <div class="position-relative">

            </div>

        </div>                                    <p class="card-text text-muted mb-3" style="line-height: 1.5;">

    </div>

    @endif                                        {{ Str::limit($a->description, 100) }}                                                        <img src="{{ asset('storage/'.$a->image_path) }}" 



@endsection                                    </p>

                                @endif                            {{-- Immagine antipasto --}}                                 alt="Immagine antipasto {{ $a->name }}" 

                                

                                {{-- Prezzo evidenziato --}}                            @if($a->image_path)                                 class="card-img-top" 

                                <div class="d-flex justify-content-between align-items-center mb-3">

                                    <span class="h4 fw-bold text-success mb-0">€{{ number_format($a->price, 2) }}</span>                                <div class="position-relative">                                 style="height:200px;object-fit:cover;">

                                    @if($a->is_vegan)

                                        <span class="badge bg-success text-white">🌱 Vegano</span>                                    <img src="{{ asset('storage/'.$a->image_path) }}"                             @if($a->is_vegan)

                                    @endif

                                </div>                                         alt="Foto di {{ $a->name }}"                                 <span class="position-absolute top-0 start-0 badge bg-success text-white m-2">



                                {{-- Bottoni azione semplificati --}}                                         class="card-img-top"                                     <i class="fas fa-leaf me-1"></i>Vegano

                                <div class="d-grid gap-2">

                                    <div class="btn-group" role="group">                                         style="height:220px;object-fit:cover;border-radius: 12px 12px 0 0;">                                </span>

                                        <a class="btn btn-primary flex-fill" 

                                           href="{{ route('admin.appetizers.show', $a) }}"                                    @if($a->is_vegan)                            @endif

                                           data-bs-toggle="tooltip" 

                                           title="Guarda tutti i dettagli di {{ $a->name }}">                                        <span class="position-absolute top-0 start-0 badge bg-success text-white m-2">                        </div>

                                            <i class="fas fa-eye me-1"></i>Dettagli

                                        </a>                                            🌱 Vegano                    @else

                                        <a class="btn btn-success flex-fill" 

                                           href="{{ route('admin.appetizers.edit', $a) }}"                                        </span>                        <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height:200px;">

                                           data-bs-toggle="tooltip" 

                                           title="Modifica {{ $a->name }}">                                    @endif                            <div class="text-center text-muted">

                                            <i class="fas fa-edit me-1"></i>Modifica

                                        </a>                                </div>                                <i class="fas fa-salad fs-1 mb-2 text-success"></i>

                                    </div>

                                                                @else                                <div class="small">Nessuna immagine</div>

                                    {{-- Bottone elimina separato per sicurezza --}}

                                    <form method="POST" action="{{ route('admin.appetizers.destroy', $a) }}"                                 <div class="card-img-top d-flex align-items-center justify-content-center bg-light"                                 @if($a->is_vegan)

                                          onsubmit="return confirm('⚠️ Sei sicuro di voler eliminare {{ $a->name }}?\n\nQuesta azione non si può annullare!')"

                                          class="mb-0">                                     style="height:220px;border-radius: 12px 12px 0 0;">                                    <span class="position-absolute top-0 start-0 badge bg-success text-white m-2">

                                        @csrf

                                        @method('DELETE')                                    <div class="text-center">                                        <i class="fas fa-leaf me-1"></i>Vegano

                                        <button type="submit" 

                                                class="btn btn-outline-danger btn-sm w-100"                                        <div style="font-size: 3rem; opacity: 0.5;">🥗</div>                                    </span>

                                                data-bs-toggle="tooltip" 

                                                title="Elimina definitivamente {{ $a->name }}">                                        <small class="text-muted">Nessuna foto</small>                                @endif

                                            <i class="fas fa-trash me-1"></i>🗑️ Elimina Antipasto

                                        </button>                                    </div>                            </div>

                                    </form>

                                </div>                                </div>                        </div>

                            </div>

                        </div>                            @endif                    @endif

                    </div>

                @endforeach                    

            </div>

        </div>                            {{-- Contenuto carta --}}                    <div class="card-body d-flex flex-column">

    </div>

                            <div class="card-body d-flex flex-column p-4">                        <div class="d-flex justify-content-between align-items-start mb-3">

    {{-- Paginazione semplificata --}}

    @if($appetizers->hasPages())                                <h4 class="card-title fw-bold text-dark mb-2">{{ $a->name }}</h4>                            <a href="{{ route('admin.appetizers.show', $a) }}" 

    <div class="row justify-content-center mt-5">

        <div class="col-auto">                                                               class="h5 mb-0 text-decoration-none fw-bold text-dark hover-primary">

            <div class="card border-0 shadow-sm">

                <div class="card-body text-center">                                {{-- Descrizione breve --}}                                {{ $a->name }}

                    <h6 class="mb-3">📄 Altri antipasti</h6>

                    {{ $appetizers->links() }}                                @if($a->description)                            </a>

                </div>

            </div>                                    <p class="card-text text-muted mb-3" style="line-height: 1.5;">                            <div class="text-end">

        </div>

    </div>                                        {{ Str::limit($a->description, 100) }}                                <div class="h5 mb-0 text-success fw-bold">

    @endif

    @endif                                    </p>                                    €{{ number_format($a->price, 2, ',', '.') }}



    {{-- Suggerimento finale --}}                                @endif                                </div>

    @if($appetizers->count() > 0)

    <div class="row justify-content-center mt-5">                                                            </div>

        <div class="col-lg-8">

            <div class="alert alert-info border-0 text-center py-4"                                 {{-- Prezzo evidenziato --}}                        </div>

                 style="background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);">

                <div class="mb-2">💡</div>                                <div class="d-flex justify-content-between align-items-center mb-3">                        

                <h5 class="fw-bold mb-2">Suggerimento</h5>

                <p class="mb-3">Hai già {{ $appetizers->total() }} {{ $appetizers->total() == 1 ? 'antipasto' : 'antipasti' }}!                                     <span class="h4 fw-bold text-success mb-0">€{{ number_format($a->price, 2) }}</span>                        @if($a->description)

                   Che ne dici di aggiungere anche delle pizze o bevande?</p>

                <div class="d-flex justify-content-center gap-2 flex-wrap">                                    @if($a->is_vegan)                            <div class="mb-3">

                    <a href="{{ route('admin.pizzas.index') }}" class="btn btn-outline-primary btn-sm">

                        🍕 Vai alle Pizze                                        <span class="badge bg-success text-white">🌱 Vegano</span>                                <div class="small text-muted mb-1">

                    </a>

                    <a href="{{ route('admin.beverages.index') }}" class="btn btn-outline-primary btn-sm">                                    @endif                                    <i class="fas fa-align-left me-1"></i>

                        🥤 Vai alle Bevande

                    </a>                                </div>                                    Descrizione:

                </div>

            </div>                                </div>

        </div>

    </div>                                {{-- Bottoni azione semplificati --}}                                <div class="small text-dark">

    @endif

                                <div class="d-grid gap-2">                                    {{ \Illuminate\Support\Str::limit($a->description, 120) }}

@endsection
                                    <div class="btn-group" role="group">                                </div>

                                        <a class="btn btn-primary flex-fill"                             </div>

                                           href="{{ route('admin.appetizers.show', $a) }}"                        @endif

                                           data-bs-toggle="tooltip"                         

                                           title="Guarda tutti i dettagli di {{ $a->name }}">                        @if($a->ingredients && $a->ingredients->isNotEmpty())

                                            <i class="fas fa-eye me-1"></i>Dettagli                            <div class="mb-3">

                                        </a>                                <div class="small text-muted mb-1">

                                        <a class="btn btn-success flex-fill"                                     <i class="fas fa-seedling me-1"></i>

                                           href="{{ route('admin.appetizers.edit', $a) }}"                                    Ingredienti:

                                           data-bs-toggle="tooltip"                                 </div>

                                           title="Modifica {{ $a->name }}">                                <div class="d-flex flex-wrap gap-1">

                                            <i class="fas fa-edit me-1"></i>Modifica                                    @foreach($a->ingredients->take(3) as $ingredient)

                                        </a>                                        <span class="badge bg-light text-dark">{{ $ingredient->name }}</span>

                                    </div>                                    @endforeach

                                                                        @if($a->ingredients->count() > 3)

                                    {{-- Bottone elimina separato per sicurezza --}}                                        <span class="badge bg-secondary">+{{ $a->ingredients->count() - 3 }}</span>

                                    <form method="POST" action="{{ route('admin.appetizers.destroy', $a) }}"                                     @endif

                                          onsubmit="return confirm('⚠️ Sei sicuro di voler eliminare {{ $a->name }}?\n\nQuesta azione non si può annullare!')"                                </div>

                                          class="mb-0">                            </div>

                                        @csrf                        @endif

                                        @method('DELETE')                        

                                        <button type="submit"                         @if(!empty($a->notes))

                                                class="btn btn-outline-danger btn-sm w-100"                            <div class="alert alert-info py-2 px-3 mb-3 small border-0" role="note">

                                                data-bs-toggle="tooltip"                                 <i class="fas fa-info-circle me-1"></i>

                                                title="Elimina definitivamente {{ $a->name }}">                                <strong>Nota:</strong> {{ \Illuminate\Support\Str::limit($a->notes, 80) }}

                                            <i class="fas fa-trash me-1"></i>🗑️ Elimina Antipasto                            </div>

                                        </button>                        @endif

                                    </form>                        

                                </div>                        <div class="d-flex gap-2 mt-auto">

                            </div>                            <a class="btn btn-success btn-sm flex-fill" 

                        </div>                               href="{{ route('admin.appetizers.edit', $a) }}" 

                    </div>                               aria-label="Modifica antipasto {{ $a->name }}">

                @endforeach                                <i class="fas fa-edit me-1"></i>

            </div>                                Modifica

        </div>                            </a>

    </div>                            <form class="flex-fill" method="POST" action="{{ route('admin.appetizers.destroy', $a) }}" 

                                  data-confirm="Sicuro di voler eliminare l'antipasto '{{ $a->name }}'?">

    {{-- Paginazione semplificata --}}                                @csrf @method('DELETE')

    @if($appetizers->hasPages())                                <button class="btn btn-outline-danger btn-sm w-100" 

    <div class="row justify-content-center mt-5">                                        type="submit" 

        <div class="col-auto">                                        aria-label="Elimina antipasto {{ $a->name }}">

            <div class="card border-0 shadow-sm">                                    <i class="fas fa-trash me-1"></i>

                <div class="card-body text-center">                                    Elimina

                    <h6 class="mb-3">📄 Altri antipasti</h6>                                </button>

                    {{ $appetizers->links() }}                            </form>

                </div>                        </div>

            </div>                    </div>

        </div>                </div>

    </div>            </div>

    @endif        @empty

    @endif            <div class="col-12">

                <div class="card border-0 bg-light">

    {{-- Suggerimento finale --}}                    <div class="card-body text-center py-5">

    @if($appetizers->count() > 0)                        <div class="display-1 text-muted mb-3">🥗</div>

    <div class="row justify-content-center mt-5">                        <h4 class="text-muted mb-3">Nessun antipasto trovato</h4>

        <div class="col-lg-8">                        <p class="text-muted mb-4">Inizia ad aggiungere antipasti per arricchire il tuo menu</p>

            <div class="alert alert-info border-0 text-center py-4"                         <a href="{{ route('admin.appetizers.create') }}" class="btn btn-success">

                 style="background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);">                            <i class="fas fa-plus me-2"></i>

                <div class="mb-2">💡</div>                            Crea il primo antipasto

                <h5 class="fw-bold mb-2">Suggerimento</h5>                        </a>

                <p class="mb-3">Hai già {{ $appetizers->total() }} {{ $appetizers->total() == 1 ? 'antipasto' : 'antipasti' }}!                     </div>

                   Che ne dici di aggiungere anche delle pizze o bevande?</p>                </div>

                <div class="d-flex justify-content-center gap-2 flex-wrap">            </div>

                    <a href="{{ route('admin.pizzas.index') }}" class="btn btn-outline-primary btn-sm">        @endforelse

                        🍕 Vai alle Pizze    </div>

                    </a>

                    <a href="{{ route('admin.beverages.index') }}" class="btn btn-outline-primary btn-sm">    {{-- Paginazione moderna --}}

                        🥤 Vai alle Bevande    @if($appetizers->hasPages())

                    </a>        <div class="d-flex justify-content-center mt-5">

                </div>            <nav aria-label="Navigazione antipasti">

            </div>                {{ $appetizers->links('pagination.custom') }}

        </div>            </nav>

    </div>        </div>

    @endif    @endif

@endsection

@endsection