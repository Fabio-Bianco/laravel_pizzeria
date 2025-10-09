@extends('layouts.app-modern')

@section('title', 'Nuovo Dessert')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <div class="d-flex align-items-center mb-2">
            <a href="{{ route('admin.desserts.index') }}" class="btn btn-outline-secondary btn-sm me-3">
                <i class="fas fa-arrow-left me-1"></i>
                Indietro
            </a>
            <h1 class="page-title mb-0">
                <i class="fas fa-plus-circle text-warning me-2"></i>
                Nuovo Dessert
            </h1>
        </div>
        <p class="page-subtitle">Aggiungi un nuovo dessert al tuo menu</p>
    </div>
    <div>
        <span class="badge bg-light text-dark fs-6 px-3 py-2">
            <i class="fas fa-birthday-cake me-1"></i>
            Gestione Menu
        </span>
    </div>
</div>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-12">
            <form action="{{ route('admin.desserts.store') }}" method="POST" enctype="multipart/form-data" novalidate class="needs-validation">
                @csrf
                
                <div class="row g-4">
                    {{-- Informazioni Base (colonna sinistra) --}}
                    <div class="col-12 col-lg-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white border-bottom">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-info-circle text-warning me-2"></i>
                                    Informazioni Base
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="name" class="form-label fw-semibold">
                                            <i class="fas fa-birthday-cake me-1"></i>
                                            Nome Dessert <span class="text-danger">*</span>
                                        </label>
                                        <input id="name" name="name" type="text" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               value="{{ old('name') }}" 
                                               placeholder="Es. Tiramisù, Panna cotta, Gelato..."
                                               required>
                                        @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="price" class="form-label fw-semibold">
                                            <i class="fas fa-euro-sign me-1"></i>
                                            Prezzo <span class="text-danger">*</span>
                                        </label>
                                        <div class="input-group">
                                            <span class="input-group-text">€</span>
                                            <input id="price" name="price" type="number" step="0.01" 
                                                   class="form-control @error('price') is-invalid @enderror" 
                                                   value="{{ old('price') }}" 
                                                   placeholder="6.50"
                                                   required>
                                        </div>
                                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="description" class="form-label fw-semibold">
                                            <i class="fas fa-align-left me-1"></i>
                                            Descrizione
                                        </label>
                                        <textarea id="description" name="description" rows="3" 
                                                  class="form-control @error('description') is-invalid @enderror" 
                                                  placeholder="Descrivi il dessert...">{{ old('description') }}</textarea>
                                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="image" class="form-label fw-semibold">
                                            <i class="fas fa-image me-1"></i>
                                            Immagine
                                        </label>
                                        <input id="image" name="image" type="file" 
                                               class="form-control @error('image') is-invalid @enderror" 
                                               accept=".jpg,.jpeg,.png,.webp">
                                        @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="notes" class="form-label fw-semibold">
                                            <i class="fas fa-sticky-note me-1"></i>
                                            Note
                                        </label>
                                        <textarea id="notes" name="notes" rows="2" 
                                                  class="form-control @error('notes') is-invalid @enderror" 
                                                  placeholder="Note aggiuntive...">{{ old('notes') }}</textarea>
                                        @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Ingredienti e Opzioni (colonna destra) --}}
                    <div class="col-12 col-lg-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white border-bottom">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-seedling text-warning me-2"></i>
                                    Ingredienti e Opzioni
                                </h5>
                            </div>
                            <div class="card-body">
                                {{-- Checkbox Vegano --}}
                                <div class="mb-4">
                                    <div class="form-check form-switch mb-2">
                                        <input class="form-check-input" type="checkbox" id="is_vegan" name="is_vegan" value="1" 
                                               @checked(old('is_vegan', false))>
                                        <label class="form-check-label fw-semibold" for="is_vegan">
                                            <i class="fas fa-leaf text-success me-1"></i>
                                            Vegano
                                        </label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_gluten_free" name="is_gluten_free" value="1" 
                                               @checked(old('is_gluten_free', false))>
                                        <label class="form-check-label fw-semibold" for="is_gluten_free">
                                            Senza glutine
                                        </label>
                                    </div>
                                    <small class="text-muted">Contrassegna se il dessert è adatto ai vegani o a chi è intollerante al glutine</small>
                                </div>

                                {{-- Ingredienti --}}
                                @if(isset($ingredients) && $ingredients->isNotEmpty())
                                <div class="mb-3">
                                    <label for="ingredients" class="form-label fw-semibold mb-3">
                                        <i class="fas fa-list me-1"></i>
                                        Ingredienti Principali
                                    </label>
                                    <select id="ingredients" name="ingredients[]" multiple 
                                            class="form-select @error('ingredients') is-invalid @enderror" 
                                            data-choices 
                                            placeholder="Cerca e seleziona ingredienti...">
                                        @foreach ($ingredients as $ingredient)
                                            <option value="{{ $ingredient->id }}" 
                                                    @selected(collect(old('ingredients',[]))->contains($ingredient->id))>
                                                {{ $ingredient->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('ingredients')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Aiuta a calcolare automaticamente gli allergeni
                                    </div>
                                </div>
                                @endif

                                {{-- Spazio per allergeni calcolati automaticamente --}}
                                <div class="mt-4 p-3 bg-light rounded">
                                    <h6 class="mb-2">
                                        <i class="fas fa-exclamation-triangle text-warning me-1"></i>
                                        Allergeni
                                    </h6>
                                    <small class="text-muted">
                                        Gli allergeni verranno calcolati automaticamente in base agli ingredienti selezionati
                                    </small>
                                </div>
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
                                        <a href="{{ route('admin.desserts.index') }}" class="btn btn-outline-secondary px-4">
                                            <i class="fas fa-times me-2"></i>
                                            Annulla
                                        </a>
                                        <button type="submit" class="btn btn-warning px-4">
                                            <i class="fas fa-save me-2"></i>
                                            Salva Dessert
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