@extends('layouts.app-modern')@extends('layouts.app-modern')@extends('layouts.app-modern')



@section('title', 'Le Tue Bevande')



@section('header')@section('title', 'Le Tue Bevande')@section('title', 'Le Tue Bevande')

<div class="text-center py-4">

    <div class="mb-3">

        <div style="font-size: 3rem;">🥤</div>

    </div>@section('header')@section('header')

    <h1 class="display-6 fw-bold text-dark mb-2">Le Tue Bevande</h1>

    <p class="lead text-muted mb-4">Tutte le bevande e bibite del tuo menu</p><div class="text-center py-4"><div class="text-center py-4">

    

    {{-- Azione principale sempre visibile --}}    <div class="mb-3">    <div class="mb-3">

    <div class="d-flex justify-content-center gap-3 mb-3">

        <a class="btn btn-success btn-lg px-4 py-3 fw-bold"         <div style="font-size: 3rem;">🥤</div>        <div style="font-size: 3rem;">🥤</div>

           href="{{ route('admin.beverages.create') }}"

           data-bs-toggle="tooltip"     </div>    </div>

           title="Clicca qui per aggiungere una nuova bevanda al menu">

            <i class="fas fa-plus me-2"></i>🥤 Aggiungi Nuova Bevanda    <h1 class="display-6 fw-bold text-dark mb-2">Le Tue Bevande</h1>    <h1 class="display-6 fw-bold text-dark mb-2">Le Tue Bevande</h1>

        </a>

    </div>    <p class="lead text-muted mb-4">Tutte le bevande e bibite del tuo menu</p>    <p class="lead text-muted mb-4">Tutte le bevande e bibite del tuo menu</p>

    

    {{-- Contatore semplice --}}        

    <div class="badge bg-info fs-6 px-3 py-2">

        <i class="fas fa-glass-water me-1"></i>    {{-- Azione principale sempre visibile --}}    {{-- Azione principale sempre visibile --}}

        Hai {{ $beverages->total() ?? 0 }} {{ $beverages->total() == 1 ? 'bevanda' : 'bevande' }} nel menu

    </div>    <div class="d-flex justify-content-center gap-3 mb-3">    <div class="d-flex justify-content-center gap-3 mb-3">

</div>

@endsection        <a class="btn btn-success btn-lg px-4 py-3 fw-bold"         <a class="btn btn-success btn-lg px-4 py-3 fw-bold" 



