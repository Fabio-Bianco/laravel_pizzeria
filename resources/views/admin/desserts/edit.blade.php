@extends('layouts.app-modern')

@section('title', 'Modifica: ' . $dessert->name)

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <div class="d-flex align-items-center mb-2">
            <a href="{{ route('admin.desserts.index') }}" class="btn btn-outline-secondary btn-sm me-3">
                <i class="fas fa-arrow-left me-1"></i>
                Indietro
            </a>
            <h1 class="page-title mb-0">
                <i class="fas fa-edit text-warning me-2"></i>
                Modifica: {{ $dessert->name }}
            </h1>
        </div>
        <p class="page-subtitle">Aggiorna le informazioni del dessert</p>
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
            <form action="{{ route('admin.desserts.update', $dessert) }}" method="POST" enctype="multipart/form-data" novalidate class="needs-validation">
                @csrf
                @method('PUT')
                
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
                                               value="{{ old('name', $dessert->name) }}" 
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
                                                   value="{{ old('price', $dessert->price) }}" 
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
                                                  placeholder="Descrivi il dessert...">{{ old('description', $dessert->description) }}</textarea>
                                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="image" class="form-label fw-semibold">
                                            <i class="fas fa-image me-1"></i>
                                            Immagine
                                        </label>
                                        @if($dessert->image_path)
                                            <div class="mb-2">
                                                <img src="{{ asset('storage/'.$dessert->image_path) }}" 
                                                     alt="{{ $dessert->name }}" 
                                                     class="img-thumbnail" 
                                                     style="max-height: 80px;">
                                                <div class="form-text">Immagine attuale</div>
                                            </div>
                                        @endif
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
                                                  placeholder="Note aggiuntive...">{{ old('notes', $dessert->notes) }}</textarea>
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
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="is_vegan" name="is_vegan" value="1" 
                                               @checked(old('is_vegan', $dessert->is_vegan))>
                                        <label class="form-check-label fw-semibold" for="is_vegan">
                                            <i class="fas fa-leaf text-success me-1"></i>
                                            Vegano
                                        </label>
                                    </div>
                                    <small class="text-muted">Contrassegna se il dessert è adatto ai vegani</small>
                                </div>
                                    <div class="mb-4">
                                        <div class="form-check form-switch">
                                            <input class="form-check-input" type="checkbox" id="is_gluten_free" name="is_gluten_free" value="1" 
                                                {{ old('is_gluten_free', $dessert->is_gluten_free) ? 'checked' : '' }}>
                                            <label class="form-check-label fw-semibold" for="is_gluten_free">
                                                Senza glutine
                                            </label>
                                        </div>
                                        <small class="text-muted">Contrassegna se il dessert è adatto a chi è intollerante al glutine</small>
                                    </div>

                                {{-- Ingredienti --}}
                                @if(isset($ingredients) && $ingredients->isNotEmpty())
                                <div class="mb-3">
                                    <label for="ingredients" class="form-label fw-semibold mb-3">
                                        <i class="fas fa-list me-1"></i>
                                        Ingredienti Principali
                                    </label>
                                    @php
                                        $selectedIngredients = old('ingredients', $dessert->ingredients->pluck('id')->toArray());
                                    @endphp
                                    <select id="ingredients" name="ingredients[]" multiple 
                                            class="form-select @error('ingredients') is-invalid @enderror" 
                                            data-choices 
                                            placeholder="Cerca e seleziona ingredienti...">
                                        @foreach ($ingredients as $ingredient)
                                            <option value="{{ $ingredient->id }}" 
                                                    @selected(in_array($ingredient->id, $selectedIngredients))>
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

                                {{-- Allergeni attuali --}}
                                @if($dessert->allergens->isNotEmpty())
                                <div class="mt-4 p-3 bg-light rounded">
                                    <h6 class="mb-2">
                                        <i class="fas fa-exclamation-triangle text-warning me-1"></i>
                                        Allergeni Attuali
                                    </h6>
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($dessert->allergens as $allergen)
                                            <span class="badge bg-warning text-dark">{{ $allergen->name }}</span>
                                        @endforeach
                                    </div>
                                    <small class="text-muted d-block mt-2">
                                        Gli allergeni vengono aggiornati automaticamente in base agli ingredienti
                                    </small>
                                </div>
                                @else
                                <div class="mt-4 p-3 bg-light rounded">
                                    <h6 class="mb-2">
                                        <i class="fas fa-exclamation-triangle text-warning me-1"></i>
                                        Allergeni
                                    </h6>
                                    <small class="text-muted">
                                        Gli allergeni verranno calcolati automaticamente in base agli ingredienti selezionati
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
                                        <a href="{{ route('admin.desserts.show', $dessert) }}" class="btn btn-outline-secondary px-4">
                                            <i class="fas fa-times me-2"></i>
                                            Annulla
                                        </a>
                                        <button type="submit" class="btn btn-warning px-4">
                                            <i class="fas fa-save me-2"></i>
                                            Aggiorna Dessert
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