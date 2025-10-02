@extends('layouts.app-modern')

@section('title', 'Nuova Bevanda')

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <div class="d-flex align-items-center mb-2">
            <a href="{{ route('admin.beverages.index') }}" class="btn btn-outline-secondary btn-sm me-3">
                <i class="fas fa-arrow-left me-1"></i>
                Indietro
            </a>
            <h1 class="page-title mb-0">
                <i class="fas fa-plus-circle text-info me-2"></i>
                Nuova Bevanda
            </h1>
        </div>
        <p class="page-subtitle">Aggiungi una nuova bevanda alla tua carta</p>
    </div>
    <div>
        <span class="badge bg-light text-dark fs-6 px-3 py-2">
            <i class="fas fa-glass-water me-1"></i>
            Gestione Menu
        </span>
    </div>
</div>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-xl-8">
            <form action="{{ route('admin.beverages.store') }}" method="POST" enctype="multipart/form-data" novalidate class="needs-validation">
                @csrf
                
                {{-- Informazioni Base --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-info-circle text-info me-2"></i>
                            Informazioni Base
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-12 col-md-8">
                                <label for="name" class="form-label fw-semibold">
                                    <i class="fas fa-glass-water me-1"></i>
                                    Nome Bevanda <span class="text-danger">*</span>
                                </label>
                                <input id="name" name="name" type="text" 
                                       class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                       value="{{ old('name') }}" 
                                       placeholder="Es. Coca Cola, Birra Moretti, Acqua Naturale..."
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
                                           placeholder="3.50"
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
                                          placeholder="Descrivi la bevanda, origine, caratteristiche particolari...">{{ old('description') }}</textarea>
                                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <div class="form-text">
                                    <i class="fas fa-lightbulb me-1"></i>
                                    Aiuta i clienti a conoscere meglio le bevande
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="category" class="form-label fw-semibold">
                                    <i class="fas fa-tags me-1"></i>
                                    Categoria
                                </label>
                                <select id="category" name="category" 
                                        class="form-select @error('category') is-invalid @enderror">
                                    <option value="">Seleziona categoria...</option>
                                    <option value="analcoliche" @selected(old('category') == 'analcoliche')>Analcoliche</option>
                                    <option value="alcoliche" @selected(old('category') == 'alcoliche')>Alcoliche</option>
                                    <option value="birre" @selected(old('category') == 'birre')>Birre</option>
                                    <option value="vini" @selected(old('category') == 'vini')>Vini</option>
                                    <option value="liquori" @selected(old('category') == 'liquori')>Liquori</option>
                                    <option value="caffetteria" @selected(old('category') == 'caffetteria')>Caffetteria</option>
                                </select>
                                @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
                        </div>
                    </div>
                </div>

                {{-- Informazioni Aggiuntive --}}
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header bg-white border-bottom">
                        <h5 class="card-title mb-0">
                            <i class="fas fa-wine-bottle text-warning me-2"></i>
                            Informazioni Aggiuntive
                            <small class="text-muted fw-normal">(opzionale)</small>
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-12 col-md-6">
                                <label for="alcohol_content" class="form-label fw-semibold">
                                    <i class="fas fa-percentage me-1"></i>
                                    Gradazione Alcolica
                                </label>
                                <div class="input-group">
                                    <input id="alcohol_content" name="alcohol_content" type="number" step="0.1" 
                                           class="form-control @error('alcohol_content') is-invalid @enderror" 
                                           value="{{ old('alcohol_content') }}" 
                                           placeholder="5.0">
                                    <span class="input-group-text">% Vol.</span>
                                </div>
                                @error('alcohol_content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                <div class="form-text">Lascia vuoto se analcolica</div>
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="size" class="form-label fw-semibold">
                                    <i class="fas fa-ruler me-1"></i>
                                    Formato
                                </label>
                                <input id="size" name="size" type="text" 
                                       class="form-control @error('size') is-invalid @enderror" 
                                       value="{{ old('size') }}" 
                                       placeholder="Es. 330ml, 0.5L, 75cl...">
                                @error('size')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12">
                                <label for="notes" class="form-label fw-semibold">
                                    <i class="fas fa-sticky-note me-1"></i>
                                    Note Aggiuntive
                                </label>
                                <textarea id="notes" name="notes" rows="3" 
                                          class="form-control @error('notes') is-invalid @enderror" 
                                          placeholder="Temperature di servizio, abbinamenti consigliati, allergeni...">{{ old('notes') }}</textarea>
                                @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
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
                                        <a href="{{ route('admin.beverages.index') }}" class="btn btn-outline-secondary px-4">
                                            <i class="fas fa-times me-2"></i>
                                            Annulla
                                        </a>
                                        <button type="submit" class="btn btn-info px-4">
                                            <i class="fas fa-save me-2"></i>
                                            Salva Bevanda
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