@section('content')           href="{{ route('admin.beverages.create') }}"           href="{{ route('admin.beverages.create') }}"



    {{-- Messaggio di guida quando non ci sono bevande --}}           data-bs-toggle="tooltip"            data-bs-toggle="tooltip" 

    @if($beverages->count() == 0)

    <div class="row justify-content-center">           title="Clicca qui per aggiungere una nuova bevanda al menu">           title="Clicca qui per aggiungere una nuova bevanda al menu">

        <div class="col-lg-6">

            <div class="text-center py-5">            <i class="fas fa-plus me-2"></i>🥤 Aggiungi Nuova Bevanda            <i class="fas fa-plus me-2"></i>🥤 Aggiungi Nuova Bevanda

                <div class="mb-4" style="font-size: 5rem; opacity: 0.5;">🥤</div>

                <h3 class="fw-bold text-dark mb-3">Non hai ancora nessuna bevanda!</h3>        </a>        </a>

                <p class="text-muted mb-4">Inizia subito aggiungendo le prime bevande per il menu.</p>

                <a class="btn btn-success btn-lg px-4 py-3 fw-bold"     </div>    </div>

                   href="{{ route('admin.beverages.create') }}">

                    <i class="fas fa-rocket me-2"></i>Crea la Prima Bevanda        

                </a>

            </div>    {{-- Contatore semplice --}}    {{-- Contatore semplice --}}

        </div>

    </div>    <div class="badge bg-info fs-6 px-3 py-2">    <div class="badge bg-info fs-6 px-3 py-2">

    @else

    {{-- Griglia semplificata delle bevande --}}        <i class="fas fa-glass-water me-1"></i>        <i class="fas fa-glass-water me-1"></i>

    <div class="row justify-content-center">

        <div class="col-12">        Hai {{ $beverages->total() ?? 0 }} {{ $beverages->total() == 1 ? 'bevanda' : 'bevande' }} nel menu        Hai {{ $beverages->total() ?? 0 }} {{ $beverages->total() == 1 ? 'bevanda' : 'bevande' }} nel menu

            <div class="row g-4" aria-live="polite">

                @foreach($beverages as $b)    </div>    </div>

                    <div class="col-12 col-md-6 col-xl-4">

                        <div class="card h-100 border-0 shadow-sm hover-lift" </div></div>

                             style="transition: all 0.3s ease;">

                            @endsection@endsection

                            {{-- Immagine bevanda --}}

                            @if($b->image_path)

                                <div class="position-relative">

                                    <img src="{{ asset('storage/'.$b->image_path) }}" @section('content')@section('content')

                                         alt="Foto di {{ $b->name }}" 

                                         class="card-img-top"     {{-- Barra filtri moderna --}}

                                         style="height:220px;object-fit:cover;border-radius: 12px 12px 0 0;">

                                    @if($b->is_alcoholic)    {{-- Messaggio di guida quando non ci sono bevande --}}    <div class="card border-0 shadow-sm mb-4">

                                        <span class="position-absolute top-0 end-0 badge bg-warning text-dark m-2">

                                            🍺 Alcolica    @if($beverages->count() == 0)        <div class="card-body">

                                        </span>

                                    @endif    <div class="row justify-content-center">            <x-filter-toolbar

                                </div>

                            @else        <div class="col-lg-6">                search

                                <div class="card-img-top d-flex align-items-center justify-content-center bg-light" 

                                     style="height:220px;border-radius: 12px 12px 0 0;">            <div class="text-center py-5">                searchPlaceholder="Cerca bevande per nome o descrizione..."

                                    <div class="text-center">

                                        <div style="font-size: 3rem; opacity: 0.5;">🥤</div>                <div class="mb-4" style="font-size: 5rem; opacity: 0.5;">🥤</div>                :sort-options="['' => 'Più recenti', 'name_asc' => 'Nome A→Z', 'name_desc' => 'Nome Z→A', 'price_asc' => 'Prezzo ↑', 'price_desc' => 'Prezzo ↓']"

                                        <small class="text-muted">Nessuna foto</small>

                                    </div>                <h3 class="fw-bold text-dark mb-3">Non hai ancora nessuna bevanda!</h3>                :reset-url="route('admin.beverages.index')"

                                </div>

                            @endif                <p class="text-muted mb-4">Inizia subito aggiungendo le prime bevande per il menu.</p>            />



                            {{-- Contenuto carta --}}                <a class="btn btn-success btn-lg px-4 py-3 fw-bold"         </div>

                            <div class="card-body d-flex flex-column p-4">

                                <h4 class="card-title fw-bold text-dark mb-2">{{ $b->name }}</h4>                   href="{{ route('admin.beverages.create') }}">    </div>

                                

                                {{-- Descrizione breve --}}                    <i class="fas fa-rocket me-2"></i>Crea la Prima Bevanda

                                @if($b->description)

                                    <p class="card-text text-muted mb-3" style="line-height: 1.5;">                </a>    {{-- Griglia bevande moderna --}}

                                        {{ Str::limit($b->description, 100) }}

                                    </p>            </div>    <div class="row g-4" aria-live="polite">

                                @endif

                                        </div>        @forelse($beverages as $b)

                                {{-- Prezzo evidenziato --}}

                                <div class="d-flex justify-content-between align-items-center mb-3">    </div>            <div class="col-12 col-lg-6 col-xl-4">

                                    <span class="h4 fw-bold text-info mb-0">€{{ number_format($b->price, 2) }}</span>

                                    @if($b->is_alcoholic)    @else                <div class="card h-100 border-0 shadow-sm hover-lift" role="article" aria-label="Scheda bevanda {{ $b->name }}">

                                        <span class="badge bg-warning text-dark">🍺 Alcolica</span>

                                    @else    {{-- Griglia semplificata delle bevande --}}                    @if($b->image_path)

                                        <span class="badge bg-success text-white">✅ Analcolica</span>

                                    @endif    <div class="row justify-content-center">                        <div class="position-relative">

                                </div>

        <div class="col-12">                            <img src="{{ asset('storage/'.$b->image_path) }}" 

                                {{-- Bottoni azione semplificati --}}

                                <div class="d-grid gap-2">            <div class="row g-4" aria-live="polite">                                 alt="Immagine bevanda {{ $b->name }}" 

                                    <div class="btn-group" role="group">

                                        <a class="btn btn-primary flex-fill"                 @foreach($beverages as $b)                                 class="card-img-top" 

                                           href="{{ route('admin.beverages.show', $b) }}"

                                           data-bs-toggle="tooltip"                     <div class="col-12 col-md-6 col-xl-4">                                 style="height:200px;object-fit:cover;">

                                           title="Guarda tutti i dettagli di {{ $b->name }}">

                                            <i class="fas fa-eye me-1"></i>Dettagli                        <div class="card h-100 border-0 shadow-sm hover-lift"                         </div>

                                        </a>

                                        <a class="btn btn-success flex-fill"                              style="transition: all 0.3s ease;">                    @else

                                           href="{{ route('admin.beverages.edit', $b) }}"

                                           data-bs-toggle="tooltip"                                                     <div class="card-img-top d-flex align-items-center justify-content-center bg-light" style="height:200px;">

                                           title="Modifica {{ $b->name }}">

                                            <i class="fas fa-edit me-1"></i>Modifica                            {{-- Immagine bevanda --}}                            <div class="text-center text-muted">

                                        </a>

                                    </div>                            @if($b->image_path)                                <i class="fas fa-glass-water fs-1 mb-2 text-info"></i>

                                    

                                    {{-- Bottone elimina separato per sicurezza --}}                                <div class="position-relative">                                <div class="small">Nessuna immagine</div>

                                    <form method="POST" action="{{ route('admin.beverages.destroy', $b) }}" 

                                          onsubmit="return confirm('⚠️ Sei sicuro di voler eliminare {{ $b->name }}?\n\nQuesta azione non si può annullare!')"                                    <img src="{{ asset('storage/'.$b->image_path) }}"                             </div>

                                          class="mb-0">

                                        @csrf                                         alt="Foto di {{ $b->name }}"                         </div>

                                        @method('DELETE')

                                        <button type="submit"                                          class="card-img-top"                     @endif

                                                class="btn btn-outline-danger btn-sm w-100"

                                                data-bs-toggle="tooltip"                                          style="height:220px;object-fit:cover;border-radius: 12px 12px 0 0;">                    

                                                title="Elimina definitivamente {{ $b->name }}">

                                            <i class="fas fa-trash me-1"></i>🗑️ Elimina Bevanda                                    @if($b->is_alcoholic)                    <div class="card-body d-flex flex-column">

                                        </button>

                                    </form>                                        <span class="position-absolute top-0 end-0 badge bg-warning text-dark m-2">                        <div class="d-flex justify-content-between align-items-start mb-3">

                                </div>

                            </div>                                            🍺 Alcolica                            <a href="{{ route('admin.beverages.show', $b) }}" 

                        </div>

                    </div>                                        </span>                               class="h5 mb-0 text-decoration-none fw-bold text-dark hover-primary">

                @endforeach

            </div>                                    @endif                                {{ $b->name }}

        </div>

    </div>                                </div>                            </a>



    {{-- Paginazione semplificata --}}                            @else                            <div class="text-end">

    @if($beverages->hasPages())

    <div class="row justify-content-center mt-5">                                <div class="card-img-top d-flex align-items-center justify-content-center bg-light"                                 <div class="h5 mb-0 text-info fw-bold">

        <div class="col-auto">

            <div class="card border-0 shadow-sm">                                     style="height:220px;border-radius: 12px 12px 0 0;">                                    €{{ number_format($b->price, 2, ',', '.') }}

                <div class="card-body text-center">

                    <h6 class="mb-3">📄 Altre bevande</h6>                                    <div class="text-center">                                </div>

                    {{ $beverages->links() }}

                </div>                                        <div style="font-size: 3rem; opacity: 0.5;">🥤</div>                                @if(isset($b->category))

            </div>

        </div>                                        <small class="text-muted">Nessuna foto</small>                                    <span class="badge bg-light text-muted small">{{ $b->category }}</span>

    </div>

    @endif                                    </div>                                @endif

    @endif

                                </div>                            </div>

    {{-- Suggerimento finale --}}

    @if($beverages->count() > 0)                            @endif                        </div>

    <div class="row justify-content-center mt-5">

        <div class="col-lg-8">                        

            <div class="alert alert-info border-0 text-center py-4" 

                 style="background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);">                            {{-- Contenuto carta --}}                        @if($b->description)

                <div class="mb-2">💡</div>

                <h5 class="fw-bold mb-2">Suggerimento</h5>                            <div class="card-body d-flex flex-column p-4">                            <div class="mb-3">

                <p class="mb-3">Hai già {{ $beverages->total() }} {{ $beverages->total() == 1 ? 'bevanda' : 'bevande' }}! 

                   Che ne dici di aggiungere anche delle pizze o antipasti?</p>                                <h4 class="card-title fw-bold text-dark mb-2">{{ $b->name }}</h4>                                <div class="small text-muted mb-1">

                <div class="d-flex justify-content-center gap-2 flex-wrap">

                    <a href="{{ route('admin.pizzas.index') }}" class="btn btn-outline-primary btn-sm">                                                                    <i class="fas fa-align-left me-1"></i>

                        🍕 Vai alle Pizze

                    </a>                                {{-- Descrizione breve --}}                                    Descrizione:

                    <a href="{{ route('admin.appetizers.index') }}" class="btn btn-outline-primary btn-sm">

                        🥗 Vai agli Antipasti                                @if($b->description)                                </div>

                    </a>

                </div>                                    <p class="card-text text-muted mb-3" style="line-height: 1.5;">                                <div class="small text-dark">

            </div>

        </div>                                        {{ Str::limit($b->description, 100) }}                                    {{ \Illuminate\Support\Str::limit($b->description, 120) }}

    </div>

    @endif                                    </p>                                </div>



