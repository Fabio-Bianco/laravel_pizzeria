<x-app-layout>
  <x-slot name="header">
    <x-page-header :title="'Modifica: '.$pizza->name" :items="[['label'=>'Pizze','url'=>route('admin.pizzas.index')],['label'=>$pizza->name],['label'=>'Modifica']]" :backUrl="route('admin.pizzas.index')" />
  </x-slot>

  @include('partials.flash')

  <div class="row justify-content-center py-3">
    <div class="col-12 col-lg-10 col-xl-8">
      <div class="card shadow-sm">
        <div class="card-header bg-white"><span class="h6 mb-0">Dettagli pizza</span></div>
        <div class="card-body">
          <form action="{{ route('admin.pizzas.update', $pizza) }}" method="POST" enctype="multipart/form-data" novalidate>
            @csrf @method('PUT')

            <div class="row g-3">
              <div class="col-12 col-md-6">
                <label for="name" class="form-label">Nome</label>
                <input id="name" name="name" type="text" class="form-control @error('name') is-invalid @enderror" value="{{ old('name', $pizza->name) }}" required>
                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>

              <div class="col-12 col-md-3">
                <label for="price" class="form-label">Prezzo</label>
                <input id="price" name="price" type="number" step="0.01" class="form-control @error('price') is-invalid @enderror" value="{{ old('price', $pizza->price) }}" required>
                @error('price')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>

              <div class="col-12 col-md-3">
                <label for="category_id" class="form-label">Categoria</label>
                <select id="category_id" name="category_id" class="form-select @error('category_id') is-invalid @enderror" data-choices>
                  <option value="">-</option>
                  @foreach ($categories as $category)
                    <option value="{{ $category->id }}" data-is-white="{{ $category->is_white ? '1' : '0' }}" @selected(old('category_id', $pizza->category_id) == $category->id)>{{ $category->name }}</option>
                  @endforeach
                </select>
                @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>

              <div class="col-12">
                <label for="notes" class="form-label">Note</label>
                <textarea id="notes" name="notes" rows="2" class="form-control @error('notes') is-invalid @enderror" placeholder="Aggiunte speciali, cottura, richiami, ecc.">{{ old('notes', $pizza->notes) }}</textarea>
                @error('notes')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>

              <div class="col-12 col-md-6">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <label for="ingredients" class="form-label mb-0">Ingredienti</label>
                  <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#newIngredientModal">+ Nuovo ingrediente</button>
                </div>
                <select id="ingredients" name="ingredients[]" multiple class="form-select @error('ingredients') is-invalid @enderror" data-choices placeholder="Seleziona ingredienti..." data-store-url="{{ route('admin.ingredients.store') }}">
                  @foreach ($ingredients as $ingredient)
                    <option value="{{ $ingredient->id }}" data-is-tomato="{{ $ingredient->is_tomato ? '1' : '0' }}" @selected($pizza->ingredients->pluck('id')->contains($ingredient->id))>{{ $ingredient->name }}</option>
                  @endforeach
                </select>
                @error('ingredients')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
                <div id="whiteHelp" class="form-text text-warning d-none">Il pomodoro è disabilitato per le pizze bianche.</div>
              </div>

              <div class="col-12 col-md-6">
                <label for="image" class="form-label">Immagine</label>
                <input id="image" name="image" type="file" class="form-control @error('image') is-invalid @enderror" accept=".jpg,.jpeg,.png,.webp">
                @error('image')<div class="invalid-feedback">{{ $message }}</div>@enderror

                @if($pizza->image_path)
                  <div class="mt-2">
                    <img src="{{ asset('storage/'.$pizza->image_path) }}" alt="{{ $pizza->name }}" class="rounded" style="width:120px;height:120px;object-fit:cover;">
                  </div>
                @endif
              </div>

              {{-- Sezione Allergeni Intelligenti --}}
              <div class="col-12">
                <div class="card border-info">
                  <div class="card-header bg-info-subtle">
                    <h6 class="mb-0"><i class="fas fa-exclamation-triangle me-1"></i> Allergeni</h6>
                  </div>
                  <div class="card-body">
                    {{-- Allergeni automatici --}}
                    <div class="mb-3">
                      <label class="form-label fw-bold">Allergeni automatici (da ingredienti)</label>
                      <div id="automatic-allergens" class="border rounded p-2 bg-light">
                        {{-- Sarà popolato via JavaScript --}}
                      </div>
                    </div>

                    {{-- Allergeni manuali --}}
                    <div class="mb-3">
                      <label for="manual_allergens" class="form-label fw-bold">Allergeni aggiuntivi <small class="text-muted">(opzionale)</small></label>
                      <div class="row" id="manual-allergens-container">
                        @foreach($allergens as $allergen)
                          <div class="col-md-4 col-sm-6">
                            <div class="form-check">
                              <input class="form-check-input" type="checkbox" name="manual_allergens[]" value="{{ $allergen->id }}" id="allergen_{{ $allergen->id }}" 
                                @checked(collect(old('manual_allergens', $pizza->manual_allergens ?? []))->contains($allergen->id))>
                              <label class="form-check-label" for="allergen_{{ $allergen->id }}">{{ $allergen->name }}</label>
                            </div>
                          </div>
                        @endforeach
                      </div>
                      @error('manual_allergens')<div class="text-danger mt-1">{{ $message }}</div>@enderror
                    </div>

                    {{-- Preview finale --}}
                    <div class="alert alert-info mb-0">
                      <strong>Allergeni finali che vedranno i clienti:</strong>
                      <div id="final-allergens-preview" class="mt-1">
                        <em class="text-muted">Caricamento...</em>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="d-flex justify-content-end gap-2 mt-4">
              <a href="{{ route('admin.pizzas.index') }}" class="btn btn-outline-secondary">Annulla</a>
              <button type="submit" class="btn btn-primary">Salva</button>
            </div>
          </form>
        </div>
      </div>

      {{-- Modal nuovo ingrediente --}}
      <div class="modal fade" id="newIngredientModal" tabindex="-1" aria-labelledby="newIngredientModalLabel" aria-hidden="true">
        <div class="modal-dialog"><div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="newIngredientModalLabel">Nuovo ingrediente</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Chiudi"></button>
          </div>
          <div class="modal-body">
            <div class="mb-3">
              <label for="ni_name" class="form-label">Nome</label>
              <input type="text" id="ni_name" class="form-control" />
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Annulla</button>
            <button type="button" id="ni_save" class="btn btn-primary">Crea</button>
          </div>
        </div></div>
      </div>
    </div>
  </div>

  {{-- Script per sistema allergeni intelligente --}}
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const ingredientsSelect = document.getElementById('ingredients');
      const automaticAllergensDiv = document.getElementById('automatic-allergens');
      const manualAllergensContainer = document.getElementById('manual-allergens-container');
      const finalAllergensPreview = document.getElementById('final-allergens-preview');
      
      let automaticAllergens = [];
      
      function updateAutomaticAllergens() {
        const selectedIngredients = Array.from(ingredientsSelect.selectedOptions).map(option => option.value);
        
        if (selectedIngredients.length === 0) {
          automaticAllergens = [];
          automaticAllergensDiv.innerHTML = '<em class="text-muted">Seleziona ingredienti per vedere gli allergeni automatici</em>';
          updateFinalPreview();
          return;
        }
        
        fetch('{{ route("admin.ajax.ingredients-allergens") }}?' + new URLSearchParams({
          ingredient_ids: selectedIngredients
        }))
        .then(response => response.json())
        .then(data => {
          automaticAllergens = data.allergens || [];
          
          if (automaticAllergens.length === 0) {
            automaticAllergensDiv.innerHTML = '<em class="text-muted">Nessun allergene automatico</em>';
          } else {
            automaticAllergensDiv.innerHTML = automaticAllergens.map(allergen => 
              `<span class="badge bg-warning text-dark me-1">${allergen.name}</span>`
            ).join('');
          }
          
          updateFinalPreview();
        });
      }
      
      function updateFinalPreview() {
        const manualCheckboxes = manualAllergensContainer.querySelectorAll('input[type="checkbox"]:checked');
        const manualAllergens = Array.from(manualCheckboxes).map(cb => ({
          id: cb.value,
          name: cb.nextElementSibling.textContent
        }));
        
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
            `<span class="badge bg-danger me-1">${allergen.name}</span>`
          ).join('');
        }
      }
      
      ingredientsSelect.addEventListener('change', updateAutomaticAllergens);
      manualAllergensContainer.addEventListener('change', function(e) {
        if (e.target.type === 'checkbox') updateFinalPreview();
      });
      
      // Inizializzazione con dati esistenti
      updateAutomaticAllergens();
    });
  </script>
</x-app-layout>
