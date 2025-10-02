@extends('layouts.app-modern')

@section('title', 'Dashboard')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Gestisci il tuo menu</p>
    </div>
    <div>
        <span class="badge bg-success fs-6 px-3 py-2">
            <i class="fas fa-check-circle me-1"></i>
            Gestione attiva
        </span>
    </div>
</div>
@endsection

@section('content')

    {{-- Azioni rapide centrali --}}
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt text-warning me-2"></i>
                        Azioni Rapide
                    </h5>
                    <p class="card-text small text-muted mb-0">Crea rapidamente nuovi contenuti per il tuo menu</p>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('admin.pizzas.create') }}" class="btn btn-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4 btn-action-primary">
                                <i class="fas fa-plus fs-2 mb-2"></i>
                                <span class="fw-semibold">Nuova Pizza</span>
                                <small class="opacity-75">Aggiungi al menu</small>
                            </a>
                        </div>
                        
                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('admin.appetizers.create') }}" class="btn btn-success w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4 btn-action-success">
                                <i class="fas fa-plus fs-2 mb-2"></i>
                                <span class="fw-semibold">Nuovo Antipasto</span>
                                <small class="opacity-75">Aggiungi al menu</small>
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('admin.beverages.create') }}" class="btn btn-info w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4 btn-action-info">
                                <i class="fas fa-plus fs-2 mb-2"></i>
                                <span class="fw-semibold">Nuova Bevanda</span>
                                <small class="opacity-75">Aggiungi alla carta</small>
                            </a>
                        </div>

                        <div class="col-lg-3 col-md-6">
                            <a href="{{ route('admin.desserts.create') }}" class="btn btn-warning w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4 btn-action-warning">
                                <i class="fas fa-plus fs-2 mb-2"></i>
                                <span class="fw-semibold">Nuovo Dessert</span>
                                <small class="opacity-75">Aggiungi alla carta</small>
                            </a>
                        </div>
                    </div>

                    {{-- Azioni secondarie --}}
                    <div class="row g-3 mt-3">
                        <div class="col-md-6">
                            <a href="{{ route('admin.ingredients.create') }}" class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-center py-3 btn-action-outline">
                                <i class="fas fa-seedling fs-4 me-2"></i>
                                <div class="text-start">
                                    <div class="fw-semibold">Nuovo Ingrediente</div>
                                    <small class="text-muted">Per sistema allergeni</small>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-md-6">
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-secondary w-100 d-flex align-items-center justify-content-center py-3 btn-action-outline">
                                <i class="fas fa-tags fs-4 me-2"></i>
                                <div class="text-start">
                                    <div class="fw-semibold">Nuova Categoria</div>
                                    <small class="text-muted">Organizza il menu</small>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Panoramica contenuti --}}
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-utensils text-primary me-2"></i>
                        Gestione Menu
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-sm-6">
                            <a href="{{ route('admin.pizzas.index') }}" class="card text-decoration-none border-2 h-100" style="border-color: #FF6B35 !important;">
                                <div class="card-body text-center">
                                    <div class="display-4 mb-2">🍕</div>
                                    <h6 class="card-title text-dark">Pizze</h6>
                                    <p class="card-text text-muted">Gestisci il tuo menu pizze</p>
                                    <div class="badge bg-light text-dark">{{ $countPizzas ?? 0 }} elementi</div>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-sm-6">
                            <a href="{{ route('admin.appetizers.index') }}" class="card text-decoration-none border-2 h-100" style="border-color: #10B981 !important;">
                                <div class="card-body text-center">
                                    <div class="display-4 mb-2">🥗</div>
                                    <h6 class="card-title text-dark">Antipasti</h6>
                                    <p class="card-text text-muted">Gestisci gli antipasti</p>
                                    <div class="badge bg-light text-dark">{{ $countAppetizers ?? 0 }} elementi</div>
                                </div>
                            </a>
                        </div>

                        <div class="col-sm-6">
                            <a href="{{ route('admin.beverages.index') }}" class="card text-decoration-none border-2 h-100" style="border-color: #3B82F6 !important;">
                                <div class="card-body text-center">
                                    <div class="display-4 mb-2">🥤</div>
                                    <h6 class="card-title text-dark">Bevande</h6>
                                    <p class="card-text text-muted">Gestisci le bevande</p>
                                    <div class="badge bg-light text-dark">{{ $countBeverages ?? 0 }} elementi</div>
                                </div>
                            </a>
                        </div>

                        <div class="col-sm-6">
                            <a href="{{ route('admin.desserts.index') }}" class="card text-decoration-none border-2 h-100" style="border-color: #F59E0B !important;">
                                <div class="card-body text-center">
                                    <div class="display-4 mb-2">🍰</div>
                                    <h6 class="card-title text-dark">Dessert</h6>
                                    <p class="card-text text-muted">Gestisci i dessert</p>
                                    <div class="badge bg-light text-dark">{{ $countDesserts ?? 0 }} elementi</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-clock text-info me-2"></i>
                        Attività Recenti
                    </h5>
                </div>
                <div class="card-body">
                    @php
                        $recentItems = collect([
                            $latestPizza ? ['item' => $latestPizza, 'type' => 'pizza', 'icon' => '🍕', 'color' => 'primary'] : null,
                            $latestAppetizer ? ['item' => $latestAppetizer, 'type' => 'antipasto', 'icon' => '🥗', 'color' => 'success'] : null,
                            $latestBeverage ? ['item' => $latestBeverage, 'type' => 'bevanda', 'icon' => '🥤', 'color' => 'info'] : null,
                            $latestDessert ? ['item' => $latestDessert, 'type' => 'dessert', 'icon' => '🍰', 'color' => 'warning'] : null
                        ])->filter()->sortByDesc(function($data) {
                            return $data['item']->created_at;
                        })->take(3);
                    @endphp

                    @if($recentItems->count() > 0)
                        <div class="d-flex flex-column gap-3">
                            @foreach($recentItems as $data)
                            <div class="d-flex align-items-center p-2 rounded border">
                                <div class="fs-4 me-3">{{ $data['icon'] }}</div>
                                <div class="flex-grow-1">
                                    <div class="fw-semibold text-dark">{{ $data['item']->name }}</div>
                                    <div class="small text-muted d-flex justify-content-between">
                                        <span>{{ ucfirst($data['type']) }} • {{ $data['item']->created_at->format('d M Y') }}</span>
                                        <span class="text-{{ $data['color'] }} fw-bold">€{{ number_format($data['item']->price, 2) }}</span>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <div class="border-top pt-3 mt-3">
                            <div class="small text-muted text-center">
                                <strong>{{ ($countPizzas ?? 0) + ($countAppetizers ?? 0) + ($countBeverages ?? 0) + ($countDesserts ?? 0) }}</strong> elementi totali nel menu
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <i class="fas fa-plus-circle fs-1 mb-2 opacity-50"></i>
                            <div>Nessun elemento ancora creato</div>
                            <div class="small">Inizia aggiungendo i tuoi primi piatti!</div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
