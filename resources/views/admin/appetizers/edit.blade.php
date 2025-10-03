@extends('layouts.app-modern')

@section('title', 'Modifica: ' . $appetizer->name)

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <div class="d-flex align-items-center mb-2">
            <a href="{{ route('admin.appetizers.index') }}" class="btn btn-outline-secondary btn-sm me-3">
                <i class="fas fa-arrow-left me-1"></i>
                Indietro
            </a>
            <h1 class="page-title mb-0">
                <i class="fas fa-edit text-success me-2"></i>
                Modifica: {{ $appetizer->name }}
            </h1>
        </div>
        <p class="page-subtitle">Aggiorna le informazioni dell'antipasto</p>
    </div>
    <div>
        <span class="badge bg-light text-dark fs-6 px-3 py-2">
            <i class="fas fa-salad me-1"></i>
            Gestione Menu
        </span>
    </div>
</div>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-xl-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle text-success me-2"></i>
                        Informazioni Antipasto
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.appetizers.update', $appetizer) }}" method="POST" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="row g-4">
                            <div class="col-12 col-md-6">
                                <label for="name" class="form-label fw-semibold">
                                    <i class="fas fa-salad me-1"></i>
                                    Nome Antipasto <span class="text-danger">*</span>
                                </label>
                                <input id="name" name="name" type="text" 
                                       class="form-control form-control-lg @error('name') is-invalid @enderror" 
                                       value="{{ old('name', $appetizer->name) }}" 
                                       required>
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>

                            <div class="col-12 col-md-6">
                                <label for="price" class="form-label fw-semibold">
                                    <i class="fas fa-euro-sign me-1"></i>
                                    Prezzo <span class="text-danger">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-text">€</span>
                                    <input id="price" name="price" type="number" step="0.01" 
                                           class="form-control form-control-lg @error('price') is-invalid @enderror" 
                                           value="{{ old('price', $appetizer->price) }}" 
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
                                          placeholder="Descrivi l'antipasto...">{{ old('description', $appetizer->description) }}</textarea>
                                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        <div class="d-flex justify-content-between align-items-center">
                            <div class="text-muted">
                                <small>
                                    <i class="fas fa-info-circle me-1"></i>
                                    I campi contrassegnati con <span class="text-danger">*</span> sono obbligatori
                                </small>
                            </div>
                            <div class="d-flex gap-3">
                                <a href="{{ route('admin.appetizers.show', $appetizer) }}" class="btn btn-outline-secondary px-4">
                                    <i class="fas fa-times me-2"></i>
                                    Annulla
                                </a>
                                <button type="submit" class="btn btn-success px-4">
                                    <i class="fas fa-save me-2"></i>
                                    Aggiorna Antipasto
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
