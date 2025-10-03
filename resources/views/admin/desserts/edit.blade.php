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
        <div class="col-12 col-xl-8">
            <form action="{{ route('admin.desserts.update', $dessert) }}" method="POST" enctype="multipart/form-data" novalidate class="needs-validation">
                @csrf
                @method('PUT')
                
                {{-- Informazioni Base --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle text-warning me-2"></i>
                            Informazioni Base
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-12 col-md-8">
                                <label for="name" class="form-label fw-semibold">
                                    <i class="fas fa-birthday-cake me-1"></i>
                                    Nome Dessert <span class="text-danger">*</span>
                                </label>
                                <input id="name" name="name" type="text" 
                                       class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $dessert->name) }}" 
                                       placeholder="Es. Tiramisù, Panna cotta, Gelato..."
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
                                <textarea id="description" name="description" rows="4" 
                                          class="form-control @error('description') is-invalid @enderror" 
                                          placeholder="Descrivi il dessert, ingredienti principali, caratteristiche...">{{ old('description', $dessert->description) }}</textarea>
                                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <div class="form-text">
                                    <i class="fas fa-lightbulb me-1"></i>
                                    Una buona descrizione aiuta i clienti a scegliere
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="image" class="form-label fw-semibold">
                                    <i class="fas fa-image me-1"></i>
                                    Immagine
                                </label>
                                @if($dessert->image_path)
                                    <div class="mb-2">
                                        <img src="{{ asset('storage/'.$dessert->image_path) }}" 
                                             alt="{{ $dessert->name }}" 
                                             class="img-thumbnail" 
                                             style="max-height: 100px;">
                                        <div class="form-text">Immagine attuale</div>
                                    </div>
                                @endif
                                <input id="image" name="image" type="file" 
                                       class="form-control @error('image') is-invalid @enderror" 
                                       accept=".jpg,.jpeg,.png,.webp">
                                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <div class="form-text">
                                    <i class="fas fa-info-circle me-1"></i>
                                    Lascia vuoto per mantenere l'immagine attuale. Formati: JPG, PNG, WebP. Max: 2MB
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="notes" class="form-label fw-semibold">
                                    <i class="fas fa-sticky-note me-1"></i>
                                    Note Aggiuntive
                                </label>
                                <textarea id="notes" name="notes" rows="3" 
                                          class="form-control @error('notes') is-invalid @enderror" 
                                          placeholder="Note per la preparazione, allergeni, varianti...">{{ old('notes', $dessert->notes) }}</textarea>
                                @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Ingredienti (se applicabile) --}}
                @if(isset($ingredients) && $ingredients->isNotEmpty())
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-seedling text-warning me-2"></i>
                            Ingredienti
                            <small class="text-muted fw-normal">(opzionale)</small>
                        </h5>
                    </div>
                    <div class="card-body">
                        <label for="ingredients" class="form-label fw-semibold mb-3">
                            Seleziona gli ingredienti principali
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
                </div>
                @endif

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