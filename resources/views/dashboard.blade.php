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

    {{-- Layout ottimizzato: Azioni Rapide + Gestione Menu affiancate --}}
    <div class="row g-4 mb-4">
        {{-- Azioni Rapide (ridotte) --}}
        <div class="col-lg-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt text-warning me-2"></i>
                        Azioni Rapide
                    </h5>
                    <p class="card-text small text-muted mb-0">Crea rapidamente nuovi contenuti</p>
                </div>
                <div class="card-body">
                    {{-- Azioni principali compatte --}}
                    <div class="row g-2">
                        <div class="col-6">
                            <a href="{{ route('admin.pizzas.create') }}" class="btn btn-primary w-100 d-flex flex-column align-items-center justify-content-center py-3 btn-action-primary">
                                <i class="fas fa-plus fs-4 mb-1"></i>
                                <span class="fw-semibold small">Nuova Pizza</span>
                            </a>
                        </div>
                        
                        <div class="col-6">
                            <a href="{{ route('admin.appetizers.create') }}" class="btn btn-success w-100 d-flex flex-column align-items-center justify-content-center py-3 btn-action-success">
                                <i class="fas fa-plus fs-4 mb-1"></i>
                                <span class="fw-semibold small">Antipasto</span>
                            </a>
                        </div>

                        <div class="col-6">
                            <a href="{{ route('admin.beverages.create') }}" class="btn btn-info w-100 d-flex flex-column align-items-center justify-content-center py-3 btn-action-info">
                                <i class="fas fa-plus fs-4 mb-1"></i>
                                <span class="fw-semibold small">Bevanda</span>
                            </a>
                        </div>

                        <div class="col-6">
                            <a href="{{ route('admin.desserts.create') }}" class="btn btn-warning w-100 d-flex flex-column align-items-center justify-content-center py-3 btn-action-warning">
                                <i class="fas fa-plus fs-4 mb-1"></i>
                                <span class="fw-semibold small">Dessert</span>
                            </a>
                        </div>
                    </div>

                    {{-- Azioni secondarie ridotte --}}
                    <div class="row g-2 mt-2">
                        <div class="col-6">
                            <a href="{{ route('admin.ingredients.create') }}" class="btn btn-outline-secondary btn-sm w-100 d-flex align-items-center justify-content-center py-2">
                                <i class="fas fa-seedling me-1"></i>
                                <span class="small">Ingrediente</span>
                            </a>
                        </div>
                        
                        <div class="col-6">
                            <a href="{{ route('admin.categories.create') }}" class="btn btn-outline-secondary btn-sm w-100 d-flex align-items-center justify-content-center py-2">
                                <i class="fas fa-tags me-1"></i>
                                <span class="small">Categoria</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Gestione Menu compatta --}}
        <div class="col-lg-6">
            <div class="card h-100 border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-utensils text-primary me-2"></i>
                        Gestione Menu
                    </h5>
                    <p class="card-text small text-muted mb-0">Crea rapidamente nuovi contenuti</p>
                </div>
                <div class="card-body">
                    <div class="row g-2">
                        <div class="col-6">
                            <a href="{{ route('admin.pizzas.index') }}" class="card text-decoration-none border-2 h-100" style="border-color: #FF6B35 !important;">
                                <div class="card-body text-center py-3">
                                    <div class="fs-2 mb-1">🍕</div>
                                    <h6 class="card-title text-dark mb-1">Pizze</h6>
                                    <div class="badge bg-light text-dark">{{ $countPizzas ?? 0 }}</div>
                                </div>
                            </a>
                        </div>
                        
                        <div class="col-6">
                            <a href="{{ route('admin.appetizers.index') }}" class="card text-decoration-none border-2 h-100" style="border-color: #10B981 !important;">
                                <div class="card-body text-center py-3">
                                    <div class="fs-2 mb-1">🥗</div>
                                    <h6 class="card-title text-dark mb-1">Antipasti</h6>
                                    <div class="badge bg-light text-dark">{{ $countAppetizers ?? 0 }}</div>
                                </div>
                            </a>
                        </div>

                        <div class="col-6">
                            <a href="{{ route('admin.beverages.index') }}" class="card text-decoration-none border-2 h-100" style="border-color: #3B82F6 !important;">
                                <div class="card-body text-center py-3">
                                    <div class="fs-2 mb-1">🥤</div>
                                    <h6 class="card-title text-dark mb-1">Bevande</h6>
                                    <div class="badge bg-light text-dark">{{ $countBeverages ?? 0 }}</div>
                                </div>
                            </a>
                        </div>

                        <div class="col-6">
                            <a href="{{ route('admin.desserts.index') }}" class="card text-decoration-none border-2 h-100" style="border-color: #F59E0B !important;">
                                <div class="card-body text-center py-3">
                                    <div class="fs-2 mb-1">🍰</div>
                                    <h6 class="card-title text-dark mb-1">Dessert</h6>
                                    <div class="badge bg-light text-dark">{{ $countDesserts ?? 0 }}</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Attività Recenti compatte --}}
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom py-2">
                    <div class="d-flex justify-content-between align-items-center">
                        <h6 class="card-title mb-0">
                            <i class="fas fa-history text-info me-2"></i>
                            Ultimi Elementi Creati
                        </h6>
                        <span class="badge bg-info text-white small">
                            {{ ($countPizzas ?? 0) + ($countAppetizers ?? 0) + ($countBeverages ?? 0) + ($countDesserts ?? 0) }} totali
                        </span>
                    </div>
                </div>
                <div class="card-body py-3">
                    <div class="row g-2">
                        {{-- Ultimo Antipasto --}}
                        <div class="col-md-4">
                            @if($latestAppetizer)
                                <div class="border rounded p-2 bg-light d-flex align-items-center">
                                    <div class="fs-4 me-2">🥗</div>
                                    <div class="flex-grow-1 min-w-0">
                                        <div class="fw-semibold small text-truncate">{{ $latestAppetizer->name }}</div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">{{ $latestAppetizer->created_at->format('d/m') }}</small>
                                            <span class="text-success fw-bold small">€{{ number_format($latestAppetizer->price, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="border rounded p-2 text-center text-muted">
                                    <div class="fs-5 opacity-50">🥗</div>
                                    <div class="small">Nessun antipasto</div>
                                </div>
                            @endif
                        </div>

                        {{-- Ultima Pizza --}}
                        <div class="col-md-4">
                            @if($latestPizza)
                                <div class="border rounded p-2 bg-light d-flex align-items-center">
                                    <div class="fs-4 me-2">🍕</div>
                                    <div class="flex-grow-1 min-w-0">
                                        <div class="fw-semibold small text-truncate">{{ $latestPizza->name }}</div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">{{ $latestPizza->created_at->format('d/m') }}</small>
                                            <span class="text-primary fw-bold small">€{{ number_format($latestPizza->price, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="border rounded p-2 text-center text-muted">
                                    <div class="fs-5 opacity-50">🍕</div>
                                    <div class="small">Nessuna pizza</div>
                                </div>
                            @endif
                        </div>

                        {{-- Ultimo Dessert --}}
                        <div class="col-md-4">
                            @if($latestDessert)
                                <div class="border rounded p-2 bg-light d-flex align-items-center">
                                    <div class="fs-4 me-2">🍰</div>
                                    <div class="flex-grow-1 min-w-0">
                                        <div class="fw-semibold small text-truncate">{{ $latestDessert->name }}</div>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">{{ $latestDessert->created_at->format('d/m') }}</small>
                                            <span class="text-warning fw-bold small">€{{ number_format($latestDessert->price, 2) }}</span>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="border rounded p-2 text-center text-muted">
                                    <div class="fs-5 opacity-50">🍰</div>
                                    <div class="small">Nessun dessert</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
