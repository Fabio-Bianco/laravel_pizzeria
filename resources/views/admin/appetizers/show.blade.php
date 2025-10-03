@extends('layouts.app-modern')

@section('title', $appetizer->name)

@section('header')
<div class="d-flex justify-content-between align-items-center">
    <div>
        <div class="d-flex align-items-center mb-2">
            <a href="{{ route('admin.appetizers.index') }}" class="btn btn-outline-secondary btn-sm me-3">
                <i class="fas fa-arrow-left me-1"></i>
                Indietro
            </a>
            <h1 class="page-title mb-0">
                <i class="fas fa-salad text-success me-2"></i>
                {{ $appetizer->name }}
            </h1>
        </div>
        <p class="page-subtitle">Dettagli dell'antipasto</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.appetizers.edit', $appetizer) }}" class="btn btn-success px-4">
            <i class="fas fa-edit me-2"></i>
            Modifica
        </a>
    </div>
</div>
@endsection

@section('content')
    <div class="row justify-content-center">
        <div class="col-12 col-xl-8">
            {{-- Informazioni principali --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-info-circle text-success me-2"></i>
                        Informazioni Generali
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row g-4">
                        <div class="col-12">
                            <div class="row g-3">
                                <div class="col-12 col-md-6">
                                    <div class="d-flex align-items-center">
                                        <strong class="me-2">Nome:</strong>
                                        <span class="fs-5 fw-bold text-success">{{ $appetizer->name }}</span>
                                    </div>
                                </div>
                                
                                <div class="col-12 col-md-6">
                                    <div class="d-flex align-items-center">
                                        <strong class="me-2">Prezzo:</strong>
                                        <span class="fs-4 fw-bold text-success">€{{ number_format($appetizer->price, 2, ',', '.') }}</span>
                                    </div>
                                </div>

                                @if($appetizer->description)
                                    <div class="col-12">
                                        <strong>Descrizione:</strong>
                                        <div class="mt-2 p-3 bg-light rounded">
                                            {{ $appetizer->description }}
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Azioni --}}
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="text-muted">
                            <small>
                                <i class="fas fa-calendar me-1"></i>
                                Creato il {{ $appetizer->created_at->format('d/m/Y H:i') }}
                                @if($appetizer->updated_at && $appetizer->updated_at != $appetizer->created_at)
                                    • Aggiornato il {{ $appetizer->updated_at->format('d/m/Y H:i') }}
                                @endif
                            </small>
                        </div>
                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.appetizers.index') }}" class="btn btn-outline-secondary px-4">
                                <i class="fas fa-list me-2"></i>
                                Lista Antipasti
                            </a>
                            <a href="{{ route('admin.appetizers.edit', $appetizer) }}" class="btn btn-success px-4">
                                <i class="fas fa-edit me-2"></i>
                                Modifica
                            </a>
                            <form method="POST" action="{{ route('admin.appetizers.destroy', $appetizer) }}" 
                                  data-confirm="Sei sicuro di voler eliminare l'antipasto '{{ $appetizer->name }}'?" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger px-4">
                                    <i class="fas fa-trash me-2"></i>
                                    Elimina
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
