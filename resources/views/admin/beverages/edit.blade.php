@extends('layouts.app-modern')

@section('title', 'Modifica: ' . $beverage->name)

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <div class="d-flex align-items-center mb-2">
            <a href="{{ route('admin.beverages.index') }}" class="btn btn-outline-secondary btn-sm me-3">
                <i class="fas fa-arrow-left me-1"></i>
                Indietro
            </a>
            <h1 class="page-title mb-0">
                <i class="fas fa-edit text-success me-2"></i>
                Modifica: {{ $beverage->name }}
            </h1>
        </div>
        <p class="page-subtitle">Aggiorna le informazioni della bevanda</p>
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
        <div class="col-12">
            <form action="{{ route('admin.beverages.update', $beverage) }}" method="POST" enctype="multipart/form-data" novalidate class="needs-validation">
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
                                            <i class="fas fa-glass-water me-1"></i>
                                            Nome Bevanda <span class="text-danger">*</span>
                                        </label>
                                        <input id="name" name="name" type="text" 
                                               class="form-control @error('name') is-invalid @enderror" 
                                               value="{{ old('name', $beverage->name) }}" 
                                               placeholder="Es. Coca Cola, Birra Moretti..."
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
                                                   value="{{ old('price', $beverage->price) }}" 
                                                   placeholder="3.50"
                                                   required>
                                        </div>
                                        @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="category" class="form-label fw-semibold">
                                            <i class="fas fa-tags me-1"></i>
                                            Categoria
                                        </label>
                                        <select id="category" name="category" 
                                                class="form-select @error('category') is-invalid @enderror">
                                            <option value="">Seleziona categoria...</option>
                                            <option value="analcoliche" @selected(old('category', $beverage->category) == 'analcoliche')>Analcoliche</option>
                                            <option value="alcoliche" @selected(old('category', $beverage->category) == 'alcoliche')>Alcoliche</option>
                                            <option value="birre" @selected(old('category', $beverage->category) == 'birre')>Birre</option>
                                            <option value="vini" @selected(old('category', $beverage->category) == 'vini')>Vini</option>
                                            <option value="liquori" @selected(old('category', $beverage->category) == 'liquori')>Liquori</option>
                                            <option value="caffetteria" @selected(old('category', $beverage->category) == 'caffetteria')>Caffetteria</option>
                                        </select>
                                        @error('category')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="description" class="form-label fw-semibold">
                                            <i class="fas fa-align-left me-1"></i>
                                            Descrizione
                                        </label>
                                        <textarea id="description" name="description" rows="3" 
                                                  class="form-control @error('description') is-invalid @enderror" 
                                                  placeholder="Descrivi la bevanda...">{{ old('description', $beverage->description) }}</textarea>
                                        @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>

                                    <div class="col-12">
                                        <label for="image" class="form-label fw-semibold">
                                            <i class="fas fa-image me-1"></i>
                                            Immagine
                                        </label>
                                        @if($beverage->image_path)
                                            <div class="mb-2">
                                                <img src="{{ asset('storage/'.$beverage->image_path) }}" 
                                                     alt="{{ $beverage->name }}" 
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
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Informazioni Aggiuntive (colonna destra) --}}
                    <div class="col-12 col-lg-6">
                        <div class="card border-0 shadow-sm h-100">
                            <div class="card-header bg-white border-bottom">
                                <h5 class="card-title mb-0">
                                    <i class="fas fa-wine-bottle text-warning me-2"></i>
                                    Informazioni Aggiuntive
                                </h5>
                            </div>
                            <div class="card-body">
                                <div class="row g-3">
                                    <div class="col-12">
                                        <label for="alcohol_content" class="form-label fw-semibold">
                                            <i class="fas fa-percentage me-1"></i>
                                            Gradazione Alcolica
                                        </label>
                                        <div class="input-group">
                                            <input id="alcohol_content" name="alcohol_content" type="number" step="0.1" 
                                                   class="form-control @error('alcohol_content') is-invalid @enderror" 
                                                   value="{{ old('alcohol_content', $beverage->alcohol_content) }}" 
                                                   placeholder="5.0">
                                            <span class="input-group-text">% Vol.</span>
                                        </div>
                                        @error('alcohol_content')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                        <div class="form-text">Lascia vuoto se analcolica</div>
                                    </div>

                                    <div class="col-12">
                                        <label for="size" class="form-label fw-semibold">
                                            <i class="fas fa-ruler me-1"></i>
                                            Formato
                                        </label>
                                        <input id="size" name="size" type="text" 
                                               class="form-control @error('size') is-invalid @enderror" 
                                               value="{{ old('size', $beverage->size) }}" 
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
                                                  placeholder="Temperature di servizio, abbinamenti...">{{ old('notes', $beverage->notes) }}</textarea>
                                        @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                    </div>
                                    <div class="form-check form-switch mt-3">
                                        <input class="form-check-input" type="checkbox" role="switch" 
                                               id="is_gluten_free" name="is_gluten_free" value="1"
                                               @checked(old('is_gluten_free', $beverage->is_gluten_free))>
                                        <label class="form-check-label fw-semibold text-dark" for="is_gluten_free">
                                            <i class="fas fa-bread-slice me-1 text-dark"></i>
                                            <span class="text-dark">Senza Glutine</span>
                                        </label>
                                    </div>
                                    <small class="text-muted">Spunta se la bevanda è senza glutine</small>

                                    {{-- Info categoria attuale --}}
                                    <div class="col-12 mt-4">
                                        <div class="p-3 bg-light rounded">
                                            <h6 class="mb-2">
                                                <i class="fas fa-info-circle text-info me-1"></i>
                                                Categoria Attuale
                                            </h6>
                                            <span class="badge bg-info text-white">
                                                {{ $beverage->category ?? 'Non specificata' }}
                                            </span>
                                        </div>
                                    </div>
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
                                        <a href="{{ route('admin.beverages.index') }}" class="btn btn-outline-secondary px-4">
                                            <i class="fas fa-times me-2"></i>
                                            Annulla
                                        </a>
                                        <button type="submit" class="btn btn-success px-4">
                                            <i class="fas fa-save me-2"></i>
                                            Aggiorna Bevanda
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
