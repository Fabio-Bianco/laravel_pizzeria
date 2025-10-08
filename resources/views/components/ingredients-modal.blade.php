@props(['item', 'modalId' => 'ingredientsModal', 'itemType' => 'pizza'])

@php
    $ingredients = $item->ingredients ?? collect();
    $ingredientCount = $ingredients->count();
@endphp

{{-- Badge cliccabile ingredienti --}}
@if($ingredientCount > 0)
    <button type="button" 
            class="btn btn-outline-info btn-sm position-relative"
            data-bs-toggle="modal" 
            data-bs-target="#{{ $modalId }}-{{ $item->id }}"
            aria-label="Mostra {{ $ingredientCount }} ingredienti di {{ $item->name }}"
            data-bs-toggle="tooltip"
            title="Clicca per vedere tutti gli ingredienti">
        <i class="fas fa-list-ul me-1" aria-hidden="true"></i>
        <span>{{ $ingredientCount }} ingredient{{ $ingredientCount === 1 ? 'e' : 'i' }}</span>
    </button>

    {{-- Modale accessibile per ingredienti --}}
    <div class="modal fade" 
         id="{{ $modalId }}-{{ $item->id }}" 
         tabindex="-1" 
         aria-labelledby="{{ $modalId }}-{{ $item->id }}-label" 
         aria-hidden="true"
         role="dialog"
         aria-modal="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header bg-light">
                    <h5 class="modal-title fw-bold" id="{{ $modalId }}-{{ $item->id }}-label">
                        <i class="fas fa-list-ul me-2 text-primary" aria-hidden="true"></i>
                        Ingredienti di: {{ $item->name }}
                    </h5>
                    <button type="button" 
                            class="btn-close" 
                            data-bs-dismiss="modal" 
                            aria-label="Chiudi finestra ingredienti"
                            title="Chiudi (ESC)"></button>
                </div>
                <div class="modal-body">
                    @if($ingredients->count() > 0)
                        <div class="row g-3">
                            @foreach($ingredients as $ingredient)
                                <div class="col-md-6 col-lg-4">
                                    <div class="card border-0 bg-light h-100">
                                        <div class="card-body p-3">
                                            <div class="d-flex align-items-center">
                                                <div class="flex-shrink-0 me-3">
                                                    <div class="bg-primary bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" 
                                                         style="width:40px;height:40px;">
                                                        <i class="fas fa-seedling text-primary" aria-hidden="true"></i>
                                                    </div>
                                                </div>
                                                <div class="flex-grow-1">
                                                    <h6 class="mb-1 fw-semibold text-dark">{{ $ingredient->name }}</h6>
                                                    @if(!empty($ingredient->description))
                                                        <small class="text-muted">{{ \Illuminate\Support\Str::limit($ingredient->description, 60) }}</small>
                                                    @endif
                                                </div>
                                            </div>
                                            
                                            {{-- Allergeni dell'ingrediente --}}
                                            @if($ingredient->allergens && $ingredient->allergens->count() > 0)
                                                <div class="mt-2">
                                                    <small class="text-muted d-block mb-1">Allergeni:</small>
                                                    <div class="d-flex flex-wrap gap-1">
                                                        @foreach($ingredient->allergens as $allergen)
                                                            <span class="badge bg-warning bg-opacity-20 text-dark border border-warning">
                                                                {{ $allergen->name }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="mb-3" style="font-size:3rem;opacity:.3;">
                                <i class="fas fa-list-ul"></i>
                            </div>
                            <h6 class="text-muted">Nessun ingrediente specificato</h6>
                            <p class="small text-muted mb-0">Gli ingredienti non sono stati ancora aggiunti a questo {{ $itemType }}.</p>
                        </div>
                    @endif
                </div>
                <div class="modal-footer bg-light">
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <div class="text-muted small">
                            <i class="fas fa-info-circle me-1" aria-hidden="true"></i>
                            Totale: {{ $ingredientCount }} ingredient{{ $ingredientCount === 1 ? 'e' : 'i' }}
                        </div>
                        <button type="button" 
                                class="btn btn-secondary" 
                                data-bs-dismiss="modal"
                                aria-label="Chiudi finestra ingredienti">
                            <i class="fas fa-times me-1" aria-hidden="true"></i> Chiudi
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@else
    {{-- Nessun ingrediente --}}
    <span class="badge bg-light text-muted border" 
          title="Nessun ingrediente specificato"
          aria-label="Nessun ingrediente specificato per {{ $item->name }}">
        <i class="fas fa-minus me-1" aria-hidden="true"></i>
        Nessun ingrediente
    </span>
@endif