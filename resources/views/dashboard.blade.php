@extends('layouts.app-modern')

@section('title', 'Dashboard')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <h1 class="page-title">Dashboard</h1>
        <p class="page-subtitle">Panoramica generale del tuo menu</p>
    </div>
    <div>
        <span class="badge bg-success fs-6 px-3 py-2">
            <i class="fas fa-check-circle me-1"></i>
            Sistema Attivo
        </span>
    </div>
</div>
@endsection

@section('content')

    {{-- Statistiche veloci --}}
    <div class="row g-4 mb-4">
        <div class="col-6 col-lg-3">
            <div class="card border-0 bg-gradient" style="background: linear-gradient(135deg, #FF6B35 0%, #E55A2B 100%);">
                <div class="card-body text-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="h3 mb-0 fw-bold">{{ $countPizzas ?? 0 }}</div>
                            <div class="small opacity-75">Pizze</div>
                        </div>
                        <div class="fs-1 opacity-50">🍕</div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="col-6 col-lg-3">
            <div class="card border-0 bg-gradient" style="background: linear-gradient(135deg, #10B981 0%, #059669 100%);">
                <div class="card-body text-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="h3 mb-0 fw-bold">{{ $countAppetizers ?? 0 }}</div>
                            <div class="small opacity-75">Antipasti</div>
                        </div>
                        <div class="fs-1 opacity-50">🥗</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 bg-gradient" style="background: linear-gradient(135deg, #3B82F6 0%, #1D4ED8 100%);">
                <div class="card-body text-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="h3 mb-0 fw-bold">{{ $countBeverages ?? 0 }}</div>
                            <div class="small opacity-75">Bevande</div>
                        </div>
                        <div class="fs-1 opacity-50">🥤</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg-3">
            <div class="card border-0 bg-gradient" style="background: linear-gradient(135deg, #F59E0B 0%, #D97706 100%);">
                <div class="card-body text-white">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <div class="h3 mb-0 fw-bold">{{ $countIngredients ?? 0 }}</div>
                            <div class="small opacity-75">Ingredienti</div>
                        </div>
                        <div class="fs-1 opacity-50">🥬</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Azioni rapide --}}
    <div class="row g-4 mb-4">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-bolt text-warning me-2"></i>
                        Azioni Rapide
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-4">
                            <a href="{{ route('admin.pizzas.create') }}" class="btn btn-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                <i class="fas fa-plus fs-2 mb-2"></i>
                                <span class="fw-semibold">Nuova Pizza</span>
                                <small class="opacity-75">Aggiungi al menu</small>
                            </a>
                        </div>
                        
                        <div class="col-md-4">
                            <a href="{{ route('admin.appetizers.create') }}" class="btn btn-success w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                <i class="fas fa-plus fs-2 mb-2"></i>
                                <span class="fw-semibold">Nuovo Antipasto</span>
                                <small class="opacity-75">Aggiungi al menu</small>
                            </a>
                        </div>

                        <div class="col-md-4">
                            <a href="{{ route('admin.ingredients.create') }}" class="btn btn-outline-primary w-100 h-100 d-flex flex-column align-items-center justify-content-center py-4">
                                <i class="fas fa-seedling fs-2 mb-2"></i>
                                <span class="fw-semibold">Nuovo Ingrediente</span>
                                <small class="text-muted">Espandi le opzioni</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Menu principale --}}
    <div class="row g-4">
        <div class="col-lg-8">
            <div class="card h-100">
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
                            <a href="{{ route('admin.categories.index') }}" class="card text-decoration-none border-2 h-100" style="border-color: #8B5CF6 !important;">
                                <div class="card-body text-center">
                                    <div class="display-4 mb-2">📂</div>
                                    <h6 class="card-title text-dark">Categorie</h6>
                                    <p class="card-text text-muted">Organizza il menu</p>
                                    <div class="badge bg-light text-dark">{{ $countCategories ?? 0 }} elementi</div>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card h-100">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-cog text-secondary me-2"></i>
                        Configurazione
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-3">
                        <a href="{{ route('admin.ingredients.index') }}" class="btn btn-outline-secondary d-flex align-items-center justify-content-start">
                            <span class="me-3">🥬</span>
                            <div class="text-start">
                                <div class="fw-semibold">Ingredienti</div>
                                <small class="text-muted">{{ $countIngredients ?? 0 }} disponibili</small>
                            </div>
                        </a>

                        <a href="{{ route('admin.allergens.index') }}" class="btn btn-outline-warning d-flex align-items-center justify-content-start">
                            <span class="me-3">⚠️</span>
                            <div class="text-start">
                                <div class="fw-semibold">Allergeni</div>
                                <small class="text-muted">{{ $countAllergens ?? 0 }} configurati</small>
                            </div>
                        </a>

                        <div class="border-top pt-3 mt-2">
                            <h6 class="text-muted small text-uppercase fw-bold mb-2">Sistema</h6>
                            <div class="d-flex align-items-center text-success">
                                <i class="fas fa-circle me-2" style="font-size: 0.5rem;"></i>
                                <small>Allergeni intelligenti attivi</small>
                            </div>
                            <div class="d-flex align-items-center text-success">
                                <i class="fas fa-circle me-2" style="font-size: 0.5rem;"></i>
                                <small>API menu funzionanti</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
