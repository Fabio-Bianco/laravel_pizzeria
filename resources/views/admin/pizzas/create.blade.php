@extends('layouts.app-modern')

@section('title', 'Nuova Pizza')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <div class="d-flex align-items-center mb-2">
            <a href="{{ route('admin.pizzas.index') }}" class="btn btn-outline-secondary btn-sm me-3">
                <i class="fas fa-arrow-left me-1"></i>
                Indietro
            </a>
            <h1 class="page-title mb-0">
                <i class="fas fa-plus-circle text-success me-2"></i>
                Nuova Pizza
            </h1>
        </div>
        <p class="page-subtitle">Aggiungi una nuova pizza al tuo menu</p>
    </div>
    <div>
        <span class="badge bg-light text-dark fs-6 px-3 py-2">
            <i class="fas fa-list me-1"></i>
            Gestione Menu
        </span>
    </div>
</div>
@endsection

@section('content')

    <div class="row justify-content-center">
        <div class="col-12 col-xl-10">
            <form action="{{ route('admin.pizzas.store') }}" method="POST" enctype="multipart/form-data" novalidate class="needs-validation">
                @csrf
                
                {{-- Informazioni Base --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle text-primary me-2"></i>
                            Informazioni Base
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-12 col-md-8">
                                <label for="name" class="form-label fw-semibold">
                                    <i class="fas fa-pizza-slice me-1"></i>
                                    Nome Pizza <span class="text-danger">*</span>
                                </label>
                                <input id="name" name="name" type="text" 
                                       class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" 
                                       placeholder="Es. Margherita, Marinara, Quattro Stagioni..."
                                       required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12 col-md-4">
                                <label for="price" class="form-label fw-semibold">
                                    <i class="fas fa-euro-sign me-1"></i>
                                    Prezzo <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">€</span>
                                    <input id="price" name="price" type="number" step="0.01" 
                                           class="form-control form-control-lg @error('price') is-invalid @enderror" 
                                           value="{{ old('price') }}" 
                                           placeholder="12.50"
                                           required>
                                </div>
                                @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="category_id" class="form-label fw-semibold">
                                    <i class="fas fa-tags me-1"></i>
                                    Categoria
                                </label>
                                <select id="category_id" name="category_id" 
                                        class="form-select form-select-lg @error('category_id') is-invalid @enderror" 
                                        data-choices>
                                    <option value="">Seleziona categoria...</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}" 
                                                data-is-white="{{ $category->is_white ? '1' : '0' }}" 
                                                @selected(old('category_id') == $category->id)>
                                            {{ $category->name }}
                                            @if($category->is_white) (Pizza Bianca) @endif
                                        </option>
                                    @endforeach
                                </select>
                                @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="image" class="form-label fw-semibold">
                                    <i class="fas fa-image me-1"></i>
                                    Immagine
                                </label>
                                <input id="image" name="image" type="file" 
                                       class="form-control @error('image') is-invalid @enderror" 
                                       accept=".jpg,.jpeg,.png,.webp">
                                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Formati supportati: JPG, PNG, WebP. Dimensione max: 2MB
                                </div>
                            </div>

                            <div class="col-12">
                                <label for="notes" class="form-label fw-semibold">
                                    <i class="fas fa-sticky-note me-1"></i>
                                    Note Aggiuntive
                                </label>
                                <textarea id="notes" name="notes" rows="3" 
                                          class="form-control @error('notes') is-invalid @enderror" 
                                          placeholder="Aggiunte speciali, metodo di cottura, ingredienti particolari...">{{ old('notes') }}</textarea>
                                @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Ingredienti --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-seedling text-success me-2"></i>
                                Ingredienti
                            </h5>
                            <button type="button" class="btn btn-outline-success btn-sm" 
                                    data-bs-toggle="modal" data-bs-target="#newIngredientModal">
                                <i class="fas fa-plus me-1"></i>
                                Nuovo Ingrediente
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <label for="ingredients" class="form-label fw-semibold mb-3">
                            Seleziona gli ingredienti per questa pizza
                        </label>
                        <select id="ingredients" name="ingredients[]" multiple 
                                class="form-select @error('ingredients') is-invalid @enderror" 
                                data-choices 
                                placeholder="Cerca e seleziona ingredienti..." 
                                data-store-url="{{ route('admin.ingredients.store') }}">
                            @foreach ($ingredients as $ingredient)
                                <option value="{{ $ingredient->id }}" 
                                        data-is-tomato="{{ $ingredient->is_tomato ? '1' : '0' }}" 
                                        @selected(collect(old('ingredients',[]))->contains($ingredient->id))>
                                    {{ $ingredient->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('ingredients')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                        <div id="whiteHelp" class="alert alert-warning mt-3 d-none">
                            <i class="fas fa-info-circle me-1"></i>
                            <strong>Pizza Bianca:</strong> Il pomodoro non può essere utilizzato nelle pizze bianche.
                        </div>
                    </div>
                </div>

                {{-- Sistema Allergeni Intelligente --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-warning bg-opacity-10 border-bottom border-warning">
                        <h5 class="card-title mb-0 text-warning-emphasis">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            Sistema Allergeni Intelligente
                        </h5>
                    </div>
                    <div class="card-body">
                        {{-- Allergeni automatici --}}
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-2">
                                <i class="fas fa-robot me-1 text-info"></i>
                                Allergeni Automatici
                            </h6>
                            <p class="text-muted small mb-2">
                                Calcolati automaticamente dagli ingredienti selezionati
                            </p>
                            <div id="automatic-allergens" class="p-3 bg-light border rounded">
                                <em class="text-muted">
                                    <i class="fas fa-arrow-up me-1"></i>
                                    Seleziona ingredienti sopra per vedere gli allergeni automatici
                                </em>
                            </div>
                        </div>

                        {{-- Allergeni manuali --}}
                        <div class="mb-4">
                            <h6 class="fw-semibold mb-2">
                                <i class="fas fa-hand-paper me-1 text-warning"></i>
                                Allergeni Aggiuntivi
                                <small class="text-muted fw-normal">(opzionale)</small>
                            </h6>
                            <p class="text-muted small mb-3">
                                Aggiungi allergeni non rilevati automaticamente o specifici del processo di preparazione
                            </p>
                            <div class="row g-2" id="manual-allergens-container">
                                @foreach($allergens ?? [] as $allergen)
                                    <div class="col-lg-3 col-md-4 col-sm-6">
                                        <div class="form-check form-check-card p-3 border rounded">
                                            <input class="form-check-input" type="checkbox" 
                                                   name="manual_allergens[]" 
                                                   value="{{ $allergen->id }}" 
                                                   id="allergen_{{ $allergen->id }}" 
                                                   @checked(collect(old('manual_allergens',[]))->contains($allergen->id))>
                                            <label class="form-check-label fw-semibold" for="allergen_{{ $allergen->id }}">
                                                {{ $allergen->name }}
                                            </label>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            @error('manual_allergens')<div class="text-danger mt-2">{{ $message }}</div>@enderror
                        </div>

                        {{-- Preview finale --}}
                        <div class="alert alert-info border-info mb-0">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-eye me-2 mt-1"></i>
                                <div>
                                    <strong>Anteprima allergeni per i clienti:</strong>
                                    <div id="final-allergens-preview" class="mt-2">
                                        <em class="text-muted">Nessun allergene</em>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Pulsanti azione --}}
                <div class="row">
                    <div class="col-12">
                        <div class="card border-0 shadow-sm">
                            <div class="card-body">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div class="text-muted">
                                        <small>
                                            <i class="fas fa-info-circle me-1"></i>
                                            I campi contrassegnati con <span class="text-danger">*</span> sono obbligatori
                                        </small>
                                    </div>
                                    <div class="d-flex gap-3">
                                        <a href="{{ route('admin.pizzas.index') }}" class="btn btn-outline-secondary px-4">
                                            <i class="fas fa-times me-2"></i>
                                            Annulla
                                        </a>
                                        <button type="submit" class="btn btn-primary px-4">
                                            <i class="fas fa-save me-2"></i>
                                            Salva Pizza
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

    {{-- Modal nuovo ingrediente --}}
    <div class="modal fade" id="newIngredientModal" tabindex="-1" aria-labelledby="newIngredientModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newIngredientModalLabel">
                        <i class="fas fa-plus-circle text-success me-2"></i>
                        Nuovo Ingrediente
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="ni_name" class="form-label fw-semibold">Nome Ingrediente</label>
                        <input type="text" id="ni_name" class="form-control" placeholder="Es. Mozzarella, Basilico, Prosciutto..." />
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i>
                        Annulla
                    </button>
                    <button type="button" id="ni_save" class="btn btn-success">
                        <i class="fas fa-plus me-1"></i>
                        Crea Ingrediente
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Script per sistema allergeni intelligente --}}
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        const ingredientsSelect = document.getElementById('ingredients');
        const categorySelect = document.getElementById('category_id');
        const automaticAllergensDiv = document.getElementById('automatic-allergens');
        const manualAllergensContainer = document.getElementById('manual-allergens-container');
        const finalAllergensPreview = document.getElementById('final-allergens-preview');
        const whiteHelp = document.getElementById('whiteHelp');
        
        let automaticAllergens = [];
        
        // Gestione categoria bianca
        categorySelect.addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const isWhite = selectedOption?.dataset?.isWhite === '1';
            
            if (isWhite) {
                whiteHelp.classList.remove('d-none');
                
                // Disabilita opzioni pomodoro
                Array.from(ingredientsSelect.options).forEach(option => {
                    if (option.dataset.isTomato === '1') {
                        option.disabled = true;
                        option.selected = false;
                    }
                });
            } else {
                whiteHelp.classList.add('d-none');
                
                // Riabilita opzioni pomodoro
                Array.from(ingredientsSelect.options).forEach(option => {
                    if (option.dataset.isTomato === '1') {
                        option.disabled = false;
                    }
                });
            }
            
            updateAutomaticAllergens();
        });
        
        function updateAutomaticAllergens() {
            const selectedIngredients = Array.from(ingredientsSelect.selectedOptions).map(option => option.value);
            
            if (selectedIngredients.length === 0) {
                automaticAllergens = [];
                automaticAllergensDiv.innerHTML = '<em class="text-muted"><i class="fas fa-arrow-up me-1"></i>Seleziona ingredienti sopra per vedere gli allergeni automatici</em>';
                updateFinalPreview();
                return;
            }
            
            // Loading state
            automaticAllergensDiv.innerHTML = '<div class="d-flex align-items-center text-muted"><div class="spinner-border spinner-border-sm me-2"></div>Caricamento allergeni...</div>';
            
            // Chiamata AJAX per ottenere allergeni
            fetch('{{ route("admin.ajax.ingredients-allergens") }}?' + new URLSearchParams({
                ingredient_ids: selectedIngredients
            }))
            .then(response => response.json())
            .then(data => {
                automaticAllergens = data.allergens || [];
                
                if (automaticAllergens.length === 0) {
                    automaticAllergensDiv.innerHTML = '<div class="text-success"><i class="fas fa-check-circle me-1"></i>Nessun allergene automatico</div>';
                } else {
                    automaticAllergensDiv.innerHTML = automaticAllergens.map(allergen => 
                        `<span class="badge bg-warning text-dark me-1 mb-1">${allergen.name}</span>`
                    ).join('');
                }
                
                updateFinalPreview();
            })
            .catch(error => {
                console.error('Errore nel caricamento allergeni:', error);
                automaticAllergensDiv.innerHTML = '<div class="text-danger"><i class="fas fa-exclamation-triangle me-1"></i>Errore nel caricamento</div>';
            });
        }
        
        function updateFinalPreview() {
            const manualCheckboxes = manualAllergensContainer.querySelectorAll('input[type="checkbox"]:checked');
            const manualAllergens = Array.from(manualCheckboxes).map(cb => ({
                id: cb.value,
                name: cb.nextElementSibling.textContent.trim()
            }));
            
            // Merge automatic + manual, rimuovi duplicati
            const allAllergens = [...automaticAllergens];
            manualAllergens.forEach(manual => {
                if (!allAllergens.find(auto => auto.id == manual.id)) {
                    allAllergens.push(manual);
                }
            });
            
            if (allAllergens.length === 0) {
                finalAllergensPreview.innerHTML = '<em class="text-muted">Nessun allergene</em>';
            } else {
                finalAllergensPreview.innerHTML = allAllergens.map(allergen => 
                    `<span class="badge bg-danger text-white me-1 mb-1">${allergen.name}</span>`
                ).join('');
            }
        }
        
        // Event listeners
        ingredientsSelect.addEventListener('change', updateAutomaticAllergens);
        
        manualAllergensContainer.addEventListener('change', function(e) {
            if (e.target.type === 'checkbox') {
                updateFinalPreview();
            }
        });
        
        // Inizializzazione
        updateAutomaticAllergens();
    });
    </script>

    <style>
    .form-check-card {
        transition: all 0.2s ease;
        cursor: pointer;
    }
    
    .form-check-card:hover {
        background-color: var(--gray-50);
        border-color: var(--primary-color) !important;
    }
    
    .form-check-card:has(.form-check-input:checked) {
        background-color: rgba(255, 107, 53, 0.1);
        border-color: var(--primary-color) !important;
    }
    
    .needs-validation .form-control:invalid {
        border-color: var(--danger-color);
    }
    
    .needs-validation .form-control:valid {
        border-color: var(--success-color);
    }
    </style>
@endsection
