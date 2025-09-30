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
                    <option value="{{ $category->id }}" @selected(old('category_id', $pizza->category_id) == $category->id)>{{ $category->name }}</option>
                  @endforeach
                </select>
                @error('category_id')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>

              <div class="col-12">
                <label for="description" class="form-label">Descrizione</label>
                <textarea id="description" name="description" rows="3" class="form-control @error('description') is-invalid @enderror">{{ old('description', $pizza->description) }}</textarea>
                @error('description')<div class="invalid-feedback">{{ $message }}</div>@enderror
              </div>

              <div class="col-12 col-md-6">
                <div class="d-flex justify-content-between align-items-center mb-1">
                  <label for="ingredients" class="form-label mb-0">Ingredienti</label>
                  <button type="button" class="btn btn-sm btn-outline-primary" data-bs-toggle="modal" data-bs-target="#newIngredientModal">+ Nuovo ingrediente</button>
                </div>
                <select id="ingredients" name="ingredients[]" multiple class="form-select @error('ingredients') is-invalid @enderror" data-choices placeholder="Seleziona ingredienti..." data-store-url="{{ route('admin.ingredients.store') }}">
                  @foreach ($ingredients as $ingredient)
                    <option value="{{ $ingredient->id }}" @selected($pizza->ingredients->pluck('id')->contains($ingredient->id))>{{ $ingredient->name }}</option>
                  @endforeach
                </select>
                @error('ingredients')<div class="invalid-feedback d-block">{{ $message }}</div>@enderror
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
</x-app-layout>