@endsection                                @endif                            </div>

                                                        @endif

                                {{-- Prezzo evidenziato --}}                        

                                <div class="d-flex justify-content-between align-items-center mb-3">                        @if(isset($b->alcohol_content) && $b->alcohol_content > 0)

                                    <span class="h4 fw-bold text-info mb-0">€{{ number_format($b->price, 2) }}</span>                            <div class="mb-3">

                                    @if($b->is_alcoholic)                                <span class="badge bg-warning text-dark">

                                        <span class="badge bg-warning text-dark">🍺 Alcolica</span>                                    <i class="fas fa-wine-bottle me-1"></i>

                                    @else                                    {{ $b->alcohol_content }}% Alc.

                                        <span class="badge bg-success text-white">✅ Analcolica</span>                                </span>

                                    @endif                            </div>

                                </div>                        @elseif(isset($b->is_alcoholic) && !$b->is_alcoholic)

                            <div class="mb-3">

                                {{-- Bottoni azione semplificati --}}                                <span class="badge bg-success">

                                <div class="d-grid gap-2">                                    <i class="fas fa-leaf me-1"></i>

                                    <div class="btn-group" role="group">                                    Analcolica

                                        <a class="btn btn-primary flex-fill"                                 </span>

                                           href="{{ route('admin.beverages.show', $b) }}"                            </div>

                                           data-bs-toggle="tooltip"                         @endif

                                           title="Guarda tutti i dettagli di {{ $b->name }}">                        

                                            <i class="fas fa-eye me-1"></i>Dettagli                        @if(!empty($b->notes))

                                        </a>                            <div class="alert alert-info py-2 px-3 mb-3 small border-0" role="note">

                                        <a class="btn btn-success flex-fill"                                 <i class="fas fa-info-circle me-1"></i>

                                           href="{{ route('admin.beverages.edit', $b) }}"                                <strong>Nota:</strong> {{ \Illuminate\Support\Str::limit($b->notes, 80) }}

                                           data-bs-toggle="tooltip"                             </div>

                                           title="Modifica {{ $b->name }}">                        @endif

                                            <i class="fas fa-edit me-1"></i>Modifica                        

                                        </a>                        <div class="d-flex gap-2 mt-auto">

                                    </div>                            <a class="btn btn-success btn-sm flex-fill" 

                                                                   href="{{ route('admin.beverages.edit', $b) }}" 

                                    {{-- Bottone elimina separato per sicurezza --}}                               aria-label="Modifica bevanda {{ $b->name }}">

                                    <form method="POST" action="{{ route('admin.beverages.destroy', $b) }}"                                 <i class="fas fa-edit me-1"></i>

                                          onsubmit="return confirm('⚠️ Sei sicuro di voler eliminare {{ $b->name }}?\n\nQuesta azione non si può annullare!')"                                Modifica

                                          class="mb-0">                            </a>

                                        @csrf                            <form class="flex-fill" method="POST" action="{{ route('admin.beverages.destroy', $b) }}" 

                                        @method('DELETE')                                  data-confirm="Sicuro di voler eliminare la bevanda '{{ $b->name }}'?">

                                        <button type="submit"                                 @csrf @method('DELETE')

                                                class="btn btn-outline-danger btn-sm w-100"                                <button class="btn btn-outline-danger btn-sm w-100" 

                                                data-bs-toggle="tooltip"                                         type="submit" 

                                                title="Elimina definitivamente {{ $b->name }}">                                        aria-label="Elimina bevanda {{ $b->name }}">

                                            <i class="fas fa-trash me-1"></i>🗑️ Elimina Bevanda                                    <i class="fas fa-trash me-1"></i>

                                        </button>                                    Elimina

                                    </form>                                </button>

                                </div>                            </form>

                            </div>                        </div>

                        </div>                    </div>

                    </div>                </div>

                @endforeach            </div>

            </div>        @empty

        </div>            <div class="col-12">

    </div>                <div class="card border-0 bg-light">

                    <div class="card-body text-center py-5">

    {{-- Paginazione semplificata --}}                        <div class="display-1 text-muted mb-3">🥤</div>

    @if($beverages->hasPages())                        <h4 class="text-muted mb-3">Nessuna bevanda trovata</h4>

    <div class="row justify-content-center mt-5">                        <p class="text-muted mb-4">Inizia ad aggiungere bevande per completare la tua carta</p>

        <div class="col-auto">                        <a href="{{ route('admin.beverages.create') }}" class="btn btn-info">

            <div class="card border-0 shadow-sm">                            <i class="fas fa-plus me-2"></i>

                <div class="card-body text-center">                            Crea la prima bevanda

                    <h6 class="mb-3">📄 Altre bevande</h6>                        </a>

                    {{ $beverages->links() }}                    </div>

                </div>                </div>

            </div>            </div>

        </div>        @endforelse

    </div>    </div>

    @endif

    @endif    {{-- Paginazione moderna --}}

    @if($beverages->hasPages())

    {{-- Suggerimento finale --}}        <div class="d-flex justify-content-center mt-5">

    @if($beverages->count() > 0)            <nav aria-label="Navigazione bevande">

    <div class="row justify-content-center mt-5">                {{ $beverages->links('pagination.custom') }}

        <div class="col-lg-8">            </nav>

            <div class="alert alert-info border-0 text-center py-4"         </div>

                 style="background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);">    @endif

                <div class="mb-2">💡</div>@endsection

                <h5 class="fw-bold mb-2">Suggerimento</h5>
                <p class="mb-3">Hai già {{ $beverages->total() }} {{ $beverages->total() == 1 ? 'bevanda' : 'bevande' }}! 
                   Che ne dici di aggiungere anche delle pizze o antipasti?</p>
                <div class="d-flex justify-content-center gap-2 flex-wrap">
                    <a href="{{ route('admin.pizzas.index') }}" class="btn btn-outline-primary btn-sm">
                        🍕 Vai alle Pizze
                    </a>
                    <a href="{{ route('admin.appetizers.index') }}" class="btn btn-outline-primary btn-sm">
                        🥗 Vai agli Antipasti
                    </a>
                </div>
            </div>
        </div>
    </div>
    @endif

@endsection