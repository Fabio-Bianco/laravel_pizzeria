@extends('layouts.app-modern')

@section('title', 'Modifica: ' . $ingredient->name)

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <div class="d-flex align-items-center mb-2">
            <a href="{{ route('admin.ingredients.index') }}" class="btn btn-outline-secondary btn-sm me-3">
                <i class="fas fa-arrow-left me-1"></i>
                Indietro
            </a>
            <h1 class="page-title mb-0">
                <i class="fas fa-edit text-success me-2"></i>
                Modifica: {{ $ingredient->name }}
            </h1>
        </div>
        <p class="page-subtitle">Aggiorna le informazioni dell'ingrediente</p>
    </div>
    <div>
        <span class="badge bg-light text-dark fs-6 px-3 py-2">
            <i class="fas fa-seedling me-1"></i>
            Gestione Ingredienti
        </span>
    </div>
</div>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <form action="{{ route('admin.ingredients.update', $ingredient) }}" method="POST" novalidate class="needs-validation">
                @csrf
                @method('PUT')
                
                <div class="row g-4">
                    {{-- Informazioni Base (colonna sinistra) --}}
                    <div class="col-12 col-lg-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white border-bottom">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-info-circle text-success me-2"></i>
                                    Informazioni Base
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="name" class="form-label fw-semibold">
                                            <i class="fas fa-seedling me-1"></i>
                                            Nome Ingrediente <span class="text-danger">*</span>
                                        </label>
                                        <input id="name" name="name" type="text" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               value="{{ old('name', $ingredient->name) }}" 
                                               placeholder="Es. Mozzarella, Pomodoro, Basilico..."
                                               required>
                                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-12">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" value="1" 
                                                   id="is_tomato" name="is_tomato" 
                                                   @checked(old('is_tomato', $ingredient->is_tomato))>
                                            <label class="form-check-label fw-semibold" for="is_tomato">
                                                <i class="fas fa-tomato text-danger me-1"></i>
                                                È un tipo di pomodoro
                                            </label>
                                        </div>
                                        <small class="text-muted">Contrassegna se questo ingrediente è un derivato del pomodoro</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Allergeni (colonna destra) --}}
                    <div class="col-12 col-lg-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white border-bottom">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                    Allergeni Associati
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="mb-3">
                                    <label for="allergens" class="form-label fw-semibold mb-3">
                                        <i class="fas fa-list me-1"></i>
                                        Seleziona allergeni
                                    </label>
                                    <select id="allergens" name="allergens[]" multiple 
                                            class="form-select @error('allergens') is-invalid @enderror" 
                                            data-choices 
                                            placeholder="Cerca e seleziona allergeni...">
                                        @foreach ($allergens as $allergen)
                                            <option value="{{ $allergen->id }}" 
                                                    @selected($ingredient->allergens->pluck('id')->contains($allergen->id))>
                                                {{ $allergen->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('allergens')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Seleziona tutti gli allergeni presenti in questo ingrediente
                                    </div>
                                </div>

                                {{-- Allergeni attuali --}}
                                @if($ingredient->allergens->isNotEmpty())
                                <div class="mt-4 p-3 bg-light rounded">
                                    <h6 class="mb-2">
                                        <i class="fas fa-exclamation-triangle text-warning me-1"></i>
                                        Allergeni Attuali
                                    </h6>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($ingredient->allergens as $allergen)
                                            <span class="badge bg-warning text-dark">{{ $allergen->name }}</span>
                                        @endforeach
                                    </div>
                                </div>
                                @else
                                <div class="mt-4 p-3 bg-light rounded">
                                    <h6 class="mb-2">
                                        <i class="fas fa-check-circle text-success me-1"></i>
                                        Nessun Allergene
                                    </h6>
                                    <small class="text-muted">
                                        Questo ingrediente non contiene allergeni noti
                                    </small>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pulsanti azione --}}
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        I campi contrassegnati con <span class="text-danger">*</span> sono obbligatori
                                    </small>
                                    <div class="d-flex gap-3">
                                        <a href="{{ route('admin.ingredients.index') }}" class="btn btn-outline-secondary px-4">
                                            <i class="fas fa-times me-2"></i>
                                            Annulla
                                        </a>
                                        <button type="submit" class="btn btn-success px-4">
                                            <i class="fas fa-save me-2"></i>
                                            Aggiorna Ingrediente
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
